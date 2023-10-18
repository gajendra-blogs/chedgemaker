<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignCourseCenter extends Model
{
    use HasFactory;
    protected $table = 'assign_course_centers';

    protected $fillable = ['center_id', 'course_id'];
}
