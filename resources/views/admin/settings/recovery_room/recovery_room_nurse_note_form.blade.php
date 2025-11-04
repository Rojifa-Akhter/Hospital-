<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<style>
    *,
    *::after,
    *::before {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    body {
        margin: 0;
        /* font-size: 14px; */
        /* background: #F4F3FE; */
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ol,
    li,
    a {
        margin-bottom: 0;
        list-style: none;
    }

    a,
    a:hover {
        text-decoration: none;
    }

    .anaesthetic__form {
        padding: 25px 0px;
        position: relative;


    }

    .anaesthetic__form fieldset {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        padding-block-start: 0.35em;
        padding-inline-start: 0.75em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        min-inline-size: min-content;
        border-width: 1px;
        border-style: groove;
        border-color: #ffffff5e;
        border-image: initial;
    }

    .anaesthetic__form legend {
        display: block;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
        border-width: initial;
        border-style: none;
        border-color: initial;
        border-image: initial;
        width: auto;
        font-size: 18px;
        font-weight: 600;
    }

    .anaesthetic__form .card {
        background-color: #fff0;

    }

    .col-form-label {
        font-size: 14px !important;
        font-weight: 700;
        color: #33449d;
    }

    img {
        max-width: 100%;
    }

    .header-info {
        float: right;
        overflow: hidden;
    }

    .header-info h1 {
        font-size: 35px;
        font-weight: 800;
        color: #970307;
    }

    .header-info h6 {
        font-size: 12px;
        font-weight: 400;
        font-style: italic;
    }

    .header-info p {
        font-size: 14px;
        font-weight: 500;
    }

    .card-header h4.card-title {
        font-size: 18px;
        font-weight: 600;
        color: #c9272b;
    }

    .capital_letter {
        display: block;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        color: #33449d;
    }

    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Upload";
    }

    .modal_link {
        text-decoration: underline;
        cursor: pointer;
    }

    .btn {
        display: inline-block;
        padding: 5px 15px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 3px;
        transition: all 0.3s linear;
    }

    .btn-draft {
        background: #277ff5;
        border: 1px solid #277ff5;

    }

    .btn-preview {
        background: #2E2E2E;
        border: 1px solid #2E2E2E;
    }

    .btn-submit {
        background: #0066A2;
        border: 1px solid #0066A2;

    }

    .btn-draft:hover,
    .btn-preview:hover,
    .btn-submit:hover {
        background: transparent;
        color: #333;
    }


    .attested_section li {
        list-style: inside !important;
        font-size: 14px;
        font-weight: 400;
    }

    .custom-checkbox span {
        font-weight: 500;
        transition: all 0.3s;
    }

    .custom-checkbox span:hover {
        color: #33449d;
    }

    @media (max-width: 767px) {
        .admission_form img {
            max-width: 60%;
            display: block;
            margin: auto;
        }

        .header-info h1 {
            font-size: 25px;
            margin-top: 20px;
        }
    }

    .redactor_editor {
        min-height: 450px !important;
    }

    #cke_1_contents {
        min-height: 100px;
        width: 630px;
    }

    th,
    td {
        padding: 5px;
    }

    select {
        width: 50px;
    }

    .section-title {
        text-align: center;
        font-weight: bold;


    }

    .large-select {

        padding: 0.75rem 1rem;
        /* Vertical and horizontal padding */
        height: auto;
        /* Let padding control the height */
        border-radius: 0.5rem;
        /* Smooth rounded corners */
        border: 1px solid #ccc;
        /* Light gray border */
        width: 40%;
        /* Full width if inside a form */
        box-sizing: border-box;
        /* Include padding in width */
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm align-items-center">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Nurse's Note</h5>
                <small>Report / Nurse's Note Form</small>
            </div>
        </div>


        <div class="nursesNotes__form">
            <form action="{{ route('ipd.store-recovery-room-nurses-note') }}" method="post" id="NURSESNOTEFORM">
                @csrf
                <input type="hidden"
                    value="{{ isset($nurse_info->rr_nursenote_no_pk) ? $nurse_info->rr_nursenote_no_pk : '' }}"
                    name="rr_nursenote_no_pk">
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_data->admission_no_pk) ? $pat_data->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_data->patient_no_pk) ? $pat_data->patient_no_pk : '' }}">

                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header text-center">
                                <h2 class="card-title mb-0 text-left"> <strong>
                                        <h3>Recovery Room : Nurse's Note</h3>
                                    </strong>
                                </h2>
                            </div>


                            <table width="100%" border="1" style="margin-bottom: 10px">
                                <tr>
                                    <td><strong>UHID:</strong> <input type="text" name="uhid"
                                            value="{{ isset($pat_data->patient_code) ? $pat_data->patient_code : '' }}" />
                                    </td>
                                    <td colspan="2"><strong>Patient Name:</strong> <input type="text" name="patient_name"
                                            value="{{ isset($pat_data->patient_name) ? $pat_data->patient_name : '' }}" />
                                    </td>
                                    {{-- <td><strong>Cabin:</strong> <input type="text" name="cabin_bed"
                                            value="{{ isset($pat_data->new_ward_name) ? $pat_data->new_ward_name : '' }}" />
                                    </td> --}}
                                </tr>

                                <tr>
                                    <td><strong>Received at Date & Time:</strong> <input type="datetime-local"
                                            name="received_date"
                                            value="{{ isset($nurse_info->received_date) ? date('Y-m-d\TH:i', strtotime($nurse_info->received_date)) : '' }}" />
                                    </td>
                                    <td><strong>Transfer out at:</strong>
                                        @php
                                            $transfer_out = explode(' ', @$nurse_info->transfer_out);
                                        @endphp
                                        <input type="time" name="transfer_out"
                                            value="{{ $transfer_out[1] ?? '' }}" />
                                    </td>
                                    @php
                                        $anesthesiaTypes =
                                            json_decode($nurse_info->anesthesia_type ?? '[]', true) ?? [];
                                    @endphp

                                    <td>
                                        <strong>Type of anesthesia:</strong><br>

                                        <label>
                                            <input type="checkbox" name="anesthesia_type[]" value="General"
                                                {{ in_array('General', $anesthesiaTypes) ? 'checked' : '' }}>
                                            General
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="anesthesia_type[]" value="Spinal"
                                                {{ in_array('Spinal', $anesthesiaTypes) ? 'checked' : '' }}>
                                            Spinal
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="anesthesia_type[]" value="Epidural"
                                                {{ in_array('Epidural', $anesthesiaTypes) ? 'checked' : '' }}>
                                            Epidural
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="anesthesia_type[]" value="TIVA"
                                                {{ in_array('TIVA', $anesthesiaTypes) ? 'checked' : '' }}>
                                            TIVA
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="anesthesia_type[]" value="LA"
                                                {{ in_array('LA', $anesthesiaTypes) ? 'checked' : '' }}>
                                            LA
                                        </label>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label><strong>Others:</strong></label>
                                        <input type="text" name="anesthesia_others" style="width: 90%;"
                                            value="{{ isset($nurse_info->anesthesia_others) ? $nurse_info->anesthesia_others : '' }}" />


                                    </td>

                                </tr>
                                @php
                                    $airwayDevices = json_decode($nurse_info->airway_device ?? '[]', true) ?? [];
                                @endphp

                                <tr>
                                    <td colspan="3">
                                        <strong>Airway Device:</strong>

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="Nil"
                                                {{ in_array('Nil', $airwayDevices) ? 'checked' : '' }}>
                                            Nil
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="Oral"
                                                {{ in_array('Oral', $airwayDevices) ? 'checked' : '' }}>
                                            Oral
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="Nasal"
                                                {{ in_array('Nasal', $airwayDevices) ? 'checked' : '' }}>
                                            Nasal
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="LMA"
                                                {{ in_array('LMA', $airwayDevices) ? 'checked' : '' }}>
                                            LMA
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="OETT"
                                                {{ in_array('OETT', $airwayDevices) ? 'checked' : '' }}>
                                            OETT
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="NETT"
                                                {{ in_array('NETT', $airwayDevices) ? 'checked' : '' }}>
                                            NETT
                                        </label> &nbsp;

                                        <label>
                                            <input type="checkbox" name="airway_device[]" value="Tracheostomy"
                                                {{ in_array('Tracheostomy', $airwayDevices) ? 'checked' : '' }}>
                                            Tracheostomy
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <strong>Respiration:</strong>
                                        <label><input type="radio" name="respiration" value="Spontaneous"
                                                {{ isset($nurse_info->respiration) && $nurse_info->respiration == 'Spontaneous' ? 'checked' : '' }} />
                                            Spontaneous</label>
                                        <label><input type="radio" name="respiration" value="Assisted"
                                                {{ isset($nurse_info->respiration) && $nurse_info->respiration == 'Assisted' ? 'checked' : '' }} />
                                            Assisted</label>
                                        <label><input type="radio" name="respiration" value="Mechanical"
                                                {{ isset($nurse_info->respiration) && $nurse_info->respiration == 'Mechanical' ? 'checked' : '' }} />
                                            Mechanical</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <p><strong>Monitor in Recovery Room Chart (Opposite Leaf):</strong>
                                            Pulse (●), SBP (˅ ), DBP ( ˄) , SpO2, Respiratory rate, Pain score (1-10),
                                            Nausea/Vomiting score (Nil-0, Nausea-1, Vomiting -2), Urine in ml, Drain in
                                            ml (if any),
                                            Level of consciousness (Awake-3, Respond to verbal stimuli-2, Respond to
                                            painful stimuli -1, Not responding-0).</p>
                                    </td>

                                </tr>
                            </table> <br>

                            <h3>Medications at Recovery Room</h3>
                            <table width="100%" border="1" style="margin-bottom: 10px" id="medicationsTable">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Drug/Dose/Route</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="medBody">
                                    @if (!empty($med_time))
                                        @foreach ($med_time as $i => $time)
                                            <tr>
                                                <td><input type="time" name="med_time[]"
                                                        value="{{ $time }}" class="form-control" /></td>
                                                <td><input type="text" name="med_drug[]"
                                                        value="{{ $med_drug[$i] ?? '' }}" class="form-control" />
                                                </td>
                                                <td><input type="text" name="med_sign[]"
                                                        value="{{ $med_sign[$i] ?? '' }}" class="form-control" />
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeRow">Remove</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        {{-- Show one empty row if no previous data --}}
                                        <tr>
                                            <td><input type="time" name="med_time[]" class="form-control" /></td>
                                            <td><input type="text" name="med_drug[]" class="form-control" /></td>
                                            <td><input type="text" name="med_sign[]" class="form-control" /></td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm removeRow">Remove</button>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <button type="button" class="btn btn-primary" id="addMedicationRow">+Add
                                                More</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <p><strong>Recovery Events Note (If any):</strong></p>
                            <textarea name="recovery_events" rows="3" style="width: 100%;">{{ isset($nurse_info->recovery_events) ? $nurse_info->recovery_events : '' }}</textarea>


                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="4" class="section-title">
                                            <h4>Aldrete and Kronlik Modified
                                                Post-Anesthetic Recovery Score</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Consciousness</th>
                                        <th>Arrival</th>
                                        <th>Consciousness</th>
                                        <th>On Discharge</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="text-start">


                                            <select name="conscious_rouse_arrival"
                                                class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'consciousness', 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->conscious_rouse_arrival) ? 'selected' : '' }}>
                                                    -- Select --</option>

                                                <option value="0"
                                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 0 ? 'selected' : '' }}>
                                                    Not responding</option>

                                                <option value="2"
                                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 2 ? 'selected' : '' }}>
                                                    Fully awake</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->conscious_rouse_arrival) && $nurse_info->conscious_rouse_arrival == 1 ? 'selected' : '' }}>
                                                    Rousable on calling</option>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="conscious_fully_arrival" readonly
                                                id="consciousness_arrival" class="form-control text-center"
                                                value="{{ isset($nurse_info->conscious_fully_arrival) ? $nurse_info->conscious_fully_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select name="consciousness_discharge"
                                                class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'consciousness', 'discharge')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->conscious_rouse_thirty) ? 'selected' : '' }}>
                                                    -- Select --</option>

                                                <option value="0"
                                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 0 ? 'selected' : '' }}>
                                                    Not responding</option>

                                                <option value="2"
                                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 2 ? 'selected' : '' }}>
                                                    Fully awake</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->conscious_rouse_thirty) && $nurse_info->conscious_rouse_thirty == 1 ? 'selected' : '' }}>
                                                    Rousable on calling</option>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="conscious_fully_thirty" readonly
                                                id="consciousness_discharge" class="form-control text-center"
                                                value="{{ isset($nurse_info->conscious_fully_thirty) ? $nurse_info->conscious_fully_thirty : '0' }}">
                                        </td>

                                    </tr>

                                    {{-- Activity --}}
                                    <tr>
                                        <td colspan="3" class="section-title text-left">Activity (Able to move
                                            voluntarily or
                                            on command)</td>
                                    </tr>

                                    <tr>
                                        <td class="text-start">

                                            <select name="activity_two_arrival" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'activity', 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->activity_two_arrival) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 0 ? 'selected' : '' }}>
                                                    0 extremities</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 1 ? 'selected' : '' }}>
                                                    2 extremities</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->activity_two_arrival) && $nurse_info->activity_two_arrival == 2 ? 'selected' : '' }}>
                                                    4 extremities (Able to Lift head or good hand grip)</option>


                                            </select>
                                        </td>
                                        <td><input type="text" name="activity_four_arrival" readonly
                                                id="activity_arrival" class="form-control text-center"
                                                value="{{ isset($nurse_info->activity_four_arrival) ? $nurse_info->activity_four_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">
                                            <select name="activity_discharge" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'activity', 'discharge')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->activity_two_thirty) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 0 ? 'selected' : '' }}>
                                                    0 extremities</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 1 ? 'selected' : '' }}>
                                                    2 extremities</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->activity_two_thirty) && $nurse_info->activity_two_thirty == 2 ? 'selected' : '' }}>
                                                    4 extremities (Able to Lift head or good hand grip)</option>


                                            </select>
                                        </td>
                                        <td><input type="text" name="activity_four_thirty" readonly
                                                id="activity_discharge" class="form-control text-center"
                                                value="{{ isset($nurse_info->activity_four_thirty) ? $nurse_info->activity_four_thirty : '0' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="section-title text-left">Respiration</td>
                                    </tr>

                                    <tr>
                                        <td class="text-start">

                                            <select name="resp_dyspnea_arrival" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'respiration', 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->resp_dyspnea_arrival) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 0 ? 'selected' : '' }}>
                                                    Apneic</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 2 ? 'selected' : '' }}>
                                                    Able to breathe deeply and cough easily</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->resp_dyspnea_arrival) && $nurse_info->resp_dyspnea_arrival == 1 ? 'selected' : '' }}>
                                                    Dyspneic or with limited breathing</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="resp_deep_arrival" readonly
                                                id="respiration_arrival" class="form-control text-center"
                                                value="{{ isset($nurse_info->resp_deep_arrival) ? $nurse_info->resp_deep_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select name="respiration_discharge"
                                                onchange="updateScore(this, 'respiration', 'discharge')"
                                                class="form-select large-select mt-1">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->resp_dyspnea_thirty) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 0 ? 'selected' : '' }}>
                                                    Apneic</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 2 ? 'selected' : '' }}>
                                                    Able to breathe deeply and cough easily</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->resp_dyspnea_thirty) && $nurse_info->resp_dyspnea_thirty == 1 ? 'selected' : '' }}>
                                                    Dyspneic or with limited breathing</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="resp_deep_thirty" readonly
                                                id="respiration_discharge" class="form-control text-center"
                                                value="{{ isset($nurse_info->resp_deep_thirty) ? $nurse_info->resp_deep_thirty : '0' }}">
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="3" class="section-title text-left">SpO₂</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">

                                            <select name="spo2_oxygen_arrival" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'spo2', 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->spo2_oxygen_arrival) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 0 ? 'selected' : '' }}>
                                                    ≤92% despite O2 supplement</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 1 ? 'selected' : '' }}>
                                                    Need O2 to maintain ≥92%</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->spo2_oxygen_arrival) && $nurse_info->spo2_oxygen_arrival == 2 ? 'selected' : '' }}>
                                                    ≥92% on room air</option>

                                            </select>
                                        </td>
                                        <td><input type="text" name="spo2_room_arrival" readonly id="spo2_arrival"
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->spo2_room_arrival) ? $nurse_info->spo2_room_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select name="spo2_discharge" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'spo2', 'discharge')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->spo2_oxygen_thirty) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 0 ? 'selected' : '' }}>
                                                    ≤92% despite O2 supplement</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 1 ? 'selected' : '' }}>
                                                    Need O2 to maintain ≥92%</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->spo2_oxygen_thirty) && $nurse_info->spo2_oxygen_thirty == 2 ? 'selected' : '' }}>
                                                    ≥92% on room air</option>

                                            </select>
                                        </td>
                                        <td><input type="text" name="spo2_room_thirty" readonly
                                                id="spo2_discharge" class="form-control text-center"
                                                value="{{ isset($nurse_info->spo2_room_thirty) ? $nurse_info->spo2_room_thirty : '0' }}">
                                        </td>
                                    </tr>

                                    {{-- Blood Pressure --}}
                                    <tr>
                                        <td colspan="3" class="section-title text-left"> Blood Pressure</td>
                                    </tr>
                                    <tr>

                                        <td class="text-start">

                                            <select name="bp_fifty_arrival" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'bp', 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->bp_fifty_arrival) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 0 ? 'selected' : '' }}>
                                                    Systolic BP if ± 50% preanesthetic level</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 1 ? 'selected' : '' }}>
                                                    Systolic BP if ± 20% to 50% preanesthetic level</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->bp_fifty_arrival) && $nurse_info->bp_fifty_arrival == 2 ? 'selected' : '' }}>
                                                    Systolic BP if ± 20% preanesthetic level</option>

                                            </select>
                                        </td>
                                        <td><input type="text" name="bp_twenty_arrival" readonly id="bp_arrival"
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->bp_twenty_arrival) ? $nurse_info->bp_twenty_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select name="bp_discharge" class="form-select large-select mt-1"
                                                onchange="updateScore(this, 'bp', 'discharge')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->bp_fifty_thirty) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="0"
                                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 0 ? 'selected' : '' }}>
                                                    Systolic BP if ± 50% preanesthetic level</option>

                                                <option value="1"
                                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 1 ? 'selected' : '' }}>
                                                    Systolic BP if ± 20% to 50% preanesthetic level</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->bp_fifty_thirty) && $nurse_info->bp_fifty_thirty == 2 ? 'selected' : '' }}>
                                                    Systolic BP if ± 20% preanesthetic level</option>

                                            </select>
                                        </td>
                                        <td><input type="text" name="bp_twenty_thirty" readonly id="bp_discharge"
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->bp_twenty_thirty) ? $nurse_info->bp_twenty_thirty : '0' }}">
                                        </td>
                                    </tr>
                                    <tr >
                                        <td colspan="4" class="section-title text-left">Total Score at Discharge
                                            with Time</td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <strong>Time:</strong>
                                            @php
                                                $aldrete_arr_time = explode(' ', @$nurse_info->bp_high_arrival);
                                            @endphp
                                            <input type="time"name="aldrete_arr_time" style="width: 30%"
                                                value="{{ $aldrete_arr_time[1] ?? '' }}">
                                        </td>



                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" name="aldrete_arr_total" readonly
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->total_arrival) ? $nurse_info->total_arrival : '0' }}">
                                        </td>




                                        <td>
                                            <strong>Time:</strong>
                                            @php
                                                $aldrete_time = explode(' ', @$nurse_info->bp_high_thirty);
                                            @endphp
                                            <input type="time"name="aldrete_time" style="width: 30%"
                                                value="{{ $aldrete_time[1] ?? '' }}">
                                        </td>
                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" name="aldrete_dis_total" readonly
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->total_thirtymin) ? $nurse_info->total_thirtymin : '0' }}">
                                        </td>


                                    </tr>
                                    <tr>
                                        <th colspan="4" class="section-title mt-4">
                                            <h4>Ramsay Sedation Scale</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-start">

                                            <select id="ramsay_arrival_select" name="rss_awake_cooperative_arrival"
                                                class="form-select large-select mt-1"
                                                onchange="calculateRamsay('arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->rss_awake_cooperative_arrival) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 1 ? 'selected' : '' }}>
                                                    Awake; agitated or restless or both </option>
                                                <option value="2"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 2 ? 'selected' : '' }}>
                                                    Awake; cooperative, oriented, and tranquil</option>
                                                <option value="3"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 3 ? 'selected' : '' }}>
                                                    Awake but responds to commands only</option>
                                                <option value="4"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 4 ? 'selected' : '' }}>
                                                    Asleep; brisk response to light glabellar tap or loud auditory
                                                    stimulus</option>
                                                <option value="5"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 5 ? 'selected' : '' }}>
                                                    Asleep; sluggish response to light glabellar tap or loud auditory
                                                    stimulus</option>
                                                <option value="6"
                                                    {{ isset($nurse_info->rss_awake_cooperative_arrival) && $nurse_info->rss_awake_cooperative_arrival == 6 ? 'selected' : '' }}>
                                                    Asleep; no response to glabellar tap or loud auditory stimulus
                                                </option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="rss_awake_agitated_arrival" readonly
                                                id="ramsay_arrival_score" class="form-control text-center"
                                                value="{{ isset($nurse_info->rss_awake_agitated_arrival) ? $nurse_info->rss_awake_agitated_arrival : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select id="ramsay_thirty_select" name="rss_awake_cooperative_thirty"
                                                class="form-select large-select mt-1"
                                                onchange="calculateRamsay('thirty')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->rss_awake_cooperative_thirty) ? 'selected' : '' }}>
                                                    -- Select --</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 1 ? 'selected' : '' }}>
                                                    Awake; agitated or restless or both </option>
                                                <option value="2"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 2 ? 'selected' : '' }}>
                                                    Awake; cooperative, oriented, and tranquil</option>
                                                <option value="3"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 3 ? 'selected' : '' }}>
                                                    Awake but responds to commands only</option>
                                                <option value="4"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 4 ? 'selected' : '' }}>
                                                    Asleep; brisk response to light glabellar tap or loud auditory
                                                    stimulus</option>
                                                <option value="5"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 5 ? 'selected' : '' }}>
                                                    Asleep; sluggish response to light glabellar tap or loud auditory
                                                    stimulus</option>
                                                <option value="6"
                                                    {{ isset($nurse_info->rss_awake_cooperative_thirty) && $nurse_info->rss_awake_cooperative_thirty == 6 ? 'selected' : '' }}>
                                                    Asleep; no response to glabellar tap or loud auditory stimulus
                                                </option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="rss_awake_agitated_thirty" readonly
                                                id="ramsay_thirty_score" class="form-control text-center"
                                                value="{{ isset($nurse_info->rss_awake_agitated_thirty) ? $nurse_info->rss_awake_agitated_thirty : '0' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="section-title text-left">Score at Discharge With Time</td>
                                    </tr>
                                    <tr>

                                       <td>
                                            <strong>Time:</strong>
                                            @php
                                                $ramsay_arr_time = explode(' ', @$nurse_info->rss_commands_30);
                                            @endphp
                                            <input type="time"name="ramsay_arr_time" style="width: 30%"
                                                value="{{ $ramsay_arr_time[1] ?? '' }}">
                                        </td>


                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" id="ramsay_arrival_total"
                                                name="ramsay_arrival_total" readonly class="form-control text-center"
                                                value="{{ isset($nurse_info->ramsay_arrival_total) ? $nurse_info->ramsay_arrival_total : '0' }}">

                                        </td>




                                        <td>
                                            <strong>Time:</strong>
                                            @php
                                                $ramsay_time = explode(' ', @$nurse_info->rss_commands_arr);
                                            @endphp
                                            <input type="time"name="ramsay_time" style="width: 30%"
                                                value="{{ $ramsay_time[1] ?? '' }}">
                                        </td>
                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" id="ramsay_thirty_total"
                                                name="ramsay_thirtymin_total" readonly
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->ramsay_thirtymin_total) ? $nurse_info->ramsay_thirtymin_total : '0' }}">

                                        </td>


                                    </tr>
                                    <tr>
                                        <th colspan="4" class="section-title">
                                            <h4>Modified Bromage Score</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-start">

                                            <select name="bromage_almost_arr" class="form-select large-select mt-1"
                                                onchange="updateBromageScore(this, 'arrival')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->bromage_almost_arr) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 1 ? 'selected' : '' }}>
                                                    Complete Motor block; Unable to move feet or knees</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 2 ? 'selected' : '' }}>
                                                    Almost Complete Block; Only able to move feet; unable to flex knees
                                                </option>
                                                <option value="3"
                                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 3 ? 'selected' : '' }}>
                                                    Partial Block Remains; Just able to flex knees with free movement of
                                                    feet</option>
                                                <option value="4"
                                                    {{ isset($nurse_info->bromage_almost_arr) && $nurse_info->bromage_almost_arr == 4 ? 'selected' : '' }}>
                                                    No Residual Motor block; full flexion of knee and feet</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="bromage_complete_arr" id="bromage_arrival"
                                                readonly class="form-control text-center"
                                                value="{{ isset($nurse_info->bromage_complete_arr) ? $nurse_info->bromage_complete_arr : '0' }}">
                                        </td>
                                        <td class="text-start">

                                            <select name="bromage_discharge" class="form-select large-select mt-1"
                                                onchange="updateBromageScore(this, 'discharge')">
                                                <option value="" disabled
                                                    {{ !isset($nurse_info->bromage_discharge) ? 'selected' : '' }}>--
                                                    Select --</option>
                                                <option value="1"
                                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 1 ? 'selected' : '' }}>
                                                    Complete Motor block; Unable to move feet or knees</option>
                                                <option value="2"
                                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 2 ? 'selected' : '' }}>
                                                    Almost Complete Block; Only able to move feet; unable to flex knees
                                                </option>
                                                <option value="3"
                                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 3 ? 'selected' : '' }}>
                                                    Partial Block Remains; Just able to flex knees with free movement of
                                                    feet</option>
                                                <option value="4"
                                                    {{ isset($nurse_info->bromage_discharge) && $nurse_info->bromage_discharge == 4 ? 'selected' : '' }}>
                                                    No Residual Motor block; full flexion of knee and feet</option>
                                            </select>
                                        </td>

                                        <td><input type="text" name="bromage_complete_30" readonly
                                                id="bromage_discharge" class="form-control text-center"
                                                value="{{ isset($nurse_info->bromage_complete_30) ? $nurse_info->bromage_complete_30 : '0' }}">
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" class="section-title text-left">Score at Discharge With Time</td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <strong>Time:</strong>
                                            @php
                                                $bromage_arr_time = explode(' ', @$nurse_info->bromage_partial_30);
                                            @endphp
                                            <input type="time"name="bromage_arr_time" style="width: 30%"
                                                value="{{ $bromage_arr_time[1] ?? '' }}">
                                        </td>



                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" name="bromage_arrival_total" readonly
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->bromage_arrival_total) ? $nurse_info->bromage_arrival_total : '0' }}">

                                        </td>



                                        <td>
                                            <strong>Time:</strong>
                                            @php
                                                $bromage_time = explode(' ', @$nurse_info->bromage_partial_arr);
                                            @endphp
                                            <input type="time"name="bromage_time" style="width: 30%"
                                                value="{{ $bromage_time[1] ?? '' }}">
                                        </td>
                                        <td>
                                            <strong>Total:</strong>
                                            <input type="text" name="bromage_thirtymin_total" readonly
                                                class="form-control text-center"
                                                value="{{ isset($nurse_info->bromage_thirtymin_total) ? $nurse_info->bromage_thirtymin_total : '0' }}">

                                        </td>


                                    </tr>
                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    @php
                        $redirect_url = route('ipd.recovery-room-nurses-note-form',[$pat_data->patient_no_pk,$ref_no]);
                    @endphp
                    <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                </div>
        </div>
        </form>
    </div>
    </div>
