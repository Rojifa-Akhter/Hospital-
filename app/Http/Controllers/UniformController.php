<?php

namespace App\Http\Controllers;
use App\Traits\LookupData;
use App\Http\Controllers\Controller;
use App\Http\Requests\UniformRequest;
use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UniformController extends Controller
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
        return Template::loadview("admin.uniform.index");
    }

    /**
     * Get all item type data to feed datatable
     */
    public function getData()
    {
        $items = DB::table('sysc_uniformpolicy a')
                    ->leftJoin('SYSC_SERVICEUNIT b', 'a.serviceunit_no_fk', 'b.serviceunit_no_pk')
                    ->leftJoin('hrms_designation c', 'a.designation_no_fk', 'c.designation_no_pk')
                    ->select('a.uniformpolicy_no_pk', 'a.designation_no_fk', 'c.designation_name', 'a.serviceunit_no_fk', 'b.serviceunit_name', 'a.uniform_ind', 'a.shoe_ind', 'a.winteruniform_ind', 'a.status')
                    ->get();
        return response()->json(["success" => true, "data" => $items], 200);
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
     */
    public function store(UniformRequest $request)
    {
        DB::beginTransaction();

        try {
            $exists = DB::table('sysc_uniformpolicy')
                    ->where('designation_no_fk', $request->input('designation_no_fk'))
                    ->first();

            if($exists) {
                throw new Exception('Uniform already assigned');
            }

            DB::table('sysc_uniformpolicy')->insert([
                "UNIFORMPOLICY_NO_PK"       => $this->getSequence('uniformpolicy_NO_PK_SEQ'),
                "DESIGNATION_NO_FK"         => $request->input('designation_no_fk'),
                "SERVICEUNIT_NO_FK"         => $request->input('serviceunit_no_fk'),
                "UNIFORM_IND"               => $request->input('uniform_ind') ?? 0,
                "SHOE_IND"                  => $request->input('shoe_ind') ?? 0,
                "WINTERUNIFORM_IND"         => $request->input('winteruniform_ind') ?? 0,
                "status"                    => $request->input('status'),
                "UNIFORM_QTY"               => $request->input('uniform_qty'),
                "SHOE_QTY"                  => $request->input('shoe_qty'),
                "WINTERUNIFORM_QTY"         => $request->input('winteruniform_qty'),
                "au_entry_at"               => Carbon::now()->toDateString(),
                "au_entry_by"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
            ]);
            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Uniform Successfully Saved'], 200);
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
            ->select('a.uniformpolicy_no_pk', 'a.designation_no_fk', 'c.designation_name', 'a.serviceunit_no_fk', 'b.serviceunit_name', 'a.uniform_ind', 'a.shoe_ind', 'a.winteruniform_ind', 'a.status', 'a.uniform_qty', 'a.shoe_qty', 'a.winteruniform_qty')
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
                    "UNIFORM_QTY"               => $request->input('uniform_qty'),
                    "SHOE_QTY"                  => $request->input('shoe_qty'),
                    "WINTERUNIFORM_QTY"         => $request->input('winteruniform_qty'),
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

    public function uniformRequest(Request $request)
	{

		$purposes  = LookupData::getLookupListByCode("COVEYANCEPURPOSE");
		$user_id   = Session::get('user.ses_user_pk_no');
		$person_no = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();
		// dd($person_no);
		// $transport = DB::table('hrms_transport_eligibity_setup_vw')
		// 				->where('person_no_pk', $person_no->person_no_fk)
		// 				->select('hrms_transport_eligibity_setup_vw.*')
		// 				->get();

		// $location_thana    = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', 47)->orderBy("name", "asc")->get();
		$requested_by_name = DB::table('hrms_personnel')
								->select('wsec_user.user_fullname', 'hrms_personnel.person_no_pk', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.jobtitle_lookup_no_fk')
								->leftJoin('wsec_user', 'hrms_personnel.person_no_pk', 'wsec_user.person_no_fk')
								->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
								->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
								->where('wsec_user.user_no_pk', Session::get('user.ses_user_pk_no'))
								->first();
		$requested_by_id    = Session::get('user.ses_user_pk_no');
		$requested_by_dept  = Session::get('user.serviceunit');
		$requested_by_desig = $requested_by_name->jobtitle_lookup_no_fk; //Session::get('user.designation');

		 

		$policy = DB::table('SYSC_UNIFORMPOLICY')
						->selectRaw('NVL(UNIFORM_IND, 0) AS UNIFORM_IND, NVL(SHOE_IND, 0) AS SHOE_IND, NVL(WINTERUNIFORM_IND, 0) AS WINTERUNIFORM_IND')
						->where('DESIGNATION_NO_FK', $requested_by_name->jobtitle_lookup_no_fk)
						->first();
		$requestData = null;				

						if ($policy) {
							// If the policy is found, proceed with fetching the request data
							$requestData = DB::select(
								"SELECT 
                          
                                    ITEM_NO_PK,
                                    ITEM_CODE,
                                    ITEM_NAME,
                                    Allocated_Qty,
                                    Request_Qty,
                                    Issue_Qty,
                                    issue_date,
                                    request_date,
                                    Year,
                                    Status
                          from (  SELECT 
                                    SI.ITEM_NO_PK,0
                                    SI.ITEM_CODE,
                                    SI.ITEM_NAME,
                                    UP.USES_QTY AS Allocated_Qty,
                                    UI.REQ_QTY AS Request_Qty,
                                    UI.ISSUE_QTY AS Issue_Qty,
                                    UI.ISSUE_AT AS issue_date,
                                    UI.REQ_AT AS request_date,
                                    NVL(UI.YEAR_YYYY,to_number(to_char(SYSDATE,'YYYY'))) AS Year,
                                    CASE 
                                        WHEN NVL(UI.REQ_QTY, 0) <= 0 THEN 'Pending' 
                                        WHEN NVL(UI.REQ_QTY, 0) > 0 AND NVL(UI.ISSUE_QTY, 0) <= 0 THEN 'Issue Pending' 
                                        WHEN NVL(UI.REQ_QTY, 0) > 0 AND NVL(UI.ISSUE_QTY, 0) > 0 THEN 'Issued' 
                                        ELSE ' ' 
                                    END AS Status
                                FROM sysc_serviceitem SI
                                left join SYSC_ITEMTYPE it on SI.ITEMTYPE_NO_FK = it.ITEMTYPE_NO_PK
                                 LEFT JOIN (SELECT * FROM HRMS_EMPUNIFORMDTL UI  WHERE UI.YEAR_YYYY = to_number(to_char(SYSDATE,'YYYY'))) UI  ON SI.ITEM_NO_PK = UI.ITEM_NO_FK
                                LEFT JOIN HRMS_EMPUNIFORMMST UM ON UI.EMPUNIFORMMST_NO_FK = UM.EMPUNIFORMMST_NO_PK
                                LEFT JOIN HRMS_PERSONNEL P ON UM.PERSON_NO_FK = P.PERSON_NO_PK
                                JOIN SYSC_UNIFORM_DURATION_USES_SETUP UP ON SI.ITEM_NO_PK = UP.ITEM_NO_FK
                                WHERE UPPER(it.ITEMTYPE_CODE) = 'UNIFORM' AND (UP.UNIFORM_IND = ? OR UP.SHOES_IND = ? OR UP.WINTER_UNIFORM_IND = ? ) ) where Year = to_number(to_char(sysdate,'YYYY'))",
								[
									$policy->uniform_ind,
									$policy->shoe_ind,
									$policy->winteruniform_ind	
								]
							);
						} else {
							$requestData = [];
						}

		return Template::loadView(
			'admin.uniform.uniformRequest',
			[
				'requested_by_name' => $requested_by_name,
				'requested_by_dept' => $requested_by_dept,
				'requested_by_id'   => $requested_by_id,
				'purposes'          => $purposes,
                'requestData'       => $requestData,
				'person_no'       => $person_no
			]
		);
	}

	public function uniformRequestStore(Request $request)
    {
		//  dd($request->all());

		$validatedData = $request->validate([
			'item_no_pk' => 'required|integer',
			'request_qty' => 'required|integer',
			'req_remarks' => 'nullable|string|max:200',
			'year' => 'required|integer',
			'req_desig' => 'required|string|max:200',
		]);
		
		$preMstID = DB::table('HRMS_EMPUNIFORMMST')
			->where('person_no_fk', $request->req_person_no)
			->orderByDesc('EMPUNIFORMMST_NO_PK')
			->value('EMPUNIFORMMST_NO_PK'); // Fetching the value of EMPUNIFORMMST_NO_PK
		
		try {
			if ($preMstID === null) {
				DB::beginTransaction();
				DB::table('HRMS_EMPUNIFORMMST')->insert([
					'EMPUNIFORMMST_NO_PK' => $this->getSequence('EMPUNIFORMMST_NO_PK_seq'),
					'PERSON_NO_FK' => $request->input('req_person_no'),
					'ASSIGN_DATE' => Carbon::now(),
					'REMARKS' => $request->input('req_remarks'),
					'STATUS' => 1,
					'AU_ENTRY_BY' => Auth::id(),
					'AU_ENTRY_SESSION' => session()->getId(),
					'AU_ENTRY_HOSPITAL_NO_FK' => session()->get('user.ses_hospital_no_pk'),
					'AU_ENTRY_AT' => Carbon::now(),
				]);
				DB::commit();
			}
		
			$mstID = DB::table('HRMS_EMPUNIFORMMST')
				->where('person_no_fk', $request->req_person_no)
				->orderByDesc('EMPUNIFORMMST_NO_PK')
				->value('EMPUNIFORMMST_NO_PK');
		
			if ($mstID !== null) {

				DB::beginTransaction();
		
				DB::table('HRMS_EMPUNIFORMDTL')->insert([
					'EMPUNIFORMDTL_NO_PK' => $this->getSequence('EMPUNIFORMDTL_NO_PK_seq'),
					'EMPUNIFORMMST_NO_FK' => $mstID,
					'UNIFORM_TYPE' => null,
					'ITEM_NO_FK' => $request->input('item_no_pk'), 
					'QTY' => $request->input('request_qty'),
					'ITEM_REMARKS' => $request->input('req_remarks'),
                    'ITEM_SIZE' => $request->input('req_size'),
					'STATUS' => 1,
					'REQ_QTY' => $request->input('request_qty'),
					'REQ_BY' => Auth::id(),
					'REQ_AT' => Carbon::now(),
					'REQ_BY_REMARKS' => $request->input('req_remarks'),
					'YEAR_YYYY' => $request->input('year'),  
					'AU_ENTRY_BY' => Auth::id(),
					'AU_ENTRY_AT' => Carbon::now(),
					'AU_ENTRY_SESSION' => 'Session',
					'AU_ENTRY_HOSPITAL_NO_FK' => session()->get('user.ses_hospital_no_pk'),
				]);
		
				DB::commit();
		
				return response()->json([
					'success' => true,
					'message' => 'Uniform request submitted successfully!',
				]);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'Error occurred while submitting the request: Invalid or missing $mstID.',
				]);
			}
		
		} catch (\Exception $e) {
			// Handle any exceptions
			return response()->json([
				'success' => false,
				'message' => 'Error occurred while submitting the request: ' . $e->getMessage(),
			]);
		}
		
    }
	
    public function uniformIssue(Request $request)
	{
		// $user_id   = Session::get('user.ses_user_pk_no');
		// $person_no = DB::table('wsec_user')->select('person_no_fk')->where('user_no_pk', $user_id)->first();

        $two_days_ago = date("Y-m-d", strtotime("-10 day"));
            $req_person_name = DB::table('HRMS_EMPUNIFORMMST as um')
                                ->join('HRMS_PERSONNEL as p', 'um.PERSON_NO_FK', '=', 'p.PERSON_NO_PK')
                                ->join('HRMS_EMPUNIFORMDTL as ud', 'um.EMPUNIFORMMST_NO_PK', '=', 'ud.EMPUNIFORMMST_NO_FK')
                                ->distinct()
                                ->whereRaw('nvl(UD.REQ_QTY,0) > nvl(ud.ISSUE_QTY, 0)')
                                ->select('p.PERSON_NO_PK', 'p.FULL_NAME')
                                ->get();
        $su_no = [];
        if (!empty($sub_store_list)) {
            foreach ($sub_store_list as  $value) {
                $su_no[] = $value->serviceunit_no_pk;
            }
        }

        $requisition_list_drafts = null;
        $requisition_list_posts = null;
        $requisition_list_draft = []; 

        $two_days_ago_post = date("Y-m-d", strtotime("-10 day"));

        $requisition_list_posts = [];
        $query = DB::table('HRMS_EMPUNIFORMDTL as req')
        ->join('sysc_serviceitem as ITEM', 'req.ITEM_NO_FK', '=', 'ITEM.ITEM_NO_PK')
        ->join('wsec_user as US', 'req.REQ_BY', '=', 'US.USER_NO_PK')
        ->join('HRMS_PERSONNEL as PER', 'US.PERSON_NO_FK', '=', 'PER.PERSON_NO_PK')
        ->join('SYSC_SERVICEUNIT as SUN', 'PER.SERVICEUNIT_NO_FK', '=', 'SUN.SERVICEUNIT_NO_PK')
        ->where(DB::raw('COALESCE(req.REQ_QTY, 0)'), '>', DB::raw('COALESCE(req.ISSUE_QTY, 0)'))
        ->select(
            'req.EMPUNIFORMDTL_NO_PK',
            'req.ITEM_NO_FK',
            'ITEM.ITEM_NAME',
            'PER.FULL_NAME',
            'SUN.SERVICEUNIT_NO_PK',
            'SUN.SERVICEUNIT_NAME',
            DB::raw('COALESCE(req.REQ_QTY, 0) as REQ_QTY'),
            'req.REQ_AT',
            DB::raw('COALESCE(req.ISSUE_QTY, 0) as ISSUE_QTY'),
            'req.ISSUE_AT',
            'req.YEAR_YYYY',
            'req.REQ_BY',
            'req.REQ_BY_REMARKS',
            'req.ITEM_SIZE'
        );

        $requisition_list = $query->get();



        return  Template::loadView("admin.uniform.uniformIssueWorklist", [
            'req_person_name'=>$req_person_name,
            'requisition_list'=>$requisition_list,

        ]);

	}

    public function updateIssue(Request $request)
        {
            DB::beginTransaction();
            // Validate the incoming data
            $validated = $request->validate([
                'reqNo' => 'required|exists:HRMS_EMPUNIFORMDTL,empuniformdtl_no_pk',
                'issueQty' => 'required|integer|min:1',
                'issueRemarks' => 'nullable|string|max:255',
            ]);
                  
            $affectedRows = DB::table('HRMS_EMPUNIFORMDTL')
                            ->where('empuniformdtl_no_pk', $validated['reqNo'])
                            ->update([
                                'issue_qty' => $validated['issueQty'],
                                'issue_at' => Carbon::now()->toDateString(),
                                'issue_by_remarks' => $validated['issueRemarks'],
                                 'issue_by' => Auth::id(),
                            ]);
                            DB::commit();

            if ($affectedRows === 0) {
                return response()->json(['success' => false, 'message' => 'No record updated.'], 404);
            }

            return response()->json([
                'success' => true,
                'issueDate' => now()->format('d/m/Y'), // Send the issue date in response
            ]);
        }

}
