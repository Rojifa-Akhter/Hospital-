<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FoodTypeController extends Controller
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
        $items = DB::table('SYSC_FOOD')
                    ->select('FOOD_NO_PK', 'FOOD_NAME', 'STATUS')
                    ->orderByDesc('FOOD_NO_PK')
                    ->get();

        return Template::loadview("admin.foodType.index", compact('items'));
    }

    public function create()
    {
        return Template::loadview("admin.foodType.createEdit");
    }

    public function store(Request $request)
    {
        DB::table('SYSC_FOOD')->insert([
            "FOOD_NO_PK"                => $this->getSequence('FOOD_NO_PK_SEQ'), 
            "food_name"                 => $request->input("food_name"),
            "status"                    => 1,
            "au_entry_at"               => Carbon::now()->toDateString(),
            "au_entry_by"               => Auth::id(),
            "AU_ENTRY_SESSION"          => auth()->user()->user_name,
            "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
        ]);

        $message = ['msg' => 'Food Type Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function edit(int $id)
    {
        $item = DB::table('SYSC_FOOD')
            ->where('FOOD_NO_PK', $id)
            ->select('FOOD_NO_PK', 'FOOD_NAME', 'STATUS')
            ->orderByDesc('FOOD_NO_PK')
            ->first();

        return Template::loadview("admin.foodType.createEdit", compact("item"));
    }

    public function update(Request $request, int $id)
    {
        DB::table('SYSC_FOOD')
            ->where('FOOD_NO_PK', $id)
            ->update([
                "food_name"                 => $request->input("food_name"),
                "status"                    => 1,
                'AU_UPDATE_AT'              => Carbon::now()->toDateString(),
                'AU_UPDATE_BY'              => Auth::id(),
                'AU_UPDATE_SESSION'         => auth()->user()->user_name,
                'AU_UPDATE_HOSPITAL_NO_FK'  => session()->get('user.ses_hospital_no_pk'),
            ]);

        $message = ['msg' => 'Food Type Updated Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function delete($id)
    {
        DB::table('SYSC_FOOD')
            ->where('FOOD_NO_PK', $id)
            ->delete();

        $message = ['msg' => 'Food Type Deleted Successfully', 'title' => 'Success',]; 

        return response()->json($message);
    }
}
