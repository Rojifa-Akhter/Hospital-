<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemTypeWorkflowRequest;
use App\Http\Requests\ItemTypeWorkflowUpdateRequest;
use Session;
use Carbon\Carbon;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Models\ItemTypeWorkflow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PhonebookController extends Controller
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
        return Template::loadview("admin.phonebook.index");
    }

    /**
     * Get all item type data to feed datatable
     */
    public function getItemTypeData() {
        $items = DB::table('SYSC_PHONEBOOK')
            ->orderByDesc('PHONEBOOK_no_pk')
            ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        return Template::loadview("admin.phonebook.createUpdate");
    }

    /**
     * Save data to database
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "PHONEBOOK_no_pk"   => $this->getSequence('PHONEBOOK_no_pk_seq'),
                "full_name"         => $request->input('full_name'),
                "designation"       => $request->input('designation'),
                "department"        => $request->input('department'),
                "pabx_no"           => $request->input('pabx_no'),
                "phone_mobile"      => $request->input('phone_mobile') ?? "",
                "phone_office"      => $request->input('phone_office') ?? "",
                "email_personal"    => $request->input('email_personal') ?? "",
                "pe_addr1"          => $request->input('pe_addr1') ?? "",
                "extension"         => $request->input('extension') ?? "",
            ];

            // ItemTypeWorkflow::create($itemTypeWorkflow);
            DB::table('SYSC_PHONEBOOK')->insert($data);
            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Phonebook Successfully Saved'], 200);
        } catch(\Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    /**
     * Edit Phonebook
     */
    public function edit(int $id)
    {
        $item = DB::table('SYSC_PHONEBOOK')
            ->where('PHONEBOOK_no_pk', $id)
            ->orderByDesc('PHONEBOOK_no_pk')
            ->first();

        return Template::loadview("admin.phonebook.createUpdate", ['item' => $item]);
    }

    public function update(Request $request, int $id)
    {


        DB::beginTransaction();

        try {
            $data = [
                "PHONEBOOK_no_pk"   => $this->getSequence('PHONEBOOK_no_pk_seq'),
                "full_name"         => $request->input('full_name'),
                "designation"       => $request->input('designation'),
                "department"        => $request->input('department'),
                "pabx_no"           => $request->input('pabx_no'),
                "phone_mobile"      => $request->input('phone_mobile') ?? "",
                "phone_office"      => $request->input('phone_office') ?? "",
                "email_personal"    => $request->input('email_personal') ?? "",
                "pe_addr1"          => $request->input('pe_addr1') ?? "",
                "extension"         => $request->input('extension') ?? "",
            ];

            // ItemTypeWorkflow::create($itemTypeWorkflow);
            DB::table('SYSC_PHONEBOOK')->where('PHONEBOOK_no_pk', $id)
                ->update($data);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Phonebook Successfully Updated'], 200);
        } catch(\Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }


    public function delete($id){
        
        DB::beginTransaction();
        try {
            DB::table('SYSC_PHONEBOOK')->where('PHONEBOOK_no_pk', $id)->delete();
            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Phonebook Successfully Updated'], 200);
        } catch(\Exception $exception) {
            DB::rollback();
            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }
}
