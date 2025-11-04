<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Invoice</title>
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
            font-size: 10px;
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
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
@endphp

<body>
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                <tr style="">
                    <td style="width: 15%; border-right:1px solid transparent!important">
                        @if ($po_hospital_details->logo != '')
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
                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                style="width: 90%;height:90%" alt="">
                        @endif
                    </td>
                </tr>
            @endif
        </table>
    </header>

    <footer style="border-top: 1px solid transparent; font-size:9px !important">

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

        <table style="border:0px; border-top:1px solid #222;">
            <?php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left;">
                    Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }},
                    Printed By: {{ Session::get('user.ses_user_name') }} &nbsp;&nbsp; Printing Date & Time:
                    {{ date('d/m/Y') }}
                    ,
                    {{ $date }}</td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
            </tr>
        </table>
    </footer>


    <main>
        <div class="" style=" margin: 2px 0px;">
            <div class="patient-information d-flex align-items-center">
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%"> <img style=""
                                src="data:image/png;base64, {{ $pat_barcode }} " style="width: 120px; " />
                            <br>
                            {{ $invoice_mst_info->patient_code }}
                        </td>
                        <td style="text-align: center"> Payment </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                style="width: 120px; " /> <br>
                            {{ $invoice_mst_info->invoice_code }}
                        </td>
                    </tr>
                </table>
                <table style="padding:10px;">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <div class="text-left" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><i style="color: blue;"><b>Customer Copy</b></i></li>
                                        <li style="margin-top: 4px;"><b>
                                                @php
                                                    if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                                        echo 'Customer Id:';
                                                    } else {
                                                        echo ' Patient ID :';
                                                    }
                                                @endphp

                                            </b>&nbsp;<span> {{ $invoice_mst_info->patient_code }}</span></li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                            <li style="margin-top: 4px;"><b> Admission ID :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->admission_no_pk }} (<strong>Bed/Ward : </strong>{{$invoice_mst_info->bed_name}} / {{$invoice_mst_info->ward_name}})</span></li>
                                        @endif
                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span> </li>
                                    
                                        <li style="margin-top: 4px;">
                                            <b>Age:</b>&nbsp;<span>{{ $invoice_mst_info->age == '' ? '' : $invoice_mst_info->age . ',' }}</span>
                                            <b>Gender :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                            <b>Contact: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>

                                        @if ($invoice_mst_info->present_addr != '' && $invoice_mst_info->present_addr != null)
                                            <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                    {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                            </li>
                                        @endif

                                        @if ($invoice_mst_info->doctor_name != '')
                                            <li style="margin-top: 4px;"><b>Ref. Doctor: </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                            </li>
                                        @endif

                                        @if ($invoice_mst_info->first_doc_name != ' ')
                                            <li style="margin-top: 4px;"><b>1st Ref:
                                                </b>&nbsp;<span>{{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                            </li>
                                        @endif

                                        @if ($invoice_mst_info->second_doc_name != ' ')
                                            <li style="margin-top: 4px;"><b>2nd Ref:
                                                </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                            </li>
                                        @endif

                                        @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                                            <li style="margin-top: 4px;">
                                                <b>Discount By: </b>&nbsp;<span>
                                                    {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                                    {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                                    {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}</span>
                                            </li>
                                        @endif

                                        @if ($ledgermst_paydisc->disc_amt_request_name != '')
                                            <li style="margin-top: 4px;"><b>Disc. Request By: </b>&nbsp;<span>
                                                    {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </td>
                            <td class="text-right" style="vertical-align: text-top;">
                                <div class="text-right" style="">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Date of
                                                Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
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

        <table class="table  mt-3" style="padding:10px">
            <thead>
                <tr>
                    <th class="text-left" style="width: 10px">SL#</th>
                    <th class="text-left">Item Description</th>
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
                        @endphp
                        <tr>
                            <td class="text-left " style="padding: 2px !important;">
                                {{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="text-left" style="padding: 2px !important;"> {{ $row->item_name }}
                                <br>
                                @if (!empty($exp_date))
                                    @foreach ($exp_date as $data)
                                        @if ($row->item_no_fk == $data->item_no_fk && $data->batch_no != '')
                                            <small>
                                                {{ $data->batch_no ? date('d-m-Y', strtotime($data->expiry_date)) . ',' : '' }}
                                            </small>
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            @php
                                $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                $item_rate = $row->item_rate + $urgent_fee;
                            @endphp


                            <td class=" text-right item_rate" style="padding: 2px !important;">
                                {{ number_format($item_rate, 2, '.', '') }}</td>
                            <td class=" text-right" style="padding: 2px !important;">{{ $row->item_qty }}</td>
                            <td class=" text-right" style="padding: 2px !important;">{{ $row->cancel_qty }}</td>
                            <td class="text-right bg-light" style="padding: 2px !important;">
                                {{ number_format($row->current_item_qty * $item_rate, 2, '.', '') }}</td>
                        </tr>
                        @php

                        @endphp
                    @endforeach
                @endif
                @php
                    // $totals = round($sub_total);
                    // // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                    // $total = $total_item_rates->ledger_amt_sales;
                    // $vat = number_format(0, 2, '.', '');
                    // $discount = number_format($c_discount->disc_amount, 2, '.', '');
                    // $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                    // $payable = number_format($totals - $discount, 2, '.', '');

                    // $cancel_amt = number_format($all_sub_total - $totals, 2, '.', '');
                    // $due = number_format($totals - $payment, 2, '.', '');
                    // $due = round($due - $discount - $cancel_amt);
                    // $number = number_format($totals - $discount, 2, '.', '');
                    // $locale = 'en_US';
                    // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    // $in_words = numfmt_format($fmt, $number);

                    $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                        // $totals = $sub_total + $vat + $urgent_fee;
                                        // $totals = $finc_inv_sum_amount->ledger_amt_sales ;
                                        $totals = $finc_inv_sum_amount->sales;

                                        // $discount = number_format($c_discount->disc_amount, 2, '.', '');

                                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                        $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');
                                        // $payment = number_format($finc_vouchermas_sum->collection, 2, '.', '');
                                        $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                        // $payable = number_format($totals - $discount, 2, '.', '');
                                        $payable_total = $totals - ($discount + $finc_inv_sum_amount->sales_cancel);
                                        $payable = number_format($payable_total, 2, '.', '');
                                        // $due = number_format($totals - $discount - $payment, 2, '.', '');
                                        $due = round(number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', ''));
                                        $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                        // $due = $due - $discount;
                                        // dd($due ,$payment ,  $payable ,  $totals );
                                        // $number = $totals - $discount;
                                        $number = $payable;
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $in_words = numfmt_format($fmt, $number);
                                        $to_date = date('Y-m-d');
                @endphp

            </tbody>

        </table>
        <table style="padding: 10px; margin:0px ; border-top:1px solid black">
            <tr>

                @if (!empty($paymood))
                    <td class="" rowspan="6" colspan="2" style="padding: 2px !important;">
                        <div style="margin-bottom: 5px; ">
                            <span style="font-size: 30px; line-height: 1; border: 5px solid
              #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                {{-- @if ($due == 0)
                                    <strong>PAID</strong>
                                @elseif($due < 0)
                                    <strong>Refund</strong>
                                @else
                                    <strong>DUE</strong>
                                @endif --}}

                                @if ($due == 0 && $refund == 0)
                                <strong>PAID</strong>
                            @elseif( $refund > 0)
                                <strong>Refund</strong><br>

                            @elseif($due > 0 && $refund == 0)
                                <strong>DUE</strong>
                            @endif
                            </span>
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

                        
                        <div style="padding-top: 5px"> 
                            @if (!empty($collector_info))
                                <b>Collector Information:</b>
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
                    @else
                    <td rowspan="6" colspan="2"></td>
                @endif


                </td>

                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>SUBTOTAL :</b></td>
                <td class="text-right" style="padding: 2px !important;">{{ number_format($totals, 2, '.', '') }}
                </td>
            </tr>
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
                    {{ number_format($finc_inv_collection_amount->collection, 2, '.', '') }}</td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Paid :</b></td>
                <td class="text-right" style="padding: 2px !important;">{{ number_format($payment, 2, '.', '') }}
                </td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;">
                    {{-- @if ($due >= 0)
                        <b>Due :</b>
                    @elseif($due < 0)
                        <b>Refund :</b>
                    @elseif($due == 0)
                        <b>Paid :</b>
                    @endif --}}

                    @if ($due >= 0 && $refund == 0)
                    <b>Due :</b>
                @elseif( $refund > 0)

                @if ($finc_inv_collection_amount->refund > 0)
                <b>Refund :</b> <br>
                @endif
                    <b>Total Refund :</b>
                @endif
                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{-- {{ number_format(abs($due), 2, '.', '') }} --}}
                    @if ($due >= 0 && $refund == 0)
                    {{ number_format($due, 2, '.', '') }}
                   @elseif( $refund > 0)

                   @if ($finc_inv_collection_amount->refund > 0)
                    {{    number_format(abs($finc_inv_collection_amount->refund ), 2, '.', '')}} <br>
                   @endif
                        {{ number_format(abs($refund), 2, '.', '') }}
                   @endif
                </td>
            </tr>
        </table>
            <span>Returns are only accepted within 14 days from the date of purchase.</span> <br>
            <span>A valid receipt of purchase is required for all returns or exchange.</span> <br>
            <span>Temperature sensitive medicines such as Vaccine, Insulin etc., opened tablets / Capsules, damaged or faulty products are not eligible for return or exchange.</span>
    </main>
</body>

</html>
