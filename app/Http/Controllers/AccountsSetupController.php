<?php

namespace App\Http\Controllers;

use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\Supplier\Supplier;
use App\Core\Accounts\PatientInfo\Patient;
use App\Core\Accounts\EmployeeInfo\Employee;
use App\Core\Accounts\AccountType\AccountType;
use App\Core\Accounts\VoucherType\VoucherType;
use App\Core\Accounts\AccountSetup\AccountSetup;
use App\Core\Accounts\VoucherEntry\VoucherEntry;
use App\Core\Accounts\AccountsBalance\AccountsBalance;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use App\Core\Accounts\CashFlowCategory\CashFlowCategory;

class AccountsSetupController extends Controller
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

    public function fiscalYearV1()
    {
        return template::loadview('admin.accounts.v1.settings.fiscal_year_v1');
    }

    public function getfiscalYearV1(){
      $fiscal_year = $this->account_setup->get_fiscal_year();

        if(count($fiscal_year->getData()->data) == 0){
            return response()->json(["success" => true, "data" => [] ],200);
        }

        return response()->json(["success" => true, "data" => $fiscal_year->getData()->data ],200);
    }

    public function savefiscalYearV1(Request $request){

      $request->validate([
        'start_date' => 'required',
        'end_date'   => 'required'
      ]);

      $start_date = DateTime::createFromFormat('d/m/Y', $request->start_date);
      $start_date = $start_date->format('m/d/Y');

      $end_date = DateTime::createFromFormat('d/m/Y', $request->end_date);
      $end_date = $end_date->format('m/d/Y');

      return $this->account_setup->save_fiscal_year([
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => $request->status,
        'default' => $request->default,
      ]);
    }

    public function editFiscalYearV1($id){
      $data = DB::table('acct_fiscalyear')
                    ->where('fiscalyear_no_pk',$id)
                    ->select('fiscalyear_no_pk','status','default_ind','current_fiscal_year_ind')
                    ->selectRaw("TO_CHAR(start_date, 'DD/MM/YYYY') as start_date, TO_CHAR(end_date, 'DD/MM/YYYY') as end_date")
                    ->first();
        if($data->current_fiscal_year_ind == 1){
          return Template::loadView("admin.accounts.v1.settings.modal.edit_fiscal_year", ['data' => $data]);
        }
        else{
          return Template::loadView('admin.components.error_alert');
        }
    }

    public function updatefiscalYearV1(Request $request){
      $request->validate([
        'start_date_modal' => 'required',
        'end_date_modal'   => 'required'
      ]);

      $start_date = DateTime::createFromFormat('d/m/Y', $request->start_date_modal);
      $start_date = $start_date->format('m/d/Y');

      $end_date = DateTime::createFromFormat('d/m/Y', $request->end_date_modal);
      $end_date = $end_date->format('m/d/Y');
      return $this->account_setup->update_fiscal_year([
        'fiscalyear_no_pk' => $request->fiscalyear_no_pk,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => $request->status_modal,
        'current_fiscal_year_ind' => $request->current_fiscal_year_ind,
      ]);
    }

    public function fiscalMonthV1()
    {
        return template::loadview('admin.accounts.v1.settings.fiscal_month_v1');
    }

    public function getfiscalMonthV1(){
      $fiscal_month = $this->account_setup->get_fiscal_month();

        if(count($fiscal_month->getData()->data) == 0){
            return response()->json(["success" => true, "data" => [] ],200);
        }

        return response()->json(["success" => true, "data" => $fiscal_month->getData()->data ],200);
    }

    public function savefiscalMonthV1(Request $request){

      $request->validate([
        'start_date' => 'required',
        'end_date'   => 'required'
      ]);

      $start_date = DateTime::createFromFormat('d/m/Y', $request->start_date);
      $start_date = $start_date->format('m/d/Y');

      $end_date = DateTime::createFromFormat('d/m/Y', $request->end_date);
      $end_date = $end_date->format('m/d/Y');

      return $this->account_setup->save_fiscal_month([
        'start_date' => $start_date,
        'end_date' => $end_date,
        'closing_type' => $request->closing_type,
        'status' => $request->status,
      ]);

    }

    public function editFiscalMonthV1($id){
      $data = DB::table('acct_fiscalmonth')
                  ->where('fiscalmonth_no_pk',$id)
                  ->select('fiscalmonth_no_pk','status','default_ind','closing_type')
                  ->selectRaw("TO_CHAR(start_date, 'DD/MM/YYYY') as start_date, TO_CHAR(end_date, 'DD/MM/YYYY') as end_date")
                  ->first();
        return Template::loadView("admin.accounts.v1.settings.modal.edit_fiscal_month", ['data' => $data]);
    }

    public function updatefiscalMonthV1(Request $request){
      $request->validate([
        'start_date_modal' => 'required',
        'end_date_modal'   => 'required'
      ]);

      $start_date = DateTime::createFromFormat('d/m/Y', $request->start_date_modal);
      $start_date = $start_date->format('m/d/Y');

      $end_date = DateTime::createFromFormat('d/m/Y', $request->end_date_modal);
      $end_date = $end_date->format('m/d/Y');

      return $this->account_setup->update_fiscal_month([
        'fiscalmonth_no_pk' => $request->fiscalmonth_no_pk,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => $request->status_modal,
        'closing_type' => $request->closing_type,
        'default' => $request->default_modal,
      ]);
    }

    public function accountsGroupV1(){
      return template::loadview('admin.accounts.v1.settings.accounts_group_v1');
    }

    public function saveAccountsGroup(Request $request){

      $request->validate([
            'account_group_name' => 'required|max:200',
            'account_group_code' => 'required|max:50',
            'start_range'            => 'max:10',
            'end_range'            => 'max:10',
            'notes'            => 'max:500',
        ]);

        $save_account_group = $this->account_setup->save_account_group([
                'status' => $request->status,
                'start_range' => $request->start_range,
                'end_range' => $request->end_range,
                'account_group_name' =>$request->account_group_name,
                'account_group_code' =>$request->account_group_code,
                'notes' =>$request->notes,
        ]);

        return $save_account_group;
    }

    public function getAccountsGroupV1(){
        $get_account_group = $this->account_setup->get_accounts_group_v1();

        if(count($get_account_group->getData()->data) == 0){
            return response()->json(["success" => false, "data" => [] ],200);
        }

        return response()->json(["success" => false, "data" => $get_account_group->getData()->data ],200);
    }

    public function editAccountsGroup($id){

        $get_account_group = $this->account_setup->get_accounts_group_by_id($id);
        return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_group_name", ['data' => $get_account_group]);
    }

    public function updateAccountsGroup(Request $request){
        $request->validate([
            'account_group_name' => 'required|max:200',
            'account_group_code' => 'required|max:50',
            'start_range'            => 'max:10',
            'end_range'            => 'max:10',
            'notes'            => 'max:500',
        ]);

        $update_account_group = $this->account_setup->update_account_group([
            'status' => $request->status,
            'start_range' => $request->start_range,
            'end_range' => $request->end_range,
            'account_group_name' =>$request->account_group_name,
            'account_group_code' =>$request->account_group_code,
            'acc_1group_no_pk' =>$request->acc_1group_no_pk,
            'notes' =>$request->notes,
        ]);

        return $update_account_group;
    }

    public function accountsSubGroupV1(){
        $account_group = $this->account_setup->get_accounts_group_v1();
        return template::loadview('admin.accounts.v1.settings.accounts_sub_group_v1', compact('account_group'));
    }

    public function saveAccountsSubGroup(Request $request){

      $request->validate([
            'account_group_fk' => 'required',
            'account_sub_group_name' => 'required|max:200',
            'account_sub_group_code' => 'required|max:50',
            'start_range'            => 'max:10',
            'end_range'            => 'max:10',
            'notes'            => 'max:500',
        ]);

        $save_account_sub_group = $this->account_setup->save_account_sub_group([
                'status' => $request->status,
                'start_range' => $request->start_range,
                'end_range' => $request->end_range,
                'account_group_fk' => $request->account_group_fk,
                'account_sub_group_name' =>$request->account_sub_group_name,
                'account_sub_group_code' =>$request->account_sub_group_code,
                'notes' =>$request->notes,
        ]);

        return $save_account_sub_group;
    }

    public function getAccountsSubGroupV1(){
      $get_account_group = $this->account_setup->get_accounts_sub_group_v1();

      if(count($get_account_group->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $get_account_group->getData()->data ],200);
    }

    public function editAccountsSubGroup($id){

      $get_account_sub_group = $this->account_setup->get_accounts_sub_group_by_id($id);
      $account_group = $this->account_setup->get_accounts_group_v1();
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_sub_group_name", ['data' => $get_account_sub_group, 'account_group' => $account_group]);
    }

    public function updateAccountsSubGroup(Request $request){
        $request->validate([
            'account_group_fk' => 'required',
            'acc_2subgroup_no_pk' => 'required',
            'account_sub_group_name' => 'required|max:200',
            'account_sub_group_code' => 'required|max:50',
            'start_range'            => 'max:10',
            'end_range'            => 'max:10',
            'notes'            => 'max:500',
        ]);

      $save_account_sub_group = $this->account_setup->update_account_sub_group([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'account_group_fk' => $request->account_group_fk,
              'account_sub_group_name' =>$request->account_sub_group_name,
              'account_sub_group_code' =>$request->account_sub_group_code,
              'notes' =>$request->notes,
              'acc_2subgroup_no_pk' =>$request->acc_2subgroup_no_pk
        ]);

        return $save_account_sub_group;
    }

    public function accountsGroupTypeV1(){
      $account_sub_group = $this->account_setup->get_accounts_sub_group_v1();
      return template::loadview('admin.accounts.v1.settings.accounts_group_type_v1', compact('account_sub_group'));
    }

    public function saveAccountsGroupType(Request $request){

      $request->validate([
          'account_sub_group_fk' => 'required',
          'account_group_type_name' => 'required|max:200',
          'account_group_type_code' => 'required|max:50',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $save_account_group_type = $this->account_setup->save_account_group_type([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'account_sub_group_fk' => $request->account_sub_group_fk,
              'account_group_type_name' =>$request->account_group_type_name,
              'account_group_type_code' =>$request->account_group_type_code,
              'notes' =>$request->notes,
      ]);

      return $save_account_group_type;
    }

    public function getAccountsGroupTypeV1(){
      $get_account_group_type = $this->account_setup->get_accounts_group_type_v1();

      if(count($get_account_group_type->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $get_account_group_type->getData()->data ],200);
    }

    public function editAccountsGroupType($id){

      $get_account_group_type = $this->account_setup->get_accounts_group_type_by_id($id);
      $account_sub_group = $this->account_setup->get_accounts_sub_group_v1();
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_group_type", ['data' => $get_account_group_type, 'account_sub_group' => $account_sub_group]);
    }

    public function updateAccountsGroupType(Request $request){
      $request->validate([
          'account_sub_group_fk' => 'required',
          'acc_3grouptype_no_pk' => 'required',
          'account_group_type_name' => 'required|max:200',
          'account_group_type_code' => 'required|max:50',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $update_account_group_type = $this->account_setup->update_account_group_type([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'account_sub_group_fk' => $request->account_sub_group_fk,
              'acc_3grouptype_no_pk' => $request->acc_3grouptype_no_pk,
              'account_group_type_name' =>$request->account_group_type_name,
              'account_group_type_code' =>$request->account_group_type_code,
              'notes' =>$request->notes,
      ]);

      return $update_account_group_type;
    }
    
    // doctor share setup start
    public function doctorShare(){

      $item_type = DB::table('sysc_serviceitem as a')
        ->join('sysc_itemtype as b', 'a.itemtype_no_fk', '=', 'b.itemtype_no_pk')
        ->select('b.itemtype_no_pk', 'b.item_type_name')
        ->distinct()
        ->get();

      return template::loadview('admin.accounts.v1.settings.doctor_share', compact('item_type'));
    }


    public function getDoctorShare(){
      $get_doctor_share = $this->account_setup->get_doctor_share();

      if(count($get_doctor_share->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $get_doctor_share->getData()->data ],200);
    }

    public function saveDoctorShare(Request $request){

      $request->validate([
          'hdn_doctor_id' => 'required',
          'itemtype_no_fk' => 'required',
          'share_per' => 'required|max:100|min:0',
          'start_date'            => 'required',
          // 'end_date'            => 'max:10',
          // 'status'            => 'required',
      ]);

      $save_doctor_share = $this->account_setup->save_doctor_share([
              'person_no_fk' => $request->hdn_doctor_id,
              'itemtype_no_fk' => $request->itemtype_no_fk,
              'share_per' => $request->share_per,
              'start_date' => $request->start_date,
              // 'end_date' =>$request->end_date,
              'status' =>$request->status,
      ]);

      return $save_doctor_share;
    }


    public function editDoctorShare($id){
      $item_type = DB::table('sysc_serviceitem as a')
        ->join('sysc_itemtype as b', 'a.itemtype_no_fk', '=', 'b.itemtype_no_pk')
        ->select('b.itemtype_no_pk', 'b.item_type_name')
        ->distinct()
        ->get();
      $get_doctor_share = $this->account_setup->get_doctor_share_by_id($id);
      return Template::loadView("admin.accounts.v1.settings.modal.edit_doctor_share", ['data' => $get_doctor_share, 'item_type' => $item_type]);
    }

    public function updateDoctorShare(Request $request){
      // dd($request->all());
        $request->validate([
          'hdn_doctor_id_m' => 'required',
          'itemtype_no_fk' => 'required',
          'share_per' => 'required|max:100|min:0',
          'start_date'            => 'required',
          // 'end_date'            => 'max:10',
          // 'status'            => 'required',
      ]);

      $update_doctor_share = $this->account_setup->update_doctor_share([
        'person_no_fk' => $request->hdn_doctor_id_m,
        'itemtype_no_fk' => $request->itemtype_no_fk,
        'share_per' => $request->share_per,
        'start_date' => $request->start_date,
        // 'end_date' =>$request->end_date,
        'status' =>$request->status,
        'doctorfeemst_no_pk' =>$request->doctorfeemst_no_pk
      ]);

      return $update_doctor_share;
    }

    // doctor share setup end




    public function accountsTypeV1(){
      $account_group_type = $this->account_setup->get_accounts_group_type_v1();
      return template::loadview('admin.accounts.v1.settings.accounts_type_v1', compact('account_group_type'));
    }

    public function saveAccountsType(Request $request){

      $request->validate([
          'account_group_type_fk' => 'required',
          'account_type_name' => 'required|max:200',
          'account_type_code' => 'required|max:50',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $save_account_type = $this->account_setup->save_account_type([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'account_group_type_fk' => $request->account_group_type_fk,
              'account_type_name' =>$request->account_type_name,
              'account_type_code' =>$request->account_type_code,
              'notes' =>$request->notes,
      ]);

      return $save_account_type;
    }

    public function getAccountsTypeV1(){
      $get_account_type = $this->account_setup->get_accounts_type_v1();

      if(count($get_account_type->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $get_account_type->getData()->data ],200);
    }

    public function editAccountsType($id){

      $get_account_type = $this->account_setup->get_accounts_type_by_id($id);
      $account_group_type = $this->account_setup->get_accounts_group_type_v1();
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_type", ['data' => $get_account_type, 'account_group_type' => $account_group_type]);
    }

    public function updateAccountsType(Request $request){
      $request->validate([
          'account_group_type_fk' => 'required',
          'acc_4type_no_pk' => 'required',
          'account_type_name' => 'required|max:200',
          'account_type_code' => 'required|max:50',
          // 'description' => 'required|max:500',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $update_account_type = $this->account_setup->update_account_type([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              // 'description' => $request->description,
              'account_group_type_fk' => $request->account_group_type_fk,
              'acc_4type_no_pk' => $request->acc_4type_no_pk,
              'account_type_name' =>$request->account_type_name,
              'account_type_code' =>$request->account_type_code,
              'notes' =>$request->notes,
      ]);

      return $update_account_type;
    }

    public function accountsDescriptionV1(){
      $account_type = $this->account_setup->get_accounts_type_v1();
      return template::loadview('admin.accounts.v1.settings.accounts_description_v1', compact('account_type'));
    }


    public function saveAccountsDescription(Request $request){

      $request->validate([
          'acc_4type_no_fk' => 'required',
          'account_description_name' => 'required|max:200',
          'account_description_code' => 'required|max:50',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $save_account_description = $this->account_setup->save_account_description([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'acc_4type_no_fk' => $request->acc_4type_no_fk,
              'account_description_name' =>$request->account_description_name,
              'account_description_code' =>$request->account_description_code,
              'notes' =>$request->notes,
      ]);

      return $save_account_description;
    }

    public function getAccountsDescriptionV1(){
      $get_account_description = $this->account_setup->get_accounts_description_v1();

      if(count($get_account_description->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $get_account_description->getData()->data ],200);
    }

    public function editAccountsDescription($id){

      $get_account_description = $this->account_setup->get_accounts_by_id($id);
      $account_accounts_type = $this->account_setup->get_accounts_type_v1();
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_description", ['data' => $get_account_description, 'account_accounts_type' => $account_accounts_type]);
    }



    public function updateAccountsDescription(Request $request){
      $request->validate([
          'acc_4type_no_fk' => 'required',
          'acc_5typedescription_no_pk' => 'required',
          'account_description_name' => 'required|max:200',
          'account_description_code' => 'required|max:50',
          'start_range'            => 'max:10',
          'end_range'            => 'max:10',
          'notes'            => 'max:500',
      ]);

      $update_account_description = $this->account_setup->update_account_description([
              'status' => $request->status,
              'start_range' => $request->start_range,
              'end_range' => $request->end_range,
              'acc_4type_no_fk' => $request->acc_4type_no_fk,
              'acc_5typedescription_no_pk' => $request->acc_5typedescription_no_pk,
              'account_description_name' =>$request->account_description_name,
              'account_description_code' =>$request->account_description_code,
              'notes' =>$request->notes,
      ]);

      return $update_account_description;
    }

    public function journalTypeV1()
    {
        return Template::loadview('admin.accounts.v1.settings.journal_type_v1');
    }


    public function accountsGeneralLedgerEntryV1(){
      $get_account_description = $this->account_setup->get_accounts_description_v1();
      return Template::loadView('admin.accounts.v1.settings.general_ledger_entry_v1',compact('get_account_description'));
    }

    public function getAccountsGeneralLedgerEntryV1(){
      $gl_list = $this->chart_of_acc->get_gl_list_by_description('all');

      if(count($gl_list->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => true, "data" => $gl_list->getData()->data ],200);
    }


    public function getGLCodeV1($id){

      $account_description = $this->account_setup->get_accounts_by_id($id);
      $gl_list = $this->chart_of_acc->get_gl_list_by_description($id);
      $desc_start_range = $account_description->acc_code_range_5_start;
      $desc_end_range = $account_description->acc_code_range_5_end;

      $total_gl = count($gl_list->getData()->data);
      $new_gl_code = intVal($desc_start_range) + intVal($total_gl) + 1;
      $exist_code_array = collect($gl_list->getData()->data)->pluck('account_code')->toArray();
      $check_exist = $this->generateGLCode($exist_code_array,$new_gl_code);
      if(!empty($desc_start_range) && !empty($desc_end_range)){

        return response()->json(['code'=>$check_exist,'eligible' => true,'Success' => true],200);
          // if($check_exist > $desc_end_range){
          //   return response()->json(['code'=>$check_exist,'eligible' => false,'Success' => true,'message' => 'End Range Exceded'],422);
          // }
          // else if($check_exist >= $desc_start_range  && $check_exist <= $desc_end_range){
          //   return response()->json(['code'=>$check_exist,'eligible' => true,'Success' => true],200);
          // }
          // else{
          //   return response()->json(['code'=>$check_exist,'eligible' => false,'Success' => true,'message' => 'Start Range Exceded'],422);
          // }
      }
      else{
        return response()->json(['code'=> str_pad($check_exist, 6, "0", STR_PAD_LEFT),'eligible' => true,'Success' => true],200);
      }


    }

    public function generateGLCode($exist_code_array, $new_gl_code){

        if(!in_array($new_gl_code, $exist_code_array)){
          return $new_gl_code;
        }
        else{
         return $this->generateGLCode($exist_code_array,$new_gl_code + 1);
        }
    }

    public function saveAccountsGeneralLedgerEntryV1(Request $request){

      $request->validate([
          'accName' => 'required|max:200',
          'accDescription' => 'required',
          'accCode' => 'required|max:20'
        ]);

      try {

          $au_entry_at = Carbon::now();
          $au_entry_at = $au_entry_at->toDateString();
          $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
          $entry_session = Session()->get('user.ses_user_pk_no');

          /*range check*/
            $range_data = DB::table('acc_coa_5accountdescription')->where('acc_5typedescription_no_pk', $request->accDescription)->select('acc_code_range_5_start','acc_code_range_5_end')->first();

            // if($range_data->acc_code_range_5_start != null && $range_data->acc_code_range_5_end != null){
            //     if($request->accCode < $range_data->acc_code_range_5_start || $request->accCode > $range_data->acc_code_range_5_end){
            //         return response()->json(['success' => false, 'message' => "GL Code Not Eligible. Please give between ".$range_data->acc_code_range_5_start." and ".$range_data->acc_code_range_5_end ,'title' => 'Error'],422);
            //     }
            // }
            /*range check*/
            $sequence = DB::getSequence();

            $account_no_pk_seq = $sequence->nextValue('account_no_pk_seq');
            $account_name = Str::upper($request->accName);
          $data = [
              "account_no_pk" => $account_no_pk_seq,
              "account_name" => $account_name,
              "account_code" => $request->accCode,
              "control_acc_ind" => $request->controlAccount,
              "cost_center_ind" => $request->costCenter,
              "bank_ind"        => $request->bank,
              "status"        => $request->status,
              "recurring_cost_ind" => $request->recurringCost,
              "depreciation_ind" => $request->depreciation,
              "posting_head_ind" => 1,
              "default_dr_cr" => $request->default_dr_cr,
              'au_entry_at' => $au_entry_at,
              'au_entry_by' => Auth::id(),
              'au_entry_session' => $entry_session,
              'au_entry_hospital_pk_no' => $hospital_pk_no,
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
                $data['bal_inc_tag'] = 'TAXEXPENSE';
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









          if(DB::table('acct_chart_of_accounts')->where('account_code', $request->accCode)->exists()){
                return response()->json(['success' => false,'message' => 'GL Code Already Exists'],422);
            }
          DB::table('acct_chart_of_accounts')->insert($data);
           $gl_list = $this->chart_of_acc->get_gl_list_by_description('all');
          return response()->json([
              "title"   => 'Success',
              "success" => true,
              "message" => "Successfully Saved",
              "code" => 200,
              "data" => $gl_list->getData()->data
              ],200);

      } catch (\Throwable $th) {
          return response()->json([
              "title"   => 'Failed',
              "success" => false,
              "message" => $th->getMessage()
          ],422);
      }
    }


    public function accountsOpeningBalanceV1(){
       $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
       $fiscal_year = $this->account_setup->get_fiscal_year();
        return template::loadview('admin.accounts.v1.settings.accounts_opening_balance_v1', compact('general_ledger','fiscal_year'));
    }

    public function getAccountsOpeningBalanceV1(){
      $opening_balance_list = $this->account_setup->get_accounts_prev_opening_balance_v1();

      if(count($opening_balance_list->getData()->data) == 0){
          return response()->json(["success" => false, "data" => [] ],200);
      }

      return response()->json(["success" => false, "data" => $opening_balance_list->getData()->data ],200);
    }

    public function saveAccountsOpeningBalance(Request $request){
      $request->validate([
        'account_no_pk' => 'required',
        'fiscal_year' => 'required',

      ]);

      try {

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $sequence = DB::getSequence();
        $opening_bal_pk_seq = $sequence->nextValue('opbal_no_pk_seq');
        $cof = DB::table('acct_chart_of_accounts')->select('account_code','income_exp_type')->where('account_no_pk',$request->account_no_pk)->first();

        if(!isset($cof->account_code) && !isset($cof->income_exp_type)){
          return response()->json(["title"   => 'Failed',"success" => false,"message" => 'Account Code Does not Exist'],422);
        }


        $obal_year = substr($request->from_date, -4).'-'.substr($request->to_date, -4);
        $data = [
          'trn_account_no_fk' => $request->account_no_pk,
          'fiscal_year_fk' => $request->fiscal_year,
          'trn_account_code' => $cof->account_code,
        ];

        if(DB::table('acct_openingbalance')->where($data)->exists()){
          return response()->json(["title"   => 'Failed',"success" => false,"message" => 'Already Exists'],422);
        }

        $data['opbal_no_pk'] = $opening_bal_pk_seq;
        $data['opbal_code'] = $opening_bal_pk_seq;
        $data['opbal_date'] = $au_entry_at;
        $data['trn_cr_account_amount'] = $request->trn_cr_account_amount;
        $data['trn_dr_account_amount'] = $request->trn_dr_account_amount;
        $data['au_entry_at'] = $au_entry_at;
        $data['au_entry_by'] = Auth::id();
        $data['au_entry_session'] = $entry_session;
        $data['au_entry_hospital_pk_no'] = $hospital_pk_no;
        $data['status'] = $request->status;
        $data['narration_text'] = $request->note;

        if($cof->income_exp_type == 'INCOME' || $cof->income_exp_type == 'EXPENSES'){
          $data['retained_earnings_ind'] = 1;
        }
        else{
          $data['retained_earnings_ind'] = 0;
        }

        DB::table('acct_openingbalance')->insert($data);

        $opening_balance_list = $this->account_setup->get_accounts_prev_opening_balance_v1();
        return response()->json([
          "title"   => 'Success',
          "success" => true,
          "message" => "Successfully Saved",
          "data" => $opening_balance_list->getData()->data
          ],200);
      } catch (\Throwable $th) {
          return response()->json([
            "title"   => 'Failed',
            "success" => false,
            "message" => $th->getMessage()
        ],422);
      }
    }

    public function editAccountsOpeningBalance($id){

      $data = $this->account_setup->get_opening_balance_by_id($id);
      $general_ledger = $this->chart_of_acc->get_accounts_levelV1();
      $fiscal_year = $this->account_setup->get_fiscal_year();
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_opening_balance", ['data' => $data, 'general_ledger' => $general_ledger, 'fiscal_year' => $fiscal_year]);
    }

    public function updateAccountsOpeningBalance(Request $request){
      $request->validate([
        'account_no_pk' => 'required',
        'fiscal_year' => 'required',
      ]);

      try {

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        $opbal_no_pk = $request->opbal_no_pk;
        $cof = DB::table('acct_chart_of_accounts')->select('account_code','income_exp_type')->where('account_no_pk',$request->account_no_pk)->first();

        if(!isset($cof->account_code) && !isset($cof->income_exp_type)){
          return response()->json(["title"   => 'Failed',"success" => false,"message" => 'Account Code Does not Exist'],422);
        }

        $obal_year = substr($request->from_date, -4).'-'.substr($request->to_date, -4);
        $data = [
          'trn_account_no_fk' => $request->account_no_pk,
          'trn_account_code' => $cof->account_code,
          'fiscal_year_fk' => $request->fiscal_year,
        ];

        if(DB::table('acct_openingbalance')->where($data)->where('opbal_no_pk','!=', $opbal_no_pk)->exists()){
          return response()->json(["title"   => 'Failed',"success" => false,"message" => 'Already Exists'],422);
        }

        $data['opbal_no_pk'] = $opbal_no_pk;
        $data['trn_cr_account_amount'] = $request->trn_cr_account_amount;
        $data['trn_dr_account_amount'] = $request->trn_dr_account_amount;
        $data['au_entry_at'] = $au_entry_at;
        $data['au_entry_by'] = Auth::id();
        $data['au_entry_session'] = $entry_session;
        $data['au_entry_hospital_pk_no'] = $hospital_pk_no;
        $data['status'] = $request->status;
        $data['narration_text'] = $request->note;

        if($cof->income_exp_type == 'INCOME' || $cof->income_exp_type == 'EXPENSES'){
          $data['retained_earnings_ind'] = 1;
        }
        else{
          $data['retained_earnings_ind'] = 0;
        }

        DB::table('acct_openingbalance')->where('opbal_no_pk', $opbal_no_pk)->update($data);


        return response()->json([
          "title"   => 'Success',
          "success" => true,
          "message" => "Successfully Updated",
          ],200);
      } catch (\Throwable $th) {
          return response()->json([
            "title"   => 'Failed',
            "success" => false,
            "message" => $th->getMessage()
        ],422);
      }
    }

    public function accountsCurrencySetupV1(){
      $general_ledger = $this->chart_of_acc->get_accounts_levelV1();;
      return template::loadview('admin.accounts.v1.settings.accounts_currency_setup_v1',);
    }

    public function getAccountsCurrencySetupV1(){
      $currency = $this->account_setup->currency_data();
      return response()->json(['success' => true,'data' => $currency], 200);
    }

    public function saveAccountsCurrencySetup(Request $request){


      $request->validate([
          'currency_name' =>'required|max:50',
          'currency_rate' =>'required|max:5',
        ]);

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (DB::table('sysc_currency')->where('currency_code', $request->currency_name)->exists())
        {
            return response()->json(['success' => false, 'message' => 'Currency Name Already Exists !'], 422);
        }

        try {

            $sequence = DB::getSequence();
            $currency_seq = $sequence->nextValue('currency_no_pk_seq');
            DB::table('sysc_currency')
                ->insert([
                    'currency_no_pk' => $currency_seq,
                    'currency_code' => $request->currency_name,
                    'currency_name' => $request->currency_name,
                    'currency_sign' => $request->currency_name,
                    'rate' => $request->currency_rate,
                    'status' => isset($request->status) ? 1 : 0,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => $au_entry_at,
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no
                ]);
                $currency = $this->account_setup->currency_data();
            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $currency], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        }
    }

    public function editAccountsCurrencySetup($id){
      $data = $this->account_setup->get_accounts_currency_by_id($id);
      return Template::loadView("admin.accounts.v1.settings.modal.edit_accounts_currency", ['data' => $data]);
    }


    public function updateAccountsCurrencySetup(Request $request){


      $request->validate([
          'currency_name' =>'required|max:50',
          'currency_rate' =>'required|max:5',
        ]);

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (DB::table('sysc_currency')->where('currency_code', $request->currency_name)->where('currency_no_pk','!=', $request->currency_no_pk)->exists())
        {
            return response()->json(['success' => false,"title"   => 'Failed', 'msg' => 'Currency Name Already Exists !'], 422);
        }

        try {

            DB::table('sysc_currency')
                ->where('currency_no_pk',$request->currency_no_pk)
                ->update([
                    'currency_code' => $request->currency_name,
                    'rate' => $request->currency_rate,
                    'status' => isset($request->status) ? 1 : 0,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => $au_entry_at,
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no
                ]);

            return response()->json(['success' => true,  "title"   => 'Success','msg' => 'Successfully Updated'], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false,"title"   => 'Failed', 'message' => $e->getMessage()], 422);

        }
    }


}
