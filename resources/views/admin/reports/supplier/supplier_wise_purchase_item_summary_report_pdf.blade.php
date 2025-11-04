<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supplier Wise Summary Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    {{-- <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all"> --}}

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }
    </style>

</head>

<body>
    <header>
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


                </td>
            </tr>
        </table>
    </header>





    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
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
            </div>
        </div>
    </footer>

    <main>

        <div class="wrapper">
            <section id="prescription">
                <div class="container">
                    <div style="width:100%; text-align: center; margin-bottom:20px;">
                        <p style="width:100%;  margin-bottom:20px;">
                        <h3><u>Supplier Wise Purchase Details Report </u></h3>
                        </p>
                        <p style="text-align: left;"> <strong>From :</strong> {{ $date_from }} <strong>To :</strong>
                            {{ $date_to }}</p>
                    </div>


                    <div>

                        <table border="1" class="m-0" width="100%">
                            <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
                                <tr class="bg-light-blue">
                                    <th class="text-center">SL#</th>
                                    <th class="text-left">Group Name</th>
                                    <th class="text-left">Item Description</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">P. Rate</th>
                                    <th class="text-right">Amount(tk.)</th>
                                </tr>
                            </thead>
                            <tbody>


                                @php
                                    $sales_total = 0;
                                    $grand_sales_total = 0;
                                    $net_sales = 0;
                                    $return_amt_adj = 0;

                                    $sup_vari1 = 'Test';
                                    $sup_vari2 = 'Test';
                                    $i = 0;
                                @endphp

                                @if (!empty($supplier_wise_total))
                                    @foreach ($supplier_wise_total as $key => $suppilers)
                                        <tr>
                                            <td class="text-left" colspan="7"><strong>{{ $key }}</strong>
                                            </td>
                                        </tr>
                                        @foreach ($suppilers as $suppiler)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                @if ($sup_vari1 != $suppiler->generic_name)
                                                    @php
                                                        $sup_vari1 = $suppiler->generic_name;
                                                    @endphp
                                                    <td class="text-left">
                                                        {{ $suppiler->generic_name }}</td>
                                                @else
                                                    <td></td>
                                                @endif


                                                <td class="text-left">
                                                    {{ $suppiler->item_name }}</td>

                                                {{-- <td class="text-left">{{$value->person_code}}</td> --}}
                                                <td class="text-center">
                                                    {{ $suppiler->pr_uom_short }}</td>
                                                <td class="text-center">
                                                    {{ $suppiler->unit_qty }}</td>


                                                <td class="text-right">
                                                    {{ number_format($suppiler->purchase_price, 2, '.', '') }}</td>

                                                <td class="text-right">
                                                    {{-- {{ number_format((($suppiler->unit_qty * $suppiler->purchase_price) + number_format( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm, 2, '.', '') }} --}}
                                                    {{ number_format($suppiler->unit_qty * $suppiler->purchase_price + $suppiler->vat_amount_itm - $suppiler->discount_amount_itm) }}
                                                </td>

                                            </tr>

                                            @php
                                                // $sales_total += (($suppiler->unit_qty * $suppiler->purchase_price) + number_format( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm;

                                                // $grand_sales_total += (($suppiler->unit_qty * $suppiler->purchase_price) + number_format( $suppiler->vat_amount_itm)) - $suppiler->discount_amount_itm;
                                                $sales_total += $suppiler->unit_qty * $suppiler->purchase_price + $suppiler->vat_amount_itm - $suppiler->discount_amount_itm;

                                                $grand_sales_total += $suppiler->unit_qty * $suppiler->purchase_price + $suppiler->vat_amount_itm - $suppiler->discount_amount_itm;
                                            @endphp
                                        @endforeach

                                        <tr>

                                            <th class="text-right bg-light-blue" colspan="6">Sub Total</th>
                                            <th class="text-right bg-light-blue">{{ number_format($sales_total, 2) }}
                                            </th>

                                        </tr>
                                        @php
                                            $sup_vari1 = 'Test';
                                            $sales_total = 0;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>

                                    <th class="text-right bg-light-blue" colspan="6">Grand Total</th>
                                    <th class="text-right bg-light-blue">{{ number_format($grand_sales_total, 2) }}
                                    </th>

                                </tr>
                            </tfoot>
                        </table>
                        </table>
                    </div>


                </div>
            </section>
        </div>
    </main>
</body>

</html>
