<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\Room;
use App\Models\ServiceUnit;
use Session;
use App\Models\SalaryAllowance;
use PDO;
class SalaryAllowanceController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(SalaryAllowance $SalaryAllowance)
    {
        $this->middleware('auth');

        $this->model = new Repo($SalaryAllowance);
    }
    public function index()
    {
        // return Template::loadview("admin.settings.salary.salary_allowance");
        return Template::loadview("admin.settings.salary.salary_allowance_list");
    }
    public function bonusEdit($id)
    {
        $bonus = $this->model->show($id);
        return Template::loadview("admin.settings.salary.salary_allowance", ['bonus' => $bonus]);
    }
    public function create()
    {
        // dd('tt');
        return Template::loadview("admin.settings.salary.salary_allowance");
        // return Template::loadview("admin.settings.salary.salary_allowance_list");
    }
    public function getSalaryList(Request $request)
    {
        // dd('ttt');
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'bonus_name',
            'bonus_amount_ind',
            'bonus_percent_ind',
            'callculate_on',
            'value_amount',
            'value_percent',
            'festival_bonus_ind',
            'effective_date',
            'bonus_no_pk',
        );

        $yes = '<span class="badge badge-md badge-secondary"> Yes</span>';
        $no = '<span class="badge badge-md badge-danger">No</span>';

        $sql = "SELECT '' as sl, bonus_name, bonus_amount_ind, bonus_percent_ind, callculate_on,
		 value_amount,  value_percent  ,case when festival_bonus_ind=1  then '$yes' else '$no' end as
		 festival_bonus_ind, to_char(effective_date,'DD-MM-YYYY') effective_date, bonus_no_pk, rownum rownumber,
		  au_update_at, au_entry_at from hrms_salary_bonus where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "bonus_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_form()
    {
        $service_unit = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $category = $this->getLookupListByCode("ROOMCAT");
        return Template::loadview("admin.settings.room.create_room_form", [
            'category'  =>  $category,
            'service_unit'  =>  $service_unit
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
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [

                'bonus_name'        => $request->bonus_name,
                'bonus_amount_ind'  => $request->bonus_amount_ind,
                'bonus_percent_ind' => $request->bonus_percent_ind,
                'callculate_on'     => $request->callculate_on,
                'value_amount'      => $request->value_amount,
                'value_percent'     => $request->value_percent,
                'festival_bonus_ind' => $request->festival_bonus_ind ? 1 : 0,
                'effective_date'    => date('Y/m/d', strtotime($request->effective_date)),
                'au_entry_session'  => 1,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,

            ];

            if ($id == "") {

                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $this->model->create($data);
                // return $res;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getServiceUnitInfoById($id)
    {
        return $id;
    }

    public function getAllRoom(Request $request)
    {
        $columns = array(
            'sl',
            'room_code',
            'room_name',
            'room_capacity',
            'room_size',
            'service_unit',
            'category',
            'room_no_pk'
        );

        $sql = "SELECT '' as sl, a.room_code, a.room_name, a.room_capacity, a.room_size, su.serviceunit_name service_unit, ld.lookupdata_name category,a.room_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at from sysc_room a
    	LEFT JOIN sysc_lookupdata ld on ld.lookupdata_no_pk =  a.room_category_lookup_no_fk
    	LEFT JOIN sysc_serviceunit su on su.serviceunit_no_pk = a.serviceunit_no_fk
    	";
        $order_by_column = "room_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }
    // public function salaryLooked(){
    //     dd('ok');
    //     // $salaryProcess=DB::table();
    //      return Template::loadview("admin.hrm.salaryProcess.salary_looked");
    // }
    public function salaryLockedInfo()
    {

        return Template::loadview("admin.hrm.salaryProcess.salary_locked");
    }

    public function salaryLockedSearch(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $year_month = $request->year . $request->month;
        $year_month_con = ($year_month != "") ? "and salary_yyyymm = $year_month" : "";

        $Salary_locked = DB::select("select salary_yyyymm,process_description,process_no_pk,salary_process_date,salary_process_by,salary_process_person_qty,salary_lock_by, salary_lock_ind, salary_lock_date,salary_journal_ind,salary_advise_ind  from hrms_personnel_salary_process where status = 1 $year_month_con order By au_entry_at Desc");



        return Template::loadview("admin.hrm.salaryProcess.salary_locked_list", ['Salary_locked' => $Salary_locked]);
    }

    public function journalAdviseLocked(Request $request)
    {
        $process_code =  $request->process_code;
        $btn = $request->btn;
        $salary_process_id = $request->salary_id;
        $auth_id = Auth::id();
        $entry_session = "session";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $to_date=date('Y-m-d');
        DB::beginTransaction();
        // dd($btn);
        try {
            $outError = '';
            $pdo = DB::getPdo();

            $journal = $pdo->prepare("begin pkg_accounts.account_integration_payroll_wp(
            :in_process_code,
            :in_process_no_pk,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :out_error
            ); end;");


            $journal->bindParam(':in_process_code', $process_code);
            $journal->bindParam(':in_process_no_pk', $salary_process_id);
            $journal->bindParam(':in_au_entry_by', $auth_id);
            $journal->bindParam(':in_au_entry_session', $entry_session);
            $journal->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $journal->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
            // dd($journal);
            $journal->execute();



            // $result = DB::executeProcedure($procedureName, $dataBindingArr);
// dd($outError);
            if ($outError == '000') {
                DB::commit();
                if($process_code =='SALARY'){
                    $data=[
                        'salary_journal_ind' => $btn,
                        'salary_journal_by' => $auth_id,
                        'salary_journal_date' => $to_date
                    ];
                }
                if($process_code =='SALARYADVISE'){
                    $data=[
                        'salary_advise_ind' => $btn,
                        'salary_advise_by' => $auth_id,
                        'salary_advise_date' => $to_date
                    ];
                }

                DB::table('hrms_personnel_salary_process')->where('process_no_pk',$salary_process_id)->update($data);
                $message = ['msg' => 'Sent to journal successfully.', 'title' => 'Success'];
                // return  json_encode('Sent to journal successfully');

                // DB::commit();

            } else {
                DB::rollback();
                $message = ['msg' => 'Sent to journal Failed' . $outError, 'title' => 'Error'];
            //   return  json_encode('Sent to journal Failed');
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            // return  json_encode('Sent to journal Failed');
        }

        return json_encode($message);
    }
    public function salaryLockedUnlocked(Request $request)
    {
        $year_month = $request->year_month;
        $year = str_split($year_month, 4);

        if ($year[1] == 1) {
            $month = "January";
        } elseif ($year[1] == 2) {
            $month = "February";
        } elseif ($year[1] == 3) {
            $month = "March";
        } elseif ($year[1] == 4) {
            $month = "April";
        } elseif ($year[1] == 5) {
            $month = "May";
        } elseif ($year[1] == 6) {
            $month = "June";
        } elseif ($year[1] == 7) {
            $month = "July";
        } elseif ($year[1] == 8) {
            $month = "August";
        } elseif ($year[1] == 9) {
            $month = "September";
        } elseif ($year[1] == 10) {
            $month = "October";
        } elseif ($year[1] == 11) {
            $month = "November";
        } elseif ($year[1] == 12) {
            $month = "December";
        }

        if ($request->btn == '') {
            $pre_value = DB::table('hrms_personnel_salary_process')->select('salary_lock_ind', 'process_no_pk', 'salary_yyyymm')->where('process_no_pk', '<', $request->salary_id)->orderBy('process_no_pk', 'desc')->take(1)->first();
            $pre_value_con = (isset($pre_value)) ? $pre_value->salary_lock_ind == '' : '';

            if (isset($pre_value)) {
                $pre_year_month = $pre_value->salary_yyyymm;
                $pre_year = str_split($pre_year_month, 4);
                if ($pre_year[1] == 1) {
                    $pre_month = "January";
                } elseif ($pre_year[1] == 2) {
                    $pre_month = "February";
                } elseif ($pre_year[1] == 3) {
                    $pre_month = "March";
                } elseif ($pre_year[1] == 4) {
                    $pre_month = "April";
                } elseif ($pre_year[1] == 5) {
                    $pre_month = "May";
                } elseif ($pre_year[1] == 6) {
                    $pre_month = "June";
                } elseif ($pre_year[1] == 7) {
                    $pre_month = "July";
                } elseif ($pre_year[1] == 8) {
                    $pre_month = "August";
                } elseif ($pre_year[1] == 9) {
                    $pre_month = "September";
                } elseif ($pre_year[1] == 10) {
                    $pre_month = "October";
                } elseif ($pre_year[1] == 11) {
                    $pre_month = "November";
                } elseif ($pre_year[1] == 12) {
                    $pre_month = "December";
                }
            }

            if ($request->btn == ''  && $pre_value_con) {
                return json_encode($month . '-' . $year[0] . '  unable to lock , ' . $pre_month . '-' . $pre_year[0] . '   need to lock first');
            } else {
                $auth_id = Auth::id();
                $date = date('Y-m-d');

                if ($request->btn == 1) {
                    $looked = "";
                } else {
                    $looked = 1;
                }
                $salaryLooked = [
                    "salary_lock_ind" => $looked,
                    "salary_lock_by" => $auth_id,
                    "salary_lock_date" => date('Y-m-d', strtotime($date)),
                    "AU_ENTRY_BY"        => $auth_id,
                    "AU_ENTRY_AT"        => date('Y-m-d', strtotime($date)),
                    "AU_ENTRY_SESSION"  => "SESSION",
                    "AU_ENTRY_HOSPITAL_PK_NO" => 1,
                ];

                $salaryLooked['au_update_by'] = $auth_id;
                DB::table('hrms_personnel_salary_process')->where("process_no_pk", $request->salary_id)->update($salaryLooked);
                if ($request->btn == 1) {
                    return json_encode('Unocked Successful');
                } else {
                    return json_encode('Locked Successful');
                }
            }
        } else {

            $next_value = DB::table('hrms_personnel_salary_process')->select('salary_lock_ind', 'process_no_pk', 'salary_yyyymm')->where('process_no_pk', '>', $request->salary_id)->orderBy('process_no_pk', 'ASC')->take(1)->first();
            $next_value_con = (isset($next_value)) ? $next_value->salary_lock_ind == 1 : '';

            if (isset($next_value)) {
                $next_year_month = $next_value->salary_yyyymm;
                $next_year = str_split($next_year_month, 4);
                if ($next_year[1] == 1) {
                    $next_month = "January";
                } elseif ($next_year[1] == 2) {
                    $next_month = "February";
                } elseif ($next_year[1] == 3) {
                    $next_month = "March";
                } elseif ($next_year[1] == 4) {
                    $next_month = "April";
                } elseif ($next_year[1] == 5) {
                    $next_month = "May";
                } elseif ($next_year[1] == 6) {
                    $next_month = "June";
                } elseif ($next_year[1] == 7) {
                    $next_month = "July";
                } elseif ($next_year[1] == 8) {
                    $next_month = "August";
                } elseif ($next_year[1] == 9) {
                    $next_month = "September";
                } elseif ($next_year[1] == 10) {
                    $next_month = "October";
                } elseif ($next_year[1] == 11) {
                    $next_month = "November";
                } elseif ($next_year[1] == 12) {
                    $next_month = "December";
                }
            }
            if ($request->btn == 1  && $next_value_con) {
                return json_encode($month . '-' . $year[0] . ' unable to Unlock , ' . $next_month . '-' . $next_year[0] . '  need to Unlock first');
            } else {
                $auth_id = Auth::id();
                $date = date('Y-m-d');
                if ($request->btn == 1) {
                    $looked = "";
                } else {
                    $looked = 1;
                }
                $salaryLooked = [
                    "salary_lock_ind" => $looked,
                    "salary_lock_by" => $auth_id,
                    "salary_lock_date" => date('Y-m-d', strtotime($date)),
                    "AU_ENTRY_BY"        => $auth_id,
                    "AU_ENTRY_AT"        => date('Y-m-d', strtotime($date)),
                    "AU_ENTRY_SESSION"  => "SESSION",
                    "AU_ENTRY_HOSPITAL_PK_NO" => 1,
                ];
                $salaryLooked['au_update_by'] = $auth_id;
                DB::table('hrms_personnel_salary_process')->where("process_no_pk", $request->salary_id)->update($salaryLooked);
                if ($request->btn == 1) {
                    return json_encode('Unocked Successful');
                } else {
                    return json_encode('Locked Successful');
                }
            }
        }
    }
}
