<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\UomLookup as Lookup;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use \PDF;

class ComparativeStatementApprovalController extends Controller
{
    //
    public function index()
    {
        // $comparative_statement_list =  DB::table('inv_comparative_statement')
        //     ->select('inv_comparative_statement.*', 'inv_supplier.supplier_name')
        //     ->join('inv_supplier', 'inv_comparative_statement.supplier_no_fk', 'inv_supplier.supplier_no_pk')
        //     ->get();
        // dd(Session::get('user.inv_auth_director_ind'));
        return Template::loadView('admin.inventory.comparative_statement.approval.comparative_statement_approval_list', [
            'comparative_statement_list' => []
        ]);
    }
    public function searchComparativeStatement(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query =  DB::table('inv_comparative_statement')
            ->select('inv_comparative_statement.*', 'inv_supplier.supplier_name')
            ->join('inv_supplier', 'inv_comparative_statement.supplier_no_fk', 'inv_supplier.supplier_no_pk');

        if (!empty($request->indent_no)) {
            $query->where('requisition_code', $request->indent_no);
        }

        $query1 =  DB::table('inv_comparative_statement')
            ->select('inv_comparative_statement.*', 'inv_supplier.supplier_name')
            ->join('inv_supplier', 'inv_comparative_statement.supplier_no_fk', 'inv_supplier.supplier_no_pk')
            ->where('approved_ind', 1);
        if (!empty($request->indent_no)) {
            $query1->where('requisition_code', $request->indent_no);
        }
       
        return Template::loadview("admin.inventory.comparative_statement.approval.comparative_statement_list_table", [
            'comparative_statement_list' => $query->where('au_entry_hospital_pk_no', $ses_hospital_id)->get(),
            'approve_ind' => $query1->where('au_entry_hospital_pk_no', $ses_hospital_id)->first()
        ]);
    }


    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->requisition_id); $i++) {
            if (Session::get('user.inv_gen_man_proc_ind') == 1) {
                DB::table('inv_comparative_statement')->where('comparative_no_pk', $request->requisition_id[$i])->update([
                    'passed_by' => Auth::user()->user_no_pk,
                    'passed_ind' => 1,
                    'passed_date' => date('Y-m-d h:i:s'),
                ]);
                DB::commit();
            }
            if (Session::get('user.inv_director_acc_ind') == 1) {
                DB::table('inv_comparative_statement')->where('comparative_no_pk', $request->requisition_id[$i])->update([
                    'approved_by' => Auth::user()->user_no_pk,
                    'approved_ind' => 1,
                    'approved_date' => date('Y-m-d h:i:s'),
                ]);
                DB::commit();
            }
        }

        $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        return response()->json($message);
    }

    public function printComparativeStatement(Request $request)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $approved_pr = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option
                                    from inv_requisitionmst_po pr
                                    left join sysc_approvalprocess_vw apr
                                    on apr.primary_key_value = pr.inv_requisition_po_no_pk
                                    where apr.approved_ind = 1");
                 

        $uom_data = Lookup::where('uom_code','!=','PC')->orderBy('uom_no_pk','asc')->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($request->indent_no);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $purchase_order_id = $request->indent_no;


        $my_requsition = DB::select("
        select count(*) total, item_name,item_no_fk,approve_qty,supplier_prd_details,cs_policy
        from inv_comparative_statement
        where requisition_code = '$purchase_order_id'
        group by item_name,item_no_fk,approve_qty,supplier_prd_details,cs_policy");

        //dd(json_decode($my_requsition[0]->cs_policy));

        $requisition_supplier = DB::select("select count(supplier_no_fk) supplier
        from inv_comparative_statement
        where requisition_code = '$purchase_order_id'
        group by item_no_fk");

        $max_suppliere = max($requisition_supplier);
        $max_comp_supplier = $max_suppliere->supplier;
        $max_comp_total_supplier = array_sum($requisition_supplier);

        $supplier_name_total_sum = array_reduce($requisition_supplier, function($carry, $item)
        {
            return $carry + $item->supplier;
        });

        // $pdf = PDF::loadView("admin.inventory.comparative_statement.approval.print_comparative_statement", ["userInfo" => $userInfo,
        //                                                                                                     "my_requisition" => $my_requsition,
        //                                                                                                     "po_hospital_details" => $po_hospital_details,
        //                                                                                                     'admission_barcode' => $admission_barcode,
        //                                                                                                     'supplier_info'=> [],
        //                                                                                                     'purchase_order_id' => $purchase_order_id,
        //                                                                                                     'max_comp_supplier' => $max_comp_supplier,
        //                                                                                                     'supplier_name_total_sum' => $supplier_name_total_sum
        //         ])->setPaper('a4', 'landscape');
        // return $pdf->stream("comparative-statement-report.pdf", array("Attachment" => false));

        return view("admin.uhl.comparative-statement",["userInfo" => $userInfo,
            "my_requisition" => $my_requsition,
            "cs_policy" => json_decode($my_requsition[0]->cs_policy),
            "po_hospital_details" => $po_hospital_details,
            'admission_barcode' => $admission_barcode,
            'supplier_info'=> [],
            'purchase_order_id' => $purchase_order_id,
            'max_comp_supplier' => $max_comp_supplier,
            'supplier_name_total_sum' => $supplier_name_total_sum,
            'approved_pr' => $approved_pr,
            'uom_data' => $uom_data
        ]);
    }


    public function printPassedComparativeStatement(Request $request)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();



        $barcode = new BarcodeGenerator();
        $barcode->setText($request->indent_no);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $purchase_order_id = $request->indent_no;

        //dd($request->indent_no);
        $my_requsition_items = DB::select("SELECT
        ser.ITEM_NAME,
        ser.item_code ,
         ITEM_NO_FK,
          APPROVE_QTY,
          LISTAGG(sup.supplier_name || '-' ||  s.SUPPLIER_AMT ,'  | ') WITHIN GROUP (ORDER BY ser.ITEM_NAME )  supplier_name_amt
     FROM INV_COMPARATIVE_STATEMENT s join sysc_serviceitem ser
     on ser.item_no_pk=s.item_no_fk join inv_supplier sup
     on sup.supplier_no_pk=s.supplier_no_fk
     where s.passed_ind = 1
     group by
       ser.ITEM_NAME,
        ser.item_code ,
          ITEM_NO_FK,
         APPROVE_QTY");


        $my_requsition = DB::select("select a.item_name,a.item_code,a.approve_qty,a.supplier_name,a.supplier_amt
        from(
            select inv_comparative_statement.item_name,sysc_serviceitem.item_code,inv_comparative_statement.approve_qty,inv_supplier.supplier_name,inv_comparative_statement.supplier_amt
            from inv_comparative_statement
            left join sysc_serviceitem
            on inv_comparative_statement.item_no_fk = sysc_serviceitem.item_no_pk
            left join inv_supplier
            on inv_supplier.supplier_no_pk = inv_comparative_statement.supplier_no_fk
            where inv_comparative_statement.requisition_code = '$purchase_order_id'
        ) a");

        //dd($my_requsition);

        // $my_requsition = DB::table('inv_purchase_requisitionmst')
        //     ->join('inv_purchase_requisitiondtl', 'inv_purchase_requisitiondtl.pur_requisition_no_pk', 'inv_purchase_requisitionmst.pur_requisition_no_pk')
        //     ->leftJoin('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', 'inv_purchase_requisitiondtl.item_no_fk')
        //     //->leftJoin('inv_comparative_statement', 'inv_purchase_requisitionmst.pur_requisition_uid', 'inv_comparative_statement.requisition_code')
        //     ->where('pur_requisition_uid', $purchase_order_id)
        //     //->where('approved_ind',1)
        //     ->get();
        //dd($my_requsition);

        // $supplier_info = DB::table('comparative_statement_vw')
        //     //->leftJoin('inv_comparative_statement', 'inv_purchase_requisitionmst.pur_requisition_uid', 'inv_comparative_statement.requisition_code')
        //     ->where('requisition_code', $purchase_order_id)
        //     //->where('approved_ind',1)
        //     ->get();
        $pdf = PDF::loadView("admin.inventory.comparative_statement.approval.print_comparative_statement", ["userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, 'admission_barcode' => $admission_barcode,'my_requsition_items' => $my_requsition_items,'supplier_info'=> [],'purchase_order_id' => $purchase_order_id]);
        return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
    }
}
