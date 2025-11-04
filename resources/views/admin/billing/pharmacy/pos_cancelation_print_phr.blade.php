
@php
$font=Session::get('user.ses_hospital_code')=="GMC" ? '14px !important;' : '';
$align=Session::get('user.ses_hospital_code')=="GMC" ? ' text-top;' : '';
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

        padding:8px;
        }*/
    @page {
        margin-top: 20px;
        margin-bottom: 0px;
        margin-left: 10px;
        margin-right: 20px;
        /*margin: 15px;
     width: 80mm; */
        /* width: 56mm; */
        /* size: 80mm,200mm ; */
        /*margin-bottom: 15px;*/
    }


    body {
        /* width: 80mm; */
        /* margin-top: 10px; */
        margin-left: 10px;
        margin-right: 10px;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 10px;
    }

    .header {
        position: fixed;
        left: 0px;
        /* top: -140px; */
        right: 0px;
        /* height: 150px; */
        text-align: center;
    }

    /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

    .footer {
        /* position: fixed; */
        /* z-index: 999999999; */

        left: 0;
        right: 0;
        /* height: 3cm; */
        /* text-align: center; */
        /* font-size: 9px; */
        /* bottom: -130px; */
        border-top: 1px solid black;
        font-size: <?php echo $font ?>;
        /* padding-top: 10px; */
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
        /* padding: 2px; */
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

        width: 50px;
    }

    .logo {
        /*width: 80px;*/
        display: inline-block;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        /* align-items: center; */
    }

    .hospital-names {
        /* margin-bottom: 0;
    font-size: 20px;
    padding-bottom: 0; */
    }

    .hospital-logo-info .hospital_info .hospital-address {
        /* font-weight: 500; */
        /* display: block; */
        /* line-height: 1.2; */


    }

    .hospital-logo-info .hospital_info .hospital-contact {
        /* font-weight: 500; */
        /* display: block; */
        /* line-height: 1.2; */
        /* width: 480px; */
    }

    .hospital_info {
        /* margin-left: 10px; */
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .title {
        /*background-color: #444;*/
        /* display: inline-block;
    font-size: 14px;
    color: #000;
    padding: 5px 50px;
    border-radius: 3px; */
        /*font-weight: bold;*/
    }

    .form-heading .title-name {
        /* font-size: 1.35rem;
    line-height: 1;
    margin-top: 30px;
    margin-bottom: 20px; */
    }

    .form-heading h5 {
        /* font-size: 1rem; */
        /*line-height: 1;*/
        /* margin-top: -10px;
    font-weight: 400; */
    }

    .form-heading p {
        /* font-size: .8rem;
    margin-top: -10px; */
    }

    .form-name {
        /* font-size: 16px; */
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
        /* padding: 5px !important; */
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
    }
    td{
        font-size: <?php  echo $font ?>;
        vertical-align: <?php   echo $align  ?>;
    }
    .hospital-address{
        font-size: <?php  echo $font ?>;
    }



</style>
<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="">
                        <div class="form-heading  border-bottom " style="margin-bottom: -10px;">

                            <div class="hospital-address">
                            @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        alt="logo" style="width: 35px">
                                @endif
                                <strong class=" "
                                    style="font-size: 11px;">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
                                <br>
                                <span class=""
                                    style=" width:100px">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                                <br>
                                <span
                                    class="">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                                <br>
                                Hotline : <strong> {{ isset($po_hospital_details->hotline_number) ? $po_hospital_details->hotline_number : '' }} </strong>
                            </div>
                        </div>


                        <div class="">
                            <div class="patient-information  align-items-center">

                                <table>
                                    <tr>
                                        <td class="text-left">
                                            <div class="text-left" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li style="margin-top: 4px;"> <strong> Invoice No:</strong>
                                                        {{ $invoice_mst_info->invoice_code }} </li>
                                                    <li style="margin-top: 4px;"> <strong> TRX. No:</strong>
                                                        {{ $finc_inv_collection_amount->ledgertrn_no_pk }} </li>
                                                    <li style="margin-top: 4px;"><b>
                                                            @php
                                                                if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                                                    echo 'Customer Id:';
                                                                } else {
                                                                    echo 'Patient ID :';
                                                                }
                                                            @endphp

                                                        </b>&nbsp;<span> {{ $invoice_mst_info->patient_code }}</span>
                                                    </li>

                                                    <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                            {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                                    </li>
                                                    @if ($invoice_mst_info->admission_no_pk != '')
                                                        <li style="margin-top: 4px;"><b>Admission ID :</b>&nbsp;<span>
                                                                {{ $invoice_mst_info->admission_no_pk }}</span>
                                                        </li>
                                                    @endif




                                                    <!-- @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                                        <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                                {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                        </li>
                                                    @endif -->
                                                    @if ($invoice_mst_info->mobile1 != '' && $invoice_mst_info->mobile1 != null)
                                                        <li style="margin-top: 4px;"><b>Address: </b>&nbsp;<span>
                                                                {{ !empty($invoice_mst_info->mobile1) ? $invoice_mst_info->mobile1 : '' }}</span>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="form-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 10px">SL#</th>
                                        <th class="text-left">Item Description</th>
                                        <!-- <th class="text-left" style="width: 100px">Expire Date</th> -->
                                        <!-- <th class="text-left" style="width: 40px">Delivery Status</th> -->
                                        <th class="text-right" style="width: 50px">Rate</th>
                                        <th class="text-right" style="width: 10px">Qty</th>
                                        <th class="text-right" style="width: 10px">Cx. <br> Qty</th>
                                        <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    style="border-top: 1px solid #222!important; border-bottom: 1px solid #222!important;">
                                    @php
                                        $total = 0;
                                        $total_item_rate = 0;
                                        $cancel_dic = 0;
                                        $total_item_rate_cancel = 0;
                                    @endphp
                                    @if (!empty($invoice_dtls_info))
                                        @foreach ($invoice_dtls_info as $row)
                                            @php
                                                $urgent_fee = 0;
                                                $item_rate = 0;
                                                // $cancel_fee =0;
                                            @endphp
                                            <tr>
                                                <td class="text-left " style="padding: 3px !important;">
                                                    {{ sprintf('%02d', $loop->iteration) }}</td>
                                                <td class="text-left" style="padding: 3px !important;">
                                                    {{ $row->item_name }}
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

                                                <!-- <td></td> -->
                                                @php
                                                    $item_rate = $row->item_rate;
                                                    $total_item_rate_cancel = number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '');
                                                    //number_format(($row->item_qty - $row->cancel_qty)*$item_rate,2,".","");
                                                @endphp

                                                <td class=" text-right item_rate" style="padding: 3px !important;">
                                                    {{ number_format($item_rate, 2, '.', '') }}</td>
                                                <td class=" text-right" style="padding: 3px !important;">
                                                    {{ $row->item_qty }}</td>
                                                <td class=" text-right" style="padding: 3px !important;">
                                                    {{ $row->cancel_qty }}</td>
                                                <td class="text-right bg-light" style="padding: 3px !important;">
                                                    {{ number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '') }}
                                                </td>
                                            </tr>
                                            @php
                                                // $total += ($row->cancel_qty*$item_rate);
                                                // $total_item_rate += $total_item_rate_cancel;

                                                // $cancel_dic += ($row->cancel_qty * $item_rate * $row->disc_perc) / 100;
                                                // $cancel_fee += ($row->cancel_qty * $row->urgent_fee ) ;

                                                $total += $row->cancel_qty * $item_rate + $row->cancel_qty * $row->item_vat;
                                                $total_item_rate += $row->item_qty * ($item_rate + $row->item_vat);

                                                // $cancel_dic += ($row->cancel_qty * $item_rate * $row->disc_perc) / 100;
                                                // $cancel_fee += $row->cancel_qty * $row->urgent_fee;

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
                                        $due = number_format($payable - $payment, 2, '.', '');
                                        $number = $total - $discount;
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $total_amt = round($total_item_rate);
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
                                <tfoot>
                                    <tr>


                                        <td rowspan="8" colspan="2" style="padding: 2px !important;">

                                            <b>In Word :</b> {{ strtoupper($in_words) }} TAKA ONLY


                                        </td>

                                        <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total
                                                Item Amt :</b></td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($total_item_rate, 2, '.', '') }}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Total
                                                Cx. Amt :</b></td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($sales_cancel, 2, '.', '') }}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right" colspan="3" style="padding: 2px !important;">
                                            <b>Urgent Fee:</b>
                                        </td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($c_urgent_fee->urgent_fee + $cancel_fee->cancel_urgent_fee, 2, '.', '') }}
                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="text-right" colspan="3" style="padding: 2px !important;">
                                            <b>(-) Discount :</b>
                                        </td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($calcel_discount, 2, '.', '') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net
                                                Cancel Amt :</b></td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right" colspan="3" style="padding: 2px !important;">
                                            <b>Discounted Amt:</b>
                                        </td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($discount, 2, '.', '') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Net
                                                Payable :</b></td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($net_payable, 2, '.', '') }}
                                        </td>


                                    </tr>
                                    <!-- round($total + $cancel_dis->ledger_amt_discount) -->
                                    <tr>
                                        <td class="text-right" colspan="3" style="padding: 2px !important;"><b>Paid
                                                Amt :</b></td>
                                        <td class="text-right" style="padding: 2px !important;">
                                            {{ number_format($paid_amount, 2, '.', '') }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right" colspan="5" style="padding: 2px !important;">
                                            {{-- @if ($due_refund < 0)
                                                <b>Refund
                                                    :</b>
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
                                </tfoot>
                            </table>
                        </div>


                    </div>
                </div>
                <div class="footer">
                    <?php
                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                    $date = $dt->format('g:i A');
                    ?>
                    @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                        <div>
                            <img src="{{ asset('images/MicrosoftTeams-image (6).png') }}" alt=""
                                style="width: 200px">
                        </div>
                    @endif
                    <div class="" style="margin-top: 5px;<?php echo $font?>" >
                        Prepared By : {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }}
                        <span style="">Printed By: {{ Session::get('user.ses_user_name') }}</span> &nbsp; <span
                            style="">Powered By: NEXTGEN IT</span> &nbsp; <span style="">Printing Date &
                            Time:
                            {{ date('d/m/Y') }} , {{ $date }} </span>

                    </div>
                </div>
            </div>
        </div>
        <!-- <div style="margin-top: 5px">
  <strong>Note: Please collect your reports within 30 days.</strong>
</div> -->

    </div>
</div>
