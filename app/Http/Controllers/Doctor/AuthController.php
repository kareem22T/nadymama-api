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

    public function resetPassword(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'الرجاء إدخال كلمة المرور القديمة',
            'new_password.required' => 'الرجاء إدخال كلمة المرور الجديدة',
            'new_password.min' => 'يجب أن تتكون كلمة المرور الجديدة من 6 أحرف على الأقل',
            'confirm_password.required' => 'الرجاء تأكيد كلمة المرور الجديدة',
            'confirm_password.same' => 'كلمة المرور الجديدة وتأكيد كلمة المرور غير متطابقتين',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return $this->jsondata(false, null, 'Reset password failed', [$validator->errors()->first()], []);
        }

        $user = Auth::guard('doctor')->user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                "code" => 400,
                "message" => "INVALID_OLD_PASSWORD",
                "error"=> [
                    "message" => "كلمة المرور القديمة غير صحيحة"
                ]
            ], 400);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            "code" => 200,
            "message" => "PASSWORD_UPDATED",
            "data" => "تم تحديث كلمة المرور بنجاح"
        ]);
    }

}
