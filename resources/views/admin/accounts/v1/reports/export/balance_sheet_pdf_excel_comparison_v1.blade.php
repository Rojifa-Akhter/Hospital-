
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
        text-align:right ;
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
    a{
        text-decoration: none;
    }
</style>
@php 
   $formated_prev_to_date = date("Y-m-d", strtotime(@$prev_to_date));
@endphp
    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Statement of Financial Position
        </h5>
        @if($search_type == 'daily')
       <h6 class="mb" style="margin:0px 0px;font-size: 12px"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
        @else
            @php                             
                $date_parts = explode('/', $date);
                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                $timestamp = strtotime($correct_format);
                $formattedDate = date('F Y', $timestamp);                        
            @endphp
        <h6 class="mb" style="margin:0px 0px;font-size: 12px"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
        @endif
    </div>

    <table style="width: 100%;border-spacing: 0px;margin-top:35px" cellpadding="1" class="balancesheet-table">
        <thead>
            <tr>
                <th style="width:50%"></th>
                <th style="width:8%"></th>
                <th class="text-right"  style="border-bottom:1px solid #000;border-top:1px solid #000;width:22%"><small style="font-size: 12px"> {{ date("d F Y", strtotime($to_date)) }}</small></th>
                <th class="text-right"  style="border-bottom:1px solid #000;border-top:1px solid #000;width:22%"><small style="font-size: 12px">{{ date("d F Y", strtotime($prev_to_date)) }}</small></th>
                {{-- <th></th> --}}
              
            </tr>
            <tr style="border-spacing: 5px;">
                <th class="text-center" style="width:50%"></th>
                <th class="text-center" style="border-bottom:1px solid #000;width:8%" >Notes</th>
                <th class="text-right" style="border-bottom:1px solid #000;width:22%" >Taka</th>                              
                <th class="text-right" style="border-bottom:1px solid #000;width:22%" >Taka</th>                              
                {{-- <th class="text-right" style="border-bottom:1px solid #000;">Balance</th> --}}
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
                    $type_price_prev = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                    $type_price_bal = floatVal($type_price_prev) - floatVal($type_price) ;    
                @endphp  
                <tr>
                        <td class="lh-10">{{$key}}</td>
                        <td class="lh-10 text-center">@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</td>
                        <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                        <td class="text-right lh-10">@if($type_price_prev >= 0) {{number_format($type_price_prev,2)}} @else {{"(".number_format(abs($type_price_prev),2).")"}} @endif</td>
                        {{-- <td class="text-right lh-10">@if($type_price_bal >= 0) {{number_format($type_price_bal,2)}} @else {{"(".number_format(abs($type_price_bal),2).")"}} @endif</td> --}}
                </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php 
                        $net_non_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('amount') ;
                        $net_non_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('prev_amount') ;
                        $net_non_current_ammount_bal = floatVal($net_non_current_ammount_prev) + floatVal($net_non_current_ammount);
                    @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Non Current Assets</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_ammount >= 0){{number_format($net_non_current_ammount,2)}}@else{{"(".number_format(abs($net_non_current_ammount),2).")"}}@endif</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_ammount_prev >= 0){{number_format($net_non_current_ammount_prev,2)}}@else{{ "(".number_format(abs($net_non_current_ammount_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right top-bottom-border"><strong>@if($net_non_current_ammount_bal >= 0) {{number_format($net_non_current_ammount_bal,2)}} @else {{"(".number_format(abs($net_non_current_ammount_bal),2).")"}} @endif</strong></td> --}}
                </tr>
            <!-- Close Non Current Assets -->



            <!-- Current Assets -->
                <tr>
                    <td colspan="3"><strong>Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                    @php 
                        $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));  
                        $type_price_prev = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                        $type_price_bal = floatVal($type_price_prev) - floatVal($type_price) ;   
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>                            
                            <td class="text-right lh-10">@if($type_price_prev >= 0) {{number_format($type_price_prev,2)}} @else {{"(".number_format(abs($type_price_prev),2).")"}} @endif</td>
                            {{-- <td class="text-right lh-10">@if($type_price_bal >= 0) {{number_format($type_price_bal,2)}} @else {{"(".number_format(abs($type_price_bal),2).")"}} @endif</td> --}}
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php 
                        $net_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('amount'); 
                        $net_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('prev_amount') ;
                        $net_current_ammount_bal = floatVal($net_current_ammount_prev) - floatVal($net_current_ammount);
                    @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Current Assets</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_current_ammount >= 0){{number_format($net_current_ammount,2)}}@else{{"(".number_format(abs($net_current_ammount),2).")"}}@endif</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_current_ammount_prev >= 0){{number_format($net_current_ammount_prev,2)}}@else{{ "(".number_format(abs($net_current_ammount_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right top-bottom-border"><strong>@if($net_current_ammount_bal >= 0) {{number_format($net_current_ammount_bal,2)}} @else {{"(".number_format(abs($net_current_ammount_bal),2).")"}} @endif</strong></td> --}}
                </tr>
            <!-- Close Current Assets -->

            <!-- Total Asstes -->
            <tr>
                <td class="head-title bottom-border" colspan="2">
                    @php 
                    $total_current_asset = floatVal($net_current_ammount) + floatVal($net_non_current_ammount);

                    $total_current_asset_prev = floatVal($net_current_ammount_prev) + floatVal($net_non_current_ammount_prev);

                    $total_asset_balance  = floatVal($total_current_asset_prev) - floatVal($total_current_asset)
                                               
                    @endphp
                   <b>Total Assets</b> 
                </td>
                <td class="text-right bottom-border"><div class="first"><b>@if($total_current_asset >= 0){{number_format($total_current_asset,2)}}@else{{ "(".number_format(abs($total_current_asset),2).")"}}@endif</b></div></td>
                <td class="text-right bottom-border"><div class="second"><b>@if($total_current_asset_prev >= 0){{number_format($total_current_asset_prev,2)}}@else{{ "(".number_format(abs($total_current_asset_prev),2).")"}}@endif</b></div></td>
                {{-- <td class="text-right bottom-border"><div class="third"><b>@if($total_asset_balance >= 0) {{number_format($total_asset_balance,2)}} @else {{ "(".number_format(abs($total_asset_balance),2).")"}} @endif</b></div></td> --}}
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
                $type_price_prev = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                $type_price_bal = floatVal($type_price_prev) - floatVal($type_price) ; 
                @endphp  
                <tr>
                        <td class="lh-10">{{$key}}</td>
                        <td class="lh-10 text-center">@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</td>
                        <td class="text-right lh-10">@if($type_price >= 0){{number_format($type_price,2)}}@else{{"(".number_format(abs($type_price),2).")"}}@endif</td>                      
                        <td class="text-right lh-10">@if($type_price_prev >= 0){{number_format($type_price_prev,2)}}@else{{"(".number_format(abs($type_price_prev),2).")"}}@endif</td>
                        {{-- <td class="text-right lh-10">@if($type_price_bal >= 0) {{number_format($type_price_bal,2)}} @else {{"(".number_format(abs($type_price_bal),2).")"}} @endif</td> --}}
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

                <td colspan="2"><strong><small>Retained earnings</small> </strong></td>
                <td class="text-right"><strong>@if($retained_earnings >= 0){{number_format($retained_earnings,2)}}@else{{"(".number_format(abs($retained_earnings),2).")"}}@endif</strong></td>
                <td class="text-right"><strong>@if($retained_earnings_prev >= 0){{number_format($retained_earnings_prev,2)}}@else{{"(".number_format(abs($retained_earnings_prev),2).")"}}@endif</strong></td>
                {{-- <td class="text-right"><strong>@if($retained_earnings_bal >= 0) {{number_format($retained_earnings_bal,2)}} @else {{"(".number_format(abs($retained_earnings_bal),2).")"}} @endif</strong></td> --}}
            </tr>
            <tr>
                @php 
                    $owners_equity = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('amount') + floatVal($retained_earnings);
                    $owners_equity_prev = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('prev_amount') + floatVal($retained_earnings_prev);
                    $owners_equity_bal = floatVal($owners_equity_prev) - floatVal($owners_equity);
                @endphp
                <td class="top-bottom-border" colspan="2"><strong>Net Owners Equity</strong></td>
                <td class="text-right top-bottom-border"><strong>@if($owners_equity >= 0){{number_format($owners_equity,2)}}@else{{"(".number_format(abs($owners_equity),2).")"}}@endif</strong></td>
                <td class="text-right top-bottom-border"><strong>@if($owners_equity_prev >= 0){{number_format($owners_equity_prev,2)}}@else{{"(".number_format(abs($owners_equity_prev),2).")"}}@endif</strong></td>
                {{-- <td class="text-right top-bottom-border"><strong>@if($owners_equity_bal >= 0) {{number_format($owners_equity_bal,2)}} @else {{"(".number_format(abs($owners_equity_bal),2).")"}} @endif</strong></td> --}}
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
                    $type_price_prev = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                    $type_price_bal = floatVal($type_price_prev) - floatVal($type_price) ;     
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>                           
                            <td class="text-right lh-10">@if($type_price_prev >= 0) {{number_format($type_price_prev,2)}} @else {{"(".number_format(abs($type_price_prev),2).")"}} @endif</td>
                            {{-- <td class="text-right lh-10">@if($type_price_bal >= 0) {{number_format($type_price_bal,2)}} @else {{"(".number_format(abs($type_price_bal),2).")"}} @endif</td> --}}
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php 
                        $net_non_current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('amount') ;
                        $net_non_current_liability_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('prev_amount') ;
                        $net_non_current_liability_bal = floatVal($net_non_current_liability_prev) - floatVal($net_non_current_liability);
                    @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Non Current Liabilities</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_liability >= 0){{number_format($net_non_current_liability,2)}}@else{{"(".number_format(abs($net_non_current_liability),2).")"}}@endif</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($net_non_current_liability_prev >= 0){{number_format($net_non_current_liability_prev,2)}}@else{{"(".number_format(abs($net_non_current_liability_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right top-bottom-border"><strong>@if($net_non_current_liability_bal >= 0){{number_format($net_non_current_liability_bal,2)}} @else {{"(".number_format(abs($net_non_current_liability_bal),2).")"}} @endif</strong></td> --}}
                </tr>

            <!-- Close Non Current Liabilities-->


            <!-- Current Liabilities -->
                
                <tr>
                    <td colspan="3"><strong>Current Liabilities</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    @php 
                        $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount')); 
                        $type_price_prev = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
                        $type_price_bal = floatVal($type_price_prev) - floatVal($type_price) ;     
                    @endphp  
                    <tr>
                            <td class="lh-10">{{$key}}</td>
                            <td class="lh-10 text-center">@isset($item[0]->bl_notes)<a href="{{route('v1.accounts.notes-report')}}?bl_notes={{$item[0]->bl_notes}}&type_id={{$item[0]->acc_4type_no_fk}}&prev_date={{@$formated_prev_to_date}}&&to_date={{@$to_date}}" target="_blank">{{$item[0]->bl_notes}} </a>@endisset</td>
                            <td class="text-right lh-10">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>                           
                            <td class="text-right lh-10">@if($type_price_prev >= 0) {{number_format($type_price_prev,2)}} @else {{"(".number_format(abs($type_price_prev),2).")"}} @endif</td>
                            {{-- <td class="text-right lh-10">@if($type_price_bal >= 0) {{number_format($type_price_bal,2)}} @else {{"(".number_format(abs($type_price_bal),2).")"}} @endif</td> --}}
                    </tr>
                @endforeach                                                                                    
                
                <tr>
                    @php 
                        $current_liability = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('amount') ;
                        $current_liability_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('prev_amount') ;
                        $current_liability_bal = floatVal($current_liability_prev) - floatVal($current_liability);
                    @endphp
                    <td class="top-bottom-border" colspan="2"><strong>Net Current Liabilities</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($current_liability >= 0){{number_format($current_liability,2)}}@else{{"(".number_format(abs($current_liability),2).")"}}@endif</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($current_liability_prev >= 0){{number_format($current_liability_prev,2)}}@else{{"(".number_format(abs($current_liability_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right top-bottom-border"><strong>@if($current_liability_bal >= 0){{number_format($current_liability_bal,2)}} @else {{"(".number_format(abs($current_liability_bal),2).")"}} @endif</strong></td> --}}
                </tr>

                <tr>
                    @php 

                        $total_liability = floatVal($current_liability) + floatVal($net_non_current_liability); 
                        $total_liability_prev = floatVal($current_liability_prev) + floatVal($net_non_current_liability_prev); 
                        $total_liability_bal = floatVal($total_liability_prev) - floatVal($total_liability); 
                        
                    @endphp
                    <td colspan="2" ><strong>Total Liabilities</strong></td>
                    <td class="text-right"><strong>@if($total_liability >= 0){{number_format($total_liability,2)}}@else{{"(".number_format(abs($total_liability),2).")"}}@endif</strong></td>
                    <td class="text-right"><strong>@if($total_liability_prev >= 0){{number_format($total_liability_prev,2)}}@else{{"(".number_format(abs($total_liability_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right"><strong>@if($total_liability_bal >= 0){{number_format($total_liability_bal,2)}} @else {{"(".number_format(abs($total_liability_bal),2).")"}} @endif</strong></td> --}}
                </tr>

                <tr>
                    @php 
                        $total_liability_owners_equity = floatVal($total_liability) + floatVal($owners_equity); 
                        $total_liability_owners_equity_prev = floatVal($total_liability_prev) + floatVal($owners_equity_prev); 
                        $total_liability_owners_equity_bal = floatVal($total_liability_owners_equity_prev) - floatVal($total_liability_owners_equity); 
                        
                    @endphp
                    <td colspan="2"  class="top-bottom-border"><strong>Total Liabilities and Shareholders' Equity</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($total_liability_owners_equity >= 0){{number_format($total_liability_owners_equity,2)}}@else{{"(".number_format(abs($total_liability_owners_equity),2).")"}}@endif</strong></td>
                    <td class="text-right top-bottom-border"><strong>@if($total_liability_owners_equity_prev >= 0){{number_format($total_liability_owners_equity_prev,2)}}@else{{"(".number_format(abs($total_liability_owners_equity_prev),2).")"}}@endif</strong></td>
                    {{-- <td class="text-right top-bottom-border"><strong>@if($total_liability_owners_equity_bal >= 0){{number_format($total_liability_owners_equity_bal,2)}} @else {{"(".number_format(abs($total_liability_owners_equity_bal),2).")"}} @endif</strong></td> --}}
                </tr>
            <!-- Close Current Liabilities -->
            @endif
        </tbody>
    </table>
