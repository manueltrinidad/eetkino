<?php


namespace App\Repositories;


use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewRepository
{
    public function getReviewByUserAndFilmId($userId, $filmId)
    {
        try {
            return Review::where('user_id', $userId)->where('film_id', $filmId)->firstorFail();
        } catch (ModelNotFoundException $e) {
            return False;
        }
    }
}
