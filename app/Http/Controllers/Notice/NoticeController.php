<?php

namespace App\Http\Controllers\Notice;

use DateTime;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{

    public function index(){
        $category = DB::table("notice_type")->select(
                                        'status',
                                        'hospital_no_pk',
                                        'notice_type_uid',
                                        'notice_type_name',
                                        'notice_type_no_pk',
                                        'notice_type_description'
                                    )->where('status', 1)->get();
        return Template::loadview("admin.notice.index", compact('category'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);

        try {

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
                     
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('notice_board_no_pk_seq');
            $file1 = "";
            
            if(isset($request->attach_file)) {                  
                $originalFileName = $request->attach_file->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName = time() . $sysc_pat_no_pk_seq . $cleanFileName;
                $request->attach_file->move(public_path('images/uploads/notice/file/'), $fileName);
                $file1 = $fileName;
            }

            $notice_date = '';
            if(!empty($request->date)){
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);  // define date format from user
                $notice_date = $dateTime->format('Y-m-d'); // define expected format
            }

            $data = [
                
                'title' => $request->title,
                'notice_type_no_fk' => $request->category,
                'notice_date' => $notice_date,
                'attach_file' => $file1,
                'notice_description' => $request->notice_description,
                'status' => isset($request->status) ? $request->status : 0,

            ];
            $msg = 'Successfully Saved';
            if($request->notice_pk != null && !empty($request->notice_pk)){   
                $msg = 'Successfully Updated';

                if(!($request->hasFile('attach_file'))){
                    $data['attach_file'] = $request->old_image;                                   
                }
                else{
                    $image1 = public_path('images/uploads/notice/file/').'/'.$request->old_image;
                    if(file_exists($image1)){
                        @unlink($image1);
                    } 
                }

                $data['au_update_at'] = $au_entry_at;
                $data['au_update_by'] = Auth::id();
                $data['au_update_session'] = $entry_session;
                $data['au_update_hospital_pk_no'] = $hospital_pk_no;  
                DB::table('wsec_notice_board')->where('notice_board_no_pk',$request->notice_pk)->update($data); 
            }
            else{

                $data['notice_board_no_pk'] = $sysc_pat_no_pk_seq;
                $data['au_entry_at'] = $au_entry_at;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_session'] = $entry_session;
                $data['au_entry_hospital_pk_no'] = $hospital_pk_no;
                DB::table('wsec_notice_board')->insert($data);  
            }
            
            return response()->json(['success' => true, 'message' => $msg], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }


    public function getNotice(){
       $data =  DB::table('wsec_notice_board')
                    ->select('wsec_notice_board.*','notice_type.notice_type_name')
                    ->leftJoin('notice_type','wsec_notice_board.notice_type_no_fk','=','notice_type.notice_type_no_pk')
                    ->get(); 
       return response()->json(['data' => $data, 'success' => true],200);
    }


    public function getNoticebyId($id){
       $data =  DB::table('wsec_notice_board')
                    ->select('wsec_notice_board.*','notice_type.notice_type_name')
                    ->leftJoin('notice_type','wsec_notice_board.notice_type_no_fk','=','notice_type.notice_type_no_pk')
                    ->where('wsec_notice_board.notice_board_no_pk',$id)
                    ->first(); 
       return response()->json(['data' => $data, 'success' => true],200);
    }

    // Notice Type
    public function indexNoticeType(){
        return Template::loadview("admin.notice.type");
    }

    public function getNoticeType(){
        $data =  DB::table('notice_type')->get(); 
        return response()->json(['data' => $data, 'success' => true],200);
     }


     public function storeType(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'max:1000'
        ]);

        try {

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
                     
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('notice_type_no_pk_seq');

            $data = [
                'notice_type_name' => $request->title,
                'notice_type_description' => $request->description,
                'status' => isset($request->status) ? $request->status : 0,
            ];

            $msg = 'Successfully Saved';

            if($request->type_pk != null && !empty($request->type_pk)){   
                $msg = 'Successfully Updated';
                $data['au_update_at'] = $au_entry_at;
                $data['au_update_by'] = Auth::id();
                $data['au_update_session'] = $entry_session;
                $data['au_update_hospital_pk_no'] = $hospital_pk_no;  
                DB::table('notice_type')->where('notice_type_no_pk',$request->type_pk)->update($data); 
            }
            else{

                $data['notice_type_no_pk'] = $sysc_pat_no_pk_seq;
                $data['notice_type_uid'] = $sysc_pat_no_pk_seq;
                $data['au_entry_at'] = $au_entry_at;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_session'] = $entry_session;
                $data['au_entry_hospital_pk_no'] = $hospital_pk_no;
                DB::table('notice_type')->insert($data);  
            }
            
            return response()->json(['success' => true, 'message' => $msg], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function getNoticeTypeById($id){
        $data =  DB::table('notice_type')
                     ->where('notice_type.notice_type_no_pk',$id)
                     ->first(); 
        return response()->json(['data' => $data, 'success' => true],200);
     }
}
