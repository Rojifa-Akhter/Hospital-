<?php

namespace App\Traits;

use App\Models\Lookup;
use App\Repositories\BaseRepository as Repo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Mail\CustomMail;
use App\Models\Company;
use Session;


trait MailEngine
{

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public static function appointmentMail($patient_email, $patient_name, $doctor_name, $appointment_datetime)
    {
        $emaildata = DB::table('sysc_email_format')
            ->join('sysc_lookupdata', 'sysc_email_format.email_event_lookup_no_pk', '=', 'sysc_lookupdata.lookupdata_no_pk')
            ->where('sysc_lookupdata.lookupdata_code', '=', 'APPEMAIL')
            ->first();

        if (!empty($emaildata)) {
            $email_subject = str_replace("{AppointmentDateTime}", $appointment_datetime, $emaildata->email_subject);
            $email_temp_body = $emaildata->email_body1;

            $keywords = ["{AppointmentDateTime}", "{DoctorName}", "{LocationName}"];
            $keywords_replace = [$appointment_datetime, $doctor_name, "iCure Hospital"];
            $email_body = str_replace($keywords, $keywords_replace, $email_temp_body);

            MailEngine::sendMail($patient_email, $patient_name, $email_subject, $email_body);
        }
    }
    public static function inventoryMail($to_mail,  $inv_no,$request_type,$request_by)
    {
        
        $emaildata = DB::table('sysc_email_format')
            ->join('sysc_lookupdata', 'sysc_email_format.email_event_lookup_no_pk', '=', 'sysc_lookupdata.lookupdata_no_pk')
            ->where('sysc_lookupdata.lookupdata_code', '=', 'INVEMAIL')
            ->first();

        if (!empty($emaildata) && !empty($to_mail)) {
            
            $email_subject = str_replace(["{requestType}","{id}"], [$request_type,$inv_no], $emaildata->email_subject);
            $email_temp_body = $emaildata->email_body1;

            $keywords = ["{requestType}", "{id}", "{Request_name}"];
            $keywords_replace = [$request_type, $inv_no, $request_by];
            $email_body = str_replace($keywords, $keywords_replace, $email_temp_body);

            // MailEngine::sendMail($to_mail, $to_neme, $email_subject, $email_body);
            foreach ($to_mail as $key => $value) {
               if ($value !="") {
                $message_details = [
                    'email' => $value,
                    'title' => $email_subject,
                    'body' => $email_body
                ];     
                Mail::send('admin.mail.mail', $message_details, function ($message) use ($message_details) {
                    $message->to($message_details['email'])
                        ->subject($message_details["title"]);
                });
               }
               
            }
           

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public static function sendMail($to_email = '', $to_name = '', $subject = '', $mail_body = '')
    {

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'mail.nextgenitltd.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mdanikislam@nextgenitltd.com';
        $mail->Password = 'XTdmPjmyXHEvh7P';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '25';
        $mail->setFrom('mdanikislam@nextgenitltd.com', 'NEXTGENiT');
        $mail->addAddress($to_email, $to_name);
        $mail->isHTML(true);

        /*$mail_body = view('mail.dispatch')
        ->with('products', $products)
        ->with('order_info', $order_info)
        ->with('dispatchMst', $dispatchMst)
        ->render();*/
        $mail_body = "<strong>This is a test Mail from NEXTGENiT Ltd.</strong>";
        //$mail->Subject = $subject;
        $mail->Body = $mail_body;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
        //return $mail->send();

    }

    //$app_info->appoint_date,$app_info->mobile1, $app_info->full_name_bangla, $app_info->slot_sl, $app_info->specialization_bangla
    function sendSms($app_date, $start_time, $end_time, $customer_phone, $doctor_name, $doctor_name_english, $serial, $specialization, $doctor_phone, $app_time, $update_ind,$homeService="")
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $company_profile = Company::orderBy('hospital_no_pk', 'desc')->where('hospital_no_pk', $ses_hospital_id)->first();
        if (in_array($company_profile->hospital_code , ["UNICO"])) {


            $company_name = isset($company_profile->hospital_name) ? $company_profile->hospital_name : '';
            $company_adderss = isset($company_profile->addrress1) ? $company_profile->addrress1 : '';
            $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';
            $app_date = date("d/m/Y", strtotime($app_date));
            
            // Phone number formatting
            $customer_phone = ltrim($customer_phone, '+');
            $check_88 = substr($customer_phone, 0, 2);
            $cust_phone = ($check_88 == "88") ? substr($customer_phone, 2) : $customer_phone; // Remove 88 if present
            $time = isset($start_time) ? date('h:i A', strtotime($start_time)) : date('h:i A', strtotime($app_time));
            
            if ($homeService==1) {
                $messageData="Happy to confirm that $company_profile->hospital_code@Home team will visit your residence between  $start_time to  $end_time (1 hour gap preferable)on $app_date. Helpline $company_number";                
            }else{
                $messageData= "Happy to confirm that $doctor_name_english will see you at $time $app_date at $company_name, $company_adderss. Kindly arrive 15 minutes ahead to complete formalities. Helpline $company_number";
            }

            $url = "https://smpp.revesms.com:7790/sendtext";
            $data = [
                "apikey" => "94545627a85de3f5", // Your API key
                "secretkey" => "6a148cb0", // You're missing this required field
                "callerID" => "UNICO.Hosp", // Sender ID
                "toUser" => $cust_phone, // Recipient number (without 88)
                "messageContent" =>$messageData
            ];
            // dd(  $data);
            $ch = curl_init();
            // this for only live server 
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

            // this for only xampp local 
                // curl_setopt_array($ch, [
                //     CURLOPT_URL => $url,
                //     CURLOPT_POST => true,
                //     CURLOPT_POSTFIELDS => http_build_query($data),
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_SSL_VERIFYHOST => 0, 
                //     CURLOPT_SSL_VERIFYPEER => 0,  
                //     CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,                
                //     // Add timeout to prevent hanging
                //     CURLOPT_TIMEOUT => 30,                
                //     // Enable verbose for debugging
                //     CURLOPT_VERBOSE => true,
                //     CURLOPT_STDERR => fopen('curl_log.txt', 'w+') // Log to file
                // ]);
            // end local code
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
           
        }
        if ($company_profile->hospital_code == "IMPALA") {
            $company_name = isset($company_profile->hospital_name_bangla) ? $company_profile->hospital_name_bangla : $company_profile->hospital_name;
            $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '';
            $app_date = date("d/m/Y", strtotime($app_date));
            $customer_phone = ltrim($customer_phone, '+');
            $check_88 = substr($customer_phone, 0, 2);
            $cust_phone = ($check_88 == "88") ? $customer_phone : "88" . $customer_phone;

            // $doctor_phone = ltrim($doctor_phone, '+');
            // $check_88 = substr($doctor_phone, 0, 2);
            // $doc_phone = ($check_88 == "88") ? $doctor_phone : "88" . $doctor_phone;
            //$app_date = "12-09-2022";
            // dd(date('h:i', strtotime($app_date)));
            //dd($bangla_date);
            //  dd(date('h:i A ',strtotime($data->au_entry_at)))

            //     $time = '';
            //     $time_hour = '';
            //     if(isset($start_time))
            //     {
            //         $time =date('h:i',strtotime($start_time)).' টায়';
            //         $time_hour = date('H',strtotime($start_time));
            //     }
            //     else
            //     {
            //         $time = date('h:i',strtotime($app_time)).' টায়';
            //         $time_hour = date('H',strtotime($app_time));

            //     }

            //    // dd($time);
            //     $dayTerm = '';

            //         if ($time_hour < "12") {
            //             $dayTerm ='সকাল';
            //         } else
            //         /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
            //         if ($time_hour >= "12" && $time_hour < "15") {
            //             $dayTerm='দুপুর';
            //         }
            //         else
            //         if ($time_hour >= "15" && $time_hour < "17") {
            //             $dayTerm='বিকেল';
            //         }
            //          else

            //         /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
            //         if ($time_hour >= "17" && $time_hour < "19") {
            //             $dayTerm='সন্ধ্যা';
            //         } else
            //         /* Finally, show good night if the time is greater than or equal to 1900 hours */
            //         if ($time_hour >= "19") {
            //             $dayTerm='রাত';
            //         }

            //     $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            //     $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
            //     $bangla_date = str_replace($search_array, $replace_array, $app_date);
            //     $time_bangla = str_replace($search_array,$replace_array,$time);
            //    // dd($time_bangla);
            //     $doc_name = $doctor_name.'র';
            //   //  dd($dayTerm." ".$time);
            //dd($doctor_name_english);
            $is_scheduled = $update_ind == 1 ? "Rescheduled" : "scheduled";
            $time = isset($start_time) ? date('h:i A', strtotime($start_time)) : date('h:i A', strtotime($app_time));
            $doctor_name_english_designation = strtolower(trim($doctor_name_english)) == "ataul mujeeb rashed" ? "Acupuncturist Dr. Ataul Mujeeb Rashed" : "Physical Therapist $doctor_name_english";
            $pat_message = "Dear Sir/Madam,\nAssalamualaikum! Your appointment is $is_scheduled on $app_date with $doctor_name_english_designation at $time. Thank you!\nFor your support $company_number\n$company_name";
            // $doc_message = "আসসালামুআলাইকুম, আপনার $app_date তারিখে $time $serial নং সিরিয়াল নিশ্চিত করা হয়েছে।";
                 $this->sendCustomSms($cust_phone, $pat_message,'C20086736524c4ac099c95.77107755','IMPALA CARE','https://msg.elitbuzz-bd.com/smsapi','unicode');
          


        }
        //KBMH SMS Connection -- GP
        if ($company_profile->hospital_code == "KBMH") {
            $company_name = isset($company_profile->hospital_name_bangla) ? $company_profile->hospital_name_bangla : $company_profile->hospital_name;
            $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '';
            $app_date = date("d/m/Y", strtotime($app_date));
            $customer_phone = ltrim($customer_phone, '+');
            $check_88 = substr($customer_phone, 0, 2);
            $cust_phone = ($check_88 == "88") ? $customer_phone : $customer_phone;

            $is_scheduled = $update_ind == 1 ? "Rescheduled" : "scheduled";
            $time = isset($start_time) ? date('h:i A', strtotime($start_time)) : date('h:i A', strtotime($app_time));
            $doctor_name_english_designation = strtolower(trim($doctor_name_english)) == "ataul mujeeb rashed" ? "Acupuncturist Dr. Ataul Mujeeb Rashed" : "Physical Therapist $doctor_name_english";

            $pat_message = "আসসালামুআলাইকুম, $specialization বিশেষজ্ঞ $doctor_name এর $app_date তারিখে $serial নং সিরিয়াল নিশ্চিত করা হয়েছে।  $company_name । প্রয়োজনেঃ $company_number";

            $this->callAPI('GET', "https://gpcmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username=KhwajaADMIN&password=Kbmh@2023&apicode=1&msisdn=$cust_phone&countrycode=880&cli=KBMH&messagetype=3&message=".urlencode($pat_message)."&messageid=0", false);

            // $this->callAPI('GET', "https://api.mobireach.com.bd/SendTextMessage?Username=impala&Password=Dhaka@5599&From=IMPALA&To=$doc_phone&Message=".urlencode($doc_message), false);

        }
    }
    function callAPI($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        // if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }
    function sendCustomSms($customer_phone, $message_body,$api_kye='',$sender_id='',$api_url='',$type='')
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $company_profile = Company::orderBy('hospital_no_pk', 'desc')->where('hospital_no_pk', $ses_hospital_id)->first();
        if ($company_profile->hospital_code == "KBMH") {
            $customer_phone = ltrim($customer_phone, '+');
            $check_88 = substr($customer_phone, 0, 2);
            $cust_phone = ($check_88 == "88") ? $customer_phone : "88" . $customer_phone;
            $url = "http://sms.uttarainfotech.com/smsapi";
            $data = [
                "api_key" => "C20004595f7eba0508c1e6.91872739",
                "type" => "text",
                "contacts" => $cust_phone,
                "senderid" => "8809612451780",
                "msg" => $message_body,
            ];

            $ch = \curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }elseif ($company_profile->hospital_code == "IMPALA") {
            // dd($customer_phone, $message_body,$api_kye,$sender_id,$api_url);
            $customer_phone = ltrim($customer_phone, '+');
            $check_88 = substr($customer_phone, 0, 2);
            $cust_phone = ($check_88 == "88") ? $customer_phone : "88" . $customer_phone;
            $url = $api_url;
            $data = [
                "api_key" => $api_kye,
                "type" => $type,
                "contacts" => $cust_phone,
                "senderid" => $sender_id,
                "msg" => $message_body,
            ];

            $ch = \curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
    }

   public static function sendCustomMail($to_email_address = '', $to_name = '', $subject = '', $mail_body = '', $pdf)
{
    try {
        if (is_string($to_email_address)) {
            $message_details = [
                'email' => $to_email_address,
                'title' => $subject,
                'body' => $mail_body
            ];
           
            Mail::send('admin.mail.mail', $message_details, function ($message) use ($message_details, $pdf) {
                $message->to($message_details["email"], $message_details["email"])
                        ->subject($message_details["title"])
                        ->setBody($message_details['body'], 'text/html');
                // dd($message);
                // if (!empty($pdf)) {
                //     foreach ($pdf as $index => $pdfs) {
                //         $message->attachData($pdfs->output(), "report_" . ($index + 1) . ".pdf", [
                //             'mime' => 'application/pdf',
                //         ]);
                //     }
                // }
            });

        } elseif (is_array($to_email_address)) {
            foreach ($to_email_address as $to_email) {
                $message_details = [
                    'email' => $to_email,
                    'title' => $subject,
                    'body' => $mail_body
                ];

                Mail::send('admin.mail.mail', $message_details, function ($message) use ($message_details, $pdf) {
                    $message->to($message_details["email"], $message_details["email"])
                            ->subject($message_details["title"])
                            ->setBody($message_details['body'], 'text/html');

                    $message->attachData($pdf->output(), "emr.pdf", [
                        'mime' => 'application/pdf',
                    ]);
                });
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Mail sent successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Mail sending failed',
            'error' => $e->getMessage()
        ]);
    }
}



    //    Added By Nazmul
    function sendEmailForPatient($to_email, $to_name, $subject, $mail_body, $doc_email, $doc_mail_body)
    {
        // patient Email End
        $message_details = [
            'email' => $to_email,
            'title' => $subject,
            'body' => $mail_body
        ];

        Mail::send('admin.mail.mail', $message_details, function ($message) use ($message_details) {
            $message->to($message_details['email'])
                ->subject($message_details["title"]);
        });

        // patient Email End

        // Doctor Email Start
        // $message_details_doc = [
        //     'email' => $doc_email,
        //     'title' => $subject,
        //     'body' => $doc_mail_body
        // ];
        // Mail::send('admin.mail.mail', $message_details_doc, function ($message) use ($message_details_doc) {
        //     $message->to($message_details_doc['email'])
        //         ->subject($message_details_doc["title"]);
        //                ->attachData('Hello, $full_name,Today You have an appointment with a patient $patient_name at $app_time pm. His serial number is $serial.You have a total of 20 appointments today.');;
        // });
        // Doctor Email

        // Admin Email End
        // $message_details_admin = [
        //     'email' => $to_email,
        //     'title' => $subject,
        //     'body' => $mail_body
        // ];
        // Mail::send('admin.mail.mail', $message_details_admin, function ($message) use ($message_details_admin) {
        //     $message->to('admin@app.com')
        //         ->subject($message_details_admin["title"]);
        //     //                ->attachData('Hello, $full_name,Today You have an appointment with a patient $patient_name at $app_time pm. His serial number is $serial.You have a total of 20 appointments today.');;
        // });
        // Admin Email End

    }
    function sendEmailCancelPatient($to_email = "", $to_name = "", $subject = "", $mail_body = "", $doc_email = "", $doc_mail_body = "")
    {
        // patient Email start
        $message_details = [
            'email' => $to_email,
            'title' => $subject,
            'body' => $mail_body
        ];

        Mail::send('admin.mail.mail', $message_details, function ($message) use ($message_details) {
            $message->to($message_details['email'])
                ->subject($message_details["title"]);
        });

        // patient Email End

    }


    function sendWebAppSms($app_date, $customer_phone, $doctor_name, $serial, $specialization, $patient_name, $pat_gender_txt, $pat_age, $phone_mobile, $app_time, $full_name)
    {

        $company_profile = Company::orderBy('hospital_no_pk', 'desc')->first();
        $company_name = isset($company_profile->hospital_name_bangla) ? $company_profile->hospital_name_bangla : $company_profile->hospital_name;
        $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';
        $app_date = date("d/m/Y", strtotime($app_date));
        $customer_phone = ltrim($customer_phone, '+');
        $check_88 = substr($customer_phone, 0, 2);
        $cust_phone = ($check_88 == "88") ? $customer_phone : "88" . $customer_phone;
        $url = "http://sms.uttarainfotech.com/smsapi";

        //        For Doctor
        $doc_data = [
            "api_key" => "C20004595f7eba0508c1e6.91872739",
            "type" => "text",
            "contacts" => $phone_mobile,
            "senderid" => "8809612451780",
            "msg" => "Hello, $full_name,Today You have an appointment with a patient $patient_name at $app_time . His serial number is $serial.You have a total of $serial appointments today."
        ];

        $ch1 = \curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url);
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $doc_data);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch1);

