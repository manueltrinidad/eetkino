<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'imdb_id', 'title_english', 'title_native',
        'release_date', 'poster_url', 'film_type' 
    ];

    public function countries()
    {
        return $this->belongsToMany('App\Country');
    }

    public function names()
    {
        return $this->belongsToMany('App\Name')->withPivot('credit');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function watchlists()
    {
        return $this->belongsToMany('App\Watchlist');
    }
}
