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
                                <!-- <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div> -->

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Pharmacy GRN Report</strong> <br> From : {{$date_from !="" ? date('d/m/Y',strtotime($date_from)) :'' }} - To  : {{ $date_to !="" ? date('d/m/Y',strtotime($date_to)) :'' }} </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center">SL#</th>
                <th class="text-center" scope="col">GRN No</th>
                <th class="" style="text-align: left;" scope="col">GRN Date</th>
                <th class="text-center" scope="col">Challan No</th>
                <th class="" style="text-align: left;" scope="col">Challan Date</th>
                <th class="" style="text-align: left;" scope="col">Department</th>
                <th class="text-center" scope="col">No of Item</th>
                <th scope="col" class="" style="text-align: right;">GRN Amount</th>
                <th class="" style="text-align: right;" scope="col">Vat Amt.</th>
                <th class="" style="text-align: right;" scope="col">Discount Amt.</th>
                <th class="" style="text-align: right;" scope="col">Return Adjustment Amt.</th>
                <th scope="col" class="" style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody class="tr_border" style="font-size: 13px;">

            @if(!empty($grn_arr))
            @php
                $total_grn_amt=0;
                $total_vat=0;
                $total_discount=0;
                $total_adjustment_amt=0;
                $total_receive_amt=0;
            @endphp
           
            @foreach($grn_arr as $key=>$rows)
            <tr>
                <th colspan="12" class="text-left" style="text-align: left;">{{ucwords(strtolower(explode('*',$key)[1]))}}</th>
            </tr>
            @php
                $grn_amt=0;
                $vat=0;
                $discount=0;
                $adjustment_amt=0;
                $receive_amt=0;
            @endphp
            @foreach($rows as $row)
           
            <tr class="tr_border">
                <td class="border-1 bg-light" style="text-align: center;">{{ $loop->iteration }}</td>               
                <td class="border-1 bg-light" style="text-align: center;">{{ $row->itemreceive_no_pk }}</td>
                <td class="border-1 bg-light" style="text-align: left;">{{ $row->au_entry_at !="" ? date('d/m/Y',strtotime($row->au_entry_at )) :''  }}</td>
                <td class="border-1 bg-light" style="text-align: center;">{{ $row->challan_no }}</td>
                <td class="border-1 bg-light" style="text-align: left;">{{ $row->challan_date !="" ? date('d/m/Y',strtotime($row->challan_date )) :''  }}</td>
                <td class="border-1 bg-light" style="text-align: left;">{{ $row->su_name }}</td>
                <td class="border-1 bg-light" style="text-align: center;">{{$row->no_of_item}}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{number_format(($row->total_received_amount+$row->discount_amount+$row->return_amt_adj ) -$row->vat_amount,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($row->vat_amount,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($row->discount_amount,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($row->return_amt_adj,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{number_format($row->total_received_amount,2,'.','') }}</td>
            </tr>
            @php
                $grn_amt +=($row->total_received_amount + $row->discount_amount + $row->return_amt_adj ) - $row->vat_amount;
                $vat +=$row->vat_amount;
                $discount +=$row->discount_amount;
                $adjustment_amt +=$row->return_amt_adj;
                $receive_amt +=$row->total_received_amount;
            @endphp
            @endforeach
            <tr class="tr_border" style="font-weight: bold;">                
                <td class="border-1 bg-light" style="text-align: right;" colspan="7" >Sub-Total = </td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format( $grn_amt,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($vat,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{  number_format($discount,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{  number_format($adjustment_amt,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($receive_amt,2,'.','') }}</td>
            </tr>
            @php
                $total_grn_amt +=$grn_amt;
                $total_vat +=$vat;
                $total_discount +=$discount;
                $total_adjustment_amt +=$adjustment_amt;
                $total_receive_amt +=$receive_amt;
            @endphp
            @endforeach
            <tr class="tr_border" style="font-weight: bold;">                
                <td class="border-1 bg-light" style="text-align: right;" colspan="7">Total = </td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($total_grn_amt,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($total_vat,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{  number_format($total_discount,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{  number_format($total_adjustment_amt,2,'.','') }}</td>
                <td class="border-1 bg-light" style="text-align: right;">{{ number_format($total_receive_amt,2,'.','') }}</td>
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
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
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
