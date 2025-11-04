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
                <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
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
                <td
                    style="width:18%; font-weight:bold; border:1px solid;  box-sizing: border-box; padding:10px; margin-bottom:20px">

                    <div style="float:left">
                        <span>P = Present</span><br>
                        <span>A = Absent</span><br>
                        <span>L = Leave </span><br>
                    </div>
                    <div style="float:right">
                        <span>NH = National Holiday</span><br>
                        <span style="">DO = Day Off</span><br>
                        <span style="">OL= Out Less</span>
                    </div>

                </td>
                {{-- <td style=" text-align:right; width: 15%; ">
                    <div style="">
                       <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                   </td> --}}
            </tr>
        </table>
    </header>

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
            <div style=" text-align:center; margin-bottom:10px; margin-top:20px  " class="mb-2">
                @isset($attendence_month_date)
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px; font-weight: bold"> Attendance
                    Sheet for the month of {{ date('F', strtotime($attendence_month_date)) }} -
                    {{ date('Y', strtotime($attendence_month_date)) }} </span>
                @endisset
            </div>

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;font-size:8px!important" cellpadding="1"
                        cellspacing="0" border="1" style="font-size: 9px!important;">
                        <thead>
                            <tr>
                                <th style="text-align:center" colspan="5"></th>
                                @php
                                    if (isset($from_date)) {
                                        $start_date = new DateTime($from_date);
                                        $end_date = new DateTime($to_date);
                                        for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                            echo " <th style='width:2px !important; word-wrap: break-word !important;'> " . $start_date->format('d') . '</th>';
                                            // echo $from_date->format('d') . "\n" . $from_date->format('l') . '<br>';
                                        }
                                    }
                                @endphp
                                <th style="width: 10px !important;  word-wrap: break-word!important; text-align:center;"
                                    rowspan="2">M.O.D</th>
                                <th style="width: 15px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">working-Days</th>
                                <th style=" width: 15px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">Weekend</th>
                                <th style="width: 10px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">Absent</th>
                                <th style="width: 4px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">C.L</th>
                                <th style="width: 4px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">S.L</th>
                                <th style="width: 10px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">Leave</th>
                                <th style="width: 6px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">LWP</th>
                                <th style="width: 4px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">G.F</th>
                                <th style="width: 4px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">O.T</th>
                                <th style="width: 4px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">Paid
                                    Days</th>
                                <th style="width: 10px !important;word-wrap: break-word!important; text-align:center"
                                    rowspan="2">T.W.D</th>
                            </tr>
                            <tr>
                                <th style="width:2px !important; text-align:center">Sl</th>
                                <th style="width: 15px !important;word-wrap: break-word!important; text-align:center">
                                    EID</th>
                                <th style="width: 20px !important;word-wrap: break-word!important; text-align:left">Name
                                </th>
                                <th style="width: 20px !important;word-wrap: break-word!important; text-align:left">
                                    Department</th>
                                <th style="width: 20px !important;word-wrap: break-word!important; text-align:left">
                                    Designation</th>
                                @php
                                    if (isset($from_date)) {
                                        $start_date = new DateTime($from_date);
                                        $end_date = new DateTime($to_date);
                                        for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                            echo " <th style='width:2px !important; word-wrap: break-word !important;'>" . $start_date->format('D') . '</th>';
                                            // echo $from_date->format('d') . "\n" . $from_date->format('l') . '<br>';
                                        }
                                    }
                                @endphp
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($attendance_data as $key => $data)
                                @if (isset($emp_info_arr[$data->person_no_pk]))
                                    <tr>
                                        <td style="text-align:center">{{ $key + 1 }}</td>
                                        <td
                                            style="width: 10px !important;word-wrap: break-word!important; text-align:center">
                                            {{ $data->person_card_no }}</td>
                                        <td
                                            style="width: 30px !important;word-wrap: break-word !important; text-align:left">
                                            {{ $data->full_name }}
                                        </td>
                                        <td
                                            style="width: 30px !important;word-wrap: break-word!important; text-align:left">
                                            {{ $data->serviceunit_name }}</td>
                                        <td
                                            style="width: 30px !important;word-wrap: break-word!important; text-align:left">
                                            {{ $data->designation_name }}</td>
                                        @php
                                            if (isset($from_date)) {
                                                $start_date = new DateTime($from_date);
                                                $end_date = new DateTime($to_date);
                                            }
                                        @endphp
                                        @if (isset($from_date))
                                            @for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day'))
                                                <td
                                                    style="width: 2px !important;text-align:center; word-wrap: break-word!important;">
                                                    @if (isset($attendance_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['status']))
                                                        {{ $attendance_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['status'] }}
                                                    @endif
                                                </td>
                                            @endfor
                                        @endif
                                        @php
                                            $emp_working_days = $data->working_days - ($data->absent_days + $data->leave_withoutpay_days);
                                            $holidays_diff = isset($data->holidays) ? $data->holidays : $data->month_days - $data->working_days;
                                            $total_attendance = $data->attendance_days - ($data->casual_leave + $data->sick_leave + $data->general_festival_days + $data->holidays);
                                        @endphp
                                        <td style="text-align:center;">{{ $data->month_days }}</td>
                                        <td style="text-align:center">{{ $data->month_days - $holidays_diff }}</td>
                                        <td style="text-align:center">{{ $holidays_diff }}</td>
                                        <td style="text-align:center">{{ $data->absent_days }}</td>
                                        <td style="text-align:center">{{ $data->casual_leave }}</td>
                                        <td style="text-align:center">{{ $data->sick_leave }}</td>
                                        <td style="text-align:center">{{ $data->casual_leave + $data->sick_leave }}
                                        </td>
                                        <td style="text-align:center">{{ $data->leave_withoutpay_days }}</td>
                                        <td style="text-align:center">{{ $data->general_festival_days }}</td>
                                        <td style="text-align:center">
                                            @if (isset($data->ot_time))
                                                <?php
                                                $hour = floor($data->ot_time / 60);

                                                $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                                                ?>

                                                {{ $hour }} : {{ $min }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td style="text-align:center">
                                            {{ $data->month_days - $data->absent_days - $data->leave_withoutpay_days }}
                                        </td>
                                        <td style="text-align:center">
                                            {{ $data->month_days - $data->absent_days - $data->leave_withoutpay_days }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
