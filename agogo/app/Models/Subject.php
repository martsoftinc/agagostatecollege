<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function classStreams(): BelongsToMany
    {
        return $this->belongsToMany(ClassStream::class, 'class_stream_subject')
                    ->withPivot(['teacher_id', 'is_core', 'sort_order'])
                    ->withTimestamps();
    }
}