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
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td,
        th {
            font-size: 13px;
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

        .header>tbody>tr>td {
            border: none;
        }

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: 0px;
            right: 0px;
            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <tbody>
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
        </tbody>
    </table>

    <div
        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;"><b>DAILY CHECK FOR REFRIGERATOR</b></span>
    </div>

    <table class="table table-bordered">
        <thead class="global-uhl-table-bg">
            <tr>
                <td colspan="3"><b>Unit</b></td>
                <td colspan="3">{{ @$unit_month->unit }}</td>
                <td colspan="3"><b>Month</b></td>
                <td colspan="4">{{ @$unit_month->month }}</td>

            </tr>
            <tr>
                <td colspan="13" style="text-align: left"><b>ACCEPTABLE TEMPERATURE RANGE FOR REFRIGERATOR FRIDGE:
                        2◦C-8◦C, FREEZER: -15◦C to -8◦C</b></td>
            </tr>
            <tr>
                <td colspan="13" style="text-align: left"><b>CLEANING ONCE IN A WEEK: FRIDAY &nbsp; &nbsp;IN CASE OF
                        TEMPERATURE EXCEEDING ACEPTABLE LIMITS, PLEASE CALL DUTY ENGINEER AT EXTENSION</b></td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: left"><b>DISPOSITION OF MEDICINE AT THE TIME OF
                        CLEANING/TEMPRATURE
                        OUT OF RANGE IS </b>&nbsp; &nbsp; &nbsp;{{ @$unit_month->range }} </td>


                <td colspan="3"><b>DEPT</b>&nbsp; &nbsp; &nbsp;{{ @$unit_month->dept }}</td>
            </tr>
            <tr>
                <th rowspan="2">DATE</th>
                <th colspan="3">MORNING</th>
                <th colspan="3">EVENING</th>
                <th colspan="3">NIGHT</th>
                <th>CLEANING/DEFREEZE</th>
                <th>COMPLAINT</th>
                <th>REPAIRED</th>
            </tr>
            <tr>

                <th>FRIDGE</th>
                <th>FREEZER</th>
                <th>SIGN & EMP. ID</th>
                <th>FRIDGE</th>
                <th>FREEZER</th>
                <th>SIGN & EMP. ID</th>
                <th>FRIDGE</th>
                <th>FREEZER</th>
                <th>SIGN & EMP. ID</th>
                <th>DATE & TIME</th>
                <th>DATE & TIME</th>
                <th>DATE & TIME</th>



            </tr>

        </thead>


        <tbody>


            @forelse ($refrigerator as $item)
                <tr>
                    <td>
                        @if (!empty($item->ref_date))
                            {{ date('d/m/Y h:i:s A', strtotime($item->ref_date)) }}
                        @endif
                    </td>
                    <td>{{ $item->m_fridge }}</td>
                    <td>{{ $item->m_freezer }}</td>
                    <td>{{ $item->m_sign }}</td>
                    <td>{{ $item->e_fridge }}</td>
                    <td>{{ $item->e_freezer }}</td>
                    <td>{{ $item->e_sign }}</td>
                    <td>{{ $item->n_fridge }}</td>
                    <td>{{ $item->n_freezer }}</td>
                    <td>{{ $item->n_sign }}</td>
                    <td>{{ $item->cleaning }}</td>
                    <td>{{ $item->complaint }}</td>
                    <td>{{ $item->repaired }}</td>

                </tr>

            @empty
                <tr>
                    <td colspan="13" style="text-align: center">Data Not Found !</td>
                </tr>
            @endforelse


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
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>

</body>

</html>
