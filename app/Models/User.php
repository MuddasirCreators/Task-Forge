<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomPasswordResetNotification;



class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * Mass Assignable Attributes
     */
    protected $fillable = [

        'name',

        'email',

        'phone',

        'password',

        'role',

        'is_logged_in',

        'is_active',

    ];


    /**
     * Hidden Attributes
     */
    protected $hidden = [

        'password',

        'remember_token',

    ];


    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'is_logged_in' => 'boolean',

            'is_active' => 'boolean',

        ];
    }


    /**
     * Send custom password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(
            new CustomPasswordResetNotification($token)
        );
    }


    /**
     * Projects assigned to this user.
     */
    public function projects()
    {
        return $this->belongsToMany(

            Project::class,

            'project_user',

            'user_id',

            'project_id'

        )->withTimestamps();
    }


    /**
     * Projects created by this user.
     */
    public function createdProjects()
    {
        return $this->hasMany(

            Project::class,

            'created_by'

        );
    }


    /**
     * Clients created by this user.
     */
    public function clients()
    {
        return $this->hasMany(

            Client::class,

            'created_by'

        );
    }


    /**
     * Time Logs created by this user.
     */
    public function timeLogs()
    {
        return $this->hasMany(

            TimeLog::class

        );
    }
}