<?php

namespace Vanguard\Http\Requests\Student\Academic;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateAcademicRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'institute' => 'required',
          'university' => 'required',
          'passout_year' => 'required|numeric',
          'marks' => 'required|numeric',
          'place' => 'required',
        ];
    }
}
