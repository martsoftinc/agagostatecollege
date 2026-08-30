<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'semester_id',
        'class_stream_id',
        'classwork_score',
        'midsem_score',
        'exam_score',
        'total_score',
        'grade',
        'grade_point',
        'attendance',
        'teacher_comment',
        'is_submitted',
    ];

    protected $casts = [
        'classwork_score' => 'decimal:2',
        'midsem_score'    => 'decimal:2',
        'exam_score'      => 'decimal:2',
        'total_score'     => 'decimal:2',
        'grade_point'     => 'decimal:1',
        'is_submitted'    => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function classStream(): BelongsTo
    {
        return $this->belongsTo(ClassStream::class);
    }
}