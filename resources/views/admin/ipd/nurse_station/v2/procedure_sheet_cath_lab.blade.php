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


    textarea {
        width: 100%;
        height: 100%;
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 10px;
    }

    td,
    th {
        border: 1px solid black;
        padding: 6px;
        text-align: center;
    }

    .add-btn,
    .del-btn {
        cursor: pointer;
        font-size: 18px;
        padding: 2px 8px;
        border: 1px solid black;
        background: #f2f2f2;
    }

    .del-btn {
        color: red;
    }

    #vitalsTable input {
        width: 60px;
        /* adjust as needed */
        box-sizing: border-box;
    }

    #vitalsTable {
        border-collapse: collapse;
        width: 100%;
        /* table won’t overflow */
        table-layout: fixed;
        /* distribute evenly */
    }

    #vitalsTable th,
    #vitalsTable td {
        padding: 4px;
        text-align: center;
    }

    .table-wrapper {
        overflow-x: auto;
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
                            <h5 class="mt-2 mb-0">PROCEDURE SHEET WITHOUT SEDATION-CATH LAB</h5>
                            <small>IPD / Nurse Station / CATH LAB</small>
                        </div>
                        {{-- <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('without-sedation-cath-lab-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div> --}}
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
                                    <form action="{{ route('without-sedation-cath-lab-store') }}" method="post"
                                        id="PSWSCL">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="psws_cath_lab_no_pk"
                                            value="{{ isset($cath_lab->psws_cath_lab_no_pk) ? $cath_lab->psws_cath_lab_no_pk : '' }}">


                                        <div class="table-responsive">

                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    <td>Name of procedure:</td>
                                                    <td><input type="text" name="procedure_name"
                                                            value="{{ @$cath_lab->procedure_name }}"
                                                            style="width:100%"></td>
                                                    <td>Date of procedure:</td>
                                                    <td><input type="date" name="procedure_date"
                                                            value="{{ isset($cath_lab->procedure_date) ? date('Y-m-d', strtotime($cath_lab->procedure_date)) : '' }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Indication of procedure:</td>
                                                    <td colspan="3"><input type="text" name="procedure_indication"
                                                            value="{{ @$cath_lab->procedure_indication }}"
                                                            style="width:100%"></td>
                                                </tr>
                                                <tr>
                                                    <td>Known Allergy:</td>
                                                    <td colspan="3"><input type="text" name="known_allergy"
                                                            value="{{ @$cath_lab->known_allergy }}" style="width:100%">
                                                    </td>
                                                </tr>
                                            </table>

                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr style="background:#f2f2f2; font-weight:bold; text-align:center;">
                                                    <td colspan="2">PRE-PROCEDURE CHECKLIST (To be filled by nursing)
                                                    </td>
                                                    <td width="15%">YES</td>
                                                    <td width="15%">NO</td>
                                                    <td width="20%">NOT APPLICABLE</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Nil by mouth from:</td>
                                                    <td colspan="3">
                                                        <select name="nil_mouth" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->nil_mouth == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->nil_mouth == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->nil_mouth == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Vital signs recorded</td>
                                                    <td colspan="3">
                                                        <select name="vital_sign" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->vital_sign == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->vital_sign == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->vital_sign == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Pre-procedure medications given</td>
                                                    <td colspan="3">
                                                        <select name="pre_med" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->pre_med == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->pre_med == 'NO' ? 'selected' : '' }}>NO
                                                            </option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->pre_med == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">IV line in situ with heplock</td>
                                                    <td colspan="3">
                                                        <select name="iv_line" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->iv_line == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->iv_line == 'NO' ? 'selected' : '' }}>NO
                                                            </option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->iv_line == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Investigations reports received</td>
                                                    <td colspan="3">
                                                        <select name="investigations" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->investigations == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->investigations == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->investigations == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Dentures/eyeglass removed</td>
                                                    <td colspan="3">
                                                        <select name="dentures_removed" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->dentures_removed == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->dentures_removed == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->dentures_removed == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">History and physical examination completed</td>
                                                    <td colspan="3">
                                                        <select name="his_completed" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->his_completed == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->his_completed == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                            <option value="NOT APPLICABLE"
                                                                {{ @$cath_lab->his_completed == 'NOT APPLICABLE' ? 'selected' : '' }}>
                                                                NOT APPLICABLE</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>

                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse; text-align:center;">
                                                <tr style="background:#f2f2f2; font-weight:bold;">
                                                    <td>TIME</td>
                                                    <td>TEMPERATURE</td>
                                                    <td>HR/Pulse</td>
                                                    <td>RR</td>
                                                    <td>BP</td>
                                                    <td>SpO₂</td>
                                                    <td>Pain Score</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="pp_time"
                                                            value="{{ @$cath_lab->pp_time }}" style="width:100%">
                                                    </td>
                                                    <td><input type="text" name="pp_temp"
                                                            value="{{ @$cath_lab->pp_temp }}" style="width:100%">
                                                    </td>
                                                    <td><input type="text" name="hr_pulse"
                                                            value="{{ @$cath_lab->hr_pulse }}" style="width:100%">
                                                    </td>
                                                    <td><input type="text" name="pp_rr"
                                                            value="{{ @$cath_lab->pp_rr }}" style="width:100%"></td>
                                                    <td><input type="text" name="pp_bp"
                                                            value="{{ @$cath_lab->pp_bp }}" style="width:100%"></td>
                                                    <td><input type="text" name="pp_spo2"
                                                            value="{{ @$cath_lab->pp_spo2 }}" style="width:100%">
                                                    </td>
                                                    <td><input type="text" name="pp_pain"
                                                            value="{{ @$cath_lab->pp_pain }}" style="width:100%">
                                                    </td>
                                                </tr>
                                            </table>

                                            <br>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="6"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    <td>Nurse</td>
                                                    <td>Emp. ID</td>
                                                    <td>Time</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="nurse" id="nurse"
                                                            value="{{ @$cath_lab->nurse }}" style="width:100%">
                                                        <input type="hidden" name="hemp_id" id="hemp_id"
                                                            style="width:100%">
                                                    </td>
                                                    <td><input type="text" name="emp_id" id="emp_id"
                                                            value="{{ @$cath_lab->emp_id }}" style="width:100%"></td>
                                                    @php
                                                        $sign_time = explode(' ', @$cath_lab->sign_time);
                                                    @endphp
                                                    <td><input type="time" name="sign_time"
                                                            value="{{ $sign_time[1] ?? '' }}" style="width:100%">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table>
                                                <tr>
                                                    <th colspan="6">BLOOD REPORTS</th>
                                                </tr>
                                                <tr>
                                                    <td>Hb <input type="text" class="form-control" name="br_hb"
                                                            value="{{ @$cath_lab->br_hb }}">
                                                    </td>
                                                    <td colspan="3">PLT <input type="text" class="form-control"
                                                            name="br_plt" value="{{ @$cath_lab->br_plt }}"></td>
                                                    <td>RBS <input type="text" class="form-control" name="br_rbs"
                                                            value="{{ @$cath_lab->br_rbs }}"></td>
                                                    <td>HIV <input type="text" class="form-control" name="br_hiv"
                                                            value="{{ @$cath_lab->br_hiv }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>TRBC <input type="text" class="form-control"
                                                            name="br_trbc" value="{{ @$cath_lab->br_trbc }}"></td>
                                                    <td colspan="3">TLC <input type="text" class="form-control"
                                                            name="br_tlc" value="{{ @$cath_lab->br_tlc }}"></td>
                                                    <td>FBS <input type="text" class="form-control" name="br_fbs"
                                                            value="{{ @$cath_lab->br_fbs }}"></td>
                                                    <td>HCV <input type="text" class="form-control" name="br_hcv"
                                                            value="{{ @$cath_lab->br_hcv }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>PCV <input type="text" class="form-control" name="br_pcv"
                                                            value="{{ @$cath_lab->br_pcv }}"></td>
                                                    <td>DC <input type="text" class="form-control" name="br_dc"
                                                            value="{{ @$cath_lab->br_dc }}">
                                                    </td>
                                                    <td>N <input type="text" class="form-control" name="br_n"
                                                            value="{{ @$cath_lab->br_n }}">
                                                    </td>
                                                    <td>L <input type="text" class="form-control" name="br_l"
                                                            value="{{ @$cath_lab->br_l }}">
                                                    </td>
                                                    <td>UREA <input type="text" class="form-control"
                                                            name="br_urea" value="{{ @$cath_lab->br_urea }}"></td>
                                                    <td>HbsAg <input type="text" class="form-control"
                                                            name="br_hbsag" value="{{ @$cath_lab->br_hbsag }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>MCV <input type="text" class="form-control" name="br_mcv"
                                                            value="{{ @$cath_lab->br_mcv }}"></td>
                                                    <td colspan="2">M <input type="text" class="form-control"
                                                            name="br_m" value="{{ @$cath_lab->br_m }}"></td>
                                                    <td>E <input type="text" class="form-control" name="br_e"
                                                            value="{{ @$cath_lab->br_e }}">
                                                    </td>
                                                    <td>CREATININE <input type="text" class="form-control"
                                                            name="br_creatinine"
                                                            value="{{ @$cath_lab->br_creatinine }}"></td>
                                                    <td>APTT <input type="text" class="form-control"
                                                            name="br_aptt" value="{{ @$cath_lab->br_aptt }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>MCH <input type="text" class="form-control" name="br_mch"
                                                            value="{{ @$cath_lab->br_mch }}"></td>
                                                    <td colspan="3">ESR <input type="text" class="form-control"
                                                            name="br_esr" value="{{ @$cath_lab->br_esr }}"></td>
                                                    <td>SODIUM <input type="text" class="form-control"
                                                            name="br_sodium" value="{{ @$cath_lab->br_sodium }}">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>MCHC <input type="text" class="form-control"
                                                            name="br_mchc" value="{{ @$cath_lab->br_mchc }}"></td>
                                                    <td colspan="3">GROUP <input type="text"
                                                            class="form-control" name="br_group"
                                                            value="{{ @$cath_lab->br_group }}"></td>
                                                    <td>POTASSIUM <input type="text" class="form-control"
                                                            name="br_potassium"
                                                            value="{{ @$cath_lab->br_potassium }}"></td>
                                                    <td></td>
                                                </tr>


                                            </table>
                                            <table>
                                                <tr>
                                                    <td colspan="4" style="font-weight:bold; text-align:center;">
                                                        TIME OUT CHECKLIST (In cath lab before puncture/skin incision)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Name of procedure planned:</b></td>
                                                </tr>
                                                <tr>
                                                    <th>ELEMENTS</th>
                                                    <th>YES</th>
                                                    <th>NO</th>
                                                    <th>REMARKS</th>
                                                </tr>
                                                <tr>
                                                    <td>Patients name and ID checked?</td>
                                                    <td colspan="2">
                                                        <select name="pt_nameid" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->pt_nameid == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->pt_nameid == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks1"
                                                            value="{{ @$cath_lab->remarks1 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Consent for procedure obtained?</td>
                                                    <td colspan="2">
                                                        <select name="consent" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->consent == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->consent == 'NO' ? 'selected' : '' }}>NO
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks2"
                                                            value="{{ @$cath_lab->remarks2 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Is the correct site/side prepared and draped?</td>
                                                    <td colspan="2">
                                                        <select name="site_prepared" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->site_prepared == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->site_prepared == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks3"
                                                            value="{{ @$cath_lab->remarks3 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Is there anything unique or non-routine about this procedure?
                                                    </td>
                                                    <td colspan="2">
                                                        <select name="u_procedure" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->u_procedure == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->u_procedure == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks4"
                                                            value="{{ @$cath_lab->remarks4 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Availability of correct equipment/Implant/ Document?</td>
                                                    <td colspan="2">
                                                        <select name="correct_docu" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->correct_docu == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->correct_docu == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks5"
                                                            value="{{ @$cath_lab->remarks5 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Is relevant investigations/essential imaging available?</td>
                                                    <td colspan="2">
                                                        <select name="img_available" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->img_available == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->img_available == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks6"
                                                            value="{{ @$cath_lab->remarks6 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>HBsAg/Hepatitis C/HIV status checked? (If applicable)</td>
                                                    <td colspan="2">
                                                        <select name="hiv_status" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->hiv_status == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->hiv_status == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks7"
                                                            value="{{ @$cath_lab->remarks7 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Antibiotic prophylaxis given? (if applicable)</td>
                                                    <td colspan="2">
                                                        <select name="prophylaxis" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->prophylaxis == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->prophylaxis == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks8"
                                                            value="{{ @$cath_lab->remarks8 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sterility confirmed?</td>
                                                    <td colspan="2">
                                                        <select name="sterility" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->sterility == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->sterility == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="remarks9"
                                                            value="{{ @$cath_lab->remarks9 }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><b>TIME OUT DONE AT :</b></td>
                                                    @php
                                                        $timeout_done = explode(' ', @$cath_lab->timeout_done);
                                                    @endphp
                                                    <td><input type="time" name="timeout_done"
                                                            value="{{ $timeout_done[1] ?? '' }}" style="width:100%">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table>
                                                <tr>
                                                    <td>Doctor</td>
                                                    <td>
                                                        Name: <input type="text" name="doctor_name"
                                                            id="doctor_name" value="{{ @$cath_lab->doctor_name }}">
                                                        <input type="hidden" name="hdoctor_empid"
                                                            id="hdoctor_empid">
                                                    </td>
                                                    <td>Signature: {{ @$cath_lab->doctor_name }}</td>
                                                    <td>
                                                        Emp. ID: <input type="text" name="doctor_empid"
                                                            id="doctor_empid"
                                                            value="{{ @$cath_lab->doctor_empid }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Scrub Nurse</td>
                                                    <td>
                                                        Name: <input type="text" name="nurse_name" id="nurse_name"
                                                            value="{{ @$cath_lab->nurse_name }}">
                                                        <input type="hidden" name="hnurse_empid" id="hnurse_empid">
                                                    </td>
                                                    <td>Signature:{{ @$cath_lab->nurse_name }}</td>
                                                    <td>
                                                        Emp. ID:<input type="text" name="nurse_empid"
                                                            id="nurse_empid" value="{{ @$cath_lab->nurse_empid }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Technician (if applicable)</td>
                                                    <td>
                                                        Name: <input type="text" name="tech_name" id="tech_name"
                                                            value="{{ @$cath_lab->tech_name }}">
                                                        <input type="hidden" name="htech_empid" id="htech_empid">
                                                    </td>
                                                    <td>Signature:{{ @$cath_lab->tech_name }}</td>
                                                    <td>
                                                        Emp. ID: <input type="text" name="tech_empid"
                                                            id="tech_empid" value="{{ @$cath_lab->tech_empid }}">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table>
                                                <tr>
                                                    <td colspan="4">Procedure start time:</td>
                                                    <td>
                                                        @php
                                                            $p_start = explode(' ', @$cath_lab->p_start);
                                                        @endphp
                                                        <input type="time" name="p_start"
                                                            value="{{ $p_start[1] ?? '' }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Approach:</td>
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
                                            </table>

                                            @php
                                                // Intra-procedural vitals (paired cols)
                                                $time1_list = !empty($cath_lab->time1)
                                                    ? json_decode($cath_lab->time1, true)
                                                    : [];
                                                $hr1_list = !empty($cath_lab->hr1)
                                                    ? json_decode($cath_lab->hr1, true)
                                                    : [];
                                                $rr1_list = !empty($cath_lab->rr1)
                                                    ? json_decode($cath_lab->rr1, true)
                                                    : [];
                                                $bp1_list = !empty($cath_lab->bp1)
                                                    ? json_decode($cath_lab->bp1, true)
                                                    : [];

                                                $time2_list = !empty($cath_lab->time2)
                                                    ? json_decode($cath_lab->time2, true)
                                                    : [];
                                                $hr2_list = !empty($cath_lab->hr2)
                                                    ? json_decode($cath_lab->hr2, true)
                                                    : [];
                                                $rr2_list = !empty($cath_lab->rr2)
                                                    ? json_decode($cath_lab->rr2, true)
                                                    : [];
                                                $bp2_list = !empty($cath_lab->bp2)
                                                    ? json_decode($cath_lab->bp2, true)
                                                    : [];
                                            @endphp
                                            <table border="1" style="width:100%; text-align:center;">
                                                <tr>
                                                    <th colspan="9">INTRAPROCEDURAL VITALS MONITORING</th>
                                                </tr>
                                                <tr>
                                                    <th>TIME</th>
                                                    <th>HR</th>
                                                    <th>RR</th>
                                                    <th>BP</th>
                                                    <th>TIME</th>
                                                    <th>HR</th>
                                                    <th>RR</th>
                                                    <th>BP</th>
                                                    <th style="width: 6%">Action</th>
                                                </tr>
                                                <tbody id="vitalsTable">
                                                    @if (!empty($time1_list))
                                                        @foreach ($time1_list as $i => $time1)
                                                            <tr>
                                                                <td><input type="text" name="time1[]"
                                                                        value="{{ $time1 }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hr1[]"
                                                                        value="{{ $hr1_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="rr1[]"
                                                                        value="{{ $rr1_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="bp1[]"
                                                                        value="{{ $bp1_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="time2[]"
                                                                        value="{{ $time2_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hr2[]"
                                                                        value="{{ $hr2_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="rr2[]"
                                                                        value="{{ $rr2_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="bp2[]"
                                                                        value="{{ $bp2_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td>
                                                                    <span class="btn btn-success btn-md addvt"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <button type="button"
                                                                        class="btn btn-md btn-danger vtdeleterow">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="time1[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="hr1[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="rr1[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="bp1[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="time2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="hr2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="rr2[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="bp2[]"
                                                                    style="width:100%"></td>
                                                            <td><span class="btn btn-success btn-md addvt"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <table>
                                                <tr>
                                                    <td>Doctor</td>
                                                    <td>Name <input type="text" name="v_doc_name" id="v_doc_name"
                                                            value="{{ @$cath_lab->v_doc_name }}">
                                                        <input type="hidden" name="hv_doc_empid" id="hv_doc_empid">
                                                    </td>
                                                    <td>Emp. ID <input type="text" name="v_doc_empid"
                                                            id="v_doc_empid" value="{{ @$cath_lab->v_doc_empid }}">
                                                    </td>
                                                    @php
                                                        $v_doc_time = explode(' ', @$cath_lab->v_doc_time);
                                                    @endphp
                                                    <td>Time <input type="time" name="v_doc_time"
                                                            value="{{ $v_doc_time[1] ?? '' }}"></td>
                                                </tr>
                                            </table>

                                            <table>
                                                <tr>
                                                    <td colspan="4" style="font-weight:bold; text-align:center;">
                                                        SIGN OUT CHECKLIST (BEFORE PATIENT LEAVES CATH LAB)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Name of procedure done:</b></td>
                                                </tr>
                                                <tr>
                                                    <th>ELEMENTS</th>
                                                    <th>YES</th>
                                                    <th>NO</th>
                                                    <th>REMARKS</th>
                                                </tr>
                                                <tr>
                                                    <td>Instrument/sponge/needle counts are verified?</td>
                                                    <td colspan="2">
                                                        <select name="instrument" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->instrument == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->instrument == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="i_remarks"
                                                            value="{{ @$cath_lab->i_remarks }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Labelling of specimen done? (If any)</td>
                                                    <td colspan="2">
                                                        <select name="specimen" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->specimen == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->specimen == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="s_remarks"
                                                            value="{{ @$cath_lab->s_remarks }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Any equipment problem to be addressed?</td>
                                                    <td colspan="2">
                                                        <select name="equipment" style="width:100%">
                                                            <option value="">--Select--</option>
                                                            <option value="YES"
                                                                {{ @$cath_lab->equipment == 'YES' ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value="NO"
                                                                {{ @$cath_lab->equipment == 'NO' ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="e_remarks"
                                                            value="{{ @$cath_lab->e_remarks }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><b>Sign out done at :</b></td>
                                                    <td><input type="time" name="signout_done"
                                                            value="{{ @$cath_lab->signout_done }}"
                                                            style="width:100%"></td>
                                                </tr>
                                            </table>

                                            <table>
                                                <tr>
                                                    <td>Scrub Nurse</td>
                                                    <td colspan="2">Name: <input type="text" name="nurse_name2"
                                                            id="nurse_name2" value="{{ @$cath_lab->nurse_name2 }}">
                                                        <input type="hidden" name="h_nurse_name2" id="h_nurse_name2"
                                                            value="{{ @$cath_lab->h_nurse_name2 }}">
                                                    </td>
                                                    <td>Signature:{{ @$cath_lab->nurse_name2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Technician (if applicable)</td>
                                                    <td colspan="2">Name: <input type="text" name="tech_name2"
                                                            id="tech_name2"
                                                            value="{{ @$cath_lab->tech_name2 }}"><input
                                                            type="hidden" name="h_tech_name2" id="h_tech_name2"
                                                            value="{{ @$cath_lab->h_tech_name2 }}"></td>
                                                    <td>Signature: {{ @$cath_lab->tech_name2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>PROCEDURE NOTES</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: left">Findings:</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="finding" rows="10">{{ @$cath_lab->finding }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: left">Recommendation:</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="recommend" rows="10">{{ @$cath_lab->recommend }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Doctor</td>
                                                    <td>Name: <input type="text" name="proce_docname"
                                                            id="proce_docname"
                                                            value="{{ @$cath_lab->proce_docname }}">
                                                        <input type="hidden" name="hproce_empid" id="hproce_empid">
                                                    </td>
                                                    <td>Emp. ID: <input type="text" name="proce_empid"
                                                            id="proce_empid" value="{{ @$cath_lab->proce_empid }}">
                                                    </td>
                                                    @php
                                                        $proce_time = explode(' ', @$cath_lab->proce_time);
                                                    @endphp
                                                    <td>Time: <input type="time" name="proce_time"
                                                            value="{{ $proce_time[1] ?? '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: left">CORONARY ANGIOGRAM
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea name="coronary" rows="15">{{ @$cath_lab->coronary }}</textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            @php
                                                $time_list = !empty($cath_lab->time)
                                                    ? json_decode($cath_lab->time, true)
                                                    : [];
                                                $temp_list = !empty($cath_lab->temp)
                                                    ? json_decode($cath_lab->temp, true)
                                                    : [];
                                                $hr_list = !empty($cath_lab->hr)
                                                    ? json_decode($cath_lab->hr, true)
                                                    : [];
                                                $rr_list = !empty($cath_lab->rr)
                                                    ? json_decode($cath_lab->rr, true)
                                                    : [];
                                                $bp_list = !empty($cath_lab->bp)
                                                    ? json_decode($cath_lab->bp, true)
                                                    : [];
                                                $spo2_list = !empty($cath_lab->spo2)
                                                    ? json_decode($cath_lab->spo2, true)
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
                                                                <td><input type="text" name="temp[]"
                                                                        value="{{ $temp_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hr[]"
                                                                        value="{{ $hr_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="rr[]"
                                                                        value="{{ $rr_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="bp[]"
                                                                        value="{{ $bp_list[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="spo2[]"
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
                                                            <td><input type="text" name="temp[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="hr[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="rr[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="bp[]"
                                                                    style="width:100%"></td>
                                                            <td><input type="text" name="spo2[]"
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
                                            </table>


                                            <table style="width:100%">
                                                <tr>
                                                    <td>Pain Score:</td>
                                                    <td><input type="text" name="pain_score"
                                                            value="{{ @$cath_lab->pain_score }}"
                                                            class="form-control"></td>
                                                    <td>Fall Score:</td>
                                                    <td><input type="text" name="fall_score"
                                                            value="{{ @$cath_lab->fall_score }}"
                                                            class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Nurse</td>
                                                    <td>Name <input type="text" name="vnurse" id="vnurse"
                                                            value="{{ @$cath_lab->vnurse }}"><input type="hidden"
                                                            name="hvnurse_empid" id="hvnurse_empid"></td>
                                                    <td>Emp. ID <input type="text" name="vnurse_empid"
                                                            id="vnurse_empid"
                                                            value="{{ @$cath_lab->vnurse_empid }}"> </td>
                                                    @php
                                                        $vnurse_time = explode(' ', @$cath_lab->vnurse_time);
                                                    @endphp
                                                    <td>Time <input type="time" name="vnurse_time"
                                                            value="{{ $vnurse_time[1] ?? '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: left"><b>Nursing Notes:</b>
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
                                                                value="post_cath"
                                                                {{ in_array('post_cath', $transfer) ? 'checked' : '' }}>
                                                            Post cath</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="sicu"
                                                                {{ in_array('sicu', $transfer) ? 'checked' : '' }}>
                                                            SICU</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="ccu"
                                                                {{ in_array('ccu', $transfer) ? 'checked' : '' }}>
                                                            CCU</label>
                                                        <label><input type="checkbox" name="transfer[]"
                                                                value="others"
                                                                {{ in_array('others', $transfer) ? 'checked' : '' }}>
                                                            Others</label>
                                                        <input type="text" name="t_others"
                                                            value="{{ @$cath_lab->t_others }}"
                                                            placeholder="If Others,Specify" style="width: 50%">
                                                    </td>
                                                </tr>
                                            </table>


                                            <table style="width:100%">
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
                                            </table>

                                            {{-- medi table --}}
                                            <table class="table border-0 mt-2 mb-0 medicine_add_table"
                                                id="medicine_list">
                                                <thead class="medicine_thead">
                                                    <tr>
                                                        <th colspan="7" style="text-align: center">MEDICATION
                                                            RECORD</th>
                                                    </tr>
                                                    <tr class="border-0">
                                                        <th class="py-1 border-0 w-25">Medicine/Surgical</th>
                                                        <th class="py-1 px-1 border-0 w-15">Route</th>
                                                        <th class="py-1 px-1 border-0 w-15">Frequency</th>
                                                        <th class="py-1 px-1 border-0 w-15">Duration</th>
                                                        <th class="py-1 px-1 border-0 w-8">Qty.</th>
                                                        <th class="py-1 px-1 border-0 w-16">Instruction</th>
                                                        <th class="py-1 px-1 border-0 w-6">Action</th>
                                                    </tr>


                                                </thead>
                                                <tbody id="medicineTable">
                                                    @php
                                                        $medicine_items = !empty($cath_lab->medicine_item_master)
                                                            ? json_decode($cath_lab->medicine_item_master, true)
                                                            : [];
                                                        $medicine_routes = !empty($cath_lab->medicine_route_master)
                                                            ? json_decode($cath_lab->medicine_route_master, true)
                                                            : [];
                                                        $medicine_doses = !empty($cath_lab->medicine_dose_master)
                                                            ? json_decode($cath_lab->medicine_dose_master, true)
                                                            : [];
                                                        $medicine_durations = !empty(
                                                            $cath_lab->medicine_duration_type_master
                                                        )
                                                            ? json_decode(
                                                                $cath_lab->medicine_duration_type_master,
                                                                true,
                                                            )
                                                            : [];
                                                        $medicine_duration_mu = !empty(
                                                            $cath_lab->medicine_duration_mu_master
                                                        )
                                                            ? json_decode($cath_lab->medicine_duration_mu_master, true)
                                                            : [];
                                                        $medicine_quantities = !empty(
                                                            $cath_lab->medicine_quantity_master
                                                        )
                                                            ? json_decode($cath_lab->medicine_quantity_master, true)
                                                            : [];
                                                        $medicine_instructions = !empty($cath_lab->instruction_master)
                                                            ? json_decode($cath_lab->instruction_master, true)
                                                            : [];
                                                    @endphp

                                                    @if (!empty($medicine_items))
                                                        @foreach ($medicine_items as $i => $med)
                                                            <tr>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm item_element"
                                                                        name="medicine_item_master[]"
                                                                        id="medicine_item_master"
                                                                        value="{{ $med }}">
                                                                    <input type="hidden"
                                                                        name="hdn_medicine_item_id_master[]"
                                                                        id="hdn_medicine_item_id_master">
                                                                    <input type="hidden"
                                                                        name="hdn_report_serial_med_master[]"
                                                                        value="1">
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-control form-control-sm select2 medicine_route"
                                                                        name="medicine_route_master[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($route as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ ($medicine_routes[$i] ?? '') == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-control form-control-sm select2 medicine_dose"
                                                                        name="medicine_dose_master[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($dose as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ ($medicine_doses[$i] ?? '') == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="number" step="0.01"
                                                                            class="form-control form-control-sm medicine_duration"
                                                                            name="medicine_duration_type_master[]"
                                                                            value="{{ $medicine_durations[$i] ?? '' }}">
                                                                        <select
                                                                            class="form-control medicine_duration_mu"
                                                                            name="medicine_duration_mu_master[]">
                                                                            <option value="0">Select</option>
                                                                            @foreach ($meddurmu as $key => $dmu)
                                                                                <option
                                                                                    value="{{ strtoupper($key) }}"
                                                                                    {{ ($medicine_duration_mu[$i] ?? '') == strtoupper($key) ? 'selected' : '' }}>
                                                                                    {{ $dmu['data'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control form-control-sm medicine_quantity"
                                                                        name="medicine_quantity_master[]"
                                                                        value="{{ $medicine_quantities[$i] ?? '' }}">
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-control form-control-sm select2 instruction"
                                                                        name="instruction_master[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($instructions as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ ($medicine_instructions[$i] ?? '') == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td class="text-center">
                                                                    <span class="btn btn-success btn-md add"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-danger btn-md deleterow"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        {{-- fallback empty row --}}
                                                        <tr>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm item_element"
                                                                    name="medicine_item_master[]"
                                                                    id="medicine_item_master">
                                                                <input type="hidden"
                                                                    name="hdn_medicine_item_id_master[]"
                                                                    id="hdn_medicine_item_id_master">
                                                                <input type="hidden"
                                                                    name="hdn_report_serial_med_master[]"
                                                                    value="1">
                                                            </td>
                                                            <td>
                                                                <select
                                                                    class="form-control form-control-sm select2 medicine_route"
                                                                    name="medicine_route_master[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($route as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select
                                                                    class="form-control form-control-sm select2 medicine_dose"
                                                                    name="medicine_dose_master[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($dose as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" step="0.01"
                                                                        class="form-control form-control-sm medicine_duration"
                                                                        name="medicine_duration_type_master[]">
                                                                    <select class="form-control medicine_duration_mu"
                                                                        name="medicine_duration_mu_master[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($meddurmu as $key => $dmu)
                                                                            <option value="{{ strtoupper($key) }}">
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td><input type="number" step="0.01"
                                                                    class="form-control form-control-sm medicine_quantity"
                                                                    name="medicine_quantity_master[]"></td>
                                                            <td>
                                                                <select
                                                                    class="form-control form-control-sm select2 instruction"
                                                                    name="instruction_master[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($instructions as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="btn btn-success btn-md add"><i
                                                                        class="fa fa-plus"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table> <br>

                                            <table>
                                                <tr>
                                                    <td colspan="4"><b>VASCULAR ACCESS MONITORING</b></td>
                                                    <td>
                                                        @php
                                                            $v_start = explode(' ', @$cath_lab->v_start);
                                                        @endphp
                                                        <input type="time" name="v_start"
                                                            value="{{ $v_start[1] ?? '' }}" style="width:100%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Vascular Access Site:</td>
                                                    <td>RADIAL
                                                        <select name="v_radial">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->v_radial == 'R' ? 'selected' : '' }}>
                                                                R</option>
                                                            <option value="L"
                                                                {{ @$cath_lab->v_radial == 'L' ? 'selected' : '' }}>
                                                                L</option>
                                                        </select>
                                                    </td>
                                                    <td>FEMORAL
                                                        <select name="v_femoral">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->v_femoral == 'R' ? 'selected' : '' }}>
                                                                R</option>
                                                            <option value="L"
                                                                {{ @$cath_lab->v_femoral == 'L' ? 'selected' : '' }}>
                                                                L</option>
                                                        </select>
                                                    </td>
                                                    <td>ULNER
                                                        <select name="v_ulner">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->v_ulner == 'R' ? 'selected' : '' }}>
                                                                R</option>
                                                            <option value="L"
                                                                {{ @$cath_lab->v_ulner == 'L' ? 'selected' : '' }}>
                                                                L</option>
                                                        </select>
                                                    </td>
                                                    <td>OTHER
                                                        <select name="v_other">
                                                            <option value="">Select</option>
                                                            <option value="R"
                                                                {{ @$cath_lab->v_other == 'R' ? 'selected' : '' }}>
                                                                R</option>
                                                            <option value="L"
                                                                {{ @$cath_lab->v_other == 'L' ? 'selected' : '' }}>
                                                                L</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Vitals at arrival of Patient:</td>
                                                    <td>BP: <input type="text" name="pt_bp"
                                                            value="{{ @$cath_lab->pt_bp }}"></td>
                                                    <td>HR: <input type="text" name="pt_hr"
                                                            value="{{ @$cath_lab->pt_hr }}"></td>
                                                    <td>RR: <input type="text" name="pt_rr"
                                                            value="{{ @$cath_lab->pt_rr }}"></td>
                                                    <td>TEMP: <input type="text" name="pt_temp"
                                                            value="{{ @$cath_lab->pt_temp }}"></td>
                                                </tr>
                                            </table>

                                            <table>
                                                <tr>
                                                    <th rowspan="2"></th>
                                                    <th rowspan="2">Time</th>
                                                    <th rowspan="2">Hematoma <br>(Present/Absent)</th>
                                                    <th colspan="2">Distal Pulses <br>(0=Absent, +1=Feeble,
                                                        +2=Normal, +3=Strong, +4=Bounding)</th>
                                                    <th rowspan="2">Initials With ID</th>
                                                    <th rowspan="2">Remarks</th>
                                                </tr>
                                                <tr>
                                                    <th>Posterior Tibial Artery</th>
                                                    <th>Dorsalis Pedis Artery</th>
                                                </tr>

                                                <tr>
                                                    <td>Baseline</td>
                                                    <td><input type="text" name="t_baseline"
                                                            value="{{ @$cath_lab->t_baseline }}"></td>
                                                    <td><input type="text" name="hema_baseline"
                                                            value="{{ @$cath_lab->hema_baseline }}"></td>
                                                    <td><input type="text" name="tibial_baseline"
                                                            value="{{ @$cath_lab->tibial_baseline }}"></td>
                                                    <td><input type="text" name="pedis_baseline"
                                                            value="{{ @$cath_lab->pedis_baseline }}"></td>
                                                    <td><input type="text" name="initials_baseline"
                                                            value="{{ @$cath_lab->initials_baseline }}"></td>
                                                    <td><input type="text" name="remarks_baseline"
                                                            value="{{ @$cath_lab->remarks_baseline }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>30 min</td>
                                                    <td><input type="text" name="t_30"
                                                            value="{{ @$cath_lab->t_30 }}"></td>
                                                    <td><input type="text" name="hema_30"
                                                            value="{{ @$cath_lab->hema_30 }}"></td>
                                                    <td><input type="text" name="tibial_30"
                                                            value="{{ @$cath_lab->tibial_30 }}"></td>
                                                    <td><input type="text" name="pedis_30"
                                                            value="{{ @$cath_lab->pedis_30 }}"></td>
                                                    <td><input type="text" name="initials_30"
                                                            value="{{ @$cath_lab->initials_30 }}"></td>
                                                    <td><input type="text" name="remarks_30"
                                                            value="{{ @$cath_lab->remarks_30 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>60 min</td>
                                                    <td><input type="text" name="t_60"
                                                            value="{{ @$cath_lab->t_60 }}"></td>
                                                    <td><input type="text" name="hema_60"
                                                            value="{{ @$cath_lab->hema_60 }}"></td>
                                                    <td><input type="text" name="tibial_60"
                                                            value="{{ @$cath_lab->tibial_60 }}"></td>
                                                    <td><input type="text" name="pedis_60"
                                                            value="{{ @$cath_lab->pedis_60 }}"></td>
                                                    <td><input type="text" name="initials_60"
                                                            value="{{ @$cath_lab->initials_60 }}"></td>
                                                    <td><input type="text" name="remarks_60"
                                                            value="{{ @$cath_lab->remarks_60 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>90 min</td>
                                                    <td><input type="text" name="t_90"
                                                            value="{{ @$cath_lab->t_90 }}"></td>
                                                    <td><input type="text" name="hema_90"
                                                            value="{{ @$cath_lab->hema_90 }}"></td>
                                                    <td><input type="text" name="tibial_90"
                                                            value="{{ @$cath_lab->tibial_90 }}"></td>
                                                    <td><input type="text" name="pedis_90"
                                                            value="{{ @$cath_lab->pedis_90 }}"></td>
                                                    <td><input type="text" name="initials_90"
                                                            value="{{ @$cath_lab->initials_90 }}"></td>
                                                    <td><input type="text" name="remarks_90"
                                                            value="{{ @$cath_lab->remarks_90 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>2 hr</td>
                                                    <td><input type="text" name="t_2"
                                                            value="{{ @$cath_lab->t_2 }}"></td>
                                                    <td><input type="text" name="hema_2"
                                                            value="{{ @$cath_lab->hema_2 }}"></td>
                                                    <td><input type="text" name="tibial_2"
                                                            value="{{ @$cath_lab->tibial_2 }}"></td>
                                                    <td><input type="text" name="pedis_2"
                                                            value="{{ @$cath_lab->pedis_2 }}"></td>
                                                    <td><input type="text" name="initials_2"
                                                            value="{{ @$cath_lab->initials_2 }}"></td>
                                                    <td><input type="text" name="remarks_2"
                                                            value="{{ @$cath_lab->remarks_2 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>3 hr</td>
                                                    <td><input type="text" name="t_3"
                                                            value="{{ @$cath_lab->t_3 }}"></td>
                                                    <td><input type="text" name="hema_3"
                                                            value="{{ @$cath_lab->hema_3 }}"></td>
                                                    <td><input type="text" name="tibial_3"
                                                            value="{{ @$cath_lab->tibial_3 }}"></td>
                                                    <td><input type="text" name="pedis_3"
                                                            value="{{ @$cath_lab->pedis_3 }}"></td>
                                                    <td><input type="text" name="initials_3"
                                                            value="{{ @$cath_lab->initials_3 }}"></td>
                                                    <td><input type="text" name="remarks_3"
                                                            value="{{ @$cath_lab->remarks_3 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>4 hr</td>
                                                    <td><input type="text" name="t_4"
                                                            value="{{ @$cath_lab->t_4 }}"></td>
                                                    <td><input type="text" name="hema_4"
                                                            value="{{ @$cath_lab->hema_4 }}"></td>
                                                    <td><input type="text" name="tibial_4"
                                                            value="{{ @$cath_lab->tibial_4 }}"></td>
                                                    <td><input type="text" name="pedis_4"
                                                            value="{{ @$cath_lab->pedis_4 }}"></td>
                                                    <td><input type="text" name="initials_4"
                                                            value="{{ @$cath_lab->initials_4 }}"></td>
                                                    <td><input type="text" name="remarks_4"
                                                            value="{{ @$cath_lab->remarks_4 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>5 hr</td>
                                                    <td><input type="text" name="t_5"
                                                            value="{{ @$cath_lab->t_5 }}"></td>
                                                    <td><input type="text" name="hema_5"
                                                            value="{{ @$cath_lab->hema_5 }}"></td>
                                                    <td><input type="text" name="tibial_5"
                                                            value="{{ @$cath_lab->tibial_5 }}"></td>
                                                    <td><input type="text" name="pedis_5"
                                                            value="{{ @$cath_lab->pedis_5 }}"></td>
                                                    <td><input type="text" name="initials_5"
                                                            value="{{ @$cath_lab->initials_5 }}"></td>
                                                    <td><input type="text" name="remarks_5"
                                                            value="{{ @$cath_lab->remarks_5 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>6 hr</td>
                                                    <td><input type="text" name="t_6"
                                                            value="{{ @$cath_lab->t_6 }}"></td>
                                                    <td><input type="text" name="hema_6"
                                                            value="{{ @$cath_lab->hema_6 }}"></td>
                                                    <td><input type="text" name="tibial_6"
                                                            value="{{ @$cath_lab->tibial_6 }}"></td>
                                                    <td><input type="text" name="pedis_6"
                                                            value="{{ @$cath_lab->pedis_6 }}"></td>
                                                    <td><input type="text" name="initials_6"
                                                            value="{{ @$cath_lab->initials_6 }}"></td>
                                                    <td><input type="text" name="remarks_6"
                                                            value="{{ @$cath_lab->remarks_6 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>8 hr</td>
                                                    <td><input type="text" name="t_8"
                                                            value="{{ @$cath_lab->t_8 }}"></td>
                                                    <td><input type="text" name="hema_8"
                                                            value="{{ @$cath_lab->hema_8 }}"></td>
                                                    <td><input type="text" name="tibial_8"
                                                            value="{{ @$cath_lab->tibial_8 }}"></td>
                                                    <td><input type="text" name="pedis_8"
                                                            value="{{ @$cath_lab->pedis_8 }}"></td>
                                                    <td><input type="text" name="initials_8"
                                                            value="{{ @$cath_lab->initials_8 }}"></td>
                                                    <td><input type="text" name="remarks_8"
                                                            value="{{ @$cath_lab->remarks_8 }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>12 hr</td>
                                                    <td><input type="text" name="t_12"
                                                            value="{{ @$cath_lab->t_12 }}"></td>
                                                    <td><input type="text" name="hema_12"
                                                            value="{{ @$cath_lab->hema_12 }}"></td>
                                                    <td><input type="text" name="tibial_12"
                                                            value="{{ @$cath_lab->tibial_12 }}"></td>
                                                    <td><input type="text" name="pedis_12"
                                                            value="{{ @$cath_lab->pedis_12 }}"></td>
                                                    <td><input type="text" name="initials_12"
                                                            value="{{ @$cath_lab->initials_12 }}"></td>
                                                    <td><input type="text" name="remarks_12"
                                                            value="{{ @$cath_lab->remarks_12 }}"></td>
                                                </tr>
                                            </table>


                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('v2.ipd.nurse-note', $admission_id);
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
    openDoctorAutocomplete('#nurse', 'hemp_id', 'employee_ind', '1');
    openDoctorAutocomplete('#doctor_name', 'hdoctor_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse_name', 'hnurse_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_name', 'htech_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse_name2', 'h_nurse_name2', 'employee_ind', '1');
    openDoctorAutocomplete('#tech_name2', 'h_tech_name2', 'employee_ind', '1');
    openDoctorAutocomplete('#proce_docname', 'hproce_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#trans_name', 'htrans_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#recv_name', 'hrecv_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#vnurse', 'hvnurse_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#v_doc_name', 'hv_doc_empid', 'employee_ind', '1');
    openItemAutocompleteWithStockPrescription($("#medicine_item_master"), 'MED', '#hdn_medicine_item_id_master',
        '#medicine_item_master');
    openItemAutocompleteWithStockPrescription($("#mr_drug"), 'MED', '#hdn_mr_drug',
        '#mr_drug');

    document.addEventListener("click", function(e) {
        $(document).on('click', '.add', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md deleterow">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row

            $("#medicineTable").append(row);

            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.deleterow', function() {
            $(this).closest('tr').remove();
        });

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

        $(document).on('click', '.addvt', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md vtdeleterow">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row

            $("#vitalsTable").append(row);

            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.vtdeleterow', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
</script>
