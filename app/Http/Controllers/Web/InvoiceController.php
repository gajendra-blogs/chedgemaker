<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use DB;
use PDF;

class InvoiceController extends Controller
{
    public function getPaymentInvoice(Request $request , $payment_id)
    {
        $invoice_details = DB::table('payments')
                        ->leftJoin('user_registrations', 'user_registrations.id', '=', 'payments.user_registration_id')
                        ->leftJoin('users' , 'users.id' , '=' , 'user_registrations.user_id')
                        ->leftJoin('centers' , 'user_registrations.center_id' , '=' , 'centers.id')
                        ->leftJoin('courses' , 'user_registrations.course_id' , '=' , 'courses.id')
                        ->select('payments.*', 'user_registrations.*' , 'users.*', 'users.id as users_id' , 'payments.status as payments_status' , 'user_registrations.id as registration_id' , 'payments.id as payment_id' , 'users.created_at as users_created_at' , 'users.updated_at as users_updated_at' , 'user_registrations.created_at as user_registrations_created_at' , 'user_registrations.status as user_registrations_status' , 'users.status as users_status' ,'user_registrations.updated_by as user_registrations_updated_by' , 'payments.created_at as payments_created_at' , 'payments.updated_at as payments_updated_at' , 'payments.created_by as payments_created_by' , 'payments.updated_by as payments_updated_by' , 'centers.center_name' , 'courses.course_name')
                        ->where('payments.id' , $payment_id)
                        ->get()->first();
        $data = ['generated_at' => now()->format('d-m-Y') , 'invoice_details' => $invoice_details ];
        $pdf = PDF::loadView('pdf.invoice.paymentInvoice' , $data);
        return $pdf->download('invoice.pdf');
        return view('pdf.invoice.paymentInvoice' , $data);
    }
}
