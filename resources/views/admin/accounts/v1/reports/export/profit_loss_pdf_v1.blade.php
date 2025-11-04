
<style>
    table{
        border-collapse: collapse
    }
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
    .lh-10{
        line-height: 10px;
    }
    details:not([open]) > *:not(summary) {
        display: none;
        padding: 0px;
        
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

    .gl-level-2{
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

    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Statement of Profit or Loss
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
        <h6 class="mb" style="text-transform: uppercase;margin:0px 0px"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
        @endif
    </div>

    <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="balancesheet-table">
        <thead>
            <tr>
                <td class="text-left"><b>Particulars</b></td>
                <td class="text-right"><b>Current</b></td>                              
            </tr>
            <tr>
                <td style="border-top:none"></td>
                <td  class="text-right" style="border-top:none">
                    <small> 
                        @if($search_type == 'daily')
                        {{date("d/m/Y", strtotime(@$from_date))}} - {{date("d/m/Y", strtotime(@$to_date))}}
                        @else
                        {{@$date}}
                        @endif
                    </small>
                </td>
            </tr>
        </thead>
        <tbody>                   
            
        </tbody>
    </table>


    @if(!empty($profit_loss))
            <!-- Income -->
            <div>
                <span class="head-title"><strong>Income</strong></span><br>
            </div>
            @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                   
            <div>
                <div class="first_row">                                                     
                        <details>
                            @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                            @endphp
                            <summary style="padding: 1px;font-size:12px">
                                <table  style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td style="border:none">{{$key}}</td>
                                            <td style="text-align:right;border:none"> @if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                        </tr>
                                    </tbody>
                                </table>                               
                            </summary>
                            <div style="width:85%">
                                <div>
                                    @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                    
                                            <details>
                                                @php 
                                                    $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                                @endphp
                                                
                                                <summary class="description-level" style="width:100%">
                                                    <table  style="width:100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border:none">{{$key2}}</td>
                                                                <td style="text-align:right;border:none">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </summary>
                                                <table style="width:85%">
                                                    <tbody>
                                                    
                                                        @foreach (collect($item2)->groupBy('account_code') as $key3 => $item4)
                                                        
                                                        <tr>                           
                                                            @php
                                                                $gl_price = collect($item4)->sum('cr');                   
                                                            @endphp
                                                            <td class="gl-level"><a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a> - {{$item4[0]->account_name}}</td>
                                                            <td class="gl-level-2" style="text-align: right;padding-left:3px" ><span>@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                        </tr> 
                                                            
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </details>
        
                                    @endforeach
                                </div>
                            </div>
                        </details>                                                                                                                       
                    </div>
            </div>
            @endforeach   
                
                
                 <!-- Operating Expense -->
                @if($operating_gain_loss > 0)
                 <div>
                     <div class="head-title" style="float:left"><strong>Operating Gain</strong></div>
                     <div class="text-right" style="float:right">@if($operating_gain_loss >= 0) {{number_format($operating_gain_loss,2)}} @else {{"(".number_format(abs($operating_gain_loss),2).")"}} @endif</div>
                 </div><br><br>                                                                      
                @endif
                <!-- Close Operating Expense -->



                <div>
                    @php 
                        $net_income_ammount = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                        if($operating_gain_loss > 0){
                            $net_income_ammount+= $operating_gain_loss;
                        }
                    @endphp
                    <div class="head-title  border-top-none" style="float:left"><strong>Net Income</strong></div>
                    <div class="text-right border-top-none" style="float:right"><strong>@if($net_income_ammount >= 0) {{number_format($net_income_ammount,2)}} @else {{"(".number_format(abs($net_income_ammount),2).")"}} @endif</strong></div>
                </div><br><br>
            <!-- Close Income -->


            <!-- Expenses -->

            <div>
                <span class="head-title"><strong>Expenses</strong></span><br>
            </div>
            @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                   
            <div>
                <div class="first_row">                                                     
                        <details>
                            @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                            @endphp
                            <summary style="padding: 1px;font-size:12px">
                                <table  style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td style="border:none">{{$key}}</td>
                                            <td style="text-align:right; border:none"> @if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                        </tr>
                                    </tbody>
                                </table>                               
                            </summary>
                            <div style="width:85%">
                                <div>
                                    @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                    
                                            <details>
                                                @php 
                                                    $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                                @endphp
                                                
                                                <summary class="description-level" style="width:100%">
                                                    <table  style="width:100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border:none">{{$key2}}</td>
                                                                <td style="text-align:right;border:none">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </summary>
                                                <table style="width:85%">
                                                    <tbody>
                                                    
                                                        @foreach (collect($item2)->groupBy('account_code') as $key3 => $item4)
                                                        
                                                        <tr>                           
                                                            @php
                                                                $gl_price = collect($item4)->sum('cr');                   
                                                            @endphp
                                                            <td class="gl-level"><a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a> - {{$item4[0]->account_name}}</td>
                                                            <td class="gl-level-2" style="text-align: right;padding-left:3px" ><span>@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                        </tr> 
                                                            
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </details>
        
                                    @endforeach
                                </div>
                            </div>
                        </details>                                                                                                                       
                    </div>
            </div>
            @endforeach 



            <!-- Operating Expense -->
            @if($operating_gain_loss < 0)   
                <div>
                    <div class="head-title" style="float:left"><strong>Operating Loss</strong></div>
                    <div class="text-right" style="float:right">{{"(".number_format(abs($operating_gain_loss),2).")"}}</div>
                </div><br><br> 
            @endif
            <!-- Close Operating Expense -->


            <div>
                @php 
                    $net_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
                    if($operating_gain_loss < 0){
                        $net_expense+= floatVal(abs($operating_gain_loss));
                    }
                    
                @endphp
                <div class="head-title " style="float:left"><strong>Net Expense</strong></div>
                <div class="text-right "><strong>@if($net_expense >=0) @if($net_expense >= 0) {{number_format($net_expense,2)}} @else {{"(".number_format(abs($net_expense),2).")"}} @endif @else {{"(".number_format(abs($net_expense),2).")"}} @endif</strong></div>
            </div><br><br> 

            <div>                           
                <div class="head-title border-top-none" style="padding-top:20px; float:left"><strong>@if($retained_earnings >= 0) {{ 'Net Profit' }} @else {{ 'Net Loss' }} @endif</strong></div>
                <div class="text-right border-top-none" style="padding-top:20px; float:right"><strong>@if($retained_earnings >= 0) {{number_format($retained_earnings,2)}} @else {{"(".number_format(abs($retained_earnings),2).")"}} @endif</strong></div>
            </div>
            
        
    @endif



    
