<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreReviewRequest;
use App\Repositories\FilmRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\TmdbRepository;
use App\Repositories\UserRepository;
use App\Services\FilmService;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    private $tmdbRepository;
    private $filmRepository;
    private $reviewRepository;
    private $userRepository;

    public function __construct(TmdbRepository $tmdbRepository, FilmRepository $filmRepository,
                                ReviewRepository $reviewRepository, UserRepository $userRepository)
    {
        $this->tmdbRepository = $tmdbRepository;
        $this->filmRepository = $filmRepository;
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
    }

    public function store(StoreReviewRequest $request, FilmService $filmService, ReviewService $reviewService)
    {
        $attr = $request->validated();
        if(!$this->filmRepository->getFilmById($attr['tmdb_id']))
        {
            $tmdbFilm = $this->tmdbRepository->getFilmById($attr['tmdb_id']);
            if(!$tmdbFilm) {
                return response("Film ID doesn't exist in TMDb", 400);
            }

            if(!$filmService->storeFilmAndPeople($tmdbFilm)) {
                return response("Error in the server.", 500);
            }
        }

        $film = $this->filmRepository->getFilmWithPeopleById($attr['tmdb_id']);
        $user = $this->userRepository->getUserByChatId($attr['chat_id']);

        if($this->reviewRepository->getReviewByUserAndFilmId($user->id, $film->id)) {
            return response("User review for this movie already exists.", 400);
        }

        if(!$reviewService->store($attr, $user->id, $film->id)) {
            return response("Error in the server.", 500);
        }

        return $this->reviewRepository->getReviewByUserAndFilmId($user->id, $film->id);
    }
}
