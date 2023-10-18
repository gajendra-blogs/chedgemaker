<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInstallmentFeePlan extends Model
{

    use HasFactory;
    protected $table = 'student_installment_fee_plans';
    protected $fillable = ['paid_amount', 'status', 'user_registration_id', 'installment_amount', 'due_time', 'created_by', 'updated_by'];

}