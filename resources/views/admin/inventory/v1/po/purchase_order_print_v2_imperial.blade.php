<style>
    @page{
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
            margin-right: 0.8cm;
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
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

    table{
            border-collapse: collapse;
            width: 100%;
        }

    td,th{
            padding: 2px !important;
        }

    .unico{
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
            top: 90px;
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
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="70" alt="">
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

<!-- Header Section -->
<section style="padding-bottom: 0px;">


    <p class="report-header"><strong>{{ $po_master_info->poheader == '0' ? 'Work Order' : 'Purchase Order' }}</strong></p>
    <table style="margin-top: 25px !important; margin-bottom: 5px;">
        <tr>
            <td style="text-align: left;width:60%">
                @if($po_master_info->reference_no !="")
                    <strong>Ref:</strong> {{ $po_master_info->reference_no }}<br><br>
                @endif
                @if($po_master_info->supplier_name !="")
                    <strong>To: {{ strtoupper($po_master_info->supplier_name) }} </strong><br>
                @endif
                @if($po_master_info->addr1 !="")
                    <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                @endif
                @if($po_master_info->refer_contact_name !="")
                    <strong>Attention :</strong> {{ $po_master_info->refer_contact_name }}<strong> Cell:</strong> {{ $po_master_info->refer_contact_mobile }}<br>
                @endif
                @if($po_master_info->refer_contact_email !="")
                    <strong> Email:</strong> {{ $po_master_info->refer_contact_email }}<br>
                @endif

            </td>
            <td style="text-align: right;width: 40%;">
                <img src="data:image/png;base64, {{ $invoice_barcode }} "/><br>
                <strong>PO ID:</strong> {{ $po_master_info->purchase_uid }}<br>
                <strong>PO NO:</strong> {{ $po_master_info->purchaseorder_no_pk }}<br>
                <strong>Date of PO:</strong>{{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                <strong>PO By: </strong> {{ $po_master_info->created_by }}<br>
                @if($po_master_info->quotation_ref != "")
                <strong>Quotation Ref :</strong>{{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}<br>
                @endif

                @if(!empty(@$po_master_info->review_no))
                    <strong>Review Version: </strong>{{ str_pad(@$po_master_info->review_no, 2, '0', STR_PAD_LEFT)}}<br>
                @endif
            </td>
        </tr>
        @if($po_master_info->reference_sub !="")
        <tr>
            <td colspan="2" style="text-align: left; padding-top:5px">
                <strong> Subject : </strong> {{ $po_master_info->reference_sub }}<br>
            </td>
        </tr>
        @endif
    </table>

    @if($po_master_info->reference_sub_body !="")
    <table style="margin-top: 0px; width:100%">
        <tr>
            <td style="text-align: left;"> {!! isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : '' !!}</td>
        </tr>
    </table>
    @endif
</section>

<!-- Table Body Section -->
<section>
    <table class="" border="1" style="margin-top: 0px; width:100%">
        <thead>
            <tr>
                <th class="text-center" style="width:5%">Sl.</th>
                <th class="text-center" style="width:10%">PR No</th>
                <th class="text-left" style="width:22%">Item Name</th>
                {{-- <th class="text-left" style="width:20%">Item Specification</th> --}}
                <th class="text-left" style="width:20%"> @if(@$po_master_info->pharmacy_ind == 1) Generic Name  @else Item Specification @endif</th>
                <th class="text-center" style="width:6%"> UoM</th>
                <th class="text-center" style="width:8%">Quantity</th>
                <th class="text-right" style="width:14%" > Unit Price @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
                <th class="text-right" style="width:15%">Total Amount @isset($po_child_details_info[0]->currency_sign) ({{$po_child_details_info[0]->currency_sign}}) @endisset</th>
            </tr>
        </thead>
        <tbody>
            @php
                $dollar_rate = 0;
                $total_dollar_rate = 0;
                $total = 0;
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
                        @endphp

                        @foreach (collect($po_child_details_info)->where('item_no_pk',$value->item_no_pk)->toArray() as $keys=>$item)
                            @php
                                $qty+= $item->entry_qty;
                                $dollar_rate = $item->dollar_rate != '' ? $item->item_rate / $item->dollar_rate : $item->item_rate;
                                $total_dollar_rate+= $item->dollar_rate != '' ? ($item->item_rate / $item->dollar_rate) * $item->entry_qty : $item->entry_qty * $item->item_rate;


                                if($keys == 0)
                                    $requistion.=  $item->item_requisition_no_fk;
                                else
                                 $requistion.=  ', '.$item->item_requisition_no_fk;
                           @endphp


                        @endforeach

                        @php $rate = $total_dollar_rate / $qty; @endphp

                        <tr>
                            <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                            <td class="text-center">{{  ltrim($requistion, ",") }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            {{-- <td class="text-left">{{ $value->refer_item_specification }}</td> --}}
                            <td class="text-left">
                                @if(@$po_master_info->pharmacy_ind == 1) {{ $value->generic_name }}  @else {{ $value->refer_item_specification }} @endif
                            </td>
                            <td class="text-center">{{ $value->uom_code }}</td>
                            <td class="text-center">{{ $qty }}  </td>
                            <td class="text-right">{{ number_format($rate, 2) }}</td>
                            <td class="text-right">{{ number_format($total_dollar_rate, 2) }}</td>
                        </tr>
                        @php
                            $total += $total_dollar_rate;
                        @endphp

                    @else
                            @php
                                $dollar_rate = $value->dollar_rate != '' ? $value->item_rate / $value->dollar_rate : $value->item_rate;
                                $total_dollar_rate = $value->dollar_rate != '' ? ($value->item_rate / $value->dollar_rate) * $value->entry_qty : $value->entry_qty * $value->item_rate;
                            @endphp

                            <tr>
                                <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $value->item_requisition_no_fk }}</td>
                                <td class="text-left">{{ $value->item_name }}</td>
                                {{-- <td class="text-left">{{ $value->refer_item_specification }}</td> --}}
                                <td class="text-left">
                                    @if(@$po_master_info->pharmacy_ind == 1) {{ $value->generic_name }}  @else {{ $value->refer_item_specification }} @endif
                                </td>
                                <td class="text-center">{{ $value->uom_code }}</td>
                                <td class="text-center">{{ $value->entry_qty }} </td>
                                <td class="text-right">{{ number_format($dollar_rate, 2) }}</td>
                                <td class="text-right">{{ number_format($total_dollar_rate, 2) }}</td>
                            </tr>
                            @php
                                $total += $value->dollar_rate != '' ? $value->entry_qty * ($value->item_rate / $value->dollar_rate) : $value->entry_qty * $value->item_rate;
                            @endphp
                    @endif
                @endforeach

                <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0 text-right bg-light" colspan="4"><strong>Total:</strong></td>
                    <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ number_format($total, 2) }}</td>
                </tr>

                @if ($po_master_info->vat_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="4"><strong>Duty/Vat({{number_format($po_master_info->vat_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->vat_amount / $curr_rate, 2) : number_format($po_master_info->vat_amount, 2) }}</td>
                    </tr>
                @endif


                @if ($po_master_info->ait_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="4"><strong>AIT({{number_format($po_master_info->ait_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->ait_amount / $curr_rate, 2) : number_format($po_master_info->ait_amount, 2) }}</td>
                    </tr>
                @endif

                @if ($po_master_info->service_charge_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="4"><strong>Service Charge({{number_format($po_master_info->service_charge_percent, 2)}}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ !empty($curr_rate) ? number_format($po_master_info->service_charge_amount / $curr_rate, 2) : number_format($po_master_info->ait_amount, 2) }}</td>
                    </tr>
                @endif

                @if ($po_master_info->discount_amount > 0)
                    <tr>
                        <td class="border-0" colspan="2"></td>
                        <td class="border-0 text-right bg-light" colspan="4"><strong>Discount({{ number_format($po_master_info->discount_percent, 2) }}%):</strong></td>
                        <td class="border-0 text-right bg-light" colspan="2"><strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset{{ !empty($curr_rate) ? number_format($po_master_info->discount_amount / $curr_rate, 2) : number_format($po_master_info->discount_amount, 2) }}</td>
                    </tr>
                @endif
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
                    <td class="border-0 text-right bg-light" colspan="4"><strong>Payable:</strong></td>
                    <td class="border-0 text-right bg-light" colspan="2"> <strong>@isset($po_child_details_info[0]->currency_sign) {{$po_child_details_info[0]->currency_sign}} @endisset {{ number_format($total, 2) }}</strong></td>
                </tr>
        </tbody>

    </table>
</section>
<!-- T&C Section -->
<section class="pt-5">
    @php
        $number = number_format($total, 2, '.', '');
        $locale = 'en_US';
        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
        $in_words = numfmt_format($fmt, $number);
    @endphp
    <div>
        <span><strong> Total Job Cost ( In Words ) : {{ ucfirst($in_words) }} @isset($po_child_details_info[0]->currency_name) {{$po_child_details_info[0]->currency_name}} @endisset only</strong></span>
    </div>
    <div style="margin-top:5px;">
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
</section>

<!-- Signature Section -->

<div class="unico">
    <div style="font-weight: bold;margin-top:5px;">For {{ Session::get('user.hospital_name') }}</div>
   
    <div class="signature">
        <table style="width: 100%; border:none ;font-size:14px" >
            <tbody>
                @if(!empty($signature_data))
                    <tr>
                        @foreach ($signature_data as $key => $value)
                            @php
                                $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                            @endphp
                            @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                            
                                <td style="text-align:left; border:none " colspan="2">
                                    @if(Session::get('user.ses_hospital_code') == 'DMHL')
                                        @if($value->doctor_signature_image !="")
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                        @endif
                                    @endif
                                    <span style=" border-top: black solid 1px;"><strong>{{ $value->user_fullname }} </strong></span> <br>
                                    <strong>{{ ucwords($value->designation) }}</strong>
                                    @if(!empty($value->approval_promt))
                                        <br><div style="padding-top:10px;font-size:12px"><i>{{ $value->approval_promt }}</i></div>
                                    @endif
                                    {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                                </td>
                            @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:left; border:none;" colspan="2">
                                    <div style="float: right;">
                                        @if(Session::get('user.ses_hospital_code') == 'DMHL')
                                            @if($value->doctor_signature_image !="")
                                                <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif
                                        @endif
                                        <span style=" border-top: 1px solid black;"><strong>{{ $value->user_fullname }} </strong></span> <br>
                                        <strong>{{ ucwords($value->designation) }}</strong>
                                        @if(!empty($value->approval_promt))
                                            <br><div style="padding-top:10px;font-size:12px"><i>{{ $value->approval_promt }}</i></div>
                                        @endif
                                        {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                                    </div>
                                </td>
                            @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if(Session::get('user.ses_hospital_code') == 'DMHL')
                                        @if($value->doctor_signature_image !="")
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                        @endif
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>{{ $value->user_fullname }} </strong></span> <br>
                                    <strong>{{ $value->designation }}</strong>
                                    @if(!empty($value->approval_promt))
                                        <br><div style="padding-top:10px;font-size:12px"><i>{{ $value->approval_promt }}</i></div>
                                    @endif
                                    {{-- <br><strong>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}</strong> --}}
                                </td>
                            @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                <td style="text-align:center; border:none" colspan="2">
                                    @if(Session::get('user.ses_hospital_code') == 'DMHL')
                                        @if($value->doctor_signature_image !="")
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                        @endif
                                    @endif
                                    <span style="padding:5px; border-top: black solid 1px;"> <strong>{{ $value->user_fullname }} </strong></span> <br>
                                    <strong>{{ ucwords($value->designation) }}</strong>
                                    @if(!empty($value->approval_promt))
                                        <br><div style="padding-top:10px;font-size:12px"><i>{{ $value->approval_promt }}</i></div>
                                    @endif
                                    {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endif

            </tbody>
        </table>

        @if(Session::get('user.ses_hospital_code') == 'DMHL')
            <div style="font-weight: bold; margin-top:25px; font-size: 12px;">[This is system generated approved document. Signature is not required.]</div>
        @endif

    </div>
</div>
