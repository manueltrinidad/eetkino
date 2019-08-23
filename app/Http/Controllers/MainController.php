<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Review;
use App\Film;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $reviews = Review::where('is_draft', 0)->orderBy('review_date', 'desc')->take(16)->get();
        $drafts = Review::where('is_draft', 1)->orderBy('review_date', 'desc')->take(16)->get();
        return view('index', compact('reviews', 'drafts'));
    }
    public function about()
    {
        return view('about');
    }
    public function stats()
    {
        $reviews = Review::where('is_draft', false)->orderBy('review_date', 'desc')->get();
        return view('stats', compact('reviews'));
    }
    public function search()
    {
        return abort(404);
    }
    public function profile()
    {
        return abort(404);
    }
}
