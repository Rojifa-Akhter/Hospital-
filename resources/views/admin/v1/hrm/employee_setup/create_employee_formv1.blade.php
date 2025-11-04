@php
    $doctor = isset($data) && !empty($data) ? $data : [];
    // dd($doctor);
    $inv_hod_ind = $doctor ? $doctor->inv_hod_ind : '';
    $inv_auth_admin_ind = $doctor ? $doctor->inv_auth_admin_ind : '';
    $inv_auth_director_ind = $doctor ? $doctor->inv_auth_director_ind : '';
    $inv_auth_chairman_ind = $doctor ? $doctor->inv_auth_chairman_ind : '';
    
    $inv_director_admin_ind = $doctor ? $doctor->inv_director_admin_ind : '';
    $inv_director_acc_ind = $doctor ? $doctor->inv_director_acc_ind : '';
    $inv_gen_man_proc_ind = $doctor ? $doctor->inv_gen_man_proc_ind : '';
    $inv_manager_acc_ind = $doctor ? $doctor->inv_manager_acc_ind : '';
    $inv_proc_ind = $doctor ? $doctor->inv_proc_ind : '';
    $inv_store_ind = $doctor ? $doctor->inv_store_ind : '';
    
    // $out_uid = isset($out_uid) && Session::get('user.ses_hospital_code') != 'IMPERIAL' ? $out_uid : '';
    $out_uid = isset($out_uid) ? $out_uid : '';
    $doctor_code = $doctor ? $doctor->person_code : $out_uid;
    $doctor_no_pk = $doctor ? $doctor->person_no_pk : '';
    $ref_agent_person_no_fk = $doctor ? $doctor->ref_agent_person_no_fk : '';
    $apps_user = $doctor ? $doctor->apps_user_ind : '';
    $passcode = $doctor ? $doctor->agent_access_code : '';
    $employee_ind = $doctor ? $doctor->employee_ind : '';
    $doctor_ind = $doctor ? $doctor->doctor_ind : '';
    $referral_ind = $doctor ? $doctor->referal_ind : '';
    $payable_ind = $doctor ? $doctor->referral_payable_ind : '';
    $mpo_ind = $doctor ? $doctor->mpo_ind : '';
    $salary_ind = $doctor ? $doctor->salary_ind : '';
    $birth_certi_ind = $doctor ? $doctor->birth_certi_ind : '';
    $doctor_salutation = $doctor ? $doctor->salutation : '';
    $doctor_first_name = $doctor ? $doctor->fname : '';
    $doctor_last_name = $doctor ? $doctor->lname : '';
    $doctor_nid_name = $doctor ? $doctor->nid_name : '';
    $doctor_age = $doctor ? $doctor->age : '';
    $doctor_date_of_birth = $doctor ? $doctor->dob : '';
    
    $registration_no = $doctor ? $doctor->registration_no : '';
    $registration_type = $doctor ? $doctor->registration_type : '';
    $registration_name = $doctor ? $doctor->registration_name : '';
    $registration_date = $doctor ? $doctor->registration_date : '';
    $registration_update_date = $doctor ? $doctor->registration_update_date : '';
    $is_contractual_job_ind = $doctor ? $doctor->is_contractual_job_ind : '';
    $is_contact_renew_ind = $doctor ? $doctor->is_contact_renew_ind : '';
    $uniform_ind = $doctor ? $doctor->uniform_ind : '';
    $card_type_ind = $doctor ? $doctor->card_type_ind : '';
    $att_avl_ind = $doctor ? $doctor->att_avl_ind : '';
    $ot_ind = $doctor ? $doctor->ot_payable_ind : '';
    $job_description_txt = $doctor ? $doctor->job_description_txt : '';
    $emp_reference = $doctor ? $doctor->emp_reference : '';
    $serviceunit_no_fk_dept = $doctor ? $doctor->serviceunit_no_fk_dept : '';
    $emp_hod1_person_no_fk = $doctor ? $doctor->emp_hod1_person_no_fk : '';

    $drivinglc_no = $doctor ? $doctor->drivinglc_no : '';
    $drivelc_issue_date = $doctor ? $doctor->drivelc_issue_date : '';
    $drivelc_expiry_date = $doctor ? $doctor->drivelc_expiry_date : '';

    $hod1_name = isset($hod1_name) && !empty($hod1_name) ? $hod1_name : [];
    $hod2_name = isset($hod2_name) && !empty($hod2_name) ? $hod2_name : [];
    $sup1_name = isset($sup1_name) && !empty($sup1_name) ? $sup1_name : [];
    $sup2_name = isset($sup2_name) && !empty($sup2_name) ? $sup2_name : [];

    $hname1 = $hod1_name ? $hod1_name->hname1 : '';
    $hname2 = $hod2_name ? $hod2_name->hname2 : '';
    $supname1 = $sup1_name ? $sup1_name->supname1 : '';
    $supname2 = $sup2_name ? $sup2_name->supname2 : '';

    $emp_hod2_person_no_fk = $doctor ? $doctor->emp_hod2_person_no_fk : '';
    $emp_supvisor1_person_no_fk = $doctor ? $doctor->emp_supvisor1_person_no_fk : '';
    $emp_supvisor2_person_no_fk = $doctor ? $doctor->emp_supvisor2_person_no_fk : '';
    $contract_start_date = $doctor ? $doctor->contract_start_date : '';
    $contract_end_date = $doctor ? $doctor->contract_end_date : '';
    $transfer_date = $doctor ? $doctor->transfer_date : '';
    $confirmation_date = $doctor ? $doctor->confirmation_date : '';
    $conv_eligibility = $doctor ? $doctor->trans_desig_lookup_no_fk : '';
    
    $emp_serial_in_salary_sheet = $doctor ? $doctor->emp_serial_in_salary_sheet : 0;
    
    $place_of_birth = $doctor ? $doctor->place_of_birth : '';
    $doctor_address1 = $doctor ? $doctor->emergency_contact_addr : '';
    $doctor_address2 = $doctor ? $doctor->present_addr : '';
    $doctor_address3 = $doctor ? $doctor->permanent_addr : '';
    $doctor_nid = $doctor ? $doctor->nid_no : '';
    $doctor_mobile = $doctor ? $doctor->phone_mobile : '';
    $doctor_father = $doctor ? $doctor->father_name : '';
    $father_name_bangla = $doctor ? $doctor->father_name_bangla : '';
    $doctor_mother = $doctor ? $doctor->mother_name : '';
    $doctor_mother_bangla = $doctor ? $doctor->mother_name_bangla : '';
    $doctor_spouse = $doctor ? $doctor->spouse_name : '';
    $spuse_name_bangla = $doctor ? $doctor->spouse_name_bangla : '';
    $email_personal = $doctor ? $doctor->email_personal : '';
    $phone_mobile = $doctor ? $doctor->phone_mobile : '';
    $doctor_blood_group = $doctor ? $doctor->blood_group_lookup_no_fk : '';
    $doctor_job_type = $doctor ? $doctor->job_type_lookup_no_fk : '';
    $doctor_hr_type = $doctor ? $doctor->hr_type_lookup_no_fk : '';
    $job_nature_type = $doctor ? $doctor->job_nature_lookup_no_fk : '';
    $emp_type = $doctor ? $doctor->emp_type_lookup_no_fk : '';
    $leave_type = $doctor ? $doctor->leave_category_lookup_no_fk : '';
    $confirmation_status = $doctor ? $doctor->confirmation_status : '';
    $doctor_job_title = $doctor ? $doctor->jobtitle_lookup_no_fk : '';
    $ini_doctor_job_title = $doctor ? $doctor->ini_jobtitle_lookup_no_fk : '';
    $grade_no_fk = $doctor ? $doctor->grade_no_fk : '';
    $roster_type = $doctor ? $doctor->duty_roster_type : '';
    $inactivate_resson = $doctor ? $doctor->inactivate_resson : '';
    $emp_status = $doctor ? $doctor->emp_status : '';
    $inactivate_date = $doctor ? $doctor->inactivate_date : '';
    
    $bank_name = $doctor ? $doctor->bank_name : '';
    $bankName = $doctor ? $doctor->bank_look_up_data_fk : '';
    $bank_acc_no = $doctor ? $doctor->bank_acc_no : '';
    $bank_acc_name = $doctor ? $doctor->bank_acc_name : '';
    $agent_banking_type = $doctor ? $doctor->agent_banking_type : '';
    $agent_banking_no = $doctor ? $doctor->agent_banking_no : '';
    $security_money_amount = $doctor ? $doctor->security_money_amount : '';
    $security_money_received_date = $doctor ? $doctor->security_money_received_date : '';
    $acc_routing_no = $doctor ? $doctor->acc_routing_no : '';
    
    $photo_name = $doctor ? $doctor->photo_name : '';
    
    $department = $doctor ? $doctor->serviceunit_no_fk : '';
    $join_date = $doctor ? $doctor->join_date : '';
    
    $doctor_lic_no = $doctor ? $doctor->doc_lic_no : '';
    $doctor_lic_issue_date = $doctor && $doctor->license_issue_date ? date('d-m-Y', strtotime($doctor->license_issue_date)) : '';
    $doctor_card_number = $doctor ? $doctor->card_no : '';
    $present_address = $doctor ? $doctor->pr_addr1 : '';
    $salary_ind = $doctor ? $doctor->salary_ind : '';
    $bonus_eligibility = $doctor ? $doctor->bonus_elig_ind : '';
    $status = $doctor ? $doctor->status : '';
    
    $permanent_address = $doctor ? $doctor->pe_addr1 : '';
    $emergency_contact_address = $doctor ? $doctor->emergency_contact_addr : '';
    $doctor_nationality = $doctor ? $doctor->nationality : '';
    $doctor_passport_no = $doctor ? $doctor->passport_no : '';
    $passport_issue_date = $doctor ? $doctor->passport_issue_date : '';
    $passport_expire_date = $doctor ? $doctor->passport_expire_date : '';
    $passport_issue_place = $doctor ? $doctor->passport_issue_place : '';
    $doctor_gender = $doctor ? $doctor->gender_lookup_no_fk : '';
    $doctor_marital_status = $doctor ? $doctor->marital_lookup_no_fk : '';
    $doctor_religion = $doctor ? $doctor->religion_lookup_no_fk : '';
    $doctor_permanent_district = $doctor ? $doctor->pe_addr_dist : '';
    $doctor_present_district = $doctor ? $doctor->pr_addr_dist : '';
    $doctor_present_thana = $doctor ? $doctor->pr_addr_thana : '';
    $doctor_permanent_thana = $doctor ? $doctor->pe_addr_thana : '';
    $doctor_emergency_contact_name = $doctor ? $doctor->emergency_contact_name : '';
    $doctor_emergency_contact_address = $doctor ? $doctor->emergency_contact_addr : '';
    $doctor_emergency_contact_relation = $doctor ? $doctor->relation_lookup_pk_no : '';
    $doctor_emergency_contact_contact = $doctor ? $doctor->emergency_contact_contact : '';
    $emergency_contact_relation = $doctor ? $doctor->emergency_contact_relation : '';
    $doctor_specialization = $doctor ? $doctor->specialization_lookup_no_fk : '';
    $doctor_signature = $doctor ? $doctor->doctor_signature : '';
    $serviceunit_no_fk = $doctor ? $doctor->serviceunit_no_fk : '';
    $full_name_bangla = $doctor ? $doctor->full_name_bangla : '';
    $referral_agent_ind = $doctor ? $doctor->referral_agent_ind : '';
    
    $accomodation_ind = $doctor ? $doctor->accomodation_ind : '';
    $transport_ind = $doctor ? $doctor->transport_ind : '';
    $provident_fund_type = $doctor ? $doctor->provident_fund_type : '';
    $ot_payable_ind = $doctor ? $doctor->ot_payable_ind : '';
    
    $user_into = isset($user_into) && !empty($user_into) ? $user_into : [];
    $user_name = $user_into ? $user_into->user_name : '';
    $user_type = $user_into ? $user_into->user_type : '';
    
    $educationInfo = isset($educationInfo) && !empty($educationInfo) ? $educationInfo : [];
    $experienceInfo = isset($experienceInfo) && !empty($experienceInfo) ? $experienceInfo : [];
    $trainingInfo = isset($trainingInfo) && !empty($trainingInfo) ? $trainingInfo : [];
    $nomineeInfo = isset($nomineeInfo) && !empty($nomineeInfo) ? $nomineeInfo : [];
    $dependentInfo = isset($dependentInfo) && !empty($dependentInfo) ? $dependentInfo : [];
    $fringebenefitInfo = isset($fringebenefitInfo) && !empty($fringebenefitInfo) ? $fringebenefitInfo : [];
    
    $doctor_degree1 = $doctor ? $doctor->degree1 : '';
    $doctor_degree2 = $doctor ? $doctor->degree2 : '';
    $doctor_degree3 = $doctor ? $doctor->degree3 : '';
    $doctor_degree4 = $doctor ? $doctor->degree4 : '';
    
    $saturday = $doctor ? $doctor->doc_chamber_day_sat : '';
    $sunday = $doctor ? $doctor->doc_chamber_day_sun : '';
    $monday = $doctor ? $doctor->doc_chamber_day_mon : '';
    $tuesday = $doctor ? $doctor->doc_chamber_day_tue : '';
    $wednesday = $doctor ? $doctor->doc_chamber_day_wed : '';
    $thursday = $doctor ? $doctor->doc_chamber_day_thu : '';
    $friday = $doctor ? $doctor->doc_chamber_day_fri : '';
    $time_text = $doctor ? $doctor->doc_chamber_time_txt : '';
    $digital_signature_ind = $doctor ? $doctor->digital_signature_ind : '';
    
    $salary = isset($salaryInfo) && !empty($salaryInfo) ? $salaryInfo : [];
    
    $salary_no_pk = $salary ? $salary->salary_no_pk : '';
    $salary_factor_data = $salary ? $salary->salary_factor : '';
    $grade_no_fk = $salary ? $salary->grade_no_fk : '';
    $gross_salary = $salary ? $salary->gross_salary : '';
    $basic_salary = $salary ? $salary->basic_salary : '';
    $basic_salary_perc = $salary ? $salary->basic_salary_perc : '';
    $medical_allow = $salary ? $salary->medical_allow : '';
    $medical_allow_perc = $salary ? $salary->medical_allow_perc : '';
    $house_rent = $salary ? $salary->house_rent : '';
    $house_rent_perc = $salary ? $salary->house_rent_perc : '';
    $attendance_bonus = $salary ? $salary->attendance_bonus : '';
    $conveyance_allow = $salary ? $salary->conveyance_allow : '';
    $conveyance_allow_perc = $salary ? $salary->conveyance_allow_perc : '';
    $utility_allow = $salary ? $salary->utility_allow : '';
    $utility_allow_perc = $salary ? $salary->utility_allow_perc : '';
    $entertainment = $salary ? $salary->entertainment : '';
    $entertainment_perc = $salary ? $salary->entertainment_perc : '';
    $festival_bonus = $salary ? $salary->festival_bonus : '';
    $festival_bonus_perc = $salary ? $salary->festival_bonus_perc : '';
    $ta_da = $salary ? $salary->ta_da : '';
    $ta_da_perc = $salary ? $salary->ta_da_perc : '';
    $savings_amount = $salary ? $salary->personal_savings_amount : '';
    $residenceal_fee = $salary ? $salary->residence_fee : '';
    $daily_wages = $salary ? $salary->daily_wages_amount : '';
    $other_allow = $salary ? $salary->other_allow : '';
    $other_allow_perc = $salary ? $salary->other_allow_perc : '';
    $income_tex_ind = $salary ? $salary->person_income_tax_ind : '';
    $income_tex = $salary ? $salary->person_income_tax : '';
    
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}"> --}}
<style>
    .select2-container {
        width: 100% !important;
    }

    #max_height {
        height: 600px;
        overflow: auto;
    }
