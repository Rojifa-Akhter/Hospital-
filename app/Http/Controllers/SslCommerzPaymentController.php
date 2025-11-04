<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Models\HrmsSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Repositories\PatientAppointmentRepository;

class SslCommerzPaymentController extends Controller
{
    protected $appointmentRepository;

    public function __construct(HrmsSchedule $schedule)
    {
        $this->appointmentRepository = new PatientAppointmentRepository($schedule);
    }
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        if (empty(Auth::user()->patient_no_fk)) {
            return back()->with('message', 'Patient Not Found');
        }


        if ($request->doc_fee < 10) {
            return back()->with('message', 'Minimum amount have to 10TK');
        }

        

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $request->doc_fee; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->patient_first_name;
        $post_data['cus_email'] = !empty($request->email) ? $request->email : 'moinuddin7@gmail.com';
        $post_data['cus_add1'] = !empty($request->customer_address) ? $request->customer_address : 'N/A';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        // Cache::put('job_id',$request->job_id);
        // Cache::put('circular_id',$request->circular_id);
        // Cache::put('candidate_no',Auth::guard('candidate')->user()->profile->id);
        // Cache::put('employee_id',Auth::guard('candidate')->user()->id);


        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d")));//$au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');


        Cache::put('hdn_patient_id',$request->hdn_patient_id);

        Cache::put('pat_appointment_info'.$request->hdn_patient_id, [
            'hdn_appointment_date' => $request->hdn_appointment_date,
            'hdn_doctor_id' => $request->hdn_doctor_id,
            'hdn_hospital_id' => $request->hdn_hospital_id,
            'hdn_service_unit' => $request->hdn_service_unit,
            'hdn_schedule_id' => $request->hdn_schedule_id,
            'hdn_patient_id' => $request->hdn_patient_id,
            'doc_id' => $request->doc_id,
            'doc_status' => $request->doc_status,
            'doc_app_time' => $request->doc_app_time,
            'doc_fee' => $request->doc_fee,
            'session_user' => $request->session_user,
            'patient_first_name' => $request->patient_first_name,
            'patient_gender_id' => $request->patient_gender_id,
            'appointment_person' => $request->appointment_person,
            'phone' => $request->phone,
            'relationship' => $request->relationship,
            'pat_age_y' => $request->pat_age_y,
            'pat_age_m' => $request->pat_age_m,
            'pat_age_d' => $request->pat_age_d,
            'pat_dob' => $request->pat_dob,
            'email' => $request->email,
            'pat_details' => $request->pat_details,
            '_token' => $request->_token,
            'au_entry_at' => $au_entry_at,
            'au_entry_by' => intval($request->hdn_patient_id),
            'au_entry_hospital_no_fk' => 1,
            'au_entry_session' => intval($request->hdn_patient_id),
            'user_obj' => Auth::user()

        ]);

        // return $patient_app_info = Cache::get('pat_appointment_info'.$request->hdn_patient_id);
        // return $patient_app_info['_token'];

        
        DB::beginTransaction();


        $sequence = DB::getSequence();

