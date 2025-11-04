<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniformRequest;
use App\Http\Requests\UniformWorklistRequest;
use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UniformWorklistController extends Controller
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
        
        return Template::loadview("admin.uniformWorklist.index");
    }

    /**
     * Get all item type data to feed datatable
     */
    public function getData()
    {
        $items = DB::table('HRMS_PERSONNEL')
                        ->leftJoin('SYSC_SERVICEUNIT', 'SYSC_SERVICEUNIT.serviceunit_no_pk', '=', 'HRMS_PERSONNEL.serviceunit_no_fk')
        		        ->leftJoin('HRMS_DESIGNATION', 'HRMS_PERSONNEL.JOBTITLE_LOOKUP_NO_FK', '=', 'HRMS_DESIGNATION.DESIGNATION_NO_PK')
                        ->where("UNIFORM_IND", 1)
                        ->where('HRMS_PERSONNEL.AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
                        ->select("HRMS_PERSONNEL.PERSON_CODE", "HRMS_PERSONNEL.FULL_NAME", "SYSC_SERVICEUNIT.SERVICEUNIT_NAME AS DEPARTMENT", "HRMS_DESIGNATION.DESIGNATION_NAME", "HRMS_PERSONNEL.PHONE_MOBILE", "HRMS_PERSONNEL.EMAIL_PERSONAL", "HRMS_PERSONNEL.JOIN_DATE", "HRMS_PERSONNEL.STATUS", "HRMS_PERSONNEL.PERSON_NO_PK", "HRMS_PERSONNEL.JOBTITLE_LOOKUP_NO_FK", "HRMS_DESIGNATION.DESIGNATION_NO_PK")
                        ->orderBy('HRMS_PERSONNEL.FULL_NAME')
                        ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Show Uniform Allocation History
     */
    public function allocationHistory(int $id)
    {
        $itemTypesQuery = "SELECT ITEM_NO_PK, ITEM_CODE, ITEM_NAME
                        FROM SYSC_SERVICEITEM ITEM, SYSC_ITEMTYPE TYPE
                        WHERE ITEM.ITEMTYPE_NO_FK = TYPE.ITEMTYPE_NO_PK
                        AND ITEMTYPE_CODE = 'Uniform'";
        $itemTypes = DB::select(DB::raw($itemTypesQuery));

        $items = DB::table('HRMS_EMPUNIFORMMST')
                    ->leftJoin('HRMS_EMPUNIFORMDTL', 'HRMS_EMPUNIFORMMST.EMPUNIFORMMST_NO_PK', 'HRMS_EMPUNIFORMDTL.EMPUNIFORMMST_NO_FK')
                    ->leftJoin('HRMS_PERSONNEL', 'HRMS_EMPUNIFORMMST.PERSON_NO_FK', 'HRMS_PERSONNEL.PERSON_NO_PK')
                    ->leftJoin('SYSC_SERVICEITEM', 'HRMS_EMPUNIFORMDTL.ITEM_NO_FK', 'SYSC_SERVICEITEM.item_no_pk')
                    ->where('HRMS_EMPUNIFORMMST.PERSON_NO_FK', $id)
                    ->select('HRMS_EMPUNIFORMMST.PERSON_NO_FK', 'HRMS_EMPUNIFORMMST.ASSIGN_DATE', 'HRMS_EMPUNIFORMMST.REMARKS', 'HRMS_EMPUNIFORMDTL.UNIFORM_TYPE', 'HRMS_EMPUNIFORMDTL.ITEM_NO_FK', 'HRMS_EMPUNIFORMDTL.QTY', 'HRMS_EMPUNIFORMDTL.ITEM_REMARKS', 'HRMS_PERSONNEL.FULL_NAME', 'SYSC_SERVICEITEM.item_short_name')
                    ->get();
        
        return Template::loadview("admin.uniformWorklist.history", ['items' => $items]);
    }

    /**
     * Allocate Uniform
     */
    public function allocate(int $id, int $designation_id)
    {
        $items = DB::table('HRMS_PERSONNEL')
                        ->leftJoin('SYSC_SERVICEUNIT', 'SYSC_SERVICEUNIT.serviceunit_no_pk', '=', 'HRMS_PERSONNEL.serviceunit_no_fk')
        		        ->leftJoin('HRMS_DESIGNATION', 'HRMS_PERSONNEL.JOBTITLE_LOOKUP_NO_FK', '=', 'HRMS_DESIGNATION.DESIGNATION_NO_PK')
                        ->leftJoin('SYSC_UNIFORMPOLICY', 'HRMS_DESIGNATION.designation_no_pk', '=', 'SYSC_UNIFORMPOLICY.designation_no_fk')
                        ->where("HRMS_PERSONNEL.UNIFORM_IND", 1)
                        ->where("HRMS_PERSONNEL.PERSON_NO_PK", $id)
                        ->where('HRMS_PERSONNEL.AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
                        ->select("HRMS_PERSONNEL.PERSON_CODE", "HRMS_PERSONNEL.FULL_NAME", "SYSC_SERVICEUNIT.SERVICEUNIT_NAME AS DEPARTMENT", "HRMS_DESIGNATION.DESIGNATION_NAME", "HRMS_PERSONNEL.PHONE_MOBILE", "HRMS_PERSONNEL.EMAIL_PERSONAL", "HRMS_PERSONNEL.JOIN_DATE", "HRMS_PERSONNEL.STATUS", "HRMS_PERSONNEL.PERSON_NO_PK", "HRMS_PERSONNEL.JOBTITLE_LOOKUP_NO_FK", "HRMS_DESIGNATION.DESIGNATION_NO_PK", "SYSC_UNIFORMPOLICY.UNIFORM_IND", "SYSC_UNIFORMPOLICY.SHOE_IND", "SYSC_UNIFORMPOLICY.WINTERUNIFORM_IND", "SYSC_UNIFORMPOLICY.UNIFORM_QTY", "SYSC_UNIFORMPOLICY.SHOE_QTY", "SYSC_UNIFORMPOLICY.WINTERUNIFORM_QTY")
                        ->orderBy('HRMS_PERSONNEL.FULL_NAME')
                        ->get();

        $uniformPolicy = DB::table('SYSC_UNIFORMPOLICY')
                        ->select("shoe_ind","uniform_ind","winteruniform_ind")
                        ->where('designation_no_fk', $designation_id)
                        ->first();

                        // dd($uniformPolicy);

        $query = "SELECT ITEM_NO_PK, ITEM_CODE, ITEM_NAME
                        FROM SYSC_SERVICEITEM ITEM, SYSC_ITEMTYPE TYPE
                        WHERE ITEM.ITEMTYPE_NO_FK = TYPE.ITEMTYPE_NO_PK
                        AND ITEMTYPE_CODE = 'Uniform'";
        $itemTypes = DB::select(DB::raw($query));

        // dd($itemTypes);

        $result = [];

        foreach($itemTypes as $itemType) {
            if($itemType->item_name === 'Shoe' && isset($uniformPolicy->shoe_ind) &&  $uniformPolicy->shoe_ind == 1) {
                array_push($result, $itemType);
            }
            else if($itemType->item_name === 'Uniform' && isset($uniformPolicy->uniform_ind) && $uniformPolicy->uniform_ind == 1) {
                array_push($result, $itemType);
            }
            else if($itemType->item_name === 'Winter Uniform' && isset($uniformPolicy->winteruniform_ind) && $uniformPolicy->winteruniform_ind == 1) {
                array_push($result, $itemType);
            }
            else {
                
            }
        }
        
        return Template::loadview("admin.uniformWorklist.allocate", ['items' => $items, 'itemTypes' => $result, 'designation_id' => $designation_id]);
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->orderBy('serviceunit_name')
            ->get();

        $designations = DB::table('hrms_designation')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('designation_no_pk', 'designation_code', 'designation_name')
            ->orderBy('designation_name')
            ->get();

        return Template::loadview("admin.uniform.createUpdate", compact('departments', 'designations'));
    }

    /**
     * Save data to database
     * TODO:: Add limit validation
     */
    public function store(UniformWorklistRequest $request)
    {
        $allocationPolicy = DB::table('sysc_uniformpolicy')
                            ->where('designation_no_fk', $request->input('designation_no_fk'))
                            ->first();
                       
        // if($allocationPolicy->count() == 0) {
        //     throw new Exception('Policy Not Found');
        // }

        if (is_null($allocationPolicy)) {
            throw new Exception();
        }
        
        $allocated = DB::table('HRMS_EMPUNIFORMMST')
                        ->leftJoin('HRMS_EMPUNIFORMDTL', 'HRMS_EMPUNIFORMMST.EMPUNIFORMMST_NO_PK', 'HRMS_EMPUNIFORMDTL.EMPUNIFORMMST_NO_FK')
                        ->leftJoin('HRMS_PERSONNEL', 'HRMS_EMPUNIFORMMST.PERSON_NO_FK', 'HRMS_PERSONNEL.PERSON_NO_PK')
                        ->leftJoin('SYSC_SERVICEITEM', 'HRMS_EMPUNIFORMDTL.ITEM_NO_FK', 'SYSC_SERVICEITEM.item_no_pk')
                        ->where('HRMS_EMPUNIFORMMST.PERSON_NO_FK', $request->input('person_no_fk'))
                        ->select('HRMS_EMPUNIFORMMST.PERSON_NO_FK', 'HRMS_EMPUNIFORMMST.ASSIGN_DATE', 'HRMS_EMPUNIFORMMST.REMARKS', 'HRMS_EMPUNIFORMDTL.UNIFORM_TYPE', 'HRMS_EMPUNIFORMDTL.ITEM_NO_FK', 'HRMS_EMPUNIFORMDTL.QTY', 'HRMS_EMPUNIFORMDTL.ITEM_REMARKS', 'HRMS_PERSONNEL.FULL_NAME', 'HRMS_PERSONNEL.JOBTITLE_LOOKUP_NO_FK', 'SYSC_SERVICEITEM.item_short_name')
                        ->get();
        
        if($allocated->count() > 0) {
            // Already exists
        } else {
            // First time entry
            
        }

        foreach($request->input('item_no_fk') as $index => $item) {

        }

        // dd($allocated, $allocationPolicy);


        DB::beginTransaction();

        try {
            DB::table('HRMS_EMPUNIFORMMST')->insert([
                'EMPUNIFORMMST_NO_PK'       => $this->getSequence('EMPUNIFORMMST_NO_PK_seq'),
                'PERSON_NO_FK'              => $request->input('person_no_fk'),
                'ASSIGN_DATE'               => date('Y-m-d'),
                'REMARKS'                   => $request->input('remarks'),
                'STATUS'                    => true,
                'AU_ENTRY_BY'               => Auth::id(),
                'AU_ENTRY_AT'               => Carbon::now()->toDateString(),
                'AU_ENTRY_SESSION'          => auth()->user()->user_name,
                'AU_ENTRY_HOSPITAL_NO_FK'   => session()->get('user.ses_hospital_no_pk'),
            ]);

            $lastId = DB::table('HRMS_EMPUNIFORMMST')
                        ->orderBydesc('EMPUNIFORMMST_NO_PK')
                        ->value('EMPUNIFORMMST_NO_PK');
    
            foreach($request->input('item_no_fk') as $index => $item) {
                DB::table('HRMS_EMPUNIFORMDTL')->insert([
                    'EMPUNIFORMDTL_NO_PK'       => $this->getSequence('EMPUNIFORMDTL_NO_PK_seq'),
                    'EMPUNIFORMMST_NO_FK'       => $lastId,
                    'UNIFORM_TYPE'              => null,
                    'ITEM_NO_FK'                => $request->input('item_no_fk')[$index],
                    'QTY'                       => $request->input('qty')[$index],
                    'ITEM_REMARKS'              => null,
                    'STATUS'                    => true,
                    'AU_ENTRY_BY'               => Auth::id(),
                    'AU_ENTRY_AT'               => Carbon::now()->toDateString(),
                    'AU_ENTRY_SESSION'          => auth()->user()->user_name,
                    'AU_ENTRY_HOSPITAL_NO_FK'   => session()->get('user.ses_hospital_no_pk'),
                ]);
            }
            
            DB::commit();
            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Uniform Allocated Successfully'], 200);
        } catch(Exception $exception) {
            DB::rollback();
            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    /**
     * Edit Uniform
     */
    public function edit(int $id)
    {
        $departments = DB::table('SYSC_SERVICEUNIT')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_name')
            ->orderBy('serviceunit_name')
            ->get();

        $designations = DB::table('hrms_designation')
            ->where('au_entry_hospital_pk_no', session()->get('user.ses_hospital_no_pk'))
            ->select('designation_no_pk', 'designation_code', 'designation_name')
            ->orderBy('designation_name')
            ->get();

        $item = DB::table('sysc_uniformpolicy a')
            ->leftJoin('SYSC_SERVICEUNIT b', 'a.serviceunit_no_fk', 'b.serviceunit_no_pk')
            ->leftJoin('hrms_designation c', 'a.designation_no_fk', 'c.designation_no_pk')
            ->where('a.UNIFORMPOLICY_NO_PK', $id)
            ->select('a.uniformpolicy_no_pk', 'a.designation_no_fk', 'c.designation_name', 'a.serviceunit_no_fk', 'b.serviceunit_name', 'a.uniform_ind', 'a.shoe_ind', 'a.winteruniform_ind', 'a.status','a.shoe_ind')
            ->first();

        return Template::loadview("admin.uniform.createUpdate", ['item' => $item, 'departments' => $departments, 'designations' => $designations]);
    }

    /**
     * Update Uniform
     */
    public function update(UniformRequest $request, int $id)
    {
        DB::beginTransaction();

        try {
            DB::table('sysc_uniformpolicy')->where('UNIFORMPOLICY_NO_PK', $id)
                ->update([
                    "DESIGNATION_NO_FK"         => $request->input('designation_no_fk'),
                    "SERVICEUNIT_NO_FK"         => $request->input('serviceunit_no_fk'),
                    "UNIFORM_IND"               => $request->input('uniform_ind') ?? 0,
                    "SHOE_IND"                  => $request->input('shoe_ind') ?? 0,
                    "WINTERUNIFORM_IND"         => $request->input('winteruniform_ind') ?? 0,
                    "status"                    => $request->input('status'),
                    "AU_UPDATE_AT"              => Carbon::now()->toDateString(),
                    "AU_UPDATE_BY"              => Auth::id(),
                    "AU_UPDATE_SESSION"         => auth()->user()->user_name,
                    "AU_UPDATE_HOSPITAL_NO_FK"  => session()->get('user.ses_hospital_no_pk'),
                ]);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Uniform Successfully Updated'], 200);
        } catch(Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }
}
