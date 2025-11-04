<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use \PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;


class IPDDietController extends Controller
{
    //
    public function ipdDietChartPDF($patient_no_fk, $admission_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $ipd_admission = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($ipd_admission->admission_no_pk);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($ipd_admission->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        //  $patient_vitals =  DB::table('psn_t_patvitals')->where("admission_no_fk", $admission_id)->orderby('au_entry_at','asc')->get();


        $ipd_diet = DB::table('ipd_diet_chart')->where('admission_no_fk',$admission_id)->orderBy('au_entry_at','desc')->get();
        $ipd_arr = [];
        if(!empty($ipd_diet)){
            foreach($ipd_diet as $diet){
                $ipd_arr[date('d/m/Y',strtotime($diet->au_entry_at))][$diet->meal_type] = $diet->food_type;
            }
        }

        // dd($medication_chart);
        //dd(  $medication_chart );
        //return view("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication' => $medication]);

        $pdf = PDF::loadView("admin.ipd.reports.diet_chart", ["ipd_arr" => $ipd_arr, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("Diet Chart-report.pdf", array("Attachment" => false));
    }

    public function index($patient_no_fk, $admission_id)
    {
        //

        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->get()->first();

        return Template::loadView("admin.ipd.nurse_station.diet_pop_up", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }
    public function store(Request $request)
    {
        $sequence = DB::getSequence();
        $diet_chart_no_pk_seq = $sequence->nextValue('diet_chart_no_pk_seq');

        $data = [
            'patient_no_fk' => $request->patient_no_fk,
            'admission_no_fk' => $request->admission_no_fk,
            'meal_type' => $request->meal_type,
            'food_type' => $request->food_type,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'IPD Diet Followup';
        $data['diet_chart_no_pk'] = $diet_chart_no_pk_seq;

        $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

        DB::table('ipd_diet_chart')->insert($data);

        DB::commit();
        $sequence = DB::getSequence();

        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }


    // Cafeteria Part

    public function cafeteriaChart($patient_no_fk, $admission_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $ipd_admission = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($ipd_admission->admission_no_pk);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($ipd_admission->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        //  $patient_vitals =  DB::table('psn_t_patvitals')->where("admission_no_fk", $admission_id)->orderby('au_entry_at','asc')->get();


        $ipd_diet = DB::table('ipd_catering_chart')->where('admission_no_fk',$admission_id)->get();
        $ipd_arr = [];
        if(!empty($ipd_diet)){
            foreach($ipd_diet as $diet){
                $ipd_arr[date('d/m/Y',strtotime($diet->au_entry_at))][$diet->meal_type] = $diet->food_type;
            }
        }

        // dd($medication_chart);
        //dd(  $medication_chart );
        //return view("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication' => $medication]);

        $pdf = PDF::loadView("admin.ipd.reports.cafeteria_chart", ["ipd_arr" => $ipd_arr, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("Cafeteria Chart-report.pdf", array("Attachment" => false));
    }

    public function cafeteria($patient_no_fk, $admission_id)
    {
        //

        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->get()->first();

        return Template::loadView("admin.ipd.nurse_station.cafeteria_pop_up", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }
    public function cafeteriaStore(Request $request)
    {
        $sequence = DB::getSequence();
        $catering_chart_no_pk_seq = $sequence->nextValue('catering_chart_no_pk_seq');

        $data = [
            'patient_no_fk' => $request->patient_no_fk,
            'admission_no_fk' => $request->admission_no_fk,
            'meal_type' => $request->meal_type,
            'food_type' => $request->food_type,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'IPD Diet Followup';
        $data['catering_chart_no_pk'] = $catering_chart_no_pk_seq;
        $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
        DB::table('ipd_catering_chart')->insert($data);
        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];
        return response()->json($message);
    }

    // Diet Request v2
    public function dietRequest($patient_no_fk, $admission_id)
    {
        
        if(empty($patient_no_fk) || empty($admission_id)){
            return Template::loadView("admin.components.error_alert");
        }

        $patient_info = DB::table('pat_registration_wl_vw a')
                            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
                            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
                            ->where('a.patient_no_pk', $patient_no_fk)
                            ->where('b.admission_uid', $admission_id)
                            ->first();

        // Admission info
        $admission_info = DB::table('ipd_admitted_patlist_vw')
            ->where('admission_uid', $admission_id)
            ->first();

        // Diet requests with user names
        $diet_requests = DB::table('DIET_REQUEST as dr')
            ->leftJoin('WSEC_USER as entry_user', 'dr.AU_ENTRY_BY', '=', 'entry_user.USER_NO_PK')
            ->leftJoin('WSEC_USER as ack_user', 'dr.AU_ACK_BY', '=', 'ack_user.USER_NO_PK')
            ->select(
                'dr.*',
                'entry_user.USER_FULLNAME as entry_by_name',
                'ack_user.USER_NAME as ack_by_name'
            )
            ->where('dr.PATIENT_NO_FK', $patient_no_fk)
            ->where('dr.ADMISSION_NO_FK', $admission_id)
            ->orderByDesc('dr.DIET_REQUEST_NO_PK')
            ->get();

        return Template::loadView("admin.ipd.nurse_station.v2.diet_request", ['patient_info' => $patient_info, 'diet_requests' => $diet_requests, 'admission_info'=>$admission_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }


    public function dietStore(Request $request)
    {
        $request->validate([
            'diet_type'   => 'required',
            'feeding_mode'=> 'required',
            'diagnosis'   => 'required'
        ]);

        try {
            // Get Oracle Sequence
            $sequence = DB::getSequence();
            $diet_request_no_pk = $sequence->nextValue('DIET_REQUEST_NO_PK_SEQ');

            // Handle array fields (checkboxes) → save as comma separated string or JSON
            $diet_detail = is_array($request->diet_detail) ? implode(',', $request->diet_detail) : null;
            $food_habit  = is_array($request->food_habit) ? implode(',', $request->food_habit) : null;

            $data = [
                'diet_request_no_pk'   => $diet_request_no_pk,
                'patient_no_fk'        => $request->patient_no_fk,
                'admission_no_fk'      => $request->admission_no_fk,

                'diet_type'            => $request->diet_type,
                'npo'                  => $request->npo,
                'feeding_mode'         => $request->feeding_mode,
                'remarks'              => $request->remarks,
                'diagnosis'            => $request->diagnosis,

                'food_precaution'      => $request->food_precaution,
                'diet_detail'          => $diet_detail,
                'protein'              => $request->protein,
                'calories'             => $request->calories,
                'salt'                 => $request->salt,
                'potassium'            => $request->potassium,
                'fluids'               => $request->fluids,
                'food_habit'           => $food_habit,

                'status'               => 1,
                'au_entry_by'          => Auth::user()->user_no_pk,
                'au_entry_at'          => now(),
                'au_entry_session'     => 'IPD Diet Request',
                'au_entry_hospital_no_fk' => Session::get('user.ses_hospital_no_pk')
            ];

            DB::table('DIET_REQUEST')->insert($data);

            $message = ['msg' => 'Diet Request Saved Successfully', 'title' => 'Success'];
            return response()->json($message, 200);

        } catch (\Throwable $th) {
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
            return response()->json($message, 422);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('DIET_REQUEST')->where('diet_request_no_pk', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Diet Request cancelled successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 422);
        }
    }


}
