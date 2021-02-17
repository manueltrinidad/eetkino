<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


/**
 * Person
 *
 * @mixin Builder
 */
class Person extends Model
{
    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('credit', 'department');
    }
}
