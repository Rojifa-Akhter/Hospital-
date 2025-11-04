
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
        width:50%
    }
    .second-td{
        width:50%;
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
    /*previous calculation */
    $prev_income = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_cr');
    $prev_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_dr');
    $prev_operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('prev_dr');
    $prev_operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('prev_cr');
    
    
    $prev_operating_gain_loss = floatVal($prev_operating_gain_loss_dr) - floatVal($prev_operating_gain_loss_cr);
    
    if($prev_operating_gain_loss < 0){
        $prev_expense += abs($prev_operating_gain_loss);
    }
    else{
        $prev_income += $prev_operating_gain_loss;
    }
    
    $prev_retained_earnings = floatVal($prev_income) - floatVal($prev_expense);

    /* current calculation */
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
$net_income = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
$net_income_prev = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_cr');
$net_income_bal = floatVal($net_income_prev) - floatVal($net_income);

$net_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
$net_expense_prev = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_dr');
$net_expense_bal = floatVal($net_expense_prev) - floatVal($net_expense);

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
                            Statement of Profit or Loss
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
                    @if(!empty($profit_loss))
                        <div class="end export-option my-2">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="list-group-item"><span onclick="downloadProfitLossBalance('pdf-nd')" style="cursor:pointer"><button class="btn btn-sm btn-primary">Export PDF</button></span></li>
                                <li class="list-group-item"><span onclick="downloadProfitLossBalance('excel-nd')" style="cursor:pointer"><button class="btn btn-sm btn-success">Export Excel</button></span></li>                                 
                                <li class="list-group-item"><span onclick="downloadProfitLossBalance('excel')" style="cursor:pointer"><button class="btn btn-sm btn-success">Export Excel (Details)</button></span></li>                                 
                            </ul>
                        </div> 
                    @endif
                </div>
            </div>

            <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="balancesheet-table">
                <thead>
                    <tr>
                        <td style="display:flex">
                            <span class="text-left" style="width:50%"><b>Particulars</b></span>
                            <span style="display:flex;justify-content:space-between;width:50%">
                                <div class="first"><b>Current</b></div> 
                                <div class="second"><b>Previous</b></div>
                                <div class="third"><b>Difference Amount</b></div>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div style="display:flex">
                                <span class="text-left" style="width:50%"><b></b></span>
                                    <span style="display: flex;justify-content:space-between;width:50%">
                                        <div class=" first">
                                            <b>
                                                <small> 
                                                    @if($search_type == 'daily')
                                                        {{date("d/m/Y",strtotime($from_date))}} -  {{date("d/m/Y",strtotime($to_date))}}
                                                    @else
                                                    {{@$date}}
                                                    @endif
                                                </small>
                                            </b>
                                        </div> 
                                        <div class=" second">
                                            <b>
                                                <small> 
                                                    {{ date("d/m/Y", strtotime(@$prev_from_date))}} -  {{date("d/m/Y", strtotime(@$prev_to_date))}}                   
                                                </small>
                                            </b>
                                        </div>
                                        <div class="third"><b></b></div>
                                </span>
                            </div>
                        </td>           
                    </tr>
                </thead>
                <tbody>                   
                    @if(!empty($profit_loss))
                    <!-- Income -->
                        <tr>
                            <td class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Income</strong></td>
                        </tr>
                        @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                            <tr>
                                <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_cr'));    
                                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                            <div class="top_move">
                                                <span style="display:flex">
                                                    <span class="text-left" style="width:50%"><b>{{$key}} </b></span>
                                                    <span style="display:flex;justify-content:space-between;width:50%">
                                                        <div class="first"><b>@if($type_price >= 0){{number_format($type_price,2)}}@else{{"(".number_format(abs($type_price),2).")"}}@endif</b></div> 
                                                        <div class="second"><b>@if($prev_price >= 0){{number_format($prev_price,2)}}@else{{"(".number_format(abs($prev_price),2).")"}}@endif</b></div>
                                                        <div class="third"><b>@if($balance >= 0){{number_format($balance,2)}}@else{{"(".number_format(abs($balance),2).")"}}@endif</b></div>
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
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_cr'));    
                                                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                            @endphp                                                           
                                                            <summary class="description-level">                                                             
                                                                <div class="top_move">
                                                                    <span style="display:flex">
                                                                        <span class="text-left" style="width:50%"><b>{{$key2}} </b></span>
                                                                        <span style="display: flex;justify-content:space-between;width:50%">
                                                                            <div class="first"><b>@if($desc_price >= 0){{number_format($desc_price,2)}}@else{{"(".number_format(abs($desc_price),2).")"}}@endif</b></div> 
                                                                            <div class="second"><b>@if($desc_prev_price >= 0){{number_format($desc_prev_price,2)}}@else{{"(".number_format(abs($desc_prev_price),2).")"}}@endif</b></div>
                                                                            <div class="third"><b>@if($desc_prev_balance >= 0){{number_format($desc_prev_balance,2)}}@else{{"(".number_format(abs($desc_prev_balance),2).")"}}@endif</b></div>
                                                                        </span>
                                                                    </span>
                                                                </div>             
                                                            </summary>
                                                            <table style="width:100%">
                                                                <tbody>                            
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('cr');                   
                                                                            $gl_prev_price = collect($item4)->sum('prev_cr');                   
                                                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                        @endphp
                                      
                                                                        <td class="border-y gl-show">
                                                                            <span style="display:flex">
                                                                                <span class="text-left gl-level" style="width:50%"><a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a> - {{$item4[0]->account_name}}</span>
                                                                                <span style="display: flex;justify-content:space-between;width:50%" class="gl-level">
                                                                                        <div class="first">@if($gl_price >= 0){{number_format($gl_price,2)}}@else{{"(".number_format(abs($gl_price),2).")"}}@endif</div> 
                                                                                        <div class="second">@if($gl_prev_price >= 0){{number_format($gl_prev_price,2)}}@else{{"(".number_format(abs($gl_prev_price),2).")"}}@endif</div>
                                                                                        <div class="third">@if($gl_price_total >= 0){{number_format($gl_price_total,2)}}@else{{"(".number_format(abs($gl_price_total),2).")"}}@endif</div>
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
                        
                       
                        @if($prev_operating_gain_loss > 0 || $operating_gain_loss > 0)
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $operating = $operating_gain_loss > 0 ? $operating_gain_loss : 0;
                                    $operating_prev = $prev_operating_gain_loss > 0 ? $prev_operating_gain_loss : 0;
                                    $operating_bal = floatVal($operating_prev) - floatVal($operating);

                                    $net_income+= $operating_gain_loss > 0 ? $operating_gain_loss : 0;
                                    $net_income_prev+= $prev_operating_gain_loss > 0 ? $prev_operating_gain_loss : 0;
                                    $net_income_bal+= floatVal($net_income_prev) - floatVal($net_income);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:50%"><strong>Operating Gain</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:50%" class="net-amount">
                                            <div class="first"><b>@if($operating >= 0) {{number_format($operating,2)}} @else {{"(".number_format(abs($operating),2).")"}} @endif</b></div> 
                                            <div class="second"><b>@if($operating_prev >= 0) {{number_format($operating_prev,2)}} @else {{"(".number_format(abs($operating_prev),2).")"}} @endif</b></div>
                                            <div class="third"><b>@if($operating_bal >= 0) {{number_format($operating_bal,2)}} @else {{"(".number_format(abs($operating_bal),2).")"}} @endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="head-title">                                                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:50%"><strong>Net Income</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:50%" class="net-amount">
                                            <div class="first"><b>@if($net_income >= 0){{number_format($net_income,2)}}@else{{"(".number_format(abs($net_income),2).")"}}@endif</b></div> 
                                            <div class="second"><b>@if($net_income_prev >= 0){{number_format($net_income_prev,2)}}@else{{"(".number_format(abs($net_income_prev),2).")"}}@endif</b></div>
                                            <div class="third"><b>@if($net_income_bal >= 0){{number_format($net_income_bal,2)}}@else{{"(".number_format(abs($net_income_bal),2).")"}}@endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    <!-- Close Income -->

                    <!-- Expense -->
                    <tr>
                        <td class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Expense</strong></td>
                    </tr>
                    @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                        <tr>
                            <td class="first_row" style="width: 100%">                                                                                                                                                                                                                                                                                                                                                                                                               
                                <details>
                                    @php 
                                        $type_price = (collect($item)->where('acc_4type_name',$key)->sum('dr'));    
                                        $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_dr'));    
                                        $balance =  floatVal($prev_price) - floatVal($type_price);    
                                    @endphp
                                    <summary style="padding: 1px;font-size:12px">                                                                                                                          
                                        <div class="top_move">
                                            <span style="display:flex">
                                                <span class="text-left" style="width:50%"><b>{{$key}} </b></span>
                                                <span style="display: flex;justify-content:space-between;width:50%">
                                                    <div class="first"><b>@if($type_price >= 0){{number_format($type_price,2)}}@else{{"(".number_format(abs($type_price),2).")"}}@endif</b></div> 
                                                    <div class="second"><b>@if($prev_price >= 0){{number_format($prev_price,2)}}@else{{"(".number_format(abs($prev_price),2).")"}}@endif</b></div>
                                                    <div class="third"><b>@if($balance >= 0){{number_format($balance,2)}}@else{{"(".number_format(abs($balance),2).")"}}@endif</b></div>
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
                                                            $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('dr'));    
                                                            $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_dr'));    
                                                            $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                                        @endphp                                                           
                                                        <summary class="description-level">                                                             
                                                            <div class="top_move">
                                                                <span style="display:flex">
                                                                        <span class="text-left" style="width:50%"><b>{{$key2}} </b></span>
                                                                        <span style="display: flex;justify-content:space-between;width:50%">
                                                                            <div class=" first"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div> 
                                                                            <div class=" second"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div>
                                                                            <div class=" third"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div>
                                                                        </span>
                                                                </span>
                                                            </div>             
                                                        </summary>
                                                        <table style="width:100%">
                                                            <tbody>                            
                                                                @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                
                                                                <tr>                           
                                                                    @php
                                                                        $gl_price = collect($item4)->sum('dr');                   
                                                                        $gl_prev_price = collect($item4)->sum('prev_dr');                   
                                                                        $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);                   
                                                                    @endphp
                                  
                                                                    <td class="border-y gl-show">
                                                                        <span style="display:flex">
                                                                            <span class="text-left gl-level" style="width:50%"><a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a> - {{$item4[0]->account_name}}</span>
                                                                            <span style="display: flex;justify-content:space-between;width:50%" class="gl-level">
                                                                                    <div class="first">@if($gl_price >= 0){{number_format($gl_price,2)}}@else{{"(".number_format(abs($gl_price),2).")"}}@endif</div> 
                                                                                    <div class="second">@if($gl_prev_price >= 0){{number_format($gl_prev_price,2)}}@else{{"(".number_format(abs($gl_prev_price),2).")"}}@endif</div>
                                                                                    <div class="third">@if($gl_price_total >= 0){{number_format($gl_price_total,2)}}@else{{"(".number_format(abs($gl_price_total),2).")"}}@endif</div>
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
                    
                   
                    @if($prev_operating_gain_loss < 0 || $operating_gain_loss < 0)
                        <tr><td class="head-title"></td></tr>
                        <tr>
                            <td class="head-title">
                                @php 
                                    $operating = $operating_gain_loss < 0 ? $operating_gain_loss : 0;
                                    $operating_prev = $prev_operating_gain_loss < 0 ? $prev_operating_gain_loss : 0;
                                    $operating_bal = floatVal($operating_prev) - floatVal($operating);

                                    $net_expense+= abs($operating_gain_loss < 0 ? $operating_gain_loss : 0);
                                    $net_expense_prev+= abs($prev_operating_gain_loss < 0 ? $prev_operating_gain_loss : 0);
                                    $net_expense_bal+= floatVal($net_expense_prev) - floatVal($net_expense);
                                @endphp
                                
                                <span style="display:flex">
                                    <span class="text-left" style="width:50%"><strong>Operating Loss</strong></span>
                                    <span style="display: flex;justify-content:space-between;width:50%" class="net-amount">
                                        <div class="first"><b>@if($operating >= 0){{number_format($operating,2)}}@else{{"(".number_format(abs($operating),2).")"}}@endif</b></div> 
                                        <div class="second"><b>@if($operating_prev >= 0){{number_format($operating_prev,2)}}@else{{"(".number_format(abs($operating_prev),2).")"}}@endif</b></div>
                                        <div class="third"><b>@if($operating_bal >= 0){{number_format($operating_bal,2)}}@else{{"(".number_format(abs($operating_bal),2).")"}}@endif</b></div>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    @endif

                    <tr><td class="head-title"></td></tr>
                    <tr>
                        <td class="head-title">                                                    
                            <span style="display:flex">
                                <span class="text-left" style="width:50%"><strong>Net Expense</strong></span>
                                <span style="display: flex;justify-content:space-between;width:50%" class="net-amount">
                                    <div class="first"><b>@if($net_expense >= 0){{number_format($net_expense,2)}}@else{{"(".number_format(abs($net_expense),2).")"}}@endif</b></div> 
                                    <div class="second"><b>@if($net_expense_prev >= 0){{number_format($net_expense_prev,2)}}@else{{"(".number_format(abs($net_expense_prev),2).")"}}@endif</b></div>
                                    <div class="third"><b>@if($net_expense_bal >= 0){{number_format($net_expense_bal,2)}}@else{{"(".number_format(abs($net_expense_bal),2).")"}}@endif</b></div>
                                </span>
                            </span>
                        </td>
                    </tr>
                <!-- Close Expense -->

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    function downloadProfitLossBalance(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var search_type = '<?php echo json_encode($search_type); ?>';
            var date = '<?php echo json_encode($date); ?>';
            var prev_from_date = '<?php echo json_encode($prev_from_date); ?>';
            var prev_to_date = '<?php echo json_encode($prev_to_date); ?>';
            var comparison = '1';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            search_type = JSON.parse(search_type);
            date = JSON.parse(date);
            prev_from_date = JSON.parse(prev_from_date);
            prev_to_date = JSON.parse(prev_to_date);
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-profit-loss-statement-comparison-excel')}}';
            }
            else if(type == 'pdf-nd'){
                var url = '{{route('v1.accounts.download-profit-loss-statement-comparison-pdf-nd')}}';
            }
            else if(type == 'excel-nd'){
                var url = '{{route('v1.accounts.download-profit-loss-statement-comparison-excel-nd')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,search_type:search_type,date:date,prev_from_date:prev_from_date,prev_to_date:prev_to_date,comparison:comparison},    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel' || type == 'excel-nd')
                    downloadLink.setAttribute('download', 'profit_loss.xls');

                else if(type == 'pdf-nd')                     
                    downloadLink.setAttribute('download', 'profit_loss.pdf');
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