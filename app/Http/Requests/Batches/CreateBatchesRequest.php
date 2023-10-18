<?php

namespace Vanguard\Http\Requests\Batches;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateBatchesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'center_id' => 'required',
            'course_id' => 'required',
        ];

        return $rules;
    }
}
