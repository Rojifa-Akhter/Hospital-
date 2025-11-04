<?php

namespace App\Traits;

use PDO;
use Auth;
use App\Models\Item;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Repositories\BaseRepository as Repo;
use DateTime;
trait ItemData
{
    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $code    string defining UID
     *  @return array        Array of Lookup Data values
     */

    public static function getItemListAutoComplete1($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0)
    {
        $item_type = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtype = rtrim($item_type, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and sysc_itemtype.itemtype_code in($itemtype)" : "";

        $result  = DB::table('sysc_serviceitem')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceitem.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->leftJoin('sysc_itemtype', 'sysc_serviceitem.itemtype_no_fk', '=', 'sysc_itemtype.itemtype_no_pk')
            ->leftJoin('stock_ledger_vw', 'sysc_serviceitem.item_no_pk', '=', 'stock_ledger_vw.item_no_fk')
            ->select('sysc_serviceitem.item_no_pk', 'sysc_serviceitem.item_name', 'sysc_serviceitem.sales_price', 'sysc_serviceitem.item_code', 'sysc_serviceunit.serviceunit_no_pk', 'sysc_serviceunit.serviceunit_name', 'sysc_serviceitem.itemtype_no_fk', 'sysc_itemtype.itemtype_code', 'sysc_serviceitem.thrpex_ind', 'sysc_serviceitem.ether_ind', 'stock_ledger_vw.current_stock', 'sysc_serviceitem.manual_item_rate_ind')
            ->whereRaw(DB::raw("(upper(sysc_serviceitem.item_name) like '%$keyword%' or upper(sysc_serviceitem.item_code) like '%$keyword%') "))
            ->orderBy("sysc_serviceitem.item_name")
            ->get();

        $item_info = [];

        if ($result) {

            foreach ($result as $value) {

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_pk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->itemtype_code,
                    'thrpex_ind'        => $value->thrpex_ind,
                    'ether_ind'         => $value->ether_ind,
                    'current_stock'     => $value->current_stock,
                    'manual_item_rate_ind'     => $value->manual_item_rate_ind,
                );
            }
        }

        return $item_info;
    }



    public static function getItemListWithStockAutoComplete($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "", $sub_store = "",$patient_id,$admission_id="")
    {
        $keyword = strtoupper($keyword);
        $keyword = str_replace("'", "’", $keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockwithoutexpire l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.generic_no_fk',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                 DB::raw('CASE WHEN l.current_stock < 0 THEN 0 ELSE l.current_stock END as current_stock'),
                // 'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.disc_aplicable',
                's.vat_percent',
                's.generic_name',
                's.supplier_name',
            )
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond $su_no_cond"))
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
            if(!empty($sub_store)){
                $result->where('l.stock_su_no_fk', $sub_store);
            }
            // $result = $result->whereRaw('UPPER(ser.serviceunit_name) = ?', ['PHARMACY'])
            $result = $result->orderBy("s.item_name")->get();

        $item_info = [];

        if ($result) {

            foreach ($result as $value) {

                 $discount_perc =0;
                if (Session::get('user.ses_hospital_code')=="UNICO" ) {
                    $discount_perc_ptc=$value->default_discount ?? 0 ;
                    $patInfo =DB::table('pat_registration_wl_vw')->select('ccm_client_no_fk','patient_type_code')->where('patient_no_pk',$patient_id)->first();
                    $patient_type=!empty($patInfo) && $patInfo->patient_type_code !='' ? $patInfo->patient_type_code:0; 
                    $corporate_id=!empty($patInfo) && $patInfo->ccm_client_no_fk !='' ? $patInfo->ccm_client_no_fk:0; 
                    $sales_price_for_discount= $value->sales_price !="" ? $value->sales_price :0;
                    $ipd_dis_inapplicable=DB::table('patn_patienttype')->where('patient_type_code',$patient_type)->value('ipd_discount_inapplicable');                    
                    if ($admission_id !="" && $ipd_dis_inapplicable==1) {
                        $discount_perc =0;

                    }else{
                         $discount_perc_value =DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_pk,'$patient_type',$corporate_id, $sales_price_for_discount,0,$discount_perc_ptc,'PCT') as def_discount from dual"));
                        $discount_perc=$discount_perc_value[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  $discount_perc_value[0]->def_discount :0 ;
                    }
                    
                    // $value->default_discount_pct = $discount_perc;
                    // dd($value->item_no_pk,$patient_type,$corporate_id, $value->sales_price,$discount_perc_value);
                }else{
                        $discount_perc=$value->default_discount ?? 0 ;
                        // $value->default_discount_pct = $discount_perc;
                }

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'         => $value->purchase_price,
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' =>  $discount_perc ,//$value->default_discount,
                    'vat_percent' => $value->vat_percent,
                    'generic_name' => $value->generic_name,
                    'supplier_name' => $value->supplier_name,
                    'generic_no_fk' => $value->generic_no_fk,
                );
            }
        }

