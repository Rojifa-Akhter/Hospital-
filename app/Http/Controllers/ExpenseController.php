<?php

namespace App\Models;

namespace App\Http\Controllers;

use App;
use PDO;
use \PDF;
use Cache;
use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\ExpenseMemo;
use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadView('admin.uhl.expense_memo.create_expense_memo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $auth_id = Auth::id();
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            DB::beginTransaction();
            $sequence = DB::getSequence();
            $expense_no_pk_seq = $sequence->nextValue('expense_no_pk_seq');
            $data = [
                'memo_no'                   => $expense_no_pk_seq,
                'expense_name'              => $request->expense_name,
                'amount'                    => $request->amount,
                'charge_to'                 => $request->change_to,
                'status'                    => 1,
                'expense_date'              => $request->expense_date != "" ? date('Y-m-d', strtotime($request->expense_date)) : '',
                'expense_to'                => $request->expense_to
            ];

            if ($request->hdn_expense_no_pk == "") {
                $data['expense_no_pk']           = $expense_no_pk_seq;
                $data['au_entry_by']             = $auth_id;
                $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                DB::table('finc_expense')->insert($data);

                $ses_hospital_id  = Session::get('user.ses_hospital_no_pk');
                $au_entry_by      = auth::user()->user_no_pk;
                $au_entry_session = Session()->get('user.ses_user_pk_no');
                $code = 'IOUEX';
                $pdo = DB::getPdo();
                $rem = '';
                $out_apprprocess_no_pk = $out_apprprocess_uid = $expense_no_pk = $out_error = '';

                $expense = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
                    :in_approval_for_code,
                    :in_primary_key_value,
                    :in_primary_key_uid,
                    :in_remarks,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_apprprocess_no_pk,
                    :out_apprprocess_uid,
                    :out_error
                ); end;");

                $expense->bindParam(':in_approval_for_code', $code);
                $expense->bindParam(':in_primary_key_value', $expense_no_pk_seq);
                $expense->bindParam(':in_primary_key_uid', $expense_no_pk_seq);
                $expense->bindParam(':in_remarks', $rem);
                $expense->bindParam(':in_au_entry_by', $au_entry_by);
                $expense->bindParam(':in_au_entry_session', $au_entry_session);
                $expense->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
                $expense->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
                $expense->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 100000);
                $expense->bindParam(':out_error', $out_error, PDO::PARAM_STR, 100000);
                $expense->execute();
            } else {
                $data['au_update_by']             = $auth_id;
                // $data['au_update_at']             = date('Y-m-d');
                $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                $id = $request->hdn_expense_no_pk;
                // ExpenseMemo::where('expense_no_pk', $id)->update($data);
                DB::table('finc_expense')->where('expense_no_pk', $id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function ExpenseMemoWorklist(Request $request)
    {
        $auth_id = Auth::id();
        $data = DB::table('finc_expense')
            ->select('finc_expense.*', 'finc_expense_vw.bill_app_level_status_text', 'finc_expense_vw.bill_app_status')
            ->leftJoin('finc_expense_vw', 'finc_expense.expense_no_pk', 'finc_expense_vw.expense_no_pk')
            ->where('finc_expense.au_entry_by', $auth_id)
            ->get();
        return Template::loadView('admin.uhl.expense_memo.expense_memo_worklist', ['data' => $data]);
    }

    public function ExpenseMemoWorklistSearch(Request $request){
        $auth_id = Auth::id();
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $data = DB::table('finc_expense')
                ->select('finc_expense.*', 'finc_expense_vw.bill_app_level_status_text', 'finc_expense_vw.bill_app_status')
                ->leftJoin('finc_expense_vw', 'finc_expense.expense_no_pk', 'finc_expense_vw.expense_no_pk')
                ->where(DB::raw('trunc(finc_expense.expense_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                ->where(DB::raw('trunc(finc_expense.expense_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                ->where('finc_expense.au_entry_by', $auth_id)
                ->get(); 
        }
        return Template::loadView('admin.uhl.expense_memo.expense_memo_worklist_search_table', ['data' => $data]);
    }


    public function ApprovalTrackingforExpense($id = "")
    {
        $approval_matrix_id = $id;
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
            ->where("approval_for_code", "IOUEX")
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.v1.hrm.employee_portal.approval-tracking-leave-application", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }

    public function ExpenseMemoUpdate($id = "")
    {
        $data = DB::table('finc_expense')->select('finc_expense.*')
            ->where('expense_no_pk', $id)
            ->first();
        return Template::loadView('admin.uhl.expense_memo.create_expense_memo', ['data' => $data]);
    }

    public function ExpenseMemoReport($id = "")
    {
        $expense_data = DB::table('finc_expense as a')
        ->select('a.*', 'hrms_personnel.doctor_signature_image')
        ->leftJoin('wsec_user', 'a.au_entry_by', '=', 'wsec_user.user_no_pk')
        ->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'wsec_user.person_no_fk')
        ->where('a.expense_no_pk', $id)
        ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $signature_data = DB::table('sysc_approvalprocess_vw')
        //     // ->distinct('ent.person_no_fk')
        //     ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'ent_desig.designation as ent_designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.user_fullname_ent', DB::raw('trunc(sysc_approvalprocess_vw.approved_at) as approved_at'), 'sysc_approvalprocess_vw.person_no_fk')
        //     ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
        //     ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
        //     ->leftJoin('wsec_user ent', 'ent.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk_ent')
        //     ->leftJoin('employee_info_vw ent_desig', 'ent_desig.person_no_pk', 'ent.person_no_fk')
        //     ->where('sysc_approvalprocess_vw.primary_key_value', $id)
        //     ->where('sysc_approvalprocess_vw.approval_for_code', 'IOUEX')
        //     ->orderBy('sysc_approvalprocess_vw.own_level', 'asc')
        //     ->get()->toArray();
        //     $uni = array_unique($signature_data);
        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select(
                'sysc_approvalprocess_vw.user_fullname',
                'sysc_approvalprocess_vw.level_status_text',
                'employee_info_vw.designation',
                'ent_desig.designation as ent_designation',
                'employee_info_vw.doctor_signature_image',
                'sysc_approvalprocess_vw.user_fullname_ent',
                DB::raw('trunc(sysc_approvalprocess_vw.approved_at) as approved_at'),
                'sysc_approvalprocess_vw.person_no_fk')

            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->leftJoin('wsec_user as ent', 'ent.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk_ent')
            ->leftJoin('employee_info_vw as ent_desig', 'ent_desig.person_no_pk', 'ent.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'IOUEX')
            ->orderBy('sysc_approvalprocess_vw.own_level', 'asc')
            ->get()
            ->toArray();
        $unique_data = collect($signature_data)->unique('person_no_fk')->values()->all();

        $pdf = PDF::loadView("admin.uhl.expense_memo.expense_memo_report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "expense_data" => $expense_data, "signature_data" => $signature_data])->setPaper('a4', 'portrait');
        return $pdf->stream('Expense-Memo.pdf');
    }



    public function ExpenseMemoWorklistFinance(Request $request)
    {
        $emp_list = DB::table('finc_expense_vw')->select('person_code','emp_name')->distinct()->get();
        return Template::loadView('admin.uhl.expense_memo.expense_memo_worklist_finance', ['emp_list' => $emp_list]);
    }

    public function PaymentUpdate(Request $request)
    {
        $expense_no    = $request->expense_no;
        $settelmentInd = $request->settelmentInd;
        if ($settelmentInd == 'settalement') {
            DB::table('finc_expense')->where('expense_no_pk', $expense_no)->update(['sattle_ind' => 1]);
        }else{
            DB::table('finc_expense')->where('expense_no_pk', $expense_no)->update(['payment_ind' => 1]);
        }
        
        $response = [
            'title'   => 'Payment Update Success',
            'success' => true,
            'message' => 'Payment for expense ' . $expense_no . ' has been successfully updated.',
        ];
        return response()->json($response, 200);
    }

    // public function searchExpenseWorklist(Request $request)
    // {
    //     $from_date    = $request->from_date;
    //     $to_date      = $request->to_date;
    //     $paid_ind     = $request->paid_ind;
    //     $settele_ind  = $request->settele_ind;

    //     $query = DB::table('finc_expense_vw')->select('finc_expense_vw.*');
    //     if (!empty($from_date) && !empty($to_date)) {
    //         $query->where(DB::raw('trunc(expense_date)'), '>=', date('Y-m-d', strtotime($from_date)))
    //             ->where(DB::raw('trunc(expense_date)'), '<=', date('Y-m-d', strtotime($to_date)))
    //             ->where('finc_expense_vw.bill_app_level_status_text', '2/2');
    //     }

    //     if ($paid_ind === '1') {
    //         $query->whereNotNull('payment_ind');
    //     } elseif ($paid_ind === '0') {
    //         $query->whereNull('payment_ind');
    //     }
    //     if ($settele_ind === '1') {
    //         $query->whereNotNull('sattle_ind');
    //     } elseif ($settele_ind === '0') {
    //         $query->whereNull('sattle_ind');
    //     }
    //     if ($settele_ind !== null && $paid_ind != null) {
    //         $query->whereNotNull('sattle_ind');
    //         $query->whereNotNull('payment_ind');
            
    //     }
    //     $query->orderBy('finc_expense_vw.expense_date', 'desc');
    //     $data = $query->get();
    //     return response()->json(['data' => $data], 200);
    // }

       public function searchExpenseWorklist(Request $request)
        {
            $from_date    = $request->from_date;
            $to_date      = $request->to_date;
            $paid_ind     = $request->paid_ind;
            $settele_ind  = $request->settele_ind;
            $emp_name     = $request->emp_name;
            
            $query = DB::table('finc_expense_vw')->select('finc_expense_vw.*');
            $query->where('finc_expense_vw.bill_app_level_status_text', '2/2');

            if (!empty($from_date) && !empty($to_date)) {
                $query->where(DB::raw('trunc(expense_date)'), '>=', date('Y-m-d', strtotime($from_date)))
                    ->where(DB::raw('trunc(expense_date)'), '<=', date('Y-m-d', strtotime($to_date)));
                    // ->where('finc_expense_vw.bill_app_level_status_text', '2/2');
            }

            if ($paid_ind !== null) {
                if ($paid_ind === '1') {
                    $query->whereNotNull('payment_ind');
                } elseif ($paid_ind === '0') {
                    $query->whereNull('payment_ind');
                }
            }
            
            if ($settele_ind !== null) {
                if ($settele_ind === '1') {
                    $query->whereNotNull('sattle_ind'); 
                } elseif ($settele_ind === '0') {
                    $query->whereNull('sattle_ind'); 
                }
            }
       
            if (!empty($emp_name)) {
                $query->where('finc_expense_vw.person_code', $emp_name);
            }
            
            // if ($settele_ind !== null || $paid_ind !== null || !empty($emp_name)) {
            //     if ($settele_ind === '1' && $paid_ind === '1') {
            //         $query->whereNotNull('sattle_ind')
            //               ->whereNotNull('payment_ind');
            //     } elseif ($settele_ind === '0' && $paid_ind === '0') {
            //         $query->whereNull('sattle_ind')
            //               ->whereNull('payment_ind');
            //     } elseif ($settele_ind === '1' && $paid_ind === '0') {
            //         $query->whereNotNull('sattle_ind')
            //               ->whereNull('payment_ind');
            //     } elseif ($settele_ind === '0' && $paid_ind === '1') {
            //         $query->whereNull('sattle_ind')
            //               ->whereNotNull('payment_ind');
            //     }
            //     $query->where('finc_expense_vw.person_code', $emp_name); 
            // }

            $query->orderBy('finc_expense_vw.expense_date', 'desc');
            $data = $query->get();
            return response()->json(['data' => $data], 200);
        }


    public function ExpenseWorklistFinancePrint(Request $request)
    {
        $isPaid       = $request->paid_ind;
        $from_date    = $request->from_date;
        $to_date      = $request->to_date;
        $paid_ind     = $request->paid_ind;
        $settele_ind  = $request->settele_ind;
        $emp_name     = $request->emp_name;
        $query = DB::table('finc_expense_vw')->select('finc_expense_vw.*');

        if (!empty($from_date) && !empty($to_date)) {
            $query->where(DB::raw('trunc(expense_date)'), '>=', date('Y-m-d', strtotime($from_date)))
                ->where(DB::raw('trunc(expense_date)'), '<=', date('Y-m-d', strtotime($to_date)));
        }

        // if ($paid_ind === '1') {
        //     $query->where('payment_ind', 1);
        // } elseif ($paid_ind === '0') {
        //     $query->where('payment_ind', null)->orWhereNull('payment_ind');
        // }

        if ($paid_ind !== null) {
            if ($paid_ind === '1') {
                $query->whereNotNull('payment_ind');
            } elseif ($paid_ind === '0') {
                $query->whereNull('payment_ind');
            }
        }

        if ($settele_ind !== null) {
            if ($settele_ind === '1') {
                $query->whereNotNull('sattle_ind'); 
            } elseif ($settele_ind === '0') {
                $query->whereNull('sattle_ind'); 
            }
        }
        if (!empty($emp_name)) {
            $query->where('finc_expense_vw.person_code', $emp_name);
        }

        // if ($settele_ind !== null && $paid_ind !== null) {
        //     if ($settele_ind === '1' && $paid_ind === '1') {
        //         $query->whereNotNull('sattle_ind')
        //               ->whereNotNull('payment_ind');
        //     } elseif ($settele_ind === '0' && $paid_ind === '0') {
        //         $query->whereNull('sattle_ind')
        //               ->whereNull('payment_ind');
        //     } elseif ($settele_ind === '1' && $paid_ind === '0') {
        //         $query->whereNotNull('sattle_ind')
        //               ->whereNull('payment_ind');
        //     } elseif ($settele_ind === '0' && $paid_ind === '1') {
        //         $query->whereNull('sattle_ind')
        //               ->whereNotNull('payment_ind');
        //     }
        // }

        $data = $query->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.uhl.expense_memo.expense_memo_worklist_finance_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "data" => $data, 'isPaid' => $isPaid, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->setPaper('a4', 'potrait');
        return $pdf->stream('conveyancebill.pdf');
    }

    public function ExpenseWorklistFinanceExcel(Request $request)
    {
        $isPaid       = $request->paid_ind;
        $from_date    = $request->from_date;
        $to_date      = $request->to_date;
        $paid_ind     = $request->paid_ind;
        $settele_ind  = $request->settele_ind;
        $emp_name     = $request->emp_name;
        $query = DB::table('finc_expense_vw')->select('finc_expense_vw.*');

        if (!empty($from_date) && !empty($to_date)) {
            $query->where(DB::raw('trunc(expense_date)'), '>=', date('Y-m-d', strtotime($from_date)))
                ->where(DB::raw('trunc(expense_date)'), '<=', date('Y-m-d', strtotime($to_date)));
        }

        // if ($paid_ind === '1') {
        //     $query->where('payment_ind', 1);
        // } elseif ($paid_ind === '0') {
        //     $query->where('payment_ind', null)->orWhereNull('payment_ind');
        // }

        if ($paid_ind !== null) {
            if ($paid_ind === '1') {
                $query->whereNotNull('payment_ind');
            } elseif ($paid_ind === '0') {
                $query->whereNull('payment_ind');
            }
        }

        if ($settele_ind !== null) {
            if ($settele_ind === '1') {
                $query->whereNotNull('sattle_ind'); 
            } elseif ($settele_ind === '0') {
                $query->whereNull('sattle_ind'); 
            }
        }
        if (!empty($emp_name)) {
            $query->where('finc_expense_vw.person_code', $emp_name);
        }

        // if ($settele_ind !== null && $paid_ind !== null) {
        //     if ($settele_ind === '1' && $paid_ind === '1') {
        //         $query->whereNotNull('sattle_ind')
        //               ->whereNotNull('payment_ind');
        //     } elseif ($settele_ind === '0' && $paid_ind === '0') {
        //         $query->whereNull('sattle_ind')
        //               ->whereNull('payment_ind');
        //     } elseif ($settele_ind === '1' && $paid_ind === '0') {
        //         $query->whereNotNull('sattle_ind')
        //               ->whereNull('payment_ind');
        //     } elseif ($settele_ind === '0' && $paid_ind === '1') {
        //         $query->whereNull('sattle_ind')
        //               ->whereNotNull('payment_ind');
        //     }
        // }

        $data = $query->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data, 'isPaid' => $isPaid, 'from_date' => $from_date, 'to_date' => $to_date];
        $fileToExport = "Expense-Memo";
        $html = view("admin.uhl.expense_memo.expense_memo_worklist_finance_excel", $pdf)->render();
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        echo $html;
        exit;
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
