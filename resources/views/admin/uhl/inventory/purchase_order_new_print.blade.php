@php
    $sign_css = File::exists(public_path('images/uploads/doctor_images/director_sign.png')) ? '5.5cm' : '5.5cm';
    // when add digital sign= 7.3cm
@endphp
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
            margin-top: .6cm;
            margin-bottom: 0.8cm;
            margin-left: 0.8cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            /* margin-top: 2.5cm; */
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #000000;
        }


        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 4cm;
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
            /* height: 2.5cm; */
            font-size: 9px;
            /*top: -10px;
            border-top: 1px solid black;*/
            padding-top: 10px;
            z-index: 999999999;
        }

        .singature {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: <?=$sign_css ?>;
            /* 5.5; */
            text-align: center;
            font-size: 9px;
            bottom: -70px;
            padding-top: 10px;
        }





        .logo {
            width: 80px;
            display: inline-block;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .hospital-names {
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
        }

        .hospital-logo-info .hospital_info .hospital-address {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact {
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
            margin-left: 30px;
        }

        .hospital_info {
            margin-left: 10px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .title {
            /*background-color: #444;*/
            /*display: inline-block;*/
            font-size: 14px;
            color: #000;
            padding: 5px 50px;
            border-radius: 3px;
            /*font-weight: bold;*/
        }

        .form-heading .title-name {
            font-size: 1.35rem;
            line-height: 1;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .form-heading h5 {
            font-size: 1rem;
            /*line-height: 1;*/
            margin-top: -10px;
            font-weight: 400;
        }

        .form-heading h1 {
            margin-top: -20px;
            margin-left: 150px;
        }

        .form-heading p {
            font-size: .8rem;
            margin-top: -20px;
            margin-left: 245px;
        }

        .form-heading b {
            font-size: .7rem;
            margin-top: -20px;
            margin-left: 300px;
        }
    </style>
</head>
@php
    // dd($po_hospital_details );
    $imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
    // dd(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo));
@endphp

<body>
    {{-- @if (!empty($po_hospital_details) && $po_hospital_details->report_header_image_prshde_ind == 1)
    <header>
        <table style="width: 100%; border-collapse:collapse;" class="signature">
            <tr style="">
                <td style="width: 20%;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="120" alt="" />
                </td>
                <td style="text-align:left;">
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
    @else --}}
    <div class="form-heading border-bottom pb-3 justify-content-between" style="">
        <div id="logo" style="display:inline-block !important; ">
            @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
            @endif
        </div>
        <div class="hospital-address" style="display:inline-block !important; ">
            <h1 class="mb-0 ">
                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
            </h1>
            <br>
            <p class="mb-0 ">
                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
            </p>
            <br>
            <b class="mb-0 ">
                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
            </b>
            <br>
        </div>
    </div>
    <div style="height: 1cm;">

    </div>
    {{-- @endif --}}
    <footer style="border-top: 1px solid transparent;">
        <div class="">
            <table style="width: 100%; border:none ">
                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                    @if (Session::get('user.ses_hospital_code') == 'JKMH')
                        <tr style=" ">
                            <td style="text-align:left; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">GM, Admin & Procurement</span><br> --}}

                                <span style="padding:5px;">Prepared By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->passed_by_name : '' }}
                                </span><br>
                                {{-- <span style="padding:5px;">Director, Admin</span><br> --}}

                                <span style="padding:5px;">Manager (Accounts)</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                                <span style="padding:5px;">DGM</span>
                            </td>
                            <td style="border:none"></td>
                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                                <span style="padding:5px;">DMD</span>
                            </td>
                        </tr>
                    @else
                        <tr style=" ">
                            <td style="text-align:left; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">Head of Pharmacy </span><br> --}}

                                <span style="padding:5px;">Prepared By</span>

                            </td>
                            <td style="border:none"></td>
                            <td style="text-align:center; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">GM, Admin & Procurement</span><br> --}}

                                <span style="padding:5px;"> Reviewed By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->passed_by_name : '' }}
                                </span><br>
                                <span style="padding:5px;">Director, Admin</span><br>

                                <span style="padding:5px;">Checked By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:right; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                <span style="padding:5px;">Director, Finance</span><br>
                                <span style="padding:5px;">Approved By</span>
                            </td>
                        </tr>
                    @endif
                @endif
            </table>

        </div>
        @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
            <table style="border:0px; border-top:1px solid #222;">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                        {{ $userInfo->user_fullname }} &nbsp;&nbsp; Printing Date & Time: {{ date('d/m/Y') }}
                    </td>
                    <!-- <td style="padding-right:50px">
                    <p class="page" style="padding-right:50px">Page </p>
                </td> -->
                    <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
                </tr>
            </table>
        @endif
        <!-- <p class="page" style=""> <span id="pageCounter"></span> </p> -->
    </footer>


    <main>
        <div id="details" class="clearfix" style=" margin-bottom:1px; margin-top:1px">
            <p
                style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; font-size:15px">
                <strong>{{ $po_master_info->poheader == '0' ? 'Work Order' : 'Purchase Order' }}</strong>
            </p>
            <div class="" style="margin-top: 25px !important; margin-bottom: 5px;">

                <table>
                    <tr>
                        <td style="text-align: left;">
                            <strong>Ref:</strong> {{ $po_master_info->reference_no }}<br><br>
                            <strong>To:</strong> {{ $po_master_info->supplier_name }}<br>
                            <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                            <strong>Contact Person:</strong> {{ $po_master_info->refer_contact_name }}<br>
                            <strong> Mobile:</strong> {{ $po_master_info->refer_contact_mobile }}<br>
                            <strong> Email:</strong> {{ $po_master_info->refer_contact_email }}<br>

                            <!-- <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                        <strong>Email:</strong> {{ $po_master_info->e_mail }}<br> -->
                            <!-- <strong>Delivery Date:</strong> {{ $po_master_info->delivery_date != '' ? date('d/m/Y', strtotime($po_master_info->delivery_date)) : '' }}<br>
                            <strong>Status:</strong>
                            @if ($po_master_info->po_save_option == 'DRAFT')
