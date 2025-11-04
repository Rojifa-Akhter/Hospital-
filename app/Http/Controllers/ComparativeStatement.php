<?php

namespace App\Http\Controllers;

use DB;
use \PDF;
use Session;
use App\Models\UomLookup as Lookup;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class ComparativeStatement extends Controller
{
    public function comparative_statement_v1()
    {
        $approved_pr = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option
                                    from inv_requisitionmst_po pr
                                    left join sysc_approvalprocess_vw apr
                                    on apr.primary_key_value = pr.inv_requisition_po_no_pk
                                    where apr.approved_ind = 1");

        $barcode = new BarcodeGenerator();
        $barcode->setText($request->indent_no);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();
        $purchase_order_id = 1181;//$request->indent_no;

        $my_requsition = DB::select("
        select count(*) total, item_name,item_no_fk,approve_qty,supplier_prd_details
        from inv_comparative_statement
        where requisition_code = '$purchase_order_id'
        group by item_name,item_no_fk,approve_qty,supplier_prd_details");

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

        

        return view("admin.uhl.comparative-statement",["userInfo" => $userInfo,
            "my_requisition" => $my_requsition,
            "po_hospital_details" => $po_hospital_details,
            'admission_barcode' => $admission_barcode,
            'supplier_info'=> [],
            'purchase_order_id' => $purchase_order_id,
            'max_comp_supplier' => $max_comp_supplier,
            'supplier_name_total_sum' => $supplier_name_total_sum,
            'approved_pr' => $approved_pr
        ]);
    }

    public function create_comparative_statement_v1()
    {
        $approved_pr = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option
                                    from inv_requisitionmst_po pr
                                    left join sysc_approvalprocess_vw apr
                                    on apr.primary_key_value = pr.inv_requisition_po_no_pk
                                    where apr.approved_ind = 1");



        

        return Template::loadView('admin.uhl.comparative_statement.create_comparative_statement',compact('approved_pr'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comparative_statement_list =  DB::table('inv_comparative_statement')
            ->orderBy('comparative_no_pk','desc')
            ->get();

        
        return Template::loadView('admin.inventory.comparative_statement.comparative_statement_list', [
            'comparative_statement_list' => $comparative_statement_list
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $approved_pr = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option
                                    from inv_requisitionmst_po pr
                                    left join sysc_approvalprocess_vw apr
                                    on apr.primary_key_value = pr.inv_requisition_po_no_pk
                                    where apr.approved_ind = 1");
                                  
        $uom_data = Lookup::where('uom_code','!=','PC')->orderBy('uom_no_pk','asc')->get();
       
        $suppliers = DB::table('inv_supplier')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $requisitions = DB::table("inv_requisitionmst")->orderBy('inv_requisition_no_pk')->get();

        return Template::loadView('admin.inventory.comparative_statement.create_comparative_statement', [
            'suppliers' => $suppliers,
            'approved_pr' => $approved_pr,
            'uom_data' => $uom_data,
            'requisitions' => $requisitions
        ]);
    }


    public function requisition_details(Request $request)
    {
        $requisition_no = $request->requisition_no;
        
        $requisition_details = DB::table('inv_requisitiondtl')->where('inv_requisition_no_fk', $requisition_no)->get();

        if (! $requisition_details->isEmpty()) {

            return response()->json(['success' => true, 'data' => $requisition_details], 200);

        } else {

            return response()->json(['success' => false, 'data' => [], 'msg' => 'No Data Found'], 200);

        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //

        //dd(json_decode(json_encode($request->vendor_prd_inf),true));

        try {

            if (! DB::table('inv_comparative_statement')->where('requisition_no_fk', $request->req_no)->exists()) {
                $sequence = DB::getSequence();
                $comparative_no_pk_seq = $sequence->nextValue('comparative_no_pk_seq');
                DB::table('inv_comparative_statement')->insert([
                    'comparative_no_pk' => $comparative_no_pk_seq,
                    'requisition_no_fk'=> $request->req_no, 
                    'requisition_code'=> $request->req_no, 
                    'item_name'=> $request->particular, 
                    'cs_vendor_item_list' => json_encode($request->vendor_prd_inf),
                    'cs_vendor_services' => json_encode($request->vendor_services),
                    'status' => 0,
                    "au_entry_by" => Auth::user()->user_no_pk,
                    "au_entry_at" => date('Y-m-d h:i:s'),
                    "au_entry_session" => "Comparative Statement",
                    "au_entry_hospital_no_fk" => Session::get('user.ses_hospital_no_pk')
                ]);
            } else {

                DB::table('inv_comparative_statement')->where('requisition_no_fk', $request->req_no)
                    ->update([
                            'item_name'=> $request->particular, 
                            'cs_vendor_item_list' => json_encode($request->vendor_prd_inf),
                            'cs_vendor_services' => json_encode($request->vendor_services),
                            'status' => 0,
                            "au_entry_by" => Auth::user()->user_no_pk,
                            "au_entry_at" => date('Y-m-d h:i:s'),
                            "au_entry_session" => "Comparative Statement",
                            "au_entry_hospital_no_fk" => Session::get('user.ses_hospital_no_pk')
                        ]);
            }
            
            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
            return response()->json($message);

        } catch(\Exception $e) {
            DB::rollback();
            $message = ['msg' => 'Data saving failed.', 'title' => 'Error'];
            return response()->json($message);
        }
    }

    public function cs_approval_toggle(Request $request)
    {
        $req_no = $request->req_no;
        $supplier = $request->supplier;

        $comparative_statement =  DB::table('inv_comparative_statement')
            ->where('requisition_no_fk',$req_no)
            ->get();

        $vendor_qut = [];

        if ($comparative_statement[0]->status == '' || isset($comparative_statement[0]->status)) {

            if (isset($comparative_statement[0]->cs_vendor_item_list)) {
                

                foreach(collect(json_decode($comparative_statement[0]->cs_vendor_item_list))->where('req_no', $req_no) as $item_list) {

                    //->where('supplier_name',$supplier)

                    if ($item_list->supplier_name == $supplier) {

                        array_push($vendor_qut, [
                            'req_no' => $item_list->req_no,
                            'supplier_name' => $item_list->supplier_name,
                            'particular' => $item_list->particular,
                            'prd_description' => $item_list->prd_description,
                            'prd_qty' => $item_list->prd_qty,
                            'prd_uom' => $item_list->prd_uom,
                            'prd_amount' => $item_list->prd_amount,
                            'status' => 1
                        ]);
                    } else {

                        array_push($vendor_qut,[
                            'req_no' => $item_list->req_no,
                            'supplier_name' => $item_list->supplier_name,
                            'particular' => $item_list->particular,
                            'prd_description' => $item_list->prd_description,
                            'prd_qty' => $item_list->prd_qty,
                            'prd_uom' => $item_list->prd_uom,
                            'prd_amount' => $item_list->prd_amount,
                            'status' => 0
                        ]);

                    }

                }


                DB::table('inv_comparative_statement')
                ->where('requisition_no_fk',$req_no)
                ->update([
                    'status' => 1,
                    'cs_vendor_item_list' => json_encode($vendor_qut)
                ]);
            }
        }
        
        // foreach($comparative_statement->cs_vendor_item_list as $vendor_details) {

        // }

        //return response()->json(['success' => true, 'msg' => 'Comparative statement successfully approved'], 200);

        $updated_comparative_statement =  DB::table('inv_comparative_statement')
            ->orderBy('comparative_no_pk','desc')
            ->get();


        return view('admin.inventory.comparative_statement.comparative-statement', [
            'comparative_statement' => $updated_comparative_statement,
            'req_no' => $req_no
        ]);

    }


    public function print_comparative_statement(Request $request)
    {
        $req_no = $request->req_no;
        $supplier = $request->supplier;

        $comparative_statement =  DB::table('inv_comparative_statement')
            ->where('requisition_no_fk',$req_no)
            ->get();

        

        return view('admin.inventory.comparative_statement.print-comparative-statement', [
            'comparative_statement' => $comparative_statement
        ]);
    }


    public function cs_policy()
    {
        return view('admin.inventory.comparative_statement.cs_policy');
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
    public function invComparativeStatementSearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query =  DB::table('inv_comparative_statement')
            ->select('inv_comparative_statement.*', 'inv_supplier.supplier_name')
            ->join('inv_supplier', 'inv_comparative_statement.supplier_no_fk', 'inv_supplier.supplier_no_pk');


        if (!empty($request->indent_no)) {
            $query->where('requisition_code', "$request->indent_no");
        }

        if (!empty($request->indent_date_from) && !empty($request->indent_date_to)) {
            $query->where('pur_requisition_date', '>=', date('Y-m-d', strtotime($request->indent_date_from)));
            $query->where('pur_requisition_date', '<=', date('Y-m-d', strtotime($request->indent_date_to)));
        } elseif (!empty($request->indent_date_from)) {
            $query->where('pur_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (!empty($request->indent_date_to)) {
            $query->where('pur_requisition_date', '=', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        return Template::loadview("admin.inventory.comparative_statement.comparative_statement_list_table", [
            'comparative_statement_list' => $query->where('au_entry_hospital_pk_no', $ses_hospital_id)->get(),
        ]);
    }
}
