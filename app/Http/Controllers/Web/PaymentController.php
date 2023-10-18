<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Razorpay\Api\Api;
use Vanguard\Models\userRegistrations;
use Vanguard\Models\StudentInstallmentFeePlan;
use Vanguard\Models\EmailTemplate;
use Vanguard\Models\EmailsQueue;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as Input;

use Auth;
use Session;
use Redirect;

use Vanguard\Models\Payment;

class PaymentController extends Controller
{

    public function orderIdGenerate(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create(array('receipt' => $request->registrationId, 'amount' => $request->amount * 100, 'currency' => 'INR')); // Creates order
        return response()->json(['order_id' => $order['id']]);
    }
    public function payment(Request $request)
    {

        $input = $request->all();
        // echo "<pre>";
        // print_r($input);
        // die();
        if (isset($input['installment_id']) && isset($input['registration_id'])) {
            if (count($input) && !empty($input['razorpay_payment_id'])) {

                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $response = $api->payment->fetch($input['razorpay_payment_id']);

                try {
                    // Payment detail save in database
                    $payment = new Payment;
                    $payment->user_registration_id = $input['registration_id'];
                    $payment->transaction_id = $response['id'];
                    $payment->amount = $response['amount'] / 100;
                    $payment->description = $response['description'];
                    $payment->status = $response['status'];
                    $payment->payment_method = $response['method'];
                    $payment->bank = $response['bank'];
                    $payment->wallet = $response['wallet'];
                    $payment->bank_transaction_id = $request->bank_transaction_id;
                    $payment->bank_check_date = $request->bank_check_date;
                    $payment->created_by = Auth::user()->id;
                    $res = $payment->save();

                    $amount = $response['amount'] / 100;
                    if ($res && $response['status'] == 'captured') {
                        $status = "booked";

                        $registrationData = userRegistrations::find($input['registration_id']);
                        $newpaidamount = $amount + $registrationData->amount_paid;
                        if ($registrationData->amount_paid == 0) {
                            $booked_on = date("Y-m-d");
                            $registrationData->booked_on = $booked_on;
                        }
                        if ($registrationData->amount_paid + $amount == $registrationData->total_payable_amount) {
                            $status = "registered";
                        }
                        $registrationData->amount_paid = $registrationData->amount_paid + $amount;
                        $registrationData->registration_status = $status;
                        $registrationData->total_due_amount = $registrationData->total_payable_amount - $newpaidamount;
                        $regData = $registrationData->save();
                        if ($regData && $input['installment_id'] != 0) {
                            $status = "pending";
                            $updateStudentDownPayment = StudentInstallmentFeePlan::find($input['installment_id']);
                            if ($updateStudentDownPayment->installment_amount == $updateStudentDownPayment->paid_amount + $amount) {
                                $status = "paid";
                            }

                            $updateStudentDownPayment->paid_amount = $updateStudentDownPayment->paid_amount + $amount;
                            $updateStudentDownPayment->status = $status;
                            $ressss = $updateStudentDownPayment->save();

                            if ($ressss) {
                                Session::flash('success', 'Payment is done successfully');
                                $this->sendPaymentSuccessMail($res, $payment, $registrationData, $response, $updateStudentDownPayment);
                                return redirect()->back();
                            } else {
                                Session::flash('error', 'something went wrong,installment is not paid!');
                                return redirect()->back();
                            }
                        } else {
                            Session::flash('success', 'Payment is done successfully');
                            $this->sendPaymentSuccessMail($res, $payment, $registrationData, $response);
                            return redirect()->back();
                        }
                    } else {
                        Session::flash('error', 'something went wrong, payment is not captured!');
                        return redirect()->back();
                    }
                } catch (\Exception $e) {

                    Session::flash('error', $e->getMessage());
                    return redirect()->back();
                }
            } else {
                Session::flash('error', 'Unautherized Access!!!');
                return redirect()->back();
            }
        } else {
            Session::flash('error', 'Unautherized Access!!!');
            return redirect()->back();
        }
    }

    public function offlinePayment(Request $request)
    {

        $rules = array(
            'payment_method' => 'required',
            'transaction_id' => 'required',
            'amount' => 'required',
            'screenshot' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $offline = new Payment();
        $offline->user_registration_id = $request->registration_id;
        $offline->payment_method = $request->payment_method;
        $offline->transaction_id = $request->transaction_id;
        $offline->bank = $request->bank;
        $offline->bank_check_date = $request->bank_check_date;
        $offline->amount = $request->amount;
        $offline->remarks_received = $request->remarks_received;
        $offline->created_by = Auth::user()->id;
        if ($request->file('screenshot')) {
            $fileName = time() . '_' . $request->file('screenshot')->getClientOriginalName();
            $filePath = $request->file('screenshot')->storeAs('payments', $fileName, 'public');
            $offline->screenshot = $fileName;
        }
        $offline->save();
        Session::flash('success', 'Payment Details is submit successfully');
        return redirect()->back();
    }

    protected function sendPaymentSuccessMail($res, $payment, $registrationData, $response, $updateStudentDownPayment = null)
    {
        if ($response['status'] == 'captured') {
            $users = auth()->user();
            $email_template_details = EmailTemplate::where('email_type' , 'payment_success')->get()->first();
            $path = resource_path() . '/views/email/template.blade.php';
            $file = fopen($path, "w");
            fwrite($file, $email_template_details->template);
            fclose($file);
            $data = ['user' => $users , 'payments_details' => $payment];
            $body = view('email/template', $data)->render();
            $mail_from = $email_template_details->from_mail;
            $mail_to = $users->email;

            $queue_email = new EmailsQueue();
            $queue_email->from_mail = $mail_from;
            $queue_email->to_mail = $mail_to;
            $queue_email->subject = 'Payment Successfull - ' . setting('app_name');
            $queue_email->body = $body;
            $queue_email->save();
        }
    }

    public function alltransactions()
    {
        $transactions = DB::table('payments')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'payments.user_registration_id')
            ->leftJoin('users', 'users.id', '=', 'payments.user_registration_id')
            ->select('payments.*', 'users.email')->paginate(10);
        return view('transactions.list', compact('transactions'));
    }
}