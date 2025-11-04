<style>
    @page{
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: .2cm;
            margin-right: 0.2cm;
            /* height: 29.7cm;
            width: 21cm; */
        }
    @media print {
    .unico {
            page-break-inside: avoid !important;
        }
    }
    header {
            position: fixed;
            top: 0;
            height: 2.3cm;
            font-family: 'Courier New', Courier, monospace;
            /* border-bottom: 1px solid; */
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/

        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            /* font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif'; */
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
        }

    table{
            border-collapse: collapse;
            width: 100%;
        }

    td,th{
            padding: 2px !important;
        }

    .unico {
        position: relative;
        width: 100%;
        top: 0px;
        height: 125px !important;
    }

    .signature {
            position: absolute;
            width: 100%;
            z-index: 999999999;
            text-align: center;
            font-size: 9px;
            top: 15px;
        }

    .report-header{
            text-align: center;
            margin: 0 auto;
            border:1px solid #000000;
            padding: 5px;
            width: 20%;
            font-size:15px;
            border-radius: 15px;
            background-color:#E9E8E8;
        }

    .text-center{
            text-align: center;
        }
    .text-left{
            text-align: left;
        }
    .text-right{
            text-align: right;
        }

    .border-0{
            border: 0px;
        }

    .pt-5{
            padding-top: 20px
        }
</style>
@if(!empty($po_hospital_details))
    <header style="margin-bottom: 10px;">
        <table style="margin-bottom: 5px;">
            <tbody>
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
            </tbody>

        </table>
    </header>
    <hr/>
    @endif