        $record_id = $sequence->nextValue('ORDER_NO_PK_SEQ');

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'id' => $record_id,
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'customer_id' => intval($request->hdn_patient_id),
                'phone' => $post_data['cus_phone'],
                'amount' => intval($post_data['total_amount']),
                'status' => 'Pending',
                'address' => !empty($post_data['cus_add1']) ? $post_data['cus_add1'] : 'N/A',
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => intval($request->hdn_patient_id),
                'au_entry_hospital_no_fk' => 1,
                'au_entry_session' => intval($request->hdn_patient_id)
            ]);

        DB::commit();

        $sslc = new SslCommerzNotification();
        
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        $response = json_decode($payment_options);//redirect($payment_options['data']);
            
        return redirect($response->data);

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }


    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {

        $patient_id = Cache::get('hdn_patient_id',$request->hdn_patient_id);

        

        $patient_appointment_info = Cache::get('pat_appointment_info'.$patient_id);

        $request->request->add(['_token' => $patient_appointment_info['_token']]);
        $request->request->add(['hdn_appointment_date' => $patient_appointment_info['hdn_appointment_date']]);
        $request->request->add(['hdn_doctor_id' => $patient_appointment_info['hdn_doctor_id']]);
        $request->request->add(['hdn_hospital_id' => $patient_appointment_info['hdn_hospital_id']]);
        $request->request->add(['hdn_service_unit' => $patient_appointment_info['hdn_service_unit']]);
        $request->request->add(['hdn_schedule_id' => $patient_appointment_info['hdn_schedule_id']]);
        $request->request->add(['hdn_patient_id' => $patient_appointment_info['hdn_patient_id']]);
        $request->request->add(['doc_id' => $patient_appointment_info['doc_id']]);
        $request->request->add(['doc_status' => $patient_appointment_info['doc_status']]);
        $request->request->add(['doc_app_time' => $patient_appointment_info['doc_app_time']]);
        $request->request->add(['doc_fee' => $patient_appointment_info['doc_fee']]);
        $request->request->add(['session_user' => $patient_appointment_info['session_user']]);
        $request->request->add(['patient_first_name' => $patient_appointment_info['patient_first_name']]);
        $request->request->add(['patient_gender_id' => $patient_appointment_info['patient_gender_id']]);
        $request->request->add(['appointment_person' => $patient_appointment_info['appointment_person']]);
        $request->request->add(['phone' => $patient_appointment_info['phone']]);
        $request->request->add(['relationship' => $patient_appointment_info['relationship']]);
        $request->request->add(['pat_age_y' => $patient_appointment_info['pat_age_y']]);
        $request->request->add(['pat_age_m' => $patient_appointment_info['pat_age_m']]);
        $request->request->add(['pat_age_d' => $patient_appointment_info['pat_age_d']]);
        $request->request->add(['pat_dob' => $patient_appointment_info['pat_dob']]);
        $request->request->add(['email' => $patient_appointment_info['email']]);
        $request->request->add(['pat_details' => $patient_appointment_info['pat_details']]);
        $request->request->add(['au_entry_at' => $patient_appointment_info['au_entry_at']]);
        $request->request->add(['au_entry_by' => $patient_appointment_info['au_entry_by']]);
        $request->request->add(['au_entry_hospital_no_fk' => $patient_appointment_info['au_entry_hospital_no_fk']]);
        $request->request->add(['au_entry_session' => $patient_appointment_info['au_entry_session']]);

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == true) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                 */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);
                
                

//                 $csmsid = rand (100000,999999);

//                 $csmsid = "bcpcl-".$csmsid;

//                 $this->sms->singleSms($candidateinfo->phone, "
// Dear Candidate,
// Your application for the post of $jobinfo->job_title of Bangladesh-China Power Company (Pvt.) Limited is submitted successfully. You will be notified prior to the selection process.
// HR, BCPCL
//                 ", $csmsid);
            
