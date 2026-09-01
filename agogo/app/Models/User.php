<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        
        'name',
        'first_name',
        'last_name',
        'other_names',
        'profile_picture',
        'role',
        'status',
        'full_name',
        'qualification',
        'class_stream_id',
        'phone',
        'is_active',
        'email',
        'email_verified_at',
        'email_verification_code',
        'email_verification_sent_at',
        'student_id',
        'pincode',
        'pincode_updated_at',
        'programme',
        'course',
        'class',
        'track',
        'house',
        'boarding',
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
        'password',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_sent_at',
        'staff_id',
        'rank',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code',
        'pincode',
        'two_factor_code',          // never expose codes in API responses
    ];

    protected $appends = [
    'profile_picture_url',
    ];

    protected $casts = [
        'email_verified_at'          => 'datetime',
        'email_verification_sent_at' => 'datetime',
        'two_factor_sent_at'         => 'datetime',
        'password'                   => 'hashed',
        'two_factor_enabled'         => 'boolean',
    ];


    public function getProfilePictureUrlAttribute(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        // Optional default avatar
        return asset('images/default-avatar.png');
    }

    public function classStream(): BelongsTo
    {
        return $this->belongsTo(ClassStream::class, 'class_stream_id');
    }

    /* ── Name mutators: keep full_name in sync ── */

    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = $value;
        $this->attributes['full_name']  = $value . ' ' . ($this->attributes['last_name'] ?? '');
    }

    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = $value;
        $this->attributes['full_name'] = ($this->attributes['first_name'] ?? '') . ' ' . $value;
    }

    /* ── Name accessors: fall back to full_name split if columns empty ── */

    public function getFirstNameAttribute(): string
    {
        return $this->attributes['first_name']
            ?? explode(' ', $this->attributes['full_name'] ?? '')[0]
            ?? '';
    }

    public function getLastNameAttribute(): string
    {
        if (!empty($this->attributes['last_name'])) {
            return $this->attributes['last_name'];
        }
        $parts = explode(' ', $this->attributes['full_name'] ?? '');
        array_shift($parts);
        return implode(' ', $parts);
    }

    /* ── Helpers ── */

    public function getFormattedPhoneAttribute(): string
    {
        return '+233 ' . ltrim($this->phone ?? '', '0');
    }

    public function isEmailVerificationCodeValid(): bool
    {
        return $this->email_verification_sent_at
            && now()->diffInMinutes($this->email_verification_sent_at) <= 10;
    }

    public function isTwoFactorCodeValid(): bool
    {
        return $this->two_factor_sent_at
            && now()->diffInMinutes($this->two_factor_sent_at) <= 10;
    }

    // Helper methods to quickly check roles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Get the student profile metadata associated with the user.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function lessonPlans(): HasMany
    {
        return $this->hasMany(LessonPlan::class);
    }

     /**
     * Find user by student_id or phone
     */
    public static function findByStudentIdOrPhone($login)
    {
        return self::where('student_id', $login)
            ->orWhere('phone', $login)
            ->first();
    }

    /**
     * Set and hash the pincode
     */
    public function setPincodeAttribute($value): void
    {
        $this->attributes['pincode'] = Hash::make($value);
        $this->attributes['pincode_updated_at'] = now();
    }

    /**
     * Verify if the provided pincode matches
     */
    public function verifyPincode(string $pincode): bool
    {
        return Hash::check($pincode, $this->pincode);
    }

    /**
     * Check if pincode is set for this user
     */
    public function hasPincode(): bool
    {
        return !is_null($this->pincode);
    }

    /**
     * Generate a random pincode
     */
    public static function generatePincode(): string
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

   protected static function booted()
{
    static::creating(function (User $user) {
        // Only apply student logic
        if (($user->role ?? null) !== 'student') {
            return;
        }

        // 1. Auto-generate student_id if blank
        if (empty($user->student_id)) {
            $user->student_id = static::generateNextStudentId();
        }

        // 2. Auto-generate pincode from Year of Birth if blank
        if (empty($user->pincode) && !empty($user->date_of_birth)) {
            $user->pincode = date('Y', strtotime($user->date_of_birth));
        }

        // 3. Default status
        if (empty($user->status)) {
            $user->status = 'Active';
        }
    });
}

/**
 * Generate sequential student_id: ASC/{YEAR}/{SEQUENCE}
 * Example: ASC/2026/0001
 */
public static function generateNextStudentId(): string
{
    $prefix = 'ASC/' . date('Y') . '/';

    $latestNumber = \Illuminate\Support\Facades\DB::table('users')
        ->where('student_id', 'like', $prefix . '%')
        ->selectRaw("MAX(CAST(SUBSTRING_INDEX(student_id, '/', -1) AS UNSIGNED)) as max_seq")
        ->value('max_seq');

    $nextSequence = ((int) ($latestNumber ?? 0)) + 1;

    return $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
}
    
}