<?php
namespace App\Http\Controllers;

use DB;
use NumberFormatter;
use App\Library\Template;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use App\Datatables\DataTableClass;

class DueBillController extends Controller
{
    public function arReceiveList()
    {
        $fincArLedgerDetals = DB::table('finc_arledgerdtl')->orderByDesc('arledgerdtl_date')->get();
        $arLedgerDtlGroups  = DB::table('finc_arledgerdtl_groupvw')
            ->select('debtor_code', 'debtor_name')
            ->orderByDesc('arledgerdtl_date')
            ->get();

        return Template::loadView('admin.billing.ar_receive_list', compact('fincArLedgerDetals','arLedgerDtlGroups'));
    }

    public function arReceiveListData(Request $request)
    {
        $debtor_code = $request->debtor_code;
        $debtor_name = $request->debtor_name;

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to   = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : '';

        $sql_cond = "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $debtor_code != "" ? " $clause debtor_code = '$debtor_code'" : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $debtor_name != "" ? " $clause debtor_code = '$debtor_name'" : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(arledgerdtl_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";

        $table      = 'finc_arledgerdtl_groupvw';
        $primaryKey = 'ar_invoice_no_pk';

        $columns = [
            ['db' => 'ar_invoice_no_pk', 'dt' => 0],
            ['db' => 'arledgerdtl_date', 'dt' => 1],
            ['db' => 'amount',           'dt' => 2],
            ['db' => 'debtor_code',      'dt' => 3],
            ['db' => 'debtor_name',      'dt' => 4],
        ];

        if (!empty($sql_cond)) {
            return json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            return json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function arReceiveListDetails($id)
    {
        $fincArLedgerDetals = DB::table('finc_arledger_vw')->where('ar_invoice_no_pk', $id)->get();

        if (count($fincArLedgerDetals) == 0) {
            abort(404, 'Not Found!');
        }

        $totalAmount = $fincArLedgerDetals->sum('amount');

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $amountInWords = $numberTransformer->toWords($totalAmount);
        $amountInWords = ucwords(str_replace('-', ' ', $amountInWords));

        $firstData = $fincArLedgerDetals->first();

        return view('admin.billing.ar_receive_details', compact('fincArLedgerDetals', 'totalAmount', 'amountInWords', 'firstData'));
    }
}
