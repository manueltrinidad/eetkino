<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'film_id', 'content', 'review_date',
        'is_draft', 'score'
    ];

    public function film()
    {
        return $this->belongsTo('App\Film');
    }
}
