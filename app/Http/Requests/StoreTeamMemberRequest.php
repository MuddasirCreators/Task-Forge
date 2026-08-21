<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name'=>'required|string|max:255',

            'email'=>'required|email|unique:users,email',

            'phone'=>'nullable|string|max:20',

            'role'=>'required|in:Admin,Manager,Member',

            'password'=>'required|confirmed',

        ];
    }

}