<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddress extends Model
{
    use HasFactory;

    protected  $table = 'student_addresses';
    protected  $fillable = ['user_id' , 'type' , 'address1' , 'address2' , 'country' , 'state' , 'city' , 'pin_code' , 'created_by' , 'updated_by' , 'status'];
}
