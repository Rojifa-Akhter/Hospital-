<?php

namespace App\Http\Controllers;
use PDF;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Support\Facades\Response as FileResponse;

class ChartOfAccountsController extends Controller
{

    /**
     * Chart of account service
     *
     * @var [App\Core\Accounts\ChartOfAccounts\ChartOfAccounts]
     */
    protected $chart_of_accounts;

    public function __construct(ChartOfAccounts $chart_of_accounts)
    {
        $this->chart_of_accounts = $chart_of_accounts;
    }

    public function save_chart_of_accounts(Request $request)
    {

        $root_account_info = $this->chart_of_accounts->get_chart_of_account_by_id($request->account_no_fk_root_0);

        try{
            
            $account_chart = $this->chart_of_accounts->save_chart_of_account([
                'account_code' => $request->account_code,
                'account_name' => $request->account_name,
                'acct_type_no_fk' => 0,
                'account_no_fk_root_0' => $request->account_no_fk_root_0,
                'account_no_fk_root_s1' => $root_account_info->getData()->data->account_no_fk_root_0,
                'account_no_fk_root_s2' => $root_account_info->getData()->data->account_no_fk_root_s1,
                'account_no_fk_root_s3' => $root_account_info->getData()->data->account_no_fk_root_s2,
                'account_no_fk_root_s4' => $root_account_info->getData()->data->account_no_fk_root_s3,
                'cashflow_category_no_fk' => $request->cashflow_category_no_fk,
                'ledger_group_name' => $request->ledger_group_name,
                'account_no_sl' => $request->account_no_sl,
                'posting_head_ind' => $request->posting_head_ind,
                'status' => $request->status,
                'cashflow_ind' => !empty($request->cashflow_category_no_fk) ? 1 : 0,
                'income_exp_ind' => !empty($request->income_exp_type) ? 1 : 0,
                'income_exp_type' => !empty($request->income_exp_type) ? $request->income_exp_type : ''
            ]);

            return response()->json(['success' => true, 'data' => $account_chart], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function update_chart_of_accounts(Request $request)
    {

        try{
            $account_chart = $this->chart_of_accounts->update_chart_of_account([
                'account_no_pk' => $request->account_no_pk,
                'account_name' => $request->account_name,
                'cashflow_category_no_fk' => $request->cashflow_category_no_fk,
                'ledger_group_name' => $request->ledger_group_name,
                'account_no_sl' => $request->account_no_sl,
                'posting_head_ind' => $request->posting_head_ind,
                'status' => $request->status,
                'cashflow_ind' => !empty($request->cashflow_category_no_fk) ? 1 : 0,
                'income_exp_ind' => !empty($request->income_exp_type) ? 1 : 0,
                'income_exp_type' => !empty($request->income_exp_type) ? $request->income_exp_type : ''
            ]);

            return response()->json(['success' => true, 'data' => $account_chart], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function get_chart_of_account()
    {
        try {
            
            $charof_accounts = $this->chart_of_accounts->get_chart_of_account();

            return response()->json(['success' => true, 'data' => $charof_accounts], 200);
        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    //Accounts V1 route

    public function save_chart_of_accounts_v1(Request $request)
    {

        $root_account_info = $this->chart_of_accounts->get_chart_of_account_by_id($request->account_no_fk_root_0);

        try{
            
            $account_chart = $this->chart_of_accounts->save_chart_of_account([
                'account_code' => $request->account_code,
                'account_name' => $request->account_name,
                'acct_type_no_fk' => 0,
                'account_no_fk_root_0' => $request->account_no_fk_root_0,
                'account_no_fk_root_s1' => $root_account_info->getData()->data->account_no_fk_root_0,
                'account_no_fk_root_s2' => $root_account_info->getData()->data->account_no_fk_root_s1,
                'account_no_fk_root_s3' => $root_account_info->getData()->data->account_no_fk_root_s2,
                'account_no_fk_root_s4' => $root_account_info->getData()->data->account_no_fk_root_s3,
                'cashflow_category_no_fk' => $request->cashflow_category_no_fk,
                'ledger_group_name' => $request->ledger_group_name,
                'account_no_sl' => $request->account_no_sl,
                'posting_head_ind' => $request->posting_head_ind,
                'status' => $request->status,
                'cashflow_ind' => !empty($request->cashflow_category_no_fk) ? 1 : 0,
                'income_exp_ind' => !empty($request->income_exp_type) ? 1 : 0,
                'income_exp_type' => !empty($request->income_exp_type) ? $request->income_exp_type : ''
            ]);

            return response()->json(['success' => true, 'data' => $account_chart], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function update_chart_of_accounts_v1(Request $request)
    {

        try{
            $account_chart = $this->chart_of_accounts->update_chart_of_account([
                'account_no_pk' => $request->account_no_pk,
                'account_name' => $request->account_name,
                'cashflow_category_no_fk' => $request->cashflow_category_no_fk,
                'ledger_group_name' => $request->ledger_group_name,
                'account_no_sl' => $request->account_no_sl,
                'posting_head_ind' => $request->posting_head_ind,
                'status' => $request->status,
                'cashflow_ind' => !empty($request->cashflow_category_no_fk) ? 1 : 0,
                'income_exp_ind' => !empty($request->income_exp_type) ? 1 : 0,
                'income_exp_type' => !empty($request->income_exp_type) ? $request->income_exp_type : ''
            ]);

            return response()->json(['success' => true, 'data' => $account_chart], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }
    }

    public function get_chart_of_account_v1()
    {
        try {
            
            $charof_accounts = $this->chart_of_accounts->get_chart_of_account();

            return response()->json(['success' => true, 'data' => $charof_accounts], 200);
        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function accountsCOFListV1(){
      $chart_of_account_list = $this->chart_of_accounts->get_chart_of_account_list_v1();
      return Template::loadview('admin.accounts.v1.settings.chart_of_accounts_list_v1', compact('chart_of_account_list'));
    }

    public function downloadCOFListExcelV1(){
      
        $data = DB::table('acc_coa_4accounttype_vw')
                    ->orderBy('account_code','asc')
                    ->get();
                    
        $html = View('admin.accounts.v1.settings.export.chart_of_accounts_list_excel',['data' => $data]);
        $fileToExport = 'chart_of_account_list.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');

        return $response;
    }

    public function downloadCOFListPDFV1(){
      
        $data = DB::table('acc_coa_4accounttype_vw')
                    ->orderBy('account_code','asc')
                    ->get();
        $pdf = PDF::loadView("admin.accounts.v1.settings.export.chart_of_accounts_list_pdf",['data' => $data])
                ->setPaper('a4', 'landscape');
        return $pdf->download('chart_of_account_list.pdf');
        // return $pdf->stream('chart_of_account_list.pdf');
    }

    public function getTypeListByGroupType($id){
        $get_type_list = $this->chart_of_accounts->get_type_list_by_group_type($id);
        $page_info = $this->chart_of_accounts->get_chart_of_account_by_various_id('acc_3grouptype_no_pk',$id);
        return Template::loadView('admin.accounts.v1.settings.type_list_by_group_type_v1',compact('get_type_list','id','page_info'));
  
    }

    public function downloadCOFAccountTypeListExcelV1($id){
      
        $data = $this->chart_of_accounts->get_type_list_by_group_type($id);
        $html = View('admin.accounts.v1.settings.export.chart_of_accounts_type_list_excel',['data' => $data->getData()->data]);
        $fileToExport = 'account_types.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');

        return $response;
    }

    
    public function downloadCOFAccountTypeListPDFV1($id){
      
        $data = $this->chart_of_accounts->get_type_list_by_group_type($id);
        $pdf = PDF::loadView("admin.accounts.v1.settings.export.chart_of_accounts_type_list_pdf",['data' => $data->getData()->data])
                ->setPaper('a4', 'portrait');
        return $pdf->download('account_types.pdf');
        // return $pdf->stream('chart_of_account_list.pdf');
    }

    public function getDescriptionListByType($id){
        $get_type_list = $this->chart_of_accounts->get_account_list_by_type($id);
        $page_info = $this->chart_of_accounts->get_chart_of_account_by_various_id('acc_4type_no_pk',$id);
        return Template::loadView('admin.accounts.v1.settings.account_list_by_type_v1',compact('get_type_list','id','page_info'));
    }

    
    public function downloadCOFAccountDescriptionListExcelV1($id){
      
        $data = $this->chart_of_accounts->get_account_list_by_type($id);
        $html = View('admin.accounts.v1.settings.export.chart_of_accounts_description_list_excel',['data' => $data->getData()->data]);
        $fileToExport = 'account_description.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');

        return $response;
    }

    
    public function downloadCOFAccountDescriptionListPDFV1($id){
      
        $data = $this->chart_of_accounts->get_account_list_by_type($id);
        $pdf = PDF::loadView("admin.accounts.v1.settings.export.chart_of_accounts_description_list_pdf",['data' => $data->getData()->data])
                ->setPaper('a4', 'portrait');
        return $pdf->download('account_description.pdf');
        // return $pdf->stream('chart_of_account_list.pdf');
    }
    
    
    public function getGLListByDescription($id){
        $gl_list = $this->chart_of_accounts->get_gl_list_by_description($id);
        // dd($gl_list->getData()->data);
        $page_info = $this->chart_of_accounts->get_chart_of_account_by_various_id('acc_5typedescription_no_pk',$id);
        return Template::loadView('admin.accounts.v1.settings.general_ledger_list_v1',compact('gl_list','id','page_info'));
    }
    
    


    public function downloadCOFGLListExcelV1($id){
      
        $data = $this->chart_of_accounts->get_gl_list_by_description($id);
        $html = View('admin.accounts.v1.settings.export.general_ledger_list_excel',['data' => $data->getData()->data]);
        $fileToExport = 'general_ledger.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');

        return $response;
    }

    
    public function downloadCOFGLListPDFV1($id){
      
        $data = $this->chart_of_accounts->get_gl_list_by_description($id);
 
        $pdf = PDF::loadView("admin.accounts.v1.settings.export.general_ledger_list_pdf",['data' => $data->getData()->data])
                ->setPaper('a4', 'landscape');
        return $pdf->download('account_types.pdf');
        // return $pdf->stream('chart_of_account_list.pdf');
    }

    public function getGLListChartOfAccounts(){
        $gl_list = $this->chart_of_accounts->get_gl_list_by_description('all');
        $page_info = '';
        $id = 'all';
        return Template::loadView('admin.accounts.v1.settings.general_ledger_list_v1',compact('gl_list','id','page_info'));
    }
}