</section>

<script>
    const aldreteFields = ['consciousness', 'activity', 'respiration', 'spo2', 'bp'];

    function updateScore(selectBox, key, type) {

        const score = parseInt(selectBox.value) || 0;
        const inputId = key + '_' + type;
        const inputField = document.getElementById(inputId);


        if (inputField) {
            inputField.value = score;
        }

        calculateTotalScores();
    }

    function calculateTotalScores() {
        let totalArrival = 0;
        let totalDischarge = 0;

        aldreteFields.forEach(field => {
            const arrival = parseInt(document.getElementById(field + '_arrival')?.value || 0);
            const discharge = parseInt(document.getElementById(field + '_discharge')?.value || 0);
            totalArrival += arrival;
            totalDischarge += discharge;
        });

        document.querySelector('input[name="aldrete_arr_total"]').value = totalArrival;
        document.querySelector('input[name="aldrete_dis_total"]').value = totalDischarge;
    }


    document.addEventListener('DOMContentLoaded', () => {
        calculateTotalScores();
    });


    document.addEventListener('DOMContentLoaded', updateTotalScores);

    function calculateRamsay(timeType) {

        const select = document.getElementById(`ramsay_${timeType}_select`);
        const scoreInput = document.getElementById(`ramsay_${timeType}_score`);
        const totalInput = document.getElementById(`ramsay_${timeType}_total`);


        const selectedValue = parseInt(select.value);

        if (!isNaN(selectedValue)) {
            scoreInput.value = selectedValue;
            totalInput.value = selectedValue;
        } else {

            scoreInput.value = 0;
            totalInput.value = 0;
        }
    }
    // Update Bromage Score when dropdown changes
    function updateBromageScore(selectEl, type) {
        // Get the score from selected value
        const score = parseInt(selectEl.value) || 0;

        // Update the correct input field
        if (type === 'arrival') {
            document.getElementById('bromage_arrival').value = score;
            document.querySelector('input[name="bromage_arrival_total"]').value = score;
        } else if (type === 'discharge') {
            document.getElementById('bromage_discharge').value = score;
            document.querySelector('input[name="bromage_thirtymin_total"]').value = score;
        }
    }

    // Optional: preload saved values on page load
    document.addEventListener('DOMContentLoaded', () => {
        const arrivalSelect = document.querySelector('select[name="bromage_almost_arr"]');
        const dischargeSelect = document.querySelector('select[name="bromage_discharge"]');

        if (arrivalSelect?.value) updateBromageScore(arrivalSelect, 'arrival');
        if (dischargeSelect?.value) updateBromageScore(dischargeSelect, 'discharge');
    });
    $(document).ready(function() {
        $('#addMedicationRow').click(function() {
            let row = `<tr>
                <td><input type="time" name="med_time[]" class="form-control" /></td>
                <td><input type="text" name="med_drug[]" class="form-control" /></td>
                <td><input type="text" name="med_sign[]" class="form-control" /></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
            </tr>`;
            $('#medBody').append(row);
        });

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
