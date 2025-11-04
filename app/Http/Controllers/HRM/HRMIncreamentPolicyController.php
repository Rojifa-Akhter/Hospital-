<?php

namespace App\Http\Controllers\HRM;

use \PDF;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceUnit;
use Session;
use PDO;

class HRMIncreamentPolicyController extends Controller
{
    //
    use UtilitiesTrait;

    public function incrementPromotionPolicy()
    {
        $incrementPromotionPolicy = DB::table("hrms_increment_promo_policy")->first();
        return Template::loadView("admin.v1.hrm.increamentmanagement.increment-policy", [
            "incrementPromotionPolicy" => $incrementPromotionPolicy
        ]);
    }

    public function storeIncreamentPromotionPolicy(Request $request)
    {
        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $incpromo_pol_no_pk = 1;
            $data = [
                'incpromo_pol_no_pk' => $incpromo_pol_no_pk,
                'intern_duration' => $request->intern_duration,
                'intern_percent' => $request->intern_percent,
                'trainee_duration' => $request->trainee_duration,
                'trainee_percent' => $request->trainee_percent,
                'regular_inc_duration' => $request->regular_duration,
                'regular_inc_percent' => $request->regular_percent,
                'regular_promo_duration' => $request->promo_duration,
                'regular_promo_percent' => $request->promo_percent,
                'incpromo_file_link' => $request->file_link,
                'incpromo_description' => $request->description,
                'au_entry_hospital_pk_no' => $hospital_pk_no
            ];
            if ($request->incpromo_pol_no) {
                $data['au_update_at'] = $au_entry_at;
                $data['au_update_by'] = Auth::id();
                DB::table("hrms_increment_promo_policy")->where('incpromo_pol_no_pk', $request->incpromo_pol_no)
                    ->update($data);
            } else {
                $data['au_entry_at'] = $au_entry_at;
                $data['au_entry_by'] = Auth::id();
                DB::table("hrms_increment_promo_policy")
                    ->insert($data);
            }


            DB::commit();

            $this->message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function dueIncreamentWorkList()
    {
        $service_unit = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

        return Template::loadView("admin.v1.hrm.increamentmanagement.due-increment-work-list", [
            'service_unit' => $service_unit
        ]);
    }


    public function searchEmployeeDueIncreament(Request $request)
    {
        $employee_info = DB::table('hrms_emp_increment_vw');
        if (isset($request->date_from) && isset($request->date_to)) {
            $employee_info->where(DB::raw('trunc(next_expected_date)'), '>=', date('Y-m-d', strtotime($request->date_from)));
            $employee_info->where(DB::raw('trunc(next_expected_date)'), '<=', date('Y-m-d', strtotime($request->date_to)));
        }
        if (isset($request->department)) {
            $employee_info->where('serviceunit_no_fk', $request->department);
        }
        if (!isset($request->date_from) && !isset($request->date_to) && !isset($request->department)) {
            $employee_info = [];
        } else {
            $employee_info = $employee_info->get();
        }
        // dd($employee_info);
        return Template::loadView("admin.v1.hrm.increamentmanagement.due-increment-list-table", [
            'employee_info' => $employee_info
        ]);
    }

    public function employeeIncreamentStore(Request $request)
    {
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $entry_session = Session()->get('user.ses_user_pk_no');
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            if (!empty($request->person_no_fk)) {
                foreach ($request->person_no_fk as $key => $id) {
                    $sequence = DB::getSequence();
                    $data = [
                        'inctrans_no_pk'       =>  $sequence->nextValue('inctrans_no_pk_seq'),
                        'person_no_fk' => isset($request->person_no_fk) ? $request->person_no_fk[$key] : "",
                        'dept_su_no_fk' => isset($request->dept_su_no_fk) ? $request->dept_su_no_fk[$key] : "",
                        'inctrans_date' => isset($request->increment_date) ? $request->increment_date[$key] : "",
                        'last_increment_date' => isset($request->last_increment_date) ? $request->last_increment_date[$key] : "",
                        'last_increment_percent' => isset($request->estimated_inc) ? $request->estimated_inc[$key] : "",
                        'last_increment_amt' => isset($request->last_increment_amt) ? $request->last_increment_amt[$key] : "",
                        'current_salary' => isset($request->current_salary) ? $request->current_salary[$key] : "",
                        'proposed_increment_percent' => isset($request->proposed_increment_percent) ? $request->proposed_increment_percent[$key] : "",
                        'proposed_increment_amt' => isset($request->proposed_increment_amt) ? $request->proposed_increment_amt[$key] : "",
                        'au_entry_by' => isset($auth_id) ? $auth_id : "",
                        'au_entry_at' => $au_entry_at,
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $ses_hospital_id
                    ];

                    DB::table('HRMS_INCREMENT_TRANS')->insert($data);
                }
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function increamentProcessingWorklist(Request $request)
    {

        $service_unit = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $employee_info = DB::table('hrms_emp_increment_worklist_vw')->orderby("au_entry_at", "desc")->get();
        return Template::loadView("admin.v1.hrm.increamentmanagement.increment-processing-work-list", [
            'employee_info' => $employee_info,
            'service_unit' => $service_unit,
        ]);
    }

    public function removeEmployeeIncreamentProcessing(Request $request)
    {
        // dd("pppp");
        DB::table('hrms_increment_trans')->where('inctrans_no_pk', $request->inctrans_no_pk)->delete();
        $employee_info = DB::table('hrms_emp_increment_worklist_vw')
            ->when(isset($request->department), function ($query) use ($request) {
                $query->where('serviceunit_no_fk', $request->su_id);
            })->orderby("au_entry_at", "desc")->get();
        return Template::loadView("admin.v1.hrm.increamentmanagement.increment-processing-list-table", [
            'employee_info' => $employee_info
        ]);
    }

    public function searchEmployeeIncreamentProcessing(Request $request)
    {
        $employee_info = DB::table('hrms_emp_increment_worklist_vw');
        if (isset($request->date_from) && isset($request->date_to)) {
            $employee_info->where(DB::raw('trunc(au_entry_at)'), '>=', date('Y-m-d', strtotime($request->date_from)));
            $employee_info->where(DB::raw('trunc(au_entry_at)'), '<=', date('Y-m-d', strtotime($request->date_to)));
        }
        if (isset($request->department)) {
            $employee_info->where('serviceunit_no_fk', $request->department);
        }
        if (!isset($request->date_from) && !isset($request->date_to) && !isset($request->department)) {
            $employee_info = [];
        } else {
            $employee_info = $employee_info->orderby("au_entry_at", "desc")->get();
        }
        return Template::loadView("admin.v1.hrm.increamentmanagement.increment-processing-list-table", [
            'employee_info' => $employee_info
        ]);
    }
    public function awardLetterPrint($inctrans_no_pk)
    {
        $empIncApproveInfo = DB::table("hrms_emp_increment_worklist_vw")->where('inctrans_no_pk', $inctrans_no_pk)->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.v1.hrm.increamentmanagement.award-letter-pdf", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'empIncApproveInfo' => $empIncApproveInfo,
        ]);
        return $pdf->stream("AWARD_LETTER.pdf", array("Attachment" => false));
    }

    public function increamentApprove($inctrans_no_pk)
    {
        // dd($inctrans_no_pk);
        $increamentInfo = DB::table('hrms_increment_trans')->where('inctrans_no_pk', $inctrans_no_pk)->first();
        return Template::loadview("admin.v1.hrm.increamentmanagement.increament-approve", [
            'increamentInfo' => $increamentInfo,
        ]);
    }
    public function employeeIncreamentApproveStore(Request $request)
    {
        $au_update_at = Carbon::now();
        $au_update_at = $au_update_at->toDateString();
        $entry_session = Session()->get('user.ses_user_pk_no');
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd(date('d/m/Y', strtotime($request->effective_date)));
        DB::beginTransaction();
        try {

            $data = [
                'proposed_increment_amt'       =>  isset($request->inc_amt) ? $request->inc_amt : "",
                'proposed_increment_percent' => isset($request->inc_percentage) ? $request->inc_percentage : "",
                'final_approval_remarks' => isset($request->remarks) ? $request->remarks : "",
                'final_approval_ind' => 1,
                'date_of_effective' => isset($request->effective_date) ? date('Y-m-d', strtotime($request->effective_date)) : "",
                'increment_salary' => isset($request->inc_salary) ? $request->inc_salary : "",
                'au_update_by' => isset($auth_id) ? $auth_id : "",
                'au_update_at' => $au_update_at,
            ];

            DB::table('hrms_increment_trans')->where('inctrans_no_pk', $request->inctrans_no_pk)->update($data);
            DB::commit();
            $message = ['msg' => 'Increament Approved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
}
