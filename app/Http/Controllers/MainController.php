<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Review;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $reviews = Review::where('is_draft', 0)->orderBy('review_date', 'desc')->take(16)->get();
        return view('index', compact('reviews', 'id'));
    }
    public function about()
    {
        return view('about');
    }
    public function stats()
    {
        return view('stats');
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
