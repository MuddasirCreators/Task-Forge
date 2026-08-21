<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdatePhoneRequest extends FormRequest
{

    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }



    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            'phone' => [

                'nullable',

                'string',

                'max:20',

                // Allow only numbers, +, spaces and -
                'regex:/^[0-9+\-\s]+$/'

            ],

        ];
    }



    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [

            'phone.regex' =>
                'Phone number format is invalid.',

            'phone.max' =>
                'Phone number cannot exceed 20 characters.',

        ];
    }

}