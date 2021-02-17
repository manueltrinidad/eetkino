<?php


namespace App\Repositories;


use App\Exceptions\Movie\MovieNotFoundException;
use App\Exceptions\Review\ReviewNotCreatedException;
use App\Exceptions\Review\ReviewNotFoundException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewRepository
{
    /**
     * Creates a Review. Returns the Review as an array.
     * @param array $reviewData
     * @return array
     * @throws MovieNotFoundException
     * @throws UserNotFoundException
     * @throws ReviewNotCreatedException
     */
    public function create(array $reviewData): array
    {
        try {
            $review = new Review($reviewData['data']);
            $user = User::where('id', '=', $reviewData['fk']['user_id'])->firstOrFail();
            $movie = Movie::where('id', '=', $reviewData['fk']['movie_id'])->firstOrFail();
            $review->user()->associate($user);
            $review->movie()->associate($movie);
            $review->save();
            if ($review) {
                return $review->toArray();
            }
            throw new ReviewNotCreatedException('The review could not be created.');
        } catch (ModelNotFoundException $e) {
            if (strpos($e->getModel(), 'Movie')) {
                throw new MovieNotFoundException('The Movie does not exist.');
            }
            throw new UserNotFoundException('The User does not exist');
        }
    }

    /**
     * Gets all the Reviews from a User providing a key and value to query from.
     * @param string $key id, username, api_key, email
     * @param string $value
     * @param bool $authenticated
     * @return array
     * @throws UserNotFoundException
     */
    public function getByUser(string $key, string $value, bool $authenticated = false): array
    {
        try {
            $user = User::where($key, '=', $value)->firstOrFail();
            if (!$authenticated) {
                return $user->publicReviews->toArray();
            }
            return $user->reviews->toArray();
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException("The user does not exist.");
        }
    }

    /**
     * Gets a Review by Id as an array.
     * @param int $id
     * @return array
     * @throws ReviewNotFoundException
     */
    public function getById(int $id): array
    {
        try {
            return Review::where('id', '=', $id)->firstOrFail()->toArray();
        } catch (ModelNotFoundException) {
            throw new ReviewNotFoundException('The Review could not be found');
        }
    }

    /**
     * Deletes a Review by Id.
     * @param int $id
     * @throws ReviewNotFoundException
     */
    public function deleteById(int $id)
    {
        try {
            Review::where('id', '=', $id)->firstOrFail()->delete();
        } catch (ModelNotFoundException) {
            throw new ReviewNotFoundException('The Review could not be found');
        }
    }
}
