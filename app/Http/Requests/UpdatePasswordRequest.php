<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class UpdatePasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }



    public function rules(): array
    {
        return [

            'current_password' => [

                'required',

                'current_password',

            ],



            'password' => [

                'required',

                'string',

                'confirmed',

                Password::min(10)

                    ->mixedCase()

                    ->letters()

                    ->numbers()

                    ->symbols()

                    ->uncompromised(),

            ],

        ];
    }



    public function messages(): array
    {
        return [

            'current_password.current_password' =>
                'Your current password is incorrect.',


            'password.confirmed' =>
                'New password confirmation does not match.',

        ];
    }

}