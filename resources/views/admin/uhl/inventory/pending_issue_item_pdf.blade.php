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
                    <div style="text-align: center;"> <strong> Pending Issue List</strong> <br>
                       From -  {{$dateTime_from !="" ? date('d/m/Y',strtotime($dateTime_from)) :''}} , To -  {{$dateTime_to !="" ? date('d/m/Y',strtotime($dateTime_to)) : ''}}
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th>SL</th>
                <th>Indent No</th>
                <th style="text-align: left">Indent Date</th>
                <th style="text-align: left">Item Name</th>
                <th>UOM</th>
                <th style="text-align: left">From Department</th>
                <th>Receiving Store Stock</th>
                <th style="text-align: left">To Department</th>
                <th>Stock</th>
                <th style="text-align: left">Req. By</th>
                <th>Is Urgent</th>
                <th>Is Exact</th>
                <th>Indent Qty</th>
                <th>Issue Qty</th>
                <th>Receive Qty</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if(!empty($issued_requisition_list))

            @foreach($issued_requisition_list as $key=>$row)
            <tr class="tr_border">
                <td>{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $row->inv_requisition_no_fk }}</td>
                <td>{{ date('d-m-Y', strtotime($row->inv_requisition_date)) }}</td>
                <td>{{ $row->item_name }}</td>
                <td style="text-align: center">{{ $row->uom_code }}</td>
                <td>{{ $row->from_stor }}</td>
                <td style="text-align: center">{{ $row->from_stock !=""? $row->from_stock :0 }}</td>
                <td>{{ $row->to_store }}</td>
                <td style="text-align: center">{{ $row->to_stock  !="" ? $row->to_stock :0}}</td>
                <td>{{ $row->user_name }}</td>
                <td style="text-align: center">
                    <span class="{{ $row->urgent_ind != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                        {{ $row->urgent_ind != 0 ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td style="text-align: center">
                    <span class="{{ $row->exact_ind != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                        {{ $row->exact_ind != 0 ? 'Yes' : 'No' }}
                    </span>

                </td>     
                <td style="text-align: center">{{ $row->req_quantity }}</td>
                <td style="text-align: center">{{ $row->issue_quantity }}</td>                  
                <td style="text-align: center">{{ $row->recv_quantity }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="15">
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
