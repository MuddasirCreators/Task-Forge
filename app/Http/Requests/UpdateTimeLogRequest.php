<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateTimeLogRequest extends FormRequest
{

    /**
     * Authorization
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

            'minutes' => [

                'bail',

                'required',

                'integer',

                'min:1',

                'max:600',

            ],


            'logged_at' => [

                'required',

                'date',

            ],


            'note' => [

                'nullable',

                'string',

                'max:500',

                'not_regex:/<[^>]*>/',

            ],

        ];
    }





    /**
     * Custom Error Messages
     */
    public function messages(): array
    {
        return [

            'minutes.required' =>
                'Please enter logged minutes.',


            'minutes.integer' =>
                'Minutes must be a valid number.',


            'minutes.min' =>
                'Time log must be at least 1 minute.',


            'minutes.max' =>
                'A single time log cannot exceed 600 minutes.',



            'logged_at.required' =>
                'Please select logged date.',


            'logged_at.date' =>
                'Logged date must be valid.',



            'note.max' =>
                'Note cannot exceed 500 characters.',


            'note.not_regex' =>
                'HTML tags are not allowed in notes.',

        ];
    }

}