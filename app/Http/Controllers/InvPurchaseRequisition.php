<?php

namespace App\Http\Controllers;

use App;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use \PDF;

class InvPurchaseRequisition extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $my_requsition = DB::table('inv_purchase_requisitionmst')
            ->where('au_entry_by', Auth::user()->user_no_pk)
            ->orderBy('pur_requisition_no_pk','desc')
            ->get();
        return Template::loadView("admin.inventory.requisition.my_requisition_list", ['my_requsition' => $my_requsition]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return Template::loadView("admin.inventory.requisition.create_new_requistion");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $sequence = DB::getSequence();
        try {
            $data = [
                "req_at" => date('Y-m-d h:i:s'),
                "req_by" => Auth::user()->user_no_pk,
                "req_name" =>  Auth::user()->user_fullname,
                "req_ind" => 1,
                "designation_no_fk" => Session::get('user.job_title_lookup_no'),
                "designation_name" => Session::get('user.designation_name'),
                "su_no_fk" => Session::get('user.su_pk_no'),
                "su_name" => Session::get('user.serviceunit'),
                "status" => 1,
                "au_entry_by" => Auth::user()->user_no_pk,
                "au_entry_at" => date('Y-m-d h:i:s'),
                "au_entry_session" => "Requisition",
                "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
            ];
            if (isset($request->hdn_requisition_no)) {
                $pur_requisition_no_pk_seq = $request->hdn_requisition_no;
                DB::table('inv_purchase_requisitionmst')->where('pur_requisition_no_pk', $pur_requisition_no_pk_seq)->update($data);
                DB::table('inv_purchase_requisitiondtl')->where('pur_requisition_no_pk', $pur_requisition_no_pk_seq)->delete();
            } else {

                $pur_requisition_no_pk_seq = $sequence->nextValue('pur_requisition_no_pk_seq');
                $data["pur_requisition_no_pk"] = $pur_requisition_no_pk_seq;
                $data["pur_requisition_uid"] = 'REQ-' . date('Ymd') . '-' . str_pad($pur_requisition_no_pk_seq, 6, '0');
                $data["pur_requisition_date"] = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
                DB::table('inv_purchase_requisitionmst')->insert($data);
            }

            for ($i = 0; $i < count($request->item_ids); $i++) {
                $pur_requisitiondtl_no_pk_seq = $sequence->nextValue('pur_requisitiondtl_no_pk_seq');
                $data2 = [
                    "pur_requisitiondtl_no_pk" => $pur_requisitiondtl_no_pk_seq,
                    "pur_requisition_no_pk" =>  $pur_requisition_no_pk_seq,
                    "item_no_fk" => $request->item_ids[$i],
                    "item_name" => $request->item_name_arr[$i],
                    "rate" => Session::get('user.inv_proc_ind') == 1 ? $request->item_rates[$i] : 0,
                    "estimated_price" =>  Session::get('user.inv_proc_ind') == 1 ? $request->item_rates[$i] * $request->item_quantities[$i] : 0,
                    "uom" => $request->item_uoms[$i],
                    "req_quantity" => $request->item_quantities[$i],
                    "status" => 1,
                    "au_entry_by" => Auth::user()->user_no_pk,
                    "au_entry_at" => date('Y-m-d h:i:s'),
                    "au_entry_session" => "Requisition",
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                    "is_stock_ok" => 0
                ];
                DB::table('inv_purchase_requisitiondtl')->insert($data2);
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully. <br><strong>Requsition UID = ' . $pur_requisition_no_pk_seq . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            // $this->message = ['msg' => 'There is an error', 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $my_requsition = DB::table('inv_purchase_requisitionmst')
            ->where('pur_requisition_no_pk', $id)
            ->first();

        $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
            ->where('pur_requisition_no_pk', $id)
            ->get();
        return Template::loadView("admin.inventory.requisition.create_new_requistion", [
            'my_requsition' => $my_requsition,
            'my_requsition_dtls' => $my_requsition_dtls,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invRequisitionSearch(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_purchase_requisitionmst');
        if (!empty($request->indent_no)) {
            $query->where('pur_requisition_uid', $request->indent_no);
        }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('pur_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('pur_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('pur_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('pur_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        return Template::loadview("admin.inventory.requisition.my_requisition_table", [
            'my_requsition' => $query->where('au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('pur_requisition_uid', 'desc')->get(),
        ]);
    }
    public function invPurchaseRequstionPrint($req_id)
    {
        //dd('test');
        PDF::setOptions(['isPhpEnabled', 'true']);
        //$pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code","PAYMODE");

        // $po_hospital_details = DB::select(DB::raw("SELECT h.*
        // FROM INV_PURCHASEORDER_MST pom
        // LEFT JOIN WSEC_HOSPITAL h ON pom.AU_ENTRY_HOSPITAL_NO_FK = h.HOSPITAL_NO_PK
        // WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));
        // dd($po_hospital_details);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_purchase_requisitionmst')
            ->where('pur_requisition_no_pk', $req_id)
            ->first();

        if (Session::get('user.inv_store_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $req_id)
                ->where('is_stock_ok',0)
                ->get();
        } else {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
            ->where('pur_requisition_no_pk', $req_id)
            ->get();
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        // $po_child_details_info = DB::select(DB::raw("SELECT *
        //         FROM INV_PURCHASEORDER_CHD poc
        //         LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        //         WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by i.item_name"));

        // $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();
        // //dd($terms);
        // //dd($po_hospital_details);

        // // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        // // ->where("invoice_no_fk", $invoice_id)
        // // ->get();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        // return view("admin.store.purchase_order_print", [
        //     'purchase_order_id' => $purchase_order_id,
        //     'po_master_info' => $po_master_info,
        //     'po_child_details_info' => $po_child_details_info,
        //     'userInfo' => $userInfo,
        //     'po_hospital_details' => $po_hospital_details,
        //     'invoice_barcode' => $invoice_barcode,
        //     'terms' =>   $terms
        // ]);

        $pdf = PDF::loadView("admin.inventory.requisition.requisition_form_pdf", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition' => $my_requsition,
            'my_requsition_dtls' => $my_requsition_dtls,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }
    public function invRequistionApprovalWorklist()
    {
        $my_requsition = [];
        if (Session::get('user.inv_auth_chairman_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_auth_director_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_auth_admin_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_hod_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
       // dd((Session::get('user.inv_hod_ind') == 1));
        return Template::loadView("admin.inventory.requisition.requisition_approval_list", ['my_requsition' => $my_requsition]);
    }
}
