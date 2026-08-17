<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Attributes
     */
    protected $fillable = [
        'name',
        'contact_email',
        'created_by',
    ];

    /**
     * Client has many Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Client belongs to User (Manager)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}