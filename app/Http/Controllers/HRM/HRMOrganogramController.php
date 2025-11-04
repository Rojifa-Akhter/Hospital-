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

class HRMOrganogramController extends Controller
{
	use UtilitiesTrait, LookupData;

	public function createHrLevel()
	{
		$hr_levels = DB::table("hrms_organogramlevel")->select("orglevel_si_pk", "level_number", "level_text", "level_name", "default_ind")->get();

		return Template::loadView('admin.v1.hrm.organogram.create-hr-level', ['hr_levels' => $hr_levels]);
	}

	public function saveHrLevel(Request $request)
	{
		try {
			$sequence = DB::getSequence();

			if (isset($request->hdnorglevel_si_pk)) {
				$orglevel_si_pk_seq = $request->hdnorglevel_si_pk;
			} else {
				$orglevel_si_pk_seq = $sequence->nextValue('orglevel_si_pk_seq');
			}

			$entry_session = Session()->get('user.ses_user_pk_no');
			$data = [
				"orglevel_si_pk"          => $orglevel_si_pk_seq,
				"level_number"            => isset($request->level_number) ? $request->level_number : '',
				"level_text"              => isset($request->level_text) ? $request->level_text : '',
				"level_name"              => isset($request->level_name) ? $request->level_name : '',
				"default_ind"             => isset($request->default_ind) ? '1' : '0',
				"status"                  => 1,
				"au_entry_by"             => auth::user()->user_no_pk,
				"au_entry_at"             =>  date('Y-m-d'),
				"au_entry_session"        => $entry_session,
				"au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hdnorglevel_si_pk)) {

				DB::table("hrms_organogramlevel")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_organogramlevel")->where('orglevel_si_pk', $request->hdnorglevel_si_pk)->update($data);
			}
			// dd($data);
			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}

	public function editHrLevel(Request $request)
	{
		$hrlevelEditData = DB::table('hrms_organogramlevel')->select("orglevel_si_pk", "level_number", "level_text", "level_name", "default_ind")->where('orglevel_si_pk', $request->orglevel_si_pk)->first();

		return response()->json($hrlevelEditData);
	}

	public function MapwithDesignation(Request $request)
	{
		$hr_level = DB::table('hrms_organogramlevel')->select('orglevel_si_pk', 'level_number', 'level_text', 'level_name')->get();
		$hr_designation = DB::table('hrms_designation')->select('designation_no_pk', 'designation_code', 'designation_name')->get();

		$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
			->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
			->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
			->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
			->get();

		$data_with_label = [];
		if (!empty($map_desig_data)) {
			foreach ($map_desig_data as $key => $value) {
				$data_with_label[$value->orglevel_si_fk . '_' . $value->level_name][] = $value;
			}
		}
		// dd($data_with_label);
		return Template::loadView('admin.v1.hrm.organogram.level-map-with-designation', ['hr_level' => $hr_level, 'hr_designation' => $hr_designation, 'data_with_label' => $data_with_label]);
	}

	public function MapwithDesignationSave(Request $request)
	{
		try {
			$sequence = DB::getSequence();

			if (isset($request->hdnorganogramlvlmapdg_no_pk_seq)) {
				$organogramlvlmapdg_no_pk_seq = $request->hdnorganogramlvlmapdg_no_pk_seq;
			} else {
				$organogramlvlmapdg_no_pk_seq = $sequence->nextValue('organogramlvlmapdg_no_pk_seq');
			}

			$entry_session = Session()->get('user.ses_user_pk_no');
			$data = [
				"organogramlvlmapdg_no_pk" => $organogramlvlmapdg_no_pk_seq,
				"orglevel_si_fk"          => isset($request->orglevel_si_fk) ? $request->orglevel_si_fk : '',
				"designation_no_fk"       => isset($request->designation_no_fk) ? $request->designation_no_fk : '',
				"status"                  => 1,
				"au_entry_by"             => auth::user()->user_no_pk,
				"au_entry_at"             =>  date('Y-m-d'),
				"au_entry_session"        => $entry_session,
				"au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hdnorganogramlvlmapdg_no_pk_seq)) {

				DB::table("hrms_organogramlevelmapdesig")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_organogramlevelmapdesig")->where('organogramlvlmapdg_no_pk', $request->hdnorganogramlvlmapdg_no_pk_seq)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}


	public function MapwithDesignationUpdate(Request $request)
	{

		$edit_data = DB::table('hrms_organogramlevelmapdesig')->select('organogramlvlmapdg_no_pk', 'orglevel_si_fk', 'designation_no_fk')->where('organogramlvlmapdg_no_pk', $request->organogramlvlmapdg_no_pk)->first();

		return response()->json($edit_data);
	}


	public function levelMapDesignationWorklist()
	{
		$hr_level = DB::table('hrms_organogramlevel')->select('orglevel_si_pk', 'level_number', 'level_text', 'level_name')->get();
		$hr_designation = DB::table('hrms_designation')->select('designation_no_pk', 'designation_code', 'designation_name')->get();

		$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
			->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
			->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
			->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
			->get();

		$data_with_label = [];
		if (!empty($map_desig_data)) {
			foreach ($map_desig_data as $key => $value) {
				$data_with_label[$value->orglevel_si_fk . '_' . $value->level_name][] = $value;
			}
		}

		return Template::loadView('admin.v1.hrm.organogram.level-map-with-designation-worklist', ['hr_level' => $hr_level, 'hr_designation' => $hr_designation]);
	}

	public function levelMapDesignationSearch(Request $request)
	{

		if (isset($request->orglevel_si_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('orglevel_si_fk', $request->orglevel_si_fk)
				->get();
		}

		if (isset($request->designation_no_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('designation_no_fk', $request->designation_no_fk)
				->get();
		}

		$data_with_label = [];
		if (!empty($map_desig_data)) {
			foreach ($map_desig_data as $key => $value) {
				$data_with_label[$value->orglevel_si_fk . '_' . $value->level_name][] = $value;
			}
		}

		// dd($data_with_label);
		return Template::loadView('admin.v1.hrm.organogram.level-map-with-designation-worklist-search-table', ['data_with_label' => $data_with_label]);
	}



	public function levelMapDesignationWorklistPrint(Request $request)
	{
		if (isset($request->orglevel_si_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('orglevel_si_fk', $request->orglevel_si_fk)
				->get();
		} elseif (isset($request->designation_no_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('designation_no_fk', $request->designation_no_fk)
				->get();
		} else {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->get();
		}

		$data_with_label = [];
		if (!empty($map_desig_data)) {
			foreach ($map_desig_data as $key => $value) {
				$data_with_label[$value->orglevel_si_fk . '_' . $value->level_name][] = $value;
			}
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.v1.hrm.organogram.level-map-desig-worklist-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data_with_label' => $data_with_label])->setPaper('a4', 'potrait');
		return $pdf->stream('level_map_design_list.pdf');
	}



	public function levelMapDesignationWorklistExcel(Request $request)
	{
		if (isset($request->orglevel_si_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('orglevel_si_fk', $request->orglevel_si_fk)
				->get();
		} elseif (isset($request->designation_no_fk)) {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->where('designation_no_fk', $request->designation_no_fk)
				->get();
		} else {
			$map_desig_data = DB::table('hrms_organogramlevelmapdesig')
				->leftJoin('hrms_organogramlevel', 'hrms_organogramlevel.orglevel_si_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk')
				->leftJoin('hrms_designation', 'hrms_designation.designation_no_pk', 'hrms_organogramlevelmapdesig.designation_no_fk')
				->select('hrms_organogramlevelmapdesig.organogramlvlmapdg_no_pk', 'hrms_organogramlevelmapdesig.orglevel_si_fk', 'hrms_organogramlevelmapdesig.designation_no_fk', 'hrms_organogramlevelmapdesig.status', 'hrms_organogramlevel.level_name', 'hrms_designation.designation_name')
				->get();
		}

		$data_with_label = [];
		if (!empty($map_desig_data)) {
			foreach ($map_desig_data as $key => $value) {
				$data_with_label[$value->orglevel_si_fk . '_' . $value->level_name][] = $value;
			}
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data_with_label' => $data_with_label];
		$fileToExport = "level_map_design_list";
		$html = View("admin.v1.hrm.organogram.level-map-desig-worklist-excel")->with($pdf);
		header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
		header("Content-type: application/vnd.ms-excel");
		return $html;;
	}


	public function levelMapDesignationDelete(Request $request)
	{
		// dd($request->organogramlvlmapdg_no_pk);
		DB::table('hrms_organogramlevelmapdesig')->where('organogramlvlmapdg_no_pk', $request->organogramlvlmapdg_no_pk)->delete();
		DB::commit();
		$message = ['msg' => 'Data remove successfully.', 'title' => 'Success'];
		return response()->json($message);
	}

	public function HROrganogram(Request $request)
	{
		$data = DB::table('hrms_organogram_vw')->select('hrms_organogram_vw.*')->get();

		$top = [];
		foreach ($data as $key => $value) {
			if ($value->level_text == 'LEVEL 01') {
				$top[$value->orglevel_si_pk . '_' . $value->level_text][] = $value;
			}
		}

		$senior = [];
		foreach ($data as $key => $value) {
			if ($value->level_text == 'L02') {
				$senior[$value->orglevel_si_pk . '_' . $value->level_text][] = $value;
			}
		}
		// dd($senior);

		return Template::loadView('admin.v1.hrm.organogram.organogram', ['data' => $data, 'top' => $top, 'senior' => $senior]);
	}
}
