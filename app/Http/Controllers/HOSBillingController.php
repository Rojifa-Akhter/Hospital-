<?php

namespace App\Http\Controllers;
use PDO;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Models\GrantUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DateTime;
class HOSBillingController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    use  LookupData, UtilitiesTrait;
public function hos_service_billing($id=""){
    $patientId = explode('-', $id);
    $bill_type=isset($patientId[2]) ? $patientId[2] :'';
    // dd($patientId);
    if (empty($id)) {
    $patient_info = [];
    $item_info = [];
    $ref_info = [];
    $item_type = "";
    $page_type = "";
    $service_id = "";
    $corporate_id ='';
    $prescription_id ='';
    $prescription_code ='';
    }elseif (!empty($id) && $patientId[2] == 'pres'){
        $getPressId = DB::table('psn_t_prescription_vw')          
        ->where('prescription_uid', $patientId[1])
        ->first();
        $corporate_id = !empty($getPressId->ccm_client_no_fk) ? $getPressId->ccm_client_no_fk : 0;
        // dd( $patientId[1], $getPressId, $corporate_id );
        $patient_info = [];
        $item_info = [];
        $ref_info = [];
        $item_type = "";
        $page_type = "";
        $service_id = "";
        // $corporate_id ='';
        $prescription_id =$patientId[0];
        $prescription_code =$patientId[1];
    }elseif (!empty($id) && $patientId[2] == 'app' || !empty($id) && $patientId[2] == 'PKG') {
        $page_type = $patientId[2];
        $service_id = '';
        $ref_info = [];
        $item_type = "fee";
        $prescription_id ='';
        $prescription_code ='';
        $patient_info = DB::table('patn_v1_appointment_vw app')   
                            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                            ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                            ->where('app.appoint_no_pk', $patientId[1])
                            ->first();

        $item_info_data = DB::table('patn_appointment_vw a')
                            ->leftJoin('doctor_wise_consult_fee_v1_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                            ->where('a.appoint_no_pk', $patientId[1])
                            ->where('b.doc_id', $patient_info->doctor_no_fk)
                            ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"),'b.default_discount_pct','b.item_code','b.itemtype_no_fk','b.vat_percent','b.ipd_urg_amt','b.ipd_urg_pct','b.urgent_fee_amt','b.urgent_fee_pct','b.serviceunit_no_fk','b.manual_item_rate_ind')
                            ->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable','b.default_discount_pct','b.item_code','b.itemtype_no_fk','b.vat_percent','b.ipd_urg_amt','b.ipd_urg_pct','b.urgent_fee_amt','b.urgent_fee_pct','b.serviceunit_no_fk','b.manual_item_rate_ind')
                            ->get()->toArray();
       
        $reg_item_data=[];
        if (!empty($item_info_data)  &&Session::get('user.ses_hospital_code')=="UNICO" && $patient_info->reg_card_fee_paid_ind == 0   && $patient_info->patient_type_code !="Unico Hospital-Staff" && $patientId[2] == 'app') {
           $reg_item =DB::table('sysc_serviceitem_vw')
           ->select('item_no_pk as item_no_fk', 'item_name', 'sales_price', 'serviceunit_name as su_name', 'item_type', 'disc_aplicable', 'sales_price as total_price','default_discount_pct','item_code','itemtype_no_fk','vat_percent','ipd_urg_amt','ipd_urg_pct','urgent_fee_amt','urgent_fee_pct','serviceunit_no_fk','manual_item_rate_ind')
           ->where('item_code','REGFEE')
           ->first();

            if ($reg_item) {
                $reg_item_data[] = (object) $reg_item;
            }
        }
        $item_info_data=array_merge($item_info_data,$reg_item_data);
        //  dd($reg_item_data, $item_info_data);
        $item_info = [];
        $item_info_arr = [];
        $corporate_id = !empty($patient_info->ccm_client_no_pk) ? $patient_info->ccm_client_no_pk : 0;
        $patient_type = !empty($patient_info->patient_type_code) ? $patient_info->patient_type_code : 0;
        $age_years = 0;
        if ($patient_type =="STAFFDEPENDENTCHILD") {
            $birth_date = $patient_info->patient_dob !='' ? date('Y-m-d',strtotime($patient_info->patient_dob)):'' ;
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
        if (!empty($item_info_data)) {

           

            foreach ($item_info_data as $item_row) {
                $sales_price =  !empty($item_row->sales_price) ? $item_row->sales_price : 0;
                $discount = 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                // $def_dis_amt = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'AMT') as def_discount from dual"));
                
                $item_info_arr[$item_row->item_no_fk] = [
                    'item_no_fk' => $item_row->item_no_fk,
                    'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                    'su_name' => $item_row->su_name,
                    'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                    'item_type' => $item_row->item_type,
                    'vat_percent' => 0,
                    'total_price' => $item_row->total_price,
                    "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                    "default_discount_amt" =>0,// $def_dis_amt[0]->def_discount ?? 0,
                    "default_discount_pct"=> $def_dis[0]->def_discount ?? 0, //$item_row->default_discount_pct,
                    "item_code"=>$item_row->item_code,
                    "itemtype_no_fk"=>$item_row->itemtype_no_fk,
                    "vat_percent"=>$item_row->vat_percent,
                    "ipd_urg_amt"=>$item_row->ipd_urg_amt,
                    "ipd_urg_pct"=>$item_row->ipd_urg_pct,
                    "urgent_fee_amt"=>$item_row->urgent_fee_amt,
                    "urgent_fee_pct"=>$item_row->urgent_fee_pct,
                    "serviceunit_no_fk"=>$item_row->serviceunit_no_fk,
                    "manual_item_rate_ind"=>$item_row->manual_item_rate_ind

                ];
            }
        }
        $item_info =   array_merge($item_info_arr);
    }elseif ($id != "" && ($patientId[2] == 'ipd' || $patientId[2] == 'OT')) {
    
        $page_type = $patientId[2];
        $service_id = '';
        $ref_info = [];
        $item_type = "fee";
        $prescription_id ='';
        $prescription_code ='';
        $patient_info = DB::table('ipd_admitted_patlist_vw a')
            ->select(
                // 'b.*','ptv.*','pt.*','corp.*','a.*'
                // ,'a.primary_doctor_no_fk as doctor_no_fk','a.primary_doctor_name as full_name'
                // 'b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk'
                'b.patient_no_pk',
                'ptv.maximum_percent',
                'ptv.item_level_disc_ind',
                'a.patient_photo',
                'pt.patient_type_code',
                'b.patient_code',
                'a.admission_no_pk',
                'b.patient_name',
                'b.gender_txt',
                'b.age',
                'a.mobile1 as phone_mobile',
                'corp.ccm_client_name',
                'corp.contact_person',
                'corp.contact_no',
                DB::raw("'' as applied_consult_ind"),
                'a.appointment_no_fk as appoint_no_pk',
                'b.payer_type_code',
                'a.patient_type',
                'corp.ccm_client_no_pk',
                // 'sponsor_no_fk',
                'a.primary_doctor_no_fk as doctor_no_fk',
                'a.primary_doctor_name as full_name'
                )
                  
            ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
            ->where('a.admission_no_pk', $patientId[1])
            ->first();
        // dd( $patient_info);
        $corporate_id = !empty($patient_info->ccm_client_no_pk) ? $patient_info->ccm_client_no_pk : 0;
        $patient_type = !empty($patient_info->patient_type_code) ? $patient_info->patient_type_code : 0;
        $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
        // dd($ref_info);
        $item_info = [];
        // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
        // dd($item_info);

    }
    // dd( $item_info );
    $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
    $reg_type = $this->getLookupListByCode("REGTYPE");

    $marital_status = $this->getLookupListByCode("MARSTS");
    $gender = $this->getLookupListByCode("GENDER");
    $bloodg = $this->getLookupListByCode("BLOODG");
    $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
    $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
    $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
    //$service_point = ServiceUnit::where('cash_counter_ind', '1')->where("status","1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
    $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
    $bank_name = $this->getLookupListByCode("AGENTBANKING");
    $mBanking = $this->getLookupListByCode("MBANKING");
    $sponsor=DB::table('ccm_corporateclient')->where('sponser_ind',1)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->where('status',1)->get();
    $source=DB::table('sysc_source')->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->where('status',1)->get();
    $deposit_type=$this->getLookupListByCode("DEPOSITTYPE");
    $card_type=$this->getLookupListByCode("CARDTYPE");
    $discountType=$this->getLookupListByCode("DISCOUNTTYPE");
    $pay_mode = ["CS" => "Cash"];

    $check = request('su');
    $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
    // dd($item_type);
    $item_type_list=[];
    if (!empty($item_type)) {
        foreach ($item_type as $key => $value) {
            $item_type_list[]=$value->workflow_code;
        }
    }
    $patient_type_data = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
    $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
    $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

    if (Session::get('user.ses_hospital_code')=="KPJ") {
        // billing_invoice_form_v4
        return Template::loadView("admin.uhl.billing.billing_invoice_form",[
                                'marital_status' => $marital_status,
                                'gender' => $gender,
                                'bloodg' => $bloodg,
                                'disctype' => $disctype,
                                'paymodes' => $paymodes,
                                'reg_type' => $reg_type,
                                'service_unit' => $service_unit,
                                'service_point' => $service_point,
                                'patientId' => $patient_info,
                                'check' => $check,
                                'item_info' => $item_info,
                                'item_type' => $item_type,
                                'page_type' => $page_type,
                                'service_id' => $service_id,
                                'bank_name' => $bank_name,
                                'mBanking' => $mBanking,
                                'ref_info' => $ref_info,
                                'po_hospital_details' => $po_hospital_details,
                                'sponsor' => $sponsor,
                                'source' => $source,
                                'deposit_type' => $deposit_type,
                                'item_type_lists' => $item_type_lists,
                                'patient_type_data' => $patient_type_data,
                                'corporate_info' => $corporate_info,
                                'corporate_id' => $corporate_id,
                                'prescription_id' => $prescription_id,
                                'prescription_code' => $prescription_code,
                                'bill_type' => $bill_type,
                                'card_type' => $card_type,
                                'discountType' => $discountType,
                            ]);
    }else{
         return Template::loadView("admin.uhl.billing.billing_invoice_form",[
                                'marital_status' => $marital_status,
                                'gender' => $gender,
                                'bloodg' => $bloodg,
                                'disctype' => $disctype,
                                'paymodes' => $paymodes,
                                'reg_type' => $reg_type,
                                'service_unit' => $service_unit,
                                'service_point' => $service_point,
                                'patientId' => $patient_info,
                                'check' => $check,
                                'item_info' => $item_info,
                                'item_type' => $item_type,
                                'page_type' => $page_type,
                                'service_id' => $service_id,
                                'bank_name' => $bank_name,
                                'mBanking' => $mBanking,
                                'ref_info' => $ref_info,
                                'po_hospital_details' => $po_hospital_details,
                                'sponsor' => $sponsor,
                                'source' => $source,
                                'deposit_type' => $deposit_type,
                                'item_type_lists' => $item_type_lists,
                                'patient_type_data' => $patient_type_data,
                                'corporate_info' => $corporate_info,
                                'corporate_id' => $corporate_id,
                                'prescription_id' => $prescription_id,
                                'prescription_code' => $prescription_code,
                                'bill_type' => $bill_type,
                                'card_type' => $card_type,
                                'discountType' => $discountType,
                            ]);
    }
   
}
public function hos_service_billing_v4($id=""){
    $patientId = explode('-', $id);
    $bill_type=isset($patientId[2]) ? $patientId[2] :'';
    // dd($patientId);
    if (empty($id)) {
    $patient_info = [];
    $item_info = [];
    $ref_info = [];
    $item_type = "";
    $page_type = "";
    $service_id = "";
    $corporate_id ='';
    $prescription_id ='';
    $prescription_code ='';
    }elseif (!empty($id) && $patientId[2] == 'pres'){
        $getPressId = DB::table('psn_t_prescription_vw')          
        ->where('prescription_uid', $patientId[1])
        ->first();
        $corporate_id = !empty($getPressId->ccm_client_no_fk) ? $getPressId->ccm_client_no_fk : 0;
        // dd( $patientId[1], $getPressId, $corporate_id );
        $patient_info = [];
        $item_info = [];
        $ref_info = [];
        $item_type = "";
        $page_type = "";
        $service_id = "";
        // $corporate_id ='';
        $prescription_id =$patientId[0];
        $prescription_code =$patientId[1];
    }elseif (!empty($id) && $patientId[2] == 'app' || !empty($id) && $patientId[2] == 'PKG') {
        $page_type = $patientId[2];
        $service_id = '';
        $ref_info = [];
        $item_type = "fee";
        $prescription_id ='';
        $prescription_code ='';
        $patient_info = DB::table('patn_v1_appointment_vw app')   
                            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                            ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                            ->where('app.appoint_no_pk', $patientId[1])
                            ->first();

        $item_info_data = DB::table('patn_appointment_vw a')
                            ->leftJoin('doctor_wise_consult_fee_v1_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                            ->where('a.appoint_no_pk', $patientId[1])
                            ->where('b.doc_id', $patient_info->doctor_no_fk)
                            ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"),'b.default_discount_pct','b.item_code','b.itemtype_no_fk','b.vat_percent','b.ipd_urg_amt','b.ipd_urg_pct','b.urgent_fee_amt','b.urgent_fee_pct','b.serviceunit_no_fk','b.manual_item_rate_ind')
                            ->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable','b.default_discount_pct','b.item_code','b.itemtype_no_fk','b.vat_percent','b.ipd_urg_amt','b.ipd_urg_pct','b.urgent_fee_amt','b.urgent_fee_pct','b.serviceunit_no_fk','b.manual_item_rate_ind')
                            ->get()->toArray();
       
        $reg_item_data=[];
        if (!empty($item_info_data)  &&Session::get('user.ses_hospital_code')=="UNICO" && $patient_info->reg_card_fee_paid_ind == 0   && $patient_info->patient_type_code !="Unico Hospital-Staff" && $patientId[2] == 'app') {
           $reg_item =DB::table('sysc_serviceitem_vw')
           ->select('item_no_pk as item_no_fk', 'item_name', 'sales_price', 'serviceunit_name as su_name', 'item_type', 'disc_aplicable', 'sales_price as total_price','default_discount_pct','item_code','itemtype_no_fk','vat_percent','ipd_urg_amt','ipd_urg_pct','urgent_fee_amt','urgent_fee_pct','serviceunit_no_fk','manual_item_rate_ind')
           ->where('item_code','REGFEE')
           ->first();

            if ($reg_item) {
                $reg_item_data[] = (object) $reg_item;
            }
        }
        $item_info_data=array_merge($item_info_data,$reg_item_data);
        //  dd($reg_item_data, $item_info_data);
        $item_info = [];
        $item_info_arr = [];
        $corporate_id = !empty($patient_info->ccm_client_no_pk) ? $patient_info->ccm_client_no_pk : 0;
        $patient_type = !empty($patient_info->patient_type_code) ? $patient_info->patient_type_code : 0;
        $age_years = 0;
        if ($patient_type =="STAFFDEPENDENTCHILD") {
            $birth_date = $patient_info->patient_dob !='' ? date('Y-m-d',strtotime($patient_info->patient_dob)):'' ;
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
        if (!empty($item_info_data)) {

           

            foreach ($item_info_data as $item_row) {
                $sales_price =  !empty($item_row->sales_price) ? $item_row->sales_price : 0;
                $discount = 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                // $def_dis_amt = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'AMT') as def_discount from dual"));
                
                $item_info_arr[$item_row->item_no_fk] = [
                    'item_no_fk' => $item_row->item_no_fk,
                    'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                    'su_name' => $item_row->su_name,
                    'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                    'item_type' => $item_row->item_type,
                    'vat_percent' => 0,
                    'total_price' => $item_row->total_price,
                    "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                    "default_discount_amt" =>0,// $def_dis_amt[0]->def_discount ?? 0,
                    "default_discount_pct"=> $def_dis[0]->def_discount ?? 0, //$item_row->default_discount_pct,
                    "item_code"=>$item_row->item_code,
                    "itemtype_no_fk"=>$item_row->itemtype_no_fk,
                    "vat_percent"=>$item_row->vat_percent,
                    "ipd_urg_amt"=>$item_row->ipd_urg_amt,
                    "ipd_urg_pct"=>$item_row->ipd_urg_pct,
                    "urgent_fee_amt"=>$item_row->urgent_fee_amt,
                    "urgent_fee_pct"=>$item_row->urgent_fee_pct,
                    "serviceunit_no_fk"=>$item_row->serviceunit_no_fk,
                    "manual_item_rate_ind"=>$item_row->manual_item_rate_ind

                ];
            }
        }
        $item_info =   array_merge($item_info_arr);
    }elseif ($id != "" && ($patientId[2] == 'ipd' || $patientId[2] == 'OT')) {
    
        $page_type = $patientId[2];
        $service_id = '';
        $ref_info = [];
        $item_type = "fee";
        $prescription_id ='';
        $prescription_code ='';
        $patient_info = DB::table('ipd_admitted_patlist_vw a')
            ->select(
                // 'b.*','ptv.*','pt.*','corp.*','a.*'
                // ,'a.primary_doctor_no_fk as doctor_no_fk','a.primary_doctor_name as full_name'
                // 'b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk'
                'b.patient_no_pk',
                'ptv.maximum_percent',
                'ptv.item_level_disc_ind',
                'a.patient_photo',
                'pt.patient_type_code',
                'b.patient_code',
                'a.admission_no_pk',
                'b.patient_name',
                'b.gender_txt',
                'b.age',
                'a.mobile1 as phone_mobile',
                'corp.ccm_client_name',
                'corp.contact_person',
                'corp.contact_no',
                DB::raw("'' as applied_consult_ind"),
                'a.appointment_no_fk as appoint_no_pk',
                'b.payer_type_code',
                'a.patient_type',
                'corp.ccm_client_no_pk',
                // 'sponsor_no_fk',
                'a.primary_doctor_no_fk as doctor_no_fk',
                'a.primary_doctor_name as full_name'
                )
                  
            ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
            ->where('a.admission_no_pk', $patientId[1])
            ->first();
        // dd( $patient_info);
        $corporate_id = !empty($patient_info->ccm_client_no_pk) ? $patient_info->ccm_client_no_pk : 0;
        $patient_type = !empty($patient_info->patient_type_code) ? $patient_info->patient_type_code : 0;
        $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
        // dd($ref_info);
        $item_info = [];
        // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
        // dd($item_info);

    }
    // dd( $item_info );
    $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
    $reg_type = $this->getLookupListByCode("REGTYPE");

    $marital_status = $this->getLookupListByCode("MARSTS");
    $gender = $this->getLookupListByCode("GENDER");
    $bloodg = $this->getLookupListByCode("BLOODG");
    $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
    $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
    $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
    //$service_point = ServiceUnit::where('cash_counter_ind', '1')->where("status","1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
    $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
    $bank_name = $this->getLookupListByCode("AGENTBANKING");
    $mBanking = $this->getLookupListByCode("MBANKING");
    $sponsor=DB::table('ccm_corporateclient')->where('sponser_ind',1)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->where('status',1)->get();
    $source=DB::table('sysc_source')->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->where('status',1)->get();
    $deposit_type=$this->getLookupListByCode("DEPOSITTYPE");
    $card_type=$this->getLookupListByCode("CARDTYPE");
    $discountType=$this->getLookupListByCode("DISCOUNTTYPE");
    $pay_mode = ["CS" => "Cash"];

    $check = request('su');
    $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
    // dd($item_type);
    $item_type_list=[];
    if (!empty($item_type)) {
        foreach ($item_type as $key => $value) {
            $item_type_list[]=$value->workflow_code;
        }
    }
    $patient_type_data = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
    $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
    $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

    if (Session::get('user.ses_hospital_code')=="KPJ") {
        return Template::loadView("admin.uhl.billing.billing_invoice_form_v4",[
                                'marital_status' => $marital_status,
                                'gender' => $gender,
                                'bloodg' => $bloodg,
                                'disctype' => $disctype,
                                'paymodes' => $paymodes,
                                'reg_type' => $reg_type,
                                'service_unit' => $service_unit,
                                'service_point' => $service_point,
                                'patientId' => $patient_info,
                                'check' => $check,
                                'item_info' => $item_info,
                                'item_type' => $item_type,
                                'page_type' => $page_type,
                                'service_id' => $service_id,
                                'bank_name' => $bank_name,
                                'mBanking' => $mBanking,
                                'ref_info' => $ref_info,
                                'po_hospital_details' => $po_hospital_details,
                                'sponsor' => $sponsor,
                                'source' => $source,
                                'deposit_type' => $deposit_type,
                                'item_type_lists' => $item_type_lists,
                                'patient_type_data' => $patient_type_data,
                                'corporate_info' => $corporate_info,
                                'corporate_id' => $corporate_id,
                                'prescription_id' => $prescription_id,
                                'prescription_code' => $prescription_code,
                                'bill_type' => $bill_type,
                                'card_type' => $card_type,
                                'discountType' => $discountType,
                            ]);
    }else{
         return Template::loadView("admin.uhl.billing.billing_invoice_form",[
                                'marital_status' => $marital_status,
                                'gender' => $gender,
                                'bloodg' => $bloodg,
                                'disctype' => $disctype,
                                'paymodes' => $paymodes,
                                'reg_type' => $reg_type,
                                'service_unit' => $service_unit,
                                'service_point' => $service_point,
                                'patientId' => $patient_info,
                                'check' => $check,
                                'item_info' => $item_info,
                                'item_type' => $item_type,
                                'page_type' => $page_type,
                                'service_id' => $service_id,
                                'bank_name' => $bank_name,
                                'mBanking' => $mBanking,
                                'ref_info' => $ref_info,
                                'po_hospital_details' => $po_hospital_details,
                                'sponsor' => $sponsor,
                                'source' => $source,
                                'deposit_type' => $deposit_type,
                                'item_type_lists' => $item_type_lists,
                                'patient_type_data' => $patient_type_data,
                                'corporate_info' => $corporate_info,
                                'corporate_id' => $corporate_id,
                                'prescription_id' => $prescription_id,
                                'prescription_code' => $prescription_code,
                                'bill_type' => $bill_type,
                                'card_type' => $card_type,
                                'discountType' => $discountType,
                            ]);
    }
   
}

public function getDepositAmt(Request $request){

$depo_type=$request->type;
$pat_id=$request->pat_id;
// dd($depo_type , $pat_id);

$pdo = DB::getPdo();
$out_deposite_amt = 0; $out_error='';
$deposit_amt=$pdo->prepare("begin pkg_v1_billing.prc_op_getdeposite(:in_patient_no_fk , :in_deposite_type, :out_deposite_amt,:out_error); end;");
$deposit_amt->bindParam(':in_patient_no_fk', $pat_id);
$deposit_amt->bindParam(':in_deposite_type', $depo_type);
$deposit_amt->bindParam(':out_deposite_amt', $out_deposite_amt, PDO::PARAM_INT);
$deposit_amt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
$deposit_amt->execute();
$depo_amt=$out_deposite_amt?? 0;
// dd($out_deposite_amt);
return response()->json($depo_amt);

}
public function provider_autocomplete(Request $request){

    $provider_deta=DB::table('employee_info_vw')->orWhere('full_name', 'like', '%' . $request->provider_name . '%')->get();
    $provider_deta_arr=[];
    foreach ($provider_deta as $key => $value) {
        $provider_deta_arr[]=array( 'name' => $value->full_name);
        // $provider_deta_arr[]= $value->person_no_pk;
    }
return response()->json($provider_deta_arr);

}



}
