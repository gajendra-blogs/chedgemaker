<?php

namespace Vanguard\Http\Requests\Course;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateCourseRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'course_name' => 'required|unique:courses,course_name',
            'course_description' => 'required',
            'course_duration' => 'required|numeric'
        ];

        return $rules;
    }
}
