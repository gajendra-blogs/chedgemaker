<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePlanDetail extends Model
{
    use HasFactory;


    protected $fillable = ['fee_head_id' , 'fee_plan_id' , 'status' , 'amount' , 'created_by' , 'updated_by'];
}
