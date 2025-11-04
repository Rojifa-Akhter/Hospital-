<?php

namespace App\Http\Controllers;

use Session;
use App\Library\Template;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BinCardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * BIN Card Listing
     */
    public function index()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
                        ->distinct()
                        ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                        ->where('user_no_pk', '=', Auth::user()->user_no_pk)
                        ->orderBy('serviceunit_name')
                        ->get();

        // $result = DB::table('INV_BINCARD_VW bin')
        //             ->join('SYSC_SERVICEUNIT dept', 'bin.stock_su_no_fk', 'dept.SERVICEUNIT_NO_PK')
        //             // ->whereDate('TRAN_DATE', date('Y-m-d'))
        //             ->select('bin.*', 'dept.SERVICEUNIT_NAME')
        //             ->orderBy('TRAN_DATE')
        //             ->get();

        $result = [];

        $items = [];
        // foreach($result as $row) {
        //     if(!isset($items[$row->serviceunit_name])) $items[$row->serviceunit_name] = [$row];
        //     else array_push($items[$row->serviceunit_name], $row);
        // }

        foreach($result as $row) {
            if(!isset($items[$row->item_name][$row->serviceunit_name])) $items[$row->item_name][$row->serviceunit_name] = [$row];
            else array_push($items[$row->item_name][$row->serviceunit_name], $row);
        }

        return Template::loadview("admin.bin-card.index", compact('departments', 'items'));
    }

    /**
     * Filter:: BIN Card
     */
    public function filter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('INV_BINCARD_VW bin')
                    ->join('SYSC_SERVICEUNIT dept', 'bin.stock_su_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->select('bin.*', 'dept.SERVICEUNIT_NAME');

        if($request->input('item_id') != "") {
            $items = $items->where('ITEM_NO_FK', $request->input('item_id'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('TRAN_DATE', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->whereDate('TRAN_DATE', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('STOCK_SU_NO_FK', $request->input('serviceunit_no_fk'));
        }

        $result = $items->orderBy('TRAN_DATE')->get();

        $items = [];
        // foreach($result as $row) {
        //     if(!isset($items[$row->serviceunit_name])) $items[$row->serviceunit_name] = [$row];
        //     else array_push($items[$row->serviceunit_name], $row);
        // }

        foreach($result as $row) {
            if(!isset($items[$row->item_name][$row->serviceunit_name])) $items[$row->item_name][$row->serviceunit_name] = [$row];
            else array_push($items[$row->item_name][$row->serviceunit_name], $row);
        }

        
        return Template::loadview("admin.bin-card.table", compact('items'));
    }

    /**
     * BIN Card Report
     * 
     * @param Request $request
     */
    public function report(Request $request)
    {
        // $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        // $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('INV_BINCARD_VW bin')
                    ->join('SYSC_SERVICEUNIT dept', 'bin.stock_su_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->select('bin.*', 'dept.SERVICEUNIT_NAME');

        if($request->input('item_id') != "") {
            $items = $items->where('ITEM_NO_FK', $request->input('item_id'));
        }

        // if(!empty($from_date)) {
        //     $items = $items->whereDate('TRAN_DATE', '>=', $from_date);
        // }

        // if(!empty($to_date)) {
        //     $items = $items->where('TRAN_DATE', '<=', $to_date);
        // }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('STOCK_SU_NO_FK', $request->input('serviceunit_no_fk'));
        }

        $result = $items->orderBy('TRAN_DATE')->get();

        $items = [];
        foreach($result as $row) {
            if(!isset($items[$row->item_name][$row->serviceunit_name])) $items[$row->item_name][$row->serviceunit_name] = [$row];
            else array_push($items[$row->item_name][$row->serviceunit_name], $row);
        }

        // $from_date = $request->input('from_date') ?? '';
        // $to_date = $request->input('to_date') ?? '';

        $pdf = ['items' => $items, 'print_type' => 'EXCEL'];
        $fileToExport = "bin-card";
        $html = View("admin.bin-card.excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    protected function formatDate($dateString)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        return $myDateTime->format('Y-m-d');
    }
}
