<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use DB;
use Session;
use Auth;
use App\Models\IncomeTax;
use App\Repositories\BaseRepository;



class IncomeTaxSetupController extends Controller
{
    private $model;
    public function __construct(IncomeTax $model)
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $income_setup_info = '';
        $income_setup_info = DB::table('income_tax_setup')->get();
       // dd($income_setup_info);
        return Template::loadview("admin.settings.income_tax_setup.create_income_tax_setup",compact('income_setup_info'));
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
        $id = $request->income_tax_id;
        $auth_id = Auth::id();
        $request->validate([
            'tax_description'=>'required',
            'tax_fee_amount'=>'required',
            'min_tax_percent'=>'required',
            'rem_next_one_lac'=>'required',
            'rem_next_one_lac_percent'=>'required',
            'rem_next_three_lac'=>'required',
            'rem_next_three_lac_percent'=>'required',
            'rem_next_four_lac'=>'required',
            'rem_next_four_lac_percent'=>'required',
            'rem_next_five_lac'=>'required',
            'rem_next_five_lac_percent'=>'required',
            'rem_next_everything_percent'=>'required',
        ]);
        DB::beginTransaction();
        try{
            $sequence = DB::getSequence();
            $income_tax_setup_no_pk_seq = $sequence->nextValue('income_tax_setup_no_pk_seq');
            $income_setup_info = [];
            $income_setup_info = [
                // 'delivery_charge_no_pk' => $delivery_charge_no_pk_seq,
                // 'delivery_charge_type' => $request->delivery_charge_type,
                // 'delivery_charge' => $request->charge,


                'income_tax_setup_no_pk'=>$income_tax_setup_no_pk_seq,
                'tax_description'=> $request->tax_description,
                'tax_fee_amount'=> $request->tax_fee_amount,
                'min_tax_percent'=> $request->min_tax_percent,
                'rem_next_one_lac'=> $request->rem_next_one_lac,
                'rem_next_one_lac_percent'=> $request->rem_next_one_lac_percent,
                'rem_next_three_lac'=> $request->rem_next_three_lac,
                'rem_next_three_lac_percent'=> $request->rem_next_three_lac_percent,
                'rem_next_four_lac'=> $request->rem_next_four_lac,
                'rem_next_four_lac_percent'=> $request->rem_next_four_lac_percent,
                'rem_next_five_lac'=> $request->rem_next_five_lac,
                'rem_next_five_lac_percent'=> $request->rem_next_five_lac_percent,
                'rem_next_everything_percent'=> $request->rem_next_everything_percent,
                'default_ind'=> $request->default_ind ?? 0,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
           //dd($income_setup_info);
            if($id == null || $id == "")
            {
                // AU_ENTRY_BY
                $income_setup_info['au_entry_by'] = $auth_id;
                $this->model->insert($income_setup_info);
                // return $res;
            }
            else
            {
              // AU_UPDATE_BY
                $income_setup_info['au_update_by'] = $auth_id;
                DB::table('income_tax_setup')->where('income_tax_setup_no_pk',$id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update($income_setup_info);
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
        // $income_setup_info_edit = '';
        $income_setup_info_edit = DB::table('income_tax_setup')->where('income_tax_setup_no_pk', $id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
      // dd($income_setup_info_edit);
        return Template::loadview("admin.settings.income_tax_setup.create_income_tax_setup_form",compact('income_setup_info_edit'));

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
