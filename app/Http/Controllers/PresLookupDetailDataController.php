<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use Auth;
use DB;
use App\Models\PrescriptionLookup;
use App\Models\ServiceUnit;
use Session;
use App\Http\Requests\PresLookupDetailDataRequest;
use Carbon\Carbon;
use App\Models\PresLookupDetailData;
use App\Models\PrescriptionLookupItem;
use App\Repositories\BaseRepository;

class PresLookupDetailDataController extends Controller
{
    private $pressLookupDetailData;
    public function __construct(PresLookupDetailData $presLookupDetailData)
    {
        $this->middleware('auth');
        $this->model = new BaseRepository($presLookupDetailData);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $presLookupDetailData = DB::table('pres_lookupdata_dtl1')
            ->leftJoin('sysc_serviceunit', 'pres_lookupdata_dtl1.su_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->leftJoin('pres_lookupdata', 'pres_lookupdata_dtl1.psn_lookupdata_no_fk', '=', 'pres_lookupdata.pres_lookupdata_no_pk')
            ->select(
                'pres_lookupdata_dtl1.detail_name as detailData',
                'pres_lookupdata_dtl1.input_type as type',
                'pres_lookupdata_dtl1.status as status',
                'pres_lookupdata.pres_lookupdata_name as lookupData',
                'sysc_serviceunit.serviceunit_name as department',
                'pres_lookupdata_dtl1.pres_lookupdatadtl1_no_pk as id'
            )
            ->where("pres_lookupdata_dtl1.au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->get();
        return Template::loadview("admin.settings.pres_lookup.pres_lookup_data_list", ['presLookupDetailData' => $presLookupDetailData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $presLookupDetailData = [];
        $serviceUnit = ServiceUnit::where('status', 1)->get();
        $lookup = PrescriptionLookup::all();
        return Template::loadview("admin.settings.pres_lookup.create_pres_lookup", [
            'lookup' => $lookup,
            'serviceUnit'  => $serviceUnit,
            'presLookupDetailData' => $presLookupDetailData
        ]);
    }

    public function create_form()
    {
        $presLookupDetailData = [];
        $serviceUnit = ServiceUnit::where('status', 1)->get();
        $lookup = PrescriptionLookup::all();
        return Template::loadview("admin.settings.pres_lookup.create_pres_lookup_form", [
            'lookup' => $lookup,
            'serviceUnit'  => $serviceUnit,
            'presLookupDetailData' => $presLookupDetailData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresLookupDetailDataRequest $request)
    {
        $id = $request->id;

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $pres_lookup_no_pk_seq = $sequence->nextValue('seq_pres_lookupdatadtl1_no_pk');
            $presLookup = [];
            $presLookup = [
                'pres_lookupdatadtl1_no_pk' => $pres_lookup_no_pk_seq,
                'psn_lookupdata_no_fk' => $request->lookup_data,
                'su_no_fk' => $request->department,
                'detail_name' => $request->detail_data,
                'input_type' => $request->type,
                'status' => $request->status,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital'

            ];
            if ($id == null || $id == "") {

                // AU_ENTRY_BY
                $presLookup['au_entry_by'] = $auth_id;

                $this->model->insert($presLookup);
                // return $res;

            } else {

                // AU_UPDATE_BY
                $presLookup['au_update_by'] = $auth_id;
                DB::table('pres_lookupdata_dtl1')->where('pres_lookupdatadtl1_no_pk', $id)->update($presLookup);

                // $this->model->update($presLookup, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $presLookupDetailData = DB::table('pres_lookup')
            ->leftJoin('pres_lookupdata', 'pres_lookup.pres_lookup_no_pk', '=', 'pres_lookupdata.pres_lookup_no_fk')
            ->leftJoin(
                'pres_lookupdata_dtl1',
                'pres_lookupdata.pres_lookupdata_no_pk',
                '=',
                'pres_lookupdata_dtl1.psn_lookupdata_no_fk'
            )
            ->select(
                'pres_lookupdata_dtl1.pres_lookupdatadtl1_no_pk as pres_lookupdatadtl1_no_pk',
                'pres_lookupdata_dtl1.detail_name as detailData',
                'pres_lookupdata_dtl1.input_type as type',
                'pres_lookupdata_dtl1.status as status',
                'pres_lookupdata_dtl1.su_no_fk as department',
                'pres_lookup.pres_lookup_no_pk as lookupcodeid',
                'pres_lookupdata.pres_lookupdata_no_pk as lookupdataid'
            )->where('pres_lookupdatadtl1_no_pk', $id)->first();

        $presLookupData = PrescriptionLookupItem::where('pres_lookup_no_fk', $presLookupDetailData->lookupcodeid)->get();
        $serviceUnit = ServiceUnit::where('status', 1)->get();
        $lookup = prescriptionlookup::all();
        return Template::loadview("admin.settings.pres_lookup.create_pres_lookup_form", [
            'lookup' => $lookup,
            'serviceUnit'  => $serviceUnit,
            'presLookupDetailData' => $presLookupDetailData,
            'presLookupData' => $presLookupData
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

    public function getLookupCodeId(Request $request)
    {
        $lookupCodeId = $request->lookupCodeId;
        $presLookupData = PrescriptionLookupItem::where('pres_lookup_no_fk', $lookupCodeId)->get();
        $lookupDataId = '';
        return Template::loadview('admin.settings.pres_lookup.pres_lookup_data_dropdown', ['presLookupData' => $presLookupData, 'lookupDataId' => $lookupDataId]);
    }
}