@php
$hospital = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
// dd( $hospital);
$body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 11;
$footer_height= $po_hospital_details->hospital_code == 'DMHL' ? 1.3 : 1.5;
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Payment Print </title>
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
            margin-top: 5.7cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?= $body_font_size ?>px !important;
            /* padding-left: .5cm;
            padding-right: .5cm;
            color: black; */
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height:<?= $footer_height ?>cm !important;
            text-align: center;
            font-size: 7px;
            bottom: 0px;
            border-top:none;
         
            padding-top: 10px;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            height: 1.8cm;
            /* height: 2.5cm; */
            font-size: 9px;
            /*top: -10px;*/
            /* border-top: 1px solid black; */
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
        .font-11{
            font-size: 11px !important;
            line-height: 1;
        }
        .black{
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
            margin-top: 70px !important;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
        }
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$length = isset($po_hospital_details->due_cancel_fee_invoice_print) && $po_hospital_details->due_cancel_fee_invoice_print != '' ? $po_hospital_details->due_cancel_fee_invoice_print : 1;
$marginBottomHeader=$po_hospital_details->report_header_image_prshde_ind != 1 && $po_hospital_details->report_header_image !="" ? 'margin-bottom:-50px;' :'';
@endphp
@for ($i = 0; $i < $length; $i++) 
<body>

    <header>
        <table style=" border:5px solid transparent !important; <?= $marginBottomHeader ?>" class="">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                @if ($po_hospital_details->hospital_code != 'KBMH')
                <tr style="">
                    <td style="width: 15%; border-right:1px solid transparent!important">
                        @if ($po_hospital_details->hospital_code == 'IMPALA')
                        @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/' . $po_hospital_details->logo)))
                        <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}" width="60" alt="">
                        @endif
                        @else
                        @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                        <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                        @endif
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
                    <td style="text-align: center;width: 100%;">
                        @if ($po_hospital_details->report_header_image != '')
                        <img class="hospital-logo" src="{{ public_path('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" width="250px" alt="" style="width: 90%;height:100%">
                        @endif
                    </td>
                </tr>
                @else
                <tr>
                    <td style="text-align: center; ">
                        @if ($po_hospital_details->report_header_image != '')
                        <img class="hospital-logo" src="{{ public_path('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" alt="" style="width: 90%;height:50px">
                        @endif
                    </td>
                </tr>
                @endif
            @endif

        </table>
        <div class="pat_info" style="">
            <div class="patient-information d-flex align-items-center">
                {{-- <div class=" text-center " style="padding: 3px !important; font-size: 15px"> --}}
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%"> <img style="" src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                            <br>
                            {{ $invoice_mst_info->patient_code }}
                        </td>
                        <td style="text-align: center;vertical-align:top !important;">
                            @if ($po_hospital_details->hospital_code == 'GMC')
                            <div>Investigation</div>
                            <div>Payment</div>
                            @else
                            Invoice Cum Receipt
                            @endif
                        </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " /> <br>
                            {{ $invoice_mst_info->invoice_code }}
                        </td>
                    </tr>
                </table>
                {{-- </div> --}}
                <table width="100%" style="padding: 0px; margin:0px">
                    <tbody>
                        <tr >
                            <td class="text-left">
                                <div class="text-left" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><i style="color: blue;"><b>
                                                    @if ($i == 0)
                                                    Customer Copy
                                                    @elseif($i == 1)
                                                    Office Copy
                                                    @elseif($i == 2)
                                                    Lab Copy
                                                    @endif
                                                </b></i></li>
                                        <li style="margin-top: 4px;"><b> @if(session::get('user.ses_hospital_code')=="KPJ") MRN @else UHID @endif</b>&nbsp;<span>
                                                {{ $invoice_mst_info->patient_code }}</span></li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                        <li style="margin-top: 4px;"><b> IP No:</b>&nbsp;<span>
                                                {{ $invoice_mst_info->admission_no_pk }}
                                                (<strong>Bed/Cabin</strong>: {{ $bed_details }})</span></li>
                                        @endif

                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span> </li>
                                        
                                        <li style="margin-top: 3px;"><b>Pt. Cat. :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_type_code) }} </span>
                                        </li>
                                        @if ($invoice_mst_info->ccm_client_name !='')
                                            <li style="margin-top: 3px;"><b>Corp.  :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->ccm_client_name) }} </span>
                                            </li>
                                        @endif

                                        <li style="margin-top: 4px;">
                                            @php
                                            $pat_dob = new \DateTime($invoice_mst_info->dob);
                                            $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                            $interval = $invoice_date->diff($pat_dob);

                                            @endphp
                                            <b>Age:</b>&nbsp;<span>{{ $interval->format('%yY %mM %dD') }}</span>
                                            <b>Sex :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>
                                           
                                        </li>
                                        <li>
                                            <b>Contact: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>

                                       
                                    </ul>
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: text-top;">
                                <div class="text-right" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li style="color: red"><strong> <i> Duplicate </i></strong> </li>                                     
                                       
                                      
                                        <li><b>Date of Invoice
                                                :</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($invoice_mst_info->invoice_date)) }}</span>
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
        </div>
    </header>
