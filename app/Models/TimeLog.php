<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeLog extends Model
{
    use HasFactory;


    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'task_id',

        'user_id',

        'minutes',

        'logged_at',

        'note',

    ];


    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [

            'logged_at' => 'datetime',

            'minutes' => 'integer',

        ];
    }


    /**
     * TimeLog belongs to Task
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    /**
     * TimeLog belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}