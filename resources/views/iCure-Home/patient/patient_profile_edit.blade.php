@extends('iCure-Home.patient.partials.patient_master')

@section('patient_content')

    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Hi! Welcome Back</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Patient Profiles</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
        </div>
    </div>
    <!--End Page header-->

    <div class="row">
        <div class="col-md-12">

            {{-- Added By Nazmul --}}
            @php

                $patient = isset($data) && !empty($data) ? $data : [];

                $patient_no_pk = $patient ? $patient->patient_no_pk : '';
                $patient_salutation = $patient ? $patient->salutation : '';
                $patient_first_name = $patient ? $patient->first_name : '';
                $patient_last_name = $patient ? $patient->last_name : '';
                $patient_age_d = $patient ? $patient->age_dd : '';
                $patient_age_m = $patient ? $patient->age_mm : '';
                $patient_age = $patient ? $patient->age_yy : '';
                $patient_dob = $patient && $patient->dob != '' ? date('d-m-Y', strtotime($patient->dob)) : '';
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
                $id = Auth::id();

            @endphp
            <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
            <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
            <style>
                .select2-container {
                    width: 100% !important;
                }

                .form-control-sm {
                    height: 2.375rem;
                }

                .form-control::placeholder {
                    color: #a3a3a3
                }

                .form-control {
                    color: #000000;
                    opacity: 1;
                }

                select.form-control-sm:not([size]):not([multiple]) {
                    height: calc(1.8125rem + 9px);
                }

            </style>
            {{-- $patient _name = {{ !empty(Auth::user()->user_name) ? ucfirst(Auth::user()->user_name) : '' }}; --}}
            <form method="post" id="frm-pat-registration" action="{{ route('patient-online-profile.store') }}"
                enctype="multipart/form-data" action="javascript:void(0)">
                @csrf
                <input type="hidden" name="id" value="{{ $patient_no_pk }}">

                <div class="card no-b no-r shadow-sm">
                    <div class="card-header shadow-sm">
                        <h5 class="card-title">BASIC INFORMATION</h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-row align-items-center">
                            <div class="col-md-9">
                                <div class="form-group m-0 focused">
                                    <label for="name" class="col-form-label s-12"><b>PATIENT NAME</b> <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="form-control font_size_12 m-auto " id="patient_salutation"
                                                name="pat_salutation">
                                                <option value="">Select</option>
                                                @if (isset($name_prefix))
                                                    @foreach ($name_prefix as $key => $value)
                                                        <option value="{{ $value }}" @if ($salutation == $value) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <input type="text" class="form-control form-control-sm required text-capitalize"
                                            id="patient_first_name" name="pat_f_name" value=" @if (!$patient_first_name == '') {{ $patient_first_name }} @else  {{ ucfirst(Auth::user()->user_name) }} @endif  "
                                            placeholder="First Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"
                                            required maxlength="50">

                                        <input type="text" class="form-control form-control-sm  text-capitalize"
                                            id="patient_last_name" name="pat_l_name" value="{{ $patient_last_name }}"
                                            placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"
                                            maxlength="50">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-4 m-0 focused">
                                        <label for="pat_age_y" class="col-form-label s-12"><b>AGE</b> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend w-100">
                                                <input type="number" class="form-control form-control-sm required"
                                                    id="pat_age_y" name="pat_age_y" onkeyup="get_dob_by_age()"
                                                    value="{{ $patient_age }}" placeholder="YY" required>
                                                <input type="number" class="form-control form-control-sm" id="pat_age_m"
                                                    name="pat_age_m" onkeyup="get_dob_by_age()"
                                                    value="{{ $patient_age_m }}" placeholder="MM" min="1" max="12">
                                                <input type="number" class="form-control form-control-sm" id="pat_age_d"
                                                    name="pat_age_d" onkeyup="get_dob_by_age()"
                                                    value="{{ $patient_age_d }}" placeholder="DD" min="1" max="31">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-4 m-0 focused">
                                        <label for="patient_dob" class="col-form-label s-12"><b> DATE OF BIRTH</b></label>
                                        <input type="text"
                                            class="form-control form-control-sm date_picker pat_info pat_dateofbirth"
                                            id="patient_dob" name="pat_dob" value="" autocomplete="off"
                                            placeholder="dd-mm-yyyy" onchange="dob(event ,this)" onkeyup="dob(event,this)">
                                    </div>


                                    <div class="form-group col-4 m-0">

                                        <label for="pat_gender_1" class="col-form-label s-12"><b>GENDER</b> <span
                                                class="text-danger">*</span></label>
                                        <br>

                                        @if (isset($gender))
                                            @php $i=1; @endphp
                                            @foreach ($gender as $key => $value)

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="pat_gender_{{ $i }}"
                                                        name="pat_gender" class="custom-control-input keep_me"
                                                        value="{{ $key }}"
                                                        {{ $key == $patient_gender ? 'checked' : '' }}>
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
                                                $imgUrl = '../public/images/uploads/patient_images/thumb/' . $photo_name;
                                            @endphp
                                            <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');">
                                            </div>
                                        @else
                                            <div id="imagePreview"
                                                style="background-image: url('../public/images/pt-patient.jpg');"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-row mt-1">
                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_blood_group" class="col-form-label s-12"><b>BLOOD GROUP</b></label>
                                <select class="form-control font_size_12 m-auto" id="patient_blood_group"
                                    name="pat_blood_group">
                                    <option value="0">Select Blood Group</option>
                                    @if (isset($bloodg))
                                        @foreach ($bloodg as $key => $value)
                                            <option value="{{ $key }}" @if ($patient_blood_group == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_marital_status" class="col-form-label s-12"><b>MARITAL
                                        STATUS</b></label>
                                <select class="form-control font_size_12 m-auto patient_marital_status"
                                    id="patient_marital_status" name="pat_marital_status">
                                    <option value="0">Select Marital Status</option>
                                    @if (isset($marital_status))
                                        @foreach ($marital_status as $key => $value)
                                            <option value="{{ $key }}" @if ($patient_marital_status == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="form-group col-4 m-0">
                                <label for="patient_religion" class="col-form-label s-12"><b>RELIGION</b></label>
                                <select class="form-control font_size_12 m-auto" id="patient_religion" name="pat_religion">
                                    <option value="">Select Religion</option>
                                    @if (isset($religion))
                                        @foreach ($religion as $key => $value)
                                            <option value="{{ $key }}" @if ($patient_religion == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="form-row mt-1">
                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_nationality" class="col-form-label s-12"><b>NATIONALITY</b></label>
                                <select class="form-control form-control-sm text-capitalize" id="patient_nationality"
                                    name="pat_nationality" value="">
                                    <option value="Bangladeshi">Select Country</option>
                                    @if (isset($nationality))
                                        @foreach ($nationality as $key => $value)
                                            <option value="{{ $key }}" @if ($patient_nationality == $key) selected @endif
                                                {{ $value == 'Bangladeshi' ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>

                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_nid" class="col-form-label s-12"><b>NID</b></label>
                                <input type="text" class="form-control form-control-sm" id="patient_nid" name="pat_nid"
                                    value="{{ $patient_nid }}" placeholder="Enter Patient NID"
                                    onkeypress="return /^[0-9]+$/.test(event.key)" maxlength="17">
                            </div>
                            <div class="form-group col-4 m-0">
                                <label for="patient_passport" class="col-form-label s-12"><b>PASSPORT NO</b></label>
                                <input type="text" class="form-control form-control-sm" id="patient_passport"
                                    name="pat_passport" value="{{ $patient_passport }}"
                                    placeholder="Enter Patient Passport No" maxlength="50">
                            </div>
                        </div>
                    </div>
                    {{-- <hr style="margin: 0;"> --}}

                    <div class="card-header shadow-sm">
                        <h5 class="card-title">CONTACT INFORMATION</h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-row">
                            <div class="form-group col-4 m-0 focused">
                                <label for="mobile_no" class="col-form-label s-12"><b>MOBILE NO</b> <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm required digits number_only"
                                    id="mobile_no" name="mobile_no" value="{{ $phone_no }}"
                                    placeholder="Enter Patient Phone number" onkeypress="return /^[0-9]+$/.test(event.key)"
                                    required="required" maxlength="14">
                            </div>
                            <div class="form-group col-4 m-0 focused">
                                <label for="phone_no" class="col-form-label s-12"><b>PHONE NO</b></label>
                                <input type="text" class="form-control form-control-sm digits " id="phone_no"
                                    name="phone_no" value="{{ $phone_no }}" placeholder="Enter Patient Phone Number"
                                    onkeypress="return /^[0-9]+$/.test(event.key)" maxlength="14">
                            </div>
                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_email" class="col-form-label s-12"><b>EMAIL</b></label>
                                <input type="email" class="form-control form-control-sm email" id="patient_email"
                                    name="pat_email" value="{{ $patient_email }}" placeholder="abc@gmail.com"
                                    pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*"
                                    maxlength="50">
                            </div>
                        </div>
                    </div>

                    <div class="card-header shadow-sm">
                        <h5 class="card-title">ADDRESS INFORMATION</h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-row">
                            <div class="col-sm-3">
                                <label for="present_address" class="col-form-label col-form-label-sm"><b>Present</b> <span
                                        class="text-danger">*</span></label>
                                <input type="text" class=" form-control form-control-sm same_as_pre_add required"
                                    id="present_address" name="present_address" value="{{ $present_addr }}"
                                    placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213" required maxlength="200">
                            </div>

                            <div class="col-sm-3">
                                <label for="doctor_present_district"
                                    class=" col-form-label col-form-label-sm"><b>District</b></label>
                                <select class="form-control font_size_12 m-auto select2  " id="present_district"
                                    name="present_district">
                                    <option value="">Select District</option>
                                    @if (isset($district))
                                        @foreach ($district as $value)
                                            <option value="{{ $value->id }}" @if ($present_district == $value->id) selected @endif>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class=" col-form-label col-form-label-sm"><b>Thana</b></label>
                                <div id="present_thana">
                                    @include('admin.patient.pre_thana')
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="post_code" class=" pl-1 col-form-label col-form-label-sm"><b>Country</b>
                                </label>
                                <select class="form-control font_size_12 m-auto" id="present_country"
                                    name="present_country">
                                    <option value="Bangladesh" {{ $present_country == 'Bangladesh' ? 'selected' : '' }}>
                                        Bangladesh
                                    </option>
                                    <option value="Others" {{ $present_country == 'Others' ? 'selected' : '' }}>Others
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-3">
                                <label for="parmanent_address" class=" col-form-label col-form-label-sm"><b>Permanent</b>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend" title="Same as Prensent Address">
                                        <div class="input-group-text">
                                            <input type="checkbox" aria-label="Checkbox for following text input"
                                                class="same_pre_and_par" id="same_pre_and_par"
                                                {{ $permanent_addr == $present_addr && $permanent_addr != '' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control form-control-sm same_as_par_add"
                                        id="parmanent_address" name="parmanent_address"
                                        placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213"
                                        value="{{ $permanent_addr }}" maxlength="200">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="doctor_par_district"
                                    class="col-form-label col-form-label-sm"><b>District</b></label>
                                <select class="form-control font_size_12 m-auto select2" id="par_district"
                                    name="par_district">
                                    <option value="0">Select District</option>
                                    @if (isset($district))
                                        @foreach ($district as $value)
                                            <option value="{{ $value->id }}" @if ($parmanent_district == $value->id) selected @endif>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class=" col-form-label col-form-label-sm"><b>Thana</b></label>
                                <div id="per_thana">
                                    @include('admin.patient.per_thana')
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <label for="post_code" class=" pl-1 col-form-label col-form-label-sm"><b>Country</b>
                                </label>
                                <select class="form-control font_size_12 m-auto" id="parmanent_country"
                                    name="parmanent_country">
                                    <option value="Bangladesh"
                                        {{ $permanent_country == 'Bangladesh' ? 'selected' : '' }}>
                                        Bangladesh
                                    </option>
                                    <option value="Others" {{ $permanent_country == 'Others' ? 'selected' : '' }}>Others
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    {{-- <hr> --}}
                    <div class="card-header shadow-sm">
                        <h5 class="card-title">FAMILY INFORMATION</h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-row">
                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_father" class="col-form-label s-12"><b>FATHER</b></label>
                                <input type="text" class="form-control form-control-sm text-capitalize" id="patient_father"
                                    name="pat_father" value="{{ $patient_father }}"
                                    placeholder="Enter Patient Father Name"
                                    onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                            </div>
                            <div class="form-group col-4 m-0 focused">
                                <label for="patient_mother" class="col-form-label s-12"><b>MOTHER</b></label>
                                <input type="text" class="form-control form-control-sm text-capitalize" id="patient_mother"
                                    name="pat_mother" value="{{ $patient_mother }}"
                                    placeholder="Enter Patient Mother Name"
                                    onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                            </div>
                            <div class="form-group col-4 m-0 focused" id="spouse" style="display: none;">
                                <label for="patient_spouse" class="col-form-label s-12">SPOUSE</label>
                                <input type="text" class="form-control form-control-sm text-capitalize" id="patient_spouse"
                                    name="pat_spouse" value="{{ $patient_spouse }}"
                                    placeholder="Enter Patient Spouse Name"
                                    onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50">
                            </div>
                        </div>
                    </div>


                    <div class="card-header shadow-sm">
                        <h5 class="card-title">EMERGENCY CONTACT</h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-row">
                            <div class="form-group col-3 m-0 focused">
                                <label for="emergency_contact_name" class="col-form-label s-12"><b>NAME</b></label>
                                <input type="text" class="form-control form-control-sm" id="emergency_contact_name"
                                    name="emergency_contact_name" value="{{ $emergency_contact_name }}"
                                    placeholder="Enter Emergency Contact Name" maxlength="50">
                            </div>
                            <div class="form-group col-3 m-0 focused">
                                <label for="emergency_contact_contact" class="col-form-label s-12"><b>CONTACT
                                        NO</b></label>
                                <input type="text" class="form-control form-control-sm number_only"
                                    id="emergency_contact_contact" name="emergency_contact_contact"
                                    value="{{ $emergency_contact_contact }}" placeholder="Enter Emergency Contact Number"
                                    maxlength="14">
                            </div>

                            <div class="form-group col-3 m-0 focused">
                                <label for="emergency_contact_relation" class="col-form-label s-12"><b>RELATION</b></label>
                                <select class="form-control font_size_12 m-auto" id="emergency_contact_relation"
                                    name="emergency_contact_relation">
                                    <option value="">Select Relation</option>
                                    @if (isset($relation))
                                        @foreach ($relation as $key => $value)
                                            <option value="{{ $key }}" @if ($emergency_contact_relation == $key) selected @endif>
                                                {{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-3 m-0 focused">
                                <label for="emergency_contact_address" class="col-form-label s-12"><b>ADDRESS</b></label>
                                <input type="text" class="form-control form-control-sm" id="emergency_contact_address"
                                    name="emergency_contact_address" value="{{ $emergency_contact_address }}"
                                    placeholder="Enter Emergency Contact Address" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-sm">
                        <div class="form-group">
                            <label for="patient_passport"
                                class="col-form-label col-form-label-sm d-block"><b>STATUS</b></label>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioStatus1" name="status" class="custom-control-input"
                                    value="1" {{ $status == '1' ? 'checked' : '' }} checked="checked">
                                <label class="custom-control-label" for="customRadioStatus1"><b>Active</b></label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioStatus2" name="status" class="custom-control-input"
                                    value="0" {{ $status == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customRadioStatus2"><b>Inctive</b></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $patient_id = '';
                            $response_url = route('patient-card', $patient_id);
                        @endphp

                        <button class="btn btn-success btn-md" id="save_update" data-func="afterSaveModal"
                            data-response-url="{{ $response_url }}" title="Click here to save Patient Information">
                            Save
                        </button>
                        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear
                        </button>
                        <a href="{{ route('cover.patient-admin-panel') }}" class="btn btn-danger btn-md" rel="tab"
                            title="Click here to go back to Dashboard">Exit</a>
                    </div>
                </div>
            </form>


        @endsection


        @push('patient_customjs')


            <script type="text/javascript">
                $("body").addClass("sidenav-toggled");

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

                // function get_dob_by_age()
                // {
                // 	var pat_age_y = $('#pat_age_y').val();
                // 	var pat_age_m = $('#pat_age_m').val();
                // 	var pat_age_d = $('#pat_age_d').val();

                // 	var cur_date = new Date();
                // 	var cur_y = cur_date.getFullYear();

                // 	var dob = pat_age_d + "/" +  pat_age_m  + "/" + (cur_y - pat_age_y);
                // 	var dob_year = cur_y - pat_age_y;
                // 	if((pat_age_m.length && pat_age_d.length) > 0){
                // 		$("#patient_dob").val(dob);
                // 	}else{
                // 		$("#patient_dob").val(dob_year);
                // 	}
                // }

                $(function() {
                    $('#patient_marital_status').on('change', function() {
                        if (this.value == 20) {
                            $("#spouse").show();
                        } else {
                            $("#spouse").hide();
                        }
                    });

                    $(document).on("click", '#save_update', function(e) {
                        if (formValidation("frm-pat-registration") == false) {
                            return;
                        }
                        if (confirm("Are you sure?")) {
                            var page_type = "{{ $page_type }}";
                            $('#frm-pat-registration').unbind().submit(function(e) {
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
                                    success: (data) => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Patient Information Updated Successfully',
                                            showClass: {
                                                popup: 'animate__animated animate__fadeInDown'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__fadeOutUp'
                                            }
                                        })
                                       window.location =
                                            '{{ url('cover/patient/admin-panel') }}';
                                        $.unblockUI();
                                        $(this).find("input, textarea").not('.keep_me').val("");
                                        $(this).find("select").not('.keep_me').val("0");
                                    },
                                    error: function(data) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Something Went Wrong ',
                                            showClass: {
                                                popup: 'animate__animated animate__fadeInDown'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__fadeOutUp'
                                            },
                                        })

                                        window.location =
                                            '{{ url('cover/patient/admin-panel') }}';
                                        $.unblockUI();
                                    },
                                    complete: function() {

                                        if (page_type == 'edit')
                                            dynamicFunc.afterSaveLoadList(
                                                "{{ route('cover.patient-admin-panel') }}");
                                        $.unblockUI();
                                    },
                                    error: function(data) {
                                        var errors = jQuery.parseJSON(data.responseText).errors;
                                        error_messages = "";
                                        for (messages in errors) {
                                            var field_name = $("#" + messages).siblings("label")
                                                .html();
                                            error_messages +=
                                                "<div class='alert alert-danger' role='alert'>" +
                                                errors[messages] + "</div>";
                                        }
                                        $.unblockUI();
                                    }
                                });
                            });
                        }else {
            
            return false;
          }
                        e.stopImmediatePropagation();
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

                    /*$(".same_pre_and_par").click(function() {

                    });*/


                });

                // Date Of Birth
                $(document).on('keyup focus blur', '#patient_dob', function() {

                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        clearBtn: true,
                        todayHighlight: true,
                    });
                })

                function datepic(element) {
                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        clearBtn: true,
                    });
                }

                function get_dob_by_agee() {
                    // var pat_age_y = $('#pat_age_y').val();
                    // var pat_age_m = $('#pat_age_m').val();
                    // var pat_age_d = $('#pat_age_d').val();

                    // var cur_date = new Date();
                    // var cur_y = cur_date.getFullYear();

                    //     var dob = pat_age_d + "-" +  (pat_age_m  )+ "-" + (cur_y - pat_age_y);
                    //     var dob_year = cur_y - pat_age_y;
                    //     if((pat_age_m.length && pat_age_d.length) > 0){
                    //         $("#patient_dob").val(dob);
                    //     }else{
                    //         $("#patient_dob").val(dob_year);
                    //     }

                    //     $('.date_picker').datepicker({
                    //         format: 'dd-mm-yyyy',
                    //         autoclose: true,
                    //         todayHighlight: true,
                    //         clearBtn: true,
                    //     });
                }
                // $('.date_picker').datepicker({
                //     format: 'dd-mm-yyyy',
                //     autoclose: true,
                //     todayHighlight: true,
                //     clearBtn: true,
                // });
                function convertTZ(date, tzString) {
                    return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
                        timeZone: tzString
                    }));
                }

                function get_dob_by_age() {
                    var pat_age_y = $('#pat_age_y').val();
                    var pat_age_m = $('#pat_age_m').val();
                    var pat_age_d = $('#pat_age_d').val();
                    var date = new Date();
                    var today = convertTZ(date, "Asia/Jakarta");
                    var age = today.getFullYear() - pat_age_y;
                    var m = (today.getMonth() + 1) - pat_age_m;
                    var d = today.getDate() - pat_age_d;
                    var month = 0;
                    var date = 0;

                    var pre_month = (today.getMonth());
                    var add_days = 0;
                    if (pre_month == 1) {
                        add_days = 31;
                    } else if (pre_month == 2) {
                        add_days = 28;
                    } else if (pre_month == 3) {
                        add_days = 31;
                    } else if (pre_month == 4) {
                        add_days = 30;
                    } else if (pre_month == 5) {
                        add_days = 31;
                    } else if (pre_month == 6) {
                        add_days = 30;
                    } else if (pre_month == 7) {
                        add_days = 31;
                    } else if (pre_month == 8) {
                        add_days = 31;
                    } else if (pre_month == 9) {
                        add_days = 30;
                    } else if (pre_month == 10) {
                        add_days = 31;
                    } else if (pre_month == 11) {
                        add_days = 30;
                    } else if (pre_month == 12) {
                        add_days = 30;
                    }
                    if (today.getDate() < pat_age_d) {
                        date = (today.getDate() + add_days) - pat_age_d;
                    } else {
                        var dates = today.getDate() - pat_age_d;
                        if (dates == 0) {
                            date = ((today.getDate() + add_days) - pat_age_d);
                        } else {
                            date = (today.getDate() - pat_age_d);
                        }
                    }

                    if ((today.getMonth() + 1) < pat_age_m) {
                        months = (today.getMonth() + 12 + 1) - pat_age_m;
                        if (date == 0) {
                            month = (today.getMonth() + 12 + 1) - (pat_age_m);
                            if (month == 0) {
                                month += 1;
                            }
                        } else {
                            month = (today.getMonth() + 12 + 1) - pat_age_m;
                            if (month == 0) {
                                month += 1;
                            }
                        }
                    } else {
                        if (date == 0) {
                            month = (today.getMonth() + 1) - (pat_age_m);
                            if ((today.getMonth() + 1) > pat_age_m) {
                                month = (today.getMonth() + 12 + 1) - pat_age_m;
                            }
                            if (month == 0) {
                                month += 1;
                            }
                        } else {
                            month = (today.getMonth() + 1) - pat_age_m;
                            if ((today.getMonth() + 1) > pat_age_m) {
                                month = (today.getMonth() + 1) - pat_age_m;
                            }
                            if (month == 0) {
                                month = (today.getMonth() + 1 + 12) - pat_age_m;
                            }
                            console.log(month);
                        }
                    }
                    if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
                        age--;
                    }
                    if (month != 0 && today.getDate() < pat_age_d) {
                        month--;
                    }

                    if ((pat_age_y.length) > 0) {
                        $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
                    }
                    if ((pat_age_y.length && pat_age_m.length) > 0) {
                        $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
                    }
                    if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
                        $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
                    }


                }



                function dob(event, element) {
                    var code = event.keyCode || event.which;

                    if (code != '9') {

                        $('.date_picker').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                            todayHighlight: true,
                            clearBtn: true,
                        });

                        var dateString = $(element).val();
                        if (dateString.indexOf('.')) {
                            var dob = dateString.split(".");
                            dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
                        }
                        if (dateString.indexOf('/')) {
                            var dob = dateString.split("/");
                            dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
                        } else {
                            dateString = $(element).val();
                        }


                        var dob = dateString.split("-");
                        var date = new Date();
                        var now = convertTZ(date, "Asia/Jakarta");
                        var today = new Date(now.getYear(), now.getMonth(), now.getDate());
                        var yearNow = now.getFullYear();
                        var monthNow = 1 + now.getMonth();
                        var dateNow = now.getDate();
                        var yearDob = dob[2];
                        var monthDob = dob[1];
                        var dateDob = dob[0];
                        var age = {};
                        var ageString = "";
                        var yearString = "";
                        var monthString = "";
                        var dayString = "";
                        yearAge = yearNow - yearDob;

                        if ((parseFloat(monthNow)) > monthDob) {
                            var monthAge = (parseFloat(monthNow)) - monthDob;

                        } else {
                            yearAge--;
                            var monthAge = (12 + parseFloat(monthNow)) - monthDob;

                        }
                        if (dateNow > dateDob) {
                            var dateAge = dateNow - dateDob;
                        } else {
                            monthAge--;

                            var pre_month = parseFloat(monthNow);
                            var add_days = 0;
                            if (pre_month == 1) {
                                add_days = 31;
                            } else if (pre_month == 2) {
                                add_days = 28;
                            } else if (pre_month == 3) {
                                add_days = 31;
                            } else if (pre_month == 4) {
                                add_days = 30;
                            } else if (pre_month == 5) {
                                add_days = 31;
                            } else if (pre_month == 6) {
                                add_days = 30;
                            } else if (pre_month == 7) {
                                add_days = 31;
                            } else if (pre_month == 8) {
                                add_days = 31;
                            } else if (pre_month == 9) {
                                add_days = 30;
                            } else if (pre_month == 10) {
                                add_days = 31;
                            } else if (pre_month == 11) {
                                add_days = 30;
                            } else if (pre_month == 12) {
                                add_days = 30;
                            }
                            var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;
                        }
                        age = {
                            years: yearAge,
                            months: monthAge,
                            days: dateAge
                        };
                        var m = now.getMonth() - monthDob;
                        if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
                            yearAge--;
                        }
                        if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
                            ageString = age.years + "-" + age.months + "-" + age.days;
                        var pieces = ageString.split("-");
                        $("#pat_age_y").val(pieces[0]);
                        $("#pat_age_m").val(pieces[1]);
                        $("#pat_age_d").val(pieces[2]);
                    }
                }
            </script>
        </div>
    </div>
@endpush
