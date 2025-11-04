<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendBirthdaySms;
use DB;
use Illuminate\Support\Facades\Log;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        \Log::info('Scheduler running at: '.now()->toDateTimeString());
        // $schedule->call(function () {   
        // $hospitalName=DB::table('wsec_hospital')->select('hospital_name')->value('hospital_name');    
        // $patients = DB::table('patn_registration')
        //     ->select('mobile1')
        //     ->whereMonth('DOB', now()->month) 
        //     ->whereDay('DOB', now()->day)    
        //     ->get();

        //     foreach ($patients as $p) {
        //         $msg = "Happy Birthday! 🎉 From your". $hospitalName;
        //         SendBirthdaySms::dispatch($p->mobile1, $msg)->onQueue('sms');
        //     }
        // })
        // ->dailyAt('00:01')
        // ->timezone('Asia/Dhaka')
        // ->description('Send birthday greetings to patients');

        $schedule->command('sms:birthday')
        // ->dailyAt('00:01')
        ->timezone('Asia/Dhaka')
        ->withoutOverlapping() // Prevent multiple runs
        ->sendOutputTo(storage_path('logs/birthday_sms.log')); // Log output
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
