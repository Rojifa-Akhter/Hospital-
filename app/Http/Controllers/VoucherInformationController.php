<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\VoucherEntry\VoucherEntry;

class VoucherInformationController extends Controller
{
    protected $voucher_entry;

    public function __construct(VoucherEntry $voucher_entry)
    {
        $this->voucher_entry = $voucher_entry;
    }

    public function active_inactive_voucher(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $voucher_type = $request->voucher_type;
        $voucher_no = !empty($request->voucher_no) ? $request->voucher_no : $request->search_voucher_id;

        $voucher_from_date = date("Y-m-d",strtotime($request->search_voucher_from_dt));
        $voucher_to_date = date("Y-m-d",strtotime($request->search_voucher_to_dt));

        if (empty($request->search_voucher_from_dt) || empty($request->search_voucher_to_dt)) {
            $voucher_from_date = "";
            $voucher_to_date = "";
        }

        if ($request->has('voucher_date')) {

            $voucher_from_date = date("Y-m-d",strtotime($request->voucher_date));
            $voucher_to_date = date("Y-m-d",strtotime($request->voucher_date));
        }



        if (! isset($voucher_type) || empty($voucher_type)) {
            return response()->json(['message' => false, 'message' => 'Voucher type missing'], 200);
        }

        $sql_cond = (trim($voucher_from_date) != "") && (trim($voucher_to_date) != "") ? " to_char(journal_date,'YYYY-MM-DD') between '".$voucher_from_date."' and '".$voucher_to_date."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($voucher_type) != "") ? " $clause voucher_type_no_fk='".$voucher_type."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($voucher_no) != "") ? " $clause journal_code LIKE '%".$voucher_no."%'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= " $clause au_entry_hospital_pk_no ='$ses_hospital_id'";

        $unverified_voucher = $this->voucher_entry->get_active_inactive_voucher($sql_cond);

        if ($unverified_voucher->getData()->success == true) {

            return response()->json(['success' => true, 'data' => $unverified_voucher->getData()->data], 200);

        }

        return response()->json(['success' => false, 'message' => $unverified_voucher->getData()->message, 'sql_cond' => $unverified_voucher->getData()->sql_cond], 200);

    }

    public function set_active_inactive_voucher(Request $request)
    {
        $voucher_code = $request->voucher_code;
        $verified_ind = $request->verified_ind;

        $voucher = $this->voucher_entry->set_active_inactive_voucher($voucher_code, $verified_ind);

        return response()->json(['success' => true, 'data' => $voucher->getData()->data], 200);
    }

    public function set_finalized_nofinalized_voucher(Request $request)
    {
        $voucher_code = $request->voucher_code;
        $finalized_ind = $request->finalized_ind;

        $voucher = $this->voucher_entry->set_finalized_notfinalized_voucher($voucher_code, $finalized_ind);

        return response()->json(['success' => true, 'data' => $voucher->getData()->data], 200);
    }

