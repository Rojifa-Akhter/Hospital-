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
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
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
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;">
                         <strong> Cashier Wise Collection Report</strong><br>                      
                        From - {{$from_date !="" ?$from_date:''}} , To - {{$to_date!="" ? $to_date :''}}    
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" rowspan="2">SL#</th>
                <th class="text-left" rowspan="2">Cashier</th>
                <th class="text-left" rowspan="2">Card No</th>
                <th colspan="6">Received</th>
                <th class="text-right" rowspan="2">Net Amount</th>
            </tr>
            <tr class="tr_border">
                <th class="text-right">Cash</th>
                <th class="text-right">Card</th>
                <th class="text-right">Mobile Banking</th>
                <th class="text-right">Cheque</th>
                <th class="text-right">Sub Total</th>
                <th class="text-right">Refund Amt</th> 
            </tr>
        </thead>
        <tbody class="tr_border">

            @if(!empty($data))
            <div style="display: none">
                {{ $cash = 0 }}
                {{ $card = 0 }}
                {{ $mobile_banking = 0 }}
                {{ $cheque = 0 }}
                {{ $refund = 0 }}
                {{ $sub_total_amt = 0 }}
                {{ $net_amount_total = 0 }}
            </div>
            @foreach($data as $key=>$row)
            
            @php
            $sub_totel=$row->cash + $row->card + $row->mbanking + $row->cheque ;
            $net_amount= $sub_totel-$row->refund ;
            @endphp
            <tr class="tr_border">
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-left">{{$row->user_fullname}}</td>
                <td class="text-left">{{$row->user_code}}</td>
                <td class="text-right">{{$row->cash}}</td>
                <td class="text-right">{{$row->card}}</td>
                <td class="text-right">{{$row->mbanking}}</td>
                <td class="text-right">{{$row->cheque}}</td>
                <td class="text-right">{{$sub_totel}}</td>
                <td class="text-right">{{$row->refund}}</td>
                <td class="text-right">{{$net_amount}}</td>
            </tr>
                @php
                $cash += $row->cash;
                $card += $row->card;
                $mobile_banking += $row->mbanking;
                $cheque += $row->cheque;
                $refund += $row->refund;
                $sub_total_amt += $sub_totel;
                $net_amount_total += $net_amount;
                @endphp
            @endforeach
            <tr class="tr_border">
                <td colspan="3" class="text-right"><strong>Total = </strong></td>
                <td class="text-right"><strong>{{$cash}}</strong></td>
                <td class="text-right"><strong>{{$card}}</strong></td>
                <td class="text-right"><strong>{{$mobile_banking}}</strong></td>
                <td class="text-right"><strong>{{$cheque}}</strong></td>
                <td class="text-right"><strong>{{$sub_total_amt}}</strong></td>
                <td class="text-right"><strong>{{$refund}}</strong></td>
                <td class="text-right"><strong>{{$net_amount_total}}</strong></td>
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
