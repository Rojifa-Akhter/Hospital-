<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OPD Report</title>
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> OPD Report</span>
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
                    <table style="width:100%; border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <tr class="bg-light-blue">
                            <th class="text-center">SL</th>
                            {{-- <th class="text-center">Date</th> --}}
                            <th class="text-center">Department</th>
                            {{-- <th class="text-center">Doctor Name</th> --}}
                            <th class="text-center">Total Patient</th>
                            <th class="text-center">New Patient</th>
                            <th class="text-center">Follow Up</th>
                            <th class="text-center">Corporate</th>
                            <th class="text-center">Academic/Free</th>
                            @if (session('user.financial_ind') == 1)
                                <th class="text-center">Sales</th>
                                <th class="text-center">Discount Amount</th>
                                <th class="text-center">Total Amount</th>
                            @endif
                        </tr>
                        <tbody> 
                            @php
                                $total_followup = $total_patient = $total_sales = $general_quantity = $corporate_pt = $student_pt = $total_dis = $total_payment = $final_academic_qty = $final_academic_amt = $final_corporate_qty = $final_corporate_amt = $final_qty = $final_amt = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $dt)
                                    @php
                                        $collection = $dt->ledger_amt_sales - $dt->ledger_amt_discount;
                                        $total_patient += $dt->patient_cnt_total;
                                        $total_followup += $dt->patient_cnt_followup;
                                        $general_quantity += $dt->patient_cnt_newcons;
                                        $corporate_pt += $dt->patient_cnt_corporate;
                                        $student_pt += $dt->patient_cnt_free_aca;
                                        $total_dis += $dt->ledger_amt_discount;
                                        $total_payment += $dt->ledger_amt_payment;
                                        $total_sales += $dt->ledger_amt_sales;
                                    @endphp
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        {{-- <td>{{ date('d/m/y', strtotime( $dt->appoint_date)) }}</td> --}}
                                        <td style="text-align: left;">{{ $dt->serviceunit_name }}</td>
                                        {{-- <td>{{ 'N/A' }}</td> --}}
                                        <td style="text-align: center;">{{ $dt->patient_cnt_total }}</td>
                                        <td style="text-align: center;">{{ $dt->patient_cnt_newcons }}</td>
                                        <td style="text-align: center;">{{ $dt->patient_cnt_followup }}</td>
                                        <td style="text-align: center;">{{ $dt->patient_cnt_corporate }}</td>
                                        <td style="text-align: center;">{{ $dt->patient_cnt_free_aca }}</td>
                                        @if (session('user.financial_ind') == 1)
                                            <td style="text-align: right;">
                                                {{ number_format($dt->ledger_amt_sales, 2) }}</td>
                                            <td style="text-align:right;">
                                                {{ number_format($dt->ledger_amt_discount, 2) }}</td>
                                            <td style="text-align:right;">
                                                {{ number_format($dt->ledger_amt_payment, 2) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="2" style="text-align:right;">Sub Total =</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_patient }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $general_quantity }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_followup }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $corporate_pt }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $student_pt }}</th>
                                @if (session('user.financial_ind') == 1)
                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_sales, 2) }}</th>
                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_dis, 2) }}</th>
                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_payment, 2) }}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
