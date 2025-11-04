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

class GenericItemController extends Controller
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
     * List::Generic Item
     * 
     * @param RequestPayment $request
     * @return RedirectResponse
     */
    public function index()
    {
        
        $items = DB::table('sysc_generic')
                    // ->where('status', true)
                    ->select('generic_no_pk', 'generic_uid', 'generic_name', 'generic_description')
                    ->orderByDesc('generic_no_pk')
                    ->get();

        return Template::loadview("admin.genericItems.index", compact('items'));
    }

    /**
     * Create/Edit::Generic Item
     */
    public function create()
    {
        return Template::loadview("admin.genericItems.createEdit");
    }

    /**
     * Store::Generic Item
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $sequence = DB::getSequence();
            $generic_no_pk_seq = $sequence->nextValue('generic_no_pk_seq');

            DB::table('sysc_generic')->insert([
                "GENERIC_NO_PK"             => $generic_no_pk_seq,
                "GENERIC_NAME"              => $request->input("generic_name"),
                "GENERIC_DESCRIPTION"       => $request->input("generic_description"),
                "STATUS"                    => 1,
                "AU_ENTRY_AT"               => Carbon::now()->toDateString(),
                "AU_ENTRY_BY"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
            ]);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];
        } catch(Exception $exception) {
            DB::rollBack();
            $message = ['msg' => $exception->getMessage(), 'title' => 'Error',];
        }

        return response()->json($message);
    }

    /**
     * Edit::Generic Item
     */
    public function edit(int $id)
    {
        $item = DB::table('SYSC_GENERIC')
            ->where('GENERIC_NO_PK', $id)
            ->select('generic_no_pk', 'generic_uid', 'generic_name', 'generic_description')
            ->orderByDesc('GENERIC_NO_PK')
            ->first();
        
        return Template::loadview("admin.genericItems.createEdit", compact("item"));
    }
    
    /**
     * Update::Generic Item
     */
    public function update(Request $request, int $id)
    {
        DB::beginTransaction();

        try {
            DB::table('SYSC_GENERIC')
                ->where('GENERIC_NO_PK', $id)
                ->update([
                    "GENERIC_NAME"              => $request->input("generic_name"),
                    "GENERIC_DESCRIPTION"       => $request->input("generic_description"),
                    'AU_UPDATE_AT'              => Carbon::now()->toDateString(),
                    'AU_UPDATE_BY'              => Auth::id(),
                    'AU_UPDATE_SESSION'         => auth()->user()->user_name,
                    'AU_UPDATE_HOSPITAL_NO_FK'  => session()->get('user.ses_hospital_no_pk'),
                ]);

            DB::commit();
            $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success',];
        } catch(Exception $exception) {
            DB::rollBack();
            $message = ['msg' => $exception->getMessage(), 'title' => 'Error',];
        }
        
        return response()->json($message);
    }

    /**
     * Delete::Generic Item
     */
    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            $checkGenericId=DB::table('sysc_serviceitem')->where('generic_no_fk',$request->genId)->exists();;
            if (!$checkGenericId) {
               DB::table('SYSC_GENERIC')
                ->where('GENERIC_NO_PK', $request->genId)
                ->delete();
                DB::commit();
                $message = ['msg' => 'Data Deleted Successfully', 'title' => 'Success'];
            }else{
                $message = ['msg' => 'Already Item Created from this Generic.', 'title' => 'Error'];
            }
            
        } catch(Exception $exception) {
            DB::rollBack();
            $message = ['msg' => $exception->getMessage(), 'title' => 'Error'];
        }
        
        return response()->json($message);
    }
}
