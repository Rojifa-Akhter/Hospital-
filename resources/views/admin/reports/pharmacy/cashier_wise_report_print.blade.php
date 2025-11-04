<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier Wise Report</title>
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Pharmacy Date wise Cashier Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <div style="display: none">
                            {{ $sales_total = 0 }}
                            {{ $sales_discount = 0 }}
                            {{ $net_sales = 0 }}
                            {{ $collection = 0 }}
                            {{ $invoice_count = 0 }}
                            {{ $sales_due = 0 }}
                            {{ $sales_refund = 0 }}
                            {{ $total_net_collection = 0 }}
                        </div>

                        <thead class="bg-soft-green">
                            <tr class="table-tr" style="background-color: #111; color:white;">
                                <td class="table-td" scope="col">
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td" scope="col">
                                    <strong>Date</strong>
                                </td>
                                <td class="table-td" scope="col">
                                    <strong>Patient Name</strong>
                                </td>
                                <td class="table-td" scope="col">
                                    <strong>Cashier Name</strong>
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

                        </thead>
                        <br>

                        </tr>
                        @if (isset($data))
                            @foreach ($data as $value)
                                <tr class="table-tr">
                                    <td class="table-td" style="text-align: center;" scope="col">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="table-td" style="text-align: left;" scope="col">
                                        <strong>{{ date('d/m/Y', strtotime($value->invoice_date)) }}</strong>
                                    </td>
                                    <td class="table-td" style="text-align: left;" scope="col">
                                        {{ $value->patient_name }}
                                        <strong>
                                            {{ !empty($value->person_code) ? '(' . $value->person_code . ')' : '' }}</strong>

                                    </td>


                                    <td class="table-td" scope="col">
                                        {{ $value->user_fullname }}</td>

                                        <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->sales, 2) }}</td>
                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->discount, 2) }}</td>
                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->net_sales, 2) }}</td>



                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->collection, 2) }}</td>

                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->due, 2) }}</td>
                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format(abs($value->refund), 2) }}</td>

                                    <td class="table-td" style="text-align: right;" scope="col">
                                        {{ number_format($value->net_collection, 2) }}</td>

                                    <div style="display: none">{{ $sales_total += $value->sales }}</div>
                                    <div style="display: none">{{ $sales_discount += $value->discount }}
                                    </div>
                                    <div style="display: none">{{ $net_sales += $value->net_sales }}</div>
                                    <div style="display: none">{{ $collection += $value->collection }}</div>

                                    <div style="display: none">{{ $sales_due += $value->due }}</div>
                                    <div style="display: none">{{ $sales_refund += $value->refund }}</div>
                                    <div style="display: none">{{ $total_net_collection += $value->net_collection }}
                                    </div>
                                </tr>
                            @endforeach
                        @endif
                        <tfoot>
                            <tr>
                                <th class="text-right" style="text-align: right;" colspan="4">Total =</th>


                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_total, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_discount, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($net_sales, 2) }}</th>

                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($collection, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($sales_due, 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format(abs($sales_refund), 2) }}</th>
                                <th class="text-left bg-light-blue" style="text-align: right;">
                                    {{ number_format($total_net_collection, 2) }}</th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
