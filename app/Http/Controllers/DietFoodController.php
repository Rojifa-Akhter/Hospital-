<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DietFoodController extends Controller
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
     * Food Type Listing
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        $items = DB::table('SYSC_DIETFOOD a')
                    ->join('SYSC_DIETSLOT b', 'a.DIET_NO_FK', 'b.DIET_NO_PK')
                    ->join('SYSC_FOOD c', 'a.FOOD_NO_FK', 'c.FOOD_NO_PK')
                    ->select('a.DIETFOOD_NO_PK', 'a.DIET_NO_FK', 'a.FOOD_NO_FK', 'a.STATUS', 'b.DIET_NAME', 'b.DIET_TIME', 'c.FOOD_NAME')
                    ->orderByDesc('DIETFOOD_NO_PK')
                    ->get();

        return Template::loadview("admin.diet-foods.index", compact('items'));
    }

    public function create()
    {
        $diets = DB::table("SYSC_DIETSLOT")->get();
        $foods = DB::table("SYSC_FOOD")->get();

        return Template::loadview("admin.diet-foods.createEdit", compact("diets", "foods"));
    }

    public function store(Request $request)
    {
        foreach($request->input("food_no_fk") as $food_no_fk) {
            DB::table('SYSC_DIETFOOD')->insert([
                "DIETFOOD_NO_PK"            => $this->getSequence('DIETFOOD_NO_PK_SEQ'),
                "diet_no_fk"                => $request->input("diet_no_fk"),
                "food_no_fk"                => $food_no_fk,
                "status"                    => 1,
                "au_entry_at"               => Carbon::now()->toDateString(),
                "au_entry_by"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
            ]);
        }

        $message = ['msg' => 'Diet Food Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function edit(int $id)
    {
        $diets = DB::table("SYSC_DIETSLOT")->get();
        $foods = DB::table("SYSC_FOOD")->get();

        $item = DB::table('SYSC_DIETFOOD a')
            ->where('a.DIETFOOD_NO_PK', $id)
            ->join('SYSC_DIETSLOT b', 'a.DIET_NO_FK', 'b.DIET_NO_PK')
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

    public function delete($id)
    {
        DB::table('SYSC_DIETFOOD')
            ->where('DIETFOOD_NO_PK', $id)
            ->delete();

        $message = ['msg' => 'Diet Food Deleted Successfully', 'title' => 'Success',]; 

        return response()->json($message);
    }
}
