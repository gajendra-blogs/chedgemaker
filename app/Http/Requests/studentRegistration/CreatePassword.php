<?php

namespace Vanguard\Http\Requests\studentRegistration;

use Vanguard\Http\Requests\Request;

class CreatePassword extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'min:5',
            'confirm-password' => 'min:5|required_with:password|same:password'
        ];
    }
}
