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
    <title>Stock Transfer report</title>
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
                    <div style="text-align: center;"> <strong> Stock Transfer Report</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center " style="width:3%">SL</th>
                <th class="text-center " style="width:5%">ID</th>
                @if ($type == 2)
                <th class="text-left " style="width:10%">Transfer Date</th>
                @endif
                <th class="text-left " style="width:10%">Transferred By</th>
                <th class="text-left " style="width:10%">Item Name</th>
                <th class="text-center " style="width:3%">UoM</th>
                <th class="text-left " style="width:7%">Internal Batch No</th>
                <th class="text-left " style="width:9%">Batch No</th>
                <th class="text-left " style="width:13%">From Store</th>
                <th class="text-left " style="width:13%">To Store</th>
                <th class="text-center " style="width:5%">Qty</th>
                <th class="text-center " style="width:5%">Received Qty</th>
                <th class="text-center " style="width:5%">Trans Type</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if(!empty($transferDataPending))

            @foreach($transferDataPending as $key=>$stock)
            <tr class="tr_border">
                <td class="text-center">
                    {{ $loop->iteration }}                    
                </td>
                <td class="text-center">{{ $stock->itemadjment_no_fk }}</td>
                @if ($type == 2)
                <th class="text-left " style="width:10%">{{ $stock->au_entry_at !="" ? date('d/m/Y',strtotime($stock->au_entry_at)) :'' }}</th>
                @endif
                <td class="text-left">{{ $stock->user_fullname }}</td>
                <td class="text-left">{{ $stock->item_name }}</td>
                <td class="text-center">{{ $stock->uom_name }}</td>
                <td class="text-left">{{ $stock->internal_batch_no_uq }}</td>
                <td class="text-left">{{ $stock->batch_no }}</td>
                <td class="text-left">{{ $stock->from_store }}</td>
                <td class="text-left">{{ $stock->to_store }}</td>
                <td class="text-center transfer_qty" id="transfer_qty">{{ $stock->item_qty }}</td>
                <td class="text-center" style="width:5%"> {{  $stock->receive_qty }}</td>
                <td class="text-center" style="width:5%"> {{  $stock->itemadjment_type }}</td>
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
