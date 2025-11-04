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
        /*margin-top: 150px;*/
        /*margin-bottom: 120px*/
    }

    .header {
        position: fixed;
        left: 0px;
        top: -140px;
        right: 0px;
        height: 100px;
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
        bottom: -100px;

        padding-top: 10px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 12px;
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
        font-size: 12px;
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
                        <!-- <div class="form-heading text-center border-bottom pb-3">
                            <div class="hospital-address">
                                <h1 class="mb-0 text-center">Khwaja Badrudduja Modern Hospital</h1> <br>
                                <p class="mb-0 text-center">Aziz Mansion, Shufipur, Kaliakair, Gazipur.</p> <br>
                                <p class="mb-0 text-center">Phone : 01776-606262, 01687-625565</p> <br>
                            </div>
                        </div> -->
                        <div class="form-heading  border-bottom pb-3" style="">
                            <div id="logo" style="display:inline-block !important; ">
                                @if (!empty($po_hospital_details->logo))
                                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
                                @endif
                            </div>
                            <div class="hospital-address" style="display:inline-block !important; ">
                                <h1 class="mb-0 ">
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h1>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                </p>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </p>
                                <br>
                            </div>
                        </div>

                        <div class="heading text-center border-bottom mb-10">
                            <h2>GRN Report</h2>
                        </div>


                        <div class="" style="border: 1px solid #dee2e6; height: 130px; padding: 10px; margin-top: 10px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Store
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->department) ? ucfirst($grn_report_list[0]->department) : 'n/a' }}</span>
                                        </li>
                                        <li><b>Supplier Name
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->supplier_name) ? ucfirst($grn_report_list[0]->supplier_name) : 'n/a' }}</span>
                                        </li>

                                        <li><b>PO NO
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->po_no) ? $grn_report_list[0]->po_no : '' }}</span>
                                        </li>
                                        <li><b>PO Date
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->purchase_date) ? date('d/m/Y', strtotime($grn_report_list[0]->purchase_date)) : '' }}</span>
                                        </li>
                                        <li><b>PO By
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->po_by_name) ? $grn_report_list[0]->po_by_name : '' }}</span>
                                        </li>

                                        <li><b>Delivery Location
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->delivery_location) ? $grn_report_list[0]->delivery_location : 'n/a' }}</span>
                                        </li>


                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">

                                        {{-- <li>
                                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                                        </li> --}}
                                        <li><b>isPosted
                                            </b>&nbsp;<span>
                                                {{!empty($grn_report_list[0]->rcv_save_option) ? $grn_report_list[0]->rcv_save_option : ''   }}</span>
                                        </li>
                                        <li><b>GRN NO
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->itemreceive_no_pk) ? $grn_report_list[0]->itemreceive_no_pk : 'n/a' }}</span>
                                        </li>

                                        <li><b>Date of GRN:</b>&nbsp;<span>
                                                {{ date('d/m/Y', strtotime($grn_report_list[0]->receive_date)) }}</span>
                                        </li>
                                        <li><b>Challan No
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->challan_no) ? $grn_report_list[0]->challan_no : 'n/a' }}</span>
                                        </li>
                                        <li><b>Challan Date
                                                :</b>&nbsp;<span>
                                                {{ !empty($grn_report_list[0]->challan_date) ? date("d/m/Y", strtotime($grn_report_list[0]->challan_date)) : 'n/a' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>



                        <div class="form-body" style="margin-top: 30px">

                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th class="text-center">#SL</th>
                                        <th class="text-center">PR No</th>
                                        <th class="text-left">Item Name</th>
                                        <th class="text-left">Item UoM</th>
                                        <th class="text-right">Order Qty.</th>
                                        <th class="text-right">Receive Qty.</th>
                                        <th class="text-right">Free Qty.</th>
                                        <th class="text-right">Total Qty.</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totals = 0;
                                    @endphp
                                    @if (isset($grn_report_list))
                                    @foreach ($grn_report_list as $value)
                                    @php

                                    $free_qty = $value->freeitem_qty != '' ? $value->freeitem_qty : 0;
                                    @endphp
                                    <tr>
                                        <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $value->inv_requisitiondtl_no_pk =="" ? $value->inv_requisitionmst_po_no_pk :$value->inv_requisitiondtl_no_pk }}</td>
                                        <td class="text-left">{{ $value->item_name }}</td>
                                        <td>{{ $value->uom_name }}</td>
                                        <td class="text-right">{{ $value->order_qty }}</td>
                                        <td class="text-right">{{ $value->delivered_qty }}</td>
                                        <td class="text-right">{{ $value->freeitem_qty }}
                                            {{-- {{ $value->freeitem_qty > 0 ? $value->free_uom_name : '' }}
                                        </td> --}}
                                        <td class="text-right">
                                            {{ $value->total_qty }}
                                        </td>
                                        <td class="text-right"> {{ number_format($value->unit_price, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ !empty($value->delivered_qty) ? number_format($value->amount, 2) : '' }}
                                        </td>
                                    </tr>
                                    @php
                                    $totals += !empty($value->unit_price) ? $value->amount : 0;
                                    @endphp
                                    @endforeach
                                    @endif

                                </tbody>
                                @php
                                $sub_total = 0;
                                $total = 0;
                                $vat_percent = isset($grn_report_list[0]->vat_percent) ? $grn_report_list[0]->vat_percent : 0;
                                $vat_amount = isset($grn_report_list[0]->vat_amount) ? $grn_report_list[0]->vat_amount : 0;
                                $discount = 0;
                                $discount_percent = isset($grn_report_list[0]->discount_percent) ? $grn_report_list[0]->discount_percent : 0;
                                $discount_amount = isset($grn_report_list[0]->discount_amount) ? $grn_report_list[0]->discount_amount : 0;
                                $discount = 0;
                                $payment = 0;
                                $payable = 0;
                                $due = 0;
                                $due = 0;

                                $number = number_format($totals - $discount, 2, '.', '');
                                $locale = 'en_US';
                                $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                $in_words = numfmt_format($fmt, $number);
                                @endphp
                                <tfoot>
                                    <tr>
                                        <td class="" colspan="6" style="border:0px; padding: 2px !important;">
                                        </td>
                                        <td class="text-right" colspan="3" style="border:0px; padding: 2px !important;">
                                            <strong>Total :</strong>
                                        </td>
                                        <td class="text-right" style=" border:0px; padding: 2px !important;">
                                            <strong>
                                                {{ number_format($totals, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="" colspan="6" style="border:0px; padding: 2px !important;">
                                        </td>
                                        <td class="text-right" colspan="3" style="border:0px; padding: 2px !important;">
                                            <strong>Total VAT/Tax </strong>({{ number_format($vat_percent, 2) }} %):
                                        </td>
                                        <td class="text-right" style="border:0px; padding: 2px !important;"> <strong>
                                                {{ number_format($vat_amount, 2) }}</strong></td>
                                    </tr>

                                    <tr>
                                        <td class="" colspan="6" style="border:0px; padding: 2px !important;">
                                        </td>
                                        <td class="text-right" colspan="3" style="border:0px; padding: 2px !important;">
                                            <strong>Total Discount </strong>
                                            ({{ number_format($discount_percent, 2) }}
                                            %):
                                        </td>
                                        <td class="text-right" style="border:0px; padding: 2px !important;">

                                            <strong>{{ number_format($discount_amount, 2) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="" colspan="6" style="border:0px; padding: 2px !important;">
                                        </td>
                                        <td class="text-right" colspan="3" style="border:0px; padding: 2px !important;">
                                            <strong>Adjustment Amt. :</strong>
                                        </td>
                                        @php
                                        $adj_amt = !empty($return_adj_amt) ? round($return_adj_amt->adjustment_amount) : 0;
                                        @endphp
                                        <td class="text-right" style="border:0px; padding: 2px !important;"><strong>
                                                {{ number_format($adj_amt, 2) }}</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="" colspan="6" style="border:0px; padding: 2px !important;">
                                        </td>
                                        <td class="text-right" colspan="3" style="border:0px; padding: 2px !important;">
                                            <strong>Net Payable :</strong>
                                        </td>
                                        <td class="text-right" style="border:0px; padding: 2px !important;"> <strong>
                                                {{ number_format(round($totals + $vat_amount - ($adj_amt + $discount_amount)), 2) }}</strong>
                                        </td>
                                    </tr>


                                    @php $due = 0; @endphp
                                </tfoot>

                            </table>
                            @php
                            $number=round($totals + $vat_amount - ($adj_amt + $discount_amount));
                            $locale = 'en_US';
                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                            $in_words = numfmt_format($fmt, $number);
                            @endphp
                            <strong>In Word :</strong> {{ ucwords($in_words) }} Taka Only
                            <br><br><br> <br><br><br> <br><br><br>

                            <div class="">

                            </div>

                        </div>
                    </div>
                </div>


            </div>


        </div>


    </div>
</div>

<div>
    <table style="width: 100%; border:none ">
        <tr>
            <td colspan="2" style="text-align:left; ">
                <span style="padding:5px; "> prepared by</span>
            </td>
            <td colspan="2" style="text-align:center;">
                <span style="padding:5px;"> Checked by</span>
            </td>

            <td colspan="2" style="text-align:right; border:none">
                <span style="padding:5px; padding-right:50px">HOD</span>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border:none ;margin-top:40px">
        <tr style=" ">
            <td style="text-align:left; border:none " colspan="2">

                <span style="padding:5px; border-top: black solid 1px;">
                    {{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->user_fullname_entry_by : '' }}
                </span>

            </td>
            <td style="text-align:center; border:none" colspan="2">

                <span style="padding:5px; border-top: black solid 1px;"> Signature & Date
                </span>
            </td>

            <td style="text-align:right; border:none" colspan="2">

                <span style="padding:5px; border-top: black solid 1px;"> Signature & Date
                </span>
            </td>
        </tr>
    </table>

</div>

<footer>

    <!-- <hr style="border: 0.5px solid #000000"> -->
    <!-- <div class="">
        <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }} &nbsp;
            <span style="float:right">Powered By: NEXTGEN IT</span>
    </div> -->
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>

    <div class="" style=" border-top: 1px solid black;">
        <span style="">Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>