<?php

namespace App\Core\TV;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\TV\PharmacyTVService;

class PharmacyTVServiceDetails implements PharmacyTVService
{
    public function get_pharmacy_tv_data($id) {

        $today = date('Y-m-d');

        $counter = DB::table("OPD_PHRPATDISPLAY")
                    ->Join('SYSC_TVSCREEN','SYSC_TVSCREEN.TVSCREEN_NO_PK','OPD_PHRPATDISPLAY.TVSCREEN_NO_FK')
                    ->select('OPD_PHRPATDISPLAY.COUNTER_NO','OPD_PHRPATDISPLAY.COUNTER_NAME','SYSC_TVSCREEN.tvscreen_code')
                    ->whereNotIn('OPD_PHRPATDISPLAY.MOVEMENT_TYPE_NO',[3])
                    ->whereDate('OPD_PHRPATDISPLAY.INVOICE_DATE',$today)                    
                    ->where('opd_phrpatdisplay.counter_no','!=',0)
                    ->groupBy('OPD_PHRPATDISPLAY.COUNTER_NO','OPD_PHRPATDISPLAY.COUNTER_NAME','SYSC_TVSCREEN.tvscreen_code')
                    ->get()->toArray();
       
        foreach ($counter as $key => $value) {
            $value->patient = $this->get_counter_wise_patient($value->counter_no, $value->tvscreen_code);
        }
        
        return $counter;
    }

    public function get_counter_wise_patient($counter_no, $tvscreen_code){
        $today = date('Y-m-d');
        $query = DB::table("OPD_PHRPATDISPLAY")
                ->Join('SYSC_TVSCREEN','SYSC_TVSCREEN.TVSCREEN_NO_PK','OPD_PHRPATDISPLAY.TVSCREEN_NO_FK')
                ->whereNotIn('OPD_PHRPATDISPLAY.MOVEMENT_TYPE_NO',[3])
                ->select(
                    'OPD_PHRPATDISPLAY.INVOICE_NO_FK',
                    'OPD_PHRPATDISPLAY.INVOICE_DATE',
                    'OPD_PHRPATDISPLAY.TOKEN_NO',
                    'OPD_PHRPATDISPLAY.COUNTER_NO',
                    'OPD_PHRPATDISPLAY.COUNTER_NAME',
                    'OPD_PHRPATDISPLAY.PAT_NAME',
                    'OPD_PHRPATDISPLAY.MOVEMENT_TYPE_NO',
                    'OPD_PHRPATDISPLAY.TVSCREEN_NO_FK',
                    'SYSC_TVSCREEN.tvscreen_code'
                )
                ->whereDate('OPD_PHRPATDISPLAY.INVOICE_DATE',$today);

                if(!empty($counter_no)){
                    $query->where('OPD_PHRPATDISPLAY.COUNTER_NO',$counter_no);
                }else{
                    $query->whereNull('OPD_PHRPATDISPLAY.COUNTER_NO');  
                }
                
            $data = $query->where('SYSC_TVSCREEN.tvscreen_code',$tvscreen_code)
                ->orderBy('OPD_PHRPATDISPLAY.MOVEMENT_TYPE_NO', 'desc')
                ->orderBy('OPD_PHRPATDISPLAY.TOKEN_NO', 'asc')->get()->toArray();

        return $data;
    }
}