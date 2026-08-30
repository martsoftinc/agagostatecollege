<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisciplinaryRecord extends Model
{
    protected $fillable = [
        'student_id',
        'incident_date',
        'category',
        'severity',
        'description',
        'action_taken',
        'demerit_points',
        'status',
        'reported_by',
        'notes',
        'resolved_at',
    ];

    protected $casts = [
        'incident_date'  => 'date',
        'resolved_at'    => 'datetime',
        'demerit_points' => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function markResolved(): void
    {
        $this->update([
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);
    }
}