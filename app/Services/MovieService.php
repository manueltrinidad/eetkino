<?php


namespace App\Services;


use App\Repositories\TMDbRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MovieService
{
    private TMDbRepository $tmdbRepository;
    private UserRepository $userRepository;

    /**
     * MovieService constructor.
     * @param TMDbRepository $tmdbRepository
     * @param UserRepository $userRepository
     */
    public function __construct(TMDbRepository $tmdbRepository, UserRepository $userRepository)
    {
        $this->tmdbRepository = $tmdbRepository;
        $this->userRepository = $userRepository;
    }

    public function search(Request $request)
    {
        try {
            $rules = [
                'api_key' => 'required|exists:users,api_key',
                'q' => 'required|string|max:100'
            ];
            $validated = Validator::make($request->all(), $rules)->validate();
            return response($this->tmdbRepository->searchMovie($validated['q']));
        } catch (ValidationException $e) {
            if(isset($e->errors()['api_key'])) {
                return response(['errors' => ['Unauthorized']], 401);
            }
            return response(['errors' => $e->errors()], 400);
        }

    }
}
