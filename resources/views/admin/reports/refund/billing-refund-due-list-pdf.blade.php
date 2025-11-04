<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }

</style>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Billing Refund Report</title>
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
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                </td>
                <td style="">
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

<div class="signature_">
    {{-- <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table> --}}
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
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">Billing Refund Report </span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <table>
                <tr>
                    <td colspan="2">
                        <span class="report-date"><strong> From Date: </strong> {{$from_date}} </span>
                        <span class="report-date"><strong> To Date: </strong> {{$to_date}} </span>
                    </td>
                </tr>
            </table>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th class="text-center" scope="col">SL</th>
                                @if ($type == 'Refund')
                                    <th class="text-center" scope="col">Voucher</th>
                                @else
                                @if ($report_type != 'OPD')
                                    <th class="text-center" scope="col">Admission ID</th>
                                    @else
                                    <th class="text-center" scope="col">Voucher</th>
                                    @endif
                                @endif


                                <th class="text-center" scope="col" style="width:62px;">Date</th>
                                @if ($type == 'Refund')
                                <th class="text-center" scope="col">Cashier name</th>
                                @endif
                                <th class="text-center" scope="col">Patient</th>
                                {{-- <th class="text-center" scope="col">Age</th> --}}
                                {{-- <th class="text-center" scope="col">Gender</th> --}}
                                <th class="text-center" scope="col">Contact</th>
                                @if ($type == 'Refund')
                                    <th class="text-center" scope="col">Doctor</th>
                                @endif

                                <th class="text-right" scope="col">
                                    @if ($type == 'Refund')
                                        Refund
                                    @else
                                        Due
                                    @endif
                                </th>
                        </tr>
                    </thead>

                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                        @php
                        $total_tk = 0;
                    @endphp
                    @if (!empty($report_data))
                    @foreach ($report_data as $row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        @if ($report_type != 'OPD')
                            <td class="text-left">{{ $row->admission_no_pk }} </td>
                            <td class="text-left" width="80px">
                                <div>{{ date('d/m/Y', strtotime($row->admission_date)) }}</div>
                            </td>
                        @else
                            <td class="text-left">{{ $row->invoice_no_pk }} </td>
                            <td class="text-left" width="80px">
                                <div>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</div>
                            </td>
                        @endif

                        @if ($type == 'Refund')
                        <td class="text-left">{{ $row->cashier_name }}</td>
                        @endif

                        <td class="text-left">
                            <div><strong>{{ $row->patient_no_pk }}</strong></div>
                            <div>{{ $row->patient_name }}</div>
                        </td>
                        {{-- <td class="text-left" style="word-break: break-all; width: 60px;">{{ $row->age }} --}}
                        </td>
                        {{-- <td class="text-left">{{ $row->gender_txt }}</td>--}}
                        <td class="text-left">{{ $row->mobile1 }}</td>
                        @if ($type == 'Refund')
                            <td class="text-left">{{ $row->full_name }}</td>
                        @endif


                        <td class="text-right bg-light" style="text-align: right;" id="refund">
                            @if ($type == 'Refund')
                                {{ number_format($row->refund, 2, '.', '') }}
                            @else
                                {{ number_format($row->due, 2, '.', '') }}
                            @endif
                        </td>

                    </tr>
                    @php
                        if ($type == 'Refund') {
                            $total_tk += $row->refund;
                        } else {
                            $total_tk += $row->due;
                        }

                    @endphp
                @endforeach
                    @endif
                    {{-- </tbody> --}}
                    <tr>
                        <th class="text-right" scope="col" colspan="7" style="text-align:right;">Total =
                        </th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                            {{ number_format($total_tk, 2, '.', '') }}</th>
                    </tr>

                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>
