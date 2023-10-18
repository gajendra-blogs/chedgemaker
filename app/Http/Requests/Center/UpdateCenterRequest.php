<?php

namespace Vanguard\Http\Requests\Center;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateCenterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'center_name' => 'required|max:255|unique:centers,center_name,'.$this->id,
            'center_location' => 'required|max:255,'.$this->id,
            'center_email' => 'required|max:255|unique:centers,center_email,'.$this->id,
            'contact_person' => 'required|max:255|unique:centers,contact_person,'.$this->id,
        ];

        return $rules;
    }
}
