<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Users;
use Auth;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
//use App\Repositories\DoctorRepository;
use Illuminate\Support\Facades\Hash;
use App\Traits\UtilitiesTrait;
use App\Traits\ItemData;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
use App\Traits\LookupData;
use App\Traits\DoctorData;
use App\Models\DoctorFee;
use Session;
use Symfony\Component\Console\Input\Input;

class DoctorRepository extends BaseRepository
{
    use UtilitiesTrait, LookupData, DatatablesLoader, ItemData, DoctorData;

    protected $doctor = null;

    protected $userTable;
    protected $doctorfee;
    // protected $doctorfee;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
        // $this->salary = $salary;
        $this->baseRepository = new BaseRepository($doctor);
        // $this->doctorfee = new Repo($doctorfee);
        // $this->salaryRepository = new BaseRepository($salary);

    }

    public function all()
    {
        return $this->doctor->all();
    }

    public function createOrUpdate($request, $id = null)
    {

        // dd($request->all());
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id        = Auth::id();
        DB::beginTransaction();

        $sequence              = DB::getSequence();
        $sysc_doctor_no_pk_seq = $sequence->nextValue('sysc_doctor_no_pk_seq');
        $last_id               = $sysc_doctor_no_pk_seq;
        $random_text = Str::random(10);
        try {
            if ($request->employee == "EMP" || $request->employee == "DOC") {
                $data = [
                    'person_code'                  => $request->uid,
                    'salutation'                   => $request->doctor_salutation,
                    'full_name'                    => $request->doctor_first_name . ' ' . $request->doctor_last_name,
                    'fname'                        => $request->doctor_first_name,
                    'lname'                        => $request->doctor_last_name,
                    'full_name_bangla'             => $request->doctor_full_name_bangla,
                    'gender_lookup_no_fk'          => $request->doctor_gender,
                    'blood_group_lookup_no_fk'     => $request->doctor_blood_group,
                    'marital_lookup_no_fk'         => $request->doctor_marital_status,
                    'religion_lookup_no_fk'        => $request->doctor_religion,
                    'nid_no'                       => $request->doctor_nid,
                    'nationality'                  => $request->doctor_nationality,
                    'jobtitle_lookup_no_fk'        => $request->doctor_job_title,
                    'grade_no_fk'                  => $request->grade_no_fk,
                    'bank_name'                    => $request->bank_name,
                    'bank_acc_no'                  => $request->bank_acc_no,
                    'bank_acc_name'                => $request->bank_acc_name,
                    'agent_banking_type'           => $request->agent_banking_type,
                    'agent_banking_no'             => $request->agent_banking_no,
                    // 'serviceunit_no_fk'            => $request->doctor_ser_unit,
                    'serviceunit_no_fk'            => $request->doctor_ser_unit,
                    'serviceunit_no_fk_dept'       => isset($request->serviceunit_no_fk_dept) ? $request->serviceunit_no_fk_dept : '',

                    // 'card_no'                      => ($request->doctor_card_number) ? $request->doctor_card_number : $request->uid,
                    'hr_type_lookup_no_fk'         => $request->doctor_hr_type,
                    'inactivate_date'              => ($request->inactivate_date != null) ? date('Y/M/d', strtotime($request->inactivate_date)) : null,
                    'inactivate_resson'            => $request->inactivate_resson,
                    'weekly_offday'                => $request->weekly_offday,
                    'area_no_pk'                   => $request->coverage_area,
                    'employee_ind'                 => $request->employee_ind,
                    'doctor_ind'                   => $request->doctor_ind,
                    'benefit_type_no_fk'          => ($request->benefit_type_no_fk) ? $request->benefit_type_no_fk : '',
                    'doc_chamber_day_sat'          => ($request->saturday) ? $request->saturday : 0,
                    'doc_chamber_day_sun'          => ($request->sunday) ? $request->sunday : 0,
                    'doc_chamber_day_mon'          => ($request->monday) ? $request->monday : 0,
                    'doc_chamber_day_tue'          => ($request->tuesday) ? $request->tuesday : 0,
                    'doc_chamber_day_wed'          => ($request->wednesday) ? $request->wednesday : 0,
                    'doc_chamber_day_thu'          => ($request->thursday) ? $request->thursday : 0,
                    'doc_chamber_day_fri'          => ($request->friday) ? $request->friday : 0,
                    'doc_chamber_time_txt'         => $request->time_text,
                    'hospital_name'                => $request->hos_name,
                    'chamber_hospital_no_pk'       => $request->hos_name,
                    'hospital_address'             => $request->consultent_addr,
                    'chamber_schedule_time'        => $request->chamber_time,
                    'chamber_schedule_days'        => $request->chamber_days,
                    // 'contact_number'               => $request->doctor_mobile_no,
                    'phone_mobile'                 => $request->doctor_mobile_no,
                    'email_personal'               => $request->doctor_email,
                    'doc_lic_no'                   => $request->doctor_lic_no,
                    'license_issue_date'           => $request->doctor_lic_issue_date != null ? date("Y/m/d", strtotime($request->doctor_lic_issue_date)) : "",
                    'referal_ind'                  => ($request->referral_ind) ? 1 : '',
                    'specialization_lookup_no_fk'  => $request->doctor_specialization,
                    'doctor_signature'             => $request->doctor_signature,
                    'apps_user_ind'                => ($request->apps_user) ? 1 : "",
                    'agent_access_code'            => $request->passcode,
                    'referral_payable_ind'         => $request->payable_ind,
                    'au_entry_hospital_pk_no'      => Session::get('user.ses_hospital_no_pk'),
                    'digital_signature_ind'        => $request->digital_signature_ind,
                    'emp_serial_in_salary_sheet'   => $request->emp_serial_in_salary_sheet,
                    'ffs_doctor_ind'          => isset($request->ffs_doc_ind) ? 1 : 0,
                ];

                if($request->input('doctor_card_number') != null) $data['card_no'] = $request->doctor_card_number;
                if($request->input('emp_status') != null) $data['emp_status'] = $request->emp_status;

                if($request->input('place_of_birth') != null) $data['place_of_birth'] = $request->place_of_birth;
                if($request->input('doctor_join_date') != null) $data['join_date'] = date("Y-m-d", strtotime($request->doctor_join_date));
                if($request->input('emp_type') != null) $data['emp_type_lookup_no_fk'] = $request->emp_type;
                if($request->input('roster_type') != null) $data['duty_roster_type'] = $request->roster_type;

                if($request->input('doctor_spouse') != null) $data['spouse_name'] = $request->doctor_spouse;
                if($request->input('doctor_spouse_bangla') != null) $data['spouse_name_bangla'] = $request->doctor_spouse_bangla;

                if($request->input('passport_no') != null) $data['passport_no'] = $request->passport_no;
                if($request->input('issue_date') != null) $data['passport_issue_date'] = date("Y/M/d", strtotime($request->issue_date));
                if($request->input('expired_date') != null) $data['passport_expire_date'] = date("Y/M/d", strtotime($request->expired_date));
                if($request->input('issue_place') != null) $data['passport_issue_place'] = $request->issue_place;

                if($request->input('doctor_job_type') != null) $data['job_type_lookup_no_fk'] = $request->doctor_job_type;
                if($request->input('salary_ind') != null) $data['salary_ind'] = $request->salary_ind;

                if($request->input('security_money') != null) $data['security_money_amount'] = $request->security_money;
                if($request->input('receive_date') != null) $data['security_money_received_date'] = date('Y/M/d', strtotime($request->receive_date));

                if($request->input('present_address') != null) $data['pr_addr1'] = $request->present_address;
                if($request->input('doctor_present_district') != null) $data['pr_addr_dist'] = $request->doctor_present_district;
                if($request->input('doctor_pr_thana') != null) $data['pr_addr_thana'] = $request->doctor_pr_thana;
                if($request->input('present_country') != null) $data['pr_addr_country'] = $request->present_country;
                if($request->input('doctor_parmanent_address') != null) $data['pe_addr1'] = $request->doctor_parmanent_address;
                if($request->input('doctor_par_district') != null) $data['pe_addr_dist'] = $request->doctor_par_district;
                if($request->input('doctor_pe_thana') != null) $data['pe_addr_thana'] = $request->doctor_pe_thana;
                if($request->input('parmanent_country') != null) $data['pe_addr_country'] = $request->parmanent_country;

                if($request->input('doctor_date_of_birth') != null) $data['dob'] = date("Y/m/d", strtotime($request->doctor_date_of_birth));
                if($request->input('doctor_remarks') != null) $data['remarks_text'] = $request->doctor_remarks;

                if($request->input('marketing_type') != null) $data['referral_agent_ind'] = $request->marketing_type;

                # Family Information
                if($request->input('doctor_father') != null) $data['father_name'] = $request->doctor_father;
                if($request->input('doctor_father_bangla') != null) $data['father_name_bangla'] = $request->doctor_father_bangla;
                if($request->input('doctor_mother') != null) $data['mother_name'] = $request->doctor_mother;
                if($request->input('doctor_mother_bangla') != null) $data['mother_name_bangla'] = $request->doctor_mother_bangla;
                if($request->input('emergency_contact') != null) $data['emergency_contact_contact'] = $request->emergency_contact;

                # Leave
                if($request->input('leave_category') != null) $data['leave_category_lookup_no_fk'] = $request->leave_category;

                # HOD & Supv
                if($request->input('emp_hod1_person_no_fk') != null) $data['emp_hod1_person_no_fk'] = $request->emp_hod1_person_no_fk;
                if($request->input('emp_hod2_person_no_fk') != null) $data['emp_hod2_person_no_fk'] = $request->emp_hod2_person_no_fk;
                if($request->input('emp_supvisor1_person_no_fk') != null) $data['emp_supvisor1_person_no_fk'] = $request->emp_supvisor1_person_no_fk;

                if($request->page_name == 'employee_create_or_edit') {
                    $data['accomodation_ind'] = isset($request->accommodation) ? 1 : 0;
                    $data['transport_ind'] = isset($request->transport_ind) ? 1 : 0;
                    $data['provident_fund_type'] = isset($request->provident_fund_type) ? 1 : 0;
                    $data['ot_payable_ind'] = isset($request->ot_payable_ind) ? 1 : 0;
                    $data['status'] = isset($request->status_ind) ? 0 : 1;
                    $data['bonus_elig_ind'] = isset($request->bonus_eligibility) ? 1 : 0;
                    $data['mpo_ind'] = isset($request->mpo_ind) ? $request->mpo_ind : "";
                }
            }

            if ($request->employee == "REFER") {
                $data['referal_ind']                 = 1;
                $data['person_code']                 = $request->uid;
                $data['salutation']                  = $request->doctor_salutation;
                $data['full_name']                   = $request->doctor_first_name . ' ' . $request->doctor_last_name;
                $data['fname']                       = $request->doctor_first_name;
                $data['lname']                       = $request->doctor_last_name;
                $data['full_name_bangla']            = $request->doctor_full_name_bangla;
                $data['gender_lookup_no_fk']         = $request->doctor_gender;
                $data['religion_lookup_no_fk']       = $request->doctor_religion;
                $data['phone_mobile']                = $request->doctor_mobile_no;
                $data['nid_no']                      = $request->doctor_nid;
                $data['email_personal']              = $request->doctor_email;
                $data['specialization_lookup_no_fk'] = $request->doctor_specialization;
                $data['degree1']                     = $request->doctor_degree1;
                $data['degree2']                     = $request->doctor_degree2;
                $data['degree3']                     = $request->doctor_degree3;
                $data['degree4']                     = $request->doctor_degree4;
                $data['doctor_ind']                  = $request->referral_doctor_ind;
                $data['employee_ind']                = $request->employee_ind;
                $data['referral_payable_ind']        = $request->payable_ind;
                $data['apps_user_ind']               = ($request->apps_user) ? 1 : "";
                $data['agent_access_code']           = $request->passcode;
                $data['agent_institute_name']        = $request->pharmacy_name;
                $data['pr_addr1']                    = $request->present_address;
                $data['au_entry_hospital_pk_no']     = Session::get('user.ses_hospital_no_pk');
                $data['status']                      = 1;
                $data['emp_serial_in_salary_sheet']  = isset($request->emp_serial_in_salary_sheet) ? $request->emp_serial_in_salary_sheet : "";

                // if ($request->hdn_referrence_name != "") {
                //     $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
                // } else {
                //     $data['ref_agent_person_no_fk'] = $request->hdn_reference;
                // }

                if($request->input('marketing_type') != null) $data['referral_agent_ind'] = $request->marketing_type;


                if ($request->hdn_reference != "") {
                    $data['ref_agent_person_no_fk'] = $request->hdn_reference;
                } else {
                    $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
                }
            }
            if ($request->doctor_job_type == 41) {
                $data['doctor_ind'] = 1;
            }

            if ($request->employee == "EMP") {
                $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
                $data['inv_hod_ind']            = $request->inv_hod_ind;
                $data['inv_auth_admin_ind']     = $request->inv_auth_admin_ind;
                $data['inv_auth_director_ind']  = $request->inv_auth_director_ind;
                $data['inv_auth_chairman_ind']  = $request->inv_auth_chairman_ind;
                $data['inv_director_admin_ind'] = $request->inv_director_admin_ind;
                $data['inv_director_acc_ind']   = $request->inv_director_acc_ind;
                $data['inv_gen_man_proc_ind']   = $request->inv_gen_man_proc_ind;
                $data['inv_manager_acc_ind']    = $request->inv_manager_acc_ind;
                $data['inv_proc_ind']           = $request->inv_proc_ind;
                $data['inv_store_ind']          = $request->inv_store_ind;
                $data['emp_serial_in_salary_sheet']  = isset($request->emp_serial_in_salary_sheet) ? $request->emp_serial_in_salary_sheet : "";

                $data['internal_doctor_ind']    = $request->internal_doc_ind ? 1 : 0;
                $data['external_doctor_ind']    = $request->external_doc_ind ? 1 : 0;
                $data['ffs_doctor_ind']    = $request->ffs_doc_ind ? 1 : 0;
            }

            if ($request->employee == "DOC") {
                $data['internal_doctor_ind']    = $request->internal_doc_ind ? 1 : 0;
                $data['external_doctor_ind']    = $request->external_doc_ind ? 1 : 0;
                $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
                $data['doctor_ind']             =  isset($request->doctor_ind) ? 1 : 0;
                $data['ffs_doctor_ind']             =  isset($request->ffs_doc_ind) ? 1 : 0;
                $data['anaestesiologis_ind']    = $request->anesthesiologist;
                $data['surgeon_ind']            = $request->surgeon;
                $data['emp_serial_in_salary_sheet']  = isset($request->emp_serial_in_salary_sheet) ? $request->emp_serial_in_salary_sheet : "";
            }



            if ($id == null) {


                $result =$request->last_card_no !=null? DB::table("hrms_personnel")->where('person_code', $request->last_card_no)->get() :[];

                if (!empty($result)) {
                    $message = ['msg' => "This employee already inserted in our system", 'title' => 'Error'];
                    return response()->json($message, 406);
                }

                $data['au_entry_by']   = $auth_id;
                $sequence              = DB::getSequence();
                $sysc_doctor_no_pk_seq = $sequence->nextValue('sysc_doctor_no_pk_seq');
                $data['person_no_pk']  = $sysc_doctor_no_pk_seq;
                $data['au_entry_by']   = $auth_id;
                $data['au_entry_at']   = date('Y-m-d H:i:s');
                DB::table('hrms_personnel')->insert($data);
                $last_id = $sysc_doctor_no_pk_seq;


                $insertData = array();
                if (!empty($request->visit_type_pk_no)) {
                    foreach ($request->visit_type_pk_no as $key => $value) {
                        if ($value && ($request->item_name[$key])) {
                            $check =  DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                                ->where('person_no_fk', '=', $last_id)->first();

                            if ($check) {
                                //update
                                DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                                    ->where('person_no_fk', '=', $last_id)
                                    ->update(['item_no_fk' => $request->item_id[$key]]);
                            } else {
                                //insert
                                $sequence = DB::getSequence();
                                $doctorFee_no_pk_seq = $sequence->nextValue('doctorfee_no_pk_seq');
                                $doctor_fee = [

                                    'doctorfee_no_pk' => $doctorFee_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'item_no_fk' => $request->item_id[$key],
                                    'visit_type_lookup_no_fk' => $value,
                                ];
                                DB::table('hrms_doctorfee')->insert($doctor_fee);
                            }
                        }
                    }
                }


                if ($request->employee == "EMP") {
                    if ($request->salary_ind != "") {

                        $sequence = DB::getSequence();
                        $salary_no_pk_seq = $sequence->nextValue('salary_no_pk_seq');
                        $dataSalary = [
                            "salary_no_pk"            => $salary_no_pk_seq,
                            "person_no_fk"            => $last_id,
                            "salary_factor"           => $request->salary_factor,
                            "grade_no_fk"             => $request->grade_factor,
                            'gross_salary'            => $request->gross_salary,
                            'basic_salary'            => $request->basic_salary,
                            'basic_salary_perc'       => $request->basic_salary_per,
                            'medical_allow'           => $request->medical_allowance,
                            'medical_allow_perc'      => $request->medical_allowance_per,
                            'house_rent'              => $request->house_rent,
                            'house_rent_perc'         => $request->house_rent_per,
                            'attendance_bonus'        => $request->attendance_bonus,
                            'conveyance_allow'        => $request->conveyance_allowance,
                            'conveyance_allow_perc'   => $request->Conveyance_allowance_per,
                            'utility_allow'           => $request->utility,
                            'utility_allow_perc'      => $request->utility_per,
                            'entertainment'           => $request->entertainment,
                            'entertainment_perc'      => $request->entertainment_per,
                            'festival_bonus'          => $request->festival_bonus,
                            'festival_bonus_perc'     => $request->festival_bonus_per,
                            'ta_da'                   => $request->ta_da,
                            'ta_da_perc'              => $request->ta_da_per,
                            'other_allow'             => $request->other_allowance,
                            'other_allow_perc'             => $request->other_allow_perc,
                            'pf_presonnel_amount'     => $request->total_wages,
                            'au_entry_session'        => "session",
                            'au_entry_hospital_pk_no' => $hospital_no_pk,
                            'personal_savings_amount' => $request->savings_amount,
                            'residence_fee'           => $request->residenceal_fee,
                            'daily_wages_amount'      => ($request->salary_factor == 'DAILYW') ? $request->daily_wages : "",
                            'daily_wages_ind'         => ($request->salary_factor == 'DAILYW') ? 1 : "",
                            'person_income_tax_ind'   => $request->income_tex_ind,
                            'status'                  => 1

                        ];

                        if (DB::table("income_tax_setup")->where('default_ind', 1)->exists()) {
                            $income_tax_setup = DB::table("income_tax_setup")->where('default_ind', 1)->first();

                            $basic_salary = $dataSalary['basic_salary'] * 12;

                            $half_of_basic = $dataSalary['basic_salary'] * $income_tax_setup->house_rent_law_1;

                            $yearly_house_rent = intval($dataSalary['house_rent'] * 12);

                            $yearly_medical_allow = intval($dataSalary['medical_allow'] * 12);

                            $medical_law_1_nrb = ($dataSalary['basic_salary'] * 12) * $income_tax_setup->medical_law_1;

                            $medical_law_2_nrb = intval($income_tax_setup->medical_law_2);

                            $conveyance_law_nrb = $income_tax_setup->conveyance_law_1;

                            $conveyancde_allow = ($dataSalary['conveyance_allow'] * 12);

                            $ta_da_law_nrb = $income_tax_setup->conveyance_law_1;

                            $ta_da_allow = ($dataSalary['ta_da'] * 12);

                            $house_rent_range_1 = intval($half_of_basic * 12);
                            $house_rent_range_2 =  intval($income_tax_setup->house_rent_law_2);
                            $house_rent_taxable_income = 0;
                            $medical_taxable_income = 0;
                            $conveyance_taxable_income = 0;
                            $ta_da_taxable_income = 0;

                            $house_rent_benefit = 0;
                            $medical_benefit = 0;

                            if ($house_rent_range_1 < $house_rent_range_2) {
                                $house_rent_benefit = $house_rent_range_1;
                            } else {
                                $house_rent_benefit = $house_rent_range_2;
                            }





                            if ($yearly_house_rent < $house_rent_benefit) {
                                $house_rent_taxable_income = 0;
                            } else {
                                $house_rent_taxable_income = ($yearly_house_rent - $house_rent_benefit);
                            }




                            if ($medical_law_1_nrb < $medical_law_2_nrb) {
                                $medical_benefit = $medical_law_1_nrb;
                            } else {
                                $medical_benefit = $medical_law_2_nrb;
                            }



                            if ($yearly_medical_allow < $medical_benefit) {

                                $medical_taxable_income = 0;
                            } else {

                                $medical_taxable_income = ($yearly_medical_allow - $medical_benefit);
                            }

                            if ($conveyancde_allow < $conveyance_law_nrb) {

                                $conveyance_taxable_income = 0;
                            } else {

                                $conveyance_taxable_income = ($conveyancde_allow - $conveyance_law_nrb);
                            }


                            if ($ta_da_allow < $ta_da_law_nrb) {

                                $ta_da_taxable_income = 0;
                            } else {

                                $ta_da_taxable_income = ($ta_da_allow - $ta_da_law_nrb);
                            }



                            $festival_bonus_taxable_income = intval($dataSalary['festival_bonus']);

                            $utility_texable_income = ($dataSalary['utility_allow'] * 12);

                            $entertainment_texable_income = ($dataSalary['entertainment'] * 12);

                            $attendance_bonus_texable_income = ($dataSalary['attendance_bonus'] * 12);

                            $other_allowance_texable_income = ($dataSalary['other_allow'] * 12);

                            $savings_amount = ($dataSalary['personal_savings_amount'] * 12);

                            $total_salary_taxable_income = ($basic_salary + $house_rent_taxable_income + $medical_taxable_income + $conveyance_taxable_income + $ta_da_taxable_income + $utility_texable_income + $entertainment_texable_income + $attendance_bonus_texable_income + $other_allowance_texable_income + $festival_bonus_taxable_income);

                            //dd($house_rent_taxable_income , $medical_taxable_income , $conveyance_taxable_income , $ta_da_taxable_income , $utility_texable_income , $entertainment_texable_income , $attendance_bonus_texable_income , $other_allowance_texable_income , $festival_bonus_taxable_income);

                            $tax_liability = 0;

                            $minimum_tax = 0;

                            if ($request->doctor_gender == 6 ||  $request->doctor_gender == 7) {

                                $minimum_tax = intval($income_tax_setup->tax_fee_amount + 50000);
                            } else {

                                $minimum_tax = intval($income_tax_setup->tax_fee_amount);
                            }


                            $next_three_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac);


                            $next_four_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac);


                            $next_five_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac) + intval($income_tax_setup->rem_next_four_lac);



                            if ($total_salary_taxable_income < $minimum_tax) {

                                $tax_liability += 0;
                            }


                            if (($total_salary_taxable_income > $minimum_tax)) {

                                $diff = ($total_salary_taxable_income - $minimum_tax);

                                if ($diff > $income_tax_setup->rem_next_one_lac) {
                                    $tax_liability += intval($income_tax_setup->rem_next_one_lac) * floatval($income_tax_setup->min_tax_percent);
                                } else {
                                    $tax_liability += intval($diff) * floatval($income_tax_setup->min_tax_percent);
                                }
                            }


                            if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_three_lac_tax))) {

                                $diff = ($total_salary_taxable_income - $next_three_lac_tax);

                                if ($diff > intval($income_tax_setup->rem_next_three_lac)) {
                                    $tax_liability += intval($income_tax_setup->rem_next_three_lac) * floatval($income_tax_setup->rem_next_three_lac_percent);
                                } else {
                                    $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_three_lac_percent);
                                }
                            }

                            if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_four_lac_tax))) {

                                $diff = ($total_salary_taxable_income - $next_four_lac_tax);

                                if ($diff > intval($income_tax_setup->rem_next_four_lac)) {
                                    $tax_liability += intval($income_tax_setup->rem_next_four_lac) * floatval($income_tax_setup->rem_next_four_lac_percent);
                                } else {
                                    $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_four_lac_percent);
                                }
                            }

                            if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_five_lac_tax))) {

                                $diff = ($total_salary_taxable_income - $next_five_lac_tax);
                                if ($diff > intval($income_tax_setup->rem_next_five_lac)) {
                                    $tax_liability += intval($income_tax_setup->rem_next_five_lac) * floatval($income_tax_setup->rem_next_five_lac_percent);
                                } else {
                                    $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_five_lac_percent);
                                }
                            }

                            $grater_than_next_five_lac = ($total_salary_taxable_income - $next_five_lac_tax);

                            if ($total_salary_taxable_income > ($next_five_lac_tax + 1)) {

                                $tax_liability += intval($grater_than_next_five_lac) * floatval($income_tax_setup->rem_next_everything_percent);
                            }

                            $tax_deduct = 0;
                            if ($savings_amount > 0) {

                                $tax_deduct = intval($savings_amount) * .15;
                            }

                            $tax_payable = ($tax_liability - $tax_deduct);


                            $dataSalary['person_income_tax'] = intval($tax_payable / 12);
                            $dataSalary['au_entry_by'] = $auth_id;
                            $dataSalary['au_entry_at'] = date("Y-m-d");
                            DB::table('hrms_personnel_salary')->insert($dataSalary);
                        }
                    }
                }

                if ($request->employee == "EMP") {
                    $edu_array_count = sizeof($request->input("name"));
                    $name = $request->input("name");
                    $major = $request->input("major");
                    $institution = $request->input("institution");
                    $result = $request->input("result");
                    $p_year = $request->input("p_year");
                    // dd($name,$institution, $result,$p_year );
                    if (isset($name)) {

                        for ($i = 0; $i < $edu_array_count; $i++) {
                            if ($name[$i] != null) {
                                $sequence = DB::getSequence();
                                $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                                $educationData = [
                                    "education_no_pk" => $education_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'degree_name' => (isset($name[$i])) ? $name[$i] : '',
                                    'major_sub_or_gr' => (isset($major)) ? $major[$i] : '',
                                    'institute_name' => (isset($institution[$i])) ? $institution[$i] : '',
                                    'passing_year' => (isset($p_year[$i])) ? $p_year[$i] : '',
                                    'result_text' => (isset($result[$i])) ?  $result[$i] : '',
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $educationData['au_entry_by'] = $auth_id;
                                $educationData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_personnel_education')->insert($educationData);
                            }
                        }
                    }
                }
                /*  DB::table('hrms_personnel_salary')->insert($dataSalary);*/
                $hospital_no =  Session::get('user.ses_hospital_no_pk');
                if ($request->doctor_email != "" && $request->input("password") != "" && $request->input("password2") != "") {
                    $user_sequence = DB::getSequence();
                    $user_no_pk_seq = $user_sequence->nextValue('wsec_user_user_no_pk_seq');
                    $dataUser = [
                        'user_no_pk' => $user_no_pk_seq,
                        'user_fullname' => $request->input("doctor_first_name"),
                        'user_name' => $request->input("user_name"),
                        'user_pass' => Hash::make($request->input("password")),
                        'user_name_access_code' => $request->input("password"),
                        'person_no_fk' => $last_id,
                        'status' => 1,
                        'email' => $request->input("doctor_email"),
                        'phone_mobile' => $request->doctor_mobile_no,
                        'hospital_no_pk' => Session::get('user.ses_hospital_no_pk'),
                        'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        'au_entry_hospital_pk_no' => $hospital_no,
                    ];
                    if($request->input('doctor_card_number') != null) $dataUser['user_code'] = $request->doctor_card_number;
                    if($request->input('user_type') != null) $dataUser['user_type'] = $request->user_type;
                    DB::table('wsec_user')->insert($dataUser);
                }


                $image_name = "";
                if ($files = $request->file('doc_photo')) {
                    $image_name = $last_id . "." . $files->getClientOriginalExtension();
                }

                $update_image['photo_name'] = $image_name;
                $this->baseRepository->update($update_image, $last_id);



                $image_signature = "";
                if ($files = $request->file('digital_signature')) {
                    $image_signature = $last_id . $random_text . "." . $files->getClientOriginalExtension();
                }
                $update_image['doctor_signature_image'] = $image_signature;
                $this->baseRepository->update($update_image, $last_id);



                // CV Update
                $cv_update = "";
                if ($files = $request->file('cv_entry')) {
                    $cv_update = $last_id . "." . $files->getClientOriginalExtension();
                }
                $update_image['cv_path'] = $cv_update;
                $this->baseRepository->update($update_image, $last_id);
            } else {

                //dd($data);

                $data['au_update_by'] = $auth_id;

                if ($files = $request->file('doc_photo')) {
                    $data['photo_name'] = $id . "." . $files->getClientOriginalExtension();
                }

                if ($files2 = $request->file('digital_signature')) {
                    $data['doctor_signature_image'] = $id . $random_text . "." . $files2->getClientOriginalExtension();
                }

                if ($files1 = $request->file('cv_entry')) {
                    $data['cv_path'] = $id . "." . $files1->getClientOriginalExtension();
                }
                $last_id = $id;
                DB::table('hrms_personnel')->where('person_no_pk', $last_id)->update($data);

                $doctor_user = Users::where("person_no_fk", $last_id)->first();
                $hospital_no =  Session::get('user.ses_hospital_no_pk');
                if (!empty($doctor_user)) {

                    if ($request->doctor_email != "" && $request->input("password") != "" && $request->input("password2") != "") {
                        $doctor_user = Users::find($doctor_user->user_no_pk);
                        $doctor_user->user_fullname = $request->input("doctor_first_name");
                        $doctor_user->user_name = $request->input("user_name");
                        $doctor_user->user_pass = Hash::make($request->input("password"));
                        $doctor_user->user_name_access_code = $request->input("password");
                        $doctor_user->person_no_fk = $last_id;
                        $doctor_user->status = 1;
                        $doctor_user->email = $request->input("doctor_email");
                        $doctor_user->phone_mobile = $request->doctor_mobile_no;
                        $doctor_user->au_entry_hospital_pk_no = $hospital_no;
                        $doctor_user->au_update_by = $auth_id;
                        if($request->input('doctor_card_number') != null) $doctor_user->user_code = $request->input("doctor_card_number");
                        if($request->input('user_type') != null) $doctor_user->user_type = $request->user_type;

                        $doctor_user->update();
                    } else {
                        $doctor_user = Users::find($doctor_user->user_no_pk);
                        $doctor_user->au_entry_hospital_pk_no = $hospital_no;
                        $doctor_user->au_update_by = $auth_id;
                        if($request->input('doctor_card_number') != null) $doctor_user->user_code = $request->input("doctor_card_number");
                        $doctor_user->update();
                    }
                } else {
                    $doctor_user = new Users();
                    $doctor_user->user_fullname = $request->input("doctor_first_name");
                    $doctor_user->user_name = $request->input("user_name");
                    $doctor_user->user_pass = Hash::make($request->input("password"));
                    $doctor_user->user_name_access_code = $request->input("password");
                    $doctor_user->person_no_fk = $last_id;
                    $doctor_user->status = 1;
                    $doctor_user->email = $request->input("doctor_email");
                    $doctor_user->phone_mobile = $request->doctor_mobile_no;
                    $doctor_user->au_entry_hospital_pk_no = $hospital_no;
                    if($request->input('doctor_card_number') != null) $doctor_user->user_code = $request->input("doctor_card_number");
                    if($request->input('user_type') != null) $doctor_user->user_type = $request->input("user_type");
                    $doctor_user->save();
                }

                $insertData = array();
                if (!empty($request->visit_type_pk_no)) {
                    foreach ($request->visit_type_pk_no as $key => $value) {
                        if ($value && ($request->item_name[$key])) {


                            $check =  DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                                ->where('person_no_fk', '=', $last_id)->first();

                            if ($check) {
                                //update
                                DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                                    ->where('person_no_fk', '=', $last_id)
                                    ->update(['item_no_fk' => $request->item_id[$key]]);
                            } else {
                                //insert
                                $sequence = DB::getSequence();
                                $doctorFee_no_pk_seq = $sequence->nextValue('doctorfee_no_pk_seq');
                                $doctor_fee = [

                                    'doctorfee_no_pk' => $doctorFee_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'item_no_fk' => $request->item_id[$key],
                                    'visit_type_lookup_no_fk' => $value,
                                ];
                                DB::table('hrms_doctorfee')->insert($doctor_fee);
                            }
                        }
                    }
                }


                if ($request->employee == "EMP") {

                    $salary_emp_id = DB::table('hrms_personnel_salary')->where('person_no_fk', $last_id)->first();

                    $dataSalary = [
                        "person_no_fk" => $last_id,
                        "salary_factor" => $request->salary_factor,
                        "grade_no_fk" => $request->grade_factor,
                        'gross_salary' => $request->gross_salary,
                        'basic_salary' => $request->basic_salary,
                        'basic_salary_perc' => $request->basic_salary_per,
                        'medical_allow' => $request->medical_allowance,
                        'medical_allow_perc' => $request->medical_allowance_per,
                        'house_rent' => $request->house_rent,
                        'house_rent_perc' => $request->house_rent_per,
                        'attendance_bonus' => $request->attendance_bonus,
                        'conveyance_allow' => $request->conveyance_allowance,
                        'conveyance_allow_perc' => $request->conveyance_allowance_per,
                        'utility_allow' => $request->utility,
                        'utility_allow_perc' => $request->utility_per,
                        'entertainment' => $request->entertainment,
                        'entertainment_perc' => $request->entertainment_per,
                        'festival_bonus' => $request->festival_bonus,
                        'festival_bonus_perc' => $request->festival_bonus_per,
                        'ta_da' => $request->ta_da,
                        'ta_da_perc' => $request->ta_da_per,
                        'other_allow' => $request->other_allowance,
                        'other_allow_perc' => $request->other_allow_perc,
                        'pf_presonnel_amount' => $request->total_wages,
                        'au_entry_session' => "session",
                        'au_entry_hospital_pk_no' => $hospital_no_pk,
                        'personal_savings_amount' => $request->savings_amount,
                        'residence_fee' => $request->residenceal_fee,
                        'daily_wages_amount' => ($request->salary_factor == 'DAILYW') ? $request->daily_wages : "",
                        'daily_wages_ind' => ($request->salary_factor == 'DAILYW') ? 1 : "",
                        'person_income_tax_ind' => $request->income_tex_ind,
                        'status' => 1
                    ];


                    if (DB::table("income_tax_setup")->where('default_ind', 1)->exists()) {
                        $income_tax_setup = DB::table("income_tax_setup")->where('default_ind', 1)->first();

                        $basic_salary = $dataSalary['basic_salary'] * 12;

                        $half_of_basic = $dataSalary['basic_salary'] * $income_tax_setup->house_rent_law_1;

                        $yearly_house_rent = intval($dataSalary['house_rent'] * 12);

                        $yearly_medical_allow = intval($dataSalary['medical_allow'] * 12);

                        $medical_law_1_nrb = ($dataSalary['basic_salary'] * 12) * $income_tax_setup->medical_law_1;

                        $medical_law_2_nrb = intval($income_tax_setup->medical_law_2);

                        $conveyance_law_nrb = $income_tax_setup->conveyance_law_1;

                        $conveyancde_allow = ($dataSalary['conveyance_allow'] * 12);

                        $ta_da_law_nrb = $income_tax_setup->conveyance_law_1;

                        $ta_da_allow = ($dataSalary['ta_da'] * 12);

                        $house_rent_range_1 = intval($half_of_basic * 12);
                        $house_rent_range_2 =  intval($income_tax_setup->house_rent_law_2);
                        $house_rent_taxable_income = 0;
                        $medical_taxable_income = 0;
                        $conveyance_taxable_income = 0;
                        $ta_da_taxable_income = 0;

                        $house_rent_benefit = 0;
                        $medical_benefit = 0;

                        if ($house_rent_range_1 < $house_rent_range_2) {
                            $house_rent_benefit = $house_rent_range_1;
                        } else {
                            $house_rent_benefit = $house_rent_range_2;
                        }





                        if ($yearly_house_rent < $house_rent_benefit) {
                            $house_rent_taxable_income = 0;
                        } else {
                            $house_rent_taxable_income = ($yearly_house_rent - $house_rent_benefit);
                        }




                        if ($medical_law_1_nrb < $medical_law_2_nrb) {
                            $medical_benefit = $medical_law_1_nrb;
                        } else {
                            $medical_benefit = $medical_law_2_nrb;
                        }



                        if ($yearly_medical_allow < $medical_benefit) {

                            $medical_taxable_income = 0;
                        } else {

                            $medical_taxable_income = ($yearly_medical_allow - $medical_benefit);
                        }

                        if ($conveyancde_allow < $conveyance_law_nrb) {

                            $conveyance_taxable_income = 0;
                        } else {

                            $conveyance_taxable_income = ($conveyancde_allow - $conveyance_law_nrb);
                        }


                        if ($ta_da_allow < $ta_da_law_nrb) {

                            $ta_da_taxable_income = 0;
                        } else {

                            $ta_da_taxable_income = ($ta_da_allow - $ta_da_law_nrb);
                        }



                        $festival_bonus_taxable_income = intval($dataSalary['festival_bonus']);

                        $utility_texable_income = ($dataSalary['utility_allow'] * 12);

                        $entertainment_texable_income = ($dataSalary['entertainment'] * 12);

                        $attendance_bonus_texable_income = ($dataSalary['attendance_bonus'] * 12);

                        $other_allowance_texable_income = ($dataSalary['other_allow'] * 12);

                        $savings_amount = ($dataSalary['personal_savings_amount'] * 12);

                        $total_salary_taxable_income = ($basic_salary + $house_rent_taxable_income + $medical_taxable_income + $conveyance_taxable_income + $ta_da_taxable_income + $utility_texable_income + $entertainment_texable_income + $attendance_bonus_texable_income + $other_allowance_texable_income + $festival_bonus_taxable_income);

                        //dd($house_rent_taxable_income , $medical_taxable_income , $conveyance_taxable_income , $ta_da_taxable_income , $utility_texable_income , $entertainment_texable_income , $attendance_bonus_texable_income , $other_allowance_texable_income , $festival_bonus_taxable_income);

                        $tax_liability = 0;


                        $minimum_tax = 0;

                        if ($request->doctor_gender == 6 ||  $request->doctor_gender == 7) {

                            $minimum_tax = intval($income_tax_setup->tax_fee_amount + 50000);
                        } else {

                            $minimum_tax = intval($income_tax_setup->tax_fee_amount);
                        }


                        $next_three_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac);


                        $next_four_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac);


                        $next_five_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac) + intval($income_tax_setup->rem_next_four_lac);



                        if ($total_salary_taxable_income < $minimum_tax) {

                            $tax_liability += 0;
                        }


                        if (($total_salary_taxable_income > $minimum_tax)) {

                            $diff = ($total_salary_taxable_income - $minimum_tax);

                            if ($diff > $income_tax_setup->rem_next_one_lac) {
                                $tax_liability += intval($income_tax_setup->rem_next_one_lac) * floatval($income_tax_setup->min_tax_percent);
                            } else {
                                $tax_liability += intval($diff) * floatval($income_tax_setup->min_tax_percent);
                            }
                        }


                        if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_three_lac_tax))) {

                            $diff = ($total_salary_taxable_income - $next_three_lac_tax);

                            if ($diff > intval($income_tax_setup->rem_next_three_lac)) {
                                $tax_liability += intval($income_tax_setup->rem_next_three_lac) * floatval($income_tax_setup->rem_next_three_lac_percent);
                            } else {
                                $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_three_lac_percent);
                            }
                        }

                        if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_four_lac_tax))) {

                            $diff = ($total_salary_taxable_income - $next_four_lac_tax);

                            if ($diff > intval($income_tax_setup->rem_next_four_lac)) {
                                $tax_liability += intval($income_tax_setup->rem_next_four_lac) * floatval($income_tax_setup->rem_next_four_lac_percent);
                            } else {
                                $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_four_lac_percent);
                            }
                        }

                        if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_five_lac_tax))) {

                            $diff = ($total_salary_taxable_income - $next_five_lac_tax);
                            if ($diff > intval($income_tax_setup->rem_next_five_lac)) {
                                $tax_liability += intval($income_tax_setup->rem_next_five_lac) * floatval($income_tax_setup->rem_next_five_lac_percent);
                            } else {
                                $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_five_lac_percent);
                            }
                        }

                        $grater_than_next_five_lac = ($total_salary_taxable_income - $next_five_lac_tax);

                        if ($total_salary_taxable_income > ($next_five_lac_tax + 1)) {

                            $tax_liability += intval($grater_than_next_five_lac) * floatval($income_tax_setup->rem_next_everything_percent);
                        }

                        $tax_deduct = 0;
                        if ($savings_amount > 0) {

                            $tax_deduct = intval($savings_amount) * .15;
                        }

                        $tax_payable = ($tax_liability - $tax_deduct);


                        $dataSalary['person_income_tax'] = intval($tax_payable / 12);
                    }


                    if ($salary_emp_id != null) {
                        $dataSalary['au_update_by'] = $auth_id;

                        DB::table('hrms_personnel_salary')->where("salary_no_pk", $request->salary_no_pk)->update($dataSalary);
                    } else {


                        if ($request->salary_ind != "") {

                            $sequence = DB::getSequence();
                            $salary_no_pk_seq = $sequence->nextValue('salary_no_pk_seq');
                            $dataSalary['salary_no_pk'] = $salary_no_pk_seq;
                            $dataSalary['au_entry_by'] = $auth_id;
                            $dataSalary['au_entry_at'] = date("Y-m-d");

                            DB::table('hrms_personnel_salary')->insert($dataSalary);
                        }
                    }
                }
                // $this->salaryRepository->update($dataSalary, $request->salary_no_pk);
                // dd($request->salary_no_pk);
                //education array
                if ($request->employee == "EMP") {
                    DB::table("hrms_personnel_education")->where("person_no_fk", $id)->delete();
                    $edu_array_count = sizeof($request->input("name"));
                    $name = $request->input("name");
                    $major = $request->input("major");
                    $institution = $request->input("institution");
                    $result = $request->input("result");
                    $p_year = $request->input("p_year");

                    //dd( $name,$institution,$result,$p_year, $major);
                    for ($i = 0; $i < $edu_array_count; $i++) {
                        if ($name[0] != 0) {
                            $sequence = DB::getSequence();
                            $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                            $educationData = [
                                "education_no_pk" => $education_no_pk_seq,
                                'person_no_fk' => $last_id,
                                'degree_name' => $name[$i],
                                'major_sub_or_gr' => $major[$i],

                                'institute_name' => $institution[$i + 1],
                                'passing_year' => $p_year[$i + 1],
                                'result_text' => $result[$i + 1],
                                'au_entry_session' => "session",
                                'au_entry_hospital_pk_no' => $hospital_no_pk
                            ];
                            $educationData['au_entry_by'] = $auth_id;
                            $educationData['au_entry_at'] = date("Y-m-d");
                            DB::table('hrms_personnel_education')->insert($educationData);
                        } else {
                            if ($name[$i] != '0') {
                                $sequence = DB::getSequence();
                                $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                                $educationData = [
                                    "education_no_pk" => $education_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'degree_name' => $name[$i],
                                    'major_sub_or_gr' => $major[$i],

                                    'institute_name' => $institution[$i],
                                    'passing_year' => $p_year[$i],
                                    'result_text' => $result[$i],
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $educationData['au_entry_by'] = $auth_id;
                                $educationData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_personnel_education')->insert($educationData);
                            }
                        }
                    }
                }
            }

            if ($files = $request->file('doc_photo')) {
                $this->uploadImages($files, $last_id, 'images/uploads/doctor_images/', 'images/uploads/doctor_images/thumb/');
            }

            if ($files1 = $request->file('digital_signature')) {
                $this->uploadImages($files1, $last_id . $random_text, 'images/uploads/doctor_images/', 'images/uploads/doctor_images/thumb/');
            }

            if ($files1 = $request->file('cv_entry')) {
                $this->uploadImages($files1, $last_id, 'images/uploads/cv/', 'images/uploads/cv/thumb/');
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function createOrUpdateV1($request, $id = null)
    {
        // dd($request->all());
        if ($request->card_type == 1) {
            $card_no = DB::table('hrms_personnel')->select('card_no')->where('card_type_ind', 1)->orderBy('person_no_pk', 'desc')->first();
            $card_no_sl = 10001;

            if (!empty($card_no)) {
                $card_no_sl = intval($card_no->card_no) + 1;
            }
            // dd($card_no, ($card_no_sl));
        } else {
            $card_no = DB::table('hrms_personnel')->select('card_no')->where('card_type_ind', 2)->orderBy('card_no', 'desc')->first();
            $card_no_sl = 11001;

            if (!empty($card_no)) {
                $card_no_sl = intval($card_no->card_no) + 1;
            }
        }

        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id        = Auth::id();
        DB::beginTransaction();

        $sequence              = DB::getSequence();
        $sysc_doctor_no_pk_seq = $sequence->nextValue('sysc_doctor_no_pk_seq');
        $last_id               = $sysc_doctor_no_pk_seq;
        $random_text = Str::random(10);
        try {
            if ($request->employee == "EMP" || $request->employee == "DOC") {
                $data = [
                    'person_code'                  => $request->last_card_no,
                    'card_no'                      => $request->last_card_no,
                    'salutation'                   => $request->doctor_salutation,
                    'full_name'                    => $request->doctor_first_name . ' ' . $request->doctor_last_name,
                    'fname'                        => $request->doctor_first_name,
                    'lname'                        => $request->doctor_last_name,
                    // 'full_name_bangla'             => $request->doctor_full_name_bangla,
                    'gender_lookup_no_fk'          => $request->doctor_gender,
                    'blood_group_lookup_no_fk'     => $request->doctor_blood_group,
                    'place_of_birth'               => $request->place_of_birth,
                    'marital_lookup_no_fk'         => $request->doctor_marital_status,
                    'religion_lookup_no_fk'        => $request->doctor_religion,
                    'passport_no'                  => $request->passport_no,
                    'passport_issue_date'          => ($request->issue_date != null) ? date("Y/M/d", strtotime($request->issue_date)) : null,
                    'passport_expire_date'         => ($request->expired_date != null) ? date("Y/M/d", strtotime($request->expired_date)) : null,
                    'passport_issue_place'         => $request->issue_place,
                    'nid_no'                       => $request->doctor_nid,
                    'nationality'                  => $request->doctor_nationality,
                    'pr_addr1'                     => $request->present_address,
                    'pr_addr_dist'                 => $request->doctor_present_district,
                    'pr_addr_thana'                => $request->doctor_pr_thana,
                    'pr_addr_country'              => $request->present_country,
                    'pe_addr1'                     => $request->doctor_parmanent_address,
                    'pe_addr_dist'                 => $request->doctor_par_district,
                    'pe_addr_thana'                => $request->doctor_pe_thana,
                    'pe_addr_country'              => $request->parmanent_country,
                    'father_name'                  => $request->doctor_father,
                    // 'father_name_bangla'           => $request->doctor_father_bangla,
                    'mother_name'                  => $request->doctor_mother,
                    // 'mother_name_bangla'           => $request->doctor_mother_bangla,
                    'spouse_name'                  => $request->doctor_spouse,
                    // 'spouse_name_bangla'           => $request->doctor_spouse_bangla,
                    'job_type_lookup_no_fk'        => $request->doctor_job_type,
                    'jobtitle_lookup_no_fk'        => $request->doctor_job_title,
                    'duty_roster_type'             => $request->roster_type,
                    'grade_no_fk'                  => $request->grade_no_fk,
                    'bank_name'                    => $request->bank_name,
                    'bank_acc_no'                  => $request->bank_acc_no,
                    'bank_acc_name'                => $request->bank_acc_name,
                    'acc_routing_no'               => $request->acc_routing_no,
                    // 'agent_banking_type'           => $request->agent_banking_type,
                    // 'agent_banking_no'             => $request->agent_banking_no,
                    // 'security_money_amount'        => $request->security_money,
                    // 'security_money_received_date' => ($request->receive_date != null) ? date('Y/M/d', strtotime($request->receive_date)) : null,
                    'serviceunit_no_fk'            => $request->doctor_ser_unit,
                    'join_date'                    => ($request->joining_date != null) ? date("Y-m-d", strtotime($request->joining_date)) : null,
                    // 'card_no'                      => ($request->doctor_card_number) ? $request->doctor_card_number : $request->uid,

                    'hr_type_lookup_no_fk'         => $request->doctor_hr_type,
                    'emp_type_lookup_no_fk'        => $request->emp_type,
                    'leave_category_lookup_no_fk'  => $request->leave_category,
                    'confirmation_status'          => $request->confirmation_status,
                    // 'accomodation_ind'             => $request->accommodation,
                    'transport_ind'                => $request->transport_ind,
                    'provident_fund_type'          => $request->provident_fund_type,
                    'ot_payable_ind'               => $request->ot_ind,
                    'inactivate_date'              => ($request->inactivate_date != null) ? date('Y/M/d', strtotime($request->inactivate_date)) : null,
                    'inactivate_resson'            => ($request->inactivate_resson != null) ? $request->inactivate_resson : '',
                    'emp_status'                   => ($request->emp_status != null) ? $request->emp_status : '',
                    // 'weekly_offday'                => $request->weekly_offday,
                    'area_no_pk'                   => $request->coverage_area,
                    'employee_ind'                 => $request->employee_ind,
                    'doctor_ind'                   => $request->doctor_ind,
                    'salary_ind'                   => $request->salary_ind,
                    // 'doc_chamber_day_sat'          => ($request->saturday) ? $request->saturday : 0,
                    // 'doc_chamber_day_sun'          => ($request->sunday) ? $request->sunday : 0,
                    // 'doc_chamber_day_mon'          => ($request->monday) ? $request->monday : 0,
                    // 'doc_chamber_day_tue'          => ($request->tuesday) ? $request->tuesday : 0,
                    // 'doc_chamber_day_wed'          => ($request->wednesday) ? $request->wednesday : 0,
                    // 'doc_chamber_day_thu'          => ($request->thursday) ? $request->thursday : 0,
                    // 'doc_chamber_day_fri'          => ($request->friday) ? $request->friday : 0,
                    'doc_chamber_time_txt'         => $request->time_text,
                    'remarks_text'                 => $request->doctor_remarks,
                    'hospital_name'                => $request->hos_name,
                    'chamber_hospital_no_pk'       => $request->hos_name,
                    'hospital_address'             => $request->consultent_addr,
                    'chamber_schedule_time'        => $request->chamber_time,
                    'chamber_schedule_days'        => $request->chamber_days,
                    'contact_number'               => $request->doctor_mobile_no,
                    'phone_mobile'                 => $request->doctor_mobile_no,
                    'email_personal'               => $request->doctor_email,
                    'doc_lic_no'                   => $request->doctor_lic_no,
                    'license_issue_date'           => $request->doctor_lic_issue_date != null ? date("Y/m/d", strtotime($request->doctor_lic_issue_date)) : "",
                    'referral_agent_ind'           => ($request->marketing_type) ? $request->marketing_type : '',
                    'referal_ind'                  => ($request->referral_ind) ? 1 : '',
                    // 'mpo_ind'                   => ($request->mpo_ind) ? 1 : '',
                    // 'specialization_lookup_no_fk'  => $request->doctor_specialization,
                    // 'doctor_signature'             => $request->doctor_signature,
                    'dob'                          => ($request->doctor_date_of_birth != null) ? date("Y/m/d", strtotime($request->doctor_date_of_birth)) : null,
                    'bonus_elig_ind'               => ($request->bonus_eligibility) ? 1 : 0,
                    // 'apps_user_ind'                => ($request->apps_user) ? 1 : "",
                    // 'agent_access_code'            => $request->passcode,
                    // 'referral_payable_ind'         => $request->payable_ind,
                    'au_entry_hospital_pk_no'      => Session::get('user.ses_hospital_no_pk'),
                    // 'digital_signature_ind'        => $request->digital_signature_ind,
                    'status'                       => ($request->status_ind) ? 0 : 1,
                    'internal_doctor_ind'          => ($request->internal_doc_ind) ? 1 : 0,
                    'external_doctor_ind'          => ($request->external_doc_ind) ? 1 : 0,
                    'emp_serial_in_salary_sheet'   => $request->emp_serial_in_salary_sheet,
                    'registration_name'            => isset($request->registration_name) ? $request->registration_name : '',
                    'registration_no'              => isset($request->registration_no) ? $request->registration_no : '',
                    'registration_date'            => isset($request->registration_date) ? date("Y/m/d", strtotime($request->registration_date)) : "",
                    'registration_update_date'     => isset($request->registration_update_date) ? date("Y/m/d", strtotime($request->registration_update_date)) : "",
                    'emp_hod1_person_no_fk'        => isset($request->emp_hod1_person_no_fk) ? $request->emp_hod1_person_no_fk : "",
                    'emp_hod2_person_no_fk'        => isset($request->emp_hod2_person_no_fk) ? $request->emp_hod2_person_no_fk : "",
                    'emp_supvisor1_person_no_fk'   => isset($request->emp_supvisor1_person_no_fk) ? $request->emp_supvisor1_person_no_fk : '',
                    'emp_supvisor2_person_no_fk'   => isset($request->emp_supvisor2_person_no_fk) ? $request->emp_supvisor2_person_no_fk : '',
                    'contract_start_date'          => isset($request->contract_start_date) ? date("Y/m/d", strtotime($request->contract_start_date)) : "",
                    'contract_end_date'            => isset($request->contract_end_date) ? date("Y/m/d", strtotime($request->contract_end_date)) : "",
                    'transfer_date'                => isset($request->transfer_date) ? date("Y/m/d", strtotime($request->transfer_date)) : "",
                    'confirmation_date'            => isset($request->confirmation_date) ? date("Y/m/d", strtotime($request->confirmation_date)) : "",
                    'transfer_by'                  => $auth_id,
                    'confirmation_by'              => $auth_id,
                    'is_contractual_job_ind'       => isset($request->is_contractual_job_ind) ? '1' : '0',
                    'is_contact_renew_ind'         => isset($request->is_contact_renew_ind) ? '1' : '0',
                    'uniform_ind'                  => isset($request->is_uniform) ? '1' : '0',
                    'att_avl_ind'                  => isset($request->att_avl_ind) ? '1' : '0',
                    'ot_payable_ind'               => isset($request->ot_ind) ? '1' : '0',
                    'job_description_txt'          => isset($request->job_description_txt) ? $request->job_description_txt : '',
                    'emp_reference'                => isset($request->emp_reference) ? $request->emp_reference : '',
                    'serviceunit_no_fk_dept'       => isset($request->serviceunit_no_fk_dept) ? $request->serviceunit_no_fk_dept : '',
                    'job_nature_lookup_no_fk'      => isset($request->job_nature_lookup_no_fk) ? $request->job_nature_lookup_no_fk : '',
                    'bank_look_up_data_fk'         => isset($request->bank) ? $request->bank : '',
                    'card_type_ind'                => isset($request->card_type) ? $request->card_type : '',
                    'trans_desig_lookup_no_fk'     => isset($request->conveyance_eligibility) ? $request->conveyance_eligibility : '',
                    'nid_name'     => isset($request->doctor_nid_name) ? $request->doctor_nid_name : '',
                    'drivinglc_no'     => isset($request->drivinglc_no) ? $request->drivinglc_no : '',
                    'drivelc_issue_date'     => isset($request->drivelc_issue_date) ? $request->drivelc_issue_date : '',
                    'drivelc_expiry_date'     => isset($request->drivelc_expiry_date) ? $request->drivelc_expiry_date : '',
                    'birth_certi_ind'     => isset($request->birth_certi_ind) ? $request->birth_certi_ind : '',
                    'registration_type'     => isset($request->registration_type) ? $request->registration_type : '',
                    'emergency_contact_contact' => isset($request->emergency_contact_contact) ? $request->emergency_contact_contact : '',
                    'emergency_contact_name' => isset($request->emergency_contact_name) ? $request->emergency_contact_name : '',
                    'emergency_contact_relation' => isset($request->emergency_contact_relation) ? $request->emergency_contact_relation : '',
                    'emergency_contact_addr' => isset($request->emergency_contact_addr) ? $request->emergency_contact_addr : '',
                    'ini_jobtitle_lookup_no_fk' => isset($request->ini_doctor_job_title) ? $request->ini_doctor_job_title : '',
                    'ffs_doctor_ind'          => ($request->ffs_doc_ind) ? 1 : 0,
                ];
            }


            if ($request->doctor_job_type == 41) {
                $data['doctor_ind'] = 1;
            }

            // if ($request->employee == "EMP") {
            //     $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
            //     $data['inv_hod_ind']            = $request->inv_hod_ind;
            //     $data['inv_auth_admin_ind']     = $request->inv_auth_admin_ind;
            //     $data['inv_auth_director_ind']  = $request->inv_auth_director_ind;
            //     $data['inv_auth_chairman_ind']  = $request->inv_auth_chairman_ind;
            //     $data['inv_director_admin_ind'] = $request->inv_director_admin_ind;
            //     $data['inv_director_acc_ind']   = $request->inv_director_acc_ind;
            //     $data['inv_gen_man_proc_ind']   = $request->inv_gen_man_proc_ind;
            //     $data['inv_manager_acc_ind']    = $request->inv_manager_acc_ind;
            //     $data['inv_proc_ind']           = $request->inv_proc_ind;
            //     $data['inv_store_ind']          = $request->inv_store_ind;
            //     $data['emp_serial_in_salary_sheet']  = isset($request->emp_serial_in_salary_sheet) ? $request->emp_serial_in_salary_sheet : "";
            // }

            // if ($request->employee == "DOC") {
            //     $data['ref_agent_person_no_fk'] = $request->hdn_referrence_name;
            //     $data['doctor_ind']             =  isset($request->doctor_ind) ? 1 : 0;
            //     $data['anaestesiologis_ind']    = $request->anesthesiologist;
            //     $data['surgeon_ind']            = $request->surgeon;
            //     $data['emp_serial_in_salary_sheet']  = isset($request->emp_serial_in_salary_sheet) ? $request->emp_serial_in_salary_sheet : "";
            // }



            if ($id == null) {

                $result = DB::table("hrms_personnel")->where('card_no', $request->last_card_no)->get();

                if (!$result->isEmpty()) {
                    $message = ['msg' => "This employee already inserted in our system", 'title' => 'Error'];
                    return response()->json($message, 406);
                }
                // $data['card_no'] =  $card_no_sl;
                $data['au_entry_by']   = $auth_id;
                $sequence              = DB::getSequence();
                $sysc_doctor_no_pk_seq = $sequence->nextValue('sysc_doctor_no_pk_seq');
                $data['person_no_pk']  = $sysc_doctor_no_pk_seq;
                $data['au_entry_by']   = $auth_id;
                $data['au_entry_at']   = date('Y-m-d H:i:s');
                // dd($data);
                DB::table('hrms_personnel')->insert($data);

                $last_id = $sysc_doctor_no_pk_seq;

                  // User Credentials
                    $user_sequence = DB::getSequence();
                    $user_no_pk_seq = $user_sequence->nextValue('wsec_user_user_no_pk_seq');
                    $dataUser = [
                        'user_no_pk' => $user_no_pk_seq,
                        'user_code' => $request->last_card_no,
                        'user_fullname' => $request->input("doctor_first_name"),
                        'user_name' => $request->input("doctor_first_name"),
                        'user_pass' => Hash::make(123456),
                        'user_name_access_code' => $request->last_card_no,
                        'person_no_fk' => $last_id,
                        'status' => 1,
                        'email' => $request->input("doctor_email"),
                        'phone_mobile' => $request->doctor_mobile_no,
                        'hospital_no_pk' => Session::get('user.ses_hospital_no_pk'),
                        'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        // 'user_type' => $request->user_type
                    ];
                    DB::table('wsec_user')->insert($dataUser);


                //Fringe Benefit
                if ($request->employee == "EMP") {
                    $fringe_benefit_array_count = sizeof($request->input("benefit_name"));
                    $benefit_name = $request->input("benefit_name");
                    // $benefit_amount = intval($request->input("benefit_amount"));
                    $benefit_amount = $request->input("benefit_amount");
                    $benefit_eff_date = $request->input("benefit_eff_date");
                    if (isset($benefit_name)) {

                        for ($i = 0; $i < $fringe_benefit_array_count; $i++) {
                            if (!empty($benefit_name[$i])) {
                                $sequence = DB::getSequence();
                                $fringe_benefit_no_pk_seq = $sequence->nextValue('fringe_benefit_no_pk_seq');
                                $fringeBenefitData = [
                                    "fringe_benefit_no_pk" => $fringe_benefit_no_pk_seq,
                                    'person_no_fk'         => $last_id,
                                    'fringe_lookup_no_fk'  => (isset($benefit_name[$i])) ? $benefit_name[$i] : '',
                                    'amount'               => (isset($benefit_amount[$i])) ? $benefit_amount[$i] : '',
                                    'effective_date'       => (isset($benefit_eff_date[$i])) ? date('Y/m/d', strtotime($benefit_eff_date[$i])) : '',
                                    'status'               => 1,
                                    'au_entry_session'     => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by'          => $auth_id,
                                    'au_entry_at'          => date("Y-m-d"),
                                ];

                                DB::table('hrms_fringe_benefit')->insert($fringeBenefitData);
                            }
                        }
                    }
                }


                if ($request->employee == "EMP") {
                    $dependent_array_count = sizeof($request->input("dependent_name"));
                    $dependent_name = $request->input("dependent_name");
                    $dependent_nid = $request->input("dependent_nid");
                    $dependent_dob = $request->input("dependent_dob");
                    $dependent_relationship = $request->input("dependent_relationship");
                    $dependent_photos = $request->file('dependent_photo');

                    if (isset($dependent_name)) {
                        for ($i = 0; $i < $dependent_array_count; $i++) {
                            if (!empty($dependent_name[$i])) {
                                $sequence = DB::getSequence();
                                $dependent_info_pk_seq = $sequence->nextValue('dependent_info_pk_seq');

                                $dependentimage = isset($dependent_photos[$i]) ? $dependent_photos[$i] : null;

                                if ($dependentimage) {
                                    $dependentimageFileName = time() . '.' . $dependentimage->extension();
                                    $dependentimage->move(public_path('uploads/Dependent'), $dependentimageFileName);
                                } else {
                                    $dependentimageFileName = '';
                                }

                                $dependentData = [
                                    "dependent_info_pk" => $dependent_info_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'dependent_name' => $dependent_name[$i],
                                    'dependent_nid' => isset($dependent_nid[$i]) ? $dependent_nid[$i] : '',
                                    // 'dependent_dob' => isset($dependent_dob[$i]) ? date('Y/m/d', strtotime($dependent_dob[$i])) : '',
                                    'dependent_dob' => ($dependent_dob[$i] != null) ? date("Y/M/d", strtotime($dependent_dob[$i])) : null,
                                    'relationship' => isset($dependent_relationship[$i]) ? $dependent_relationship[$i] : '',
                                    'photo' => 'dependent' . $dependentimageFileName,
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by' => $auth_id,
                                    'au_entry_at' => date("Y-m-d"),
                                ];
                                DB::table('hrms_dependent_info')->insert($dependentData);
                            }
                        }
                    }
                }

                if ($request->employee == "EMP") {
                    $nominee_array_count = sizeof($request->input("nominee_name"));
                    $nominee_name = $request->input("nominee_name");
                    $nominee_nid = $request->input("nominee_nid");
                    $nominee_dob = $request->input("nominee_dob");
                    $nominee_relationship = $request->input("nominee_relationship");
                    $nominee_photos = $request->file('nominee_photo');

                    if (isset($nominee_name)) {
                        for ($i = 0; $i < $nominee_array_count; $i++) {
                            if ($nominee_name[$i] != null) {
                                $sequence = DB::getSequence();
                                $nominee_info_pk_seq = $sequence->nextValue('nominee_info_pk_seq');
                                $image = isset($nominee_photos[$i]) ? $nominee_photos[$i] : null;

                                if ($image) {
                                    $imageFileName = time() . '.' . $image->extension();
                                    $image->move(public_path('uploads/Nominee'), $imageFileName);
                                } else {
                                    $imageFileName = '';
                                }

                                $nomineeData = [
                                    "nominee_info_pk" => $nominee_info_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'nominee_name' => $nominee_name[$i],
                                    'nominee_nid' => isset($nominee_nid[$i]) ? $nominee_nid[$i] : '',
                                    // 'nominee_dob' => isset($nominee_dob[$i]) ? date('Y/m/d', strtotime($nominee_dob[$i])) : '',
                                    'nominee_dob' => ($nominee_dob[$i] != null) ? date("Y/M/d", strtotime($nominee_dob[$i])) : null,
                                    'relationship' => isset($nominee_relationship[$i]) ? $nominee_relationship[$i] : '',
                                    'photo' => 'nominee' . $imageFileName,
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by' => $auth_id,
                                    'au_entry_at' => date("Y-m-d"),
                                ];

                                DB::table('hrms_nominee_info')->insert($nomineeData);
                            }
                        }
                    }
                }



                if ($request->employee == "EMP") {
                    $edu_array_count = sizeof($request->input("name"));
                    $name = $request->input("name");
                    $major = $request->input("major");
                    $institution = $request->input("institution");
                    $result = $request->input("result");
                    $p_year = $request->input("p_year");

                    if (isset($name)) {
                        for ($i = 0; $i < $edu_array_count; $i++) {
                            if (!empty($name[$i])) {
                                $sequence = DB::getSequence();
                                $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                                $educationData = [
                                    "education_no_pk" => $education_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'degree_name' => $name[$i],
                                    'major_sub_or_gr' => $major[$i],
                                    'institute_name' => isset($institution[$i]) ? $institution[$i] : '',
                                    'passing_year' => isset($p_year[$i]) ? $p_year[$i] : '',
                                    'result_text' => isset($result[$i]) ? $result[$i] : '',
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by' => $auth_id,
                                    'au_entry_at' => date("Y-m-d"),
                                ];
                                DB::table('hrms_personnel_education')->insert($educationData);
                            }
                        }
                    }
                }


                if ($request->employee == "EMP") {
                    $we_array_count = sizeof($request->input("we_organization_name"));
                    $we_organization_name = $request->input("we_organization_name");
                    $we_designation = $request->input("we_designation");
                    $we_start_date = $request->input("we_start_date");
                    $we_end_date = $request->input("we_end_date");

                    if (isset($we_organization_name)) {
                        for ($i = 0; $i < $we_array_count; $i++) {
                            if (!empty($we_organization_name[$i])) {
                                $sequence = DB::getSequence();
                                $experience_no_pk_seq = $sequence->nextValue('experience_no_pk_seq');
                                $experienceData = [
                                    "experience_no_pk" => $experience_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'company_name' => $we_organization_name[$i],
                                    'designation_name' => isset($we_designation[$i]) ? $we_designation[$i] : '',
                                    // 'emp_from_date' => isset($we_start_date[$i]) ? date('d-m-Y', strtotime($we_start_date[$i])) : '',
                                    'emp_from_date' => ($request->we_start_date[$i] != null) ? date("Y/M/d", strtotime($request->we_start_date[$i])) : null,
                                    // 'emp_to_date' => isset($we_end_date[$i]) ?  date('d-m-Y', strtotime($we_end_date[$i])) : '',
                                    'emp_to_date' => ($request->we_end_date[$i] != null) ? date("Y/M/d", strtotime($request->we_end_date[$i])) : null,
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by' => $auth_id,
                                    'au_entry_at' => date("Y-m-d"),
                                ];
                                DB::table('hrms_personnel_experience')->insert($experienceData);
                            }
                        }
                    }
                }



                // if ($request->employee == "EMP") {
                //     $trainig_array_count = sizeof($request->tc_title);
                //     $tc_title = $request->input('tc_title');
                //     $tc_institute_name = $request->input('tc_institute_name');
                //     $tc_start_date = $request->input('tc_start_date');
                //     $tc_end_date = $request->input('tc_end_date');
                //     $tc_duration = $request->input('tc_duration');
                //     $tc_certificate_link = $request->input('tc_certificate_link');

                //     if (isset($request->tc_title)) {
                //         for ($i = 0; $i < $trainig_array_count; $i++) {
                //             if (!empty($tc_title[$i])) {
                //                 $sequence = DB::getSequence();
                //                 $cert_tr_no_pk_seq = $sequence->nextValue('cert_tr_no_pk_seq');

                //                 $tc_image = $request->file('tc_attachment')[$i];
                //                 $tcImageFileName = time() . '.' . $tc_image->extension();

                //                 $tc_image->move(public_path('uploads/Training_certificates'), $tcImageFileName);
                //                 $trainingData = [
                //                     "cert_tr_no_pk"  => $cert_tr_no_pk_seq,
                //                     'person_no_fk'   => $last_id,
                //                     'cert_tr_tittle' => isset($tc_title[$i]) ? $tc_title[$i] : '',

                //                     'institute_name'  => isset($tc_institute_name[$i]) ? $tc_institute_name[$i] : '',
                //                     'emp_from_date'  => isset($tc_start_date[$i]) ? date('Y/m/d', strtotime($tc_start_date[$i])) : '',
                //                     'tr_cert_file'   => 'training_certificate' . $tcImageFileName[$i],
                //                     'emp_to_date'  => isset($tc_end_date[$i]) ? date('Y/m/d', strtotime($tc_end_date[$i])) : '',
                //                     'training_duration' => isset($tc_duration[$i]) ? $tc_duration[$i] : '',
                //                     'tr_cert_url' => isset($tc_certificate_link[$i]) ? $tc_certificate_link[$i] : '',
                //                     'au_entry_session' => "session",
                //                     'au_entry_hospital_pk_no' => $hospital_no_pk,
                //                     'au_entry_by' => $auth_id,
                //                     'au_entry_at' => date("Y-m-d"),
                //                 ];
                //                 DB::table('hrms_personnel_cert_tr')->insert($trainingData);
                //             }
                //         }
                //     }
                // }

                if ($request->employee == "EMP") {
                    $trainig_array_count = sizeof($request->tc_title);
                    $tc_title = $request->input('tc_title');
                    $tc_institute_name = $request->input('tc_institute_name');
                    $tc_start_date = $request->input('tc_start_date');
                    $tc_end_date = $request->input('tc_end_date');
                    $tc_duration = $request->input('tc_duration');
                    $tc_certificate_link = $request->input('tc_certificate_link');
                    $tc_attachments = $request->file('tc_attachment');

                    if (isset($request->tc_title)) {
                        for ($i = 0; $i < $trainig_array_count; $i++) {
                            if (!empty($tc_title[$i])) {
                                $sequence = DB::getSequence();
                                $cert_tr_no_pk_seq = $sequence->nextValue('cert_tr_no_pk_seq');

                                $tc_image = isset($tc_attachments[$i]) ? $tc_attachments[$i] : null;

                                if ($tc_image) {
                                    $tcImageFileName = time() . '.' . $tc_image->extension();
                                    $tc_image->move(public_path('uploads/Training_certificates'), $tcImageFileName);
                                } else {
                                    $tcImageFileName = '';
                                }

                                $trainingData = [
                                    "cert_tr_no_pk" => $cert_tr_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'cert_tr_tittle' => isset($tc_title[$i]) ? $tc_title[$i] : '',
                                    'institute_name' => isset($tc_institute_name[$i]) ? $tc_institute_name[$i] : '',
                                    // 'emp_from_date' => isset($tc_start_date[$i]) ? date('Y/m/d', strtotime($tc_start_date[$i])) : '',
                                    'emp_from_date' => ($tc_start_date[$i] != null) ? date("Y/M/d", strtotime($tc_start_date[$i])) : null,
                                    // 'emp_to_date' => isset($tc_end_date[$i]) ? date('Y/m/d', strtotime($tc_end_date[$i])) : '',
                                    'emp_to_date' => ($tc_end_date[$i] != null) ? date("Y/M/d", strtotime($tc_end_date[$i])) : null,
                                    'tr_cert_file' => 'training_certificate' . $tcImageFileName,
                                    'training_duration' => isset($tc_duration[$i]) ? $tc_duration[$i] : '',
                                    'tr_cert_url' => isset($tc_certificate_link[$i]) ? $tc_certificate_link[$i] : '',
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk,
                                    'au_entry_by' => $auth_id,
                                    'au_entry_at' => date("Y-m-d"),
                                ];

                                DB::table('hrms_personnel_cert_tr')->insert($trainingData);
                            }
                        }
                    }
                }




                /*  DB::table('hrms_personnel_salary')->insert($dataSalary);*/
                // $hospital_no =  Session::get('user.ses_hospital_no_pk');
                // if ($request->doctor_email != "" && $request->input("password") != "" && $request->input("password2") != "") {
                //     $user_sequence = DB::getSequence();
                //     $user_no_pk_seq = $user_sequence->nextValue('wsec_user_user_no_pk_seq');
                //     $dataUser = [
                //         'user_no_pk' => $user_no_pk_seq,
                //         'user_code' => $request->doctor_card_number,
                //         'user_fullname' => $request->input("doctor_first_name"),
                //         'user_name' => $request->input("user_name"),
                //         'user_pass' => Hash::make($request->input("password")),
                //         'user_name_access_code' => $request->input("password"),
                //         'person_no_fk' => $last_id,
                //         'status' => 1,
                //         'email' => $request->input("doctor_email"),
                //         'phone_mobile' => $request->doctor_mobile_no,
                //         'hospital_no_pk' => Session::get('user.ses_hospital_no_pk'),
                //         'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                //         'user_type' => $request->user_type,
                //         'au_entry_hospital_pk_no' => $hospital_no,


                //     ];
                //     DB::table('wsec_user')->insert($dataUser);
                // }


                $image_name = "";
                if ($files = $request->file('doc_photo')) {
                    $image_name = $last_id . "." . $files->getClientOriginalExtension();
                }

                $update_image['photo_name'] = $image_name;
                $this->baseRepository->update($update_image, $last_id);



                $image_signature = "";
                if ($files = $request->file('digital_signature')) {
                    $image_signature = $last_id . $random_text . "." . $files->getClientOriginalExtension();
                }
                $update_image['doctor_signature_image'] = $image_signature;
                $this->baseRepository->update($update_image, $last_id);



                // CV Update
                $cv_update = "";
                if ($files = $request->file('cv_entry')) {
                    $cv_update = $last_id . "." . $files->getClientOriginalExtension();
                }
                $update_image['cv_path'] = $cv_update;
                $this->baseRepository->update($update_image, $last_id);
            } else {

                //dd($data);
                // $data['card_no'] =  $request->hdn_card_number;
                $data['au_update_by'] = $auth_id;
                if ($files = $request->file('doc_photo')) {
                    $data['photo_name'] = $id . "." . $files->getClientOriginalExtension();
                }

                if ($files2 = $request->file('digital_signature')) {
                    $data['doctor_signature_image'] = $id . $random_text . "." . $files2->getClientOriginalExtension();
                }

                if ($files1 = $request->file('cv_entry')) {
                    $data['cv_path'] = $id . "." . $files1->getClientOriginalExtension();
                }
                $last_id = $id;
                DB::table('hrms_personnel')->where('person_no_pk', $last_id)->update($data);

                $doctor_user = Users::where("person_no_fk", $last_id)->first();
                $hospital_no =  Session::get('user.ses_hospital_no_pk');
                // doctor_signature
                // if (!empty($doctor_user)) {

                //     if ($request->doctor_email != "" && $request->input("password") != "" && $request->input("password2") != "") {
                //         $doctor_user = Users::find($doctor_user->user_no_pk);
                //         $doctor_user->user_fullname = $request->input("doctor_first_name");
                //         // $doctor_user->user_code = $request->input("doctor_card_number");
                //         $doctor_user->user_name = $request->input("user_name");
                //         $doctor_user->user_pass = Hash::make($request->input("password"));
                //         $doctor_user->user_name_access_code = $request->input("password");
                //         $doctor_user->person_no_fk = $last_id;
                //         $doctor_user->status = 1;
                //         $doctor_user->email = $request->input("doctor_email");
                //         $doctor_user->phone_mobile = $request->doctor_mobile_no;
                //         $doctor_user->user_type = $request->user_type;
                //         $doctor_user->au_entry_hospital_pk_no = $hospital_no;

                //         $doctor_user->update();
                //     } else {
                //         $doctor_user = Users::find($doctor_user->user_no_pk);
                //         // $doctor_user->user_code = $request->input("doctor_card_number");
                //         $doctor_user->au_entry_hospital_pk_no = $hospital_no;
                //         $doctor_user->update();
                //     }
                // } else {

                //     $doctor_user = new Users();
                //     $doctor_user->user_fullname = $request->input("doctor_first_name");
                //     // $doctor_user->user_code = $request->input("doctor_card_number");
                //     $doctor_user->user_name = $request->input("user_name");
                //     $doctor_user->user_pass = Hash::make($request->input("password"));
                //     $doctor_user->user_name_access_code = $request->input("password");
                //     $doctor_user->person_no_fk = $last_id;
                //     $doctor_user->status = 1;
                //     $doctor_user->email = $request->input("doctor_email");
                //     $doctor_user->phone_mobile = $request->doctor_mobile_no;
                //     $doctor_user->user_type = $request->user_type;
                //     $doctor_user->au_entry_hospital_pk_no = $hospital_no;
                //     $doctor_user->save();
                // }

                $insertData = array();
                // if (!empty($request->visit_type_pk_no)) {
                //     foreach ($request->visit_type_pk_no as $key => $value) {
                //         if ($value && ($request->item_name[$key])) {


                //             $check =  DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                //                 ->where('person_no_fk', '=', $last_id)->first();

                //             if ($check) {
                //                 //update
                //                 DB::table('hrms_doctorfee')->where('visit_type_lookup_no_fk', '=', $value)
                //                     ->where('person_no_fk', '=', $last_id)
                //                     ->update(['item_no_fk' => $request->item_id[$key]]);
                //             } else {
                //                 //insert
                //                 $sequence = DB::getSequence();
                //                 $doctorFee_no_pk_seq = $sequence->nextValue('doctorfee_no_pk_seq');
                //                 $doctor_fee = [

                //                     'doctorfee_no_pk' => $doctorFee_no_pk_seq,
                //                     'person_no_fk' => $last_id,
                //                     'item_no_fk' => $request->item_id[$key],
                //                     'visit_type_lookup_no_fk' => $value,
                //                 ];
                //                 DB::table('hrms_doctorfee')->insert($doctor_fee);
                //             }
                //         }
                //     }
                // }


                // if ($request->employee == "EMP") {

                //     $salary_emp_id = DB::table('hrms_personnel_salary')->where('person_no_fk', $last_id)->first();

                //     $dataSalary = [
                //         "person_no_fk" => $last_id,
                //         "salary_factor" => $request->salary_factor,
                //         "grade_no_fk" => $request->grade_factor,
                //         'gross_salary' => $request->gross_salary,
                //         'basic_salary' => $request->basic_salary,
                //         'basic_salary_perc' => $request->basic_salary_per,
                //         'medical_allow' => $request->medical_allowance,
                //         'medical_allow_perc' => $request->medical_allowance_per,
                //         'house_rent' => $request->house_rent,
                //         'house_rent_perc' => $request->house_rent_per,
                //         'attendance_bonus' => $request->attendance_bonus,
                //         'conveyance_allow' => $request->conveyance_allowance,
                //         'conveyance_allow_perc' => $request->conveyance_allowance_per,
                //         'utility_allow' => $request->utility,
                //         'utility_allow_perc' => $request->utility_per,
                //         'entertainment' => $request->entertainment,
                //         'entertainment_perc' => $request->entertainment_per,
                //         'festival_bonus' => $request->festival_bonus,
                //         'festival_bonus_perc' => $request->festival_bonus_per,
                //         'ta_da' => $request->ta_da,
                //         'ta_da_perc' => $request->ta_da_per,
                //         'other_allow' => $request->other_allowance,
                //         'other_allow_perc' => $request->other_allow_perc,
                //         'pf_presonnel_amount' => $request->total_wages,
                //         'au_entry_session' => "session",
                //         'au_entry_hospital_pk_no' => $hospital_no_pk,
                //         'personal_savings_amount' => $request->savings_amount,
                //         'residence_fee' => $request->residenceal_fee,
                //         'daily_wages_amount' => ($request->salary_factor == 'DAILYW') ? $request->daily_wages : "",
                //         'daily_wages_ind' => ($request->salary_factor == 'DAILYW') ? 1 : "",
                //         'person_income_tax_ind' => $request->income_tex_ind,
                //         'status' => 1
                //     ];


                //     if (DB::table("income_tax_setup")->where('default_ind', 1)->exists()) {
                //         $income_tax_setup = DB::table("income_tax_setup")->where('default_ind', 1)->first();

                //         $basic_salary = $dataSalary['basic_salary'] * 12;

                //         $half_of_basic = $dataSalary['basic_salary'] * $income_tax_setup->house_rent_law_1;

                //         $yearly_house_rent = intval($dataSalary['house_rent'] * 12);

                //         $yearly_medical_allow = intval($dataSalary['medical_allow'] * 12);

                //         $medical_law_1_nrb = ($dataSalary['basic_salary'] * 12) * $income_tax_setup->medical_law_1;

                //         $medical_law_2_nrb = intval($income_tax_setup->medical_law_2);

                //         $conveyance_law_nrb = $income_tax_setup->conveyance_law_1;

                //         $conveyancde_allow = ($dataSalary['conveyance_allow'] * 12);

                //         $ta_da_law_nrb = $income_tax_setup->conveyance_law_1;

                //         $ta_da_allow = ($dataSalary['ta_da'] * 12);

                //         $house_rent_range_1 = intval($half_of_basic * 12);
                //         $house_rent_range_2 =  intval($income_tax_setup->house_rent_law_2);
                //         $house_rent_taxable_income = 0;
                //         $medical_taxable_income = 0;
                //         $conveyance_taxable_income = 0;
                //         $ta_da_taxable_income = 0;

                //         $house_rent_benefit = 0;
                //         $medical_benefit = 0;

                //         if ($house_rent_range_1 < $house_rent_range_2) {
                //             $house_rent_benefit = $house_rent_range_1;
                //         } else {
                //             $house_rent_benefit = $house_rent_range_2;
                //         }





                //         if ($yearly_house_rent < $house_rent_benefit) {
                //             $house_rent_taxable_income = 0;
                //         } else {
                //             $house_rent_taxable_income = ($yearly_house_rent - $house_rent_benefit);
                //         }




                //         if ($medical_law_1_nrb < $medical_law_2_nrb) {
                //             $medical_benefit = $medical_law_1_nrb;
                //         } else {
                //             $medical_benefit = $medical_law_2_nrb;
                //         }



                //         if ($yearly_medical_allow < $medical_benefit) {

                //             $medical_taxable_income = 0;
                //         } else {

                //             $medical_taxable_income = ($yearly_medical_allow - $medical_benefit);
                //         }

                //         if ($conveyancde_allow < $conveyance_law_nrb) {

                //             $conveyance_taxable_income = 0;
                //         } else {

                //             $conveyance_taxable_income = ($conveyancde_allow - $conveyance_law_nrb);
                //         }


                //         if ($ta_da_allow < $ta_da_law_nrb) {

                //             $ta_da_taxable_income = 0;
                //         } else {

                //             $ta_da_taxable_income = ($ta_da_allow - $ta_da_law_nrb);
                //         }



                //         $festival_bonus_taxable_income = intval($dataSalary['festival_bonus']);

                //         $utility_texable_income = ($dataSalary['utility_allow'] * 12);

                //         $entertainment_texable_income = ($dataSalary['entertainment'] * 12);

                //         $attendance_bonus_texable_income = ($dataSalary['attendance_bonus'] * 12);

                //         $other_allowance_texable_income = ($dataSalary['other_allow'] * 12);

                //         $savings_amount = ($dataSalary['personal_savings_amount'] * 12);

                //         $total_salary_taxable_income = ($basic_salary + $house_rent_taxable_income + $medical_taxable_income + $conveyance_taxable_income + $ta_da_taxable_income + $utility_texable_income + $entertainment_texable_income + $attendance_bonus_texable_income + $other_allowance_texable_income + $festival_bonus_taxable_income);

                //         //dd($house_rent_taxable_income , $medical_taxable_income , $conveyance_taxable_income , $ta_da_taxable_income , $utility_texable_income , $entertainment_texable_income , $attendance_bonus_texable_income , $other_allowance_texable_income , $festival_bonus_taxable_income);

                //         $tax_liability = 0;


                //         $minimum_tax = 0;

                //         if ($request->doctor_gender == 6 ||  $request->doctor_gender == 7) {

                //             $minimum_tax = intval($income_tax_setup->tax_fee_amount + 50000);
                //         } else {

                //             $minimum_tax = intval($income_tax_setup->tax_fee_amount);
                //         }


                //         $next_three_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac);


                //         $next_four_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac);


                //         $next_five_lac_tax = $minimum_tax + intval($income_tax_setup->rem_next_one_lac) + intval($income_tax_setup->rem_next_three_lac) + intval($income_tax_setup->rem_next_four_lac);



                //         if ($total_salary_taxable_income < $minimum_tax) {

                //             $tax_liability += 0;
                //         }


                //         if (($total_salary_taxable_income > $minimum_tax)) {

                //             $diff = ($total_salary_taxable_income - $minimum_tax);

                //             if ($diff > $income_tax_setup->rem_next_one_lac) {
                //                 $tax_liability += intval($income_tax_setup->rem_next_one_lac) * floatval($income_tax_setup->min_tax_percent);
                //             } else {
                //                 $tax_liability += intval($diff) * floatval($income_tax_setup->min_tax_percent);
                //             }
                //         }


                //         if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_three_lac_tax))) {

                //             $diff = ($total_salary_taxable_income - $next_three_lac_tax);

                //             if ($diff > intval($income_tax_setup->rem_next_three_lac)) {
                //                 $tax_liability += intval($income_tax_setup->rem_next_three_lac) * floatval($income_tax_setup->rem_next_three_lac_percent);
                //             } else {
                //                 $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_three_lac_percent);
                //             }
                //         }

                //         if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_four_lac_tax))) {

                //             $diff = ($total_salary_taxable_income - $next_four_lac_tax);

                //             if ($diff > intval($income_tax_setup->rem_next_four_lac)) {
                //                 $tax_liability += intval($income_tax_setup->rem_next_four_lac) * floatval($income_tax_setup->rem_next_four_lac_percent);
                //             } else {
                //                 $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_four_lac_percent);
                //             }
                //         }

                //         if (($total_salary_taxable_income > $minimum_tax) && (($total_salary_taxable_income > $next_five_lac_tax))) {

                //             $diff = ($total_salary_taxable_income - $next_five_lac_tax);
                //             if ($diff > intval($income_tax_setup->rem_next_five_lac)) {
                //                 $tax_liability += intval($income_tax_setup->rem_next_five_lac) * floatval($income_tax_setup->rem_next_five_lac_percent);
                //             } else {
                //                 $tax_liability += intval($diff) * floatval($income_tax_setup->rem_next_five_lac_percent);
                //             }
                //         }

                //         $grater_than_next_five_lac = ($total_salary_taxable_income - $next_five_lac_tax);

                //         if ($total_salary_taxable_income > ($next_five_lac_tax + 1)) {

                //             $tax_liability += intval($grater_than_next_five_lac) * floatval($income_tax_setup->rem_next_everything_percent);
                //         }

                //         $tax_deduct = 0;
                //         if ($savings_amount > 0) {

                //             $tax_deduct = intval($savings_amount) * .15;
                //         }

                //         $tax_payable = ($tax_liability - $tax_deduct);


                //         $dataSalary['person_income_tax'] = intval($tax_payable / 12);
                //     }


                //     if ($salary_emp_id != null) {
                //         $dataSalary['au_update_by'] = $auth_id;

                //         DB::table('hrms_personnel_salary')->where("salary_no_pk", $request->salary_no_pk)->update($dataSalary);
                //     } else {


                //         if ($request->salary_ind != "") {

                //             $sequence = DB::getSequence();
                //             $salary_no_pk_seq = $sequence->nextValue('salary_no_pk_seq');
                //             $dataSalary['salary_no_pk'] = $salary_no_pk_seq;
                //             $dataSalary['au_entry_by'] = $auth_id;
                //             $dataSalary['au_entry_at'] = date("Y-m-d");

                //             DB::table('hrms_personnel_salary')->insert($dataSalary);
                //         }
                //     }
                // }
                // $this->salaryRepository->update($dataSalary, $request->salary_no_pk);
                // dd($request->salary_no_pk);
                //education array

                if ($request->employee == "EMP") {
                    DB::table("hrms_fringe_benefit")->where("person_no_fk", $id)->delete();
                    $fringe_benefit_array_count = sizeof($request->input("benefit_name"));
                    $benefit_name = $request->input("benefit_name");
                    // $benefit_amount = intval($request->input("benefit_amount"));
                    $benefit_amount = $request->input("benefit_amount");
                    $benefit_eff_date = $request->input("benefit_eff_date");

                    for ($i = 0; $i < $fringe_benefit_array_count; $i++) {
                        if ($i > 0) {
                            if ($benefit_name[0] != 0) {
                                $sequence = DB::getSequence();
                                $fringe_benefit_no_pk_seq = $sequence->nextValue('fringe_benefit_no_pk_seq');
                                $fringeBenefitData = [
                                    "fringe_benefit_no_pk" => $fringe_benefit_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'fringe_lookup_no_fk' => $benefit_name[$i],
                                    'amount' => $benefit_amount[$i],
                                    'effective_date'  => ($benefit_eff_date[$i + 1] != null) ? date("Y/M/d", strtotime($benefit_eff_date[$i])) : null,
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $fringeBenefitData['au_entry_by'] = $auth_id;
                                $fringeBenefitData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_fringe_benefit')->insert($fringeBenefitData);
                            } else {
                                if ($benefit_name[$i] != '0') {
                                    $sequence = DB::getSequence();
                                    $fringe_benefit_no_pk_seq = $sequence->nextValue('fringe_benefit_no_pk_seq');

                                    $fringeBenefitData = [
                                        "fringe_benefit_no_pk" => $fringe_benefit_no_pk_seq,
                                        'person_no_fk' => $last_id,
                                        'fringe_lookup_no_fk' => $benefit_name[$i],
                                        'amount' => $benefit_amount[$i],
                                        'effective_date' => ($benefit_eff_date[$i] != null) ? date("Y/M/d", strtotime($benefit_eff_date[$i])) : null,
                                        'au_entry_session' => "session",
                                        'au_entry_hospital_pk_no' => $hospital_no_pk
                                    ];
                                    $fringeBenefitData['au_entry_by'] = $auth_id;
                                    $fringeBenefitData['au_entry_at'] = date("Y-m-d");
                                    DB::table('hrms_fringe_benefit')->insert($fringeBenefitData);
                                }
                            }
                        }
                    }
                }




                if ($request->employee == "EMP") {
                    DB::table("hrms_dependent_info")->where("person_no_fk", $id)->delete();
                    $dependent_array_count = sizeof($request->input("dependent_name"));
                    $dependent_name = $request->input("dependent_name");
                    $dependent_nid = $request->input("dependent_nid");
                    $dependent_dob = $request->input("dependent_dob");
                    $dependent_relationship = $request->input("dependent_relationship");
                    $dependent_photos = $request->file('dependent_photo');

                    for ($i = 0; $i < $dependent_array_count; $i++) {
                        if ($i > 0) {
                            if ($dependent_name[0] != 0) {
                                $sequence = DB::getSequence();
                                $dependent_info_pk_seq = $sequence->nextValue('dependent_info_pk_seq');
                                $dependentData = [
                                    "dependent_info_pk" => $dependent_info_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'dependent_name' => $dependent_name[$i],
                                    'dependent_nid'  => $dependent_nid[$i + 1],
                                    // 'dependent_dob'  => $dependent_dob[$i + 1],
                                    'dependent_dob'  => ($dependent_dob[$i + 1] != null) ? date("Y/M/d", strtotime($dependent_dob[$i])) : null,
                                    'relationship' => $dependent_relationship[$i + 1],
                                    'photo'        => $dependent_photos[$i + 1],
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $dependentData['au_entry_by'] = $auth_id;
                                $dependentData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_dependent_info')->insert($dependentData);
                            } else {
                                if ($dependent_name[$i] != '0') {
                                    $sequence = DB::getSequence();
                                    $dependent_info_pk_seq = $sequence->nextValue('dependent_info_pk_seq');
                                    $dependentimage = isset($dependent_photos[$i]) ? $dependent_photos[$i] : null;

                                    if ($dependentimage) {
                                        $dependentimageFileName = time() . '.' . $dependentimage->extension();
                                        $dependentimage->move(public_path('uploads/Dependent'), $dependentimageFileName);
                                    } else {
                                        $dependentimageFileName = '';
                                    }
                                    $dependentData = [
                                        "dependent_info_pk" => $dependent_info_pk_seq,
                                        'person_no_fk' => $last_id,
                                        'dependent_name' => $dependent_name[$i],
                                        'dependent_nid' => $dependent_nid[$i],
                                        // 'dependent_dob' => $dependent_dob[$i],
                                        'dependent_dob' => ($dependent_dob[$i] != null) ? date("Y/M/d", strtotime($dependent_dob[$i])) : null,
                                        'relationship' => $dependent_relationship[$i],
                                        'photo' => 'dependent' . $dependentimageFileName,
                                        'au_entry_session' => "session",
                                        'au_entry_hospital_pk_no' => $hospital_no_pk
                                    ];
                                    $dependentData['au_entry_by'] = $auth_id;
                                    $dependentData['au_entry_at'] = date("Y-m-d");
                                    DB::table('hrms_dependent_info')->insert($dependentData);
                                }
                            }
                        }
                    }
                }




                if ($request->employee == "EMP") {
                    DB::table("hrms_nominee_info")->where("person_no_fk", $id)->delete();
                    $nominee_array_count = sizeof($request->input("nominee_name"));
                    $nominee_name = $request->input("nominee_name");
                    $nominee_nid = $request->input("nominee_nid");
                    $nominee_dob = $request->input("nominee_dob");
                    $nominee_relationship = $request->input("nominee_relationship");
                    $nominee_photos = $request->file('nominee_photo');

                    for ($i = 0; $i < $nominee_array_count; $i++) {
                        if ($i > 0) {
                            if ($nominee_name[0] != 0) {
                                $sequence = DB::getSequence();
                                $nominee_info_pk_seq = $sequence->nextValue('nominee_info_pk_seq');
                                $nomineeData = [
                                    "nominee_info_pk" => $nominee_info_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'nominee_name' => $nominee_name[$i],
                                    'nominee_nid'  => $nominee_nid[$i + 1],
                                    // 'nominee_dob'  => $nominee_dob[$i + 1],
                                    'nominee_dob'  => ($nominee_dob[$i + 1] != null) ? date("Y/M/d", strtotime($nominee_dob[$i + 1])) : null,
                                    'relationship' => $nominee_relationship[$i + 1],
                                    'photo'        => $nominee_photos[$i + 1],
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $nomineeData['au_entry_by'] = $auth_id;
                                $nomineeData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_nominee_info')->insert($nomineeData);
                            } else {
                                if ($nominee_name[$i] != '0') {
                                    $sequence = DB::getSequence();
                                    $nominee_info_pk_seq = $sequence->nextValue('nominee_info_pk_seq');
                                    $image = isset($nominee_photos[$i]) ? $nominee_photos[$i] : null;

                                    if ($image) {
                                        $imageFileName = time() . '.' . $image->extension();
                                        $image->move(public_path('uploads/Nominee'), $imageFileName);
                                    } else {
                                        $imageFileName = '';
                                    }
                                    $nomineeData = [
                                        "nominee_info_pk" => $nominee_info_pk_seq,
                                        'person_no_fk' => $last_id,
                                        'nominee_name' => $nominee_name[$i],
                                        'nominee_nid' => $nominee_nid[$i],
                                        // 'nominee_dob' => $nominee_dob[$i],
                                        'nominee_dob' => ($nominee_dob[$i] != null) ? date("Y/M/d", strtotime($nominee_dob[$i])) : null,
                                        'relationship' => $nominee_relationship[$i],
                                        'photo' => isset($imageFileName) ? 'nominee' . $imageFileName : '',
                                        'au_entry_session' => "session",
                                        'au_entry_hospital_pk_no' => $hospital_no_pk
                                    ];
                                    $nomineeData['au_entry_by'] = $auth_id;
                                    $nomineeData['au_entry_at'] = date("Y-m-d");
                                    DB::table('hrms_nominee_info')->insert($nomineeData);
                                }
                            }
                        }
                    }
                }



                if ($request->employee == "EMP") {
                    DB::table("hrms_personnel_education")->where("person_no_fk", $id)->delete();
                    $edu_array_count = sizeof($request->input("name"));
                    $name = $request->input("name");
                    $major = $request->input("major");
                    $institution = $request->input("institution");
                    $result = $request->input("result");
                    $p_year = $request->input("p_year");

                    for ($i = 0; $i < $edu_array_count; $i++) {
                        if ($name[0] != 0) {
                            $sequence = DB::getSequence();
                            $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                            $educationData = [
                                "education_no_pk" => $education_no_pk_seq,
                                'person_no_fk' => $last_id,
                                'degree_name' => $name[$i],
                                'major_sub_or_gr' => $major[$i + 1],
                                'institute_name' => $institution[$i + 1],
                                'passing_year' => $p_year[$i + 1],
                                'result_text' => $result[$i + 1],
                                'au_entry_session' => "session",
                                'au_entry_hospital_pk_no' => $hospital_no_pk
                            ];
                            $educationData['au_entry_by'] = $auth_id;
                            $educationData['au_entry_at'] = date("Y-m-d");
                            DB::table('hrms_personnel_education')->insert($educationData);
                        } else {
                            if ($name[$i] != '0') {
                                $sequence = DB::getSequence();
                                $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                                $educationData = [
                                    "education_no_pk" => $education_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'degree_name' => $name[$i],
                                    'major_sub_or_gr' => $major[$i],
                                    'institute_name' => $institution[$i],
                                    'passing_year' => $p_year[$i],
                                    'result_text' => $result[$i],
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $educationData['au_entry_by'] = $auth_id;
                                $educationData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_personnel_education')->insert($educationData);
                            }
                        }
                    }
                }


                if ($request->employee == "EMP") {
                    DB::table("hrms_personnel_experience")->where("person_no_fk", $id)->delete();
                    $exp_array_count = sizeof($request->input("we_organization_name"));
                    $we_organization_name = $request->input("we_organization_name");
                    $we_designation = $request->input("we_designation");
                    $we_start_date = $request->input("we_start_date");
                    $we_end_date = $request->input("we_end_date");

                    for ($i = 0; $i < $exp_array_count; $i++) {
                        if ($i > 0) {
                            if ($we_organization_name[0] != 0) {
                                $sequence = DB::getSequence();
                                $experience_no_pk_seq = $sequence->nextValue('experience_no_pk_seq');
                                $experienceData = [
                                    "experience_no_pk" => $experience_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'company_name' => $we_organization_name[$i],
                                    'designation_name' => $we_designation[$i + 1],
                                    // 'emp_from_date' => $we_start_date[$i + 1],
                                    'emp_from_date' => ($we_start_date[$i + 1] != null) ? date("Y/M/d", strtotime($we_start_date[$i + 1])) : null,
                                    // 'emp_to_date' => $we_end_date[$i + 1],
                                    'emp_to_date' => ($we_end_date[$i + 1] != null) ? date("Y/M/d", strtotime($we_end_date[$i + 1])) : null,
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                $experienceData['au_entry_by'] = $auth_id;
                                $experienceData['au_entry_at'] = date("Y-m-d");
                                // dd($experienceData);
                                DB::table('hrms_personnel_experience')->insert($experienceData);
                            } else {
                                if ($we_organization_name[$i] != '0') {
                                    $sequence = DB::getSequence();
                                    $experience_no_pk_seq = $sequence->nextValue('experience_no_pk_seq');
                                    $experienceData = [
                                        "experience_no_pk" => $experience_no_pk_seq,
                                        'person_no_fk' => $last_id,
                                        'company_name' => $we_organization_name[$i],

                                        'designation_name' => $we_designation[$i],
                                        // 'emp_from_date' => $we_start_date[$i],
                                        'emp_from_date' => ($we_start_date[$i] != null) ? date("Y/M/d", strtotime($we_start_date[$i])) : null,
                                        // 'emp_to_date' => $we_end_date[$i],
                                        'emp_to_date' => ($we_end_date[$i] != null) ? date("Y/M/d", strtotime($we_end_date[$i])) : null,
                                        'au_entry_session' => "session",
                                        'au_entry_hospital_pk_no' => $hospital_no_pk
                                    ];
                                    $experienceData['au_entry_by'] = $auth_id;
                                    $experienceData['au_entry_at'] = date("Y-m-d");
                                    DB::table('hrms_personnel_experience')->insert($experienceData);
                                }
                            }
                        }
                    }
                }



                if ($request->employee == "EMP") {
                    // dd($request->file('tc_attachment'));
                    DB::table("hrms_personnel_cert_tr")->where("person_no_fk", $id)->delete();
                    $trainig_array_count = sizeof($request->input("tc_title"));
                    $tc_title = $request->input("tc_title");
                    $tc_institute_name = $request->input("tc_institute_name");
                    $tc_start_date = $request->input("tc_start_date");
                    $tc_end_date = $request->input("tc_end_date");
                    $tc_duration = $request->input("tc_duration");
                    $tc_attachment = $request->file('tc_attachment');
                    $tc_certificate_link = $request->input("tc_certificate_link");

                    for ($i = 0; $i < $trainig_array_count; $i++) {
                        if ($i > 0) {
                            if ($tc_title[0] != 0) {
                                $sequence = DB::getSequence();
                                $cert_tr_no_pk_seq = $sequence->nextValue('cert_tr_no_pk_seq');
                                $trainingData = [
                                    "cert_tr_no_pk" => $cert_tr_no_pk_seq,
                                    'person_no_fk' => $last_id,
                                    'cert_tr_tittle' => $tc_title[$i],
                                    'institute_name' => $tc_institute_name[$i + 1],
                                    // 'emp_from_date' => $tc_start_date[$i + 1],
                                    'emp_from_date' => ($tc_start_date[$i + 1] != null) ? date("Y/M/d", strtotime($tc_start_date[$i + 1])) : null,
                                    // 'emp_to_date' => $tc_end_date[$i + 1],
                                    'emp_to_date' => ($tc_end_date[$i + 1] != null) ? date("Y/M/d", strtotime($tc_end_date[$i + 1])) : null,
                                    'training_duration' => $tc_duration[$i + 1],
                                    'tr_cert_file' => $tc_attachment[$i + 1],
                                    'tr_cert_url' => $tc_certificate_link[$i + 1],
                                    'au_entry_session' => "session",
                                    'au_entry_hospital_pk_no' => $hospital_no_pk
                                ];
                                // dd($trainingData['tr_cert_file']);
                                $trainingData['au_entry_by'] = $auth_id;
                                $trainingData['au_entry_at'] = date("Y-m-d");
                                DB::table('hrms_personnel_cert_tr')->insert($trainingData);
                            } else {
                                if ($tc_title[$i] != '0') {
                                    $sequence = DB::getSequence();
                                    $cert_tr_no_pk_seq = $sequence->nextValue('cert_tr_no_pk_seq');
                                    $trainingData = [
                                        "cert_tr_no_pk" => $cert_tr_no_pk_seq,
                                        'person_no_fk' => $last_id,
                                        'cert_tr_tittle' => $tc_title[$i],
                                        'institute_name' => $tc_institute_name[$i],

                                        // 'emp_from_date' => $tc_start_date[$i],
                                        'emp_from_date' => ($tc_start_date[$i] != null) ? date("Y/M/d", strtotime($tc_start_date[$i])) : null,
                                        // 'emp_to_date' => $tc_end_date[$i],
                                        'emp_to_date' => ($tc_end_date[$i] != null) ? date("Y/M/d", strtotime($tc_end_date[$i])) : null,
                                        'training_duration' => $tc_duration[$i],
                                        'tr_cert_url' => $tc_certificate_link[$i],
                                        'au_entry_session' => "session",
                                        'au_entry_hospital_pk_no' => $hospital_no_pk
                                    ];
                                    $trainingData['au_entry_by'] = $auth_id;
                                    $trainingData['au_entry_at'] = date("Y-m-d");
                                    DB::table('hrms_personnel_cert_tr')->insert($trainingData);
                                }
                            }
                        }
                    }
                }
            }

            if ($files = $request->file('doc_photo')) {
                $this->uploadImages($files, $last_id, 'images/uploads/doctor_images/', 'images/uploads/doctor_images/thumb/');
            }

            if ($files1 = $request->file('digital_signature')) {
                $this->uploadImages($files1, $last_id . $random_text, 'images/uploads/doctor_images/', 'images/uploads/doctor_images/thumb/');
            }

            if ($files1 = $request->file('cv_entry')) {
                $this->uploadImages($files1, $last_id, 'images/uploads/cv/', 'images/uploads/cv/thumb/');
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }







    public function createOrUpdateQuickRegister($request, $id = null)
    {

        $auth_id = Auth::id();
        $person_seq_count = Doctor::latest('person_no_pk')->first();


        $person_id = $request->uid;
        // $person_id = isset($person_seq_count) ? "DOC-" . ($person_seq_count->person_no_pk + number_format(1)) : "DOC-" . 1;

        $doc_dob = new Carbon($request->doctor_dob);
        $doctor_dob = date("Y-m-d", strtotime($doc_dob->toDateString()));
        $full_name = $request->doctor_first_name . ' ' . $request->doctor_last_name;
        $doc_speci = isset($request->doctor_specialization) ? $request->doctor_specialization : "";
        $doctor_dept = isset($request->doctor_dept) ? $request->doctor_dept : "";
        $doc_type = isset($request->doc_type) ? $request->doc_type : 0;
        DB::beginTransaction();
        try {
            $data = [
                'salutation' => $request->doc_salutation,
                'person_code' => $person_id,
                'full_name' => $full_name,
                'fname' => $request->doctor_first_name,
                'lname' => $request->doctor_last_name,
                'gender_lookup_no_fk' => $request->doctor_gender,
                'phone_mobile' => $request->doctor_mobile,
                'email_personal' => $request->doctor_email,
                'pe_addr1' => $request->present_address,
                'specialization_lookup_no_fk' => $doc_speci,
                'serviceunit_no_fk' => $doctor_dept,
                'external_doctor_ind' => $doc_type,

            ];
            if ($request->doc_type == 1) {
                $data['doctor_ind'] = 1;
            } else {
                $data['referal_ind'] = 1;
            }
            if ($id == null) {

                if ($request->doc_type != "EMERG") {
                    $data['referral_agent_ind'] = 1;
                }
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                $response = $this->baseRepository->create($data);
                $last_id = $response->person_no_pk;
                $last_name = $response->full_name;

                DB::table('hrms_personnel')->where('person_no_pk', $last_id)->update([
                    'serviceunit_no_fk' => $doctor_dept,
                    'serviceunit_no_fk_dept' => $doctor_dept,
                ]);


                $su_data = DB::table('employee_info_vw')->select('serviceunit_no_fk','su_name')->where('person_no_pk', $last_id)->first();

                $serviceunit_no_fk = $su_data->serviceunit_no_fk;
                $su_name = $su_data->su_name;

            } else {
                if ($request->doc_type != "EMERG") {
                    $data['referral_agent_ind'] = 1;
                }
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                $this->baseRepository->update($data, $id);
                $last_id = $id;

                $serviceunit_no_fk = '';
                $su_name = '';
            }

            $gender_text =  DB::table('sysc_lookup_data')->where('lookupdata_no_pk', $request->doctor_gender)->where('status', 1)->first()->lookupdata_name;

            // switch ($request->doctor_gender) {
            //     case 5:
            //         $gender = 'Male';
            //         break;
            //     case 6:
            //         $gender = 'Female';
            //         break;
            //     case 7:
            //         $gender = 'Other';
            //         break;
            // }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id, 'doctor_code' => $person_id, 'last_name' => $full_name, 'doctor_mobile' => $request->doctor_mobile, 'gender' => $gender_text,'serviceunit_no_fk'=>$serviceunit_no_fk,'su_name'=>$su_name];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
}
