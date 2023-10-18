<?php
    
namespace Vanguard\Console;

use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Vanguard\Jobs\SendQueuedMail;
use Illuminate\Support\Stringable;
use Vanguard\Jobs\NotifyInstallmentDues;
use PHPUnit\Framework\CoveredCodeNotExecutedException;
use Throwable;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];
      
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new NotifyInstallmentDues)->everyMinute();
        $schedule->job(new SendQueuedMail)->everyMinute()
        ->onFailure(function (Exception $error){
            \Log::error('ERROR IN '. $error);
        })
        ->before(function(Stringable $before){
            \Log::info('SendQueuedMail scheduler is Started at '. now()->format('Y-m-d h:i:s'));
        })
        ->after(function(Stringable $after){
            \Log::info('SendQueuedMail scheduler is End at '. now()->format('Y-m-d h:i:s'));
        });;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}