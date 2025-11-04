<?php

namespace App\Core\Accounts\AccountSetup;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AccountSetupDetails implements AccountSetup
{
    /**
     * Save root account
     *
     * @param array $data
     *
     * @return mixed
     */
    public function get_fiscal_year(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_fiscal_year = DB::table('acct_fiscalyear')
                            ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                            ->orderBy('fiscalyear_no_pk','desc')
                            ->select('fiscalyear_no_pk','start_date','end_date','status','default_ind','fiscal_year','current_fiscal_year_ind')
                            ->get();
                            

        if ($acc_fiscal_year->isEmpty()) {
            return response()->json(['success' => true, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_fiscal_year], 200);
    }
    
    public function save_fiscal_year(array $data)
    {
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
        }

        try {
           
            if (DB::table('acct_fiscalyear')
                ->where('current_fiscal_year_ind', 1)
                ->where('au_entry_hospital_pk_no',$hospital_pk_no)               
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Please close previous fiscal year!'], 406);
            } 
            
            
            if (DB::table('acct_fiscalyear')
                ->where('start_date', date("Y-m-d",strtotime($data['start_date'])))
                ->where('end_date', date("Y-m-d",strtotime($data['end_date'])))
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal year already exist!'], 406);
            }


            $fiscal_year = substr($data['start_date'], -4).'-'.substr($data['end_date'], -4);
            if (DB::table('acct_fiscalyear')
                ->where('fiscal_year', $fiscal_year)           
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal year already exist!'], 406);
            }

            $sequence = DB::getSequence();
            $acct_fiscal_year_pk_seq = $sequence->nextValue('fiscalyear_no_pk_seq');
                        
            DB::table('acct_fiscalyear')
                            ->insert([
                                'fiscalyear_no_pk' => $acct_fiscal_year_pk_seq,
                                'start_date' => !empty($data['start_date']) ? date("Y-m-d",strtotime($data['start_date'])): null,
                                'end_date' => !empty($data['end_date']) ? date("Y-m-d",strtotime($data['end_date'])): null,
                                'default_ind' => 0,
                                'fiscal_year' => $fiscal_year,
                                'current_fiscal_year_ind' => 1,
                                'au_entry_at' => $au_entry_at,
                                'au_entry_by' => Auth::id(),
                                'status' => $data['status'],
                                'au_entry_session' => $entry_session,
                                'au_entry_hospital_pk_no' => $hospital_pk_no,
                            ]);


             $data =  $this->get_fiscal_year();          
            return response()->json(['success' => true,'message' => 'Successfully Saved','title' => 'Fiscal Year','data' => $data->getData()->data], 200);
        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 422);

        }

    }

    public function update_fiscal_year(array $data)
    {
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        try {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk'); 
            
            if($data['current_fiscal_year_ind'] == 1 && $data['status'] == 0){
                return response()->json(['success' => false, 'message' => 'Please Active Status then try closing fiscal year'], 406);
            }
            
            if (DB::table('acct_fiscalyear')
                ->where('fiscalyear_no_pk','!=', $data['fiscalyear_no_pk'])
                ->where('start_date', date("Y-m-d",strtotime($data['start_date'])))
                ->where('end_date', date("Y-m-d",strtotime($data['end_date'])))
                ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal year already exist!'], 406);
            }

            $fiscal_year = substr($data['start_date'], -4).'-'.substr($data['end_date'], -4);
            if (DB::table('acct_fiscalyear')
                ->where('fiscalyear_no_pk','!=', $data['fiscalyear_no_pk'])
                ->where('fiscal_year', $fiscal_year)
                ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal year already exist!'], 406);
            }

            DB::table('acct_fiscalyear')
                            ->where('fiscalyear_no_pk', $data['fiscalyear_no_pk'])
                            ->update([
                                'start_date' => !empty($data['start_date']) ? date("Y-m-d",strtotime($data['start_date'])): null,
                                'end_date' => !empty($data['end_date']) ? date("Y-m-d",strtotime($data['end_date'])): null,
                                'current_fiscal_year_ind' => $data['current_fiscal_year_ind'] == 1 ? 0 : 1,
                                'au_update_at' => $au_entry_at,
                                'au_update_by' => Auth::id(),
                                'fiscal_year' =>  $fiscal_year,
                                'status' => $data['status'],
                                'au_update_session' => $entry_session,
                                'au_update_hospital_pk_no' => $hospital_pk_no,
                            ]);


             $data =  $this->get_fiscal_year();          
             return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch(\Exception $e) {

            return response()->json(['success' => false,'msg' => $e->getMessage(),'title' => 'Error'],422);

        }

    }

    public function get_fiscal_month(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_fiscal_month = DB::table('acct_fiscalmonth')
                            ->where('au_entry_hospital_pk_no',  $ses_hospital_id)
                            ->orderBy('fiscalmonth_no_pk','desc')
                            ->select('fiscalmonth_no_pk','start_date','end_date','status','default_ind','closing_type')
                            ->get();

        if ($acc_fiscal_month->isEmpty()) {
            return response()->json(['success' => true, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_fiscal_month], 200);
    }
    
    public function save_fiscal_month(array $data)
    {
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }
        
        try {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
                                                   

            
            if (DB::table('acct_fiscalmonth')
                    ->where('start_date', date("Y-m-d",strtotime($data['start_date'])))
                    ->where('end_date', date("Y-m-d",strtotime($data['end_date'])))
                    ->where('au_entry_hospital_pk_no',  $ses_hospital_id)   
                    ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal year already exist!'], 406);
            }

            $sequence = DB::getSequence();
            $acct_fiscal_month_pk_seq = $sequence->nextValue('fiscalmonth_no_pk_seq');
            DB::table('acct_fiscalmonth')
                            ->insert([
                                'fiscalmonth_no_pk' => $acct_fiscal_month_pk_seq,
                                'start_date' => !empty($data['start_date']) ? date("Y-m-d",strtotime($data['start_date'])): null,
                                'end_date' => !empty($data['end_date']) ? date("Y-m-d",strtotime($data['end_date'])): null,
                                'closing_type' => $data['closing_type'],
                                'au_entry_at' => $au_entry_at,
                                'au_entry_by' => Auth::id(),
                                'status' => $data['status'],
                                'au_entry_session' => $entry_session,
                                'au_entry_hospital_pk_no' => $hospital_pk_no,
                            ]);


             $data =  $this->get_fiscal_month();          
            return response()->json(['success' => true,'message' => 'Successfully Saved','title' => 'Fiscal Month','data' => $data->getData()->data], 200);
        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 422);

        }

    }

    public function update_fiscal_month(array $data)
    {
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        try {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');                                       
   
            
            if (DB::table('acct_fiscalmonth')
                ->where('fiscalmonth_no_pk','!=', $data['fiscalmonth_no_pk'])
                ->where('start_date', date("Y-m-d",strtotime($data['start_date'])))
                ->where('end_date', date("Y-m-d",strtotime($data['end_date'])))
                 ->where('au_entry_hospital_pk_no',  $ses_hospital_id)  
                ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Fiscal month already exist!'], 406);
            }

            DB::table('acct_fiscalmonth')
                            ->where('fiscalmonth_no_pk', $data['fiscalmonth_no_pk'])
                            ->update([
                                'start_date' => !empty($data['start_date']) ? date("Y-m-d",strtotime($data['start_date'])): null,
                                'end_date' => !empty($data['end_date']) ? date("Y-m-d",strtotime($data['end_date'])): null,
                                'closing_type' => $data['closing_type'],
                                'au_update_at' => $au_entry_at,
                                'au_update_by' => Auth::id(),
                                'status' => $data['status'],
                                'au_update_session' => $entry_session,
                                'au_update_hospital_pk_no' => $hospital_pk_no,
                            ]);


             $data =  $this->get_fiscal_month();          
             return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch(\Exception $e) {

            return response()->json(['success' => false,'msg' => $e->getMessage(),'title' => 'Error'],422);

        }

    }

    public function get_accounts_group_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_1accountgroup')
            ->orderBy('acc_coa_1accountgroup.acc_1group_no_pk', 'desc')
            ->where('acc_coa_1accountgroup.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acc_coa_1accountgroup.acc_1group_notes',
                'acc_coa_1accountgroup.status',
                'acc_coa_1accountgroup.acc_1group_name',
                'acc_coa_1accountgroup.acc_1group_code',
                'acc_coa_1accountgroup.acc_code_range_1_start',
                'acc_coa_1accountgroup.acc_code_range_1_end',
                'acc_coa_1accountgroup.acc_1group_no_pk',
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }
    
    public function save_account_group(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            $sequence = DB::getSequence();
            $acc_1group_no_pk_seq = $sequence->nextValue('acc_1group_no_pk_seq');

            $datas = [
                'status' => $data['status'],
                'acc_1group_notes'  => $data['notes'],
                'acc_code_range_1_start' => $data['start_range'],
                'acc_code_range_1_end' => $data['end_range'],
                'acc_1group_name' => $data['account_group_name'],
                'acc_1group_code' => $data['account_group_code'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acc_1group_no_pk' => $acc_1group_no_pk_seq
            ];
            if(DB::table('acc_coa_1accountgroup')->where('acc_1group_code',$data['account_group_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Group Code Already Exists'],422);
            }
            DB::table('acc_coa_1accountgroup')->insert($datas);

            $accountsGroup = $this->get_accounts_group_v1();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $accountsGroup->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    public function get_accounts_group_by_id($id){
        $data = DB::table('acc_coa_1accountgroup')
                    ->where('acc_1group_no_pk',$id)
                    ->select(
                        'acc_coa_1accountgroup.acc_1group_notes',
                        'acc_coa_1accountgroup.status',
                        'acc_coa_1accountgroup.acc_1group_name',
                        'acc_coa_1accountgroup.acc_1group_code',
                        'acc_coa_1accountgroup.acc_code_range_1_start',
                        'acc_coa_1accountgroup.acc_code_range_1_end',
                        'acc_coa_1accountgroup.acc_1group_no_pk',
                        )
                        
                    ->first();
        return $data;
    }

    public function update_account_group(array $data)
    {
        $au_update_at = Carbon::now();

        $au_update_at = $au_update_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
        }
        
        if(DB::table('acc_coa_1accountgroup')->where('acc_1group_no_pk','!=', $data['acc_1group_no_pk'])->where('acc_1group_code',$data['account_group_code'])->exists()){
            return response()->json(['success' => false, 'message' => 'Account Group Code Already Exists!'], 422);
        }
        
        try {

            DB::table('acc_coa_1accountgroup')
                ->where('acc_1group_no_pk', $data['acc_1group_no_pk'])
                ->update(
                    [
                        'status' => $data['status'],
                        'acc_1group_notes'  => $data['notes'],
                        'acc_code_range_1_start' => $data['start_range'],
                        'acc_code_range_1_end' => $data['end_range'],
                        'acc_1group_name' => $data['account_group_name'],
                        'acc_1group_code' => $data['account_group_code'],                                   
                        'au_update_at' => $au_update_at,
                        'au_update_by' => Auth::id(),
                        'au_update_session' => $entry_session,
                        'au_update_hospital_pk_no' => $hospital_pk_no,
                    ]
                );
            return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }

    // Account Sub Group

    public function save_account_sub_group(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_1accountgroup')->where('acc_1group_no_pk', $data['account_group_fk'])->select('acc_code_range_1_start','acc_code_range_1_end')->first();
            if($range_data->acc_code_range_1_start != null && $range_data->acc_code_range_1_end != null){
                if($data['account_sub_group_code'] < $range_data->acc_code_range_1_start || $data['account_sub_group_code'] > $range_data->acc_code_range_1_end){
                    return response()->json(['success' => false, 'message' => "Account Sub Group Code Not Eligible. Please give between ".$range_data->acc_code_range_1_start." and ".$range_data->acc_code_range_1_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            $sequence = DB::getSequence();
            $acc_2subgroup_no_pk_seq = $sequence->nextValue('acc_2subgroup_no_pk_seq');

            $datas = [
                'status' => $data['status'],
                'acc_2subgroup_notes'  => $data['notes'],
                'acc_code_range_2_start' => $data['start_range'],
                'acc_code_range_2_end' => $data['end_range'],
                'acc_2subgroup_name' => $data['account_sub_group_name'],
                'acc_2subgroup_code' => $data['account_sub_group_code'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acc_2subgroup_no_pk' => $acc_2subgroup_no_pk_seq,
                'acc_1group_no_fk' => $data['account_group_fk']
            ];
            if(DB::table('acc_coa_2accountsubgroup')->where('acc_2subgroup_code',$data['account_sub_group_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Sub Group Code Already Exists'],422);
            }
            DB::table('acc_coa_2accountsubgroup')->insert($datas);

            $accountsGroup = $this->get_accounts_sub_group_v1();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $accountsGroup->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    public function get_accounts_sub_group_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_2accountsubgroup')
            ->leftJoin('acc_coa_1accountgroup','acc_coa_1accountgroup.acc_1group_no_pk','=','acc_coa_2accountsubgroup.acc_1group_no_fk')
            ->orderBy('acc_coa_2accountsubgroup.acc_2subgroup_no_pk', 'desc')
            ->where('acc_coa_2accountsubgroup.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acc_coa_2accountsubgroup.acc_2subgroup_notes',
                'acc_coa_2accountsubgroup.status',
                'acc_coa_2accountsubgroup.acc_2subgroup_name',
                'acc_coa_2accountsubgroup.acc_2subgroup_code',
                'acc_coa_2accountsubgroup.acc_code_range_2_start',
                'acc_coa_2accountsubgroup.acc_code_range_2_end',
                'acc_coa_2accountsubgroup.acc_2subgroup_no_pk',
                'acc_coa_1accountgroup.acc_1group_name',
                'acc_coa_1accountgroup.acc_1group_code'
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function get_accounts_sub_group_by_id($id){
        $data = DB::table('acc_coa_2accountsubgroup')
                    ->where('acc_2subgroup_no_pk',$id)
                    ->select(
                        'acc_coa_2accountsubgroup.acc_2subgroup_notes',
                        'acc_coa_2accountsubgroup.status',
                        'acc_coa_2accountsubgroup.acc_2subgroup_name',
                        'acc_coa_2accountsubgroup.acc_2subgroup_code',
                        'acc_coa_2accountsubgroup.acc_code_range_2_start',
                        'acc_coa_2accountsubgroup.acc_code_range_2_end',
                        'acc_coa_2accountsubgroup.acc_2subgroup_no_pk',
                        'acc_coa_2accountsubgroup.acc_1group_no_fk',
                        )
                        
                    ->first();
        return $data;
    }

    public function update_account_sub_group(array $data){
        
        try {
            
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'msg' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'msg' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_1accountgroup')->where('acc_1group_no_pk', $data['account_group_fk'])->select('acc_code_range_1_start','acc_code_range_1_end')->first();
            if($range_data->acc_code_range_1_start != null && $range_data->acc_code_range_1_end != null){
                if($data['account_sub_group_code'] < $range_data->acc_code_range_1_start || $data['account_sub_group_code'] > $range_data->acc_code_range_1_end){
                    return response()->json(['success' => false, 'msg' => "Account Sub Group Code Not Eligible. Please give between ".$range_data->acc_code_range_1_start." and ".$range_data->acc_code_range_1_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            $datas = [
                'status' => $data['status'],
                'acc_2subgroup_notes'  => $data['notes'],
                'acc_code_range_2_start' => $data['start_range'],
                'acc_code_range_2_end' => $data['end_range'],
                'acc_2subgroup_name' => $data['account_sub_group_name'],
                'acc_2subgroup_code' => $data['account_sub_group_code'],
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'acc_1group_no_fk' => $data['account_group_fk']
            ];
            if(DB::table('acc_coa_2accountsubgroup')->where('acc_2subgroup_no_pk','!=', $data['acc_2subgroup_no_pk'])->where('acc_2subgroup_code',$data['account_sub_group_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Sub Group Code Already Exists'],422);
            }
            DB::table('acc_coa_2accountsubgroup')->where('acc_2subgroup_no_pk', $data['acc_2subgroup_no_pk'])->update($datas);

  
            return response()->json(['success' => true, 'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }

    public function save_account_group_type(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_2accountsubgroup')->where('acc_2subgroup_no_pk', $data['account_sub_group_fk'])->select('acc_code_range_2_start','acc_code_range_2_end')->first();
            if($range_data->acc_code_range_2_start != null && $range_data->acc_code_range_2_end != null){
                if($data['account_group_type_code'] < $range_data->acc_code_range_2_start || $data['account_group_type_code'] > $range_data->acc_code_range_2_end){
                    return response()->json(['success' => false, 'message' => "Account Group Type Code Not Eligible. Please give between ".$range_data->acc_code_range_2_start." and ".$range_data->acc_code_range_2_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            $sequence = DB::getSequence();
            $acc_3grouptype_no_pk_seq = $sequence->nextValue('acc_3grouptype_no_pk_seq');

            $datas = [
                'status' => $data['status'],
                'acc_3grouptype_notes'  => $data['notes'],
                'acc_code_range_3_start' => $data['start_range'],
                'acc_code_range_3_end' => $data['end_range'],
                'acc_3grouptype_name' => $data['account_group_type_name'],
                'acc_3grouptype_code' => $data['account_group_type_code'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acc_3grouptype_no_pk' => $acc_3grouptype_no_pk_seq,
                'acc_2subgroup_no_fk' => $data['account_sub_group_fk']
            ];
            if(DB::table('acc_coa_3accountgrouptype')->where('acc_3grouptype_code',$data['account_group_type_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Group Type Code Already Exists'],422);
            }
            DB::table('acc_coa_3accountgrouptype')->insert($datas);

            $accountsGroup = $this->get_accounts_group_type_v1();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $accountsGroup->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    public function get_accounts_group_type_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_3accountgrouptype')
            ->leftJoin('acc_coa_2accountsubgroup','acc_coa_2accountsubgroup.acc_2subgroup_no_pk','=','acc_coa_3accountgrouptype.acc_2subgroup_no_fk')
            ->orderBy('acc_coa_3accountgrouptype.acc_3grouptype_no_pk', 'desc')
            ->where('acc_coa_3accountgrouptype.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acc_coa_3accountgrouptype.acc_3grouptype_notes',
                'acc_coa_3accountgrouptype.status',
                'acc_coa_3accountgrouptype.acc_3grouptype_name',
                'acc_coa_3accountgrouptype.acc_3grouptype_code',
                'acc_coa_3accountgrouptype.acc_code_range_3_start',
                'acc_coa_3accountgrouptype.acc_code_range_3_end',
                'acc_coa_3accountgrouptype.acc_3grouptype_no_pk',
                'acc_coa_3accountgrouptype.acc_2subgroup_no_fk',
                'acc_coa_2accountsubgroup.acc_2subgroup_name',
                'acc_coa_2accountsubgroup.acc_2subgroup_code'
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }
    
    public function get_accounts_group_type_by_id($id){
        $data = DB::table('acc_coa_3accountgrouptype')
                    ->where('acc_3grouptype_no_pk',$id)
                    ->select(
                        'acc_coa_3accountgrouptype.acc_3grouptype_notes',
                        'acc_coa_3accountgrouptype.status',
                        'acc_coa_3accountgrouptype.acc_3grouptype_name',
                        'acc_coa_3accountgrouptype.acc_3grouptype_code',
                        'acc_coa_3accountgrouptype.acc_code_range_3_start',
                        'acc_coa_3accountgrouptype.acc_code_range_3_end',
                        'acc_coa_3accountgrouptype.acc_3grouptype_no_pk',
                        'acc_coa_3accountgrouptype.acc_2subgroup_no_fk',
                        )
                        
                    ->first();
        return $data;
    }

    public function update_account_group_type(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'msg' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'msg' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_2accountsubgroup')->where('acc_2subgroup_no_pk', $data['account_sub_group_fk'])->select('acc_code_range_2_start','acc_code_range_2_end')->first();
            if($range_data->acc_code_range_2_start != null && $range_data->acc_code_range_2_end != null){
                if($data['account_group_type_code'] < $range_data->acc_code_range_2_start || $data['account_group_type_code'] > $range_data->acc_code_range_2_end){
                    return response()->json(['success' => false, 'msg' => "Account Group Type Code Not Eligible. Please give between ".$range_data->acc_code_range_2_start." and ".$range_data->acc_code_range_2_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            
            $datas = [
                'status' => $data['status'],
                'acc_3grouptype_notes'  => $data['notes'],
                'acc_code_range_3_start' => $data['start_range'],
                'acc_code_range_3_end' => $data['end_range'],
                'acc_3grouptype_name' => $data['account_group_type_name'],
                'acc_3grouptype_code' => $data['account_group_type_code'],
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'acc_2subgroup_no_fk' => $data['account_sub_group_fk']
            ];
            if(DB::table('acc_coa_3accountgrouptype')->where('acc_3grouptype_no_pk' ,'!=', $data['acc_3grouptype_no_pk'])->where('acc_3grouptype_code',$data['account_group_type_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Group Type Code Already Exists'],422);
            }
            DB::table('acc_coa_3accountgrouptype')->where('acc_3grouptype_no_pk', $data['acc_3grouptype_no_pk'])->update($datas);


            return response()->json(['success' => true, 'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }

    public function save_account_type(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_3accountgrouptype')->where('acc_3grouptype_no_pk', $data['account_group_type_fk'])->select('acc_code_range_3_start','acc_code_range_3_end')->first();
            if($range_data->acc_code_range_3_start != null && $range_data->acc_code_range_3_end != null){
                if($data['account_type_code'] < $range_data->acc_code_range_3_start || $data['account_type_code'] > $range_data->acc_code_range_3_end){
                    return response()->json(['success' => false, 'message' => "Account Type Code Not Eligible. Please give between ".$range_data->acc_code_range_3_start." and ".$range_data->acc_code_range_3_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            $sequence = DB::getSequence();
            $acc_4type_no_pk_seq = $sequence->nextValue('acc_4type_no_pk_seq');

            $datas = [
                'status' => $data['status'],
                'acc_4type_notes'  => $data['notes'],
                'acc_code_range_4_start' => $data['start_range'],
                'acc_code_range_4_end' => $data['end_range'],
                'acc_4type_name' => $data['account_type_name'],
                'acc_4type_code' => $data['account_type_code'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acc_4type_no_pk' => $acc_4type_no_pk_seq,
                'acc_3grouptype_no_fk' => $data['account_group_type_fk']
            ];
            if(DB::table('acc_coa_4accounttype')->where('acc_4type_code',$data['account_type_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Type Code Already Exists'],422);
            }
            DB::table('acc_coa_4accounttype')->insert($datas);

            $accountsGroup = $this->get_accounts_type_v1();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $accountsGroup->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    // doctor share setup 
    public function save_doctor_share(array $data)
    {
        try {
            DB::beginTransaction(); 

            $au_entry_at = now();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            $sequence = DB::getSequence();
            $doctorfeemst_no_pk_seq = $sequence->nextValue('doctorfeemst_no_pk_seq');

            $existing_overlap = DB::table('sysc_doctorfeemst')
                ->where('person_no_fk', $data['person_no_fk'])
                ->where('itemtype_no_fk', $data['itemtype_no_fk'])
                ->first();

            if ($existing_overlap) {
                $last_record = DB::table('sysc_doctorfeemst')
                    ->where('person_no_fk', $data['person_no_fk'])
                    ->where('itemtype_no_fk', $data['itemtype_no_fk'])
                    ->orderBy('start_date', 'desc')
                    ->first();

                if ($last_record) {
                    if ($data['start_date'] == $last_record->start_date) {
                        $new_end_date = $last_record->end_date;
                    } else {
                        $new_end_date = date('Y-m-d', strtotime($data['start_date'] . ' -1 day'));
                    }

                    if (!empty($last_record->start_date) && $new_end_date < $last_record->start_date) {
                        $new_end_date = $last_record->start_date;
                    }

                    DB::table('sysc_doctorfeemst')
                        ->where('doctorfeemst_no_pk', $last_record->doctorfeemst_no_pk)
                        ->update(['end_date' => $new_end_date]);
                }
            }

            $datas = [
                'status' => $data['status'],
                'person_no_fk'  => $data['person_no_fk'],
                'itemtype_no_fk' => $data['itemtype_no_fk'],
                'share_per' => $data['share_per'],
                'start_date' => $data['start_date'],
                // 'end_date' => $data['end_date'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'doctorfeemst_no_pk' => $doctorfeemst_no_pk_seq,
            ];

            DB::table('sysc_doctorfeemst')->insert($datas);

            DB::commit(); 
            $doctor_share_data = $this->get_doctor_share();

            return response()->json([
                'success' => true,
                'message' => 'Successfully Saved',
                'data' => $doctor_share_data->getData()->data
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack(); 
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => []
            ], 422);
        }
    }



    

    public function get_doctor_share(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $doctor_share_data = DB::table('sysc_doctorfeemst as d')
            ->leftJoin('hrms_personnel as p', 'd.person_no_fk', '=', 'p.person_no_pk')
            ->leftJoin('sysc_itemtype as i', 'd.itemtype_no_fk', '=', 'i.itemtype_no_pk')
            ->where('d.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('d.doctorfeemst_no_pk', 'desc')
            ->select(
                'd.*',
                'p.full_name',
                'i.item_type_name'
            )
            ->get();
        
        return response()->json(['success' => true, 'data' => $doctor_share_data]);
    }

    public function get_doctor_share_by_id($id){

        $data = DB::table('sysc_doctorfeemst as d')
            ->where('d.doctorfeemst_no_pk',$id)
            ->leftJoin('hrms_personnel as p', 'd.person_no_fk', '=', 'p.person_no_pk')
            ->leftJoin('sysc_itemtype as i', 'd.itemtype_no_fk', '=', 'i.itemtype_no_pk')
            ->orderBy('d.doctorfeemst_no_pk', 'desc')
            ->select(
                'd.*',
                'p.full_name',
                'i.item_type_name'
            )
            ->first();
        // dd($data);
        
        return $data;
    }

    public function update_doctor_share(array $data)
    {
        try {
            $au_entry_at   = now();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            // Validation
            if (empty($data['person_no_fk'])) {
                return response()->json(['success' => false, 'message' => 'Doctor is required'], 422);
            }
            if (empty($data['itemtype_no_fk'])) {
                return response()->json(['success' => false, 'message' => 'Item Type is required'], 422);
            }
            if (isset($data['share_per']) && ($data['share_per'] < 0 || $data['share_per'] > 100)) {
                return response()->json(['success' => false, 'message' => 'Share % must be between 0 and 100'], 422);
            }

            $updateData = [
                'person_no_fk'          => $data['person_no_fk'],
                'itemtype_no_fk'        => $data['itemtype_no_fk'],
                'share_per'             => $data['share_per'],
                'start_date'            => !empty($data['start_date']) ? $data['start_date'] : null,
                'end_date'              => !empty($data['end_date']) ? $data['end_date'] : null,
                'status'                => isset($data['status']) ? $data['status'] : 0,
                'au_update_at'          => $au_entry_at,
                'au_update_by'          => Auth::id(),
                'au_update_session'     => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
            ];

            DB::table('sysc_doctorfeemst')
                ->where('doctorfeemst_no_pk', $data['doctorfeemst_no_pk'])
                ->update($updateData);

            return response()->json([
                'success' => true,
                'msg'     => 'Doctor Share Successfully Updated',
                'title'   => 'Success'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'msg'     => $th->getMessage(),
                'title'   => 'Error'
            ], 422);
        }
    }


    public function get_accounts_type_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_4accounttype')
            ->leftJoin('acc_coa_3accountgrouptype','acc_coa_3accountgrouptype.acc_3grouptype_no_pk','=','acc_coa_4accounttype.acc_3grouptype_no_fk')
            ->orderBy('acc_coa_4accounttype.acc_4type_no_pk', 'desc')
            ->where('acc_coa_4accounttype.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acc_coa_4accounttype.acc_4type_notes',
                'acc_coa_4accounttype.status',
                'acc_coa_4accounttype.acc_4type_name',
                'acc_coa_4accounttype.acc_4type_code',
                'acc_coa_4accounttype.acc_4type_description',
                'acc_coa_4accounttype.acc_code_range_4_start',
                'acc_coa_4accounttype.acc_code_range_4_end',
                'acc_coa_4accounttype.acc_4type_no_pk',
                'acc_coa_4accounttype.acc_3grouptype_no_fk',
                'acc_coa_3accountgrouptype.acc_3grouptype_name',
                'acc_coa_3accountgrouptype.acc_3grouptype_code'
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function get_accounts_type_by_id($id){
        $data = DB::table('acc_coa_4accounttype')
                    ->where('acc_4type_no_pk',$id)
                    ->select(
                        'acc_coa_4accounttype.acc_4type_notes',
                        'acc_coa_4accounttype.status',
                        'acc_coa_4accounttype.acc_4type_name',
                        'acc_coa_4accounttype.acc_4type_code',
                        'acc_coa_4accounttype.acc_4type_description',
                        'acc_coa_4accounttype.acc_code_range_4_start',
                        'acc_coa_4accounttype.acc_code_range_4_end',
                        'acc_coa_4accounttype.acc_4type_no_pk',
                        'acc_coa_4accounttype.acc_3grouptype_no_fk'
                        )
                        
                    ->first();
        return $data;
    }

    public function update_account_type(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_3accountgrouptype')->where('acc_3grouptype_no_pk', $data['account_group_type_fk'])->select('acc_code_range_3_start','acc_code_range_3_end')->first();
            if($range_data->acc_code_range_3_start != null && $range_data->acc_code_range_3_end != null){
                if($data['account_type_code'] < $range_data->acc_code_range_3_start || $data['account_type_code'] > $range_data->acc_code_range_3_end){
                    return response()->json(['success' => false, 'message' => "Account Type Code Not Eligible. Please give between ".$range_data->acc_code_range_3_start." and ".$range_data->acc_code_range_3_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            

            $datas = [
                'status' => $data['status'],
                'acc_4type_notes'  => $data['notes'],
                'acc_code_range_4_start' => $data['start_range'],
                'acc_code_range_4_end' => $data['end_range'],
                'acc_4type_name' => $data['account_type_name'],
                'acc_4type_code' => $data['account_type_code'],
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,               
                'acc_3grouptype_no_fk' => $data['account_group_type_fk']
            ];
            if(DB::table('acc_coa_4accounttype')->where('acc_4type_no_pk','!=', $data['acc_4type_no_pk'])->where('acc_4type_code',$data['account_type_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Type Code Already Exists'],422);
            }
            DB::table('acc_coa_4accounttype')->where('acc_4type_no_pk', $data['acc_4type_no_pk'])->update($datas);


            return response()->json(['success' => true, 'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }
    
    public function save_account_description(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_4accounttype')->where('acc_4type_no_pk', $data['acc_4type_no_fk'])->select('acc_code_range_4_start','acc_code_range_4_end')->first();
            
            if($range_data->acc_code_range_4_start != null && $range_data->acc_code_range_4_end != null){
                if($data['account_description_code'] < $range_data->acc_code_range_4_start || $data['account_description_code'] > $range_data->acc_code_range_4_end){
                    return response()->json(['success' => false, 'message' => "Account Group Type Code Not Eligible. Please give between ".$range_data->acc_code_range_4_start." and ".$range_data->acc_code_range_4_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
            $sequence = DB::getSequence();
            $acc_5typedescription_no_pk_seq = $sequence->nextValue('acc_5typedescription_no_pk_seq');

            $datas = [
                'status' => $data['status'],
                'acc_5type_description_notes'  => $data['notes'],
                'acc_code_range_5_start' => $data['start_range'],
                'acc_code_range_5_end' => $data['end_range'],
                'acc_5type_description' => $data['account_description_name'],
                'type_code' => $data['account_description_code'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acc_5typedescription_no_pk' => $acc_5typedescription_no_pk_seq,
                'acc_4type_no_fk' => $data['acc_4type_no_fk']
            ];
            if(DB::table('acc_coa_5accountdescription')->where('type_code',$data['account_description_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Description Code Already Exists'],422);
            }
            DB::table('acc_coa_5accountdescription')->insert($datas);

            $accountsGroup = $this->get_accounts_description_v1();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $accountsGroup->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    public function get_accounts_description_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_5accountdescription')
            ->leftJoin('acc_coa_4accounttype','acc_coa_4accounttype.acc_4type_no_pk','=','acc_coa_5accountdescription.acc_4type_no_fk')
            ->orderBy('acc_coa_5accountdescription.acc_5typedescription_no_pk', 'desc')
            ->where('acc_coa_5accountdescription.au_entry_hospital_pk_no', $ses_hospital_id)
            ->select(
                'acc_coa_5accountdescription.acc_5type_description_notes',
                'acc_coa_5accountdescription.status',
                'acc_coa_5accountdescription.acc_5type_description',
                'acc_coa_5accountdescription.type_code',
                'acc_coa_5accountdescription.acc_code_range_5_start',
                'acc_coa_5accountdescription.acc_code_range_5_end',
                'acc_coa_5accountdescription.acc_5typedescription_no_pk',
                'acc_coa_5accountdescription.acc_4type_no_fk',
                'acc_coa_4accounttype.acc_4type_name',
                'acc_coa_4accounttype.acc_4type_code'
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function get_accounts_by_id($id){
        $data = DB::table('acc_coa_5accountdescription')
                    ->where('acc_5typedescription_no_pk',$id)
                    ->select(
                        'acc_coa_5accountdescription.acc_5type_description_notes',
                        'acc_coa_5accountdescription.status',
                        'acc_coa_5accountdescription.acc_5type_description',
                        'acc_coa_5accountdescription.type_code',
                        'acc_coa_5accountdescription.acc_code_range_5_start',
                        'acc_coa_5accountdescription.acc_code_range_5_end',
                        'acc_coa_5accountdescription.acc_5typedescription_no_pk',
                        'acc_coa_5accountdescription.acc_4type_no_fk',
                        )                       
                    ->first();
        return $data;
    }

    public function update_account_description(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }
            
            $start_range = $data['start_range'];
            $end_range = $data['end_range'];

            if($start_range != '' || $end_range != ''){
                if($start_range == ''){
                    return response()->json(['success' => false, 'message' => "Start Range Required" ,'title' => 'Error'],422);
                }
                if($end_range == ''){
                    return response()->json(['success' => false, 'message' => "End Range Required" ,'title' => 'Error'],422);
                }
            }
            
            /*range check*/
            $range_data = DB::table('acc_coa_4accounttype')->where('acc_4type_no_pk', $data['acc_4type_no_fk'])->select('acc_code_range_4_start','acc_code_range_4_end')->first();
            
            if($range_data->acc_code_range_4_start != null && $range_data->acc_code_range_4_end != null){
                if($data['account_description_code'] < $range_data->acc_code_range_4_start || $data['account_description_code'] > $range_data->acc_code_range_4_end){
                    return response()->json(['success' => false, 'message' => "Account Group Type Code Not Eligible. Please give between ".$range_data->acc_code_range_4_start." and ".$range_data->acc_code_range_4_end ,'title' => 'Error'],422);
                }
            }
            /*range check*/
            
          
            $datas = [
                'status' => $data['status'],
                'acc_5type_description_notes'  => $data['notes'],
                'acc_code_range_5_start' => $data['start_range'],
                'acc_code_range_5_end' => $data['end_range'],
                'acc_5type_description' => $data['account_description_name'],
                'type_code' => $data['account_description_code'],
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'acc_4type_no_fk' => $data['acc_4type_no_fk']
            ];
            if(DB::table('acc_coa_5accountdescription')->where('acc_5typedescription_no_pk' ,'!=', $data['acc_5typedescription_no_pk'])->where('type_code',$data['account_description_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Account Description Code Already Exists'],422);
            }
            DB::table('acc_coa_5accountdescription')->where('acc_5typedescription_no_pk' , $data['acc_5typedescription_no_pk'])->update($datas);


            return response()->json(['success' => true, 'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }

    public function get_item_wise_accounts_integration(){
        $data = DB::table('acc_integrationitemgroup_vw')
                    ->select('acc_integrationitemgroup_vw.voucher_type_name','acc_integrationitemgroup_vw.trn_type_code','acc_integrationitemgroup_vw.serviceunit_name','acc_integrationitemgroup_vw.active_status','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk','acc_integrationitemgroup_vw.mserviceunit_name','acc_integrationitemgroup_vw.trn_type_name','acc_integrationitemgroup_vw.module_code')
                    ->groupBy('acc_integrationitemgroup_vw.voucher_type_name','acc_integrationitemgroup_vw.trn_type_code','acc_integrationitemgroup_vw.serviceunit_name','acc_integrationitemgroup_vw.active_status','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk','acc_integrationitemgroup_vw.mserviceunit_name','acc_integrationitemgroup_vw.trn_type_name','acc_integrationitemgroup_vw.module_code')
                    ->leftJoin('acc_integrationitemgroupmst','acc_integrationitemgroupmst.itemgroupwisemst_no_pk','=','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk')                  
                    ->where('acc_integrationitemgroupmst.page_seperation_code','GRN')
                    ->orderByRaw('lower(acc_integrationitemgroup_vw.voucher_type_name) asc')
                ->get();
        return $data;
    }

    public function get_major_group($con){
        $major_group = DB::table('sysc_itemtype')->select('item_type_name','itemtype_no_pk','major_group_ind','itemtype_code')->whereRaw($con)->get();
        return $major_group;
    }

    public function get_accounts_integration_dtl_by_parent($id){
        $details = DB::table('acc_integrationitemgroupdtl')
                        ->select('*')
                        ->where('itemgroupwisemst_no_fk',$id)
                        ->get()
                        ->map(function ($item) {
                            unset(
                                $item->au_entry_by,
                                $item->au_entry_at,
                                $item->au_entry_session,
                                $item->au_entry_hospital_pk_no,
                                $item->au_update_by,
                                $item->au_update_at,
                                $item->au_update_session,
                                $item->au_update_hospital_pk_no,
                                $item->au_sync_hospital_pk_no,
                                $item->au_sync_at
                            );
                            return $item;
                        });
        return response()->json(['success' => true, 'data' => $details]);
    }

    public function get_accounts_integration_master_by_id($id){
        $master = DB::table('acc_integrationitemgroupmst')
                        ->select('*')
                        ->where('itemgroupwisemst_no_pk', $id)
                        ->first();

                    if ($master) {
                        unset(
                            $master->au_entry_by,
                            $master->au_entry_at,
                            $master->au_entry_session,
                            $master->au_entry_hospital_pk_no,
                            $master->au_update_by,
                            $master->au_update_at,
                            $master->au_update_session,
                            $master->au_update_hospital_pk_no,
                            $master->au_sync_hospital_pk_no,
                            $master->au_sync_at
                        );
                    }
        return $master;
    }

    public function get_accounts_integration_details_by_id($id){
        $details = DB::table('acc_integrationitemgroup_vw')
                        ->select('acc_integrationitemgroup_vw.*','sysc_module.module_code','sysc_module.module_name')
                        ->where('itemgroupwisemst_no_pk', $id)
                        ->leftJoin('sysc_module','sysc_module.module_no_pk','=','acc_integrationitemgroup_vw.module_no_fk')
                        // ->orderBy('account_code','asc')
                        ->orderBy('trn_crdr_type','desc')
                        ->get();
        return $details;
    }

    public function get_accounts_prev_opening_balance_v1(){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk'); 
        $prev_opening_balance = DB::table('acct_openingbalance_vw')
                                ->orderBy('opbal_enddate','desc')
                                ->get();

         return response()->json(['success' => true, 'data' => $prev_opening_balance]);
    }

    public function get_opening_balance_by_id($id){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk'); 
        $prev_opening_balance = DB::table('acct_openingbalance')
                                ->leftJoin('acct_chart_of_accounts','acct_chart_of_accounts.account_no_pk','=','acct_openingbalance.trn_account_no_fk')
                                ->select('acct_openingbalance.*','acct_chart_of_accounts.account_name')
                                ->where('acct_openingbalance.au_entry_hospital_pk_no',$hospital_pk_no)
                                ->where('acct_openingbalance.opbal_no_pk',$id)
                                ->orderBy('acct_openingbalance.fiscal_year_fk','desc')
                                ->first();

        return $prev_opening_balance;
    }

    public function currency_data(){
        $currency = [];
        $curr_data = DB::table('sysc_currency')->select('currency_no_pk','rate','currency_code','status')
        // ->where('status',1)
        ->get();
        foreach ($curr_data as $value) {           
            $temp['curr_pk'] = $value->currency_no_pk;;
            $temp['curr_name'] = $value->currency_code;
            $temp['curr_rate'] = $value->rate;
            $temp['status'] = $value->status;
            
            array_push($currency,$temp);
        }
        return $currency;
    }

    public function get_accounts_currency_by_id($id){
        $curr_data = DB::table('sysc_currency')->select('currency_no_pk','rate','currency_code','status')
                        ->where('currency_no_pk',$id)
                        ->first();
        return $curr_data;
    }


    public function get_item_wise_accounts_integration_billing(){
        // page_seperation_code
        $data = DB::table('acc_integrationitemgroup_vw')
                ->select('acc_integrationitemgroup_vw.voucher_type_name','acc_integrationitemgroup_vw.trn_type_code','acc_integrationitemgroup_vw.serviceunit_name','acc_integrationitemgroup_vw.active_status','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk','acc_integrationitemgroup_vw.mserviceunit_name','acc_integrationitemgroup_vw.trn_type_name','acc_integrationitemgroup_vw.module_code')
                ->groupBy('acc_integrationitemgroup_vw.voucher_type_name','acc_integrationitemgroup_vw.trn_type_code','acc_integrationitemgroup_vw.serviceunit_name','acc_integrationitemgroup_vw.active_status','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk','acc_integrationitemgroup_vw.mserviceunit_name','acc_integrationitemgroup_vw.trn_type_name','acc_integrationitemgroup_vw.module_code')
                ->leftJoin('acc_integrationitemgroupmst','acc_integrationitemgroupmst.itemgroupwisemst_no_pk','=','acc_integrationitemgroup_vw.itemgroupwisemst_no_pk')
                
                ->where('acc_integrationitemgroupmst.page_seperation_code','BILLING')
                ->orderByRaw('lower(acc_integrationitemgroup_vw.voucher_type_name) asc')
                ->get();
        return $data;
    }
}