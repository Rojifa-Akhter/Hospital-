<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinenLaundryRequest;
use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class LinenLaundryController extends Controller
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
     * Send to Laundry
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
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

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.rtn_ind', null)
                    ->where('mst.status', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();

        return Template::loadview("admin.linenLaundry.request-to-laundry.request-to-laundry", compact('departments', 'items'));
    }

    public function requestToLaundryFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.rtn_ind', null)
                    ->where('mst.status', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND');
                    
        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();
        
        return Template::loadview("admin.linenLaundry.request-to-laundry.request-to-laundry-table", compact('items'));
    }

    public function requestToLaundryDetails(int $id)
    {
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadView("admin.linenLaundry.request-to-laundry.request-to-laundry-details", compact('itemDetails'));
    }

    public function returnToDepartmentFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('LNL_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'rtn_ind', 'rtnrcv_ind');
        
        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadView("admin.linenLaundry.return-to-department.return-to-department-table", compact('items'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
            ->distinct()
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->orderBy('serviceunit_name')
            ->get();

        $items = DB::table('SYSC_SERVICEITEM')
            ->whereRaw('NVL(WASHABLE_IND,0) = 1')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->orderBy('item_name')
            ->get();

        return Template::loadview("admin.linenLaundry.create", compact('departments', 'items'));
    }

    /**
     * Store Linen & Laundry
     */
    public function store(LinenLaundryRequest $request)
    {
        DB::beginTransaction();

        try {
            $linen_laundry_requsitionmst_id = $this->getSequence('lnl_requsitionmst_seq');
            DB::table('lnl_requsitionmst')->insert([
                "REQMST_NO_PK"              => $linen_laundry_requsitionmst_id,
                "REQ_DATE"                  => date('Y-m-d', strtotime($request->input('req_date'))),
                "SERVICEUNIT_NO_FK"         => $request->input('serviceunit_no_fk'),
                "REMARKS"                   => $request->input('remarks'),
                "status"                    => 1,
                "au_entry_at"               => Carbon::now()->toDateString(),
                "au_entry_by"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_PK_NO"   => session()->get('user.ses_hospital_no_pk'),
            ]);

            foreach($request->input('item_no_fk') as $key => $item)
            {
                DB::table('lnl_requsitiondtl')->insert([
                    "REQUSITIONDTL_NO_PK"       => $this->getSequence('lnl_requsitiondtl_seq'),
                    "REQMST_NO_FK"              => $linen_laundry_requsitionmst_id,
                    "ITEM_NO_FK"                => $request->input('item_no_fk')[$key],
                    "ITEM_QTY"                  => $request->input('item_qty')[$key],
                    "ITEM_REMARKS"              => $request->input('item_remarks')[$key],
                    "status"                    => 1,
                    "au_entry_at"               => Carbon::now()->toDateString(),
                    "au_entry_by"               => Auth::id(),
                    "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                    "AU_ENTRY_HOSPITAL_PK_NO"   => session()->get('user.ses_hospital_no_pk'),
                ]);
            }

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Successfully Send to Laundry'], 200);
        } catch(Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    /**
     * Show details
     */
    public function details(int $id)
    {
        $item = DB::table('lnl_requsitionmst mst')
                    ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.item_qty', 'dtl.item_remarks')
                    ->get();

        return response()->json(["success" => true, "data" => $item], 200);
    }

    public function receiveFromDepartmentDetails(int $id)
    {
        // $itemDetails = DB::table('LNL_REQUSITIONMST mst')
        //             ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
        //             ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
        //             ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
        //             ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
        //             ->where('mst.REQMST_NO_PK', $id)
        //             ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
        //             ->orderBy('dtl.REQUSITIONDTL_NO_PK')
        //             ->get();

        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadView("admin.linenLaundry.details", compact('itemDetails'));
    }

    public function receiveFromLaundryDetails(int $id)
    {
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadView("admin.linenLaundry.receive-from-laundry.receive-from-laundry-details", compact('itemDetails'));
    }

    /**
     * Print Report
     */
    public function print($id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $userInfo = Auth::user();

        $items = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind', 'item.item_name', 'dtl.item_qty', 'dtl.item_remarks')
                    ->get();

        $pdf = PDF::loadView("admin.linenLaundry.send_to_laundry_pdf", [
            'po_hospital_details'   => $po_hospital_details,
            'userInfo'              => $userInfo,
            'items'                 => $items,
            // 'signature_data' => $signature_data,
        ]);

        return $pdf->stream("send_to_laundry.pdf", array("Attachment" => false));
    }

    /**
     * Receive by Laundry dept.
     */
    public function receiveByLaundry(Request $request)
    {
        DB::beginTransaction();

        try {
            DB::table('LNL_REQUSITIONMST')
                ->whereIn('reqmst_no_pk', $request->input('ids'))
                ->update([
                    'RCV_IND'   => 1,
                    'RCV_DATE'  => Carbon::now()->toDateString(),
                    'RCV_BY'    => Auth::id(),
                ]);

            DB::commit();

        } catch(Exception $exception) {
            DB::rollback();
        }

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('RCV_IND', null)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();
        
        return Template::loadview("admin.linenLaundry.receive-from-department.receive-from-department-table", compact('items'));
    }

    public function returnedToDepartment()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
                            ->distinct()
                            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
                            ->orderBy('serviceunit_name')
                            ->get();

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('RCV_IND', true)
                    ->where('rtnrcv_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind')
                    ->get();

        return Template::loadview("admin.linenLaundry.returned-to-department.returned-to-department", compact('departments', 'items'));
    }

    public function returnedToDepartmentFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('RCV_IND', true)
                    ->where('rtnrcv_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND');

        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.linenLaundry.returned-to-department.returned-to-department-table", compact('items'));
    }

    public function returnedToDepartmentDetails(int $id)
    {
        // $itemDetails = DB::table('LNL_REQUSITIONMST mst')
        //     ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
        //     ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
        //     ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
        //     ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
        //     ->where('mst.REQMST_NO_PK', $id)
        //     ->where('RCV_IND', true)
        //     ->where('mst.rtnrcv_ind', true)
        //     ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
        //     ->orderBy('dtl.REQUSITIONDTL_NO_PK')
        //     ->get();

        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
            ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
            )
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->get();

        return Template::loadView("admin.linenLaundry.details", compact('itemDetails'));
    }

    public function history(int $id)
    {
        $history = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->join('WSEC_USER usr', 'issueDtl.rtnrcv_by', 'usr.USER_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_BY', 'issueDtl.RTNRCV_IND', "issueDtl.ISSUE_QTY", "issueDtl.rtnrcv_date", "usr.user_name", DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->orderBy('issueDtl.ISSUEDTL_NO_PK')
                    ->get();

        return Template::loadView("admin.linenLaundry.history", compact('history'));
    }

    public function receivedFromDepartmentDetails(int $id)
    {
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    ->where('RCV_IND', true)
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->get();

        return Template::loadView("admin.linenLaundry.received-from-department.received-from-department-details", compact('itemDetails'));
    }

    /**
     * Filter: Send to Laundry
     */
    public function sendToLinenLaundryFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND');
        
        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();
        
        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Receive from Laundry
     */
    public function receiveFromLaundry()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
                            ->distinct()
                            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
                            ->orderBy('serviceunit_name')
                            ->get();

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('rcv_ind', true)
                    ->where('rtn_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind')
                    ->get();

        return Template::loadview("admin.linenLaundry.receive-from-laundry.receive-from-laundry", compact('departments', 'items'));
    }

    public function receiveFromLaundryFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('rcv_ind', true)
                    ->where('rtn_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind');

        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.linenLaundry.receive-from-laundry.receive-from-laundry-table", compact('items'));
    }

    /**
     * Already Received from Laundry
     */
    public function receivedFromLaundry()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
                            ->distinct()
                            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
                            ->orderBy('serviceunit_name')
                            ->get();

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('rcv_ind', true)
                    ->where('rtn_ind', true)
                    // ->where('rtnrcv_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind')
                    ->get();

        return Template::loadview("admin.linenLaundry.received-from-laundry.received-from-laundry", compact('departments', 'items'));
    }

    public function receivedFromLaundryFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('rcv_ind', true)
                    ->where('rtn_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind');

        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.linenLaundry.received-from-laundry.received-from-laundry-table", compact('items'));
    }

    public function receivedFromLaundryDetails(int $id)
    {
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                ->where('mst.REQMST_NO_PK', $id)
                // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
                ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                    DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                    DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                )
                ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                ->get();

        return Template::loadView("admin.linenLaundry.received-from-laundry.received-from-laundry-details", compact('itemDetails'));
    }

    /**
     * Get Linen Laundry Receive Data
     */
    public function getLinenLaundryReceiveData()
    {
        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
                    ->where('mst.rtn_ind', null)
                    ->where('mst.rtnrcv_ind', null)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();

        return response()->json(["success" => true, "data" => $items], 200);        
    }

    public function receiveFromDepartmentFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('LNL_REQUSITIONMST mst')
                    // ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('rtn_ind', null)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND');

        if($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if(!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.linenLaundry.receive-from-department.receive-from-department-table", compact('items'));
    }

    /**
     * Linen & Laundry Receive
     */
    public function receiveFromDepartment()
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
                            // ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
                            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                            ->orderBy('serviceunit_name')
                            ->get();

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('RCV_IND', null)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();

        return Template::loadview("admin.linenLaundry.receive-from-department.receive-from-department", compact('departments', 'items'));
    }

    public function returnToDepartmentDetails(int $id)
    {
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadView("admin.linenLaundry.return-to-department.return-to-department-details", compact('itemDetails'));
    }

    public function returnToDepartmentHistory(int $id)
    {
        $history = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->join('WSEC_USER usr', 'issueDtl.rtnrcv_by', 'usr.USER_NO_PK')
                    ->where('mst.REQMST_NO_PK', $id)
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_BY', 'issueDtl.RTNRCV_IND', "issueDtl.ISSUE_QTY", "issueDtl.rtnrcv_date", "usr.user_name", DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->orderBy('issueDtl.ISSUEDTL_NO_PK')
                    ->get();

        return Template::loadView("admin.linenLaundry.history", compact('history'));
    }

    /**
     * Return to Department
     */
    public function returnToDepartment()
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
                            // ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
                            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
                            ->orderBy('serviceunit_name')
                            ->get();

        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.rcv_ind', true)
                    ->where('mst.rtnrcv_ind', null)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'mst.rtn_ind', 'mst.rtnrcv_ind')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();
        
        return Template::loadview("admin.linenLaundry.return-to-department.return-to-department", compact('departments', 'items'));
    }

    /**
     * Linen & Laundry Return Data
     */
    public function getLinenLaundryReturnData()
    {
        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.rcv_ind', 1)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'mst.rtn_ind')
                    ->orderByDesc('reqmst_no_pk')
                    ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Return back to department partially from Linen & Laundry dept.
     */
    public function returnBackToDept(Request $request)
    {
        DB::beginTransaction();

        try {
            $reqmst_no_pk = null;

            foreach(json_decode($request->input("payload")) as $item) {
                $itemDetails = DB::table('LNL_REQUSITIONDTL')->where('REQUSITIONDTL_NO_PK', $item->id)->first();

                $reqmst_no_pk = $itemDetails->reqmst_no_fk;

                if(isset($itemDetails)) {
                    DB::table('LNL_ISSUEDTL')->insert([
                        'ISSUEDTL_NO_PK'            => $this->getSequence('LNLISSUEDTL_NO_PK_SEQ '),
                        'ISSUE_DATE'                => Carbon::now()->toDateString(),
                        'REQUSITIONDTL_NO_FK'       => $itemDetails->requsitiondtl_no_pk,
                        'ITEM_NO_FK'                => $item->id,
                        'ISSUE_QTY'                 => $item->issue_qty,
                        'ISSUE_REMARKS'             => '',
                        'STATUS'                    => '',
                        'AU_ENTRY_BY'               => Auth::id(),
                        'AU_ENTRY_AT'               => Carbon::now()->toDateString(),
                        'AU_ENTRY_SESSION'          => auth()->user()->user_name,
                        'AU_ENTRY_HOSPITAL_PK_NO'   => session()->get('user.ses_hospital_no_pk'),
                    ]);
                } else {
                    throw new Exception("Sorry! Item Details Not Found");
                }
            }

            DB::table('LNL_REQUSITIONMST')
                ->where('reqmst_no_pk', $reqmst_no_pk)
                ->update([
                    'RTN_IND'   => 1,
                    'RTN_DATE'  => Carbon::now()->toDateString(),
                    'RTN_BY'    => Auth::id(),
                ]);

            DB::commit();
        } catch(Exception $exception) {
            DB::rollback();
        }

        // TODO:: Try to make it shorter
        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $reqmst_no_pk)
                    // ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND', DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK) alreadyrtn_qty"))
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadview("admin.linenLaundry.return-to-department.return-to-department-details", compact('itemDetails'));
    }

    /**
     * Item Receive from Laundry
     */
    public function itemReceiveFromLinenLaundry(Request $request)
    {
        DB::beginTransaction();

        try {
            $mstId = DB::table('LNL_REQUSITIONDTL')
                        ->where('REQUSITIONDTL_NO_PK', $request->input('ids')[0])
                        ->first()
                        ->reqmst_no_fk;

            $items = DB::table('LNL_ISSUEDTL')->whereIn('REQUSITIONDTL_NO_FK', $request->input('ids'))
                ->update([
                    'RTNRCV_IND'    => 1,
                    'RTNRCV_DATE'   => Carbon::now()->toDateString(),
                    'RTNRCV_BY'     => Auth::id(),
                ]);

            # START::RTNRCV_IND mark as true from LNL_REQUSITIONMST table when all items are received
            $itemWithDetails = DB::table("LNL_REQUSITIONMST mst")
                ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                ->where("mst.REQMST_NO_PK", $mstId)
                ->select("reqmst_no_pk", "requsitiondtl_no_pk", "item_qty")
                ->get();

            $allReceived = true;
            foreach($itemWithDetails as $item) {
                $issueDtl = DB::table("LNL_ISSUEDTL")
                    ->where("REQUSITIONDTL_NO_FK", $item->requsitiondtl_no_pk)
                    ->sum("ISSUE_QTY");
                
                if($issueDtl < $item->item_qty) {
                    $allReceived = false;
                    break;
                }
            }

            if($allReceived == true) {
                DB::table("LNL_REQUSITIONMST mst")->where("mst.REQMST_NO_PK", $mstId)->update([
                    "RTNRCV_IND"    => true,
                    "RTNRCV_DATE"   => Carbon::now()->toDateString(),
                ]);
            }
            # END::RTNRCV_IND mark as true from LNL_REQUSITIONMST table when all items are received

            DB::commit();
        } catch(Exception $exception) {
            DB::rollback();
        }

        $itemDetails = DB::table('LNL_REQUSITIONMST mst')
                    ->join('LNL_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->leftJoin('LNL_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.REQMST_NO_PK', $mstId)                    
                    ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK', 
                        DB::raw("(select sum(ISSUE_QTY) from LNL_ISSUEDTL where REQUSITIONDTL_NO_FK=dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 1) alreadyrtn_qty"),
                        DB::raw("(SELECT SUM(ISSUE_QTY) FROM LNL_ISSUEDTL WHERE REQUSITIONDTL_NO_FK = dtl.REQUSITIONDTL_NO_pK AND NVL(RTNRCV_IND, 0) = 0) PENDING_RCV_BY_DEPT_QTY")
                    )                    
                    ->orderBy('dtl.REQUSITIONDTL_NO_PK')
                    ->groupBy('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.REQUSITIONDTL_NO_FK')
                    ->get();

        return Template::loadView("admin.linenLaundry.receive-from-laundry.receive-from-laundry-details", compact('itemDetails'));
    }

    /**
     * Get Return Receive from Laundry
     */
    public function getReturnReceiveData()
    {
        $items = DB::table('lnl_requsitionmst mst')
                    // ->join('lnl_requsitiondtl dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
                    ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
                    // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
                    ->where('mst.au_entry_by', Auth::id())
                    ->where('rcv_ind', true)
                    ->where('rtn_ind', true)
                    ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind')
                    ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Linen & Laundry Item List
     */
    public function itemList()
    {
        $item_names = DB::table('SYSC_SERVICEITEM')
                            ->where('WASHABLE_IND', 1)
                            ->select('item_name', 'ITEM_NO_PK')
                            ->orderBy('item_name')
                            ->get();

        $items = DB::table('sysc_v1_serviceitem_vw')
				->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('WASHABLE_IND', 1)
				->select('item_no_pk', 'item_code', 'item_name', 'item_short_name', 'item_type', 'serviceunit_name', 'manufacturer_no_fk', 'main_store_name', 'sales_price', 'vat_percent', 'item_no_pk', 'item_uom_name_2nd', 'item_uom_name_3rd', 'item_uom_name_4th', 'uom_no_fk_2nd_conv_ratio', 'uom_no_fk_3rd_conv_ratio', 'uom_no_fk_4th_conv_ratio')
                ->orderByDesc('item_code')
				->get();

        return Template::loadview("admin.linenLaundry.item-list", compact('item_names', 'items'));
    }

    /**
     * Filter:: Linen & Laundry Item List
     */
    public function searchItemList(Request $request)
    {
        $items = DB::table('sysc_v1_serviceitem_vw')
				->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('WASHABLE_IND', 1)
				->select('item_no_pk', 'item_code', 'item_name', 'item_short_name', 'item_type', 'serviceunit_name', 'manufacturer_no_fk', 'main_store_name', 'sales_price', 'vat_percent', 'item_no_pk', 'item_uom_name_2nd', 'item_uom_name_3rd', 'item_uom_name_4th', 'uom_no_fk_2nd_conv_ratio', 'uom_no_fk_3rd_conv_ratio', 'uom_no_fk_4th_conv_ratio');

        $item_no_pk = $request->input('item_no_pk');

        if (!empty($item_no_pk)) {
            $items = $items->where('item_no_pk', $item_no_pk);
        }

        $items = $items->orderByDesc('item_code')->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    protected function formatDate($dateString)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        return $myDateTime->format('Y-m-d');
    }
}
