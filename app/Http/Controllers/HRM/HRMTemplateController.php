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
use Barryvdh\DomPDF;
use Carbon\Carbon;

class HRMTemplateController extends Controller
{
	use UtilitiesTrait, LookupData;

	public function HrmTemplateMain()
	{

		$lettertemp_uid =  $this->getAutoGenerateUID("hrms_lettertemplate", "lettertemp_uid");
		$template_data = DB::table('hrms_lettertemplate')
			->leftJoin('hrms_lettertemplatedtl', 'hrms_lettertemplatedtl.lettertempdtl_no_pk', 'hrms_lettertemplate.lettertemp_no_pk')
			->select('hrms_lettertemplate.lettertemp_no_pk', 'hrms_lettertemplate.lettertemp_uid', 'hrms_lettertemplate.lettertemp_name', 'hrms_lettertemplatedtl.lettertemp_no_fk', DB::raw('(select count(*) FROM hrms_lettertemplatedtl where hrms_lettertemplatedtl.lettertemp_no_fk = hrms_lettertemplate.lettertemp_no_pk) as lettertemp_no_fk_count'))
			->orderBy('hrms_lettertemplate.lettertemp_no_pk', 'asc')
			->get();

		return Template::loadView('admin.v1.hrm.templates.hr-letter-templates', ['template_data' => $template_data, 'lettertemp_uid' => $lettertemp_uid]);
	}

