<?php


namespace App\Services;


use App\Models\Film;
use App\Models\Person;

class FilmService
{
    public function storeFilmAndPeople($data)
    {
        $cast = $data['cast'];
        foreach ($cast as $c) {
            Person::firstOrCreate([
                'full_name' => $c['full_name'],
                'photo_url' => $c['photo_url'],
                'tmdb_id' => $c['tmdb_id']
            ]);
        }
        $crew = $data['crew'];
        foreach ($crew as $c) {
            Person::firstOrCreate([
                'full_name' => $c['full_name'],
                'photo_url' => $c['photo_url'],
                'tmdb_id' => $c['tmdb_id']
            ]);
        }
        $film = Film::firstOrCreate([
            'tmdb_id' => $data['tmdb_id'],
            'title' => $data['title'],
            'release_date' => $data['release_date'],
            'poster_url' => $data['poster_url']
        ]);

        if($film->people()->get()->isEmpty()) {

            foreach ($cast as $c) {
                $p = Person::where('tmdb_id', $c['tmdb_id'])->firstOrFail();
                $film->people()->attach($p->id, ['credit' => 'Acting']);
            }

            foreach ($crew as $c) {
                $p = Person::where('tmdb_id', $c['tmdb_id'])->firstOrFail();
                if($c['job'] == "Director") {
                    $film->people()->attach($p->id, ['credit' => 'Director']);
                } else {
                    $film->people()->attach($p->id, ['credit' => 'Writer']);
                }
            }

        }
        return True;
    }
}
