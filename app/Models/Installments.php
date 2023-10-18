<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installments extends Model
{
    use HasFactory;
    protected $fillable = ['fee_plan_id','installment_amount','due_time','created_by','updated_by'];
}
