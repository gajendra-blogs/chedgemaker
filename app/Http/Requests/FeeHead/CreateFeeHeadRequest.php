<?php

namespace Vanguard\Http\Requests\FeeHead;

use Vanguard\Http\Requests\Request;

class CreateFeeHeadRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'fee_heads_title' => 'required|unique:fee_heads|max:255',
            'fee_heads_sequence' => 'required|unique:fee_heads|min:0',
        ];

        return $rules;
    }
}