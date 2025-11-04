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

    $out_uid = isset($out_uid) && Session::get('user.ses_hospital_code') != 'IMPERIAL' ? $out_uid : '';
    $doctor_code = $doctor ? $doctor->person_code : $out_uid;
    $doctor_no_pk = $doctor ? $doctor->person_no_pk : '';
    $ref_agent_person_no_fk = $doctor ? $doctor->ref_agent_person_no_fk : '';
    $apps_user = $doctor ? $doctor->apps_user_ind : '';
    $passcode = $doctor ? $doctor->agent_access_code : '';
    // $employee_ind = $doctor ? $doctor->employee_ind : '';
    $employee_ind = (!isset($doctor->employee_ind)) ? 1 : ($doctor ? $doctor->employee_ind : '');
    $doctor_ind = $doctor ? $doctor->doctor_ind : '';
    $referral_ind = $doctor ? $doctor->referal_ind : '';
    $payable_ind = $doctor ? $doctor->referral_payable_ind : '';
    $mpo_ind = $doctor ? $doctor->mpo_ind : '';
    $salary_ind = $doctor ? $doctor->salary_ind : '';
    $doctor_salutation = $doctor ? $doctor->salutation : '';
    $doctor_first_name = $doctor ? $doctor->fname : '';
    $doctor_last_name = $doctor ? $doctor->lname : '';
    $doctor_age = $doctor ? $doctor->age : '';
    $doctor_date_of_birth = $doctor ? $doctor->dob : '';

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
    $emergency_contact_contact = $doctor ? $doctor->emergency_contact_contact : '';
    $doctor_blood_group = $doctor ? $doctor->blood_group_lookup_no_fk : '';
    $doctor_job_type = $doctor ? $doctor->job_type_lookup_no_fk : '';
    $doctor_hr_type = $doctor ? $doctor->hr_type_lookup_no_fk : '';
    $doctor_emp_type = $doctor ? $doctor->emp_type_lookup_no_fk : '';
    $doctor_job_title = $doctor ? $doctor->jobtitle_lookup_no_fk : '';
    $grade_no_fk = $doctor ? $doctor->grade_no_fk : '';
    $roster_type = $doctor ? $doctor->duty_roster_type : '';
    $inactivate_resson = $doctor ? $doctor->inactivate_resson : '';
    $emp_status = $doctor ? $doctor->emp_status : '';
    $inactivate_date = $doctor ? $doctor->inactivate_date : '';

    $bank_name = $doctor ? $doctor->bank_name : '';
    $bank_acc_no = $doctor ? $doctor->bank_acc_no : '';
    $bank_acc_name = $doctor ? $doctor->bank_acc_name : '';
    $agent_banking_type = $doctor ? $doctor->agent_banking_type : '';
    $agent_banking_no = $doctor ? $doctor->agent_banking_no : '';
    $security_money_amount = $doctor ? $doctor->security_money_amount : '';
    $security_money_received_date = $doctor ? $doctor->security_money_received_date : '';

    $photo_name = $doctor ? $doctor->photo_name : '';

    $department = $doctor ? $doctor->serviceunit_no_fk : '';
    $doctor_join_date = $doctor ? $doctor->join_date : '';

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
    $doctor_benifit_tpye = $doctor ? $doctor->benefit_type_no_fk : '';
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
    $doctor_specialization = $doctor ? $doctor->specialization_lookup_no_fk : '';
    $doctor_signature = $doctor ? $doctor->doctor_signature : '';
    $serviceunit_no_pk = $doctor ? $doctor->serviceunit_no_fk : '';
    $serviceunit_no_fk_dept = $doctor ? $doctor->serviceunit_no_fk_dept : '';
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

    $internal_doctor_ind = $doctor ? $doctor->internal_doctor_ind : '';
    $external_doctor_ind = $doctor ? $doctor->external_doctor_ind : '';

    $leave_type = $doctor ? $doctor->leave_category_lookup_no_fk : '';
    $emp_hod1_person_no_fk = $doctor ? $doctor->emp_hod1_person_no_fk : '';
    $emp_hod2_person_no_fk = $doctor ? $doctor->emp_hod2_person_no_fk : '';
    $emp_supvisor1_person_no_fk = $doctor ? $doctor->emp_supvisor1_person_no_fk : '';

    $hod1_name = isset($hod1_name) && !empty($hod1_name) ? $hod1_name : [];
    $hod2_name = isset($hod2_name) && !empty($hod2_name) ? $hod2_name : [];
    $sup1_name = isset($sup1_name) && !empty($sup1_name) ? $sup1_name : [];

    $hname1 = $hod1_name ? $hod1_name->hname1 : '';
    $hname2 = $hod2_name ? $hod2_name->hname2 : '';
    $supname1 = $sup1_name ? $sup1_name->supname1 : '';
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<form method="post" id="doctor_form" action="{{ route('doctor.store') }}">
    @csrf
    <input type="hidden" name="page_name" value="employee_create_or_edit" />

    <input type="hidden" name="id" id="" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="" id="employee_id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="employee" value="EMP">

    <div class="form-row">
        <div class="col-md-12">
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
                                            <div class="form-group row">
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
                                            </div>

                                            <div class="form-group row">

                                                <label for="doctor_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Employee
                                                    Name
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="doctor_salutation" name="doctor_salutation">
                                                                <!-- <option value="MR." {{ $doctor_salutation == 'MR.' ? 'selected' : '' }}>MR.
                                                    </option>
                                                    <option value="MRS." {{ $doctor_salutation == 'MRS.' ? 'selected' : '' }}>MRS.
                                                    </option>
                                                    <option value="MD." {{ $doctor_salutation == 'MD.' ? 'selected' : '' }}>MD.
                                                    </option>
                                                    <option value="MST." {{ $doctor_salutation == 'MST.' ? 'selected' : '' }}>MST.
                                                    </option> -->

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
                                                        {{-- onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" --}}
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize "
                                                            id="doctor_last_name" name="doctor_last_name"
                                                            value="{{ $doctor_last_name }}" placeholder="Last Name">
                                                    </div>
                                                </div>
                                                <label for="doctor_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">
                                                    নাম (বাংলা)
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">

                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize "
                                                            id="doctor_full_name_bangla" name="doctor_full_name_bangla"
                                                            value="{{ $full_name_bangla }}"
                                                            placeholder="Employee Name">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="doctor_gender"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Gender
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto required"
                                                        id="doctor_gender" name="doctor_gender" required>
                                                        <option value="">Select Gender</option>
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

                                                <label for=""
                                                    class="col-sm-3 col-form-label col-form-label-sm">Mobile
                                                    Number <span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="doctor_mobile_no" name="doctor_mobile_no"
                                                        value="{{ $phone_mobile }}" placeholder="Mobile No" required
                                                        maxlength="30">
                                                </div>

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
                                                        id="doctor_nationality" name="doctor_nationality"
                                                        value="{{ $doctor_nationality }}">
                                                        <option value="Bangladeshi">Bangladeshi</option>
                                                        <option value="Others">Others</option>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group row">

                                                <label for="doctor_nid"
                                                    class="col-sm-3 col-form-label col-form-label-sm"> NID</label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm number_only"
                                                        id="doctor_nid" name="doctor_nid"
                                                        value="{{ $doctor_nid }}" placeholder=" NID No"
                                                        maxlength="17">
                                                </div>


                                                <label for="doctor_nationality"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Email<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="email" class="form-control form-control-sm "
                                                        id="doctor_email" name="doctor_email"
                                                        value="{{ $email_personal }}" placeholder="Employee Email"
                                                        maxlength="50"
                                                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
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
                                                    class="col-sm-3 col-form-label col-form-label-sm  ">Expaired
                                                    Date </label>
                                                <div class="col-sm-3 ">
                                                    <input type="text"
                                                        class="form-control form-control-sm text-capitalize date_picker"
                                                        id="expired_date" name="expired_date"
                                                        value="{{ $passport_expire_date != '' ? date('d-m-Y', strtotime($passport_expire_date)) : '' }}"
                                                        placeholder="DD/MM/YYYY">
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
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title "
                                    data-toggle="collapse" data-target="#address_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 2. Address Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="address_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="present_address"
                                                    class="col-sm-2 col-form-label col-form-label-sm">Present <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text"
                                                        class=" form-control form-control-sm same_as_pre_add required"
                                                        id="present_address" name="present_address"
                                                        value="{{ $present_address }}"
                                                        placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213"
                                                        required maxlength="200">
                                                </div>

                                                <label for="doctor_present_district"
                                                    class=" col-form-label col-form-label-sm">District</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control font_size_12 m-auto select2 "
                                                        id="doctor_present_district" name="doctor_present_district">
                                                        <option value="">Select District</option>
                                                        @if (isset($district))
                                                            @foreach ($district as $value)
                                                                <option value="{{ $value->id }}"
                                                                    @if ($doctor_present_district == $value->id) selected @endif>
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
                                                                <option value="{{ $value->id }}"
                                                                    @if ($doctor_permanent_district == $value->id) selected @endif>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
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

                                            <div class="form-group row">
                                                <label for="emergency_contact"
                                                    class="col-sm-1 col-form-label col-form-label-sm">Emergency Contact</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control form-control-sm number_only"
                                                        id="emergency_contact" name="emergency_contact"
                                                        value="{{ $emergency_contact_contact }}" placeholder="Emergency Contact Number"
                                                        maxlength="15">
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
                                                                <th class="p-0 border-0">Major/Subject</th>
                                                                <th class="p-0 border-0 w-15">Result</th>
                                                                <th class="p-0 border-0 w-15">Passing Year</th>
                                                                <th class="p-0 border-0">Board/Institute</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="data-append-to">
                                                            <tr id="0">
                                                                <td class="">


                                                                    <select
                                                                        class="
                                                                    form-control font_size_12 m-auto select2X"
                                                                        name="name[]" class="degree_name_0">
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
                                                                        class="form-control" id="major_0"
                                                                        name="major[]" placeholder="Major/Subject">
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
                                                                                class="form-control font_size_12 m-auto select2X"
                                                                                name="name[]">
                                                                                <option value="0">Select Degree</option>
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
                                                                                name="major[]" placeholder="Major/Subject"
                                                                                value="{{ $education->major_sub_or_gr }}">
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
            </div>
            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#office_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>5. Office Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="office_info" class="collapse show  p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-row">
                                                <div class="col-md-9">

                                                    <div class="form-group row">
                                                        <label for="doctor_job_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Job Type
                                                            <span class="text-danger">*</span></label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto required"
                                                                id="doctor_job_type" name="doctor_job_type" required>
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
                                                        <label for="doctor_specialization"
                                                            class="col-sm-3 col-form-label col-form-label-sm ">Specialization</label>
                                                        <div class="col-sm-3  ">
                                                            <select class="form-control font_size_12 m-auto select2X"
                                                                id="doctor_specialization"
                                                                name="doctor_specialization">
                                                                <option value="">Select Specialization</option>
                                                                @if (isset($specialization))
                                                                    @foreach ($specialization as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($doctor_specialization == $key) selected @endif>

                                                                            {{ strtoupper($value) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>


                                                    </div>
                                                    <div class="form-group row specialization">
                                                        <label for="serviceunit_no_fk_dept"
                                                            class="col-md-3 col-form-label col-form-label-sm ">Department
                                                        </label>
                                                        <div class="col-md-3">
                                                            <select class="form-control form-control-sm  select2 "
                                                                id="serviceunit_no_fk_dept" name="serviceunit_no_fk_dept">
                                                                <option value="">Select Department</option>
                                                                @if (!empty($service_unit))
                                                                    @foreach ($service_unit as $service)
                                                                        <option
                                                                            value="{{ $service->serviceunit_no_pk }}"
                                                                            @if ($service->serviceunit_no_pk == $serviceunit_no_fk_dept) selected @endif>
                                                                            {{ strtoupper($service->serviceunit_name) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <label for="doctor_ser_unit"
                                                            class="col-md-3 col-form-label col-form-label-sm ">Unit
                                                        </label>
                                                        <div class="col-md-3">
                                                            <select class="form-control form-control-sm  select2 "
                                                                id="doctor_ser_unit" name="doctor_ser_unit">
                                                                <option value="">Select Unit</option>
                                                                @if (!empty($units))
                                                                    @foreach ($units as $unit)
                                                                        <option
                                                                            value="{{ $unit->serviceunit_no_pk }}"
                                                                            @if ($unit->serviceunit_no_pk == $serviceunit_no_pk) selected @endif>
                                                                            {{ strtoupper($unit->serviceunit_name) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group row">

                                                        <!-- <label for="department"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Department</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto "
                                                                id="department" name="department">
                                                                <option value="">Select Department</option>
                                                                @if (isset($dept))
@foreach ($dept as $key => $val)
<option value="{{ $key }}"
                                                                            @if ($department == $key) selected @endif>
                                                                            {{ $val }}
                                                                        </option>
@endforeach
@endif
                                                            </select>
                                                        </div> -->
                                                        <label for="doctor_job_title"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Designation</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto select2"
                                                                id="doctor_job_title" name="doctor_job_title">
                                                                <option value="0">Select Designation</option>
                                                                @if (isset($job_title))
                                                                    @foreach ($job_title as $record)
                                                                        <option
                                                                            value="{{ $record->designation_no_pk }}"
                                                                            @if ($doctor_job_title == $record->designation_no_pk) selected @endif>
                                                                            {{ $record->designation_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <label for="doctor_job_title"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Employee
                                                            Serial</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto select2"
                                                                id="emp_serial_in_salary_sheet"
                                                                name="emp_serial_in_salary_sheet">
                                                                <option value="0">Select Employee Serial</option>
                                                                @for ($i = 1; $i <= 23; $i++)
                                                                    <option value="{{ $i }}"
                                                                        @if (intval($emp_serial_in_salary_sheet) === $i) selected @endif>
                                                                        Serial-{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="doctor_hr_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm"> HR
                                                            Attendance
                                                            Type</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="doctor_hr_type" name="doctor_hr_type">
                                                                <option value="0">Select Attendance Type</option>
                                                                @if (isset($hr_type))
                                                                    @foreach ($hr_type as $key => $val)
                                                                        <option value="{{ $key }}"
                                                                            @if ($doctor_hr_type == $key) selected @endif>
                                                                            {{ $val }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                        <label for="doctor_join_date"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Join
                                                            Date</label>
                                                        <div class="col-sm-3">
                                                            <input type="text"
                                                                class="form-control form-control-sm date_picker"
                                                                id="doctor_join_date" name="doctor_join_date"
                                                                value="{{ $doctor_join_date != '' ? date('d-m-Y', strtotime($doctor_join_date)) : '' }}"
                                                                placeholder="DD/MM/YYYY">
                                                        </div>

                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="doctor_card_number"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Card
                                                            Number</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="doctor_card_number" name="doctor_card_number"
                                                                value="{{ $doctor_card_number }}"
                                                                placeholder="Card Number" maxlength="30">
                                                        </div>

                                                        <label for="emp_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Emp.
                                                            Type</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="emp_type" name="emp_type">
                                                                <option value="0" selected="selected">Select Emp.
                                                                    Type
                                                                </option>
                                                                @if (isset($emp_type))
                                                                    @foreach ($emp_type as $key => $val)
                                                                        <option value="{{ $key }}"
                                                                            @if ($doctor_emp_type == $key) selected @endif>
                                                                            {{ $val }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="doctor_lic_no"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Professional
                                                            License No</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="doctor_lic_no" name="doctor_lic_no"
                                                                value="{{ $doctor_lic_no }}"
                                                                placeholder="Professional License No" maxlength="50">
                                                        </div>
                                                        <label for="doctor_lic_issue_date"
                                                            class="col-sm-3 col-form-label col-form-label-sm">
                                                            License Issue Date</label>
                                                        <div class="col-sm-3">
                                                            <input type="text"
                                                                class="form-control form-control-sm date_picker"
                                                                id="doctor_lic_issue_date"
                                                                name="doctor_lic_issue_date"
                                                                value="{{ $doctor_lic_issue_date }}"
                                                                placeholder="DD/MM/YYYY" maxlength="50">
                                                        </div>

                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="emp_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Marketing
                                                            Type</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="marketing_type" name="marketing_type">
                                                                <option value="0" selected="selected">Select
                                                                    Marketing
                                                                    Type
                                                                </option>
                                                                <option value="1"
                                                                    {{ $referral_agent_ind == 1 ? 'selected' : '' }}>
                                                                    Referal</option>
                                                                <option value="2"
                                                                    {{ $referral_agent_ind == 2 ? 'selected' : '' }}>
                                                                    Agent</option>

                                                            </select>
                                                        </div>

                                                        <label for="roster_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Roster
                                                            Type</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="roster_type" name="roster_type">
                                                                <option value="" selected="selected">Select
                                                                    Roster Type
                                                                </option>
                                                                <option value="General"
                                                                    {{ $roster_type == 'General' ? 'selected' : '' }}>
                                                                    General
                                                                </option>
                                                                <option value="ROSTER"
                                                                    {{ $roster_type == 'ROSTER' ? 'selected' : '' }}>
                                                                    Roster
                                                                </option>

                                                            </select>
                                                        </div>


                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="user_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">User Type
                                                            (Telemedicine)</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="user_type" name="user_type">
                                                                <option value="0" selected="selected">Select User
                                                                    Type
                                                                </option>
                                                                {{-- <option value="doc" data-doc="{{ $user_type }}"
                                                                    @if ($user_type == 'doc') selected @endif> Doctor
                                                                </option> --}}

                                                                <option value="doc" data-doc="{{ $user_type }}"
                                                                    @if ($user_type == 'doc') selected @endif>
                                                                    Doctor</option>
                                                                <option value="pat" data-doc="{{ $user_type }}"
                                                                    @if ($user_type == 'pat') selected @endif>
                                                                    Patient</option>
                                                                <option value="dmn" data-doc="{{ $user_type }}"
                                                                    @if ($user_type == 'dmn') selected @endif>
                                                                    Delivery Man</option>
                                                            </select>
                                                        </div>
                                                        <label for="digital_signature"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Digital
                                                            Signature</label>
                                                        <div class="col-sm-3">
                                                            <input type="file" class="form-control"
                                                                id="digital_signature" name="digital_signature"
                                                                accept=".jpg,.png,.jpeg,.webp">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="leave_category" class="col-sm-3 col-form-label col-form-label-sm">Leave Category</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto" id="leave_category" name="leave_category">
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
                                                        <label for="" class="col-sm-3 col-form-label col-form-label-sm">Signature
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="doctor_signature" name="doctor_signature"
                                                                value="{{ $doctor_signature }}"
                                                                placeholder="Signature" maxlength="30">
                                                        </div>
                                                        <label for="doctor_job_title"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Benefit Type</label>
                                                        <div class="col-sm-3 mt-1">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="benefit_type_no_fk" name="benefit_type_no_fk">
                                                                <option value="">Select Benefit Type</option>
                                                                @if (isset($benifit_tpye))
                                                                    @foreach ($benifit_tpye as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($doctor_benifit_tpye == $key) selected @endif>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="hod1" class="col-form-label">HOD 1</label>
                                                        <div class="form-row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="hod1"
                                                                    id="hod1" placeholder=""
                                                                    value="{{ $emp_hod1_person_no_fk }}">
                                                                <input type="hidden" name="emp_hod1_person_no_fk"
                                                                    id="emp_hod1_person_no_fk" value="{{ $emp_hod1_person_no_fk }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="hod1_name"
                                                                    id="hod1_name" placeholder="" value="{{ $hname1 }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="hod2" class="col-form-label">HOD 2</label>
                                                        <div class="form-row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="hod2"
                                                                    id="hod2" placeholder=""
                                                                    value="{{ $emp_hod2_person_no_fk }}">
                                                                <input type="hidden" name="emp_hod2_person_no_fk"
                                                                    id="emp_hod2_person_no_fk" value="{{ $emp_hod2_person_no_fk }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="hod2_name"
                                                                    id="hod2_name" value="{{ $hname2 }}" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="supv1" class="col-form-label">Supv 1</label>
                                                        <div class="form-row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="supv1"
                                                                    id="supv1" placeholder=""
                                                                    value="{{ $emp_supvisor1_person_no_fk }}">
                                                                <input type="hidden" name="emp_supvisor1_person_no_fk"
                                                                    id="emp_supvisor1_person_no_fk" value="{{ $emp_supvisor1_person_no_fk }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="supv1_name"
                                                                    id="supv1_name" value="{{ $supname1 }}" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row d-none" id="status_data">
                                                        <label for="inactivate_resson"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Inactive
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input type="text"
                                                                class="form-control form-control-sm date_picker"
                                                                id="inactivate_date" name="inactivate_date"
                                                                value="{{ $inactivate_date != '' ? date('d-m-Y', strtotime($inactivate_date)) : '' }}"
                                                                placeholder="DD/MM/YYYY">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="inactivate_resson" name="inactivate_resson"
                                                                value="{{ $inactivate_resson }}"
                                                                placeholder="Inactive Reason" maxlength="50">
                                                        </div>
                                                        <div class="col-sm-3">
                                                                <select class="form-control form-control-sm"
                                                                id="emp_status" name="emp_status">
                                                                    <option value="">Select Employee Status</option>
                                                                    <option value="4" @if($emp_status == 4) selected @endif>Resigned</option>
                                                                    <option value="5" @if($emp_status == 5) selected @endif>Dismissed</option>
                                                                </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="accommodation"
                                                            id="accommodation" value="1"
                                                            {{ $accomodation_ind == 1 ? 'checked' : '' }}>
                                                        <label for="accommodation" class="pl-1 ml-0">Accommodation
                                                        </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" name="transport_ind" value="1"
                                                            id="transport_ind"
                                                            {{ $transport_ind == 1 ? 'checked' : '' }}>
                                                        <label for="transport_ind" class=" ml-0 pl-1">Transport
                                                        </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" name="provident_fund_type"
                                                            value="1" id="provident_fund_type"
                                                            {{ $provident_fund_type == 1 ? 'checked' : '' }}>
                                                        <label for="provident_fund_type" class=" ml-0 pl-1">Provident
                                                            fund
                                                        </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" name="ot_payable_ind" value="1"
                                                            id="ot_payable_ind"
                                                            {{ $ot_payable_ind == 1 ? 'checked' : '' }}>
                                                        <label for="ot_payable_ind" class=" ml-0 pl-1">OT Payable
                                                        </label>
                                                    </div>

                                                    <div class="form-group" id="status_data_ind">
                                                        <input type="checkbox" name="status_ind" value="1"
                                                            id="status_ind" {{ $status == 0 ? 'checked' : '' }}>
                                                        <label for="status_ind" class=" ml-0 pl-1">Inactive
                                                        </label>
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
            </div>

            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#salary_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>6. Salary Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="salary_info" class="collapse show p-1 " aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class=" form-group row pl-2 pr-2">
                                    <div class="form-group form-row p-2" id="emp_salary_ind">
                                        <div class="col-md-12">
                                            <input type="checkbox" name="salary_ind" value="1" id="salary_ind"
                                                {{ $salary_ind == 1 ? 'checked' : '' }}>
                                            <label for="salary_ind" class=" ml-0 pl-1">Salary Process
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none" id="open_salary_view">
                                        <input type="hidden" value="{{ $salary_no_pk }}" name="salary_no_pk">
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="attendence_bonus"
                                                    class=" col-form-label col-form-label-sm">Salary Factor
                                                </label>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="input-group flex-nowrap">

                                                            <select class="form-control form-control-sm"
                                                                name="salary_factor" id="salary_factor">
                                                                <option value="">select Salary Factor</option>


                                                                @if (!empty($salary_factor))
                                                                    @foreach ($salary_factor as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ $salary_factor_data == $key ? 'selected' : '' }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-2 d-none" id="grade">
                                                <label for="attendence_bonus"
                                                    class=" col-form-label col-form-label-sm ">Grade Factor
                                                </label>

                                                <div class="form-row">

                                                    <div class="input-group flex-nowrap">

                                                        <select class="form-control form-control-sm"
                                                            name="grade_factor" id="grade_factor">
                                                            <option value="">select Grade</option>
                                                            @if (isset($grade))
                                                                <?php foreach ($grade as $value) : ?>

                                                                <option value="{{ $value->grade_no_pk }}"
                                                                    {{ $grade_no_fk == $value->grade_no_pk ? 'selected' : '' }}>
                                                                    {{ $value->grade_name }}</option>

                                                                <?php endforeach ?>
                                                            @endif
                                                        </select>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-sm-2 hdn_salary" id="grade">
                                                <label for="bonus_eligibility"
                                                    class=" col-form-label col-form-label-sm ">Bonus Eligibility
                                                </label>
                                                <div class="form-row">

                                                    <div class="input-group flex-nowrap">
                                                        <input type="checkbox" name="bonus_eligibility"
                                                            value="1" id="bonus_eligibility"
                                                            {{ $bonus_eligibility == 1 ? 'checked' : '' }}> &nbsp
                                                        <label for="bonus_eligibility"
                                                            class=" col-form-label col-form-label-sm "> Check
                                                        </label>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 " id="">
                                                <label for="income_tex_ind"
                                                    class=" col-form-label col-form-label-sm ">Income Tax Eligibility
                                                </label>
                                                <div class="form-row">

                                                    <div class="input-group flex-nowrap">
                                                        <input type="checkbox" name="income_tex_ind" value="1"
                                                            id="income_tex_ind"
                                                            {{ $income_tex_ind == 1 ? 'checked' : '' }}> &nbsp
                                                        <label for="income_tex_ind"
                                                            class=" col-form-label col-form-label-sm "> Check
                                                        </label>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 d-none" id="income_tex">
                                                <label for="income_tex"
                                                    class=" col-form-label col-form-label-sm ">Income Tax Amt.
                                                </label>
                                                <div class="form-row">

                                                    <div class="input-group flex-nowrap">
                                                        <input type="text"
                                                            class=" form-control form-control-sm sum number_only number_only"
                                                            name="income_tex" value="{{ $income_tex }}"
                                                            id="income_tex_amt">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3 d-none " id="daily_wages">
                                                <label for="attendence_bonus"
                                                    class=" col-form-label col-form-label-sm "> Daily Wages
                                                </label>

                                                <div class="form-row">

                                                    <div class="input-group flex-nowrap">
                                                        <input type="text"
                                                            class="form-control form-control-sm sum number_only "
                                                            id="daily_wages" name="daily_wages"
                                                            value="{{ $daily_wages }}" placeholder="0.00"
                                                            maxlength="10">

                                                    </div>


                                                </div>
                                            </div>

                                        </div>


                                        <div id="salary_info_amt" class="hdn_salary">
                                            @include('admin.hrm.employee.salary_info')
                                        </div>


                                        <div class="form-row hdn_salary">

                                            <div class="col-sm-3">
                                                <label for=""
                                                    class=" col-form-label col-form-label-sm">Security
                                                    Money</label>
                                                <div class="form-row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group flex-nowrap">

                                                            <input type="text"
                                                                class="form-control form-control-sm sum number_only "
                                                                id="security_money" name="security_money"
                                                                value="{{ $security_money_amount }}"
                                                                placeholder="0.00" maxlength="10">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class=" col-form-label col-form-label-sm">
                                                    Receive
                                                    Date</label>
                                                <div class="form-row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group flex-nowrap">


                                                            <input type="text"
                                                                class="form-control form-control-sm sum number_only date_picker"
                                                                id="receive_date" name="receive_date"
                                                                value="{{ $security_money_received_date != '' ? date('d-m-Y', strtotime($security_money_received_date)) : '' }}"
                                                                placeholder="DD/MM/YYYY">

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for=""
                                                    class=" col-form-label col-form-label-sm">Savings Amount
                                                </label>
                                                <div class="form-row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group flex-nowrap">

                                                            <input type="text"
                                                                class="form-control form-control-sm sum number_only "
                                                                id="savings_amount" name="savings_amount"
                                                                value="{{ $savings_amount }}" placeholder="0.00"
                                                                maxlength="10">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class=" col-form-label col-form-label-sm">
                                                    Residence fee
                                                </label>
                                                <div class="form-row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group flex-nowrap">

                                                            <input type="text"
                                                                class="form-control form-control-sm sum number_only "
                                                                id="residenceal_fee" name="residenceal_fee"
                                                                value="{{ $residenceal_fee }}" placeholder="0.00"
                                                                maxlength="10">
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
                </div>
            </div>

            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#doctor_fee" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 7. Consultation Fee Setup </strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="doctor_fee" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group mt-1">
                                            @if (isset($visit_type))
                                                @php $i = 0; @endphp
                                                @foreach ($visit_type as $key => $val)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="email">{{ $val }}</label>
                                                            <input type="hidden" name="visit_type_pk_no[]"
                                                                value="{{ $key }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if (isset($fee_arr[$key]['item_id']))
                                                                <input type="text" name="item_name[]"
                                                                    class="form-control item_name"
                                                                    value="{{ $fee_arr[$key]['item_name'] }}">
                                                                <input type="hidden" name="item_id[]"
                                                                    value="{{ $fee_arr[$key]['item_id'] }}" />
                                                                <input type="hidden" name="hdn_doctorfee_id[]"
                                                                    value="{{ $fee_arr[$key]['doc_fee_id'] }}" />
                                                            @else
                                                                <input type="text" name="item_name[]"
                                                                    class="form-control item_name" value=""
                                                                    autocomplete="off">
                                                                <input type="hidden" name="item_id[]" />
                                                            @endif

                                                        </div>
                                                    </div>
                                                    @php $i++; @endphp
                                                @endforeach
                                            @endif
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
                                    data-toggle="collapse" data-target="#hospital_chamber_shedule"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <strong> 8. Hospital Chamber Shedule</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="hospital_chamber_shedule" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-row">
                                                <strong>Week Days </strong>
                                                <div class="col-sm-12">
                                                    <input type="checkbox" name="saturday" value="1"
                                                        id="saturday" {{ $saturday == 1 ? 'checked' : '' }}> <label
                                                        for="saturday" class=" ml-0 pl-1">Saturday
                                                    </label> &nbsp; &nbsp;
                                                    <input type="checkbox" name="sunday" value="2"
                                                        id="sunday" {{ $sunday == 2 ? 'checked' : '' }}> <label
                                                        for="sunday" class=" ml-0 pl-1">Sunday
                                                    </label>&nbsp; &nbsp;
                                                    <input type="checkbox" name="monday" value="3"
                                                        id="monday" {{ $monday == 3 ? 'checked' : '' }}> <label
                                                        for="monday" class=" ml-0 pl-1">Monday
                                                    </label>&nbsp; &nbsp;
                                                    <input type="checkbox" name="tuesday" value="4"
                                                        id="tuesday" {{ $tuesday == 4 ? 'checked' : '' }}> <label
                                                        for="tuesday" class=" ml-0 pl-1">Tuesday
                                                    </label>&nbsp; &nbsp;
                                                    <input type="checkbox" name="wednesday" value="5"
                                                        id="wednesday" {{ $wednesday == 5 ? 'checked' : '' }}>
                                                    <label for="wednesday" class=" ml-0 pl-1">Wednesday
                                                    </label>&nbsp; &nbsp;
                                                    <input type="checkbox" name="thursday" value="6"
                                                        id="thursday" {{ $thursday == 6 ? 'checked' : '' }}> <label
                                                        for="thursday" class=" ml-0 pl-1">Thursday
                                                    </label>&nbsp; &nbsp;
                                                    <input type="checkbox" name="friday" value="7"
                                                        id="friday" {{ $friday == 7 ? 'checked' : '' }}> <label
                                                        for="friday" class=" ml-0 pl-1">Friday
                                                    </label>
                                                </div>

                                                <div class="col-sm-7">
                                                    <div><strong>Shedule Time </strong></div>
                                                    <textarea class="form-control form-control-sm" id="time_text" name="time_text" placeholder="write">{{ $time_text }} </textarea>
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
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#approval-info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>8. Approval Layer </strong>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="approval-info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body pt-2">

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_hod_ind" value="1"
                                                id="inv_hod_ind" {{ $inv_hod_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_hod_ind" class=" ml-0 pl-1"><strong>HOD</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_auth_admin_ind" value="1"
                                                id="inv_auth_admin_ind"
                                                {{ $inv_auth_admin_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_auth_admin_ind" class=" ml-0 pl-1"><strong>Admin
                                                </strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_auth_director_ind" value="1"
                                                id="inv_auth_director_ind"
                                                {{ $inv_auth_director_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_auth_director_ind"
                                                class=" ml-0 pl-1"><strong>Director</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_auth_chairman_ind" value="1"
                                                id="inv_auth_chairman_ind"
                                                {{ $inv_auth_chairman_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_auth_chairman_ind"
                                                class=" ml-0 pl-1"><strong>Chairman</strong></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_store_ind" value="1"
                                                id="inv_store_ind" {{ $inv_store_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_store_ind"
                                                class=" ml-0 pl-1"><strong>Store</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_proc_ind" value="1"
                                                id="inv_proc_ind" {{ $inv_proc_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_proc_ind"
                                                class=" ml-0 pl-1"><strong>Procurement</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_gen_man_proc_ind" value="1"
                                                id="inv_gen_man_proc_ind"
                                                {{ $inv_gen_man_proc_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_gen_man_proc_ind" class=" ml-0 pl-1"><strong>GM,
                                                    Procurement </strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_manager_acc_ind" value="1"
                                                id="inv_manager_acc_ind"
                                                {{ $inv_manager_acc_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_manager_acc_ind" class=" ml-0 pl-1"><strong>Manager
                                                    Accounts</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_director_acc_ind" value="1"
                                                id="inv_director_acc_ind"
                                                {{ $inv_director_acc_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_director_acc_ind" class=" ml-0 pl-1"><strong>Director
                                                    Accounts</strong></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="inv_director_admin_ind" value="1"
                                                id="inv_director_admin_ind"
                                                {{ $inv_director_admin_ind == 1 ? 'checked' : '' }}>
                                            <label for="inv_director_admin_ind" class=" ml-0 pl-1"><strong>Director
                                                    Admin</strong></label>
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
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#bank_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>9. Bank Information</strong>

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
            </div>
            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left global-uhl-table-bg accordion_title"
                                    data-toggle="collapse" data-target="#login_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 10. Login Information </strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="login_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-2 col-form-label col-form-label-sm">User Name
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm  "
                                                        id="user_name" name="user_name"
                                                        value="{{ $user_name }}" placeholder="User Name"
                                                        maxlength="50">
                                                </div>
                                                <label for="post_code"
                                                    class="col-sm-1 pl-1 col-form-label col-form-label-sm">
                                                    Password</label>
                                                <div class="col-sm-2">
                                                    <input type="password" class="form-control form-control-sm "
                                                        id="password" name="password" value=""
                                                        placeholder="Password" minlength="6">


                                                </div>
                                                <label for=""
                                                    class="col-sm-2 col-form-label col-form-label-sm">Confirm
                                                    Password</label>
                                                <div class="col-sm-2">
                                                    <input type="password" class="form-control form-control-sm "
                                                        id="password2" name="password2" value=""
                                                        placeholder="Confirm Password" minlength="6">
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
            @if ($doctor_no_pk != null)
                <div class="col-md-12">
                    <div class="employee_registration">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                        data-toggle="collapse" data-target="#mobile_apps" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <strong> 11. Mobile Apps User </strong>

                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>

                                <div id="mobile_apps" class="collapse show p-1" aria-labelledby="headingOne"
                                    data-parent="#accordion">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body pt-2">
                                                <div class="form-group row">
                                                    <label for="apps_user"
                                                        class="col-sm-2 col-form-label col-form-label-sm">Apps User
                                                        &nbsp; <input type="checkbox" class=""
                                                            id="apps_user" name="apps_user" value="1"
                                                            @if ($apps_user == 1) checked @endif> </label>


                                                    <label for="user_code"
                                                        class="col-sm-2 pl-1 col-form-label col-form-label-sm">
                                                        User Code</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                            readonly="readonly" id="user_code" name="user_code"
                                                            value="{{ $doctor_code }}" placeholder="User Code">
                                                    </div>

                                                    <label for="passcode"
                                                        class="col-sm-2 col-form-label col-form-label-sm">Passcode</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm "
                                                            id="passcode" name="passcode"
                                                            value="{{ $passcode }}" placeholder="Passcode">
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="self_referrence"
                                                        class="col-sm-2 col-form-label col-form-label-sm">Self
                                                        Referrence
                                                        &nbsp; <input type="checkbox" class=""
                                                            id="self_referrence" name="self_referrence"
                                                            value=""
                                                            @if ($ref_agent_person_no_fk != '') checked @endif> </label>


                                                    <label for="referrence_name"
                                                        class="col-sm-2 pl-1 col-form-label col-form-label-sm">
                                                        Referrence Name</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm"
                                                            readonly="readonly" id="referrence_name"
                                                            name="referrence_name"
                                                            value="{{ $ref_agent_person_no_fk != '' && $ref_agent_person_no_fk == $doctor_no_pk ? $doctor_first_name : '' }}"
                                                            placeholder="Referrence Name">
                                                        <input type="hidden" name="hdn_referrence_name"
                                                            id="hdn_referrence_name"
                                                            value="{{ $ref_agent_person_no_fk }}">
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
            @endif

            <div class="col-md-12">
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

                                        <input type="checkbox" name="internal_doc_ind" value="1" id="internal_doc_ind"
                                            {{ $internal_doctor_ind == 1 ? 'checked' : '' }}>
                                        <label for="internal_doc_ind" class=" ml-0 pl-1">Internal Doctor
                                        </label>

                                        <input type="checkbox" name="external_doc_ind" value="1" id="external_doc_ind"
                                            style="margin-left: 10px;" {{ $external_doctor_ind == 1 ? 'checked' : '' }}>
                                        <label for="external_doc_ind" class=" ml-0 pl-1">External Doctor
                                        </label>

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
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).on('click', '#self_referrence', function() {
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

    });

    openDoctorAutocomplete('#hod1', 'emp_id', "employee_ind", 1, personInfo1);
    openDoctorAutocomplete('#hod2', 'emp_id', "employee_ind", 1, personInfo2);
    openDoctorAutocomplete('#supv1', 'emp_id', "employee_ind", 1, personInfo3);

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

        // if ($('#doctor_job_type').val() == 41) {
        //     $('.specialization').removeClass('d-none');
        // } else {
        //     $('.specialization').addClass('d-none');
        // }

        // $(document).on('change', '#doctor_job_type', function() {

        //     var jobType = $('#doctor_job_type').val();
        //     if (jobType == 41) {

        //         $('.specialization').removeClass('d-none');
        //     } else {
        //         $('.specialization').addClass('d-none');
        //     }
        // });

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
        alert(newId);
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');


        $('.degree_name_0').val('0').select2({
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
        row.find('#degree_name_' + oldId).attr('id', 'degree_name_' + newId).val($(thisElement).parents('tbody').find(
            '#degree_name_' + oldId).val());
        $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('Select');
        $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('');
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
                                dynamicFunc.afterSaveLoadList(
                                    "{{ route('doctor.loadList') }}");
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

    $(document).ready(function() {
        if($('#status_ind').is(':checked')) {
            $('#status_data').removeClass('d-none');
        } else {
            $('#status_data').addClass('d-none');
        }
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
            }
            else if (id == "other_allow_perc") {
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
            }
            else if (id == "other_allowance") {
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
