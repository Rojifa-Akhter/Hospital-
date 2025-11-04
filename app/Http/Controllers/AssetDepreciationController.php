<?php
namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssetDepreciationController extends Controller
{
    public function index()
    {
        $categories = DB::table('fas_asset_dep_vw')
            ->select('catagory', 'catagory_no_fk')
            ->distinct()
            ->get();

        $sub_categories = DB::table('fas_asset_dep_vw')
            ->select('sub_catagory', 'itemtype_no_pk')
            ->distinct()
            ->get();

        $asset_depreciations = DB::table('fas_asset_dep_vw')
            ->select([
                'depreciation_percentage',
                'ast_register_no_pk',
                'ast_register_uid',
                'catagory',
                'catagory_no_fk',
                'grn_date',
                'grn_no',
                'itemtype_no_pk',
                'item_name',
                'location',
                'months',
                'per_month',
                'already_dep_amt',
                'last_dep_date',
                'po_no',
                'qty',
                'rate',
                'sub_catagory',
                'supplier_name',
                'tag_ud',
            ])
            ->get();

        // dd($asset_depreciations);

        return Template::loadView('admin.accounts.asset_depreciation.index', compact('categories', 'sub_categories', 'asset_depreciations'));
    }

    public function assetDepreciationsSearch(Request $request)
    {
        $query = DB::table('fas_asset_dep_vw')
            ->select([
                'depreciation_percentage',
                'ast_register_no_pk',
                'ast_register_uid',
                'catagory',
                'catagory_no_fk',
                'grn_date',
                'grn_no',
                'itemtype_no_pk',
                'item_name',
                'location',
                'months',
                'per_month',
                'already_dep_amt',
                'last_dep_date',
                'po_no',
                'qty',
                'rate',
                'sub_catagory',
                'supplier_name',
                'tag_ud',
            ]);

        if ($request->category_id) {
            $query->where('catagory_no_fk', $request->category_id);
        }
        if ($request->sub_category_id) {
            $query->where('itemtype_no_pk', $request->sub_category_id);
        }

        $asset_depreciations = $query->get();

        return Template::loadView("admin.accounts.asset_depreciation.asset_depreciation_list", compact('asset_depreciations'));
    }

    public function getSubCategoryByCategory(Request $request)
    {
        $sub_categories = DB::table('fas_asset_dep_vw')
            ->where('catagory_no_fk', $request->category_id)
            ->select('sub_catagory', 'itemtype_no_pk')
            ->distinct()
            ->get();

        return response()->json(['sub_categories' => $sub_categories]);
    }

    public function assetDepreciationsSave(Request $request)
    {
        DB::beginTransaction();

        try {
            $au_entry_by             = Auth::id();
            $au_entry_at             = date('Y-m-d H:i:s');
            $au_entry_session        = Session::get('user.ses_user_pk_no');
            $au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $assetDepreciations      = $request->assets;

            $masterId = DB::getSequence()->nextValue('assetdepmst_no_pk_seq');

            DB::table('fas_assetdepmst')->insert([
                'assetdepmst_no_pk'       => $masterId,
                'tran_date'               => date('Y-m-d'),
                'dep_amount'              => floatval(str_replace(',', '', $request->total_amount)),
                'status'                  => 1,
                'au_entry_by'             => $au_entry_by,
                'au_entry_at'             => $au_entry_at,
                'au_entry_session'        => $au_entry_session,
                'au_entry_hospital_pk_no' => $au_entry_hospital_pk_no,
            ]);

            foreach ($assetDepreciations as $asset) {
                DB::table('fas_assetdepdtl')->insert([
                    'assetdepdtl_no_pk'       => DB::getSequence()->nextValue('assetdepdtl_no_pk_seq'),
                    'assetdepmst_no_fk'       => $masterId,
                    'ast_register_no_fk'      => $asset['register_no'],
                    'amount'                  => floatval(str_replace(',', '', $asset['per_month'])),
                    'status'                  => 1,
                    'au_entry_by'             => $au_entry_by,
                    'au_entry_at'             => $au_entry_at,
                    'au_entry_session'        => $au_entry_session,
                    'au_entry_hospital_pk_no' => $au_entry_hospital_pk_no,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Asset depreciations saved successfully.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save asset depreciations',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function assetDepreciationsMaster()
    {
        $assetDepreciationMasters = DB::table('fas_assetdepmst')
        // ->select([
        //     'depreciation_percentage',
        //     'ast_register_no_pk',
        //     'ast_register_uid',
        //     'catagory',
        //     'catagory_no_fk',
        //     'grn_date',
        //     'grn_no',
        //     'itemtype_no_pk',
        //     'item_name',
        //     'location',
        //     'months',
        //     'per_month',
        //     'already_dep_amt',
        //     'last_dep_date',
        //     'po_no',
        //     'qty',
        //     'rate',
        //     'sub_catagory',
        //     'supplier_name',
        //     'tag_ud',
        // ])
            ->get();

        // dd($assetDepreciationMasters);
        return Template::loadView("admin.accounts.asset_depreciation.asset_depreciation_master", compact('assetDepreciationMasters'));
    }

    public function assetDepreciationsExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $asset_depreciations = DB::table('fas_asset_dep_vw')
            ->select([
                'depreciation_percentage',
                'ast_register_no_pk',
                'ast_register_uid',
                'catagory',
                'catagory_no_fk',
                'grn_date',
                'grn_no',
                'itemtype_no_pk',
                'item_name',
                'location',
                'months',
                'per_month',
                'already_dep_amt',
                'last_dep_date',
                'po_no',
                'qty',
                'rate',
                'sub_catagory',
                'supplier_name',
                'tag_ud',
            ])
            ->get();

        $params = [
            'asset_depreciations' => $asset_depreciations,
            'po_hospital_details' => $po_hospital_details,
        ];

        $fileToExport = "Asset_Depreciations_Report_" . date('d_m_Y');
        $html         = View("admin.accounts.asset_depreciation.asset_depreciation_report_pdf")->with($params);
        return response($html)
            ->header("Content-Disposition", "attachment; filename={$fileToExport}.xls")
            ->header("Content-Type", "application/vnd.ms-excel");
    }
}
