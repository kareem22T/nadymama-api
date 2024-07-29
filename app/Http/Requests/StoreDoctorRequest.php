<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponser;

class StoreDoctorRequest extends FormRequest
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
            'username' => 'required|unique:doctors,username',
            'password' => 'required',
            'description' => 'required|string',
            'photo' => 'nullable|image',
            'specialization' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'examination_price' => 'required|numeric',
            'special_examination_price' => 'required|numeric',
            'way_of_waiting' => 'required|string|max:255',
            'phones' => 'required|array',
            'phones.*' => 'required|string|max:255'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));
    }
}
