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

class DietTypeController extends Controller
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
     * Diet Type Listing
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        $items = DB::table('SYSC_DIETSLOT')
                    ->select('DIET_NO_PK', 'DIET_NAME', 'DIET_TIME', 'STATUS')
                    ->orderByDesc('DIET_NO_PK')
                    ->get();

        return Template::loadview("admin.dietType.index", compact('items'));
    }

    public function create()
    {
        return Template::loadview("admin.dietType.createEdit");
    }

    public function store(Request $request)
    {
        DB::table('SYSC_DIETSLOT')->insert([
            "DIET_NO_PK"                => $this->getSequence('DIET_NO_PK_SEQ'),
            "diet_name"                 => $request->input("diet_name"),
            "diet_time"                 => date('H:i:s', strtotime($request->input("diet_time"))),
            "status"                    => 1,
            "au_entry_at"               => Carbon::now()->toDateString(),
            "au_entry_by"               => Auth::id(),
            "AU_ENTRY_SESSION"          => auth()->user()->user_name,
            "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
        ]);


        DB::beginTransaction();
        try {

            $pdo = DB::getPdo();
            $med_cal = $pdo->prepare("begin IPD_DIETCHART(); end;");
            $med_cal->execute();
        } catch (Exception $th) {
            DB::rollBack();
            // return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }

        

        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function edit(int $id)
    {
        $item = DB::table('SYSC_DIETSLOT')
            ->where('DIET_NO_PK', $id)
            ->select('DIET_NO_PK', 'DIET_NAME', 'DIET_TIME', 'STATUS')
            ->orderByDesc('DIET_NO_PK')
            ->first();

        return Template::loadview("admin.dietType.createEdit", compact("item"));
    }

    public function update(Request $request, int $id)
    {
        DB::table('SYSC_DIETSLOT')
            ->where('DIET_NO_PK', $id)
            ->update([
                "diet_name"                 => $request->input("diet_name"),
                "diet_time"                 => date('H:i:s', strtotime($request->input("diet_time"))),
                "status"                    => 1,
                'AU_UPDATE_AT'              => Carbon::now()->toDateString(),
                'AU_UPDATE_BY'              => Auth::id(),
                'AU_UPDATE_SESSION'         => auth()->user()->user_name,
                'AU_UPDATE_HOSPITAL_NO_FK'  => session()->get('user.ses_hospital_no_pk'),
            ]);

        $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function delete($id)
    {
        DB::table('SYSC_DIETSLOT')
            ->where('DIET_NO_PK', $id)
            ->delete();

        $message = ['msg' => 'Diet Type Deleted Successfully', 'title' => 'Success',]; 

        return response()->json($message);
    }
}
