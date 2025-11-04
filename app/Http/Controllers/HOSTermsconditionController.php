<?php

namespace App\Http\Controllers;

use DB;
use App;

use Carbon\Carbon;
use App\Models\Item;
use App\Traits\ItemData;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Datatables\DataTableClass;
use App\Models\UomLookup as Lookup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BaseRepository as Repo;

class HOSTermsconditionController extends Controller
{
    use LookupData, ItemData, UtilitiesTrait;

    protected $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->middleware('auth');

        $this->itemModel = new Repo($item);
    }

    public function index()
    {
        $grn = $this->getLookupListByCode("GRNTYPE");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->orderBy('supplier_name', 'asc')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        return Template::loadView("admin.uhl.inventory.item-receive-grn", [
            'grn_list' => $grn,
            'suppiler_arr' => $suppiler_arr,
            'main_store_list' => $main_store_list
        ]);
    }

    public function create() {
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $po_master_info =[];
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();


        return Template::loadView("admin.uhl.inventory.po-terms-condition", ['main_store_list' => $main_store_list, 'supplier_arr' => $supplier_arr, 'po_master_info'=>$po_master_info]);
    }


    public function store(Request $request) {

        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            //dd(json_decode($request->po_terms)[0]->store_su_no_fk);

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            foreach(json_decode($request->po_terms) as $term) {
            $termscon_no_pk = $sequence->nextValue('termscon_no_pk_seq');
                    DB::table("sysc_termscondition")
                    ->insert([
                        'termscon_no_pk' => $termscon_no_pk,
                        'store_su_no_fk' => intval($term->store_su_no_fk),
                        'supplier_no_fk' => intval($term->supplier_no_fk),
                        'header_sl' => intval($term->header_sl),
                        'termscon_header' => $term->termscon_header,
                        'terms_sl' => intval($term->terms_sl),
                        'termscon_text1' => $term->termscon_text1,
                        'store_default_ind' => $term->store_default_ind,
                        'default_terms_ind' => $term->default_terms_ind,
                        'status' => intval($term->status),
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no
                    ]);
            }

            DB::commit();

            $this->message = ['msg' => 'Data saved successfully', 'title' => 'Success'];

        } catch(\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];


        }

        return response()->json($this->message);
    }

    public function edit($id)
    {
         $po_term_condition_id = $id;
         $terms_conditions = DB::table('sysc_termscondition')
            ->select('*')
            ->where('termscon_no_pk', $po_term_condition_id)
            ->first();

         $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $po_master_info =[];
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        return Template::loadView("admin.uhl.inventory.edit-po-terms-conditions", ['terms_conditions' => $terms_conditions,'main_store_list' => $main_store_list, 'supplier_arr' => $supplier_arr, 'po_master_info'=>$po_master_info]);
    }
    public function update(Request $request)
    {
        $po_id = $request->po_id;
        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $entry_session = Session()->get('user.ses_user_pk_no');
     
     
        // try {
            DB::beginTransaction();
            $sequence = DB::getSequence();

            $approval_matrix_mst = DB::table('sysc_termscondition')
            ->where('termscon_no_pk', $po_id)
            ->update(
                [
                    'store_su_no_fk' => $request->po_store ? $request->po_store : 0,
                    'supplier_no_fk' => $request->po_supplier ? $request->po_supplier : 0,
                    'termscon_header' => $request->terms_header ? $request->terms_header : "",
                    'terms_sl' => $request->terms_condition_serial ? $request->terms_condition_serial : 0,
                    'termscon_text1' => $request->terms_condition ? $request->terms_condition : "",
                    'header_sl' => $request->header_serial ? $request->header_serial : 0,
                    'store_default_ind' => isset($request->isDefault) ? $request->isDefault : 0,
                    'default_terms_ind' => isset($request->default_terms_ind) ? $request->default_terms_ind : 0,
                    'status' =>isset($request->isStatus) ? $request->isStatus : 0,
                    'au_update_at' => $au_entry_at,
                    'au_update_by' => Auth::id(),
                    'au_update_session' => $entry_session,
                ]
            );
                $message = ['msg' => 'Data updated successfully', 'title' => 'Success'];
                DB::commit();
                return response()->json($message);

            // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
            // } catch (\Exception $e) {
            //     $message = ['msg' => ' Failled.', 'title' => 'Error'];
            //     DB::rollback();
            //     return response()->json($message);
            // }
    }


    public function po_terms_conditions_worklist()
    {
        $supplier_arr = DB::table('INV_SUPPLIER')
                            ->select('*')
                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                            ->orderByRaw("lower(supplier_name) asc")
                            ->get();



        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $po_terms_worklist = DB::table('sysc_termscondition_vw')
                            ->select('*')
                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                            ->whereNotNull('termscon_header')
                            // ->orderByRaw('lower(store_name) asc')
                            ->orderByRaw('default_terms_ind asc')
                            ->orderBy('header_sl', 'asc')
                            ->orderBy('terms_sl', 'asc')
                            ->get();

        return Template::loadview("admin.uhl.inventory.po-terms-conditions-worklist",
            [
                'po_terms_worklist' => $po_terms_worklist,
                'supplier_arr' => $supplier_arr,
                'main_store_list' => $main_store_list
            ]
        );
    }

    public function search_grn_worklist(Request $request)
    {
        $supplier_cnd =  isset($request->supplier_id) ? "and supplier_no_fk  =  " . $request->supplier_id : '';
        $challan_no_cnd =  isset($request->challan_no) ? "and  po_no=  " . $request->challan_no : '';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $grn_worklists = DB::select("select itemreceive_no_pk,po_no,challan_date,supplier_name,count(item_no_fk) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
            from phr_v1_grn_vw
        where au_entry_hospital_no_fk = $hospital_id  $supplier_cnd   $challan_no_cnd
        group by itemreceive_no_pk,po_no,challan_date,supplier_name
        order by challan_date desc,po_no desc
       ");


        return Template::loadview("admin.uhl.inventory.grn.inventory-grn-worklist-table", compact('grn_worklists'));
    }

    public function trash($id)
    {

        DB::beginTransaction();
        try {
            DB::table('sysc_termscondition')->where("termscon_no_pk", $id)->delete();
            DB::commit();
            $message = ['msg' => 'Data deleted successfully', 'title' => 'Success'];
            return response()->json($message);
        } catch (\Exception $e) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
            return response()->json($message);
        }
    }

    public function poTremsSearch(Request $request)
    {
        $po_store = $request->po_store;
        $po_supplier = $request->po_supplier;
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $po_store_con = ($request->po_store != "") ? " and store_su_no_fk = $po_store" : "";
        $po_supplier_con = ($request->po_supplier != "") ? " and supplier_no_fk = $po_supplier" : "";

        $po_terms_worklist = DB::select("select * from sysc_termscondition_vw where au_entry_hospital_pk_no= $ses_hospital_no_pk $po_store_con $po_supplier_con");

        return Template::loadview("admin.uhl.inventory.po_terms_table_list", ['po_terms_worklist' => $po_terms_worklist]);
    }
}
