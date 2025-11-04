<?php

namespace App\Traits;

use App\Models\Lookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Auth;

trait LookupData
{
    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $code    string defining UID
     *  @return array        Array of Lookup Data values
     */
    public static function getLookupListByCode($code)
    {
        $lookupdata = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->whereNull('ipd_consultant_ind')
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
            ->get();
           

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_arr[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        //  dd($lookup_arr);

        return $lookup_arr;
    }


    public static function getLookupListByCodeAll($code)
    {
        $lookupdata = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            // ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
            ->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_arr[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        return $lookup_arr;
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $code    string defining UID
     *  @return array        Array of Lookup Data values
     */
    public static function getLookupListByCodeCustomKey($field, $code)
    {
        $lookupdata = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_code', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('sysc_lookupdata.serial_no', 'desc')
            ->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_arr[$row->$field] = $row->lookupdata_name;
            }
        }

        return $lookup_arr;
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $lookup_code    string defining UID
     *  @return array        Array of Lookup Autocomplete Data values
     */
    public function getLookupDataAutocompleteList(Request $request)
    {
        $lkcode = trim($request->lookup_code);
        $keyword = trim($request->search_data);

        $lookupdata = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_code', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $lkcode)
            ->whereRaw(DB::raw("upper(sysc_lookup.lookup_code) like '%$keyword%' or upper(sysc_lookupdata.lookupdata_name) like '%$keyword%' "))
            ->where('sysc_lookupdata.status', 1)
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();

        $lookup_data = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $lkdata) {
                $lookup_data[] = array(
                    'lookupdata_id' => $lkdata->lookupdata_no_pk,
                    'lookupdata_code' => $lkdata->lookupdata_code,
                    'lookupdata_name' => $lkdata->lookupdata_name,
                    'lookupdata_desc' => $lkdata->lookupdata_desc,
                );
            }
            return $lookup_data;
        }
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $lookup_code    string defining UID
     *  @return array        Array of Lookup Autocomplete Data values
     */
    public function getPresLookupDataAutocompleteList(Request $request)
    {
        $lkcode = trim($request->lookup_code);
        $keyword = strtoupper(trim($request->search_data));
        $keyword = str_replace("'", "’", $keyword);

        $lookupdata = DB::table('pres_lookupdata_vw')
            ->where('pres_lookupdata_vw.pres_lookup_code', '=', $lkcode)
            ->whereRaw(DB::raw("upper(pres_lookupdata_vw.pres_lookupdata_name) like '%$keyword%' "))
            ->where('pres_lookupdata_vw.status', 1)
            ->orderBy('pres_lookupdata_vw.serial', 'asc')
            ->get();
            // dd($lookupdata);
        $lookup_data = [];
        // dd($lookupdata);
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $lkdata) {
                $lookup_data[] = array(
                    'pres_lookupdata_id' => $lkdata->pres_lookupdata_no_pk,
                    'pres_lookupdata_code' => $lkdata->pres_lookupdata_code,
                    'pres_lookupdata_name' => $lkdata->pres_lookupdata_name,
                    'pres_lookup_no_pk' => $lkdata->pres_lookup_no_pk,
                    'pres_lookup_code' => $lkdata->pres_lookup_code,
                    'pres_lookup_name' => $lkdata->pres_lookup_name,
                );
            }
            return $lookup_data;
        }
    }
    public function genericDataAutocompleteList(Request $request)
    {
        // $lkcode = trim($request->lookup_code);
        $keyword = strtoupper(trim($request->search_data));

        $data = DB::table('sysc_generic')
            // ->where('pres_lookupdata_vw.pres_lookup_code', '=', $lkcode)
            ->whereRaw(DB::raw("upper(sysc_generic.generic_name) like '%$keyword%' "))
            ->where('sysc_generic.status', 1)
            ->where('sysc_generic.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('sysc_generic.generic_name', 'asc')
            ->get();

        $generic_data = [];
        if (!empty($data)) {
            foreach ($data as $lkdata) {
                $generic_data[] = array(
                    'generic_no_pk' => $lkdata->generic_no_pk,
                    'generic_uid' => $lkdata->generic_uid,
                    'generic_name' => $lkdata->generic_name,

                );
            }
            return $generic_data;
        }
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $code    string defining UID
     *  @return array        Array of Lookup Data values
     */
    public static function getPresLookupListByCode($code, $index = "")
    {


        $lookupdata = DB::table('pres_lookupdata_vw')
            ->where('pres_lookup_code', '=', $code)
            // ->where('pres_lookupdata_vw.status', 1)
            ->orderBy('serial', 'asc')
            ->get();
        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                if ($index != "") {
                    $lookup_arr[$row->$index]['data'] = $row->pres_lookupdata_name;
                    $lookup_arr[$row->$index]['attr'] = $row->dose_other_qty;
                    $lookup_arr[$row->$index]['entry'] = $row->au_entry_by;
                } else {
                    $lookup_arr[$row->pres_lookupdata_no_pk] = $row->pres_lookupdata_name;
                }
            }
        }

        return $lookup_arr;
    }

    public static function getPresLookupListByCodeEwmch($code, $index = "")
    {
        $doctor_id = Auth::id();
        $lookupdata = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME,data.AU_ENTRY_BY from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        and PRES_LOOKUP_CODE='$code'
        and (data.AU_ENTRY_BY    = $doctor_id
        or DEFAULT_IND=1)");
        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                if ($index != "") {
                    $lookup_arr[$row->$index]['data'] = $row->pres_lookupdata_name;
                    // $lookup_arr[$row->$index]['attr'] = $row->dose_other_qty;
                    $lookup_arr[$row->$index]['entry'] = $row->au_entry_by;
                } else {
                    $lookup_arr[$row->pres_lookupdata_no_pk] = $row->pres_lookupdata_name;
                }
            }
        }

        return $lookup_arr;
    }

     public static function getPresLookupListByCodeDoses($code, $index = "")
    {
        $doctor_id = Auth::id();
        
        $lookupdata = DB::select("select 
      dose.PRES_LOOKUPDATA_NO_PK,
      dose.PRES_LOOKUPDATA_NAME,
      dose.AU_ENTRY_BY from (
        SELECT 
              data.PRES_LOOKUPDATA_NO_PK,
              data.DEFAULT_IND,
              nvl(data.PRES_LOOKUPDATA_NAME,MED.DOSAGE) AS PRES_LOOKUPDATA_NAME,
              nvl(data.AU_ENTRY_BY,med.AU_ENTRY_BY) AS AU_ENTRY_BY
            FROM 
             (select distinct m.DOSAGE, M.AU_ENTRY_BY from PSN_T_PRESCRIPTION_MED m ) med
            left join (select 
            D.DEFAULT_IND,
             d.PRES_LOOKUPDATA_NO_PK,
              d.PRES_LOOKUPDATA_NAME,
              d.AU_ENTRY_BY
            from  PRES_LOOKUPDATA  d
             JOIN PRES_LOOKUP  lookup ON d.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK 
             where UPPER(lookup.PRES_LOOKUP_CODE) = '$code') data on  MED.DOSAGE = DATA.PRES_LOOKUPDATA_NAME ) dose
              where
               dose.AU_ENTRY_BY = $doctor_id
               OR dose.DEFAULT_IND = 1");
               
        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                if ($index != "") {
                    $lookup_arr[$row->$index]['data'] = $row->pres_lookupdata_name;
                    // $lookup_arr[$row->$index]['attr'] = $row->dose_other_qty;
                    $lookup_arr[$row->$index]['entry'] = $row->au_entry_by;
                } else {
                    $lookup_arr[$row->pres_lookupdata_no_pk] = $row->pres_lookupdata_name;
                }
            }
        }

        return $lookup_arr;
    }
    public static function getPresLookupDTLListByCode($code, $index = "")
    {

        $lookupdata = DB::table('pres_lookupdata_vw')
            ->leftjoin('pres_lookupdata_dtl1', 'pres_lookupdata_vw.pres_lookupdata_no_pk', 'pres_lookupdata_dtl1.psn_lookupdata_no_fk')
            ->where('pres_lookup_code', '=', $code)
            ->where('pres_lookupdata_dtl1.su_no_fk', Session::get('user.su_pk_no'))
            // ->where('pres_lookupdata_vw.status', 1)
            ->orderBy('serial', 'asc')
            ->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                if ($index != "") {
                    $lookup_arr[$row->$index]['data'] = $row->pres_lookupdata_name;
                } else {
                    $lookup_arr[$row->pres_lookupdata_code][] = $row;
                }
            }
        }

        return $lookup_arr;
    }
    public static function getPresLookupHistoryDTLListByCode($code, $index = "", $su = "")
    {

        $lookupdata = DB::table('pres_lookupdata_vw')
            ->leftjoin('pres_lookupdata_dtl1', 'pres_lookupdata_vw.pres_lookupdata_no_pk', 'pres_lookupdata_dtl1.psn_lookupdata_no_fk')
            ->where('pres_lookup_code', '=', $code)
            ->where('pres_lookupdata_dtl1.su_no_fk', $su)
            // ->where('pres_lookupdata_vw.status', 1)
            ->orderBy('serial', 'asc')
            ->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                if ($index != "") {
                    $lookup_arr[$row->$index]['data'] = $row->pres_lookupdata_name;
                } else {
                    $lookup_arr[$row->pres_lookupdata_code][] = $row;
                }
            }
        }

        return $lookup_arr;
    }

    public static function getPresLookupListByMultipleCode($code_arr)
    {
        $lookupdata = DB::table('psn_s_lookup_vw')
            ->select('pres_lookupdata_no_pk', 'pres_lookupdata_name', 'pres_lookup_code', 'pres_lookupdata_code', 'pres_lookup_no_pk')
            ->whereIn('pres_lookup_code', $code_arr)
            ->get();

        $lookup_data = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_data[$row->pres_lookup_code][] = (object) array(
                    'lookupdata_id' => $row->pres_lookupdata_no_pk,
                    'lookupdata_name' => $row->pres_lookupdata_name,
                    'lookupdata_uid' => $row->pres_lookupdata_code,
                    'lookup_code' => $row->pres_lookup_code,
                    'lookup_id' => $row->pres_lookup_no_pk,
                );
            }
        }

        return (object) $lookup_data;
    }

    public static function getPresLookupListByMultipleCodeAlergy($code_arr)
    {
        $lookupdata = DB::table('psn_s_lookup_vw')
            ->select('pres_lookupdata_no_pk', 'pres_lookupdata_name', 'pres_lookup_code', 'pres_lookupdata_code', 'pres_lookup_no_pk')
            ->whereIn('pres_lookup_code', $code_arr)
            ->get();

        $lookup_data = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_data[$row->pres_lookup_code][] = (object) array(
                    'lookupdata_id' => $row->pres_lookupdata_no_pk,
                    'lookupdata_name' => $row->pres_lookupdata_name,
                    'lookupdata_uid' => $row->pres_lookupdata_code,
                    'lookup_code' => $row->pres_lookup_code,
                    'lookup_id' => $row->pres_lookup_no_pk,
                );
            }
        }

        return (object) $lookup_data;
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $code    string defining UID
     *  @return array        Array of Lookup Data values
     */
    public static function getPresLookupIDByCode($code)
    {
        $lookupdata = DB::table('pres_lookup')
            ->where('pres_lookup_code', $code)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_arr[$row->pres_lookup_code] = $row->pres_lookup_no_pk;
            }
        }
        return (object) $lookup_arr;
    }

    public static function getDocPresLookupIDByCode($code)
    {
        $lookupdata = DB::table('pres_lookup')->whereIn('pres_lookup_code', $code)->get();

        $lookup_arr = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $row) {
                $lookup_arr[$row->pres_lookup_code] = $row->pres_lookup_no_pk;
                //$lookup_arr[$row->pres_lookupdata_code] = $row->pres_lookupdata_code;
            }
        }
        return (object) $lookup_arr;
    }

    // public static function getPresLookupIDByCode ( $code )
    // {
    //     $lookupdata = DB::table('psn_s_lookup')
    //     ->whereIn('psn_lookup_uid', $code)
    //     ->get();

    //     $lookup_arr = [];
    //     if(!empty($lookupdata))
    //     {
    //         foreach ($lookupdata as $row) {
    //             $lookup_arr[$row->psn_lookup_uid] = $row->psn_lookup_no_pk;
    //         }
    //     }

    //     return (object)$lookup_arr;
    // }
    public static function getLookupIDByCode($code)
    {
        return DB::table('sysc_lookup')->select('lookup_no_pk')->where('lookup_code', $code)->first()->lookup_no_pk;
    }




    public function getPatientAreaDataAutocompleteList(Request $request)
    {
        $lkcode = trim($request->lookup_code);
        $keyword = strtoupper(trim($request->search_data));

        $lookupdata = DB::table('sysc_lookupdata dt')
                    ->join('sysc_lookup look','dt.lookup_no_fk','look.lookup_no_pk')
                    ->where('look.lookup_code', '=', 'PATIENTAREA')
                    ->whereraw(db::raw("upper(dt.lookupdata_name) like '%$keyword%' ")) //or (dt.serial_no) $keyword
                    // ->orWhere()
                    ->where('dt.status', 1)
                    ->get();


        $lookup_data = [];
        if (!empty($lookupdata)) {
            foreach ($lookupdata as $lkdata) {
                $lookup_data[] = array(
                    'lookupdata_no_pk' => $lkdata->lookupdata_no_pk,
                    'lookupdata_code' => $lkdata->lookupdata_code,
                    'lookupdata_name' => $lkdata->lookupdata_name,
                    'lookup_no_pk' => $lkdata->lookup_no_pk,
                    'lookup_code' => $lkdata->lookup_code,
                    'lookup_name' => $lkdata->lookup_name,
                );
            }
            return $lookup_data;
        }
    }




}
