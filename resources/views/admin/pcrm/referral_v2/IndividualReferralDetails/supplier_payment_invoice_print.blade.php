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
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -130px;
        border-top: 1px solid black;
        padding-top: 10px;
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
        margin-right: 5px;
    }

    /*#logo{
           width: 70px;
           display: inline-block;
           }*/
    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 15px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address {
        font-weight: 400;
        /*display: block;*/
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
                            <div id="logo" style="display:inline-block !important; width:70px">
                                @if (!empty($po_hospital_details->logo))
                                    <img
                                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" />
                                @endif
                            </div>
                            <div class="hospital-address" style="display:inline-block !important;">
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
                                <br>
                            </div>
                        </div>


                        <div class="" style=" margin: 2px 0px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class=" text-center " style="padding: 3px !important; font-size: 15px">
                                    Invoice
                                </div>
                                <table>
                                    <tr>
                                        <td class="text-left">

                                            <ul style="list-style: none; padding-left: 0;">
                                                <li style="margin-top: 4px;"><i style="color: blue;"><b>Customer
                                                            Copy</b></i></li>

                                                <li style="margin-top: 4px;"><b>Supplier Name :</b>&nbsp;<span>
                                                        {{ !empty($supplier_info->supplier_name) ? ucwords($supplier_info->supplier_name) : '' }}</span>
                                                </li>
                                                <li style="margin-top: 4px;"><b>Supplier UID :</b>&nbsp;<span>
                                                        {{ ucwords($supplier_info->supplier_uid) }}</span>
                                                </li>
                                                <li style="margin-top: 4px;"><b>Challan Number :</b>&nbsp;<span>
                                                        {{ !empty($supplier_info->bill_challan_number) ? ucwords($supplier_info->bill_challan_number) : '' }}</span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-right">
                                            <ul style="list-style: none; padding-left: 0;">
                                                <li style="margin-top: 4px;"><b>Payment Date :</b>&nbsp;<span>
                                                        {{ !empty($supplier_info->payment_date) ? date('d/m/Y', strtotime($supplier_info->payment_date)) : '' }}</span>
                                                </li>
                                                <li style="margin-top: 4px;"><b>Supplier Ledger UID :</b>&nbsp;<span>
                                                        {{ ucwords($supplier_info->supledger_no_uid) }}</span>
                                                </li>
                                                <li style="margin-top: 4px;">
                                                    <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                                        style="width: 120px; " />
                                                </li>
                                            </ul>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-body" style="margin-top: 2px">
                            <table class="table  mt-3">
                                <thead>
                                    <tr>
                                        <td class="w-5 bg-primary text-center"><strong>SL#</strong></td>
                                        <td class="text-left bg-primary"><strong>PO UID</strong></td>
                                        <td class=" text-left bg-primary"><strong>PO Paid Status</strong></td>
                                        <td class=" text-right bg-primary"><strong>PO Deduct Amt.</strong></td>
                                        <td class=" text-right bg-primary"><strong>PO Payment Amt.</strong></td>
                                        <td class=" text-right bg-primary w-15"><strong>PO Amt.</strong></td>
                                    </tr>
                                </thead>
                                <tbody style="border-top: 1px solid #222!important; ">
                                    @if (!empty($payment_info))

                                        @php
                                            $total_po_amt = 0;
                                            $total_dis_amt = 0;
                                            $dis_amt = 0;
                                            $total_paid_amt = 0;
                                            $pre_po_amount_deduct = 0;
                                            $payable_amt = 0;
                                            $total_deduct_amt = 0;
                                            $total_current_payment_amt = 0;
                                            $due = 0;
                                        @endphp
                                        @foreach ($payment_info as $data)
                                            @php
                                                $total_po_amt += $data->po_amount;
                                                $total_dis_amt += $data->past_po_dis_amount;
                                                $dis_amt += $data->po_amount_discount;
                                                $total_paid_amt += $data->past_po_pay_amount;
                                                $pre_po_amount_deduct += $data->past_po_ded_amount;
                                                $payable_amt =  ($total_po_amt - $total_dis_amt - $total_paid_amt) + $pre_po_amount_deduct;
                                                $total_deduct_amt += $data->po_amount_deduct;
                                                $total_current_payment_amt += $data->po_amount_payment;
                                                $due = (($payable_amt + $total_deduct_amt) - $dis_amt) - $total_current_payment_amt;
                                                $locale = 'en_US';
                                                $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                                $in_words = numfmt_format($fmt, $payable_amt);
                                            @endphp
                                            <tr>
                                                <td class=" text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left ">{{ $data->purchase_uid }}</td>
                                                <td class="text-left ">
                                                    {{ $data->po_fullpaid_ind == 1 ? 'Paid' : 'Due' }}</td>
                                                <td class="text-right ">
                                                    {{ number_format($data->po_amount_deduct, 2) }}
                                                </td>
                                                <td class="text-right ">
                                                    {{ number_format($data->po_amount_payment, 2) }}</td>
                                                <td class="text-right ">{{ number_format($data->po_amount, 2) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                <tfoot style="border-top: 1px solid #222!important;">
                                    <tr>
                                        <td rowspan="9" colspan="4">
                                            <div style="margin-bottom: 5px; ">
                                                <span style="font-size: 30px; line-height: 1; border: 5px solid
                                                #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                                    @if ($due == 0)
                                                        <strong>PAID</strong>
                                                    @elseif($due<0) <strong>Advance</strong>
                                                        @else
                                                            <strong>DUE</strong>
                                                    @endif
                                                </span>
                                            </div>
                                            <br>
                                            <b>Cash Receipt In :</b>
                                            @if (!empty($total_current_payment_amt))
                                            @if (!empty($supplier_info->pay_mode && $supplier_info->pay_mode == 'cash'))
                                            Cash : {{ $total_current_payment_amt }}
                                            @elseif (!empty($supplier_info->pay_mode) && $supplier_info->pay_mode == 'cheque')
                                            Cheque : {{ $total_current_payment_amt }}
                                            @endif
                                            @else
                                            @if (!empty($supplier_info->pay_mode && $supplier_info->pay_mode == 'cash'))
                                            Cash : {{ $total_deduct_amt }}
                                            @elseif (!empty($supplier_info->pay_mode) && $supplier_info->pay_mode == 'cheque')
                                            Cheque : {{ $total_deduct_amt }}
                                            @endif
                                            @endif

                                            <div style="padding-top: 5px">
                                                <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                            </div>
                                        </td>
                                        <td class="text-right border-none" >

                                            <strong>Total PO Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($total_po_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong> Discounted Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($total_dis_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none">
                                            <strong> Deducted Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($pre_po_amount_deduct, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong> Paid Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                          <strong>  {{ number_format($total_paid_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong>Payable Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($payable_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong>Discount Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($dis_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong> Deduct Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                           <strong> {{ number_format($total_deduct_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong> Payment Amt : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                          <strong>  {{ number_format($total_current_payment_amt, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right border-none" >
                                            <strong>Due : </strong>
                                        </td>
                                        <td class="text-right border-none">
                                          <strong>  {{ number_format($due, 2) }} </strong>
                                        </td>
                                    </tr>
                                </tfoot>

                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div style="margin-top: 5px ;padding-left: 5px">
            <strong>Note: Please collect your reports within 30 days.</strong>
        </div> --}}
    </div>
</div>
<footer>
    <?php

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');

    ?>
    <div class="">
        <span style="float:left;">Prepared By: {{ $user }}</span> &nbsp; <span style="">Printing
            Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
