<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponser;

class RegisterUserRequest extends FormRequest
{
    use ApiResponser;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مُسجل بالفعل.',
            'phone.required' => 'حقل الهاتف مطلوب.',
            'phone.unique' => 'الهاتف مُسجل بالفعل.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password_confirmation.required' => 'حقل تأكيد كلمة المرور مطلوب.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));
    }
}
