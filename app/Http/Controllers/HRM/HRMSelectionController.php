
<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Designation;
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

class HRMSelectionController extends Controller
{
	use UtilitiesTrait, LookupData;

	public function jobCircularCreate()
	{
		$gender      = $this->getLookupListByCode("GENDER");
		$circular_id =  $this->getAutoGenerateUID("hrms_jobcircular", "jobcircular_no_pk");
		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
		$designation = Designation::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
		$marking = DB::table('hrms_markingcriteria')->where('status', 1)->get();
		// dd($marking);
		return Template::loadView('admin.v1.hrm.hrmselection.job-circulation', [
			'departments' => $departments,
			'designation' => $designation,
			'circular_id' => $circular_id,
			'gender'      => $gender,
			'marking'     => $marking
		]);
	}

	public function jobCircularStore(Request $request)
	{
		$sequence = DB::getSequence();
		$entry_session = Session()->get('user.ses_user_pk_no');
		$jobcircular_uid =  $this->getAutoGenerateUID("hrms_jobcircular", "jobcircular_uid");
		$jobcircular_no_pk = $sequence->nextValue('jobcircular_no_pk_seq');
		if (isset($request->hidden_circular_id)) {
			$jobcircular_no_pk = $request->hidden_circular_id;
		} else {
			$jobcircular_no_pk = $sequence->nextValue('jobcircular_no_pk_seq');
		}

		try {

			$data = [
				// 'jobcircular_no_pk'        => $sequence->nextValue('jobcircular_no_pk_seq'),
				'jobcircular_no_pk'        => $jobcircular_no_pk,
				// 'jobcircular_uid'          => $request->jobcircular_uid,
				'jobcircular_uid'          => $jobcircular_uid,
				'jobcircular_date'         => $request->jobcircular_date != '' ? date('Y-m-d', strtotime($request->jobcircular_date)) : '',
				'position_name'            => isset($request->position_name) ? $request->position_name : '',
				'no_of_post'               => isset($request->no_of_post) ? $request->no_of_post : '',
				'skills_required'          => isset($request->skills_required) ? $request->skills_required : '',
				'minimum_expericences_yy'  => isset($request->minimum_expericences_yy) ? $request->minimum_expericences_yy : '',
				'age_limit'                => isset($request->age_limit) ? $request->age_limit : '',
				'jobcircular_opening_date' => $request->jobcircular_opening_date != '' ? date('Y-m-d', strtotime($request->jobcircular_opening_date)) : '',
				'jobcircular_closing_date' => $request->jobcircular_closing_date != '' ? date('Y-m-d', strtotime($request->jobcircular_closing_date)) : '',
				'jobcircular_text'         => isset($request->jobcircular_text) ? $request->jobcircular_text : '',
				'gender_specification'     => isset($request->gender_specification) ? $request->gender_specification : '',
				'designation_no_fk'        => isset($request->designation_no_fk) ? $request->designation_no_fk : '',
				'su_no_fk'                 => isset($request->su_no_fk) ? $request->su_no_fk : '',
				'markingmst_no_fk'         => isset($request->marking_criteria) ? $request->marking_criteria : '',
				'status'                   => 1,
				'au_entry_by'              => auth::user()->user_no_pk,
				'au_entry_at'              => date('Y-m-d'),
				"au_entry_session"         => $entry_session,
				"au_entry_hospital_pk_no"  => Session::get('user.ses_hospital_no_pk'),
			];

			if (isset($request->upload_circuler)) {
				$fileName = time() . '.' . $request->upload_circuler->extension();
				$request->upload_circuler->move(public_path('uploads/hrselection/'), $fileName);
				$data['upload_circuler'] =   $fileName;
			}

			if (!isset($request->hidden_circular_id)) {

				db::table("hrms_jobcircular")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
				db::table("hrms_jobcircular")->where('jobcircular_no_pk', $request->hidden_circular_id)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);
	}

	public function jobCircularEdit($id = "")
	{
		$gender      = $this->getLookupListByCode("GENDER");
		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
		$designation = Designation::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
		$editData = DB::table('hrms_jobcircular')->where('jobcircular_no_pk', $id)->first();
		$marking = DB::table('hrms_markingcriteria')->where('status', 1)->get();

		return Template::loadView(
			"admin.v1.hrm.hrmselection.job-circulation-edit-form",
			[
				'editData'    => $editData,
				'gender'      => $gender,
				'departments' => $departments,
				'designation' => $designation,
				'marking'     => $marking
			]
		);
	}


	public function jobCircularWorkList(Request $request)
	{
		$data = DB::table('hrms_jobcircular_vw')->join('hrms_applicant_cv', 'hrms_jobcircular_vw.jobcircular_no_pk', 'hrms_applicant_cv.jobcircular_no_fk')->select('hrms_jobcircular_vw.jobcircular_uid', 'hrms_jobcircular_vw.jobcircular_date', 'hrms_jobcircular_vw.position_name', 'hrms_jobcircular_vw.designation_name', 'hrms_jobcircular_vw.serviceunit_name', 'hrms_jobcircular_vw.jobcircular_closing_date', 'hrms_jobcircular_vw.jobcircular_no_pk', DB::raw('COUNT(hrms_applicant_cv.jobcircular_no_fk) as total'))->addSelect(DB::raw('COUNT(hrms_applicant_cv.call_for_interview) as total_call'))
			->groupBy('hrms_jobcircular_vw.jobcircular_uid', 'hrms_jobcircular_vw.jobcircular_date', 'hrms_jobcircular_vw.position_name', 'hrms_jobcircular_vw.designation_name', 'hrms_jobcircular_vw.serviceunit_name', 'hrms_jobcircular_vw.jobcircular_closing_date', 'hrms_jobcircular_vw.jobcircular_no_pk')->get();

		return Template::loadView('admin.v1.hrm.hrmselection.job-circulation-work-list', [
			'data' => $data,
		]);
	}

	public function searchJobCircular(Request $request)
	{
		$position         = $request->position;
		$designation      = $request->designation;
		$department       = $request->department;
		$search_date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
		$search_date_to   = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';


		if (isset($position)) {
			$search_data = DB::table('hrms_jobcircular_vw')
				->select('hrms_jobcircular_vw.*')->where('position_name', $position)->get();
		}
		if (isset($designation)) {
			$search_data = DB::table('hrms_jobcircular_vw')
				->select('hrms_jobcircular_vw.*')->where('designation_name', $designation)->get();
		}
		if (isset($department)) {
			$search_data = DB::table('hrms_jobcircular_vw')
				->select('hrms_jobcircular_vw.*')->where('serviceunit_name', $department)->get();
		}


		if (isset($search_date_from) && $search_date_to) {
			$search_data = DB::table('hrms_jobcircular_vw')->select('hrms_jobcircular_vw.*')
				->whereBetween('jobcircular_date', [$search_date_from, $search_date_to])->get();
		}
		// dd($search_data);
		return Template::loadView('admin.v1.hrm.hrmselection.job-circulation-work-list-search-table', [
			'search_data' => $search_data,
		]);
	}

	public function viewAllApplicants($id = "")
	{

		$data = DB::table('hrms_applicant_cv')->where('jobcircular_no_fk', $id)->get();
		// dd($data);
		return Template::loadView('admin.v1.hrm.hrmselection.view-all-applicants', [
			'data' => $data
		]);
	}

	public function viewCircular($id = "")
	{
		$circular_data = DB::table('hrms_jobcircular')->join('sysc_serviceunit', 'hrms_jobcircular.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('hrms_designation', 'hrms_jobcircular.designation_no_fk', 'hrms_designation.designation_no_pk')->select('hrms_jobcircular.*', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name')->where('jobcircular_no_pk', $id)->get();
		$gender = $this->getLookupListByCode("GENDER");
		// dd($circular_data);
		return Template::loadView('admin.v1.hrm.hrmselection.view-circular', [
			'circular_data' => $circular_data,
			'gender'        => $gender
		]);
	}

	public function applicantWorkList()
	{
		$data = DB::table('hrms_applicant_cv')->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('hrms_applicant_experience', 'hrms_applicant_cv.cvapplicant_no_pk', 'hrms_applicant_experience.cvapplicant_no_fk')->leftJoin('hrms_applicant_education', 'hrms_applicant_cv.cvapplicant_no_pk', 'hrms_applicant_education.cvapplicant_no_fk')->leftJoin('sysc_district', 'hrms_applicant_cv.pe_district', 'sysc_district.id')->leftJoin('hrms_applicant_cv_marking', 'hrms_applicant_cv.cvapplicant_no_pk', 'hrms_applicant_cv_marking.cvapplicant_no_fk')->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name', 'hrms_applicant_experience.number_of_years', 'hrms_applicant_education.highest_education', 'sysc_district.name as district_name', 'hrms_applicant_cv_marking.cvapplicant_no_fk')->distinct()->get();
		// $data = DB::table('hrms_applicant_cv')->get();
		// dd($data);

		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
		// dd($data);
		return Template::loadView('admin.v1.hrm.hrmselection.applicant-work-list', [
			'data' => $data,
			'department_list' => $departments
		]);
	}

	public function searchApplicant(Request $request)
	{
		// dd($request->circuler_id);
		$circuler_id    = $request->circuler_id;
		$name           = $request->name;
		$deaprtment     = $request->deaprtment;
		$mobile         = $request->mobile;
		$exprience      = $request->exprience;
		$position       = $request->position;
		$status         = $request->status;

		$data = DB::table('hrms_applicant_cv')->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('hrms_applicant_experience', 'hrms_applicant_cv.cvapplicant_no_pk', 'hrms_applicant_experience.cvapplicant_no_fk')->leftJoin('hrms_applicant_education', 'hrms_applicant_cv.cvapplicant_no_pk', 'hrms_applicant_education.cvapplicant_no_fk')->leftJoin('sysc_district', 'hrms_applicant_cv.pe_district', 'sysc_district.id')->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name', 'hrms_applicant_experience.number_of_years', 'hrms_applicant_education.highest_education', 'sysc_district.name as district_name');

		if (isset($name)) {
			$data = $data->where('full_name', $name);
		}

		if (isset($circular_id)) {
			$data = $data->where('jobcircular_no_fk', $circuler_id);
		}

		if (isset($deaprtment)) {
			$data = $data->where('su_no_fk', $deaprtment);
		}

		if (isset($mobile)) {
			$data = $data->where('mobile_no', $mobile);
		}

		if (isset($exprience)) {
			$data = $data->where('number_of_years', $exprience);
		}

		if (isset($position)) {
			$data = $data->where('post', $position);
		}

		// if (isset($status)) {
		// 	$data = $data->where('status', $status)->get();
		// }

		if (!isset($name) && !isset($circular_id) && !isset($deaprtment) && !isset($mobile) && !isset($exprience) && !isset($position)) {
			$data = [];
		} else {
			$data = $data->distinct()->get();
		}

		return Template::loadView('admin.v1.hrm.hrmselection.applicant-work-list-search-table', [
			'data' => $data
		]);
	}

	public function markingCriteria(Request $request)
	{

		$data = DB::table('hrms_markingcriteria')->get();
		// dd($data);
		return Template::loadView('admin.v1.hrm.hrmselection.marking-criteria', [
			'data'       => $data
		]);
	}

	public function saveMarkingCriteria(Request $request)
	{
		$sequence = DB::getSequence();
		$entry_session = Session()->get('user.ses_user_pk_no');
		$markingcriteria_no_pk = $sequence->nextValue('seq_markingcriteria_no_pk');
		// $marking_sl =  $this->getAutoGenerateUID("hrms_markingcriteria", "marking_sl");
		if (isset($request->hidden_markingcriteria_no_pk)) {
			$markingcriteria_no_pk = $request->hidden_markingcriteria_no_pk;
		} else {
			$markingcriteria_no_pk = $sequence->nextValue('seq_markingcriteria_no_pk');
		}

		try {

			$data = [
				'markingcriteria_no_pk'    => $markingcriteria_no_pk,
				'marking_sl'               => $request->marking_sl,
				'marking_creteria'         => isset($request->marking_creteria) ? $request->marking_creteria : '',
				'top_score'                => isset($request->top_score) ? $request->top_score : '',
				'passing_score'            => isset($request->passing_score) ? $request->passing_score : '',
				'status'                   => 1,
				'au_entry_by'              => auth::user()->user_no_pk,
				'au_entry_at'              => date('Y-m-d'),
				"au_entry_session"         => $entry_session,
				"au_entry_hospital_pk_no"  => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hidden_markingcriteria_no_pk)) {

				db::table("hrms_markingcriteria")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				db::table("hrms_markingcriteria")->where('markingcriteria_no_pk', $request->hidden_markingcriteria_no_pk)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);

		return Template::loadView('admin.v1.hrm.hrmselection.marking-criteria');
	}


	public function updateMarkingCriteria($id = "")
	{
		$update_data = DB::table('hrms_markingcriteria')->where('markingcriteria_no_pk', $id)->first();
		// dd($update_data);
		return Template::loadView('admin.v1.hrm.hrmselection.update-marking-criteria', [
			'update_data' => $update_data
		]);
	}

	public function applicantMarks($id = "", $uid = "")
	{
		// dd($id);
		$sequence = DB::getSequence();
		$sl = $sequence->nextValue('seq_appl_markingdtl_no_pk');
		$marking_criteria = DB::table('hrms_markingcriteria')->where('status', 1)->get();
		$applicant_marks = DB::table('hrms_applicant_cv_marking')->leftJoin('hrms_markingcriteria', 'hrms_applicant_cv_marking.markingmst_no_fk', 'hrms_markingcriteria.markingcriteria_no_pk')->select('hrms_applicant_cv_marking.*', 'hrms_markingcriteria.marking_creteria')->where('cvapplicant_no_fk', $id)->get();
		// dd($applicant_marks);
		return Template::loadView('admin.v1.hrm.hrmselection.add-applicant-marks', [
			'marking_criteria'         => $marking_criteria,
			'cvapplicant_no_pk'        => $id,
			'cvapplicant_uid'          => $uid,
			'sl'                       => $sl,
			'applicant_marks'          => $applicant_marks
		]);
	}

	public function applicantMarkSave(Request $request)
	{
		$sequence = DB::getSequence();
		$entry_session = Session()->get('user.ses_user_pk_no');
		$appl_markingdtl_no_pk = $sequence->nextValue('seq_appl_markingdtl_no_pk');
		$appl_markingdtl_uid =  $this->getAutoGenerateUID("hrms_applicant_cv_marking", "appl_markingdtl_uid");
		if (isset($request->hidden_appl_markingdtl_no_pk)) {
			$appl_markingdtl_no_pk = $request->hidden_appl_markingdtl_no_pk;
		} else {
			$markingcriteria_no_pk = $sequence->nextValue('seq_appl_markingdtl_no_pk');
		}

		try {

			$data = [
				'appl_markingdtl_no_pk'    => $appl_markingdtl_no_pk,
				// 'seq_appl_markingdtl_no_pk' => $appl_markingdtl_uid,
				'appl_markingdtl_uid'      => $appl_markingdtl_uid,
				'appl_marking_date'        => isset($request->appl_marking_date) ? date('Y-m-d', strtotime($request->appl_marking_date)) : date("Y-m-d"),
				'cvapplicant_no_fk'        => $request->cvapplicant_no_fk,
				'cvapplicant_uid'		   => $request->cvapplicant_uid,
				'markingmst_no_fk'         => isset($request->markingmst_no_fk) ? $request->markingmst_no_fk : '',
				'top_mark'                 => isset($request->top_mark) ? $request->top_mark : '',
				'passing_mark'             => isset($request->passing_mark) ? $request->passing_mark : '',
				'applicant_mark'           => isset($request->applicant_mark) ? $request->applicant_mark : '',
				'status'                   => 1,
				'au_entry_by'              => auth::user()->user_no_pk,
				'au_entry_at'              => date('Y-m-d'),
				"au_entry_session"         => $entry_session,
				"au_entry_hospital_pk_no"  => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hidden_appl_markingdtl_no_pk)) {

				db::table("hrms_applicant_cv_marking")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				db::table("hrms_applicant_cv_marking")->where('appl_markingdtl_no_pk', $request->hidden_appl_markingdtl_no_pk)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);
		return Template::loadView('admin.v1.hrm.hrmselection.add-applicant-marks');
	}



	public function markingDataFind(Request $request)
	{
		$marking_find = DB::table('hrms_markingcriteria')->where('markingcriteria_no_pk', $request->markingCriteriaId)->first();
		return response()->json($marking_find);
	}


	public function issueLetter($id = "")
	{
		$checkLetter =  DB::table('hrms_applicant_cv')->where('cvapplicant_no_pk', $id)->first();
		// dd($checkLetter);
		return Template::loadView('admin.v1.hrm.hrmselection.issue-appointment-letter', [
			'applicant_id' => $id,
			'checkLetter'  => $checkLetter
		]);
	}

	public function letterIssueSave(Request $request)
	{
		if (isset($request->hdn_applicant_id)) {
			$data = [
				'letterissued_date'     => isset($request->letterissued_date) ? date('Y-m-d', strtotime($request->letterissued_date)) : date("Y-m-d"),
				'letterissued_remarks'  => isset($request->letterissued_remarks) ? $request->letterissued_remarks : '',
				'letterissued_ind'      => 1,
			];
			DB::table("hrms_applicant_cv")->where("cvapplicant_no_pk", $request->hdn_applicant_id)->update($data);
		}
		$message = ['msg' => 'Updated successfully.', 'title' => 'Success'];
		return response()->json($message);

		return Template::loadView('admin.v1.hrm.hrmselection.applicant-work-list');
	}

	public function appointmentLetter($id = "")
	{
		// dd($id);
		$candidateInfo       = DB::table("hrms_applicant_cv")->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->where('cvapplicant_no_pk', $id)->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')->first();

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
		$userInfo            = Auth::user();
		// dd($po_hospital_details);
		$pdf = PDF::loadView("admin.v1.hrm.hrmselection.appointment-letter-pdf", [
			'po_hospital_details' => $po_hospital_details,
			'userInfo'            => $userInfo,
			'candidateInfo'       => $candidateInfo,
		]);
		return $pdf->stream("Appointment_Letter.pdf", array("Attachment" => false));
	}
}
