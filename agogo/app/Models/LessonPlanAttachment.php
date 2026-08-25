<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LessonPlanAttachment extends Model
{
    protected $fillable = [
        'lesson_plan_id',
        'original_name',
        'file_path',
        'mime_type',
        'extension',
        'file_size',
        'disk',
        'description',
        'sort_order',
    ];

    public function lessonPlan(): BelongsTo
    {
        return $this->belongsTo(LessonPlan::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }
}