<?php


namespace App\Services;


use App\Exceptions\Movie\MovieNotFoundException;
use App\Exceptions\Review\ReviewNotCreatedException;
use App\Exceptions\Review\ReviewNotFoundException;
use App\Exceptions\Review\ReviewNotUpdated;
use App\Exceptions\User\ApiKeyNotFromUserException;
use App\Exceptions\User\UserNotFoundException;
use App\Repositories\MovieRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Rules\RecentWatchDate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

class ReviewService
{
    private ReviewRepository $reviewRepository;
    private UserRepository $userRepository;
    private TMDbService $tmdbService;
    private MovieRepository $movieRepository;

    /**
     * ReviewService constructor.
     * @param ReviewRepository $reviewRepository
     * @param UserRepository $userRepository
     * @param TMDbService $tmdbService
     * @param MovieRepository $movieRepository
     */
    public function __construct(ReviewRepository $reviewRepository, UserRepository $userRepository,
                                TMDbService $tmdbService, MovieRepository $movieRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
        $this->tmdbService = $tmdbService;
        $this->movieRepository = $movieRepository;
    }


    /**
     * Stores and validates a Review. Will attempt to create the movie
     * if it doesn't exist.
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function reviewStore(Request $request): Response|ResponseFactory
    {
        try {

            $rules = [
                'api_key' => 'required|exists:users,api_key',
                'score' => 'required|integer|min:0|max:100',
                'comment' => 'max:10000|string',
                'tmdb_id' => 'required|string|max:20',
                'is_public' => 'boolean',
                'is_draft' => 'boolean',
                'watch_date' => ['required', 'date', new RecentWatchDate()]
            ];
            $validated = Validator::make($request->all(), $rules)->validated();
            $userId = $this->userRepository->getUserProperties('api_key', $validated['api_key'], 'id')['id'];
            $movie = $this->movieRepository->findOrCreate($validated['tmdb_id']);
            unset($validated['api_key']);
            unset($validated['tmdb_id']);
            $reviewData = [
                'data' => $validated,
                'fk' => [
                    'user_id' => $userId,
                    'movie_id' => $movie['id']
                ]
            ];
            return response($this->reviewRepository->create($reviewData), status: 201);

        } catch (ValidationException $e) {
            return response(['errors' => $e->errors()], status: 400);
        } catch (MovieNotFoundException | UserNotFoundException $e) {
            return response(['errors' => [$e->getMessage()]], 404);
        } catch (ReviewNotCreatedException $e) {
            return response(['errors' => [$e->getMessage()]], 500);
        }
    }

    /**
     * Gets all reviews by a User. Excludes drafts. If the Request includes the api key,
     * it will be authenticated. If the
     * @param string $username
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function showByUsername(string $username, Request $request): Response|ResponseFactory
    {
        try {

            $authenticated = false;
            if (isset($request->api_key)) {
                if (!$this->isApiKeyFromUser($request->api_key, 'username', $username)) {
                    throw new ApiKeyNotFromUserException('Unauthorized Access');
                }
                $authenticated = true;
            }
            return response($this->reviewRepository->getByUser('username', $username, $authenticated));

        } catch (ApiKeyNotFromUserException $e) {
            return response(["errors" => [$e->getMessage()]], status: 401);
        } catch (UserNotFoundException $e) {
            return response(['errors' => [$e->getMessage()]], 404);
        }
    }

    /**
     * @param Request $request
     * @param int $reviewId
     * @return Response|ResponseFactory
     */
    public function updateByApiKey(Request $request, int $reviewId)
    {
        try {
            $rules = [
                'api_key' => 'required|exists:users,api_key',
                'review_id' => 'required|exists:reviews,id',
                'score' => 'integer|min:0|max:100',
                'comment' => 'max:10000|string',
                'tmdb_id' => 'string|max:20',
                'is_public' => 'boolean',
                'is_draft' => 'boolean',
                'watch_date' => ['date', new RecentWatchDate()]
            ];
            $inputToValidate = $request->all();
            $inputToValidate['review_id'] = $reviewId;
            $validated = Validator::make($inputToValidate, $rules)->validated();
            if($this->isReviewByUserApiKey($validated['review_id'], $validated['api_key'])) {
                unset($validated['api_key'], $validated['review_id']);
                $this->reviewRepository->updateById($reviewId, $validated);
                return response($this->reviewRepository->getById($reviewId));
            } else throw new ApiKeyNotFromUserException();

        } catch (ValidationException $e) {
            if(isset($e->errors()['api_key'])) {
                return response(['errors' => ['Unauthorized Action']], status: 401);
            }
            return response(['errors' => $e->errors()], status: 400);
        } catch (ReviewNotFoundException) {
            return response(['errors' => ['Review not found']], status: 404);
        } catch (UserNotFoundException | ApiKeyNotFromUserException) {
            return response(['errors' => ['Unauthorized Action']], status: 401);
        } catch (ReviewNotUpdated) {
            return response(['errors' => ['There was an error performing your request.']], status: 500);
        }
    }

    /**
     * @param Request $request
     * @param int $reviewId
     * @return Response|ResponseFactory
     */
    public function deleteByApiKey(Request $request, int $reviewId): Response|ResponseFactory
    {
        try {
            $rules = [
                'api_key' => 'required|exists:users,api_key',
                'review_id' => 'required|exists:reviews,id'
            ];
            $validated = Validator::make([
                'api_key' => $request->api_key,
                'review_id' => $reviewId
            ], $rules)->validated();

            if($this->isReviewByUserApiKey($validated['review_id'], $validated['api_key'])) {
                $this->reviewRepository->deleteById($reviewId);
                return response(status: 204);
            } else throw new ApiKeyNotFromUserException();

        } catch (ValidationException | ReviewNotFoundException | UserNotFoundException) {
            return response(['errors' => ['API Key or Review ID provided are invalid']], status: 400);
        } catch (ApiKeyNotFromUserException) {
            return response(['errors' => ['Unauthorized action']], status: 401);
        }

    }

    /**
     * Tests if the review belongs to the User authenticated by the API Key.
     * @param int $reviewId
     * @param string $apiKey
     * @return bool
     * @throws ReviewNotFoundException
     * @throws UserNotFoundException
     */
    private function isReviewByUserApiKey(int $reviewId, string $apiKey): bool
    {
        try {
            $reviewUserId = $this->reviewRepository->getById($reviewId)['user_id'];
            $userId = $this->userRepository->getUserProperties('api_key', $apiKey, 'id')['id'];
            return $reviewUserId === $userId;
        } catch (ReviewNotFoundException | UserNotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Tests the API key against the User providing a key and value to query it. Returns
     * true / false if it is authenticated.
     * @param string $inputApiKey
     * @param string $key id, username, email, api_key (last one beats the purpose tho)
     * @param string $value value of the key.
     * @return bool|null
     * @throws UserNotFoundException
     */
    private function isApiKeyFromUser(string $inputApiKey, string $key, string $value): ?bool
    {
        try {
            $userApiKey = $this->userRepository->getUserProperties($key, $value, 'api_key')['api_key'];
            return $userApiKey === $inputApiKey;
        } catch (UserNotFoundException $e) {
            throw $e;
        }
    }
}
