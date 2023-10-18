<?php

namespace Vanguard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use PgSql\Lob;
use Vanguard\Mail\NotifyInstallmentDuesMail;
use Vanguard\Models\StudentInstallmentFeePlan;
use Vanguard\Models\UserRegistrations;
use Vanguard\User;
use Vanguard\Models\Course;
use Vanguard\Models\EmailsQueue;
use Vanguard\Models\EmailTemplate;
use View;
use Storage;

class NotifyInstallmentDues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $due_days = 0;
        $allInstallments = StudentInstallmentFeePlan::all()->groupBy('user_registration_id')->toArray();
        foreach ($allInstallments as $key => $value) {
            $current_user_registration = UserRegistrations::where('id', $key)->get()->first()->toArray();
            if($current_user_registration['registration_status'] == 'booked')
            {
                // foreach ($value as $installment_key => $each_installments) {
                //     if ($each_installments['status'] == 'paid') {
                //         $due_days = $due_days + $each_installments['due_time'];
                //         \Log::info($due_days);
                //     }
                // }
                foreach ($value as $installment_key => $each_installments) {
                    $due_days = $due_days + $each_installments['due_time'];
                    if ($each_installments['status'] == 'pending') {
                        $due_days = $due_days + $each_installments['due_time'];
                        $next_due_date = date('d-m-Y', strtotime($current_user_registration['booked_on'] . ' +' . $due_days . ' days'));
                        $datetime1 = date_create(now());
                        $datetime2 = date_create($next_due_date);
                        $interval = date_diff($datetime1, $datetime2);
                        // $file = \File::get($path);
                        $course = Course::where('id' , $current_user_registration['course_id'])->get()->first();
                        $user = User::where('id' , $current_user_registration['user_id'])->get()->first();
                        $template_data = ['installment' => $each_installments , 'user' => $user , 'user_registration' => $current_user_registration , 'due_date' => $datetime2 , 'course' => $course];

                        if ($interval->days <= setting('notify_due_date')) {
                            $email_details = EmailTemplate::where('email_type' , 'installment_due')->get()->first();
                            $path = resource_path() . '/views/email/template.blade.php';
                            $file = fopen($path, "w");
                            fwrite($file, $email_details->template);
                            \Log::info($file);
                            fclose($file);
                            $body = View('email/template' , $template_data)->render();
                            $mail_from = $email_details->from_mail;
                            $mail_to = $user->email;

                            $queue_email = new EmailsQueue();
                            $queue_email->from_mail = $mail_from;
                            $queue_email->to_mail = $mail_to;
                            $queue_email->subject = 'Complete Your Installment Due - '. setting('app_name');
                            $queue_email->body = $body;
                            $queue_email->save();
                        }
                        break;
                    }
                }
            }
        }
    }

    public function failed(\Throwable $throwable)
    {
        \Log::error('Error in '.$throwable->getFile().' is '.$throwable->getMessage() .' on line NO '. $throwable->getLine());
    }
}
