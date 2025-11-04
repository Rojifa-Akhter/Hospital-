@php
$patient = isset($data) && !empty($data) ? $data : [];
$patient_no_pk = $patient ? $patient->patient_no_pk : '';
$patient_salutation = $patient ? $patient->salutation : '';
$patient_first_name =
$patient && $patient->first_name != ''
? $patient->first_name
: (isset($patient->patient_name)
? $patient->patient_name
: '');
$patient_last_name = $patient ? $patient->last_name : '';
$occupation = $patient ? $patient->occupation : '';
$patient_age_d = $patient ? $patient->age_dd : '';
$patient_age_m = $patient ? $patient->age_mm : '';
$patient_age = $patient ? $patient->age_yy : '';
$patient_dob = $patient && $patient->dob != '' ? date('d-m-Y', strtotime($patient->dob)) : '';
$patient_dobs = $patient && $patient->dob != '' ? date('d/m/Y', strtotime($patient->dob)) : '';
$patient_address1 = $patient ? $patient->emergency_contact_addr : '';
$photo_name = $patient ? $patient->patient_photo : '';
$doctor_permanent_district = $patient ? $patient->permanent_district : '';
$doctor_present_district = $patient ? $patient->present_district : '';
$doctor_present_thana = $patient ? $patient->pr_addr_thana : '';
$doctor_permanent_thana = $patient ? $patient->pe_addr_thana : '';

$present_addr = $patient ? $patient->present_addr : '';
$permanent_addr = $patient ? $patient->permanent_addr : '';

$patient_nid = $patient ? $patient->national_id : '';
$phone_no = $patient ? $patient->mobile1 : '';
$mobile2 = $patient ? $patient->mobile2 : '';
$patient_father = $patient ? $patient->father_name : '';
$patient_mother = $patient ? $patient->mother_name : '';
$patient_spouse = $patient ? $patient->spouse_name : '';
$patient_email = $patient ? $patient->email : '';
$patient_blood_group = $patient ? $patient->blood_group : '';
$salutation = $patient ? $patient->salutation : '';
$present_addres = $patient ? $patient->present_addr : '';
$parmanent_address = $patient ? $patient->permanent_addr : '';
$emergency_contact_address = $patient ? $patient->emergency_contact_addr : '';
$patient_nationality = $patient ? $patient->nationality : '';
$patient_passport = $patient ? $patient->passport_no : '';
$patient_gender = $patient ? $patient->gender : '';
$patient_marital_status = $patient ? $patient->marital_status : '';
$patient_religion = $patient ? $patient->religion : '';
$present_district = $patient ? $patient->present_district : '';
$parmanent_district = $patient ? $patient->permanent_district : '';

$doctor_present_thana = $patient ? $patient->pr_addr_thana : '';
$doctor_permanent_thana = $patient ? $patient->pe_addr_thana : '';
$present_country = $patient ? $patient->pr_addr_thana : '';
$permanent_country = $patient ? $patient->pe_addr_thana : '';

$emergency_contact_name = $patient ? $patient->emergency_contact_name : '';
$emergency_contact_relation = $patient ? $patient->relation_lookup_pk_no : '';
$emergency_contact_contact = $patient ? $patient->emergency_contact_contact : '';
$status = $patient ? $patient->status : '';
$patient_type_data = $patient ? $patient->patient_type : '';
$ccm_client_no_pk = $patient ? $patient->ccm_client_no_fk : '';
$cor_member_no_pk = $patient ? $patient->cor_member_no_pk : '';

$membershid_id = $patient ? optional($patient)->membershid_id : '';
$cardnumber = $patient ? optional($patient)->cardnumber : '';
$membership_organization_name = $patient ? optional($patient)->membership_organization_name : '';
$currentdesignationname = $patient ? optional($patient)->currentdesignationname : '';
$pat_relation_name_stf_oth = $patient ? optional($patient)->pat_relation_name_stf_oth : '';
$ref_person_no_fk = $patient ? $patient->ref_person_no_fk : '';
$emp_full_name = $patient ? $patient->full_name : '';
$cardnumber = $patient ? optional($patient)->cardnumber : '';

$is_health_insurance = $patient ? $patient->oi_ins_comp_name : '';
$insurance_company_name = $patient ? $patient->oi_ins_comp_name : '';
$local_guardian = $patient ? $patient->oi_locar_guardian : '';
$relationship_with_local_guardian = $patient ? $patient->oi_relation_with_guar : '';
$local_guardian_mobile = $patient ? $patient->oi_guar_mobile_no : '';
$passport_no_foreign = $patient ? $patient->fi_passport_no : '';
$visa_no_foreign = $patient ? $patient->fi_visa_no : '';
$visa_validity = !empty($patient->fi_visa_validity) ? date('m/d/Y', strtotime($patient->fi_visa_validity)) : '';
$visa_type = $patient ? $patient->fi_visa_type : '';
$inform_text = $patient ? $patient->inform_text : '';
$inform_agent_id = $inform_agent_id ? $inform_agent_id : '';
$inform_agent_name = $inform_agent_name ? $inform_agent_name : '';
$is_health_insurance = $patient ? $patient->oi_ins_comp_name : '';
$insurance_company_name = $patient ? $patient->oi_ins_comp_name : '';
$local_guardian = $patient ? $patient->oi_locar_guardian : '';
$relationship_with_local_guardian = $patient ? $patient->oi_relation_with_guar : '';
$local_guardian_mobile = $patient ? $patient->oi_guar_mobile_no : '';
$passport_no_foreign = $patient ? $patient->fi_passport_no : '';
$visa_no_foreign = $patient ? $patient->fi_visa_no : '';
$visa_validity = !empty($patient->fi_visa_validity) ? date('m/d/Y', strtotime($patient->fi_visa_validity)) : '';
$visa_type = $patient ? $patient->fi_visa_type : '';



// From Appointment
if(Route::currentRouteName() == 'patient-create'){
$appoint_data = isset($appoint_data) && !empty($appoint_data) ? $appoint_data : [];
$appoint_no_pk = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->appoint_no_pk : '';
$patient_first_name = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->patient_name : '';
$phone_no = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->phone_mobile : '';
$patient_email = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->email : '';
$patient_age_d = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->age_dd : '';
$patient_age_m = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->age_mm : '';
$patient_age = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->age_yy : '';
$patient_dob = isset($appoint_data) && !empty($appoint_data->dob) ? date('d-m-Y', strtotime($appoint_data->dob)) : '';
$patient_dobs = isset($appoint_data) && !empty($appoint_data->dob) ? date('d/m/Y', strtotime($appoint_data->dob)) : '';
$patient_gender = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->gender : '';
$present_addr = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->address : '';
$permanent_addr = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->address : '';
$patient_blood_group = isset($appoint_data) && !empty($appoint_data) ? $appoint_data->blood_group : '';
}



