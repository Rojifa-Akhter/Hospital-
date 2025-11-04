<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Date Wise Cashier Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{ public_path().'css/purchase_order_print.css' }}" media="print"> --}}
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
                    @if ($po_hospital_details->hospital_code == 'GMC')
                        Cashier Wise Collection Report
                    @else
                       Pharmacy Date Wise
                        Cashier Report
                    @endif
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col">
                                <strong>SL</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong>Date</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong>Patient Name</strong>
                            </td>
                            <td class="table-td" style="text-align: center;" scope="col">
                                <strong>Invoice No</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Sales</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Discount</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Net Sales</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Collection</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Due</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Refund</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Net Collection</strong>
                            </td>

                        </tr>

                        <div style="display: none">
                            {{ $invoice_count = 0 }}
                            {{ $sales_total_final_final = 0 }}
                            {{ $sales_discount_final = 0 }}
                            {{ $collection_final = 0 }}
                            {{ $invoice_count_final = 0 }}
                            {{ $net_sales_final = 0 }}
                            {{ $due_final = 0 }}
                            {{ $refund_final = 0 }}
                            {{ $netcollection_final = 0 }}
                        </div>
                        @if (!empty($cashier_arr))
                            @foreach ($cashier_arr as $key1 => $cashier_arr1)
                                <tr>
                                    <td class="text-left" colspan="11"> <strong>User Name:
                                            {{ $key1 }}</strong></td>
                                </tr>

                                @foreach ($cashier_arr1 as $key => $value)
                                    @php
                                        $str = $key;
                                        $service_point = explode('_', $str);
                                    @endphp

                                    <tr>
                                        <td class="text-left" colspan="11">
                                            <strong> {{ $service_point[1] }} </strong>
                                        </td>
                                    </tr>

                                    <div style="display: none">

                                        {{ $sl_count = 0 }}
                                        {{ $sales_total = 0 }}
                                        {{ $sales_discount = 0 }}
                                        {{ $net_sales = 0 }}
                                        {{ $due = 0 }}
                                        {{ $collection = 0 }}
                                        {{ $refund = 0 }}
                                        {{ $net_collection = 0 }}
                                    </div>
                                    @foreach ($value as $data)
                                        {{-- <tr>
                                <td>{{ $data->invoice_code }}</td>
                                <td>{{ $data->customer_name }}</td>
                            </tr> --}}



                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
                                            <td class="text-center">
                                                {{ $data->customer_name }} <br>
                                                {{ $data->mobile1 }}

                                            </td>
                                            {{-- <td class="text-center">{{$value->counter_name}}</td> --}}
                                            <td class="text-right" style="text-align: center;">
                                                {{ $data->invoice_code }}</td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->ledger_amt_sales, 2) }}</td>

                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->ledger_amt_discount, 2) }} </td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->ledger_amt_sales_net, 2) }} </td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->ledger_amt_payment, 2) }} </td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->ledger_amt_due, 2) }}</td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->refund, 2) }}</td>
                                            <td class="text-right" style="text-align: right;">
                                                {{ number_format($data->net_collection, 2) }}</td>

                                            <div style="display: none">{{ $sales_total += $data->ledger_amt_sales }}
                                            </div>
                                            <div style="display: none">
                                                {{ $sales_discount += $data->ledger_amt_discount }}</div>
                                            <div style="display: none">{{ $collection += $data->ledger_amt_payment }}
                                            </div>
                                            <div style="display: none">
                                                {{ $net_sales += $data->ledger_amt_sales_net }}
                                            </div>
                                            <div style="display: none">{{ $due += $data->ledger_amt_due }}</div>
                                            <div style="display: none">{{ $invoice_count += $data->ledger_amt_due }}
                                            </div>
                                            <div style="display: none">{{ $refund += $data->refund }}</div>
                                            <div style="display: none">{{ $net_collection += $data->net_collection }}
                                            </div>
                                        </tr>
                                        @php
                                            $sl_count += 1;
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td class="text-right" style="text-align: right;" colspan="3"><strong>Sub
                                                Total = </strong></td>
                                        <td class="text-right" style="text-align: left;">
                                            <strong>{{ $sl_count }}</strong>
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($sales_total, 2) }}</strong>
                                        </td>

                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($sales_discount, 2) }}</strong>
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($net_sales, 2) }}</strong>
                                        </td>

                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($collection, 2) }}</strong>
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($due, 2) }}</strong>
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($refund, 2) }}</strong>
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            <strong>{{ number_format($net_collection, 2) }}</strong>
                                        </td>



                                        <div style="display: none">{{ $sales_total_final_final += $sales_total }}
                                        </div>
                                        <div style="display: none">{{ $sales_discount_final += $sales_discount }}
                                        </div>
                                        <div style="display: none">{{ $collection_final += $collection }}</div>
                                        <div style="display: none">{{ $net_sales_final += $net_sales }}</div>
                                        <div style="display: none">{{ $due_final += $due }}</div>
                                        <div style="display: none">{{ $refund_final += $refund }}</div>
                                        <div style="display: none">{{ $netcollection_final += $net_collection }}
                                        </div>
                                        @php
                                            $invoice_count_final += $sl_count;
                                        @endphp
                                    </tr>
                                @endforeach
                            @endforeach

                        @endif

                        <tfoot>
                            <tr>
                                <th class="text-right" style="text-align: right;" colspan="3">Total =</th>
                                <th class="text-right bg-light-blue" style="text-align: left;">
                                    {{ $invoice_count_final }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_total_final_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_discount_final, 2) }} </th>

                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($net_sales_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($collection_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($due_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($refund_final, 2) }} </th>
                                <th class="text-right bg-light-blue" style="text-align: right;">
                                    {{ number_format($netcollection_final, 2) }} </th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>


    <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
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


</body>

</html>
