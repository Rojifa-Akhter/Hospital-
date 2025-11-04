<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\ServiceUnit;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Session;
use PDF;
use Carbon\Carbon;

class HRMEmployeeSeparationController extends Controller
{
	use UtilitiesTrait, LookupData;

	public function SeperationApplication(Request $request)
	{
		$patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
		$emp_seprtn_uid =  $this->getAutoGenerateUID("hrms_emp_seperation", "emp_seprtn_uid");
		return Template::loadView('admin.v1.hrm.employee_separation.application_for_seperation', ['emp_seprtn_uid' => $emp_seprtn_uid, 'patient_type' => $patient_type]);
	}

	public function SeperationApplicationSave(Request $request)
	{
		try {
			$sequence = DB::getSequence();

			if (isset($request->hdnemp_seprtn_no_pk)) {
				$emp_seprtn_no_pk_seq = $request->hdnemp_seprtn_no_pk;
			} else {
				$emp_seprtn_no_pk_seq = $sequence->nextValue('emp_seprtn_no_pk_seq');
			}

			$data = [
				"emp_seprtn_no_pk"               => $emp_seprtn_no_pk_seq,
				"emp_seprtn_uid"                 => $emp_seprtn_no_pk_seq,
				"emp_seprtn_person_no_fk"        => isset($request->emp_seprtn_person_no_fk) ? $request->emp_seprtn_person_no_fk : null,
				"seprtn_type"                    => isset($request->seprtn_type) ? $request->seprtn_type : '',
				"emp_seprtn_application_date"    => isset($request->emp_seprtn_application_date) ? date('Y-m-d', strtotime($request->emp_seprtn_application_date)) : '',
				"emp_seprtn_expected_date"       => isset($request->emp_seprtn_expected_date) ? date('Y-m-d', strtotime($request->emp_seprtn_expected_date)) : '',
				"last_working_day"               => isset($request->last_working_day) ? date('Y-m-d', strtotime($request->last_working_day)) : '',
				"emp_seprtn_application_remarks" => isset($request->emp_seprtn_application_remarks) ? $request->emp_seprtn_application_remarks : '',
				"save_option"                    => $request->save_option == "SAVE" ? "POST" : "DRAFT",
				"status"                         => 1,
				"au_entry_by"                    => auth::user()->user_no_pk,
				"au_entry_at"                    =>  date('Y-m-d'),
				"au_entry_session"               => Session()->get('user.ses_user_pk_no'),
				"au_entry_hospital_pk_no"        => Session::get('user.ses_hospital_no_pk'),
			];

			if (isset($request->emp_seprtn_attachment_path)) {
				$fileName = time() . '.' . $request->emp_seprtn_attachment_path->extension();
				$request->emp_seprtn_attachment_path->move(public_path('images/uploads/emp_seprtn_attachment/'), $fileName);
				$data['emp_seprtn_attachment_path'] =   $fileName;
			}

			if (!isset($request->hdnemp_seprtn_no_pk)) {

				if ($request->save_option == "SAVE") {
					DB::table('hrms_personnel')
						->where('person_no_pk', $request->emp_seprtn_person_no_fk)
						->update(['status' => '', 'employee_ind' => '', 'last_working_day'=> $data['last_working_day'], 'inactive_reason'=> $data['emp_seprtn_application_remarks']]);

					DB::table('wsec_user')
						->where('person_no_fk', $request->emp_seprtn_person_no_fk)
						->update(['status' => '', 'user_pass' => '', 'user_name_access_code' => '']);

					$persone_info = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->emp_seprtn_person_no_fk)->first();
					DB::table('patn_registration')->where('emp_id', $persone_info->person_code)
						->update(['patient_type' => $request->patient_type]);
				}

				DB::table("hrms_emp_seperation")->insert($data);
				DB::commit();
			} else {
				if ($request->save_option == "SAVE") {
					DB::table('hrms_personnel')
						->where('person_no_pk', $request->emp_seprtn_person_no_fk)
						->update(['status' => '', 'employee_ind' => '','last_working_day'=> $data['last_working_day'], 'inactive_reason'=> $data['emp_seprtn_application_remarks']]);
					DB::table('wsec_user')
						->where('person_no_fk', $request->emp_seprtn_person_no_fk)
						->update(['status' => '', 'user_pass' => '', 'user_name_access_code' => '']);
					
					$persone_info = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->emp_seprtn_person_no_fk)->first();
					DB::table('patn_registration')->where('emp_id', $persone_info->person_code)
						->update(['patient_type' => $request->patient_type]);
				}

				$data['au_update_by']             = auth::user()->user_no_pk;
				$data['au_update_session']        = Session()->get('user.ses_user_pk_no');
				$data['au_update_at']             = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_emp_seperation")->where('emp_seprtn_no_pk', $request->hdnemp_seprtn_no_pk)->update($data);
				DB::commit();
			}

			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
			return response()->json($message, 422);
		}
	}

	public function employeeSeparation(Request $request)
	{
		$departments = ServiceUnit::where('status', '1')
									->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
									->select('serviceunit_no_pk', 'serviceunit_name')
									->orderBy('serviceunit_name', 'asc')
									->get();
		$employee_separation_data = DB::table("hrms_emp_seperation_vw")
									->select("hrms_emp_seperation_vw.*")
									->get();
		return Template::loadView('admin.v1.hrm.employee_separation.employee_seperation_worklist', ['employee_separation_data' => $employee_separation_data, 'departments' => $departments]);
	}


	public function employeeSeparationSearch(Request $request)
	{
		if (isset($request->department)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->get();
		}

		if (isset($request->separation_type)) {
			$separation_search_data = DB::table('hrms_emp_seperation_vw')
										->select('hrms_emp_seperation_vw.*')
										->where('seprtn_type', $request->separation_type)
										->get();
		}

		if (isset($request->separation_status)) {
			$separation_search_data = DB::table('hrms_emp_seperation_vw')
										->select('hrms_emp_seperation_vw.*')
										->where('save_option', $request->separation_status)
										->get();
		}

		if (isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		}

		if (isset($request->department) && isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		}
		if (!isset($request->department) && !isset($request->separation_type) && !isset($request->separation_status) && !isset($request->from_date) && !isset($request->to_date)) {
			$separation_search_data = '';
		}

		return Template::loadView('admin.v1.hrm.employee_separation.employee_seperation_worklist_search_table', ['separation_search_data' => $separation_search_data]);
	}


	public function SeparationWorklistPrint(Request $request)
	{
		if (isset($request->department)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->get();
		} elseif (isset($request->separation_type) && isset($request->separation_status)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('seprtn_type', $request->separation_type)
										->where('save_option', $request->separation_status)
										->get();
		} elseif (isset($request->separation_status)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('save_option', $request->separation_status)
										->get();
		} elseif (isset($request->separation_type)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('seprtn_type', $request->separation_type)
										->get();
		} elseif (isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		} elseif (isset($request->department) && isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		} else {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		return view("admin.v1.hrm.employee_separation.employee_seperation_worklist_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "separation_search_data" => $separation_search_data]);
	}

	public function SeparationWorklistExcel(Request $request)
	{
		if (isset($request->department)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->get();
		} elseif (isset($request->separation_type) && isset($request->separation_status)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('seprtn_type', $request->separation_type)
										->where('save_option', $request->separation_status)
										->get();
		} elseif (isset($request->separation_status)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('save_option', $request->separation_status)
										->get();
		} elseif (isset($request->separation_type)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('seprtn_type', $request->separation_type)
										->get();
		} elseif (isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		} elseif (isset($request->department) && isset($request->from_date) && isset($request->to_date)) {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->where('serviceunit_no_fk', $request->department)
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
										->where(DB::raw('trunc(emp_seprtn_application_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
										->get();
		} else {
			$separation_search_data = DB::table("hrms_emp_seperation_vw")
										->select("hrms_emp_seperation_vw.*")
										->get();
		}


		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		$pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'separation_search_data' => $separation_search_data];
		$fileToExport = "Employee Separation List";
		$html = View("admin.v1.hrm.employee_separation.employee_seperation_worklist_excel")->with($pdf);
		header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
		header("Content-type: application/vnd.ms-excel");
		return $html;
	}

	public function UpdateEmployeeSeparation($id = "", $save_option = "")
	{
		$edit_data = DB::table('hrms_emp_seperation_vw')
					->select('hrms_emp_seperation_vw.*')
					->where('emp_seprtn_no_pk', $id)
					->first();
		return Template::loadView('admin.v1.hrm.employee_separation.application_for_seperation', ['edit_data' => $edit_data]);
	}
}
