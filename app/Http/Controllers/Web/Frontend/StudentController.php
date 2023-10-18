<?php

namespace Vanguard\Http\Controllers\Web\Frontend;

use Auth;
use Illuminate\Http\Request;
use Vanguard\Http\Requests\Student\Academic\CreateAcademicRequest;
use Vanguard\Http\Requests\Student\Academic\UpdateAcademicRequest;
use Vanguard\Http\Requests\Student\StudentDetails\UpdateStudentDetails;
use Vanguard\Http\Requests\Student\StudentAddress\UpdateStudentAddress;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\User;
use Vanguard\Models\StudentAddress;
use Vanguard\Models\UserAcedmic;
use Vanguard\Models\UploadedDocuments;
use Vanguard\Models\Course;
use DB;

class StudentController extends Controller
{
    public function __construct(private UserRepository $users)
    {
    }

    public function index()
    {
        $current_user = auth()->user();
        $academics = DB::table('user_acedmics')
            ->leftJoin('uploaded_documents', 'uploaded_documents.id', '=', 'user_acedmics.certificate_id')
            ->select('user_acedmics.*', 'uploaded_documents.document')
            ->where('user_acedmics.user_id', auth()->user()->id)
            ->get();
        //dd($academics);

        $addresses = DB::table('student_addresses')
            ->leftJoin('states', 'states.id', '=', 'student_addresses.state')
            ->leftJoin('cities', 'cities.id', '=', 'student_addresses.city')
            ->leftJoin('countries', 'countries.id', '=', 'student_addresses.country')
            ->select('student_addresses.*', 'states.name as state_name', 'cities.city', 'countries.name as country_name')
            ->where('student_addresses.user_id', auth()->user()->id)
            ->first();


        $userDetails = DB::table('user_registrations')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->leftJoin('courses', 'courses.id', '=', 'user_registrations.course_id')
            ->leftJoin('fee_plans', 'fee_plans.id', 'user_registrations.feePlan_id')
            ->select('user_registrations.*', 'fee_plans.*', 'centers.center_name', 'courses.course_name')
            ->where('user_registrations.user_id', auth()->user()->id)
            ->get();
        return view('frontend.user.account', compact('academics', 'addresses', 'userDetails', 'current_user'));
    }

    public function editStudentDetails(Request $request, $student_id)
    {
        $user = $this->users->find($student_id);
        $edit = true;
        return view('frontend.user.partial.editDetails', compact('user', 'edit'));
    }

    public function updateStudentDetails(UpdateStudentDetails $request, $student_id)
    {
        $data = $request->all();
        $current_user = $this->users->update($student_id, $data);
        $template = view('frontend.user.partial.profilecart', compact('current_user'))->render();
        $current_user = $current_user->toArray();
        return json_encode(['success' => true, 'template' => $template, 'message' => 'Details Updated Successfully', 'user' => $current_user]);
    }

    public function editStudentAddress(Request $request, $address_id)
    {
        $countries = DB::table('countries')->select('id', 'name')->get();
        $states = DB::table('states')->select('id', 'name')->get();
        $cities = DB::table('cities')->select('id', 'city')->get();
        $address = StudentAddress::where('id', $address_id)->get()->first();
        $edit = true;
        return view('frontend.user.partial.editAddress', compact('edit', 'address', 'countries', 'states', 'cities'));
    }

    public function myCourse(Request $request)
    {

        $studentCoursePlan = DB::table('user_registrations')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->leftJoin('courses', 'courses.id', '=', 'user_registrations.course_id')
            ->select('user_registrations.*', 'centers.center_name', 'courses.course_name')
            ->where('user_id', auth()->user()->id)
            ->get();

        $fee_plan_id = $studentCoursePlan[0]->feePlan_id;
        $booking_fee_head = DB::table('fee_plan_details')
            ->leftJoin('fee_heads', 'fee_heads.id', '=', 'fee_plan_details.fee_head_id')
            ->select('*')
            ->where('fee_plan_id', $fee_plan_id)
            ->where('fee_heads.id', 1)
            ->get();
        // dd($booking_fee_head);
        $installments = DB::table('student_installment_fee_plans')
            ->select('student_installment_fee_plans.*')
            ->where('user_registration_id', $studentCoursePlan[0]->id)
            ->get();

        $downpayment = DB::table('student_installment_fee_plans')
            ->select('student_installment_fee_plans.*')
            ->where('user_registration_id', $studentCoursePlan[0]->id)
            ->where('due_time', 0)
            ->get();


        if (count($downpayment) > 0) {
            $downpayment = $downpayment[0];
        } else {
            $downpayment = [];
        }

        return view('frontend.user.mycourse', compact('studentCoursePlan', 'booking_fee_head', 'installments', 'downpayment'));
    }

    public function editStudentAcademic(Request $request, $academic_id)
    {
        $academic = UserAcedmic::where('id', $academic_id)->get()->first();
        $edit = true;
        return view('frontend.user.partial.editAcademic', compact('academic', 'edit'));

    }

    public function updateStudentAcademic(Request $request, $academic_id)
    {
        $academic = UserAcedmic::find($academic_id)->first();
        $academic->institute = $request->institute;
        $academic->university = $request->university;
        $academic->passout_year = $request->passout_year;
        $academic->marks = $request->marks;
        $academic->place = $request->place;

    }

