<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exeat extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'destination',
        'reason',
        'departure_at',
        'expected_return_at',
        'actual_return_at',
        'status',
        'logged_by',
        'approved_by',
        'guardian_contact',
        'notes',
    ];

    protected $casts = [
        'departure_at'       => 'datetime',
        'expected_return_at' => 'datetime',
        'actual_return_at'   => 'datetime',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function logger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logged_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helpers
    public function isOverdue(): bool
    {
        return in_array($this->status, ['approved', 'out'])
            && $this->expected_return_at->isPast()
            && is_null($this->actual_return_at);
    }

    public function markAsOut(): void
    {
        $this->update(['status' => 'out']);
    }

    public function markAsReturned(): void
    {
        $this->update([
            'status'           => 'returned',
            'actual_return_at' => now(),
        ]);
    }
}