@php
    use Carbon\Carbon;
    $po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
    ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Wise Stock Report (In Whole Hospital)</title>
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
                <td colspan="8">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> 
                                    <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong>
                                </span>
                                <br>
                                Address:
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                </span>
                                <br>
                                Phone No:
                                <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Item Wise Stock Report (In Whole Hospital)</strong> </div>
                    {{-- <div style="text-align: center;">
                        <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                    </div> --}}
                </td>
            </tr>

            <tr class="tr_border">
                <th class="text-center" style="width: 5%;">SL.</th>
                <th class="text-center" style="width: 10%;">Department</th>
                <th class="text-center" style="width: 10%;">Item Code</th>
                <th class="text-center" style="width: 25%;">Item Name</th>
                <th class="text-center" style="width: 10%;">Generic Name</th>
                <th class="text-center" style="width: 20%;">Supplier Name</th>
                <th class="text-center" style="width: 10%;">Purchase Price</th>
                <th class="text-center" style="width: 10%;">Sales Price</th>
                <th class="text-center" style="width: 10%;">Stock Qty</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @if(!empty($items))
                @foreach($items as $item)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td style="text-align:center">{{ $item->serviceunit_name }}</td>
                        <td style="text-align:center">{{ $item->item_code }}</td>
                        <td style="text-align:left">{{ $item->item_name }}</td>
                        <td style="text-align:left">{{ $item->generic_name }}</td>
                        <td style="text-align:left">{{ $item->supplier_name }}</td>
                        <td style="text-align:right">{{ $item->purchase_price }}</td>
                        <td style="text-align:right">{{ $item->sales_price }}</td>
                        <td style="text-align:center">{{ $item->stock_qty }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>

        {{-- <tfoot>
            <tr>
                <td style="width: 100%; " colspan="7">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">
                                @php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                @endphp
                                <strong>Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}</strong>
                            </td>
                            <td style="font-size: 9px; border:none;">
                                <strong>Powered By: NEXTGEN IT</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot> --}}
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
