<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  protected $fillable = [
        'user_id', 'title', 'description', 'original_name',
        'file_path', 'mime_type', 'extension', 'file_size',
        'disk', 'visibility',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sharedWithUsers()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('permission')
            ->withTimestamps();
    }

    // Scope so teachers only see their own + shared + public
    public function scopeAccessibleBy($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('visibility', 'public')
              ->orWhereHas('sharedWithUsers', fn ($q2) => $q2->where('users.id', $userId));
        });
    }
}
