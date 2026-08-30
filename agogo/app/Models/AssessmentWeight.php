<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentWeight extends Model
{
    protected $fillable = [
        'academic_year_id',
        'classwork_percent',
        'midsem_percent',
        'exam_percent',
        'is_active',
    ];

    protected $casts = [
        'classwork_percent' => 'decimal:2',
        'midsem_percent'    => 'decimal:2',
        'exam_percent'      => 'decimal:2',
        'is_active'         => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Helper: Get active weights
    public static function active()
    {
        return self::where('is_active', true)->first();
    }

    // Validation helper
    public function totalPercent(): float
    {
        return $this->classwork_percent + $this->midsem_percent + $this->exam_percent;
    }
}