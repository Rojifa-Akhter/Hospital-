<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use Session;
use DB;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Auth;

class AccountsIntegrationPayrollController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payroll_list = DB::table('acc_integration_payrolllist_vw')->get();

        return  Template::loadview('admin.settings.accounts_integration.payroll.index', [
            'payroll_list' => $payroll_list
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $salary_breakdown = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYBREAKDOWN");

        //dd( $paymodes ,  $bank_name );
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();

        return Template::loadview('admin.settings.accounts_integration.payroll.create', [
            'paymodes' => $paymodes,
            'bank_name' => $bank_name,
            'sysc_module' => $sysc_module,
            'salary_breakdown' => $salary_breakdown
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = $request->id;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $module = explode('_', $request->module_no_fk);
            $sequence = DB::getSequence();
            $dash_board_item_set_no_pk_seq = $sequence->nextValue('integrationpayroll_no_pk_seq');
            $data = [
                'payroll_breakdown_code' => $request->payroll_breakdown_code,
                'bank_no_fk' => isset($request->bank_no_fk) ? $request->bank_no_fk : 0,
                'trn_cr_account_no_fk' => $request->trn_cr_account_no_fk,
                'trn_cr_account_percent' => $request->trn_cr_account_percent,
                'trn_dr_account_no_fk' => $request->trn_dr_account_no_fk,
                'trn_dr_account_percent' => $request->trn_dr_account_percent,
                'module_code' =>  $module[1],
                'module_no_fk' => $module[0],
                'status' => $request->status,
                'au_entry_hospital_pk_no' => $hospital_id,
            ];

            if ($id == null || $id == '') {

                // AU_ENTRY_BY
                $data['integrationpayroll_no_pk'] = $dash_board_item_set_no_pk_seq;
                $data['integrationpayroll_code'] = $dash_board_item_set_no_pk_seq;
                $data['au_entry_by'] = Auth::user()->user_no_pk;
                $data['au_entry_at'] = date('Y-m-d');
                $data['au_entry_session'] = "Session";

                // return $data;
                DB::table('acc_integration_payroll_list')->insert($data);
                //$this->model->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = Auth::user()->user_no_pk;
                DB::table('acc_integration_payroll_list')->where('integrationpayroll_no_pk', $id)->update($data);
                //$this->model->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $paymode_item =  DB::table('acc_integration_payrolllist_vw')->where('integrationpayroll_no_pk', $id)->first();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $salary_breakdown = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYBREAKDOWN");

        //dd( $paymodes ,  $bank_name );
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();

        return Template::loadview('admin.settings.accounts_integration.payroll.create', [
            'paymodes' => $paymodes,
            'bank_name' => $bank_name,
            'sysc_module' => $sysc_module,
            'salary_breakdown' => $salary_breakdown,
            'paymode_item' => $paymode_item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
