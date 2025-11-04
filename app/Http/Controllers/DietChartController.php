<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Library\Template;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class DietChartController extends Controller
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
     * Diet Chart Listing
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        $items = DB::table('SYSC_DIET_CHARTMST mst')
                    // ->join('SYSC_DIET_CHART_DTL dtl', 'mst.DIET_CHART_NO_PK', 'dtl.DIET_CHART_NO_FK')
                    // ->join('SYSC_FOOD food', 'food.FOOD_NO_PK', 'dtl.FOOD_NO_FK')
                    // ->select('mst.diet_chart_no_pk', 'mst.DIET_CHART_NAME', 'mst.NOTE', 'mst.PRICE', 'mst.STATUS', 'food.FOOD_NAME')
                    ->select('diet_chart_no_pk', 'diet_chart_name', 'note', 'price', 'status')
                    ->orderByDesc('diet_chart_no_pk')
                    ->get();

        // return $result;

        // $items = [];
        // foreach ($result as $item) {
        //     $items[$item->diet_chart_no_pk][] = $item;
        // }

        return Template::loadview("admin.diet-chart.index", compact('items'));
    }

    public function getFoodsByMealType(int $id)
    {
        $foods = DB::table("SYSC_DIETFOOD df")
                    ->join('SYSC_FOOD f', 'df.FOOD_NO_FK', 'f.FOOD_NO_PK')
                    ->where("df.DIET_NO_FK", $id)
                    ->select("df.FOOD_NO_FK", "f.FOOD_NAME")
                    ->orderBy("f.FOOD_NAME")
                    ->get();
        
        return response()->json(['foods' => $foods]);
    }

    public function create()
    {
        $diets = DB::table("SYSC_DIETSLOT")->get();

        return Template::loadview("admin.diet-chart.create", compact("diets"));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $diet_chart_no_pk = $this->getSequence('DIET_CHART_mst_PK_seq');

            DB::table('SYSC_DIET_CHARTMST')->insert([
                "DIET_CHART_NO_PK"          => $diet_chart_no_pk,
                "DIET_CHART_NAME"           => $request->input("name"),
                "NOTE"                      => $request->input("note"),
                "PRICE"                     => $request->input("price"),
                "STATUS"                    => 1,
                "AU_ENTRY_AT"               => Carbon::now()->toDateString(),
                "AU_ENTRY_BY"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
            ]);

            foreach($request->input("foods") as $key => $food) {
                foreach ($food as $idx => $value) {
                    DB::table('SYSC_DIET_CHART_DTL')->insert([
                        "DIET_CHART_DTL_NO_PK"      => $this->getSequence('DIET_CHART_Dtl_NO_PK'),
                        "DIET_CHART_NO_FK"          => $diet_chart_no_pk,
                        "DIET_NO_FK"                => $request->input("diets")[$key],
                        "FOOD_NO_FK"                => $value,
                        "STATUS"                    => 1,
                        "AU_ENTRY_AT"               => Carbon::now()->toDateString(),
                        "AU_ENTRY_BY"               => Auth::id(),
                        "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                        "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
                    ]);
                }
            }

            $message = ['msg' => 'Diet Chart Saved Successfully', 'title' => 'Success',];

            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();

            $message = ['msg' => $exception->getMessage(), 'title' => 'Error',];
        }

        return response()->json($message);
    }

    public function edit(int $id)
    {
        $diets = DB::table("SYSC_DIETSLOT")->get();
        $foods = DB::table("SYSC_FOOD")->get();

        $item = DB::table('SYSC_DIETFOOD a')
            ->where('a.DIETFOOD_NO_PK', $id)
            ->join('SYSC_DIET b', 'a.DIET_NO_FK', 'b.DIET_NO_PK')
            ->join('SYSC_FOOD c', 'a.FOOD_NO_FK', 'c.FOOD_NO_PK')
            ->select('a.DIETFOOD_NO_PK', 'a.DIET_NO_FK', 'a.FOOD_NO_FK', 'a.STATUS', 'b.DIET_NAME', 'b.DIET_TIME', 'c.FOOD_NAME')
            ->orderByDesc('a.DIETFOOD_NO_PK')
            ->first();

        return Template::loadview("admin.diet-foods.createEdit", compact("item", "diets", "foods"));
    }

    public function update(Request $request, int $id)
    {
        DB::table('SYSC_DIETFOOD')
            ->where('DIETFOOD_NO_PK', $id)
            ->update([
                "diet_no_fk"                => $request->input("diet_no_fk"),
                "food_no_fk"                => $request->input("food_no_fk")[0],
                "status"                    => 1,
                'AU_UPDATE_AT'              => Carbon::now()->toDateString(),
                'AU_UPDATE_BY'              => Auth::id(),
                'AU_UPDATE_SESSION'         => auth()->user()->user_name,
                'AU_UPDATE_HOSPITAL_NO_FK'  => session()->get('user.ses_hospital_no_pk'),
            ]);

        $message = ['msg' => 'Diet Food Updated Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function details(int $id)
    {
        $item = DB::table("SYSC_DIET_CHART_DTL dtl")
                    ->join("SYSC_DIETSLOT diet", 'dtl.diet_no_fk', 'diet.DIET_NO_PK')
                    ->join("SYSC_FOOD food", 'dtl.food_no_fk', 'food.FOOD_NO_PK')
                    ->select('diet.DIET_NAME', 'diet.DIET_TIME', 'food.FOOD_NAME')
                    ->where("DIET_CHART_NO_FK", $id)
                    ->get();

        $result = [];
        foreach ($item as $key => $value) {
            $time = $value->diet_name . ' (' . date('h:ia', strtotime($value->diet_time)) . ') ';
            if(!isset($result[$time])) {
                $result[$time] = [$value->food_name];
            } else {
                array_push($result[$time], $value->food_name);
            }
        }

        return Template::loadview("admin.diet-chart.details", compact('result'));
    }

    public function delete($id)
    {
        DB::table('SYSC_DIETFOOD')
            ->where('DIETFOOD_NO_PK', $id)
            ->delete();

        $message = ['msg' => 'Diet Food Deleted Successfully', 'title' => 'Success',]; 

        return response()->json($message);
    }

    public function report(Request $request)
    {
        $items = DB::table('SYSC_DIET_CHARTMST mst')
                    // ->join('SYSC_DIET_CHART_DTL dtl', 'mst.DIET_CHART_NO_PK', 'dtl.DIET_CHART_NO_FK')
                    // ->join('SYSC_FOOD food', 'food.FOOD_NO_PK', 'dtl.FOOD_NO_FK')
                    // ->select('mst.diet_chart_no_pk', 'mst.DIET_CHART_NAME', 'mst.NOTE', 'mst.PRICE', 'mst.STATUS', 'food.FOOD_NAME')
                    ->select('diet_chart_no_pk', 'diet_chart_name', 'note', 'price', 'status')
                    ->orderByDesc('diet_chart_no_pk')
                    ->get();

        $reports = [];
        foreach($items as $item) {
            $details = DB::table("SYSC_DIET_CHART_DTL dtl")
                    ->join("SYSC_DIETSLOT diet", 'dtl.diet_no_fk', 'diet.DIET_NO_PK')
                    ->join("SYSC_FOOD food", 'dtl.food_no_fk', 'food.FOOD_NO_PK')
                    ->select('diet.DIET_NAME', 'diet.DIET_TIME', 'food.FOOD_NAME')
                    ->where("DIET_CHART_NO_FK", $item->diet_chart_no_pk)
                    ->get();

            $result = [];
            foreach ($details as $key => $value) {
                $time = $value->diet_name . ' (' . date('h:ia', strtotime($value->diet_time)) . ') ';
                if(!isset($result[$time])) {
                    $result[$time] = [$value->food_name];
                } else {
                    array_push($result[$time], $value->food_name);
                }
            }

            array_push($reports, [
                $item->diet_chart_name => $result
            ]);
        }

        $pdf = PDF::loadView("admin.diet-chart.report", ['items' => $reports])->setPaper('a4', 'landscape');
        return $pdf->stream('diet-chart.pdf');
    }

    /**
     * Diet Chart Report
     */
    public function reportV1(Request $request)
    {
        $items = DB::table("IPD_DIETCHART_VW")->orderBy('diet_chart_name')->get();

        $pdf = PDF::loadView("admin.diet-chart.report-v1", ['items' => $items])->setPaper('a4', 'landscape');
        return $pdf->stream('diet-chart.pdf');
    }
}
