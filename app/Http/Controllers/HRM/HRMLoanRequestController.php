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

class HRMLoanRequestController extends Controller
{
    //
    use UtilitiesTrait;

    public function loanList()
    {
        $loanList = DB::table('hrms_loanrequest')->join('employee_info_vw', 'hrms_loanrequest.request_by', 'employee_info_vw.person_no_pk')
            ->leftJoin('hrms_loansettlement loansett', 'hrms_loanrequest.loan_req_no_pk', 'loansett.loan_req_no_fk')
            ->select('hrms_loanrequest.*', 'loansett.approval_date', 'loansett.approval_amt', 'loansett.no_of_installment as refund_installment', 'loansett.refund_amt', 'employee_info_vw.person_code', 'employee_info_vw.full_name', 'employee_info_vw.join_date')->where('req_saveoption', 'POST')->orderBy('loan_req_no_pk', 'desc')->get();

        return Template::loadView("admin.v1.hrm.loan-request-list", ['loanList' => $loanList]);
    }


    public function loanRequestListSearch(Request $request)
    {
        $search_data = [
            'application' => $request->application,
            'approved'    => $request->approved,
            'completed'   => $request->completed,
            'rejected'    => $request->rejected,
        ];
        // dd($search_data);

        $query = DB::table('hrms_loanrequest')
            ->join('employee_info_vw', 'hrms_loanrequest.request_by', 'employee_info_vw.person_no_pk')
            ->leftJoin('hrms_loansettlement loansett', 'hrms_loanrequest.loan_req_no_pk', 'loansett.loan_req_no_fk')
            ->select('hrms_loanrequest.*', 'loansett.approval_date', 'loansett.approval_amt', 'loansett.no_of_installment as refund_installment', 'loansett.refund_amt', 'employee_info_vw.person_code', 'employee_info_vw.full_name', 'employee_info_vw.join_date');
        if (isset($search_data['application'])) {
            $query->orWhere('loan_req_ind', 1);
        }
        if (isset($search_data['approved'])) {
            $query->orWhere('loan_approve_ind', 1);
        }
        if (isset($search_data['completed'])) {
            $query->orWhere('loan_complete_ind', 1);
        }
        if (isset($search_data['rejected'])) {
            $query->orWhere('loan_reject_ind', 1);
        }
        $query->where('req_saveoption', 'POST')->orderBy('loan_req_no_pk', 'desc');

        $loanSearchList = $query->get();

        // dd($loanSearchList);
        return Template::loadView("admin.v1.hrm.loan-request-list-search-table", ['loanSearchList' => $loanSearchList]);
    }



    public function loanRequest()
    {
        $getUid = $this->getAutoGenerateUID('hrms_loanrequest', 'loan_req_uid');
        $loanList = DB::table('hrms_loanrequest')->where('request_by', Auth::user()->person_no_fk)->orderBy('loan_req_no_pk', 'desc')->get();
        return Template::loadView("admin.v1.hrm.loan-request", [
            'getUid' => $getUid,
            'loanList' => $loanList
        ]);
    }


    public function storeLoanRequest(Request $request)
    {
        try {
            $sequence = DB::getSequence();
            $fileName = '';

            $data = [
                'loan_req_uid'      => $request->loan_req_uid,
                'req_reason'        => $request->req_reason,
                'expected_date'     => date('Y-m-d', strtotime($request->expected_date)),
                'loan_amt'          => $request->loan_amt,
                'no_of_installment' => $request->no_of_installment,
                'installment_amt'   => $request->installment_amt,
                'loan_req_desc'     => $request->loan_req_desc,
                'req_saveoption'    => $request->in_req_saveoption,
                'remarks'           => $request->reamrks,
                'request_by'        => Auth::user()->person_no_fk,
                'au_entry_by'       => Auth::user()->user_no_pk,
                'au_entry_at'       => date('Y-m-d'),
                'status'            => 1,
            ];

            if (isset($request->upload_application)) {
                $fileName = time() . '.' . $request->upload_application->extension();
                $request->upload_application->move(public_path('uploads/hrm/'), $fileName);
                $data['upload_application'] =   $fileName;
            }
            if (isset($request->loan_req_no_pk)) {
                $loan_req_no_pk_seq = $request->loan_req_no_pk;
                DB::table('hrms_loanrequest')->where('loan_req_no_pk', $request->loan_req_no_pk)->update($data);
            } else {
                $loan_req_no_pk_seq = $sequence->nextValue('loan_req_no_pk_seq');
                $data['loan_req_no_pk'] =    $loan_req_no_pk_seq;
                DB::table('hrms_loanrequest')->insert($data);
            }
            DB::commit();

            if ($request->in_req_saveoption == "POST") {
                try {
                    $out_apprprocess_no_pk = '';
                    $out_apprprocess_uid = '';
                    $out_error = '';
                    $pdo                        = DB::getPdo();
                    $in_au_entry_by             = auth()->user()->user_no_pk;
                    $in_au_entry_session        = "Approval ";
                    $in_au_entry_hospital_pk_no = session('user.ses_hospital_no_pk');
                    $code = "LOAN";
                    $null = '';
                    $stmt = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
                        :in_approval_for_code,
                        :in_primary_key_value ,
                        :in_primary_key_uid,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :out_apprprocess_no_pk
                        :out_apprprocess_uid
                        :out_error
                    );
                        end;"); //,:in_is_manual_sl

                    $stmt->bindParam(':in_approval_for_code', $code);
                    $stmt->bindParam(':in_primary_key_value', $loan_req_no_pk_seq);
                    $stmt->bindParam(':in_primary_key_uid', $loan_req_no_pk_seq);

                    $stmt->bindParam(':in_au_entry_by', $in_au_entry_by);
                    $stmt->bindParam(':in_au_entry_session', $in_au_entry_session);
                    $stmt->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
                    $stmt->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
                    $stmt->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 500);
                    $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                    $stmt->execute();
                } catch (Exception $e) {
                }
            }
            // dd( $out_apprprocess_uid);
            $message = ['msg' => 'Data saved successfully. ', 'title' => 'Success'];
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

    public function monthlyLoanStatus()
    {
        return Template::loadView("admin.v1.hrm.monthly-loan-status");
    }


    public function searchMonthlyLoanStatus(Request $request)
    {
        $loan = DB::table('HRMS_LOANSTATUS_VW');

        if (isset($request->from_date) && $request->to_date) {
            $loan->where('approval_date', '>=', date('Y-m-d', strtotime($request->from_date)));
            $loan->where('approval_date', '<=', date('Y-m-d', strtotime($request->to_date)));
        }
        return Template::loadView("admin.v1.hrm.monthly-loan-status-table", [
            'loan' => $loan->get()
        ]);
    }
}
