@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
// dd( $hospital);
$body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 12;
$footer_height= $po_hospital_details->hospital_code == 'DMHL' ? 1.3 : 0.8;
$body_font_size = $po_hospital_details->hospital_code == 'JKMH' || $po_hospital_details->hospital_code == 'IMPERIAL' || $po_hospital_details->hospital_code == 'AMCSH' ? 10 :  $body_font_size;
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Bill Cancel Print</title>
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
            margin-top: 8cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?=$body_font_size ?>px !important;
            /* padding-left: .5cm;
            padding-right: .5cm; */
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height:<?= $footer_height ?>cm !important;
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

        table tr th {
            border: 0px;
            background-color: white;
            color: #222;
        }

        table tr td {
            border: 0px;
        }

        table {
            border: 0px;
        }
        .font-11 {
        font-size: 11px !important;
        line-height: 1;
    }

    .black {
        color: black !important;
    }

    .main_container {
        position: relative;
        display: inline-block;
        margin: 0px;
        padding: 0px;
    }

    .overlay-text {
        font-size: 30px !important;
        color: #d2d3d4;
        background-color: transparent;
        position: relative;
        z-index: 1;
    }

    .text-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(61, 60, 60);
        font-size: 13px;
        z-index: 2;
        pointer-events: none;
    }
        .page-break {
            page-break-after: always;
        }
        .pat_info{
            margin-top: 100px !important;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
        }
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$length = isset($po_hospital_details->due_cancel_fee_invoice_print) && $po_hospital_details->due_cancel_fee_invoice_print != '' ? $po_hospital_details->due_cancel_fee_invoice_print : 1;
@endphp
@for ($i = 0; $i < $length; $i++)

    <body>
     
        <header>
            <table style="width: 100%; border:5px solid transparent !important" class="signature">
                @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                    @if ($po_hospital_details->hospital_code != 'KBMH')
                        <tr style="">
                            <td style="width: 15%; border-right:1px solid transparent!important">
                            @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
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
                    @else
                    @endif
                @else
                    @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                        <tr>
                            <td style="text-align: center;width: 100%;" >
                                @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="250px" alt="" style="width: 90%;height:100%">
                                @endif
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: center">
                                @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="250px" alt="">
                                @endif
                            </td>
                        </tr>
                    @endif
                @endif

            </table>
            <div class="pat_info patient-information d-flex align-items-center">
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%"> <img style=""
                                src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                            <br>
                            {{ $invoice_mst_info->patient_code }}
                        </td>
                        <td style="text-align: center;vertical-align:top;"> Bill Cancel Invoice </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                style="width: 120px; " /> <br>
                            {{ $invoice_mst_info->invoice_code }}
                        </td>
                    </tr>
                </table>
                <table style="">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <div class="text-left" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><i style="color: blue;"><b>
                                                    @if ($i == 0)
                                                        Customer Copy
                                                    @elseif($i == 1)
                                                        Office Copy
                                                    @endif
                                                </b></i></li>
                                        <li style="margin-top: 4px;"><b> @if(session::get('user.ses_hospital_code')=="KPJ") MRN @else UHID @endif :</b>&nbsp;<span>
                                                {{ $invoice_mst_info->patient_code }}</span></li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                            <li style="margin-top: 4px;"><b> Admission ID :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->admission_no_pk }}</span></li>
                                        @endif

                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                        </li>

                                        <li style="margin-top: 4px;">
                                            @php
                                                $pat_dob = new \DateTime($invoice_mst_info->dob);
                                                $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                                $interval = $invoice_date->diff($pat_dob);
                                            @endphp
                                            <b>Age:</b>&nbsp;<span>{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</span>
                                            <b>Sex :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                            
                                        </li>
                                        <li>
                                            <b>Contact: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>

                                        {{-- @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                            <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                    {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                            </li>
                                        @endif --}}

                                        @if ($invoice_mst_info->doctor_name != '')
                                            <li style="margin-top: 4px;">
                                                @if ($po_hospital_details->hospital_code == 'GMC')
                                                    <b>Doctor: </b>&nbsp;<span>
                                                    @else
                                                        <b>Ref. Doctor: </b>&nbsp;<span>
                                                @endif
                                                {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                            </li>
                                        @endif

                                        @if ($invoice_mst_info->first_doc_name != ' ')
                                            @if (in_array($po_hospital_details->hospital_code ,[ 'GMC','IMPERIAL']))
                                                <b>Ref:
                                                </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->person_code != '' ? ucwords($invoice_mst_info->person_code) : '' }}</span>
                                            @else
                                                <b>1st Ref:
                                                </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                            @endif
                                        @endif

                                        @if ($invoice_mst_info->second_doc_name != ' ')
                                            <li style="margin-top: 4px;">
                                                @if (in_array($po_hospital_details->hospital_code ,[ 'IMPERIAL']))
                                                <b>2nd Ref:
                                                </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->second_doc_person_code != '' ? ucwords($invoice_mst_info->second_doc_person_code) : '' }}</span>
                                                @else
                                                <b>2nd Ref:
                                                </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                                @endif
                                            </li>
                                        @endif



                                    </ul>
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: text-top;">
                                <div class="text-right" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li style="color: red"><strong> <i> Duplicate </i></strong> </li>
                                        {{-- <li><b>Printed By: </b>{{ Session::get('user.ses_user_name') }}
                                        </li> --}}
                                       
                                        <li><b>Date of
                                                Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                        </li>
                                        <li><b>Invoice ID
                                            :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span> </li>
                                        <li><b>TRX ID
                                                :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                        </li>                                           
                                        
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </header>
@php
$footerHide=session::get('user.ses_hospital_code')=="KPJ" ? 'display:none' :'';
@endphp

        <footer style="border-top: 1px solid transparent;<?= $footerHide ?>">
            <table style="border:0px; border-top:1px solid #222; font-size:9px !important">
                <?php

                date_default_timezone_set('Asia/Dhaka');
                $date = date(' h:i a'); // $dt->format('g:i A');
                ?>
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;padding-left:20px;">
                        Print: {{ Session::get('user.user_code') }} /  <span> {{ date('d-m-Y') }} / {{ $date }}</span>
                     
                    </td>
                    <td style="border: 0px; padding-top: 5px;padding-right:10px;">Powered By: NEXTGEN IT</td>
                </tr>
            </table>
        </footer>


        <main>
            <table class="" style=""  width="100%" >
                <thead>
                    <tr>
                        <th class="text-left" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">SL#</th>
                        <th class="text-left"  style="border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Item Description</th>
                    
                        {{-- <th class="text-left" style="width: 40px"></th> --}}
                        {{-- <th class="text-right" style="width: 50px">Rate</th> --}}
                        
                        <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Rate </th>
                        <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Qty</th>
                        {{-- <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Cx. Qty</th> --}}
                        <th class="text-right" style="width: 40px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Dis.</th>
                        <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Amount </th>
                    </tr>
                </thead>
                <tbody style="border-top: 1px solid #222!important; ">
                    @php
                        $total = 0;
                        $total_item_rate = 0;
                        $cancel_dic = 0;
                        $service_charges = 0;
                    @endphp
                    @if (!empty($invoice_dtls_info))
                        @foreach ($invoice_dtls_info as $row)
                            @php
                                $urgent_fee = 0;
                                $item_rate = 0;
                                $cancel_fee = 0;
                                $text_dec = $row->item_qty == $row->cancel_qty ? 'text-decoration: line-through; line-height:1' : '';
                            @endphp

                            <tr>
                                <td class="text-center  font-11 black" style="padding: 3px !important;">
                                    {{ sprintf('%02d', $loop->iteration) }}</td>
                                <td class="text-left font-11 black" style="padding: 3px !important; "><span style="<?= $text_dec ?>">
                                        {{ $row->item_name }} </span></td>
                                {{-- <td class="text-left" style="padding: 3px !important;">
                                    {{ $row->report_delivery_date == '' ? ' ' : date('d/m/Y', strtotime($row->report_delivery_date)) }}

                                </td> --}}


                                @if ($row->delivery_status_lookup_no_fk == 1)
                                    {{-- <td class=" text-left" style="padding: 3px !important;">

                                    </td> --}}
                                    @php
                                        $item_rate = $row->item_rate_orig;
                                    @endphp
                                @elseif($row->delivery_status_lookup_no_fk == 2)
                                    {{-- <td class=" text-left" style="padding: 3px !important;width: 40px"> Urgent </td> --}}
                                    @php
                                        $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                        $item_rate = $row->item_rate_orig + $urgent_fee;
                                    @endphp
                                @else
                                    {{-- <td></td> --}}
                                    @php
                                        $item_rate = $row->item_rate_orig;
                                    @endphp
                                @endif
                                <td class=" text-center font-11 black" style="padding: 3px !important; text-align:right !important">{{ $item_rate }}</td>
                                <td class=" text-center font-11 black" style="padding: 3px !important;">{{ $row->item_qty }}</td>
                                {{-- <td class=" text-center font-11 black" style="padding: 3px !important;">{{ $row->cancel_qty }}</td> --}}
                                <td class=" text-right font-11 black" style="padding: 3px !important;">
                                    {{ number_format($row->disc_amount, 2, '.', '') }}</td>
                                <td class="text-right font-11 black bg-light" style="padding: 3px !important;">
                                    <span style="<?= $text_dec ?>">
                                        {{ number_format(($row->item_qty * $item_rate)-$row->disc_amount, 2, '.', '') }} </span>
                                </td>
                            </tr>
                            @php
                                $total += $row->cancel_qty * $item_rate + $row->cancel_qty * $row->item_vat;
                                $total_item_rate += $row->item_qty * ($item_rate + $row->item_vat);

                                $cancel_dic += ($row->cancel_qty * $item_rate * $row->disc_perc) / 100;
                                $cancel_fee += $row->cancel_qty * $row->urgent_fee;
                                if ($row->cancel_ind != 1) {
                                    $service_charges += $row->service_charge;
                                }
                            @endphp
                        @endforeach
                    @endif
                    @php
                        $service_charge = number_format($service_charges, 2, '.', '');
                        $sales_cancel = !empty($finc_inv_sum_amount->sales_cancel) ? $finc_inv_sum_amount->sales_cancel : 0;
                        $calcel_discount = !empty($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;
                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                        $payment = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                        $payable = number_format($total - $discount, 2, '.', '');
                        $due = number_format($payable - $payment, 2, '.', '');
                        $number = $total - $discount;
                        // $locale = 'en_US';
                        // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $total = $finc_inv_sum_amount->sales - $service_charges;
                        $total_amt = $finc_inv_sum_amount->sales;
                        $net_payable = number_format($total_amt - $discount - $sales_cancel, 2, '.', '');

                        $paid_amount = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                        $due_refund = number_format($net_payable - $paid_amount, 2, '.', '');
                        // if ($due_refund <= 0) {
                        //     $in_words = numfmt_format($fmt, abs($net_payable));
                        // } else {
                        //     $in_words = numfmt_format($fmt, $net_payable);
                        // }
                        $locale = 'en_US';
                        $fmt = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                        $wholeNumberPart = floor(abs($net_payable));
                        $inWordsWhole = $fmt->format($wholeNumberPart);
                        $decimalPart = (abs($net_payable) - $wholeNumberPart) * 100; 
                        $decimalPart = round($decimalPart);
                        $taka = 'Taka';
                        $paysha = 'Paysha';
                        $in_words = $inWordsWhole . ' ' . $taka . ' ' . ($decimalPart > 0 ? $fmt->format($decimalPart) . ' ' . $paysha : '');

                        $to_date = date('Y-m-d');
                    @endphp
                </tbody>
            </table>
            <table width="100%" style=" border-top:1px solid black">
                <tr>
                    <td style="text-align: left">
                        <b>Total Item Amt :</b> {{ number_format($total, 2, '.', '') }}, <b>Total Cancel Amt :</b> {{ number_format($sales_cancel, 2, '.', '') }}, <b>(-) Discount :</b> {{ number_format($calcel_discount, 2, '.', '') }},<b>Net Cancel Amt :</b> {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }} ,<b>Discounted Amt :</b> {{ number_format($discount, 2, '.', '') }}, <b>Net Payable :</b> {{ $net_payable }} , <b>Paid Amt :</b> {{ number_format($paid_amount, 2, '.', '') }},  
                        @if ($due_refund < 0)
                            <b>Cash Refund :</b>
                            <br> <b>Total Refund :</b>
                        @elseif($due_refund >= 0)
                            <b> Due :</b>
                        @endif
                        @if ($due_refund < 0)
                            {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }} <br>
                            {{ number_format(abs($due_refund), 2, '.', '') }}
                        @elseif($due_refund >= 0)
                            {{ number_format(abs($due_refund), 2, '.', '') }}
                        @endif
                        <br>
                        <span> <b>In Word :</b> {{ ucwords($in_words) }} Only </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px !important; text-align:left">
                        <div style="margin-bottom: 5px">
                          
                            <div class="text-overlay">                           
                                @if(!empty($return_reson))
                                <div> Return Reason :{{$return_reson->refund_reason}}  </div> <br>
                                @endif
                                @if($invoice_mst_info->invoice_remarks !='')
                                <div style="padding-top: 15px">Remarks : {{$invoice_mst_info->invoice_remarks}} </div><br>
                                @endif
                              
                                    
                            </div>
                            <span class="overlay-text">
                                @if ($due_refund < 0)
                                    <strong>Refund</strong>
                                @elseif($due_refund == 0)
                                    <strong>Paid</strong>
                                @else
                                    <strong>DUE</strong>
                                @endif

                            </span>
                        </div> 
                        {{-- <br>
                        <b>In Word :</b> {{ucwords($in_words) }}  Only --}}


                    </td>

                    {{-- <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Item Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($total, 2, '.', '') }}</td> --}}
                </tr>

                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Cancel Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($sales_cancel, 2, '.', '') }}
                    </td>
                </tr> --}}
                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>(-) Discount :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($calcel_discount, 2, '.', '') }}
                    </td>
                </tr> --}}

                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Cancel Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>
                </tr> --}}

                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Discounted Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($discount, 2, '.', '') }}</td>
                </tr> --}}

                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Payable :</b></td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ $net_payable }}
                    </td>
                </tr> --}}

                {{-- <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Paid Amt :</b></td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($paid_amount, 2, '.', '') }}</td>
                </tr> --}}

                {{-- <tr>
                    <td class="text-right" colspan="7" style="padding: 2px !important;">
                        @if ($due_refund < 0)
                            <b>Cash Refund :</b>
                            <br> <b>Total Refund :</b>
                        @elseif($due_refund >= 0)
                            <b> Due :</b>
                        @endif
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        @if ($due_refund < 0)
                            {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }} <br>
                            {{ number_format(abs($due_refund), 2, '.', '') }}
                        @elseif($due_refund >= 0)
                            {{ number_format(abs($due_refund), 2, '.', '') }}
                        @endif
                    </td>
                </tr> --}}
            </table>
        </main>
    </body>
    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor

</html>
