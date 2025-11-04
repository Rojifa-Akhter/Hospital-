<?php

namespace App\Http\Controllers;
use Session;


use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AcctAccountType;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\AcctChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Core\Accounts\Supplier\Supplier;
use App\Core\Accounts\PatientInfo\Patient;
use GuzzleHttp\Psr7\Request as Psr7Request;
use App\Core\Accounts\EmployeeInfo\Employee;
use App\Core\Accounts\AccountType\AccountType;
use App\Core\Accounts\VoucherType\VoucherType;
use App\Core\Accounts\AccountSetup\AccountSetup;
use App\Core\Accounts\VoucherEntry\VoucherEntry;
use App\Core\Accounts\AccountsBalance\AccountsBalance;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use App\Core\Accounts\CashFlowCategory\CashFlowCategory;

class AccountsController extends Controller
{
    use LookupData;
    /**
     * Root account service
     *
     * @var [@App\Core\Accounts\AccountType\AccountType]
     */
    protected $account_type;

    /**
     * Root account service
     *
     * @var [@App\Core\Accounts\AccountSetup\AccountSetup]
     */
    protected $account_setup;

    /**
     * Chart of account service
     *
     * @var [@App\Core\Accounts\ChartOfAccounts\ChartOfAccounts]
     */
    protected $chart_of_acc;


    /**
     * Cash flow category service
     *
     * @var [@App\Core\Accounts\CashFlowCategory\CashFlowCategory]
     */
    protected $cashflow_category;


    /**
     * Voucher type service
     *
     * @var [App\Core\Accounts\VoucherType]
     */
    protected $voucher_type;


    /**
     * Voucher entry service
     *
     * @var [@App\Core\Accounts\VoucherEntry\VoucherEntry]
     */
    protected $voucher_entry;

    /**
     * Account head balance
     *
     * @var [@App\Core\Accounts\AccountsBalance\AccountsBalance]
     */


    protected $account_balance;

    /**
      * Employee information
      *
      * @var [@App\Core\Accounts\EmployeeInfo\Employee]
      */

    protected $employee;

    /**
      * Supplier information
      *
      * @var [@App\Core\Accounts\Supplier\Supplier]
      */

      protected $patient;

      /**
      * Patient information
      *
      * @var [@App\Core\Accounts\Patient\Patient]
      */

      protected $supplier;

    public function __construct(
        AccountType $account_type,
        AccountSetup  $account_setup,
        CashFlowCategory $cashflow_category,
        ChartOfAccounts $chart_of_acc,
        VoucherType $voucher_type,
        VoucherEntry $voucher_entry,
        AccountsBalance $account_balance,
        Employee $employee,
        Supplier $supplier,
        Patient $patient
    )
    {
        $this->account_type = $account_type;
        $this->account_setup = $account_setup;
        $this->cashflow_category = $cashflow_category;
        $this->chart_of_acc = $chart_of_acc;
        $this->voucher_type = $voucher_type;
        $this->voucher_entry = $voucher_entry;
        $this->account_balance = $account_balance;
        $this->employee =$employee;
        $this->supplier = $supplier;
        $this->patient = $patient;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
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

    public function accountsVoucherEntry()
    {

        $voucher_type = $this->voucher_type->get_voucher_type();
        $cost_center = $this->voucher_type->get_cost_center();

        return template::loadview('admin.accounts.transaction.voucher_entry',compact('voucher_type','cost_center'));
    }

    public function get_employee(Request $request)
    {
        return $employee = $this->employee->get_employee($request->search);
    }

    public function get_supplier(Request $request)
    {
        return $supplier = $this->supplier->get_supplier($request->search);
    }

    public function get_patient(Request $request)
    {
        return $employee = $this->patient->get_patient($request->search);
    }


    public function get_account_balance(Request $request)
    {

        return $this->account_balance->get_accounts_balance($request->acc_code);
    }

    public function autocompelete_transection_head()
    {
        $posting_heads = $this->chart_of_acc->transection_accounts_head();

        $postinghead_autocom = [];

        foreach($posting_heads->getData()->data as $postinghead) {
            array_push($postinghead_autocom,$postinghead->account_code."-".$postinghead->account_name."             (".strtolower($postinghead->pr_account_name)." /      ".strtolower($postinghead->root_account_name).")");
        }

        return response()->json(['success' => true, 'data' => $postinghead_autocom], 200);
    }

    public function accountsVoucherInfo()
    {
        $voucher_type = $this->voucher_type->get_voucher_type();

        return template::loadview('admin.accounts.transaction.voucher_info',compact('voucher_type'));
    }

    public function show_voucher_info(Request $request)
    {
        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$request->date_from."' and '".$request->date_to."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$request->cheque_date."'": "";

        $voucher_info = $this->voucher_entry->voucher_info($sql_cond);

        return view('admin.accounts.verification.show_voucher_info',compact('voucher_info'));

    }

    public function edit_voucher(Request $request)
    {
        $voucher_info = $this->voucher_entry->edit_voucher($request->voucher_no);

        if ($voucher_info->getData()->success == true) {

            return $voucher_info;

        }

        return $voucher_info;

    }

    public function accountsVoucherFinalize()
    {
        $voucher_type = $this->voucher_type->get_voucher_type();

        return template::loadview('admin.accounts.transaction.voucher_finalize',compact('voucher_type'));
    }

    public function show_voucher_finalize(Request $request)
    {
        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$request->date_from."' and '".$request->date_to."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$request->cheque_date."'": "";

        $voucher_info = $this->voucher_entry->voucher_info($sql_cond);

        return view('admin.accounts.verification.show_voucher_finalize',compact('voucher_info'));

    }

    public function arProcessing()
    {
        return template::loadview('admin.accounts.transaction.ar_processing');
    }

    public function voucherVerify()
    {
        return template::loadview('admin.accounts.verification.voucher_verify');
    }

    public function accountsSetup()
    {
        $cashflow_category = $this->cashflow_category->getCashFlowCategories();

        $last_account_code = $this->chart_of_acc->get_last_account_codeno();

        $chartof_accounts = $this->chart_of_acc->get_chart_of_account();

        $chartof_accounts = $chartof_accounts->getData()->data;

        $root_accounts = $this->chart_of_acc->get_root_account();

        $root_accounts = $root_accounts->getData()->data;

        $voucher_type = $this->voucher_type->get_voucher_type();

        return template::loadview('admin.accounts.settings.accounts_setup',compact('cashflow_category','last_account_code','root_accounts','chartof_accounts','voucher_type'));
    }

    public function set_voucher_type_status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $status = $this->voucher_type->set_voucher_type_status($status,$id);
        return response()->json(['success' => true, 'data' => $status->getData()->data], 200);

    }

    public function request_get_accounts_level($acc_id)
    {
        try {
            $accounts_level = $this->chart_of_acc->request_get_accounts_level($acc_id);
            return response()->json(['success' => true, 'data' => $accounts_level->getData()->data],200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);


        }
    }

