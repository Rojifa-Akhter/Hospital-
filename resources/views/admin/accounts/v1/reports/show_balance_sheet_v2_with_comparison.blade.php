
@extends('admin.layouts.master')
@push('css_custom')
<style>
    table td {
        font-size: 15px;
        border-top: 1px solid #B4B5B6;
        border-left:none;
        border-right:none;
        padding-right:3px;
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important;
        background-color: unset;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    .list-group-item.active {
    background-color: unset !important;
    }
    summary {
        cursor: pointer;
        outline: none;
        border: none
    } 
    details:not([open]) > *:not(summary) {
        display: none;
    }
    details {
        border: none;
    }
    .gl-level{
        padding-left: 42px;       
        border-left:none;
        border-right:none;
        font-size: 12px;
    }
    .border-y{
        border-top:1px solid #B4B5B6;
        border-bottom:1px solid #B4B5B6;
    }
    .description-level{
        padding:3px 0px;
        padding-left:20px; 
        font-size: 12px;
    }
    .first_row{
        border:none;
        padding-left: 50px;
        /* display: flex; */
    }
    .head-title{
        border-bottom: 1px solid #B4B5B6;
        border-top:none;
        border-left:none;
        border-right:none;
        text-align: left;
    }
    .fs-12{
        font-size:12px;
    }
    .pul-right{
        text-align: right;
        padding-right: 5px;
        padding-left: 25px !important;
    }
    .first{
        text-align:right;
    }
    .second{
        text-align:right;
    }
    .third{
        text-align:right;
    }
    .first-td{
        width:30%
    }
    .second-td{
        width:30%;
    }
    .top_move{
        padding-left: 15px;
        margin-top: -18px;
    }
    .gl-show:last-child {
        border-bottom: none !important;
    }
    .net-amount{
        padding-left: 24px;
    }
</style>
@endpush
@php 
   $formated_prev_to_date = date("Y-m-d", strtotime(@$prev_to_date));
@endphp
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
                    <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                        <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                            Statement of Financial Position
                        </h5>
                        @if($search_type == 'daily')
                        <h6 class="mb"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
                        @else
                            @php 
                             
                                $date_parts = explode('/', $date);
                                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                                $timestamp = strtotime($correct_format);
                                $formattedDate = date('F Y', $timestamp);
                          

                            @endphp
                        <h6 class="mb" style="text-transform: uppercase"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"> 
                    @if(!empty($root_info))
                        @if(!empty($root_info))
                            <div class="end export-option my-2">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadBalanceSheet('pdf-nd')" style="cursor:pointer"><button class="btn btn-sm btn-primary"> Export PDF</button></span></li>
                                    <li class="list-group-item"><span onclick="downloadBalanceSheet('excel-nd')" style="cursor:pointer"><button class="btn btn-sm btn-success"> Export Excel</button></span></li>                                 
                                    {{-- <li class="list-group-item"><span onclick="downloadBalanceSheet('pdf')" style="cursor:pointer"><button class="btn btn-sm btn-primary"> Export PDF (Details)</button></span></li> --}}
                                    <li class="list-group-item"><span onclick="downloadBalanceSheet('excel')" style="cursor:pointer"><button class="btn btn-sm btn-success"> Export Excel (Details)</button></span></li>                                 
                                </ul>
                            </div> 
                        @endif

                    @endif
                </div>
            </div>

            <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="balancesheet-table">
                <thead>
                    <tr>
                        <td style="display:flex">
                            <span class="text-left" style="width:70%"><b>Assets</b></span>
                                <span style="display: flex;justify-content:space-between;width:30%">
                                    <div class=" third"><b>Notes</b></div>
                                    <div class=" first"><b>Current</b></div> 
                                    <div class=" second"><b>Previous</b></div>
                                </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div style="display:flex">
                                <span class="text-left" style="width:70%"><b></b></span>
                                    <span style="display: flex;justify-content:space-between;width:30%">
                                        <div class="third"><b></b></div>
                                        
                                        <div class="first">
                                            <b>
                                                <small> 
                                                    @if($search_type == 'daily')                             
                                                        {{date("d F Y", strtotime(@$to_date))}} 
                                                    @else
                                                    {{@$date}}
                                                    @endif
                                                </small>
                                            </b>
                                        </div> 

                                        <div class="second">
                                            <b>
                                                <small> 
                                                    {{date("d F Y", strtotime(@$prev_to_date))}}                   
                                                </small>
                                            </b>
                                        </div>  
                                </span>
                            </div>
                        </td>           
                    </tr>
                </thead>
                <tbody>                   
                    @if(!empty($root_info))
                    <!-- Non Current Assets -->
                        <tr>
                            <td class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Non Current Assets</strong></td>
                        </tr>
                        @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:70%"><b>{{$key}} </b></span>
                                                    <span style="display: flex;justify-content:space-between;width:30%">
                                                        <div class=" third"><b>@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</b></div>
                                                        <div class=" first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div> 
                                                        <div class=" second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div>
                                                    </span>
                                                </span>
                                            </div>                                                                         
                                        </summary>                                  
                                        <table style="width:100%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                            <span class="text-left" style="width:70%"><b>{{$key2}} </b></span>
                                                                            <span style="display: flex;justify-content:space-between;width:30%">
                                                                                <div class=" third"><b></b></div>
                                                                                <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                                <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('amount');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:70%">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a></span>
                                                                                <span style="display: flex;justify-content:space-between;width:30%" class="gl-level">
                                                                                        <div class=" third"></div>
                                                                                        <div class=" first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div> 
                                                                                        <div class=" second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div>
                                                                                </span>
                                                                            </span>
                                                                        </td>

                                                                    </tr>                                                                                                                                   
                                                                    @endforeach                   
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>               
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>    
                                </td>
                            </tr>
                        @endforeach                                                                                    
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $net_non_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('amount') ;
                                    $net_non_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('prev_amount') ;
                                    $net_non_current_ammount_bal = floatVal($net_non_current_ammount_prev) - floatVal($net_non_current_ammount);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%"><strong>Net Non Current Assets</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class=" third"></div>
                                            <div class=" first"><b>@if($net_non_current_ammount >= 0) {{number_format($net_non_current_ammount,2)}} @else {{"(".number_format(abs($net_non_current_ammount),2).")"}} @endif</b></div> 
                                            <div class=" second"><b>@if($net_non_current_ammount_prev >= 0) {{number_format($net_non_current_ammount_prev,2)}} @else {{ "(".number_format(abs($net_non_current_ammount_prev),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Non Current Assets -->



                     <!-- Current Assets -->
                        <tr>
                            <td class="head-title"><strong>Current Assets</strong></td>
                        </tr>
                        @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:70%"><b>{{$key}} </b></span>
                                                    <span style="display: flex;justify-content:space-between;width:30%">
                                                        <div class=" third"><b>@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</b></div>
                                                        <div class=" first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div> 
                                                        <div class=" second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div>
                                                    </span>
                                                </span>
                                            </div>                                                                         
                                        </summary>                                  
                                        <table style="width:100%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                            <span class="text-left" style="width:70%"><b>{{$key2}} </b></span>
                                                                            <span style="display: flex;justify-content:space-between;width:30%">
                                                                                <div class=" third"><b></b></div>
                                                                                <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                                <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('amount');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:70%">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a></span>
                                                                                <span style="display: flex;justify-content:space-between;width:30%" class="gl-level">
                                                                                        <div class=" third"></div>
                                                                                        <div class=" first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div> 
                                                                                        <div class=" second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div>
                                                                                </span>
                                                                            </span>
                                                                        </td>

                                                                    </tr>                                                                                                                                   
                                                                    @endforeach                   
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>               
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>    
                                </td>
                            </tr>
                        @endforeach                                                                                    
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $net_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('amount') ;
                                    $net_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('prev_amount') ;
                                    $net_current_ammount_bal = floatVal($net_current_ammount_prev) - floatVal($net_current_ammount);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%"><strong>Net Current Assets</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class=" third"><b></b></div>
                                            <div class=" first"><b>@if($net_current_ammount >= 0) {{number_format($net_current_ammount,2)}} @else {{"(".number_format(abs($net_current_ammount),2).")"}} @endif</b></div> 
                                            <div class=" second"><b>@if($net_current_ammount_prev >= 0) {{number_format($net_current_ammount_prev,2)}} @else {{ "(".number_format(abs($net_current_ammount_prev),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Current Assets -->
                    
                    <!-- Total Assets -->
                    <tr>
                        @php 
                            $total_current_asset = collect($root_info)
                                                        ->where('balanc_income','BALANCE')
                                                        ->filter(function ($item) {
                                                            return ($item->bal_inc_tag == 'CURRASSET')
                                                                || ($item->bal_inc_tag == 'FIXEDASSET');
                                                        })
                                                        ->sum('amount');

                            $total_current_asset_prev = collect($root_info)
                                                        ->filter(function ($item) {
                                                            return ($item->bal_inc_tag == 'CURRASSET')
                                                                || ($item->bal_inc_tag == 'FIXEDASSET');
                                                                })
                                                        ->where('balanc_income','BALANCE')                               
                                                        ->sum('prev_amount');

                            $total_asset_balance  = floatVal($total_current_asset_prev) - floatVal($total_current_asset)
                                                       
                        @endphp


                        <td class="head-title">
                            <span style="display:flex">
                                <span class="text-left" style="width:70%"><strong>Total Assets </strong></span>
                                <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                   
                                        <div class=" third"><b></b></div>
                                        <div class=" first"><b>@if($total_current_asset >= 0) {{number_format($total_current_asset,2)}} @else {{ "(".number_format(abs($total_current_asset),2).")"}} @endif</b></div> 
                                        <div class=" second"><b>@if($total_current_asset_prev >= 0) {{number_format($total_current_asset_prev,2)}} @else {{ "(".number_format(abs($total_current_asset_prev),2).")"}} @endif</b></div>
                                </span>
                            </span> 
                        </td>
                                 
                    </tr>
                    <!-- Close Total Assets -->

                    <!-- Current Liabilities -->
                        <tr>
                            <td  class="head-title"><strong>Liabilities and Shareholders' Equity</strong></td>
                        </tr>

                        <tr>
                            <td class="head-title"><strong></strong></td>
                        </tr>

                        <tr>
                            <td class="head-title"><strong>Current Liabilities</strong></td>
                        </tr>
                        @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:70%"><b>{{$key}} </b></span>
                                                    <span style="display: flex;justify-content:space-between;width:30%">
                                                        <div class=" third"><b>@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</b></div>
                                                        <div class=" first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div> 
                                                        <div class=" second"><b>@if($prev_price >= 0){{number_format($prev_price,2)}}@else{{ "(".number_format(abs($prev_price),2).")"}}@endif</b></div>
                                                    </span>
                                                </span>
                                            </div>                                                                         
                                        </summary>                                  
                                        <table style="width:100%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                            <span class="text-left" style="width:70%"><b>{{$key2}} </b></span>
                                                                            <span style="display: flex;justify-content:space-between;width:30%">
                                                                                <div class=" third"><b></b></div>
                                                                                <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                                <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('amount');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:70%">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a></span>
                                                                                <span style="display: flex;justify-content:space-between;width:30%" class="gl-level">
                                                                                        <div class=" third"></div>
                                                                                        <div class=" first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div> 
                                                                                        <div class=" second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div>
                                                                                </span>
                                                                            </span>
                                                                        </td>

                                                                    </tr>                                                                                                                                   
                                                                    @endforeach                   
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>               
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>    
                                </td>
                            </tr>
                        @endforeach                                                                                    
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $net_current_liabilities_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('amount') ;
                                    $net_current_liabilities_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('prev_amount') ;
                                    $net_current_liabilities_ammount_bal = floatVal($net_current_liabilities_ammount_prev) - floatVal($net_current_liabilities_ammount);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%"><strong>Net Current Liabilities</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class=" third"><b></b></div>
                                            <div class=" first"><b>@if($net_current_liabilities_ammount >= 0) {{number_format($net_current_liabilities_ammount,2)}} @else {{ "(".number_format(abs($net_current_liabilities_ammount),2).")"}} @endif</b></div> 
                                            <div class=" second"><b>@if($net_current_liabilities_ammount_prev >= 0) {{number_format($net_current_liabilities_ammount_prev,2)}} @else {{ "(".number_format(abs($net_current_liabilities_ammount_prev),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Current Liabilities -->

                    <!-- Owners Equity -->
                        <tr>
                            <td class="head-title"><strong>Owners Equity</strong></td>
                        </tr>
                        @foreach(collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('owners_amount'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_owners_amount'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:70%"><b>{{$key}} </b></span>
                                                    <span style="display: flex;justify-content:space-between;width:30%">
                                                        <div class=" third"><b>@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</b></div>
                                                        <div class=" first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div> 
                                                        <div class=" second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div>
                                                    </span>
                                                </span>
                                            </div>                                                                         
                                        </summary>                                  
                                        <table style="width:100%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('owners_amount'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_owners_amount'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                            <span class="text-left" style="width:70%"><b>{{$key2}} </b></span>
                                                                            <span style="display: flex;justify-content:space-between;width:30%">
                                                                                <div class=" third"><b></b></div>
                                                                                <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                                <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('owners_amount');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_owners_amount');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:70%">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a></span>
                                                                                <span style="display: flex;justify-content:space-between;width:30%" class="gl-level">
                                                                                        <div class=" third"></div>
                                                                                        <div class=" first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div> 
                                                                                        <div class=" second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div>
                                                                                </span>
                                                                            </span>
                                                                        </td>

                                                                    </tr>                                                                                                                                   
                                                                    @endforeach                   
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>               
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>    
                                </td>
                            </tr>
                        @endforeach                                                                                    
                        <tr><td class="head-title"></td></tr>


                        <tr>
                            <td class="head-title">

                                @php 
                                        $income = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                                        $expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
                                        $operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('dr');
                                        $operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('cr');
                                        $operating_gain_loss = floatVal($operating_gain_loss_dr) - floatVal($operating_gain_loss_cr);
                                        if($operating_gain_loss < 0){
                                            $expense += abs($operating_gain_loss);
                                        }
                                        else{
                                            $income += $operating_gain_loss;
                                        }                           
                                        $retained_earnings = floatVal($income) - floatVal($expense); 
                                @endphp

                                @php 
                                    $prev_income = collect($prev_profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                                    $prev_expense = collect($prev_profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
                                    $prev_operating_gain_loss_dr = collect($prev_profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('dr');
                                    $prev_operating_gain_loss_cr = collect($prev_profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('cr');
                                    $prev_operating_gain_loss = floatVal($prev_operating_gain_loss_dr) - floatVal($prev_operating_gain_loss_cr);
                                    if($prev_operating_gain_loss < 0){
                                        $prev_expense += abs($prev_operating_gain_loss);
                                    }
                                    else{
                                        $prev_income += $prev_operating_gain_loss;
                                    }                           
                                    $retained_earnings_prev = floatVal($prev_income) - floatVal($prev_expense); 
                                @endphp


                                @php 
                                    $retained_earnings_bal = floatVal($retained_earnings_prev) - floatVal($retained_earnings);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%">Retained Earnings</span>
                                    <span style="display:flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class="third"><b></b></div>
                                            <div class="first"><b>@if($retained_earnings >= 0){{number_format($retained_earnings,2)}}@else{{"(".number_format(abs($retained_earnings),2).")"}}@endif</b></div> 
                                            <div class="second"><b>@if($retained_earnings_prev >= 0){{number_format($retained_earnings_prev,2)}}@else{{"(".number_format(abs($retained_earnings_prev),2).")"}}@endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="head-title">
                                @php 
                                    $net_owners_equity_ammount = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('owners_amount') + floatVal($retained_earnings);
                                    $net_owners_equity_ammount_prev = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('prev_owners_amount') + floatVal($retained_earnings_prev);
                                    $net_owners_equity_ammount_bal = floatVal($net_owners_equity_ammount_prev) - floatVal($net_owners_equity_ammount);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%"><strong>Net Owners Equity</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class=" third"><b></b></div>
                                            <div class=" first"><b>@if($net_owners_equity_ammount >= 0){{number_format($net_owners_equity_ammount,2)}} @else {{"(".number_format(abs($net_owners_equity_ammount),2).")"}} @endif</b></div> 
                                            <div class=" second"><b>@if($net_owners_equity_ammount_prev >= 0){{number_format($net_owners_equity_ammount_prev,2)}} @else {{"(".number_format(abs($net_owners_equity_ammount_prev),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Owners Equity -->

                    <!-- Non Current Liabilities-->
                        <tr>
                            <td class="head-title"><strong>Non Current Liabilities</strong></td>
                        </tr>
                        @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:70%"><b>{{$key}} </b></span>
                                                    <span style="display: flex;justify-content:space-between;width:30%">
                                                        <div class=" third"><b>@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</b></div>
                                                        <div class=" first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div> 
                                                        <div class=" second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div>
                                                    </span>
                                                </span>
                                            </div>                                                                         
                                        </summary>                                  
                                        <table style="width:100%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                            <span class="text-left" style="width:70%"><b>{{$key2}} </b></span>
                                                                            <span style="display: flex;justify-content:space-between;width:30%">
                                                                                <div class=" third"><b></b></div>
                                                                                <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                                <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('amount');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:70%">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a></span>
                                                                                <span style="display: flex;justify-content:space-between;width:30%" class="gl-level">
                                                                                        <div class=" third"></div>
                                                                                        <div class=" first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div> 
                                                                                        <div class=" second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div>
                                                                                </span>
                                                                            </span>
                                                                        </td>

                                                                    </tr>                                                                                                                                   
                                                                    @endforeach                   
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>               
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>    
                                </td>
                            </tr>
                        @endforeach                                                                                    
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $net_non_current_lib_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('amount') ;
                                    $net_non_current_lib_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('prev_amount') ;
                                    $net_non_current_lib_ammount_bal = floatVal($net_non_current_lib_ammount_prev) - floatVal($net_non_current_lib_ammount);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:70%"><strong>Non Current Liabilities</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">
                                            <div class=" third"><b></b></div>
                                            <div class=" first"><b>@if($net_non_current_lib_ammount >= 0) {{number_format($net_non_current_lib_ammount,2)}} @else {{ "(".number_format(abs($net_non_current_lib_ammount),2).")"}} @endif</b></div> 
                                            <div class=" second"><b>@if($net_non_current_lib_ammount_prev >= 0) {{number_format($net_non_current_lib_ammount_prev,2)}} @else {{ "(".number_format(abs($net_non_current_lib_ammount_prev),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Non Current Liabilities--> 

                    <!-- Total Owners and Liability -->
                    <tr>
                   
                
                        @php $total_liability_owners_equity_current = $net_non_current_lib_ammount + $net_owners_equity_ammount + $net_current_liabilities_ammount; @endphp
                        @php $total_liability_owners_equity_prev = $net_non_current_lib_ammount_prev + $net_owners_equity_ammount_prev + $net_current_liabilities_ammount_prev; @endphp
                        @php $total_liability_owners_equity_balance = $net_non_current_lib_ammount_bal + $net_owners_equity_ammount_bal + $net_current_ammount_bal; @endphp

                        <td class="head-title">
                            <span style="display:flex">
                                <span class="text-left" style="width:70%"><strong>Total Liabilities and Shareholders' Equity</strong></span>
                                <span style="display: flex;justify-content:space-between;width:30%" class="net-amount">                                   
                                        <div class=" third"><b></b></div>
                                        <div class=" first"><b>@if($total_liability_owners_equity_current >= 0){{number_format($total_liability_owners_equity_current,2)}} @else {{"(".number_format(abs($total_liability_owners_equity_current),2).")"}} @endif</b></div> 
                                        <div class=" second"><b>@if($total_liability_owners_equity_prev >= 0){{number_format($total_liability_owners_equity_prev,2)}} @else {{"(".number_format(abs($total_liability_owners_equity_prev),2).")"}} @endif</b></div>
                                </span>
                            </span> 
                        </td>
                                 
                    </tr>
                    <!-- Close Total Owners and Liability -->

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function downloadBalanceSheet(type){

            var to_date = '<?php echo json_encode($to_date); ?>';
            var search_type = '<?php echo json_encode($search_type); ?>';
            var date = '<?php echo json_encode($date); ?>';
            var prev_to_date = '<?php echo json_encode($prev_to_date); ?>';
            var comparison = '1';
            to_date = JSON.parse(to_date);
            search_type = JSON.parse(search_type);
            date = JSON.parse(date);
            prev_to_date = JSON.parse(prev_to_date);
            if(type == 'excel'){
                var url = '{{route('v2.accounts.download-balance-statement-comparison-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-balance-statement-comparison-pdf')}}';
            }
            else if(type == 'pdf-nd'){
                var url = '{{route('v2.accounts.download-balance-statement-comparison-pdf-nd')}}';
            }
            else if(type == 'excel-nd'){
                var url = '{{route('v2.accounts.download-balance-statement-comparison-excel-nd')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{to_date:to_date,search_type:search_type,date:date,prev_to_date:prev_to_date,comparison:comparison},    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel' || type == 'excel-nd')
                    downloadLink.setAttribute('download', 'balance_statement.xls');

                else if(type == 'pdf' || type == 'pdf-nd')                     
                    downloadLink.setAttribute('download', 'balance_statement.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }
</script>
@endpush