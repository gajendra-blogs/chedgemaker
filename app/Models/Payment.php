<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = ['user_registration_id','transaction_id',
'payment_method','amount','description','wallet','entity','refund_Date','bank_transaction_id','bank',
'bank_check_date','status'];
}
