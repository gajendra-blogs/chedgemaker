<?php

namespace Vanguard\Http\Controllers\Web\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;

use Illuminate\Support\Facades\Validator;
use Vanguard\Http\Requests\studentRegistration\CreatePassword;

use Illuminate\Auth\Events\Registered;
use Vanguard\Http\Controllers\Controller;
use Auth;
use Vanguard\Models\UserAcedmic;
use Vanguard\Models\City;
use Vanguard\Models\State;
use Vanguard\Models\StudentInstallmentFeePlan;
use Vanguard\Models\StudentAddress;
use Vanguard\Models\UploadedDocuments;
use Vanguard\Models\userRegistrations;
use Illuminate\Support\Facades\View;
use Vanguard\Http\Requests\studentRegistration\studentRegistration;
use Vanguard\Models\EmailsQueue;
use Vanguard\Models\EmailTemplate;
use Illuminate\Support\Facades\Crypt;
use Vanguard\Repositories\User\UserRepository;

use Vanguard\User;
use Illuminate\Support\Facades\DB;

class StudentRegistrationController extends Controller
{
    public function __construct(private UserRepository $users)
    {
    }
    public function index()
    {
        return view('frontend.index');
    }
    public function createRegister(Request $request)
    {
        $counsellers = DB::table('users')->select('id', 'first_name')->where('role_id', 5)->get();
        $countries = DB::table('countries')->select('id', 'name')->get();
        $centers = DB::table('centers')->select('*')->where('status', 1)->get();
        return view('frontend.register.studentRegistration', ['countries' => $countries, 'centers' => $centers, "edit" => false, 'counsellers' => $counsellers]);
    }

