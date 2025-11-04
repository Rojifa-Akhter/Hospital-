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
            margin-top: 7.4cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: 10px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height:1.5cm;
            text-align: center;
            font-size: 7px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
            padding-top: 10px;
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
        .font-10{
            font-size: 11px !important;
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
            font-size: 30px;
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
            margin-top:70px !important;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
        }
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$marginBottomHeader=$po_hospital_details->report_header_image_prshde_ind != 1 && $po_hospital_details->report_header_image !="" ? 'margin-bottom:-50px;' :'';
@endphp
<header>
    <table style="width: 100%; border:5px solid transparent !important; <?= $marginBottomHeader ?>" class="signature">
        @if ($po_hospital_details->report_header_image_prshde_ind == 1)
            <tr style="">
                <td style="width: 15%; border-right:1px solid transparent!important">
                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
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
            <tr>
                <td style="text-align: center">
                    @if ($po_hospital_details->report_header_image != '')
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" style="width: 90%;height:50px" alt="">
                    @endif
                </td>
            </tr>
        @endif
    </table>
    <div class="pat_info" style="">
        <div class="patient-information d-flex align-items-center">
            <table width="100%" style="padding: 0px; margin:0px">
                <tr>
                    <td style="text-align:left" width="30%"> 
                        <img style="" src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                        <br>
                        {{ $invoice_mst_info->patient_code }}
                    </td>
                    <td style="text-align: center; vertical-align:top"> <strong>Pharmacy  Invoice</strong> 
                 </td>
                    <td style="text-align: right" width="30%">
                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                            style="width: 120px; " /> <br>
                        {{ $invoice_mst_info->invoice_code }}
                    </td>
                </tr>
            </table>
            <table width="100%" style="padding: 0px; margin:0px">
                <tr>
                    <td style="text-align:left" > 
                        <div class="text-left" style="">
                            <ul style="list-style: none; padding-left: 0;">
                                <li><i style="color: blue;"><b>Customer Copy</b></i></li>
                                <li style="margin-top: 4px;">
                                    <b>
                                       @if(session::get('user.ses_hospital_code')=="KPJ") MRN @else UHID @endif
                                    </b>

                                    &nbsp;<span> {{ $invoice_mst_info->patient_code }}</span>
                                </li>
                                @if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE')
                                    <li style="margin-top: 4px;"><b>Name :</b>&nbsp;<span>
                                            {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                    </li>
                                @else
                                    <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                            {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                    </li>
                                @endif
                                <li style="margin-top: 3px;"><b>Pt. Cat. :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_type_code) }} </span>
                                        </li>
                                @if ($invoice_mst_info->ccm_client_name !='')
                                    <li style="margin-top: 3px;"><b>Corp.  :</b>&nbsp;<span>
                                        {{ ucwords($invoice_mst_info->ccm_client_name) }} </span>
                                    </li>
                                @endif
                                @if ($invoice_mst_info->admission_no_pk != '')
                                    <li style="margin-top: 4px;"><b>Admission ID :</b>&nbsp;<span>
                                            {{ ucwords($invoice_mst_info->admission_no_pk) }}  (<strong>Bed/Ward : </strong>{{$invoice_mst_info->bed_name}} / {{$invoice_mst_info->ward_name}})</span>
                                    </li>
                                @endif
                                @if ($invoice_mst_info->mobile1 != '' || $invoice_mst_info->mobile1 != null)
                                    <li style="margin-top: 4px;"><b> Phone no:</b>&nbsp;<span>
                                            {{ !empty($invoice_mst_info->mobile1) ? $invoice_mst_info->mobile1 : '' }}</span>
                                    </li>
                                @endif
                                @if ($invoice_mst_info->gender_txt != '')
                                    <li style="margin-top: 4px;">
                                        <b>{{ $invoice_mst_info->age == '' ? '' : 'Age:' }}</b>&nbsp;<span>{{ $invoice_mst_info->age == '' ? '' : $invoice_mst_info->age . ',' }}</span>
                                        <b>{{ $invoice_mst_info->gender_txt != '' ? 'Sex:' : '' }}</b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>
                                       
                                    </li>
                                @endif
                                <li>
                                    <b>
                                        {{ $invoice_mst_info->mobile1 != '' ? 'Contact:' : '' }}
                                    </b>&nbsp;<span>
                                        {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                </li>

                                @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                                    <li style="margin-top: 4px;">
                                        <b>Discount By: </b>&nbsp;<span>
                                            {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                            {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                            {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
                                    </li>
                                @endif

                                @if ($ledgermst_paydisc->disc_amt_request_name != '')
                                    <li style="margin-top: 4px;"><b>Disc. Request By:
                                        </b>&nbsp;<span>
                                            {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </td>
                    
                    <td style="text-align: right" >
                        <div class="text-right" style="">
                            <ul style="list-style: none; padding-left: 0;">
                                <li>
                                    <strong> Queue No : {{$invoice_mst_info->queue_no_sl}}</strong>
                                </li>
                              
                                <li><b>Date of
                                        Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                </li>
                                <li><b>Invoice ID
                                        :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                </li>
                                <li><b>TRX ID
                                        :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                </li>

                                <!-- <li><i style="color: blue;"><b>Duplicate Copy</b></i> </li> -->
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
           
        </div>
    </div>
</header>
<body>
   @php
$footerHide=session::get('user.ses_hospital_code')=="KPJ" ? 'display:none' :'';
@endphp

    <footer style="border-top: 1px solid transparent;<?= $footerHide ?>">

        <table style="border:0px; border-top:1px solid #222; font-size:10px !important">
            <?php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left;">Print:
                    {{ Session::get('user.user_code') }} /  <span> {{ date('d-m-Y') }} / {{ $date }}</span>
                    </td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
        

        <table class="table" width="100%">
            <thead>
                <tr style="">
                    <th class="text-left" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">SL#</th>
                    <th class="text-left" style="border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Item Description</th>
                    <th class="text-right" style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Qty</th>
                    <th class="text-left" style="width: 55px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">Expiry / <br> Batch </th> 
                    <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">MRP</th>
                    <th class="text-right" style="width: 40px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Disc <br> (<small>amt</small>)</th>
                    <!-- <th class="text-left" style="width: 80px">Expire Date</th> -->
                    <th class="text-right" style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">Amount 
                    </th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid #222!important; ">

                @php
                    $total = 0;
                    $total_disc_amount = 0;
                @endphp
                @if (!empty($invoice_dtls_info))
                    @foreach ($invoice_dtls_info as $row)
                        @php
                            $urgent_fee = 0;
                        @endphp

                        <tr>
                            <td class="text-left font-10 black" style="padding: 3px !important;">
                                {{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="text-left font-10 black" style="padding: 3px !important;">
                                {{ $row->item_name }}<br>                               
                            </td>
                            
                            <td class=" text-center font-10 black" style="padding: 3px !important;">
                                {{ $row->item_qty }}</td>
                           <td class="text-left font-10 black" style="padding: 3px !important;">
                                @if (!empty($exp_date))
                                    @foreach ($exp_date as $data)
                                        @if ($row->item_no_fk == $data->item_no_fk && $data->batch_no != '')
                                            <small>
                                                {{ $data->batch_no ? date('d-m-Y', strtotime($data->expiry_date)) : '' }} 
                                                {{ $data->batch_no ?  $data->batch_no : '' }}
                                            </small>
                                        @endif
                                    @endforeach
                                @endif
                           </td>

                            @php
                                $item_rate = $row->item_rate;
                                $disc_amount = $row->disc_amount;
                            @endphp

                            <td class=" text-right item_rate font-10 black" style="padding: 3px !important;">
                                {{ number_format($item_rate, 2, '.', '') }}</td>
                            <td class=" text-right item_rate font-10 black" style="padding: 3px !important;">
                                {{ number_format($disc_amount, 2, '.', '') }}</td>
                            <td class="text-right bg-light font-10 black" style="padding: 3px !important;">
                                {{ number_format(($row->item_qty * $item_rate)- $disc_amount, 2, '.', '') }}</td>
                        </tr>

                        @php
                            $total += $row->item_qty * $item_rate; 
                            $total_disc_amount += $row->disc_amount;
                        @endphp
                    @endforeach
                @endif
                @php
               
                    $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                    $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                    $total =number_format($total, 2, '.', '') ;// number_format($finc_inv_sum_amount->sales - $finc_inv_sum_amount->discount, 2, '.', '');
                    $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                    $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');
                    $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                    $payable = number_format(($total + $finc_inv_sum_amount->ledger_amt_vat) - $discount - $finc_inv_sum_amount->sales_cancel + $cancel_discount, 2, '.', '');

                    $due = round(number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', ''));
                    $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                    $number = $payable;
                    // $locale = 'en_US';
                    // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    // $in_words = numfmt_format($fmt, $number);
                    $locale = 'en_US';
                    $fmt = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                    $wholeNumberPart = floor(abs($number));
                    $inWordsWhole = $fmt->format($wholeNumberPart);
                    $decimalPart = (abs($number) - $wholeNumberPart) * 100; 
                    $decimalPart = round($decimalPart);
                    $taka = 'Taka';
                    $paysha = 'Paysha';
                    $in_words = $inWordsWhole . ' ' . $taka . ' ' . ($decimalPart > 0 ? $fmt->format($decimalPart) . ' ' . $paysha : '');
                    $to_date = date('Y-m-d');
                @endphp

            </tbody>

        </table>
        <table style=" margin:0px; border-top:1px solid black">
            <tr>
                <td colspan="3" style="text-align: left">
                    <b>Subtotal :</b>  {{ number_format($total, 2) }} ,  <b>Discount :</b> {{ number_format($discount, 2, '.', '') }} , <b>Bill Amount :</b> {{ number_format($payable, 2, '.', '') }} , <b>Paid :</b> {{ number_format($payment, 2, '.', '') }} , 
                    <b>
                        @if ($due >= 0 && $refund == 0)
                        <b>Due :</b>
                    @elseif( $refund > 0)

                    @if ($finc_inv_collection_amount->refund > 0)
                    <b>Refund :</b> <br>
                    @endif
                        <b>Total Refund :</b>
                    @endif
                    </b>
                    @if ($due >= 0 && $refund == 0)
                    {{ number_format($due, 2, '.', '') }}
                   @elseif( $refund > 0)

                   @if ($finc_inv_collection_amount->refund > 0)
                    {{    number_format(abs($finc_inv_collection_amount->refund ), 2, '.', '')}} <br>
                   @endif
                        {{ number_format(abs($refund), 2, '.', '') }}
                   @endif
                   <br>
                   In Word : {{ ucwords($in_words) }}  Only
                </td>
            </tr>
            <tr>
                @if (isset($ledger_no) && $ledger_no != '')
                    <td class=""  colspan="3" style="padding: 3px !important;  text-align:left">
                        <div class="main_container" style="margin-bottom: 5px">  
                            <div class="text-overlay">
                                Cash Receipt In :
                                @foreach ($ledger_no as $value)
                                    @if ($value->paymood == 'CASH')
                                        CASH : Tk {{ $value->pay_amount }} ,
                                    @elseif($value->paymood == 'Mbanking')
                                        {{ strtoupper($value->pay_mood_type) }}
                                        : Tk {{ $value->pay_amount }} ,
                                    @elseif($value->paymood == 'CARD')
                                        {{ strtoupper('Card') }}
                                        ({{ strtoupper($value->pay_mood_type) }})
                                        : Tk 
                                        {{ $value->pay_amount }} ,
                                    @else
                                        OTHERS : Tk {{ $value->pay_amount }} ,
                                    @endif
                                @endforeach                            
                                
                            </div>
                           
                            <span class="overlay-text">
                                @if ($due == 0 && $refund == 0)
                                    <strong>PAID</strong>
                                @elseif ($refund > 0)
                                    <strong>Refund</strong><br>
                                @elseif ($due > 0 && $refund == 0)
                                    <strong>DUE</strong>
                                @endif
                            </span>
                        </div>
                       
                    </td>
                @else
                    <td colspan="3" style="padding: 3px !important"></td>
                @endif

            </tr>           
       
        </table>
        <div style="margin-top:45px;">
            <span style="border-top:#222 1px solid"><strong>Verified By Pharmacist</strong></span>
        </div>
        <div style="margin-top:10px;">
            <span>Returns are only accepted within 15 days from the date of purchase.</span> <br>
            <span>A valid receipt of purchase is required for all returns or exchange.</span> <br>
            <span>Temperature sensitive medicines such as Vaccine, Insulin etc., opened tablets / Capsules, damaged or faulty products are not eligible for return or exchange.</span>
        </div>
    </main>
</body>
</html>
