<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;




class TestIPDController extends Controller
{
    // intra operative nursing form
    public function inHouseTransferForm($admission_id = "")
    {
        $pat_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $inHouseTransferNursingFromData = DB::table('ipd_inhouse_transfer_nursing_form')->where('admission_no_fk', $admission_id)->first();
        return Template::loadView("admin.ipd.reports.in_house_transfer_form", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'inHouseTransferNursingFromData' => $inHouseTransferNursingFromData]);
    }

    public function inHouseTransferFormSave(Request $request)
    {
        // dd($request->all());
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        try {
            DB::beginTransaction();

            $transferFormNoPk = $request->input('transfer_form_no_pk'); // check if updating or inserting

            $data = [
                'admission_no_fk' => $request->input('admission_id'),
                'patient_no_fk' => $request->input('pat_id'),
                'patient_name' => $request->input('patient_name'),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
                'reg_no' => $request->input('reg_no'),
                'cabin' => $request->input('cabin'),
                'ward' => $request->input('ward'),
                'bed_number' => $request->input('bed_number'),
                'reg_date' => $request->input('reg_date') ? Carbon::parse($request->input('reg_date')) : null,
                'doctor_no_fk' => $request->input('doctor_no_fk'),
                'doctor_name' => $request->input('doctor_name'),
                'date_of_transfer' => $request->input('date_of_transfer') ? Carbon::parse($request->input('date_of_transfer')) : null,
                'vital_temp' => $request->input('vital_temp'),
                'vital_pulse' => $request->input('vital_pulse'),
                'vital_resp' => $request->input('vital_resp'),
                'vital_spo2' => $request->input('vital_spo2'),
                'vital_bp' => $request->input('vital_bp'),
                'vital_painscore' => $request->input('vital_painscore'),
                'allergies' => $request->input('allergies'),
                'allergies_specify' => $request->input('allergies_specify'),
                'diet_advice' => $request->input('diet_advice'),
                'informed_dietry' => $request->input('informed_dietry'),
                'invasive_lines_infus' => $request->input('invasive_lines_infus'),
                'peripheralnother' => $request->input('peripheralnother'),
                'peripheralnother_site' => $request->input('peripheralnother_site'),
                'infusions' => $request->input('infusions'),
                'infusions_rate' => $request->input('infusions_rate'),
                'tubes_drains_amount' => $request->input('tubes_drains_amount'),
                'tube_drain_chest' => $request->input('tube_drain_chest'),
                'tube_drain_abdomen' => $request->input('tube_drain_abdomen'),
                'tube_drain_foleys' => $request->input('tube_drain_foleys'),
                'tube_drain_ngtube' => $request->input('tube_drain_ngtube'),
                'tube_drain_other' => $request->input('tube_drain_other'),
                'intake' => $request->input('intake'),
                'output' => $request->input('output'),
                'transfer_req_placed_staff' => $request->input('transfer_req_placed_staff'),
                'pat_transfer_info_nxt_unit' => $request->input('pat_transfer_info_nxt_unit'),
                'pat_transfer_by_whom' => $request->input('pat_transfer_by_whom'),
                'unit_dropdown' => $request->input('unit_dropdown'),
                'before_shitting_chk' => $request->input('before_shitting_chk'),
                'transfer_info_pat_bystander' => $request->input('transfer_info_pat_bystander'),
                'transfer_avail_bystander' => $request->input('transfer_avail_bystander'),
                'pat_family_edu_given' => $request->input('pat_family_edu_given'),
                'patient_belongings' => $request->input('patient_belongings'),
                'pat_belongings_secify' => $request->input('pat_belongings_secify'),
                'items_handed_over' => $request->input('items_handed_over'),
                'debulk_inv_files' => $request->input('debulk_inv_files'),
                'debulk_inv_files_specify' => $request->input('debulk_inv_files_specify'),
                'thermometer_hand_rub_etc' => $request->input('thermometer_hand_rub_etc'),
                'skin_integrity_intact' => $request->input('skin_integrity_intact'),
                'skin_int_intact_detail' => $request->input('skin_int_intact_detail'),
                'leaving_unit_nurse_sigh' => $request->input('leaving_unit_nurse_sigh'),
                'receive_unit_nurse_sigh' => $request->input('receive_unit_nurse_sigh'),
                'leaving_unit_hn_sigh' => $request->input('leaving_unit_hn_sigh'),
                'receive_unit_hn_sigh' => $request->input('receive_unit_hn_sigh'),
                'leaving_unit_tl_sigh' => $request->input('leaving_unit_tl_sigh'),
                'receive_unit_tl_sigh' => $request->input('receive_unit_tl_sigh'),
                'skin_related_issues' => $request->input('skin_related_issues'),
                'any_other_remarks' => $request->input('any_other_remarks'),
                'sign_handed_over_rn' => $request->input('sign_handed_over_rn'),
                'empid_handed_over_rn' => $request->input('empid_handed_over_rn'),
                'datetime_handed_over_rn' => $request->input('datetime_handed_over_rn') ? Carbon::parse($request->input('datetime_handed_over_rn')) : null,
                'sign_receivingr_rn' => $request->input('sign_receivingr_rn'),
                'empid_receiving_rn' => $request->input('empid_receiving_rn'),
                'datetime_receiving_rn' => $request->input('datetime_receiving_rn') ? Carbon::parse($request->input('datetime_receiving_rn')) : null,
            ];

            if (empty($transferFormNoPk)) {
                // insert new
                $sequence = DB::getSequence();
                $transferFormNoPk = $sequence->nextValue('transfer_form_no_pk_seq');

                $data['transfer_form_no_pk'] = $transferFormNoPk;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] = now();
                $data['au_entry_session'] = session()->getId();
                $data['au_entry_hospital_pk_no'] = $hospital_no_pk;

                DB::table('ipd_inhouse_transfer_nursing_form')->insert($data);
            } else {
                // update existing
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] = now();
                $data['au_update_session'] = session()->getId();
                $data['au_update_hospital_pk_no'] = $hospital_no_pk;

                DB::table('ipd_inhouse_transfer_nursing_form')
                    ->where('transfer_form_no_pk', $transferFormNoPk)
                    ->update($data);
            }

            DB::commit();

            return response()->json(['msg' => 'Data saved successfully.', 'title' => 'Success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['msg' => 'Failed to save data.', 'title' => 'Error', 'error' => $th->getMessage()]);
        }
    }


    public function inHouseTransferFormPdf($admission_id = "")
    {
        $pat_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $inHouseTransferFormData = DB::table('ipd_inhouse_transfer_nursing_form')->where('admission_no_fk', $admission_id)->first();
        // dd($inHouseTransferFormData);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($pat_info->admission_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($pat_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();

        return View("admin.ipd.reports.in_house_transfer_form_pdf", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'inHouseTransferFormData' => $inHouseTransferFormData, 'po_hospital_details' => $po_hospital_details, 'invoice_barcode' => $invoice_barcode, 'pat_barcode' => $pat_barcode]);
        // return $pdf->stream('operation_note_pdf.pdf');
    }



    // intra recovery nursing form
    public function recoveryNursingRecordForm($admission_id = "")
    {
        $pat_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $intraOperativeNursingData = DB::table('ipd_intraoperative')->where('admission_no_fk', $admission_id)->first();
        // $intraOperativeNursingData=[];
        return Template::loadView("admin.ipd.reports.recovery_nursign_record_form", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'intraOperativeNursingData' => $intraOperativeNursingData]);
        // return View("admin.ipd.reports.in_house_transfer_form", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'intraOperativeNursingData' => $intraOperativeNursingData]);
        // return View("admin.ipd.reports.in_house_transfer_form");
    }





    // Clabsi insertion & maintenance bundle
    public function clabsiForm($admission_id = "")
    {
        $pat_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $inHouseTransferNursingFromData = DB::table('ipd_inhouse_transfer_nursing_form')->where('admission_no_fk', $admission_id)->first();
        return Template::loadView("admin.ipd.reports.in_house_transfer_form", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'inHouseTransferNursingFromData' => $inHouseTransferNursingFromData]);
    }

    public function storeClabsiForm(Request $request)
    {
        // dd($request->all());
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        try {
            DB::beginTransaction();

            $transferFormNoPk = $request->input('transfer_form_no_pk'); // check if updating or inserting

            $data = [
                'admission_no_fk' => $request->input('admission_id'),
                'patient_no_fk' => $request->input('pat_id'),
                'patient_name' => $request->input('patient_name'),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
                'reg_no' => $request->input('reg_no'),
                'cabin' => $request->input('cabin'),
                'ward' => $request->input('ward'),
                'bed_number' => $request->input('bed_number'),
                'reg_date' => $request->input('reg_date') ? Carbon::parse($request->input('reg_date')) : null,
                'doctor_no_fk' => $request->input('doctor_no_fk'),
                'doctor_name' => $request->input('doctor_name'),
                'date_of_transfer' => $request->input('date_of_transfer') ? Carbon::parse($request->input('date_of_transfer')) : null,
                'vital_temp' => $request->input('vital_temp'),
                'vital_pulse' => $request->input('vital_pulse'),
                'vital_resp' => $request->input('vital_resp'),
                'vital_spo2' => $request->input('vital_spo2'),
                'vital_bp' => $request->input('vital_bp'),
                'vital_painscore' => $request->input('vital_painscore'),
                'allergies' => $request->input('allergies'),
                'allergies_specify' => $request->input('allergies_specify'),
                'diet_advice' => $request->input('diet_advice'),
                'informed_dietry' => $request->input('informed_dietry'),
                'invasive_lines_infus' => $request->input('invasive_lines_infus'),
                'peripheralnother' => $request->input('peripheralnother'),
                'peripheralnother_site' => $request->input('peripheralnother_site'),
                'infusions' => $request->input('infusions'),
                'infusions_rate' => $request->input('infusions_rate'),
                'tubes_drains_amount' => $request->input('tubes_drains_amount'),
                'tube_drain_chest' => $request->input('tube_drain_chest'),
                'tube_drain_abdomen' => $request->input('tube_drain_abdomen'),
                'tube_drain_foleys' => $request->input('tube_drain_foleys'),
                'tube_drain_ngtube' => $request->input('tube_drain_ngtube'),
                'tube_drain_other' => $request->input('tube_drain_other'),
                'intake' => $request->input('intake'),
                'output' => $request->input('output'),
                'transfer_req_placed_staff' => $request->input('transfer_req_placed_staff'),
                'pat_transfer_info_nxt_unit' => $request->input('pat_transfer_info_nxt_unit'),
                'pat_transfer_by_whom' => $request->input('pat_transfer_by_whom'),
                'unit_dropdown' => $request->input('unit_dropdown'),
                'before_shitting_chk' => $request->input('before_shitting_chk'),
                'transfer_info_pat_bystander' => $request->input('transfer_info_pat_bystander'),
                'transfer_avail_bystander' => $request->input('transfer_avail_bystander'),
                'pat_family_edu_given' => $request->input('pat_family_edu_given'),
                'patient_belongings' => $request->input('patient_belongings'),
                'pat_belongings_secify' => $request->input('pat_belongings_secify'),
                'items_handed_over' => $request->input('items_handed_over'),
                'debulk_inv_files' => $request->input('debulk_inv_files'),
                'debulk_inv_files_specify' => $request->input('debulk_inv_files_specify'),
                'thermometer_hand_rub_etc' => $request->input('thermometer_hand_rub_etc'),
                'skin_integrity_intact' => $request->input('skin_integrity_intact'),
                'skin_int_intact_detail' => $request->input('skin_int_intact_detail'),
                'leaving_unit_nurse_sigh' => $request->input('leaving_unit_nurse_sigh'),
                'receive_unit_nurse_sigh' => $request->input('receive_unit_nurse_sigh'),
                'leaving_unit_hn_sigh' => $request->input('leaving_unit_hn_sigh'),
                'receive_unit_hn_sigh' => $request->input('receive_unit_hn_sigh'),
                'leaving_unit_tl_sigh' => $request->input('leaving_unit_tl_sigh'),
                'receive_unit_tl_sigh' => $request->input('receive_unit_tl_sigh'),
                'skin_related_issues' => $request->input('skin_related_issues'),
                'any_other_remarks' => $request->input('any_other_remarks'),
                'sign_handed_over_rn' => $request->input('sign_handed_over_rn'),
                'empid_handed_over_rn' => $request->input('empid_handed_over_rn'),
                'datetime_handed_over_rn' => $request->input('datetime_handed_over_rn') ? Carbon::parse($request->input('datetime_handed_over_rn')) : null,
                'sign_receivingr_rn' => $request->input('sign_receivingr_rn'),
                'empid_receiving_rn' => $request->input('empid_receiving_rn'),
                'datetime_receiving_rn' => $request->input('datetime_receiving_rn') ? Carbon::parse($request->input('datetime_receiving_rn')) : null,
            ];

            if (empty($transferFormNoPk)) {
                // insert new
                $sequence = DB::getSequence();
                $transferFormNoPk = $sequence->nextValue('transfer_form_no_pk_seq');

                $data['transfer_form_no_pk'] = $transferFormNoPk;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] = now();
                $data['au_entry_session'] = session()->getId();
                $data['au_entry_hospital_pk_no'] = $hospital_no_pk;

                DB::table('ipd_inhouse_transfer_nursing_form')->insert($data);
            } else {
                // update existing
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] = now();
                $data['au_update_session'] = session()->getId();
                $data['au_update_hospital_pk_no'] = $hospital_no_pk;

                DB::table('ipd_inhouse_transfer_nursing_form')
                    ->where('transfer_form_no_pk', $transferFormNoPk)
                    ->update($data);
            }

            DB::commit();

            return response()->json(['msg' => 'Data saved successfully.', 'title' => 'Success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['msg' => 'Failed to save data.', 'title' => 'Error', 'error' => $th->getMessage()]);
        }
    }


    public function clabsiFormPDF($admission_id = "")
    {
        $pat_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $inHouseTransferFormData = DB::table('ipd_inhouse_transfer_nursing_form')->where('admission_no_fk', $admission_id)->first();
        // dd($inHouseTransferFormData);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($pat_info->admission_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($pat_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();

        return View("admin.ipd.reports.in_house_transfer_form_pdf", ['admission_id' => $admission_id, 'pat_info' => $pat_info, 'inHouseTransferFormData' => $inHouseTransferFormData, 'po_hospital_details' => $po_hospital_details, 'invoice_barcode' => $invoice_barcode, 'pat_barcode' => $pat_barcode]);
        // return $pdf->stream('operation_note_pdf.pdf');
    }






}
