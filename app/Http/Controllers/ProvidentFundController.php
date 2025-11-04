<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProvidentFund;
use App\Library\Template;
use Auth;
use DB;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Session;
use App\Repositories\BaseRepository as Repo;

class ProvidentFundController extends Controller
{

    use LookupData, DatatablesLoader;

    public function __construct(ProvidentFund $ProvidentFund)
    {
        $this->middleware('auth');

        $this->model = new Repo($ProvidentFund);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return template::loadview('admin.settings.provident_fund.all_provident_fund');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provident_fund = $this->getLookupListByCode("PROVIDENT FUND");

        return template::loadview('admin.settings.provident_fund.add_provident_fund', ['provident_fund' => $provident_fund]);
    }
    public function popUpCreate()
    {
        $provident_fund = $this->getLookupListByCode("PROVIDENT FUND");
        // dd($provident_fund);
        return template::loadview('admin.settings.provident_fund.add_provident_fund_form', ['provident_fund' => $provident_fund]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'pf_bank_name' => $request->bank_name,
                'pf_amount_type' => $request->amount_type,
                'pf_bank_account' => $request->bank_Account,
                'pf_loan_percent' => $request->loan_percent,
                'COMP_VALUE_PERCENT' => $request->comp_value_amount,

                'value_percent' => $request->value_percent,
                'comp_payment_amount' => $request->Company_payment_amount,
                'fixed_amount' => $request->fixed_amount,
                'effective_date' => $request->effective_date,


                'status' => $request->grade_status ? 1 : null,
                'au_sync_hospital_pk_no' => $ses_hospital_id,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                'au_entry_session' => 1,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model->create($data);
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
    public function getAllProvidentFund(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'pf_bank_name',
            'pf_amount_type',
            'pf_bank_account',
            'pf_loan_percent',
            'value_amount',
            'value_percent',

            'pf_no_pk',
            'effective_date',

        );

        $sql = "SELECT '' as sl,pf_bank_name,  pf_amount_type,pf_bank_account,pf_loan_percent,value_amount,value_percent,pf_no_pk, effective_date,rownum rownumber, au_update_at,au_entry_at from hrms_provident_fund_setup where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";

        $order_by_column = "pf_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);


        echo json_encode($json_data);
    }

    public function editProvidentFundList($id)
    {


        $provident_fund_data = $this->model->show($id);
        $provident_fund = $this->getLookupListByCode("PROVIDENT FUND");
        return template::loadview('admin.settings.provident_fund.add_provident_fund_form', ['provident_fund_data' => $provident_fund_data, 'provident_fund' => $provident_fund]);
    }
}