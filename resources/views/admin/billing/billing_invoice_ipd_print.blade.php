@php 
$footer_height= $po_hospital_details->hospital_code == 'DMHL' ? 3.8 : 3;
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
        bottom: -130px;
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
</style>
<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">
                        <div class="form-heading  border-bottom pb-3">
                            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                            <div id="logo" style="display:inline-block !important; width:70px;vertical-align: middle; margin-right:20px">
                                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
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
                            <div id="" style="  text-align:center ; padding-bottom:15px; height:80px;">
                                <div style="">
                                    @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" width="250px" alt="">
                                    @endif
                                </div>

                            </div>
                            @endif
                        </div>


                        <div class="" style=" margin: 2px 0px;">
                            <div class="patient-information d-flex align-items-center">


                                <table>
                                    <tr>
                                        <td class="text-left">
                                            <div class="text-left" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li><i style="color: blue;"><b>Customer Copy</b></i></li>
                                                    <li style="margin-top: 4px;"><b> Paitent ID :</b>&nbsp;<span>
                                                            {{ $invoice_mst_info->patient_code }}</span></li>
                                                    @if(!empty($invoice_mst_info->admission_no_pk))
                                                    <li style="margin-top: 4px;"><b> Admission ID :</b>&nbsp;<span>
                                                            <strong> {{ $invoice_mst_info->admission_no_pk }}</strong></span></li>
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

                                                    @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                                    <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                            {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                    </li>
                                                    @endif

                                                    <!-- @if ($invoice_mst_info->doctor_name != '')
                                                    <li style="margin-top: 4px;"><b>Ref. Doctor: </b>&nbsp;<span>
                                                            {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                                    </li>
                                                    @endif -->

                                                    <!-- @if ($invoice_mst_info->first_doc_name != ' ')
                                                    <li style="margin-top: 4px;"><b>1st Ref:
                                                        </b>&nbsp;<span>{{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                                    </li>
                                                    @endif -->

                                                    <!-- @if ($invoice_mst_info->second_doc_name != ' ')
                                                    <li style="margin-top: 4px;"><b>2nd Ref:
                                                        </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>
                                                    </li>
                                                    @endif -->

                                                    @if (isset($discout_by->full_name) || $ledgermst_paydisc->disc_amt_by_doc != 0)
                                                    <li style="margin-top: 4px;">
                                                        <b>Discount By: </b>&nbsp;<span>
                                                            {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}
                                                            {{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')': '' }}
                                                            {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0? ' ,  Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')': '' }}</span>
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
                                        <td class="text-right" style="vertical-align: text-top;">
                                            <div class="text-right" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li><b>Date of
                                                            Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span>
                                                    </li>
                                                    <li><b>Invoice ID
                                                            :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span>
                                                    </li>
                                                    <li>
                                                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " />
                                                    </li>

                                                    <!-- <li><i style="color: blue;"><b>Duplicate Copy</b></i> </li> -->
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($invoice_mst_info->doctor_name != '')
                                    <tr>
                                        <td colspan="2">
                                            <b>Ref. Doctor: </b>&nbsp;<span>
                                                {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if ($invoice_mst_info->first_doc_name != ' ')
                                    <tr>
                                        <td colspan="2">
                                            <b>1st Ref:
                                            </b>&nbsp;<span>{{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>

                                        </td>
                                    </tr>
                                    @endif
                                    @if ($invoice_mst_info->second_doc_name != ' ')
                                    <tr>
                                        <td colspan="2">
                                            <b>2nd Ref:
                                            </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span>


                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="form-body" style="margin-top: 2px">
                            <table class="table  mt-3" width='100%'>
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 10px">SL#</th>
                                        <th class="text-left">Item Description</th>
                                        <!--  <th class="text-leftleft">Delivery Date</th>
                                        <th class="text-leftleft">Delivery Status</th> -->
                                        <!-- <th class="text-right" style="width: 50px">Rate</th> -->
                                        <!-- <th class="text-right" style="width: 10px">Qty</th> -->
                                        <th class="text-right" colspan="7">Amount <br> (<small>BDT</small>)</th>
                                    </tr>
                                </thead>
                                <tbody style="border-top: 1px solid #222!important; border-bottom: 1px solid #222!important;">
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
                                            {{ sprintf('%02d', $loop->iteration) }}
                                        </td>
                                        <td class="text-left" style="padding: 3px !important; width:200px">
                                            {{ $row->item_name }}
                                        </td>
                                            <!-- <td class="text-left">
                                            {{ $row->report_delivery_date == '1970-01-01 00:00:00'? ' ': date('d/m/Y', strtotime($row->report_delivery_date)) }}
                                            </td>
                                            @if ($row->delivery_status_lookup_no_fk == 1)
                                            <td class=" text-left"> Routine </td>
                                                    @php
                                                        $item_rate = $row->item_rate;
                                                    @endphp
                                            @elseif($row->delivery_status_lookup_no_fk == 2)
                                                    <td class=" text-left"> Urgent </td>
                                                    @php
                                                        $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                                        $item_rate = $row->item_rate + $urgent_fee;
                                                    @endphp
                                            @else
                                                    <td></td>
                                            @endif -->
                                            @php
                                            $item_rate = $row->item_rate;
                                            @endphp

                                            <!-- <td class=" text-right item_rate" style="padding: 3px !important;">{{ number_format($item_rate, 2, '.', '') }}</td> -->
                                            <!-- <td class=" text-right" style="padding: 3px !important;">{{ $row->item_qty }}</td> -->
                                            <td class="text-right bg-light" style="padding: 3px !important;" colspan="7">
                                                <!-- number_format($row->item_qty*$item_rate,2,".","")  -->
                                                {{ abs(number_format($total_sales->ledger_amt_payment, 2, '.', '')) }}
                                            </td>
                                    </tr>

                                    @php
                                    $total += abs(number_format($total_sales->ledger_amt_payment, 2, '.', ''));

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
                                    $due = number_format($payment, 2, '.', '');
                                    $due = $due;
                                    $number = $total + $vat - $discount;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($due));
                                    @endphp
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if (isset($ledger_no) && $ledger_no != '')
                                        <td class="" rowspan="5" colspan="4" style="padding: 3px !important">
                                            <div style="margin-bottom: 5px">
                                                <span style="font-size: 30px; line-height: 1; border: 5px solid #dee4e6; border-left-color: #dee2e6; color: #909dab; padding: 10px; ">

                                                    <!-- @if ($due < 0)
                                                            <strong>Refund</strong>
                                                        @else
                                                            <strong>Advance</strong>
                                                        @endif -->

                                                    <strong> {{!empty($payment_status->pay_type) ? $payment_status->pay_type =="FINALBILL" ? 'PAID':$payment_status->pay_type :'' }}</strong>

                                                </span>
                                            </div>
                                            <br>

                                            <b>Cash Receipt In :</b>
                                            @foreach ($ledger_no as $value)
                                            @if ($value->paymood != null)
                                            @if ($value->paymood == 'CS')
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
                                            @endif
                                            @endforeach
                                            
                                            <div style="padding-top: 5px">
                                                <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                            </div>
                                            
                                            <div style="padding-top: 5px">
                                                <b>Remarks :</b> {{@$invoice_mst_info->invoice_remarks}}
                                            </div>
                                            @else
                                        <td rowspan="5" colspan="4"></td>
                                        @endif


                                        </td>
                                        <td class="text-right" colspan="4" style="padding: 3px !important">
                                            <b>SUBTOTAL :</b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($total + $vat, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4"><b>Urgent Fee :</b></td>
                                        <td class="text-right">
                                            {{ number_format($invoice_mst_info->urgent_fee, 2, '.', '') }}
                                        </td>
                                    </tr>

                                     <!-- <tr>
                                    <td class="text-right" colspan="4" style="padding: 3px !important"><b>Discount :</b></td>
                                    <td class="text-right" style="padding: 3px !important">{{ number_format($discount, 2, '.', '') }}</td>
                                    </tr> -->
                                                        <!-- <tr>
                                        <td class="text-right" colspan="4" style="padding: 3px !important"><b>Bill Amount :</b></td>
                                        <td class="text-right" style="padding: 3px !important">{{ number_format($payable, 2, '.', '') }}</td>
                                    </tr> -->
                                                        <!-- <tr>

                                        <td class="text-right" colspan="2" style="padding: 3px !important"><b>Paid :</b></td>
                                        <td class="text-right" style="padding: 3px !important">{{ number_format($payment, 2, '.', '') }}</td>
                                    </tr> -->
                                    <tr>
                                        <td class="text-right" colspan="4" style="padding: 3px !important"><b>

                                                @if ($due < 0) Refund @else Advance @endif </b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format(abs($due), 2, '.', '') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div style="margin-top: 5px ;padding-left: 5px" >
        <strong>Note: Please collect your reports within 30 days.</strong>
        </div> -->
    </div>
</div>
<footer>
    <!-- <hr style="border: 0.5px solid #000000"> -->
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="">
        <span style="float:left;">Prepared By: {{ Session::get('user.ses_user_name') }}</span> &nbsp; <span style="">Printing
            Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>