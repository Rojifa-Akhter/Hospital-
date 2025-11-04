<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Item;
use App\Traits\LookupData;
use Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\IndentApprovalSearchRequest;
use Illuminate\Support\Facades\Validator;
use PDF;
use PDO;
use Session;

class PharmacyController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'store_from' => 'required',
            'store_to' => 'required',
            'date' => 'required',
        ]);
        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
        });
        $validator->validate();
        DB::beginTransaction();
        try {
            $indent_no = '';
            $indent_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
            $store_from = $request->store_from;
            $store_to = $request->store_to;
            $return_reason = $request->reason;

            $item_no_fk_arr = $request->item_ids;
            $item_pvmsno_arr = $request->pvms_nos;
            $item_quantities_arr = $request->item_quantities;
            $item_uoms_arr = $request->item_uoms;
            $item_serial_dtl_arr = [];

            if (!empty($item_no_fk_arr)) {
                foreach ($item_no_fk_arr as $key => $item_no) {
                    $item_serial_dtl_arr[] = $key + 1;
                }
            }

            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            //dd($in_au_entry_hospital_pk_no);

            $numelems = 500;
            $null = '';
            $in_admission_no_fk = 0;
            $out_requisition_uid = '';
            $in_patient_no_fk = isset($request->hdn_patient_id) ? $request->hdn_patient_id : 0;
            $pdo = DB::getPdo();

            $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemrequisition(
    			:in_indent_no,
    			:in_indent_date,
    			:in_store_from_su_no_fk,
    			:in_store_to_su_no_fk,
                :in_patient_no_fk,
                :in_admission_no_fk,
    			:in_a_item_no_fk,
    			:in_a_item_pvmsno,
    			:in_a_item_qty,
    			:in_a_item_uom,
    			:in_a_entry_serial_dtl,
    			:in_au_entry_by,
    			:in_au_entry_session,
    			:in_au_entry_hospital_no_fk,
                :in_return_reason,
    			:out_requisition_uid
    		); end;");

            $receive_items->bindparam('in_indent_no', $indent_no);
            $receive_items->bindparam('in_indent_date', $indent_date);
            $receive_items->bindparam('in_store_from_su_no_fk', $store_from);
            $receive_items->bindparam('in_store_to_su_no_fk', $store_to);
            $receive_items->bindparam('in_patient_no_fk', $in_patient_no_fk);
            $receive_items->bindparam('in_admission_no_fk', $in_admission_no_fk);

            $receive_items->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_pvmsno', $item_pvmsno_arr, count($item_pvmsno_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $item_quantities_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_uom', $item_uoms_arr, count($item_quantities_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);

            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindparam('in_return_reason', $return_reason);

            $receive_items->bindParam(':out_requisition_uid', $out_requisition_uid, PDO::PARAM_STR, 500);

            $receive_items->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Indent No = ' . $out_requisition_uid . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }
    public function storeNurseStationIndent(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'store_from' => 'required',
        //     'store_to' => 'required',
        //     'date' => 'required',
        // ]);
        // $validator->after(function ($validator) use ($request) {
        //     if (empty($request->item_ids)) {
        //         return $validator->errors()->add('item', 'Items cannot be blank.');
        //     }
        // });

        // $validator->validate();
        DB::beginTransaction();
        try {
            $indent_no = '';
            $indent_date = date('Y-m-d');
            $nurse_station_dept = DB::table('ipd_admission_details')->join('ipds_nsds', 'ipds_nsds.nsds_no_pk', '=', 'ipd_admission_details.ns_receive_by')->select('ipds_nsds.su_no_fk')->where('admission_no_pk', $request->admission_id)->first();
            // dd( $nurse_station_dept);
            $store_from = $nurse_station_dept->su_no_fk;
            $store_to = $request->phr_department_id;
            // dd($store_from,$store_to);
            $return_reason = '';

            $item_no_fk_arr = $request->indent_req;
            // $item_quantities_arr = $request->item_quantities;
            // $item_uoms_arr = $request->item_uoms;
            $item_serial_dtl_arr = [];

            if (!empty($item_no_fk_arr)) {
                foreach ($item_no_fk_arr as $key => $item_no) {
                    $item_serial_dtl_arr[] = $key + 1;
                }
            }

            $qty = $uom = $item_id = $item_pvmsno_arr = [];
            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                // $check[$i]= 'indent_req;
                $uom[$i] = $request->input('uom_' . $item_no_fk_arr[$i]);
                $qty[$i] = $request->input('indent_qty_' . $item_no_fk_arr[$i]);
                $item_id[$i] = $request->input('item_id_' . $item_no_fk_arr[$i]);
                $pres_med[$i] = $request->input('pres_med_' . $item_no_fk_arr[$i]);
                $item_pvmsno_arr[$i] = '';
            }
            // dd( $item_no_fk_arr, $uom, $qty, $item_id);
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            //dd($in_au_entry_hospital_pk_no);

            $numelems = 500;
            $null = '';
            $out_requisition_uid = '';
            $admission_no = $request->admission_id;
            $pres_med_id = $request->pres_med_id;
            $in_patient_no_fk = isset($request->patient_id) ? $request->patient_id : 0;
            $pdo = DB::getPdo();
            // $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemrequisition(
            $receive_items = $pdo->prepare("begin  pkg_ipd.prc_ipdmedrequisition(
    			:in_patindentmst_no_pk,
    			:in_indent_date,
    			:in_store_from_su_no_fk,
    			:in_store_to_su_no_fk,
                :in_patient_no_fk,
                :in_admission_no_fk,
    			:in_pres_med_no_fk,
    			:in_a_item_no_fk,
    			:in_a_item_pvmsno,
    			:in_a_item_qty,
    			:in_a_item_uom,
    			:in_a_entry_serial_dtl,
    			:in_au_entry_by,
    			:in_au_entry_session,
    			:in_au_entry_hospital_no_fk,
                :in_return_reason,
    			:out_patindentmst_uid
    		); end;");

            $receive_items->bindparam('in_patindentmst_no_pk', $indent_no);
            $receive_items->bindparam('in_indent_date', $indent_date);
            $receive_items->bindparam('in_store_from_su_no_fk', $store_from);
            $receive_items->bindparam('in_store_to_su_no_fk', $store_to);
            $receive_items->bindparam('in_patient_no_fk', $in_patient_no_fk);
            $receive_items->bindparam('in_admission_no_fk', $admission_no);

            $receive_items->bindArray('in_pres_med_no_fk', $pres_med, count($pres_med), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_pvmsno', $item_pvmsno_arr, count($item_pvmsno_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $qty, count($qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_uom', $uom, count($uom), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);

            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindparam('in_return_reason', $return_reason);

            $receive_items->bindParam(':out_patindentmst_uid', $out_requisition_uid, PDO::PARAM_STR, 500);
            // dd($receive_items);
            $receive_items->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Indent No = ' . $out_requisition_uid . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function new_indent()
    {
        $return_reason = $this->getLookupListByCode("ITEM_RETURN_REASON");
        // dd($return_reason);

        return Template::loadview("admin.store.inventory.new_indent", [
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->where([
                    'user_no_fk' => Auth::id(),
                ])
                ->orWhere('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'))
                ->get()
                ->toArray(),
            'return_reason' => $return_reason,
        ]);
    }
    public function pharmacy_new_indent()
    {
        $return_reason = $this->getLookupListByCode("ITEM_RETURN_REASON");
        // dd($return_reason);

        return Template::loadview("admin.pharmacy.new_indent", [
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->where([
                    'user_no_fk' => Auth::id(),
                ])
                ->orWhere('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'))
                ->get()
                ->toArray(),
            'return_reason' => $return_reason,
        ]);
    }

    public function pharmacy_indent_worklist()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        //where au_entry_hospital_pk_no = '$ses_hospital_id'

        return Template::loadview("admin.pharmacy.indent_worklist", [
            'indents' => DB::select("select * from phr_requisition_vw left join sysc_serviceunit on sysc_serviceunit.serviceunit_no_pk = phr_requisition_vw.to_store_no_fk where sysc_serviceunit.pharmacy_ind = 1 and return_reason_name is null order by inv_requisition_no_pk desc"),
            //'indent_items' => $iis,
            //'indent_items_search' => '',
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->orWhere('user_no_fk', Auth::id())
                ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
                ->get()
                ->toArray(),
        ]);
    }
    public function pharmacyIndentItemReceivePdf(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                    ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                    ->where('sis.au_entry_hospital_pk_no', '=', $ses_hospital_id);
            });
        $indent_no = $request->indent_no;
        $from_date = $request->indent_date_from;
        $to_date = $request->indent_date_to;
        $store_no = $request->store_list;
        if (!empty($indent_no)) {
            $query->where('inv_requisition_uid', $indent_no);
        }

        if (!empty($request->store_list)) {
            $query->where('from_store_no_fk', $store_no);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($from_date)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($to_date)));
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($to_date)));
        }
        $indent_items = $query->select(
            'phrivw.inv_requisition_uid',
            'phrivw.inv_requisition_date',
            'phrivw.req_by_name',
            'phrivw.to_store_no_fk',
            'phrivw.to_store_name',
            'phrivw.from_store_no_fk',
            'phrivw.from_store_name',
            'phrivw.pvmsno',
            'phrivw.item_name',
            'phrivw.req_quantity',
            'phrivw.issue_quantity',
            'phrivw.recv_ind',
            'phrivw.inv_requisition_no_pk',
            'phrivw.inv_requisitiondtl_no_pk',
            'phrivw.recv_quantity',
            'phrivw.item_no_fk',
            'phrivw.expireable',
            'phrivw.patient_no_fk',
            'sis.balance_qty'
        )
            ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->orderBy('item_name', 'asc')
            ->get();
        $iis = [];

        if (!$indent_items->isEmpty()) {
            foreach ($indent_items as $ii) {
                $iis[$ii->inv_requisition_uid][] = $ii;
            }
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $store_name = DB::table('sysc_user_store_su_privs_vw')->select('serviceunit_name')
            ->where('su_no_fk', $store_no)->first()->serviceunit_name;
        //  dd($store_name);
        // //dd($iis);
        // return Template::loadview("admin.pharmacy.search_indent_item", [
        //     'indent_items_search' => $iis,
        // ]);

        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pharmacy.pharmacy_indent_received_by_item_pdf", [
            'barcode_no' => $barcode_no, 'indent_items_search' => $iis, 'from_date' => $from_date, 'to_date' => $to_date, 'store_name' => $store_name,
            'indent_no' => $indent_no, 'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('pharmacy_indent_received_by_item_pdf.pdf');
    }
    public function pharmacyIndentItemPdf(Request $request)
    {
        //dd('test');

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $indent_no = $request->indent_no;
        $from_date = $request->indent_date_from;
        $to_date = $request->indent_date_to;
        $query = DB::table('phr_requisition_vw');
        if (!empty($indent_no)) {
            $query->where('inv_requisition_uid', $indent_no);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($from_date)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($to_date)));
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($to_date)));
        }
        $indents = $query->where('au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('inv_requisition_no_pk', 'desc')->get()->toArray();
        // return Template::loadview("admin.pharmacy.search_indent", [
        //     'indents' => $query->where('au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('inv_requisition_no_pk', 'desc')->get()->toArray(),
        // ]);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $store_name = DB::table('sysc_user_store_su_privs_vw')->select('serviceunit_name')
        // ->where('su_no_fk', $store_no)->first();
        // dd($store_name);
        // //dd($iis);
        // return Template::loadview("admin.pharmacy.search_indent_item", [
        //     'indent_items_search' => $iis,
        // ]);

        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pharmacy.pharmacy_indent_item_pdf", [
            'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date,
            'indent_no' => $indent_no, 'po_hospital_details' => $po_hospital_details, 'indents' => $indents
        ])->setPaper('a4', 'landscape');
        return $pdf->download('pharmacy_indent_item_pdf.pdf');
    }
    public function pharmacyIssueWoklistPdf(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $indent_no = $request->indent_no;
        $from_date = $request->indent_date_from;
        $to_date = $request->indent_date_to;
        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })->select(
                'phrivw.inv_requisition_uid',
                'phrivw.inv_requisition_date',
                'phrivw.req_by_name',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.inv_requisition_no_fk',
                'phrivw.inv_requisitiondtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'sis.balance_qty'
            );
        if (!empty($indent_no)) {
            $query->where('phrivw.inv_requisition_uid', $indent_no);
        }
        // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        // ->orderBy('phrivw.inv_requisition_date', 'desc')
        // ->orderBy('phrivw.item_name', 'asc')
        // ->get();
        // $query = DB::table('phrivw.phr_requisition_vw');
        // if (!empty($request->indent_no)) {
        //     $query->where('inv_requisition_uid', $request->indent_no)->get();
        // }

        if (!empty($from_date) && !empty($to_date)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($from_date)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($to_date)));
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($to_date)));
        }
        $issue_worklist = $query
            ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            ->orderBy('phrivw.inv_requisition_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();
        //dd($query);
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->inv_requisition_uid][] = $iwl;
            }
        }
        // //dd($iwls);
        // return Template::loadview("admin.pharmacy.search_issue_worklist", [
        //     'issue_work_list' => $iwls,
        // ]);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // //dd($iis);
        // return Template::loadview("admin.pharmacy.search_indent_item", [
        //     'indent_items_search' => $iis,
        // ]);

        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pharmacy.pharmacy_issue_worklist_pdf", [
            'barcode_no' => $barcode_no, 'issue_work_list' => $iwls, 'from_date' => $from_date, 'to_date' => $to_date,
            'indent_no' => $indent_no, 'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('pharmacy_issue_worklist_pdf.pdf');
    }
    public function pharmacy_indent_worklist_v2($indent = "", $store = "")
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                    ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                    ->where('sis.au_entry_hospital_pk_no', '=', $ses_hospital_id);
            });
        if (!empty($indent)) {
            $query->where('inv_requisition_uid', $indent);
        }

        if (!empty($store)) {
            $query->where('from_store_no_fk', $store);
        }

        $indent_items = $query->select(
            'phrivw.inv_requisition_uid',
            'phrivw.inv_requisition_date',
            'phrivw.req_by_name',
            'phrivw.to_store_no_fk',
            'phrivw.to_store_name',
            'phrivw.from_store_no_fk',
            'phrivw.from_store_name',
            'phrivw.pvmsno',
            'phrivw.item_name',
            'phrivw.req_quantity',
            'phrivw.issue_quantity',
            'phrivw.recv_ind',
            'phrivw.inv_requisition_no_pk',
            'phrivw.inv_requisitiondtl_no_pk',
            'phrivw.recv_quantity',
            'phrivw.item_no_fk',
            'phrivw.expireable',
            'phrivw.patient_no_fk',
            'sis.balance_qty'
        )
            ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->orderBy('item_name', 'asc')
            ->get();
        $iis = [];

        if (!$indent_items->isEmpty()) {
            foreach ($indent_items as $ii) {
                $iis[$ii->inv_requisition_uid][] = $ii;
            }
        }

        //where au_entry_hospital_pk_no = '$ses_hospital_id'
        return Template::loadview("admin.pharmacy.indent_worklist", [
            'indents' => DB::select("select * from phr_requisition_vw where return_reason_name is null order by inv_requisition_no_pk DESC "),
            'indent_items_search' => $iis,
            //'indent_items_search' => '',
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->orWhere('user_no_fk', Auth::id())
                ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
                ->get()
                ->toArray(),
        ]);
    }
    public function inventory_indent_worklist()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $indent_items = DB::table('phr_requisition_item_vw as phrivw')
        //     ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
        //         $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
        //             ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
        //             ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
        //             ->where('sis.au_entry_hospital_pk_no', '=', '1');
        //     })->select(
        //         'phrivw.inv_requisition_uid',
        //         'phrivw.inv_requisition_date',
        //         'phrivw.req_by_name',
        //         'phrivw.to_store_no_fk',
        //         'phrivw.to_store_name',
        //         'phrivw.from_store_no_fk',
        //         'phrivw.from_store_name',
        //         'phrivw.pvmsno',
        //         'phrivw.item_name',
        //         'phrivw.req_quantity',
        //         'phrivw.issue_quantity',
        //         'phrivw.req_ind_text',
        //         'phrivw.inv_requisition_no_fk',
        //         'phrivw.inv_requisition_no_pk',
        //         'phrivw.recv_quantity',
        //         'phrivw.item_no_fk',
        //         'sis.balance_qty',
        //         'phrivw.expireable',

        //     )
        //     ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
        //     ->orderBy('inv_requisition_no_fk', 'desc')
        //     ->orderBy('item_name', 'asc')
        //     ->get();
        // //  dd($indent_items);

        // $iis = [];
        // if (!$indent_items->isEmpty()) {
        //     foreach ($indent_items as $ii) {
        //         $iis[$ii->inv_requisition_uid][] = $ii;
        //     }
        // }
        //dd($iis);
        //dd('test');
        // $stores = DB::table('sysc_user_store_su_privs_vw')
        // ->orWhere('user_no_fk', Auth::id())
        // ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
        // ->get()
        // ->toArray();
        // dd($stores);

        //dd(DB::select("select * from phr_requisition_vw  order by inv_requisition_no_pk DESC"))
        //where au_entry_hospital_pk_no = '$ses_hospital_id'

        return Template::loadview("admin.store.inventory.indent_worklist", [
            // 'indents' => DB::select("select * from phr_requisition_vw where return_reason_name is null order by inv_requisition_no_pk DESC "),
            'indents' => DB::select("select * from phr_requisition_vw left join sysc_serviceunit on sysc_serviceunit.serviceunit_no_pk = phr_requisition_vw.to_store_no_fk where sysc_serviceunit.pharmacy_ind = null or sysc_serviceunit.pharmacy_ind = 0 and return_reason_name is null order by inv_requisition_no_pk desc"),
            //'indent_items' => $iis,
            //'indent_items_search' => '',
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->orWhere('user_no_fk', Auth::id())
                ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
                ->get()
                ->toArray(),
        ]);
    }
    public function inventory_return_indent_worklist()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $indent_items = DB::table('phr_requisition_item_vw as phrivw')
        //     ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
        //         $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
        //             ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
        //             ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
        //             ->where('sis.au_entry_hospital_pk_no', '=', '1');
        //     })->select(
        //         'phrivw.inv_requisition_uid',
        //         'phrivw.inv_requisition_date',
        //         'phrivw.req_by_name',
        //         'phrivw.to_store_no_fk',
        //         'phrivw.to_store_name',
        //         'phrivw.from_store_no_fk',
        //         'phrivw.from_store_name',
        //         'phrivw.pvmsno',
        //         'phrivw.item_name',
        //         'phrivw.req_quantity',
        //         'phrivw.issue_quantity',
        //         'phrivw.req_ind_text',
        //         'phrivw.inv_requisition_no_fk',
        //         'phrivw.inv_requisition_no_pk',
        //         'phrivw.recv_quantity',
        //         'phrivw.item_no_fk',
        //         'sis.balance_qty',
        //         'phrivw.expireable',

        //     )
        //     ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
        //     ->orderBy('inv_requisition_no_fk', 'desc')
        //     ->orderBy('item_name', 'asc')
        //     ->get();
        // //  dd($indent_items);

        // $iis = [];
        // if (!$indent_items->isEmpty()) {
        //     foreach ($indent_items as $ii) {
        //         $iis[$ii->inv_requisition_uid][] = $ii;
        //     }
        // }
        //dd($iis);
        //dd('test');
        // $stores = DB::table('sysc_user_store_su_privs_vw')
        // ->orWhere('user_no_fk', Auth::id())
        // ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
        // ->get()
        // ->toArray();
        // dd($stores);

        //dd(DB::select("select * from phr_requisition_vw  order by inv_requisition_no_pk DESC"))
        //where au_entry_hospital_pk_no = '$ses_hospital_id'
        return Template::loadview("admin.store.inventory.indent_return_worklist", [
            'indents' => DB::select("select * from phr_requisition_vw  where return_reason_name is not null order by inv_requisition_no_pk DESC"),
            //'indent_items' => $iis,
            //'indent_items_search' => '',
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->orWhere('user_no_fk', Auth::id())
                ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
                ->get()
                ->toArray(),
        ]);
    }
    public function indent_item_details($indent_no)
    {
        //dd($indent_no);
        $person_no_fk = Session::get('user.ses_person_no_fk');
        // dd($person_no_fk);
        //dd($person_no_fk);
        $users_ind = DB::table('hrms_personnel')->where('person_no_pk', $person_no_fk)->select('inv_auth_admin_ind', 'inv_hod_ind', 'inv_auth_director_ind', 'inv_auth_chairman_ind')->first();
        $admin_ind = $users_ind->inv_auth_admin_ind;
        //dd($admin_ind);
        $hod_ind = $users_ind->inv_hod_ind;
        $director_ind = $users_ind->inv_auth_director_ind;
        $md_ind = $users_ind->inv_auth_chairman_ind;



        if ($hod_ind != 1 && $director_ind != 1 && $md_ind != 1) {

            $this->message = 'Insufficient Privileges. ';

            return Template::loadview("admin.pharmacy.indent_item_details", [
                'indent_items' => [],
                'users_ind' => $users_ind,
                'check_md_ind' => '',
                'msg' => $this->message

            ]);
        }


        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        if (isset($hod_ind)) {
            // dd('hod');
            $indent_items = DB::table('phr_requisition_item_vw')
                // ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                //     $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                //         ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                //         ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                //         ->where('sis.au_entry_hospital_pk_no', '=', '1');
                ->select(
                    // 'inv_requisition_uid',
                    // 'inv_requisition_date',
                    'req_by_name',
                    'req_at',
                    // 'phrivw.to_store_no_fk',
                    // 'phrivw.to_store_name',
                    // 'phrivw.from_store_no_fk',
                    // 'phrivw.from_store_name',
                    'aproval_hod_ind',
                    'aproval_diradm_ind',
                    'aproval_dirhospital_ind',
                    'aproval_md_chairman_ind',
                    'aproval_hod_name',
                    'aproval_diradm_name',
                    'aproval_dirhospital_name',
                    'aproval_md_chairman_name',
                    'aproval_hod_at',
                    'aproval_diradm_at',
                    'aproval_dirhospital_at',
                    'aproval_md_chairman_at',
                    'aproval_hod_by',
                    'aproval_diradm_by',
                    'aproval_dirhospital_by',
                    'aproval_md_chairman_by',

                    'pvmsno',
                    'item_name',
                    'req_quantity',
                    // 'issue_quantity',
                    // 'phrivw.req_ind_text',
                    'inv_requisition_no_fk',
                    'inv_requisitiondtl_no_pk',
                    // 'phrivw.recv_quantity',
                    // 'item_no_fk',
                    'uom_long'
                    //'sis.balance_qty',
                    //'phrivw.expireable'
                )
                ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('inv_requisition_no_fk', $indent_no)
                ->orderBy('inv_requisition_no_fk', 'desc')
                ->orderBy('item_name', 'asc')
                ->get();
            // dd($indent_items);
        }
        if (isset($admin_ind)) { //dd('admn');
            $indent_items = DB::table('phr_requisition_item_vw')

                ->select(
                    'req_by_name',
                    'req_at',
                    'aproval_hod_ind',
                    'aproval_diradm_ind',
                    'aproval_dirhospital_ind',
                    'aproval_md_chairman_ind',
                    'aproval_hod_name',
                    'aproval_diradm_name',
                    'aproval_dirhospital_name',
                    'aproval_md_chairman_name',
                    'aproval_hod_at',
                    'aproval_diradm_at',
                    'aproval_dirhospital_at',
                    'aproval_md_chairman_at',
                    'aproval_hod_by',
                    'aproval_diradm_by',
                    'aproval_dirhospital_by',
                    'aproval_md_chairman_by',

                    'pvmsno',
                    'item_name',
                    'req_quantity',
                    'inv_requisition_no_fk',
                    'inv_requisitiondtl_no_pk',
                    'uom_long'
                )
                ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('inv_requisition_no_fk', $indent_no)
                ->where('aproval_hod_ind', 1)
                ->orderBy('inv_requisition_no_fk', 'desc')
                ->orderBy('item_name', 'asc')
                ->get();
        }
        if (isset($director_ind)) {
            //dd('director');
            $indent_items = DB::table('phr_requisition_item_vw')
                // ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                //     $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                //         ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                //         ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                //         ->where('sis.au_entry_hospital_pk_no', '=', '1');
                ->select(
                    // 'inv_requisition_uid',
                    // 'inv_requisition_date',
                    'req_by_name',
                    'req_at',
                    // 'phrivw.to_store_no_fk',
                    // 'phrivw.to_store_name',
                    // 'phrivw.from_store_no_fk',
                    // 'phrivw.from_store_name',
                    'aproval_hod_ind',
                    'aproval_diradm_ind',
                    'aproval_dirhospital_ind',
                    'aproval_md_chairman_ind',
                    'aproval_hod_name',
                    'aproval_diradm_name',
                    'aproval_dirhospital_name',
                    'aproval_md_chairman_name',
                    'aproval_hod_at',
                    'aproval_diradm_at',
                    'aproval_dirhospital_at',
                    'aproval_md_chairman_at',
                    'aproval_hod_by',
                    'aproval_diradm_by',
                    'aproval_dirhospital_by',
                    'aproval_md_chairman_by',

                    'pvmsno',
                    'item_name',
                    'req_quantity',
                    // 'issue_quantity',
                    // 'phrivw.req_ind_text',
                    'inv_requisition_no_fk',
                    'inv_requisitiondtl_no_pk',
                    // 'phrivw.recv_quantity',
                    // 'item_no_fk',
                    'uom_long'
                    //'sis.balance_qty',
                    //'phrivw.expireable'
                )
                ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('inv_requisition_no_fk', $indent_no)
                //->where('aproval_diradm_ind', 1)
                ->where('aproval_hod_ind', 1)
                ->orderBy('inv_requisition_no_fk', 'desc')
                ->orderBy('item_name', 'asc')
                ->get();
        }


        if (isset($md_ind)) {
            //dd('md');
            $indent_items = DB::table('phr_requisition_item_vw')
                // ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                //     $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                //         ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                //         ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                //         ->where('sis.au_entry_hospital_pk_no', '=', '1');
                ->select(
                    // 'inv_requisition_uid',
                    // 'inv_requisition_date',
                    'req_by_name',
                    'req_at',
                    // 'phrivw.to_store_no_fk',
                    // 'phrivw.to_store_name',
                    // 'phrivw.from_store_no_fk',
                    // 'phrivw.from_store_name',
                    'aproval_hod_ind',
                    'aproval_diradm_ind',
                    'aproval_dirhospital_ind',
                    'aproval_md_chairman_ind',
                    'aproval_hod_name',
                    'aproval_diradm_name',
                    'aproval_dirhospital_name',
                    'aproval_md_chairman_name',
                    'aproval_hod_at',
                    'aproval_diradm_at',
                    'aproval_dirhospital_at',
                    'aproval_md_chairman_at',
                    'aproval_hod_by',
                    'aproval_diradm_by',
                    'aproval_dirhospital_by',
                    'aproval_md_chairman_by',

                    'pvmsno',
                    'item_name',
                    'req_quantity',
                    // 'issue_quantity',
                    // 'phrivw.req_ind_text',
                    'inv_requisition_no_fk',
                    'inv_requisitiondtl_no_pk',
                    // 'phrivw.recv_quantity',
                    // 'item_no_fk',
                    'uom_long'
                    //'sis.balance_qty',
                    //'phrivw.expireable'
                )
                ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('inv_requisition_no_fk', $indent_no)
                ->where('aproval_dirhospital_ind', 1)
                ->orderBy('inv_requisition_no_fk', 'desc')
                ->orderBy('item_name', 'asc')
                ->get();
        }

        $check_md_ind = '';
        foreach ($indent_items as $ii) {
            if (isset($ii->aproval_md_chairman_ind)) {
                $check_md_ind = 1;
                break;
            }
        }
        // dd($check_md_ind);
        // $iis = [];
        // if (!$indent_items->isEmpty()) {
        //     foreach ($indent_items as $ii) {
        //         $iis[$ii->inv_requisition_uid][] = $ii;
        //     }
        // }
        // $stores = DB::table('sysc_user_store_su_privs_vw')
        // ->orWhere('user_no_fk', Auth::id())
        // ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
        // ->get()
        // ->toArray();
        // dd($stores);

        //where au_entry_hospital_pk_no = '$ses_hospital_id'




        return Template::loadview("admin.pharmacy.indent_item_details", [
            'indent_items' => $indent_items,
            'users_ind' => $users_ind,
            'check_md_ind' => $check_md_ind,
            //  'admin_name' =>

        ]);
    }
    public function return_indent_item_details($indent_no)
    {
        //dd($indent_no);
        //$person_no_fk = Session::get('user.ses_person_no_fk');
        // dd($person_no_fk);
        //dd($person_no_fk);

        //dd($users_ind);
        //dd($person_no_fk);
        // dd($indent_no);
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        //dd('md');
        $indent_items = DB::table('phr_requisition_item_vw')
            // ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
            //     $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
            //         ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
            //         ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
            //         ->where('sis.au_entry_hospital_pk_no', '=', '1');
            ->select(
                // 'inv_requisition_uid',
                // 'inv_requisition_date',
                'req_by_name',
                'req_at',
                // 'phrivw.to_store_no_fk',
                // 'phrivw.to_store_name',
                // 'phrivw.from_store_no_fk',
                // 'phrivw.from_store_name'

                'pvmsno',
                'item_name',
                'req_quantity',
                // 'issue_quantity',
                // 'phrivw.req_ind_text',
                'inv_requisition_no_fk',
                'inv_requisitiondtl_no_pk',
                // 'phrivw.recv_quantity',
                // 'item_no_fk',
                'uom_long'
                //'sis.balance_qty',
                //'phrivw.expireable'
            )
            ->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('inv_requisition_no_fk', $indent_no)
            ->orderBy('inv_requisition_no_fk', 'desc')
            ->orderBy('item_name', 'asc')
            ->get();

        // dd($check_md_ind);
        // $iis = [];
        // if (!$indent_items->isEmpty()) {
        //     foreach ($indent_items as $ii) {
        //         $iis[$ii->inv_requisition_uid][] = $ii;
        //     }
        // }
        // $stores = DB::table('sysc_user_store_su_privs_vw')
        // ->orWhere('user_no_fk', Auth::id())
        // ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
        // ->get()
        // ->toArray();
        // dd($stores);

        //where au_entry_hospital_pk_no = '$ses_hospital_id'

        return Template::loadview("admin.pharmacy.indent_return_item_details", [
            'indent_items' => $indent_items,
            //  'admin_name' =>

        ]);
    }
    public function indent_verify(Request $request)
    {
        //  dd(Session::get('user.ses_user_name'));
        //dd($request->all());
        $indent_no = $request->indent_no;
        $hod_ind = $request->hod_ind;
        // $hod_verify_ind = $request->hod_verify_ind;
        $admin_ind = $request->admin_ind;
        // $admin_verify_ind = $request->admin_verify_ind;
        $director_ind = $request->director_ind;
        // $director_verify_ind = $request->director_verify_ind;
        $md_ind = $request->md_ind;
        // $md_verify_ind = $request->md_verify_ind;
        $rejected_items_pk = $request->rejected_items_pk;
        //dd($rejected_items);
        $dt = new \DateTime('now', new \DateTimezone('Asia/Dhaka'));
        $dateTime = $dt->format('Y-m-d H:i');
        DB::beginTransaction();
        //dd(json_decode($request->item_quantity));
        try {
            // foreach (json_decode($request->item_quantity) as $qty) {

            //     if (isset($admin_ind)) {
            //         DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', $indent_no)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
            //             'aproval_diradm_quantity' => $qty,
            //             'aproval_diradm_by' => session::get('user.ses_person_no_fk'),
            //             'aproval_diradm_ind' => $admin_ind,
            //             'aproval_diradm_at' => $dateTime

            //         ]);
            //     }
            // }
            for ($i = 0; $i < count($indent_no); $i++) {

                $check_exists = is_array($rejected_items_pk) ? in_array($indent_no[$i], $rejected_items_pk) : false;
                //dd($check_exists);
                if (isset($admin_ind)) {
                    //dd($check_exists);
                    if ($check_exists) {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_diradm_quantity' => $request->item_quantity[$i],
                            'aproval_diradm_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_diradm_ind' => 2,
                            'aproval_diradm_at' => $dateTime,

                        ]);
                    } else {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_diradm_quantity' => $request->item_quantity[$i],
                            'aproval_diradm_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_diradm_ind' => 1,
                            'aproval_diradm_at' => $dateTime,

                        ]);
                    }
                }
                if (isset($hod_ind)) {
                    if ($check_exists) {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_hod_quantity' => $request->item_quantity[$i],
                            'aproval_hod_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_hod_ind' => 2,
                            'aproval_hod_at' => $dateTime,

                        ]);
                    } else {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_hod_quantity' => $request->item_quantity[$i],
                            'aproval_hod_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_hod_ind' => 1,
                            'aproval_hod_at' => $dateTime,

                        ]);
                    }
                }
                if (isset($director_ind)) {
                    // dd('test');
                    if ($check_exists) {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_dirhospital_quantity' => $request->item_quantity[$i],
                            'aproval_dirhospital_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_dirhospital_ind' => 2,
                            'aproval_dirhospital_at' => $dateTime,

                        ]);
                    } else {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_dirhospital_quantity' => $request->item_quantity[$i],
                            'aproval_dirhospital_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_dirhospital_ind' => 1,
                            'aproval_dirhospital_at' => $dateTime,

                        ]);
                    }
                }
                if (isset($md_ind)) {
                    if ($check_exists) {

                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_md_chairman_quantity' => $request->item_quantity[$i],
                            'aproval_md_chairman_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_md_chairman_ind' => 2,
                            'aproval_md_chairman_at' => $dateTime,

                        ]);
                    } else {

                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', ($indent_no)[$i])->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update([
                            'aproval_md_chairman_quantity' => $request->item_quantity[$i],
                            'aproval_md_chairman_by' => Session::get('user.ses_user_pk_no'),
                            'aproval_md_chairman_ind' => 1,
                            'aproval_md_chairman_at' => $dateTime,

                        ]);
                    }
                }
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function search_indent(Request $request)
    {
        // dd('test');
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $query = DB::table('phr_requisition_vw')->select('phr_requisition_vw.*')->leftJoin('sysc_serviceunit', 'phr_requisition_vw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->where('sysc_serviceunit.pharmacy_ind', '=', null)->orWhere('sysc_serviceunit.pharmacy_ind', '=', 0)->where('phr_requisition_vw.return_reason_name', '=', null);

        // $query = DB::table('phr_requisition_vw');
        if (!empty($request->indent_no)) {
            $query->where('phr_requisition_vw.inv_requisition_uid', $request->indent_no);
        }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('phr_requisition_vw.inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        return Template::loadview("admin.pharmacy.search_indent", [
            'indents' => $query->where('phr_requisition_vw.au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('phr_requisition_vw.inv_requisition_no_pk', 'desc')->get()->toArray(),
        ]);
    }

    public function search_indent_new(Request $request)
    {
        // dd('test');
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $query = DB::table('phr_requisition_vw')->select('phr_requisition_vw.*')->leftJoin('sysc_serviceunit', 'phr_requisition_vw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->where('sysc_serviceunit.pharmacy_ind', '=', 1)->where('phr_requisition_vw.return_reason_name', '=', null);

        // $query = DB::table('phr_requisition_vw');
        if (!empty($request->indent_no)) {
            $query->where('phr_requisition_vw.inv_requisition_uid', $request->indent_no);
        }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('phr_requisition_vw.inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('phr_requisition_vw.inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        return Template::loadview("admin.pharmacy.search_indent_pharmacy", [
            'indents' => $query->where('phr_requisition_vw.au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('phr_requisition_vw.inv_requisition_no_pk', 'desc')->get()->toArray(),
        ]);
    }




    public function search_item_issue_worklist(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })
            ->leftJoin('sysc_serviceunit', 'phrivw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select(
                'phrivw.inv_requisition_uid',
                'phrivw.inv_requisition_date',
                'phrivw.req_by_name',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.inv_requisition_no_fk',
                'phrivw.inv_requisitiondtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'sis.balance_qty'
            );
        if (!empty($request->indent_no)) {
            $query->where('phrivw.inv_requisition_uid', $request->indent_no);
        }
        // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        // ->orderBy('phrivw.inv_requisition_date', 'desc')
        // ->orderBy('phrivw.item_name', 'asc')
        // ->get();
        // $query = DB::table('phrivw.phr_requisition_vw');
        // if (!empty($request->indent_no)) {
        //     $query->where('inv_requisition_uid', $request->indent_no)->get();
        // }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issue_worklist = $query
            ->where('sysc_serviceunit.pharmacy_ind', '=', 1)
            ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            ->orderBy('phrivw.inv_requisition_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();
        //dd($query);
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->inv_requisition_uid][] = $iwl;
            }
        }
        //dd($iwls);
        return Template::loadview("admin.pharmacy.search_issue_worklist", [
            'issue_work_list' => $iwls,
        ]);
    }


    public function search_inventory_item_issue_worklist(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $query = DB::table('phr_requisition_item_vw as phrivw')
        //     ->leftJoin('inv_itemstockmst as sis', function ($join) {
        //         $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
        //             ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
        //     })->select(
        //         'phrivw.inv_requisition_uid',
        //         'phrivw.inv_requisition_date',
        //         'phrivw.req_by_name',
        //         'phrivw.to_store_no_fk',
        //         'phrivw.to_store_name',
        //         'phrivw.from_store_no_fk',
        //         'phrivw.from_store_name',
        //         'phrivw.pvmsno',
        //         'phrivw.item_name',
        //         'phrivw.req_quantity',
        //         'phrivw.issue_quantity',
        //         'phrivw.issue_ind',
        //         'phrivw.inv_requisition_no_fk',
        //         'phrivw.inv_requisitiondtl_no_pk',
        //         'phrivw.recv_quantity',
        //         'phrivw.item_no_fk',
        //         'sis.balance_qty'
        //     );

        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })
            ->leftJoin('sysc_serviceunit', 'phrivw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select(
                'phrivw.inv_requisition_uid',
                'phrivw.inv_requisition_date',
                'phrivw.req_by_name',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.inv_requisition_no_fk',
                'phrivw.inv_requisitiondtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'sis.balance_qty'
            );
        // ->where('phrivw.inv_requisition_date', date('Y-m-d'))
        // ->where('sysc_serviceunit.pharmacy_ind', '=', null)
        // ->orWhere('sysc_serviceunit.pharmacy_ind', '=', 0)
        // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        // ->orderBy('phrivw.inv_requisition_date', 'desc')
        // ->orderBy('phrivw.item_name', 'asc')
        // ->get();

        if (!empty($request->indent_no)) {
            $query->where('phrivw.inv_requisition_uid', $request->indent_no);
        }

        if (!empty($request->store_list)) {
            $query->where('from_store_no_fk', $request->store_list);
        }
        // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        // ->orderBy('phrivw.inv_requisition_date', 'desc')
        // ->orderBy('phrivw.item_name', 'asc')
        // ->get();
        // $query = DB::table('phrivw.phr_requisition_vw');
        // if (!empty($request->indent_no)) {
        //     $query->where('inv_requisition_uid', $request->indent_no)->get();
        // }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issue_worklist = $query
            // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            // ->orderBy('phrivw.inv_requisition_date', 'desc')
            // ->orderBy('phrivw.item_name', 'asc')
            // ->get();
            // ->where('phrivw.inv_requisition_date', date('Y-m-d'))
            ->where('sysc_serviceunit.pharmacy_ind', '=', null)
            ->orWhere('sysc_serviceunit.pharmacy_ind', '=', 0)
            ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            ->orderBy('phrivw.inv_requisition_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();
        //dd($query);
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->inv_requisition_uid][] = $iwl;
            }
        }





        //     $query = DB::table('phr_requisition_item_vw as phrivw')
        //     ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
        //         $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
        //             ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
        //             ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
        //             ->where('sis.au_entry_hospital_pk_no', '=', $ses_hospital_id);
        //     });
        // if (!empty($request->indent_no)) {
        //     $query->where('inv_requisition_uid', $request->indent_no);
        // }

        // if (!empty($request->store_list)) {
        //     $query->where('from_store_no_fk', $request->store_list);
        // }

        // if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
        //     $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
        //     $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        // } elseif (!empty($request->indent_date_from)) {
        //     $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        // } elseif (!empty($request->indent_date_to)) {
        //     $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        // }
        // $indent_items = $query->select(
        //     'phrivw.inv_requisition_uid',
        //     'phrivw.inv_requisition_date',
        //     'phrivw.req_by_name',
        //     'phrivw.to_store_no_fk',
        //     'phrivw.to_store_name',
        //     'phrivw.from_store_no_fk',
        //     'phrivw.from_store_name',
        //     'phrivw.pvmsno',
        //     'phrivw.item_name',
        //     'phrivw.req_quantity',
        //     'phrivw.issue_quantity',
        //     'phrivw.recv_ind',
        //     'phrivw.inv_requisition_no_pk',
        //     'phrivw.inv_requisitiondtl_no_pk',
        //     'phrivw.recv_quantity',
        //     'phrivw.item_no_fk',
        //     'phrivw.expireable',
        //     'phrivw.patient_no_fk',
        //     'sis.balance_qty'
        // )
        //     ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
        //     ->orderBy('inv_requisition_no_pk', 'desc')
        //     ->orderBy('item_name', 'asc')
        //     ->get();
        // $iis = [];

        // if (!$indent_items->isEmpty()) {
        //     foreach ($indent_items as $ii) {
        //         $iis[$ii->inv_requisition_uid][] = $ii;
        //     }
        // }





        //dd($iwls);
        return Template::loadview("admin.pharmacy.search_issue_worklist", [
            'issue_work_list' => $iwls,
        ]);
    }



    public function search_item_issue_worklist_nurse_station(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('ipd_patindentmst_med_vw as phrivw')
            ->leftJoin('sysc_serviceitem item', 'item.item_no_pk', '=', 'phrivw.item_no_fk')
            ->leftJoin('employee_list_vw', 'employee_list_vw.person_no_pk', '=', 'phrivw.intransit_by')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })->select(
                'phrivw.patindentmst_no_pk',
                'phrivw.patindentmst_uid',
                'phrivw.tran_date',
                'phrivw.req_by_name',
                'phrivw.return_recv_quantity',
                'phrivw.after_return_recv_qty',
                'phrivw.return_after_receive_qty',
                'phrivw.after_return_recv_ind',
                'phrivw.return_after_receive_ind',
                'phrivw.return_recv_ind',
                'phrivw.indent_approval_at',
                'phrivw.indent_approval_by',
                'phrivw.indent_approval_qty',
                'phrivw.indent_approval_ind',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.recv_ind',
                'phrivw.return_quantity',
                'phrivw.return_ind',
                'phrivw.intransit_ind',
                'phrivw.patindentdtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'phrivw.patient_name',
                'phrivw.admission_no_fk',
                'sis.balance_qty',
                'employee_list_vw.full_name',
                'employee_list_vw.designation',
                'item.supplier_pk_no',
                'item.sales_price',
                'item.uom_no_fk',
                'phrivw.stock_qty',
                'phrivw.au_entry_session'
            );

        if (!empty($request->indent_no)) {
            $query->where('phrivw.patindentmst_uid', $request->indent_no);
        }
        if (!empty($request->hdn_admission_id)) {
            $query->where('phrivw.admission_no_fk', $request->hdn_admission_id);
        }
        // ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        // ->orderBy('phrivw.inv_requisition_date', 'desc')
        // ->orderBy('phrivw.item_name', 'asc')
        // ->get();
        // $query = DB::table('phrivw.phr_requisition_vw');
        // if (!empty($request->indent_no)) {
        //     $query->where('inv_requisition_uid', $request->indent_no)->get();
        // }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('tran_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('tran_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('tran_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('tran_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issue_worklist = $query
            ->where('admission_no_fk', '!=', null)
            ->where('indent_approval_ind', '=', 1)
            ->orderBy('phrivw.patindentmst_no_pk', 'desc')
            ->orderBy('phrivw.tran_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->patindentmst_uid][] = $iwl;
            }
        }
        // dd($iwls);
        $extra_med = [];
        if ($request->hdn_admission_id != "") {
            $extra_med = DB::table('psn_t_prescription_med')->select('psn_t_prescription_med.*', 'hrms_personnel.full_name as ipd_instructed_doc_name')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'psn_t_prescription_med.ipd_instruct_doc_person_no_fk')->where('admission_pk_no', $request->hdn_admission_id)->where('item_no_fk', 0)->get();
        }

        return Template::loadview("admin.pharmacy.search_issue_worklist_nurse_station", [
            'issue_work_list' => $iwls, 'extra_med' => $extra_med, 'admission_id' => $request->hdn_admission_id,
        ]);
    }

    public function ipd_phr_issue_all($item_details)
    {
        //  dd($item_details);
        $pId_qty = explode('_', $item_details);
        $item_id = $pId_qty[0];
        $qty = $pId_qty[1];
        $to_store_id = $pId_qty[2];
        $indent = $pId_qty[6];
        $from_store_id = $pId_qty[4];
        $patient_no_fk = isset($pId_qty[5]) ? $pId_qty[5] : '';
        // dd($pId_qty);
        /*
        Note
        1 = Patient
        2 = Employee or Adminstration

         */

        $type_of_consum = isset($pId_qty[6]) ? $pId_qty[6] : '';
        //$item_name = isset($pId_qty[6]) ? $pId_qty[6] : '';
        $type = '';

        $indent_data = DB::table('ipd_patindentdtl r')->select('r.*', 'item.*', 'admi.*')->where('patindentmst_no_fk', $pId_qty[6])->where('indent_approval_ind', 1)->leftJoin('sysc_serviceitem item', 'item.item_no_pk', '=', 'r.item_no_fk')->leftJoin('ipd_admission admi', 'admi.admission_no_pk', '=', 'r.admission_no_fk')->get();

        $admission_no = $indent_data[0]->admission_no_fk;
        $patindentdtl_no_pk = $indent_data[0]->patindentdtl_no_pk;
        $patindentmst_no_fk = $indent_data[0]->patindentmst_no_fk;
        $recive_qty = [];
        if (!empty($indent_data)) {
            $items = [];
            foreach ($indent_data as $value) {
                $items[] = $value->item_no_fk;
            }

            $recive_qty = DB::table('inv_trn_chd_vw')->whereIn('item_no_fk', $items)->where('stock_su_no_fk', $from_store_id)->where('stock_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->whereNotNull('expiry_date')->orderBy('expiry_date', 'asc')->get();
        }

        // dd($recive_qty);
        // $item_name = item::select("item_name", "purchase_price", "uom_no_fk", 'itemtype_no_fk')->where("item_no_pk", $item_id)->first();
        $item_name = DB::table('sysc_serviceitem')->select("item_name", "purchase_price", "uom_no_fk", 'itemtype_no_fk')->where("item_no_pk", $item_id)->first();
        //  dd($item_name);
        return Template::loadview("admin.pharmacy.show_indent_item_receive_popup_nurse_station_all", ['type_of_consum' => $type_of_consum, 'type' => $type, 'indent' => $indent, 'from_store_id' => $from_store_id, 'to_store_id' => $to_store_id, 'item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'patient_no_fk' => $patient_no_fk, 'recive_qty' => $recive_qty, 'indent_data' => $indent_data, 'admission_no' => $admission_no]);
    }
    public function search_item_issue_worklist_nurse_station_approval(IndentApprovalSearchRequest $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
      
        $query = DB::table('ipd_patindentmst_med_vw as phrivw')
            ->leftJoin('sysc_serviceitem item', 'item.item_no_pk', '=', 'phrivw.item_no_fk')
            ->leftJoin('employee_list_vw', 'employee_list_vw.person_no_pk', '=', 'phrivw.intransit_by')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })->select(
                'phrivw.patindentmst_no_pk',
                'phrivw.patindentmst_uid',
                'phrivw.tran_date',
                'phrivw.req_by_name',
                'phrivw.return_recv_quantity',
                'phrivw.after_return_recv_qty',
                'phrivw.return_after_receive_qty',
                'phrivw.after_return_recv_ind',
                'phrivw.return_after_receive_ind',
                'phrivw.return_recv_ind',
                'phrivw.recv_quantity',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.recv_ind',
                'phrivw.return_quantity',
                'phrivw.return_ind',
                'phrivw.intransit_ind',
                'phrivw.patindentmst_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'phrivw.patient_name',
                'phrivw.admission_no_fk',
                'phrivw.indent_approval_ind',
                'phrivw.indent_approval_qty',
                'phrivw.patindentmst_no_pk',
                'phrivw.patindentdtl_no_pk',
                'sis.balance_qty',
                'employee_list_vw.full_name',
                'employee_list_vw.designation',
                'item.supplier_pk_no',
                'item.sales_price',
                'item.uom_no_fk',
                'phrivw.pres_med_no_fk',
                'phrivw.stock_qty',
                'phrivw.au_entry_session'
            );

        if (!empty($request->indent_no)) {
            $query->where('phrivw.PATINDENTMST_UID', $request->indent_no);
        }
        if (!empty($request->hdn_admission_id)) {
            $query->where('phrivw.admission_no_fk', $request->hdn_admission_id);
        }
        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('tran_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('tran_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('tran_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('tran_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issue_worklist = $query
            ->where('admission_no_fk', '!=', null)
            ->orderBy('phrivw.patindentmst_no_pk', 'desc')
            ->orderBy('phrivw.tran_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();
        
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->patindentmst_uid][] = $iwl;
            }
        }
        $extra_med = [];
        if ($request->hdn_admission_id != "") {
            $extra_med = DB::table('psn_t_prescription_med')->select('psn_t_prescription_med.*', 'hrms_personnel.full_name as ipd_instructed_doc_name')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'psn_t_prescription_med.ipd_instruct_doc_person_no_fk')->where('admission_pk_no', $request->hdn_admission_id)->where('item_no_fk', 0)->get();
        }

        return Template::loadview("admin.pharmacy.search_issue_worklist_nurse_station_approval", [
            'issue_work_list' => $iwls, 'extra_med' => $extra_med,
        ]);
    }

    public function phr_indent_approval_store(Request $request)
    {

        if (empty($request->indent_approval)) {
            $this->message = ['msg' => 'Select Item.', 'title' => 'Error'];
            return response()->json($this->message);
        }



        $auth_id = Auth::id();
        $data = [];

        try {

            for ($i = 0; $i < count($request->indent_approval); $i++) {
                $indent_item_no = explode('_', $request->indent_approval[$i]);
                // if (!empty($indent_item_no[5] > $indent_item_no[4] || $indent_item_no[5] == 0)) {
                //     $this->message = ['msg' => 'Stock Qty. is less then Indent Qty', 'title' => 'Error'];
                //     return response()->json($this->message);
                // }



                $indant_no = $indent_item_no[0];
                $item_no = $indent_item_no[1];
                $presc_id = $indent_item_no[2];
                $dtl_id = $indent_item_no[3];
                $qty = $indent_item_no[4];
                $item = DB::table('sysc_serviceitem')->where('item_no_pk', $item_no)->first();
                //  dd($request->input("issue_quantity_" . $item_no));
                $data = [
                    'indent_approval_qty' => $qty,
                    // 'indent_approval_qty' => $request->input("issue_quantity_" . $item_no),
                    'item_name' => $item->item_name,
                    'item_no_fk' => $request->input("hdn_item_id_" . $item_no),
                    'indent_approval_ind' => 1,
                    'indent_approval_at' => date('Y-m-d'),
                    'indent_approval_by' => $auth_id,
                    'pres_med_no_fk' => $presc_id,
                    'alt_item_no_fk' => $item_no,
                ];
                // dd($data);
                // dd($indant_no,$item_no,$dtl_id);
                // DB::select("update table ipd_patindentdtl where item_no_fk = $item_no and patindentmst_no_fk = $indant_no set  indent_approval_qty = 150")
                // echo
                $sql =  DB::table('ipd_patindentdtl')->where('patindentmst_no_fk', $indant_no)->where('patindentdtl_no_pk', $dtl_id)->update($data);
                // dd($item_no.'_'.$indant_no.'_'.$request->input("issue_quantity_" . $item_no).'_'.$sql);
            }
            $this->message = ['msg' => 'Approved.', 'title' => 'Success'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = ['msg' => 'Approve create Failled.', 'title' => 'Error'];
        }

        return response()->json($this->message);
    }
    public function cancel_approve(Request $request)
    {

        $auth_id = Auth::id();
        $data = [];
        $indent_item_no_data[] = $request->indent_item_no;

        // try {

        for ($i = 0; $i < count($indent_item_no_data); $i++) {
            $indent_item_no = explode('_', $indent_item_no_data[$i]);

            $indant_no = $indent_item_no[0];
            $item_no = $indent_item_no[1];

            $data = [
                // 'indent_approval_qty'=> $request->input("issue_quantity_".$item_no),
                // 'item_name'=> $request->input("item_name_".$item_no),
                // 'item_no_fk'=> $request->input("hdn_item_id_".$item_no),
                'indent_approval_ind' => 0,
                'indent_approval_at' => date('Y-m-d'),
                'indent_approval_by' => $auth_id,
            ];

            DB::table('inv_requisitiondtl')->where('item_no_fk', $item_no)->where('inv_requisition_no_fk', $indant_no)->where('inv_requisition_no_fk', $indant_no)->update($data);
        }
        $this->message = ['msg' => 'Canceled', 'title' => 'Success'];
        DB::commit();
        // } catch (\Throwable $th) {
        //     dd(5);
        //     DB::rollback();
        //     $this->message = ['msg' => 'Canceled Failled.' , 'title' => 'Error',];
        // }

        return response()->json($this->message);
    }

    public function set_transit_by($indent_no = "", $item_no = "")
    {

        return Template::loadview("admin.pharmacy.set_pharmacy_transit_by", ['indent_no' => $indent_no, 'item_no' => $item_no]);
    }

    public function search_indent_item(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) use ($ses_hospital_id) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk')
                    ->on('sis.au_entry_hospital_pk_no', '=', 'phrivw.au_entry_hospital_pk_no')
                    ->where('sis.au_entry_hospital_pk_no', '=', $ses_hospital_id);
            });
        if (!empty($request->indent_no)) {
            $query->where('inv_requisition_uid', $request->indent_no);
        }

        if (!empty($request->store_list)) {
            $query->where('from_store_no_fk', $request->store_list);
        }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('inv_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('inv_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $indent_items = $query->select(
            'phrivw.inv_requisition_uid',
            'phrivw.inv_requisition_date',
            'phrivw.req_by_name',
            'phrivw.to_store_no_fk',
            'phrivw.to_store_name',
            'phrivw.from_store_no_fk',
            'phrivw.from_store_name',
            'phrivw.pvmsno',
            'phrivw.item_name',
            'phrivw.req_quantity',
            'phrivw.issue_quantity',
            'phrivw.recv_ind',
            'phrivw.inv_requisition_no_pk',
            'phrivw.inv_requisitiondtl_no_pk',
            'phrivw.recv_quantity',
            'phrivw.item_no_fk',
            'phrivw.expireable',
            'phrivw.patient_no_fk',
            'sis.balance_qty'
        )
            ->where('phrivw.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->orderBy('item_name', 'asc')
            ->get();
        $iis = [];

        if (!$indent_items->isEmpty()) {
            foreach ($indent_items as $ii) {
                $iis[$ii->inv_requisition_uid][] = $ii;
            }
        }
        //dd($iis);
        return Template::loadview("admin.pharmacy.search_indent_item", [
            'indent_items_search' => $iis,
        ]);
    }

    public function item_issue_worklist()
    {
        $issue_worklist = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })
            ->leftJoin('sysc_serviceunit', 'phrivw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select(
                'phrivw.inv_requisition_uid',
                'phrivw.inv_requisition_date',
                'phrivw.req_by_name',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.inv_requisition_no_fk',
                'phrivw.inv_requisitiondtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'sis.balance_qty'
            )
            ->where('phrivw.inv_requisition_date', date('Y-m-d'))
            ->where('sysc_serviceunit.pharmacy_ind', '=', 1)
            ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            ->orderBy('phrivw.inv_requisition_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')

            ->get();
        // dd($issue_worklist);
        // ->where('sis.au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_id'))
        // ->where('phrivw.requisition_date', '=', date('Y-m-d'))
        //->where('au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_id'))
        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->inv_requisition_uid][] = $iwl;
            }
        }
        // 'item_stats' => $this->worklistStats($issue_worklist)
        return Template::loadview("admin.pharmacy.item_issue_worklist", [
            'issue_work_list' => $iwls,
        ]);
    }

    public function inventory_item_issue_worklist()
    {
        // dd("test");
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $issue_worklist = DB::table('phr_requisition_item_vw as phrivw')
        //     ->leftJoin('inv_itemstockmst as sis', function ($join) {
        //         $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
        //             ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
        //     })->select(
        //         'phrivw.inv_requisition_uid',
        //         'phrivw.inv_requisition_date',
        //         'phrivw.req_by_name',
        //         'phrivw.to_store_no_fk',
        //         'phrivw.to_store_name',
        //         'phrivw.from_store_no_fk',
        //         'phrivw.from_store_name',
        //         'phrivw.pvmsno',
        //         'phrivw.item_name',
        //         'phrivw.req_quantity',
        //         'phrivw.issue_quantity',
        //         'phrivw.issue_ind',
        //         'phrivw.inv_requisition_no_fk',
        //         'phrivw.inv_requisitiondtl_no_pk',
        //         'phrivw.recv_quantity',
        //         'phrivw.item_no_fk',
        //         'sis.balance_qty'
        //     )
        //     ->where('phrivw.inv_requisition_date', date('Y-m-d'))
        //     ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
        //     ->orderBy('phrivw.inv_requisition_date', 'desc')
        //     ->orderBy('phrivw.item_name', 'asc')
        //     ->get();




        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $issue_worklist = DB::table('phr_requisition_item_vw as phrivw')
            ->leftJoin('inv_itemstockmst as sis', function ($join) {
                $join->on('sis.item_no_fk', '=', 'phrivw.item_no_fk')
                    ->on('sis.stock_su_no_fk', '=', 'phrivw.from_store_no_fk');
            })
            ->leftJoin('sysc_serviceunit', 'phrivw.to_store_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select(
                'phrivw.inv_requisition_uid',
                'phrivw.inv_requisition_date',
                'phrivw.req_by_name',
                'phrivw.to_store_no_fk',
                'phrivw.to_store_name',
                'phrivw.from_store_no_fk',
                'phrivw.from_store_name',
                'phrivw.pvmsno',
                'phrivw.item_name',
                'phrivw.req_quantity',
                'phrivw.issue_quantity',
                'phrivw.issue_ind',
                'phrivw.inv_requisition_no_fk',
                'phrivw.inv_requisitiondtl_no_pk',
                'phrivw.recv_quantity',
                'phrivw.item_no_fk',
                'sis.balance_qty'
            )
            ->where('phrivw.inv_requisition_date', date('Y-m-d'))
            ->where('sysc_serviceunit.pharmacy_ind', '=', null)
            ->orWhere('sysc_serviceunit.pharmacy_ind', '=', 0)
            ->orderBy('phrivw.inv_requisition_no_pk', 'desc')
            ->orderBy('phrivw.inv_requisition_date', 'desc')
            ->orderBy('phrivw.item_name', 'asc')
            ->get();




        // dd($issue_worklist);
        // ->where('sis.au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_id'))
        // ->where('phrivw.requisition_date', '=', date('Y-m-d'))
        //->where('au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_id'))


        $iwls = [];
        if (!$issue_worklist->isEmpty()) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->inv_requisition_uid][] = $iwl;
            }
        }
        // 'item_stats' => $this->worklistStats($issue_worklist)
        return Template::loadview("admin.pharmacy.inventory_item_issue_worklist", [
            'issue_work_list' => $iwls,
            'stores' => DB::table('sysc_user_store_su_privs_vw')
                ->orWhere('user_no_fk', Auth::id())
                ->orWhere('au_entry_hospital_no_fk', $ses_hospital_id)
                ->get()
                ->toArray(),
        ]);
    }



    public function item_issue_worklist_nurse_station()
    {
        $issue_worklist = DB::select("  SELECT PHRIVW.PATINDENTMST_NO_PK,
        PHRIVW.PATINDENTMST_UID,
        PHRIVW.TRAN_DATE,
        PHRIVW.REQ_BY_NAME,
        PHRIVW.RETURN_RECV_QUANTITY,
        PHRIVW.AFTER_RETURN_RECV_QTY,
        PHRIVW.RETURN_AFTER_RECEIVE_QTY,
        PHRIVW.AFTER_RETURN_RECV_IND,
        PHRIVW.RETURN_AFTER_RECEIVE_IND,
        PHRIVW.RETURN_RECV_IND,
        PHRIVW.INDENT_APPROVAL_AT,
        PHRIVW.INDENT_APPROVAL_BY,
        PHRIVW.INDENT_APPROVAL_QTY,
        PHRIVW.INDENT_APPROVAL_IND,
        PHRIVW.TO_STORE_NO_FK,
        PHRIVW.TO_STORE_NAME,
        PHRIVW.FROM_STORE_NO_FK,
        PHRIVW.FROM_STORE_NAME,
        PHRIVW.PVMSNO,
        PHRIVW.ITEM_NAME,
        PHRIVW.REQ_QUANTITY,
        PHRIVW.ISSUE_QUANTITY,
        PHRIVW.ISSUE_IND,
        PHRIVW.RECV_IND,
        PHRIVW.RETURN_QUANTITY,
        PHRIVW.RETURN_IND,
        PHRIVW.INTRANSIT_IND,
        PHRIVW.PATINDENTDTL_NO_PK,
        PHRIVW.RECV_QUANTITY,
        PHRIVW.ITEM_NO_FK,
        PHRIVW.PATIENT_NAME,
        PHRIVW.ADMISSION_NO_FK,
        SIS.BALANCE_QTY,
        EMPLOYEE_LIST_VW.FULL_NAME,
        EMPLOYEE_LIST_VW.DESIGNATION,
        ITEM.SUPPLIER_PK_NO,
        ITEM.SALES_PRICE,
        ITEM.UOM_NO_FK,
        PHRIVW.STOCK_QTY,
        phrivw.invoice_no_fk,
        phrivw.au_entry_session
   FROM IPD_PATINDENTMST_MED_VW phrivw
        LEFT JOIN SYSC_SERVICEITEM item
           ON ITEM.ITEM_NO_PK = PHRIVW.ITEM_NO_FK
        LEFT JOIN EMPLOYEE_LIST_VW
           ON EMPLOYEE_LIST_VW.PERSON_NO_PK = PHRIVW.INTRANSIT_BY
        LEFT JOIN INV_ITEMSTOCKMST sis
           ON SIS.ITEM_NO_FK = PHRIVW.ITEM_NO_FK
              AND SIS.STOCK_SU_NO_FK = PHRIVW.FROM_STORE_NO_FK
  where trunc(TRAN_DATE) between trunc(sysdate-2) and  trunc(sysdate) and ADMISSION_NO_FK IS NOT NULL AND INDENT_APPROVAL_IND = 1
ORDER BY PHRIVW.PATINDENTMST_NO_PK DESC,
        PHRIVW.TRAN_DATE DESC,
        PHRIVW.ITEM_NAME ASC");
        //  dd($issue_worklist);
        $iwls = [];
        if (!empty($issue_worklist)) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->patindentmst_uid][] = $iwl;
            }
        }
        // dd($iwls);
        $extra_med = [];
        // if ($request->hdn_admission_id != "") {
        $extra_med = DB::table('psn_t_prescription_med')->select('psn_t_prescription_med.*', 'hrms_personnel.full_name as ipd_instructed_doc_name')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'psn_t_prescription_med.ipd_instruct_doc_person_no_fk')->where('item_no_fk', 0)->get();
        // }
        return Template::loadview("admin.pharmacy.item_issue_worklist_nurse_station", [
            'issue_work_list' => $iwls, 'extra_med' => $extra_med,
        ]);
    }
    public function item_issue_worklist_nurse_station_approval()
    {
       
        $issue_worklist = DB::select("SELECT PHRIVW.PATINDENTMST_NO_PK,
               phrivw.patindentmst_uid,
               phrivw.tran_date,
               phrivw.req_by_name,
               phrivw.return_recv_quantity,
               phrivw.after_return_recv_qty,
               phrivw.return_after_receive_qty,
               phrivw.after_return_recv_ind,
               phrivw.return_after_receive_ind,
               phrivw.return_recv_ind,
               phrivw.recv_quantity,
               phrivw.to_store_no_fk,
               phrivw.to_store_name,
               phrivw.from_store_no_fk,
               phrivw.from_store_name,
               phrivw.pvmsno,
               phrivw.item_name,
               phrivw.req_quantity,
               phrivw.issue_quantity,
               phrivw.issue_ind,
               phrivw.recv_ind,
               phrivw.return_quantity,
               phrivw.return_ind,
               phrivw.intransit_ind,
               phrivw.patindentmst_no_pk,
               phrivw.recv_quantity,
               phrivw.item_no_fk,
               phrivw.patient_name,
               phrivw.admission_no_fk,
               phrivw.indent_approval_ind,
               phrivw.indent_approval_qty,
               phrivw.patindentmst_no_pk,
               phrivw.patindentdtl_no_pk,
               sis.balance_qty,
               employee_list_vw.full_name,
               employee_list_vw.designation,
               item.supplier_pk_no,
               item.sales_price,
               item.uom_no_fk,
               phrivw.pres_med_no_fk,
               phrivw.stock_qty,
               phrivw.au_entry_session
          FROM IPD_PATINDENTMST_MED_VW phrivw
               LEFT JOIN SYSC_SERVICEITEM item
                  ON ITEM.ITEM_NO_PK = PHRIVW.ITEM_NO_FK
               LEFT JOIN EMPLOYEE_LIST_VW
                  ON EMPLOYEE_LIST_VW.PERSON_NO_PK = PHRIVW.INTRANSIT_BY
               LEFT JOIN INV_ITEMSTOCKMST sis
                  ON SIS.ITEM_NO_FK = PHRIVW.ITEM_NO_FK
                     AND SIS.STOCK_SU_NO_FK = PHRIVW.FROM_STORE_NO_FK
                     where trunc(TRAN_DATE) between trunc(sysdate-2) and  trunc(sysdate) order by PHRIVW.PATINDENTMST_UID desc");
     
        $extra_med = [];
        $iwls = [];
        if (!empty($issue_worklist)) {
            foreach ($issue_worklist as $iwl) {
                $iwls[$iwl->patindentmst_uid][] = $iwl;
            }
        }
       

        return Template::loadview("admin.pharmacy.item_issue_worklist_nurse_station_approval", [
            'issue_work_list' => $iwls, 'extra_med' => $extra_med,
        ]);
    }

    public function update_item_issue(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'pk' => 'required',
            'issued_quantity' => 'required',
        ]);
        // dd($request->from_store_fk);
        $row_to_update = DB::table('inv_requisitiondtl as phrdtl')
            ->leftJoin('inv_itemstockmst as sis', function ($join) use ($request) {
                $join->on('phrdtl.item_no_fk', '=', 'sis.item_no_fk')
                    ->where('sis.stock_su_no_fk', '=', $request->from_store_fk)
                    ->where('sis.au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_no_pk'));
            })
            ->select('phrdtl.req_quantity', 'phrdtl.issue_quantity', 'phrdtl.uom', 'phrdtl.item_name', 'sis.balance_qty')
            ->where([
                'phrdtl.inv_requisitiondtl_no_pk' => $request->pk,
            ])
            ->first();
        // dd($row_to_update->balance_qty);
        // dd("iss $request->issued_quantity bl $request->balance_qty");
        // dd('bl'.$request->balance_qty);

        $validator->after(function ($validator) use ($row_to_update, $request) {
            if (!$row_to_update) {
                return $validator->errors()->add('pk', 'No row found for this item.!');
            }
            $max_issue_qty = $row_to_update->req_quantity - $row_to_update->issue_quantity;
            if ((int)$request->issued_quantity > (int)$row_to_update->balance_qty) {

                $validator->errors()->add('pk', 'Issue quantity cannot be greater than Stock Quantity. <br>');
            } else if ($request->issued_quantity > $max_issue_qty) {
                $validator->errors()->add('pk', 'Issue quantity cannot be greater than Indent Quantity. <br>');
            } else if ($row_to_update->issue_quantity == $row_to_update->req_quantity) {
                $validator->errors()->add('pk', 'Issue quantity is not available.');
            } elseif ($request->issued_quantity <= 0) {
                $validator->errors()->add('pk', 'Issue qty cannot be zero or negative!');
            }
        });
        $validator->validate();
        DB::beginTransaction();
        try {
            $issue_ind = 1;

            DB::table('inv_requisitiondtl')
                ->where([
                    'inv_requisitiondtl_no_pk' => $request->pk,
                ])->update([
                    'issue_quantity' => (int) $request->issued_quantity + (int) $row_to_update->issue_quantity,
                    'issue_at' => date('Y-m-d'),
                    'issue_by' => Auth::id(),
                    'issue_ind' => $issue_ind,
                    'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                ]);

            DB::commit();

            $this->message = [
                'msg' => 'Data Saved Successfully.<br>Indent No = ' . $request->in_transref_no .
                    '<br>Medicine = ' . $row_to_update->item_name .
                    '<br>Issue Quantity = ' . $request->issued_quantity,
                'title' => 'Success',
            ];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => 'Some Errors Occured.', 'title' => 'Error'];
        }
        return response()->json($this->message);
    }
    public function update_item_issue_nurse_station(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pk' => 'required',
            'issued_quantity' => 'required',
        ]);

        $row_to_update = DB::table('inv_requisitiondtl as phrdtl')
            ->leftJoin('inv_itemstockmst as sis', function ($join) use ($request) {
                $join->on('phrdtl.item_no_fk', '=', 'sis.item_no_fk')
                    ->where('sis.stock_su_no_fk', '=', $request->in_stock_su_no_fk)
                    ->where('sis.au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_no_pk'));
            })
            ->select('phrdtl.req_quantity', 'phrdtl.issue_quantity', 'phrdtl.uom', 'phrdtl.item_name', 'sis.balance_qty')
            ->where([
                'phrdtl.inv_requisitiondtl_no_pk' => $request->pk,
            ])
            ->first();

        // $validator->after(function ($validator) use ($row_to_update, $request) {
        //     if (!$row_to_update) {
        //         return $validator->errors()->add('pk', 'No row found for this item.!');
        //     }
        //     $max_issue_qty = $row_to_update->req_quantity - $row_to_update->issue_quantity;
        //     // dd($request->issued_quantity , $row_to_update->balance_qty);
        //     if ($request->issued_quantity > $row_to_update->balance_qty) {
        //         $validator->errors()->add('pk', 'Issue quantity cannot be greater than Stock Quantity. <br>');
        //     } else if ($request->issued_quantity > $max_issue_qty) {
        //         $validator->errors()->add('pk', 'Issue quantity cannot be greater than Indent Quantity. <br>');
        //     } else if ($row_to_update->issue_quantity == $row_to_update->req_quantity) {
        //         $validator->errors()->add('pk', 'Issue quantity is not available.');
        //     } elseif ($request->issued_quantity <= 0) {
        //         $validator->errors()->add('pk', 'Issue qty cannot be zero or negative!');
        //     }
        // });
        // $validator->validate();
        // @dd(array_sum($request->item_qty));
        DB::beginTransaction();
        // try {
        $chalan_no = $request->indent;
        $issue_ind = 1;
        $transitBy = $request->hdn_doctor_id ?? "";
        // dd( $request->hdn_doctor_id);
        DB::table('inv_requisitiondtl')
            ->where([
                'inv_requisitiondtl_no_pk' => $chalan_no,
            ])->update([
                'issue_quantity' => array_sum($request->item_qty),
                // (int) $request->issued_quantity + (int) $row_to_update->issue_quantity,
                'issue_at' => date('Y-m-d'),
                'issue_by' => Auth::id(),
                'issue_ind' => $issue_ind,
                'intransit_by' => $transitBy,
                'intransit_at' => date('Y-m-d'),
                'intransit_ind' => 1,
                'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
            ]);

        $chalan_date = date("Y-m-d");
        $from_store_id = $request->from_store_id;
        $to_store_id = $request->to_store_id;

        $demand_no_fk = 0;
        $in_suplier_no_fk = 0;
        $item_arr = [];
        $batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $item_uoms_arr = [];
        $item_prices_arr = [];
        $item_serial_dtl_arr = [];
        $item_name_arr = [];
        $hdn_item_type = [];
        $issue_qty_sum = 0;
        for ($i = 0; $i < count($request->item_batch_name); $i++) {
            $item_arr[$i] = $request->item_id;
            $item_name_arr[$i] = $request->item_name;
            $hdn_item_type[$i] = $request->in_itemtype_no_fk; //39==10000 (95==20000)
            $batch_arr[$i] = $request->item_batch_name[$i];
            $expire_arr[$i] = $request->exp_date[$i] != "" ? date('Y-m-d', strtotime($request->exp_date[$i])) : '';
            $quantity_arr[$i] = $request->item_qty[$i];
            $item_uoms_arr[$i] = $request->item_uom;
            $item_prices_arr[$i] = $request->item_price;
            $item_serial_dtl_arr[$i] = "";
            $issue_qty_sum += $quantity_arr[$i];
        }

        // dd($item_arr ,$item_name_arr ,$batch_arr);
        if ($issue_qty_sum > $request->sales_qty) {
            $this->message = ['msg' => 'Isssue Qty More Then Sales Qty', 'title' => 'Error'];
            return response()->json($this->message);
        }
        // dd( $batch_arr , $expire_arr );
        $numelems = 500;
        $null = '';
        $out_itemreceive_uid = '';
        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $pdo = DB::getPdo();
        $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemreceive_store2store(
            :in_transref_no,
            :in_transref_date,
            :in_stock_su_no_fk_from,
            :in_stock_su_no_fk_to,
            :in_a_item_no_fk,
            :in_item_batch_fk,
            :in_item_expiry_dt,
            :in_a_item_pvmsno,
            :in_a_item_qty,
            :in_a_item_uom,
            :in_a_item_price,

            :in_a_entry_serial_dtl,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_itemreceive_uid
        ); end;");

        $receive_items->bindparam('in_transref_no', $chalan_no);
        $receive_items->bindparam('in_transref_date', $chalan_date);
        $receive_items->bindparam('in_stock_su_no_fk_from', $from_store_id);
        $receive_items->bindparam('in_stock_su_no_fk_to', $to_store_id);
        //$receive_items->bindparam('in_demand_no_fk', $null);

        $receive_items->bindArray('in_a_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_a_item_pvmsno', $item_arr, count($item_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_a_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_item_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_item_price', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);
        $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
        $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
        $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
        $receive_items->bindParam(':out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
        // dd($receive_items);
        $receive_items->execute();

        // DB::commit();

        // create bill
        $qty_sum[] = array_sum($quantity_arr);
        $item_ids[] = $request->item_id;
        // dd( array_sum($quantity_arr));
        $chalan_no = 0; //$request->indent;
        $chalan_date = ""; //'date("Y-m-d");
        $from_store_id = $request->from_store_id;
        $to_store_id = $request->to_store_id;
        $demand_no_fk = 0;
        $in_suplier_no_fk = 0;
        $item_arr = [];
        $batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $item_uoms_arr = [];
        $item_prices_arr = [];
        $item_serial_dtl_arr = [];
        $item_name_arr = [];
        $hdn_item_type = [];
        // dd($item_ids);
        for ($i = 0; $i < count($item_ids); $i++) {
            $item_arr[$i] = $item_ids[$i];
            $item_que[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_arr[$i])->first();
            $item_name_arr[$i] = $item_que[$i]->item_name;
            $hdn_item_type[$i] = $item_que[$i]->itemtype_no_fk; //39==10000 (95==20000)
            $batch_arr[$i] = "";
            $expire_arr[$i] = "";
            // $quantity_arr[$i] = $request->item_quantities[$i];
            $item_uoms_arr[$i] = $item_que[$i]->uom_no_fk;
            $item_prices_arr[$i] = $item_que[$i]->sales_price;
            $item_serial_dtl_arr[$i] = "";
        }
        // indent
        $patient_details = DB::table('inv_requisitiondtl')->select('patient_no_fk', 'admission_no_fk')->where('inv_requisitiondtl_no_pk', $request->indent)->leftjoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'inv_requisitiondtl.admission_no_fk')->first();

        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $numelems = 500;
        $null = '';
        $out_itemreceive_uid = '';
        $service_unit = $request->serviceunit_no_fk;
        $demand_no = $request->demand_no;

        $store_su_no_fk = isset($request->store_name) ? $request->store_name : 0;

        $out_invoice_no = $out_invoice_id = $out_error = $out_ledgertrn_no = "";
        $in_ledgertrn_no = 0;
        $numelems = 5000;
        $total_item = count($item_arr);
        // if ($request->type_of_consum == 1) {
        //     $sum_qty =  array_sum($quantity_arr);
        //     DB::table('inv_requisitiondtl')->where('item_no_fk', $request->item_id)->where('inv_requisition_no_fk', $request->indent)->update([
        //         "item_consumption_qty" => $sum_qty,
        //         "item_consumption_at" => date('Y-m-d h:i:s'),
        //         "item_consumption_by" => Auth::user()->user_no_pk,
        //     ]);
        // } else {
        // if (isset($patient_details->patient_no_fk)) {

        $out_patient_no_pk = $patient_details->patient_no_fk;
        $admission_no = $patient_details->admission_no_fk;
        $payment_type = DB::table('ipd_medicine_inv_set')->first();
        // dd( $payment_type->ipd_setting_type);
        $pdo = DB::getPdo();
        if ($payment_type->ipd_setting_type == 1) {
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(
                            :in_invoice_date,
                            :in_invoice_datetime,
                            :in_module_no_fk,
                            :in_patient_no_fk,
                            :in_patient_code,
                            :in_admission_no_pk,
                            :in_admission_code,
                            :in_appointment_no_fk,
                            :in_prescription_no_fk,
                            :in_doc_person_no_fk,
                            :in_first_ref_doc_person_no_fk,
                            :in_second_ref_doc_person_no_fk,
                            :in_report_delivary_date,
                            :in_report_delivary_datetime,
                            :in_counter_su_no_fk,
                            :in_cor_client_no_fk,
                            :in_cor_client_card_no_fk,
                            :in_relation_lookup_no_fk,
                            :in_ref_invoice_no_fk,
                            :in_pat_type,
                            :in_dob,
                            :in_age,
                            :in_age_dd,
                            :in_age_mm,
                            :in_age_yy,
                            :in_customer_addr,
                            :in_customer_name,
                            :in_gender_txt,
                            :in_marital_status_txt,
                            :in_blood_group,
                            :in_phone_mobile,
                            :in_invoice_remarks,
                            :in_urgent_fee_total,
                            :in_invoice_type,
                            :in_emergency_ind,
                            :in_daycare_ind,
                            :in_ot_ind,
                            :in_au_entry_by,
                            :in_au_entry_session,
                            :in_au_entry_hospital_pk_no,
                            :in_item_level_disc_ind,
                            :in_item_count,
                            :in_item_no_fk,
                            :in_item_batch_fk,
                            :in_item_expiry_dt,
                            :in_item_name,
                            :in_itemtype_no_fk,
                            :in_item_qty,
                            :in_item_mu,
                            :in_item_rate,
                            :in_item_disc_percent,
                            :in_item_disc_amount,
                            :in_item_vat,
                            :in_urgent_fee,
                            :in_service_charge,
                            :in_report_delivery_date,
                            :in_report_delivery_time,
                            :in_delivery_status_lookup_no_fk,
                            :in_package_item_ind,
                            :in_item_level_remarks,
                            :in_provider_no_fk,
                            :in_ledgertrn_no,
                            :out_invoice_no,
                            :out_invoice_id,
                            :out_ledgertrn_no,
                            :out_error); end;");
            //Preparating Data

            date_default_timezone_set('Asia/Dhaka');
            // $date = date('d/m/Y h:i a');
            $cur_date = date("Y-m-d h:i:s");
            $cur_datetime = date("Y-m-d h:i:s");
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $null = '';
            $zero = 0;
            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            $auth_id = Auth::id();
            $entry_session = "Session";
            $hdn_doctor_id = $request->doctor_id;
            $billinvoice->bindParam(':in_invoice_date', $cur_date);
            $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
            $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
            $billinvoice->bindParam(':in_admission_no_pk', $admission_no);
            $billinvoice->bindParam(':in_admission_code', $null);
            $billinvoice->bindParam(':in_appointment_no_fk', $zero);
            $billinvoice->bindParam(':in_prescription_no_fk', $zero);
            $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
            $billinvoice->bindParam(':in_first_ref_doc_person_no_fk', $zero);
            $billinvoice->bindParam(':in_second_ref_doc_person_no_fk', $zero);
            $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
            $billinvoice->bindParam(':in_report_delivary_datetime', $cur_date);
            $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_card_no_fk', $zero);
            $billinvoice->bindParam(':in_relation_lookup_no_fk', $zero);
            $billinvoice->bindParam(':in_ref_invoice_no_fk', $zero);
            $billinvoice->bindParam(':in_pat_type', $zero);
            $billinvoice->bindParam(':in_dob', $null);
            $billinvoice->bindParam(':in_age', $zero);
            $billinvoice->bindParam(':in_age_dd', $zero);
            $billinvoice->bindParam(':in_age_mm', $zero);
            $billinvoice->bindParam(':in_age_yy', $zero);
            $billinvoice->bindParam(':in_customer_addr', $null);
            $billinvoice->bindParam(':in_customer_name', $null);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $null);

            $billinvoice->bindParam(':in_invoice_remarks', $null);
            $billinvoice->bindParam(':in_urgent_fee_total', $zero);
            $billinvoice->bindParam(':in_invoice_type', $null);
            $billinvoice->bindParam(':in_emergency_ind', $null);
            $billinvoice->bindParam(':in_daycare_ind', $null);
            $billinvoice->bindParam(':in_ot_ind', $null);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
            $billinvoice->bindParam(':in_item_count', $total_item);
            $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $package_ind_arr = $item_delivery_status_arr = $item_disc_percent = $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
                0 => 0,
            ];

            $item_level_remarks = $deli_dt_arr = $deli_dt_arr = $provider_no = [
                0 => '',
            ];
            $billinvoice->bindArray(':in_item_name', $item_name_arr, count($item_name_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_qty', $qty_sum, count($qty_sum), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_mu', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

            $billinvoice->bindArray(':in_report_delivery_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_report_delivery_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_delivery_status_lookup_no_fk', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);
            $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            // dd($billinvoice);

            $billinvoice->execute();
        }

        // end create bill

        DB::commit();
        $this->message = [
            'msg' => 'Data Saved Successfully.<br>Indent No = ' . $chalan_no .
                '<br>Medicine = ' . $request->item_name .
                '<br>Issue Quantity = ' . array_sum($request->item_qty),
            'title' => 'Success',
        ];
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     $this->message = ['msg' => 'Some Errors Occured.', 'title' => 'Error'];
        // }
        return response()->json($this->message);
    }
    public function update_item_issue_nurse_station_all(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pk' => 'required',
            'issued_quantity' => 'required',
            'from_store_id' => 'required',
        ]);

        DB::beginTransaction();
        // try {
        $chalan_no = $request->indent;
        $patient_no = $request->patient_no_fk_id;
        $admission_no = $request->admission_no;
        $module_id = 0;
        $issue_ind = 1;
        $rec_by_id = 0;
        $transtype = "ISSUE";
        $nurse = "";
        $save = 0;
        $invoice_id = 0;
        $transitBy = $request->hdn_doctor_id ?? "";
        // dd( $request->hdn_doctor_id);
        $chalan_date = date("Y-m-d");
        $hos_from_store = DB::table('sysc_serviceunit')->where('serviceunit_name', 'PHARMACY')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $from_store_id = $hos_from_store->serviceunit_no_pk;
        $to_store_id = $request->from_store_id;
        if (session('user.ses_hospital_code') == "EWMCH") {
            $to_store_id = 20001;
        }
        // dd( $from_store_id  , $to_store_id);
        $demand_no_fk = 0;
        $in_suplier_no_fk = 0;
        $item_arr = [];

        $batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $item_uoms_arr = [];
        $item_prices_arr = [];
        $item_serial_dtl_arr = [];
        $item_name_arr = [];
        $hdn_item_type = [];

        $package_ind_arr = $item_delivery_status_arr = $item_disc_percent =  $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [];
        $item_level_remarks = $deli_dt_arr = $provider_no = [];

        if (!empty($request->hdn_item_id)) {

            for ($k = 0; $k < count($request->hdn_item_id); $k++) {
                if (!empty($request->input("item_batch_name_" . $request->hdn_item_id[$k]))) {
                    $issue_qty_sum = [];
                    $indent_req = explode('_', $request->hdn_request_id[$k]);
                    for ($i = 0; $i < count($request->input("item_batch_name_" . $request->hdn_item_id[$k])); $i++) {
                        $item_arr[] = $request->input("item_id_" . $request->hdn_item_id[$k]);
                        $item_name_arr[] = $request->input("item_name_" . $request->hdn_item_id[$k]);
                        $hdn_item_type[] = $request->input("in_itemtype_no_fk_" . $request->hdn_item_id[$k]);
                        $checker = "item_batch_name_" . $request->hdn_item_id[$k];
                        $batch_arr[] = $request->$checker[$i]; //item_batch_name[$i];
                        $checker2 = "exp_date_" . $request->hdn_item_id[$k];
                        $expire_arr[] = $request->$checker2[$i] != "" ? date('Y-m-d', strtotime($request->$checker2[$i])) : '';
                        $checker3 = "item_qty_" . $request->hdn_item_id[$k];
                        $quantity_arr[] = $request->$checker3[$i];
                        $item_uoms_arr[] = $request->input("item_uom_" . $request->hdn_item_id[$k]);
                        $item_prices_arr[] = floatval($request->input("item_price_" . $request->hdn_item_id[$k]));
                        $item_serial_dtl_arr[] = "";
                        $package_ind_arr[] = 0;
                        $item_delivery_status_arr[] = 0;
                        $default_dis_percent=DB::table('sysc_serviceitem')->select('default_discount_pct')->where('item_no_pk',$request->hdn_item_id[$k])->first()->default_discount_pct;
                        $item_disc_percent[] = $default_dis_percent;
                        $item_disc_amount[] = 0;
                        $item_vat_prse[] = 0;
                        $hdn_item_urgent_fee_amt[] = 0;
                        $item_level_remarks[] = "";
                        // $provider_no[] = null;
                        $provider_no[] = 0;
                        $deli_dt_arr[] = "";
                        $issue_qty_sum[] = $request->$checker3[$i];
                    }
                    if ($indent_req[0] == $request->hdn_item_id[$k]) {
                        db::table('ipd_patindentdtl')
                            ->where([
                                'patindentmst_no_fk' => $indent_req[1],
                            ])->update([
                                'issue_quantity' =>  array_sum($issue_qty_sum),
                                'issue_at' => date('y-m-d'),
                                'issue_by' => auth::id(),
                                'issue_ind' => $issue_ind,
                                'intransit_by' =>  $transitBy,
                                'intransit_at' => date('y-m-d'),
                                'intransit_ind' => 1,
                                'au_update_hospital_pk_no' => session::get('user.ses_hospital_no_pk'),
                            ]);
                    }
                }              
            }
         
            $numelems = 500;
            $null = '';
            $out_itemreceive_uid = '';
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $pdo = DB::getPdo();

        $receive_items = $pdo->prepare("begin pkg_ipd.prc_ipdindentinout(
                    :in_indentreceive_no_pk,
                    :in_store_su_no_fk,
                    :in_transtype,
                    :in_module_no_fk,
                    :in_patient_no_fk,
                    :in_invoice_no_fk,
                    :in_nursestation_no_fk,
                    :in_received_by_person_no_fk,
                    :in_rcv_save_option,
                    :in_remarks,
                    :in_a_item_no_fk,
                    :in_item_batch_fk,
                    :in_item_expiry_dt,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_item_rate,
                    :in_a_entry_serial_dtl,
                    :in_cost_price,
                    :in_internal_batch_no_uq,
                    :in_internal_expiry_date,
                    :in_purchaseorderdtl_no_pk,
                    :in_inv_requisitiondtl_no_pk,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid
                ); end;");

            $receive_items->bindparam(':in_indentreceive_no_pk', $chalan_no);
            $receive_items->bindparam(':in_store_su_no_fk', $to_store_id);
            $receive_items->bindparam(':in_transtype', $transtype);
            $receive_items->bindparam(':in_module_no_fk', $module_id);
            $receive_items->bindparam(':in_patient_no_fk', $patient_no);
            $receive_items->bindparam(':in_invoice_no_fk', $invoice_id);
            $receive_items->bindparam(':in_nursestation_no_fk', $transitBy);
            $receive_items->bindparam(':in_received_by_person_no_fk', $transitBy);
            $receive_items->bindparam(':in_rcv_save_option', $save);
            $receive_items->bindparam(':in_remarks', $transtype);
            // ------- item details----
            // $receive_items->bindparam('in_transref_date', $chalan_date);
            // $receive_items->bindparam('in_stock_su_no_fk_from', $from_store_id);
            // $receive_items->bindparam('in_stock_su_no_fk_to', $to_store_id);
            $receive_items->bindArray(':in_a_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $receive_items->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray(':in_a_item_pvmsno', $item_arr, count($item_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray(':in_a_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
            $receive_items->bindArray(':in_a_item_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $receive_items->bindArray(':in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $receive_items->bindArray(':in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);
            $receive_items->bindArray(':in_cost_price', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $receive_items->bindArray(':in_internal_batch_no_uq', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray(':in_internal_expiry_date', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray(':in_purchaseorderdtl_no_pk',  $provider_no, count($expire_arr), $numelems, SQLT_INT);
            $receive_items->bindArray(':in_inv_requisitiondtl_no_pk',  $provider_no, count($expire_arr), $numelems, SQLT_INT);
            // -------Generic Values ----
            $receive_items->bindparam(':in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam(':in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam(':in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindParam(':out_ITEMTRANS_UID', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            $receive_items->execute();
        }

        // create bill
        $qty_sum[] = array_sum($quantity_arr);
        $item_ids[] = $request->item_id;
        $chalan_date = ""; //'date("Y-m-d");
        $from_store_id = $request->from_store_id;
        $to_store_id = $request->to_store_id;
        $demand_no_fk = 0;
        $in_suplier_no_fk = 0;
        $item_arr;
        $batch_arr;
        $expire_arr;
        $quantity_arr;
        $item_uoms_arr;
        $item_prices_arr;
        $item_serial_dtl_arr;
        $patient_details = DB::table('ipd_patindentdtl')->select('ipd_admitted_patlist_vw.patient_no_fk', 'ipd_patindentdtl.admission_no_fk')->where('patindentmst_no_fk', $request->indent)->leftjoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'ipd_patindentdtl.admission_no_fk')->first();

        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $numelems = 500;
        $null = '';
        // $out_itemreceive_uid = '';
        $service_unit = $request->serviceunit_no_fk;
        $demand_no = $request->demand_no;

        $store_su_no_fk = isset($request->store_name) ? $request->store_name : 0;
        $out_invoice_no = $out_invoice_id = $out_error = $out_ledgertrn_no = "";
        $in_ledgertrn_no = 0;
        $numelems = 5000;
        $total_item = count($item_arr);
        $ind_one=1;

        $out_patient_no_pk = $patient_details->patient_no_fk;
        $admission_no = $patient_details->admission_no_fk;
        $payment_type = DB::table('ipd_medicine_inv_set')->first();

        $pdo = DB::getPdo();
        if ($payment_type->ipd_setting_type == 1) {
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_phr_wp(
                                    :in_invoice_date,
                                    :in_invoice_datetime,
                                    :in_module_no_fk,
                                    :in_patient_no_fk,
                                    :in_patient_code,
                                    :in_admission_no_pk,
                                    :in_admission_code,
                                    :in_appointment_no_fk,
                                    :in_prescription_no_fk,
                                    :in_doc_person_no_fk,
                                    :in_first_ref_doc,
                                    :in_second_ref_doc,
                                    :in_report_delivary_date,
                                    :in_report_deli_datetime,
                                    :in_counter_su_no_fk,
                                    :in_cor_client_no_fk,
                                    :in_cor_client_card_no_fk,
                                    :in_relation_lookup_no_fk,
                                    :in_ref_invoice_no_fk,
                                    :in_pat_type_lookup_no_fk,
                                    :in_dob,
                                    :in_age,
                                    :in_age_dd,
                                    :in_age_mm,
                                    :in_age_yy,
                                    :in_customer_addr,
                                    :in_customer_name,
                                    :in_gender_txt,
                                    :in_marital_status_txt,
                                    :in_blood_group,
                                    :in_phone_mobile,
                                    :in_invoice_remarks,
                                    :in_urgent_fee_total,
                                    :in_invoice_type,
                                    :in_emergency_ind,
                                    :in_daycare_ind,
                                    :in_ot_ind,
                                    :in_au_entry_by,
                                    :in_au_entry_session,
                                    :in_au_entry_hospital_pk_no,
                                    :in_item_level_disc_ind,
                                    :in_item_count,
                                    :in_item_no_fk,
                                    :in_item_batch_fk,
                                    :in_item_expiry_dt,
                                    :in_item_name,
                                    :in_itemtype_no_fk,
                                    :in_item_qty,
                                    :in_item_mu,
                                    :in_item_rate,
                                    :in_item_disc_percent,
                                    :in_item_disc_amount,
                                    :in_item_vat,
                                    :in_urgent_fee,
                                    :in_service_charge,
                                    :in_report_deli_date,
                                    :in_report_deli_time,
                                    :in_deli_status_lookup,
                                    :in_package_item_ind,
                                    :in_item_level_remarks,
                                    :in_ledgertrn_no,
                                    :out_invoice_no,
                                    :out_invoice_id,
                                    :out_ledgertrn_no,
                                    :out_error); end;");


            date_default_timezone_set('Asia/Dhaka');
            // $date = date('d/m/Y h:i a');
            $cur_date = date("Y-m-d h:i:s");
            $cur_datetime = date("Y-m-d h:i:s");
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $null = '';
            $zero = 0;
            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            $auth_id = Auth::id();
            $entry_session = "Session";
            $hdn_doctor_id = $request->doctor_id;
            $billinvoice->bindParam(':in_invoice_date', $cur_date);
            $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
            $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
            $billinvoice->bindParam(':in_admission_no_pk', $admission_no);
            $billinvoice->bindParam(':in_admission_code', $null);
            $billinvoice->bindParam(':in_appointment_no_fk', $zero);
            $billinvoice->bindParam(':in_prescription_no_fk', $zero);
            $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
            $billinvoice->bindParam(':in_first_ref_doc', $zero);
            $billinvoice->bindParam(':in_second_ref_doc', $zero);
            $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
            $billinvoice->bindParam(':in_report_deli_datetime', $cur_date);
            $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_card_no_fk', $zero);
            $billinvoice->bindParam(':in_relation_lookup_no_fk', $zero);
            $billinvoice->bindParam(':in_ref_invoice_no_fk', $zero);
            $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $zero);
            $billinvoice->bindParam(':in_dob', $null);
            $billinvoice->bindParam(':in_age', $zero);
            $billinvoice->bindParam(':in_age_dd', $zero);
            $billinvoice->bindParam(':in_age_mm', $zero);
            $billinvoice->bindParam(':in_age_yy', $zero);
            $billinvoice->bindParam(':in_customer_addr', $null);
            $billinvoice->bindParam(':in_customer_name', $null);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $null);

            $billinvoice->bindParam(':in_invoice_remarks', $null);
            $billinvoice->bindParam(':in_urgent_fee_total', $zero);
            $billinvoice->bindParam(':in_invoice_type', $null);
            $billinvoice->bindParam(':in_emergency_ind', $null);
            $billinvoice->bindParam(':in_daycare_ind', $null);
            $billinvoice->bindParam(':in_ot_ind', $null);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billinvoice->bindParam(':in_item_level_disc_ind', $ind_one);
            $billinvoice->bindParam(':in_item_count', $total_item);
            $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_name', $item_name_arr, count($item_name_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_mu', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

            $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
            // $billinvoice->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);
            $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            // dd($billinvoice);

            $billinvoice->execute();


            // update Invoice ID start
            for ($k = 0; $k < count($request->hdn_item_id); $k++) {
                if (!empty($request->input("item_batch_name_" . $request->hdn_item_id[$k]))) {
                    $indent_req = explode('_', $request->hdn_request_id[$k]);
                    if ($indent_req[0] == $request->hdn_item_id[$k]) {
                        db::table('ipd_patindentdtl')
                            ->where([
                                'patindentmst_no_fk' => $indent_req[1],
                            ])->update(['invoice_no_fk' => $out_invoice_no]);
                    }
                }
            }

        }
        // end create bill

        DB::commit();
        $this->message = [
            'msg' => 'Data Saved Successfully.<br>Indent No = ' . $chalan_no, 'receive_uid' => $out_itemreceive_uid,
            'title' => 'Success',
        ];
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     $this->message = ['msg' => 'Some Errors Occured.', 'title' => 'Error'];
        // }
        return response()->json($this->message);
    }

    public function showIndentItemReceivePopup($item_details, $type = '')
    {
        $pId_qty = explode('_', $item_details);
        $item_id = $pId_qty[0];
        $qty = $pId_qty[1];
        $to_store_id = $pId_qty[2];
        $indent = $pId_qty[3];
        $from_store_id = $pId_qty[4];
        $patient_no_fk = isset($pId_qty[5]) ? $pId_qty[5] : '';

        /*
        Note
        1 = Patient
        2 = Employee or Adminstration

         */

        $type_of_consum = isset($pId_qty[6]) ? $pId_qty[6] : '';
        //$item_name = isset($pId_qty[6]) ? $pId_qty[6] : '';
        // dd($id);
        $item_name = Item::select("ITEM_NAME", "PURCHASE_PRICE", "UOM_NO_FK", 'ITEMTYPE_NO_FK')->where("ITEM_NO_PK", $item_id)->first();
        return Template::loadview("admin.pharmacy.show_indent_item_receive_popup", ['type_of_consum' => $type_of_consum, 'type' => $type, 'indent' => $indent, 'from_store_id' => $from_store_id, 'to_store_id' => $to_store_id, 'item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'patient_no_fk' => $patient_no_fk]);
    }
    public function showIndentItemReceivePopupNurseStation($item_details, $type = '')
    {
        $pId_qty = explode('_', $item_details);
        $item_id = $pId_qty[0];
        $qty = $pId_qty[1];
        $to_store_id = $pId_qty[2];
        $indent = $pId_qty[3];
        $from_store_id = $pId_qty[4];
        $patient_no_fk = isset($pId_qty[5]) ? $pId_qty[5] : '';
        /*
        Note
        1 = Patient
        2 = Employee or Adminstration

         */

        $type_of_consum = isset($pId_qty[6]) ? $pId_qty[6] : '';
        //$item_name = isset($pId_qty[6]) ? $pId_qty[6] : '';

        $recive_qty = DB::table('inv_trn_chd_vw')->where('item_no_fk', $item_id)->where('stock_su_no_fk', $from_store_id)->where('stock_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->whereNotNull('expiry_date')->orderBy('expiry_date', 'asc')->get();

        // dd($recive_qty);
        $item_name = Item::select("ITEM_NAME", "PURCHASE_PRICE", "UOM_NO_FK", 'ITEMTYPE_NO_FK')->where("ITEM_NO_PK", $item_id)->first();
        return Template::loadview("admin.pharmacy.show_indent_item_receive_popup_nurse_station", ['type_of_consum' => $type_of_consum, 'type' => $type, 'indent' => $indent, 'from_store_id' => $from_store_id, 'to_store_id' => $to_store_id, 'item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'patient_no_fk' => $patient_no_fk, 'recive_qty' => $recive_qty]);
    }

    public function showConsumItemReceivePopup($item_details, $type = '')
    {
        $pId_qty = explode('_', $item_details);
        $item_id = $pId_qty[0];
        $qty = $pId_qty[1];
        $pat_consumtion = DB::table('sysc_serviceunit')->where('serviceunit_code', 'PATCONSUMINV')->first();
        if (isset($pat_consumtion)) {
            $to_store_id = $pat_consumtion->serviceunit_no_pk;
        } else {
            $to_store_id = 0;
        }

        $indent = $pId_qty[3];
        $from_store_id = $pId_qty[2];
        $patient_no_fk = isset($pId_qty[5]) ? $pId_qty[5] : '';
        /*
        Note
        1 = Patient
        2 = Employee or Adminstration

         */

        $type_of_consum = isset($pId_qty[6]) ? $pId_qty[6] : '';
        //$item_name = isset($pId_qty[6]) ? $pId_qty[6] : '';
        // dd($id);
        $item_name = Item::select("ITEM_NAME", "PURCHASE_PRICE", "UOM_NO_FK", 'ITEMTYPE_NO_FK')->where("ITEM_NO_PK", $item_id)->first();
        return Template::loadview("admin.pharmacy.show_consum_item_receive_popup", ['type_of_consum' => $type_of_consum, 'type' => $type, 'indent' => $indent, 'from_store_id' => $from_store_id, 'to_store_id' => $to_store_id, 'item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'patient_no_fk' => $patient_no_fk]);
    }

    public function update_indent(Request $request)
    {
        // dd($request->all());

        $chalan_no = $request->indent;
        $chalan_date = date("Y-m-d");
        $from_store_id = $request->from_store_id;
        $to_store_id = $request->to_store_id;
        $demand_no_fk = 0;
        $in_suplier_no_fk = 0;
        $item_arr = [];
        $batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $item_uoms_arr = [];
        $item_prices_arr = [];
        $item_serial_dtl_arr = [];
        $item_name_arr = [];
        $hdn_item_type = [];
        for ($i = 0; $i < count($request->item_batch_name); $i++) {
            $item_arr[$i] = $request->item_id;
            $item_name_arr[$i] = $request->item_name;
            $hdn_item_type[$i] = $request->in_itemtype_no_fk; //39==10000 (95==20000)
            $batch_arr[$i] = $request->item_batch_name[$i];
            $expire_arr[$i] = $request->exp_date[$i];
            $quantity_arr[$i] = $request->item_qty[$i];
            $item_uoms_arr[$i] = $request->item_uom;
            $item_prices_arr[$i] = $request->item_price;
            $item_serial_dtl_arr[$i] = "";
        }

        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $numelems = 500;
        $null = '';
        $out_itemreceive_uid = '';

        $pdo = DB::getPdo();
        $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemreceive_store2store(
            :in_transref_no,
            :in_transref_date,
            :in_stock_su_no_fk_from,
            :in_stock_su_no_fk_to,
            :in_a_item_no_fk,
            :in_item_batch_fk,
            :in_item_expiry_dt,
            :in_a_item_pvmsno,
            :in_a_item_qty,
            :in_a_item_uom,
            :in_a_item_price,
            :in_a_entry_serial_dtl,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_itemreceive_uid
        ); end;");

        $receive_items->bindparam('in_transref_no', $chalan_no);
        $receive_items->bindparam('in_transref_date', $chalan_date);
        $receive_items->bindparam('in_stock_su_no_fk_from', $from_store_id);
        $receive_items->bindparam('in_stock_su_no_fk_to', $to_store_id);
        //$receive_items->bindparam('in_demand_no_fk', $null);

        $receive_items->bindArray('in_a_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_a_item_pvmsno', $item_arr, count($item_arr), $numelems, SQLT_CHR);
        $receive_items->bindArray('in_a_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_item_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_item_price', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_INT);
        $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);

        $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
        $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
        $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

        $receive_items->bindParam(':out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);

        $receive_items->execute();

        DB::commit();

        $out_invoice_no = $out_invoice_id = $out_error = "";
        $numelems = 5000;
        $total_item = count($item_arr);
        if ($request->type_of_consum == 1) {

            $sum_qty = array_sum($quantity_arr);
            DB::table('inv_requisitiondtl')->where('item_no_fk', $request->item_id)->where('inv_requisition_no_fk', $request->indent)->update([
                "item_consumption_qty" => $sum_qty,
                "recv_quantity" => $sum_qty,
                "recv_ind" => '1',
                "recv_at" => date('Y-m-d h:i:s'),
                "recv_by" => Auth::user()->user_no_pk,
                "item_consumption_at" => date('Y-m-d h:i:s'),
                "item_consumption_by" => Auth::user()->user_no_pk,
            ]);
        } else {

            if (isset($request->patient_no_fk) && $request->patient_no_fk != 0) {

                $out_patient_no_pk = $request->patient_no_fk;

                $pdo = DB::getPdo();
                $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");
                //Preparating Data
                $cur_date = date("Y-M-d H:i:s");
                $cur_datetime = date("Y-M-d h:i:s");
                $hospital_id = Session::get('user.ses_hospital_no_pk');
                $null = '';
                $zero = 0;
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                $auth_id = Auth::id();
                $entry_session = "Session";
                $hdn_doctor_id = $request->doctor_id;
                $billinvoice->bindParam(':in_invoice_date', $cur_date);
                $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
                $billinvoice->bindParam(':in_module_no_fk', $module_id);
                $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
                $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
                $billinvoice->bindParam(':in_admission_no_pk', $zero);
                $billinvoice->bindParam(':in_admission_code', $null);
                $billinvoice->bindParam(':in_appointment_no_fk', $zero);
                $billinvoice->bindParam(':in_prescription_no_fk', $zero);
                $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
                $billinvoice->bindParam(':in_first_ref_doc', $zero);
                $billinvoice->bindParam(':in_second_ref_doc', $zero);
                $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
                $billinvoice->bindParam(':in_report_deli_datetime', $cur_date);
                $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
                $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
                $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
                $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $zero);
                $billinvoice->bindParam(':in_dob', $cur_date);
                $billinvoice->bindParam(':in_age', $null);
                $billinvoice->bindParam(':in_age_dd', $null);
                $billinvoice->bindParam(':in_age_mm', $null);
                $billinvoice->bindParam(':in_age_yy', $null);
                $billinvoice->bindParam(':in_customer_addr', $null);
                $billinvoice->bindParam(':in_customer_name', $null);

                $billinvoice->bindParam(':in_gender_txt', $null);
                $billinvoice->bindParam(':in_marital_status_txt', $null);
                $billinvoice->bindParam(':in_blood_group', $null);
                $billinvoice->bindParam(':in_phone_mobile', $null);

                $billinvoice->bindParam(':in_invoice_remarks', $null);
                $billinvoice->bindParam(':in_urgent_fee_total', $null);
                $billinvoice->bindParam(':in_invoice_type', $null);
                $billinvoice->bindParam(':in_au_entry_by', $auth_id);
                $billinvoice->bindParam(':in_au_entry_session', $entry_session);
                $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

                $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
                $billinvoice->bindParam(':in_item_count', $total_item);
                $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
                $package_ind_arr = $item_delivery_status_arr = $item_disc_percent = $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
                    0 => 0,
                ];

                $item_level_remarks = $deli_dt_arr = $deli_dt_arr = [
                    0 => '',
                ];
                $billinvoice->bindArray(':in_item_name', $item_name_arr, count($item_name_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_mu', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

                $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);

                $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                $billinvoice->execute();
            } else {
                $sum_qty = array_sum($quantity_arr);

                DB::table('inv_requisitiondtl')->where('item_no_fk', $request->item_id)->where('inv_requisition_no_fk', $request->indent)->update([
                    "item_consumption_qty" => $sum_qty,
                    "recv_quantity" => $sum_qty,
                    "recv_ind" => '1',
                    "recv_at" => date('Y-m-d h:i:s'),
                    "recv_by" => Auth::user()->user_no_pk,
                    "item_consumption_at" => date('Y-m-d h:i:s'),
                    "item_consumption_by" => Auth::user()->user_no_pk,
                ]);
            }
        }

        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {
        }

        $this->message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($this->message);
    }

    public function update_indent_nurse_station(Request $request)
    {

        if ($request->transit_type == 1) {
            if ($request->item_quantities[0] <= 0) {
                $this->message = ['msg' => 'Qty. less then 1', 'title' => 'Error'];
                return response()->json($this->message);
            }
        } else {
            if ($request->current_qty < $request->item_quantities[0]) {
                $this->message = ['msg' => 'Qty. less then ' . $request->current_qty . ' or equal', 'title' => 'Error'];
                return response()->json($this->message);
            }
        }

        try {




            $chalan_no = 0; //$request->indent;
            $chalan_date = date("d-m-Y"); //'date("Y-m-d");
            $from_store_id = $request->from_store_id;
            $to_store_id = $request->to_store_id;
            $demand_no_fk = 0;
            $in_suplier_no_fk = 0;
            $module_no_fk = 0;
            $item_arr = [];
            $batch_arr = [];
            $expire_arr = [];
            $quantity_arr = [];
            $item_uoms_arr = [];
            $item_prices_arr = [];
            $item_serial_dtl_arr = [];
            $item_name_arr = [];
            $hdn_item_type = [];







            for ($i = 0; $i < count($request->item_ids); $i++) {
                $item_arr[$i] = $request->item_ids[$i];
                $item_que[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_arr[$i])->first();
                $item_name_arr[$i] = $item_que[$i]->item_name;
                $hdn_item_type[$i] = $item_que[$i]->itemtype_no_fk; //39==10000 (95==20000)
                $batch_arr[$i] = "";
                $expire_arr[$i] = "";
                $quantity_arr[$i] = $request->item_quantities[$i];
                $item_uoms_arr[$i] = $item_que[$i]->uom_no_fk;
                $item_prices_arr[$i] = $item_que[$i]->sales_price;
                $item_serial_dtl_arr[$i] = "";
            }
            $patient_details = DB::table('ipd_patindentdtl')->select('patient_no_fk', 'admission_no_fk')->where('patindentdtl_no_pk', $request->demand_no)->leftjoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'ipd_patindentdtl.admission_no_fk')->first();

            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $numelems = 500;
            $null = '';
            $out_itemreceive_uid = '';
            $service_unit = $request->serviceunit_no_fk;
            $demand_no = $request->demand_no;

            $store_su_no_fk = isset($request->store_name) ? $request->store_name : 0;
            $from_store_su_no_fk = isset($request->store_from) ? $request->store_from : 0;
            $po_no = 0;
            $supplier_no_fk = isset($request->supplier_id) ? $request->supplier_id : 0;
            $stock_type = $request->stock_type;
            $item_pk_no = [];
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $hdn_single_quantity = [];
            $item_uom_phur = [];
            $phur_qty = [];
            $demand_no_fk = 1;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';

            if (!empty($request->item_ids)) {
                for ($i = 0; $i < count($request->item_ids); $i++) {
                    $item_pk_no[$i] = isset($request->item_ids[$i]) ? $request->item_ids[$i] : 0;
                    $item_pvms[$i] = $null;
                    $item_query[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_pk_no[$i])->first();
                    $supplier_name = $item_query[$i]->supplier_pk_no;
                    $item_uom[$i] = $item_query[$i]->uom_no_fk;
                    $item_qty[$i] = isset($request->item_quantities[$i]) ? $request->item_quantities[$i] : 0;
                    $item_price[$i] = $item_query[$i]->sales_price ?? 0;
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                }
            }

            $pdo = DB::getPdo();

            if ($request->transit_type == 2) {
                $transferIn = 'ISSUE';
            } else {
                $transferIn = 'RECEIVE';
            }

            $stock_adjustment = $pdo->prepare("begin

            pkg_pharmacy.prc_transactioninout(
            :in_challan_no,
            :in_challan_date,
            :in_store_su_no_fk,
            :in_demand_no_fk,
            :in_po_no,
            :in_supplier_no_fk,
            :in_transtype,
            :in_module_no_fk,
            :in_a_item_no_fk,
            :in_a_item_pvmsno,
            :in_a_item_qty,
            :in_a_item_uom,
            :in_a_freeitem_qty,
            :in_a_freeitem_uom,
            :in_a_item_price,
            :in_a_entry_serial_dtl,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_itemtrans_uid);
            end;
            ");
            $stock_adjustment->bindparam('in_challan_no', $chalan_no);
            $stock_adjustment->bindparam('in_challan_date', $chalan_date);
            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no);
            $stock_adjustment->bindparam('in_po_no', $po_no);
            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_name);

            $stock_adjustment->bindparam('in_transtype', $transferIn);
            $stock_adjustment->bindparam('in_module_no_fk', $module_no_fk);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

            $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            // dd( $stock_adjustment);

            $stock_adjustment->execute();

            // transection in out end

            $out_invoice_no = $out_invoice_id = $out_error = $out_ledgertrn_no = "";
            $in_ledgertrn_no = 0;
            $numelems = 5000;
            $total_item = count($item_arr);
            // if ($request->type_of_consum == 1) {
            //     $sum_qty =  array_sum($quantity_arr);
            //     DB::table('inv_requisitiondtl')->where('item_no_fk', $request->item_id)->where('inv_requisition_no_fk', $request->indent)->update([
            //         "item_consumption_qty" => $sum_qty,
            //         "item_consumption_at" => date('Y-m-d h:i:s'),
            //         "item_consumption_by" => Auth::user()->user_no_pk,
            //     ]);
            // } else {
            // if (isset($patient_details->patient_no_fk)) {

            $out_patient_no_pk = $patient_details->patient_no_fk;
            $admission_no = $patient_details->admission_no_fk;
            // dd( $out_patient_no_pk,$admission_no);
            $payment_type = DB::table('ipd_medicine_inv_set')->first();
            $pdo = DB::getPdo();
            if ($transferIn == 'RECEIVE' && $payment_type->ipd_setting_type == 2) {
                $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(
                        :in_invoice_date,
                        :in_invoice_datetime,
                        :in_module_no_fk,
                        :in_patient_no_fk,
                        :in_patient_code,
                        :in_admission_no_pk,
                        :in_admission_code,
                        :in_appointment_no_fk,
                        :in_prescription_no_fk,
                        :in_doc_person_no_fk,
                        :in_first_ref_doc_person_no_fk,
                        :in_second_ref_doc_person_no_fk,
                        :in_report_delivary_date,
                        :in_report_delivary_datetime,
                        :in_counter_su_no_fk,
                        :in_cor_client_no_fk,
                        :in_cor_client_card_no_fk,
                        :in_relation_lookup_no_fk,
                        :in_ref_invoice_no_fk,
                        :in_pat_type,
                        :in_dob,
                        :in_age,
                        :in_age_dd,
                        :in_age_mm,
                        :in_age_yy,
                        :in_customer_addr,
                        :in_customer_name,
                        :in_gender_txt,
                        :in_marital_status_txt,
                        :in_blood_group,
                        :in_phone_mobile,
                        :in_invoice_remarks,
                        :in_urgent_fee_total,
                        :in_invoice_type,
                        :in_emergency_ind,
                        :in_daycare_ind,
                        :in_ot_ind,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :in_item_level_disc_ind,
                        :in_item_count,
                        :in_item_no_fk,
                        :in_item_batch_fk,
                        :in_item_expiry_dt,
                        :in_item_name,
                        :in_itemtype_no_fk,
                        :in_item_qty,
                        :in_item_mu,
                        :in_item_rate,
                        :in_item_disc_percent,
                        :in_item_disc_amount,
                        :in_item_vat,
                        :in_urgent_fee,
                        :in_service_charge,
                        :in_report_delivery_date,
                        :in_report_delivery_time,
                        :in_delivery_status_lookup_no_fk,
                        :in_package_item_ind,
                        :in_item_level_remarks,
                        :in_provider_no_fk,
                        :in_ledgertrn_no,
                        :out_invoice_no,
                        :out_invoice_id,
                        :out_ledgertrn_no,
                        :out_error); end;");
                //Preparating Data

                date_default_timezone_set('Asia/Dhaka');
                // $date = date('d/m/Y h:i a');
                $cur_date = date("Y-m-d h:i:s");
                $cur_datetime = date("Y-m-d h:i:s");
                $hospital_id = Session::get('user.ses_hospital_no_pk');
                $null = '';
                $zero = 0;
                $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                $auth_id = Auth::id();
                $entry_session = "Session";
                $hdn_doctor_id = $request->doctor_id;
                $billinvoice->bindParam(':in_invoice_date', $cur_date);
                $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
                $billinvoice->bindParam(':in_module_no_fk', $module_id);
                $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
                $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
                $billinvoice->bindParam(':in_admission_no_pk', $admission_no);
                $billinvoice->bindParam(':in_admission_code', $null);
                $billinvoice->bindParam(':in_appointment_no_fk', $zero);
                $billinvoice->bindParam(':in_prescription_no_fk', $zero);
                $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
                $billinvoice->bindParam(':in_first_ref_doc_person_no_fk', $zero);
                $billinvoice->bindParam(':in_second_ref_doc_person_no_fk', $zero);
                $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
                $billinvoice->bindParam(':in_report_delivary_datetime', $cur_date);
                $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_card_no_fk', $zero);
                $billinvoice->bindParam(':in_relation_lookup_no_fk', $zero);
                $billinvoice->bindParam(':in_ref_invoice_no_fk', $zero);
                $billinvoice->bindParam(':in_pat_type', $zero);
                $billinvoice->bindParam(':in_dob', $null);
                $billinvoice->bindParam(':in_age', $zero);
                $billinvoice->bindParam(':in_age_dd', $zero);
                $billinvoice->bindParam(':in_age_mm', $zero);
                $billinvoice->bindParam(':in_age_yy', $zero);
                $billinvoice->bindParam(':in_customer_addr', $null);
                $billinvoice->bindParam(':in_customer_name', $null);

                $billinvoice->bindParam(':in_gender_txt', $null);
                $billinvoice->bindParam(':in_marital_status_txt', $null);
                $billinvoice->bindParam(':in_blood_group', $null);
                $billinvoice->bindParam(':in_phone_mobile', $null);

                $billinvoice->bindParam(':in_invoice_remarks', $null);
                $billinvoice->bindParam(':in_urgent_fee_total', $zero);
                $billinvoice->bindParam(':in_invoice_type', $null);
                $billinvoice->bindParam(':in_emergency_ind', $null);
                $billinvoice->bindParam(':in_daycare_ind', $null);
                $billinvoice->bindParam(':in_ot_ind', $null);
                $billinvoice->bindParam(':in_au_entry_by', $auth_id);
                $billinvoice->bindParam(':in_au_entry_session', $entry_session);
                $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

                $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
                $billinvoice->bindParam(':in_item_count', $total_item);
                $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
                $package_ind_arr = $item_delivery_status_arr = $item_disc_percent = $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
                    0 => 0,
                ];

                $item_level_remarks = $deli_dt_arr = $deli_dt_arr = $provider_no = [
                    0 => '',
                ];
                $billinvoice->bindArray(':in_item_name', $item_name_arr, count($item_name_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_mu', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

                $billinvoice->bindArray(':in_report_delivery_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_report_delivery_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_delivery_status_lookup_no_fk', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);
                $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
                $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                // dd($billinvoice);

                $billinvoice->execute();
            }

            // }
            // }
            if ($out_error == 999) {
                // dd($out_error);
                DB::rollback();
                $this->message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
            } else {
                if ($transferIn == 'RECEIVE' && $payment_type->ipd_setting_type == 2) {
                    $return_qty = $request->issue_quantity - array_sum($item_qty);
                    $data = [
                        'recv_quantity' => array_sum($item_qty),
                        // (int) $request->issued_quantity + (int) $row_to_update->issue_quantity,
                        'recv_at' => date('Y-m-d'),
                        'recv_by' => Auth::id(),
                        'recv_ind' => 1,
                        'return_quantity' => $return_qty > 0 ? $request->issue_quantity - array_sum($item_qty) : 0,
                        'return_at' => $return_qty > 0 ? date('Y-m-d') : "",
                        'return_by' => $return_qty > 0 ? Auth::id() : "",
                        'return_ind' => $return_qty > 0 ? 1 : "",

                        'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                    ];
                } else {

                    if ($transferIn == 'RECEIVE') {
                        $return_qty = $request->issue_quantity - array_sum($item_qty);
                        $data = [
                            'recv_quantity' => array_sum($item_qty),
                            // (int) $request->issued_quantity + (int) $row_to_update->issue_quantity,
                            'recv_at' => date('Y-m-d'),
                            'recv_by' => Auth::id(),
                            'recv_ind' => 1,
                            'return_after_receive_qty' => $return_qty > 0 ? $request->issue_quantity - array_sum($item_qty) : 0,
                            'return_after_receive_at' => $return_qty > 0 ? date('Y-m-d') : '',
                            'return_after_receive_by' => $return_qty > 0 ? Auth::id() : '',
                            'return_after_receive_ind' => $return_qty > 0 ? 1 : '',
                            'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        ];



                        // db::table('ipd_patindentdtl')
                        // ->where([
                        //     'patindentmst_no_fk' => $request->rec_no,
                        // ])->update([
                        //     'recv_quantity' => $return_qty > 0 ? $request->issue_quantity - array_sum($item_qty) : 0,
                        //     'recv_by' => auth::id(),
                        //     'recv_at' => $return_qty > 0 ? date('Y-m-d') : '',
                        //     'recv_ind' => 1,
                        //     'au_update_hospital_pk_no' => session::get('user.ses_hospital_no_pk'),
                        // ]);

                    } else {
                        $data = [
                            'return_after_receive_qty' => array_sum($item_qty),
                            'return_after_receive_at' => date('Y-m-d'),
                            'return_after_receive_by' => Auth::id(),
                            'return_after_receive_ind' => 1,
                            'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        ];



                        // db::table('ipd_patindentdtl')
                        // ->where([
                        //     'patindentmst_no_fk' => $request->rec_no,
                        // ])->update([
                        //     'return_quantity' =>  array_sum($item_qty),
                        //     'return_by' => auth::id(),
                        //     'return_at' => date('y-m-d'),
                        //     'return_ind' => 1,
                        //     'au_update_hospital_pk_no' => session::get('user.ses_hospital_no_pk')
                        // ]);

                    }
                }
                // dd($data);

                DB::table('ipd_patindentdtl')
                    ->where([
                        'patindentdtl_no_pk' => $demand_no,
                    ])->update($data);
                DB::commit();
                $this->message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
            }
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    // Added By Nazmul Pharmacy Dashboard
    public function pharmacyDashboard()
    {
        $management_ind = 0;
        if (Session::get('user.inv_auth_chairman_ind') == "1") {
            $management_ind = 1;
        } elseif (Session::get('user.inv_director_acc_ind') == "1") {
            $management_ind = 1;
        } elseif (Session::get('user.inv_director_admin_ind') == "1") {
            $management_ind = 1;
        }

        // $dashboard = DB::select(DB::raw("select dash_key,dash_value, heading_name from SYSC_DASHBOARDMST where TO_CHAR(dash_date,'MM')=TO_CHAR(sysdate,'MM')"));

        $dashboard_data = [];
        // if (!empty($dashboard)) {
        //     foreach ($dashboard as  $value) {
        //         $dashboard_data[$value->dash_key] = $value->dash_value . "_" . $value->heading_name;
        //     }
        // }
        // dd($dashboard_data);
        $to_day_sales = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('round(sum(sales)) sales'), DB::raw('round(sum(NET_COLLECTION) - round(sum(REFUND))) net_collection'), DB::raw('round(sum(REFUND)) refund'))->whereIn('MODULE_CODE', ["PHR", "PHR-I"])->whereDate('LEDGERTRN_DATE', date('Y-m-d'))->first();

        $monthly_sales = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('round(sum(sales)) sales'), DB::raw('round(sum(NET_COLLECTION) - round(sum(REFUND))) net_collection'), DB::raw('round(sum(REFUND)) refund'))->whereIn('MODULE_CODE', ["PHR", "PHR-I"])->whereMonth('LEDGERTRN_DATE', date('m'))->first();
        // dd( $monthly_sales);

        // Worklist Query
        $month_top_medicine = DB::select(DB::raw("SELECT  finc_invoicedtl_vw.item_no_fk,finc_invoicedtl_vw.ITEM_NAME,
                                                finc_invoicedtl_vw.ITEM_RATE,
                                                lastInv.last_INVOICE_DATE,
                                                sum(finc_invoicedtl_vw.ITEM_QTY) item_qty
                                                FROM finc_invoicedtl_vw
                                                    left join
                                                    (select  ITEM_NO_FK ,  max(INVOICE_DATE) as last_INVOICE_DATE  from finc_invoicedtl_vw group by  ITEM_NO_FK  ) lastInv on lastInv.ITEM_NO_FK = finc_invoicedtl_vw.ITEM_NO_FK
                                                WHERE TO_CHAR (finc_invoicedtl_vw.invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND finc_invoicedtl_vw.ITEM_TYPE='MED'
                                                GROUP BY finc_invoicedtl_vw.ITEM_NO_FK,
                                                finc_invoicedtl_vw.ITEM_NAME,
                                                finc_invoicedtl_vw.ITEM_RATE,
                                                lastInv.last_INVOICE_DATE
                                                ORDER BY item_qty ASC"));

        // dd($month_top_medicine);

        $ltmls = DB::select(DB::raw("SELECT item_no_fk,ITEM_NAME,  sum(current_item_qty) item_qty  FROM finc_invoicedtl_vw WHERE TO_CHAR (invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND ITEM_TYPE='MED' group by item_no_fk,ITEM_NAME   ORDER BY item_qty DESC"));
        // $ltmls = DB::select(DB::raw("SELECT item_no_fk,ITEM_NAME
        //                             -- ITEM_RATE,
        //                             -- TO_CHAR (invoice_date, 'mm') MONTH_NUMBER,
        //                             sum(ITEM_QTY) item_qty
        //                             --COUNT (ITEM_NO_FK)
        //                             FROM finc_invoicedtl_vw
        //                             WHERE TO_CHAR (invoice_date, 'mm') = TO_CHAR (SYSDATE-3, 'mm') AND ITEM_TYPE='MED'
        //                             -- WHERE TRUNC(invoice_date) > TRUNC (ADD_MONTHS (SYSDATE, -3)) AND ITEM_TYPE='MED'
        //                             GROUP BY ITEM_NO_FK,
        //                             ITEM_NAME
        //                             -- TO_CHAR (invoice_date, 'mm'),
        //                             --ITEM_QTY,
        //                             -- ITEM_RATE
        //                             ORDER BY item_qty DESC"));

        // ----
        // dd($ltmls);
        $expire_this_month = DB::select(DB::raw("SELECT mst.*, to_char(child.EXPIRY_DATE, 'dd/mm/YYYY') phrexpiry_date,child.STOCKTRANS_NO_FK,child.ITEM_NO_FK,child.ITEM_NAME,child.ITEM_RATE,child.ITEM_QTY,currentQty.CURRENT_STOCK
                                        FROM    INV_ITEMSTOCKTRANSMST mst
                                        left join INV_ITEMSTOCKTRANSCHD child on child.STOCKTRANS_NO_FK = mst.STOCKTRANS_NO_PK
                                        left join STOCK_LEDGER_VW currentQty on currentQty.ITEM_NO_FK = child.ITEM_NO_FK

                                        where mst.TRANS_TYPE_ISS_RCV = 'RECEIVE' and child.EXPIRY_DATE between  to_char(SYSDATE, 'dd/mm/YYYY') and to_char(SYSDATE+90, 'dd/mm/YYYY')  order by child.EXPIRY_DATE ASC"));

        // --         JOIN
        // --         finc_invoicedtl_vw finc
        // --         ON inv.ITEM_NO_FK = finc.ITEM_NO_FK
        // -- WHERE EXPIRY_DATE < TRUNC (SYSDATE) + INTERVAL '60' DAY
        // --         AND EXPIRY_DATE >= SYSDATE
        // -- GROUP BY inv.ITEM_NAME, inv.EXPIRY_DATE,inv.item_no_fk"));

        // dd($expire_this_month);

        $expire_next_month = DB::select(DB::raw("SELECT mst.*, to_char(child.EXPIRY_DATE, 'dd/mm/YYYY') phrexpiry_date,child.STOCKTRANS_NO_FK,child.ITEM_NO_FK,child.ITEM_NAME,child.ITEM_RATE,child.ITEM_QTY,currentQty.CURRENT_STOCK, to_char(SYSDATE-200, 'dd/mm/YYYY') test_date
        FROM    INV_ITEMSTOCKTRANSMST mst
        left join INV_ITEMSTOCKTRANSCHD child on child.STOCKTRANS_NO_FK = mst.STOCKTRANS_NO_PK
        left join STOCK_LEDGER_VW currentQty on currentQty.ITEM_NO_FK = child.ITEM_NO_FK

        where mst.TRANS_TYPE_ISS_RCV = 'RECEIVE' and child.EXPIRY_DATE between to_char(SYSDATE-90, 'dd/mm/YYYY')   and to_char(SYSDATE, 'dd/mm/YYYY')  order by child.EXPIRY_DATE ASC"));

        // DB::select(DB::raw("SELECT INV.item_no_fk,inv.ITEM_NAME,SUM(inv.ITEM_QTY) ITEM_QTY ,inv.EXPIRY_DATE,max(finc.INVOICE_DATE) INVOICE_DATE FROM INV_ITEMSTOCKTRANSCHD inv join finc_invoicedtl_vw finc on inv.ITEM_NO_FK = finc.ITEM_NO_FK
        //                                         WHERE TRUNC(EXPIRY_DATE) < TRUNC( SYSDATE ) + INTERVAL '90' DAY
        //                                         AND EXPIRY_DATE >= SYSDATE
        //                                         group by INV.item_no_fk,inv.ITEM_NAME,inv.EXPIRY_DATE
        //                                         order by invoice_date desc"));

        // dd($expire_next_month);
        $re_order_list = DB::select(DB::raw("SELECT inv.ITEM_NAME,
                                                INV.ITEM_NO_FK,
                                                INV.RE_ORDER_LEVEL,
                                                stock.current_stock,
                                                inv.SALES_PRICE,
                                                MAX (finc.INVOICE_DATE) INVOICE_DATE
                                           FROM PHR_ITEM_REORDER_LEVEL_VW inv
                                                LEFT JOIN finc_invoicedtl_vw finc
                                                   ON inv.ITEM_NO_FK = finc.ITEM_NO_FK
                                                LEFT JOIN PHR_TRANSACTION_STOCK_IN_VW stock
                                                   ON inv.item_no_fk = stock.item_no_fk
                                       GROUP BY inv.ITEM_NAME,
                                       INV.RE_ORDER_LEVEL,
                                                INV.ITEM_NO_FK,
                                                stock.current_stock,
                                                inv.SALES_PRICE"));
        // dd( $re_order_list);
        //    Chart Query
        $echart_data = DB::select("SELECT number_val,
                                    sale_hour,
                                    ROUND (total_sales, 2) total_sales,
                                    ROUND (total_collection, 2) total_collection
                            FROM    (SELECT number_val
                                        FROM sysc_number
                                        WHERE number_val < 25) hrs
                                    LEFT JOIN
                                    (  SELECT TO_CHAR (LEDGER_DATE, 'hh24') sale_hour,
                                                AVG (LEDGER_AMT_SALES) total_sales,
                                                AVG (LEDGER_AMT_PAYMENT) total_collection
                                            FROM FINC_LEDGERMST
                                        WHERE TRUNC (LEDGER_DATE) > TRUNC (ADD_MONTHS (SYSDATE, -3))
                                        GROUP BY TO_CHAR (LEDGER_DATE, 'hh24')) dta
                                    ON hrs.number_val = dta.sale_hour
                            ORDER BY number_val");

        // dd($echart_data);

        // $serial_data = '';
        // if (!empty($echart_data)) {
        //     foreach ($echart_data as $key => $row) {

        //         return response()->json($row);

        //         // $s_h = $row->sale_hour;
        //         // if ($s_h != '') {
        //         //     $serial_data .= $row->sale_hour . ',';
        //         // }
        //     }
        //     // return ($serial_data);
        // }

        // dd($row);
        $echart_chart_data = json_encode([$echart_data]);
        // dd($dashboard_data);

        return Template::loadview("admin.pharmacy_dashboard.index", [
            'dashboard_data' => $dashboard_data,
            'echart_data' => $echart_data,
            'month_top_medicine' => $month_top_medicine,
            'ltmls' => $ltmls,
            'expire_this_month' => $expire_this_month,
            'expire_next_month' => $expire_next_month,
            're_order_list' => $re_order_list,
            'echart_chart_data' => $echart_chart_data,
            'to_day_sales' => $to_day_sales,
            'monthly_sales' => $monthly_sales,
            'management_ind' => $management_ind,
        ]);
    }
}
