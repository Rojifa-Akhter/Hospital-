<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Facades\DB;
use PDF;

class CaseSheetController extends Controller
{
    //
    public function ipdCaseSheet($patient_id, $admission_uid)
    {
        ini_set("max_execution_time", -1);

        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_uid)
            ->get()->first();

        $ipd_vitals = DB::table('psn_t_patvitals_ipd_vw')->where('patient_no_fk', $patient_id)->where('admission_no_fk', $patient_info->admission_no_pk)->orderBy('vital_date', 'desc')->get()->toArray();
        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->where('continue_ind', 1)->orderBy('au_entry_at', 'desc')->get()->toArray();
        $prescription_med_doc = DB::table('psn_t_prescription_med_vw')->select('au_entry_at','ipd_instructed_doc_name','prescription_no_fk')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->groupBy('au_entry_at','ipd_instructed_doc_name','prescription_no_fk')->orderBy('au_entry_at', 'desc')->get()->toArray();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->whereIn('LOOKUPDATA_UID', ['RAD', 'LAB'])->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_ot_list = DB::table('opt_ot_confirmlist_wl_vw')->where('patient_no_fk', $patient_id)->where('admission_no_fk', $patient_info->admission_no_pk)->orderBy('ot_req_date', 'desc')->get()->toArray();
        $ipd_diet_list = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->where('LOOKUPDATA_UID', 'FOOD')->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_otherServices = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->where('LOOKUPDATA_UID', 'SERVICE')->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_discontinue_med_list = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $patient_id)->where('admission_pk_no', $patient_info->admission_no_pk)->where('continue_ind', 0)->orderBy('au_entry_at', 'desc')->get()->toArray();

        $in_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {

                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;
                $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data . ' (' . $dtl_row->lookupdata_uid . ')';
                   $in_arr[date('d/m/Y',strtotime($dtl_row->au_entry_at))][] = date('d/m/Y',strtotime($dtl_row->au_entry_at));
                }

                if (in_array($dtl_row->lookupdata_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($patient_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($admission_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $prescription_med_by_date_arr = [];

        if (!empty($prescription_med)) {
            foreach ($prescription_med as $row) {
                $prescription_med_by_date_arr[date('d/m/Y', strtotime($row->au_entry_at))] = date('d/m/Y', strtotime($row->au_entry_at));
            }
        }

        // dd($prescription_med_doc);

        $data = [
            'patient_info' => $patient_info,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "in_arr" => $in_arr,
            "pr_arr" => $pr_arr,
            "prescription_med_by_date_arr" => $prescription_med_by_date_arr,
            "prescription_med_doc" => $prescription_med_doc,
        ];

        // return view("admin.case_sheet.case_sheet_pdf", $data);

        $pdf = PDF::loadView("admin.case_sheet.case_sheet_pdf", $data);
        return $pdf->stream("patient_case_sheet.pdf");
    }
}
