<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Name;
use App\Http\Requests\NameStoreRequest;

class NameController extends Controller
{
    public function index()
    {
        $names = Name::all();
        return view('names.index', compact('names'));
    }
    public function show(Name $name)
    {
        return view('names.show', compact('name'));
    }
    public function store(NameStoreRequest $request)
    {
        $attributes = $request->validated();
        $name = Name::create($attributes);
        return back();
    }
    public function update(NameStoreRequest $request, Name $name)
    {
        $attributes = $request->validated();
        $name->update($attributes);
        $name->save();
        return back();
    }
    public function destroy(Name $name)
    {
        $name->delete();
        return redirect()->route('index');
    }
}
