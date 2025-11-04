<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ChartOfAccountAutocomplete extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $chart_of_account =  DB::table('ACCT_CHART_OF_ACCOUNTS')
            ->where('POSTING_HEAD_IND', 1)
            ->whereRaw("upper(account_name) like upper('%$keyword%')")
            ->get();

        $chart_of_arr = [];
        if (!empty($chart_of_account)) {
            foreach ($chart_of_account as $accounts) {
                $chart_of_arr[] =  array(
                    'account_name'      => $accounts->account_name,
                    'account_no_pk'      => $accounts->account_no_pk,
                );
            }
        }

        return $chart_of_arr;
    }
}
