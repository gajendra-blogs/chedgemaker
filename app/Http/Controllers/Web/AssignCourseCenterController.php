<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\AssignCourseCenter;
use Vanguard\Models\Center;
use Vanguard\Http\Requests\Batches\CreateBatchesRequest;
use DB;
use Auth;
use Vanguard\Models\Course;
use Vanguard\Events\ActivityLogEvents\Created;
use Illuminate\Support\Facades\Crypt;

class AssignCourseCenterController extends Controller
{
    public function index(Request $request)
    {
        try {
            $centers = Center::all()->pluck('center_name', 'id')->toArray();
            $centers = ["" => 'Select Center'] + $centers;
            $all_centers = Center::all();
            $courses = Course::all()->pluck('course_name', 'id');
            $assigned_courses = DB::table('assign_course_centers')
                ->leftJoin('centers', 'centers.id', '=', 'assign_course_centers.center_id')
                ->leftJoin('courses', 'courses.id', '=', 'assign_course_centers.course_id')
                ->select('assign_course_centers.*', 'centers.center_name', 'courses.course_name')
                // ->orderBy($request->column ? Crypt::decrypt($request->column) : 'assign_course_centers.center_id  ' , $request->order ? $request->order : 'asc')
                ->get();
            if($request->order && $request->column) {
                $edit = false;
                return view('batches.partials.table', compact('assigned_courses', 'edit', 'centers', 'courses'));
            }
            return view('batches.batches', [
                'assigned_courses' => $assigned_courses,
                'edit' => false,
                'centers' => $centers,
                'courses' => $courses,
                'all_centers' => $all_centers
            ]);
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }
    public function create(AssignCourseCenter $batch)
    {
        $centers = Center::all();
        $courses = Course::all();
        return view('batches.add', [
            'batch' => $batch,
            'centers' => $centers,
            'courses' => $courses
        ]);
    }

    public function store(CreateBatchesRequest $request)
    {
        $assigned_courses = [];
        try {
            $courses_to_be_assigned = $request->course_id;
            foreach ($courses_to_be_assigned as $key => $value) {
                // dd($value);
                $course_assignment = new AssignCourseCenter;
                $course_assignment->center_id = $request->center_id;
                $course_assignment->course_id = $value;
                $course_assignment->created_by = Auth::user()->id;
                $course_assignment->save();
                $course = Course::find($value);
                array_push($assigned_courses , $course);
            }
            event(new Created("Created Assignment " . $request->center_id));
            $template = view('batches.partials.courses' , compact('assigned_courses'))->render();
            return json_encode(['success' => true , "template" => $template , "center" => $request->center_id , "message" => "Course Assigned Successfully"]);

        } catch (\Exception $exception) {
            json_encode(['success' => false, 'error' => $exception]);
        }

    }

    public function edit(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $assigned_courses = DB::table('assign_course_centers')
                    ->leftJoin('courses', 'courses.id', '=', 'assign_course_centers.course_id')
                    ->where('center_id', $id)->get();
     
                    dd($assigned_courses);
        $center = Center::where('id' , $id)->get();
        $courses = Course::all();
        return view('batches.partials.details', [
            'edit' => true,
            'batch' => $batch,
            'centers' => $centers,
            'courses' => $courses
        ]);
    }

    public function update(CreateBatchesRequest $request, Batch $batch)
    {
        try {
            $batches = AssignCourseCenter::findOrFail($batch->id);
            $batches->center_id = $request->center_id;
            $batches->course_id = $request->course_id;
            $batches->batch_name = $request->batch_name;
            $batches->batch_duration = $request->batch_duration;
            $batches->batch_start = $request->batch_start;
            $batches->batch_end = $request->batch_end;
            $batches->batch_time = $request->batch_time;
            $batches->updated_by = Auth::user()->id;
            $batches->save();
            event(new Created("Updated Batch " . $request->batch_name));
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        $updatedData = DB::table('batches')
            ->leftJoin('centers', 'centers.id', '=', 'batches.center_id')
            ->leftJoin('courses', 'courses.id', '=', 'batches.course_id')
            ->select('batches.*', 'centers.center_name', 'courses.course_name')
            ->where('batches.id', $batches->id)
            ->get()->first();
        $renderedRow = view('batches.partials.row', ['batch' => $updatedData, "edit" => true, 'row_count' => $request->row_count])->render();
        return json_encode(['success' => true, 'template' => $renderedRow, "message" => 'Batch Updated Successfully']);
    }

    public function show($batch)
    {
        $batch = AssignCourseCenter::find(Crypt::decrypt($batch));
        return view('batches.view', compact('batch'));
    }

    public function destroy($batch)
    {

        try {
            $batch = AssignCourseCenter::findOrFail(Crypt::decrypt($batch));
            $batch->delete();
            event(new Created("Deleted Batch " . $batch->batch_name));
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('batches.index')
            ->withSuccess(__('Batch deleted successfully.'));
    }
}
