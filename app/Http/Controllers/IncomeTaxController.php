<?php

namespace App\Http\Controllers;

use App\IncomeTex;
use Illuminate\Http\Request;
use App;
use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\BillingRepository;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Traits\getLookupListByCodeCustomKey;
use App\Models\IncomeTaxSlab;
use App\Models\IncomeTaxCale;
use Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;
use PDO;
use \PDF;
use PhpParser\Node\Stmt\TryCatch;
use Session;
class IncomeTaxController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $salary_breakdown = $this->getLookupListByCodeCustomKey("lookupdata_code", "GENDER");
        $salary_breakdown = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYBREAKDOWN");
        // dd($salary_breakdown);
        return Template::loadview("admin.settings.income_tax.income_tax_cale",['salary_breakdown'=>$salary_breakdown]);
    }

    public function incomeTaxCale(Request $request){
        $table = 'acc_incometax_calc';
        // Table's primary key
        $primaryKey = 'incometax_calc_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "";

        $columns = array(
            array('db' => 'incometax_calc_no_pk', 'dt' => 0),
            array('db' => 'incometax_calc_code', 'dt' => 1),
            array('db' => 'payroll_breakdown_code', 'dt' => 2),
            array('db' => 'payroll_breakdown_desc', 'dt' => 3),
            array('db' => 'percent_of_gross', 'dt' => 4),
            array('db' => 'taxableincome_percent', 'dt' => 5),
            array('db' => 'taxableincome_loweramount', 'dt' => 6),
            array('db' => 'active_status', 'dt' => 7),

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function incomeTaxSlab(Request $request){
        $table = 'acc_incometax_slab';
        // Table's primary key
        $primaryKey = 'incometax_slab_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "";

        $columns = array(
            array('db' => 'incometax_slab_no_pk', 'dt' => 0),
            array('db' => 'incometax_slab_code', 'dt' => 1),
            array('db' => 'payroll_breakdown_code', 'dt' => 2),
            array('db' => 'payroll_breakdown_desc', 'dt' => 3),
            array('db' => 'person_type', 'dt' => 4),
            array('db' => 'income_start_amt', 'dt' => 5),
            array('db' => 'income_end_amt', 'dt' => 6),
            array('db' => 'taxpercent', 'dt' => 7),
            array('db' => 'active_status', 'dt' => 8),

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id="")
    {
        $incomeTaxSlab = IncomeTaxSlab::where('incometax_slab_no_pk', $id
        )->first();

        // dd( $incomeTaxSlab);
        // $category = $this->getLookupListByCode("ROOMCAT");
        return Template::loadview("admin.settings.income_tax.create_income_tax_slab", [
            // 'category'  =>  $category,
            // 'service_unit'  =>  $service_unit
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try {
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        $date=date('Y-m-d');
        $sequence = DB::getSequence();
        $incometax_calc_no_pk_seq = $sequence->nextValue('incometax_calc_no_pk_seq');
        $data=[

             'incometax_calc_no_pk' =>   $incometax_calc_no_pk_seq,
             'incometax_calc_code' =>   $incometax_calc_no_pk_seq,
              'payroll_breakdown_code' => $request->payroll_breakdown_code,
               'payroll_breakdown_desc' => $request->payroll_breakdown_code,
               'percent_of_gross' => $request->percent_of_gross,
               'taxableincome_percent' => $request->taxableincome_percent ,
                'taxableincome_loweramount' =>$request->taxableincome_loweramount ,
                 'active_status' => $request->active_status,
                  'status' => 1 ,
                   'au_entry_by' => $auth_id,
                    'au_entry_at' => $date,
                    'au_entry_session' => 'session',
                     'au_entry_hospital_pk_no' =>$hospital_no_pk
        ];
        // dd($data);
        IncomeTaxCale::insert( $data);
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
     * @param  \App\IncomeTex  $incomeTex
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeTex $incomeTex)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncomeTex  $incomeTex
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeTex $incomeTex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncomeTex  $incomeTex
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomeTex $incomeTex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncomeTex  $incomeTex
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeTex $incomeTex)
    {
        //
    }
}
