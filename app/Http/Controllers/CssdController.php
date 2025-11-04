<?php

namespace App\Http\Controllers;

use App\Http\Requests\CssdRequest;
use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use App\Models\ServiceUnit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class CssdController extends Controller
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
     * Send to CSSD
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

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.rtn_ind', null)
            ->where('mst.status', true)
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rcv_ind', 'mst.can_ind','mst.can_date','mst.can_by','mst.can_remarks')
            ->orderByDesc('reqmst_no_pk')
            ->get();

        return Template::loadview("admin.cssd.request-to-cssd.request-to-cssd", compact('departments', 'items'));
    }

    public function requestToCssdFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.rtn_ind', null)
            ->where('mst.status', true)
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND');

        if ($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if (!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if (!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if ($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.cssd.request-to-cssd.request-to-cssd-table", compact('items'));
    }

    public function returnToDepartmentFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'rtn_ind', 'rtnrcv_ind');

        if ($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if (!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if (!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if ($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadView("admin.cssd.cssd-pending-return-table", compact('items'));
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
            ->whereRaw('NVL(CSSD_IND,0) = 1')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->orderBy('item_name')
            ->get();

        return Template::loadview("admin.cssd.create", compact('departments', 'items'));
    }

    /**
     * Store CSSD
     */
    public function store(CssdRequest $request)
    {
        DB::beginTransaction();

        try {
            $cssd_requsitionmst_id = $this->getSequence('REQMST_NO_PK_SEQ');
            DB::table('cssd_requsitionmst')->insert([
                "REQMST_NO_PK"              => $cssd_requsitionmst_id,
                "REQ_DATE"                  => date('Y-m-d', strtotime($request->input('req_date'))),
                "SERVICEUNIT_NO_FK"         => $request->input('serviceunit_no_fk'),
                "REMARKS"                   => $request->input('remarks'),
                "status"                    => 1,
                "au_entry_at"               => Carbon::now()->toDateString(),
                "au_entry_by"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_PK_NO"   => session()->get('user.ses_hospital_no_pk'),
            ]);

            foreach ($request->input('item_no_fk') as $key => $item) {
                DB::table('cssd_requsitiondtl')->insert([
                    "REQUSITIONDTL_NO_PK"       => $this->getSequence('REQUSITIONDTL_NO_PK_SEQ'),
                    "REQMST_NO_FK"              => $cssd_requsitionmst_id,
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

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Successfully Saved'], 200);
        } catch (Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    public function returnToDepartmentDetails(int $id)
    {
        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadView("admin.cssd.return-to-department.details-return-to-department", compact('itemDetails'));
    }

    public function requestToCssdDetails(int $id)
    {
        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadView("admin.cssd.request-to-cssd.request-to-cssd-details", compact('itemDetails'));
    }

    public function receiveFromDepartmentDetails(int $id)
    {
        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadView("admin.cssd.receive-from-department.receive-from-department-details", compact('itemDetails'));
    }

    public function receiveFromCssdDetails(int $id)
    {
        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadView("admin.cssd.receive-from-cssd.receive-from-cssd-details", compact('itemDetails'));
    }

    public function print($id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $userInfo = Auth::user();

        $items = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $id)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind', 'item.item_name', 'dtl.item_qty', 'dtl.item_remarks', 'mst.rcv_ind', 'mst.can_ind','mst.can_date','mst.can_by','mst.can_remarks')
            ->get();

        $pdf = PDF::loadView("admin.cssd.send_to_cssd_pdf", [
            'po_hospital_details'   => $po_hospital_details,
            'userInfo'              => $userInfo,
            'items'                 => $items,
            // 'signature_data' => $signature_data,
        ]);

        return $pdf->stream("send_to_cssd.pdf", array("Attachment" => false));
    }

    /**
     * Receive by CSSD dept.
     */
    public function receiveByCssd(Request $request)
    {
        DB::beginTransaction();

        try {
            DB::table('CSSD_REQUSITIONMST')
                ->whereIn('reqmst_no_pk', $request->input('ids'))
                ->update([
                    'RCV_IND'   => 1,
                    'RCV_DATE'  => Carbon::now()->toDateString(),
                    'RCV_BY'    => Auth::id(),
                ]);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Successfully Received by CSSD'], 200);
        } catch (Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }


    /**
     * Cancel by CSSD dept.
     */
    public function cancelByCssd(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            DB::table('CSSD_REQUSITIONMST')
                ->whereIn('reqmst_no_pk', $request->input('ids'))
                ->update([
                    'CAN_IND'   => 1,
                    'CAN_DATE'  => Carbon::now()->toDateString(),
                    'CAN_BY'    => Auth::id(),
                    'CAN_REMARKS' => $request->input('remarks'),
                ]);

            DB::commit();

            return response()->json([
                'title' => 'Success',
                'success' => true,
                'msg' => 'Successfully Cancelled by CSSD'
            ], 200);
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([
                'title' => 'Error',
                'success' => false,
                'msg' => $exception->getMessage()
            ], 422);
        }
    }


    /**
     * CSSD Pending Receive
     */
    public function receiveFromCssd()
    {
        $departments = DB::table('sysc_v1_grant_servieceunit_vw')
            ->distinct()
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->orderBy('serviceunit_name')
            ->get();

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.au_entry_by', Auth::id())
            ->where('rcv_ind', true)
            ->where('rtn_ind', true)
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind')
            ->get();

        return Template::loadview("admin.cssd.receive-from-cssd.receive-from-cssd", compact('departments', 'items'));
    }

    public function receiveFromCssdFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.au_entry_by', Auth::id())
            ->where('rcv_ind', true)
            ->where('rtn_ind', true)
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.rtn_ind', 'mst.rtnrcv_ind');

        if ($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if (!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if (!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if ($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.cssd.receive-from-cssd.receive-from-cssd-table", compact('items'));
    }

    /**
     * CSSD Pending Receive
     */
    public function cssdPendingReceive()
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
            // ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->orderBy('serviceunit_name')
            ->get();

        $items = DB::table('CSSD_REQUSITIONMST as mst')
            // ->join('CSSD_REQUSITIONDTL as dtl', 'mst.REQMST_NO_PK', '=', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT as dept', 'mst.serviceunit_no_fk', '=', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM as item', 'mst.ITEM_NO_FK', '=', 'item.ITEM_NO_PK')
            ->whereNull('mst.rtn_ind')
            ->where(function ($q) {
                $q->whereNull('mst.CAN_IND')
                    ->orWhere('mst.CAN_IND', 0);
            })
            ->select(
                'mst.reqmst_no_pk',
                'dept.serviceunit_name',
                'mst.req_date',
                'mst.serviceunit_no_fk',
                'mst.remarks',
                'mst.rcv_ind',
                'mst.rcv_date',
                'mst.rcv_by',
                'mst.status',
                'mst.rcv_ind'
            )
            ->orderByDesc('mst.reqmst_no_pk')
            ->get();


        return Template::loadview("admin.cssd.receive-from-department.receive-from-department", compact('departments', 'items'));
    }

    public function receiveFromDepartmentFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('rtn_ind', null)
            // ->whereNull('mst.rtn_ind')
            ->where(function ($q) {
                $q->whereNull('mst.CAN_IND')
                    ->orWhere('mst.CAN_IND', 0);
            })
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'mst.can_ind','mst.can_date','mst.can_by','mst.can_remarks');

        if ($request->input('reqmst_no_pk') != "") {
            $items = $items->where('reqmst_no_pk', $request->input('reqmst_no_pk'));
        }

        if (!empty($from_date)) {
            $items = $items->whereDate('req_date', '>=', $from_date);
        }

        if (!empty($to_date)) {
            $items = $items->where('req_date', '<=', $to_date);
        }

        if ($request->input('serviceunit_no_fk') != "") {
            $items = $items->where('serviceunit_no_fk', $request->input('serviceunit_no_fk'));
        }

        $items = $items->orderByDesc('reqmst_no_pk')->get();

        return Template::loadview("admin.cssd.receive-from-department.receive-from-department-table", compact('items'));
    }

    /**
     * CSSD Pending Return
     */
    public function cssdPendingReturn()
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
            // ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->orderBy('serviceunit_name')
            ->get();

        $items = DB::table('CSSD_REQUSITIONMST mst')
            // ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            // ->join('SYSC_SERVICEITEM item', 'mst.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.rcv_ind', 1)
            ->select('reqmst_no_pk', 'serviceunit_name', 'req_date', 'serviceunit_no_fk', 'remarks', 'rcv_ind', 'rcv_date', 'rcv_by', 'mst.status', 'mst.RCV_IND', 'mst.rtn_ind', 'mst.rtnrcv_ind')
            ->orderByDesc('reqmst_no_pk')
            ->get();

        return Template::loadview("admin.cssd.return-to-department.cssd-pending-return", compact('departments', 'items'));
    }

    public function returnBackToDept(Request $request)
    {
        DB::beginTransaction();

        try {
            $reqmst_no_pk = null;

            foreach ($request->input('ids') as $itemId) {
                $itemDetails = DB::table('CSSD_REQUSITIONDTL')->where('REQUSITIONDTL_NO_PK', $itemId)->first();

                $reqmst_no_pk = $itemDetails->reqmst_no_fk;

                if (isset($itemDetails)) {
                    $exists = DB::table('CSSD_ISSUEDTL')->where('ITEM_NO_FK', $itemId)->first();

                    if (!isset($exists)) {
                        DB::table('CSSD_ISSUEDTL')->insert([
                            'ISSUEDTL_NO_PK'            => $this->getSequence('ISSUEDTL_no_pk_seq '),
                            'ISSUE_DATE'                => Carbon::now()->toDateString(),
                            'REQUSITIONDTL_NO_FK'       => $itemDetails->requsitiondtl_no_pk,
                            'ITEM_NO_FK'                => $itemId,
                            'ISSUE_QTY'                 => $itemDetails->item_qty,
                            'ISSUE_REMARKS'             => '',
                            'STATUS'                    => '',
                            'AU_ENTRY_BY'               => Auth::id(),
                            'AU_ENTRY_AT'               => Carbon::now()->toDateString(),
                            'AU_ENTRY_SESSION'          => auth()->user()->user_name,
                            'AU_ENTRY_HOSPITAL_PK_NO'   => session()->get('user.ses_hospital_no_pk'),
                        ]);
                    }
                } else {
                    throw new Exception("Sorry! Item Details Not Found");
                }
            }

            DB::table('CSSD_REQUSITIONMST')
                ->where('reqmst_no_pk', $reqmst_no_pk)
                ->update([
                    'RTN_IND'   => 1,
                    'RTN_DATE'  => Carbon::now()->toDateString(),
                    'RTN_BY'    => Auth::id(),
                ]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
        }

        // TODO:: Try to make it shorter
        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $reqmst_no_pk)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadview("admin.cssd.return-to-department.details-return-to-department", compact('itemDetails'));
    }

    public function itemReceiveFromCssd(Request $request)
    {
        DB::beginTransaction();

        try {
            $mstId = DB::table('CSSD_REQUSITIONDTL')
                ->where('REQUSITIONDTL_NO_PK', $request->input('ids')[0])
                ->first()
                ->reqmst_no_fk;

            $items = DB::table('CSSD_ISSUEDTL')->whereIn('REQUSITIONDTL_NO_FK', $request->input('ids'))
                ->update([
                    'RTNRCV_IND'    => 1,
                    'RTNRCV_DATE'   => Carbon::now()->toDateString(),
                    'RTNRCV_BY'     => Auth::id(),
                ]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
        }

        $itemDetails = DB::table('CSSD_REQUSITIONMST mst')
            ->join('CSSD_REQUSITIONDTL dtl', 'mst.REQMST_NO_PK', 'dtl.REQMST_NO_FK')
            ->leftJoin('CSSD_ISSUEDTL issueDtl', 'dtl.REQUSITIONDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK')
            ->join('SYSC_SERVICEUNIT dept', 'mst.serviceunit_no_fk', 'dept.SERVICEUNIT_NO_PK')
            ->join('SYSC_SERVICEITEM item', 'dtl.ITEM_NO_FK', 'item.ITEM_NO_PK')
            ->where('mst.REQMST_NO_PK', $mstId)
            ->select('mst.reqmst_no_pk', 'dept.serviceunit_name', 'mst.req_date', 'mst.serviceunit_no_fk', 'mst.remarks', 'mst.rcv_ind', 'mst.rcv_date', 'mst.rcv_by', 'mst.status', 'item.item_name', 'dtl.REQUSITIONDTL_NO_PK', 'dtl.item_qty', 'dtl.item_remarks', 'issueDtl.ISSUEDTL_NO_PK', 'issueDtl.REQUSITIONDTL_NO_FK', 'issueDtl.RTNRCV_IND')
            ->orderBy('dtl.REQUSITIONDTL_NO_PK')
            ->get();

        return Template::loadView("admin.cssd.receive-from-cssd.receive-from-cssd-details", compact('itemDetails'));
    }

    /**
     * CSSD Item List
     */
    public function itemList()
    {
        $item_names = DB::table('SYSC_SERVICEITEM')
            ->where('CSSD_IND', 1)
            ->select('item_name', 'ITEM_NO_PK')
            ->orderBy('item_name')
            ->get();

        $items = DB::table('sysc_v1_serviceitem_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('cssd_ind', 1)
            ->select('item_no_pk', 'item_code', 'item_name', 'item_short_name', 'item_type', 'serviceunit_name', 'manufacturer_no_fk', 'main_store_name', 'sales_price', 'vat_percent', 'item_no_pk', 'item_uom_name_2nd', 'item_uom_name_3rd', 'item_uom_name_4th', 'uom_no_fk_2nd_conv_ratio', 'uom_no_fk_3rd_conv_ratio', 'uom_no_fk_4th_conv_ratio')
            ->orderByDesc('item_code')
            ->get();

        return Template::loadview("admin.cssd.item-list", compact('item_names', 'items'));
    }

    /**
     * Filter:: CSSD Item List
     */
    public function searchItemList(Request $request)
    {
        $items = DB::table('sysc_v1_serviceitem_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('cssd_ind', 1)
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
