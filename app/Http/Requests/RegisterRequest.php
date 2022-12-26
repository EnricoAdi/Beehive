<?php

namespace App\Http\Requests;

use App\Rules\RegisterUsernameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => "email|required",
            "password" => "string|required",
            "name" => "string|required",
            "role" => "numeric|required",
            "birthday" => "date|before:18 years ago|required",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Register Gagal',
            'data'      => $validator->errors()
        ]));
    }
    public function messages()
    {
        return [
            "min" => ":Attribute minimal 8 karakter",
            "before" => "Anda harus minimal berusia 18 tahun"
        ];
    }
}
