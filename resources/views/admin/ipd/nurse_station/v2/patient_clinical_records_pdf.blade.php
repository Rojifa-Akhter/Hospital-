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
                        <span style="font-size: 16px;"><b>PATIENT CLINICAL RECORDS </b></span>
                    </div>

                        <table class="table table-bordered">
                            <tr>
                                <td><b>Presenting Complaints:</b></td>
                                <td>{{ @$pt_record->pc }}</td>
                            </tr>

                            <tr>
                                <td><b>History of Present Illness:</b></td>
                                <td>{{ @$pt_record->hopi }}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4">Obstetrics History:</th>
                            </tr>

                            <tr>
                                <td>Married for:</td>
                                <td>{{ $pt_record->mf ?? '' }}</td>
                                <td>Gravida:</td>
                                <td>{{ $pt_record->gravida ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>Para:</td>
                                <td>{{ $pt_record->para ?? '' }}</td>
                                <td>ALC:</td>
                                <td>{{ $pt_record->alc ?? '' }}</td>
                            </tr>

                            <tr>
                                <th colspan="4">Past Obstetrics History:</th>
                            </tr>

                            <tr>
                                <td>PIH/PE:</td>
                                <td>{{ $pt_record->pih ?? '' }}</td>
                                <td>GDM:</td>
                                <td>{{ $pt_record->gdm ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>APH:</td>
                                <td>{{ $pt_record->aph ?? '' }}</td>
                                <td>PPH:</td>
                                <td>{{ $pt_record->pph ?? '' }}</td>
                            </tr>
                        </table>

                        @php
                            $pregnancy_list = !empty($pt_record->pregnancy)
                                ? json_decode($pt_record->pregnancy, true)
                                : [];

                            $yeardate = !empty($pt_record->yeardate) ? json_decode($pt_record->yeardate, true) : [];

                            $gestation = !empty($pt_record->gestation) ? json_decode($pt_record->gestation, true) : [];
                            $induced = !empty($pt_record->induced) ? json_decode($pt_record->induced, true) : [];
                            $delivery = !empty($pt_record->delivery) ? json_decode($pt_record->delivery, true) : [];
                            $complication = !empty($pt_record->complication)
                                ? json_decode($pt_record->complication, true)
                                : [];
                            $puerperium = !empty($pt_record->puerperium)
                                ? json_decode($pt_record->puerperium, true)
                                : [];
                            $sex = !empty($pt_record->sex) ? json_decode($pt_record->sex, true) : [];
                        @endphp

                        <table class="table table-bordered text-center">
                            <tr>
                                <th>No. of Pregnancy</th>
                                <th>Year & Date</th>
                                <th>Gestation Age</th>
                                <th>Spontaneous/Induced</th>
                                <th>Mode of delivery</th>
                                <th>Complication</th>
                                <th>Puerperium</th>
                                <th>Baby wt. Sex, BF</th>
                            </tr>
                            <tbody id="vitalsTable">
                                @if (!empty($pregnancy_list))
                                    @foreach ($pregnancy_list as $i => $pregnancy)
                                        <tr>
                                            <td>{{ $pregnancy }}</td>
                                            <td>{{ $yeardate[$i] ?? '' }}</td>
                                            <td>{{ $gestation[$i] ?? '' }}</td>
                                            <td>{{ $induced[$i] ?? '' }}</td>
                                            <td>{{ $delivery[$i] ?? '' }}</td>
                                            <td>{{ $complication[$i] ?? '' }}</td>
                                            <td>{{ $puerperium[$i] ?? '' }}</td>
                                            <td>{{ $sex[$i] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">No pregnancy history recorded</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4">H/O of Immunization:</th>
                            </tr>

                            <tr>
                                <td>Tetanus:</td>
                                <td>{{ $pt_record->tetanus ?? '' }}</td>
                                <td>Rubella:</td>
                                <td>{{ $pt_record->rubella ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>Hepatitis B:</td>
                                <td>{{ $pt_record->hepatitis ?? '' }}</td>
                                <td>Others:</td>
                                <td>{{ $pt_record->ho_others ?? '' }}</td>
                            </tr>

                            <tr>
                                <th colspan="4">Menstrual History:</th>
                            </tr>

                            <tr>
                                <td>MC:</td>
                                <td>{{ $pt_record->mc ?? '' }}</td>
                                <td>LMP:</td>
                                <td>{{ $pt_record->lmp ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>MP:</td>
                                <td>{{ $pt_record->mp ?? '' }}</td>
                                <td>EDD:</td>
                                <td>{{ $pt_record->edd ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Dysmenorrhea:</td>
                                <td>{{ $pt_record->dysmen ?? '' }}</td>
                                <td>Post coital bleeding:</td>
                                <td>{{ $pt_record->bleeding ?? '' }}</td>
                            </tr>
                        </table>

                        @php
                            $drugs_list = !empty($pt_record->drugs) ? json_decode($pt_record->drugs, true) : [];
                            $duration = !empty($pt_record->duration) ? json_decode($pt_record->duration, true) : [];
                            $dose = !empty($pt_record->dose) ? json_decode($pt_record->dose, true) : [];
                            $side = !empty($pt_record->side) ? json_decode($pt_record->side, true) : [];
                            $adverse = !empty($pt_record->adverse) ? json_decode($pt_record->adverse, true) : [];
                        @endphp

                        <table class="table table-bordered text-center">
                            <tr>
                                <th>Drugs</th>
                                <th>Durations</th>
                                <th>Dose</th>
                                <th>Side Effects</th>
                                <th>Adverse……</th>
                            </tr>
                            <tbody id="drugTable">
                                @if (!empty($drugs_list))
                                    @foreach ($drugs_list as $i => $d)
                                        <tr>
                                            <td>{{ $d }}</td>
                                            <td>{{ $duration[$i] ?? '' }}</td>
                                            <td>{{ $dose[$i] ?? '' }}</td>
                                            <td>{{ $side[$i] ?? '' }}</td>
                                            <td>{{ $adverse[$i] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No drug history recorded</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        @php
                            $med_history = json_decode($pt_record->med_history ?? '[]', true) ?? [];
                            $surgical_history = json_decode($pt_record->surgical_history ?? '[]', true) ?? [];
                            $family_history = json_decode($pt_record->family_history ?? '[]', true) ?? [];
                        @endphp

                        <table class="table table-bordered" style="width:100%; text-align:left;">
                            <tr>
                                <th colspan="3" style="text-align:left;">Medical History:</th>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('1', $med_history) ? '✓' : '☐' }} DM
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('2', $med_history) ? '✓' : '☐' }} Cardiac disorder
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('3', $med_history) ? '✓' : '☐' }} Br. Asthma
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('4', $med_history) ? '✓' : '☐' }} PUD
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('5', $med_history) ? '✓' : '☐' }} Liver disorder
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('6', $med_history) ? '✓' : '☐' }} Hemoglobinopathies
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('7', $med_history) ? '✓' : '☐' }} HTN
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('8', $med_history) ? '✓' : '☐' }} Thyroid disorder
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('9', $med_history) ? '✓' : '☐' }} UTI
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('10', $med_history) ? '✓' : '☐' }} Others:
                                </td>
                                <td colspan="2" style="text-align:left;">
                                    {{ $pt_record->med_others ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th colspan="3" style="text-align:left;">Surgical History:</th>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('1', $surgical_history) ? '✓' : '☐' }} Appendicectomy
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('2', $surgical_history) ? '✓' : '☐' }} Salpingectomy
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('3', $surgical_history) ? '✓' : '☐' }} Laparotomy
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('4', $surgical_history) ? '✓' : '☐' }} Ovarian Cystectomy
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('5', $surgical_history) ? '✓' : '☐' }} LUCS
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('6', $surgical_history) ? '✓' : '☐' }} Others:
                                    {{ $pt_record->surgical_others ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th colspan="3" style="text-align:left;">Family History:</th>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('1', $family_history) ? '✓' : '☐' }} HTN
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('2', $family_history) ? '✓' : '☐' }} DM
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('3', $family_history) ? '✓' : '☐' }} Heart disease
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('4', $family_history) ? '✓' : '☐' }} Br. Asthma
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('5', $family_history) ? '✓' : '☐' }} Allergies
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('6', $family_history) ? '✓' : '☐' }} Others:
                                    {{ $pt_record->family_others ?? '' }}
                                </td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4">Social & Personal history:</th>
                            </tr>

                            <tr>
                                <td>Occupation:</td>
                                <td>{{ $pt_record->occupation ?? '' }}</td>
                                <td>Education:</td>
                                <td>{{ $pt_record->education ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>Husband Occupation:</td>
                                <td>{{ $pt_record->occupation_husband ?? '' }}</td>
                                <td>Financial Condition:</td>
                                <td>
                                    @if (@$pt_record->financial_condition == '1')
                                        Poor
                                    @elseif(@$pt_record->financial_condition == '2')
                                        Middle
                                    @elseif(@$pt_record->financial_condition == '3')
                                        Upper
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @php
                            $method_list = !empty($pt_record->method) ? json_decode($pt_record->method, true) : [];
                            $use_duration = !empty($pt_record->use_duration)
                                ? json_decode($pt_record->use_duration, true)
                                : [];
                        @endphp

                        <table class="table table-bordered text-center">
                            <tr>
                                <th colspan="3">Contraceptive Used:</th>
                            </tr>

                            <tr>
                                <th>Methods</th>
                                <th>Duration of Use</th>
                            </tr>
                            <tbody id="contraceptiveTable">
                                @if (!empty($method_list))
                                    @foreach ($method_list as $i => $m)
                                        <tr>
                                            <td>{{ $m }}</td>
                                            <td>{{ $use_duration[$i] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">No contraceptive history recorded</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <table class="table table-bordered" style="width:100%; text-align:left;">
                            <tr>
                                <th colspan="3" style="text-align:left;">General Examination:</th>
                            </tr>

                            @php
                                $general_exam = json_decode($pt_record->general_exam ?? '[]', true) ?? [];
                            @endphp

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('1', $general_exam) ? '✓' : '☐' }} Appearance
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('2', $general_exam) ? '✓' : '☐' }} Cyanosis
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('3', $general_exam) ? '✓' : '☐' }} Breast
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('4', $general_exam) ? '✓' : '☐' }} Height
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('5', $general_exam) ? '✓' : '☐' }} Edema
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('6', $general_exam) ? '✓' : '☐' }} Lymphnodes
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('7', $general_exam) ? '✓' : '☐' }} Weight
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('8', $general_exam) ? '✓' : '☐' }} Heart sound
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('9', $general_exam) ? '✓' : '☐' }} Thyroid
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('10', $general_exam) ? '✓' : '☐' }} Pulse
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('11', $general_exam) ? '✓' : '☐' }} Murmur
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('12', $general_exam) ? '✓' : '☐' }} Others
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('13', $general_exam) ? '✓' : '☐' }} BP
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('14', $general_exam) ? '✓' : '☐' }} Lungs
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('15', $general_exam) ? '✓' : '☐' }} Temp.
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('16', $general_exam) ? '✓' : '☐' }} Breath sound
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('17', $general_exam) ? '✓' : '☐' }} Resp. Rate
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('18', $general_exam) ? '✓' : '☐' }} Creps
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:left;">
                                    {{ in_array('19', $general_exam) ? '✓' : '☐' }} Anemia
                                </td>
                                <td style="text-align:left;">
                                    {{ in_array('20', $general_exam) ? '✓' : '☐' }} Rhonchi
                                </td>
                                <td style="text-align:left;"></td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4">Abdominal Examination:</th>
                            </tr>

                            <tr>
                                <th colspan="4" style="text-align: left">Obstetrical:</th>
                            </tr>

                            <tr>
                                <td>Ht of uterus (wks/cm)</td>
                                <td>{{ $pt_record->uterus ?? '' }}</td>
                                <td>Presentation:</td>
                                <td>{{ $pt_record->presentation ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>Engagement:</td>
                                <td>{{ $pt_record->engagement ?? '' }}</td>
                                <td>Amniotic fluid vol:</td>
                                <td>{{ $pt_record->vol ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Fetal movement:</td>
                                <td>{{ $pt_record->fetal ?? '' }}</td>
                                <td>Scar tenderness:</td>
                                <td>{{ $pt_record->scar ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>FHS:</td>
                                <td>{{ $pt_record->fhs ?? '' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Gynecological:</b></td>
                                <td colspan="3">{{ @$pt_record->gynecological }}</td>
                            </tr>

                            <tr>
                                <td><b>Inspection:</b></td>
                                <td colspan="3">{{ @$pt_record->inspection }}</td>
                            </tr>
                            <tr>
                                <td>Any Lumps:</td>
                                <td>{{ $pt_record->lumps ?? '' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Palpation:</b></td>
                                <td colspan="3">{{ @$pt_record->palpation }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left">Lumps:</th>
                            </tr>
                            <tr>
                                <td>Size:</td>
                                <td>{{ $pt_record->lum_size ?? '' }}</td>
                                <td>Mobility:</td>
                                <td>{{ $pt_record->lum_mobility ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Margin Ill Defined:</td>
                                <td>{{ $pt_record->lum_margin ?? '' }}</td>
                                <td>Ascites:</td>
                                <td>{{ $pt_record->lum_ascites ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Percussion:</b></td>
                                <td colspan="3">{{ @$pt_record->percussion }}</td>
                            </tr>

                            <tr>
                                <td><b>Auscultation:</b></td>
                                <td colspan="3">{{ @$pt_record->auscultation }}</td>
                            </tr>
                            <tr>
                                <td><b>Pelvic Examination:</b></td>
                                <td colspan="3">{{ @$pt_record->pelvic }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left">Obstetrical:</th>
                            </tr>
                            <tr>
                                <td>Cervix Consistency</td>
                                <td>{{ $pt_record->cervix ?? '' }}</td>
                                <td>Position</td>
                                <td>{{ $pt_record->pos ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Effacement(%)</td>
                                <td>{{ $pt_record->effacement ?? '' }}</td>
                                <td>Presentation part</td>
                                <td>{{ $pt_record->p_part ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Station</td>
                                <td>{{ $pt_record->station ?? '' }}</td>
                                <td>Pelvis</td>
                                <td>
                                    @if (@$pt_record->pelvis == '1')
                                        Adequate
                                    @elseif(@$pt_record->pelvis == '2')
                                        Border line
                                    @elseif(@$pt_record->pelvis == '3')
                                        Inadequate
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">Gynecological:</th>
                            </tr>
                            <tr>
                                <td>Vulva/vagina</td>
                                <td>{{ $pt_record->vagina ?? '' }}</td>
                                <td>Urethral orifice</td>
                                <td>{{ $pt_record->orifice ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Perineum</td>
                                <td>{{ $pt_record->perineum ?? '' }}</td>
                                <td>Cystocele</td>
                                <td>{{ $pt_record->cystocele ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Perspectum:</th>
                            </tr>
                            <tr>
                                <td>Cervix</td>
                                <td>{{ $pt_record->vagina ?? '' }}</td>
                                <td>Fomices</td>
                                <td>{{ $pt_record->orifice ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Discharge – </td>
                                <td>Color <br>{{ $pt_record->color ?? '' }}</td>
                                <td>Amount <br>{{ $pt_record->amount ?? '' }}</td>
                                <td>Smell <br>{{ $pt_record->smell ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Bimanual:</th>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left">Uterus</th>
                            </tr>
                            <tr>
                                <td>Size:</td>
                                <td>{{ $pt_record->u_size ?? '' }}</td>
                                <td>Consistency:</td>
                                <td>{{ $pt_record->u_consistency ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left">Fomices</th>
                            </tr>
                            <tr>
                                <td>Rt:</td>
                                <td>{{ $pt_record->f_rt ?? '' }}</td>
                                <td>Lt:</td>
                                <td>{{ $pt_record->f_lt ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Posterior:</td>
                                <td>{{ $pt_record->posterior ?? '' }}</td>
                                <td>Appendages:</td>
                                <td>{{ $pt_record->appendage ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align: left">Pre rectal Exam</th>
                            </tr>
                            <tr>
                                <td>Rectal mucosa:</td>
                                <td>{{ $pt_record->mucosa ?? '' }}</td>
                                <td>Sphincter condition:</td>
                                <td>{{ $pt_record->sphincter ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Any lump:</td>
                                <td>{{ $pt_record->any_lump ?? '' }}</td>
                                <td>Rectocele:</td>
                                <td>{{ $pt_record->rectocele ?? '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Other Systemic Examination:</th>
                            </tr>
                            <tr>
                                <td>CVS:</td>
                                <td>{{ $pt_record->cvs ?? '' }}</td>
                                <td>Respiratory:</td>
                                <td>{{ $pt_record->respiratory ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>CNS:</td>
                                <td>{{ $pt_record->cns ?? '' }}</td>
                                <td>Others:</td>
                                <td>{{ $pt_record->systemic_other ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Provisional Diagnosis:</b></td>
                                <td colspan="3">{{ @$pt_record->provisional }}</td>
                            </tr>

                            <tr>
                                <td><b>Initial Diagnosis:</b></td>
                                <td colspan="3">{{ @$pt_record->initial_diagnosis }}</td>
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
