<?php

namespace App\Http\Controllers\CPH;

use App\Http\Controllers\Controller;
use App\CPHPatientAppointment;
use Illuminate\Http\Request;
use App\Library\Template;
use \PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;

class MedicineDistributionController extends Controller
{
    public function medicineDistributionDashboard()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_distribution_dashboard");
    }
    public function medicineDetailStock()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_detail_stock");
    }

    public function medicinePacketPending()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_packet_pending");
    }
    public function medicineDistributionReport()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_distribution_report");
    }
    public function medicineBoxaDistributionPending()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_box_a_distribution_pending");
    }
    public function medicineBoxaDistribution()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_box_a_distribution");
    }
    public function medicinRackIn()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_rack_in");
    }
    public function medicineCustomerToken()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_customer_token");
    }

    public function medicineCustomerTokenPrint()
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();
        $barcode = new BarcodeGenerator();
        $barcode->setText('160461');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.cph.medicine_distribution.medicine_customer_token_print", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo, ]);
        return $pdf->stream("medicine_customer_token_print.pdf");
    }

    public function medicineRackOut()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_rack_out");
    }

    public function medicineRackDistributionPending()
    {
        return Template::loadView("admin.cph.medicine_distribution.medicine_rack_distribution_pending");
    }


    public function medicinePacketDetail()
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText('160461');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $barcode_no = $barcode->generate();
        return Template::loadView("admin.cph.medicine_distribution.medicine_pending_detail", ['barcode_no' => $barcode_no]);
    }
    public function medicinePacketPrint()
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();
        $barcode = new BarcodeGenerator();
        $barcode->setText('160461');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.cph.medicine_distribution.medicine_packet_print", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo, ]);
        return $pdf->stream("medicine_packet_print.pdf");
    }

    public function blankPrescriptionForm()
    {
        $po_session_hospital = Session::get('user.ses_hospital_no_pk');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        // $blankPrescriptionPrint = DB::table('patn_appointment_vw a')->where('a.appoint_no_pk', $id)->first();
        // // dd($blankPrescriptionPrint);
        // // $prescription_mst = DB::table('psn_t_prescription_vw')->where('appoint_no_fk', '=', $id)->first();
        // $vitals =  DB::table('psn_t_patvitals')->where('patapp_no_fk', $id)->first();
        // $allergy =  DB::table('emr_allergies')->where('appoint_no_fk', $id)->get();
        // $chronic_item =  DB::table('emr_chronic_disease')->where('appoint_no_fk', $id)->get();
        // $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('appointment_pk_no', '=', $id)->get();
        // $left_side_arr = [];
        // foreach ($prescription_dtl as $dtl_row) {
        //     $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
        // }

        // dd($blankPrescriptionPrint);
        // $title = $blankPrescriptionPrint->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText('123456');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(100);
        $barcode_no = $barcode->generate();

        // $title_app = $blankPrescriptionPrint->appoint_no_pk;
        $barcode_app = new BarcodeGenerator();
        $barcode_app->setText('123456');
        $barcode_app->setType(BarcodeGenerator::Code128);
        $barcode_app->setLabel('');
        $barcode_app->setScale(1);
        $barcode_app->setThickness(25);
        $barcode_app->setFontSize(100);
        $barcode_app_no = $barcode_app->generate();

        return view("admin.cph.medicine_distribution.blank_prescription_print", ['po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'barcode_app_no' => $barcode_app_no]);
        }

    }

