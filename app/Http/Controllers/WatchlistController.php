<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watchlist;
use App\Film;
use App\Http\Requests\WatchlistStoreRequest;
use App\Http\Requests\WatchlistEditFilmsRequest;


class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::all();
        return view('watchlists.index', compact('watchlists'));
    }
    public function show(Watchlist $watchlist)
    {
        return view('watchlists.show', compact('watchlist'));
    }
    public function store(WatchlistStoreRequest $request)
    {
        $attributes = $request->validated();
        $watchlist = Watchlist::create($attributes);
        return back();
    }
    public function update(WatchlistStoreRequest $request, Watchlist $watchlist)
    {
        $attributes = $request->validated();
        $watchlist->update($attributes);
        $watchlist->save();
        return back();
    }
    public function destroy(Watchlist $watchlist)
    {
        $watchlist->delete();
        return redirect()->route('index');
    }
    public function editfilms(WatchlistEditFilmsRequest $request, Watchlist $watchlist)
    {
        $attributes = $request->validated();
        $films = Film::find($attributes['films']);
        $watchlist->films()->sync($films);
        return back();
    }
}
