<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'body',
        'target_roles',
        'target_classes',
        'target_programmes',
        'send_sms',
        'created_by',
    ];

    protected $casts = [
        'target_roles'      => 'array',
        'target_classes'    => 'array',
        'target_programmes' => 'array',
        'send_sms'          => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}