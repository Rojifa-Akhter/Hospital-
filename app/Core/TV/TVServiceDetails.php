<?php

namespace App\Core\TV;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\TV\TVService;

class TVServiceDetails implements TVService
{
    public function get_tv_data($id) {

        $today = date('Y-m-d');

        $doctor = DB::table("OPD_PATDISPLAY")
                    ->Join('SYSC_TVSCREEN','SYSC_TVSCREEN.TVSCREEN_NO_PK','OPD_PATDISPLAY.TVSCREEN_NO_FK')
                    ->select('OPD_PATDISPLAY.DOCTOR_NO','OPD_PATDISPLAY.DOCTOR_NAME','SYSC_TVSCREEN.tvscreen_code')
                    ->whereNotIn('OPD_PATDISPLAY.MOVEMENT_TYPE_NO',[3])
                    ->where('OPD_PATDISPLAY.BIL_IND',1)
                    ->where('OPD_PATDISPLAY.APPOINT_DATE',$today)
                    ->groupBy('OPD_PATDISPLAY.DOCTOR_NO','OPD_PATDISPLAY.DOCTOR_NAME','SYSC_TVSCREEN.tvscreen_code')
                    ->get()->toArray();


        foreach ($doctor as $key => $value) {
            $value->patient = $this->get_doctor_wise_patient($value->doctor_no, $value->tvscreen_code);
            // $value->today_completed = DB::table('OPD_PATDISPLAY')
            //                             ->Join('SYSC_TVSCREEN','SYSC_TVSCREEN.TVSCREEN_NO_PK','OPD_PATDISPLAY.TVSCREEN_NO_FK')
            //                             ->where('movement_type_no',3)
            //                             ->where('BIL_IND',1)
            //                             ->where('APPOINT_DATE',$today)
            //                             ->where('OPD_PATDISPLAY.DOCTOR_NO',$value->doctor_no)
            //                             ->where('SYSC_TVSCREEN.tvscreen_code',$value->tvscreen_code)
            //                             ->count();
        }
        return $doctor;
    }

    public function get_doctor_wise_patient($doctor_no, $tvscreen_code){
        $today = date('Y-m-d');
        $current_time = date('h:i:s A');
        $query = DB::table("OPD_PATDISPLAY")
                ->Join('SYSC_TVSCREEN','SYSC_TVSCREEN.TVSCREEN_NO_PK','OPD_PATDISPLAY.TVSCREEN_NO_FK')
                ->whereNotIn('OPD_PATDISPLAY.MOVEMENT_TYPE_NO',[3])
                ->select(
                    'OPD_PATDISPLAY.APPOINT_NO_FK',
                    'OPD_PATDISPLAY.PATIENT_NO_FK',
                    'OPD_PATDISPLAY.PAT_NAME',
                    'OPD_PATDISPLAY.DOC_CHEMBER',
                    'OPD_PATDISPLAY.ROOM_NAME',
                    'OPD_PATDISPLAY.DOCTOR_NO',
                    'OPD_PATDISPLAY.DOCTOR_NAME',
                    'OPD_PATDISPLAY.MOVEMENT_TYPE_NO',
                    'OPD_PATDISPLAY.TVSCREEN_NO_FK',
                    'SYSC_TVSCREEN.tvscreen_code'
                )
                ->selectRaw("TO_CHAR(OPD_PATDISPLAY.START_TIME, 'HH:MI:SS AM') AS start_time")
                ->selectRaw("TO_CHAR(OPD_PATDISPLAY.END_TIME, 'HH:MI:SS AM') AS end_time")
                ->where('OPD_PATDISPLAY.APPOINT_DATE',$today)
                ->where('OPD_PATDISPLAY.BIL_IND',1)
                ->where('OPD_PATDISPLAY.DOCTOR_NO',$doctor_no)
                ->where('SYSC_TVSCREEN.tvscreen_code',$tvscreen_code)
                ->orderBy('OPD_PATDISPLAY.MOVEMENT_TYPE_NO', 'desc')
                ->orderBy('OPD_PATDISPLAY.START_TIME', 'asc');
        $data = $query->get()->toArray();

        return $data;
    }
}