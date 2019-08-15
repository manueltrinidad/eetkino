<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function films()
    {
        return $this->belongsToMany('App\Film');
    }
}
