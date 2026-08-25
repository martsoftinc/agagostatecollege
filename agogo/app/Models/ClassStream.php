<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassStream extends Model
{
    use HasFactory;

    protected $fillable = ['school_class_id', 'stream_id', 'teacher_id', 'capacity', 'is_active'];
    protected $table = "class_streams";

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'class_stream_id');
    }

    // Accessor for full composite class name (e.g., "SHS 1 - General Science 1")
    public function getFullNameAttribute(): string
    {
        return "{$this->schoolClass->name} {$this->stream->name}";
    }
}