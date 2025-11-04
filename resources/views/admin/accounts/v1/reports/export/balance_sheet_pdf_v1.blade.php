
<style>
    table td {
        font-size: 15px;
        border-top: 1px solid #B4B5B6;
        border-left:none;
        border-right:none;
        padding-right:3px;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
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
        padding-left: 50px;
        /* border-top:1px solid #B4B5B6; */
        /* border-bottom:1px solid #B4B5B6; */
        border-left:none;
        border-right:none;
        font-size: 12px;
    }
    .description-level{
        padding:3px 0px;
        padding-left:20px; 
        font-size: 12px;
    }
    .first_row{
        border:none;
        padding-left: 50px
    }
    .head-title{
        border-left:none;
        border-right:none;
        text-align: left;
    }
    .border-top-none{
        border-top:none;
    }
</style>

    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Statement of Financial Position
        </h5>
        @if($search_type == 'daily')
       <h6 class="mb" style="margin:0px 0px"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
        @else
            @php                             
                $date_parts = explode('/', $date);
                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                $timestamp = strtotime($correct_format);
                $formattedDate = date('F Y', $timestamp);                        
            @endphp
        <h6 class="mb" style="margin:0px 0px"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
        @endif
    </div>

    <table style="width: 100%;border-spacing: 0px;margin-top:35px" cellpadding="1" class="balancesheet-table">

        <tbody>  
            <tr>
                <td class="text-left"><b>Assets</b></td>
                <td class="text-right"><b>Current</b></td>                              
            </tr>
            <tr>
                <td style="border-top:none"></td>
                <td  class="text-right" style="border-top:none">
                    <small> 
                        @if($search_type == 'daily')
                            {{@$from_date}}   {{@$to_date}}
                        @else
                        {{@$date}}
                        @endif
                    </small>
                </td>
            </tr>                 
            @if(!empty($root_info))
            <!-- Non Current Assets -->
                <tr>
                    <td colspan="2" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Non Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td colspan="2" class="first_row">                                                     
                            <details>
                                @php 
                                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                @endphp
                                <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                <table style="width:80%">
                                    <tbody>
                                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                        <tr>
                                            <td style="border:none">
                                                <details>
                                                    @php 
                                                        $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                    @endphp
                                                    <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                    <table style="width:80%">
                                                        <tbody>
                                                        
                                                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                        
                                                            <tr>                           
                                                                @php
                                                                    $gl_price = collect($item4)->sum('amount');                   
                                                                @endphp
                                                                <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                            </tr> 
                                                                
                                                    
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>                                                                                                                       
                        </td>
                    </tr>
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="2"></td></tr>
                <tr>
                    @php $net_non_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('amount') @endphp
                    <td class="head-title border-top-none"><strong>Net Non Current Assets</strong></td>
                    <td class="text-right border-top-none"><strong>@if($net_non_current_ammount >= 0) {{number_format($net_non_current_ammount,2)}} @else {{"(".number_format(abs($net_non_current_ammount),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Non Current Assets -->



            <!-- Current Assets -->
                <tr>
                    <td colspan="2" class="head-title"><strong>Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td colspan="2" class="first_row">                                                     
                            <details>
                                @php 
                                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                @endphp
                                <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                <table style="width:80%">
                                    <tbody>
                                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                        <tr>
                                            <td style="border:none">
                                                <details>
                                                    @php 
                                                        $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                    @endphp
                                                    <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                    <table style="width:80%">
                                                        <tbody>
                                                        
                                                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                        
                                                            <tr>                           
                                                                @php
                                                                    $gl_price = collect($item4)->sum('amount');                   
                                                                @endphp
                                                                <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                            </tr> 
                                                                
                                                    
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>                                                                                                                       
                        </td>
                    </tr>
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="2"></td></tr>
                <tr>
                    @php $net_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('amount') @endphp
                    <td class="head-title border-top-none"><strong>Net Current Assets</strong></td>
                    <td class="text-right border-top-none"><strong>@if($net_current_ammount >= 0) {{number_format($net_current_ammount,2)}} @else {{"(".number_format(abs($net_current_ammount),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Current Assets -->

            <!-- Total Assets -->
            <tr>
                @php $total_asset_balance  = floatVal($net_current_ammount) + floatVal($net_non_current_ammount); @endphp
                <td class="bottom-border"><strong>Total Assets</strong></td>
                <td class="text-right bottom-border"><strong>@if($total_asset_balance >= 0) {{number_format($total_asset_balance,2)}} @else {{"(".number_format(abs($total_asset_balance),2).")"}} @endif</strong></td>
            </tr>
            <!-- Close Total Assets -->


            <!-- Current Liabilities -->
                <tr>
                    <td colspan="2" class="head-title"><strong>Liabilities and Shareholders' Equity</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="head-title"><strong>Current Liabilities</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td colspan="2" class="first_row">                                                     
                            <details>
                                @php 
                                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                @endphp
                                <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                <table style="width:80%">
                                    <tbody>
                                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                        <tr>
                                            <td style="border:none">
                                                <details>
                                                    @php 
                                                        $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                    @endphp
                                                    <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                    <table style="width:80%">
                                                        <tbody>
                                                        
                                                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                        
                                                            <tr>                           
                                                                @php
                                                                    $gl_price = collect($item4)->sum('amount');                   
                                                                @endphp
                                                                <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                            </tr> 
                                                                
                                                    
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>                                                                                                                       
                        </td>
                    </tr>
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="2"></td></tr>
                <tr>
                    @php $current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('amount') @endphp
                    <td class="head-title border-top-none"><strong>Net Current Liabilities</strong></td>
                    <td class="text-right border-top-none"><strong>@if($current_liability >= 0) {{number_format($current_liability,2)}} @else {{"(".number_format(abs($current_liability),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Current Liabilities -->

            <!-- Owners Equity -->
                <tr>
                    <td colspan="2" class="head-title"><strong>Owners Equity</strong></td>
                </tr>
                @foreach(collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td colspan="2" class="first_row">                                                     
                            <details>
                                @php 
                                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                @endphp
                                <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                <table style="width:80%">
                                    <tbody>
                                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                        <tr>
                                            <td style="border:none">
                                                <details>
                                                    @php 
                                                        $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                    @endphp
                                                    <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                    <table style="width:80%">
                                                        <tbody>
                                                        
                                                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                        
                                                            <tr>                           
                                                                @php
                                                                    $gl_price = collect($item4)->sum('amount');                   
                                                                @endphp
                                                                <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                            </tr> 
                                                                
                                                    
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>                                                                                                                       
                        </td>
                    </tr>
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="2"></td></tr>
                <tr>

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

                   
                    <td class="head-title border-top-none"><strong><small>Retained earnings</small> </strong></td>
                    <td class="text-right border-top-none"><strong>@if($retained_earnings >= 0) {{number_format($retained_earnings,2)}} @else {{"(".number_format(abs($retained_earnings),2).")"}} @endif</strong></td>
                </tr>
                <tr>
                    @php $owners_equity = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('amount') + floatVal($retained_earnings) @endphp
                    <td class="head-title"><strong>Net Owners Equity</strong></td>
                    <td class="text-right"><strong>@if($owners_equity >=0){{number_format($owners_equity,2)}} @else {{"(".number_format(abs($owners_equity),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Owners Equity -->

            <!-- Non Current Liabilities-->
                <tr>
                    <td colspan="2" class="head-title"><strong>Non Current Liabilities</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td colspan="2" class="first_row">                                                     
                            <details>
                                @php 
                                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                @endphp
                                <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                <table style="width:80%">
                                    <tbody>
                                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                        <tr>
                                            <td style="border:none">
                                                <details>
                                                    @php 
                                                        $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                                    @endphp
                                                    <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                    <table style="width:80%">
                                                        <tbody>
                                                        
                                                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                        
                                                            <tr>                           
                                                                @php
                                                                    $gl_price = collect($item4)->sum('amount');                   
                                                                @endphp
                                                                <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                            </tr> 
                                                                
                                                    
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </details>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </details>                                                                                                                       
                        </td>
                    </tr>
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="2"></td></tr>
                <tr>
                    @php $net_non_current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('amount') @endphp
                    <td class="head-title border-top-none"><strong>Net Non Current Liabilities</strong></td>
                    <td class="text-right border-top-none"><strong>@if($net_non_current_liability >= 0) {{number_format($net_non_current_liability,2)}} @else {{"(".number_format(abs($net_non_current_liability),2).")"}} @endif</strong></td>
                </tr>

                <tr>
                    @php $total_liability_owners_equity = $current_liability + $owners_equity + $net_non_current_liability; @endphp
                    <td class="head-title"><strong>Total Liabilities and Shareholders' Equity</strong></td>
                    <td class="text-right"><strong>@if($total_liability_owners_equity >= 0) {{number_format($total_liability_owners_equity,2)}} @else {{"(".number_format(abs($total_liability_owners_equity),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Non Current Liabilities-->
            @endif
        </tbody>
    </table>
