<?php

namespace App\Core\Accounts\PatientInfo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\PatientInfo\Patient;


class PatientDetails implements Patient
{
    public function get_patient($search)
    {
        return $employee = DB::table('patient_info_vw')
                        ->where('au_entry_hospital_pk_no', Auth::user()->au_entry_hospital_pk_no)
                        ->whereRaw('upper(patient_name) LIKE '."'%".Str::upper($search)."%'")
                        ->get();
        
    }

}