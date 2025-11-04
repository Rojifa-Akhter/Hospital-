@php
    $footer_height = $po_hospital_details->hospital_code == 'DMHL' ? 3.6 : 3.8;
    
@endphp


<style>
    /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
    @page {
        margin-top: -20px;
        /*margin-bottom: 15px;*/
    }

    .header {
        position: fixed;
        left: 0px;
        top: -140px;
        right: 0px;
        height: 150px;
        text-align: center;
    }

    /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

    footer {
        position: fixed;
        z-index: 999999999;

        left: 0;
        right: 0;
        height: <?=$footer_height ?>cm !important;
        text-align: center;
        font-size: 9px;
        bottom: -125px;
        /* border-top: 1px solid black;
        /* g<<dding-top: 10px; */g<
        border-top:none; */
    }

    body {
        margin-top: 10px;
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
        /* padding-left: .5cm;
        padding-right: .5cm; */
    }

    .bg-black {
        background-color: #222;
        color: #fff;
    }


    table {
        border-collapse: collapse;
        width: 100%;

    }

    table tr td,
    table tr th {
        font-size: 11px;
        border: 0;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        padding: 2px;
        /*border-width: thin;*/
    }

    



    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

   

  
    .border-bottom {
        border-bottom: 1px solid #dee2e6;
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
</style>

@php
    $length =
        isset($po_hospital_details->consultation_invoice_print) &&
        $po_hospital_details->consultation_invoice_print != ''
            ? $po_hospital_details->consultation_invoice_print
            : 1;
    $imagePath = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';
    $imagePathImpala = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';

    date_default_timezone_set('Asia/Dhaka');
    $date = date('d/m/Y h:i a'); // $dt->format('g:i A');

@endphp
@for ($i = 0; $i < $length; $i++)
    <div class="container-fluid">
        <div class="form-row justify-content-center">           
            <div class="form-content">
                <div class="form-heading  border-bottom pb-3">
                    @if ($po_hospital_details->report_header_image_prshde_ind == 1)


                        @if ($po_hospital_details->hospital_code != 'KBMH')
                            @if ($po_hospital_details->hospital_code == 'IMPALA')
                                <div id="logo"
                                    style="display:inline-block !important; width:70px;vertical-align: middle; margin-right:20px">
                                    @if (!empty($po_hospital_details->logo))
                                        <img src="{{ $imagePathImpala }}" />
                                    @endif
                                </div>
                                <div class="hospital-address" style="display:inline-block !important">
                                    <h3 class="mb-0 ">
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </h3>
                                    <br>
                                    <p style="font-size: 10px !important;" class="mb-0 ">
                                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                    </p>
                                    <br>
                                    <p style="font-size: 10px !important;" class="mb-0 ">
                                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                    </p>
                                </div>
                            @else
                                <div id="logo"
                                    style="display:inline-block !important; width:70px;vertical-align: middle; margin-right:20px">
                                    @if (!empty($po_hospital_details->logo))
                                        <img src="{{ $imagePath }}" />
                                    @endif
                                </div>
                                <div class="hospital-address" style="display:inline-block !important">
                                    <h3 class="mb-0 ">
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </h3>
                                    <br>
                                    <p style="font-size: 10px !important;" class="mb-0 ">
                                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                    </p>
                                    <br>
                                    <p style="font-size: 10px !important;" class="mb-0 ">
                                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                    </p>
                                </div>
                            @endif
                        @else
                            <div style="height: 80px"></div>
                        @endif
                    @else
                        <div id="" style="  text-align:center ; padding-bottom:15px; height:80px;">
                            <div style="">
                                @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="250px" alt="">
                                @endif
                            </div>

                        </div>
                    @endif
                </div>

                <div class="" style=" margin: 2px 0px;">

                    <table width="100%" style="padding: 0px; margin:0px">
                        <tr>
                            <td style="text-align:left" width="30%"> <img
                                    src="data:image/png;base64, {{ $pat_barcode }} "
                                    style="width: 120px; " />
                                <br>
                                {{ $invoice_mst_info->patient_code }}
                            </td>
                            <td style="text-align: center;vertical-align:top;">
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <div>Consultation</div>
                                    <div>Payment</div>
                                @else
                                    Invoice Cum Receipt
                                @endif

                            </td>
                            <td style="text-align: right" width="30%">
                                <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                    style="width: 120px; " /> <br>
                                {{ $invoice_mst_info->invoice_code }}
                            </td>
                        </tr>
                    </table>
                    <div class="patient-information ">
                        <table width="100%" style="">
                            <tr>
                                <td class="text-left">
                                    <div class="text-left" style="">
                                        <ul style="list-style: none; padding-left: 0;">

                                            <li style=""><b> @if(session::get('user.ses_hospital_code')=="KPJ") MRN @else UHID @endif :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->patient_code }}</span></li>

                                            <li style=""><b>Patient Name :</b>&nbsp;<span>
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

                                            <li style="margin-top: 3px;>
                                                @php
                                                    $pat_dob = new \DateTime($invoice_mst_info->dob);
                                                    $invoice_date = new \DateTime(
                                                        $invoice_mst_info->invoice_date,
                                                    );
                                                    $interval = $invoice_date->diff($pat_dob);
                                                @endphp
                                                <b>Age:</b>&nbsp;<span>{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</span>
                                                <b>Sex :
                                                </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>

                                            </li>
                                            <li style="margin-top: 3px;>
                                                <b>Contact: </b><span>
                                                    {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                            </li>

                                            {{-- @if ($invoice_mst_info->present_addr != '  ' && $invoice_mst_info->present_addr != null)
                                                <li style=""><b>Address: </b>&nbsp;<span>
                                                        {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                </li>
                                            @endif --}}

                                         
                                            {{-- @if ($appoint_type != '')
                                                <li style=""><b>Appointment type:
                                                    </b>&nbsp;<span>
                                                        {{ isset($appoint_type) ? $appoint_type : '' }}</span>
                                                </li>
                                            @endif --}}

                                        </ul>
                                    </div>
                                </td>
                                <td class="text-right" style="vertical-align: text-top;">
                                    <div class="text-right" style="">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li><i style="color: blue;"><b>
                                                        @if ($i == 0)
                                                            Customer Copy
                                                        @elseif($i == 1)
                                                            Office Copy
                                                        @endif
                                                    </b></i></li>
                                            {{-- <li>
                                                <b>Printed By:</b> {{ Session::get('user.ses_user_name') }}

                                            </li> --}}
                                            <li><b>
                                                Date of Invoice:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                         </li>
                                         <li><b>Invoice ID
                                            :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                        </li>
                                         <li><b>TRX ID
                                                 :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                         </li>                                        
                                        
                                            
                                            {{-- <li><b>Dr. ID
                                                    :</b>&nbsp;<span>{{ isset($invoice_mst_info->doc_person_code) ? $invoice_mst_info->doc_person_code : '' }}</span>
                                            </li> --}}


                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <ul style="list-style: none; padding-left: 5px; margin-top:0px; padding-top:0px !important">
                            <li style="">
                                @if ($invoice_mst_info->doctor_name != '')
                                    @if ($po_hospital_details->hospital_code == 'GMC')
                                        <b>Consultant/Doctor: </b>&nbsp;<span>
                                        @else
                                            <b>Ref. Doctor: </b>&nbsp;<span>
                                    @endif
                                    {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }} {{$invoice_mst_info->degree !='' ? ','. $invoice_mst_info->degree :''}}</span>
                                @endif
                            </li>
                            <li style="">
                                @if ($invoice_mst_info->doc_serviceunit_name != '')
                                    <b>Department: </b>&nbsp;<span>
    
                                        {{ $invoice_mst_info->doc_serviceunit_name != '' ? ucwords($invoice_mst_info->doc_serviceunit_name) : '' }}</span>
                                @endif
                            </li>
    
    
    
                            <li style="">
                                @if ($invoice_mst_info->first_doc_name != ' ')
                                    @if ($po_hospital_details->hospital_code == 'GMC')
                                        <b>Ref:
                                        </b>&nbsp;<span>
                                            {{ $invoice_mst_info->person_code != '' ? ucwords($invoice_mst_info->person_code) : '' }}</span>
                                    @else
                                        <b>1st Ref:
                                        </b>&nbsp;<span>
                                            {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                    @endif
                                @endif
                            </li>
    
                            @if ($invoice_mst_info->second_doc_name != ' ')
                                <li style=""><b>External Ref:
                                    </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                </li>
                            @endif
    
                            @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                                <li style="">
                                    <b>Discount By: </b>&nbsp;<span>
                                        {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                        {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                        {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
                                </li>
                            @endif
    
                            @if ($ledgermst_paydisc->disc_amt_request_name != '')
                                <li style=""><b>Disc. Request By:
                                    </b>&nbsp;<span>
                                        {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="form-body" style="">
                 
                    <table width="100%" class="table">
                        <thead>
                            <tr>
                                <th class="text-left"
                                    style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important">
                                    SL#</th>
                                <th class="text-left"
                                    style="border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">
                                    Item Description</th>
                                <th class="text-right"
                                    style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">
                                    Rate</th>
                                <th class="text-right"
                                    style="width: 10px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">
                                    Qty</th>
                                <th class="text-right"
                                    style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">
                                    Dis. </th>
                                <th class="text-right"
                                    style="width: 50px;border: 1px solid #222!important;background-color:rgb(212, 209, 209) !important;">
                                    Amount </th>
                            </tr>
                        </thead>
                        <tbody
                            style="border-top: 1px solid #222!important; border-bottom: 1px solid #222!important;">
                            @php
                                $total = 0;
                            @endphp
                            @if (!empty($invoice_dtls_info))
                                @foreach ($invoice_dtls_info as $row)
                               
                                    @php
                                        $urgent_fee = 0;
                                    @endphp
                                    <tr>
                                        <td class="text-left " style="padding: 3px !important;">
                                            {{ sprintf('%02d', $loop->iteration) }}</td>
                                        <td class="text-left" style="padding: 3px !important;">
                                           {{ $row->item_name }}</td>

                                        @php
                                            $item_rate = $row->item_rate;
                                        @endphp

                                        <td class=" text-right item_rate" style="padding: 3px !important;">
                                            {{ number_format($item_rate, 2, '.', '') }}</td>
                                        <td class=" text-center" style="padding: 3px !important;">
                                            {{ $row->item_qty }}</td>
                                        <td class="text-right bg-light" style="padding: 3px !important;">
                                            {{ number_format($row->disc_amount , 2, '.', '') }}
                                        </td>
                                        <td class="text-right bg-light" style="padding: 3px !important;">
                                            {{ number_format(($row->item_qty * $item_rate)-$row->disc_amount, 2, '.', '') }}
                                        </td>
                                    </tr>

                                @endforeach
                            @endif
                            @php
                                $vat = number_format(0, 2, '.', '');
                                $total = $finc_inv_sum_amount->sales;
                                $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                // $payable = number_format($finc_inv_sum_amount->net_sales, 2, '.', '');
                                $payable = number_format($finc_inv_sum_amount->sales, 2, '.', '');
                                $due = number_format(
                                    ($payable-$discount) - $finc_inv_sum_amount->net_collection,
                                    2,
                                    '.',
                                    '',
                                );
                                $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                $number = $total - $discount;
                                $locale = 'en_US';
                                $fmt = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
                                $wholeNumberPart = floor($number);
                                $inWordsWhole = $fmt->format($wholeNumberPart);
                                $decimalPart = ($number - $wholeNumberPart) * 100;
                                $decimalPart = round($decimalPart);
                                $taka = 'Taka';
                                $paysha = 'Paysha';
                                $in_words =
                                    $inWordsWhole .
                                    ' ' .
                                    $taka .
                                    ' ' .
                                    ($decimalPart > 0 ? $fmt->format($decimalPart) . ' ' . $paysha : '');
                            @endphp
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: left" colspan="5">
                                    <b>Subtotal :</b> {{ number_format($total, 2) }}
                                    , <b>Discount :</b> {{ number_format($discount, 2, '.', '') }} ,
                                    <b>Bill Amount :</b>{{ number_format($payable, 2, '.', '') }} ,
                                    <b>Paid:</b>{{ number_format($payment, 2, '.', '') }} ,
                                    @if ($due >= 0 && $refund == 0)
                                        <b>Due :</b>
                                    @elseif($due <= 0 && $refund > 0)
                                        <b>Refund :</b>
                                    @endif
                                    {{-- @dd($due , $r  efund) --}}
                                    {{ number_format(abs($due), 2, '.', '') }}
                                    <br>
                                    <span> <b>In Word :</b> {{ ucwords($in_words) }} Only </span>
                                </td>
                            </tr>
                            <tr>
                                @if (isset($ledger_no) && $ledger_no != '')
                                    <td class="" style="padding: 3px !important" colspan="5">
                                        <div class="text-overlay">
                                            <b>Cash Receipt In :

                                                @if (!empty($ledger_no[0]->paymood))
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
                                                        @else
                                                            OTHERS : Tk {{ $value->pay_amount }} 
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </b>
                                            
                                            {{-- <div style="padding-top: 15px">
                                                <b>In Word :</b> {{ ucwords($in_words) }} Only
                                            </div> --}}
                                           

                                            <div style="padding-top: 25px;font-size:12px">
                                                <b>Billed By :</b>
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
                                                <br>
                                                 @if ($po_hospital_details->hospital_code != 'IMPALA')
                                                <div style="padding-top: 10px; word-wrap: break-word; ">
                                                    <strong>Remarks :
                                                    </strong>{{ $invoice_mst_info->invoice_remarks }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        <span class="overlay-text" style="float: right;">
                                            @if ($due == 0 && $refund == 0)
                                                <strong>PAID</strong>
                                            @elseif($due == 0 && $refund > 0)
                                                <strong>Refund</strong>
                                            @elseif($due > 0 && $refund == 0)
                                                <strong>DUE</strong>
                                            @endif
                                        </span>
                                    </td>
                                @else
                                    <td colspan="5"></td>
                                @endif

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>               
            @php
            $footerHide=session::get('user.ses_hospital_code')=="KPJ" ? 'display:none' :'';
            @endphp
            <footer style="font-size: 9px;<?= $footerHide ?>">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $date = date('h:i a'); // $dt->format('g:i A');
                ?>
                <span style="float:left;">

                    {{-- Prepared By: {{ Session::get('user.ses_user_name') }} --}}
                    Print: {{ Session::get('user.user_code') }} /  <span> {{ date('d-m-Y') }} / {{ $date }}</span>

                </span>

                <span style="float:right;"> Powered By: NEXTGEN IT</span>
            </footer>
        </div>
    </div>


    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor
