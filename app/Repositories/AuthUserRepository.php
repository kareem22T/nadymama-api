<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthUserRepository implements AuthUserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUser($request)
    {
        return $request->user();
    }

    public function login(array $credentials)
    {
        DB::beginTransaction();

        try {
            $isAuth = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);
            DB::commit();
            return $isAuth;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $user = $this->model->create($data);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
