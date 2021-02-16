<?php


namespace App\Services;


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
        $rules = [
            'api_key' => 'required|exists:users,api_key',
            'score' => 'required|integer|min:0|max:100',
            'comment' => 'max:10000|string',
            'tmdb_id' => 'required|string|max:20',
            'is_public' => 'boolean',
            'is_draft' => 'boolean',
            'watch_date' => ['required', 'date', new RecentWatchDate()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], status: 400);
        }

        try {
            $validated = $validator->validated();
            $userId = $this->userRepository->getUserProperties('api_key', $validated['api_key'], 'id')['id'];
            $movie = $this->movieRepository->findOrCreate($validated['tmdb_id']);
            if(!$movie)
            {
                return response(["errors" => ['The Movie Id (TMDb) is invalid.']], status: 400);
            }
            unset($validated['api_key']);
            unset($validated['tmdb_id']);
            $reviewData = [
                'data' => $validated,
                'fk' => [
                    'user_id' => $userId,
                    'movie_id' => $movie['id']
                ]
            ];
            $review = $this->reviewRepository->create($reviewData);
            if($review) {
                return response($review, status: 201);
            } else {
                return response(['errors' => ['There was an error creating your review.']], status: 500);
            }

        } catch (ValidationException) {
            return response(["errors" => ["There was an error validating your data."]], status: 500);
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
        $authenticated = false;
        if($request->api_key) {
            if(!$this->userRepository->isApiKeyFromUser($request->api_key, 'username', $username))
            {
                return response(["errors" => ['The API Key or username is invalid']], status: 400);
            }
            $authenticated = true;
        }
        $reviews = $this->reviewRepository->getByUser('username', $username, $authenticated);
        if($reviews === null)
        {
            return response(["errors" => ["The username doesn't exist"]], status: 404);
        }
        return response($reviews);
    }
}
