<?php

namespace App\Http\Controllers;

use \PDF;
use Auth;
use DateTime;
use Illuminate\Http\Response;
use App\Library\Template;
use App\Traits\LookupData;
use App\Traits\InvoiceData;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Models\PurchaseOrderChild;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderMaster;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository as Repo;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Facades\Response as FileResponse;

class PurchaseOrderController extends Controller
{

    use DatatablesLoader, InvoiceData, LookupData;
    protected $model;
    protected $model2;
    public function __construct(PurchaseOrderMaster $PurchaseOrderMaster, PurchaseOrderChild $PurchaseOrderChild)
    {
        $this->middleware('auth');
        $this->model = new Repo($PurchaseOrderMaster);
        $this->model2 = new Repo($PurchaseOrderChild);
    }


    public function purchaseOrderPOS()
    {
        return Template::loadview("admin.inventory.purchase_order");
    }
    public function purchaseOrderList()
    {

        // $to_date=date('d-m-Y');
        $poList = DB::select("select purchaseorder_no_pk, trunc(purchase_date) purchase_date, item_no_fk, case when status=1 then 'Active' else 'Inactive' end as status from po_work_list_vw where status = 1 ");
        return Template::loadview("admin.inventory.purchase_order_worklist", ['poList'=>$poList] );
    }
    public function purchaseOrderReceive()
    {
        return Template::loadview("admin.inventory.po_receive");
    }
    public function purchaseOrderPrint($id)
    {
        // dd($id);
        $list=DB::select("select item_no_fk, entry_qty, item_rate, remarks_text from inv_purchaseorder_chd where PURCHASEORDER_NO_FK = $id ");

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.inventory.po_print", ['barcode_no' => $barcode_no, 'list'=>$list]);
        return $pdf->download('admin.inventory.po_print.pdf');
    }

    public function purchaseOrderCreate(Request $request)
    {
        // return $request;
        // dd($request);
        $id = $request->id;

        $auth_id = Auth::id();

        DB::beginTransaction();
      
        try {
            $data = [
               
                'purchase_date' =>  $request->po_date,
                'status' => 1

            ];
            // dd($data);

            if ($id == null || $id == "") {
              
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $response = $this->model->create($data);
                $last_id = $response->purchaseorder_no_pk;
                // return $res;
                $item_array_count = sizeof($request->input("hdn_item_id"));
                $hdn_item_id = $request->input("hdn_item_id");
                $hdn_item_type = $request->input("hdn_item_type");
                $hdn_item_qnty = $request->input("hdn_item_qnty");
                $hdn_item_rate = $request->input("hdn_item_rate");

                for ($i = 0; $i < $item_array_count; $i++) {
                    if ($hdn_item_id[$i] != null) {

                        $itemData = [
                            "purchaseorder_no_fk" => $last_id,
                            'item_no_fk' => $hdn_item_id[$i],
                            'itemtype_no_fk' => $hdn_item_type[$i],
                            'entry_qty' => $hdn_item_qnty[$i],
                            'item_rate' => $hdn_item_rate[$i],
                            'status' => 1

                        ]; 
                        $data['au_entry_by'] = $auth_id;
                        $this->model2->create($itemData);                     
                    }
                    // dd($itemData);

                  
                }
               
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function purchaseOrderSearch(Request $request){
        $date=date('d/m/Y',strtotime($request->date_pic));
        $id=$request->po_id;
        $date_con=($date != '')? " and purchase_date = '$date' " : '';
        $id_con= ($id != '') ? " and purchaseorder_no_pk = $id" : '';
        $poList = DB::select("select purchaseorder_no_pk, trunc(purchase_date) purchase_date, item_no_fk, case when status=1 then 'Active' else 'Inactive' end as status from po_work_list_vw where status = 1  $id_con ");
        return Template::loadview("admin.inventory.purchase_order_list", ['poList'=>$poList] );

    }




    public function downloadPurchaseOrderExcel(Request $request){
        ini_set("max_execution_time",0);
  
        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
            // $from_date = date('Y-m-d', strtotime($request->from_date));
        }

        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
            // $to_date = date('Y-m-d', strtotime($request->to_date));
        }
        $hospitalCode = $request->session()->get('user.ses_hospital_code');
        // dd($from_date,$to_date);
        $query = DB::table('inv_po_wl_vw')
                     ->select(
                        'total_amount',
                        'vat_amount',
                        'discount_amount',
                        'vat_percent',
                        'discount_percent',
                        'discount_amount',
                        'approval_level_status_text',
                        'approval_status_text',
                        'purchaseorder_no_pk',
                        'purchase_uid',
                        'pr_doc_attachment_path',
                        'po_doc_attachment_path',
                        'purchase_date',
                        'supplier_name',
                        'total_qty',
                        'po_save_option',
                        'dollar_rate',
                        'currency_sign',
                        'ait_percent',
                        'ait_amount',
                        'service_charge_percent',
                        'service_charge_amount'
                    );

        if (!empty($request->po_no)) {
            if ($hospitalCode === "KPJ") {
                $query->where('purchase_uid', $request->po_no);
            } else {
                $query->where('purchaseorder_no_pk', $request->po_no);
            }
        }

        if (!empty($request->status)) {
            $query->where('po_save_option', $request->status);
        }
        if (!empty($request->main_store_id)) {
            $query->where('store_no_fk', $request->main_store_id);
        }
        if (!empty($request->supplier)) {
            $query->where('supplier_no_fk', $request->supplier);
        }
        if (!empty($request->from_date) &&  !empty($request->to_date)) {
            $query->whereBetween('purchase_date', [$from_date, $to_date]);
        }
        elseif (!empty($request->from_date)) {
            $query->where('purchase_date', $from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('purchase_date', $to_date);
        }

        $query->where([
            ['finalized_ind', '=', 0],
            ['issue_ind', '=', 0]
        ]);


        $data = $query->orderByDesc('purchaseorder_no_pk')->get()->toArray();


        $status = $request->status;
        $po_no = $request->po_no;
        $supplier = $request->supplier;

        $html = view('admin.inventory.v1.po.export.purchase_order_excel', compact('from_date','to_date','status','po_no','supplier','data'));
        $fileToExport = 'purchase_order_worklist.xls';

        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

}
