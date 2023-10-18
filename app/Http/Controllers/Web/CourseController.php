<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Repositories\Session\SessionRepository;
use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Models\Course;
use Vanguard\User;

class CourseController extends Controller
{
    public function __construct(private UserRepository $users)
    {
    }

    public function show()
    {
        $data = Course::where('status', 'Active')->get();;
        return view('courses.courses', ['courses' => $data]);
    }
}
