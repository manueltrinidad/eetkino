<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
