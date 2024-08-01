<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\AuthUserRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $user->token = $token;

            $data = [
                "isLogin" => $this->userRepository->login($credentials),
                "user" => $user
            ];

            return $data;
        } else {
            $data = [
                "isLogin" => false,
                "user" => null,
            ];

            return $data;
        }
    }

    public function register(array $data)
    {
        return $this->userRepository->register($data);
    }

}
