<?php

namespace App\Core\Ambulance;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Ambulance\Ambulance;
use App\LookupList;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Datatables\DataTableClass;
use Auth;

class AmbulanceDetails implements Ambulance
{
    use LookupData;
    public function ambulanceList()
    {
       $ambulance_info=DB::table('ambs_ambulance')->select('ambs_ambulance_name','ambs_ambulance_no_pk','no_plate')->where('status',1)->get();
       return response()->json($ambulance_info);
    }
    public function fineAmbulanceInfo($id)
    {
       $ambulance_info=DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$id)->first();
       return response()->json($ambulance_info);
    }
    public function allAmbulanceInfo()
    {
       $all_ambulance_info=DB::table('ambs_ambulance')->orderBy('status')->get();
       return response()->json($all_ambulance_info);
    }
    public function tripList($id)
    {
       $trip_info=DB::table('ambt_ambulancetrip')->select('ambt_ambulancetrip.*','per.full_name as driver_name','pt.patient_code','invoice.ledger_amt_sales','invoice.ledger_amt_discount','invoice.ledger_amt_payment')->leftJoin('hrms_personnel per','per.person_no_pk','=','ambt_ambulancetrip.person_no_fk')->leftJoin('patn_registration pt','pt.patient_no_pk','=','ambt_ambulancetrip.patient_no_fk')->leftJoin('finc_invoicewise_sum_vw invoice','invoice.invoice_no_pk','=','ambt_ambulancetrip.invoice_no_fk')->where('ambt_trip_no_pk',$id)->first();
      
       return response()->json($trip_info);
    }

    public function bockedTripList(){
        $bocked_trip_info=DB::table('ambt_ambulancetrip')->select('ambt_ambulancetrip.*','per.full_name as driver_name','amb.ambs_ambulance_name','amb.no_plate','pt.patient_code','invoice.ledger_amt_sales','invoice.ledger_amt_discount','invoice.ledger_amt_payment')->leftJoin('hrms_personnel per','per.person_no_pk','=','ambt_ambulancetrip.person_no_fk')->leftJoin('ambs_ambulance amb','amb.ambs_ambulance_no_pk','=','ambt_ambulancetrip.ambs_ambulance_no_fk')->leftJoin('patn_registration pt','pt.patient_no_pk','=','ambt_ambulancetrip.patient_no_fk')->leftJoin('finc_invoicewise_sum_vw invoice','invoice.invoice_no_pk','=','ambt_ambulancetrip.invoice_no_fk')->whereNull('end_time')->orderByDesc('ambt_trip_no_pk')->get();
      
        return response()->json($bocked_trip_info);
    }
    public function CompletedTripList(){
        $bocked_trip_info=DB::table('ambt_ambulancetrip')->select('ambt_ambulancetrip.*','per.full_name as driver_name','amb.ambs_ambulance_name','amb.no_plate','pt.patient_code','invoice.ledger_amt_sales','invoice.ledger_amt_discount','invoice.ledger_amt_payment')->leftJoin('hrms_personnel per','per.person_no_pk','=','ambt_ambulancetrip.person_no_fk')->leftJoin('ambs_ambulance amb','amb.ambs_ambulance_no_pk','=','ambt_ambulancetrip.ambs_ambulance_no_fk')->leftJoin('patn_registration pt','pt.patient_no_pk','=','ambt_ambulancetrip.patient_no_fk')->leftJoin('finc_invoicewise_sum_vw invoice','invoice.invoice_no_pk','=','ambt_ambulancetrip.invoice_no_fk')->whereNotNull('end_time')->orderByDesc('ambt_trip_no_pk')->get();
      
        return response()->json($bocked_trip_info);
    }

    public function ambulanceTripSave($request){
        try {
            $auth_id = Auth::id();
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $id=$request->trip_id;
            DB::beginTransaction();
            $sequence = DB::getsequence();
            $ambt_trip_no_pk_seq = $sequence->nextvalue('ambt_trip_no_pk_seq');
            $data=[
               
                'trip_patient_type'     =>$request->trip_patient_type ,
                'start_time'            =>$request->start_time !='' && $request->start_date !='' ? date('Y-m-d h:i',strtotime($request->start_date .' '.$request->start_time)):'' ,
                'end_time'              =>$request->end_time !='' && $request->end_date !='' ? date('Y-m-d h:i',strtotime($request->end_date .' '. $request->end_time)):''  ,
                'patient_no_fk'         =>$request->hdn_patient_id ,
                'admission_no_fk'       =>$request->admission_id ,
                'patient_name'          =>$request->patient_name ,
                'phone_mobile'          =>$request->mobile_no ,
                'start_from_location'   =>$request->from_location ,
                'ended_to_location'     =>$request->to_location ,
                'remarks_text'          =>$request->remarks,
                'total_bill'            =>$request->bill_amt ,
                'ambs_ambulance_no_fk'  =>$request->ambulance_name ,
                'person_no_fk'          =>$request->emp_id ,
                'status'                =>1 ,
              
            ];
            if ($id=='') {
                $data['ambt_trip_no_pk']        = $ambt_trip_no_pk_seq;
                $data['ambt_trip_date']         =date('Y-m-d h:i');
                $data['au_entry_by']            =$auth_id;
                $data['au_entry_at']            =date('Y-m-d h:i');
                $data['au_entry_hospital_pk_no']=$ses_hospital_id;
                DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$request->ambulance_name)->update(['status'=>2]);
                DB::table('ambt_ambulancetrip')->insert($data);
            }else{
                $data['au_update_by']=$auth_id;
                $data['au_update_at']=date('Y-m-d h:i');
                $data['au_update_hospital_pk_no']=$ses_hospital_id;
                if ($request->previous_amb_id != $request->ambulance_name) {
                    DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$request->previous_amb_id)->update(['status'=>1]);
                    DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$request->ambulance_name)->update(['status'=>2]);
                }
                if ($request->end_time !='' && $request->end_date !='') {
                    DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$request->ambulance_name)->update(['status'=>1]);
                }
                DB::table('ambt_ambulancetrip')->where('ambt_trip_no_pk',$id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
          
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
       
    }
    public function ambulanceSetupSave($request){
        try {
            $auth_id = Auth::id();
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $id=$request->ambulance_id;
            DB::beginTransaction();
            $sequence = DB::getsequence();
            $ambs_ambulance_no_pk_seq = $sequence->nextvalue('ambs_ambulance_no_pk_seq');
            $data=[
                
                'ambs_ambulance_name'=>$request->ambulance_name,
                'lic_expire_date'    =>$request->license_expiry_date  ? date('Y-m-d',strtotime($request->license_expiry_date)):'',
                'model_no'           =>$request->model_no,
                'lic_no'             =>$request->license_no,
                'no_plate'           =>$request->no_plate,
                'status'             =>$request->status,              
              
            ];
           
            if ($id=='') {
                $data['ambs_ambulance_no_pk']= $ambs_ambulance_no_pk_seq;
                $data['au_entry_by']=$auth_id;
                $data['au_entry_at']=date('Y-m-d h:i');
                $data['au_entry_hospital_pk_no']=$ses_hospital_id;
                DB::table('ambs_ambulance')->insert($data);
            }else{
                $data['au_update_by']=$auth_id;
                $data['au_update_at']=date('Y-m-d h:i');
                $data['au_update_hospital_pk_no']=$ses_hospital_id;              
                DB::table('ambs_ambulance')->where('ambs_ambulance_no_pk',$id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
          
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
       
    }

   
}
