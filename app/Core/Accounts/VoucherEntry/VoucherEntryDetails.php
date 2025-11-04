<?php

namespace App\Core\Accounts\VoucherEntry;

use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\VoucherEntry\VoucherEntry;

class VoucherEntryDetails implements VoucherEntry
{
    public function add_voucher(array $data){

        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        try{

            DB::table('acct_journal_entry')
                ->insert($data);


            DB::commit();

            return response()->json(['success' => true, 'message' => 'Voucher successfully inserted'], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function get_active_inactive_voucher($conditions){

         //dd(Session::get('user.inv_manager_acc_ind'),  Session::get('user.serviceunit'));

         if((Session::get('user.inv_manager_acc_ind') == 1) && (Session::get('user.serviceunit') == 'Accounts') ){
                $unverifed_voucher = DB::table('acct_journal_entry_vw')
                                    ->select("journal_code", "journal_date", "verified_ind", DB::raw("sum(trn_cr_account_amount) cr, sum(trn_dr_account_amount) dr"))
                                    ->whereRaw($conditions)
                                    ->orderBy('journal_date', 'desc')
                                    ->groupBy('journal_date', 'journal_code', 'verified_ind')
                                    ->get();
                                    // dd(Session::get('user.inv_manager_acc_ind'),  Session::get('user.serviceunit'));
            }else{
                $unverifed_voucher = DB::table('acct_journal_entry_vw')
                                    ->select("journal_code","journal_date","verified_ind",DB::raw("sum(trn_cr_account_amount) cr, sum(trn_dr_account_amount) dr"))
                                    ->whereRaw($conditions)
                                    ->where('au_entry_by',Session::get('user.ses_user_pk_no')) // added by Nazmul
                                    ->orderBy('journal_date','desc')
                                    ->groupBy('journal_date','journal_code','verified_ind')
                                    ->get();

                                }

        if (! $unverifed_voucher->isEmpty()) {
            return response()->json(['success' => true, 'data' => $unverifed_voucher,'sql_cond' => $conditions], 200);
        }

        return response()->json(['success' => false, 'message' => 'No Data Found','sql_cond' => $conditions], 200);
    }

    public function set_active_inactive_voucher($voucher_no = null, $verified_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
            ->where('journal_code', $voucher_no)
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'));
        
             $voucher_info->update([
                'verified_ind' => $verified_ind === "0" ? 1 : 0,
                'verify_req_ind' => $verified_ind === "0" ? 1 : 0,
                'verified_entry_by' => Auth::id(),
                'verified_entry_at' => date("Y-m-d", strtotime($current_date))
            ]);
    
            $voucher_info = $voucher_info->get();
    
            return response()->json(['success' => true,'data' => $voucher_info], 200);  
 
        


    }

    public function set_active_inactive_voucher_v1($voucher_no = null, $verified_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
            ->where('journal_code', $voucher_no)
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'));
        
        if($verified_ind != 1){
            $voucher_info->update([
                'verified_ind' => $verified_ind === "0" ? 1 : 0,
                'verify_req_ind' => $verified_ind === "0" ? 1 : 0,
                'verified_entry_by' => $verified_ind === "0" ? Auth::id():'',
                'verified_entry_at' => date("Y-m-d", strtotime($current_date))
            ]);
    
            $voucher_info = $voucher_info->get();
    
            return response()->json(['success' => true,'data' => $voucher_info], 200);  
        }
        else{
            
            $voucher_info = $voucher_info->get();
            return response()->json(['success' => false,'data' => $voucher_info,'message' => ''], 422); 
        }
        


    }

    public function set_finalized_notfinalized_voucher($voucher_no = null, $finalized_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
            ->where('journal_code', $voucher_no);

        $voucher_info->update([
            'finalized_ind' => $finalized_ind === "0" ? 1 : 0,
            'finalized_entry_by' => Auth::id(),
            'finalized_entry_at' => date("Y-m-d", strtotime($current_date))
        ]);

        $voucher_info = $voucher_info->get();

        return response()->json(['success' => true,'data' => $voucher_info], 200);


    }

    public function get_voucher($voucher_id)
    {
        if (! isset($voucher_id) || empty($voucher_id)) {

            return response()->json(['success' => false,'message' => 'Voucherid missing'], 200);

        }

        $voucher = DB::table('acct_journal_entry_vw')
                                ->select('acct_chart_of_accounts.account_name',
                                        'acct_journal_entry_vw.trn_cr_account_amount',
                                        'acct_journal_entry_vw.trn_dr_account_amount',
                                        'acct_journal_entry_vw.journal_date',
                                        'acct_journal_entry_vw.journal_code',
                                        'acct_journal_entry_vw.trn_account_code',
                                        'acct_journal_entry_vw.narration_text',
                                        'acct_journal_entry_vw.bank_cheq_number',
                                        'acct_journal_entry_vw.bank_cheq_date',
                                        'acct_journal_entry_vw.voucher_type_name',
                                        'acct_journal_entry_vw.is_contra',
                                        'acct_journal_entry_vw.voucher_remarks',
                                        'patient_info_vw.patient_code','patient_info_vw.patient_name',
                                        'suppliers_vw.supplier_name','hrms_personnel_vw.full_name'

                                )
                                ->join('acct_chart_of_accounts','acct_journal_entry_vw.trn_account_no_fk','=','acct_chart_of_accounts.account_no_pk')
                                ->leftjoin('patient_info_vw','patient_info_vw.patient_no_pk','=','acct_journal_entry_vw.patient_no_fk')
                                ->leftjoin('suppliers_vw','suppliers_vw.supplier_no_pk','=','acct_journal_entry_vw.supplier_no_fk')
                                ->leftjoin('hrms_personnel_vw','hrms_personnel_vw.person_no_pk','=','acct_journal_entry_vw.person_no_fk')
                                ->where('journal_code', $voucher_id)
                                ->get();

        if (! $voucher->isEmpty()) {

            return response()->json([
                'success' => true,
                'data' => $voucher,
                'journal_date' => $voucher[0]->journal_date,
                'voucher_no' => $voucher[0]->journal_code,
                'narration' => $voucher[0]->narration_text,
                'voucher_type' => $voucher[0]->voucher_type_name,
                'patient_name' => $voucher[0]->patient_name,
                'supplier_name' => $voucher[0]->supplier_name,
                'employee_name' => $voucher[0]->full_name,
                'is_contra' => $voucher[0]->is_contra,
                'voucher_remarks' => $voucher[0]->voucher_remarks,
            ], 200);

        }

        return response()->json(['success' => false,'message' => 'No data Found'], 200);
    }

    public function voucher_info($conditions)
    {
        $voucher_info = DB::table('acct_journal_entry_vw')
            ->select("journal_code","journal_date","verified_ind","voucher_type_no_fk","voucher_type_name",'finalized_ind')
            ->whereRaw($conditions)
            ->groupBy('journal_code','journal_date','verified_ind','voucher_type_no_fk','voucher_type_name','finalized_ind')
            ->get();
            // dd($voucher_info);

        if (! $voucher_info->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_info], 200);
        }
    }

    public function edit_voucher($voucher_id){
        $voucher_info = DB::table('acct_journal_entry_vw')
            ->where('journal_code',$voucher_id)
            ->get();

        if (! $voucher_info->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_info], 200);
        }

