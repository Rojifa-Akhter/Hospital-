
<style>
    @page {
        margin: 0;
        padding: 0;
        font-family: 'Courier New';

    }
    body {
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 15px;
        font-family: 'Courier New';
        font-size: 15px;
        /* margin-bottom: 1cm; */
    }

    /* Add these rules for explicit font application */
    h1, p, strong, span, li, b, table, td, th {
        font-family: 'Courier New' !important; /* !important ensures it overrides other rules */
    }

    /* Your existing table and other styles */
    table tr {
        border-bottom: none;
    }

    .signature{
        height:100px;
        width: 100%;
        top: 20px;
        position: relative;
    }
    .AccInfo{
        height:auto;
        width: 60%;
        top: 40px;
        position: relative;
    }
    .second-class{
        position: absolute;
        top:80px;
    }

    footer {
        position: fixed;
        z-index: 999;
        left: 0;
        right: 0;
        height: 1cm; /* Adjust height based on content + page number */
        text-align: center; /* This centers the overall footer content */
        bottom: 0; /* Ensures it's at the very bottom of the page */
        padding-top: 10px;
        /* border-top: 1px solid black; */
        font-family: 'Courier New' !important;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr td,
    table tr th {
        font-size: 15px;
        border: 0;
        padding: 2px;
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

    .form-heading p {
        font-size: .8rem;
        margin-top: -10px;
    }
    .mb-1 {
        margin-bottom: 7px;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
    }
    .table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        word-wrap: break-word;
        page-break-inside: auto;
    }
    .page-number:before {
    content: counter(page);
    font-size: 15px;
    font-family: 'Courier New' !important;
    float: right;
    margin-right: 0.3cm;
}
</style>

{{-- @dd($grn_report_list); --}}


<div class="form-content">
    {{-- <div class="form-heading border-bottom pb-3 text-center" style="">
        <div id="logo" style="display:inline-block !important; ">
            @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
            @endif
        </div>
        <div style="display:inline-block !important; ">
            <h1 class="mb-1">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
            <p class="mb-1">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
            <p class="mb-1">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
        </div>
    </div> --}}

    @if(!empty($po_hospital_details))
    <header style="margin-bottom: 10px;">
        <table style="margin-bottom: 5px;">
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}"
                            width="80" alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 25px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                    </div>

                </td>
            </tr>
        </table>


    </header>
    <hr/>
    @endif

    <div class="heading text-center">
        <strong>Goods Receive Note</strong>
    </div>

    <div class="" style="border-top: 1px dotted #5e5e5f; height: 130px; padding: 10px; margin-top: 10px;">
        <div class="patient-information d-flex align-items-center">
            <div class="text-left">
                <ul style="list-style: none; padding-left: 0;">
                    <li><b>Received Department :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->department) ? ucfirst($grn_report_list[0]->department) : '' }}</span>
                    </li>
                    <li><b>PO/INV No :</b>&nbsp;
                        <span>{{ !empty($grn_report_list[0]->challan_no) ? $grn_report_list[0]->challan_no : '' }}</span>
                    </li>
                    <li><b>Supplier :</b>&nbsp;
                        {{ !empty($grn_report_list[0]->supplier_name) ? $grn_report_list[0]->supplier_name : '' }}</span>
                    </li>
                    <li><b>Despatch Person :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->user_fullname_entry_by : '' }}</span>
                    </li>
                    <li><b>Status :</b>&nbsp;
                        <span>{{!empty($grn_report_list[0]->rcv_save_option) ? $grn_report_list[0]->rcv_save_option : ''   }}</span>
                    </li>
                    <li><b>Remarks :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->remarks) ? $grn_report_list[0]->remarks : '' }}</span>
                    </li>
                </ul>
            </div>
            {{-- @dd($grn_report_list); --}}

            <div class="text-right">
                <ul style="list-style: none; padding-left: 0;">

                    {{-- <li>
                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                    </li> --}}
                    {{-- <li><b>isPosted:
                        </b>&nbsp;<span>
                            {{!empty($grn_report_list[0]->rcv_save_option) ? $grn_report_list[0]->rcv_save_option : ''   }}</span>
                    </li> --}}

                    {{-- @if(!empty($grn_report_list[0]->au_update_at))
                    <li><b>Post Date:
                        </b>&nbsp;<span>
                            {{!empty($grn_report_list[0]->au_update_at) ?date('d/m/Y', strtotime($grn_report_list[0]->au_update_at)) : ''   }}</span>
                    </li>
                    @endif --}}
                    <li><b>Goods Receive No:</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->itemreceive_uid) ? $grn_report_list[0]->itemreceive_uid : '' }}</span>
                    </li>
                    <li><b>Purchase Order No:</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->purchase_uid) ? $grn_report_list[0]->purchase_uid : '' }}</span>
                    </li>

                    <li><b>Received Date:</b>&nbsp;<span>
                            {{ date('d/m/Y', strtotime($grn_report_list[0]->receive_date)) }}</span>
                    </li>
                    <li><b>Time :</b>&nbsp;<span>
                            {{ date('h:i A', strtotime($grn_report_list[0]->receive_date)) }}</span>
                    </li>
                    {{-- <li><b>Challan No
                            :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->challan_no) ? $grn_report_list[0]->challan_no : '' }}</span>
                    </li> --}}
                    <li><b>Delivery Date
                            :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->challan_date) ? date("d/m/Y", strtotime($grn_report_list[0]->challan_date)) : '' }}</span>
                    </li>
                    <li><b>Checked Date
                            :</b>&nbsp;<span>
                            {{ !empty($grn_report_list[0]->challan_date) ? date("d/m/Y", strtotime($grn_report_list[0]->challan_date)) : '' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @php
        $hasFreeQty = false;
        foreach($grn_report_list as $item) {
            if($item->freeitem_qty > 0) {
                $hasFreeQty = true;
                break;
            }
        }
    @endphp

    <div class="form-body" style="margin-top: 3px">
        <table class="table" style="width:100% ; margin: 0px !important;">
            <thead>
                <tr style="border-top:1px dotted black !important; border-bottom:1px dotted black !important;">
                    <th class="text-left" style="width:8% !important; border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Type</th>
                    <th class="text-left" style="width:10% !important; border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Item</th>
                    <th class="text-center" style="width:8% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important; white-space: normal">UOM</th>
                    <th class="text-right" style="width:10% !important; border-top:1px dotted black !important; border-bottom:1px dotted black !important;">QTY</th>
                    {{-- <th class="text-center" style="width:6% !important;">UoM</th> --}}
                    {{-- @if($hasFreeQty == true)
                    <th class="text-center" style="width:4% !important;">Free Qty.</th>
                    @endif
                    @if($hasFreeQty == true)
                    <th class="text-center" style="width:6% !important;">Total Qty.</th>
                    @endif --}}
                    <th class="text-right" style="width:10% !important; border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Unit Price</th>
                    <th class="text-right" style="width:15% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Amount</th>
                    <th class="text-right" style="width:8% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Disc Amount</th>
                    <th class="text-right" style="width:8% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Tax Amount</th>
                    <th class="text-right" style="width:15% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Net Amount (RM)</th>
                    <th class="text-center" style="width:8% !important;border-top:1px dotted black !important; border-bottom:1px dotted black !important;">Expiary Dt.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totals = 0;
                    $Netamounts = 0;
                    $NetDiscount = 0;
                    $NetDiscountAvr = 0;
                    $currency_rate = 1;
                @endphp

                @isset($grn_report_list[0]->currency_rate)
                    @php $currency_rate = !empty($grn_report_list[0]->currency_rate) ? $grn_report_list[0]->currency_rate : 1 ; @endphp
                @endisset
                {{-- @dd($grn_report_list); --}}
                @if (isset($grn_report_list))
                    @forelse ($grn_report_list as $value)
                        @php
                            $free_qty = $value->freeitem_qty != '' ? $value->freeitem_qty : 0;
                            $unit_price = (!empty($value->unit_price) ? $value->unit_price : 0 );// / $currency_rate;
                            $amount = (!empty($value->amount) ? $value->amount : 0 );// / $currency_rate;
                            $conv_qty = !empty($value->pr_uom_conversion_qty) ? $value->pr_uom_conversion_qty : 1;
                            $Netamount = (!empty($value->amount) ? ($value->amount + $value->ait_amount_itm)-$value->discount_amount_itm  : 0 );

                        @endphp

                        <tr>
                            <td class="text-left">{{ $value->item_type}}</td>
                            <td class="text-left">{{ $value->item_code }}</td>
                            {{-- <td class="text-left">{{ $value->item_name }}</td> --}}
                            <td class="text-center">{{ $value->uom_name }}</td>
                            {{-- <td class="text-center">{{ $value->uom_name }}<br>({{$conv_qty}})</td> --}}
                            <td class="text-right">{{ number_format(($value->delivered_qty / $conv_qty), 2) }}</td>

                            {{-- @if($hasFreeQty == true)
                            <td class="text-center">{{ $value->freeitem_qty / $conv_qty}}</td>
                            @endif --}}
                            {{-- @if($hasFreeQty == true)
                            <td class="text-center">{{ $value->total_qty / $conv_qty}}</td>
                            @endif --}}
                            <td class="text-right"> {{ number_format(($unit_price * $conv_qty), 2)  }}</td>
                            <td class="text-right">{{ !empty($value->delivered_qty) ? number_format($amount, 2) : '' }}</td>
                            <td class="text-right">{{ $value->discount_amount_itm}}</td>
                            <td class="text-right">{{ $value->ait_amount_itm}}</td>
                            <td class="text-right">{{ !empty($value->delivered_qty) ? number_format($Netamount, 2) : '' }}</td>
                            <td class="text-center"> {{ !empty($value->expiry_date) ? date('d/m/Y', strtotime($value->expiry_date)) : ''}} </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-left">{{ $value->generic_name }} {{ $value->item_name }}</td>
                            <td colspan="1" class="text-right">{{ $value->discount_percent_itm}}%</td>
                            <td colspan="1" class="text-right">{{ $value->ait_percent_itm}}%</td>
                            <td colspan="2" class="text-right"></td>
                            {{-- <td colspan="4" class="text-left"></td> --}}
                        </tr>
                        @php
                        $totals += $amount;
                        $Netamounts +=$Netamount;
                        $NetDiscount += $value->discount_percent_itm;
                        $NetDiscountAvr =  $NetDiscount>0 ? $NetDiscount/count($grn_report_list):0;
                        @endphp
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center;color:red">You have no data</td>
                        </tr>
                    @endforelse
                @endif

                @php
                    $vat_percent = isset($grn_report_list[0]->vat_percent) ? $grn_report_list[0]->vat_percent : 0;
                    $vat_amount = isset($grn_report_list[0]->vat_amount) ? $grn_report_list[0]->vat_amount : 0;
                    $vat_amount = $vat_amount ;//* $currency_rate;
                    $discount_percent = isset($grn_report_list[0]->discount_percent) ? $grn_report_list[0]->discount_percent : 0;
                    $discount_amount = isset($grn_report_list[0]->discount_amount) ? $grn_report_list[0]->discount_amount : 0;
                    $discount_amount = $discount_amount * $currency_rate;

                    $ait_percent = isset($grn_report_list[0]->ait_percent) ? $grn_report_list[0]->ait_percent : 0;
                    $ait_amount = isset($grn_report_list[0]->ait_amount) ? $grn_report_list[0]->ait_amount : 0;
                    $ait_amount = $ait_amount ;//* $currency_rate;

                    $sc_percent = isset($grn_report_list[0]->service_charge_percent) ? $grn_report_list[0]->service_charge_percent : 0;
                    $sc_amount = isset($grn_report_list[0]->service_charge_amount) ? $grn_report_list[0]->service_charge_amount : 0;
                    $sc_amount = $sc_amount ;//* $currency_rate;
                    $col_no= $grn_report_list[0]->pharmacy_ind == 1 ? 1:0;
                @endphp

                <tr>
                    <td class="text-right" colspan="3" style="border-top:1px dotted black !important;"></td>
                    <td class="text-right" colspan="2" style="border-top:1px dotted black !important;"><strong>SubAmount :</strong></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($totals, 2)}}</strong></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;">{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($discount_amount, 2)}}</td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;">{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($discount_amount, 2)}}</td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($Netamounts, 2)}}</strong></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;"></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5"><strong>Amount Discount :</strong></td>
                    <td class="text-right" colspan="1"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($discount_amount, 2)}}</strong></strong></td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right" colspan="1"></td>
                    <td class="text-right" colspan="1"></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5"><strong>Parcentage of Discount :</strong></td>
                    <td class="text-right" colspan="1"><strong>{{number_format($NetDiscountAvr, 2)}}%</strong></strong></td>
                    <td class="text-right" colspan="2"></td>
                    <td class="text-right" colspan="1"></td>
                    <td class="text-right" colspan="1"></td>
                </tr>
{{-- @dd(count($grn_report_list)); --}}
                @if(isset($grn_report_list[0]->currency_sign) &&  strtoupper($grn_report_list[0]->currency_sign) !='TK')

                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 +$col_no}}" style="border:0px; padding: 2px !important;"><strong>Total :</strong></td>
                        <td class="text-right" colspan="2" style=" border:0px; padding: 2px !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? 'TK' : '' }} {{number_format($totals*$currency_rate, 2)}}</strong></td>
                    </tr>
                @endif

                @if($vat_amount > 0)
                    <tr>
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Total VAT/Tax </strong>({{number_format($vat_percent, 2) }}%):</td>
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($vat_amount, 2)}}</strong></td>
                    </tr>
                @endif

                @if($ait_amount > 0)
                    <tr>
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Total AIT </strong>({{number_format($ait_percent, 2)}}%):</td>
                        {{-- <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($ait_amount, 2)}}</strong></td> --}}
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong>{{number_format($ait_amount, 2)}}</strong></td>
                    </tr>
                @endif

                @if($sc_amount > 0)
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 + $col_no}}" style="white-space:nowrap; border:0px; padding: 2px !important;"><strong>Others LC Cost </strong>({{ number_format($sc_percent, 2) }} %):</td>
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong> {{isset($grn_report_list[0]->currency_sign) ? 'TK' : '' }} {{number_format($sc_amount, 2)}}</strong></td>
                    </tr>
                @endif
                @php $adj_amt = isset($return_adj_amt) ? round($return_adj_amt->adjustment_amount) : 0; @endphp
                @if(isset($return_adj_amt))
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Adjustment Amt. :</strong></td>

                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($adj_amt, 2)}}</strong></td>
                    </tr>
                @endif

                <tr>
                    @php $total_payable = floatval($totals*$currency_rate) + floatval($vat_amount) + floatval($sc_amount) + floatval($ait_amount)- ($adj_amt + $discount_amount) ;@endphp
                    <td class="text-right" colspan="5" style="border-top:1px dotted black !important; border-bottom:1px dotted black !important; "><strong>Total Amount :</strong></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important; border-bottom:1px dotted black !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? 'TK' : '' }} {{number_format($total_payable, 0)}}</strong></strong></td>
                    <td class="text-right" colspan="2" style="border-top:1px dotted black !important;border-bottom:1px dotted black !important; "></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;border-bottom:1px dotted black !important; "></td>
                    <td class="text-right" colspan="1" style="border-top:1px dotted black !important;border-bottom:1px dotted black !important; "></td>
                </tr>
{{--
                <tr>
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                    <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Net Payable :</strong></td>
                    <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;">
                        @php $total_payable = floatval($totals*$currency_rate) + floatval($vat_amount) + floatval($sc_amount) + floatval($ait_amount)- ($adj_amt + $discount_amount) ;@endphp
                        <strong>{{isset($grn_report_list[0]->currency_sign) ? 'Tk' : '' }} {{number_format($total_payable, 2)}}</strong>
                    </td>
                </tr> --}}

                <tr>
                    <td colspan="10" style="text-align: left; border:0px;">
                    @php
                        $number = number_format($total_payable, 0, '.', '');
                        $integer_part = floor($total_payable);
                        $decimal_part = $total_payable - $integer_part;
                        $decimal_part_str = rtrim(rtrim(number_format($decimal_part, 0), '0'), '.');
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $integer_in_words = numfmt_format($fmt, $integer_part);
                        $decimal_in_words = '';
                        if ($decimal_part_str != '0') {
                            $decimal_in_words = numfmt_format($fmt, (int)$decimal_part_str);
                        }
                        if ($decimal_in_words) {
                            $in_words = $integer_in_words ; //. ' and ' . $decimal_in_words
                        } else {
                            $in_words = $integer_in_words;
                        }

                    @endphp
                        <strong>In Word :</strong>{{ ucwords($in_words) }} Taka
                        {{-- {{isset($grn_report_list[0]->currency_name) ? $grn_report_list[0]->currency_name : 'Tk'}}  --}}
                        Only
                    </td>
                </tr>
                <tr>
                        <td colspan="5" style="text-align: left; border:0px;">
                        <strong>Received By:</strong> <span>{{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->received_by : '' }}</span>
                        <td colspan="5" style="text-align: left; border:0px;">
                        <strong>Checked By:</strong> <span>{{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->user_fullname_entry_by : '' }}</span>
                    </div>

                </tr>
                {{-- @if(!empty($grn_report_list[0]->remarks))
                <tr>
                    <td colspan="10" style="text-align: left; border:0px;">
                        <strong>Remarks :</strong> {{isset($grn_report_list[0]->remarks) ? $grn_report_list[0]->remarks : ''}}
                    </td>
                </tr>
                @endif --}}
            </tbody>
        </table>
    </div>
