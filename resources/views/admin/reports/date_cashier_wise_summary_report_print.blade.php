<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo', 'hospital_name', 'hospital_name', 'addrress1', 'telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>date wise cashier report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>
@php
$invoice_arr = 0;
$invoice_su_arr[] = [];
@endphp

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
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
                    <div style="text-align: center;"> <strong>
                            @if ($po_hospital_details->hospital_code == 'GMC')
                            Cashier Wise Collection Summary Report
                            @else
                            Date Wise
                            Cashier Summary Report
                            @endif
                        </strong> </div>
                    <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                        </span>
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <td class="table-td" scope="col">
                    <strong>SL</strong>
                </td>
                <td class="table-td" scope="col">
                    <strong>Invoice Date</strong>
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
                    <strong>Refund</strong>
                </td>
                <td class="table-td" scope="col" style="text-align: right;">
                    <strong>Net Collection</strong>
                </td>
            </tr>
        </thead>
        <tbody class="tr_border">


            <div style="display: none">

                {{ $sl_count = 0 }}
                {{ $sales_total = 0 }}
                {{ $sales_discount = 0 }}
                {{ $net_sales = 0 }}
                {{ $due = 0 }}
                {{ $due_total = 0 }}
                {{ $collection = 0 }}
                {{ $refund = 0 }}
                {{ $net_collection = 0 }}
                {{ $sales_cancel = 0 }}
            </div>
            @foreach ($cashier_arr as $data)



            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">
                    {{ $data->full_name }}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($data->invoice_date)) }}
                </td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format(round($data->ledger_amt_sales), 2) }}
                </td>

                <td class="text-right" style="text-align: right;">
                    {{ number_format($data->ledger_amt_discount, 2) }}
                </td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format(round($data->ledger_amt_sales_net), 2) }}
                </td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format(round($data->ledger_amt_payment), 2) }}
                </td>

                <td class="text-right" style="text-align: right;">
                    {{ number_format($data->refund, 2) }}
                </td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format($data->ledger_amt_payment - $data->refund, 2) }}
                </td>
                <div style="display: none">
                    {{ $sales_total += $data->ledger_amt_sales }}
                </div>
                <div style="display: none">
                    {{ $sales_discount += $data->ledger_amt_discount }}
                </div>
                <div style="display: none">
                    {{ $collection += $data->ledger_amt_payment }}
                </div>
                <div style="display: none">
                    {{ $net_sales += $data->ledger_amt_sales_net }}
                </div>

                <div style="display: none">{{ $due_total += $due }}</div>
              
                <div style="display: none">{{ $refund += $data->refund }}</div>
                <div style="display: none">
                    {{ $net_collection += $data->ledger_amt_payment - $data->refund }}
                </div>
            </tr>
            @endforeach
            <tr>
                <td class="text-right" style="text-align: right;" colspan="3"><strong>Sub
                        Total = </strong></td>
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
                    <strong>{{ number_format($refund, 2) }}</strong>
                </td>
                <td class="text-right" style="text-align: right;">
                    <strong>{{ number_format($net_collection, 2) }}</strong>
                </td>

        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; padding-top: 50px;" colspan="12">
                    @if (Session::get('user.ses_hospital_code') == 'JKMH')
                    <div class="">
                        <table style="width: 100%; border:none ">
                            <tr style=" ">
                                <td style="text-align:left; border:none ">
                                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                                </td>
                                <td style="text-align:left; border:none ">
                                    <span style="padding:5px; border-top: black solid 1px;">Manager Accounts</span>
                                </td>

                                <td style="text-align:center; border:none">
                                    <span style="padding:5px; border-top: black solid 1px;">DGM
                                    </span>
                                </td>

                                <td style="text-align:right; border:none">
                                    <span style="padding:5px; border-top: black solid 1px;">DMD
                                    </span>
                                </td>

                            </tr>
                        </table>

                    </div>
                    @else
                    <div class="">
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
                    @endif

                </td>
            </tr>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>