<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Events\User\Created;
use Vanguard\Http\Controllers\Controller;
use DB;
use Vanguard\User;
use Vanguard\Country;
use Vanguard\Models\Center;
use Vanguard\Models\State;
use Vanguard\Models\City;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Models\UserAcedmic;
use Vanguard\Models\StudentAddress;
use Vanguard\Http\Requests\Student\UpdateLoginDetailsRequest;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Models\UploadedDocuments;
use Illuminate\Support\Facades\Crypt;


class StudentController extends Controller
{
    public function __construct(private UserRepository $users, private UserAvatarManager $avatarManager)
    {
    }
    public function index(Request $request)
    {
        // $studentType = null;
        // $typeValue = null;
        // $selectedStudentType = "allStudents";
        // if ($request->searchStudents == "registeredStudents") {
        //     $selectedStudentType = "registeredStudents";
        //     $studentType = "registration_status";
        //     $typeValue = "pending";
        // }
        // if ($request->searchStudents == "bookedStudents") {
        //     $selectedStudentType = "bookedStudents";
        //     $studentType = "registration_status";
        //     $typeValue = "booked";
        // }

        // $students = User::join('user_registrations', 'user_registrations.user_id', '=', 'users.id')
        //     ->join('centers', 'user_registrations.center_id', '=', 'centers.id')
        //     ->join('courses', 'user_registrations.course_id', '=', 'courses.id')
        //     ->where('role_id', 3)
        //     ->select('users.*', 'centers.center_name');

        // if ($request->searchStudents == "registeredStudents" || $request->searchStudents == "bookedStudents") {
        //     $students->where($studentType, 'LIKE', "%{$typeValue}%");
        // }
        // ;
        // $res = $students->get();

        if ($request->status) {
            $students = User::where('role_id', 3)
                ->where('status', $request->status)
                ->where('email', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)->where('status', $request->status)
                ->orWhere('first_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)->where('status', $request->status)
                ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)->where('status', $request->status)
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)->where('status', $request->status)
                ->orderBy($request->column ? Crypt::decrypt($request->column) : 'email', $request->order ? $request->order : 'asc')
                ->paginate(10);
        } else {
            $students = User::where('role_id', 3)
                ->where('email', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
                ->orWhere('first_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
                ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
                ->orderBy($request->column ? Crypt::decrypt($request->column) : 'email', $request->order ? $request->order : 'asc')
                ->paginate(10);
        }

        //dd($students);
        $statuses = ['' => __('All')] + UserStatus::lists();

        if ($request->order && $request->column) {
            return view('students.table', compact('students'));
        }

        return view('students.list', [

            'students' => $students,
            'statuses' => $statuses
            // 'selectedStudentType' => $selectedStudentType
        ]);
    }



    public function show(User $student)
    {
        $centers = Center::where('status', 1)->pluck('center_name', 'id')->toArray();
        $academics = DB::table('user_acedmics')
            ->leftJoin('uploaded_documents', 'uploaded_documents.id', '=', 'user_acedmics.certificate_id')
            ->select('user_acedmics.*', 'uploaded_documents.document')
            ->where('user_acedmics.user_id', $student->id)
            ->get();
        $addresses = DB::table('student_addresses')
            ->leftJoin('states', 'states.id', '=', 'student_addresses.state')
            ->leftJoin('cities', 'cities.id', '=', 'student_addresses.city')
            ->leftJoin('countries', 'countries.id', '=', 'student_addresses.country')
            ->select('student_addresses.*', 'states.name as state_name', 'cities.city', 'countries.name as country_name')
            ->where('student_addresses.user_id', $student->id)
            ->get();
        $edit = false;
        return view('students.view', compact('student', 'academics', 'addresses', 'centers', 'edit'));
    }

    public function edit(User $student)
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $studentRegist = DB::table('user_registrations')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->select('user_registrations.*')
            ->where('user_registrations.user_id', $student->id)
            ->first();
        $academics = DB::table('user_acedmics')
            ->leftJoin('uploaded_documents', 'uploaded_documents.id', '=', 'user_acedmics.certificate_id')
            ->select('user_acedmics.*', 'uploaded_documents.document')
            ->where('user_acedmics.user_id', $student->id)
            ->get();

        $addresses = DB::table('student_addresses')
            ->leftJoin('states', 'states.id', '=', 'student_addresses.state')
            ->leftJoin('cities', 'cities.id', '=', 'student_addresses.city')
            ->leftJoin('countries', 'countries.id', '=', 'student_addresses.country')
            ->select('student_addresses.*', 'states.name as state_name', 'cities.city', 'countries.name as country_name')
            ->where('student_addresses.user_id', $student->id)
            ->first();
        return view('students.edit', [
            'edit' => true,
            'centers' => Center::where('status', 1)->pluck('center_name', 'id')->toArray(),
            'center' => ['' => 'Select Center'] + Center::all()->pluck('center_name', 'id')->toArray(),
            'studentRegist' => $studentRegist,
            'student' => $student,
            'countries' => $countries,
            'academics' => $academics,
            'addresses' => $addresses,
            'states' => $states,
            'cities' => $cities
        ]);
    }

