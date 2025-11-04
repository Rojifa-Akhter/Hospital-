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

    .rotate-text {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        text-align: center;
        vertical-align: middle;
        transform: rotate(180deg);

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
                            <h5 class="mt-2 mb-0">NICU FLOW SHEET</h5>
                            <small>IPD / Nurse Station / NICU Flow Sheet</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.nicu-flow-sheet-form-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-nicu-flow-sheet-form') }}" method="post"
                                        id="NICUFLOWSHEET">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="nicu_flow_sheet1_no_pk"
                                            value="{{ $nicufs1->nicu_flow_sheet1_no_pk ?? '' }}">
                                        <input type="hidden" name="nicu_flow_sheet2_no_pk"
                                            value="{{ $nicufs2->nicu_flow_sheet2_no_pk ?? '' }}">
                                        <input type="hidden" name="nicu_flow_sheet3_no_pk"
                                            value="{{ $nicufs3->nicu_flow_sheet3_no_pk ?? '' }}">

                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Day</th>
                                                        <th style="width: 15%">Consultant</th>
                                                        <th>Diagnosis</th>
                                                        <th>BL. GROUP</th>
                                                        <th>4 LIMB BP</th>
                                                        <th>BIRTH WT.</th>
                                                        <th>DAILY WT.</th>
                                                        <th>RT. LEG</th>
                                                        <th>LF. LEG </th>
                                                        <th>RT. ARM</th>
                                                        <th>LF. ARM</th>
                                                        <th>OFC</th>



                                                    </tr>

                                                    <tr>
                                                        <td><input type="date" name="datee"
                                                                value="{{ @$nicufs1->datee }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="day"
                                                                value="{{ @$nicufs1->day }}" class="form-control"></td>
                                                        <td><input type="text" name="consultant" id="consultant"
                                                                value="{{ @$nicufs1->consultant }}"
                                                                class="form-control">
                                                                <input type="hidden" name="hconsultant" id="hconsultant"
                                                                value=""
                                                                class="form-control">
                                                            </td>
                                                        <td> <input type="text" name="diagnosis"
                                                                value="{{ @$nicufs1->diagnosis }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bl_group"
                                                                value="{{ @$nicufs1->bl_group }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="limb_bp"
                                                                value="{{ @$nicufs1->limb_bp }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="birth_wt"
                                                                value="{{ @$nicufs1->birth_wt }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="daily_wt"
                                                                value="{{ @$nicufs1->daily_wt }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="rt_leg"
                                                                value="{{ @$nicufs1->rt_leg }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="lf_leg"
                                                                value="{{ @$nicufs1->lf_leg }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="rt_arm"
                                                                value="{{ @$nicufs1->rt_arm }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="lf_arm"
                                                                value="{{ @$nicufs1->lf_arm }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="ofc"
                                                                value="{{ @$nicufs1->ofc }}" class="form-control">
                                                        </td>


                                                    </tr>
                                                </thead>
                                            </table>

                                            @php
                                                $time_list = !empty($nicufs1->timee)
                                                    ? json_decode($nicufs1->timee, true)
                                                    : [];
                                                $hb = !empty($nicufs1->hb) ? json_decode($nicufs1->hb, true) : [];
                                                $ret = !empty($nicufs1->ret) ? json_decode($nicufs1->ret, true) : [];
                                                $hct = !empty($nicufs1->hct) ? json_decode($nicufs1->hct, true) : [];
                                                $plt = !empty($nicufs1->plt) ? json_decode($nicufs1->plt, true) : [];
                                                $wbc = !empty($nicufs1->wbc) ? json_decode($nicufs1->wbc, true) : [];
                                                $anc = !empty($nicufs1->anc) ? json_decode($nicufs1->anc, true) : [];
                                                $it = !empty($nicufs1->it) ? json_decode($nicufs1->it, true) : [];
                                                $crp = !empty($nicufs1->crp) ? json_decode($nicufs1->crp, true) : [];
                                                $na = !empty($nicufs1->na) ? json_decode($nicufs1->na, true) : [];
                                                $k = !empty($nicufs1->k) ? json_decode($nicufs1->k, true) : [];
                                                $ca = !empty($nicufs1->ca) ? json_decode($nicufs1->ca, true) : [];
                                                $p = !empty($nicufs1->p) ? json_decode($nicufs1->p, true) : [];
                                                $mg = !empty($nicufs1->mg) ? json_decode($nicufs1->mg, true) : [];
                                                $glu = !empty($nicufs1->glu) ? json_decode($nicufs1->glu, true) : [];
                                                $sbr = !empty($nicufs1->sbr) ? json_decode($nicufs1->sbr, true) : [];
                                                $ak = !empty($nicufs1->ak) ? json_decode($nicufs1->ak, true) : [];
                                                $aib = !empty($nicufs1->aib) ? json_decode($nicufs1->aib, true) : [];
                                                $irea = !empty($nicufs1->irea) ? json_decode($nicufs1->irea, true) : [];
                                                $reat = !empty($nicufs1->reat) ? json_decode($nicufs1->reat, true) : [];
                                                $radio = !empty($nicufs1->radio)
                                                    ? json_decode($nicufs1->radio, true)
                                                    : [];
                                            @endphp


                                            <table class="table table-bordered text-center align-middle">
                                                <thead>
                                                    <tr>

                                                        <th>Time</th>
                                                        <th>Hb</th>
                                                        <th>RET</th>
                                                        <th>HCT</th>
                                                        <th>PLT</th>
                                                        <th>WBC</th>
                                                        <th>ANC</th>
                                                        <th>I/T</th>
                                                        <th>CRP</th>
                                                        <th>Na</th>
                                                        <th>K</th>
                                                        <th>Ca</th>
                                                        <th>P</th>
                                                        <th>Mg</th>
                                                        <th>Glu</th>
                                                        <th>SBR</th>
                                                        <th>A/k Hos</th>
                                                        <th>AIb</th>
                                                        <th>UREA</th>
                                                        <th>REAT</th>
                                                        <th>RADIOLOGY</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vitalsTable">
                                                    @if (!empty($time_list))
                                                        @foreach ($time_list as $i => $timee)
                                                            <tr>
                                                                <td><input type="text" name="timee[]"
                                                                        value="{{ $timee }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hb[]"
                                                                        value="{{ $hb[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="ret[]"
                                                                        value="{{ $ret[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="hct[]"
                                                                        value="{{ $hct[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="plt[]"
                                                                        value="{{ $plt[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="wbc[]"
                                                                        value="{{ $wbc[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="anc[]"
                                                                        value="{{ $anc[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="it[]"
                                                                        value="{{ $it[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="crp[]"
                                                                        value="{{ $crp[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="na[]"
                                                                        value="{{ $na[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="k[]"
                                                                        value="{{ $k[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="ca[]"
                                                                        value="{{ $ca[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="p[]"
                                                                        value="{{ $p[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="mg[]"
                                                                        value="{{ $mg[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="glu[]"
                                                                        value="{{ $glu[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="sbr[]"
                                                                        value="{{ $sbr[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="ak[]"
                                                                        value="{{ $ak[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="aib[]"
                                                                        value="{{ $aib[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="irea[]"
                                                                        value="{{ $irea[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="reat[]"
                                                                        value="{{ $reat[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="radio[]"
                                                                        value="{{ $radio[$i] ?? '' }}"
                                                                        style="width:100%"></td>

                                                                <td>
                                                                    <span class="btn btn-success btn-md addvt"><i
                                                                            class="fa fa-plus"></i></span> <br>
                                                                    <button type="button"
                                                                        class="btn btn-md btn-danger vtdeleterow"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="timee[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="hb[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="ret[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="hct[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="plt[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="wbc[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="anc[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="it[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="crp[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="na[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="k[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="ca[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="p[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="mg[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="glu[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="sbr[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="ak[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="aib[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="irea[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="reat[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="radio[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><span class="btn btn-success btn-md addvt"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="2">Time</th>
                                                        <th colspan="16">ASSESSMENT</th>

                                                    </tr>
                                                    <tr>
                                                        <th>SKIN PROBE &deg;C</th>
                                                        <th>INF ANT TEMP &deg;C </th>
                                                        <th>HEART RATE</th>
                                                        <th>RESP. RATE</th>
                                                        <th>BLOOD PRESSURE</th>
                                                        <th>MEAN BP</th>
                                                        <th>COLOR</th>
                                                        <th>ACTIVITY</th>
                                                        <th>CAPILLARY REFILL TIME</th>
                                                        <th>AIR ENTRY</th>
                                                        <th>BREATH SOUNDS</th>
                                                        <th>RESPIRATORY EFFORT</th>
                                                        <th>CHEST TUBES</th>
                                                        <th>INO(PPM)</th>
                                                        <th>02 SAT PRE</th>
                                                        <th>02 SAT POST</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>

                                                            {{-- ASSESSMENT --}}
                                                            <td><input type="text" name="skin_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'skin_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="iat_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'iat_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="heart_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'heart_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="resp_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'resp_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="bloodp_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'bloodp_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="meanbp_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'meanbp_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="color_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'color_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="actv_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'actv_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="crt_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'crt_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="air_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'air_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="breath_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'breath_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="re_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'re_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="ct_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'ct_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="ino_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'ino_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="spre_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'spre_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="spost_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'spost_' . $t} }}"
                                                                    class="form-control"></td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="2">Time</th>
                                                        <th colspan="9">RESPIRATORY DATA</th>

                                                    </tr>
                                                    <tr>

                                                        <th>VENT/O2 DELIVERY MODE</th>
                                                        <th>FIO<sub>2</sub></th>
                                                        <th>RATE</th>
                                                        <th>PIP</th>
                                                        <th>PEEP</th>
                                                        <th>MAP</th>
                                                        <th>TIME</th>
                                                        <th>TV</th>
                                                        <th>MV</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times2 = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times2 as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>



                                                            {{-- RESPIRATORY DATA --}}

                                                            <td><input type="text" name="vent_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'vent_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="fio2_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'fio2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="rate_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'rate_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="pip_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'pip_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="peep_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'peep_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="map_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'map_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="time_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'time_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tv_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'tv_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="mv_{{ $t }}"
                                                                    value="{{ @$nicufs1->{'mv_' . $t} }}"
                                                                    class="form-control"></td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="2">Time</th>
                                                        <th colspan="10">NEURO ASSESSMENT</th>
                                                        <th colspan="1">PAIN SCALE </th>
                                                        <th colspan="8">BLOOD GAS PARAMETERS</th>
                                                    </tr>
                                                    <tr>

                                                        <th>LEVEL OF CONSCIOUSNESS</th>
                                                        <th>SEIZURE ACTIVITY</th>
                                                        <th>ANTERIOR FONTANEL</th>
                                                        <th>SUTURES</th>
                                                        <th>TONE </th>
                                                        <th>MOVEMENT </th>
                                                        <th>PUPIL
                                                            ACTIVITY</th>
                                                        <th>PUPIL SIZE</th>
                                                        <th>BLADDER
                                                            CONTROL</th>
                                                        <th>MORO REFLEX</th>

                                                        <th>N-PASS</th>

                                                        <th>TYPE </th>
                                                        <th>PH</th>
                                                        <th>PCO₂</th>
                                                        <th>PO₂</th>
                                                        <th>HCO₃</th>
                                                        <th>BE</th>
                                                        <th>Lac</th>
                                                        <th>Glu</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times3 = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times3 as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>

                                                            <td><input type="text"
                                                                    name="neuro_level_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'neuro_level_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="seizure_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'seizure_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="fontanel_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'fontanel_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="sutures_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'sutures_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="tone_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tone_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="movement_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'movement_' . $t} }}"
                                                                    class="form-control"></td>

                                                            <td><input type="text"
                                                                    name="pupil_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'pupil_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="psize_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'psize_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="bladder_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'bladder_' . $t} }}"
                                                                    class="form-control"></td>

                                                            <td><input type="text"
                                                                    name="reflex_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'reflex_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="npass_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'npass_' . $t} }}"
                                                                    class="form-control"></td>


                                                            <td><input type="text"
                                                                    name="type_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'type_' . $t} }}"
                                                                    class="form-control"></td>

                                                            <td><input type="text" name="ph_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'ph_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="pco2_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'pco2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="po2_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'po2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hco3_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hco3_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="be_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'be_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="lac_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'lac_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="glu_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'glu_' . $t} }}"
                                                                    class="form-control"></td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">

                                                <tr>
                                                    <th>CULTURES</th>
                                                    <th>SENT DATE </th>
                                                    <th>PREVIOUS DATE </th>
                                                    <th>REPORT SUMMARY</th>
                                                    <th>TIME</th>
                                                    <th>SPECIAL INSTRUCTIONS </th>
                                                </tr>
                                                <tr>
                                                    <td><b>BLOOD C/S </b></td>
                                                    <td><input type="date" name="bloodcs_sent"
                                                            value="{{ @$nicufs1->bloodcs_sent }}"
                                                            class="form-control"></td>
                                                    <td><input type="date" name="bloodcs_prev"
                                                            value="{{ @$nicufs1->bloodcs_prev }}"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="bloodcs_rep"
                                                            value="{{ @$nicufs1->bloodcs_rep }}"
                                                            class="form-control"></td>
                                                    <td>M</td>
                                                    <td><input type="text" name="m_si"
                                                            value="{{ @$nicufs1->m_si }}" class="form-control"></td>


                                                </tr>
                                                <tr>
                                                    <td><b>URINE C/S </b></td>
                                                    <td><input type="date" name="urinecs_sent"
                                                            value="{{ @$nicufs1->urinecs_sent }}"
                                                            class="form-control"></td>
                                                    <td><input type="date" name="urinecs_prev"
                                                            value="{{ @$nicufs1->urinecs_prev }}"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="urinecs_rep"
                                                            value="{{ @$nicufs1->urinecs_rep }}"
                                                            class="form-control"></td>
                                                    <td>E</td>
                                                    <td><input type="text" name="e_si"
                                                            value="{{ @$nicufs1->e_si }}" class="form-control"></td>


                                                </tr>
                                                <tr>
                                                    <td><b>SWAB C/S </b></td>
                                                    <td><input type="date" name="swabcs_sent"
                                                            value="{{ @$nicufs1->swabcs_sent }}"
                                                            class="form-control"></td>
                                                    <td><input type="date" name="swabcs_prev"
                                                            value="{{ @$nicufs1->swabcs_prev }}"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="swabcs_rep"
                                                            value="{{ @$nicufs1->swabcs_rep }}"
                                                            class="form-control">
                                                    </td>
                                                    <td>N</td>
                                                    <td><input type="text" name="n_si"
                                                            value="{{ @$nicufs1->n_si }}" class="form-control"></td>


                                                </tr>

                                                <tr>

                                                    <th>No. </th>
                                                    <th>ANTIBIOTICS </th>
                                                    <th>DAYS</th>
                                                    <th colspan="3">SPECIAL NOTES</th>
                                                </tr>
                                                <tr>
                                                    <td><b>1</b></td>
                                                    <td><input type="text" name="anti_1"
                                                            value="{{ @$nicufs1->anti_1 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="days_1"
                                                            value="{{ @$nicufs1->days_1 }}" class="form-control">
                                                    </td>
                                                    <td colspan="3" rowspan="5">
                                                        <textarea name="special_notes" id="" cols="30" rows="10">{{ @$nicufs1->special_notes }}</textarea>

                                                </tr>
                                                <tr>
                                                    <td><b>2</b></td>
                                                    <td><input type="text" name="anti_2"
                                                            value="{{ @$nicufs1->anti_2 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="days_2"
                                                            value="{{ @$nicufs1->days_2 }}" class="form-control">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td><b>3</b></td>
                                                    <td><input type="text" name="anti_3"
                                                            value="{{ @$nicufs1->anti_3 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="days_3"
                                                            value="{{ @$nicufs1->days_3 }}" class="form-control">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td><b>4</b></td>
                                                    <td><input type="text" name="anti_4"
                                                            value="{{ @$nicufs1->anti_4 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="days_4"
                                                            value="{{ @$nicufs1->days_4 }}" class="form-control">
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td><b>5</b></td>
                                                    <td><input type="text" name="anti_5"
                                                            value="{{ @$nicufs1->anti_5 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="days_5"
                                                            value="{{ @$nicufs1->days_5 }}" class="form-control">
                                                    </td>


                                                </tr>



                                            </table>
                                        </div>

                                        <!-- NICU Flow Sheet Legend / Static Footer -->
                                        <div class="mt-3">
                                            <table class="table table-bordered text-center align-middle small">
                                                <tr>
                                                    <td><strong>COLOUR</strong>
                                                    <td><strong>ACTIVITY</strong>
                                                    <td><b>AIR ENTRY </b></td>
                                                    <td><b>BREATH SOUNDS</b></td>
                                                    <td><b>RESPIRATORY EFFORT</b></td>
                                                    <td><b>RETRACTIONS</b></td>
                                                    <td><b>VENT MODE/DELIVERY MODE</b></td>
                                                    <td><b>LEVEL OF CONCIOUSNESS</b></td>
                                                    <td><b>ANTERIOR FONTANEL</b></td>
                                                    <td><b>MOVEMENT</b></td>
                                                    <td><b>BLADDER CONTROL</b></td>


                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; vertical-align: top;"> P - PINK<br>
                                                        D - DUSKY<br>
                                                        C - CYANOSED<br>
                                                        A - ASHEN<br>
                                                        M - MOTTLED<br>
                                                        PA - PALE<br>
                                                        J - JAUNDICED</td>
                                                    <td style="text-align: left; vertical-align: top;">A - ACTIVE<br>
                                                        H - HYPERACTIVE<br>
                                                        I - IRRITABLE<br>
                                                        S - LETHARGIC<br>
                                                        S - SEDATED<br>
                                                        P - PARALYSED<br>
                                                        Q - QUIET</td>
                                                    <td style="text-align: left; vertical-align: top;">= - EQUAL <br>
                                                        ↓R - DECREASE RIGHT SIDE<br>
                                                        ↓L - DECREASE LEFT SIDE

                                                    </td>
                                                    <td style="text-align: left; vertical-align: top;">W - WHEEZY<br>
                                                        FC - FINE CRACKLES<br>
                                                        CO - COARSE<br>
                                                        T - TIGHT<br>
                                                        CL - CLEAR<br>
                                                        R - RALES<br>
                                                        ST - STRIDOR<br>
                                                        M - MOIST</td>
                                                    <td style="text-align: left; vertical-align: top;">S - SHALLOW<br>
                                                        IR - IRREGULAR<br>
                                                        FL - FLARING<br>
                                                        G - GRUNTING<br>
                                                        EZ - EASY<br>
                                                        IVS - IN SYNC WITH VENT<br>
                                                        INO - INHALED NITRIC OXIDE</td>
                                                    <td style="text-align: left; vertical-align: top;">R1 - MILD<br>
                                                        R2 - MODERATE<br>
                                                        R3 - SEVERE <br>
                                                        <hr>
                                                        <b>CHEST TUBES </b>
                                                        <hr>
                                                        F - FLUCTUATING
                                                        B - BUBBLING
                                                    </td>
                                                    <td style="text-align: left; vertical-align: top;">S - SIMV<br>
                                                        C - CPAP<br>
                                                        BM - BAG / MASK<br>
                                                        BE - BAG / ETT<br>
                                                        A - AIRWAY (ORAL)<br>
                                                        FF - FREE FLOW O₂<br>
                                                        LF - LOW FLOW O₂ PRONGS<br>
                                                        O - OXYHOOD</td>
                                                    <td style="text-align: left; vertical-align: top;">
                                                        F - FOLLOW WITH EYES &nbsp;D - DROWSY <br>
                                                        S - STUPOR &nbsp; C - COMA <br>
                                                        <hr>
                                                        <b>SEIZURE ACTIVITY</b>
                                                        <hr>
                                                        RT - RHYTHMIC TWITCHING &nbsp; FJ - FAST JERKS <br>
                                                        SS - SUSTAINED STIFFENING &nbsp; G - GENERALISED <br>
                                                        S - SUBTLE MOVEMENTS &nbsp; F - FOCAL
                                                    </td>
                                                    <td style="text-align: left; vertical-align: top;">F - FULL &nbsp;
                                                        FL- FLAT &nbsp; T - TENSE <br>
                                                        N - NORMOTENSIVE &nbsp; D -DEPRESSED
                                                        <hr>
                                                        <b>SUTURES</b>
                                                        <hr>
                                                        N - NORMAL &nbsp; S - SEPERATED &nbsp; OR - OVERIOING
                                                        <hr>
                                                        <b>TONE : NECK / LIMBS</b>
                                                        <hr>
                                                        F - FLACCID &nbsp; E - HYPOTONIC <br>
                                                        N - NORMAL &nbsp; D - HYPERTONIC
                                                    </td>
                                                    <td style="text-align: left">A - ASYMMETRIC N - NORMAL P -
                                                        PARALYZED J - JITTERNEGS <br>
                                                        JH - JITTERINESS WITH HANDLING
                                                        <hr>
                                                        <b>PUPIL ACTIVITY </b>
                                                        <hr>
                                                        FX - FIXED B - BRISK R - RIGHT L - LEFT <br>
                                                        <hr>
                                                        <b>PERLA (PUPILS EQUAL REACTION TO LIGHT & ACCOMMODATION)</b>
                                                        <hr>
                                                        <b>MORO REFLEX </b>
                                                        <hr>
                                                        P - PESENT A - ABSENT PP - PARTIALLY PRESENT

                                                    </td>
                                                    <td style="text-align: left; vertical-align: top;">VS - VOIDS
                                                        SPONTANEOUSLY <br>
                                                        C - CATHETERISATION D - URINE DRIBBLING
                                                        <hr>
                                                        <b>PUPIL SIZE </b>
                                                        <hr>
                                                        D - DILATED PP - PINPOINT <br>
                                                        2 mm 3 mm 4 mm 5 mm 6 mm 7 mm
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7">BLOOD PRODUCTS</th>
                                                        <th colspan="3">24 HOURS FLUID BALANCE</th>
                                                        <th>TIMES</th>
                                                        <th>ML/H</th>
                                                        <th>ML/KG/DAY</th>
                                                        <th>FEEDING ROUTE</th>
                                                        <th>AMOUNT</th>
                                                        <th>ASPIRATE/GASTRIC DRAINAGE</th>
                                                        <th>TYPES OF DRAINS</th>
                                                        <th>TYPE OF STOOL</th>
                                                    </tr>
                                                    <tr>
                                                        <th>TIME</th>
                                                        <th>WHOLE BLOOD</th>
                                                        <th>PRBC</th>
                                                        <th>PLT</th>
                                                        <th>FFP</th>
                                                        <th>OTHERS</th>
                                                        <th>TOTAL</th>
                                                        <th>TOTAL INTAKE</th>
                                                        <th>TOTAL OUTPUT</th>
                                                        <th>DIFFERENCE</th>
                                                        <th><input type="text" name="tm1"
                                                                value="{{ @$nicufs1->tm1 }}" class="form-control">
                                                        </th>
                                                        <th><input type="text" name="mlh1"
                                                                value="{{ @$nicufs1->mlh1 }}" class="form-control">
                                                        </th>
                                                        <th><input type="text" name="mlkg1"
                                                                value="{{ @$nicufs1->mlkg1 }}" class="form-control">
                                                        </th>
                                                        <td rowspan="4" style="text-align: left">B - Bottle <br>
                                                            BR - Breast <br>
                                                            CF - Continuous Feed <br>
                                                            NG - Nasogastric <br>
                                                            OG - Orogastric <br>
                                                            GT - Gastrostomy Tube <br>
                                                            NNS - Non-nutritive Sucking </td>
                                                        <td rowspan="4"
                                                            style="text-align: left; vertical-align: top;">
                                                            SM - Small <br>
                                                            MO - Moderate <br>
                                                            L - Large
                                                        </td>
                                                        <td rowspan="4"
                                                            style="text-align: left; vertical-align: top;">
                                                            M - Mucous <br>
                                                            F - Fresh Blood <br>
                                                            C - Clear <br>
                                                            B.S - Blood Stain <br>
                                                            BL - Bile <br>
                                                            Y - Yellow <br>
                                                            CG - Coffee Ground <br>
                                                            UDM - Undigested Milk <br>
                                                            PDM - Partially Digested Milk <br>
                                                        </td>
                                                        <td rowspan="4"
                                                            style="text-align: left; vertical-align: top;">
                                                            SD - Straight Drainage
                                                            SL - Suction Low
                                                            <hr>
                                                            DATE OF LAST STOOL:
                                                            <input type="date" name="dols"
                                                                value="{{ @$nicufs1->dols }}" class="form-control">

                                                        </td>
                                                        <td rowspan="4"
                                                            style="text-align: left; vertical-align: top;">
                                                            B - Brown <br>
                                                            Y - Yellow <br>
                                                            M - Meconium <br>
                                                            P - Pasty <br>
                                                            W - Watery <br>
                                                            L - Loose <br>
                                                            G - Green
                                                        </td>



                                                    </tr>

                                                    <tr>
                                                        <td><input type="text" name="bp_time1"
                                                                value="{{ @$nicufs1->bp_time1 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_blood1"
                                                                value="{{ @$nicufs1->bp_blood1 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_prbc1"
                                                                value="{{ @$nicufs1->bp_prbc1 }}"
                                                                class="form-control"></td>
                                                        <td> <input type="text" name="bp_plt1"
                                                                value="{{ @$nicufs1->bp_plt1 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_ffp1"
                                                                value="{{ @$nicufs1->bp_ffp1 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_other1"
                                                                value="{{ @$nicufs1->bp_other1 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_total1"
                                                                value="{{ @$nicufs1->bp_total1 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="intake"
                                                                value="{{ @$nicufs1->intake }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="output"
                                                                value="{{ @$nicufs1->output }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="diff"
                                                                value="{{ @$nicufs1->diff }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="tm2"
                                                                value="{{ @$nicufs1->tm1 }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="mlh2"
                                                                value="{{ @$nicufs1->mlh1 }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="mlkg2"
                                                                value="{{ @$nicufs1->mlkg1 }}" class="form-control">
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="bp_time2"
                                                                value="{{ @$nicufs1->bp_time2 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_blood2"
                                                                value="{{ @$nicufs1->bp_blood2 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_prbc2"
                                                                value="{{ @$nicufs1->bp_prbc2 }}"
                                                                class="form-control"></td>
                                                        <td> <input type="text" name="bp_plt2"
                                                                value="{{ @$nicufs1->bp_plt2 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_ffp2"
                                                                value="{{ @$nicufs1->bp_ffp2 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_other2"
                                                                value="{{ @$nicufs1->bp_other2 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_total2"
                                                                value="{{ @$nicufs1->bp_total2 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><b>IV CHECK:</b></td>
                                                        <td colspan="2"><input type="text" name="iv_check"
                                                                value="{{ @$nicufs1->iv_check }}"
                                                                class="form-control">
                                                        </td>

                                                        <td><input type="text" name="tm3"
                                                                value="{{ @$nicufs1->tm3 }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="mlh3"
                                                                value="{{ @$nicufs1->mlh3 }}" class="form-control">
                                                        </td>
                                                        <td><input type="text" name="mlkg3"
                                                                value="{{ @$nicufs1->mlkg3 }}" class="form-control">
                                                        </td>



                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="bp_time3"
                                                                value="{{ @$nicufs1->bp_time3 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_blood3"
                                                                value="{{ @$nicufs1->bp_blood3 }}"
                                                                class="form-control"></td>
                                                        <td><input type="text" name="bp_prbc3"
                                                                value="{{ @$nicufs1->bp_prbc3 }}"
                                                                class="form-control"></td>
                                                        <td> <input type="text" name="bp_plt3"
                                                                value="{{ @$nicufs1->bp_plt3 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_ffp3"
                                                                value="{{ @$nicufs1->bp_ffp3 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_other3"
                                                                value="{{ @$nicufs1->bp_other3 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="bp_total3"
                                                                value="{{ @$nicufs1->bp_total3 }}"
                                                                class="form-control">
                                                        </td>
                                                        <td colspan="3">P - Puffy B - Blocked <br>
                                                            R - Removed A - Acceptable</td>



                                                        <td>TODAYS WEIGHT:<br>
                                                            <input type="text" name="today_wt"
                                                                value="{{ @$nicufs1->today_wt }}"
                                                                class="form-control">
                                                        </td>
                                                        <td colspan="2">GAIN/LOSS:<br>
                                                            <input type="text" name="loss"
                                                                value="{{ @$nicufs1->loss }}" class="form-control">
                                                        </td>



                                                    </tr>
                                                </thead>
                                            </table>

                                            <table class="table table-bordered text-center align-middle">
                                                <tr>
                                                    <th colspan="8">LINES AND TUBING</th>
                                                </tr>
                                                <tr>
                                                    <th>LINE / TUB</th>
                                                    <th>DATE OF INSERTION</th>
                                                    <th>SIZE</th>
                                                    <th>SITE</th>
                                                    <th>LENGTH</th>
                                                    <th>DAYS IN USE</th>
                                                    <th>DATE OF REMOVAL</th>
                                                    <th>DATE OF CHANGE</th>
                                                </tr>
                                                <tr>
                                                    <td><b>E.T. TUBE</b></td>
                                                    <td><input type="date" name="dt_insert"
                                                            value="{{ @$nicufs1->dt_insert }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="sizee"
                                                            value="{{ @$nicufs1->sizee }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site"
                                                            value="{{ @$nicufs1->site }}" class="form-control"></td>
                                                    <td><input type="text" name="length"
                                                            value="{{ @$nicufs1->length }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use"
                                                            value="{{ @$nicufs1->day_use }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove"
                                                            value="{{ @$nicufs1->dt_remove }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change"
                                                            value="{{ @$nicufs1->dt_change }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>UVC/UAC</b></td>
                                                    <td><input type="date" name="dt_insert2"
                                                            value="{{ @$nicufs1->dt_insert2 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size2"
                                                            value="{{ @$nicufs1->size2 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site2"
                                                            value="{{ @$nicufs1->site2 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length2"
                                                            value="{{ @$nicufs1->length2 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use2"
                                                            value="{{ @$nicufs1->day_use2 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove2"
                                                            value="{{ @$nicufs1->dt_remove2 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change2"
                                                            value="{{ @$nicufs1->dt_change2 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>PICC LINE</b></td>
                                                    <td><input type="date" name="dt_insert3"
                                                            value="{{ @$nicufs1->dt_insert3 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size3"
                                                            value="{{ @$nicufs1->size3 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site3"
                                                            value="{{ @$nicufs1->site3 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length3"
                                                            value="{{ @$nicufs1->length3 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use3"
                                                            value="{{ @$nicufs1->day_use3 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove3"
                                                            value="{{ @$nicufs1->dt_remove3 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change3"
                                                            value="{{ @$nicufs1->dt_change3 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>ARTERIAL LINE</b></td>
                                                    <td><input type="date" name="dt_insert4"
                                                            value="{{ @$nicufs1->dt_insert4 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size4"
                                                            value="{{ @$nicufs1->size4 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site4"
                                                            value="{{ @$nicufs1->site4 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length4"
                                                            value="{{ @$nicufs1->length4 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use4"
                                                            value="{{ @$nicufs1->day_use4 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove4"
                                                            value="{{ @$nicufs1->dt_remove4 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change4"
                                                            value="{{ @$nicufs1->dt_change4 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>URINARY CATHETER</b></td>
                                                    <td><input type="date" name="dt_insert5"
                                                            value="{{ @$nicufs1->dt_insert5 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size5"
                                                            value="{{ @$nicufs1->size5 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site5"
                                                            value="{{ @$nicufs1->site5 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length5"
                                                            value="{{ @$nicufs1->length5 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use5"
                                                            value="{{ @$nicufs1->day_use5 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove5"
                                                            value="{{ @$nicufs1->dt_remove5 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change5"
                                                            value="{{ @$nicufs1->dt_change5 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>VENTILATOR TUBING</b></td>
                                                    <td><input type="date" name="dt_insert6"
                                                            value="{{ @$nicufs1->dt_insert6 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size6"
                                                            value="{{ @$nicufs1->size6 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site6"
                                                            value="{{ @$nicufs1->site6 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length6"
                                                            value="{{ @$nicufs1->length6 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use6"
                                                            value="{{ @$nicufs1->day_use6 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove6"
                                                            value="{{ @$nicufs1->dt_remove6 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change6"
                                                            value="{{ @$nicufs1->dt_change6 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>HUMIDIFIER</b></td>
                                                    <td><input type="date" name="dt_insert7"
                                                            value="{{ @$nicufs1->dt_insert7 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="size7"
                                                            value="{{ @$nicufs1->size7 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="site7"
                                                            value="{{ @$nicufs1->site7 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="length7"
                                                            value="{{ @$nicufs1->length7 }}" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="day_use7"
                                                            value="{{ @$nicufs1->day_use7 }}" class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_remove7"
                                                            value="{{ @$nicufs1->dt_remove7 }}"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="date" name="dt_change7"
                                                            value="{{ @$nicufs1->dt_change7 }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                            </table>



                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="4">TIME</th>
                                                        <th rowspan="4">IV CHECK</th>
                                                        <th rowspan="4">IV FLUSHES</th>
                                                        <th colspan="10">INTAKE</th>
                                                    </tr>
                                                    <tr>

                                                        <th colspan="2">SITE</th>
                                                        <th colspan="2">SITE</th>
                                                        <th colspan="2">SITE</th>
                                                        <th colspan="2">SITE</th>
                                                        <th colspan="2">SITE</th>



                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">IV</th>
                                                        <th colspan="2">IV</th>
                                                        <th colspan="2">IV</th>
                                                        <th colspan="2">IV</th>
                                                        <th colspan="2">IV</th>
                                                    </tr>
                                                    <tr>
                                                        <th>HOURLY</th>
                                                        <th>TOTAL</th>
                                                        <th>HOURLY</th>
                                                        <th>TOTAL</th>
                                                        <th>HOURLY</th>
                                                        <th>TOTAL</th>
                                                        <th>HOURLY</th>
                                                        <th>TOTAL</th>
                                                        <th>HOURLY</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times4 = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times4 as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>

                                                            <td><input type="text" name="iv_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'iv_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="flushes_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'flushes_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hour1_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hour1_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tl1_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tl1_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hour2_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hour2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tl2_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tl2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hour3_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hour3_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tl3_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tl3_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hour4_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hour4_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tl4_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tl4_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="hour5_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'hour5_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="tl5_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'tl5_' . $t} }}"
                                                                    class="form-control"></td>




                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="4">TIME</th>
                                                        <th colspan="5">ORAL INTAKE</th>
                                                        <th colspan="15">OUTPUT</th>

                                                    </tr>
                                                    <tr>

                                                        <th rowspan="3">ROUTE</th>
                                                        <th rowspan="3">TYPE</th>
                                                        <th rowspan="3" class="rotate-text">RESIDUAL</th>
                                                        <th rowspan="3" class="rotate-text">VALUME</th>
                                                        <th rowspan="3" class="rotate-text">CUM TOTAL</th>
                                                        <th colspan="3">URINE</th>
                                                        <th>STOOL</th>
                                                        <th colspan="5">GASTRIC DRAINAGE</th>
                                                        <th colspan="6">CHEST TUBE</th>



                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="rotate-text">VALUME</th>
                                                        <th rowspan="2" class="rotate-text">CUM TOTAL</th>
                                                        <th rowspan="2" class="rotate-text">ML/KG/h</th>
                                                        <th rowspan="2" class="rotate-text">AMOUNT/TYPE</th>
                                                        <th rowspan="2" class="rotate-text">
                                                            REGURGITATE/VOMIT</th>
                                                        <th colspan="4">SX: <input type="text"
                                                                name="sx" value="{{ @$nicufs1->sx }}"
                                                                class="form-control">
                                                        </th>
                                                        <th colspan="2">SITE 1</th>
                                                        <th colspan="2">SITE 2</th>
                                                        <th colspan="2">SITE 3</th>

                                                    </tr>
                                                    <tr>
                                                        <th>IN</th>
                                                        <th>RETURN</th>
                                                        <th>H VOL</th>
                                                        <th>CUM TOTAL</th>
                                                        <th>H</th>
                                                        <th>CUM</th>
                                                        <th>H</th>
                                                        <th>CUM</th>
                                                        <th>H</th>
                                                        <th>CUM</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times5 = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times5 as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>

                                                            <td><input type="text"
                                                                    name="oi_route_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'oi_route_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oi_type_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'oi_type_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oi_res_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'oi_res_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oi_vol_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'oi_vol_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oi_cum_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'oi_cum_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ou_vol_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'ou_vol_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ou_cum_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'ou_cum_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ou_ml_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'ou_ml_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="o_stool_{{ $t }}"
                                                                    value="{{ @$nicufs2->{'o_stool_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ogd_vomit_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'ogd_vomit_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ogd_in_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'ogd_in_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ogd_return_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'ogd_return_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ogd_hvol_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'ogd_hvol_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="ogd_cum_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'ogd_cum_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_h1_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_h1_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_cum1_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_cum1_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_h2_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_h2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_cum2_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_cum2_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_h3_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_h3_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="oct_cum3_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'oct_cum3_' . $t} }}"
                                                                    class="form-control"></td>





                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th rowspan="2">TIME</th>
                                                        <th colspan="9">SPECIAL CARE</th>


                                                    </tr>

                                                    <tr>
                                                        <th>ABDOMINAL GIRTH</th>
                                                        <th>E.T. SUCTION</th>
                                                        <th>POSITION</th>
                                                        <th>CHEST PHYSIO</th>
                                                        <th>NEBULIZATION</th>
                                                        <th>EYE CARE</th>
                                                        <th>CORD CARE</th>
                                                        <th>CATHETER CARE</th>
                                                        <th>OGT CARE</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $times6 = [
                                                            '8am',
                                                            '9am',
                                                            '10am',
                                                            '11am',
                                                            '12pm',
                                                            '1pm',
                                                            '2pm',
                                                            '3pm',
                                                            '4pm',
                                                            '5pm',
                                                            '6pm',
                                                            '7pm',
                                                            '8pm',
                                                            '9pm',
                                                            '10pm',
                                                            '11pm',
                                                            '12am',
                                                            '1am',
                                                            '2am',
                                                            '3am',
                                                            '4am',
                                                            '5am',
                                                            '6am',
                                                            '7am',
                                                        ];
                                                    @endphp

                                                    @foreach ($times6 as $t)
                                                        <tr>
                                                            <td>{{ strtoupper($t) }}</td>

                                                            <td><input type="text"
                                                                    name="girth_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'girth_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="suction_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'suction_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="position_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'position_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="chest_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'chest_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="nebuliza_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'nebuliza_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="eyecare_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'eyecare_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="cordcare_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'cordcare_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="catheter_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'catheter_' . $t} }}"
                                                                    class="form-control"></td>
                                                            <td><input type="text"
                                                                    name="mouthcare_{{ $t }}"
                                                                    value="{{ @$nicufs3->{'mouthcare_' . $t} }}"
                                                                    class="form-control"></td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered text-center align-middle"
                                                style="font-size: 12px;">

                                                <tr>
                                                    <th colspan="10">N-PASS: Neonatal Pain, Agitation & Sedation
                                                        Scale</th>


                                                </tr>
                                                <tr>
                                                    <th rowspan="2">Assessment Criteria</th>
                                                    <th colspan="2">Sedation</th>
                                                    <th>Sedation/Pain</th>
                                                    <th colspan="2">Pain/Agitation</th>
                                                    <th>SHIFT</th>
                                                    <th style="width: 20%">ASSIGNED STAFF</th>
                                                    <th>EMPLOYEE ID</th>
                                                    <th>SIGNATURE</th>
                                                </tr>

                                                <tr>

                                                    <th>-2</th>
                                                    <th>-1</th>
                                                    <th>0/0</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th rowspan="2">MORNING</th>
                                                    <td rowspan="2"><input type="text" name="m_staff"
                                                            id="m_staff" value="{{ @$nicufs1->m_staff }}"
                                                            class="form-control">
                                                            <input type="hidden" name="m_empid"
                                                            value="" class="form-control">

                                                        </td>
                                                    <td rowspan="2"><input type="text" name="m_empid"
                                                            value="{{ @$nicufs1->m_empid }}" class="form-control">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="m_sign"
                                                            value="{{ @$nicufs1->m_sign }}" class="form-control">
                                                    </td>



                                                </tr>
                                                <tr>
                                                    <td>Crying / Irritability</td>
                                                    <td>No cry with painful stimuli</td>
                                                    <td>Moans or cries minimally with painful stimuli</td>
                                                    <td>No sedation / No pain signs</td>
                                                    <td>Irritable or crying at intervals Consoliable</td>
                                                    <td>High-pitched or silent-continuous cry inconsoliable</td>
                                                </tr>

                                                <tr>
                                                    <td>Behavior State</td>
                                                    <td>No arousal to any stimuli no spontaneous movement</td>
                                                    <td>Arouses minimally / No spontaneous movement</td>
                                                    <td>No sedation / No pain signs</td>
                                                    <td>Restless, squirming Awakens frequently</td>
                                                    <td>Arching, kicking constantly awake or Arouses minimally / no
                                                        movement (not sedated)</td>
                                                    <th rowspan="2">EVENING</th>
                                                    <td rowspan="2"><input type="text" name="e_staff"
                                                            id="e_staff" value="{{ @$nicufs1->e_staff }}"
                                                            class="form-control"></td>
                                                    <td rowspan="2"><input type="text" name="e_empid"
                                                            value="{{ @$nicufs1->e_empid }}" class="form-control">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="e_sign"
                                                            value="{{ @$nicufs1->e_sign }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Facial Expression</td>
                                                    <td>Mouth is lax No expression</td>
                                                    <td>Minimal expression with stimuli</td>
                                                    <td>No sedation / No pain signs</td>
                                                    <td>Any pain expression intermittent</td>
                                                    <td>Any pain expression continual</td>
                                                </tr>
                                                <tr>
                                                    <td>Vital Signs HR, RR, BP, SaO₂</td>
                                                    <td>No variability with stimuli / Hypoventilation or apnea</td>
                                                    <td>&lt;10% variability for moderate with stimuli</td>
                                                    <td>No sedation / No pain signs</td>
                                                    <td>&lt;10-20% from Painless State. SpO₂ 76-85% with stimulation -
                                                        quick +</td>
                                                    <td>&lt;20% from baseline SpO₂ ≤ 75% with stimulation or SpO₂ = 90%
                                                        with oxygen. Out of synchrony with vent</td>
                                                    <th rowspan="2">NIGHT</th>
                                                    <td rowspan="2"><input type="text" name="n_staff"
                                                            id="n_staff" value="{{ @$nicufs1->n_staff }}"
                                                            class="form-control"></td>
                                                    <td rowspan="2"><input type="text" name="n_empid"
                                                            value="{{ @$nicufs1->n_empid }}" class="form-control">
                                                    </td>
                                                    <td rowspan="2"><input type="text" name="n_sign"
                                                            value="{{ @$nicufs1->n_sign }}" class="form-control">
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>


                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.nicu-flow-sheet-form', [
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
    openDoctorAutocomplete('#m_staff', 'm_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#e_staff', 'e_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#n_staff', 'n_empid', 'employee_ind', '1');
    openDoctorAutocomplete('#consultant', 'hconsultant', 'employee_ind', '1');


    $(function() {
        const makeRow = () => `
        <tr>
                <td><input type="text" name="timee[]" style="width:100%"></td>
                <td><input type="text" name="hb[]" style="width:100%"></td>
                <td><input type="text" name="ret[]" style="width:100%"></td>
                <td><input type="text" name="hct[]" style="width:100%"></td>
                <td><input type="text" name="plt[]" style="width:100%"></td>
                <td><input type="text" name="wbc[]" style="width:100%"></td>
                <td><input type="text" name="anc[]" style="width:100%"></td>
                <td><input type="text" name="it[]" style="width:100%"></td>
                <td><input type="text" name="crp[]" style="width:100%"></td>
                <td><input type="text" name="na[]"  style="width:100%"></td>
                <td><input type="text" name="k[]"   style="width:100%"></td>
                <td><input type="text" name="ca[]"   style="width:100%"></td>
                <td><input type="text" name="p[]"   style="width:100%"></td>
                <td><input type="text" name="mg[]"   style="width:100%"></td>
                <td><input type="text" name="glu[]"   style="width:100%"></td>
                <td><input type="text" name="sbr[]"   style="width:100%"></td>
                <td><input type="text" name="ak[]"   style="width:100%"></td>
                <td><input type="text" name="aib[]"   style="width:100%"></td>
                <td><input type="text" name="irea[]"   style="width:100%"></td>
                <td><input type="text" name="reat[]"   style="width:100%"></td>
                <td><input type="text" name="radio[]"   style="width:100%"></td>
            <td>
                <button type="button" class="btn btn-md btn-danger vtdeleterow"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;

        // Prevent duplicate bindings
        $(document).off('click', '.addvt').on('click', '.addvt', function(e) {
            e.preventDefault();
            $("#vitalsTable").append(makeRow());
        });

        $(document).off('click', '.vtdeleterow').on('click', '.vtdeleterow', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
