<?php

namespace App\Http\Controllers;

use App;
use PDO;
use \PDF;
use View;
use App\Traits\ItemData;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Traits\DatatablesLoader;
use App\Traits\HospitalStoreData;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use App\Models\UomLookup as Lookup;
use App\Http\Controllers\Controller;
use App\Models\ServiceUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use SebastianBergmann\Diff\Diff;

class PromotionController extends Controller
{
	use DatatablesLoader, LookupData, ItemData, UtilitiesTrait, HospitalStoreData;

	private $message;

	public function due_promotion_work_list()
	{
		$department = ServiceUnit::where('status', '1')
						->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
						->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
						->orderBy('serviceunit_name', 'asc')
						->get();
		  $grade   = DB::table("HRMS_GRADE")
						->select("grade_no_pk", "grade_name")
						->where('status', 1)
						->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
						->orderBy('grade_name', 'asc')
						->get();

		$employee   = DB::table("employee_info_vw")
						->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
						->select('person_no_pk', 'full_name')
						->orderBy('person_no_pk', 'asc')
						->get();
		return Template::loadView(
			"admin.v1.hrm.due-promotion-work-list",
			[
				'grade'       => $grade,
				'department'  => $department,
				'employee'    => $employee
			]);
	}


	public function search_promotion_work_list(Request $request)
	{
		$searchKey = [
			'su_name'            => $request->su_name,
			'from_designation'   => $request->from_grade,
			'to_designation'     => $request->to_grade,
			'employee_name'      => $request->employee_name
		];

		$from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
		$to_date   = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date)) : '';

		if (isset($from_date) && $to_date) {
			$data = DB::table('hrms_emp_promotion_vw')
					->join('hrms_designation', 'hrms_emp_promotion_vw.curr_design_no_fk', 'hrms_designation.designation_no_pk')
					->select('hrms_emp_promotion_vw.*', 'hrms_designation.designation_name')
					->whereBetween('next_expected_date', [$from_date, $to_date])
					->get();
		}

		if (isset($searchKey['employee_name'])) {
			$data = DB::table('hrms_emp_promotion_vw')
						->join('hrms_designation', 'hrms_emp_promotion_vw.curr_design_no_fk', 'hrms_designation.designation_no_pk')
						->select('hrms_emp_promotion_vw.*', 'hrms_designation.designation_name')
						->where('person_no_pk', $searchKey['employee_name'])
						->get();
		}
		if (isset($searchKey['su_name'])) {
			$data = DB::table('hrms_emp_promotion_vw')
						->join('hrms_designation', 'hrms_emp_promotion_vw.curr_design_no_fk', 'hrms_designation.designation_no_pk')
						->select('hrms_emp_promotion_vw.*', 'hrms_designation.designation_name')
						->where('serviceunit_no_fk', $searchKey['su_name'])
						->get();
		}

		$designation = DB::table("hrms_designation")->select("designation_no_pk", "designation_name")
						->where('status', 1)
						->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
						->orderBy('designation_name', 'asc')
						->get();

		return Template::loadView("admin.v1.hrm.due-promotion-work-list-search-table", [
			'data'           => $data,
			'designation'    => $designation
		]);
	}


	public function promotion_trans_store(Request $request)
	{
		$auth_id         = Auth::id();
		$person_id       = $request->emp_id;
		$ses_hospital_id = Session::get('user.ses_hospital_no_pk');
		try {
			$name_array_count        		= sizeof($request->input('emp_name'));
			$emp_id                  		= $request->input('emp_id');
			$emp_name                		= $request->input('emp_name');
			$department		         		= $request->input('department');
			$join_date               		= $request->input('join_date');
			$last_promotion_date	 		= $request->input('last_promotion_date');
			$last_designation        		= $request->input('last_designation');
			$current_designation     		= $request->input('current_designation');
			$current_designation_duration   = $request->input('current_designation_duration');
			$date_of_due					= $request->input('date_of_due');
			$gross_salary					= $request->input('gross_salary');
			$estimated_increment_amout		= $request->input('estimated_increment_amout');
			$estimated_increment_salary		= $request->input('estimated_increment_salary');
			$increment 						= $request->input('increment');
			$increment_details				= $request->input('increment_details');
			$curr_design_no_fk              = $request->input('curr_design_no_fk');
			$final_increment_amt            = $request->input('final_increment_amt');
			$proposed_designation           = $request->input('expected_designation');

			if (isset($emp_name)) {
				for ($i = 0; $i < $name_array_count; $i++) {
					if ($emp_name[$i] != null) {
						$sequence              = DB::getSequence();
						$promotrans_no_pk_seq  = $sequence->nextValue('promotrans_no_pk_seq');
						$entry_session         = Session()->get('user.ses_user_pk_no');
						$promotion_data = [
							"promotrans_no_pk"                 => $promotrans_no_pk_seq,
							"promotrans_date"                  => (isset($last_promotion_date[$i])) ? $last_promotion_date[$i] : '',
							"person_no_fk"                     => isset(($emp_id[$i])) ? $emp_id[$i] : '',
							"curr_design_no_fk"                => isset($curr_design_no_fk[$i]) ? $curr_design_no_fk[$i] : '',
							"proposed_design_no_fk"	           => isset($proposed_designation[$i]) ? $proposed_designation[$i] : '',
							"current_salary"                   => (isset($gross_salary[$i])) ? $gross_salary[$i] : '',
							"proposed_increment_percent"	   => (isset($increment[$i])) ? $increment[$i] : '',
							"proposed_increment_amt"           => (isset($estimated_increment_amout[$i])) ? $estimated_increment_amout[$i] : '',
							"final_increment_amt"              => (isset($final_increment_amt[$i])) ? $final_increment_amt[$i] : '',
							'date_of_effective'                => isset($request->effective_date) ? date('Y-m-d', strtotime($request->effective_date)) : '',
							"au_entry_session"				   => $entry_session,
							"au_entry_hospital_pk_no"		   => $ses_hospital_id,
						];
						$promotion_data["au_entry_by"] = $auth_id;
						$promotion_data["au_entry_at"] = date("Y-m-d");
						db::table("hrms_promotion_trans")->insert($promotion_data);
					}
				}
			}
			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $person_id];
		} catch (\Exception $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);
	}


	public function promotionHistory($id = "")
	{
		$promotion_info = [];
		if ($id != null) {
			$promotion_info = DB::table('hrms_emp_promotion_worklist_vw')
								->where("person_no_pk", $id)
								->get();
		}
		return Template::loadView("admin.v1.hrm.employee_promotion_history", ['promotion_info' => $promotion_info]);
	}

	public function incrementHistory($id = "")
	{
		$increment_info = [];
		if ($id != null) {
			$increment_info = DB::table('hrms_emp_increment_worklist_vw')->where("person_no_pk", $id)->get();
		}
		return Template::loadView("admin.v1.hrm.employee_increment_history", ['increment_info' => $increment_info]);
	}
}
