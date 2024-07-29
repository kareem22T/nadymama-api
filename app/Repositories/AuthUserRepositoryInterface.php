<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface AuthUserRepositoryInterface
{
    public function register(array $data);
    public function login(array $data);
    public function getUser($request);
}
