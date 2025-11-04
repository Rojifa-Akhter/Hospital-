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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
@php
$imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
$length = isset($po_hospital_details->due_cancel_fee_invoice_print) && $po_hospital_details->due_cancel_fee_invoice_print != '' ? $po_hospital_details->due_cancel_fee_invoice_print : 1;
@endphp
@for ($i = 0; $i < $length; $i++)

    <body>
        <!-- <header>

            <table style="width: 100%; border:5px solid transparent !important" class="signature">
                @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                    @if ($po_hospital_details->hospital_code != 'KBMH')
                        <tr style="">
                            <td style="width: 15%; border-right:1px solid transparent!important">
                                @if (!empty($po_hospital_details->logo))
                                    <img class="hospital-logo"
                                        src="{{ $imagePath }}"
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
                    @endif
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
        </header> -->
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
        </header>
        <footer style="border-top: 1px solid transparent;">


            <table style="border:0px; border-top:1px solid #222; font-size:9px !important">
                <?php

                date_default_timezone_set('Asia/Dhaka');
                $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
                ?>
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;padding-left:20px;">
                        Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }},
                        Printed By: {{ Session::get('user.ses_user_name') }} &nbsp;&nbsp; Printing Date & Time:
                        {{ $date }}
                    </td>
                    <td style="border: 0px; padding-top: 5px;padding-right:10px;">Powered By: NEXTGEN IT</td>
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
                            <td style="text-align: center"> Bill Cancel </td>
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
                                            <li><i style="color: blue;"><b>
                                                        @if ($i == 0)
                                                            Customer Copy
                                                        @elseif($i == 1)
                                                            Office Copy
                                                        @endif
                                                    </b></i></li>
                                            <li style="margin-top: 4px;"><b> Patient ID :</b>&nbsp;<span>
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
                                                <b>Gender :
                                                </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                                <b>Contact: </b>&nbsp;<span>
                                                    {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                            </li>

                                            @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                                <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                        {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                </li>
                                            @endif

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
                                            <li><b>Date of
                                                    Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                            </li>
                                            <li><b>TRX ID
                                                    :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                            </li>
                                            <li><b>Invoice ID
                                                    :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span> </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            <table class="table  mt-3" style="padding-left:10px; padding-right:10px; margin-top:-10px;">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 10px">SL#</th>
                        <th class="text-left">Item Description</th>
                        <th class="text-left" style="width: 50px">Delivery Date</th>
                        <th class="text-left" style="width: 40px"></th>
                        {{-- <th class="text-right" style="width: 50px">Rate</th> --}}
                        <th class="text-right" style="width: 10px">Qty</th>
                        <th class="text-right" style="width: 10px">Cx. <br> Qty</th>
                        <th class="text-right" style="width: 50px">Dis.</th>
                        <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)</th>
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
                                <td class="text-left " style="padding: 3px !important;">
                                    {{ sprintf('%02d', $loop->iteration) }}</td>
                                <td class="text-left" style="padding: 3px !important; "><span style="<?= $text_dec ?>">
                                        {{ $row->item_name }} </span></td>
                                <td class="text-left" style="padding: 3px !important;">
                                    {{ $row->report_delivery_date == '' ? ' ' : date('d/m/Y', strtotime($row->report_delivery_date)) }}

                                </td>


                                @if ($row->delivery_status_lookup_no_fk == 1)
                                    <td class=" text-left" style="padding: 3px !important;">

                                    </td>
                                    @php
                                        $item_rate = $row->item_rate_orig;
                                    @endphp
                                @elseif($row->delivery_status_lookup_no_fk == 2)
                                    <td class=" text-left" style="padding: 3px !important;width: 40px"> Urgent </td>
                                    @php
                                        $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                        $item_rate = $row->item_rate_orig + $urgent_fee;
                                    @endphp
                                @else
                                    <td></td>
                                    @php
                                        $item_rate = $row->item_rate_orig;
                                    @endphp
                                @endif
                                {{-- <td class=" text-right item_rate" style="padding: 3px !important;">
                                    {{ number_format($item_rate, 2, '.', '') }}</td> --}}
                                <td class=" text-right" style="padding: 3px !important;">{{ $row->item_qty }}</td>
                                <td class=" text-right" style="padding: 3px !important;">{{ $row->cancel_qty }}</td>
                                <td class=" text-right" style="padding: 3px !important;">
                                    {{ number_format($row->disc_amount, 2, '.', '') }}</td>
                                <td class="text-right bg-light" style="padding: 3px !important;">
                                    <span style="<?= $text_dec ?>">
                                        {{ number_format($row->item_qty * $item_rate, 2, '.', '') }} </span>
                                </td>
                            </tr>
                            @php
                                //   $total_vat += $row->item_vat;
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
                        // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                        // $calcel_discount = $c_dis_cancelation->disc_amount;
                        // $vat = number_format(0, 2, '.', '');
                        // $discount = number_format($invoice_mst_info->ledger_amt_discount, 2, '.', '');
                        // $payment = number_format($invoice_mst_info->ledger_amt_payment, 2, '.', '');
                        // $urgent_fee = number_format($invoice_mst_info->urgent_fee, 2, '.', '');
                        // $payable = number_format($total - $discount, 2, '.', '');
                        // $due = number_format($total - $payment, 2, '.', '');
                        // $due = $due - $discount;
                        // $number = $total - $discount;
                        // $locale = 'en_US';
                        // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        // $total_dis = $invoice_mst_info->ledger_amt_discount;
                        // $total_amt = $total_item_rate;
                        // $net_payable = number_format($total_amt - ($total + $c_discount->disc_amount - $calcel_discount), 2, '.', '');
                        // $paid_amount = number_format($finc_vouchermas_sum->collection, 2, '.', '');
                        // $due_refund = number_format($net_payable - $paid_amount, 2, '.', '');
                        $service_charge = number_format($service_charges, 2, '.', '');
                        $sales_cancel = !empty($finc_inv_sum_amount->sales_cancel) ? $finc_inv_sum_amount->sales_cancel : 0;
                        $calcel_discount = !empty($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;

                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                        $payment = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                        $payable = number_format($total - $discount, 2, '.', '');
                        $due = number_format($payable - $payment, 2, '.', '');
                        $number = $total - $discount;
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $total = $finc_inv_sum_amount->sales - $service_charges;
                        $total_amt = $finc_inv_sum_amount->sales;
                        // $total_dis = $invoice_mst_info->ledger_amt_discount ? $invoice_mst_info->ledger_amt_discount : 0;
                        $net_payable = number_format($total_amt - $discount - $sales_cancel, 2, '.', '');
                        // dd( $total_amt , $service_charge ,  $discount , $sales_cancel);
                        // number_format($total_amt - ($total - $discount), 2, '.', '');

                        $paid_amount = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                        $due_refund = number_format($net_payable - $paid_amount, 2, '.', '');
                        if ($due_refund <= 0) {
                            $in_words = numfmt_format($fmt, abs($net_payable));
                        } else {
                            $in_words = numfmt_format($fmt, $net_payable);
                        }
                        $to_date = date('Y-m-d');
                    @endphp

                </tbody>


            </table>
            <table style="padding: 10px; margin:0px; border-top:1px solid black">
                <tr>


                    <td rowspan="7" colspan="4" style="padding: 2px !important; text-align:left">
                        <div style="margin-bottom: 5px">
                            <span
                                style="font-size: 30px !important; line-height: 1; border: 5px solid
              #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                @if ($due_refund < 0)
                                    <strong>Refund</strong>
                                @elseif($due_refund == 0)
                                    <strong>Paid</strong>
                                @else
                                    <strong>DUE</strong>
                                @endif

                            </span>
                            <div style="margin-top: 10px !important">
                            @if(!empty($return_reson))
                               <strong> Return Reason : </strong> {{$return_reson->refund_reason}} <br>
                            @endif
                                <strong>Remarks : </strong>{{$invoice_mst_info->invoice_remarks}} <br>
                                <strong> Report Delivery Date :
                                    {{ $invoice_mst_info->report_delivary_date != '' ? date('d/m/Y', strtotime($invoice_mst_info->report_delivary_date)) : date('d/m/Y', strtotime("$to_date + 1 day")) }}
                                    {{ $invoice_mst_info->report_delivary_datetime != '' ? date('H:i a', strtotime($invoice_mst_info->report_delivary_datetime)) : '' }}</strong>
                                    
                            </div>
                        </div> <br>
                        <b>In Word :</b> {{ strtoupper($in_words) }} TAKA ONLY


                    </td>

                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Item Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($total, 2, '.', '') }}</td>
                </tr>

                <tr>

                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Cancel Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($sales_cancel, 2, '.', '') }}
                    </td>
                </tr>
                <tr>

                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>(-) Discount :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($calcel_discount, 2, '.', '') }}
                    </td>
                </tr>

                <tr>

                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Cancel Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>

                </tr>

                <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Discounted Amt :</b>
                    </td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($discount, 2, '.', '') }}</td>
                </tr>

                <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Payable :</b></td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ $net_payable }}
                    </td>
                </tr>

                <tr>
                    <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Paid Amt :</b></td>
                    <td class="text-right" style="padding: 2px !important;">
                        {{ number_format($paid_amount, 2, '.', '') }}</td>
                </tr>

                <tr>
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
                </tr>
            </table>
        </main>
    </body>
    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor

</html>
