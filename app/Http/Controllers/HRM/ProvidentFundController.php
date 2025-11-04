<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Designation;
use App\Models\ServiceUnit;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Session;
use PDF;

class ProvidentFundController extends Controller
{
    //HRMS_PROVIDENTFUNDPOLICY
    public function fundPolicy()
    {
        $policy = DB::table('HRMS_PROVIDENTFUNDPOLICY')->first();
        return Template::loadView("admin.v1.providentfund.provident-fund-policy", [
            'policy' => $policy
        ]);
    }

    public function storFundPolicy(Request $request)
    {
        try {
            if ($request->fundpolicy_no_pk) {
                DB::table('HRMS_PROVIDENTFUNDPOLICY')->where('fundpolicy_no_pk', $request->fundpolicy_no_pk)->update(
                    [
                        "min_servicelength" => $request->mini_length_serv,
                        "emp_share_pct"     => $request->employee_share_per,
                        "ofc_share_pct"     => $request->org_share,
                        "status"            => 1,
                        'au_entry_by'       => auth::user()->user_no_pk,
                        'au_entry_at'       => date('Y-m-d')
                    ]
                );
            } else {
                $sequence = DB::getSequence();
                DB::table('HRMS_PROVIDENTFUNDPOLICY')->insert(
                    [
                        "min_servicelength" => $request->mini_length_serv,
                        "emp_share_pct"     => $request->employee_share_per,
                        "ofc_share_pct"     => $request->org_share,
                        "status"            => 1,
                        'au_entry_by'       => auth::user()->user_no_pk,
                        'au_entry_at'       => date('Y-m-d'),
                        'fundpolicy_no_pk'       =>  $sequence->nextValue('fundpolicy_no_pk_seq'),
                    ]
                );
            }

            $message = ['msg' => 'Policy saved successfully.', 'title' => 'Success'];
        } catch (Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function fundSettlement()
    {
        $policy = DB::table('HRMS_PROVIDENTFUNDPOLICY')->first();
        return Template::loadView("admin.v1.providentfund.provident-fund-final-settlement", [
            'policy' => $policy,
            'type' => 1
        ]);
    }


    public function getAllSalaryInfo(Request $request)
    {
        $salary =  DB::table('hrms_personnel_salary_monthly')->where('person_no_fk', $request->employee_id);
        $total_amount =  DB::table('hrms_personnel_salary_monthly')->where('person_no_fk', $request->employee_id)->selectRaw("sum(pf_company_amount + pf_presonnel_amount) total")->get();
        $policy = DB::table('HRMS_PROVIDENTFUNDPOLICY')->first();
        if (isset($request->from_date) && $request->to_date) {
            $salary->where(DB::raw('trunc(salary_process_date)'), '>=', date('Y-m-d', strtotime($request->from_date)));
            $salary->where(DB::raw('trunc(salary_process_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        }

        return Template::loadView("admin.v1.providentfund.provident-fund-salary-info", [
            'salary' => $salary->get(),
            'total_amount' => $total_amount,
            'policy' => $policy,
            'type' =>  $request->type ?? 1
        ]);
    }


    public function storeFundSettlement(Request $request)
    {
        $sequence = DB::getSequence();
        $pf_no_pk_seq =  $sequence->nextValue('pf_no_pk_seq');
        $data = [
            "effective_date" => $request->pf_date,
            "person_no_fk" => $request->employee_id,
            "joining_date" => $request->joining_date,
            "statutory_rate" => $request->rate_of_cont,
            "pf_settlement_date" => $request->pf_date,
            "pf_settlement_amount" => $request->pf_amt,
            "pf_settlement_reason" => $request->reason,
            "status" => 1,
            "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
            "au_entry_by" => Auth::user()->user_no_pk,
            "au_entry_at" => date("Y-m-d"),
            "au_entry_session" => "Settlement",
            "pf_no_pk" => $pf_no_pk_seq,
        ];

        DB::table('hrms_provident_fund_mst')->insert($data);

        $salary =  DB::table('hrms_personnel_salary_monthly')->where('person_no_fk', $request->employee_id)->get();

        if (!empty($salary)) {
            foreach ($salary as $data) {
                $sequence = DB::getSequence();
                DB::table('hrms_provident_fund_dtl')->insert([
                    'pfdtl_no_pk' => $sequence->nextValue('pfdtl_no_pk_seq'),
                    'PF_NO_FK' => $pf_no_pk_seq,
                    'SL_NO' => 1,
                    'PF_MONTH' => $data->salary_description,
                    'PERSON_SALARY_AMT' => $data->gross_salary,
                    'PF_PERSON_AMOUNT' => $data->pf_presonnel_amount,
                    "status" => 1,
                    "au_entry_by" => Auth::user()->user_no_pk,
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                    "au_entry_session" => "Settlement",
                    "au_entry_at" => date("Y-m-d"),
                ]);
            }
        }
        $message = ['msg' => 'Policy saved successfully.', 'title' => 'Success'];
        return response()->json($message);
    }
    public function monthWiseContributionPosting()
    {
        return Template::loadView("admin.v1.providentfund.monthly-office-wise-contribution-posting", [
            'type' => 2
        ]);
    }
}
