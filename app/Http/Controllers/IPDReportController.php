<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use \PDF;
use Auth;
use Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class IPDReportController extends Controller
{
    //
    public function patVitalsReport($patient_no_fk, $admission_id)
    {
        ini_set('max_execution_time',0);
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

        $patient_vitals =  DB::table('psn_t_patvitals')->where("admission_no_fk", $admission_id)->orderby('au_entry_at', 'asc')->get();

        $pdf = PDF::loadView("admin.ipd.reports.pat_vitals_report", ["patient_vitals" => $patient_vitals, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }
    public function patConsultantReport($patient_no_fk, $admission_id)
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

        $consultant_visit =  DB::table('ipd_consultants_visit_vw')->where("admission_no_pk", $admission_id)->orderby('au_entry_at', 'asc')->get();

        $pdf = PDF::loadView("admin.ipd.reports.pat_consultant_report", ["consultant_visit" => $consultant_visit, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("Consultat Visit Report.pdf", array("Attachment" => false));
        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }

    public function patTemperatureReport($patient_no_fk, $admission_id)
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

        //$consultant_visit =  DB::table('ipd_consultants_visit_vw')->where("admission_no_pk", $admission_id)->orderby('au_entry_at','asc')->get();
        $psn_t_patvitals =  DB::table('psn_t_patvitals')->where('admission_no_fk', $admission_id)->get();
        $vitals_data = [];
        $vitals_time = [];
        foreach ($psn_t_patvitals as $vitals) {
            if (isset($vitals->temp_val)) {
                $vitals_data[]=  $vitals->temp_val;
                $date_time = date('h A', strtotime($vitals->au_entry_at));
                $vitals_time[] = "`".$date_time."`"; //"'". date("h A", strtotime($vitals->au_entry_at)) . "',";
            }
        }
        // dd($vitals_time,$vitals_data);
        //
        $vitals_time1  = implode(',', $vitals_time);
        $vitals_data1  = implode(',', $vitals_data);
        // dd($vitals_time1);
        return view("admin.ipd.reports.pat_temperature_pdf", ['vitals_data1' => $vitals_data1, "vitals_time1" => $vitals_time1, "psn_t_patvitals" => $psn_t_patvitals, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);

        // $pdf = PDF::loadView("admin.ipd.reports.pat_temperature_pdf", ["psn_t_patvitals" => $psn_t_patvitals, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        // return $pdf->stream("Consultat Visit Report.pdf", array("Attachment" => false));
        // // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }

    public function nurseRoundListReport($patient_no_fk, $admission_id)
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

        $psn_prescription =  DB::table('psn_t_prescription')->select('psn_t_prescription.*', 'wsec_user.user_fullname')->join('wsec_user', 'psn_t_prescription.au_entry_by', 'wsec_user.user_no_pk')->where("admission_no_fk", $admission_id)->orderby('psn_t_prescription.au_entry_at', 'asc')->get();

        $nurse_round_arr = [];
        if (!empty($psn_prescription)) {
            foreach ($psn_prescription as $psn) {
                if (date('H', strtotime($psn->au_entry_at)) >= 6  && date('H', strtotime($psn->au_entry_at)) < 9) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][6] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][6] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 9  && date('H', strtotime($psn->au_entry_at)) < 12) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][9] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][9] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 12  && date('H', strtotime($psn->au_entry_at)) < 15) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][12] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][12] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 15  && date('H', strtotime($psn->au_entry_at)) < 18) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][15] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][15] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 18  && date('H', strtotime($psn->au_entry_at)) < 21) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][18] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][18] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 21  && date('H', strtotime($psn->au_entry_at)) < 24) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][21] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][21] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
                if (date('H', strtotime($psn->au_entry_at)) >= 24  && date('H', strtotime($psn->au_entry_at)) < 6) {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][24] = [
                        'time' =>  date('H:i:s', strtotime($psn->au_entry_at)),
                        'nurse_name' =>   $psn->user_fullname
                    ];
                } else {
                    $nurse_round_arr[date('d/m/Y', strtotime($psn->au_entry_at))][24] = [
                        'time' =>  '',
                        'nurse_name' =>   ''
                    ];
                }
            }
        }
        //dd($nurse_round_arr);
        $pdf = PDF::loadView("admin.ipd.reports.nurse_round_list_report", ["nurse_round_arr" => $nurse_round_arr, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }
    public function patietnIntakeOutputChart($patient_no_fk, $admission_id)
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

        $ipd_intakeoutput =  DB::table('ipd_intakeoutput')->select('ipd_intakeoutput.*', 'wsec_user.user_fullname')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'ipd_intakeoutput.au_entry_by')
            ->where("ipd_intakeoutput.admission_no_fk", $admission_id)
            ->orderby('ipd_intakeoutput.au_entry_at', 'asc')->get();

        //dd($nurse_round_arr);
        if (Session::get('user.ses_hospital_code') == 'AMCSH'){
            $pdf = PDF::loadView("admin.ipd.reports.patient_intake_output_chart_nicu", ["ipd_intakeoutput" => $ipd_intakeoutput, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
            return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
        }else{
            $pdf = PDF::loadView("admin.ipd.reports.patient_intake_output_chart", ["ipd_intakeoutput" => $ipd_intakeoutput, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
            return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
         }

        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }

    public function supportingReport($patient_no_fk, $admission_id)
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

        $ipd_intakeoutput =  DB::table('ipd_intakeoutput')
            ->where("admission_no_fk", $admission_id)
            ->orderby('au_entry_at', 'asc')->get();
        $supporting_data =  DB::table('ipd_support_chart')->select('ipd_support_chart.*', 'wsec_user.user_fullname', 'sysc_lookupdata.lookupdata_name')->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'ipd_support_chart.au_entry_by')->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookupdata_no_pk', '=', 'ipd_support_chart.instrument_no_fk')->where('ipd_support_chart.admission_no_fk', $admission_id)->orderBy('ipd_support_chart.au_entry_by', 'desc')->get();

        $pdf = PDF::loadView("admin.ipd.reports.supporting_report", ["supporting_data" => $supporting_data, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("supporting-report.pdf", array("Attachment" => false));

        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }

    public function breastFeedingReport($patient_no_fk, $admission_id)
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
// dd($admission_id); WSEC_USER
        $ipd_feeding_data =  DB::table('ipd_breastfeeding_chart feed')->select('feed.*', 'personnel.full_name', 'wsec_user.user_fullname')->leftJoin('hrms_personnel personnel', 'personnel.person_no_pk', '=', 'feed.supervise_no_fk')
        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'feed.au_entry_by')
        ->orderby('feed.au_entry_at', 'desc')->get();

// dd($ipd_feeding_data);
        $pdf = PDF::loadView("admin.ipd.reports.breast_feeding_report", ["ipd_feeding_data" => $ipd_feeding_data, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
            return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));


        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }

    public function cbgreport($patient_no_fk, $admission_id)
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

        // $ipd_intakeoutput =  DB::table('ipd_intakeoutput')
        //     ->where("admission_no_fk", $admission_id)
        //     ->orderby('au_entry_at', 'asc')->get();
        $cbg_data =  DB::table('ipd_cbg_chart')->select('ipd_cbg_chart.*', 'wsec_user.user_fullname')->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'ipd_cbg_chart.au_entry_by')->where('ipd_cbg_chart.admission_no_fk', $admission_id)->orderby('ipd_cbg_chart.au_entry_at', 'desc')->get();

        $pdf = PDF::loadView("admin.ipd.reports.cbg_report", ["cbg_data" => $cbg_data, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
            return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
    }

    public function patientDailyFollowupStatement($patient_no_fk, $admission_id, $date = "")
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

        // $ipd_symptoms =  DB::table('ipd_dailyfollowup_ds_ns_mst')
        //     ->join('ipd_dailyfollowup_ds_ns_chd', 'ipd_dailyfollowup_ds_ns_mst.dfollowupmst_no_pk', 'ipd_dailyfollowup_ds_ns_chd.dfollowupmst_no_fk')
        //     ->select('ipd_dailyfollowup_ds_ns_chd.*','ipd_dailyfollowup_ds_ns_mst.')
        //     ->where("ipd_dailyfollowup_ds_ns_mst.admission_no_fk", $admission_id)
        //     ->orderby('ipd_dailyfollowup_ds_ns_mst.au_entry_at', 'asc')->get();

        $followupdate = !empty($date) ?  date('Y-m-d', strtotime($date)) : date('Y-m-d');
        $ipd_symptoms =  DB::table('ipd_dailyfollowup_ds_ns_mst')
            ->join('ipd_dailyfollowup_ds_ns_chd', 'ipd_dailyfollowup_ds_ns_chd.dfollowupmst_no_fk', 'ipd_dailyfollowup_ds_ns_mst.dfollowupmst_no_pk')
            ->select('ipd_dailyfollowup_ds_ns_chd.*')
            ->whereRaw("trunc(dfollowupmst_date) =   '$followupdate'")
            ->get();

        $patient_vitals =  DB::table('psn_t_patvitals')->where('admission_no_fk', $admission_id)->whereRaw("trunc(vital_date) =   '$followupdate'")->get();
        $patient_vitals_arr = [];
        if (!empty(($patient_vitals))) {
            foreach ($patient_vitals as $vitals) {
                if (isset($vitals->pulse_val)) {
                    if (date('H', strtotime($vitals->vital_date)) >= 6  && date('H', strtotime($vitals->vital_date)) < 12) {
                        $patient_vitals_arr["Pulse / Heart Rate"]["MORNING"] = [
                            'value' => $vitals->pulse_val,

                        ];
                    } elseif (date('H', strtotime($vitals->vital_date)) >= 12  && date('H', strtotime($vitals->vital_date)) < 18) {
                        $patient_vitals_arr["Pulse / Heart Rate"]["EVENING"] = [
                            'value' => $vitals->pulse_val,

                        ];
                    } else {
                        $patient_vitals_arr["Pulse / Heart Rate"]["NIGHT"] = [
                            'value' => $vitals->pulse_val,

                        ];
                    }
                }

                if (isset($vitals->bp_val_sys)) {
                    if (date('H', strtotime($vitals->vital_date)) >= 6  && date('H', strtotime($vitals->vital_date)) < 12) {
                        $patient_vitals_arr["BP (mmHg)"]["MORNING"] = [
                            'value' => $vitals->bp_val_sys . '/' . $vitals->bp_val_dia,

                        ];
                    } elseif (date('H', strtotime($vitals->vital_date)) >= 12  && date('H', strtotime($vitals->vital_date)) < 18) {
                        $patient_vitals_arr["BP (mmHg)"]["EVENING"] = [
                            'value' => $vitals->bp_val_sys . '/' . $vitals->bp_val_dia,

                        ];
                    } else {
                        $patient_vitals_arr["BP (mmHg)"]["NIGHT"] = [
                            'value' => $vitals->bp_val_sys . '/' . $vitals->bp_val_dia,

                        ];
                    }
                }


                if (isset($vitals->temp_val)) {
                    if (date('H', strtotime($vitals->vital_date)) >= 6  && date('H', strtotime($vitals->vital_date)) < 12) {
                        $patient_vitals_arr["Temparature"]["MORNING"] = [
                            'value' => $vitals->temp_val,

                        ];
                    } elseif (date('H', strtotime($vitals->vital_date)) >= 12  && date('H', strtotime($vitals->vital_date)) < 18) {
                        $patient_vitals_arr["Temparature"]["EVENING"] = [
                            'value' => $vitals->temp_val,

                        ];
                    } else {
                        $patient_vitals_arr["Temparature"]["NIGHT"] = [
                            'value' => $vitals->temp_val,

                        ];
                    }
                }

                if (isset($vitals->rr_value)) {
                    if (date('H', strtotime($vitals->vital_date)) >= 6  && date('H', strtotime($vitals->vital_date)) < 12) {
                        $patient_vitals_arr["Resp Rate"]["MORNING"] = [
                            'value' => $vitals->rr_value,

                        ];
                    } elseif (date('H', strtotime($vitals->vital_date)) >= 12  && date('H', strtotime($vitals->vital_date)) < 18) {
                        $patient_vitals_arr["Resp Rate"]["EVENING"] = [
                            'value' => $vitals->rr_value,

                        ];
                    } else {
                        $patient_vitals_arr["Resp Rate"]["NIGHT"] = [
                            'value' => $vitals->rr_value,

                        ];
                    }
                }
                if (isset($vitals->spo2_value)) {
                    if (date('H', strtotime($vitals->vital_date)) >= 6  && date('H', strtotime($vitals->vital_date)) < 12) {
                        $patient_vitals_arr["SPO2"]["MORNING"] = [
                            'value' => $vitals->spo2_value,

                        ];
                    } elseif (date('H', strtotime($vitals->vital_date)) >= 12  && date('H', strtotime($vitals->vital_date)) < 18) {
                        $patient_vitals_arr["SPO2"]["EVENING"] = [
                            'value' => $vitals->spo2_value,

                        ];
                    } else {
                        $patient_vitals_arr["SPO2"]["NIGHT"] = [
                            'value' => $vitals->spo2_value,

                        ];
                    }
                }
            }
        }
        $inv_list  = DB::table('ipd_investigation_result_list')->where('admission_no_pk', $admission_id)->where('result_entry_date', $followupdate)->get();

        $ipd_doctor =  DB::table('ipd_dailyfollowup_ds_ns_mst')
            ->join('hrms_personnel', 'ipd_dailyfollowup_ds_ns_mst.followup_by_doc_person_no_fk', 'hrms_personnel.person_no_pk')
            ->select('ipd_dailyfollowup_ds_ns_mst.*', 'hrms_personnel.full_name', 'hrms_personnel.doctor_signature')
            ->whereRaw("trunc(dfollowupmst_date) =   '$followupdate'")
            ->get();

        $visit_arr = [];
        if (!empty(($ipd_doctor))) {
            foreach ($ipd_doctor as $doctor) {

                if (date('H', strtotime($doctor->au_entry_at)) >= 6  && date('H', strtotime($doctor->au_entry_at)) < 12) {
                    $visit_arr["MORNING"] = $doctor->doctor_signature;
                } elseif (date('H', strtotime($doctor->au_entry_at)) >= 12  && date('H', strtotime($doctor->au_entry_at)) < 18) {
                    $visit_arr["EVENING"] = $doctor->doctor_signature;
                } else {
                    $visit_arr["NIGHT"] =  $doctor->doctor_signature;
                }
            }
        }
        // dd($visit_arr);
        $pdf = PDF::loadView("admin.ipd.reports.daily_followup_statement", ["visit_arr" => $visit_arr, "inv_list" => $inv_list, "patient_vitals_arr" => $patient_vitals_arr, "ipd_symptoms" => $ipd_symptoms, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode]);
        return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
    }

    // reports
    public function nicuVitalsReport($patient_no_fk, $admission_id)
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

        $patient_vitals =  DB::table('psn_t_patvitals')->select('psn_t_patvitals.*', 'wsec_user.user_fullname')->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'psn_t_patvitals.au_entry_by')->where("psn_t_patvitals.admission_no_fk", $admission_id)->orderby('psn_t_patvitals.au_entry_at', 'asc')->get();
        // dd($patient_vitals);
        $pdf = PDF::loadView("admin.ipd.reports.nicu_vitals_report", ["patient_vitals" => $patient_vitals, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode])->setPaper('a4', 'landscape');
        return $pdf->stream("nicu-vitals-report.pdf", array("Attachment" => false));
        // return Template::loadView("admin.ipd.reports.pat_vitals_report");
    }
}
