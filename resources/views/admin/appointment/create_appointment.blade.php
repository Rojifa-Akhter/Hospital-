@php
    $hospital = DB::table('wsec_hospital')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

    $class_bottom = $hospital->hospital_code == 'GMC' ? '' : 'border-bottom';
@endphp
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<form id="frmCreateAppointment" method="post" action="{{ route('appointments.store') }}">
    <input type="hidden" class="keep_me" id="hdn_appointment_date" name="hdn_appointment_date" value="">
    <input type="hidden" class="keep_me" id="hdn_doctor_id" name="hdn_doctor_id" value="">
    <input type="hidden" class="keep_me" id="hdn_hospital_id" name="hdn_hospital_id" value="">
    <input type="hidden" class="keep_me" id="hdn_service_unit" name="hdn_service_unit" value="">
    <input type="hidden" class="keep_me" id="hdn_schedule_id" name="hdn_schedule_id" value="">
    <input type="hidden" class="keep_me" id="hdn_item_id" name="hdn_item_id" value="">
    <div class="form-row">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="card-body p-2">
                <div>
                    <div class="form-group form-row border-bottom">

                        <div class="avatar-upload d-none" id="pp">
                            <div class="avatar-edit">
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview">
                                    <img id="patientImage" src="" alt="Patient Photo" style="width: 100%; height: auto;">
                                </div>
                            </div>
                        </div>

                        <label class="col-md-3 col-form-label col-form-label-sm patient_id" for="patient_id"></label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input patient_type" type="radio" name="patient_type"
                                    id="patient_type1" value="1" checked>
                                <label class="form-check-label" for="patient_type1">Registered</label>
                            </div>
                            @if (Session::get('user.ses_hospital_code') != 'UNICO')
                            <div class="form-check form-check-inline">
                                <input class="form-check-input patient_type" type="radio" name="patient_type"
                                    id="patient_type2" value="2">
                                <label class="form-check-label" for="patient_type2">Non-Registered</label>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="registered_patient mt-2">
                        <div class="form-group border-bottom form-row">
                            @if (Session::get('user.ses_hospital_code') != 'UNICO')
                            <label class="col-sm-3 col-form-label col-form-label-sm patient_id"
                                for="patient_code">Patient ID <span class="text-danger">*</span>
                            </label>
                            @else
                            <label class="col-sm-3 col-form-label col-form-label-sm patient_id"
                            for="patient_code">UHID <span class="text-danger">*</span>
                            @endif
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm patient_id" id="patient_code"
                                    name="patient_code"
                                    placeholder="Search Patient by Patient Code, Name and Phone Number"
                                    required="required">
                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="non_registered_patient d-none mt-2">
                        <div class="form-group row">
                            <label for="patient_name" class="col-sm-3 col-form-label col-form-label-sm">Patient Name
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="form-control font_size_12 m-auto" id="patient_salutation"
                                            name="patient_salutation">
                                            <option value="">Select </option>
                                            @if (isset($name_prefix))
                                                @foreach ($name_prefix as $key => $value)
                                                    <option value="{{ $value }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_first_name" name="patient_first_name" value=""
                                        placeholder="First Name" maxlength="50" required>
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_last_name" name="patient_last_name" value=""
                                        placeholder="Last Name" maxlength="50">
                                </div>
                            </div>
                        </div>


                        <div class="form-group form-row">
                            <label class="col-md-3 col-form-label col-form-label-sm" for="patienttype">Patient Type
                            </label>
                            <div class="col-md-9">
                                <select class="form-control form-control-sm select2" id="patienttype"
                                    name="patienttype" onchange="corporate(this)" value="">
                                    @if (!empty($patient_type))
                                        @foreach ($patient_type as $data)
                                            <option value="{{ $data->patient_type_no_pk }}" {{-- {{ $data->patient_type_no_pk == $patient_type_data ? 'selected' : '' }} --}}
                                                data-type_code="{{ $data->patient_type_code }}">
                                                {{ ucfirst($data->patient_type_code) }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <label for="corporate_name"
                                class="col-md-3 col-form-label col-form-label-sm corporate_name d-none">Corporate <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9 d-none corporate_name">
                                <select class="form-control font_size_12 m-auto select2" id="corporate_name"
                                    name="corporate_name">
                                    <option value="">Select Corporate</option>
                                    @if (isset($corporate_info))
                                        @foreach ($corporate_info as $value)
                                            <option value="{{ $value->ccm_client_no_pk }}">
                                                {{ $value->ccm_client_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <label for="corporate_id"
                                class="col-md-3 col-form-label col-form-label-sm d-none corporate_id">Corporate
                                ID</label>
                            <div class="col-md-9 d-none corporate_id">
                                <input type="text" class="form-control form-control-sm d-none corportate_id"
                                    maxlength="50" id="corporate_id" name="corporate_id" value=""
                                    placeholder="Enter Corporate ID">
                            </div>


                        </div>



                        <div class="form-group form-row">
                            <label for="patient_gender" class="col-sm-3 col-form-label col-form-label-sm">Gender <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control font_size_12 m-auto " id="patient_gender"
                                    name="patient_gender" required>
                                    <option value="">Select Gender</option>
                                    @if (isset($gender))
                                        @foreach ($gender as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <label for="phone_no" class="col-sm-2 col-form-label col-form-label-sm">Mobile <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                @if(Session::get('user.ses_hospital_code') == "DMHL")
                                <input type="text" class="form-control form-control-sm number_only pat_info"
                                    id="phone_no" name="phone_no" value="" placeholder="Enter Phone Number"
                                    maxlength="14" required>
                                @else
                                    <input type="text" class="form-control form-control-sm number_only pat_info"
                                    id="" name="phone_no" value="" placeholder="Enter Phone Number"
                                    maxlength="14" required>
                                @endif
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label for="patient_age_dd" class="col-sm-3 col-form-label col-form-label-sm">Patient Age
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <input type="number" class="form-control form-control-sm pat_info"
                                            id="pat_age_y" name="patient_age_yy" value="" placeholder="YY"
                                            style="width: 35%;" required>
                                        <input type="number" class="form-control form-control-sm pat_info"
                                            id="pat_age_m" name="patient_age_mm" value="" placeholder="MM"
                                            style="width: 33%;">
                                        <input type="number" class="form-control form-control-sm pat_info"
                                            id="pat_age_d" name="patient_age_dd" value="" placeholder="DD"
                                            style="width: 32%;">
                                    </div>
                                </div>
                            </div>

                            <label for="patient_dob" class="col-sm-2 col-form-label col-form-label-sm">DOB</label>
                            <div class="col-sm-3">
                                <input type="hidden" class="form-control form-control-sm dob_date_picker pat_info"
                                    id="patient_dob" name="patient_dob" value="" autocomplete="off"
                                    placeholder="mm/dd/yyyy">
                                <div id="label_dob"></div>
                                {{-- onclick="dob(event,this)" --}}
                            </div>
                            <label for="patient_blood_group" class="col-sm-3 col-form-label col-form-label-sm">Blood
                                Group</label>
                            <div class="col-sm-4">
                                <select class="form-control font_size_12 m-auto" id="patient_blood_group"
                                    name="patient_blood_group">
                                    <option value="0">Select Blood Group</option>
                                    @if (isset($bloodg))
                                        @foreach ($bloodg as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <label for="patient_marital_status" class="col-sm-2 col-form-label col-form-label-sm"
                                title="Marital Status">M. Status</label>
                            <div class="col-sm-3">
                                <select class="form-control font_size_12 m-auto" id="patient_marital_status"
                                    name="patient_marital_status">
                                    <option value="0">Select Marital Status</option>
                                    @if (isset($marsts))
                                        @foreach ($marsts as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>


                            <label for="patient_religion" class="col-sm-3 col-form-label col-form-label-sm"
                                title="Marital Status">Religion Status</label>
                            <div class="col-sm-4">
                                <select class="form-control font_size_12 m-auto" id="patient_religion"
                                    name="patient_religion">
                                    <option value="0">Select Religion Status</option>
                                    @if (isset($religion))
                                        @foreach ($religion as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <label for="patient_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control form-control-sm pat_info"
                                    id="patient_email" name="patient_email" value=""
                                    placeholder="Enter Patient Email ID" maxlength="50"
                                    pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
                            </div>
                        </div>


                        {{-- Start --}}
                        <div class="form-group row">
                            @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                <label for="patient_address" class="col-sm-3 col-form-label col-form-label-sm">Address
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_address" name="patient_address" value=""
                                        placeholder="Enter Patient Address" maxlength="100" required>
                                </div>
                            @else
                                <label for="patient_address"
                                    class="col-sm-3 col-form-label col-form-label-sm">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="patient_address" name="patient_address" value=""
                                        placeholder="Enter Patient Address" maxlength="100">
                                </div>
                            @endif
                        </div>

                        <div class="form-group row <?php echo $class_bottom; ?>">
                            <label for="patient_nid" class="col-sm-3 col-form-label col-form-label-sm">NID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm pat_info" id="patient_nid"
                                    name="pat_nid" value="" placeholder="Enter Patient NID"
                                    onkeypress="return /^[0-9]+$/.test(event.key)" maxlength="17">
                            </div>
                        </div>


                        @if ($hospital->hospital_code == 'GMC' || $hospital->hospital_code == 'EWMCH')

                            @if ($hospital->hospital_code == 'EWMCH')
                                <div class="form-group row">
                                    <label for="search_data"
                                        class="col-sm-3 col-form-label col-form-label-sm">Village/Area/Town <span
                                            class="text-danger">*</span></label>
                                @else
                                    <div class="form-group row border-bottom">
                                        <label for="search_data"
                                            class="col-sm-3 col-form-label col-form-label-sm">Patient
                                            Area <span class="text-danger">*</span></label>
                            @endif

                            <div class="col-sm-9">
                                @if ($hospital->hospital_code == 'EWMCH')
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="search_data" name="patient_area" value=""
                                        placeholder="Enter Village/Area/Town" maxlength="100 " required>
                                @else
                                    <input type="text" class="form-control form-control-sm pat_info"
                                        id="search_data" name="patient_area" value=""
                                        placeholder="Enter Patient Area" maxlength="100 " required>
                                @endif

                                <input type="hidden" id="hdn_area_code" name="hdn_area_code">
                                <input type="hidden" id="hdn_area_name" name="hdn_area_name">
                            </div>
                    </div>
                    @endif

                    @if ($hospital->hospital_code == 'EWMCH')
                        <div class="form-group form-row border-bottom">
                            <label for="present_district" class="col-sm-3 col-form-label col-form-label-sm">District
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <select class="form-control font_size_12 m-auto select2  " id="present_district"
                                    name="present_district" required>
                                    <option value="">Select District</option>
                                    @if (isset($district))
                                        @foreach ($district as $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <label for="present_thana" class="col-sm-1 col-form-label col-form-label-sm">Thana
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <div id="present_thana">

                                    @include('admin.patient.pre_thana')

                                </div>
                            </div>


                            <label for="present_ward" class="col-sm-2 col-form-label col-form-label-sm">Ward/Union
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <div id="present_ward">

                                    <input type="text" class="form-control form-control-sm " id="present_ward"
                                        name="present_ward" value="" placeholder="Enter Ward" maxlength="100"
                                        required>

                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- End --}}

                </div>
            </div>






            <input type="hidden" id="hos_code" value="{{ Session::get('user.ses_hospital_code') }}">
            <div class="form-group form-row mt-2">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="visit_type"
                    title="Appointment Type">App. Type<span class="text-danger"> *</span></label>

                <div class="col-sm-9">
                    <select class="form-control form-control-sm required" id="visit_type" name="visit_type"
                        required="required" required>
                        <option value="">Select Appointment Type</option>
                        @if (!empty($visit_types))
                            @foreach ($visit_types as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            @if (Session::get('user.ses_hospital_code') != 'UNICO')
            <div class="form-group form-row mt-2">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="cheif_compl">Chief Complaint</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control mb-0" id="cheif_complaint" name="cheif_complaint"
                        placeholder="Enter Chief Complaints"
                        data-lookup-id="{{ isset($chiefcom->CHIEFCOM) ? $chiefcom->CHIEFCOM : '' }}"
                        data-lookup-code="CHIEFCOM">
                    <div class="card mt-0 bg-none border-0">
                        <div class="card-body p-0">
                            <ul class="list-unstyled mb-0 pt-1" id="chfcom"></ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="form-group form-row">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="reffered_by">Reffered By <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control form-control-sm" id="reffered_by" name="reffered_by" required>
                        {{-- <option value="0">Select Refferer</option> --}}
                        <option value="1">Self</option>
                        <option value="2">Others</option>
                    </select>
                </div>
            </div>
            <div class="d-none" id="referrer_name_con">
                <div class="form-group form-row">
                    <label class="col-md-3 col-form-label col-form-label-sm" for="first_refer">First
                        Referral</label>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-9 first_refer_div">
                                <input class="form-control first_refer" type="text" name="first_refer"
                                    id="first_refer" placeholder="Write First Referral Name">
                                <input type="hidden" name="hdn_first_refer" class="hdn_first_refer"
                                    id="hdn_first_refer">
                            </div>
                            <div class="col-md-3">
                                <span class="badge badge-primary cursor-pointer open-modal"
                                    data-modal="common-modal-sm"
                                    data-action="{{ route('doctor.createquickregistration', '2') }}"
                                    data-title="Add new Doctor (Referral)">+ Add New</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-row" id="referrer_name_con">
                    <label class="col-md-3 col-form-label col-form-label-sm" for="second_refer">Second
                        Referral</label>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-9 second_refer_div">
                                <input class="form-control second_refer" type="text" name="second_refer"
                                    id="second_refer" placeholder="Write Second Referral Name">
                                <input type="hidden" name="hdn_second_refer" class="hdn_second_refer"
                                    id="hdn_second_refer">
                            </div>
                            <div class="col-md-3">
                                <span class="badge badge-primary cursor-pointer open-modal"
                                    data-modal="common-modal-sm"
                                    data-action="{{ route('doctor.createquickregistration', '3') }}"
                                    data-title="Add new Doctor (Referral)">+ Add New</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-row">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="appointment_priority">Priority
                </label>
                <div class="col-sm-9">
                    <select class="form-control form-control-sm" id="appointment_priority"
                        name="appointment_priority" value="">
                        {{-- <option value="0">Select Priority</option> --}}

                        @if (!empty($priority))
                            @foreach ($priority as $key => $value)
                                <option value="{{ $key }} "
                                    @if ($value == 'Routine') selected @endif>{{ $value }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                </div>


            </div>

            <div class="form-group form-row">
                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                <label for="inform" class="col-sm-3 col-form-label col-form-label-sm">How Did You Find Us?
                </label>
                <div class="col-md-9">
                    <select class="form-control form-control-sm" id="inform" name="inform">
                        @if ($hospital->hospital_code == 'IMPALA')
                            <option value="">Select</option>
                        @endif
                        @if (isset($inform))
                            @foreach ($inform as $key => $value)
                                <option value="{{ $value }}"
                                    @if ($value == 'Self' && $hospital->hospital_code != 'IMPALA') selected @endif>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @endif

                {{-- <div id="agent_id" style="display: none";"> --}}
                <label for="agent_id" class="col-sm-3 col-form-label col-form-label-sm agent_id"
                    style="display: none;">Agent ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm agent_id" maxlength="50"
                        id="agent_id" name="agent" value="" placeholder="Enter Agent ID"
                        style="display: none;">
                    <input type="hidden" name="agent_id_hdn" id="agent_id_hdn">
                </div>

                <label for="staff__id" class="col-sm-3 col-form-label col-form-label-sm staff__id"
                    style="display: none;">Staff ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm staff__id" maxlength="50"
                        id="staff__id" name="agent" value="" placeholder="Enter Staff ID"
                        style="display: none;">
                    <input type="hidden" name="hdn_staff__id" id="hdn_staff__id">
                </div>

                <label for="campaign" class="col-sm-3 col-form-label col-form-label-sm campaign"
                    style="display: none;">Campaign Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm campaign" maxlength="50"
                        id="campaign" name="campaign" value="" placeholder="Enter Campaign Name"
                        style="display: none;">
                </div>

                <label for="others" class="col-sm-3 col-form-label col-form-label-sm others"
                    style="display: none;">Others Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm others" maxlength="50" id="others"
                        name="others" value="" placeholder="Enter Others Info" style="display: none;">
                </div>
                {{-- </div> --}}
            </div>





            @if (Session::get('user.ses_hospital_code') != 'UNICO')
            <div class="form-group form-row">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="select_end_date">Notes</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="2" id="patient_note" name="patient_note"></textarea>
                </div>
            </div>
            @endif
            {{-- new pay bill section start --}}
            <div class="form-group form-row">
                <label for="is_pay_consultation" class="col-sm-3 col-form-label col-form-label-sm">Pay Bill Now?</label>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" id="is_pay_consultation" name="is_pay_consultation">
                    </select>
                </div>

                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                <div class="col-sm-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="patient_manual_sl_checkbox"
                            name="patient_manual_sl_checkbox" value="1" />
                        <label class="form-check-label" for="patient_manual_sl_checkbox">
                            Manual SL
                        </label>
                    </div>
                </div>
                {{-- <div class="col-sm-2">
                        <input type="text" onkeypress="return false;" class="form-control form-control-sm"
                            id="start_time" name="start_time" placeholder="S.Time" />
                    </div>

                    <div class="col-sm-2">
                        <input type="text" onkeypress="return false;" class="form-control form-control-sm"
                            id="end_time" name="end_time" placeholder="E.Time" />
                    </div> --}}
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="start_time" name="start_time"
                        placeholder="S.Time" />
                </div>

                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" id="end_time" name="end_time"
                        placeholder="E.Time" />
                </div>
                @endif

            </div>
            {{-- new pay bill section end --}}


            {{-- <div class="form-group form-row">
                        <label class="col-md-3 col-form-label col-form-label-sm" for="select_end_date">Pay Bill Now?</label>
                        <div class="col-md-2">
                            <select class="form-control form-control-sm" id="is_pay_consultation" name="is_pay_consultation"> </select>
                        </div>

                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="patient_manual_sl_checkbox" name="patient_manual_sl_checkbox" value="1" />
                            <label class="custom-control-label" for="patient_manual_sl_checkbox">Manual SL</label>
                        </div>
                        <div class="custom-control mr-sm-2">
                            <label class="custom-label" for="start_time">S.Time</label>

                            <input type="text" id="start_time" name="start_time" />
                        </div>
                        <div class="custom-control mr-sm-2">
                            <label class="custom-label" for="end_time">E.Time</label>

                            <input type="text" id="end_time" name="end_time" />
                        </div>
                        <input type="hidden" id="slot_no_pk" name="slot_no_pk" />
                  </div> --}}


            {{-- <input type="text"  id="end_time"
                            name="end_time" onkeypress="return false;">
                    </div> --}}
            <input type="hidden" id="slot_no_pk" name="slot_no_pk" value="">
            {{-- <input type="text" id="doc_slot_ind_val_" name="doc_slot_ind_val_" value=""> --}}



            <div class="form-group form-row">
                <div class="col-md-7" id="sales_price"></div>
                <div class="col-md-5 text-red text-center" id="appoint_date"> </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal-footer mt-1">

        @php
            $appoint_id = '';
            $response_url = route('appointment-card-pat', $appoint_id);
            $redirect_url = route('appointments.create');
        @endphp
        <button type="button" class="btn btn-md btn-success float-left" data-response_action="{{ $response_url }}"
            data-redirect-action="{{ $redirect_url }}" onclick="appointmentEngine.saveAppointment(this)"><i
                class="fa fa-save"></i> Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

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

    $(document).on("change", ".patient_type	", function(e) {

        var value = $(this).val();
        console.log(value + ' MMM');
        
        if (value == 1) {
            $('.pat_info').val("");
            $("#patient_gender").val("");
            $("#patient_blood_group").val(0);
            $("#patient_marital_status").val(0);
        } else {
            $('#patient_code').val("");
            $('#hdn_patient_id').val("");
            $('#non_registered_photo').removeClass('d-none')
            function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview2').hide();
                    $('#imagePreview2').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
          }
            $("#imageUpload2").change(function() {
                readURL(this);
            });
        }
    });
    $(function() {

        $(document).on("click", "#quickRegisterReferral2", function() {
            var formID = $(this).parents("form").attr("id");
            var formAction = $(this).parents("form").attr("action");
            var formMethod = $(this).parents("form").attr("method");

            $.ajax({
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#hdn_second_refer").val(data.insert_id);
                    $("#second_refer").val(data.last_name);

                    $('#doctor_quick_reg_form')[0].reset();
                    $('#exampleModal').modal('hide');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });
    });

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
    // function datepic(element) {

    //     $('.dob_date_picker').datepicker({
    //         format: 'dd-mm-yyyy',
    //         autoclose: true,
    //         // todayHighlight: true,
    //         clearBtn: true,
    //         // onSelect: function (date) {
    //         // //defined your own method here
    //         // alert(date);
    //         // }

    //     });

    // }



    function corporate(element) {
        var corp_val = $(element).find(":selected").attr('data-type_code'); //$(element).text();
        if (corp_val == 'CORPORATE') {

            $('.corporate_name').removeClass('d-none');
            $('#corporate_name').attr('required', 'required');


            $('.corporate_id').removeClass('d-none');
            $('#corporate_id').removeClass('d-none');
        } else {
            $('.corporate_name').addClass('d-none');
            $('#corporate_name').attr('required', '');

            $('.corporate_id').addClass('d-none');
            $('#corporate_id').addClass('d-none');
        }
    }
    // var tajul = $("#doc_slot_ind_val_").val();
    // console.log(tajul);
    // console.log('taj');




    $("select#inform").change(function() {
        var heard_us = $(this).children("option:selected").val();
        var heard_us_attr = $(this).children("option:selected").html().toUpperCase();
        console.log(heard_us_attr)
        if (heard_us_attr == 'MARKETING AGENT') {
            $('.agent_id').show();
        } else {
            $('.agent_id').hide();
        }
        if (heard_us_attr == 'STAFF') {
            $('.staff__id').show();
        } else {
            $('.staff__id').hide();
        }
        if (heard_us_attr == 'CAMPAIGN') {
            $('.campaign').show();
        } else {
            $('.campaign').hide();
        }
        if (heard_us_attr == 'OTHERS') {
            $('.others').show();
        } else {
            $('.others').hide();
        }
    });
    openDoctorAutocomplete('#agent_id', 'agent_id_hdn');
    openDoctorAutocomplete('#staff__id', 'hdn_staff__id');




    // district and thana add
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

                $('.select2').select2();
                //$("#par_district").select2("readonly", true);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
