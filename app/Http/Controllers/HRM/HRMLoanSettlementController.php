<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class HRMLoanSettlementController extends Controller
{
    //HRMLoanSettlementController
    use UtilitiesTrait;
    public function loanSettlement($loadId)
    {
        $getUid = $this->getAutoGenerateUID('hrms_loanrequest', 'loan_req_uid');
        $loanList = DB::table('hrms_loanrequest')
            ->join('employee_info_vw', 'hrms_loanrequest.request_by', 'employee_info_vw.person_no_pk')
            ->select('hrms_loanrequest.*', 'employee_info_vw.person_code', 'employee_info_vw.full_name', 'employee_info_vw.join_date', 'employee_info_vw.designation', 'employee_info_vw.su_name')
            ->where('loan_req_no_pk', $loadId)->first();

        $loanDtls = DB::table('hrms_loansettlement')
            ->join('hrms_loansettlementdtl', 'hrms_loansettlement.loansettlement_no_pk', 'hrms_loansettlementdtl.loansettlement_no_fk')
            ->where('loan_req_no_fk', $loadId)
            ->get();

        $loanInfo = DB::table('hrms_loansettlement')->where('loan_req_no_fk', $loadId)->get();


        return Template::loadView("admin.v1.hrm.loan-settlement", [
            'getUid' => $getUid,
            'loanList' => $loanList,
            'loanDtls' => $loanDtls,
            'loanInfo' => $loanInfo
        ]);
    }


    public function storeLoanSettlement(Request $request)
    {
        try {
            $sequence = DB::getSequence();
            $fileName = '';

            $data = [
                'loan_req_no_fk'         => $request->loan_req_no_fk,
                'approval_date'          => date('Y-m-d', strtotime($request->apporved_date)),
                'approval_amt'           => $request->apporved_amt,
                'refund_amt'             => $request->refund_amt,
                'no_of_installment'      => $request->no_fo_install,
                'installment_amt'        => $request->install_amt,
                'loan_reason'            => $request->loan_reason,
                'loan_saveoption'        => $request->in_req_saveoption,
                'person_no_fk'           => $request->person_no_fk,
                'au_entry_by'            => auth::user()->user_no_pk,
                'au_entry_at'            => date('Y-m-d'),
                'installment_start_date' => date('Y-m-d', strtotime($request->ins_start_date)),
                'status'                 => 1,
                'deduct_from_salary'     => $request->deduct_from_salary,
            ];

            if (isset($request->upload_application)) {
                $fileName = time() . '.' . $request->upload_application->extension();
                $request->upload_application->move(public_path('uploads/hrm/loan_settlement'), $fileName);
                $data['upload_application'] =   $fileName;
            }
            if (isset($request->loansettlement_no_pk)) {
                DB::table('hrms_loansettlement')->where('loansettlement_no_pk', $request->loansettlement_no_pk)->update($data);

                DB::table('hrms_loansettlementdtl')->where('loansettlement_no_fk', $request->loansettlement_no_pk)->delete();

                for ($i = 0; $i < count($request->date_arr); $i++) {
                    $data = [
                        'loansettlement_no_fk'    => $request->loansettlement_no_pk,
                        'no_of_installment'       => $i + 1,
                        'installment_date'        => date('Y-m-d', strtotime($request->date_arr[$i])),
                        'installment_amt'         => $request->install_amt,
                        'au_entry_by'             => auth::user()->user_no_pk,
                        'au_entry_at'             => date('Y-m-d'),
                        'loansettlementdtl_no_pk' => $sequence->nextValue('loansettlementdtl_no_pk_seq'),
                    ];
                    DB::table('hrms_loansettlementdtl')->insert($data);
                }
            } else {
                $loansettlement_no_pk_seq = $sequence->nextValue('loansettlement_no_pk_seq');
                $data['loansettlement_no_pk'] =    $loansettlement_no_pk_seq;
                DB::table('hrms_loansettlement')->insert($data);
                for ($i = 0; $i < count($request->date_arr); $i++) {
                    $data = [
                        'loansettlement_no_fk'    => $loansettlement_no_pk_seq,
                        'no_of_installment'       => $i + 1,
                        'installment_date'        => date('Y-m-d', strtotime($request->date_arr[$i])),
                        'installment_amt'         => $request->install_amt,
                        'au_entry_by'             => auth::user()->user_no_pk,
                        'au_entry_at'             => date('Y-m-d'),
                        'loansettlementdtl_no_pk' => $sequence->nextValue('loansettlementdtl_no_pk_seq'),
                    ];
                    DB::table('hrms_loansettlementdtl')->insert($data);
                }
            }
            DB::commit();

            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function editLoanRequest($loanID)
    {
        $loan = DB::table('hrms_loanrequest')->where('loan_req_no_pk', $loanID)->first();
        return Template::loadView("admin.v1.hrm.edit-loan-request", [
            'loan' => $loan
        ]);
    }

    public function loanSettlementDateTime(Request $request)
    {
        $installment  = $request->installment;
        $date = date('Y-m-d', strtotime($request->start_date));
        $new_date = date('Y-m-d', strtotime('+' . $installment . ' month', strtotime($date)));
        return Template::loadView("admin.v1.hrm.load-settlement-date-time", [
            'date' => $date,
            'new_date' => $new_date,
            'installment' => $installment,
            'install_amt' => $request->install_amt
        ]);
    }


    public function loanInstallmentPaymentAndClose($loanReqNo = "")
    {
        // dd($loanReqNo);
        $Details = DB::table('hrms_loansettlement')
            ->join('hrms_loansettlementdtl', 'hrms_loansettlement.loansettlement_no_pk', 'hrms_loansettlementdtl.loansettlement_no_fk')
            ->where('loan_req_no_fk', $loanReqNo)
            ->get();
        // dd($Details);

        return Template::loadView("admin.v1.hrm.loan-installment-payment-and-closing", ['Details' => $Details]);
    }
    public function searchLoanInstallmentPaymentAndClose(Request $request)
    {
        $loanDtls = DB::table('hrms_loansettlement')
            ->join('hrms_loansettlementdtl', 'hrms_loansettlement.loansettlement_no_pk', 'hrms_loansettlementdtl.loansettlement_no_fk')
            ->where('loan_req_no_fk', $request->loan_id)
            ->get();
        return Template::loadView("admin.v1.hrm.loan-installment-payment-and-closing-table", [
            'loanDtls' => $loanDtls
        ]);
    }

    public function updateLoanInstallmentPaymentAndClose(Request $request)
    {

        for ($i = 0; $i < count($request->loansettlementdtl_no_pk); $i++) {
            DB::table('hrms_loansettlementdtl')->where('loansettlementdtl_no_pk', $request->loansettlementdtl_no_pk[$i])->update([
                'pay_status' => 1,
                'paid_date' => date('Y-m-d'),
            ]);
            DB::commit();
        }
        $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        return response()->json($message);
    }
}
