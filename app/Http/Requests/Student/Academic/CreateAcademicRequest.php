<?php

namespace Vanguard\Http\Requests\Student\Academic;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateAcademicRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'qualification' => 'required',
          'institute' => 'required',
          'university' => 'required',
          'passout_year' => 'required|numeric',
          'marks' => 'required|numeric',
          'place' => 'required',
        ];
    }
}
