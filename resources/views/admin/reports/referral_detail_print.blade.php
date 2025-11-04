<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Report</title>
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
                <img class="hospital-logo" src="{{ asset('images/kbmh.jpg') }}" width="60" alt="">
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
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Detail Wise Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> -  <span class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" >
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                                <td class="table-td"  scope="col" >
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td"  scope="col" >
                                    <strong>Code</strong></td>
                                <td class="table-td" style="width: 15%;"  scope="col" >
                                    <strong>Name</strong></td>
                                 <td class="table-td" scope="col" >
                                    <strong>Voucher</strong></td>

                                <td class="table-td" scope="col" >
                                    <strong>Date</strong></td>
                                 <td class="table-td"  style="text-align: center;"  scope="col" >
                                    <strong>Patient</strong></td>
                                <td class="table-td"  scope="col" style="text-align: right;"><strong>
                                        Sales Amount</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Collection</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Due</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Referral Amount</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Paid</strong></td>

                            </tr>
                            @if(isset($data))
                            @foreach($data as $value)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>{{$loop->iteration}}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$value->patient_code}}</strong></td>


                                <td class="table-td" style="text-align: left;" scope="col" ><strong>
                                {{$value->patient_name}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$value->voucher_no}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{!empty($value->invoice_date)?date('d/m/Y',strtotime($value->invoice_date)):''}}</strong></td>
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>{{$value->full_name}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{$value->ledger_amt_sales}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{$value->collection}}</strong></td>
                                 <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{$value->due}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{$value->referal_amount_paid}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{!empty($value->paid)? $value->paid : 0}}</strong></td>


                            </tr>
                            @endforeach
                            @endif


                        </table>
                    </div>
                </section>
            </div>
        </main>


        @include('admin.components.pdf_footer')
