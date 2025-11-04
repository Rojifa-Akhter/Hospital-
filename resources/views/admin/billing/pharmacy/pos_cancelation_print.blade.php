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
                        @if ($po_hospital_details->report_header_image !="")
                        <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                        width="250px" alt="">
                        @endif

                    </td>
                </tr>
            @endif
        </table>
    </header>

    <footer style="border-top: 1px solid transparent; font-size:9px !important">


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
                    , {{ $date }}</td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
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
                        <td style="text-align: center"> Bill Cancel </td>
                        <td style="text-align: right" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                style="width: 120px; " /> <br>
                            {{ $invoice_mst_info->invoice_code }}
                        </td>
                    </tr>
                </table>

                {{-- </div> --}}
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
                                                        echo 'Patient ID :';
                                                    }
                                                @endphp

                                            </b>&nbsp;<span> {{ $invoice_mst_info->patient_code }}</span></li>
                                        <!-- <li>
                                  <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                                </li> -->
                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                {{ ucwords($invoice_mst_info->patient_name) }}</span> </li>
                                        @if ($invoice_mst_info->admission_no_pk != '')
                                            <li style="margin-top: 4px;"><b>Admission ID :</b>&nbsp;<span>
                                                    {{ $invoice_mst_info->admission_no_pk }}</span>
                                            </li>
                                        @endif

                                        <li style="margin-top: 4px;">
                                            <b>Age:</b>&nbsp;<span>{{ $invoice_mst_info->age == '' ? '' : $invoice_mst_info->age . ',' }}</span>
                                            <b>Gender :
                                            </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                            <b>Contact: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                        </li>

                                        @if ($invoice_mst_info->present_addr != '  ' && $invoice_mst_info->present_addr != null)
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
                                        <li><b>TRX. No
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

        <table class="table  mt-3" style="padding:10px">
            <thead>
                <tr>
                    <th class="text-left" style="width: 10px">SL#</th>
                    <th class="text-left">Item Description</th>
                    <th class="text-left" style="width: 100px">Expire Date</th>
                    <th class="text-right" style="width: 50px">Rate</th>
                    <th class="text-right" style="width: 10px">Qty</th>
                    <th class="text-right" style="width: 10px">Cx. <br> Qty</th>
                    <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)</th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid #222!important; ">

                @php
                    $total = 0;
                    $total_item_rate = 0;
                    $cancel_dic = 0;
                @endphp
                @if (!empty($invoice_dtls_info))

                    @foreach ($invoice_dtls_info as $row)
                        @php
                            $urgent_fee = 0;
                            $item_rate = 0;
                            $cancel_fee = 0;
                            $total_item_rate_cancel = 0;
                        @endphp
                        <tr>
                            <td class="text-left " style="padding: 3px !important;">
                                {{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="text-left" style="padding: 3px !important;"> {{ $row->item_name }}
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
                            <td class="text-left" style="padding: 3px !important;"> </td>


                            <!-- <td></td> -->
                            @php
                                $item_rate = $row->item_rate;
                                $total_item_rate_cancel = number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '');
                                //number_format(($row->item_qty  - $row->cancel_qty)*$item_rate,2,".","");
                            @endphp

                            <td class=" text-right item_rate" style="padding: 3px !important;">
                                {{ number_format($item_rate, 2, '.', '') }}</td>
                            <td class=" text-right" style="padding: 3px !important;">{{ $row->item_qty }}</td>
                            <td class=" text-right" style="padding: 3px !important;">{{ $row->cancel_qty }}</td>
                            <td class="text-right bg-light" style="padding: 3px !important;">
                                {{ number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '') }}
                            </td>
                        </tr>
                        @php
                            // $total_item_rate += $total_item_rate_cancel;
                            // $cancel_dic += ($row->cancel_qty * $item_rate * $row->disc_perc) / 100;
                            // $cancel_fee += $row->cancel_qty * $row->urgent_fee;
                            $total += $row->cancel_qty * $item_rate + $row->cancel_qty * $row->item_vat;
                            $total_item_rate += $row->item_qty * ($item_rate + $row->item_vat);
                        @endphp
                    @endforeach
                @endif
                @php

                    $total_item_rate = round($total_item_rate);
                    $sales_cancel = !empty($finc_inv_sum_amount->sales_cancel) ? $finc_inv_sum_amount->sales_cancel : 0;
                    $calcel_discount = !empty($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;
                    $vat = number_format(0, 2, '.', '');
                    $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                    $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                    $payment = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                    $payable = number_format($total - $discount, 2, '.', '');
                    // dd($payable ,$total, $discount);
                    $due = number_format($payable - $payment, 2, '.', '');
                    $number = $total - $discount;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $total_amt = round($total_item_rate);
                    // dd($total_amt);
                    // $total_dis = $invoice_mst_info->ledger_amt_discount ? $invoice_mst_info->ledger_amt_discount : 0;
                    // $net_payable = number_format($total_amt - ($total + $discount), 2, '.', '');
                    $net_payable =number_format(($total_amt - $discount) - $sales_cancel, 2, '.', '');
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
        <table style="padding: 10px; margin:0px ; border-top:1px solid black">
            <tr>


                <td rowspan="7" colspan="3" style="padding: 2px !important;">
                    <div style="margin-bottom: 5px">
                        <span
                            style="font-size: 30px; line-height: 1; border: 5px solid
                    #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                            {{-- @if ($due_refund < 0)
                                <strong>Refund</strong>
                            @elseif($due_refund == 0)
                                <strong>Paid</strong>
                            @else
                                <strong>DUE</strong>
                            @endif --}}
                            @if ($due_refund < 0)
                                <strong>Refund</strong>
                            @elseif($due_refund == 0)
                                <strong>Paid</strong>
                            @else
                                <strong>DUE</strong>
                            @endif

                        </span>
                    </div> <br>
                    <b>In Word :</b> {{ strtoupper($in_words) }} TAKA ONLY


                </td>

                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Item Amount :</b>
                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($total_item_rate, 2, '.', '') }}</td>
            </tr>
            <tr>

                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total Cancel Amount :</b>
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

                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Cancel Amount :</b>
                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Discounted Amount :</b>
                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($discount, 2, '.', '') }}</td>
            </tr>

            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net Payable :</b></td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($net_payable, 2, '.', '') }}
            </tr>
            <tr>
                <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Paid Amount :</b></td>
                <td class="text-right" style="padding: 2px !important;">
                    {{ number_format($paid_amount, 2, '.', '') }}</td>
            </tr>

            <tr>
                <td class="text-right" colspan="6" style="padding: 2px !important;">
                    {{-- @if ($due_refund < 0)
                        <b>Refund :</b>
                    @elseif($due_refund >= 0)
                        <b> Due :</b>
                    @endif --}}
                    @if ($due_refund < 0)
                        <b>Cash Refund :</b>
                        <br> <b>Total Refund :</b>
                    @elseif($due_refund >= 0)
                        <b> Due :</b>
                    @endif

                </td>
                <td class="text-right" style="padding: 2px !important;">
                    {{-- {{ number_format(abs($due_refund), 2, '.', '') }}</td> --}}
                    @if ($due_refund < 0)
                        {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }}
                        <br>
                        {{ number_format(abs($due_refund), 2, '.', '') }}
                    @elseif($due_refund >= 0)
                        {{ number_format(abs($due_refund), 2, '.', '') }}
                    @endif
            </tr>
        </table>
            <span>Returns are only accepted within 14 days from the date of purchase.</span> <br>
            <span>A valid receipt of purchase is required for all returns or exchange.</span> <br>
            <span>Temperature sensitive medicines such as Vaccine, Insulin etc., opened tablets / Capsules, damaged or faulty products are not eligible for return or exchange.</span>
    </main>
</body>

</html>
