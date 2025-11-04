<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use Session;
use DB;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Auth;

class AccountsIntegrationPaymoodController extends Controller
{
    use LookupData, DatatablesLoader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $paymood_list = DB::table('acc_integration_paymood_vw')->orderBy('integrationpaymood_no_pk','desc')->get();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        //dd( $paymodes ,  $bank_name );
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $voucher_type = DB::table('acct_voucher_type')->get();

        return  Template::loadview('admin.settings.accounts_integration.paymood.index', [
            'paymood_list' => $paymood_list,
            'paymodes' => $paymodes,
            'bank_name' => $bank_name,
            'finc_trntype' => $finc_trntype,
            'sysc_module' => $sysc_module,
            'voucher_type' => $voucher_type,
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
        //dd( $paymodes ,  $bank_name );
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $voucher_type = DB::table('acct_voucher_type')->get();
        return Template::loadview('admin.settings.accounts_integration.paymood.create', [
            'paymodes' => $paymodes,
            'bank_name' => $bank_name,
            'finc_trntype' => $finc_trntype,
            'sysc_module' => $sysc_module,
            'voucher_type' => $voucher_type,

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
            $dash_board_item_set_no_pk_seq = $sequence->nextValue('integrationpaymood_no_pk_seq');
            $data = [
                'payment_mood' => $request->payment_mood,
                'bank_no_fk' => isset($request->bank_no_fk) ? $request->bank_no_fk : 0,
                'card_type' => $request->card_type,
                'trn_cr_account_no_fk' => $request->trn_cr_account_no_fk,
                'trn_cr_account_percent' => $request->trn_cr_account_percent,
                'trn_dr_account_no_fk' => $request->trn_dr_account_no_fk,
                'trn_dr_account_percent' => $request->trn_dr_account_percent,
                'voucher_type_no_fk' => $request->voucher_type_no_fk ? $request->voucher_type_no_fk : null,
                'module_code' =>  $module[1],
                'module_no_fk' => $module[0],
                'status' => $request->status,
                'au_entry_hospital_pk_no' => $hospital_id,
            ];

            if ($id == null || $id == '') {

                // AU_ENTRY_BY
                $data['integrationpaymood_no_pk'] = $dash_board_item_set_no_pk_seq;
                $data['integrationpaymood_code'] = $dash_board_item_set_no_pk_seq;
                $data['au_entry_by'] = Auth::user()->user_no_pk;
                $data['au_entry_at'] = date('Y-m-d');
                $data['au_entry_session'] = "Session";

                // return $data;
                DB::table('acc_integration_paymood')->insert($data);
                //$this->model->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = Auth::user()->user_no_pk;
                DB::table('acc_integration_paymood')->where('integrationpaymood_no_pk', $id)->update($data);
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
        $paymode_item =  DB::table('acc_integration_paymood_vw')->where('integrationpaymood_no_pk', $id)->first();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        //dd( $paymodes ,  $bank_name );
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();

        $voucher_type = DB::table('acct_voucher_type')->get();

        return Template::loadview('admin.settings.accounts_integration.paymood.create', [
            'paymodes' => $paymodes,
            'bank_name' => $bank_name,
            'finc_trntype' => $finc_trntype,
            'sysc_module' => $sysc_module,
            'paymode_item' => $paymode_item,
            'voucher_type' => $voucher_type
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