        return $item_info;
    }
    public static function getItemListWithStockAutoCompleteV2($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "",$sub_store="", $patient_no="",$admission_id="")
    {
        // dd( $patient_no, $admission_id);
        $keyword = strtoupper($keyword);
        $keyword = str_replace("'", "’", $keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }


        $medicinecoveragepercentages =0;

        if (Session::get('user.ses_hospital_code') == "DMHL" && $patient_no !='') {

       

            $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$patient_no)->first();
            $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502';
            $typeCode =$admission_id =='' ? '01' :'02' ;
          if ($input_value !="") {

            $requestData = [
                'ByUserId' => '8415',
                'PersonId' => '121529',
                'MobileNumber' => '-',
                'UserName' => 'info@divinemercyhospital.com',
                'SearchText' => $input_value, // Replace with your actual input value
                'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                'DiscountTypeCode'=>'01',
                'RequestFrom' => 'HIS'
            ];

            // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';

            $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
            $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

            // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
            // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

            $client = new Client();

            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'token' => $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $data = json_decode($body, true);
            // dd( $data);
            if (isset($data['Data'])) {
                $dataInside = json_decode($data['Data'], true);
                if (isset($dataInside[0]['MedicineCoveragePercentages'])) {
                    $medicinecoveragepercentages = $dataInside[0]['MedicineCoveragePercentages'];
                }
            }
         }
        }






        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockwithoutexpire l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->leftJoin('sysc_serviceitem_uom uom', 'uom.uom_no_pk', '=', 's.uom_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                'uom.uom_code as uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                 DB::raw('CASE WHEN l.current_stock < 0 THEN 0 ELSE l.current_stock END as current_stock'),
                // 'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.vat_percent',
                's.generic_name',
                's.generic_no_fk',
                's.supplier_name',
                's.disc_aplicable',
            )
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond $su_no_cond"))
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status',1);

            if(!empty($sub_store) && in_array(Session::get('user.ses_hospital_code'),["UNICO","DMHL","RLHL","KPJ"])){

                $result->where('l.stock_su_no_fk', $sub_store);
            }else{
             $result->whereRaw('UPPER(ser.serviceunit_name) = ?', ['PHARMACY']);
            }

            $result=$result->orderBy("s.item_name")->get();
            // dd($sub_store,Session::get('user.ses_hospital_code'));
        $item_info = [];

        if ($result) {

            foreach ($result as $value) {
                $discount_perc=0;
                $apiDiscount_ind=0;
                 $sales_price_for_discount=$value->sales_price !=null? $value->sales_price:0;
                if ($medicinecoveragepercentages  > 0) {
                    $discount_perc=$medicinecoveragepercentages ;
                    $apiDiscount_ind=1;
                }else {
                    $discount_perc_ptc=$value->default_discount ?? 0 ;
                     $discount_perc =0;
                    if (Session::get('user.ses_hospital_code')=="UNICO" && $patient_no !='') {
                      
                        $patInfo =DB::table('pat_registration_wl_vw')->select('ccm_client_no_fk','patient_type_code')->where('patient_no_pk',$patient_no)->first();
                        $patient_type=!empty($patInfo) && $patInfo->patient_type_code !='' ? $patInfo->patient_type_code:0; 
                        $corporate_id=!empty($patInfo) && $patInfo->ccm_client_no_fk !='' ? $patInfo->ccm_client_no_fk:0; 
                        $ipd_dis_inapplicable=DB::table('patn_patienttype')->where('patient_type_code',$patient_type)->value('ipd_discount_inapplicable'); 
                         if ($admission_id !="" && $ipd_dis_inapplicable==1) {
                             $discount_perc =0;
                         }else{
                                $discount_perc_value =DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_pk,'$patient_type',$corporate_id, $sales_price_for_discount,0,$discount_perc_ptc,'PCT') as def_discount from dual"));
                            $discount_perc=$discount_perc_value[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  $discount_perc_value[0]->def_discount :0 ;
                         }
                        
                        // dd($value->item_no_pk,$patient_type,$corporate_id, $value->sales_price,$discount_perc_value);
                    }else{
                         $discount_perc=$value->default_discount ?? 0 ;
                    }
                   
                }


                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'    => $value->purchase_price,
                    'item_rate'         => $sales_price_for_discount,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' => $discount_perc,
                    'apiDiscount_ind' => $apiDiscount_ind,
                    'vat_percent' => $value->vat_percent,
                    'generic_name' => $value->generic_name,
                    'generic_no_fk' => $value->generic_no_fk,
                    'supplier_name' => $value->supplier_name,
                );
            }
        }

        return $item_info;
    }
    public static function getCafeItemListWithStockAutoComplete($keyword, $itemtype = "",$service_unit="", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "",$empId="")
    {
        
        $keyword = strtoupper($keyword);
        $keyword = str_replace("'", "’", $keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }
        // $item_type_service_arr = $service_unit != "" ? DB::table('sysc_itemtype_workflow')
        // ->select('workflow_code')
        // ->where('service_point_su_no_fk', $service_unit)
        // ->where('status', 1)
        // ->pluck('workflow_code')
        // ->toArray() : [];

        // Add quotes around each element
        // $item_type_service_arr_quoted = array_map(function($item) {
        //     return "'$item'";
        // }, $item_type_service_arr);

        // Join the elements with commas
        // $item_type_service =!empty($item_type_service_arr) ? implode(',', $item_type_service_arr_quoted):'';
        //    dd( $item_type_service);
        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtypes != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        // $su_no_cond = ($service_unit != "") ? " and s.serviceunit_no_fk = '$service_unit'" : "";
        $su_no_cond = ($service_unit != "") ? " and l.stock_su_no_fk = '$service_unit'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockledger_vw_itemwise l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.vat_percent',
                's.sd_percent',
                's.generic_name',
                's.supplier_name',
            )
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond $su_no_cond"))
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->where('ser.serviceunit_no_pk', $service_unit)
            // ->where('ser.serviceunit_name', 'PHARMACY')
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        if ($result) {

            foreach ($result as $value) {
                $discountPct=$empId !="" ? 30 : $value->default_discount;
                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'         => $value->purchase_price,
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' => $discountPct,
                    'vat_percent' => $value->vat_percent,
                    'sd_percent' => $value->sd_percent,
                    'generic_name' => $value->generic_name,
                    'supplier_name' => $value->supplier_name,
                );
            }
        }

        return $item_info;
    }
    public static function getItemListWithStockAutoCompleteImperial($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "", $sub_store = "")
    {

        $keyword = strtoupper($keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockledger_vw_itemwise l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.vat_percent',
                's.generic_name',
                's.supplier_name',
            )
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond $su_no_cond"))
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
            // ->where('ser.serviceunit_name', 'PHARMACY')

            if(!empty($sub_store)){
                $result->where('l.stock_su_no_fk', $sub_store);
            }
            // $result->where('ser.serviceunit_name', 'PHARMACY')
            $result= $result->orderBy("s.item_name")
            ->get();

        $item_info = [];

        if ($result) {

            foreach ($result as $value) {

                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'         => $value->purchase_price,
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' => $value->default_discount,
                    'vat_percent' => $value->vat_percent,
                    'generic_name' => $value->generic_name,
                    'supplier_name' => $value->supplier_name,
                );
            }
        }
        // dd( $item_info);
        return $item_info;
    }




    public static function getItemListAutoComplete($keyword, $itemtype = "", $thrpex_ind = '', $ether_ind = '', $itemtype_void = "", $su_no_id = "", $corporate_id = "", $patient_type = "", $admission_id = "",$patient_id="")
    {

        $corporate_id = $corporate_id != "" ? $corporate_id : 0;
        $patient_type = $patient_type != "" ? strval($patient_type) : '0';
        $itemtype =$itemtype;


        $testCoveragePercentages =0;
        if (Session::get('user.ses_hospital_code') == "DMHL") {
            $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$patient_id)->first();
            $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502';
            $typeCode =$admission_id == "" ? '01' : '02';
          if ($input_value !="") {

            $requestData = [
                'ByUserId' => '8415',
                'PersonId' => '121529',
                'MobileNumber' => '-',
                'UserName' => 'info@divinemercyhospital.com',
                'SearchText' => $input_value, // Replace with your actual input value
                'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                'DiscountTypeCode'=>'01',
                'RequestFrom' => 'HIS'
            ];

            // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';

            $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
            $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

            // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
            // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

            $client = new Client();

            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'token' => $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $data = json_decode($body, true);
            // dd( $data);
            if (isset($data['Data'])) {
                $dataInside = json_decode($data['Data'], true);
                if (isset($dataInside[0]['TestCoveragePercentages'])) {
                    $testCoveragePercentages = $dataInside[0]['TestCoveragePercentages'];
                }
            }
         }
            // dd($testCoveragePercentages);
        }
        // dd($testCoveragePercentages);


        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);
        // dd($patient_type);
        $keyword = strtoupper($keyword);
        // $keyword = str_replace("'", "’", $keyword);
        // $keyword = str_replace('-', ' ', $keyword); // Replace hyphens with spaces
        $keyword = preg_replace('/\s+/', ' ', trim($keyword));
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim(str_replace('"','',$item_type), ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('sysc_serviceitem_uom u', 's.uom_no_fk', '=', 'u.uom_no_pk')
            ->leftJoin(
                DB::raw("(select item_no_fk,
                listagg (slv.store_name || ': ' || current_stock, ', ') within group (order by slv.store_name desc) item_store_stock
                from stock_ledger_vw slv
                group by item_no_fk)
                stock_ledger_privot"),
                function ($join) {
                    $join->on('s.item_no_pk', '=', 'stock_ledger_privot.item_no_fk');
                }
            )
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                'u.uom_code',
                'u.uom_label_desc',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                // 'l.current_stock',
                's.dealer_sales_price',
                // 'l.stock_status_text',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                'stock_ledger_privot.item_store_stock'

            )
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond  $su_no_cond "))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if ($result) {
            $apiDiscount_ind=0;
            $discounttypecode=02;
            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $discount = $value->default_discount != null ? $value->default_discount : 0;
                $def_dis =DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_pk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                $ipd_charge = [];
                $ipd_charge_prc = 0;
                $ipd_charge_prc2 = 0;
                $discount_perc=0;
                //    dd($value->item_no_pk,$patient_type,$corporate_id, $sales_price,0,$discount,'PCT');

                if ($testCoveragePercentages  > 0 && $value->disc_aplicable != 1) {
                   $discount_perc=$testCoveragePercentages ;
                   $apiDiscount_ind=1;
                }else {
                    $discount_perc=$def_dis[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  $def_dis[0]->def_discount :0 ;
                }
                if ($admission_id != "") {
                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$value->item_no_pk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));
                    if ($ipd_charge[0]->ipd_charge_amt != null) {
                        $ipd_charge_prc2=$ipd_charge[0]->ipd_charge_amt;
                        $ipd_charge_prc = $value->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;
                        $sales_price = round($value->sales_price + $ipd_charge_prc);
                    }
                } else {
                    $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                }
                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'    => $value->pr_uom_tradeprice,
                    'item_rate'         => $sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'item_type_name'    => $value->item_type, 
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'uom_code'          => $value->uom_code,
                    'uom_label_desc'     => $value->uom_label_desc,
                    'pr_uom_name'          => $value->pr_uom_name,
                    'pr_uom_no_fk'         => $value->pr_uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => 'N/A', //$value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text'      => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'      => $value->pr_uom_conversion_qty,
                    'item_sales_uom' =>  $value->uom_no_fk,
                    'supplier_name' => $value->supplier_name,
                    'vat_percent' => $value->vat_percent,
                    'disc_aplicable' => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'default_discount' => $discount_perc,
                    'apiDiscount_ind' => $apiDiscount_ind,
                    'discounttypecode' => $discounttypecode,
                    'ipd_charge' =>  $ipd_charge_prc,
                    'generic_name' =>  $value->generic_name,
                    'item_store_stock'=>$value->item_store_stock,
                    'service_charge_prc'=>$ipd_charge_prc2,

                );
            }
        }
      
        // dd(   $def_dis, $patient_type ,$item_info );
        return $item_info;
    }
    public static function getItemListAutoCompleteV1($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "", $corporate_id = "", $patient_type = "", $admission_id = "",$patient_id="")
    {

        $corporate_id = $corporate_id != "" ? $corporate_id : 0;
        $patient_type = $patient_type != "" ? strval($patient_type) : '0';
        //  dd(  $corporate_id );
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);


        $keyword = strtoupper($keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim(str_replace('"','',$item_type), ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and upper(s.item_type) in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";
        $result  = DB::table('sysc_serviceitem_vw s')
            ->leftJoin('sysc_serviceitem_uom u', 's.uom_no_fk', '=', 'u.uom_no_pk')
            // ->leftJoin('stock_ledger_vw l', 's.item_no_pk', '=', 'l.item_no_fk')
            // ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk','=','l.stock_su_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                'u.uom_code',
                'u.uom_label_desc',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                // 'l.current_stock',
                's.dealer_sales_price',
                // 'l.stock_status_text',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name'
            )
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $item_type_cond $item_type_void_cond $su_no_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];
     
        $age_years = 0;
        if ($patient_type =="STAFFDEPENDENTCHILD") {
            $pat_reg=DB::table('patn_registration')->where('patient_no_pk',$patient_id)->select('dob')->first();
           
            $birth_date = $pat_reg->dob !='' ? date('Y-m-d',strtotime($pat_reg->dob)):'' ;
            if ( $birth_date !='') {
                $current_date = date('Y-m-d');
                $birth_date_obj = new DateTime($birth_date);
                $current_date_obj = new DateTime($current_date);
                $diff = $current_date_obj->diff($birth_date_obj);
                $age_years = $diff->y;
            }
            $max_age_discount=DB::table('sysc_discountpolicy')->where('dispolicy_code', $patient_type)->value('max_age')??0;
            // dd( $max_age_discount, $age_years);
            if ($max_age_discount > 0 && $age_years > $max_age_discount) {
                 $patient_type ="GENERAL";
            }           
        }
        $pdo = DB::getPdo();
        $discount_pct=0;  
        if ($result) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $discount = $value->default_discount != null ? $value->default_discount : 0;
                $ipd_dis_inapplicable=DB::table('patn_patienttype')->where('patient_type_code',$patient_type)->value('ipd_discount_inapplicable');  
                 if ($admission_id !="" && $ipd_dis_inapplicable==1) {
                    $discount_pct=0;  
                 }else{
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_pk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                    $discount_pct=  $def_dis[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  $def_dis[0]->def_discount : 0;
                 }
                // dd( $def_dis, $value->disc_aplicable,$value->item_no_pk,$patient_type,$corporate_id, $sales_price,$discount);
                $ipd_charge = [];
                $ipd_charge_prc = 0;
                if ($admission_id != "") {
                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$value->item_no_pk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));
                    if ($ipd_charge[0]->ipd_charge_amt != null) {
                        $ipd_charge_prc = $value->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;
                      
                    }
                } else {
                    $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                }



                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => htmlspecialchars(ucfirst($value->item_name), ENT_QUOTES),
                    'purchase_price'    => $value->pr_uom_tradeprice,
                    'item_rate'         => $sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'uom_code'          => $value->uom_code,
                    'uom_label_desc'     => $value->uom_label_desc,
                    'pr_uom_name'          => $value->pr_uom_name,
                    'pr_uom_no_fk'         => $value->pr_uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => 'N/A', //$value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text'      => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'      => $value->pr_uom_conversion_qty,
                    'item_sales_uom' =>  $value->uom_no_fk,
                    'supplier_name' => $value->supplier_name,
                    'vat_percent' => $value->vat_percent,
                    'disc_aplicable' => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'default_discount' =>  $discount_pct,
                    'ipd_charge' =>  $ipd_charge_prc,
                    'generic_name' =>  $value->generic_name
                );
            }
        }
        // dd(   $def_dis, $patient_type ,$item_info );
        return $item_info;
    }




    // added by asif

    public static function getDiscountListAutoComplete($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "")
    {


        $keyword = strtoupper($keyword);

        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and serviceunit_no_fk = '$su_no_id'" : "";


        $result  = DB::table('SYSC_DISCOUNTPOLICY_VW')
            ->select('dispolicy_code', 'discount_name')
            ->whereRaw(DB::raw("(upper(dispolicy_code) like '%$keyword%' or upper(discount_name) like '%$keyword%')"))

            ->get();


        $policy_info = [];



        if ($result) {

            foreach ($result as $value) {


                $policy_info[] = array(
                    'discount_name'           => $value->discount_name,
                    'dispolicy_code'         => ucfirst($value->dispolicy_code)

                );
            }
        }

        return $policy_info;
    }



    public static function getpolicyListAutoComplete($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "")
    {


        $keyword = strtoupper($keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and serviceunit_no_fk = '$su_no_id'" : "";


        $result  = DB::table('sysc_referralpolicy_vw')
            ->select('policy_name', 'referralpolicy_code', 'referralpolicy_no_pk')
            ->whereRaw(DB::raw("(upper(policy_name) like '%$keyword%' or upper(referralpolicy_code) like '%$keyword%')"))

            ->get();

        $item_info = [];



        if ($result) {

            foreach ($result as $value) {

                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'policy_name'           => $value->policy_name,
                    'referralpolicy_code'   => $value->referralpolicy_code,
                    'referralpolicy_no_pk'  => $value->referralpolicy_no_pk,
                    // 'item_code'         =>$value->item_code,
                    // 'item_dept_id'      =>$value->serviceunit_no_fk,
                    // 'item_dept'         =>$value->serviceunit_name,
                    // 'item_type'         =>$value->itemtype_no_fk,
                    // 'itemtype_code'     =>$value->item_type,
                    // 'uom_name'          =>$value->uom_name,
                    // 'uom_no_fk'         =>$value->uom_no_fk,
                    // 'urgent_fee_amt'    =>$value->urgent_fee_amt
                );
            }
        }

        return $item_info;
    }


    // for Ewmch
    public static function getItemListWithStockAutoCompletePrescription($keyword, $itemtype = "", $thrpex_ind = 0, $ether_ind = 0, $itemtype_void = "", $su_no_id = "")
    {

        $keyword = strtoupper($keyword);
        $keyword = str_replace("'", "’", $keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        $hospital = Session::get('user.ses_hospital_no_pk');
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        if ($itemtype_void != "") {
            $item_type_void_arr = explode(",", $itemtype_void);
            foreach ($item_type_void_arr as $itype) {
                $item_type_void .= "'" . $itype . "',";
            }
            $itemtypevoid = rtrim($item_type_void, ", ");
        }

        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $item_type_void_cond = ($itemtype_void != "") ? " and s.item_type not in($itemtypevoid)" : "";
        $su_no_cond = ($su_no_id != "") ? " and s.serviceunit_no_fk = '$su_no_id'" : "";

        $hospital_code = Session::get('user.ses_hospital_code');

        $ckServiceunit = '';
        if($hospital_code == "UHL"){
            $ckServiceunit = "and SER.SERVICEUNIT_CODE = '38082'";
        }
       

        
        $result = DB::select(DB::raw("SELECT s.item_no_pk,
           s.item_name,
           s.purchase_price,
           s.sales_price,
           s.item_code,
           s.serviceunit_no_fk,
           s.serviceunit_name,
           s.itemtype_no_fk,
           s.item_type,
           s.uom_name,
           s.uom_no_fk,
           s.urgent_fee_amt,
           s.manual_item_rate_ind,
           s.expireable,
           l.current_stock,
           s.dealer_sales_price,
           s.default_discount,
           s.vat_percent,
           s.generic_name,
           s.supplier_name,
           CASE
              WHEN S.ITEM_NAME LIKE '%TAB%' THEN 1
              WHEN S.ITEM_NAME LIKE '%CAP%' THEN 2
              WHEN S.ITEM_NAME LIKE '%TAB%' THEN 1
              WHEN S.ITEM_NAME LIKE '%SYP%' THEN 3
              WHEN S.ITEM_NAME LIKE '%SUPPO%' THEN 4
              WHEN S.ITEM_NAME LIKE '%SUSP%' THEN 5
              WHEN S.ITEM_NAME LIKE '%SOL%' THEN 6
              WHEN S.ITEM_NAME LIKE '%PFS%' THEN 7
              WHEN S.ITEM_NAME LIKE '%OINT%' THEN 8
              WHEN S.ITEM_NAME LIKE '%P/D%' THEN 9
              WHEN S.ITEM_NAME LIKE '%E/D%' THEN 10
              WHEN S.ITEM_NAME LIKE '%NASAL SPRAY%' THEN 11
              WHEN S.ITEM_NAME LIKE '%INJ%' THEN 12
              ELSE 13
           END
              ordercloumn
            FROM SYSC_SERVICEITEM_VW s
           LEFT JOIN STOCKLEDGER_VW_ITEMWISE l
              ON S.ITEM_NO_PK = L.ITEM_NO_FK
           LEFT JOIN SYSC_SERVICEUNIT ser
              ON SER.SERVICEUNIT_NO_PK = L.STOCK_SU_NO_FK
            WHERE (   UPPER (s.item_name) LIKE '%$keyword%'
            OR UPPER (s.item_code) LIKE '%$keyword%'
            OR UPPER (s.generic_name) LIKE '%$keyword%')
           AND s.item_type IN ('MED')
           AND S.AU_ENTRY_HOSPITAL_PK_NO = $hospital
           AND l.current_stock > 0
           $ckServiceunit
            ORDER BY
            CASE
          WHEN l.current_stock IS NOT NULL AND l.current_stock <> 0 THEN 0
          ELSE 1
            END, l.current_stock DESC"));


        $item_info = [];

        if ($result) {

            foreach ($result as $value) {

                //echo $value->item_no_pk; exit;
                $mainStockStore=DB::table('inv_itemstockmst')->select('inv_itemstockmst.balance_qty','sysc_serviceunit.serviceunit_name')->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_itemstockmst.stock_su_no_fk')->where('inv_itemstockmst.item_no_fk',$value->item_no_pk)->where('sysc_serviceunit.main_store_ind',1)->where('inv_itemstockmst.balance_qty','>',0)->get()->toArray();
                // dd($mainStockStore);
                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'    => $value->purchase_price,
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      =>0,// $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' => $value->default_discount,
                    'vat_percent' => $value->vat_percent,
                    'generic_name' => $value->generic_name,
                    'supplier_name' => $value->supplier_name,
                    'all_main_stock' =>  $mainStockStore,
                );
            }
        }

        return $item_info;
    }

    public static function getItemListWithStockAutoCompletePrescriptionStoreWise($keyword, $itemtype = "", $su_no_id = "")
    {

        $keyword = strtoupper($keyword);
        $keyword = str_replace("'", "’", $keyword);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        $hospital = Session::get('user.ses_hospital_no_pk');
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }

        $su_no_cond = ($su_no_id != "") ? " and l.stock_su_no_fk = '$su_no_id'" : "";



        $result = DB::select(DB::raw("SELECT s.item_no_pk,
           s.item_name,
           s.purchase_price,
           s.sales_price,
           s.item_code,
           s.serviceunit_no_fk,
           s.serviceunit_name,
           s.itemtype_no_fk,
           s.item_type,
           s.uom_name,
           s.uom_no_fk,
           s.urgent_fee_amt,
           s.manual_item_rate_ind,
           s.expireable,
           l.current_stock,
           s.dealer_sales_price,
           s.default_discount,
           s.vat_percent,
           s.generic_name,
           s.supplier_name,
           CASE
              WHEN S.ITEM_NAME LIKE '%TAB%' THEN 1
              WHEN S.ITEM_NAME LIKE '%CAP%' THEN 2
              WHEN S.ITEM_NAME LIKE '%TAB%' THEN 1
              WHEN S.ITEM_NAME LIKE '%SYP%' THEN 3
              WHEN S.ITEM_NAME LIKE '%SUPPO%' THEN 4
              WHEN S.ITEM_NAME LIKE '%SUSP%' THEN 5
              WHEN S.ITEM_NAME LIKE '%SOL%' THEN 6
              WHEN S.ITEM_NAME LIKE '%PFS%' THEN 7
              WHEN S.ITEM_NAME LIKE '%OINT%' THEN 8
              WHEN S.ITEM_NAME LIKE '%P/D%' THEN 9
              WHEN S.ITEM_NAME LIKE '%E/D%' THEN 10
              WHEN S.ITEM_NAME LIKE '%NASAL SPRAY%' THEN 11
              WHEN S.ITEM_NAME LIKE '%INJ%' THEN 12
              ELSE 13
           END
              ordercloumn
            FROM SYSC_SERVICEITEM_VW s
           LEFT JOIN STOCKLEDGER_VW_ITEMWISE l
              ON S.ITEM_NO_PK = L.ITEM_NO_FK
           LEFT JOIN SYSC_SERVICEUNIT ser
              ON SER.SERVICEUNIT_NO_PK = L.STOCK_SU_NO_FK
            WHERE (   UPPER (s.item_name) LIKE '%$keyword%'
            OR UPPER (s.item_code) LIKE '%$keyword%'
            OR UPPER (s.generic_name) LIKE '%$keyword%')
           AND s.item_type IN ($itemtypes)
           AND S.AU_ENTRY_HOSPITAL_PK_NO = $hospital $su_no_cond
            ORDER BY
            CASE
          WHEN l.current_stock IS NOT NULL AND l.current_stock <> 0 THEN 0
          ELSE 1
            END, l.current_stock DESC"));


        $item_info = [];

        if ($result) {

            foreach ($result as $value) {
            $mainStockStore=DB::table('inv_itemstockmst')->select('inv_itemstockmst.balance_qty','sysc_serviceunit.serviceunit_name')->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_itemstockmst.stock_su_no_fk')->where('inv_itemstockmst.item_no_fk',$value->item_no_pk)->where('sysc_serviceunit.main_store_ind',1)->where('inv_itemstockmst.balance_qty','>',0)->get()->toArray();
                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'item_id'           => $value->item_no_pk,
                    'item_name'         => ucfirst($value->item_name),
                    'purchase_price'    => $value->purchase_price,
                    'item_rate'         => $value->sales_price,
                    'item_code'         => $value->item_code,
                    'item_dept_id'      => $value->serviceunit_no_fk,
                    'item_dept'         => $value->serviceunit_name,
                    'item_type'         => $value->itemtype_no_fk,
                    'itemtype_code'     => $value->item_type,
                    'uom_name'          => $value->uom_name,
                    'uom_no_fk'         => $value->uom_no_fk,
                    'urgent_fee_amt'    => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable'        => $value->expireable,
                    'current_stock'      => $value->current_stock,
                    'dealer_sales_price'      => $value->dealer_sales_price,
                    'stock_status_text' => ($value->current_stock > 0) ? "Sufficant" : "Not Available",
                    'default_discount' => $value->default_discount,
                    'vat_percent' => $value->vat_percent,
                    'generic_name' => $value->generic_name,
                    'supplier_name' => $value->supplier_name,
                     'all_main_stock' =>  $mainStockStore,
                );
            }
        }

        return $item_info;
    }
}
