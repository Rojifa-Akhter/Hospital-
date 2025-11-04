<?php

namespace App\Core\Accounts\EmployeeInfo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\EmployeeInfo\Employee;


class EmployeeDetails implements Employee
{
    public function get_employee($search)
    {
        return $employee = DB::table('hrms_personnel_vw')
                        ->where('au_entry_hospital_pk_no', Auth::user()->au_entry_hospital_pk_no)
                        ->whereRaw('upper(full_name) LIKE '."'%".Str::upper($search)."%'")
                        ->get();
        
    }
}