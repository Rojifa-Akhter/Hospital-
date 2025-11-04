<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserWiseDashboard extends Controller
{
    //
    public function __invoke()
    {
        $user_privileage_card =  DB::table('dashboard_item_setup')
            ->join("dashboard_item_data_query", "dashboard_item_data_query.db_item_no_fk", "dashboard_item_setup.dash_board_item_set_no_pk")
            ->join("dashboard_user_previlige", "dashboard_user_previlige.dashboard_item_no_fk", "dashboard_item_setup.dash_board_item_set_no_pk")
            ->where("dashboard_user_previlige.user_no_fk", Auth::user()->user_no_pk)
            ->where("dashboard_item_setup.card_ind", 1)
            ->get();
        $user_privileage_text =  DB::table('dashboard_item_setup')
            ->join("dashboard_item_data_query", "dashboard_item_data_query.db_item_no_fk", "dashboard_item_setup.dash_board_item_set_no_pk")
            ->join("dashboard_user_previlige", "dashboard_user_previlige.dashboard_item_no_fk", "dashboard_item_setup.dash_board_item_set_no_pk")
            ->where("dashboard_user_previlige.user_no_fk", Auth::user()->user_no_pk)
            ->where("dashboard_item_setup.text_ind", 1)
            ->get();
            
        //dd(   $user_privileage );
        return Template::loadView("admin.dashboards.user_wise_dashboard", [
            "user_privileage_card" => $user_privileage_card,
            "user_privileage_text" => $user_privileage_text,
        ]);
    }
}
// select sum(NET_SALES)
// from CORE_FINC_SUM_DT_ENTRYBY_LD_VW
// where trunc(INVOICE_DATE) = trunc(sysdate)
