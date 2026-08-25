<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];
    protected $table = "streams";

    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_streams')
                    ->withPivot('id', 'teacher_id', 'capacity', 'is_active')
                    ->withTimestamps();
    }
}