    public function voucher(Request $request)
    {
        $voucher_id = $request->get('voucher_id');
        $voucher = $this->voucher_entry->get_voucher($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
        }

        //return view("admin.accounts.reports.cash_receipt_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type'));
        $pdf = PDF::loadView("admin.accounts.reports.cash_receipt_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra'));
        //return $pdf->download('voucher.pdf');
        return $pdf->stream('voucher.pdf');

        return view("admin.accounts.reports.cash_receipt_voucher",compact('voucher_details','journal_date','voucher_no','narration','voucher_contra'));
    }

    public function view_voucher(Request $request)
    {
        $voucher_id = $request->get('voucher_id');
        $voucher = $this->voucher_entry->get_voucher($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
        }

        return view("admin.accounts.reports.cash_receipt_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra'));
    }

    //Accounts V1
    public function journal(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $doc_date = $voucher->getData()->doc_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            $pdf = PDF::loadView("admin.accounts.v1.reports.export.cash_receipt_voucher_pdf_excel", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('voucher.pdf');
            return $pdf->stream('voucher_'.$voucher_no.'.pdf');
        }
        else{
            return view("admin.components.error_alert");
        }

    }

    public function journal_excel(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $doc_date = $voucher->getData()->doc_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            $html = view("admin.accounts.v1.reports.cash_receipt_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date'))->render();

            $fileToExport = 'voucher_'.$voucher_no.'.xls';
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . $fileToExport . '"'
            ];

            return response()->make($html, 200, $headers);
        }
        else{
            return view("admin.components.error_alert");
        }

    }

    public function journalShow(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);
        ini_set('max_execution_time',0);
        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $doc_date = $voucher->getData()->doc_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            $voucher_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            if(Session::get('user.ses_hospital_code') != 'DMHL'){
                 if(Session::get('user.ses_hospital_code') == 'KPJ'){
                        $pdf = PDF::loadView("admin.accounts.v1.reports.journal_voucher_kpj", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date','voucher_hospital_details'));
                    }
                    else
                        $pdf = PDF::loadView("admin.accounts.v1.reports.journal_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date','voucher_hospital_details'));
            }

            else{
                $pdf = PDF::loadView("admin.accounts.v1.reports.journal_voucher_dmhl", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date','voucher_hospital_details'));
            }

            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('voucher.pdf');
        }
        else{
            return view("admin.components.error_alert");
        }

    }


    public function supplierShow(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);
        ini_set('max_execution_time',0);
        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $doc_date = $voucher->getData()->doc_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            $voucher_hospital_details = DB::table("WSEC_HOSPITAL")->first();

            // dd($voucher);

            $acc_sub_ledger = $voucher_details[0]->acct_subledger_no_fk;
                // dd($acc_sub_ledger);
            $subledgerInfo = DB::table('ACCT_SUBLEDGER_NAME as sl')
                ->leftJoin('INV_SUPPLIER as supp', 'sl.ACCT_SUBLEDGER_NO_PK', '=', 'supp.ACCT_SUBLEDGER_NO_FK')
                ->select(
                    'sl.SUBLEDGER_CODE',
                    'sl.SUBLEDGER_NAME',
                    DB::raw("supp.ADDR1 || ', ' || supp.ADDR2 AS ADDRESS"),
                    DB::raw("NVL(supp.PHONE, NVL(supp.MOBILE1, supp.MOBILE2)) AS TEL_NO")
                )
                ->where('sl.ACCT_SUBLEDGER_NO_PK', $acc_sub_ledger)
                ->first();

            //    dd($subledgerInfo);

            $acctSuppPayDetails = DB::table('INV_ACCSUPPLIERPAYMENTMST as asm')
                ->join('INV_ACCSUPPLIERPAYMENTDTL as asd', 'asm.ACCSUPPLIERPAYMENTMST_NO_PK', '=', 'asd.ACCSUPPLIERPAYMENTMST_NO_FK')
                ->join('PHR_ITEMRECEIVEMST as pim', 'pim.ITEMRECEIVE_NO_PK', '=', 'asd.ITEMRECEIVE_NO_FK')
                ->select(
                    'asm.journal_code',
                    'asd.itemreceive_no_fk',
                    'asm.mst_remarks',
                    'asm.cheque_no',
                    'asd.grn_amt',
                    'asd.remarks',
                    'asd.payment_date',
                    'pim.itemreceive_uid',
                    'pim.challan_no',
                    'pim.au_entry_at as itemreceive_date'
                )
                ->where('asm.JOURNAL_CODE', $voucher_id)
                ->get();
            // dd($voucher_details, $journal_date, $voucher_no, $narration, $voucher_type, $voucher_contra, $doc_date, $voucher_hospital_details, $acctSuppPayDetails, $subledgerInfo);
            if(Session::get('user.ses_hospital_code') != 'DMHL'){
                $pdf = PDF::loadView("admin.accounts.v1.reports.supplier_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date','voucher_hospital_details','acctSuppPayDetails','subledgerInfo'));
            }
            else{
                $pdf = PDF::loadView("admin.accounts.v1.reports.journal_voucher_dmhl", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date','voucher_hospital_details'));
            }

            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

            return $pdf->stream('voucher.pdf');
        }
        else{
            return view("admin.components.error_alert");
        }

    }

    public function set_active_inactive_journal(Request $request)
    {
        $voucher_code = $request->voucher_code;
        $verified_ind = $request->verified_ind;

        $voucher = $this->voucher_entry->set_active_inactive_journal($voucher_code, $verified_ind);
        if($voucher->getData()->success == true){

            return response()->json(['success' => true, 'data' => $voucher->getData()->data], 200);
        }
        else{
            return response()->json(['success' => false, 'data' => $voucher->getData()->data,'message' => 'Currently not available'], 422);
        }
    }
    public function set_active_inactive_journal_v2(Request $request)
    {
        $voucher_code = $request->voucher_code;
        $verified_ind = $request->verified_ind;

        $voucher = $this->voucher_entry->set_active_inactive_journal_v2($voucher_code, $verified_ind);
        if($voucher->getData()->success == true){

            return response()->json(['success' => true, 'data' => $voucher->getData()->data], 200);
        }
        else{
            return response()->json(['success' => false, 'data' => $voucher->getData()->data,'message' => 'Currently not available'], 422);
        }
    }

    public function view_journal(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $doc_date = $voucher->getData()->doc_date;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            return view("admin.accounts.v1.reports.cash_receipt_voucher", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date'));
        }
        else{
            return view("admin.components.error_alert");
        }


    }

    public function preview_journal($journal)
    {
        try {
            $voucher_id = $journal;
            $voucher = $this->voucher_entry->get_journal($voucher_id);

            if ($voucher->getData()->success == true) {
                $voucher_details = $voucher->getData()->data;
                $journal_date = $voucher->getData()->journal_date;
                $voucher_no = $voucher->getData()->voucher_no;
                $doc_date = $voucher->getData()->doc_date;
                $narration = $voucher->getData()->narration;
                $voucher_type = $voucher->getData()->voucher_type;
                $voucher_contra = $voucher->getData()->is_contra;
                $html = view("admin.accounts.v1.reports.journal_voucher_only_data", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date'))->render();
                return response()->json(['html'=> $html],200);

            }
            else{
                $html = view("admin.components.error_alert")->render();
                return response()->json(['html'=> $html],200);
            }
        } catch (\Throwable $th) {
            return response()->json(['html'=> '','message' => $th->getMessage()],422);
        }



    }

    public function view_journal_details(Request $request)
    {
        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);

        if ($voucher->getData()->success == true) {
            $voucher_details = $voucher->getData()->data;
            $journal_date = $voucher->getData()->journal_date;
            $voucher_no = $voucher->getData()->voucher_no;
            $doc_date = $voucher->getData()->doc_date;
            $narration = $voucher->getData()->narration;
            $voucher_type = $voucher->getData()->voucher_type;
            $voucher_contra = $voucher->getData()->is_contra;
            return view("admin.accounts.v1.reports.view_journal_details", compact('voucher_details','journal_date','voucher_no','narration','voucher_type','voucher_contra','doc_date'));
        }
        else{
            return view("admin.components.error_alert");
        }


    }

    public function set_finalized_nofinalized_journal(Request $request)
    {
        $voucher_code = $request->voucher_code;
        $finalized_ind = $request->finalized_ind;

        $voucher = $this->voucher_entry->set_finalized_notfinalized_voucher($voucher_code, $finalized_ind);

        return response()->json(['success' => true, 'data' => $voucher->getData()->data], 200);
    }
}
