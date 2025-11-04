@php
$doctor = isset($data) && !empty($data) ? $data : [];
$doctor_code = $doctor ? $doctor->person_code : '';
$agent_institute_name = $doctor ? $doctor->agent_institute_name : '';
$doctor_ind = $doctor ? $doctor->doctor_ind : '';
$employee_ind = $doctor ? $doctor->employee_ind : '';
$payable_ind = $doctor ? $doctor->referral_payable_ind : '';
$mpo_ind = $doctor ? $doctor->mpo_ind : '';
$doctor_no_pk = $doctor ? $doctor->person_no_pk : '';
$ref_agent_person_no_fk = $doctor ? $doctor->ref_agent_person_no_fk : '';
$apps_user = $doctor ? $doctor->apps_user_ind : '';
$passcode = $doctor ? $doctor->agent_access_code : '';
$doctor_salutation = $doctor ? $doctor->salutation : '';
$doctor_first_name = $doctor ? $doctor->fname : '';
$doctor_last_name = $doctor ? $doctor->lname : '';
$doctor_age = $doctor ? $doctor->age : '';
$doctor_date_of_birth = $doctor ? date('d-m-Y', strtotime($doctor->dob)) : '';
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
$inactivate_date = $doctor ? date('d-m-Y', strtotime($doctor->inactivate_date)) : '';
$reference = $doctor ? $doctor->ref_agent_person_no_fk : '';
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
$doctor_lic_no = $doctor ? $doctor->doc_lic_no : '';
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
$refer_name = $doctor ? $doctor->full_name : '';
$accomodation_ind = $doctor ? $doctor->accomodation_ind : '';
$transport_ind = $doctor ? $doctor->transport_ind : '';
$provident_fund_type = $doctor ? $doctor->provident_fund_type : '';
$ot_payable_ind = $doctor ? $doctor->ot_payable_ind : '';
$status = $doctor ? $doctor->status : '';

$user_into = isset($user_into) && !empty($user_into) ? $user_into : [];
$user_name = $user_into ? $user_into->user_name : '';

$educationInfo = isset($educationInfo) && !empty($educationInfo) ? $educationInfo : [];

$doctor_degree1 = $doctor ? $doctor->degree1 : '';
$doctor_degree2 = $doctor ? $doctor->degree2 : '';
$doctor_degree3 = $doctor ? $doctor->degree3 : '';
$doctor_degree4 = $doctor ? $doctor->degree4 : '';

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
// $reference_name = $doctor ? $doctor->full_name : '';


