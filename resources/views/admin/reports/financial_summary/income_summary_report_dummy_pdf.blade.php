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


                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Invoice Wise Income Summary</strong> <br> From : {{$date_from !="" ? date('d/m/Y',strtotime($date_from)) :''}} To : {{$date_to !="" ? date('d/m/Y',strtotime($date_to)) :''}}</div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" style="width: 30px;">Sl.</th>
                <th class="text-center" style="width: 100px; text-align:left">Invoice No</th>
                <th class="text-left" style="width: 100px; text-align:left">Invoice Date</th>
                <th class="text-left" style="width: 100px; text-align:left">Patinet Name</th>
                <th class="text-left" style="width: 100px; text-align:left">Patinet Id</th>
                <th class="text-left" style="width: 100px; text-align:left">Admission No</th>
                <th class="text-left" style="width: 100px; text-align:left">Age</th>
                <th class="text-left" style="width: 100px; text-align:left">Gender</th>
                <th class="text-left" style="width: 100px; text-align:left">Cashier Name</th>
                <th class="text-right" style="width: 100px; text-align:right">Sales Amt</th>
                <th class="text-right" style="width: 100px; text-align:right">Discount Amt</th>
                <th class="text-right" style="width: 100px; text-align:right">Payment Amt</th>
                <th class="text-right" style="width: 100px; text-align:right">Payable Amt</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if(!empty($data))
            @php
            $sales =0;
            $discount=0;
            $payment =0;
            $payable =0;
            @endphp
            @foreach($data as $key=>$row)
            <tr class="tr_border">
                <td style="text-align: center;">{{$loop->iteration}}</td>
                <td class="text-center" style="text-align: left;">{{$row->invoice_no_fk}}</td>
                <td class="text-center" style="text-align: left;">{{$row->invoice_date !="" ? date('d/m/Y',strtotime($row->invoice_date)) :''}}</td>
                <td class="text-center" style="text-align: left;">{{$row->patient_name}}</td>
                <td class="text-center" style="text-align: left;">{{$row->patient_code}}</td>
                <td class="text-center" style="text-align: left;">{{$row->admission_no_fk}}</td>
                <td class="text-center" style="text-align: left;">{{$row->patient_age}}</td>
                <td class="text-center" style="text-align: left;">{{$row->gender_txt}}</td>
                <td class="text-center" style="text-align: left;">{{$row->cashier_name}}</td>
                <td class="text-right" style="text-align: right;">{{number_format($row->ledger_amt_sales,2,'.','')}}</td>
                <td class="text-right" style="text-align: right;">{{number_format($row->ledger_amt_discount,2,'.','')}}</td>
                <td class="text-right" style="text-align: right;">{{number_format($row->ledger_amt_payment,2,'.','')}}</td>
                <td class="text-right" style="text-align: right;">{{number_format(($row->ledger_amt_sales ) -( $row->ledger_amt_payment +  $row->ledger_amt_discount),2,'.','')}}</td>
            </tr>

            @php
            $sales +=$row->ledger_amt_sales;
            $discount +=$row->ledger_amt_discount;
            $payment +=$row->ledger_amt_payment;
            $payable +=($row->ledger_amt_sales ) -( $row->ledger_amt_payment + $row->ledger_amt_discount);
            @endphp
            @endforeach

            <tr class="tr_border">
                <td class="text-right" style="text-align: right;" colspan="9"><strong>Total = </strong></td>
                <td class="text-right" style="text-align: right;"><strong>{{number_format($sales ,2,'.','')}} </strong></td>
                <td class="text-right" style="text-align: right;"><strong>{{number_format($discount,2,'.','')}} </strong></td>
                <td class="text-right" style="text-align: right;"><strong>{{number_format($payment,2,'.','')}} </strong></td>
                <td class="text-right" style="text-align: right;"><strong>{{number_format($payable,2,'.','')}} </strong></td>
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
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>

</html>