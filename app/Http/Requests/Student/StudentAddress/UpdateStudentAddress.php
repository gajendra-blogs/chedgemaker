<?php

namespace Vanguard\Http\Requests\Student\StudentAddress;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateStudentAddress extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'address1' => 'required',
          'country' => 'required',
          'state' => 'required',
          'pincode' => 'required|numeric|min_digits:6|min_digits:6',
          'city' => 'required'
        ];
    }
}
