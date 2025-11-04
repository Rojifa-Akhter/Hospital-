<?php

namespace App\Http\Controllers;
use PDO;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\Supplier\Supplier;
use Illuminate\Support\Facades\Validator;
use App\Core\Accounts\PatientInfo\Patient;
use App\Core\Accounts\EmployeeInfo\Employee;
use App\Core\Accounts\AccountType\AccountType;
use App\Core\Accounts\VoucherType\VoucherType;
use App\Core\Accounts\AccountSetup\AccountSetup;
use App\Core\Accounts\VoucherEntry\VoucherEntry;
use App\Core\Accounts\AccountsBalance\AccountsBalance;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use App\Core\Accounts\CashFlowCategory\CashFlowCategory;

class AccountsIntregrationController extends Controller
{

    use LookupData;
    /**
     * Root account service
     *
     * @var [@App\Core\Accounts\AccountType\AccountType]
     */
    protected $account_type;

    /**
     * Accounts Setup service
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
      
    public function __construct(AccountType $account_type,
            AccountSetup  $account_setup,
            CashFlowCategory $cashflow_category,
            ChartOfAccounts $chart_of_acc,
            VoucherType $voucher_type,
            VoucherEntry $voucher_entry,
            AccountsBalance $account_balance,
            Employee $employee,
            Supplier $supplier,
            Patient $patient)
    {
        $this->middleware('auth');
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

    public function index()
    {
        //Data for inputfill

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $salary_lookup_data = DB::table('SYSC_LOOKUPDATA')->whereIn('lookup_no_fk', function($query){
            $query->select('lookup_no_pk')
            ->from('sysc_lookup')
            ->where('lookup_name','SALARYBREAKDOWN');
        })->get();
        $item_wise_trn_type_no = DB::table('ACCT_ACCOUNT_TYPE')->get();
        $system_service_unit = DB::table('SYS_SERVICEUNIT')->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        // $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                           ->where('FIN_MAPPING_IND', 1)
                           ->get();
        $chart_of_accounts = DB::table('ACCT_CHART_OF_ACCOUNTS')
            ->select('ACCOUNT_NAME', 'ACCOUNT_CODE', 'ACCOUNT_NO_PK')
            ->where('STATUS', 1)
            ->get();
        // dd($sysc_module->all());
        return Template::loadview('admin.accounts.intregration.accounts_intregration', compact('service_unit', 'system_service_unit', 'item_wise_trn_type_no', 'sysc_module', 'finc_trntype','salary_lookup_data', 'chart_of_accounts'));
    }

    public function fetchItemwise()
    {
        //Item wise Data for View
        $itemWiseData_view = DB::table('ACC_INTEGRATIONITEMWISE a')
            ->join('sysc_serviceitem', 'a.item_no_fk', '=', 'sysc_serviceitem.item_no_pk')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS cr', 'a.TRN_CR_ACCOUNT_NO_FK', '=', 'cr.account_no_pk')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS dr', 'a.TRN_DR_ACCOUNT_NO_FK', '=', 'dr.account_no_pk')
            // ->leftJoin('FINC_TRNTYPE tn', 'a.TRN_TYPE_NO_FK', '=', 'tn.TRN_TYPE_NO_PK')
            // ->leftJoin('FINC_TRNTYPE tc', 'a.TRN_TYPE_CODE', '=','tc.TRN_TYPE_CODE')
            ->select(
                'sysc_serviceitem.ITEM_NAME',
                'cr.ACCOUNT_NAME as cr_account_name',
                'a.TRN_CR_ACCOUNT_PERCENT',
                'dr.ACCOUNT_NAME as dr_account_name',
                'a.TRN_DR_ACCOUNT_PERCENT',
                'a.TRN_TYPE_NO_FK as tn_name',
                'a.TRN_TYPE_CODE as tc_name',
                'a.MODULE_CODE',

            )
            ->orderBy('a.INTEGRATIONITEMWISE_NO_PK', 'desc')
            ->get();

        return response()->json([
            'itemWiseData_view' => $itemWiseData_view,
        ]);
    }

    public function fetchitemtypewise()
    {
        //Item type Data for View
        $itemTypeWiseData = DB::table('ACC_INTEGRATIONITEMTYPEWISE itd')
            ->join('SYSC_ITEMTYPE', 'itd.ITEM_TYPE_NO_FK',  'SYSC_ITEMTYPE.ITEMTYPE_NO_PK')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS cr', 'itd.TRN_CR_ACCOUNT_NO_FK', '=', 'cr.account_no_pk')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS dr', 'itd.TRN_DR_ACCOUNT_NO_FK', '=', 'dr.account_no_pk')
            // ->leftJoin('ACCT_ACCOUNT_TYPE tn', 'itd.TRN_TYPE_NO_FK', '=', 'tn.acct_type_no_pk')
            // ->leftJoin('ACCT_ACCOUNT_TYPE tc', 'itd.TRN_TYPE_CODE', '=', 'tc.acct_type_code')
            ->select(
                'SYSC_ITEMTYPE.ITEM_TYPE_NAME',
                'cr.ACCOUNT_NAME as cr_account_name',
                'itd.TRN_CR_ACCOUNT_PERCENT',
                'dr.ACCOUNT_NAME as dr_account_name',
                'itd.TRN_DR_ACCOUNT_PERCENT',
                'itd.TRN_TYPE_NO_FK as tn_name',
                'itd.TRN_TYPE_CODE as tc_name',
                'itd.MODULE_CODE',
            )
            ->orderBy('itd.INTEGRATIONITEMTYPEWISE_NO_PK', 'desc')
            ->get();

        return response()->json([
            'itemTypeWiseData' => $itemTypeWiseData,
        ]);
    }

    public function fetchserviceunit()
    {
        //Service Unit Data for View  acc_integrationserviceunitwise
        $serviceUnitWiseData = DB::table('acc_integrationserviceunitwise sud')
            ->join('SYSC_SERVICEUNIT', 'sud.SERVICEUNIT_NO_FK',  'SYSC_SERVICEUNIT.SERVICEUNIT_NO_PK')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS cr', 'sud.TRN_CR_ACCOUNT_NO_FK', '=', 'cr.account_no_pk')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS dr', 'sud.TRN_DR_ACCOUNT_NO_FK', '=', 'dr.account_no_pk')
            // ->leftJoin('ACCT_ACCOUNT_TYPE tn', 'sud.TRN_TYPE_NO_FK', '=', 'tn.acct_type_no_pk')
            // ->leftJoin('ACCT_ACCOUNT_TYPE tc', 'sud.TRN_TYPE_CODE', '=', 'tc.acct_type_code')
            ->select(
                'SYSC_SERVICEUNIT.SERVICEUNIT_NAME',
                'cr.ACCOUNT_NAME as cr_account_name',
                'sud.TRN_CR_ACCOUNT_PERCENT',
                'dr.ACCOUNT_NAME as dr_account_name',
                'sud.TRN_DR_ACCOUNT_PERCENT',
                'sud.TRN_TYPE_NO_FK as tn_name',
                'sud.TRN_TYPE_CODE as tc_name',
                'sud.MODULE_CODE',
            )
            ->orderBy('sud.INTEG_NO_PK', 'desc')
            ->get();

        return response()->json([
            'serviceUnitWiseData' => $serviceUnitWiseData,
        ]);
    }

    public function fetchacctypewise()
    {
        //Acc.  type wise Data for View acc_integrationtrntypewise
        $accTypeWiseData = DB::table('acc_accounts_name_wise_vw acct')
            ->select(
                'integrationtrntypewise_no_pk',
                'account_name_cr as cr_account_name',
                'TRN_CR_ACCOUNT_PERCENT',
                'ACCOUNT_NAME_DR as dr_account_name',
                'TRN_DR_ACCOUNT_PERCENT',
                'TRN_TYPE_NO_FK as tn_name',
                'TRN_TYPE_CODE as tc_name',
                'MODULE_CODE',
                'SERVICEUNIT_NAME',
                "SET_PATIENT_VAL_IND",
                "SET_SUPPLIER_VAL_IND",
                "SET_PERSON_VAL_IND",
                "INDEPENDENT_VOUCHER_IND"
            )
            ->orderBy('INTEGRATIONTRNTYPEWISE_NO_PK', 'desc')
            ->get();

        return response()->json([
            'accTypeWiseData' => $accTypeWiseData,
        ]);
    }


    public function fetchPayrollwise()
    {
        //Acc.  type wise Data for View acc_integrationtrntypewise
        $accTypeWiseData = DB::table('ACC_INTEGRATION_PAYROLLLIST_VW acct')
            ->select(
                'INTEGRATIONPAYROLL_NO_PK',
                'account_name_cr as cr_account_name',
                'TRN_CR_ACCOUNT_PERCENT',
                'ACCOUNT_NAME_DR as dr_account_name',
                'TRN_DR_ACCOUNT_PERCENT',
                //'TRN_TYPE_NO_FK as tn_name',
                //'TRN_TYPE_CODE as tc_name',
                'MODULE_CODE',
                //'SERVICEUNIT_NAME',
                //"SET_PATIENT_VAL_IND",
                //"SET_SUPPLIER_VAL_IND",
                //"SET_PERSON_VAL_IND",
                //"INDEPENDENT_VOUCHER_IND"
            )
            ->orderBy('INTEGRATIONPAYROLL_NO_PK', 'desc')
            ->get();

        return response()->json([
            'accPayrollData' => $accTypeWiseData,
        ]);
    }

    public function fetchcostcenter()
    {
        // ACC_COSTCENTER_MST_VW Cost center Data for View acc_costcenter_mst
        $costCenter = DB::table('acc_costcenter_mst')
            ->orderBy('acc_costcenter_mst.COSTCENTER_NO_PK', 'desc')
            ->get();

        return response()->json([
            'costCenter' => $costCenter,
        ]);
    }

    public function fetchcostcenterchild()
    {
        $costCenterChildData = DB::table('acc_costcenter_chd ccc')
            ->join('ACCT_CHART_OF_ACCOUNTS', 'ccc.TRN_CR_ACCOUNT_NO_FK',  'ACCT_CHART_OF_ACCOUNTS.ACCOUNT_NO_PK')
            ->leftJoin('ACCT_CHART_OF_ACCOUNTS dr', 'ccc.TRN_DR_ACCOUNT_NO_FK', '=', 'dr.account_no_pk')
            ->select(
                'ACCT_CHART_OF_ACCOUNTS.ACCOUNT_NAME',
                'ccc.TRN_CR_ACCOUNT_PERCENT',
                'dr.ACCOUNT_NAME as dr_account_name',
                'ccc.TRN_DR_ACCOUNT_PERCENT',
                'ccc.MODULE_CODE',
            )
            ->orderBy('ccc.COSTCENTERCHD_NO_PK', 'desc')
            ->get();

        return response()->json([
            'costCenterChildData' => $costCenterChildData,
        ]);
    }


    public function searchitem(Request $request)
    {
        // //Item wise item list
        if ($request->has('itemList')) {
            $variable = $request->input('itemList');
            return DB::table('SYSC_SERVICEITEM')
                ->whereRaw("upper(item_name) like upper('%$variable%')")
                ->get();
        }
        //cr acc no Auto Complete
        elseif ($request->has('crAccount')) {
            $variable = $request->input('crAccount');
            return DB::table('ACCT_CHART_OF_ACCOUNTS')
                ->where('POSTING_HEAD_IND', 1)
                ->whereRaw("upper(account_name) like upper('%$variable%')")
                ->get();
        }


        //DR acc no Auto Complete
        elseif ($request->has('draccount')) {
            $variable = $request->input('draccount');
            return DB::table('ACCT_CHART_OF_ACCOUNTS')
                ->where('POSTING_HEAD_IND', 1)
                ->whereRaw("upper(account_name) like upper('%$variable%')")
                ->get();
        }

        //  Item Types   Item Type List
        elseif ($request->has('itemtypeListfilter')) {
            $variable = $request->input('itemtypeListfilter');
            return DB::table('SYSC_ITEMTYPE')
                ->whereRaw("upper(ITEM_TYPE_NAME) like upper('%$variable%')")
                ->get();
        }

        //SYSC_SERVICEUNIT Service Unit List
        elseif ($request->has('servicUnitList')) {
            $variable = $request->input('servicUnitList');
            return DB::table('SYSC_SERVICEUNIT')
                ->whereRaw("upper(SERVICEUNIT_NAME) like upper('%$variable%')")
                ->get();
        }
    }


    public function storeItemWise(Request $request)
    {

        $validData = Validator::make($request->all(), [
            'item_list_no_pk' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->itemWisecrAccPar > 100   || $request->itemWisecrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->itemWisedrAccPar > 100   || $request->itemWisedrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('INTEGRATIONITEMWISE_NO_PK_SEQ') + 1;
            DB::table('ACC_INTEGRATIONITEMWISE')->insert([
                'INTEGRATIONITEMWISE_NO_PK' => $sysc_pat_no_pk_seq,
                'ITEM_NO_FK' => $request->item_list_no_pk,
                'TRN_CR_ACCOUNT_NO_FK' => $request->itemWiseCrAccNo_pk,
                'TRN_CR_ACCOUNT_PERCENT' => $request->itemWisecrAccPar,
                'TRN_DR_ACCOUNT_NO_FK' => $request->itemWisedrAccNo_pk,
                'TRN_DR_ACCOUNT_PERCENT' => $request->itemWisedrAccPar,
                'TRN_TYPE_NO_FK' => $request->itemWise_trn_type_no,
                'TRN_TYPE_CODE' => $request->itemWisetrnTypeCode,
                'MODULE_CODE' => $request->itemWisemoduleCode,
            ]);
            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }

    public function storeItemType(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'item_type_list_no_pk' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->itemTypeWisecrAccPar > 100   || $request->itemTypeWisecrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->itemTypeWisedrAccPar > 100   || $request->itemTypeWisedrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('INTEGRATIONITEMTYPEWISE_NO_PK_SEQ') + 1;
            DB::table('ACC_INTEGRATIONITEMTYPEWISE')->insert([
                'INTEGRATIONITEMTYPEWISE_NO_PK' => $sysc_pat_no_pk_seq,
                'ITEM_TYPE_NO_FK' => $request->item_type_list_no_pk,
                'TRN_CR_ACCOUNT_NO_FK' => $request->itemTypeCrAccNo_pk,
                'TRN_DR_ACCOUNT_NO_FK' => $request->itemTypedrAccNo_pk,
                'TRN_TYPE_NO_FK' => $request->itemType_trn_type_no,
                'TRN_TYPE_CODE' => $request->itemTypetrnTypeCode,

                'TRN_CR_ACCOUNT_PERCENT' => $request->itemTypeWisecrAccPar,
                'TRN_DR_ACCOUNT_PERCENT' => $request->itemTypeWisedrAccPar,
                'MODULE_CODE' => $request->itemTypeWisemoduleCode,

            ]);
            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }

    public function storeserviceunit(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'serviceunitlist_no_pk' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->sUnitWisecrAccPar > 100   || $request->sUnitWisecrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->sUnitWisedrAccPar > 100   || $request->sUnitWisedrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('INTEGRATIONSERVICEUNITWISE_NO_PK_SEQ') + 1;
            DB::table('ACC_INTEGRATIONSERVICEUNITWISE')->insert([
                'INTEG_NO_PK' => $sysc_pat_no_pk_seq,
                'SERVICEUNIT_NO_FK' => $request->serviceunitlist_no_pk,
                'TRN_CR_ACCOUNT_NO_FK' => $request->serviceUnitrAccNo_pk,
                'TRN_CR_ACCOUNT_PERCENT' => $request->sUnitWisecrAccPar,
                'TRN_DR_ACCOUNT_NO_FK' => $request->serviceUnitrDrcNo_pk,
                'TRN_DR_ACCOUNT_PERCENT' => $request->sUnitWisedrAccPar,
                'TRN_TYPE_NO_FK' => $request->serviceUnit_trn_type_no,
                'TRN_TYPE_CODE' => $request->serviceUnitTrnTypeCode,
                'MODULE_CODE' => $request->sUnitWisemoduleCode,
            ]);
            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }

    public function storeacctype(Request $request)
    {
        // dd($request->all());
        //dd($request->id);
        $validData = Validator::make($request->all(), [
            'AccTypeWisecrAccNo_pk' => 'required',
        ]);

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $au_entry_by = Session::get('user.ses_user_pk_no');
        $tran_type =  explode('_', $request->AccTypeWisetrnTypeNo);
        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->AccTypeWisecrAccPar > 100   || $request->AccTypeWisecrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->AccTypeWisedrAccPar > 100   || $request->AccTypeWisedrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {


            $module_info = DB::table('SYSC_MODULE')->where('module_code', $request->AccTypeWisemoduleCode)->where('au_entry_hospital_pk_no', $hospital_id)->get();
            //dd($module_info[0]->module_no_pk);
            if (isset($request->id)) {
                //dd($request->all());
                DB::table('acc_integrationtrntypewise')->where('integrationtrntypewise_no_pk', $request->id)->update([
                    'TRN_CR_ACCOUNT_NO_FK' => $request->AccTypeWisecrAccNo_pk,
                    'TRN_CR_ACCOUNT_PERCENT' => $request->AccTypeWisecrAccPar,
                    'TRN_DR_ACCOUNT_NO_FK' => $request->AccTypeWisedrAccNo_pk,
                    'TRN_DR_ACCOUNT_PERCENT' => $request->AccTypeWisedrAccPar,
                    'TRN_TYPE_NO_FK' => isset($tran_type[0]) ? $tran_type[0] : 0,
                    'TRN_TYPE_CODE' => isset($tran_type[1]) ? $tran_type[1] : 0,
                    'ACCOUNTS_MAPPING_SU_NO_FK' => $request->AccTypeWiseServiceUnit,
                    'MODULE_CODE' => $request->AccTypeWisemoduleCode,
                    'MODULE_NO_FK' => $module_info[0]->module_no_pk,
                    'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id,
                    'AU_ENTRY_BY' => $au_entry_by,
                    'AU_ENTRY_AT' => now(),
                    'AU_ENTRY_SESSION' => 'IPDMAPPINF',
                    'STATUS' => 1,
                    'set_patient_val_ind' => isset($request->patient_ind) ? $request->patient_ind : 0,
                    'set_supplier_val_ind' => isset($request->supplier_ind) ? $request->supplier_ind : 0,
                    'set_person_val_ind' => isset($request->doctor_ind) ? $request->doctor_ind : 0,
                    'independent_voucher_ind' => isset($request->independent_voucher_ind) ? $request->independent_voucher_ind : 0
                ]);
            } else {
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('INTEGRATIONSERVICEUNITWISE_NO_PK_SEQ') + 1;
                DB::table('ACC_INTEGRATIONTRNTYPEWISE')->insert([
                    'INTEGRATIONTRNTYPEWISE_NO_PK' => $sysc_pat_no_pk_seq,
                    'TRN_CR_ACCOUNT_NO_FK' => $request->AccTypeWisecrAccNo_pk,
                    'TRN_CR_ACCOUNT_PERCENT' => $request->AccTypeWisecrAccPar,
                    'TRN_DR_ACCOUNT_NO_FK' => $request->AccTypeWisedrAccNo_pk,
                    'TRN_DR_ACCOUNT_PERCENT' => $request->AccTypeWisedrAccPar,
                    'TRN_TYPE_NO_FK' => isset($tran_type[0]) ? $tran_type[0] : 0,
                    'TRN_TYPE_CODE' => isset($tran_type[1]) ? $tran_type[1] : 0,
                    'ACCOUNTS_MAPPING_SU_NO_FK' => $request->AccTypeWiseServiceUnit,
                    'MODULE_CODE' => $request->AccTypeWisemoduleCode,
                    'MODULE_NO_FK' => $module_info[0]->module_no_pk,
                    'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id,
                    'AU_ENTRY_BY' => $au_entry_by,
                    'AU_ENTRY_AT' => now(),
                    'AU_ENTRY_SESSION' => 'IPDMAPPINF',
                    'STATUS' => 1,
                    'set_patient_val_ind' => isset($request->patient_ind) ? $request->patient_ind : 0,
                    'set_supplier_val_ind' => isset($request->supplier_ind) ? $request->supplier_ind : 0,
                    'set_person_val_ind' => isset($request->doctor_ind) ? $request->doctor_ind : 0,
                    'independent_voucher_ind' => isset($request->independent_voucher_ind) ? $request->independent_voucher_ind : 0
                ]);
            }
            DB::commit();

            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }


    //account payroll setup entry

    public function storePayroll(Request $request)
    {
        // dd($request->all());
        //dd($request->id);
        $validData = Validator::make($request->all(), [
            'AccPayrollcrAccNo_pk' => 'required',
        ]);

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $au_entry_by = Session::get('user.ses_user_pk_no');
        $tran_type =  explode('_', $request->AccPayrolltrnTypeNo);
        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->AccPayrollcrAccPar > 100   || $request->AccPayrollcrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->AccPayrolldrAccPar > 100   || $request->AccPayrolldrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {


            $module_info = DB::table('SYSC_MODULE')->where('module_code', $request->AccPayrollmoduleCode)->where('au_entry_hospital_pk_no', $hospital_id)->get();
            
            //dd($module_info[0]->module_no_pk);
            if (isset($request->id)) {
                //dd($request->all());
                DB::table('ACC_INTEGRATION_PAYROLL_LIST')->where('INTEGRATIONPAYROLL_NO_PK', $request->id)->update([
                    'TRN_CR_ACCOUNT_NO_FK' => $request->AccPayrollcrAccNo_pk,
                    'TRN_CR_ACCOUNT_PERCENT' => $request->AccPayrollcrAccPar,
                    'TRN_DR_ACCOUNT_NO_FK' => $request->AccPayrolldrAccNo_pk,
                    'TRN_DR_ACCOUNT_PERCENT' => $request->AccPayrolldrAccPar,
                    'PAYROLL_BREAKDOWN_CODE' => $request->SalaryBreakDown,
                    //'TRN_TYPE_CODE' => isset($tran_type[1]) ? $tran_type[1] : 0,
                    //'ACCOUNTS_MAPPING_SU_NO_FK' => $request->AccTypeWiseServiceUnit,
                    'MODULE_CODE' => $request->AccPayrollmoduleCode,
                    'MODULE_NO_FK' => $module_info[0]->module_no_pk,
                    'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id,
                    'AU_ENTRY_BY' => $au_entry_by,
                    'AU_ENTRY_AT' => date("Y-m-d"),
                    'STATUS' => 1
                    //'set_patient_val_ind' => isset($request->patient_ind) ? $request->patient_ind : 0,
                    //'set_supplier_val_ind' => isset($request->supplier_ind) ? $request->supplier_ind : 0,
                    //'set_person_val_ind' => isset($request->doctor_ind) ? $request->doctor_ind : 0,
                    //'independent_voucher_ind' => isset($request->independent_voucher_ind) ? $request->independent_voucher_ind : 0
                ]);
            } else {
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('ACCOUNT_PAYROLL_NO_PK_SEQ') + 1;
                DB::table('ACC_INTEGRATION_PAYROLL_LIST')->insert([
                    'INTEGRATIONPAYROLL_NO_PK' => $sysc_pat_no_pk_seq,
                    'TRN_CR_ACCOUNT_NO_FK' => $request->AccPayrollcrAccNo_pk,
                    'TRN_CR_ACCOUNT_PERCENT' => $request->AccPayrollcrAccPar,
                    'TRN_DR_ACCOUNT_NO_FK' => $request->AccPayrolldrAccNo_pk,
                    'TRN_DR_ACCOUNT_PERCENT' => $request->AccPayrolldrAccPar,
                    'PAYROLL_BREAKDOWN_CODE' => $request->SalaryBreakDown,
                    //'TRN_TYPE_NO_FK' => isset($tran_type[0]) ? $tran_type[0] : 0,
                    //'TRN_TYPE_CODE' => isset($tran_type[1]) ? $tran_type[1] : 0,
                    //'ACCOUNTS_MAPPING_SU_NO_FK' => $request->AccTypeWiseServiceUnit,
                    'MODULE_CODE' => $request->AccPayrollmoduleCode,
                    'MODULE_NO_FK' => $module_info[0]->module_no_pk,
                    'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id,
                    'AU_ENTRY_BY' => $au_entry_by,
                    'AU_ENTRY_AT' => date("Y-m-d"),
                    'STATUS' => 1
                    //'set_patient_val_ind' => isset($request->patient_ind) ? $request->patient_ind : 0,
                    //'set_supplier_val_ind' => isset($request->supplier_ind) ? $request->supplier_ind : 0,
                    //'set_person_val_ind' => isset($request->doctor_ind) ? $request->doctor_ind : 0,
                    //'independent_voucher_ind' => isset($request->independent_voucher_ind) ? $request->independent_voucher_ind : 0
                ]);
            }
            DB::commit();

            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }


    //   //costCenter_form_data
    public function storeacostcenter(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'costCenterName' => 'required',
        ]);

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } else {
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('COSTCENTER_NO_PK_SEQ') + 1;
            DB::table('ACC_COSTCENTER_MST')->insert([
                'COSTCENTER_NO_PK' => $sysc_pat_no_pk_seq,
                'COSTCENTER_NAME' => $request->costCenterName,
                'SERVICE_UNIT_NO_FK' => $request->costCenterSerUnitNum,
                'STATUS' => $request->costCenterStatus,
                'COSTCENTER_DESC' => $request->costCenterDescription,
                'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id
            ]);
            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }


    // costCenterChild_form_data
    public function storeacostcenterchild(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'costCenterChildcrAccNo_pk' => 'required',
        ]);

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'error' => $validData->errors()->toArray()]);
        } elseif ($request->costCenterChildcrAccPar > 100   || $request->costCenterChildcrAccPar < 0) {
            return response()->json(['status' => 2]);
        } elseif ($request->costCenterChilddrAccPar > 100   || $request->costCenterChilddrAccPar < 0) {
            return response()->json(['status' => 3]);
        } else {
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('COSTCENTERCHD_NO_PK_SEQ') + 1;
            DB::table('ACC_COSTCENTER_CHD')->insert([
                'COSTCENTERCHD_NO_PK' => $sysc_pat_no_pk_seq,
                'TRN_CR_ACCOUNT_NO_FK' => $request->costCenterChildcrAccNo_pk,
                'TRN_CR_ACCOUNT_PERCENT' => $request->costCenterChildcrAccPar,
                'TRN_DR_ACCOUNT_NO_FK' => $request->costCenterChilddrAccNo_pk,
                'TRN_DR_ACCOUNT_PERCENT' => $request->costCenterChilddrAccPar,
                'MODULE_CODE' => $request->costCenterChildmoduleCode,
                'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id
            ]);
            return response()->json(['status' => 1, 'msg' => 'Data Added Success']);
        }
    }

    public function create()
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }
    public function editAccountTypeWise($id)
    {
        //

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        // $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $acc_type_data = DB::table('acc_accounts_name_wise_vw')->where('integrationtrntypewise_no_pk', $id)->first();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                           ->where('FIN_MAPPING_IND', 1)
                           ->get();
        $chart_of_accounts = DB::table('ACCT_CHART_OF_ACCOUNTS')
            ->select('ACCOUNT_NAME', 'ACCOUNT_CODE', 'ACCOUNT_NO_PK')
            ->where('STATUS', 1)
            ->get();
        //dd(   $acc_type_data);
        return view("admin.accounts.intregration.edit_acc_type_wise_modal", [
            'sysc_module' =>    $sysc_module,
            'finc_trntype' =>    $finc_trntype,
            'acc_type_data' =>    $acc_type_data,
            'service_unit' => $service_unit,
            'chart_of_accounts' => $chart_of_accounts
        ]);
    }


    public function editAccountPayroll($id)
    {
        //

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $salary_lookup_data = DB::table('SYSC_LOOKUPDATA')->whereIn('lookup_no_fk', function($query){
            $query->select('lookup_no_pk')
            ->from('sysc_lookup')
            ->where('lookup_name','SALARYBREAKDOWN');
        })->get();
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $acc_type_data = DB::table('ACC_INTEGRATION_PAYROLLLIST_VW')->where('INTEGRATIONPAYROLL_NO_PK', $id)->first();
        //dd($acc_type_data);
        //dd(   $acc_type_data);
        return view("admin.accounts.intregration.edit_payroll_modal", [
            'sysc_module' =>    $sysc_module,
            'finc_trntype' =>    $finc_trntype,
            'acc_type_data' =>    $acc_type_data,
            'service_unit' => $service_unit,
            'salary_lookup_data' => $salary_lookup_data
        ]);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
    
    public function accTypeWiseData(Request $request)
    {
        //dd($request->all());
        $sql = "";
        if (isset($request->search_trn_type)) {
            $search_trn_type = explode("_", $request->search_trn_type);
            if (!empty($sql)) {
                $sql .= "and trn_type_no_fk = " .  $search_trn_type[0];
            } else {
                $sql .= "where trn_type_no_fk = " .  $search_trn_type[0];
            }
        }
        if (isset($request->search_service_unit)) {
            if (!empty($sql)) {
                $sql .= "and accounts_mapping_su_no_fk = " . $request->search_service_unit;
            } else {
                $sql .= "where accounts_mapping_su_no_fk = " . $request->search_service_unit;
            }
        }
        if (isset($request->module_code)) {
            if (!empty($sql)) {
                $sql .= "and module_code = '" . $request->module_code."'";
            } else {
                $sql .= "where module_code = '" . $request->module_code."'";
            }
        }

        $accTypeWiseData = DB::select(
            "select integrationtrntypewise_no_pk,
             account_name_cr as cr_account_name,
             trn_cr_account_percent,
             account_name_dr as dr_account_name,
             trn_dr_account_percent,
             trn_type_no_fk as tn_name,
             trn_type_code as tc_name,
             module_code,
             serviceunit_name,
             set_patient_val_ind,
             set_supplier_val_ind,
             set_person_val_ind,
             independent_voucher_ind from acc_accounts_name_wise_vw  $sql  "
        );
       // dd( $accTypeWiseData );

        return response()->json([
            'accSearchDataTypeWise' => $accTypeWiseData,
        ]);
    }

    // Accounts v1 method

    public function accountIntegrationV1(){
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $con = 'fin_majorgroup_ind = 1';
        $major_group_item_type = $this->account_setup->get_major_group($con);
        $cond = 'main_store_ind = 1';
        $system_service_unit = $this->chart_of_acc->get_service_unit($cond);
        $condition = '';
        $all_service_unit = $this->chart_of_acc->get_service_unit($condition);
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $cost_center = $this->chart_of_acc->get_cost_center_v1(null);
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        return Template::loadview('admin.accounts.v1.intregration.accounts_intregration_v1', compact('service_unit', 'system_service_unit', 'major_group_item_type', 'sysc_module', 'finc_trntype','voucher_type','general_ledger','all_service_unit','cost_center'));
    }

    public function saveAccountIntegrationV1(Request $request){
        $request->validate([
            'journal_type' => 'required',
            'trn_type' => 'required',
            'store' => 'required',
        ]);
        if(count($request->general_ledger) < 2){
            return response()->json(['success' => false, 'message' => 'Debit and Credit Part Data Required','title' => 'Failed'], 422); 
        };
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            DB::beginTransaction();
            
            $parent_sequence = DB::getSequence();
            $parent_pk_seq = $parent_sequence->nextValue('itemgroupwisemst_no_pk_seq'); 
            $finc_trntype_code = DB::table('finc_trntype')->where('trn_type_no_pk', $request->trn_type)->value('trn_type_code');
            
            $data = [
                'itemgroupwisemst_no_pk' => $parent_pk_seq,
                'itemgroupwisemst_code' => str_pad($parent_pk_seq, 4, "0", STR_PAD_LEFT),
                'store_su_no_fk' => $request->store,
                'voucher_type_no_fk' => $request->journal_type,
                'accounts_mapping_su_no_fk' => $request->service_unit,
                'trn_type_no_fk' => $request->trn_type,
                'trn_type_code' => $finc_trntype_code,
                'status' => 1,
                'active_status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'module_code' => '',
                'module_no_fk' => '',
                'page_seperation_code' =>'GRN',
                'au_entry_hospital_pk_no' => $hospital_pk_no
            ];
            
            DB::table('acc_integrationitemgroupmst')->insert($data);  
            $lastInsertedId = DB::table('acc_integrationitemgroupmst')
                                ->orderBy('itemgroupwisemst_no_pk', 'desc')
                                ->value('itemgroupwisemst_no_pk');                              
            foreach($request->general_ledger as $key => $value){
                $sequence = DB::getSequence();
                $itemgroupwise_no_pk_seq = $sequence->nextValue('itemgroupwisedtl_no_pk_seq'); 
               
                
                $child = [                              
                    'active_status' => 1,
                    'group_itemtype_no_fk' => $request->item_type[$key],                                       
                    'set_supplier_val_ind' => 0,
                    'status' => 1,                             
                    'subledger_ind' => $request->subledger[$key],
                    'costcenter_ind' => $request->costcenter[$key],
                    'costcenter_no_fk' => $request->cost_center[$key],
                    'trn_crdr_type' => $request->dr_cr_type[$key],
                    'trn_dr_cr_account_no_fk' => $request->general_ledger[$key],
                    'trn_dr_cr_account_percent' => $request->percentage[$key],               
                    'itemgroupwisemst_no_fk' => $lastInsertedId               
                ];
                
                if(DB::table('acc_integrationitemgroupdtl')->where($child)->exists()){
                    return response()->json(['success' => false, 'message' => 'Already Exists!'.$child,'title' => 'Failed'], 422);
                }
                $child['itemgroupwisedtl_no_pk'] = $itemgroupwise_no_pk_seq;
                $child['itemgroupwisedtl_code'] = $itemgroupwise_no_pk_seq;
                $child['au_entry_at'] = $au_entry_at;
                $child['au_entry_by'] = Auth::id();
                $child['au_entry_session'] = $entry_session;
                $child['au_entry_hospital_pk_no'] = $hospital_pk_no;
                DB::table('acc_integrationitemgroupdtl')->insert($child);              
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }

    public function updateAccountIntegrationV1(Request $request){
        $request->validate([
            'journal_type' => 'required',
            'trn_type' => 'required',
            'store' => 'required',
        ]);
        if(count($request->general_ledger) < 2){
            return response()->json(['success' => false, 'message' => 'Debit and Credit Part Data Required','title' => 'Failed'], 422); 
        };
        try {
            $au_update_at = Carbon::now();
            $au_update_at = $au_update_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $update_session = Session()->get('user.ses_user_pk_no');
            DB::beginTransaction();

            $itemgroupwisemst_no_pk = $request->itemgroupwisemst_no_pk; 
            $finc_trntype_code = DB::table('finc_trntype')->where('trn_type_no_pk', $request->trn_type)->value('trn_type_code');
            $data = [
                'store_su_no_fk' => $request->store,
                'voucher_type_no_fk' => $request->journal_type,
                'accounts_mapping_su_no_fk' => $request->service_unit,
                'trn_type_no_fk' => $request->trn_type,
                'trn_type_code' => $finc_trntype_code,
                'au_update_at' => $au_update_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $update_session,
                'page_seperation_code' =>'GRN',
                'au_update_hospital_pk_no' => $hospital_pk_no
            ];
            
            DB::table('acc_integrationitemgroupmst')->where('itemgroupwisemst_no_pk',$itemgroupwisemst_no_pk)->update($data);  
            $lastInsertedId = $itemgroupwisemst_no_pk;  
            DB::table('acc_integrationitemgroupdtl')->where( 'itemgroupwisemst_no_fk', $lastInsertedId)->delete();                           
            foreach($request->general_ledger as $key => $value){
                $sequence = DB::getSequence();
                $itemgroupwise_no_pk_seq = $sequence->nextValue('itemgroupwisedtl_no_pk_seq'); 
                
                $child = [                              
                    'active_status' => 1,
                    'group_itemtype_no_fk' => $request->item_type[$key],                                       
                    'set_supplier_val_ind' => 0,
                    'status' => 1,                             
                    'subledger_ind' => $request->subledger[$key],
                    'costcenter_ind' => $request->costcenter[$key],
                    'costcenter_no_fk' => $request->cost_center[$key],
                    'trn_crdr_type' => $request->dr_cr_type[$key],
                    'trn_dr_cr_account_no_fk' => $request->general_ledger[$key],
                    'trn_dr_cr_account_percent' => $request->percentage[$key],               
                    'itemgroupwisemst_no_fk' => $lastInsertedId               
                ];
                
                if(DB::table('acc_integrationitemgroupdtl')->where($child)->exists()){
                    return response()->json(['success' => false, 'message' => 'Already Exists!'.$child,'title' => 'Failed'], 422);
                }
                $child['itemgroupwisedtl_no_pk'] = $itemgroupwise_no_pk_seq;
                $child['itemgroupwisedtl_code'] = $itemgroupwise_no_pk_seq;
                $child['au_update_at'] = $au_update_at;
                $child['au_update_by'] = Auth::id();
                $child['au_update_session'] = $update_session;
                $child['au_update_hospital_pk_no'] = $hospital_pk_no;
                DB::table('acc_integrationitemgroupdtl')->insert($child);              
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Updated','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }

    public function getItemWiseIntegrationV1(){
        $data = $this->account_setup->get_item_wise_accounts_integration();
        return response(['success' =>true,'data'=>$data],200);
    }

    public function editAccountsIntegrationV1($id){

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $con = 'fin_majorgroup_ind = 1';
        $major_group_item_type = $this->account_setup->get_major_group($con);
        $cond = 'main_store_ind = 1';
        $system_service_unit = $this->chart_of_acc->get_service_unit($cond);
        $condition = '';
        $all_service_unit = $this->chart_of_acc->get_service_unit($condition);
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $cost_center = $this->chart_of_acc->get_cost_center_v1(null);
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        $master = $this->account_setup->get_accounts_integration_master_by_id($id);
        $details = $this->account_setup->get_accounts_integration_dtl_by_parent($id);

        if(count($details->getData()->data) == 0 || $master == null){
            return view("admin.components.error_alert");
        }
        else if($master->page_seperation_code != 'GRN'){
            return view("admin.components.error_alert");
        }
        return Template::loadview('admin.accounts.v1.intregration.edit_accounts_intregration_v1', compact('details','master','service_unit', 'system_service_unit', 'major_group_item_type', 'sysc_module', 'finc_trntype','voucher_type','general_ledger','all_service_unit','cost_center'));
    }

    public function accountsIntegrationDetailsV1($id){
      $integration_details = $this->account_setup->get_accounts_integration_details_by_id($id);
      return Template::loadView("admin.accounts.v1.intregration.modal.show_accounts_integration", compact('integration_details'));
    }


    public function manualJournalEntry(){
             
        // try {
            
        //     $row_data_count = DB::table('dl_accounts_jounal_20230828')
        //                         ->select('posting_id','document_date','posting_date')
        //                         ->groupBy('posting_id','document_date','posting_date')
        //                         ->limit(10)
        //                         ->get();
        //     dd($row_data_count);

        //      foreach($row_data_count as $item1){
                    
        //         $au_entry_at = Carbon::now();
        //         $au_entry_at = $au_entry_at->toDateString();
        //         $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        //         $entry_session = Session()->get('user.ses_user_pk_no');
        
        //         $sequence = DB::getSequence();
        //         $journal_master_no_pk = $sequence->nextValue('journalmst_no_pk_seq');          
        //         $module_no = DB::table('sysc_module')->select('module_no_pk')->where('module_code','ACCOUNTS')->first();
                           
        //         $datas = [
        //             'voucher_remarks' => '',
        //             'au_entry_at' => $item1->document_date,
        //             'au_entry_by' => Auth::id(),
        //             'au_entry_session' => $entry_session,
        //             'au_entry_hospital_pk_no' => $hospital_pk_no,
        //             'voucher_type_no_fk' => $data['journal_type'],
        //             'status' => 1,
        //             'journalmst_no_pk' => $journal_master_no_pk,
        //             'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
        //             'dr_account_amount' => $data['total_dr'],
        //             'cr_account_amount' => $data['total_cr'],
        //             'doc_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,
        //             'auto_posting_ind' => 0,
        //             'module_no_fk' => $module_no->module_no_pk
        //         ];
                
        //         DB::beginTransaction();
        //             DB::table('acct_journal_entrymst')->insert($datas);
        //             $lastInsertedId = DB::table('acct_journal_entrymst')
        //                                 ->orderBy('journalmst_no_pk', 'desc')
        //                                 ->value('journalmst_no_pk');                              
                    
                    
        //             $condition = [
        //                     'posting_id'  => $item1->posting_id,
        //                     'document_date'  => $item1->document_date,
        //                     'posting_date'  => $item1->posting_date
        //                 ];
        //             $details = DB::table('dl_accounts_jounal_20230828')
        //                         ->where($condition)
        //                         ->get();
                    
        //             foreach($details as $key => $item){
        //                 $child_sequence = DB::getSequence();
        //                 $journal_child_no_pk = $child_sequence->nextValue('journal_no_pk_seq');
        //                 $trn_account_code = DB::table('acct_chart_of_accounts')->where('account_no_pk',$data['general_ledger'][$key])->select('account_code','cost_center_ind')->first();
                        
        //                 $child_data = [
        //                     'au_entry_at' => $au_entry_at,
        //                     'au_entry_by' => Auth::id(),
        //                     'au_entry_session' => $entry_session,
        //                     'au_entry_hospital_pk_no' => $hospital_pk_no,
        //                     'journal_no_pk' => $journal_child_no_pk,
        //                     'journal_date' => !empty($data['doc_date']) ? date("Y-m-d",strtotime($data['doc_date'])) : null,               
        //                     'voucher_type_no_fk' => $data['journal_type'],
        //                     'trn_account_no_fk' => $data['general_ledger'][$key],
        //                     'trn_account_code' => $trn_account_code->account_code,
        //                     'narration_text' => $data['naration'][$key],
        //                     'auto_posting_ind' => 0,
        //                     'journal_no' => $journal_no,
        //                     'journal_code' => $voucher_no,
        //                     'acct_subledger_no_fk' => $data['sub_ledger_name'][$key] = 0 ? '' :$data['sub_ledger_name'][$key],
        //                     'acct_subledger_type_fk' => $data['sub_ledger_type'][$key] = 0 ? '' :$data['sub_ledger_type'][$key],
        //                     'costcenter_no_fk' => $data['cost_center'][$key] = 0 ? '' :$data['cost_center'][$key],
        //                     'module_no_fk' => $module_no->module_no_pk,                                              
        //                     'voucher_remarks' =>  $data['notes'],
        //                     'person_no_fk' => null,
        //                     'supplier_no_fk' => null, 
        //                     'patient_no_fk' => null, 
        //                     'auto_posting_ref_value' => 0,
        //                     'auto_posting_ref_by' => null,
        //                     'auto_posting_ref_type' => null,
        //                     'verify_req_ind' => 0,
        //                     'verified_ind' => 0,
        //                     'verified_entry_by' => null,
        //                     'verified_entry_at' => null,
        //                     'finalized_ind' => 0,
        //                     'finalized_entry_by' => null,
        //                     'finalized_entry_at' => null,
        //                     'bank_cheq_number' => $data['cheque_no'][$key],
        //                     'bank_cheq_date' => !empty($data['cheque_date'][$key]) ? date("Y-m-d",strtotime($data['cheque_date'][$key])):""
        //                 ];
        //                 if($data['dr_cr_type'][$key] == 'dr'){
        //                     $child_data['trn_dr_account_amount'] = $data['amt_local_curr'][$key];
        //                     $child_data['trn_cr_account_amount'] = 0;
        //                 }
        //                 if($data['dr_cr_type'][$key] == 'cr'){
        //                     $child_data['trn_cr_account_amount'] = $data['amt_local_curr'][$key];
        //                     $child_data['trn_dr_account_amount'] = 0;
        //                 }
                        
    
        //                 if(!DB::table('acct_journal_entry')->where($child_data)->exists()){
        //                     $child_data['journalmst_no_fk'] = $lastInsertedId;
        //                     DB::table('acct_journal_entry')->insert($child_data);
        //                 }
        //             }
                    

                
        //         DB::commit();
        //      }   
        //     return response()->json(['success' => true, 'message' => 'Successfully Saved'], 200);
               
        // } catch (\Exception $th) {
        //     DB::rollBack();
        //     return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        // } 
    }


    // Billing Integration

    public function accountIntegrationBillingV1(){
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $con = 'fin_majorgroup_ind = 1';
        $major_group_item_type = $this->account_setup->get_major_group($con);
        $cond = 'main_store_ind = 1';
        $system_service_unit = $this->chart_of_acc->get_service_unit($cond);
        $condition = '';
        $all_service_unit = $this->chart_of_acc->get_service_unit($condition);
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();


        $module = DB::table('sysc_module')->select('module_no_pk','module_code','module_name','status')->where('status',1)
                    ->orderByRaw('lower(module_name) asc')
                    ->get();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        return Template::loadview('admin.accounts.v1.intregration.billing.accounts_billing_intregration_v1', compact('service_unit', 'system_service_unit', 'major_group_item_type', 'sysc_module', 'finc_trntype','voucher_type','general_ledger','all_service_unit','module'));
    }

    public function saveAccountIntegrationBillingV1(Request $request){
        $request->validate([
            'journal_type' => 'required',
            'trn_type' => 'required',
            'store' => 'required',
            'module' => 'required',
        ]);
        if(count($request->general_ledger) < 2){
            return response()->json(['success' => false, 'message' => 'Debit and Credit Part Data Required','title' => 'Failed'], 422); 
        };
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            DB::beginTransaction();
            
            $parent_sequence = DB::getSequence();
            $parent_pk_seq = $parent_sequence->nextValue('itemgroupwisemst_no_pk_seq'); 
            $finc_trntype_code = DB::table('finc_trntype')->where('trn_type_no_pk', $request->trn_type)->value('trn_type_code');
            $module_code = DB::table('sysc_module')->where('module_no_pk', $request->module)->value('module_code');
            $data = [
                'itemgroupwisemst_no_pk' => $parent_pk_seq,
                'itemgroupwisemst_code' => str_pad($parent_pk_seq, 4, "0", STR_PAD_LEFT),
                'store_su_no_fk' => $request->store,
                'voucher_type_no_fk' => $request->journal_type,
                'accounts_mapping_su_no_fk' => $request->service_unit,
                'trn_type_no_fk' => $request->trn_type,
                'trn_type_code' => $finc_trntype_code,
                'status' => 1,
                'active_status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'module_code' => $module_code,
                'module_no_fk' => $request->module,
                'page_seperation_code' =>'BILLING',
                'au_entry_hospital_pk_no' => $hospital_pk_no
            ];
            
            DB::table('acc_integrationitemgroupmst')->insert($data);  
            $lastInsertedId = DB::table('acc_integrationitemgroupmst')
                                ->orderBy('itemgroupwisemst_no_pk', 'desc')
                                ->value('itemgroupwisemst_no_pk');                              
            foreach($request->general_ledger as $key => $value){
                $sequence = DB::getSequence();
                $itemgroupwise_no_pk_seq = $sequence->nextValue('itemgroupwisedtl_no_pk_seq'); 
               
                
                $child = [                              
                    'active_status' => 1,
                    'group_itemtype_no_fk' => $request->item_type[$key],                                       
                    'set_supplier_val_ind' => 0,
                    'status' => 1,                             
                    'trn_crdr_type' => $request->dr_cr_type[$key],
                    'trn_dr_cr_account_no_fk' => $request->general_ledger[$key],
                    'trn_dr_cr_account_percent' => $request->percentage[$key],               
                    'itemgroupwisemst_no_fk' => $lastInsertedId               
                ];
                
                if(DB::table('acc_integrationitemgroupdtl')->where($child)->exists()){
                    return response()->json(['success' => false, 'message' => 'Already Exists!'.$child,'title' => 'Failed'], 422);
                }
                $child['itemgroupwisedtl_no_pk'] = $itemgroupwise_no_pk_seq;
                $child['itemgroupwisedtl_code'] = $itemgroupwise_no_pk_seq;
                $child['au_entry_at'] = $au_entry_at;
                $child['au_entry_by'] = Auth::id();
                $child['au_entry_session'] = $entry_session;
                $child['au_entry_hospital_pk_no'] = $hospital_pk_no;
                DB::table('acc_integrationitemgroupdtl')->insert($child);              
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }

    public function getItemWiseIntegrationBillingV1(){
        $data = $this->account_setup->get_item_wise_accounts_integration_billing();
        return response(['success' =>true,'data'=>$data],200);
    }

    public function accountsIntegrationDetailsBillingV1($id){
        $integration_details = $this->account_setup->get_accounts_integration_details_by_id($id);
        return Template::loadView("admin.accounts.v1.intregration.billing.modal.show_accounts_integration_billing", compact('integration_details'));
    }


    public function editAccountsIntegrationBillingV1($id){

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $con = 'fin_majorgroup_ind = 1';
        $major_group_item_type = $this->account_setup->get_major_group($con);
        $cond = 'main_store_ind = 1';
        $system_service_unit = $this->chart_of_acc->get_service_unit($cond);
        $condition = '';
        $all_service_unit = $this->chart_of_acc->get_service_unit($condition);
        $sysc_module = DB::table('SYSC_MODULE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $finc_trntype = DB::table('FINC_TRNTYPE')->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $module = DB::table('sysc_module')->select('module_no_pk','module_code','module_name','status')->where('status',1)
                    ->orderByRaw('lower(module_name) asc')
                    ->get();
        $voucher_type = $this->voucher_type->get_voucher_type_v1();
        $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
        $master = $this->account_setup->get_accounts_integration_master_by_id($id);
        $details = $this->account_setup->get_accounts_integration_dtl_by_parent($id);

        if(count($details->getData()->data) == 0 || $master == null){
            return view("admin.components.error_alert");
        }
        else if($master->page_seperation_code != 'BILLING'){
            return view("admin.components.error_alert");
        }
        
        return Template::loadview('admin.accounts.v1.intregration.billing.edit_accounts_intregration_v1_billing', compact('details','master','service_unit', 'system_service_unit', 'major_group_item_type', 'sysc_module', 'finc_trntype','voucher_type','general_ledger','all_service_unit','module'));
    }

    public function updateAccountIntegrationBillingV1(Request $request){
        $request->validate([
            'journal_type' => 'required',
            'trn_type' => 'required',
            'store' => 'required',
            'module' => 'required'
        ]);

        if(count($request->general_ledger) < 2){
            return response()->json(['success' => false, 'message' => 'Debit and Credit Part Data Required','title' => 'Failed'], 422); 
        };

        try {
            $au_update_at = Carbon::now();
            $au_update_at = $au_update_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $update_session = Session()->get('user.ses_user_pk_no');
            DB::beginTransaction();

            $itemgroupwisemst_no_pk = $request->itemgroupwisemst_no_pk; 
            $finc_trntype_code = DB::table('finc_trntype')->where('trn_type_no_pk', $request->trn_type)->value('trn_type_code');
            $module_code = DB::table('sysc_module')->where('module_no_pk', $request->module)->value('module_code');
            $data = [
                'store_su_no_fk' => $request->store,
                'voucher_type_no_fk' => $request->journal_type,
                'accounts_mapping_su_no_fk' => $request->service_unit,
                'trn_type_no_fk' => $request->trn_type,
                'trn_type_code' => $finc_trntype_code,
                'au_update_at' => $au_update_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $update_session,
                'page_seperation_code' =>'BILLING',
                'module_code' => $module_code,
                'module_no_fk' => $request->module,
                'au_update_hospital_pk_no' => $hospital_pk_no
            ];
            
            DB::table('acc_integrationitemgroupmst')->where('itemgroupwisemst_no_pk',$itemgroupwisemst_no_pk)->update($data);  
            $lastInsertedId = $itemgroupwisemst_no_pk;  
            DB::table('acc_integrationitemgroupdtl')->where( 'itemgroupwisemst_no_fk', $lastInsertedId)->delete();                           
            foreach($request->general_ledger as $key => $value){
                $sequence = DB::getSequence();
                $itemgroupwise_no_pk_seq = $sequence->nextValue('itemgroupwisedtl_no_pk_seq'); 
                
                $child = [                              
                    'active_status' => 1,
                    'group_itemtype_no_fk' => $request->item_type[$key],                                       
                    'set_supplier_val_ind' => 0,
                    'status' => 1,                             
                    'trn_crdr_type' => $request->dr_cr_type[$key],
                    'trn_dr_cr_account_no_fk' => $request->general_ledger[$key],
                    'trn_dr_cr_account_percent' => $request->percentage[$key],               
                    'itemgroupwisemst_no_fk' => $lastInsertedId               
                ];
                
                if(DB::table('acc_integrationitemgroupdtl')->where($child)->exists()){
                    return response()->json(['success' => false, 'message' => 'Already Exists!'.$child,'title' => 'Failed'], 422);
                }
                $child['itemgroupwisedtl_no_pk'] = $itemgroupwise_no_pk_seq;
                $child['itemgroupwisedtl_code'] = $itemgroupwise_no_pk_seq;
                $child['au_update_at'] = $au_update_at;
                $child['au_update_by'] = Auth::id();
                $child['au_update_session'] = $update_session;
                $child['au_update_hospital_pk_no'] = $hospital_pk_no;
                DB::table('acc_integrationitemgroupdtl')->insert($child);              
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Updated','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }
}