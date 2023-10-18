<?php

namespace Vanguard\Http\Requests\Module;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateModuleRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:modules,name,' .$this->module->id,
            'description' => 'required',
            'duration' => 'required|numeric',
        ];

        return $rules;
    }
}
