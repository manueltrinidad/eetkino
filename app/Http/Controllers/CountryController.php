<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Http\Requests\CountryStoreRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('countries.index', compact('countries'));
    }
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }
    public function store(CountryStoreRequest $request)
    {
        $attributes = $request->validated();
        $country = Country::create($attributes);
        return back();
    }
    public function ajax_store(CountryStoreRequest $request)
    {
        $attributes = $request->validated();
        $country = Country::create($attributes);
        return response()->json(compact('country'));
    }
    public function update(CountryStoreRequest $request, Country $country)
    {
        $attributes = $request->validated();
        $country->update($attributes);
        $country->save();
        return back();
    }
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('index');
    }
}
