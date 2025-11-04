<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Attendance Report</title>
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
            font-size: 12px;
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

        .border-0 {
            border: 1px solid black;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                {{-- <td style="width: 10%;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                </td> --}}
                <td style="text-align: center;">
                     <span style="font-size: 15px;"> <strong>  {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong></span> <br>
                   Address: <span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span> {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                {{-- <td style=" text-align:right; width: 15%; ">
                 <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                 </div>

                </td> --}}
            </tr>
        </table>
    </header>
    {{-- <header>
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
                </td> --}}
                {{-- <td style=" text-align:right; width: 15%; ">
                    <div style="">
                       <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                   </td> --}}
            {{-- </tr>
        </table>
    </header> --}}

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> PREPARED BY
                    </span>
                </td>
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER(A/C)
                    </span>
                </td>
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> DGM
                    </span>
                </td>

                <td style="text-align:right; border:none">
                    <span style="padding:5px; border-top: black solid 1px;">DMD
                    </span>
                </td>
                <td style="text-align:right; border:none">
                    <span style="padding:5px; border-top: black solid 1px;">CHAIRMAN
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
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
            <div style=" text-align:center; margin-bottom:10px;" class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px; font-weight:bold "> Attendance
                    Sheet for the month of {{ date('F', strtotime($attendence_month_date)) }} -
                    {{ date('Y', strtotime($attendence_month_date)) }} </span>
            </div>

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-left" scope="col" style="width:5px">SL</th>
                                <th class="text-left" scope="col">Employee Card</th>
                                <th class="text-center" scope="col" style="">Name</th>
                                <th class="text-center" scope="col">Desig.</th>
                                {{-- <th class="text-left" scope="col">Department</th>
                                <th class="text-left" scope="col">Year-Month</th> --}}
                                <th class="text-left" scope="col">M.O.D</th>
                                <th class="text-left" scope="col">working-Days</th>
                                <th class="text-left" scope="col">Weekend</th>
                                <th class="text-left" scope="col">Absent</th>
                                <th class="text-left" scope="col">C.L</th>
                                <th class="text-left" scope="col">S.L</th>
                                {{-- <th class="text-left" scope="col">Late</th> --}}
                                <th class="text-left" scope="col">T.Leave-days</th>
                                <th class="text-left" scope="col">LWP</th>
                                <th class="text-left" scope="col">G.F</th>
                                <th class="text-left" scope="col">Paid Days</th>
                                <th class="text-left" scope="col" style="border-bottom: 1px solid #333;">Total Working Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($attend_data))
                                @php
                                    $diff = 1;
                                    $count = 0;
                                    $pre = '';
                                    $listSl = 0;
                                @endphp
                                 @foreach ($attend_data as $dept => $dept_data)
                                {{-- @foreach ($attend_data as $sample_row) --}}
                                {{-- {{dd($sample_row)}} --}}
                                @php
                                $dep = 0;
                                @endphp
                                  @foreach ($dept_data as $desig => $sample_row)
                                  @php
                                    $des = 0;
                                    $listSl++;
                                    $dep++;
                                   @endphp
                                    {{-- @if ($pre != $sample_row->serviceunit_name)
                                        <tr class="table-tr">
                                            <td class="border-1" colspan="13" style="border-bottom: 1px solid #333;">
                                                <b>Department : </b> {{ $sample_row->serviceunit_name }}
                                            </td>
                                            @php
                                                $count = 1;
                                                $pre = $sample_row->serviceunit_name;
                                            @endphp
                                        </tr>
                                    @endif --}}
                                    @if ($dep == 1)

                                        <tr class="table-tr">
                                            <td class="border-0" colspan="15">
                                                <strong> Job Type = </strong>{{ $dept }}
                                                <strong> Total Employee = </strong>
                                                {{ isset($count_depart_emp[$dept]) ? $count_depart_emp[$dept] : '0' }}

                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="table-tr">
                                        <td class=" text-center border-0" style="width:5px">{{ $listSl }}</td>
                                        <td class=" text-center border-0">{{ $sample_row->person_card_no }}</td>
                                        <td class=" text-center border-0" style="width:220px">
                                            {{ (strlen($sample_row->full_name) > 30) ? substr($sample_row->full_name,0,30).'..' : $sample_row->full_name}}
                                        </td>
                                        <td class=" text-center border-0" style="width:220px">{{ (strlen($sample_row->designation_name) > 30) ? substr($sample_row->designation_name,0,30).'..' : $sample_row->designation_name}}</td>
                                        {{-- <td class=" text-center border-0">{{ $sample_row->serviceunit_name }}</td>
                                        <td class=" text-center border-0">{{ $sample_row->attendance_yyyymm }}</td> --}}
                                        <td class=" text-center border-0">{{ $sample_row->month_days }}</td>
                                        @php
                                            $emp_working_days = ($sample_row->working_days - ($sample_row->absent_days+$sample_row->leave_withoutpay_days));
                                            $holidays_diff = isset($sample_row->holidays) ? $sample_row->holidays : ($sample_row->month_days - $sample_row->working_days);
                                            $total_attendance = ($sample_row->attendance_days - ($sample_row->casual_leave+$sample_row->sick_leave+$sample_row->general_festival_days+$sample_row->holidays));
                                        @endphp
                                        {{-- <td class=" text-center border-0">{{ ($sample_row->attendance_days - ($sample_row->casual_leave+$sample_row->sick_leave+$sample_row->general_festival_days+$sample_row->holidays)) }}</td> --}}
                                        <td class=" text-center border-0">{{ ($sample_row->month_days - $holidays_diff) }}</td>
                                        {{-- <td class=" text-center border-0">{{ ($sample_row->working_days) }}</td> --}}
                                        <td class=" text-center border-0">{{ $holidays_diff }}</td>
                                        <td class=" text-center border-0">{{ $sample_row->absent_days }}</td>
                                        <td class=" text-center border-0">{{ $sample_row->casual_leave }}</td>
                                        <td class=" text-center border-0">{{ $sample_row->sick_leave }}</td>
                                        {{-- <td class=" text-center border-0">{{ $sample_row->late_days }}</td> --}}
                                        <td class=" text-center border-1">{{ ($sample_row->casual_leave+$sample_row->sick_leave) }}</td>
                                        <td class=" text-center border-1">{{ $sample_row->leave_withoutpay_days }}</td>
                                        {{-- <td class=" text-center border-0">{{ $sample_row->leave_withoutpay_days }}</td> --}}
                                        <td class=" text-center border-1">{{ $sample_row->general_festival_days }}</td>
                                        <td class=" text-center border-1" style="border-bottom: 1px solid #333;">{{ $sample_row->month_days - $sample_row->absent_days - $sample_row->leave_withoutpay_days }}</td>
                                        <td class=" text-center border-1" style="border-bottom: 1px solid #333;">{{ $sample_row->month_days - $sample_row->absent_days - $sample_row->leave_withoutpay_days }}</td>
                                        {{-- <td class=" text-center border-1" style="border-bottom: 1px solid #333;">{{ ((($total_attendance+$holidays_diff+$sample_row->general_festival_days+$sample_row->casual_leave+$sample_row->sick_leave) - ($sample_row->absent_days+$sample_row->leave_withoutpay_days))) }}</td> --}}
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
