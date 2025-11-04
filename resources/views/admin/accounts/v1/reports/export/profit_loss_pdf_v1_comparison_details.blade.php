
<style>
    table{
        border-collapse: collapse;
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
    div {
        cursor: pointer;
        outline: none;
        border: none
    } 
    div:not([open]) > *:not(div) {
        display: none;
        
    }
    div {
        border: none;
    }
    .gl-level{        
        padding-left: 50px !important;
        border-left:none;
        border-right:none;
        font-size: 11px;
    }
    .gl-price{
        font-size: 11px;
    }
    .py-0{
        padding-top:0px;
        padding-bottom:0px;
    }
    .description-level{
        padding-left:35px; 
        font-size: 12px;
    }
    .description-price{
        font-size: 12px;
    }
    .first_row{
        padding-left: 20px
    }
    .head-title{
        /* border-bottom: 1px solid #B4B5B6; */
        /* border-top:none; */
        border-left:none;
        border-right:none;
        text-align: left;
    }
    .border-y{
        border-top:1px solid #B4B5B6;
        border-bottom:1px solid #B4B5B6;
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
    .top_move{
        padding-left: 15px;
        margin-top: -18px;
    }
    .gl-show:last-child > td {
        border-bottom: none !important;
    }
    .net-amount{
        padding-left: 24px;
    }

</style>



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

    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Statement of  Profit or Loss
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

    <table style="width: 100%; border-spacing: 0px; margin-top:35px" cellpadding="1" class="balancesheet-table">
            <thead>
                <tr>
                    <td><b>Particulars</b></td>
                    <td class="first"><b>Current</b></td> 
                    <td class="second"><b>Previous</b></td>
                    <td class="third"><b>Difference Amount</b></td>
                </tr>

                <tr>
                    <td></td>  
                    <td class="first">
                        <b>
                            <small> 
                                @if($search_type == 'daily')
                                    {{date("d/m/Y",strtotime($from_date))}} -  {{date("d/m/Y",strtotime($to_date))}}
                                @else
                                {{@$date}}
                                @endif
                            </small>
                        </b>
                    </td> 
                    <td class="second">
                        <b>
                            <small> 
                                {{ date("d/m/Y", strtotime(@$prev_from_date))}} -  {{date("d/m/Y", strtotime(@$prev_to_date))}}                   
                            </small>
                        </b>
                    </td> 
                    <td></td>        
                </tr>
            </thead>
            <tbody>                   
                @if(!empty($profit_loss))
                <!-- Income -->
                    <tr>
                        <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Income</strong></td>
                    </tr>
                    
                    @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                        <tr>
                            <td style="width:70%" class="first_row">
                                @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                                $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_cr'));    
                                $balance =  floatVal($prev_price) - floatVal($type_price);    
                                @endphp
                            <b>{{$key}} </b>
                            </td>
                            <td><div class="first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div></td>
                            <td><div class="second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third"><b>@if($balance >= 0) {{number_format($balance,2)}} @else {{ "(".number_format(abs($balance),2).")"}} @endif</b></div></td>
                        </tr>
                        @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                      
                            <tr>
                                <td class="description-level">
                                    @php 
                                    $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                    $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_cr'));    
                                    $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                    @endphp
                                <b>{{$key2}} </b>
                                </td>
                                <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                                <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                                <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                            </tr>

                            @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                                <tr class="gl-show">
                                    <td class="border-y  py-0">
                                        @php
                                            $gl_price = collect($item4)->sum('cr');                   
                                            $gl_prev_price = collect($item4)->sum('prev_cr');                   
                                            $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                        @endphp
                                       <span class="gl-level"> {{$key3}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$item4[0]->account_name}}</a></span>
                                    </td>
                                    <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                                    <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                                    <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                                </tr>
                            @endforeach 
                        @endforeach

                        
                    @endforeach                                                                                    
      

                    @if($prev_operating_gain_loss > 0 || $operating_gain_loss > 0)
                        <tr><td class="head-title" colspan="4"></td></tr>
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
                                <strong>Operating Gain</strong> 
                            </td>
                            <td class="first"><b>@if($operating >= 0) {{number_format($operating,2)}} @else {{"(".number_format(abs($operating),2).")"}} @endif</b></td> 
                            <td class="second"><b>@if($operating_prev >= 0) {{number_format($operating_prev,2)}} @else {{"(".number_format(abs($operating_prev),2).")"}} @endif</b></td>
                            <td class="third"><b>@if($operating_bal >= 0) {{number_format($operating_bal,2)}} @else {{"(".number_format(abs($operating_bal),2).")"}} @endif</b></td>
                        </tr>
                    @endif
                        
                    <tr>
                        <td class="head-title" style="border-top:none"><strong>Net Income</strong></td>
                        <td class="first" style="border-top:none"><b>@if($net_income >= 0){{number_format($net_income,2)}}@else{{"(".number_format(abs($net_income),2).")"}}@endif</b></td> 
                        <td class="second" style="border-top:none"><b>@if($net_income_prev >= 0){{number_format($net_income_prev,2)}}@else{{"(".number_format(abs($net_income_prev),2).")"}}@endif</b></td>
                        <td class="third" style="border-top:none"><b>@if($net_income_bal >= 0){{number_format($net_income_bal,2)}}@else{{"(".number_format(abs($net_income_bal),2).")"}}@endif</b></td>
                    </tr>
                <!-- Close Income -->   
                
                
                <!-- Expense -->
                <tr>
                    <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Expense</strong></td>
                </tr>
                
                @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td style="width:70%" class="first_row">
                            @php 
                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_cr'));    
                            $balance =  floatVal($prev_price) - floatVal($type_price);    
                            @endphp
                        <b>{{$key}} </b>
                        </td>
                        <td><div class="first"><b>@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</b></div></td>
                        <td><div class="second"><b>@if($prev_price >= 0) {{number_format($prev_price,2)}} @else {{ "(".number_format(abs($prev_price),2).")"}} @endif</b></div></td>
                        <td><div class="third"><b>@if($balance >= 0) {{number_format($balance,2)}} @else {{ "(".number_format(abs($balance),2).")"}} @endif</b></div></td>
                    </tr>
                    @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                  
                        <tr>
                            <td class="description-level">
                                @php 
                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_cr'));    
                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                @endphp
                            <b>{{$key2}} </b>
                            </td>
                            <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                            <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                        </tr>

                        @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                            <tr class="gl-show">
                                <td class="border-y gl-level py-0">
                                    @php
                                        $gl_price = collect($item4)->sum('cr');                   
                                        $gl_prev_price = collect($item4)->sum('prev_cr');                   
                                        $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                    @endphp
                                    {{$key3}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$item4[0]->account_name}}</a>
                                </td>
                                <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                                <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                                <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                            </tr>
                        @endforeach 
                    @endforeach

                   
                @endforeach                                                                                    
  

                @if($prev_operating_gain_loss < 0 || $operating_gain_loss < 0)
                    <tr><td class="head-title" colspan="4"></td></tr>
                    <tr>
                        <td class="head-title">
                            @php 
                                $operating = $operating_gain_loss > 0 ? $operating_gain_loss : 0;
                                $operating_prev = $prev_operating_gain_loss > 0 ? $prev_operating_gain_loss : 0;
                                $operating_bal = floatVal($operating_prev) - floatVal($operating);

                                $net_expense+= abs($operating_gain_loss < 0 ? $operating_gain_loss : 0);
                                $net_expense_prev+= abs($prev_operating_gain_loss < 0 ? $prev_operating_gain_loss : 0);
                                $net_expense_bal+= floatVal($net_expense_prev) - floatVal($net_expense);
                            @endphp                               
                            <strong>Operating Loss</strong> 
                        </td>
                        <td class="first"><b>@if($operating >= 0) {{number_format($operating,2)}} @else {{"(".number_format(abs($operating),2).")"}} @endif</b></td> 
                        <td class="second"><b>@if($operating_prev >= 0) {{number_format($operating_prev,2)}} @else {{"(".number_format(abs($operating_prev),2).")"}} @endif</b></td>
                        <td class="third"><b>@if($operating_bal >= 0) {{number_format($operating_bal,2)}} @else {{"(".number_format(abs($operating_bal),2).")"}} @endif</b></td>
                    </tr>
                @endif
                    
                <tr>
                    <td class="head-title" style="border-top:none"><strong>Net Expense</strong></td>
                    <td class="first" style="border-top:none"><b>@if($net_expense >= 0){{number_format($net_expense,2)}}@else{{"(".number_format(abs($net_expense),2).")"}}@endif</b></td> 
                    <td class="second" style="border-top:none"><b>@if($net_expense_prev >= 0){{number_format($net_expense_prev,2)}}@else{{"(".number_format(abs($net_expense_prev),2).")"}}@endif</b></td>
                    <td class="third" style="border-top:none"><b>@if($net_expense_bal >= 0){{number_format($net_expense_bal,2)}}@else{{"(".number_format(abs($net_expense_bal),2).")"}}@endif</b></td>
                </tr>
            <!-- Close Expense -->  
                @endif
            </tbody>
     
    </table>
