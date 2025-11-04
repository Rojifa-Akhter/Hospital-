<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\ChamberHospital;
use App\Models\HrmsSchedule;
use App\Models\PatientRegistration;
use App\Models\PatnAppointment;
use App\Models\Users;
use App\Models\Doctor;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\PatientAppointmentRepository;
use App\Repositories\PatientRegistrationRepository;
use App\Traits\DoctorData;
use App\Traits\LookupData;
use App\Traits\MailEngine;
use App\Traits\PatientData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SiteController extends Controller
{
    use LookupData, DoctorData, MailEngine, PatientData, AuthenticatesUsers;

    protected $model;
    protected $appointment;
    protected $appointmentRepository;
    protected $patRegRepository;
    protected $modelDoctor;
    protected $Doctor;
    protected $PatientRegistration;
    //

    /**
     * @var Repo
     */


    public function __construct(HrmsSchedule $schedule, PatnAppointment $appointment, PatientRegistration $patReg, Users $user, Doctor $Doctor, PatientRegistration $PatientRegistration)
    {
       
        $this->model = new Repo($schedule);
        $this->appointment = new Repo($appointment);
        $this->model_user = new Repo($user);
        $this->appointmentRepository = new PatientAppointmentRepository($schedule);
        $this->patRegRepository = new PatientRegistrationRepository($patReg);
        $this->modelDoctor = new Repo($Doctor);
        $this->PatientRegistration = new Repo($PatientRegistration);
    }


    public function app_page()
    {
        $docspl = DB::table('SPECIALIZATION_WISE_DOC_COUNT_VW')->get();
        $chiefcom = $this->getPresLookupIDByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $visit_types = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        // dd($name_prefix);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        //        $doctor_list = $this->getActiveDoctorsList();
        $doctor_list = DB::table("doctor_info_vw")
            ->where("status", 1)
            ->where("job_type", "DR")
            ->where("opd_consultation_ind", 1)
            ->orderBy("full_name", "asc")
            ->get();
        return view("iCure-Home.index", [
            'docspl' => $docspl,
            //            'doctor_list' => $doctor_list,
            'chiefcom' => $chiefcom, 'priority' => $priority, 'gender' => $gender, 'marsts' => $marsts, 'bloodg' => $bloodg, 'visit_types' => $visit_types, 'po_hospital_details' => $po_hospital_details, 'name_prefix' => $name_prefix
        ]);
    }


    public function coverpage()
    {
       
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //dd($po_hospital_details->hospital_code);
        if (strtoupper($po_hospital_details->hospital_code) == "MCARE") {
            return redirect()->route('cover-page-v2'); //cover-page-v2
        } else {
           
            return view('iCure-Home.cover-page', [
                'po_hospital_details' => $po_hospital_details
            ]);
        }
    }


    public function get_doctors_list_by_specl(Request $request)
    {
        return $this->getDoctorsListBySpeclOnline($request);
    }


    public function specialized(Request $request)
    {
        return $this->getDoctorsListBycover($request);
    }

    public function lookupPresDataAutocomplete(Request $request)
    {
        return $this->getPresLookupDataAutocompleteList($request);
    }

    public function appointments_store(Request $request)
    {
        return $this->appointmentRepository->createOrUpdatePatientAppointment($request, $request->id);
    }

    public function patientInfoAutocomplete(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $keyword = strtoupper($request->search_data);
        $patient_info = db::table("patn_registration")
            ->select('patient_no_pk', 'patient_code', 'salutation', 'patient_name', 'gender_txt', 'age', 'mobile1', 'patient_photo')
            ->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->whereRaw(DB::raw("upper(patient_code) like '%$keyword%' or upper(patient_name) like '%$keyword%' or mobile1 like '%$keyword%' "))->get();

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {
                $patient_data[] = array(
                    'patient_id' => $patient->patient_no_pk,
                    'patient_code' => $patient->patient_code,
                    'patient_name' => $patient->patient_name,
                    'gender' => $patient->gender_txt,
                    'age' => $patient->age,
                    'phone_mobile' => $patient->mobile1,
                    'patient_photo' => $patient->patient_photo,
                );
            }
            return $patient_data;
        }
    }

    public function get_doctor_appointment_info(Request $request)
    {
        $appointment_dt = new Carbon($request->appointment_dt);
        $app_date = date("Y-M-d", strtotime($appointment_dt->toDateString()));

        $app_stat = DB::table("doctor_appointment_stat_vw")
            ->where("person_no_pk", $request->doctor_id)
            ->where("schedule_dt", $app_date)
            ->first();

        $app_stat_info = [];
        if (!empty($app_stat)) {
            $app_stat_info = array(
                'doctor_id' => $app_stat->person_no_pk,
                'specialization' => $app_stat->specialization,
                'hospital_id' => $app_stat->au_entry_hospital_pk_no,
                'service_unit_id' => $app_stat->serviceunit_no_fk,
                'schedule_id' => $app_stat->schedule_no_pk,
                'avg_duration' => $app_stat->avg_duration,
                'avg_load' => $app_stat->avg_load,
                'block_load' => $app_stat->block_load,
                'total_appointment' => $app_stat->total_appointment,
                'total_cancel' => $app_stat->total_cancel,
                'total_billed' => $app_stat->total_billed,
                'total_arrived' => $app_stat->total_arrived,
                'total_confirmed' => $app_stat->total_confirmed,
            );
        }
        return $app_stat_info;
    }

    //Added By Nazmul
    public function cashierInfoAutocomplete(Request $request)
    {
        return $this->getDoctorAutocompleteList($request);

        //
        //        $keyword = strtoupper($request->search_data);
        //        $personnel_ind_name = strtoupper($request->personnel_ind_name);
        //        $personnel_ind = strtoupper($request->personnel_ind);
        //        $personnel_cond = ($personnel_ind != "") ? " and $personnel_ind_name in ($personnel_ind)" : "";
        //
        //        $patient_info = \Illuminate\Support\Facades\DB::table("employee_info_vw")
        //
        //            ->select('person_no_pk', 'person_code', 'full_name', 'phone_mobile', 'specialization_lookup_no_fk', 'specialization', 'serviceunit_no_fk', 'su_name', 'gender_txt', 'referal_ind')
        //            ->where('status', 1)
        //            ->whereRaw(DB::raw("(upper(person_code) like '$keyword%' or upper(full_name) like '%$keyword%' or upper(phone_mobile) like '$keyword%' or upper(specialization) like '$keyword%') $personnel_cond "))->get();
        //
        //
        //        $patient_data = [];
        //        if (!empty($patient_info)) {
        //            foreach ($patient_info as $patient) {
        //                $patient_data[] = array(
        //                    'doctor_id' => $patient->person_no_pk,
        //                    'referal_ind' => $patient->referal_ind,
        //                    'person_code' => $patient->person_code,
        //                    'full_name' => $patient->full_name,
        //                    'specialization' => $patient->specialization,
        //                    'gender_txt' => $patient->gender_txt,
        //                    'phone_mobile' => $patient->phone_mobile,
        //                );
        //            }
        //            return $patient_data;
    }

    //        $keyword = strtoupper($request->search_data);
    //        $cashier_info = DB::table("hrms_personnel")
    //            ->select('person_no_pk','person_code','full_name','phone_mobile','card_no','photo_name')
    //            ->whereRaw(DB::raw("upper(person_code) like '%$keyword%' or upper(full_name) like '%$keyword%' or phone_mobile like '%$keyword%' "))
    //            ->get();
    //        $cashier_data = [];
    //        if(!empty($cashier_info))
    //        {
    //            foreach ($cashier_info as $cashier) {
    //                $cashier_data[] =  array (
    //                    'person_no_pk'    => $cashier->person_no_pk,
    //                    'person_code'     => $cashier->person_code,
    //                    'full_name'       => $cashier->full_name,
    //                    'phone_mobile'    => $cashier->phone_mobile,
    //                    'card_no'         => $cashier->card_no,
    //                    'photo_name'      => $cashier->photo_name,
    //                );
    //            }
    //            return $cashier_data;
    //        }

    //        return $this->getCashierListAutoComplete($request);
    //    }


    public function ipdBedViewer()
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $bed = DB::table('ipds_bed')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->select('bed_no_pk', 'bed_name')->get();
        $ward = DB::table('ipds_ward')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('ward_no_pk', 'ward_name')->get();
        $service = db::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('status', 1)->get();
        $ipds_bed = DB::table('ipds_bed')->where('STATUS', 1)->where('bed_status', '1')->orderBy('bed_sl_no', 'asc')->get();


        // and a.au_entry_hospital_no_pk =   $hospital_id


        return Template::loadView('admin.ipd.ipd_bed_viewer.bed_viewer', [
            'ipds_bed' => $ipds_bed,
            'bed' => $bed,
            'ward' => $ward,
            'service' => $service
        ]);
    }
    public function ipdBedViewerV2()
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $bed =[];// DB::table('ipds_bed')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->select('bed_no_pk', 'bed_name')->get();
        $ward =[];// DB::table('ipds_ward')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('ward_no_pk', 'ward_name')->get();
        $service =[];// DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('status', 1)->get();
      
        $grant_privilige=DB::table('sysc_serviceunit')
        ->select('sysc_serviceunit.serviceunit_no_pk as su_no_fk','sysc_serviceunit.serviceunit_name')
        // ->leftJoin('sysc_grant_su','sysc_grant_su.su_no_fk','=','sysc_serviceunit.serviceunit_no_pk')
        // ->where('sysc_grant_su.user_no_fk',Auth::id())
        ->where('sysc_serviceunit.status',1)
        ->where('ipd_ind',1)
        ->get();
        // dd($grant_privilige);
        $ipds_bed =[]; 
        // DB::table('ipds_bed')->leftJoin('ipd_admitted_patlist_vw', function($join) {
        //     $join->on('ipds_bed.bed_no_pk', '=', 'ipd_admitted_patlist_vw.new_bed_no_fk')
        //          ->where('ipd_admitted_patlist_vw.dis_ind', '=', 0);
        // })
        // ->leftJoin('ipds_ward','ipds_ward.ward_no_pk','=','ipds_bed.ward_no_fk')
        // ->select('ipds_bed.*', 'ipd_admitted_patlist_vw.admission_no_pk','ipd_admitted_patlist_vw.patient_name','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipds_ward.ward_name','ipd_admitted_patlist_vw.dis_req_ind','ipd_admitted_patlist_vw.dis_ind','ipd_admitted_patlist_vw.ns_receive_ind')
        // ->where('ipds_bed.status', 1)
        // ->whereIn('ipds_ward.service_unit_no_fk', $grant_privilige)
        // ->orderBy('ipds_bed.bed_sl_no', 'asc')
        // ->get();
        // dd( $results);

        // $ipds_bed = DB::table('ipds_bed')->where('STATUS', 1)
        // // ->where('bed_status', '1')
        // ->orderBy('bed_sl_no', 'asc')
        // ->get();


        // and a.au_entry_hospital_no_pk =   $hospital_id


        return Template::loadView('admin.ipd.ipd_bed_viewer.bed_viewer_v2', [
            'ipds_bed' => $ipds_bed,
            'bed' => $bed,
            'ward' => $ward,
            'service' => $service, 
            'grant_privilige' => $grant_privilige, 
        ]);
    }

    public function ipdBedViewerSearchV2(Request $request){
       
            $data= DB::table('ipds_bed')->leftJoin('ipd_admitted_patlist_vw', function($join) {
                    $join->on('ipds_bed.bed_no_pk', '=', 'ipd_admitted_patlist_vw.new_bed_no_fk')
                         ->where('ipd_admitted_patlist_vw.dis_ind', '=', 0);
                })
                ->leftJoin('ipds_ward','ipds_ward.ward_no_pk','=','ipds_bed.ward_no_fk')
                ->select('ipds_bed.*', 'ipd_admitted_patlist_vw.admission_no_pk','ipd_admitted_patlist_vw.patient_name','ipd_admitted_patlist_vw.patient_code','ipd_admitted_patlist_vw.patient_no_fk','ipd_admitted_patlist_vw.ns_receive_ind','ipd_admitted_patlist_vw.primary_doctor_name','ipd_admitted_patlist_vw.admission_date','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipds_ward.ward_name','ipd_admitted_patlist_vw.dis_req_ind','ipd_admitted_patlist_vw.dis_ind','ipd_admitted_patlist_vw.ns_receive_ind')
                ->where('ipds_bed.status', 1)
                ->where('ipds_bed.bed_status', '!=', null)
                ->where('ipds_ward.service_unit_no_fk', $request->dept_id)
                ->orderBy('ipds_bed.bed_sl_no', 'asc')
                ->get();


                return Template::loadView('admin.ipd.ipd_bed_viewer.all_bed_viewer_v2', [
                    'ipds_bed' => $data,
                    
                ]);
    }
    public function ipdAllBedViewer(Request $request)
    {
        $tab_type = $request->tab_type;
        $bed_id = isset($request->bed_id) ? $request->bed_id : "";
        $ward_id =  isset($request->ward_id) ? $request->ward_id : "";
        $dept_id =  isset($request->dept_id) ? $request->dept_id : "";
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($bed_id != "") ? " $clause  b.bed_no_pk = $bed_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($ward_id != "") ? " $clause  w.ward_no_pk = $ward_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($dept_id != "") ? " $clause  a.su_no_fk = $dept_id" : "";

        if ($tab_type == "Available") {

            $query = DB::table('ipds_bed')
                ->where('STATUS', 1)
                ->where('bed_status', '1')
                ->orderBy('bed_sl_no', 'asc');
            if ($bed_id) {
                $query->where('bed_no_pk', $bed_id);
            }
            if ($ward_id) {
                $query->where('ward_no_fk', $ward_id);
            }
            if ($dept_id) {
                $query->where('su_no_fk', $dept_id);
            }
            $ipds_bed = $query->get();

            return Template::loadView('admin.ipd.ipd_bed_viewer.ipd_available_bed', [
                'ipds_bed' => $ipds_bed,
                'tab_type' => $tab_type
            ]);
        } elseif ($tab_type == "Occupied") {
            $query = DB::table('ipds_bed')
                ->where('STATUS', 1)
                ->where('bed_status', '2')
                ->orderBy('bed_sl_no', 'asc');
            if ($bed_id) {
                $query->where('bed_no_pk', $bed_id);
            }
            if ($ward_id) {
                $query->where('ward_no_fk', $ward_id);
            }
            if ($dept_id) {
                $query->where('su_no_fk', $dept_id);
            }
            $ipds_bed = $query->get();

            return Template::loadView('admin.ipd.ipd_bed_viewer.occupied_bed', [
                'ipds_bed' => $ipds_bed,
                'tab_type' => $tab_type
            ]);
        } elseif ($tab_type == "Not Ready") {

            $query = DB::table('ipds_bed')
                ->where('STATUS', 1)
                ->where('bed_status', '3')
                ->orderBy('bed_sl_no', 'asc');
            if ($bed_id) {
                $query->where('bed_no_pk', $bed_id);
            }
            if ($ward_id) {
                $query->where('ward_no_fk', $ward_id);
            }
            if ($dept_id) {
                $query->where('su_no_fk', $dept_id);
            }
            $ipds_bed = $query->get();

            return Template::loadView('admin.ipd.ipd_bed_viewer.not_ready', [
                'ipds_bed' => $ipds_bed,
                'tab_type' => $tab_type
            ]);
        } elseif ($tab_type == "All Bed") {

            $query = DB::table('ipds_bed')
                ->where('STATUS', 1)
                ->orderBy('bed_sl_no', 'asc');
            if ($bed_id) {
                $query->where('bed_no_pk', $bed_id);
            }
            if ($ward_id) {
                $query->where('ward_no_fk', $ward_id);
            }
            if ($dept_id) {
                $query->where('su_no_fk', $dept_id);
            }
            $ipds_bed = $query->get();
            // where a.au_entry_hospital_no_pk =   $hospital_id
            return Template::loadView('admin.ipd.ipd_bed_viewer.all_bed_viewer', [
                'ipds_bed' => $ipds_bed,
                'tab_type' => $tab_type
            ]);
        }
    }

    public function ipdBedInfo($bed_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_details = db::select(db::raw("select patient_name,gender_txt,admission_date,dis_date,patient_photo from ipd_admitted_patlist_vw where curr_bed_no_fk = $bed_id order by admission_date Desc"));
        $ipds_bed = DB::table("ipd_admission_bed a")
            ->select("a.bed_no_fk", "w.ward_name", "b.bed_name", "s.serviceunit_name", "b.bed_status", "b.admission_fee_item_no_fk", "b.bed_charge_item_no_fk", "b.others_charge_item_no_fk", "b.minimum_deposit_amount", "b.service_charge_item_no_fk")
            ->leftJoin("ipds_ward w", "a.ward_no_fk", "=", "w.ward_no_pk")
            ->leftJoin("ipds_bed b", "a.bed_no_fk", "=", "b.bed_no_pk")
            ->leftJoin("sysc_serviceunit s", "a.su_no_fk", "=", "s.serviceunit_no_pk")
            ->where('b.bed_no_pk', $bed_id)
            ->first();
        return Template::loadView('admin.ipd.ipd_bed_viewer.bed_info_card', [
            'data' => $ipds_bed,
            'patient_details' => $patient_details,
            'po_hospital_details' => $po_hospital_details
        ]);
    }


    //    Cover Page V2 21/09/2021
    public function coverPageV2()
    {
        $current_page = "home";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $country_name = $this->getLookupListByCode("COUNTRY");
        $docspl = DB::table('SPECIALIZATION_WISE_DOC_COUNT_VW')->get();



        $code = 'ECITEMCAT';
        $category = DB::table('sysc_lookupdata_vw')->where('lookup_code', $code)->get();

        $cate_arr = [];
        $sub_cate_arr = [];
        $cate_wise_product = [];
        if (!empty($category)) {
            foreach ($category as $cate) {
                if ($cate->lookupdata_pk_no_parent == null) {
                    $cate_arr[$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
                    $cate_wise_product[$cate->lookupdata_name] = DB::table('sysc_serviceitem_policywise')->where('item_cat_lookupdata_no_fk', $cate->lookupdata_no_pk)->orderBy('au_update_at', 'asc')->orderBy('au_entry_at', 'asc')->paginate(20);
                }
                if ($cate->lookupdata_pk_no_parent != null) {
                    $sub_cate_arr[$cate->lookupdata_pk_no_parent][$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
                }
            }
        }
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();

        //Doctor -- India
        $doctor_indian_list = DB::table('doctor_info_vw')
            ->join('sysc_lookupdata', 'lookupdata_no_pk', 'chamber_hospital_country')
            //->whereRaw("upper(lookupdata_name) ='INDIA'")
            ->get();
        //Doctor -- Bangladesh
        // $doctor_ban_list = DB::table('doctor_info_vw')
        //     ->join('sysc_lookupdata', 'lookupdata_no_pk', 'chamber_hospital_country')
        //     ->whereRaw("upper(lookupdata_name) ='BANGLADESH'")
        //     ->get();

        //Hospital -- Bangla
        // $hospital_bangladesh =  DB::table('wsec_chamber_hospital')
        //     ->join('sysc_lookupdata', 'lookupdata_no_pk', 'chamber_hospital_country')
        //     ->whereRaw("upper(lookupdata_name) ='BANGLADESH' ")
        //     ->limit(10)
        //     ->get();
        //Hospital -- India
        $hospital_india =  DB::table('wsec_chamber_hospital')
            ->join('sysc_lookupdata', 'lookupdata_no_pk', 'chamber_hospital_country')
            ->where('wsec_chamber_hospital.status', 1)
            //->whereRaw("upper(lookupdata_name) ='INDIA' ")
            ->limit(10)
            ->get();

        return view('mCare.index', [
            'po_hospital_details' => $po_hospital_details,
            'country_name' => $country_name,
            'docspl' => $docspl,
            'current_page' => $current_page,
            'cate_wise_product' => $cate_wise_product,
            // 'hospital_bangladesh' => $hospital_bangladesh,
            'hospital_india' => $hospital_india,
            'doctor_indian_list' => $doctor_indian_list,
            'item_cat_arr' => $item_cat_arr
            // 'doctor_ban_list' => $doctor_ban_list,

        ]);
    }


    public function doctorList()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        // $doctor_info_data = DB::table('doctor_info_vw d')
        // ->select()
        // ->leftJoin('hrms_schedule d','sc.doctor_person_no_fk','d.person_no_pk')
        // ->paginate('6');
        $doctor_info_data = DB::table('doctor_info_vw')->where('status', 1)->paginate('6');
        $country = DB::select(DB::raw(' select nationality,count(FULL_NAME) as doctor from doctor_info_vw group by NATIONALITY'));
        // $country = $this->getLookupListByCode("COUNTRY");
        $citys = db::select(db::raw('select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw group by chamber_hospital_city_name'));
        // $citys = $this->getLookupListByCode("DISTRICT");
        $dept = db::select(db::raw(" select specialization,count(specialization) as specialization_count from doctor_info_vw group by specialization"));
        // $dept = DB::table('sysc_serviceunit')->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')->where('status', 1)->get();
        // $cham_hospital = DB::table('WSEC_CHAMBER_HOSPITAL')->select('CHAMBER_HOSPITAL_NO_PK', 'CHAMBER_HOSPITAL_NAME', 'CHAMBER_HOSPITAL_DESCRIPTION')->where('status', 1)->get();

        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw group by chamber_hospital_name,chamber_hospital_location"));
        return view('mCare.doctors', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'doctor_info_data' => $doctor_info_data,
            'country' => $country,
            'dept' => $dept,
            'citys' => $citys,
            'cham_hospital' => $cham_hospital
        ]);
    }

    // public function seachquery(Request $request)
    // {

    // }


    public function doctorSearchDataCity(Request $request)
    {
        $city_name = $request->city;
        $citys = db::select(db::raw("select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw where UPPER(chamber_hospital_city_name) LIKE UPPER('$city_name%') group by chamber_hospital_city_name"));

        return view('mCare.city_hospital_list', [
            'citys' => $citys,
        ]);
    }

    public function hospitalSearchDataCity(Request $request)
    {
        $city_name = $request->city;
        $citys = db::select(db::raw("select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw where UPPER(chamber_hospital_city_name) LIKE UPPER('$city_name%') group by chamber_hospital_city_name"));

        return view('mCare.city_doctor_list', [
            'citys' => $citys,
        ]);
    }

    public function doctorSearchDataDept(Request $request)
    {
        //  dd($request->all());
        $dept_name = $request->dept;
        $dept = db::select(db::raw("SELECT specialization, COUNT (specialization) AS specialization_count
                FROM doctor_info_vw where UPPER(specialization) LIKE UPPER('$dept_name%')
            GROUP BY specialization "));
        return view('mCare.dept_doctor_list', [
            'dept' => $dept,
        ]);
    }

    public function hospitalSearchDataDept(Request $request)
    {
        //  dd($request->all());
        $dept_name = $request->dept;
        $dept = db::select(db::raw("SELECT specialization, COUNT (specialization) AS specialization_count
                FROM doctor_info_vw where UPPER(specialization) LIKE UPPER('$dept_name%')
            GROUP BY specialization "));
        return view('mCare.department_hospital_list', [
            'dept' => $dept,
        ]);
    }

    public function doctorSearchDataHospital(Request $request)
    {
        $hospital_name = $request->hospital;
        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw  where UPPER(chamber_hospital_name) LIKE UPPER('$hospital_name%') group by chamber_hospital_name,chamber_hospital_location "));

        // dd($cham_hospital);

        return view('mCare.hospital_doctor_list', [
            'cham_hospital' => $cham_hospital,
        ]);
    }

    public function hospitalSearchDataHospital(Request $request)
    {
        $hospital_name = $request->hospital;
        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw  where UPPER(chamber_hospital_name) LIKE UPPER('$hospital_name%') group by chamber_hospital_name,chamber_hospital_location "));

        // dd($cham_hospital);

        return view('mCare.hospital_doctor_list', [
            'cham_hospital' => $cham_hospital,
        ]);
    }



    public function doctorSearchDataCountryCheckbox(Request $request)
    {
        // dd($request->all());
        $country_name = $request->country;
        $doctor_info_data = db::select(db::raw("select * from doctor_info_vw where upper(nationality) like upper('$country_name%')"));

        //dd($doctor_info_data);

        return view('mCare.doctor_list', [
            'doctor_info_data' => $doctor_info_data,
        ]);
    }
    public function hospitalSearchDataCountryCheckbox(Request $request)
    {
        // dd($request->all());
        $country_name = $request->country;
        $hospital_info_data = db::select(db::raw("select * from doctor_info_vw where upper(nationality) like upper('$country_name%') and chamber_hospital_no_pk is not null"));

        //dd($doctor_info_data);

        return view('mCare.hospital_list_data', [
            'hospital_info_data' => $hospital_info_data,
        ]);
    }

    public function doctorSearchDataCityCheckbox(Request $request)
    {
        // dd($request->all());
        $city_name = $request->city_id;
        $doctor_info_data = db::select(db::raw("select * from doctor_info_vw where upper(nationality) like upper('$city_name%')"));

        //dd($doctor_info_data);

        return view('mCare.doctor_list', [
            'doctor_info_data' => $doctor_info_data,
        ]);
    }

    public function hospitalSearchDataCityCheckbox(Request $request)
    {

        $city_name = $request->city;
        $hospital_info_data = db::select(db::raw("select * from doctor_info_vw where upper(CHAMBER_HOSPITAL_CITY_NAME) like upper('$city_name%') and chamber_hospital_no_pk is not null"));

        //dd($doctor_info_data);

        return view('mCare.hospital_list_data', [
            'hospital_info_data' => $hospital_info_data,
        ]);
    }

    public function hospitalSearchDataDeptCheckbox(Request $request)
    {

        $dept_name = $request->dept;
        $hospital_info_data = db::select(db::raw("select * from doctor_info_vw where upper(specialization) like upper('$dept_name%') and chamber_hospital_no_pk is not null"));

        //dd($doctor_info_data);

        return view('mCare.hospital_list_data', [
            'hospital_info_data' => $hospital_info_data,
        ]);
    }


    public function hospitalSearchDataHospitalCheckbox(Request $request)
    {

        $hospital = $request->hospital;
        $hospital_info_data = db::select(db::raw("select * from doctor_info_vw where upper(CHAMBER_HOSPITAL_NAME) like upper('$hospital%') and chamber_hospital_no_pk is not null"));

        //dd($doctor_info_data);

        return view('mCare.hospital_list_data', [
            'hospital_info_data' => $hospital_info_data,
        ]);
    }


    public function doctorSearchDataDeptCheckbox(Request $request)
    {
        // dd($request->all());
        $dept_name = $request->dept;
        $doctor_info_data = db::select(db::raw("select * from doctor_info_vw where upper(specialization) like upper('$dept_name%')"));

        //dd($doctor_info_data);

        return view('mCare.doctor_list', [
            'doctor_info_data' => $doctor_info_data,
        ]);
    }
    public function doctorSearchDataHospitalCheckbox(Request $request)
    {
        // dd($request->all());
        $hospital_name = $request->hospital;
        $doctor_info_data = db::select(db::raw("select * from doctor_info_vw where upper(specialization) like upper('$hospital_name%')"));

        //dd($doctor_info_data);

        return view('mCare.doctor_list', [
            'doctor_info_data' => $doctor_info_data,
        ]);
    }

    public function hospitalList()
    {
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $country = DB::select(DB::raw(' select nationality,count(CHAMBER_HOSPITAL_NO_PK) as hospital from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null  group by NATIONALITY'));
        $citys = db::select(db::raw('select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null  group by chamber_hospital_city_name'));
        $dept = db::select(db::raw(" select specialization,count(specialization) as specialization_count from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null group by specialization"));
        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null group by chamber_hospital_name,chamber_hospital_location"));



        $hospital_info_data = DB::table('WSEC_CHAMBER_HOSPITAL')->whereNotNull('CHAMBER_HOSPITAL_NO_PK')->paginate('4');
        return view('mCare.hospitals', [
            'po_hospital_details' => $po_hospital_details,
            'hospital_info_data' => $hospital_info_data,
            'country' => $country,
            'dept' => $dept,
            'citys' => $citys,
            'cham_hospital' => $cham_hospital
        ]);
    }



    public function aboutUs()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('iCure-Home.about_us', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }

    public function mcareAboutUs()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('mCare.about_us', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }

    public function mcareContactUs()
    {
        $current_page = "contact";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('mCare.contact_us', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }
    public function refundPolicy()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('mCare.refund_policy', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }
    public function privacyPolicy()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('mCare.privacy_policy', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }

    public function specialist()
    {
        $current_page = "specialist";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $doctor_list = DB::select(DB::raw("SELECT *
                                              FROM (  SELECT d.person_no_pk,
                                                             sc.schedule_dt,
                                                             d.doctor_fee,
                                                             d.photo_name,
                                                             sc.start_time,
                                                             d.doctor_signature,
                                                             d.full_name,
                                                             d.person_code,
                                                             d.phone_mobile,
                                                             d.specialization,
                                                             d.EXPERIENCE,
                                                             d.JOIN_DATE,
                                                             d.nationality
                                                        FROM    hrms_schedule sc
                                                             LEFT JOIN
                                                                doctor_info_vw d
                                                             ON sc.doctor_person_no_fk = d.person_no_pk
                                                       WHERE TRUNC (sc.schedule_dt) = TRUNC (SYSDATE)
                                                    GROUP BY d.person_no_pk,
                                                             sc.schedule_dt,
                                                             d.photo_name,
                                                             sc.start_time,
                                                             d.doctor_signature,
                                                             d.full_name,
                                                             d.person_code,
                                                             d.phone_mobile,
                                                             d.specialization,
                                                             d.doctor_fee,
                                                             d.EXPERIENCE,
                                                             d.JOIN_DATE,
                                                             d.nationality
                                                    ORDER BY DBMS_RANDOM.RANDOM)
                                             WHERE ROWNUM < 7"));
        return view('iCure-Home.cover_specialist', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'doctor_list' => $doctor_list
        ]);
    }

    public function coverDoctor()
    {
        $current_page = "doctor";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('iCure-Home.cover_doctor', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }

    public function contactUs()
    {
        $current_page = "contact";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('iCure-Home.cover_contact_us', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }

    public function coverSignup()
    {
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $gender = $this->getLookupListByCode("GENDER");
        $division = $this->getLookupListByCode("DIVISION");
        $country_name = $this->getLookupListByCode("COUNTRY");
        return view('iCure-Home.cover_signup', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'gender' => $gender,
            'division' => $division,
            'country_name' => $country_name
        ]);
    }

    public function coverSignupForAppointment($id)
    {
        // dd($id);
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $gender = $this->getLookupListByCode("GENDER");
        $division = $this->getLookupListByCode("DIVISION");
        $country_name = $this->getLookupListByCode("COUNTRY");
        return view('iCure-Home.cover_signup_for_appointment', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'gender' => $gender,
            'division' => $division,
            'country_name' => $country_name,
            'id' => $id
        ]);
    }


    public function coverSignin()
    {
        if (isset(Auth::user()->user_no_pk)) {
            if (Auth::user()->user_type == "doc") {
                return redirect()->route('cover.doctor-admin-panel');
            } else {
                return redirect()->route('cover.patient-admin-panel');
            }
        } else {
            $current_page = "";
            $po_hospital_details = DB::table("wsec_hospital")->first();
            return view('iCure-Home.cover_signin', [
                'po_hospital_details' => $po_hospital_details,
                'current_page' => $current_page
            ]);
        }
    }

    public function coverLoginForAppointment($id)
    {


        if (isset(Auth::user()->user_no_pk)) {
            $current_page = "";
            $po_hospital_details = DB::table("wsec_hospital")->first();
            $gender = $this->getLookupListByCode("GENDER");
            $doc_data = DB::select(DB::raw("SELECT d.person_no_pk,
                                        sc.schedule_dt,
                                        d.doctor_fee,
                                        d.photo_name,
                                        sc.start_time,
                                        d.doctor_signature,
                                        d.full_name,
                                        d.person_code,
                                        d.phone_mobile,
                                        d.specialization,
                                        d.specialization_lookup_no_fk,
                                        d.nationality,
                                        d.experience,
                                        sc.schedule_no_pk,
                                        d.au_entry_hospital_pk_no,
                                        d.serviceunit_no_fk,d.email_personal
                                    FROM    doctor_info_vw d
                                        LEFT JOIN
                                            hrms_schedule sc
                                        ON sc.doctor_person_no_fk = d.person_no_pk
                                    WHERE TRUNC (sc.schedule_dt) = TRUNC (SYSDATE) AND d.person_no_pk = $id"));

            return view('iCure-Home.patient.cover_appointment_form_for_patient', [
                'doc_data' => $doc_data,
                'po_hospital_details' => $po_hospital_details,
                'current_page' => $current_page,
                'gender' => $gender,
            ]);
        } else {
            $current_page = "";
            $id = $id;
            $po_hospital_details = DB::table("wsec_hospital")->first();
            return view('iCure-Home.patient.signin_for_appointment', [
                'po_hospital_details' => $po_hospital_details,
                'current_page' => $current_page,
                'id' => $id
            ]);
        }
    }

    public function coverBookAppointment()
    {
        $current_page = "apointment";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $docspl = DB::table('SPECIALIZATION_WISE_DOC_COUNT_VW')->get();
        $specialization = $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getPresLookupIDByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $visit_types = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $country_name = $this->getLookupListByCode("COUNTRY");

        $doctor_list = DB::select(DB::raw("SELECT *
                              FROM (  SELECT d.person_no_pk,sc.schedule_dt,d.doctor_fee,d.photo_name,sc.start_time,d.doctor_signature, d.full_name,d.person_code,d.phone_mobile,d.specialization
                                        FROM hrms_schedule sc
                                        left join doctor_info_vw d on sc.doctor_person_no_fk = d.person_no_pk
                                        where trunc(sc.schedule_dt) = trunc(sysdate)
                                        group by d.person_no_pk,sc.schedule_dt,d.photo_name,sc.start_time,d.doctor_signature,d.full_name,d.person_code,d.phone_mobile,d.specialization,d.doctor_fee
                                    ORDER BY DBMS_RANDOM.RANDOM)
                             WHERE ROWNUM < 4"));

        return view('iCure-Home.cover_book_appointment', [
            'chiefcom' => $chiefcom,
            'priority' => $priority,
            'gender' => $gender,
            'marsts' => $marsts,
            'bloodg' => $bloodg,
            'visit_types' => $visit_types,
            'specialization' => $specialization,
            'name_prefix' => $name_prefix,
            'doctor_list' => $doctor_list,
            'docspl' => $docspl,
            'country_name' => $country_name,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }
    public function coverBookAppointmentPatient()
    {
        $current_page = "apointment";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $gender = $this->getLookupListByCode("GENDER");
        $doc_data = DB::table('doctor_info_vw')
            // ->where('person_no_pk',$doctor_id)
            ->first();

        return view('iCure-Home.cover_appointment_form', [
            'gender' => $gender,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'doc_data' => $doc_data,
        ]);
    }


    //        Store SignUp

    public function signUpStore(Request $request)
    {


        //        dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();
        $join_type = $request->join_type;
        $sequence = DB::getSequence();
        $sysc_pat_no_pk_seq = $sequence->nextValue('sysc_reg_patient_no_pk_seq') + 1;
        $sequence_doc = DB::getSequence();
        $sysc_doc_no_pk_seq = $sequence_doc->nextValue('sysc_doctor_no_pk_seq') + 1;
        //        otp randomly
        $otp1 = rand(0, 9);
        $otp2 = rand(0, 9);
        $otp3 = rand(0, 9);
        $otp4 = rand(0, 9);

        $request->validate([
            //            'join_type' => 'required',
            'full_name' => 'required',
            'phone' => 'required',
            //            'user_email' => 'required|email',
            //            'password' => 'required|min:6|max:12',
            //            'c_pasword' => 'required_with:password|same:password|min:6'
        ]);

        //    User Part
        DB::beginTransaction();
        try {


            $data = [
                'user_type' => $join_type,
                'phone_mobile' => $request->phone,
                'email' => $request->user_email,
                'user_name' => $request->full_name,
                'user_fullname' => $request->full_name,
                'status' => 1,
                'user_pass' => hash::make($request->password),
                'last_otp_text' => $otp1 . $otp2 . $otp3 . $otp4,
                //                'last_otp_verified_ind'=>1,
                'last_otp_expire_dttm' => date('y-m-d h:i:s')

            ];
            //        Patient or Doctor part
            //            if ($join_type == 'doc') {
            //                $doc_data = [
            //                    'phone_mobile' => $request->phone,
            //                    'email_personal' => $request->user_email,
            //                    'nationality' => $request->country,
            //                    'full_name' => $request->full_name,
            //                    'fname' => $request->full_name,
            //                    'license_number' => $request->license,
            //                    'license_issue_date' => date('y-m-d'),
            //                    'status' => 1,
            //                    'doctor_ind' => 1,
            //                    'specialization_lookup_no_fk' => 641,
            //                ];
            //            } else {
            $pat_data = [
                'mobile1' => $request->phone,
                'email' => $request->user_email,
                'nationality' => $request->country,
                'patient_name' => $request->full_name,
                'status' => 1,
                // 'age' => 18,
                'patient_code' => 'P10203' . $sysc_pat_no_pk_seq,
            ];
            //            }




            if ($id == "") {
                //                    if($join_type == 'doc') {
                //                        $data['person_no_fk'] = $sysc_doc_no_pk_seq;
                //                           }else{
                //                        $data['patient_no_fk'] = $sysc_pat_no_pk_seq;
                //                    }
                $data['patient_no_fk'] = $sysc_pat_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                $this->model_user->create($data);
            }

            //            if ($join_type == 'doc') {
            //                if ($id == "") {
            //                    $doc_data['au_entry_by'] = $auth_id;
            //                    $this->modelDoctor->create($doc_data);
            //                }
            //            } else {
            //                if ($id == "") {
            //                    $pat_data['au_entry_by'] = $auth_id;
            //                    $this->PatientRegistration->create($pat_data);
            //
            //                }
            //
            //            }
            if ($id == "") {
                $pat_data['au_entry_by'] = $auth_id;
                $this->PatientRegistration->create($pat_data);
            }
            DB::commit();
            // $user = Users::where('phone_mobile', '=', $request->phone)->first();
            $po_hospital_details = DB::table("wsec_hospital")->first();
            //session(['wsec_user.ses_hospital_no_pk' => $po_hospital_details->hospital_no_pk]);
            session(['user.ses_hospital_code' => $po_hospital_details->hospital_code]);
            // Auth::login($user_otp);
            $user = Users::where('phone_mobile', '=', $request->phone)->first();
            Auth::login($user);
            return redirect()->route('cover.otp-verify');

            //            $this->message = ['msg' => 'Save Successfully.', 'title' => 'Success',];

            //            if ($join_type == 'doc') {
            //                Auth::login($user);
            //                return $join_type;
            //                return redirect()->route('cover.otp-verify');
            //            } else {
            //                Auth::login($user);
            //                return redirect()->route('cover.otp-verify');
            //            }
            //return redirect()->route('cover.admin-panel');
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return back()->with('fail', 'No Account Found For This Mobile Number');
        }

        //return response()->json($this->message);
    }


    //        Store SignUp

    public function signUpStoreForAppointment(Request $request)
    {


        dd($request->all());

        $id = $request->id;
        $auth_id = Auth::id();
        $sequence = DB::getSequence();
        $sysc_pat_no_pk_seq = $sequence->nextValue('sysc_reg_patient_no_pk_seq') + 1;
        $sequence_doc = DB::getSequence();
        $sysc_doc_no_pk_seq = $sequence_doc->nextValue('sysc_doctor_no_pk_seq') + 1;

        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
        ]);

        //    User Part
        DB::beginTransaction();
        try {


            $data = [
                'phone_mobile' => $request->phone,
                'email' => $request->user_email,
                'user_name' => $request->full_name,
                'user_fullname' => $request->full_name,
                'status' => 1,
                'user_pass' => hash::make($request->password),
                'last_otp_expire_dttm' => date('y-m-d h:i:s')

            ];
            $pat_data = [
                'mobile1' => $request->phone,
                'email' => $request->user_email,
                'nationality' => $request->country,
                'patient_name' => $request->full_name,
                'status' => 1,
                // 'age' => 18,
                'patient_code' => 'P10203' . $sysc_pat_no_pk_seq,
            ];
            //            }




            if ($id == "") {
                $data['patient_no_fk'] = $sysc_pat_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                $this->model_user->create($data);
            }
            if ($id == "") {
                $pat_data['au_entry_by'] = $auth_id;
                $this->PatientRegistration->create($pat_data);
            }
            DB::commit();

            $user = Users::where('phone_mobile', '=', $request->phone)->first();
            Auth::login($user);
            return redirect()->route('cover.otp-verify');
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return back()->with('fail', 'No Account Found For This Email');
        }
    }


    public function otpVerify()
    {
        $current_page = "apointment";
        $po_hospital_details = DB::table("wsec_hospital")->first();


        return view('iCure-Home.otp', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
        ]);
    }
    public function verifyOtpStore(Request $request)
    {
        $user_otp = Users::where('user_no_pk', '=', $request->user_no_pk)->first();
        $otp = $request->otp_0 . $request->otp_1 . $request->otp_2 . $request->otp_3;

        //            dd($user_otp->,$otp);

        if ($otp == $user_otp->last_otp_text) {
            $user_verify_data  = DB::table('wsec_user')
                ->where('user_no_pk', $request->user_no_pk)
                ->update([
                    'last_otp_verified_ind' => 1,
                    'last_otp_expire_dttm' => date('y-m-d h:i:s')
                ]);
            DB::commit();

            // // $user = Users::where('phone_mobile', '=', $request->phone)->first();
            //  $po_hospital_details = DB::table("wsec_hospital")->first();
            //      //session(['wsec_user.ses_hospital_no_pk' => $po_hospital_details->hospital_no_pk]);
            //      session(['user.ses_hospital_code' => $po_hospital_details->hospital_code]);
            //  Auth::login($user_otp);

            return redirect()->route('cover.patient-admin-panel');
        } else {
            return redirect()->back();
        }
    }

    public function verifyOtpStoreForAppointment(Request $request, $id)
    {
        $user_otp = Users::where('user_no_pk', '=', $request->user_no_pk)->first();
        $otp = $request->otp_0 . $request->otp_1 . $request->otp_2 . $request->otp_3;

        //            dd($user_otp->,$otp);

        if ($otp == $user_otp->last_otp_text) {
            $user_verify_data  = DB::table('wsec_user')
                ->where('user_no_pk', $request->user_no_pk)
                ->update([
                    'last_otp_verified_ind' => 1,
                    'last_otp_expire_dttm' => date('y-m-d h:i:s')
                ]);
            DB::commit();


            return redirect()->route('cover.book-appointment-sign-doctor-by-patient', $id);
        } else {
            return redirect()->back();
        }
    }

    public function doctorSpecialized(Request $request)
    {
        //        dd($request->all());

        $doctor_data = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->country != "") ? " $clause d.person_no_pk = $request->country" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->specialization != "") ? " $clause d.specialization_lookup_no_fk = $request->specialization" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_data != "") ? " $clause d.person_no_pk = $doctor_data" : "";
        $query = DB::select("SELECT *
                      FROM ( SELECT
    d.person_no_pk,
    sc.schedule_dt,
    d.doctor_fee,
    d.photo_name,
    sc.start_time,
    d.doctor_signature,
    d.full_name,
    d.person_code,
    d.phone_mobile,
    d.specialization,
    d.specialization_lookup_no_fk,
    d.nationality,
    d.experience
FROM
   doctor_info_vw d
    LEFT JOIN hrms_schedule sc ON sc.doctor_person_no_fk = d.person_no_pk
    and trunc(sc.schedule_dt) = trunc(sysdate)
    $sql_cond
GROUP BY
    d.person_no_pk,
    sc.schedule_dt,
    d.photo_name,
    sc.start_time,
    d.doctor_signature,
    d.full_name,
    d.person_code,
    d.phone_mobile,
    d.specialization,
    d.doctor_fee,
    d.specialization_lookup_no_fk,
     d.nationality,
     d.experience
    ORDER BY DBMS_RANDOM.RANDOM)");
        return Template::loadview("iCure-Home.cover_doctor_list", [
            'doctor_list' => $query,
        ]);
    }

    public function coverLogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required|min:5|max:12'
        ]);
        $user = Users::where('phone_mobile', '=', $request->mobile)->first();
        //        dd($user->user_type);


        if ($user) {
            if ($user->user_type == 'doc') {
                Auth::login($user);
                return redirect()->route('cover.doctor-admin-panel');
            } else {
                $po_hospital_details = DB::table("wsec_hospital")->first();
                //session(['wsec_user.ses_hospital_no_pk' => $po_hospital_details->hospital_no_pk]);
                session(['user.ses_hospital_code' => $po_hospital_details->hospital_code]);
                session(['user.ses_hospital_no_pk' => $po_hospital_details->hospital_no_pk]);
                Auth::login($user);
                // $this->message = ['msg' => 'Message Sent Successful.', 'title' => 'Success',];
                return redirect()->route('cover.patient-admin-panel');
            }
        } else {
            // $this->message = ['title' => 'Error'];
            return back()->with('fail', 'No Account Found For This Phone Number');
        }
    }

    public function coverLoginForAppoitment(Request $request, $id)
    {
        // dd($request->id);
        $request->validate([
            'mobile' => 'required|min:5|max:12'
        ]);
        $user = Users::where('phone_mobile', '=', $request->mobile)->first();
        //        dd($user->user_type);



        if ($user) {
            if ($user->user_type == 'doc') {
                Auth::login($user);
                return view('iCure-Home.otp_for_appointment', [
                    'id' => $id
                ]);
            } else {
                Auth::login($user);
                // $this->message = ['msg' => 'Message Sent Successful.', 'title' => 'Success',];
                return view('iCure-Home.otp_for_appointment', [
                    'id' => $id
                ]);
            }
        } else {
            // $this->message = ['title' => 'Error'];
            return back()->with('fail', 'No Account Found For This Email');
        }
    }

    public function CoverLogout()
    {
        Auth::logout();
        return redirect('cover/signin');
    }
    public function get_doctor_appointment_info_cover(Request $request)
    {
        $appointment_dt = new Carbon($request->appointment_dt);
        $app_date = date("Y-M-d", strtotime($appointment_dt->toDateString()));

        $app_stat = DB::table("doctor_appointment_stat_vw")
            ->where("person_no_pk", $request->doctor_id)
            ->where("schedule_dt", $app_date)
            ->first();

        $app_stat_info = [];
        if (!empty($app_stat)) {
            $app_stat_info = array(
                'doctor_id' => $app_stat->person_no_pk,
                'specialization' => $app_stat->specialization,
                'hospital_id' => $app_stat->au_entry_hospital_pk_no,
                'service_unit_id' => $app_stat->serviceunit_no_fk,
                'schedule_id' => $app_stat->schedule_no_pk,
                'avg_duration' => $app_stat->avg_duration,
                'avg_load' => $app_stat->avg_load,
                'block_load' => $app_stat->block_load,
                'total_appointment' => $app_stat->total_appointment,
                'total_cancel' => $app_stat->total_cancel,
                'total_billed' => $app_stat->total_billed,
                'total_arrived' => $app_stat->total_arrived,
                'total_confirmed' => $app_stat->total_confirmed,
            );
        }
        return $app_stat_info;
    }

    public function contactUsStore(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_text' => 'required'
        ]);
        //$last_id = DB::table('pat_history_tracking')->('pat_tracking_no_pk','desc')->first();
        $sequence = DB::getSequence();
        $sysc_pat_no_pk_seq = $sequence->nextValue('pat_tracking_no_seq');

        DB::beginTransaction();
        try {
            $result  = db::table('pat_history_tracking')
                ->insert([
                    'online_pat_name' => $request->user_name,
                    'email_name' => $request->user_email,
                    'sms_text' => $request->user_text,
                    'email_ind' => 1,
                    'online_pat_ind' => 1,
                    'AU_ENTRY_AT' => date('Y-m-d'),
                    'AU_ENTRY_BY' => 1,
                    'AU_ENTRY_HOSPITAL_PK_NO' => 1,
                    'AU_ENTRY_SESSION' => 'Session',
                    'TRAKING_DATE' => date('Y-m-d'),
                    'PAT_TRACKING_NO_PK' => $sysc_pat_no_pk_seq
                ]);
            DB::commit();

            $this->message = ['msg' => 'Message Sent Successful.', 'title' => 'Success',];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }
    public function coverBookAppointmentSignDoctor($doctor_id)
    {
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $gender = $this->getLookupListByCode("GENDER");
        //        $doc_data = DB::table('doctor_info_vw')
        //                ->where('person_no_pk',$doctor_id)
        //                ->first();
        $doc_data = DB::select(DB::raw("SELECT d.person_no_pk,
       sc.schedule_dt,
       d.doctor_fee,
       d.photo_name,
       sc.start_time,
       d.doctor_signature,
       d.full_name,
       d.person_code,
       d.phone_mobile,
       d.specialization,
       d.specialization_lookup_no_fk,
       d.nationality,
       d.experience,
       sc.schedule_no_pk,
       d.au_entry_hospital_pk_no,
       d.serviceunit_no_fk
  FROM    doctor_info_vw d
       LEFT JOIN
          hrms_schedule sc
       ON sc.doctor_person_no_fk = d.person_no_pk
 WHERE TRUNC (sc.schedule_dt) = TRUNC (SYSDATE) AND d.person_no_pk = $doctor_id"));

        //dd($doc_data);
        return view('iCure-Home.cover_book_appointment', [
            'doc_data' => $doc_data,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'gender' => $gender,
        ]);
    }
    public function appointmentStore(Request $request)
    {
        dd($request->all());
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_text' => 'required'
        ]);
        //$last_id = DB::table('pat_history_tracking')->('pat_tracking_no_pk','desc')->first();
        $sequence = DB::getSequence();
        $sysc_pat_no_pk_seq = $sequence->nextValue('pat_tracking_no_seq');

        DB::beginTransaction();
        try {
            $result  = db::table('pat_history_tracking')
                ->insert([
                    'online_pat_name' => $request->user_name,
                    'email_name' => $request->user_email,
                    'sms_text' => $request->user_text,
                    'email_ind' => 1,
                    'online_pat_ind' => 1,
                    'AU_ENTRY_AT' => date('Y-m-d'),
                    'AU_ENTRY_BY' => 1,
                    'AU_ENTRY_HOSPITAL_PK_NO' => 1,
                    'AU_ENTRY_SESSION' => 'Session',
                    'TRAKING_DATE' => date('Y-m-d'),
                    'PAT_TRACKING_NO_PK' => $sysc_pat_no_pk_seq
                ]);
            DB::commit();

            $this->message = ['msg' => 'Message Sent Successful.', 'title' => 'Success',];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }

    // doctor Details
    public function doctorDetails($id)
    {
        $country = DB::select(DB::raw(' select nationality,count(FULL_NAME) as doctor from doctor_info_vw group by NATIONALITY'));
        $citys = db::select(db::raw('select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw group by chamber_hospital_city_name'));
        $dept = db::select(db::raw(" select specialization,count(specialization) as specialization_count from doctor_info_vw group by specialization"));
        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw group by chamber_hospital_name,chamber_hospital_location"));
        // $doctor_details = DB::select(DB::raw("select hospital.image_url
        //                                     from wsec_chamber_hospital hospital left join hrms_personnel per on per.chamber_hospital_no_pk = hospital.chamber_hospital_no_pk where per.person_no_pk = $id"));
        // $doctor_details = DB::table("wsec_chamber_hospital hospital")->leftJoin('hrms_personnel per', 'per.chamber_hospital_no_pk', 'hospital.chamber_hospital_no_pk')->where('per.person_no_pk', $id)->first();
        $doctor_details = DB::table('doctor_info_vw')->where('person_no_pk', $id)->first();
        $po_hospital_details = DB::table("wsec_hospital")->first();

        //  dd($doctor_details);
        return view('mCare.doctor_details', [
            'country' => $country,
            'dept' => $dept,
            'citys' => $citys,
            'cham_hospital' => $cham_hospital,
            'doctor_details' => $doctor_details,
            'po_hospital_details' => $po_hospital_details,
        ]);
    }
    // doctor Details
    public function hospitalDetails($id)
    {
        $hospital_data = DB::table('WSEC_CHAMBER_HOSPITAL')->where('CHAMBER_HOSPITAL_NO_PK', $id)->first();
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $country = DB::select(DB::raw(' select nationality,count(CHAMBER_HOSPITAL_NO_PK) as hospital from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null  group by NATIONALITY'));
        $citys = db::select(db::raw('select chamber_hospital_city_name, count (chamber_hospital_city_name) as city_count
        from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null  group by chamber_hospital_city_name'));
        $dept = db::select(db::raw(" select specialization,count(specialization) as specialization_count from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null group by specialization"));
        $cham_hospital = db::select(db::raw("select chamber_hospital_name,chamber_hospital_location,count(chamber_hospital_name) as chamber_hospital_name_count from doctor_info_vw where CHAMBER_HOSPITAL_NO_PK is not null group by chamber_hospital_name,chamber_hospital_location"));
        $hospital_details = DB::table('doctor_info_vw')->where('chamber_hospital_no_pk', $id)->get();
        // dd($hospital_data);
        return view('mCare.hospital_details', [
            'country' => $country,
            'dept' => $dept,
            'citys' => $citys,
            'cham_hospital' => $cham_hospital,
            'hospital_data' => $hospital_data,
            'hospital_details' => $hospital_details,

        ]);
    }
    public function termsCondition()
    {
        $current_page = "about";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        return view('mCare.terms_condition', [
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page
        ]);
    }


    public function searchDoctorList(Request $request)
    {
        // dd($request->all());

        $search_doctor = $request->search_doctor;
        $category = $request->category;


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($search_doctor != "") ? " $clause  UPPER (FULL_NAME) LIKE UPPER('%$search_doctor%')" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($category != "") ? " $clause UPPER (LOOKUPDATA_NAME) LIKE UPPER ('%$category%') " : "";


        $query = DB::select(DB::raw("SELECT *
                                    FROM doctor_info_vw
                                        JOIN
                                            sysc_lookupdata
                                        ON lookupdata_no_pk = chamber_hospital_country $sql_cond"));

        // dd($query);

        return Template::loadview("mCare.doctor_wise_list", [
            'doctor_indian_list' => $query
        ]);
    }

    public function searchHospitalList(Request $request)
    {
        // dd($request->all());

        $hospital_search_id = $request->hospital_search_id;
        $category = $request->hosptial_category;


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($hospital_search_id != "") ? " $clause  UPPER (wsec_chamber_hospital.CHAMBER_HOSPITAL_NAME) LIKE UPPER('%$hospital_search_id%')" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($category != "") ? " $clause UPPER (sysc_lookupdata.LOOKUPDATA_NAME) LIKE UPPER ('%$category%') " : "";


        $query = DB::select(DB::raw(" select * from wsec_chamber_hospital  join  sysc_lookupdata
        ON lookupdata_no_pk = chamber_hospital_country $sql_cond  and wsec_chamber_hospital.status= 1 "));

        //  dd($query);

        return Template::loadview("mCare.search_hospital_list", [
            'hospital_india' => $query
        ]);
    }

    public function searchProductList(Request $request)
    {
        //dd($request->all());

        $hospital_search_id = $request->pro_id;
        $category = $request->cat_id;


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($hospital_search_id != "") ? " $clause  UPPER (ITEM_NAME) LIKE UPPER('%$hospital_search_id%')" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($category != "") ? " $clause  item_cat_lookupdata_no_fk = $category " : "";



        $code = 'ECITEMCAT';
        $category = DB::table('sysc_lookupdata_vw')->where('lookup_code', $code)->get();

        $cate_arr = [];
        $sub_cate_arr = [];
        $cate_wise_product = [];
        if (!empty($category)) {
            foreach ($category as $cate) {
                if ($cate->lookupdata_pk_no_parent == null) {
                    $cate_arr[$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
                    $cate_wise_product[$cate->lookupdata_name] = DB::select(DB::raw('select * from sysc_serviceitem_policywise ' . $sql_cond . 'and item_cat_lookupdata_no_fk = ' . $cate->lookupdata_no_pk));



                    // DB::table('sysc_serviceitem_vw')->where('item_cat_lookupdata_no_fk', $cate->lookupdata_no_pk)->where('item_cat_lookupdata_no_fk',$category)->orderBy('au_update_at', 'asc')->orderBy('au_entry_at', 'asc')->paginate(20);
                }
                if ($cate->lookupdata_pk_no_parent != null) {
                    $sub_cate_arr[$cate->lookupdata_pk_no_parent][$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
                }
            }
        }

        // $query = DB::select(DB::raw(" select * from wsec_chamber_hospital  join  sysc_lookupdata
        // ON lookupdata_no_pk = chamber_hospital_country $sql_cond  and wsec_chamber_hospital.status= 1 "));

        //dd($cate_wise_product);

        return Template::loadview("mCare.search_product_list", [
            'cate_wise_product' => $cate_wise_product,
        ]);
    }



    // added By Nazmul 02/06/2022
    public function patientAreaInfoAutocomplete(Request $request)
    {
        return $this->getPatientAreaDataAutocompleteList($request);
    }


    public function ipdBedViewerEmergency()
    {
        //   $ipds_bed = DB::table('ipds_bed bed')
        //   ->select('bed.*','EMERGENCY_DAYCARE_IND_TXT')
        //   ->join('SYSC_USER_SU_PRIVS_VW user_priv', 'bed.SU_NO_FK', 'user_priv.SU_NO_FK')
        //   ->join()
        //   ->where('bed.STATUS', 1)
        //   ->wherenotnull('EMERGENCY_DAYCARE_IND_TXT')
        //   ->orderBy('bed_sl_no', 'asc')
        //   ->get();
        $ipds_bed = DB::select(DB::raw("SELECT bed_no_pk,
        ADMISSION_NO_PK,
        admission_uid,
        ADMISSION_DATE,
        ADMISSION_UID bed_name,
        bed_uid,
        ward_no_fk,
        ward_name,
        serviceunit_name,
        bed.BED_STATUS,
        unit.emergency_daycare_ind_txt,
        PATIENT_NO_FK,
        bed.bed_name
   FROM ipds_bed bed
        JOIN sysc_serviceunit unit
           ON bed.su_no_fk = unit.serviceunit_no_pk
              AND unit.emergency_daycare_ind_txt IS NOT NULL
        JOIN ipds_ward ward
           ON bed.ward_no_fk = ward.ward_no_pk
        LEFT JOIN ipd_admission ipd
           ON ipd.CURR_BED_NO_FK = BED.BED_NO_PK AND NVL (IPD.DIS_IND, 0) = 0
  WHERE bed.status = 1 order by 1 asc"));
        // dd($ipds_bed);
        $bedtextind = $this->getLookupListByCode('BEDTEXTIND');
        return Template::loadView('admin.ipd.ipd_bed_viewer.bed_viewer_emergency', [
            'ipds_bed' => $ipds_bed,
            'bedtextind' => $bedtextind,
        ]);
    }

    public function ipdAllBedViewerEmergency(Request $request)
    {
        $module_type =  isset($request->module_type) ? $request->module_type : "";

        $query = DB::select(DB::raw("SELECT bed_no_pk,
        ADMISSION_NO_PK,
        admission_uid,
        ADMISSION_DATE,
        ADMISSION_UID bed_name,
        bed_uid,
        ward_no_fk,
        ward_name,
        serviceunit_name,
        bed.BED_STATUS,
        unit.emergency_daycare_ind_txt,
        PATIENT_NO_FK,
        bed.bed_name
   FROM ipds_bed bed
        JOIN sysc_serviceunit unit
           ON bed.su_no_fk = unit.serviceunit_no_pk
              AND unit.emergency_daycare_ind_txt IS NOT NULL
        JOIN ipds_ward ward
           ON bed.ward_no_fk = ward.ward_no_pk
        LEFT JOIN ipd_admission ipd
           ON ipd.CURR_BED_NO_FK = BED.BED_NO_PK AND NVL (IPD.DIS_IND, 0) = 0
  WHERE bed.status = 1 and unit.emergency_daycare_ind_txt = '$module_type' order by 1 asc"));
        // $query = DB::select(DB::raw("select bed.*,EMERGENCY_DAYCARE_IND_TXT from ipds_bed bed join SYSC_USER_SU_PRIVS_VW user_priv on bed.SU_NO_FK = user_priv.SU_NO_FK where EMERGENCY_DAYCARE_IND_TXT = '$module_type' and EMERGENCY_DAYCARE_IND_TXT is not null "));

        //                                     // where a.au_entry_hospital_no_pk =   $hospital_id
        return Template::loadView('admin.ipd.ipd_bed_viewer.ipd_available_bed_emergency', [
                'ipds_bed' => $query
            ]);
    }

    public function ipdPatientnfo($adm_id)
    {
        $patient_details = DB::table('ipd_admitted_patlist_vw')->where('ADMISSION_NO_PK',$adm_id)->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        return Template::loadView('admin.ipd.ipd_bed_viewer.ipd_emergency_patient_details', [
            'patient_details' => $patient_details,
            'po_hospital_details' => $po_hospital_details,
        ]);
    }

}
