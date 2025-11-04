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
                                  
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Item Wise consumption Report</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th>SL</th>
                <th class="text-left">Consumption By</th>
                <th class="text-left">Consumption Date</th>
                <th class="text-left">Department</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Consumption Uom</th>
                <th>Purchase Price</th>
                <th>Current Stock</th>
                <th class="text-left">Internal Batch</th>
                <th>Consumption Qty.</th>
                <th>Cost Price</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            <?php $totalValue = 0; ?>
            @if(!empty($requisition_list))

            @foreach($requisition_list as $key=>$value)
            <?php 
                $valueTotal = $value->item_consumption_qty * $value->cost_price; 
                $totalValue += $valueTotal; 
            ?>
            <tr class="tr_border">
                <td class="text-center bg-light">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $value->emp_name }}</td>
                <td class="text-left">{{ $value->inv_consumption_date !="" ? date('d/m/Y',strtotime($value->inv_consumption_date)) :'' }}</td>
                <td class="text-left">{{ $value->dept }}</td>
                <td class="text-left">{{ $value->item_name }}</td>
                <td class="text-left">{{ $value->uom }}</td>
                <td class="text-right">{{ $value->purchase_price }}</td>
                <td class="text-center">{{ $value->curr_stock }}</td>
                <td class="text-left">
                    {{ $value->internal_batch_no != '0' ? ucwords($value->internal_batch_no) : '' }}
                </td>
                <td class="text-right">{{ $value->item_consumption_qty }}</td>
                <td class="text-right">{{ $value->cost_price }}</td>
                <td class="text-right">{{ $valueTotal }}</td>
            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="11" class="text-right"><b>Total:</b></td>
                <td class="text-right"><b>{{ $totalValue }}</b></td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="11">
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
