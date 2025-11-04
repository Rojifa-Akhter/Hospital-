<?php

namespace App\Http\Controllers;

use App\Library\Template;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

class AdmissionController extends Controller
{
    public function index($id)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $admission_pat = DB::table('IPD_ADMITTED_PATLIST_VW')->where('admission_no_pk',$id)->first();

        $title = $admission_pat->admission_uid;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_admission_no = $barcode->generate();

        $title = $admission_pat->patient_code;
        $pat_barcode = new BarcodeGenerator();
        $pat_barcode->setText($title);
        $pat_barcode->setType(BarcodeGenerator::Code128);
        $pat_barcode->setLabel('');
        $pat_barcode->setScale(1);
        $pat_barcode->setThickness(25);
        $pat_barcode->setFontSize(10);
        $barcode_pat_no = $pat_barcode->generate();
        // dd($admission_pat);
        return Template::loadView("admission.admission", ['admission_pat' => $admission_pat, 'barcode_admission_no' => $barcode_admission_no, 'po_hospital_details' => $po_hospital_details, 'barcode_pat_no' => $barcode_pat_no]);


        // return Template::loadview('admission.admission',compact('admission_pat','barcode'));



    }

    public function store(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'past_m_history' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $admission_no_pk = $request->admission_no_pk;
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('ipd_admission_no_pk_seq') + 1;
                $admissionStore = [
                    'ADM_FORM_PAST_MED_HIST' => $request->past_m_history,
                    'ADM_FORM_ILLNESS_SURGERY' => $request->illness_or_surgery,
                    'ADM_FORM_ALLERGIES' => $request->allergy,
                    'ADM_FORM_RELEVENT_HIST' => $request->relevant,
                    'ADM_FORM_ENTRY_BY' => Auth::id(),
                    'ADM_FORM_ENTRY_TIME' => date('Y-m-d H:i'),
                ];
                DB::table('IPD_ADMISSION_DETAILS')->where('admission_no_pk', $admission_no_pk)->update($admissionStore);
                $this->message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }

    public function admissionPdf($admission_id){
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $admission_pat = DB::table('IPD_ADMITTED_PATLIST_VW')->where('admission_no_pk', $admission_id)->first();
        // dd($admission_pat);
        $title = $admission_pat->admission_uid;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_admission_no = $barcode->generate();

        $title = $admission_pat->patient_code;
        $pat_barcode = new BarcodeGenerator();
        $pat_barcode->setText($title);
        $pat_barcode->setType(BarcodeGenerator::Code128);
        $pat_barcode->setLabel('');
        $pat_barcode->setScale(1);
        $pat_barcode->setThickness(25);
        $pat_barcode->setFontSize(10);
        $barcode_pat_no = $pat_barcode->generate();

        $pdf = PDF::loadView("admission.admission_pdf", ['admission_pat' => $admission_pat, 'barcode_admission_no' => $barcode_admission_no, 'po_hospital_details' => $po_hospital_details,'barcode_pat_no'=>$barcode_pat_no]);
        return $pdf->stream('Ipd Addmission Print.pdf');
    }
}
