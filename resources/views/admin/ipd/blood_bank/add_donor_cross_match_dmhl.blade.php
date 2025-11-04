<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<!-- <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet"> -->
<style>
    .error {
        color: red;
        font-size: 0.9em;
    }
</style>
<div class="container-fluid">
    <form id="searchFormDmhl" action="{{ route('ipd.save-blood-bank-donor-info-dmhl') }}" method="post">
        <input type="hidden" class="" id="blood_bank_req_id" name="blood_bank_req_id"
            value="{{ !empty($blood_requisition_data) ? $blood_requisition_data->requsition_no_pk : '' }}">
        <input type="hidden" class="" id="prescription_no" name="prescription_no" value="">
        <input type="hidden" class="" id="donor_dtl_no" name="donor_dtl_no"
            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donordtl_no_pk : '' }}">
        @csrf
        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="card-link" style="cursor: pointer">
                        Add Donor Information
                    </a>
                </div>
                <div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Donar Name <span class="text-danger">*</span>
                                        </strong></div>
                                    <div class="col-md-7"><input type="text" class="form-control" id="donor_name"
                                            name="donor_name"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_name : '' }}"
                                            placeholder="" required autocomplete="off"><input type="hidden"
                                            class="form-control" id="hidden_donor_id" name="hidden_donor_id"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_no_fk : '' }}">
                                        <span class="error" id="donorNameError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    {{-- <div class="col-md-5"><strong>Date of Birth <span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control date-picker" id="donor_age" name="donor_age" value="{{!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->donor_dob !='' ? date('d-m-Y',strtotime( $blood_requisition_dtl_data->donor_dob)) :''}}" placeholder="dd-mm-yyyy" required></div> --}}
                                    <div class="col-md-5"><strong>Age<span class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="donor_age"
                                            name="donor_age"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_age : '' }}"
                                            placeholder="Donor Age" required autocomplete="off">
                                        <span class="error" id="ageError"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Gender <span class="text-danger">*</span></strong>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="donor_gender" name="donor_gender"
                                            title="From lookup 'gender (GENDER)'" required>
                                            <option value="">select</option>
                                            @if (!empty($gender))
                                                @foreach ($gender as $kye => $value)
                                                    <option value="{{ $value }}"
                                                        {{ !empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->donor_gender == $value ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="error" id="genderError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Phone No <span class="text-danger">*</span></strong>
                                    </div>
                                    <div class="col-md-7"> <input type="text" class="form-control number_only" id="mobile"
                                            name="mobile"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_mobile : '' }}"
                                            required autocomplete="off"  maxlength="11" pattern="\d{11}">
                                        <span class="error" id="phoneError"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Address <span class="text-danger">*</span></strong>
                                    </div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="address"
                                            name="address"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_address : '' }}"
                                            required>
                                        <span class="error" id="addressError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Profession </strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control"
                                            id="donor_profession" name="donor_profession"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_profession : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Marital Status </strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="marital_status" name="marital_status"
                                            title="From lookup 'Marital Status (MARSTS)'">
                                            <option value="">select</option>
                                            @if (!empty($marital_status))
                                                @foreach ($marital_status as $kye => $value)
                                                    <option value="{{ $value }}"
                                                        {{ !empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->marital_status == $value ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Father/Husband Name <span
                                                class="text-danger">*</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control"
                                            id="spouse_name" name="spouse_name"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->fatherorhousbend_name : '' }}"
                                            required autocomplete="off">
                                        <span class="error" id="fatherError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Donor Type <span class="text-danger">
                                                *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="donor_type" name="donor_type" required>
                                            <option value="">select</option>
                                            @if (!empty($donorType))
                                                @foreach ($donorType as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ isset($blood_requisition_dtl_data->donor_type) && $blood_requisition_dtl_data->donor_type == $key ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="error" id="donorTypeError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Did you proper sleep last night? <span
                                                class="text-danger"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="sleep" name="sleep" required>
                                            <option value="1"
                                                {{ isset($blood_requisition_dtl_data->sleep_id) && $blood_requisition_dtl_data->sleep_id == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2"
                                                {{ isset($blood_requisition_dtl_data->sleep_id) && $blood_requisition_dtl_data->sleep_id == 2 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        <span class="error" id="sleepError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Did you have breakfast or lunch?<span
                                                class="text-danger"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="breakfast_lunch" name="breakfast_lunch"
                                            required>
                                            <option value="1"
                                                {{ isset($blood_requisition_dtl_data->breakfast) && $blood_requisition_dtl_data->breakfast == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2"
                                                {{ isset($blood_requisition_dtl_data->breakfast) && $blood_requisition_dtl_data->breakfast == 2 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        <span class="error" id="lunchError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Have you taken any of the following in last 72
                                            hours?<span class="text-danger"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="taken_any" name="taken_any" required>
                                            <option value="2"
                                                {{ isset($blood_requisition_dtl_data->following_72) && $blood_requisition_dtl_data->following_72 == 2 ? 'selected' : '' }}>
                                                No</option>
                                            <option value="1"
                                                {{ isset($blood_requisition_dtl_data->following_72) && $blood_requisition_dtl_data->following_72 == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                        </select>
                                        <span class="error" id="takenError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Oral Polio, measeles and mumps vaccine-Defer for 4
                                            weeks<span class="text-danger"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="oral_polio" name="oral_polio" required>
                                            <option value="2"
                                                {{ isset($blood_requisition_dtl_data->vaccine) && $blood_requisition_dtl_data->vaccine == 2 ? 'selected' : '' }}>
                                                No</option>
                                            <option value="1"
                                                {{ isset($blood_requisition_dtl_data->vaccine) && $blood_requisition_dtl_data->vaccine == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                        </select>
                                        <span class="error" id="oralError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Hepatitis immunoglobin-Defer for 12 months<span
                                                class="text-danger"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="hepatitis" name="hepatitis" required>
                                            <option value="2"
                                                {{ isset($blood_requisition_dtl_data->hepatitis) && $blood_requisition_dtl_data->hepatitis == 2 ? 'selected' : '' }}>
                                                No</option>
                                            <option value="1"
                                                {{ isset($blood_requisition_dtl_data->hepatitis) && $blood_requisition_dtl_data->hepatitis == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                        </select>
                                        <span class="error" id="hepatitisError"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" style="cursor: pointer">
                        Donor Physical Condition
                    </a>
                </div>
                <div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Hemoglobin <span style="color:red">
                                                *</span></strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control"
                                            id="hemoglobin" name="hemoglobin"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->hemoglobin : '' }}"
                                            required autocomplete="off">
                                        <span class="error" id="hemoglobinError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>BP <span style="color:red"> *</span></strong></div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="systolic"
                                                name="systolic" placeholder="Systolic"
                                                value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->systolic : '' }}"
                                                required autocomplete="off">
                                            <input type="text" class="form-control" id="diastolic"
                                                name="diastolic" placeholder="Diastolic"
                                                value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->diastolic : '' }}"
                                                required autocomplete="off">
                                        </div>
                                        <span class="error" id="BPError"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Pulse </strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control" id="Pulse"
                                            name="Pulse"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->pulse : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Blood Group <span style="color:red"> *</span></strong></div>
                                    <div class="col-md-7">

                                        <select class="form-control" id="blood_groupe" name="blood_groupe" required>
                                              @if (!empty($bloodg))
                                                @foreach ($bloodg as $key => $value)
                                                    @if ((!empty($blood_requisition_data) && $blood_requisition_data->blood_group == $value) || (!empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->blood_group == $value))
                                                        <option value="{{ $value }}" selected>
                                                            {{ $value }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Temparture </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="temparture" name="temparture"
                                            placeholder="fahrenheit" title="temparture"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->temparture : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Weight </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_weight"
                                            name="donor_weight" placeholder="kg" title="donor_weight"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_weight : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Height </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_height"
                                            name="donor_height" placeholder="cm" title="donor_height"
                                            value="{{ !empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->donor_height : '' }}">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>HB </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_hb" name="donor_hb" placeholder="" title="donor_hb" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->hb :''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Platelate </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_platelet" name="donor_platelet" placeholder="" title="donor_platelet" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->platelet :''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>HCT </strong></div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="donor_hct" name="donor_hct" placeholder="" title="donor_hct" value="{{!empty($blood_requisition_dtl_data) ? $blood_requisition_dtl_data->hct :''}}">
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <strong>For donating blood : </strong>
                    <label for="selected">Selected</label>
                    <input type="radio" name="selected_rejected" id="selected" value="Yes"
                        {{ !empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->is_selected_donate != '' && $blood_requisition_dtl_data->is_selected_donate == 'Yes' ? 'Checked' : '' }}
                        checked="checked">
                    <label for="rejected">Rejected</label>
                    <input type="radio" name="selected_rejected" id="rejected" value="No"
                        {{ !empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->is_selected_donate == 'No' ? 'Checked' : '' }}>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <a class="collapsed card-link" data-toggle="collapse" data-target="#collapseFour"
                        aria-expanded="false" aria-controls="collapseFour" style="cursor: pointer">
                        Donor's Questionnaries
                    </a>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Have you donated blood in the past?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="donated_past" name="donated_past">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->donated_past == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->donated_past == 2 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Last Blood Donation Date</strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control date-picker"
                                            id="last_blood_donation_date" name="last_blood_donation_date"
                                            value="{{ !empty($blood_requisition_dtl_data) && $blood_requisition_dtl_data->last_blood_donat_date != '' ? date('d-m-Y', strtotime($blood_requisition_dtl_data->last_blood_donat_date)) : '' }}"
                                            placeholder="dd-mm-yyyy"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Are you feeling today well?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="feeling_today_well"
                                            name="feeling_today_well">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->feeling_today_well == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->feeling_today_well == 2 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Did you have any reaction or discomfort on any
                                            previous donation?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="discomfort_donation"
                                            name="discomfort_donation">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->discomfort_donation == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->discomfort_donation == 2 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Any history of surgery (last 6 months)?</strong>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="surgery_history" name="surgery_history">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->surgery_history == 1 ? 'selected' : '' }}>
                                                Major</option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->surgery_history == 2 ? 'selected' : '' }}>
                                                minor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Do you practice safe sex?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="safe_sex" name="safe_sex">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->safe_sex == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->safe_sex == 1 ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Have you suffered from/had any of the
                                            following?</strong></div>
                                    <div class="col-md-7">
                                        <?php
                                        $suffered_from = explode(',', @$blood_requisition_dtl_data->suffered_from);
                                        ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="jaundice_hepatitis"
                                                value="1" name="suffered_from[]"
                                                {{ @$suffered_from && in_array(1, $suffered_from) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="jaundice_hepatitis">Jaundice/Hepatitis B/C(in the last one
                                                year)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="epilepsy"
                                                value="2" name="suffered_from[]"
                                                {{ @$suffered_from && in_array(2, $suffered_from) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="epilepsy">Epilepsy</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="cancer"
                                                value="3" name="suffered_from[]"
                                                {{ @$suffered_from && in_array(3, $suffered_from) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cancer">Cancer</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="fever_diarrhea"
                                                value="4" name="suffered_from[]"
                                                {{ @$suffered_from && in_array(4, $suffered_from) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="fever_diarrhea">Dental
                                                Extraction(last 6 months)</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lungs_disease"
                                                value="5" name="suffered_from[]"
                                                {{ @$suffered_from && in_array(5, $suffered_from) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="lungs_disease">Lungs Disease</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Did you suffer from these?</strong></div>
                                    <?php
                                    $did_you_suffer = explode(',', @$blood_requisition_dtl_data->did_you_suffer);
                                    ?>
                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="weight_loss"
                                                value="1" name="did_you_suffer[]"
                                                {{ @$did_you_suffer && in_array(1, $did_you_suffer) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="weight_loss">Unexplained weight
                                                loss</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="repeated_diarrhea"
                                                name="did_you_suffer[]" value="2"
                                                {{ @$did_you_suffer && in_array(2, $did_you_suffer) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox2">Repeated
                                                Diarrhea</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="night_sweating"
                                                value="3" name="did_you_suffer[]"
                                                {{ @$did_you_suffer && in_array(3, $did_you_suffer) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="night_sweating">Night
                                                sweating</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="fever_diarrhea"
                                                value="4" name="did_you_suffer[]"
                                                {{ @$did_you_suffer && in_array(4, $did_you_suffer) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="fever_diarrhea">Continuous low grade
                                                fever Diarrhea</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="lymph_node"
                                                value="5" name="did_you_suffer[]"
                                                {{ @$did_you_suffer && in_array(5, $did_you_suffer) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="lymph_node">Lymph node
                                                enlargement</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <a class="collapsed card-link" data-toggle="collapse" data-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree" style="cursor:pointer">
                        Females
                    </a>
                </div>
                <div id="collapseThree"class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>When did you have your last menstrual
                                            period?</strong></div>
                                    <div class="col-md-7"> <input type="text" class="form-control date-picker"
                                            id="last_menstrual_date" name="last_menstrual_date"
                                            value="{{ isset($blood_requisition_dtl_data->last_menstrual_date) ? date('d-m-Y', strtotime($blood_requisition_dtl_data->last_menstrual_date)) : '' }}"
                                            placeholder="dd-mm-yyyy" autocomplete="off"></div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Menstrual problem (excessive period)</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="menstrual_problem" name="menstrual_problem">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->abortion == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->abortion == 2 ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Are you pregnant (for married)?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="pregnant" name="pregnant">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->pregnant == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->pregnant == 2 ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Breast Feeding?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="breast_feeding" name="breast_feeding">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->breast_feeding == 1 ? 'selected' : '' }}>
                                                Major</option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->breast_feeding == 2 ? 'selected' : '' }}>
                                                minor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                                <div class="form-row">
                                    <div class="col-md-5"><strong>Abortion/MTP within last 3 months?</strong></div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="abortion" name="abortion">
                                            <option value="">select</option>
                                            <option value="1"
                                                {{ @$blood_requisition_dtl_data->abortion == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2"
                                                {{ @$blood_requisition_dtl_data->abortion == 2 ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" text-right mt-2">
            @php
                $url = $pat_id != '' ? route('ipd.blood-bank-requisition-worklist') : route('ipd.blood-bank-requisition-donor-list');
            @endphp
            <button type="button" class="btn btn-success btn-md btn-md-global uhl_common_btn">Save</button>
        </div>
    </form>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<!-- <script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script> -->
<script>
    // openDonorAutocomplete($('#donor_name'), 'donor_name', donorDetails);
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    function donorDetails(item, obj) {

        var currentDate = new Date(item.donor_dob);
        // $("#donor_age").datepicker("setDate", new Date(currentDate.getDate().toString().padStart(2, "0") + "-" + (currentDate.getMonth() + 1).toString().padStart(2, "0") + "-" + currentDate.getFullYear()));
        $('#donor_age').val(item.donor_age);
        $('#mobile').val(item.donor_mobile);
        $('#mobile').val(item.donor_mobile);
        $('#address').val(item.donor_address);
        $('#spouse_name').val(item.fatherorhousbend_name);
        $('#donor_profession').val(item.donor_profession);
        $('#marital_status').val(item.marital_status);
        $("#donor_gender option[value='" + item.donor_gender + "']").prop("selected", true);

    }

    document.querySelector('.uhl_common_btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission
        let isValid = true;
        document.querySelectorAll(".error").forEach(span => span.textContent = "");
        const status = document.querySelector('input[name="selected_rejected"]:checked').value;
        const donor_name = document.getElementById("donor_name").value.trim();
        if (!donor_name) {
            document.getElementById("donorNameError").textContent = "Donor Name is required.";
            isValid = false;
        }
        const donor_age = document.getElementById("donor_age").value.trim();
        if (!donor_age) {
            document.getElementById("ageError").textContent = "Donor age is required.";
            isValid = false;
        }
        const donor_gender = document.getElementById("donor_gender").value.trim();
        if (!donor_gender) {
            document.getElementById("genderError").textContent = "Gender is required.";
            isValid = false;
        }
        const mobile = document.getElementById("mobile").value.trim();
        if (!mobile) {
            document.getElementById("phoneError").textContent = "Phone no. is required.";
            isValid = false;
        }
        const address = document.getElementById("address").value.trim();
        if (!address) {
            document.getElementById("addressError").textContent = "Address is required.";
            isValid = false;
        }
        const spouse_name = document.getElementById("spouse_name").value.trim();
        if (!spouse_name) {
            document.getElementById("fatherError").textContent = "Father/Husband Name is required.";
            isValid = false;
        }
        const donor_type = document.getElementById("donor_type").value.trim();
        if (!donor_type) {
            document.getElementById("donorTypeError").textContent = "Donor type is required.";
            isValid = false;
        }
        const sleep = document.getElementById("sleep").value.trim();
        if (sleep == 2 && status == 'Yes') {
            document.getElementById("sleepError").textContent = "You selected No, so it should be rejected !!";
            isValid = false;
        }
        const breakfast_lunch = document.getElementById("breakfast_lunch").value.trim();
        if (breakfast_lunch == 2 && status == 'Yes') {
            document.getElementById("lunchError").textContent = "You selected No, so it should be rejected !!";
            isValid = false;
        }
        const taken_any = document.getElementById("taken_any").value.trim();
        if (taken_any == 1 && status == 'Yes') {
            document.getElementById("takenError").textContent = "You selected Yes, so it should be rejected !!";
            isValid = false;
        }
        const oral_polio = document.getElementById("oral_polio").value.trim();
        if (oral_polio == 1 && status == 'Yes') {
            document.getElementById("oralError").textContent = "You selected Yes, so it should be rejected !!";
            isValid = false;
        }
        const hepatitis = document.getElementById("hepatitis").value.trim();
        if (hepatitis == 1 && status == 'Yes') {
            document.getElementById("hepatitisError").textContent =
                "You selected Yes, so it should be rejected !!";
            isValid = false;
        }

        const hemoglobin = document.getElementById("hemoglobin").value.trim();
        if (!hemoglobin) {
            document.getElementById("hemoglobinError").textContent = "Hemoglobin is required.";
            isValid = false;
        } else if (!(hemoglobin >= 12 && hemoglobin <= 17.5) && status == 'Yes') {
            document.getElementById("hemoglobinError").textContent =
                "Hemoglobin is greater than 17.5/less than 12, so it should be rejected !!";
            isValid = false;
        }
        const systolic = document.getElementById("systolic").value.trim();
        const diastolic = document.getElementById("diastolic").value.trim();
        if (!systolic || !diastolic) {
            document.getElementById("BPError").textContent = "BP is required.";
            isValid = false;
        } else if ((!(systolic >= 100 && systolic <= 160) || !(diastolic >= 70 && diastolic <= 100)) &&
            status == 'Yes') {
            document.getElementById("BPError").textContent =
                "Systolic range should be 100-160, Diastolic range should be 70-100, otherwise it should be rejected !!";
            isValid = false;
        }
        if (isValid) {
            btnSaveUpdate(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                '{{ $url }}')
        }
    })
</script>
