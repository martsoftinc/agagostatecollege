<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonPlanResource extends Model
{
    protected $fillable = [
        'lesson_plan_id',
        'title',
        'url',
        'type',
        'description',
        'sort_order',
    ];

    public function lessonPlan(): BelongsTo
    {
        return $this->belongsTo(LessonPlan::class);
    }
}