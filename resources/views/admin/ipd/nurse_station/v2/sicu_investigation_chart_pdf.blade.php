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
                        <span style="font-size: 16px;"><b>SICU INVESTIGATION CHART</b></span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table border="1" cellspacing="0" cellpadding="4"
        style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">

        <thead>
            <tr style="font-weight:700;">
                <th colspan="3">HEMATOLOGY</th>
                <th colspan="2">CARDIAC ENZYMES</th>
                <th colspan="3">BIOCHEMICAL</th>
            </tr>

            <tr style="font-weight:700;">
                <th>TIME</th>
                <th>Pre-op</th>
                <th></th>
                <th>Troponin-I</th>
                <th></th>
                <th>Time</th>
                <th>Pre-op</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>HB</td>
                <td>{{ @$sicu_chart->hema_hb }}</td>
                <td>{{ @$sicu_chart->hema_hb2 }}</td>
                <td>Time</td>
                <td>{{ @$sicu_chart->cardiac_time }}</td>
                <td>GLU Random/Fasting</td>
                <td>{{ @$sicu_chart->bio_glu }}</td>
                <td>{{ @$sicu_chart->bio_glu2 }}</td>
            </tr>
            <tr>
                <td>PCV</td>
                <td>{{ @$sicu_chart->hema_pcv }}</td>
                <td>{{ @$sicu_chart->hema_pcv2 }}</td>
                <td>SGOT(AST)</td>
                <td>{{ @$sicu_chart->cardiac_sgot }}</td>
                <td>UREA</td>
                <td>{{ @$sicu_chart->bio_urea }}</td>
                <td>{{ @$sicu_chart->bio_urea2 }}</td>
            </tr>
            <tr>
                <td>WBC</td>
                <td>{{ @$sicu_chart->hema_wbc }}</td>
                <td>{{ @$sicu_chart->hema_wbc2 }}</td>
                <td>CPK</td>
                <td>{{ @$sicu_chart->cardiac_cpk }}</td>
                <td>CREATININE</td>
                <td>{{ @$sicu_chart->bio_creatinine }}</td>
                <td>{{ @$sicu_chart->bio_creatinine2 }}</td>
            </tr>
            <tr>
                <td>Platelet Count</td>
                <td>{{ @$sicu_chart->hema_platelet }}</td>
                <td>{{ @$sicu_chart->hema_platelet2 }}</td>
                <td>CPKMB</td>
                <td>{{ @$sicu_chart->cardiac_cpkmb }}</td>
                <td>Sr. URIC ACID</td>
                <td>{{ @$sicu_chart->bio_acid }}</td>
                <td>{{ @$sicu_chart->bio_acid2 }}</td>
            </tr>
            <tr>
                <td>ESR</td>
                <td>{{ @$sicu_chart->hema_esr }}</td>
                <td>{{ @$sicu_chart->hema_esr2 }}</td>
                <td>LDH</td>
                <td>{{ @$sicu_chart->cardiac_ldh }}</td>
                <td>K+(eGFR)</td>
                <td>{{ @$sicu_chart->bio_egfr }}</td>
                <td>{{ @$sicu_chart->bio_egfr2 }}</td>
            </tr>
            <tr>
                <td>Neutrophil</td>
                <td>{{ @$sicu_chart->hema_neutrophil }}</td>
                <td>{{ @$sicu_chart->hema_neutrophil2 }}</td>
                <td colspan="2"><strong>CARDIOLOGY</strong></td>
                <td>Na+/Cl-</td>
                <td>{{ @$sicu_chart->bio_na }}</td>
                <td>{{ @$sicu_chart->bio_na2 }}</td>
            </tr>
            <tr>
                <td>Lymphocyte</td>
                <td>{{ @$sicu_chart->hema_lymphocyte }}</td>
                <td>{{ @$sicu_chart->hema_lymphocyte2 }}</td>
                <td colspan="2">ECG</td>
                <td>BILIRUBIN. T.</td>
                <td>{{ @$sicu_chart->bio_t }}</td>
                <td>{{ @$sicu_chart->bio_t2 }}</td>
            </tr>
            <tr>
                <td>Eosinophil</td>
                <td>{{ @$sicu_chart->hema_nophil }}</td>
                <td>{{ @$sicu_chart->hema_nophil2 }}</td>
                <td colspan="2" rowspan="3">{{ @$sicu_chart->car_ecg }}</td>
                <td>BILIRUBIN. D.</td>
                <td>{{ @$sicu_chart->bio_d }}</td>
                <td>{{ @$sicu_chart->bio_d2 }}</td>
            </tr>
            <tr>
                <td>Monocyte</td>
                <td>{{ @$sicu_chart->hema_monocyte }}</td>
                <td>{{ @$sicu_chart->hema_monocyte2 }}</td>
                <td>BILIRUBIN. I.</td>
                <td>{{ @$sicu_chart->bio_i }}</td>
                <td>{{ @$sicu_chart->bio_i2 }}</td>
            </tr>
            <tr>
                <td>Basophil</td>
                <td>{{ @$sicu_chart->hema_basophil }}</td>
                <td>{{ @$sicu_chart->hema_basophil2 }}</td>
                <td>ALK.PHOS</td>
                <td>{{ @$sicu_chart->bio_phos }}</td>
                <td>{{ @$sicu_chart->bio_phos2 }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>BIOCHEMISTRY</strong></td>
                <td colspan="2">Echo</td>
                <td>SGPT(ALT)</td>
                <td>{{ @$sicu_chart->bio_alt }}</td>
                <td>{{ @$sicu_chart->bio_alt2 }}</td>
            </tr>
            <tr>
                <td rowspan="2">Cholesterol</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_cholesterol }}</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_cholesterol2 }}</td>
                <td colspan="2" rowspan="3">{{ @$sicu_chart->car_echo }}</td>
                <td>SGOT (AST)</td>
                <td>{{ @$sicu_chart->bio_ast }}</td>
                <td>{{ @$sicu_chart->bio_ast2 }}</td>
            </tr>
            <tr>
                <td>ALBUMIN</td>
                <td>{{ @$sicu_chart->bio_albumin }}</td>
                <td>{{ @$sicu_chart->bio_albumin2 }}</td>
            </tr>
            <tr>
                <td rowspan="2">Triglyceride</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_trigly }}</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_trigly2 }}</td>
                <td>TOTAL PROTEIN</td>
                <td>{{ @$sicu_chart->bio_protein }}</td>
                <td>{{ @$sicu_chart->bio_protein2 }}</td>
            </tr>
            <tr>
                <td colspan="2">CARDIAC CATH</td>
                <td>CALCIUM</td>
                <td>{{ @$sicu_chart->bio_calcium }}</td>
                <td>{{ @$sicu_chart->bio_calcium2 }}</td>
            </tr>
            <tr>
                <td rowspan="2">HDL</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_hdl }}</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_hdl2 }}</td>
                <td colspan="2" rowspan="4">{{ @$sicu_chart->car_cath }}</td>
                <td>Sr. INOR. PHOS/Mg++</td>
                <td>{{ @$sicu_chart->bio_mg }}</td>
                <td>{{ @$sicu_chart->bio_mg2 }}</td>
            </tr>
            <tr>
                <td>FT4</td>
                <td>{{ @$sicu_chart->bio_ft }}</td>
                <td>{{ @$sicu_chart->bio_ft2 }}</td>
            </tr>
            <tr>
                <td rowspan="2">LDL</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_ldl }}</td>
                <td rowspan="2">{{ @$sicu_chart->bioche_ldl2 }}</td>
                <td>FT3</td>
                <td>{{ @$sicu_chart->bio_ft3 }}</td>
                <td>{{ @$sicu_chart->bio_ft4 }}</td>
            </tr>
            <tr>
                <td>TSH</td>
                <td>{{ @$sicu_chart->bio_tsh }}</td>
                <td>{{ @$sicu_chart->bio_tsh2 }}</td>
            </tr>
        </tbody>
    </table> <br> <br> <br> <br> <br> <br> <br>
    <table border="1" cellspacing="0" cellpadding="4"
        style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">
        <thead>
            <tr style="font-weight:700;">
                <th colspan="5">COAGULATION PROFILE</th>
                <th colspan="2">RADIOLOGY</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TIME</td>
                <td>{{ @$sicu_chart->profile_time }}</td>
                <td>{{ @$sicu_chart->profile_time2 }}</td>
                <td>{{ @$sicu_chart->profile_time3 }}</td>
                <td>{{ @$sicu_chart->profile_time4 }}</td>
                <td colspan="2">X-Ray</td>
            </tr>
            <tr>
                <td>PT</td>
                <td>{{ @$sicu_chart->profile_pt }}</td>
                <td>{{ @$sicu_chart->profile_pt2 }}</td>
                <td>{{ @$sicu_chart->profile_pt3 }}</td>
                <td>{{ @$sicu_chart->profile_pt4 }}</td>
                <td colspan="2" rowspan="4">{{ @$sicu_chart->xray }}</td>
            </tr>
            <tr>
                <td>APTT</td>
                <td>{{ @$sicu_chart->profile_aptt }}</td>
                <td>{{ @$sicu_chart->profile_aptt2 }}</td>
                <td>{{ @$sicu_chart->profile_aptt3 }}</td>
                <td>{{ @$sicu_chart->profile_aptt4 }}</td>
            </tr>
            <tr>
                <td>INR</td>
                <td>{{ @$sicu_chart->profile_inr }}</td>
                <td>{{ @$sicu_chart->profile_inr2 }}</td>
                <td>{{ @$sicu_chart->profile_inr3 }}</td>
                <td>{{ @$sicu_chart->profile_inr4 }}</td>
            </tr>
            <tr>
                <td>PLATELET COUNT</td>
                <td>{{ @$sicu_chart->profile_count }}</td>
                <td>{{ @$sicu_chart->profile_count2 }}</td>
                <td>{{ @$sicu_chart->profile_count3 }}</td>
                <td>{{ @$sicu_chart->profile_count4 }}</td>
            </tr>
            <tr>
                <td>B.T</td>
                <td>{{ @$sicu_chart->profile_bt }}</td>
                <td>{{ @$sicu_chart->profile_bt2 }}</td>
                <td>{{ @$sicu_chart->profile_bt3 }}</td>
                <td>{{ @$sicu_chart->profile_bt4 }}</td>
                <td colspan="2">OTHERS</td>
            </tr>
            <tr>
                <td>C.T</td>
                <td>{{ @$sicu_chart->profile_ct }}</td>
                <td>{{ @$sicu_chart->profile_ct2 }}</td>
                <td>{{ @$sicu_chart->profile_ct3 }}</td>
                <td>{{ @$sicu_chart->profile_ct4 }}</td>
                <td colspan="2" rowspan="4">{{ @$sicu_chart->rd_other }}</td>
            </tr>
            <tr>
                <td>D.DIMER</td>
                <td>{{ @$sicu_chart->profile_dimer }}</td>
                <td>{{ @$sicu_chart->profile_dimer2 }}</td>
                <td>{{ @$sicu_chart->profile_dimer3 }}</td>
                <td>{{ @$sicu_chart->profile_dimer4 }}</td>
            </tr>
            <tr>
                <td>FIBRINOGEN</td>
                <td>{{ @$sicu_chart->profile_fib }}</td>
                <td>{{ @$sicu_chart->profile_fib2 }}</td>
                <td>{{ @$sicu_chart->profile_fib3 }}</td>
                <td>{{ @$sicu_chart->profile_fib4 }}</td>
            </tr>
            <tr>
                <td>FDP</td>
                <td>{{ @$sicu_chart->profile_fdp }}</td>
                <td>{{ @$sicu_chart->profile_fdp2 }}</td>
                <td>{{ @$sicu_chart->profile_fdp3 }}</td>
                <td>{{ @$sicu_chart->profile_fdp4 }}</td>
            </tr>
        </tbody>
    </table>
    <table border="1" cellspacing="0" cellpadding="4" class="blood-gas-table"
        style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">
        <thead>
            <tr style="font-weight:700;">
                <th colspan="10">BLOOD GAS ANALYSIS</th>
                <th colspan="2">OTHERS INVESTIGATION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TIME</td>
                <td>{{ @$sicu_chart->blood_time }}</td>
                <td>{{ @$sicu_chart->blood_time2 }}</td>
                <td>{{ @$sicu_chart->blood_time3 }}</td>
                <td>{{ @$sicu_chart->blood_time4 }}</td>
                <td>{{ @$sicu_chart->blood_time5 }}</td>
                <td>{{ @$sicu_chart->blood_time6 }}</td>
                <td>{{ @$sicu_chart->blood_time7 }}</td>
                <td>{{ @$sicu_chart->blood_time8 }}</td>
                <td>{{ @$sicu_chart->blood_time9 }}</td>
                <td colspan="2" rowspan="10">{{ @$sicu_chart->investigation }}</td>
            </tr>
            <tr>
                <td>PH</td>
                <td>{{ @$sicu_chart->blood_ph }}</td>
                <td>{{ @$sicu_chart->blood_ph2 }}</td>
                <td>{{ @$sicu_chart->blood_ph3 }}</td>
                <td>{{ @$sicu_chart->blood_ph4 }}</td>
                <td>{{ @$sicu_chart->blood_ph5 }}</td>
                <td>{{ @$sicu_chart->blood_ph6 }}</td>
                <td>{{ @$sicu_chart->blood_ph7 }}</td>
                <td>{{ @$sicu_chart->blood_ph8 }}</td>
                <td>{{ @$sicu_chart->blood_ph9 }}</td>
            </tr>
            <tr>
                <td>PCO2</td>
                <td>{{ @$sicu_chart->blood_pco }}</td>
                <td>{{ @$sicu_chart->blood_pco2 }}</td>
                <td>{{ @$sicu_chart->blood_pco3 }}</td>
                <td>{{ @$sicu_chart->blood_pco4 }}</td>
                <td>{{ @$sicu_chart->blood_pco5 }}</td>
                <td>{{ @$sicu_chart->blood_pco6 }}</td>
                <td>{{ @$sicu_chart->blood_pco7 }}</td>
                <td>{{ @$sicu_chart->blood_pco8 }}</td>
                <td>{{ @$sicu_chart->blood_pco9 }}</td>
            </tr>
            <tr>
                <td>PO2</td>
                <td>{{ @$sicu_chart->blood_po }}</td>
                <td>{{ @$sicu_chart->blood_po2 }}</td>
                <td>{{ @$sicu_chart->blood_po3 }}</td>
                <td>{{ @$sicu_chart->blood_po4 }}</td>
                <td>{{ @$sicu_chart->blood_po5 }}</td>
                <td>{{ @$sicu_chart->blood_po6 }}</td>
                <td>{{ @$sicu_chart->blood_po7 }}</td>
                <td>{{ @$sicu_chart->blood_po8 }}</td>
                <td>{{ @$sicu_chart->blood_po9 }}</td>
            </tr>
            <tr>
                <td>HCO3</td>
                <td>{{ @$sicu_chart->blood_hco }}</td>
                <td>{{ @$sicu_chart->blood_hco2 }}</td>
                <td>{{ @$sicu_chart->blood_hco3 }}</td>
                <td>{{ @$sicu_chart->blood_hco4 }}</td>
                <td>{{ @$sicu_chart->blood_hco5 }}</td>
                <td>{{ @$sicu_chart->blood_hco6 }}</td>
                <td>{{ @$sicu_chart->blood_hco7 }}</td>
                <td>{{ @$sicu_chart->blood_hco8 }}</td>
                <td>{{ @$sicu_chart->blood_hco9 }}</td>
            </tr>
            <tr>
                <td>BE</td>
                <td>{{ @$sicu_chart->blood_be }}</td>
                <td>{{ @$sicu_chart->blood_be2 }}</td>
                <td>{{ @$sicu_chart->blood_be3 }}</td>
                <td>{{ @$sicu_chart->blood_be4 }}</td>
                <td>{{ @$sicu_chart->blood_be5 }}</td>
                <td>{{ @$sicu_chart->blood_be6 }}</td>
                <td>{{ @$sicu_chart->blood_be7 }}</td>
                <td>{{ @$sicu_chart->blood_be8 }}</td>
                <td>{{ @$sicu_chart->blood_be9 }}</td>
            </tr>
            <tr>
                <td>O2SAT</td>
                <td>{{ @$sicu_chart->blood_sat }}</td>
                <td>{{ @$sicu_chart->blood_sat2 }}</td>
                <td>{{ @$sicu_chart->blood_sat3 }}</td>
                <td>{{ @$sicu_chart->blood_sat4 }}</td>
                <td>{{ @$sicu_chart->blood_sat5 }}</td>
                <td>{{ @$sicu_chart->blood_sat6 }}</td>
                <td>{{ @$sicu_chart->blood_sat7 }}</td>
                <td>{{ @$sicu_chart->blood_sat8 }}</td>
                <td>{{ @$sicu_chart->blood_sat9 }}</td>
            </tr>
            <tr>
                <td>Hb</td>
                <td>{{ @$sicu_chart->blood_hb }}</td>
                <td>{{ @$sicu_chart->blood_hb2 }}</td>
                <td>{{ @$sicu_chart->blood_hb3 }}</td>
                <td>{{ @$sicu_chart->blood_hb4 }}</td>
                <td>{{ @$sicu_chart->blood_hb5 }}</td>
                <td>{{ @$sicu_chart->blood_hb6 }}</td>
                <td>{{ @$sicu_chart->blood_hb7 }}</td>
                <td>{{ @$sicu_chart->blood_hb8 }}</td>
                <td>{{ @$sicu_chart->blood_hb9 }}</td>
            </tr>
            <tr>
                <td>NA/CL</td>
                <td>{{ @$sicu_chart->blood_na }}</td>
                <td>{{ @$sicu_chart->blood_na2 }}</td>
                <td>{{ @$sicu_chart->blood_na3 }}</td>
                <td>{{ @$sicu_chart->blood_na4 }}</td>
                <td>{{ @$sicu_chart->blood_na5 }}</td>
                <td>{{ @$sicu_chart->blood_na6 }}</td>
                <td>{{ @$sicu_chart->blood_na7 }}</td>
                <td>{{ @$sicu_chart->blood_na8 }}</td>
                <td>{{ @$sicu_chart->blood_na9 }}</td>
            </tr>
            <tr>
                <td>K</td>
                <td>{{ @$sicu_chart->blood_k }}</td>
                <td>{{ @$sicu_chart->blood_k2 }}</td>
                <td>{{ @$sicu_chart->blood_k3 }}</td>
                <td>{{ @$sicu_chart->blood_k4 }}</td>
                <td>{{ @$sicu_chart->blood_k5 }}</td>
                <td>{{ @$sicu_chart->blood_k6 }}</td>
                <td>{{ @$sicu_chart->blood_k7 }}</td>
                <td>{{ @$sicu_chart->blood_k8 }}</td>
                <td>{{ @$sicu_chart->blood_k9 }}</td>
            </tr>
            <tr>
                <td>SUGAR</td>
                <td>{{ @$sicu_chart->blood_sugar }}</td>
                <td>{{ @$sicu_chart->blood_sugar2 }}</td>
                <td>{{ @$sicu_chart->blood_sugar3 }}</td>
                <td>{{ @$sicu_chart->blood_sugar4 }}</td>
                <td>{{ @$sicu_chart->blood_sugar5 }}</td>
                <td>{{ @$sicu_chart->blood_sugar6 }}</td>
                <td>{{ @$sicu_chart->blood_sugar7 }}</td>
                <td>{{ @$sicu_chart->blood_sugar8 }}</td>
                <td>{{ @$sicu_chart->blood_sugar9 }}</td>
                <td colspan="2">{{ @$sicu_chart->sign }}</td>
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
