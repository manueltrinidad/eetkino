<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * User
 *
 * @mixin Builder
 */
class User extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var mixed
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var mixed
     */
    protected $hidden = [
        'password_hash', 'api_key', 'created_at', 'updated_at'
    ];

    /**
     * Gets all the reviews from the User excluding drafts.
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_draft', '=', 0);
    }

    /**
     * Gets all the reviews including drafts.
     * @return HasMany
     */
    public function reviewsWithDrafts(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Gets all the drafts from the User.
     * @return HasMany
     */
    public function drafts(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_draft', '=', 1);
    }

    public function publicReviews()
    {
        return $this->hasMany(Review::class)
            ->where('is_public', '=', 1)
            ->where('is_draft', '=', 0);
    }

    public function movies()
    {
        return $this->hasManyThrough(Movie::class, Review::class);
    }
}