<!-- Header Section -->
<section style="padding-bottom: 0px;">
        <div style="text-align: center; padding-bottom: 3px !important;">

            <table style="margin-top: 3px !important; margin-bottom: 3px;">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: right; padding-top:5px; width:60%;">
                            <strong style="display: block; text-align: right; font-size: 17px;">Purchase Order</strong>
                        </td>
                        <td colspan="2" style="text-align: right; padding-top:5px; width:40%;">
                        <div style="text-align: right;">
                                <img src="data:image/png;base64, {{ $invoice_barcode }}" alt="Barcode" /><br>
                                <strong>{{ $po_master_info->purchase_uid }}</strong>
                        </div>
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    <div style="border-top: 1px solid rgb(63, 63, 63) !important;">
        <table style="margin-top: 5px !important; margin-bottom: 5px;">
            <tbody>
                <tr>
                    <td style="text-align: left;width:60%">
                        {{-- @if($po_master_info->reference_no !="")
                            <strong>Ref:</strong> {{ $po_master_info->reference_no }}<br><br>
                        @endif --}}
                        @if($po_master_info->supplier_name !="")
                            <strong>SUPPLIER :</strong> {{ strtoupper($po_master_info->supplier_name) }} <br>
                        @endif
                        <span style="padding-left: 0px !important;">
                            @if($po_master_info->addr1 !="")
                            <strong>ADDRESS :</strong> {{ $po_master_info->addr1 }}<br>
                        </span>

                        @endif
                        <strong>Fax No   :</strong> {{ $po_master_info->fax }}<br>
                        <strong>Tel. No  :</strong> {{ $po_master_info->mobile1 }}<br>
                        {{-- @if($po_master_info->refer_contact_name !="")
                            <strong>Attention :</strong> {{ $po_master_info->refer_contact_name }}<strong> Cell:</strong> {{ $po_master_info->refer_contact_mobile }}<br>
                        @endif --}}
                        {{-- @if($po_master_info->refer_contact_email !="")
                            <strong> Email:</strong> {{ $po_master_info->refer_contact_email }}<br>
                        @endif --}}

                    </td>
                    <td style="text-align: right;width: 40%;">
                        {{-- <img src="data:image/png;base64, {{ $invoice_barcode }} "/><br> --}}
                        {{-- <strong>Supplier Code:</strong> {{ $po_master_info->purchase_uid }}<br> --}}
                        {{-- <strong>PO ID:</strong> {{ $po_master_info->purchase_uid }}<br> --}}
                        <strong>SUPPLIER CODE :</strong> {{ $po_master_info->supplier_uid }}<br>
                        <strong>PO NO :</strong> {{ $po_master_info->purchase_uid }}<br>
                        <strong>PO Type :</strong>@if(@$po_master_info->pharmacy_ind == 1) Phst  @else Pur @endif<br>
                        <strong>Order Date :</strong>{{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                        {{-- <strong>PO By: </strong> {{ $po_master_info->created_by }}<br> --}}
                        {{-- @if($po_master_info->quotation_ref != "")
                        <strong>Quotation Ref :</strong>{{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}<br>
                        @endif --}}
                        {{-- @if(!empty(@$po_master_info->review_no))
                            <strong>Review Version: </strong>{{ str_pad(@$po_master_info->review_no, 2, '0', STR_PAD_LEFT)}}<br>
                        @endif --}}
                    </td>
                </tr>
                {{-- @if($po_master_info->reference_sub !="")
                <tr>
                    <td colspan="2" style="text-align: left; padding-top:5px">
                        <strong> Subject : </strong> {{ $po_master_info->reference_sub }}<br>
                    </td>
                </tr>
                @endif --}}

            </tbody>
        </table>
    </div>
    <div style="border-top: 1px solid rgb(63, 63, 63); border-bottom: 1px solid rgb(63, 63, 63); !important; margin-top: 3px;">
        <table style="margin-top: 3px !important; margin-bottom: 3px;">
            <tbody>
                <tr>
                    <td style="text-align: left;width:60%">
                        <strong>Delivery To :</strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}<br>
                        <strong>Receiving Area:</strong> @if(@$po_master_info->pharmacy_ind == 1) Pharmacy Store  @else Purchase Store @endif<br>
                    </td>
                    <td style="text-align: right;width: 40%;">
                        <strong>Expected Date : </strong> {{ \Carbon\Carbon::parse($po_master_info->delivery_date)->format('d/m/y') }}<br>
                        <strong>Payment Terms :</strong> {{0}} days

                    </td>
                </tr>
            </tbody>

        </table>
    </div>


   @if($po_master_info->reference_sub !="")
    <div style="padding-top: 3px !important;">
        <table style="margin-top: 3px !important; margin-bottom: 3px;">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: left; padding-top:5px">
                        <strong> Subject : </strong> {{ $po_master_info->reference_sub }}<br>
                    </td>
                </tr>
            </tbody>


        </table>
    </div>



    @if($po_master_info->reference_sub_body !="")
    <table style="margin-top: 0px; width:100%">
        <tr>
            <td style="text-align: left;"> {!! isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : '' !!}</td>
        </tr>
    </table>
    @endif

    @endif
</section>

<!-- Table Body Section -->
<section>
    <table class="" style="margin-top: 0px; width:100%">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black;">
            <tr>
                <th class="text-center" style="width:8%">Line No</th>
                <th class="text-center" style="width:8%">Type</th>
                <th class="text-left" style="width:15%">Item</th>
                <th class="text-center" style="width:10%"> Packing Type</th>
                <th class="text-center" style="width:8%">Qty</th>
                <th class="text-right" style="width:12%" > Unit Price @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
                <th class="text-right" style="width:15%" > Amount @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
                <th class="text-right" style="width:8%" > Disc @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
                <th class="text-right" style="width:16%">Net Amount @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
            </tr>
        </thead>
        <tbody>
            @php
                $dollar_rate = 0;
                $total_dollar_rate = 0;
                $TNetPrice = 0;
                $total = 0;
                $total_disc = 0;
                $duplicate = [];

            @endphp
                @foreach (collect($po_child_details_info)->groupBy('item_no_pk')->toArray() as $value)
                    @php  $value = (object) $value[0];  @endphp

                    @if(count(collect($po_child_details_info)->where('item_no_pk',$value->item_no_pk)->toArray()) > 1)

                        @php
                            $dollar_rate = 0;
                            $total_dollar_rate = 0;
                            $qty = 0;
                            $requistion = '';
                            $NetPrice = 0;
                        @endphp

                        @foreach (collect($po_child_details_info)->where('item_no_pk',$value->item_no_pk)->toArray() as $keys=>$item)
                            @php
                                $qty+= $item->entry_qty;
                                $dollar_rate = $item->dollar_rate != '' ? $item->item_rate / $item->dollar_rate : $item->item_rate;
                                $total_dollar_rate += $item->dollar_rate != '' ? ($item->item_rate / $item->dollar_rate) * $item->entry_qty : $item->entry_qty * $item->item_rate;
                                $NetPrice = $total_dollar_rate - ($item->discount_percent_itm != '' ? $item->discount_percent_itm : 0);

                                if($keys == 0)
                                    $requistion.=  $item->item_requisition_no_fk;
                                else
                                 $requistion.=  ', '.$item->item_requisition_no_fk;
                           @endphp

                        @endforeach

                        @php $rate = $total_dollar_rate / $qty; @endphp

                        <tr>
                                <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $value->item_requisition_no_fk }}</td>
                                <td class="text-left">{{ $value->item_code }}</td>
                                {{-- <td class="text-left">{{ $value->refer_item_specification }}</td> --}}
                                {{-- <td class="text-left">
                                    @if(@$po_master_info->pharmacy_ind == 1) {{ $value->generic_name }}  @else {{ $value->refer_item_specification }} @endif
                                </td> --}}
                                <td class="text-center">{{ $value->uom_code }}</td>
                                <td class="text-center">{{ $value->entry_qty }} </td>
                                <td class="text-right">{{ number_format($dollar_rate, 2) }}</td>
                                <td class="text-right">{{ number_format($total_dollar_rate, 2) }}</td>
                                <td class="text-center">{{ number_format(($value->discount_amount_itm != '' ? $value->discount_amount_itm : 0),2) }}</td>
                                <td class="text-center">{{ number_format($NetPrice,2) }} </td>
                            </tr>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="6">{{$value->generic_name}} {{ $value->item_name }}</td>
                                <td colspan="1" >{{number_format($value->discount_percent_itm,2)}}{{'%'}}</td>
                                <td colspan="1"></td>
                            </tr>
                        @php
                            $total += $total_dollar_rate;
                            $total_disc += $value->discount_amount_itm
                        @endphp
                        @php
                            $TNetPrice = $total - $total_disc ;
                        @endphp

                    @else
                            @php
                                $dollar_rate = $value->dollar_rate != '' ? $value->item_rate / $value->dollar_rate : $value->item_rate;
                                $total_dollar_rate = $value->dollar_rate != '' ? ($value->item_rate / $value->dollar_rate) * $value->entry_qty : $value->entry_qty * $value->item_rate;
                            @endphp

                            <tr>
                                <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $value->item_type }}</td>
                                <td class="text-left">{{ $value->item_code }}</td>
                                <td class="text-center">{{ $value->uom_code }}</td>
                                <td class="text-center">{{ $value->entry_qty }} </td>
                                <td class="text-right">{{ number_format($dollar_rate, 2) }}</td>
                                <td class="text-right">{{ number_format($total_dollar_rate, 2) }}</td>
                                <td class="text-right">{{ number_format($value->discount_amount_itm,2) }}</td>
                                <td class="text-right">{{ number_format($total_dollar_rate,2) }} </td>
                            </tr>
                            <tr>
                               <td style="text-align: right; padding: 0; margin: 0;"></td>
                               <td colspan="6" style="padding: 0; margin: 0;">
                                    @if(!empty($value->generic_name) && !empty($value->refer_item_specification))
                                        {{ $value->generic_name }} - {{ $value->item_name }} ({{ $value->refer_item_specification }})
                                    @elseif(!empty($value->generic_name))
                                        {{ $value->generic_name }} - {{ $value->item_name }}
                                    @else
                                        {{ $value->item_name }}
                                        @if(!empty($value->refer_item_specification))
                                            ({{ $value->refer_item_specification }})
                                        @endif
                                    @endif
                                </td>
                                <td style="text-align: right; padding: 0; margin: 0;">
                                    {{ number_format($value->discount_percent_itm, 2) }}%
                                </td>
                                <td style="text-align: right; padding: 0; margin: 0;"></td>
                            </tr>
                            @php
                                $total += $value->dollar_rate != '' ? $value->entry_qty * ($value->item_rate / $value->dollar_rate) : $value->entry_qty * $value->item_rate;
                                $total_disc += $value->discount_amount_itm;
                                $TNetPrice =  $total - $total_disc;
                                $TNetPriceFormatted = number_format($TNetPrice, 2);
                            @endphp
                    @endif
                @endforeach

                <tr>
                    <td class="border-0 text-right" colspan="2"></td>
                    <td class="border-0 text-right bg-light" colspan="3"><strong>Amount:</strong></td>
                    <td class="border-0 text-right bg-light" style="border-top: 1px solid black;" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ number_format($total, 2) }}</strong></td>
                    <td class="border-0 text-right bg-light" style="border-top: 1px solid black;" colspan="1"></td>
                    <td class="border-0 text-right bg-light" style="border-top: 1px solid black;" colspan="1"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ $TNetPriceFormatted }}</strong></td>
                </tr>
                 <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0 text-right bg-light" colspan="3"><strong>Additional Discount:</strong></td>
                    <td class="border-0 text-right bg-light" style="border-top: 1px solid black;" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ number_format(0,2) }}</td>
                    <td class="border-0" style="border-top: 1px solid black;" colspan="2"></td>
                </tr>

                @if ($po_master_info->vat_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="3"><strong>Duty/Vat({{number_format($po_master_info->vat_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->vat_amount / $curr_rate, 2) : number_format($po_master_info->vat_amount, 2) }}</td>
                        <td class="border-0" colspan="2"></td>
                    </tr>
                @endif


                @if ($po_master_info->ait_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="3"><strong>AIT({{number_format($po_master_info->ait_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->ait_amount / $curr_rate, 2) : number_format($po_master_info->ait_amount, 2) }}</td>
                        <td class="border-0" colspan="2"></td>
                    </tr>
                @endif

                @if ($po_master_info->service_charge_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="3"><strong>Service Charge({{number_format($po_master_info->service_charge_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->service_charge_amount / $curr_rate, 2) : number_format($po_master_info->ait_amount, 2) }}</td>
                        <td class="border-0" colspan="2"></td>
                        </tr>
                @endif

                {{-- @if ($po_master_info->discount_amount > 0) --}}
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="3"><strong>Discount({{ number_format($po_master_info->discount_percent, 2) }}%):</strong></td>
                        <td class="border-0 text-right bg-light"  colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset{{ !empty($curr_rate) ? number_format($po_master_info->discount_amount / $curr_rate, 2) : number_format($po_master_info->discount_amount, 2) }}</td>
                        <td class="border-0" colspan="2"></td>
                    </tr>
                {{-- @endif --}}
                <tr>
                    @php
                        if (!empty($curr_rate)) {
                            $total = ($total + ($po_master_info->vat_amount / $curr_rate) - ($po_master_info->discount_amount / $curr_rate)) + ($po_master_info->service_charge_amount / $curr_rate) + ($po_master_info->ait_amount / $curr_rate);
                        }
                        else {
                            $total = (($total + $po_master_info->vat_amount) - ($po_master_info->discount_amount)) + $po_master_info->service_charge_amount + $po_master_info->ait_amount;
                        }
                    @endphp
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0 text-right bg-light" colspan="3"><strong>Total Amount:</strong></td>
                    <td class="border-0 text-right bg-light" style="border-top: 1px solid black; border-bottom: 1px solid black; " colspan="2"> <strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ number_format($total) }}</strong></td>
                    <td class="border-0" style="border-top: 1px solid black; border-bottom: 1px solid black; " colspan="2"></td>
                </tr>
        </tbody>

    </table>
</section>
<!-- T&C Section -->
<section class="">
    @php
        $number = number_format($total, 0, '.', '');
        $locale = 'en_US';
        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
        $in_words = numfmt_format($fmt, $number);
    @endphp
    <div>
        <span><strong>In Words : {{ ucfirst($in_words) }} @isset($po_child_details_info[0]->currency_name) {{$po_child_details_info[0]->currency_name}} @endisset only</strong></span>
    </div>
    <div class="mt-1">
        <span><strong>Remaks : </strong> {{$po_master_info->notes}}</span>
    </div>
    <!-- count($signature_data)>0 -->
     @if(count($signature_data)>0 || $po_master_info->submit_by_name != '' || $po_master_info->posted_by_name != '' )
        <div class="unico">
        <div class="signature" style="padding-bottom: 1px !important;">
            <table style="width: 100%; border:none ;font-size:14px" >
                <tbody>
                        <tr>
                            <td style="text-align:left; border:none " colspan="2">
                                            <span >Checked By</span><br>
                                            <span style="margin-top: 50px !important; display: inline-block; border-top: black solid 1px;">
                                                <strong>{{ $po_master_info->submit_by_name }}</strong>
                                            </span> <br>
                                            <span style="margin-top: 35px !important; display: inline-block;"><strong>{{ $po_master_info->submit_by_desig != '' ? ucwords($po_master_info->submit_by_desig) : '-' }}</strong></span>
                                            {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                            </td>

                            <td style="text-align:left; border:none " colspan="2">
                                            <span >Issued By</span><br>
                                            <span style="margin-top: 50px !important; display: inline-block; border-top: black solid 1px;">
                                                <strong>{{ $po_master_info->posted_by_name }}</strong>
                                            </span> <br>
                                            <span style="margin-top: 35px !important; display: inline-block;"><strong>{{ $po_master_info->posted_by_desig != '' ?  ucwords($po_master_info->posted_by_desig) : '-' }}</strong></span>
                                            {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                            </td>

                            <td style="text-align:left; border:none " colspan="2">
                                            <span >Verified By</span><br>
                                            <span style="margin-top: 50px !important; display: inline-block; border-top: black solid 1px;">
                                                <strong>Nuradilah Shuib</strong>
                                            </span> <br>
                                            <span style="margin-top: 35px !important; display: inline-block;"><strong>Chief Financial Officer</strong></span>
                            </td>

                            <td style="text-align:left; border:none " colspan="2">
                                            <span >Approved By</span><br>
                                            <span style="margin-top: 50px !important; display: inline-block; border-top: black solid 1px;">
                                                <strong>Mohd. Taufik Bin Ismail</strong>
                                            </span> <br>
                                            <span style="margin-top: 35px !important; display: inline-block;"><strong>Chief Executive Officer</strong></span>
                            </td>
                        </tr>

                </tbody>
            </table>

        </div>
    </div>
     @endif
     @if(count($terms)>0)
    <div style="margin-top:120px;">
        @if (!empty($terms))
            @foreach ($terms as $header => $terms_condition)
                <div class="text-left "> <strong> {{ $header }}</strong></div>
                @foreach ($terms_condition as $value)
                    <span class="text-left">{{ $value->description }}</span>
                @endforeach
            @endforeach
            <div style="font-weight: bold; margin-top:5px">Please sign and return the copy of this letter as acceptance of the above order.</div>
        @endif
    </div>
    @endif
</section>



