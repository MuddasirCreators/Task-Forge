<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'name' => [

                'required',

                'string',

                'min:2',

                'max:20',

                // Only letters and spaces
                'regex:/^[A-Za-z\s]+$/',

            ],

            'contact_email' => [

                'required',

                'email',

                'max:40',

                'unique:clients,contact_email,' . $this->route('client')->id,

            ],

        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Client name is required.',

            'name.min' => 'Client name must be at least 2 characters.',

            'name.max' => 'Client name may not be greater than 20 characters.',

            'name.regex' => 'Client name can contain only letters and spaces.',

            'contact_email.required' => 'Contact email is required.',

            'contact_email.email' => 'Please enter a valid email address.',

            'contact_email.max' => 'Email may not be greater than 40 characters.',

            'contact_email.unique' => 'This email already exists.',

        ];
    }
}