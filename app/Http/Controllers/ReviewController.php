<?php


namespace App\Http\Controllers;


use App\Services\ReviewService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ReviewController extends Controller
{
    private ReviewService $reviewService;

    /**
     * ReviewController constructor.
     * @param $reviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(Request $request)
    {
        return $this->reviewService->reviewStore($request);
    }

    public function show(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function showByUsername(Request $request, $username)
    {

        return $this->reviewService->showByUsername($username, $request);
    }
}
