<?php

$vitals = isset($vitals_data) && !empty($vitals_data) ? $vitals_data : [];

$txt_pulse = $vitals ? $vitals->pulse_val : '';
$txt_bp_sys = $vitals ? $vitals->bp_val_sys : '';
$txt_bp_dia = $vitals ? $vitals->bp_val_dia : '';
$txt_temperature = $vitals ? $vitals->temp_val : '';
$txt_height = $vitals ? $vitals->height_val : '';
$txt_weight = $vitals ? $vitals->weight_val : '';
$txt_bmi = $vitals ? $vitals->bmi : '';
$txt_heart_rate = $vitals ? $vitals->heart_condition : '';
$txt_ofc = $vitals ? $vitals->ofc : '';
$txt_spo2_value = $vitals ? $vitals->spo2_value : '';
$txt_rr_value = $vitals ? $vitals->rr_value : '';
$txt_lung = $vitals ? $vitals->lung_condition : '';
$txt_bowel = $vitals ? $vitals->bowel_condition : '';
$oxygen = $vitals ? $vitals->oxygen : '';
// dd($oxygen);
$respiration = $vitals ? $vitals->respiration : '';

?>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style type="text/css">
    #prescription_engin input.form-control,
    #prescription_engin select.form-control {
        height: calc(1em + 0.75rem + 0px) !important;
    }

    #prescription_engin .col-form-label-sm,
    #prescription_engin {
        font-size: .75rem;
    }

    #prescription_engin .card {
        border: 0 !important;
    }

    #pres-favourit-list {
        font-size: .75rem;
    }

    #pres-favourit-list td {
        background-color: #ECF0F5;
        border-top: 2px solid #fff;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        padding: 1px 10px !important;
    }

    .dataTables_filter {
        display: none;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    #presc_details .fa {
        font-size: 9px;
    }

    #presc_details .fa-star:hover {
        color: #38c172 !important;
    }

    .details_header {
        font-size: 11px;
    }

    .dropdown-item {
        padding: 0.25rem 1rem;
    }

    .dropdown-menu {
        padding: 0.5rem 0 0 0;
    }

    .alert-dismissible .close {
        padding: 0.05rem .5rem;
    }

    #dental-teeth-con .list-group .list-group-item {
        padding: 3px 5px !important;
        cursor: pointer;
        color: #fff;
    }

    .list-group-item-navy {
        background-color: #004B7B;
        transition: background-color 0.3s ease;
    }

    .list-group-item-blue {
        background-color: #007FD2;
        transition: background-color 0.3s ease;
    }

    .list-group-item-selected {
        background-color: #34B369
    }

    #dental-teeth-con .list-group .list-group-item:hover {
        background-color: #34B369;
    }

    #dental-teeth-con .list-group .list-group-item div {
        background-color: rgba(77, 171, 247, .7);
    }

    .data-table-inv.dataTable tbody th,
    .data-table-inv.dataTable tbody td {
        padding: 1px 10px !important;
    }

    #path_con_info {
        display: none;
    }

    .gyncology_clinical_history {
        padding-right: 30px;
        position: relative;
    }

    .gyncology_clinical_history_btn {
        position: absolute;
        top: 8px;
        right: 10px;
        /* transform: translateY(-50%); */
    }

    #examination ul {

        list-style: none;

        margin-bottom: 0px;

        padding-left: 25px;

    }



    #examination li {

        list-style: none;

        margin-bottom: 0px;

    }
