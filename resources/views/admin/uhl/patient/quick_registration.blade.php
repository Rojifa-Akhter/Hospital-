@php
    $patient = isset($patient) && !empty($patient) ? $patient : [];
    $patient_no_pk = $patient ? $patient->patient_no_pk : '';
    $uhid = $patient ? $patient->patient_code : '';
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
@endphp

<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
  
    <form action="{{ route('uhl.patient-registration-store-v2') }}" id="hos-registration-form" method="POST"
        enctype="multipart/form-data">
        @csrf
        <section class="paitent__registration">
            <input type="hidden" name="hdn_patient_no_pk" id="hdn_patient_no_pk" value="{{ $patient_no_pk }}">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12 mb-1">
                                <h5 class="mt-2 mb-0">Quick Patient Registration</h5>
                                <small>Patient / Registration Info</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <div class="card mt-0">
                                            <div class="card-header">
                                                <h5>Personal Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
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
                                                </div>
                                              
                                                <div class="form-group form-row">
                                                    <label for="quick_reg_date" class="col-sm-5 col-form-label">Registration Date<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        @php
                                                            $current_date = date('d-m-Y');
                                                        @endphp
                                                        <input type="text" class="form-control" id="quick_reg_date" name="quick_reg_date" required
                                                            value="{{ $current_date }}" readonly/>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="full_name" class="col-sm-5 col-form-label">Full Name<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="full_name" tabindex="1" name="full_name" required
                                                            onkeyup="checkBlankSpace(this)" value="{{ $patient_first_name . $patient_last_name }}"/>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="pati_age_y"
                                                        class="col-sm-5 col-form-label">Age</label>
                                                    <div class="col-sm-7">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend w-100">
                                                                <input type="text" class="form-control number_only form-control-sm" id="pat_age_y" name="pat_age_y"
                                                                    value="{{ $patient_age }}" placeholder="YY" tabindex="2" required="" />

                                                                <input type="text" class="form-control number_only form-control-sm" id="pat_age_m" name="pat_age_m"
                                                                    value="{{ $patient_age_m }}" placeholder="MM" />

                                                                <input type="text" class="form-control number_only form-control-sm" id="pat_age_d" name="pat_age_d"
                                                                    value="{{ $patient_age_d }}" placeholder="DD" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="patient_dob" class="col-sm-5 col-form-label">DOB<span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control date_picker" id="patient_dob" name="patient_dob"
                                                            placeholder="dd-mm-yyyy" tabindex="3" value="{{ $patient_dob }}"/>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="patient_gender" class="col-sm-5 col-form-label">Sex<span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="patient_gender" value="3002115_Male">Male
                                                            </label>
                                                          </div>
                                                          <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="patient_gender" value="6_Female">Female
                                                            </label>
                                                          </div>
                                                          <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="patient_gender" value="7_Others">Others
                                                            </label>
                                                          </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="marital_status" class="col-sm-5 col-form-label">Marital Status<span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="marital_status" value="19_Single">Single
                                                            </label>
                                                          </div>
                                                          <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="marital_status" value="20_Married">Married
                                                            </label>
                                                          </div>
                                                          <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="marital_status" value="1_Others">Others
                                                            </label>
                                                          </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="religion_" class="col-sm-5 col-form-label">Religion <span class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control form-control-sm font_size_12"
                                                            id="religion_" name="religion" required tabindex="4">
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

                                                <div class="form-group form-row">
                                                    <label for="in_national_id" class="col-sm-5 col-form-label">NID / Passport</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control number_only" id="in_national_id" name="in_national_id"
                                                            tabindex="5" placeholder="NID / Passport" onkeyup="checkBlankSpace(this)" value="{{ $patient_nid }}" />
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="nationality" class="col-sm-5 col-form-label">Nationality</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control form-control-sm font_size_12"
                                                            id="nationality" name="nationality" tabindex="4">
                                                            <option value="">Select</option>
                                                            <option value="10">Bangladeshi</option>
                                                            <option value="3003394">Indian</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="visa_validity" class="col-sm-5 col-form-label">Visa Validity (In case of foreigner)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="visa_validity" name="visa_validity"
                                                            tabindex="5" onkeyup="checkBlankSpace(this)" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="occupation" class="col-sm-5 col-form-label">Occupation</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="occupation" name="occupation"
                                                            tabindex="6" placeholder="Occupation" onkeyup="checkBlankSpace(this)" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group form-row">
                                                    <label for="health_insurance" class="col-sm-5 col-form-label">Health Insurance</label>
                                                    <div class="col-sm-7">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="health_insurance" id="health_yes" value="yes">Yes
                                                            </label>
                                                          </div>
                                                          <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                              <input type="radio" class="form-check-input" name="health_insurance" id="health_no" value="no">No
                                                            </label>
                                                          </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-row d-none" id="insurance_company">
                                                    <label for="insurance_company_name" class="col-sm-5 col-form-label">Name of Insurance Company</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="insurance_company_name" name="insurance_company_name"
                                                        onkeyup="checkBlankSpace(this)" value="" />
                                                    </div>
                                                </div>


                                                <div class="form-group form-row">
                                                    <label for="identity_type" class="col-sm-5 col-form-label">Pt. Category<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-7">
                                                        
                                                    <select class="form-control form-control-sm text-capitalize" id="patient_type" name="patient_type" value="" tabindex="22" onchange="corporate(this)">
                                                        @if (!empty($patient_type_data))
                                                            @foreach ($patient_type_data as $data)
                                                            <option data-type_code="{{ $data->patient_type_code }}"
                                                            value="{{ $data->patient_type_no_pk }}"
                                                            {{ $data->patient_type_no_pk == $patient_type ? 'selected' : '' }}>
                                                            {{ $data->patient_type_code }}
                                                            </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                    
                                                    @php
                                                    $d_none = isset($patient_type) && $patient_type == '' ? 'd-none' : '';
                                                    @endphp
                                                    </div>
                                                  </div>

                                                    <div class="form-group form-row  corporate_name {{$d_none}}">
                                                        
                                                        <label for="corporate_name" class="col-sm-5 col-form-label corporate_name {{ $d_none }}">Corporate<span class="text-danger">*</span></label>
                                                        <div class="col-sm-7">
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
                                                    </div>

                                                
                                                <div class="form-group form-row">
                                                    <label for="patient_consent" class="col-sm-5 col-form-label">Patient Consent</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="patient_consent" name="patient_consent"
                                                        tabindex="7" onkeyup="checkBlankSpace(this)" value="" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="card mt-0">
                                                    <div class="card-header">
                                                        <h5 class="mt-2 mb-0">Contact Details</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group form-row">
                                                            <label for="mobile_" class="col-sm-5 col-form-label">Mobile
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control form-control-sm number_only" title="Mobile Number Must be 11 Digit"
                                                                    id="mobile_" name="mobile" minlength="11" required tabindex="8"
                                                                    onkeyup="checkBlankSpace(this)" value="{{ $phone_no }}"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="in_email" class="col-sm-5 col-form-label">Email</label>
                                                            <div class="col-sm-7">
                                                            <input type="email" class="form-control form-control-sm" id="in_email" name="in_email" tabindex="9" onkeyup="checkBlankSpace(this)" value="{{ $patient_email }}"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="thana_ps" class="col-sm-5 col-form-label">Thana/P.S.</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12 select2" id="thana_present" name="in_pr_addr_thana">
                                                                    <option value="">Select Thana</option>
                                                                    @if (!empty($thanas))
                                                                        @foreach ($thanas as $row)
                                                                            <option value="{{ $row->id }}" @if ($present_thana == $row->id) selected @endif data-district-id="{{ $row->district_id }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="distric_city" class="col-sm-5 col-form-label">District/City</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12 select2" id="distric_city" name="in_present_district">
                                                                    <option value="">Select District</option>
                                                                    @if (!empty($district))
                                                                        @foreach ($district as $row)
                                                                            <option value="{{ $row->id }}" @if ($row->id == $doctor_present_district) selected @endif>{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row d-none">
                                                            <label for="state_division" class="col-sm-5 col-form-label">State/Division
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12" id="state_division" name="state_division">
                                                                    <option value="">Select Division</option>
                                                                    @if (!empty($divisions))
                                                                        @foreach ($divisions as $row)
                                                                            <option value="{{ $row->id }}" {{ $row->id == 6 ? '' : '' }}>{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="present_country" class="col-sm-5 col-form-label">Country</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm" id="present_country" name="in_pr_addr_country">
                                                                    @if (!empty($country))
                                                                        @foreach ($country as $row)
                                                                            <option
                                                                                value="{{ $row->country_no_pk }}">
                                                                                {{ $row->country_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group form-row">
                                                            <label for="address_" class="col-sm-5 col-form-label">Address<span class="text-danger">*</span></label>
                                                            <div class="col-sm-7">
                                                                <textarea class="form-control form-control-sm" id="address_" name="pat_address" placeholder="" row="3"
                                                                    onkeyup="checkBlankSpace(this)" required tabindex="10" name="pat_address"
                                                                    style="min-height: 100px !important;">{{ $present_addres }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="guardian__name" class="col-sm-5 col-form-label">Parent / Guardian Name</label>
                                                            <div class="col-sm-7">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control form-control-sm" id="guardian__name" name="in_guardian_name"
                                                                        tabindex="11" onkeyup="checkBlankSpace(this)" value="{{ $patient_guardian }}"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="card mt-0">
                                                    <div class="card-header">
                                                        <h5 class="mt-2 mb-0">Permanent Address Info</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" tabindex="12" onchange="sameAddress(this)">
                                                            <label class="form-check-label" for="exampleCheck1">Same As</label>
                                                        </div>
                                                        
                                                        <div class="form-group form-row">
                                                            <label for="thana_ps" class="col-sm-5 col-form-label">Thana/P.S.</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12 select2" tabindex="13" id="thana_per" name="in_per_addr_thana">
                                                                    <option value="">Select Thana</option>
                                                                    @if (!empty($thanas))
                                                                        @foreach ($thanas as $row)
                                                                            <option value="{{ $row->id }}" @if ($doctor_permanent_thana == $row->id) selected @endif data-district-id = "{{ $row->district_id }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="per_distric_city" class="col-sm-5 col-form-label">District/City</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12 select2" id="per_distric_city" name="in_permanent_district">
                                                                    <option value="">District/City</option>
                                                                    @if (!empty($district))
                                                                        @foreach ($district as $row)
                                                                            <option value="{{ $row->id }}" @if ($parmanent_district == $row->id) selected @endif>{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row d-none">
                                                            <label for="per_state_division" class="col-sm-5 col-form-label">State/Division<span class="text-danger">*</span></label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm font_size_12" id="per_state_division" name="per_state_division">
                                                                    <option value="">State/Division</option>
                                                                    @if (!empty($divisions))
                                                                        @foreach ($divisions as $row)
                                                                            <option value="{{ $row->id }}" {{ $row->id == 6 ? '' : '' }}>{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-row">
                                                            <label for="per_country" class="col-sm-5 col-form-label">Country</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control form-control-sm" id="per_country" name="in_pe_addr_country">
                                                                    @if (!empty($country))
                                                                        @foreach ($country as $row)
                                                                            <option value="{{ $row->country_no_pk }}">{{ $row->country_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="form-group form-row">
                                                            <label for="in_permanent_addr" class="col-sm-5 col-form-label">Address<span class="text-danger">*</span></label>
                                                            <div class="col-sm-7">
                                                                <textarea class="form-control form-control-sm" id="in_permanent_addr" tabindex="14" placeholder="" row="3" required
                                                                    onkeyup="checkBlankSpace(this)" name="in_permanent_addr" style="min-height: 100px !important;"
                                                                    required>{{ $parmanent_address }}</textarea>
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
                                    $response_action = route('uhl.patient-service-type');

                                    $redirect_url = route('uhl.patient-quick-registration');
                                    @endphp
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button class="btn btn-secondary uhl_save_btn" type="button"
                                                onclick="btnSaveUpdatefile(this , 'afterSaveModal', '{{ $response_action }}', 'common-modal-xl', 'Patient Service Type',dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save
                                            </button>
                                            {{-- btnSaveUpdate     --}}
                                        </li>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
$("body").addClass("sidebar-collapse");
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

    $('#health_yes').change(function() {
        if ($(this).is(':checked')) {
            $('#insurance_company').removeClass('d-none');
        }
    });

    $('#health_no').change(function() {
        if ($(this).is(':checked')) {
            $('#insurance_company').addClass('d-none');
        }
    });

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

    window.onload = function() {
            document.getElementById('full_name').focus();
        };

        function handleKeyDown(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();
                var button = document.getElementById('save_update');
                if (button) {
                    saveUpdate(button);
                }
            }
        }
        document.addEventListener('keydown', handleKeyDown);


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
                    //alert(res.new_year + "," +res.new_month +",")
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

    })



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


    function checkDuplicate(element) {

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
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-title').html();
                $('.common-modal-notify .modal-body').html(data.data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
