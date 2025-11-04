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

class HRMManpowerRequisitionController extends Controller
{
	use UtilitiesTrait, LookupData;

	public function manpowerRequisition()
	{
		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();

		$hrms_designation = DB::table('hrms_designation')->select('designation_no_pk', 'designation_code', 'designation_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', '1')->get();

		$manpowreq_no_uid =  $this->getAutoGenerateUID("hrms_manpowerreq", "manpowreq_no_uid");

		$manpowreq_data = DB::table('hrms_manpowerreq')->leftJoin('sysc_serviceunit', 'hrms_manpowerreq.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('hrms_designation', 'hrms_manpowerreq.designation_no_fk', 'hrms_designation.designation_no_pk')
			->select('hrms_manpowerreq.*', 'sysc_serviceunit.serviceunit_no_pk', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_no_pk', 'hrms_designation.designation_name')->get();

		return Template::loadView('admin.v1.hrm.manpower_requisition.manpower-requisition', ['manpowreq_no_uid' => $manpowreq_no_uid, 'departments' => $departments, 'hrms_designation' => $hrms_designation, 'manpowreq_data' => $manpowreq_data]);
	}

	public function manpowerRequisitionStore(Request $request)
	{
		try {
			$sequence = DB::getSequence();

			if (isset($request->hdnmanpowreq_no_pk)) {
				$manpowreq_no_pk_seq = $request->hdnmanpowreq_no_pk;
			} else {
				$manpowreq_no_pk_seq = $sequence->nextValue('manpowreq_no_pk_seq');
			}

			$entry_session = Session()->get('user.ses_user_pk_no');
			$salary_range = $request->salary_rangefrom . ' - ' . $request->salary_rangeto;
			$data = [
				"manpowreq_no_pk"         => $manpowreq_no_pk_seq,
				"manpowreq_no_uid"        => $request->manpowreq_no_uid,
				"designation_no_fk"       => isset($request->designation_no_fk) ? $request->designation_no_fk : '',
				"su_no_fk"                => isset($request->su_no_fk) ? $request->su_no_fk : '',
				"required_skills"         => isset($request->required_skills) ? $request->required_skills : '',
				"shortage_staff_qty"      => isset($request->shortage_staff_qty) ? $request->shortage_staff_qty : '',
				"expected_date"           => $request->expected_date != '' ? date('Y-m-d', strtotime($request->expected_date)) : '',
				"salary_range"            => isset($salary_range) ? $salary_range : '',
				"req_remarks"             => isset($request->req_remarks) ? $request->req_remarks : '',
				"urgent_ind"              => isset($request->urgent_ind) ? '1' : '0',
				"au_entry_by"             => auth::user()->user_no_pk,
				"au_entry_at"             =>  date('Y-m-d'),
				"au_entry_session"        => $entry_session,
				"au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hdnmanpowreq_no_pk)) {

				DB::table("hrms_manpowerreq")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_manpowerreq")->where('manpowreq_no_pk', $request->hdnmanpowreq_no_pk)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}

	public function manpowerRequisitionUpdate(Request $request)
	{
		$edit_req_data = DB::table('hrms_manpowerreq')->select('hrms_manpowerreq.*')->where('manpowreq_no_pk', $request->manpowreq_no_pk)->first();
		return response()->json($edit_req_data);
	}

	public function manpowerRequisitionWorklist(Request $request)
	{
		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();

		$hrms_designation = DB::table('hrms_designation')->select('designation_no_pk', 'designation_code', 'designation_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', '1')->get();

		$manpowreq_data = DB::table('hrms_manpowerreq_vw')->select('hrms_manpowerreq_vw.*')->get();

		return Template::loadView('admin.v1.hrm.manpower_requisition.requisition-work-list', ['manpowreq_data' => $manpowreq_data, 'departments' => $departments, 'hrms_designation' => $hrms_designation]);
	}

	public function manpowerRequisitionSearch(Request $request)
	{
		$designation = $request->designation;
		$deaprtment  = $request->deaprtment;
		$skill       = $request->skill;
		// dd($designation, $deaprtment, $skill);

		if (isset($designation)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('designation_no_fk', $designation)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}
		if (isset($deaprtment)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('su_no_fk', $deaprtment)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		if (isset($skill)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('required_skills', $skill)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		if (isset($designation) && isset($department)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('designation_no_fk', $designation)
				->where('su_no_fk', $department)
				->orderBy("manpowreq_no_pk", "desc")
				->get();
		}

		if (isset($designation) && isset($department) && isset($skill)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('designation_no_fk', $designation)
				->where('su_no_fk', $department)
				->where('required_skills', $skill)
				->orderBy("manpowreq_no_pk", "desc")
				->get();
		}
		return Template::loadView('admin.v1.hrm.manpower_requisition.requisition-work-search-table', ['manpower_req_data' => $manpower_req_data]);
	}

	public function requisitionWorklistPrint(Request $request)
	{
		$designation = $request->designation;
		$deaprtment  = $request->deaprtment;
		$skill       = $request->skill;
		// dd($designation, $deaprtment, $skill);

		if (isset($designation)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('designation_no_fk', $designation)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}
		elseif (isset($deaprtment)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('su_no_fk', $deaprtment)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		elseif (isset($skill)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('required_skills', $skill)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		// elseif (isset($designation) && isset($department)) {
		// 	$manpower_req_data = DB::table('hrms_manpowerreq_vw')
		// 		->select('hrms_manpowerreq_vw.*')
		// 		->where('designation_no_fk', $designation)
		// 		->where('su_no_fk', $department)
		// 		->orderBy("manpowreq_no_pk", "desc")
		// 		->get();
		// }
		else{
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->orderBy("manpowreq_no_pk", "desc")
				->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

			$pdf = PDF::loadView("admin.v1.hrm.manpower_requisition.requisition-worklist-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $manpower_req_data])->setPaper('a4', 'landscape');
			return $pdf->stream('manpower_requisition_list.pdf');
		
	}

	public function requisitionWorklistExcel(Request $request)
	{
		$designation = $request->designation;
		$deaprtment  = $request->deaprtment;
		$skill       = $request->skill;

		if (isset($designation)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('designation_no_fk', $designation)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}
		elseif (isset($deaprtment)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('su_no_fk', $deaprtment)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		elseif (isset($skill)) {
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->where('required_skills', $skill)
				->orderby("manpowreq_no_pk", "desc")
				->get();
		}

		// elseif (isset($designation) && isset($department)) {
		// 	$manpower_req_data = DB::table('hrms_manpowerreq_vw')
		// 		->select('hrms_manpowerreq_vw.*')
		// 		->where('designation_no_fk', $designation)
		// 		->where('su_no_fk', $department)
		// 		->orderBy("manpowreq_no_pk", "desc")
		// 		->get();
		// }
		else{
			$manpower_req_data = DB::table('hrms_manpowerreq_vw')
				->select('hrms_manpowerreq_vw.*')
				->orderBy("manpowreq_no_pk", "desc")
				->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

			$pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $manpower_req_data];
			$fileToExport = "manpower_requisition_list";
			$html = View("admin.v1.hrm.manpower_requisition.requisition-worklist-excel")->with($pdf);
			header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
			header("Content-type: application/vnd.ms-excel");
			return $html;
	}
}
