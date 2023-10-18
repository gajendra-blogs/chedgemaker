<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feeHead extends Model
{
    use HasFactory;

    protected $table = 'fee_heads';

    protected $fillable = ['fee_heads_title' , 'fee_heads_sequence' , 'status' , 'created_by' ,'charges_default_value' , 'charges_type'];

}
