<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Hemodialysis Record</h5>
                            <small>IPD / Nurse Station / Hemodialysis Record</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.hemodialysis-record-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('icu.hemodialysis-record-store') }}" method="post"
                                        id="docShiftHandoverForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="icu_hemodialysis_rec_no_pk"
                                            value="{{ isset($hemodialysis->icu_hemodialysis_rec_no_pk) ? $hemodialysis->icu_hemodialysis_rec_no_pk : '' }}">


                                        <div class="table-responsive">


                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td><strong>Age</strong> <input type="text" class="form-control"
                                                            value="{{ isset($patient_info->age) ? $patient_info->age : '' }}"
                                                            readonly></td>
                                                    <td><strong>Gender</strong> <input type="text"
                                                            class="form-control"
                                                            value="{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}"
                                                            readonly></td>
                                                    <td><strong>Consultant</strong> <input type="text"
                                                            class="form-control"
                                                            value="{{ $admission_info->primary_doctor_name }}"
                                                            readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="radio" name="iop" value="IP"
                                                                onclick="toggleWardICU()"
                                                                {{ isset($hemodialysis->iop) && $hemodialysis->iop == 'IP' ? 'checked' : '' }}>
                                                            <strong>IP</strong>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="iop" value="OP"
                                                                onclick="toggleWardICU()"
                                                                {{ isset($hemodialysis->iop) && $hemodialysis->iop == 'OP' ? 'checked' : '' }}>
                                                            <strong>OP</strong>
                                                        </label>
                                                    </td>
                                                    <td colspan="2">
                                                        Ward/ICU:
                                                        <input type="text" class="form-control" name="ward_icu"
                                                            id="ward_icu"
                                                            value="{{ isset($hemodialysis->ward_icu) ? $hemodialysis->ward_icu : '' }}"
                                                            readonly>
                                                    </td>
                                                </tr>

                                                @php
                                                    $prescrip =
                                                        json_decode($hemodialysis->prescrip ?? '[]', true) ?? [];
                                                @endphp
                                                <tr>
                                                    <td><strong>Dialysis Prescription:</strong></td>
                                                    <td>
                                                        <label><input type="checkbox" name="prescrip[]" value="HD"
                                                                {{ in_array('HD', $prescrip) ? 'checked' : '' }}>
                                                            HD</label>
                                                        <label><input type="checkbox" name="prescrip[]" value="SLED"
                                                                {{ in_array('SLED', $prescrip) ? 'checked' : '' }}>
                                                            SLED</label>
                                                        <label><input type="checkbox" name="prescrip[]" value="CRRT"
                                                                {{ in_array('CRRT', $prescrip) ? 'checked' : '' }}>
                                                            CRRT</label>
                                                        <label><input type="checkbox" name="prescrip[]"
                                                                value="PLASMA EXCHANGE"
                                                                {{ in_array('PLASMA EXCHANGE', $prescrip) ? 'checked' : '' }}>
                                                            PLASMA EXCHANGE</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="prescrip_other" class="form-control"
                                                            placeholder="if Others:"
                                                            value="{{ isset($hemodialysis->prescrip_other) ? $hemodialysis->prescrip_other : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Dialyser Surface Area:
                                                        <input type="text" class="form-control" name="dialyser_area"
                                                            value="{{ isset($hemodialysis->dialyser_area) ? $hemodialysis->dialyser_area : '' }}">
                                                    </td>
                                                    <td>Duration:
                                                        <input type="text" class="form-control" name="duration"
                                                            value="{{ isset($hemodialysis->duration) ? $hemodialysis->duration : '' }}">
                                                    </td>
                                                    <td>Dialysate Flow:
                                                        <input type="text" class="form-control" name="dialysate_flow"
                                                            value="{{ isset($hemodialysis->dialysate_flow) ? $hemodialysis->dialysate_flow : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Dry Weight:
                                                        <input type="text" class="form-control" name="dry_weight"
                                                            value="{{ isset($hemodialysis->dry_weight) ? $hemodialysis->dry_weight : '' }}">
                                                    </td>
                                                    <td>Ultra Filtration:
                                                        <input type="text" class="form-control"
                                                            name="ultra_filtration"
                                                            value="{{ isset($hemodialysis->ultra_filtration) ? $hemodialysis->ultra_filtration : '' }}">
                                                    </td>
                                                    <td>Dialysate Na⁺:
                                                        <input type="text" class="form-control"
                                                            name="dialysate_na"
                                                            value="{{ isset($hemodialysis->dialysate_na) ? $hemodialysis->dialysate_na : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Blood Flow:
                                                        <input type="text" class="form-control" name="blood_flow"
                                                            value="{{ isset($hemodialysis->blood_flow) ? $hemodialysis->blood_flow : '' }}">
                                                    </td>
                                                    <td>Blood Group & Rh:
                                                        <input type="text" class="form-control" name="blood_group"
                                                            value="{{ isset($hemodialysis->blood_group) ? $hemodialysis->blood_group : '' }}">
                                                    </td>
                                                    <td>Heparin:
                                                        <select name="heparin">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ isset($hemodialysis->heparin) && $hemodialysis->heparin == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($hemodialysis->heparin) && $hemodialysis->heparin == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Heparin Bolus:
                                                        <input type="text" class="form-control"
                                                            name="heparin_bolus"
                                                            value="{{ isset($hemodialysis->heparin_bolus) ? $hemodialysis->heparin_bolus : '' }}">
                                                        International Units
                                                    </td>
                                                    <td colspan="2">Maintenance:
                                                        <input type="text" name="heparin_maintenance"
                                                            value="{{ isset($hemodialysis->heparin_maintenance) ? $hemodialysis->heparin_maintenance : '' }}">
                                                        International Units X
                                                        <input type="text" name="heparin_hr"
                                                            value="{{ isset($hemodialysis->heparin_hr) ? $hemodialysis->heparin_hr : '' }}">
                                                        Hr
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">
                                                        If Heparin free, Reason:
                                                        <input type="text" class="form-control"
                                                            name="heparin_reason"
                                                            value="{{ isset($hemodialysis->heparin_reason) ? $hemodialysis->heparin_reason : '' }}">
                                                    </td>
                                                </tr>

                                            </table>
                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="4">
                                                        <h5><strong>TRANSFUSION HISTORY:</strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Last Hb%:
                                                        <input type="text" name="last_hb" class="form-control"
                                                            value="{{ isset($hemodialysis->last_hb) ? $hemodialysis->last_hb : '' }}">
                                                    </td>
                                                    <td>
                                                        Date of Test:
                                                        <input type="date" name="test_date" class="form-control"
                                                            value="{{ isset($hemodialysis->test_date) ? date('Y-m-d', strtotime($hemodialysis->test_date)) : '' }}">
                                                    </td>
                                                    <td>
                                                        Date of last Transfusion:
                                                        <input type="date" class="form-control" name="last_date"
                                                            value="{{ isset($hemodialysis->last_date) ? date('Y-m-d', strtotime($hemodialysis->last_date)) : '' }}">
                                                    </td>
                                                    <td>
                                                        Total No. of Transfusion:
                                                        <input type="text" class="form-control"
                                                            name="total_transfusion"
                                                            value="{{ isset($hemodialysis->total_transfusion) ? $hemodialysis->total_transfusion : '' }}">
                                                    </td>
                                                </tr>

                                                @php
                                                    $transfusionTypes =
                                                        json_decode($hemodialysis->prbc ?? '[]', true) ?? [];
                                                    $healthEduTypes =
                                                        json_decode($hemodialysis->health_edu ?? '[]', true) ?? [];
                                                @endphp

                                                <tr>
                                                    <td>Transfusion:</td>
                                                    <td colspan="3">
                                                        <label>
                                                            <input type="checkbox" name="prbc[]" value="PRBC"
                                                                {{ in_array('PRBC', $transfusionTypes) ? 'checked' : '' }}>
                                                            PRBC
                                                        </label>
                                                        No: <input type="text" name="prbc_no"
                                                            value="{{ isset($hemodialysis->prbc_no) ? $hemodialysis->prbc_no : '' }}">

                                                        <label>
                                                            <input type="checkbox" name="prbc[]" value="FFP"
                                                                {{ in_array('FFP', $transfusionTypes) ? 'checked' : '' }}>
                                                            FFP
                                                        </label>
                                                        No: <input type="text" name="ffp_no"
                                                            value="{{ isset($hemodialysis->ffp_no) ? $hemodialysis->ffp_no : '' }}">

                                                        <label>
                                                            <input type="checkbox" name="prbc[]" value="Albumin"
                                                                {{ in_array('Albumin', $transfusionTypes) ? 'checked' : '' }}>
                                                            Albumin
                                                        </label>
                                                        No: <input type="text" name="albumin_no"
                                                            value="{{ isset($hemodialysis->albumin_no) ? $hemodialysis->albumin_no : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <h5><strong>DOCTOR’S NOTES (Daily Clinical Assessment)</strong>
                                                        </h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="doctor_notes" placeholder="write here:" cols="196" rows="3">{{ isset($hemodialysis->doctor_notes) ? $hemodialysis->doctor_notes : '' }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                        <h5><strong>INVESTIGATION</strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pre HD:</td>
                                                    <td colspan="3">
                                                        <textarea name="pre_hd" rows="2" cols="180">{{ isset($hemodialysis->pre_hd) ? $hemodialysis->pre_hd : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Post HD:</td>
                                                    <td colspan="3">
                                                        <textarea name="post_hd" rows="2" cols="180">{{ isset($hemodialysis->post_hd) ? $hemodialysis->post_hd : '' }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <h5><strong>PATIENT / FAMILY HEALTH EDUCATION</strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <label>
                                                            <input type="checkbox" name="health_edu[]"
                                                                value="Access Care"
                                                                {{ in_array('Access Care', $healthEduTypes) ? 'checked' : '' }}>
                                                            Access Care
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="health_edu[]"
                                                                value="Infection Control"
                                                                {{ in_array('Infection Control', $healthEduTypes) ? 'checked' : '' }}>
                                                            Infection Control
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="health_edu[]"
                                                                value="Diet and Nutrition"
                                                                {{ in_array('Diet and Nutrition', $healthEduTypes) ? 'checked' : '' }}>
                                                            Diet and Nutrition
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="health_edu[]"
                                                                value="Medication Reconciliation"
                                                                {{ in_array('Medication Reconciliation', $healthEduTypes) ? 'checked' : '' }}>
                                                            Medication Reconciliation
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="health_edu[]" value="Others"
                                                                {{ in_array('Others', $healthEduTypes) ? 'checked' : '' }}>
                                                            Others
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <h5><strong>MEDICATION ADMINISTRATION RECORD</strong></h5>
                                                    </td>
                                                </tr>
                                            </table>

                                            @php

                                                $med_date = json_decode($hemodialysis->med_date ?? '[]', true) ?? [];
                                                $med_time = json_decode($hemodialysis->med_time ?? '[]', true) ?? [];
                                                $med_drug = json_decode($hemodialysis->med_drug ?? '[]', true) ?? [];
                                                $med_dose = json_decode($hemodialysis->med_dose ?? '[]', true) ?? [];
                                                $med_route = json_decode($hemodialysis->med_route ?? '[]', true) ?? [];
                                                $med_freq = json_decode($hemodialysis->med_freq ?? '[]', true) ?? [];
                                                $med_docsign =
                                                    json_decode($hemodialysis->med_docsign ?? '[]', true) ?? [];
                                                $med_admintime =
                                                    json_decode($hemodialysis->med_admintime ?? '[]', true) ?? [];
                                                $med_rnid = json_decode($hemodialysis->med_rnid ?? '[]', true) ?? [];
                                                $med_countersign =
                                                    json_decode($hemodialysis->med_countersign ?? '[]', true) ?? [];

                                                $hasData =
                                                    !empty($med_date) && is_array($med_date) && count($med_date) > 0;
                                            @endphp

                                            <h5>Medication Administration</h5>
                                            <table id="medTable" width="100%" border="1"
                                                style="margin-top:10px; border-collapse:collapse;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Name of Drug</th>
                                                        <th>Dose</th>
                                                        <th>Route</th>
                                                        <th>Frequency</th>
                                                        <th>Doctor Name</th>
                                                        <th>Administered Time</th>
                                                        <th>RN EMP</th>
                                                        <th>Counter Sign</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($hasData)
                                                        @for ($i = 0; $i < count($med_date); $i++)
                                                            <tr>
                                                                <td><input type="date" class="form-control"
                                                                        name="med_date[]"
                                                                        value="{{ isset($med_date[$i]) ? date('Y-m-d', strtotime($med_date[$i])) : '' }}">
                                                                </td>
                                                                <td><input type="time" class="form-control"
                                                                        name="med_time[]"
                                                                        value="{{ $med_time[$i] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="med_drug[]"
                                                                        value="{{ $med_drug[$i] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="med_dose[]"
                                                                        value="{{ $med_dose[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="med_route[]"
                                                                        value="{{ $med_route[$i] ?? '' }}">

                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="med_freq[]"
                                                                        value="{{ $med_freq[$i] ?? '' }}">
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="med_docsign[]"
                                                                        value="{{ $med_docsign[$i] ?? '' }}"
                                                                        id="med_docsign">

                                                                </td>
                                                                <td><input type="time" class="form-control"
                                                                        name="med_admintime[]"
                                                                        value="{{ $med_admintime[$i] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="med_rnid[]"
                                                                        value="{{ $med_rnid[$i] ?? '' }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="med_countersign[]"
                                                                        value="{{ $med_countersign[$i] ?? '' }}"></td>
                                                                <td><button type="button" class="btn-danger"
                                                                        onclick="removeRow(this,'medTable')">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- Empty row if no data --}}
                                                        <tr>
                                                            <td><input type="date" class="form-control"
                                                                    name="med_date[]"></td>
                                                            <td><input type="time" class="form-control"
                                                                    name="med_time[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="med_drug[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="med_dose[]"></td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="med_route[]">

                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="med_freq[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="med_docsign[]" id="med_docsign">
                                                                <input type="hidden" class="form-control"
                                                                    name="h_med_docsign" value="">
                                                            </td>
                                                            <td><input type="time" class="form-control"
                                                                    name="med_admintime[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="med_rnid[]" id="med_rnid">
                                                                <input type="hidden" class="form-control"
                                                                    name="h_med_rnid" value="">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="med_countersign[]"></td>
                                                            <td><button type="button" class="btn-danger"
                                                                    onclick="removeRow(this,'medTable')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            <div style="text-align:center; margin-top:10px;">
                                                <button type="button" class="add-btn" onclick="addRow('medTable')">+
                                                    Add More</button>
                                            </div>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <h5><strong>THERAPIST / NURSE RECORD</strong></h5>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Access:</strong></td>
                                                    <td>
                                                        @php
                                                            $access =
                                                                json_decode($hemodialysis->acess ?? '[]', true) ?? [];

                                                        @endphp
                                                        <label><input type="checkbox" name="acess[]" value="FC"
                                                                {{ in_array('FC', $access) ? 'checked' : '' }}>
                                                            FC</label>
                                                        <label><input type="checkbox" name="acess[]" value="IJC"
                                                                {{ in_array('IJC', $access) ? 'checked' : '' }}>
                                                            IJC</label>
                                                        <label><input type="checkbox" name="acess[]" value="SC"
                                                                {{ in_array('SC', $access) ? 'checked' : '' }}>
                                                            SC</label>
                                                        <label><input type="checkbox" name="acess[]" value="Permcath"
                                                                {{ in_array('Permcath', $access) ? 'checked' : '' }}>
                                                            Permcath</label>
                                                        <label><input type="checkbox" name="acess[]"
                                                                value="AVF (Radial)"
                                                                {{ in_array('AVF (Radial)', $access) ? 'checked' : '' }}>
                                                            AVF (Radial)</label>
                                                        <label><input type="checkbox" name="acess[]"
                                                                value="AVF (Brachial)"
                                                                {{ in_array('AVF (Brachial)', $access) ? 'checked' : '' }}>
                                                            AVF (Brachial)</label>
                                                        <label><input type="checkbox" name="acess[]" value="others"
                                                                {{ in_array('others', $access) ? 'checked' : '' }}>
                                                            Others</label>
                                                    </td>
                                                    <td>Right / Left:
                                                        <select name="side">
                                                            <option value="">Select</option>
                                                            <option value="right"
                                                                {{ @$hemodialysis->side == 'right' ? 'selected' : '' }}>
                                                                Right</option>
                                                            <option value="left"
                                                                {{ @$hemodialysis->side == 'left' ? 'selected' : '' }}>
                                                                Left</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Temporary Access Placed on (If Present):
                                                        <input type="text" name="temp_access"
                                                            value="{{ @$hemodialysis->temp_access }}">
                                                    </td>
                                                    <td colspan="2" style="text-align: center;">
                                                        <strong>AVF</strong>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Heparin/Antibiotic Lock Aspirated:
                                                        <select name="heparin2">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->heparin2 == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->heparin2 == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2">Created On:
                                                        <input type="date" name="created_on"
                                                            value="{{ isset($hemodialysis->created_on) ? date('Y-m-d', strtotime($hemodialysis->created_on)) : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="3"> Catheter Access Site:
                                                        @php
                                                            $catheter =
                                                                json_decode(
                                                                    $hemodialysis->catheter_site ?? '[]',
                                                                    true,
                                                                ) ?? [];

                                                        @endphp
                                                        <label><input type="checkbox" name="catheter_site[]"
                                                                value="Abnormal"
                                                                {{ in_array('Abnormal', $catheter) ? 'checked' : '' }}>
                                                            Abnormal</label>
                                                        <label><input type="checkbox" name="catheter_site[]"
                                                                value="Redness"
                                                                {{ in_array('Redness', $catheter) ? 'checked' : '' }}>
                                                            Redness</label>
                                                        <label><input type="checkbox" name="catheter_site[]"
                                                                value="Warmth"
                                                                {{ in_array('Warmth', $catheter) ? 'checked' : '' }}>
                                                            Warmth</label>
                                                        <label><input type="checkbox" name="catheter_site[]"
                                                                value="Pus"
                                                                {{ in_array('Pus', $catheter) ? 'checked' : '' }}>
                                                            Pus</label>
                                                    </td>
                                                    <td colspan="2">Ischemic Symptoms:
                                                        <select name="ischemic">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->ischemic == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->ischemic == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Outflow Stenosis:
                                                        <select name="outflow">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->outflow == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->outflow == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>Collapse of vein:
                                                        <select name="collapse_vein">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->collapse_vein == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->collapse_vein == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select> <br>
                                                        Water hammer Pulse:
                                                        <select name="water_pulse">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->water_pulse == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->water_pulse == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Inflow Stenosis:
                                                        <select name="inflow">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->inflow == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->inflow == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>Continuous Bruit:
                                                        <select name="bruit">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->bruit == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->bruit == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select> <br>
                                                        Pulse Augmentation:
                                                        <select name="pulse_aug">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->pulse_aug == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->pulse_aug == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">Sign of Technician:
                                                        <input type="text" name="tech_sign" id="tech_sign"
                                                            value="{{ @$hemodialysis->tech_sign }}">
                                                        <input type="hidden" name="h_tech_sign"
                                                            value="{{ @$hemodialysis->h_tech_sign }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td>Self-test of machine alarms passed:
                                                        <select name="alarm_pass">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->alarm_pass == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->alarm_pass == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>Terminated By:
                                                        <input type="text" name="terminated_by" id="terminated_by"
                                                            value="{{ @$hemodialysis->terminated_by }}">
                                                        <input type="hidden" name="h_terminated_by"
                                                            value="{{ @$hemodialysis->h_terminated_by }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Dialysate pH between 6.5 & 7.5 with pH Meter:
                                                        <select name="dialysate_ph">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->dialysate_ph == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->dialysate_ph == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>Kt/V (if applicable):
                                                        <input type="text" name="ktv"
                                                            value="{{ @$hemodialysis->ktv }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Renalin trace in effluent after priming:
                                                        <select name="renalin_trace">
                                                            <option value="">Select</option>
                                                            <option value="Present"
                                                                {{ @$hemodialysis->renalin_trace == 'Present' ? 'selected' : '' }}>
                                                                Present</option>
                                                            <option value="Absent"
                                                                {{ @$hemodialysis->renalin_trace == 'Absent' ? 'selected' : '' }}>
                                                                Absent</option>
                                                        </select>
                                                    </td>
                                                    <td>Vascular Access Haemostasis Achieved:
                                                        <select name="haemostasis">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->haemostasis == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->haemostasis == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Pressure Leak test passed:
                                                        <select name="pressure_test">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->pressure_test == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->pressure_test == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>Machine No:
                                                        <input type="text" name="machine_no"
                                                            value="{{ @$hemodialysis->machine_no }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Priming done by:
                                                        <input type="text" name="priming_by" id="priming_by"
                                                            value="{{ @$hemodialysis->priming_by }}">
                                                        <input type="hidden" name="h_priming_by" id="h_priming_by"
                                                            value="{{ @$hemodialysis->h_priming_by }}">
                                                    </td>
                                                    <td>Dialyzer:
                                                        <input type="text" name="dialyzer" id="dialyzer"
                                                            value="{{ @$hemodialysis->dialyzer }}">
                                                        <input type="hidden" name="h_dialyzer" id="h_dialyzer"
                                                            value="{{ @$hemodialysis->h_dialyzer }}">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <h5><strong>TIME OUT CHECKLIST</strong></h5>
                                                        (To be read out loud)The Following have been verified and
                                                        confirmed:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $timeoutchecklist =
                                                            json_decode(
                                                                $hemodialysis->timeoutchecklist ?? '[]',
                                                                true,
                                                            ) ?? [];

                                                    @endphp

                                                    <td colspan="4">
                                                        <input type="checkbox" name="timeoutchecklist[]"
                                                            value="Patient"
                                                            {{ in_array('Patient', $timeoutchecklist) ? 'checked' : '' }}>
                                                        Correct Patient <br>

                                                        <input type="checkbox" name="timeoutchecklist[]"
                                                            value="Site"
                                                            {{ in_array('Site', $timeoutchecklist) ? 'checked' : '' }}>
                                                        Correct Site & Side Confirmed <br>

                                                        <input type="checkbox" name="timeoutchecklist[]"
                                                            value="Consent"
                                                            {{ in_array('Consent', $timeoutchecklist) ? 'checked' : '' }}>
                                                        Consent for Procedure <br>

                                                        <input type="checkbox" name="timeoutchecklist[]"
                                                            value="documents"
                                                            {{ in_array('documents', $timeoutchecklist) ? 'checked' : '' }}>
                                                        All relevant documents <br>

                                                        <input type="checkbox" name="timeoutchecklist[]"
                                                            value="Medical"
                                                            {{ in_array('Medical', $timeoutchecklist) ? 'checked' : '' }}>
                                                        Appropriate Medical Technology available and working (E.g.
                                                        Dialyzer and Blood Tubing)
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Nurse Name:
                                                        <input type="text" name="nurse_sign" id="nurse_sign"
                                                            value="{{ @$hemodialysis->nurse_sign }}">
                                                        <input type="hidden" name="h_nurse_sign"
                                                            value="{{ @$hemodialysis->h_nurse_sign }}">
                                                    </td>
                                                    <td colspan="2">Technician Name:
                                                        <input type="text" name="tech_sign2" id="tech_sign2"
                                                            value="{{ @$hemodialysis->tech_sign2 }}">
                                                        <input type="hidden" name="h_tech_sign2"
                                                            value="{{ @$hemodialysis->h_tech_sign2 }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td class="text-center">
                                                        <h5><strong>PRE HD</strong></h5>
                                                    </td>
                                                    <td class="text-center">
                                                        <h5><strong>POST HD</strong></h5>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Patient Entry Time:
                                                        @php $pre_entry_time = explode(' ', @$hemodialysis->pre_entry_time); @endphp
                                                        <input type="time" name="pre_entry_time"
                                                            value="{{ $pre_entry_time[1] ?? '' }}">
                                                    </td>
                                                    <td>Time of Termination:
                                                        @php $post_termination = explode(' ', @$hemodialysis->post_termination); @endphp
                                                        <input type="time" name="post_termination"
                                                            value="{{ $post_termination[1] ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>BP: <input type="text" name="pre_bp"
                                                            value="{{ @$hemodialysis->pre_bp }}"> &nbsp;mmhg</td>
                                                    <td>BP: <input type="text" name="post_bp"
                                                            value="{{ @$hemodialysis->post_bp }}"> &nbsp;mmhg</td>
                                                </tr>

                                                <tr>
                                                    <td>SpO₂: <input type="text" name="pre_spo2"
                                                            value="{{ @$hemodialysis->pre_spo2 }}"> &nbsp;%</td>
                                                    <td>SpO₂: <input type="text" name="post_spo2"
                                                            value="{{ @$hemodialysis->post_spo2 }}"> &nbsp;%</td>
                                                </tr>

                                                <tr>
                                                    <td>Pulse: <input type="text" name="pre_pulse"
                                                            value="{{ @$hemodialysis->pre_pulse }}"> &nbsp;/min</td>
                                                    <td>Pulse: <input type="text" name="post_pulse"
                                                            value="{{ @$hemodialysis->post_pulse }}"> &nbsp;/min</td>
                                                </tr>

                                                <tr>
                                                    <td>Temp: <input type="text" name="pre_temp"
                                                            value="{{ @$hemodialysis->pre_temp }}"> &nbsp;°F</td>
                                                    <td>Temp: <input type="text" name="post_temp"
                                                            value="{{ @$hemodialysis->post_temp }}"> &nbsp;°F</td>
                                                </tr>

                                                <tr>
                                                    <td>Weight: <input type="text" name="pre_weight"
                                                            value="{{ @$hemodialysis->pre_weight }}"> &nbsp;kg</td>
                                                    <td>Weight: <input type="text" name="post_weight"
                                                            value="{{ @$hemodialysis->post_weight }}"> &nbsp;kg</td>
                                                </tr>

                                                <tr>
                                                    <td>Weight Gain: <input type="text" name="weight_gain"
                                                            value="{{ @$hemodialysis->weight_gain }}"> &nbsp;kg</td>
                                                    <td>Weight Loss: <input type="text" name="weight_loss"
                                                            value="{{ @$hemodialysis->weight_loss }}"> &nbsp;kg</td>
                                                </tr>

                                                <tr>
                                                    <td>Sensorium:
                                                        <select name="pre_sensorium">
                                                            <option value="">Select</option>
                                                            <option value="Alert"
                                                                {{ @$hemodialysis->pre_sensorium == 'Alert' ? 'selected' : '' }}>
                                                                Alert</option>
                                                            <option value="Drowsy"
                                                                {{ @$hemodialysis->pre_sensorium == 'Drowsy' ? 'selected' : '' }}>
                                                                Drowsy</option>
                                                        </select>
                                                    </td>
                                                    <td>Sensorium:
                                                        <select name="post_sensorium">
                                                            <option value="">Select</option>
                                                            <option value="Alert"
                                                                {{ @$hemodialysis->post_sensorium == 'Alert' ? 'selected' : '' }}>
                                                                Alert</option>
                                                            <option value="Drowsy"
                                                                {{ @$hemodialysis->post_sensorium == 'Drowsy' ? 'selected' : '' }}>
                                                                Drowsy</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Starting Time:
                                                        @php $pre_start_time = explode(' ', @$hemodialysis->pre_start_time); @endphp
                                                        <input type="time" name="pre_start_time"
                                                            value="{{ $pre_start_time[1] ?? '' }}">
                                                    </td>
                                                    <td>Patient Exit Time:
                                                        @php $post_exit_time = explode(' ', @$hemodialysis->post_exit_time); @endphp
                                                        <input type="time" name="post_exit_time"
                                                            value="{{ $post_exit_time[1] ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Started By:
                                                        <input type="text" name="started_by" id="started_by"
                                                            value="{{ @$hemodialysis->started_by }}">
                                                        <input type="hidden" name="h_started_by"
                                                            value="{{ @$hemodialysis->h_started_by }}">
                                                    </td>
                                                    <td>Discharge Criteria Met:
                                                        <select name="discharge">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$hemodialysis->discharge == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$hemodialysis->discharge == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Name of Staff who received patient:
                                                        <input type="text" name="pre_staff" id="pre_staff"
                                                            value="{{ @$hemodialysis->pre_staff }}">
                                                        <input type="hidden" name="h_pre_staff"
                                                            value="{{ @$hemodialysis->h_pre_staff }}">
                                                    </td>
                                                    <td>Name of Staff who sent patient:
                                                        <input type="text" name="post_staff" id="post_staff"
                                                            value="{{ @$hemodialysis->post_staff }}">
                                                        <input type="hidden" name="h_post_staff"
                                                            value="{{ @$hemodialysis->h_post_staff }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            @php
                                                $pain_time = json_decode($hemodialysis->pain_time ?? '[]', true) ?? [];
                                                $pain_factor =
                                                    json_decode($hemodialysis->pain_factor ?? '[]', true) ?? [];
                                                $pain_type = json_decode($hemodialysis->pain_type ?? '[]', true) ?? [];
                                                $pain_location =
                                                    json_decode($hemodialysis->pain_location ?? '[]', true) ?? [];
                                                $pain_score =
                                                    json_decode($hemodialysis->pain_score ?? '[]', true) ?? [];
                                                $pain_freq = json_decode($hemodialysis->pain_freq ?? '[]', true) ?? [];
                                                $pain_duration =
                                                    json_decode($hemodialysis->pain_duration ?? '[]', true) ?? [];
                                                $pain_time2 =
                                                    json_decode($hemodialysis->pain_time2 ?? '[]', true) ?? [];
                                                $pain_intervention =
                                                    json_decode($hemodialysis->pain_intervention ?? '[]', true) ?? [];
                                                $pain_time3 =
                                                    json_decode($hemodialysis->pain_time3 ?? '[]', true) ?? [];
                                                $pain_postscore =
                                                    json_decode($hemodialysis->pain_postscore ?? '[]', true) ?? [];

                                                $hasPainData =
                                                    !empty($pain_time) && is_array($pain_time) && count($pain_time) > 0;
                                            @endphp

                                            <table id="painTable" width="100%" border="1"
                                                style="margin-top:10px; border-collapse:collapse;">
                                                <thead>
                                                    <tr>
                                                        <td colspan="12">
                                                            <h5><strong>MONITORING DURING DIALYSIS</strong></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="12">PAIN ASSESSMENT</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2">Time</th>
                                                        <th colspan="5">Pain</th>
                                                        <th rowspan="2">Duration</th>
                                                        <th rowspan="2">Time</th>
                                                        <th rowspan="2">Intervention</th>
                                                        <th rowspan="2">Time</th>
                                                        <th rowspan="2">Post Intervention Score</th>
                                                        <th rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Precipitating Factor</th>
                                                        <th>Type</th>
                                                        <th>Location</th>
                                                        <th>Pain Score</th>
                                                        <th>Frequency</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @if ($hasPainData)
                                                        @for ($i = 0; $i < count($pain_time); $i++)
                                                            <tr>
                                                                <td><input type="time" name="pain_time[]"
                                                                        value="{{ $pain_time[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_factor[]"
                                                                        value="{{ $pain_factor[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_type[]"
                                                                        value="{{ $pain_type[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_location[]"
                                                                        value="{{ $pain_location[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_score[]"
                                                                        value="{{ $pain_score[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <select name="pain_freq[]">
                                                                        <option value="">Select</option>
                                                                        <option value="Constant"
                                                                            {{ ($pain_freq[$i] ?? '') == 'Constant' ? 'selected' : '' }}>
                                                                            Constant</option>
                                                                        <option value="Intermittent"
                                                                            {{ ($pain_freq[$i] ?? '') == 'Intermittent' ? 'selected' : '' }}>
                                                                            Intermittent</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="pain_duration[]"
                                                                        value="{{ $pain_duration[$i] ?? '' }}"></td>
                                                                <td><input type="time" name="pain_time2[]"
                                                                        value="{{ $pain_time2[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_intervention[]"
                                                                        value="{{ $pain_intervention[$i] ?? '' }}">
                                                                </td>
                                                                <td><input type="time" name="pain_time3[]"
                                                                        value="{{ $pain_time3[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="pain_postscore[]"
                                                                        value="{{ $pain_postscore[$i] ?? '' }}"></td>
                                                                <td><button type="button" class="btn-danger"
                                                                        onclick="removeRow(this,'painTable')">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- Empty Row --}}
                                                        <tr>
                                                            <td><input type="time" name="pain_time[]"></td>
                                                            <td><input type="text" name="pain_factor[]"></td>
                                                            <td><input type="text" name="pain_type[]"></td>
                                                            <td><input type="text" name="pain_location[]"></td>
                                                            <td><input type="text" name="pain_score[]"></td>
                                                            <td>
                                                                <select name="pain_freq[]">
                                                                    <option value="">Select</option>
                                                                    <option value="Constant">Constant</option>
                                                                    <option value="Intermittent">Intermittent</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="pain_duration[]"></td>
                                                            <td><input type="time" name="pain_time2[]"></td>
                                                            <td><input type="text" name="pain_intervention[]"></td>
                                                            <td><input type="time" name="pain_time3[]"></td>
                                                            <td><input type="text" name="pain_postscore[]"></td>
                                                            <td><button type="button" class="btn-danger"
                                                                    onclick="removeRow(this,'painTable')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="12">
                                                            Precipitating factor:
                                                            position/activity/stress/movement-walking/standing/lying/bending.
                                                            Type of pain: sharp/Dull/Cramping/shooting/Pricking.
                                                            If the pain score >2, inform doctor, follow doctor’s order
                                                            and reassess pain.
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <div style="text-align:center; margin-top:10px;">
                                                <button type="button" class="add-btn"
                                                    onclick="addRow('painTable')">+
                                                    Add More</button>
                                            </div>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="2" style="text-align: center;">
                                                        <h5><strong>FALL RISK ASSESSMENT AND SAFETY PRECAUTION</strong>
                                                        </h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Adult fall risk screening</th>
                                                    <th>Yes/No</th>
                                                </tr>
                                                <tr>
                                                    <td>History of falling within past 3 months</td>
                                                    <td>
                                                        <select name="fall_history">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_history ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_history ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ambulatory aids</td>
                                                    <td>
                                                        <select name="fall_ambulation">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_ambulation ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_ambulation ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Wheelchair</td>
                                                    <td>
                                                        <select name="wheel_chair">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->wheel_chair ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->wheel_chair ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Crutches/cane/walker</td>
                                                    <td>
                                                        <select name="crutches">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->crutches ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->crutches ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Uses furniture for support</td>
                                                    <td>
                                                        <select name="furniture">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->furniture ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->furniture ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Gait / Transferring</td>
                                                    <td>
                                                        <select name="fall_gait">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_gait ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_gait ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Bedrest/immobile</td>
                                                    <td>
                                                        <select name="fall_immobile">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_immobile ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_immobile ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Weak</td>
                                                    <td>
                                                        <select name="fall_weak">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_weak ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_weak ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Impaired</td>
                                                    <td>
                                                        <select name="fall_impaired">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->fall_impaired ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->fall_impaired ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mental status</td>
                                                    <td>
                                                        <select name="mental">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->mental ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->mental ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>• Forget limitations</td>
                                                    <td>
                                                        <select name="limitations">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ ($hemodialysis->limitations ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ ($hemodialysis->limitations ?? '') == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Paediatrics/Neonates fall prevention measures –
                                                        up to 16 years</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">All Paediatrics/neonates are considered to be
                                                        risk for all. Follow the fall prevention measures:</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        @php
                                                            $safety_measures =
                                                                json_decode(
                                                                    $hemodialysis->safety_measures ?? '[]',
                                                                    true,
                                                                ) ?? [];

                                                        @endphp
                                                        <label>
                                                            <input type="checkbox" name="safety_measures[]"
                                                                value="accompanied"
                                                                {{ in_array('accompanied', $safety_measures) ? 'checked' : '' }}>
                                                            Ensure child is carried/accompanied by patients/care takers
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="safety_measures[]"
                                                                value="escorted"
                                                                {{ in_array('escorted', $safety_measures) ? 'checked' : '' }}>
                                                            Escort while shifting or moving in wheelchair/stretcher
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="safety_measures[]"
                                                                value="secured"
                                                                {{ in_array('secured', $safety_measures) ? 'checked' : '' }}>
                                                            Child is secured with safety belts while on
                                                            wheelchair/stretcher
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="safety_measures[]"
                                                                value="educated"
                                                                {{ in_array('educated', $safety_measures) ? 'checked' : '' }}>
                                                            Educate family members on fall prevention measures
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Note: If patient is "Yes" to any above, follow
                                                        prevention measures:</th>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $escort =
                                                            json_decode($hemodialysis->escort ?? '[]', true) ?? [];

                                                    @endphp
                                                    <td>
                                                        <label><input type="checkbox" name="escort[]" value="escort"
                                                                {{ in_array('escort', $escort) ? 'checked' : '' }}>
                                                            Escort with shifting/moving</label><br>
                                                        <label><input type="checkbox" name="escort[]"
                                                                value="seatbelt"
                                                                {{ in_array('seatbelt', $escort) ? 'checked' : '' }}>
                                                            Patient secured with seatbelt</label>
                                                    </td>
                                                    <td>
                                                        <label><input type="checkbox" name="escort[]" value="assist"
                                                                {{ in_array('assist', $escort) ? 'checked' : '' }}>
                                                            Assist the patient</label><br>
                                                        <label><input type="checkbox" name="escort[]" value="educate"
                                                                {{ in_array('educate', $escort) ? 'checked' : '' }}>
                                                            Educate patient/family</label>
                                                    </td>
                                                </tr>
                                            </table>


                                            @php

                                                $mon_time = json_decode($hemodialysis->mon_time ?? '[]', true) ?? [];
                                                $mon_pulse = json_decode($hemodialysis->mon_pulse ?? '[]', true) ?? [];
                                                $mon_bp = json_decode($hemodialysis->mon_bp ?? '[]', true) ?? [];
                                                $mon_ufrate =
                                                    json_decode($hemodialysis->mon_ufrate ?? '[]', true) ?? [];
                                                $mon_ufvol = json_decode($hemodialysis->mon_ufvol ?? '[]', true) ?? [];
                                                $mon_vp = json_decode($hemodialysis->mon_vp ?? '[]', true) ?? [];
                                                $mon_ap = json_decode($hemodialysis->mon_ap ?? '[]', true) ?? [];
                                                $mon_bflow = json_decode($hemodialysis->mon_bflow ?? '[]', true) ?? [];
                                                $mon_spo2 = json_decode($hemodialysis->mon_spo2 ?? '[]', true) ?? [];
                                                $mon_bleeding =
                                                    json_decode($hemodialysis->mon_bleeding ?? '[]', true) ?? [];
                                                $mon_remarks =
                                                    json_decode($hemodialysis->mon_remarks ?? '[]', true) ?? [];

                                                $hasMonData =
                                                    !empty($mon_time) && is_array($mon_time) && count($mon_time) > 0;
                                            @endphp

                                            <table id="monitorTable" width="100%" border="1"
                                                style="margin-top:10px; border-collapse:collapse;">
                                                <thead>
                                                    <tr>
                                                        <td colspan="12">
                                                            <h5><strong>MONITORING CHART</strong></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Pulse /min</th>
                                                        <th>BP mmHg</th>
                                                        <th>UF Rate</th>
                                                        <th>UF Volume</th>
                                                        <th>Venous Pressure</th>
                                                        <th>Arterial Pressure</th>
                                                        <th>Blood Flow</th>
                                                        <th>SpO2</th>
                                                        <th>Bleeding from access site</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($hasMonData)
                                                        @for ($i = 0; $i < count($mon_time); $i++)
                                                            <tr>
                                                                <td><input type="time" name="mon_time[]"
                                                                        value="{{ $mon_time[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_pulse[]"
                                                                        value="{{ $mon_pulse[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_bp[]"
                                                                        value="{{ $mon_bp[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_ufrate[]"
                                                                        value="{{ $mon_ufrate[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_ufvol[]"
                                                                        value="{{ $mon_ufvol[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_vp[]"
                                                                        value="{{ $mon_vp[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_ap[]"
                                                                        value="{{ $mon_ap[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_bflow[]"
                                                                        value="{{ $mon_bflow[$i] ?? '' }}"></td>
                                                                <td><input type="text" name="mon_spo2[]"
                                                                        value="{{ $mon_spo2[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <select name="mon_bleeding[]">
                                                                        <option value="">Select</option>
                                                                        <option value="Yes"
                                                                            {{ ($mon_bleeding[$i] ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                            Yes</option>
                                                                        <option value="No"
                                                                            {{ ($mon_bleeding[$i] ?? '') == 'No' ? 'selected' : '' }}>
                                                                            No</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="mon_remarks[]"
                                                                        value="{{ $mon_remarks[$i] ?? '' }}"></td>
                                                                <td><button type="button" class="btn-danger"
                                                                        onclick="removeRow(this,'monitorTable')">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- Empty row --}}
                                                        <tr>
                                                            <td><input type="time" name="mon_time[]"></td>
                                                            <td><input type="text" name="mon_pulse[]"></td>
                                                            <td><input type="text" name="mon_bp[]"></td>
                                                            <td><input type="text" name="mon_ufrate[]"></td>
                                                            <td><input type="text" name="mon_ufvol[]"></td>
                                                            <td><input type="text" name="mon_vp[]"></td>
                                                            <td><input type="text" name="mon_ap[]"></td>
                                                            <td><input type="text" name="mon_bflow[]"></td>
                                                            <td><input type="text" name="mon_spo2[]"></td>
                                                            <td>
                                                                <select name="mon_bleeding[]">
                                                                    <option value="">Select</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="mon_remarks[]"></td>
                                                            <td><button type="button" class="btn-danger"
                                                                    onclick="removeRow(this,'monitorTable')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <div style="text-align:center; margin-top:10px;">
                                                <button type="button" class="add-btn"
                                                    onclick="addRow('monitorTable')">+
                                                    Add More</button>
                                            </div>

                                            @php
                                                $nurse_time =
                                                    json_decode($hemodialysis->nurse_time ?? '[]', true) ?? [];
                                                $nurse_notes =
                                                    json_decode($hemodialysis->nurse_notes ?? '[]', true) ?? [];
                                                $nurse_name =
                                                    json_decode($hemodialysis->nurse_name ?? '[]', true) ?? [];

                                                $hasNurseData =
                                                    !empty($nurse_time) &&
                                                    is_array($nurse_time) &&
                                                    count($nurse_time) > 0;
                                            @endphp

                                            <table id="nurseNote" width="100%" border="1"
                                                style="margin-top:10px">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Time</th>
                                                        <th style="text-align: center;">NURSES NOTES</th>
                                                        <th style="text-align: center;">Signature</th>
                                                        <th style="text-align: center;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($hasNurseData)
                                                        @for ($i = 0; $i < count($nurse_time); $i++)
                                                            <tr>
                                                                <td><input type="time" name="nurse_time[]"
                                                                        value="{{ $nurse_time[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <textarea name="nurse_notes[]" cols="145" rows="3">{{ $nurse_notes[$i] ?? '' }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="nurse_name[]"
                                                                        id="nurse_name"
                                                                        value="{{ $nurse_name[$i] ?? '' }}">
                                                                    <input type="hidden" name="h_nurse_name"
                                                                        value="{{ $nurse_name[$i] ?? '' }}">
                                                                </td>
                                                                <td><button type="button" class="btn-danger"
                                                                        onclick="removeRow(this,'nurseNote')">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- Empty Row --}}
                                                        <tr>
                                                            <td><input type="time" name="nurse_time[]"></td>
                                                            <td>
                                                                <textarea name="nurse_notes[]" cols="145" rows="3"></textarea>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="nurse_name[]"
                                                                    id="nurse_name">
                                                                <input type="hidden" name="h_nurse_name">
                                                            </td>
                                                            <td><button type="button" class="btn-danger"
                                                                    onclick="removeRow(this,'nurseNote')">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <div style="text-align:center; margin-top:10px;">
                                                <button type="button" class="add-btn"
                                                    onclick="nurseNotes('nurseNote')">+
                                                    Add More</button>
                                            </div>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="2" style="text-align: center;">
                                                        <h5><strong>PATIENT AND FAMILY EDUCATION </strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $safety_precautions =
                                                            json_decode(
                                                                $hemodialysis->safety_precautions ?? '[]',
                                                                true,
                                                            ) ?? [];

                                                    @endphp
                                                    <td>

                                                        <input type="checkbox" id="infection_control"
                                                            name="safety_precautions[]" value="Infection Control"
                                                            {{ in_array('Infection Control', $safety_precautions) ? 'checked' : '' }}>
                                                        Infection Control
                                                        <br>
                                                        <input type="checkbox" name="safety_precautions[]"
                                                            value="Fistula/line care"
                                                            {{ in_array('Fistula/line care', $safety_precautions) ? 'checked' : '' }}>
                                                        Fistula/line care
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="safety_precautions[]"
                                                            value="Safe use of medication"
                                                            {{ in_array('Safe use of medication', $safety_precautions) ? 'checked' : '' }}>
                                                        Safe use of medication
                                                        <br>
                                                        <input type="checkbox" name="safety_precautions[]"
                                                            value="Fall prevention measures"
                                                            {{ in_array('Fall prevention measures', $safety_precautions) ? 'checked' : '' }}>
                                                        Fall prevention measures
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        Others <input type="text" name="pt_others"
                                                            value="{{ $hemodialysis->pt_others ?? '' }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;">
                                                        <h5><strong>PATIENT RECORD AND REPORT CHECKED BY </strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"><strong>Hand over given by</strong></td>
                                                    <td class="text-center"><strong>Hand over taken by</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Name of RN <input type="text" class="form-control"
                                                            name="rn_given" id="rn_given"
                                                            value="{{ $hemodialysis->rn_given ?? '' }}">
                                                        <input type="hidden" class="form-control" name="h_rn_given"
                                                            id="h_rn_given"
                                                            value="{{ $hemodialysis->h_rn_given ?? '' }}">
                                                    </td>
                                                    <td>
                                                        Name of RN <input type="text" class="form-control"
                                                            name="rn_taken" id="rn_taken"
                                                            value="{{ $hemodialysis->rn_taken ?? '' }}">
                                                        <input type="hidden" class="form-control" name="h_rn_taken"
                                                            id="h_rn_taken"
                                                            value="{{ $hemodialysis->h_rn_taken ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Name of Technician <input type="text" class="form-control"
                                                            name="tech_given" id="tech_given"
                                                            value="{{ $hemodialysis->tech_given ?? '' }}">
                                                        <input type="hidden" class="form-control"
                                                            name="h_tech_given" id="h_tech_given"
                                                            value="{{ $hemodialysis->h_tech_given ?? '' }}">
                                                    </td>
                                                    <td>
                                                        Name of Technician <input type="text" class="form-control"
                                                            name="tech_taken" id="tech_taken"
                                                            value="{{ $hemodialysis->tech_taken ?? '' }}">
                                                        <input type="hidden" class="form-control"
                                                            name="h_tech_taken" id="h_tech_taken"
                                                            value="{{ $hemodialysis->h_tech_taken ?? '' }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="5" style="text-align: center;">
                                                        <h5><strong>REPROCESSING</strong></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">No. of Reuse Dialyzer</td>
                                                    <td class="text-center">No. of Reuse Blood Tubing</td>
                                                    <td class="text-center">FBV</td>
                                                    <td class="text-center">Dialyzer is reusable</td>
                                                    <td class="text-center">Checked by Technician</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" name="dialyzer2"
                                                            value="{{ $hemodialysis->dialyzer2 ?? '' }}"></td>
                                                    <td><input type="text" class="form-control"
                                                            name="blood_tubing"
                                                            value="{{ $hemodialysis->blood_tubing ?? '' }}"></td>
                                                    <td><input type="text" class="form-control" name="fbv"
                                                            value="{{ $hemodialysis->fbv ?? '' }}"></td>
                                                    <td>
                                                        <select name="reusable_dialyzer" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ isset($hemodialysis->reusable_dialyzer) && $hemodialysis->reusable_dialyzer == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($hemodialysis->reusable_dialyzer) && $hemodialysis->reusable_dialyzer == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="technician"
                                                            id="technician"
                                                            value="{{ $hemodialysis->technician ?? '' }}">
                                                        <input type="hidden" class="form-control"
                                                            name="h_technician" id="h_technician"
                                                            value="{{ $hemodialysis->h_technician ?? '' }}">
                                                    </td>
                                                </tr>
                                            </table>


                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.hemodialysis-record-form', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#med_rnid', 'h_med_rnid', 'employee_ind', '1');
    openDoctorAutocomplete('#med_docsign', 'h_med_docsign', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_sign', 'h_tech_sign', 'employee_ind', '1');
    openDoctorAutocomplete('#terminated_by', 'h_terminated_by', 'employee_ind', '1');
    openDoctorAutocomplete('#priming_by', 'h_priming_by', 'employee_ind', '1');
    openDoctorAutocomplete('#dialyzer', 'h_dialyzer', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse_sign', 'h_nurse_sign', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_sign2', 'h_tech_sign2', 'employee_ind', '1');
    openDoctorAutocomplete('#started_by', 'h_started_by', 'employee_ind', '1');
    openDoctorAutocomplete('#post_staff', 'h_post_staff', 'employee_ind', '1');
    openDoctorAutocomplete('#pre_staff', 'h_pre_staff', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse_name', 'h_nurse_name', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_taken', 'h_tech_taken', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_given', 'h_tech_given', 'employee_ind', '1');
    openDoctorAutocomplete('#rn_taken', 'h_rn_taken', 'employee_ind', '1');
    openDoctorAutocomplete('#rn_given', 'h_rn_given', 'employee_ind', '1');
    openDoctorAutocomplete('#technician', 'h_technician', 'employee_ind', '1');


    function toggleWardICU() {
        let wardInput = document.getElementById("ward_icu");
        let selected = document.querySelector('input[name="iop"]:checked').value;

        if (selected === "IP") {
            wardInput.removeAttribute("readonly");
        } else {
            wardInput.setAttribute("readonly", true);
            wardInput.value = ""; // optional: clear field if OP
        }
    }


    function addRow(tableId) {
        let table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        let newRow = table.rows[0].cloneNode(true);
        newRow.querySelectorAll("input,select").forEach(el => el.value = "");
        table.appendChild(newRow);
    }

    function nurseNotes(tableId) {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true); // clone first row

        // Clear values in the cloned row
        Array.from(newRow.querySelectorAll('input')).forEach(input => {
            if (input.type === 'hidden') return; // keep hidden if needed
            input.value = '';
        });
        Array.from(newRow.querySelectorAll('textarea')).forEach(textarea => {
            textarea.value = '';
        });

        table.appendChild(newRow);
    }

    function removeRow(btn, tableId) {
        let row = btn.parentNode.parentNode;
        let tbody = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        if (tbody.rows.length > 1) {
            tbody.removeChild(row);
        } else {
            alert("At least one row must remain!");
        }
    }
</script>
