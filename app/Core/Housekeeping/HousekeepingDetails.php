<?php

namespace App\Core\Housekeeping;

use Illuminate\Support\Facades\DB;

use App\Core\Housekeeping\HouseKeepingMain as HousekeepingHouseKeepingMain;
use Session;

class HousekeepingDetails implements HousekeepingHouseKeepingMain
{
    public function get_housekeeping_details() {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hk_data = DB::table('stock_ledger_hk_vw')->get();

            return response()->json(['success' => true, 'data' => $hk_data], 200);
    }
}