    public function ajax_account_level(Request $request)
    {
        $chartof_accounts = $this->chart_of_acc->get_root_child_accounts($request->account_level_acct_type);

        $chartof_accounts = $chartof_accounts->getData()->data;

        return template::loadview('admin.accounts.settings.ajax_account_level','chartof_accounts');
    }

    public function last_account_code()
    {
        $last_account_code = $this->chart_of_acc->get_last_account_codeno();
        try{

            return response()->json(['success' => true, 'data' => $last_account_code], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }

    }

    public function treeView()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $Categorys = AcctChartOfAccount::with('childs')->where('au_entry_hospital_pk_no',$ses_hospital_id)->where('account_no_fk_root_0', '=', 0)->orderBy('account_no_pk','asc')->orderBy('account_no_sl','asc')->get();

        $tree='<ul id="browser" class="filetree"><li class="tree-view"><strong>CHART OF ACCOUNTS</strong></li>';
        foreach ($Categorys as $Category) {
             $tree .='<li class="tree-view closed"<a class="tree-name">'.$Category->account_name.' <span title="Add Account Head Group"
             class="btn btn-info btn-sm"
             style="margin-top: -3px; margin-right: 5px;"><i
                 class="fa fa-plus root_child" data-root_name="'.$Category->account_name.'" data-step="root" data-cashflow_ind="'.$Category->cashflow_ind.'" data-income_exp_ind="'.$Category->income_exp_ind.'" data-root_id="'.$Category->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root"></i></span></a>';
             if(count($Category->childs)) {
                $tree .=$this->childView($Category);
            }
        }
        $tree .='<ul>';

        return template::loadview('admin.accounts.settings.chart_of_account_tree',compact('tree'));
    }

    public function childView($Category)
    {
            $html ='<ul>';
            foreach ($Category->childs as $arr) {
                if(count($arr->childs)){
                $html .='<li class="tree-view closed"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-eye"></i></span> &nbsp;
            <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-cashflow_ind="'.$arr->cashflow_ind.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span> &nbsp;
            <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-plus subroot_first_child" data-root_name="'.$arr->account_name.'" data-step="subroot_first" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-root_id="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_subroot_first"></i></span></a>';
                        $html.= $this->childView($arr);
                    }else{
                        if ($arr->posting_head_ind == 0) {
                            $html .='<li class="tree-view"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-eye"></i></span> &nbsp;
                            <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span> &nbsp;
                            <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-plus subroot_child"  data-root_name="'.$arr->account_name.'" data-step="subroot" data-cashflow_ind="'.$arr->cashflow_ind.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-root_id="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_subroot"></i></span></a>';
                                        $html .="</li>";
                        } else {
                            $html .='<li class="tree-view"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                                    class="btn btn-info btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-eye"></i></span>
                                &nbsp;
                                <span title="Add Account Head Group"
                                    class="btn btn-info btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span>
                                &nbsp;
                                <span title="Add Account Head Group"
                                    class="btn btn-danger btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-trash"></i></span></a>';
                                    $html .="</li>";
                        }

                    }

            }

            $html .="</ul>";
            return $html;
    }

    public function get_chart_of_account_by_id(Request $request)
    {
        $get_charof_account_by_id = $this->chart_of_acc->get_chart_of_account_by_id($request->account_no_pk);

        if ($get_charof_account_by_id->getData()->success == true) {
            return response()->json(['success' => true, 'data' => $get_charof_account_by_id->getData()->data], 200);
        }

        return response()->json(['success' => false, 'message' => 'Invalid Account Code'], 200);

    }


    public function moduleSetup()
    {
        return template::loadview('admin.accounts.settings.module_setup');
    }

    public function stockItemSetup()
    {
        return template::loadview('admin.accounts.settings.stock_item_setup');
    }

    public function fiscalYear()
    {
        return template::loadview('admin.accounts.settings.fiscal_year');
    }

    public function defaultAccHeadMapping()
    {
        return template::loadview('admin.accounts.settings.default_acc_head_mapping');
    }

    public function get_accounts_level()
    {
        try {
            $accounts_level = $this->chart_of_acc->get_accounts_level();
            return response()->json(['success' => true, 'data' => $accounts_level->getData()->data],200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);


        }
    }
    // Accounts V1 Methods

    public function accountsSetupV1()
    {
        $cashflow_category = $this->cashflow_category->getCashFlowCategories();

        $last_account_code = $this->chart_of_acc->get_last_account_codeno();

        $chartof_accounts = $this->chart_of_acc->get_chart_of_account();

        $chartof_accounts = $chartof_accounts->getData()->data;

        $root_accounts = $this->chart_of_acc->get_root_account();

        $root_accounts = $root_accounts->getData()->data;

        $voucher_type = $this->voucher_type->get_voucher_type();

        return template::loadview('admin.accounts.v1.settings.accounts_setup_v1',compact('cashflow_category','last_account_code','root_accounts','chartof_accounts','voucher_type'));
    }

    public function get_accounts_levelV1()
    {
        try {
            $accounts_level = $this->chart_of_acc->get_accounts_levelV1();
            return response()->json(['success' => true, 'data' => $accounts_level->getData()->data],200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);
        }
    }

    public function treeViewV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $Categorys = AcctChartOfAccount::with('childs')->where('au_entry_hospital_pk_no',$ses_hospital_id)->where('account_no_fk_root_0', '=', 0)->orderBy('account_no_pk','asc')->orderBy('account_no_sl','asc')->get();

        $tree='<ul id="browser" class="filetree"><li class="tree-view"><strong>CHART OF ACCOUNTS</strong></li>';
        foreach ($Categorys as $Category) {
             $tree .='<li class="tree-view closed"<a class="tree-name">'.$Category->account_name.' <span title="Add Account Head Group"
             class="btn btn-info btn-sm"
             style="margin-top: -3px; margin-right: 5px;"><i
                 class="fa fa-plus root_child" data-root_name="'.$Category->account_name.'" data-step="root" data-cashflow_ind="'.$Category->cashflow_ind.'" data-income_exp_ind="'.$Category->income_exp_ind.'" data-root_id="'.$Category->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root"></i></span></a>';
             if(count($Category->childs)) {
                $tree .=$this->childViewV1($Category);
            }
        }
        $tree .='<ul>';

