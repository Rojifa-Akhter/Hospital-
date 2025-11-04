@php
    $patient = isset($patient) && !empty($patient) ? $patient : [];
    $patient_no_pk = $patient ? $patient->patient_no_pk : '';
    $uhid = $patient ? $patient->patient_code : '';
    $emp_id = $patient ? $patient->emp_id : '';
    $patient_salutation = $patient ? $patient->salutation : '';
    $patient_first_name = $patient ? $patient->first_name : '';
    $patient_last_name = $patient ? $patient->last_name : '';
    $patient_age_d = $patient ? $patient->age_dd : '';
    $patient_age_m = $patient ? $patient->age_mm : '';
    $patient_age = $patient ? $patient->age_yy : '';
    $patient_dob = $patient && $patient->dob != '' ? date('d-m-Y', strtotime($patient->dob)) : '';
    $reg_date = $patient ? $patient->reg_date : '';
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
    $patient_father = $patient ? $patient->father_name : '';
    $patient_mother = $patient ? $patient->mother_name : '';
    $patient_spouse = $patient ? $patient->spouse_name : '';
    $patient_guardian = $patient ? $patient->guardian_name : '';
    $patient_email = $patient ? $patient->email : '';
    $patient_blood_group = $patient ? $patient->blood_group : '';
    $salutation = $patient ? $patient->salutation : '';
    $present_addres = $patient ? $patient->present_addr : '';
    $present_post_code = $patient ? $patient->present_post_code : '';
    $parmanent_address = $patient ? $patient->permanent_addr : '';
    $emergency_contact_address = $patient ? $patient->emergency_contact_addr : '';
    $patient_nationality = $patient ? $patient->nationality : '';
    $patient_passport = $patient ? $patient->passport_no : '';
    $patient_gender = $patient ? $patient->gender : '';
    $patient_marital_status = $patient ? $patient->marital_status : '';
    $patient_religion = $patient ? $patient->religion : '';
    $present_district = $patient ? $patient->present_district : '';
    $parmanent_district = $patient ? $patient->permanent_district : '';
    $present_thana = $patient ? $patient->pr_addr_thana : '';
    $doctor_permanent_thana = $patient ? $patient->pe_addr_thana : '';
    // $present_country = $patient ? $patient->pr_addr_thana : '';
    $permanent_country = $patient ? $patient->pe_addr_thana : '';
    $mobile2_alt = $patient ? $patient->mobile2 : '';
    $emergency_contact_name = $patient ? $patient->emergency_contact_name : '';
    $emergency_contact_relation = $patient ? $patient->emergency_contact_relation : '';
    $emergency_contact_contact = $patient ? $patient->emergency_contact_contact : '';
    $status = $patient ? $patient->status : '';
    $patient_type = $patient ? $patient->patient_type : '';
    $patient_occupation = $patient ? $patient->occupation : '';
    $vip_ind = $patient ? $patient->vip_ind : '';
    $is_masking = $patient ? $patient->is_masking : '';
    $handle_with_care = $patient ? $patient->handle_with_care : '';
    $fall_risk = $patient ? $patient->fall_risk : '';
    $vip_narration = $patient ? $patient->vip_narration : '';
    $last_edit_reason = $patient ? $patient->last_edit_reason : '';
    $reg_remarks = $patient ? $patient->reg_remarks : '';
    $corporate_id = '';
    $ccm_client_no_pk = $patient ? $patient->ccm_client_no_fk : '';
    // dd($patient);
    // dd($patient_gender, $patient_marital_status)
@endphp
<style>
    canvas {
        border: 1px solid #000;
    }
