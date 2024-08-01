<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthUserService;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;

    protected $userService;

    public function __construct(AuthUserService $userService)
    {
        $this->userService = $userService;
    }

    public function user(Request $request)
    {
        $users = $this->userService->getUser($request);
        return $this->successResponse($users);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->register($request->validated());
        $token = $user->createToken('token')->plainTextToken;
        $user->token = $token;
        return $this->successResponse($user, 'User registerd successfully', 201);
    }

    public function login(AuthUserRequest $request)
    {
        return $this->userService->login($request->validated());
        $isLogin = $this->userService->login($request->validated())['isLogin'];
        if ($isLogin) :
            $user = $this->userService->login($request->validated())['user'];

            return $this->successResponse($user, 'Logged in successfully', 200);
        else:
            return $this->errorResponse('Invalid Credentials', 400);
        endif;
    }
}
