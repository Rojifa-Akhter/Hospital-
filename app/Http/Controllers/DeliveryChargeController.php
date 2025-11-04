<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use DB;
use Session;
use Auth;
use App\Models\DeliveryCharge;
use App\Repositories\BaseRepository;
class DeliveryChargeController extends Controller
{
    private $model;
    public function __construct(DeliveryCharge $model)
    {
        $this->middleware('auth');
        $this->model = new BaseRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_charges = DB::table('ecom_delivery_charge')->select('delivery_charge_no_pk','delivery_charge_type','delivery_charge')->get();
        return Template::loadview("admin.settings.delivery_charge.delivery_charge_list", compact('delivery_charges'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.delivery_charge.create_delivery_charge");
    }
    public function getDeliveryChargeForm()
    {
        return Template::loadview("admin.settings.delivery_charge.create_delivery_charge_form");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $request->validate([
            'delivery_charge_type'=>'required',
            'charge'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try{
            $sequence = DB::getSequence();
            $delivery_charge_no_pk_seq = $sequence->nextValue('delivery_charge_no_pk_seq');
            $delivery_charge_info = [];
            $delivery_charge_info = [
                'delivery_charge_no_pk' => $delivery_charge_no_pk_seq,
                'delivery_charge_type' => $request->delivery_charge_type,
                'delivery_charge' => $request->charge,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            if($id == null || $id == "")
            {
                // AU_ENTRY_BY
                $delivery_charge_info['au_entry_by'] = $auth_id;
                $this->model->insert($delivery_charge_info);
                // return $res;
            }
            else
            {
              // AU_UPDATE_BY
                $delivery_charge_info['au_update_by'] = $auth_id;
                DB::table('ecom_delivery_charge')->where('delivery_charge_no_pk',$id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->update($delivery_charge_info);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        }
        catch (\Exception $e)
        {
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
        $delivery_charge = DB::table('ecom_delivery_charge')->where('delivery_charge_no_pk', $id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->first();
        return Template::loadview("admin.settings.delivery_charge.create_delivery_charge_form", compact('delivery_charge'));

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
}
