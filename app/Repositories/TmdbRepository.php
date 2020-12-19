<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Http;

class TmdbRepository
{
    private $tmdb_url = "https://api.themoviedb.org/3";
    private $base_params;

    public function __construct()
    {
        $this->base_params = [
            'api_key' => env('TMDB_API_KEY')
        ];
    }

    public function getFilmById($tmdb_id)
    {
        $params = array_merge($this->base_params, [
            'append_to_response' => 'credits'
        ]);
        $film = Http::get($this->tmdb_url . "/movie/" . $tmdb_id . "&append_to_response=credits", $params);
        if ($film->failed()) {
            return False;
        }

        $crewJobs = ["Director", "Writer", "Screenplay", "Author", "Story", "Novel", "Characters"];
        $cast = array();
        $crew = array();
        $countries = array();

        foreach ($film['credits']['crew'] as $p) {
            if(in_array($p['job'], $crewJobs)) {
                $crewMember = [
                    'full_name' => $p['name'],
                    'tmdb_id' => $p['id'],
                    'photo_url' => $p['profile_path'],
                    'job' => $p['job']
                ];
                array_push($crew, $crewMember);
            }
        }

        $n = 0;
        foreach ($film['credits']['cast'] as $p) {
            // Limit to 20, we don't need all the Cast anyways
            if($n == 20) { break; }
            $castMember = [
                'full_name' => $p['name'],
                'tmdb_id' => $p['id'],
                'photo_url' => $p['profile_path']
            ];
            array_push($cast, $castMember);
            $n++;
        }

        foreach ($film['production_countries'] as $c) {
            $country = [
                'code' => $c['iso_3166_1']
            ];
            array_push($countries, $country);
        }

        return [
            'tmdb_id' => $film['id'],
            'title' => $film['title'],
            'release_date' => $film['release_date'],
            'poster_url' => $film['poster_path'],
            'crew' => $crew,
            'cast' => $cast,
            'countries' => $countries
        ];
    }
}
