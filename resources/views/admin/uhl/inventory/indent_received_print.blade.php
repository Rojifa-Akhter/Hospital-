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
                                <div style="">
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Item Receive Pending List</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th rowspan="2">SL</th>
                <th rowspan="2">Indent No</th>
                <th rowspan="2">Indent Date</th>
                <th rowspan="2">From Dept.</th>
                <th rowspan="2">To Dept.</th>
                <th colspan="2">Req. By</th>
                <th rowspan="2">Ref. Req. No</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2">Is Urgent</th>
                <th rowspan="2">Is Exact</th>
            
               
            </tr>
            <tr class="tr_border">
                <th>Type</th>
                <th>Req. By</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (!empty($issued_requisition_list))
           
                @foreach ($issued_requisition_list as  $row)
                @inject('indent','App\Http\Controllers\HOSItemIssueController')
                @php
                    
                    $indt_qty = 0;
                    $iss_qty = 0;
                    $iss_ind = 0;
                    $rcv_ind = 0;
                    $rcv_qty = 0;
                    $indent_item = $indent->get_received_indent_details($row->inv_requisition_uid);
                    foreach($indent_item as $item) {
                        $indt_qty += intval($item->req_quantity);
                        $iss_qty += intval($item->issue_quantity);
                        $rcv_qty += intval($item->recv_quantity);
                        $iss_ind = isset($item->issue_ind) ? $item->issue_ind : 0;
                        $rcv_ind = isset($item->recv_ind) ? $item->recv_ind : 0;
                    }
                @endphp
                    <tr class="tr_border">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->inv_requisition_uid }}</td>
                        <td>{{ date('d-m-Y h:i a', strtotime($row->req_at)) }}
                        </td>
                        <td>{{ $row->from_stor }}</td>
                        <td>{{ $row->to_store }}</td>
                        <td>{{ $row->req_type }}</td>
                        <td>{{ $row->user_name }}</td>
                        <td>{{ $row->ref_indent_no_fk }}</td>
                        <td>{{ $row->indent_remarks }}</td>


                        <td>
                            <span class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <span class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->exact != 0 ? 'Yes' : 'No' }}
                            </span>

                        </td>                     
                     
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
