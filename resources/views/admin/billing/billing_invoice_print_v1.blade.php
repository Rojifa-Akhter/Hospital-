@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
// dd( $hospital);
$body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 :11;
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Invice Print</title>
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
            margin-top: 5.2cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?=$body_font_size ?>px !important;
            /* padding-left: .5cm;
            padding-right: .5cm; */
            /* color: black; */
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 1.5cm;
            text-align: center;
            font-size: 7px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
            padding-top: 10px;
            border-top:none;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            height: 1.8cm;
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

        .page-break {
            page-break-after: always;
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
        .pat_info{
            margin-top: 70px !important;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
        }
    </style>
   
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$length = isset($po_hospital_details->no_of_invoice_print) && $po_hospital_details->no_of_invoice_print != '' ? $po_hospital_details->no_of_invoice_print : 1;
$marginBottomHeader=$po_hospital_details->report_header_image_prshde_ind != 1 && $po_hospital_details->report_header_image !="" ? 'margin-bottom:-50px;' :'';
@endphp


@for ($i = 0; $i < $length; $i++)

    <body style="">
        <header>
            <table style="width: 100%; border:5px solid transparent !important; <?= $marginBottomHeader ?>" class="signature">
                @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                    {{-- <tr style="">
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
                    </tr> --}}
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
                    <tr>
                        <td style="text-align: center">
                            @if ($po_hospital_details->report_header_image != '')
                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" alt="" style="width: 90%;height:50px">
                            @endif

                        </td>
                    </tr>
                @endif
            </table>
            <div class="pat_info" style="">
                <div class="patient-information d-flex align-items-center">
                    {{-- <div class="" style="padding: 3px !important; font-size: 15px"> --}}
                    <table width="100%" style="padding: 0px; margin:0px">
                        <tr>
                            <td style="text-align:left" width="30%"> <img style=""
                                    src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                                <br>
                                {{ $invoice_mst_info->patient_code }}
                            </td>
                            <td style="text-align: center; vertical-align:top">
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <div>Investigation</div>
                                    <div>Payment</div>
                                @else
                                  <strong>Invoice Cum Receipt</strong>  
                                @endif

                            </td>
                            <td style="text-align: right" width="30%">
                                <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                    style="width: 120px; " /> <br>
                                {{ $invoice_mst_info->invoice_code }}
                            </td>
                        </tr>
                    </table>
                    <table width="100%" style="padding: 0px; margin:0px">
                        <tbody>
                            <tr>
                                <td class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li style="margin-top: 3px;">

                                                <b> @if(session::get('user.ses_hospital_code')=="KPJ") MRN @else UHID @endif :</b>&nbsp;
                                            
                                            <span>
                                                {{ $invoice_mst_info->patient_code }}</span></li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                            <li style="margin-top: 3px;"><b> IP No
                                                    :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->admission_no_pk }} (<strong>Bed/Cabin</strong>: {{$bed_details}}) </span>
                                            </li>
                                        @endif
                                        <li style="margin-top: 3px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                        </li>
                                        <li style="margin-top: 3px;"><b>Pt. Cat. :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_type_code) }} </span>
                                        </li>
                                        @if ($invoice_mst_info->ccm_client_name !='')
                                            <li style="margin-top: 3px;"><b>Corp.  :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->ccm_client_name) }} </span>
                                            </li>
                                        @endif
                                        
                                        <li style="margin-top: 3px;">
                                            @php
                                                $pat_dob = new \DateTime($invoice_mst_info->dob);
                                                $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                                $interval = $invoice_date->diff($pat_dob);
                                            @endphp
                                            <b>Age:</b>&nbsp;<span>{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</span>
                                            <b>Gender :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>
                                           
                                        </li>
                                        <li style="margin-top: 3px;">
                                            <b>Contact: </b><span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>

                                     


                                    </ul>

                                </td>
                                <td class="text-right" style="vertical-align: text-top;">

                                    <ul style="list-style: none; padding-left: 0;">
                                        <li>
                                            <i style="color: blue;"><b>
                                                    @if ($i == 0)
                                                        Customer Copy
                                                    @elseif ($i == 1)
                                                        Lab Copy
                                                    @else
                                                        Office Copy
                                                    @endif
                                                </b></i>
                                        </li>
                                        <li><b>Date of Invoice :</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($invoice_mst_info->invoice_date)) }}</span></li>
                                        <li><b>Invoice ID:</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span></li>
                                        <li><b> TRX ID :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span></li>                                        
                                    </ul>

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
            {{-- <div class="">
                <table style="width: 100%; border:none " >
                    <tr style=" ">
                        <td style="text-align:left; border:none ">
                            <span style="padding:5px; border-top: black solid 1px;"> Prepared  By</span>
                        </td>

                        <td style="text-align:center; border:none">
                            <span style="padding:5px; border-top: black solid 1px;"> Checked By</span>
                        </td>

                        <td style="text-align:right; border:none">
                            <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                        </td>
                    </tr>
                </table>
            </div> --}}

            <table style="  font-size:10px !important">
                <?php
                // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                // $date = $dt->format('g:i A');
                date_default_timezone_set('Asia/Dhaka');
                $date = date('h:i a'); // $dt->format('g:i A');
                ?>
                <tr>
                    <td style=" padding-top: 5px; text-align: left; padding-left:20px; ">
                        Print: {{ Session::get('user.user_code') }} /  <span> {{ date('d-m-Y') }} / {{ $date }}</span>
                         {{-- Printing Date & Time:{{ $date }} --}}
                    </td>
                    <td style="padding-top: 5px; width:30%;padding-right:20px;">Powered By: [NEXTGEN]</td>
                </tr>
            </table>
           
        </footer>


        <main>
            @php 
                $ulMarginTop=$invoice_mst_info->admission_no_pk != '' ? 'margin-top: 55px !important':'margin-top: 35px !important';
            @endphp
            <ul style="list-style: none; padding-left: 5px;">
                @if ($invoice_mst_info->doctor_name != '')
                    <li style="<?= $ulMarginTop; ?>">
                    
                            @if ($po_hospital_details->hospital_code == 'GMC')
                                <b>Consultant/Doctor: </b>&nbsp;<span>
                                @else
                                    <b>Ref. Doctor: </b>&nbsp;<span>
                            @endif
                            {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }} {{$invoice_mst_info->degree !='' ? ','. $invoice_mst_info->degree :''}}</span>
                    
                    </li>
                @endif

                @if ($invoice_mst_info->first_doc_name != ' ')
                    <li style="margin-top: 3px;">
                    
                            @if ($po_hospital_details->hospital_code == 'GMC')
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
                    <li style="margin-top: 3px;">
                    
                            <b>External Ref:
                            </b>&nbsp;<span>
                                {{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                    
                    </li>
                @endif

                @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                    <li style="margin-top: 3px;">
                    
                            <b>Discount By: </b>&nbsp;<span>
                                {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
                    
                    </li>
                @endif

                @if ($ledgermst_paydisc->disc_amt_request_name != '')
                    <li style="margin-top: 3px;">
                    
                            <b>Disc. Request By:
                            </b>&nbsp;<span>
                                {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                    
                    </li>
                @endif
            </ul>

            <table class="table" style="margin-top:20px;">
                <thead style="">
                    <tr>
                        <th class="text-left" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">SL#</th>
                        <th class="text-left" style="border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Item Description</th>
                        {{-- <th class="text-left" style="width: 50px"></th> --}}
                        <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Rate</th>
                        <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Qty</th>
                        <th class="text-right"  style="width: 40px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Dis.</th>
                        <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Amount </th>
                    </tr>
                </thead>
                <tbody style="border-top: 1px solid #222!important; ">
                    @php
                        $total = 0;
                        $service_charges = 0;
                    @endphp

                    @if (!empty($invoice_dtls_info))
                        @foreach ($invoice_dtls_info as $row)
                            @php
                                $urgent_fee = 0;

                            @endphp

                            <tr>
                                <td class="text-left   font-11 black" style="padding: 3px !important;">
                                    {{ sprintf('%02d', $loop->iteration) }}</td>
                                <td class="text-left  font-11 black" style="padding: 3px !important;">
                                    {{ $row->item_name }}</td>
                                {{-- <td class="text-left" style="padding: 3px !important;">
                                    {{ $row->report_delivery_date == '' ? '' : date('d/m/Y', strtotime($row->report_delivery_date)) }}
                                </td> --}}
                                @if ($row->delivery_status_lookup_no_fk == 1)
                                    {{-- <td class=" text-left" style="padding: 3px !important;">
                                      
                                    </td> --}}
                                    @php
                                        $item_rate = $row->ledgerdtl_amt_sales;

                                    @endphp
                                @elseif($row->delivery_status_lookup_no_fk == 2)
                                    {{-- <td class=" text-left" style="padding: 3px !important; width: 50px">
                                        Urgent
                                    </td> --}}
                                    @php
                                        $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                        $item_rate = $row->ledgerdtl_amt_sales + $urgent_fee;

                                    @endphp
                                @else
                                    @php
                                        $item_rate = $row->ledgerdtl_amt_sales;

                                    @endphp
                                    {{-- <td></td> --}}
                                @endif
                                <td class=" text-right font-11 black" style="padding: 3px !important;">
                                    {{ $row->item_rate }}</td>
                                <td class=" text-center font-11 black" style="padding: 3px !important;">
                                    {{ $row->item_qty }}</td>
                                <td class=" text-right font-11 black" style="padding: 3px !important;">
                                    {{ number_format($row->disc_amount, 2, '.', '') }}</td>
                                <td class="text-right bg-light font-11 black" style="padding: 3px !important;">
                                    {{ number_format( $item_rate-$row->disc_amount, 2, '.', '') }}
                                  
                                </td>
                            </tr>

                            @php
                                if ($row->cancel_ind != 1) {
                                    $service_charges +=  $row->service_charge;
                                   
                                }

                            @endphp
                        @endforeach
                    @endif
                    @php
                        $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                        $service_charge = number_format($service_charges, 2, '.', '');
                        $total = $finc_inv_sum_amount->sales;
                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                        $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                        $payable = number_format(($finc_inv_sum_amount->net_sales + $service_charges), 2, '.', '');
                        $due = number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', '');
                        $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                        $number = $finc_inv_sum_amount->net_sales; //$total - $discount;
                        $discount_percent= $discount >0 ?($discount /  $total ) * 100 : 0 ;
                        // $locale = 'en_US';
                        // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        // $in_words = numfmt_format($fmt, $number);
                        // Set the number you want to convert
                        // $number = 1340.02;

                        // Create a NumberFormatter instance for the English locale
                        $locale = 'en_US';
                        $fmt = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                        $wholeNumberPart = floor($number);
                        $inWordsWhole = $fmt->format($wholeNumberPart);
                        $decimalPart = ($number - $wholeNumberPart) * 100; 
                        $decimalPart = round($decimalPart);
                        $taka = 'Taka';
                        $paysha = 'Poysha';
                        $in_words = $inWordsWhole . ' ' . $taka . ' ' . ($decimalPart > 0 ? $fmt->format($decimalPart) . ' ' . $paysha : '');

                        $to_date = date('Y-m-d');
                    @endphp

                </tbody>


            </table>
            <table width="100%" style=" margin:0px ; border-top:1px solid black">
                <tr>
                    <td  style="text-align: left"> 
                        <b>Subtotal :</b> {{ number_format($total, 2) }}  @if ($urgent_fee != 0),  <b>Urgent Fee :</b>{{ number_format($urgent_fee, 2, '.', '') }}@endif
                        @if ($service_charge != 0) , <b>Service Charge :</b>{{ number_format($service_charge, 2, '.', '') }}@endif
                        @if ($vat != 0) , <b>Vat :</b>{{ number_format($vat, 2, '.', '') }}@endif
                       , <b>Discount :</b>  {{ number_format($discount, 2, '.', '') }} ,  <b>Bill Amount :</b>{{ number_format($payable, 2, '.', '') }} , 
                       <b>Paid:</b>{{ number_format($payment, 2, '.', '') }} ,   <b>Due :</b> {{ number_format($due, 2, '.', '') }}
                       <br>
                       <span> <b>In Word :</b> {{ ucwords($in_words) }} Only </span>
                    </td>
                </tr>
                <tr>
                   
                    @if (isset($ledger_no) && $ledger_no != '')
                        <td class=""  style="padding: 0px !important; text-align:left">
                            <div class="main_container" style="margin-bottom: 5px">  

                                <div class="text-overlay">
                                   Cash Receipt In :
                          
                                    @foreach ($ledger_no as $value)
                                        @if ($value->paymood == 'CASH')
                                            CASH : Tk {{ $value->pay_amount }} 
                                        @elseif($value->paymood == 'Mbanking')
                                            {{ strtoupper($value->pay_mood_type) }}
                                            : Tk {{ $value->pay_amount }} 
                                        @elseif($value->paymood == 'CARD')
                                            {{ strtoupper('Card') }}
                                            ({{ strtoupper($value->pay_mood_type) }})
                                            : Tk {{ $value->pay_amount }} 
                                        @elseif($value->paymood == 'DEPOSITED')
                                            {{ strtoupper('DEPOSITED') }}
                                            {{ strtoupper($value->pay_mood_type) }}
                                            : Tk {{ $value->pay_amount }} 
                                        @else
                                            OTHERS : Tk {{ $value->pay_amount }} 
                                        @endif
                                    @endforeach    
                                    @if ($invoice_mst_info->invoice_remarks !="")
                                        <div style="padding-top: 15px; word-wrap: break-word; ">
                                            <strong>Remarks : </strong>{{ $invoice_mst_info->invoice_remarks }}
                                        </div>
                                    @endif               
                                    @if(Session::get('user.ses_hospital_code') != "GMC")
                                    <div style="padding-top: 30px">
                                        <b>Billed By:</b>
                                        @if(!empty($collector_info))        
                                        @foreach ($collector_info as $collector)
                                        {{  $collector->user_fullname }} ({{ date('d/m/Y h:i a',strtotime($collector->ledgertrn_datetime)) }})
                                        @if (count($collector_info)!= $loop->iteration)
                                        ||
                                        @else
                                        .
                                        @endif
                                        @endforeach
                                        @endif        
                                    </div>
                                    @endif      
                                    
                                </div>
                                <span class="overlay-text " style="float: right;">
                                    @if ($due == 0 && $refund == 0)
                                        <strong>PAID</strong>
                                    @elseif($due == 0 && $refund > 0)
                                        <strong>Refund</strong><br>
                                    @elseif($due > 0 && $refund == 0)
                                        <strong>DUE</strong>
                                    @endif
                                </span>
                            </div>
                           
                           
                            {{-- <div style="padding-top: 5px; word-wrap: break-word; ">
                                <span> <b>In Word :</b> {{ ucwords($in_words) }} Taka Only</span>
                            </div> --}}
                           
                           
                        </td>
                    @else
                        <td style="padding: 0px !important"></td>
                    @endif

                    {{-- <td class="text-right" colspan="2" style="padding: 0px !important">
                        <b>SUBTOTAL :</b>
                    </td> --}}
                    {{-- <td class="text-right" style="padding: 0px !important">
                        {{ number_format($total, 2) }}</td> --}}
                </tr>
                {{-- @if ($urgent_fee != 0)
                    <tr>
                        <td class="text-right" colspan="2" style="padding: 0px !important"><b>Urgent Fee :</b>
                        </td>
                        <td class="text-right" style="padding: 0px !important">
                            {{ number_format($urgent_fee, 2, '.', '') }}</td>
                    </tr>
                @endif
                @if ($service_charge != 0)
                    <tr>
                        <td class="text-right" colspan="2" style="padding: 0px !important"><b>Service Charge :</b>
                        </td>
                        <td class="text-right" style="padding: 0px !important">
                            {{ number_format($service_charge, 2, '.', '') }}</td>
                    </tr>
                @endif

                @if ($vat != 0)
                    <tr>
                        <td class="text-right" colspan="2" style="padding: 0px !important">
                            <b>Vat :</b>
                        </td>
                        <td class="text-right" style="padding: 0px !important">
                            {{ number_format($vat, 2, '.', '') }}</td>
                    </tr>
                @endif --}}

                {{-- <tr>
                    <td class="text-right" colspan="2" style="padding: 0px !important">
                        <b>Discount{{ Session::get('user.ses_hospital_code') == "GMC" || Session::get('user.ses_hospital_code') == "AMCSH" ? '('.number_format($discount_percent,2).'%)' : ''}} :</b>
                    </td>
                    <td class="text-right" style="padding: 0px !important">
                        {{ number_format($discount, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2" style="padding: 0px !important">
                        <b>Bill Amount :</b>
                    </td>
                    <td class="text-right" style="padding: 0px !important">
                        {{ number_format($payable, 2, '.', '') }}</td>
                </tr>
                <tr>

                    <td class="text-right" colspan="2" style="padding: 0px !important">
                        <b>Paid:</b>
                    </td>
                    <td class="text-right" style="padding: 0px !important">
                        {{ number_format($payment, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2" style="padding: 0px !important">
                        <b>Due :</b>
                    </td>
                    <td class="text-right" style="padding: 0px !important">
                        {{ number_format($due, 2, '.', '') }}</td>
                </tr> --}}
            </table>
        </main>
       
    
    </body>
    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor

</html>
