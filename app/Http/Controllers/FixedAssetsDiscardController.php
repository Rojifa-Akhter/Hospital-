<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App;
use App\Datatables\DataTableClass;
use App\Library\Template;
use App\Traits\UtilitiesTrait;
use Auth;
use App\Traits\LookupData;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;
use PDO;
use \PDF;
use Session;
use Carbon\Carbon;

class FixedAssetsDiscardController extends Controller
{
	use UtilitiesTrait;

	public function FixedAssetsDiscard(Request $request)
	{
		$tag = DB::table('fas_assetregister_full_vw')->select('fas_assetregister_full_vw.*')->get();
		$sequence = DB::getSequence();
		$discard_no_pk = $sequence->nextValue('discard_no_pk_seq');
		// dd($tag);
		return Template::loadView("admin.uhl.fixed_assets.fixed-asset-discard", [
			'tag' => $tag,
			'discard_no_pk' => $discard_no_pk
		]);
	}

	public function searchTagInfo(Request $request)
	{
		$tag_info_find = DB::table('fas_assetregister_full_vw')->where('asset_tag_uid', $request->assetTagId)->first();
		return response()->json($tag_info_find);
	}

	public function fixedAssetsDiscardStore(Request $request)
	{
		$sequence = DB::getSequence();
		$entry_session = Session()->get('user.ses_user_pk_no');
		// $discard_no_pk = $sequence->nextValue('discard_no_pk_seq');
		$discard_uid =  $this->getAutoGenerateUID("fas_discard", "discard_uid");
		$auth_id = Auth::id();
		$ses_hospital_id = Session::get('user.ses_hospital_no_pk');

		try {
			$data = [
				'discard_no_pk' => $request->discard_no,
				'discard_uid' => $discard_uid,
				'discard_date' => isset($request->discard_date) ? date('Y-m-d', strtotime($request->discard_date)) : '',
				'asset_tag_uid' => $request->asset_tag_uid,
				'discard_reasons' => isset($request->discard_reasons) ? $request->discard_reasons : '',
				'sales_to_text' => isset($request->sales_to_text) ? $request->sales_to_text : '',
				'sales_price' => isset($request->sales_price) ? $request->sales_price : '',
				'sales_qty' => isset($request->sales_qty) ? $request->sales_qty : '',
				'discard_final_remarks' => isset($request->discard_final_remarks) ? $request->discard_final_remarks : '',
				'ast_register_no_fk' => isset($request->ast_register_no_fk) ? $request->ast_register_no_fk : '',
				'discard_cost_price' => isset($request->cost_balance) ? $request->cost_balance : '',
				'status' => 1,
				// 'au_entry_by' => $auth_id,
				'au_entry_by' => $request->emp_id,
				'au_entry_at' => date('Y-m-d'),
				'au_entry_session' => $entry_session,
				'au_entry_hospital_pk_no' => $ses_hospital_id
			];

			if (isset($request->discarded_item_pic)) {
				$fileName = time() . '.' . $request->discarded_item_pic->extension();
				$request->discarded_item_pic->move(public_path('images/uploads/discardImages/'), $fileName);
				$data['discarded_item_pic'] =   $fileName;
			}

			if (isset($request->discard_auth_letter_pic)) {
				$fileName1 = time() . '.' . $request->discard_auth_letter_pic->extension();
				$request->discard_auth_letter_pic->move(public_path('images/uploads/discardImages/'), $fileName1);
				$data['discard_auth_letter_pic'] =   $fileName1;
			}

			if (!isset($request->hidden_id)) {
				db::table("fas_discard")->insert($data);
			} else {
				$data['au_update_by'] = auth::user()->user_no_pk;
				$data['au_update_session'] = Session()->get('user.ses_user_pk_no');
				$data['au_update_at'] = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
				db::table("fas_discard")->where('fas_discard_no_pk', $request->hidden_id)->update($data);
			}

			DB::commit();

			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $e) {
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
		}

		return response()->json($message);
	}

	public function fixedAssetsDiscardWorklist(Request $request)
	{
		$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->get();
		// dd($discard_data);
		return Template::loadView('admin.uhl.fixed_assets.fixed-assets-discard-worklist', ['discard_data' => $discard_data]);
	}

	public function fixedAssetsDiscardItemPrint($id = "")
	{
		PDF::setOptions(['isPhpEnabled', 'true']);
		$po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

		$userInfo = Auth::user();
		$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->leftJoin('sysc_serviceunit', 'fas_assetregister_full_vw.main_store_su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('hrms_personnel', 'fas_discard.au_entry_by', 'hrms_personnel.person_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk', 'sysc_serviceunit.serviceunit_name', 'hrms_personnel.full_name')->where('discard_no_pk', $id)->get();
		// dd($discard_data);
		$pdf = App::make('dompdf.wrapper');

		$pdf = PDF::loadView(
			'admin.uhl.fixed_assets.fixed-asset-discard-item-pdf',
			[
				'po_hospital_details' => $po_hospital_details,
				'userInfo' => $userInfo,
				'discard_data' => $discard_data
			]
		);
		return $pdf->stream("DISCARD_REPORT.pdf", array("Attachment" => false));
	}

	public function searchDiscardFixedAsset(Request $request)
	{
		$discard_uid  = $request->discard_uid;
		$asset_tag    = $request->asset_tag;
		$item_name    = $request->item_name;
		$date_from    = $request->date_from;
		$date_to      = $request->date_to;

		if ($discard_uid) {
			$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->where('discard_uid', $discard_uid)->get();
		}

		if ($item_name) {
			$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->where('item_name', $item_name)->get();
		}

		if ($asset_tag) {
			$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->where('fas_assetregister_full_vw.asset_tag_uid', $asset_tag)->get();
		}

		if ($date_from != "" && $date_to != "") {

			$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->whereBetween(DB::raw('trunc(discard_date)'), [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))])->get();
		} elseif ($date_from != "") {
			$discard_data = DB::table('fas_discard')->leftJoin('fas_assetregister_full_vw', 'fas_discard.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')->select('fas_discard.*', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_name', 'fas_assetregister_full_vw.ast_register_uid', 'fas_assetregister_full_vw.item_no_fk')->whereDate('discard_date', date('Y-m-d', strtotime($date_from)))->get();
		}

		return Template::loadView('admin.uhl.fixed_assets.fixed-asset-discard-worklist-search-table', ['discard_data' => $discard_data]);
	}
}
