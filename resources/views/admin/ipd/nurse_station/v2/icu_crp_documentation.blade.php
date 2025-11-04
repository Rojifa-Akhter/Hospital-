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
                            <h5 class="mt-2 mb-0">CPR Documentation</h5>
                            <small>IPD / Nurse Station / CPR Documentation</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('icu.cpr-doc-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('icu.crp-doc-store') }}" method="post"
                                        id="docShiftHandoverForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="icu_cpr_doc_no_pk"
                                            value="{{ isset($cpr_doc->icu_cpr_doc_no_pk) ? $cpr_doc->icu_cpr_doc_no_pk : '' }}">


                                        <div class="table-responsive">

                                            <table width="100%" border="1" style="margin-top:10px">

                                                <tr>
                                                    <td><strong>Date:</strong><input type="date" name="cpr_date"
                                                            value="{{ isset($cpr_doc->cpr_date) ? date('Y-m-d', strtotime($cpr_doc->cpr_date)) : '' }}"
                                                            placeholder="dd-mm-YYYY" autocomplete="off"></td>
                                                    <td rowspan="7"><strong>History of Event:</strong><br>
                                                        <textarea name="history_event" cols="130" rows="15">{{ isset($cpr_doc->history_event) ? $cpr_doc->history_event : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Time & Location of Arrest: </strong>
                                                        @php
                                                            $cprr_time = explode(' ', @$cpr_doc->cprr_time);
                                                        @endphp
                                                        <input type="time" name="cprr_time"
                                                            value="{{ $cprr_time[1] ?? '' }}" placeholder="time">
                                                        <input type="text" name="cpr_loc"
                                                            value="{{ isset($cpr_doc->cpr_loc) ? $cpr_doc->cpr_loc : '' }}"
                                                            placeholder="location">

                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Code blue activated:</strong>
                                                        <select name="code_blue">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->code_blue == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->code_blue == 'No' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Witnessed</strong>
                                                        <select name="witnessed">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->witnessed == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->witnessed == 'No' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Consciousness at onset</strong>
                                                        <select name="consciousness">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->consciousness == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->consciousness == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Indicate all monitors that were present</strong>
                                                        <select name="monitors">
                                                            <option value="ECG"
                                                                {{ @$cpr_doc->monitors == 'ECG' ? 'selected' : '' }}>
                                                                ECG</option>
                                                            <option value="Pulse oximeter"
                                                                {{ @$cpr_doc->monitors == 'Pulse oximeter' ? 'selected' : '' }}>
                                                                Pulse oximeter</option>
                                                            <option value="BP"
                                                                {{ @$cpr_doc->monitors == 'BP' ? 'selected' : '' }}>BP
                                                            </option>
                                                            <option value="None"
                                                                {{ @$cpr_doc->monitors == 'None' ? 'selected' : '' }}>
                                                                None</option>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>CPR Started:</strong>
                                                        <select name="cpr">
                                                            <option value="Bystander"
                                                                {{ @$cpr_doc->cpr == 'Bystander' ? 'selected' : '' }}>
                                                                Bystander</option>
                                                            <option value="Hospital Staff"
                                                                {{ @$cpr_doc->cpr == 'Hospital Staff' ? 'selected' : '' }}>
                                                                Hospital Staff</option>
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table border="1" cellspacing="0" cellpadding="4"
                                                            style="width:100%; border-collapse:collapse;">
                                                            <tr>
                                                                <th>Initial VS</th>
                                                                <th>BP(mmhg)</th>
                                                                <th>Temp(°F)</th>
                                                                <th>Pulse(/main)</th>
                                                                <th>SpO₂(%)</th>
                                                                <th>GCS</th>
                                                                <th>Others</th>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="text" name="bp"
                                                                        value="{{ isset($cpr_doc->bp) ? $cpr_doc->bp : '' }}">
                                                                </td>
                                                                <td><input type="text" name="temp"
                                                                        value="{{ isset($cpr_doc->temp) ? $cpr_doc->temp : '' }}">
                                                                </td>
                                                                <td><input type="text" name="pulse"
                                                                        value="{{ isset($cpr_doc->pulse) ? $cpr_doc->pulse : '' }}">
                                                                </td>
                                                                <td><input type="text" name="spo2"
                                                                        value="{{ isset($cpr_doc->spo2) ? $cpr_doc->spo2 : '' }}">
                                                                </td>
                                                                <td><input type="text" name="gcs"
                                                                        value="{{ isset($cpr_doc->gcs) ? $cpr_doc->gcs : '' }}">
                                                                </td>
                                                                <td><input type="text" name="initial_others"
                                                                        value="{{ isset($cpr_doc->initial_others) ? $cpr_doc->initial_others : '' }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Airway/Breathing</th>
                                                    <th>Circulation</th>
                                                </tr>
                                                <tr>

                                                    <td><strong>Artificial Ventilation:</strong>
                                                        <select name="art_ventilation">
                                                            <option value="Bag"
                                                                {{ @$cpr_doc->art_ventilation == 'Bag' ? 'selected' : '' }}>
                                                                Bag</option>
                                                            <option value="Mask"
                                                                {{ @$cpr_doc->art_ventilation == 'Mask' ? 'selected' : '' }}>
                                                                Mask</option>
                                                            <option value="Endo Tube"
                                                                {{ @$cpr_doc->art_ventilation == 'Endo Tube' ? 'selected' : '' }}>
                                                                Endo Tube</option>
                                                            <option value="SGA(LMA)"
                                                                {{ @$cpr_doc->art_ventilation == 'SGA(LMA)' ? 'selected' : '' }}>
                                                                SGA(LMA)</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <strong>First Documented Rhythm:</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Intubated:</strong> &nbsp;
                                                    </td>
                                                    <td rowspan="3">
                                                        <textarea name="doc_rhythm" cols="130" rows="4">{{ isset($cpr_doc->doc_rhythm) ? $cpr_doc->doc_rhythm : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        @php
                                                            $intubated_time = explode(' ', @$cpr_doc->intubated_time);
                                                        @endphp
                                                        Time:
                                                        <input type="time" name="intubated_time"
                                                            value="{{ $intubated_time[1] ?? '' }}">

                                                        Size & Site:
                                                        <input type="text" style="width: 30%;"
                                                            name="intubated_size"
                                                            value="{{ isset($cpr_doc->intubated_size) ? $cpr_doc->intubated_size : '' }}">

                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>
                                                        By:
                                                        <input type="text" style="width: 30%;" name="intubated_by"
                                                            value="{{ isset($cpr_doc->intubated_by) ? $cpr_doc->intubated_by : '' }}">

                                                        No. of Attempts:
                                                        <input type="text" style="width: 20%;"
                                                            name="intubated_attemp"
                                                            value="{{ isset($cpr_doc->intubated_attemp) ? $cpr_doc->intubated_attemp : '' }}">

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><strong>Placement Confirmed By:</strong><input type="text"
                                                            name="placement_by"
                                                            value="{{ isset($cpr_doc->placement_by) ? $cpr_doc->placement_by : '' }}">
                                                    </td>
                                                    <td><strong>Pt. Defibrillated</strong>
                                                        <select name="pt_defibrillated">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->pt_defibrillated == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->pt_defibrillated == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tube Secured At (cm):</strong><input type="text"
                                                            name="tube_secured"
                                                            value="{{ isset($cpr_doc->tube_secured) ? $cpr_doc->tube_secured : '' }}">
                                                    </td>
                                                    <td>

                                                        @php
                                                            $shock_time_list = !empty($cpr_doc->time_shock)
                                                                ? json_decode($cpr_doc->time_shock, true)
                                                                : [];

                                                            function ordinal($number)
                                                            {
                                                                $ends = [
                                                                    'th',
                                                                    'st',
                                                                    'nd',
                                                                    'rd',
                                                                    'th',
                                                                    'th',
                                                                    'th',
                                                                    'th',
                                                                    'th',
                                                                    'th',
                                                                ];
                                                                if ($number % 100 >= 11 && $number % 100 <= 13) {
                                                                    return $number . 'th';
                                                                } else {
                                                                    return $number . $ends[$number % 10];
                                                                }
                                                            }
                                                        @endphp
                                                        <table border="1" cellspacing="0" cellpadding="4"
                                                            style="border-collapse:collapse; width:100%; text-align:center;">
                                                            <tr>
                                                                <th>If Yes,Time of Shocks</th>
                                                                <th>Time</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            <tbody id="shockTableBody">
                                                                @if (!empty($shock_time_list))
                                                                    @foreach ($shock_time_list as $i => $time)
                                                                        <tr>
                                                                            <td style="text-align: center">
                                                                                {{ ordinal($i + 1) }} Shock
                                                                                <input type="hidden"
                                                                                    name="shock_num[]"
                                                                                    value="{{ ordinal($i + 1) }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="time"
                                                                                    class="form-control form-control-sm"
                                                                                    name="time_shock[]"
                                                                                    value="{{ $time }}">
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="btn btn-success btn-md shockadd"><i
                                                                                        class="fa fa-plus"></i></span>
                                                                                <span
                                                                                    class="btn btn-danger btn-md shockdelete"><i
                                                                                        class="fa fa-trash"></i></span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td style="text-align: center">
                                                                            1st Shock
                                                                            <input type="hidden" name="shock_num[]"
                                                                                value="1st">
                                                                        </td>
                                                                        <td><input type="time"
                                                                                class="form-control form-control-sm"
                                                                                name="time_shock[]"></td>
                                                                        <td class="text-center">
                                                                            <span
                                                                                class="btn btn-success btn-md shockadd"><i
                                                                                    class="fa fa-plus"></i></span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table> <br>

                                                        <label><b>No. Of Attemps:</b></label> <input type="text" name="shock_attemp"
                                                            style="width: 20%;"
                                                            value="{{ isset($cpr_doc->shock_attemp) ? $cpr_doc->shock_attemp : '' }}">

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><strong>NG/OG Tube:</strong></td>
                                                    <td><strong>IO/IV/CV:</strong></td>


                                                </tr>
                                                <tr>

                                                    <td>
                                                        @php
                                                            $ng_time = explode(' ', @$cpr_doc->ng_time);
                                                        @endphp
                                                        Time: <input type="time" name="ng_time"
                                                            value="{{ $ng_time[1] ?? '' }}">
                                                        Size: <input type="text" name="ng_size"
                                                            style="width: 20%;"
                                                            value="{{ isset($cpr_doc->ng_size) ? $cpr_doc->ng_size : '' }}">
                                                        By: <input type="text" name="ng_by" style="width: 20%;"
                                                            value="{{ isset($cpr_doc->ng_by) ? $cpr_doc->ng_by : '' }}">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $io_time = explode(' ', @$cpr_doc->io_time);
                                                        @endphp
                                                        Time: <input type="time" name="io_time"
                                                            value="{{ $io_time[1] ?? '' }}">
                                                        Size & Site: <input type="text" name="io_size"
                                                            style="width: 20%;"
                                                            value="{{ isset($cpr_doc->io_size) ? $cpr_doc->io_size : '' }}">
                                                        By: <input type="text" style="width: 20%;" name="io_by"
                                                            value="{{ isset($cpr_doc->io_by) ? $cpr_doc->io_by : '' }}">
                                                        No. of Attempts: <input type="text" style="width: 10%;"
                                                            name="io_attemp"
                                                            value="{{ isset($cpr_doc->io_attemp) ? $cpr_doc->io_attemp : '' }}">

                                                    </td>
                                                </tr>

                                            </table> <br>
                                            @php
                                                $cpr_time = json_decode($cpr_doc->cpr_time ?? '[]');
                                                $cpr_hr = json_decode($cpr_doc->cpr_hr ?? '[]');
                                                $cpr_rhythm = json_decode($cpr_doc->cpr_rhythm ?? '[]');
                                                $cpr_bp = json_decode($cpr_doc->cpr_bp ?? '[]');
                                                $cpr_rr = json_decode($cpr_doc->cpr_rr ?? '[]');
                                                $cpr_spo2 = json_decode($cpr_doc->cpr_spo2 ?? '[]');
                                                $defib = json_decode($cpr_doc->defib ?? '[]');
                                                $t1 = json_decode($cpr_doc->t1 ?? '[]');
                                                $epi = json_decode($cpr_doc->epi ?? '[]');
                                                $atropine = json_decode($cpr_doc->atropine ?? '[]');
                                                $lidocaine_med = json_decode($cpr_doc->lidocaine_med ?? '[]');
                                                $sodium_bicarb = json_decode($cpr_doc->sodium_bicarb ?? '[]');
                                                $calcium = json_decode($cpr_doc->calcium ?? '[]');
                                                $amiodarone = json_decode($cpr_doc->amiodarone ?? '[]');
                                                $rhythm_response = json_decode($cpr_doc->rhythm_response ?? '[]');
                                                $dopamine = json_decode($cpr_doc->dopamine ?? '[]');
                                                $lidocaine_iv = json_decode($cpr_doc->lidocaine_iv ?? '[]');
                                                $fluid_bolus = json_decode($cpr_doc->fluid_bolus ?? '[]');
                                                $abg_drawn = json_decode($cpr_doc->abg_drawn ?? '[]');
                                                $comments = json_decode($cpr_doc->comments ?? '[]');

                                                $hasData =
                                                    !empty($cpr_time) && is_array($cpr_time) && count($cpr_time) > 0;
                                            @endphp

                                            <table id="mainTable" border="1" cellspacing="0" cellpadding="4"
                                                style="border-collapse:collapse; width:100%; text-align:center; font-size:12px;">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="width:60px;">Time</th>
                                                        <th rowspan="2" style="width:50px;">HR</th>
                                                        <th rowspan="2" style="width:60px;">Rhythm</th>
                                                        <th rowspan="2" style="width:50px;">BP</th>
                                                        <th rowspan="2" style="width:50px;">RR</th>
                                                        <th rowspan="2" style="width:50px;">SpO₂</th>
                                                        <th rowspan="2" style="width:70px;">Defib Joules</th>
                                                        <th colspan="4"><strong>Medications (* if given by ET
                                                                Tube)</strong></th>
                                                        <th rowspan="2" style="width:70px;">Rhythm Response</th>
                                                        <th colspan="6"><strong>IV Meds/Fluids</strong></th>
                                                        <th rowspan="2" style="width:70px;">ABG Drawn (√)</th>
                                                        <th rowspan="2" style="width:120px;">
                                                            <strong>Comments</strong><br>
                                                            (pO2, pCO2, pH, Color, Mental Status, Temp., Pupils,
                                                            Procedures, etc.)
                                                        </th>
                                                        <th rowspan="2" style="width:60px;">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:70px;">1:1, 000EPI</th>
                                                        <th style="width:70px;">EPI1:10, 000</th>
                                                        <th style="width:70px;">Atropine</th>
                                                        <th style="width:70px;">Lidocaine</th>
                                                        <th style="width:70px;">Sodium Bicarbonate</th>
                                                        <th style="width:70px;">Calcium</th>
                                                        <th style="width:70px;">Amiodarone</th>
                                                        <th style="width:70px;">Dopamine</th>
                                                        <th style="width:70px;">Lidocaine</th>
                                                        <th style="width:80px;">IV Fluid Bolus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($hasData)
                                                        @for ($i = 0; $i < count($cpr_time); $i++)
                                                            <tr>
                                                                <td><input type="text" name="cpr_time[]"
                                                                        value="{{ $cpr_time[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="cpr_hr[]"
                                                                        value="{{ $cpr_hr[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="cpr_rhythm[]"
                                                                        value="{{ $cpr_rhythm[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="cpr_bp[]"
                                                                        value="{{ $cpr_bp[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="cpr_rr[]"
                                                                        value="{{ $cpr_rr[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="cpr_spo2[]"
                                                                        value="{{ $cpr_spo2[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="defib[]"
                                                                        value="{{ $defib[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="t1[]"
                                                                        value="{{ $t1[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="epi[]"
                                                                        value="{{ $epi[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="atropine[]"
                                                                        value="{{ $atropine[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="lidocaine_med[]"
                                                                        value="{{ $lidocaine_med[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="sodium_bicarb[]"
                                                                        value="{{ $sodium_bicarb[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="calcium[]"
                                                                        value="{{ $calcium[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="amiodarone[]"
                                                                        value="{{ $amiodarone[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="rhythm_response[]"
                                                                        value="{{ $rhythm_response[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="dopamine[]"
                                                                        value="{{ $dopamine[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="lidocaine_iv[]"
                                                                        value="{{ $lidocaine_iv[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="fluid_bolus[]"
                                                                        value="{{ $fluid_bolus[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td><input type="text" name="abg_drawn[]"
                                                                        value="{{ $abg_drawn[$i] ?? '' }}"
                                                                        style="width:100%;"></td>
                                                                <td>
                                                                    <textarea name="comments[]" rows="3" style="width:100%;">{{ $comments[$i] ?? '' }}</textarea>
                                                                </td>
                                                                <td><button type="button" class="btn-danger"
                                                                        onclick="removeRow(this)">Remove</button></td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="cpr_time[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="cpr_hr[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="cpr_rhythm[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="cpr_bp[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="cpr_rr[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="cpr_spo2[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="defib[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="t1[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="epi[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="atropine[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="lidocaine_med[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="sodium_bicarb[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="calcium[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="amiodarone[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="rhythm_response[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="dopamine[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="lidocaine_iv[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="fluid_bolus[]"
                                                                    style="width:100%;"></td>
                                                            <td><input type="text" name="abg_drawn[]"
                                                                    style="width:100%;"></td>
                                                            <td>
                                                                <textarea name="comments[]" rows="3" style="width:100%;"></textarea>
                                                            </td>
                                                            <td><button type="button" class="btn-danger"
                                                                    onclick="removeRow(this)">Remove</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>


                                            <div class="text-center mt-2">
                                                <button type="button" class="btn-add" onclick="addRow()">+Add
                                                    More</button>
                                            </div>



                                            <table border="1" cellspacing="0" cellpadding="4"
                                                style="width:100%; border-collapse:collapse;">
                                                <tr>
                                                    <td colspan="2"><strong>Does ROSC achived?</strong>
                                                        <select name="resuscitated">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->resuscitated == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->resuscitated == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><strong>Time code terminated:</strong><input type="text"
                                                            name="time_code"
                                                            value="{{ isset($cpr_doc->time_code) ? $cpr_doc->time_code : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Disposition of Patient:</strong></td>
                                                    @php
                                                        $disposition_time = explode(' ', @$cpr_doc->disposition_time);
                                                    @endphp
                                                    <td>
                                                        Time: <input type="time" name="disposition_time"
                                                            value="{{ $disposition_time[1] ?? '' }}">

                                                    </td>


                                                    <td>Location:
                                                        <select name="disposition_loc">
                                                            <option value="Out of Hospital"
                                                                {{ @$cpr_doc->disposition_loc == 'Out of Hospital' ? 'selected' : '' }}>
                                                                Out of Hospital</option>
                                                            <option value="Others"
                                                                {{ @$cpr_doc->disposition_loc == 'Others' ? 'selected' : '' }}>
                                                                Others</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        @php
                                                            $expired_at = explode(' ', @$cpr_doc->expired_at);
                                                        @endphp
                                                        Patient expired at: <input type="time" name="expired_at"
                                                            value="{{ $expired_at[1] ?? '' }}"></td>
                                                    <td>Pronounced by: <input type="text" name="pronounced_by"
                                                            value="{{ isset($cpr_doc->pronounced_by) ? $cpr_doc->pronounced_by : '' }}">
                                                    </td>
                                                    <td>Family notified:
                                                        <select name="family_notified">
                                                            <option value="Yes"
                                                                {{ @$cpr_doc->family_notified == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$cpr_doc->family_notified == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Names of all individuals present at
                                                            code:</strong><br>
                                                        <textarea name="present_code" rows="3" cols="165">{{ isset($cpr_doc->present_code) ? $cpr_doc->present_code : '' }}</textarea>
                                                    </td>
                                                    @php
                                                        $cpr_reason = json_decode($cpr_doc->reason ?? '[]', true) ?? [];
                                                    @endphp
                                                    <td colspan="3">
                                                        <strong>Reason for Resuscitation ended:</strong><br>
                                                        <label><input type="checkbox" name="reason[]"
                                                                value="ROSC > 30 min"
                                                                {{ in_array('ROSC > 30 min', $cpr_reason) ? 'checked' : '' }}>
                                                            ROSC > 30 min</label><br>
                                                        <label><input type="checkbox" name="reason[]"
                                                                value="Effort Terminate"
                                                                {{ in_array('Effort Terminate', $cpr_reason) ? 'checked' : '' }}>
                                                            Effort Terminate</label><br>
                                                        <label><input type="checkbox" name="reason[]"
                                                                value="Medical futility"
                                                                {{ in_array('Medical futility', $cpr_reason) ? 'checked' : '' }}>
                                                            Medical futility</label><br>
                                                        <label><input type="checkbox" name="reason[]"
                                                                value="Advanced directives"
                                                                {{ in_array('Advanced directives', $cpr_reason) ? 'checked' : '' }}>
                                                            Advanced
                                                            directives</label><br>
                                                        <label><input type="checkbox" name="reason[]"
                                                                value="Family Restriction"
                                                                {{ in_array('Family Restriction', $cpr_reason) ? 'checked' : '' }}>
                                                            Family Restriction</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Team Leader</strong></td>
                                                    <td><input type="text" name="team_leader"
                                                            value="{{ isset($cpr_doc->team_leader) ? $cpr_doc->team_leader : '' }}">
                                                    </td>
                                                    <td><strong>CPR Committee Notification</strong></td>
                                                    <td><input type="text" name="cpr_notifi"
                                                            value="{{ isset($cpr_doc->cpr_notifi) ? $cpr_doc->cpr_notifi : '' }}">
                                                    </td>
                                                </tr>

                                            </table>




                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('icu.crp-doc-form', [
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
    openDoctorAutocomplete('#out_doc', 'h_out_doc', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#in_doc', 'h_in_doc', 'doctor_ind', '1,2');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });


    function addRow() {
        let table = document.getElementById("mainTable").getElementsByTagName('tbody')[0];
        let newRow = table.rows[0].cloneNode(true);
        let inputs = newRow.querySelectorAll("input, textarea");
        inputs.forEach(input => input.value = "");
        table.appendChild(newRow);
    }

    function removeRow(btn) {
        let row = btn.closest("tr");
        let tbody = document.getElementById("mainTable").getElementsByTagName('tbody')[0];
        if (tbody.rows.length > 1) {
            row.remove();
        }
    }

    $(document).ready(function() {
        // Add row
        $(document).off('click', '.shockadd').on('click', '.shockadd', function() {
            let rowCount = $("#shockTableBody tr").length;
            let newShockNum = rowCount + 1;

            function ordinal(n) {
                let s = ["th", "st", "nd", "rd"],
                    v = n % 100;
                return n + (s[(v - 20) % 10] || s[v] || s[0]);
            }

            let newRow = `
            <tr>
                <td style="text-align: center">
                    ${ordinal(newShockNum)} Shock
                    <input type="hidden" name="shock_num[]" value="${ordinal(newShockNum)}">
                </td>
                <td>
                    <input type="time" class="form-control form-control-sm" name="time_shock[]">
                </td>
                <td class="text-center">
                    <span class="btn btn-danger btn-md shockdelete">
                        <i class="fa fa-trash"></i>
                    </span>
                </td>
            </tr>
        `;

            $("#shockTableBody").append(newRow);
        });

        // Remove row
        $(document).off('click', '.shockdelete').on('click', '.shockdelete', function() {
            $(this).closest('tr').remove();

            $("#shockTableBody tr").each(function(index) {
                let shockNum = index + 1;
                let text = ordinal(shockNum) + " Shock";

                $(this).find("td:first").html(`
                ${text}
                <input type="hidden" name="shock_num[]" value="${text}">
            `);
            });

            function ordinal(n) {
                let s = ["th", "st", "nd", "rd"],
                    v = n % 100;
                return n + (s[(v - 20) % 10] || s[v] || s[0]);
            }
        });
    });
</script>