//                 Mail::to($candidateinfo->email)->send(new JobApplicationMailable($jobinfo));

                $success_msg = $this->appointmentRepository->coverPatientAppointment($request, $request->id);
                Auth::login($patient_appointment_info['user_obj']);
                return view('iCure-Home.patient.gateway_payment_success', compact('success_msg'));
                //return redirect(route('job-application-submition-msg'))->with('job_title',$jobinfo->job_title);
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                 */

                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                $msg = "validation Fail";

                Auth::login($patient_appointment_info['user_obj']);
                return view('iCure-Home.patient.gateway_payment_faild', $msg);
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
        That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
         */

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }

    }

    public function fail(Request $request)
    {
        $patient_id = Cache::get('hdn_patient_id',$request->hdn_patient_id);

        $patient_appointment_info = Cache::get('pat_appointment_info'.$patient_id);

        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
                $msg = "validation Fail";

                Auth::login($patient_appointment_info['user_obj']);
                return view('iCure-Home.patient.gateway_payment_faild', compact('msg'));
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            Auth::login($patient_appointment_info['user_obj']);
            return view('iCure-Home.patient.gateway_payment_already_success');
        } else {
            $msg = "Transaction Invalid";
            Auth::login($patient_appointment_info['user_obj']);
            return view('iCure-Home.patient.gateway_payment_faild', compact('msg'));
        }

    }

    public function cancel(Request $request)
    {
        $patient_id = Cache::get('hdn_patient_id',$request->hdn_patient_id);
        
        $patient_appointment_info = Cache::get('pat_appointment_info'.$patient_id);

        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
                $msg = "Order canceled";
                Auth::login($patient_appointment_info['user_obj']);
                return view('iCure-Home.patient.gateway_payment_cancel', $msg);
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            Auth::login($patient_appointment_info['user_obj']);
            return view('iCure-Home.patient.gateway_payment_already_success');
        } else {
            $msg = "Transaction Invalid";
            Auth::login($patient_appointment_info['user_obj']);
            return view('iCure-Home.patient.gateway_payment_faild', compact('msg'));
        }

    }

    public function ipn(Request $request)
    {
        $patient_id = Cache::get('hdn_patient_id',$request->hdn_patient_id);

        

        $patient_appointment_info = Cache::get('pat_appointment_info'.$patient_id);

        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            

            $request->request->add(['_token' => $patient_appointment_info['_token']]);
            $request->request->add(['hdn_appointment_date' => $patient_appointment_info['hdn_appointment_date']]);
            $request->request->add(['hdn_doctor_id' => $patient_appointment_info['hdn_doctor_id']]);
            $request->request->add(['hdn_hospital_id' => $patient_appointment_info['hdn_hospital_id']]);
            $request->request->add(['hdn_service_unit' => $patient_appointment_info['hdn_service_unit']]);
            $request->request->add(['hdn_schedule_id' => $patient_appointment_info['hdn_schedule_id']]);
            $request->request->add(['hdn_patient_id' => $patient_appointment_info['hdn_patient_id']]);
            $request->request->add(['doc_id' => $patient_appointment_info['doc_id']]);
            $request->request->add(['doc_status' => $patient_appointment_info['doc_status']]);
            $request->request->add(['doc_app_time' => $patient_appointment_info['doc_app_time']]);
            $request->request->add(['doc_fee' => $patient_appointment_info['doc_fee']]);
            $request->request->add(['session_user' => $patient_appointment_info['session_user']]);
            $request->request->add(['patient_first_name' => $patient_appointment_info['patient_first_name']]);
            $request->request->add(['patient_gender_id' => $patient_appointment_info['patient_gender_id']]);
            $request->request->add(['appointment_person' => $patient_appointment_info['appointment_person']]);
            $request->request->add(['phone' => $patient_appointment_info['phone']]);
            $request->request->add(['relationship' => $patient_appointment_info['relationship']]);
            $request->request->add(['pat_age_y' => $patient_appointment_info['pat_age_y']]);
            $request->request->add(['pat_age_m' => $patient_appointment_info['pat_age_m']]);
            $request->request->add(['pat_age_d' => $patient_appointment_info['pat_age_d']]);
            $request->request->add(['pat_dob' => $patient_appointment_info['pat_dob']]);
            $request->request->add(['email' => $patient_appointment_info['email']]);
            $request->request->add(['pat_details' => $patient_appointment_info['pat_details']]);
            $request->request->add(['au_entry_at' => $patient_appointment_info['au_entry_at']]);
            $request->request->add(['au_entry_by' => $patient_appointment_info['au_entry_by']]);
            $request->request->add(['au_entry_hospital_no_fk' => $patient_appointment_info['au_entry_hospital_no_fk']]);
            $request->request->add(['au_entry_session' => $patient_appointment_info['au_entry_session']]);

            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == true) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    $success_msg = $this->appointmentRepository->coverPatientAppointment($request, $request->id);    
                    Auth::login($patient_appointment_info['user_obj']);
                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);
                    Auth::login($patient_appointment_info['user_obj']);
                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.
                Auth::login($patient_appointment_info['user_obj']);
                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                Auth::login($patient_appointment_info['user_obj']);
                echo "Invalid Transaction";
            }
        } else {
            Auth::login($patient_appointment_info['user_obj']);
            echo "Invalid Data";
        }
    }

}