</style>
<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0">Vitals Entry {{ $department_id == '' ? ' - External Hospital' : '' }}</h5>
                <small>Vitals / Vitals Entry</small>
            </div>
            <div class="col-8">

            </div>
        </div>

        <form method="post" id="frm-pat-prescription" action="{{ route('opd-nurse-station-vital-save-update') }}"
            autocomplete="off" onsubmit="">

            @csrf
            <input type="hidden" id="opd_nurse_vital_redirect_action" name="opd_nurse_vital_redirect_action"
                value="{{ route('appointments.opd-nurse-station') }}" />
            <input type="hidden" id="hdn_prescription_id" name="hdn_prescription_id" />
            <input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id"
                value="{{ $appointment_rs[0]->appoint_no_pk }}" />
            <input type="hidden" id="hdn_patient_id" name="hdn_patient_id"
                value="{{ $appointment_rs[0]->patient_no_pk }}" />
            <input type="hidden" id="hdn_service_id" name="hdn_service_id"
                value="{{ $appointment_rs[0]->su_no_fk }}" />
            <input type="hidden" id="hdn_doctor_id" name="hdn_doctor_id"
                value="{{ $appointment_rs[0]->doctor_no_fk }}" />
            @if ($department_id != '')
                <input type="hidden" id="hdn_su_no" name="hdn_su_no" value="{{ $department_id }}" />
            @endif
            <input type="hidden" id="hdn_external_ind" name="hdn_external_ind"
                value="{{ $department_id == '' ? 1 : 0 }}" />
            <input type="hidden" id="hdn_dental_ind" name="hdn_dental_ind"
                value="{{ !empty($su_info) ? $su_info->dental_ind : 0 }}" />
            <input type="hidden" id="hdn_eye_ind" name="hdn_eye_ind"
                value="{{ !empty($su_info) ? $su_info->eye_ind : 0 }}" />
            <input type="hidden" id="hdn_room_no" name="hdn_room_no" value="{{ $room_id }}" />
            <input type="hidden" id="hdn_current_url" name="hdn_current_url" value="{{ url()->full() }}" />
            <input type="hidden" id="hdn_favourite_route" name="hdn_favourite_route"
                value="{{ route('physiotherapy.load-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_pres_data_autocom" name="hdn_pres_data_autocom"
                value="{{ route('lookup-pres-data-autocomplete') }}" />
            <input type="hidden" id="hdn_add_pres_favourit_url" value="{{ route('add-pres-favourit-list') }}" />
            <input type="hidden" id="hdn_interaction_url" value="{{ route('presc-interaction') }}" />
            <div class="row border-bottom-dark">
                @if ($department_id == '')
                    <div class="form-row mt-1 mb-1 w-100">
                        <div class="col">
                            <select class="custom-select" name="hdn_su_no" id="hdn_su_no">
                                <option value="0">Select Department</option>
                                @if (!empty($su_arr))
                                    @foreach ($su_arr as $su_row)
                                        <option value="{{ $su_row->su_no_pk }}"
                                            data-dental-ind="{{ $su_row->dental_ind }}"
                                            data-eye-ind="{{ $su_row->eye_ind }}">{{ $su_row->su_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="service_id" name="service_id"
                                value="" placeholder="Search Patient By Service ID/ Name / Phone NO."
                                data-emr-route="{{ route('emr.patient-emr') }}"
                                title="Search Patient By Service ID/ Name / Phone NO."
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="patient_id" id="patient_id">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control bg-white" id="doctor_name" name="doctor_name"
                                value="" placeholder="Search Doctor By Name / Phone NO. / SPL."
                                title="Search Doctor By Name / Phone NO. / Specialization"
                                style="margin-bottom: 0 !important; padding: 12px 5px !important" />
                            <input type="hidden" name="doctor_id" id="doctor_id">
                        </div>
                        <div class="col">
                            <select class="custom-select" name="cmb_external_hospital">
                                <option value="0">Select Extarnal Hospital</option>
                                @if (!empty($extarnal_hospitals))
                                    @foreach ($extarnal_hospitals as $hkey => $hrow)
                                        <option value="{{ $hkey }}">{{ $hrow }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                @endif


                <div class="col-md-12 col-lg-12 col-sm-12 p-2 bg-white">
                    <h6 class="mt-3 mb-0"><strong>Patient Details</strong></h6>
                    <div class="card mt-0">
                        <div class="card-body pl-3 pr-3">
                            <div class="row border">
                                <div class="col-md-12 col-lg-6 col-sm-12 p-1 mb-2 border-right ">
                                    <div id="patient_info">

                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name" class="pl-2"> <strong>Name :
                                                    </strong>{{ $appointment_rs[0] ? $appointment_rs[0]->patient_name : '' }}
                                                </td>
                                                <td rowspan="5" width="100" class="p-2" id="patient_img"
                                                    data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    {{-- <img src="{{ asset('images/doc-1.png') }}" width="100"
                                                        alt=""> --}}
                                                    @if ($appointment_rs[0]->patient_photo != null)
                                                        <img src="{{ asset('images/uploads/patient_images/thumb/' . $appointment_rs[0]->patient_photo) }}"
                                                            width="100" alt="">
                                                    @else
                                                        <img src="{{ asset('images/doc-1.png') }}" width="100"
                                                            alt="">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong>UHID :
                                                    </strong>
                                                    {{ $appointment_rs[0] ? $appointment_rs[0]->patient_code : '' }},
                                                    <strong>Pt. Category :
                                                    </strong>{{ $appointment_rs[0] ? ucwords($appointment_rs[0]->patient_type_code) : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong> Gender : </strong>
                                                    {{ $appointment_rs[0] ? $appointment_rs[0]->gender_txt : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age" class="pl-2"> <strong> Age : </strong>
                                                    {{ $appointment_rs[0] ? $appointment_rs[0]->age : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td id="patient_mobile" class="pl-2"> <strong> Mobile No :
                                                    </strong>
                                                    {{ $appointment_rs[0] ? $appointment_rs[0]->mobile1 : '' }}
                                                    {{-- , <strong> Address :
                                                    </strong>
                                                    {{ $appointment_rs[0] ? $appointment_rs[0]->present_addr : 'N/A' }} --}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 col-lg-6 col-sm-12 p-1 border-right border-bottom">
                                    <!-- <div id="patient_info">
                                        <table width="100%" cellspacing="2" style="border-collapse: inherit;">
                                            <tr>
                                                <td id="patient_name_other" class="pl-2"></td>
                                                <td rowspan="2" width="30" class="p-2" id="ref_patient_img" data-path="{{ asset('img/uploads/patient_images/thumb') }}">
                                                    <img src="{{ asset('img/doc-1.png') }}" width="30" alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="patient_age_other" class="pl-2"></td>
                                            </tr>
                                        </table>
                                    </div> -->
                                    <div
                                        class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-right border-bottom pl-1">
                                        <input type="hidden" id="chronic-route"
                                            value="{{ route('add-chronic-disease') }}">
                                        <input type="hidden" id="chronic-route-save"
                                            value="{{ route('store-chronic-disease') }}">
                                        <input type="hidden" id="chronic-route-delete"
                                            value="{{ route('delete-chronic-disease') }}">
                                        <strong>Chronic Disease:</strong> <span id="chronic_con">

                                            @php
                                                $hdn_chro_name = '';
                                                $hdn_chor_text = '';

                                            @endphp
                                            @if ($chronic_disease)

                                                @foreach ($chronic_disease as $item)
                                                    <span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1"
                                                        style="font-size:10px;"
                                                        onclick="prescriptionFunc.addChronicItem(this)"
                                                        data-modal="common-modal-sm"
                                                        data-action="{{ route('add-chronic-disease') }}">{{ $item->chronic_dis_name }}</span>
                                                    @php
                                                        $hdn_chro_name .= $item->chronic_dis_item_pk_no_fk . '_' . $item->chronic_dis_name . '*';
                                                        $hdn_chor_text .= $item->chronic_dis_item_pk_no_fk . '_' . $item->chronic_dis_description . '*';
                                                    @endphp
                                                @endforeach

                                            @endif
                                        </span>
                                        <input type="hidden" class="form-control" id="chrn-items" name="chrn_items"
                                            value="{{ $hdn_chro_name }}" />
                                        <input type="hidden" class="form-control" id="chronic_text"
                                            name="chronic_text" value="{{ $hdn_chor_text }}">
                                        <span class="cursor-pointer float-right mt-1"
                                            onclick="prescriptionFunc.addChronicItem(this)"
                                            data-modal="common-modal-sm"
                                            data-action="{{ route('add-chronic-disease') }}"
                                            title="Add New Chronic Disease" style="font-size: 9px;"> <i
                                                class="fa fa-plus"></i> </span>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-sm-12 bg-light-blue border-bottom pl-1">
                                        <strong>Allergy:</strong>
                                        <span id="allergy_con">

                                            @php
                                                $hdn_allergie_name = '';
                                            @endphp
                                            @if ($allergie_data)

                                                @foreach ($allergie_data as $data)
                                                    <span id="allergy_data">

                                                        <span
                                                            class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal"
                                                            style="font-size:10px;" onclick=""
                                                            data-modal="common-modal-md"
                                                            data-action="{{ route('add-allergy') }}">{{ $data['allergies_name'] }}</span>
                                                        <sup> <i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2"
                                                                data-allergyId="{{ $data['pat_allergies_no_pk'] }}"></i></sup>
                                                        @php
                                                            $hdn_allergie_name .= $data['allergies_severity_lk_no_fk'] . '_' . $data['allergies_name'] . '*';
                                                        @endphp
                                                    </span>
                                                @endforeach

                                            @endif

                                        </span>

                                        <input type="hidden" class="form-control" id="allergie-items"
                                            name="allergie_items" value="{{ $hdn_allergie_name }}" />
                                        <span class="cursor-pointer float-right open-modal mt-1"
                                            data-modal="common-modal-md" data-action="{{ route('add-allergy') }}"
                                            title="Add New Allergy" data-title="Add New Allergy"
                                            style="font-size: 9px;"> <i class="fa fa-plus"></i> </span>
                                    </div>
                                </div> --}}
                            </div>


                            <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                                <div class="card mt-0">
                                    <div class="card-body pb-0">
                                        <div class="table-responsive">
                                            <table class="table border-0 m-0">
                                                <thead>
                                                    <tr class="border-0">
                                                        <th class="p-0 px-1 border-0">Pulse(bpm)</th>
                                                        <th class="p-0 px-1 border-0">BP(mmHg) <span
                                                                class="text-danger">*</span></th>
                                                        <th class="p-0 px-1 border-0">Temperature(°F)</th>
                                                        <th class="p-0 px-1 border-0">Respiration</th>
                                                        <th class="p-0 px-1 border-0">Spo2(%)</th>
                                                        <th class="p-0 px-1 border-0">Height(cm)</th>
                                                        <th class="p-0 px-1 border-0">Weight(kg)</th>
                                                        <th class="p-0 px-1 border-0">BMI(kg/m <sup>2</sup> )</th>
                                                        {{-- <th class="p-0 px-1 border-0">Oxygen</th> --}}
                                                        {{-- <th class="p-0 px-1 border-0">Assesment</th> --}}
                                                        <th class="p-0 px-1 border-0"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-0">
                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_pulse" name="txt_pulse"
                                                                value="{{ $txt_pulse }}" maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-28">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0 number_only"
                                                                    id="txt_bp_sys" name="txt_bp_sys"
                                                                    value="{{ $txt_bp_sys }}" maxlength="5"
                                                                    required>
                                                                &nbsp; / &nbsp;
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0 number_only"
                                                                    id="txt_bp_dia" name="txt_bp_dia"
                                                                    value="{{ $txt_bp_dia }}" maxlength="5"
                                                                    required>
                                                            </div>
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_temperature" name="txt_temperature"
                                                                value="{{ $txt_temperature }}" maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="respiration" name="respiration"
                                                                value="{{ $respiration }}" maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_spo2_value" name="txt_spo2_value"
                                                                value="{{ $txt_spo2_value }}" maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_height" name="txt_height"
                                                                value="{{ $txt_height }}" placeholder="eg.170 cm"
                                                                maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_weight" name="txt_weight"
                                                                value="{{ $txt_weight }}" placeholder="eg. 80 kg"
                                                                maxlength="5">
                                                        </td>

                                                        <td class="p-0 px-1 border-0 w-12">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="txt_bmi" name="txt_bmi"
                                                                value="{{ $txt_bmi }}" maxlength="5">
                                                        </td>
                                                        {{-- <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0 number_only"
                                                                id="oxygen" name="oxygen"
                                                                value="{{ $oxygen }}" maxlength="5">
                                                        </td> --}}
                                                        {{-- <td class="p-0 px-1 border-0">
                                                           <select class="form-control form-control-sm" name="option_for_wb" id="option_for_wb">
                                                             <option value="no">No</option>
                                                             <option value="yes">Yes</option>
                                                           </select>
                                                        </td>
                                                        <td class="p-0 px-1 border-0 d-none">
                                                            <input type="hidden" value="{{ $oxygen }}" id="oxygen_hdn_val" name="oxygen_hdn_val">
                                                            <select class="form-control form-control-sm" name="oxygen" id="oxygen">
                                                              <option value="0">Select</option>
                                                              <option value="Option A">Option A</option>
                                                              <option value="Option B">Option B</option>
                                                              <option value="Option C">Option C</option>
                                                              <option value="Option D">Option D</option>
                                                              <option value="Option E">Option E</option>
                                                            </select>
                                                        </td> --}}
                                                    </tr>
                                                </tbody>
                                            </table>

                                            {{-- @if (Session::get('user.ses_hospital_code') != 'DMHL')

                                            <table class="table border-0 m-0">
                                                <thead>

                                                    <tr>
                                                        <th class="p-0 px-1 border-0">Heart</th>
                                                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                            <th class="p-0 px-1 border-0">
                                                                OFC

                                                            </th>
                                                        @endif

                                                        <th class="p-0 px-1 border-0">SPO <sub>2</sub></th>
                                                        <th class="p-0 px-1 border-0">RR</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_heart_rate" name="txt_heart_rate"
                                                                value="{{ $txt_heart_rate }}">
                                                        </td>
                                                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                            <td class="p-0 px-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_ofc" name="txt_ofc"
                                                                    value="{{ $txt_ofc }}">
                                                            </td>
                                                        @endif

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_spo2_value" name="txt_spo2_value"
                                                                value="{{ $txt_spo2_value }}">
                                                        </td>

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_rr_value" name="txt_rr_value"
                                                                value="{{ $txt_rr_value }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table border-0 m-0">
                                                <thead>

                                                    <tr>
                                                        <th class="p-0 px-1 border-0">Lung </th>

                                                        <th class="p-0 px-1 border-0">
                                                            Bowel

                                                        </th>

                                                        <th class="p-0 px-1 border-0">Bladder</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_lung" name="txt_lung"
                                                                value="{{ $txt_lung }}">
                                                        </td>

                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_bowel" name="txt_bowel"
                                                                value="{{ $txt_bowel }}">
                                                        </td>


                                                        <td class="p-0 px-1 border-0">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_bladder" name="txt_bladder"
                                                                value="{{ $txt_bladder }}">
                                                        </td>


                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endif --}}

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
                    <div class="card border-0 bg-none">
                        <div class="card-body" id="presc_details">
                            @include('admin.prescription.v2.v2_vital_details_nurse_wise')
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <div class="modal fade" id="examination_modal" role="dialog" aria-labelledby="history_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">Clinical Examination</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">

                    @if (!empty($clinical_arr))

                        @if (count($clinical_arr) != 0)

                            @foreach ($clinical_arr as $history => $history_dtl)
                                <div class="row">
                                    <div class="col-md-12">
                                        <b>{{ $history }}</b>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="test345">
                                            @php
                                                $i = 0;
                                            @endphp
                                            @if (!empty($history_dtl))
                                                @foreach ($history_dtl as $history_item)
                                                    @php
                                                        $input_type = isset($history_item->input_type)
                                                            ? $history_item->input_type
                                                            : 'text';
                                                    @endphp
                                                    @if ($i == 0)
                                                        <div class="col-md-1">

                                                        </div>
                                                    @endif
                                                    <div class="col-md-2">
                                                        <p>{{ $history_item->detail_name }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="{{ $input_type }}"
                                                            class="form-control item_dtl_val" name="item_dtl_val[]">
                                                        <input type="hidden" class="form-control item_name "
                                                            name="item_name[]"
                                                            value="{{ $history_item->detail_name }}">
                                                        <input type="hidden" class="form-control lookup_id"
                                                            name="item_name[]"
                                                            value="{{ $history_item->pres_lookupdata_no_pk }}">
                                                        <input type="hidden" class="form-control pres_lookup_no_pk"
                                                            name="pres_lookup_no_pk[]"
                                                            value="{{ $history_item->pres_lookup_no_pk }}">
                                                        <input type="hidden" class="form-control lookup_code"
                                                            name="lookup_code[]"
                                                            value="{{ $history_item->pres_lookup_code }}">
                                                        <input type="hidden" class="form-control lookupdata_code"
                                                            name="lookupdata_code[]" value="{{ $history }}">

                                                    </div>

                                                    @php
                                                        $i++;
                                                        if ($i == 2) {
                                                            $i = 0;
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="modal-footer py-1">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"
                                        onclick="saveExamination()">Save</button>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        @endif
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available </h4>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="history_of_objective_modal" role="dialog" aria-labelledby="history_modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    @if (!empty($history_arr))
                        @foreach ($history_arr as $history => $history_dtl)
                            <div class="row">
                                <div class="col-md-12">
                                    <b>{{ $history }}</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="row" id="test123">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @if (!empty($history_dtl))
                                            @foreach ($history_dtl as $history_item)
                                                @php
                                                    $input_type = isset($history_item->input_type)
                                                        ? $history_item->input_type
                                                        : 'text';
                                                @endphp
                                                @if ($i == 0)
                                                    <div class="col-md-1">

                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <p>{{ $history_item->detail_name }}</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="{{ $input_type }}"
                                                        class="form-control item_dtl_val text-left"
                                                        name="item_dtl_val[]">
                                                    <input type="hidden" class="form-control item_name "
                                                        name="item_name[]" value="{{ $history_item->detail_name }}">
                                                    <input type="hidden" class="form-control lookup_id"
                                                        name="item_name[]"
                                                        value="{{ $history_item->pres_lookupdata_no_pk }}">
                                                    <input type="hidden" class="form-control pres_lookup_no_pk"
                                                        name="pres_lookup_no_pk[]"
                                                        value="{{ $history_item->pres_lookup_no_pk }}">
                                                    <input type="hidden" class="form-control lookup_code"
                                                        name="lookup_code[]"
                                                        value="{{ $history_item->pres_lookup_code }}">
                                                    <input type="hidden" class="form-control lookupdata_code"
                                                        name="lookupdata_code[]" value="{{ $history }}">

                                                </div>

                                                @php
                                                    $i++;
                                                    if ($i == 2) {
                                                        $i = 0;
                                                    }
                                                @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="modal-footer py-1">
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-success" data-dismiss="modal"
                                    onclick="saveMenstrual()">Save</button>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger text-center">No Setup Data Available</h4>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</section>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
    });
    openPatientAutocomplete('#service_id', 'hdn_patient_id', function(item, obj) {
        var patient_info_route = "{{ route('prescription.get-patient-info') }}";

        var dtls_action = "{{ route('get-prev-prescription-dtls', ':id') }}";
        var dtlsAction = dtls_action.replace(':id', item.patient_id);
        prescriptionFunc.getPatientDetails(item.patient_id, patient_info_route, dtlsAction);
        obj.stopImmediatePropagation();
    });


    $(document).on("change", "#option_for_wb", function(e) {
        var option_for_wb_val = $(this).find(':selected').val();
        if (option_for_wb_val == 'yes') {
            $("#oxygen").closest('td').removeClass('d-none');
        } else {
            $("#oxygen").closest('td').addClass('d-none');
            $("#oxygen").val('');
        }
    });

    $(document).ready(function() {
        var oxygen_hdn_val = $("#oxygen_hdn_val").val();
        if (oxygen_hdn_val != null && oxygen_hdn_val != 0) {
            $("#oxygen").closest('td').removeClass('d-none');
            $("#oxygen").val(oxygen_hdn_val);
            $("#option_for_wb").val('yes')
        } else {
            $("#option_for_wb").val('no')
            $("#oxygen").closest('td').addClass('d-none');
        }
    });

    $(document).on('click', '.remove_allergy', function() {
        event.preventDefault();
        var allergy_id = $(this).attr("data-allergyid");
        if (confirm("Are you sure")) {
            $(this).closest('span').remove();
            $.ajax({

                data: {
                    allergy_id: allergy_id
                },
                url: "{{ route('prescription.allergy-data-delete') }}",
                type: "post",
                beforeSend: function() {

                    // blockUI();
                },
                success: function(data) {
                    // var riderect_action = $("#hdn_current_url").val();
                    // $('.common-modal-notify').modal('show');
                    // $('.common-modal-notify .modal-body').html("Absent successful");
                    // dynamicFunc.afterSaveLoadPage(riderect_action);
                },

                complete: function() {
                    /*$(".data-table").DataTable({
                    	"ordering": false,
                    	"bPaginate": false,
                    	"bLengthChange": false,
                    	"bInfo": false,
                    	"bAutoWidth": false
                    });*/
                    $.unblockUI();
                }
            });
        }
        event.stopImmediatePropagation();
        //    $(this).parent().find("#allergy_data").remove();

    });

    $('body').on('keyup', '#txt_height', function() {
        // let height_to_meter = $(this).val() != "" ? $(this).val() * 0.0254 : 0; OLD
        // let height_to_meter = $(this).val() != "" ? $(this).val() * 0.01 : 0;
        // console.log(height_to_meter)
        // let weight = $('#txt_weight').val();
        // let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        // $('#txt_bmi').val(bmi.toFixed(1));


        let height_to_meter = $(this).val() != "" ? $(this).val() * 0.01 : 0;
        let weight = $('#txt_weight').val();
        let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#txt_bmi').val(bmi.toFixed(1));
    })

    $('body').on('keyup', '#txt_weight', function() {
        // let height_to_meter = $(this).val() != "" ? $(this).val() * 0.0254 : 0; OLD
        // let height_to_meter = $(this).val() != "" ? $(this).val() * 0.01 : 0;
        // let weight = $(this).val();
        // let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
        // $('#txt_bmi').val(bmi.toFixed(1));



        let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.01 : 0;
        let weight = $(this).val();
        let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#txt_bmi').val(bmi.toFixed(1));
    })






    $(document).on("click", ".patapp_absent", function(e) {
        var patapp_id = $(this).siblings('#patapp_hdn').val();
        if (confirm("Are you sure")) {
            $.ajax({

                data: {
                    patapp_id: patapp_id
                },
                url: "{{ route('prescription.appointment-absent') }}",
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    var riderect_action = $("#hdn_current_url").val();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("Absent successful");
                    dynamicFunc.afterSaveLoadPage(riderect_action);
                },

                complete: function() {
                    /*$(".data-table").DataTable({
                    	"ordering": false,
                    	"bPaginate": false,
                    	"bLengthChange": false,
                    	"bInfo": false,
                    	"bAutoWidth": false
                    });*/
                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();

    })

    openDoctorAutocomplete("#doctor_name", "hdn_doctor_id", function(item, obj) {
        $("#hdn_su_no").val(item.serviceunit_id);
        obj.stopImmediatePropagation();
    });

    $(document).ready(function() {
        var patTable = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "bAutoWidth": false
        });
        $(document).on("keyup", '#txtSearchPat', function() {
            patTable.search($(this).val()).draw();
        });

        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $(document).on("keyup", "#template_name", function(e) {
            $("#template_msg").html("");
            $(this).removeClass("is-invalid");
        });

        $(document).on("click", "#btn_emr", function(e) {
            var hdn_patient_id = $("#patapp_hdn").val();
            console.log(hdn_patient_id);
            if (hdn_patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                return;
            }

            window.open("{{ route('emr.patient-emr') }}/" + hdn_patient_id, "_blank");
        });

        $(document).on('show.bs.dropdown', '.btn_template', function() {
            var doctor_id = $("#hdn_doctor_id").val();
            var hdn_patient_id = $("#hdn_patient_id").val();
            if (hdn_patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
                return;
            }

            $("#template-container").html('<div class="d-flex justify-content-center"></div>');
            $.ajax({
                async: true,
                data: {
                    doctor_id: doctor_id
                },
                url: "{{ route('prescription-templates', 2) }}",
                type: "get",
                beforeSend: function() {
                    $("#template-container div").html(
                        '<i class="spinner-border spinner-border-sm"></i>');
                },
                success: function(data) {
                    $("#template-container").html(data);
                }
            });
        });

        $(document).on("change", "#cmb_type", function(e) {
            var type = $(this).find(':selected').val();
            // $('#free_text').removeAttr('required','required');
            // $('#medicine_item').removeAttr('required','required');
            // $('#cmb_allergy').removeAttr('required','required');
            if (type == "FLRG") {
                $('#allergy_con .twitter-typeahead').addClass('d-none');
                $('#cmb_allergy').removeClass('d-none');
                $('#free_text').addClass('d-none');
                $('#medicine_item').addClass('d-none');
                $('#cmb_allergy').attr('required', 'required');
                // alert("FLRG");
            } else if (type == "OLRG") {
                $('#allergy_con .twitter-typeahead').addClass('d-none');
                $('#cmb_allergy').addClass('d-none');
                $('#medicine_item').addClass('d-none');
                $('#free_text').removeClass('d-none');
                $('#free_text').attr('required', 'required');
            } else {
                $('#allergy_con .twitter-typeahead').removeClass('d-none');
                $('#cmb_allergy').addClass('d-none');
                $('#free_text').addClass('d-none');
                $('#medicine_item').removeClass('d-none');
                $('#medicine_item').attr('required', 'required');
            }
            //$('#medicine_item').typeahead();
        });

        $(document).on("change", "#hdn_su_no", function(e) {
            var hdn_su_no = $(this).val();
            $("#hdn_dental_ind").val($(this).find(":selected").attr("data-dental-ind") * 1);
            $("#hdn_eye_ind").val($(this).find(":selected").attr("data-eye-ind") * 1);

            var dtls_action = "{{ route('get-prev-prescription-dtls', 0) }}";
            prescriptionFunc.prescriptionDetails(hdn_su_no, dtls_action);
        });

    });
</script>
