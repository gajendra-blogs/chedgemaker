<?php

namespace Vanguard\Http\Controllers\web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Vanguard\Exports\ExportData;


class CommonController extends Controller
{
    public function index()
    {
        $allStudents = DB::table('users')
            ->select('id', 'username', 'email', 'phone', 'status', 'first_name', 'last_name')
            ->where('role_id', 3)
            ->get();

        $allStudentCount = $allStudents->count();

        $bookedStudents = DB::table('users')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
            ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
            ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
            ->where('role_id', 3)
            ->where('registration_status', 'booked')
            ->get();
        $allBookedStudentsCount = $bookedStudents->count();

        $registeredStudents = DB::table('users')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
            ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
            ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
            ->where('role_id', 3)
            ->where('registration_status', 'pending')
            ->get();
        $registeredStudentsCount = $registeredStudents->count();
        $downPaymentStudents = DB::table('users')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
            ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
            ->leftJoin('student_installment_fee_plans', 'student_installment_fee_plans.user_registration_id', '=', 'user_registrations.id')
            ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
            ->where('role_id', 3)
            ->where('registration_status', 'pending')
            ->where('due_time', 0)
            ->get();
        $downPaymentStudentCounts = $downPaymentStudents->count();
        $centerWiseStudents = DB::table('users')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
            ->select('users.id as student_id', 'username', 'email', 'phone', 'users.status', 'centers.center_name')
            ->where('role_id', 3)
            ->where('user_registrations.center_id')
            ->get();
        $centerWiseStudentCount = $centerWiseStudents->count();
        return view('reports/index', compact('allStudents', 'downPaymentStudentCounts', 'allStudentCount', 'bookedStudents', 'allBookedStudentsCount', 'registeredStudentsCount', 'centerWiseStudentCount'));
    }
    public function reports(Request $request, $query, $id = null)
    {
        return Excel::download(new ExportData($query, $id), $query . '.csv');
    }

}