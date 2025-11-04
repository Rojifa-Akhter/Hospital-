<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>print_grn_report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- custom style -->


    <style>
        /* @page {
            padding-bottom: 100px;
            size: Letter;

        } */

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

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }

        #content {
            display: table;
        }

        #pageFooter {
            display: table-footer-group;
        }

        #pageFooter:after {
            counter-increment: page;
            content: counter(page);
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="16" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}" width="60" alt="">
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
                    <span style="text-align: center;"> <strong>{{$main_store_name->serviceunit_name}} </strong> </span>
                </td>
            </tr>
            <tr class="tr_border">
            <th class="text-center " scope="col">SL</th>
                <th class="text-left " scope="col">GRN No</th>
                <th class="text-left " scope="col">GRN Date</th>
                <th class="text-left " scope="col">PO No</th>
                <th class="text-left " scope="col">PR No</th>
                <th class="text-left " scope="col">Item No</th>
                <th class="text-left " scope="col">Item Name</th>
                <th class="text-left " scope="col">Brand Name</th>
                <th class="text-left " scope="col">Batch No</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-left " scope="col"> Expiry Date</th>
                <th class="text-right " scope="col">Qty</th>
                <th class="text-right " scope="col">Rate</th>
                <th class="text-right " scope="col">Total</th>
                <th class="text-right " scope="col">Discount</th>
                <th class="text-right " scope="col">Net Purchase</th>
            </tr>
        </thead>
        <tbody>

            @php
                $total_discount = 0;
                $total_amount = 0;
                $net_total_amount = 0;
            @endphp

            @if (!empty($data))
            @foreach ($data as $value)
            <tr class="tr_border">
                <td class="text-center " style="width: 20px" scope="col">{{$loop->iteration}}</td>
                <td class="text-center " style="width: 70px" scope="col"> {{$value->itemreceive_no_pk}}</td>
                <td class="text-center " style="width: 100px"scope="col">{{$value->au_entry_at}}</td>
                <td class="text-center " style="width: 65px"scope="col"> {{$value->po_no}}</td>
                <td class="text-center " style="width: 65px" scope="col"> {{$value->pr_no}}</td>
                <td class="text-center " style="width: 80px"scope="col"> {{$value->item_no_fk}}</td>
                <td class="text-left "   style="width: 150px"scope="col"> {{$value->item_name}}</td>
                <td class="text-center " scope="col">N/A</td>
                <td class="text-center " style="width: 40px" scope="col">{{$value->batch_no}}</td>
                <td class="text-center " scope="col">{{$value->uom_name}}</td>
                <td class="text-center " style="width: 60px" scope="col"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-center " style="width: 15px" scope="col">{{$value->delivered_qty}}</td>
                <td class="text-right"   style="width: 50px" scope="col">{{$value->purchase_price}}</td>
                <td class="text-right"   style="width: 90px" scope="col">{{$value->total}}</td>
                <td class="text-right"   style="width: 40px" scope="col">{{$value->discount_amount_itm}}</td>
                <td class="text-right"   style="width: 100px" scope="col">{{$value->net_total}}</td>
            </tr>
            @php
                $total_discount =  $total_discount + $value->discount_amount_itm;
                $total_amount = $total_amount +$value->total;
                $net_total_amount = $net_total_amount + $value->net_total;
            @endphp

            @endforeach

            <tr class="tr_border">
                <th colspan="13" class="text-right table_heading_bg">Grand Total</th>
                <th class="text-right table_heading_bg" scope="col">{{ number_format($total_amount) }}</th>
                <th class="text-right table_heading_bg" scope="col">{{ number_format($total_discount) }}</th>
                <th class="text-right table_heading_bg" scope="col">{{ number_format($net_total_amount) }}</th>
            </tr>
            
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="16">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;" class="page"><strong>Powered By - H360 [NextGen]
                                </strong>
                               
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

<script>
    window.onload = function() {
        window.print();
    }
</script>