<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;



class RegisterUserRequest extends FormRequest
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


            /*
            |--------------------------------------------------------------------------
            | User Name
            |--------------------------------------------------------------------------
            */

            'name' => [

                'bail',

                'required',

                'string',

                'min:3',

                'max:25',

                'regex:/^[A-Za-z\s]+$/',

            ],




            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */

            'email' => [

                'bail',

                'required',

                'string',

                'email',

                'lowercase',

                'max:50',

                'unique:users,email',

            ],





            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            'password' => [

                'bail',

                'required',

                'confirmed',


                Password::min(8)

                    ->letters()

                    ->mixedCase()

                    ->numbers()

                    ->symbols(),

            ],


        ];

    }





    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {

        return [



            /*
            |--------------------------------------------------------------------------
            | Name Messages
            |--------------------------------------------------------------------------
            */

            'name.required' => 
                'Full name is required.',


            'name.min' => 
                'Name must be at least 3 characters.',


            'name.max' => 
                'Name may not be greater than 25 characters.',


            'name.regex' => 
                'Name may contain only letters and spaces.',





            /*
            |--------------------------------------------------------------------------
            | Email Messages
            |--------------------------------------------------------------------------
            */

            'email.required' => 
                'Email address is required.',


            'email.email' => 
                'Please enter a valid email address.',


            'email.max' => 
                'Email may not exceed 50 characters.',


            'email.unique' => 
                'This email is already registered.',





            /*
            |--------------------------------------------------------------------------
            | Password Messages
            |--------------------------------------------------------------------------
            */

            'password.required' => 
                'Password is required.',


            'password.confirmed' => 
                'Password confirmation does not match.',


        ];

    }




    /**
     * Prepare data before validation
     */
    protected function prepareForValidation(): void
    {

        $this->merge([

            'email' => strtolower(
                $this->email
            ),

            'name' => trim(
                $this->name
            ),

        ]);

    }

}