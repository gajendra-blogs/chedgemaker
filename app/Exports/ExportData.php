<?php

namespace Vanguard\Exports;

use Vanguard\Models\Center;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportData implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function __construct($query = null, $id = null)
    {
        $this->query = $query;
        $this->id = $id;
    }
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        if ($this->query == "allStudents") {
            return [
                'id',
                'Username',
                'email',
                'Phone',
                'Status'
            ];
        }
        if ($this->query == "bookedStudents" || $this->query == "registeredStudents" || $this->query == "downPaymentStudents") {
            return [
                'id',
                'Username',
                'Email',
                'Phone',
                'Status',
                'Registration Code',
                'Center Name',
                'Course Name',
                'Fee Type',
                'Total Bill Amount',
                'Total Due Amount',
                'Amount Paid',
                'Discount Value',
                'Registration Status',
                'Discount Approve Status'
            ];
        }
        if ($this->query == "centerWiseStudents") {
            return [
                'Student ID',
                'Usename',
                'Email',
                'Phone',
                'Status',
                'Center'
            ];
        }

        // $heading = DB::getSchemaBuilder()->getColumnListing($this->table);
        // return $heading;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        if ($this->query == "allStudents") {
            $students = DB::table('users')
                ->select('id', 'username', 'email', 'phone', 'status')
                ->where('role_id', 3)
                ->get();
            return $students;
        }
        if ($this->query == "bookedStudents") {
            $students = DB::table('users')
                ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
                ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
                ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
                ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
                ->where('role_id', 3)
                ->where('registration_status', 'booked')
                ->get();
            return $students;
        }
        if ($this->query == "registeredStudents") {
            $students = DB::table('users')
                ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
                ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
                ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
                ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
                ->where('role_id', 3)
                ->where('registration_status', 'pending')
                ->get();
            return $students;
        }
        // if ($this->query == "downPaymentStudents") {
        //     $students = DB::table('users')
        //         ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
        //         ->leftJoin('centers', 'user_registrations.center_id', '=', 'centers.id')
        //         ->leftJoin('courses', 'user_registrations.course_id', '=', 'courses.id')
        //         ->leftJoin('student_installment_fee_plans', 'student_installment_fee_plans.user_registration_id', '=', 'user_registrations.id')
        //         ->select('users.id as student_id', 'users.username', 'users.email', 'users.phone', 'users.status', 'student_registration_code', 'center_name', 'course_name', 'selected_fee_type', 'total_bill_amount', 'total_due_amount', 'amount_paid', 'discount_value', 'registration_status', 'discountApproveStatus')
        //         ->where('role_id', 3)
        //         ->where('registration_status', 'pending')
        //         ->where('due_time', 0)
        //         ->get();
        //     return $students;
        // }
        // if ($this->query == "centerWiseStudents") {
        //     $students = DB::table('users')
        //         ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
        //         ->leftJoin('centers', 'centers.id', '=', 'user_registrations.center_id')
        //         ->select('users.id as student_id', 'username', 'email', 'phone', 'users.status', 'centers.center_name')
        //         ->where('role_id', 3)
        //         ->where('user_registrations.center_id', $this->id)
        //         ->get();
        //     return $students;
        // }
    }
}