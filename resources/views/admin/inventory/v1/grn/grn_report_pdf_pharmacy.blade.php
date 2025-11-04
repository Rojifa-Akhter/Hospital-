
<style>
    table tr {
        border-bottom: none;
    }

    /* @media print {
    .signature {
            page-break-inside: avoid;
        }
    } */
    .signature{
      height:100px;
      width: 100%;
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
        height: 3cm;
        text-align: center;
        bottom: -100px;
        padding-top: 10px;
    }

    body {
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 15px;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr td,
    table tr th {
        font-size: 12px;
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
</style>

{{-- @dd($grn_report_list); --}}


<div class="form-content">
    <div class="form-heading border-bottom pb-3" style="">
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
                    <li><b>isPosted:
                        </b>&nbsp;<span>
                            {{!empty($grn_report_list[0]->rcv_save_option) ? $grn_report_list[0]->rcv_save_option : ''   }}</span>
                    </li>

                    @if(!empty($grn_report_list[0]->au_update_at))
                    <li><b>Post Date:
                        </b>&nbsp;<span>
                            {{!empty($grn_report_list[0]->au_update_at) ?date('d/m/Y', strtotime($grn_report_list[0]->au_update_at)) : ''   }}</span>
                    </li>
                    @endif
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

    @php
        $hasFreeQty = false;
        foreach($grn_report_list as $item) {
            if($item->freeitem_qty > 0) {
                $hasFreeQty = true;
                break;
            }
        }
    @endphp

    <div class="form-body" style="margin-top: 30px">
        <table class="table table-bordered mt-3" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:4% !important;">#SL</th>
                    @if($hasFreeQty == true)
                    <th class="text-left" style="width:4% !important;">PR No</th>
                    @else
                    <th class="text-left" style="width:8% !important;">PR No</th>
                    @endif
                    @if($hasFreeQty == true)
                    <th class="text-center" style="width:8% !important;">Item Id</th>
                    @else
                    <th class="text-center" style="width:10% !important;">Item Id</th>
                    @endif
                    @if($grn_report_list[0]->pharmacy_ind == 1)
                    <th class="text-left" style="width:15% !important;">Item Name</th>
                    @else
                    <th class="text-left" style="width:25% !important;">Item Name</th>
                    @endif
                    @if($grn_report_list[0]->pharmacy_ind == 1)
                        <th class="text-left" style="width:15%">Generic Name</th>
                    @endif                   
                    <th class="text-center" style="width:6% !important;;white-space: normal">Batch No</th>
                    <th class="text-center" style="width:6% !important;">Exp. Date</th>
                    <th class="text-center" style="width:6% !important;">UoM</th>
                    <th class="text-center" style="width:6% !important;">Rece. Qty.</th>
                    @if($hasFreeQty == true)
                    <th class="text-center" style="width:4% !important;">Free Qty.</th>
                    @endif
                    @if($hasFreeQty == true)
                    <th class="text-center" style="width:6% !important;">Total Qty.</th>
                    @endif
                    <th class="text-right" style="width:8% !important;">Unit Price({{ !empty($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : 'Tk'}})</th>
                    <th class="text-right" style="width:12% !important;">Amt.({{ !empty($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : 'Tk'}})</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $totals = 0;
                    $currency_rate = 1;
                @endphp
              
                @isset($grn_report_list[0]->currency_rate)
                    @php $currency_rate = !empty($grn_report_list[0]->currency_rate) ? $grn_report_list[0]->currency_rate : 1 ; @endphp
                @endisset
                @if (isset($grn_report_list))
                    @forelse ($grn_report_list as $value)
                        @php
                            $free_qty = $value->freeitem_qty != '' ? $value->freeitem_qty : 0;
                            $unit_price = (!empty($value->unit_price) ? $value->unit_price : 0 );// / $currency_rate;
                            $amount = (!empty($value->amount) ? $value->amount : 0 );// / $currency_rate;
                            $conv_qty = !empty($value->pr_uom_conversion_qty) ? $value->pr_uom_conversion_qty : 1;

                        @endphp
                  
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $value->inv_requisitiondtl_no_pk =="" ? $value->inv_requisitionmst_po_no_pk :$value->inv_requisitiondtl_no_pk}}</td>
                            <td class="text-center">{{ $value->item_no_fk }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            @if($value->pharmacy_ind == 1)
                             <td class="text-left">{{ $value->generic_name }}</td>
                            @endif
                            <td class="text-center">{{ $value->batch_no }}</td>
                            <td class="text-center">
                                @if(!empty($value->expiry_date))
                                    {{date('d/m/Y', strtotime($value->expiry_date))}} 
                                @endif
                            </td>
                            <td class="text-center">{{ $value->uom_name }}<br>({{$conv_qty}})</td>
                            <td class="text-center">{{ number_format(($value->delivered_qty / $conv_qty), 2) }}</td>
                            @if($hasFreeQty == true)
                            <td class="text-center">{{ $value->freeitem_qty / $conv_qty}}</td>
                            @endif
                            @if($hasFreeQty == true)
                            <td class="text-center">{{ $value->total_qty / $conv_qty}}</td>
                            @endif
                            <td class="text-right"> {{ number_format(($unit_price * $conv_qty), 2)  }}</td>
                            <td class="text-right">{{ !empty($value->delivered_qty) ? number_format($amount, 2) : '' }}</td>
                        </tr>
                        @php $totals += $amount; @endphp
                        @empty
                        <tr>
                            <td colspan="12" style="text-align:center;color:red">You have no data</td>
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
                    @if($hasFreeQty == true)
                    <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                    @else
                    <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                    @endif
                    <td class="text-right" colspan="{{3 +$col_no}}" style="border:0px; padding: 2px !important;"><strong>Total :</strong></td>
                    <td class="text-right" colspan="2" style=" border:0px; padding: 2px !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($totals, 2)}}</strong></td>
                </tr>
               
                @if(isset($grn_report_list[0]->currency_sign) &&  strtoupper($grn_report_list[0]->currency_sign) !='TK')
              
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 +$col_no}}" style="border:0px; padding: 2px !important;"><strong>Total :</strong></td>
                        <td class="text-right" colspan="2" style=" border:0px; padding: 2px !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? 'Tk' : '' }} {{number_format($totals*$currency_rate, 2)}}</strong></td>
                    </tr>
                @endif
                
                @if($vat_amount > 0)
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Total VAT/Tax </strong>({{number_format($vat_percent, 2) }}%):</td>
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($vat_amount, 2)}}</strong></td>
                    </tr>
                @endif

                @if($ait_amount > 0)
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
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
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"> <strong> {{isset($grn_report_list[0]->currency_sign) ? 'Tk' : '' }} {{number_format($sc_amount, 2)}}</strong></td>
                    </tr>
                @endif

                @if($discount_amount > 0)
                    <tr>
                        @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                        <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Total Discount </strong>({{ number_format($discount_percent, 2) }}%):</td>
                        <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;"><strong>{{isset($grn_report_list[0]->currency_sign) ? $grn_report_list[0]->currency_sign : '' }} {{number_format($discount_amount, 2)}}</strong></td>
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
                    @if($hasFreeQty == true)
                        <td class="" colspan="7" style="border:0px; padding: 2px !important;"></td>
                        @else
                        <td class="" colspan="5" style="border:0px; padding: 2px !important;"></td>
                        @endif
                    <td class="text-right" colspan="{{3 + $col_no}}" style="border:0px; padding: 2px !important;"><strong>Net Payable :</strong></td>
                    <td class="text-right" colspan="2" style="border:0px; padding: 2px !important;">
                        @php $total_payable = floatval($totals*$currency_rate) + floatval($vat_amount) + floatval($sc_amount) + floatval($ait_amount)- ($adj_amt + $discount_amount) ;@endphp
                        <strong>{{isset($grn_report_list[0]->currency_sign) ? 'Tk' : '' }} {{number_format($total_payable, 2)}}</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="10" style="text-align: left; border:0px;">
                    @php
                        $number = number_format($total_payable, 2, '.', '');
                        $integer_part = floor($total_payable);
                        $decimal_part = $total_payable - $integer_part;
                        $decimal_part_str = rtrim(rtrim(number_format($decimal_part, 2), '0'), '.');
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
                        <strong>In Word :</strong>{{ ucwords($in_words) }} Tk
                        {{-- {{isset($grn_report_list[0]->currency_name) ? $grn_report_list[0]->currency_name : 'Tk'}}  --}}
                        Only
                    </td>
                </tr>
                @if(!empty($grn_report_list[0]->remarks))
                <tr>
                    <td colspan="10" style="text-align: left; border:0px;">
                        <strong>Remarks :</strong> {{isset($grn_report_list[0]->remarks) ? $grn_report_list[0]->remarks : ''}} 
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>




    <div class="signature">
        <table style="width: 100%; border:none">
            <tbody>
                <tr>
                    <td style="text-align:left;"><span style="padding:5px;">Prepared by</span></td>
                    <td style="text-align:center;"><span style="padding:5px;">Checked by</span></td>
                    <td style="text-align:right;"><span style="padding:5px; padding-right:50px">HOD</span></td>
                </tr>
            </tbody>
        </table>


        <table style="width: 100%; " class="second-class">
            <tbody>
                <tr>
                    <td style="text-align:left; ">
                        <span style="padding:5px; border-top: black solid 1px;">{{ !empty($grn_report_list[0]->user_fullname_entry_by) ? $grn_report_list[0]->user_fullname_entry_by : '' }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="padding:5px; border-top: black solid 1px;">Signature & Date</span>
                    </td>
                    <td style="text-align:right; ">
                        <span style="padding:5px; border-top: black solid 1px;">Signature & Date</span>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>



<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <div style="border-top: 1px solid black;">
        <table>
            <tbody>
                <tr>
                    <td style="text-align:left; font-size: 9px;">
                        <span>Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
                    </td>
                    <td style="text-align:right; font-size: 9px;">
                        <span>Powered By: NEXTGEN IT</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</footer>
