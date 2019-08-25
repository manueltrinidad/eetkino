<?php

namespace App\Http\Controllers;

use App\Film;
use App\Name;
use App\Watchlist;
use App\Country;
use App\Http\Requests\SearchBarGetRequest;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function bar(SearchBarGetRequest $request)
    {
        $attributes = $request->validated();
        $films = Film::where('title_english', 'LIKE', '%'.$attributes['query'].'%')->take(5)->get();
        $names = Name::where('name', 'LIKE', '%'.$attributes['query'].'%')->take(5)->get();
        return response()->json(compact('films', 'names'));
    }
    public function name(SearchBarGetRequest $request)
    {
        $attributes = $request->validated();
        $names = Name::where('name', 'LIKE', '%'.$attributes['query'].'%')->take(5)->get();
        return response()->json(compact('names'));
    }
    public function country(SearchBarGetRequest $request)
    {
        $attributes = $request->validated();
        $countries = Country::where('name', 'LIKE', '%'.$attributes['query'].'%')->take(5)->get();
        return response()->json(compact('countries'));
    }
    public function film(SearchBarGetRequest $request)
    {
        $attributes = $request->validated();
        $films = Film::where('title_english', 'LIKE', '%'.$attributes['query'].'%')->take(5)->get();
        return response()->json(compact('films'));
    }
}
