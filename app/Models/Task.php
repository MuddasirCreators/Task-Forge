<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;


    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'project_id',

        'title',

        'description',

        'status',

        'priority',

        'assigned_to',

        'due_date',

    ];



    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [

            'due_date' => 'date',

        ];
    }



    /**
     * Task belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(
            Project::class
        );
    }



    /**
     * Task belongs to Assigned User
     */
    public function assignee()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }



    /**
     * Task has many Time Logs
     */
    public function timeLogs()
    {
        return $this->hasMany(
            TimeLog::class
        );
    }



    /**
     * Total Logged Minutes
     *
     * Uses withSum() value when available.
     * Falls back to loaded relationship.
     */
    public function getTotalLoggedMinutesAttribute()
    {

        if (
            isset(
                $this->attributes['time_logs_sum_minutes']
            )
        ) {

            return $this->attributes['time_logs_sum_minutes'];

        }


        return $this->relationLoaded('timeLogs')
            ? $this->timeLogs->sum('minutes')
            : $this->timeLogs()->sum('minutes');

    }
}