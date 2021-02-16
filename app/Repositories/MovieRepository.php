<?php


namespace App\Repositories;


use App\Models\Country;
use App\Models\Movie;
use App\Models\Person;
use App\Services\TMDbService;
use App\Traits\GetModelPropertiesTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieRepository
{
    use GetModelPropertiesTrait;

    private PersonRepository $personRepository;
    private CountryRepository $countryRepository;
    private TMDbService $tmdbService;

    /**
     * MovieRepository constructor.
     * @param PersonRepository $personRepository
     * @param CountryRepository $countryRepository
     * @param TMDbService $tmdbService
     */
    public function __construct(PersonRepository $personRepository, CountryRepository $countryRepository,
                                TMDbService $tmdbService)
    {
        $this->personRepository = $personRepository;
        $this->countryRepository = $countryRepository;
        $this->tmdbService = $tmdbService;
    }

    /**
     * Gets a Movie from the Database. Creates it if it doesn't exist. Must use TMDb Id.
     * @param string $tmdbId
     * @return array|null
     */
    public function findOrCreate(string $tmdbId): ?array
    {
        $movie = $this->getMovie('tmdb_id', $tmdbId);
        if ($movie) {
            return $movie;
        } else {
            return $this->createMovie($tmdbId);
        }
    }

    /**
     * Gets a Movie from the Database. Returns null upon failure.
     * @param string $key id or tmdb_id
     * @param string $value Value of the key
     * @return array|null
     */
    public function getMovie(string $key, string $value): ?array
    {
        try {
            return Movie::with(['people', 'countries'])->where($key, '=', $value)->firstOrFail()->toArray();
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Creates a Movie with People / Countries given a TMDb Id.
     * @param string $tmdbId
     * @return array|null
     */
    public function createMovie(string $tmdbId): ?array
    {
        $tmdbMovie = $this->tmdbService->getMovieOrNull($tmdbId);

        if (!$tmdbMovie) {
            return null;
        }

        $movie = Movie::create($tmdbMovie['movie']);
        $this->attachPeopleToMovie($tmdbMovie['people'], $movie);
        $this->attachCountriesToMovie($tmdbMovie['countries'], $movie);
        return $this->getMovie('id', $movie->id);
    }

    /**
     * Attach Cast and Crew retrieved from TMDb Service. Will attempt to create
     * new people if the Person doesn't exist.
     * @param array $peopleInput
     * @param Movie $movie
     */
    private function attachPeopleToMovie(array $peopleInput, Movie $movie)
    {
        $people = [];
        $pivot = [];
        foreach ($peopleInput as $person) {
            $people[] = Person::firstOrCreate($person['data']);
            $pivot[] = $person['movie'];
        }
        $movie->people()->saveMany($people, $pivot);
    }

    /**
     * Attach Countries retrieved from TMDb Service. Will attempt to create a new Country if
     * it doesn't exist.
     * @param array $countriesInput
     * @param Movie $movie
     */
    public function attachCountriesToMovie(array $countriesInput, Movie $movie)
    {
        $countries = [];
        foreach ($countriesInput as $country) {
            $countries[] = Country::firstOrCreate($country);
        }
        $movie->countries()->saveMany($countries);
    }

}
