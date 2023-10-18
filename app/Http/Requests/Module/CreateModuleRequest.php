<?php

namespace Vanguard\Http\Requests\Module;

use Vanguard\Http\Requests\Request;

class CreateModuleRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:modules,name',
            'description' => 'required',
            'duration' => 'required|numeric'
        ];

        return $rules;
    }
}
