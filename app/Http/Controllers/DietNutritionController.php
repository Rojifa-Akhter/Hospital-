<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Traits\LookupData;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class DietNutritionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use LookupData;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listing
     */
    public function index()
    {
        $nurseStations = DB::table('sysc_serviceunit_vw')
            ->where('ipd_ind', 1)
            ->orderBy("serviceunit_name")
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->get();

        $wards = db::table('ipds_ward')
            ->select('ward_no_pk', 'ward_name')
            // ->where('au_entry_hospital_no_fk', session()->get('user.ses_hospital_no_pk'))
            ->orderBy("ward_name")
            ->get();

        $beds = db::table('ipds_bed')
            ->select('bed_no_pk', 'bed_name')
            ->orderBy("bed_name")
            ->get();

        $dietCharts = DB::table("SYSC_DIET_CHARTMST")
            ->where("AU_ENTRY_HOSPITAL_NO_FK", session()->get('user.ses_hospital_no_pk'))
            ->get();

        // $items = DB::table("IPD_V1_ADMITTED_PAT_NSREQ_WL_VW a")
        //             ->join("PATIENT_INFO_VW b", "a.PATIENT_NO_FK", "b.PATIENT_NO_PK")
        //             ->leftJoin("IPD_DIET_CHART c", function($join) {
        //                 $join->on("a.ADMISSION_NO_PK", "c.ADMISSION_NO_FK")->where('c.DIET_DATE', Carbon::today());
        //             })
        //             ->select("a.ADMISSION_NO_PK", "a.ADMISSION_DATE", "a.PATIENT_NO_FK", "a.PATIENT_NAME", "a.BED_UID", "a.DIS_ADVICE", "b.DOB", "b.GENDER_TXT", "a.primary_doctor_name", "b.MOBILE1", "a.ward_name", "a.bed_name", "a.nurse_station", "c.DIET_DATE", "c.DIET_TYPE", "c.DIET_CHART_NO_FK")
        //             ->orderByDesc("a.ADMISSION_NO_PK")
        //             ->get();

        $items = DB::select("SELECT A.ADMISSION_NO_PK,
       A.ADMISSION_DATE,
       A.PATIENT_NO_FK,
       A.PATIENT_NAME,
       A.BED_UID,
       A.DIS_ADVICE,
       B.DOB,
       B.GENDER_TXT,
       A.PRIMARY_DOCTOR_NAME,
       B.MOBILE1,
       A.WARD_NAME,
       A.BED_NAME,
       A.NURSE_STATION,
       C.DIET_DATE,
       C.DIET_TYPE,
       C.DIET_CHART_NO_FK
  FROM IPD_V1_ADMITTED_PAT_NSREQ_WL_VW A
       INNER JOIN PATIENT_INFO_VW B ON A.PATIENT_NO_FK = B.PATIENT_NO_PK
       LEFT JOIN
       (  SELECT DIET_DATE,
                 DIET_TYPE,
                 ADMISSION_NO_FK,
                 DIET_CHART_NO_FK
            FROM IPD_DIET_CHART C
           WHERE ADMISSION_NO_FK = C.ADMISSION_NO_FK
           AND C.DIET_CHART_NO_FK =
               (SELECT MAX(DIET_CHART_NO_FK)
                  FROM IPD_DIET_CHART
                 WHERE ADMISSION_NO_FK = C.ADMISSION_NO_FK)
          ) C
            ON A.ADMISSION_NO_PK = C.ADMISSION_NO_FK
--WHERE A.ADMISSION_NO_PK = 1468
ORDER BY A.ADMISSION_NO_PK DESC
");

        return Template::loadview("admin.diet-nutrition.index", compact('items', 'nurseStations', 'wards', 'beds', 'dietCharts'));
    }

    public function filter(Request $request)
    {
        $items = DB::table("IPD_V1_ADMITTED_PAT_NSREQ_WL_VW a")
            ->join("PATIENT_INFO_VW b", "a.PATIENT_NO_FK", "b.PATIENT_NO_PK")
            ->leftJoin("IPD_DIET_CHART c", function ($join) {
                $join->on("a.ADMISSION_NO_PK", "c.ADMISSION_NO_FK")->where('c.DIET_DATE', Carbon::today());
            })
            ->select("a.ADMISSION_NO_PK", "a.ADMISSION_DATE", "a.PATIENT_NO_FK", "a.PATIENT_NAME", "a.BED_UID", "a.DIS_ADVICE", "b.DOB", "b.GENDER_TXT", "a.primary_doctor_name", "b.MOBILE1", "a.ward_name", "a.bed_name", "a.nurse_station", "c.DIET_DATE", "c.DIET_TYPE", "c.DIET_CHART_NO_FK");

        if ($request->input('admission_no') != "") {
            $items = $items->where('a.ADMISSION_NO_PK', $request->input('admission_no'));
        }

        if ($request->input('mobile') != "") {
            $items = $items->where('b.MOBILE1', $request->input('mobile'));
        }

        if ($request->input('ward_id') != "") {
            $items = $items->where('a.WARD_NO_FK', $request->input('ward_id'));
        }

        if ($request->input('bed_id') != "") {
            $items = $items->where('a.bed_name', $request->input('bed_id'));
        }

        if ($request->input('department_id') != "") {
            $items = $items->where('a.nurse_station', $request->input('department_id'));
        }

        $items = $items->orderByDesc('a.ADMISSION_NO_PK')->get();

        $dietCharts = DB::table("SYSC_DIET_CHARTMST")
            ->where("AU_ENTRY_HOSPITAL_NO_FK", session()->get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadview("admin.diet-nutrition.table", compact('items', 'dietCharts'));
    }

    public function dietAllocate(Request $request)
    {
        DB::beginTransaction();

        try {
            $diets = json_decode($request->input('dietChart'))->payload;

            foreach ($diets as $key => $diet) {
                DB::table('IPD_DIET_CHART')->insert([
                    "DIET_CHART_NO_PK"          => $this->getSequence('DIET_CHART_NO_PK_SEQ'),
                    "PATIENT_NO_FK"             => $diet->patient_no_fk,
                    "ADMISSION_NO_FK"           => $diet->admission_no_pk,
                    "STATUS"                    => 1,
                    "AU_ENTRY_AT"               => Carbon::now()->toDateString(),
                    "AU_ENTRY_BY"               => Auth::id(),
                    "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                    "AU_ENTRY_HOSPITAL_PK_NO"   => session()->get('user.ses_hospital_no_pk'),
                    "DIET_DATE"                 => Carbon::now()->toDateString(),
                    "DIET_TYPE"                 => $diet->diet_nature,
                    "DIET_CHART_NO_FK"          => $diet->diet_chart_no_pk,
                ]);
            }

            DB::commit();

            $message = ['msg' => 'Diet Allocated Successfully', 'title' => 'Success',];
        } catch (Exception $exception) {
            $message = ['msg' => $exception->getMessage(), 'title' => 'error',];
        }

        return response()->json($message);
    }

    public function report(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $items = DB::table("IPD_V1_ADMITTED_PAT_NSREQ_WL_VW a")
            ->join("PATIENT_INFO_VW b", "a.PATIENT_NO_FK", "b.PATIENT_NO_PK")
            ->leftJoin("IPD_DIET_CHART c", "a.ADMISSION_NO_PK", "c.ADMISSION_NO_FK")
            ->where('c.DIET_DATE', Carbon::today())
            ->leftJoin("IPD_DIETCHART_VW d", "c.DIET_CHART_NO_FK", "d.DIET_CHART_NO_PK")
            ->select("a.ADMISSION_NO_PK", "a.ADMISSION_DATE", "a.PATIENT_NO_FK", "a.PATIENT_NAME", "a.BED_UID", "a.DIS_ADVICE", "b.DOB", "b.GENDER_TXT", "a.primary_doctor_name", "b.MOBILE1", "a.ward_name", "a.bed_name", "a.nurse_station", "c.DIET_DATE", "c.DIET_TYPE", "c.DIET_CHART_NO_FK", "d.*");

        if ($request->input('admission_no') != "") {
            $items = $items->where('a.ADMISSION_NO_PK', $request->input('admission_no'));
        }

        if ($request->input('mobile') != "") {
            $items = $items->where('b.MOBILE1', $request->input('mobile'));
        }

        if ($request->input('ward_id') != "") {
            $items = $items->where('a.WARD_NO_FK', $request->input('ward_id'));
        }

        if ($request->input('bed_id') != "") {
            $items = $items->where('a.bed_name', $request->input('bed_id'));
        }

        if ($request->input('department_id') != "") {
            $items = $items->where('a.nurse_station', $request->input('department_id'));
        }

        $items = $items->orderByDesc('a.ADMISSION_NO_PK')->get();

        $pdf = PDF::loadView("admin.diet-nutrition.report", ["items" => $items, "po_hospital_details" => $po_hospital_details,])->setPaper('a4', 'landscape');
        return $pdf->stream("Diet Chart Report.pdf", array("Attachment" => false));
    }

    public function dietEntry($patient_no_fk, $admission_id)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->first();

        return Template::loadView("admin.diet-nutrition.diet-entry", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }

    public function history(int $id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $ipd_admission = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $id)->first();

        $userInfo = Auth::user();

        $dietCharts = DB::table("IPD_DIET_CHART a")
            ->join("IPD_DIETCHART_VW b", "a.DIET_CHART_NO_FK", "b.DIET_CHART_NO_PK")
            ->where("ADMISSION_NO_FK", $id)
            ->select("a.diet_date", "a.DIET_TYPE", "b.*")
            ->orderByDesc('a.diet_date')
            ->get();

        $pdf = PDF::loadView("admin.diet-nutrition.history", ["dietCharts" => $dietCharts, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission,])->setPaper('a4', 'landscape');
        return $pdf->stream("Daily Diet Chart Report.pdf", array("Attachment" => false));
    }

    public function dietCard(int $id)
    {
        $patientInfo = DB::table("IPD_ADMITTED_PATLIST_VW")
            ->where("ADMISSION_NO_PK", $id)
            ->select("patient_name", "bed_name", "ward_name")
            ->first();

        $dietChart = DB::table('IPD_DIET_CHART')
            ->where('ADMISSION_NO_FK', $id)
            ->whereDate('DIET_DATE', today())
            ->first();

        $result = [];

        if (isset($dietChart)) {
            $dietChartNoFk = $dietChart->diet_chart_no_fk;

            $item = DB::table("SYSC_DIET_CHART_DTL dtl")
                ->join("SYSC_DIETSLOT diet", 'dtl.diet_no_fk', 'diet.DIET_NO_PK')
                ->join("SYSC_FOOD food", 'dtl.food_no_fk', 'food.FOOD_NO_PK')
                ->select('diet.DIET_NAME', 'diet.DIET_TIME', 'food.FOOD_NAME', 'dtl.*')
                ->where("DIET_CHART_NO_FK", $dietChartNoFk)
                ->get();

            foreach ($item as $key => $value) {
                $time = $value->diet_name . ' (' . date('h:ia', strtotime($value->diet_time)) . ') ';
                if (!isset($result[$time])) {
                    $result[$time] = [$value->food_name];
                } else {
                    array_push($result[$time], $value->food_name);
                }
            }
        }

        $pdf = PDF::loadView("admin.diet-nutrition.diet-card", ['dietChart' => $dietChart, 'patientInfo' => $patientInfo, 'result' => $result]);
        return $pdf->stream('Diet Card.pdf');
    }

    public function dailyNatureWiseDietReport()
    {
        $from_date = date('d/m/Y');
        $to_date = date('d/m/Y');

        $dietCharts = DB::table('SYSC_DIET_CHARTMST mst')
            ->where('status', true)
            ->select('diet_chart_no_pk', 'diet_chart_name')
            ->orderByDesc('diet_chart_no_pk')
            ->get();

        $items = DB::select("select count(*) total_patient, diet_chart_no_fk, diet_chart_name
                    from ipd_dietchart_vw vw, ipd_diet_chart ip
                    where ip.diet_chart_no_fk = vw.diet_chart_no_pk
                    and diet_date between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                    group by diet_chart_no_fk,diet_chart_name");

        return Template::loadview("admin.diet-nutrition.daily-nature-wise-diet-report", compact('dietCharts', 'items'));
    }

    public function dailyDietNutritionSummaryReport()
    {

        return Template::loadview("admin.diet-nutrition.daily_diet_nutrition_cunsumption_summary");
    }

    public function dailyNatureWiseDietReportFilter(Request $request)
    {
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');

        $whereClause = '';

        if ($request->diet_chart_no_pk != null) {
            $whereClause .= " AND diet_chart_no_fk = " . $request->diet_chart_no_pk;
        }

        $items = DB::select("select count(*) total_patient, diet_chart_no_fk, diet_chart_name
                    from ipd_dietchart_vw vw, ipd_diet_chart ip
                    where ip.diet_chart_no_fk = vw.diet_chart_no_pk
                    $whereClause
                    group by diet_chart_no_fk,diet_chart_name");

        return Template::loadview("admin.diet-nutrition.daily-nature-wise-diet-table", compact('items'));
    }

    public function dailyNatureWiseDietReportPdf(Request $request)
    {
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');

        $whereClause = '';

        if ($request->diet_chart_no_pk != null) {
            $whereClause .= " AND diet_chart_no_fk = " . $request->diet_chart_no_pk;
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $items = DB::select("select count(*) total_patient, diet_chart_no_fk, diet_chart_name
                    from ipd_dietchart_vw vw, ipd_diet_chart ip
                    where ip.diet_chart_no_fk = vw.diet_chart_no_pk
                    and diet_date between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy') $whereClause
                    group by diet_chart_no_fk,diet_chart_name");

        $pdf = PDF::loadView("admin.diet-nutrition.daily-nature-wise-diet-report-pdf", ["items" => $items, "po_hospital_details" => $po_hospital_details, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
        return $pdf->stream("Diet Chart Report.pdf", array("Attachment" => false));
    }

    public function dietNutrotionEntry($patient_id, $admission_id)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_id)
            ->first();
        $chartData = DB::table('ipd_dietchart_vw')->whereNotNull('diet_chart_name')->get();
        $dietType = DB::table('sysc_dietslot')->whereNotNull('diet_no_pk')->get();
        $dietType1 = DB::table('sysc_dietslot')->whereNotNull('diet_no_pk')->get();
        $diet_type = $this->getLookupListByCode("DIETTYPE");


        $formatted_meal_type = $dietType->map(function ($meal) {
            $meal->diet_name = strtolower(str_replace(' ', '_', $meal->diet_name)); // Ensure lowercase keys
            return $meal;
        });
        $diet_check = '';  // Default value

        // Try to fetch the diet_chart_no_fk for the given admission and patient IDs
        $diet_record = DB::table('IPD_DIET_CHART')
                        ->select('diet_chart_no_fk')
                        ->where('admission_no_fk', $admission_id)
                        ->where('patient_no_fk', $patient_id)
                        ->orderByDesc('diet_chart_no_pk')
                        ->first();

        // Check if a record is found, and if so, assign the diet_chart_no_fk to $diet_check
        if ($diet_record) {
            $diet_check = $diet_record->diet_chart_no_fk;
        }
        return Template::loadview("admin.diet-nutrition.diet_nutrition_entry", [
            'patient_info' => $patient_info,
            'chartData' => $chartData,
            'dietType' => $dietType,
            'dietType1' => $dietType1,
            'patient_id' => $patient_id,
            'diet_type' => $diet_type,
            'formatted_meal_type' => $formatted_meal_type,
            'admission_id' => $admission_id,
            'diet_check' => intval($diet_check)
        ]);
    }
    public function itemData(Request $request)
    {
        $itemData = DB::table('sysc_food')->where('status', 1)->get();
        return response()->json($itemData);
    }
    public function itemFoodData(Request $request)
    {
        // Get diet chart data
        $itemData = DB::table('ipd_dietchart_vw')
            ->where('diet_chart_no_pk', $request->diet_chart_id)
            ->first();

        // Get the available meal types (e.g., breakfast, lunch)
        $meal_type = DB::table('sysc_dietslot')
            ->select('diet_no_pk', 'diet_name')
            ->where('status', 1)
            ->get();

        // Format meal types by replacing spaces with underscores (e.g., 'Breakfast' -> 'breakfast')
        $formatted_meal_type = $meal_type->map(function ($meal) {
            $meal->diet_name = strtolower(str_replace(' ', '_', $meal->diet_name)); // Ensure lowercase keys
            return $meal;
        });

        // Check if diet chart data was found
        if ($itemData) {
            // Prepare response data array
            $responseData = [];

            // Loop through each formatted meal type and add data to response
            foreach ($formatted_meal_type as $meal) {
                $mealKey = $meal->diet_name; // e.g., 'breakfast', 'lunch'

                // Check if this meal exists in the diet chart data
                if (isset($itemData->$mealKey)) {
                    // Add the meal data (could be null or some other value)
                    $responseData[$mealKey] = $itemData->$mealKey ?? null;
                } else {
                    // If the meal data is not set in the diet chart, add null (or handle differently if needed)
                    $responseData[$mealKey] = null;
                }
            }
            $responseData['price'] = $itemData->price ?? 0;
            // dd($responseData);
            return response()->json($responseData, 200);
        } else {
            return response()->json(['message' => 'No diet data found for the provided diet ID.'], 404);
        }
    }


    public function dietPlanSave(Request $request)
    {

        // Start transaction
        DB::beginTransaction();

        try {
            $diet_chart_no_pk = null;

            if (!empty($request->chart_name)) {
                $diet_chart_no_pk = $this->getSequence('DIET_CHART_mst_PK_seq');

                DB::table('SYSC_DIET_CHARTMST')->insert([
                    "DIET_CHART_NO_PK" => $diet_chart_no_pk,
                    "DIET_CHART_NAME" => $request->input("chart_name"),
                    "PRICE" => $request->input("price"),
                    "STATUS" => 1,
                    "AU_ENTRY_AT" => Carbon::now()->toDateString(),
                    "AU_ENTRY_BY" => Auth::id(),
                    "AU_ENTRY_SESSION" => auth()->user()->user_name,
                    "AU_ENTRY_HOSPITAL_NO_FK" => session()->get('user.ses_hospital_no_pk'),
                ]);
                DB::commit();

                if (!empty($request->meal_data) && is_array($request->meal_data)) {
                    foreach ($request->meal_data as $meal) {
                        if (!empty($meal['meal_type']) && !empty($meal['food_items']) && is_array($meal['food_items'])) {
                            $meal_type = $meal['meal_type'];
                            $food_items = $meal['food_items'];

                            $diet_id = DB::table('sysc_dietslot')
                                ->select('diet_no_pk')
                                ->where('DIET_NAME', $meal_type)
                                ->first();

                            if ($diet_id) {
                                foreach ($food_items as $food_name) {
                                    $food_id = DB::table('sysc_food')
                                        ->select('FOOD_NO_PK')
                                        ->where('food_name', $food_name)
                                        ->first();

                                    if ($food_id) {
                                        DB::table('SYSC_DIET_CHART_DTL')->insert([
                                            "DIET_CHART_DTL_NO_PK" => $this->getSequence('DIET_CHART_Dtl_NO_PK'),
                                            "DIET_CHART_NO_FK" => $diet_chart_no_pk,
                                            "DIET_NO_FK" => $diet_id->diet_no_pk,
                                            "FOOD_NO_FK" => $food_id->food_no_pk,
                                            "STATUS" => 1,
                                            "AU_ENTRY_AT" => Carbon::now()->toDateString(),
                                            "AU_ENTRY_BY" => Auth::id(),
                                            "AU_ENTRY_SESSION" => auth()->user()->user_name,
                                            "AU_ENTRY_HOSPITAL_NO_FK" => session()->get('user.ses_hospital_no_pk'),
                                        ]);
                                        DB::commit();
                                    } else {
                                        Log::error("Food not found: " . $food_name);
                                    }
                                }
                            } else {
                                Log::error("Diet slot not found for meal type: " . $meal_type);
                            }
                        } else {
                            Log::error("Invalid meal data structure or missing 'meal_type' or 'food_items'.");
                        }
                    }
                } else {
                    Log::error("'meal_data' is missing or not an array.");
                }
            } else {
                $diet = DB::table('ipd_dietchart_vw')
                    ->where('diet_chart_no_pk', $request->diet_plan_id)
                    ->first();
                $diet_chart_no_pk = $diet->diet_chart_no_pk;
                $foodlist = $diet->
                dd($diet);

                // $food_id = DB::table('sysc_food')
                //                         ->select('FOOD_NO_PK')
                //                         ->where('food_name', $food_name)
                //                         ->first();

                //                     if ($food_id) {
                //                         DB::table('SYSC_DIET_CHART_DTL')->insert([
                //                             "DIET_CHART_DTL_NO_PK" => $this->getSequence('DIET_CHART_Dtl_NO_PK'),
                //                             "DIET_CHART_NO_FK" => $diet_chart_no_pk,
                //                             "DIET_NO_FK" => $diet_id->diet_no_pk,
                //                             "FOOD_NO_FK" => $food_id->food_no_pk,
                //                             "STATUS" => 1,
                //                             "AU_ENTRY_AT" => Carbon::now()->toDateString(),
                //                             "AU_ENTRY_BY" => Auth::id(),
                //                             "AU_ENTRY_SESSION" => auth()->user()->user_name,
                //                             "AU_ENTRY_HOSPITAL_NO_FK" => session()->get('user.ses_hospital_no_pk'),
                //                         ]);
                //                         DB::commit();


            }

            DB::table('IPD_DIET_CHART')->insert([
                "DIET_CHART_NO_PK" => $this->getSequence('DIET_CHART_NO_PK_SEQ'),
                "PATIENT_NO_FK" => $request->patient_no,
                "ADMISSION_NO_FK" => $request->admission_no,
                "REMARKS" => $request->remarks,
                "STATUS" => 1,
                "AU_ENTRY_AT" => Carbon::now()->toDateTimeString(),
                "AU_ENTRY_BY" => Auth::id(),
                "AU_ENTRY_SESSION" => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_PK_NO" => session()->get('user.ses_hospital_no_pk'),
                "DIET_DATE" => Carbon::now()->toDateTimeString(),
                "DIET_TYPE" => $request->type,
                "DIET_CHART_NO_FK" => $diet_chart_no_pk,
            ]);

            DB::commit();



            return response()->json(['msg' => 'Diet Allocated Successfully', 'title' => 'Success']);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['msg' => $exception->getMessage(), 'title' => 'Error']);
        }
    }



    public function dailyDietConsumptionSummarySearch(Request $request)
    {
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');

        $whereClause = '';

        if ($request->search_date_from != null) {
            $whereClause .= " where trunc(dtl.au_entry_at) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')";
        }

        $items = DB::select("SELECT
                        food.FOOD_NAME,
                        COUNT(dtl.food_no_fk) AS total_quantity
                    FROM
                        SYSC_DIET_CHART_DTL dtl
                    JOIN
                        sysc_food food
                        ON dtl.food_no_fk = food.food_no_pk $whereClause
                    GROUP BY
                        food.FOOD_NAME
                    ORDER BY
                        total_quantity DESC  -- Ordering by the total quantity, not au_entry_at
                    ");
                    

        return Template::loadview("admin.diet-nutrition.daily_diet_nutrition_consumption_list", compact('items'));
    }

    public function dailyDietNutritionConsumptionSummary(Request $request)
    {

        $date_from = $request->search_date_from != "" ? date("d/m/Y", strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date("d/m/Y", strtotime($request->search_date_to)) : "";
    // dd($from_date,$to_date);
        // Initialize the where clause
        $whereClause = '';

        // Build the WHERE clause if the dates are provided
        if ($date_from && $date_to) {
            $whereClause = " WHERE trunc(dtl.au_entry_at) BETWEEN TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        // Use parameterized queries to prevent SQL injection
        $items = DB::select("
            SELECT
                food.FOOD_NAME,
                COUNT(dtl.food_no_fk) AS total_quantity
            FROM
                SYSC_DIET_CHART_DTL dtl
            JOIN
                sysc_food food ON dtl.food_no_fk = food.food_no_pk
            $whereClause
            GROUP BY
                food.FOOD_NAME
            ORDER BY
                total_quantity DESC
        "); // Pass the sanitized dates as parameters to the query
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();


        return view("admin.diet-nutrition.daily_diet_consumption_summary_pdf", compact(['items','date_from','date_to','barcode_no','po_hospital_details']));
    }

}
