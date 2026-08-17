<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class StoreTimeLogRequest extends FormRequest
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
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'minutes.required' =>
                'Please enter logged minutes.',


            'minutes.integer' =>
                'Minutes must be a valid number.',


            'minutes.min' =>
                'Minimum time log must be 1 minute.',


            'minutes.max' =>
                'Maximum time log entry cannot exceed 600 minutes.',



            'logged_at.required' =>
                'Please select logged date.',


            'logged_at.date' =>
                'Invalid logged date.',



            'note.max' =>
                'Note cannot exceed 500 characters.',


            'note.not_regex' =>
                'HTML tags are not allowed.',

        ];
    }





    /**
     * Additional Business Validation
     * Member can only log time on assigned project tasks
     */
    protected function passedValidation()
    {

        $task = Task::with('project.members')
            ->find($this->route('task')->id);



        if (!$task) {

            throw ValidationException::withMessages([

                'task' =>
                'Task not found.'

            ]);

        }



        $allowed = $task->project
            ->members
            ->contains(
                Auth::id()
            );



        // Admin and Manager bypass
        if (
            Auth::user()->role !== 'Admin'
            &&
            Auth::user()->role !== 'Manager'
            &&
            !$allowed
        ) {


            throw ValidationException::withMessages([

                'minutes' =>
                'You cannot log time for this task.'

            ]);


        }

    }

}