</style>
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
   
    <form action="{{ route('uhl.patient-registration-store') }}" id="hos-registration-form" method="POST"
        enctype="multipart/form-data">
        @csrf
        <section class="paitent__registration">
            <input type="hidden" name="hdn_patient_no_pk" id="hdn_patient_no_pk" value="{{ $patient_no_pk }}">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12 mb-1">
                                <h5 class="mt-2 mb-0">Patient Registration</h5>
                                <small>Patient / Registration Info</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="form-row align-items-center">
                                    {{-- <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="reg__type" class="col-sm-4 col-form-label">Reg. Type <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select onchange="showHide(this)" class="form-control form-control-sm"
                                                    id="reg_type" name="reg_type" required tabindex="1">

                                                    @if (!empty($pat_type))
                                                        @foreach ($pat_type as $pat)
                                                            <option value="{{ $pat->patient_type_no_pk }}"
                                                                data-attr="{{ strtoupper($pat->patient_type_code) }}">
                                                                {{ $pat->patient_type_desc }}</option>
                                                        @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="uhid_" class="col-sm-4 col-form-label">UHID</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="uhid_" name="uhid_" placeholder="" readonly
                                                    value="{{ $uhid }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- mother uhid(when baby select than show this input field)  -->
                                    <div class="col-lg-3 col-md-12 d-none" id="mother_uid">
                                        <div class="form-group form-row">
                                            <label for="mother_uhid" class="col-sm-5 col-form-label">Mother UHID</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="mother_uhid" name="mother_uhid" placeholder="" />
                                                <input type="hidden" class="form-control" id="hdn_patient_id"
                                                    name="hdn_patient_id" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 d-none" id="emp_uid">
                                        <div class="form-group form-row">
                                            <label for="emp_id" class="col-sm-5 col-form-label">EMP. ID</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="emp_id" name="emp_id" placeholder="" />

                                                <input type="hidden" class="form-control" id="hdn_doctor_id"
                                                    name="hdn_doctor_id" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 d-none" id="emp_rel">
                                        <div class="form-group form-row">
                                            <label for="realation_pat" class="col-sm-5 col-form-label">Relation</label>
                                            <div class="col-sm-7">
                                                <select class="form-control form-control-sm font_size_12"
                                                    id="realation_pat" name="realation_pat"
                                                    onchange="addRelation(this)">
                                                    <option value="">Select</option>
                                                    @if (isset($relation))
                                                        @foreach ($relation as $key => $value)
                                                            <option value="{{ $key }}"
                                                                @if ($emergency_contact_relation == $key) selected @endif>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- mother uhid  -->
                                </div>
                            </div>
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group form-row">
                                                            <label for="national_id"
                                                                class="col-sm-4 col-form-label">National
                                                                ID</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id="national_id" placeholder="" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-row">
                                                            <label for="patient_dob"
                                                                class="col-sm-4 col-form-label">DOB</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control date_picker"
                                                                    placeholder="dd-mm-yyyy" />
                                                            </div>
                                                            <div class="col-sm-3">

                                                                <button type="button"
                                                                    class="btn btn-secondary uhl_common_btn btn-md">Verify</button>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <div class="upload__img__box">
                                                               

                                                                <div class="avatar-upload">
                                                                    <div class="avatar-edit">
                                                                        <input type="file" id="imageUpload"
                                                                            name="pat_photo"
                                                                            accept=".png, .jpg, .jpeg"
                                                                            value="">
                                                                            <input type="hidden" name="old_patient_photo" value="{{ !empty($photo_name) ? $photo_name : '' }}">
                                                                        <label for="imageUpload"></label>
                                                                    </div>
                                                                    <div class="avatar-preview">
                                                                        @if (!empty($photo_name))
                                                                            @php
                                                                                // $imgUrl ='images/uploads/patient_images/thumb/'.$photo_name;
                                                                                // $backgorund="background-image: url('{{ $imgUrl }}')";
                                                                                $imgUrl = asset('images/uploads/patient_images/thumb/' . $photo_name);
                                                                                $background = "background-image: url('$imgUrl')";
                                                                                // dd($background);

                                                                            @endphp
                                                                            <div id="imagePreview" style="<?= $background ?>"></div>
                                                                            {{-- <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');"></div> --}}
                                                                            {{-- <div id="imagePreview" style="background-image: url('images/pt-patient.jpg');"></div> --}}
                                                                        @else
                                                                            <div id="imagePreview" style="background-image: url('images/pt-patient.jpg');"></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group col-md-12">
                                                            <div style="text-align: center;">
                                                                <div id="video"></div>
                                                            </div>
                                                            <button id="imageCapture">capture</button>
                                                            <div id="canvas" class="mt-3"></div>
                                                        </div> -->

                                                        <div class="form-group form-row">
                                                            <label for="reg__date"
                                                                class="col-sm-4 col-form-label">Reg.
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker keep_me"
                                                                    id="reg__date" placeholder="dd-mm-yyyy"
                                                                    value="{{ $reg_date ? date('d-m-Y', strtotime($reg_date)) : date('d-m-Y') }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mt-2 mb-0">Personal Information</h5>
                                                    </div>
                                                    @php
                                                        $info_disabled=$patient_no_pk !="" && Session::get('user.inv_hod_ind') !=1 ? 'readonly' :'';
                                                    @endphp
                                                    <div class="card-body">
                                                        <div class="form-group form-row">
                                                            <label for="full_name"
                                                                class="col-sm-4 col-form-label">Full
                                                                Name<span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="full_name" tabindex="2" name="full_name"
                                                                    placeholder="" required
                                                                    onkeyup="checkBlankSpace(this)"
                                                                    value="{{ $patient_first_name . $patient_last_name }}" <?= $info_disabled?> />
                                                            </div>
                                                        </div>
                                                        <!--
                                                        <div class="form-group form-row">
                                                            <label for="middle_name" class="col-sm-4 col-form-label">Middle Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="middle_name" placeholder="" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="dob_" class="col-sm-4 col-form-label">Last Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="last_name" placeholder="" />
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group form-row">
                                                            <label for="pati_age_y"
                                                                class="col-sm-4 col-form-label">AGE</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                                    @if($patient_no_pk =='')
                                                                    <div class="input-group-prepend w-100">
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_y" name="pat_age_y"
                                                                            value="{{ $patient_age }}"
                                                                            placeholder="YY" tabindex="3"
                                                                            required="" <?= $info_disabled?> />
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_m" name="pat_age_m"
                                                                            value="{{ $patient_age_m }}"
                                                                            placeholder="MM" <?= $info_disabled?> />
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_d" name="pat_age_d"
                                                                            value="{{ $patient_age_d }}"
                                                                            placeholder="DD" <?= $info_disabled?> />
                                                                    </div>
                                                                    @else
                                                                    <div class="input-group-prepend w-100">
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_y" name="pat_age_y"
                                                                            value="{{ $patient_age }}"
                                                                            placeholder="YY" tabindex="3"
                                                                            required="" <?= $info_disabled?> />
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_m" name="pat_age_m"
                                                                            value="{{ $patient_age_m }}"
                                                                            placeholder="MM" <?= $info_disabled?> />
                                                                        <input type="text"
                                                                            class="form-control number_only form-control-sm"
                                                                            id="pat_age_d" name="pat_age_d"
                                                                            value="{{ $patient_age_d }}"
                                                                            placeholder="DD" <?= $info_disabled?> />
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-row">
                                                            <label for="patient_dob"
                                                                class="col-sm-4 col-form-label">DOB<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control date_picker"
                                                                    id="patient_dob" name="patient_dob"
                                                                    placeholder="dd-mm-yyyy" tabindex="4"
                                                                    value="{{ $patient_dob }}" <?= $info_disabled?> />
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-row">
                                                            <label for="patient__gender"
                                                                class="col-sm-4 col-form-label">Sex<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" id="patient_gender"
                                                                    name="patient_gender" required tabindex="5">
                                                                    <option value="">Select</option>
                                                                    @if (isset($gender))
                                                                        @php $i=1; @endphp
                                                                        @foreach ($gender as $key => $value)
                                                                            <option
                                                                                value="{{ $key }}_{{ $value }}"
                                                                                @if ($key == $patient_gender) selected @endif>
                                                                                {{ $value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="in_national_id"
                                                                class="col-sm-4 col-form-label">NID</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control number_only"
                                                                    id="in_national_id" name="in_national_id"
                                                                    tabindex="6" placeholder="NID"
                                                                    onkeyup="checkBlankSpace(this)"
                                                                    value="{{ $patient_nid }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="marital_status"
                                                                class="col-sm-4 col-form-label">Marital Status<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" id="marital_status"
                                                                    name="marital_status" required tabindex="7"
                                                                    onchange="checkMartialStatus(this)">
                                                                    <option value="">Select</option>
                                                                    @if (isset($marital_status))
                                                                        @foreach ($marital_status as $key => $value)
                                                                            <option
                                                                                value="{{ $key }}_{{ $value }}"
                                                                                data-attr="{{ strtoupper($value) }}"
                                                                                @if ($patient_marital_status == $key) selected @endif>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="spouse_name"
                                                                class="col-sm-4 col-form-label">Spouse Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="spouse_name" name="in_spouse_name"
                                                                    placeholder="" tabindex="8"
                                                                    onkeyup="checkBlankSpace(this)"
                                                                    value="{{ $patient_spouse }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="mother_name"
                                                                class="col-sm-4 col-form-label">Mother Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="mother_name" name="in_mother_name"
                                                                    placeholder="" tabindex="10"
                                                                    onkeyup="checkBlankSpace(this)"
                                                                    value="{{ $patient_mother }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="father_name"
                                                                class="col-sm-4 col-form-label">Father Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="father_name" name="in_father_name"
                                                                    tabindex="11" placeholder=""
                                                                    onkeyup="checkBlankSpace(this)"
                                                                    value="{{ $patient_father }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="guardian__name"
                                                                class="col-sm-4 col-form-label">Guardian Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="guardian__name" name="in_guardian_name"
                                                                        placeholder="" tabindex="12"
                                                                        onkeyup="checkBlankSpace(this)"
                                                                        value="{{ $patient_guardian }}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="religion_"
                                                                class="col-sm-4 col-form-label">Religion <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select
                                                                    class="form-control form-control-sm font_size_12"
                                                                    id="religion_" name="religion" required
                                                                    tabindex="13">
                                                                    <option value="" slected>Select</option>
                                                                    @if (isset($religion))
                                                                        @foreach ($religion as $key => $value)
                                                                            <option value="{{ $key }}"
                                                                                @if ($patient_religion == $key) selected @endif>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="card">
                                            <div class="card-header uhl_nav_tab">
                                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="pills-personalInfo-tab"
                                                            data-toggle="pill" href="#pills-personalInfo"
                                                            role="tab" aria-controls="pills-personalInfo"
                                                            aria-selected="true">Address Info</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="pills-othersInfo-tab"
                                                            data-toggle="pill" href="#pills-othersInfo"
                                                            role="tab" aria-controls="pills-othersInfo"
                                                            aria-selected="false">Others Info</a>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-personalInfo"
                                                        role="tabpanel" aria-labelledby="pills-personalInfo-tab">
                                                        <div class="form-row">
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="card mt-0">
                                                                    <div class="card-header">
                                                                        <h5 class="mt-2 mb-0">Contact Details</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-group form-row">
                                                                            <label for="mobile_"
                                                                                class="col-sm-5 col-form-label">Mobile<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm number_only"
                                                                                    title="Mobile Number Must be 11 Digit"
                                                                                    id="mobile_" name="mobile"
                                                                                    placeholder="" minlength="11"
                                                                                    required tabindex="14"
                                                                                    onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $phone_no }}" />
                                                                            </div>
                                                                        </div>



                                                                      
                                                                        <div class="form-group form-row">
                                                                            <label for="present_country"
                                                                                class="col-sm-5 col-form-label">Country</label>
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm"
                                                                                    tabindex="17"
                                                                                    id="present_country"
                                                                                    name="in_pr_addr_country" onchange="setDisThana(this)">
                                                                                    @if (!empty($country))
                                                                                        @foreach ($country as $row)
                                                                                            <option
                                                                                                value="{{ $row->country_no_pk }}" @if(strtoupper(trim($row->country_name))=="BANGLADESH") selected  @endif>
                                                                                                {{ $row->country_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="distric_city"
                                                                                class="col-sm-5 col-form-label">District/City</label>
                                                                            <div class="col-sm-7">
                                                                                <select tabindex="16"
                                                                                    class="form-control form-control-sm font_size_12 select2"
                                                                                    id="distric_city"
                                                                                    name="in_present_district">
                                                                                    <option value="">Select
                                                                                        District</option>
                                                                                    @if (!empty($district))
                                                                                        @foreach ($district as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                @if ($row->id == $doctor_present_district) selected @endif>
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                            {{-- @if ($row->id == $doctor_present_district) selected @endif --}}
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-row">
                                                                            {{-- @dd($present_thana) --}}
                                                                            <label for="thana_ps"
                                                                                class="col-sm-5 col-form-label">Thana/P.S. <span
                                                                                class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12 select2"
                                                                                    tabindex="15" id="thana_present"
                                                                                    name="in_pr_addr_thana" required>
                                                                                    <option value="">Select Thana
                                                                                    </option>
                                                                                    @if (!empty($thanas))
                                                                                        @foreach ($thanas as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                @if ($present_thana == $row->id) selected @endif
                                                                                                data-district-id="{{ $row->district_id }}">
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row d-none">
                                                                            <label for="state_division"
                                                                                class="col-sm-5 col-form-label">State/Division<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <select tabindex="16"
                                                                                    class="form-control form-control-sm font_size_12"
                                                                                    id="state_division"
                                                                                    name="state_division">
                                                                                    <option value="">Select
                                                                                        Division</option>
                                                                                    @if (!empty($divisions))
                                                                                        @foreach ($divisions as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                {{ $row->id == 6 ? '' : '' }}>
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                      

                                                                        <div class="form-group form-row">
                                                                            <label for="address_"
                                                                                class="col-sm-5 col-form-label">Address<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <textarea class="form-control form-control-sm" id="address_" name="pat_address" placeholder="" row="3"
                                                                                    onkeyup="checkBlankSpace(this)" required tabindex="18" name="pat_address"
                                                                                    style="min-height: 100px !important;">{{ $present_addres }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row d-none">
                                                                            <label for="pin_code"
                                                                                class="col-sm-5 col-form-label">Post
                                                                                Code</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="pin_code"
                                                                                    name="in_present_post_code"
                                                                                    tabindex="19"
                                                                                    onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $present_post_code }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="alt_phn"
                                                                                class="col-sm-5 col-form-label">Alt.
                                                                                Phone</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm number_only"
                                                                                    id="alt_phn"
                                                                                    name="in_mobile2_alt"
                                                                                    tabindex="20"
                                                                                    onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $mobile2_alt }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="in_email"
                                                                                class="col-sm-5 col-form-label">Email</label>
                                                                            <div class="col-sm-7">
                                                                                <input type="email"
                                                                                    class="form-control form-control-sm"
                                                                                    id="in_email" name="in_email"
                                                                                    tabindex="21"
                                                                                    onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $patient_email }}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="card mt-0">
                                                                    <div class="card-header">
                                                                        {{-- <h5 class="mt-2 mb-0">Payar</h5> --}}
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-group form-row">
                                                                            <label for="identity_type"
                                                                                class="col-sm-4 col-form-label">Pt. Category<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">


                                                                                <select
                                                                                    class="form-control form-control-sm text-capitalize"
                                                                                    id="patient_type"
                                                                                    name="patient_type" value=""
                                                                                    tabindex="22"
                                                                                    onchange="corporate(this)" required>
                                                                                    <option value="">Select</option>
                                                                                    @if (!empty($patient_type_data))
                                                                                        @foreach ($patient_type_data as $data)
                                                                                            <option
                                                                                                data-type_code="{{ $data->patient_type_code }}"
                                                                                                value="{{ $data->patient_type_no_pk }}"
                                                                                                {{ $data->patient_type_no_pk == $patient_type ? 'selected' : '' }}>
                                                                                                {{ $data->patient_type_code }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>

                                                                                @php
                                                                                    $d_none =
                                                                                        isset($patient_type) &&
                                                                                        $patient_type == ''
                                                                                            ? 'd-none'
                                                                                            : '';
                                                                                @endphp
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="form-group form-row  corporate_name {{ $d_none }}">

                                                                            <label for="corporate_name"
                                                                                class="col-sm-4 col-form-label corporate_name {{ $d_none }}">Corporate<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <select
                                                                                    class="form-control font_size_12 m-auto "
                                                                                    id="corporate_name"
                                                                                    name="corporate_name">
                                                                                    <option value="">Select
                                                                                        Corporate</option>
                                                                                    @if (isset($corporate_info))
                                                                                        @foreach ($corporate_info as $value)
                                                                                            <option
                                                                                                value="{{ $value->ccm_client_no_pk }}"
                                                                                                {{ $value->ccm_client_no_pk == $ccm_client_no_pk ? 'selected' : '' }}>
                                                                                                {{ $value->ccm_client_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        {{-- </div> --}}
                                                                        {{-- </div> --}}

                                                                        {{-- <div class="form-group form-row">
                                                                        <label for="sponsor_"
                                                                            class="col-sm-3 col-form-label">Sponsor</label>
                                                                        <div class="col-sm-9">
                                                                            <select
                                                                                class="form-control font_size_12"
                                                                                id="sponsor_" name="sponsor_">
                                                                                <option value="" slected>
                                                                                    Select Sponsor
                                                                                </option>
                                                                                @if (!empty($sponser_data))
                                                                                    @foreach ($sponser_data as $data)
                                                                                        <option
                                                                                            value="{{ $data->ccm_client_no_pk }}">
                                                                                            {{ $data->ccm_client_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div> --}}

                                                                        <div class="form-group form-row">
                                                                            <label for="emp_"
                                                                                class="col-sm-4 col-form-label">Employee ID
                                                                            </label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <div
                                                                                        class="input-group-prepend w-100">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="emp_relation_id"                                                                                         
                                                                                            onkeypress="setEmpInfo(this)"
                                                                                            name="emp_relation_id" value="{{$emp_id}}"
                                                                                            placeholder="" />
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="emp_name"
                                                                                            name="emp_name"
                                                                                            tabindex="24"
                                                                                            onkeyup="checkBlankSpace(this)"
                                                                                            value=""
                                                                                            placeholder="" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="realtion_"
                                                                                class="col-sm-4 col-form-label">Relation</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="realtion_name" tabindex="25"
                                                                                    name="realtion_name"
                                                                                    value="" />

                                                                                <input type="hidden"
                                                                                    id="hdn_realtion_"
                                                                                    name="hdn_realtion_"
                                                                                    value="">
                                                                            </div>
                                                                        </div>

                                                                        {{-- <div class="form-group form-row">
                                                                        <label for="realtion_"
                                                                            class="col-sm-3 col-form-label">Card</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend w-100">
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="card_no" name=""
                                                                                        placeholder="" />
                                                                                    <input type="file"
                                                                                        class="form-control-file"
                                                                                        id="" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                    </div>
                                                                </div>

                                                                <div class="card mt-0">
                                                                    <div class="card-header">
                                                                        <h5 class="mt-2 mb-0">Emergency Contact</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-group form-row">
                                                                            <label for="emr_name"
                                                                                class="col-sm-4 col-form-label">Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="emr_name" name="emr_name"
                                                                                    tabindex="26"
                                                                                    placeholder=""onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $emergency_contact_name }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="realation_pat"
                                                                                class="col-sm-4 col-form-label">Relationship</label>
                                                                            <div class="col-sm-8">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12"
                                                                                    id="realation_pat" tabindex="27"
                                                                                    name="in_emergency_contact_relation">
                                                                                    <option value="">Select
                                                                                    </option>
                                                                                    @if (isset($relation))
                                                                                        @foreach ($relation as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                {{ $emergency_contact_relation == $key ? 'selected' : '' }}>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="emr_contact"
                                                                                class="col-sm-4 col-form-label">Contact
                                                                                No. <span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm number_only"
                                                                                    id="emr_contact"
                                                                                    title="Mobile Number Must be 11 Digit"
                                                                                    name="in_emergency_contact_contact"
                                                                                    placeholder="" tabindex="28"
                                                                                    required minlength="11"
                                                                                    onkeyup="checkBlankSpace(this)"
                                                                                    value="{{ $emergency_contact_contact }}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-othersInfo" role="tabpanel"
                                                        aria-labelledby="pills-othersInfo-tab">
                                                        <div class="form-row">

                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="card mt-0">
                                                                    <div class="card-header">
                                                                        <h5 class="mt-2 mb-0">Permanent Address Info
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        {{-- <div class="form-group form-row">
                                                                        <label for="provider"
                                                                            class="col-sm-3 col-form-label">Provider</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control font_size_12"
                                                                                id="provider" name="provider">
                                                                                <option value="" slected>Select</option>
                                                                                <option value=""></option>
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="leadr_source"
                                                                            class="col-sm-3 col-form-label">Lead Source</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control font_size_12"
                                                                                id="leadr_source" name="leadr_source">
                                                                                <option value="" slected>Select</option>
                                                                                <option value=""></option>
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="reffered__type"
                                                                            class="col-sm-3 col-form-label">Referred Type</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control font_size_12"
                                                                                id="reffered__type" name="reffered__type">
                                                                                <option value="" slected>Self</option>
                                                                                <option value=""></option>
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="referred__by"
                                                                            class="col-sm-3 col-form-label">Referred By</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control font_size_12"
                                                                                id="referred__by" name="referred__by">
                                                                                <option value="" slected>Select</option>
                                                                                <option value=""></option>
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="self_"
                                                                            class="col-sm-3 col-form-label">Self</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control font_size_12"
                                                                                id="self_" name="self_">
                                                                                <option value="" slected>Select</option>
                                                                                <option value=""></option>
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                    </div> --}}
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="exampleCheck1"
                                                                                onchange="sameAddress(this)">
                                                                            <label class="form-check-label"
                                                                                for="exampleCheck1">Same As</label>
                                                                        </div>

                                                                       

                                                                       

                                                                        <div class="form-group form-row d-none">
                                                                            <label for="per_state_division"
                                                                                class="col-sm-5 col-form-label">State/Division<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12"
                                                                                    tabindex="18"
                                                                                    id="per_state_division"
                                                                                    name="per_state_division">
                                                                                    <option value="">
                                                                                        State/Division</option>
                                                                                    @if (!empty($divisions))
                                                                                        @foreach ($divisions as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                {{ $row->id == 6 ? '' : '' }}>
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                        <div class="form-group form-row">
                                                                            <label for="per_country"
                                                                                class="col-sm-5 col-form-label">Country</label>
                                                                              
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm"
                                                                                    id="per_country"
                                                                                    name="in_pe_addr_country" onchange="setDisThana(this)">
                                                                                    @if (!empty($country))
                                                                                        @foreach ($country as $row)
                                                                                            <option
                                                                                                value="{{ $row->country_no_pk }}" @if(strtoupper(trim($row->country_name))=="BANGLADESH") selected  @endif >
                                                                                                {{ $row->country_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-row">
                                                                            <label for="per_distric_city"
                                                                                class="col-sm-5 col-form-label">District/City</label>
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12 select2"
                                                                                    id="per_distric_city"
                                                                                    tabindex="19"
                                                                                    name="in_permanent_district">
                                                                                    <option value="">
                                                                                        District/City</option>
                                                                                    @if (!empty($district))
                                                                                        @foreach ($district as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                @if ($parmanent_district == $row->id) selected @endif>
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-row">
                                                                            <label for="thana_ps"
                                                                                class="col-sm-5 col-form-label">Thana/P.S.</label>
                                                                            <div class="col-sm-7">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12 select2"
                                                                                    tabindex="14" id="thana_per"
                                                                                    name="in_per_addr_thana">
                                                                                    <option value="">Select Thana
                                                                                    </option>
                                                                                    @if (!empty($thanas))
                                                                                        @foreach ($thanas as $row)
                                                                                            <option
                                                                                                value="{{ $row->id }}"
                                                                                                @if ($doctor_permanent_thana == $row->id) selected @endif
                                                                                                data-district-id = "{{ $row->district_id }}">
                                                                                                {{ $row->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <label for="in_permanent_addr"
                                                                                class="col-sm-5 col-form-label">Address<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-7">
                                                                                <textarea class="form-control form-control-sm" id="in_permanent_addr" placeholder="" row="3" required
                                                                                    tabindex="16" onkeyup="checkBlankSpace(this)" name="in_permanent_addr" style="min-height: 100px !important;"
                                                                                    required>{{ $parmanent_address }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="card mt-0">
                                                                    <div class="card-header">
                                                                        <h5 class="mt-2 mb-0">Other</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-group form-row">
                                                                            <label for="blood_grup"
                                                                                class="col-sm-3 col-form-label">Blood
                                                                                group</label>
                                                                            <div class="col-sm-9">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12"
                                                                                    id="blood_grup"
                                                                                    name="blood_group">
                                                                                    <option value="" slected>
                                                                                        Select</option>
                                                                                    @if (isset($bloodg))
                                                                                        @foreach ($bloodg as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                @if ($patient_blood_group == $key) selected @endif>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group form-row">
                                                                            <label for="occupation_"
                                                                                class="col-sm-3 col-form-label">Occupation</label>
                                                                            <div class="col-sm-9">
                                                                                <select
                                                                                    class="form-control form-control-sm font_size_12"
                                                                                    id="occupation_"
                                                                                    name="in_occupation">
                                                                                    <option value="" slected>
                                                                                        Select</option>
                                                                                    @if (isset($occupation))
                                                                                        @foreach ($occupation as $key => $value)
                                                                                            <option
                                                                                                value="{{ $key }}"
                                                                                                @if ($patient_occupation == $key) selected @endif>
                                                                                                {{ $value }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>



                                                                        <div class="form-group form-row">
                                                                            <label for="narration_"
                                                                                class="col-sm-3 col-form-label col-form-label-sm">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        name="in_vip_ind"
                                                                                        value="1"
                                                                                        {{ $vip_ind != null ? 'checked' : '' }}
                                                                                        id="defaultCheck1" />
                                                                                    <label class="form-check-label"
                                                                                        for="defaultCheck1">
                                                                                        VIP
                                                                                    </label>
                                                                                    {{--  <label for="narration_"
                                                                                      class="col-form-label col-form-label-sm" style="margin-top:5px">
                                                                                      Narration</label> --}}
                                                                                </div>
                                                                            </label>

                                                                            <div class="col-sm-9">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="narration_"
                                                                                    name="in_vip_narration"
                                                                                    value="{{ $vip_narration }}"
                                                                                    placeholder="Narration"
                                                                                    onkeyup="checkBlankSpace(this)" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-row">
                                                                            <div class="col-sm-11">
                                                                                <div
                                                                                    class="form-check form-check-inline">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="inlineCheckbox2"
                                                                                        name="in_n_masking"
                                                                                        value="1"
                                                                                        <?php if ($is_masking == 1) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                                                                    <label class="form-check-label"
                                                                                        for="inlineCheckbox2">Name
                                                                                        Masking</label>
                                                                                </div>
                                                                                <div
                                                                                    class="form-check form-check-inline">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="inlineCheckbox3"
                                                                                        name="in_n_masking"
                                                                                        value="1"
                                                                                        <?php if ($handle_with_care == 1) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                                                                    <label class="form-check-label"
                                                                                        for="inlineCheckbox3">Handle
                                                                                        With Care</label>
                                                                                </div>
                                                                                <div
                                                                                    class="form-check form-check-inline">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="inlineCheckbox4"
                                                                                        name="in_h_with_care"
                                                                                        value="1"
                                                                                        <?php if ($fall_risk == 1) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                                                                    <label class="form-check-label"
                                                                                        for="inlineCheckbox4">Fall
                                                                                        Risk</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @if ($patient_no_pk != null)
                                                                            <div class="form-group form-row">
                                                                                <label for="edit_reason"
                                                                                    class="col-sm-3 col-form-label">Edit
                                                                                    Reason<span
                                                                                        class="text-danger">*</span></label>
                                                                                <div class="col-sm-9">
                                                                                    <textarea onkeyup="checkBlankSpace(this)" class="form-control font_size_12" id="edit_reason"
                                                                                        name="in_last_edit_reason" placeholder="" rows="3">{{ $last_edit_reason }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-md-12">
                                                                <div class="card mt-2">
                                                                    <div class="card-header">
                                                                        <h5 class="mt-2 mb-0">Patient Identity Details
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group form-row">
                                                                                    <label for="in_nationalilty"
                                                                                        class="col-sm-4 col-form-label">Nationality<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <div class="col-sm-8">
                                                                                        <select
                                                                                            class="form-control form-control-sm font_size_12"
                                                                                            id="in_nationalilty"
                                                                                            name="in_nationalilty"
                                                                                            required>
                                                                                            <option value="">
                                                                                                Select One</option>
                                                                                            @if (isset($nationality))
                                                                                                @foreach ($nationality as $key => $value)
                                                                                                    <option
                                                                                                        value="{{ $key }}"
                                                                                                        {{ $value == 'Bangladeshi' ? 'selected' : '' }}>
                                                                                                        {{ $value }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group form-row">
                                                                                    <label for="passport_id"
                                                                                        class="col-sm-4 col-form-label">Passport
                                                                                        No</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="passport_id"
                                                                                            name="passport_id"
                                                                                            onkeyup="checkBlankSpace(this)"
                                                                                            placeholder=""
                                                                                            value="{{ $patient_passport }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group form-row">
                                                                                    <label for="remarks_"
                                                                                        class="col-sm-2 col-form-label">Remarks</label>
                                                                                    <div class="col-sm-10">
                                                                                        <textarea onkeyup="checkBlankSpace(this)" class="form-control font_size_12" id="remarks_" name="in_reg_remarks"
                                                                                            placeholder="" rows="2">{{ $reg_remarks }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        {{-- <div class="form-group form-row">
                                                                          <label for="identity_type"
                                                                              class="col-sm-4 col-form-label">Identity Type</label>
                                                                          <div class="col-sm-8">
                                                                              <select class="form-control font_size_12"
                                                                                  id="identity_type" name="identity_type">
                                                                                  <option value="" slected>Select</option>
                                                                                  @if (isset($patidentity))
                                                                                      @foreach ($patidentity as $key => $value)
                                                                                          <option value="{{ $key }}"
                                                                                              @if ($patient_nationality == $key) selected @endif
                                                                                              {{ $value == 'Bangladeshi' ? 'selected' : '' }}>
                                                                                              {{ $value }}
                                                                                          </option>
                                                                                      @endforeach
                                                                                  @endif
                                                                              </select>
                                                                          </div>
                                                                      </div>

                                                                      <div class="form-group form-row">
                                                                          <label for="identity_"
                                                                              class="col-sm-4 col-form-label">Idenity</label>
                                                                          <div class="col-sm-8">
                                                                              <input type="text"
                                                                                  class="form-control form-control-sm"
                                                                                  id="identity_" name="identity_" placeholder="" />
                                                                          </div>
                                                                      </div> --}}




                                                                        {{-- <div class="form-group form-row">
                                                                          <label for="status_"
                                                                              class="col-sm-4 col-form-label">Status</label>
                                                                          <div class="col-sm-8">
                                                                              <select class="form-control font_size_12"
                                                                                  id="status_" name="status_">
                                                                                  <option value="" slected>Active</option>
                                                                                  <option value="">Disable</option>
                                                                                  <option value=""></option>
                                                                              </select>
                                                                          </div>
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
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    @php
                                        $patient_id = '';
                                        $response_url = route('patient-card', $patient_id);
                                    @endphp



                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            @if($patient_no_pk =='')
                                            <button type="button"
                                            class="btn btn-secondary uhl_save_btn" id="save_update"
                                            onclick="checkDuplicate(this)" tabindex="30" data-func="afterSaveModal"
                                            data-response-url="{{ $response_url }}">Save</button>
                                            @else
                                            <button type="button"
                                            class="btn btn-secondary uhl_save_btn" id="save_update"
                                            onclick="saveUpdate(this)" tabindex="30" data-func="afterSaveModal"
                                            data-response-url="{{ $response_url }}">Save</button>
                                           
                                            @endif
                                        </li>


                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">New</button></li>

                                        <!-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Update</button></li> -->
                                        <!-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print</button></li> -->
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Print Card</button></li>
                                        <!-- <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">PatientRegDetails</button></li> -->
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn"
                                                onclick="checkDuplicate(this)">Check Duplicate</button></li>
                                        <li class="list-inline-item">
                                            <!-- <button type="button" class="btn btn-primary">Notes <span
                                                    class="badge badge-light">4</span></button> -->
                                        </li>
                                        <!-- <li class="list-inline-item float-right border-right-0 cursor-pointer"
                                            title="Switch to List View" style="font-size: 1rem;">
                                            <a href="#" rel="tab"><i class="fa fa-list"></i></a>
                                        </li> -->

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </form>
    
    
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script type="text/javascript">
 
     
   
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
  $('#full_name').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    function setDisThana(element) {
        let type=$(element).attr('id');
        let selectedText = $.trim($(element).find("option:selected").text().toUpperCase());
       
        if (type=='present_country' && selectedText !="BANGLADESH") {
           
            $($('#distric_city')).find("option").each(function() {
             
                if ($.trim($(this).text()) === 'Other') {
                   
                    $(this).prop('selected', true);  // Select the 'other' option
                }
            });
            $($('#thana_present')).find("option").each(function() {
              
                if ($.trim($(this).text()) === 'Other') {
                   
                    $(this).prop('selected', true);  // Select the 'other' option
                }
            });
            $($('#distric_city')).trigger('change');
            $($('#thana_present')).trigger('change');
        }else if(type=='per_country' && selectedText !="BANGLADESH"){
            $($('#per_distric_city')).find("option").each(function() {
              
                if ($.trim($(this).text()) === 'Other') {
                   
                    $(this).prop('selected', true);  // Select the 'other' option
                }
            });
            $($('#thana_per')).find("option").each(function() {
               
                if ($.trim($(this).text()) === 'Other') {
                   
                    $(this).prop('selected', true);  // Select the 'other' option
                }
            });
            $($('#per_distric_city')).trigger('change');
            $($('#thana_per')).trigger('change');
        }else{
            console.log(type,selectedText)
            if (type=='per_country') {
                $('#thana_per').val('');
                $('#per_distric_city').val('');
                $($('#per_distric_city')).trigger('change');
                $($('#thana_per')).trigger('change');
            }else if(type=='present_country'){
                $('#distric_city').val('');
                $('#thana_present').val('');
                $($('#distric_city')).trigger('change');
                $($('#thana_present')).trigger('change');
            }
        }
       
    }
    function sameAddress(element) {
        var pre_addr = $('#address_').val();
        var pre_thana = $('#thana_present').find(":selected").val();

        var pre_district = $('#distric_city').find(":selected").val();
        var pre_division = $('#state_division').find(":selected").val();
        var pre_country = $('#present_country').find(":selected").val();
        if ($(element).is(':checked')) {
            $('#in_permanent_addr').val(pre_addr);
            $('#thana_per').val(pre_thana).change();
            $('#per_distric_city option[value="' + pre_district + '"]').attr('selected', 'selected');
            $('#per_state_division option[value="' + pre_division + '"]').attr('selected', 'selected');
            $('#per_country option[value="' + pre_country + '"]').attr('selected', 'selected');
        } else {
            $('#in_permanent_addr').val('');
            $('#thana_per').val('').change();
            $('#per_distric_city option[value=""]').attr('selected', 'selected');
            $('#per_state_division option[value=""]').attr('selected', 'selected');
            $('#per_country option[value=""]').attr('selected', 'selected');
        }
    }

    function setEmpInfo(element) {
        if (event.which === 13 && $('#patient_type option:selected').text().toUpperCase().trim()=="UNICO HOSPITAL-STAF") {
            event.preventDefault();
            let emp_id = $(element).val();
            if (emp_id=='') {
                alert('Enter Employee Id');
                return false;
            }
            $.ajax({
                url: "{{route('get-employee-info-from-registraion')}}",
                type: 'post', // or 'POST' depending on the request
                data: {
                    emp_id: emp_id,
                },
                success: function(response) {
                   console.log(response)
                   if (response[1] =='') {
                    
                  
                    if (response[0] && Object.keys(response[0]).length > 0) {
                        
                        let name=response[0].full_name !=null ? $('#full_name').val( response[0].full_name) :'';
                        let gender_txt=response[0].gender_txt !=null ? response[0].gender_txt :'';
                        let marital_status=response[0].marital_status !=null ? response[0].marital_status :'';
                        let pe_addr1=response[0].pe_addr1 !=null ? $('#address_').val(response[0].pe_addr1) :'';
                        let phone_mobile=response[0].phone_mobile !=null ? $('#mobile_').val( response[0].phone_mobile) :'';
                        let religion_name=response[0].religion_name !=null ? response[0].religion_name :'';
                        let dob=response[0].dob !=null ? response[0].dob :'';

                        let dob_data = new Date(dob);
                        let dob_day = dob_data.getDate();         
                        let dob_month = dob_data.getMonth() + 1; 
                        let dob_year = dob_data.getFullYear();

                        let set_dob=dob_day +'-'+ dob_month +'-'+ dob_year;
                        $('#patient_dob').val(set_dob);
                        $("#patient_dob").datepicker("setDate", set_dob);


                        $('#patient_gender option').each(function() {                                                  
                            if ($(this).text().toUpperCase().trim() === gender_txt.toUpperCase().trim()) {
                                $(this).prop('selected', true);
                            }
                        });

                        $('#religion_ option').each(function() {                                                  
                            if ($(this).text().toUpperCase().trim() === religion_name.toUpperCase().trim()) {
                                $(this).prop('selected', true);  
                            }
                        });

                        $('#marital_status option').each(function() {                                                  
                            if ($(this).text().toUpperCase().trim() === marital_status.toUpperCase().trim()) {
                                $(this).prop('selected', true);  
                            }
                        });

                    }else{
                                     
                    $('input[type="checkbox"], input[type="radio"]').prop('checked', false);
                    $('input[type="text"], select').val('');
                        alert('No Data Found')
                    }
                }else{
                    $('input[type="checkbox"], input[type="radio"]').prop('checked', false);
                    $('input[type="text"], select').val('');
                    alert(response[1]);
                }
                },               
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }else{
            // alert('Select Privilege Patient Category')
        }

    }

    window.onload = function() {
        document.getElementById('full_name').focus();
    };

    // function handleKeyDown(event) {
    //     if (event.key === 'Enter' || event.keyCode === 13) {
    //         event.preventDefault();
    //         var button = document.getElementById('save_update');
    //         if (button) {
    //             saveUpdate(button);
    //         }
    //     }
    // }
    // document.addEventListener('keydown', handleKeyDown);

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



    $(document).ready(function() {

        // Autocomplete Calling
        openPatientAutocomplete('#mother_uhid', 'patient_name', patientInfo);
        openDoctorAutocomplete('#emp_id', 'hdn_doctor_id', 'employee_ind', '1', doctorInfo);

        $("#reg_type").focus();
     
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        }).on("change", function() {
           
            $.ajax({
                url: "{{ route('registration.calculateagebydatev2') }}",
                method: "post",
                data: {
                    patient_dob: $('#patient_dob').val()
                },
                success: function(res) {
                    // alert(res.new_year + "," +res.new_month +",")
                    console.log(res.new_month,res.new_year,res.new_day,$('#pat_age_m').val());
                    $('#pat_age_m').val(res.new_month);
                    $('#pat_age_y').val(res.new_year)
                    $('#pat_age_d').val(res.new_day)
                }
            })
        });

        $('body').on('focusout', '#pat_age_y', function() {
           
            $.ajax({
                url: "{{ route('registration.calculateage-v2') }}",
                method: "post",
                beforeSend: function() {
                    blockUI();

                },
                data: {
                    age_year: $(this).val(),
                    age_month: $('#pat_age_m').val(),
                    age_day: $('#pat_age_d').val()
                },
                success: function(res) {
                   
                    $('#patient_dob').val(res.patient_age);
                    $("#patient_dob").datepicker("setDate", res.patient_age);
                    console.log(res.patient_age)

                },
                complete: function() {
                    $.unblockUI();
                }
            })
        })

        $('body').on('focusout', '#pat_age_m', function() {
            
            $.ajax({
                url: "{{ route('registration.calculateage-v2') }}",
                method: "post",
                beforeSend: function() {
                    blockUI();

                },
                data: {
                    age_year: $('#pat_age_y').val(),
                    age_month: $(this).val(),
                    age_day: $('#pat_age_d').val()
                },
                success: function(res) {
                  
                    $('#patient_dob').val(res.patient_age);
                    $("#patient_dob").datepicker("setDate", res.patient_age);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        })

        $('body').on('focusout', '#pat_age_d', function() {
         
            $.ajax({
                url: "{{ route('registration.calculateage-v2') }}",
                method: "post",
                beforeSend: function() {
                    blockUI();

                },
                data: {
                    age_year: $('#pat_age_y').val(),
                    age_month: $('#pat_age_m').val(),
                    age_day: $(this).val()
                },
                success: function(res) {
                    
                    $('#patient_dob').val(res.patient_age);
                    $("#patient_dob").datepicker("setDate", res.patient_age);
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        })

        // $(document).on("change", "#present_country", function(e) {
        //     var country_value = $(this).val();
        //     $.ajax({
        //         url: "{{ route('pat_all_division_pre') }}",
        //         type: 'GET',
        //         data: {
        //             country_value: country_value
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             $("#state_division").html(data);

        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

        // $(document).on("change", "#state_division", function(e) {
        //     var state_division = $(this).val();
        //     var delay = 500;
        //     $.ajax({
        //         url: "{{ route('pat_all_district_pre') }}",
        //         type: 'GET',
        //         data: {
        //             state_division: state_division
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             setTimeout(function() {
        //             $("#distric_city").html(data);
        //             }, delay);

        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });


        // $(document).on("change", "#distric_city", function(e) {

        //     var disct_value = $(this).val();
        //     var delay = 500;
        //     $.ajax({
        //         url: "{{ route('pat_all_thana_pre') }}",
        //         type: 'GET',
        //         data: {
        //             disct_value: disct_value
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             setTimeout(function() {
        //             $("#thana_ps").html(data);
        //             }, delay)

        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

        // $(document).on("change", "#par_district ", function(e) {
        //     var disct_value = $(this).val();
        //     $.ajax({
        //         url: "{{ route('pat_all_thana_per') }}",
        //         type: 'GET',
        //         data: {
        //             disct_value: disct_value
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             $("#per_thana").html(data);
        //             var pre_thana = $('#doctor_present_thana').val();
        //             if ($("#same_pre_and_par").is(':checked')) {
        //                 $('#doctor_pe_thana').val(pre_thana);
        //             }
        //             $('.select2').select2();
        //             //$("#par_district").select2("readonly", true);
        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

        $(document).ready(function() {
            $('.select2').select2();
        });

        $(document).on("change", "#thana_present", function(e) {

            var selectedOption = $(this).find('option:selected');
            var disct_value = selectedOption.val();
            var dist_id = selectedOption.data('district-id');
            $('#distric_city').val(dist_id).change();

        });


        $(document).on("change", "#thana_per", function(e) {
            var selectedOption = $(this).find('option:selected');
            var disct_value = selectedOption.val();
            var dist_id = selectedOption.data('district-id');
            $('#per_distric_city').val(dist_id).change();

        });



        // $(document).on("change", "#per_country", function(e) {
        //     var country_value = $(this).val();
        //     $.ajax({
        //         url: "{{ route('pat_all_division_pre') }}",
        //         type: 'GET',
        //         data: {
        //             country_value: country_value
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             $("#per_state_division").html(data);

        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

        // $(document).on("change", "#per_state_division", function(e) {
        //     var state_division = $(this).val();
        //     $.ajax({
        //         url: "{{ route('pat_all_district_pre') }}",
        //         type: 'GET',
        //         data: {
        //             state_division: state_division
        //         },
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             $("#per_distric_city").html(data);

        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

    })

  
   

    function saveUpdate(element) {
        //alert(1);
        event.preventDefault();
        var formData = new FormData($('#hos-registration-form')[0]);
        var formAction = $(element).parents("form").attr("action");
        var formMethod = $(element).parents("form").attr("method");
        var formID = $(element).parents("form").attr("id");
        var page_type = "{{ $page_type }}";
        var customFunc = $("#save_update").attr("data-func");
        if ($('#thana_present').val()=="") {
            alert('Select Thana/P.S');
            return false;
        }

        if ($('#mobile_').val().length < 11) {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html(
                "Validation Error");
            $('.common-modal-notify-error .modal-body').html(
                "Mobile Number Must be 11 digits");
        }
        if ($('#emr_contact').val().length < 11) {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html(
                "Validation Error");
            $('.common-modal-notify-error .modal-body').html(
                "Contact Number Must be 11 digits");


        }


        if (formValidation(formID) == false) {
            return;
        }
        if (confirm("Are you sure?")) {
            // $('#frm-pat-registration').unbind().submit(function(e) {
            // var formAction = $('#frm-pat-registration').attr("action");
            // var formMethod = $('#frm-pat-registration').attr("method");

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
                    var response_url = $("#save_update").attr(
                        "data-response-url") + "/" + data.insert_id;
                    dynamicFunc.afterSaveModal(response_url,
                        "common-modal-sm", "Patient Card");

                    $('#hos-registration-form').find("input, textarea").not('.keep_me').val(
                        "");
                    $('#hos-registration-form').find("select").not('.keep_me').val("");

                    $("#imagePreview").attr('style', "background-image: url('../images/patient.jpg')");
                },
                error: function(data) {

                },
                complete: function() {

                    if (page_type == 'edit')
                        dynamicFunc.afterSaveLoadList(
                            "{{ route('registration.loadList') }}");
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText)
                        .errors;
                    error_messages = "Failed to Insert Data";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings(
                                "label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(
                        "Validation Error");
                    $('.common-modal-notify-error .modal-body').html(
                        error_messages);
                    finished = false;
                    $.unblockUI();
                }
            });
            // });
            $("#reg_type").focus();

        }
        $("#reg_type").focus();
        event.stopImmediatePropagation();
    }

    function showHide(element) {

        var attr_value = $(':selected', element).attr("data-attr");
        if (attr_value == 'BABY') {
            $("#mother_uid").removeClass('d-none');
            $("#emp_uid").addClass('d-none');
            $("#emp_rel").addClass('d-none');
            $('#full_name').attr('readonly', true);
            $('#in_national_id').attr('required', false);
        } else if (attr_value == 'STAFF') {
            $("#emp_uid").removeClass('d-none');
            $("#emp_rel").addClass('d-none');
            $("#mother_uid").addClass('d-none');
            $('#full_name').attr('readonly', false);
            $('#in_national_id').attr('required', true);
        } else if (attr_value == 'STAFFDEPENDENT') {
            $("#emp_uid").removeClass('d-none');
            $("#emp_rel").removeClass('d-none');
            $("#mother_uid").addClass('d-none');
            $('#full_name').attr('readonly', false);
            $('#in_national_id').attr('required', true);
        } else {
            $("#mother_uid").addClass('d-none');
            $("#emp_uid").addClass('d-none');
            $("#emp_rel").addClass('d-none');
            $('#full_name').attr('readonly', false);
            $('#in_national_id').attr('required', true);
        }
        // console.log(attr_value);

    }

    function checkMartialStatus(element) {

        var attr_value = $(':selected', element).attr("data-attr");
        if (attr_value == 'SINGLE') {
            $("#spouse_name").val('');
            $("#spouse_name").attr('readonly', true);
        } else {
            $("#spouse_name").attr('readonly', false);
        }
        // console.log(attr_value);

    }



    function getCompanyInfo(element) {
        $.ajax({
            url: "{{ route('get_corporate_list') }}",
            type: 'GET',
            data: {
                type: $(element).val(),
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#payer_details").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function patientInfo(item, obj) {
        console.log(item.religion);
        if (item.gender != null) {
            if (item.gender.toUpperCase() == "FEMALE") {
                $("#mother_name").val(item.patient_name);
                $("#full_name").val("Baby of Ms " + item.patient_name);
                $("#mobile_").val(item.phone_mobile);
                $("#father_name").val(item.spouse_name);
                $("#religion_").val(item.religion);
                $("#distric_city").val(item.present_district);
                $("#thana_present").val(item.pe_addr_thana);
                $("#per_distric_city").val(item.permanent_district);
                $("#in_email").val(item.email);
                $("#alt_phn").val(item.alt_phone_mobile);
                $("#emr_contact").val(item.alt_phone_mobile);
                $("#address_").val(item.alt_phone_mobile);
                $("#alt_phn").val(item.alt_phone_mobile);
            } else {
                $("#hdn_patient_id").val(0);
                $("#mother_uhid").val('');
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Error");
                $('.common-modal-notify-error .modal-body').html("Please select right person");
            }
        } else {
            $("#mother_uhid").val('');
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Error");
            $('.common-modal-notify-error .modal-body').html("Please select right person");
        }


    }

    function doctorInfo(item, obj) {
        console.log(item);
        var attr_value = $(':selected', $('#reg_type')).attr("data-attr");
        if (attr_value == 'STAFF') {
            $("#full_name").val(item.full_name);
            $("#mobile_").val(item.phone_mobile);
            $("#pat_age_y").val(item.age);
            $("#patient_gender").val(item.gender + '_' + item.gender_txt);
            $("#marital_status").val(item.marital_status_id + '_' + item.marital_status);
        } else if (attr_value == 'STAFFDEPENDENT') {
            $("#emp_relation_id").val(item.doctor_id);
            $("#emp_name").val(item.full_name);

        }

    }

    function addRelation(params) {
        var ralatin_id = $(params).find(':selected').val();
        var ralatin_name = String($(params).find(':selected').text());

        $("#hdn_realtion_").val(ralatin_id);
        $("#realtion_name").val(ralatin_name.trim());
    }

    // $(function() {
    //     setTimeout(() => {
    //     $('#user_id').focus();


    //     Webcam.set({
    //         width: 200,
    //         height: 200,
    //         image_format: 'jpeg',
    //         jpeg_quality: 90,
    //         force_flash: false
    //     });
    //     Webcam.attach('#video');
    //     Webcam.on('live', function() {
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //     });
    //     navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator
    //         .mozGetUserMedia || navigator.msGetUserMedia);

    //     navigator.mediaDevices.getUserMedia({video: true}) .then((stream)=> {
    //             video.srcObject = stream;
    //                 $(document).on("click", "#imageCapture", function(e) {                       
    //                         e.preventDefault();
    //                         Webcam.snap(function(data_uri) {
    //                             document.getElementById('canvas').innerHTML =
    //                                 '<img id="imageprev" width="150" src="' + data_uri + '"/>';                            
    //                             var base64image = document.getElementById("imageprev").src;

    //                             //'<img id="imageprev" id="imageprev" width="150" src="' + data_uri + '"/>';
    //                             // var route_name = '{{ route('attendance_image_save') }}';

    //                             // var service_number = $("#user_id").val();
    //                             // var base64image = document.getElementById("imageprev").src;
    //                             // var route_name = "{{ route('attendance_image_save') }}/" +
    //                             //     service_number;

    //                             // Webcam.upload(base64image, route_name, function(code, text) {
    //                             //     if (text != "") {
    //                             //         console.log(text);
    //                             //         var obj = JSON.parse(text);

    //                             //         if (obj.full_name != "") {
    //                             //             $("#emp_name").val(obj.full_name);
    //                             //             $("#emp_designation").val(obj
    //                             //                 .designation_name);
    //                             //             $("#emp_department").val(obj
    //                             //                 .serviceunit_name);


    //                             //             var photo_route ="../public/images/uploads/doctor_images/" + obj.photo_name;

    //                             //             $("#emp_photo").attr("src", photo_route);
    //                             //             $("#user_id").val('');
    //                             //         }
    //                             //     }
    //                             //     $.unblockUI();
    //                             // });

    //                         });                     

    //                     e.stopImmediatePropagation();
    //             });
    //         });      

    //     }, 2000);

    // });


    function checkDuplicate(element) {  
        event.preventDefault();
        var nid_no = $('#in_national_id').val();
        var name = $('#full_name').val();
        var age = $('#patient_dob').val();
        var mobile_no = $('#mobile_').val();

        if (name === "" || age === "" || mobile_no === "") {
            alert("Enter value  Name or DOB or Mobile No");
            return false;
        }


        $.ajax({
            url: "{{ route('v1.check-patReg-duplicate-info') }}",
            type: 'post',
            data: {
                nid_no: nid_no,
                name: name,
                age: age,
                mobile_no: mobile_no,
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data)
              
                if (data[1]==1) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html();
                    $('.common-modal-notify .modal-body').html(data[0].data);
                    $('.common-modal-notify').on('hidden.bs.modal', function () {
                    saveUpdate($('#save_update'));  // Trigger saveUpdate after modal is hidden
                    });
                }else{
                    saveUpdate($('#save_update'));
                }

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
    $(document).ready(function() {  
        $(".date_picker").each(function() {
            if ($(this).prop("readonly")) {
              
                $(this).datepicker("destroy");  // Remove date picker functionality
            }
        });
    });
</script>
