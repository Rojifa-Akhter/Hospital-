<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
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

                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Assign P.R List </strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th>SL</th>
                <th style="text-align: left;">Assign Employee Name</th>
                <th  style="text-align: left;">P.R No</th>
                <th style="text-align: left;">P.R Date</th>
                <th style="text-align: left;">Item Name</th>
                <th style="text-align: left;">Qty</th>
                <th style="text-align: left;">Uom</th>
                <th style="text-align: left;">Main Store</th>
                <th  style="text-align: left;">Approval Status</th>
                <th  style="text-align: left;">Status</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (!empty($requisition_list))

            @foreach ($requisition_list as $row)
            <tr class="tr_border">
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">
                    {{ $row['assign_by_name'] }}
                </td>
                <td class="text-center">
                    {{ $row['inv_requisition_po_no_pk'] }}
                </td>

                <td>{{ $row['req_at'] != '' ? date('d-m-Y h:i:s a', strtotime($row['req_at'])) : '' }}
                </td>
                <td class="text-center">
                    {{ $row['item_name'] }}
                </td>
                <td class="text-center">
                    {{ $row['req_quantity'] }}
                </td>
                <td class="text-center">
                    {{ $row['item_pur_uom_name'] }}
                </td>
                <td>{{ $row['serviceunit_name'] }}</td>
                <td class="text-center">
                    @if (strpos($row['approval_status_text'], 'REJECTED') >= 1 || strpos($row['approval_status_text'], 'HOLD') >= 1)
                    <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}" data-id="{{ $row['inv_requisition_po_no_pk'] }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
                    </a>
                    <span class="text-danger">{{ strpos($row['approval_status_text'], 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                    @else
                    @if ($row['approval_level_status_text'] != '')
                    @php
                    $lavel = explode('/', $row['approval_level_status_text']);
                    $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                    $approval_person = $row['approval_level_status_text'] != '' ? explode('/', $row['approval_level_status_text']) : '';

                    @endphp
                    @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                    <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}" data-id="{{ $row['inv_requisition_po_no_pk'] }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-success">({{ $row['approval_level_status_text'] }})
                        </span>
                    </a>
                    @else
                    <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}" data-id="{{ $row['inv_requisition_po_no_pk'] }}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
                    </a>
                    @endif
                    {{ $approval_status }}
                    @endif
                    @endif
                </td>
                <td class="text-center">
                    {{ $row['assign_ind'] ==1 ? 'Assigned' : 'Pending' }}
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