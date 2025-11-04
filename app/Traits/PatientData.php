<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait PatientData
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
    public function getPatientAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $patient_infos = db::table("patient_info_vw pr")
            ->select(
                'pr.patient_no_pk',
                'pr.patient_code',
                'pr.salutation',
                'pr.patient_name',
                'pr.gender_txt',
                'pr.age',
                'pr.mobile1',
                'pr.patient_photo',
                'pt.patient_type_code',
                'ptv.maximum_percent',
                'ptv.patient_type_no_pk',
                'ptv.item_level_disc_ind',
                'corp.ccm_client_no_pk',
                'corp.ccm_client_name',
                'corp.ccm_client_code',
                'corp.contact_person',
                'corp.contact_mobile',
                DB::raw('pat_age(pr.dob,nvl(dod,sysdate))pat_age'),
                'pr.dob',
                'pr.age_yy',
                'pr.age_mm',
                'pr.age_dd',
                'pr.gender',
                'pr.email',
                "pr.spouse_name",
                "pr.nationality",
                "pr.mobile2",
                "pr.religion",
                "pr.present_district",
                "pr.permanent_district",
                "pr.emergency_contact_contact",
                "pr.pr_addr_thana",
                "pr.pr_addr_country",
                "pr.pe_addr_thana",
                "pr.pe_addr_country",
                "pr.permanent_post_code",
                "pr.payer_type_code",

            )
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pr.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pr.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pr.ccm_client_no_pk')
            ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("upper(pr.patient_code) like '%$keyword%' or upper(pr.patient_name) like '%$keyword%' or pr.mobile1 like '%$keyword%' "));
            
            // if (Session::get('user.ses_hospital_code')=="KPJ") {
            //    $patient_infos->orderByRaw('TO_NUMBER(pr.patient_code)');
            // }
            $patient_info=$patient_infos->get();

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                $patient_data[] =  array(
                    'patient_id'      => $patient->patient_no_pk,
                    'patient_code'    => $patient->patient_code,
                    'patient_name'    => $patient->patient_name,
                    'gender'          => $patient->gender_txt,
                    'gender_no_fk'          => $patient->gender,
                    'age'             => $patient->age,
                    'dob'             => isset($patient->dob) ? date('d-m-Y', strtotime($patient->dob)) : '',
                    'age_yy'             => $patient->age_yy,
                    'age_mm'             => $patient->age_mm,
                    'age_dd'             => $patient->age_dd,
                    'phone_mobile'    => $patient->mobile1,
                    'patient_photo'   => $patient->patient_photo,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'patient_no_pk'   => $patient->patient_no_pk,
                    'spouse_name'   => $patient->spouse_name,
                    'alt_phone_mobile'   => $patient->mobile2,
                    'email'   => $patient->email,
                    'nationality'   => $patient->nationality,
                    'religion'   => $patient->religion,
                    'present_district'   => $patient->present_district,
                    'permanent_district'   => $patient->permanent_district,
                    'emergency_contact_contact'   => $patient->emergency_contact_contact,
                    "pr_addr_thana" => $patient->pr_addr_thana,
                    "pr_addr_country" => $patient->pr_addr_country,
                    "pe_addr_thana" => $patient->pe_addr_thana,
                    "pe_addr_country" => $patient->pe_addr_country,
                    "permanent_post_code" => $patient->permanent_post_code,
                    "payer_type_code" => $patient->payer_type_code,
                    'pat_age'   => $patient->pat_age
                    // 'doctor_no_fk'   => $patient->doctor_no_fk,
                    // 'full_name'   => $patient->full_name,
                    // 'person_code'   => $patient->person_code,
                    // 'doc_phone'   => $patient->doc_phone,
                    // 'first_referral_no_fk'   => $patient->first_referral_no_fk,
                    // 'first_ref_code'   => $patient->first_ref_code,
                    // 'first_ref_name'   => $patient->first_ref_name,
                    // 'first_ref_phone_no'   => $patient->first_ref_phone_no,
                    // 'second_referral_no_fk'   => $patient->second_referral_no_fk,
                    // 'second_ref_code'   => $patient->second_ref_code,
                    // 'second_ref_name'   => $patient->second_ref_name,
                    // 'second_ref_phone_no'   => $patient->second_ref_phone_no,
                    // 'email'   => $patient->email,

                );
            }

            return $patient_data;
        }
    }
    public function getDonorAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $donor_info = db::table("bbd_donor")
            ->select(
                'donor_no_pk',
                'donor_name',
                'fatherorhousbend_name',
                'donor_dob',
                'donor_age',
                'donor_gender',
                'donor_mobile',
                'donor_address',              
                'donor_uid',              
                'donor_profession',              
                'marital_status',              

            )
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("upper(donor_uid) like '$keyword%' or donor_no_pk like '$keyword%' or upper(donor_name) like '$keyword%' or donor_mobile like '$keyword%' "))
            ->get();

        $donor_data = [];
        if (!empty($donor_info)) {
            foreach ($donor_info as $patient) {
                $donor_data[] =  array(
                    'donor_no_pk'            => $patient->donor_no_pk,
                    'donor_name'             => $patient->donor_name,
                    'fatherorhousbend_name'  => $patient->fatherorhousbend_name,
                    'donor_dob'              =>isset($patient->donor_dob) ?$patient->donor_dob : '',
                    'donor_age'              =>isset($patient->donor_age) ? $patient->donor_age : '',
                    'donor_gender'           => $patient->donor_gender,
                    'donor_mobile'           => $patient->donor_mobile,
                    'donor_address'          =>$patient->donor_address,                  
                    'donor_uid'              =>$patient->donor_uid,                  
                    'donor_profession'       =>$patient->donor_profession,                  
                    'marital_status'         =>$patient->marital_status,                  

                );
            }

            return $donor_data;
        }
    }
    public function getPatientIdAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $patient_info = db::table("patient_info_vw pr")
            ->select(
                // 'app.doctor_no_fk',
                // 'app.full_name',
                // 'app.person_code',
                // 'app.phone_mobile as doc_phone',
                // 'app.first_referral_no_fk',
                // 'app.first_ref_code',
                // 'app.first_ref_name',
                // 'app.first_ref_phone_no',
                // 'app.second_referral_no_fk',
                // 'app.second_ref_code',
                // 'app.second_ref_name',
                // 'app.second_ref_phone_no',
                'pr.patient_no_pk',
                'pr.patient_code',
                'pr.salutation',
                'pr.patient_name',
                'pr.gender_txt',
                'pr.age',
                'pr.mobile1',
                'pr.patient_photo',
                'pt.patient_type_code',
                'ptv.maximum_percent',
                'ptv.patient_type_no_pk',
                'ptv.item_level_disc_ind',
                'corp.ccm_client_no_pk',
                'corp.ccm_client_name',
                'corp.ccm_client_code',
                'corp.contact_person',
                'corp.contact_mobile',
                DB::raw('pat_age(pr.dob,nvl(dod,sysdate))pat_age'),
                'pr.dob',
                'pr.age_yy',
                'pr.age_mm',
                'pr.age_dd',
                'pr.gender',
                'pr.email',
                "pr.spouse_name",
                "pr.nationality",
                "pr.mobile2",
                "pr.religion",
                "pr.present_district",
                "pr.permanent_district",
                "pr.emergency_contact_contact",
                "pr.pr_addr_thana",
                "pr.pr_addr_country",
                "pr.pe_addr_thana",
                "pr.pe_addr_country",
                "pr.permanent_post_code",
                "pr.payer_type_code",

            )
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pr.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pr.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pr.ccm_client_no_pk')
            //->leftJoin('patn_appointment_vw app', 'app.patient_no_pk', '=', 'pr.patient_no_pk')
            ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("upper(pr.patient_code) = '$keyword'"))
            //->orderBy('appoint_no_pk', 'DESC')
            ->first();

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                $patient_data =  array(
                    'patient_id'      => $patient->patient_no_pk,
                    'patient_code'    => $patient->patient_code,
                    'patient_name'    => $patient->patient_name,
                    'gender'          => $patient->gender_txt,
                    'gender_no_fk'          => $patient->gender,
                    'age'             => $patient->age,
                    'dob'             => isset($patient->dob) ? date('d-m-Y', strtotime($patient->dob)) : '',
                    'age_yy'             => $patient->age_yy,
                    'age_mm'             => $patient->age_mm,
                    'age_dd'             => $patient->age_dd,
                    'phone_mobile'    => $patient->mobile1,
                    'patient_photo'   => $patient->patient_photo,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'patient_no_pk'   => $patient->patient_no_pk,
                    'spouse_name'   => $patient->spouse_name,
                    'alt_phone_mobile'   => $patient->mobile2,
                    'email'   => $patient->email,
                    'nationality'   => $patient->nationality,
                    'religion'   => $patient->religion,
                    'present_district'   => $patient->present_district,
                    'permanent_district'   => $patient->permanent_district,
                    'emergency_contact_contact'   => $patient->emergency_contact_contact,
                    "pr_addr_thana" => $patient->pr_addr_thana,
                    "pr_addr_country" => $patient->pr_addr_country,
                    "pe_addr_thana" => $patient->pe_addr_thana,
                    "pe_addr_country" => $patient->pe_addr_country,
                    "permanent_post_code" => $patient->permanent_post_code,
                    "payer_type_code" => $patient->payer_type_code,
                    'pat_age'   => $patient->pat_age
                    // 'doctor_no_fk'   => $patient->doctor_no_fk,
                    // 'full_name'   => $patient->full_name,
                    // 'person_code'   => $patient->person_code,
                    // 'doc_phone'   => $patient->doc_phone,
                    // 'first_referral_no_fk'   => $patient->first_referral_no_fk,
                    // 'first_ref_code'   => $patient->first_ref_code,
                    // 'first_ref_name'   => $patient->first_ref_name,
                    // 'first_ref_phone_no'   => $patient->first_ref_phone_no,
                    // 'second_referral_no_fk'   => $patient->second_referral_no_fk,
                    // 'second_ref_code'   => $patient->second_ref_code,
                    // 'second_ref_name'   => $patient->second_ref_name,
                    // 'second_ref_phone_no'   => $patient->second_ref_phone_no,
                    // 'email'   => $patient->email,

                );
            }


        }
        return response()->json( $patient_data);
    }

    public function getPatientAutocompleteBillList(Request $request)
    {

        $keyword = strtoupper($request->search_data);
        $patient_info_arr = db::table("patn_registration pr")
            ->select(
                
                'pr.patient_no_pk',
                'pr.patient_code',
                'pr.salutation',
                'pr.patient_name',
                'pr.gender_txt',
                'pr.age',
                'pr.mobile1',
                'pr.patient_photo',
                'pt.patient_type_code',
                'ptv.maximum_percent',
                'ptv.patient_type_no_pk',
                'ptv.item_level_disc_ind',
                'corp.ccm_client_no_pk',
                'corp.ccm_client_name',
                'corp.ccm_client_code',
                'corp.contact_person',
                'corp.contact_mobile',
                DB::raw('pat_age(pr.dob,nvl(dod,sysdate))pat_age'),
                'pr.dob',
                'pr.age_yy',
                'pr.age_mm',
                'pr.age_dd',
                'pr.gender',
                'pr.email',
                'pr.present_addr',
            )
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pr.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pr.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pr.ccm_client_no_fk');
            // ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
          
            if ( in_array( Session::get('user.ses_hospital_code'),['IMPERIAL', 'IMPALA','AMCSH','JKMH','SSG','DMHL','RLHL'])) {
                $patient_info=$patient_info_arr->whereRaw(DB::raw("upper(pr.patient_code) like '%$keyword%' or upper(pr.patient_name) like '%$keyword%' or pr.mobile1 like '%$keyword%' "));
            }else{
                $patient_info=$patient_info_arr->whereRaw(DB::raw("pr.mobile1 like '%$keyword%' "));
            }

           $patient_info = $patient_info_arr
            ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

            // ->whereRaw(DB::raw("upper(pr.patient_code) like '%$keyword%' or upper(pr.patient_name) like '%$keyword%' or pr.mobile1 like '%$keyword%' "))
            // ->orderBy('appoint_no_pk', 'DESC')

        // dd($patient_info);

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                if ( in_array( Session::get('user.ses_hospital_code'),['JKMH'])) {
                $app_data = DB::table('patn_appointment_vw')->select('doctor_no_fk','full_name','person_code','phone_mobile','first_referral_no_fk','first_ref_code','first_ref_name','first_ref_phone_no','second_referral_no_fk','second_ref_code','second_ref_name','second_ref_phone_no')->where('patient_no_pk',$patient->patient_no_pk)->orderBy('appoint_no_pk','desc')->first();
                }else{
                    $app_data =[];
                }
                // dd($app_data);
                $patient_data[] =  array(
                    'patient_id'      => $patient->patient_no_pk,
                    'patient_code'    => $patient->patient_code,
                    'patient_name'    => $patient->patient_name,
                    'gender'          => $patient->gender_txt,
                    'gender_no_fk'          => $patient->gender,
                    'age'             => $patient->age,
                    'dob'             => isset($patient->dob) ? date('d-m-Y', strtotime($patient->dob)) : '',
                    'age_yy'             => $patient->age_yy,
                    'age_mm'             => $patient->age_mm,
                    'age_dd'             => $patient->age_dd,
                    'phone_mobile'    => $patient->mobile1,
                    'patient_photo'   => $patient->patient_photo,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'patient_no_pk'   => $patient->patient_no_pk,

                    'doctor_no_fk'   => !empty($app_data) ? $app_data->doctor_no_fk : null,
                    'full_name'   => !empty($app_data) ? $app_data->full_name : null,
                    'person_code'   => !empty($app_data) ? $app_data->person_code : null, //$patient->person_code,
                    'doc_phone'   => !empty($app_data) ? $app_data->phone_mobile : null, //$patient->doc_phone,
                    'first_referral_no_fk'   => !empty($app_data) ? $app_data->first_referral_no_fk : null, //$patient->first_referral_no_fk,
                    'first_ref_code'   => !empty($app_data) ? $app_data->first_ref_code : null, //$patient->first_ref_code,
                    'first_ref_name'   => !empty($app_data) ? $app_data->first_ref_name : null, //$patient->first_ref_name,
                    'first_ref_phone_no'   => !empty($app_data) ? $app_data->first_ref_phone_no : null, //$patient->first_ref_phone_no,
                    'second_referral_no_fk'   => !empty($app_data) ? $app_data->second_referral_no_fk : null, //$patient->second_referral_no_fk,
                    'second_ref_code'   => !empty($app_data) ? $app_data->second_ref_code : null, //$patient->second_ref_code,
                    'second_ref_name'   => !empty($app_data) ? $app_data->second_ref_name : null, //$patient->second_ref_name,
                    'second_ref_phone_no'   => !empty($app_data) ? $app_data->second_ref_phone_no : null, //$patient->second_ref_phone_no,
                    'email'   => $patient->email,
                    'present_addr'   => $patient->present_addr,
                    'pat_age'   => $patient->pat_age,

                );
            }
            // dd($patient_data);
            return $patient_data;
        }
    }
    public function getPatientIdAutocompleteBillList(Request $request)
    {

        $keyword = strtoupper($request->search_data);
        $patient_infos = db::table("patn_registration pr")
            ->select(

                'pr.patient_no_pk',
                'pr.patient_code',
                'pr.salutation',
                'pr.patient_name',
                'pr.gender_txt',
                'pr.age',
                'pr.mobile1',
                'pr.patient_photo',
                'pt.patient_type_code',
                'ptv.maximum_percent',
                'ptv.patient_type_no_pk',
                'ptv.item_level_disc_ind',
                'corp.ccm_client_no_pk',
                'corp.ccm_client_name',
                'corp.ccm_client_code',
                'corp.contact_person',
                'corp.contact_mobile',
                DB::raw('pat_age(pr.dob,nvl(dod,sysdate))pat_age'),
                'pr.dob',
                'pr.age_yy',
                'pr.age_mm',
                'pr.age_dd',
                'pr.gender',
                'pr.email',
                'pr.present_addr',
            )
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pr.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pr.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pr.ccm_client_no_fk')
            ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("upper(pr.patient_code) = '$keyword' "));
            // ->whereRaw(DB::raw("upper(pr.patient_code) like '%$keyword%' or upper(pr.patient_name) like '%$keyword%' or pr.mobile1 like '%$keyword%' "))
            // ->orderBy('appoint_no_pk', 'DESC')
            if (in_array(Session::get('user.ses_hospital_code'),["GMC"])) {
                $patient_infos->leftJoin('patn_appointment_vw app', 'app.patient_no_pk', '=', 'pr.patient_no_pk');
                $patient_infos->addSelect([ 'app.doctor_no_fk','app.full_name','app.person_code','app.phone_mobile as doc_phone','app.first_referral_no_fk','app.first_ref_code','app.first_ref_name','app.first_ref_phone_no','app.second_referral_no_fk','app.second_ref_code','app.second_ref_name','app.second_ref_phone_no']);
            }

            $patient_info = $patient_infos->first();
        // dd($patient_info);

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                $app_data = [];
                if (in_array(Session::get('user.ses_hospital_code'),["GMC"])) {
                    $app_data = DB::table('patn_appointment_vw')->select('doctor_no_fk','full_name','person_code','phone_mobile','first_referral_no_fk','first_ref_code','first_ref_name','first_ref_phone_no','second_referral_no_fk','second_ref_code','second_ref_name','second_ref_phone_no')->where('patient_no_pk',$patient->patient_no_pk)->orderBy('appoint_no_pk','desc')->first();
                }
                // dd($app_data);
                $patient_data =  array(
                    'patient_id'      => $patient->patient_no_pk,
                    'patient_code'    => $patient->patient_code,
                    'patient_name'    => $patient->patient_name,
                    'gender'          => $patient->gender_txt,
                    'gender_no_fk'          => $patient->gender,
                    'age'             => $patient->age,
                    'dob'             => isset($patient->dob) ? date('d-m-Y', strtotime($patient->dob)) : '',
                    'age_yy'             => $patient->age_yy,
                    'age_mm'             => $patient->age_mm,
                    'age_dd'             => $patient->age_dd,
                    'phone_mobile'    => $patient->mobile1,
                    'patient_photo'   => $patient->patient_photo,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'patient_no_pk'   => $patient->patient_no_pk,

                    'doctor_no_fk'   => !empty($app_data) ? $app_data->doctor_no_fk : null,
                    'full_name'   => !empty($app_data) ? $app_data->full_name : null,
                    'person_code'   => !empty($app_data) ? $app_data->person_code : null, //$patient->person_code,
                    'doc_phone'   => !empty($app_data) ? $app_data->phone_mobile : null, //$patient->doc_phone,
                    'first_referral_no_fk'   => !empty($app_data) ? $app_data->first_referral_no_fk : null, //$patient->first_referral_no_fk,
                    'first_ref_code'   => !empty($app_data) ? $app_data->first_ref_code : null, //$patient->first_ref_code,
                    'first_ref_name'   => !empty($app_data) ? $app_data->first_ref_name : null, //$patient->first_ref_name,
                    'first_ref_phone_no'   => !empty($app_data) ? $app_data->first_ref_phone_no : null, //$patient->first_ref_phone_no,
                    'second_referral_no_fk'   => !empty($app_data) ? $app_data->second_referral_no_fk : null, //$patient->second_referral_no_fk,
                    'second_ref_code'   => !empty($app_data) ? $app_data->second_ref_code : null, //$patient->second_ref_code,
                    'second_ref_name'   => !empty($app_data) ? $app_data->second_ref_name : null, //$patient->second_ref_name,
                    'second_ref_phone_no'   => !empty($app_data) ? $app_data->second_ref_phone_no : null, //$patient->second_ref_phone_no,
                    'email'   => $patient->email,
                    'present_addr'   => $patient->present_addr,
                    'pat_age'   => $patient->pat_age,

                );
            }

        }
        // dd($patient_data);
        return response()->json( $patient_data);
    }
    public function getAppointmnetPatientAutocompleteBillList(Request $request)
    {

        $keyword = strtoupper($request->search_data);
        $patient_info = db::table("patn_appointment_vw app")
            ->select(
                'app.patient_no_pk',
                'app.appoint_no_pk',
                'app.doctor_no_fk',
                'app.full_name',
                'app.person_code',
                'app.phone_mobile as doc_phone',
                'app.first_referral_no_fk',
                'app.first_ref_code',
                'app.first_ref_name',
                'app.first_ref_phone_no',
                'app.second_referral_no_fk',
                'app.second_ref_code',
                'app.second_ref_name',
                'app.second_ref_phone_no',
                // 'pr.patient_no_pk',
                'pr.patient_code',
                'pr.salutation',
                'pr.patient_name',
                'pr.gender_txt',
                'pr.age',
                'pr.mobile1',
                'pr.patient_photo',
                'pt.patient_type_code',
                'ptv.maximum_percent',
                'ptv.patient_type_no_pk',
                'ptv.item_level_disc_ind',
                'corp.ccm_client_no_pk',
                'corp.ccm_client_name',
                'corp.ccm_client_code',
                'corp.contact_person',
                'corp.contact_mobile',
                DB::raw('pat_age(pr.dob,nvl(dod,sysdate))pat_age'),
                'pr.dob',
                'pr.age_yy',
                'pr.age_mm',
                'pr.age_dd',
                'pr.gender',
                'pr.email',
                'pr.present_addr',
            )
            ->join('patn_registration pr', 'app.patient_no_pk', '=', 'pr.patient_no_pk')
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'pr.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'pr.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pr.ccm_client_no_fk')
            ->where('pr.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->whereRaw(DB::raw("upper(app.appoint_no_pk) = $keyword"))
            ->whereRaw(DB::raw("upper(app.appoint_code) = '$keyword'"))
            // ->whereRaw(DB::raw("upper(app.appoint_no_pk) like '%$keyword%'"))
            ->orderBy('app.appoint_no_pk', 'DESC')
            ->first();
        // dd(($patient_info));

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                // $app_data=DB::table('patn_appointment_vw')->select('doctor_no_fk','full_name','person_code','phone_mobile','first_referral_no_fk','first_ref_code','first_ref_name','first_ref_phone_no','second_referral_no_fk','second_ref_code','second_ref_name','second_ref_phone_no')->where('patient_no_pk',$patient->patient_no_pk)->orderBy('appoint_no_pk','desc')->first();
                // dd($app_data);
                $patient_data =  array(
                    'patient_id'      => $patient->patient_no_pk,
                    'patient_code'    => $patient->patient_code,
                    'patient_name'    => $patient->patient_name,
                    'gender'          => $patient->gender_txt,
                    'gender_no_fk'          => $patient->gender,
                    'age'             => $patient->age,
                    'dob'             => isset($patient->dob) ? date('d-m-Y', strtotime($patient->dob)) : '',
                    'age_yy'             => $patient->age_yy,
                    'age_mm'             => $patient->age_mm,
                    'age_dd'             => $patient->age_dd,
                    'phone_mobile'    => $patient->mobile1,
                    'patient_photo'   => $patient->patient_photo,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'patient_no_pk'   => $patient->patient_no_pk,
                    'appoint_no_pk'   => $patient->appoint_no_pk,
                    'doctor_no_fk'   => $patient->doctor_no_fk,
                    'full_name'   => $patient->full_name,
                    'person_code'   => $patient->person_code,
                    'doc_phone'   => $patient->doc_phone,
                    'first_referral_no_fk'   => $patient->first_referral_no_fk,
                    'first_ref_code'   => $patient->first_ref_code,
                    'first_ref_name'   => $patient->first_ref_name,
                    'first_ref_phone_no'   => $patient->first_ref_phone_no,
                    'second_referral_no_fk'   => $patient->second_referral_no_fk,
                    'second_ref_code'   => $patient->second_ref_code,
                    'second_ref_name'   => $patient->second_ref_name,
                    'second_ref_phone_no'   => $patient->second_ref_phone_no,
                    'email'   => $patient->email,
                    'present_addr'   => $patient->present_addr,
                    'pat_age'   => $patient->pat_age,

                );
            }
            // dd($patient_data);

        }
        return $patient_data;
    }

    public function getAdmissionAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $patient_info = db::table("ipd_admitted_patlist_vw")
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "ipd_admitted_patlist_vw.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'ipd_admitted_patlist_vw.admission_no_pk', 'ipd_admitted_patlist_vw.admission_uid', 'ipd_admitted_patlist_vw.admission_date', 'ipd_admitted_patlist_vw.bed_name', 'ipd_admitted_patlist_vw.ward_name', 'ipd_admitted_patlist_vw.primary_doctor_name', 'ipd_admitted_patlist_vw.ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.first_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.second_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.refrral_doctor_name', 'ipd_admitted_patlist_vw.first_ref_doctor_name', 'ipd_admitted_patlist_vw.second_ref_doctor_name', 'ipd_admitted_patlist_vw.primary_doctor_code', 'ipd_admitted_patlist_vw.ref_doc_person_code', 'ipd_admitted_patlist_vw.first_ref_doc_person_code', 'ipd_admitted_patlist_vw.second_ref_doc_person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'ipd_admitted_patlist_vw.primary_doctor_no_fk', 'pat_registration_wl_vw.payer_type_code', 'ipd_admitted_patlist_vw.lock_ind')
            ->where('ipd_admitted_patlist_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->whereRaw(DB::raw("upper(ipd_admitted_patlist_vw.admission_no_pk) like '%$keyword%' and nvl(dis_ind,0)=0     "))
            ->whereRaw(DB::raw("upper(ipd_admitted_patlist_vw.admission_no_pk) = $keyword"))
            ->first();

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                $patient_data[] =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'admission_no_pk'   => $patient->admission_no_pk,
                    'admission_uid'     => $patient->admission_uid,
                    'admission_date'    => $patient->admission_date,
                    'bed_name'          => $patient->bed_name,
                    'ward_name'         => $patient->ward_name,
                    'primary_doctor_name'        => $patient->primary_doctor_name,
                    'ref_doc_person_no_fk'       => $patient->ref_doc_person_no_fk,
                    'first_ref_doc_person_no_fk' => $patient->first_ref_doc_person_no_fk,
                    'second_ref_doc_person_no_fk' => $patient->second_ref_doc_person_no_fk,
                    'refrral_doctor_name'        => $patient->refrral_doctor_name,
                    'first_ref_doctor_name'      => $patient->first_ref_doctor_name,
                    'second_ref_doctor_name'     => $patient->second_ref_doctor_name,
                    'primary_doctor_code'     => $patient->primary_doctor_code,
                    'ref_doc_person_code'     => $patient->ref_doc_person_code,
                    'first_ref_doc_person_code'     => $patient->first_ref_doc_person_code,
                    'second_ref_doc_person_code'     => $patient->second_ref_doc_person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'primary_doctor_no_fk'   => $patient->primary_doctor_no_fk,
                    'payer_type_code'   => $patient->payer_type_code,
                    'lock_ind'   => $patient->lock_ind,
                );
            }
            // dd( $patient_data);
            return $patient_data;
        }
    }
    public function getAdmissionGetData(Request $request)
    {
        // dd(5);
        $keyword = $request->search_data;
        $patient_info = db::table("ipd_admitted_patlist_vw")
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "ipd_admitted_patlist_vw.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'ipd_admitted_patlist_vw.admission_no_pk', 'ipd_admitted_patlist_vw.admission_uid', 'ipd_admitted_patlist_vw.admission_date', 'ipd_admitted_patlist_vw.bed_name', 'ipd_admitted_patlist_vw.ward_name', 'ipd_admitted_patlist_vw.primary_doctor_name', 'ipd_admitted_patlist_vw.ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.first_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.second_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.refrral_doctor_name', 'ipd_admitted_patlist_vw.first_ref_doctor_name', 'ipd_admitted_patlist_vw.second_ref_doctor_name', 'ipd_admitted_patlist_vw.primary_doctor_code', 'ipd_admitted_patlist_vw.ref_doc_person_code', 'ipd_admitted_patlist_vw.first_ref_doc_person_code', 'ipd_admitted_patlist_vw.second_ref_doc_person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'ipd_admitted_patlist_vw.primary_doctor_no_fk', 'pat_registration_wl_vw.payer_type_code','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipd_admitted_patlist_vw.new_su_name','ipd_admitted_patlist_vw.dis_ind', 'ipd_admitted_patlist_vw.lock_ind')
            ->where('ipd_admitted_patlist_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->whereRaw(DB::raw("upper(ipd_admitted_patlist_vw.admission_no_pk) like '%$keyword%' and nvl(dis_ind,0)=0     "))
            ->where("ipd_admitted_patlist_vw.admission_no_pk", $keyword)
            ->first();
        //   dd( $patient_info);
        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                $patient_data =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'admission_no_pk'   => $patient->admission_no_pk,
                    'admission_uid'     => $patient->admission_uid,
                    'admission_date'    => $patient->admission_date,
                    'bed_name'          => $patient->bed_name,
                    'ward_name'         => $patient->ward_name,
                    'primary_doctor_name'        => $patient->primary_doctor_name,
                    'ref_doc_person_no_fk'       => $patient->ref_doc_person_no_fk,
                    'first_ref_doc_person_no_fk' => $patient->first_ref_doc_person_no_fk,
                    'second_ref_doc_person_no_fk' => $patient->second_ref_doc_person_no_fk,
                    'refrral_doctor_name'        => $patient->refrral_doctor_name,
                    'first_ref_doctor_name'      => $patient->first_ref_doctor_name,
                    'second_ref_doctor_name'     => $patient->second_ref_doctor_name,
                    'primary_doctor_code'     => $patient->primary_doctor_code,
                    'ref_doc_person_code'     => $patient->ref_doc_person_code,
                    'first_ref_doc_person_code'     => $patient->first_ref_doc_person_code,
                    'second_ref_doc_person_code'     => $patient->second_ref_doc_person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'primary_doctor_no_fk'   => $patient->primary_doctor_no_fk,
                    'payer_type_code'   => $patient->payer_type_code,
                    'new_bed_name'   => $patient->new_bed_name,
                    'new_ward_name'   => $patient->new_ward_name,
                    'new_su_name'   => $patient->new_su_name,
                    'dis_ind'   => $patient->dis_ind,
                    'lock_ind'   => $patient->lock_ind,
                );
            }
            // dd( $patient_data);

        }
        return $patient_data;
    }
    public function getAdmissionGetDataByBed(Request $request)
    {
        // dd(5);
        $keyword = $request->search_data;
        $patient_info = db::table("ipd_admitted_patlist_vw")
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "ipd_admitted_patlist_vw.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'ipd_admitted_patlist_vw.admission_no_pk', 'ipd_admitted_patlist_vw.admission_uid', 'ipd_admitted_patlist_vw.admission_date', 'ipd_admitted_patlist_vw.bed_name', 'ipd_admitted_patlist_vw.ward_name', 'ipd_admitted_patlist_vw.primary_doctor_name', 'ipd_admitted_patlist_vw.ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.first_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.second_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.refrral_doctor_name', 'ipd_admitted_patlist_vw.first_ref_doctor_name', 'ipd_admitted_patlist_vw.second_ref_doctor_name', 'ipd_admitted_patlist_vw.primary_doctor_code', 'ipd_admitted_patlist_vw.ref_doc_person_code', 'ipd_admitted_patlist_vw.first_ref_doc_person_code', 'ipd_admitted_patlist_vw.second_ref_doc_person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'ipd_admitted_patlist_vw.primary_doctor_no_fk', 'pat_registration_wl_vw.payer_type_code','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipd_admitted_patlist_vw.new_su_name','ipd_admitted_patlist_vw.dis_ind')
            ->where('ipd_admitted_patlist_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->whereRaw(DB::raw("upper(ipd_admitted_patlist_vw.admission_no_pk) like '%$keyword%' and nvl(dis_ind,0)=0     "))
            ->where("ipd_admitted_patlist_vw.new_bed_name", $keyword)
            ->where("ipd_admitted_patlist_vw.dis_req_ind", 0)
            ->where("ipd_admitted_patlist_vw.dis_ind", 0)
            ->first();
        //   dd( $patient_info);
        $patient_data = [];
        if (!empty($patient_info)) {
            foreach (array($patient_info) as $patient) {
                $patient_data =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'admission_no_pk'   => $patient->admission_no_pk,
                    'admission_uid'     => $patient->admission_uid,
                    'admission_date'    => $patient->admission_date,
                    'bed_name'          => $patient->bed_name,
                    'ward_name'         => $patient->ward_name,
                    'primary_doctor_name'        => $patient->primary_doctor_name,
                    'ref_doc_person_no_fk'       => $patient->ref_doc_person_no_fk,
                    'first_ref_doc_person_no_fk' => $patient->first_ref_doc_person_no_fk,
                    'second_ref_doc_person_no_fk' => $patient->second_ref_doc_person_no_fk,
                    'refrral_doctor_name'        => $patient->refrral_doctor_name,
                    'first_ref_doctor_name'      => $patient->first_ref_doctor_name,
                    'second_ref_doctor_name'     => $patient->second_ref_doctor_name,
                    'primary_doctor_code'     => $patient->primary_doctor_code,
                    'ref_doc_person_code'     => $patient->ref_doc_person_code,
                    'first_ref_doc_person_code'     => $patient->first_ref_doc_person_code,
                    'second_ref_doc_person_code'     => $patient->second_ref_doc_person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'primary_doctor_no_fk'   => $patient->primary_doctor_no_fk,
                    'payer_type_code'   => $patient->payer_type_code,
                    'new_bed_name'   => $patient->new_bed_name,
                    'new_ward_name'   => $patient->new_ward_name,
                    'new_su_name'   => $patient->new_su_name,
                    'dis_ind'   => $patient->dis_ind,
                );
            }
            // dd( $patient_data);

        }
        return $patient_data;
    }
    public function getPrescriptionAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
      
        $patient_info =  db::table("psn_t_prescription_vw")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'psn_t_prescription_vw.patient_type')
            ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'psn_t_prescription_vw.patient_type')
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "psn_t_prescription_vw.patient_no_fk")
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.present_addr', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'psn_t_prescription_vw.prescription_no_pk', 'psn_t_prescription_vw.prescription_uid', 'psn_t_prescription_vw.prescription_date', 'psn_t_prescription_vw.first_referral_no_fk', 'psn_t_prescription_vw.second_referral_no_fk', 'psn_t_prescription_vw.first_ref_person_code', 'psn_t_prescription_vw.first_ref_doc_name', 'psn_t_prescription_vw.sec_ref_person_code', 'psn_t_prescription_vw.sec_ref_doc_name', 'psn_t_prescription_vw.doctor_person_no_fk', 'psn_t_prescription_vw.doctor_name', 'psn_t_prescription_vw.person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'psn_t_prescription_vw.admission_no_fk', 'pat_registration_wl_vw.payer_type_code','pat_registration_wl_vw.dob')
            ->where('psn_t_prescription_vw.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->where("psn_t_prescription_vw.prescription_uid" ,"=", $keyword )->get();
            // ->whereRaw(DB::raw("upper(psn_t_prescription_vw.prescription_uid) = $keyword "))->first();


        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                $patient_data[] =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'dob'               => $patient->dob,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'prescription_no_pk'   => $patient->prescription_no_pk,
                    'prescription_uid'     => $patient->prescription_uid,
                    'first_referral_no_fk'    => $patient->first_referral_no_fk,
                    'second_referral_no_fk'    => $patient->second_referral_no_fk,
                    'first_ref_person_code'    => $patient->first_ref_person_code,
                    'first_ref_doc_name'    => $patient->first_ref_doc_name,
                    'sec_ref_person_code'   => $patient->sec_ref_person_code,
                    'sec_ref_doc_name'      => $patient->sec_ref_doc_name,
                    'prescription_date'    => $patient->prescription_date,
                    // 'bed_name'          => $patient->bed_name,
                    // 'ward_name'         => $patient->ward_name,
                    'doctor_person_no_fk'  => $patient->doctor_person_no_fk,
                    'doctor_name'         => $patient->doctor_name,
                    'person_code'         => $patient->person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'admission_no_fk'   => $patient->admission_no_fk,
                    'present_addr'   => $patient->present_addr,
                    'payer_type_code'   => $patient->payer_type_code,
                );
            }
           
            return $patient_data;
        }
    }
    public function getPrescriptionGetData(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $patient_info =  db::table("psn_t_prescription_vw")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'psn_t_prescription_vw.patient_type')
            ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'psn_t_prescription_vw.patient_type')
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "psn_t_prescription_vw.patient_no_fk")
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.present_addr', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'psn_t_prescription_vw.prescription_no_pk', 'psn_t_prescription_vw.prescription_uid', 'psn_t_prescription_vw.prescription_date', 'psn_t_prescription_vw.first_referral_no_fk', 'psn_t_prescription_vw.second_referral_no_fk', 'psn_t_prescription_vw.first_ref_person_code', 'psn_t_prescription_vw.first_ref_doc_name', 'psn_t_prescription_vw.sec_ref_person_code', 'psn_t_prescription_vw.sec_ref_doc_name', 'psn_t_prescription_vw.doctor_person_no_fk', 'psn_t_prescription_vw.doctor_name', 'psn_t_prescription_vw.person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'psn_t_prescription_vw.admission_no_fk', 'pat_registration_wl_vw.payer_type_code')
            ->where('psn_t_prescription_vw.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->where("psn_t_prescription_vw.prescription_uid" ,"=", $keyword )->get();
            // ->whereRaw(DB::raw("upper(psn_t_prescription_vw.prescription_uid) = $keyword "))->first();


        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                $patient_data =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'prescription_no_pk'   => $patient->prescription_no_pk,
                    'prescription_uid'     => $patient->prescription_uid,
                    'first_referral_no_fk'    => $patient->first_referral_no_fk,
                    'second_referral_no_fk'    => $patient->second_referral_no_fk,
                    'first_ref_person_code'    => $patient->first_ref_person_code,
                    'first_ref_doc_name'    => $patient->first_ref_doc_name,
                    'sec_ref_person_code'   => $patient->sec_ref_person_code,
                    'sec_ref_doc_name'      => $patient->sec_ref_doc_name,
                    'prescription_date'    => $patient->prescription_date,
                    // 'bed_name'          => $patient->bed_name,
                    // 'ward_name'         => $patient->ward_name,
                    'doctor_person_no_fk'  => $patient->doctor_person_no_fk,
                    'doctor_name'         => $patient->doctor_name,
                    'person_code'         => $patient->person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'admission_no_fk'   => $patient->admission_no_fk,
                    'present_addr'   => $patient->present_addr,
                    'payer_type_code'   => $patient->payer_type_code,
                );
            }

        }
        return $patient_data;
    }


    // added by Nazmul

    //    public static function getCashierListAutoComplete($keyword, $itemtype = "", $thrpex_ind=0, $ether_ind=0, $itemtype_void = "",$su_no_id = "")
    //    {
    //
    //
    //        $keyword = strtoupper($keyword);
    //
    //        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
    //        if($itemtype !="")
    //        {
    //            $item_type_arr = explode(",", $itemtype);
    //            foreach ($item_type_arr as $itype) {
    //                $item_type .= "'".$itype."',";
    //            }
    //            $itemtypes = rtrim($item_type,", ");
    //        }
    //
    //        if($itemtype_void !="")
    //        {
    //            $item_type_void_arr = explode(",", $itemtype_void);
    //            foreach ($item_type_void_arr as $itype) {
    //                $item_type_void .= "'".$itype."',";
    //            }
    //            $itemtypevoid = rtrim($item_type_void,", ");
    //        }
    //
    //        $item_type_cond = ($itemtype!="")?" and item_type in($itemtypes)":"";
    //        $item_type_void_cond = ($itemtype_void!="")?" and item_type not in($itemtypevoid)":"";
    //        $su_no_cond = ($su_no_id!= "")?" and serviceunit_no_fk = '$su_no_id'":"";
    //
    //
    //        $result  = DB::table('finc_cashier_wise_reports_vw')
    //            ->select('person_code', 'full_name')
    //            ->whereRaw(DB::raw("(upper(person_code) like '%$keyword%' or upper(full_name) like '%$keyword%')"))
    //
    //            ->get();
    //        dd($result);
    //
    //
    //        $policy_info = [];
    //
    //
    //
    //        if ($result) {
    //
    //            foreach ($result as $value) {
    //
    //
    //                $policy_info[] = array(
    //                    'full_name'           =>$value->full_name,
    //                    'person_code'         => ucfirst($value->person_code)
    //
    //                );
    //
    //            }
    //
    //        }
    //
    //        return $policy_info;
    //    }

    public function getCashierListAutoComplete(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $cashier_info = DB::table('finc_ledgermst_paydisc_vw')
            ->select('ledger_entry_txt', 'ledger_no_pk')
            ->whereRaw(DB::raw("(upper(ledger_no_pk) like '%$keyword%' or upper(ledger_entry_txt) like '%$keyword%')"))
            ->get();
        $cashier_data = [];
        if (!empty($cashier_info)) {
            foreach ($cashier_info as $patient) {
                $cashier_data[] =  array(
                    'person_id'        => $patient->ledger_no_pk,
                    //                    'person_code'      => $patient->person_code,
                    'full_name'      => $patient->ledger_entry_txt,
                    //                    'gender'            => $patient->gender_txt,
                    //                    'age'               => $patient->age,
                    //                    'phone_mobile'      => $patient->mobile1,
                    //                    'patient_photo'     => $patient->patient_photo,
                    //                    'admission_no_pk'   => $patient->admission_no_pk,
                    //                    'admission_uid'     => $patient->admission_uid,
                    //                    'admission_date'    => $patient->admission_date,
                    //                    'bed_name'          => $patient->bed_name,
                    //                    'ward_name'         => $patient->ward_name,
                );
            }
            return $cashier_data;
        }
    }

    //    Added By Nazmul
    public function getPatientAndBilingAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);

        $acc_data = DB::table('finc_voucherwise_vw')
            ->whereRaw(DB::raw("upper(patient_name) like '$keyword%' or upper(invoice_code) like '%$keyword'"))
            ->get();

        $account_data = [];
        if (!empty($acc_data)) {
            foreach ($acc_data as $account) {
                $account_data[] =  array(
                    'patient_id'      => $account->patient_no_fk,
                    'patient_code'    => $account->patient_code,
                    'patient_name'    => $account->patient_name,
                    'gender'          => $account->gender_txt,
                    'age'             => $account->age,
                    'phone_mobile'    => $account->mobile1,
                    'patient_photo'   => $account->patient_photo,
                    'account'         => $account->sales,
                    'adjustable'      => $account->item_level_dist_adj_amt,
                    'discount'        => $account->discount,
                    'payable'         => $account->net_sales,
                    'voucher_id'      => $account->invoice_code,
                );
            };
            return $account_data;
        }
    }

    //    Added By Nazmul Date 06/09/2021
    public function labIdAutoCompleteList(Request $request)
    {
        $keyword = $request->search_data;
        $lab_data = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("lab_code like '$keyword%' or lab_code like '%$keyword'"))
            ->get()->toArray();

        $path_lab_data = [];
        if (!empty($lab_data)) {
            foreach ($lab_data as $row) {
                $path_lab_data[] = array(
                    'lab_uid' => $row->lab_code,
                    'item_name' => $row->item_name,
                    'hospital_code' => $row->hospital_code,
                    'report_no_fk' => $row->report_no_fk,
                    'item_no_pk' => $row->item_no_pk,
                    'sam_name' => $row->sam_name,
                    'patient_no_fk' => $row->patient_no_fk,
                    'serviceunit_name' => $row->serviceunit_name
                );
            };
            return $path_lab_data;
        }
    }
    public function getPatientDetails($patient_id)
    {
        return $patient_info = DB::table("pat_registration_wl_vw")->where("patient_no_pk", $patient_id)->first();
    }


    public function getChequeInfoDetails(Request $request)
    {
        dd('ok');
        $keyword = strtoupper($request->search_data);
        $patient_info = db::table("ipd_admitted_patlist_vw")
            ->leftjoin("pat_registration_wl_vw", "pat_registration_wl_vw.patient_no_pk", "ipd_admitted_patlist_vw.patient_no_fk")
            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'ipd_admitted_patlist_vw.patient_type')
            ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'pat_registration_wl_vw.ccm_client_no_fk')
            ->select('pat_registration_wl_vw.patient_no_pk', 'pat_registration_wl_vw.patient_code', 'pat_registration_wl_vw.salutation', 'pat_registration_wl_vw.patient_name', 'pat_registration_wl_vw.gender_txt', 'pat_registration_wl_vw.age', 'pat_registration_wl_vw.mobile1', 'pat_registration_wl_vw.patient_photo', 'ipd_admitted_patlist_vw.admission_no_pk', 'ipd_admitted_patlist_vw.admission_uid', 'ipd_admitted_patlist_vw.admission_date', 'ipd_admitted_patlist_vw.bed_name', 'ipd_admitted_patlist_vw.ward_name', 'ipd_admitted_patlist_vw.primary_doctor_name', 'ipd_admitted_patlist_vw.ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.first_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.second_ref_doc_person_no_fk', 'ipd_admitted_patlist_vw.refrral_doctor_name', 'ipd_admitted_patlist_vw.first_ref_doctor_name', 'ipd_admitted_patlist_vw.second_ref_doctor_name', 'ipd_admitted_patlist_vw.primary_doctor_code', 'ipd_admitted_patlist_vw.ref_doc_person_code', 'ipd_admitted_patlist_vw.first_ref_doc_person_code', 'ipd_admitted_patlist_vw.second_ref_doc_person_code', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'corp.ccm_client_no_pk', 'corp.ccm_client_name', 'corp.ccm_client_code', 'corp.contact_person', 'corp.contact_mobile', 'ptv.item_level_disc_ind', 'ipd_admitted_patlist_vw.primary_doctor_no_fk', 'pat_registration_wl_vw.payer_type_code')
            ->where('ipd_admitted_patlist_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("upper(ipd_admitted_patlist_vw.admission_no_pk) like '%$keyword%' "))->get();
        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                $patient_data[] =  array(
                    'patient_id'        => $patient->patient_no_pk,
                    'patient_code'      => $patient->patient_code,
                    'patient_name'      => $patient->patient_name,
                    'gender'            => $patient->gender_txt,
                    'age'               => $patient->age,
                    'phone_mobile'      => $patient->mobile1,
                    'patient_photo'     => $patient->patient_photo,
                    'admission_no_pk'   => $patient->admission_no_pk,
                    'admission_uid'     => $patient->admission_uid,
                    'admission_date'    => $patient->admission_date,
                    'bed_name'          => $patient->bed_name,
                    'ward_name'         => $patient->ward_name,
                    'primary_doctor_name'        => $patient->primary_doctor_name,
                    'ref_doc_person_no_fk'       => $patient->ref_doc_person_no_fk,
                    'first_ref_doc_person_no_fk' => $patient->first_ref_doc_person_no_fk,
                    'second_ref_doc_person_no_fk' => $patient->second_ref_doc_person_no_fk,
                    'refrral_doctor_name'        => $patient->refrral_doctor_name,
                    'first_ref_doctor_name'      => $patient->first_ref_doctor_name,
                    'second_ref_doctor_name'     => $patient->second_ref_doctor_name,
                    'primary_doctor_code'     => $patient->primary_doctor_code,
                    'ref_doc_person_code'     => $patient->ref_doc_person_code,
                    'first_ref_doc_person_code'     => $patient->first_ref_doc_person_code,
                    'second_ref_doc_person_code'     => $patient->second_ref_doc_person_code,
                    'patient_type_code'   => $patient->patient_type_code,
                    'maximum_percent'   => $patient->maximum_percent,
                    'patient_type_no_pk'   => $patient->patient_type_no_pk,
                    'ccm_client_no_pk'   => $patient->ccm_client_no_pk,
                    'ccm_client_name'   => $patient->ccm_client_name,
                    'ccm_client_code'   => $patient->ccm_client_code,
                    'contact_person'   => $patient->contact_person,
                    'contact_mobile'   => $patient->contact_mobile,
                    'item_level_disc_ind'   => $patient->item_level_disc_ind,
                    'primary_doctor_no_fk'   => $patient->primary_doctor_no_fk,
                    'payer_type_code'   => $patient->payer_type_code,
                );
            }
            return $patient_data;
        }
    }
    public function qrCodeGenerate($data)
     {
         return QrCode::size(75)->generate($data);
        //   return QrCode::format('svg')->size(100)->generate($data);
     }
}
