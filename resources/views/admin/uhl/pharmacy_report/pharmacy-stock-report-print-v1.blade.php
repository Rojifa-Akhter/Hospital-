<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>As On Report</title>
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

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                    width="60" alt="">
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


                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>As On Report</strong> <br>From
                        {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }} </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th style="text-align: center; width:60px;">
                    <strong>SL</strong>
                </th>
                <th style="text-align: center; width:100px;">
                    <strong>Item No.</strong>
                </th>
                <th style="text-align: left; width:200px;">
                    <strong>Item Name</strong>
                </th>
                <th style="text-align: left; width:180px;">
                    <strong>Generic Name</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Last Purchase Price</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Last Sales Price</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Opening Qty.</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Stock In</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Stock Out</strong>
                </th>
                <th style="text-align: right; width:90px;">
                    <strong>Closing Qty</strong>
                </th>
                <th style="text-align: right; width:110px;">
                    <strong>Total Purchase Price</strong>
                </th>
                <th style="text-align: right; width:110px;">
                    <strong>Total Sales Price</strong>
                </th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (!empty($data))
                @php
                    $total_op_qty_all = 0;
                    $total_stock_in_all = 0;
                    $total_stock_out_all = 0;
                    $total_clos_qty_all = 0;
                    $total_purchase_price_all = 0;
                    $total_sales_price_all = 0;
                @endphp

                @foreach ($data as $supplierDepartment => $item)
                    <tr style="background-color: #E3E3E3;" class="tr_border">
                        <td colspan="12">
                            <strong>Department: {{ $supplierDepartment }}</strong>
                        </td>
                    </tr>
                    @foreach ($item as $supp => $items)
                        <tr style="background-color: #E3E3E3;" class="tr_border">
                            <td colspan="12">
                                <strong>{{ $supp }}</strong>
                            </td>
                        </tr>

                        @php
                            $total_purchase_price = 0;
                            $total_sales_price = 0;
                            $total_op_qty = 0;
                            $total_stock_in = 0;
                            $total_stock_out = 0;
                            $total_clos_qty = 0;
                            $purchase = 0;
                            $salse = 0;
                        @endphp

                        @foreach ($items as $value)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td style="text-align: center;">{{ $value->item_no_fk }}</td>
                                <td>{{ $value->item_name }}</td>
                                <td>{{ $value->generic_name }}</td>
                                <td style="text-align: right">{{ number_format($value->purchase_price, 2, '.', '') }}
                                </td>
                                <td style="text-align: right">{{ number_format($value->sales_price, 2, '.', '') }}</td>
                                <td style="text-align: right;">{{ $value->op_qty }}</td>
                                <td style="text-align: right;">{{ $value->stock_in }}</td>
                                <td style="text-align: right;">{{ $value->stock_out }}</td>
                                <td style="text-align: right;">{{ $value->clos_qty }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($value->purchase_price * $value->clos_qty, 2, '.', '') }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($value->sales_price * $value->clos_qty, 2, '.', '') }}</td>
                            </tr>
                            @php
                                $total_purchase_price += $value->purchase_price;
                                $total_sales_price += $value->sales_price;
                                $total_op_qty += $value->op_qty;
                                $total_stock_in += $value->stock_in;
                                $total_stock_out += $value->stock_out;
                                $total_clos_qty += $value->clos_qty;
                                $purchase += $value->purchase_price * $value->clos_qty;
                                $salse += $value->sales_price * $value->clos_qty;
                            @endphp
                        @endforeach

                        @php
                            $total_op_qty_all += $total_op_qty;
                            $total_stock_in_all +=  $total_stock_in;
                            $total_stock_out_all += $total_stock_out;
                            $total_clos_qty_all +=  $total_clos_qty;
                            $total_purchase_price_all += $purchase;
                            $total_sales_price_all += $salse;

                        @endphp
                        <tr>
                            <td style="text-align: right;" colspan="4"><b>Total</b></td>
                            <td style="text-align: right;"><b></b></td>
                            <td style="text-align: right;"><b></b></td>
                            <td style="text-align: right;"><b>{{ $total_op_qty }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_stock_in }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_stock_out }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_clos_qty }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($purchase, 2, '.', '') }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($salse, 2, '.', '') }}</b></td>
                        </tr>
                    @endforeach
                    <tr>
                            <td style="text-align: right;" colspan="4"><b>Gross-Total</b></td>
                            <td style="text-align: right;"><b></b></td>
                            <td style="text-align: right;"><b></b></td>
                            <td style="text-align: right;"><b>{{ $total_op_qty_all }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_stock_in_all }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_stock_out_all }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_clos_qty_all }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($total_purchase_price_all, 2, '.', '') }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($total_sales_price_all, 2, '.', '') }}</b></td>
                        </tr>
                @endforeach
            @endif

        </tbody>

        <tfoot>
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
