<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $type }} Report</title>
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

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <!-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> -->
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    {{ $type }} Report with Payment History
                </span>
            </div>
            @if ($type != 'Total Patient')
                <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                    <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                            class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                    </span>
                </div>
            @endif

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%; border-collapse: collapse;" cellpadding="4">
                        <thead>
                            <tr style="background-color: #E3E3E3; text-align:center;">
                                <th style="border:1px solid #222;">SL</th>
                                <th style="border:1px solid #222;">Admission ID</th>
                                <th style="border:1px solid #222;">
                                    {{ Session::get('user.ses_hospital_code') == "KPJ" ? "MRN" : "UIHD" }}
                                </th>
                                <th style="border:1px solid #222; width:150px;">Patient Name</th>
                                <th style="border:1px solid #222;">Bed Information</th>
                                <th style="border:1px solid #222;">Admission Date</th>
                                <th style="border:1px solid #222;">Discharge Date</th>
                    
                                <!-- Payment History columns -->
                                <th style="border:1px solid #222;">Total Bill</th>
                                <th style="border:1px solid #222;">Discount</th>
                                <th style="border:1px solid #222;">Payable</th>
                                <th style="border:1px solid #222;">Paid</th>
                                <th style="border:1px solid #222;">Due</th>
                                {{-- <th style="border:1px solid #222;">Advance</th> --}}
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach ($report_data as $value)
                                <tr style="text-align:center;">
                                    <td style="border:1px solid #222;">{{ $loop->iteration }}</td>
                                    <td style="border:1px solid #222;">{{ strtoupper($value->admission_uid ?? '') }}</td>
                                    <td style="border:1px solid #222;">{{ strtoupper($value->patient_code ?? '') }}</td>
                                    <td style="border:1px solid #222;">{{ strtoupper($value->patient_name ?? '') }}</td>
                                    <td style="border:1px solid #222;">
                                        {{ !empty($value->new_bed_name) ? strtoupper($value->new_bed_name) : $value->bed_name }}
                                    </td>
                                    <td style="border:1px solid #222;">
                                        {{ !empty($value->admission_date) ? date('d/m/Y h:i a', strtotime($value->admission_date)) : 'N/A' }}
                                    </td>
                                    <td style="border:1px solid #222;">
                                        {{ !empty($value->dis_datetime) ? date('d/m/Y h:i a', strtotime($value->dis_datetime)) : 'N/A' }}
                                    </td>
                    
                                    <!-- Payment columns -->
                                    <td style="border:1px solid #222;">{{ number_format($value->total_sales ?? 0, 2) }}</td>
                                    <td style="border:1px solid #222;">{{ number_format($value->total_discount ?? 0, 2) }}</td>
                                    <td style="border:1px solid #222;">{{ number_format($value->total_payable ?? 0, 2) }}</td>
                                    <td style="border:1px solid #222;">{{ number_format($value->total_payment ?? 0, 2) }}</td>
                                    <td style="border:1px solid #222;">{{ number_format($value->total_due ?? 0, 2) }}</td>
                                    {{-- <td style="border:1px solid #222;">{{ number_format($value->advance ?? 0, 2) }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    
                        <tfoot>
                            @php
                                $total_sales = $report_data->sum('total_sales') ?? 0;
                                $total_discount = $report_data->sum('total_discount') ?? 0;
                                $total_payable = $report_data->sum('total_payable') ?? 0;
                                $total_payment = $report_data->sum('total_payment') ?? 0;
                                $total_due = $report_data->sum('total_due') ?? 0;
                                // $total_advance = $report_data->sum('advance') ?? 0;
                            @endphp
                    
                            <tr style="background-color:#F2F2F2; font-weight:bold; text-align:center;">
                                <td colspan="7" style="border:1px solid #222; text-align:right;">Total</td>
                                <td style="border:1px solid #222;">{{ number_format($total_sales, 2) }}</td>
                                <td style="border:1px solid #222;">{{ number_format($total_discount, 2) }}</td>
                                <td style="border:1px solid #222;">{{ number_format($total_payable, 2) }}</td>
                                <td style="border:1px solid #222;">{{ number_format($total_payment, 2) }}</td>
                                <td style="border:1px solid #222;">{{ number_format($total_due, 2) }}</td>
                                {{-- <td style="border:1px solid #222;">{{ number_format($total_advance, 2) }}</td> --}}
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
            </section>
        </div>
    </main>





</body>

</html>
