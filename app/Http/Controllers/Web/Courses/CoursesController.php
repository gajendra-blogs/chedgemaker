<?php

namespace Vanguard\Http\Controllers\Web\Courses;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Course\CourseRepository;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Http\Requests\Course\CreateCourseRequest;
use Vanguard\Http\Requests\Course\UpdateCoursRequest;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Events\Course\Deleted;
use Vanguard\Events\ActivityLogEvents\Created;
use Vanguard\Models\Course;
use Illuminate\Support\Facades\Crypt;

class CoursesController extends Controller
{
    public function __construct(private CourseRepository $courses)
    {
    }

    /**
     * Display a listing of the Courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = $this->courses->paginate($perPage = 5, $request->search, $request->status , $request);
        $edit = false;
        if ($request->order && $request->column) {
            return view('courses.partials.table' , compact('courses' , 'edit'));
        }
        return view('courses.courses', compact('courses' , 'edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CountryRepository $countryRepository, RoleRepository $roleRepository)
    {
        return view('courses.add', [
            'countries' => $this->parseCountries($countryRepository),
            'roles' => $roleRepository->lists(),
            'statuses' => UserStatus::lists()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourseRequest $request)
    {
        $data = $request->all() + [
            'created_by' => auth()->user()->id,
            'status' => '0'
        ];
        $last_inserted = $this->courses->create($data);
        event(new Created("Created Course ".$request->course_name));

        $total_record = Course::count();
        $rendered_row = view('courses.partials.row' , ['course' => $last_inserted , 'edit' => false , 'row_count' => 1])->render();
        return json_encode(['success' => true , 'total_record' => $total_record , 'template' => $rendered_row , "message" => 'Course Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        // $course = Crypt::decrypt($course);
        // print_r($course);die;
        return view('courses.partials.details', [
            'edit' => true,
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, UpdateCoursRequest $request)
    {
        $data = $request->all() + [
            'updated_by' => auth()->user()->id
        ];
        $updatedData = $this->courses->update($course->id, $data);
        event(new Created("Updated Course ".$request->course_name));

        $renderedRow = view('courses.partials.row' , ['course' => $updatedData , "edit" => false , 'row_count' => $request->row_count])->render();
        return json_encode(['success' => true , 'template' => $renderedRow , "message" => 'Course Updated Successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $this->courses->delete($course->id);
        event(new Created("Deleted Course ".$course->course_name));


        return redirect()->route('course.index')
            ->withSuccess(__('Course deleted successfully.'));
    }

    /**
     * Parse countries into an array that also has a blank
     * item as first element, which will allow users to
     * leave the country field unpopulated.
     *
     * @param CountryRepository $countryRepository
     * @return array
     */
    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => __('Select a Country')] + $countryRepository->lists()->toArray();
    }
}