@endphp
<style>
    .error {
        color: red;
        font-size: 11px;
    }

    .not-clickable {
        pointer-events: none;
        cursor: not-allowed;
    }

    /* .agent_id_container,
    .staff_id_container,
    .campaign_container,
    .others_container {
        display: none;
    } */
    .input-highlight input {
        border: 2px solid #007bff;
        /* Bootstrap primary blue */
        background-color: #e7f1ff;
        /* light blue background */
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form method="post" id="frm-pat-registration" action="{{ route('registration.storeV2') }}" enctype="multipart/form-data"
    action="javascript:void(0)">
    @csrf
    <input type="hidden" name="id" id="pat_id" value="{{ $patient_no_pk }}">

    <div class="card no-b no-r">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>BASIC INFORMATION.
                        <!-- Trigger the modal with a button -->
                        @if (Session::get('user.ses_hospital_code') == 'DMHL')
                        Is Dhaka Credit Member? <button type="button" class="btn btn-info btn-ms"
                            data-toggle="modal" data-target="#myModal">Get data</button>
                        @endif

                    </h5>
                </div>

                <div class="col-md-4">
                    <input type="text" class="form-control" id="check_patient_id" name="check_patient_id"
                        placeholder="Check Existing Patient By Name/Mobile" title="Check Patient Info" />
                </div>
            </div>
        </div>
 <input type="hidden" name="appoint_no_pk" id="appoint_no_pk" value="{{ @$appoint_no_pk }}">
        <div class="card-body">
            @if (Session::get('user.ses_hospital_code') == 'DMHL')
            <div class="form-row mt-1">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_type" class="col-form-label s-12">Patient Type</label>
                    <select class="form-control form-control-sm text-capitalize" id="patient_type"
                        name="patient_type" value="" onchange="corporate(this)">
                        @if (!empty($patient_type))
                        @foreach ($patient_type as $data)
                        <option data-type_code="{{ $data->patient_type_code }}"
                            value="{{ $data->patient_type_no_pk }}"
                            {{ $data->patient_type_no_pk == $patient_type_data ? 'selected' : '' }}>
                            {{ $data->patient_type_code }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @php
                $d_none = $ccm_client_no_pk == '' ? 'd-none' : '';
                $membershid_id_class = $membershid_id == '' ? 'd-none' : '';
                $cardnumber_class = $cardnumber == '' ? 'd-none' : '';
                $membership_organization_name_class = $membership_organization_name == '' ? 'd-none' : '';
                $currentdesignationname_class = $currentdesignationname == '' ? 'd-none' : '';
                $pat_relation_name_stf_oth_class = $pat_relation_name_stf_oth == '' ? 'd-none' : '';
                $ref_person_no_fk_class = $ref_person_no_fk == '' ? 'd-none' : '';
                // dd($d_none);
                @endphp
                <div class="form-group col-4 m-0 focused emp_id {{ $membershid_id_class }}">
                    <label for="emp_id" class="col-form-label s-12   ">EMP Id / Membership Id <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm " id="emp_id" name="emp_id"
                        value="{{ $membershid_id }}" placeholder="Enter EMP Id / Membership Id">
                    <input type="hidden" name="card_no" id="card_no" value="{{ $cardnumber }}">
                   
                </div>
                <div class="form-group col-4 m-0 focused hospital_emp_id {{ $ref_person_no_fk_class }}">
                    <label for="emp_id" class="col-form-label s-12   ">Hospital Card Number <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control " name="hospital_emp_name" id="hospital_emp_name"
                        value="{{ $emp_full_name }}" placeholder="Card Number" />
                    <input type="hidden" name="hospital_emp_id_hidden" id="hospital_emp_id_hidden"
                        value="{{ $ref_person_no_fk }}">
                </div>
                <div class="form-group col-4 m-0 focused organization {{ $membership_organization_name_class }}">
                    <label for="organization" class="col-form-label s-12">Organization Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="organization" name="organization"
                        value="{{ $membership_organization_name }}" placeholder="Enter Organization Name">

                </div>
                <div class="form-group col-4 m-0 focused designation {{ $currentdesignationname_class }}">
                    <label for="designation" class="col-form-label s-12">Designation <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="designation" name="designation"
                        value="{{ $currentdesignationname }}" placeholder="Enter designation Name">

                </div>

                <div class="form-group col-4 m-0   relation_data {{ $pat_relation_name_stf_oth_class }}">
                    <label for="relation_data" class="col-form-label s-12 ">Relation <span
                            class="text-danger">*</span></label>

                    <select class="form-control font_size_12 m-auto " id="relation_data" name="relation_data">
                        <option value="">Select Relation</option>
                        @if (isset($relation))
                        @foreach ($relation as $kye => $value)
                        <option value="{{ $value }}"
                            {{ $pat_relation_name_stf_oth == $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col-4 m-0 focused  corporate_name {{ $d_none }}">
                    <label for="corporate_name" class="col-form-label s-12 ">Corporate <span
                            class="text-danger">*</span></label>
                    <select class="form-control font_size_12 m-auto " id="corporate_name" name="corporate_name">
                        <option value="">Select Corporate</option>
                        @if (isset($corporate_info))
                        @foreach ($corporate_info as $value)
                        <option value="{{ $value->ccm_client_no_pk }}"
                            {{ $value->ccm_client_no_pk == $ccm_client_no_pk ? 'selected' : '' }}>
                            {{ $value->ccm_client_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-4 m-0 focused corporate_id {{ $d_none }}">
                    <label for="corporate_id" class="col-form-label s-12  ">Corporate ID</label>
                    <input type="text" class="form-control form-control-sm " maxlength="50" id="corporate_id"
                        name="corporate_id" value="{{ $cor_member_no_pk }}" placeholder="Enter Corporate ID">

                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="occupation" class="col-form-label s-12">Occupation</label>
                    <input type="text" class="form-control form-control-sm" id="occupation" name="occupation"
                        placeholder="Enter your occupation" value="{{@$occupation}}">
                    {{-- <select class="form-control font_size_12 m-auto" id="patient_blood_group" name="pat_blood_group">
                        <option value="0">Select Blood Group</option>
                        @if (isset($bloodg))
                            @foreach ($bloodg as $key => $value)
                                <option value="{{ $key }}" @if ($patient_blood_group == $key) selected @endif>
                    {{ $value }}
                    </option>
                    @endforeach
                    @endif
                    </select> --}}
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="inform" class="col-form-label s-12">Heard About Us ? </label>
                    <select class="form-control font_size_12 m-auto " id="inform" name="inform">
                        <option value="">Select Where You Heard About Us ?</option>
                        <option value="REFERRAL DOCTOR" {{ $inform_text == 'REFERRAL DOCTOR' ? 'selected' : '' }}>Referral Doctor</option>
                        <option value="MARKETING AGENT" {{ $inform_text == 'MARKETING AGENT' ? 'selected' : '' }}>Marketing Agent</option>
                        <option value="STAFF" {{ $inform_text == 'STAFF' ? 'selected' : '' }}>Staff</option>
                        <option value="CAMPAIGN" {{ $inform_text == 'CAMPAIGN' ? 'selected' : '' }}>Campaign</option>
                        <option value="SOCIAL MEDIA" {{ $inform_text == 'SOCIAL MEDIA' ? 'selected' : '' }}>Social Media</option>
                        <option value="INSTITUTE" {{ $inform_text == 'INSTITUTE' ? 'selected' : '' }}>Institute</option>
                        <option value="OTHERS" {{ $inform_text == 'OTHERS' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>
                <div class="col-md-8"></div>
                <!-- Marketing Agent input group -->
                <div class="col-md-4 agent_id_container d-none">
                    <div class="form-group row">
                        <label for="agent_id_input" class="col-sm-12 col-form-label col-form-label-sm">Agent ID</label>
                        <div class="col-sm-12">
                            <input type="text"
                                class="form-control form-control-sm"
                                maxlength="50"
                                id="agent_id_input"
                                name="agent"
                                placeholder="Enter Agent ID"
                                value="{{ ($inform_text ?? '') == 'MARKETING AGENT' ? $inform_agent_name : '' }}">

                            <input type="hidden"
                                name="agent_id_hdn"
                                id="agent_id_hdn"
                                value="{{ ($inform_text ?? '') == 'MARKETING AGENT' ? $inform_agent_id : '' }}">
                        </div>
                    </div>
                </div>

                <!-- Staff input group -->
                <div class="col-md-4 staff_id_container d-none">
                    <div class="form-group row">
                        <label for="staff_id_input" class="col-sm-12 col-form-label col-form-label-sm">Staff ID</label>
                        <div class="col-sm-12">
                            <input type="text"
                                class="form-control form-control-sm"
                                maxlength="50"
                                id="staff_id_input"
                                name="staff"
                                placeholder="Enter Staff ID"
                                value="{{ ($inform_text ?? '') == 'STAFF' ? $inform_agent_name : '' }}">

                            <input type="hidden"
                                name="hdn_staff__id"
                                id="hdn_staff__id"
                                value="{{ ($inform_text ?? '') == 'STAFF' ? $inform_agent_id : '' }}">
                        </div>
                    </div>
                </div>


                <!-- Campaign input group -->
                <div class="col-md-4 campaign_container  d-none">
                    <div class="form-group row">
                        <label for="campaign_input" class="col-sm-12 col-form-label col-form-label-sm">Campaign Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" maxlength="50" id="campaign_input"
                                name="campaign" placeholder="Enter Campaign Name">
                        </div>
                    </div>
                </div>



                <!-- Others input group -->
                <div class="col-md-4 others_container  d-none">
                    <div class="form-group row">
                        <label for="others_input" class="col-sm-12 col-form-label col-form-label-sm">Others Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" maxlength="50" id="others_input"
                                name="others" placeholder="Enter Others Info">
                        </div>
                    </div>
                </div>

                <!-- Referral Doctor select -->
                <div class="col-md-4 referral_doctor_container d-none">
                    <div class="form-group row">
                        <label for="referral_doctor_select" class="col-sm-12 col-form-label col-form-label-sm">Referral Doctor</label>
                        <div class="col-sm-12">
                            <input type="text"
                                class="form-control form-control-sm"
                                maxlength="50"
                                id="ref_doc_input"
                                name="ref_doc"
                                placeholder="Enter Referral Doctor ID"
                                value="{{ ($inform_text ?? '') == 'REFERRAL DOCTOR' ? $inform_agent_name : '' }}">

                            <input type="hidden"
                                name="ref_doc_hdn"
                                id="ref_doc_hdn"
                                value="{{ ($inform_text ?? '') == 'REFERRAL DOCTOR' ? $inform_agent_id : '' }}">
                        </div>
                    </div>
                </div>

                <!-- Social Media select -->
                <div class="col-md-4 social_media_container d-none">
                    <div class="form-group row">
                        <label for="social_media_select" class="col-sm-12 col-form-label col-form-label-sm">Social Media</label>
                        <div class="col-sm-12">
                            <!-- <select class="form-control form-control-sm" id="social_media_select" name="social_media">
                                <option value="">Select Social Media</option>
                                <option value="Facebook">Facebook</option>
                                <option value="LinkedIn">LinkedIn</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Twitter">Twitter</option>
                            </select> -->
                            <select class="form-control form-control-sm" id="social_media_select" name="social_media">
                                <option value="">Select Social Media</option>
                                @if(!empty($socialMediaList) && $socialMediaList->count() > 0)
                                    @foreach($socialMediaList as $media)
                                        <option value="{{ $media->social_media_code }}"
                                            {{ (isset($selectedSocialMedia) && $selectedSocialMedia == $media->social_media_code) ? 'selected' : '' }}>
                                            {{ $media->social_media_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No Social Media Found</option>
                                @endif
                            </select>

                        </div>
                    </div>
                </div>

                <!-- Institute input -->
                <div class="col-md-4 institute_container d-none">
                    <div class="form-group row">
                        <label for="institute_input" class="col-sm-12 col-form-label col-form-label-sm">Institute Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" id="institute_input" name="institute"
                                placeholder="Enter Institute Name" maxlength="100">
                        </div>
                    </div>
                </div>


            </div>
            @endif
            <div class="form-row align-items-center">
                <div class="col-md-9">
                    <div class="form-group m-0 focused">
                        <label for="name" class="col-form-label s-12">PATIENT NAME <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="form-control font_size_12 m-auto " id="patient_salutation"
                                    name="pat_salutation">
                                    <option value="">Select </option>
                                    @if (isset($name_prefix))
                                    @foreach ($name_prefix as $key => $value)
                                    <option value="{{ $value }}"
                                        @if ($salutation==$value) selected @endif>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>
                            {{-- <input type="text" class="form-control form-control-sm required text-capitalize" id="patient_first_name" name="pat_f_name" value="{{ $patient_first_name }}" placeholder="First Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" required maxlength="50"> --}}
                            <input type="text" class="form-control form-control-sm required text-capitalize"
                                id="patient_first_name" name="pat_f_name" value="{{ $patient_first_name }}"
                                placeholder="First Name" required maxlength="50">

                            {{-- <input type="text" class="form-control form-control-sm  text-capitalize" id="patient_last_name" name="pat_l_name" value="{{ $patient_last_name }}" placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50"> --}}
                            <input type="text" class="form-control form-control-sm  text-capitalize"
                                id="patient_last_name" name="pat_l_name" value="{{ $patient_last_name }}"
                                placeholder="Last Name" maxlength="50">

                        </div>
                    </div>

                    @php
                    $pat_dob = new \DateTime($patient_dob);
                    $current_date = new \DateTime();
                    $current_date->modify('+1 day');
                    $interval = $current_date->diff($pat_dob);
                    $patient_year = $interval->y ? $interval->y : '';
                    $patient_month = $interval->m ? $interval->m : '';
                    $patient_day = $interval->d ? $interval->d : '';

                    @endphp

                    <div class="form-row">
                        <div class="form-group col-4 m-0 focused">
                            <label for="pat_age_y" class="col-form-label s-12">AGE <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend w-100">
                                    <input type="number" class="form-control form-control-sm" id="pat_age_y"
                                        name="pat_age_y" value="{{ !empty($patient_year) ? $patient_year : 0 }}"
                                        placeholder="YY" {{ $patient_no_pk ? '' : 'required' }}
                                        oninput="calBirthDate()" required>
                                    <input type="number" class="form-control form-control-sm" id="pat_age_m"
                                        name="pat_age_m" value="{{ !empty($patient_month) ? $patient_month : 0 }}"
                                        placeholder="MM" oninput="calBirthDate()">
                                    <input type="number" class="form-control form-control-sm" id="pat_age_d"
                                        name="pat_age_d" value="{{ !empty($patient_day) ? $patient_day : 1 }}"
                                        placeholder="DD" oninput="calBirthDate()">
                                </div>
                            </div>
                        </div>



                        <div class="form-group col-4 m-0 focused">
                            <label for="patient_dob" class="col-form-label s-12">DATE OF BIRTH</label>
                            <input type="text" class="form-control form-control-sm  datepicker" autocomplete="off"
                                id="patient_dob" name="pat_dob" value="{{ $patient_dobs }}"
                                placeholder="dd/mm/yyyy" onchange="calculateAge(this.value)">
                        </div>


                        <div class="form-group col-4 m-0">

                            <label for="pat_gender_1" class="col-form-label s-12">GENDER <span
                                    class="text-danger">*</span></label>
                            <br>

                            @if (isset($gender))
                            @php $i=1; @endphp
                            @foreach ($gender as $key => $value)
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pat_gender_{{ $i }}" name="pat_gender"
                                    class="custom-control-input keep_me" value="{{ $key }}"
                                    {{ $key == $patient_gender ? 'checked' : '' }} required>
                                <label class="custom-control-label"
                                    for="pat_gender_{{ $i }}">{{ $value }}</label>
                            </div>
                            @php $i++; @endphp
                            @endforeach
                            @endif
                        </div>

                    </div>


                </div>
                <div class="col-md-3 text-center">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="pat_photo" accept=".png, .jpg, .jpeg"
                                value="{{ !empty($photo_name) ? $photo_name : '' }}">
                            <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            @if (!empty($photo_name))
                            @php
                            $imgUrl = 'images/uploads/patient_images/thumb/' . $photo_name;
                            @endphp
                            <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');">
                            </div>
                            @else
                            <div id="imagePreview" style="background-image: url('images/pt-patient.jpg');">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!--  <div class="col-md-3 offset-md-1">
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type="file" id="imageUpload" name="pat_photo" accept=".png, .jpg, .jpeg">
                    <label for="imageUpload"></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url('../public/images/pt-patient.jpg');">
                    </div>
                </div>
            </div>
        </div> -->

            </div>
            <div class="form-row mt-1">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_blood_group" class="col-form-label s-12">BLOOD GROUP</label>
                    <select class="form-control font_size_12 m-auto" id="patient_blood_group" name="pat_blood_group">
                        <option value="0">Select Blood Group</option>
                        @if (isset($bloodg))
                        @foreach ($bloodg as $key => $value)
                        <option value="{{ $key }}"
                            @if ($patient_blood_group==$key) selected @endif>
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_marital_status" class="col-form-label s-12">MARITAL STATUS</label>
                    <select class="form-control font_size_12 m-auto patient_marital_status"
                        id="patient_marital_status" name="pat_marital_status">
                        <option value="0">Select Marital Status</option>
                        @if (isset($marital_status))
                        @foreach ($marital_status as $key => $value)
                        <option value="{{ $key }}"
                            @if ($patient_marital_status==$key) selected @endif>
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                <div class="form-group col-4 m-0">
                    <label for="patient_religion" class="col-form-label s-12">RELIGION </label>
                    <select class="form-control font_size_12 m-auto" id="patient_religion" name="pat_religion">
                        <option value="">Select Religion</option>
                        @if (isset($religion))
                        @foreach ($religion as $key => $value)
                        <option value="{{ $key }}"
                            @if ($patient_religion==$key) selected @endif>
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @else
                <div class="form-group col-4 m-0">
                    <label for="patient_religion" class="col-form-label s-12">RELIGION <span
                            class="text-danger">*</span></label>
                    <select class="form-control font_size_12 m-auto" required id="patient_religion"
                        name="pat_religion">
                        <option value="">Select Religion</option>
                        @if (isset($religion))
                        @foreach ($religion as $key => $value)
                        <option value="{{ $key }}"
                            @if ($patient_religion==$key) selected @endif>
                            {{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @endif
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_nationality" class="col-form-label s-12">NATIONALITY</label>
                    <select class="form-control form-control-sm text-capitalize" id="patient_nationality"
                        name="pat_nationality" value="">
                        <option value="Bangladeshi">Select Country</option>
                        @if (isset($nationality))
                        @foreach ($nationality as $key => $value)
                        <option value="{{ $key }}" @if ($patient_nationality==$key) selected @endif
                            {{ $value == 'Bangladeshi' ? 'selected' : '' }}>{{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_nid" class="col-form-label s-12">NID</label>
                    <input type="text" class="form-control form-control-sm" id="patient_nid" name="pat_nid"
                        value="{{ $patient_nid }}" placeholder="Enter Patient NID"
                        onkeypress="return /^[0-9]+$/.test(event.key)" maxlength="17">
                </div>
                <div class="form-group col-4 m-0">
                    <label for="patient_passport" class="col-form-label s-12">PASSPORT NO</label>
                    <input type="text" class="form-control form-control-sm" id="patient_passport"
                        name="pat_passport" value="{{ $patient_passport }}" placeholder="Enter Patient Passport No"
                        maxlength="50">
                </div>
            </div>
            @if (Session::get('user.ses_hospital_code') != 'DMHL')
            <div class="form-row mt-1">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_type" class="col-form-label s-12">Patient Type</label>
                    <select class="form-control form-control-sm text-capitalize" id="patient_type"
                        name="patient_type" value="" onchange="corporate(this)">
                        @if (!empty($patient_type))
                        @foreach ($patient_type as $data)
                        <option data-type_code="{{ $data->patient_type_code }}"
                            value="{{ $data->patient_type_no_pk }}"
                            {{ $data->patient_type_no_pk == $patient_type_data ? 'selected' : '' }}>
                            {{ $data->patient_type_code }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @php
                $d_none = $ccm_client_no_pk == '' ? 'd-none' : '';
                // dd($d_none);
                @endphp
                <div class="form-group col-4 m-0 focused  corporate_name {{ $d_none }}">
                    <label for="corporate_name" class="col-form-label s-12 ">Corporate <span
                            class="text-danger">*</span></label>
                    <select class="form-control font_size_12 m-auto " id="corporate_name" name="corporate_name">
                        <option value="">Select Corporate</option>
                        @if (isset($corporate_info))
                        @foreach ($corporate_info as $value)
                        <option value="{{ $value->ccm_client_no_pk }}"
                            {{ $value->ccm_client_no_pk == $ccm_client_no_pk ? 'selected' : '' }}>
                            {{ $value->ccm_client_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-4 m-0 focused {{ $d_none }} corporate_id">
                    <label for="corporate_id" class="col-form-label s-12  d-none ">Corporate ID</label>
                    <input type="text" class="form-control form-control-sm d-none " maxlength="50"
                        id="corporate_id" name="corporate_id" value="{{ $cor_member_no_pk }}"
                        placeholder="Enter Corporate ID">

                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="occupation" class="col-form-label s-12">Occupation</label>
                    <input type="text" class="form-control form-control-sm" id="occupation" name="occupation"
                        placeholder="Enter your occupation">
                    {{-- <select class="form-control font_size_12 m-auto" id="patient_blood_group" name="pat_blood_group">
                        <option value="0">Select Blood Group</option>
                        @if (isset($bloodg))
                            @foreach ($bloodg as $key => $value)
                                <option value="{{ $key }}" @if ($patient_blood_group == $key) selected @endif>
                    {{ $value }}
                    </option>
                    @endforeach
                    @endif
                    </select> --}}
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="inform" class="col-form-label s-12">Heard About Us ? </label>
                    <select class="form-control font_size_12 m-auto " id="inform" name="inform">
                        <option value="">Select Where You Heard About Us ?</option>
                        @if (isset($inform))
                        @foreach ($inform as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            @endif
        </div>
        <hr>

        <div class="card-header">
            <h5>CONTACT INFORMATION</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-4 m-0 focused">
                    <label for="mobile_no" class="col-form-label s-12">MOBILE NO <span
                            class="text-danger">*</span></label>
                    {{-- digits --}}
                    <input type="text" class="form-control form-control-sm " id="mobile_no"
                        name="mobile_no" value="{{ $phone_no ? $phone_no : '+880' }}"
                        placeholder="Enter Patient Phone number" required="required"
                        onkeypress="return /^[0-9+]+$/.test(event.key)" maxlength="14">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="phone_no" class="col-form-label s-12">PHONE NO</label>
                    <input type="text" class="form-control form-control-sm digits number_only" id="phone_no"
                        name="phone_no" onkeypress="return /^[0-9+]+$/.test(event.key)" value="{{ $mobile2 }}"
                        placeholder="Enter Patient Phone Number" maxlength="14">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_email" class="col-form-label s-12">EMAIL</label>
                    <input type="email" class="form-control form-control-sm email" id="patient_email"
                        name="pat_email" value="{{ $patient_email }}" placeholder="abc@gmail.com"
                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*" maxlength="50">
                </div>
            </div>
        </div>
        <hr>
        <div class="card-header">
            <h5>ADDRESS INFORMATION</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-3">
                    <label for="present_address" class="col-form-label col-form-label-sm">Present <span
                            class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control form-control-sm same_as_pre_add required text-capitalize"
                        id="present_address" name="present_address" value="{{ $present_addr }}"
                        placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213" required maxlength="200">
                </div>

                <div class="col-sm-3">
                    <label for="doctor_present_district" class=" col-form-label col-form-label-sm">District</label>
                    <select class="form-control font_size_12 m-auto select2  " id="present_district"
                        name="present_district">
                        <option value="">Select District</option>
                        @if (isset($district))
                        @foreach ($district as $value)
                        <option value="{{ $value->id }}"
                            @if ($present_district==$value->id) selected @endif>
                            {{ $value->name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="" class=" col-form-label col-form-label-sm">Thana</label>
                    <div id="present_thana">

                        @include('admin.patient.pre_thana')

                    </div>
                </div>


                <div class="col-sm-3">
                    <label for="post_code" class=" pl-1 col-form-label col-form-label-sm">Country
                    </label>
                    <select class="form-control font_size_12 m-auto" id="present_country" name="present_country">
                        <option value="Bangladesh" {{ $present_country == 'Bangladesh' ? 'selected' : '' }}>
                            Bangladesh</option>
                        <option value="Others" {{ $present_country == 'Others' ? 'selected' : '' }}>Others
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-row">


                <div class="col-sm-3">
                    <label for="parmanent_address" class=" col-form-label col-form-label-sm">Permanent </label>
                    <div class="input-group">
                        <div class="input-group-prepend" title="Same as Prensent Address">
                            <div class="input-group-text">
                                <input type="checkbox" class="same_pre_and_par"
                                    aria-label="Checkbox for following text input" id="same_pre_and_par"
                                    {{ $permanent_addr == $present_addr && $permanent_addr != '' ? 'checked' : '' }}>
                            </div>
                        </div>

                        <input type="text" class="form-control form-control-sm same_as_par_add text-capitalize"
                            id="parmanent_address" name="parmanent_address"
                            placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213"
                            value="{{ $permanent_addr }}" maxlength="200">
                    </div>
                </div>

                <div class="col-sm-3">
                    <label for="doctor_par_district" class="col-form-label col-form-label-sm">District</label>
                    <select class="form-control font_size_12 m-auto select2" id="par_district" name="par_district">
                        <option value="0">Select District</option>

                        @if (isset($district))

                        @foreach ($district as $value)
                        <option value="{{ $value->id }}"
                            @if ($parmanent_district==$value->id) selected @endif>{{ $value->name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="" class=" col-form-label col-form-label-sm">Thana</label>
                    <div id="per_thana">

                        @include('admin.patient.per_thana')

                    </div>
                </div>


                <div class="col-sm-3">
                    <label for="post_code" class=" pl-1 col-form-label col-form-label-sm">Country
                    </label>
                    <select class="form-control font_size_12 m-auto" id="parmanent_country" name="parmanent_country">
                        <option value="Bangladesh" {{ $permanent_country == 'Bangladesh' ? 'selected' : '' }}>
                            Bangladesh</option>
                        <option value="Others" {{ $permanent_country == 'Others' ? 'selected' : '' }}>Others
                        </option>
                    </select>
                </div>

            </div>
        </div>
        <hr>
        <div class="card-header">
            <h5>FAMILY INFORMATION</h5>
        </div>
        <div class="card-body pb-0">
            <div class="form-row">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_father" class="col-form-label s-12">FATHER</label>
                    <input type="text" class="form-control form-control-sm text-capitalize" id="patient_father"
                        name="pat_father" value="{{ $patient_father }}" placeholder="Enter Patient Father Name"
                        onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_mother" class="col-form-label s-12">MOTHER</label>
                    <input type="text" class="form-control form-control-sm text-capitalize" id="patient_mother"
                        name="pat_mother" value="{{ $patient_mother }}" placeholder="Enter Patient Mother Name"
                        onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                </div>
                <div class="form-group col-4 m-0 focused" id="spouse"
                    style="display: {{ $patient_marital_status == '20' ? '' : 'none' }};">
                    <label for="patient_spouse" class="col-form-label s-12">SPOUSE</label>
                    <input type="text" class="form-control form-control-sm text-capitalize" id="patient_spouse"
                        name="pat_spouse" value="{{ $patient_spouse }}" placeholder="Enter Patient Spouse Name"
                        onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                </div>
            </div>
        </div>
        <hr>
        <div class="card-header">
            <h5>EMERGENCY CONTACT</h5>
        </div>
        <div class="card-body pb-0">
            <div class="form-row">
                <div class="form-group col-4 m-0 focused">
                    <label for="emergency_contact_name" class="col-form-label s-12">NAME <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm text-capitalize"
                        id="emergency_contact_name" name="emergency_contact_name"
                        value="{{ $emergency_contact_name }}" placeholder="Enter Emergency Contact Name"
                        required="required" maxlength="50">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="emergency_contact_contact" class="col-form-label s-12">CONTACT NO <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="emergency_contact_contact"
                        name="emergency_contact_contact"
                        value="{{ $emergency_contact_contact ? $emergency_contact_contact : '+880' }}"
                        required="required" placeholder="Enter Emergency Contact Number" maxlength="14"
                        onkeypress="return /^[0-9+]+$/.test(event.key)">
                </div>

                <div class="form-group col-4 m-0 focused">
                    <label for="emergency_contact_relation" class="col-form-label s-12">RELATION</label>
                    <select class="form-control font_size_12 m-auto" id="emergency_contact_relation"
                        name="emergency_contact_relation">
                        <option value="">Select Relation</option>
                        @if (isset($relationAll))
                        @foreach ($relationAll as $key => $value)
                        <option value="{{ $key }}"
                            @if ($emergency_contact_relation==$key) selected @endif>{{ $value }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col m-0 focused">
                    <label for="emergency_contact_address" class="col-form-label s-12">ADDRESS</label>
                    <input type="text" class="form-control form-control-sm text-capitalize"
                        id="emergency_contact_address" name="emergency_contact_address"
                        value="{{ $emergency_contact_address }}" placeholder="Enter Emergency Contact Address"
                        maxlength="100">
                </div>
            </div>
        </div>
        <hr>
        <div class="card-header">
            <h5>OTHER INFORMATION</h5>
        </div>
        <div class="card-body pb-0">
            <div class="form-row">
                <div class="form-group col-6 m-0 focused">
                    <label for="is_health_insurance" class="col-form-label s-12">HEALTH INSURANCE</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="is_health_insurance"
                                id="is_health_insurance_yes" value="Yes"
                                {{ $is_health_insurance = 'Yes' ? 'checked' : '' }}>Yes
                        </label> &nbsp; &nbsp; &nbsp; &nbsp;
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input keep_me" name="is_health_insurance"
                                id="is_health_insurance_no" value="No"
                                {{ $is_health_insurance = 'No' ? 'checked' : '' }}>No
                        </label>
                    </div>
                </div>
                <div class="form-group col-6 m-0 focused">
                    <label for="insurance_company_name" class="col-form-label s-12">Name of Insurance Company</label>
                    <input type="text" class="form-control form-control-sm text-capitalize"
                        id="insurance_company_name" name="insurance_company_name"
                        value="{{ $insurance_company_name }}" placeholder="Enter Name of Insurance Company">
                </div>
                <div class="form-group col-4 m-0 focused mt-2">
                    <label for="local_guardian" class="col-form-label s-12">LOCAL GUARDIAN</label>
                    <input type="text" class="form-control form-control-sm text-capitalize" id="local_guardian"
                        name="local_guardian" value="{{ $local_guardian }}"
                        placeholder="Enter Name of Local Guardian">
                </div>
                <div class="form-group col-4 m-0 focused mt-2">
                    <label for="relationship_with_local_guardian" class="col-form-label s-12">RELATIONSHIP</label>
                    <input type="text" class="form-control form-control-sm text-capitalize"
                        id="relationship_with_local_guardian" name="relationship_with_local_guardian"
                        value="{{ $relationship_with_local_guardian }}" placeholder="Enter Relationship">
                </div>
                <div class="form-group col-4 m-0 focused mt-2">
                    <label for="local_guardian_mobile" class="col-form-label s-12">MOBILE NO</label>
                    <input type="text" class="form-control form-control-sm" id="local_guardian_mobile"
                        name="local_guardian_mobile"
                        value="{{ $local_guardian_mobile ? $local_guardian_mobile : '+880' }}"
                        placeholder="Enter Mobile No" maxlength="14" onkeypress="return /^[0-9+]+$/.test(event.key)">
                </div>
            </div>
        </div>
        <hr>

        <div class="card-header">
            <h5>If you are a foreigner, please furnish the following details:</h5>
        </div>
        <div class="card-body pb-0">
            <div class="form-row">
                <div class="form-group col-6 m-0 focused">
                    <label for="passport_no_foreign" class="col-form-label s-12">PASSPORT NO</label>
                    <input type="text" class="form-control form-control-sm number_only" id="passport_no_foreign"
                        name="passport_no_foreign" value="{{ $passport_no_foreign }}"
                        placeholder="Enter Passport No">
                </div>
                <div class="form-group col-6 m-0 focused">
                    <label for="visa_no_foreign" class="col-form-label s-12">VISA NO</label>
                    <input type="text" class="form-control form-control-sm number_only" id="visa_no_foreign"
                        name="visa_no_foreign" value="{{ $visa_no_foreign }}" placeholder="Enter Visa No">
                </div>

                <div class="form-group col-6 m-0 focused">
                    <label for="visa_validity" class="col-form-label s-12">VISA VALIDITY</label>
                    <input type="text" class="form-control form-control-sm date_picker_visa" id="visa_validity"
                        name="visa_validity" value="{{ $visa_validity }}" placeholder="Enter Visa Validity">
                </div>
                <div class="form-group col-6 m-0 focused">
                    <label for="visa_type" class="col-form-label s-12">VISA TYPE</label>
                    <input type="text" class="form-control form-control-sm text-capitalize" id="visa_type"
                        name="visa_type" value="{{ $visa_type }}" placeholder="Enter Visa Type">
                </div>
            </div>
        </div>
        <hr>

        <div class="card-body pb-0">
            <div class="form-group">
                <label for="patient_passport" class="col-form-label col-form-label-sm d-block">STATUS</label>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioStatus1" name="status"
                        class="custom-control-input keep_me" value="1" {{ $status == '1' ? 'checked' : '' }}
                        checked="checked">
                    <label class="custom-control-label" for="customRadioStatus1">Active</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioStatus2" name="status"
                        class="custom-control-input keep_me" value="0" {{ $status == '0' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customRadioStatus2">Inactive</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            @php
            $patient_id = '';
            $response_url = route('patient-card', $patient_id);
            @endphp

            <button type="button" class="btn btn-success btn-md" id="save_update" onclick="saveUpdate(this)"
                data-func="afterSaveModal" data-response-url="{{ $response_url }}"
                title="Click here to save Patient Information"> Save
            </button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                @if ($patient_no_pk == '')
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                @else
                <button type="button" class="close" onclick="closeChildModal()">&times;</button>
                @endif

                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>
                    <input type="radio" id="card" name="api" checked onchange="apiCall(this)"
                        value="02"> <label for="card">Membership ID Card</label>
                    <input type="radio" id="member" name="api" onchange="apiCall(this)" value="01">
                    <label for="member">Membership No</label>
                    <!-- <input type="radio" id="nid" name="api" onchange="apiCall(this)" value="03"> <label for="nid">NID</label> -->
                </p>
                <p id="input_data">
                    <input type="text" class="form-control" id="input_card" name="input_card" value=""
                        autocomplete="off" placeholder="Enter....">
                    <!-- <input type="text" class="form-control d-none" id="input_member" name="input_member" value="" placeholder="Enter Member Id">
                    <input type="text" class="form-control d-none" id="input_mid" name="input_mid" value="" placeholder="Enter NID"> -->
                </p>
            </div>
            <div class="modal-footer">
                @if ($patient_no_pk == '')
                <button type="button" class="btn btn-info" data-dismiss="modal" onclick="getData(this)">Get
                    Data</button>
                @else
                <button type="button" class="btn btn-info" onclick="getData(this)">Get Data</button>
                @endif

                @if ($patient_no_pk == '')
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                @else
                <button type="button" class="btn btn-danger" onclick="closeChildModal()">Close</button>
                @endif



            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    function closeChildModal() {
        $('#myModal').modal('hide'); // Close only the child modal
        $('#myModal').on('hidden.bs.modal', function() {
            if ($('.patient_entry').hasClass('show')) {
                $('body').addClass('modal-open');
            }
        });

    }
    openDoctorAutocomplete('#hospital_emp_name', 'hospital_emp_id_hidden', "employee_ind", 1, patInfo);
    openPatientAutocomplete('#check_patient_id');
    openPatientAutocompleteByPhoneNoV2('#mobile_no');
    openDoctorAutocomplete('#agent_id_input', 'agent_id_hdn','referal_ind','1');
    openDoctorAutocomplete('#staff_id_input', 'hdn_staff__id');
    // openDoctorAutocomplete('#ref_doc_input', 'ref_doc_hdn', 'Y');
    openDoctorAutocomplete('#ref_doc_input', 'ref_doc_hdn', 'doctor_ind', '1,2');

    function patInfo(item, obj) {
        var pat_type = $('#patient_type :selected').attr('data-type_code');
        // alert(pat_type);
        if (pat_type != "STAFF FAMILY MEMBER") {
            $('#patient_first_name').val(item.full_name);
        }

    }

    function apiCall(element) {
        // var get_id = $(element).attr('id');
        // $('#input_data').find('input').addClass('d-none');
        // $('#input_data').find('input').val('');
        // if (get_id == "card") {
        //     $('#input_card').removeClass('d-none');
        // } else if (get_id == "member") {
        //     $('#input_member').removeClass('d-none');
        // } else if (get_id == "nid") {
        //     $('#input_mid').removeClass('d-none');
        // }
    }

    function checkCardValueExists(cardValue = "", name_phone = "", callback = "") {
        if ($('#pat_id').val() == "") {
            $.ajax({
                url: "{{ route('check-membership-no') }}", // Replace with the URL of your server-side script
                type: 'POST',
                data: {
                    cardValue: cardValue,
                    name_phone: name_phone
                },
                success: function(response) {
                    callback(response);
                },
                error: function(error) {
                    callback(false);
                    console.log('Error checking card value:', error);
                }
            });
        } else {
            callback(true);
        }

    }

    function getData(element) {
        var input_value = $('#input_card').val();
        checkCardValueExists(input_value, "", function(exists) {
            console.log(exists);
            if (exists == false) {
                alert('This Member Already Registered');
                return false;
            }
            var checkedValues = $('input[name="api"]:checked').map(function() {
                return $(this).val();
            }).get();
            var requestData = {
                // ByUserId: '8334',
                // PersonId: '120761',
                // MobileNumber: '-',
                // UserName: 'info@divinemercyhospital.com',
                // SearchText: input_value, //'0004169502',
                // TypeCode: checkedValues[0], //'02',
                // RequestFrom: 'HIS'

                ByUserId: '8415',
                PersonId: '121529',
                MobileNumber: '-',
                UserName: 'info@divinemercyhospital.com',
                SearchText: input_value, //'0004169502',
                TypeCode: checkedValues[0], //'02',
                RequestFrom: 'HIS'
            };

            // var apiUrl = 'https://stagingapi.cccul.com/api/HIS_V1/GetMembershipInfo';

            // var token = 'mlEE6MXph7BdiL8+SD97ZkVDEOg77rfieJuSweC9c1dC5LQTHobDykMHDzIkPpdHuDaP7cPCD3GfCzlx/R9vSqiCyCiGsaiRaU58rR5Gm2dhlkZiKtRHW2iBsn1HiPxn12CNmXdoZKltTSpJ5y8l286YxH1NFGSzbp6oc/khYmFCNhEo8tOANl1Qac84naXvUMYOKj8gMW1aMKFtZTAUO6W2qVXnAsj2t5uhInL3HEJulLm2NbU6vV1gw7CwFGEkFe3gcCzwe6PFx2JLW/sZBVvS8NynaDICX5ppwX733ZOWk+cN9k2wYfHn6K/O91iW';

            // var apiUrl = 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            // var token ='kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';

            var apiUrl = 'https://hisapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            var token =
                'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

            $.ajax({
                url: apiUrl,
                type: 'POST',
                headers: {
                    'token': token,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(requestData),
                success: function(response) {
                    // Handle the response.
                    console.log(JSON.parse(response.Data));
                    if (JSON.parse(response.Data).length === 0) {
                        alert('No Data');
                        $('#patient_first_name').val('');
                        $('#pat_gender_2').prop('checked', false);
                        $('#pat_gender_1').prop('checked', false);
                        $('#pat_gender_3').prop('checked', false);
                        $('#patient_blood_group').val('');
                        $('#patient_nationality').val('');
                        $('#patient_religion').val('');
                        $('#patient_nid').val('');
                        $('#occupation').val('');
                        $('#mobile_no').val('');
                        $('#patient_email').val('');
                        $('#patient_father').val('');
                        $('#patient_mother').val('');
                        $('#present_address').val('');
                        $('#is_health_insurance_yes').prop('checked', false);
                        $('#is_health_insurance_no').prop('checked', false);
                        $(".datepicker").val('');
                        $('#pat_age_y').val('');
                        $('#pat_age_m').val('');
                        $('#pat_age_d').val('');
                        return false;
                    } else {
                        var show_data = JSON.parse(response.Data);
                        console.log(show_data[0]);
                        $('#patient_first_name').val(show_data[0].PersonName);

                        if (show_data[0].Gender.toUpperCase() == "MALE") {
                            $('#pat_gender_2').prop('checked', true);
                        } else if (show_data[0].Gender.toUpperCase() == "FEMALE") {
                            $('#pat_gender_1').prop('checked', true);
                        } else if (show_data[0].Gender.toUpperCase() == "OTHERS") {
                            $('#pat_gender_3').prop('checked', true);
                        }
                        var originalBloodGroup = show_data[0].BloodGroup;
                        var convertedBloodGroup = originalBloodGroup.replace(/[\s()]+/g, '');
                        if (convertedBloodGroup == 'Unknown') {
                            $('#patient_blood_group').val('');
                        } else {
                            $('#patient_blood_group option:contains(' + convertedBloodGroup + ')')
                                .prop('selected', true);
                        }
                        $('#patient_nationality option:contains(' + show_data[0].Nationality + ')')
                            .prop('selected', true);
                        $('#patient_religion option:contains(' + show_data[0].Religion + ')').prop(
                            'selected', true);
                        $('#patient_nid').val(show_data[0].NID)
                        $('#occupation').val(show_data[0].Occupation)
                        $('#mobile_no').val(show_data[0].PersonMobileNo)
                        $('#patient_email').val(show_data[0].email)
                        $('#patient_father').val(show_data[0].FatherName)
                        $('#patient_mother').val(show_data[0].MotherName)
                        $('#present_address').val(show_data[0].PresentAddress)
                        if (show_data[0].HealthInsuranceFlag) {
                            $('#is_health_insurance_yes').prop('checked', true)
                        } else {
                            $('#is_health_insurance_no').prop('checked', false)
                        }
                        var dateString = show_data[0].DateOfBirth;
                        var dateObject = new Date(dateString);
                        // Format the date as "YYYY-MM-DD"
                        // var initialDate = '10-03-1991';
                        $(".datepicker").datepicker("setDate", new Date(dateObject));
                        calculateAge($(".datepicker").val());
                        $('.emp_id').removeClass('d-none');
                        $('#emp_id').val(show_data[0].person_id);
                        $('#card_no').val($('#input_card').val());
                        $('#patient_type option[data-type_code="CCCUL MEMBER"]').prop('selected',
                            true);
                        $('#input_card').val('');
                    }
                },
                error: function(error) {
                    // Handle the error
                    console.log('Error:', error);
                }
            });
        })
    }
    $(document).ready(function() {

        $(".date_picker_visa").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            changeMonth: true,
            changeYear: true,
        });

        var currentDate = new Date();



        var route_name = "{{ Route::currentRouteName() }}";
        if (route_name == 'registration.edit' || route_name == 'patient-create') {
            $('.datepicker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                format: 'dd/mm/yyyy',
                autoclose: true,
                maxDate: new Date(),
            })
        } else {
            $('.datepicker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                format: 'dd/mm/yyyy',
                autoclose: true,
                maxDate: new Date(),
            }).datepicker('setDate', currentDate);
        }


        //Age Calculation

        //validate form
        $("#frm-pat-registration").validate({
            rules: {
                pat_dob: {
                    required: true,
                    dateDMY: true
                },
            },
            messages: {
                pat_dob: {
                    required: 'Birth Day Required'
                },
            }
        })

        $('#pat_age_m').focus(function() {
            $(this).select();
        });
        $('#pat_age_y').focus(function() {
            $(this).select();
        });
        $('#pat_age_d').focus(function() {
            $(this).select();
        });

    })


    function calculateAge(dateText) {



        if ($('#pat_age_y').is(':focus')) {
            return false;
        }
        if ($('#pat_age_m').is(':focus')) {
            return false;
        }
        if ($('#pat_age_d').is(':focus')) {
            return false;
        }

        var userinput = dateText;
        var date = dateText.split('/');
        var new_date = date[2] + '-' + date[1] + '-' + date[0]
        var dob = new Date(new_date);

        var dobYear = dob.getYear();
        var dobMonth = dob.getMonth();
        var dobDate = dob.getDate();

        var now = new Date();
        var currentYear = now.getYear();
        var currentMonth = now.getMonth();
        var currentDate = now.getDate();
        var age = {};
        var ageString = "";
        yearAge = currentYear - dobYear;
        if (currentMonth >= dobMonth)
            var monthAge = currentMonth - dobMonth;
        else {
            yearAge--;
            var monthAge = 12 + currentMonth - dobMonth;
        }

        if (currentDate >= dobDate)
            var dateAge = 1 + currentDate - dobDate;
        else {
            monthAge--;
            var dateAge = 31 + 1 + currentDate - dobDate;
            if (monthAge < 0) {
                monthAge = 11;
                yearAge--;
            }
        }
        age = {
            years: yearAge,
            months: monthAge,
            days: dateAge
        };


        if (age.years < 0) {
            alert('Future date is invalid')
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }
        if (age.months < 0) {
            alert('Future date is invalid')
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }
        if (age.days < 0) {
            alert('Future date is invalid')
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }

        //display the calculated age
        $('#pat_age_y').val(age.years);
        $('#pat_age_m').val(age.months);
        $('#pat_age_d').val(age.days);
    }

    function calBirthDate() {
        $(this).select();
        var year = $("#pat_age_y").val();
        var month = $("#pat_age_m").val();
        var day = $("#pat_age_d").val();
        calculateBirthDate(year, month, day);
    }

    function calculateBirthDate(years, months, days) {

        if (years.length > 3) {
            alert('Years must be within 3 digit')
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }
        if (months > 12) {
            alert('Maximum 12 months available');
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }
        if (days > 31) {
            alert('Maximum 31 days available')
            $("#pat_age_y").val(0);
            $("#pat_age_m").val(0);
            $("#pat_age_d").val(0);
            $('.datepicker').val('');
            return false;
        }


        if (years < 0) {
            alert('Negetive value is invalid')
            $("#pat_age_y").val(0);
            return false;
        }
        if (months < 0) {
            alert('Negetive value is invalid')
            $("#pat_age_m").val(0);
            return false;
        }
        if (days < 0) {
            alert('Negetive value is invalid')
            $("#pat_age_d").val(0);
            return false;
        }

        var currentDate = new Date();
        // Calculate the birth date
        var birthDate = new Date(
            currentDate.getFullYear() - years,
            currentDate.getMonth() - months,
            currentDate.getDate() - days + 1
        );
        var options = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };
        var formattedBirthday = birthDate.toLocaleDateString('en-GB', options);
        $('.datepicker').datepicker('setDate', formattedBirthday);
    }

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

    $(function() {
        $('#patient_marital_status').on('change', function() {
            if (this.value == 20) {
                $("#spouse").show();
            } else {
                $("#spouse").hide();
            }
        });

        $('.select2').select2();
        $(document).on("change", "#present_district", function(e) {
            var disct_value = $(this).val();
            $.ajax({
                url: "{{ route('pat_all_thana_pre') }}",
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
        });

        $(document).on("change", "#par_district ", function(e) {
            var disct_value = $(this).val();
            $.ajax({
                url: "{{ route('pat_all_thana_per') }}",
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
                    //$("#par_district").select2("readonly", true);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        $(document).on("click", "#same_pre_and_par", function() {
            var pre_addr = $('#present_address').val();
            var pre_distric = $('#present_district').val();
            var pre_thana = $('#doctor_present_thana').val();
            var pre_country = $('#present_country').val();

            if ($(this).is(':checked')) {
                $('#parmanent_address').val(pre_addr);
                $('#par_district').val(pre_distric).trigger('change');
                $('#parmanent_country').val(pre_country);
                $('#doctor_pe_thana').val(pre_thana).trigger('change');

                $('#parmanent_address').attr('readonly', true);
                $("#par_district").attr("readonly", true);
                $('#parmanent_country').attr("readonly", true);
                $('#doctor_pe_thana').attr("readonly", true);
                //$("#par_district").select2("readonly", true);
                //$('.select2 option:selected').attr('readonly','readonly');
            } else {
                $('#parmanent_address').attr('readonly', false);
                $('#par_district').attr('readonly', false);
                $('#doctor_pe_thana').attr('readonly', false);
                $('#parmanent_country').attr('readonly', false);
            }

        });

    });

    function saveUpdate(element) {
        event.preventDefault();
        var formData = new FormData($('#frm-pat-registration')[0]);
        var formAction = $(element).parents("form").attr("action");
        var formMethod = $(element).parents("form").attr("method");
        var formID = $(element).parents("form").attr("id");
        var page_type = "{{ $page_type }}";
        var customFunc = $("#save_update").attr("data-func");
        var pat_name = $('#patient_salutation').val() + '*' + $('#patient_first_name').val() + '*' + $(
            '#patient_last_name').val();
        var pat_phone_no = $('#mobile_no').val();
        var pat_data = pat_name + '_' + pat_phone_no;
        checkCardValueExists("", pat_data, function(exists) {
            console.log(exists);
            if (exists == false) {
                alert('This Patient Already Registered');
                return false;
            }

            if ($('#pat_age_y').val() != "" || $('#pat_age_m').val() != "" || $('#pat_age_d').val() != "") {
                if (formValidation(formID) == false) {
                    return;
                }

                if (confirm("Are you sure?")) {
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
                        success: (data) => {
                            var response_url = $("#save_update").attr("data-response-url") + "/" +
                                data
                                .insert_id;
                            dynamicFunc.afterSaveModal(response_url, "common-modal-sm",
                                "Patient Card");
                            $('#frm-pat-registration').find("input, textarea").not('.keep_me').val(
                                "");
                            $('#frm-pat-registration').find("select").not('.keep_me').val("0");
                        },
                        error: function(data) {},
                        complete: function() {
                            if (page_type == 'edit')
                                dynamicFunc.afterSaveLoadList(
                                    "{{ route('registration.loadList') }}");
                            $.unblockUI();
                        },
                        error: function(data) {
                            var errors = jQuery.parseJSON(data.responseText)
                                .errors;
                            error_messages = "";
                            for (messages in errors) {
                                var field_name = $("#" + messages).siblings(
                                        "label")
                                    .html();
                                error_messages +=
                                    "<div class='alert alert-danger' role='alert'>" +
                                    errors[messages] + "</div>";
                            }

                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html("Validation Error");
                            $('.common-modal-notify-error .modal-body').html(error_messages);
                            finished = false;
                            $.unblockUI();
                        }
                    });
                    // });

                }
            } else {
                alert('Enter Age');
                return;
            }
            e.stopImmediatePropagation();
        })
    }

    function convertTZ(date, tzString) {
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
            timeZone: tzString
        }));
    }

    function corporate(element) {
        var classNames = ['.emp_id', '.corporate_name', '.corporate_id', '.organization', '.designation',
            '.relation_data', '.hospital_emp_id'
        ];

        classNames.forEach(function(className) {
            $(className + ' input[type="text"]').val('');
            $(className + ' input[type="hidden"]').val('');
            $(className + ' select').prop('selectedIndex', 0);
            $(className + ' input[type="text"]').prop('required', false);
            $(className + ' select').prop('required', false);
        });

        var corp_val = $(element).find(":selected").attr('data-type_code'); //$(element).text();
        var pat_type = $("#patient_type option:selected").attr('data-type_code');

        var pat_type_arr = ['CCCUL MEMBER', 'CHURCH MEMBER', 'CCCUL FAMILY MEMBER', 'STAFF FAMILY MEMBER OTHERS',
            'STAFF OTHERS', 'STAFF FAMILY MEMBER', 'STAFF'
        ];

        if (jQuery.inArray(jQuery.trim(corp_val), pat_type_arr) !== -1) {

            $('.emp_id ,.organization').removeClass('d-none');
            $('#emp_id ,#organization').prop('required', true);
            $('.designation ,.corporate_name,.corporate_id,.relation_data,.hospital_emp_id').addClass('d-none');
            if (jQuery.inArray(jQuery.trim(corp_val), ['CCCUL FAMILY MEMBER', 'STAFF FAMILY MEMBER OTHERS',
                    'STAFF FAMILY MEMBER'
                ]) !== -1) {
                $('.relation_data').removeClass('d-none');
                $('#relation_data').prop('required', true);
            }
            if (jQuery.inArray(jQuery.trim(corp_val), ['STAFF', 'STAFF FAMILY MEMBER']) !== -1) {

                $('.designation ,.corporate_name,.corporate_id,.relation_data,.emp_id,.organization').addClass(
                    'd-none');
                $('.hospital_emp_id').removeClass('d-none');
                $('.hospital_emp_name').prop('required', true);
                $('#emp_id ,#organization').prop('required', false);
                if (jQuery.inArray(jQuery.trim(corp_val), ['STAFF FAMILY MEMBER']) !== -1) {
                    $('.relation_data').removeClass('d-none');
                    $('#relation_data').prop('required', true);
                }
            }
            console.log(corp_val, pat_type_arr)
        } else if (jQuery.inArray(jQuery.trim(corp_val), ['MISSIONARIES']) !== -1) {
            $('.designation ,.organization').removeClass('d-none');
            $('#designation ,#organization').prop('required', true);
            $('.emp_id ,.corporate_name,.corporate_id,.relation_data,.hospital_emp_id').addClass('d-none');
        } else {
            $('.emp_id ,.corporate_name,.corporate_id,.organization,.designation,.relation_data,.hospital_emp_id')
                .addClass('d-none');
        }

        if (corp_val.indexOf('CORPORATE') !== -1) {
            $('.corporate_name').removeClass('d-none');
            $('.corporate_id').removeClass('d-none');
            $('#corporate_name').attr('required', 'required');
            $('.organization,.designation,.relation_data,.hospital_emp_id').addClass('d-none');
            // $('.emp_id').removeClass('d-none');
        } else {
            $('.corporate_name').addClass('d-none');
            $('.corporate_id').addClass('d-none');
            $('#corporate_name').attr('required', '');
        }
    }

    $(document).on('change', '#patient_marital_status', function() {
        if (this.value == 20) {
            $("#spouse").show();
        } else {
            $("#spouse").hide();
        }
    });

    // agent hide show
    $("#inform").change(function() {
        var selectedVal = $(this).val().toUpperCase().trim();

        // Hide all containers first
        $('.agent_id_container, .staff_id_container, .campaign_container, .others_container, .referral_doctor_container, .social_media_container, .institute_container')
            .addClass('d-none')
            .removeClass('input-highlight');

        var containerToShow;

        if (selectedVal === 'MARKETING AGENT') {
            containerToShow = $('.agent_id_container');
        } else if (selectedVal === 'STAFF') {
            containerToShow = $('.staff_id_container');
        } else if (selectedVal === 'CAMPAIGN') {
            containerToShow = $('.campaign_container');
        } else if (selectedVal === 'OTHERS') {
            containerToShow = $('.others_container');
        } else if (selectedVal === 'REFERRAL DOCTOR') {
            containerToShow = $('.referral_doctor_container');
        } else if (selectedVal === 'SOCIAL MEDIA') {
            containerToShow = $('.social_media_container');
        } else if (selectedVal === 'INSTITUTE') {
            containerToShow = $('.institute_container');
        }

        if (containerToShow) {
            containerToShow.removeClass('d-none');
            containerToShow.addClass('input-highlight');
            var $selectContainer = $('#inform').closest('.col-md-4');
            containerToShow.insertBefore($selectContainer);
        }
    });



    $(document).ready(function() {
        $("select#inform").trigger('change');
    });
</script>