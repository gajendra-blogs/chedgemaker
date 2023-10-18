<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistrations extends Model
{
    use HasFactory;
    protected $table = 'user_registrations';
    protected $fillable = [
        'user_id',
        'student_registration_code',
        'center_id',
        'course_id',
        'selected_fee_type',
        'total_bill_amount',
        'total_due_amount',
        'amount_paid',
        'discount_value',
        'feePlan_id',
        'updated_by',
        'registration_status',
        'PaymentStatus',
        'status',
        'newDiscount',
        'discountApproveStatus',
        'counsellor_id'
    ];
}