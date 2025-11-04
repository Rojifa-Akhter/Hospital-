<?php

namespace App\Core\Carparking\CarparkingPolicy;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Carparking\CarparkingPolicy\CarparkingPolicy;
use App\LookupList;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Datatables\DataTableClass;

class CarparkingPolicyDetails implements CarparkingPolicy
{
    use LookupData;
    public function carparking()
    {
        $vicicle_type = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_code', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', 'CARPARKING')
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();
        return $vicicle_type;
    }

    public function carparkingData(Request $request)
    {
        $hospital_id = session::get('user.ses_hospital_no_pk');
        $sql_cond = '';
        $where = '';
        $table = 'carp_ratepolicy_vw';
        // table's primary key
        $primaryKey = 'ratepolicy_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'ratepolicy_uid', 'dt' => 1),
            array('db' => 'vehicle_type', 'dt' => 2),
            array('db' => 'minimum_rate',  'dt' => 3),
            array('db' => 'minimum_hour',  'dt' => 4),
            array('db' => 'hourly_rate',  'dt' => 5),
            array('db' => 'ratepolicy_no_pk',  'dt' => 6),

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
}
