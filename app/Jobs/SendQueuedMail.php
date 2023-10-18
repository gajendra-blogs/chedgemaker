<?php

namespace Vanguard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vanguard\Mail\NotifyInstallmentDuesMail;
use Mail;
use PhpParser\Node\Stmt\TryCatch;
use Vanguard\Models\EmailsQueue;

class SendQueuedMail implements ShouldQueue
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
        try {
            $all_queued_mails = EmailsQueue::all()->toArray();
            foreach ($all_queued_mails as $key => $value) {
                if ($value['status'] != 'sent') {
                    $mail_data = ['subject' => $value['subject'], 'from' => $value['from_mail'], 'body' => $value['body']];
                    Mail::to($value['to_mail'])->send(new NotifyInstallmentDuesMail($mail_data));
                    if (Mail::flushMacros()) {
                        $current_queued_email = EmailsQueue::findOrFail($value['id']);
                        $current_queued_email->update(['status' => 'failed']);
                    } else {
                        $current_queued_email = EmailsQueue::findOrFail($value['id']);
                        $current_queued_email->update(['status' => 'sent']);
                    }
                }
            }
        } catch (\Exception  $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function failed(\Throwable $throwable)
    {
        \Log::error('Error in '.$throwable->getFile().' is '.$throwable->getMessage().' on line NO '. $throwable->getLine());
    }
}
