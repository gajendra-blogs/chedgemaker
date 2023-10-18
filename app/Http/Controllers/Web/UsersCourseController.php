<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Course\CourseRepository;
use Vanguard\Models\Course;

class UsersCourseController extends Controller
{
    public function __construct(private CourseRepository $courses)
    {
    }

    public function index(Request $request)
    {
        $courses = $this->courses->paginate($perPage = 10, $request->search, $request->status);
        return view('courses.courses', compact('courses'));
    }
}
