<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Purchase Order Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/invoice.css" media="all" />
    <style type="text/css">
        @page {
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            margin-top: 3.cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 2cm;
            text-align: center;
            font-size: 9px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
            padding-top: 10px;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            height: 2.5cm;
            font-size: 9px;
            /*top: -10px;*/
            border-top: 1px solid black;
            padding-top: 10px;
            z-index: 999999999;
        }
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
@endphp

<body>
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            <tr style="">
                <td style="width: 15%; border-right:1px solid transparent!important">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>

    <footer style="border-top: 1px solid transparent;">
        <div class="">

            @if (Session::get('user.ses_hospital_code') == 'JKMH')
                <div class="">
                    <table style="width: 100%; border:none ">
                        <tr style=" ">
                            <td style="text-align:left; border:none ">
                                <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                            </td>
                            <td style="text-align:left; border:none ">
                                <span style="padding:5px; border-top: black solid 1px;">Manager Accounts</span>
                            </td>

                            <td style="text-align:center; border:none">
                                <span style="padding:5px; border-top: black solid 1px;">DGM
                                </span>
                            </td>

                            <td style="text-align:right; border:none">
                                <span style="padding:5px; border-top: black solid 1px;">DMD
                                </span>
                            </td>

                        </tr>
                    </table>
                </div>
            @else
                <table style="width: 100%; border:none ">
                    <tr style=" ">
                        <td style="text-align:left; border:none ">
                            <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                        </td>

                        <td style="text-align:center; border:none">
                            <span style="padding:5px; border-top: black solid 1px;"> Checked By</span>
                        </td>

                        <td style="text-align:right; border:none">
                            <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                        </td>
                    </tr>
                </table>
            @endif
        </div>

        <table style="border:0px; border-top:1px solid #222;">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                    {{ $userInfo->user_fullname }} &nbsp;&nbsp; Printing Date & Time: {{ date('d/m/Y') }}</td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
        <div id="details" class="clearfix">
            <p
                style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; margin-top: 25px;">
                GRN Report</p>
            <div class="" style=" margin-top: 25px !important; margin-bottom: 25px;">
                <div style="float: left; width: 50%">
                    <strong><i style="color: blue;"><b>Office Copy</b></i></strong><br>
                    <strong>Supplier Name :</strong>
                    {{ !empty($grn_report_list[0]->supplier_name) ? ucfirst($grn_report_list[0]->supplier_name) : 'n/a' }}<br>
                    <strong>Order No :</strong>
                    {{ !empty($grn_report_list[0]->po_no) ? $grn_report_list[0]->po_no : '' }}<br>
                    <strong>Delivery Location :</strong>
                    {{ !empty($grn_report_list[0]->delivery_location) ? $grn_report_list[0]->delivery_location : 'n/a' }}<br>
                </div>
                <div style="float: right; width: 50%; text-align: right;">
                    <img style="" src="data:image/png;base64, {{ $grn_barcode_no }} " style="width: 120px; " />
                    <br>
                    <strong>GRN ID :</strong> {{ $grn_barcode }}<br>
                    <strong>Date of GRN :</strong>
                    {{ date('d/m/Y', strtotime($grn_report_list[0]->challan_date)) }}<br>
                </div>
            </div>
        </div>

        <table style="margin-top: 30px; width:100%" border="1">
            <thead>
                <tr>
                    <td colspan="11" style="background: black"></td>
                </tr>
                <tr>
                    <th class="text-center" style="width: 10px">SL#</th>
                    <th class="text-left" style="">Item Name</th>
                    <th class="text-center" style="">Item UoM</th>
                    <th class="text-center" style="">Order Qty</th>
                    <th class="text-center" style="">Delivered Qty</th>
                    <th class="text-center" style="">Free Qty</th>
                    <th class="text-center" style="">Total Qty</th>
                    <th class="text-right" style="">Rate</th>
                    <th class="text-right" style="">Vat Amt.</th>
                    <th class="text-right" style="">Dis. Amt.</th>
                    <th class="text-right" style="">Amount <br> (<small>BDT</small>) </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totals = 0;
                @endphp

                @if (!empty($grn_report_list))
                    @foreach ($grn_report_list as $row)
                        @php
                            $urgent_fee = 0;
                            $free_qty = $row->freeitem_qty != '' ? $row->freeitem_qty : 0;
                        @endphp
                        <tr>
                            <td style="border:0px; padding: 2px !important; text-align:center">
                                {{ sprintf('%02d', $loop->iteration) }}</td>
                            <td style="border:0px; padding: 2px !important; text-align:left">
                                {{ !empty($row->item_name) ? $row->item_name : '' }}

                            </td>
                            <td style="border:0px; padding: 2px !important; text-align:center">
                                {{ !empty($row->pr_uom_name) ? $row->pr_uom_name : '' }}
                                ({{ $row->pr_uom_conversion_qty }} {{ $row->uom_name }})
                            </td>

                            <td class="item_rate" style="border:0px; padding: 2px !important; text-align:center">
                                {{ !empty($row->order_qty) ? $row->order_qty . ' ' . $row->pr_uom_name : '' }}</td>
                            <td class="" style="border:0px; padding: 2px !important; text-align:center">
                                {{ !empty($row->delivered_qty) ? $row->delivered_qty / $row->pr_uom_conversion_qty : '' }}
                                {{ $row->pr_uom_name }}</td>
                            <td class="" style="border:0px; padding: 2px !important; text-align:center">
                                {{ !empty($row->freeitem_qty) ? $row->freeitem_qty : '' }}
                                {{ $row->free_uom_name }}</td>
                            <td class="" style="border:0px; padding: 2px !important; text-align:center">
                                {{ !empty($row->delivered_qty) ? $row->delivered_qty + $free_qty : '' }}
                                {{ $row->uom_name }}</td>

                            <td class=" bg-light" style="border:0px; padding: 2px !important; text-align:right">
                                {{ !empty($row->unit_price) ? number_format($row->unit_price, 2) : 0 }}
                            </td>
                            <td class=" bg-light" style="border:0px; padding: 2px !important; text-align:right">
                                {{ !empty($row->vat_amount) ? number_format($row->vat_amount, 2) : 0 }}
                            </td>
                            <td class=" bg-light" style="border:0px; padding: 2px !important; text-align:right">
                                {{ !empty($row->discount_amount) ? number_format($row->discount_amount, 2) : 0 }}
                            </td>
                            <td class=" bg-light" style="border:0px; padding: 2px !important; text-align:right">
                                {{ !empty($row->unit_price) ? number_format($row->unit_price * $row->delivered_qty, 2) : 0 }}
                            </td>
                        </tr>
                        @php
                            $totals += !empty($row->unit_price) ? $row->unit_price * $row->delivered_qty : 0;
                        @endphp
                    @endforeach
                @endif
                @php
                    $sub_total = 0;
                    $total = 0;
                    $vat_percent = isset($grn_report_list[0]->vat_percent) ? $grn_report_list[0]->vat_percent : 0;
                    $vat_amount = isset($grn_report_list[0]->vat_amount) ? $grn_report_list[0]->vat_amount : 0;
                    $discount = 0;
                    $discount_percent = isset($grn_report_list[0]->discount_percent) ? $grn_report_list[0]->discount_percent : 0;
                    $discount_amount = isset($grn_report_list[0]->discount_amount) ? $grn_report_list[0]->discount_amount : 0;
                    $discount = 0;
                    $payment = 0;
                    $payable = 0;
                    $due = 0;
                    $due = 0;

                    $number = number_format($totals - $discount, 2, '.', '');
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, $number);
                @endphp
            </tbody>


            {{-- <tfoot style="border-top: 1px solid #111">
            <tr>
                <td class="" rowspan="8" colspan="2" style="border:0px; padding: 2px !important;"></td>
                <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total :</b></td>
                <td class="text-right" colspan="1" style="border:0px; padding: 2px !important;"><strong> {{ number_format($totals, 2) }} </strong></td>
            </tr>
            <tr>

                <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total VAT/Tax </b>({{ number_format($vat_percent, 2) }} %) :</td>
                <td class="text-right" style="border:0px; padding: 2px !important;" colspan="1"> <strong> {{ number_format($vat_amount, 2) }}</strong></td>
            </tr>

            <tr>

                <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total Discount </b>   ({{ number_format($discount_percent, 2) }} %): </td>
                <td class="text-right" style="border:0px; padding: 2px !important;" colspan="1"> <strong>{{ number_format($discount_amount, 2) }} </strong></td>
            </tr>

            <tr>
                <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Payable :</b></td>
                <td class="text-right" style="border:0px; padding: 2px !important;" colspan="1"> <strong> {{ number_format($totals + $vat_amount - $discount_amount, 2) }}</strong></td>
            </tr>


            @php $due = 0; @endphp

        </tfoot> --}}

        </table>

        <table style="width: 100%;border: none;">
            <tr>
                <td style="width: 100%;border: none;">
                    <table style="width: 100%; border: none;"">
                        <tbody>
                            <tr>
                                <td class="" rowspan="8" colspan="2"
                                    style="border:0px; padding: 2px !important;">
                                </td>
                                {{-- <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total :</b></td> --}}
                                <td class="text-right" " style=" border:0px; padding: 2px !important;"><strong>Total :
                                        {{ number_format($totals, 2) }} </strong></td>
                            </tr>
                            <tr>

                                {{-- <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total VAT/Tax </b>({{ number_format($vat_percent, 2) }} %) :</td> --}}
                                <td class="text-right" style="border:0px; padding: 2px !important;"><b>Total VAT/Tax
                                    </b>({{ number_format($vat_percent, 2) }} %) : <strong>
                                        {{ number_format($vat_amount, 2) }}</strong></td>
                            </tr>

                            <tr>

                                {{-- <td class="text-right" colspan="6" style="border:0px; padding: 2px !important;"><b>Total Discount </b>   ({{ number_format($discount_percent, 2) }} %): </td> --}}
                                <td class="text-right" style="border:0px; padding: 2px !important;"><b>Total Discount </b>
                                    ({{ number_format($discount_percent, 2) }} %):
                                    <strong>{{ number_format($discount_amount, 2) }} </strong></td>
                            </tr>

                            <tr>
                               <td class="text-right" style="border:0px; padding: 2px !important;"><b>Payable :</b> <strong>
                                        {{ number_format($totals + $vat_amount - $discount_amount, 2) }}</strong></td>
                            </tr>
                            <tr>
                                @php
                                    $adj_amt= !empty($return_adj_amt)? round($return_adj_amt->adjustment_amount) : 0;
                                @endphp
                               <td class="text-right" style="border:0px; padding: 2px !important;"><b>Adjustment Amt. :</b> <strong>
                                        {{ number_format(  $adj_amt, 2) }}</strong></td>
                            </tr>
                            <tr>
                               <td class="text-right" style="border:0px; padding: 2px !important;"><b> Net Payable :</b> <strong>
                                        {{ number_format($totals + $vat_amount - (  $adj_amt + $discount_amount), 2) }}</strong></td>
                            </tr>


                            @php $due = 0; @endphp
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>


    </main>



</body>

</html>
