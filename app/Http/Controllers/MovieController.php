<?php


namespace App\Http\Controllers;


use App\Services\MovieService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class MovieController extends Controller
{
    protected MovieService $movieService;

    /**
     * MovieController constructor.
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function search(Request $request)
    {
        return $this->movieService->search($request);
    }

}
