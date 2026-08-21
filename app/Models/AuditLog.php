<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'description',
    ];


    /**
     * User who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Polymorphic relation
     */
    public function auditable()
    {
        return $this->morphTo();
    }
}