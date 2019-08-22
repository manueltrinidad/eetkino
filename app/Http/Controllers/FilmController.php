<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Film;
use App\Name;
use App\Country;
use App\Watchlist;
use App\Http\Requests\FilmStoreRequest;
use App\Http\Requests\FilmEditWatchlistsRequest;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return view('films.index', compact('films'));
    }
    public function show(Film $film)
    {
        $watchlists = Watchlist::all();
        return view('films.show', compact('film', 'watchlists'));
    }
    public function show_json(Film $film)
    {
        return response()->json(compact('film'));
    }
    public function store(FilmStoreRequest $request)
    {
        $v = $request->validated();
        $film = Film::create(['title_english' => $v['title_english'],
        'title_native' => $v['title_native'],
        'release_date' => $v['release_date'],
        'imdb_id' => $v['imdb_id'],
        'film_type' => $v['film_type'],
        'poster_url' => $v['poster_url']
        ]);
        
        $directors = $v['directors'];
        $writers = $v['writers'];
        $countries = $v['countries'];

        $data = Name::find($directors);
        $film->names()->attach($data, ['credit' => 'director']);
        unset($data);
        
        $data = Name::find($writers);
        $film->names()->attach($data, ['credit' => 'writer']);
        unset($data);
        
        $data = Country::find($countries);
        $film->countries()->attach($data);
        unset($data);
        
        // $film->names()->attach([Name::find($directors) => ['credit' => 'director'],
        // Name::find($writers) => ['credit' => 'writer'],
        // Name::find($actors) => ['credit' => 'actor']
        // ]); Maybe this can work???
        
        return back();
        
    }
    public function update(FilmStoreRequest $request, Film $film)
    {
        $attributes = $request->validated();
        $film->update($attributes);
        $film->save();
        
        $directors = explode(',', $attributes['directors']);
        $writers = explode(',', $attributes['writers']);
        $countries = explode(',', $attributes['countries']);
        
        // All that explode part will be eliminated with the
        // HTML / AJAX tags

        // This whole updateExistingPivot isn't working properly
        // It duplicates credits for each repeated id.
        // So if for instance ID 1 is director and writer at start
        // After editing, it will be director twice and not actor
        // Considering you only run the director updateExistingPivot

        // This cleans the film_name table with the film's id.
        // Only needs to be done for tables with a pivot column (?).
        $film->names()->sync([]);
        
        $data = Name::find($directors);
        $film->names()->attach($data, ['credit' => 'director']);
        unset($data);
        
        $data = Name::find($writers);
        $film->names()->attach($data, ['credit' => 'writer']);
        unset($data);
        
        $countries = Country::find($countries);
        $film->countries()->sync($countries);
        return back();
    }
    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('index');
    }
    public function editwatchlists(FilmEditWatchlistsRequest $request, Film $film)
    {
        $attributes = $request->validated();
        $watchlists = Watchlist::find($attributes['watchlists']);
        $film->watchlists()->sync($watchlists);
        return back();
    }
}
