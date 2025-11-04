<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shift Wise Doctor Performance Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
            border-bottom: 1px solid;
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

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
                    @if (!empty($po_hospital_details->logo))
                        {{-- <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt=""> --}}
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="200" height="40" /> --}}
                    </div>
                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px; ">Shift Wise Doctor Performance Report</span>
        </div>

        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To Date: {{ $to_date }}</strong>
            </span>
        </div>
    </div>

    {{-- <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div> --}}

    <footer class="">
        <div class="footer ">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <table class="table data-table table-bordered table-hover table-striped" style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="bg-primary" style="background-color: #E3E3E3;">
                            <tr>
                                <th class="text-center">Sl#</th>
                                <th class="text-center">Department Name</th>
                                <th class="text-center">Doctor's Name</th>
                                <th class="text-center">Morning</th>
                                <th class="text-center">Evening</th>
                                <th class="text-center">Total Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                                $morning = 0;
                                $evening = 0;
                                $total = 0;
                            @endphp
                            @if (!empty($result))
                                @foreach($result as $department => $data) 
                                    @foreach($data as $idx => $row)
                                        @php
                                            $morning += $row->morning;
                                            $evening += $row->evening;
                                            $total += $row->total_patient;
                                        @endphp
                                        <tr>
                                            @if($idx == 0)
                                                <td class="text-left" style="text-align: center;" rowspan="{{ count($data) }}">{{ ++$i }}</td>
                                                <td class="text-left" rowspan="{{ count($data) }}" style="vertical-align: middle;">{{ $row->su_name }}</td>
                                            @endif
                                            <td class="text-left">{{ $row->full_name }}</td>
                                            <td class="text-center" style="text-align: center">{{ $row->morning }}</td>
                                            <td class="text-center" style="text-align: center">{{ $row->evening }}</td>
                                            <td class="text-center" style="text-align: center">{{ $row->total_patient }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right" style="text-align: right;">Total Patient</td>
                                    <td class="text-center" style="text-align: center">{{ $morning }}</td>
                                    <td class="text-center" style="text-align: center">{{ $evening }}</td>
                                    <td class="text-center" style="text-align: center">{{ $total }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <footer class="">
        <div class="footer ">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
