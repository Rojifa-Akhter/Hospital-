@php 
$footer_height= $po_hospital_details->hospital_code == 'DMHL' ? 3.6 :3;
@endphp
<style>
    .custom_inline_input {
        border: 0px;
        outline: 0;
        background-color: transparent;
        border-bottom: 1px dotted #222;
        /*display: block;*/
    }

    .custom_inline_input2 {
        width: 465px;
    }

    .w-30 {
        width: 30%
    }

    .w-50px {
        width: 50px
    }

    .w-100px {
        width: 100px
    }

    .v-align-top {
        vertical-align: top !important;
    }

    table tr {
        border-bottom: none;
    }

    .instraction-page>ul>li {
        margin-bottom: 20px;
    }
</style>


<style>
    /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
    @page {
        margin-top: 10px;
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
        height: <?= $footer_height ?>cm !important;
        text-align: center;
        font-size: 9px;
        bottom: -125px;
        border-top: 1px solid black;
        /* padding-top: 10px; */
    }

    body {
        margin-top: 10px;
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 10px;
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

    .custom_inline_input {
        border: 0px;
        outline: 0;
        background-color: transparent;
        border-bottom: 1px dotted #222;
    }


    .border-0 {
        border: 0px;
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

    .w-100 {
        width: 100%;
    }

    .w-5 {
        width: 5%;
    }

    .w-10 {
        width: 10%;
    }

    .w-15 {
        width: 15%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-50 {
        width: 50%;
    }

    .w-100 {
        width: 100%;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .mt-5 {
        margin-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-15 {
        margin-bottom: 15px;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .pb-0 {
        padding-bottom: 0;
    }

    #logo img {

        width: 70px;
    }

    .logo {
        width: 80px;
        display: inline-block;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address {
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact {
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info {
        margin-left: 10px;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .title {
        /*background-color: #444;*/
        /*display: inline-block;*/
        font-size: 14px;
        color: #000;
        padding: 5px 50px;
        border-radius: 3px;
        /*font-weight: bold;*/
    }

    .form-heading .title-name {
        font-size: 1.35rem;
        line-height: 1;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .form-heading h5 {
        font-size: 1rem;
        /*line-height: 1;*/
        margin-top: -10px;
        font-weight: 400;
    }

    .form-heading p {
        font-size: .8rem;
        margin-top: -10px;
    }

    .form-name {
        font-size: 16px;
    }

    .float-left {
        float: left;
    }

    .float-right {
        float: right;
    }

    .d-block {
        display: block;
    }

    .d-inline-block {
        display: inline-block;
    }

    .border-1 {
        border: 1px solid;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .signature {
        width: 100%;
        height: 30px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .border-right {
        border-right: 1px solid #222;
    }

    .form-check-inline {
        display: inline-block;
        align-items: center;
        padding-left: 0;
        margin-right: 0.2rem;
    }

    .form-check {
        position: relative;
    }

    .form-check-inline .form-check-input {
        position: static;
        margin-top: 5px;
        /*margin-right: 0.3125rem;*/
        margin-left: 0;
    }

    input[type=radio],
    input[type=checkbox] {
        box-sizing: border-box;
        padding: 0;
    }

    .v-align-top {
        vertical-align: top;
    }

    .table td,
    .table th {
        padding: 5px !important;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
    }

    .page-break {
        page-break-after: always;
    }
</style>

@php
    $length = isset($po_hospital_details->consultation_invoice_print) && $po_hospital_details->consultation_invoice_print != '' ? $po_hospital_details->consultation_invoice_print : 1;
    $imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
    $imagePathImpala = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/' . $po_hospital_details->logo : 'images/kbmh.jpg';

@endphp
@for ($i = 0; $i < $length; $i++)
    <div class="container-fluid">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
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
                                                    style="width: 100%;height:90%">
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
                                        <td style="text-align: center">
                                            @if ($po_hospital_details->hospital_code == 'GMC')
                                                <div>Consultation</div>
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
                                <div class="patient-information d-flex align-items-center">
                                    <table style="">
                                        <tr>
                                            <td class="text-left">
                                                <div class="text-left" style="">
                                                    <ul style="list-style: none; padding-left: 0;">

                                                        <li style="margin-top: 4px;"><b> UHID :</b>&nbsp;<span>
                                                                {{ $invoice_mst_info->patient_code }}</span></li>

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
                                                            <b>Contact: </b><span>
                                                                {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span>
                                                        </li>

                                                        @if ($invoice_mst_info->present_addr != '  ' && $invoice_mst_info->present_addr != null)
                                                            <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                                    {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                            </li>
                                                        @endif

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
                                                            @if ($invoice_mst_info->doc_serviceunit_name != '')
                                                                <b>Department: </b>&nbsp;<span>

                                                                    {{ $invoice_mst_info->doc_serviceunit_name != '' ? ucwords($invoice_mst_info->doc_serviceunit_name) : '' }}</span>
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
                                                            <li style="margin-top: 4px;"><b>Disc. Request By:
                                                                </b>&nbsp;<span>
                                                                    {{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}</span>
                                                            </li>
                                                        @endif
                                                        @if ($appoint_type != '')
                                                            <li style="margin-top: 4px;"><b>Appointment type:
                                                                </b>&nbsp;<span>
                                                                    {{ isset($appoint_type) ? $appoint_type : '' }}</span>
                                                            </li>
                                                        @endif

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
                                                        <li><b>
                                                                Date &
                                                                Time:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                                        </li>
                                                        <li><b>TRX ID
                                                                :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                                        </li>
                                                        <li><b>Invoice ID
                                                                :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                                        </li>
                                                        <li><b>Dr. ID
                                                                :</b>&nbsp;<span>{{ isset($invoice_mst_info->doc_person_code) ? $invoice_mst_info->doc_person_code : '' }}</span>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-body" style="margin-top: 2px">
                                <table class="table  mt-3">
                                    <thead>
                                        <tr>
                                            <th class="text-left" style="width: 10px">SL#</th>
                                            <th class="text-left">Item Description</th>
                                            <th class="text-right" style="width: 50px">Rate</th>
                                            <th class="text-right" style="width: 10px">Qty</th>
                                            <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)
                                            </th>
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
                                                        {{ $row->item_code }}- {{ $row->item_name }}</td>

                                                    @php
                                                        $item_rate = $row->item_rate;
                                                    @endphp

                                                    <td class=" text-right item_rate" style="padding: 3px !important;">
                                                        {{ number_format($item_rate, 2, '.', '') }}</td>
                                                    <td class=" text-right" style="padding: 3px !important;">
                                                        {{ $row->item_qty }}</td>
                                                    <td class="text-right bg-light" style="padding: 3px !important;">
                                                        {{ number_format($row->item_qty * $item_rate, 2, '.', '') }}
                                                    </td>
                                                </tr>

                                                @php
                                                    // $total = $sub_total != null ? $sub_total : 0; //($row->item_qty*$item_rate);
                                                @endphp
                                            @endforeach
                                        @endif
                                        @php
                                            // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                                            $vat = number_format(0, 2, '.', '');
                                            $total = $finc_inv_sum_amount->sales;

                                            // $discount = number_format($total_dis->ledger_amt_discount, 2, '.', '');
                                            $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                            // $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                                            $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                            //  dd($total);
                                            $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                            // $payable = number_format($total - $discount, 2, '.', '');
                                            $payable = number_format($finc_inv_sum_amount->net_sales, 2, '.', '');
                                            // $due = number_format($total - $payment, 2, '.', '');
                                            $due = number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', '');
                                            $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                            // $due = $due - $discount;
                                            $number = $total - $discount;
                                            $locale = 'en_US';
                                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                            $in_words = numfmt_format($fmt, $number);
                                        @endphp
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            @if (isset($ledger_no) && $ledger_no != '')
                                                <td class="" rowspan="5" colspan="2"
                                                    style="padding: 3px !important">
                                                    <div style="margin-bottom: 5px">
                                                        <span
                                                            style="font-size: 30px; line-height: 1; border: 5px solid
                                                             #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px; ">

                                                            @if ($due == 0 && $refund == 0)
                                                                <strong>PAID</strong>
                                                            @elseif($due == 0 && $refund > 0)
                                                                <strong>Refund</strong>
                                                            @elseif($due > 0 && $refund == 0)
                                                                <strong>DUE</strong>
                                                            @endif

                                                        </span>
                                                    </div>
                                                    <br>
                                                    <b>Cash Receipt In :</b>

                                                    @if (!empty($ledger_no[0]->paymood))
                                                        @foreach ($ledger_no as $value)
                                                            @if ($value->paymood == 'CASH')
                                                                CASH :{{ $value->pay_amount }} ,
                                                            @elseif($value->paymood == 'Mbanking')
                                                                {{ strtoupper($value->pay_mood_type) }}
                                                                :{{ $value->pay_amount }} ,
                                                            @elseif($value->paymood == 'CARD')
                                                                {{ strtoupper('Card') }}
                                                                ({{ strtoupper($value->pay_mood_type) }})
                                                                :
                                                                {{ $value->pay_amount }} ,
                                                            @else
                                                                OTHERS : {{ $value->pay_amount }} ,
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        CASH :{{ number_format($payment, 2, '.', '') }}
                                                    @endif
                                                    <div style="padding-top: 5px">
                                                        <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                                    </div>
                                                    @if ($po_hospital_details->hospital_code != 'IMPALA')
                                                        <div style="padding-top: 5px; word-wrap: break-word; ">
                                                            <strong>Remarks :
                                                            </strong>{{ $invoice_mst_info->invoice_remarks }}
                                                        </div>
                                                    @endif

                                                    <div style="padding-top: 5px">
                                                        <b>Collector Information:</b>
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
                                                @else
                                                <td rowspan="5" colspan="2"></td>
                                            @endif


                                            </td>
                                            <td class="text-right" colspan="2" style="padding: 3px !important">
                                                <b>SUBTOTAL :</b>
                                            </td>
                                            <td class="text-right" style="padding: 3px !important">
                                                {{ number_format($total, 2) }}</td>
                                        </tr>

                                        <tr>

                                            <td class="text-right" colspan="2" style="padding: 3px !important">
                                                <b>Discount :</b>
                                            </td>
                                            <td class="text-right" style="padding: 3px !important">
                                                {{ number_format($discount, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="2" style="padding: 3px !important">
                                                <b>Bill
                                                    Amount :</b>
                                            </td>
                                            <td class="text-right" style="padding: 3px !important">
                                                {{ number_format($payable, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>

                                            <td class="text-right" colspan="2" style="padding: 3px !important">
                                                <b>Paid
                                                    :</b>
                                            </td>
                                            <td class="text-right" style="padding: 3px !important">
                                                {{ number_format($payment, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="2" style="padding: 3px !important">
                                                @if ($due >= 0 && $refund == 0)
                                                    <b>Due :</b>
                                                @elseif($due == 0 && $refund > 0)
                                                    <b>Refund :</b>
                                                @endif


                                            </td>
                                            <td class="text-right" style="padding: 3px !important">
                                                {{-- @if ($due < 0)
                                                    {{ number_format(abs($due), 2, '.', '') }}
                                                @else
                                                    {{ number_format($due, 2, '.', '') }}
                                                @endif --}}
                                                {{ number_format(abs($due + $refund), 2, '.', '') }}


                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer style="font-size: 9px">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $date = date('d/m/Y h:i a'); // $dt->format('g:i A');
                ?>
                <span style="float:left;">

                    {{-- Prepared By: {{ Session::get('user.ses_user_name') }} --}}
                    Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }},
                    Printed By: {{ Session::get('user.ses_user_name') }}

                </span>
                <span style=""> , Printing Date
                    & Time:{{ $date }} </span>
                <span style=""> , Powered By: NEXTGEN IT</span>


            </footer>
        </div>
    </div>


    @if ($length > 1 && $i != $length - 1)
        <div class="page-break"></div>
    @endif
@endfor
