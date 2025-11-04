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

    .add-col-btn {
        font-size: 28px;
        /* bigger plus */
        font-weight: bold;
        border: none;
        background: none;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        color: green;
        /* nice contrast */
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
                            <h5 class="mt-2 mb-0">Ventilator Associated Events Initiation & Maintenance Bundle</h5>
                            <small>IPD / Nurse Station / Ventilator Associated Events</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.ventilator-associated-events-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('icu.ventilator-associated-events-store') }}" method="post"
                                        id="docShiftHandoverForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="icu_ventilator_bundle_no_pk"
                                            value="{{ isset($icu_ventilator->icu_ventilator_bundle_no_pk) ? $icu_ventilator->icu_ventilator_bundle_no_pk : '' }}">


                                        <div class="table-responsive">

                                            <table width="100%" border="1" style="margin-top:10px">

                                                <tr>
                                                    <td><strong>Diagnosis:</strong> <input class="form-control"
                                                            type="text" name="diagnosis" id="diagnosis"
                                                            value="{{ isset($icu_ventilator->diagnosis) ? $icu_ventilator->diagnosis : '' }}">
                                                        <input type="hidden" name="h_diagnosis" id="h_diagnosis">
                                                    </td>
                                                    <td><strong>Location & Inserted by:</strong> <input
                                                            class="form-control" type="text" name="location_by"
                                                            value="{{ isset($icu_ventilator->location_by) ? $icu_ventilator->location_by : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ET/TT Inserted on:</strong> <input style="width: 30%"
                                                            class="form-control" type="datetime-local"
                                                            name="inserted_on"
                                                            value="{{ isset($icu_ventilator->inserted_on) ? date('Y-m-d\TH:i', strtotime($icu_ventilator->inserted_on)) : '' }}">
                                                    </td>
                                                    <td><strong>Indication:</strong> <input class="form-control"
                                                            type="text" name="indication1"
                                                            value="{{ isset($icu_ventilator->indication1) ? $icu_ventilator->indication1 : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ET/TT Removed on:</strong> <input style="width: 30%"
                                                            class="form-control" type="datetime-local" name="removed_on"
                                                            value="{{ isset($icu_ventilator->removed_on) ? date('Y-m-d\TH:i', strtotime($icu_ventilator->removed_on)) : '' }}">
                                                    </td>
                                                    <td><strong>Indication::</strong> <input class="form-control"
                                                            type="text" name="indication2"
                                                            value="{{ isset($icu_ventilator->indication2) ? $icu_ventilator->indication2 : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Patient intubation and ventilation justified by clinical
                                                            care team</strong>

                                                    </td>
                                                    <td>
                                                        <select name="clinical_care">
                                                            <option
                                                                value="Yes"{{ @$icu_ventilator->clinical_care == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$icu_ventilator->clinical_care == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$icu_ventilator->clinical_care == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Standard aseptic precautions
                                                            followed (as per HIC manual)
                                                        </strong>

                                                    </td>
                                                    <td>
                                                        <select name="hic">
                                                            <option
                                                                value="Yes"{{ @$icu_ventilator->hic == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$icu_ventilator->hic == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$icu_ventilator->hic == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Endotracheal tube with subglottic suction used</strong>

                                                    </td>
                                                    <td>
                                                        <select name="endotracheal">
                                                            <option
                                                                value="Yes"{{ @$icu_ventilator->endotracheal == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$icu_ventilator->endotracheal == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option
                                                                value="N/A"{{ @$icu_ventilator->endotracheal == 'N/A' ? 'selected' : '' }}>
                                                                N/A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            @php
                                                $semi_recumbent =
                                                    json_decode($icu_ventilator->semi_recumbent ?? '[]', true) ?? [];
                                                $cuff_pressure =
                                                    json_decode($icu_ventilator->cuff_pressure ?? '[]', true) ?? [];
                                                $sedation_free =
                                                    json_decode($icu_ventilator->sedation_free ?? '[]', true) ?? [];
                                                $ulcer_prevention =
                                                    json_decode($icu_ventilator->ulcer_prevention ?? '[]', true) ?? [];
                                                $dvt_prevention =
                                                    json_decode($icu_ventilator->dvt_prevention ?? '[]', true) ?? [];
                                                $oral_hygiene =
                                                    json_decode($icu_ventilator->oral_hygiene ?? '[]', true) ?? [];
                                                $sterile_fluid =
                                                    json_decode($icu_ventilator->sterile_fluid ?? '[]', true) ?? [];
                                                $suction = json_decode($icu_ventilator->suction ?? '[]', true) ?? [];
                                                $blood_sugar =
                                                    json_decode($icu_ventilator->blood_sugar ?? '[]', true) ?? [];
                                            @endphp
                                            <table id="checklistTable" width="100%" border="1"
                                                style="margin-top:10px; border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:40%">VAE – Yes / No / N/A</th>
                                                        <th>1</th>
                                                        <th style="text-align:center; width:80px;">
                                                            <button type="button" class="add-col-btn"
                                                                onclick="addColumn()">+</button>
                                                        </th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Patient is in semi-recumbent position of 30-45 degrees
                                                            (unless contraindicated)</td>
                                                        <td>
                                                            @forelse ($semi_recumbent as $ans)
                                                                <select name="semi_recumbent[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="semi_recumbent[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse
                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_semi"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_semi_recumbent) ? $icu_ventilator->remarks_semi_recumbent : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cuff pressure maintained around 20 cms H<sub>2</sub>O</td>
                                                        <td>
                                                            @forelse ($cuff_pressure as $ans)
                                                                <select name="cuff_pressure[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="cuff_pressure[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_cuff"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_cuff_pressure) ? $icu_ventilator->remarks_cuff_pressure : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sedation free interval for 2 hours given (to assess
                                                            readiness to wean or extubate)</td>
                                                        <td>
                                                            @forelse ($sedation_free as $ans)
                                                                <select name="sedation_free[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="sedation_free[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse


                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_sedation"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_sedation_free) ? $icu_ventilator->remarks_sedation_free : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ulcer prevention measures (Sucralfate, H2 blockers/proton
                                                            pump inhibitors)</td>
                                                        <td>
                                                            @forelse ($ulcer_prevention as $ans)
                                                                <select name="ulcer_prevention[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="ulcer_prevention[]"
                                                                    class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_ulcer"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_ulcer_prevention) ? $icu_ventilator->remarks_ulcer_prevention : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>DVT prevention measures (pharma or mechanical)</td>
                                                        <td>
                                                            @forelse ($dvt_prevention as $ans)
                                                                <select name="dvt_prevention[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="dvt_prevention[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_dvt"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_dvt_prevention) ? $icu_ventilator->remarks_dvt_prevention : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Oral hygiene with chlorhexidine solution 4th hourly</td>
                                                        <td>
                                                            @forelse ($oral_hygiene as $ans)
                                                                <select name="oral_hygiene[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="oral_hygiene[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_oral"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_oral_hygiene) ? $icu_ventilator->remarks_oral_hygiene : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sterile fluid used for nebulization</td>
                                                        <td>
                                                            @forelse ($sterile_fluid as $ans)
                                                                <select name="sterile_fluid[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="sterile_fluid[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_fluidsuction"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_sterile_fluid) ? $icu_ventilator->remarks_sterile_fluid : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Orotracheal suction performed</td>
                                                        <td>
                                                            @forelse ($suction as $ans)
                                                                <select name="suction[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="suction[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse


                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_suction"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_suction) ? $icu_ventilator->remarks_suction : '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Blood sugar maintained &lt;180mg/dl</td>
                                                        <td>
                                                            @forelse ($blood_sugar as $ans)
                                                                <select name="blood_sugar[]"
                                                                    class="form-control d-block mb-1">
                                                                    <option value="Yes"
                                                                        {{ $ans == 'Yes' ? 'selected' : '' }}>Yes
                                                                    </option>
                                                                    <option value="No"
                                                                        {{ $ans == 'No' ? 'selected' : '' }}>No
                                                                    </option>
                                                                    <option value="N/A"
                                                                        {{ $ans == 'N/A' ? 'selected' : '' }}>N/A
                                                                    </option>
                                                                </select>
                                                            @empty
                                                                {{-- show one empty select if no data --}}
                                                                <select name="blood_sugar[]" class="form-control">
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                    <option value="N/A">N/A</option>
                                                                </select>
                                                            @endforelse

                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" name="remarks_sugar"
                                                                class="form-control"
                                                                value="{{ isset($icu_ventilator->remarks_blood_sugar) ? $icu_ventilator->remarks_blood_sugar : '' }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table width="100%" border="1" style="margin-top:10px">

                                                <tr>
                                                    <td><label
                                                            style="display: inline-block; margin-right: 10px; font-weight: bold;">Assigned
                                                            Staff:</label></td>
                                                    <td>

                                                        <input class="form-control" type="text" name="staff"
                                                            id="staff"
                                                            value="{{ isset($icu_ventilator->staff) ? $icu_ventilator->staff : '' }}">
                                                        <input type="hidden" name="hh_staff" id="hh_staff">
                                                    </td>

                                                    <td><strong>Emp
                                                            ID:</strong>
                                                        <input type="text" name="h_staff" value="{{ isset($icu_ventilator->h_staff) ? $icu_ventilator->h_staff : '' }}">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label
                                                            style="display: inline-block; margin-right: 10px; font-weight: bold;">Verified
                                                            by:</label>


                                                    </td>
                                                    <td>

                                                        <input class="form-control" type="text" name="verified_by"
                                                            id="verified_by"
                                                            value="{{ isset($icu_ventilator->verified_by) ? $icu_ventilator->verified_by : '' }}">
                                                        <input type="hidden" name="hh_verified_by"
                                                            id="hh_verified_by">
                                                    </td>

                                                    <td><strong>Emp
                                                            ID:</strong> <input type="text" name="h_verified_by"
                                                            value="{{ isset($icu_ventilator->h_verified_by) ? $icu_ventilator->h_verified_by : '' }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.ventilator-associated-events-form', [
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
    openDoctorAutocomplete('#diagnosis', 'h_diagnosis', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#staff', 'hh_staff', 'employee_ind', '1,2');
    openDoctorAutocomplete('#verified_by', 'hh_verified_by', 'employee_ind', '1,2');



    let colCount = 1;

    // function addColumn() {
    //     colCount++;
    //     let table = document.getElementById("checklistTable");
    //     let headerRow = table.rows[0];

    //     // Insert before "+ Add" button column (which is before last "Remarks")
    //     let newTh = document.createElement("th");
    //     if (colCount === 1) {
    //         newTh.innerHTML = colCount; // first column (no ❌)
    //     } else {
    //         newTh.innerHTML = colCount +
    //             ' <button type="button" class="remove-col-btn" onclick="removeColumn(this)">❌</button>';
    //     }

    //     headerRow.insertBefore(newTh, headerRow.cells[headerRow.cells.length - 2]);

    //     // Add new <td> before "+ Add" column in every row
    //     for (let i = 1; i < table.rows.length; i++) {
    //         let newCell = table.rows[i].insertCell(table.rows[i].cells.length - 2);
    //         newCell.innerHTML = `
    //         <select name="dynamic_${i}_${colCount}">
    //             <option>Yes</option>
    //             <option>No</option>
    //             <option>N/A</option>
    //         </select>`;
    //     }
    // }
    function addColumn() {
        colCount++;
        let table = document.getElementById("checklistTable");
        let headerRow = table.rows[0];

        // Add header column
        let newTh = document.createElement("th");
        newTh.innerHTML = colCount +
            ' <button type="button" class="remove-col-btn" onclick="removeColumn(this)">❌</button>';
        headerRow.insertBefore(newTh, headerRow.cells[headerRow.cells.length - 2]);

        // Add new <td> before "+ Add" column in every row
        for (let i = 1; i < table.rows.length; i++) {
            let row = table.rows[i];

            // Map row index to input name
            let inputName = "";
            switch (i) {
                case 1:
                    inputName = "semi_recumbent[]";
                    break;
                case 2:
                    inputName = "cuff_pressure[]";
                    break;
                case 3:
                    inputName = "sedation_free[]";
                    break;
                case 4:
                    inputName = "ulcer_prevention[]";
                    break;
                case 5:
                    inputName = "dvt_prevention[]";
                    break;
                case 6:
                    inputName = "oral_hygiene[]";
                    break;
                case 7:
                    inputName = "sterile_fluid[]";
                    break;
                case 8:
                    inputName = "suction[]";
                    break;
                case 9:
                    inputName = "blood_sugar[]";
                    break;
            }

            let newCell = row.insertCell(row.cells.length - 2);
            newCell.innerHTML = `
            <select name="${inputName}" class="form-control">
                <option>Yes</option>
                <option>No</option>
                <option>N/A</option>
            </select>`;
        }
    }

    function removeColumn(btn) {
        let th = btn.parentElement;
        let colIndex = th.cellIndex;

        if (colIndex === 1) return; // prevent removing column #1

        let table = document.getElementById("checklistTable");
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].deleteCell(colIndex);
        }
    }
</script>
