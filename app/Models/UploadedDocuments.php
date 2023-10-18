<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDocuments extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

}