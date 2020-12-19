<?php


namespace App\Services;


use App\Models\Review;
use Illuminate\Database\QueryException;

class ReviewService
{
    public function store($reviewData, $userId, $filmId)
    {
        try {
            Review::create([
                'user_id' => $userId,
                'film_id' => $filmId,
                'comment' => $reviewData['comment'],
                'score' => $reviewData['score'],
                'watch_date' => $reviewData['watch_date']
            ]);
            return True;
        } catch (QueryException $e) {
            return False;
        }
    }
}
