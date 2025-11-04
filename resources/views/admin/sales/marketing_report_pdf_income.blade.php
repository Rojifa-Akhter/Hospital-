<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IPD Patient Wise Daily & Monthly Income Summary Report</title>
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
            font-size: 9px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            /* border-bottom: 1px solid; */
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
            /* border-top: 1px solid; */
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
            width: 100%
        }

        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    {{-- <header>
        <div style="text-align: center; padding:5px">
            <strong>
                <h1> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
            </strong>
            <strong>
                <h2>Marketing Department</h2>
            </strong>
            <strong>
                <h2>Month Wise OPD & IPD Patients</h2>
            </strong>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To
                        Date: {{ $to_date }}</strong>
                </span>
        </div>

    </header> --}}
    <header>
        <div class="signature" style="display: flex; justify-content: space-between; width: 100%;">
            <div style="width: 15%; text-align: left;">
                @if (!empty($po_hospital_details->logo))
                    <img class="hospital-logo"
                         src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                         width="60" alt="">
                @endif
            </div>
            <div style="text-align: center; flex-grow: 1;">
                <span style="font-size: 15px;"> 
                    <strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
                </span> <br>
                Address: <span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                Phone No: <span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
            </div>
            <div style="width: 15%; text-align: right;">
            </div>
        </div>
    </header>
    

    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; ">
            <h2>Marketing Department <span>(IPD Patient Wise Daily & Monthly Income Summary)</span></h2>

            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To
                        Date: {{ $to_date }}</strong>
                </span>
        </div>
    </div>

    <footer>
        <div class="footer">
            <div class="container" style="width: 100%; padding: 3px; margin: 0;">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9px; text-align: left;">
                        Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y H:m:s');
                            @endphp
                            {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong>
                    </div>
                    <div style="font-size: 9px; text-align: right;">
                        <strong>Powered By - H360 [NextGenIT]</strong>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    

    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <table class="table table-bordered table-striped mb-0 data-table">
                        <thead class="sticky_header">
                            <tr class="bg-light-blue">
                                <th class="text-center">SL#</th>
                                {{-- <th class="text-center">Invoice Date</th> --}}
                                <th class="text-center">UHID</th>
                                <th class="text-center">Admission ID</th>
                                <th class="text-center">Patient Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Sales</th>
                                <th class="text-center">Sales Cancel</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Discount Refund</th>
                                <th class="text-center">Collection</th>
                                <th class="text-center">Refund</th>
                                <th class="text-center">Net Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_sales = 0;
                                $total_salescancel = 0;
                                $total_discount = 0;
                                $total_discount_refund = 0;
                                $total_payment = 0;
                                $total_refund = 0;
                                $total_net_collection = 0;

                            @endphp
                            @if (!empty($data))


                                @foreach ($data as $value)
                                    <tr>
                                        <td class="text-right">{{ $loop->iteration }}</td>
                                        {{-- <td class="text-left">
                                            {{ date('d/m/y', strtotime($value->ledger_date)) }}
                                        </td> --}}
                                        <td class="text-center">{{ $value->patient_code }}</td>
                                        <td class="text-center">{{ $value->admission_no_pk }}</td>
                                        <td class="text-left">{{ $value->patient_name }}</td>
                                        <td class="text-left">{{ $value->department }}</td>
                                        <td class="text-right">{{ number_format($value->sales, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->salescancel, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->discount, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->discount_refund, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->payment, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->refund, 2) }}</td>
                                        <td class="text-right">{{ number_format($value->payment - $value->refund, 2) }}
                                        </td>
                                        <!-- You can calculate Total if needed -->

                                        @php
                                            $total_sales += $value->sales;
                                            $total_salescancel += $value->salescancel;
                                            $total_discount += $value->discount;
                                            $total_discount_refund += $value->discount_refund;
                                            $total_payment += $value->payment;
                                            $total_refund += $value->refund;
                                            $total_net_collection += $value->payment - $value->refund;
                                        @endphp
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-light-blue">
                                <td class="text-right" colspan="5"><strong>Total</strong></td>
                                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                                <td class="text-right">{{ number_format($total_salescancel, 2) }}</td>
                                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                                <td class="text-right">{{ number_format($total_discount_refund, 2) }}</td>
                                <td class="text-right">{{ number_format($total_payment, 2) }}</td>
                                <td class="text-right">{{ number_format($total_refund, 2) }}</td>
                                <td class="text-right">{{ number_format($total_net_collection, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </section>
        </div>
    </main>
    <footer class="">
        {{-- <div class="footer">
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
        </div> --}}
    </footer>


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        // window.close(); // Close the window after printing
    }
</script>
