<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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

            'project_id' => [
                'bail',
                'required',
                'integer',
                'exists:projects,id',
            ],

            'title' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:100',
                /*
                 |--------------------------------------------------------------
                 | Allows:
                 | Letters
                 | Numbers
                 | Spaces
                 | . , - _ ( )
                 |--------------------------------------------------------------
                 */
                'regex:/^[A-Za-z0-9\s\.\,\-\_\(\)]+$/',
                'not_regex:/<[^>]*>/',
            ],

            'description' => [
                'nullable',
                'string',
                'min:5',
                'max:1000',
                'not_regex:/<[^>]*>/',
            ],

            'status' => [
                'bail',
                'required',
                'in:Todo,In Progress,Done',
            ],

            // ===== ADDED =====
            'priority' => [
                'bail',
                'required',
                'in:High,Medium,Low',
            ],

            // ===== ADDED =====
            'assigned_to' => [
                'bail',
                'required',
                'integer',
                'exists:users,id',
            ],

            'due_date' => [
                'bail',
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }

    /**
     * Custom Validation Messages
     */
    public function messages(): array
    {
        return [

            'project_id.required' => 'Please select a project.',
            'project_id.integer'  => 'Invalid project selected.',
            'project_id.exists'   => 'Selected project does not exist.',

            'title.required'   => 'Task title is required.',
            'title.min'        => 'Task title must be at least 3 characters.',
            'title.max'        => 'Task title may not be greater than 100 characters.',
            'title.regex'      => 'Task title contains invalid characters.',
            'title.not_regex'  => 'HTML tags are not allowed in the task title.',

            'description.min'       => 'Description must be at least 5 characters.',
            'description.max'       => 'Description may not be greater than 1000 characters.',
            'description.not_regex' => 'HTML tags are not allowed in the description.',

            'status.required' => 'Please select task status.',
            'status.in'       => 'Invalid task status selected.',

            'priority.required' => 'Please select a priority.',
            'priority.in'       => 'Invalid priority selected.',

            'assigned_to.required' => 'Please select an assignee.',
            'assigned_to.integer'  => 'Invalid assignee selected.',
            'assigned_to.exists'   => 'Selected assignee does not exist.',

            'due_date.required'       => 'Due date is required.',
            'due_date.date'           => 'Due date must be a valid date.',
            'due_date.after_or_equal' => 'Due date cannot be earlier than today.',
        ];
    }
}