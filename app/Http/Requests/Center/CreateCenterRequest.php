<?php

namespace Vanguard\Http\Requests\Center;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateCenterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'center_name' => 'required|unique:centers|max:255',
            'center_location' => 'required|max:255',
            'center_email' => 'required|unique:centers|max:255',
            'contact_person' => 'required|max:255',
        ];

        return $rules;
    }
}
