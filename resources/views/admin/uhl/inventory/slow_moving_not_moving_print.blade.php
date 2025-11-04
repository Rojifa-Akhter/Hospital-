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
    <title>
            Non Moving Report
    </title>
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
                <td colspan="9" style="">
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
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>
                        Non Moving Report
                        </strong> </div>

                    <div style="text-align: center;"> <strong>
                            <?php
                            if ($reptype == 'SLOWMOVING') {
                                $from_date = date('d/m/Y', strtotime('-90 days')); // 90 days before today
                            } else {
                                $from_date = date('d/m/Y', strtotime('-180 days')); // 90 days before today
                            }

                            $to_date = date('d/m/Y'); // today's date
                            ?>
                            <span class="report-date"><strong>From Date: <?php echo $from_date; ?></strong> -
                                <span class="report-date"><strong>To Date: <?php echo $to_date; ?></strong></span>
                        </strong> </div>
                </td>
            </tr>
            @if (isset($store_name_txt) && !empty($store_name_txt))
                <tr>
                    <td colspan="9" style="text-align: left;">Store Name: <strong>{{ $store_name_txt }}</strong></td>
                </tr>
            @endif


            <tr class="tr_border">
                <th class="bg-soft-green text-left">SL</th>
                <th class="bg-soft-green text-left">Generic Name</th>
                <th class="bg-soft-green text-left">Category</th>
                <th class="bg-soft-green text-left">Sub. Category</th>
                <th class="bg-soft-green text-left">Item Name</th>
                <th class="bg-soft-green text-left">Last Purchase Price</th>
                <th class="bg-soft-green text-left">Last Sale Price</th>
                <th class="bg-soft-green text-left">Current Stock</th>
                <th class="bg-soft-green text-left">Store Name</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (!empty($report_data))


                @foreach ($report_data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ !empty($item->generic_name) ? $item->generic_name : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->catagory) ? $item->catagory : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->sub_catagory) ? $item->sub_catagory : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->item_name) ? $item->item_name : 'N/A' }}</td>
                        <td class="text-right">
                            {{ !empty($item->purchase_price) ? number_format($item->purchase_price, 2) : 'N/A' }}</td>
                        <td class="text-right">
                            {{ !empty($item->sales_price) ? number_format($item->sales_price, 2) : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($item->curr_stk) ? $item->curr_stk : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->store) ? $item->store : 'N/A' }}</td>
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
