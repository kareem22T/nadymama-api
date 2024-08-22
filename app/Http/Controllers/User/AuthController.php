<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthUserService;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SendEmailTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    use ApiResponser, SendEmailTrait;

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
        $isLogin = $this->userService->login($request->validated())['isLogin'];
        if ($isLogin) :
            $user = $this->userService->login($request->validated())['user'];

            return $this->successResponse($user, 'Logged in successfully', 200);
        else:
            return $this->errorResponse('Invalid Credentials', 400);
        endif;
    }

    public function askEmailCode(Request $request) {
        $user = $request->user();

        if ($user) {
            $code = rand(100000, 999999);

            $user->email_last_verfication_code = Hash::make($code);
            $user->email_last_verfication_code_expird_at = Carbon::now()->addMinutes(10)->timezone('Europe/Istanbul');
            $user->save();

            $msg_title = "تفضل رمز تفعيل بريدك الالكتروني";
            $msg_content = "<h1>";
            $msg_content .= "رمز التاكيد هو <span style='color: blue'>" . $code . "</span>";
            $msg_content .= "</h1>";

            $this->sendEmail($user->email, $msg_title, $msg_content);

            return $this->successResponse("تم ارسال رمز التحقق بنجاح عبر الايميل");
        }

        return $this->errorResponse("invalid process", 400);
    }

    public function verifyEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            "code" => ["required"],
        ], [
            "code.required" => "ادخل رمز التاكيد ",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 419);
        }


        $user = $request->user();
        $code = $request->code;

        if ($user) {
            if (!Hash::check($code, $user->email_last_verfication_code ? $user->email_last_verfication_code : Hash::make(0000))) {
                return $this->errorResponse("الرمز غير صحيح", 400);
            } else {
                $timezone = 'Europe/Istanbul'; // Replace with your specific timezone if different
                $verificationTime = new Carbon($user->email_last_verfication_code_expird_at, $timezone);
                if ($verificationTime->isPast()) {
                    return $this->errorResponse("الرمز غير ساري", 400);
                } else {
                    $user->is_email_verified = true;
                    $user->save();
                    $token = $user->createToken('token')->plainTextToken;
                    $user->token = $token;

                    if ($user) {
                        return $this->successResponse($user, "تم تاكيد بريدك الالكتروني بنجاح");
                    }
                }
            }
        }

    }

    public function askEmailCodeForgot(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"],
        ], [
            "email.required" => "من فضلك ادخل بريدك الاكتروني ",
            "email.email" => "من فضلك ادخل بريد الكتروني صالح",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $user = User::where("email", $request->email)->first();

        if ($user) {

            $code = rand(100000, 999999);

            $user->email_last_verfication_code = Hash::make($code);
            $user->email_last_verfication_code_expird_at = Carbon::now()->addMinutes(10)->timezone('Europe/Istanbul');
            $user->save();

            $msg_title = "تفضل رمز تفعيل بريدك الالكتروني";
            $msg_content = "<h1>";
            $msg_content .= "رمز التاكيد هو <span style='color: blue'>" . $code . "</span>";
            $msg_content .= "</h1>";

            $this->sendEmail($user->email, $msg_title, $msg_content);

            return $this->successResponse("", "تم ارسال رمز التحقق بنجاح عبر الايميل");
        } else {
            return $this->errorResponse("هذا الحساب غير مسجل", 400);
        }

        return $this->errorResponse("invalid process", 400);
    }

    public function forgetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"],
            'password' => [
                'required', // Required only if joined_with is 1
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/u',
                'confirmed'
            ],
        ], [
            "email.required" => "من فضلك ادخل بريدك الاكتروني ",
            "email.email" => "من فضلك ادخل بريد الكتروني صالح",
            "password.required" => "ادخل كلمة المرور",
            "password.min" => "يجب ان تكون كلمة المرور من 8 احرف على الاقل",
            "password.regex" => "يجب ان تحتوي كلمة المرور علي حروف وارقام ورموز",
            "password.confirmed" => "كلمة المرور والتاكيد غير متطابقان",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }


        $user = User::where("email", $request->email)->first();
        $code = $request->code;

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            if ($user) {
                return $this->successResponse("", "تم تعين كلمة المرور بنجاح ");
            }
        }
        else {
            return $this->errorResponse("هذا الحساب غير مسجل", 400);
        }

    }

    public function forgetPasswordCheckCode(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"],
            "code" => ["required"],
        ], [
            "code.required" => "ادخل رمز التاكيد ",
            "email.required" => "من فضلك ادخل بريدك الاكتروني ",
            "email.email" => "من فضلك ادخل بريد الكتروني صالح",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }


        $user = User::where("email", $request->email)->first();
        $code = $request->code;

        if ($user) {
            if (!Hash::check($code, $user->email_last_verfication_code ? $user->email_last_verfication_code : Hash::make(0000))) {
                return $this->errorResponse("الرمز غير صحيح", 400);

            } else {
                $timezone = 'Europe/Istanbul'; // Replace with your specific timezone if different
                $verificationTime = new Carbon($user->email_last_verfication_code_expird_at, $timezone);
                if ($verificationTime->isPast()) {
                    return $this->errorResponse("الرمز غير ساري", 400);
                } else {
                    if ($user) {
                        return $this->errorResponse("الرمز صحيح", 400);
                    }
                }
            }
        } else {
            return $this->errorResponse("هذا الحساب غير مسجل", 400);
        }

    }


}
