<?php


namespace App\View;

use DB;
use Illuminate\View\View;
use Illuminate\Http\Request;


class OrgNameComposer
{
    public function compose(View $view)
    {
        $view->with('org_info', $this->org_information());
    }

    public function org_information()
    {
        return $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
    }
}