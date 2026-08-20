<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }


    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            |
            | Admin:
            | - Can select any client.
            |
            | Manager:
            | - Can select only clients created by themselves.
            |
            */

            'client_id' => [
                'bail',
                'required',
                'integer',
                'exists:clients,id',

                function ($attribute, $value, $fail) {

                    /*
                    |--------------------------------------------------------------------------
                    | Admin
                    |--------------------------------------------------------------------------
                    */

                    if (auth()->user()->role === 'Admin') {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Manager
                    |--------------------------------------------------------------------------
                    */

                    if (auth()->user()->role === 'Manager') {

                        $belongsToManager = Client::where(
                            'id',
                            $value
                        )
                        ->where(
                            'created_by',
                            auth()->id()
                        )
                        ->exists();


                        if (!$belongsToManager) {

                            $fail(
                                'Selected client does not belong to you.'
                            );

                        }

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Other Roles
                    |--------------------------------------------------------------------------
                    */

                    $fail(
                        'You are not authorized to select this client.'
                    );
                },
            ],


            /*
            |--------------------------------------------------------------------------
            | Project Name
            |--------------------------------------------------------------------------
            */

            'name' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-z0-9\s\.\'-]+$/',
            ],


            /*
            |--------------------------------------------------------------------------
            | Project Status
            |--------------------------------------------------------------------------
            */

            'status' => [
                'bail',
                'required',
                Rule::in([
                    'Pending',
                    'In Progress',
                    'Completed',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Start Date
            |--------------------------------------------------------------------------
            */

            'start_date' => [
                'bail',
                'required',
                'date',
            ],


            /*
            |--------------------------------------------------------------------------
            | Due Date
            |--------------------------------------------------------------------------
            */

            'due_date' => [
                'bail',
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


            /*
            |--------------------------------------------------------------------------
            | Individual Members
            |--------------------------------------------------------------------------
            |
            | Only users with the Member role can be assigned
            | to a project.
            |
            */

            'member_ids.*' => [
                'bail',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'Member'),
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
            | Client Messages
            |--------------------------------------------------------------------------
            */

            'client_id.required' =>
                'Please select a client.',

            'client_id.integer' =>
                'Invalid client selected.',

            'client_id.exists' =>
                'Selected client does not exist.',


            /*
            |--------------------------------------------------------------------------
            | Project Name Messages
            |--------------------------------------------------------------------------
            */

            'name.required' =>
                'Project name is required.',

            'name.min' =>
                'Project name must be at least 3 characters.',

            'name.max' =>
                'Project name may not be greater than 100 characters.',

            'name.regex' =>
                'Project name contains invalid characters.',


            /*
            |--------------------------------------------------------------------------
            | Status Messages
            |--------------------------------------------------------------------------
            */

            'status.required' =>
                'Please select project status.',

            'status.in' =>
                'Invalid project status selected.',


            /*
            |--------------------------------------------------------------------------
            | Start Date Messages
            |--------------------------------------------------------------------------
            */

            'start_date.required' =>
                'Start date is required.',

            'start_date.date' =>
                'Start date must be a valid date.',


            /*
            |--------------------------------------------------------------------------
            | Due Date Messages
            |--------------------------------------------------------------------------
            */

            'due_date.required' =>
                'Due date is required.',

            'due_date.date' =>
                'Due date must be a valid date.',

            'due_date.after_or_equal' =>
                'Due date must be after or equal to the start date.',


            /*
            |--------------------------------------------------------------------------
            | Member Messages
            |--------------------------------------------------------------------------
            */

            'member_ids.array' =>
                'Invalid members selection.',

            'member_ids.*.integer' =>
                'Invalid member selected.',

            'member_ids.*.exists' =>
                'One or more selected members are invalid.',
        ];
    }
}