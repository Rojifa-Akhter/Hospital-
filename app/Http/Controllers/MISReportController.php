<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Psr7\Request as Psr7Request;
use App\Core\Accounts\AccountSetup\AccountSetup;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;

class MISReportController extends Controller
{

    protected $account_setup;

    /**
     * Chart of account service
     *
     * @var [@App\Core\Accounts\ChartOfAccounts\ChartOfAccounts]
     */
    protected $chart_of_acc;

    public function __construct(AccountSetup  $account_setup,ChartOfAccounts $chart_of_acc)
    {

        $this->account_setup = $account_setup;
        $this->chart_of_acc = $chart_of_acc;

    }



    public function reportEntry(Request $request){

        $allMenus = Menu::select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                        ->where('parent_menu_no_fk',0)
                        ->orderBy('sl_no','asc')
                        ->get();
        return Template::loadview('admin.mis_report.mis_report_entry', compact('allMenus'));
    }
   
    function isSelectStatement($sql)
    {
        $trimmedSql = trim($sql);
        $lowerSql = strtolower($trimmedSql);
        if (strpos($lowerSql, 'select') === 0) {
            $prohibitedKeywords = ['update', 'delete', 'insert', 'alter', 'drop', 'truncate'];
            foreach ($prohibitedKeywords as $keyword) {
                if (stripos($lowerSql, $keyword) !== false) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function store(Request $request){
        $request->validate([
            'menu' => 'required'
        ]);

 
        try {

            if (!$this->isSelectStatement($request->sql_query)) {
                return response()->json(['success' => false, 'message' => 'Only Select Statement allowed','title' => 'Failed'], 422);
            } 
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $seq = $this->getSequence('MIS_REPORTMST_SEQ');
            DB::beginTransaction();
            $data = [
                'report_no_pk' => $seq,
                'report_code' => $seq,
                'report_setup_date' => $au_entry_at,
                'report_name' => $request->report_name,
                'report_name_show' => $request->report_name_show,
                'menu_no_fk' => $request->menu,
                'sql_based_ind' => 1,
                'sql_query_text' => $request->sql_query,
                'sql_query_clob' => $request->sql_query,
                'status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_no_fk' => $hospital_pk_no
            ];
            
            DB::table('mis_reportmst')->insert($data);  
            $lastInsertedId = DB::table('mis_reportmst')->orderByDesc('report_no_pk')->value('report_no_pk');    
            //Column Entry                       
            foreach($request->column_heading_name as $key => $value){
                $sequence = $this->getSequence('mis_reportchd_seq');
                
                $child = [                              
                    'reportchd_no_pk' => $sequence,
                    'reportchd_code' => $sequence,
                    'reportchd_setup_date' => $au_entry_at,                                                                
                    'column_heading_name' => $request->column_heading_name[$key],
                    'column_name_actual' => $request->column_name_actual[$key],             
                    'value_type' => $request->value_type[$key],               
                    'alignment_type' => $request->alignment_type[$key],               
                    'sum_ind' => $request->sum_ind[$key], 
                    'show_ind' => $request->show_ind[$key], 
                    'sl' => $request->sl[$key],               
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no              
                ];
                
                if(!empty($child['column_name_actual']) && !empty($child['column_heading_name'])){
                    DB::table('MIS_REPORTCHD')->insert($child);              
                }
            }

            //Parameter Entry
            foreach($request->reportparam_name as $key => $value){
                $sequence = $this->getSequence('MIS_REPORT_PARAM_SEQ');

                $value_list_sql = $request->value_list_sql[$key];
                if(!empty($request->value_list_sql[$key])){
                    if (!$this->isSelectStatement($request->value_list_sql[$key])) {
                        $value_list_sql = '';
                    } 
                }
                $child = [  
                    'reportparam_no_pk' => $sequence,                           
                    'reportparam_code' => $sequence,                           
                    'numeric_ind' => $request->parameter_type[$key] == 1 ? 1 : 0,                                       
                    'date_ind' => $request->parameter_type[$key] == 2 ? 1 : 0,                                                                         
                    'text_type_ind' => $request->parameter_type[$key] == 3 ? 1 : 0,                                                                         
                    'value_list_ind' => $request->parameter_type[$key] == 4 ? 1 : 0,                                                                         
                    'reportparam_name' => $value,
                    'parameter_label' => $request->parameter_label[$key],
                    'value_list_sql' => $value_list_sql,
                    'status' => 1,                                           
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'reportparam_setup_date' => $au_entry_at,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no              
                ];
                
                if(!empty($value)){
                    DB::table('MIS_REPORT_PARAM')->insert($child);              
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }

    public function getMISReport(){
        $data = DB::table('mis_reportmst')
                    ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'mis_reportmst.menu_no_fk')
                    ->select('mis_reportmst.*', 'wsec_menutree.menu_name')
                    ->where('mis_reportmst.status', 1)
                    ->get();
        return response()->json(['data' => $data],200);
    }

    public function reportDetatils($id){
        $data = $this->reportInfo($id);
        return Template::loadView("admin.mis_report.modal.report_info", compact('data'));
    }

    public function reportInfo($id){
        $data = DB::table('mis_reportmst')
                    ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'mis_reportmst.menu_no_fk')
                    ->select('mis_reportmst.*', 'wsec_menutree.menu_name')
                    ->where('mis_reportmst.report_no_pk', $id)
                    ->first();
        
        $column =  DB::table('mis_reportchd')
                    ->where('report_no_fk', $id)
                    ->orderBy('sl','asc')
                    ->orderBy('reportchd_no_pk','asc')
                    ->get();

        $parameter =  DB::table('mis_report_param')
                    ->where('report_no_fk', $id)
                    ->orderBy('reportparam_no_pk','asc')
                    ->get();

        $result = [
            'report' => $data,
            'column' => $column,
            'parameter' => $parameter,
        ];
        return $result;

        
    }


    public function reportGenerate(){

        if(isset($_COOKIE['menu_id'])){
            $sub_menu_id = $_COOKIE['menu_id'];
        }else{
            return Template::loadview('admin.mis_report.error'); 
        }

        $menu_no_pk = Menu::where('menu_no_pk', $sub_menu_id )->where('parent_menu_no_fk','>', 0)->pluck('parent_menu_no_fk');

        if(count($menu_no_pk) == 0){
            $menu_no_pk = Menu::where('menu_no_pk', $sub_menu_id )->pluck('menu_no_pk');
        }

        
        $data = DB::table('mis_reportmst')
                    ->where('mis_reportmst.status', 1)
                    ->select(
                        "report_no_pk",
                        "report_name",
                        "status",
                    )
                    ->whereIn('menu_no_fk', $menu_no_pk)
                    ->get();
        return Template::loadview('admin.mis_report.mis_report_generate', compact('data'));
    }

    public function getReportList($id){
        if($id == 0){
            $report = DB::table('mis_reportmst')
                    ->where('mis_reportmst.status', 1)
                    ->select(
                        "report_no_pk",
                        "report_name",
                        "status",
                    )
                    ->get();
        }
        else{
            $report = DB::table('mis_reportmst')
                    ->where('mis_reportmst.status', 1)
                    ->where('mis_reportmst.su_no_fk', $id)
                    ->select(
                        "report_no_pk",
                        "report_name",
                        "status",
                    )
                    ->get();
        }

        
        $data = [];
        if(count($report)>0){
            foreach($report as $item){
                $d='<option value='.$item->report_no_pk.'>'.$item->report_name.'</option>';                       
                array_push($data,$d);
            }
            return $data;
        }
        else{
            return "<option value=''>Not Found</option>";
        }
    }

    public function reportGenerateRequest($id){
        $hospital_code= Session::get('user.ses_hospital_code');
        $data = $this->reportInfo($id);
        return view('admin.mis_report.mis_input_promt', compact('data','hospital_code'));
    }

    public function reportGenerateDownload(Request $request){
        // dd($request->all());
        $request->validate([
            'report' => 'required',
        ]);
        $userInfo = Auth::user();
        $data = [];
        $id = $request->report;
        $data = $this->reportInfo($id);
        $show_column = $request->columns;
       
        $parameters = [];
        $bindings = [];
        $input = [];
        // Iterate through the dynamic parameters
        foreach ($data['parameter'] as $key => $value) {
            $parameter_name = $value->reportparam_name;
            $parameters[] = "$parameter_name = :$parameter_name"; 
            $bindings[$parameter_name] = $request->input($parameter_name);

            // input info set

            if($value->value_list_ind != 1){
                $input[$value->parameter_label] = $request->input($value->reportparam_name);
            }else{

                if (!$this->isSelectStatement($value->value_list_sql)) {
                    $input[$value->parameter_label] = '';
                } 
                $query_data = $this->getValuesFromSQL($value->value_list_sql);
                $name = collect($query_data)->where('id',$request->input($value->reportparam_name))->values();
                $input[$value->parameter_label] = @$name[0]->name;
            }
            
        }
 
        if (!$this->isSelectStatement($data['report']->sql_query_text)) {
            return response()->json(['success' => false, 'message' => 'Only Select Statement allowed','title' => 'Failed'], 422);
        } 

        $result = DB::select($data['report']->sql_query_text, $bindings);
        
        $show_column = DB::table("MIS_REPORTCHD")->whereIn('reportchd_no_pk',$request->columns)->where('report_no_fk', $id)->select('column_heading_name','column_name_actual','value_type','alignment_type','sum_ind')->orderBy('sl', 'asc')->get();
       
        $hospital_details = DB::table("WSEC_HOSPITAL")->first();

        
        return view('admin.mis_report.mis_report_pdf', compact('result', 'show_column', 'userInfo','data','input','hospital_details'));
    }

    public function reportEntryEdit($id){
        $data = $this->reportInfo($id);

        $allMenus = Menu::select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                        ->where('parent_menu_no_fk',0)
                        ->orderBy('sl_no','asc')
                        ->get();
        return Template::loadview('admin.mis_report.edit_mis_report', compact('allMenus','data'));
    }

    public function updateReport(Request $request){
        $request->validate([
            'menu' => 'required',
            'report_no_pk' => 'required',
        ]);

 
        try {

            if (!$this->isSelectStatement($request->sql_query)) {
                return response()->json(['success' => false, 'message' => 'Only Select Statement allowed','title' => 'Failed'], 422);
            } 
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $report_no_pk = $request->report_no_pk;
            DB::beginTransaction();
            $data = [
                'report_setup_date' => $au_entry_at,
                'report_name' => $request->report_name,
                'report_name_show' => $request->report_name_show,
                'menu_no_fk' => $request->menu,
                'sql_query_text' => $request->sql_query,
                'sql_query_clob' => $request->sql_query,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_no_fk' => $hospital_pk_no
            ];
            
            DB::table('mis_reportmst')->where('report_no_pk', $report_no_pk)->update($data);  
            $lastInsertedId = $report_no_pk;  

            //Column Entry       
            DB::table('MIS_REPORTCHD')->where('report_no_fk', $report_no_pk)->delete(); 
            foreach($request->column_heading_name as $key => $value){
                $sequence = $this->getSequence('mis_reportchd_seq');
                
                $child = [                              
                    'reportchd_no_pk' => $sequence,
                    'reportchd_code' => $sequence,
                    'reportchd_setup_date' => $au_entry_at,                                                                
                    'column_heading_name' => $request->column_heading_name[$key],
                    'column_name_actual' => $request->column_name_actual[$key],             
                    'value_type' => $request->value_type[$key],               
                    'alignment_type' => $request->alignment_type[$key],               
                    'sum_ind' => $request->sum_ind[$key],  
                    'show_ind' => $request->show_ind[$key],              
                    'sl' => $request->sl[$key],               
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no              
                ];
                
                if(!empty($child['column_name_actual']) && !empty($child['column_heading_name'])){
                    DB::table('MIS_REPORTCHD')->insert($child);              
                }
            }

            //Parameter Entry
            DB::table('MIS_REPORT_PARAM')->where('report_no_fk', $report_no_pk)->delete(); 
            foreach($request->reportparam_name as $key => $value){
                $sequence = $this->getSequence('MIS_REPORT_PARAM_SEQ');

                $value_list_sql = $request->value_list_sql[$key];
                if(!empty($request->value_list_sql[$key])){
                    if (!$this->isSelectStatement($request->value_list_sql[$key])) {
                        $value_list_sql = '';
                    } 
                }
                $child = [  
                    'reportparam_no_pk' => $sequence,                           
                    'reportparam_code' => $sequence,                           
                    'numeric_ind' => $request->parameter_type[$key] == 1 ? 1 : 0,                                       
                    'date_ind' => $request->parameter_type[$key] == 2 ? 1 : 0,                                                                         
                    'text_type_ind' => $request->parameter_type[$key] == 3 ? 1 : 0,   
                    'value_list_ind' => $request->parameter_type[$key] == 4 ? 1 : 0,                                                                        
                    'reportparam_name' => $value,
                    'parameter_label' => $request->parameter_label[$key],
                    'value_list_sql' => $value_list_sql,
                    'status' => 1,                                           
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'reportparam_setup_date' => $au_entry_at,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no              
                ];
                
                if(!empty($value)){
                    DB::table('MIS_REPORT_PARAM')->insert($child);              
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Updated','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(),'title' => 'Failed'], 422);
        }
    }


    public static function getValuesFromSQL($sql)
    {
        $trimmedSql = trim($sql);
        $lowerSql = strtolower($trimmedSql);
        if (strpos($lowerSql, 'select') === 0) {
            $prohibitedKeywords = ['update', 'delete', 'insert', 'alter', 'drop', 'truncate'];
            foreach ($prohibitedKeywords as $keyword) {
                if (stripos($lowerSql, $keyword) !== false) {
                    return [];
                }
            }

            // : check
            $prohibitedKeywords = [':'];
            foreach ($prohibitedKeywords as $keyword) {
                if (stripos($lowerSql, $keyword) !== false) {
                    
                    $bindings['PERSON_NO_FK'] = Session::get('user.ses_person_no_fk');
                    return DB::select($sql, $bindings);
                }
            }




            return DB::select($sql);
        }
        return false;
       
    }


    public function reportGenerateExcel(Request $request){
        ini_set('max_execution_time',0);

        $request->validate([
            'report' => 'required',
        ]);
        $userInfo = Auth::user();
        $data = [];
        $id = $request->report;
        $data = $this->reportInfo($id);
        $show_column = $request->columns;

        $parameters = [];
        $bindings = [];
        $input = [];
        // Iterate through the dynamic parameters
        foreach ($data['parameter'] as $key => $value) {
            $parameter_name = $value->reportparam_name;
            $parameters[] = "$parameter_name = :$parameter_name"; 
            $bindings[$parameter_name] = $request->input($parameter_name);

            // input info set

            if($value->value_list_ind != 1){
                $input[$value->parameter_label] = $request->input($value->reportparam_name);
            }else{

                if (!$this->isSelectStatement($value->value_list_sql)) {
                    $input[$value->parameter_label] = '';
                } 
                $query_data = $this->getValuesFromSQL($value->value_list_sql);
                $name = collect($query_data)->where('id',$request->input($value->reportparam_name))->values();
                $input[$value->parameter_label] = @$name[0]->name;
            }
            
        }
 
        if (!$this->isSelectStatement($data['report']->sql_query_text)) {
            return response()->json(['success' => false, 'message' => 'Only Select Statement allowed','title' => 'Failed'], 422);
        } 

        $result = DB::select($data['report']->sql_query_text, $bindings);
        $show_column = DB::table("MIS_REPORTCHD")->whereIn('reportchd_no_pk',$request->columns)->where('report_no_fk', $id)->select('column_heading_name','column_name_actual','value_type','alignment_type','sum_ind')->orderBy('sl', 'asc')->get();

        $html = view("admin.mis_report.mis_report_excel", compact('result', 'show_column', 'userInfo','data','input'));
        $fileToExport = 'report.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }
    
}