        //        End Doctor

        //        Patient Sms  Start
        $data = [
            "api_key" => "C20004595f7eba0508c1e6.91872739",
            "type" => "text",
            "contacts" => $cust_phone,
            "senderid" => "8809612451780",
            "msg" => "আসসালামুআলাইকুম, $specialization বিশেষজ্ঞ $doctor_name এর $app_date তারিখে $serial নং সিরিয়াল নিশ্চিত করা হয়েছে।  $company_name । প্রয়োজনেঃ $company_number",
        ];

        $ch = \curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        //        Patient Sms End

        return $response;
    }
    function appCancelSms($app_date, $customer_phone, $doctor_name, $serial, $specialization, $patient_name = "", $pat_gender_txt = "", $pat_age = "", $phone_mobile = "", $app_time = "", $full_name = "")
    {
        $company_profile = Company::orderBy('hospital_no_pk', 'desc')->first();
        $company_name = isset($company_profile->hospital_name_bangla) ? $company_profile->hospital_name_bangla : $company_profile->hospital_name;
        $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';
        $app_date = date("d/m/Y", strtotime($app_date));
        $customer_phone = ltrim($customer_phone, '+');
        $check_88 = substr($customer_phone, 0, 2);
        $cust_phone = ($check_88 == "88") ? $customer_phone : "88" . $customer_phone;
        $url = "http://sms.uttarainfotech.com/smsapi";

        //        Patient Sms  Start
        $data = [
            "api_key" => "C20004595f7eba0508c1e6.91872739",
            "type" => "text",
            "contacts" => $cust_phone,
            "senderid" => "8809612451780",
            "msg" => "আসসালামুআলাইকুম, $specialization বিশেষজ্ঞ $doctor_name এর $app_date তারিখে $serial নং সিরিয়াল বাতিল করা হয়েছে।  $company_name । প্রয়োজনেঃ $company_number",
        ];

        $ch = \curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        //        Patient Sms End

        return $response;
    }
}
