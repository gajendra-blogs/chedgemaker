<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAcedmic extends Model
{
    use HasFactory;
    protected $table = 'user_acedmics';

    protected $fillable = ['user_id','qualification','institute','university','passout_year',
     'place','marks','certificate_id','created_by','updated_by'];
}
