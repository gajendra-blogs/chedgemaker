<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePlan extends Model
{
    use HasFactory;
    protected $table = 'fee_plans';
    protected $fillable = ['center_id','course_id','fee_type','total_fee','fee_detail','created_by','updated_by','name'];
  
    public function batch() {
        return $this->belongsTo('Vanguard\Models\Batch');
    }

    public function center() {
        return $this->belongsTo('Vanguard\Models\Center');
    }

    public function course() {
        return $this->belongsTo('Vanguard\Models\Course');
    }
}
