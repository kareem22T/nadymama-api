<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\AuthUserRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class AuthUserService
{
    protected $userRepository;

    public function __construct(AuthUserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser($request)
    {
        return $this->userRepository->getUser($request);
    }

    public function login($credentials)
    {
        $user = User::where("email", $credentials['email'])->first();
        $token = $user->createToken('token')->plainTextToken;
        $user->token = $token;

        $data = [
            "isLogin" => $this->userRepository->login($credentials),
            "user" => $user
        ];

        return $data;
    }

    public function register(array $data)
    {
        return $this->userRepository->register($data);
    }

}
