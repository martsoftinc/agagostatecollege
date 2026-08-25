<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'index_number',
        'cssps_number',
        'date_of_birth',
        'gender',
        'current_form',
        'track',
        'program_of_study',
        'class_id',
        'residential_status',
        'house_id',
        'room_number',
        'guardian_name',
        'guardian_phone',
        'guardian_relation',
        'enrollment_date',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
    ];

    /**
     * Get the core user/authentication record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class/arm the student belongs to.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the house the student is assigned to.
     */
    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    protected static function booted(): void
    {
        static::creating(function (StudentProfile $profile) {
            // If an index number is already manually provided (e.g., from an override), don't overwrite it
            if (!$profile->index_number) {
                $profile->index_number = self::generateUniqueIndexNumber($profile->enrollment_date);
            }
        });
    }

    /**
     * Generate sequential format: ASC/{sequence}/{year}
     */
    public static function generateUniqueIndexNumber($enrollmentDate = null): string
    {
        $date = $enrollmentDate ? \Carbon\Carbon::parse($enrollmentDate) : now();
        $yearSuffix = $date->format('y'); // e.g., '26' for 2026

        // Use a pessimistic lock or atomic transaction block to prevent race conditions during heavy bulk registration
        return DB::transaction(function () use ($yearSuffix) {
            // Find the highest sequence number used in the current enrollment year
            $latestProfile = StudentProfile::where('index_number', 'like', "ASC/%/{$yearSuffix}")
                ->select('index_number')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            $nextSequence = 1;

            if ($latestProfile) {
                // Extract the middle sequence number from 'ASC/939/26'
                $parts = explode('/', $latestProfile->index_number);
                if (isset($parts[1])) {
                    $nextSequence = (int)$parts[1] + 1;
                }
            }

            return "ASC/{$nextSequence}/{$yearSuffix}";
        });
    }
}
