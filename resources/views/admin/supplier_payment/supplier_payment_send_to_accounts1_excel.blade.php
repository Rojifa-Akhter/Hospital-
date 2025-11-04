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
                    <div style="text-align: center;"> <strong> Accounts Approval Report</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center" style="width: 30px;">Sl.</th>
                <th class="text-center" style="width: 100px;">Bill Process No / Date</th>
                <th class="text-center" style="width: 100px;">GRN No</th>
                <th class="text-center" style="width: 100px;">PO No</th>
                <th class="text-center" style="width: 100px;">Challan No</th>
                <th>Store</th>
                <th>Supplier</th>
                <th class="text-right" style="width: 100px;">Receive Amt</th>
                <th class="text-right" style="width: 100px;">Return Amt</th>
                <th class="text-right" style="width: 100px;">Current Amt</th>
                <th class="text-center" style="width: 140px;">Status </th>
            </tr>
        </thead>
   
        <tbody class="tr_border">
            @php
                $total = 0;
                
            @endphp
           
            @if (!empty($grn_data_arr))
                @php
                    $previousValue = null;
                @endphp
                @foreach ($grn_data_arr as $key => $row)
                    <tr class="tr_border">
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        @if ($row->accbillprocessmst_no_fk != $previousValue)
                            <td rowspan="{{ $grn_data_arr->where('accbillprocessmst_no_fk', $row->accbillprocessmst_no_fk)->count() }}"
                                class="text-center">
                                <a target="_blank"
                                    href="{{ route('supplier-payment-sent-to-accounts-pdf', $row->accbillprocessmst_no_fk) }}"
                                    class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a><br>
                                {{ $row->accbillprocessmst_no_fk }} <br>
                                {{ $row->au_entry_at != '' ? date('d/m/Y', strtotime($row->au_entry_at)) : '' }}
                            </td>
                        @endif
                        <td class="text-center">{{ $row->itemreceive_no_fk }}</td>
                        <td class="text-center">{{ $row->purchaseorder_no_fk }}</td>
                        <td class="text-center">{{ $row->challan_no }}</td>
                        <td>{{ $row->serviceunit_name }}</td>
                        <td>{{ $row->supplier_name }}</td>
                        <td class="text-right">{{ number_format($row->grnmst_amnt, 2, '.', ',') }}</td>
                        <td class="text-right">{{ number_format($row->grnrtn_amt, 2, '.', ',') }}</td>
                        <td class="text-right">{{ number_format($row->payable_amnt, 2, '.', ',') }}</td>
                        <td class="text-center">
                            @if ($row->approval_ind == 1)
                               Approved
                            @else
                                Pending
                            @endif
                           
                        </td>
                    </tr>
                    @php
                        $total += $row->payable_amnt;
                    @endphp
                    <?php $previousValue = $row->accbillprocessmst_no_fk; ?>
                @endforeach
                <tr>
                    <td class="text-right" colspan="9"><strong>Total=</strong></td>
                    <td class="text-right"> <strong>{{ number_format($total, 2, '.', ',') }}</strong></td>
                    <td></td>
                </tr>
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="9">
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
