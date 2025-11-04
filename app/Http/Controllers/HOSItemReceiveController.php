<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use PDO;
use Session;
USE App\Http\Controllers\BarcodeGenerator;
use Illuminate\Http\Response;


class HOSItemReceiveController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $sql = "begin
        pkg_v1_inventory_all.prc_invrequisition_info_refcur(
                :p_ref_invrequisition_info,
                :p_inv_requisition_no_pk,
                :p_item_name,
                :p_main_su_no_fk,
                :in_au_entry_hospital_no_fk
              
            );
            end;";
        $pdo = DB::getPdo();
        $requisition_no = $request->requisition_no;
        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':p_ref_invrequisition_info', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':p_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        $stmt->bindParam(':p_item_name', $empty, PDO::PARAM_STR, 100);
        $stmt->bindParam(':p_main_su_no_fk', $text, PDO::PARAM_INT);
        $stmt->bindParam(':in_au_entry_hospital_no_fk', $text, PDO::PARAM_INT);
       
        $stmt->execute();

        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);
        $requisition_list =  $array;
        // dd($requisition_list);
        // dd($requisition_list);
        return Template::loadView("admin.uhl.inventory.item-received", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no
        ]);
    }
    public function indnetItemStatus()
    {
        // $sql = "begin
        // pkg_v1_inventory_all.prc_invrequisition_userwise(
        //         :p_ref_invrequisition_info,
        //         :p_inv_requisition_no_pk,
        //         :p_item_name,
        //         :p_main_su_no_fk,
        //         :in_au_entry_by
        //     );
        //     end;";


        $sql = "begin
        pkg_v1_inventory_all.prc_indent2grn_track_refcur(
                :ref_invrequisition2grn_track,
                :in_inv_requisition_no_pk,
                :in_inv_requisition_po_no_pk,
                :in_purchaseorder_no_pk,
                :in_purchase_uid,
                :in_itemreceive_no_pk,
                :in_tracking_for,
                :in_item_no_fk,
                :in_from_date,
                :in_to_date,
                :in_au_entry_hospital_no_fk
            );
            end;";

        $pdo = DB::getPdo();
        $requisition_no = 1721; // $request->requisition_no;
        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];
        $au_entry_at = Auth::id();
        $hospital_no = null; //Session::get('user.ses_hospital_no_pk');
        $stmt = $pdo->prepare($sql);


        // new
        $requisition_po_no = null;
        $purchaseorder_no = null;
        $itemreceive_no = null;
        $item_no = null;
        // $au_entry_hospital_no = null;
        $au_entry_hospital_no = Session::get('user.ses_hospital_no_pk');
        $indent = 'INDENT';

        // $stmt->bindParam(':p_ref_invrequisition_info', $lista, PDO::PARAM_STMT);
        // $stmt->bindParam(':p_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        // $stmt->bindParam(':p_item_name', $empty, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':p_main_su_no_fk', $text, PDO::PARAM_INT);
        // $stmt->bindParam(':in_au_entry_by', $au_entry_at, PDO::PARAM_INT);
        // $stmt->execute();

        // new
        // $stmt->bindParam(':ref_invrequisition2grn_track', $lista, PDO::PARAM_STMT);
        // $stmt->bindParam(':in_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_inv_requisition_po_no_pk', $requisition_po_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchaseorder_no_pk', $purchaseorder_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchase_uid', $empty, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_itemreceive_no_pk', $itemreceive_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_tracking_for', $indent, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_item_no_fk', $item_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_from_date', $text, PDO::PARAM_STR);
        // $stmt->bindParam(':in_to_date', $text, PDO::PARAM_STR);
        // $stmt->bindParam(':in_au_entry_hospital_no_fk', $au_entry_hospital_no, PDO::PARAM_INT);
        // $stmt->execute();

        // oci_execute($lista, OCI_DEFAULT);
        // oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        // oci_free_cursor($lista);
        $requisition_list =[];
        //  $array;  
        // $requisition_list =  $array;
        // dd($requisition_list);
        return Template::loadView("admin.uhl.inventory.indent_item_status", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no
        ]);
    }

    public function indnetItemStatusSearch(Request $request)
    {
        // $sql = "begin
        // pkg_v1_inventory_all.prc_indent2grn_track_refcur(
        //         :ref_invrequisition2grn_track,
        //         :in_inv_requisition_no_pk,
        //         :in_inv_requisition_po_no_pk,
        //         :in_purchaseorder_no_pk,
        //         :in_purchase_uid,
        //         :in_itemreceive_no_pk,
        //         :in_tracking_for,
        //         :in_item_no_fk,
        //         :in_from_date,
        //         :in_to_date,
        //         :in_au_entry_hospital_no_fk
        //     );
        //     end;";
      

        $sql = "begin
        pkg_v1_inventory_all.prc_item_track_refcur(
                :in_item_track,              
                :in_track_no_pk,
                :in_tracking_for,
                :in_item_no_fk,
                :in_from_date,
                :in_to_date
            );
            end;";

        $pdo = DB::getPdo();

        $requisition_no = null;
        $requisition_po_no = null;
        $purchaseorder_no = null;
        $itemreceive_no = null;
        $tracking_for = null;
        $item_no = null;

        if (isset($request->id)) {
            if ($request->id == 'INDENT') {
                $tracking_for = 'INDENT';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'PR') {
                $tracking_for = 'PR';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'PO') {
                $tracking_for = 'PO';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'GRN') {
                $tracking_for = 'GRN';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'ALL') {
                $tracking_for = '';
                $requisition_no = $request->trns_id;
            }
        }

        if (isset($request->item_id)) {
            $item_no = $request->item_id;
           
        }

        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];
        $au_entry_at = Auth::id();
        $hospital_no = Session::get('user.ses_hospital_no_pk');
        $stmt = $pdo->prepare($sql);
        $from_date=$request->from_date !="" ? date('Y-m-d',strtotime($request->from_date)):'';
        $to_date=$request->to_date !="" ? date('Y-m-d',strtotime($request->to_date)):'';
        $au_entry_hospital_no = Session::get('user.ses_hospital_no_pk');

        // $stmt->bindParam(':ref_invrequisition2grn_track', $lista, PDO::PARAM_STMT);
        // $stmt->bindParam(':in_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_inv_requisition_po_no_pk', $requisition_po_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchaseorder_no_pk', $purchaseorder_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchase_uid', $empty, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_itemreceive_no_pk', $itemreceive_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_tracking_for', $tracking_for, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_item_no_fk', $item_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_from_date', $from_date, PDO::PARAM_STR);
        // $stmt->bindParam(':in_to_date', $to_date, PDO::PARAM_STR);
        // $stmt->bindParam(':in_au_entry_hospital_no_fk', $au_entry_hospital_no, PDO::PARAM_INT);
        // $stmt->execute();
       
        $stmt->bindParam(':in_item_track', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':in_track_no_pk', $requisition_no, PDO::PARAM_INT);       
        $stmt->bindParam(':in_tracking_for', $tracking_for, PDO::PARAM_STR, 100);
        $stmt->bindParam(':in_item_no_fk', $item_no, PDO::PARAM_INT);
        $stmt->bindParam(':in_from_date', $from_date, PDO::PARAM_STR);
        $stmt->bindParam(':in_to_date', $to_date, PDO::PARAM_STR);
        // dd($stmt);
        $stmt->execute();

        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);
        $requisition_list =  $array;
        // dd($requisition_list,$tracking_for , $requisition_no,$requisition_no,$item_no );
        return Template::loadView("admin.uhl.inventory.indent_item_status_list", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no
        ]);
    }


    public function indentToGrnDownload(Request $request)
    {
        //  dd($request->all());

        // $sql = "begin
        // pkg_v1_inventory_all.prc_indent2grn_track_refcur(
        //         :ref_invrequisition2grn_track,
        //         :in_inv_requisition_no_pk,
        //         :in_inv_requisition_po_no_pk,
        //         :in_purchaseorder_no_pk,
        //         :in_purchase_uid,
        //         :in_itemreceive_no_pk,
        //         :in_tracking_for,
        //         :in_item_no_fk,
        //         :in_from_date,
        //         :in_to_date,
        //         :in_au_entry_hospital_no_fk
        //     );
        //     end;";
        $sql = "begin
        pkg_v1_inventory_all.prc_item_track_refcur(
                :in_item_track,              
                :in_track_no_pk,
                :in_tracking_for,
                :in_item_no_fk,
                :in_from_date,
                :in_to_date
            );
            end;";
        $pdo = DB::getPdo();

        $requisition_no = null;
        $requisition_po_no = null;
        $purchaseorder_no = null;
        $itemreceive_no = null;
        $tracking_for = null;
        $item_no = null;

        if (isset($request->id)) {
            if ($request->id == 'INDENT') {
                $tracking_for = 'INDENT';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'PR') {
                $tracking_for = 'PR';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'PO') {
                $tracking_for = 'PO';
                $requisition_no = $request->trns_id;
            } elseif ($request->id == 'GRN') {
                $tracking_for = 'GRN';
                $requisition_no = $request->trns_id;
            }
        }

        if (isset($request->item_id)) {
            $item_no = $request->item_id;
        }

        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];
        $au_entry_at = Auth::id();
        $hospital_no = Session::get('user.ses_hospital_no_pk');
        $stmt = $pdo->prepare($sql);
        $from_date=$request->from_date !="" ? date('Y-m-d',strtotime($request->from_date)):'';
        $to_date=$request->to_date !="" ? date('Y-m-d',strtotime($request->to_date)):'';
        $au_entry_hospital_no = Session::get('user.ses_hospital_no_pk');
        // dd($requisition_no, $tracking_for);
        // $stmt->bindParam(':ref_invrequisition2grn_track', $lista, PDO::PARAM_STMT);
        // $stmt->bindParam(':in_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_inv_requisition_po_no_pk', $requisition_po_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchaseorder_no_pk', $purchaseorder_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_purchase_uid', $empty, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_itemreceive_no_pk', $itemreceive_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_tracking_for', $tracking_for, PDO::PARAM_STR, 100);
        // $stmt->bindParam(':in_item_no_fk', $item_no, PDO::PARAM_INT);
        // $stmt->bindParam(':in_from_date', $from_date, PDO::PARAM_STR);
        // $stmt->bindParam(':in_to_date', $to_date, PDO::PARAM_STR);
        // $stmt->bindParam(':in_au_entry_hospital_no_fk', $au_entry_hospital_no, PDO::PARAM_INT);
        // $stmt->execute();

        $stmt->bindParam(':in_item_track', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':in_track_no_pk', $requisition_no, PDO::PARAM_INT);       
        $stmt->bindParam(':in_tracking_for', $tracking_for, PDO::PARAM_STR, 100);
        $stmt->bindParam(':in_item_no_fk', $item_no, PDO::PARAM_INT);
        $stmt->bindParam(':in_from_date', $from_date, PDO::PARAM_STR);
        $stmt->bindParam(':in_to_date', $to_date, PDO::PARAM_STR);
        $stmt->execute();

        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);
        $requisition_list =  $array;
        // dd($requisition_list);
      
        //    dd($requisition_list[0]["REQ_INV_REQUISITION_NO_PK"]);

        $html = view("admin.uhl.inventory.indent_to_grn_report", compact('requisition_list', 'from_date', 'to_date'));
        $fileToExport = 'indent_to_grn_{"from_date"}.xls';
        $response = new Response($html);
        // dd($response);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response; 
    }




    public function store(Request $request)
    {
        try {

            $pdo = DB::getPdo();
            $requisition_info = DB::table('inv_requisitionlist_vw')->where('inv_requisition_no_pk', $request->requisition_no)->first();
            //Reverse From Requisition.
            $in_store_from_su_no_fk = intval($requisition_info->from_store_no_fk);
            $in_store_to_su_no_fk = intval($requisition_info->to_store_no_fk);
            $in_au_entry_session = 'V1 ITEM RECEIVE';
            $in_au_entry_by = intval(Session::get('user.ses_user_pk_no'));
            $in_au_entry_session = 'UHL INDENT RECEIVE';
            $in_au_entry_hospital_pk_no = intval(Session::get('user.ses_hospital_no_pk'));
            $in_transref_date = date('Y-m-d');
            $in_transref_no = intval($requisition_info->inv_requisition_no_pk);
            $main_store = ServiceUnit::where('serviceunit_no_pk', $in_store_from_su_no_fk)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();


            $main_store_module = isset($main_store->main_store_module_no_fk) ?
                intval($main_store->main_store_module_no_fk) : 0;
            $zero = 0;
            $empty_char = "";
            $in_a_entry_serial_dtl = 0;
            // dd($request->item_name,$request->item_quantity , $request->in_inv_requisitiondtl_no_pk );
            for ($i = 0; $i < count($request->item_name); $i++) {

                if (isset($request->item_quantity[$i])) {
                    $item_no_fk_arr = intval($request->item_name[$i]);
                    // $in_a_item_qty = intval($request->item_quantity[$i]);
                    $in_inv_requisitiondtl_no_pk = intval($request->in_inv_requisitiondtl_no_pk[$i]);


                    $item_issue_info = DB::table("phr_itemissuedtl")
                        ->where('inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk)
                        ->where('item_no_fk', $item_no_fk_arr)
                        ->whereNull('receive_ind')
                        ->get();

                    // dd($item_issue_info);
                    $j = 0;
                    foreach ($item_issue_info as $item) {

                        $item_batch_no = $item->batch_no;
                        $item_expiry_date = $item->expiry_date; //isset($item->expiry_date) ? date("Y-m-d", strtotime($item->expiry_date)) : null;
                        $item_uom = intval($item->uom);
                        $internal_batch_no_uq = $item->internal_batch_no_uq;
                        $item_cost_price = intval($item->cost_price);
                        $item_purchase_price = intval($item->purchase_price);
                        $item_sales_price = intval($item->sales_price);
                        $in_a_item_qty = $item->item_qty;
                        $itemreceivedtl_no_pk = intval($item->itemreceivedtl_no_pk);

                        $in_a_entry_serial_dtl = ++$j;

                        // dd($in_inv_requisitiondtl_no_pk,$in_transref_date,$in_store_from_su_no_fk,$in_store_to_su_no_fk,$item_no_fk_arr,$item_issue_info->batch_no,date("Y-m-d", strtotime($item_issue_info->expiry_date)),
                        // $in_a_item_qty,$empty_char,$item_issue_info->uom,$in_a_entry_serial_dtl,$main_store_module,$in_transref_no,$in_inv_requisitiondtl_no_pk,
                        // $zero,$zero,$zero,$item_issue_info->internal_batch_no_uq,intval($item_issue_info->cost_price),intval($item_issue_info->purchase_price),intval($item_issue_info->sales_price),
                        // $in_au_entry_by,$in_au_entry_session,$in_au_entry_hospital_pk_no);
                        $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemreceive_ss(
                                :in_transref_no,
                                :in_transref_date,
                                :in_stock_su_no_fk_from,
                                :in_stock_su_no_fk_to,
                                :in_item_no_fk,
                                :in_item_batch_fk,
                                :in_item_expiry_dt,
                                :in_item_qty,
                                :in_item_pvmsno,  
                                :in_item_uom,
                                :in_entry_serial_dtl,
                                :in_module_no_fk,
                                :in_requisition_no_fk,
                                :in_requisitiondtl_no_pk,
                                :in_purchaseorderdtl_no_pk,
                                :in_itemreceivedtl_no_pk,
                                :in_invoicedtl_no_pk,
                                :in_internal_batch_no_uq,
                                :in_cost_price,   
                                :in_purchase_price, 
                                :in_sales_price,
                                :in_au_entry_by,
                                :in_au_entry_session,
                                :in_au_entry_hospital_no_fk
                                ); end;");
                        $purchase_order_entry->bindparam('in_transref_no', $in_inv_requisitiondtl_no_pk);
                        $purchase_order_entry->bindparam('in_transref_date', $in_transref_date);
                        $purchase_order_entry->bindparam('in_stock_su_no_fk_from', $in_store_from_su_no_fk);
                        $purchase_order_entry->bindparam('in_stock_su_no_fk_to', $in_store_to_su_no_fk);
                        $purchase_order_entry->bindparam('in_item_no_fk', $item_no_fk_arr);
                        $purchase_order_entry->bindparam('in_item_batch_fk', $item_batch_no);
                        $purchase_order_entry->bindparam('in_item_expiry_dt', $item_expiry_date);
                        $purchase_order_entry->bindparam('in_item_qty', $in_a_item_qty);
                        $purchase_order_entry->bindparam('in_item_pvmsno', $empty_char);
                        $purchase_order_entry->bindparam('in_item_uom', $item_uom);
                        $purchase_order_entry->bindparam('in_entry_serial_dtl', $in_a_entry_serial_dtl);
                        $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);
                        $purchase_order_entry->bindparam('in_requisition_no_fk', $in_transref_no);
                        $purchase_order_entry->bindparam('in_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk);
                        $purchase_order_entry->bindparam('in_purchaseorderdtl_no_pk', $zero);
                        $purchase_order_entry->bindparam('in_itemreceivedtl_no_pk', $itemreceivedtl_no_pk);
                        $purchase_order_entry->bindparam('in_invoicedtl_no_pk', $zero);
                        $purchase_order_entry->bindparam('in_internal_batch_no_uq', $internal_batch_no_uq);
                        $purchase_order_entry->bindparam('in_cost_price', $item_cost_price);
                        $purchase_order_entry->bindparam('in_purchase_price', $item_purchase_price);
                        $purchase_order_entry->bindparam('in_sales_price', $item_sales_price);
                        $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
                        $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
                        $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
                        // dd($main_store_module,$in_inv_requisitiondtl_no_pk,$purchase_order_entry);
                        $purchase_order_entry->execute();


                        DB::commit();
                    }
                }
            }
            $message = ['msg' => 'Data saved successfully.<br>', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => 'Failed to Recevied.<br><strong>Error Message = ' . $e->getMessage() . '</strong>', 'title' => 'Success'];
        }

        return response()->json($message);
    }
}
