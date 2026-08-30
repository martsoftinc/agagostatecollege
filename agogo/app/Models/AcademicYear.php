<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
        'is_active',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'is_current'  => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class);
    }

    public function assessmentWeights(): HasMany
    {
        return $this->hasMany(AssessmentWeight::class);
    }

    // Helper: Get the current academic year
    public static function current()
    {
        return self::where('is_current', true)->first();
    }
}