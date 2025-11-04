<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdmittedPatientSummary extends Controller
{
    public function index(){
        $requestDepts = DB::table('sysc_serviceunit')
        ->where('ipd_ind', 1)
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview('admin.ipd.admittedPatientSummary.index',compact('requestDepts'));

    }
}
