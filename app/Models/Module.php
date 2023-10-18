<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = ['fees' , 'name' , 'description' , 'status' , 'duration' , 'created_by' , 'updated_by'];
}
