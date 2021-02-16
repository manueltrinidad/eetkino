<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('credit', 'department');
    }
}
