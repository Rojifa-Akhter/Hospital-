<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>print_store_stock_ledger</title>
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
                    <div style="text-align: center;"> <strong> Current Medicine Stock</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center ">SL#</th>
                <th class="text-left ">Item Code</th>
                <th class="text-left ">Pack Type</th>
                <th class="text-left">Item Name</th>
                <th class="text-left ">UOM</th>
                <th class="text-right ">Re-Order</th>
                <th class="text-right ">Cur. Stock</th>
                <th class="text-center ">Purchase Price</th>
                <th class="text-center ">Total Purchase Price</th>
                <th class="text-center ">Sales Price</th>
                <th class="text-center ">Total Sales Price</th>
                <th class="text-center ">Last Purchase Date</th>
                <th class="text-right ">Last Purchase Price</th>
                <th class="text-right ">Last Purchase Qty</th>
                <th class="text-left ">Status</th>
            </tr>
        </thead>
        <tbody>

            @if (!empty($total_stocks))
            @foreach ($total_stocks as $stock)
            @php
            $subTotal = 0;
            $purchase_total = 0;
            $sales_total = 0;
            $gross_purchase_total = 0;
            $gross_sales_total = 0;
            $last_purchase_prise = 0;
            $supp_name = '';

            @endphp


            @php
            $totalItems = 0; //!empty($stock_arr) ? count($stock_arr) : 0;

            $total_purch_price = ($stock->current_stock ?? 0) * ($stock->purchase_price ?? 0);
            $total_sales_price = ($stock->current_stock ?? 0) * ($stock->sales_price ?? 0);
            @endphp
            <tr class="tr_border">
                <td style="padding:5px;text-align:center">
                    {{ $loop->iteration }}
                </td>
                <td style="padding:5px;text-align:left">
                    {{ $stock->item_code }}
                </td>
                <td style="padding:5px;text-align:left">
                    {{ $stock->pack_type }}
                </td>
                <td style="padding:5px;text-align:left">
                    {{ $stock->item_name }}
                </td>
                <td style="padding:5px;text-align:left">
                    {{ $stock->uom_name }}
                </td>
                <td style="padding:5px;text-align:center">
                    {{ $stock->re_order_level }}
                </td>
                <td style="padding:5px;text-align:center">
                    {{ $stock->current_stock }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ number_format($stock->purchase_price, 2, '.', '') }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ number_format($total_purch_price, 2, '.', '') }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ $stock->sales_price }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ number_format($total_sales_price, 2, '.', '') }}
                </td>
                <td style="padding:5px;text-align:right">
                {{$stock->last_purchase_date !="" ? date('d/m/Y',strtotime($stock->last_purchase_date)):'' }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ number_format($stock->last_purchase_prise, 2, '.', '') }}
                </td>
                <td style="padding:5px;text-align:right">
                    {{ $stock->last_purchase_qty }}
                </td>
                <td style="padding:5px;text-align:left"><span class="badge bg-danger text-white">{{ $stock->stock_status_text }}</span>
                </td>
            </tr>
            @php
            $subTotal += $stock->current_stock;
            $purchase_total += $stock->purchase_price;
            $sales_total += $stock->sales_price;
            $gross_purchase_total += $total_purch_price;
            $gross_sales_total += $total_sales_price;
            $last_purchase_prise += $stock->last_purchase_prise;
            @endphp
            @endforeach
             <!-- <tr class="tr_border">
                <td colspan="4"></td>

                <td colspan="2"><strong>Sub-total</strong></td>
                <td style="text-align:right">{{ number_format($subTotal, 2, '.', '') }}
            </td>
            <td style="text-align:right">
                {{ number_format($purchase_total, 2, '.', '') }}
            </td>
            <td style="text-align:right">
                {{ number_format($gross_purchase_total, 2, '.', '') }}
            </td>
            <td style="text-align:right">
                {{ number_format($sales_total, 2, '.', '') }}
            </td>
            <td style="text-align:right">
                {{ number_format($gross_sales_total, 2, '.', '') }}
            </td>
            <td></td>
            <td style="text-align:right">
                {{ number_format($last_purchase_prise, 2, '.', '') }}
            </td>
            <td style=""></td>
            <td style=""></td>
            </tr>  -->

            <!-- <tr class="tr_border">
                <td colspan="4"></td>

                <td colspan="2"><strong>Total</strong></td>
                <td style="text-align:right">
                </td>
                <td style="text-align:right">

                </td>
                <td style="text-align:right">

                </td>
                <td style="text-align:right">

                </td>
                <td style="text-align:right">

                </td>
                <td style=""></td>
            </tr> -->


            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; padding-top: 50px;" colspan="12">
                    @if (Session::get('user.ses_hospital_code') == 'JKMH')
                    <div class="">
                        <table style="width: 100%; border:none ">
                            <tr style=" ">
                                <td style="text-align:center; border:none ">
                                    <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                                </td>
                                <td style="text-align:center; border:none ">
                                    <span style="padding:5px; border-top: black solid 1px;"> Checked By</span>
                                </td>
                                <td style="text-align:center; border:none ">
                                    <span style="padding:5px; border-top: black solid 1px;">Store Incharge</span>
                                </td>

                                <td style="text-align:center; border:none">
                                    <span style="padding:5px; border-top: black solid 1px;">DGM
                                    </span>
                                </td>

                                <td style="text-align:center; border:none">
                                    <span style="padding:5px; border-top: black solid 1px;">Chairman
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
</body>

</html>