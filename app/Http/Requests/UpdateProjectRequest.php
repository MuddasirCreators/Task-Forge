<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Client Validation
            |--------------------------------------------------------------------------
            |
            | Admin:
            |   Can select any client.
            |
            | Manager:
            |   Can select only clients created by himself.
            |
            */

            'client_id' => [

                'required',

                Rule::exists('clients', 'id')
                    ->when(
                        auth()->user()->role === 'Manager',
                        function ($rule) {

                            $rule->where(
                                'created_by',
                                auth()->id()
                            );

                        }
                    ),
            ],


            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-z0-9\s\.\'-]+$/',
            ],


            'status' => [
                'required',
                Rule::in([
                    'Pending',
                    'In Progress',
                    'Completed',
                ]),
            ],


            'start_date' => [
                'required',
                'date',
            ],


            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],


            /*
            |--------------------------------------------------------------------------
            | Project Members
            |--------------------------------------------------------------------------
            */

            'member_ids' => [
                'nullable',
                'array',
            ],


            'member_ids.*' => [
                'integer',

                Rule::exists(
                    'users',
                    'id'
                )
                ->where(
                    'role',
                    'Member'
                ),
            ],

        ];
    }


    public function messages(): array
    {
        return [

            'client_id.required' =>
                'Please select a client.',

            'client_id.exists' =>
                'Selected client is invalid or you do not have permission to use it.',


            'name.required' =>
                'Project name is required.',

            'name.min' =>
                'Project name must be at least 3 characters.',

            'name.max' =>
                'Project name may not be greater than 100 characters.',

            'name.regex' =>
                'Project name contains invalid characters.',


            'status.required' =>
                'Please select project status.',

            'status.in' =>
                'Invalid project status selected.',


            'start_date.required' =>
                'Start date is required.',

            'start_date.date' =>
                'Start date must be a valid date.',


            'due_date.required' =>
                'Due date is required.',

            'due_date.date' =>
                'Due date must be a valid date.',

            'due_date.after_or_equal' =>
                'Due date must be after or equal to the start date.',


            'member_ids.array' =>
                'Invalid members selection.',

            'member_ids.*.exists' =>
                'One or more selected members are invalid.',

        ];
    }
}