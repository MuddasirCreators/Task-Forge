<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'client_id',

        'name',

        'status',

        'start_date',

        'due_date',

        'archived_at',

        'created_by',

    ];

    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [

            'start_date' => 'date',

            'due_date' => 'date',

            'archived_at' => 'datetime',

        ];
    }

    /**
     * Project belongs to a Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Project belongs to the User who created it
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Project has many Tasks
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Members assigned to this Project
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withTimestamps();
    }
}