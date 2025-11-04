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
                            <h5 class="mt-2 mb-0">DOCTORS INHOUSE TRANSFER FORM</h5>
                            <small>IPD / Nurse Station / Ward to Critical Care Area / Critical Care Area to Ward</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.doc-inhouse-transfer-form-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('icu.doc-inhouse-transfer-form-store') }}" method="post"
                                        id="DOCINHOUSETRANSFERFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="icu_doc_inhouse_no_pk"
                                            value="{{ isset($doc_inhouse->icu_doc_inhouse_no_pk) ? $doc_inhouse->icu_doc_inhouse_no_pk : '' }}">


                                        <div class="table-responsive">



                                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <td><strong>Date & Time</strong>
                                                        <input type="datetime-local" name="date_time"
                                                            value="{{ isset($doc_inhouse->date_time) ? date('Y-m-d\TH:i', strtotime($doc_inhouse->date_time)) : '' }}">
                                                    </td>

                                                    <td><strong>Shifting From</strong>
                                                        <input type="text" name="shifting_from"
                                                            value="{{ @$doc_inhouse->shifting_from }}">
                                                    </td>
                                                    <td><strong>Bed</strong>
                                                        <input type="text" name="bed_from"
                                                            value="{{ @$doc_inhouse->bed_from }}">
                                                    </td>
                                                    <td><strong>Shifting To</strong>
                                                        <input type="text" name="shifting_to"
                                                            value="{{ @$doc_inhouse->shifting_to }}">
                                                    </td>
                                                    <td><strong>Bed</strong>
                                                        <input type="text" name="bed_to"
                                                            value="{{ @$doc_inhouse->bed_to }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Shifting From Doctor/Dept.</b></td>
                                                    <td><input type="text" name="sfdd"
                                                            value="{{ @$doc_inhouse->sfdd }}"></td>
                                                    <td><b>Shifting To Doctor/Dept.</b></td>
                                                    <td colspan="2"><input type="text" name="stdd"
                                                            value="{{ @$doc_inhouse->stdd }}"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Diagnosis:</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="3" name="diagnosis" style="width:100%">{{ @$doc_inhouse->diagnosis }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Reason for Transfer:</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="4" name="reason_transfer" style="width:100%">{{ @$doc_inhouse->reason_transfer }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Surgery Done:</strong></td>
                                                    <td>
                                                        <select name="surgery_done">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$doc_inhouse->surgery_done == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$doc_inhouse->surgery_done == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><strong>Date of Surgery & Time:</strong>
                                                        <input type="datetime-local" name="date_surgery"
                                                            value="{{ isset($doc_inhouse->date_surgery) ? date('Y-m-d\TH:i', strtotime($doc_inhouse->date_surgery)) : '' }}">
                                                    </td>
                                                    <td><strong>No. of Post Operative Days:</strong></td>
                                                    <td><input type="text" name="post_op_days"
                                                            value="{{ @$doc_inhouse->post_op_days }}"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Name of Surgery:</strong></td>
                                                    <td colspan="4"><input type="text" name="surgery_name"
                                                            style="width:100%"
                                                            value="{{ @$doc_inhouse->surgery_name }}"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Critical Report (Lab/Radiology):</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="3" name="critical_report" style="width:100%">{{ @$doc_inhouse->critical_report }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Cross Referrals / Follow up:</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="3" name="cross_referral" style="width:100%">{{ @$doc_inhouse->cross_referral }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Infection Control Precautions:</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="3" name="infection_control" style="width:100%">{{ @$doc_inhouse->infection_control }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Status at Time of Transfer:</strong></td>
                                                    <td colspan="4">
                                                        <textarea rows="4" name="status_transfer" style="width:100%">{{ @$doc_inhouse->status_transfer }}</textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <td colspan="2"><strong>Pain Rating Score</strong></td>
                                                    <td><select name="pain_score">
                                                            <option value="">Select</option>
                                                            <option value="0"
                                                                {{ @$doc_inhouse->pain_score == '0' ? 'selected' : '' }}>
                                                                0-No Hurt</option>
                                                            <option value="2"
                                                                {{ @$doc_inhouse->pain_score == '2' ? 'selected' : '' }}>
                                                                2-Hurts Little Bit</option>
                                                            <option value="4"
                                                                {{ @$doc_inhouse->pain_score == '4' ? 'selected' : '' }}>
                                                                4-Hurts Little More</option>
                                                            <option value="6"
                                                                {{ @$doc_inhouse->pain_score == '6' ? 'selected' : '' }}>
                                                                6-Hurts Even More</option>
                                                            <option value="8"
                                                                {{ @$doc_inhouse->pain_score == '8' ? 'selected' : '' }}>
                                                                8-Hurts Whole Lot</option>
                                                            <option value="10"
                                                                {{ @$doc_inhouse->pain_score == '10' ? 'selected' : '' }}>
                                                                10-Hurts Worst</option>
                                                        </select></td>
                                                    <td colspan="2"><strong>Location</strong></td>
                                                    <td colspan="3"><input type="text" name="location"
                                                            value="{{ @$doc_inhouse->location }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>Acuity:</strong></td>
                                                    <td colspan="6">
                                                        <label>
                                                            <input type="radio" name="acuity" value="Acute"
                                                                {{ @$doc_inhouse->acuity == 'Acute' ? 'checked' : '' }}>
                                                            Acute (<span class="acute-symbol">&lt;</span>6 weeks)
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="acuity" value="Chronic"
                                                                {{ @$doc_inhouse->acuity == 'Chronic' ? 'checked' : '' }}>
                                                            Chronic (≥6 weeks)
                                                        </label>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>Modifying Factors:</strong></td>
                                                    <td>Decreasing</td>
                                                    <td colspan="2"><input type="text" name="decreasing"
                                                            value="{{ @$doc_inhouse->decreasing }}"></td>
                                                    <td>Increasing</td>
                                                    <td colspan="2"><input type="text" name="increasing"
                                                            value="{{ @$doc_inhouse->increasing }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>Character:</strong></td>
                                                    <td colspan="6">
                                                        <label><input type="checkbox" name="character[]"
                                                                value="Sharp"
                                                                {{ in_array('Sharp', json_decode(@$doc_inhouse->character ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            Sharp
                                                        </label>

                                                        <label><input type="checkbox" name="character[]"
                                                                value="Dull"
                                                                {{ in_array('Dull', json_decode(@$doc_inhouse->character ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            Dull
                                                        </label>

                                                        <label><input type="checkbox" name="character[]"
                                                                value="Aching"
                                                                {{ in_array('Aching', json_decode(@$doc_inhouse->character ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            Aching
                                                        </label>

                                                        <label><input type="checkbox" name="character[]"
                                                                value="Burning"
                                                                {{ in_array('Burning', json_decode(@$doc_inhouse->character ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            Burning
                                                        </label>

                                                        <label><input type="checkbox" name="character[]"
                                                                value="Spasmodic"
                                                                {{ in_array('Spasmodic', json_decode(@$doc_inhouse->character ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            Spasmodic
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Temperature (°F):</strong></td>
                                                    <td><input type="text" name="temperature"
                                                            value="{{ @$doc_inhouse->temperature }}"></td>
                                                    <td><strong>Respiratory Rate (Per min):</strong></td>
                                                    <td><input type="text" name="resp_rate"
                                                            value="{{ @$doc_inhouse->resp_rate }}"></td>
                                                    <td><strong>Pulse (Per min):</strong></td>
                                                    <td><input type="text" name="pulse"
                                                            value="{{ @$doc_inhouse->pulse }}"></td>
                                                    <td><strong>Blood Pressure (mmHg):</strong></td>
                                                    <td><input type="text" name="bp"
                                                            value="{{ @$doc_inhouse->bp }}"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>GCS:</strong></td>
                                                    <td><input type="text" name="gcs"
                                                            value="{{ @$doc_inhouse->gcs }}"></td>
                                                    <td><strong>SpO₂:</strong></td>
                                                    <td><input type="text" name="spo2"
                                                            value="{{ @$doc_inhouse->spo2 }}"></td>
                                                    <td><strong>Oxygen:</strong></td>
                                                    <td>
                                                        <select name="oxygen">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$doc_inhouse->oxygen == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$doc_inhouse->oxygen == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>

                                                    </td>
                                                    <td><strong>Others:</strong></td>
                                                    <td><input type="text" name="others"
                                                            value="{{ @$doc_inhouse->others }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Medication Reconciliation done?</strong>

                                                    </td>
                                                    <td colspan="6">
                                                        <select name="med_recon">
                                                            <option value="">Select</option>
                                                            <option
                                                                value="Yes"{{ @$doc_inhouse->med_recon == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option
                                                                value="No"{{ @$doc_inhouse->med_recon == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="8">
                                                        <strong>Tubing/ Line Reconciliation:</strong>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>I/V line</td>
                                                    <td><input type="text" name="iv_line"
                                                            value="{{ @$doc_inhouse->iv_line }}"></td>
                                                    <td>Fluid Rate</td>
                                                    <td><input type="text" name="fluid_rate"
                                                            value="{{ @$doc_inhouse->fluid_rate }}"></td>
                                                    <td>Medication Running</td>
                                                    <td colspan="3"> <input type="text" name="med_running"
                                                            value="{{ @$doc_inhouse->med_running }}"></td>


                                                </tr>
                                                <tr>
                                                    <td>Foley’s</td>
                                                    <td> <input type="text" name="foley"
                                                            value="{{ @$doc_inhouse->foley }}"></td>
                                                    <td> NG tube </td>
                                                    <td><input type="text" name="ng_tube"
                                                            value="{{ @$doc_inhouse->ng_tube }}"></td>
                                                    <td>Other</td>
                                                    <td colspan="3"><input type="text" style="width: 100%"
                                                            name="line_other"
                                                            value="{{ @$doc_inhouse->line_other }}"></td>

                                                </tr>

                                                <tr>
                                                    <td colspan="8">
                                                        <strong>Special Concerns:</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>None </td>
                                                    <td colspan="7"><input type="text" name="special_none"
                                                            value="{{ @$doc_inhouse->special_none }}"></td>
                                                </tr>
                                                <tr>
                                                    <td> NPO </td>
                                                    <td colspan="7"> <input type="text" name="special_npo"
                                                            value="{{ @$doc_inhouse->special_npo }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Impairments:</td>

                                                    <td>Hearing<input type="text" name="imp_hearing"
                                                            value="{{ @$doc_inhouse->imp_hearing }}"></td>

                                                    <td>Visual<input type="text" name="imp_visual"
                                                            value="{{ @$doc_inhouse->imp_visual }}"></td>
                                                    <td>Cognitive <input type="text" name="imp_cognitive"
                                                            value="{{ @$doc_inhouse->imp_cognitive }}"></td>
                                                    <td>Mobility <input type="text" name="imp_mobility"
                                                            value="{{ @$doc_inhouse->imp_mobility }}"></td>
                                                    <td colspan="3"> Other <input type="text"
                                                            style="width: 100%" name="imp_other"
                                                            value="{{ @$doc_inhouse->imp_other }}"></td>
                                                </tr>
                                                <tr>

                                                    <td colspan="4"> Fall Risk (Score) <input type="text"
                                                            style="width: 100%" name="fall_risk"
                                                            value="{{ @$doc_inhouse->fall_risk }}">
                                                    </td>
                                                    <td colspan="2"> Skin Condition <input type="text"
                                                            style="width: 100%" name="skin_condition"
                                                            value="{{ @$doc_inhouse->skin_condition }}"></td>
                                                    <td colspan="2"> Bed Sore: if yes (Grade & Size) <input
                                                            type="text" style="width: 100%" name="bed_sore"
                                                            value="{{ @$doc_inhouse->bed_sore }}">
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td colspan="8">
                                                        <strong>Other Advice:</strong><br>
                                                        <textarea name="other_advice" style="width:100%; height:80px;">{{ @$doc_inhouse->other_advice }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="8">
                                                        <strong>Patient & Family Education:</strong><br>
                                                        <textarea name="family_edu" style="width:100%; height:80px;">{{ @$doc_inhouse->family_edu }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">Transfer order by:</td>
                                                    <td><input type="text" name="order_by" id="order_by"
                                                            class="form-control"
                                                            value="{{ @$doc_inhouse->order_by }}">
                                                        <input type="hidden" name="h_order_by" id="h_order_by"
                                                            class="form-control"
                                                            value="{{ @$doc_inhouse->h_order_by }}"></td>
                                                    <td colspan="3">Transfer informed to:</td>
                                                    <td><input type="text" class="form-control"
                                                            name="info_to" id="info_to"
                                                            value="{{ @$doc_inhouse->info_to }}">
                                                        <input type="hidden" class="form-control"
                                                            name="h_info_to" id="h_info_to"
                                                            value="{{ @$doc_inhouse->h_info_to }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">Date & Time:</td>
                                                    <td><input type="datetime-local" name="order_date"
                                                            class="form-control"
                                                            value="{{ isset($doc_inhouse->order_date) ? date('Y-m-d\TH:i', strtotime($doc_inhouse->order_date)) : '' }}">
                                                    </td>
                                                    <td colspan="3">Date & Time:</td>
                                                    <td><input type="datetime-local" name="info_date"
                                                            class="form-control"
                                                            value="{{ isset($doc_inhouse->info_date) ? date('Y-m-d\TH:i', strtotime($doc_inhouse->info_date)) : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">Transferred by:</td>
                                                    <td><input type="text" name="trans_by" id="trans_by"
                                                            class="form-control"
                                                            value="{{ @$doc_inhouse->trans_by }}">
                                                            <input type="hidden" name="h_trans_by" id="h_trans_by"
                                                            class="form-control"
                                                            value="{{ @$doc_inhouse->h_trans_by }}">
                                                        </td>
                                                    <td colspan="3">Received by:</td>
                                                    <td><input type="text" name="receiv_by" id="receiv_by" class="form-control"
                                                            value="{{ @$doc_inhouse->receiv_by }}">
                                                        <input type="hidden" name="h_receiv_by" id="h_receiv_by" class="form-control"
                                                            value="{{ @$doc_inhouse->h_receiv_by }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">Signature & Seal:</td>
                                                    <td>{{ @$doc_inhouse->trans_by }}</td>
                                                    <td colspan="3">Signature & Seal:</td>
                                                    <td>{{ @$doc_inhouse->receiv_by }}</td>
                                                </tr>
                                            </table>


                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.doc-inhouse-transfer-form', [
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
    openDoctorAutocomplete('#order_by', 'h_order_by', 'employee_ind', '1');
    openDoctorAutocomplete('#info_to', 'h_info_to', 'employee_ind', '1');
    openDoctorAutocomplete('#trans_by', 'h_trans_by', 'employee_ind', '1');
    openDoctorAutocomplete('#receiv_by', 'h_receiv_by', 'employee_ind', '1');


    openDoctorAutocomplete('#', '', 'employee_ind', '1');
    openDoctorAutocomplete('#', '', 'employee_ind', '1');
</script>
