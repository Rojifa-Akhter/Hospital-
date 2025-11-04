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

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 15px;
            border: 1px solid #333;
            padding-right: 3px;
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

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            position: bottom;
            bottom: 0px;
            width: 95%;

            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
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
                        <span style="font-size: 16px;"><b>NEONATAL CLINICAL RECORD</b></span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date & Time of Birth</th>
                                <td>{{ $pt_record->dtb ?? '' }}</td>
                                <th>Gestational age</th>
                                <td>{{ $pt_record->gestational ?? '' }}</td>
                                <th>By</th>
                                <td>
                                    @if (@$pt_record->age_by == '1')
                                        Dates
                                    @elseif(@$pt_record->age_by == '2')
                                        Ultrasound
                                    @elseif(@$pt_record->age_by == '3')
                                        Fundal Height
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Plurality</th>
                                <td>
                                    @if (@$pt_record->plurality == '1')
                                        Singleton
                                    @elseif(@$pt_record->plurality == '2')
                                        Twin
                                    @elseif(@$pt_record->plurality == '3')
                                        Triplet
                                    @elseif(@$pt_record->plurality == '4')
                                        Quad
                                    @endif
                                </td>
                                <th>Birth Order</th>
                                <td>
                                    @if (@$pt_record->birth_order == '1')
                                        1
                                    @elseif(@$pt_record->birth_order == '2')
                                        2
                                    @elseif(@$pt_record->birth_order == '3')
                                        3
                                    @elseif(@$pt_record->birth_order == '4')
                                        4
                                    @endif
                                </td>
                                <th>SEX</th>
                                <td>
                                    @if (@$pt_record->sex == '1')
                                        Male
                                    @elseif(@$pt_record->sex == '2')
                                        Female
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Weight(gm)</th>
                                <td>{{ $pt_record->wt ?? '' }}</td>
                                <th>Length(cm)</th>
                                <td>{{ $pt_record->wtl ?? '' }}</td>
                                <th>Head circumference(cm)</th>
                                <td>{{ $pt_record->wt_hc ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Type Of Delivery</th>
                                <td colspan="5">
                                    @if (@$pt_record->tod == '1')
                                        Unsupervised
                                    @elseif(@$pt_record->tod == '2')
                                        Normal
                                    @elseif(@$pt_record->tod == '3')
                                        Forceps
                                    @elseif(@$pt_record->tod == '4')
                                        Rotational forceps
                                    @elseif(@$pt_record->tod == '5')
                                        Ventouse
                                    @elseif(@$pt_record->tod == '6')
                                        Assisted breech
                                    @elseif(@$pt_record->tod == '7')
                                        LSCS, elective
                                    @elseif(@$pt_record->tod == '8')
                                        LSCS, emerg, not in labour
                                    @elseif(@$pt_record->tod == '9')
                                        LSCS, emerg, in labour
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th>Agar Score</th>
                                <th>0</th>
                                <th>1'</th>
                                <th>5'</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Respiration</th>
                                <td>{{ $pt_record->res1 ?? '' }}</td>
                                <td>{{ $pt_record->res2 ?? '' }}</td>
                                <td>{{ $pt_record->res3 ?? '' }}</td>
                                <td>{{ $pt_record->res4 ?? '' }}</td>
                                <td>{{ $pt_record->res5 ?? '' }}</td>
                                <td>{{ $pt_record->res6 ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Colour</th>
                                <td>{{ $pt_record->color1 ?? '' }}</td>
                                <td>{{ $pt_record->color2 ?? '' }}</td>
                                <td>{{ $pt_record->color3 ?? '' }}</td>
                                <td>{{ $pt_record->color4 ?? '' }}</td>
                                <td>{{ $pt_record->color5 ?? '' }}</td>
                                <td>{{ $pt_record->color6 ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Heart rate</th>
                                <td>{{ $pt_record->rate1 ?? '' }}</td>
                                <td>{{ $pt_record->rate2 ?? '' }}</td>
                                <td>{{ $pt_record->rate3 ?? '' }}</td>
                                <td>{{ $pt_record->rate4 ?? '' }}</td>
                                <td>{{ $pt_record->rate5 ?? '' }}</td>
                                <td>{{ $pt_record->rate6 ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Tone</th>
                                <td>{{ $pt_record->tone1 ?? '' }}</td>
                                <td>{{ $pt_record->tone2 ?? '' }}</td>
                                <td>{{ $pt_record->tone3 ?? '' }}</td>
                                <td>{{ $pt_record->tone4 ?? '' }}</td>
                                <td>{{ $pt_record->tone5 ?? '' }}</td>
                                <td>{{ $pt_record->tone6 ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Reflex</th>
                                <td>{{ $pt_record->reflex1 ?? '' }}</td>
                                <td>{{ $pt_record->reflex2 ?? '' }}</td>
                                <td>{{ $pt_record->reflex3 ?? '' }}</td>
                                <td>{{ $pt_record->reflex4 ?? '' }}</td>
                                <td>{{ $pt_record->reflex5 ?? '' }}</td>
                                <td>{{ $pt_record->reflex6 ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $pt_record->total1 ?? '' }}</td>
                                <td>{{ $pt_record->total2 ?? '' }}</td>
                                <td>{{ $pt_record->total3 ?? '' }}</td>
                                <td>{{ $pt_record->total4 ?? '' }}</td>
                                <td>{{ $pt_record->total5 ?? '' }}</td>
                                <td>{{ $pt_record->total6 ?? '' }}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="6" style="text-align: left">MOTHER'S</th>
                            </tr>
                            <tr>
                                <th>VDRL</th>
                                <td>{{ $pt_record->vdrl ?? '' }}</td>
                                <th>Hep B</th>
                                <td>{{ $pt_record->hepb ?? '' }}</td>
                                <th>Blood Group</th>
                                <td>{{ $pt_record->bg ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Resuscitation</th>
                                <td>
                                    @if (@$pt_record->resuscitation == '1')
                                        None
                                    @elseif(@$pt_record->resuscitation == '2')
                                        Stimulation
                                    @elseif(@$pt_record->resuscitation == '3')
                                        Oxygen
                                    @elseif(@$pt_record->resuscitation == '4')
                                        Mask ventilation
                                    @elseif(@$pt_record->resuscitation == '5')
                                        ETT ventilation
                                    @endif
                                </td>
                                <th>Drugs</th>
                                <td>
                                    @if (@$pt_record->drugs == '1')
                                        Vit K. 1 mg
                                    @elseif(@$pt_record->drugs == '2')
                                        Naloxone 0.1 mg/kg
                                    @endif
                                </td>
                                <th>History in siblings of</th>
                                <td>
                                    @if (@$pt_record->hiso == '1')
                                        Preterm/LBW
                                    @elseif(@$pt_record->hiso == '2')
                                        Infant death
                                    @elseif(@$pt_record->hiso == '3')
                                        Developmental delay
                                    @elseif(@$pt_record->hiso == '4')
                                        Cong. abnor
                                    @elseif(@$pt_record->hiso == '5')
                                        GSPD deficiency
                                    @elseif(@$pt_record->hiso == '6')
                                        Jaundice needing phototherapy
                                    @elseif(@$pt_record->hiso == '7')
                                        Inheritable or communicable disease
                                    @elseif(@$pt_record->hiso == '8')
                                        Stillbirth
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Any siblings</th>
                                <td>
                                    @if (@$pt_record->sibling == '1')
                                        Yes
                                    @elseif(@$pt_record->sibling == '2')
                                        No
                                    @endif
                                </td>
                                <th>Vaccination of birth</th>
                                <td>
                                    Hepatitis B-
                                    @if (@$pt_record->hb == '1')
                                        Yes
                                    @elseif(@$pt_record->hb == '2')
                                        No
                                    @endif
                                </td>
                                <td>
                                    BCG-
                                    @if (@$pt_record->bcg == '1')
                                        Yes
                                    @elseif(@$pt_record->bcg == '2')
                                        No
                                    @endif
                                </td>
                                <td>
                                    Oral Polio-
                                    @if (@$pt_record->op == '1')
                                        Yes
                                    @elseif(@$pt_record->op == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">DELIVERY SUITE OBSERVATION CHART FOR NEONATES</th>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: left">The following observations are to be made on
                                    all babies trust stay in the delivery suite</td>
                            </tr>
                            <tr>
                                <td style="text-align: left">Age: {{ $pt_record->baby_age ?? '' }}</td>
                                <td style="text-align: left">Time: {{ $pt_record->baby_time ?? '' }}</td>
                                <td colspan="4">
                                    @php
                                        $drugs_list = !empty($pt_record->thirtymin)
                                            ? json_decode($pt_record->thirtymin, true)
                                            : [];
                                        $onehr = !empty($pt_record->onehr) ? json_decode($pt_record->onehr, true) : [];
                                        $onehr30min = !empty($pt_record->onehr30min)
                                            ? json_decode($pt_record->onehr30min, true)
                                            : [];
                                        $twohr = !empty($pt_record->twohr) ? json_decode($pt_record->twohr, true) : [];
                                    @endphp

                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>30 min</th>
                                            <th>1 hr</th>
                                            <th>1 hr 30 min</th>
                                            <th>2 hrs</th>
                                        </tr>
                                        <tbody>
                                            @if (!empty($drugs_list))
                                                @foreach ($drugs_list as $i => $d)
                                                    <tr>
                                                        <td>{{ $d }}</td>
                                                        <td>{{ $onehr[$i] ?? '' }}</td>
                                                        <td>{{ $onehr30min[$i] ?? '' }}</td>
                                                        <td>{{ $twohr[$i] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No observation data recorded</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="2" style="text-align: left">
                                    Extremity colour (pink, blue or pale) <br>
                                    Lip colour (Pink, blue or pale) <br>
                                    Grunting (present or absent) <br>
                                    Retractions (present or absent) <br>
                                    Response to tactile stimulation <br>
                                    (no response / grimace / cry) <br>
                                    Respiratory rate (breaths/min) <br>
                                    Rectal temperature (°C) at 30 min and 2 hrs <br>
                                    (1/2 hourly if temperature &lt;36.5°C) Activity (active, passive,flat) Time of
                                    cleaning <br>
                                    Please inform the paediatrician if: (1) extremities are pale <br>
                                    (2) lips are blue <br>
                                    (3) respiratory rate > 60/minute <br>
                                    (4) grunting is present <br>
                                    (5) retractions are seen <br>
                                    (6) cry is weak and <br>
                                    (7) rectal temperature is &lt;36.0°C
                                </td>
                                <th colspan="4">BREAST INITIATION</th>
                            </tr>
                            @php
                                $breast = json_decode($pt_record->breast ?? '[]', true) ?? [];
                            @endphp
                            <tr>
                                <td style="text-align: left">{{ in_array('1', $breast) ? '✓' : '☐' }} Yes</td>
                                <td style="text-align: left">
                                    Time {{ $pt_record->breast_time ?? '' }}<br>
                                    Duration {{ $pt_record->breast_duration ?? '' }}
                                </td>
                                <td style="text-align: left">{{ in_array('2', $breast) ? '✓' : '☐' }} No</td>
                                <td style="text-align: left">
                                    Reasons {{ $pt_record->b_reason ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">MOTHER</th>
                            </tr>
                            <tr>
                                <th>Marital Status</th>
                                <td colspan="2">
                                    @if (@$pt_record->m_ms == '1')
                                        Married
                                    @elseif(@$pt_record->m_ms == '2')
                                        Single
                                    @elseif(@$pt_record->m_ms == '3')
                                        Defacto
                                    @endif
                                </td>
                                <th>Consanguinity</th>
                                <td colspan="2">
                                    @if (@$pt_record->m_consanguinity == '1')
                                        Yes
                                    @elseif(@$pt_record->m_consanguinity == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nationality</th>
                                <td>{{ $pt_record->m_nation ?? '' }}</td>
                                <th>Age</th>
                                <td>{{ $pt_record->m_age ?? '' }}</td>
                                <th>Occupation</th>
                                <td>{{ $pt_record->m_occupation ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: left">PRESENT PREGNANCY</th>
                            </tr>
                            <tr>
                                <th>Parity</th>
                                <td>{{ $pt_record->m_parity ?? '' }}</td>
                                <th>Gravidity</th>
                                <td>{{ $pt_record->m_gravidity ?? '' }}</td>
                                <th>L.M.P.</th>
                                <td>{{ $pt_record->m_lmp ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>E.D.D.</th>
                                <td>{{ $pt_record->m_edd ?? '' }}</td>
                                <th>Dates</th>
                                <td>
                                    @if (@$pt_record->m_dates == '1')
                                        Certain
                                    @elseif(@$pt_record->m_dates == '2')
                                        Uncertain
                                    @endif
                                </td>
                                <th>Mode of ovulation</th>
                                <td>
                                    @if (@$pt_record->m_moo == '1')
                                        Spontaneous
                                    @elseif(@$pt_record->m_moo == '2')
                                        Induced
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mode of fertilization</th>
                                <td>
                                    @if (@$pt_record->m_mode == '1')
                                        Spontaneous
                                    @elseif(@$pt_record->m_mode == '2')
                                        IVF
                                    @elseif(@$pt_record->m_mode == '3')
                                        GIFT
                                    @elseif(@$pt_record->m_mode == '4')
                                        TET
                                    @elseif(@$pt_record->m_mode == '5')
                                        MIST
                                    @endif
                                </td>
                                <th>Antenatal Care</th>
                                <td>
                                    @if (@$pt_record->m_care == '1')
                                        Yes
                                    @elseif(@$pt_record->m_care == '2')
                                        No
                                    @endif
                                </td>
                                <th>Book of EHD</th>
                                <td>
                                    @if (@$pt_record->m_book == '1')
                                        Yes
                                    @elseif(@$pt_record->m_book == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Analgesia in labour</th>
                                <td>
                                    @if (@$pt_record->m_labour == '1')
                                        None
                                    @elseif(@$pt_record->m_labour == '2')
                                        Narcotics
                                    @elseif(@$pt_record->m_labour == '3')
                                        Regional
                                    @elseif(@$pt_record->m_labour == '4')
                                        Combination
                                    @endif
                                </td>
                                <th>Birth attendant</th>
                                <td>
                                    @if (@$pt_record->m_birth == '1')
                                        None
                                    @elseif(@$pt_record->m_birth == '2')
                                        Consultant
                                    @elseif(@$pt_record->m_birth == '3')
                                        Registrar
                                    @elseif(@$pt_record->m_birth == '4')
                                        Trained midwives
                                    @elseif(@$pt_record->m_birth == '5')
                                        Ambulance Nurse
                                    @elseif(@$pt_record->m_birth == '6')
                                        Layman
                                    @endif
                                </td>
                                <th>Presentation at delivery</th>
                                <td>
                                    @if (@$pt_record->m_delivry == '1')
                                        Not known
                                    @elseif(@$pt_record->m_delivry == '2')
                                        Vertex
                                    @elseif(@$pt_record->m_delivry == '3')
                                        Breech
                                    @elseif(@$pt_record->m_delivry == '4')
                                        Face
                                    @elseif(@$pt_record->m_delivry == '5')
                                        Shoulder
                                    @elseif(@$pt_record->m_delivry == '6')
                                        Brow
                                    @elseif(@$pt_record->m_delivry == '7')
                                        Compound
                                    @elseif(@$pt_record->m_delivry == '8')
                                        Cord
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Reason for assisted delivery:</th>
                                <td>
                                    @if (@$pt_record->m_rfad == '1')
                                        Fetal distress
                                    @elseif(@$pt_record->m_rfad == '2')
                                        Failure to progress
                                    @elseif(@$pt_record->m_rfad == '3')
                                        Cord complication
                                    @elseif(@$pt_record->m_rfad == '4')
                                        Malposition
                                    @elseif(@$pt_record->m_rfad == '5')
                                        C.P.D.
                                    @elseif(@$pt_record->m_rfad == '6')
                                        Prolonged 2nd stage
                                    @elseif(@$pt_record->m_rfad == '7')
                                        Maternal distress
                                    @elseif(@$pt_record->m_rfad == '8')
                                        Previous LSCS
                                    @endif
                                </td>
                                <th>Place of birth</th>
                                <td>
                                    @if (@$pt_record->m_pbirth == '1')
                                        Inborn Labour ward
                                    @elseif(@$pt_record->m_pbirth == '2')
                                        Outborn Hospital
                                    @elseif(@$pt_record->m_pbirth == '3')
                                        Outborn Nursing home
                                    @elseif(@$pt_record->m_pbirth == '4')
                                        Home, car, etc
                                    @endif
                                </td>
                                <th>Meconium from trachea</th>
                                <td>
                                    @if (@$pt_record->m_mft == '1')
                                        Yes
                                    @elseif(@$pt_record->m_mft == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>Antenatal U/S Findings</b></td>
                                <td colspan="5">{{ @$pt_record->antenatal }}</td>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: left">PAST OBSTETRIC HISTORY</th>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @php
                                        $preg_list = !empty($pt_record->preg)
                                            ? json_decode($pt_record->preg, true)
                                            : [];
                                        $m_sex = !empty($pt_record->m_sex) ? json_decode($pt_record->m_sex, true) : [];
                                        $gest = !empty($pt_record->gest) ? json_decode($pt_record->gest, true) : [];
                                        $birth_wt = !empty($pt_record->birth_wt)
                                            ? json_decode($pt_record->birth_wt, true)
                                            : [];
                                        $delivery = !empty($pt_record->delivery)
                                            ? json_decode($pt_record->delivery, true)
                                            : [];
                                        $complication = !empty($pt_record->complication)
                                            ? json_decode($pt_record->complication, true)
                                            : [];
                                        $outcome = !empty($pt_record->outcome)
                                            ? json_decode($pt_record->outcome, true)
                                            : [];
                                    @endphp

                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>Preg. Order</th>
                                            <th>Sex</th>
                                            <th>Gest</th>
                                            <th>Birth wt.</th>
                                            <th>Mode of delivery</th>
                                            <th>Complication</th>
                                            <th>Outcome</th>
                                        </tr>
                                        <tbody>
                                            @if (!empty($preg_list))
                                                @foreach ($preg_list as $i => $d)
                                                    <tr>
                                                        <td>{{ $d }}</td>
                                                        <td>{{ $m_sex[$i] ?? '' }}</td>
                                                        <td>{{ $gest[$i] ?? '' }}</td>
                                                        <td>{{ $birth_wt[$i] ?? '' }}</td>
                                                        <td>{{ $delivery[$i] ?? '' }}</td>
                                                        <td>{{ $complication[$i] ?? '' }}</td>
                                                        <td>{{ $outcome[$i] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7">No past obstetric history recorded</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">FATHER</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $pt_record->f_name ?? '' }}</td>
                                <th>Age</th>
                                <td>{{ $pt_record->f_age ?? '' }}</td>
                                <th>Occupation</th>
                                <td>{{ $pt_record->f_occupation ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Age in Completed years</th>
                                <td colspan="2">{{ $pt_record->f_age_completed ?? '' }}</td>
                                <th>Religion</th>
                                <td colspan="2">
                                    @if (@$pt_record->f_religion == '1')
                                        Muslim
                                    @elseif(@$pt_record->f_religion == '2')
                                        Hindu
                                    @elseif(@$pt_record->f_religion == '3')
                                        Christian
                                    @elseif(@$pt_record->f_religion == '4')
                                        Others
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">MEDICAL COMPLICATIONS</th>
                                <td colspan="2">
                                    @if (@$pt_record->medc == '1')
                                        Yes
                                    @elseif(@$pt_record->medc == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: left">Tick ✓ those present and describe details in
                                    below</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @php
                                        $mc = json_decode($pt_record->mc ?? '[]', true) ?? [];
                                    @endphp
                                    <table class="table table-bordered align-middle text-start" style="width:100%;">
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('1', $mc) ? '✓' : '☐' }} Anaemia
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('2', $mc) ? '✓' : '☐' }} Epilepsy
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('3', $mc) ? '✓' : '☐' }} S.L.E
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('4', $mc) ? '✓' : '☐' }} Asthma
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('5', $mc) ? '✓' : '☐' }} Febrile exanthem
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('6', $mc) ? '✓' : '☐' }} Thyrotoxicosis
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('7', $mc) ? '✓' : '☐' }} Acute R.T.I.
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('8', $mc) ? '✓' : '☐' }} Heart disease
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('9', $mc) ? '✓' : '☐' }} α Thalasaemia
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('10', $mc) ? '✓' : '☐' }} Bacteriuria
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('11', $mc) ? '✓' : '☐' }} Hepatitis
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('12', $mc) ? '✓' : '☐' }} β Thalasaemia
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('13', $mc) ? '✓' : '☐' }} Chronic renal disease
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('14', $mc) ? '✓' : '☐' }} Hypertension
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('15', $mc) ? '✓' : '☐' }} Venereal disease
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('16', $mc) ? '✓' : '☐' }} Diabetes
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('17', $mc) ? '✓' : '☐' }} Obesity
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('18', $mc) ? '✓' : '☐' }} Others
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('19', $mc) ? '✓' : '☐' }} Drugs
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('20', $mc) ? '✓' : '☐' }} Schizophrenia
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">OBSTETRIC COMPLICATIONS</th>
                                <td colspan="2">
                                    @if (@$pt_record->obstetric == '1')
                                        Yes
                                    @elseif(@$pt_record->obstetric == '2')
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: left">Tick ✓ those present and describe details in
                                    below</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @php
                                        $oc = json_decode($pt_record->oc ?? '[]', true) ?? [];
                                    @endphp
                                    <table class="table table-bordered align-middle text-start" style="width:100%;">
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('1', $oc) ? '✓' : '☐' }} Abruptio
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('2', $oc) ? '✓' : '☐' }} Cord prolapse
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('3', $oc) ? '✓' : '☐' }} Oligohydramnios
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('4', $oc) ? '✓' : '☐' }} CPD
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('5', $oc) ? '✓' : '☐' }} Premature R.O.M.
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('6', $oc) ? '✓' : '☐' }} Antepartum fetal distress
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('7', $oc) ? '✓' : '☐' }} Growth retardation
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('8', $oc) ? '✓' : '☐' }} Placenta Previa
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('9', $oc) ? '✓' : '☐' }} Placental infarction
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('10', $oc) ? '✓' : '☐' }} Prolonged 2nd stage
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('11', $oc) ? '✓' : '☐' }} Bleeding < 20 weeks </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('12', $oc) ? '✓' : '☐' }} Hyperemesis
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('13', $oc) ? '✓' : '☐' }} Polyhydramnios
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('14', $oc) ? '✓' : '☐' }} Shoulder dystocia
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('15', $oc) ? '✓' : '☐' }} Slow R.O.M.
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('16', $oc) ? '✓' : '☐' }} Bleeding >20 weeks
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('17', $oc) ? '✓' : '☐' }} Cord presentation
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('18', $oc) ? '✓' : '☐' }} Multiple pregnancy
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('19', $oc) ? '✓' : '☐' }} Premature labour
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('20', $oc) ? '✓' : '☐' }} Spurious labour
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {{ in_array('21', $oc) ? '✓' : '☐' }} Breech presentation
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                            <td style="vertical-align: middle; text-align: left;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Addictions</th>
                                <td>
                                    @if (@$pt_record->addiction == '1')
                                        No
                                    @elseif(@$pt_record->addiction == '2')
                                        Smoking
                                    @elseif(@$pt_record->addiction == '3')
                                        Alcohol
                                    @elseif(@$pt_record->addiction == '4')
                                        Narcotics
                                    @endif
                                </td>
                                <th>LABOUR</th>
                                <td>
                                    @if (@$pt_record->labour == '1')
                                        Spontaneous
                                    @elseif(@$pt_record->labour == '2')
                                        Induced
                                    @elseif(@$pt_record->labour == '3')
                                        Augmented
                                    @elseif(@$pt_record->labour == '4')
                                        Tocolytics
                                    @endif
                                </td>
                                <th>Observed duration to the nearest hour</th>
                                <td>{{ $pt_record->odttnh ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="2">Duration of ruptured membranes (hrs)</th>
                                <td colspan="4">{{ $pt_record->dorm ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Colour of liquor</th>
                                <td>
                                    @if (@$pt_record->liquor_color == '1')
                                        Clear
                                    @elseif(@$pt_record->liquor_color == '2')
                                        LMSL
                                    @elseif(@$pt_record->liquor_color == '3')
                                        MMSL
                                    @elseif(@$pt_record->liquor_color == '4')
                                        TMSL
                                    @elseif(@$pt_record->liquor_color == '5')
                                        Bld stained
                                    @elseif(@$pt_record->liquor_color == '6')
                                        Fou
                                    @endif
                                </td>
                                <th>Fetal distress</th>
                                <td>
                                    @if (@$pt_record->fetal_distress == '1')
                                        None
                                    @elseif(@$pt_record->fetal_distress == '2')
                                        Meconium stained
                                    @elseif(@$pt_record->fetal_distress == '3')
                                        Suspicious CTG
                                    @elseif(@$pt_record->fetal_distress == '4')
                                        Abnormal CTG
                                    @endif
                                </td>
                                <th>Drugs in labour</th>
                                <td>
                                    @if (@$pt_record->drugs_labour == '1')
                                        Spontaneous
                                    @elseif(@$pt_record->drugs_labour == '2')
                                        Induced
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @php
                                        $oct_list = !empty($pt_record->oct_date)
                                            ? json_decode($pt_record->oct_date, true)
                                            : [];
                                        $oct_time = !empty($pt_record->oct_time)
                                            ? json_decode($pt_record->oct_time, true)
                                            : [];
                                        $oct_age = !empty($pt_record->oct_age)
                                            ? json_decode($pt_record->oct_age, true)
                                            : [];
                                        $brief = !empty($pt_record->brief) ? json_decode($pt_record->brief, true) : [];
                                    @endphp
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Age</th>
                                            <th>Brief summary of problems at birth and Management</th>
                                        </tr>
                                        <tbody>
                                            @if (!empty($oct_list))
                                                @foreach ($oct_list as $i => $m)
                                                    <tr>
                                                        <td>{{ $m }}</td>
                                                        <td>{{ $oct_time[$i] ?? '' }}</td>
                                                        <td>{{ $oct_age[$i] ?? '' }}</td>
                                                        <td>{{ $brief[$i] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No OCT data recorded</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Meconium 1st passed (date & time)</td>
                                <td>{{ $pt_record->meconium ?? '' }}</td>
                                <td></td>
                                <td>Urine 1st passed (date & time)</td>
                                <td>{{ $pt_record->urinepass ?? '' }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: left">FIRST EXAMINATION</th>
                            </tr>
                            <tr>
                                <td>Date & Time {{ $pt_record->fe_dt ?? '' }}</td>
                                <td>Name {{ $pt_record->fe_name ?? '' }}</td>
                                <td>Axillary temp.( ◦C) {{ $pt_record->fe_atemp ?? '' }}</td>
                                <td>Heart rate(/min) {{ $pt_record->fe_hrate ?? '' }}</td>
                                <td>Resp. rate {{ $pt_record->fe_rrate ?? '' }}</td>
                                <td>Bld pressure {{ $pt_record->fe_bp ?? '' }}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width:25%;">Parameter</th>
                                    <th style="width:10%;">Tick if normal</th>
                                    <th>Findings / Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>GENERAL</b></td>
                                </tr>
                                <tr>
                                    <td>Size</td>
                                    <td class="text-center">{{ @$pt_record->gen_size ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->gen_size_r }}</td>
                                </tr>
                                <tr>
                                    <td>Nutrition</td>
                                    <td class="text-center">{{ @$pt_record->gen_nutrition ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->gen_nutrition_r }}</td>
                                </tr>
                                <tr>
                                    <td>Body proportions</td>
                                    <td class="text-center">{{ @$pt_record->gen_proportion ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->gen_proportion_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>CHEST</b></td>
                                </tr>
                                <tr>
                                    <td>Respiration</td>
                                    <td class="text-center">{{ @$pt_record->ch_respiration ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ch_respiration_r }}</td>
                                </tr>
                                <tr>
                                    <td>Breath sounds</td>
                                    <td class="text-center">{{ @$pt_record->ch_breath ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ch_breath_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->ch_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ch_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>HEART</b></td>
                                </tr>
                                <tr>
                                    <td>Apex</td>
                                    <td class="text-center">{{ @$pt_record->ht_apex ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ht_apex_r }}</td>
                                </tr>
                                <tr>
                                    <td>Heart sounds</td>
                                    <td class="text-center">{{ @$pt_record->ht_sounds ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ht_sounds_r }}</td>
                                </tr>
                                <tr>
                                    <td>Femoral pulses</td>
                                    <td class="text-center">{{ @$pt_record->ht_femoral ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ht_femoral_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->ht_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->ht_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>ABDOMEN</b></td>
                                </tr>
                                <tr>
                                    <td>Umbilicus</td>
                                    <td class="text-center">{{ @$pt_record->abd_umbilicus ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_umbilicus_r }}</td>
                                </tr>
                                <tr>
                                    <td>Liver</td>
                                    <td class="text-center">{{ @$pt_record->abd_liver ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_liver_r }}</td>
                                </tr>
                                <tr>
                                    <td>Spleen</td>
                                    <td class="text-center">{{ @$pt_record->abd_spleen ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_spleen_r }}</td>
                                </tr>
                                <tr>
                                    <td>Kidneys</td>
                                    <td class="text-center">{{ @$pt_record->abd_kidneys ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_kidneys_r }}</td>
                                </tr>
                                <tr>
                                    <td>Genitalia</td>
                                    <td class="text-center">{{ @$pt_record->abd_genitalia ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_genitalia_r }}</td>
                                </tr>
                                <tr>
                                    <td>Anus</td>
                                    <td class="text-center">{{ @$pt_record->abd_anus ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_anus_r }}</td>
                                </tr>
                                <tr>
                                    <td>Hernial orifices</td>
                                    <td class="text-center">{{ @$pt_record->abd_hernial ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_hernial_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->abd_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->abd_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>SKIN</b></td>
                                </tr>
                                <tr>
                                    <td>Colour</td>
                                    <td class="text-center">{{ @$pt_record->skin_colour ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->skin_colour_r }}</td>
                                </tr>
                                <tr>
                                    <td>Bruising</td>
                                    <td class="text-center">{{ @$pt_record->skin_bruising ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->skin_bruising_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->skin_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->skin_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>HEAD AND NECK</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Scalp</td>
                                    <td class="text-center">{{ @$pt_record->hn_scalp ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_scalp_r }}</td>
                                </tr>
                                <tr>
                                    <td>Fontanelles and sutures</td>
                                    <td class="text-center">{{ @$pt_record->hn_fontanelles ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_fontanelles_r }}</td>
                                </tr>
                                <tr>
                                    <td>Eyes</td>
                                    <td class="text-center">{{ @$pt_record->hn_eyes ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_eyes_r }}</td>
                                </tr>
                                <tr>
                                    <td>Mouth and palate</td>
                                    <td class="text-center">{{ @$pt_record->hn_mouth ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_mouth_r }}</td>
                                </tr>
                                <tr>
                                    <td>Ears</td>
                                    <td class="text-center">{{ @$pt_record->hn_ears ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_ears_r }}</td>
                                </tr>
                                <tr>
                                    <td>Sternomastoids</td>
                                    <td class="text-center">{{ @$pt_record->hn_sternomastoids ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_sternomastoids_r }}</td>
                                </tr>
                                <tr>
                                    <td>Clavicles</td>
                                    <td class="text-center">{{ @$pt_record->hn_clavicles ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_clavicles_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->hn_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->hn_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>SKELETAL</b></td>
                                </tr>
                                <tr>
                                    <td>Spine</td>
                                    <td class="text-center">{{ @$pt_record->sk_spine ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->sk_spine_r }}</td>
                                </tr>
                                <tr>
                                    <td>Arms and hands</td>
                                    <td class="text-center">{{ @$pt_record->sk_arms ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->sk_arms_r }}</td>
                                </tr>
                                <tr>
                                    <td>Legs and feet</td>
                                    <td class="text-center">{{ @$pt_record->sk_legs ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->sk_legs_r }}</td>
                                </tr>
                                <tr>
                                    <td>Hips</td>
                                    <td class="text-center">{{ @$pt_record->sk_hips ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->sk_hips_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->sk_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->sk_other_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="fw-bold" style="text-align: left"><b>C.N.S.</b></td>
                                </tr>
                                <tr>
                                    <td>Posture and tone</td>
                                    <td class="text-center">{{ @$pt_record->cns_posture ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->cns_posture_r }}</td>
                                </tr>
                                <tr>
                                    <td>Movements</td>
                                    <td class="text-center">{{ @$pt_record->cns_movements ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->cns_movements_r }}</td>
                                </tr>
                                <tr>
                                    <td>Cry</td>
                                    <td class="text-center">{{ @$pt_record->cns_cry ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->cns_cry_r }}</td>
                                </tr>
                                <tr>
                                    <td>Reflexes (Specify)</td>
                                    <td class="text-center">{{ @$pt_record->cns_reflex ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->cns_reflex_r }}</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td class="text-center">{{ @$pt_record->cns_other ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->cns_other_r }}</td>
                                </tr>

                                <tr>
                                    <td style="text-align: left"><b>Estimated maturity</b></td>
                                    <td class="text-center">{{ @$pt_record->estimated_maturity ? '✓' : '' }}</td>
                                    <td>{{ @$pt_record->estimated_maturity_r }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="fw-semibold" style="text-align: left">
                                        <b>Conclusion:</b></td>
                                    <td>{{ @$pt_record->conclusion }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-semibold text-end" style="text-align: left">
                                        <b>Normal Healthy Infant</b>
                                        &nbsp;
                                        {{ @$pt_record->normal_infant ? '✓' : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-semibold" style="text-align: left"><b>If not,
                                            specify:</b></td>
                                    <td>{{ @$pt_record->not_specify }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