$ref_name = isset($reference_name) && !empty($reference_name) ? $reference_name : [];
$reference_name = $ref_name ? $ref_name->reference_name : '';
$ref_agent_person_no_fk = $ref_name ? $ref_name->ref_agent_person_no_fk : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<form method="post" id="doctor_form" action="{{ route('doctor.store') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="" id="employee_id" value="{{ $doctor_no_pk }}">
    <input type="hidden" name="employee" value="REFER">

    <div class="form-row">
        <div class="col-md-12">
            <div class="employee_registration">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                data-toggle="collapse" data-target="#basic_info" aria-expanded="true"
                                aria-controls="collapseOne">
                                <strong>1. Basic Information</strong> (Introduce a Referral / Agent )

                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>

                        <div id="basic_info" class="collapse show p-1" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="card-body pt-2">
                                        <div class="form-group row">

                                            <!--   <label for="emp_type"
                                  class="col-sm-3 col-form-label col-form-label-sm">Marketing Type</label>
                                  <div class="col-sm-3">
                                    <select class="form-control font_size_12 m-auto"
                                    id="marketing_type" name="marketing_type">
                                    <option value="" selected="selected">Select Marketing Type
                                    </option>
                                    <option value="1" {{ $referral_agent_ind == 1 ? 'selected' : '' }}>Referal</option>
                                    <option value="2" {{ $referral_agent_ind == 2 ? 'selected' : '' }}>Agent</option>

                                </select>
                            </div> -->
                                            <label for="emp_type"
                                                class="col-sm-3 col-form-label col-form-label-sm">Marketing Type</label>
                                            <div class="col-sm-3">
                                                <input type="radio" name="marketing_type" id="ref"
                                                    value="1" class="marketing_type"
                                                    {{ $referral_agent_ind == 1 ? 'checked' : '' }} /> <label
                                                    for="ref">Referal</label>
                                                <input type="radio" name="marketing_type" id="agent"
                                                    value="2" class="marketing_type"
                                                    {{ $referral_agent_ind == 2 ? 'checked' : '' }} /> <label
                                                    for="agent">Agent</label>
                                            </div>
                                            <label for="doctor_name"
                                                class="col-sm-3 col-form-label col-form-label-sm">UID
                                            </label>

                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm   "
                                                        id="uid" name="uid" value="{{ $doctor_code }}"
                                                        placeholder="" maxlength="30">
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
                                                        required="required" maxlength="50">
                                                    {{-- onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" --}}
                                                    <input type="text"
                                                        class="form-control form-control-sm text-capitalize required"
                                                        id="doctor_last_name" name="doctor_last_name"
                                                        value="{{ $doctor_last_name }}" placeholder="Last Name"
                                                        maxlength="50">
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
                                                        value="{{ $full_name_bangla }}" placeholder="Employee Name"
                                                        maxlength="100">
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
                                                <select class="form-control font_size_12 m-auto " id="doctor_religion"
                                                    name="doctor_religion">
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
                                                Number</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm number_only"
                                                    id="doctor_mobile_no" name="doctor_mobile_no"
                                                    value="{{ $phone_mobile }}" placeholder="Mobile No"
                                                    maxlength="15">
                                            </div>

                                            <label for="doctor_nid" class="col-sm-3 col-form-label col-form-label-sm">
                                                NID</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm number_only"
                                                    id="doctor_nid" name="doctor_nid" value="{{ $doctor_nid }}"
                                                    placeholder=" NID No" maxlength="17">
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                            <label for="doctor_nationality"
                                                class="col-sm-3 col-form-label col-form-label-sm">Email </label>
                                            <div class="col-sm-3">
                                                <input type="email"
                                                    class="form-control form-control-sm text-capitalize"
                                                    id="doctor_email" name="doctor_email"
                                                    value="{{ $email_personal }}" placeholder="Employee Email"
                                                    maxlength="50">
                                            </div>

                                            <label for="doctor_name"
                                                class="col-sm-3 col-form-label col-form-label-sm">Reference
                                            </label>

                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm   "
                                                        id="reference" name="reference"
                                                        value="{{ $ref_agent_person_no_fk != '' ? $reference_name : '' }}"
                                                        placeholder="Reference" maxlength="">
                                                    <input type="hidden" id="hdn_reference" name="hdn_reference"
                                                        value="{{ $ref_agent_person_no_fk != '' ? $reference : '' }}">
                                                </div>
                                            </div>
                                            <label for="present_address"
                                                class="col-sm-3 col-form-label col-form-label-sm">Present Add.</label>
                                            <div class="col-sm-3">
                                                <input type="text"
                                                    class=" form-control form-control-sm"
                                                    id="present_address" name="present_address"
                                                    value="{{ $present_address }}"
                                                    placeholder=""
                                                    required maxlength="200">

                                            </div>

                                            <label for="pharmacy_name"
                                                class="col-sm-3 col-form-label col-form-label-sm">Pharmacy Name</label>
                                            <div class="col-sm-3">
                                                <input type="text"
                                                    class=" form-control form-control-sm"
                                                    id="pharmacy_name" name="pharmacy_name"
                                                    value="{{$agent_institute_name}}"
                                                    placeholder="Enter Pharmacy Name">
                                            </div>
                                        </div>


                                        <div class="form-group row d-none referral_info" id="">
                                            <label for="doctor_specialization"
                                                class="col-sm-3 col-form-label col-form-label-sm ">Specialization</label>
                                            <div class="col-sm-3  ">
                                                <select class="form-control font_size_12 m-auto select2"
                                                    id="doctor_specialization" name="doctor_specialization">
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

                                            <label for="doctor_nid" class="col-sm-3 col-form-label col-form-label-sm">
                                                Degree1</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="degree1" name="doctor_degree1"
                                                    value="{{ $doctor_degree1 }}" placeholder="degree1"
                                                    maxlength="20">
                                            </div>
                                        </div>

                                        <div class="form-group row d-none referral_info" id="">
                                            <label for=""
                                                class="col-sm-3 col-form-label col-form-label-sm">Degree2
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="degree2" name="doctor_degree2"
                                                    value="{{ $doctor_degree2 }}" placeholder="degree2"
                                                    maxlength="30">
                                            </div>

                                            <label for="doctor_nid"
                                                class="col-sm-3 col-form-label col-form-label-sm">Degree3</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="degree2" name="doctor_degree3"
                                                    value="{{ $doctor_degree3 }}" placeholder="degree2"
                                                    maxlength="20">
                                            </div>

                                        </div>
                                        <div class="form-group row d-none referral_info" id="">

                                            <label for="doctor_nid"
                                                class="col-sm-3 col-form-label col-form-label-sm">Degree4</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="degree4" name="doctor_degree4"
                                                    value="{{ $doctor_degree4 }}" placeholder="degree4"
                                                    maxlength="20">
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
                                                            <input type="file" id="imageUpload" name="doc_photo"
                                                                accept=".png, .jpg, .jpeg"
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

                            <div id="mobile_apps" class="collapse p-1" aria-labelledby="headingOne"
                                data-parent="#accordion">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body pt-2">
                                            <div class="form-group row">
                                                <label for="apps_user"
                                                    class="col-sm-2 col-form-label col-form-label-sm">Apps User
                                                    &nbsp; <input type="checkbox" class="" id=" apps_user"
                                                        name="apps_user" value="1"
                                                        @if ($apps_user == 1) checked @endif>
                                                </label>


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
                                                        id="passcode" name="passcode" value="{{ $passcode }}"
                                                        placeholder="Passcode">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="self_referrence_ind"
                                                    class="col-sm-2 col-form-label col-form-label-sm">Self
                                                    Referrence
                                                    &nbsp; <input type="checkbox" class=""
                                                        id="self_referrence_ind" name="self_referrence"
                                                        value=""
                                                        @if ($ref_agent_person_no_fk != '' && $ref_agent_person_no_fk == $doctor_no_pk) checked @endif> </label>


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
    </div>



    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class="form-group form-row" id="status_data_ind">

                        <input type="checkbox" name="referral_doctor_ind" value="1" id="referral_doctor_ind"
                            {{ $doctor_ind == 1 ? 'checked' : '' }}>
                        <label for="referral_doctor_ind" class=" ml-0 pl-1">Doctor
                        </label> &nbsp; &nbsp;
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
                        <input type="checkbox" name="mpo_ind" value="1" id="mpo_ind"
                            {{ $mpo_ind == 1 ? 'checked' : '' }}>
                        <label for="mpo_ind" class=" ml-0 pl-1">MPO IND
                        </label>

                        &nbsp; &nbsp;
                        <input type="checkbox" name="status_ind" value="1" id="status_ind"
                            {{ $status == 1 ? 'checked' : '' }}>
                        <label for="status_ind" class=" ml-0 pl-1">Status
                        </label>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @php
        $doctor_id = '';
        $response_url = route('referral-card', $doctor_id);
    @endphp

    <div class="form-row">
        <div class="col-md-12">
            <div class="employee_registration">
                <div class="card">
                    <div class="card-body p-2">
                        <button class="btn btn-md btn-success" id="save_referral" data-func="afterSaveModal"
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorDegreeAutocomplete('#doctor_degree1');
    openDoctorDegreeAutocomplete('#doctor_degree2');
    openDoctorDegreeAutocomplete('#doctor_degree3');
    openDoctorDegreeAutocomplete('#doctor_degree4');
    $(document).on('click', '#self_referrence_ind', function() {

        if ($('#self_referrence_ind').is(':checked')) {
            var self_referrence = $('#self_referrence_ind').val();
            var ref_name = $('#doctor_first_name').val();
            var ref_id = $('#employee_id').val();
            $('#referrence_name').val(ref_name);
            $('#hdn_referrence_name').val(ref_id);

        } else {
            $('#referrence_name').val('');
            $('#hdn_referrence_name').val('');
        }

    });

    openDoctorAutocomplete('#reference', 'hdn_reference');

    $(document).ready(function() {

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

        if ($('.marketing_type:checked').val() == 1) {
            $(".referral_info").removeClass('d-none');

        } else {
            $(".referral_info").addClass('d-none');

        }

        $('.marketing_type').on('change', function() {
            // alert('ok');
            if (this.value == 1) {
                $(".referral_info").removeClass('d-none');
                $("#agent_info").addClass('d-none');
            } else if (this.value == 2) {
                $("#agent_info").removeClass('d-none');
                $(".referral_info").addClass('d-none');
            } else {
                $(".referral_info").addClass('d-none');
                $("#agent_info").addClass('d-none');
            }
        });

        //  if($('#doctor_job_type').val() == 41){
        //     $('.specialization').removeClass('d-none');
        // }else{
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



    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }

    $(function() {

        $(document).on("click", '#save_referral', function(e) {
            if (confirm("Are you sure?")) {
                var page_type = "{{ $page_type }}";
                $('#doctor_form').unbind().submit(function(e) {
                    e.preventDefault();
                    var formAction = $(this).attr("action");
                    var formMethod = $(this).attr("method");
                    var formData = new FormData(this);
                    var customFunc = $("#save_referral").attr("data-func");

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
                            var response_url = $("#save_referral").attr(
                                "data-response-url") + "/" + data.insert_id;
                            dynamicFunc.afterSaveModal(response_url,
                                "common-modal-sm",
                                "Referral Card");

                            // marketing
                            //$("#referrer_name_con").val(data.insert_id);

                            $(this).find("input, textarea").not('.keep_me').val("");
                            $(this).find("select").not('.keep_me').val("0");
                        },
                        error: function(data) {
                            console.log(data);
                        },
                        complete: function() {
                            $.unblockUI();
                            if (page_type == 'edit')
                                dynamicFunc.afterSaveLoadList(
                                    "{{ route('referral-list') }}");
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
</script>
