<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\Loan;
use Auth;
use DB;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository AS Repo;


class LoanController extends Controller
{

    use DatatablesLoader;
     protected $model;
     public function __construct(Loan $loan)
    {
        $this->middleware('auth');

        $this->model = new Repo($loan);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return Template::loadview("admin.settings.loan.loan_list");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.loan.create_loan");
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
        $hostpital = 1;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'person_no_pk'           => $request->hdn_item_item_id_0,
                'original_amount'        => $request->original_amount,
                'interest_perc'          => $request->interest,
                'loan_amount'            => $request->loan_amount,
                'installment_no'         => $request->no_of_installment,
                'installment_amount'     => $request->installment,
                'installment_date'       => date("Y-m-d",strtotime($request->date)),
                'au_entry_session'       =>'session',
                'au_entry_hospital_pk_no'=>$hostpital,
            ];

            if($id == "")
            {

                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $this->model->create($data);
                // return $res;

            }
            else
            {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
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
        
        $loan = DB::table("hrms_loan a")
                ->join("hrms_personnel b","a.person_no_pk","b.person_no_pk")
                ->select('a.person_no_pk','b.full_name','a.original_amount','a.interest_perc','a.loan_amount','a.installment_no','a.installment_amount','a.installment_date','a.loan_no_pk')
                ->where('a.loan_no_pk',$id)
                ->get()->first();
        return Template::loadview("admin.settings.loan.create_loan_form",['loan'  =>  $loan]);
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
    public function create_form()
    {
        //
     
        return Template::loadview("admin.settings.loan.create_loan_form");
    }
    public function getAllLoan(Request $request){
        $columns = array(
            'sl',
            'person_code',
            'full_name',
            'su_name',
            'original_amount',
            'loan_amount',
            'interest_perc',
            'installment_no',
            'installment_amount',
            'loan_no_pk',
        );

        $sql = "select '' as sl,b.person_code, b.full_name ,b.su_name,a.original_amount,a.loan_amount,a.interest_perc,a.installment_no,a.installment_amount,a.loan_no_pk,rownum rownumber, a.au_update_at, a.au_entry_at from hrms_loan a join employee_info_vw b on b.person_no_pk = a.person_no_pk";
        $order_by_column = "loan_no_pk";

        $json_data = $this->datatable( $request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);

    }
}
