
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
        padding-left: 50px;
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

    <table style="width: 100%; border-spacing: 0px; margin-top:35px" cellpadding="1" class="balancesheet-table">
            <thead>
                <tr>
                    <td style="width:49%;"><b>Assets</b></td>
                    <td style="width:17%;text-align:right"><b>Current</b></td>
                    <td style="width:17%;text-align:right"><b>Previous</b></td>
                    <td style="width:17%;text-align:right"><b>Balance</b></td>
                </tr>

                <tr>
                    <td style="width:49%"></td>
                    <td style="text-align:right;width:17%;white-space:nowrap;font-size:10px">
                        <b>
                            <small> 
                                @if($search_type == 'daily')
                                    {{date("d F Y", strtotime(@$to_date))}}
                                @else
                                {{date('F Y', strtotime(@$formattedDate))}}
                                @endif
                            </small>
                        </b>
                    </td>
                    <td style="text-align:right;width:17%;white-space:nowrap;font-size:10px">
                        <b>
                            <small> 
                                @if($search_type == 'daily')
                                    {{date("d F Y", strtotime(@$prev_to_date))}}
                                @else
                                @endif
                            </small>
                        </b>
                    </td>
                    <td style="text-align:right;width:17%;white-space:nowrap;font-size:10px">
                        
                    </td>

                </tr>
            </thead>
            <tbody>                   
                @if(!empty($root_info))
                <!-- Non Current Assets -->
                    <tr>
                        <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Non Current Assets</strong></td>
                    </tr>
                    @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                        <tr>
                            <td style="width:70%" class="first_row">
                                @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                                $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
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
                                    $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                    $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                    $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                    @endphp
                                <b>{{$key2}} </b>
                                </td>
                                <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                                <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                                <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                            </tr>

                          
                        @endforeach

                        @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                            <tr class="gl-show">
                                <td class="border-y gl-level py-0">
                                    @php
                                        $gl_price = collect($item4)->sum('amount');                   
                                        $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                        $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                    @endphp
                                    {{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a>
                                </td>
                                <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                                <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                                <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                            </tr>
                        @endforeach 
                    @endforeach                                                                                    
                    <tr><td class="head-title" colspan="4"></td></tr>
                    <tr>
                        <td class="head-title" style="border-top:none">
                            @php 
                                $net_non_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('amount') ;
                                $net_non_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','FIXEDASSET')->sum('prev_amount') ;
                                $net_non_current_ammount_bal = floatVal($net_non_current_ammount_prev) - floatVal($net_non_current_ammount);
                            @endphp
                           <b>Net Non Current Assets</b> 
                        </td>
                        <td style="border-top:none"><div class="first"><b>@if($net_non_current_ammount >= 0) {{number_format($net_non_current_ammount,2)}} @else {{"(".number_format(abs($net_non_current_ammount),2).")"}} @endif</b></div></td>
                        <td style="border-top:none"><div class="second"><b>@if($net_non_current_ammount_prev >= 0) {{number_format($net_non_current_ammount_prev,2)}} @else {{ "(".number_format(abs($net_non_current_ammount_prev),2).")"}} @endif</b></div></td>
                        <td style="border-top:none"><div class="third"><b>@if($net_non_current_ammount_bal >= 0) {{number_format($net_non_current_ammount_bal,2)}} @else {{ "(".number_format(abs($net_non_current_ammount_bal),2).")"}} @endif</b></div></td>
                    </tr>
                <!-- Close Non Current Assets -->

                <!-- Current Assets -->
                <tr>
                    <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Current Assets</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td style="width:70%" class="first_row">
                            @php 
                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
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
                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                @endphp
                            <b>{{$key2}} </b>
                            </td>
                            <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                            <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                        </tr>

                      
                    @endforeach

                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                        <tr class="gl-show">
                            <td class="border-y gl-level py-0">
                                @php
                                    $gl_price = collect($item4)->sum('amount');                   
                                    $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                    $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                @endphp
                                {{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a>
                            </td>
                            <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                        </tr>
                    @endforeach 
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="4"></td></tr>
                <tr>
                    <td class="head-title" style="border-top:none">
                        @php 
                            $net_current_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('amount') ;
                            $net_current_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRASSET')->sum('prev_amount') ;
                            $net_current_ammount_bal = floatVal($net_current_ammount_prev) - floatVal($net_current_ammount);
                        @endphp
                       <b>Net Current Assets</b> 
                    </td>
                    <td style="border-top:none"><div class="first"><b>@if($net_current_ammount >= 0) {{number_format($net_current_ammount,2)}} @else {{"(".number_format(abs($net_current_ammount),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="second"><b>@if($net_current_ammount_prev >= 0) {{number_format($net_current_ammount_prev,2)}} @else {{ "(".number_format(abs($net_current_ammount_prev),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="third"><b>@if($net_current_ammount_bal >= 0) {{number_format($net_current_ammount_bal,2)}} @else {{ "(".number_format(abs($net_current_ammount_bal),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Current Assets -->

                <!-- Total Asstes -->
                <tr>
                    <td class="head-title">
                        @php 
                        $total_current_asset = floatVal($net_current_ammount) + floatVal($net_non_current_ammount);

                        $total_current_asset_prev = floatVal($net_current_ammount_prev) + floatVal($net_non_current_ammount_prev);

                        $total_asset_balance  = floatVal($total_current_asset_prev) - floatVal($total_current_asset)
                                                   
                        @endphp
                       <b>Total Assets</b> 
                    </td>
                    <td><div class="first"><b>@if($total_current_asset >= 0) {{number_format($total_current_asset,2)}} @else {{ "(".number_format(abs($total_current_asset),2).")"}} @endif</b></div></td>
                    <td><div class="second"><b>@if($total_current_asset_prev >= 0) {{number_format($total_current_asset_prev,2)}} @else {{ "(".number_format(abs($total_current_asset_prev),2).")"}} @endif</b></div></td>
                    <td><div class="third"><b>@if($total_asset_balance >= 0) {{number_format($total_asset_balance,2)}} @else {{ "(".number_format(abs($total_asset_balance),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Total Assets -->
                
                <!-- Current Liabilities -->
                <tr>
                    <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Current Liabilites</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td style="width:70%" class="first_row">
                            @php 
                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
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
                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                @endphp
                            <b>{{$key2}} </b>
                            </td>
                            <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                            <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                        </tr>

                      
                    @endforeach

                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                        <tr class="gl-show">
                            <td class="border-y gl-level py-0">
                                @php
                                    $gl_price = collect($item4)->sum('amount');                   
                                    $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                    $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                @endphp
                                {{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a>
                            </td>
                            <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                        </tr>
                    @endforeach 
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="4"></td></tr>
                <tr>
                    <td class="head-title" style="border-top:none">
                        @php 
                            $net_current_liabilities_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('amount') ;
                            $net_current_liabilities_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','CURRLIABILITIES')->sum('prev_amount') ;
                            $net_current_liabilities_ammount_bal = floatVal($net_current_liabilities_ammount_prev) - floatVal($net_current_liabilities_ammount);
                        @endphp
                       <b>Net Current Liabilites</b> 
                    </td>
                    <td style="border-top:none"><div class="first"><b>@if($net_current_liabilities_ammount >= 0) {{number_format($net_current_liabilities_ammount,2)}} @else {{ "(".number_format(abs($net_current_liabilities_ammount),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="second"><b>@if($net_current_liabilities_ammount_prev >= 0) {{number_format($net_current_liabilities_ammount_prev,2)}} @else {{ "(".number_format(abs($net_current_liabilities_ammount_prev),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="third"><b>@if($net_current_liabilities_ammount_bal >= 0) {{number_format($net_current_liabilities_ammount_bal,2)}} @else {{ "(".number_format(abs($net_current_liabilities_ammount_bal),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Current Liabilities -->

                <!-- Owners Equity -->
                <tr>
                    <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Owners Equity</strong></td>
                </tr>
                @foreach(collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td style="width:70%" class="first_row">
                            @php 
                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('owners_amount'));    
                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_owners_amount'));    
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
                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('owners_amount'));    
                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_owners_amount'));    
                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                @endphp
                            <b>{{$key2}} </b>
                            </td>
                            <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                            <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                        </tr>

                      
                    @endforeach

                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                        <tr class="gl-show">
                            <td class="border-y gl-level py-0">
                                @php
                                    $gl_price = collect($item4)->sum('owners_amount');                   
                                    $gl_prev_price = collect($item4)->sum('prev_owners_amount');                   
                                    $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                @endphp
                                {{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a>
                            </td>
                            <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                        </tr>
                    @endforeach 
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="4"></td></tr>


                <tr>
                    <td class="head-title" style="border-top:none">
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
                        $prev_income = collect($prev_profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('amount');
                        $prev_expense = collect($prev_profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('amount');
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
                                                         
                       <b>Retained Earnings</b> 
                    </td>
                    <td style="border-top:none"><div class="first"><b>@if($retained_earnings >= 0){{number_format($retained_earnings,2)}} @else {{ "(".number_format(abs($retained_earnings),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="second"><b>@if($retained_earnings_prev >= 0){{number_format($retained_earnings_prev,2)}} @else {{ "(".number_format(abs($retained_earnings_prev),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="third"><b>@if($retained_earnings_bal >= 0) {{number_format($retained_earnings_bal,2)}} @else {{ "(".number_format(abs($retained_earnings_bal),2).")"}} @endif</b></div></td>
                </tr>
                <tr>
                    <td class="head-title" style="border-top:none">
                        @php 
                            $net_owners_equity_ammount = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('owners_amount') + floatVal($retained_earnings);
                            $net_owners_equity_ammount_prev = collect($root_info)->whereIn('balanc_income',['BALANCE','OWNERS'])->where('bal_inc_tag','OWNERSEQUITY')->sum('prev_owners_amount') + floatVal($retained_earnings_prev);
                            $net_owners_equity_ammount_bal = floatVal($net_owners_equity_ammount_prev) - floatVal($net_owners_equity_ammount);
                        @endphp
                       <b>Net Owners Equity</b> 
                    </td>
                    <td style="border-top:none"><div class="first"><b>@if($net_owners_equity_ammount >= 0){{number_format($net_owners_equity_ammount,2)}} @else {{ "(".number_format(abs($net_owners_equity_ammount),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="second"><b>@if($net_owners_equity_ammount_prev >= 0){{number_format($net_owners_equity_ammount_prev,2)}} @else {{ "(".number_format(abs($net_owners_equity_ammount_prev),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="third"><b>@if($net_owners_equity_ammount_bal >= 0) {{number_format($net_owners_equity_ammount_bal,2)}} @else {{ "(".number_format(abs($net_owners_equity_ammount_bal),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Owners Equity -->

                <!-- Non Current Liabilities -->
                <tr>
                    <td colspan="4" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Non Current Liabilites</strong></td>
                </tr>
                @foreach(collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td style="width:70%" class="first_row">
                            @php 
                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('amount'));    
                            $prev_price = (collect($item)->where('acc_4type_name',$key)->sum('prev_amount'));    
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
                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('amount'));    
                                $desc_prev_price = (collect($item2)->where('acc_5type_description',$key2)->sum('prev_amount'));    
                                $desc_prev_balance = floatVal($desc_prev_price) - floatVal($desc_price);    
                                @endphp
                            <b>{{$key2}} </b>
                            </td>
                            <td><div class="first description-price"><b>@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif</b></div></td>
                            <td><div class="second description-price"><b>@if($desc_prev_price >= 0) {{number_format($desc_prev_price,2)}} @else {{ "(".number_format(abs($desc_prev_price),2).")"}} @endif</b></div></td>
                            <td><div class="third description-price"><b>@if($desc_prev_balance >= 0) {{number_format($desc_prev_balance,2)}} @else {{ "(".number_format(abs($desc_prev_balance),2).")"}} @endif</b></div></td>
                        </tr>

                      
                    @endforeach

                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)                                                                                               
                        <tr class="gl-show">
                            <td class="border-y gl-level py-0">
                                @php
                                    $gl_price = collect($item4)->sum('amount');                   
                                    $gl_prev_price = collect($item4)->sum('prev_amount');                   
                                    $gl_price_total = floatVal($gl_prev_price) - floatVal($gl_price);  
                                @endphp
                                {{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$to_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a>
                            </td>
                            <td class="py-0 gl-price"><div class="first">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="second">@if($gl_prev_price >= 0) {{number_format($gl_prev_price,2)}} @else {{ "(".number_format(abs($gl_prev_price),2).")"}} @endif</div></td>
                            <td class="py-0 gl-price"><div class="third">@if($gl_price_total >= 0) {{number_format($gl_price_total,2)}} @else {{ "(".number_format(abs($gl_price_total),2).")"}} @endif</div></td>
                        </tr>
                    @endforeach 
                @endforeach                                                                                    
                <tr><td class="head-title" colspan="4"></td></tr>
                <tr>
                    <td class="head-title" style="border-top:none">
                        @php 
                            $net_non_current_lib_ammount = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('amount') ;
                            $net_non_current_lib_ammount_prev = collect($root_info)->where('balanc_income','BALANCE')->where('bal_inc_tag','LONGLIABILITIES')->sum('prev_amount') ;
                            $net_non_current_lib_ammount_bal = floatVal($net_non_current_lib_ammount_prev) - floatVal($net_non_current_lib_ammount);
                        @endphp
                       <b>Net Non Current Liabilites</b> 
                    </td>
                    <td style="border-top:none"><div class="first"><b>@if($net_non_current_lib_ammount >= 0) {{number_format($net_non_current_lib_ammount,2)}} @else {{ "(".number_format(abs($net_non_current_lib_ammount),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="second"><b>@if($net_non_current_lib_ammount_prev >= 0) {{number_format($net_non_current_lib_ammount_prev,2)}} @else {{ "(".number_format(abs($net_non_current_lib_ammount_prev),2).")"}} @endif</b></div></td>
                    <td style="border-top:none"><div class="third"><b>@if($net_non_current_lib_ammount_bal >= 0) {{number_format($net_non_current_lib_ammount_bal,2)}} @else {{ "(".number_format(abs($net_non_current_lib_ammount_bal),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Non Current Liabilities -->

                <!-- Total Liability and Equity -->
                <tr>
                    <td class="head-title">
                        @php $total_liability_owners_equity_current = $net_non_current_lib_ammount + $net_owners_equity_ammount + $net_current_liabilities_ammount; @endphp
                        @php $total_liability_owners_equity_prev = $net_non_current_lib_ammount_prev + $net_owners_equity_ammount_prev + $net_current_liabilities_ammount_prev; @endphp
                        @php $total_liability_owners_equity_balance = $net_non_current_lib_ammount_bal + $net_owners_equity_ammount_bal + $net_current_ammount_bal; @endphp
                       <b>Total Liabilities and Shareholders' Equity</b> 
                    </td>
                    <td><div class="first"><b>@if($total_liability_owners_equity_current >= 0){{number_format($total_liability_owners_equity_current,2)}} @else {{ "(".number_format(abs($total_liability_owners_equity_current),2).")"}} @endif</b></div></td>
                    <td><div class="second"><b>@if($total_liability_owners_equity_prev >= 0){{number_format($total_liability_owners_equity_prev,2)}} @else {{ "(".number_format(abs($total_liability_owners_equity_prev),2).")"}} @endif</b></div></td>
                    <td><div class="third"><b>@if($total_liability_owners_equity_balance >= 0) {{number_format($total_liability_owners_equity_balance,2)}} @else {{ "(".number_format(abs($total_liability_owners_equity_balance),2).")"}} @endif</b></div></td>
                </tr>
                <!-- Close Total Liability and Equity --->
                                
                @endif
            </tbody>
     
    </table>
