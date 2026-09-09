<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtaMeeting extends Model
{
    protected $fillable = [
        'title',
        'description',
        'meeting_date',
        'meeting_time',
        'venue',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        // meeting_time stays as string (HH:MM) for simplicity with HTML time input
    ];
}