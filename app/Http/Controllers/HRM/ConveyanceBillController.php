<?php

namespace App\Http\Controllers\HRM;

use DB;
use QR;
use PDF;
use PDO;
use Auth;
use Session;
use DateTime;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Grade;
use App\Models\Doctor;
use App\Traits\ItemData;
use App\Library\Template;
use App\Models\DoctorFee;
use App\Traits\DoctorData;
use App\Traits\LookupData;
// use App\Repositories\DoctorRepository;
use App\Models\Designation;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Models\ChamberHospital;
use App\Traits\DatatablesLoader;
use function PHPSTORM_META\type;
use App\Http\Controllers\Storage;
use App\Models\MachineAttendance;
use App\Datatables\DataTableClass;
use App\Models\PatientRegistration;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Repositories\BaseRepository as Repo;

use Illuminate\Support\Facades\DB as FacadesDB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class ConveyanceBillController extends Controller
{
	use LookupData, DatatablesLoader, ItemData, DoctorData, UtilitiesTrait;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function urgentTransport(Request $request)
	{
		if ($request->type_value == "Urgent") {
			$urgentTransport = $this->getLookupListByCode("VEHICLENAME");
		} else {
			$user_id   = Session::get('user.ses_user_pk_no');
			$person_no = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

			$urgentTransports = DB::table('hrms_transport_eligibity_setup_vw')
								->where('person_no_pk', $person_no->person_no_fk)
								->select('hrms_transport_eligibity_setup_vw.transport_name', 'hrms_transport_eligibity_setup_vw.trans_lookup_no_fk')
								->get();
			$urgentTransport = [];
			if (!empty($urgentTransports)) {
				foreach ($urgentTransports as $key => $value) {
					$urgentTransport[$value->trans_lookup_no_fk] = $value->transport_name;
				}
			}
		}
		return response()->json($urgentTransport);
	}

	public function conveyanceBill(Request $request)
	{
		$purposes  = $this->getLookupListByCode("COVEYANCEPURPOSE");
		$user_id   = Session::get('user.ses_user_pk_no');
		$person_no = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

		$transport = DB::table('hrms_transport_eligibity_setup_vw')
						->where('person_no_pk', $person_no->person_no_fk)
						->select('hrms_transport_eligibity_setup_vw.*')
						->get();

		$location_thana    = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', 47)->orderBy("name", "asc")->get();
		$requested_by_name = DB::table('hrms_personnel')
								->select('wsec_user.user_fullname', 'hrms_personnel.person_no_pk', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name')
								->leftJoin('wsec_user', 'hrms_personnel.person_no_pk', 'wsec_user.person_no_fk')
								->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
								->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
								->where('wsec_user.user_no_pk', Session::get('user.ses_user_pk_no'))
								->first();
		$requested_by_id    = Session::get('user.ses_user_pk_no');
		$requested_by_dept  = Session::get('user.serviceunit');
		$requested_by_desig = Session::get('user.designation');

		return Template::loadView(
			'admin.uhl.conveyance_bill.create-conveyance-bill',
			[
				'requested_by_name' => $requested_by_name,
				'requested_by_dept' => $requested_by_dept,
				'requested_by_id'   => $requested_by_id,
				'purposes'          => $purposes,
				'location_thana'    => $location_thana,
				'transport'         => $transport
			]
		);
	}

	public function conveyanceBillSave(Request $request)
	{


		$sequence = DB::getSequence();
		if (isset($request->hdn_conveyancebillmst_no_pk)) {
			$conveyancebillmst_no_pk_seq = $request->hdn_conveyancebillmst_no_pk;
		} else {
			$conveyancebillmst_no_pk_seq = $sequence->nextValue('conveyancebillmst_no_pk_seq');
		}

		$billing_date = date("Y-m-d");
		if(!empty($request->billing_date)){
			$dateTime     = DateTime::createFromFormat('d/m/Y', $request->billing_date); 
 			$billing_date = $dateTime->format('Y-m-d'); 
		}

		$data = [
			"conveyancebillmst_no_pk" => $conveyancebillmst_no_pk_seq,
			"billing_date"            => $billing_date,
			"type_name"               => isset($request->type_name) ? $request->type_name : '',
			"req_by_person_no_fk"     => isset($request->req_by_person_no_fk_hdn) ? $request->req_by_person_no_fk_hdn : '',
			"total_bill_amount"       => isset($request->total_bill_amount) ? $request->total_bill_amount : '',
			"status"                  => 1,
			'conveyancebillmst_uid'   => $conveyancebillmst_no_pk_seq,
			"au_entry_by"             => auth::user()->user_no_pk,
			"au_entry_at"             => date('Y-m-d'),
			"au_entry_session"        => Session()->get('user.ses_user_pk_no'),
			"au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
		];

		if (isset($request->hdn_conveyancebillmst_no_pk)) {
			$temp = [];

			foreach ($request->conveyance_date as $key => $value) {
				$tmpimages = DB::table("acct_conveyancebilldtl")
							->select('attachment_name_01', 'attachment_name_02')
							->where("conveyancebilldtl_no_pk", $request->hdn_conveyancebilldtl_no_pk)
							->first();
				$img_data  = [
					'attachment_name_01' => isset($tmpimages->attachment_name_01) ? $tmpimages->attachment_name_01 : '',
					'attachment_name_02' => isset($tmpimages->attachment_name_02) ? $tmpimages->attachment_name_02 : ''
				];
				array_push($temp, $img_data);
			}

			DB::table("acct_conveyancebillmst")->where("conveyancebillmst_no_pk", $request->hdn_conveyancebillmst_no_pk)->update($data);
			$images = DB::table("acct_conveyancebilldtl")->select('attachment_name_01', 'attachment_name_02')->where("conveyancebillmst_no_fk", $request->hdn_conveyancebillmst_no_pk)->get();
			DB::table("acct_conveyancebilldtl")->where("conveyancebillmst_no_fk", $request->hdn_conveyancebillmst_no_pk)->delete();
		} else {
			DB::table("acct_conveyancebillmst")->insert($data);
			$ses_hospital_id       = Session::get('user.ses_hospital_no_pk');
			$au_entry_by           = auth::user()->user_no_pk;
			$au_entry_session      = Session()->get('user.ses_user_pk_no');
			$code                  = 'CONVEYANCE';
			$pdo                   = DB::getPdo();
			$rem                   = '';
			$out_apprprocess_no_pk = $out_apprprocess_uid = $out_error = '';

			$conveyance = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
				:in_approval_for_code,
				:in_primary_key_value,
				:in_primary_key_uid,
				:in_remarks,
				:in_au_entry_by,
				:in_au_entry_session,
				:in_au_entry_hospital_pk_no,
				:out_apprprocess_no_pk,
				:out_apprprocess_uid,
				:out_error); end;");

			$conveyance->bindParam(':in_approval_for_code', $code);
			$conveyance->bindParam(':in_primary_key_value', $conveyancebillmst_no_pk_seq);
			$conveyance->bindParam(':in_primary_key_uid', $conveyancebillmst_no_pk_seq);
			$conveyance->bindParam(':in_remarks', $rem);
			$conveyance->bindParam(':in_au_entry_by', $au_entry_by);
			$conveyance->bindParam(':in_au_entry_session', $au_entry_session);
			$conveyance->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
			$conveyance->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
			$conveyance->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 100000);
			$conveyance->bindParam(':out_error', $out_error, PDO::PARAM_STR, 100000);
			$conveyance->execute();

			if ($out_error == 000) {
				DB::commit();
			} else {
				DB::rollback();
			}
		}


		for ($i = 0; $i < count($request->conveyance_date); $i++) {

			if ($i > 0) {
				$conveyance_date = "";
				if(!empty($request->conveyance_date[$i])){
					$dateTime = DateTime::createFromFormat('d/m/Y', $request->conveyance_date[$i]);  // define date format from user
					$conveyance_date = $dateTime->format('Y-m-d'); // define expected format
				}

				$billmst_data = [
					"conveyancebilldtl_no_pk"       => intVal($sequence->nextValue('conveyancebilldtl_no_pk_seq')),
					"conveyancebillmst_no_fk"       => intVal($conveyancebillmst_no_pk_seq),
					"conveyance_date"               => $conveyance_date,
					"transport_name_lookup_data_fk" => isset($request->transport_name[$i]) ? $request->transport_name[$i] : '',
					"from_location" 		        => isset($request->from_location[$i]) ? $request->from_location[$i] : '',
					"to_location"   		        => isset($request->to_location[$i]) ? $request->to_location[$i] : '',
					"purpose_name"  		        => isset($request->purpose_name[$i]) ? $request->purpose_name[$i] : '',
					"description"                   => isset($request->description[$i]) ? $request->description[$i] : '',
					"remarks"                       => isset($request->remarks[$i]) ? $request->remarks[$i] : '',
					"trip_sl"                       => isset($request->trip_id[$i]) ? $request->trip_id[$i] : '',
					"amount"                        => intVal(isset($request->amount[$i]) ? $request->amount[$i] : 0),
					"status"                        => 1,
					"au_entry_by"                   => auth::user()->user_no_pk,
					"au_entry_at"                   =>  date('Y-m-d'),
					"au_entry_session"              => Session()->get('user.ses_user_pk_no'),
					"au_entry_hospital_pk_no"       => intVal(Session::get('user.ses_hospital_no_pk')),
				];

				if (isset($request->attachment_name_01[$i]) != null) {
					$fileName = time() . '.' . $request->attachment_name_01[$i]->extension();
					$request->attachment_name_01[$i]->move(public_path('uploads/conveyance_bill/'), $fileName);
					$billmst_data['attachment_name_01'] = $fileName;
				} else {
					if (isset($request->hdn_conveyancebilldtl_no_pk)) {
						$billmst_data['attachment_name_01'] = $temp[$i]['attachment_name_01'];
					}
				}

				if (isset($request->attachment_name_02[$i]) != null) {
					$fileName2 = '02'.time() . '.' . $request->attachment_name_02[$i]->extension();
					$request->attachment_name_02[$i]->move(public_path('uploads/conveyance_bill/'), $fileName2);
					$billmst_data['attachment_name_02'] = $fileName2;
				} else {
					if (isset($request->hdn_conveyancebilldtl_no_pk)) {
						$billmst_data['attachment_name_02'] = $temp[$i]['attachment_name_02'];
					}
				}

				DB::table("acct_conveyancebilldtl")->insert($billmst_data);
			}
		}

		$message = ['msg' => 'Conveyance Bill Saved Successfully.', 'title' => 'Success'];
		return response()->json($message);
	}


	public function conveyanceBillWorklist(Request $request)
	{
		$user_id      = Session::get('user.ses_user_pk_no');
		$person_no_fk = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();
		$data         = DB::table('acct_conveyancebillmst')
						->select('acct_conveyancebillmst.*', 'acct_conveyancebillmst_vw.approval_status_text', 'acct_conveyancebillmst_vw.approval_level_status_text', 'acct_conveyancebillmst_vw.conv_paid_ind', 'acct_conveyancebillmst_vw.conveyancebillmst_no_pk')
						->leftJoin('acct_conveyancebillmst_vw', 'acct_conveyancebillmst.conveyancebillmst_no_pk', '=', 'acct_conveyancebillmst_vw.conveyancebillmst_no_pk')
						->where('acct_conveyancebillmst.req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->distinct('acct_conveyancebillmst.conveyancebillmst_no_pk')
						->orderBy('acct_conveyancebillmst.billing_date', 'desc')
						->get();
		return Template::loadView('admin.uhl.conveyance_bill.conveyance-bill-worklist', ['data' => $data]);
	}


	public function conveyanceBillSearch(Request $request)
	{
		$user_id      = Session::get('user.ses_user_pk_no');
		$person_no_fk = DB::table('wsec_user')
						->select('person_no_fk')
						->where('user_no_pk', $user_id)
						->first();

		if (isset($request->from_date) && isset($request->to_date)) {
			$search_data = DB::table("acct_conveyancebillmst")
							->select('acct_conveyancebillmst.*',
								'acct_conveyancebillmst_vw.approval_status_text',
								'acct_conveyancebillmst_vw.approval_level_status_text')
							->leftJoin('acct_conveyancebillmst_vw', 'acct_conveyancebillmst.conveyancebillmst_no_pk', '=', 'acct_conveyancebillmst_vw.conveyancebillmst_no_pk')
							->where(DB::raw('trunc(acct_conveyancebillmst.billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
							->where(DB::raw('trunc(acct_conveyancebillmst.billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
							->where('acct_conveyancebillmst.req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
							->distinct('acct_conveyancebillmst.conveyancebillmst_no_pk')
							->get();
		}

		return Template::loadView('admin.uhl.conveyance_bill.conveyance-bill-worklist-search', ['search_data' => $search_data]);
	}

	public function conveyanceBillPdf(Request $request)
	{
		$user_id      = Session::get('user.ses_user_pk_no');
		$person_no_fk = DB::table('wsec_user')
						->select('person_no_fk')
						->where('user_no_pk', $user_id)
						->first();

		if (isset($request->from_date) && isset($request->to_date)) {
			$data = DB::table("acct_conveyancebillmst_vw")->select("acct_conveyancebillmst_vw.*")
			            ->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
						->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
						->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->get();
		} else {
			$data = DB::table('acct_conveyancebillmst_vw')
					->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
					->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.conveyance_bill.conveyancebill-worklist-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "data" => $data])->setPaper('a4', 'potrait');
		return $pdf->stream('conveyancebill.pdf');
	}


	public function conveyanceBillExcel(Request $request)
	{
		$user_id      = Session::get('user.ses_user_pk_no');
		$person_no_fk = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

		if (isset($request->from_date) && isset($request->to_date)) {
			$data = DB::table("acct_conveyancebillmst_vw")->select("acct_conveyancebillmst_vw.*")
						->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
						->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
						->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->get();
		} else {
			$data = DB::table('acct_conveyancebillmst_vw')
						->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		$pdf                 =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data];
		$fileToExport        = "conveyancebill";
		$html                = View("admin.uhl.conveyance_bill.conveyancebill-worklist-excel")->with($pdf);
		header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
		header("Content-type: application/vnd.ms-excel");
		return $html;
	}


	public function conveyanceBillFinancePdf(Request $request)
	{
		$isPaid = $request->paid;
		$query = DB::table('acct_conveyancebillmst_vw as a')
				->join('hrms_personnel as emp', 'a.req_by_person_no_fk', '=', 'emp.person_no_pk')
				->join('hrms_designation as deg', 'deg.designation_no_pk', '=', 'emp.jobtitle_lookup_no_fk')
				->groupBy('a.req_by_person_no_fk', 'a.conv_paid_ind', 'a.approval_status_text', 'a.approval_level_status_text', 'full_name', 'person_code', 'serviceunit_no_fk', 'jobtitle_lookup_no_fk', 'serviceunit_no_fk_dept', 'designation_name')
				->select(
					'a.req_by_person_no_fk',
					'a.approval_status_text',
					'a.approval_level_status_text',
					'a.conv_paid_ind',
					'full_name',
					'person_code',
					DB::raw('fnc_serviceunitname(serviceunit_no_fk) as unit'),
					DB::raw('fnc_serviceunitname(serviceunit_no_fk_dept) as dept'),
					'jobtitle_lookup_no_fk',
					'designation_name',
					DB::raw('SUM(amount) as conv_amt')
				)
				->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
				->whereRaw("approval_status_text NOT LIKE '%HOLD%'")
				->whereRaw("approval_status_text NOT LIKE '%PENDING%'");

		if ($request->paid != "" && $request->from_date != "" && $request->to_date != "") {

			if ($request->paid == "0") {
				$search_data = $query->whereRaw("NVL(a.conv_paid_ind, 0) = 0")
								->where('a.approval_level_status_text', '2/2')
								->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
								->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
								->get();
			} else {
				$search_data = $query->where('a.conv_paid_ind', '=', 1)
								->where('a.approval_level_status_text', '2/2')
								->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
								->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
								->get();
			}
		} elseif (isset($request->paid)) {
			if ($request->paid == "0") {
				$search_data = $query->whereRaw("NVL(a.conv_paid_ind, 0) = 0")->get();
			} else {
				$search_data = $query->where('a.conv_paid_ind', 1)->get();
			}
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.conveyance_bill.conveyancebill-finance-worklist-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "search_data" => $search_data, 'isPaid' => $isPaid, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->setPaper('a4', 'potrait');
		return $pdf->stream('conveyancebill.pdf');
	}


	public function conveyanceBillFinanceDetailsReport(Request $request)
	{
		if ($request->from_date != "" && $request->to_date != "") {
			$search_data = DB::select("select conveyancebillmst_no_pk, billing_date, req_by_person_no_fk, full_name, person_code,  fnc_serviceunitname(serviceunit_no_fk) as unit,
							fnc_serviceunitname(serviceunit_no_fk_dept) as dept,  designation_name, sum(amount) as conv_amt 
							from acct_conveyancebillmst_vw a join hrms_personnel emp on a.req_by_person_no_fk = emp.person_no_pk
							left join hrms_designation deg on emp.jobtitle_lookup_no_fk =deg.designation_no_pk where trunc(billing_date) between to_date('$request->from_date', 'dd/mm/yyyy') and to_date('$request->to_date', 'dd/mm/yyyy')
							and a.conv_paid_ind = 1 group by conveyancebillmst_no_pk, billing_date, req_by_person_no_fk, full_name, person_code, conv_paid_ind, serviceunit_no_fk, serviceunit_no_fk_dept, jobtitle_lookup_no_fk, designation_name
							order by full_name,billing_date");
		}
		$search_data_arr = [];
		if (!empty($search_data)) {
			foreach ($search_data as $key => $value) {
				$search_data_arr[$value->full_name . '*' . $value->req_by_person_no_fk][] = $value;
			}
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.conveyance_bill.conveyancebill-finance-details-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "search_data_arr" => $search_data_arr, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->setPaper('a4', 'potrait');
		return $pdf->stream('conveyancebill.pdf');
	}


	public function conveyanceBillFinanceExcel(Request $request)
	{
		$user_id      = Session::get('user.ses_user_pk_no');
		$person_no_fk = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

		if (isset($request->from_date) && isset($request->to_date)) {
			$data = DB::table("acct_conveyancebillmst_vw")->select("acct_conveyancebillmst_vw.*")
						->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
						->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
						->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->get();
		} else {
			$data = DB::table('acct_conveyancebillmst_vw')
						->where('req_by_person_no_fk', '=', $person_no_fk->person_no_fk)
						->get();
		}

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		$pdf                 = ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data];
		$fileToExport        = "conveyancebill";
		$html                = View("admin.uhl.conveyance_bill.conveyancebill-worklist-excel")->with($pdf);
		header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
		header("Content-type: application/vnd.ms-excel");
		return $html;
	}

	public function conveyanceBillUpdate($bill_id = "")
	{
		$requested_by_name = DB::table('hrms_personnel')
							->select('wsec_user.user_fullname', 'hrms_personnel.person_no_pk', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name')
							->leftJoin('wsec_user', 'hrms_personnel.person_no_pk', 'wsec_user.person_no_fk')
							->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
							->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
							->where('wsec_user.user_no_pk', Session::get('user.ses_user_pk_no'))
							->first();

				$user_id   = Session::get('user.ses_user_pk_no');
				$person_no = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

				$transport = DB::table('hrms_transport_eligibity_setup_vw')
								->where('person_no_pk', $person_no->person_no_fk)
								->select('hrms_transport_eligibity_setup_vw.*')
								->get();
		$purposes          = $this->getLookupListByCode("COVEYANCEPURPOSE");
		$requested_by_id   = Session::get('user.ses_user_pk_no');
		$requested_by_dept = Session::get('user.serviceunit');
		$location_thana    = DB::table('sysc_upazilas')
								->select('id', 'name', 'district_id')
								->where('district_id', 47)
								->orderBy("name", "asc")
								->get();
		$conv_mst          = DB::table('acct_conveyancebillmst')
								->select('acct_conveyancebillmst.total_bill_amount', 'acct_conveyancebillmst.conveyancebillmst_no_pk', 'acct_conveyancebillmst.type_name')
								->where('conveyancebillmst_no_pk', $bill_id)
								->first();

		$conv_details = DB::table('acct_conveyancebilldtl')
						->select('acct_conveyancebilldtl.*', 'acct_conveyancebillmst_vw.approval_status_text', 'acct_conveyancebillmst_vw.approval_level_status_text')
						->leftJoin('acct_conveyancebillmst_vw', 'acct_conveyancebilldtl.conveyancebillmst_no_fk', '=', 'acct_conveyancebillmst_vw.conveyancebillmst_no_fk')
						->where('acct_conveyancebilldtl.conveyancebillmst_no_fk', $bill_id)
						->orderBy('acct_conveyancebilldtl.trip_sl', 'asc')
						->distinct('acct_conveyancebillmst_vw.conveyancebillmst_no_fk')
						->get();
		return Template::loadView(
			'admin.uhl.conveyance_bill.create-conveyance-bill',
			[
				'requested_by_name' => $requested_by_name,
				'requested_by_dept' => $requested_by_dept,
				'requested_by_id'   => $requested_by_id,
				'purposes'          => $purposes,
				'conv_mst'          => $conv_mst,
				'conv_details'      => $conv_details,
				'location_thana'    => $location_thana,
				'transport'         => $transport,

			]);
	}


	public function conveyanceBillView($id = "")
	{
		$view_data = DB::table('acct_conveyancebilldtl')->select('*')->where('conveyancebillmst_no_fk', $id)
			->get()
			->map(function ($item) {
				unset(
					$item->au_entry_by,
					$item->au_entry_at,
					$item->au_entry_session,
					$item->au_entry_hospital_pk_no,
					$item->au_update_by,
					$item->au_update_at,
					$item->au_update_session,
					$item->au_update_hospital_pk_no,
					$item->au_sync_hospital_pk_no,
					$item->au_sync_at
				);
				return $item;
			});

		foreach ($view_data as $key => $value) {

					$purpose_name   = DB::table('sysc_lookupdata')
										->select('lookupdata_name')
										->where('lookupdata_no_pk', $value->purpose_lookupdata_no_fk)
										->first();

					$transport_name = DB::table('sysc_lookupdata')
										->select('lookupdata_name')
										->where('lookupdata_no_pk', $value->transport_name_lookup_data_fk)
										->first();

					$from_location = DB::table('sysc_upazilas')
										->select('name')
										->where('id', $value->from_location_lookup_data_fk)
										->first();
					$to_location   = DB::table('sysc_upazilas')
										->select('name')
										->where('id', $value->to_location_lookup_data_fk)
										->first();
			$value->purpose_name   = !empty($purpose_name) ? $purpose_name->lookupdata_name : '';
			$value->transport_name = !empty($transport_name) ? $transport_name->lookupdata_name : '';
			$value->from_location  = !empty($from_location) ? $from_location->name : '';
			$value->to_location    = !empty($to_location) ? $to_location->name : '';
		}
		return Template::loadView('admin.uhl.conveyance_bill.view-conveyance-bill', ['view_data' => $view_data]);
	}



	public function conveyanceBillViewFinance($id = "", $from = "", $to = "", $isPaid)
	{
		$view_data = DB::table('acct_conveyancebillmst_vw as a')
					->join('hrms_personnel as emp', 'a.req_by_person_no_fk', '=', 'emp.person_no_pk')
					->join('hrms_designation as deg', 'deg.designation_no_pk', '=', 'emp.jobtitle_lookup_no_fk')
					->select('conveyancebillmst_no_pk', 'billing_date', 'req_by_person_no_fk',
						'full_name', 'person_code', 'conv_paid_ind', 'attachment_name_01','attachment_name_02',
						DB::raw('fnc_serviceunitname(serviceunit_no_fk) as unit'),
						DB::raw('fnc_serviceunitname(serviceunit_no_fk_dept) as dept'),
						'jobtitle_lookup_no_fk',
						'designation_name',
						DB::raw('SUM(amount) as conv_amt'))
					->groupBy('conveyancebillmst_no_pk', 'billing_date', 'req_by_person_no_fk', 'full_name', 'person_code',
						'conv_paid_ind', 'serviceunit_no_fk', 'serviceunit_no_fk_dept', 'jobtitle_lookup_no_fk','designation_name',
						'attachment_name_01','attachment_name_02')
					->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
					->whereRaw("approval_status_text NOT LIKE '%HOLD%'")
					->whereRaw("approval_status_text NOT LIKE '%PENDING%'")
					->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($from)))
					->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($to)))
					->where('req_by_person_no_fk', '=', $id);

		if ($isPaid == "0") {
			$view_data = $view_data->whereRaw("NVL(a.conv_paid_ind, 0) = 0")->get();
		} else {
			$view_data = $view_data->where('a.conv_paid_ind', 1)->get();
		}
		return Template::loadView('admin.uhl.conveyance_bill.view-conveyance-bill-finance', ['view_data' => $view_data]);
	}

	public function conveyanceBillReport($id = "")
	{
		ini_set('max_execution_time', 0);
		$report_data = DB::table('acct_conveyancebilldtl')->select('*')->where('conveyancebillmst_no_fk', $id)
			->orderBy('trip_sl', 'asc')
			->get()
			->map(function ($item) {
				unset(
					$item->au_entry_by,
					$item->au_entry_at,
					$item->au_entry_session,
					$item->au_entry_hospital_pk_no,
					$item->au_update_by,
					$item->au_update_at,
					$item->au_update_session,
					$item->au_update_hospital_pk_no,
					$item->au_sync_hospital_pk_no,
					$item->au_sync_at
				);
				return $item;
			});
		$totalAmount = $report_data->sum('amount');

		foreach ($report_data as $key => $value) {

			$transport_name = DB::table('sysc_lookupdata')
								->select('lookupdata_name')
								->where('lookupdata_no_pk', $value->transport_name_lookup_data_fk)
								->first();

			$value->transport_name = !empty($transport_name) ? $transport_name->lookupdata_name : '';
		}

		$req_by         = DB::table('acct_conveyancebillmst_vw')->select('req_by_name', 'conveyancebillmst_uid')->where('conveyancebillmst_no_pk', $id)->first();

		$signature_data = DB::table('sysc_approvalprocess_vw')
							->distinct('ent.person_no_fk')
							->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'ent_desig.designation as ent_designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.user_fullname_ent', DB::raw('trunc(sysc_approvalprocess_vw.approved_at) as approved_at'), 'sysc_approvalprocess_vw.person_no_fk','ent_img.doctor_signature_image as ent_img')
							->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')							
							->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
							->leftJoin('wsec_user ent', 'ent.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk_ent')
							->leftJoin('employee_info_vw as ent_img', 'ent_img.person_no_pk', 'ent.person_no_fk')
							->leftJoin('employee_info_vw ent_desig', 'ent_desig.person_no_pk', 'ent.person_no_fk')
							->where('sysc_approvalprocess_vw.primary_key_value', $id)
							->where('sysc_approvalprocess_vw.approval_for_code', 'CONVEYANCE')
							->get();
		// dd($signature_data);
		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		$userInfo            = Auth::user();
		
		$pdf     = PDF::loadView("admin.uhl.conveyance_bill.conveyancebill-report-print", ["type" => "pdf", "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "report_data" => $report_data, 'totalAmount' => $totalAmount, 'req_by' => $req_by, 'signature_data' => $signature_data])->setPaper('a4', 'potrait');
		$dom_pdf = $pdf->getDomPDF();
        $canvas  = $dom_pdf->get_canvas();
        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));
		return $pdf->stream('conveyancebill.pdf', array("Attachment" => false));
	}


	public function conveyanceBillApprovalWorklist()
	{

		$data = DB::table('acct_conveyancebillmst_vw as a')
					->join('hrms_personnel as emp', 'a.req_by_person_no_fk', '=', 'emp.person_no_pk')
					->join('hrms_designation as deg', 'deg.designation_no_pk', '=', 'emp.jobtitle_lookup_no_fk')
					->whereRaw("NVL(a.conv_paid_ind, 0)= 0")
					->where('billing_date', '>=', DB::raw('sysdate - 7'))
					->where('a.approval_level_status_text', '2/2')
					->groupBy('a.req_by_person_no_fk', 'full_name', 'person_code', 'serviceunit_no_fk', 'jobtitle_lookup_no_fk', 'serviceunit_no_fk_dept', 'designation_name')
					->select('a.req_by_person_no_fk', 'full_name', 'person_code',
						DB::raw('fnc_serviceunitname(serviceunit_no_fk) as unit'),
						DB::raw('fnc_serviceunitname(serviceunit_no_fk_dept) as dept'),
						'jobtitle_lookup_no_fk',
						'designation_name',
						DB::raw('SUM(amount) as conv_amt')
					)
					->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
					->whereRaw("approval_status_text NOT LIKE '%HOLD%'")
					->whereRaw("approval_status_text NOT LIKE '%PENDING%'")
					->get();
		return Template::loadView('admin.uhl.conveyance_bill.conveyance-billapproval-worklist', ['data' => $data]);
	}

	public function conveyanceBillApprovalSearch(Request $request)
	{
		$from   = $request->from_date;
		$to     = $request->to_date;
		$isPaid = $request->paid;

		$query = DB::table('acct_conveyancebillmst_vw as a')
					->join('hrms_personnel as emp', 'a.req_by_person_no_fk', '=', 'emp.person_no_pk')
					->join('hrms_designation as deg', 'deg.designation_no_pk', '=', 'emp.jobtitle_lookup_no_fk')
					->groupBy('a.req_by_person_no_fk', 'full_name', 'person_code', 'serviceunit_no_fk', 'jobtitle_lookup_no_fk', 'serviceunit_no_fk_dept', 'designation_name')
					->select(
						'a.req_by_person_no_fk',
						'full_name',
						'person_code',
						DB::raw('fnc_serviceunitname(serviceunit_no_fk) as unit'),
						DB::raw('fnc_serviceunitname(serviceunit_no_fk_dept) as dept'),
						'jobtitle_lookup_no_fk',
						'designation_name',
						DB::raw('SUM(amount) as conv_amt')
					)
					->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
					->whereRaw("approval_status_text NOT LIKE '%HOLD%'")
					->whereRaw("approval_status_text NOT LIKE '%PENDING%'");

		if ($request->paid != "" && $request->from_date != "" && $request->to_date != "") {

			if ($request->paid == "0") {
				$search_data = $query->whereRaw("NVL(a.conv_paid_ind, 0) = 0")
								->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
								->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
								->get();
			} else {
				$search_data = $query->where('a.conv_paid_ind', '=', 1)
								->where(DB::raw('trunc(billing_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
								->where(DB::raw('trunc(billing_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
								->get();
			}
		} elseif (isset($request->paid)) {
			if ($request->paid == "0") {
				$search_data = $query->whereRaw("NVL(a.conv_paid_ind, 0) = 0")->get();
			} else {
				$search_data = $query->where('a.conv_paid_ind', 1)->get();
			}
		}
		return Template::loadView('admin.uhl.conveyance_bill.conveyance-billapproval-search-worklist', ['search_data' => $search_data, 'from' => $from, 'to' => $to, 'isPaid' => $isPaid]);
	}

	public function conveyanceBillPayment(Request $request)
	{
		$id = $request->id;
		return Template::loadView('admin.uhl.conveyance_bill.conveyance_bill_payment', ['id' => $id]);
	}


	public function conveyanceBillPaymentUpdate(Request $request)
	{
		$currentDateTime = Carbon::now();
		$au_entry_at     = $currentDateTime->format('Y-m-d H:i:s');
		try {
			$ids = [];
			foreach ($request->IsPaidCheckbox as $d) {
				$ids[] = $d;
			}
			DB::table('acct_conveyancebillmst')
				->whereIn('conveyancebillmst_no_pk', $ids)
				->update(
					[
						'conv_paid_ind' => 1,
						'conv_paid_by' => Auth::id(),
						'conv_paid_at' => $au_entry_at,
						'conv_paid_remarks' => $request->payment_remark ? $request->payment_remark : "",
					]
				);

			$message = ['msg' => 'Payment successfully', 'title' => 'Success'];
			DB::commit();
			return response()->json($message);
		} catch (\Exception $e) {
			$message = ['msg' => ' Failled.', 'title' => 'Error'];
			DB::rollback();
			return response()->json($message);
		}
	}

	public function ApprovalTrackingforConveyance($id = "")
	{
		$approval_matrix_id = $id;
		$loginUser          = Session()->get('user.ses_person_no_fk');
		$hospital_pk_no     = session()->get('user.ses_hospital_no_pk');

		$leveldetailInfo = DB::table('sysc_approvalprocess_vw')
							->select("status_text")
							->where("primary_key_value", $approval_matrix_id)
							->where("approval_for_code", "CONVEYANCE")
							->where("au_entry_hospital_pk_no", $hospital_pk_no)
							->first();

		return Template::loadView("admin.v1.hrm.employee_portal.approval-tracking-leave-application", [
			'leveldetailInfo' => $leveldetailInfo
		]);
	}
}
