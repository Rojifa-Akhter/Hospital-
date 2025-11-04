<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Monthly Salary Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;

            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                {{-- <td style=" text-align:right; width: 15%; ">
                 <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                 </div>

                </td> --}}
            </tr>
        </table>
    </header>

    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Monthly Salary
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


            <span class="report-date"><strong> Year: </strong> {{ $year }} </br> <strong> Month: </strong>
                @php
                    if ($month == '01') {
                        echo 'January';
                    } elseif ($month == '02') {
                        echo 'February';
                    } elseif ($month == '03') {
                        echo 'March';
                    } elseif ($month == '04') {
                        echo 'April';
                    } elseif ($month == '05') {
                        echo 'May';
                    } elseif ($month == '06') {
                        echo 'June';
                    } elseif ($month == '07') {
                        echo 'July';
                    } elseif ($month == '08') {
                        echo 'August';
                    } elseif ($month == '09') {
                        echo 'September';
                    } elseif ($month == '10') {
                        echo 'October';
                    } elseif ($month == '11') {
                        echo 'November';
                    } elseif ($month == '12') {
                        echo 'December';
                    }
                @endphp

            </span>
        </div>
    </div>
    <div class="signature_">
        <table style="width: 100%; border:none ">
            <tr style=" ">
                <td style="text-align:left; border:none ">
                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                </td>
                <td style="text-align:left; border:none ">
                    <span style="padding:5px; border-top: black solid 1px;">Manager Accounts</span>
                </td>

                <td style="text-align:center; border:none">
                    <span style="padding:5px; border-top: black solid 1px;">DGM
                    </span>
                </td>

                <td style="text-align:right; border:none">
                    <span style="padding:5px; border-top: black solid 1px;">DMD
                    </span>
                </td>
                <td style="text-align:right; border:none">
                    <span style="padding:5px; border-top: black solid 1px;">Chairman
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <footer>
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="wrapper">

            <section id="lp-items">
                <div class="container">
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead style="">
                            <tr class="table-tr" style="background-color: #E3E3E3; ">
                                <th class=" table-td" rowspan="2"> <strong>SL# </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Card No </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Name </strong></th>
                                <!-- <th class=" table-td" rowspan="2"> <strong>Designation </strong></th> -->
                                <!-- <th class=" table-td" rowspan="2"> <strong>AD </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>PD </strong></th> -->
                                <th class=" table-td" colspan="3"> <strong>Salary Stracture </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Gross Salary </strong></th>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <th class=" table-td" rowspan="2"> <strong>Attend Bonus </strong></th>
                                @endif
                                <th class=" table-td" rowspan="2">
                                    <strong>{{ Session::get('user.ses_hospital_code') == 'JKMH' ? 'Night Allowance' : 'Others' }}
                                    </strong>
                                </th>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <th class=" table-td" colspan="3"> <strong>Over time </strong></th>
                                @endif
                                <!-- <th class=" table-td" rowspan="2"> <strong>Payable Wages </strong></th> -->
                                <!-- <th class=" table-td" rowspan="2"> <strong>Late Count </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Deduct Hours </strong></th> -->
                                <th class=" table-td"
                                    colspan="{{ Session::get('user.ses_hospital_code') == 'JKMH' ? 5 : 10 }}">
                                    <strong>Deduction </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Payable Amount </strong></th>
                                <th class=" table-td" rowspan="2"> <strong>Recipient Signature </strong></th>
                            </tr>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <td class=" table-td"> <strong>Basic </strong></td>
                                <td class=" table-td"> <strong>House Rent </strong></td>
                                <td class=" table-td"> <strong>Medical </strong></td>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <td class=" table-td"> <strong>Min </strong></td>
                                    <td class=" table-td"> <strong>Rate </strong></td>
                                    <td class=" table-td"> <strong>Amount </strong></td>

                                    <!-- <td class=" table-td"> <strong>Gross </strong></td> -->
                                    <td class="text-center"><strong>Late Day</strong></td>
                                    <td class="text-center"><strong>Leave Day</strong></td>
                                @endif
                                <td class="text-center"><strong>Leave WP day</strong></td>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <td class="text-center"><strong>Abs Day</strong></td>
                                @endif
                                <td class="text-center"><strong>Pre Day</strong></td>
                                <td class=" table-td"> <strong>Abs Deduct Amt </strong></td>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <td class=" table-td"> <strong>Residence fee </strong></td>
                                @endif
                                <td class=" table-td"> <strong>Loan </strong></td>
                                @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                    <td class=" table-td"> <strong>SF </strong></td>
                                @endif
                                <td class=" table-td"> <strong>Other Deduct </strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $listSl = 0; @endphp
                            @if (!empty($emp_data))
                                @foreach ($emp_data as $dept => $dept_data)
                                    @php
                                        $dep = 0;

                                    @endphp
                                    @foreach ($dept_data as $desig => $data)
                                        @php
                                            $des = 0;
                                            $listSl++;
                                            $dep++;

                                        @endphp
                                        @if ($dep == 1)
                                            <tr class="">
                                                <td class="border-0"
                                                    colspan="{{ Session::get('user.ses_hospital_code') == 'JKMH' ? 15 : 24 }}">
                                                    <strong> Department = </strong>{{ $dept }}
                                                    <strong> Total Employee = </strong>
                                                    {{ isset($count_depart_emp[$dept]) ? $count_depart_emp[$dept] : '0' }}
                                                    <strong> Total Salary = </strong>
                                                    {{ isset($total_salary[$dept]) ? number_format($total_salary[$dept], 2) : '0' }}

                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="table-tr">
                                            <td class="table-td" style="text-align: center;"
                                                style="text-align: center;" scope="col">
                                                <strong>{{ $listSl }}</strong>
                                            </td>
                                            <td class="table-td" style="text-align: left;">{{ $data->card_no }} </td>
                                            <td class="table-td" style="text-align: left;">{{ $data->full_name }}
                                                <br>{{ $data->designation_name }}
                                            </td>
                                            <!-- <td class="table-td" style="text-align: left;">{{ $data->designation_name }}</td> -->
                                            <!-- <td class="table-td" style="text-align: right;">00</td>
                                                <td class="table-td" style="text-align: right;">00</td> -->
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->basic_salary, 2) }}</td>
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->house_rent, 2) }}</td>
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->medical_allowance, 2) }}</td>
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->gross_salary, 2) }}</td>
                                            @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->attendance_bonus, 2) }}</td>
                                            @endif
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->other_allowance, 2) }}</td>


                                            @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->overtime_hours) }}</td>
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->overtime_rate, 2) }}</td>
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->overtime_amount, 2) }}</td>

                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->late_days) }}</td>
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->leave_days) }}</td>
                                            @endif
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->leave_withoutpay_days) }}</td>
                                            @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->absent_days) }}</td>
                                            @endif
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->attendance_days) }}</td>
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->att_deduct_amount, 2) }}</td>
                                            @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->residence_fee, 2) }}</td>
                                            @endif
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->loan_deduct_amount, 2) }}</td>
                                            <!-- <td class="table-td" style="text-align: right;"></td> -->
                                            @if (Session::get('user.ses_hospital_code') != 'JKMH')
                                                <td class="table-td" style="text-align: right;">
                                                    {{ number_format($data->personal_savings_amount, 2) }}</td>
                                            @endif
                                            <td class="table-td" style="text-align: right;">
                                                {{ number_format($data->other_deduct_amount, 2) }}</td>
                                            <td class="table-td" style="text-align: right;"> <strong>
                                                    {{ number_format($data->payable_amount, 2) }} </strong></td>
                                            <td class="table-td" style="text-align: left;"></td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>


                    </table>
                </div>
            </section>
        </div>
    </main>



</body>

</html>
