<?php


namespace App\Repositories;


use App\Models\Film;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FilmRepository
{
    public function getFilmById($tmdbId)
    {
        try {
            return Film::where('tmdb_id', $tmdbId)->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return False;
        }
    }

    public function getFilmWithPeopleById($tmdbId)
    {
        try {
            return Film::where('tmdb_id', $tmdbId)
                ->with('people')
                ->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return False;
        }
    }
}
