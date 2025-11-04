<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Purchase Order Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/purchase_order_print.css" media="all" />
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
            margin-top: 2.5cm;
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
            /*top: -10px;
            border-top: 1px solid black;*/
            padding-top: 10px;
            z-index: 999999999;
        }



    </style>
</head>
@php
//dd($po_hospital_details );
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
//dd(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo));
@endphp

<body>
    <header>
        <table style="width: 100%; border-collapse:collapse;" class="signature">
            <tr style="">
                <td style="width: 15%;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="" />
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>

    <footer style="border-top: 1px solid transparent;">
        <div class="">
            <table style="width: 100%; border:none " >
                <tr style=" ">
                    <td style="text-align:left; width:20%; border-top: black solid 1px;">
                        <span style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name :'' }}</span><br>
                        {{-- <span style="padding:5px;">GM, Admin & Procurement</span><br> --}}

                        <span style="padding:5px;">Prepared By</span>

                    </td>
                    <td style="border:none"></td>

                    <td style="text-align:center; width:20%;border-top: black solid 1px;">
                        <span style="padding:5px; ">{{ isset($signed_user) ? $signed_user->passed_by_name:'' }} </span><br>
                        {{-- <span style="padding:5px;">Director, Admin</span><br> --}}

                        <span style="padding:5px;">Manager (Accounts)</span>

                    </td>
                    <td style="border:none"></td>

                    <td style="text-align:center; width:20%;border-top: black solid 1px;">
                        <span style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name:'' }}</span><br>
                        {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                        <span style="padding:5px;">DGM</span>
                    </td>
                    <td style="border:none"></td>
                    <td style="text-align:center; width:20%;border-top: black solid 1px;">
                        <span style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name:'' }}</span><br>
                        {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                        <span style="padding:5px;">DMD</span>
                    </td>
                </tr>
            </table>
        </div>

        <table style="border:0px; border-top:1px solid #222;">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By: {{ $userInfo->user_fullname }} &nbsp;&nbsp; Printing Date & Time: {{ date('d/m/Y') }}</td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
        <div id="details" class="clearfix" style="margin-left:10px;">
            <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; margin-top: 25px;">Purchase Order</p>
            <div class="" style=" margin-top: 25px !important; margin-bottom: 25px;">
                <div style="float: left; width: 50%">
                    <strong>Ref:</strong> {{ $po_master_info->reference_no }}<br>
                    <strong>Date:</strong> {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                    {{-- <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                    <strong>Email:</strong> {{ $po_master_info->e_mail }}<br> --}}
                </div>
                <div style="float: right; width: 50%; text-align: right;">
                    <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                    <br>
                    <strong>Purchase Order ID:</strong> {{ $purchase_order_id }}<br>
                    <strong>Date of PO:</strong> {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                </div>
            </div>
        </div>
        <div id="details" class="clearfix" style="margin-left:10px;">
            {{-- <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; margin-top: 25px;">Purchase Order</p> --}}
            <div class="" style=" margin-top: 10px !important; margin-bottom: 10px;">
                <div style="float: left; width: 50%">
                    <strong>To:</strong> {{ $po_master_info->supplier_name }}<br>
                    <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                    <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                    <strong>Email:</strong> {{ $po_master_info->e_mail }}<br>
                </div>
                {{-- <div style="float: right; width: 50%; text-align: right;">
                    <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                    <br>
                    <strong>Purchase Order ID:</strong> {{ $purchase_order_id }}<br>
                    <strong>Date of PO:</strong> {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                </div> --}}
            </div>
        </div>
        <div id="details" class="clearfix" style="margin-left:10px;">
            {{-- <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; margin-top: 25px;">Purchase Order</p> --}}
            <div class="" style=" margin-top: 25px !important; margin-bottom: 25px;">
                {{-- <div style="float: left; width: 50%">
                    <strong>To:</strong> {{ $po_master_info->supplier_name }}<br>
                    <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                    <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                    <strong>Email:</strong> {{ $po_master_info->e_mail }}<br>
                </div> --}}
                <div style="float: left; width: 50%;">
                    {{-- <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " /> --}}
                    {{-- <br> --}}
                    <strong>Sub:</strong> {{ $po_master_info->reference_sub }}<br>
                     {{-- {{ $po_master_info->reference_sub_body }}<br> --}}
                    {{-- <strong>Date of PO:</strong> {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br> --}}
                </div>
            </div>
        </div>
            <div id="details" class="clearfix" style="margin-left:10px;">
            {{-- <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; margin-top: 25px;">Purchase Order</p> --}}
            <div class="" style=" margin-top: 10px !important;">
                {{-- <div style="float: left; width: 50%">
                    <strong>To:</strong> {{ $po_master_info->supplier_name }}<br>
                    <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                    <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                    <strong>Email:</strong> {{ $po_master_info->e_mail }}<br>
                </div> --}}
                <div style="float: left; width: 50%;">
                    {{-- <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " /> --}}
                    {{-- <br> --}}
                    {{-- <strong>Sub:</strong> {{ $po_master_info->reference_sub }}<br> --}}
                     {{ $po_master_info->reference_sub_body }}<br>
                    {{-- <strong>Date of PO:</strong> {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br> --}}
                </div>
            </div>
        </div>

        <table class="" border="1" style="margin-top: 0px; width:100%">
            <thead>
                <tr>
                    <th class="text-center">#SL</th>
                    <th class="text-left">Item Code</th>
                    <th class="text-left">Item Name</th>
                    <th class="text-left">Item UoM</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-center" >Vat(%)</th>
                    <th class="text-right">Vat Amount</th>
                    <th class="text-center">Discount(%)</th>
                    <th class="text-right ">Discount Amount</th>
                    <th class="text-right">Total Amount (<small>BDT</small>)</th>

                </tr>
            </thead>
            <tbody>
               <?php $total = 0; ?>
               @if (isset($po_child_details_info))
               @foreach ($po_child_details_info as $value)
               <tr>
                <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $value->item_code }}</td>
                <td class="text-left">{{ $value->item_name }}</td>
                <td class="text-left">{{ $value->pr_uom_name }} ({{ $value->pr_uom_conversion_qty }} {{ $value->uom_name }})</td>
                <td class="text-center">{{ $value->entry_qty }} {{ $value->pr_uom_name }} </td>
                <td class="text-center">{{ $value->entry_qty* $value->pr_uom_conversion_qty }} {{ $value->uom_name }} </td>
                <td class="text-right">{{ $value->pr_uom_tradeprice }}</td>
                <td class="text-right">{{ $value->vat_percent_itm }}</td>
                <td class="text-right">{{ $value->vat_amount_itm }}</td>
                <td class="text-right">{{ $value->discount_percent_itm }}</td>
                <td class="text-right">{{ $value->discount_amount_itm }}</td>
                <td class="text-right">
                    {{ number_format($value->entry_qty * $value->item_rate, 2, '.', '') }}
                </td>
            </tr>
            @php $total +=$value->entry_qty*$value->item_rate; @endphp
            @endforeach
            @endif
        </tbody>


        <tfoot>
            <tr>
                <td class="border-0" colspan="11"></td>
                <td class="border-0 text-right bg-light">
                    <strong>Total:</strong> {{ number_format($total, 2, '.', '') }}
                </td>
            </tr>
            <tr>
                <td class="border-0" colspan="11"></td>
                <td class="border-0 text-right bg-light">
                    <strong>VAT/Tax({{ number_format($po_master_info->vat_percent , 2, '.', '') }}%):</strong> {{ number_format($po_master_info->vat_amount , 2, '.', '') }}
                </td>
            </tr>
            <tr>
                <td class="border-0" colspan="11"></td>
                <td class="border-0 text-right bg-light">
                    <strong>Discount ({{ number_format($po_master_info->discount_percent , 2, '.', '') }}%):</strong>{{ number_format($po_master_info->discount_amount, 2, '.', '') }}
                </td>
            </tr>
            <tr>
                @php
                $total = $total + $po_master_info->vat_amount -$po_master_info->discount_amount;
                @endphp
                <td class="border-0" colspan="11"></td>
                <td class="border-0 text-right bg-light"><strong>Payable:</strong>
                {{ number_format($total, 2, '.', '') }} </td>

            </tr>
        </tfoot>
    </table>
    @php
    $number = number_format($total, 2, '.', '') ;
    $locale = 'en_US';
    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
    $in_words = numfmt_format($fmt, $number);
    @endphp
<strong>In Words:{{ ucfirst($in_words) }} Taka only </strong>

@if (!empty($terms))
    <h5>Terms & Conditions</h5>
    <table style="margin-top: 25px;">
        <thead>
            <tr>
                <?php $total = 0; ?>
                <th class="text-center">#SL</th>
                <th class="text-left">Terms & Condition</th>
            </tr>
        </thead>
        <tbody>


            @foreach ($terms as $value)
            <tr>
                <td class="text-center bg-light">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $value->description }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endif




</main>



</body>

</html>
