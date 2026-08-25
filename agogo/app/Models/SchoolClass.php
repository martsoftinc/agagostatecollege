<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'level_order'];
    protected $table = "school_classes";

    public function classStreams(): HasMany
    {
        return $table = $this->hasMany(ClassStream::class);
    }

    public function streams(): BelongsToMany
    {
        return $this->belongsToMany(Stream::class, 'class_streams')
                    ->withPivot('id', 'teacher_id', 'capacity', 'is_active')
                    ->withTimestamps();
    }
}