<?php

namespace Vanguard\Http\Controllers\web\userRegistrations;

use Illuminate\Http\Request;
use Razorpay\Api\Payment;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Events\ActivityLogEvents\Created;
use Vanguard\Models\userRegistrations;
use Vanguard\Models\StudentInstallmentFeePlan;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;
use Vanguard\Models\Payment as PaymentModel;

class UserRegistration extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        $studentType = null;
        $typeValue = null;
        $selectedStudentType = "allStudents";
        if ($request->searchStudents == "registeredStudents") {
            $selectedStudentType = "registeredStudents";
            $studentType = "registration_status";
            $typeValue = "pending";
        }
        if ($request->searchStudents == "bookedStudents") {
            $selectedStudentType = "bookedStudents";
            $studentType = "registration_status";
            $typeValue = "booked";
        }


        $registrationData = DB::table('user_registrations')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('courses', 'courses.id', '=', 'user_registrations.course_id')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->select('user_registrations.*', 'user_registrations.id AS enroll_id', 'users.*', 'centers.center_name', 'courses.course_name')
            ->where('users.role_id', 3)
            ->where('email', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
            ->orWhere('user_registrations.student_registration_code', 'LIKE', '%' . $request->search . '%')->where('users.role_id', 3)
            ->orWhere('first_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
            ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
            ->orWhere('phone', 'LIKE', '%' . $request->search . '%')->where('role_id', 3)
            ->orderBy($request->column ? Crypt::decrypt($request->column) : 'users.email', $request->order ? $request->order : 'asc');
        if ($request->searchStudents == "registeredStudents" || $request->searchStudents == "bookedStudents") {
            $registrationData->where($studentType, 'LIKE', '%' . $typeValue . '%');
        }
        $registrationsList = $registrationData->paginate(10);

        if ($request->order && $request->column) {
            return view('userRegistrations.table', compact('registrationsList'));
        }



        $data = [
            'registrationsList' => $registrationsList,
            'selectedStudentType' => $selectedStudentType
        ];
        return view('userRegistrations.list', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counsellers = DB::table('users')->select('id', 'first_name')->where('role_id', 5)->get();
        $countries = DB::table('countries')->select('id', 'name')->get();
        $centers = DB::table('centers')->select('*')->get();
        return view('userRegistrations.adminpanel.registration', ['countries' => $countries, 'centers' => $centers, 'counsellers' => $counsellers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $registrationData = DB::table('user_registrations')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('courses', 'courses.id', '=', 'user_registrations.course_id')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->leftJoin('fee_plans', 'fee_plans.id', '=', 'user_registrations.feePlan_id')
            ->select('user_registrations.*', 'user_registrations.id AS enroll_id', 'users.*', 'centers.center_name', 'courses.course_name', 'fee_plans.name')
            ->where('user_registrations.id', $id)
            ->get();
        $userInstallments = DB::table('student_installment_fee_plans')
            ->select('*')
            ->where('user_registration_id', $id)
            ->get();

        $paymentHistory = DB::table('payments')
            ->leftJoin('users', 'users.id', '=', 'payments.updated_by')
            ->select('payments.*', 'users.first_name', 'users.last_name')
            ->where('user_registration_id', $id)
            ->get();

        //dd($paymentCaptured);
        $data = [
            'registrationsDetail' => $registrationData,
            'userInstallments' => $userInstallments,
            'paymentHistory' => $paymentHistory
        ];

        return view('userRegistrations.viewRegistration', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $data = $request->all();
        $registrationData = DB::table('user_registrations')
            ->where('id', $id)
            ->get();

        $res = StudentInstallmentFeePlan::where('user_registration_id', $id)->delete();
        $paidAmount = 0;
        $restAmount = 0;
        $status = 'pending';
        if ($registrationData[0]->amount_paid != 0) {
            if ($registrationData[0]->amount_paid < $request->DownPayment) {
                $paidAmount = $registrationData[0]->amount_paid;

            } elseif ($registrationData[0]->amount_paid == $request->DownPayment) {
                $paidAmount = $registrationData[0]->amount_paid;
                $status = 'paid';
            } else {
                $paidAmount = $request->DownPayment;
                $restAmount = $registrationData[0]->amount_paid - $request->DownPayment;
                $status = 'paid';
            }
        }
        $newInstallments = new StudentInstallmentFeePlan([
            'user_registration_id' => $id,
            'installment_amount' => $request->DownPayment,
            'due_time' => 0,
            'paid_amount' => $paidAmount,
            'status' => $status,
            'created_by' => Auth::user()->id,
        ]);
        $newInstallments->save();

        for ($i = 1; $i < $data["totalStudentsInstallments"] + 1; $i++) {
            $paid = 0;
            $status = 'pending';
            if ($restAmount <= $data['Installment' . $i]) {
                $paid = $restAmount;
                $restAmount = 0;
            } else {
                $paid = $data['Installment' . $i];
                $status = 'paid';
                $restAmount = $restAmount - $data['Installment' . $i];
            }
            $newInstallments = new StudentInstallmentFeePlan([
                'user_registration_id' => $id,
                'installment_amount' => $data['Installment' . $i],
                'due_time' => $data['dueInstallment' . $i],
                'paid_amount' => $paid,
                'status' => $status,
                'created_by' => Auth::user()->id,
            ]);
            $res = $newInstallments->save();
        }
        if ($res) {
            return response()->json(['type' => 'success', 'message' => 'Student Installments updated  Successfully for this registeration']);
        } else {
            return response()->json(['type' => 'warning', 'message' => 'Something went wrong,try again.']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $count = StudentInstallmentFeePlan::where(['user_registration_id' => $id])->count();
        if ($count > 0) {
            StudentInstallmentFeePlan::where('user_registration_id', $id)->delete();
        }
        $registrationData = userRegistrations::find($id);
        $res = $registrationData->delete();
        if ($res) {
            event(new Created("User Registration Record of primary id " . $id . "is deleted"));
            return redirect()->back()->with('success', 'User Registration Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'User Registration Not Deleted');
        }
    }

    public function updateDiscount(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $newDiscount = $request->newDiscount;
        $userRegistrations = userRegistrations::find($id);
        $userRegistrations->newDiscount = $newDiscount;
        $userRegistrations->discountApproveStatus = 'pending';
        $res = $userRegistrations->save();
        if ($res) {
            return response()->json(['type' => 'success', 'message' => 'Discount is Added Successfully for this registeration,it will reflect after approvement']);
        } else {
            return response()->json(['type' => 'warning', 'message' => 'something went wrong,try again.']);

        }

    }

    public function ApproveDiscount(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $userRegistrations = userRegistrations::find($id);
        $userRegistrations->discountApproveStatus = 'approved';
        $userRegistrations->discount_value = $userRegistrations->newDiscount;
        $userRegistrations->total_payable_amount = $userRegistrations->total_bill_amount - $userRegistrations->newDiscount;
        if ($userRegistrations->amount_paid == 0) {
            $userRegistrations->total_due_amount = $userRegistrations->total_payable_amount;
        }
        $res = $userRegistrations->save();
        if ($res) {
            return response()->json(['type' => 'success', 'message' => 'Discount is Approved Successfully for this registeration']);
        } else {
            return response()->json(['type' => 'warning', 'message' => 'Something went wrong,try again.']);

        }

    }

    public function CencelDiscount(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $userRegistrations = userRegistrations::find($id);
        $userRegistrations->discountApproveStatus = 'cenceled';
        $res = $userRegistrations->save();
        if ($res) {
            return response()->json(['type' => 'success', 'message' => 'Discount is Cenceled Successfully for this registeration']);
        } else {
            return response()->json(['type' => 'warning', 'message' => 'Something went wrong,try again.']);

        }

    }
    public function updateStudentPaymentStatus(Request $request)
    {
        $id = $request->id;
        $newStatus = $request->newStatus;
        $studentRegistrationId = $request->studentRegistrationId;
        $payments = PaymentModel::find($id);
        $amount = $payments->amount;
        $payments->status = $newStatus;
        $payments->updated_by = Auth::user()->id;
        $captured = $payments->save();
        if ($payments->status == 'captured') {
            $userReistration = userRegistrations::find($studentRegistrationId);
            $newAmountPaid = $userReistration->amount_paid + $amount;
            $userReistration->amount_paid = $newAmountPaid;
            $newDueAmount = $userReistration->total_payable_amount - $userReistration->amount_paid;
            $userReistration->total_due_amount = $newDueAmount;
            $res = $userReistration->save();
        }
        if ($captured) {
            return response()->json(['type' => 'success', 'message' => 'Offline Payment Status is changed']);
        } else {
            return response()->json(['type' => 'warning', 'message' => 'something went wrong,try again.']);
        }
    }
}