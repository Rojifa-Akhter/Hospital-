<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabRequestController extends Controller
{
    public function sendLabelData(Request $request, $id = "")
    {
        try {
            $ipAddress = $request->ip();
            $hostname = gethostbyaddr($ipAddress);
            $labOrders = DB::table('labt_samplecoll_wl_vw')->select('pat_registration_wl_vw.patient_name', 'labt_samplecoll_wl_vw.age', 'labt_samplecoll_wl_vw.lab_code', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.patient_code', 'labt_samplecoll_wl_vw.sam_name', 'labt_samplecoll_wl_vw.test_name_list', 'labt_samplecoll_wl_vw.serviceunit_name', 'labt_samplecoll_wl_vw.sc_sample_coll_keyed_time', 'labt_samplecoll_wl_vw.container_item_name', 'labt_samplecoll_wl_vw.admission_no_pk', 'labt_samplecoll_wl_vw.invoice_no_fk', 'labt_samplecoll_wl_vw.label_print_machine_name', 'labt_samplecoll_wl_vw.print_type')->leftJoin('pat_registration_wl_vw', 'pat_registration_wl_vw.patient_no_pk', '=', 'labt_samplecoll_wl_vw.patient_no_pk')->where('label_print_ind', 1)->get();

            // dd( $labOrders);

            if ($labOrders->isEmpty()) {
                return response()->json([
                    "success" => false,
                    "message" => "Lab order not found.",
                    "data" => []
                ]);
            }
            $dataToSend = $labOrders->map(function ($labOrder) use ($ipAddress) {
                $pat_location = !empty($labOrder->admission_no_pk) ? "IP" : "OP";
                $SpecimenCode = $labOrder->print_type == "AUX" ? 'Collection-AUX' : strtoupper($labOrder->container_item_name);
                return [
                    'PatientName'       => $labOrder->patient_name,
                    'PatientAge'        => $labOrder->age,
                    'Barcode'           => $labOrder->lab_code,
                    'PatientGender'     => $labOrder->gender_txt,
                    'PatientID'         => $labOrder->patient_code,
                    'BillID'            => $labOrder->invoice_no_fk,
                    'SpecimenName'      => strtoupper($labOrder->sam_name),
                    'SpecimenCode'      =>  $SpecimenCode,
                    'TestName'          => $labOrder->test_name_list,
                    'TestCode'          => $labOrder->test_name_list,
                    'PatientLocation'   => $pat_location,
                    'DepartmentName'    => $labOrder->serviceunit_name,
                    'DepartmentCode'    => $labOrder->serviceunit_name,
                    'PhlebotomyDeskID'  => $labOrder->label_print_machine_name,
                    'TestShortCode'     => $labOrder->test_name_list,
                    'TimeStamp'         => date('d/m/Y h:i a', strtotime($labOrder->sc_sample_coll_keyed_time)),
                    'GenericData1'      => null,
                    'GenericData2'      => null
                ];
            });
            // dd( $dataToSend);
            $response = [
                "success" => true,
                "message" => "Successfull",
                "data" => $dataToSend,
            ];
        } catch (\Exception $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage(),
                "data" => [],
            ];
        }
        return response()->json($response);
    }

    public function updateLabelPrintInd(Request $request)
    {

        try {
            $labCode = $request->lab_code;
            $printInd = $request->label_print_ind;
            $data = [
                'label_print_ind' => null,
            ];
            DB::table('labt_samplecoll')->where('lab_code', $labCode)->update($data);
            DB::commit();
            $response = [
                "success" => true,
                "message" => "Record updated successfully",
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            $response = [
                "success" => false,
                "message" => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }


    // api for website

    public function doctorDetails(Request $request, $id)
    {
        $doctor_details = DB::table('DOCTOR_INFO_VW')
            ->select('full_name', 'card_no', 'person_no_pk', 'su_name', 'serviceunit_no_fk', 'specialization', 'email_personal', 'gender_txt', 'photo_name')
            ->where('card_no', $id)->first();
        return response()->json($doctor_details);
    }
}
