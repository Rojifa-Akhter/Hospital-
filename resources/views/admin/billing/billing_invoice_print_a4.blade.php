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
            border-top: 1px solid black;
            padding-top: 10px;
            z-index: 999999999;
        }

        table tr th{
            border: 0px;
            background-color: white;
            color: #222;
        }
        table tr td{
            border: 0px;
        }
        table{
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

        <table style="border:0px; border-top:1px solid #222; font-size:10px !important">
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left; width:70%">Prepared By:
                    {{ Session::get('user.ses_user_name')}} &nbsp;&nbsp; Printing Date & Time: {{ date('d/m/Y h:i:s a') }}</td>
                <td style="border: 0px; padding-top: 5px; width:30%">Powered By: [NEXTGEN]</td>
            </tr>
        </table>
    </footer>


    <main>
        <div class="" style=" margin: 2px 0px;">
            <div class="patient-information d-flex align-items-center">
                <div class=" text-center " style="padding: 3px !important; font-size: 15px">
                    Invoice
                </div>
                <table style="padding:10px;">
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="margin-top: 4px;"><b> Paitent ID :</b>&nbsp;<span>
                                            {{ $invoice_mst_info->patient_code }}</span></li>
                                    @if ($invoice_mst_info->admission_no_pk != '')
                                        <li style="margin-top: 4px;"><b> Admission ID
                                                :</b>&nbsp;<span>
                                                {{ $invoice_mst_info->admission_no_pk }}</span>
                                        </li>
                                    @endif
                                    <li style="margin-top: 4px;"><b>Paitent Name :</b>&nbsp;<span>
                                            {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                    </li>
                                    <li style="margin-top: 4px;">
                                        @php
                                        $pat_dob = new \DateTime($invoice_mst_info->dob);
                                        $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                        $interval = $invoice_date->diff($pat_dob);
                                    @endphp
                                        <b>Age:</b>&nbsp;<span>{{ isset( $interval)?$interval->format('%yY %mM %dD'):'' }}</span>
                                        <b>Gender :
                                        </b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : '' }}</span>,
                                        <b>Contact: </b>&nbsp;<span>
                                            {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                    </li>
                                    <li style="margin-top: 4px;">
                                        @if ($invoice_mst_info->email != '  ' && $invoice_mst_info->email != null)
                                        <b>Email: </b>&nbsp;<span>
                                            {{ !empty($invoice_mst_info->email) ? $invoice_mst_info->email : '' }}</span>
                                        @endif
                                    </li>


                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->present_addr != '  ' && $invoice_mst_info->present_addr != null)
                                            <b>Address: </b>&nbsp;<span>
                                                {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                            @endif
                                        </li>



                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->doctor_name != '')
                                            <b>Ref. Doctor:
                                            </b>&nbsp;<span>
                                                {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                            @endif
                                        </li>



                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->first_doc_name != ' ')
                                            <b>1st Ref:
                                            </b>&nbsp;<span>
                                                {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                            @endif
                                        </li>



                                        <li style="margin-top: 4px;">
                                            @if ($invoice_mst_info->second_doc_name != ' ')
                                            <b>2nd Ref:
                                            </b>&nbsp;<span>
                                                {{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
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
                                            <b>Disc. Request By:
                                            </b>&nbsp;<span>
                                                {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                            @endif
                                        </li>


                                </ul>

                            </td>
                            <td class="text-right" style="vertical-align: text-top;">

                                <ul style="list-style: none; padding-left: 0;">
                                    <li><i style="color: blue;"><b>Customer Copy</b></i></li>
                                    <li><b>Date of
                                            Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                    </li>
                                    <li><b>Invoice ID
                                            :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                    </li>
                                    <li>
                                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                            style="width: 120px; " />
                                    </li>
                                </ul>

                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <table class="table  mt-3" style="padding:10px">
            <thead style="">
                <tr>
                    <th class="text-left" style="width: 10px">SL#</th>
                    <th class="text-left">Item Description</th>
                    <th class="text-left" style="width: 50px">Delivery <br> Date</th>
                    <th class="text-left" style="width: 50px"></th>
                    <th class="text-right" style="width: 10px">Qty</th>
                    <th class="text-right" style="width: 50px">Amount <br>
                        (<small>BDT</small>)
                    </th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid #222!important; ">
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
                            <td class="text-left" style="padding: 3px !important;">
                                {{ $row->report_delivery_date == '1970-01-01 00:00:00' ? ' ' : date('d/m/Y', strtotime($row->report_delivery_date)) }}
                            </td>
                            @if ($row->delivery_status_lookup_no_fk == 1)
                                <td class=" text-left" style="padding: 3px !important;">
                                    {{-- Routine --}}
                                </td>
                                @php
                                    $item_rate = $row->item_rate;
                                @endphp
                            @elseif($row->delivery_status_lookup_no_fk == 2)
                                <td class=" text-left" style="padding: 3px !important;">
                                    Urgent
                                </td>
                                @php
                                    $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                    $item_rate = $row->item_rate + $urgent_fee;
                                @endphp
                            @else
                            @php
                                 $item_rate = $row->item_rate;
                            @endphp
                                <td></td>
                            @endif
                            <td class=" text-right" style="padding: 3px !important;">
                                {{ $row->item_qty }}</td>
                            <td class="text-right bg-light" style="padding: 3px !important;">
                                {{ number_format($row->item_qty * $item_rate, 2, '.', '') }}
                            </td>
                        </tr>

                        @php
                            $total += $row->item_qty * $item_rate;
                        @endphp
                    @endforeach
                @endif
                @php
                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                    $vat = number_format($invoice_mst_info->ledger_amt_vat, 2);
                    $discount = number_format($total_dis->ledger_amt_discount, 2, '.', '');
                    $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                    $urgent_fee = number_format($invoice_mst_info->urgent_fee, 2, '.', '');
                    $payable = number_format($total + $vat - $discount, 2, '.', '');
                    $due = number_format($total + $vat - $payment, 2, '.', '');
                    $due = $due - $discount;
                    $number = $total + $vat - $discount;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, $number);
                @endphp

            </tbody>


        </table>
        <table style="padding: 10px; margin:0px">
            <tr>
                @if (isset($ledger_no) && $ledger_no != '')
                    <td class="" rowspan="7" colspan="3" style="padding: 0px !important; text-align:left">
                        <div style="">
                            <span style="font-size: 30px; line-height: 1; border: 5px solid
                                #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px; ">

                                @if ($due == 0)
                                    <strong>PAID</strong>
                                @elseif($due < 0)
                                    <strong>Refund</strong>
                                @else
                                    <strong>DUE</strong>
                                @endif
                            </span>

                        </div>
                        <br>
                        <b>Cash Receipt In :</b>
                        @foreach ($ledger_no as $value)
                            @if ($value->paymood == 'CASH')
                                CASH :{{ $value->pay_amount }} ,
                            @elseif($value->paymood == 'Mbanking')
                                {{ strtoupper($value->pay_mood_type) }}
                                :{{ $value->pay_amount }} ,
                            @elseif($value->paymood == 'CARD')
                                {{ strtoupper('Card') }}
                                ({{ strtoupper($value->pay_mood_type) }}) :
                                {{ $value->pay_amount }} ,
                            @else
                                OTHERS : {{ $value->pay_amount }} ,
                            @endif
                        @endforeach
                        <div style="padding-top: 5px; word-wrap: break-word; ">
                           <span>  <b>In Word :</b> {{ ucwords($in_words) }} Taka Only</span>
                        </div>
                        <div style="padding-top: 5px; word-wrap: break-word; ">
                            <strong>Remarks : </strong>{{ $invoice_mst_info->invoice_remarks }}
                        </div>
                    </td>
                @else
                    <td rowspan="7" colspan="3" style="padding: 0px !important"></td>
                @endif

                <td class="text-right" colspan="2" style="padding: 0px !important">
                    <b>SUBTOTAL :</b>
                </td>
                <td class="text-right" style="padding: 0px !important">
                    {{ number_format($total + $vat, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2"><b>Urgent Fee :</b></td>
                <td class="text-right">
                    {{ number_format($invoice_mst_info->urgent_fee, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2" style="padding: 0px !important">
                    <b>Vat :</b>
                </td>
                <td class="text-right" style="padding: 0px !important">
                    {{ number_format($vat, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2" style="padding: 0px !important">
                    <b>Discount :</b>
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
            </tr>
        </table>
    </main>
</body>

</html>