@php
$footerHide=session::get('user.ses_hospital_code')=="KPJ" ? 'display:none' :'';
@endphp
    <footer style="<?= $footerHide ?>">


        <table style="border:0px; font-size:9px !important;">
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $date = date('h:i a'); 
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; padding-left:15px">
                    Print: {{ Session::get('user.user_code') }} /  <span> {{ date('d-m-Y') }} / {{ $date }}</span>
            
                </td>
                <td style="border: 0px; padding-top: 5px; padding-right:10px">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
    @php 
        $ulMarginTop=$invoice_mst_info->admission_no_pk != '' ? 'margin-top: 55px !important':'margin-top: 35px !important';
    @endphp
      <ul style="list-style: none; padding-left: 6px;">
         @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
            <li>
            
                <b>Discount By: </b>&nbsp;<span>
                    {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                    {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                    {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
            
            </li>
        @endif

        @if ($ledgermst_paydisc->disc_amt_request_name != '')
            <li style="margin-top: 4px;">
                
                <b>Disc. Request By: </b>&nbsp;<span>
                    {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
            
            </li>
        @endif
        @if ($invoice_mst_info->doctor_name != '')
            <li style="<?= $ulMarginTop; ?>">   

                        @if ($po_hospital_details->hospital_code == 'GMC')
                        <b>Consultant/Doctor: </b>&nbsp;<span>
                        @else
                        <b>Ref. Doctor: </b>&nbsp;<span>
                        @endif

                        {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }} {{$invoice_mst_info->degree !='' ? ','. $invoice_mst_info->degree :''}}
                        </span>
            </li>
        @endif

        @if ($invoice_mst_info->first_doc_name != ' ')
            <li>          

                    @if (in_array($po_hospital_details->hospital_code ,[ 'GMC','IMPERIAL']))
                    <b>Ref:
                    </b>&nbsp;<span>
                        {{ $invoice_mst_info->person_code != '' ? ucwords($invoice_mst_info->person_code) : '' }}</span>
                    @else
                    <b>1st Ref:
                    </b>&nbsp;<span>
                        {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                    @endif
            </li>
        @endif
        @if ($invoice_mst_info->second_doc_name != ' ')                  
            <li>
                

                    @if (in_array($po_hospital_details->hospital_code ,[ 'IMPERIAL']))
                    <b>External Ref:
                    </b>&nbsp;<span>
                        {{ $invoice_mst_info->second_doc_person_code != '' ? ucwords($invoice_mst_info->second_doc_person_code) : '' }}</span>
                    @else
                    <b>External Ref:
                    </b>&nbsp;<span>
                        {{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                    @endif
            
            </li>
        @endif
      </ul>

        <table width="100%" class="table" style="">
            <thead style="">
                <tr>
                    <th colspan="6"></th>
                </tr>
                <tr>
                    <th class="text-left" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">SL#</th>
                    <th class="text-left" style="border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Item Description</th>
                    <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Rate</th>
                    <!-- <th class="text-right" style="width: 35px">S. <br> Charge</th> -->
                    <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Qty</th>
                    {{-- <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Cx. Qty</th> --}}
                    <th class="text-right" style="width: 40px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Dis.</th>
                    <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Amount </th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid #222!important; ">
                @php
                $totals = 0;
                $service_charges = 0;
                @endphp

                @if (!empty($invoice_dtls_info))
                @foreach ($invoice_dtls_info as $row)
                @php
                $urgent_fee = 0;
                $text_dec = $row->current_item_qty == $row->cancel_qty ? 'text-decoration: line-through; ' : '';
                @endphp
                <tr>
                    <td class="text-center  font-11 black" style="padding: 2px !important;">
                        {{ sprintf('%02d', $loop->iteration) }}
                    </td>
                    <td class="text-left font-11 black" style="padding: 2px !important; <?= $text_dec ?>">
                        {{ $row->item_name }}
                    </td>
                    {{-- <td class="text-left font-11 black" style="padding: 2px !important;">
                        {{ $row->report_delivery_date == '' ? '' : date('d/m/Y', strtotime($row->report_delivery_date)) }}
                    </td> --}}


                    @if ($row->delivery_status_lookup_no_fk == 1)
                    <!-- <td class=" text-left" style="padding: 2px !important;">
                                        {{-- Routine --}}
                                    </td> -->
                    @php
                    $item_rate = $row->item_rate_orig;
                    @endphp
                    @elseif($row->delivery_status_lookup_no_fk == 2)
                    <!-- <td class=" text-left" style="padding: 2px !important; width: 35px"> Urgent </td> -->
                    @php
                    $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                    $item_rate = $row->item_rate_orig + $urgent_fee;
                    @endphp
                    @else
                    <!-- <td></td> -->
                    <!-- @php
                                        $item_rate = $row->item_rate_orig;
                                    @endphp -->
                    @endif

                    <td class=" text-right font-11 black" style="padding: 3px !important;">
                        {{ $row->item_rate_orig }}
                    </td>
                    <!-- <td class=" text-right" style="padding: 3px !important;">
                                    {{ $row->service_charge }}</td> -->
                    <td class=" text-center font-11 black" style="padding: 2px !important;">{{ $row->current_item_qty }}</td>
                    {{-- <td class=" text-center font-11 black" style="padding: 2px !important;">{{ $row->cancel_qty }}</td> --}}
                    <td class="text-right font-11 black bg-light" style="padding: 2px !important;">
                        {{ number_format($row->dis_amt, 2, '.', '') }}
                    </td>
                    <td class="text-right font-11 black bg-light" style="padding: 2px !important;">

                        {{ number_format(($row->current_item_qty * $item_rate) - $row->dis_amt, 2, '.', '') }}
                    </td>
                </tr>
                @php
                if ($row->cancel_ind != 1) {
                $service_charges += $row->current_item_qty * $row->service_charge;
                }
                //$service_charges += ($row->current_item_qty - $row->cancel_qty) * $row->service_charge;
                @endphp
                @endforeach
                @endif
                @php

                // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

                $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');

                $service_charge = number_format($service_charges + $finc_inv_sum_amount->service_charge_cancel, 2, '.', '');

                $totals = $finc_inv_sum_amount->sales;
                $total_item_amt = $finc_inv_sum_amount->sales - $service_charges;
                //$finc_inv_sum_amount->ledger_amt_sales - $service_charge;

                $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');

                $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');

                $payable = number_format($totals - $discount - $finc_inv_sum_amount->sales_cancel, 2, '.', '');

                $due = number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', '');
                $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                //dd($totals , $discount ,$finc_inv_sum_amount->sales_cancel , $finc_inv_sum_amount->net_collection);
                $discount_percent = $totals - $finc_inv_sum_amount->sales_cancel > 0 ? ($discount / ($totals - $finc_inv_sum_amount->sales_cancel)) * 100 : 0;

                $number = $payable > 0 ? $payable : 0;
                $locale = 'en_US';
                $fmt = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                $wholeNumberPart = floor($number);
                $inWordsWhole = $fmt->format($wholeNumberPart);
                $decimalPart = ($number - $wholeNumberPart) * 100; 
                $decimalPart = round($decimalPart);
                $taka = 'Taka';
                $paysha = 'Paysha';
                $in_words = $inWordsWhole . ' ' . $taka . ' ' . ($decimalPart > 0 ? $fmt->format($decimalPart) . ' ' . $paysha : '');
                $to_date = date('Y-m-d');

                @endphp

            </tbody>
        </table>

        <table width="100%" style=" margin:0px; border-top:1px solid black">
            <tr>
                <td  style="text-align: left"> 
                    <b>Subtotal :</b> {{ number_format($total_item_amt, 2) }}  @if ($urgent_fee != 0),  <b>Urgent Fee :</b>{{ number_format($urgent_fee, 2, '.', '') }}@endif
                    @if ($service_charge != 0) , <b>Service Charge :</b>{{ number_format($service_charge, 2, '.', '') }}@endif
                    @if ($vat != 0) , <b>Vat :</b>{{ number_format($vat, 2, '.', '') }}@endif
                   , <b>Total Discount :</b>  {{ number_format($discount, 2, '.', '') }} , <b>Net Payable :</b>{{ $payable >= 0 ? number_format($payable, 2, '.', '') : '0.00' }}
                   , <b>Payment :</b> {{ number_format($finc_inv_collection_amount->collection, 2, '.', '') }} , <b>Total Paid :</b>{{ number_format($finc_inv_sum_amount->net_collection, 2, '.', '') }}
                  ,
                  @if ($due >= 0 && $refund == 0)
                  <b>Due :</b>
                  @elseif($refund > 0)
                  @if ($finc_inv_collection_amount->refund > 0)
                  <b>Refund :
                    @if ($finc_inv_collection_amount->refund > 0)
                    {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }} , 
                    @endif
                  </b>
                  @endif
                  <b>Total Refund :</b>
                  @endif
                  @if ($due >= 0 && $refund == 0)
                  {{ number_format($due, 2, '.', '') }}
                  @elseif($refund > 0)
                   
                  {{ number_format(abs($refund), 2, '.', '') }}
                  @endif
                   {{-- <b>Bill Amount :</b>{{ number_format($payable, 2, '.', '') }} , 
                   <b>Paid:</b>{{ number_format($payment, 2, '.', '') }} ,   <b>Due :</b> {{ number_format($due, 2, '.', '') }} --}}
                   <br>
                   <span> <b>In Word :</b> {{ ucwords($in_words) }} Only </span>
                </td>
            </tr>
            <tr>               
                <td class="" style=" text-align:left">
                    <div class="" style="margin-bottom: 5px">  
                        <div class="text-overlay">
                            Cash Receipt In :
                            @if (!empty($paymood))
                            @foreach ($paymood as $value)
                            @if ($value->paymood == 'CASH')
                            CASH : Tk {{ $value->pay_amount }} 
                            @elseif($value->paymood == 'Mbanking')
                            {{ strtoupper($value->pay_mood_type) }} : Tk {{ $value->pay_amount }} 
                            @elseif($value->paymood == 'CARD')
                            {{ strtoupper('Card') }} ({{ strtoupper($value->pay_mood_type) }}) :
                            Tk {{ $value->pay_amount }} 
                            @else
                            OTHERS : Tk {{ $value->pay_amount }} 
                            @endif
                            @endforeach
                            @endif
                           
                            @if ($invoice_mst_info->invoice_remarks != '')
                            <div style="padding-top: 15px; word-wrap: break-word; ">
                                <strong> {{ $invoice_mst_info->invoice_remarks != '' ? 'Remarks :' : '' }}
                                </strong>{{ $invoice_mst_info->invoice_remarks }}
                            </div>
                            @endif

                            @if (!empty($return_reson))
                            <strong style="padding-top: 30px;"> Return Reason : </strong> {{ $return_reson->refund_reason }} <br>
                            @endif
                            @if (Session::get('user.ses_hospital_code') != 'GMC')
                            <div style="padding-top: 45px">
                                Billed By:
                                @if (!empty($collector_info))
                                @foreach ($collector_info as $collector)
                                {{ $collector->user_fullname }}
                                ({{ date('d/m/Y h:i a', strtotime($collector->ledgertrn_datetime)) }})
                                @if (count($collector_info) != $loop->iteration)
                                ||
                                @else
                                .
                                @endif
                                @endforeach
                                @endif
        
                            </div>
                          
                        </div>
                        <span class="overlay-text" style="float: right;">
                            @if ($due == 0 && $refund == 0)
                            <strong>PAID</strong>
                            @elseif($refund > 0)
                            <strong>Refund</strong><br>
                            @elseif($due > 0 && $refund == 0)
                            <strong>DUE</strong>
                            @endif
                        </span>
                    
                    </div>
                    <br>
                </td>
                @else
                <td ></td>
                @endif

               
            </tr>
          
        </table>
    </main>
</body>
    @if ($length > 1 && $i != $length - 1)
    <div class="page-break"></div>
    @endif
    @endfor


</html>