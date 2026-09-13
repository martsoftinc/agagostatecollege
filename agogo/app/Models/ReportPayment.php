<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPayment extends Model
{
    protected $fillable = [
        'student_id', 'semester_id', 'reference', 'amount',
        'currency', 'status', 'channel', 'paystack_response', 'paid_at'
    ];

    protected $casts = [
        'paystack_response' => 'array',
        'paid_at'           => 'datetime',
        'amount'            => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }
}