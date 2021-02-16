<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

    public function registerUser(Request $request)
    {
        if(!env('USER_REGISTRATION'))
        {
            return response(['errors' => ['Forbidden']], 403);
        }

        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:150',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], status: 400);
        }

        // Could there be a way to do this without the Exception and Guessing parameters...
        try {
            $validated = $validator->validated();
            $validated['password_hash'] = password_hash($validated['password'], PASSWORD_DEFAULT);
            unset($validated['password']);
            $validated['api_key'] = $this->generateApiKey();
            $user = $this->userRepository->registerUser($validated);
            if($user) {
                return response($user, 201);
            } else {
                return response(["errors" => ["There was an error validating your data."]], status: 500);
            }
        } catch (ValidationException) {
            return response(["errors" => ["There was an error validating your data."]], status: 500);
        }
    }

    public function deleteUser(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:150'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], status: 400);
        }
        try {
            $validated = $validator->validated();
            $isUserValid = $this->authenticateUserByEmailPassword($validated['email'], $validated['password']);
            if(isset($isUserValid['errors'])) {
                return response($isUserValid, status: 400);
            }
            if($this->userRepository->deleteByEmail($validated['email'])) {
                return response(status: 204);
            }
            return response(['errors' => ['There was an error processing your request.']], 500);
        } catch (ValidationException) {
            return response(["errors" => ["There was an error validating your data."]], status: 500);
        }
    }

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
     * Authenticate a User by Email and Password. Will return an empty array on success or
     * an array with errors upon failure.
     * @param string $email User's email.
     * @param string $password User's password.
     * @return array Empty array or array with errors.
     */
    private function authenticateUserByEmailPassword(string $email, string $password): array
    {
        $password_hash = $this->userRepository->getUserProperties('email', $email, 'password_hash')['password_hash'];
        if(!$password_hash) {
            return ["errors" => "Email doesn't exist."];
        }

        if(!password_verify($password, $password_hash)) {
            return ["errors" => "Password is incorrect."];
        }

        return [];
    }
}
