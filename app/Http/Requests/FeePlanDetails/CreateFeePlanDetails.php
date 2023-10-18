<?php

namespace Vanguard\Http\Requests\FeePlanDetails;

use Vanguard\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateFeePlanDetails extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uniqueRule = Rule::unique('fee_plan_details')->where(function ($query){
            return $query->where('fee_plan_id', $this['fee_plan_id']??'')
            ->where('fee_head_id', $this['fee_head_id']??'');
        });
        $rules = [
            'fee_head_id' => ['required' , $uniqueRule],
            'fee_plan_id' => ['required' , $uniqueRule],
            'amount' => 'required|numeric'
        ];

        return $rules;
    }
}
