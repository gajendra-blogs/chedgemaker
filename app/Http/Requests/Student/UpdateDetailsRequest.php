<?php

namespace Vanguard\Http\Requests\Student;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'nullable|date'
        ];
    }
}
