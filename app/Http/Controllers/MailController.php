<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\MailEngine;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Facades\DB;
use App;
use \PDF;

class MailController extends Controller
{
    //
    use MailEngine;

    public function mailModal($patient_id)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')->where('a.patient_no_pk', $patient_id)->first();
        return Template::loadView("admin.mail.mail_modal", ['patient_id' => $patient_id, 'patient_info' => $patient_info]);
    }
    public function sendMail(Request $request)
    {
        $id = $request->id;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $id)
            ->get()->first();
        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $id)->orderBy('au_entry_at', 'desc')->get();
        $medical_equiment = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $id)->get();

        $past_medical_records = DB::table('psn_t_prescription_vw a')->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $lab_data = DB::table('labt_invoicedtl_vw a')->select('a.item_name', 'a.report_delivary_date', 'a.invoice_code', 'a.lab_code', 'a.report_no_fk', 'a.prescription_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.labinvoicedtl_no_pk', 'desc')->get();
        $radiology_data = DB::table("radt_invoicedtl_app_wl_vw a")->select('a.hospital_code', 'a.prescription_no_fk', 'a.invoice_code', 'a.item_name', 'a.invoice_date', 'a.radinvoicedtl_no_pk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $prescription_data = DB::table('psn_t_prescription_vw a')->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $current_equiment_data = DB::table('emr_medicalequipment a')->select('h.hospital_code', 'h.hospital_name', 'a.medequ_name', 'a.medequ_start_date', 'a.medequ_end_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $sergical_data = DB::table("opt_ot_confirmlist_wl_vw a")
            ->select('h.hospital_code', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.age', 'a.surg_doctor_name', 'a.ot_date', 'a.surg_doctor_name')
            ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.ot_req_no_pk', 'desc')
            ->get();
        $hospitalized_data = DB::table("ipd_admitted_patlist_vw a")
            ->select('a.admission_date', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.dis_date', 'a.dis_reason')
            // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.admission_no_pk', 'desc')
            ->get();
        $immunization_data = DB::table("emr_patimmunization a")
            ->select('a.immunization_start_date', 'a.immunization_name', 'a.dose_number', 'a.immunization_no_pk')
            // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.au_entry_at', 'desc')
            ->get();
        $family_disease_data = DB::table("emr_familymedhistory a")->select('h.hospital_code', 'a.relation_name', 'a.disease_name', 'a.disease_name', 'a.date_from', 'a.date_to', 'a.severity', 'a.suffered_duration', 'a.death_bydisease_ind', 'a.familymedhistory_no_pk')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();

        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $id)->orderBy('au_entry_at', 'desc')->get();

        $patient_barcode = $patient_info->patient_no_pk;
        $title = "$patient_barcode";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);
        $pdf = PDF::loadView('admin.EMR.emr_report', [
            'pat_barcode' => $barcode_no,
            'patient_info' => $patient_info,
            'po_hospital_details' => $po_hospital_details,
            'alergies_data' => $alergies_data,
            'past_medical_records' => $past_medical_records,
            'lab_data' => $lab_data,
            'radiology_data' => $radiology_data,
            'vitals_data' => $vitals_data,
            'medical_equiment' => $medical_equiment,
            'prescription_data' => $prescription_data,
            'current_equiment_data' => $current_equiment_data,
            'sergical_data' => $sergical_data,
            'hospitalized_data' => $hospitalized_data,
            'immunization_data' => $immunization_data,
            'family_disease_data' => $family_disease_data,
            'patient_barcode' => $patient_barcode,
            'chronic_data' => $chronic_data,
            'pat_barcode' => $barcode_no,
        ]);

        $this->sendCustomMail($request->sender_email, '', $request->subject, $request->message_body, $pdf);
        $message = ['msg' => 'Email Send to User', 'title' => 'Success'];
        return response()->json($message);
    }
}
