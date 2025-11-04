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

    .btn-add {
        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;
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
                            <h5 class="mt-2 mb-0">Central Line Insertion </h5>
                            <small>IPD / Nurse Station / Central Line Insertion </small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.central-line-insertion-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.central-line-insertion-store') }}" method="post"
                                        id="CENTRALLINE">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="central_line_insertion_no_pk"
                                            value="{{ isset($central_line->central_line_insertion_no_pk) ? $central_line->central_line_insertion_no_pk : '' }}">


                                        <div class="table-responsive">


                                            <table width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">
                                                <tr>
                                                    <td><strong>Date:</strong> <input type="date" name="proc_date"
                                                            value="{{ isset($central_line->proc_date) ? date('Y-m-d', strtotime($central_line->proc_date)) : '' }}">
                                                    </td>
                                                    <td><strong>Name of the Doctor Inserting Line:</strong>
                                                        <input type="text" class="form-control" name="doc_name"
                                                            id="doc_name"
                                                            value="{{ isset($central_line->doc_name) ? $central_line->doc_name : '' }}">
                                                        <input type="hidden" id="h_doc_name" name="h_doc_name"
                                                            value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Procedure Location:</strong>
                                                        <select name="proc_location">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="OT"{{ @$central_line->proc_location == 'OT' ? 'selected' : '' }}>
                                                                OT</option>
                                                            <option
                                                                value="Recovery"{{ @$central_line->proc_location == 'Recovery' ? 'selected' : '' }}>
                                                                Recovery</option>
                                                            <option
                                                                value="ICU"{{ @$central_line->proc_location == 'ICU' ? 'selected' : '' }}>
                                                                ICU</option>

                                                        </select>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <strong>Others:</strong> <input type="text"
                                                                class="form-control" name="loc_other"
                                                                value="{{ isset($central_line->loc_other) ? $central_line->loc_other : '' }}">
                                                        </span>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Catheter Type:</strong>
                                                        <select name="cath_type">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Dialysis"{{ @$central_line->cath_type == 'Dialysis' ? 'selected' : '' }}>
                                                                Dialysis</option>
                                                            <option
                                                                value="Tunneled"{{ @$central_line->cath_type == 'Tunneled' ? 'selected' : '' }}>
                                                                Tunneled</option>
                                                            <option
                                                                value="Non-tunneled"{{ @$central_line->cath_type == 'Non-tunneled' ? 'selected' : '' }}>
                                                                Non-tunneled</option>
                                                            <option
                                                                value="Implant"{{ @$central_line->cath_type == '' ? 'Implant' : '' }}>
                                                                Implant</option>
                                                            <option
                                                                value="Non-implant"{{ @$central_line->cath_type == 'Non-implant' ? 'selected' : '' }}>
                                                                Non-implant</option>
                                                            <option
                                                                value="PICC"{{ @$central_line->cath_type == '' ? 'selected' : '' }}>
                                                                PICC</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Number of Lumen:</strong> <input type="text"
                                                            name="lumen_count"
                                                            value="{{ isset($central_line->lumen_count) ? $central_line->lumen_count : '' }}">
                                                    </td>
                                                    <td><strong>Catheter Lot No:</strong> <input type="text"
                                                            name="cath_lot"
                                                            value="{{ isset($central_line->cath_lot) ? $central_line->cath_lot : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Side of The Body:</strong> <input type="text"
                                                            name="body_side"
                                                            value="{{ isset($central_line->body_side) ? $central_line->body_side : '' }}">
                                                    </td>
                                                    <td>
                                                        <strong>Insertion Site:</strong>
                                                        <select name="insert_site">
                                                            <option value="">Select Site</option>
                                                            <option
                                                                value="Jugular"{{ @$central_line->insert_site == 'Jugular' ? 'selected' : '' }}>
                                                                Jugular</option>
                                                            <option
                                                                value="Brachial"{{ @$central_line->insert_site == 'Brachial' ? 'selected' : '' }}>
                                                                Brachial</option>
                                                            <option
                                                                value="Subclavian"{{ @$central_line->insert_site == 'Subclavian' ? 'selected' : '' }}>
                                                                Subclavian</option>
                                                            <option
                                                                value="Femoral"{{ @$central_line->insert_site == 'Femoral' ? 'selected' : '' }}>
                                                                Femoral</option>
                                                            <option
                                                                value="Umbilical"{{ @$central_line->insert_site == 'Umbilical' ? 'selected' : '' }}>
                                                                Umbilical</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Reason for Insertion:</strong>
                                                        <select name="insert_reason">
                                                            <option value="">Select Reason</option>
                                                            <option
                                                                value="New indication"{{ @$central_line->insert_reason == 'New indication' ? 'selected' : '' }}>
                                                                New indication</option>
                                                            <option
                                                                value="Malfunction"{{ @$central_line->insert_reason == 'Malfunction' ? 'selected' : '' }}>
                                                                Malfunction</option>
                                                            <option
                                                                value="Routine Replacement"{{ @$central_line->insert_reason == '' ? 'Routine Replacement' : '' }}>
                                                                Routine Replacement</option>
                                                            <option
                                                                value="Emergency"{{ @$central_line->insert_reason == 'Emergency' ? 'selected' : '' }}>
                                                                Emergency</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Observer Name (Designation):</strong>
                                                        <input type="text" class="form-control"
                                                            name="observer_name" id="observer_name"
                                                            value="{{ isset($central_line->observer_name) ? $central_line->observer_name : '' }}">
                                                        <input type="hidden" name="h_observer_name"
                                                            id="h_observer_name">
                                                    </td>
                                                    <td>
                                                        <strong>Procedure Start Time:</strong>
                                                        @php
                                                            $proc_start = explode(' ', @$central_line->proc_start);
                                                        @endphp
                                                        <input type="time" name="proc_start"
                                                            value="{{ $proc_start[1] ?? '' }}">
                                                        <strong>End Time:</strong>
                                                        @php
                                                            $proc_end = explode(' ', @$central_line->proc_end);
                                                        @endphp
                                                        <input type="time" name="proc_end"
                                                            value="{{ $proc_end[1] ?? '' }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Steps for Inserting Central Line -->
                                            <table width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">
                                                <tr>
                                                    <th colspan="4" class="text-center"><strong>STEPS FOR INSERTING
                                                            CENTRAL
                                                            LINE</strong></th>
                                                </tr>
                                                <tr>
                                                    <th><strong>Before procedure</strong></th>
                                                    <th>Yes</th>
                                                    <th>No</th>
                                                    <th>N/A</th>
                                                </tr>
                                                <tr>
                                                    <td>Patient and family education regarding central line insertion /
                                                        Obtain informed consent.</td>
                                                    <td colspan="3">
                                                        <select name="consent_edu">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->consent_edu == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->consent_edu == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->consent_edu == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Consent form and other relevant documents complete and in chart
                                                        (Exception: Emergent procedure)</td>
                                                    <td colspan="3">
                                                        <select name="consent_docs">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->consent_docs == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->consent_docs == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->consent_docs == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Time Out Checklist -->
                                            <table width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">
                                                <tr>
                                                    @php
                                                        $timeout_time = explode(' ', @$central_line->timeout_time);
                                                    @endphp
                                                    <th colspan="4" class="text-center"><strong>TIME OUT
                                                            CHECKLIST</strong> &nbsp;&nbsp;
                                                        Time-Out (time): <input type="time" name="timeout_time"
                                                            value="{{ $timeout_time[1] ?? '' }}">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>The following have been Verified</th>
                                                    <th>Yes</th>
                                                    <th>No</th>
                                                    <th>N/A</th>
                                                </tr>
                                                <tr>
                                                    <td>Name, DOB and UHID of the patient</td>
                                                    <td colspan="3">
                                                        <select name="verify_patient">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_patient == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_patient == 'No' ? 'selected' : '' }}>
                                                                No</option>



                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Relevant investigations if any</td>
                                                    <td colspan="3">
                                                        <select name="verify_invest">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_invest == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_invest == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_invest == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Correct procedure verified</td>
                                                    <td colspan="3">
                                                        <select name="verify_procedure">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_procedure == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_procedure == 'No' ? 'selected' : '' }}>
                                                                No</option>



                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Signature of Observers (Doctor)</td>
                                                    <td colspan="3">
                                                        <select name="verify_sign">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_sign == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_sign == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_sign == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Site and side of procedure verified</td>
                                                    <td colspan="3">
                                                        <select name="verify_site">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_site == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_site == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_site == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Blood products required, if any</td>
                                                    <td colspan="3">
                                                        <select name="verify_blood">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_blood == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_blood == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_blood == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>To check allergy for latex or adhesive</td>
                                                    <td colspan="3">
                                                        <select name="verify_allergy">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_allergy == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_allergy == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_allergy == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Assess the status of anticoagulant therapy</td>
                                                    <td colspan="3">
                                                        <select name="verify_anticoag">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_anticoag == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_anticoag == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_anticoag == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Assembling of central line insertion cart</td>
                                                    <td colspan="3">
                                                        <select name="verify_cart">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_cart == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_cart == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_cart == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Site assessment</td>
                                                    <td colspan="3">
                                                        <select name="verify_site_assess">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_site_assess == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_site_assess == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_site_assess == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Wearing cap mask by all personnel in that room</td>
                                                    <td colspan="3">
                                                        <select name="verify_ppe">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_ppe == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_ppe == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_ppe == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hand hygiene</td>
                                                    <td colspan="3">
                                                        <select name="verify_hygiene">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->verify_hygiene == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->verify_hygiene == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->verify_hygiene == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <strong>Before Procedure</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Maintain sterile medium</td>
                                                    <td colspan="3">
                                                        <select name="before_sterile">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_sterile == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_sterile == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_sterile == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>All those performing procedure using sterile gloves, sterile
                                                        gown, cap, mask (eye protection/shield, if required)</td>
                                                    <td colspan="3">
                                                        <select name="before_ppe">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_ppe == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_ppe == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_ppe == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Others in room wearing mask</td>
                                                    <td colspan="3">
                                                        <select name="before_mask">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_mask == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_mask == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_mask == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Patient sedated</td>
                                                    <td colspan="3">
                                                        <select name="before_sedated">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_sedated == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_sedated == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_sedated == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>If patient is NOT sedated, local anesthetic used</td>
                                                    <td colspan="3">
                                                        <select name="before_anesthetic">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_anesthetic == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_anesthetic == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_anesthetic == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Transducer set up for CVP monitoring</td>
                                                    <td colspan="3">
                                                        <select name="before_transducer">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->before_transducer == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->before_transducer == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->before_transducer == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <strong>During Procedure</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Maintain aseptic technique</td>
                                                    <td colspan="3">
                                                        <select name="during_aseptic">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_aseptic == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_aseptic == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_aseptic == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Skin preparation with 2% chlorhexidine and allow it to dry</td>
                                                    <td colspan="3">
                                                        <select name="during_skin_prep">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_skin_prep == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_skin_prep == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_skin_prep == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Blood aspirated from each lumen</td>
                                                    <td colspan="3">
                                                        <select name="during_aspirate">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_aspirate == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_aspirate == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_aspirate == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Type/Dosage ml/units of flush:
                                                        <input type="text" name="flush_details"
                                                            value="{{ isset($central_line->flush_details) ? $central_line->flush_details : '' }}">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Catheter caps placed on lumens</td>
                                                    <td colspan="3">
                                                        <select name="during_caps">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_caps == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_caps == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_caps == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>All lumens clamped</td>
                                                    <td colspan="3">
                                                        <select name="during_clamped">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_clamped == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_clamped == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_clamped == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Clean blood from the site using antiseptic agent (2%
                                                        chlorhexidine) and apply sterile dressing</td>
                                                    <td colspan="3">
                                                        <select name="during_clean">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_clean == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_clean == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_clean == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>USG guided / Non-USG guided</td>
                                                    <td colspan="3">
                                                        <select name="during_usg">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->during_usg == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->during_usg == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->during_usg == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <strong>After Procedure</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Type of dressing:
                                                        <select name="after_dressing">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Transparent"{{ @$central_line->after_dressing == 'Transparent' ? 'selected' : '' }}>
                                                                Transparent</option>
                                                            <option
                                                                value="Padded"{{ @$central_line->after_dressing == 'Padded' ? 'selected' : '' }}>
                                                                Padded</option>

                                                        </select>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Verification of line (CXR)</td>
                                                    <td colspan="3">
                                                        <select name="after_verify">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->after_verify == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->after_verify == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->after_verify == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>USG guided / Non-USG guided</td>
                                                    <td colspan="3">
                                                        <select name="after_usg">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->after_usg == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->after_usg == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->after_usg == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>If in OT to be performed in Recovery/ICU</td>
                                                    <td colspan="3">
                                                        <select name="after_transfer">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->after_transfer == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->after_transfer == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->after_transfer == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dressing dated</td>
                                                    <td colspan="3">
                                                        <select name="after_dated">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$central_line->after_dated == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$central_line->after_dated == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$central_line->after_dated == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><strong>Comments</strong>(If any deviation from
                                                        usual course):</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" colspan="4">
                                                        <textarea name="comments" id="" cols="196" rows="10">{{ isset($central_line->comments) ? $central_line->comments : '' }}</textarea>

                                                    </td>
                                                </tr>

                                            </table>
                                            <table border="1" style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Emp. ID</th>
                                                        <th>Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Performer</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="per_name" id="per_name"
                                                                value="{{ isset($central_line->per_name) ? $central_line->per_name : '' }}">
                                                            <input type="hidden" name="h_per_id" id="h_per_id">
                                                        </td>
                                                        <td> <input type="text" name="per_id"
                                                                value="{{ isset($central_line->per_id) ? $central_line->per_id : '' }}">
                                                        </td>
                                                        <td><input type="datetime-local" name="per_datetime"
                                                                value="{{ isset($central_line->per_datetime) ? date('Y-m-d\TH:i', strtotime($central_line->per_datetime)) : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Observer</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="observer_name2" id="observer_name2"
                                                                value="{{ isset($central_line->observer_name2) ? $central_line->observer_name2 : '' }}">
                                                            <input type="hidden" name="h_observer_id"
                                                                id="h_observer_id" value="">
                                                        </td>
                                                        <td> <input type="text" name="observer_id"
                                                                value="{{ isset($central_line->observer_id) ? $central_line->observer_id : '' }}">
                                                        </td>
                                                        <td><input type="datetime-local" name="observer_datetime"
                                                                value="{{ isset($central_line->observer_datetime) ? date('Y-m-d\TH:i', strtotime($central_line->observer_datetime)) : '' }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.central-line-insertion-form', [
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
    openDoctorAutocomplete('#doc_name', 'h_doc_name', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#in_doc', 'h_in_doc', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#per_name', 'h_per_id', 'employee_ind', '1,2');
    openDoctorAutocomplete('#observer_name2', 'h_observer_id', 'employee_ind', '1,2');
    openDoctorAutocomplete('#observer_name', 'h_observer_name', 'employee_ind', '1');
</script>
