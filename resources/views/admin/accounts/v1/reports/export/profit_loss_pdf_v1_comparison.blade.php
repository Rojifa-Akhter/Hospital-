
<style>
    table td {
        font-size: 15px;
        border: none;
        padding: 0px 3px;
    }
    table>tbody>tr{
        padding: 2px;
        line-height: 18px;
        margin:4px 0px;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
    }
    .text-center{
        text-align: center;
    }
    .lh-10{
        line-height: 10px;
    }
    .top-bottom-border{
        border-top:1px solid #000;
        border-bottom:1px solid #000;
    }
    .top-border{
        border-top:1px solid #000;
    }
    .section-gap{
        padding-top:15px;
    }
    .profitloss-table{
        margin-top:20px;
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


        //previous info
        $prev_income = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_cr');
        $prev_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_dr');
        $prev_operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('prev_dr');
        $prev_operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('prev_cr');
        $prev_operating_gain_loss = floatVal($prev_operating_gain_loss_dr) - floatVal($prev_operating_gain_loss_cr);
        
        if($prev_operating_gain_loss < 0){
            $prev_expense += abs($prev_operating_gain_loss);
        }
        else{
            $prev_income += $operating_gain_loss;
        }
        
        $prev_retained_earnings = floatVal($prev_income) - floatVal($prev_expense); 

        $bal_operating_gain_loss = floatVal($operating_gain_loss) - floatVal($prev_operating_gain_loss);

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

    <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="profitloss-table">
        <thead>
            <tr>
                <td class="text-left" style="widht:55%"><b>Particulars</b></td>
                <td class="text-right" style="widht:15%"><b>Current</b></td>                              
                <td class="text-right" style="widht:15%"><b>Previous</b></td>                              
                <td class="text-right" style="widht:15%"><b>Diff. Amtount</b></td>                              
            </tr>
            <tr>
                <td style="border-top:none;widht:55%"></td>
                <td  class="text-right" style="border-top:none;widht:15%;font-weigt:normal">
                    <small> 
                        {{date("d/m/Y", strtotime(@$from_date))}} - {{date("d/m/Y", strtotime(@$to_date))}}
                    </small>
                </td>
                <td  class="text-right" style="border-top:none;widht:15%;font-weigt:normal">
                    <small> 
                        {{date("d/m/Y", strtotime(@$prev_from_date))}} - {{date("d/m/Y", strtotime(@$prev_to_date))}}
                    </small>
                </td>
                <td  class="text-right" style="border-top:none;widht:15%;font-weigt:normal">
                </td>
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
                        <td class="first_row lh-10">                                                                        
                            @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                                $prev_type_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_cr')); 
                                $bal_amount = floatVal($type_price) - floatVal($prev_type_price);
                            @endphp
                            <span style="padding: 1px;font-size:12px">{{$key}}</span>                                                                                                                    
                        </td>

                        <td class="text-right lh-10">
                           @if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif
                        </td>
                        <td class="text-right lh-10">
                           @if($prev_type_price >= 0) {{number_format($prev_type_price,2)}} @else {{"(".number_format(abs($prev_type_price),2).")"}} @endif
                        </td>

                        <td class="text-right lh-10">
                           @if($bal_amount >= 0) {{number_format($bal_amount,2)}} @else {{"(".number_format(abs($bal_amount),2).")"}} @endif
                        </td>
                    </tr>
                @endforeach                                                                                    
                
                                                                
                <!-- Operating Expense -->
                
                @if($operating_gain_loss > 0 || $prev_operating_gain_loss > 0)
                
                    <tr>
                        <td class="head-title"><strong>Operating Gain</strong></td>
                        <td class="text-right">@if($operating_gain_loss >= 0) {{number_format($operating_gain_loss,2)}} @else {{"(".number_format(abs($operating_gain_loss),2).")"}} @endif</td>
                        <td class="text-right">@if($prev_operating_gain_loss >= 0) {{number_format($prev_operating_gain_loss,2)}} @else {{"(".number_format(abs($prev_operating_gain_loss),2).")"}} @endif</td>
                        <td class="text-right">@if($bal_operating_gain_loss >= 0) {{number_format($bal_operating_gain_loss,2)}} @else {{"(".number_format(abs($bal_operating_gain_loss),2).")"}} @endif</td>
                    </tr>
                    <tr><td class="head-title" colspan="4"></td></tr>                                                                               
                @endif
                <!-- Close Operating Expense -->
                                                                                                                   
                <tr>
                    @php 
                        $net_income_ammount = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                        if($operating_gain_loss > 0){
                            $net_income_ammount+= $operating_gain_loss;
                        }

                        $prev_net_income_ammount = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_cr');
                        if($prev_operating_gain_loss > 0){
                            $prev_net_income_ammount+= $prev_operating_gain_loss;
                        }       
                        $bal_income_amount = floatVal($net_income_ammount) - floatVal($prev_net_income_ammount);       
                    @endphp
                    <td class="head-title  border-top-none"><strong>Net Income</strong></td>
                    <td class="text-right border-top-none"><strong>@if($net_income_ammount >= 0){{number_format($net_income_ammount,2)}}@else{{"(".number_format(abs($net_income_ammount),2).")"}}@endif</strong></td>
                    <td class="text-right border-top-none"><strong>@if($prev_net_income_ammount >= 0){{number_format($prev_net_income_ammount,2)}}@else{{"(".number_format(abs($prev_net_income_ammount),2).")"}}@endif</strong></td>
                    <td class="text-right border-top-none"><strong>@if($bal_income_amount >= 0){{number_format($bal_income_amount,2)}}@else{{"(".number_format(abs($bal_income_amount),2).")"}}@endif</strong></td>
                </tr>
            <!-- Close Income -->

            <!-- Expenses -->
                <tr>
                    <td colspan="4" class="head-title" style="padding-top: 15px"><strong>Expenses</strong></td>
                </tr>
                @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>                     
                        <td class="first_row lh-10">                                                                        
                            @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('dr'));    
                                $prev_type_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_dr'));  
                                $bal_amount = floatVal($type_price) - floatVal($prev_type_price);  
                            @endphp
                            <span style="padding: 1px;font-size:12px">{{$key}}</span>                                                                                                                    
                        </td>

                        <td class="text-right lh-10">
                            @if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif
                        </td>
                        <td class="text-right lh-10">
                            @if($prev_type_price >= 0) {{number_format($prev_type_price,2)}} @else {{"(".number_format(abs($prev_type_price),2).")"}} @endif
                        </td>                       
                        <td class="text-right lh-10">
                            @if($bal_amount >= 0) {{number_format($bal_amount,2)}} @else {{"(".number_format(abs($bal_amount),2).")"}} @endif
                        </td>                       
                    </tr>
                @endforeach                                                                                    
              

                <!-- Operating Expense -->
                @if($operating_gain_loss < 0 || $prev_operating_gain_loss < 0)                            
                    <tr>
                        <td class="head-title"><strong>Operating Loss</strong></td>
                        <td class="text-right">{{"(".number_format(abs($operating_gain_loss),2).")"}}</td>
                        <td class="text-right">{{"(".number_format(abs($prev_operating_gain_loss),2).")"}}</td>
                        <td class="text-right">{{"(".number_format(abs($bal_operating_gain_loss),2).")"}}</td>
                    </tr>    
                    <tr><td class="head-title" colspan="4"></td></tr>
                @endif
                <!-- Close Operating Expense -->
                
                <tr>
                    @php 
                        $net_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
                        if($operating_gain_loss < 0){
                        $net_expense+= floatVal(abs($operating_gain_loss));
                        }

                        $prev_net_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('prev_dr');
                        if($prev_operating_gain_loss < 0){
                            $prev_net_expense+= floatVal(abs($prev_operating_gain_loss));
                        }

                        $bal_net_expense = floatVal($net_expense) - floatVal($prev_net_expense);
                        
                    @endphp
                    <td class="head-title"><b>Net Expense</b></td>
                    <td class="text-right"><b>@if($net_expense >=0)@if($net_expense >= 0){{number_format($net_expense,2)}}@else{{"(".number_format(abs($net_expense),2).")"}}@endif @else{{"(".number_format(abs($net_expense),2).")"}}@endif</b></td>
                    <td class="text-right"><b>@if($prev_net_expense >=0)@if($prev_net_expense >= 0){{number_format($prev_net_expense,2)}}@else{{"(".number_format(abs($prev_net_expense),2).")"}}@endif @else{{"(".number_format(abs($prev_net_expense),2).")"}}@endif</b></td>
                    <td class="text-right"><b>@if($bal_net_expense >=0)@if($bal_net_expense >= 0){{number_format($bal_net_expense,2)}}@else{{"(".number_format(abs($bal_net_expense),2).")"}}@endif @else{{"(".number_format(abs($bal_net_expense),2).")"}}@endif</b></td>
                </tr>

                {{-- <tr>   
                    @php 
                        $retained_earnings = floatVal($retained_earnings) - floatVal($prev_retained_earnings)
                    @endphp

                    <td class="head-title border-top-none" style="padding-top:20px; text-align:right"><strong>@if($retained_earnings >= 0) {{ 'Net Profit' }} @else {{ 'Net Loss' }} @endif</strong></td>
                    <td class="text-right border-top-none" style="padding-top:20px" colspan="2"><strong>@if($retained_earnings >= 0) {{number_format($retained_earnings,2)}} @else {{"(".number_format(abs($retained_earnings),2).")"}} @endif</strong></td>
                </tr> --}}
                
            <!-- Close Expense -->

            @endif
        </tbody>
    </table>
