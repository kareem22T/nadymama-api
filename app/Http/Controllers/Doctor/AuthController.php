<?php

namespace App\Http\Controllers\Doctor;

use App\Traits\DataFormController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use DataFormController;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'please enter your username',
            'password.required' => 'please enter your password',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, null, 'Login failed', [$validator->errors()->first()], []);
        }

        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        if (Auth::guard('doctor')->attempt($credentials)) {
            $user = Auth::guard("doctor")->user();
            if ($user->tokens())
                $user->tokens()->delete();
            $token = $user->createToken('token')->plainTextToken;
            $user->token = $token;
            $user->registered = true;
            return $user;
        }

        return response()->json([
            "code" => 400,
            "message" => "INVALID_PASSWORD",
            "error"=> [
                "message" => "INVALID_PASSWORD"
            ]
        ], 400);
    }

}
