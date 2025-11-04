@php
    $hospital_code = Session::get('user.ses_hospital_code');
    $doctor = isset($data) && !empty($data) ? $data : [];
    $out_uid = isset($out_uid) && $hospital_code != 'IMPERIAL' ? $out_uid : '';
    $doctor_code = $doctor ? $doctor->person_code : $out_uid;
    $doctor_no_pk = $doctor ? $doctor->person_no_pk : '';
    $ref_agent_person_no_fk = $doctor ? $doctor->ref_agent_person_no_fk : '';
    $apps_user = $doctor ? $doctor->apps_user_ind : '';
    $passcode = $doctor ? $doctor->agent_access_code : '';
    $doctor_salutation = $doctor ? $doctor->salutation : '';
    $doctor_first_name = $doctor ? $doctor->fname : '';
    $doctor_last_name = $doctor ? $doctor->lname : '';
    $doctor_age = $doctor ? $doctor->age : '';
    $doctor_date_of_birth = $doctor ? $doctor->dob : '';
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
    $doctor_emp_type = $doctor ? $doctor->emp_type_lookup_no_fk : '';
    $doctor_job_title = $doctor ? $doctor->jobtitle_lookup_no_fk : '';
    $grade_no_fk = $doctor ? $doctor->grade_no_fk : '';
    $roster_type = $doctor ? $doctor->duty_roster_type : '';
    $inactivate_resson = $doctor ? $doctor->inactivate_resson : '';
    $inactivate_date = $doctor ? $doctor->inactivate_date : '';
    $bank_name = $doctor ? $doctor->bank_name : '';
    $bank_acc_no = $doctor ? $doctor->bank_acc_no : '';
    $bank_acc_name = $doctor ? $doctor->bank_acc_name : '';
    $agent_banking_type = $doctor ? $doctor->agent_banking_type : '';
    $agent_banking_no = $doctor ? $doctor->agent_banking_no : '';
    $security_money_amount = $doctor ? $doctor->security_money_amount : '';
    $security_money_received_date = $doctor ? date('d/M/Y', strtotime($doctor->security_money_received_date)) : '';
    $photo_name = $doctor ? $doctor->photo_name : '';
    $department = $doctor ? $doctor->serviceunit_no_fk : '';
    $doctor_join_date = $doctor ? date('d-m-Y', strtotime($doctor->join_date)) : '';
    $registration_no = isset($doctor->registration_no) ? $doctor->registration_no : null;
    $doctor_lic_no = isset($doctor->doctor_lic_no) ? $doctor->doctor_lic_no : null;
    $doctor_lic_issue_date = $doctor && $doctor->license_issue_date ? date('d-m-Y', strtotime($doctor->license_issue_date)) : '';
    $doctor_card_number = $doctor ? $doctor->card_no : '';
    $present_address = $doctor ? $doctor->pr_addr1 : '';
    $permanent_address = $doctor ? $doctor->pe_addr1 : '';
    $emergency_contact_address = $doctor ? $doctor->emergency_contact_addr : '';
    $doctor_nationality = $doctor ? $doctor->nationality : '';
    $doctor_passport_no = $doctor ? $doctor->passport_no : '';
    $passport_issue_date = $doctor ? date('d-m-Y', strtotime($doctor->passport_issue_date)) : '';
    $passport_expire_date = $doctor ? date('d-m-Y', strtotime($doctor->passport_expire_date)) : '';
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
    $doctor_specialization = $doctor ? $doctor->specialization_lookup_no_fk : '';
    $doctor_signature = $doctor ? $doctor->doctor_signature : '';
    $serviceunit_no_pk = $doctor ? $doctor->serviceunit_no_fk : '';
    $full_name_bangla = $doctor ? $doctor->full_name_bangla : '';
    $referral_agent_ind = $doctor ? $doctor->referral_agent_ind : '';
    $accomodation_ind = $doctor ? $doctor->accomodation_ind : '';
    $transport_ind = $doctor ? $doctor->transport_ind : '';
    $provident_fund_type = $doctor ? $doctor->provident_fund_type : '';
    $ot_payable_ind = $doctor ? $doctor->ot_payable_ind : '';
    $hospital_name = $doctor ? $doctor->hospital_name : '';
    $hospital_address = $doctor ? $doctor->hospital_address : '';
    $chamber_schedule_time = $doctor ? $doctor->chamber_schedule_time : '';
    $chamber_schedule_days = $doctor ? $doctor->chamber_schedule_days : '';
    $contact_number = $doctor ? $doctor->contact_number : '';
    $user_into = isset($user_into) && !empty($user_into) ? $user_into : [];
    $user_name = $user_into ? $user_into->user_name : '';
    $user_type = $user_into ? $user_into->user_type : '';
    $educationInfo = isset($educationInfo) && !empty($educationInfo) ? $educationInfo : [];
    $doctor_degree1 = $doctor ? $doctor->degree1 : '';
    $doctor_degree2 = $doctor ? $doctor->degree2 : '';
    $doctor_degree3 = $doctor ? $doctor->degree3 : '';
    $doctor_degree4 = $doctor ? $doctor->degree4 : '';

    $emp_serial_in_salary_sheet = $doctor ? $doctor->emp_serial_in_salary_sheet : 0;

    $saturday = $doctor ? $doctor->doc_chamber_day_sat : '';
    $sunday = $doctor ? $doctor->doc_chamber_day_sun : '';
    $monday = $doctor ? $doctor->doc_chamber_day_mon : '';
    $tuesday = $doctor ? $doctor->doc_chamber_day_tue : '';
    $wednesday = $doctor ? $doctor->doc_chamber_day_wed : '';
    $thursday = $doctor ? $doctor->doc_chamber_day_thu : '';
    $friday = $doctor ? $doctor->doc_chamber_day_fri : '';
    $time_text = $doctor ? $doctor->doc_chamber_time_txt : '';
    $doctor_remarks = $doctor ? $doctor->remarks_text : '';
    $inactive = $doctor ? $doctor->status : '';
    $referral_ind = $doctor ? $doctor->referal_ind : '';
    $employee_ind = $doctor ? $doctor->employee_ind : '';
    $agent_code = $doctor ? $doctor->agent_code : '';
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
    $payable_ind = $doctor ? $doctor->referral_payable_ind : '';
    $digital_signature_ind = $doctor ? $doctor->digital_signature_ind : '';
    $anesthesiologist = $doctor ? $doctor->anaestesiologis_ind : '';
    $surgeon = $doctor ? $doctor->surgeon_ind : '';
    $doctor_ind = $doctor ? $doctor->doctor_ind : '';
    $internal_doctor_ind = $doctor ? $doctor->internal_doctor_ind : '';
    $external_doctor_ind = $doctor ? $doctor->external_doctor_ind : '';
    $ffs_doctor_ind = $doctor ? $doctor->ffs_doctor_ind : '';
    
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<form method="post" id="doctor_form" action="{{ route('doctor.store') }}">
    @csrf
    <input type="hidden" name="page_name" value="doctor_create_or_edit" />

    <input type="hidden" name="id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="" id="employee_id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="employee" value="DOC">

    <div class="form-row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#basic_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>1. Basic Information</strong> (Introduce a Employee )

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="basic_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="doctor_name"
                                                    class="col-sm-3 col-form-label col-form-label-sm">UID
                                                </label>

                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-capitalize  "
                                                            id="uid" name="uid" value="{{ $doctor_code }}"
                                                            placeholder="">
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
                                                    class="col-sm-3 col-form-label col-form-label-sm">Religion </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control font_size_12 m-auto "
                                                        id="doctor_religion" name="doctor_religion">
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
                                                        class="form-control form-control-sm number_only"
                                                        id="doctor_mobile_no" name="doctor_mobile_no"
                                                        value="{{ $phone_mobile }}" placeholder="Mobile No" required
                                                        maxlength="15">
                                                </div>

                                                <label for="doctor_date_of_birth"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Date of Birth
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="doctor_date_of_birth" name="doctor_date_of_birth"
                                                        value="{{ $doctor_date_of_birth != '' ? date('d/m/Y', strtotime($doctor_date_of_birth)) : '' }}"
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

                                                <label for="doctor_nationality"
                                                    class="col-sm-3 col-form-label col-form-label-sm">Email </label>
                                                <div class="col-sm-3">
                                                    <input type="email" class="form-control form-control-sm "
                                                        id="doctor_email" name="doctor_email"
                                                        value="{{ $email_personal }}"
                                                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*"
                                                        placeholder="abc@gmail.com" maxlength="50">
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
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#office_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>2. Office Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="office_info" class="collapse show  p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-row align-items-center">
                                                <div class="col-md-9">


                                                    <div class="form-group row  specialization">


                                                        <label for="doctor_specialization"
                                                            class="col-sm-3 col-form-label col-form-label-sm ">Specialization</label>
                                                        <div class="col-sm-3  ">
                                                            <select class="form-control font_size_12 m-auto select2"
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
                                                        <label for="doctor_ser_unit"
                                                            class="col-sm-3 col-form-label col-form-label-sm ">Department

                                                            <span class="text-danger">*</span></label>
                                                        <div class="col-sm-3">
                                                            <select
                                                                class="form-control font_size_12 m-auto  select2 required"
                                                                id="doctor_ser_unit" name="doctor_ser_unit" required>
                                                                <option value="">Select Department</option>
                                                                @if (!empty($service_unit))
                                                                    @foreach ($service_unit as $service)
                                                                        <option
                                                                            value="{{ $service->serviceunit_no_pk }}"
                                                                            @if ($service->serviceunit_no_pk == $serviceunit_no_pk) selected @endif>
                                                                            {{ strtoupper($service->serviceunit_name) }}
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
                                                            <select class="form-control font_size_12 m-auto required"
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
                                                                value="{{ isset($doctor_lic_no) ? $doctor_lic_no : $registration_no}}"
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
                                                        <label for="user_type"
                                                            class="col-sm-3 col-form-label col-form-label-sm">User Type
                                                            (Telemedicine)</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control font_size_12 m-auto"
                                                                id="user_type" name="user_type">
                                                                <option value="0" selected="selected">Select User
                                                                    Type
                                                                </option>
                                                                <option value="doc" data-doc="{{ $user_type }}"
                                                                    @if ($user_type == 'doc') selected @endif>
                                                                    Doctor
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
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
                                                        <label for=""
                                                            class="col-sm-3 col-form-label col-form-label-sm">Signature
                                                        </label>
                                                        <div class="card-body py-0 mt-2 col-sm-9" id="">
                                                            <textarea id="result_entry_editor" name="doctor_signature">
                                                            {{ $doctor_signature }}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for=""
                                                            class="col-sm-3 col-form-label col-form-label-sm">Doctor
                                                            Remarks
                                                        </label>
                                                        <div class="card-body py-0 mt-2 col-sm-9" id="">
                                                            <textarea id="doctor_remarks" name="doctor_remarks">
                                                                {{ $doctor_remarks }}
                                                            </textarea>
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
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#bank_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong>3. Bank Information</strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="bank_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body pt-2">
                                    <input type="hidden" value="{{ $salary_no_pk }}" name="salary_no_pk">
                                    <div class="form-group row">


                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_name">Bank
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" class=" form-control form-control-sm"
                                                id="bank_name" name="bank_name" value="{{ $bank_name }}"
                                                placeholder="Bank Name" maxlength="50">
                                        </div>
                                        <label for="bank_name" class="col-md-3 col-form-label col-form-label-sm "
                                            id="bank_name">Acc.
                                            Name</label>
                                        <div class="col-sm-3 ">
                                            <input type="text" class="form-control form-control-sm"
                                                id="bank_acc_name" name="bank_acc_name" value="{{ $bank_acc_name }}"
                                                placeholder="Account Name" maxlength="50">
                                        </div>

                                        <label for="bank_acc_no" class="col-md-3 col-form-label col-form-label-sm"
                                            id="bank_acc_no">
                                            Acc. No</label>
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
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#chamber_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 4. Chamber Information </strong>

                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>

                            <div id="chamber_info" class="collapse show p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-6 col-form-label col-form-label-sm">Hospital/Institute
                                                    Name </label>
                                                <div class="col-sm-6">

                                                    <select name="hos_name" class="select2 form-control"
                                                        id="">
                                                        <option value="">Select One</option>
                                                        @if (!$chamberList->isEmpty())
                                                            @foreach ($chamberList as $chamberHos)
                                                                <option
                                                                    value="{{ $chamberHos->chamber_hospital_no_pk }}"
                                                                    {{ $hospital_name == $chamberHos->chamber_hospital_no_pk ? 'selected' : '' }}>
                                                                    {{ $chamberHos->chamber_hospital_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                </div>


                                            </div>

                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-6 col-form-label col-form-label-sm">Address </label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm  "
                                                        id="consultent_addr" name="consultent_addr"
                                                        value="{{ $hospital_address }}" placeholder="Address"
                                                        maxlength="50">
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-6 col-form-label col-form-label-sm">Contact</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm  "
                                                        id="con_contact" name="con_contact"
                                                        value="{{ $contact_number }}" placeholder="Contact"
                                                        maxlength="50">
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card-body pt-2">

                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-4 col-form-label col-form-label-sm ">Chamber Days
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm  "
                                                        id="chamber_days" name="chamber_days"
                                                        value="{{ $chamber_schedule_days }}"
                                                        placeholder="Sat, Sun, Mon" maxlength="">
                                                </div>


                                            </div>

                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-4 col-form-label col-form-label-sm">Chamber Time
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm "
                                                        id="chamber_time" name="chamber_time"
                                                        value="{{ $chamber_schedule_time }}"
                                                        placeholder="Chamber Time" maxlength="50">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="user_name"
                                                    class="col-sm-4 col-form-label col-form-label-sm">Agent
                                                    Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm  "
                                                        id="agent_code" name="agent_code"
                                                        value="{{ $agent_code }}" placeholder="Agent Code"
                                                        maxlength="50">
                                                    <input type="hidden" name="agent_hidn" id="agent_hidn">
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
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#doctor_fee" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 5. Consultation Fee Setup </strong>

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
                                                                <!-- {{ $i == 0 ? 'required' : ' ' }} -->
                                                                <input type="hidden" name="item_id[]"
                                                                    value="{{ $fee_arr[$key]['item_id'] }}" />
                                                                <input type="hidden" name="hdn_doctorfee_id[]"
                                                                    value="{{ $fee_arr[$key]['doc_fee_id'] }}" />
                                                            @else
                                                                <input type="text" name="item_name[]"
                                                                    class="form-control item_name" value=""
                                                                    autocomplete="off">
                                                                <!-- {{ $i == 0 ? 'required' : ' ' }} -->
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

            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#hospital_chamber_shedule"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <strong> 6. Hospital Chamber Schedule </strong>

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
                                                        id="wednesday" {{ $wednesday == 5 ? 'checked' : '' }}> <label
                                                        for="wednesday" class=" ml-0 pl-1">Wednesday
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

                                                <div class="col-sm-6">
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
            </div>
            <div class="col-md-12">
                <div class="employee_registration">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                    data-toggle="collapse" data-target="#login_info" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <strong> 7. Login Information </strong>

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
                                                        id="user_name" name="user_name" value="{{ $user_name }}"
                                                        placeholder="User Name" maxlength="50">
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
                                                        &nbsp; <input type="checkbox" class="" id="apps_user"
                                                            name="apps_user" value="1"
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
                                                            {{-- readonly="readonly"  --}}
                                                            id="referrence_name"
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

                <div class="card">
                    <div class="card-body p-2">

                        <div class="form-group" id="status_data_ind">
                            <input type="checkbox" name="referral_ind" value="1" id="referral_ind"
                                {{ $referral_ind == 1 ? 'checked' : '' }}>
                            <label for="referral_ind" class=" ml-0 pl-1">Referral
                            </label> &nbsp;&nbsp;
                            <input type="checkbox" name="employee_ind" value="1" id="employee_ind"
                                {{ $employee_ind == 1 ? 'checked' : '' }}>
                            <label for="employee_ind" class=" ml-0 pl-1">Employee
                            </label>

                            &nbsp; &nbsp;
                            <input type="checkbox" name="payable_ind" value="1" id="payable_ind"
                                {{ $payable_ind == 1 ? 'checked' : '' }}>
                            <label for="payable_ind" class=" ml-0 pl-1">Payable
                            </label>
                            &nbsp; &nbsp;
                            <input type="checkbox" name="anesthesiologist" value="1" id="anesthesiologist"
                                {{ $anesthesiologist == 1 ? 'checked' : '' }}>
                            <label for="anesthesiologist" class=" ml-0 pl-1">Anesthesiologist
                            </label>
                            &nbsp; &nbsp;
                            <input type="checkbox" name="surgeon" value="1" id="surgeon"
                                {{ $surgeon == 1 ? 'checked' : '' }}>
                            <label for="surgeon" class=" ml-0 pl-1">Surgeon
                            </label>
                            &nbsp; &nbsp;
                            <input type="checkbox" name="digital_signature_ind" value="1"
                                id="digital_signature_ind" {{ $digital_signature_ind == 1 ? 'checked' : '' }}>
                            <label for="digital_signature_ind" class=" ml-0 pl-1">Digital Signature
                            </label>

                            &nbsp; &nbsp;
                            <input type="checkbox" name="doctor_ind" id="doctor_ind" value="1" checked >
                            <label for="doctor_ind" class="ml-0 pl-1">Doctor Ind</label>

                            <br>
                            @if ($hospital_code !== 'KPJ')
                                <input type="checkbox" name="internal_doc_ind" value="1" id="internal_doc_ind" class="doc-type"
                                    {{ $internal_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="internal_doc_ind" class="ml-0 pl-1">Internal Doctor</label>

                                <input type="checkbox" name="external_doc_ind" value="1" id="external_doc_ind" class="doc-type"
                                    style="margin-left: 10px;" {{ $external_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="external_doc_ind" class="ml-0 pl-1">External Doctor</label>
                                <input type="checkbox" name="ffs_doc_ind" value="1" id="ffs_doc_ind" class="doc-type"
                                    style="margin-left: 10px;" {{ $ffs_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="ffs_doc_ind" class="ml-0 pl-1">FFS Doctor</label>
                            @else
                                <input type="checkbox" name="internal_doc_ind" value="1" id="internal_doc_ind" class="doc-type"
                                    {{ $internal_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="internal_doc_ind" class="ml-0 pl-1">Salaried Doctor</label>

                                <input type="checkbox" name="external_doc_ind" value="1" id="external_doc_ind" class="doc-type"
                                    style="margin-left: 10px;" {{ $external_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="external_doc_ind" class="ml-0 pl-1">Visiting Doctor</label>

                                <input type="checkbox" name="ffs_doc_ind" value="1" id="ffs_doc_ind" class="doc-type"
                                    style="margin-left: 10px;" {{ $ffs_doctor_ind == 1 ? 'checked' : '' }}>
                                <label for="ffs_doc_ind" class="ml-0 pl-1">FFS Doctor</label>
                            @endif

                        </div>

                        {{-- <div class="form-group" id="status_data_ind">
                            <input type="checkbox" name="status_ind" value="1" id="status_ind"
                                {{ $inactive === 0 ? 'checked' : '' }}>
                            <label for="status_ind" class=" ml-0 pl-1">Inactive
                            </label>
                        </div> --}}

                        <div class="form-group row d-none" id="status_data">

                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm date_picker"
                                    id="inactivate_date" name="inactivate_date"
                                    value="{{ $inactivate_date != '' ? date('d/m/Y', strtotime($inactivate_date)) : '' }}"
                                    placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" id="inactivate_resson"
                                    name="inactivate_resson" value="{{ $inactivate_resson }}"
                                    placeholder="Inactive Reason" maxlength="50">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            @php
                $doctor_id = '';
                $response_url = route('doctor-card', $doctor_id);
            @endphp
            <div class="col-md-12">
                <div class="employee_registration">
                    <div class="card">
                        <div class="card-body p-2">
                            <button class="btn btn-md btn-success" id="save_doctor" data-func="afterSaveModal"
                                data-response-url="{{ $response_url }}"
                                title="Click here to save Doctor Information">Save
                            </button>
                            <button type="reset" class="btn btn-md btn-info">Reset</button>
                            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
                                title="Click here to go back to Dashboard">Exit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

   <script>
    // Pre-set values from backend (passed to Blade)
    const doctorCode = "{{ $doctor ? $doctor->person_code : $out_uid }}";
    const doctorCode1 = "{{ $doctor ? $doctor->person_code : $out_uid1 }}";
    const doctorCode2 = "{{ $doctor ? $doctor->person_code : $out_uid2 }}";

    // console.log(doctorCode, doctorCode1, doctorCode2);

    // Get elements
    const doctorIndCheckbox = document.getElementById('doctor_ind');
    const internalDocIndCheckbox = document.getElementById('internal_doc_ind');
    const externalDocIndCheckbox = document.getElementById('external_doc_ind');
    const ffsDoctor = document.getElementById('ffs_doc_ind');
    const uidInput = document.getElementById('uid');
    const empIND = document.getElementById('employee_ind');
    const docTypeCheckboxes = document.querySelectorAll('.doc-type');

    // Function to update UID based on checkbox states
    function updateUID() {
        if (doctorIndCheckbox.checked && internalDocIndCheckbox.checked && !ffsDoctor.checked && !externalDocIndCheckbox.checked) {
            uidInput.value = doctorCode;
        } else if (doctorIndCheckbox.checked && !internalDocIndCheckbox.checked && externalDocIndCheckbox.checked && !ffsDoctor.checked) {
            uidInput.value = doctorCode1;
        } else if (doctorIndCheckbox.checked && !internalDocIndCheckbox.checked && ffsDoctor.checked && !externalDocIndCheckbox.checked) {
            uidInput.value = doctorCode2;
        } else {
            uidInput.value = ''; // or any default value
        }
    }

    // Function to update employee_ind checkbox based on checkbox states
    function updateEMPCCHECK() {
        if (doctorIndCheckbox.checked && internalDocIndCheckbox.checked) {
            empIND.checked = true; // Check the employee checkbox
        } else {
            empIND.checked = false; // Uncheck the employee checkbox
        }
    }

    docTypeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                // Uncheck all others
                docTypeCheckboxes.forEach(cb => {
                    if (cb !== this) cb.checked = false;
                });
            }
        });
    });
    // Attach event listeners to checkboxes to update both UID, employee_ind, and doc types
    doctorIndCheckbox.addEventListener('change', function() {
        updateUID();
        updateEMPCCHECK();
        // updateDocType();
    });

    internalDocIndCheckbox.addEventListener('change', function() {
        updateUID();
        updateEMPCCHECK();
        // updateDocType();
    });

    externalDocIndCheckbox.addEventListener('change', function() {
        updateUID();
        updateEMPCCHECK();
        // updateDocType();
    });

    ffsDoctor.addEventListener('change', function() {
        updateUID();
        updateEMPCCHECK();
        // updateDocType();
    });

    // Initialize on page load
    updateEMPCCHECK();
    updateUID();
    // updateDocType();
</script>







<script type="text/javascript">
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
    loadEditor("result_entry_editor");
    loadEditor("doctor_remarks");
    openReceiveItemAutocomplete1('#item_name', 'item_name', function(item, obj) {


        // alert(item.uom_no_fk);
        console.log(item.uom_no_fk);
        $('#item_id_hidden').val(item.item_id);
        $('#item_uom_hidden').val(item.uom_no_fk);
        $('#item_uom').val(item.uom_name);
        $('#pvms_no').val(item.pvms_no);
        $('#item_id').val(item.item_id);

        $('#item_price').val(item.purchase_price);
        $('#sales_price').val(item.item_rate);
        // $('#item_id').val(item.item_id);
        obj.stopImmediatePropagation();
    });

    function openReceiveItemAutocomplete1(element_id, display = 'item_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('referral.referal-policy-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name +
                        '</strong><div><small>UOM: ' + item.uom_name + '</small>, <small>Pvms No: ' + item
                        .pvms_no + '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }



    openDoctorAutocomplete('#agent_code', 'agent_hidn', 'referral_agent_ind', '2');
    $(document).ready(function() {

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
                $('#Conveyance_allowance').val('');
                $('#Conveyance_allowance_per').val('');
                $('#house_rent').val('');
                $('#house_rent_per').val('');
                $('#utility').val('');
                $('#utility_per').val('');
                $('#entertainment').val('');
                $('#entertainment_per').val('');
                $('#festival_bonus').val('');
                $('#festival_bonus_per').val('');
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
                    $('.select2').select2();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            // alert(disct_value);
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
        row.attr('id', newId);
        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
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

        $(document).on("click", '#save_doctor', function(e) {
            if (confirm("Are you sure?")) {
                var page_type = "{{ $page_type }}";

                $('#doctor_form').unbind().submit(function(e) {
                    e.preventDefault();
                    var formAction = $(this).attr("action");
                    var formMethod = $(this).attr("method");
                    var formData = new FormData(this);
                    var customFunc = $("#save_doctor").attr("data-func");

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
                            var response_url = $("#save_doctor").attr(
                                "data-response-url") + "/" + data.insert_id;
                            dynamicFunc.afterSaveModal(response_url,
                                "common-modal-sm",
                                "Doctor Card");

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
                                    "{{ route('doctor-index') }}");
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
    $(".timepicker").timepicker({
        showInputs: false,
        showMeridian: false,
        setTime: null

    });

    if ($('#status_ind').is(':checked')) {
        $('#status_data').removeClass('d-none');
    } else {
        $('#status_data').addClass('d-none');
    }

    $(document).ready(function() {
        $(document).on('change', '#status_ind', function() {
            if ($(this).is(':checked')) {
                $('#status_data').removeClass('d-none');
            } else {
                $('#status_data').addClass('d-none');
            }
        });
    });
</script>


<script type="text/javascript">
    referalPolicyAutocomplete('#referal_policy', 'referal_policy', function(item, obj) {
        //alert(item.referralpolicy_code);

        $('#referal_policy_hidden').val(item.policy_name);
        $('#referal_policy_hidden').attr("type", "text");
        $('#referal_policy').hide();
        $('#referal_policy').html('');
        $(".tt-hint").hide();
        $(".tt-hint").html('');


        obj.stopImmediatePropagation();
    });






    // referaldisCountAutocomplete('#discount_policy', 'discount_policy', function(item, obj) {

    //     $('#discount_policy_hidden').val(item.discount_name);
    //     $('#discount_policy_hidden').attr('type', 'text');
    //     $('#discount_policy').hide();
    //     $('#discount_policy').html('');
    //     $('.tt-hint').hide();

    //     obj.stopImmediatePropagation();
    // });
openDoctorAutocomplete('#referrence_name', 'hdn_referrence_name');
    
</script>
