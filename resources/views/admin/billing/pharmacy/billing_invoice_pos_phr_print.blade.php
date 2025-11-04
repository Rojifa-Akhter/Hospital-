@php
    $font = Session::get('user.ses_hospital_code') == 'GMC' ? '14px !important;' : '';
    $align = Session::get('user.ses_hospital_code') == 'GMC' ? ' text-top;' : '';
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
        font-size: <?php echo $font; ?>;
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

    td {
        font-size: <?php echo $font; ?>;
        vertical-align: <?php echo $align; ?>;
    }

    .hospital-address {
        font-size: <?php echo $font; ?>;
    }
</style>


<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="">
                        <div class="form-heading  border-bottom " style="margin-bottom: -10px;">
                         
                            @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                <div class="hospital-address" style="text-align: center">
                                    @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                            alt="logo" style="width: 65px;text-align:centers">
                                    @endif
                                    <br>
                                    <strong class=" "
                                        style="font-size: 11px;">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
                                    <br>
                                    <span class=" "
                                        style=" width:100px">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                                    <br>
                                    <span
                                        class="">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                                    <br>
                                    Hotline : <strong>
                                        {{ isset($po_hospital_details->hotline_number) ? $po_hospital_details->hotline_number : '' }}
                                    </strong>
                                </div>
                            @else
                                <div class="hospital-address">
                                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                            alt="logo" style="width: 35px">
                                    @endif
                                    <strong class=" "
                                        style="font-size: 11px;">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong>
                                    <br>
                                    <span class=" "
                                        style=" width:100px">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                                    <br>
                                    <span
                                        class="">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                                    <br>
                                    Hotline : <strong>
                                        {{ isset($po_hospital_details->hotline_number) ? $po_hospital_details->hotline_number : '' }}
                                    </strong>
                                </div>
                            @endif

                        </div>


                        <div class="">
                            <div class="patient-information  align-items-center">
                                <!-- <div class="heading text-center " style="margin:0px; padding: 0px; font-size: 15px">
                  Invoice Id = {{ $invoice_mst_info->invoice_code }}
                </div> -->
                                <table>
                                    <tr>
                                        <td class="text-left">
                                            <div class="text-left" style="">
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <!-- <i style="color: blue;"><b>Customer Copy </b></i> -->
                                                    <li style="margin-top: 4px;"><b> Invoice No :</b>&nbsp;<span>
                                                            {{ $invoice_mst_info->invoice_code }}</span></li>
                                                    <li><b>TRX ID
                                                            :</b>&nbsp;<span>{{ $finc_inv_collection_amount->ledgertrn_no_pk }}</span>
                                                    </li>
                                                    <li style="margin-top: 4px;">
                                                        <b>
                                                            @php
                                                                if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                                                    echo 'Id:';
                                                                } else {
                                                                    echo 'Patient ID :';
                                                                }
                                                            @endphp
                                                        </b>
                                                        &nbsp;<span> {{ $invoice_mst_info->patient_code }}</span>
                                                    </li>
                                                    <!-- <li>
                    <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                  </li> -->
                                                    @if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE')
                                                        <li style="margin-top: 4px;"><b>Name :</b>&nbsp;<span>
                                                                {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                                        </li>
                                                    @else
                                                        <li style="margin-top: 4px;"><b>Patient Name :</b>&nbsp;<span>
                                                                {{ ucwords($invoice_mst_info->patient_name) }}</span>
                                                        </li>
                                                    @endif
                                                    @if ($invoice_mst_info->admission_no_pk != '')
                                                        <li style="margin-top: 4px;"><b>Admission ID :</b>&nbsp;<span>
                                                                {{ ucwords($invoice_mst_info->admission_no_pk) }}</span>
                                                        </li>
                                                    @endif
                                                    <!-- @if ($invoice_mst_info->present_addr != ' ' && $invoice_mst_info->present_addr != null)
                                                        <li style="margin-top: 4px;"><b> Address:</b>&nbsp;<span>
                                                                {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : '' }}</span>
                                                        </li>
                                                    @endif -->
                                                    @if ($invoice_mst_info->mobile1 != ' ' && $invoice_mst_info->mobile1 != null)
                                                        <li style="margin-top: 4px;"><b> Phone no:</b>&nbsp;<span>
                                                                {{ !empty($invoice_mst_info->mobile1) ? $invoice_mst_info->mobile1 : '' }}</span>
                                                        </li>
                                                    @endif
                                                    <!-- @if ($invoice_mst_info->gender_txt != '')
