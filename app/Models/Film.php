<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'tmdb_id', 'title', 'release_date', 'poster_url'
    ];

    public function people()
    {
        return $this->belongsToMany(Person::class)->withPivot('credit');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
