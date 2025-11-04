<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Library\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BankWiseService;
use App\Traits\DatatablesLoader;

use App\Repositories\BaseRepository as Repo;

class BankWiseController extends Controller
{
   use DatatablesLoader, LookupData;
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(BankWiseService $BankWiseService)
    {
        $this->middleware('auth');
        $this->model_bank_charge = new Repo($BankWiseService);
    }



    public function bankWiseCharge(){
    	return template::loadview('admin.settings.card_service.create_bank_service');
    }


    public function bankServiceChargeList(){
    	$card_type = $this->getLookupListByCode('CARDTYPE');
    	$bank = $this->getLookupListByCode('BANK');

    	return template::loadview('admin.settings.card_service.bank_service_charge_list',[
    		'card_type' => $card_type,
    		'bank' => $bank
    	]);
    }

    public function bankWiseChargeStore(Request $request)
    {
    	$id = $request->id;
    	$auth_id = Auth::id();

    	DB::beginTransaction();
    	try {
    		$data = [
    			'bank_charge_code' => $request->bank_code,
    			'card_type' => $request->card_type,
    			'service_charge_percent' => $request->service_charge,
    			'bank_no_fk' => $request->bank_name,
    		];

    		if ($id == "") {

    			$data['au_entry_by'] = $auth_id;
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



    public function getAllbankWiseCharge(Request $request)
    {
        $table = 'finc_bankcard_charge';
        // Table's primary key
        $primaryKey = 'bank_charge_no_pk';

        $columns = array(
            array( 'db' => 'rownum', 'dt' => 0 ),
            array( 'db' => 'bank_charge_code', 'dt' => 1 ),
            array( 'db' => 'card_type',  'dt' => 2 ),
            array( 'db' => 'service_charge_percent',   'dt' => 3 ),
            array( 'db' => 'bank_no_fk',   'dt' => 4 ),
            array( 'db' => 'bank_charge_no_pk',   'dt' => 5 ),
        );
        echo json_encode(DataTableClass::simple( $request, $table, $primaryKey, $columns));

//    	$columns = array(
//    		'sl',
//    		'bank_charge_code',
//    		'card_type',
//    		'service_charge_percent',
//    		'bank_no_fk',
//    		'bank_charge_no_pk'
//    	);
//
//    	$sql = "select '' sl,
//    	bank_charge_code,
//    	bank_no_fk,
//    	card_type,
//    	service_charge_percent,bank_charge_no_pk,rownum rownumber,  au_update_at,au_entry_at from finc_bankcard_charge";
//    	$order_by_column = "bank_charge_no_pk";
//
//    	$json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);
//
//    	echo json_encode($json_data);

    }





}
