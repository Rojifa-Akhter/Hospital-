
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
    .bottom-border{
        border-bottom:1px solid #000;
    }
    .section-gap{
        padding-top:15px;
    }

</style>

    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Statement of Financial Position
        </h5>
        @if($search_type == 'daily')
       <h6 class="mb" style="margin:0px 0px;font-size:12px"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
        @else
            @php                             
                $date_parts = explode('/', $date);
                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                $timestamp = strtotime($correct_format);
                $formattedDate = date('F Y', $timestamp);                        
            @endphp
        <h6 class="mb" style="margin:0px 0px;font-size:12px"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
        @endif
    </div>

    <table style="width: 100%;border-spacing: 0px;margin-top:35px" cellpadding="1" class="balancesheet-table">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th class="text-center"  style="border-bottom:1px solid #000;border-top:1px solid #000;">{{ $formattedDate = date('d F Y', strtotime($to_date)) }}</th>
              
            </tr>
            <tr style="border-spacing: 5px;">
                <th class="text-center"></th>
                <th class="text-center" style="border-bottom:1px solid #000;">Notes</th>
                <th class="text-center" style="border-bottom:1px solid #000;">Taka</th>                              
            </tr>
        </thead>
        <tbody>  
                
            @if(!empty($root_info))
            <!-- Non Current Assets -->
                <tr>
                    <td colspan="3"><strong><u>ASSETS:</u></strong></td>
                </tr>
                <tr>
                    <td colspan="3" ><strong>Non Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                @php 
                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                @endphp  
                <tr>
                        <td class="lh-10">{{$key}}</td>
                        <td class="lh-10 text-center">{{collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->where('acc_4type_name',$key)->count()}}</td>
                        <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php $net_non_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('amount') @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Non Current Assets</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_ammount >= 0){{number_format($net_non_current_ammount,2)}}@else{{"(".number_format(abs($net_non_current_ammount),2).")"}}@endif</strong></td>
                </tr>
            <!-- Close Non Current Assets -->



            <!-- Current Assets -->
                <tr>
                    <td colspan="3"><strong>Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                    @php 
                        $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">{{collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->where('acc_4type_name',$key)->count()}}</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php $net_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('amount') @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Current Assets</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_current_ammount >= 0){{number_format($net_current_ammount,2)}}@else{{"(".number_format(abs($net_current_ammount),2).")"}}@endif</strong></td>
                </tr>
            <!-- Close Current Assets -->

            <!-- Total Assets -->
            <tr>
                @php $total_asset_balance  = floatVal($net_current_ammount) + floatVal($net_non_current_ammount); @endphp
                <td class="bottom-border" colspan="2"><strong>Total Assets</strong></td>
                <td class="text-right bottom-border"><strong>@if($total_asset_balance >= 0) {{number_format($total_asset_balance,2)}}@else{{"(".number_format(abs($total_asset_balance),2).")"}}@endif</strong></td>
            </tr>
            <!-- Close Total Assets -->

            <!-- Owners Equity -->
            <tr >
                <td colspan="3" class="section-gap"><strong><u>EQUITY:</u></strong></td>
            </tr>
            <tr>
                <td colspan="3"><strong>Owners Equity</strong></td>
            </tr>
            @foreach(collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->groupBy('acc_4type_name') as $key => $item)                                          
                @php 
                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                @endphp  
                <tr>
                        <td class="lh-10">{{$key}}</td>
                        <td class="lh-10 text-center">{{collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->where('acc_4type_name',$key)->count()}}</td>
                        <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                </tr>
            @endforeach                                                                                    

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
                <td colspan="2"><strong><small>Retained earnings</small> </strong></td>
                <td class="text-right border-top-none"><strong>@if($retained_earnings >= 0){{number_format($retained_earnings,2)}}@else{{"(".number_format(abs($retained_earnings),2).")"}}@endif</strong></td>
            </tr>
            <tr>
                @php $owners_equity = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('amount') + floatVal($retained_earnings) @endphp
                <td class="top-bottom-border" colspan="2"><strong>Net Owners Equity</strong></td>
                <td class="text-right top-bottom-border"><strong>@if($owners_equity >= 0){{number_format($owners_equity,2)}}@else{{"(".number_format(abs($owners_equity),2).")"}}@endif</strong></td>
            </tr>
            <!-- Close Owners Equity -->

            
            <!-- Non Current Liabilities-->
                <tr>
                    <td colspan="3" class="section-gap"><strong><u>LIABILITIES:</u></strong></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Non Current Liabilities</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    @php 
                    $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">{{collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->where('acc_4type_name',$key)->count()}}</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php $net_non_current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('amount') @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Non Current Liabilities</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_liability >= 0){{number_format($net_non_current_liability,2)}}@else{{"(".number_format(abs($net_non_current_liability),2).")"}}@endif</strong></td>
                </tr>

            <!-- Close Non Current Liabilities-->


            <!-- Current Liabilities -->
                
                <tr>
                    <td colspan="3"><strong>Current Liabilities</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    @php 
                        $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">{{collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->where('acc_4type_name',$key)->count()}}</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php $current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('amount') @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Current Liabilities</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($current_liability >= 0) {{number_format($current_liability,2)}}@else{{"(".number_format(abs($current_liability),2).")"}}@endif</strong></td>
                </tr>

                <tr>
                    @php $total_liability = $current_liability + $net_non_current_liability; @endphp
                    <td colspan="2" ><strong>Total Liabilities</strong></td>
                    <td class="text-right"><strong>@if($total_liability >= 0){{number_format($total_liability,2)}}@else{{"(".number_format(abs($total_liability),2).")"}}@endif</strong></td>
                </tr>

                <tr>
                    @php $total_liability_owners_equity = $total_liability + $owners_equity; @endphp
                    <td colspan="2"  class="top-bottom-border"><strong>Total Liabilities and Shareholders' Equity</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($total_liability_owners_equity >= 0){{number_format($total_liability_owners_equity,2)}}@else{{"(".number_format(abs($total_liability_owners_equity),2).")"}}@endif</strong></td>
                </tr>
            <!-- Close Current Liabilities -->
            @endif
        </tbody>
    </table>
