<?php


namespace App\Services;


use App\Exceptions\User\UserNotAuthenticatedException;
use App\Exceptions\User\UserNotDeletedException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotRegisteredException;
use App\Exceptions\UserService\RouteNotEnabledException;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

class UserService
{
    protected UserRepository $userRepository;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registers a User.
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function registerUser(Request $request): Response|ResponseFactory
    {
        try {

            if(!env('USER_REGISTRATION')) {
                throw new RouteNotEnabledException();
            }
            $rules = [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|max:150',
                'username' => 'required|string|max:50|alpha_dash|unique:users,username'
            ];
            $validated = Validator::make($request->all(), $rules)->validated();
            $validated['password_hash'] = password_hash($validated['password'], PASSWORD_DEFAULT);
            $validated['api_key'] = $this->generateApiKey();
            unset($validated['password']);
            $user = $this->userRepository->registerUser($validated);
            return response($user, 201);

        } catch (ValidationException $e) {
            return response(["errors" => $e->errors()], status: 400);
        } catch (RouteNotEnabledException) {
            return response(['errors' => ['Forbidden']], 403);
        } catch (UserNotRegisteredException) {
            return response(['errors' => ['Internal server error']]);
        }
    }

    /**
     * Deletes a User providing username and password.
     * @param Request $request
     * @param string $username
     * @return Response|ResponseFactory
     */
    public function deleteUser(Request $request, string $username): Response|ResponseFactory
    {
        try {

            $rules = [
                'username' => 'required|string|exists:users,username',
                'password' => 'required|string|min:8|max:150'
            ];
            $dataToValidate = $request->all();
            $dataToValidate['username'] = $username;
            $validated = Validator::make($dataToValidate, $rules)->validated();
            if(!$this->authenticateUserByKeyPassword('username', $validated['username'], $validated['password'])) {
                throw new UserNotAuthenticatedException();
            }
            $this->userRepository->deleteByKeyValue('email', $validated['email']);
            return response(status: 204);

        } catch (ValidationException $e) {
            return response(["errors" => $e->errors()], status: 400);
        } catch (UserNotAuthenticatedException | UserNotFoundException) {
            return response(['errors' => ['Unauthorized']], 401);
        } catch (UserNotDeletedException) {
            return response(['errors' => ['Internal server error']], 500);
        }
    }

    /**
     * Gets a User by an API Key
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function getByApiKey(Request $request): Response|ResponseFactory
    {
        try {

            $rules = ['api_key' => 'required|exists:users,api_key'];
            $validated = Validator::make($request->query(), $rules)->validated();
            return response($this->userRepository->getUser('api_key', $validated['api_key']));

        } catch (ValidationException | UserNotFoundException) {
            return response(["errors" => ['Unauthorized']], status: 401);
        }
    }

    /**
     * Get a User's Profile by Username
     * @param string $username
     * @return Response|ResponseFactory
     */
    public function showProfile(string $username): Response|ResponseFactory
    {
        try {

            $rules = ['username' => 'required|exists:users,username'];
            $validated = Validator::make(['username' => $username], $rules)->validated();
            return response($this->userRepository->getUser('username', $validated['username']));

        } catch (ValidationException|UserNotFoundException) {
            return response(["errors" => ['Username not found']], status: 404);
        }
    }

    /**
     * Generates a new API Key for a User authenticated by email and password.
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function newKeyByEmailPassword(Request $request): Response|ResponseFactory
    {
        try {

            $rules = [
                'email' => 'required|exists:users,email',
                'password' => 'required|string'
            ];
            $validated = Validator::make($request->all(), $rules)->validated();
            if($this->authenticateUserByKeyPassword('email', $validated['email'], $validated['password'])) {
                $newKey = $this->generateApiKey();
                $this->userRepository->update('email', $validated['email'], ['api_key' => $newKey]);
                return response($this->userRepository->getUser('email', $validated['email'], withApiKey: true));
            } else throw new UserNotAuthenticatedException();

        } catch (ValidationException | UserNotAuthenticatedException | UserNotFoundException) {
            return response(["errors" => ['Unauthorized']], status: 401);
        }
    }

    /**
     * Generates a unique API Key
     * @return string
     */
    private function generateApiKey(): string
    {
        $apiKey = Str::random(20);
        $validated = Validator::make(['api_key' => $apiKey], ['api_key' => 'unique:users,api_key']);
        if($validated->fails())
        {
            return $this->generateApiKey();
        }
        return $apiKey;
    }

    /**
     * Authenticate a User by Key and Password and returns boolean result.
     * If the User doesn't exist, it returns false.
     * @param string $key
     * @param string $value
     * @param string $password User's password.
     * @return bool
     */
    private function authenticateUserByKeyPassword(string $key, string $value, string $password): bool
    {
        try {
            $password_hash = $this->userRepository->getUserProperties($key, $value, 'password_hash')['password_hash'];
            if(!password_verify($password, $password_hash)) {
                return false;
            }
            return true;
        } catch (UserNotFoundException) {
            return false;
        }
    }
}
