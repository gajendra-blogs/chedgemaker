<?php

namespace Vanguard\Http\Requests\Student\StudentDetails;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateStudentDetails extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'first_name' => 'required',
          'last_name' => 'required',
          'birthday' => 'required|date',
          'phone' => 'required|numeric',
          'father_name' => 'required'
        ];
    }
}
