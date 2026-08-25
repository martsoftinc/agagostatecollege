<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'passport_picture',
        'surname',
        'first_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'home_town',
        'parent_guardian_name',
        'parent_guardian_phone',
        'parent_guardian_email',
        'relationship',
        'parent_guardian_occupation',
        'address',
        'place_of_residence',
        'previous_school',
        'index_number',
        'bece_year',
        'programme',
        'position_held',
        'interests_hobbies',
        'medical_conditions',
        'amount_paid',
        'payment_reference',
        'payment_status',
        'status',
        'religion',
        'role',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'amount_paid' => 'decimal:2'
    ];

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->surname);
    }

    // Scope for paid admissions
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Scope for pending admissions
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}