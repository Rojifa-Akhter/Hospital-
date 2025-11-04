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
        bottom: -130px;
        border-top: 1px solid black;
        padding-top: 10px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        /* font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif'; */
        font-family: 'font-family: Arial, Tahoma, sans-serif' !important;
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
        font-family: 'font-family: Arial, Tahoma, sans-serif' !important;
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
        border-bottom: 1px dotted #222;
        font-family: Arial, Tahoma, sans-serif;
    }
</style>
@php
    $length =
        isset($po_hospital_details->consultation_invoice_print) &&
        $po_hospital_details->consultation_invoice_print != ''
            ? $po_hospital_details->consultation_invoice_print
            : 1;
    $imagePath = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';
    $imagePathImpala = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';

    date_default_timezone_set('Asia/Dhaka');
    $date = date('d/m/Y h:i a'); // $dt->format('g:i A');

@endphp

<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">
                        {{-- <div class="form-heading text-center border-bottom pb-3">
                            <div class="hospital-address">
                                <h1 class="mb-0 text-center">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}  </h1> <br>
                                <p class="mb-0 text-center">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p> <br>
                                <p class="mb-0 text-center">  {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p> <br>
                            </div>
                        </div>  --}}

                        <div class="form-heading  border-bottom pb-3">
                            {{-- @if ($po_hospital_details->report_header_image_prshde_ind == 1) --}}
                            @if ($po_hospital_details->hospital_code != 'KBMH')
                                <div id="logo"
                                    style="display:inline-block !important; width:70px;vertical-align: middle; margin-right:20px">
                                    @if (!empty($po_hospital_details->logo))
                                        <img src="{{ $imagePath }}" width="80px" />
                                    @endif
                                </div>
                                <div class="hospital-address"
                                    style="display:inline-block !important; text-align:center;margin-right:190px">
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
                                <div style="height: 80px"></div>
                            @endif
                            {{-- @else
                                <div id="" style="  text-align:center ; padding-bottom:15px; height:80px;">
                                    <div style="">
                                        @if ($po_hospital_details->report_header_image != '')
                                            <img class="hospital-logo"
                                                src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                                width="250px" alt="">
                                        @endif
                                    </div>

                                </div> --}}
                            {{-- @endif --}}
                        </div>

                        <div style="text-align: center">
                            <h3>{{ $admission_info->dis_ind == 1 ? 'Summary Bill' : 'Provisional Bill' }}</h3>
                        </div>
                        <div class=""
                            style="border: 1px solid #dee2e6; height: 115px; padding: 0px 10px 10px; margin: 10px 0px;">
                            {{-- @dd($admission_info) --}}
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><i style="color: blue;"><b>Customer Copy</b></i></li>
                                        <li><b>Name
                                                :</b>&nbsp;<span>{{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}</span>
                                        </li>
                                        <li><b>Age
                                                :</b>&nbsp;<span>{{ isset($paitent_info->age) ? $paitent_info->age : '' }}</span>
                                        </li>
                                        <li><b>Gender
                                                :</b>&nbsp;<span>{{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}</span>
                                        </li>
                                        <li><b>Contact No
                                                :</b>&nbsp;<span>{{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}</span>
                                        </li>
                                        <li><b>Consultant
                                                :</b>&nbsp;<span>{{ isset($admission_info->primary_doctor_name) ? $admission_info->primary_doctor_name : '' }}</span>
                                        </li>
                                        <li><b>Department
                                                :</b>&nbsp;<span>{{ isset($admission_info->doc_dept) ? $admission_info->doc_dept : '' }}</span>
                                        </li>
                                        <li><b>Address
                                                :</b>&nbsp;<span>{{ isset($paitent_info->present_addr) ? $paitent_info->present_addr : '' }}</span>
                                        </li>
                                        {{-- <li><b>Ref. By :</b>&nbsp;<span>Dr.MD. Jahangir Kabir,  MBBS, BCS, FCPS</span> </li>
                                            <li><b>Sec. Ref. :</b>&nbsp;<span></span> </li> --}}
                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">
                                        {{-- <li><i>11-12-2021 (8:30:00PM)</i> </li> --}}
                                        <li><b>@if (Session::get('user.ses_hospital_code') == "KPJ")
                                                    MRN :
                                                @else
                                                    UHID :
                                                @endif
                                                </b>&nbsp;<span>{{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}</span>
                                        </li>
                                        <li>
                                            <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                                        </li>

                                        {{-- <li><i style="color: blue;"><b>Duplicate Copy</b></i></li> --}}
                                        <li><b>Admission Date
                                                :</b>&nbsp;<span>{{ $admission_info->admission_date != '' ? date('d-m-Y', strtotime($admission_info->admission_date)) : '' }}</span>
                                        </li>
                                        @if(!empty($admission_info->dis_datetime))
                                            <li>
                                                <b>Discharge Date :</b>&nbsp;
                                                <span>{{ \Carbon\Carbon::parse($admission_info->dis_datetime)->format('d-m-Y') }}</span>
                                            </li>
                                        @endif
                                        
                                        
                                        <li><b>Admission ID
                                                :</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                                        </li>

                                        <li><b>Bed Category
                                                :</b>&nbsp;<span>{{ isset($admission_info->new_ward_name) ? $admission_info->new_ward_name : '' }}</span>
                                        </li>
                                        <li><b>Bed No
                                                :</b>&nbsp;<span>{{ isset($admission_info->new_bed_name) ? $admission_info->new_bed_name : '' }}</span>
                                        </li>

                                        @if(Session::get('user.ses_hospital_code') != 'KPJ')

                                        <li><b>MUSHAK
                                                :</b>&nbsp;<span>6.3</span>
                                        </li>
                                        <li><b>BIN NO
                                                :</b>&nbsp;<span>000995938-0201</span>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>



                        <div class="form-body" style="">
                            {{-- <div class="heading text-center border-bottom mb-10">
                                <h2>Hospital and Consultant Bill</h2>
                            </div> --}}
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr class="">
                                        <th class="text-left w-5" style="border-bottom: 1px solid black !important">SL
                                        </th>
                                        <th class="text-left" style="border-bottom: 1px solid black !important">Charge
                                        </th>
                                        <th class="text-right w-20" style="border-bottom: 1px solid black !important">
                                            Amount</th>
                                        <th class="text-right w-20" style="border-bottom: 1px solid black !important">
                                            Discount</th>
                                        <th class="text-right w-20" style="border-bottom: 1px solid black !important">
                                            Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($bill))
                                        @php
                                            $totalSale = 0;
                                            $totalDiscount = 0;
                                            $sl=1;
                                            // $totalPaid      =0;
                                        @endphp
                                        @foreach ($bill as $value)
                                            @if($value->sales >0 )
                                                <tr class="" style="font-size:11px !important; font-width:none">
                                                    <td class="text-left">{{ $sl++ }}</td>
                                                    <td class="text-left">{{ ucfirst(strtolower($value->item_type_name)) }}
                                                    </td>
                                                    <td class="text-right">{{ number_format($value->sales, 2) }}</td>
                                                    <td class="text-right">{{ number_format($value->dis, 2) }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($value->sales - $value->dis, 2) }}</td>
                                                </tr>
                                            @endif
                                            @php
                                                $totalSale += $value->sales;
                                                $totalDiscount += $value->dis;
                                                // $totalPaid      +=$value->payment;
                                            @endphp
                                        @endforeach
                                             @inject('dipositAmt', 'App\Http\Controllers\IPDController')
                                             @inject('dipositAmtDtl', 'App\Http\Controllers\IPDController')
                                        @php
                                            $totalPaid = 0;
                                            foreach ($advancePayment as $item) {
                                                $totalPaid += $item->ledger_amt_payment;
                                            }
                                            $dipositAmt=$dipositAmt->ipdDipositAmt($admission_info->admission_no_pk)['sum_deposit_amount'];
                                            $dipositAmtDtl=$dipositAmtDtl->ipdDipositAmt($admission_info->admission_no_pk)['deposit_details'];
                                           
                                            $totalPaid +=$dipositAmt;
                                            $netBillAmt = $totalSale - $totalDiscount;
                                            $receivableAmount =
                                                $totalSale - $totalDiscount - $totalPaid >= 0
                                                    ? round($totalSale - $totalDiscount - $totalPaid, 2)
                                                    : 0;
                                            $locale = 'en_US';
                                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                            $in_words = numfmt_format($fmt, abs($receivableAmount));
                                        @endphp
                                        <tr>
                                            <td colspan="4" style="text-align: right; border-bottom:none !important">
                                                Total Bill Amount</td>
                                            <td
                                                style="text-align: right; border-bottom:none !important;  border-top:1px solid rgb(110, 107, 107) !important">
                                                {{ number_format($totalSale, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; border-bottom:none !important">
                                                Discount Amt.</td>
                                            <td
                                                style="text-align: right; border-bottom:none !important ; border-bottom:1px solid rgb(110, 107, 107) !important">
                                                {{ number_format($totalDiscount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; border-bottom:none !important">
                                                Net Bill Amount</td>
                                            <td style="text-align: right; border-bottom:none !important ; ">
                                                {{ number_format($netBillAmt, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right; border-bottom:none !important">
                                                Advance Payment</td>
                                            <td style="text-align: right; border-bottom:none !important ; ">
                                                {{ number_format($totalPaid, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="text-align: right; border-bottom:none !important">
                                                @if ($totalSale - $totalDiscount - $totalPaid > 0)
                                                    Due Amount
                                                @else
                                                    Refund Amount
                                                @endif

                                            </th>
                                            <th
                                                style="text-align: right; border-bottom:none !important ; border-top:1px solid rgb(110, 107, 107) !important">
                                                {{ number_format($totalSale - $totalDiscount - $totalPaid, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="border-bottom:none !important;"><b>In Word
                                                    :</b>{{ strtoupper($in_words) }} TAKA ONLY</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                           
                                <h3>Advance Collection</h3>
                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">SL</th>
                                            <th style="text-align: left">Trans No</th>
                                            <th style="text-align: left">Transection Type</th>
                                            <th style="text-align: left">Transection Date</th>
                                            <th style="text-align: left">Received By</th>
                                            <th style="text-align: right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (!empty($advancePayment))
                                        @foreach ($advancePayment as $item)
                                            <tr>
                                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                                <td style="text-align: left">{{ $item->ledger_no_pk }}</td>
                                                <td style="text-align: left">{{ $item->pay_type }}</td>
                                                <td style="text-align: left">
                                                    {{ $item->ledger_datetime != '' ? date('d-m-Y h:i a', strtotime($item->ledger_datetime)) : '' }}
                                                </td>
                                                <td style="text-align: left">{{ $item->user_fullname }}</td>
                                                <td style="text-align: right">{{ $item->ledger_amt_payment }}</td>

                                            </tr>
                                        @endforeach
                                    @endif
                                        @if (!empty($dipositAmtDtl))
                                            @foreach($dipositAmtDtl as $value)
                                                <tr>
                                                    <td style="text-align: center">{{ count($advancePayment)+1 }}</td>
                                                    <td style="text-align: left">{{ $value->ledger_no_fk }}</td>
                                                    <td style="text-align: left">DIPOSIT</td>
                                                    <td style="text-align: left">
                                                        {{ $value->au_entry_at != '' ? date('d-m-Y h:i a', strtotime($value->au_entry_at)) : '' }}
                                                    </td>
                                                    <td style="text-align: left">{{ $value->user_fullname }}</td>
                                                    <td style="text-align: right">{{ $value->pay_amount }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Session::get('user.ses_hospital_code') != 'KPJ')

<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="">
        <span style="float:left;">Prepared By: {{ $userInfo->user_fullname }}</span> &nbsp; <span
            style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        {{-- <span style="float:right">Powered By: NEXTGEN IT</span> --}}

        
          <span style="float:right">Powered By: NEXTGEN IT</span>
        
    </div>
</footer>
@endif

