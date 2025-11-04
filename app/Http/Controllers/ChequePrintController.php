<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChequePrintController extends Controller
{   

    public function index(Request $request) 
    {
        $today = date('Y-m-d');
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $cheques = DB::table('acc_chequeprint_vw a')
            ->leftJoin('wsec_user w', 'w.user_no_pk', '=', 'a.AU_ENTRY_BY')
            ->where('a.status', '1')
            ->where(DB::raw('trunc(a.au_entry_at)'), $today)
            ->orderBy('a.acc_chequeprint_no_pk', 'asc')
            ->get();

        $payToNames = DB::table('acc_chequeprint_vw')
            ->select('chq_pay_to')
            ->groupBy("chq_pay_to")
            ->orderBy("chq_pay_to", 'asc')
            ->get();


        $bankAccounts = DB::table('ACCT_CHART_OF_ACCOUNTS')
                        ->select([
                            'ACCOUNT_NO_PK as account_pk',
                            'ACCOUNT_CODE as account_code', 
                            'ACCOUNT_NAME as account_name'
                        ])
                        ->where('BANK_IND', 1)
                        ->get();


        return Template::loadView("admin.cheque-printing.index", [
            'cheques' => $cheques,
            'PayToNames' => $payToNames,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'cheque_dt' => 'required|date',
                'cheque_pay_to' => 'required|string|max:255',
                'cheque_amount' => 'required|numeric|min:0',
                'bank_name' => 'required|string',
                'cheque_number' => 'required|numeric',
                'cheque_detail_pk' => 'required|numeric', 
                'remarks' => 'required|string|max:58'
            ]);

            $id = $request->id;
            $authId = Auth::id();
            $hospitalNo = Session::get('user.ses_hospital_no_pk');
            $sequence = DB::getSequence();
            $accChequePrintNoPk = $sequence->nextValue('acc_chequeprint_no_pk_seq');

            $data = [
                'chq_date' => $request->cheque_dt ? date('Y-m-d', strtotime($request->cheque_dt)) : "",
                'chq_pay_to' => $request->cheque_pay_to,
                'chq_amount' => $request->cheque_amount,
                'chq_amount_text' => $request->sum_of_tk,
                'chq_bank_name' => $request->bank_name,
                'account_number' => $request->cheque_number,
                'chq_account_pay_ind' => $request->acc_pay,
                'remarks' => $request->remarks,
                'status' => 1,
            ];

            if ($id == null) {

                $data['acc_chequeprint_no_pk'] = $accChequePrintNoPk;
                $data['au_entry_by'] = $authId;
                $data['au_entry_at'] = now();
                $data['au_entry_hospital_pk_no'] = $hospitalNo;

                DB::table('acc_chequeprint')->insert($data);

                DB::table('ACCT_CHECQUEDTL')
                    ->where('CHECQUEDTL_NO_PK', $request->cheque_detail_pk)
                    ->update(['USE_IND' => 1]);

            } else {

                $data['au_update_by'] = $authId;
                $data['au_update_at'] = now();
                $data['au_update_hospital_pk_no'] = $hospitalNo;

                DB::table('acc_chequeprint')
                    ->where('acc_chequeprint_no_pk', $id)
                    ->update($data);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'msg' => 'Data Saved Successfully',
                'title' => 'Success'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
                'title' => 'Error'
            ], 500);
        }
    }

    public function getCheques(Request $request)
    {
        $cheques = DB::table('ACCT_CHECQUEDTL as cd')
            ->join('ACCT_CHECQUE_VERIFIED_LISTING as cvl', 'cd.CHECQUE_VERIFIED_NO_FK', '=', 'cvl.CHECQUE_VERIFIED_NO_PK')
            ->where('cvl.BANK_NO', $request->bank_pk)
            ->where('cd.USE_IND', 0)
            ->orderBy('cd.CHECQUE_NO') 
            ->select(
                'cvl.CHECQUE_VERIFIED_NO_PK as cheque_verified_pk',
                'cd.CHECQUEDTL_NO_PK as cheque_detail_pk',
                'cd.CHECQUE_NO as cheque_number'
            )
            ->get();


        return response()->json([
            'success' => true,
            'message' => 'Cheques fetched successfully.', 
            'data' => [
                'cheques' => $cheques 
            ]
        ]);
    }


}