<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Repositories\BaseRepository as Repo;
use \PDF;
use Auth;
use App\Datatables\DataTableClass;
use App\Models\ServiceUnit;
use Session;
use Response;
use App\Traits\UtilitiesTrait;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class RateManagementController extends Controller
{
    use DatatablesLoader, LookupData, UtilitiesTrait;


    public function __construct(Item $item)
    {
        $this->middleware('auth');
        $this->itemModel = new Repo($item);
    }

    function generalRate()
    {
        # code...
        $requestDepts = DB::table('sysc_serviceunit')->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')->where('status', 1)->get();
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk', 'itemtype_code')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.rate_management.rate_management", [
            'item_type' => $item_type,
            'requestDepts' => $requestDepts
        ]);
    }
    function generalRatePhr()
    {
        # code...
        $requestDepts = DB::table('sysc_serviceunit')->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk', 'itemtype_code')->where('itemtype_code', 'MED')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.rate_management.rate_management_phr", [
            'item_type' => $item_type,
            'requestDepts' => $requestDepts
        ]);
    }

    public function generalRateList(Request $request)
    {

        $table = 'rate_management_vw';
        $primaryKey = 'item_no_pk';
        $sql_cond = "";
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause item_type != 'MED'";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause au_entry_hospital_pk_no = '$hospital_id'";
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_type', 'dt' => 3),
            // array('db' => 'SERVICEUNIT_NAME', 'dt' => 4),
            array('db' => 'sales_price', 'dt' => 4),
            array('db' => 'dealer_sales_price', 'dt' => 5),
            array('db' => 'vat_percent', 'dt' => 6),
            array('db' => 'default_discount_pct', 'dt' => 7),
            array('db' => 'urgent_fee_pct', 'dt' => 8),
            array('db' => 'purchase_price', 'dt' => 9),
            array('db' => 'last_sales_price', 'dt' => 10),
            array('db' => 'last_purchase_price', 'dt' => 11),
            array('db' => 'last_update_date', 'dt' => 12),
            array('db' => 'active_stat', 'dt' => 13),
            array('db' => 'item_no_pk', 'dt' => 14),

        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function generalRateListPhr(Request $request)
    {

        $table = 'rate_management_vw';
        $primaryKey = 'item_no_pk';

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause item_type = 'MED'";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause au_entry_hospital_pk_no = '$hospital_id'";
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_type', 'dt' => 3),
            // array('db' => 'SERVICEUNIT_NAME', 'dt' => 4),
            array('db' => 'sales_price', 'dt' => 4),
            array('db' => 'dealer_sales_price', 'dt' => 5),
            array('db' => 'vat_percent', 'dt' => 6),
            array('db' => 'default_discount_pct', 'dt' => 7),
            array('db' => 'urgent_fee_pct', 'dt' => 8),
            array('db' => 'purchase_price', 'dt' => 9),
            array('db' => 'last_sales_price', 'dt' => 10),
            array('db' => 'last_purchase_price', 'dt' => 11),
            array('db' => 'last_update_date', 'dt' => 12),
            array('db' => 'active_stat', 'dt' => 13),
            array('db' => 'item_no_pk', 'dt' => 14),

        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function editRate($id="" , $type="")
    {
        $requestDepts = DB::table('sysc_serviceunit')->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $service_unit = ServiceUnit::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $data = $this->itemModel->show($id);
        return Template::loadview("admin.rate_management.edit_item_rate", [
            'item' => $data,
            'requestDepts' => $requestDepts,
            'service_unit' => $service_unit,
            'type' =>$type
        ]);
    }

    public function updateRate(Request $request)
    {
        //return $request;
        $id = $request->id;
        $auth_id = Auth::id();
      
        try {
            DB::beginTransaction();
            $data = [
                'sales_price' => $request->item_sales_price ? $request->item_sales_price : 0,
                'purchase_price' => $request->item_purchase_price ? $request->item_purchase_price : 0,
                'dealer_sales_price' => $request->dealer_price ? $request->dealer_price : 0,
                'vat_percent' => $request->vat ? $request->vat : 0,
                'default_discount_pct' => $request->default_discount ? $request->default_discount : 0,
                'urgent_fee_pct' => $request->urgent_fee ? $request->urgent_fee : 0,
                'disc_aplicable' => $request->dis_inapplicable ? $request->dis_inapplicable : 0,
                'status' => 1,
                'accounts_mapping_su_no_fk' => $request->accounts_service_unit,
                'non_stock_ind' => $request->stock_type,
                'ipd_urg_pct' => $request->ipd_urg_pct,
                'max_disc_pct' => $request->max_discount,
            ];
            //dd($data);

            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            // $this->itemModel->update($data, $id);
           DB::table('sysc_serviceitem')->where('item_no_pk',$id)->update($data);

            DB::commit();
            $message = ['msg' => 'Data Update Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function searchGeneralList(Request $request)
    {
        //dd($request->all());
        $supplier_no_fk = $request->hdn_supplier_id;
        // dd($supplier_no_fk);
        $item_rate = $request->item_rate;
        //dd($item_rate);
        $mrp_price = $request->mrp_price;
        $trade_price = $request->trade_price;
        $price_range = $request->price_range;
        $item_type = $request->item_type;
        $start_price = $request->start_price;
        $end_price = $request->end_price;
        $request_department = $request->request_department;

        $item_type_name = $item_type; // substr($item_type, 0, 3);

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $request_department != "" ? " $clause invoice_code = '$request_department'" : "";

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $item_rate != "" ? " $clause invoice_code = '$item_rate'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause item_type != 'MED'";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $mrp_price != "" ? " $clause last_sales_price = $mrp_price " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $trade_price != "" ? " $clause last_purchase_price = $trade_price" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $item_type_name != "" ? " $clause item_type = '$item_type_name' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $supplier_no_fk != "" ? " $clause supplier_no_pk = '$supplier_no_fk' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $start_price && $end_price != "" ? " $clause last_sales_price between $start_price and $end_price " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";

        $table = 'rate_management_vw';
        $primaryKey = 'item_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_type', 'dt' => 3),
            array('db' => 'sales_price', 'dt' => 4),
            array('db' => 'dealer_sales_price', 'dt' => 5),
            array('db' => 'vat_percent', 'dt' => 6),
            array('db' => 'default_discount_pct', 'dt' => 7),
            array('db' => 'urgent_fee_pct', 'dt' => 8),
            array('db' => 'purchase_price', 'dt' => 9),
            array('db' => 'last_sales_price', 'dt' => 10),
            array('db' => 'last_purchase_price', 'dt' => 11),
            array('db' => 'last_update_date', 'dt' => 12),
            array('db' => 'active_stat', 'dt' => 13),
            array('db' => 'item_no_pk', 'dt' => 14),
        );
        //dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function searchGeneralListPhr(Request $request)
    {

        $supplier_no_fk = $request->hdn_supplier_id;
        // dd($supplier_no_fk);
        $item_rate = $request->item_rate;
        //dd($item_rate);
        $mrp_price = $request->mrp_price;
        $trade_price = $request->trade_price;
        $price_range = $request->price_range;
        $item_type = $request->item_type;
        $start_price = $request->start_price;
        $end_price = $request->end_price;
        $request_department = $request->request_department;

        $item_type_name = $item_type; // substr($item_type, 0, 3);

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause item_type = 'MED'";
        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $request_department != "" ? " $clause invoice_code = '$request_department'" : "";

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $item_rate != "" ? " $clause invoice_code = '$item_rate'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $mrp_price != "" ? " $clause last_sales_price = $mrp_price " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $trade_price != "" ? " $clause last_purchase_price = $trade_price" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $item_type_name != "" ? " $clause item_type = '$item_type_name' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $supplier_no_fk != "" ? " $clause supplier_no_pk = '$supplier_no_fk' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $start_price && $end_price != "" ? " $clause last_sales_price between $start_price and $end_price " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";

        $table = 'rate_management_vw';
        $primaryKey = 'item_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_type', 'dt' => 3),
            array('db' => 'sales_price', 'dt' => 4),
            array('db' => 'dealer_sales_price', 'dt' => 5),
            array('db' => 'vat_percent', 'dt' => 6),
            array('db' => 'default_discount_pct', 'dt' => 7),
            array('db' => 'urgent_fee_pct', 'dt' => 8),
            array('db' => 'purchase_price', 'dt' => 9),
            array('db' => 'last_sales_price', 'dt' => 10),
            array('db' => 'last_purchase_price', 'dt' => 11),
            array('db' => 'last_update_date', 'dt' => 12),
            array('db' => 'active_stat', 'dt' => 13),
            array('db' => 'item_no_pk', 'dt' => 14),
        );
        //dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchGeneralListPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $supplier_no_fk = $request->hdn_supplier_id;
        // dd($supplier_no_fk);
        $item_rate = $request->item_rate;
        //dd($item_rate);
        $mrp_price = $request->mrp_price;
        $trade_price = $request->trade_price;
        $price_range = $request->price_range;
        $item_type = $request->item_type;
        $start_price = $request->start_price;
        $end_price = $request->end_price;

        $item_type_name = $item_type; // substr($item_type, 0, 3);

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= $item_rate != "" ? " $clause invoice_code = '$item_rate'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause item_type != 'MED'";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $mrp_price != "" ? " $clause last_sales_price = $mrp_price " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $trade_price != "" ? " $clause last_purchase_price = $trade_price" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $item_type_name != "" ? " $clause item_type = '$item_type_name' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $supplier_no_fk != "" ? " $clause supplier_no_pk = '$supplier_no_fk' " : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $start_price && $end_price != "" ? " $clause last_sales_price between $start_price and $end_price " : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        $data_arr = DB::select(DB::raw("select * from rate_management_vw $sql_cond order by item_name Asc "));
        $data = $data_arr;

        // if ($request->input_item_type == 'PDF') {
        //     return $this->generatePdf('admin.rate_management.rate_management_pdf', "Item_rate_list", $data);
        // }
        // if ($request->input_item_type == 'EXCEL') {
        //     return $this->generateExcel('admin.rate_management.rate_management_pdf', 'Item_rate_list', $data);
        // }

        $barcode = new BarcodeGenerator();
        $barcode->setText("item rate list");
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($request->input_item_type == "PDF") {
            $pdf = PDF::loadView('admin.rate_management.rate_management_pdf', ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
            return $pdf->download('item-rate-list.pdf');
        }
        if ($request->input_item_type == "EXCEL") {
            $pdf = ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no];
            $fileToExport = "item-rate-list";
            $html = View('admin.rate_management.rate_management_pdf')->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
    public function searchGeneralListPrintPhr(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $supplier_no_fk = $request->hdn_supplier_id;
        // dd($supplier_no_fk);
        $item_rate = $request->item_rate;
        //dd($item_rate);
        $mrp_price = $request->mrp_price;
        $trade_price = $request->trade_price;
        $price_range = $request->price_range;
        $item_type = $request->item_type;
        $start_price = $request->start_price;
        $end_price = $request->end_price;

        $item_type_name = $item_type; // substr($item_type, 0, 3);

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause item_type = 'MED'";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= $item_rate != "" ? " $clause invoice_code = '$item_rate'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $mrp_price != "" ? " $clause last_sales_price = $mrp_price " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $trade_price != "" ? " $clause last_purchase_price = $trade_price" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $item_type_name != "" ? " $clause item_type = '$item_type_name' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $supplier_no_fk != "" ? " $clause supplier_no_pk = '$supplier_no_fk' " : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= $start_price && $end_price != "" ? " $clause last_sales_price between $start_price and $end_price " : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        $data_arr = DB::select(DB::raw("select * from rate_management_vw $sql_cond order by item_name Asc "));
        $data = $data_arr;

        // if ($request->input_item_type == 'PDF') {
        //     return $this->generatePdf('admin.rate_management.rate_management_pdf', "Item_rate_list", $data);
        // }
        // if ($request->input_item_type == 'EXCEL') {
        //     return $this->generateExcel('admin.rate_management.rate_management_pdf', 'Item_rate_list', $data);
        // }
        // dd( $data_arr);
        // echo "select * from rate_management_vw $sql_cond order by item_name Asc";
        $barcode = new BarcodeGenerator();
        $barcode->setText("MED");
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($request->input_item_type == "PDF") {
            $pdf = PDF::loadView('admin.rate_management.rate_management_pdf', ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
            return $pdf->download('item-rate-list.pdf');
        }
        if ($request->input_item_type == "EXCEL") {
            $pdf = ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no];
            $fileToExport = "item-rate-list";
            $html = View('admin.rate_management.rate_management_pdf')->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
}
