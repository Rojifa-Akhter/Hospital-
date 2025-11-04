<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescribe & Sales Medicine</title>
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

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            /* border: 1px solid #dddddd; */
            text-align: left;
            /* padding: 8px; */
            vertical-align: top;
        }

        tr:nth-child(even) {
            /* background-color: #dddddd; */
        }
    </style>
<body onload="window.print();">
    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                {{-- <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt=""> --}}
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
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span><br>
                                From Date: <span>{{ isset($from_date) ? $from_date : '' }}</span>,
                                To Date: <span>{{ isset($to_date) ? $to_date : '' }}</span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="">
                    <h2 style="text-align: center; margin-top: 20px; padding: 10px; border: 1px solid black;">Not Sales Medicine</h2>
                    @foreach($prescribeMedicine as $idx => $items)
                        <h4 class="text-center" style="border-bottom: 1px solid gray; text-align:center;">Doctor Name: {{ $idx }}</h4>
                        <table style="width: 500px; border:1px solid black; margin: auto;" class="signature">
                            <thead style="width: 100%; border:1px solid black;">
                                <tr>
                                    <th style="width: 10%; border:1px solid black;">Sl.</th>
                                    <th style="width: 30%; border:1px solid black;">Generic Name</th>
                                    <th style="width: 40%; border:1px solid black;">Brand Name</th>
                                    <th style="width: 20%; border:1px solid black;">Stock Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $index => $item)
                                <tr>
                                    <td style=" text-align:center; width: 10%;  border:1px solid black;">
                                        {{ ++$index }}
                                    </td>
                                    <td style=" text-align:left; width: 30%;  border:1px solid black;">
                                        {{ substr($item->generic_name, 0, 70) }}
                                    </td>
                                    <td style=" text-align:left; width: 40%;  border:1px solid black;">
                                        {{ $item->item_name }}
                                    </td>
                                    <td style=" text-align:center; width: 20%;  border:1px solid black;">
                                        {{ $item->stk_qty }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </td>
                <td colspan="6" style="">
                    <h2 style="text-align: center; margin-top: 20px; padding: 10px; border: 1px solid black;">Sales Medicine</h2>
                    <table style="width: 500px; border:1px solid black; margin: auto;" class="signature">
                        <thead style="width: 100%; border:1px solid black;">
                            <tr>
                                <th style="width: 60%; border:1px solid black;">Generic Name</th>
                                <th style="width: 40%; border:1px solid black;">Brand Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesMedicine as $index => $item)
                            <tr>
                                <td style=" text-align:left; width: 60%;  border:1px solid black;">
                                    {{ substr($item->generic_name, 0, 70) }}
                                </td>
                                <td style=" text-align:left; width: 40%;  border:1px solid black;">
                                    {{ $item->item_name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody></tbody>
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
</body>

</html>