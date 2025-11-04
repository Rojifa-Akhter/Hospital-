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
                        <span style="font-size: 16px;"><b>PATIENT DISCHARGE DIET CHART</b></span>
                    </div>

                    <div class="container mt-3">
                        <h3 class="fw-bold text-decoration-underline"><u>Nutritional Assessment Summary</u></h3>
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Parameter</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Weight (kg)</td>
                                    <td>{{ @$ptddc->weight }}</td>
                                </tr>
                                <tr>
                                    <td>Height (cm)</td>
                                    <td>{{ @$ptddc->height }}</td>
                                </tr>
                                <tr>
                                    <td>BMI</td>
                                    <td>{{ @$ptddc->bmi }}</td>
                                </tr>
                                <tr>
                                    <td>Dietary Restrictions / Allergies</td>
                                    <td>{{ @$ptddc->d_restrictions }}</td>
                                </tr>
                                <tr>
                                    <td>Nutrition Risk Score (if applicable)</td>
                                    <td>{{ @$ptddc->nr_score }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="fw-bold text-decoration-underline mt-4"><u>Discharge Diet Plan</u></h3>
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Meal Time</th>
                                    <th>Recommended Food / Quantity</th>
                                    <th>Avoid / Restrict</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $meals = [
                                        'early_morning' => 'Early Morning',
                                        'breakfast' => 'Breakfast',
                                        'mid_morning' => 'Mid-Morning',
                                        'lunch' => 'Lunch',
                                        'evening_snack' => 'Evening Snack',
                                        'dinner' => 'Dinner',
                                        'bedtime' => 'Bedtime',
                                    ];
                                @endphp

                                @foreach ($meals as $key => $label)
                                    <tr>
                                        <td style="text-align: left">{{ $label }}</td>
                                        <td>{{ @$ptddc->{'recommended_' . $key} }}</td>
                                        <td>{{ @$ptddc->{'avoid_' . $key} }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h3 class="fw-bold text-decoration-underline mt-4"><u>Special Instructions</u></h3>
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <td>Diabetic Diet</td>
                                    <td>{{ @$ptddc->diabetic_diet ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Renal Diet</td>
                                    <td>{{ @$ptddc->renal_diet ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Low Salt / Cardiac Diet</td>
                                    <td>{{ @$ptddc->low_salt ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>High Protein Diet</td>
                                    <td>{{ @$ptddc->high_protein ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Soft / Liquid Diet</td>
                                    <td>{{ @$ptddc->soft_liquid ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Other (Specify)</td>
                                    <td>
                                        {{ @$ptddc->other_diet ? '✅' : '⬜' }}
                                        {{ @$ptddc->other_diet_txt ? ' - ' . @$ptddc->other_diet_txt : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container mt-4">
                        <h3 class="fw-bold text-decoration-underline"><u>Notes / Instructions for Home</u></h3>
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <td>Drink adequate water unless restricted</td>
                                    <td>{{ @$ptddc->drink_water ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Avoid fried or spicy food unless advised</td>
                                    <td>{{ @$ptddc->af_food ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Follow portion control as demonstrated</td>
                                    <td>{{ @$ptddc->fp_control ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Maintain regular meal timing</td>
                                    <td>{{ @$ptddc->mm_timing ? '✅' : '⬜' }}</td>
                                </tr>
                                <tr>
                                    <td>Continue nutritional supplements (if prescribed)</td>
                                    <td>
                                        {{ @$ptddc->c_supplements ? '✅' : '⬜' }}
                                        {{ @$ptddc->sup_text ? ' - ' . @$ptddc->sup_text : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="fw-bold text-decoration-underline mt-4"><u>Patient / Attendant Education</u></h3>
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Education Provided On</th>
                                    <th>Yes / No</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left">Diet Plan Explained</td>
                                    <td>{{ @$ptddc->dp_explained }}</td>
                                    <td>{{ @$ptddc->dpe_remarks }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Food Portion Demonstrated</td>
                                    <td>{{ @$ptddc->fp_demo }}</td>
                                    <td>{{ @$ptddc->fpd_remarks }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Follow-up Appointment Informed</td>
                                    <td>{{ @$ptddc->followup_informed }}</td>
                                    <td>{{ @$ptddc->fi_remarks }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="fw-bold text-decoration-underline mt-4"><u>Acknowledgment</u></h3>
                        <p>I have received and understood the diet plan explained to me by the hospital dietician.</p>
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name & Signature of Patient / Attendant</th>
                                    <th>Signature of Dietician</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ @$ptddc->patient_signature }}</td>
                                    <td>{{ @$ptddc->dietician_signature }}</td>
                                    <td>{{ @$ptddc->ack_date }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="fw-bold text-decoration-underline mt-4"><u>Follow-up Advice</u></h3>
                        <table class="table table-bordered align-middle">
                            <tr>
                                <td><b>Next Review Date:</b></td>
                                <td>{{ @$ptddc->next_review_date }}</td>
                            </tr>
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
