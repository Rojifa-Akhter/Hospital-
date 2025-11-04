<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Type Wise Report</title>
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
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Item Type Wise Report</span>
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
                                <strong>Item Type</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong>No Of Invoice</strong>
                            </td>
                            <td class="table-td" style="text-align: center;" scope="col">
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
                            {{ $sales_total = 0 }}
                            {{ $total_sales_discount = 0 }}
                            {{ $total_net_sales = 0 }}
                            {{ $total_collection = 0 }}
                            {{ $total_due = 0 }}
                            {{ $total_refund = 0 }}
                            {{ $total_net_collection = 0 }}
                            {{ $total_invoice_count = 0 }}
                        </div>
                        @if (!empty($data_arr))
                        @foreach ($data_arr as $key => $dt)
                            <tr>
                                <td class="text-left" colspan="10">
                                    <strong>Date:
                                        {{ !empty($key) ? date('d/m/Y', strtotime($key)) : '' }}</strong></td>
                            </tr>

                            <div style="display: none">
                                {{ $sales_sub = 0 }}
                                {{ $sub_sales_discount = 0 }}
                                {{ $sub_net_sales = 0 }}
                                {{ $sub_collection = 0 }}
                                {{ $sub_due = 0 }}
                                {{ $sub_refund = 0 }}
                                {{ $sub_net_collection = 0 }}
                                {{ $sub_invoice_count = 0 }}
                            </div>

                            @foreach ($dt as $value)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $value->item_type_name }}</td>
                                    <td class="text-center" style="text-align: center;">{{ $value->invoice_count }}</td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->sales, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->discount, 2) }}</td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->net_sales, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->collection, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->due, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->refund, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->net_collection, 2) }} </td>
                                    <div style="display: none">{{ $sales_sub += $value->sales }}</div>
                                    <div style="display: none">{{ $sub_sales_discount += $value->discount }}</div>
                                    <div style="display: none">{{ $sub_net_sales += $value->net_sales }}</div>
                                    <div style="display: none">{{ $sub_collection += $value->collection }}</div>
                                    <div style="display: none">{{ $sub_invoice_count += $value->invoice_count }}</div>
                                    <div style="display: none">{{ $sub_due += $value->due }}</div>
                                    <div style="display: none">{{ $sub_refund += $value->refund }}</div>
                                    <div style="display: none">{{ $sub_net_collection += $value->net_collection }}</div>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="2" style="text-align: right;">Sub Total =</th>
                                <td class="text-center bg-light-blue" style="text-align: center;" >{{$sub_invoice_count}}</th>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sales_sub,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_sales_discount,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_net_sales,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_collection,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_due,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_refund,2)}} </td>
                                <td class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sub_net_collection,2)}} </td>
                            </tr>

                            <div style="display: none">{{ $sales_total += $sales_sub }}</div>
                            <div style="display: none">{{ $total_sales_discount += $sub_sales_discount }}</div>
                            <div style="display: none">{{ $total_net_sales += $sub_net_sales }}</div>
                            <div style="display: none">{{ $total_collection += $sub_collection }}</div>
                            <div style="display: none">{{ $total_invoice_count += $sub_invoice_count }}</div>
                            <div style="display: none">{{ $total_due += $sub_due }}</div>
                            <div style="display: none">{{ $total_refund += $sub_refund }}</div>
                            <div style="display: none">{{ $total_net_collection += $sub_net_collection }}</div>

                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                    <th class="text-right" colspan="2" style="text-align: right;">Total =</th>
                    <th class="text-center bg-light-blue" style="text-align: center;" >{{$total_invoice_count}}</th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($sales_total,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_sales_discount,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_net_sales,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_collection,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_due,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_refund,2)}} </th>
                    <th class="text-right bg-light-blue" style="text-align: right;" >{{number_format($total_net_collection,2)}} </th>
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