    public function destroy(User $student)
    {
        if ($student->is(auth()->user())) {
            return redirect()->route('students.index')
                ->withErrors(__('You cannot delete yourself.'));
        }
        $student = User::find($student->id);
        $student->delete();
        event(new Created($student));

        return redirect()->route('students.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function update(User $student, Request $request)
    {
        $student->update($request->all());
        return redirect()->back()
            ->withSuccess(__('Student updated successfully.'));
    }
    public function loginupdate(User $student, UpdateLoginDetailsRequest $request)
    {
        $data = $request->all();
        $student->update($data);
        return redirect()->back()
            ->withSuccess(__('Student login updated successfully.'));
    }
    public function academicupdate(Request $request, UserAcedmic $academic_id)
    {
        $data = $request->all();
        //dd($data);
        $academic = UserAcedmic::find($academic_id);
        if ($request['10_th_marksheet']) {
            $userAcademics = UserAcedmic::where('id', $request['ids'][0])->update([
                'qualification' => $request['10_th_marksheet'][0],
                'institute' => $request['10_th_marksheet'][1],
                'university' => $request['10_th_marksheet'][2],
                'passout_year' => $request['10_th_marksheet'][3],
                'place' => $request['10_th_marksheet'][4],
                'marks' => $request['10_th_marksheet'][5],
                'updated_by' => auth()->user()->id
            ]);
        }
        if ($request['12_th_marksheet']) {
            $userAcademics = UserAcedmic::where('id', $request['ids'][1])->update([
                'qualification' => $request['12_th_marksheet'][0],
                'institute' => $request['12_th_marksheet'][1],
                'university' => $request['12_th_marksheet'][2],
                'passout_year' => $request['12_th_marksheet'][3],
                'place' => $request['12_th_marksheet'][4],
                'marks' => $request['12_th_marksheet'][5],
                'updated_by' => auth()->user()->id
            ]);
        }
        if ($request['graduation']) {
            $userAcademics = UserAcedmic::where('id', $request['ids'][2])->update([
                'qualification' => $request['graduation'][0],
                'institute' => $request['graduation'][1],
                'university' => $request['graduation'][2],
                'passout_year' => $request['graduation'][3],
                'place' => $request['graduation'][4],
                'marks' => $request['graduation'][5],
                'updated_by' => auth()->user()->id
            ]);
        }
        if ($request['post_graduation']) {
            $userAcademics = UserAcedmic::where('id', $request['ids'][3])->update([
                'qualification' => $request['post_graduation'][0],
                'institute' => $request['post_graduation'][1],
                'university' => $request['post_graduation'][2],
                'passout_year' => $request['post_graduation'][3],
                'place' => $request['post_graduation'][4],
                'marks' => $request['post_graduation'][5],
                'updated_by' => auth()->user()->id
            ]);
        }
        return redirect()->back()
            ->withSuccess(__('Student academic updated successfully.'));
    }
    public function addressupdate(User $student, Request $request, StudentAddress $studentAddress)
    {
        //$data = $request->all();
        $studentAddress = StudentAddress::where('user_id', $student->id)->update([
            'address1' => $request->address1,
            'address2' => $request->address2,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'updated_by' => auth()->user()->id
        ]);
        return redirect()->back()
            ->withSuccess(__('Student address updated successfully.'));
    }

    public function avatarupdate(User $student, Request $request)
    {
        // $data = $request->avatar;
        // dd($data);
        // $avatarName = time().'.'.$request->avatar->getClientOriginalExtension();
        // $request->avatar->move(public_path('upload/users'), $avatarName);

        // Auth()->user()->update(['avatar'=>$avatarName]);

        // return back()->with('success', 'Avatar updated successfully.');

        $this->validate($request, ['avatar' => 'image']);
        $name = $this->avatarManager->uploadAndCropAvatar(
            $request->file('avatar'),
            $request->get('points')
        );
        if ($name) {
            if ($student->id) {
                $this->users->update($student->id, ['avatar' => $name]);
                event(new UpdatedByAdmin($student));
                return redirect()->back()
                    ->withSuccess(__('Avatar changed successfully.'));
            } else {
                $this->users->update(auth()->user()->id, ['avatar' => $name]);
                return redirect()->back()
                    ->withSuccess(__('Avatar changed successfully.'));

            }

        }
        if ($student->id) {
            return redirect()->route('students.edit', $student)
                ->withErrors(__('Avatar image cannot be updated. Please try again.'));
        }
    }

    public function viewAcademicDoc(Request $request, $doc_id)
    {
        $doc_details = UploadedDocuments::where('id', $doc_id)->get()->first();
        $path = url('uploads/' . $doc_details->document);
        return \Redirect::to($path);
    }
}