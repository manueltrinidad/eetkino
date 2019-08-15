<?php

namespace App\Http\Controllers;

use App\Review;
use App\Film;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewStoreRequest;

class ReviewController extends Controller
{
    public function show(Review $review)
    {
        $film = Film::where('id', $review->film->id)->first();
        return view('reviews.show', compact('review', 'film'));
    }
    public function store(ReviewStoreRequest $request)
    {
        $attributes = $request->validated();
        $review = Review::create($attributes);
        return redirect()->route('reviews.show', compact('review'));
    }
    public function update(ReviewStoreRequest $request, Review $review)
    {
        $attributes = $request->validated();
        $review->update($attributes);
        $review->save();
        return back();
    }
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('index');
    }
}
