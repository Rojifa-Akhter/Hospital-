<?php

namespace App\Traits;

use App\Models\Policy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

trait PolicyData
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPolicyAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $policy_info = db::table("pcrm_comission_policymst")
        ->select('policy_no_pk','policy_code','policy_desc','apply_to')
        ->where('status', 1)
        ->whereRaw(DB::raw("(upper(policy_code) like '%$keyword%' or upper(policy_desc) like '%$keyword%')"))->get();

        $policy_data = [];
        if(!empty($policy_info))
        {
            foreach ($policy_info as $patient) {
                $policy_data[] =  array (
                    'policy_id'       => $patient->policy_no_pk,
                    'policy_code'     => $patient->policy_code,
                    'policy_desc'     => $patient->policy_desc,
                    'apply_to'        => $patient->apply_to
                );
            }
            return $policy_data;
        }
    }

}