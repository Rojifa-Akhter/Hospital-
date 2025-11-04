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

    textarea {
        width: 100%;
        height: 100%;
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
                            <h5 class="mt-2 mb-0">PROCEDURE SHEET UNDER SEDATION-CATH LAB</h5>
                            <small>IPD / Nurse Station / Pre-Sedation Assessment</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('under-sedation-cath-lab-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('under-sedation-cath-lab-store') }}" method="post"
                                        id="SEDATIONASSESSMENT">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="psus_cath_lab_no_pk"
                                            value="{{ isset($cath_lab->psus_cath_lab_no_pk) ? $cath_lab->psus_cath_lab_no_pk : '' }}">


                                        <div class="table-responsive">

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">

                                                <tr>
                                                    <td width="20%">Diagnosis:</td>
                                                    <td colspan="3"><input type="text" name="diagnosis"
                                                            value="{{ @$cath_lab->diagnosis }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Proposed procedure:</td>
                                                    <td colspan="3"><input type="text" name="proposed_procedure"
                                                            value="{{ @$cath_lab->proposed_procedure }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Height:</td>
                                                    <td><input type="text" name="height"
                                                            value="{{ @$cath_lab->height }}" style="width:100%"></td>
                                                    <td>Weight:</td>
                                                    <td><input type="text" name="weight"
                                                            value="{{ @$cath_lab->weight }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Allergies:</td>
                                                    <td colspan="3"><input type="text" name="allergies"
                                                            value="{{ @$cath_lab->allergies }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>History of Pre-Anesthesia/Surgery:</td>
                                                    <td colspan="3"><input type="text"
                                                            name="history_pre_anesthesia"
                                                            value="{{ @$cath_lab->history_pre_anesthesia }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Current medication:</td>
                                                    <td colspan="3"><input type="text" name="current_medication"
                                                            value="{{ @$cath_lab->current_medication }}"
                                                            style="width:100%"></td>
                                                </tr>

                                                <!-- PHYSICAL EXAMINATION -->
                                                <tr style="background:#f2f2f2; font-weight:bold; text-align:center;">
                                                    <td colspan="4">PHYSICAL EXAMINATION</td>
                                                </tr>
                                                <tr>
                                                    <td>PULSE:</td>
                                                    <td><input type="text" name="pulse"
                                                            value="{{ @$cath_lab->pulse }}" style="width:100%"></td>
                                                    <td>BP:</td>
                                                    <td><input type="text" name="bp"
                                                            value="{{ @$cath_lab->bp }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>SPO₂:</td>
                                                    <td><input type="text" name="spo2"
                                                            value="{{ @$cath_lab->spo2 }}" style="width:100%"></td>
                                                    <td>RR:</td>
                                                    <td><input type="text" name="rr"
                                                            value="{{ @$cath_lab->rr }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>TEMP:</td>
                                                    <td><input type="text" name="temp"
                                                            value="{{ @$cath_lab->temp }}" style="width:100%"></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Airway</b></td>
                                                </tr>

                                                <tr>
                                                    <td>ASA grade:</td>
                                                    <td><input type="text" name="asa_grade"
                                                            value="{{ @$cath_lab->asa_grade }}" style="width:100%">
                                                    </td>
                                                    <td>Denture / Others:</td>
                                                    <td><input type="text" name="denture"
                                                            value="{{ @$cath_lab->denture }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Risk factors(if any):</td>
                                                    <td><input type="text" name="risk_fact"
                                                            value="{{ @$cath_lab->risk_fact }}" style="width:100%">
                                                    </td>
                                                    <td>Others:</td>
                                                    <td><input type="text" name="air_other"
                                                            value="{{ @$cath_lab->air_other }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>CARDIOVASCULAR:</b></td>
                                                    <td><input type="text" name="cardiovascular"
                                                            value="{{ @$cath_lab->cardiovascular }}"
                                                            style="width:100%"></td>
                                                    <td><b>RESPIRATORY:</b></td>
                                                    <td><input type="text" name="respiratory"
                                                            value="{{ @$cath_lab->respiratory }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>CNS:</b></td>
                                                    <td><input type="text" name="cns"
                                                            value="{{ @$cath_lab->cns }}" style="width:100%"></td>
                                                    <td><b>EXTREMITY:</b></td>
                                                    <td><input type="text" name="extremity"
                                                            value="{{ @$cath_lab->extremity }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>HEPATIC/RENAL:</b></td>
                                                    <td><input type="text" name="hepatic_renal"
                                                            value="{{ @$cath_lab->hepatic_renal }}"
                                                            style="width:100%"></td>
                                                    <td><b>ENDOCRINE:</b></td>
                                                    <td><input type="text" name="endocrine"
                                                            value="{{ @$cath_lab->endocrine }}" style="width:100%">
                                                    </td>
                                                </tr>

                                                <!-- INVESTIGATIONS -->
                                                <tr style="background:#f2f2f2; font-weight:bold; text-align:center;">
                                                    <td colspan="4">INVESTIGATIONS</td>
                                                </tr>
                                                <tr>
                                                    <td>Blood Group:</td>
                                                    <td><input type="text" name="blood_group"
                                                            value="{{ @$cath_lab->blood_group }}" style="width:100%">
                                                    </td>
                                                    <td>Urea:</td>
                                                    <td><input type="text" name="urea"
                                                            value="{{ @$cath_lab->urea }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>HCT/Hb:</td>
                                                    <td><input type="text" name="hct_hb"
                                                            value="{{ @$cath_lab->hct_hb }}" style="width:100%"></td>
                                                    <td>Creatinine:</td>
                                                    <td><input type="text" name="creatinine"
                                                            value="{{ @$cath_lab->creatinine }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Platelet:</td>
                                                    <td><input type="text" name="platelet"
                                                            value="{{ @$cath_lab->platelet }}" style="width:100%">
                                                    </td>
                                                    <td>Blood Sugar:</td>
                                                    <td><input type="text" name="blood_sugar"
                                                            value="{{ @$cath_lab->blood_sugar }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Na⁺:</td>
                                                    <td><input type="text" name="na"
                                                            value="{{ @$cath_lab->na }}" style="width:100%"></td>
                                                    <td>K⁺:</td>
                                                    <td><input type="text" name="k"
                                                            value="{{ @$cath_lab->k }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>ECG:</td>
                                                    <td><input type="text" name="ecg"
                                                            value="{{ @$cath_lab->ecg }}" style="width:100%"></td>
                                                    <td>ETT:</td>
                                                    <td><input type="text" name="ett"
                                                            value="{{ @$cath_lab->ett }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>CXR:</td>
                                                    <td><input type="text" name="cxr"
                                                            value="{{ @$cath_lab->cxr }}" style="width:100%"></td>
                                                    <td>ECHO:</td>
                                                    <td><input type="text" name="echo"
                                                            value="{{ @$cath_lab->echo }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>EF:</td>
                                                    <td><input type="text" name="ef"
                                                            value="{{ @$cath_lab->ef }}" style="width:100%"></td>
                                                    <td>USD/ASD:</td>
                                                    <td><input type="text" name="usd_asd"
                                                            value="{{ @$cath_lab->usd_asd }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Valvular:</td>
                                                    <td colspan="3"><input type="text" name="valvular"
                                                            value="{{ @$cath_lab->valvular }}" style="width:100%">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Others:</td>
                                                    <td colspan="3"><input type="text" name="others"
                                                            value="{{ @$cath_lab->others }}" style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Pre-procedure instructions:</td>
                                                    <td colspan="3"><input type="text"
                                                            name="pre_procedure_instructions"
                                                            value="{{ @$cath_lab->pre_procedure_instructions }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Nothing by mouth:</td>
                                                    <td colspan="3"><input type="text" name="nothing_by_mouth"
                                                            value="{{ @$cath_lab->nothing_by_mouth }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Pre-medications given:</td>
                                                    <td colspan="3"><input type="text" name="pre_medications"
                                                            value="{{ @$cath_lab->pre_medications }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Other advice:</td>
                                                    <td colspan="3"><input type="text" name="other_advice"
                                                            value="{{ @$cath_lab->other_advice }}"
                                                            style="width:100%"></td>
                                                </tr>


                                            </table> <br>

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    <td><b>Anesthetist / Intensivist</b></td>
                                                    <td><b>Name:</b> <input type="text" name="anesthetist"
                                                            id="anesthetist" value="{{ @$cath_lab->anesthetist }}">
                                                        <input type="hidden" name="anesthetist_empid"
                                                            id="anesthetist_empid" value="">
                                                    </td>
                                                    <td><b>Emp. ID:</b><input type="text" name="anesthetist_empid"
                                                            value="{{ @$cath_lab->anesthetist_empid }}"></td>

                                                    <td><b>Date & Time:</b> <input type="datetime-local"
                                                            name="anesthetist_dt"
                                                            value="{{ isset($cath_lab->anesthetist_dt) ? date('Y-m-d\TH:i', strtotime($cath_lab->anesthetist_dt)) : '' }}">
                                                    </td>
                                                </tr>
                                            </table> <br>
                                            <h4 style="text-align: center">PRE-PROCEDURE RECORD</h4>
                                            <!-- PRE-PROCEDURE CHECKLIST (selects for YES/NO/NA) -->
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse; text-align:center;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td colspan="8">PRE-PROCEDURE CHECKLIST : (TO BE FILLED BY
                                                        NURSE)
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ELEMENTS</th>
                                                    <th>YES / NO / NA</th>
                                                    <th>ELEMENTS</th>
                                                    <th>YES / NO / NA</th>
                                                </tr>

                                                <tr>
                                                    <td>Nil by mouth from:</td>
                                                    <td>
                                                        <select name="nil_mouth" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->nil_by_mouth == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->nil_by_mouth == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->nil_by_mouth == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>

                                                    <td>IV line in situ with heplock</td>
                                                    <td>
                                                        <select name="heplock" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->heplock == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->heplock == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->heplock == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Consent Taken</td>
                                                    <td>
                                                        <select name="consent_taken" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->consent_taken == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->consent_taken == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->consent_taken == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>

                                                    <td>Investigations reports received</td>
                                                    <td>
                                                        <select name="investigations" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->investigations == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->investigations == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->investigations == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Vital signs recorded</td>
                                                    <td>
                                                        <select name="vital_rec" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->vital_rec == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->vital_rec == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->vital_rec == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>

                                                    <td>Dentures/eyeglass removed</td>
                                                    <td>
                                                        <select name="dentures_removed" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->dentures_removed == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->dentures_removed == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->dentures_removed == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Pre-procedure medications given</td>
                                                    <td>
                                                        <select name="med_given" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->med_given == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->med_given == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->med_given == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>

                                                    <td>History & physical exam completed</td>
                                                    <td>
                                                        <select name="his_phy" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->his_phy == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->his_phy == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NA"
                                                                {{ @$cath_lab->his_phy == 'NA' ? 'selected' : '' }}>
                                                                NA</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- VITALS -->
                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse; text-align:center;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td colspan="6">VITALS</td>
                                                </tr>
                                                <tr>
                                                    <td>TEMP: <input type="text" name="v_temp"
                                                            value="{{ @$cath_lab->v_temp }}" style="width:100%;">
                                                    </td>
                                                    <td>HR: <input type="text" name="v_hr"
                                                            value="{{ @$cath_lab->v_hr }}" style="width:100%;"></td>
                                                    <td>RR: <input type="text" name="v_rr"
                                                            value="{{ @$cath_lab->v_rr }}" style="width:100%;"></td>
                                                    <td>BP: <input type="text" name="v_bp"
                                                            value="{{ @$cath_lab->v_bp }}" style="width:100%;"></td>
                                                    <td>SpO₂: <input type="text" name="v_spo2"
                                                            value="{{ @$cath_lab->v_spo2 }}" style="width:100%;">
                                                    </td>
                                                    <td>Pain Score: <input type="text" name="v_pain_score"
                                                            value="{{ @$cath_lab->v_pain_score }}"
                                                            style="width:100%;">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="2"><b>NURSE</b></td>
                                                    <td colspan="2"><b>Name</b></td>
                                                    <td><b>Emp.ID:</b></td>
                                                    <td colspan="2"><b>Time</b></td>


                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="nurse_name"
                                                            id="nurse_name" value="{{ @$cath_lab->nurse_name }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="nurse_empid" id="nurse_empid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td><input type="text" name="nurse_empid"
                                                            value="{{ @$cath_lab->nurse_empid }}"
                                                            style="width:100%;"></td>
                                                    @php
                                                        $nurse_time = explode(' ', @$cath_lab->nurse_time);
                                                    @endphp
                                                    <td colspan="2"><input type="time" name="nurse_time"
                                                            value="{{ $nurse_time[1] ?? '' }}" style="width:100%;">
                                                    </td>
                                                </tr>
                                            </table>


                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td colspan="4" style="text-align: center">TO BE FILLED IN BY
                                                        ANESTHETIST :</td>
                                                </tr>
                                                @php
                                                    $ivStarted = json_decode($cath_lab->iv_started ?? '[]', true) ?? [];
                                                @endphp
                                                <tr>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="1"
                                                                {{ in_array('1', $ivStarted) ? 'checked' : '' }}> IV
                                                            Started</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="2"
                                                                {{ in_array('2', $ivStarted) ? 'checked' : '' }}>
                                                            Cardiac Monitor</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="3"
                                                                {{ in_array('3', $ivStarted) ? 'checked' : '' }}>
                                                            Suction Ready</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="4"
                                                                {{ in_array('4', $ivStarted) ? 'checked' : '' }}>
                                                            Naloxone @ bedside</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="5"
                                                                {{ in_array('5', $ivStarted) ? 'checked' : '' }}> SpO₂
                                                            Monitor</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="6"
                                                                {{ in_array('6', $ivStarted) ? 'checked' : '' }}> O₂ @
                                                            Bedside</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="7"
                                                                {{ in_array('7', $ivStarted) ? 'checked' : '' }}> Ambu
                                                            Bag
                                                            @
                                                            Bedside</label></td>
                                                    <td><label><input type="checkbox" name="iv_started[]"
                                                                value="8"
                                                                {{ in_array('8', $ivStarted) ? 'checked' : '' }}>
                                                            Flumazenil @ Bedside</label></td>
                                                </tr>

                                                <tr>
                                                    <td><b>Anesthetist / Intensivist</b></td>
                                                    <td><b>Name:</b> <input type="text" name="anesthetist2"
                                                            id="anesthetist2"
                                                            value="{{ @$cath_lab->anesthetist2 }}">
                                                        <input type="hidden" name="anesthetist2_empid"
                                                            id="anesthetist2_empid" value="">
                                                    </td>
                                                    <td><b>Emp. ID:</b><input type="text" name="anesthetist2_empid"
                                                            value="{{ @$cath_lab->anesthetist2_empid }}"></td>

                                                    <td><b>Date & Time:</b> <input type="datetime-local"
                                                            name="anesthetist2_dt"
                                                            value="{{ isset($cath_lab->anesthetist2_dt) ? date('Y-m-d\TH:i', strtotime($cath_lab->anesthetist2_dt)) : '' }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- TIME OUT CHECKLIST (YES/NO as selects now) -->
                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse; text-align:center;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td colspan="4">TIME OUT CHECKLIST</td>
                                                    <td colspan="3">TIME OUT PARTICIPANTS</td>
                                                </tr>
                                                <tr>
                                                    <th>ELEMENTS</th>
                                                    <th>YES</th>
                                                    <th>NO</th>
                                                    <th>REMARKS</th>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Emp.ID</th>
                                                </tr>

                                                <tr>
                                                    <td>Patient’s name and ID checked?</td>
                                                    <td colspan="2">
                                                        <select name="pt_nameid" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->pt_nameid == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->pt_nameid == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="toc_remarks1"
                                                            value="{{ @$cath_lab->toc_remarks1 }}"
                                                            style="width:100%;"></td>
                                                    <td rowspan="2">Doctor</td>
                                                    <td rowspan="2"><input type="text" name="toc_docname"
                                                            id="toc_docname" value="{{ @$cath_lab->toc_docname }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="toc_docid" id="toc_docid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="toc_docid"
                                                            value="{{ @$cath_lab->toc_docid }}" style="width:100%;">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Consent for procedure obtained?</td>
                                                    <td colspan="2">
                                                        <select name="consent_obtained_toc" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->consent_obtained_toc == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->consent_obtained_toc == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="toc_remarks2"
                                                            value="{{ @$cath_lab->toc_remarks2 }}"
                                                            style="width:100%;"></td>

                                                </tr>

                                                <tr>
                                                    <td>Is correct site/side prepared and draped?</td>
                                                    <td colspan="2">
                                                        <select name="site_side_prepared" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->site_side_prepared == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->site_side_prepared == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="toc_remarks3"
                                                            value="{{ @$cath_lab->toc_remarks3 }}"
                                                            style="width:100%;"></td>
                                                    <td rowspan="3">Nurse</td>
                                                    <td rowspan="3"><input type="text" name="toc_nursename"
                                                            id="toc_nursename"
                                                            value="{{ @$cath_lab->toc_nursename }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="toc_nurseid" id="toc_nurseid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td rowspan="3"><input type="text" name="toc_nurseid"
                                                            value="{{ @$cath_lab->toc_nurseid }}"
                                                            style="width:100%;"></td>

                                                </tr>
                                                <tr>
                                                    <td>Is there anything unique or non-routine about this procedure?
                                                    </td>
                                                    <td colspan="2">
                                                        <select name="non_routing" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->non_routing == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->non_routing == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="toc_remarks4"
                                                            value="{{ @$cath_lab->toc_remarks4 }}"
                                                            style="width:100%;"></td>

                                                </tr>
                                                <tr>
                                                    <td>Availability of correct equipment/Implant/Documents?</td>
                                                    <td colspan="2">
                                                        <select name="eid" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->eid == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->eid == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="toc_remarks5"
                                                            value="{{ @$cath_lab->toc_remarks5 }}"
                                                            style="width:100%;"></td>

                                                </tr>
                                                <tr>
                                                    <td>Is relevant investigations/essential radiological imaging
                                                        available?</td>
                                                    <td colspan="2">
                                                        <select name="iriria" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->iriria == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->iriria == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="toc_remarks6"
                                                            value="{{ @$cath_lab->toc_remarks6 }}"
                                                            style="width:100%;"></td>
                                                    <td rowspan="4">Technologist</td>
                                                    <td rowspan="4"><input type="text" name="toc_tecname"
                                                            id="toc_tecname" value="{{ @$cath_lab->toc_tecname }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="toc_tecid" id="toc_tecid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td rowspan="4"><input type="text" name="toc_tecid"
                                                            value="{{ @$cath_lab->toc_tecid }}" style="width:100%;">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>HBsAg/Hepatitis C/HIV status checked? (if applicable)</td>
                                                    <td colspan="2">
                                                        <select name="hiv_check" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->hiv_check == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->hiv_check == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="toc_remarks7"
                                                            value="{{ @$cath_lab->toc_remarks7 }}"
                                                            style="width:100%;"></td>

                                                </tr>
                                                <tr>
                                                    <td>Antibiotic prophylaxis given? (If applicable)</td>
                                                    <td colspan="2">
                                                        <select name="apg" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->apg == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->apg == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="toc_remarks8"
                                                            value="{{ @$cath_lab->toc_remarks8 }}"
                                                            style="width:100%;"></td>

                                                </tr>

                                                <tr>
                                                    <td>Sterility confirmed?</td>
                                                    <td colspan="2">
                                                        <select name="sc" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->sc == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->sc == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="toc_remarks9"
                                                            value="{{ @$cath_lab->toc_remarks9 }}"
                                                            style="width:100%;"></td>

                                                </tr>
                                            </table> <br>
                                            <h4 style="text-align: center">INTRA-PROCEDURAL RECORD</h4>
                                            <table border="1" width="100%" style="border-collapse: collapse;">
                                                <tr>
                                                    <td colspan="4"><b>Procedure start time:</b></td>
                                                    <td>
                                                        @php
                                                            $p_start = explode(' ', @$cath_lab->p_start);
                                                        @endphp
                                                        <input type="time" name="p_start"
                                                            value="{{ $p_start[1] ?? '' }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Approach:</b></td>
                                                    <td>
                                                        RADIAL
                                                        <select name="a_radial" style="width:100%">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->a_radial == 'R' ? 'selected' : '' }}>R
                                                            </option>
                                                            <option value="L"
                                                                {{ @$cath_lab->a_radial == 'L' ? 'selected' : '' }}>L
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        FEMORAL
                                                        <select name="a_femoral" style="width:100%">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->a_femoral == 'R' ? 'selected' : '' }}>R
                                                            </option>
                                                            <option value="L"
                                                                {{ @$cath_lab->a_femoral == 'L' ? 'selected' : '' }}>L
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        ULNER
                                                        <select name="a_ulner" style="width:100%">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->a_ulner == 'R' ? 'selected' : '' }}>R
                                                            </option>
                                                            <option value="L"
                                                                {{ @$cath_lab->a_ulner == 'L' ? 'selected' : '' }}>L
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        OTHER
                                                        <select name="a_other" style="width:100%">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->a_other == 'R' ? 'selected' : '' }}>R
                                                            </option>
                                                            <option value="L"
                                                                {{ @$cath_lab->a_other == 'L' ? 'selected' : '' }}>L
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><b>INTRA PROCEDURE SEDATION MONITORING</b></td>

                                                </tr>
                                                @php
                                                    $equipment = json_decode($cath_lab->equipment ?? '[]', true) ?? [];
                                                @endphp
                                                <tr>
                                                    <td colspan="5"><b>Equipment Check:</b>
                                                        <label><input type="checkbox" name="equipment[]"
                                                                value="1"
                                                                {{ in_array('1', $equipment) ? 'checked' : '' }}>
                                                            O<sub>2</sub> port with circuit</label>
                                                        <label><input type="checkbox" name="equipment[]"
                                                                value="2"
                                                                {{ in_array('2', $equipment) ? 'checked' : '' }}>
                                                            Suction</label>
                                                        <label><input type="checkbox" name="equipment[]"
                                                                value="3"
                                                                {{ in_array('3', $equipment) ? 'checked' : '' }}>
                                                            Drugs</label>
                                                    </td>

                                                </tr>
                                            </table> <br>



                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">

                                                <tr>
                                                    <td colspan="4"><b>Event Note:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="event_note" rows="5">{{ @$cath_lab->event_note }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Anesthetist / Intensivist</b></td>
                                                    <td><b>Name:</b> <input type="text" name="anesthetist3"
                                                            id="anesthetist3"
                                                            value="{{ @$cath_lab->anesthetist3 }}">
                                                        <input type="hidden" name="anesthetist3_empid"
                                                            id="anesthetist3_empid" value="">
                                                    </td>
                                                    <td><b>Emp. ID:</b><input type="text" name="anesthetist3_empid"
                                                            value="{{ @$cath_lab->anesthetist3_empid }}"></td>

                                                    <td><b>Date & Time:</b> <input type="datetime-local"
                                                            name="anesthetist3_dt"
                                                            value="{{ isset($cath_lab->anesthetist3_dt) ? date('Y-m-d\TH:i', strtotime($cath_lab->anesthetist3_dt)) : '' }}">
                                                    </td>
                                                </tr>
                                            </table> <br>

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse; text-align:center;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td colspan="4">SIGN OUT CHECKLIST</td>
                                                    <td colspan="3">Sign out particiapnt</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Name of the procedure done:</th>
                                                    <th rowspan="3">Nurse</th>
                                                    <th>Name</th>
                                                    <th>Emp.ID</th>

                                                </tr>
                                                <tr>
                                                    <th>ELEMENTS</th>
                                                    <th>YES</th>
                                                    <th>NO</th>
                                                    <th>REMARKS</th>
                                                    <td rowspan="2"><input type="text" name="soc_nursename"
                                                            id="soc_nursename"
                                                            value="{{ @$cath_lab->soc_nursename }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="soc_nurseid" id="soc_nurseid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="soc_nurseid"
                                                            value="{{ @$cath_lab->soc_nurseid }}"></td>



                                                </tr>

                                                <tr>
                                                    <td>Instrument/sponge/needle counts are verified?</td>
                                                    <td colspan="2">
                                                        <select name="isncav" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->isncav == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->isncav == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="soc_remarks1"
                                                            value="{{ @$cath_lab->soc_remarks1 }}"
                                                            style="width:100%;"></td>


                                                </tr>

                                                <tr>
                                                    <td>Labelling of specimen done? (if any)</td>
                                                    <td colspan="2">
                                                        <select name="losd" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->losd == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->losd == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="soc_remarks2"
                                                            value="{{ @$cath_lab->soc_remarks2 }}"
                                                            style="width:100%;"></td>
                                                    <td rowspan="2"><b>Technologist (If applicable)</b></td>
                                                    <td rowspan="2"><input type="text" name="soc_tecname"
                                                            id="soc_tecname" value="{{ @$cath_lab->soc_tecname }}"
                                                            style="width:100%;">
                                                        <input type="hidden" name="soc_tecid" id="soc_tecid"
                                                            value="" style="width:100%;">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="soc_tecid"
                                                            value="{{ @$cath_lab->soc_tecid }}"></td>

                                                </tr>

                                                <tr>
                                                    <td>Any equipment problem to be addressed?</td>
                                                    <td colspan="2">
                                                        <select name="aeptba" style="width:100%;">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->aeptba == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->aeptba == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>

                                                    <td><input type="text" name="soc_remarks3"
                                                            value="{{ @$cath_lab->soc_remarks3 }}"
                                                            style="width:100%;"></td>



                                            </table> <br>
                                            <h4 style="text-align: center">POST PROCEDURE RECORD</h4>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">

                                                <tr>
                                                    <td colspan="4"><b>PROCEDURE NOTES</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Findings:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="finding" rows="10">{{ @$cath_lab->finding }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Recommendation:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="recommend" rows="10">{{ @$cath_lab->recommend }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: left"><b>CORONARY
                                                            ANGIOGRAM</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="coronary" rows="15">{{ @$cath_lab->coronary }}</textarea>
                                                    </td>
                                                </tr>





                                            </table>

                                            <h4 style="text-align: center">POST PROCEDURE ORDER</h4>

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    @php
                                                        $vital_sign =
                                                            json_decode($cath_lab->vital_sign ?? '[]', true) ?? [];
                                                    @endphp
                                                    <td> 1. Observe vital signs:
                                                        <label><input type="checkbox" name="vital_sign[]"
                                                                value="1"
                                                                {{ in_array('1', $vital_sign) ? 'checked' : '' }}>
                                                            Every 15 min for 1 hour</label>
                                                        <label><input type="checkbox" name="vital_sign[]"
                                                                value="2"
                                                                {{ in_array('2', $vital_sign) ? 'checked' : '' }}>
                                                            Every 30 min for 1 hour</label>
                                                        <label><input type="checkbox" name="vital_sign[]"
                                                                value="3"
                                                                {{ in_array('3', $vital_sign) ? 'checked' : '' }}>
                                                            Every hourly for 6 hours</label>
                                                    </td>



                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>2. Watch puncture site/cut down site for bleeding. If
                                                            swelling apply pressure and inform doctor</label>
                                                        <label>3. Watch for reaction (allergies) to contrast media e.g..
                                                            rashes</label>
                                                        <label>4. In case of femoral approach, patient should not bend
                                                            the leg at hip, sit up, stand up for 6 hours. He/she should
                                                            be assisted when eating, drinking, passing urine etc. during
                                                            this time. In case of arm approach, patient can mobilize
                                                            when clinical condition is suitable.</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> 5. Check the relevant pulse:
                                                        @php
                                                            $relevent_pulse =
                                                                json_decode($cath_lab->relevent_pulse ?? '[]', true) ??
                                                                [];
                                                        @endphp
                                                        <label><input type="checkbox" name="relevent_pulse[]"
                                                                value="1"
                                                                {{ in_array('1', $relevent_pulse) ? 'checked' : '' }}>
                                                            Radial Pulse for arm approach</label>
                                                        <label><input type="checkbox" name="relevent_pulse[]"
                                                                value="2"
                                                                {{ in_array('2', $relevent_pulse) ? 'checked' : '' }}>
                                                            Posterior Tibialis/Dorsalis pedis pulse for femoral
                                                            approach</label>

                                                    </td>



                                                </tr>
                                                <tr>
                                                    @php
                                                        $sheath = json_decode($cath_lab->sheath ?? '[]', true) ?? [];
                                                    @endphp
                                                    <td> 6. Sheath Removal:
                                                        <label><input type="checkbox" name="sheath[]" value="1"
                                                                {{ in_array('1', $sheath) ? 'checked' : '' }}>
                                                            Cath Lab</label>
                                                        <label><input type="checkbox" name="sheath[]" value="2"
                                                                {{ in_array('2', $sheath) ? 'checked' : '' }}>CCU/CHDU/Post
                                                            Cath/Ward/Cabin</label>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7. Other Instructions: </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea name="otherinstruct" rows="10">{{ @$cath_lab->otherinstruct }}</textarea>
                                                    </td>
                                                </tr>

                                            </table> <br>
                                            <table border="1" style="width:100%; text-align:center;">
                                                <tr>
                                                    <td>Doctor</td>
                                                    <td>Name <input type="text" name="v_doc_name" id="v_doc_name"
                                                            value="{{ @$cath_lab->v_doc_name }}">
                                                        <input type="hidden" name="v_doc_empid" id="v_doc_empid"
                                                            value="">
                                                    </td>
                                                    <td>Emp. ID <input type="text" name="v_doc_empid"
                                                            value="{{ @$cath_lab->v_doc_empid }}"></td>
                                                    @php
                                                        $v_doc_time = explode(' ', @$cath_lab->v_doc_time);
                                                    @endphp
                                                    <td>Time <input type="time" name="v_doc_time"
                                                            value="{{ $v_doc_time[1] ?? '' }}"></td>
                                                </tr>
                                            </table> <br>

                                            @php
                                                $time_list = !empty($cath_lab->time)
                                                    ? json_decode($cath_lab->time, true)
                                                    : [];
                                                $temp_list = !empty($cath_lab->temp2)
                                                    ? json_decode($cath_lab->temp2, true)
                                                    : [];
                                                $hr_list = !empty($cath_lab->hr)
                                                    ? json_decode($cath_lab->hr, true)
                                                    : [];
                                                $rr_list = !empty($cath_lab->rr2)
                                                    ? json_decode($cath_lab->rr2, true)
                                                    : [];
                                                $bp_list = !empty($cath_lab->bp2)
                                                    ? json_decode($cath_lab->bp2, true)
                                                    : [];
                                                $spo2_list = !empty($cath_lab->spo2_2)
                                                    ? json_decode($cath_lab->spo2_2, true)
                                                    : [];
                                                $act_time_list = !empty($cath_lab->act_time)
                                                    ? json_decode($cath_lab->act_time, true)
                                                    : [];
                                                $act_res_list = !empty($cath_lab->act_result)
                                                    ? json_decode($cath_lab->act_result, true)
                                                    : [];

                                            @endphp

                                            <table border="1" style="width:100%; text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6">Post Procedure Vitals</th>
                                                        <th colspan="3">ACT</th>
                                                    </tr>
                                                    <tr>
                                                        <th>TIME</th>
                                                        <th>TEMP</th>
                                                        <th>HR/Pulse</th>
                                                        <th>RR</th>
                                                        <th>BP</th>
                                                        <th>SpO₂</th>
                                                        <th>TIME</th>
                                                        <th>RESULT</th>
                                                        <th style="width: 6%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vitals">
                                                    @if (!empty($time_list))
                                                        @foreach ($time_list as $i => $time)
                                                            <tr>
                                                                <td><input type="text" name="time[]"
                                                                        value="{{ $time }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="temp2[]"
                                                                        value="{{ $temp_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hr[]"
                                                                        value="{{ $hr_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="rr2[]"
                                                                        value="{{ $rr_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="bp2[]"
                                                                        value="{{ $bp_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="spo2_2[]"
                                                                        value="{{ $spo2_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="act_time[]"
                                                                        value="{{ $act_time_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="act_result[]"
                                                                        value="{{ $act_res_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td>
                                                                    <span class="btn btn-success btn-md addv"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <button type="button"
                                                                        class="btn btn-md btn-danger vdeleterow">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="time[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="temp2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="hr[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="rr2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="bp2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="spo2_2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="act_time[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="act_result[]"
                                                                    style="width:100%"></td>
                                                            <td><span class="btn btn-success btn-md addv"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table> <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    <td>Pain Score:</td>
                                                    <td><input type="text" name="pain_score"
                                                            value="{{ @$cath_lab->pain_score }}"></td>
                                                    <td>Fall Score:</td>
                                                    <td><input type="text" name="fall_score"
                                                            value="{{ @$cath_lab->fall_score }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Nurse</td>
                                                    <td>Name <input type="text" name="vnurse" id="vnurse"
                                                            value="{{ @$cath_lab->vnurse }}"><input type="hidden"
                                                            name="vnurse_empid" id="vnurse_empid" value="">
                                                    </td>
                                                    <td>Emp. ID <input type="text" name="vnurse_empid"
                                                            value="{{ @$cath_lab->vnurse_empid }}"> </td>
                                                    @php
                                                        $vnurse_time = explode(' ', @$cath_lab->vnurse_time);
                                                    @endphp
                                                    <td>Time <input type="time" name="vnurse_time"
                                                            value="{{ $vnurse_time[1] ?? '' }}"></td>
                                                </tr>
                                            </table> <br>

                                            <table id="aldrete-table" border="1" width="100%" cellspacing="0"
                                                cellpadding="6" style="border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <td colspan="9" style="text-align: center"><b>MODIFIED
                                                                ALDRETE RECOVERY SCORE</b> <br>

                                                            <label>(To be filled in by Nurse under supervision of
                                                                Doctor)</label>

                                                            <label> These parameters should be monitored every 15
                                                                minutes. Total
                                                                score is 10. A Score 29 (and/or are returned to similar
                                                                pre-op status) are considered fit to be discharged from
                                                                recovery area.</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Criteria</th>
                                                        <th>Parameter</th>
                                                        <th>Scale</th>
                                                        <th class="time-header">INITIAL</th>
                                                        <th class="time-header">15'</th>
                                                        <th class="time-header">30'</th>
                                                        <th class="time-header">45'</th>
                                                        <th class="time-header">60'</th>
                                                        <th class="time-header">AT DISCHARGE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php
                                                        $atmfe = json_decode($cath_lab->atmfe ?? '[]', true) ?? [];
                                                        $atmte = json_decode($cath_lab->atmte ?? '[]', true) ?? [];
                                                        $utme = json_decode($cath_lab->utme ?? '[]', true) ?? [];
                                                        $atbdcf = json_decode($cath_lab->atbdcf ?? '[]', true) ?? [];
                                                        $dolb = json_decode($cath_lab->dolb ?? '[]', true) ?? [];
                                                        $bopl = json_decode($cath_lab->bopl ?? '[]', true) ?? [];
                                                        $bpl = json_decode($cath_lab->bpl ?? '[]', true) ?? [];
                                                        $fa = json_decode($cath_lab->fa ?? '[]', true) ?? [];
                                                        $aon = json_decode($cath_lab->aon ?? '[]', true) ?? [];
                                                        $nr = json_decode($cath_lab->nr ?? '[]', true) ?? [];
                                                        $atmsor = json_decode($cath_lab->atmsor ?? '[]', true) ?? [];
                                                        $notms = json_decode($cath_lab->notms ?? '[]', true) ?? [];
                                                        $sewo = json_decode($cath_lab->sewo ?? '[]', true) ?? [];

                                                    @endphp

                                                    <tr>
                                                        <td rowspan="3" class="criteria-header">Activity</td>
                                                        <td class="parameter">Able to move four extremities</td>
                                                        <td class="score-cell">2</td>
                                                        <td><input type="checkbox" data-score="2" data-time="initial"
                                                                name="atmfe[]" value="1"
                                                                {{ in_array('1', $atmfe) ? 'checked' : '' }}></td>
                                                        <td><input type="checkbox" data-score="2" data-time="15"
                                                                name="atmfe[]" value="2"
                                                                {{ in_array('2', $atmfe) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="30"
                                                                name="atmfe[]" value="3"
                                                                {{ in_array('3', $atmfe) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="45"
                                                                name="atmfe[]" value="4"
                                                                {{ in_array('4', $atmfe) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="60"
                                                                name="atmfe[]" value="5"
                                                                {{ in_array('5', $atmfe) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="discharge" name="atmfe[]" value="6"
                                                                {{ in_array('6', $atmfe) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Able to move two extremities</td>
                                                        <td class="score-cell">1</td>
                                                        <td><input type="checkbox" data-score="1" data-time="initial"
                                                                name="atmte[]" value="1" {{ in_array('1', $atmte) ? 'checked' : '' }}></td>
                                                        <td><input type="checkbox" data-score="1" data-time="15"
                                                                name="atmte[]" value="2" {{ in_array('2', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="30"
                                                                name="atmte[]" value="3" {{ in_array('3', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="45"
                                                                name="atmte[]" value="4" {{ in_array('4', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="60"
                                                                name="atmte[]" value="5" {{ in_array('5', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="discharge" name="atmte[]" value="6" {{ in_array('6', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Unable to move extremities</td>
                                                        <td class="score-cell">0</td>
                                                        <td><input type="checkbox" data-score="0" data-time="initial"
                                                                name="utme[]" value="1" {{ in_array('1', $atmte) ? 'checked' : '' }}></td>
                                                        <td><input type="checkbox" data-score="0" data-time="15"
                                                                name="utme[]" value="2" {{ in_array('2', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="30"
                                                                name="utme[]" value="3" {{ in_array('3', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="45"
                                                                name="utme[]" value="4" {{ in_array('4', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="60"
                                                                name="utme[]" value="5" {{ in_array('5', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0"
                                                                data-time="discharge" name="utme[]" value="6" {{ in_array('6', $atmte) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>

                                                    <!-- Respiration -->
                                                    <tr>
                                                        <td rowspan="2" class="criteria-header">Respiration</td>
                                                        <td class="parameter">Able to breathe deeply and cough freely
                                                        </td>
                                                        <td class="score-cell">2</td>
                                                        <td><input type="checkbox" data-score="2" data-time="initial"
                                                                name="atbdcf[]" value="1" {{ in_array('1', $atbdcf) ? 'checked' : '' }}></td>
                                                        <td><input type="checkbox" data-score="2" data-time="15"
                                                                name="atbdcf[]" value="2" {{ in_array('2', $atbdcf) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="30"
                                                                name="atbdcf[]" value="3" {{ in_array('3', $atbdcf) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="45"
                                                                name="atbdcf[]" value="4" {{ in_array('4', $atbdcf) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="60"
                                                                name="atbdcf[]" value="5" {{ in_array('5', $atbdcf) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="discharge" name="atbdcf[]"
                                                                value="6" {{ in_array('6', $atbdcf) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Dyspnea or limited breathing</td>
                                                        <td class="score-cell">1</td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="initial" name="dolb[]" value="1" {{ in_array('1', $dolb) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="15"
                                                                name="dolb[]" value="2" {{ in_array('2', $dolb) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="30"
                                                                name="dolb[]" value="3" {{ in_array('3', $dolb) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="45"
                                                                name="dolb[]" value="4" {{ in_array('4', $dolb) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="60"
                                                                name="dolb[]" value="5" {{ in_array('5', $dolb) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="discharge" name="dolb[]"
                                                                value="6" {{ in_array('6', $dolb) ? 'checked' : '' }}></td>
                                                    </tr>


                                                    <tr>
                                                        <td rowspan="2" class="criteria-header">Circulation</td>
                                                        <td class="parameter">BP ± 20% of preanesthetic level</td>
                                                        <td class="score-cell">2</td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="initial" name="bopl[]" value="1" {{ in_array('1', $bopl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="15"
                                                                name="bopl[]" value="2" {{ in_array('2', $bopl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="30"
                                                                name="bopl[]" value="3" {{ in_array('3', $bopl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="45"
                                                                name="bopl[]" value="4" {{ in_array('4', $bopl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="60"
                                                                name="bopl[]" value="5" {{ in_array('5', $bopl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="discharge" name="bopl[]"
                                                                value="6" {{ in_array('6', $bopl) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">BP ± 20-50% of preanesthetic level</td>
                                                        <td class="score-cell">1</td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="initial" name="bpl[]" value="1" {{ in_array('1', $bpl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="15"
                                                                name="bpl[]" value="2" {{ in_array('2', $bpl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="30"
                                                                name="bpl[]" value="3" {{ in_array('3', $bpl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="45"
                                                                name="bpl[]" value="4" {{ in_array('4', $bpl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="60"
                                                                name="bpl[]" value="5" {{ in_array('5', $bpl) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="discharge" name="bpl[]"
                                                                value="6" {{ in_array('6', $bpl) ? 'checked' : '' }}></td>
                                                    </tr>


                                                    <tr>
                                                        <td rowspan="3" class="criteria-header">Consciousness
                                                        </td>
                                                        <td class="parameter">Fully awake</td>
                                                        <td class="score-cell">2</td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="initial" name="fa[]" value="1" {{ in_array('1', $fa) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="15"
                                                                name="fa[]" value="2" {{ in_array('2', $fa) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="30"
                                                                name="fa[]" value="3" {{ in_array('1', $fa) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="45"
                                                                name="fa[]" value="4" {{ in_array('4', $fa) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="60"
                                                                name="fa[]" value="5" {{ in_array('5', $fa) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="discharge" name="fa[]"
                                                                value="6" {{ in_array('6', $fa) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Arousable on calling</td>
                                                        <td class="score-cell">1</td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="initial" name="aon[]" value="1" {{ in_array('1', $aon) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="15"
                                                                name="aon[]" value="2" {{ in_array('2', $aon) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="30"
                                                                name="aon[]" value="3" {{ in_array('3', $aon) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="45"
                                                                name="aon[]" value="4" {{ in_array('4', $aon) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="60"
                                                                name="aon[]" value="5" {{ in_array('5', $aon) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="discharge" name="aon[]"
                                                                value="6" {{ in_array('6', $aon) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Not responding</td>
                                                        <td class="score-cell">0</td>
                                                        <td><input type="checkbox" data-score="0"
                                                                data-time="initial" name="nr[]" value="1" {{ in_array('1', $nr) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="15"
                                                                name="nr[]" value="2" {{ in_array('2', $nr) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="30"
                                                                name="nr[]" value="3" {{ in_array('3', $nr) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="45"
                                                                name="nr[]" value="4" {{ in_array('4', $nr) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="60"
                                                                name="nr[]" value="5" {{ in_array('5', $nr) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0"
                                                                data-time="discharge" name="nr[]"
                                                                value="6" {{ in_array('6', $nr) ? 'checked' : '' }}></td>
                                                    </tr>


                                                    <tr>
                                                        <td rowspan="3" class="criteria-header">Oxygenation</td>
                                                        <td class="parameter">Able to maintain saturation >92% on room
                                                            air</td>
                                                        <td class="score-cell">2</td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="initial" name="atmsor[]"
                                                                value="1" {{ in_array('1', $atmsor) ? 'checked' : '' }}></td>
                                                        <td><input type="checkbox" data-score="2" data-time="15"
                                                                name="atmsor[]" value="2" {{ in_array('2', $atmsor) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="30"
                                                                name="atmsor[]" value="3" {{ in_array('3', $atmsor) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="45"
                                                                name="atmsor[]" value="4" {{ in_array('4', $atmsor) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2" data-time="60"
                                                                name="atmsor[]" value="5" {{ in_array('5', $atmsor) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="2"
                                                                data-time="discharge" name="atmsor[]"
                                                                value="6" {{ in_array('6', $atmsor) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Needs oxygen to maintain saturation >90%
                                                        </td>
                                                        <td class="score-cell">1</td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="initial" name="notms[]" value="1" {{ in_array('1', $notms) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="15"
                                                                name="notms[]" value="2" {{ in_array('2', $notms) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="30"
                                                                name="notms[]" value="3" {{ in_array('3', $notms) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="45"
                                                                name="notms[]" value="4" {{ in_array('4', $notms) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1" data-time="60"
                                                                name="notms[]" value="5" {{ in_array('5', $notms) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="1"
                                                                data-time="discharge" name="notms[]"
                                                                value="6" {{ in_array('6', $notms) ? 'checked' : '' }}></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="parameter">Saturation &lt;90% even with oxygen</td>
                                                        <td class="score-cell">0</td>
                                                        <td><input type="checkbox" data-score="0"
                                                                data-time="initial" name="sewo[]" value="1" {{ in_array('1', $sewo) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="15"
                                                                name="sewo[]" value="2" {{ in_array('2', $sewo) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="30"
                                                                name="sewo[]" value="3" {{ in_array('3', $sewo) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="45"
                                                                name="sewo[]" value="4" {{ in_array('4', $sewo) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0" data-time="60"
                                                                name="sewo[]" value="5" {{ in_array('5', $sewo) ? 'checked' : '' }}>
                                                        </td>
                                                        <td><input type="checkbox" data-score="0"
                                                                data-time="discharge" name="sewo[]"
                                                                value="6" {{ in_array('6', $sewo) ? 'checked' : '' }}></td>
                                                    </tr>


                                                    <tr class="total-row">
                                                        <td colspan="2">Total Score</td>
                                                        <td id="max-score">10</td>
                                                        <td><input type="text" name="score_initial"
                                                                style="width: 40%" id="score-initial"
                                                                value="{{ @$cath_lab->score_initial }}" readonly>
                                                        </td>
                                                        <td><input type="text" name="score_15"
                                                                style="width: 40%" id="score-15"
                                                                value="{{ @$cath_lab->score_15 }}" readonly></td>
                                                        <td><input type="text" name="score_30"
                                                                style="width: 40%" id="score-30"
                                                                value="{{ @$cath_lab->score_30 }}" readonly></td>
                                                        <td><input type="text" name="score_45"
                                                                style="width: 40%" id="score-45"
                                                                value="{{ @$cath_lab->score_45 }}" readonly></td>
                                                        <td><input type="text" name="score_60"
                                                                style="width: 40%" id="score-60"
                                                                value="{{ @$cath_lab->score_60 }}" readonly></td>
                                                        <td><input type="text" name="score_discharge"
                                                                style="width: 40%" id="score-discharge"
                                                                value="{{ @$cath_lab->score_discharge }}" readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> <br>

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">

                                                <tr>
                                                    <td><b>Nurse</b></td>
                                                    <td><b>Name </b><input type="text" name="mnurse"
                                                            id="mnurse" value="{{ @$cath_lab->mnurse }}"><input
                                                            type="hidden" name="hmnurse_empid"
                                                            id="hmnurse_empid"></td>
                                                    <td><b>Emp. ID </b><input type="text" name="hmnurse_empid"
                                                            id="hmnurse_empid"
                                                            value="{{ @$cath_lab->hmnurse_empid }}"> </td>
                                                    @php
                                                        $mnurse_time = explode(' ', @$cath_lab->mnurse_time);
                                                    @endphp

                                                    <td> <b>Time </b><input type="time" name="mnurse_time"
                                                            value="{{ $mnurse_time[1] ?? '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Patient fit for discharge:</td>
                                                    <td colspan="3">
                                                        <select name="pt_discharge">
                                                            <option value="">--Select--</option>
                                                            <option value="Yes"
                                                                {{ @$cath_lab->pt_discharge == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cath_lab->pt_discharge == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Anesthetist</b></td>
                                                    <td> <b>Name</b> <input type="text" name="manesthetist"
                                                            id="manesthetist"
                                                            value="{{ @$cath_lab->manesthetist }}"><input
                                                            type="hidden" name="hmanesthetist_id"
                                                            id="hmanesthetist_id"></td>
                                                    <td><b>Emp. ID</b> <input type="text" name="manesthetist_id"
                                                            id="manesthetist_id"
                                                            value="{{ @$cath_lab->manesthetist_id }}"> </td>

                                                    @php
                                                        $manesthetist_time = explode(
                                                            ' ',
                                                            @$cath_lab->manesthetist_time,
                                                        );
                                                    @endphp

                                                    <td><b>Time</b> <input type="time" name="manesthetist_time"
                                                            value="{{ $manesthetist_time[1] ?? '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Nursing Notes:</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea class="notes" name="nursing_notes" rows="10">{{ @$cath_lab->nursing_notes }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $transfer =
                                                            json_decode($cath_lab->transfer ?? '[]', true) ?? [];
                                                    @endphp
                                                    <td colspan="4" style="text-align: left">
                                                        <b>Transfer to:</b>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="1"
                                                                {{ in_array('1', $transfer) ? 'checked' : '' }}>
                                                            Pre/Post cath</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="2"
                                                                {{ in_array('2', $transfer) ? 'checked' : '' }}>
                                                            CHDU</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="3"
                                                                {{ in_array('3', $transfer) ? 'checked' : '' }}>
                                                            CCU</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="4"
                                                                {{ in_array('4', $transfer) ? 'checked' : '' }}>
                                                            Others</label>
                                                        <input type="text" name="t_others"
                                                            value="{{ @$cath_lab->t_others }}"
                                                            placeholder="If Others,Specify" style="width: 50%">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    @php
                                                        $condition =
                                                            json_decode($cath_lab->condition ?? '[]', true) ?? [];
                                                    @endphp
                                                    <td colspan="4">
                                                        <b>Condition at transfer:</b>
                                                        <label><input type="checkbox" name="condition[]"
                                                                value="1"
                                                                {{ in_array('1', $condition) ? 'checked' : '' }}>
                                                            Stable</label>
                                                        <label><input type="checkbox" name="condition[]"
                                                                value="2"
                                                                {{ in_array('2', $condition) ? 'checked' : '' }}>
                                                            Critical</label>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Emp. ID</th>
                                                    <th>Date & Time</th>
                                                </tr>
                                                <tr>
                                                    <td>Transferring Staff</td>
                                                    <td><input type="text" name="trans_name" id="trans_name"
                                                            value="{{ @$cath_lab->trans_name }}"
                                                            class="form-control"><input type="hidden"
                                                            name="htrans_empid" id="htrans_empid"></td>
                                                    <td><input type="text" name="trans_empid" id="trans_empid"
                                                            value="{{ @$cath_lab->trans_empid }}"></td>
                                                    <td><input type="datetime-local" name="trans_date"
                                                            value="{{ isset($cath_lab->trans_date) ? date('Y-m-d\TH:i', strtotime($cath_lab->trans_date)) : '' }}"
                                                            class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Receiving Staff</td>
                                                    <td><input type="text" name="recv_name" id="recv_name"
                                                            value="{{ @$cath_lab->recv_name }}"
                                                            class="form-control"><input type="hidden"
                                                            name="hrecv_empid" id="hrecv_empid"></td>
                                                    <td><input type="text" name="recv_empid" id="recv_empid"
                                                            value="{{ @$cath_lab->recv_empid }}"></td>
                                                    <td><input type="datetime-local" name="recv_date"
                                                            value="{{ isset($cath_lab->recv_date) ? date('Y-m-d\TH:i', strtotime($cath_lab->recv_date)) : '' }}"
                                                            class="form-control"></td>
                                                </tr>
                                            </table> <br>

                                            @php
                                                $date_list = !empty($cath_lab->mr_date)
                                                    ? json_decode($cath_lab->mr_date, true)
                                                    : [];
                                                $time_list = !empty($cath_lab->mr_time)
                                                    ? json_decode($cath_lab->mr_time, true)
                                                    : [];
                                                $drug_list = !empty($cath_lab->mr_drug)
                                                    ? json_decode($cath_lab->mr_drug, true)
                                                    : [];
                                                $doc_list = !empty($cath_lab->mr_doc)
                                                    ? json_decode($cath_lab->mr_doc, true)
                                                    : [];
                                                $emp_list = !empty($cath_lab->mr_emp)
                                                    ? json_decode($cath_lab->mr_emp, true)
                                                    : [];
                                                $admin_list = !empty($cath_lab->mr_admin)
                                                    ? json_decode($cath_lab->mr_admin, true)
                                                    : [];

                                            @endphp




                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7" style="text-align: center">MEDICATION
                                                            ADMINISTRATION RECORD</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="py-1  w-10"
                                                            style="text-align: center">Date & Time</th>
                                                        <th rowspan="2" class="py-1  w-45"
                                                            style="text-align: center">Drug Name<br>
                                                            <small>(With Dose, Route & Frequency)<br>Infusion: Rate &
                                                                Duration</small>
                                                        </th>
                                                        <th colspan="2"class="py-1  w-25"
                                                            style="text-align: center">Doctor</th>
                                                        <th colspan="2"class="py-1  w-10"
                                                            style="text-align: center">Administration Record</th>
                                                        <th rowspan="2"class="py-1  w-10"
                                                            style="text-align: center">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-1  w-70">Sign</th>
                                                        <th>Emp. ID</th>
                                                        <th>Admin. Time</th>
                                                        <th>Checked By</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="med_rec">


                                                    @if (!empty($date_list))
                                                        @foreach ($date_list as $i => $mr_date)
                                                            <tr>

                                                                <td><input type="datetime-local"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_date[]"
                                                                        value="{{ $mr_date }}"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_time[]"
                                                                        value="{{ $time_list[$i] ?? '' }}"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_drug[]"
                                                                        value="{{ $drug_list[$i] ?? '' }}"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_doc[]"
                                                                        value="{{ $doc[$i] ?? '' }}"></td>
                                                                <td><input type="time"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_emp[]"
                                                                        value="{{ $emp_list[$i] ?? '' }}"></td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_admin[]"
                                                                        value="{{ $admin_list[$i] ?? '' }}"></td>
                                                                <td class="text-center">
                                                                    <span class="btn btn-success btn-md medadd"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-danger btn-md meddelete"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="date"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_date[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_time[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_drug[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_doc[]"></td>
                                                            <td><input type="time"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_emp[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_admin[]"></td>
                                                            <td class="text-center">
                                                                <span class="btn btn-success btn-md medadd"><i
                                                                        class="fa fa-plus"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('under-sedation-cath-lab', [
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
    openDoctorAutocomplete('#anesthetist', 'anesthetist_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#anesthetist2', 'anesthetist2_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#anesthetist3', 'anesthetist3_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse_name', 'nurse_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#toc_docname', 'toc_docid', 'employee_ind', '1');
    openDoctorAutocomplete('#toc_nursename', 'toc_nurseid', 'employee_ind', '1');
    openDoctorAutocomplete('#toc_tecname', 'toc_tecid', 'employee_ind', '1');
    openDoctorAutocomplete('#soc_nursename', 'soc_nurseid', 'employee_ind', '1');
    openDoctorAutocomplete('#soc_tecname', 'soc_tecid', 'employee_ind', '1');
    openDoctorAutocomplete('#v_doc_name', 'v_doc_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#mnurse', 'mnurse_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#vnurse', 'vnurse_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#manesthetist', 'manesthetist_id', 'employee_ind', '1');
    openDoctorAutocomplete('#trans_name', 'htrans_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#trans_name', 'htrans_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#recv_name', 'hrecv_empid', 'employee_ind', '1');

    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateScores);
    });

    function updateScores() {
        // Initialize scores for each time column
        const scores = {
            initial: 0,
            15: 0,
            30: 0,
            45: 0,
            60: 0,
            discharge: 0
        };

        // Calculate scores for each time column
        for (const time in scores) {
            // Get all checked checkboxes for this time column
            const checkboxes = document.querySelectorAll(`input[data-time="${time}"]:checked`);

            // Sum the scores for this time column
            checkboxes.forEach(checkbox => {
                const score = parseInt(checkbox.getAttribute('data-score'));
                scores[time] += score;
            });
        }

        // Update the total score input fields for each column
        document.getElementById('score-initial').value = scores.initial;
        document.getElementById('score-15').value = scores[15];
        document.getElementById('score-30').value = scores[30];
        document.getElementById('score-45').value = scores[45];
        document.getElementById('score-60').value = scores[60];
        document.getElementById('score-discharge').value = scores.discharge;

    }

    function clearAllCheckboxes() {
        // Uncheck all checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset all scores to 0
        updateScores();
    }

    // Add event listeners to ensure only one checkbox per category per time is selected
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const name = this.getAttribute('name');
            const time = this.getAttribute('data-time');

            // If this checkbox is checked, uncheck others in the same category and time
            if (this.checked) {
                document.querySelectorAll(`input[name="${name}"][data-time="${time}"]`).forEach(
                    otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
            }

            updateScores();
        });
    });

    $(document).ready(function() {


        $(document).on('click', '.addv', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md vdeleterow">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row

            $("#vitals").append(row);

            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.vdeleterow', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.medadd', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md meddelete">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row

            $("#med_rec").append(row);

            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.meddelete', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
