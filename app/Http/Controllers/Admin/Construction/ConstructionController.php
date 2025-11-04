<?php

namespace App\Http\Controllers\Admin\Construction;

use PDF;
use PDO;
use DateTime;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConstructionController extends Controller
{
    public function index(){

        $vendor =  DB::table('cons_workordermst')->select('vendor_name')->groupBy('vendor_name')->get();
        $unit =  DB::table('cons_workorderdtl')->select('unit')->groupBy('unit')->get();
        $work_type =  DB::table('cons_workorderdtl')->select('typeofwoker')->groupBy('typeofwoker')->get();
        $department =  DB::table('sysc_serviceunit')->select('serviceunit_name','serviceunit_no_pk')->where('status',1)->where('construction_ind',1)->get();
        return Template::loadView('admin.construction.work_order_entry', compact('department','vendor','unit','work_type'));
    }

    public function store(Request $request){
        $request->validate([
                'ref_no' => 'required',
                'department' => 'required',
                'start_date' => 'required',
                'vendor' => 'required',
                'date' => 'required',
                'end_date' => 'required',
        ]);

        try {

            if(count($request->description) == 0){
                return response()->json(['success' => false, 'message' => 'Please Add at least one item', 'title' => 'Failed'],422);
            }

            DB::beginTransaction();
            $mast_seq = $this->getSequence('workordermst_no_pk_seq');
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            $attachment = "";
            if ($request->hasFile('attachment')) {                  
                $originalFileName = $request->attachment->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName = time(). $cleanFileName;
                $request->attachment->move(public_path('uploads/construction/'), $fileName);
                $attachment = $fileName;
            }


            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);
            $date = $dateTime->format('Y-m-d'); 

            $dateTime = DateTime::createFromFormat('d/m/Y', $request->start_date);
            $start_date = $dateTime->format('Y-m-d'); 

            $dateTime = DateTime::createFromFormat('d/m/Y', $request->end_date);
            $end_date = $dateTime->format('Y-m-d'); 
            // dd($date,$start_date,$end_date,$au_entry_at);

            $data = [
                'workordermst_no_pk' => $mast_seq,
                'workorder_ref_no' => $request->ref_no,
                'workorder_date' => $date,
                'work_start_date' => $start_date,
                'work_completion_date' => $end_date,
                'vendor_name' => $request->vendor,
                'serviceunit_no_fk' => $request->department,
                'att_doc' => $attachment,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'termsncon' => $request->terms_condition,
                'adv_amount' => $request->advance_amt,
                'workorder_type' => $request->workorder_type,
                'draft_ind' => 0,
                'status' => 1
            ];

            DB::table('cons_workordermst')->insert($data);
            $last_id = DB::table('cons_workordermst')->orderByDesc('workordermst_no_pk')->value('workordermst_no_pk');
            
            foreach ($request->description as $key => $value) {
                $child_seq = $this->getSequence('workorderdtl_no_pk_seq');  
                $child = [
                    'workorderdtl_no_pk' => $child_seq,
                    'workordermst_no_fk' => $last_id,
                    'rate' => $request->rate[$key],
                    'unit' => $request->unit[$key],
                    'remarks' => $request->remarks[$key],
                    'typeofwoker' => $request->work_type[$key],
                    'wo_desc' => $value,
                    'work_qty' => $request->work_qty[$key],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'status' => 1
                ];
                DB::table('cons_workorderdtl')->insert($child);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'title' => 'Success','work_order_id' => $last_id],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'],422);
        }

    }

    public function worklist(){
        $department = DB::table('sysc_serviceunit')->select('serviceunit_name','serviceunit_no_pk')->where('status',1)->where('construction_ind',1)->get();;
        $vendor =  DB::table('cons_workordermst')->select('vendor_name')->groupBy('vendor_name')->get();
        return Template::loadView('admin.construction.work_order_list', compact('department','vendor'));
    }
    

    public function searchWorkOrder(Request $request){

        $from_date = '';
        $to_date = '';
        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d'); 
        }
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d'); 
        }

        $data = DB::table('cons_workorder_vw')

                ->select(
                    'workordermst_no_pk',
                    'workorder_ref_no',
                    'workorder_date',
                    'adv_amount',
                    'work_start_date',
                    'work_completion_date',
                    'att_doc',
                    'vendor_name',
                    'draft_ind',
                    'serviceunit_no_fk',
                    'department',
                    'app_status',
                    'total_amount',
                    'approval_status_text',
                    'approval_level_status_text',
                    'billprocess_ind',
                    'bill_app_level_status_text',
                    'bill_app_status', 
                    'bill_app_status_text', 
                );

        if(!empty($request->department)){
            $data->where('serviceunit_no_fk', $request->department);
        }

        if(!empty($request->vendor)){
            $data->where('vendor_name', $request->vendor);
        }

        if(!empty($request->work_order_no)){
            $data->where('workordermst_no_pk', $request->work_order_no);
        }

        if(!empty($from_date) && !empty($from_date)){
            $data->whereBetween('workorder_date', [$from_date, $to_date]);
        }elseif (!empty($from_date)) {
            $data->where('workorder_date', $from_date);
        }elseif (!empty($to_date)) {
            $data->where('workorder_date', $to_date);
        }

        return response()->json(['data' => $data->get(), 'success' => true], 200);
    }

    public function edit($id){
        $department =DB::table('sysc_serviceunit')->select('serviceunit_name','serviceunit_no_pk')->where('status',1)->where('construction_ind',1)->get();;
        $vendor =  DB::table('cons_workordermst')->select('vendor_name')->groupBy('vendor_name')->get();
        $unit =  DB::table('cons_workorderdtl')->select('unit')->groupBy('unit')->get();
        $work_type =  DB::table('cons_workorderdtl')->select('typeofwoker')->groupBy('typeofwoker')->get();


        $data = DB::table('cons_workorderdtl')
                    ->join('cons_workordermst','cons_workordermst.workordermst_no_pk','=','cons_workorderdtl.workordermst_no_fk')
                    ->select(
                        'cons_workordermst.workordermst_no_pk',
                        'cons_workordermst.workorder_ref_no',
                        'cons_workordermst.workorder_date',
                        'cons_workordermst.work_start_date',
                        'cons_workordermst.work_completion_date',
                        'cons_workordermst.att_doc',
                        'cons_workordermst.termsncon',
                        'cons_workordermst.vendor_name',
                        'cons_workordermst.adv_amount',
                        'cons_workordermst.workorder_type',
                        'cons_workordermst.serviceunit_no_fk',
                        'cons_workordermst.draft_ind',
                        'cons_workordermst.status',
                        'cons_workorderdtl.wo_desc',
                        'cons_workorderdtl.typeofwoker',
                        'cons_workorderdtl.unit',
                        'cons_workorderdtl.work_qty',
                        'cons_workorderdtl.rate',
                        'cons_workorderdtl.remarks',
                    )->where('cons_workordermst.workordermst_no_pk', $id)->get();

        if(count($data) == 0){
            return view("admin.components.error_alert");
        }
        else if($data[0]->draft_ind == 1){
            return view("admin.components.error_alert");
        }

        return Template::loadView('admin.construction.work_order_post', compact('department','vendor','unit','work_type', 'data'));
    }

    public function show($id){
        ini_set('max_execution_time', 0);
        $data = DB::table('cons_workorderdtl')
                    ->join('cons_workordermst','cons_workordermst.workordermst_no_pk','=','cons_workorderdtl.workordermst_no_fk')
                    ->join('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','cons_workordermst.serviceunit_no_fk')
                    ->join('wsec_user', 'wsec_user.user_no_pk', 'cons_workordermst.au_entry_by')
                    ->leftJoin('HRMS_PERSONNEL', 'wsec_user.PERSON_NO_FK', 'HRMS_PERSONNEL.PERSON_NO_PK')
                    ->select(
                        'cons_workordermst.workordermst_no_pk',
                        'cons_workordermst.workorder_ref_no',
                        'cons_workordermst.workorder_date',
                        'cons_workordermst.work_start_date',
                        'cons_workordermst.work_completion_date',
                        'cons_workordermst.att_doc',
                        'cons_workordermst.termsncon',
                        'cons_workordermst.vendor_name',
                        'cons_workordermst.adv_amount',
                        'cons_workordermst.workorder_type',
                        'cons_workordermst.serviceunit_no_fk',
                        'cons_workordermst.draft_ind',
                        'cons_workordermst.status',
                        'cons_workorderdtl.wo_desc',
                        'cons_workorderdtl.typeofwoker',
                        'cons_workorderdtl.unit',
                        'cons_workorderdtl.work_qty',
                        'cons_workorderdtl.rate',
                        'cons_workorderdtl.remarks',
                        'wsec_user.user_fullname',
                        'cons_workordermst.au_entry_at',
                        'HRMS_PERSONNEL.doctor_signature_image',
                    )
                    ->where('cons_workordermst.workordermst_no_pk', $id)->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $signature_data = DB::table('sysc_approvalprocess_vw')
                                    ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
                                    ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                                    ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                                    ->where('sysc_approvalprocess_vw.primary_key_value', $id)
                                    ->where('sysc_approvalprocess_vw.approval_for_code', 'WORKORDER')
                                    ->whereRaw("sysc_approvalprocess_vw.level_status_text like '%APPROVED%'")
                                    ->orderBy('own_level','asc')
                                    ->get();                  
           

        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.construction.work_order_pdf", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'signature_data' => $signature_data,
            'data' => $data,
        ]);

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        
        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));

        return $pdf->stream("work order.pdf");
    }

    public function postWorkOrder(Request $request){
        $request->validate([
                'ref_no' => 'required',
                'department' => 'required',
                'start_date' => 'required',
                'vendor' => 'required',
                'date' => 'required',
                'end_date' => 'required',
        ]);

        try {

            if(count($request->description) == 0){
                return response()->json(['success' => false, 'message' => 'Please Add at least one item', 'title' => 'Failed'],422);
            }

            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            $attachment = DB::table('cons_workordermst')->where('workordermst_no_pk',$request->work_order_id)->value('att_doc');
            if ($request->hasFile('attachment')) {   
                $image = public_path('uploads/construction/').'/'.$attachment;
                if(file_exists($image)){
                    @unlink($image);
                }               
                $originalFileName = $request->attachment->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName = time(). $cleanFileName;
                $request->attachment->move(public_path('uploads/construction/'), $fileName);
                $attachment = $fileName;  
            }

            if($request->work_attachment_ind == 1){
                $image = public_path('uploads/construction/').'/'.$attachment;
                if(file_exists($image)){
                    @unlink($image);
                }
                $attachment = '';
            }


            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);
            $date = $dateTime->format('Y-m-d'); 

            $dateTime = DateTime::createFromFormat('d/m/Y', $request->start_date);
            $start_date = $dateTime->format('Y-m-d'); 

            $dateTime = DateTime::createFromFormat('d/m/Y', $request->end_date);
            $end_date = $dateTime->format('Y-m-d'); 
            // dd($date,$start_date,$end_date,$au_entry_at);

            $data = [
                'workorder_ref_no' => $request->ref_no,
                'workorder_date' => $date,
                'work_start_date' => $start_date,
                'work_completion_date' => $end_date,
                'vendor_name' => $request->vendor,
                'serviceunit_no_fk' => $request->department,
                'att_doc' => $attachment,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'termsncon' => $request->terms_condition,
                'adv_amount' => $request->advance_amt,
                'workorder_type' => $request->workorder_type,
                'draft_ind' => 1,
                'status' => 1
            ];

            DB::table('cons_workordermst')->where('workordermst_no_pk',$request->work_order_id)->update($data);
            $last_id = $request->work_order_id;

            DB::table('cons_workorderdtl')->where('workordermst_no_fk',$request->work_order_id)->delete();
            $in_remarks = "";
            foreach ($request->description as $key => $value) {
                $child_seq = $this->getSequence('workorderdtl_no_pk_seq');  
                $child = [
                    'workorderdtl_no_pk' => $child_seq,
                    'workordermst_no_fk' => $last_id,
                    'rate' => $request->rate[$key],
                    'unit' => $request->unit[$key],
                    'remarks' => $request->remarks[$key],
                    'typeofwoker' => $request->work_type[$key],
                    'wo_desc' => $value,
                    'work_qty' => $request->work_qty[$key],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'status' => 1
                ];
                DB::table('cons_workorderdtl')->insert($child);

                if($key == 0){
                    $in_remarks.= $request->remarks[$key];
                }
                else{
                    if(!empty($request->remarks[$key] && !empty($in_remarks))){
                        $in_remarks.= '-'.$request->remarks[$key];
                    }
                    else{
                        $in_remarks.= $request->remarks[$key];
                    }
                }
            }




            //set approval process

            $out_apprprocess_no_pk = 0;
            $out_apprprocess_uid = 0;
            $in_approval_for_code = "WORKORDER";
            $in_primary_key_value = $request->work_order_id;
            $in_primary_key_uid = $request->work_order_id;
            $in_serviceunit_no_fk = $request->department;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = $entry_session;
            $in_au_entry_hospital_pk_no = $hospital_pk_no;


            $out_error = 0;
            $pdo = DB::getPdo();
            $construction_work_order = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapprovaldept(
                                        :in_approval_for_code,   
                                        :in_primary_key_value,

                                        :in_primary_key_uid, 
                                        :in_remarks, 
                                        :in_serviceunit_no_fk,
                                        :in_au_entry_by,
                                        :in_au_entry_session,
                                        :in_au_entry_hospital_pk_no,
                                                                                
                                        :out_apprprocess_no_pk,
                                        :out_apprprocess_uid,
                                        :out_error
                                ); end;");

            $construction_work_order->bindparam('in_approval_for_code', $in_approval_for_code);
            $construction_work_order->bindparam('in_primary_key_value', $in_primary_key_value);
            $construction_work_order->bindparam('in_primary_key_uid', $in_primary_key_uid);
            $construction_work_order->bindparam('in_remarks', $in_remarks);

            $construction_work_order->bindparam('in_serviceunit_no_fk', $in_serviceunit_no_fk);
            $construction_work_order->bindparam('in_au_entry_by', $in_au_entry_by);
            $construction_work_order->bindparam('in_au_entry_session', $in_au_entry_session);
            $construction_work_order->bindparam('in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);

            $construction_work_order->bindParam('out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
            $construction_work_order->bindParam('out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 500);
            $construction_work_order->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $construction_work_order->execute();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully POST', 'title' => 'Success'],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'],422);
        }
    }

    public function billWorklist(){
        $department = DB::table('sysc_serviceunit')->select('serviceunit_name','serviceunit_no_pk')->where('status',1)->where('construction_ind',1)->get();;
        $vendor =  DB::table('cons_workordermst')->select('vendor_name')->groupBy('vendor_name')->get();
        return Template::loadView('admin.construction.work_order_bill_generate_list', compact('department','vendor'));
    }

    public function billApprovedWorklist(){
        $department = DB::table('sysc_serviceunit')->select('serviceunit_name','serviceunit_no_pk')->where('status',1)->where('construction_ind',1)->get();;
        $vendor =  DB::table('cons_workordermst')->select('vendor_name')->groupBy('vendor_name')->get();
        // dd($vendor);
        return Template::loadView('admin.construction.work_order_bill_approved_list', compact('department','vendor'));
    }


    public function searchBillGenerateWorkOrder(Request $request){

        $from_date = '';
        $to_date = '';
        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d'); 
        }
       
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d'); 
        }

        $data = DB::table('cons_workorder_vw')
                ->select(
                    'workordermst_no_pk',
                    'workorder_ref_no',
                    'workorder_date',
                    'work_start_date',
                    'work_completion_date',
                    'att_doc',
                    'vendor_name',
                    'bill_amount',
                    'draft_ind',
                    'serviceunit_no_fk',
                    'department',
                    'total_amount',
                    'billprocess_ind',
                    'bill_app_level_status_text as approval_level_status_text',
                    'bill_app_status_text as approval_status_text', 
                )->where('app_status',1);

        if(!empty($request->department)){
            $data->where('serviceunit_no_fk', $request->department);
        }

        if(!empty($request->vendor)){
            $data->where('vendor_name', $request->vendor);
        }

        if(!empty($request->generated_status)){
            $data->where('bill_statuse', $request->generated_status);
        }

        if(!empty($request->work_order_no)){
            $data->where('workordermst_no_pk', $request->work_order_no);
        }

        if(!empty($from_date) && !empty($from_date)){
            $data->whereBetween('workorder_date', [$from_date, $to_date]);
        }elseif (!empty($from_date)) {
            $data->where('workorder_date', $from_date);
        }elseif (!empty($to_date)) {
            $data->where('workorder_date', $to_date);
        }

        return response()->json(['data' => $data->get(), 'success' => true], 200);
    }

    public function searchBillApprovedWorkOrder(Request $request){

        $from_date = '';
        $to_date = '';
        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d'); 
        }
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d'); 
        }

        $data = DB::table('CONS_WORKORDERBILL_VW')
                ->select(
                    'workorderbill_no_pk',
                    'workordermst_no_pk',
                    'workorder_ref_no',
                    'workorder_date',
                    'bill_date',
                    'work_start_date',
                    'work_completion_date',
                    'att_doc',
                    'last_approve_dt',
                    'paid_amount',
                    'vendor_name',
                    'draft_ind',
                    'serviceunit_no_fk',
                    'department',
                    'bill_amt as total_amount',
                    'billprocess_ind',
                    'attechment_file',
                    'bill_app_level_status_text as approval_level_status_text',
                    'bill_app_status_text as approval_status_text', 
                    'bill_amount_status',
                )->where('billprocess_ind',1)->where('app_status',1)->where('bill_app_status',1);

        if(!empty($request->department)){
            $data->where('serviceunit_no_fk', $request->department);
        }

        if(!empty($request->vendor)){
            $data->where('vendor_name', $request->vendor);
        }

        if(!empty($request->work_order_no)){
            $data->where('workordermst_no_pk', $request->work_order_no);
        }

        if(!empty($request->generated_status)){
            $data->where('bill_amount_status', $request->generated_status);
        }

        if(!empty($from_date) && !empty($from_date)){
            $data->whereBetween('bill_date', [$from_date, $to_date]);
        }elseif (!empty($from_date)) {
            $data->where('bill_date', $from_date);
        }elseif (!empty($to_date)) {
            $data->where('bill_date', $to_date);
        }

        return response()->json(['data' => $data->orderByDesc('last_approve_dt')->get(), 'success' => true], 200);
    }


    public function billGenerate($id){
      try {
        DB::beginTransaction();
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if(DB::table('cons_workordermst')->where('workordermst_no_pk',$id)->where('billprocess_ind',1)->exists()){
            return response()->json(['success' => false, 'message' => 'Bill already generated', 'title' => 'Failed'],422);
        }


        $serviceunit_no_fk = DB::table('cons_workordermst')->where('workordermst_no_pk',$id)->value('serviceunit_no_fk');



         //set approval process
         $out_apprprocess_no_pk = 0;
         $out_apprprocess_uid = 0;
         $in_approval_for_code = "WORKORDERBILL";
         $in_primary_key_value = $id;
         $in_primary_key_uid = $id;
         $in_serviceunit_no_fk = $serviceunit_no_fk;
         $in_au_entry_by = Auth::id();
         $in_au_entry_session = $entry_session;
         $in_au_entry_hospital_pk_no = $hospital_pk_no;
         $in_remarks = '';

         $out_error = 0;
         $pdo = DB::getPdo();
         $construction_work_order = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapprovaldept(
                                     :in_approval_for_code,   
                                     :in_primary_key_value,

                                     :in_primary_key_uid, 
                                     :in_remarks, 
                                     :in_serviceunit_no_fk,
                                     :in_au_entry_by,
                                     :in_au_entry_session,
                                     :in_au_entry_hospital_pk_no,
                                                                             
                                     :out_apprprocess_no_pk,
                                     :out_apprprocess_uid,
                                     :out_error
                             ); end;");

         $construction_work_order->bindparam('in_approval_for_code', $in_approval_for_code);
         $construction_work_order->bindparam('in_primary_key_value', $in_primary_key_value);
         $construction_work_order->bindparam('in_primary_key_uid', $in_primary_key_uid);
         $construction_work_order->bindparam('in_remarks', $in_remarks);

         $construction_work_order->bindparam('in_serviceunit_no_fk', $in_serviceunit_no_fk);
         $construction_work_order->bindparam('in_au_entry_by', $in_au_entry_by);
         $construction_work_order->bindparam('in_au_entry_session', $in_au_entry_session);
         $construction_work_order->bindparam('in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);

         $construction_work_order->bindParam('out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
         $construction_work_order->bindParam('out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 500);
         $construction_work_order->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
         $construction_work_order->execute();
         DB::table('cons_workordermst')->where('workordermst_no_pk',$id)->update(['billprocess_ind' => 1]);                   

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Successfully Bill Generated', 'title' => 'Success'],200);                    

      } catch (\Throwable $th) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'],422);
      }  
    }

    public function billGeneratePDF($id){
        ini_set('max_execution_time', 0);
        $work_order =  DB::table('cons_workorderbill')->where('workorderbill_no_pk',$id)->select('workordermst_no_fk','bill_date')->first();
        if(!isset($work_order->workordermst_no_fk)){
            return view("admin.components.error_alert");
        }
        $bill_date = $work_order->bill_date;
        $work_order = $work_order->workordermst_no_fk;
        
        $data = DB::table('cons_workorderdtl')
                    ->join('cons_workordermst','cons_workordermst.workordermst_no_pk','=','cons_workorderdtl.workordermst_no_fk')
                    ->join('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','cons_workordermst.serviceunit_no_fk')
                    ->join('wsec_user', 'wsec_user.user_no_pk', 'cons_workordermst.au_entry_by')
                    ->leftJoin('HRMS_PERSONNEL', 'wsec_user.PERSON_NO_FK', 'HRMS_PERSONNEL.PERSON_NO_PK')
                    ->select(
                        'cons_workordermst.workordermst_no_pk',
                        'cons_workordermst.workorder_ref_no',
                        'cons_workordermst.workorder_date',
                        'cons_workordermst.work_start_date',
                        'cons_workordermst.work_completion_date',
                        'cons_workordermst.att_doc',
                        'cons_workordermst.vendor_name',
                        'cons_workordermst.serviceunit_no_fk',
                        'cons_workordermst.draft_ind',
                        'cons_workordermst.status',
                        'cons_workorderdtl.wo_desc',
                        'cons_workorderdtl.typeofwoker',
                        'cons_workorderdtl.unit',
                        'cons_workorderdtl.work_qty',
                        'cons_workorderdtl.rate',
                        'cons_workorderdtl.remarks',
                        'wsec_user.user_fullname',
                        'cons_workordermst.au_entry_at',
                        'HRMS_PERSONNEL.doctor_signature_image',
                    )->where('cons_workordermst.workordermst_no_pk', $work_order)->get();



        $current_bill_amount =  DB::table('cons_workorderbill')->where('workorderbill_no_pk',$id)->value('bill_amt');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $signature_data = DB::table('sysc_approvalprocess_vw')
                                    ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
                                    ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                                    ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                                    ->where('sysc_approvalprocess_vw.primary_key_value', $id)
                                    ->where('sysc_approvalprocess_vw.approval_for_code', 'WORKORDERBILL')
                                    ->whereRaw("sysc_approvalprocess_vw.level_status_text like '%APPROVED%'")
                                    ->orderBy('own_level','asc')
                                    ->get();                  
           

        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.construction.work_order_bill_generate_pdf", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'current_bill_amount' => $current_bill_amount,
            'signature_data' => $signature_data,
            'data' => $data,
            'bill_no' => $id,
            'bill_date' => $bill_date
        ]);

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        
        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));

        return $pdf->stream("work order.pdf");
    }

    public function partialPayment($id){

        $workorder = DB::table('cons_workorderbill')->where('workorderbill_no_pk', $id)->value('workordermst_no_fk');
        $current_bill = DB::table('cons_workorderbill')->where('workorderbill_no_pk', $id)->value('bill_amt');


        $payment_data = DB::table('cons_workorderpayment')->where('workordermst_no_fk', $workorder)->where('status',1)->get();
        $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $workorder)->sum('total_amount');
        $current_payment = DB::table('cons_workorderpayment')
                                ->where('workordermst_no_fk', $workorder)
                                ->where('workorderbill_no_fk', $id)
                                ->where('status',1)
                                ->get();

        $data = [];
        $data['total_payment'] = collect($payment_data)->sum('paid_amt');
        $data['current_payment'] = collect($current_payment)->sum('paid_amt');
        
        $data['due'] = $current_bill - $data['current_payment'];
        $data['total_amount'] = $total_amount;
        $data['work_order'] = $workorder;
        $data['current_bill'] = $current_bill;
        $data['bill_pk'] = $id;
       return Template::loadView("admin.construction.modal.pay_partial_payment", ['data' => $data, 'order_no' => $id]);

    }


    public function partialPaymentHistory($id){
       $payment_data = DB::table('cons_workorderpayment')
                        ->join('wsec_user', 'wsec_user.user_no_pk', 'cons_workorderpayment.au_entry_by')
                        ->select(
                            'wsec_user.user_fullname',
                            'cons_workorderpayment.remarks',
                            'cons_workorderpayment.payment_date',
                            'cons_workorderpayment.paid_amt',
                            'cons_workorderpayment.au_entry_by'
                            )
                        ->where('cons_workorderpayment.workorderbill_no_fk', $id)->where('cons_workorderpayment.status',1)
                        ->get();

        $workorder = DB::table('cons_workorderbill')->where('workorderbill_no_pk', $id)->value('workordermst_no_fk');
        $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $workorder)->sum('total_amount');
        $total_bill_amount = DB::table('cons_workorderbill_vw')
                                ->where('workordermst_no_pk', $workorder)
                                ->where('workorderbill_no_pk', $id)
                                ->sum('bill_amt');

       
       return Template::loadView("admin.construction.modal.pay_partial_payment_history", ['data' => $payment_data, 'order_no' => $workorder, 'bill_pk' => $id, 'total_amount' => $total_amount, 'total_bill_amount' => $total_bill_amount]);

    }
    
    public function partialPaymentEntry(Request $request){
        $request->validate([
            'paid_amount' => 'required',
            'work_order' => 'required',
            'bill_pk' => 'required',
        ]);

        try {

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $bill_pk       = $request->bill_pk;
            $work_order = $request->work_order;
            $payment_data = DB::table('cons_workorderpayment')
                                ->where('workordermst_no_fk', $work_order)
                                ->where('workorderbill_no_fk', $bill_pk)
                                ->where('status',1)
                                ->get();
            $total_amount = DB::table('cons_workorderbill_vw')
                                ->where('workordermst_no_pk', $work_order)
                                ->where('workorderbill_no_pk', $bill_pk)
                                ->sum('bill_amt');
            
            
            $paid_amount = str_replace(",", "", $request->paid_amount);
            $paid_amount = floatval($paid_amount);
 
            $prev_paid = collect($payment_data)->sum('paid_amt');

            $total_paid = floatVal($paid_amount) + floatVal($prev_paid);
            if($paid_amount  == 0 || empty($paid_amount)){
                return response()->json(['title' => 'Failed', 'msg' => 'Zero amount is invalid', 'success' => false],422);
            }
            if($total_paid > $total_amount){
                return response()->json(['title' => 'Failed', 'msg' => 'Total Paid Amount can not Exceed', 'success' => false],422);
            }

            $seq = $this->getSequence('workorderpayment_no_pk_seq');

            $data = [
                'workorderpayment_no_pk' => $seq,
                'workordermst_no_fk' => $work_order,
                'workorderbill_no_fk' => $bill_pk,
                'payment_date' => $au_entry_at,
                'paid_amt' => $paid_amount,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'status' => 1,
                'remarks' => $request->remarks,
            ];

            DB::table('cons_workorderpayment')->insert($data);
            return response()->json(['title' => 'Success', 'msg' => 'Successfully Paid', 'success' => true],200);
        } catch (\Throwable $th) {
            return response()->json(['title' => 'Failed', 'msg' => $th->getMessage(), 'success' => false],422);
        }

    }

    public function downloadPaymentHistory(Request $request){
        ini_set('max_execution_time', 0);
        $id = $request->bill_pk;
        $workorder = DB::table('cons_workorderbill')->where('workorderbill_no_pk', $id)->value('workordermst_no_fk');
        $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();

        $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $workorder)->sum('total_amount');
        $total_bill_amount = DB::table('cons_workorderbill_vw')
                                ->where('workordermst_no_pk', $workorder)
                                ->where('workorderbill_no_pk', $id)
                                ->sum('bill_amt');
        
        $payment_data = DB::table('cons_workorderpayment')
                        ->join('wsec_user', 'wsec_user.user_no_pk', 'cons_workorderpayment.au_entry_by')
                        ->select(
                            'wsec_user.user_fullname',
                            'cons_workorderpayment.remarks',
                            'cons_workorderpayment.payment_date',
                            'cons_workorderpayment.paid_amt',
                            'cons_workorderpayment.au_entry_by'
                            )
                        ->where('cons_workorderpayment.workorderbill_no_fk', $id)->where('cons_workorderpayment.status',1)->get();

        $pdf = PDF::loadView('admin.construction.export.pay_partial_payment_history_pdf', ['total_bill_amount' => $total_bill_amount, 'bill_pk' => $id, 'total_amount' => $total_amount, 'data' => $payment_data, 'order_no' => $workorder ,'po_hospital_details' => $po_hospital_details])
                        ->setPaper('a4', 'portrait');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('work_order_payment_history.pdf');
    }
    
    public function downloadApprovedWorkOrder(Request $request){

        ini_set('max_execution_time', 0);
        $from_date = '';
        $to_date = '';
        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d'); 
        }
        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d'); 
        }

        $data = DB::table('CONS_WORKORDERBILL_VW')
                ->select(
                    'workorderbill_no_pk',
                    'workordermst_no_pk',
                    'workorder_ref_no',
                    'workorder_date',
                    'bill_date',
                    'work_start_date',
                    'work_completion_date',
                    'att_doc',
                    'last_approve_dt',
                    'paid_amount',
                    'vendor_name',
                    'draft_ind',
                    'serviceunit_no_fk',
                    'department',
                    'bill_amt as total_amount',
                    'billprocess_ind',
                    'bill_app_level_status_text as approval_level_status_text',
                    'bill_app_status_text as approval_status_text',  
                )->where('billprocess_ind',1)->where('app_status',1)->where('bill_app_status',1);

        if(!empty($request->department)){
            $data->where('serviceunit_no_fk', $request->department);
        }

        if(!empty($request->vendor)){
            $data->where('vendor_name', $request->vendor);
        }

        if(!empty($request->work_order_no)){
            $data->where('workordermst_no_pk', $request->work_order_no);
        }

        if(!empty($request->generated_status)){
            $data->where('bill_amount_status', $request->generated_status);
        }

        if(!empty($from_date) && !empty($from_date)){
            $data->whereBetween('bill_date', [$from_date, $to_date]);
        }elseif (!empty($from_date)) {
            $data->where('bill_date', $from_date);
        }elseif (!empty($to_date)) {
            $data->where('bill_date', $to_date);
        }

        $data = $data->get();

        $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();



        $pdf = PDF::loadView('admin.construction.export.approved_worklist', [ 'data' => $data,'po_hospital_details' => $po_hospital_details])
                        ->setPaper('a4', 'landscape');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('approved_work_order_worklist.pdf');
    }





    // partial Bill Generate

    public function partialBillGenerate($id){
        $bill_data = DB::table('cons_workorderbill')->where('workordermst_no_fk', $id)->where('status',1)->get();
        $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $id)->sum('total_amount');

        $data = [];
        $data['bill'] = collect($bill_data)->sum('bill_amt');
        $data['due'] = $total_amount - $data['bill'];
        $data['total_amount'] = $total_amount;
        $data['bill_history'] = $bill_data;
        $data['work_order'] = $id;
       return Template::loadView("admin.construction.modal.partial_bill_generate", ['data' => $data, 'order_no' => $id]);

    }

    public function partialBillEntry(Request $request){

        $request->validate([
            'bill_amount' => 'required',
            'work_order' => 'required',
        ]);
        try {

            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $bill_entry = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            $work_order = $request->work_order;
            $payment_data = DB::table('cons_workorderbill')->where('workordermst_no_fk', $work_order)->where('status',1)->get();
            $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $work_order)->sum('total_amount');
            $bill_amount = str_replace(",", "", $request->bill_amount);
            $bill_amount = floatval($bill_amount);
 
            $prev_bill = collect($payment_data)->sum('bill_amt');

            $total_bill = floatVal($bill_amount) + floatVal($prev_bill);
            if($bill_amount  == 0 || empty($bill_amount)){
                return response()->json(['title' => 'Failed', 'msg' => 'Zero amount is invalid', 'success' => false],422);
            }
            if($total_bill > $total_amount){
                return response()->json(['title' => 'Failed', 'msg' => 'Total Bill Amount can not Exceed', 'success' => false],422);
            }

            $seq = $this->getSequence('workorderbill_no_pk_seq');

            $attachment = '';
            if($request->hasFile('attachment')){
                $files = $request->file('attachment');
                $attachment = date('Ymdhi') . time(). "." . $files->getClientOriginalExtension();
                $request->attachment->move(public_path('/images/uploads/construction/bill'), $attachment);
            }

            $data = [
                'workorderbill_no_pk' => $seq,
                'workordermst_no_fk' => $work_order,
                'bill_date' => $au_entry_at,
                'bill_amt' => $bill_amount,
                'au_entry_at' => $bill_entry,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'attechment_file' => $attachment,
                'status' => 1,
                'remarks' => $request->remarks,
            ];

            DB::table('cons_workorderbill')->insert($data);


        
            $serviceunit_no_fk = DB::table('cons_workordermst')->where('workordermst_no_pk',$work_order)->value('serviceunit_no_fk');
            $id =  DB::table('cons_workorderbill')->orderByDesc('workorderbill_no_pk')->value('workorderbill_no_pk');
            //set approval process
            $out_apprprocess_no_pk = 0;
            $out_apprprocess_uid = 0;
            $in_approval_for_code = "WORKORDERBILL";
            $in_primary_key_value = $id;
            $in_primary_key_uid = $id;
            $in_serviceunit_no_fk = $serviceunit_no_fk;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = $entry_session;
            $in_au_entry_hospital_pk_no = $hospital_pk_no;
            $in_remarks = '';

            $out_error = 0;
            $pdo = DB::getPdo();
            $construction_work_order = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapprovaldept(
                                        :in_approval_for_code,   
                                        :in_primary_key_value,

                                        :in_primary_key_uid, 
                                        :in_remarks, 
                                        :in_serviceunit_no_fk,
                                        :in_au_entry_by,
                                        :in_au_entry_session,
                                        :in_au_entry_hospital_pk_no,
                                                                                
                                        :out_apprprocess_no_pk,
                                        :out_apprprocess_uid,
                                        :out_error
                                ); end;");

            $construction_work_order->bindparam('in_approval_for_code', $in_approval_for_code);
            $construction_work_order->bindparam('in_primary_key_value', $in_primary_key_value);
            $construction_work_order->bindparam('in_primary_key_uid', $in_primary_key_uid);
            $construction_work_order->bindparam('in_remarks', $in_remarks);

            $construction_work_order->bindparam('in_serviceunit_no_fk', $in_serviceunit_no_fk);
            $construction_work_order->bindparam('in_au_entry_by', $in_au_entry_by);
            $construction_work_order->bindparam('in_au_entry_session', $in_au_entry_session);
            $construction_work_order->bindparam('in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);

            $construction_work_order->bindParam('out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
            $construction_work_order->bindParam('out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 500);
            $construction_work_order->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $construction_work_order->execute();
            DB::table('cons_workordermst')->where('workordermst_no_pk',$work_order)->update(['billprocess_ind' => 1]); 


            DB::commit();
            return response()->json(['title' => 'Success', 'msg' => 'Successfully Bill Generated', 'success' => true],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['title' => 'Failed', 'msg' => $th->getMessage(), 'success' => false],422);
        }

    }

    public function partialBillHistory($id){

        $payment_data = DB::table('CONS_WORKORDERBILL_VW')
                         ->select(
                             'cons_workorderbill_vw.username as user_fullname',
                             'cons_workorderbill_vw.bill_remarks as remarks',
                             'cons_workorderbill_vw.bill_date',
                             'cons_workorderbill_vw.bill_amt',
                             'cons_workorderbill_vw.bill_app_level_status_text',
                             'cons_workorderbill_vw.bill_app_status_text',
                             'cons_workorderbill_vw.workorderbill_no_pk',
                             'cons_workorderbill_vw.attechment_file',
                             'cons_workorderbill_vw.workordermst_no_pk'

                             )
                         ->where('cons_workorderbill_vw.workordermst_no_pk', $id)
                         ->where('cons_workorderbill_vw.bill_status',1)
                         ->get();        
                         
        //    dd($payment_data);
        return Template::loadView("admin.construction.modal.partial_bill_history", ['data' => $payment_data, 'order_no' => $id]);
 
    }

    public function downloadBillHistory(Request $request){
        ini_set('max_execution_time', 0);
        $id = $request->work_order;
        $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
        $total_amount = DB::table('cons_workorder_vw')->where('workordermst_no_pk', $id)->sum('total_amount');
        $payment_data = DB::table('CONS_WORKORDERBILL')
                        ->join('wsec_user', 'wsec_user.user_no_pk', 'CONS_WORKORDERBILL.au_entry_by')
                        ->select(
                            'wsec_user.user_fullname',
                            'CONS_WORKORDERBILL.remarks',
                            'CONS_WORKORDERBILL.bill_date',
                            'CONS_WORKORDERBILL.bill_amt',
                            'CONS_WORKORDERBILL.au_entry_by'
                            )
                        ->where('CONS_WORKORDERBILL.workordermst_no_fk', $id)->where('CONS_WORKORDERBILL.status',1)->get();

        $pdf = PDF::loadView('admin.construction.export.partial_bill_history_pdf', ['total_amount' => $total_amount, 'data' => $payment_data, 'order_no' => $id ,'po_hospital_details' => $po_hospital_details])
                        ->setPaper('a4', 'portrait');

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('work_order_bill_history.pdf');
    }
}