    public function updateStudentAddress(UpdateStudentAddress $request, $address_id)
    {
        $address = StudentAddress::where('id', $address_id)->get()->first();
        $address->type = 'home';
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->pin_code = $request->pincode;
        $address->updated_by = auth()->user()->id;
        $address->save();

        $addresses = DB::table('student_addresses')
            ->leftJoin('states', 'states.id', '=', 'student_addresses.state')
            ->leftJoin('cities', 'cities.id', '=', 'student_addresses.city')
            ->leftJoin('countries', 'countries.id', '=', 'student_addresses.country')
            ->select('student_addresses.*', 'states.name as state_name', 'cities.city', 'countries.name as country_name')
            ->where('student_addresses.id', $address->id)
            ->first();

        $template = view('frontend.user.partial.address', compact('addresses'))->render();

        return json_encode(['success' => true, 'template' => $template, 'message' => 'Address Updated Successfully']);

    }

    public function addStudentAcademics(CreateAcademicRequest $request)
    {
        $data = $request->input();
        if ($request->file('marksheet_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['marksheet_file']->getClientOriginalName();
            $filePath = $request->file('marksheet_file')->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['marksheet_file']->getClientOriginalName();
            $UploadedDocuments->user_id = auth()->user()->id;
            $UploadedDocuments->created_by = auth()->user()->id;
            $UploadedDocuments->save();
        }

        $acedmic = new UserAcedmic();
        $acedmic->user_id = auth()->user()->id;
        $acedmic->qualification = $data['qualification'];
        $acedmic->institute = $data['institute'];
        $acedmic->university = $data['university'];
        $acedmic->passout_year = $data['passout_year'];
        $acedmic->marks = $data['marks'];
        $acedmic->place = $data['place'];
        if ($request->file('marksheet_file')) {
            $acedmic->certificate_id = $UploadedDocuments->id;
        }
        $acedmic->created_by = auth()->user()->id;
        $acedmic->save();
        $template = view('frontend.user.partial.acedmicSection', compact('acedmic'))->render();

        return json_encode(['success' => true, 'template' => $template, 'message' => 'Academic Added Successfully']);
    }

    public function updateStudentAcademics(UpdateAcademicRequest $request, $academic_id)
    {
        $data = $request->input();

        $acedmic = UserAcedmic::where('id', $academic_id)->get()->first();
        // dd($request->file());
        if ($request->file('marksheet_file')) {
            if ($acedmic->certificate_id != null) {
                $certificate = UploadedDocuments::where('id', $acedmic->certificate_id)->get()->first();
                $fileName = time() . '_' . $request['marksheet_file']->getClientOriginalName();
                $filePath = $request->file('marksheet_file')->storeAs('uploads', $fileName, 'public');
                $certificate->document = $fileName;
                $certificate->save();
            } else {
                $UploadedDocuments = new UploadedDocuments();
                $fileName = time() . '_' . $request['marksheet_file']->getClientOriginalName();
                $filePath = $request->file('marksheet_file')->storeAs('uploads', $fileName, 'public');
                $UploadedDocuments->document = time() . '_' . $request['marksheet_file']->getClientOriginalName();
                $UploadedDocuments->user_id = auth()->user()->id;
                $UploadedDocuments->created_by = auth()->user()->id;
                $UploadedDocuments->save();
            }
        }
        $acedmic->user_id = auth()->user()->id;
        $acedmic->institute = $data['institute'];
        $acedmic->university = $data['university'];
        $acedmic->passout_year = $data['passout_year'];
        $acedmic->marks = $data['marks'];
        $acedmic->place = $data['place'];
        if ($request->file('marksheet_file') && !$acedmic->certificate_id) {
            $acedmic->certificate_id = $UploadedDocuments->id;
        }
        $acedmic->created_by = auth()->user()->id;
        $acedmic->save();

        $template = view('frontend.user.partial.acedmicSection', compact('acedmic'))->render();

        return json_encode(['success' => true, 'template' => $template, 'message' => 'Academic Updated Successfully', 'academic' => $acedmic->toArray()]);
    }

    public function getAvailableCourses(Request $request)
    {
        $courses = DB::table('assign_course_centers')
            ->leftJoin('courses', 'courses.id', '=', 'assign_course_centers.course_id')
            ->leftJoin('centers', 'centers.id', '=', 'assign_course_centers.center_id')
            ->select('assign_course_centers.*', 'courses.course_name', 'courses.course_description', 'courses.course_duration', 'courses.status as course_status', 'centers.center_name', 'centers.center_location', 'centers.center_email', 'centers.contact_person', 'centers.contact_number', 'centers.center_code', 'centers.status as center_status')
            ->where('assign_course_centers.status', 1)->get();

        return view('frontend.courses.list', compact('courses'));
    }
    public function paymentHistory(Request $request)
    {
        $studentCoursePlan = DB::table('user_registrations')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->select('user_registrations.*', 'centers.center_name')
            ->where('user_id', auth()->user()->id)
            ->get();
        //dd($studentCoursePlan[0]->id);
        $paymentHistory = DB::table('payments')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'payments.user_registration_id')
            ->leftJoin('users', 'users.id', '=', 'payments.updated_by')
            ->select('payments.*', 'users.first_name')
            ->where('user_registration_id', $studentCoursePlan[0]->id)
            ->get();
        //dd($paymentHistory);
        return view('frontend.user.paymenthistory', compact('paymentHistory'));
    }
}