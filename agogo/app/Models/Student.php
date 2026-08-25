<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'index_number',
        'pin',
        'course',
        'class',
        'track',
        'house',
        'surname',
        'first_name',
        'middle_name',
        'date_of_birth',
        'place_of_residence',
        'address',
        'guardian_name',
        'guardian_phone',
        'guardian_occupation',
        'jhs_previous_school',
        'jhs_index_number',
        'jhs_position_held',
        'interests_hobbies',
        'medical_conditions',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Model Boot Hooks
     */
    protected static function booted()
    {
        static::creating(function ($student) {
            // 1. Auto-generate Index Number if blank
            if (empty($student->index_number)) {
                $student->index_number = static::generateNextIndexNumber();
            }

            // 2. Auto-generate PIN from Year of Birth if blank
            if (empty($student->pin) && !empty($student->date_of_birth)) {
                $student->pin = date('Y', strtotime($student->date_of_birth));
            }
        });
    }

    /**
     * Generate sequential Index Number format: ASC/{YEAR}/{SEQUENCE}
     * Example: ASC/2026/0001
     */
    public static function generateNextIndexNumber(): string
    {
        $prefix = 'ASC/' . date('Y') . '/';

        // Query the highest existing sequence number for the current year
        $latestNumber = DB::table('students')
            ->where('index_number', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING_INDEX(index_number, '/', -1) AS UNSIGNED)) as max_seq")
            ->value('max_seq');

        $nextSequence = ($latestNumber ?? 0) + 1;

        return $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }
}