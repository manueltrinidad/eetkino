<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;


/**
 * Movie
 *
 * @mixin Builder
 */
class Movie extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->withPivot('credit', 'department');
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
