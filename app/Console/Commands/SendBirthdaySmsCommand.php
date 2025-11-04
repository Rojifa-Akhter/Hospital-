<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendBirthdaySms;
use DB;
class SendBirthdaySmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday SMS to patients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hospitalName=DB::table('wsec_hospital')->select('hospital_name','hospital_code')->first();    
       
          
        if ($hospitalName->hospital_code =="UNICO") {
            $patients = DB::table('patn_registration')
            ->select('mobile1','patient_name')
            ->whereMonth('DOB', now()->month) 
            ->whereDay('DOB', now()->day)    
            ->get();
            foreach ($patients as $p) {
                // $msg = "Happy Birthday! 🎉 From ". $hospitalName;
                // $msg = "Wishing you a day filled with joy, good health, and happiness. May this year bring you strength, peace, and wellness. — With care,". $hospitalName->hospital_name;
                $msg ="Dear ".$p->patient_name." , ".$hospitalName->hospital_name." wishes you strength, peace and wellness on this special day! HAPPY BIRTHDAY!";
                dd($msg );
                SendBirthdaySms::dispatch($p->mobile1, $msg)->onQueue('sms');
            }
             $this->info('Sent birthday SMS to '.count($patients).' patients');
             return 0;
         }
    }
}
