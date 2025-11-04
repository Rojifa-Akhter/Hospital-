<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBirthdaySms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     private string $phone;
    private string $message;
    public function __construct(string $phone, string $message)
    {
         $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $cust = ltrim($this->phone, '+');
        if (substr($cust, 0, 2) === '88') {
            $cust = substr($cust, 2);
        }

        $data = [
            "apikey" => "94545627a85de3f5",
            "secretkey" => "6a148cb0",
            "callerID" => "UNICO.Hosp",
            "toUser" => $cust,
            "messageContent" => $this->message,
        ];
        $url = "https://smpp.revesms.com:7790/sendtext";
        $ch = curl_init();
           
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($data),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CAINFO => '/etc/pki/tls/certs/ca-bundle.crt',
                // Add these security options:
                CURLOPT_SSL_CIPHER_LIST => 'DEFAULT:@SECLEVEL=1',
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_VERBOSE => true
            ]);  


            // for local xampp pc 

            //  curl_setopt_array($ch, [
            //         CURLOPT_URL => $url,
            //         CURLOPT_POST => true,
            //         CURLOPT_POSTFIELDS => http_build_query($data),
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_SSL_VERIFYHOST => 0, 
            //         CURLOPT_SSL_VERIFYPEER => 0,  
            //         CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,                
            //         // Add timeout to prevent hanging
            //         CURLOPT_TIMEOUT => 30,                
            //         // Enable verbose for debugging
            //         CURLOPT_VERBOSE => true,
            //         CURLOPT_STDERR => fopen('curl_log.txt', 'w+') // Log to file
            //     ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
    
    }
}