<li style="margin-top: 4px;"><b>{{ $invoice_mst_info->age == '' ? '' : 'Age:' }}</b>&nbsp;<span>{{ $invoice_mst_info->age == '' ? '' : $invoice_mst_info->age . ',' }}</span> <b>{{ $invoice_mst_info->gender_txt != '' ? 'Gender:' : '' }}</b>&nbsp;<span>{{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt . ',' : '' }}</span> <b>
                              {{ $invoice_mst_info->mobile1 != '' ? 'Contact:' : '' }} </b>&nbsp;<span> {{ $invoice_mst_info->mobile1 != '' ? $invoice_mst_info->mobile1 : '' }}</span> </li>
@endif -->

                                                    <!--  @if ($invoice_mst_info->doctor_name != '')
<li style="margin-top: 4px;"><b>Ref. Doctor: </b>&nbsp;<span> {{ $invoice_mst_info->doctor_name != '' ? ucwords($invoice_mst_info->doctor_name) : '' }}</span> </li>
@endif

                    @if ($invoice_mst_info->first_doc_name != ' ')
<li style="margin-top: 4px;"><b>1st Ref: </b>&nbsp;<span>{{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span> </li>
@endif

                    @if ($invoice_mst_info->second_doc_name != ' ')
<li style="margin-top: 4px;"><b>2nd Ref: </b>&nbsp;<span>{{ $invoice_mst_info->second_doc_name != '' ? ucwords($invoice_mst_info->second_doc_name) : '' }}</span> </li>
@endif -->

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

                                                </ul>
                                            </div>
                                        </td>
                                        <!-- <td class="text-right" style="vertical-align: text-top;">
                      <div class="text-right" style="">
                        <ul style="list-style: none; padding-left: 0;">
                          <li><b>Date of Invoice:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($invoice_mst_info->au_entry_at)) }}</span> </li>
                          <li><b>Invoice ID :</b>&nbsp;<span>{{ $invoice_mst_info->invoice_code }}</span> </li>
                          <li>
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " />
                          </li>

                           <li><i style="color: blue;"><b>Duplicate Copy</b></i> </li>

                        </ul>
                      </div>
                    </td>  -->

                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-body" style="">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 5px">SL#</th>
                                        <th class="text-left">Item Description</th>
                                        <!-- <th class="text-left" style="width: 50px">Batch <br> No</th> -->
                                        <!-- <th class="text-left" style="width: 80px">Expire Date</th> -->
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
                                                    {{ $row->item_name }}<br>
                                                    {{-- @if (!empty($exp_date))
                                                        @foreach ($exp_date as $data)
                                                            @if ($row->item_no_fk == $data->item_no_fk && $data->batch_no != '')
                                                                <small>
                                                                    {{ $data->batch_no ? date('d-m-Y', strtotime($data->expiry_date)) . ',' : '' }}
                                                                </small>
                                                            @endif
                                                        @endforeach
                                                    @endif --}}
                                                </td>
                                                <!-- <td class="text-left" style="padding: 3px !important;"></td> -->

                                                @php
                                                    $item_rate = $row->item_rate;
                                                @endphp

                                                <td class=" text-right item_rate" style="padding: 3px !important;">
                                                    {{ number_format($item_rate, 2, '.', '') }}</td>
                                                <td class=" text-right" style="padding: 3px !important;">
                                                    {{ $row->item_qty }}</td>
                                                <td class="text-right bg-light" style="padding: 3px !important;">
                                                    {{ number_format($row->item_qty * $item_rate, 2, '.', '') }}</td>
                                            </tr>

                                            @php
                                                $total += $row->item_qty * $item_rate;
                                            @endphp
                                        @endforeach
                                    @endif
                                    @php
                                        // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                                        // $total = round(	$total);
                                        // $vat = number_format(0, 2, '.', '');
                                        // $discount = number_format($total_dis->ledger_amt_discount, 2, '.', '');
                                        // $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                                        // $urgent_fee =$invoice_mst_info->urgent_fee !="" ? number_format($invoice_mst_info->urgent_fee, 2, '.', '') : 0;
                                        // $payable = number_format(($total + $urgent_fee)- $discount, 2, '.', '');
                                        // $due = number_format(($total+$urgent_fee) - $payment, 2, '.', '');
                                        // $due = $due - $discount;
                                        // $number = number_format($total - $discount, 2, '.', '');
                                        // $locale = 'en_US';
                                        // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        // $in_words = numfmt_format($fmt, $number);
                                        $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                        $total = round($finc_inv_sum_amount->sales - $finc_inv_sum_amount->ledger_amt_vat);
                                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                        $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');
                                        $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                        $payable = number_format(($total + $finc_inv_sum_amount->ledger_amt_vat) - $discount - $finc_inv_sum_amount->sales_cancel + $cancel_discount, 2, '.', '');
                                        
                                        $due = round(number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', ''));
                                        $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                        $number = $payable;
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $in_words = numfmt_format($fmt, $number);
                                        $to_date = date('Y-m-d');
                                        
                                    @endphp
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if (isset($ledger_no) && $ledger_no != '')
                                            <td class="" rowspan="7" colspan="2"
                                                style="vertical-align: text-top;">

                                                <b>Cash Receipt In :</b>
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
                                                <div style="">
                                                    <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                                </div>
                                            @else
                                            <td rowspan="6" colspan="2" style="padding: 3px !important"></td>
                                        @endif


                                        </td>
                                        <td class="text-right" colspan="2" style="padding: 3px !important">
                                            <b>Sub Total </b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($total, 2) }}</td>
                                    </tr>
                                 
                                     @if($vat > 0 )                                       
                                    <tr>

                                        <td class="text-right" colspan="2" style="padding: 3px !important">
                                            <b>Vat Amt. </b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ $vat }}</td>
                                    </tr>
                                    @endif
                                    @if($urgent_fee > 0 )    
                                    <tr>

                                        <td class="text-right" colspan="2" style="padding: 3px !important">
                                            <b>Urgent Fee </b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($urgent_fee, 2, '.', '') }}</td>
                                    </tr>
                                    @endif
                                    <tr>

                                        <td class="text-right" colspan="2" style="padding: 3px !important">
                                            <b>Discount </b>
                                        </td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($discount, 2, '.', '') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2" style="padding: 3px !important"><b>Bill
                                                Amount </b></td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($payable, 2, '.', '') }}</td>
                                    </tr>
                                    <tr>

                                        <td class="text-right" colspan="2" style="padding: 3px !important"><b>Paid
                                            </b></td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{ number_format($payment, 2, '.', '') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2" style="padding: 3px !important"><b>

                                                @if ($due >= 0 && $refund == 0)
                                                    <b>Due :</b>
                                                @elseif($refund > 0)
                                                    @if ($finc_inv_collection_amount->refund > 0)
                                                        <b>Refund :</b> <br>
                                                    @endif
                                                    <b>Total Refund :</b>
                                                @endif

                                            </b></td>
                                        <td class="text-right" style="padding: 3px !important">
                                            {{-- {{ abs(number_format($due, 2, '.', '')) }}</td> --}}
                                            @if ($due >= 0 && $refund == 0)
                                                {{ number_format($due, 2, '.', '') }}
                                            @elseif($refund > 0)
                                                @if ($finc_inv_collection_amount->refund > 0)
                                                    {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }}
                                                    <br>
                                                @endif
                                                {{ number_format(abs($refund), 2, '.', '') }}
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
                    <div class="" style="margin-top: 5px;">
                        <span style="">Prepared By: {{ Session::get('user.ses_user_name') }}</span> &nbsp; <span
                            style="">Powered By: NEXTGEN IT</span> &nbsp; <span style="">Printing Date &
                            Time:
                            {{ date('d/m/Y') }} , {{ $date }} </span>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
