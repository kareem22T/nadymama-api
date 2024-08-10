<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponser;

class UpdateDoctorRequest extends FormRequest
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
            'username' => 'required',
            'description' => 'required|string',
            'photo' => 'nullable|image',
            'specialization_id' => 'required',
            'position_id' => 'required',
            'specialization' => 'nullable',
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
