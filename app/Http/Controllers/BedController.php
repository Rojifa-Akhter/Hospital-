<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Models\ServiceUnit;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Item;
use Session;

class BedController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Bed $bed, Item $item)
    {
        $this->middleware('auth');
        $this->model_bed = new Repo($bed);
        $this->model_item = new Repo($item);
    }

    public function index()
    {
        // $destinationWards = DB::select(" select * from sysc_serviceunit left join ipds_ward on sysc_serviceunit.serviceunit_no_pk = ipds_ward.service_unit_no_fk where serviceunit_no_pk = $request->ward_data");

        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $ward = Ward::select('ward_no_pk', 'ward_name')->where('status',1)->get();
        $bed_cat = $this->getLookupListByCode("BED");
        $bed_status_list = DB::table('ipds_bed')->select('bed_no_pk', 'bed_status')->where('status', 1)->get()->toArray();
        return Template::loadview("admin.settings.bed.bed_list", ['bed_status_list' => $bed_status_list, 'requestDepts' => $requestDepts, 'destinationWards' => $ward, 'bed_cat' => $bed_cat]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $ward = Ward::select('ward_no_pk', 'ward_name')->where('status',1)->get();
        $bed_charge = DB::select("select 'itemtype_no_pk','item_type_name' from SYSC_ITEMTYPE");
        //        $service =
        $service = ServiceUnit::where('ipd_ind', 1)->where('status', 1)->get();
        $bed_cat = $this->getLookupListByCode("BED");
        $service_item = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name', 'sales_price')->where(DB::raw('UPPER(item_type)'), 'BED')->where('status', 1)->get();
        return Template::loadview("admin.settings.bed.create_bed_form", [
            'ward' => $ward,
            'service' => $service,
            'bed_cat' => $bed_cat,
            'service_item' => $service_item
        ]);
    }
    public function create_form()
    {
        $ward = Ward::select('ward_no_pk', 'ward_name')->where('status',1)->get();
        $service = ServiceUnit::where('ipd_ind', 1)->where('status', 1)->get();
        $service_item = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name', 'sales_price')->where('item_type', 'BED')->where('status', 1)->get();
        $bed_cat = $this->getLookupListByCode("BED");
        return Template::loadview("admin.settings.bed.create_bed", [
            'ward' => $ward,
            'service' => $service,
            'bed_cat' => $bed_cat,
            'service_item' => $service_item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function userBedSetup()
    {
        //return Template::loadview("admin.settings.bed.user_bed_setup");

    }
    public function getAllBedSetup(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'serviceunit_name',
            'bed_uid',
            'bed_name',
            'ward_name',
            'admission_fee_item_no_fk',
            'bed_charge_amount',
            'service_charge_item_no_fk',
            'others_charge_item_no_fk',
            'minimum_deposit_amount',
            'remarks',
            'authorized_bed_ind',
            'bed_status',
            'bed_sl_no',
            'bed_no_pk'
        );

        $active = '<span class="badge badge-primary">Yes</span';
        $inactive = '<span class="badge badge-danger">No</span';

        $sql = "select '' as sl, s.serviceunit_name, b.bed_uid, b.bed_name,b.bed_sl_no,w.ward_name,b.admission_fee_item_no_fk,
                b.bed_charge_amount,b.service_charge_item_no_fk,b.others_charge_item_no_fk,b.minimum_deposit_amount,b.remarks,
                case b.bed_status when 1 then 'Available' when 2 then 'Occupied' else 'Not Ready' end bed_status,case b.authorized_bed_ind when 1 then '$active' else '$inactive' end authorized_bed_ind,

                 b.bed_no_pk, rownum rownumber, b.au_update_at, b.au_entry_at

                 from ipds_bed b left join ipds_ward w on w.ward_no_pk = b.ward_no_fk
                 left join sysc_serviceunit s
                 on s.serviceunit_no_pk = b.su_no_fk WHERE b.status = 1";
                //  WHERE b.au_entry_hospital_no_fk = $ses_hospital_id;
        $order_by_column = "bed_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }



    public function storeBed(Request $request)
    {
        $id = $request->id;
        $item_id = $request->service_id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $bed =

            DB::beginTransaction();
        try {
            // $service = [
            //     'itemtype_no_fk' => '1162',
            //     'item_type' => 'BED',
            //     'item_code' => $request->bed_uid,
            //     'item_name' => $request->bed_name,
            //     'serviceunit_no_fk' => $request->su_name,
            //     'sales_price' => $request->bed_charge
            // ];

            $service_item = DB::table('sysc_serviceitem')->orderBy('item_no_pk', 'desc')->first();
            $data = [
                'bed_uid' => $request->bed_uid,
                'bed_name' => $request->bed_name,
                'bed_sl_no' => $request->bed_sl_no,
                'bed_status' => $request->bed_status,
                'ward_no_fk' => $request->ward_no_fk,
                'su_no_fk' => $request->su_name,
                'admission_fee_item_no_fk' => $request->admission_fee,
                'bed_charge_item_no_fk' => $request->item_name,
                'bed_charge_amount' => $request->bed_charge,
                'service_charge_item_no_fk' => $request->service_charge,
                'others_charge_item_no_fk' => $request->other_charge,
                'minimum_deposit_amount' => $request->m_d_ammount,
                'remarks' => $request->remark,
                'status' => $request->status,
                'authorized_bed_ind' => $request->active_beds,
                'au_entry_hospital_no_fk' =>  $ses_hospital_id,
            ];
            // dd($data);
            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_bed->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_bed->update($data, $id);
            }


            // if ($item_id == "") {

            //     $data['au_entry_by'] = $auth_id;
            //     $this->model_item->create($service);
            // } else {
            //     // AU_UPDATE_BY
            //     $data['au_update_by'] = $auth_id;
            //     $this->model_item->update($service, $item_id);
            // }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function editBedSetup($id)
    {

        $ward = Ward::select('ward_no_pk', 'ward_name')->get();
        $service = ServiceUnit::where('ipd_ind', 1)->where('status', 1)->get();
        $bed_cat = $this->getLookupListByCode("BED");
        $data = $this->model_bed->show($id,);
        $item_data = Db::select(Db::raw("select s.item_no_pk from ipds_bed b
        left join sysc_serviceitem s
        on b.bed_charge_item_no_fk = s.item_no_pk
        where b.bed_no_pk = '$id'"));
        $item = DB::table('ipds_bed b')->join('sysc_serviceitem s', 'b.bed_charge_item_no_fk', 's.item_no_pk')->where('b.bed_no_pk', $id)->first();
        $service_item = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name', 'sales_price')->where(DB::raw('UPPER(item_type)'), 'BED')->where('status', 1)->get();
        
        return Template::loadview("admin.settings.bed.create_bed_form", [
            'bed' => $data,
            'ward' => $ward,
            'service' => $service,
            'bed_cat' => $bed_cat,
            'item_data' => $item_data,
            'item' => $item,
            'service_item' => $service_item,
        ]);
    }

    public function searchStatus(Request $request)
    {
        $bed_type = $request->bed_type;
        $request_department = $request->request_department;
        $destination_ward = $request->destination_ward;
        $destination_bed = $request->destination_bed;
        $sql_cond = "";
        $sql_cond .= !empty($bed_type) ? " and bed_status = $bed_type" : "";
        $sql_cond .= !empty($request_department) ? " and su_no_fk = $request_department" : "";
        $sql_cond .= !empty($destination_ward) ? " and ward_no_fk = $destination_ward" : "";
        $sql_cond .= !empty($destination_bed) ? " and bed_no_pk = $destination_bed" : "";

        $sql = "select '' as sl,
            s.serviceunit_name,
            b.bed_uid,
            b.bed_name,
            b.bed_sl_no,
            w.ward_name,
            b.admission_fee_item_no_fk,
            b.bed_charge_amount,
            b.service_charge_item_no_fk,
            b.others_charge_item_no_fk,
            b.minimum_deposit_amount,
            b.remarks,
            case b.bed_status when 1 then 'Available' when 2 then 'Occupied' else 'Not Ready' end bed_status, 
            authorized_bed_ind,
            b.bed_no_pk,
            rownum rownumber,
            b.au_update_at,
            b.au_entry_at
            from ipds_bed b left join ipds_ward w on w.ward_no_pk = b.ward_no_fk
            left join sysc_serviceunit s on s.serviceunit_no_pk = b.su_no_fk 
            WHERE b.status = 1 $sql_cond";
        return response()->json(['data' => DB::select($sql),'success' => true] ,200);
    }

    public function wardService(Request $request)
    {
        $destinationWards = DB::select(" select * from sysc_serviceunit left join ipds_ward on sysc_serviceunit.serviceunit_no_pk = ipds_ward.service_unit_no_fk where serviceunit_no_pk = $request->dept");
        return Template::loadview("admin.settings.bed.ward", ['ward' => $destinationWards]);
    }
}
