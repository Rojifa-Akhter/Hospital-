<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}


    <style>
        .border-left-0 {
            border-left: none !important;
        }

        .border-right-0 {
            border-right: none !important;
        }

        thead {
            background-color: white;

        }



        .fs-12 {
            font-size: 16px;
        }



        .table-bordered {
            border: 1px solid #333;
        }




        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td,
        .header>thead>tr>td {
            border: none;
        }



        .footer-table {
            position: bottom;
            bottom: 0px;
            width: 95%;

            margin-top: 10px;
        }



        body {
            margin: 0.5cm 0.5cm;
            overflow-x: hidden;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }

        table.nicufs-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            text-align: center;
            vertical-align: middle;
        }

        .nicufs-table th,
        .nicufs-table td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .rotate-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            font-size: 12px;
        }

        .nested-row {
            background-color: #f9f9f9;
        }

        .sub-table th,
        .sub-table td {
            border: none;
            padding: 3px 6px;
            text-align: center;
        }

        th,
        td {
            font-size: 13px;
            /* reduce slightly to fit */
            padding: 2px;
            border: 1px solid #333;
            white-space: normal;
            /* allow wrapping */
            text-align: center;
        }

        .rotate-text {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            text-align: center;
            vertical-align: bottom;
            padding: 0;
            /* removes extra width from padding */
            line-height: 1;
        }

        @page {
            size: A4 landscape;
            /* optional: force print width fit */
            margin: 1cm;
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65% ;text-align:left;">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>NICU FLOW SHEET</b></span>
                    </div>
                    @php
                        $time_list = !empty($nicufs1->timee) ? json_decode($nicufs1->timee, true) : [];
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
                        $radio = !empty($nicufs1->radio) ? json_decode($nicufs1->radio, true) : [];
                    @endphp
                    <table class="nicufs-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Consultant</th>
                                <th>BL. GROUP</th>
                                <th>BIRTH WT.</th>
                                <th>RT. LEG</th>
                                <th>LF. LEG</th>
                                <th>OFC</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($time_list as $i => $timee)
                                <tr class="nested-row">
                                    @if ($i === 0)
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->datee }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->consultant }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->bl_group }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->birth_wt }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->rt_leg }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->lf_leg }}</td>
                                        <td rowspan="{{ count($time_list) }}">{{ @$nicufs1->ofc }}</td>
                                    @endif
                                    <td>{{ $timee }}</td>
                                    <td>{{ $hb[$i] ?? '' }}</td>
                                    <td>{{ $ret[$i] ?? '' }}</td>
                                    <td>{{ $hct[$i] ?? '' }}</td>
                                    <td>{{ $plt[$i] ?? '' }}</td>
                                    <td>{{ $wbc[$i] ?? '' }}</td>
                                    <td>{{ $anc[$i] ?? '' }}</td>
                                    <td>{{ $it[$i] ?? '' }}</td>
                                    <td>{{ $crp[$i] ?? '' }}</td>
                                    <td>{{ $na[$i] ?? '' }}</td>
                                    <td>{{ $k[$i] ?? '' }}</td>
                                    <td>{{ $ca[$i] ?? '' }}</td>
                                    <td>{{ $p[$i] ?? '' }}</td>
                                    <td>{{ $mg[$i] ?? '' }}</td>
                                    <td>{{ $glu[$i] ?? '' }}</td>
                                    <td>{{ $sbr[$i] ?? '' }}</td>
                                    <td>{{ $ak[$i] ?? '' }}</td>
                                    <td>{{ $aib[$i] ?? '' }}</td>
                                    <td>{{ $irea[$i] ?? '' }}</td>
                                    <td>{{ $reat[$i] ?? '' }}</td>
                                    <td>{{ $radio[$i] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="nicufs-table" style="margin-top: 10px;">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Diagnosis</th>
                                <th>4 LIMB BP</th>
                                <th>DAILY WT.</th>
                                <th>RT. ARM</th>
                                <th>LF. ARM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ @$nicufs1->day }}</td>
                                <td>{{ @$nicufs1->diagnosis }}</td>
                                <td>{{ @$nicufs1->limb_bp }}</td>
                                <td>{{ @$nicufs1->daily_wt }}</td>
                                <td>{{ @$nicufs1->rt_arm }}</td>
                                <td>{{ @$nicufs1->lf_arm }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="nicufs-table" style="margin-top: 10px;">

                        <tr>
                            <th rowspan="2" class="rotate-text">Time</th>
                            <th colspan="16">ASSESSMENT</th>
                            <th colspan="9">RESPIRATORY DATA</th>
                            <th colspan="10">NEURO ASSESSMENT</th>
                            <th colspan="1" class="rotate-text">PAIN SCALE </th>
                            <th colspan="8">BLOOD GAS PARAMETERS</th>



                        </tr>
                        <tr>
                            <th class="rotate-text">SKIN PROBE &deg;C</th>
                            <th class="rotate-text">INF ANT TEMP &deg;C </th>
                            <th class="rotate-text">HEART RATE</th>
                            <th class="rotate-text">RESP. RATE</th>
                            <th class="rotate-text">BLOOD PRESSURE</th>
                            <th class="rotate-text">MEAN BP</th>
                            <th class="rotate-text">COLOR</th>
                            <th class="rotate-text">ACTIVITY</th>
                            <th class="rotate-text">CAPILLARY REFILL TIME</th>
                            <th class="rotate-text">AIR ENTRY</th>
                            <th class="rotate-text">BREATH SOUNDS</th>
                            <th class="rotate-text">RESPIRATORY EFFORT</th>
                            <th class="rotate-text">CHEST TUBES</th>
                            <th class="rotate-text">INO(PPM)</th>
                            <th class="rotate-text">02 SAT PRE</th>
                            <th class="rotate-text">02 SAT POST</th>
                            <th class="rotate-text">VENT/O2 DELIVERY MODE</th>
                            <th class="rotate-text">FIO<sub>2</sub></th>
                            <th class="rotate-text">RATE</th>
                            <th class="rotate-text">PIP</th>
                            <th class="rotate-text">PEEP</th>
                            <th class="rotate-text">MAP</th>
                            <th class="rotate-text">TIME</th>
                            <th class="rotate-text">TV</th>
                            <th class="rotate-text">MV</th>

                            <th class="rotate-text">LEVEL OF CONSCIOUSNESS</th>
                            <th class="rotate-text">SEIZURE ACTIVITY</th>
                            <th class="rotate-text">ANTERIOR FONTANEL</th>
                            <th class="rotate-text">SUTURES</th>
                            <th class="rotate-text">TONE </th>
                            <th class="rotate-text">MOVEMENT </th>
                            <th class="rotate-text">PUPIL
                                ACTIVITY</th>
                            <th class="rotate-text">PUPIL SIZE</th>
                            <th class="rotate-text">BLADDER
                                CONTROL</th>
                            <th class="rotate-text">MORO REFLEX</th>

                            <th class="rotate-text">N-PASS</th>

                            <th class="rotate-text">TYPE </th>
                            <th class="rotate-text">PH</th>
                            <th class="rotate-text">PCO₂</th>
                            <th class="rotate-text">PO₂</th>
                            <th class="rotate-text">HCO₃</th>
                            <th class="rotate-text">BE</th>
                            <th class="rotate-text">Lac</th>
                            <th class="rotate-text">Glu</th>





                        </tr>
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
                                <td>{{ @$nicufs1->{'skin_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'iat_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'heart_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'resp_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'bloodp_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'meanbp_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'color_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'actv_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'crt_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'air_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'breath_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'re_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'ct_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'ino_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'spre_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'spost_' . $t} }}</td>

                                {{-- RESPIRATORY DATA --}}
                                <td>{{ @$nicufs1->{'vent_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'fio2_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'rate_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'pip_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'peep_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'map_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'time_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'tv_' . $t} }}</td>
                                <td>{{ @$nicufs1->{'mv_' . $t} }}</td>

                                {{-- NEURO ASSESSMENT --}}
                                <td>{{ @$nicufs2->{'neuro_level_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'seizure_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'fontanel_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'sutures_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'tone_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'movement_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'pupil_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'psize_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'bladder_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'reflex_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'npass_' . $t} }}</td>

                                {{-- BLOOD GAS PARAMETERS --}}
                                <td>{{ @$nicufs2->{'type_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'ph_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'pco2_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'po2_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'hco3_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'be_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'lac_' . $t} }}</td>
                                <td>{{ @$nicufs2->{'glu_' . $t} }}</td>



                            </tr>
                        @endforeach

                    </table>
                    <table class="nicufs-table" style="margin-top: 10px;">
                        <thead>
                            <tr>

                                <th>CULTURES</th>
                                <th>SENT DATE </th>
                                <th>PREVIOUS DATE </th>
                                <th>REPORT SUMMARY</th>
                                <th>TIME</th>
                                <th style="width: 15%">SPECIAL INSTRUCTIONS</th>
                                <th>No.</th>
                                <th>ANTIBIOTICS</th>
                                <th>DAYS</th>
                                <th style="width: 30%">SPECIAL NOTES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>BLOOD C/S</b></td>
                                <td>{{ @$nicufs1->bloodcs_sent }}</td>
                                <td>{{ @$nicufs1->bloodcs_prev }}</td>
                                <td>{{ @$nicufs1->bloodcs_rep }}</td>
                                <td>M</td>
                                <td>{{ @$nicufs1->m_si }}</td>
                                <td><b>1</b></td>
                                <td>{{ @$nicufs1->anti_1 }}
                                </td>
                                <td>{{ @$nicufs1->days_1 }}
                                </td>
                                <td rowspan="5">{{ @$nicufs1->special_notes }}</td>

                            </tr>
                            <tr>
                                <td rowspan="2"><b>URINE C/S</b></td>
                                <td rowspan="2">{{ @$nicufs1->urinecs_sent }}</td>
                                <td rowspan="2">{{ @$nicufs1->urinecs_prev }}</td>
                                <td rowspan="2">{{ @$nicufs1->urinecs_rep }}</td>
                                <td rowspan="2">E</td>
                                <td rowspan="2">{{ @$nicufs1->e_si }}</td>
                                <td><b>2</b></td>
                                <td>{{ @$nicufs1->anti_2 }}
                                </td>
                                <td>{{ @$nicufs1->days_2 }}
                                </td>

                            </tr>
                            <tr>

                                <td><b>3</b></td>
                                <td>{{ @$nicufs1->anti_3 }}
                                </td>
                                <td>{{ @$nicufs1->days_3 }}
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2"><b>SWAB C/S</b></td>
                                <td rowspan="2">{{ @$nicufs1->swabcs_sent }}</td>
                                <td rowspan="2">{{ @$nicufs1->swabcs_prev }}</td>
                                <td rowspan="2">{{ @$nicufs1->swabcs_rep }}</td>
                                <td rowspan="2">N</td>
                                <td rowspan="2">{{ @$nicufs1->n_si }}</td>
                                <td><b>4</b></td>
                                <td>{{ @$nicufs1->anti_4 }}
                                </td>
                                <td>{{ @$nicufs1->days_4 }}
                                </td>
                            </tr>
                            <tr>
                                <td><b>5</b></td>
                                <td>{{ @$nicufs1->anti_5 }}
                                </td>
                                <td>{{ @$nicufs1->days_5 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="nicufs-table" style="margin-top: 10px;">
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
                    <table class="nicufs-table" style="margin-top: 10px;">
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
                            <th>{{ @$nicufs1->tm1 }}</th>
                            <th>{{ @$nicufs1->mlh1 }}</th>
                            <th>{{ @$nicufs1->mlkg1 }}</th>
                            <td rowspan="4" style="text-align: left">B - Bottle <br>
                                BR - Breast <br>
                                CF - Continuous Feed <br>
                                NG - Nasogastric <br>
                                OG - Orogastric <br>
                                GT - Gastrostomy Tube <br>
                                NNS - Non-nutritive Sucking </td>
                            <td rowspan="4" style="text-align: left; vertical-align: top;">
                                SM - Small <br>
                                MO - Moderate <br>
                                L - Large
                            </td>
                            <td rowspan="4" style="text-align: left; vertical-align: top;">
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
                            <td rowspan="4" style="text-align: left; vertical-align: top;">
                                SD - Straight Drainage
                                SL - Suction Low
                                <hr>
                                DATE OF LAST STOOL:
                                {{ @$nicufs1->dols }}

                            </td>
                            <td rowspan="4" style="text-align: left; vertical-align: top;">
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
                            <td>{{ @$nicufs1->bp_time1 }}</td>
                            <td>{{ @$nicufs1->bp_blood1 }}</td>
                            <td>{{ @$nicufs1->bp_prbc1 }}</td>
                            <td>{{ @$nicufs1->bp_plt1 }}</td>
                            <td>{{ @$nicufs1->bp_ffp1 }}</td>
                            <td>{{ @$nicufs1->bp_other1 }}</td>
                            <td>{{ @$nicufs1->bp_total1 }}</td>
                            <td>{{ @$nicufs1->intake }}</td>
                            <td>{{ @$nicufs1->output }}</td>
                            <td>{{ @$nicufs1->diff }}</td>
                            <td>{{ @$nicufs1->tm2 }}</td>
                            <td>{{ @$nicufs1->mlh2 }}</td>
                            <td>{{ @$nicufs1->mlkg2 }}</td>

                        </tr>

                        <tr>
                            <td>{{ @$nicufs1->bp_time2 }}</td>
                            <td>{{ @$nicufs1->bp_blood2 }}</td>
                            <td>{{ @$nicufs1->bp_prbc2 }}</td>
                            <td>{{ @$nicufs1->bp_plt2 }}</td>
                            <td>{{ @$nicufs1->bp_ffp2 }}</td>
                            <td>{{ @$nicufs1->bp_other2 }}</td>
                            <td>{{ @$nicufs1->bp_total2 }}</td>
                            <td><b>IV CHECK:</b></td>
                            <td colspan="2">{{ @$nicufs1->iv_check }}</td>
                            <td>{{ @$nicufs1->tm3 }}</td>
                            <td>{{ @$nicufs1->mlh3 }}</td>
                            <td>{{ @$nicufs1->mlkg3 }}</td>

                        </tr>

                        <tr>
                            <td>{{ @$nicufs1->bp_time3 }}</td>
                            <td>{{ @$nicufs1->bp_blood3 }}</td>
                            <td>{{ @$nicufs1->bp_prbc3 }}</td>
                            <td>{{ @$nicufs1->bp_plt3 }}</td>
                            <td>{{ @$nicufs1->bp_ffp3 }}</td>
                            <td>{{ @$nicufs1->bp_other3 }}</td>
                            <td>{{ @$nicufs1->bp_total3 }}</td>
                            <td colspan="3">P - Puffy &nbsp; B - Blocked &nbsp; R - Removed &nbsp; A - Acceptable
                            </td>
                            <td>TODAY'S WEIGHT:<br>{{ @$nicufs1->today_wt }}</td>
                            <td colspan="2">GAIN/LOSS:<br>{{ @$nicufs1->loss }}</td>


                        </tr>
                    </table>
                    <table class="nicufs-table" style="margin-top: 10px;">
                        
                        <th colspan="8">LINES AND TUBING</th>
            </tr>
            <tr>
                <th>LINE / TUBE</th>
                <th>DATE OF INSERTION</th>
                <th>SIZE</th>
                <th>SITE</th>
                <th>LENGTH</th>
                <th>DAYS IN USE</th>
                <th>DATE OF REMOVAL</th>
                <th>DATE OF CHANGE</th>
            </tr>

            @foreach ([['E.T. TUBE', ''], ['UVC/UAC', '2'], ['PICC LINE', '3'], ['ARTERIAL LINE', '4'], ['URINARY CATHETER', '5'], ['VENTILATOR TUBING', '6'], ['HUMIDIFIER', '7']] as [$label, $num])
                <tr>
                    <td><b>{{ $label }}</b></td>
                    <td>{{ @$nicufs1->{'dt_insert' . $num} }}</td>
                    <td>{{ @$nicufs1->{'size' . $num} }}</td>
                    <td>{{ @$nicufs1->{'site' . $num} }}</td>
                    <td>{{ @$nicufs1->{'length' . $num} }}</td>
                    <td>{{ @$nicufs1->{'day_use' . $num} }}</td>
                    <td>{{ @$nicufs1->{'dt_remove' . $num} }}</td>
                    <td>{{ @$nicufs1->{'dt_change' . $num} }}</td>
                </tr>
            @endforeach
    </table>
    <table class="nicufs-table" style="margin-top: 10px;">

        <tr>
            <th rowspan="4">TIME</th>
            <th rowspan="4" class="rotate-text">IV CHECK</th>
            <th rowspan="4" class="rotate-text">IV FLUSHES</th>
            <th colspan="10">INTAKE</th>
            <th colspan="5">ORAL INTAKE</th>
        </tr>
        <tr>

            <th colspan="2">SITE</th>
            <th colspan="2">SITE</th>
            <th colspan="2">SITE</th>
            <th colspan="2">SITE</th>
            <th colspan="2">SITE</th>
            <th rowspan="3">ROUTE</th>
            <th rowspan="3">TYPE</th>
            <th rowspan="3" class="rotate-text">RESIDUAL</th>
            <th rowspan="3" class="rotate-text">VALUME</th>
            <th rowspan="3" class="rotate-text">CUM TOTAL</th>



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

        @foreach ($times as $t)
            <tr>
                <td>{{ strtoupper($t) }}</td>

                <td>{{ @$nicufs2->{'iv_' . $t} }}</td>
                <td>{{ @$nicufs2->{'flushes_' . $t} }}</td>
                <td>{{ @$nicufs2->{'hour1_' . $t} }}</td>
                <td>{{ @$nicufs2->{'tl1_' . $t} }}</td>
                <td>{{ @$nicufs2->{'hour2_' . $t} }}</td>
                <td>{{ @$nicufs2->{'tl2_' . $t} }}</td>
                <td>{{ @$nicufs2->{'hour3_' . $t} }}</td>
                <td>{{ @$nicufs2->{'tl3_' . $t} }}</td>
                <td>{{ @$nicufs2->{'hour4_' . $t} }}</td>
                <td>{{ @$nicufs2->{'tl4_' . $t} }}</td>
                <td>{{ @$nicufs2->{'hour5_' . $t} }}</td>
                <td>{{ @$nicufs2->{'tl5_' . $t} }}</td>
                <td>{{ @$nicufs2->{'oi_route_' . $t} }}</td>
                <td>{{ @$nicufs2->{'oi_type_' . $t} }}</td>
                <td>{{ @$nicufs2->{'oi_res_' . $t} }}</td>
                <td>{{ @$nicufs2->{'oi_vol_' . $t} }}</td>
                <td>{{ @$nicufs2->{'oi_cum_' . $t} }}</td>

            </tr>
        @endforeach

    </table>
    <table class="nicufs-table" style="margin-top: 10px;">
        <tr>
            <th rowspan="4" class="rotate-text">TIME</th>
            <th colspan="15">OUTPUT</th>
            <th colspan="9">SPECIAL CARE</th>

        </tr>
        <tr>

            <th colspan="3">URINE</th>
            <th>STOOL</th>
            <th colspan="5">GASTRIC DRAINAGE</th>
            <th colspan="6">CHEST TUBE</th>
            <th rowspan="3" class="rotate-text">ABDOMINAL GIRTH</th>
            <th rowspan="3" class="rotate-text">E.T. SUCTION</th>
            <th rowspan="3" class="rotate-text">POSITION</th>
            <th rowspan="3" class="rotate-text">CHEST PHYSIO</th>
            <th rowspan="3" class="rotate-text">NEBULIZATION</th>
            <th rowspan="3" class="rotate-text">EYE CARE</th>
            <th rowspan="3" class="rotate-text">CORD CARE</th>
            <th rowspan="3" class="rotate-text">CATHETER CARE</th>
            <th rowspan="3" class="rotate-text">OGT CARE</th>



        </tr>
        <tr>
            <th rowspan="2" class="rotate-text">VALUME</th>
            <th rowspan="2" class="rotate-text">CUM TOTAL</th>
            <th rowspan="2" class="rotate-text">ML/KG/h</th>
            <th rowspan="2" class="rotate-text">AMOUNT/TYPE</th>
            <th rowspan="2" class="rotate-text">
                REGURGITATE/VOMIT</th>
            <th colspan="4">SX: {{ @$nicufs1->sx }}
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
        @foreach ($times as $t)
            <tr>
                <td>{{ strtoupper($t) }}</td>

                <td>{{ @$nicufs2->{'ou_vol_' . $t} }}</td>
                <td>{{ @$nicufs2->{'ou_cum_' . $t} }}</td>
                <td>{{ @$nicufs2->{'ou_ml_' . $t} }}</td>
                <td>{{ @$nicufs2->{'o_stool_' . $t} }}</td>

                <td>{{ @$nicufs3->{'ogd_vomit_' . $t} }}</td>
                <td>{{ @$nicufs3->{'ogd_in_' . $t} }}</td>
                <td>{{ @$nicufs3->{'ogd_return_' . $t} }}</td>
                <td>{{ @$nicufs3->{'ogd_hvol_' . $t} }}</td>
                <td>{{ @$nicufs3->{'ogd_cum_' . $t} }}</td>

                <td>{{ @$nicufs3->{'oct_h1_' . $t} }}</td>
                <td>{{ @$nicufs3->{'oct_cum1_' . $t} }}</td>
                <td>{{ @$nicufs3->{'oct_h2_' . $t} }}</td>
                <td>{{ @$nicufs3->{'oct_cum2_' . $t} }}</td>
                <td>{{ @$nicufs3->{'oct_h3_' . $t} }}</td>
                <td>{{ @$nicufs3->{'oct_cum3_' . $t} }}</td>

                <td>{{ @$nicufs3->{'girth_' . $t} }}</td>
                <td>{{ @$nicufs3->{'suction_' . $t} }}</td>
                <td>{{ @$nicufs3->{'position_' . $t} }}</td>
                <td>{{ @$nicufs3->{'chest_' . $t} }}</td>
                <td>{{ @$nicufs3->{'nebuliza_' . $t} }}</td>
                <td>{{ @$nicufs3->{'eyecare_' . $t} }}</td>
                <td>{{ @$nicufs3->{'cordcare_' . $t} }}</td>
                <td>{{ @$nicufs3->{'catheter_' . $t} }}</td>
                <td>{{ @$nicufs3->{'mouthcare_' . $t} }}</td>
            </tr>
        @endforeach


    </table>
    <table class="nicufs-table" style="margin-top: 10px;">
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
            <td rowspan="2">{{ @$nicufs1->m_staff }}

            </td>
            <td rowspan="2">{{ @$nicufs1->m_empid }}
            </td>
            <td rowspan="2">{{ @$nicufs1->m_sign }}
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
            <td rowspan="2">{{ @$nicufs1->e_staff }}</td>
            <td rowspan="2">{{ @$nicufs1->e_empid }}
            </td>
            <td rowspan="2">{{ @$nicufs1->e_sign }}
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
            <td rowspan="2">{{ @$nicufs1->n_staff }}</td>
            <td rowspan="2">{{ @$nicufs1->n_empid }}
            </td>
            <td rowspan="2">{{ @$nicufs1->n_sign }}
            </td>
        </tr>

    </table>


    </td>
    </tr>
    </tbody>
    </table>


    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%"><strong>Staff ID:</strong>
                        {{ @$userInfo->user_code }}, <strong>Printing Date & Time:</strong>
                        {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%"><strong>Powered By: NEXTGEN
                            IT</strong></td>
                </tr>
            </tbody>
        </table>
    </section>
    </td>
    </tr>
    </tbody>
    </table>
</body>

</html>
