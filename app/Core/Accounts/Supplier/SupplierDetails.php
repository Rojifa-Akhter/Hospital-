<?php

namespace App\Core\Accounts\Supplier;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\Supplier\Supplier;


class SupplierDetails implements Supplier
{
    public function get_supplier($search)
    {
        return $employee = DB::table('suppliers_vw')
                        ->where('au_entry_hospital_pk_no', Auth::user()->au_entry_hospital_pk_no)
                        ->whereRaw('upper(supplier_name) LIKE '."'%".Str::upper($search)."%'")
                        ->get();
    }
}