        return template::loadview('admin.accounts.v1.settings.chart_of_account_tree',compact('tree'));
    }

    public function childViewV1($Category)
    {
            $html ='<ul>';
            foreach ($Category->childs as $arr) {
                if(count($arr->childs)){
                $html .='<li class="tree-view closed"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-eye"></i></span> &nbsp;
            <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-cashflow_ind="'.$arr->cashflow_ind.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span> &nbsp;
            <span title="Add Account Head Group"
                class="btn btn-info btn-sm"
                style="margin-top: -3px; margin-right: 5px;"><i
                    class="fa fa-plus subroot_first_child" data-root_name="'.$arr->account_name.'" data-step="subroot_first" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-root_id="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_subroot_first"></i></span></a>';
                        $html.= $this->childView($arr);
                    }else{
                        if ($arr->posting_head_ind == 0) {
                            $html .='<li class="tree-view"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-eye"></i></span> &nbsp;
                            <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span> &nbsp;
                            <span title="Add Account Head Group"
                                class="btn btn-info btn-sm"
                                style="margin-top: -3px; margin-right: 5px;"><i
                                    class="fa fa-plus subroot_child"  data-root_name="'.$arr->account_name.'" data-step="subroot" data-cashflow_ind="'.$arr->cashflow_ind.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-root_id="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_subroot"></i></span></a>';
                                        $html .="</li>";
                        } else {
                            $html .='<li class="tree-view"><a class="tree-name">'.$arr->account_name.' <span title="Add Account Head Group"
                                    class="btn btn-info btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-eye"></i></span>
                                &nbsp;
                                <span title="Add Account Head Group"
                                    class="btn btn-info btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-edit root_first_edit" data-account_no_sl="'.$arr->account_no_sl.'" data-income_exp_type="'.$arr->income_exp_type.'" data-ledger_group_name="'.$arr->ledger_group_name.'" data-account_name="'.$arr->account_name.'" data-posting_head_ind="'.$arr->posting_head_ind.'" data-account_code="'.$arr->account_code.'" data-status="'.$arr->status.'" data-step="root_first_edit" data-cashflow_ind="'.$arr->cashflow_ind.'" data-cashflow_category_no_fk="'.$arr->cashflow_category_no_fk.'" data-income_exp_ind="'.$arr->income_exp_ind.'" data-account_no_pk="'.$arr->account_no_pk.'" data-toggle="modal" data-target="#add_acct_account_head_root_edit"></i></span>
                                &nbsp;
                                <span title="Add Account Head Group"
                                    class="btn btn-danger btn-sm"
                                    style="margin-top: -3px; margin-right: 5px;"><i
                                        class="fa fa-trash"></i></span></a>';
                                    $html .="</li>";
                        }

                    }

            }

            $html .="</ul>";
            return $html;
    }

    public function get_accounts_typeV1(){
        return $this->chart_of_acc->get_account_type();
    }


    public function editAccountsLevelV1($acc_pk)
    {
        $data = DB::table('acct_chart_of_accounts')->where('account_no_pk', $acc_pk)->first();
        $get_account_description = $this->account_setup->get_accounts_description_v1();
        // dd($data);
        if($data == ''){
            return view("admin.components.error_alert");
        }
        return template::loadview('admin.accounts.v1.settings.edit_accounts_level_v1',compact('data','get_account_description'));
    }

    public function updateAccountsLevelV1(Request $request){

        $request->validate([
            'accName' => 'required|max:200',
            'accDescription' => 'required',

        ]);

        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                "account_name" => $request->accName,
                "control_acc_ind" => $request->controlAccount,
                "cost_center_ind" => $request->costCenter,
                "bank_ind"        => $request->bank,
                "recurring_cost_ind" => $request->recurringCost,
                "default_dr_cr" => $request->default_dr_cr,
                "depreciation_ind" => $request->depreciation,
                "status" => $request->status,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'acc_5typedescription_no_fk' => $request->accDescription,
            ];

            if($request->balanceSheetReport != '' && isset($request->balanceSheetReport)){

                $balance_ind  = substr($request->balanceSheetReport, -3);
                $balance_ind = $balance_ind == 'BAL' ? 'BALANCE' : $balance_ind;
                $balance_ind = $balance_ind == 'INC' ? 'INCOME' : $balance_ind;
                $balance_ind = $balance_ind == 'OWN' ? 'OWNERS' : $balance_ind;
                $data['mapped_report'] = $balance_ind;
                $data['report_header'] = substr($request->balanceSheetReport,0, -3);

                if($balance_ind == 'INCOME'){

                    if($data['report_header'] == 'Revenue' || $data['report_header'] == 'Other Income'){
                      $data['income_exp_type'] = 'INCOME' ;
                    }
                    else{
                      $data['income_exp_type'] = 'EXPENSES' ;
                    }

                  }

                if($data['report_header'] == 'Revenue'){
                    $data['bal_inc_tag'] = 'REVENUE';
                }
                else if($data['report_header'] == 'Other Income'){
                    $data['bal_inc_tag'] = 'OTHERINCOME';
                }
                else if($data['report_header'] == 'Cost Of Goods Sold'){
                    $data['bal_inc_tag'] = 'COSTGDSOLD';
                }
                else if($data['report_header'] == 'Operating Expenses'){
                    $data['bal_inc_tag'] = 'OPEXPENSE';
                }
                else if($data['report_header'] == 'Non-Operating Gain/Loses'){
                    $data['bal_inc_tag'] = 'NONOPGL';
                }
                else if($data['report_header'] == 'Interest Expense'){
                    $data['bal_inc_tag'] = 'INTEXPENSE';
                }
                else if($data['report_header'] == 'Tax Expense'){
                    $data['tag'] = 'TAXEXPENSE';
                }
                else if($data['report_header'] == 'Depreciation Expense'){
                    $data['bal_inc_tag'] = 'DEPEXPENSE';
                }
                else if($data['report_header'] == 'Preference Dividend'){
                    $data['bal_inc_tag'] = 'PREDIVIDEND';
                }

                else if($data['report_header'] == 'Current Assets'){
                    $data['bal_inc_tag'] = 'CURRASSET';
                }
                else if($data['report_header'] == 'Fixed & Long Term Assets'){
                    $data['bal_inc_tag'] = 'FIXEDASSET';
                }
                else if($data['report_header'] == 'Current Liabilities'){
                    $data['bal_inc_tag'] = 'CURRLIABILITIES';
                }
                else if($data['report_header'] == 'Long Term Liabilities'){
                    $data['bal_inc_tag'] = 'LONGLIABILITIES';
                }
                else if($data['report_header'] == 'Owners Equity'){
                    $data['bal_inc_tag'] = 'OWNERSEQUITY';
                }
            }
            if($request->cashFlow != '' && isset($request->cashFlow)){
                $data['cashflow_report_header'] = $request->cashFlow;
                $data['cash_flow_ind'] = 1;


                if($request->cashFlow == 'Cash at Begining of Year'){
                    $data['cash_flow_tag'] = 'BEGCASH';
                }
                else if($request->cashFlow == 'Cash Flows From Financial Activities'){
                $data['cash_flow_tag'] = 'FINACTCASH';
                }
                else if($request->cashFlow == 'Cash Flows From Investing Activities'){
                $data['cash_flow_tag'] = 'INVCASH';
                }
                else if($request->cashFlow == 'Cash Flows From Operating Activities'){
                $data['cash_flow_tag'] = 'OACASH';
                }
                else if($request->cashFlow == 'Current Assets'){
                $data['cash_flow_tag'] = 'CFCURRASSET';
                }
                else if($request->cashFlow == 'Current Liabilities'){
                $data['cash_flow_tag'] = 'CFCURRLIABILITIES';
                }
            }
            else{
              $data['cash_flow_ind'] = 0;
            }

            DB::table('acct_chart_of_accounts')->where('account_no_pk',$request->account_no_pk)->update($data);
            return response()->json([
                "title"   => 'Success',
                "success" => true,
                "message" => "Successfully Updated",
                "code" => 200
                ],200);

        } catch (\Throwable $th) {
            return response()->json([
                "title"   => 'Failed',
                "success" => false,
                "message" => $th->getMessage()
            ],422);
        }

    }

    public function accountsSubLedgerTypeV1() {

        $hospitalPk = session('user.ses_hospital_no_pk');

        $accounts = AcctChartOfAccount::query()
            ->select([
                'account_no_pk',
                'account_no_sl',
                'account_code',
                'account_name',
                'status',
            ])
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        return template::loadview('admin.accounts.v1.settings.sub_ledger_type_v1', compact('accounts'));
    }

    public function accountsGetSubLedgerTypeV1(){
        $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();

        if(count($sub_ledger_type->getData()->data) == 0){
            return response()->json(["success" => false, "data" => [] ],200);
        }

        return response()->json(["success" => false, "data" => $sub_ledger_type->getData()->data ],200);
    }

    public function saveSubLedgerType(Request $request){

        $request->validate([
            'sub_ledger_type_name' => 'required|max:50',
            'sub_ledger_type_code' => 'required|max:50',
            'notes'            => 'max:500'
        ]);

        $sub_ledger_type = $this->chart_of_acc->save_sub_ledger_type([
            'notes' => $request->notes,
            'status' => $request->status,
            'subledgertype_name' =>$request->sub_ledger_type_name,
            'subledgertype_code' =>$request->sub_ledger_type_code,
            'dr_account_no_fk' =>$request->debit_account,
            'cr_account_no_fk' =>$request->credit_account
        ]);

        return $sub_ledger_type;
    }

    public function editSubLedgerType($id) {

        $hospitalPk = session('user.ses_hospital_no_pk');

        $data = DB::table('acct_subledger_type')
            ->where('acct_subledger_typeno_pk', $id)
            ->select([
                'notes',
                'status',
                'subledgertype_name',
                'subledgertype_code',
                'acct_subledger_typeno_pk',
                'dr_account_no_fk',
                'cr_account_no_fk',
            ])
            ->first();


        $accounts = AcctChartOfAccount::query()
            ->select([
                'account_no_pk',
                'account_no_sl',
                'account_code',
                'account_name',
                'status',
            ])
            ->where('au_entry_hospital_pk_no', $hospitalPk)
            ->where('posting_head_ind', 1)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        return Template::loadView("admin.accounts.v1.settings.modal.edit_sub_ledger_type_name", ['data' => $data, 'accounts' => $accounts]);
    }

    public function updateSubLedgerType(Request $request){
        $request->validate([
            'sub_ledger_type_name' => 'required|max:50',
            'sub_ledger_type_code' => 'required|max:50',
            'notes'            => 'max:500'
        ]);

        $sub_ledger_type = $this->chart_of_acc->update_sub_ledger_type([
            'acct_subledger_typeno_pk' => $request->acct_subledger_typeno_pk,
            'notes' => $request->notes,
            'status' => $request->status,
            'subledgertype_name' =>$request->sub_ledger_type_name,
            'subledgertype_code' =>$request->sub_ledger_type_code,
            'dr_account_no_fk' =>$request->debit_account,
            'cr_account_no_fk' =>$request->credit_account
        ]);

        return $sub_ledger_type;
    }

    public function accountsSubLedgerNameV1(){
        $data = $this->chart_of_acc->get_sub_ledger_type();
        return template::loadview('admin.accounts.v1.settings.sub_ledger_name_v1',compact('data'));
    }

    public function accountsGetSubLedgerNameV1(Request $request){
        $con = null;
        if(isset($request->subledger_type)){
            if($request->subledger_type != null){
                $con = "acct_subledger_name.acct_subledger_typeno_fk = '$request->subledger_type'";
            }
        }
        $sub_ledger_name = $this->chart_of_acc->get_sub_ledger_name($con);

        if(count($sub_ledger_name->getData()->data) == 0){
            return response()->json(["success" => false, "data" => [] ],200);
        }

        return response()->json(["success" => false, "data" => $sub_ledger_name->getData()->data ],200);
    }

    public function saveSubLedgerName(Request $request){

        $request->validate([
            'sub_ledger_type' => 'required',
            'sub_ledger_name_code' => 'required|max:50',
            'sub_ledger_name' => 'required|max:50',
            'notes'            => 'max:500'
        ]);
        $sub_ledger_name = $this->chart_of_acc->save_sub_ledger_name([
                'notes' => $request->notes,
                'status' => $request->status,
                'sub_ledger_type' =>$request->sub_ledger_type,
                'sub_ledger_name' =>$request->sub_ledger_name,
                'sub_ledger_name_code' =>$request->sub_ledger_name_code,
                'tracking_id' =>$request->tracking_id
        ]);

        return $sub_ledger_name;
    }

    public function editSubLedgerName($id){
        $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();
        $data = DB::table('acct_subledger_name')
                    ->where('acct_subledger_no_pk',$id)
                    ->select('notes','status','subledger_name','subledger_code','acct_subledger_no_pk','acct_subledger_typeno_fk','sub_ledger_tracking_no')
                    ->first();
        return Template::loadView("admin.accounts.v1.settings.modal.edit_sub_ledger_name", ['data' => $data , 'sub_ledger_type' => $sub_ledger_type]);
    }

    public function updateSubLedgerName(Request $request){
        $request->validate([
            'sub_ledger_type' => 'required',
            'sub_ledger_name' => 'required|max:50',
            'sub_ledger_name_code' => 'required|max:50',
            'notes'            => 'max:500'
        ]);

        $sub_ledger_name = $this->chart_of_acc->update_sub_ledger_name([
            'acct_subledger_no_pk' => $request->acct_subledger_no_pk,
            'notes' => $request->notes,
            'status' => $request->status,
            'sub_ledger_type' =>$request->sub_ledger_type,
            'sub_ledger_name' =>$request->sub_ledger_name,
            'sub_ledger_name_code' =>$request->sub_ledger_name_code,
            'tracking_id' =>$request->tracking_id,
        ]);

        return $sub_ledger_name;
    }

    // public function accountsCheque()
    // {
    //     $bank_name = $this->getLookupListByCode("AGENTBANKING");

    //     return template::loadview('admin.accounts.v1.settings.cheque_setup', compact('bank_name'));
    // }


    //-- Medical Benefit Setup --//
    public function medicalBenefitSetup()
    {

        $medical_benefit_type = $this->getLookupListByCode("MEDICALBENEFITTYPE");
        return template::loadview('admin.accounts.v1.settings.medical_benefit_setup', [
            'medical_benefit_type' => $medical_benefit_type
        ]);
    }

    public function getMedicalBenefit()
    {
       $medical_benefits = DB::table('acct_medical_benefit_setup as mbs')
        ->leftJoin('WSEC_USER as u', 'u.user_no_pk', '=', 'mbs.au_entry_by')
        ->select(
            'mbs.medical_benefit_no_pk',
            'mbs.benefit_effective_at',
            'mbs.benefit_type_no',
            'mbs.benefit_type_name',
            'mbs.benefit_amount',
            'mbs.au_entry_by',
            'u.user_fullname as created_by_name',
            'mbs.au_entry_at',
            'mbs.status'
        )
        ->orderBy('mbs.au_entry_at', 'desc')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $medical_benefits
        ]);
    }

    public function saveMedicalBenefit(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $id = $request->medical_benefit_no_pk;

            $request->validate([
                'benefit_effective_at' => 'required|date',
                'benefit_type_no' => 'required|numeric',
                'benefit_type_name' => 'required|string|max:200',
                'benefit_amount' => 'required|numeric|min:0',
                'status' => 'required|in:1,2',
            ]);

            $hospitalNo = Session::get('user.ses_hospital_no_pk');

            $data = [
                'benefit_effective_at' => $request->benefit_effective_at,
                'benefit_type_no' => $request->benefit_type_no,
                'benefit_type_name' => $request->benefit_type_name,
                'benefit_amount' => $request->benefit_amount,
                'status' => $request->status,
            ];

            if (empty($id)) {
                // Generate new PK using sequence
                $sequence = DB::getSequence();
                $newPk = $sequence->nextValue('MEDICAL_BENEFIT_NO_PK_SEQ');

                $data['medical_benefit_no_pk'] = $newPk;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_at'] = now();
                $data['au_entry_session'] = 'entry session';
                $data['au_entry_hospital_no_fk'] = $hospitalNo;

                DB::table('ACCT_MEDICAL_BENEFIT_SETUP')->insert($data);
            } else {
                $data['au_update_by'] = Auth::id();
                $data['au_update_at'] = now();
                $data['au_update_session'] = 'update session';
                $data['au_update_hospital_no_fk'] = $hospitalNo;

                DB::table('ACCT_MEDICAL_BENEFIT_SETUP')
                    ->where('medical_benefit_no_pk', $id)
                    ->update($data);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medical Benefit setup saved successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function editMedicalBenefit($primaryKey)
    {
        $medicalBenefitTypes = $this->getLookupListByCode("MEDICALBENEFITTYPE");

        $data = DB::table('acct_medical_benefit_setup')
            ->where('medical_benefit_no_pk', $primaryKey)
            ->select(
                'medical_benefit_no_pk as medical_benefit_pk',
                'benefit_effective_at as benefit_effective_at',
                'benefit_type_no as benefit_type_no',
                'benefit_type_name as benefit_type_name',
                'benefit_amount as benefit_amount',
                'status as status'
            )
            ->first();
        // dd($data);

        return Template::loadView(
            'admin.accounts.v1.settings.modal.edit_medical_benefit_setup',
            compact('medicalBenefitTypes', 'data')
        );
    }


    public function updateMedicalBenefit(Request $request)
    {
        DB::beginTransaction();
        // dd($request->all());

        try {
            $request->validate([
                'medical_benefit_no_pk' => 'required|numeric',
                'benefit_effective_at' => 'required|date',
                'benefit_type_no' => 'required|numeric',
                'benefit_type_name' => 'required|string|max:200',
                'benefit_amount' => 'required|numeric|min:0',
                'status' => 'required|in:1,2',
            ]);

            $id = $request->medical_benefit_no_pk;
            $hospitalNo = Session::get('user.ses_hospital_no_pk');

            $data = [
                'benefit_effective_at' => $request->benefit_effective_at,
                'benefit_type_no' => $request->benefit_type_no,
                'benefit_type_name' => $request->benefit_type_name,
                'benefit_amount' => $request->benefit_amount,
                'status' => $request->status,
                'au_update_by' => Auth::id(),
                'au_update_at' => now(),
                'au_update_session' => 'update session',
                'au_update_hospital_no_fk' => $hospitalNo,
            ];

            DB::table('ACCT_MEDICAL_BENEFIT_SETUP')
                ->where('medical_benefit_no_pk', $id)
                ->update($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medical Benefit setup updated successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //-- End Medical Benefit Setup --//





    public function accountsCheque()
    {
        $bankAccounts = DB::table('ACCT_CHART_OF_ACCOUNTS')
                        ->select([
                            'ACCOUNT_NO_PK as account_pk',
                            'ACCOUNT_CODE as account_code',
                            'ACCOUNT_NAME as account_name'
                        ])
                        ->where('BANK_IND', 1)
                        ->get();

        return template::loadview('admin.accounts.v1.settings.cheque_setup', compact('bankAccounts'));
    }

    public function accountsGetCheque(Request $request)
    {
        $cheques = DB::table('ACCT_CHECQUE_VERIFIED_LISTING AS c')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS AS a', 'c.BANK_NO', '=', 'a.ACCOUNT_NO_PK')
            ->leftJoin('WSEC_USER AS u', 'c.CHECQUE_VERIFIED_BY', '=', 'u.USER_NO_PK')
            ->select(
                'c.CHECQUE_VERIFIED_NO_PK',
                'c.BANK_NO',
                'a.ACCOUNT_NAME AS bank_name',
                'c.CHECQUE_NO',
                'c.CHECQUE_NO_TO',
                'c.CHECQUE_VERIFIED_DATE',
                'c.CHECQUE_VERIFIED_BY',
                'u.USER_FULLNAME AS verified_by_name',
                'c.STATUS'
            )
            ->orderBy('c.CHECQUE_VERIFIED_DATE', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $cheques
        ]);
    }

    // public function saveCheque(Request $request)
    // {
    //     DB::beginTransaction(); // Start transaction
    //     // dd($request->all());
    //     try {
    //         $id = $request->checque_verified_no_pk; // Primary key field (used for update)
    //         // Validation
    //         $request->validate([
    //             'bank_name' => 'required|numeric',
    //             'cheque_start_number' => 'required|numeric',
    //             'cheque_end_number' => 'required|numeric|gte:cheque_start_number',
    //             'status' => 'required|in:1,2',

    //         ]);

    //         $data = [
    //             'bank_no' => $request->bank_name,
    //             'checque_no' => $request->cheque_start_number,
    //             'checque_no_to' => $request->cheque_end_number,
    //             'status' => $request->status,
    //             'checque_verified_by' => Auth::id(),
    //             'checque_verified_date' => now(),
    //         ];

    //         if (empty($id)) {
    //             // Insert new record
    //             $sequence = DB::getSequence();
    //             $newPk = $sequence->nextValue('checque_verified_no_pk_seq');

    //             $data['checque_verified_no_pk'] = $newPk;
    //             $data['au_entry_by'] = Auth::id();
    //             $data['au_entry_at'] = now();
    //             $data['au_entry_session'] = 'test'; // Or get from session
    //             $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

    //             DB::table('ACCT_CHECQUE_VERIFIED_LISTING')->insert($data);
    //         } else {
    //             // Update existing record
    //             $data['au_update_by'] = Auth::id();
    //             $data['au_update_at'] = now();
    //             $data['au_update_session'] = 'update session';
    //             $data['au_update_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

    //             DB::table('ACCT_CHECQUE_VERIFIED_LISTING')
    //                 ->where('checque_verified_no_pk', $id)
    //                 ->update($data);
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Cheque register saved successfully.',
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollback();

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function saveCheque(Request $request)
    {
        DB::beginTransaction();

        try {
            $id = $request->checque_verified_no_pk;

            $request->validate([
                'bank_name' => 'required|numeric',
                'cheque_start_number' => 'required|numeric',
                'cheque_end_number' => 'required|numeric|gte:cheque_start_number',
                'status' => 'required|in:1,2',
            ]);

            $hospitalNo = \Illuminate\Support\Facades\Session::get('user.ses_hospital_no_pk');
            $startNo = (int) $request->cheque_start_number;
            $endNo = (int) $request->cheque_end_number;

            $data = [
                'bank_no' => $request->bank_name,
                'checque_no' => $startNo,
                'checque_no_to' => $endNo,
                'status' => $request->status,
                'checque_verified_by' => Auth::id(),
                'checque_verified_date' => now(),
            ];

            if (empty($id)) {
                $sequence = DB::getSequence();
                $newPk = $sequence->nextValue('checque_verified_no_pk_seq');

                $data['checque_verified_no_pk'] = $newPk;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_at'] = now();
                $data['au_entry_session'] = 'entry session';
                $data['au_entry_hospital_no_fk'] = $hospitalNo;

                DB::table('ACCT_CHECQUE_VERIFIED_LISTING')->insert($data);
                $id = $newPk;
            } else {
                $data['au_update_by'] = Auth::id();
                $data['au_update_at'] = now();
                $data['au_update_session'] = 'update session';
                $data['au_update_hospital_no_fk'] = $hospitalNo;

                DB::table('ACCT_CHECQUE_VERIFIED_LISTING')
                    ->where('checque_verified_no_pk', $id)
                    ->update($data);

                DB::table('ACCT_CHECQUEDTL')
                    ->where('checque_verified_no_fk', $id)
                    ->delete();
            }

            $detailSeq = DB::getSequence();
            $detailData = [];

            for ($i = $startNo; $i <= $endNo; $i++) {
                $detailData[] = [
                    'checquedtl_no_pk' => $detailSeq->nextValue('checquedtl_no_pk_seq'),
                    'checque_verified_no_fk' => $id,
                    'checque_no' => $i,
                    'use_ind' => 0,
                    'status' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => now(),
                    'au_entry_session' => 'entry session',
                    'au_entry_hospital_no_fk' => $hospitalNo,
                ];
            }

            DB::table('ACCT_CHECQUEDTL')->insert($detailData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cheque register saved successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editCheque($primaryKey)
    {

        $bankAccounts = DB::table('ACCT_CHART_OF_ACCOUNTS')
                        ->select([
                            'ACCOUNT_NO_PK as account_pk',
                            'ACCOUNT_CODE as account_code',
                            'ACCOUNT_NAME as account_name'
                        ])
                        ->where('BANK_IND', 1)
                        ->get();

        $data = DB::table('ACCT_CHECQUE_VERIFIED_LISTING')
                ->where('CHECQUE_VERIFIED_NO_PK', $primaryKey)
                ->select(
                    'CHECQUE_VERIFIED_NO_PK as cheque_verified_pk',
                    'BANK_NO as bank_pk',
                    'CHECQUE_NO as cheque_no_form',
                    'CHECQUE_NO_TO as cheque_no_to',
                    'STATUS as status'
                )
                ->first();

        return Template::loadView(
            'admin.accounts.v1.settings.modal.edit_cheque_setup',
            compact('bankAccounts', 'data')
        );
    }

    // public function updateCheque(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Validation
    //         $request->validate([
    //             'cheque_verified_no_pk' => 'required|numeric',
    //             'bank_name' => 'required|numeric',
    //             'cheque_start_number' => 'required|numeric',
    //             'cheque_end_number' => 'required|numeric|gte:cheque_start_number',
    //             'status' => 'required|in:1,2',

    //         ]);

    //         // Data Preparation
    //         $data = [
    //             'bank_no' => $request->bank_name,
    //             'checque_no' => $request->cheque_start_number,
    //             'checque_no_to' => $request->cheque_end_number,
    //             'status' => $request->status,
    //             'au_update_by' => Auth::id(),
    //             'au_update_at' => now(),
    //             'au_update_session' => 'update session',
    //             'au_update_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
    //         ];

    //         // Update the record
    //         DB::table('ACCT_CHECQUE_VERIFIED_LISTING')
    //             ->where('checque_verified_no_pk', $request->cheque_verified_no_pk)
    //             ->update($data);

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Cheque record updated successfully.',
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollback();

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function updateCheque(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'cheque_verified_no_pk' => 'required|numeric',
                'bank_name' => 'required|numeric',
                'cheque_start_number' => 'required|numeric',
                'cheque_end_number' => 'required|numeric|gte:cheque_start_number',
                'status' => 'required|in:1,2',
            ]);

            $id = $request->cheque_verified_no_pk;
            $hospitalNo = \Illuminate\Support\Facades\Session::get('user.ses_hospital_no_pk');
            $startNo = (int) $request->cheque_start_number;
            $endNo = (int) $request->cheque_end_number;

            $data = [
                'bank_no' => $request->bank_name,
                'checque_no' => $startNo,
                'checque_no_to' => $endNo,
                'status' => $request->status,
                'au_update_by' => Auth::id(),
                'au_update_at' => now(),
                'au_update_session' => 'update session',
                'au_update_hospital_no_fk' => $hospitalNo,
            ];

            DB::table('ACCT_CHECQUE_VERIFIED_LISTING')
                ->where('checque_verified_no_pk', $id)
                ->update($data);

            DB::table('ACCT_CHECQUEDTL')
                ->where('checque_verified_no_fk', $id)
                ->delete();

            $detailSeq = DB::getSequence();
            $detailData = [];

            for ($i = $startNo; $i <= $endNo; $i++) {
                $detailData[] = [
                    'checquedtl_no_pk' => $detailSeq->nextValue('checquedtl_no_pk_seq'),
                    'checque_verified_no_fk' => $id,
                    'checque_no' => $i,
                    'use_ind' => 0,
                    'status' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => now(),
                    'au_entry_session' => 'update session',
                    'au_entry_hospital_no_fk' => $hospitalNo,
                ];
            }

            DB::table('ACCT_CHECQUEDTL')->insert($detailData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cheque record updated successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function accountsCostCenterSetupV1(){
        $con = 'hr_dept_ind = 1';
        $data = $this->chart_of_acc->get_service_unit($con);
        return template::loadview('admin.accounts.v1.settings.cost_center_v1',compact('data'));
    }

    public function accountsGetCostCenterV1(Request $request){
        $con = null;
        if(isset($request->su_no)){
            if($request->su_no != null){
                $con ="acct_costcenter.su_no_fk ='$request->su_no'";
            }
        }
        $cost_center = $this->chart_of_acc->get_cost_center_v1($con);

        if(count($cost_center->getData()->data) == 0){
            return response()->json(["success" => false, "data" => [] ],200);
        }

        return response()->json(["success" => false, "data" => $cost_center->getData()->data ],200);
    }

    public function saveCostCenter(Request $request){

        $request->validate([
            'department' => 'required',
            'cost_center_name' => 'required|max:50',
            'cost_center_code' => 'required|max:50',
            'notes'            => 'max:500'
        ]);
        $sub_ledger_name = $this->chart_of_acc->save_cost_center_v1([
                'notes' => $request->notes,
                'status' => $request->status,
                'department' =>$request->department,
                'cost_center_name' =>$request->cost_center_name,
                'cost_center_code' =>$request->cost_center_code
        ]);

        return $sub_ledger_name;
    }

    public function editCostCenter($id){
        $con = 'hr_dept_ind = 1';
        $service_unit = $this->chart_of_acc->get_service_unit($con);
        $data = DB::table('acct_costcenter')
                    ->where('costcenter_no_pk',$id)
                    ->select('notes','status','su_no_fk','costcenter_name','costcenter_code','costcenter_no_pk')
                    ->first();
        return Template::loadView("admin.accounts.v1.settings.modal.edit_cost_center", ['data' => $data , 'service_unit' => $service_unit]);
    }

    public function updateCostCenter(Request $request){
        $request->validate([
            'department_modal' => 'required',
            'costcenter_name' => 'required|max:50',
            'costcenter_code' => 'required|max:50',
            'notes'            => 'max:500'
        ]);

        $update_cost_center_v1 = $this->chart_of_acc->update_cost_center_v1([
            'costcenter_no_pk' => $request->costcenter_no_pk,
            'notes' => $request->notes,
            'status' => $request->status,
            'department' =>$request->department_modal,
            'costcenter_name' =>$request->costcenter_name,
            'costcenter_code' =>$request->costcenter_code,
        ]);

        return $update_cost_center_v1;

    }

    public function accountsJournalPosting(){
        $company = $this->chart_of_acc->get_company();
        $currency = $this->account_setup->currency_data();
        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();
        $sub_ledger_name = $this->chart_of_acc->get_sub_ledger_name(null);
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        $cost_center = $this->chart_of_acc->get_cost_center_v1(null);
        $fiscal_year = $this->account_setup->get_fiscal_year();
        $fiscal_month = $this->account_setup->get_fiscal_month();
        return template::loadview('admin.accounts.v1.transaction.journal_posting_v1',compact('voucher_type','sub_ledger_type','sub_ledger_name','general_ledger','cost_center','company','currency','fiscal_year','fiscal_month'));
    }


    public function getPatientInfo(Request $request){

        if($request->subledger_ind == 'OPD'){
           $data = $this->getOPDPatients($request->key);
        }
        else{
           $data =  $this->getIPDPatients($request->key);
        }
        if(count($data) > 0){
            return response()->json(['data'=>$data],200);
        }
        else {
            return response()->json(['data'=>[],'message' => 'Patient info not found'], 400);
        }

    }

    public function getIPDPatients($key){
        $ipd = DB::table('ipd_admission')
                ->join('patn_registration', 'patn_registration.patient_no_pk', 'ipd_admission.patient_no_fk')
                ->select([
                    'ipd_admission.admission_uid as code',
                    'ipd_admission.admission_no_pk',
                    'patn_registration.patient_code',
                    'patn_registration.patient_name',
                    'patn_registration.patient_no_pk',
                    DB::raw("ipd_admission.admission_uid || '-' || patn_registration.patient_code || '-' || patn_registration.patient_name as patient") // Alias the calculated column
                ])
                ->where(function ($query) use ($key) {
                    $query->where('admission_uid', 'like', '%' . $key . '%')
                        ->orWhere('patient_code', 'like', '%' . $key . '%')
                        ->orWhere(DB::raw("UPPER(patn_registration.patient_name)"), 'like', '%' . strtoupper($key) . '%');
                })
                ->where('patn_registration.status', 1)
                ->get();

        return $ipd;
    }

    public function getOPDPatients($key){
        $opd = DB::table('finc_invoicemst')
                    ->join('patn_registration','patn_registration.patient_no_pk','finc_invoicemst.patient_no_fk')
                    ->select([
                        'finc_invoicemst.invoice_no_pk',
                        'finc_invoicemst.invoice_code as code',
                        'patn_registration.patient_code',
                        'patn_registration.patient_name',
                        'patn_registration.patient_no_pk',
                        DB::raw("finc_invoicemst.invoice_code || '-' || patn_registration.patient_code || '-' || patn_registration.patient_name as patient")
                    ])

                    ->where(function ($query) use ($key) {
                        $query->where('finc_invoicemst.invoice_code', 'like', '%' . $key . '%')
                            ->orWhere('patn_registration.patient_code', 'like', '%' . $key . '%')
                            ->orWhere(DB::raw("UPPER(patn_registration.patient_name)"), 'like', '%' . strtoupper($key) . '%');
                    })
                    ->where('patn_registration.status',1)
                    ->get();
        return $opd;

    }

    public function edit_journal(Request $request){

        $voucher_id = $request->get('journal_id');
        $voucher = $this->voucher_entry->get_journal($voucher_id);
        if ($voucher->getData()->success == true) {
            if($voucher->getData()->data[0]->verified_ind == 1){
                return view("admin.components.error_alert");
            }
            $voucher_details = $voucher->getData()->data;
            $company = $this->chart_of_acc->get_company();
            $currency = $this->account_setup->currency_data();
            $voucher_type = $this->voucher_type->get_voucher_type_v1();
            $sub_ledger_type = $this->chart_of_acc->get_sub_ledger_type();
            $sub_ledger_name = $this->chart_of_acc->get_sub_ledger_name(null);
            $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
            $cost_center = $this->chart_of_acc->get_cost_center_v1(null);
            $fiscal_year = $this->account_setup->get_fiscal_year();
            $fiscal_month = $this->account_setup->get_fiscal_month();

            return template::loadview('admin.accounts.v1.transaction.journal_edit_v1',compact('voucher_type','sub_ledger_type','sub_ledger_name','general_ledger','cost_center','company','currency','fiscal_year','fiscal_month','voucher_details'));

        }
        else{
            return view("admin.components.error_alert");
        }




    }

    public function currency_data(){
        $currency = [];
        $curr_data = DB::table('sysc_currency')->select('currency_no_pk','rate','currency_code','status')->where('status',1)->get();
        foreach ($curr_data as $value) {
            $temp['curr_pk'] = $value->currency_no_pk;;
            $temp['curr_name'] = $value->currency_code;
            $temp['curr_rate'] = $value->rate;
            array_push($currency,$temp);
        }
        return $currency;
    }

    public function getGeneraledger($id){

         try{
          $getLedger = $this->chart_of_acc->get_account_level($id);
          return response()->json(['success' => true, 'data' => $getLedger->getData()->data], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function accountsGetSubLedgerNameList($id){
        $subledger = DB::table('acct_subledger_name')->select('acct_subledger_no_pk','subledger_code','subledger_name','acct_subledger_typeno_fk')->where('acct_subledger_typeno_fk',$id)->get();


        $data = [];
        $d="<option value='0'>Select one</option>";
        array_push($data,$d);
        if(count($subledger)>0){
            foreach($subledger as $item){
                $d='<option value='.$item->acct_subledger_no_pk.'>'.$item->subledger_code.'-'.$item->subledger_name.'</option>';
                array_push($data,$d);
            }
            return $data;
        }
        else{
            return "<option value='0'>Not Found</option>";
        }
    }

    public function accountsJournalInfo(){
        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $voucher_source = DB::table('ACCT_JOURNAL_ENTRY')->select('AUTO_POSTING_REF_TYPE')->distinct()->get()->toArray();
        return template::loadview('admin.accounts.v1.transaction.journal_info',compact('voucher_type','voucher_source'));
    }
    public function accountsJournalInfoModify(){
        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        return template::loadview('admin.accounts.v1.transaction.journal_info_modify',compact('voucher_type'));
    }

    public function accountsJournalList(){
        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $voucher_source = DB::table('ACCT_JOURNAL_ENTRY')->select('AUTO_POSTING_REF_TYPE')->distinct()->get()->toArray();
        return template::loadview('admin.accounts.v1.transaction.journal_list',compact('voucher_type','voucher_source'));
    }

    public function show_journal_info(Request $request)
    {
        $from_date = "";
        $to_date = "";
        $cheque_date = "";

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->cheque_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->cheque_date);  // define date format from user
            $cheque_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$from_date."' and '".$to_date."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$cheque_date."'": "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->status) != "") ? " $clause verified_ind='".$request->status."'": "";
        
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= (trim($request->prepared_by) != "") ? " $clause lower(prepare_by) like lower('%".$request->prepared_by."%')" : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= (trim($request->ref_value) != "") ? " $clause ref_value like '%".$request->ref_value."%'" : "";
        
        // Integration Condition

        if($request->integration_type == 0 && $request->integration_type != ''){

            $clause = ($sql_cond != "") ? " and": " ";
            $sql_cond .= (trim($request->integration_type) == 0) ? " $clause auto_posting_ind != 1": "";
        }
        else if($request->integration_type == 1){
            $clause = ($sql_cond != "") ? " and": " ";
            $sql_cond .= (trim($request->integration_type) == 1) ? " $clause auto_posting_ind = 1": "";

            if(!empty($request->voucher_source)){
                $clause = ($sql_cond != "") ? " and": " ";
                $sql_cond .= !empty(($request->voucher_source)) ? " $clause AUTO_POSTING_REF_TYPE = '".$request->voucher_source."'": "";
            }
        }


        $voucher_info = $this->voucher_entry->journal_info($sql_cond);
        // dd($voucher_info);

        return view('admin.accounts.v1.verification.show_journal_info',compact('voucher_info'));
    }

    public function autocompletePreparedBy(Request $request)
    {
        $search = $request->get('query', '');

        if (empty($search)) {
            return response()->json([]);
        }

        $data = DB::table('ACCT_JOURNAL_ENTRY')
            ->select('PREPARE_BY') 
            ->whereNotNull('PREPARE_BY')
            ->where('PREPARE_BY', 'ILIKE', "%{$search}%") 
            ->groupBy('PREPARE_BY')
            ->limit(10)
            ->get();

        $suggestions = $data->map(function ($item) {
            return ['value' => $item->PREPARE_BY];
        });

        return response()->json($suggestions);
    }

    public function show_journal_info_modify(Request $request)
    {
        $from_date = "";
        $to_date = "";
        $cheque_date = "";

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->cheque_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->cheque_date);  // define date format from user
            $cheque_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$from_date."' and '".$to_date."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$cheque_date."'": "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->status) != "") ? " $clause verified_ind='".$request->status."'": "";

        $voucher_info = $this->voucher_entry->journal_info($sql_cond);

        return view('admin.accounts.v1.verification.show_journal_info_modify',compact('voucher_info'));

    }

    public function show_journal_list(Request $request)
    {
        $from_date = "";
        $to_date = "";
        $cheque_date = "";

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->cheque_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->cheque_date);  // define date format from user
            $cheque_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$from_date."' and '".$to_date."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$cheque_date."'": "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->status) != "") ? " $clause verified_ind='".$request->status."'": "";
        // Integration Condition

        if($request->integration_type == 0 && $request->integration_type != ''){

            $clause = ($sql_cond != "") ? " and": " ";
            $sql_cond .= (trim($request->integration_type) == 0) ? " $clause auto_posting_ind != 1": "";
        }
        else if($request->integration_type == 1){
            $clause = ($sql_cond != "") ? " and": " ";
            $sql_cond .= (trim($request->integration_type) == 1) ? " $clause auto_posting_ind = 1": "";

            if(!empty($request->voucher_source)){
                $clause = ($sql_cond != "") ? " and": " ";
                $sql_cond .= !empty(($request->voucher_source)) ? " $clause AUTO_POSTING_REF_TYPE = '".$request->voucher_source."'": "";
            }
        }

        $voucher_info = $this->voucher_entry->journal_info($sql_cond);

        return view('admin.accounts.v1.transaction.show_journal',compact('voucher_info'));
    }

    public function accountsJournalFinalize()
    {
        $voucher_type = $this->voucher_type->get_voucher_type_v1();

        return template::loadview('admin.accounts.v1.transaction.journal_finalize',compact('voucher_type'));
    }

    public function show_journal_finalize(Request $request)
    {

        $from_date = "";
        $to_date = "";
        $cheque_date = "";

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);  // define date format from user
            $to_date = $dateTime->format('Y-m-d'); // define expected format
        }

        if(!empty($request->cheque_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->cheque_date);  // define date format from user
            $cheque_date = $dateTime->format('Y-m-d'); // define expected format
        }

        $sql_cond = (trim($request->date_from) != "" && trim($request->date_to != "")) ? " to_char(journal_date,'YYYY-MM-DD') between '".$from_date."' and '".$to_date."'" : "";
    	$clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_no) != "") ? " $clause journal_code='".$request->voucher_no."'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
    	$sql_cond .= (trim($request->voucher_type) != "") ? " $clause voucher_type_no_fk='".$request->voucher_type."'" : "";
        $clause = ($sql_cond !="") ? " and": " ";
        $sql_cond .= (trim($request->cheque_no) != "") ? " $clause bank_cheq_number='".$request->cheque_no."'" : "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->cheque_date) != "") ? " $clause bank_cheq_date='".$cheque_date."'": "";
        $clause = ($sql_cond != "") ? " and": " ";
        $sql_cond .= (trim($request->status) != "") ? " $clause finalized_ind='".$request->status."'": "";

        $voucher_info = $this->voucher_entry->finalize_journal_info_v1($sql_cond);
        return view('admin.accounts.v1.verification.show_journal_finalize',compact('voucher_info'));
    }

    public function get_chart_of_account_by_id_v1(Request $request)
    {
        $get_charof_account_by_id = $this->chart_of_acc->get_chart_of_account_by_id_v1($request->account_no_pk);

        if ($get_charof_account_by_id->getData()->success == true) {
            return response()->json(['success' => true, 'data' => $get_charof_account_by_id->getData()->data], 200);
        }

        return response()->json(['success' => false, 'message' => 'Invalid Account Code'], 200);

    }


    // Close Accounts V1 Methods

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //chart_of_acc
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
