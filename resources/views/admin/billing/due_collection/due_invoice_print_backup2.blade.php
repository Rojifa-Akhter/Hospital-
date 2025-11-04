@php
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
// dd( $hospital);
$body_font_size = $po_hospital_details->hospital_code == 'KBMH' ? 10 : 12;
@endphp
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
            margin-bottom: 0.9cm;
            font-family: 'Roboto', sans-serif;
            font-size: <?=$body_font_size ?>px !important;
            padding-left: .5cm;
            padding-right: .5cm;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.8cm;
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
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$length = isset($po_hospital_details->due_cancel_fee_invoice_print) && $po_hospital_details->due_cancel_fee_invoice_print !="" ? $po_hospital_details->due_cancel_fee_invoice_print : 1;

@endphp

@for ($i = 0; $i < $length; $i++)
<body>

    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
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

        </table>
    </header>

    <footer style="border-top: 1px solid transparent;">
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

        <table style="border:0px; border-top:1px solid #222; font-size:9px !important;">
            <?php
            // $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            // $date = $dt->format('g:i A');
            date_default_timezone_set('Asia/Dhaka');
            $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; padding-left:20px">
                    Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }},
                    Printed By: {{ Session::get('user.ses_user_name') }} &nbsp;&nbsp; Printing Date & Time:
                    {{ $date }}</td>
                <td style="border: 0px; padding-top: 5px; padding-right:20px">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
        <div class="" style=" margin: 2px 0px;">
            <div class="patient-information d-flex align-items-center">
                {{-- <div class=" text-center " style="padding: 3px !important; font-size: 15px"> --}}
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%"> <img style=""
                                src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                            <br>
                            {{ $invoice_mst_info->patient_code }}
                        </td>
                        <td style="text-align: center">
                            @if ($po_hospital_details->hospital_code == 'GMC')
                                <div>Investigation</div>
                                <div>Payment</div>
                            @else
                                Payment
                            @endif
                        </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                style="width: 120px; " /> <br>
                            {{ $invoice_mst_info->invoice_code }}
                        </td>
                    </tr>
                </table>
                {{-- </div> --}}
                <table style="">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <div class="text-left" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><i style="color: blue;"><b>@if ($i == 0 ) Customer Copy @elseif($i==1) Office Copy @endif </b></i></li>
                                        <li style="margin-top: 4px;"><b> Patient ID :</b>&nbsp;<span>
                                                {{ $invoice_mst_info->patient_code }}</span></li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                            <li style="margin-top: 4px;"><b> Admission ID :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->admission_no_pk }}</span></li>
                                        @endif
                                        <!-- <li>
                                  <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                                </li> -->
                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span> </li>

                                        <li style="margin-top: 4px;">
                                            <b>Age:</b>&nbsp;<span>{{ $invoice_mst_info->age == '' ? '' : $invoice_mst_info->age . ',' }}</span>
                                            <b>Gender :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                            <b>Contact: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>


                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->present_addr != '  ' && $invoice_mst_info->present_addr != null)
                                                <b>Address: </b>&nbsp;<span>
                                                    {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                            @endif
                                        </li>


                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->doctor_name != '')
                                                @if ($po_hospital_details->hospital_code == 'GMC')
                                                    <b>Consultant/Doctor: </b>&nbsp;<span>
                                                    @else
                                                        <b>Ref. Doctor: </b>&nbsp;<span>
                                                @endif

                                                {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                            @endif
                                        </li>

                                        <li style="margin-top: 4px;">
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
                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->second_doc_name != ' ')
                                                <b>2nd Ref:
                                                </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                            @endif
                                        </li>



                                        <li style="margin-top: 4px;">
                                            @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                                                <b>Discount By: </b>&nbsp;<span>
                                                    {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                                    {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                                    {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
                                            @endif
                                        </li>



                                        <li style="margin-top: 4px;">
                                            @if ($ledgermst_paydisc->disc_amt_request_name != '')
                                                <b>Disc. Request By: </b>&nbsp;<span>
                                                    {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                            @endif
                                        </li>


                                    </ul>
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: text-top;">
                                <div class="text-right" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li style="color: red"><strong> <i> Duplicate </i></strong> </li>
                                        <li><b>Date of Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->invoice_date)) }}</span>
                                        </li>
                                        <li><b>Invoice ID
                                                :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span> </li>


                                        <!-- <li><i style="color: blue;"><b>Duplicate Copy</b></i> </li> -->
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <table class="table  mt-3" style="padding-left:10px; padding-right:10px; margin-top:-10px; ">
            <thead style="">
                <tr>
                    <th class="text-left" style="width: 10px">SL#</th>
                    <th class="text-left">Item Description</th>
                    <th class="text-left" style="width: 50px">Delivery <br> Date</th>
                    <th class="text-left" style="width: 35px"></th>
                    <th class="text-right" style="width: 50px">Rate</th>
                    <th class="text-right" style="width: 10px">Qty</th>
                    <th class="text-right" style="width: 10px">Cx.<br> Qty</th>
                    <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)</th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid #222!important; ">
                @php
                    $totals = 0;
                @endphp

                @if (!empty($invoice_dtls_info))
                    @foreach ($invoice_dtls_info as $row)
                        @php
                            $urgent_fee = 0;
                            $text_dec = $row->item_qty == $row->cancel_qty ? 'text-decoration: line-through; ' : '';
                        @endphp
                        <tr>
                            <td class="text-left " style="padding: 2px !important;">
                                {{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="text-left" style="padding: 2px !important; <?= $text_dec ?>">
                                {{ $row->item_name }}</td>
                            <td class="text-left" style="padding: 2px !important;">
                                {{ $row->report_delivery_date == '' ? '' : date('d/m/Y', strtotime($row->report_delivery_date)) }}
                            </td>


                            @if ($row->delivery_status_lookup_no_fk == 1)
                                <td class=" text-left" style="padding: 2px !important;">
                                    {{-- Routine --}}
                                </td>
                                @php
                                    $item_rate = $row->item_rate;
                                @endphp
                            @elseif($row->delivery_status_lookup_no_fk == 2)
                                <td class=" text-left" style="padding: 2px !important; width: 35px"> Urgent </td>
                                @php
                                    $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                    $item_rate = $row->item_rate + $urgent_fee;
                                @endphp
                            @else
                                <td></td>
                                <!-- @php
                                    $item_rate = $row->item_rate;
                                @endphp -->
                            @endif

                            <td class=" text-right item_rate" style="padding: 2px !important;">
                                {{ number_format($item_rate, 2, '.', '') }}</td>
                            <td class=" text-right" style="padding: 2px !important;">{{ $row->item_qty }}</td>
                            <td class=" text-right" style="padding: 2px !important;">{{ $row->cancel_qty }}</td>
                            <td class="text-right bg-light" style="padding: 2px !important;">
                                {{ number_format($row->item_qty * $item_rate, 2, '.', '') }}</td>
                        </tr>
                        @php

                        @endphp
                    @endforeach
                @endif
                @php

                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                    // $total = $total_item_rates->ledger_amt_sales;
                    $vat = 0;//number_format($invoice_mst_info->ledger_amt_vat, 2, '.', '');
                    $urgent_fee = 0;//number_format($invoice_mst_info->urgent_fee, 2, '.', '');
                    $totals = $sub_total + $vat + $urgent_fee;
                    $discount = number_format($c_discount->disc_amount, 2, '.', '');
                    // $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                    $payment = number_format($finc_vouchermas_sum->collection, 2, '.', '');
                    $payable = number_format($totals - $discount, 2, '.', '');
                    $due = number_format($totals - $discount - $payment, 2, '.', '');
                    // $due = $due - $discount;
                    // dd($due ,$payment ,  $payable ,  $totals );
                    $number = $totals - $discount;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, $number);
                    $to_date = date('Y-m-d');
                @endphp

            </tbody>


        </table>
        <table style="padding: 10px; margin:0px; border-top:1px solid black">
            <tr>

                @if (!empty($paymood))
                    <td class="" rowspan="8" colspan="4" style="padding: 2px !important; text-align:left">
                        <div style="margin-bottom: 5px; ">
                            <span style="font-size: 30px !important; line-height: 1; border: 5px solid
                   #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                @if ($due == 0)
                                    <strong>PAID</strong>
                                @elseif($due < 0)
                                    <strong>Refund</strong>
                                @else
                                    <strong>DUE</strong>
                                @endif
                            </span>

                            <div style="margin-top: 10px !important">

                                @if ($po_hospital_details->hospital_code == 'GMC')

                                @else
                                <strong> Report Delivery Date :
                                    {{ $invoice_mst_info->report_delivary_date != '' ? date('d/m/Y', strtotime($invoice_mst_info->report_delivary_date)) : date('d/m/Y', strtotime("$invoice_mst_info->invoice_date + 1 day")) }}
                                    {{ $invoice_mst_info->report_delivary_datetime != '' ? date('H:i a', strtotime($invoice_mst_info->report_delivary_datetime)) : '' }}</strong>
                                @endif


                                 </div>
                            </div>
                            <br>
                            <b>Cash Receipt In :</b>

                            @foreach ($paymood as $value)
                                @if ($value->paymood == 'CASH')
                                    CASH :{{ $value->pay_amount }} ,
                                @elseif($value->paymood == 'Mbanking')
                                    {{ strtoupper($value->pay_mood_type) }} :{{ $value->pay_amount }} ,
                                @elseif($value->paymood == 'CARD')
                                    {{ strtoupper('Card') }} ({{ strtoupper($value->pay_mood_type) }}) :
                                    {{ $value->pay_amount }} ,
                                @else
                                    OTHERS : {{ $value->pay_amount }} ,
                                @endif
                            @endforeach
                            <div style="padding-top: 5px">
                                <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                            </div>
                            @if ($po_hospital_details->hospital_code != 'IMPALA')
                            <div style="padding-top: 5px; word-wrap: break-word; ">
                                <strong> {{$invoice_mst_info->invoice_remarks !="" ? "Remarks :" : ""}}  </strong>{{ $invoice_mst_info->invoice_remarks }}
                            </div>
                        @endif
                    </td>
                @else
                    <td rowspan="8" colspan="4"></td>
                @endif




                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Subtotal :</b></td>
                <td class="text-right" style="padding: 2px !important;">{{ number_format($totals, 2, '.', '') }}
                </td>
            </tr>
            @if ($urgent_fee != 0)
                <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Urgent fee :</b></td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($urgent_fee, 2, '.', '') }}
                    </td>
                </tr>
            @endif
            @if ($vat != 0)
                <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Vat :</b></td>
                    <td class="text-right" style="padding: 2px !important;">{{ number_format($vat, 2, '.', '') }}
                    </td>
                </tr>
            @endif

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Discount :</b></td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($discount, 2, '.', '') }}
                </td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Bill Amount :</b></td>
                <td class="text-right" style="padding: 2px !important;">{{ number_format($payable, 2, '.', '') }}
                </td>
            </tr>

            <tr>

                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Payment :</b></td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($ledger_pay_amount->pay_amount, 2, '.', '') }}</td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Paid :</b></td>
                <td class="text-right" style="padding: 2px !important;">{{ number_format($payment, 2, '.', '') }}
                </td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;">
                    @if ($due >= 0)
                        <b>Due :</b>
                    @elseif($due < 0)
                        <b>Refund :</b>
                    @elseif($due == 0)
                        <b>Paid :</b>
                    @endif
                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format(abs($due), 2, '.', '') }}
                </td>
            </tr>
        </table>
    </main>
</body>
@if ($length > 1 && $i !=($length-1) )
<div class="page-break"></div>
@endif
@endfor


</html>
