<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'performance_indicators' => 'array',
        'core_competencies'     => 'array',
        'key_vocabulary'        => 'array',
        'phase_1_introduction'  => 'array',
        'phase_2_main_body'     => 'array',
        'phase_3_closure'       => 'array',
        'lesson_date'           => 'date',
    ];

    // ─────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sharedWithUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_plan_shares')
                    ->withPivot('permission')
                    ->withTimestamps();
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LessonPlanResource::class)->orderBy('sort_order');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(LessonPlanAttachment::class)->orderBy('sort_order');
    }

   

    // ─────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────

    public function scopeAccessibleBy($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('visibility', 'public')
              ->orWhere('user_id', $userId)
              ->orWhereHas('sharedWithUsers', function ($q2) use ($userId) {
                  $q2->where('users.id', $userId);
              });
        });
    }

    
}