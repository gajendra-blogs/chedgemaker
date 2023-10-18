<?php

namespace Vanguard\Http\Requests\Student;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateLoginDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $student = $this->getUserForUpdate();

        return [
            'email' => 'required|email|unique:users,email,' . $student->id,
            'username' => 'nullable|unique:users,username,' . $student->id,
            'password' => 'nullable|min:8|confirmed'
        ];
    }

    /**
     * @return \Illuminate\Routing\Route|object|string
     */
    protected function getUserForUpdate()
    {
        return $this->route('student');
    }
}
