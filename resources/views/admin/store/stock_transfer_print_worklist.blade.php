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
                    <div style="text-align: center;"> <strong>Stock @if ($type) {{ ucfirst($type) }}@else Transfer  @endif Details Report</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-center " style="width:3%">SL</th>
                <th class="text-left " style="width:7%">ID</th>
                <th class="text-left " style="width:7%">
                    @if ($type)
                        {{ $type . ' Date' }}
                    @else
                        Transfer Date
                    @endif
                </th>
                <th class="text-left " style="width:10%">
                    @if ($type)
                        {{ $type . ' By' }}
                    @else
                        Transfer By
                    @endif


                </th>
                <th class="text-left " style="width:10%">Item Name</th>
                <th class="text-center " style="width:3%">UoM</th>
                <th class="text-left " style="width:7%">Internal Batch No</th>
                <th class="text-left " style="width:9%">Batch No</th>
                <th class="text-left " style="width:10%">Expiry Date</th>
                <th class="text-left " style="width:5%">Purchase Price</th>
                <th class="text-left " style="width:5%">Sales Price</th>
                <th class="text-left " style="width:10%">To Store</th>
                <th class="text-center " style="width:5%">Qty</th>
                <th class="text-center " style="width:5%">Receive Qty</th>
                <th class="text-center " >Status</th>
                <th class="text-center " style="width:10%">Remarks</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @if (!empty($transferData))
                @foreach ($transferData as $stock)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                            <input type="hidden" name="item_id[]" id="item_id" class="item_id"
                                value="{{ $stock->item_no_fk }}">
                            <input type="hidden" name="itemadjmentdtll_no_fk[]" id="itemadjmentdtll_no_fk"
                                class="itemadjmentdtll_no_fk" value="{{ $stock->itemadjmentdtll_no_pk }}">
                            <input type="hidden" name="itemadjment_no_fk[]" id="itemadjment_no_fk"
                                class="itemadjment_no_fk" value="{{ $stock->itemadjment_no_fk }}">
                            <input type="hidden" name="uom_no[]" id="uom_no" class="uom_no"
                                value="{{ $stock->uom }}">
                            <input type="hidden" name="from_store_no[]" id="from_store_no" class="from_store_no"
                                value="{{ $stock->from_store_no_fk }}">
                            <input type="hidden" name="to_store_no[]" id="to_store_no" class="to_store_no"
                                value="{{ $stock->store_su_no_fk }}">
                            <input type="hidden" name="itemadjment_type[]" id="itemadjment_type"
                                class="itemadjment_type"
                                value="{{ $stock->itemadjment_type == 'ISSUE' ? 'RECEIVE' : 'RTNRCV' }}">
                            <input type="hidden" name="internal_batch_no_uq[]" id="internal_batch_no_uq"
                                class="internal_batch_no_uq" value="{{ $stock->internal_batch_no_uq }}">
                            <input type="hidden" name="batch_no[]" id="batch_no" class="batch_no"
                                value="{{ $stock->batch_no }}">
                            <input type="hidden" name="expiry_date[]" id="expiry_date" class="expiry_date"
                                value="{{ $stock->expiry_date }}">
                            <input type="hidden" name="adjustment_qty[]" id="adjustment_qty" class="adjustment_qty"
                                value="{{ $stock->item_qty }}">
                            <input type="hidden" name="purchase_price[]" id="purchase_price" class="purchase_price"
                                value="{{ $stock->purchase_price }}">
                            <input type="hidden" name="cost_price[]" id="cost_price" class="cost_price"
                                value="{{ $stock->cost_price }}">
                            <input type="hidden" name="request_qty[]" id="request_qty" class="request_qty"
                                value="{{ $stock->item_qty }}">
                        </td>
                        <td class="text-left">{{ $stock->itemadjment_no_fk }}</td>
                        <td class="text-left">
                            {{ isset($stock->au_entry_at) && $stock->au_entry_at != '' ? date('d/m/Y', strtotime($stock->au_entry_at)) : '' }}
                        </td>

                        <td class="text-left">{{ $stock->user_fullname }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-center">{{ $stock->uom_name }}</td>
                        <td class="text-left">{{ $stock->internal_batch_no_uq }}</td>
                        <td class="text-left">{{ $stock->batch_no }}</td>
                        <td class="text-left">
                            {{ isset($stock->expiry_date) && $stock->expiry_date != '' ? date('d/m/Y', strtotime($stock->expiry_date)) : '' }}
                        </td>
                        <td class="text-right">{{ number_format($stock->purchase_price, 2) }}</td>
                        <td class="text-right">{{ number_format($stock->trade_price, 2) }}</td>
                        <td class="text-left">{{ $stock->to_store }}</td>
                        <td class="text-center transfer_qty" id="transfer_qty">{{ $stock->item_qty }}</td>
                        <td class="text-center" id="">{{ $stock->receive_qty }}</td>
                        <td class="text-center transfer_qty">
                            @if ($stock->receive_qty == '' && $stock->from_store != '')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($stock->item_qty == $stock->receive_qty)
                                <span class="badge bg-success"> Received</span>
                            @elseif ($stock->item_qty > $stock->receive_qty && $stock->from_store != '')
                                <span class="badge bg-info"> Partial</span>
                            @endif

                        </td>
                        <td class="text-left">{{ $stock->remarks }}</td>

                        {{-- <td class="text-center" style="width:5%"><input type="text"
                                class="number_only receive_qty" name="receive_qty[]" id="receive_qty"
                                onkeyup="checkQty(this)" value=""></td>
                        <td>
                            <input type="checkbox" name="receive_check[]" id="receive_check" class="receive_check">
                            <span class="btn btn-sm btn-info" onclick="receiveItem()" data-invoice="69760"
                                title="Receive"><i class="fa fa-save"></i></span>
                        </td> --}}
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
