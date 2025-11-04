<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pharmacy Card Payment Details Report</title>
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
                  style="width:70%; border:solid black 1px; padding:10px;  ">Pharmacy Card Payment Details Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> -  <span
                    class="report-date"><strong>To Date: {{ $to_date }}</strong>
            </span>
        </div>
        <section id="lp-items">
            <div class="container">

                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col">Voucher Id</th>
                        <th class="text-center" scope="col" style="width:62px;">Voucher Date</th>
                        <th class="text-center" scope="col">Patient</th>
                        <th class="text-center" scope="col">Age</th>
                        <th class="text-center" scope="col">Gender</th>
                        <th class="text-center" scope="col">Contact</th>
                        <th class="text-center" scope="col">Doctor</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right">Payable</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right">Discount</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right">Net Payable</th>
                        <th scope="col" class="text-right bg-light-blue">Card Description</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: center">Card Paid</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right">Service Charge</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right">Net Collection</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_payable = $total_discount = $total_net_payable= $total_card_paid = $service_charge = $total_net_collection = 0;
                    @endphp
                    @if(!empty($report_data))
                        @foreach($report_data as $key=>$row)
                            <tr>
                                <td class="text-center bg-light" style="text-align: center">{{ $loop->iteration }}</td>

                                <td class="text-center" style="text-align: center;">{{$row->invoice_code}} </td>
                                <td class="text-center" width="80px" style="text-align: center;">{{ date("d/m/Y",strtotime($row->invoice_date)) }}</td>

                                <td class="text-left" style="text-align: center"><strong>{{ !empty($row->patient_name)?$row->patient_name :"N/A" }}</strong></td>
                                <td class="text-left" style="word-break: break-all;text-align: center; width: 60px;">{{ !empty($row->age)?$row->age :"N/A" }}</td>
                                <td class="text-left" style="text-align: center">{{ !empty($row->gender_txt)?$row->gender_txt :"N/A" }}</td>
                                <td class="text-left" style="text-align: center">{{ !empty($row->mobile1)?$row->mobile1 :"N/A" }}</td>
                                <td class="text-left" style="text-align: center">{{ !empty($row->doctor_name)?$row->doctor_name :"N/A" }}</td>
                                <td class="text-right bg-light" style="text-align: right;">{{ number_format($row->ledger_amt_sales, 2,".","") }}</td>
                                <td class="text-right bg-light" style="text-align: right;">{{ number_format($row->ledger_amt_discount, 2,".","") }}</td>
                                {{--                    <td class="text-right bg-light">{{ number_format($row->net_payable, 2,".","") }}</td>--}}
                                <?php $net_payable = number_format($row->ledger_amt_sales, 2,".","") - number_format($row->ledger_amt_discount, 2,".",""); ?>
                                <td class="text-right" style="text-align: right;">{{ number_format($net_payable, 2,".","") }}</td>
                                <td class="text-right">
                                    <div><strong>Pay Mode:</strong>{{!empty($row->pay_mood_type)?$row->pay_mood_type:''}}</div>
                                    <div><strong>Bank Name:</strong>{{$row->bank_name}}</div>
                                    <div><strong>Transaction Id:</strong>{{$row->transaction_id}}</div>
                                    <div><strong>Acc. Holder Name:</strong>{{$row->acc_holder_name}}</div>
                                </td>
                                <td style="text-align: right;">{{ number_format($row->card_payment, 2,".","")}}</td>
                                <td class="text-right bg-light" style="text-align: right;">{{ number_format($row->bank_service_charge, 2,".","") }}</td>
                                <?php $net_collection = number_format($row->card_payment, 2,".","") - number_format($row->bank_service_charge, 2,".",""); ?>
                                <td class="text-right bg-light" style="text-align: right;">{{ number_format($net_collection, 2,".","") }} </td>


                            </tr>
                            @php
                                $total_payable += $row->ledger_amt_sales;
                                $total_discount += $row->ledger_amt_discount;
                                $total_net_payable += $net_payable;
                                $total_net_collection += $net_collection;
                                $service_charge += $row->bank_service_charge;
                                $total_card_paid += $row->card_payment;
                            @endphp
                        @endforeach
                    @else
                        <tr>
                            <th class="text-center" scope="col" colspan="14">No Data Available</th>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-right" scope="col" colspan="8" style="text-align: right;">Total = </th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_payable,2,".","") }}</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_discount,2,".","") }}</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_net_payable,2,".","") }}</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;" colspan="2">{{ number_format($total_card_paid,2,".","") }}</th>
                        <th scope="col" class="text-right bg-light-blue"  style="text-align: right;">{{ number_format($service_charge,2,".","") }}</th>
                        <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_net_collection,2,".","") }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
