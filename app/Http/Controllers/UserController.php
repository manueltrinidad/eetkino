<?php


namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        return $this->userService->registerUser($request);
    }

    public function delete(Request $request)
    {
        return $this->userService->deleteUser($request);
    }
}
