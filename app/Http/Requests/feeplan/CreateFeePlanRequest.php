<?php

namespace Vanguard\Http\Requests\feeplan;

use Vanguard\Http\Requests\Request;

class CreateFeePlanRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required',
            'fee_type' => 'required',
            'total_fee' => 'required',
            'fee_plan_name' => 'required',
        ];
        
    }
}
