<?php

namespace Vanguard\Http\Requests\FeeHead;

use Vanguard\Http\Requests\Request;

class UpdateFeeHeadRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'fee_heads_title' => 'required|max:255|unique:fee_heads,fee_heads_title,'. $this->id,
            'fee_heads_sequence' => 'required|min:0|unique:fee_heads,fee_heads_sequence,'. $this->id,
          
        ];

        return $rules;
    }
}
