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
                    <div style="text-align: center;"> <strong>Stock As On {{ $from_date ? $from_date : '' }}</strong>
                    </div>
                </td>
            </tr>
            <thead class="global-uhl-table-bg">
                <tr class="tr_border">
                    <th style="width: 50px;" class="text-center">SL</th>
                    <th style="width: 100px;" class="text-left">Department</th>
                    <th style="width: 120px;" class="text-left">Category</th>
                    <th style="width: 120px;" class="text-left">Subcategory</th>
                    <th style="width: 100px;" class="text-center">Item No.</th>
                    <th style="width: 180px;" class="text-left">Item Name</th>
                    <th style="width: 180px;" class="text-left">Generic Name</th>
                    <th style="width: 120px;" class="text-left">Batch No</th>
                    <th style="width: 120px;" class="text-left">Expiry Date</th>
                    <th style="width: 90px;" class="text-right">Stock In Hand</th>
                    <th style="width: 110px;" class="text-right">Stock Value</th>
                    <th style="width: 100px;" class="text-center">GRN No</th>
                    <th style="width: 120px;" class="text-center">GRN Date</th>
                    {{-- <th style="width: 100px;" class="text-right">Last Purchase Price</th> --}}
                    {{-- <th style="width: 100px;" class="text-right">Last Sales Price</th> --}}
                    {{-- <th style="width: 90px;" class="text-right">Opening Qty.</th> --}}
                    {{-- <th style="width: 90px;" class="text-right">Stock In</th> --}}
                    {{-- <th style="width: 90px;" class="text-right">Stock Out</th> --}}
                    {{-- <th style="width: 110px;" class="text-right">Total Sales Price</th> --}}
                </tr>

            </thead>
        </thead>
        <tbody class="tr_border">

            @php
                $total_purchase_price = 0;
                $total_sales_price = 0;
                $total_op_qty = 0;
                $total_stock_in = 0;
                $total_stock_out = 0;
                $total_qty = 0;
                $total_clos_qty = 0;
                $purchase = 0;
                $salse = 0;
            @endphp
            @if (!empty($data))
                @foreach ($data as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->department }}</td>
                        <td class="text-left">{{ $value->item_category }}</td>
                        <td class="text-left">{{ $value->item_sub_category }}</td>

                        <td class="text-center">{{ $value->item_no_fk }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ $value->generic_name }}</td>
                        <td class="text-left">
                            @if (!empty($value->batch_no))
                                {{ $value->batch_no }}
                            @else
                                {{ $value->internal_batch_no_uq }}
                            @endif
                        </td>

                        <td class="text-left">

                            {{ empty($value->expiry_date) || $value->expiry_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->expiry_date)) }}
                        </td>
                        <td class="text-right">{{ $value->clos_qty }}</td>
                        <td class="text-right" style="text-align: right">
                            {{ number_format($value->purchase_price * $value->clos_qty, 2, '.', '') }}</td>
                        <td class="text-left">{{ $value->itemreceive_no_fk }}
                        </td>
                        <td class="text-left">

                            {{ empty($value->grn_date) || $value->grn_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->grn_date)) }}

                            {{-- {{ date('d/m/Y', strtotime($value->grn_date)) }} --}}
                        </td>
                        {{-- <td class="text-right">{{ number_format($value->purchase_price, 2, '.', '')}}</td> --}}
                        {{-- <td class="text-right">{{ number_format($value->sales_price, 2, '.', '') }}</td> --}}
                        {{-- <td class="text-right">{{ $value->op_qty }}</td> --}}
                        {{-- <td class="text-right">{{ $value->stock_in }}</td> --}}
                        {{-- <td class="text-right">{{ $value->stock_out }}</td> --}}
                        {{-- <td class="text-right">{{ number_format($value->sales_price * $value->clos_qty, 2, '.', '') }}</td> --}}

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

            @endif

            {{-- <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right;"><strong>Total</strong></td>
            <td style="text-align: right;"><strong></strong></td>
            <td style="text-align: right;"><strong></strong></td>
            <td style="text-align: right;"><strong>{{ $total_op_qty }}</strong></td>
            <td style="text-align: right;"><strong>{{ $total_stock_in }}</strong></td>
            <td style="text-align: right;"><strong>{{ $total_stock_out }}</strong></td>
            <td style="text-align: right;"><strong>{{ $total_clos_qty }}</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($purchase, 2, '.', '') }}</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($salse, 2, '.', '') }}</strong></td>


        </tr> --}}

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
