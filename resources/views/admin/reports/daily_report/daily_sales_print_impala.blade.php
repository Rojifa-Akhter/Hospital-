<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daily {{ $type }} Report</title>
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
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
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
    </div>



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
                               {{ date('d/m/Y') }} {{$date}}
                            </strong> Printed By: <strong>{{Session::get('user.ses_user_name')}}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen] </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Daily
                    {{ $type }} Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    {{-- @php --}}
                    {{-- $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = 0 --}}
                    {{-- @endphp --}}
                    {{-- <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0"> --}}
                    {{-- <thead class="bg-soft-green"> --}}
                    {{-- <tr> --}}
                    {{-- <th class="text-left" scope="col" style="width: 70px;">Date</th> --}}
                    {{-- <th class="text-left" scope="col">Total No of Invoice</th> --}}
                    {{-- <th class="text-left" scope="col">Total No of Consultation</th> --}}
                    {{-- <th class="text-left" scope="col">Referral</th> --}}
                    {{-- <th scope="col" class="text-right">No of Service</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Service Referral</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Payable</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Discount</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Net Payable</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Paid</th> --}}
                    {{-- <th scope="col" class="text-right" style="text-align: right;">Due</th> --}}
                    {{-- </tr> --}}
                    {{-- </thead> --}}
                    {{-- <br> --}}
                    {{-- <tbody> --}}
                    {{-- @if (!empty($report_data)) --}}
                    {{-- @foreach ($report_data as $row) --}}
                    {{-- <tr> --}}
                    {{-- <td class="text-left" scope="col" --}}
                    {{-- style="text-align: center;">{{ date('d/m/Y',strtotime($row->invo_date)) }}</td> --}}
                    {{-- <td class="text-left" scope="col" --}}
                    {{-- style="text-align: center;">{{ $row->total_invoice_cnt }}</td> --}}
                    {{-- <td class="text-left" scope="col" --}}
                    {{-- style="text-align: center;">{{ $row->total_consult_cnt }}</td> --}}
                    {{-- <td class="text-left" scope="col" --}}
                    {{-- style="text-align: center;">{{ $row->total_consult_cnt }}</td> --}}
                    {{--  --}}{{-- <td class="text-center" scope="col">Azizul Hakim</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->payable, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->discount, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->net_payable, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" --}}
                    {{-- style="text-align: right;">{{ number_format($row->paid, 2) }}</td> --}}
                    {{-- <td scope="col" --}}
                    {{-- class="text-right" style="text-align: right;">{{ number_format($row->due, 2) }}</td> --}}
                    {{-- </tr> --}}
                    {{-- @php --}}
                    {{-- $total_payable += $row->ledgerdtl_amt_sales_service; --}}
                    {{-- $total_discount += $row->ledgerdtl_amt_sales_others; --}}
                    {{-- $total_net_payable += $row->net_payable; --}}
                    {{-- $total_paid += $row->paid; --}}
                    {{-- $total_due += $row->due --}}
                    {{-- @endphp --}}
                    {{-- @endforeach --}}
                    {{-- @endif --}}
                    {{-- </tbody> --}}
                    {{-- <tfoot> --}}
                    {{-- <tr> --}}
                    {{-- <th class="text-right" scope="col" colspan="6" style="text-align: right;">Total =</th> --}}
                    {{-- <th scope="col" --}}
                    {{-- class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_payable,2,".","") }}</th> --}}
                    {{-- <th scope="col" --}}
                    {{-- class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_discount,2,".","") }}</th> --}}
                    {{-- <th scope="col" --}}
                    {{-- class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_net_payable,2,".","") }}</th> --}}
                    {{-- <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_paid,2,".","") }}</th> --}}
                    {{-- <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($total_due,2,".","") }}</th> --}}
                    {{-- <th class="text-center" scope="col" style="width: 80px;"></th> --}}
                    {{-- </tr> --}}
                    {{-- </tfoot> --}}
                    {{-- </table> --}}
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <thead class="bg-soft-green">
                            <tr class="table-tr" style="background-color: #111; color:white;">
                                <th class="text-center" scope="col" style="text-align: center;">Sl</th>
                                <th class="text-center table-td" scope="col" style="text-align: center;">Voucher
                                </th>
                                <th class="text-center table-td" scope="col" style="text-align: left;">Date</th>
                                <th class="text-left table-td" scope="col" style="text-align: left;">Patient Code</th>
                                <th class="text-left table-td" scope="col" style="text-align: left;">Patient Info</th>
                                {{-- <th class="text-left" scope="col" style="width: 5%;">Age</th>
                                <th class="text-left" scope="col" style="width: 5%;">Gender</th>
                                <th class="text-center" scope="col" style="width: 5%;text-align: center;">Contact --}}
                                </th>
                                <th class="text-right table-td" scope="col" style="text-align: left;">Item name
                                </th>
                                {{-- @if ($type == 'Sales') --}}
                                <th class="text-right table-td" scope="col" style="text-align: right;">Subtotal
                                </th>
                                <th class="text-right table-td" scope="col" style="text-align: right;">Consultation
                                </th>
                                <th class="text-right table-td" scope="col" style="text-align: right;">physiotherapy</th>
                                {{-- <th scope="col" class="text-right table-td" style="text-align: right;">Radiology</th>
                                <th scope="col" class="text-right table-td" style="text-align: right;">Hospital</th> --}}
                                <th scope="col" class="text-right table-td" style="text-align: right;">Others</th>
                                {{-- <th scope="col" class="text-right table-td" style="text-align: right;">Ambulance</th> --}}
                                <th scope="col" class="text-right table-td" style="text-align: right;">Service</th>
                                <th scope="col" class="text-right table-td" style="text-align: right;"></th>
                                {{-- @elseif($type == 'Collection') --}}
                                {{-- <th class="text-right" scope="col">Collection</th> --}}
                                {{-- <th scope="col" class="text-right">Discount</th> --}}
                                {{-- <th scope="col" class="text-right">Refund</th> --}}
                                {{-- <th scope="col" class="text-right">Others</th> --}}
                                {{-- @elseif($type == 'Discount') --}}
                                {{-- <th class="text-right" scope="col">Hospital</th> --}}
                                {{-- <th scope="col" class="text-right">Doctor</th> --}}
                                {{-- <th scope="col" class="text-right">Others</th> --}}

                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <br>
                        <tbody>
                            @php
                                $total_consultation = $total_service = $total_positem = $total_pathology = $total_radiology = $total_hospital = $total_others = $total_amb = $total_service = $sub_total_consultation = $sub_total_pathology = $sub_total_others = $sub_total_service = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $key => $row)
                                    <tr>
                                        <td class="border-1 bg-light text-center" style="text-align: center;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-left" style="text-align: center;">
                                            {{ $row->invoice_code }}</td>
                                        <td class="text-left" style="text-align: center;">
                                            {{ date('d/m/Y', strtotime($row->invc_date)) }}</td>
                                        <td class="text-left" style="text-align: center;">
                                            {{ $row->patient_code }}</td>
                                        <td class="text-left">
                                            <div>{{ $row->patient_name }}</div>
                                            <div>{{ $row->age }}</div>
                                            <div>{{ $row->gender }}</div>
                                            <div>{{ $row->mobile }}</div>
                                        </td>
                                        <td class="text-left">
                                            {{ $row->item_name_list }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ number_format($row->ledgerdtl_amt_sales_consul + $row->ledgerdtl_amt_sales_service + $row->ledgerdtl_amt_sales_others + $row->ledgerdtl_amt_sales_path, 2) }}</td>

                                        @if ($type === 'Sales')
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_consul, 2) }}</td>
                                            {{-- <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td> --}}
                                            {{-- <td class="text-right">{{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_path, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_rad, 2) }}</td> --}}
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_hos, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_others, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_amb, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_sales_service, 2) }}</td>
                                        @elseif($type === 'Collection')
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_consul, 2) }}</td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_path, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_rad, 2) }}</td> --}}
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_hos, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_others, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_amb, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_payment_service, 2) }}</td>


                                            {{-- <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_consul, 2) }}</td> --}}
                                            {{-- <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_service, 2) }}</td> --}}
                                            {{-- <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment_others, 2) }}</td> --}}
                                        @elseif($type === 'Discount')
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_consul, 2) }}</td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_path, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_rad, 2) }}</td> --}}
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_hos, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_others, 2) }}</td>
                                            {{-- <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_amb, 2) }}</td> --}}
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($row->ledgerdtl_amt_discount_service, 2) }}</td>
                                        @endif
                                    </tr>

                                    @if ($type === 'Sales')
                                        @php
                                            $total_consultation += $row->ledgerdtl_amt_sales_consul;
                                            $total_pathology += $row->ledgerdtl_amt_sales_path;
                                            $total_radiology += $row->ledgerdtl_amt_sales_rad;
                                            $total_hospital += $row->ledgerdtl_amt_sales_hos;
                                            $total_others += $row->ledgerdtl_amt_sales_others;
                                            $total_amb += $row->ledgerdtl_amt_sales_amb;
                                            $total_service += $row->ledgerdtl_amt_sales_service;
                                        @endphp
                                    @elseif($type === 'Collection')
                                        @php
                                            $total_consultation += $row->ledgerdtl_amt_payment_consul;
                                            $total_pathology += $row->ledgerdtl_amt_payment_path;
                                            $total_radiology += $row->ledgerdtl_amt_payment_rad;
                                            $total_hospital += $row->ledgerdtl_amt_payment_hos;
                                            $total_others += $row->ledgerdtl_amt_payment_others;
                                            $total_amb += $row->ledgerdtl_amt_payment_amb;
                                            $total_service += $row->ledgerdtl_amt_payment_service;
                                        @endphp
                                    @elseif($type === 'Discount')
                                        @php
                                            $total_consultation += $row->ledgerdtl_amt_discount_consul;
                                            $total_pathology += $row->ledgerdtl_amt_discount_path;
                                            $total_radiology += $row->ledgerdtl_amt_discount_rad;
                                            $total_hospital += $row->ledgerdtl_amt_discount_hos;
                                            $total_others += $row->ledgerdtl_amt_discount_others;
                                            $total_amb += $row->ledgerdtl_amt_discount_amb;
                                            $total_service += $row->ledgerdtl_amt_discount_service;
                                        @endphp
                                    @endif
                                    @php
                                        $sub_total_consultation += $row->ledgerdtl_amt_sales_consul;
                                        $sub_total_pathology += $row->ledgerdtl_amt_sales_path;
                                        // $total_radiology += $row->ledgerdtl_amt_sales_rad;
                                        // $total_hospital += $row->ledgerdtl_amt_sales_hos;
                                        $sub_total_others += $row->ledgerdtl_amt_sales_others;
                                        // $total_amb += $row->ledgerdtl_amt_sales_amb;
                                        $sub_total_service += $row->ledgerdtl_amt_sales_service;
                                    @endphp

                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" scope="col" colspan="6" style="text-align: right;">Total =
                                </th>
                                {{-- @if ($type === 'Sales') --}}
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">{{ number_format($sub_total_consultation + $sub_total_pathology + $sub_total_others + $sub_total_service,2,".","") }}</th>

                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_consultation, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_pathology, 2, '.', '') }}</th>
                                {{-- <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_radiology, 2, '.', '') }}</th> --}}
                                {{-- <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_hospital, 2, '.', '') }}</th> --}}
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_others, 2, '.', '') }}</th>
                                {{-- <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_amb, 2, '.', '') }}</th> --}}
                                <th scope="col" class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_service, 2, '.', '') }}</th>
                                {{-- @endif --}}
                                {{-- <th class="text-center" scope="col" style="width: 80px;"></th> --}}
                            </tr>
                            <tr>
                                <th class="text-right" class="text-right bg-light-green" scope="col" colspan="4"
                                    style="text-align: right;">Total All @if ($type === 'Sales')Sales  @elseif($type === 'Collection') Collection   @elseif($type === 'Discount') Discount @endif= </th>
                                <th scope="col" colspan="7">
                                    {{ number_format($total_consultation +$total_pathology +$total_radiology +$total_hospital +$total_others +$total_amb +$total_service,2,'.','') }}
                                </th>
                                <th class="text-center" scope="col" style="width: 80px; text-align: center;"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>





</body>

</html>
