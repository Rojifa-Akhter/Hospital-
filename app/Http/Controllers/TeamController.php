<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use App\Repositories\BaseRepository;
use Auth;
use Validator;
use App\Models\Team;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Session;
use DB;
use PDF;
use Illuminate\Support\Carbon;
use App\Datatables\DataTableClass;
use App\Helpers\ExcelHelper;

class TeamController extends Controller
{
    private $model;
    use LookupData;
    public function __construct(Team $model)
    {
        $this->middleware('auth');
        $this->model = new BaseRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = DB::table('hrms_sales_team')->select('team_no_pk', 'team_name')->get();
        return Template::loadview("admin.sales.sales_team_list", compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.sales.create_sales_team");
    }
    public function create_form()
    {
        return Template::loadview("admin.sales.create_sales_team_form");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $request->validate([
            'team_name' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $team_no_pk_seq = $sequence->nextValue('team_no_pk_seq');
            $team_info = [];
            $team_info = [
                'team_no_pk' => $team_no_pk_seq,
                'team_name' => $request->team_name,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            if ($id == null || $id == "") {
                // AU_ENTRY_BY
                $team_info['au_entry_by'] = $auth_id;
                $this->model->insert($team_info);
                // return $res;
            } else {
                // AU_UPDATE_BY
                $team_info['au_update_by'] = $auth_id;
                DB::table('hrms_sales_team')->where('team_no_pk', $id)->update($team_info);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = DB::table('hrms_sales_team')->where('team_no_pk', $id)->first();
        return Template::loadview('admin.sales.create_sales_team_form', [
            'team' => $team
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // Team V2
    public function teamSetup()
    {
        $teams = DB::select("SELECT TEAM.TEAM_NAME,
         BUI.STATUS,
         PERS.FULL_NAME,
         PERS.PERSON_NO_PK,
         LISTAGG (area.area_code, ',') WITHIN GROUP (ORDER BY area.area_code)
            AS area_codes,                    -- Use LISTAGG for concatenation
         TEAM.TEAM_NO_PK
    FROM HRMS_SALES_TEAM TEAM
         INNER JOIN HRMS_TEAM_BUILD BUI ON TEAM.TEAM_NO_PK = BUI.TEAM_NO_FK
         INNER JOIN HRMS_PERSONNEL PERS
            ON BUI.EMPLOYEE_NO_FK = PERS.PERSON_NO_PK
         LEFT JOIN PCRM_MARKETING_AREA AREA
            ON AREA.SUPERVISOR_PERSON_NO_FK = PERS.PERSON_NO_PK
   WHERE TEAM.TEAM_NAME IS NOT NULL 
GROUP BY TEAM.TEAM_NO_PK,
         TEAM.TEAM_NAME,
         BUI.STATUS,
         PERS.FULL_NAME,
         PERS.PERSON_NO_PK");
// AND BUI.status = 1
        $vTeams = [];

        foreach ($teams as $team) {
            // Ensure team name is the key and each value is an array with team and area details
            $vTeams[$team->team_name . '~' . $team->team_no_pk][] = [
                'team_name' => $team->team_name,
                'status' => $team->status,
                'full_name' => $team->full_name,
                'person_no_pk' => $team->person_no_pk,
                'area_codes' => explode(',', $team->area_codes), // Convert the comma-separated area codes to an array
                'team_no_pk' => $team->team_no_pk
            ];
        }


        return Template::loadview("admin.sales.sales_team_list_v2", compact('vTeams'));
    }


    public function createMarketingSetup()
    {
        $teams = DB::select('select person_no_pk,full_name,person_code from hrms_personnel where status = 1 and employee_ind = 1');
        $areas = DB::table('PCRM_MARKETING_AREA')->select('area_no_pk', 'area_code')->where('status', 1)->get();
        return Template::loadview("admin.sales.create_sales_team_form_v2", compact('teams', 'areas'));
    }

    public function addNewMemberSetup($id)
    {
        $team_member = DB::table('hrms_sales_team')->where('team_no_pk', $id)->first();
        $teams = DB::select('select person_no_pk,full_name,person_code from hrms_personnel where status = 1 and employee_ind = 1');
        $areas = DB::table('PCRM_MARKETING_AREA')->select('area_no_pk', 'area_code')->where('status', 1)->get();
        return Template::loadview("admin.sales.add_new_member", compact('teams', 'areas', 'team_member'));
    }

    public function marketingSetupStore(Request $request)
    {
        // Begin a transaction
        DB::beginTransaction();

        try {
            // Insert the team
            $sequence = DB::getSequence();
            $team_no_pk_seq = $sequence->nextValue('team_no_pk_seq');

            $teamId = DB::table('hrms_sales_team')->insert([
                'team_no_pk' => $team_no_pk_seq,
                'team_name' => $request->teamName,
                'team_code' => $request->teamName, // Consider using a different logic for team code
                'status' => 1,
                'au_entry_hospital_pk_no' => 141,
                'au_entry_session' => 'session',
                'au_entry_by' => Auth::id(),
                'au_entry_at' => now(),
                'au_update_at' => now(),
            ]);
            // $team_no_pk = DB::table('hrms_sales_team')->select('team_no_pk')->first()->team_no_pk;

            // Loop through each member and insert
            foreach ($request->members as $member) {
                $team_build_no_pk_seq = $sequence->nextValue('team_build_no_pk_seq');
                DB::table('hrms_team_build')->insert([
                    'team_build_no_pk' => $team_build_no_pk_seq,
                    'team_no_fk' => $team_no_pk_seq,
                    'employee_no_fk' => $member['id'],
                    'status' => 1,
                    'au_entry_hospital_pk_no' => 141,
                    'au_entry_session' => 'session',
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => now(),
                    'au_update_at' => now(),
                ]);

                // Update each area associated with the member
                foreach ($member['areas'] as $area) {
                    DB::table('pcrm_marketing_area')->where('area_no_pk', $area)->update([
                        'supervisor_person_no_fk' => $member['id'],
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Team saved successfully!'
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();
            \Log::error('Error saving team: ' . $e->getMessage()); // Log the error

            return response()->json([
                'success' => false,
                'message' => 'Error saving team: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function teamSetupCommission()
    {
        $salesTeams = db::table('hrms_sales_team as team')
            ->select('target.achivement_no_pk', 'target.target_month', 'target.target_year', 'team.team_name', 'team.status', 'per.full_name', 'TOTAL_PTN_TARGET', 'TARGET_AMNT', 'ACHIEVED_IPD_TARGET_AMNT', 'ACHIEVED_OPD_TARGET_AMNT', 'ACHIEVED_IPD_PTN_QTY', 'ACHIEVED_OPD_PTN_QTY')
            ->join('PCRM_MARKETING_ACHIVEMENT as target', 'team.team_no_pk', '=', 'target.team_no_fk')
            ->join('hrms_personnel per', 'target.sales_person_no_fk', 'per.person_no_pk')
            ->get();

        return Template::loadview("admin.sales.sales_team_setup_comission_list_v2", compact('salesTeams'));
    }


    public function createMarketingTargetSetup()
    {
        $teams = DB::table('hrms_sales_team')->where('status', 1)->get();
        $member_list = DB::table('hrms_personnel')->where('status', 1)->where('employee_ind', 1)->get();
        $target = null; // এটাই মূল সমাধান
        return Template::loadview("admin.sales.create_sales_team_target_form", compact('teams', 'member_list', 'target'));
    }

    public function getTeamMembers($teamId)
    {

        $member_list = DB::table('HRMS_TEAM_BUILD build')
            ->select('per.person_no_pk', 'per.full_name')
            ->join('hrms_personnel per', 'build.employee_no_fk', 'per.person_no_pk')
            ->where('build.status', 1)
            ->where('build.team_no_fk', $teamId)
            ->get();
        return response()->json([
            'members' => $member_list
        ]);
    }

    public function marketingSetupTargetStore(Request $request)
    {
        $date_explode = explode("/", $request->input('date_picker'));
        $id = $request->input('id'); // edit id from hidden field

        $data = [
            'team_no_fk' => $request->input('marketing_team'),
            'sales_person_no_fk' => $request->input('member_name'),
            'target_month' => $date_explode[0],
            'target_year' => $date_explode[1],
            'total_ptn_target' => $request->input('target_patient'),
            'target_amnt' => $request->input('target_sales'),
            'achieved_opd_ptn_qty' => $request->input('opd_patient'),
            'achieved_ipd_ptn_qty' => $request->input('ipd_patient'),
            'achieved_opd_target_amnt' => $request->input('opd_sales'),
            'achieved_ipd_target_amnt' => $request->input('ipd_sales'),
            'au_update_at' => now(),
        ];

        try {
            DB::beginTransaction();

            if ($id) {
                // Update
                DB::table('pcrm_marketing_achivement')
                    ->where('achivement_no_pk', $id)
                    ->update($data);
                DB::commit();
                $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success'];
            } else {
                // Insert
                $sequence = DB::getSequence();
                $achivement_no_pk = $sequence->nextValue('achivement_no_pk_seq');

                $data['achivement_no_pk'] = $achivement_no_pk;
                $data['status'] = 1;
                $data['au_entry_hospital_pk_no'] = 141;
                $data['au_entry_session'] = 'session';
                $data['au_entry_by'] = auth::id();
                $data['au_entry_at'] = now();

                DB::table('pcrm_marketing_achivement')->insert($data);
                //  dd($data);
                DB::commit();
                return response()->json(['msg' => 'Data Saved Successfully', 'title' => 'Success']);
            }


        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function salesTeamedit($id)
    {
        $teams = DB::table('hrms_sales_team')->where('status', 1)->get();
        $target = DB::table("pcrm_marketing_achivement")->where('achivement_no_pk', $id)->first();
        $member_list = DB::table('hrms_personnel')->where('status', 1)->where('employee_ind', 1)->get();
        return Template::loadview("admin.sales.create_sales_team_target_form", compact('target', 'teams', 'member_list'));
    }


    // Marketing Report

    public function marketingReportMonthWise()
    {
        return Template::loadview("admin.sales.marketing_report");
    }

    public function marketingReportMonthWiseSearch(Request $request)
    {
        //  dd($request->all());
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $emp_type = $request->emp_type;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause mst.first_ref_doc_person_no_fk= $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($emp_type != "") ? " $clause ref.employee_ind= $emp_type" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $query = DB::select(DB::raw(" SELECT TO_CHAR (invoice_date, 'Monthyyyy') ref_month,
         FIRST_REF_DOC_PERSON_NO_FK,
         FULL_NAME,
         SUM (CASE WHEN NVL (admission_no_pk, 0) > 0 THEN 1 ELSE 0 END) ipd,
         SUM (CASE WHEN NVL (admission_no_pk, 0) = 0 THEN 1 ELSE 0 END) opd,
         SUM (LEDGER_AMT_SALES) sales,
         ROUND (SUM (LEDGER_AMT_DISCOUNT), 2) discount,
         ROUND (SUM (LEDGER_AMT_PAYMENT), 2) payment
    FROM finc_invoicemst mst, finc_ledgermst lmst, hrms_personnel REF
   WHERE     mst.invoice_no_pk = lmst.invoice_no_fk
         AND mst.FIRST_REF_DOC_PERSON_NO_FK = REF.person_no_pk
         AND mst.FIRST_REF_DOC_PERSON_NO_FK > 0
        $sql_cond
GROUP BY TO_CHAR (invoice_date, 'Monthyyyy'),
         TO_CHAR (invoice_date, 'mmyyyy'),
         FIRST_REF_DOC_PERSON_NO_FK,
         EMPLOYEE_IND,
         FULL_NAME"));

        $monthptData = [];
        foreach ($query as $key => $data) {
            $monthptData[$data->ref_month][] = $data;
        }
        return Template::loadview("admin.sales.marketing_report_list", [
            'data' => $monthptData,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

   public function marketingReportMonthWisePrintSummary(Request $request)
{
    // Fetch hospital details (could be cached for better performance)
    $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

    // Extract and validate date filters
    $date_from = $request->search_date_from ?? "";
    $date_to = $request->search_date_to ?? "";

    // Doctor ID and employee type filters
    $doctor_id = $request->doctor_id;
    $emp_type = $request->emp_type;

    // Build dynamic SQL conditions
    $sql_cond = "";
    $clause = " and";

    if ($date_from !== "" && $date_to !== "") {
        $sql_cond .= " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
    }
    if (!empty($doctor_id)) {
        $sql_cond .= " $clause mst.first_ref_doc_person_no_fk= $doctor_id";
    }
    if (!empty($emp_type)) {
        $sql_cond .= " $clause ref.employee_ind= $emp_type";
    }

    // Query report data
    $query = DB::select(DB::raw("
        SELECT 
            TO_CHAR(invoice_date, 'Monthyyyy') ref_month,
            FIRST_REF_DOC_PERSON_NO_FK,
            FULL_NAME,
            SUM(CASE WHEN NVL(admission_no_pk, 0) > 0 THEN 1 ELSE 0 END) ipd,
            SUM(CASE WHEN NVL(admission_no_pk, 0) = 0 THEN 1 ELSE 0 END) opd,
            SUM(LEDGER_AMT_SALES) sales,
            ROUND(SUM(LEDGER_AMT_DISCOUNT), 2) discount,
            ROUND(SUM(LEDGER_AMT_PAYMENT), 2) payment
        FROM finc_invoicemst mst
        JOIN finc_ledgermst lmst ON mst.invoice_no_pk = lmst.invoice_no_fk
        JOIN hrms_personnel ref ON mst.FIRST_REF_DOC_PERSON_NO_FK = ref.person_no_pk
        WHERE mst.FIRST_REF_DOC_PERSON_NO_FK > 0
        $sql_cond
        GROUP BY 
            TO_CHAR(invoice_date, 'Monthyyyy'),
            TO_CHAR(invoice_date, 'mmyyyy'),
            FIRST_REF_DOC_PERSON_NO_FK,
            EMPLOYEE_IND,
            FULL_NAME
    "));

    // Group data by month for PDF view
    $monthptData = [];
    foreach ($query as $data) {
        $monthptData[$data->ref_month][] = $data;
    }

    if ($request->hdn_report_type === 'PDF') {
        // Generate barcode and PDF
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.sales.marketing_report_pdf", [
            'barcode_no' => $barcode_no,
            'data' => $monthptData,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ]);
        return $pdf->stream('month-wise-opd-ipd-report.pdf');
    } else {
        // Flatten grouped data for Excel export
        $flatData = [];
        foreach ($monthptData as $month => $entries) {
            foreach ($entries as $row) {
                $flatData[] = [
                    'Month'       => $month,
                    'Doctor ID'   => $row->first_ref_doc_person_no_fk,
                    'Doctor Name' => $row->full_name,
                    'IPD Count'   => $row->ipd,
                    'OPD Count'   => $row->opd,
                    'Sales'       => $row->sales,
                    'Discount'    => $row->discount,
                    'Payment'     => $row->payment,
                ];
            }
        }

        // Use your ExcelHelper to export the data
        return ExcelHelper::export($flatData, 'month-wise-opd-ipd-report.xlsx');
    }
}








    public function marketingReportMonthWiseIncome()
    {
        return Template::loadview("admin.sales.marketing_report_income");
    }

    public function marketingReportMonthWiseSearchIncome(Request $request)
    {
        //  dd($request->all());
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $emp_type = $request->emp_type;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ipd.admission_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";







        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause mst.first_ref_doc_person_no_fk= $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($emp_type != "") ? " $clause ref.employee_ind= $emp_type" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $query = DB::select(DB::raw("SELECT mst.admission_no_pk,
         mst.patient_code,
         patient_name,
         fnc_serviceunitname (serviceunit_no_fk) department,
         SUM (CASE WHEN ledger_amt_sales > 0 THEN ledger_amt_sales ELSE 0 END)
            sales,
         SUM (
            CASE
               WHEN ledger_amt_sales < 0 THEN ABS (ledger_amt_sales)
               ELSE 0
            END)
            salescancel,
         SUM (
            CASE
               WHEN ledger_amt_discount > 0 THEN ledger_amt_discount
               ELSE 0
            END)
            discount,
         SUM (
            CASE
               WHEN ledger_amt_discount < 0 THEN ABS (ledger_amt_discount)
               ELSE 0
            END)
            discount_refund,
         SUM (
            CASE WHEN ledger_amt_payment > 0 THEN ledger_amt_payment ELSE 0 END)
            payment,
         SUM (
            CASE
               WHEN ledger_amt_payment < 0 THEN ABS (ledger_amt_payment)
               ELSE 0
            END)
            refund
    FROM finc_invoicemst mst,
         finc_ledgermst lmst,
         ipd_admission ipd,
         hrms_personnel doc,
         patn_registration reg
   WHERE     mst.invoice_no_pk = lmst.invoice_no_fk
         AND mst.admission_no_pk = ipd.admission_no_pk
         AND ipd.primary_doctor_no_fk = doc.person_no_pk
         AND IPD.PATIENT_NO_FK = REG.PATIENT_NO_PK
        $sql_cond
GROUP BY mst.admission_no_pk,
         mst.patient_code,
         serviceunit_no_fk,
         patient_name order by 1 desc"));
        return Template::loadview("admin.sales.marketing_report_list_income", [
            'data' => $query,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function marketingReportMonthWisePrintSummaryIncome(Request $request)
    {

        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $emp_type = $request->emp_type;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ipd.admission_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause mst.first_ref_doc_person_no_fk= $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($emp_type != "") ? " $clause ref.employee_ind= $emp_type" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $query = DB::select(DB::raw(" SELECT mst.admission_no_pk,
         mst.patient_code,
         patient_name,
         fnc_serviceunitname (serviceunit_no_fk) department,
         SUM (CASE WHEN ledger_amt_sales > 0 THEN ledger_amt_sales ELSE 0 END)
            sales,
         SUM (
            CASE
               WHEN ledger_amt_sales < 0 THEN ABS (ledger_amt_sales)
               ELSE 0
            END)
            salescancel,
         SUM (
            CASE
               WHEN ledger_amt_discount > 0 THEN ledger_amt_discount
               ELSE 0
            END)
            discount,
         SUM (
            CASE
               WHEN ledger_amt_discount < 0 THEN ABS (ledger_amt_discount)
               ELSE 0
            END)
            discount_refund,
         SUM (
            CASE WHEN ledger_amt_payment > 0 THEN ledger_amt_payment ELSE 0 END)
            payment,
         SUM (
            CASE
               WHEN ledger_amt_payment < 0 THEN ABS (ledger_amt_payment)
               ELSE 0
            END)
            refund
    FROM finc_invoicemst mst,
         finc_ledgermst lmst,
         ipd_admission ipd,
         hrms_personnel doc,
         patn_registration reg
   WHERE     mst.invoice_no_pk = lmst.invoice_no_fk
         AND mst.admission_no_pk = ipd.admission_no_pk
         AND ipd.primary_doctor_no_fk = doc.person_no_pk
         AND IPD.PATIENT_NO_FK = REG.PATIENT_NO_PK
        $sql_cond
GROUP BY mst.admission_no_pk,
         mst.patient_code,
         serviceunit_no_fk,
         patient_name  order by 1 desc"));


        if ($request->hdn_report_type === 'PDF') {
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            // return View("admin.sales.marketing_report_pdf", ['barcode_no' => $barcode_no, 'data' => $monthptData,'from_date' => $date_from, 'to_date' => $date_to ,'po_hospital_details' => $po_hospital_details]);
            $pdf = PDF::loadView("admin.sales.marketing_report_pdf_income", ['barcode_no' => $barcode_no, 'data' => $query, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
            ;
            return $pdf->stream('IPD_Patient_Wise_Daily_&_Monthly_Income_summary.pdf');
        } else {
            $pdf = ['data' => $query, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];

            $fileToExport = "marketing_report_pdf_income_summary";
            $html = View("admin.sales.marketing_report_pdf_income")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }
    }


    public function marketingMpoReportMonthWise()
    {
        return Template::loadview("admin.sales.marketing_report_mpo");
    }

    public function marketingMpoReportMonthWiseSearch(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $emp_type = $request->emp_type;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause REF.ref_agent_person_no_fk= $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($emp_type != "") ? " $clause ref.employee_ind= $emp_type" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $query = DB::select(DB::raw("SELECT TO_CHAR (invoice_date, 'Monthyyyy') ref_month,
                    TO_CHAR (invoice_date, 'mmyyyy'),
                    REF.FULL_NAME mpo_name,
                    REF.person_no_pk mpo_id,
                    REF.REF_AGENT_PERSON_NO_FK,
                    aREF.FULL_NAME,
                    SUM (CASE WHEN NVL (admission_no_pk, 0) > 0 THEN 1 ELSE 0 END) ipd,
                    SUM (CASE WHEN NVL (admission_no_pk, 0) = 0 THEN 1 ELSE 0 END) opd,
                    SUM (LEDGER_AMT_SALES) sales,
                    SUM (LEDGER_AMT_DISCOUNT) discount,
                    SUM (LEDGER_AMT_PAYMENT) payment
                FROM finc_invoicemst mst,
                    finc_ledgermst lmst,
                    hrms_personnel REF,
                    hrms_personnel aREF
            WHERE     mst.invoice_no_pk = lmst.invoice_no_fk
                    AND mst.FIRST_REF_DOC_PERSON_NO_FK = REF.person_no_pk
                    AND REF.REF_AGENT_PERSON_NO_FK = aREF.person_no_pk
                    AND mst.FIRST_REF_DOC_PERSON_NO_FK > 0
                    $sql_cond
            GROUP BY TO_CHAR (invoice_date, 'Monthyyyy'),
                    TO_CHAR (invoice_date, 'mmyyyy'),
                    REF.FULL_NAME,
                    REF.person_no_Pk,
                    REF.REF_AGENT_PERSON_NO_FK,
                    aREF.FULL_NAME
            ORDER BY 2"));

        $monthptData = [];
        foreach ($query as $key => $data) {
            $monthptData[$data->ref_month][$data->full_name][] = $data;
        }
        return Template::loadview("admin.sales.marketing_report_list_mpo", [
            'data' => $monthptData,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function marketingMpoReportMonthWisePrintSummary(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $emp_type = $request->emp_type;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause REF.ref_agent_person_no_fk= $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($emp_type != "") ? " $clause ref.employee_ind= $emp_type" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $query = DB::select(DB::raw("SELECT TO_CHAR (invoice_date, 'Monthyyyy') ref_month,
                    TO_CHAR (invoice_date, 'mmyyyy'),
                    REF.FULL_NAME mpo_name,
                    REF.person_no_pk mpo_id,
                    REF.REF_AGENT_PERSON_NO_FK,
                    aREF.FULL_NAME,
                    SUM (CASE WHEN NVL (admission_no_pk, 0) > 0 THEN 1 ELSE 0 END) ipd,
                    SUM (CASE WHEN NVL (admission_no_pk, 0) = 0 THEN 1 ELSE 0 END) opd,
                    SUM (LEDGER_AMT_SALES) sales,
                    SUM (LEDGER_AMT_DISCOUNT) discount,
                    SUM (LEDGER_AMT_PAYMENT) payment
                FROM finc_invoicemst mst,
                    finc_ledgermst lmst,
                    hrms_personnel REF,
                    hrms_personnel aREF
            WHERE     mst.invoice_no_pk = lmst.invoice_no_fk
                    AND mst.FIRST_REF_DOC_PERSON_NO_FK = REF.person_no_pk
                    AND REF.REF_AGENT_PERSON_NO_FK = aREF.person_no_pk
                    AND mst.FIRST_REF_DOC_PERSON_NO_FK > 0
                    $sql_cond
            GROUP BY TO_CHAR (invoice_date, 'Monthyyyy'),
                    TO_CHAR (invoice_date, 'mmyyyy'),
                    REF.FULL_NAME,
                    REF.person_no_Pk,
                    REF.REF_AGENT_PERSON_NO_FK,
                    aREF.FULL_NAME
            ORDER BY 2"));

        $monthptData = [];
        foreach ($query as $key => $data) {
            $monthptData[$data->ref_month][$data->full_name][] = $data;
        }
        if ($request->hdn_report_type === 'PDF') {
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.sales.marketing_report__mpo_pdf", ['barcode_no' => $barcode_no, 'data' => $monthptData, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
            return $pdf->stream('mpo_month-wise-opd&ipd-report.pdf');
        } else {
            $pdf = ['data' => $monthptData, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];

            $fileToExport = "mpo_month_wise_OPD_IPD";
            $html = View("admin.sales.marketing_report__mpo_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }
    }






    public function teamDelete($id)
    {
        // Start transaction
        DB::beginTransaction();

        try {
            // Update the team build table to mark the team as deleted (status = 0)
            DB::table('hrms_team_build')->where('employee_no_fk', $id)->update([
                'status' => 0,
                'au_entry_hospital_pk_no' => 141,
                'au_entry_session' => 'session',
                'au_entry_by' => Auth::id(),
                'au_entry_at' => now(),
                'au_update_at' => now(),
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Return a response with error message
            return response()->json(['success' => false, 'message' => 'Failed to delete team']);
        }
    }
    public function activeMember($id)
    {
        // Start transaction
        DB::beginTransaction();

        try {
            // Update the team build table to mark the team as deleted (status = 0)
            DB::table('hrms_team_build')->where('employee_no_fk', $id)->update([
                'status' => 1,
                'au_entry_hospital_pk_no' => 141,
                'au_entry_session' => 'session',
                'au_entry_by' => Auth::id(),
                'au_entry_at' => now(),
                'au_update_at' => now(),
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Return a response with error message
            return response()->json(['success' => false, 'message' => 'Failed to delete team']);
        }
    }

    public function addNewMemberStore(Request $request)
    {
        // dd($request->all());
        // Validate the input data
        $validated = $request->validate([
            // 'teamName' => 'required|string',
            // 'teamId' => 'required|integer|exists:hrms_sales_team,team_no_pk',
            'areas' => 'required|array|min:1',
            'areas.*' => 'integer|exists:pcrm_marketing_area,area_no_pk',
            'lead' => 'required|in:Y,N',
        ]);

        DB::beginTransaction();

        try {
            // Check if teamName is null or empty and handle it accordingly
            // if (empty($request->teamName)) {
            //     throw new \Exception('Team Name is required.');
            // }

            // Use the correct method to get the next sequence value for team build
            $sequence = DB::getSequence();
            $team_name = DB::table('hrms_sales_team')->where('team_no_pk', $request->teamId)->first()->team_name;
            // Update the team info
            DB::table('hrms_sales_team')->where('team_no_pk', $request->teamId)->update([
                'team_name' => $team_name,
                'team_code' => $team_name, // Modify as needed for team code logic
                'status' => 1,
                'au_entry_hospital_pk_no' => 141,
                'au_entry_session' => 'session',
                'au_entry_by' => Auth::id(),
                'au_entry_at' => now(),
                'au_update_at' => now(),
            ]);

            // Assuming member information comes from somewhere, for now using a placeholder for member ID
            $memberId = $request->memberId;  // You should get the correct member ID based on your application flow

            // Get the next team build PK value from the sequence
            $team_build_no_pk_seq = $sequence->nextValue('team_build_no_pk_seq');

            // Insert member into the hrms_team_build table
            DB::table('hrms_team_build')->insert([
                'team_build_no_pk' => $team_build_no_pk_seq,
                'team_no_fk' => $request->teamId,
                'employee_no_fk' => $memberId,  // You should pass or find member ID based on logic
                'status' => 1,
                'au_entry_hospital_pk_no' => 141,
                'au_entry_session' => 'session',
                'au_entry_by' => Auth::id(),
                'au_entry_at' => now(),
                'au_update_at' => now(),
            ]);

            // Loop through areas associated with the member
            foreach ($request->areas as $area) {
                // Ensure area exists before updating
                DB::table('pcrm_marketing_area')->where('area_no_pk', $area)->update([
                    'supervisor_person_no_fk' => $memberId,
                ]);
            }

            // Commit the transaction if everything is successful
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Team saved successfully!',
            ]);

        } catch (\Exception $e) {
            // Rollback if something went wrong
            DB::rollBack();
            \Log::error('Error saving team: ' . $e->getMessage()); // Log the error for debugging

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error saving team: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function agentWiseReferral($id)
    {
        $agent_name = DB::table('hrms_personnel')->where('person_no_pk', $id)->value('full_name');
        $refTypes = $this->getLookupListByCode("referral_type");
        $members = DB::table('hrms_personnel')
            ->select('person_code', 'full_name', 'salutation', 'lookupdata_name')
            ->leftjoin('sysc_lookupdata', 'hrms_personnel.referral_type_lookup_no_fk', '=', 'sysc_lookupdata.lookupdata_no_pk')
            ->where('ref_agent_person_no_fk', $id)
            ->get();
        return Template::loadView('admin.sales.marketing_team_list', compact('members', 'agent_name', 'refTypes'));
    }

    public function agentMembersSearch(Request $request)
    {
        // Get doctor_id and ref_type from the request
        $doctor_id = $request->doctor_id;
        $ref_type = $request->ref_type;
        $members = DB::table('hrms_personnel')
            ->select('person_code', 'full_name', 'salutation', 'lookupdata_name')
            ->leftjoin('sysc_lookupdata', 'hrms_personnel.referral_type_lookup_no_fk', '=', 'sysc_lookupdata.lookupdata_no_pk');

        if ($doctor_id) {
            $members->where('doctor_id', $doctor_id);
        }

        if ($ref_type) {
            $members->where('hrms_personnel.referral_type_lookup_no_fk', $ref_type);
        }

        $members = $members->get();
        return response()->json([
            'members' => $members
        ]);
    }


    public function referralDoctor()
    {
        $referralTypesDt = $this->getLookupListByCode("referral_type");
        $service_unit = ServiceUnit::where('status', '1')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->get();
        $Mragents = DB::table('hrms_personnel')
            // ->where('status', 1)
            // ->where('employee_ind', 1)
            ->select('person_no_pk', 'full_name')
            ->where('mpo_ind', 1)
            ->where('referral_agent_ind', 1)
            ->get();

        $employee_info = DB::select("SELECT photo_name, person_code,card_no, full_name, age,  gender_txt ,specialization, designation,su_name,phone_mobile, pe_addr1, email_personal, status,person_no_pk, rownum rownumber, au_update_at, au_entry_at FROM employee_info_vw where employee_ind = 1 order By person_no_pk desc FETCH NEXT 20 ROWS ONLY ");
        $teams = DB::select('select person_no_pk,full_name,person_code from hrms_personnel where status = 1 and employee_ind = 1 and referral_agent_ind = 1');

        return Template::loadview("mCare.marketing_referral_doctor", [
            "employee_info" => $employee_info,
            'service_unit' => $service_unit,
            'referralTypesDt' => $referralTypesDt,
            'Mragents' => $Mragents,

        ]);
    }
    public function referralDoctorList(Request $request)
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id and doctor_ind = 1";

        $table = 'employee_info_vw';
        // Table's primary key
        $primaryKey = 'person_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            // array('db' => 'photo_name', 'dt' => 1),
            array('db' => 'person_code', 'dt' => 1),
            // array('db' => 'card_no',   'dt' => 3),
            array('db' => 'full_name', 'dt' => 2),
            // array('db' => 'age',   'dt' => 5),
            // array('db' => 'gender_txt',   'dt' => 6),
            // array('db' => 'specialization',   'dt' => 7),
            // array('db' => 'designation',   'dt' => 8),
            array('db' => 'su_name', 'dt' => 3),
            // array('db' => 'phone_mobile',   'dt' => 4),
            // array('db' => 'email_personal',   'dt' => 11),
            array('db' => 'pe_addr1', 'dt' => 4),
            // array('db' => 'status',   'dt' => 13),
            array('db' => 'agent_name', 'dt' => 5),
            array('db' => 'referral_type', 'dt' => 6),
            array('db' => 'referral_payable_ind', 'dt' => 7),
            array('db' => 'person_no_pk', 'dt' => 8),
            array('db' => 'ref_agent_person_no_fk', 'dt' => 9),
            array('db' => 'referral_type_lookup_no_fk', 'dt' => 10),
            // array('db' => 'emp_status',   'dt' => 15)

        );
        // dd($sql_cond);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    // Controller method
    public function referralDoctorUpdateCheckboxStatus(Request $request)
    {
        DB::table('hrms_personnel')->where('person_no_pk', $request->person_id)->update(['referral_payable_ind' => $request->status]);
        return response()->json(['success' => true]);
    }
    // Update Referral Agent
    public function referralDoctorUpdateAgent(Request $request)
    {
        // Validate input
        $request->validate([
            'person_id' => 'required|integer',
            'value' => 'nullable|integer'  // Agent can be null if no agent is selected
        ]);

        // Update referral agent in database
        DB::table('hrms_personnel')
            ->where('person_no_pk', $request->person_id)
            ->update(['ref_agent_person_no_fk' => $request->value]);

        return response()->json(['success' => true]);
    }

    // Update Referral Type
    public function referralDoctorUpdateType(Request $request)
    {
        // Validate input
        $request->validate([
            'person_id' => 'required|integer',
            'value' => 'nullable|integer'  // Referral type can be null if no type is selected
        ]);

        // Update referral type in database
        DB::table('hrms_personnel')
            ->where('person_no_pk', $request->person_id)
            ->update(['referral_Type_lookup_no_fk' => $request->value]);

        return response()->json(['success' => true]);
    }

    public function getOptions()
    {
        // Fetch agents (person_no_pk and full_name)
        $agents = DB::table('hrms_personnel')
            // ->where('status', 1)
            ->where('mpo_ind', 1)
            ->select('person_no_pk', 'full_name')
            ->where('referral_agent_ind', 1)
            ->get();
        // dd($agents);

        return response()->json([
            'agents' => $agents,
        ]);
    }

    public function getReferralTypes()
    {
        // Get all referral types from the database (you can modify this as needed)
        $referralTypes = $this->getLookupListByCode("referral_type");

        return response()->json([
            'referral_types' => $referralTypes
        ]);
    }

    public function referralLedger()
    {
        // $doctors = DB::table('hrms_personnel')
        //     ->select('person_no_pk', 'full_name', 'person_code', 'pe_addr1')
        //     ->where('referal_ind', 1)
        //     ->get();
        $doctors = [];
        $agents = DB::table('hrms_personnel')
            ->select('person_no_pk', 'full_name', 'person_code', 'pe_addr1')
            ->where('referral_agent_ind', 1)
            ->where('mpo_ind', 1)
            ->get();
        $areas = DB::table('user_wise_coverage_vw')
            ->select('BRANCH_NAME', 'HOSPITAL_NO_PK')
            ->where('user_no_pk', Session::get('user.ses_user_pk_no'))
            ->orderBy('branch_name', 'Asc')
            ->get();
        return Template::loadview("admin.sales.referral_ledger", [
            'areas' => $areas,
            'agents' => $agents,
            'doctors' => $doctors,
            'type' => '',
        ]);
    }

    public function referralReportSearch(Request $request)
    {
        // dd($request->all());
        // Retrieve request inputs
        $type = '';
        $mtg_area = $request->mtg_area;
        $agent = $request->agent;
        $referral_id = $request->referral_id;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $show_dues_only = $request->show_dues_only;
        $exclude_previous_dues = $request->exclude_previous_dues;
        $exclude_special_items = $request->exclude_special_items;
        $quantity_only = $request->quantity_only;
        $referral_summary = $request->referral_summary_1;
        $referral_performance = $request->referral_performance;
        $referral_summary_2 = $request->referral_summary_2;

        // Date range handling
        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Initialize SQL condition array
        $sql_cond = [];

        // Handle date range condition
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(ledgertrn_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        // Handle additional conditions
        if ($mtg_area) {
            $sql_cond[] = "branch_id = '$mtg_area'";
        }

        if ($agent) {
            $sql_cond[] = "mkt_officer_id = '$agent'";
        }
        if ($referral_id) {
            $sql_cond[] = "referral_id = '$referral_id'";
        }

        // Handle boolean flag conditions
        if ($show_dues_only === 'on') {
            $sql_cond[] = "dues_only = 1";  // Assuming dues_only is a column in the DB
        }

        if ($exclude_previous_dues === 'on') {
            $sql_cond[] = "exclude_previous_dues = 1";  // Assuming exclude_previous_dues is a column
        }

        if ($exclude_special_items === 'on') {
            $sql_cond[] = "exclude_special_items = 1";  // Assuming exclude_special_items is a column
        }

        if ($quantity_only === 'on') {
            $sql_cond[] = "quantity_only = 1";  // Assuming quantity_only is a column
        }

        // Construct final SQL condition string
        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // Handle the referral summary condition and calculate totals
        if ($referral_summary === 'on') {
            $query = "SELECT REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (PAYEMNT) AS TOTAL_PAYMENT,
                SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                SUM (NET_SALES) AS TOTAL_NET_SALES,
                SUM (DUE) AS TOTAL_DUE,
                SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT, referral_payable_ind,
         MKT_OFFICER_ID
            FROM FINC_REFERRAL_SUMMARY_VW
             JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
        $sql_where and referral_payable_ind = 1
        GROUP BY REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,referral_payable_ind,
         MKT_OFFICER_ID order by TOTAL_SALES desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary_1';
        } elseif ($referral_summary_2 === 'on') {
            $query = "SELECT REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT
            FROM FINC_REFERRAL_SUMMARY_VW
       JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
        $sql_where and referral_payable_ind = 1
        GROUP BY REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,referral_payable_ind order by TOTAL_SALES desc";

            $report_data = DB::select($query);
            $type = 'referral_summary_2';
        } elseif ($referral_performance === 'on') {
            $query = "SELECT REFERRAL_NAME,
                BRANCH_NAME,REFERRAL_ID,REFERRAL_ADDR,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (PAYEMNT) AS TOTAL_PAYMENT,
                SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                SUM (NET_SALES) AS TOTAL_NET_SALES,
                SUM (DUE) AS TOTAL_DUE,
                SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,referral_payable_ind
            FROM FINC_REFERRAL_SUMMARY_VW
            LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
        $sql_where
        GROUP BY REFERRAL_NAME, BRANCH_NAME,REFERRAL_ID,REFERRAL_ADDR,referral_payable_ind order by TOTAL_INVOICE_QTY desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_performance';
        } else {
            // Construct the SQL query to group by referral_doc_name and calculate totals
            $query = "SELECT REFERRAL_NAME,
                        BRANCH_NAME,
                        REFERRAL_ID,
                        SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                        SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                        SUM (TOTAL_SALES) AS TOTAL_SALES,
                        SUM (PAYEMNT) AS TOTAL_PAYMENT,         -- Updated to match 'PAYMENT'
                        SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                        SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                        SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                        SUM (NET_SALES) AS TOTAL_NET_SALES,
                        SUM (DUE) AS TOTAL_DUE,                     -- Updated to match 'DUE'
                        SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                        SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,
                        referral_payable_ind
                    FROM FINC_REFERRAL_SUMMARY_VW
                        LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
                        $sql_where
                GROUP BY REFERRAL_NAME,
                        BRANCH_NAME,
                        REFERRAL_ID,
                        referral_payable_ind
                ORDER BY TOTAL_INVOICE_QTY DESC";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary';
        }

        return Template::loadview("admin.sales.referral_ledger_sales", [
            'data' => $report_data,
            'type' => $type,
            'agent' => $agent,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ]);
    }




    public function referralReportPdf(Request $request)
    {
        $type = '';
        $mtg_area = $request->mtg_area;
        $agent = $request->agent;
        $referral_id = $request->referral_id;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $show_dues_only = $request->show_dues_only;
        $exclude_previous_dues = $request->exclude_previous_dues;
        $exclude_special_items = $request->exclude_special_items;
        $quantity_only = $request->quantity_only;
        $referral_summary = $request->referral_summary_1;
        $referral_performance = $request->referral_performance;
        $referral_summary_2 = $request->referral_summary_2;

        // Date range handling
        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Initialize SQL condition array
        $sql_cond = [];
        $agent_dt = '';

        // Handle date range condition
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(ledgertrn_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        // Handle additional conditions
        if ($mtg_area) {
            $sql_cond[] = "branch_id = '$mtg_area'";
        }

        if ($agent) {
            $sql_cond[] = "mkt_officer_id = '$agent'";
            $agent_dt = DB::table('hrms_personnel')->select('full_name', 'person_code')->where('person_no_pk', $agent)->first();
        }
        if ($referral_id) {
            $sql_cond[] = "referral_id = '$referral_id'";
        }

        // Handle boolean flag conditions
        if ($show_dues_only === 'on') {
            $sql_cond[] = "dues_only = 1";  // Assuming dues_only is a column in the DB
        }

        if ($exclude_previous_dues === 'on') {
            $sql_cond[] = "exclude_previous_dues = 1";  // Assuming exclude_previous_dues is a column
        }

        if ($exclude_special_items === 'on') {
            $sql_cond[] = "exclude_special_items = 1";  // Assuming exclude_special_items is a column
        }

        if ($quantity_only === 'on') {
            $sql_cond[] = "quantity_only = 1";  // Assuming quantity_only is a column
        }

        // Construct final SQL condition string
        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // Handle the referral summary condition and calculate totals
        if ($referral_summary === 'on') {
            $query = "SELECT REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,
            SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
            SUM (TEST_QTY) AS TOTAL_TEST_QTY,
            SUM (TOTAL_SALES) AS TOTAL_SALES,
            SUM (PAYEMNT) AS TOTAL_PAYMENT,
            SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
            SUM (DISCOUNT) AS TOTAL_DISCOUNT,
            SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
            SUM (NET_SALES) AS TOTAL_NET_SALES,
            SUM (DUE) AS TOTAL_DUE,
            SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
            SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT, referral_payable_ind
        FROM FINC_REFERRAL_SUMMARY_VW
         JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
    $sql_where and referral_payable_ind = 1
    GROUP BY REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,referral_payable_ind order by TOTAL_SALES desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary_1';
        } elseif ($referral_summary_2 === 'on') {
            $query = "SELECT REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,
            SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
            SUM (TOTAL_SALES) AS TOTAL_SALES,
            SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT
        FROM FINC_REFERRAL_SUMMARY_VW
   JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
    $sql_where and referral_payable_ind = 1
    GROUP BY REFERRAL_NAME,REFERRAL_ID,REFERRAL_ADDR,referral_payable_ind order by TOTAL_SALES desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary_2';
        } elseif ($referral_performance === 'on') {
            $query = "SELECT REFERRAL_NAME,
                BRANCH_NAME,REFERRAL_ID,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (PAYEMNT) AS TOTAL_PAYMENT,
                SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                SUM (NET_SALES) AS TOTAL_NET_SALES,
                SUM (DUE) AS TOTAL_DUE,
                SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,referral_payable_ind
            FROM FINC_REFERRAL_SUMMARY_VW
            LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
        $sql_where
        GROUP BY REFERRAL_NAME, BRANCH_NAME,REFERRAL_ID,referral_payable_ind order by TOTAL_INVOICE_QTY desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_performance';
        } else {
            // Construct the SQL query to group by referral_doc_name and calculate totals
            $query = "SELECT REFERRAL_NAME,
                        BRANCH_NAME,
                        REFERRAL_ID,
                        SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                        SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                        SUM (TOTAL_SALES) AS TOTAL_SALES,
                        SUM (PAYEMNT) AS TOTAL_PAYMENT,         -- Updated to match 'PAYMENT'
                        SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                        SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                        SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                        SUM (NET_SALES) AS TOTAL_NET_SALES,
                        SUM (DUE) AS TOTAL_DUE,                     -- Updated to match 'DUE'
                        SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                        SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,
                        referral_payable_ind
                    FROM FINC_REFERRAL_SUMMARY_VW
                        LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
                        $sql_where
                GROUP BY REFERRAL_NAME,
                        BRANCH_NAME,
                        REFERRAL_ID,
                        referral_payable_ind
                ORDER BY TOTAL_INVOICE_QTY DESC";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary';
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.sales.referral_ledger_sales_pdf", [
                'data' => $report_data,
                'type' => $type,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'agent_dt' => $agent_dt,
                'agent' => $agent,
                'po_hospital_details' => $po_hospital_details
            ]);
        } else {

            $pdf = [
                'data' => $report_data,
                'type' => $type,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'po_hospital_details' => $po_hospital_details
            ];

            $fileToExport = "referral_ledger_report";

            // Generate HTML content using the Blade view
            $html = View("admin.sales.referral_ledger_sales_pdf")->with($pdf);

            // Set headers to prompt download as Excel file
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");

            // Return the HTML content
            return $html;
        }
    }

    public function referralDoctorDetails($id, $from, $to)
    {
        $carbonDate = Carbon::createFromFormat('d-m-y', $to);
        $carbonDate1 = Carbon::createFromFormat('d-m-y', $from);

        $refdata = DB::table('FINC_REFERRAL_INVOICEWISE_COL_VW')
            ->where('REFERAL_PERSON_NO_FK', $id)
            ->whereBetween(DB::raw('TRUNC(collection_date)'), [$carbonDate1->format('Y/m/d'), $carbonDate->format('Y/m/d')])
            ->orderBy('COLLECTION_DATE', 'asc')
            ->get();
        $referral_name = DB::table('employee_info_vw')
            ->select('full_name')
            ->where('person_no_pk', $id)
            ->first();
        $referralData = [];

        foreach ($refdata as $ref) {
            $referralData[$ref->branch_name][$ref->session_ip . ' ' . $ref->branch_name][] = $ref;
        }
        return view("admin.sales.doctor_details_referral", [
            'referralData' => $referralData,
            'referral_name' => $referral_name
        ]);
    }
    public function investigationWiseDetails($id, $from, $to, $mkt_id = '')
    {
        // Parse the dates using Carbon
        $carbonDate = Carbon::createFromFormat('d-m-y', $to);
        $carbonDate1 = Carbon::createFromFormat('d-m-y', $from);
        $invoicelist = DB::table('FINC_REFERRAL_SUMMARY_VW')
            ->select('invoice_no_pk')
            ->where('referral_id', $id)
            ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [$carbonDate1->format('Y/m/d'), $carbonDate->format('Y/m/d')])
            ->pluck('invoice_no_pk');

        $refdata = DB::table('FINC_REFERRAL_INVOICEDTL_VW')
            ->whereIn('invoice_no_pk', $invoicelist) // Filter by invoice numbers
            ->where(function ($query) {
                $query->where('item_type', 'LAB')
                    ->orWhere('item_type', 'RAD');
            })
            ->orderBy('invoice_code', 'ASC')
            ->get([
                'invoice_code',
                'due_ind',
                'branch_name',
                'INVOICE_DATE',
                'CUSTOMER_NAME',
                'INVOICEMST_AMT_SALES',
                'INVOICEDTL_AMT_PAYMENT',
                'INVOICEDTL_AMT_DISCOUNT',
                'invoicemst_amt_discount',
                'INVOICEMST_AMT_PAYMENT',
                'DISC_AMT_BY_DOC',
                'ITEM_NAME',
                'ITEM_RATE',
                'ITEM_TYPE',
                'MAX_DISC_PCT',
                'ITEM_QTY'
            ]);


        // Step 3: Fetch referral name based on person code
        $referral_name = DB::table('employee_info_vw')
            ->select('person_code', 'full_name', 'person_no_pk')
            ->where('person_no_pk', $id)
            ->first();

        // Step 4: If there's no refdata, set default branch name
        $branch_name = $refdata->isNotEmpty() ? $refdata[0]->branch_name : 'Unknown Branch';

        // Step 5: Group the referral data by item name
        $referralData = $refdata->groupBy('item_name'); // Eloquent collection method to group by

        $invoiceCount = DB::table('FINC_REFERRAL_SUMMARY_VW')
            ->where('referral_id', $id)
            ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [$carbonDate1->format('Y/m/d'), $carbonDate->format('Y/m/d')])
            ->count('invoice_no_pk');


        if ($mkt_id != '') {
            $serial = DB::table('FINC_REFERRAL_SUMMARY_VW')
                ->join('hrms_personnel', 'referral_id', 'person_no_pk')
                ->where('referral_payable_ind', 1)
                ->where('mkt_officer_id', $mkt_id)
                ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [$carbonDate1->format('Y/m/d'), $carbonDate->format('Y/m/d')])
                ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY SUM(TOTAL_SALES) DESC) AS SERIAL'), 'REFERRAL_NAME', 'REFERRAL_ID', 'REFERRAL_ADDR', 'referral_payable_ind', DB::raw('SUM(TOTAL_SALES) AS total_sales'))
                ->groupBy('REFERRAL_NAME', 'REFERRAL_ID', 'REFERRAL_ADDR', 'referral_payable_ind') // Correct group by
                ->get();
        } else {
            $serial = DB::table('finc_referral_summary_vw')
                ->join('hrms_personnel', 'referral_id', 'person_no_pk')
                ->where('referral_payable_ind', 1)
                ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [$carbonDate1->format('Y/m/d'), $carbonDate->format('Y/m/d')])
                ->select(db::raw('row_number() over (order by sum(total_sales) desc) as serial'), 'referral_name', 'referral_id', 'referral_addr', 'referral_payable_ind', db::raw('sum(total_sales) as total_sales'))
                ->groupby('referral_name', 'referral_id', 'referral_addr', 'referral_payable_ind') // correct group by
                ->get();
        }
        // dd($serial);
        // Step 6: Return the view with the necessary data
        return view("admin.sales.doctor_details_referral_item", [
            'referralData' => $referralData,
            'referral_name' => $referral_name,
            'from' => $from,
            'to' => $to,
            'invoiceCount' => $invoiceCount,
            'branch_name' => $branch_name,
            'serial' => $serial,
        ]);
    }

    public function updateReferralCheckbox(Request $request)
    {
        // Get the selected referral IDs and all referral IDs from the request
        $selectedReferralIds = $request->selected_referral_ids;
        $allReferralIds = $request->referral_ids;

        // Validate the referral IDs: they must be arrays and not empty
        if (empty($selectedReferralIds) || !is_array($selectedReferralIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid referral IDs.',
            ]);
        }

        // Update the referral_payable_ind field in the database for the selected referral IDs
        DB::beginTransaction();

        // Mark selected referrals as payable (checked)
        DB::table('hrms_personnel')
            ->whereIn('person_no_pk', $selectedReferralIds)
            ->update([
                'referral_payable_ind' => 1,
            ]);

        // Mark all other referrals as not payable (unchecked)
        $unselectedReferralIds = array_diff($allReferralIds, $selectedReferralIds);
        DB::table('hrms_personnel')
            ->whereIn('person_no_pk', $unselectedReferralIds)
            ->update([
                'referral_payable_ind' => null,  // or 0 if you want to explicitly mark it as unchecked
            ]);

        DB::commit();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Referral selection updated successfully!',
        ]);
    }
    public function printLedger(Request $request)
    {
        // Get the request inputs
        $serial_from = $request->input('serial_from');
        $serial_to = $request->input('serial_to');
        $from = $request->input('date_from');
        $to = $request->input('date_to');
        $limit = $request->input('limit');

        // Fetch the referral data within the date range
        $refdata = DB::table('FINC_REFERRAL_INVOICEDTL_VW')
            ->select(
                'invoice_code',
                'due_ind',
                'branch_name',
                'INVOICE_DATE',
                'CUSTOMER_NAME',
                'INVOICEMST_AMT_SALES',
                'INVOICEMST_AMT_PAYMENT',
                'INVOICEDTL_AMT_PAYMENT',
                'INVOICEDTL_AMT_DISCOUNT',
                'invoicemst_amt_discount',
                'INVOICEMST_AMT_PAYMENT',
                'DISC_AMT_BY_DOC',
                'ITEM_NAME',
                'ITEM_RATE',
                'ITEM_TYPE',
                'PERSON_NO_FK',
                'MAX_DISC_PCT',
                'ITEM_QTY',
                DB::raw('SUM(INVOICEMST_AMT_SALES) as total_sales')
            )
            ->whereBetween(DB::raw('TRUNC(INVOICE_DATE)'), [
                Carbon::createFromFormat('d/m/Y', $from)->startOfDay(),
                Carbon::createFromFormat('d/m/Y', $to)->endOfDay()
            ])
            ->where(function ($query) {
                $query->where('item_type', 'LAB')
                    ->orWhere('item_type', 'RAD');
            })
            ->groupBy(
                'invoice_code',
                'due_ind',
                'branch_name',
                'INVOICE_DATE',
                'CUSTOMER_NAME',
                'INVOICEMST_AMT_SALES',
                'INVOICEMST_AMT_PAYMENT',
                'INVOICEDTL_AMT_PAYMENT',
                'INVOICEDTL_AMT_DISCOUNT',
                'invoicemst_amt_discount',
                'INVOICEMST_AMT_PAYMENT',
                'DISC_AMT_BY_DOC',
                'ITEM_NAME',
                'ITEM_RATE',
                'ITEM_TYPE',
                'PERSON_NO_FK',
                'MAX_DISC_PCT',
                'ITEM_QTY'
            )
            ->orderByDesc('total_sales')
            ->get();


        // Group data by Employee (PERSON_NO_FK) and then by Item (ITEM_NAME)
        $groupedByEmployee = $refdata->groupBy('person_no_fk');

        // Get employee details to map to employee name and code
        $employeeInfo = DB::table('employee_info_vw')
            ->whereIn('person_no_pk', $groupedByEmployee->keys())
            ->get()
            ->keyBy('person_no_pk');

        // Paginate based on serial_from and serial_to
        $start = $serial_from - 1;
        $end = $serial_to;
        $slicedData = $groupedByEmployee->slice($start, $end - $start);
        // dd($slicedData);

        $ledgerPages = [];

        $invoiceCount = DB::table('FINC_REFERRAL_SUMMARY_VW')
            // ->where('referral_id', $id)
            ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [
                Carbon::createFromFormat('d/m/Y', $from)->startOfDay(),
                Carbon::createFromFormat('d/m/Y', $to)->endOfDay()
            ])
            ->count('invoice_no_pk');

        $serial = DB::table('FINC_REFERRAL_SUMMARY_VW')
            ->leftjoin('hrms_personnel', 'referral_id', 'person_no_pk')
            ->where('referral_payable_ind', 1)
            ->whereBetween(DB::raw('TRUNC(ledgertrn_date)'), [
                Carbon::createFromFormat('d/m/Y', $from)->startOfDay(),
                Carbon::createFromFormat('d/m/Y', $to)->endOfDay()
            ])
            ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY SUM(TOTAL_SALES) DESC) AS SERIAL'), 'REFERRAL_NAME', 'BRANCH_NAME', 'REFERRAL_ID', 'REFERRAL_ADDR', 'referral_payable_ind', DB::raw('SUM(TOTAL_SALES) AS total_sales'))
            ->groupBy('REFERRAL_NAME', 'BRANCH_NAME', 'REFERRAL_ID', 'REFERRAL_ADDR', 'referral_payable_ind') // Correct group by
            ->get();
        // ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY SUM(TOTAL_SALES) DESC) AS SERIAL'), 'referral_id', DB::raw('SUM(TOTAL_SALES) AS total_sales'))
        // ->groupBy('referral_id') // Correct group by
        // ->get();
        foreach ($slicedData as $employeeId => $employeeData) {
            $employee = $employeeInfo->get($employeeId);
            $employeeName = $employee ? $employee->full_name : 'Unknown Employee';
            $employeeCode = $employee ? $employee->person_code : 'Unknown Code';
            $branch_name = $employee ? $employee->branch_name : 'Unknown Branch';
            $person_no_pk = $employee ? $employeeId : 'Unknown Branch';

            $employeeLedger = [
                'employee_name' => $employeeName,
                'employee_code' => $employeeCode,
                'person_no_pk' => $person_no_pk,
                'branch_name' => $branch_name,
                'items' => [] // Changed to items, grouped by item_name
            ];

            // Group data by item name for the current employee
            foreach ($employeeData as $data) {
                // Initialize the item data if not already initialized
                if (!isset($employeeLedger['items'][$data->item_name])) {
                    $employeeLedger['items'][$data->item_name] = [];
                }

                // Add invoice details under the item name
                $employeeLedger['items'][$data->item_name][] = [
                    'invoice_code' => $data->invoice_code,
                    'invoice_date' => $data->invoice_date,
                    'customer_name' => $data->customer_name,
                    'amt_sales' => $data->invoicemst_amt_sales,
                    'amt_payment' => $data->invoicemst_amt_payment,
                    'item_name' => $data->item_name,
                    'item_rate' => $data->item_rate,
                    'item_type' => $data->item_type,
                    'max_disc_pct' => $data->max_disc_pct,
                    'item_qty' => $data->item_qty,
                    'invoicedtl_amt_payment' => $data->invoicedtl_amt_payment,
                    'invoicedtl_amt_discount' => $data->invoicedtl_amt_discount,
                    'disc_amt_by_doc' => $data->disc_amt_by_doc,
                    'invoicemst_amt_sales' => $data->invoicemst_amt_sales,
                    'invoicemst_amt_discount' => $data->invoicemst_amt_discount,
                    'invoicemst_amt_payment' => $data->invoicemst_amt_payment,
                    'due_ind' => $data->due_ind,
                ];
            }

            // Add the employee's data to the ledgerPages array
            $ledgerPages[] = $employeeLedger;
        }
        // Return the view with the ledger pages
        return view('admin.sales.print_ledger', compact('ledgerPages', 'serial_from', 'serial_to', 'limit', 'from', 'to', 'invoiceCount', 'serial'));
    }


    public function referralReport()
    {
        $agents = DB::table('hrms_personnel')
            ->select('person_no_pk', 'full_name', 'person_code')
            ->where('referral_agent_ind', 1)
            ->where('mpo_ind', 1)
            ->get();
        $areas = DB::table('user_wise_coverage_vw')
            ->select('BRANCH_NAME', 'HOSPITAL_NO_PK')
            ->where('user_no_pk', Session::get('user.ses_user_pk_no'))
            ->orderBy('branch_name', 'Asc')
            ->get();
        return Template::loadview("admin.sales.referral_report", [
            'areas' => $areas,
            'agents' => $agents,
            'type' => '',
        ]);
    }

    public function marketingReportSearch(Request $request)
    {
        // Retrieve request inputs
        $type = '';
        $mtg_area = $request->mtg_area;
        $agent = $request->agent;
        $referral_id = $request->referral_id;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $show_dues_only = $request->show_dues_only;
        $exclude_previous_dues = $request->exclude_previous_dues;
        $exclude_special_items = $request->exclude_special_items;
        $quantity_only = $request->quantity_only;
        $referral_summary = $request->referral_summary_1;
        $referral_performance = $request->referral_performance;
        $referral_summary_2 = $request->referral_summary_2;

        // Date range handling
        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Initialize SQL condition array
        $sql_cond = [];

        // Handle date range condition
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(invoice_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        // Handle additional conditions
        if ($mtg_area) {
            $sql_cond[] = "branch_id = '$mtg_area'";
        }

        if ($agent) {
            $sql_cond[] = "mkt_officer_id = '$agent'";
        }
        if ($referral_id) {
            $sql_cond[] = "referral_id = '$referral_id'";
        }

        // Handle boolean flag conditions
        if ($show_dues_only === 'on') {
            $sql_cond[] = "dues_only = 1";  // Assuming dues_only is a column in the DB
        }

        if ($exclude_previous_dues === 'on') {
            $sql_cond[] = "exclude_previous_dues = 1";  // Assuming exclude_previous_dues is a column
        }

        if ($exclude_special_items === 'on') {
            $sql_cond[] = "exclude_special_items = 1";  // Assuming exclude_special_items is a column
        }

        if ($quantity_only === 'on') {
            $sql_cond[] = "quantity_only = 1";  // Assuming quantity_only is a column
        }

        // Construct final SQL condition string
        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // Handle the referral summary condition and calculate totals

        if ($request->type == 'LR') {
            $query = " SELECT REFERRAL_NAME,
                BRANCH_NAME,
                REFERRAL_ID,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT
            FROM FINC_REFERRAL_SUMMARY_VW
                LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
                $sql_where
        GROUP BY REFERRAL_NAME,
                BRANCH_NAME,
                REFERRAL_ID
        ORDER BY TOTAL_SALES DESC";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_summary';
            return Template::loadview("admin.sales.referral_report_sale", [
                'data' => $report_data,
                'type' => $type,
                'date_from' => $date_from,
                'date_to' => $date_to,
            ]);
        } else {
            $query = "SELECT REFERRAL_NAME,
                    BRANCH_NAME,REFERRAL_ID,
                    SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                    SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                    SUM (TOTAL_SALES) AS TOTAL_SALES,
                    SUM (PAYEMNT) AS TOTAL_PAYMENT,
                    SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                    SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                    SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                    SUM (NET_SALES) AS TOTAL_NET_SALES,
                    SUM (DUE) AS TOTAL_DUE,
                    SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                    SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,referral_payable_ind
                FROM FINC_REFERRAL_SUMMARY_VW
                LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
            $sql_where
            GROUP BY REFERRAL_NAME, BRANCH_NAME,REFERRAL_ID,referral_payable_ind order by TOTAL_INVOICE_QTY desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_performance';
            return Template::loadview("admin.sales.referral_ledger_sales", [
                'data' => $report_data,
                'type' => $type,
                'date_from' => $date_from,
                'date_to' => $date_to,
            ]);
        }
    }

    public function marketingReportPdf(Request $request)
    {
        // Initialize default variables
        $ledgerPages = [];
        $sql_cond = [];

        $mtg_area = $request->mtg_area;
        $agent = $request->agent;
        $referral_id = $request->referral_id;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $show_dues_only = $request->show_dues_only;
        $exclude_previous_dues = $request->exclude_previous_dues;
        $exclude_special_items = $request->exclude_special_items;
        $quantity_only = $request->quantity_only;
        $referral_summary = $request->referral_summary_1;
        $referral_performance = $request->referral_performance;
        $referral_summary_2 = $request->referral_summary_2;

        // Date range handling
        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Build the SQL condition array
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(invoice_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        if ($mtg_area) {
            $sql_cond[] = "branch_id = '$mtg_area'";
        }

        if ($agent) {
            $sql_cond[] = "mkt_officer_id = '$agent'";
        }

        if ($referral_id) {
            $sql_cond[] = "referral_id = '$referral_id'";
        }

        if ($show_dues_only === 'on') {
            $sql_cond[] = "dues_only = 1";
        }

        if ($exclude_previous_dues === 'on') {
            $sql_cond[] = "exclude_previous_dues = 1";
        }

        if ($exclude_special_items === 'on') {
            $sql_cond[] = "exclude_special_items = 1";
        }

        if ($quantity_only === 'on') {
            $sql_cond[] = "quantity_only = 1";
        }

        // Combine the SQL conditions
        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // SQL query
        if ($request->type == 'LR') {
            $query = "SELECT REFERRAL_NAME,
                    BRANCH_NAME,
                    REFERRAL_ID,
                    MKT_OFFICER_ID,
                    SUM(INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                    SUM(TOTAL_SALES) AS TOTAL_SALES,
                    SUM(DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                    SUM(DISCOUNT) AS TOTAL_DISCOUNT,
                    SUM(DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                    SUM(PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT
                FROM FINC_REFERRAL_SUMMARY_VW
                LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
                $sql_where
                GROUP BY REFERRAL_NAME, BRANCH_NAME, REFERRAL_ID, MKT_OFFICER_ID
                ORDER BY TOTAL_SALES DESC";

            $refdata = DB::select($query);

            // Group by marketing officer
            $groupedByEmployee = collect($refdata)->groupBy('mkt_officer_id');

            // Retrieve employee information
            $employeeInfo = DB::table('employee_info_vw')
                ->whereIn('person_no_pk', $groupedByEmployee->keys())
                ->get()
                ->keyBy('person_no_pk');

            // Process each employee data
            foreach ($groupedByEmployee as $employeeId => $employeeData) {
                $employee = $employeeInfo->get($employeeId);
                $employeeName = $employee ? $employee->full_name : 'Unknown Employee';
                $employeeCode = $employee ? $employee->person_code : 'Unknown Code';
                $branch_name = $employee ? $employee->branch_name : 'Unknown Branch';
                $person_no_pk = $employee ? $employee->person_no_pk : 'Unknown Branch';

                $employeeLedger = [
                    'employee_name' => $employeeName,
                    'employee_code' => $employeeCode,
                    'person_no_pk' => $person_no_pk,
                    'branch_name' => $branch_name,
                    'items' => []
                ];

                // Add data to employee ledger
                foreach ($employeeData as $data) {
                    $employeeLedger['items'][] = [
                        'referral_name' => $data->referral_name,
                        'branch_name' => $data->branch_name,
                        'referral_id' => $data->referral_id,
                        'mkt_officer_id' => $data->mkt_officer_id,
                        'total_invoice_qty' => $data->total_invoice_qty,
                        'total_sales' => $data->total_sales,
                        'total_doctor_profit' => $data->total_doctor_profit,
                        'total_discount' => $data->total_discount,
                        'total_doctor_discount' => $data->total_doctor_discount,
                        'total_payable_profit' => $data->total_payable_profit,
                    ];
                }

                // Add the employee's data to the ledgerPages array
                $ledgerPages[] = $employeeLedger;
            }
            // dd($ledgerPages);
            // Return the view with the ledger pages
            return view('admin.sales.print_report_ledger', compact('ledgerPages', 'date_from', 'date_to'));
        } else {
            $agent_dt = '';
            $query = "SELECT REFERRAL_NAME,
                BRANCH_NAME,REFERRAL_ID,
                SUM (INVOICE_QTY) AS TOTAL_INVOICE_QTY,
                SUM (TEST_QTY) AS TOTAL_TEST_QTY,
                SUM (TOTAL_SALES) AS TOTAL_SALES,
                SUM (PAYEMNT) AS TOTAL_PAYMENT,
                SUM (DISCOUNT_BY_ORG) AS TOTAL_DISCOUNT_BY_ORG,
                SUM (DISCOUNT) AS TOTAL_DISCOUNT,
                SUM (DOCTOR_DISCOUNT) AS TOTAL_DOCTOR_DISCOUNT,
                SUM (NET_SALES) AS TOTAL_NET_SALES,
                SUM (DUE) AS TOTAL_DUE,
                SUM (DOCTOR_PROFIT) AS TOTAL_DOCTOR_PROFIT,
                SUM (PAYABLE_PROFIT) AS TOTAL_PAYABLE_PROFIT,referral_payable_ind
            FROM FINC_REFERRAL_SUMMARY_VW
            LEFT JOIN hrms_personnel ON REFERRAL_ID = person_no_pk
        $sql_where
        GROUP BY REFERRAL_NAME, BRANCH_NAME,REFERRAL_ID,referral_payable_ind order by TOTAL_INVOICE_QTY desc";
            // Execute the query
            $report_data = DB::select($query);
            $type = 'referral_performance';
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            if ($agent) {
                $sql_cond[] = "mkt_officer_id = '$agent'";
                $agent_dt = DB::table('hrms_personnel')->select('full_name', 'person_code')->where('person_no_pk', $agent)->first();
            }
            return view("admin.sales.referral_ledger_sales_pdf", [
                'data' => $report_data,
                'type' => $type,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'agent_dt' => $agent_dt,
                'agent' => $agent,
                'po_hospital_details' => $po_hospital_details
            ]);
        }
    }

    public function topSalesReport()
    {
        $reptype = '';
        return Template::loadview("admin.sales.top_sales_report", compact('reptype'));
    }

    public function marketingTopSalesReportSearch(Request $request)
    {
        $reptype = $request->type;
        $top_sl = $request->top_sl;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;

        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Initialize SQL condition array
        $sql_cond = [];

        // Handle date range condition
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(invoice_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        // Handle additional conditions
        // if ($reptype) {
        //     $sql_cond[] = "branch_id = '$reptype'";
        // }

        // if ($top_sl) {
        //     $sql_cond[] = "mkt_officer_id = '$top_sl'";
        // }

        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // Handle the referral summary condition and calculate totals

        if ($reptype == 'MO') {
            $query = "SELECT MKT_OFFICER_ID,
                MKT_OFFICER_NAME_DESIG,
                MKT_OFFICER_DESIG,
                INVOICE_QTY,
                TEST_QTY,
                TOTAL_SALES,
                PAYEMNT,
                DISCOUNT,
                NET_SALES,
                DUE
            FROM (  SELECT MKT_OFFICER_ID,
                            MKT_OFFICER_NAME AS MKT_OFFICER_NAME_DESIG,
                            MKT_OFFICER_DESIG,
                            SUM (INVOICE_QTY) AS INVOICE_QTY,
                            SUM (TEST_QTY) AS TEST_QTY,
                            SUM (TOTAL_SALES) AS TOTAL_SALES,
                            SUM (PAYEMNT) AS PAYEMNT,
                            SUM (DISCOUNT) AS DISCOUNT,
                            SUM (NET_SALES) AS NET_SALES,
                            SUM (DUE) AS DUE
                        FROM FINC_REFERRAL_SUMMARY_VW
                     $sql_where
                    GROUP BY MKT_OFFICER_ID, MKT_OFFICER_NAME, MKT_OFFICER_DESIG
                    ORDER BY TOTAL_SALES DESC)
            WHERE ROWNUM <= $top_sl";

            // Execute the query
        } else {
            $query = "SELECT
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME_DESIG,
                    MKT_OFFICER_DESIG,
                    INVOICE_QTY,
                    TEST_QTY,
                    TOTAL_SALES,
                    PAYEMNT,
                    DISCOUNT,
                    DOCTOR_DISCOUNT,
                    DOCTOR_PROFIT,
                    PAYABLE_PROFIT,
                    NET_SALES,
                    DUE
                FROM (
                SELECT
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME AS MKT_OFFICER_NAME_DESIG ,
                    MKT_OFFICER_DESIG,
                    SUM(INVOICE_QTY) AS INVOICE_QTY,
                    SUM(TEST_QTY) AS TEST_QTY,
                    SUM(TOTAL_SALES) AS TOTAL_SALES,
                    SUM(PAYEMNT) AS PAYEMNT,
                    SUM(DISCOUNT) AS DISCOUNT,
                    SUM(DOCTOR_DISCOUNT) AS DOCTOR_DISCOUNT,
                    SUM(DOCTOR_PROFIT) AS DOCTOR_PROFIT,
                    SUM(PAYABLE_PROFIT) AS PAYABLE_PROFIT,
                    SUM(NET_SALES) AS NET_SALES,
                    SUM(DUE) AS DUE
                FROM FINC_REFERRAL_SUMMARY_VW
                $sql_where
                GROUP BY
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME,
                    MKT_OFFICER_DESIG
                ORDER BY TOTAL_SALES DESC
                )
                WHERE ROWNUM <= $top_sl";
        }
        $report_data = DB::select($query);
        return Template::loadview("admin.sales.top_sales_report_data", [
            'reportData' => $report_data,
            'reptype' => $reptype,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ]);
    }

    public function marketingTopSalesReportPdf(Request $request)
    {
        $reptype = $request->type;
        $top_sl = $request->top_sl;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;

        if (!empty($allowed_dates) && !empty($allowed_dates_to)) {
            $date_from = $allowed_dates;
            $date_to = $allowed_dates_to;
        } else {
            $date_from = null;
            $date_to = null;
        }

        // Initialize SQL condition array
        $sql_cond = [];

        // Handle date range condition
        if ($date_from && $date_to) {
            $sql_cond[] = "trunc(invoice_date) between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')";
        }

        // Handle additional conditions
        // if ($reptype) {
        //     $sql_cond[] = "branch_id = '$reptype'";
        // }

        // if ($top_sl) {
        //     $sql_cond[] = "mkt_officer_id = '$top_sl'";
        // }

        $sql_where = !empty($sql_cond) ? " WHERE " . implode(" AND ", $sql_cond) : "";

        // Handle the referral summary condition and calculate totals

        if ($reptype == 'MO') {
            $query = "SELECT MKT_OFFICER_ID,
                MKT_OFFICER_NAME_DESIG,
                MKT_OFFICER_DESIG,
                INVOICE_QTY,
                TEST_QTY,
                TOTAL_SALES,
                PAYEMNT,
                DISCOUNT,
                NET_SALES,
                DUE
            FROM (  SELECT MKT_OFFICER_ID,
                            MKT_OFFICER_NAME AS MKT_OFFICER_NAME_DESIG,
                            MKT_OFFICER_DESIG,
                            SUM (INVOICE_QTY) AS INVOICE_QTY,
                            SUM (TEST_QTY) AS TEST_QTY,
                            SUM (TOTAL_SALES) AS TOTAL_SALES,
                            SUM (PAYEMNT) AS PAYEMNT,
                            SUM (DISCOUNT) AS DISCOUNT,
                            SUM (NET_SALES) AS NET_SALES,
                            SUM (DUE) AS DUE
                        FROM FINC_REFERRAL_SUMMARY_VW
                     $sql_where
                    GROUP BY MKT_OFFICER_ID, MKT_OFFICER_NAME, MKT_OFFICER_DESIG
                    ORDER BY TOTAL_SALES DESC)
            WHERE ROWNUM <= $top_sl";

            // Execute the query
        } else {
            $query = "SELECT
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME_DESIG,
                    MKT_OFFICER_DESIG,
                    INVOICE_QTY,
                    TEST_QTY,
                    TOTAL_SALES,
                    PAYEMNT,
                    DISCOUNT,
                    DOCTOR_DISCOUNT,
                    DOCTOR_PROFIT,
                    PAYABLE_PROFIT,
                    NET_SALES,
                    DUE
                FROM (
                SELECT
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME AS MKT_OFFICER_NAME_DESIG ,
                    MKT_OFFICER_DESIG,
                    SUM(INVOICE_QTY) AS INVOICE_QTY,
                    SUM(TEST_QTY) AS TEST_QTY,
                    SUM(TOTAL_SALES) AS TOTAL_SALES,
                    SUM(PAYEMNT) AS PAYEMNT,
                    SUM(DISCOUNT) AS DISCOUNT,
                    SUM(DOCTOR_DISCOUNT) AS DOCTOR_DISCOUNT,
                    SUM(DOCTOR_PROFIT) AS DOCTOR_PROFIT,
                    SUM(PAYABLE_PROFIT) AS PAYABLE_PROFIT,
                    SUM(NET_SALES) AS NET_SALES,
                    SUM(DUE) AS DUE
                FROM FINC_REFERRAL_SUMMARY_VW
                $sql_where
                GROUP BY
                    REFERRAL_ID,referral_addr,
                    REFERRAL_NAME,
                    MKT_OFFICER_ID,
                    MKT_OFFICER_NAME,
                    MKT_OFFICER_DESIG
                ORDER BY TOTAL_SALES DESC
                )
                WHERE ROWNUM <= $top_sl";
        }
        $report_data = DB::select($query);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.sales.top_sales_pdf", [
                'reportData' => $report_data,
                'reptype' => $reptype,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'po_hospital_details' => $po_hospital_details
            ]);
        } else {

            $pdf = [
                'reportData' => $report_data,
                'reptype' => $reptype,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'po_hospital_details' => $po_hospital_details
            ];
            $fileToExport = "marketing_report";
            $html = View("admin.sales.top_sales_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
}
