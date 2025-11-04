<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use DateTime;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Accounts\VoucherEntry\VoucherEntry;

class VoucherEntryController extends Controller
{

    protected $voucher_entry;

    public function __construct(VoucherEntry $voucher_entry)
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->voucher_entry = $voucher_entry;
    }


    public function cash_receipt_entry(Request $request)
    {
        if ($request->cash_receipt_entry_mood == "edt")
        {
            DB::table('acct_journal_entry')
                ->where('journal_code', $request->cash_receipt_journal_code)
                ->delete();
        }

        $au_entry_at = Carbon::now();

        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")));//$au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

        // return $max_voucher_code = DB::table('acct_journal_entry')
        //                         ->groupBy('journal_code')
        //                         ->count();

        $journal_id = DB::table('acct_journal_entry')->count('journal_code');

        $journal_id = ($journal_id+1);

        $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();

        if (empty($journal_no->journal_no)) {
            $journal_no = 1;
        } else {
            $journal_no = $journal_no->journal_no+1;
        }



        $cash_cr_account_code = $request->cash_cr_account_code;
        $cash_cr_amount_value = $request->cash_cr_amount_value;
        $cash_dr_account_code = $request->cash_dr_account_code;

        if (empty($request->cash_receipt_journal_code)) {

            $voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        
        } else {

            $voucher_no = $request->cash_receipt_journal_code;
            
        }
        
        $time = date("h:i:s");
        
        $voucher_date = date("Y-m-d h:i:s",strtotime($request->cash_receipt_voucher_date." ".$time));
        $voucher_type_no = $request->cash_receipt_voucher_type_no;
        $cash_rcpt_voucher = [];

        //return $request->cash_dr_amount_value;
        $total_dr_value = collect($request->cash_dr_amount_value)->sum();
        $total_cr_value = collect($request->cash_cr_amount_value)->sum();

        if ($total_dr_value !== $total_cr_value) {

            return response()->json(['success' => false, 'message' => 'Incomplete voucher, Please completed your voucher'],200);

        }

        DB::beginTransaction();

        foreach($cash_dr_account_code as $key => $dr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_dr_account_code[$key])->first();



            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => 0.00,
                'trn_dr_account_amount' => $request->cash_dr_amount_value[$key],
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'person_no_fk' => null,//$request->person_no_fk,
                'supplier_no_fk' => null,//$request->supplier_no_fk,
                'patient_no_fk' => null, //$request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }


        foreach($cash_cr_account_code as $key => $cr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_cr_account_code[$key])->first();

            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => $request->cash_cr_amount_value[$key],
                'trn_dr_account_amount' => 0.00,
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'person_no_fk' => $request->person_no_fk,
                'supplier_no_fk' => $request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }

        //return $cash_rcpt_voucher;


        $voucher_details = $this->voucher_entry->add_voucher($cash_rcpt_voucher);


        return response()->json(['success' => true, 'message' => $voucher_details->getData()->message]);
    }


    public function bank_receipt_entry(Request $request)
    {
        if ($request->bank_receipt_entry_mood == "edt")
        {
            DB::table('acct_journal_entry')
                ->where('journal_code', $request->bank_receipt_journal_code)
                ->delete();
        }

        $au_entry_at = Carbon::now();

        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d")));//$au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

        $journal_id = DB::table('acct_journal_entry')->count('journal_code');

        $journal_id = ($journal_id+1);

        $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();

        if (empty($journal_no->journal_no)) {
            $journal_no = 1;
        } else {
            $journal_no = $journal_no->journal_no+1;
        }



        $cash_cr_account_code = $request->cash_cr_account_code;
        $cash_cr_amount_value = $request->cash_cr_amount_value;
        $cash_dr_account_code = $request->cash_dr_account_code;

        
        if (empty($request->bank_receipt_journal_code)) {

            $voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        
        } else {

            $voucher_no = $request->bank_receipt_journal_code;
            
        }

        $time = date("h:i:s");

        $voucher_date = date("Y-m-d h:i:s",strtotime($request->cash_receipt_voucher_date." ".$time));
        $bank_cheq_date = !empty($request->bank_cheq_date) ? date("Y-m-d",strtotime($request->bank_cheq_date)) : null;
        $voucher_type_no = $request->cash_receipt_voucher_type_no;
        $cash_rcpt_voucher = [];

        //return $request->cash_dr_amount_value;
        $total_dr_value = collect($request->cash_dr_amount_value)->sum();
        $total_cr_value = collect($request->cash_cr_amount_value)->sum();

        if ($total_dr_value !== $total_cr_value) {
            return response()->json(['success' => false, 'message' => 'Incomplete voucher, Please completed your voucher'],200);
        }

        DB::beginTransaction();

        foreach($cash_dr_account_code as $key => $dr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_dr_account_code[$key])->first();



            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => 0.00,
                'trn_dr_account_amount' => $request->cash_dr_amount_value[$key],
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => !empty($bank_cheq_date) ? $bank_cheq_date : null,
                'person_no_fk' => null, //$request->person_no_fk,
                'supplier_no_fk' => null, //$request->supplier_no_fk,
                'patient_no_fk' => null, //$request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }


        foreach($cash_cr_account_code as $key => $cr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_cr_account_code[$key])->first();

            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => $request->cash_cr_amount_value[$key],
                'trn_dr_account_amount' => 0.00,
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => !empty($bank_cheq_date) ? $bank_cheq_date : null,
                'person_no_fk' => $request->person_no_fk,
                'supplier_no_fk' => $request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }

        //return $cash_rcpt_voucher;


        $voucher_details = $this->voucher_entry->add_voucher($cash_rcpt_voucher);


        return response()->json(['success' => true, 'message' => $voucher_details->getData()->message]);
    }


    public function cash_payment(Request $request)
    {
        if ($request->cash_payment_entry_mood == "edt")
        {
            DB::table('acct_journal_entry')
                ->where('journal_code', $request->cash_payment_journal_code)
                ->delete();
        }

        $au_entry_at = Carbon::now();

        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d")));//$au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

        $journal_id = DB::table('acct_journal_entry')->count('journal_code');

        $journal_id = ($journal_id+1);

        $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();

        if (empty($journal_no->journal_no)) {
            $journal_no = 1;
        } else {
            $journal_no = $journal_no->journal_no+1;
        }



        $cash_cr_account_code = $request->cash_cr_account_code;
        $cash_cr_amount_value = $request->cash_cr_amount_value;
        $cash_dr_account_code = $request->cash_dr_account_code;

        //$voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        if (empty($request->cash_payment_journal_code)) {

            $voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        
        } else {

            $voucher_no = $request->cash_payment_journal_code;

        }
            
        
        $time = date("h:i:s");

        $voucher_date = date("Y-m-d h:i:s",strtotime($request->cash_receipt_voucher_date." ".$time));
        $voucher_type_no = $request->cash_receipt_voucher_type_no;
        $cash_rcpt_voucher = [];

        //return $request->cash_dr_amount_value;
        $total_dr_value = collect($request->cash_dr_amount_value)->sum();
        $total_cr_value = collect($request->cash_cr_amount_value)->sum();

        if ($total_dr_value !== $total_cr_value) {
            return response()->json(['success' => false, 'message' => 'Incomplete voucher, Please completed your voucher'],200);
        }

        DB::beginTransaction();

        foreach($cash_dr_account_code as $key => $dr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_dr_account_code[$key])->first();



            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => 0.00,
                'trn_dr_account_amount' => $request->cash_dr_amount_value[$key],
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'person_no_fk' => $request->person_no_fk,
                'supplier_no_fk' => $request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }


        foreach($cash_cr_account_code as $key => $cr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_cr_account_code[$key])->first();

            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => $request->cash_cr_amount_value[$key],
                'trn_dr_account_amount' => 0.00,
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'person_no_fk' => null, //$request->person_no_fk,
                'supplier_no_fk' => null, //$request->supplier_no_fk,
                'patient_no_fk' => null, //$request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }

        //return $cash_rcpt_voucher;


        $voucher_details = $this->voucher_entry->add_voucher($cash_rcpt_voucher);


        return response()->json(['success' => true, 'message' => $voucher_details->getData()->message]);
    }


    public function bank_payment_entry(Request $request)
    {
        if ($request->bank_payment_entry_mood == "edt")
        {
            DB::table('acct_journal_entry')
                ->where('journal_code', $request->bank_payment_journal_code)
                ->delete();
        }

        $au_entry_at = Carbon::now();

        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d")));//$au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

        $journal_id = DB::table('acct_journal_entry')->count('journal_code');

        $journal_id = ($journal_id+1);

        $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();

        if (empty($journal_no->journal_no)) {
            $journal_no = 1;
        } else {
            $journal_no = $journal_no->journal_no+1;
        }



        $cash_cr_account_code = $request->cash_cr_account_code;
        $cash_cr_amount_value = $request->cash_cr_amount_value;
        $cash_dr_account_code = $request->cash_dr_account_code;

        //$voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        if (empty($request->bank_payment_journal_code)) {

            $voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        
        } else {

            $voucher_no = $request->bank_payment_journal_code;

        }
        
        $time = date("h:i:s");

        $voucher_date = date("Y-m-d h:i:s",strtotime($request->cash_receipt_voucher_date." ".$time));

        $bank_cheq_date = !empty($request->bank_cheq_date) ? date("Y-m-d",strtotime($request->bank_cheq_date)) : null;
        $voucher_type_no = $request->cash_receipt_voucher_type_no;
        $cash_rcpt_voucher = [];

        //return $request->cash_dr_amount_value;
        $total_dr_value = collect($request->cash_dr_amount_value)->sum();
        $total_cr_value = collect($request->cash_cr_amount_value)->sum();

        if ($total_dr_value !== $total_cr_value) {
            return response()->json(['success' => false, 'message' => 'Incomplete voucher, Please completed your voucher'],200);
        }

        DB::beginTransaction();

        foreach($cash_dr_account_code as $key => $dr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_dr_account_code[$key])->first();



            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => 0.00,
                'trn_dr_account_amount' => $request->cash_dr_amount_value[$key],
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => $bank_cheq_date,
                'person_no_fk' => $request->person_no_fk,
                'supplier_no_fk' => $request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }


        foreach($cash_cr_account_code as $key => $cr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_cr_account_code[$key])->first();

            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => $request->cash_cr_amount_value[$key],
                'trn_dr_account_amount' => 0.00,
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => $bank_cheq_date,
                'person_no_fk' => null,//$request->person_no_fk,
                'supplier_no_fk' => null,//$request->supplier_no_fk,
                'patient_no_fk' => null,//$request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }

        //return $cash_rcpt_voucher;


        $voucher_details = $this->voucher_entry->add_voucher($cash_rcpt_voucher);


        return response()->json(['success' => true, 'message' => $voucher_details->getData()->message]);
    }



    public function journal_voucher_entry(Request $request)
    {
        if ($request->journal_entry_mood == "edt")
        {
            DB::table('acct_journal_entry')
                ->where('journal_code', $request->journal_journal_code)
                ->delete();
        }

        $au_entry_at = Carbon::now();

        $au_entry_at = date("Y-m-d h:i:s",strtotime(date("Y-m-d")));//$au_entry_at->toDateTimeString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

        $journal_id = DB::table('acct_journal_entry')->count('journal_code');

        $journal_id = ($journal_id+1);

        $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();

        if (empty($journal_no->journal_no)) {
            $journal_no = 1;
        } else {
            $journal_no = $journal_no->journal_no+1;
        }



        $cash_cr_account_code = $request->cash_cr_account_code;
        $cash_cr_amount_value = $request->cash_cr_amount_value;
        $cash_dr_account_code = $request->cash_dr_account_code;

        //$voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);

        if (empty($request->journal_journal_code)) {

            $voucher_no = "V".date("Ymd").str_pad(@$journal_no, 6, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);
        
        } else {

            $voucher_no = $request->journal_journal_code;

        }
        
        $time = date("h:i:s");

        $voucher_date = date("Y-m-d h:i:s",strtotime($request->cash_receipt_voucher_date." ".$time));
        $bank_cheq_date = !empty($request->bank_cheq_date) ? date("Y-m-d",strtotime($request->bank_cheq_date)) : null;
        $voucher_type_no = $request->cash_receipt_voucher_type_no;
        $cash_rcpt_voucher = [];

        //return $request->cash_dr_amount_value;
        $total_dr_value = collect($request->cash_dr_amount_value)->sum();
        $total_cr_value = collect($request->cash_cr_amount_value)->sum();

        if ($total_dr_value !== $total_cr_value) {
            return response()->json(['success' => false, 'message' => 'Incomplete voucher, Please completed your voucher'],200);
        }

        DB::beginTransaction();

        foreach($cash_dr_account_code as $key => $dr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_dr_account_code[$key])->first();



            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => 0.00,
                'trn_dr_account_amount' => $request->cash_dr_amount_value[$key],
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'auto_posting_ind' => 0,
                'is_contra' => isset($request->contra_voucher) ? $request->contra_voucher : 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => $bank_cheq_date,
                'person_no_fk' => null,//$request->person_no_fk,
                'supplier_no_fk' => null,//$request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }


        foreach($cash_cr_account_code as $key => $cr_account) {

            $acc_info = DB::table('acct_chart_of_accounts')->where('account_code', $request->cash_cr_account_code[$key])->first();

            $sequence = DB::getSequence();

            $journal_no_pk_seq = $sequence->nextValue('journal_no_pk_seq');

            array_push($cash_rcpt_voucher, [
                'journal_no_pk' => $journal_no_pk_seq,
                'journal_code' => $voucher_no,
                'journal_no' => $journal_no,
                'journal_date' => $voucher_date,
                'voucher_type_no_fk' => $voucher_type_no,
                'trn_account_no_fk' => $acc_info->account_no_pk,
                'trn_account_code' => $acc_info->account_code,
                'trn_cr_account_amount' => $request->cash_cr_amount_value[$key],
                'trn_dr_account_amount' => 0.00,
                'narration_text' => $request->voucher_description,
                'voucher_remarks' => $request->voucher_remarks,
                'is_contra' => isset($request->contra_voucher) ? $request->contra_voucher : 0,
                'auto_posting_ind' => 0,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'status' => 1,
                'au_entry_by' => Auth::id(),
                'au_entry_at' => $au_entry_at,
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'bank_cheq_number' => !empty($request->bank_cheq_number) ? $request->bank_cheq_number : null,
                'bank_cheq_date' => $bank_cheq_date,
                'person_no_fk' => null,//$request->person_no_fk,
                'supplier_no_fk' => $request->supplier_no_fk,
                'patient_no_fk' => $request->patient_no_fk,
                'invoice_no_fk' => $request->invoice_no,

            ]);
        }

        //return $cash_rcpt_voucher;


        $voucher_details = $this->voucher_entry->add_voucher($cash_rcpt_voucher);

        if ($voucher_details->getData()->success == true) {
            return response()->json(['success' => true, 'message' => $voucher_details->getData()->message]);
        }

        return response()->json(['success' => false, 'message' => $voucher_details->getData()->message]);
    }

    // Accounts V1
    public function accountsSaveJournal(Request $request){
        
        $request->validate([
            'doc_date' => 'required',
            'journal_type' => 'required',
            'total_dr' => 'required',
            'total_cr' => 'required',
        ]);

        $doc_date = DateTime::createFromFormat('d/m/Y', $request->doc_date);  // define date format from user
        $doc_date = $doc_date->format('m/d/Y'); // define expected format

        $post_date = $request->post_date;
        if(empty($request->post_date)){
            $post_date  = $doc_date;
        }
        else{
            $post_date = DateTime::createFromFormat('d/m/Y', $request->post_date); 
            $post_date = $post_date->format('m/d/Y');
        } 
        
        $save_journal = $this->voucher_entry->save_journal_post([
                'notes' =>$request->notes,
                'file1' =>$request->file1,
                'file2' =>$request->file2,
                'file3' =>$request->file3,
                'total_dr' =>$request->total_dr,
                'total_cr' =>$request->total_cr,
                'company' => $request->company,
                'naration' => $request->naration,
                'doc_date' => $doc_date,
                'post_date' => $post_date,
                'voucher_no' => $request->voucher_no,
                'attachment1' =>$request->attachment1,
                'attachment2' =>$request->attachment2,
                'attachment3' =>$request->attachment3,
                'dr_cr_type' => $request->dr_cr_type,
                'currency' => $request->currency,
                'amt_curr' => $request->amt_curr,
                'cheque_no' => is_array($request->cheque_no) ? $request->cheque_no:  null,
                'cheque_date' => is_array($request->cheque_date) ? $request->cheque_date:  null,
                'cost_center' => $request->cost_center,
                'journal_type' =>$request->journal_type,               
                'general_ledger' => $request->general_ledger,
                'sub_ledger_type' => $request->sub_ledger_type,
                'sub_ledger_name' => $request->sub_ledger_name,
                'sub_ledger_name_input' => $request->sub_ledger_name_input,
                'opd_ipd_ind' => $request->opd_ipd_ind,
                'amt_local_curr' => $request->amt_local_curr,           
                // 'unique_id' => $request->unique_id,           
        ]);

        return $save_journal;
    }

    public function accountsUpdateJournal(Request $request){

        $request->validate([
            'doc_date' => 'required',
            'journal_type' => 'required',
            'total_dr' => 'required',
            'total_cr' => 'required',
        ]);
        
        $voucher = $this->voucher_entry->get_journal($request->journal_code);
        if ($voucher->getData()->success == true) {
            if($voucher->getData()->data[0]->verified_ind == 1){
               return response()->json(['success' => false, 'message' => 'Update not eligible. Voucher already verified'], 422);
            }
        }

        $doc_date = DateTime::createFromFormat('d/m/Y', $request->doc_date);  // define date format from user
        $doc_date = $doc_date->format('m/d/Y'); // define expected format

        $post_date = $request->post_date;
        if(empty($request->post_date)){
            $post_date  = $doc_date;
        }
        else{
            $post_date = DateTime::createFromFormat('d/m/Y', $request->post_date); 
            $post_date = $post_date->format('m/d/Y');
        }

        $save_journal = $this->voucher_entry->update_journal_post([
                'notes' =>$request->notes,
                'file1' =>$request->file1,
                'file2' =>$request->file2,
                'file3' =>$request->file3,
                'journal_code' =>$request->journal_code,
                'journalmst_no_pk' =>$request->journalmst_no_pk,
                'total_dr' =>$request->total_dr,
                'total_cr' =>$request->total_cr,
                'company' => $request->company,
                'naration' => $request->naration,
                'doc_date' => $doc_date,
                'post_date' => $post_date,
                'voucher_no' => $request->voucher_no,
                'attachment1' =>$request->attachment1,
                'attachment2' =>$request->attachment2,
                'attachment3' =>$request->attachment3,
                'dr_cr_type' => $request->dr_cr_type,
                'currency' => $request->currency,
                'amt_curr' => $request->amt_curr,
                'cheque_no' => is_array($request->cheque_no) ? $request->cheque_no:  null,
                'cheque_date' => is_array($request->cheque_date) ? $request->cheque_date:  null,
                'cost_center' => $request->cost_center,
                'journal_type' =>$request->journal_type,               
                'general_ledger' => $request->general_ledger,
                'sub_ledger_type' => $request->sub_ledger_type,
                'sub_ledger_name' => $request->sub_ledger_name,
                'sub_ledger_name_input' => $request->sub_ledger_name_input,
                'opd_ipd_ind' => $request->opd_ipd_ind,
                'amt_local_curr' => $request->amt_local_curr             
        ]);

        return $save_journal;
    }
    

}