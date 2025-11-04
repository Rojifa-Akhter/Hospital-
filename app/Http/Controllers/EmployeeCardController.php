<?php

namespace App\Http\Controllers;
use App\Library\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\LookupData;
use App\Traits\ItemData;
use App\Traits\DoctorData;
use App\Traits\DatatablesLoader;
use App\Models\Doctor;
use App\Models\EmployeeCard;
use App\Models\ServiceUnit;
use App\Http\Requests\DoctorRequest;
use App\Repositories\BaseRepository AS Repo;
use App\Repositories\DoctorRepository;
use App\Models\Item;
use App\Models\DoctorFee;
use DB;
use Auth;
use Session;

class EmployeeCardController extends Controller
{
    use LookupData, DatatablesLoader, ItemData, DoctorData;
	protected $model, $model2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeCard $EmployeeCard, Doctor $Doctor)
    {
    	$this->middleware('auth');
    	$this->model = new Repo($EmployeeCard);
    	$this->model2 = new Repo($Doctor);

    }

    public function index()
    {
    	return Template::loadview("admin.settings.employee_card.employee_card_list");
    }
    public function employeeCardIssue($id)
    {
        // dd($id);
        // $cardId=$this->model->show($id);
        $cardId=DB::table('hrms_personnel')->select("person_code", "card_no", "full_name", "phone_mobile", "join_date", "person_no_pk", "au_update_at", "au_entry_at")->where('person_no_pk', $id)->get()->first();
        // dd($cardId);
        // $Card=DB::table('hrms_card')->select('card_no_pk','card_number')->get();

    	return Template::loadview("admin.settings.employee_card.employee_card_issue",['cardId'=>$cardId]);
    }

    public function store(Request $request)
    {

        // return $request;
        $id = $request->id;

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'card_number' => $request->employee_card,
                'au_entry_session' => '1',
                'au_entry_hospital_pk_no' => 1,
                'status' => 1,

            ];

            if($id == null || $id == "")
            {
                // dd($data);
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
    public function issueCardStore(Request $request)
    {

        // return $request;
        $id = $request->id;

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'card_no' => $request->card_number,
            ];

            if($id == null || $id == "")
            {
                // dd($data);
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $this->model2->create($data);
                // return $res;

            }
            else
            {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
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

    public function getAllCardNumber(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
             'sl',
             'card_number',
             'card_no_pk'
        );

        $sql = "SELECT '' as sl, card_number, card_no_pk, rownum rownumber, au_update_at, au_entry_at from hrms_card where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "card_no_pk";

        $json_data = $this->datatable( $request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);

    }
    public function getAllEmployeeList(Request $request)
    {
        $sql = DB::table('hrms_personnel')->select("hrms_personnel.person_code", "sysc_serviceunit.serviceunit_name", "hrms_personnel.full_name", "hrms_personnel.phone_mobile", "hrms_personnel.join_date", "hrms_personnel.person_no_pk", "hrms_personnel.au_update_at", "hrms_personnel.au_entry_at")->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk' ,'=', 'hrms_personnel.serviceunit_no_fk')->where("hrms_personnel.person_code", $request->employee_code)->orWhere ("hrms_personnel.full_name", $request->employee_code)->orWhere("sysc_serviceunit.serviceunit_name", $request->employee_code)->get();
        // dd($sql);

        return Template::loadview("admin.settings.employee_card.employee-list",['sql'=>$sql,"hhhhh"=>$request->employee_code]);
    }
}
