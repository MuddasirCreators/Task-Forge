<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;



class DeleteAccountRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [

            'password' => [
                'required',
                'current_password'
            ],

        ];
    }



    protected function failedValidation(
        \Illuminate\Contracts\Validation\Validator $validator
    ) {

        throw new \Illuminate\Validation\ValidationException(
            $validator,
            redirect()
                ->back()
                ->withErrors(
                    $validator,
                    'userDeletion'
                )
        );

    }


}