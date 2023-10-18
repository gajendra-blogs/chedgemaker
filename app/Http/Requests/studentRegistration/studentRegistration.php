<?php

namespace Vanguard\Http\Requests\studentRegistration;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class studentRegistration extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'phone' => 'required|max:255',
            'birthday' => 'required|max:255',
            'country' => 'required|max:255',
            'phone' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
            'pin_code' => 'required|max:255',
            'centers' => 'required|max:255',
            'courses' => 'required|max:255',
            'paymentType' => 'required|max:255',
        ];

        return $rules;
    }
}