<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use App\Traits\LookupData;
use DB;
use App\Traits\PatientData;
use Illuminate\Support\Facades\Auth;
use Session;
use PDO;
use PDF;
use QR;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Traits\UtilitiesTrait;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use GuzzleHttp\Client;


class HOSPatientRegistrationController extends Controller
{
    //
    use  LookupData, UtilitiesTrait,PatientData;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pat_type =  DB::table('patn_patienttype')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.uhl.patient.patient_details_v2", [
            'pat_type' => $pat_type
        ]);
    }
    public function create()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $occupation = $this->getLookupListByCode("OCCUPATION");
        $patidentity = $this->getLookupListByCode("PATIDENTITY");
        $guardianship = $this->getLookupListByCode("GUARDIANSHIP");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $country =  DB::table('sysc_country')->where('status', 1)->get();
        $divisions =  DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        // $district =  DB::table('sysc_district')->orderBy('name', 'asc')->get();
        $thanas =  DB::table('sysc_upazilas')->orderBy('name', 'asc')->get();
        $pat_type =  DB::table('patn_patienttype')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $payer_data = DB::table('ccm_corporateclient')->where('direct_pat_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $sponser_data = DB::table('ccm_corporateclient')->where('sponser_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $patient_type_data = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        // dd($thanas);
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.uhl.patient.registration", ['thanas' => $thanas, 'district' => $district, 'divisions' => $divisions, 'marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'relation' => $relation, 'page_type' => 'add', 'nationality' => $nationality, 'district' => $district, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'country' => $country, 'occupation' => $occupation, 'guardianship' => $guardianship, 'patidentity' => $patidentity, 'pat_type' => $pat_type, 'payer_data' => $payer_data, 'sponser_data' => $sponser_data, 'patient_type_data' => $patient_type_data]);
    }

    public function getEmpInfoFromPatReg(Request $request){
        $emp_id=$request->emp_id; 
        $pat_registration=$emp_id !=null ? DB::table('patn_registration')->where('emp_id', $emp_id)->first():[];
       
        $dupliate_status=!empty( $pat_registration) ?'This Employee Already Registered':'';
        // dd($emp_id, $pat_registration,$dupliate_status);
        $emp_info=DB::table('employee_info_vw')->select('full_name','phone_mobile','dob','gender_txt','marital_status','religion_name','pe_addr1')->where('person_code', $emp_id)->where('status',1)->first();
      
        return response()->json( [$emp_info,$dupliate_status]);
     
       
    }

    public function edit($id = "")
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $occupation = $this->getLookupListByCode("OCCUPATION");
        $patidentity = $this->getLookupListByCode("PATIDENTITY");
        $guardianship = $this->getLookupListByCode("GUARDIANSHIP");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $country =  DB::table('sysc_country')->where('status', 1)->get();
        $divisions =  DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        $thanas =  DB::table('sysc_upazilas')->orderBy('name', 'asc')->get();
        $pat_type =  DB::table('patn_patienttype')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $payer_data = DB::table('ccm_corporateclient')->where('direct_pat_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $sponser_data = DB::table('ccm_corporateclient')->where('sponser_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $patient_type_data = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        // $photo = DB::table('patn_registration')->select('patient_photo')->first();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        
        $patient = DB::table('patn_registration')->where('patient_no_pk', $id)->first();
        return Template::loadView("admin.uhl.patient.registration", ['thanas' => $thanas, 'district' => $district, 'divisions' => $divisions, 
          'marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'relation' => $relation, 'page_type' => 'add',
          'nationality' => $nationality, 'district' => $district, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info,
          'country' => $country, 'occupation' => $occupation, 'guardianship' => $guardianship, 'patidentity' => $patidentity, 'pat_type' => $pat_type, 
          'payer_data' => $payer_data, 'sponser_data' => $sponser_data, 'patient_type_data' => $patient_type_data, 'patient' => $patient]);
    }


    public function store(Request $request)
    {
        try {            
            DB::beginTransaction();
            $pdo = DB::getPdo();
            $pat_salutation     = '';
            $patient_no = $request->hdn_patient_no_pk;
            
            // $corporate_id = $request->corporate_id;
            $corporate_id = $request->corporate_name;
            $corporate_name = '';
            if ($corporate_id != "") {
                $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }
            $appoint_source     = 'WEB';
            $entry_session         = 'session';
            $hospital_id         = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $dob =  $request->patient_dob;
            $patient_name =  $request->full_name;
            $pat_email =  $request->in_email;
            $pat_age_d =  $request->pat_age_d;
            $pat_age_m =  $request->pat_age_m;
            $pat_age_y =  $request->pat_age_y;
            $age =  $request->pat_age_y;
            $patient_dob = date('Y-m-d', strtotime($request->patient_dob));
            $temp = explode("_", $request->patient_gender);
            $patient_gender  = isset($temp[0]) ? $temp[0] : 0;
            $gender_txt  = isset($temp[1]) ? $temp[1] : 0;
            $temp = explode("_", $request->marital_status);
            $marital_status = isset($temp[0]) ? $temp[0] : 0;
            $marital_status_txt = isset($temp[1]) ? $temp[1] : 0;
            $phone_no =  $request->mobile;
            $pat_religion =  $request->religion;
            $pat_address =  $request->pat_address;
            $pat_address1 =  $pat_address2 = '';
            $blood_group =  $request->blood_group;
            // $patient_type =  $request->reg_type;
            $patient_type = $request->patient_type;
            $phone_no =  $request->mobile;
            $zero = 0;
            $null = null;

            $in_father_name = $request->in_father_name;
            $in_mother_name = $request->in_mother_name;
            $in_spouse_name = $request->in_spouse_name;
            $in_national_id = $request->in_national_id;

            $in_pr_addr_thana = $request->in_pr_addr_thana;
            $in_pe_addr_thana = $request->in_per_addr_thana;
            $in_present_district = $request->in_present_district;
            $in_present_post_code = $request->in_present_post_code;
            $in_pr_addr_country = $request->in_pr_addr_country;
            $in_permanent_addr = $request->in_permanent_addr;
            $in_permanent_district = $request->in_permanent_district;
            $in_pe_addr_country = $request->in_pe_addr_country;
            $in_emergency_contact_name = $request->emr_name;
            $in_emergency_contact_relation = $request->in_emergency_contact_relation;
            $in_emergency_contact_contact = $request->in_emergency_contact_contact;
            $in_payer_type_code = $request->payer_type;
            $in_occupation = $request->in_occupation;
            $in_vip_ind = $request->in_occupation;
            $in_vip_narration = $request->in_vip_narration;
            $in_reg_remarks = $request->in_reg_remarks;
            $in_last_edit_reason = $request->in_last_edit_reason;
            $passport_no = $request->passport_id;
            $in_mobile2_alt = $request->in_mobile2_alt;
            $hdn_patient_id = $request->hdn_patient_id;
            $hdn_doctor_id = $request->hdn_doctor_id;
            $realation_pat = $request->realation_pat;

            $in_fall_risk = $request->in_fall_risk;
            $in_n_masking = $request->in_n_masking;
            $in_h_with_care = $request->in_h_with_care;
            $in_guardian_name = $request->in_guardian_name;
            $in_nationality = $request->in_nationalilty;
            $in_status =1;// $request->in_status;
            $auth_id = Auth::user()->user_no_pk;
           
            $per_state_division = $request->per_state_division;
            $state_division = $request->state_division;
            
            $files = $request->file('pat_photo');
            // realtion_name
            $imageName = '';
            $imageName1 = '';
            $imageName2 = '';
            if ($files = $request->file('pat_photo')) {
                $time = time();
                $imageName = $time   . '1.' . $files->getClientOriginalExtension();
                $imageName1 = $time   . '1';
                $this->uploadImages($files, $imageName1, 'images/uploads/patient_images/', 'images/uploads/patient_images/thumb/');
            }else{
                $imageName = $request->old_patient_photo;
            }
            // OUT PAREMETER INITIALIZE
            $out_patient_no_pk = $out_patient_code = $out_error = "";
            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_patregistration(
                :in_patient_no_pk,
                :in_salutation,
                :in_patient_name,
                :in_phone_mobile,
                :in_mobile2_alt,
                :in_email,
                :in_dob,
                :in_age_dd,
                :in_age_mm,
                :in_age_yy,
                :in_age,
                :in_gender,
                :in_gender_txt,
                :in_marital_status,
                :in_marital_status_txt,
                :in_religion,
                :in_address,
                :in_address1,
                :in_address2,
                :in_blood_group,
                :in_patient_type_no_fk,
                :in_ref_patient_no_fk,
                :in_ref_person_no_fk,
                :in_ref_person_no_fk_rel,
                :in_father_name,
                :in_mother_name,
                :in_spouse_name,
                :in_national_id,
                :in_present_addr,
                :in_pr_addr_thana,
                :in_present_district,
                :in_present_post_code,
                :in_pr_addr_country,
                :in_permanent_addr,
                :in_pe_addr_thana,
                :in_permanent_district,
                :in_permanent_post_code,
                :in_pe_addr_country,
                :in_emergency_contact_name,
                :in_emergency_contact_addr,
                :in_emergency_contact_relation,
                :in_emergency_contact_contact,
                :in_payer_type_code,
                :in_occupation,
                :in_vip_ind,
                :in_vip_narration,
                :in_last_edit_reason,
                :in_reg_remarks,
                :in_ccm_client_no_fk,
                :in_ccm_client_name,
                :in_passport_no,
                :in_patient_photo,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :in_fall_risk,
                :in_n_masking,
                :in_h_with_care,
                :in_guardian_name,
                :in_nationality,
                :in_status,
                :in_present_state,
                :in_parmamnent_state,
                :in_sponsor_no_fk,
                :out_patient_no_pk,
                :out_patient_code,
                :out_error
            ); end;");

            $stmt->bindParam(':in_patient_no_pk', $patient_no);
            $stmt->bindParam(':in_salutation', $pat_salutation);
            $stmt->bindParam(':in_patient_name', $patient_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_mobile2_alt', $in_mobile2_alt);
            $stmt->bindParam(':in_email', $pat_email);
            $stmt->bindParam(':in_dob', $patient_dob);
            $stmt->bindParam(':in_age_dd', $pat_age_d);
            $stmt->bindParam(':in_age_mm', $pat_age_m);
            $stmt->bindParam(':in_age_yy', $pat_age_y);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $patient_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_religion', $pat_religion);
            $stmt->bindParam(':in_address', $pat_address);
            $stmt->bindParam(':in_address1', $pat_address1);
            $stmt->bindParam(':in_address2', $pat_address2);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_ref_patient_no_fk', $hdn_patient_id);
            $stmt->bindParam(':in_ref_person_no_fk', $hdn_doctor_id);
            $stmt->bindParam(':in_ref_person_no_fk_rel', $realation_pat);
            $stmt->bindParam(':in_father_name', $in_father_name);
            $stmt->bindParam(':in_mother_name', $in_mother_name);
            $stmt->bindParam(':in_spouse_name', $in_spouse_name);
            $stmt->bindParam(':in_national_id', $in_national_id);
            $stmt->bindParam(':in_present_addr', $pat_address);
            $stmt->bindParam(':in_pr_addr_thana', $in_pr_addr_thana);
            $stmt->bindParam(':in_present_district', $in_present_district);
            $stmt->bindParam(':in_present_post_code', $in_present_post_code);
            $stmt->bindParam(':in_pr_addr_country', $in_pr_addr_country);
            $stmt->bindParam(':in_permanent_addr', $in_permanent_addr);
            $stmt->bindParam(':in_pe_addr_thana', $in_pe_addr_thana);
            $stmt->bindParam(':in_permanent_district', $in_permanent_district);
            $stmt->bindParam(':in_permanent_post_code', $zero);
            $stmt->bindParam(':in_pe_addr_country', $in_pe_addr_country);
            $stmt->bindParam(':in_emergency_contact_name', $in_emergency_contact_name);
            $stmt->bindParam(':in_emergency_contact_addr', $null);
            $stmt->bindParam(':in_emergency_contact_relation', $in_emergency_contact_relation);
            $stmt->bindParam(':in_emergency_contact_contact', $in_emergency_contact_contact);
            $stmt->bindParam(':in_payer_type_code', $in_payer_type_code);
            $stmt->bindParam(':in_occupation', $in_occupation);
            $stmt->bindParam(':in_vip_ind', $in_vip_ind);
            $stmt->bindParam(':in_vip_narration', $in_vip_narration);
            $stmt->bindParam(':in_last_edit_reason', $in_last_edit_reason);
            $stmt->bindParam(':in_reg_remarks', $in_reg_remarks);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_passport_no', $passport_no);
            $stmt->bindParam(':in_patient_photo', $imageName);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':in_fall_risk', $in_fall_risk);
            $stmt->bindParam(':in_n_masking', $in_n_masking);
            $stmt->bindParam(':in_h_with_care', $in_h_with_care);
            $stmt->bindParam(':in_guardian_name', $in_guardian_name);
            $stmt->bindParam(':in_nationality', $in_nationality);
            $stmt->bindParam(':in_status', $in_status);
            $stmt->bindParam(':in_present_state', $state_division);
            $stmt->bindParam(':in_parmamnent_state', $per_state_division);
            $stmt->bindParam(':in_sponsor_no_fk', $zero);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $stmt->execute();
            DB::commit();

            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_code = Session::get('user.ses_hospital_code');
            //billInvoice_wp

            $patient_type = DB::table('pat_registration_wl_vw reg')
                            ->select('pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'reg.ccm_client_name', 'reg.ccm_client_no_fk', 'reg.contact_person', 'reg.contact_no')
                            ->where('reg.patient_no_pk', $out_patient_no_pk)
                            ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'reg.patient_type')
                            ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'reg.patient_type')
                            ->first();
            //return $stmt;


            $address_data = [
                'present_addr' => $request->pat_address,
                'patient_area_no_fk' => $request->hdn_area_code,
                'patient_area_name' => $request->hdn_area_name,
                'emp_id' => $request->emp_relation_id
            ];
            DB::table('patn_registration')->where('patient_no_pk', $out_patient_no_pk)->update($address_data);

            // End
            return [
                'msg' => 'Data Saved Successfully',
                'insert_id' => $out_patient_no_pk,
                'patient_code' => $out_patient_code,
                'patient_name' => $patient_name,
                'gender' => $gender_txt,
                'age' => $age,
                'phone_mobile' => $phone_no,
                'patient_type_code' => isset($patient_type->patient_type_code) ? $patient_type->patient_type_code : '',
                'maximum_percent' => $patient_type->maximum_percent != "" ? $patient_type->maximum_percent : "",
                'patient_type_no_pk' => $patient_type->patient_type_no_pk,
                'item_level_disc_ind' => $patient_type->item_level_disc_ind,
                'ccm_client_no_fk' => $patient_type->ccm_client_no_fk,
                'ccm_client_name' => $patient_type->ccm_client_name,
                'contact_person' => $patient_type->contact_person,
                'contact_no' => $patient_type->contact_no,
                'invoice_no' => isset($out_invoice_no1) ? $out_invoice_no1 : 0
            ];
        } catch (\Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            // return response()->json(['msg' => $e->getMessage()],406);

            return response()->json($message,422);

        }
    }

    public function checkDuplicate(Request $request){
        $nid=$request->nid_no;
        $name=strtoupper($request->name);
        $dob=$request->age !="" ? date('Y-m-d',strtotime($request->age)) :'';
        $mobile_no=$request->mobile_no;
        // dd($name ,$dob , $mobile_no);
        $query = DB::table('patn_registration')
                    ->where('mobile1', $mobile_no)
                    ->whereRaw("upper(patient_name) = upper('$name')")
                    ->whereDate('dob', $dob)->count();
        //dd($query);
        $pat_ind=0;
        if ($query > 0) {
            $pat_ind=1;
            $message=['data'=> '<p style="color:red">This Patient Already Registered </p> '];
        }else{
            $pat_ind=0;
            $message=['data'=>'New Patient'];
        }

        return response()->json( [$message,$pat_ind]);

    }

    public function wristBandSelfAttendent($id){
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $data=explode('*',$id);
        $patien_info=DB::table('patn_registration')->select('patient_name','patient_code','age','gender_txt','dob')->where('patient_no_pk',$data[0])->first();
        // $qrText = 'Patient Code: ' . $patien_info->patient_code;
        $qrText = 20251072;
        // Generate QR code as base64 string
        $qrcontent=$this->qrCodeGenerate( $qrText );
       
            if ($data[1]=="ATTENDENT") {
                 return view("admin.uhl.patient.patient-wristband-print-attendant", ['patien_info' => $patien_info, 'po_hospital_details' => $po_hospital_details,'qrcontent'=>$qrcontent,'pat_type'=>$data[1]]);
            }else{
                 return view("admin.uhl.patient.patient-wristband-print", ['patien_info' => $patien_info, 'po_hospital_details' => $po_hospital_details,'qrcontent'=>$qrcontent,'pat_type'=>$data[1]]);
            }
           
       
        // $pdf = PDF::loadView("admin.uhl.patient.patient-wristband-print", ['patien_info' => $patien_info, 'po_hospital_details' => $po_hospital_details,'qrcontent'=>$qrcontent,'pat_type'=>$data[1]]);
        // return $pdf->stream('item_wise_financial_count_pdf.pdf');
       
    }
    public function wristBandIpd($id){
        ini_set("max_execution_time",0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
      
        $patien_info=DB::table('ipd_admission')->leftjoin('patn_registration','patn_registration.patient_no_pk','=','ipd_admission.patient_no_fk')->select('patn_registration.patient_name','patn_registration.patient_code','patn_registration.dob','patn_registration.gender_txt','ipd_admission.admission_no_pk','patn_registration.age')->where('ipd_admission.admission_no_pk',$id)->first();
      

        // $qrText = 'Patient Code: ' . $patien_info->patient_code;
         $qrText = 20251072;
        // Generate QR code as base64 string
        $qrcontent=$this->qrCodeGenerate( $qrText );
        // dd($qrcontent);
            return view("admin.uhl.patient.patient-wristband-ipd-print", ['patien_info' => $patien_info, 'po_hospital_details' => $po_hospital_details,'qrcontent'=>$qrcontent]);
       
        // $pdf = PDF::loadView("admin.uhl.patient.patient-wristband-ipd-print", ['patien_info' => $patien_info, 'po_hospital_details' => $po_hospital_details,'qrcontent'=>$qrcontent]);
        // return $pdf->stream('wristband.pdf');
    }
    
    public function ipdLevelPrint($id){
        $label_info = DB::table('IPD_ADMITTED_PATLIST_VW')
        ->where('admission_no_pk',$id)
        ->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        

        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;

        $pdf = PDF::loadView("admin.uhl.patient.patient-level-ipd-print", ['data' => $data,'po_hospital_details' => $po_hospital_details]);
        return $pdf->stream("IAN-$label_info->patient_code.pdf");
    }

    public function quickRegistration()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $occupation = $this->getLookupListByCode("OCCUPATION");
        $patidentity = $this->getLookupListByCode("PATIDENTITY");
        $guardianship = $this->getLookupListByCode("GUARDIANSHIP");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $country =  DB::table('sysc_country')->where('status', 1)->get();
        $divisions =  DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        $district =  DB::table('sysc_district')->orderBy('name', 'asc')->get();
        $thanas =  DB::table('sysc_upazilas')->orderBy('name', 'asc')->get();
        $pat_type =  DB::table('patn_patienttype')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $payer_data = DB::table('ccm_corporateclient')->where('direct_pat_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $sponser_data = DB::table('ccm_corporateclient')->where('sponser_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $patient_type_data = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.uhl.patient.quick_registration", ['thanas' => $thanas, 'district' => $district, 'divisions' => $divisions, 'marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'relation' => $relation, 'page_type' => 'add', 'nationality' => $nationality, 'district' => $district, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'country' => $country, 'occupation' => $occupation, 'guardianship' => $guardianship, 'patidentity' => $patidentity, 'pat_type' => $pat_type, 'payer_data' => $payer_data, 'sponser_data' => $sponser_data, 'patient_type_data' => $patient_type_data]);
    }

    public function store_v2(Request $request)
    {
        try { 
            DB::beginTransaction();
            $pdo                            = DB::getPdo();
            $pat_salutation                 = '';
            $patient_no                     = $request->hdn_patient_no_pk;
            $corporate_id                   = $request->corporate_name;
            $corporate_name                 = '';
            if ($corporate_id              != "") {
                $corporate_name            = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }
            $appoint_source                = 'WEB';
            $entry_session                 = 'session';
            $hospital_id                   = Session::get('user.ses_hospital_no_pk');
            $is_pay_consultation           = $request->is_pay_consultation;
            $dob                           = $request->patient_dob;
            $patient_name                  = $request->full_name;
            $pat_email                     = $request->in_email;
            $pat_age_d                     = $request->pat_age_d;
            $pat_age_m                     = $request->pat_age_m;
            $pat_age_y                     = $request->pat_age_y;
            $age                           = $request->pat_age_y;
            $patient_dob                   = date('Y-m-d', strtotime($request->patient_dob));
            $temp                          = explode("_", $request->patient_gender);
            $patient_gender                = isset($temp[0]) ? $temp[0] : 0;
            $gender_txt                    = isset($temp[1]) ? $temp[1] : 0;
            $temp_mari                     = explode("_", $request->marital_status);
            $marital_status                = isset($temp_mari[0]) ? $temp_mari[0] : 0;
            $marital_status_txt            = isset($temp_mari[1]) ? $temp_mari[1] : 0;

            $phone_no                      = $request->mobile;
            $pat_religion                  = $request->religion;
            $pat_address                   = $request->pat_address;
            $pat_address1                  = $pat_address2 = '';
            $blood_group                   = $request->blood_group;
            $patient_type                  = $request->patient_type;
            $phone_no                      = $request->mobile;
            $zero                          = 0;
            $null                          = null;
            $in_father_name                = $request->in_father_name;
            $in_mother_name                = $request->in_mother_name;
            $in_spouse_name                = $request->in_spouse_name;
            $in_national_id                = $request->in_national_id;

            $in_pr_addr_thana              = $request->in_pr_addr_thana;
            $in_pe_addr_thana              = $request->in_per_addr_thana;
            $in_present_district           = $request->in_present_district;
            $in_present_post_code          = $request->in_present_post_code;
            $in_pr_addr_country            = $request->in_pr_addr_country;
            $in_permanent_addr             = $request->in_permanent_addr;
            $in_permanent_district         = $request->in_permanent_district;
            $in_pe_addr_country            = $request->in_pe_addr_country;
            $in_emergency_contact_name     = $request->emr_name;
            $in_emergency_contact_relation = $request->in_emergency_contact_relation;
            $in_emergency_contact_contact  = $request->in_emergency_contact_contact;
            $in_payer_type_code            = $request->payer_type;
            $in_occupation                 = $request->in_occupation;
            $in_vip_ind                    = $request->in_occupation;
            $in_vip_narration              = $request->in_vip_narration;
            $in_reg_remarks                = $request->in_reg_remarks;
            $in_last_edit_reason           = $request->in_last_edit_reason;
            $passport_no                   = $request->passport_id;
            $in_mobile2_alt                = $request->in_mobile2_alt;
            $hdn_patient_id                = $request->hdn_patient_id;
            $hdn_doctor_id                 = $request->hdn_doctor_id;
            $realation_pat                 = $request->realation_pat;

            $in_fall_risk                  = $request->in_fall_risk;
            $in_n_masking                  = $request->in_n_masking;
            $in_h_with_care                = $request->in_h_with_care;
            $in_guardian_name              = $request->in_guardian_name;
            $in_nationality                = $request->nationality;
            $in_status                     = 1;// $request->in_status;
            $auth_id                       = Auth::user()->user_no_pk;
            $per_state_division            = $request->per_state_division;
            $state_division                = $request->state_division;
           
            $visa_validity                 = $request->visa_validity;
            $files = $request->file('pat_photo');
            // realtion_name
            $imageName = '';
            $imageName1 = '';
            $imageName2 = '';
            if ($files = $request->file('pat_photo')) {
                $time = time();
                $imageName = $time   . '1.' . $files->getClientOriginalExtension();
                $imageName1 = $time   . '1';
                $this->uploadImages($files, $imageName1, 'images/uploads/patient_images/', 'images/uploads/patient_images/thumb/');
            }else{
                $imageName = $request->old_patient_photo;
            }
            // dd($request->file('pat_photo'), $imageName);
            // OUT PAREMETER INITIALIZE
            $out_patient_no_pk = $out_patient_code = $out_error = "";
            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_patregistration_quick(
                :in_patient_no_pk,
                :in_salutation,
                :in_patient_name,
                :in_phone_mobile,
                :in_mobile2_alt,
                :in_email,
                :in_dob,
                :in_age_dd,
                :in_age_mm,
                :in_age_yy,
                :in_age,
                :in_gender,
                :in_gender_txt,
                :in_marital_status,
                :in_marital_status_txt,
                :in_religion,
                :in_address,
                :in_address1,
                :in_address2,
                :in_blood_group,
                :in_patient_type_no_fk,
                :in_ref_patient_no_fk,
                :in_ref_person_no_fk,
                :in_ref_person_no_fk_rel,
                :in_father_name,
                :in_mother_name,
                :in_spouse_name,
                :in_national_id,
                :in_present_addr,
                :in_pr_addr_thana,
                :in_present_district,
                :in_present_post_code,
                :in_pr_addr_country,
                :in_permanent_addr,
                :in_pe_addr_thana,
                :in_permanent_district,
                :in_permanent_post_code,
                :in_pe_addr_country,
                :in_emergency_contact_name,
                :in_emergency_contact_addr,
                :in_emergency_contact_relation,
                :in_emergency_contact_contact,
                :in_payer_type_code,
                :in_occupation,
                :in_vip_ind,
                :in_vip_narration,
                :in_last_edit_reason,
                :in_reg_remarks,
                :in_ccm_client_no_fk,
                :in_ccm_client_name,
                :in_passport_no,
                :in_patient_photo,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :in_fall_risk,
                :in_n_masking,
                :in_h_with_care,
                :in_guardian_name,
                :in_nationality,
                :in_status,
                :in_present_state,
                :in_parmamnent_state,
                :in_sponsor_no_fk,
                :in_visa_validate,
                :out_patient_no_pk,
                :out_patient_code,
                :out_error
            ); end;");

            $stmt->bindParam(':in_patient_no_pk', $patient_no);
            $stmt->bindParam(':in_salutation', $pat_salutation);
            $stmt->bindParam(':in_patient_name', $patient_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_mobile2_alt', $in_mobile2_alt);
            $stmt->bindParam(':in_email', $pat_email, PDO::PARAM_STR, 255);
            $stmt->bindParam(':in_dob', $patient_dob);
            $stmt->bindParam(':in_age_dd', $pat_age_d);
            $stmt->bindParam(':in_age_mm', $pat_age_m);
            $stmt->bindParam(':in_age_yy', $pat_age_y);
            $stmt->bindParam(':in_age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':in_gender', $patient_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_religion', $pat_religion);
            $stmt->bindParam(':in_address', $pat_address);
            $stmt->bindParam(':in_address1', $pat_address1);
            $stmt->bindParam(':in_address2', $pat_address2);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type, PDO::PARAM_INT);
            $stmt->bindParam(':in_ref_patient_no_fk', $hdn_patient_id);
            $stmt->bindParam(':in_ref_person_no_fk', $hdn_doctor_id);
            $stmt->bindParam(':in_ref_person_no_fk_rel', $realation_pat);
            $stmt->bindParam(':in_father_name', $in_father_name);
            $stmt->bindParam(':in_mother_name', $in_mother_name);
            $stmt->bindParam(':in_spouse_name', $in_spouse_name);
            $stmt->bindParam(':in_national_id', $in_national_id);
            $stmt->bindParam(':in_present_addr', $pat_address);
            $stmt->bindParam(':in_pr_addr_thana', $in_pr_addr_thana);
            $stmt->bindParam(':in_present_district', $in_present_district);
            $stmt->bindParam(':in_present_post_code', $in_present_post_code);
            $stmt->bindParam(':in_pr_addr_country', $in_pr_addr_country);
            $stmt->bindParam(':in_permanent_addr', $in_permanent_addr);
            $stmt->bindParam(':in_pe_addr_thana', $in_pe_addr_thana);
            $stmt->bindParam(':in_permanent_district', $in_permanent_district);
            $stmt->bindParam(':in_permanent_post_code', $zero);
            $stmt->bindParam(':in_pe_addr_country', $in_pe_addr_country);
            $stmt->bindParam(':in_emergency_contact_name', $in_emergency_contact_name);
            $stmt->bindParam(':in_emergency_contact_addr', $null);
            $stmt->bindParam(':in_emergency_contact_relation', $in_emergency_contact_relation);
            $stmt->bindParam(':in_emergency_contact_contact', $in_emergency_contact_contact);
            $stmt->bindParam(':in_payer_type_code', $in_payer_type_code);
            $stmt->bindParam(':in_occupation', $in_occupation);
            $stmt->bindParam(':in_vip_ind', $in_vip_ind);
            $stmt->bindParam(':in_vip_narration', $in_vip_narration);
            $stmt->bindParam(':in_last_edit_reason', $in_last_edit_reason);
            $stmt->bindParam(':in_reg_remarks', $in_reg_remarks);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_passport_no', $passport_no);
            $stmt->bindParam(':in_patient_photo', $imageName);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':in_fall_risk', $in_fall_risk);
            $stmt->bindParam(':in_n_masking', $in_n_masking);
            $stmt->bindParam(':in_h_with_care', $in_h_with_care);
            $stmt->bindParam(':in_guardian_name', $in_guardian_name);
            $stmt->bindParam(':in_nationality', $in_nationality);
            $stmt->bindParam(':in_status', $in_status);
            $stmt->bindParam(':in_present_state', $state_division);
            $stmt->bindParam(':in_parmamnent_state', $per_state_division);
            $stmt->bindParam(':in_sponsor_no_fk', $zero, PDO::PARAM_INT);
            $stmt->bindParam(':in_visa_validate', $visa_validity);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
           
            
            if (Session::get('user.ses_hospital_code')=="KPJ") {
               $apiUrl = 'http://180.211.162.10:3038/api/patregent/';
                $patient_dob = date('d-M-Y', strtotime($request->patient_dob));
                //  $patient_dob = now()->format('d-M-Y');
                 $sequence = DB::getSequence();
                $sysc_reg_patient_no_pk_seq = $sequence->nextValue('sysc_reg_patient_no_pk_seq');
                $patientData = [
                    "in_PATIENT_NO_PK" => $patient_no,
                    "in_PATIENT_CODE" => "P".$sysc_reg_patient_no_pk_seq,
                    "in_SALUTATION" => $pat_salutation,
                    "in_PATIENT_NAME" => $patient_name,
                    "in_PHONE_MOBILE" =>$phone_no,
                    "in_MOBILE2_alt" => $in_mobile2_alt,
                    "in_EMAIL" =>  $pat_email,
                    "in_DOB" => $patient_dob,
                    "in_AGE_DD" => intval($pat_age_d),
                    "in_AGE_MM" => intval($pat_age_m),
                    "in_AGE_YY" => intval($pat_age_y),
                    "in_AGE" => $age,
                    "in_GENDER" => intval($patient_gender),
                    "in_GENDER_TXT" =>  $gender_txt,
                    "in_MARITAL_STATUS" => intval($marital_status),
                    "in_MARITAL_STATUS_TXT" => $marital_status_txt,
                    "in_RELIGION" => $pat_religion,
                    "in_ADDRESS" => $pat_address,
                    "in_ADDRESS1" => $pat_address1,
                    "in_ADDRESS2" =>$pat_address2,
                    "in_BLOOD_GROUP" => $blood_group,
                    "in_PATIENT_TYPE_NO_FK" =>  intval($patient_type),
                    "in_REF_PATIENT_NO_FK" => $hdn_patient_id,
                    "in_REF_PERSON_NO_FK" => $hdn_doctor_id,
                    "in_REF_PERSON_NO_FK_REL" => $realation_pat,
                    "in_FATHER_NAME" => $in_father_name,
                    "in_MOTHER_NAME" => $in_mother_name,
                    "in_SPOUSE_NAME" => $in_spouse_name,
                    "in_NATIONAL_ID" => $in_national_id,
                    "in_PRESENT_ADDR" => $pat_address,
                    "in_PR_ADDR_THANA" => $in_pr_addr_thana,
                    "in_PRESENT_DISTRICT" => $in_present_district,
                    "in_present_post_code" => $in_present_post_code,
                    "in_PR_ADDR_COUNTRY" => intval($in_pr_addr_country),
                    "in_PERMANENT_ADDR" => $in_permanent_addr,
                    "in_PE_ADDR_THANA" => $in_pe_addr_thana,
                    "in_PERMANENT_DISTRICT" => $in_permanent_district,
                    "in_permanent_post_code" => $zero,
                    "in_PE_ADDR_COUNTRY" => intval($in_pe_addr_country),
                    "in_EMERGENCY_CONTACT_NAME" => $in_emergency_contact_name,
                    "in_EMERGENCY_CONTACT_ADDR" => $null,
                    "in_EMERGENCY_CONTACT_RELATION" => $in_emergency_contact_relation,
                    "in_EMERGENCY_CONTACT_CONTACT" => $in_emergency_contact_contact,
                    "in_payer_type_code" => $in_payer_type_code,
                    "in_OCCUPATION" => $in_occupation,
                    "in_vip_ind" =>intval($in_vip_ind),
                    "in_vip_narration" => $in_vip_narration,
                    "in_last_edit_reason" => $in_last_edit_reason,
                    "in_reg_remarks" => $in_reg_remarks,
                    "in_CCM_CLIENT_NO_FK" => $corporate_id,
                    "in_CCM_CLIENT_NAME" => $corporate_name,
                    "in_passport_no" => $passport_no,
                    "in_PATIENT_PHOTO" => $imageName,
                    "in_au_entry_by" => intval($auth_id),
                    "in_au_entry_session" => $entry_session,
                    "in_au_entry_hospital_pk_no" => intval($hospital_id),
                    "IN_FALL_RISK" => intval($in_fall_risk),
                    "IN_N_MASKING" => intval($in_n_masking),
                    "IN_H_WITH_CARE" => intval($in_h_with_care),
                    "IN_GUARDIAN_NAME" => $in_guardian_name,
                    "in_nationality" => intval($in_nationality),
                    "in_STATUS" => intval($in_status),
                    "in_present_state" => intval($state_division),
                    "in_parmamnent_state" => intval($per_state_division),
                    "in_sponsor_no_fk" => null
                ];

                // dd($patientData);
                
                 $client = new Client();
                  try {
                        $response = $client->post($apiUrl, [
                            'form_params' => $patientData,
                            'headers' => [
                                'Accept' => 'application/json',
                            ]
                        ]);
                        
                        $responseData = json_decode($response->getBody(), true);
                        
                        return response()->json([
                            'success' => true,
                            'data' => $responseData
                        ]);
                        
                    } catch (\GuzzleHttp\Exception\RequestException $e) {
                        return response()->json([
                            'success' => false,
                            'error' => $e->getMessage()
                        ], 500);
                    }
            }else{
                $stmt->execute();
                DB::commit();
                $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $out_patient_no_pk];
                return response()->json($message);
            }
            // $hospital_id = Session::get('user.ses_hospital_no_pk');
            // $hospital_code = Session::get('user.ses_hospital_code');

            // // Fetch patient type details
            // $patient_type = DB::table('pat_registration_wl_vw reg')
            //                 ->select('pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'reg.ccm_client_name', 'reg.ccm_client_no_fk', 'reg.contact_person', 'reg.contact_no')
            //                 ->where('reg.patient_no_pk', $out_patient_no_pk)
            //                 ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'reg.patient_type')
            //                 ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'reg.patient_type')
            //                 ->first();

            // // Update patient registration address data
            // $address_data = [
            //     'present_addr' => $request->pat_address,
            //     'patient_area_no_fk' => $request->hdn_area_code,
            //     'patient_area_name' => $request->hdn_area_name
            // ];
            // DB::table('patn_registration')->where('patient_no_pk', $out_patient_no_pk)->update($address_data);

            // Prepare response data
            // return [
            //     'msg' => 'Data Saved Successfully',
            //     'insert_id' => $out_patient_no_pk,
            //     'patient_code' => $out_patient_code ?? '', 
            //     'patient_name' => $patient_name ?? '',
            //     'gender' => $gender_txt ?? '',
            //     'age' => $age ?? '',
            //     'phone_mobile' => $phone_no ?? '',
            //     'patient_type_code' => $patient_type->patient_type_code ?? '', 
            //     'maximum_percent' => $patient_type->maximum_percent ?? '',
            //     'patient_type_no_pk' => $patient_type->patient_type_no_pk ?? '',
            //     'item_level_disc_ind' => $patient_type->item_level_disc_ind ?? '',
            //     'ccm_client_no_fk' => $patient_type->ccm_client_no_fk ?? '',
            //     'ccm_client_name' => $patient_type->ccm_client_name ?? '',
            //     'contact_person' => $patient_type->contact_person ?? '',
            //     'contact_no' => $patient_type->contact_no ?? '',
            //     'invoice_no' => $out_invoice_no1 ?? 0 
            // ];

           

        } catch (\Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message,422);
        }

    }


    public function patientServiceType($patient_id = ""){
        $specialization = $this->getLookupListByCode("DOCSPL");
        $doctors        = DB::table('hrms_personnel')
                              ->select('person_no_pk', 'person_code', 'serviceunit_no_fk', 'full_name')
                              ->where('internal_doctor_ind', 1)->where('doctor_ind', 1)->get();
        return Template::loadView("admin.uhl.patient.patient_service_type", ['specialization' => $specialization, 'doctors' => $doctors, 'patient_id' => $patient_id]);
    }

    public function patientServiceTypeStore(Request $request){
     
        $sequence                  = DB::getSequence();
		$entry_session             = Session()->get('user.ses_user_pk_no');
		$appointment_req_no_pk     = $sequence->nextValue('appointment_req_no_pk_seq');
		$auth_id                   = Auth::id();
		$ses_hospital_id           = Session::get('user.ses_hospital_no_pk');

		if (isset($request->hidden_circular_id)) {
			$appointment_req_no_pk = $request->appointment_req_no_pk;
		} else {
			$appointment_req_no_pk = $sequence->nextValue('appointment_req_no_pk_seq');
		}

		try {
			$data = [
				'appointment_req_no_pk' => $appointment_req_no_pk,
				'appoint_date'          => date('Y-m-d'),
				'patient_no_fk'         => $request->patient_id,
				'doctor_no_fk'          => $request->doctotr,
				'su_no_fk'              => $request->department,
				'remarks'               => $request->remarks,
				'service_type'          => $request->billing_type,
				'status'                => 1,
				'au_entry_by'           => $auth_id,
				'au_entry_at'           => date('Y-m-d'),
				'au_entry_session'      => $entry_session,
				'au_entry_hospital_pk_no' => $ses_hospital_id
			];
			if (!isset($request->hidden_id)) {
				DB::table("patn_appointment_req")->insert($data);
			} else {
				$data['au_update_by']             = auth::user()->user_no_pk;
				$data['au_update_session']        = Session()->get('user.ses_user_pk_no');
				$data['au_update_at']             = date('Y-m-d');
				$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
			    DB::table("patn_appointment_req")->where('appointment_req_no_pk', $request->hidden_id)->update($data);
			}
			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $e) {
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
		}

		return response()->json($message);
        return Template::loadView("admin.uhl.patient.patient_service_type");
    }


    public function patientServiceTypeList(){
        $today = date('Y-m-d');
        $data  = DB::table('patn_appointment_req')
                     ->join('sysc_lookupdata', 'patn_appointment_req.su_no_fk', '=', 'sysc_lookupdata.lookupdata_no_pk')
                     ->join('hrms_personnel', 'patn_appointment_req.doctor_no_fk', '=', 'hrms_personnel.person_no_pk')
                     ->whereDate('appoint_date', $today)
                     ->select('patn_appointment_req.*', 'hrms_personnel.full_name as doctor_name', 'sysc_lookupdata.lookupdata_name as dept')
                     ->get();
                     
        return Template::loadView("admin.uhl.patient.patient_service_type_worklist", ['data' => $data]);
    }

}
