<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class TMDbService
{
    private string $baseUrl = "https://api.themoviedb.org/3/";
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_KEY');
    }

    /**
     * Gets a Movie (array) from TMDb. Returns null upon failure.
     * @param string $tmdbId
     * @return array|null
     */
    public function getMovieOrNull(string $tmdbId): ?array
    {
        $url = $this->baseUrl."movie/{$tmdbId}";
        $response = Http::get($url, [
            'api_key' => $this->apiKey,
            'append_to_response' => 'credits'
        ]);
        if($response->failed())
        {
            return null;
        }
        return $this->serializeMovie($response);
    }

    /**
     * Serialize TMDb response to the Database format as an array.
     * @param $response
     * @return array
     */
    private function serializeMovie($response): array
    {
        $decoded = json_decode($response);
        $movie = [];
        $movieData = [
            'tmdb_id' => $decoded->id,
            'title' => $decoded->title,
            'release_date' => $decoded->release_date
        ];

        if(isset($decoded->poster_path)) {
            $movieData['poster_path'] = $decoded->poster_path;
        }

        if($movieData['title'] != $decoded->original_title) {
            $movieData['title_original'] = $decoded->original_title;
        }

        $movie['movie'] = $movieData;

        $people = [];

        for ($i = 0; $i < env('MAX_CAST'); $i++)
        {
            $actor = $decoded->credits->cast[$i];
            $person = [];
            $person['data'] = [
                'tmdb_id' => $actor->id,
                'full_name' => $actor->name,
                'photo_path' => $actor->profile_path
            ];
            $person['movie'] = [
                'department' => 'Cast',
                'credit' => 'Actor'
            ];
            $people[] = $person;
        }

        foreach ($decoded->credits->crew as $crew)
        {
            if(in_array($crew->job, ['Director']))
            {
                $person = [];
                $person['data'] = [
                    'tmdb_id' => $crew->id,
                    'full_name' => $crew->name,
                    'photo_path' => $crew->profile_path
                ];
                $person['movie'] = [
                    'department' => 'Director',
                    'credit' => $crew->job
                ];
                $people[] = $person;
            } elseif (in_array($crew->job, ['Writer', 'Screenplay', 'Author', 'Story', 'Novel', 'Characters'])) {
                $person = [];
                $person['data'] = [
                    'tmdb_id' => $crew->id,
                    'full_name' => $crew->name,
                    'photo_path' => $crew->profile_path
                ];
                $person['movie'] = [
                    'department' => 'Writer',
                    'credit' => $crew->job
                ];
                $people[] = $person;
            }
        }

        $movie['people'] = $people;

        $countries = [];
        foreach ($decoded->production_countries as $country)
        {
            $countries[] = [
                'id' => $country->iso_3166_1,
                'name' => $country->name
            ];
        }
        $movie['countries'] = $countries;
        return $movie;
    }
}
