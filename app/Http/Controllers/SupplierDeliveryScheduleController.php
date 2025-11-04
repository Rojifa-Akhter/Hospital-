<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Supplier;
use App\Models\SupplierSchedule;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class SupplierDeliveryScheduleController extends Controller
{
    protected $supplier_delivery_schedule;

    public function __construct(SupplierSchedule $supplier_schedule_model)
    {
        //$this->middleware('auth');

        $this->supplier_delivery_schedule = new Repo($supplier_schedule_model);
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = $request->id;

        $auth_id = Auth::id();
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $supplier_schedule = SupplierSchedule::where('po_no_fk', $request->po_no_fk)->delete();
            for ($i = 0; $i < count($request->item_name); $i++) {
                if ($request->item_name[$i] != '') {
                    $item_arr = explode('_', $request->item_name[$i]);
                    $data = [
                        'supplier_no_fk' => $request->supplier_no_fk,
                        'po_no_fk' => $request->po_no_fk,
                        'challan_no' => $request->challan_no,
                        'challan_date' => $request->challan_date,
                        'item_no_fk' => isset($item_arr[0]) ? $item_arr[0] : 0,
                        'item_name' => isset($item_arr[1]) ? $item_arr[1] : 0,
                        'order_quantity' => isset($item_arr[2]) ? $item_arr[2] : 0,
                        'item_quantity' => $request->delivery_quantity[$i],
                        'delivery_date' => $request->delivery_date[$i],
                        'au_entry_hospital_pk_no' => $hospital_id,
                        'status' => 1,
                        'module_no_fk' => $request->module_no_fk
                    ];
                    if ($id == null || $id == "") {
                        $data['au_entry_by'] = 1;
                        $res = $this->supplier_delivery_schedule->create($data);
                    } else {
                        $data['au_update_by'] = $auth_id;
                        $this->supplier_delivery_schedule->update($data, $id);
                    }

                    DB::commit();
                }
            }
            $message = ['msg' => 'Delivery Schedule Created Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
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
        $po_details = DB::table('inv_po_wl_vw')->where('purchaseorder_no_pk', $id)->first();
        $suppiler_details = Supplier::find($po_details->supplier_no_fk);
        $po_child_details_info = DB::select(DB::raw("SELECT i.item_no_pk,i.item_code, i.item_name, poc.entry_qty, poc.item_rate
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN SYSC_SERVICEITEM i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $id"));
        $supplier_schedule = SupplierSchedule::where('po_no_fk', $id)->get();
        return Template::loadView(
            "admin.supplier_delivery_schedule.pharmacy_supplier_delivery_schedule",
            [
                'po_details' => $po_details,
                'po_child_details_info' => $po_child_details_info,
                'suppiler_details' => $suppiler_details,
                'supplier_schedule' => $supplier_schedule,
            ]
        );
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
        $po_details = DB::table('inv_po_wl_vw')->where('purchaseorder_no_pk', $id)->first();
        $suppiler_details = Supplier::find($po_details->supplier_no_fk);
        $po_child_details_info = DB::select(DB::raw("SELECT i.item_no_pk,i.item_code, i.item_name, poc.entry_qty, poc.item_rate
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN SYSC_SERVICEITEM i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $id"));
        $supplier_schedule = SupplierSchedule::where('po_no_fk', $id)->get();
        return Template::loadView(
            "admin.supplier_delivery_schedule.supplier_delivery_schedule",
            [
                'po_details' => $po_details,
                'po_child_details_info' => $po_child_details_info,
                'suppiler_details' => $suppiler_details,
                'supplier_schedule' => $supplier_schedule,
            ]
        );
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
    public function supplier_delivery_viewer()
    {
        return Template::loadView('admin.supplier_delivery_schedule.supplier_delivery_schedule_viewer');
    }
    public function pharmacy_supplier_delivery_viewer()
    {
        return Template::loadView('admin.supplier_delivery_schedule.pharmacy_supplier_delivery_schedule_viewer');
    }
    public function show_supplier_schedule_viewer()
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $results = DB::select("select inv_supplier.supplier_name,item_name,item_quantity,to_date(to_char(delivery_date,'ddmmyyyy'),'dd-mm-yyyy')  sstart,
                         to_date(to_char(delivery_date,'ddmmyyyy'),'dd-mm-yyyy')  send
                         from inv_supp_sdle_delivery
                         join inv_supplier
                         on inv_supp_sdle_delivery.supplier_no_fk = inv_supplier.supplier_no_pk
                         left join sysc_module
                         on inv_supp_sdle_delivery.module_no_fk = sysc_module.module_no_pk

                          where inv_supp_sdle_delivery.au_entry_hospital_pk_no = $hospital_id
                          and sysc_module.module_code = 'INVENTORY' ");
        //return json_encode(SupplierSchedule::all());

        $sarray = [];
        foreach ($results as $result) {
            array_push($sarray, [
                'title' => $result->supplier_name . '-(' . $result->item_name . ':' . $result->item_quantity . ')',
                'start' => date("Y-m-d", strtotime($result->sstart)),
                'end' => date("Y-m-d", strtotime($result->send)),
            ]);
        }

        echo json_encode($sarray);
    }

    public function pharmacy_show_supplier_schedule_viewer()
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $results = DB::select("select inv_supplier.supplier_name,item_name,item_quantity,to_date(to_char(delivery_date,'ddmmyyyy'),'dd-mm-yyyy')  sstart,
                         to_date(to_char(delivery_date,'ddmmyyyy'),'dd-mm-yyyy')  send
                         from inv_supp_sdle_delivery
                         join inv_supplier
                         on inv_supp_sdle_delivery.supplier_no_fk = inv_supplier.supplier_no_pk
                         left join sysc_module
                         on inv_supp_sdle_delivery.module_no_fk = sysc_module.module_no_pk

                          where inv_supp_sdle_delivery.au_entry_hospital_pk_no = $hospital_id
                          and sysc_module.module_code = 'PHR' ");
        //return json_encode(SupplierSchedule::all());

        $sarray = [];
        foreach ($results as $result) {
            array_push($sarray, [
                'title' => $result->supplier_name . '-(' . $result->item_name . ':' . $result->item_quantity . ')',
                'start' => date("Y-m-d", strtotime($result->sstart)),
                'end' => date("Y-m-d", strtotime($result->send)),
            ]);
        }

        echo json_encode($sarray);
    }
}
