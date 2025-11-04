<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
trait InvoiceData
{
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function getInvoiceAutocompleteList(Request $request)
    {
        //finc_voucherwise_sum_vw    invoice_no_fk
        $invoice_infos = DB::table("finc_invoicewise_sum_vw")
            ->select('invoice_no_pk', 'invoice_code', 'patient_name', 'patient_code', 'age', 'gender_txt', 'mobile1')
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))
            ->where('invoice_code', 'like', '%' . strtoupper($request->search_data) . '%');
            if (in_array(Session::get('user.ses_hospital_code'),['IMPALA'])) {
                $invoice_infos->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%');
            }
            // ->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%')
           $invoice_info= $invoice_infos->orderBy('invoice_code', 'desc')
            ->get();
        // dd(Session::get('user.ses_hospital_code'),$invoice_info);
        $invoice_data = [];
        if (!empty($invoice_info)) {
            foreach ($invoice_info as $invoice) {
                $invoice_data[] = array(
                    'invoice_id' => $invoice->invoice_no_pk,
                    'invoice_code' => $invoice->invoice_code,
                    'patient_code' => $invoice->patient_code,
                    'patient_name' => $invoice->patient_name,
                    'age' => $invoice->age,
                    'gender' => $invoice->gender_txt,
                    'mobile' => $invoice->mobile1

                );
            }
            return $invoice_data;
        }

    }
      public function getInvoiceAutocompleteListOp(Request $request)
    {
        //finc_voucherwise_sum_vw    invoice_no_fk
        $invoice_infos = DB::table("finc_invoicewise_sum_vw")
            ->select('invoice_no_pk', 'invoice_code', 'patient_name', 'patient_code', 'age', 'gender_txt', 'mobile1')
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))
            ->whereNotIn('module_code', ['PHR','PHR-I','PHR-O','PHR-D'])
            ->where('invoice_code', 'like', '%' . strtoupper($request->search_data) . '%');
            if (in_array(Session::get('user.ses_hospital_code'),['IMPALA'])) {
                $invoice_infos->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%');
            }
            // ->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%')
           $invoice_info= $invoice_infos->orderBy('invoice_code', 'desc')
            ->get();

        $invoice_data = [];
        if (!empty($invoice_info)) {
            foreach ($invoice_info as $invoice) {
                $invoice_data[] = array(
                    'invoice_id' => $invoice->invoice_no_pk,
                    'invoice_code' => $invoice->invoice_code,
                    'patient_code' => $invoice->patient_code,
                    'patient_name' => $invoice->patient_name,
                    'age' => $invoice->age,
                    'gender' => $invoice->gender_txt,
                    'mobile' => $invoice->mobile1

                );
            }
            return $invoice_data;
        }

    }

    public function getCafeInvoiceAutocompleteList(Request $request)
    {
        //FINC_VOUCHERWISE_SUM_VW_PHR invoice_no_fk
        $invoice_info = DB::table("finc_invoicewise_sum_cafe_vw")
            ->select('invoice_no_pk', 'invoice_code', 'patient_name', 'patient_code', 'age', 'gender_txt', 'mobile1')
            ->where('invoice_code', 'like', '%' . strtoupper($request->search_data) . '%')
            // ->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%')
            ->orderBy('invoice_code', 'desc')
            ->get();

        $invoice_data = [];
        if (!empty($invoice_info)) {
            foreach ($invoice_info as $invoice) {
                $invoice_data[] = array(
                    'invoice_id' => $invoice->invoice_no_pk,
                    'invoice_code' => $invoice->invoice_code,
                    'patient_code' => $invoice->patient_code,
                    'patient_name' => $invoice->patient_name,
                    'age' => $invoice->age,
                    'gender' => $invoice->gender_txt,
                    'mobile' => $invoice->mobile1

                );
            }
            return $invoice_data;
        }

    }
    public function getPosInvoiceAutocompleteList(Request $request)
    {
        //FINC_VOUCHERWISE_SUM_VW_PHR invoice_no_fk
        $invoice_info = DB::table("finc_invoicewise_sum_phr_vw")
            ->select('invoice_no_pk', 'invoice_code', 'patient_name', 'patient_code', 'age', 'gender_txt', 'mobile1','admission_no_pk')
            ->where('invoice_code', 'like', '%' . strtoupper($request->search_data) . '%')
            // ->orWhere('mobile1', 'like', '%' . strtoupper($request->search_data) . '%')
            ->orderBy('invoice_code', 'desc')
            ->get();

        $invoice_data = [];
        if (!empty($invoice_info)) {
            foreach ($invoice_info as $invoice) {
                $invoice_data[] = array(
                    'invoice_id' => $invoice->invoice_no_pk,
                    'invoice_code' => $invoice->invoice_code,
                    'patient_code' => $invoice->patient_code,
                    'patient_name' => $invoice->patient_name,
                    'age' => $invoice->age,
                    'gender' => $invoice->gender_txt,
                    'mobile' => $invoice->mobile1,
                    'admission_no_pk' => $invoice->admission_no_pk
                );
            }
            return $invoice_data;
        }

    }

    public function getAppointmentAutocompleteList(Request $request)
    {
        $appoint_info = DB::table('wl_patn_appointment_vw')
            ->select('appoint_no_pk', 'appoint_code')
            ->where('appoint_code', 'like', '%' . $request->search_data . '%')->get();

        $appoint_data = [];
        if (!empty($appoint_info)) {
            foreach ($appoint_info as $appoint) {
                $appoint_data[] = array(
                    'appoint_id' => $appoint->appoint_no_pk,
                    'appoint_code' => $appoint->appoint_code
                );
            }
            return $appoint_data;
        }
    }
}
