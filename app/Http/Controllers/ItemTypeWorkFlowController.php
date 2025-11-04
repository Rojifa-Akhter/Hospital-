<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemTypeWorkflowRequest;
use App\Http\Requests\ItemTypeWorkflowUpdateRequest;
use Session;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Models\ItemTypeWorkflow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemTypeWorkFlowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        return Template::loadview("admin.itemTypeWorkflow.index");
    }

    /**
     * Get all item type data to feed datatable
     */
    public function getItemTypeData() {
        // $items = ItemTypeWorkflow::orderByDesc('WORKFLOW_NO_PK')->get();
        $items = DB::table('SYSC_ITEMTYPE_WORKFLOW a')
            ->select('a.*', 'b.serviceunit_name','b.serviceunit_no_pk')
            ->leftJoin('SYSC_SERVICEUNIT b', 'a.service_point_su_no_fk', '=','b.serviceunit_no_pk')
            ->orderByDesc('WORKFLOW_NO_PK')
            ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $servicePoints = DB::table('SYSC_GRANT_SERVIECEUNIT_VW')
            ->select('SERVICEUNIT_NAME', 'serviceunit_no_pk')
            ->distinct('serviceunit_no_pk')
            ->orderBy('SERVICEUNIT_NAME')
            ->get();

        return Template::loadview("admin.itemTypeWorkflow.create", ['servicePoints' => $servicePoints]);
    }

    /**
     * Save data to database
     */
    public function store(ItemTypeWorkflowRequest $request)
    {
        DB::beginTransaction();

        try {
            $itemTypeWorkflow = [
                "WORKFLOW_NO_PK"            => $this->getSequence('sysc_itemworkflow_seq'),
                "workflow_code"             => $request->input('workflow_code'),
                "workflow_name"             => $request->input('workflow_name'),
                "service_point_su_no_fk"    => $request->input('service_point_su_no_fk'),
                "service_billing_ind"       => $request->input('service_billing_ind') ?? "",
                "pharmacy_billing_ind"      => $request->input('pharmacy_billing_ind') ?? "",
                "emergency_billing_ind"     => $request->input('emergency_billing_ind') ?? "",
                "daycare_billing_ind"       => $request->input('daycare_billing_ind') ?? "",
                "ot_billing_ind"            => $request->input('ot_billing_ind') ?? "",
                "carpark_billing_ind"       => $request->input('carpark_billing_ind') ?? "",
                "cafeteria_billing_ind"     => $request->input('cafeteria_billing_ind') ?? "",
                "optical_shop_billing_ind"  => $request->input('optical_shop_billing_ind') ?? "",
                "workflow_desc"             => $request->input('workflow_desc'),
                "au_entry_at"               => Carbon::now()->toDateString(),
                "au_entry_by"               => Auth::id(),
                "au_entry_hospital_pk_no"   => session()->get('user.ses_hospital_no_pk'),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "status"                    => 1,
            ];

            // ItemTypeWorkflow::create($itemTypeWorkflow);

            DB::table('SYSC_ITEMTYPE_WORKFLOW')->insert($itemTypeWorkflow);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Workflow Successfully Saved'], 200);
        } catch(\Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    public function edit(int $id)
    {
        $servicePoints = DB::table('SYSC_GRANT_SERVIECEUNIT_VW')
            ->select('SERVICEUNIT_NAME', 'serviceunit_no_pk')
            ->distinct('serviceunit_no_pk')
            ->orderBy('SERVICEUNIT_NAME')
            ->get();

        $item = DB::table('SYSC_ITEMTYPE_WORKFLOW a')
            ->select('a.*', 'b.serviceunit_name','b.serviceunit_no_pk')
            ->leftJoin('SYSC_SERVICEUNIT b', 'a.service_point_su_no_fk', '=','b.serviceunit_no_pk')
            ->where('WORKFLOW_NO_PK', $id)
            ->orderByDesc('WORKFLOW_NO_PK')
            ->first();

        return Template::loadview("admin.itemTypeWorkflow.create", ['servicePoints' => $servicePoints, 'item' => $item]);
    }

    public function update(ItemTypeWorkflowUpdateRequest $request, int $id)
    {
        DB::beginTransaction();

        try {
            $itemTypeWorkflow = [
                "WORKFLOW_NO_PK"            => $this->getSequence('sysc_itemworkflow_seq'),
                "workflow_code"             => $request->input('workflow_code'),
                "workflow_name"             => $request->input('workflow_name'),
                "service_point_su_no_fk"    => $request->input('service_point_su_no_fk'),
                "service_billing_ind"       => $request->input('service_billing_ind') ?? "",
                "pharmacy_billing_ind"      => $request->input('pharmacy_billing_ind') ?? "",
                "emergency_billing_ind"     => $request->input('emergency_billing_ind') ?? "",
                "daycare_billing_ind"       => $request->input('daycare_billing_ind') ?? "",
                "ot_billing_ind"            => $request->input('ot_billing_ind') ?? "",
                "carpark_billing_ind"       => $request->input('carpark_billing_ind') ?? "",
                "cafeteria_billing_ind"     => $request->input('cafeteria_billing_ind') ?? "",
                "optical_shop_billing_ind"  => $request->input('optical_shop_billing_ind') ?? "",
                "workflow_desc"             => $request->input('workflow_desc'),
                "au_update_at"              => Carbon::now()->toDateString(),
                "au_update_by"              => Auth::id(),
            ];

            // ItemTypeWorkflow::create($itemTypeWorkflow);

            DB::table('SYSC_ITEMTYPE_WORKFLOW')->where('WORKFLOW_NO_PK', $id)
                ->update($itemTypeWorkflow);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Workflow Successfully Updated'], 200);
        } catch(\Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }
}