	public function saveTemplate(Request $request)
	{

		try {
			$sequence = DB::getSequence();

			if (isset($request->hdnlettertemp_no_pk)) {
				$lettertemp_no_pk_seq = $request->hdnlettertemp_no_pk;
			} else {
				$lettertemp_no_pk_seq = $sequence->nextValue('lettertemp_no_pk_seq');
			}

			$template_code 			 = $request->template_code;
			$template_name 			 = $request->template_name;
			$template_type 			 = $request->template_type;
			$content 				 = $request->content;
			$active_status 			 = $request->active_status;
			$entry_session = Session()->get('user.ses_user_pk_no');
			$data = [
				"lettertemp_no_pk"        => $lettertemp_no_pk_seq,
				"lettertemp_uid"          => $template_code,
				"lettertemp_name"         => isset($template_name) ? $template_name : '',
				"lettertemp_type"         => isset($template_type) ? $template_type : '',
				"status"                  => isset($active_status) ? '1' : '0',
				"lettertemp_html_text"    => isset($content) ? $content : '',
				"apply_for_letter_ind"    => $request->template_ind === '1' ? 1 : 0,
				"apply_for_email_ind"     => $request->template_ind === '2' ? 1 : 0,
				"apply_for_sms_ind"       => $request->template_ind === '3' ? 1 : 0,
				"au_entry_by"             => auth::user()->user_no_pk,
				"au_entry_at"             =>  date('Y-m-d'),
				"au_entry_session"        => $entry_session,
				"au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->hdnlettertemp_no_pk)) {

				DB::table("hrms_lettertemplate")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_lettertemplate")->where('lettertemp_no_pk', $request->hdnlettertemp_no_pk)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}


	public function editTemplate(Request $request)
	{
		$lettertemp_no_pk = $request->lettertemp_no_pk;
		$edit_data = DB::table('hrms_lettertemplate')->select('hrms_lettertemplate.*')->where('lettertemp_no_pk', $lettertemp_no_pk)->first();
		// dd($edit_data);
		return response()->json($edit_data);
	}

	public function templateParameter($lettertemp_name = "", $lettertemp_no_fk = "", $lettertemp_uid = "")
	{
		$lettertemp_no_fk = $lettertemp_no_fk;
		$parameter_data = DB::table('hrms_lettertemplatedtl')->select('hrms_lettertemplatedtl.lettertempdtl_no_pk', 'hrms_lettertemplatedtl.dyn_value_sl', 'hrms_lettertemplatedtl.dynamic_value_name', 'hrms_lettertemplatedtl.dynamic_value_sql_func', 'hrms_lettertemplatedtl.dynamic_value_desc')->where('hrms_lettertemplatedtl.lettertemp_no_fk', $lettertemp_no_fk)->orderBy('hrms_lettertemplatedtl.lettertempdtl_no_pk', 'asc')->get();
		// dd($parameter_data);
		return Template::loadView('admin.v1.hrm.templates.template-parameter', ['parameter_data' => $parameter_data, 'lettertemp_no_fk' => $lettertemp_no_fk, 'lettertemp_name' => $lettertemp_name, 'lettertemp_uid' => $lettertemp_uid]);
	}


	public function templateParameterStore(Request $request)
	{
		try {

			$sequence = DB::getSequence();

			if (isset($request->lettertempdtl_no_pk)) {
				$lettertempdtl_no_pk_seq = $request->lettertempdtl_no_pk;
			} else {
				$lettertempdtl_no_pk_seq  = $sequence->nextValue('lettertempdtl_no_pk_seq');
			}

			$dyn_value_sl             = $request->sl_no;
			$lettertemp_no_fk         = $request->lettertemp_no_fk;
			$dynamic_value_name       = $request->dynamic_value_name;
			$dynamic_value_sql_func   = $request->dynamic_value_sql_func;
			$dynamic_value_desc       = $request->dynamic_value_desc;

			$entry_session = Session()->get('user.ses_user_pk_no');
			$data = [
				"lettertempdtl_no_pk"        => $lettertempdtl_no_pk_seq,
				"lettertemp_no_fk"           => isset($lettertemp_no_fk) ? $lettertemp_no_fk : '',
				"dyn_value_sl"               => isset($dyn_value_sl) ? $dyn_value_sl : '',
				"dynamic_value_name"         => isset($dynamic_value_name) ? $dynamic_value_name : '',
				"dynamic_value_sql_func"     => isset($dynamic_value_sql_func) ? $dynamic_value_sql_func : '',
				"status"                     => 1,
				"dynamic_value_desc"         => isset($dynamic_value_desc) ? $dynamic_value_desc : '',
				"au_entry_by"                => auth::user()->user_no_pk,
				"au_entry_at"                =>  date('Y-m-d'),
				"au_entry_session"           => $entry_session,
				"au_entry_hospital_pk_no"    => Session::get('user.ses_hospital_no_pk'),
			];

			if (!isset($request->lettertempdtl_no_pk)) {

				DB::table("hrms_lettertemplatedtl")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

				DB::table("hrms_lettertemplatedtl")->where('lettertempdtl_no_pk', $request->lettertempdtl_no_pk)->update($data);
			}

			DB::commit();
			$message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}


	public function templateParameterDelete(Request $request)
	{
		DB::table('hrms_lettertemplatedtl')->where('lettertempdtl_no_pk', $request->lettertempdtl_no_pk)->delete();
		DB::commit();
		$message = ['msg' => 'Data remove successfully.', 'title' => 'Success'];
		return response()->json($message);
	}

	public function templatePrepare(Request $request)
	{
		$letters = DB::table('hrms_lettertemplate')->select('hrms_lettertemplate.lettertemp_no_pk', 'hrms_lettertemplate.lettertemp_name', 'hrms_lettertemplate.lettertemp_type')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

		$departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
		// dd($letters);
		return Template::loadView('admin.v1.hrm.templates.prepare-letter', ['letters' => $letters, 'departments' => $departments]);
	}


	public function getTemplateType(Request $request)
	{
		// dd($request->selected_value);
		$letter_type = DB::table('hrms_lettertemplate')->select('lettertemp_type', 'lettertemp_name', 'apply_for_letter_ind', 'apply_for_email_ind', 'apply_for_sms_ind')->where('lettertemp_no_pk', $request->selected_value)->first();
		// dd($letter_type);
		return response()->json($letter_type);
	}



	public function getApplicantList(Request $request)
	{
		$query = strtoupper($request->get('query'));
		// dd($query);
		$person_data = [];
		if ($request->letter_type != "Employee") {
			$person_datas = DB::table('hrms_applicant_cv')->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', 'hrms_applicant_cv.su_no_fk')->select('cvapplicant_no_pk', 'full_name', 'designation', 'sysc_serviceunit.serviceunit_name')->whereRaw(DB::raw("(upper(hrms_applicant_cv.full_name) like '%$query%')"))->get()->toArray();

			if (!empty($person_datas)) {
				foreach ($person_datas as $key => $value) {
					$person_data[] = (object) [
						'name' => $value->full_name,
						'id' => $value->cvapplicant_no_pk . 'c',
						'designation' => $value->designation,
						'serviceunit_name' => $value->serviceunit_name
					];
				}
			}
			// dd($person_datas, $person_data);
			// return response()->json($person_data);
		} else {
			$person_datas = DB::table('hrms_personnel')->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', 'hrms_personnel.serviceunit_no_fk')->select('hrms_personnel.person_no_pk', 'hrms_personnel.full_name', 'sysc_serviceunit.serviceunit_name')
				->whereRaw(DB::raw("(upper(hrms_personnel.full_name) like '%$query%')"))->get()->toArray();
			if (!empty($person_datas)) {
				foreach ($person_datas as $key => $value) {
					$person_data[] = (object) [
						'name' => $value->full_name,
						'id' => $value->person_no_pk . 'e',
						'designation' => '',
						'serviceunit_name' => $value->serviceunit_name
					];
				}
				// dd($person_datas, $person_data);
			}
		}

		// dd($person_data);
		return response()->json($person_data);
	}



	public function templateGenerateData(Request $request)
	{
		$name = $request->emp_name;
		$id   = $request->employee_id;
		$data = DB::table('hrms_lettertemplatedtl')
			->leftJoin('hrms_lettertemplate', 'hrms_lettertemplatedtl.lettertemp_no_fk', 'hrms_lettertemplate.lettertemp_no_pk')->select('dynamic_value_name', 'dynamic_value_sql_func', 'hrms_lettertemplate.lettertemp_type', 'hrms_lettertemplate.lettertemp_html_text')->where('lettertemp_no_fk', $request->lettertemp_no_pk)
			->get();

		$dynamicValueNames = [];
		$dynamicValueSqlFuncs = [];
		$func_data = [];

		foreach ($data as $key => $row) {
			try {
				$dynamicValueNames[$key] = $row->dynamic_value_name;

				$sqlFunc[$key] = str_replace('$id$', "$id", $row->dynamic_value_sql_func);

				// $dynamicValueSqlFuncs = DB::select(DB::raw("select pkg_letter_template.$sqlFunc[$key] as id from dual")); 
				$dynamicValueSqlFuncs = DB::select(DB::raw("select $sqlFunc[$key] as id from dual")); // DB::select(DB::raw("select $sqlFunc as id from dual"));
				$func_data[] = $dynamicValueSqlFuncs[0]->id;
			} catch (\Throwable $th) {
				//throw $th;
			}
		}
		// dd($dynamicValueSqlFuncs);

		$replace_data = str_replace($dynamicValueNames, $func_data, $data[0]->lettertemp_html_text);

		// dd($dynamicValueNames, $sqlFunc, $func_data, $replace_data);

		return response()->json($replace_data);
	}


	public function templateGeneratSave(Request $request)
	{
		// dd($request->all());
		try {

			$sequence = DB::getSequence();

			if (isset($request->letterissue_no_pk)) {
				$letterissue_no_pk_seq = $request->letterissue_no_pk;
			} else {
				$letterissue_no_pk_seq  = $sequence->nextValue('letterissue_no_pk_seq');
			}
			$letterissue_uid =  $this->getAutoGenerateUID("hrms_letterissue", "letterissue_uid");

			$entry_session = Session()->get('user.ses_user_pk_no');
			$data = [
				"letterissue_no_pk"           => $letterissue_no_pk_seq,
				"lettertemp_html_text"        => isset($request->signature) ? $request->signature : '',
				"letterissue_date"            => date('Y-m-d'),
				"lettertemp_no_fk"            => isset($request->lettertemp_no_pk) ? $request->lettertemp_no_pk : '',
				"lettertemp_type"             => isset($request->lettertemp_type) ? $request->lettertemp_type : '',
				"letterissue_uid"             => $letterissue_uid,
				"letterissue_by"              => auth::user()->user_no_pk,
				// "person_no_fk"                => isset($request->employee_id) ? $request->employee_id : '',
				"person_no_fk"                => isset($request->hdnIDforEmployee) ? $request->hdnIDforEmployee : '',
				"cvapplicant_no_fk"           => isset($request->hdnIDforCandidate) ? $request->hdnIDforCandidate : '',
				"lettertemp_name"             => isset($request->letter_name) ? $request->letter_name : '',
				"apply_for_letter_ind"        => $request->apply_for_letter_ind == '1' && !null ? 1 : 0,
				"apply_for_email_ind"         => $request->apply_for_email_ind == '1' && !null ? 1 : 0,
				"apply_for_sms_ind"           => $request->apply_for_sms_ind == '1' && !null ? 1 : 0,
				"status"                      => 1,
				// "dynamic_value_desc"         => isset($dynamic_value_desc) ? $dynamic_value_desc : '',
				"au_entry_by"                 => auth::user()->user_no_pk,
				"au_entry_at"                 =>  date('Y-m-d'),
				"au_entry_session"            => $entry_session,
				"au_entry_hospital_pk_no"     => Session::get('user.ses_hospital_no_pk'),
			];

			// dd($data['apply_for_letter_ind'], $data['apply_for_email_ind'], $data['apply_for_sms_ind']);
			// if (!isset($request->lettertempdtl_no_pk)) {

			DB::table("hrms_letterissue")->insert($data);
			// } else {
			// 	$data['au_update_by'] = auth::user()->user_no_pk;
			// 	$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
			// 	$data['au_update_at'] = date('Y-m-d');
			// 	$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

			// 	DB::table("hrms_lettertemplatedtl")->where('lettertempdtl_no_pk', $request->lettertempdtl_no_pk)->update($data);
			// }

			DB::commit();
			$message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
			return response()->json($message);
		} catch (\Throwable $th) {
			DB::rollback();
			$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
		}
	}



	public function templateGeneratePdf(Request $request)
	{
		// dd($request->letter_name);

		// delete previous pdf from folder
		// $folderPath = public_path('uploads/letter_template/');
		// $files = glob($folderPath . '*');

		// foreach ($files as $file) {
		// 	if (is_file($file)) {
		// 		unlink($file);
		// 	}
		// }

		$content = $request->signature;
		$letter_name = $request->letter_name;
		$po_hospital_details = DB::table("wsec_hospital")->first();

		// $pdf = PDF::loadView("admin.v1.hrm.templates.template-generate-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "content" => $content, "letter_name" => $letter_name])->setPaper('a4', 'portrait');
		$isPdf = true;
		return view("admin.v1.hrm.templates.template-generate-print", ["po_hospital_details" => $po_hospital_details, "content" => $content, "letter_name" => $letter_name, "isPdf" => $isPdf]);

		// $pdf->render();

		// for pdf preview
		// $pdfContent = $pdf->output();
		// $filename = 'generated_pdf.pdf';
		// $pdfFilePath = public_path('uploads/letter_template/') . $filename;
		// file_put_contents($pdfFilePath, $pdfContent);

		// return response()->json(['pdf' => $filename], 200);
		// return $pdf->stream('letter.pdf');
	}



	public function templatePreview()
	{
		// dd(request()->get('letterpreview'));
		$letterPreview = request()->get('letterpreview');
		$filePath = public_path('uploads/letter_template/') . $letterPreview;

		if (file_exists($filePath)) {
			return response()->file($filePath);
		} else {
			return response()->json(['message' => 'File not found'], 404);
		}
	}


	public function templateList(Request $request)
	{
		$letter_data = DB::table("hrms_lettertemplate")->select("lettertemp_no_pk", "lettertemp_name", "lettertemp_type", "lettertemp_uid", "status", "lettertemp_desc", "apply_for_letter_ind", "apply_for_email_ind", "apply_for_sms_ind")->get();

		return Template::loadView('admin.v1.hrm.templates.letter-list', ['letter_data' => $letter_data]);
	}

	public function searchTemplateList(Request $request)
	{
		// dd($request->lettertemp_no_pk);
		$data = DB::table("hrms_lettertemplate")->select("lettertemp_no_pk", "lettertemp_name", "lettertemp_type", "lettertemp_uid", "status", "lettertemp_desc", "apply_for_letter_ind", "apply_for_email_ind", "apply_for_sms_ind")->where("lettertemp_no_pk", $request->lettertemp_no_pk)->get();
		// dd($data);
		return Template::loadView('admin.v1.hrm.templates.letter-list-search-table', ['data' => $data]);
	}
}