        return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
    }

    public function update_voucher(array $data){

    }

    public function delete_voucher($voucher_id){

    }

    //Accounts V1
    public function get_fiscal_year(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_fiscal_year = DB::table('acct_fiscalyear')
                            ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                            ->orderBy('fiscalyear_no_pk','desc')
                            ->select('fiscalyear_no_pk','start_date','end_date','status','default_ind')
                            ->get();

        if ($acc_fiscal_year->isEmpty()) {
            return response()->json(['success' => true, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_fiscal_year], 200);
    }

    public function get_fiscal_month(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_fiscal_month = DB::table('acct_fiscalmonth')
                            ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                            ->orderBy('fiscalmonth_no_pk','desc')
                            ->select('fiscalmonth_no_pk','start_date','end_date','status','default_ind')
                            ->get();

        if ($acc_fiscal_month->isEmpty()) {
            return response()->json(['success' => true, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_fiscal_month], 200);
    }
    
    public function save_journal_post(array $data){
        
        try {
      
                // $au_entry_at = Carbon::now();
                // $au_entry_at = $au_entry_at->toDateString();
                $au_entry_at = new DateTime('now');
                $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
                $entry_session = Session()->get('user.ses_user_pk_no');
            
                if (!is_array($data)) {
                    return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
                }
                if (($data['total_dr'] != $data['total_cr']) ||($data['total_dr'] == 0 && $data['total_cr'] == 0 ) ) {
                    return response()->json(['success' => false, 'message' => 'Total Dr/Cr Amount Is Invalid'], 422);
                }
                
                //check fiscal year and month
                
                // $fiscal_year = collect($this->get_fiscal_year()->getData()->data)->where('current_fiscal_year_ind',1);
                // $doc_date = date("Y-m-d",strtotime($data['doc_date']));
                
                // foreach($fiscal_year as $item){
                //     if(!(($doc_date>=$item->start_date) && ($doc_date<=$item->end_date) && ($item->status == 1))){
                //         return response()->json(['success' => false, 'message' => 'This Doc. Date is Not Available'], 422);
                //     }
                // }


                // $fiscal_month = collect($this->get_fiscal_month()->getData()->data)->sortByDesc('end_date')->take(1)->values();
                
                
                // foreach($fiscal_month as $item){
                //     if(($doc_date>=$item->start_date) && ($doc_date<=$item->end_date) && ($item->status == 1)){
                //         return response()->json(['success' => false, 'message' => 'This Doc. Date is Not Available'], 422);
                //     }
                // }
                
                //close fiscal year and month
            
                //get journal code
                $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();
                $journal_type = DB::table('acct_voucher_type')->where('voucher_type_no_pk',$data['journal_type'])->value('voucher_type_code');;
            
                if (empty($journal_no->journal_no)) {               
                    $journal_no = 1;
                } else {
                    $journal_no = $journal_no->journal_no+1;
                }
                // dd($journal_no);


                $dateString = $data['doc_date'];
                $dateTimeObj = DateTime::createFromFormat('m/d/Y', $dateString);
                $timestamp = $dateTimeObj->getTimestamp();
                $current_my = date('Y-m-d', $timestamp);
                $formattedDate = substr($current_my,0,7);
                
                $journal_count = DB::table('acct_journal_entry')
                    ->selectRaw("voucher_type_no_fk,journal_code,journal_date")
                    ->where('voucher_type_no_fk', $data['journal_type'])
                    ->whereRaw("SUBSTR(to_char(journal_date,'YYYY-MM-DD'), 0,7) = '$formattedDate'")
                    ->groupBy('voucher_type_no_fk','journal_code','journal_date')
                    ->orderBy('journal_code','asc')
                    ->get();
                    
                if (empty($data['voucher_no'])) {
                    $journal_count = count($journal_count) + 1;
                    $voucher_no = $journal_type.date("Ym",strtotime($data['doc_date'])).str_pad(@$journal_count, 4, '0', STR_PAD_LEFT);//$voucher_no = "V".date("dmY").$journal_no_pk_seq;//mt_rand(1000,10000);              
                    $voucher_no = $this->checkVoucherCode($voucher_no); 
                } else {
        
                    $voucher_no = $data['voucher_no'];                
                }

                // close get journal code
                if($voucher_no == '' || empty($voucher_no) || $voucher_no == null){
                    return response()->json(['success' => false, 'message' => 'Something Went Wrong. Please Try Again Letter'], 422);
                }
                
                if(DB::table('acct_journal_entry')->where('journal_code',$voucher_no)->count() > 0){
                    return response()->json(['success' => false, 'message' => 'This Voucher No already Exists!'], 422);
                }
            
                $sequence = DB::getSequence();
                $journal_master_no_pk = $sequence->nextValue('journalmst_no_pk_seq');          
                $module_no = DB::table('sysc_module')->select('module_no_pk')->where('module_code','ACCOUNTS')->first();
                
                $file1 = '';
                $file2 = '';
                $file3 = '';
                if (isset($data['file1'])) {                  
                    $originalFileName = $data['file1']->getClientOriginalName();
                    $cleanFileName = str_replace(' ', '_', $originalFileName);       
                    $fileName = time() . '_file1_' . $cleanFileName;
                    $data['file1']->move(public_path('uploads/journal_post_documents/'), $fileName);
                    $file1 = $fileName;
                }
                if (isset($data['file2'])) {
                    $originalFileName = $data['file2']->getClientOriginalName();
                    $cleanFileName = str_replace(' ', '_', $originalFileName);       
                    $fileName1 = time() . '_file2_' . $cleanFileName;
                    $data['file2']->move(public_path('uploads/journal_post_documents/'), $fileName1);
                    $file2 = $fileName1;
                }
                if (isset($data['file3'])) {

                    $originalFileName = $data['file3']->getClientOriginalName();
                    $cleanFileName = str_replace(' ', '_', $originalFileName);       
                    $fileName2 = time() . '_file3_' . $cleanFileName;
                
                    $data['file3']->move(public_path('uploads/journal_post_documents/'), $fileName2);
                    $file3 = $fileName2;                                
                }                                
                $datas = [
                    'voucher_remarks' => $data['notes'],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'voucher_type_no_fk' => $data['journal_type'],
                    'status' => 1,
                    'journalmst_no_pk' => $journal_master_no_pk,
                    'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
                    'file_name1' => $data['attachment1'],
                    'file_name2' => $data['attachment2'],
                    'file_name3' => $data['attachment3'],
                    'file_path1' => $file1,
                    'file_path2' => $file2,
                    'file_path3' => $file3,
                    'dr_account_amount' => $data['total_dr'],
                    'cr_account_amount' => $data['total_cr'],
                    'doc_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
                    'auto_posting_ind' => 0,
                    'module_no_fk' => $module_no->module_no_pk
                ];
                
                DB::beginTransaction();
                    DB::table('acct_journal_entrymst')->insert($datas);
                    $lastInsertedId = DB::table('acct_journal_entrymst')
                                        ->orderBy('journalmst_no_pk', 'desc')
                                        ->value('journalmst_no_pk');                              
                    
                    foreach($data['general_ledger'] as $key => $item){
                        $child_sequence = DB::getSequence();
                        $journal_child_no_pk = $child_sequence->nextValue('journal_no_pk_seq');
                        $trn_account_code = DB::table('acct_chart_of_accounts')->where('account_no_pk',$data['general_ledger'][$key])->select('account_code','cost_center_ind')->first();
                        
                        $child_data = [
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,
                            'journal_no_pk' => $journal_child_no_pk,
                            'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,               
                            'voucher_type_no_fk' => $data['journal_type'],
                            'trn_account_no_fk' => $data['general_ledger'][$key],
                            'trn_account_code' => $trn_account_code->account_code,
                            'narration_text' => $data['naration'][$key],
                            'auto_posting_ind' => 0,
                            'journal_no' => $journal_no,
                            'journal_code' => $voucher_no,
                            'acct_subledger_no_fk' => $data['sub_ledger_name'][$key] = 0 ? '' :$data['sub_ledger_name'][$key],
                            'acct_subledger_type_fk' => $data['sub_ledger_type'][$key] = 0 ? '' :$data['sub_ledger_type'][$key],
                            'costcenter_no_fk' => $data['cost_center'][$key] = 0 ? '' :$data['cost_center'][$key],
                            'module_no_fk' => $module_no->module_no_pk,                                              
                            'voucher_remarks' =>  $data['notes'],
                            'person_no_fk' => null,
                            'supplier_no_fk' => null, 
                            'patient_no_fk' => null, 
                            'auto_posting_ind' => 0,
                            'auto_posting_ref_value' => null,
                            'auto_posting_ref_by' => null,
                            'auto_posting_ref_type' => null,
                            'verify_req_ind' => 0,
                            'verified_ind' => 0,
                            'verified_entry_by' => null,
                            'verified_entry_at' => null,
                            'finalized_ind' => 0,
                            'finalized_entry_by' => null,
                            'finalized_entry_at' => null,
                        ];
                        if($data['dr_cr_type'][$key] == 'dr'){
                            $child_data['trn_dr_account_amount'] = $data['amt_local_curr'][$key];
                            $child_data['trn_cr_account_amount'] = 0;
                        }
                        if($data['dr_cr_type'][$key] == 'cr'){
                            $child_data['trn_cr_account_amount'] = $data['amt_local_curr'][$key];
                            $child_data['trn_dr_account_amount'] = 0;
                        }
                        
                        if(is_array($data['cheque_no'])){
                            $child_data['bank_cheq_number'] = $data['cheque_no'][$key];
                            if(!empty($data['cheque_date'][$key])){
                                $cheque_date = DateTime::createFromFormat('d/m/Y', $data['cheque_date'][$key]);  // define date format from user
                                $cheque_date = $cheque_date->format('m/d/Y'); // define expected format
                                $child_data['bank_cheq_date'] = date("Y-m-d",strtotime($cheque_date));
                            } 
                        }

                        if($data['opd_ipd_ind'][$key] == 'IPD'){

                            $sub_ledger_fk = DB::table('acct_subledger_name')->where('subledger_code','IPD')->value('acct_subledger_no_pk');
                            if(empty($sub_ledger_fk)){
                              return  response()->json(['success' => false, 'message' => 'IPD Sub Ledger No Found!'], 422);
                            }
                            else{
                                $child_data['acct_subledger_no_fk'] = $sub_ledger_fk;
                            }
                                       
                            $patient_info = explode('-',$data['sub_ledger_name_input'][$key]);
                        
                            if(!empty($patient_info[0]) && count($patient_info) == 3){                                
                                $admission = DB::table('ipd_admission')->where('admission_uid',$patient_info[0])->select('admission_no_pk','patient_no_fk')->first();
                                if($admission == null){
                                    return response()->json(['success' => false, 'message' => 'Admission UID Incorrect!'], 422);     
                                }
                                
                                $child_data['admission_no_fk'] = isset($admission->admission_no_pk) ? $admission->admission_no_pk : '';
                                $child_data['patient_no_fk'] = isset($admission->patient_no_fk) ? $admission->patient_no_fk : '';
                            }
                            else{
                                    if(!empty($patient_info[0])){                                       
                                        return response()->json(['success' => false, 'message' => 'Please Select IPD Patient info from suggesstion'], 422);     
                                    }
                                }
                                                                                   
                        }
                        else if($data['opd_ipd_ind'][$key] == 'OPD'){
                            $sub_ledger_fk = DB::table('acct_subledger_name')->where('subledger_code','OPD')->value('acct_subledger_no_pk');
                            if(empty($sub_ledger_fk)){
                              return  response()->json(['success' => false, 'message' => 'OPD Sub Ledger No Found!'], 422);
                            }
                            else{
                                $child_data['acct_subledger_no_fk'] = $sub_ledger_fk;
                            }
                            $patient_info = explode('-',$data['sub_ledger_name_input'][$key]);

                            if(!empty($patient_info[0]) && count($patient_info) == 3){  
                                $invocie = DB::table('finc_invoicemst')->where('invoice_code',$patient_info[0])->select('invoice_no_pk','patient_no_fk')->first();
                                
                                if($invocie == null){
                                    return response()->json(['success' => false, 'message' => 'invocie code Incorrect!'], 422);     
                                }
                                $child_data['invoice_no_fk'] = isset($invocie->invoice_no_pk) ? $invocie->invoice_no_pk : '';
                                $child_data['patient_no_fk'] = isset($invocie->patient_no_fk) ? $invocie->patient_no_fk : ''; 
                            }
                            else{
                                if(!empty($patient_info[0])){                                       
                                    return response()->json(['success' => false, 'message' => 'Please Select OPD Patient info from suggesstion'], 422);     
                                } 
                            }
                        }

                        
                        if(!DB::table('acct_journal_entry')->where($child_data)->exists()){
                            $child_data['journalmst_no_fk'] = $lastInsertedId;
                            DB::table('acct_journal_entry')->insert($child_data);
                        }
                    }
                DB::commit();

                $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
                return response()->json(['success' => true, 'message' => 'Successfully Saved','voucher'=> $voucher_no,'hospital_code'=> $hospital_code], 200);
                
    
                 
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    } 
    
    public function checkVoucherCode($voucher_no){
        if(DB::table('acct_journal_entry')->where('journal_code',$voucher_no)->count() > 0){
            $lastFourDigits = intval(substr($voucher_no, -4)) + 1;              
            $modifiedCode = substr_replace($voucher_no, str_pad($lastFourDigits, 4, '0', STR_PAD_LEFT), -4);
            return $this->checkVoucherCode($modifiedCode);
        }
        else{
            return $voucher_no;
        }
    }
    
    public function update_journal_post(array $data){

        try {
            
            // $au_entry_at = Carbon::now();
            // $au_entry_at = $au_entry_at->toDateString();
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            if (($data['total_dr'] != $data['total_cr']) ||($data['total_dr'] == 0 && $data['total_cr'] == 0 ) ) {
                return response()->json(['success' => false, 'message' => 'Total Dr/Cr Amount Is Invalid'], 422);
            }
            
            //check fiscal year and month
                // $fiscal_year = collect($this->get_fiscal_year()->getData()->data)->where('current_fiscal_year_ind',1);
                // $doc_date = date("Y-m-d",strtotime($data['doc_date']));
                
                // foreach($fiscal_year as $item){
                //     if(!(($doc_date>=$item->start_date) && ($doc_date<=$item->end_date) && ($item->status == 1))){
                //         return response()->json(['success' => false, 'message' => 'This Doc. Date is Not Available'], 422);
                //     }
                // }


                // $fiscal_month = collect($this->get_fiscal_month()->getData()->data)->sortByDesc('end_date')->take(1)->values();
                
                
                // foreach($fiscal_month as $item){
                //     if(($doc_date>=$item->start_date) && ($doc_date<=$item->end_date) && ($item->status == 1)){
                //         return response()->json(['success' => false, 'message' => 'This Doc. Date is Not Available'], 422);
                //     }
                // }
            //close fiscal year and month
                      
            $journal_master_no_pk = $data['journalmst_no_pk'];   
            $journal_no = DB::table('acct_journal_entry')->where('journalmst_no_fk',$journal_master_no_pk)->select('journal_no')->first();          
            $module_no = DB::table('sysc_module')->select('module_no_pk')->where('module_code','ACCOUNTS')->first();
            

            $prev_image = DB::table('acct_journal_entrymst')->where('journalmst_no_pk',$journal_master_no_pk)->first();
            $file1 = $prev_image->file_path1;
            $file2 = $prev_image->file_path2;
            $file3 = $prev_image->file_path3;
 
            if (isset($data['file1'])) {
                $originalFileName = $data['file1']->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName = time() . '_file1_' . $cleanFileName;
                
                $data['file1']->move(public_path('uploads/journal_post_documents/'), $fileName);
                $image1 = public_path('uploads/journal_post_documents/').'/'.$file1;
                if(file_exists($image1)){
                    @unlink($image1);
                }
                $file1 = $fileName;
                
            }
            if (isset($data['file2'])) {
                $originalFileName = $data['file2']->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName1 = time() . '_file2_' . $cleanFileName;               
                $data['file2']->move(public_path('uploads/journal_post_documents/'), $fileName1);
                $image2 = public_path('uploads/journal_post_documents/').'/'.$file2;
                if(file_exists($image2)){
                    @unlink($image2);
                }
                $file2 = $fileName1;

            }
            if (isset($data['file3'])) {              
                $originalFileName = $data['file3']->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName2 = time() . '_file3_' . $cleanFileName;
                $data['file3']->move(public_path('uploads/journal_post_documents/'), $fileName2);
                $image3 = public_path('uploads/journal_post_documents/').'/'.$file3;
                if(file_exists($image3)){
                    @unlink($image3);
                }
                $file3 = $fileName2;
            }                                
            $datas = [
                'voucher_remarks' => $data['notes'],
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'voucher_type_no_fk' => $data['journal_type'],
                'status' => 1,               
                'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
                'file_name1' => $data['attachment1'],
                'file_name2' => $data['attachment2'],
                'file_name3' => $data['attachment3'],
                'file_path1' => $file1,
                'file_path2' => $file2,
                'file_path3' => $file3,
                'dr_account_amount' => $data['total_dr'],
                'cr_account_amount' => $data['total_cr'],
                'doc_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
                'auto_posting_ind' => 0,
                'module_no_fk' => $module_no->module_no_pk
            ];
            
            DB::beginTransaction();
                DB::table('acct_journal_entrymst')->where('journalmst_no_pk',$journal_master_no_pk)->update($datas);
                $lastInsertedId = $journal_master_no_pk; 
                DB::table('acct_journal_entry')->where('journalmst_no_fk',$journal_master_no_pk)->delete();                             
                foreach($data['general_ledger'] as $key => $item){
                    $child_sequence = DB::getSequence();
                    $journal_child_no_pk = $child_sequence->nextValue('journal_no_pk_seq');
                    $trn_account_code = DB::table('acct_chart_of_accounts')->where('account_no_pk',$data['general_ledger'][$key])->select('account_code','cost_center_ind')->first();
                    
                     $child_data = [
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,
                        'au_update_at' => $au_entry_at,
                        'au_update_by' => Auth::id(),
                        'au_update_session' => $entry_session,
                        'au_update_hospital_pk_no' => $hospital_pk_no,                      
                        'journal_no_pk' => $journal_child_no_pk,
                        'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,               
                        'voucher_type_no_fk' => $data['journal_type'],
                        'trn_account_no_fk' => $data['general_ledger'][$key],
                        'trn_account_code' => $trn_account_code->account_code,
                        'narration_text' => $data['naration'][$key],
                        'auto_posting_ind' => 0,
                        'journal_no' => $journal_no->journal_no,
                        'journal_code' => $data['voucher_no'],
                        'acct_subledger_no_fk' => $data['sub_ledger_name'][$key] = 0 ? '' :$data['sub_ledger_name'][$key],
                        'acct_subledger_type_fk' => $data['sub_ledger_type'][$key] = 0 ? '' :$data['sub_ledger_type'][$key],
                        'module_no_fk' => $module_no->module_no_pk,                      
                        'voucher_remarks' =>  $data['notes'],
                        'costcenter_no_fk' => $data['cost_center'][$key] = 0 ? '' :$data['cost_center'][$key],
                        'person_no_fk' => null,
                        'supplier_no_fk' => null, 
                        'patient_no_fk' => null, 
                        'auto_posting_ind' => 0,
                        'auto_posting_ref_value' => null,
                        'auto_posting_ref_by' => null,
                        'auto_posting_ref_type' => null,
                        'verify_req_ind' => 0,
                        'verified_ind' => 0,
                        'verified_entry_by' => null,
                        'verified_entry_at' => null,
                        'finalized_ind' => 0,
                        'finalized_entry_by' => null,
                        'finalized_entry_at' => null,
                    ];
                    if($data['dr_cr_type'][$key] == 'dr'){
                        $child_data['trn_dr_account_amount'] = $data['amt_local_curr'][$key];
                        $child_data['trn_cr_account_amount'] = 0;
                    }
                    if($data['dr_cr_type'][$key] == 'cr'){
                        $child_data['trn_cr_account_amount'] = $data['amt_local_curr'][$key];
                        $child_data['trn_dr_account_amount'] = 0;
                    }


                    if($data['opd_ipd_ind'][$key] == 'IPD')
                        {

                            $sub_ledger_fk = DB::table('acct_subledger_name')->where('subledger_code','IPD')->value('acct_subledger_no_pk');
                            if(empty($sub_ledger_fk)){
                              return  response()->json(['success' => false, 'message' => 'IPD Sub Ledger No Found!'], 422);
                            }
                            else{
                                $child_data['acct_subledger_no_fk'] = $sub_ledger_fk;
                            }
                                       
                            $patient_info = explode('-',$data['sub_ledger_name_input'][$key]);
                        
                            if(!empty($patient_info[0]) && count($patient_info) == 3){                                
                                $admission = DB::table('ipd_admission')->where('admission_uid',$patient_info[0])->select('admission_no_pk','patient_no_fk')->first();
                                if($admission == null){
                                    return response()->json(['success' => false, 'message' => 'Admission UID Incorrect!'], 422);     
                                }
                                
                                $child_data['admission_no_fk'] = isset($admission->admission_no_pk) ? $admission->admission_no_pk : '';
                                $child_data['patient_no_fk'] = isset($admission->patient_no_fk) ? $admission->patient_no_fk : '';
                            }
                            else{
                                    if(!empty($patient_info[0])){                                       
                                        return response()->json(['success' => false, 'message' => 'Please Select IPD Patient info from suggesstion'], 422);     
                                    }
                                }                                                                                 
                        }
                    else if($data['opd_ipd_ind'][$key] == 'OPD')
                        {
                            $sub_ledger_fk = DB::table('acct_subledger_name')->where('subledger_code','OPD')->value('acct_subledger_no_pk');
                            if(empty($sub_ledger_fk)){
                              return  response()->json(['success' => false, 'message' => 'OPD Sub Ledger No Found!'], 422);
                            }
                            else{
                                $child_data['acct_subledger_no_fk'] = $sub_ledger_fk;
                            }
                            $patient_info = explode('-',$data['sub_ledger_name_input'][$key]);

                            if(!empty($patient_info[0]) && count($patient_info) == 3){  
                                $invocie = DB::table('finc_invoicemst')->where('invoice_code',$patient_info[0])->select('invoice_no_pk','patient_no_fk')->first();
                                
                                if($invocie == null){
                                    return response()->json(['success' => false, 'message' => 'invocie code Incorrect!'], 422);     
                                }
                                $child_data['invoice_no_fk'] = isset($invocie->invoice_no_pk) ? $invocie->invoice_no_pk : '';
                                $child_data['patient_no_fk'] = isset($invocie->patient_no_fk) ? $invocie->patient_no_fk : ''; 
                            }
                            else{
                                if(!empty($patient_info[0])){                                       
                                    return response()->json(['success' => false, 'message' => 'Please Select OPD Patient info from suggesstion'], 422);     
                                } 
                            }
                        }
                    
                    if(is_array($data['cheque_no'])){
                        $child_data['bank_cheq_number'] = $data['cheque_no'][$key];

                        if(!empty($data['cheque_date'][$key])){
                            $cheque_date = DateTime::createFromFormat('d/m/Y', $data['cheque_date'][$key]);  // define date format from user
                            $cheque_date = $cheque_date->format('m/d/Y'); // define expected format
                            $child_data['bank_cheq_date'] = date("Y-m-d",strtotime($cheque_date));
                        } 
                    }
                    if(!DB::table('acct_journal_entry')->where($child_data)->exists()){
                        $child_data['journalmst_no_fk'] = $lastInsertedId;
                        DB::table('acct_journal_entry')->insert($child_data);
                    }
                   
                }
            DB::commit();
            $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;          
            return response()->json(['success' => true, 'message' => 'Successfully Udated','voucher'=> $data['voucher_no'],'hospital_code'=>$hospital_code], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    
    
    public function journal_info($conditions)
    {
         $query = DB::table('acct_v1_journal_entry_vw')
                ->select(
                    "auto_posting_ind",
                    "auto_posting_ref_value",
                    "auto_posting_ref_type",
                    "journal_code",
                    "journal_date",
                    "verified_ind",
                    "voucher_type_no_fk",
                    "voucher_type_name",
                    'finalized_ind',
                    'prepare_by',
                    'au_entry_at',
                    'verified_by',
                    'verified_entry_at',
                    'journal_update_by',
                    'journal_update_at',
                    'auto_posting_ref_grn_uid'
                )
                ->selectRaw('SUM(trn_cr_account_amount) as cr, SUM(trn_dr_account_amount) as dr');
            
                if($conditions != ""){
                    $query ->whereRaw($conditions) ; 
                }
        $query->groupBy(
            'auto_posting_ind',
            'auto_posting_ref_value',
            'auto_posting_ref_type',
            'journal_code',
            'journal_date',
            'verified_ind',
            'voucher_type_no_fk',
            'voucher_type_name',
            'finalized_ind',
            'prepare_by',
            'au_entry_at',
            'verified_by',
            'verified_entry_at',
            'journal_update_by',
            'journal_update_at',
            'auto_posting_ref_grn_uid'
            )
                ->orderBy('journal_code','asc');
           
        $voucher_info = $query->get();
        if (! $voucher_info->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_info], 200);
        }
        else{
            return response()->json(['success' => true, 'data' => []], 200);
        }
    }

    public function get_journal($voucher_id)
    {

        if (! isset($voucher_id) || empty($voucher_id)) {
            return response()->json(['success' => false,'message' => 'Voucherid missing'], 200);
        }

        $voucher = DB::table('acct_v1_journal_entry_vw')
                                ->select('acct_v1_journal_entry_vw.account_name',
                                        'acct_v1_journal_entry_vw.trn_cr_account_amount',
                                        'acct_v1_journal_entry_vw.trn_dr_account_amount',
                                        'acct_v1_journal_entry_vw.journal_date',
                                        'acct_v1_journal_entry_vw.journal_code',
                                        'acct_v1_journal_entry_vw.trn_account_code',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.bank_cheq_number',
                                        'acct_v1_journal_entry_vw.bank_cheq_date',
                                        'acct_v1_journal_entry_vw.voucher_type_name',
                                        'acct_v1_journal_entry_vw.is_contra',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.doc_date',
                                        'acct_v1_journal_entry_vw.subledgertype_name',
                                        'acct_v1_journal_entry_vw.subledger_name',
                                        'acct_v1_journal_entry_vw.costcenter_name',
                                        'acct_v1_journal_entry_vw.verified_by',
                                        'acct_v1_journal_entry_vw.verified_ind',
                                        'acct_v1_journal_entry_vw.finalized_by',
                                        'acct_v1_journal_entry_vw.prepare_by',
                                        'acct_v1_journal_entry_vw.file_path1',
                                        'acct_v1_journal_entry_vw.file_path2',
                                        'acct_v1_journal_entry_vw.file_path3',
                                        'acct_v1_journal_entry_vw.file_name1',
                                        'acct_v1_journal_entry_vw.file_name2',
                                        'acct_v1_journal_entry_vw.file_name3',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.acct_subledger_no_fk',
                                        'acct_v1_journal_entry_vw.costcenter_no_fk',
                                        'acct_v1_journal_entry_vw.journalmst_no_pk',
                                        'acct_v1_journal_entry_vw.journal_no_pk',
                                        'acct_v1_journal_entry_vw.acct_subledger_type_fk',
                                        'acct_v1_journal_entry_vw.cost_center_ind',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.subledgertype_code',
                                        'acct_v1_journal_entry_vw.subledger_code',
                                        'acct_v1_journal_entry_vw.patient_code',
                                        'acct_v1_journal_entry_vw.patient_name',
                                        'acct_v1_journal_entry_vw.invoice_code',
                                        'acct_v1_journal_entry_vw.admission_uid',

                                )
                                ->orderBy('acct_v1_journal_entry_vw.journal_no_pk','asc')
                                ->where('journal_code', $voucher_id)
                                ->get();

        if (! $voucher->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $voucher,
                'journal_date' => $voucher[0]->journal_date,
                'doc_date' => $voucher[0]->doc_date,
                'voucher_no' => $voucher[0]->journal_code,
                'narration' => $voucher[0]->narration_text,
                'voucher_type' => $voucher[0]->voucher_type_name,
                'patient_name' => $voucher[0]->patient_name,
                'is_contra' => $voucher[0]->is_contra,
                'voucher_remarks' => $voucher[0]->voucher_remarks,
            ], 200);

        }

        return response()->json(['success' => false,'message' => 'No data Found'], 200);
    }

    public function set_active_inactive_journal($voucher_no = null, $verified_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
            ->where('journal_code', $voucher_no)
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'));
        
        if($verified_ind != 1){
            
            $voucher_info->update([
                'verified_ind' => $verified_ind === "0" ? 1 : 0,
                'verify_req_ind' => $verified_ind === "0" ? 1 : 0,
                'verified_entry_by' => $verified_ind === "0" ? Auth::id():'',
                'verified_entry_at' => date("Y-m-d", strtotime($current_date))
            ]);
    
            $voucher_info = $voucher_info->get();
    
            return response()->json(['success' => true,'data' => $voucher_info], 200);  
        }
        else{
            
            $voucher_info = $voucher_info->get();
            return response()->json(['success' => false,'data' => $voucher_info,'message' => ''], 422); 
        }
    }
    
    public function set_active_inactive_journal_v2($voucher_no = null, $verified_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
            ->where('journal_code', $voucher_no)
            ->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'));
        
        $voucher_info->update([
            'verified_ind' => $verified_ind === "0" ? 1 : 0,
            'verify_req_ind' => $verified_ind === "0" ? 1 : 0,
            'verified_entry_by' => $verified_ind === "0" ? Auth::id():'',
            'verified_entry_at' => date("Y-m-d", strtotime($current_date))
        ]);

        $voucher_info = $voucher_info->get();

        return response()->json(['success' => true,'data' => $voucher_info], 200);  
    }

    public function finalize_journal_info($conditions)
    {
        $query = DB::table('acct_journal_entry_vw')
            ->select("journal_code","journal_date","verified_ind","voucher_type_no_fk","voucher_type_name",'finalized_ind');
            if($conditions != ""){
              $query->whereRaw($conditions);  
            }
            $query->where('verified_ind',1)
                    ->groupBy('journal_code','journal_date','verified_ind','voucher_type_no_fk','voucher_type_name','finalized_ind')
                    ->orderByDesc('journal_code');;
            
            $voucher_info = $query->get();

        if (! $voucher_info->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_info], 200);
        }
    }
    public function finalize_journal_info_v1($conditions)
    {

        $query = DB::table('acct_v1_journal_entry_vw')
                ->select("journal_code","journal_date","verified_ind","voucher_type_no_fk","voucher_type_name",'finalized_ind','prepare_by','au_entry_at','verified_by','verified_entry_at','journal_update_by','journal_update_at','finalized_by')
                ->selectRaw('SUM(trn_cr_account_amount) as cr, SUM(trn_dr_account_amount) as dr');
            
                if($conditions != ""){
                    $query ->whereRaw($conditions) ; 
                }
        $query->where('verified_ind',1)
                // ->where('finalized_ind','!=',1)
                ->groupBy('journal_code','journal_date','verified_ind','voucher_type_no_fk','voucher_type_name','finalized_ind','prepare_by','au_entry_at','verified_by','verified_entry_at','journal_update_by','journal_update_at','finalized_by')
                ->orderBy('journal_code','asc');
            
            $voucher_info = $query->get();

            if (! $voucher_info->isEmpty()) {
                return response()->json(['success' => true, 'data' => $voucher_info], 200);
            }
            else{
                return response()->json(['success' => true, 'data' => []], 200);
            }
    }

    public function set_finalized_notfinalized_journal($voucher_no = null, $finalized_ind = 0){

        if (! isset($voucher_no) || empty($voucher_no)) {
            return response()->json(['success' => false, 'message' => 'Voucher id missing'], 200);
        }

        $current_date = date("Y-m-d");

        $voucher_info = DB::table("acct_journal_entry")
                        ->where('journal_code', $voucher_no);

        $voucher_info->update([
            'finalized_ind' => $finalized_ind === "0" ? 1 : 0,
            'finalized_entry_by' => Auth::id(),
            'finalized_entry_at' => date("Y-m-d", strtotime($current_date))
        ]);

        $voucher_info = $voucher_info->get();

        return response()->json(['success' => true,'data' => $voucher_info], 200);


    }
}