</style>

<form method="post" id="doctor_form" action="{{ route('storeV1') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="" id="employee_id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="employee" value="EMP">
    <div class="form-row">
        <div class="col-md-12" id="max_height">
            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#basic_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>1. Basic Information</strong> (Introduce a Employee )

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="basic_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="card-body pt-2">
                                            {{-- <div class="form-group row">
                                                <label for="doctor_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">UID
                                                    <span class="text-danger">*</span></label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize  required"
                                                            id="uid" name="uid" value="{{ $doctor_code }}"
                                                            placeholder="" autocomplete="off" required="required">
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <input type="hidden"
                                                class="form-control form-control-sm text-capitalize  required"
                                                id="uid" name="uid" value="{{ $doctor_code }}" placeholder=""
                                                autocomplete="off" required="required">

                                            <div class="form-group row">
                                                
                                                @php
                                                    $nameLabelText = Session::get('user.ses_hospital_code') === 'UNICO' 
                                                        ? 'Employee Preferred Name' 
                                                        : 'Employee Name';
                                                @endphp

                                                <label for="doctor_name" class="col-sm-3 col-form-label col-form-label-sm">
                                                    {{ $nameLabelText }} <span class="text-danger">*</span>
                                                </label>
                                                    
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="doctor_salutation" name="doctor_salutation">

                                                                <option value="">Select </option>
                                                                @if (isset($name_prefix))
                                                                    @foreach ($name_prefix as $key => $value)
                                                                        <option value="{{ $value }}"
                                                                            @if ($doctor_salutation == $value) selected @endif>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize required"
                                                            id="doctor_first_name" name="doctor_first_name"
                                                            value="{{ $doctor_first_name }}" placeholder="First Name"
                                                            required="required">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize "
                                                            id="doctor_last_name" name="doctor_last_name"
                                                            value="{{ $doctor_last_name }}" placeholder="Last Name">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group row">

                                                <label for="doctor_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Employee NID
                                                    Name
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize "
                                                            id="doctor_nid_name" name="doctor_nid_name"
                                                            value="{{ $doctor_nid_name }}" placeholder="NID Full Name">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="form-group row">
                                                <label for="card_type"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Card Type<span
                                                        style="color: red;">*</span></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm" id="card_type"
                                                        name="card_type" required>
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            @if ($card_type_ind == 1) selected @endif>Managment
                                                        </option>
                                                        <option value="2"
                                                            @if ($card_type_ind == 2) selected @endif >General
                                                        </option>
                                                    </select>
                                                    {{-- @dd($doctor_card_number) --}}
                                                    <input type="hidden" id="hdn_card_number" name="hdn_card_number"
                                                        value="{{ $doctor_card_number }}">

                                                        <input type="hidden" name="hdn_card_type_ind"
                                                        value="{{ $card_type_ind }}" id="hdn_card_type_ind">  
                                                                                                          
                                                </div>

                                                <label for="card"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Employee
                                                    ID</label>
                                                <div class="col-sm-3">
                                                    @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                                    <input type="text" class="form-control form-control-sm number_only"
                                                    id="last_card_no" name="last_card_no" value="{{ $doctor_card_number }}">
                                                    @else
                                                    <input type="text" class="form-control form-control-sm number_only" id="last_card_no" name="last_card_no"
                                                    value="{{ $doctor_card_number }}" readonly>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="doctor_gender"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Sex
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto required"
                                                        id="doctor_gender" name="doctor_gender" required>
                                                        <option value="">Select Sex</option>
                                                        @if (isset($gender))
                                                            @foreach ($gender as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($doctor_gender == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <label for="doctor_religion"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Religion <span
                                                        class="text-danger">*</span> </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto required"
                                                        id="doctor_religion" name="doctor_religion" required>
                                                        <option value="">Select Religion</option>
                                                        @if (isset($religion))
                                                            @foreach ($religion as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($doctor_religion == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group row">

                                                {{-- <label for=""
                                                    class="col-sm-3 col-form-label col-form-label-sm">Mobile
                                                    Number <span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm number_only"
                                                        id="doctor_mobile_no" name="doctor_mobile_no"
                                                        value="{{ $phone_mobile }}" placeholder="Mobile No" required
                                                        maxlength="15">
                                                </div> --}}

                                                <label for="doctor_date_of_birth"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Date of Birth
                                                    <span class="text-danger">*</span> </label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="doctor_date_of_birth" name="doctor_date_of_birth"
                                                        value="{{ !empty($doctor_date_of_birth) ? date('d-m-Y', strtotime($doctor_date_of_birth)) : '' }}"
                                                        placeholder="DD/MM/YYYY" required>
                                                </div>


                                            </div>

                                            <div class="form-group row">

                                                <label for="place_of_birth"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Place
                                                    of
                                                    Birth</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="place_of_birth" name="place_of_birth"
                                                        value="{{ $place_of_birth }}" placeholder="Place of Birth"
                                                        maxlength="30">
                                                </div>
                                                {{-- <label for="doctor_marital_status"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Marital
                                                    Status</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto required"
                                                        id="doctor_marital_status" name="doctor_marital_status">
                                                        <option value="">Select Marital Status</option>
                                                        @if (isset($marital_status))
                                                            @foreach ($marital_status as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($doctor_marital_status == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div> --}}


                                                <label for="conveyance_eligibility"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Conveyance
                                                    Eligibility</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="conveyance_eligibility" name="conveyance_eligibility">
                                                        <option value="">Select</option>
                                                        @if (isset($conveyance))
                                                            @foreach ($conveyance as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($conv_eligibility == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">

                                                <label for="doctor_blood_group"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Blood
                                                    Group</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="doctor_blood_group" name="doctor_blood_group">
                                                        <option value="0">Select Blood Group</option>
                                                        @if (isset($bloodg))
                                                            @foreach ($bloodg as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($doctor_blood_group == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <label for="doctor_nationality"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Nationality</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm text-capitalize"
                                                            id="doctor_nationality" name="doctor_nationality">
                                                        <option value="Bangladeshi" <?= ($doctor_nationality == 'Bangladeshi') ? 'selected' : '' ?>>Bangladeshi</option>
                                                        <option value="Indian" <?= ($doctor_nationality == 'Indian') ? 'selected' : '' ?>>Indian</option>
                                                        <option value="Chinese" <?= ($doctor_nationality == 'Chinese') ? 'selected' : '' ?>>Chinese</option>
                                                        <option value="Nepali" <?= ($doctor_nationality == 'Nepali') ? 'selected' : '' ?>>Nepali</option>
                                                        <option value="Bhutanese" <?= ($doctor_nationality == 'Bhutanese') ? 'selected' : '' ?>>Bhutanese</option>
                                                        <option value="Malay" <?= ($doctor_nationality == 'Malay') ? 'selected' : '' ?>>Malay</option>
                                                        <option value="Others" <?= ($doctor_nationality == 'Others') ? 'selected' : '' ?>>Others</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="doctor_nid"
                                                    class="col-sm-3 col-form-label col-form-label-sm"> NID/Birth Certificate
                                                    {{-- <div class="m-0"> --}}
                                                        <input type="checkbox" name="birth_certi_ind" value="1"
                                                        id="birth_certi_ind" {{ $birth_certi_ind == 1 ? 'checked' : '' }} class="m-1">
                                                    {{-- </div> --}}
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm number_only"
                                                        id="doctor_nid" name="doctor_nid"
                                                        value="{{ $doctor_nid }}" placeholder=" NID/Birth Certificate"
                                                        maxlength="17">
                                                </div>
                                                {{-- <div class="m-0">
                                                    <input type="checkbox" name="birth_certi_ind" value="1"
                                                    id="birth_certi_ind" {{ $birth_certi_ind == 1 ? 'checked' : '' }}>
                                                </div>
                                                <label for="birth_certi_ind" class=" ml-1 pl-0">Birth Certificate</label> --}}
                                                    
                                               
                                                

                                                {{-- <label for="doctor_nationality"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                <div class="col-sm-3">
                                                    <input type="email" class="form-control form-control-sm"
                                                        id="doctor_email" name="doctor_email"
                                                        value="{{ $email_personal }}" placeholder="Employee Email"
                                                        maxlength="50"
                                                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
                                                </div> --}}
                                            </div>


                                            <div class="form-group row">
                                                {{-- <label for="registration_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Registration</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="registration_name" name="registration_name"
                                                        value="{{ $registration_name }}" placeholder="Registration">
                                                </div> --}}

                                                <label for="registration_no"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Registration
                                                    No</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="registration_no" name="registration_no"
                                                        value="{{ $registration_no }}"
                                                        placeholder="Registration Number" autocomplete="off">
                                                </div>

                                                <label for="registration_type"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Registration Type
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-control-sm"
                                                            id="registration_type" name="registration_type">
                                                        <option value="">---Select---</option>
                                                        <option value="BMDC" {{ $registration_type == 'BMDC' ? 'selected' : '' }}>BMDC</option>
                                                        <option value="BNMC" {{ $registration_type == 'BNMC' ? 'selected' : '' }}>BNMC</option>
                                                        <option value="STATE MEDICAL FACULTY" {{ $registration_type == 'STATE MEDICAL FACULTY' ? 'selected' : '' }}>STATE MEDICAL FACULTY</option>
                                                        <option value="PHARMACY COUNCIL" {{ $registration_type == 'PHARMACY COUNCIL' ? 'selected' : '' }}>PHARMACY COUNCIL</option>
                                                        <option value="Others" {{ $registration_type == 'Others' ? 'selected' : '' }}>Others</option>
                                                    </select>
                                                </div>

                                                <label for="registration_date"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Reg. Issue
                                                    Date</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="registration_date" name="registration_date"
                                                        value="{{ $registration_date }}" placeholder="Issue Date">
                                                </div>

                                                <label for="registration_update_date"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Reg. Date of Expiry</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="registration_update_date" name="registration_update_date"
                                                        value="{{ $registration_update_date }}"
                                                        placeholder="Updated Date">
                                                </div>
                                            </div>



                                            <div class="form-group row">

                                                <label for="passport_no"
                                                    class="col-sm-3 col-form-label col-form-label-sm" id="passport">
                                                    Passport</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="passport_no" name="passport_no"
                                                        value="{{ $doctor_passport_no }}"
                                                        placeholder="Passport NID No" maxlength="50">
                                                </div>

                                                <label for="cv_entry"
                                                    class="col-sm-3 col-form-label col-form-label-sm">
                                                    Upload CV/Document</label>
                                                <div class="col-sm-3">
                                                    <input type="file" class="form-control" id="cv_entry"
                                                        name="cv_entry">
                                                </div>

                                            </div>

                                            <div class="form-group row d-none expired_date">
                                                <label for="issue_date"
                                                    class="col-sm-3 col-form-label col-form-label-sm d-none expired_date">Issue
                                                    Date </label>
                                                <div class="col-sm-3 expired_date d-none">
                                                    <input type="text"
                                                        class="form-control form-control-sm text-capitalize date_picker"
                                                        id="issue_date" name="issue_date"
                                                        value="{{ $passport_issue_date != '' ? date('d-m-Y', strtotime($passport_issue_date)) : '' }}"
                                                        placeholder="DD/MM/YYYY">
                                                </div>

                                                <label for="issue_place"
                                                    class="col-sm-3 col-form-label col-form-label-sm" id="passport">
                                                    Issue Place</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="issue_place" name="issue_place"
                                                        value="{{ $passport_issue_place }}" placeholder="Issue Place"
                                                        maxlength="30">
                                                </div>
                                            </div>
                                            <div class="form-group row d-none expired_date">
                                                <label for="expired_date"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Expaired
                                                    Date </label>
                                                <div class="col-sm-3 ">
                                                    <input type="text"
                                                        class="form-control form-control-sm text-capitalize date_picker"
                                                        id="expired_date" name="expired_date"
                                                        value="{{ $passport_expire_date != '' ? date('d-m-Y', strtotime($passport_expire_date)) : '' }}"
                                                        placeholder="DD/MM/YYYY">
                                                </div>
                                            </div>

                                            <div class="form-group row">

                                                <label for="doctor_marital_status"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Marital
                                                    Status</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto required"
                                                        id="doctor_marital_status" name="doctor_marital_status">
                                                        <option value="">Select Marital Status</option>
                                                        @if (isset($marital_status))
                                                            @foreach ($marital_status as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if ($doctor_marital_status == $key) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="doctor_father"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Father Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="doctor_father" name="doctor_father"
                                                        value="{{ $doctor_father }}" placeholder="Father Name">
                                                </div>

                                                <label for="doctor_mother"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Mother Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="doctor_mother" name="doctor_mother"
                                                        value="{{ $doctor_mother }}" placeholder="Mother Name">
                                                </div>

                                                {{-- <label for="doctor_nationality"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                <div class="col-sm-3">
                                                    <input type="email" class="form-control form-control-sm"
                                                        id="doctor_email" name="doctor_email"
                                                        value="{{ $email_personal }}" placeholder="Employee Email"
                                                        maxlength="50"
                                                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
                                                </div> --}}
                                            </div>

                                            <div class="form-group row">
                                                <label for="doctor_spouse"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Spouse Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="doctor_spouse" name="doctor_spouse"
                                                        value="{{ $doctor_spouse }}" placeholder="Spouse Name">
                                                </div>
                                               
                                                <label for="drivinglc_no"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Driving License Number</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="drivinglc_no" name="drivinglc_no"
                                                        value="{{ $drivinglc_no }}" placeholder="Driving License Number">
                                                </div>
                                            </div>

                                            @php
                                                $formattedIssueDate = $drivelc_issue_date ? \Carbon\Carbon::parse($drivelc_issue_date)->format('Y-m-d') : '';
                                                $formattedExpiryDate = $drivelc_expiry_date ? \Carbon\Carbon::parse($drivelc_expiry_date)->format('Y-m-d') : '';
                                            @endphp

                                            <div class="form-group row">
                                                <label for="drivelc_issue_date" class="col-sm-3 col-form-label col-form-label-sm">
                                                    Driving License Issue Date
                                                </label>
                                                <div class="col-sm-3">
                                                    <input 
                                                        type="date"
                                                        class="form-control form-control-sm datepicker"
                                                        id="drivelc_issue_date"
                                                        name="drivelc_issue_date"
                                                        value="{{ $formattedIssueDate }}"
                                                        placeholder="DD/MM/YYYY"
                                                    >
                                                </div>
                                            
                                                <label for="drivelc_expiry_date" class="col-sm-3 col-form-label col-form-label-sm">
                                                    Driving License Expiry Date
                                                </label>
                                                <div class="col-sm-3">
                                                    <input 
                                                        type="date"
                                                        class="form-control form-control-sm datepicker"
                                                        id="drivelc_expiry_date"
                                                        name="drivelc_expiry_date"
                                                        value="{{ $formattedExpiryDate }}"
                                                        placeholder="DD/MM/YYYY"
                                                    >
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="card-body pt-2">
                                            <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <div class="text-center"> <strong>Upload Image</strong> </div>

                                                    <div class="col-sm-12 text-center">

                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type="file" id="imageUpload"
                                                                    name="doc_photo" accept=".png, .jpg, .jpeg"
                                                                    value="{{ !empty($photo_name) ? $photo_name : '' }}">
                                                                <label for="imageUpload"></label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                @if (!empty($photo_name))
                                                                    @php
                                                                        $imgUrl = '../public/images/uploads/doctor_images/thumb/' . $photo_name;
                                                                    @endphp
                                                                    <div id="imagePreview"
                                                                        style="background-image: url('{{ $imgUrl }}');">
                                                                    </div>
                                                                @else
                                                                    <div id="imagePreview"
                                                                        style="background-image: url('../public/images/doc-1.png');">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div style="margin-top: 115px;">
                                                        <label for="signature">Signature</label>
                                                        <input type="file" class="form-control">
                                                    </div> --}}

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>




            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#office_info" aria-expanded="true"
                                    aria-controls="collapseTwo">
                                    <strong>2. Job Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="office_info" class="collapse p-1" aria-labelledby="headingTwo"
                                data-parent="#accordion">
                                {{-- <div class="row"> --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dept_type" class="col-form-label">Division Type</label>
                                            <select class="form-control font_size_12 m-auto select2"
                                                id="doctor_job_type" name="doctor_job_type">
                                                <option value="">Select Job Type</option>
                                                @if (isset($job_type))
                                                    @foreach ($job_type as $key => $val)
                                                        <option value="{{ $key }}"
                                                            @if ($doctor_job_type == $key) selected @endif>
                                                            {{ $val }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="serviceunit_no_fk_dept"
                                                class="col-form-label">Department</label>
                                            <select class="form-control form-control-sm font_size_12 m-auto select2"
                                                id="serviceunit_no_fk_dept" name="serviceunit_no_fk_dept">
                                                <option value="">Select Department</option>
                                                @if (!empty($service_unit))
                                                    @foreach ($service_unit as $service)
                                                        <option value="{{ $service->serviceunit_no_pk }}"
                                                            @if ($service->serviceunit_no_pk == $serviceunit_no_fk_dept) selected @endif>
                                                            {{ strtoupper($service->serviceunit_name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="unit" class="col-form-label">Unit</label>

                                            <select class="form-control form-control-sm select2" id="doctor_ser_unit"
                                                name="doctor_ser_unit">
                                                <option value="">Select Unit</option>
                                                @if (!empty($units))
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->serviceunit_no_pk }}"
                                                            @if ($unit->serviceunit_no_pk == $serviceunit_no_fk) selected @endif>
                                                            {{ strtoupper($unit->serviceunit_name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                    

                                        {{-- <div class="form-group">
                                            <label for="job_description_txt" class="col-form-label">Job
                                                Description</label>
                                            <textarea class="form-control" id="job_description_txt" name="job_description_txt" rows="3">{{ $job_description_txt }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="emp_reference" class="col-form-label">Reference</label>
                                            <textarea class="form-control" id="emp_reference" name="emp_reference" rows="3">{{ $emp_reference }}</textarea>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doctor_job_title" class="col-form-label">Current Designation</label>
                                            <select class="form-control font_size_12 m-auto select2"
                                                id="doctor_job_title" name="doctor_job_title">
                                                <option value="0">Select Designation</option>
                                                @if (isset($job_title))
                                                    @foreach ($job_title as $record)
                                                        <option value="{{ $record->designation_no_pk }}"
                                                            @if ($doctor_job_title == $record->designation_no_pk) selected @endif>
                                                            {{ $record->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ini_doctor_job_title" class="col-form-label">Initial Designation</label>
                                            <select class="form-control font_size_12 m-auto select2"
                                                id="ini_doctor_job_title" name="ini_doctor_job_title">
                                                <option value="0">Select Designation</option>
                                                @if (isset($job_title))
                                                    @foreach ($job_title as $record)
                                                        <option value="{{ $record->designation_no_pk }}"
                                                            @if ($ini_doctor_job_title == $record->designation_no_pk) selected @endif>
                                                            {{ $record->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- <div class="form-group row align-items-left">
                                            <div class="col-sm-1">
                                                <div class="form-check">
                                                    <input type="checkbox" name="promotion_ind" value="1" id="promotion_ind" class="form-check-input">
                                                </div>
                                            </div>
                                            <label for="promotion_ind" class="col-form-label col-sm-6 pl-0">Promotion Ind</label>
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="joining_date" class="col-form-label">Joining Date</label>
                                            <input type="text" class="form-control date_picker"
                                                name="joining_date" id="joining_date" placeholder="Joining Date"
                                                value="{{ $join_date != '' ? date('d-m-Y', strtotime($join_date)) : '' }}">
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="grade" class="col-form-label">Grade<span
                                                    class="text-danger">*</span></label>

                                            <select class="form-control form-control-sm" id="grade">
                                                <option value="">Grade: P-3</option>
                                            </select>
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="hod1" class="col-form-label">HOD 1</label>
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="hod1"
                                                        id="hod1" placeholder=""
                                                        value="{{ $emp_hod1_person_no_fk }}">
                                                    <input type="hidden" name="emp_hod1_person_no_fk"
                                                        id="emp_hod1_person_no_fk" value="{{ $emp_hod1_person_no_fk }}">
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="hod1_name"
                                                        id="hod1_name" placeholder="" value="{{ $hname1 }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="hod2" class="col-form-label">HOD 2</label>
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="hod2"
                                                        id="hod2" placeholder=""
                                                        value="{{ $emp_hod2_person_no_fk }}">
                                                    <input type="hidden" name="emp_hod2_person_no_fk"
                                                        id="emp_hod2_person_no_fk" value="{{ $emp_hod2_person_no_fk }}">
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="hod2_name"
                                                        id="hod2_name" value="{{ $hname2 }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="supv1" class="col-form-label">Supv 1</label>
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="supv1"
                                                        id="supv1" placeholder=""
                                                        value="{{ $emp_supvisor1_person_no_fk }}">
                                                    <input type="hidden" name="emp_supvisor1_person_no_fk"
                                                        id="emp_supvisor1_person_no_fk" value="{{ $emp_supvisor1_person_no_fk }}">
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="supv1_name"
                                                        id="supv1_name" value="{{ $supname1 }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="supv2" class="col-form-label">Supv 2</label>
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="supv2"
                                                        id="supv2" placeholder=""
                                                        value="{{ $emp_supvisor2_person_no_fk }}">
                                                    <input type="hidden" name="emp_supvisor2_person_no_fk"
                                                        id="emp_supvisor2_person_no_fk" value="{{ $emp_supvisor2_person_no_fk }}">
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="supv2_name"
                                                        id="supv2_name" value="{{ $supname2 }}" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div
                                                    style="margin-top: 10px; border: 1px solid #eee; border-radius: 4px; padding: 7px;">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="is_contractual_job_ind" name="is_contractual_job_ind"
                                                            {{ $is_contractual_job_ind == 1 ? 'checked' : '' }} />
                                                        <label class="form-check-label"
                                                            for="is_contractual_job_ind">Contractual </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="is_contact_renew_ind" name="is_contact_renew_ind"
                                                            {{ $is_contact_renew_ind == 1 ? 'checked' : '' }} />
                                                        <label class="form-check-label" for="is_contact_renew_ind">Renewal Contractual</label>
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label for="total_con_amt" class="col-form-label">Total
                                                        Consolidated Amt.</label>
                                                    <input type="text" class="form-control" placeholder=""
                                                        id="total_con_amt" />
                                                </div> --}}

                                                <div class="form-group">
                                                    <label for="job_nature" class="col-form-label">Job Nature<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="job_nature_lookup_no_fk" name="job_nature_lookup_no_fk">
                                                        <option value="">Select</option>
                                                        @if (isset($job_nature))
                                                            @foreach ($job_nature as $key => $val)
                                                                <option value="{{ $key }}"
                                                                    @if ($job_nature_type == $key) selected @endif>
                                                                    {{ $val }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="contract_start_date" class="col-form-label">Contract Start Date</label>
                                                    <input type="text" class="form-control date_picker"
                                                        placeholder="" id="contract_start_date"
                                                        name="contract_start_date"
                                                        value="{{ !empty($contract_start_date) ? date('d-m-Y', strtotime($contract_start_date)) : '' }}" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="contract_end_date" class="col-form-label">Contract End
                                                        Date</label>
                                                    <input type="text" class="form-control date_picker"
                                                        placeholder="" id="contract_end_date"
                                                        name="contract_end_date"
                                                        value="{{ !empty($contract_end_date) ? date('d-m-Y', strtotime($contract_end_date)) : '' }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="employee_type" class="col-form-label">Employee
                                                        Type</label>
                                                    <select class="form-control font_size_12 m-auto select2"
                                                        id="emp_type" name="emp_type">
                                                        <option value="0">Select Employee Type</option>

                                                        @if (isset($employee_type_data))
                                                            @foreach ($employee_type_data as $key => $val)
                                                                <option value="{{ $key }}"
                                                                    @if ($emp_type == $key) selected @endif>
                                                                    {{ $val }}
                                                                </option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="leave_category" class="col-form-label">Leave
                                                        Category</label>

                                                    <select class="form-control form-control-sm select2"
                                                        id="leave_category" name="leave_category">
                                                        <option value="">Select</option>
                                                        @if (isset($leave_emp_category))
                                                            @foreach ($leave_emp_category as $key => $leave)
                                                                <option value="{{ $key }}"
                                                                    @if ($leave_type == $key) selected @endif>
                                                                    {{ $leave }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <label for="confirmation_status"
                                                                class="col-form-label">Confirmation Status</label>
                                                            <select class="form-control form-control-sm"
                                                                id="confirmation_status" name="confirmation_status">
                                                                <option value="Confirmed"
                                                                    @if ($confirmation_status == 'Confirmed') selected @endif>
                                                                    Confirmed</option>
                                                                <option value="Probation"
                                                                    @if ($confirmation_status == 'Probation') selected @endif>
                                                                    On Probation</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col">
                                                            <label for="" class="col-form-label">Transfer
                                                                Date</label>
                                                            <input type="text" class="form-control date_picker"
                                                                placeholder="" id="transfer_date"
                                                                name="transfer_date"
                                                                value="{{ !empty($transfer_date) ? date('d-m-Y', strtotime($transfer_date)) : '' }}" />
                                                        </div>
                                                        <div class="col">
                                                            <label for="" class="col-form-label">Confirmation
                                                                Date</label>
                                                            <input type="text" class="form-control date_picker"
                                                                placeholder="" id="confirmation_date"
                                                                name="confirmation_date"
                                                                value="{{ !empty($confirmation_date) ? date('d-m-Y', strtotime($confirmation_date)) : '' }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col-md-6 mt-4">
                                                            <div
                                                                style="border: 1px solid #eee; border-radius: 4px; padding: 7px;">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="is_uniform" name="is_uniform"
                                                                        {{ $uniform_ind == 1 ? 'checked' : '' }} />
                                                                    <label class="form-check-label"
                                                                        for="is_uniform">Uniform Availability</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="duty_roster" class="col-form-label">Duty
                                                                Roster</label>
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="roster_type" name="roster_type">
                                                                <option value="" selected="selected">Select
                                                                    Roster Type
                                                                </option>
                                                                <option value="General"
                                                                    {{ $roster_type == 'General' ? 'selected' : '' }}>
                                                                    General
                                                                </option>
                                                                <option value="General_1"
                                                                {{ $roster_type == 'General_1' ? 'selected' : '' }}>
                                                                General-1
                                                                </option>
                                                                <option value="General_2"
                                                                {{ $roster_type == 'General_2' ? 'selected' : '' }}>
                                                                General-2
                                                                </option>
                                                                <option value="ROSTER"
                                                                    {{ $roster_type == 'ROSTER' ? 'selected' : '' }}>
                                                                    Roster
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col-md-6 mt-4">
                                                            <div
                                                                style="border: 1px solid #eee; border-radius: 4px; padding: 7px;">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="att_avl_ind" name="att_avl_ind" {{ $att_avl_ind == 1 ? 'checked' : '' }}/>
                                                                    <label class="form-check-label"
                                                                        for="att_avl_ind">Attendance Availability</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-4">
                                                            <div
                                                                style="border: 1px solid #eee; border-radius: 4px; padding: 7px;">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="ot_ind" name="ot_ind"
                                                                        {{ $ot_ind == 1 ? 'checked' : '' }} />
                                                                    <label class="form-check-label"
                                                                        for="ot_ind">OT Payable</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Fringe Benefit</h5>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive"
                                                            style="height: 125px;overflow-y: scroll;">
                                                            <table
                                                                class="table border-0 mt-1 mb-0 table-striped table-bordered table-hover"
                                                                id="mytable">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="p-0 border-0">Benefit</th>
                                                                        <th class="p-0 border-0 w-15">Amount</th>
                                                                        <th class="p-0 border-0 w-15">Effective Date
                                                                        </th>

                                                                    </tr>
                                                                </thead>

                                                                <tbody id="data-append-to">
                                                                    <tr id="0">
                                                                        <td class="">
                                                                            <select
                                                                                class="form-control font_size_12 m-auto"
                                                                                name="benefit_name[]"
                                                                                id="benefit_name_0">
                                                                                <option value="">Select</option>
                                                                                @if (!empty($fringebenefit))
                                                                                    @foreach ($fringebenefit as $key => $benefit)
                                                                                        <option
                                                                                            value="{{ $key }}">
                                                                                            {{ $benefit }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="number" class="form-control"
                                                                                id="benefit_amount_0"
                                                                                name="benefit_amount[]"
                                                                                placeholder="Amount" maxlength="17">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control number_only date_picker"
                                                                                id="benefit_eff_date_0"
                                                                                name="benefit_eff_date[]">
                                                                        </td>

                                                                        <td id="med_td_action_0">
                                                                            <span onclick="addFringeBenefitRow(this)"
                                                                                class="btn btn-md btn-success"> +Add
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $tableId = 2;
                                                                    @endphp

                                                                    @if (!empty($fringebenefitInfo))
                                                                        @foreach ($fringebenefitInfo as $benefit)
                                                                            <tr id="">
                                                                                <td>
                                                                                    <select
                                                                                        class="form-control font_size_12 m-auto select2"
                                                                                        name="benefit_name[]">
                                                                                        @if (!empty($fringebenefit))
                                                                                            @foreach ($fringebenefit as $key => $value)
                                                                                                <option
                                                                                                    value="{{ $key }}"
                                                                                                    {{ $benefit->fringe_lookup_no_fk == $key ? 'selected' : '' }}>
                                                                                                    {{ $value }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="benefit_amount[]"
                                                                                        placeholder="Amount"
                                                                                        value="{{ $benefit->amount }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="benefit_eff_date[]"
                                                                                        value="{{ date('d-m-Y', strtotime($benefit->effective_date)) }}">
                                                                                </td>
                                                                                <td id="med_td_action_">
                                                                                    <span
                                                                                        onclick="removeFringeBenefitTableRowOnly(this)"
                                                                                        class="btn btn-sm btn-danger">
                                                                                        <i class='fa fa-times'></i>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <td>
                                                                                <input type="hidden"
                                                                                    name="hidden_temp_edu_id[]"
                                                                                    value="{{ $benefit->fringe_benefit_no_pk }}">
                                                                            </td>
                                                                            @php
                                                                                $tableId = $tableId + 1;
                                                                            @endphp
                                                                        @endforeach
                                                                    @endif

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""
                                                                        class="col-form-label">Benefit<span
                                                                            class="text-danger">*</span></label>

                                                                    <select class="form-control form-control-sm"
                                                                        id="">
                                                                        <option value="">Select</option>
                                                                        <option value="">Pick & Drop</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""
                                                                        class="col-form-label">Amount</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for=""
                                                                        class="col-form-label">Effective Date<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group mt-4">
                                                                    <span class="btn btn-success btn-sm"
                                                                        onclick="addFringeBenefitRow(this)">Add</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive"
                                                            style="height: 125px;overflow-y: scroll;">
                                                            <table
                                                                class="table table-striped table-bordered table-hover">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th class="text-center">Benefit</th>
                                                                        <th class="text-center">Amount</th>
                                                                        <th class="text-center">Effective Date</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="data-append-to">
                                                                    <tr id="0">
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>

                                                                        <td id="med_td_action_">
                                                                            <span onclick="removeTableRowOnly(this)"
                                                                                class="btn btn-sm btn-danger"> <i
                                                                                    class='fas fa-trash-alt'></i>
                                                                            </span>
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title "
                                    data-toggle="collapse" data-target="#address_info" aria-expanded="true"
                                    aria-controls="collapseThree">
                                    <strong> 3. Contact Details</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="address_info" class="collapse p-1" aria-labelledby="headingThree"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="present_address"
                                                    class="col-sm-2 col-form-label col-form-label-sm">Present</label>
                                                <div class="col-sm-2">
                                                    <input type="text"
                                                        class=" form-control form-control-sm same_as_pre_add"
                                                        id="present_address" name="present_address"
                                                        value="{{ $present_address }}"
                                                        placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213"
                                                        maxlength="200">
                                                </div>

                                                <label for="doctor_present_district"
                                                    class=" col-form-label col-form-label-sm">District</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control font_size_12 m-auto select2 "
                                                        id="doctor_present_district" name="doctor_present_district">
                                                        <option value="">Select District</option>
                                                        @if (isset($district))
                                                            @foreach ($district as $value)
                                                                <option
                                                                    value="{{ $value->id }} @if ($doctor_present_district == $value->id) selected @endif">
                                                                    {{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <label for=""
                                                    class=" col-form-label col-form-label-sm">Thana</label>
                                                <div class="col-sm-2" id="present_thana">

                                                    @include('admin.hrm.employee.pre_thana')

                                                </div>

                                                <label for="post_code"
                                                    class=" pl-1 col-form-label col-form-label-sm">Country
                                                </label>
                                                <div class="col-sm-2">
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="present_country" name="present_country">
                                                        <option value="Bangladeshi">Bangladesh</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group row">

                                                <label for="parmanent_address"
                                                    class="col-sm-2 col-form-label col-form-label-sm">Permanent
                                                </label>
                                                <div class="col-sm-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"
                                                            title="Same as Prensent Address">
                                                            <div class="input-group-text">
                                                                <input type="checkbox"
                                                                    aria-label="Checkbox for following text input"
                                                                    class="same_pre_and_par" id="same_pre_and_par">
                                                            </div>
                                                        </div>

                                                        <input type="text"
                                                            class="form-control form-control-sm same_as_par_add"
                                                            id="parmanent_address" name="doctor_parmanent_address"
                                                            placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213"
                                                            value="{{ $permanent_address }}" maxlength="200">
                                                    </div>
                                                </div>
                                                <label for="doctor_par_district"
                                                    class="col-form-label col-form-label-sm">District</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control font_size_12 m-auto select2"
                                                        id="doctor_par_district" name="doctor_par_district">
                                                        <option value="0">Select District</option>

                                                        @if (isset($district))

                                                            @foreach ($district as $value)
                                                                <option
                                                                    value="{{ $value->id }}  @if ($doctor_permanent_district == $value->id) selected @endif">
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <label for="doctor_par_district"
                                                    class=" col-form-label col-form-label-sm">Thana</label>
                                                <div class="col-sm-2" id="per_thana">

                                                    @include('admin.hrm.employee.per_thana')

                                                </div>

                                                <label for="post_code"
                                                    class=" pl-1 col-form-label col-form-label-sm">Country
                                                </label>
                                                <div class="col-sm-2">
                                                    <select class="form-control font_size_12 m-auto"
                                                        id="parmanent_country" name="parmanent_country">
                                                        <option value="Bangladeshi">Bangladesh</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    {{-- Phone --}}
                                    <label for="doctor_mobile_no"
                                        class="col-md-3 col-form-label col-form-label-sm"
                                        id="doctor_mobile_no">Phone
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm"
                                            id="doctor_mobile_no" name="doctor_mobile_no"
                                            value="{{ $phone_mobile }}" placeholder="Phone" autocomplete="off"
                                           >
                                    </div>
                                    {{-- Email --}}
                                    <label for="doctor_email"
                                        class="col-md-3 col-form-label col-form-label-sm"
                                        id="doctor_email">Email
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm"
                                            id="doctor_email" name="doctor_email"
                                            value="{{ $email_personal }}" placeholder="Email" autocomplete="off"
                                            >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    
                                    <label for="emergency_contact_name"
                                        class="col-md-3 col-form-label col-form-label-sm"
                                        id="emergency_contact">Emergency Contact Name
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm"
                                            id="emergency_contact_name" name="emergency_contact_name"
                                            value="{{ $doctor_emergency_contact_name }}" placeholder="Emergency Contact Name"
                                            >
                                    </div>
                                       {{-- Emergency Contact --}}
                                       <label for="emergency_contact_relation"
                                       class="col-md-3 col-form-label col-form-label-sm"
                                       id="emergency_contact">Emergency Contact Relation
                                   </label>
                                   <div class="col-sm-3">
                                       <input type="text" class="form-control form-control-sm"
                                           id="emergency_contact_relation" name="emergency_contact_relation"
                                           value="{{ $emergency_contact_relation }}" placeholder="Emergency Contact Relation"
                                           >
                                   </div>
                                </div>
                                <div class="form-group row">

                                     {{-- Emergency Contact --}}
                                     <label for="emergency_contact_contact"
                                     class="col-md-3 col-form-label col-form-label-sm"
                                     id="emergency_contact">Emergency Contact No
                                 </label>
                                 <div class="col-sm-3">
                                     <input type="text" class="form-control form-control-sm"
                                         id="emergency_contact_contact" name="emergency_contact_contact"
                                         value="{{ $doctor_emergency_contact_contact }}" placeholder="Emergency Contact No"
                                         >
                                 </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            {{-- <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>3. Family Info</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="collapseOne" class="collapse show show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="doctor_father"
                                                    class="col-sm-1 col-form-label col-form-label-sm">Father</label>
                                                <div class="col-sm-5">



                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_father" name="doctor_father"
                                                        value="{{ $doctor_father }}" placeholder="Father Name"
                                                        maxlength="50">
                                                </div>

                                                <label for="doctor_father_bangla"
                                                    class="col-sm-2 col-form-label col-form-label-sm">পিতার নাম
                                                    (বাংলা)</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_father_bangla" name="doctor_father_bangla"
                                                        value="{{ $father_name_bangla }}" placeholder="পিতার নাম"
                                                        maxlength="100">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="doctor_mother"
                                                    class="col-sm-1 col-form-label col-form-label-sm">Mother</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_mother" name="doctor_mother"
                                                        value="{{ $doctor_mother }}" placeholder="Mother Name"
                                                        maxlength="50">
                                                </div>

                                                <label for="doctor_mother_bangla"
                                                    class="col-sm-2 col-form-label col-form-label-sm">মাতার নাম
                                                    (বাংলা)</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_mother_bangla" name="doctor_mother_bangla"
                                                        value="{{ $doctor_mother_bangla }}" placeholder="মাতার নাম"
                                                        maxlength="100">
                                                </div>
                                            </div>

                                            <div class="form-group row d-none spouse_name">
                                                <label for="doctor_mother"
                                                    class="col-sm-1 col-form-label col-form-label-sm  ">Spouse</label>
                                                <div class="col-sm-5" class=" ">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_mother" name="doctor_spouse"
                                                        value="{{ $doctor_spouse }}" placeholder="Spouse Name"
                                                        maxlength="50">
                                                </div>

                                                <label for="doctor_mother "
                                                    class="col-sm-2 col-form-label col-form-label-sm  ">Spouse(In
                                                    Bengali)</label>
                                                <div class="col-sm-4" class="  ">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_mother" name="doctor_spouse_bangla"
                                                        value="{{ $spuse_name_bangla }}" placeholder="Spouse Name"
                                                        maxlength="100">
                                                </div>

                                            </div>





                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}




            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                                    aria-controls="collapseFour">
                                    <strong>4. Dependent Info</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="collapseFour" class="collapse p-1" aria-labelledby="headingFour"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <table class="table border-0 mt-2 mb-0" id="mytable">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0 border-0">Name</th>
                                                        <th class="p-0 border-0 w-15">NID</th>
                                                        <th class="p-0 border-0 w-15">Date of Birth</th>
                                                        <th class="p-0 border-0">Relationship</th>
                                                        <th class="p-0 border-0">Photo</th>

                                                    </tr>
                                                </thead>

                                                <tbody id="data-append-to">
                                                    <tr id="0">
                                                        <td class="">
                                                            <input type="text" class="form-control"
                                                                id="dependent_name_0" name="dependent_name[]"
                                                                placeholder="Name">
                                                        </td>

                                                        <td class="">
                                                            <input type="number" class="form-control"
                                                                id="dependent_nid_0" name="dependent_nid[]"
                                                                placeholder="NID" maxlength="17">
                                                        </td>
                                                        <td class="">
                                                            <input type="text" class="form-control date_picker"
                                                                id="dependent_dob_0" name="dependent_dob[]"
                                                                placeholder="DOB">
                                                        </td>
                                                        <td class="">
                                                            <input type="text" class="form-control"
                                                                id="dependent_relationship_0"
                                                                name="dependent_relationship[]"
                                                                placeholder="Relationship" maxlength="100">
                                                        </td>

                                                        <td class="">
                                                            <input type="file" class="form-control"
                                                                id="dependent_photo_0" name="dependent_photo[]">
                                                        </td>

                                                        <td id="med_td_action_0">
                                                            <span onclick="addFamillyMemberRow(this)"
                                                                class="btn btn-md btn-success"> +Add </span>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $tableId = 3;
                                                    @endphp

                                                    @if (!empty($dependentInfo))
                                                        @foreach ($dependentInfo as $dependent)
                                                            <tr id="">
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="dependent_name[]" placeholder="Name"
                                                                        value="{{ $dependent->dependent_name }}">
                                                                </td>

                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                        name="dependent_nid[]" placeholder="NID"
                                                                        value="{{ $dependent->dependent_nid }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        name="dependent_dob[]" placeholder="DOB"
                                                                        value="{{ date('d-m-Y', strtotime($dependent->dependent_dob)) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="dependent_relationship[]"
                                                                        placeholder="Relationship"
                                                                        value="{{ $dependent->relationship }}">
                                                                </td>
                                                                <td class="">
                                                                    <input type="file" class="form-control"
                                                                        id="dependent_photo_0"
                                                                        name="dependent_photo[]">
                                                                </td>
                                                                <td id="med_td_action_">
                                                                    <span onclick="removeFamilyTableRowOnly(this)"
                                                                        class="btn btn-sm btn-danger"> <i
                                                                            class='fa fa-times'></i> </span>
                                                                </td>
                                                            </tr>
                                                            <td>
                                                                <input type="hidden" name="hidden_temp_edu_id[]"
                                                                    value="{{ $dependent->dependent_info_pk }}">
                                                            </td>
                                                            @php
                                                                $tableId = $tableId + 1;
                                                            @endphp
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
                                    aria-controls="collapseFive">
                                    <strong>5. Nominee Info</strong>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="collapseFive" class="collapse p-1" aria-labelledby="headingFive"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <table class="table border-0 mt-2 mb-0" id="mytable">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0 border-0">Nominee Name</th>
                                                        <th class="p-0 border-0 w-15">Nominee NID</th>
                                                        <th class="p-0 border-0 w-15">Date of Birth</th>
                                                        <th class="p-0 border-0">Relationship</th>
                                                        <th class="p-0 border-0">Photo</th>

                                                    </tr>
                                                </thead>

                                                <tbody id="data-append-to">
                                                    <tr id="0">
                                                        <td class="">
                                                            <input type="text" class="form-control"
                                                                id="nominee_name_0" name="nominee_name[]"
                                                                placeholder="Name">
                                                        </td>

                                                        <td class="">
                                                            <input type="number" class="form-control"
                                                                id="nominee_nid_0" name="nominee_nid[]"
                                                                placeholder="NID" maxlength="17">
                                                        </td>
                                                        <td class="">
                                                            <input type="text" class="form-control date_picker"
                                                                id="nominee_dob_0" name="nominee_dob[]"
                                                                placeholder="DOB">
                                                        </td>
                                                        <td class="">
                                                            <input type="text" class="form-control"
                                                                id="nominee_relationship_0"
                                                                name="nominee_relationship[]"
                                                                placeholder="Relationship" maxlength="100">
                                                        </td>

                                                        <td class="">
                                                            <input type="file" class="form-control"
                                                                id="nominee_photo_0" name="nominee_photo[]">
                                                        </td>

                                                        <td id="med_td_action_0">
                                                            <span onclick="addNomineeRow(this)"
                                                                class="btn btn-md btn-success"> +Add </span>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $tableId = 4;
                                                    @endphp

                                                    @if (!empty($nomineeInfo))
                                                        @foreach ($nomineeInfo as $nominee)
                                                            <tr id="">
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="nominee_name[]" placeholder="Name"
                                                                        value="{{ $nominee->nominee_name }}">
                                                                </td>

                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                        name="nominee_nid[]" placeholder="NID"
                                                                        value="{{ $nominee->nominee_nid }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        name="nominee_dob[]" placeholder="DOB"
                                                                        value="{{ date('d-m-Y', strtotime($nominee->nominee_dob)) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="nominee_relationship[]"
                                                                        placeholder="Relationship"
                                                                        value="{{ $nominee->relationship }}">
                                                                </td>
                                                                <td class="">
                                                                    <input type="file" class="form-control"
                                                                        id="nominee_photo_0" name="nominee_photo[]">
                                                                </td>
                                                                <td id="med_td_action_">
                                                                    <span onclick="removeNomineeTableRowOnly(this)"
                                                                        class="btn btn-sm btn-danger"> <i
                                                                            class='fa fa-times'></i> </span>
                                                                </td>
                                                            </tr>
                                                            <td>
                                                                <input type="hidden" name="hidden_temp_edu_id[]"
                                                                    value="{{ $nominee->nominee_info_pk }}">
                                                            </td>
                                                            @php
                                                                $tableId = $tableId + 1;
                                                            @endphp
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            {{-- <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#education_qualification"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <strong> 4. Education & Qualification</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="education_qualification" class="collapse show show p-1"
                                aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <table class="table border-0 mt-2 mb-0" id="mytable">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-0 border-0">Degree Name</th>
                                                                <th class="p-0 border-0 w-15">Result</th>
                                                                <th class="p-0 border-0 w-15">Passing Year</th>
                                                                <th class="p-0 border-0">Board/ Institute</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="data-append-to">
                                                            <tr id="0">
                                                                <td class="">


                                                                    <select
                                                                        class="
                                                                    form-control font_size_12 m-auto select2"
                                                                        name="name[]" id="degree_name_0">
                                                                        <option value="0">Select Degree</option>

                                                                        @if (!empty($degree))
                                                                            @foreach ($degree as $key => $value)
                                                                                <option value="{{ $key }}">
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>

                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control" id="result_0"
                                                                        name="result[]" placeholder="Result"
                                                                        maxlength="20">
                                                                </td>
                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control number_only"
                                                                        id="p_year_0" name="p_year[]"
                                                                        placeholder="Passing Year" maxlength="10">
                                                                </td>
                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control" id="institution_0"
                                                                        name="institution[]"
                                                                        placeholder="Board/Institute" maxlength="100">
                                                                </td>
                                                                <td id="med_td_action_0">
                                                                    <span onclick="addDegreeRow(this)"
                                                                        class="btn btn-md btn-success"> +Add </span>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $tableId = 2;
                                                            @endphp

                                                            @if (!empty($educationInfo))
                                                                @foreach ($educationInfo as $education)
                                                                    <tr id="{{ $tableId }}">
                                                                        <td>


                                                                            <select
                                                                                class="form-control font_size_12 m-auto select2"
                                                                                name="name[]">
                                                                                @if (!empty($degree))
                                                                                    @foreach ($degree as $key => $value)
                                                                                        <option
                                                                                            value="{{ $key }}"
                                                                                            {{ $education->degree_name == $key ? 'selected' : '' }}>
                                                                                            {{ $value }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="result[]" placeholder="Result"
                                                                                value="{{ $education->result_text }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="p_year[]"
                                                                                placeholder="Passing Year"
                                                                                value="{{ $education->passing_year }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="institution[]"
                                                                                placeholder="Board"
                                                                                value="{{ $education->institute_name }}">
                                                                        </td>
                                                                        <td id="med_td_action_{{ $tableId }}">
                                                                            <span onclick="removeTableRowOnly(this)"
                                                                                class="btn btn-sm btn-danger"> <i
                                                                                    class='fa fa-times'></i> </span>
                                                                        </td>
                                                                    </tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            name="hidden_temp_edu_id[]"
                                                                            value="{{ $education->education_no_pk }}">
                                                                    </td>
                                                                    @php
                                                                        $tableId = $tableId + 1;
                                                                    @endphp
                                                                @endforeach
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}




            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#education_qualification"
                                    aria-expanded="true" aria-controls="collapseSix">
                                    <strong> 6. Education & Qualification</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="education_qualification" class="collapse p-1" aria-labelledby="headingSix"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <table class="table border-0 mt-2 mb-0" id="mytable">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-0 border-0">Degree Name</th>
                                                                <th class="p-0 border-0">Major</th>
                                                                <th class="p-0 border-0 w-15">Result</th>
                                                                <th class="p-0 border-0 w-15">Passing Year</th>
                                                                <th class="p-0 border-0">Board/ Institute</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="data-append-to">
                                                            <tr id="0">
                                                                <td class="">
                                                                    <select class="form-control font_size_12 m-auto"
                                                                        name="name[]" id="degree_name_0">
                                                                        <option value="0">Select Degree</option>
                                                                        @if (!empty($degree))
                                                                            @foreach ($degree as $key => $value)
                                                                                <option value="{{ $key }}">
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>

                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        id="major_0" name="major[]"
                                                                        placeholder="Major">
                                                                </td>

                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control" id="result_0"
                                                                        name="result[]" placeholder="Result"
                                                                        maxlength="20">
                                                                </td>
                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control number_only"
                                                                        id="p_year_0" name="p_year[]"
                                                                        placeholder="Passing Year" maxlength="10">
                                                                </td>
                                                                <td class="">
                                                                    <input
                                                                        type="
                                                                    text"
                                                                        class="form-control" id="institution_0"
                                                                        name="institution[]"
                                                                        placeholder="Board/Institute" maxlength="100">
                                                                </td>
                                                                <td id="med_td_action_0">
                                                                    <span onclick="addDegreeRow(this)"
                                                                        class="btn btn-md btn-success"> +Add </span>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $tableId = 5;
                                                            @endphp

                                                            @if (!empty($educationInfo))
                                                                @foreach ($educationInfo as $education)
                                                                    <tr id="">
                                                                        <td>
                                                                            <select
                                                                                class="form-control font_size_12 m-auto select2"
                                                                                name="name[]">
                                                                                @if (!empty($degree))
                                                                                    @foreach ($degree as $key => $value)
                                                                                        <option
                                                                                            value="{{ $key }}"
                                                                                            {{ $education->degree_name == $key ? 'selected' : '' }}>
                                                                                            {{ $value }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="text" class="form-control"
                                                                                id="major_0" name="major[]"
                                                                                placeholder="Major"
                                                                                value="{{ $education->major_sub_or_gr }}">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control" name="result[]"
                                                                                placeholder="Result"
                                                                                value="{{ $education->result_text }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control" name="p_year[]"
                                                                                placeholder="Passing Year"
                                                                                value="{{ $education->passing_year }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="institution[]"
                                                                                placeholder="Board"
                                                                                value="{{ $education->institute_name }}">
                                                                        </td>
                                                                        <td id="med_td_action_{{ $tableId }}">
                                                                            <span onclick="removeTableRowOnly(this)"
                                                                                class="btn btn-sm btn-danger"> <i
                                                                                    class='fa fa-times'></i> </span>
                                                                        </td>
                                                                    </tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            name="hidden_temp_edu_id[]"
                                                                            value="{{ $education->education_no_pk }}">
                                                                    </td>
                                                                    @php
                                                                        $tableId = $tableId + 1;
                                                                    @endphp
                                                                @endforeach
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#work_experience" aria-expanded="true"
                                    aria-controls="collapseSeven">
                                    <strong> 7. Work Experience</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="work_experience" class="collapse p-1" aria-labelledby="headingSeven"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <table class="table border-0 mt-2 mb-0" id="mytable">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-0 border-0">Organization Name</th>
                                                                <th class="p-0 border-0 w-15">Designation</th>
                                                                <th class="p-0 border-0 w-15">Start Date</th>
                                                                <th class="p-0 border-0">End Date</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="data-append-to">
                                                            <tr id="0">
                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        name="we_organization_name[]"
                                                                        id="we_organization_name_0"
                                                                        placeholder="Organization Name">
                                                                </td>

                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        id="we_designation_0"
                                                                        name="we_designation[]"
                                                                        placeholder="Designation" maxlength="60">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        id="we_start_date_0" name="we_start_date[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        id="we_end_date_0" name="we_end_date[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td id="med_td_action_0">
                                                                    <span onclick="addWorkExperienceRow(this)"
                                                                        class="btn btn-md btn-success"> +Add </span>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $tableId = 2;
                                                            @endphp

                                                            @if (!empty($experienceInfo))
                                                                @foreach ($experienceInfo as $experience)
                                                                    <tr id="">
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="we_organization_name[]"
                                                                                value="{{ $experience->company_name }}">
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="we_designation[]"
                                                                                value="{{ $experience->designation_name }}">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control date_picker"
                                                                                name="we_start_date[]"
                                                                                placeholder=""
                                                                                value="{{ date('d-m-Y', strtotime($experience->emp_from_date)) }}">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control date_picker"
                                                                                name="we_end_date[]"
                                                                                value="{{ date('d-m-Y', strtotime($experience->emp_to_date)) }}">
                                                                        </td>
                                                                        <td id="med_td_action_{{ $tableId }}">
                                                                            <span
                                                                                onclick="removeWorkExperienceRowOnly(this)"
                                                                                class="btn btn-sm btn-danger"> <i
                                                                                    class='fa fa-times'></i> </span>
                                                                        </td>
                                                                    </tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            name="hidden_temp_edu_id[]"
                                                                            value="{{ $experience->experience_no_pk }}">
                                                                    </td>
                                                                    @php
                                                                        $tableId = $tableId + 1;
                                                                    @endphp
                                                                @endforeach
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#training_certification"
                                    aria-expanded="true" aria-controls="collapseEight">
                                    <strong> 8. Training and Certification</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="training_certification" class="collapse p-1" aria-labelledby="headingEight"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <table class="table border-0 mt-2 mb-0" id="mytable">
                                                        <thead>
                                                            <tr>
                                                                <th class="p-0 border-0">Certification / Training
                                                                    Tittle</th>
                                                                <th class="p-0 border-0 w-15">Institute Name</th>
                                                                <th class="p-0 border-0 w-15">Start Date</th>
                                                                <th class="p-0 border-0">End Date</th>
                                                                <th class="p-0 border-0">Duration</th>
                                                                <th class="p-0 border-0">Attachment</th>
                                                                <th class="p-0 border-0">Certificate Link</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="data-append-to">
                                                            <tr id="0">
                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        name="tc_title[]" id="tc_title_0"
                                                                        placeholder="Title">
                                                                </td>

                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        id="tc_institute_name_0"
                                                                        name="tc_institute_name[]"
                                                                        placeholder="Institute Name">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        id="tc_start_date_0" name="tc_start_date[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text"
                                                                        class="form-control date_picker"
                                                                        id="tc_end_date_0" name="tc_end_date[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        id="tc_duration_0" name="tc_duration[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td class="">
                                                                    <input type="file" class="form-control"
                                                                        id="tc_attachment_0" name="tc_attachment[]"
                                                                        placeholder="">
                                                                </td>
                                                                <td class="">
                                                                    <input type="text" class="form-control"
                                                                        id="tc_certificate_link_0"
                                                                        name="tc_certificate_link[]" placeholder="">
                                                                </td>
                                                                <td id="med_td_action_0">
                                                                    <span onclick="addTrainingCerticationRow(this)"
                                                                        class="btn btn-md btn-success"> +Add </span>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $tableId = 2;
                                                            @endphp

                                                            @if (!empty($trainingInfo))
                                                                @foreach ($trainingInfo as $training)
                                                                    <tr id="">
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="tc_title[]"
                                                                                value="{{ $training->cert_tr_tittle }}">
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="tc_institute_name[]"
                                                                                value="{{ $training->institute_name }}">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control date_picker"
                                                                                name="tc_start_date[]"
                                                                                placeholder=""
                                                                                value="{{ date('d-m-Y', strtotime($training->emp_from_date)) }}">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control date_picker"
                                                                                name="tc_end_date[]"
                                                                                value="{{ date('d-m-Y', strtotime($training->emp_to_date)) }}">
                                                                        </td>
                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="tc_duration[]"
                                                                                value="{{ $training->training_duration }}">
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="file"
                                                                                class="form-control"
                                                                                name="tc_attachment[]"
                                                                                value="">
                                                                        </td>

                                                                        <td class="">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="tc_certificate_link[]"
                                                                                value="{{ $training->tr_cert_url }}">
                                                                        </td>

                                                                        <td id="med_td_action_{{ $tableId }}">
                                                                            <span
                                                                                onclick="removeTrainingCerticationRowOnly(this)"
                                                                                class="btn btn-sm btn-danger"> <i
                                                                                    class='fa fa-times'></i> </span>
                                                                        </td>
                                                                    </tr>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            name="hidden_temp_training_id[]"
                                                                            value="{{ $training->cert_tr_no_pk }}">
                                                                    </td>
                                                                    @php
                                                                        $tableId = $tableId + 1;
                                                                    @endphp
                                                                @endforeach
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            {{-- <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#bank_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>10. Bank Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="bank_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body pt-2">

                                    <div class="form-group row">


                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Bank Name
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" class=" form-control form-control-sm"
                                                id="bank_name" name="bank_name" value="{{ $bank_name }}"
                                                placeholder="Bank Name" maxlength="50">
                                        </div>
                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm "
                                            id="bank_name">Account Name</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="bank_acc_name" name="bank_acc_name"
                                                value="{{ $bank_acc_name }}" placeholder="Account Name"
                                                maxlength="50">
                                        </div>

                                        <label for="bank_acc_no" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_acc_no">
                                            Account No</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="bank_acc_no" name="bank_acc_no" value="{{ $bank_acc_no }}"
                                                placeholder="Bank Account No." maxlength="50">
                                        </div>
                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Agent Banking Type
                                        </label>
                                        <div class="col-sm-3">
                                            <select class="form-control font_size_12 m-auto" id="agent_banking_type"
                                                name="agent_banking_type">
                                                <option value="0" selected="selected">Select Grade Type
                                                </option>
                                                @if (!empty($agent_banking))
                                                    @foreach ($agent_banking as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $agent_banking_type ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>

                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Acc.
                                            Agent Banking number</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="agent_banking_no" name="agent_banking_no"
                                                value="{{ $agent_banking_no }}" placeholder="Agent Banking Number"
                                                maxlength="20">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}



            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingNine">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#bank_info" aria-expanded="true"
                                    aria-controls="collapseNine">
                                    <strong>9. Bank Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="bank_info" class="collapse p-1" aria-labelledby="headingNine"
                                data-parent="#accordion">
                                <div class="card-body pt-2">

                                    <div class="form-group row">


                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Bank Name
                                        </label>
                                        <div class="col-sm-3">
                                            {{-- <input type="text" class=" form-control form-control-sm"
                                                id="bank_name" name="bank_name" value=""
                                                placeholder="Bank Name" maxlength="50"> --}}
                                            <select class="form-control font_size_12 m-auto required" id="bank"
                                                name="bank">
                                                <option value="">Select Bank</option>
                                                @if (!empty($bank))
                                                    @foreach ($bank as $key => $value)
                                                        <option value="{{ $key }}"
                                                            @if ($bankName == $key) selected @endif>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm "
                                            id="bank_name">Account Name</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="bank_acc_name" name="bank_acc_name"
                                                value="{{ $bank_acc_name }}" placeholder="Account Name"
                                                maxlength="50">
                                        </div> --}}

                                        <label for="bank_acc_no" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_acc_no">
                                            Account No</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="bank_acc_no" name="bank_acc_no" value="{{ $bank_acc_no }}"
                                                placeholder="Bank Account No." maxlength="50">
                                        </div>

                                        <label for="acc_routing_no"
                                            class="col-md-3 col-form-label col-form-label-sm"
                                            id="acc_routing_no">Routing No
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm"
                                                id="acc_routing_no" name="acc_routing_no"
                                                value="{{ $acc_routing_no }}" placeholder="Routing No"
                                                maxlength="50">
                                        </div>
                                        {{-- <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Agent Banking Type
                                        </label>
                                        <div class="col-sm-3">
                                            <select class="form-control font_size_12 m-auto" id="agent_banking_type"
                                                name="agent_banking_type">
                                                <option value="0" selected="selected">Select Grade Type
                                                </option>
                                            </select>
                                        </div> --}}

                                        {{-- <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Acc.
                                            Agent Banking number</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="agent_banking_no" name="agent_banking_no" value=""
                                                placeholder="Agent Banking Number" maxlength="20">
                                        </div> --}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="col-md-12">
                <div class="">
                    <div class=" form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="form-group form-row" id="status_data_ind">
                                        <input type="checkbox" name="employee_ind" value="1"
                                            id="employee_ind" {{ $employee_ind == 1 ? 'checked' : '' }}>
                                        <label for="employee_ind" class=" ml-0 pl-1">Employee
                                        </label>

                                        <input type="checkbox" name="digital_signature_ind" value="1"
                                            id="digital_signature_ind"
                                            {{ $digital_signature_ind == 1 ? 'checked' : '' }}
                                            style="margin-left: 10px;">
                                        <label for="digital_signature_ind" class=" ml-0 pl-1">Digital Signature
                                        </label>

                                        <input type="checkbox" name="doctor_ind" value="1" id="doctor_ind"
                                            {{ $doctor_ind == 1 ? 'checked' : '' }} style="margin-left: 10px;">
                                        <label for="doctor_ind" class=" ml-0 pl-1">Doctor Ind
                                        </label>&nbsp;&nbsp;

                                        <input type="checkbox" name="referral_ind" value="1" id="referral_ind"
                                            {{ $referral_ind == 1 ? 'checked' : '' }}>
                                        <label for="referral_ind" class=" ml-0 pl-1">Referral
                                        </label> &nbsp;&nbsp;

                                        <input type="checkbox" name="payable_ind" value="1" id="payable_ind"
                                        {{ $payable_ind == 1 ? 'checked' : '' }}>
                                        <label for="payable_ind" class=" ml-0 pl-1">Payable
                                        </label>
                                        &nbsp; &nbsp;

                                        <input type="checkbox" name="mpo_ind" value="1" id="mpo_ind"
                                        {{ $mpo_ind == 1 ? 'checked' : '' }}>
                                        <label for="mpo_ind" class=" ml-0 pl-1">MPO
                                        </label>
                                        &nbsp; &nbsp;

                                        <input type="checkbox" name="salary_ind" value="1" id="salary_ind"
                                        {{ $salary_ind == 1 ? 'checked' : '' }}>
                                        <label for="salary_ind" class=" ml-0 pl-1">Salary
                                        </label>
                                        &nbsp; &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


            <div class="col-md-12">
                <div class="">
                    <div class=" form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="form-group form-row" id="status_data_ind">
                                        <input type="checkbox" name="employee_ind" value="1"
                                            id="employee_ind" {{ $employee_ind == 1 ? 'checked' : '' }} checked="true">
                                        <label for="employee_ind" class=" ml-0 pl-1">Employee
                                        </label>

                                        {{-- <input type="checkbox" name="digital_signature_ind" value="1"
                                            id="digital_signature_ind" style="margin-left: 10px;">
                                        <label for="digital_signature_ind" class=" ml-0 pl-1">Digital Signature
                                        </label> --}}

                                        <input type="checkbox" name="doctor_ind" value="1" id="doctor_ind"
                                            {{ $doctor_ind == 1 ? 'checked' : '' }} style="margin-left: 10px;">
                                        <label for="doctor_ind" class=" ml-0 pl-1">Doctor Ind
                                        </label>&nbsp;&nbsp;

                                        {{-- <input type="checkbox" name="referral_ind" value="1"
                                            id="referral_ind">
                                        <label for="referral_ind" class=" ml-0 pl-1">Referral
                                        </label> &nbsp;&nbsp;

                                        <input type="checkbox" name="payable_ind" value="1"
                                            id="payable_ind">
                                        <label for="payable_ind" class=" ml-0 pl-1">Payable
                                        </label>
                                        &nbsp; &nbsp;

                                        <input type="checkbox" name="mpo_ind" value="1" id="mpo_ind">
                                        <label for="mpo_ind" class=" ml-0 pl-1">MPO
                                        </label>
                                        &nbsp; &nbsp; --}}

                                        <input type="checkbox" name="salary_ind" value="1" id="salary_ind" {{ $salary_ind == 1 ? 'checked' : '' }}>
                                        <label for="salary_ind" class=" ml-0 pl-1">Salary
                                        </label>
                                        &nbsp; &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @php
                $doctor_id = '';
                $response_url = route('employee-card', $doctor_id);
                
            @endphp
            <div class="col-md-12">
                <div class="employee_registration">
                    <div class="card">
                        <div class="card-body p-2">
                            <button class="btn btn-md btn-success uhl_save_btn" id="save_update"
                                data-func="afterSaveModal" data-response-url="{{ $response_url }}"
                                title="Click here to save Doctor Information">Save
                            </button>
                            <button type="reset" class="btn btn-md btn-info uhl_common_btn">Reset</button>
                            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
                                title="Click here to go back to Dashboard">Exit</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    $(document).ready(function() {


        $("#hod1").on("keyup", function() {
        var inputValue = $(this).val(); 
        if (inputValue === "") {
           $('#emp_hod1_person_no_fk').val("");
           $('#hod1_name').val("");
        }
        });

        $("#hod2").on("keyup", function(){
            var inputHod2 = $(this).val();
            if (inputHod2 === "") {
                $('#emp_hod2_person_no_fk').val("");
                $('#hod2_name').val("");
            }
        });

        $("#supv1").on("keyup", function(){
            var inputSup1 = $(this).val();
            if (inputSup1 === "") {
                $('#emp_supvisor1_person_no_fk').val("");
                $('#supv1_name').val("");
            }
        });

        $("#supv2").on("keyup", function(){
            var inputSup2 = $(this).val();
            if (inputSup2 === "") {
                $('#emp_supvisor2_person_no_fk').val("");
                $('#supv2_name').val("");
            }
        });


        $("#confirmation_status").change(function() {
            if ($(this).val() === "Confirmed") {
                var joinDate = $("#joining_date").val();

                if (joinDate !== "") {
                    var parsedDate = new Date(joinDate);
                   var y = parsedDate.setMonth(parsedDate.getMonth() + 6);
                    var resultDate = ("0" + parsedDate.getDate()).slice(-2) + "-" + ("0" + (parsedDate
                        .getMonth() + 1)).slice(-2) + "-" + parsedDate.getFullYear();
                    // $("#confirmation_date").val(resultDate);
                }
            }
        });
    });

    $('#card_type').on('change', function() {
        var selectedValue = $(this).val();
        var hdn_card_type_ind = $("#hdn_card_type_ind").val();
        if (selectedValue != hdn_card_type_ind) {
            $.ajax({
            type: 'POST',
            url: '{{ route('get_last_card_number') }}',
            data: {
                selected_value: selectedValue,
            },
            success: function(response) {
                    $("#last_card_no").val(response);

            },
            error: function() {

            }
        }); 
        }else{
            $("#last_card_no").val($("#hdn_card_number").val());
 
        }
      

    });



    openDoctorAutocomplete('#hod1', 'emp_id', "employee_ind", 1, personInfo1);
    openDoctorAutocomplete('#hod2', 'emp_id', "employee_ind", 1, personInfo2);
    openDoctorAutocomplete('#supv1', 'emp_id', "employee_ind", 1, personInfo3);
    openDoctorAutocomplete('#supv2', 'emp_id', "employee_ind", 1, personInfo4);

    function personInfo1(item, obj) {
        console.log(item)
        $("#emp_hod1_person_no_fk").val(item.doctor_id);
        $("#hod1_name").val(item.full_name);

    }


    function personInfo2(item, obj) {
        $("#emp_hod2_person_no_fk").val(item.doctor_id);
        $("#hod2_name").val(item.full_name);
    }

    function personInfo3(item, obj) {
        $("#emp_supvisor1_person_no_fk").val(item.doctor_id);
        $("#supv1_name").val(item.full_name);
    }

    function personInfo4(item, obj) {
        $("#emp_supvisor2_person_no_fk").val(item.doctor_id);
        $("#supv2_name").val(item.full_name);
    }

    $(document).on('click', '#self_referrence', function() {
        if ($('#self_referrence').is(':checked')) {
            var self_referrence = $('#self_referrence').val();
            var ref_name = $('#doctor_first_name').val();
            var ref_id = $('#employee_id').val();
            $('#referrence_name').val(ref_name);
            $('#hdn_referrence_name').val(ref_id);
            // alert(ref_id);
        } else {
            $('#referrence_name').val('');
            $('#hdn_referrence_name').val('');
        }

    })

    $(document).on('click', '#income_tex_ind', function() {
        $('#income_tex_amt').val('');
        if ($('#income_tex_ind').is(':checked')) {
            $('#income_tex').removeClass('d-none');
            $('#income_tex').removeClass('d-none');
        } else {
            $('#income_tex').addClass('d-none');
            $('#income_tex').attr('required', '');
        }
    })

    $(document).ready(function() {

        if ($('#income_tex_ind').is(':checked')) {
            console.log('checked')
            $('#income_tex').removeClass('d-none');
            $('#income_tex').removeClass('d-none');
        } else {
            console.log("uncheck")
            $('#income_tex').addClass('d-none');
            $('#income_tex').attr('required', '');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $('.item_name').each(function() {
            openItemAutocomplete($(this));
        });
        var status = $('#doctor_marital_status').val();
        if (status == 20) {

            $(".spouse_name").removeClass('d-none');
        } else {
            $(".spouse_name").addClass('d-none');
        }

        $('#doctor_marital_status').on('change', function() {
            if (this.value == 20) {
                $(".spouse_name").removeClass('d-none');
            } else {
                $(".spouse_name").addClass('d-none');
            }
        });
        if ($('#salary_ind').is(':checked')) {
            // alert('ok');
            $("#open_salary_view").removeClass('d-none');
        } else {
            $("#open_salary_view").addClass('d-none');
        }

        $('#salary_ind').on('click', function() {
            if ($('#salary_ind').is(':checked')) {
                // alert('ok');
                $("#open_salary_view").removeClass('d-none');
            } else {
                $("#open_salary_view").addClass('d-none');
            }
        });

        if ($('#passport_no').val() != '') {
            $('.expired_date').removeClass('d-none');
        } else {
            $('.expired_date').addClass('d-none');
        }

        $(document).on('focus', '#passport_no', function() {

            $('.expired_date').removeClass('d-none');

        });

        $(document).on('focusout', '#passport_no', function() {

            var data = $('#passport_no').val();
            // alert(data);
            if (data == '') {
                $('.expired_date').addClass('d-none');
            } else {
                $('.expired_date').removeClass('d-none');
            }

        });

        if ($('#salary_factor').val() == 'GRADEBASED') {
            $("#grade").removeClass('d-none');
        } else {
            $("#grade").addClass('d-none');
        }

        if ($('#salary_factor').val() == 'DAILYW') {
            $('.hdn_salary').addClass('d-none');
            $('#daily_wages').removeClass('d-none');
        } else {
            $('.hdn_salary').removeClass('d-none');
            $('#daily_wages').addClass('d-none');
        }

        $('#salary_factor').on('change', function() {
            if (this.value == 'GRADEBASED') {
                // alert('ok');
                $("#grade").removeClass('d-none');
            } else {
                $("#grade").addClass('d-none');
                $('#grade_factor').val('');
                $('#gross_salary').val('');
                $('#basic_salary').val('');
                $('#basic_salary_per').val('');
                $('#attendence_bonus').val('');
                $('#medical_allowance').val('');
                $('#medical_allowance_per').val('');
                $('#ta_da').val('');
                $('#ta_da_per').val('');
                $('#conveyance_allowance').val('');
                $('#conveyance_allowance_per').val('');
                $('#house_rent').val('');
                $('#house_rent_per').val('');
                $('#utility').val('');
                $('#utility_per').val('');
                $('#entertainment').val('');
                $('#entertainment_per').val('');
                $('#festival_bonus').val('');
                $('#festival_bonus_per').val('');
                $('#savings_amount').val('');
            }

            if (this.value == "DAILYW") {
                $('.hdn_salary').addClass('d-none');
                $('#daily_wages').removeClass('d-none');
                $('#grade_factor').val('');
                $('#gross_salary').val('');
                $('#basic_salary').val('');
                $('#basic_salary_per').val('');
                $('#attendence_bonus').val('');
                $('#medical_allowance').val('');
                $('#medical_allowance_per').val('');
                $('#ta_da').val('');
                $('#ta_da_per').val('');
                $('#conveyance_allowance').val('');
                $('#conveyance_allowance_per').val('');
                $('#house_rent').val('');
                $('#house_rent_per').val('');
                $('#utility').val('');
                $('#utility_per').val('');
                $('#entertainment').val('');
                $('#entertainment_per').val('');
                $('#festival_bonus').val('');
                $('#festival_bonus_per').val('');
                $('#savings_amount').val('');

            } else {
                $('.hdn_salary').removeClass('d-none');
                $('#daily_wages').addClass('d-none');
            }
        });


        $(document).on("change", "#grade_factor", function(e) {
            var grade_value = $(this).val();
            // var formAction = $("#frmSearch").attr("action");
            // alert(grade_value);

            $.ajax({
                url: "{{ route('grade_factor') }}",
                type: 'GET',
                data: {
                    grade_value: grade_value
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#salary_info_amt").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });




        $(document).on("change", "#doctor_present_district", function(e) {
            var disct_value = $(this).val();
            $.ajax({
                url: "{{ route('all_thana_pre') }}",
                type: 'GET',
                data: {
                    disct_value: disct_value
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#present_thana").html(data);
                    $('.select2').select2();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            // alert(disct_value);
        });
        $(document).on("change", "#doctor_par_district ", function(e) {
            var disct_value = $(this).val();
            $.ajax({
                url: "{{ route('all_thana_per') }}",
                type: 'GET',
                data: {
                    disct_value: disct_value
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#per_thana").html(data);
                    var pre_thana = $('#doctor_present_thana').val();
                    if ($("#same_pre_and_par").is(':checked')) {
                        $('#doctor_pe_thana').val(pre_thana);
                    }
                    $('.select2').select2();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            // alert(disct_value);
        });


        $(document).on("click", "#same_pre_and_par", function() {
            var pre_addr = $('#present_address').val();
            var pre_distric = $('#doctor_present_district').val();
            var pre_thana = $('#doctor_present_thana').val();
            var pre_country = $('#present_country').val();

            if ($(this).is(':checked')) {
                $('#parmanent_address').val(pre_addr);
                $('#doctor_par_district').val(pre_distric).trigger('change');
                $('#parmanent_country').val(pre_country);
                $('#doctor_pe_thana').val(pre_thana).trigger('change');

                $('#parmanent_address').attr('readonly', true);
                $("#doctor_par_district").attr("readonly", true);
                $('#parmanent_country').attr("readonly", true);
                $('#doctor_pe_thana').attr("readonly", true);
                //$("#par_district").select2("readonly", true);
                //$('.select2 option:selected').attr('readonly','readonly');
            } else {
                $('#parmanent_address').attr('readonly', false);
                $('#doctor_par_district').attr('readonly', false);
                $('#doctor_pe_thana').attr('readonly', false);
                $('#parmanent_country').attr('readonly', false);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });


        $(document).on('change', '#login_information', function() {
            if ($(this).is(':checked')) {
                $(this).parents('#login_information').siblings('#referrer_name_con').removeClass(
                    'd-none');
            } else {
                $(this).parents('#login_information').siblings('#referrer_name_con').addClass('d-none');
            }

        });
        $('.select2').select2();
    });

    function addDegreeRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');

        row.find('#degree_name_' + oldId).attr('id', 'degree_name_' + newId).val($(thisElement).parent('td').parent(
            'tr').find(
            '#degree_name_' + oldId).val());

        $('#degree_name_0').val('0').select2({
            data: [{
                id: '',
                text: 'Select Degree'
            }]
        });
        /*        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
                $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
                $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
                $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');
                $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('DAY');
                $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('');
                $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
                $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');*/

        // $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('Select');
        // $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#major_' + oldId).val('');
        $(thisElement).parents('tbody').find('#p_year_' + oldId).val('');

        $(thisElement).parents('tbody').find('#institution_' + oldId).val('');

        $(thisElement).parents('tbody').find('#result_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }


    function addFamillyMemberRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');



        row.find('#dependent_name_' + oldId).attr('id', 'dependent_name_' + newId).val($(thisElement).parents('tbody')
            .find('#dependent_name_' + oldId).val());
        $(thisElement).parents('tbody').find('#dependent_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#dependent_nid_' + oldId).val('');

        $(thisElement).parents('tbody').find('#dependent_dob_' + oldId).val('');

        $(thisElement).parents('tbody').find('#dependent_relationship_' + oldId).val('');

        $(thisElement).parents('tbody').find('#dependent_photo_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeFamilyTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeFamilyTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }


    function addNomineeRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');



        row.find('#nominee_name_' + oldId).attr('id', 'nominee_name_' + newId).val($(thisElement).parents('tbody')
            .find('#nominee_name_' + oldId).val());

        $(thisElement).parents('tbody').find('#nominee_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#nominee_nid_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_dob_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_relationship_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_photo_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeNomineeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeNomineeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }


    function addWorkExperienceRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');

        row.find('#we_organization_name_' + oldId).attr('id', 'we_organization_name_' + newId).val($(thisElement)
            .parents('tbody')
            .find(
                '#we_organization_name_' + oldId).val());
        $(thisElement).parents('tbody').find('#we_organization_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#we_designation_' + oldId).val('');

        $(thisElement).parents('tbody').find('#we_start_date_' + oldId).val('');

        $(thisElement).parents('tbody').find('#we_end_date_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeWorkExperienceRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeWorkExperienceRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }



    function addNomineeRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');



        row.find('#nominee_name_' + oldId).attr('id', 'nominee_name_' + newId).val($(thisElement).parents('tbody')
            .find('#nominee_name_' + oldId).val());

        $(thisElement).parents('tbody').find('#nominee_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#nominee_nid_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_dob_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_relationship_' + oldId).val('');

        $(thisElement).parents('tbody').find('#nominee_photo_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeNomineeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }



    function addTrainingCerticationRow(thisElement) {
        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;

        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');

        row.find('#tc_title_' + oldId).attr('id', 'tc_title_' + newId).val($(thisElement)
            .parents('tbody').find('#tc_title_' + oldId).val());

        $(thisElement).parents('tbody').find('#tc_title_' + oldId).val('');
        $(thisElement).parents('tbody').find('#tc_institute_name_' + oldId).val('');

        $(thisElement).parents('tbody').find('#tc_start_date_' + oldId).val('');

        $(thisElement).parents('tbody').find('#tc_end_date_' + oldId).val('');
        $(thisElement).parents('tbody').find('#tc_duration_' + oldId).val('');
        $(thisElement).parents('tbody').find('#tc_attachment_' + oldId).val('');
        $(thisElement).parents('tbody').find('#tc_certificate_link_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTrainingCerticationRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeTrainingCerticationRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }



    function addFringeBenefitRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        // alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');


        row.find('#benefit_name_' + oldId).attr('id', 'benefit_name_' + newId).val($(thisElement).parent('td').parent(
            'tr').find('#benefit_name_' + oldId).val());

        // row.find('#benefit_name_' + oldId).attr('id', 'benefit_name_' + newId).val($(thisElement).parents('tbody')
        //     .find('#benefit_name_' + oldId).val());
        // $(thisElement).parents('tbody').find('#benefit_name_' + oldId).val('Select');
        $(thisElement).parents('tbody').find('#benefit_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#benefit_amount_' + oldId).val('');

        $(thisElement).parents('tbody').find('#benefit_eff_date_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeFringeBenefitTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeFringeBenefitTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }




    $(function() {

        $(document).on("click", '#save_update', function(e) {
            if (confirm("Are you sure?")) {
                var page_type = "{{ $page_type }}";
                $('#doctor_form').unbind().submit(function(e) {
                    e.preventDefault();
                    var formAction = $(this).attr("action");
                    var formMethod = $(this).attr("method");
                    var formData = new FormData(this);
                    var customFunc = $("#save_update").attr("data-func");

                    $.ajax({
                        type: formMethod,
                        url: formAction,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            if (customFunc == "") {
                                if (isAModalOpen)
                                    $('.modal').modal('hide');

                                $('.common-modal-notify').modal('show');
                                $('.common-modal-notify .modal-body').html(
                                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                                );
                            }
                            blockUI();
                        },
                        success: function(data) {
                            var response_url = $("#save_update").attr(
                                "data-response-url") + "/" + data.insert_id;
                            dynamicFunc.afterSaveModal(response_url,
                                "common-modal-sm",
                                "Employee Card");

                            // marketing
                            //$("#referrer_name_con").val(data.insert_id);

                            $(this).find("input, textarea").not('.keep_me').val("");
                            $(this).find("select").not('.keep_me').val("0");
                        },
                        error: function(data) {

                        },
                        complete: function() {
                            $.unblockUI();
                            if (page_type == 'edit')
                                // dynamicFunc.afterSaveLoadList(
                                //     "{{ route('v1.hrm.employees.list_v1') }}");

                                $.ajax({
                                    async: false,
                                    url: "{{ route('v1.hrm.employees.list_v1') }}",
                                    type: "get",
                                    beforeSend: function() {
                                        blockUI();
                                        //$('.data-table').DataTable().destroy();
                                    },
                                    success: function(data) {
                                        $("#page-content").html(data);
                                    },
                                    complete: function(data) {
                                        $.unblockUI();
                                    }
                                });
                        },
                        error: function(data) {
                            var errors = jQuery.parseJSON(data.responseText).msg;

                            error_messages = "";
                            for (messages in errors) {
                                var field_name = $("#" + messages).siblings("label")
                                    .html();
                                error_messages +=
                                    "<div class='alert alert-danger' role='alert'>" +
                                    errors[messages] + "</div>";
                            }
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html(
                                "Validation Error");
                            $('.common-modal-notify-error .modal-body').html(
                                errors);
                            finished = false;
                            $.unblockUI();
                        }
                    });
                });
                e.stopImmediatePropagation();
            }
        });
    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).ready(function() {
        $(document).on('change', '#status_ind', function() {
            if ($(this).is(':checked')) {
                $('#status_data').removeClass('d-none');
            } else {
                $('#status_data').addClass('d-none');
            }
        });
    });

    function calculateAmt(element) {
        var id = $(element).attr('id');
        var salary_factor = $('#salary_factor').find(':selected').val();
        var percent = $(element).val();
        var gross_salary = $('#gross_salary').val() != "" ? Number($('#gross_salary').val()) : 0;

        var basic_salary_per = $('#basic_salary_per').val() != "" ? parseFloat($('#basic_salary_per').val()) : 0;
        var medical_allowance_per = $('#medical_allowance_per').val() != "" ? parseFloat($('#medical_allowance_per')
            .val()) : 0;
        var house_rent_per = $('#house_rent_per').val() != "" ? parseFloat($('#house_rent_per').val()) : 0;
        var utility_per = $('#utility_per').val() != "" ? parseFloat($('#utility_per').val()) : 0;
        var Conveyance_allowance_per = $('#conveyance_allowance_per').val() != "" ? parseFloat($(
            '#conveyance_allowance_per').val()) : 0;
        var entertainment_per = $('#entertainment_per').val() != "" ? parseFloat($('#entertainment_per').val()) : 0;
        var ta_da_per = $('#ta_da_per').val() != "" ? parseFloat($('#ta_da_per').val()) : 0;
        var other_allow_perc = $('#other_allow_perc').val() != "" ? parseFloat($('#other_allow_perc').val()) : 0;
        var total_prec = Number(basic_salary_per) + Number(medical_allowance_per) + Number(house_rent_per) + Number(
                utility_per) +
            Number(Conveyance_allowance_per) + Number(entertainment_per) + Number(ta_da_per) + Number(other_allow_perc);

        if (total_prec > 100) {
            alert('Maximum Percent error');
            $('#' + id).val('');
            $('#' + id + '_per').val('');
            return false;
        }
        console.log('Total', typeof(total_prec));
        if (salary_factor == "STRUCTPERC" && gross_salary > 0 && total_prec <= 100) {
            var cal_amt = (gross_salary * percent) / 100;

            if (id == "basic_salary_per") {
                $('#basic_salary').val(cal_amt);
            } else if (id == "medical_allowance_per") {
                $('#medical_allowance').val(cal_amt);

            } else if (id == "house_rent_per") {
                $('#house_rent').val(cal_amt);

            } else if (id == "utility_per") {
                $('#utility').val(cal_amt);

            } else if (id == "conveyance_allowance_per") {
                $('#conveyance_allowance').val(cal_amt);

            } else if (id == "entertainment_per") {
                $('#entertainment').val(cal_amt);

            } else if (id == "festival_bonus_per") {
                $('#festival_bonus').val(cal_amt);

            } else if (id == "ta_da_per") {
                $('#ta_da').val(cal_amt);
            } else if (id == "other_allow_perc") {
                $('#other_allowance').val(cal_amt);
            }

        } else {
            if (total_prec > 100) {
                $(element).val('');
                calculateAmt(element);
                alert('Enter Percent less then 100');
            }
            if (salary_factor == "STRUCTPERC" && gross_salary > 0) {
                alert('Select   "Structure (p%)" and "Gross Salary"');
            }

        }
    }


    function calculateAmtOnValue(element) {
        var id = $(element).attr('id');
        var salary_factor = $('#salary_factor').find(':selected').val();
        var percent = $(element).val();
        var gross_salary = $('#gross_salary').val() != "" ? Number($('#gross_salary').val()) : 0;

        var basic_salary_per = $('#basic_salary_per').val() != "" ? parseFloat($('#basic_salary_per').val()) : 0;
        var medical_allowance_per = $('#medical_allowance_per').val() != "" ? parseFloat($('#medical_allowance_per')
            .val()) : 0;
        var house_rent_per = $('#house_rent_per').val() != "" ? parseFloat($('#house_rent_per').val()) : 0;
        var utility_per = $('#utility_per').val() != "" ? parseFloat($('#utility_per').val()) : 0;
        var Conveyance_allowance_per = $('#conveyance_allowance_per').val() != "" ? parseFloat($(
            '#conveyance_allowance_per').val()) : 0;
        var entertainment_per = $('#entertainment_per').val() != "" ? parseFloat($('#entertainment_per').val()) : 0;
        var ta_da_per = $('#ta_da_per').val() != "" ? parseFloat($('#ta_da_per').val()) : 0;
        var other_allow_perc = $('#other_allow_perc').val() != "" ? parseFloat($('#other_allow_perc').val()) : 0;
        var total_prec = Number(basic_salary_per) + Number(medical_allowance_per) + Number(house_rent_per) + Number(
                utility_per) +
            Number(Conveyance_allowance_per) + Number(entertainment_per) + Number(ta_da_per) + Number(other_allow_perc);

        if (total_prec > 100) {
            alert('Maximum Percent error');
            $('#' + id).val('');
            $('#' + id + '_per').val('');
            return false;
        }

        if (salary_factor == "STRUCTPERC" && gross_salary > 0 && total_prec <= 100) {
            var cal_amt = (100 * percent) / gross_salary;
            cal_amt = cal_amt.toFixed(2)

            if (id == "basic_salary") {
                $('#basic_salary_per').val(cal_amt);
            } else if (id == "medical_allowance") {
                $('#medical_allowance_per').val(cal_amt);

            } else if (id == "house_rent") {
                $('#house_rent_per').val(cal_amt);

            } else if (id == "utility") {
                $('#utility_per').val(cal_amt);

            } else if (id == "conveyance_allowance") {
                $('#conveyance_allowance_per').val(cal_amt);

            } else if (id == "entertainment") {
                $('#entertainment_per').val(cal_amt);

            } else if (id == "festival_bonus") {
                $('#festival_bonus_per').val(cal_amt);

            } else if (id == "ta_da") {
                $('#ta_da_per').val(cal_amt);
            } else if (id == "other_allowance") {
                $('#other_allow_perc').val(cal_amt);
            }

        } else {
            if (total_prec > 100) {
                $(element).val('');
                calculateAmtOnValue(element);
                alert('Enter Percent less then 100');
            }
            if (salary_factor == "STRUCTPERC" && gross_salary > 0) {
                alert('Select   "Structure (p%)" and "Gross Salary"');
            }

        }
    }
</script>
{{-- //towhid --}}

<script>
    function updateNIDName() {
        const firstName = document.getElementById('doctor_first_name').value.trim();
        const lastName = document.getElementById('doctor_last_name').value.trim();
        const fullName = [firstName, lastName].filter(Boolean).join(' ');
        document.getElementById('doctor_nid_name').value = fullName;
    }

    document.getElementById('doctor_first_name').addEventListener('input', updateNIDName);
    document.getElementById('doctor_last_name').addEventListener('input', updateNIDName);
</script>
