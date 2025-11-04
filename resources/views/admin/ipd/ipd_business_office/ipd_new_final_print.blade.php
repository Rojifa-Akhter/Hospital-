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
        border-top: 1px solid black;
        padding-top: 10px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
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
        font-size: 10px;
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
        margin-bottom: 5px;
    }

    .mt-5 {
        margin-top: 5px;
    }

    .mt-10 {
        margin-top: 5px;
    }

    .mt-20 {
        margin-top: 7px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-15 {
        margin-bottom: 5px;
    }

    .mb-10 {
        margin-bottom: 5px;
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
        font-size: 12px;
        color: #000;
        padding: 5px 50px;
        border-radius: 3px;
        /*font-weight: bold;*/
    }

    .form-heading .title-name {
        font-size: 12px;
        line-height: 1;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .form-heading h5 {
        font-size: 12px;
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
        border-bottom: 1px solid #333;
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
        border-bottom: 1px dotted #333;
    }
</style>


<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
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
                                @if(!empty($po_hospital_details->logo))
                                <img src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="80px" />
                                @endif
                            </div>
                            <div class="hospital-address" style="display:inline-block !important; ">
                                <h1 class="mb-0 ">{{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}}</h1>
                                <br>
                                <p class="mb-0 ">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</p>
                                <br>
                                <p class="mb-0 ">{{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</p>
                                <br>
                            </div>
                        </div>
                        <div class="" style="border: 1px dotted #dee2e6; height: 80px; padding:5px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                                        <li><b>Admission ID
                                                :</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                                        </li>
                                        <li>
                                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                                        </li>
                                        <li>&nbsp;<span><b>Name:</b>{{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}</span>
                                            &nbsp;<span><b>Age
                                                    :</b>{{ isset($paitent_info->age) ? $paitent_info->age : '' }}</span>
                                            <b>Gender
                                                :</b>&nbsp;<span>{{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}</span>
                                            <b>Bed :</b>&nbsp;<span>
                                                {{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                                        </li>

                                        <li><b>Con. Number :</b>&nbsp;<span>{{$paitent_info->mobile1}}</span> </li>
                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Patient ID
                                                :</b>&nbsp;<span>{{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}</span>
                                        </li>
                                        <li>
                                            <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                                        </li>
                                        <li><b>Phone
                                                :</b>&nbsp;<span>{{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}</span>
                                        </li>
                                        <li><b>Date Of Admission
                                                :</b>&nbsp;<span>{{ date('d/m/Y', strtotime($admission_info->admission_date)) }}</span>
                                        </li>
                                        <li><b>BILL STATUS
                                                :</b>&nbsp;<span>FINAL</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @php
                        $total = 0;
                        $total_investigation = 0;
                        $total_phr = 0;

                        $ledger_amt_discount = 0;
                        $ledger_amt_invst_discount = 0;
                        $ledger_amt_phar_discount = 0;

                        $ledger_amt_payment = 0;
                        $ledger_amt_invst_payment = 0;
                        $ledger_amt_phar_payment = 0;

                        $service_charge = 0;
                        $service_invst_charge = 0;
                        $service_phart_charge = 0;

                        $total_service_charge = 0;


                        @endphp

                        @if (!empty($hospital_service))

                        <div class="form-body">
                            <div class="heading text-center">
                                <h4>{{$hospital_service[0]->par_item_type_name}}</h4>
                            </div>
                            <table class="table table-bordered border-bottom">
                                <thead>
                                    <tr class="">
                                        <th class="text-left">SL</th>
                                        {{-- <th class="text-left">Service Type</th> --}}
                                        <th class="text-left">Item</th>
                                        {{-- <th class="text-left" colspan="2">Description</th> --}}
                                        <th class="text-center">Qty.</th>
                                        <th class="text-right" colspan="2">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>




                                    @foreach ($hospital_service as $row)
                                    <tr>
                                        <td class="text-left">{{ $loop->iteration }}</td>
                                        {{-- <td class="text-left">{{ $row->ity_group_header_name }}</td> --}}
                                        <td class="text-left">{{ $row->item_name }}</td>
                                        <td class="text-center">{{ ($row->day_sum_item_qty - $row->day_sum_cancel_qty) }}</td>
                                        {{-- <td class="text-left" colspan="2">{{ $row->item_name }}</td> --}}
                                        <td class="text-right" colspan="2">{{ number_format($row->day_sum_invoicedtl_amt_sales,2) }}
                                        </td>
                                    </tr>
                                    @php
                                    $total += $row->day_sum_invoicedtl_amt_sales;
                                    $service_charge += $row->day_service_charge;
                                    $ledger_amt_discount = $total_discount_hos_srv[0]->discount_hossrv;
                                    @endphp
                                    @endforeach
                                    @php
                                    //$total_due_refund =( $total - $paymentHistories[1]) - $paymentHistories[0];
                                    if (!empty($hospital_service)) {

                                    $ledger_amt_payment = isset($hospital_service[0]->sum_payment) ? $hospital_service[0]->sum_payment :0;
                                    $payable=number_format(($total+$service_charge) - $ledger_amt_discount, 2, '.', '');

                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $net_payable= number_format(($total+$service_charge) - $ledger_amt_discount);//number_format($total - $ledger_amt_discount, 2);
                                    $in_words = numfmt_format($fmt, abs($payable));
                                    $total_paid=number_format($ledger_amt_payment, 2);

                                    } else {
                                    $ledger_amt_payment = 0;
                                    $payable=$total - $ledger_amt_discount;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $net_payable= number_format($total - $ledger_amt_discount, 2, '.', '');
                                    $in_words = numfmt_format($fmt, abs($net_payable));
                                    $total_paid=number_format($ledger_amt_payment, 2);

                                    }
                                    @endphp


                                    <tr>
                                        <td class="text-left" rowspan="4" colspan="3">

                                            <b>In Word :</b>
                                            {{ strtoupper($in_words) }} TAKA ONLY
                                        </td>
                                        <td class="text-right"><b>Bill :</b></td>
                                        <td class="text-right">{{ number_format($total,2) }}</td>
                                    </tr>
                                    @if($service_charge > 0)
                                    <tr>
                                        <td class="text-right"><b>(+)Service Charge :</b></td>
                                        <td class="text-right">{{ number_format($service_charge,2) }}</td>
                                    </tr>
                                    @endif

                                    @if($ledger_amt_discount > 0)
                                    <tr>
                                        <td class="text-right"><b>(-)Discount :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_discount,2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right"><b>Net Payable :</b></td>
                                        <td class="text-right">{{ number_format(($total+$service_charge) - $ledger_amt_discount,2) }}</td>
                                    </tr>

                                    {{-- <tr>
                                        <td class="text-right"><b>Total Paid :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_payment, 2) }}</td>
                                    </tr> --}}

                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if (!empty($investigation))

                        <div class="form-body">
                            <div class="heading text-center mb-10">
                                <h4>&nbsp;</h4>
                            </div>
                            <table class="table  table-bordered border-bottom">
                                <thead>
                                    <tr class="">
                                        <th class="text-left" style="width: 68px;">SL</th>
                                        <th class="text-left" colspan="7">Service Type</th>
                                        {{-- <th class="text-left" colspan="2">Description</th> --}}
                                        {{-- <th class="text-center">Qty.</th> --}}
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($investigation as $row)
                                    @php

                                    $total_investigation += $row->day_sum_invoicedtl_amt_sales;
                                    $service_invst_charge += $row->day_service_charge;
                                    $ledger_amt_invst_discount = $total_discount_invst[0]->discount_invst;
                                    @endphp
                                    @endforeach

                                    <tr>
                                        <td class="text-left">1</td>
                                        <td class="text-left" colspan="7">{{$investigation[0]->par_item_type_name}}</td>
                                        {{-- <td class="text-center">{{ ($row->day_sum_item_qty - $row->day_sum_cancel_qty) }}</td> --}}
                                        {{-- <td class="text-left" colspan="2">{{ $row->item_name }}</td> --}}
                                        <td class="text-right">{{ number_format($total_investigation,2) }}</td>
                                    </tr>

                                    @php
                                    //$total_due_refund =( $total - $paymentHistories[1]) - $paymentHistories[0];
                                    if (!empty($investigation)) {

                                    $ledger_amt_invst_payment = isset($investigation[0]->sum_payment) ? $investigation[0]->sum_payment :0;
                                    $payable=number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount, 2, '.', '');
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($payable));
                                    $net_payable= number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount, 2);
                                    $total_paid=number_format($ledger_amt_invst_payment, 2);

                                    } else {

                                    $ledger_amt_invst_payment = 0;
                                    $payable=number_format($total_investigation - $ledger_amt_invst_discount, 2, '.', '');
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($payable));
                                    $net_payable= number_format($total_investigation - $ledger_amt_invst_discount, 2);
                                    $total_paid=number_format($ledger_amt_invst_payment, 2);
                                    }
                                    @endphp







                                    <tr>
                                        <td class="text-left" rowspan="4" colspan="5"><b>In Word :</b>
                                            {{ strtoupper($in_words) }} TAKA ONLY
                                        </td>
                                        <td class="text-right" colspan="3"><b>Bill :</b></td>
                                        <td class="text-right">{{ number_format($total_investigation,2) }}</td>
                                    </tr>

                                    @if($service_invst_charge > 0)
                                    <tr>
                                        <td class="text-right" colspan="3"><b>(+)Service Charge :</b></td>
                                        <td class="text-right">{{ number_format($service_invst_charge,2) }}</td>
                                    </tr>
                                    @endif

                                    @if($ledger_amt_invst_discount > 0)
                                    <tr>
                                        <td class="text-right" colspan="3"><b>(-)Discount :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_invst_discount,2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right" colspan="3"><b>Net Payable :</b></td>
                                        <td class="text-right">{{ number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount,2) }}</td>
                                    </tr>

                                    {{-- <tr>
                                        <td class="text-right"><b>Total Paid :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_payment, 2) }}</td>
                                    </tr> --}}

                                </tbody>
                            </table>
                        </div>
                        @endif

                       
                        @if (!empty($pharmacy))

                        <div class="form-body">
                            <div class="heading text-center mb-10">
                                <h4>&nbsp;</h4>
                            </div>
                            <table class="table  table-bordered border-bottom">
                                <thead>
                                    <tr class="">
                                        <th class="text-left" style="width: 68px;">SL</th>
                                        <th class="text-left" colspan="7">Service Type</th>
                                        {{-- <th class="text-left" colspan="2">Description</th> --}}
                                        {{-- <th class="text-center">Qty.</th> --}}
                                        <th class="text-right" colspan="2">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>




                                    @foreach ($pharmacy as $row)

                                    @php
                                    $total_phr += $row->day_sum_invoicedtl_amt_sales;
                                    $service_phart_charge += $row->day_service_charge;
                                    $ledger_amt_phar_discount = $total_discount_pharmacy[0]->discount_pharmacy;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td class="text-left">1</td>
                                        <td class="text-left" colspan="7">{{$pharmacy[0]->par_item_type_name}}</td>
                                        {{-- <td class="text-center">{{ ($row->day_sum_item_qty - $row->day_sum_cancel_qty) }}</td> --}}
                                        {{-- <td class="text-left" colspan="2">{{ $row->item_name }}</td> --}}
                                        <td class="text-right" colspan="2">{{ number_format($total_phr,2) }}
                                        </td>
                                    </tr>

                                    @php
                                    //$total_due_refund =( $total - $paymentHistories[1]) - $paymentHistories[0];
                                    if (!empty($pharmacy)) {

                                    $ledger_amt_phar_payment = isset($pharmacy[0]->sum_payment) ? $pharmacy[0]->sum_payment :0;
                                    $payable=($total_phr+$service_phart_charge) - $ledger_amt_phar_discount;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($payable));
                                    $net_payable= number_format($total_phr - $ledger_amt_phar_discount);
                                    $total_paid=number_format($ledger_amt_phar_payment);

                                    } else {
                                    $ledger_amt_phar_discount = 0;
                                    $ledger_amt_phar_payment = 0;
                                    $payable=$total_phr - $ledger_amt_phar_discount;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($payable));
                                    $net_payable= number_format($total_phr - $ledger_amt_phar_discount);
                                    $total_paid=number_format($ledger_amt_phar_payment);
                                    }
                                    @endphp







                                    <tr>
                                        <td class="text-left" rowspan="4" colspan="6"><b>In Word :</b>
                                            {{ strtoupper($in_words) }} TAKA ONLY
                                        </td>
                                        <td class="text-right" colspan="3"><b>Bill :</b></td>
                                        <td class="text-right">{{ number_format($total_phr,2) }}</td>
                                    </tr>

                                    @if($service_phart_charge > 0)
                                    <tr>
                                        <td class="text-right"><b>(+)Service Charge :</b></td>
                                        <td class="text-right">{{ number_format($service_phart_charge,2) }}</td>
                                    </tr>
                                    @endif

                                    @if($ledger_amt_phar_discount > 0)
                                    <tr>
                                        <td class="text-right" colspan="3"><b>(-)Discount :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_phar_discount,2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right" colspan="3"><b>Net Payable :</b></td>
                                        <td class="text-right">{{ number_format(($total_phr+$service_phart_charge) - $ledger_amt_phar_discount,2) }}</td>
                                    </tr>

                                    {{-- <tr>
                                        <td class="text-right"><b>Total Paid :</b></td>
                                        <td class="text-right">{{ number_format($ledger_amt_payment, 2) }}</td>
                                    </tr> --}}

                                </tbody>
                            </table>
                        </div>
                        @endif




                        <div class="form-body">
                            <div class="heading text-center mb-10">
                                <h4>Total Bill</h4>
                            </div>
                            <table class="table table-bordered mt-3">
                                <tbody>

                                    @php

                                    $tolat_amt = $total + $total_investigation + $total_phr;
                                    //$total_due_refund_amt =$total_due_refund + $total_due_refund_phr;
                                    $ledger_amt_discount_amt = $ledger_amt_discount + $ledger_amt_invst_discount + $ledger_amt_phar_discount;

                                    $net_payable_amt=number_format(($total - $ledger_amt_discount) + ($total_phr - $ledger_amt_phar_discount) + ($total_investigation - $ledger_amt_invst_discount),2);
                                    //$ledger_amt_payment_amt =number_format($paymentHistories[0] + $paymentHistories_phr[0],2);
                                    $ledger_amt_payment_amt =number_format($total_payment[0]->total_payment);
                                    $ledger_amt_payment_amt_rtn =number_format($total_payment_return[0]->total_payment);

                                    $act_payment = ($total_payment[0]->total_payment-abs($total_payment_return[0]->total_payment));

                                    $payable_amt=($total - $ledger_amt_discount) + ($total_phr - $ledger_amt_phar_discount) + ($total_investigation - $ledger_amt_invst_discount);
                                    //($total - $ledger_amt_discount) + ($total_phr - $ledger_amt_discount_phr);

                                    $total_service_charge = $service_charge + $service_invst_charge + $service_phart_charge;

                                    $total_payable = ($payable_amt+$total_service_charge);

                                    $total_due = (round($total_payable)-round($act_payment));

                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, abs($total_due),2);
                                    @endphp

                                    <tr>
                                        <td class="text-left" rowspan="7" colspan="3">
                                            <span style="font-size: 30px !important; line-height: 1; border: 5px solid #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                                @if ($total_due == 0 )
                                                <strong>PAID</strong>
                                                @elseif($total_due < 0) <strong>Refund</strong>
                                                    @elseif($total_due > 0)
                                                    <strong>DUE</strong>
                                                    @endif
                                            </span><br><br>
                                            <b>In Word :</b>
                                            {{ strtoupper($in_words) }} TAKA ONLY
                                        </td>
                                        <td class="text-right"><b>Bill :</b></td>
                                        <td class="text-right">{{ number_format($tolat_amt,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><b>(+)Total Service Charge :</b></td>
                                        <td class="text-right">{{ number_format($total_service_charge,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>(+)Total Bill :</b></td>
                                        <td class="text-right">{{ number_format($tolat_amt + $total_service_charge,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>(-)Total Discount :</strong></td>
                                        <td class="text-right"><strong>{{ number_format($ledger_amt_discount_amt,2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Net Payable :</b></td>
                                        <td class="text-right">{{ number_format($total_payable,2) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><b>Total Paid :</b></td>
                                        <td class="text-right">{{ $act_payment }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><b>Total Due :</b></td>
                                        <td class="text-right">{{ number_format($total_due) }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div style="margin-top: 50px;">
                    <span style="float: left;"><strong>Authorised Signature</strong></span>
                    <span style="float: right"><strong>Accounts</strong></span>
                </div>
            </div>
        </div>
    </div>
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
    <div class="">
        <span style="float:left;">Prepared By: {{ $userInfo->user_fullname }}</span>
        {{-- <span>Printing Date & Time: {{ date('d/m/Y') }} , {{ $date}} </span>&nbsp; --}}
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>