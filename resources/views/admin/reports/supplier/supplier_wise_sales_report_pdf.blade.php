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
    <title>report</title>
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

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="7" style="">
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

                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Sales Return Report</strong>
                        <p>{{$date_from !="" ? 'From : '. date('d/m/Y',strtotime($date_from)) :''}} {{$date_to !="" ? ', To : '. date('d/m/Y',strtotime($date_to)) :''}}</p>
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" style="width: 35px;">SL#</th>
                <th class="text-left">Item Name</th>
                <th class="text-right">Rate</th>
                <th class="text-center">Cancel Qty</th>
                <th class="text-right"> Cancel Amt.</th>
                <th class="text-right">Refund Amt.</th>
                <th class="text-right">Cancel Discount</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @php
            $qty = 0;
            $cancel_amt = 0;
            $refund = 0;
            $discount = 0;
            @endphp
            @if (!empty($sales_return))

            @foreach ($sales_return as $suppiler)
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-left">{{$suppiler->item_name}}</td>
                <td class="text-right">{{number_format($suppiler->item_rate,2,'.',',')}}</td>
                <td class="text-center">{{$suppiler->cancel_qty}}</td>
                <td class="text-right">{{number_format($suppiler->cancel_amount,2,'.',',') }}</td>
                <td class="text-right">{{ number_format($suppiler->refund_amt,2,'.',',') }}</td>
                <td class="text-right">{{number_format($suppiler->discount_amt,2,'.',',')}}</td>
            </tr>
            @php
            $qty +=$suppiler->cancel_qty;
            $cancel_amt += $suppiler->cancel_amount;
            $refund += $suppiler->refund_amt;
            $discount += $suppiler->discount_amt;
            @endphp
            @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr class="tr_border">

                <th class="text-right bg-light-blue" colspan="3">Total</th>
                <th class="text-center bg-light-blue">{{ number_format($qty,2,'.',',') }}</th>
                <th class="text-right bg-light-blue">{{ number_format($cancel_amt,2,'.',',') }}</th>
                <th class="text-right bg-light-blue">{{ number_format($refund,2,'.',',') }}</th>
                <th class="text-right bg-light-blue">{{ number_format($discount,2,'.',',') }}</th>

            </tr>
            <tr>
                <td style="width: 100%; " colspan="7">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]
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