</div>

{{-- <span style="padding:5px; border-top: black solid 1px;">{{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->user_fullname_entry_by : '' }}</span> --}}

    <div class="signature">
        <table style="width: 100%; border:none">
            <tbody>
                <tr>
                    <td style="text-align:left;"><span style="padding:5px;">Posted By</span></td>
                    <td style="text-align:center;"><span style="padding:5px;">Certified By</span></td>
                    {{-- <td style="text-align:right;"><span style="padding:5px; padding-right:50px">HOD</span></td> --}}
                </tr>
            </tbody>
        </table>


        <table style="width: 100%; " class="second-class">
            <tbody>
                <tr>
                    <td style="text-align:left; ">
                        <span style="padding:5px; border-top: black dotted 1px;">Signature & Date</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="padding:5px; border-top: black dotted 1px;">Signature & Date</span>
                    </td>
                    {{-- <td style="text-align:right; ">
                        <span style="padding:5px; border-top: black solid 1px;">Signature & Date</span>
                    </td> --}}
                </tr>
            </tbody>
        </table>
    </div>

    <div class="AccInfo">
        <table style="width: 100%; border:none">
            <thead>
                <thead>
                <tr>
                    <th class="text-left" style="width:10% !important;  border-bottom:1px dotted black !important;">Dr/Cr</th>
                    <th class="text-left" style="width:15% !important;  border-bottom:1px dotted black !important;">GL Acc</th>
                    <th class="text-left" style="width:30% !important; border-bottom:1px dotted black !important;">Description</th>
                    <th class="text-left" style="width:20% !important; border-bottom:1px dotted black !important;">Cost Code</th>
                    <th class="text-right" style="width:25% !important; border-bottom:1px dotted black !important;">Amount</th>
                </tr>
            </thead>
            </thead>
            <tbody>
                @if (count($ae_grn) > 0)
                    <tr>
                        <td class="text-left">{{ 'Dr' }}</td>
                        <td class="text-left">{{ $ae_grn[0]->account_code }}</td>
                        <td class="text-left">{{ $ae_grn[0]->account_name }}</td>
                        <td class="text-left">{{ $ae_grn[0]->subledger_code }}</td>
                        <td class="text-right">{{ number_format($ae_grn[0]->trn_dr_account_amount, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-center">No data available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>



<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <div style="border-top: 1px dotted black;">
        <table>
            <tbody>
                <tr>
                    <td style="text-align:left; font-size: 15px;">
                        <span>Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
                    </td>

                    <td style="text-align:left; font-size: 15px;"><span>Page no : </span></td>
                    <td style="text-align:right; font-size: 15px;"><span class="page-number"></span> </td>
                    {{-- <td style="text-align:right; font-size: 9px;">
                        <span>Powered By: NEXTGEN IT</span>
                    </td> --}}
                </tr>
            </tbody>
        </table>
    </div>
</footer>
