<?php


namespace App\Repositories;


use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewRepository
{
    /**
     * Creates a Review. Returns the Review as an array or null upon failure.
     * @param array $reviewData
     * @return array|null
     */
    public function create(array $reviewData): ?array
    {
        try {
            $review = new Review($reviewData['data']);
            $user = User::where('id', '=', $reviewData['fk']['user_id'])->firstOrFail();
            $movie = Movie::where('id', '=', $reviewData['fk']['movie_id'])->firstOrFail();
            $review->user()->associate($user);
            $review->movie()->associate($movie);
            $review->save();
            return $review->toArray();
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Gets all the Reviews from a User providing a key and value to query from.
     * @param string $key id, username, api_key, email
     * @param string $value
     * @param bool $authenticated
     * @return null
     */
    public function getByUser(string $key, string $value, bool $authenticated = false)
    {
        try {
            $user = User::where($key, '=', $value)->firstOrFail();
            if(!$authenticated) {
                return $user->publicReviews->toArray();
            }
            return $user->reviews->toArray();
        } catch (ModelNotFoundException) {
            return null;
        }
    }
}
