<?php

namespace App\Http\Controllers;

use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use App\Models\ServiceUnit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class FloorController extends Controller
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
     * Floor Listing
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        $items = DB::table('SYSC_PHYSICALSTRUCTFLOOR')
                    ->join('SYSC_PHYSICALSTRUCTUREBUILDING', 'SYSC_PHYSICALSTRUCTFLOOR.PHYSICALSTRUCT_BUILDING_NO_PK', 'SYSC_PHYSICALSTRUCTUREBUILDING.PHYSICALSTRUCT_BUILD_NO_PK')
                    ->select('PHYSICALSTRUCT_NO_PK', 'PHYSICALSTRUCT_FLOOR_SL', 'PHYSICALSTRUCT_UID', 'PHYSICALSTRUCT_NAME', 'PHYSICALSTRUCT_DESC', 'PHYSICALSTRUCT_BUILDING_NO_PK', 'PHYSICALSTRUCT_FLOORTYPE', 'SYSC_PHYSICALSTRUCTFLOOR.STATUS', 'SYSC_PHYSICALSTRUCTUREBUILDING.PHYSICALSTRUCT_BUILD_NAME')
                    ->orderByDesc('SYSC_PHYSICALSTRUCTFLOOR.PHYSICALSTRUCT_NO_PK')
                    ->get();

        return Template::loadview("admin.floor.index", compact('items'));
    }

    public function create()
    {
        $buildings = DB::table('SYSC_PHYSICALSTRUCTUREBUILDING')
                        ->select('PHYSICALSTRUCT_BUILD_NO_PK', 'PHYSICALSTRUCT_BUILD_NAME')
                        ->orderBy('PHYSICALSTRUCT_BUILD_NAME')        
                        ->get();

        return Template::loadview("admin.floor.createEdit", compact('buildings'));
    }

    public function store(Request $request)
    {
        $seq = $this->getSequence('PHYSICALSTRUCT_NO_PK_SEQ');

        DB::table('SYSC_PHYSICALSTRUCTFLOOR')->insert([
            "PHYSICALSTRUCT_NO_PK"          => $seq,
            "PHYSICALSTRUCT_FLOOR_SL"       => $seq,
            "PHYSICALSTRUCT_UID"            => $seq,
            "PHYSICALSTRUCT_NAME"           => $request->input("physicalstruct_name"),
            "PHYSICALSTRUCT_DESC"           => $request->input("physicalstruct_desc"),
            "PHYSICALSTRUCT_BUILDING_NO_PK" => $request->input("physicalstruct_building_no_pk"),
            "PHYSICALSTRUCT_FLOORTYPE"      => $request->input("physicalstruct_floortype"),
            "status"                        => 1,
            "au_entry_at"                   => Carbon::now()->toDateString(),
            "au_entry_by"                   => Auth::id(),
            "AU_ENTRY_SESSION"              => auth()->user()->user_name,
            "AU_ENTRY_HOSPITAL_PK_NO"       => session()->get('user.ses_hospital_no_pk'),
            'PHYSICALSTRUCT_BUILDING_NO_FK' => $request->input("physicalstruct_building_no_pk"),
        ]);

        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function edit(int $id)
    {
        $buildings = DB::table('SYSC_PHYSICALSTRUCTUREBUILDING')
                        ->select('PHYSICALSTRUCT_BUILD_NO_PK', 'PHYSICALSTRUCT_BUILD_NAME')
                        ->orderBy('PHYSICALSTRUCT_BUILD_NAME')        
                        ->get();

        $item = DB::table('SYSC_PHYSICALSTRUCTFLOOR')
            ->join('SYSC_PHYSICALSTRUCTUREBUILDING', 'SYSC_PHYSICALSTRUCTFLOOR.PHYSICALSTRUCT_BUILDING_NO_PK', 'SYSC_PHYSICALSTRUCTUREBUILDING.PHYSICALSTRUCT_BUILD_NO_PK')
            ->where('PHYSICALSTRUCT_NO_PK', $id)
            ->select('PHYSICALSTRUCT_NO_PK', 'PHYSICALSTRUCT_FLOOR_SL', 'PHYSICALSTRUCT_UID', 'PHYSICALSTRUCT_NAME', 'PHYSICALSTRUCT_DESC', 'PHYSICALSTRUCT_BUILDING_NO_PK', 'PHYSICALSTRUCT_FLOORTYPE', 'SYSC_PHYSICALSTRUCTFLOOR.STATUS', 'SYSC_PHYSICALSTRUCTUREBUILDING.PHYSICALSTRUCT_BUILD_NAME')
            ->first();

        return Template::loadview("admin.floor.createEdit", compact("buildings", "item"));
    }

    public function update(Request $request, int $id)
    {
        DB::table('SYSC_PHYSICALSTRUCTFLOOR')
            ->where('PHYSICALSTRUCT_NO_PK', $id)
            ->update([
                "PHYSICALSTRUCT_NAME"           => $request->input("physicalstruct_name"),
                "PHYSICALSTRUCT_DESC"           => $request->input("physicalstruct_desc"),
                "PHYSICALSTRUCT_BUILDING_NO_PK" => $request->input("physicalstruct_building_no_pk"),
                "PHYSICALSTRUCT_FLOORTYPE"      => $request->input("physicalstruct_floortype"),
                "status"                    => 1,
                'AU_UPDATE_AT'              => Carbon::now()->toDateString(),
                'AU_UPDATE_BY'              => Auth::id(),
                'AU_UPDATE_SESSION'         => auth()->user()->user_name,
                'AU_UPDATE_HOSPITAL_PK_NO'  => session()->get('user.ses_hospital_no_pk'),
            ]);

        $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function delete($id)
    {
        DB::table('SYSC_PHYSICALSTRUCTFLOOR')
            ->where('PHYSICALSTRUCT_NO_PK', $id)
            ->delete();

        $message = ['msg' => 'Floor Deleted Successfully', 'title' => 'Success',]; 

        return response()->json($message);
    }
}
