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
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                {{-- <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt=""> --}}
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
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Expiry Item </strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" scope="col">SL</th>
                <th class="text-left "  style="text-align: left;">Item Name</th>
                <th class="text-left " scope="col">Internal Batch No</th>
                <th class="text-left " scope="col"> Batch No</th>
                <th class="text-left "  style="text-align: left;"> Expired Date</th>
                <th class="text-center " scope="col">Qty</th>
                <th class="text-right "  style="text-align: right;">Cost Price</th>
                <th class="text-right "  style="text-align: right;">Value</th>
                <th class="text-center " scope="col">UoM</th>                
                <th class="text-center " scope="col">GRN No</th>                
                <th class="text-center " scope="col">GRN Date</th>                
                <th class="text-left "  style="text-align: left;">Department</th>
                <th class="text-left "  style="text-align: left;">Supplier Name</th>
            </tr>
        </thead>
        <tbody>

            @if (!empty($data))
            @php
                $value_total=0;   
            @endphp
            @foreach ($data as $value)
            <tr class="tr_border">
                <td class="text-center "scope="col">{{$loop->iteration}}</td>
                <td class="text-left " style="text-align: left;"> {{$value->item_name}}</td>
                <td class="text-left " scope="col" style="text-align: center;">{{$value->internal_batch_no_uq}}</td>
                <td class="text-left " scope="col" style="text-align: center;">{{$value->batch_no}}</td>
                <td class="text-left " style="text-align: left;"> {{$value->expiry_date !="" ? date('d-m-Y',strtotime($value->expiry_date)) :''}}</td>
                <td class="text-center " scope="col" style="text-align: center;">{{$value->item_qty}}</td>                
                <td class="text-right " style="text-align: right;">{{number_format($value->cost_price,2)}}</td>
                <td class="text-right " style="text-align: right;">{{number_format($value->item_qty * $value->cost_price,2)}}</td>
                <td class="text-center " scope="col" style="text-align: center;">{{$value->uom_code}}</td>
                <td class="text-center " scope="col" style="text-align: center;">{{$value->itemreceive_no_fk}}</td>
                <td class="text-center " scope="col" style="text-align: center;">{{$value->grn_date !="" ? date('d/m/Y',strtotime($value->grn_date)) : ''}}</td>
                <td class="text-left " style="text-align: left;">{{$value->serviceunit_name}}</td>
                <td class="text-left " style="text-align: left;">{{$value->supplier_name}}</td>
            </tr>
            @php
                 $value_total +=$value->item_qty * $value->cost_price;   
            @endphp
            @endforeach
            <tr>
                <td colspan="7" style="text-align: right"><strong>Total Value = </strong></td>
                <td> <strong> {{number_format( $value_total,2)}}</strong></td>
            </tr>
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