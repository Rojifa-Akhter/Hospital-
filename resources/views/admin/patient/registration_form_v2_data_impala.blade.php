@php
    $patient = isset($data) && !empty($data) ? $data : [];
    $patient_no_pk = $patient ? $patient->patient_no_pk : '';
    $patient_salutation = $patient ? $patient->salutation : '';
    $patient_first_name = $patient ? $patient->first_name : '';
    $patient_last_name = $patient ? $patient->last_name : '';
    $patient_age_d = $patient ? $patient->age_dd : '';
    $patient_age_m = $patient ? $patient->age_mm : '';
    $patient_age = $patient ? $patient->age_yy : '';
    $patient_dob = $patient && $patient->dob != '' ? date('Y-m-d', strtotime($patient->dob)) : '';
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
    $patient_type_data = $patient ? $patient->patient_type : '';
    $ccm_client_no_pk = $patient ? $patient->ccm_client_no_fk : '';
    $inform_val = $patient ? $patient->inform_text : '';
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form method="post" id="frm-pat-registration" action="{{ route('registration.store') }}" enctype="multipart/form-data"
    action="javascript:void(0)">
    @csrf
    <input type="hidden" name="id" value="{{ $patient_no_pk }}">

    <div class="card no-b no-r">
        <div class="card-header">
            <h5>BASIC INFORMATION</h5>
        </div>
        <div class="card-body">
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
                                                @if ($salutation == $value) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <input type="text" class="form-control form-control-sm required text-capitalize"
                                id="patient_first_name" name="pat_f_name" value="{{ $patient_first_name }}"
                                placeholder="First Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" required
                                maxlength="50">

                            <input type="text" class="form-control form-control-sm  text-capitalize"
                                id="patient_last_name" name="pat_l_name" value="{{ $patient_last_name }}"
                                placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"
                                maxlength="50">

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4 m-0 focused">
                            <label for="patient_dob" class=" col-form-label col-form-label-sm ">
                                Date of Birth</label>
                            <input type="text" class="form-control form-control-sm date_picker_dob" id="patient_dob"
                                name="pat_dob" value="{{$patient_dob}}" placeholder="YYYY-MM-DD"  onchange="calculateAgeNum(this)">
                        </div>


                        <div class="form-group col-4 m-0 focused">
                           <label for="pat_age_y" class="col-form-label s-12">AGE <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend w-100">
                                    <input type="number" class="form-control form-control-sm" id="pat_age_y"
                                        name="pat_age_y" value="{{ $patient_age }}" placeholder="YY" >
                                    <input type="number" class="form-control form-control-sm" id="pat_age_m"
                                        name="pat_age_m" value="{{ $patient_age_m }}" placeholder="MM">
                                    <input type="number" class="form-control form-control-sm" id="pat_age_d"
                                        name="pat_age_d" value="{{ $patient_age_d }}" placeholder="DD">
                                </div>
                            </div>
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
                                <option value="{{ $key }}" @if ($patient_blood_group == $key) selected @endif>
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
                                <option value="{{ $key }}" @if ($patient_marital_status == $key) selected @endif>
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
                                        @if ($patient_religion == $key) selected @endif>
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
                                        @if ($patient_religion == $key) selected @endif>
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
                    <!--   <input type="text" class="form-control form-control-sm text-capitalize" id="patient_nationality" name="pat_nationality" value="{{ $patient_nationality }}" placeholder="Enter Patient Nationality" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"> -->


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


            <div class="form-row mt-1">
                <div class="form-group col-4 m-0 focused">
                    <label for="patient_type" class="col-form-label s-12">Patient Type</label>
                    <!--   <input type="text" class="form-control form-control-sm text-capitalize" id="patient_nationality" name="pat_nationality" value="" placeholder="Enter Patient Nationality" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"> -->


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
                    <!--   <input type="text" class="form-control form-control-sm text-capitalize" id="patient_nationality" name="pat_nationality" value="" placeholder="Enter Patient Nationality" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"> -->

                    <select class="form-control font_size_12 m-auto " id="corporate_name" name="corporate_name">
                        <option value="">Select Corporate</option>
                        @if (isset($corporate_info))
                            @foreach ($corporate_info as $value)
                                <option value="{{ $value->ccm_client_no_pk }}"
                                    {{ $value->ccm_client_no_pk == $ccm_client_no_pk ? 'selected' : '' }}>
                                    {{ $value->ccm_client_name }}</option>
                            @endforeach
                        @endif
                    </select>

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
                    <label for="inform" class="col-form-label s-12">Where You Heard About Us? </label>
                    <select class="form-control font_size_12 m-auto" id="inform" name="inform">
                        <option value="">Select</option>
                        @if (isset($inform))
                            @foreach ($inform as $key => $value)
                                <option value="{{ $value }}" @if ($inform_val == $value) selected @endif>
                                    {{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <label for="agent_id" class="col-sm-9 col-form-label col-form-label-sm agent_id text-right" style="display: none;">Agent
                    ID</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm pat_info agent_id" maxlength="50" id="agent_id"
                        name="agent" value="" placeholder="Enter Agent ID" style="display: none;">
                    <input type="hidden" name="agent_id_hdn" id="agent_id_hdn">
                </div>

                <label for="staff__id" class="col-sm-10 col-form-label col-form-label-sm staff__id y text-right" style="display: none;">Staff
                    ID</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm pat_info staff__id" maxlength="50" id="staff__id"
                        name="agent" value="" placeholder="Enter Staff ID" style="display: none;">
                    <input type="hidden" name="hdn_staff__id" id="hdn_staff__id">
                </div>

                {{-- <label for="campaign" class="col-sm-8 col-form-label col-form-label-sm campaign text-right" style="display: none;">Campaign
                    Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm pat_info campaign" maxlength="50" id="campaign"
                        name="campaign" value="" placeholder="Enter Campaign Name" style="display: none;">
                </div> --}}

                {{-- <label for="others" class="col-sm-9 col-form-label col-form-label-sm others text-right" style="display: none;">Others
                    Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm pat_info others" maxlength="50" id="others"
                        name="others" value="" placeholder="Enter Others Info" style="display: none;">
                </div> --}}
            </div>


        </div>
        <hr>

        <div class="card-header">
            <h5>CONTACT INFORMATION</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-4 m-0 focused">
                    <label for="mobile_no" class="col-form-label s-12">MOBILE NO</label>
                    <input type="text" class="form-control form-control-sm"
                        id="mobile_no" name="mobile_no" value="{{ $phone_no }}"
                        placeholder="Enter Patient Phone number" onkeypress="return /^[0-9]+$/.test(event.key)"
                         maxlength="14">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="phone_no" class="col-form-label s-12">PHONE NO</label>
                    <input type="text" class="form-control form-control-sm" id="phone_no"
                        name="phone_no" value="{{ $phone_no }}" placeholder="Enter Patient Phone Number"
                        onkeypress="return /^[0-9]+$/.test(event.key)" maxlength="14">
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
                    <label for="present_address" class="col-form-label col-form-label-sm">Present </label>
                    <input type="text" class=" form-control form-control-sm same_as_pre_add"
                        id="present_address" name="present_address" value="{{$present_addr }}"
                        placeholder="Flat#A1, House#17, Road#17/A,Block#E, Dhaka 1213" maxlength="200">
                </div>

                <div class="col-sm-3">
                    <label for="doctor_present_district" class=" col-form-label col-form-label-sm">District</label>
                    <select class="form-control font_size_12 m-auto select2  " id="present_district"
                        name="present_district">
                        <option value="">Select District</option>
                        @if (isset($district))
                            @foreach ($district as $value)
                                <option value="{{ $value->id }}"
                                    @if ($present_district == $value->id) selected @endif>
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
                    <label for="doctor_par_district" class="col-form-label col-form-label-sm">District</label>
                    <select class="form-control font_size_12 m-auto select2" id="par_district" name="par_district">
                        <option value="0">Select District</option>

                        @if (isset($district))

                            @foreach ($district as $value)
                                <option value="{{ $value->id }}"
                                    @if ($parmanent_district == $value->id) selected @endif>{{ $value->name }}
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
                <div class="form-group col-4 m-0 focused" id="spouse" style="display: none;">
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
                    <label for="emergency_contact_name" class="col-form-label s-12">NAME</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_contact_name"
                        name="emergency_contact_name" value="{{ $emergency_contact_name }}"
                        placeholder="Enter Emergency Contact Name" maxlength="50">
                </div>
                <div class="form-group col-4 m-0 focused">
                    <label for="emergency_contact_contact" class="col-form-label s-12">CONTACT NO</label>
                    <input type="text" class="form-control form-control-sm number_only"
                        id="emergency_contact_contact" name="emergency_contact_contact"
                        value="{{ $emergency_contact_contact }}" placeholder="Enter Emergency Contact Number"
                        maxlength="14">
                </div>

                <div class="form-group col-4 m-0 focused">
                    <label for="emergency_contact_relation" class="col-form-label s-12">RELATION</label>
                    <select class="form-control font_size_12 m-auto" id="emergency_contact_relation"
                        name="emergency_contact_relation">
                        <option value="">Select Relation</option>
                        @if (isset($relation))
                            @foreach ($relation as $key => $value)
                                <option value="{{ $key }}"
                                    @if ($emergency_contact_relation == $key) selected @endif>{{ $value }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col m-0 focused">
                    <label for="emergency_contact_address" class="col-form-label s-12">ADDRESS</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_contact_address"
                        name="emergency_contact_address" value="{{ $emergency_contact_address }}"
                        placeholder="Enter Emergency Contact Address" maxlength="100">
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body pb-0">
            <div class="form-group">
                <label for="patient_passport" class="col-form-label col-form-label-sm d-block">STATUS</label>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioStatus1" name="status" class="custom-control-input"
                        value="1" {{ $status == '1' ? 'checked' : '' }} checked="checked">
                    <label class="custom-control-label" for="customRadioStatus1">Active</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioStatus2" name="status" class="custom-control-input"
                        value="0" {{ $status == '0' ? 'checked' : '' }}>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">

    function calculateAgeNum(thisElement) {
       let birthDate = new Date($(thisElement).val());
       let today = new Date();

       let years = today.getFullYear() - birthDate.getFullYear();
       let months = today.getMonth() - birthDate.getMonth();
       let days = today.getDate() - birthDate.getDate() + 1;

        if (months < 0 || (months === 0 && days < 0)) {
            years--;
            months += 12;
        }

        if (days < 0) {
            let lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 0);
            days += lastMonth.getDate();
            months--;
        }
        console.log("ppppp", years, months, days);
        $('#pat_age_y').val(years);
        $('#pat_age_m').val(months);
        $('#pat_age_d').val(days);
    }

    $('.date_picker_dob').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).ready(function() {
        $(".date_picker").datepicker({}).on("change", function() {
            $.ajax({
                url: "{{ route('registration.calculateagebydate') }}",
                method: "post",
                data: {
                    patient_dob: $('#patient_dob').val()
                },
                success: function(res) {
                    //alert(res.new_year + "," +res.new_month +",")
                    $('#pat_age_m').val(res.new_month);
                    $('#pat_age_y').val(res.new_year)
                    $('#pat_age_d').val(res.new_day)
                }
            })
        });

        var timer;

        $('body').on('keyup', '#pat_age_y', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: _this.val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                })
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_m', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: _this.val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_d', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: _this.val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })
    })

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
    // $(document).ready(function(e) {

    // $(document).on("click", '#save_update', function(e) {
    function saveUpdate(element) {
        event.preventDefault();
        var formData = new FormData($('#frm-pat-registration')[0]);
        var formAction = $(element).parents("form").attr("action");
        var formMethod = $(element).parents("form").attr("method");
        var formID = $(element).parents("form").attr("id");
        var page_type = "{{ $page_type }}";
        var customFunc = $("#save_update").attr("data-func");

        if ($('#pat_age_y').val() == "" && $('#pat_age_m').val() == "" && $('#pat_age_d').val() == "") {
            alert('Please Enter Age');
            return;
        } else {


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

                        $('#frm-pat-registration').find("input, textarea").not('.keep_me').val(
                            "");
                        $('#frm-pat-registration').find("select").not('.keep_me').val("0");
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
                        $('.common-modal-notify-error .modal-title').html(
                            "Validation Error");
                        $('.common-modal-notify-error .modal-body').html(
                            error_messages);
                        finished = false;
                        $.unblockUI();
                    }
                });
                // });

            }

        }

        e.stopImmediatePropagation();
    }
    // });
    // });

    function convertTZ(date, tzString) {
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
            timeZone: tzString
        }));
    }

    // $(document).on('keyup','#pat_age_y',function(){
    //     $(this).val(0)
    // })
    function removeRequired() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();

        if ((pat_age_d != '' && pat_age_d > 0) || (pat_age_m != '' && pat_age_m > 0) || (pat_age_d != '' && pat_age_d >
                0)) {
            $('#pat_age_y').removeAttr('required')
        } else {
            $('#pat_age_y').attr('required', true)
        }
    }

    function get_dob_by_age() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();




        var date = new Date();
        var today = convertTZ(date, "Asia/Dhaka");

        var pat_age_year = 0;
        var pat_age_month = pat_age_m;
        var pat_age_days = pat_age_d;

        if ((pat_age_m > 0) && pat_age_d == '' && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30)) / 365);
        } else if (pat_age_m == '' && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365)) / 365);
        } else if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d > 0 && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30) + parseInt(pat_age_days)) / 365)
        } else if (pat_age_m == '' && pat_age_d > 0 && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30)) / 365);
        } else if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30) + parseInt(pat_age_d)) / 365);
        } else {
            pat_age_year = pat_age_y;
        }

        console.log('patient age year 2 ', pat_age_year);

        var age = today.getFullYear() -
            pat_age_year; //today.getFullYear() - Math.round((parseInt(pat_age_y*365)+(parseInt(pat_age_m)*30)+parseInt(pat_age_d))/365);
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
            add_days = 31;
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

        console.log('patient age date ', date);

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
            }
        }
        if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
            age--;
        }
        if (month != 0 && today.getDate() < pat_age_d) {
            month--;
        }

        var age_year = today.getFullYear() - pat_age_year;

        if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear();
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y == '' && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if ((pat_age_y.length || pat_age_m.length || pat_age_d.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //$("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);
        }
        if ((pat_age_y.length && pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_y.length) > 0) {

            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
        }
        if ((pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_d.length) > 0) {
            if (pat_age_d == 30 && (pre_month == 4 || pre_month == 6 || pre_month == 9 || pre_month == 11)) {
                date = 01;
            }
            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }


        /************************************ PREVIOUS ****************************************************/
        // if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }
        // if ((pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }

        /************************************** previous *******************************************/

        $("#patient_dob").datepicker("destroy");

        /************************************ PREVIOUS ****************************************************/
        // if ((pat_age_y.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length) > 0) {
        //     $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        // if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
        //     $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
        // }
        /************************************ PREVIOUS ****************************************************/



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

            } else if ((parseFloat(monthNow)) == monthDob && yearNow == yearDob) {
                yearAge--;
                var monthAge = null; //(parseFloat(monthNow)) - monthDob;
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
                    add_days = 31;
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
        }
        console.log('date picker age ', age)
        if ((age.years < 0) && (age.months >= 0) && (age.days >= 0)) {

            ageString = null + "-" + age.months + "-" + age.days;
        }

        if ((age.years == 0) && (age.months == 11) && (age.days == 31)) {

            ageString = 1 + "-" + null + "-" + null;
        }

        if ((age.months == 12)) {

            ageString = 1 + "-" + null + "-" + age.days;
        }
        var pieces = ageString.split("-");
        $("#pat_age_y").val(pieces[0]);
        $("#pat_age_m").val(pieces[1]);
        $("#pat_age_d").val(pieces[2]);
    }


    function corporate(element) {
        var corp_val = $(element).find(":selected").attr('data-type_code'); //$(element).text();
        if (corp_val == 'CORPORATE') {

            $('.corporate_name').removeClass('d-none');
            $('#corporate_name').attr('required', 'required');
        } else {
            $('.corporate_name').addClass('d-none');
            $('#corporate_name').attr('required', '');
        }
    }
    // agent hide show
    $("select#inform").change(function() {
        var heard_us = $(this).children("option:selected").val();
        var heard_us_attr = $(this).children("option:selected").html().toUpperCase();
        if (heard_us_attr.trim() == 'MARKETING AGENT') {

            $('.agent_id').show();
        } else {
            $('.agent_id').hide();
        }
        if (heard_us_attr.trim() == 'STAFF') {
            $('.staff__id').show();
        } else {
            $('.staff__id').hide();
        }
        if (heard_us_attr.trim() == 'CAMPAIGN') {
            $('.campaign').show();
        } else {
            $('.campaign').hide();
        }
        if (heard_us_attr.trim() == 'OTHERS') {
            $('.others').show();
        } else {
            $('.others').hide();
        }
    });

    openDoctorAutocomplete('#agent_id', 'agent_id_hdn');
    openDoctorAutocomplete('#staff__id', 'hdn_staff__id');
</script>