DRAFT
                            @elseif($po_master_info->po_save_option == 'POST')
                            POSTED
                            @elseif($po_master_info->po_save_option == 'ISSUE')
                            ISSUED
                            @endif
                            <br> -->

                            {{-- <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                            <strong>Email:</strong> {{ $po_master_info->e_mail }}<br> --}}
                        </td>
                        <td>
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                            <br>
                            <strong>PO ID:</strong> {{ $po_master_info->purchase_uid }}<br>
                            <strong>PO NO:</strong> {{ $po_master_info->purchaseorder_no_pk }}<br>
                            <!-- $purchase_order_id -->
                            <strong>Date of PO:</strong>
                            {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                            @if($po_master_info->quotation_ref !="")
                            <strong>Quotation Ref :</strong>
                            {{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}<br>
                            @endif
                        </td>
                    </tr>
                    @if($po_master_info->reference_sub !="")
                    <tr>
                        <td colspan="2" style="text-align: left; padding-top:5px">
                            <strong> Subject : </strong> {{ $po_master_info->reference_sub }}<br>
                        </td>
                    </tr>
                    @endif
                </table>



                <!-- <div style="float: left; width: 50%">
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
                </div> -->
            </div>
        </div>
        <div id="details" class="clearfix" style=" margin-bottom:1px">

            <!-- <table>
                <tr>
                    <td style="text-align: left;">
                        <strong>To:</strong> {{ $po_master_info->supplier_name }}<br>
                        <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                        <strong>Mobile:</strong> {{ $po_master_info->phone }}<br>
                        <strong>Email:</strong> {{ $po_master_info->e_mail }}<br>
                    </td>
                </tr>
            </table> -->

            <!-- <div class="" style=" margin-top: 10px !important; margin-bottom: 10px;">
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
            </div> -->
        </div>
        <div id="details" class="clearfix" style=" margin-bottom:1px">


        </div>
        </div>

        @if($po_master_info->reference_sub_body !="")
        <table style="margin-top: 0px; width:100%">
            <tr>
                <td style="text-align: left;"> {!! isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : '' !!}
                </td>
            </tr>
        </table>
        @endif

        <table class="" border="1" style="margin-top: 0px; width:100%">
            <thead>
                <tr>
                    <th class="text-center">Sl.</th>
                    <!-- <th class="text-left">Item Code</th> -->
                    <th class="text-left">Item Name</th>
                    <th class="text-left">Item Specification</th>
                    <th class="text-center"> UoM</th>
                    <th class="text-center">Quantity</th>
                    <!-- <th class="text-center">Total Quantity</th> -->
                    <th class="text-right">Unit Price (TK)</th>
                    <th class="text-right">Total Amount (TK)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dollar_ind = '';
                    $dollar_rate = 0;
                    $total_dollar_rate = 0;
                @endphp
                <?php $total = 0; ?>
                @if (isset($po_child_details_info))

                    @foreach ($po_child_details_info as $value)
                        @php
                            $dollar_ind = $value->dollar_rate;
                            $dollar_rate = $value->dollar_rate != '' ? $value->item_rate / $value->dollar_rate : $value->item_rate;
                            $total_dollar_rate = $value->dollar_rate != '' ? ($value->item_rate / $value->dollar_rate) * $value->entry_qty : $value->entry_qty * $value->item_rate;
                        @endphp
                        <tr>
                            <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                            <!-- <td class="text-left">{{ $value->item_code }}</td> -->
                            <td class="text-left">{{ $value->item_name }}</td>
                            <td class="text-left">{{ $value->refer_item_specification }}</td>
                            <td class="text-center">
                                {{ $value->uom_code }}
                            </td>
                            <td class="text-center">{{ $value->entry_qty }} {{ $value->pr_uom_name }} </td>
                            <!-- <td class="text-center">{{ $value->entry_qty * $value->pr_uom_conversion_qty }}
                        {{ $value->uom_name }}
                    </td> -->
                            <td class="text-right">
                                @if ($value->currency_sign == 'USD')
                                    {{-- $ --}}
                                @elseif($value->currency_sign == 'EUR')
                                    {{-- € --}}
                                @else
                                    {{-- Tk. --}}
                                @endif{{ number_format($dollar_rate, 2) }}
                            </td>
                            <td class="text-right">
                                @if ($value->currency_sign == 'USD')
                                    {{-- $ --}}
                                @elseif($value->currency_sign == 'EUR')
                                    {{-- € --}}
                                @else
                                    {{-- Tk. --}}
                                @endif {{ number_format($total_dollar_rate, 2) }}
                            </td>
                        </tr>
                        @php
                            $total += $value->dollar_rate != '' ? $value->entry_qty * ($value->item_rate / $value->dollar_rate) : $value->entry_qty * $value->item_rate;

                        @endphp
                    @endforeach
                @endif
            </tbody>

            @php

                $dollar_exp = [];
                if (!empty($dollar_rate_currency) && $dollar_rate_currency != '_') {
                    $dollar_exp = explode('_', $dollar_rate_currency);
                }

            @endphp
            <tfoot>
                <tr>
                    <td class="border-0" colspan="5"></td>
                    <td class="border-0 text-right bg-light">
                        <strong>Total:</strong>
                    </td>
                    <td class="border-0 text-right bg-light">
                        <strong>
                            @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                {{-- $ --}}
                            @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                {{-- € --}}
                            @else
                                {{-- Tk. --}}
                            @endif{{ number_format($total, 2) }}
                    </td>
                </tr>
                @if ($po_master_info->vat_amount > 0)
                    <tr>
                        <td class="border-0" colspan="5"></td>

                        <td class="border-0 text-right bg-light">
                            <strong>Duty/Vat :
                                {{ $po_master_info->vat_percent > 0 ? '(' . number_format($po_master_info->vat_percent, 2) . ')' . '% :' : '' }}</strong>

                        </td>

                        <td class="border-0 text-right bg-light">
                            <strong>
                                @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                    {{-- $ --}}
                                @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                    {{-- € --}}
                                @else
                                    {{-- Tk. --}}
                                @endif
                                {{ !empty($dollar_exp) ? number_format($po_master_info->vat_amount / $dollar_exp[0], 2) : number_format($po_master_info->vat_amount, 2) }}
                        </td>
                    </tr>
                @endif
                @if ($po_master_info->discount_amount > 0)
                    <tr>
                        <td class="border-0" colspan="5"></td>
                        <td class="border-0 text-right bg-light">
                            <strong>Discount
                                ({{ number_format($po_master_info->discount_percent, 2) }}%):</strong>

                        </td>
                        <td class="border-0 text-right bg-light">
                            <strong>
                                @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                    {{-- $ --}}
                                @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                    {{-- € --}}
                                @else
                                    {{-- Tk. --}}
                                @endif
                                {{ !empty($dollar_exp) ? number_format($po_master_info->discount_amount / $dollar_exp[0], 2) : number_format($po_master_info->discount_amount, 2) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    @php

                        if (!empty($dollar_exp)) {
                            $total = $total + $po_master_info->vat_amount / $dollar_exp[0] - $po_master_info->discount_amount / $dollar_exp[0];
                        } else {
                            $total = $total + $po_master_info->vat_amount - $po_master_info->discount_amount;
                        }
                    @endphp
                    <td class="border-0" colspan="5"></td>
                    <td class="border-0 text-right bg-light"><strong>Payable:</strong>

                    </td>
                    <td class="border-0 text-right bg-light"> <strong>
                            @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                {{-- $ --}}
                            @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                {{-- € --}}
                            @else
                                {{-- Tk. --}}
                            @endif {{ number_format($total, 2) }}
                        </strong>
                    </td>

                </tr>
                <!-- @if (isset($dollar_euro) && !empty($dollar_euro))
<tr>
                    <td class="border-0" colspan="6"></td>
                    <td class="border-0 text-right bg-light"><strong>{{ $dollar_euro == 1 ? 'USD (105.34)' : 'Euro (114.69)' }} </strong>
                        {{ $dollar_euro == 1 ? number_format($total / 105.34, 2, '.', '') : number_format($total / 114.69, 2, '.', '') }}
                    </td>
                </tr>
@endif -->
            </tfoot>
        </table>

        @php
            $number = number_format($total, 2, '.', '');
            $locale = 'en_US';
            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
            $in_words = numfmt_format($fmt, $number);
        @endphp
        <span><strong>In words: {{ ucfirst($in_words) }} @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                    dollar only
                @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                    Euro only
                @else
                    Taka only
                @endif. </strong></span>
        <table style=" margin-bottom:50px">
            <tr>
                <td style="text-align: left;">
                    @if (!empty($terms))

                        {{-- <h4 style="text-decoration: underline;">Terms & Conditions:</h4> --}}
                        <h4 style="text-align:left; width:20%; border-bottom: black solid 1px;">Terms & Conditions:
                        </h4>
                        <table style="">
                            @foreach ($terms as $header => $terms_condition)
                                <tr>
                                    <th class="text-left" colspan="2">{{ $header }}</th>
                                </tr>
                                @foreach ($terms_condition as $value)
                                    <tr>
                                        <!-- <td class="text-left bg-light " style="width: 5px;">
                                            {{ sprintf('%02d', $loop->iteration) }}
                                        </td> -->
                                        <td class="text-left">{{ $value->description }}</td>
                                    </tr>
                                @endforeach
                            @endforeach

                        </table>

                    @endif

                    {{-- <span style="font-weight: bold;">Please sign and return the copy of this letter as acceptance of
                        the above order.</span> <br>
                    <span style="font-weight: bold;">For {{ Session::get('user.hospital_name') }}</span> --}}
                </td>
            </tr>
        </table>


        <!-- <div class="singature">
            @if (in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
@if (strpos($po_master_info->approval_status_text, 'REJECTED') >= 1 ||
        strpos($po_master_info->approval_status_text, 'HOLD') >= 1)
@else
@php
    $approval_exp = explode('/', $po_master_info->approval_level_status_text);
@endphp
            @if ($approval_exp[0] != '' && $approval_exp[0] == $approval_exp[1])
<table style="width: 100%; border:none ">
                <tr>
                </tr>
            </table>
@elseif($approval_exp[0] != '' && $approval_exp[0] == 1)
<table style="width: 100%; border:none ">
                <tr>
                </tr>
            </table>
@endif
@endif
@endif
            <table style="width: 100%; border:none ;">
                <tr style=" ">
                    <td style="text-align:left; border:none " colspan="2">

                        @if (in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
@if (strpos($po_master_info->approval_status_text, 'REJECTED') >= 1 ||
        strpos($po_master_info->approval_status_text, 'HOLD') >= 1)
@else
@php
    $approval_exp = explode('/', $po_master_info->approval_level_status_text);
@endphp
                        @if ($approval_exp[0] != '' && $approval_exp[0] == $approval_exp[1])
<span style="padding:5px; border-top: black solid 1px;"> <strong>
                                <div style="padding-bottom:5px; width: 150px; font-size: 16px;">Ardra
                                    Kurien<br><span style="font-size: 13px;">Chief Executive Officer
                                    </span></div>
                            </strong> </span>
@elseif($approval_exp[0] != '' && $approval_exp[0] == 1)
<span style="padding:5px; border-top: black solid 1px;"> <strong>
                                <div style="padding-bottom:5px; width: 150px; font-size: 16px;">Ardra
                                    Kurien <br><span style="font-size: 13px;">Chief Executive Officer
                                    </span></div>
                            </strong> </span>
@endif
@endif
@else
@endif

                    </td>
                </tr>
            </table>

        </div> -->

        {{-- <div class="singature">
            <table style="width: 100%; border:none ; font-size:14px">
                <tr style="">
                    @if (!empty($signature_data))
                        @foreach ($signature_data as $key => $value)
                            @php
                                $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                            @endphp
                            @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:left; border:none " colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px'
                                                style="padding: 0px  !important; margin:0px !important"> </div>
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ $value->designation }}</strong>

                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:right; border:none; text-align:center;">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px'
                                                style="padding: 0px  !important; margin:0px !important"> </div>
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ $value->designation }}</strong>
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px'
                                                style="padding: 0px  !important; margin:0px !important"> </div>
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ $value->designation }}</strong>
                                </td>
                            @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if ($value->doctor_signature_image != '')
                                        <div style="padding:5px"> <img
                                                src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                                width='60px'
                                                style="padding: 0px  !important; margin:0px !important"> </div>
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                            {{ $value->user_fullname }} </strong></span> <br> <strong>
                                        {{ $value->designation }}</strong>
                                </td>
                            @endif
                        @endforeach
                    @endif
                </tr>
            </table>
        </div> --}}
    </main>


</body>

</html>
