<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pharmacy Report</title>
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
    {{-- <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
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
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="200" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header> --}}
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px; ">Pharmacy Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                class="report-date"><strong>To Date: {{ $to_date }}</strong>
            </span>
        </div>
    </div>

    <main class="">
        <div class="wrapper">
            <section id="lp-items ">
                <div class="container ">
                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="bg-light-blue" style="background-color: #E3E3E3">
                                <th class="text-center">SL</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">OPD</th>
                                <th class="text-center">IPD</th>
                                <th class="text-center">Emergency</th>
                                <th class="text-center">OT</th>
                                <th class="text-center">Sales</th>
                                <th class="text-center">Discount Amount</th>
                                <th class="text-center">Net Sales</th>
                                <th class="text-center">Collection</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @php
                                $total_sales = $total_discount = $total_ipd = $total_opd = $total_ot = $total_emr = $total_net_sales = $total_income_tk = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $dt)
                                    @php
                                        $total_sales += $dt->total_sales;
                                        $total_opd += $dt->opd_sales;
                                        $total_ipd += $dt->ipd_sales;
                                        $total_discount += $dt->discount;
                                        $total_net_sales += $dt->net_sales;
                                        $total_income_tk += $dt->phr_net_collection;
                                        $total_ot += $dt->ot_sales;
                                        $total_emr += $dt->emr_sales;
                                    @endphp
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align:center;">{{ date('d/m/y', strtotime($dt->ledger_date)) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->opd_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->ipd_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->emr_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->ot_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->total_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->discount, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->net_sales, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($dt->phr_net_collection, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="2" style="text-align:right;">Total =</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_opd, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_ipd, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_emr, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_ot, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_sales, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_discount, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_net_sales, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align:right;">
                                    {{ number_format($total_income_tk, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
