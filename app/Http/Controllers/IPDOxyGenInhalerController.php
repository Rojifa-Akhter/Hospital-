<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Session;
use \PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class IPDOxyGenInhalerController extends Controller
{

    // oxygen_inhaler
    public function ipdOxygenInhalderChartPDF($patient_no_fk, $admission_id)
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
        $oxygen_info = DB::table('ipd_oxygen_saturation')
            ->join('wsec_user', 'ipd_oxygen_saturation.au_entry_by', 'wsec_user.user_no_pk')
            ->where('admission_no_fk', $admission_id)->get();
        // dd($oxygen_info);

        // dd($medication_chart);
        //dd(  $medication_chart );
        //return view("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication' => $medication]);

        $pdf = PDF::loadView("admin.ipd.reports.oxygen_inhaler_chart", ["oxygen_info" => $oxygen_info, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("medication_chart-report.pdf", array("Attachment" => false));
    }
    public function index($patient_no_fk, $admission_id)
    {



        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->get()->first();

        return Template::loadView("admin.ipd.oxygen_inhaler.oxygen_inhaler", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }

    public function store(Request $request)
    {
        $sequence = DB::getSequence();
        $saturation_no_pk_seq = $sequence->nextValue('saturation_no_pk_seq');

        $data = [
            'starting_oxygen_date' =>$request->starting_oxygen_date!="" ? date('Y-m-d', strtotime($request->starting_oxygen_date)):'',
            'starting_oxygen_time' =>$request->volume !="" ?  date('Y-m-d H:i:s', strtotime($request->volume)):'',
            'flow_oxygen_inhalation' => $request->flow_oxygen_inhalation,
            'total_number_oxygen_inhal' => $request->total_number_oxygen_inhal,
            'patient_no_fk' => $request->patient_no_fk,
            'admission_no_fk' => $request->admission_no_fk,
            'remarks' => $request->remarks,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'IPD Oxygen';
        $data['saturation_no_pk'] = $saturation_no_pk_seq;

        $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

        DB::table('ipd_oxygen_saturation')->insert($data);

        DB::commit();
        $sequence = DB::getSequence();

        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }


    public function ipdDoctorPatientVistPDF($patient_no_fk, $admission_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $ipd_admission = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();
        // dd( $ipd_admission );
        $ipd_admission1 = DB::select("select con.admission_pk_no,
                                        con.doc_name,
                                        con.doc_no,
                                        con.doctor_visit_date_time,
                                        con.no_of_visit as visit,
                                        con.visit_type,
                                        adm.patient_name,
                                        adm.age,
                                        adm.admission_date,
                                        adm.admission_uid,
                                        adm.gender_txt,
                                        con.patient_no_fk
                                from ipd_consultation_count_vw con, ipd_admitted_patlist_vw adm
                                where con.admission_pk_no = adm.admission_no_pk
                                        and adm.admission_no_pk = $admission_id
                                 order by con.doc_no desc
                                        ");
        // dd($ipd_admission1);
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
        $oxygen_info = DB::table('ipd_oxygen_saturation')
            ->join('wsec_user', 'ipd_oxygen_saturation.au_entry_by', 'wsec_user.user_no_pk')
            ->where('admission_no_fk', $admission_id)->get();
        //dd($medication_charts_info);

        // dd($medication_chart);
        //dd(  $medication_chart );
        //return view("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication' => $medication]);
        
        $pdf = PDF::loadView("admin.ipd.reports.doctor_patient_visit_pdf", ["oxygen_info" => $oxygen_info, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, "ipd_admission" => $ipd_admission1, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("medication_chart-report.pdf", array("Attachment" => false));
    }
}
