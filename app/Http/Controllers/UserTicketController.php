<?php

namespace App\Http\Controllers;

use DateTime;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.user_ticket.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("user-ticket.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'issue_name' => 'required',
            'issue_date' => 'required',
        ]);

        try {

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
                     
            $sequence = DB::getSequence();
            $sysc_pat_no_pk_seq = $sequence->nextValue('issue_no_pk_seq');
            $file1 = "";
            
            if(isset($request->attach_file)) {                  
                $originalFileName = $request->attach_file->getClientOriginalName();
                $cleanFileName = str_replace(' ', '_', $originalFileName);       
                $fileName = time() . $sysc_pat_no_pk_seq . $cleanFileName;
                $request->attach_file->move(public_path('images/uploads/issue/file/'), $fileName);
                $file1 = $fileName;
            }

            $data = [
                
                'issue_name' => $request->issue_name,
                'issue_person_name' => Auth::user()->user_name,
                'issue_date' => date("Y-m-d",strtotime($request->issue_date)),
                'issue_document' => $file1,
                'issue_descriptions' => $request->issue_description,
                'status' => isset($request->status) ? $request->status : 0,

            ];
            $msg = 'Successfully Saved';
            if($request->issu_pk != null && !empty($request->issu_pk)){    
                $msg = 'Successfully Updated';
                if(!isset($request->attach_file)){
                    $data['issue_document'] = $request->old_image;                                   
                }
                else{
                    $image1 = public_path('images/uploads/issue/file/').'/'.$request->old_image;
                    if(file_exists($image1)){
                        @unlink($image1);
                    } 
                }
                $data['au_update_at'] = $au_entry_at;
                $data['au_update_by'] = Auth::id();
                $data['au_update_session'] = $entry_session;
                $data['au_update_hospital_pk_no'] = $hospital_pk_no;  
                
                DB::table('hrms_issue_form')->where('issue_no_pk',$request->issu_pk)->update($data); 
            }
            else{

                $dateString = $request->issue_date;;
                $dateTimeObj = DateTime::createFromFormat('m/d/Y', $dateString);
                $timestamp = $dateTimeObj->getTimestamp();
                $current_my = date('Y-m-d', $timestamp);
                $formattedDate = substr($current_my,0,7);
                
                $issue_count = DB::table('hrms_issue_form')
                    ->select('issue_no_pk','issue_code','issue_date')         
                    ->whereRaw("SUBSTR(to_char(issue_date,'YYYY-MM-DD'), 0,7) = '$formattedDate'")
                    ->orderBy('issue_no_pk','asc')
                    ->get();
                // return $issue_count;
                $issue_count = count($issue_count) + 1;
                $issue_code = date("Ymd",strtotime($request->issue_date)).str_pad(@$issue_count, 3, '0', STR_PAD_LEFT);
                $issue_code = $this->checkIssueCode($issue_code); 
                    
                $data['issue_no_pk'] = $sysc_pat_no_pk_seq;
                $data['issue_no_pk_local'] = $sysc_pat_no_pk_seq;
                $data['issue_code'] = $issue_code;
                $data['au_entry_at'] = $au_entry_at;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_session'] = $entry_session;
                $data['au_entry_hospital_pk_no'] = $hospital_pk_no;
                $data['progress_status'] = 1;
                $data['person_no_fk'] = session()->get('user.ses_person_no_fk');
                
                DB::table('hrms_issue_form')->insert($data);  
            }
            
            $all_data = $this->getuserTicket();
            return response()->json(['success' => true, 'message' => $msg,'data' => $all_data->getData()->data], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
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


    public function getuserTicket(){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        $conditon = [
            'au_entry_hospital_pk_no' => $hospital_pk_no,
            'au_entry_by' => $auth_id
        ];
        $data = DB::table('hrms_issue_form')->where($conditon)
                ->select('issue_code','issue_no_pk','issue_name','issue_person_name','issue_date','issue_document','issue_descriptions','status','feedback','progress_status')
                ->orderBy('progress_status','asc')
                ->get();
        return response()->json(['success' => true, 'data' => $data],200);
    }

    public function checkIssueCode($issue_code){
        if(DB::table('hrms_issue_form')->where('issue_code',$issue_code)->count() > 0){
            $lastThreeDigits = intval(substr($issue_code, -3)) + 1;              
            $modifiedCode = substr_replace($issue_code, str_pad($lastThreeDigits, 6, '0', STR_PAD_LEFT), -3);
            return $this->checkIssueCode($modifiedCode);
        }
        else{
            return $issue_code;
        }
    }
}