    public function postRegister(Request $request)
    {

        $rules = array(
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'courses' => 'required',
            'centers' => 'required',
            'password' => 'min:5|required_with:confirmPassword|same:confirmPassword',
            'password_confirmation' => 'min:5'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if ($request->paymentType != "lumpsum" && $request->paymentType != "installment") {
            $validator->errors()->add('paymentType', 'You haven"t select the payment type please re fill the form and select payment type !');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $feeData = DB::table('fee_plans')
            ->where('course_id', $request['courses'])
            ->where('fee_type', $request['paymentType'])
            ->get();

        $users = new User();
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = $request->password;
        $users->role_id = 3;
        $users->status = "Active";
        $users->save();
        $student_id = $users->id;
        $user_reg_id = null;
        if ($student_id) {
            $user_registration = new userRegistrations();
            $user_registration->user_id = $student_id;
            $user_registration->student_registration_code = $student_id;
            $user_registration->center_id = $request->centers;
            $user_registration->course_id = $request->courses;
            $user_registration->counsellor_id = $request->counsellor_id;
            $user_registration->selected_fee_type = $feeData[0]->fee_type;
            $user_registration->total_bill_amount = $feeData[0]->total_fee;
            $user_registration->total_payable_amount = $feeData[0]->total_fee;
            $user_registration->total_due_amount = 0;
            $user_registration->amount_paid = 0;
            $user_registration->discount_value = 0;
            $user_registration->feePlan_id = $feeData[0]->id;
            $user_registration->registration_status = "pending";
            $user_registration->PaymentStatus = 0;
            $user_registration->status = 1;
            $user_registration->save();
            $user_reg_id = $user_registration->id;
        }



        if ($user_reg_id) {
            if ($feeData[0]->fee_type == "installment") {
                $installments = DB::table('installments')
                    ->where('fee_plan_id', $feeData[0]->id)
                    ->get();
                foreach ($installments as $installment) {
                    $installments = new StudentInstallmentFeePlan([
                        'user_registration_id' => $user_reg_id,
                        'fee_plan_id' => $installment->fee_plan_id,
                        'installment_amount' => $installment->installment_amount,
                        'due_time' => $installment->due_time,
                        'paid_amount' => 0,
                        'created_by' => $student_id,
                    ]);
                    $installments->save();
                }
            }
        }


        if ($user_reg_id) {
            $address = new StudentAddress();
            $address->user_id = $student_id;
            $address->type = 'home';
            $address->address1 = $request->address;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->pin_code = $request->pin_code;
            $address->created_by = $student_id;
            $address->save();
        }


        $UploadedDocumentId = null;
        if ($request->file('10_th_marksheet_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['10_th_marksheet_file'][0]->getClientOriginalName();
            $filePath = $request->file('10_th_marksheet_file')[0]->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['10_th_marksheet_file'][0]->getClientOriginalName();
            $UploadedDocuments->user_id = $student_id;
            $UploadedDocuments->created_by = $student_id;
            $UploadedDocuments->save();
            $UploadedDocumentId = $UploadedDocuments->id;
        } else {
            $UploadedDocumentId = null;
        }



        // $UploadedDocumentsId = $UploadedDocuments;
        if ($request['10_th_marksheet']) {
            $userAcademics = new UserAcedmic();
            $userAcademics->user_id = $student_id;
            $userAcademics->qualification = "10";
            $userAcademics->institute = $request['10_th_marksheet'][0];
            $userAcademics->university = $request['10_th_marksheet'][1];
            $userAcademics->passout_year = $request['10_th_marksheet'][2];
            $userAcademics->marks = $request['10_th_marksheet'][3];
            $userAcademics->place = $request['10_th_marksheet'][4];
            $userAcademics->certificate_id = $UploadedDocumentId;
            $userAcademics->created_by = $student_id;
            $userAcademics->save();
        }




        if ($request->file('12_th_marksheet_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['12_th_marksheet_file'][0]->getClientOriginalName();
            $filePath = $request->file('12_th_marksheet_file')[0]->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['12_th_marksheet_file'][0]->getClientOriginalName();
            $UploadedDocuments->user_id = $student_id;
            $UploadedDocuments->created_by = $student_id;
            $UploadedDocuments->save();
            $UploadedDocumentId = $UploadedDocuments->id;
        } else {
            $UploadedDocumentId = null;
        }
        if ($request['12_th_marksheet']) {
            $userAcademics = new UserAcedmic();
            $userAcademics->user_id = $student_id;
            $userAcademics->qualification = "12";
            $userAcademics->institute = $request['12_th_marksheet'][0];
            $userAcademics->university = $request['12_th_marksheet'][1];
            $userAcademics->passout_year = $request['12_th_marksheet'][2];
            $userAcademics->marks = $request['12_th_marksheet'][3];
            $userAcademics->place = $request['12_th_marksheet'][4];
            $userAcademics->certificate_id = $UploadedDocumentId;
            $userAcademics->created_by = $student_id;
            $userAcademics->save();
        }



        if ($request->file('graduation_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['graduation_file'][0]->getClientOriginalName();
            $filePath = $request->file('graduation_file')[0]->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['graduation_file'][0]->getClientOriginalName();
            $UploadedDocuments->user_id = $student_id;
            $UploadedDocuments->created_by = $student_id;
            $UploadedDocuments->save();
            $UploadedDocumentId = $UploadedDocuments->id;
        } else {
            $UploadedDocumentId = null;
        }

        if ($request['graduation']) {
            $userAcademics = new UserAcedmic();
            $userAcademics->user_id = $student_id;
            $userAcademics->qualification = "graduation";
            $userAcademics->institute = $request['graduation'][0];
            $userAcademics->university = $request['graduation'][1];
            $userAcademics->passout_year = $request['graduation'][2];
            $userAcademics->marks = $request['graduation'][3];
            $userAcademics->place = $request['graduation'][4];
            $userAcademics->certificate_id = $UploadedDocumentId;
            $userAcademics->created_by = $student_id;
            $userAcademics->save();
        }


        if ($request->file('post_graduation_file')) {
            $UploadedDocuments = new UploadedDocuments();
            $fileName = time() . '_' . $request['post_graduation_file'][0]->getClientOriginalName();
            $filePath = $request->file('post_graduation_file')[0]->storeAs('uploads', $fileName, 'public');
            $UploadedDocuments->document = time() . '_' . $request['post_graduation_file'][0]->getClientOriginalName();
            $UploadedDocuments->user_id = $student_id;
            $UploadedDocuments->created_by = $student_id;
            $UploadedDocuments->save();
            $UploadedDocumentId = $UploadedDocuments->id;
        } else {
            $UploadedDocumentId = null;
        }
        if ($request['post_graduation']) {
            $userAcademics = new UserAcedmic();
            $userAcademics->user_id = $student_id;
            $userAcademics->qualification = "post_graduation";
            $userAcademics->institute = $request['post_graduation'][0];
            $userAcademics->university = $request['post_graduation'][1];
            $userAcademics->passout_year = $request['post_graduation'][2];
            $userAcademics->marks = $request['post_graduation'][3];
            $userAcademics->place = $request['post_graduation'][4];
            $userAcademics->certificate_id = $UploadedDocumentId;
            $userAcademics->created_by = $student_id;
            $userAcademics->save();
        }

        if (auth()->user()) {
            if (auth()->user()->role_id != 3) {
                $email_details = EmailTemplate::where('email_type', 'registered_by_admin')->get()->first();
                $path = resource_path() . '/views/email/template.blade.php';
                $file = fopen($path, "w");
                fwrite($file, $email_details->template);
                fclose($file);
                $create_password = route('user.create.password', Crypt::encrypt($student_id));
                $body = view('email/template', compact('create_password'))->render();
                $mail_from = $email_details->from_mail;
                $mail_to = $users->email;

                $queue_email = new EmailsQueue();
                $queue_email->from_mail = $mail_from;
                $queue_email->to_mail = $mail_to;
                $queue_email->subject = 'Create Your Password - ' . setting('app_name');
                $queue_email->body = $body;
                $queue_email->save();
                return redirect()->route('userRegistrations.index')->with('message', 'you have registered successfully');
            }
        } else {
            event(new Registered($users));
        }
        return redirect()->route('user.createRegister')->with('message', 'you have registered successfully');
    }


    public function getCourseByCenterId()
    {
        $courses = DB::table('assign_course_centers')
            ->leftJoin('courses', 'courses.id', '=', 'assign_course_centers.course_id')
            ->select('assign_course_centers.*', 'courses.course_name')
            ->where('assign_course_centers.center_id', $_GET['centerId'])
            ->where('courses.status', 1)
            ->get();

        return response()->json(['success' => true, 'courses' => $courses]);
    }

    public function getCourseById()
    {

        $courses = DB::table('courses')->select('*')->where(['id' => $_GET['courseId']])->get();
        return response()->json(['courses' => $courses]);
    }



    public function getFeePlan()
    {
        $feeData = DB::table('fee_plans')
            ->select('fee_plans.*', 'courses.course_name', 'courses.course_description')
            ->leftJoin('courses', 'courses.id', '=', 'fee_plans.course_id')
            ->where(['fee_plans.course_id' => $_GET['courseId'], 'fee_plans.fee_type' => $_GET['feePlanType']])
            ->get();

        $feedetails = DB::table('fee_plan_details')
            ->leftJoin('fee_heads', 'fee_heads.id', '=', 'fee_plan_details.fee_head_id')
            ->select('fee_plan_details.*', 'fee_heads.fee_heads_title')
            ->where('fee_plan_id', $feeData[0]->id)
            ->get();

        $installments = DB::table('installments')
            ->where('fee_plan_id', $feeData[0]->id)
            ->get();

        $template = View::make('frontend.feePlan.feePlan', ['feeData' => $feeData, 'feedetails' => $feedetails], ['installments' => $installments])->render();

        return json_encode(['success' => true, 'template' => $template]);
    }
    public function editRegister(Request $request, $id)
    {
        $user = DB::table('users')
            ->leftJoin('student_addresses', 'student_addresses.user_id', '=', 'users.id')
            ->select('users.*', 'student_addresses.*')
            ->where('student_addresses.user_id', $id)->first();
        $userDetails = DB::table('user_registrations')
            ->select('user_registrations.*')
            ->where('user_registrations.user_id', $id)
            ->first();
        //dd($userDetails);
        $userAcademics = DB::table('user_acedmics')
            ->select('user_acedmics.*')
            ->where('user_acedmics.user_id', $id)
            ->get();
        //dd($userAcademics);
        $countries = DB::table('countries')->select('id', 'name')->get();
        $centers = DB::table('centers')->select('*')->get();
        $courses = DB::table('courses')->select('*')->get();
        $states = DB::table('states')->select('id', 'name')->get();
        $cities = DB::table('cities')->select('id', 'city')->get();
        return view('frontend.register.editRegistration', [
            'countries' => $countries,
            'centers' => $centers,
            'user' => $user,
            'states' => $states,
            'cities' => $cities,
            'userDetails' => $userDetails,
            'courses' => $courses

        ]);
    }

    // Show create password form to student if registered by admin
    public function showCreatePassword(Request $request, $user_id)
    {
        $student_id = Crypt::decrypt($user_id);
        $user = User::where('id', $student_id)->get()->first();
        // dd($user);
        return view('frontend.register.createPassword', compact('user'));
    }

    public function updatePassword(CreatePassword $request, $student_id)
    {
        $student_id = Crypt::decrypt($student_id);
        $data = $request->all();
        if ($data['password']) {
            unset($data['confirm-password']);
            unset($data['_token']);
            unset($data['_method']);
        }
        $data = $data + ['email_verified_at' => now()];
        // dd($data);
        $users = $this->users->update($student_id, $data);
        $credentials = ['email' => $users->email, 'password' => $data['password']];

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user, setting('remember_me') && $request->get('remember'));
        return redirect()->to('/')->with('message', 'Password Change Successfuly');
    }
}