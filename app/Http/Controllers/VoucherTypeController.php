<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Accounts\VoucherType\VoucherType;

class VoucherTypeController extends Controller
{
    protected $voucher_type;

    public function __construct(VoucherType $voucher_type)
    {
        $this->voucher_type = $voucher_type;
    }

    public function add_voucher_type(Request $request)
    {
        $voucher_type_code = $request->voucher_type_code;
        $voucher_type_name = $request->voucher_type_name;

        $voucher_type = $this->voucher_type->add_voucher_type([
            'voucher_type_code' => $voucher_type_code,
            'voucher_type_name' => $voucher_type_name
        ]);
        if ($voucher_type->getData()->success == true) {
            return response()->json(['success' => true, 'message' => $voucher_type->getData()->message], 200);
        } else {
            return response()->json(['success' => false, 'message' => $voucher_type->getData()->message], 200);
        }
    }

    public function get_voucher_type()
    {
        try {

            $voucher_type = $this->voucher_type->get_voucher_type();
            
            return response()->json(['success' => true, 'data' => $voucher_type->getData()->data], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }

    }


    // Accounts V1 Route
    public function get_voucher_type_v1()
    {
        try {

            $voucher_type = $this->voucher_type->get_voucher_type_v1();
            return response()->json(['success' => true, 'data' => $voucher_type->getData()->data], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        }

    }

    public function add_voucher_type_v1(Request $request)
    {
    
        $request->validate([
            'voucher_type_code' =>'required|max:50',
            'voucher_type_name' =>'required|max:50',
        ]);
        $voucher_type_code = $request->voucher_type_code;
        $voucher_type_name = $request->voucher_type_name;

        $voucher_type = $this->voucher_type->add_voucher_type_v1([
            'voucher_type_code' => $voucher_type_code,
            'voucher_type_name' => $voucher_type_name
        ]);
        
        return $voucher_type;
    }

    public function set_voucher_type_status_v1(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);
        $id = $request->id;
        $status = $request->status;
        $status = $this->voucher_type->set_voucher_type_status_v1($status,$id);
        return $status;
    }
}