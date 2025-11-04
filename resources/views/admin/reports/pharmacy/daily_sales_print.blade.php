<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daily Pharmacy {{$type}}  Report</title>
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
    </style>
</head>

<body>
<header>
    <table style="width: 100%;" class="signature">
        <tr>
            <td style="width: 15%;">
                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60" alt="">
            </td>
            <td style="text-align:center;">
                <span
                    style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span>
                <br>
                Address:
                <span>  {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span><br>
                Phone No:
                <span>  {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span>
            </td>
            <td style=" text-align:right; width: 15%; ">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100"/>
                </div>

            </td>
        </tr>
    </table>
</header>

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name"
                  style="width:70%; border:solid black 1px; padding:10px;  "> Daily Pharmacy {{$type}}  Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> -  <span
                    class="report-date"><strong>To Date: {{ $to_date }}</strong>
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" class="table data-table table-striped table-bordered table-hover table-responsive">
                    <thead class="bg-soft-green">
                    <tr>
                        <th class="text-center" scope="col" style="text-align: center;">Sl</th>
                        <th class="text-center" scope="col"style="text-align: center;" >Voucher</th>
                        <th class="text-center" scope="col" style="text-align: center;">Date</th>
                        <th class="text-left" scope="col" style="text-align: left;">Patient</th>
                        <th class="text-left" scope="col" style="text-align: left;">Age</th>
                        <th class="text-left" scope="col" style="text-align: left;">Gender</th>
                        <th class="text-center" scope="col" style="text-align: center;">Contact</th>
                        <th class="text-right" scope="col" style="text-align: right;">Pharmacy</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $total_sales = $total_payment = $total_discount =  0;
                    @endphp
                    @if(!empty($report_data))
                        @foreach($report_data as $key=>$row)
                            <tr>
                                <td class="text-center" style="text-align: center;">{{ $loop->iteration }}</td>
                                <td class="text-center" style="text-align: center;">{{ $row->invoice_code }}</td>
                                <td class="text-left" style="text-align: center;">{{ date("d/m/Y", strtotime($row->invc_date)) }}</td>
                                <td class="text-left" style="text-align: left;"><strong>{{ $row->patient_code }}</strong> : {{ $row->patient_name }}</td>
                                <td class="text-left" style="text-align: left;">{{ $row->age }}</td>
                                <td class="text-left" style="text-align: left;">{{ $row->gender }}</td>
                                <td class="text-left" style="text-align: center;">{{ $row->mobile }}</td>
                                @if($type === 'Sales')
                                    <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_med, 2) }}</td>
                                @elseif($type === 'Collection')
                                    <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_payment_med, 2) }}</td>
                                @elseif($type === 'Discount')
                                    <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_discount_med, 2) }}</td>
                                @endif
                            </tr>
                            @if($type === 'Sales')
                                @php
                                    $total_sales += $row->ledgerdtl_amt_sales_med;
                                @endphp
                            @elseif($type === 'Collection')
                                @php
                                    $total_payment += $row->ledgerdtl_amt_payment_med;
                                @endphp
                            @elseif($type === 'Discount')
                                @php
                                    $total_discount += $row->ledgerdtl_amt_discount_med;
                                @endphp
                            @endif
                        @endforeach
                    @else

                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-right" scope="col" style="text-align: right;" colspan="7">Total = </th>
                        @if($type === 'Sales')
                            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format( $total_sales,2,".","") }}</th>
                        @elseif($type === 'Collection')
                            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_payment,2,".","") }}</th>
                        @elseif($type === 'Discount')
                            <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_discount,2,".","") }}</th>
                        @endif
                    </tr>

                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
