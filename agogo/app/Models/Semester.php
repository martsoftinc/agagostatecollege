<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Score;

class Semester extends Model
{
    protected $fillable = [
        'academic_year_id',
        'name',
        'number',
        'start_date',
        'end_date',
        'is_current',
        'is_locked',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
        'is_locked'  => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    // Helper: Get the current semester
    public static function current()
    {
        return self::where('is_current', true)->first();
    }
}