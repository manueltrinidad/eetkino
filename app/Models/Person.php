<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
      'full_name', 'tmdb_id', 'photo_url'
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class)->withPivot('credit');
    }
}
