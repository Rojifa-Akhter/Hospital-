<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

    table td {
        font-size: 12px;
        border: 1px solid #333;
    }
    .text-right{
        text-align: right;
    }
</style>


    <div style="text-align: center;">
    <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>

    </div>
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h3 style="margin-bottom: 10px; text-transform:uppercase;">
            Trial Balance
        </h3>
        <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        <h4 class="mb">{!!@$search_type!!}</h4>
    </div>
 


@if(!empty($root_info))
<table style="width: 100%;" cellspacing="0" id="trialBalanceDatatable">
    <thead>
        <tr>
            <td colspan="6" class="text-right" style="border-top:0px;border-left:0px;border-right:0px"> <b>Amount (Tk.)</b></td>
        </tr>
        <tr>
            <td rowspan="2" style="font-weight: 900; padding-left:3px;width: 5%" >GL Code</td>
            <td rowspan="2" style="font-weight: 900; padding-left:3px;width: 45%">GL Description</td>
            <td rowspan="2" style="text-align: center; background-color: #cfd2d4;width: 15%">Opening Balance</td>
            <td colspan="2" style="text-align: center; background-color: #cfd2d4;width: 20%">Transaction</td>
            <td rowspan="2" style="text-align: center; background-color: #cfd2d4;width: 15%">Closing Balance</td>
        </tr>
        <tr>
            <td style="font-weight: 900; text-align:right;text-align: center;">DR</td>
            <td style="font-weight: 900; text-align:right;text-align: center;">CR</td>
        </tr>
    </thead>
    @php
        $root_exist = "";
        $t = 0;
        $c = 0;                                                         
        $total_tran_summery_bal_dr = 0;
        $total_tran_summery_bal_cr = 0;            
        $last_tran_bal_dr = 0;
        $last_tran_bal_cr = 0;           
        
        $total_ob_dr_sum = 0; 
        $total_ob_cr_sum = 0; 
        $total_dr_sum = 0; 
        $total_cr_sum = 0; 
        $total_closing_dr_sum = 0; 
        $total_closing_cr_sum = 0; 
        $total_ob_bal_sum = 0;
        $total_tr_bal_sum = 0;
        $total_cb_bal_sum = 0;

        $last_opening_dr = 0;
        $last_opening_cr = 0;
        $last_tran_bal_dr = 0; 
        $last_tran_bal_cr = 0;
        $last_closing_dr = 0;
        $last_closing_cr = 0;
        $last_ob_bal = 0;
        $last_tr_bal = 0;
        $last_cb_bal = 0;

    @endphp
    @forelse(collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1) as $root)


                @php                    
                    
                    $total_opening_bal_dr = collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$root->root_head)->sum("opening_balance_dr");
                    $total_opening_bal_cr = collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$root->root_head)->sum("opening_balance_cr");
                    
                    $total_dr = collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$root->root_head)->sum("dr");
                    $total_cr = collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$root->root_head)->sum("cr");
                    
                    $total_closing_bal_dr = (floatVal($total_opening_bal_dr) + floatVal($total_dr));                          
                    $total_closing_bal_cr = (floatVal($total_opening_bal_cr) + floatVal($total_cr)); 

                    $total_ob_bal = floatVal($total_opening_bal_dr) - floatVal($total_opening_bal_cr);
                    $total_tr_bal = floatVal($total_dr) - floatVal($total_cr);
                    $total_cb_bal = floatVal($total_closing_bal_dr) - floatVal($total_closing_bal_cr);

                    

                @endphp
                @if($t == 0)
                    @php
                        $root_arr = [];
                        $root_exist = $root->root_head;
                        $t = 1;
                    @endphp
                @endif

                @if($c == 0)
                    <tr>
                        <td style="padding-left: 20px; font-weight: 900;  text-align:center;">
                            {{-- {{$root->root_account_code}} --}}
                        </td>
                        <td style="font-weight: 900; padding-left:3px;color:#6B6F82">{{ucwords(strtolower($root->root_head))}}</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_ob_bal >= 0) {{number_format($total_ob_bal,2)}} @else {{"(".number_format(abs($total_ob_bal),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_tran_summery_bal_dr >= 0) {{number_format($total_tran_summery_bal_dr,2)}} @else {{"(".number_format(abs($total_tran_summery_bal_dr),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_tran_summery_bal_cr >= 0) {{number_format($total_tran_summery_bal_cr,2)}} @else {{"(".number_format(abs($total_tran_summery_bal_cr),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_cb_bal >= 0) {{number_format($total_cb_bal,2)}} @else {{"(".number_format(abs($total_cb_bal),2).")"}} @endif</td>
                    </tr>
                    @php
                        $c = 1;
                        array_push($root_arr,$root->root_head);

                    @endphp
                    @php                                               
                        //summation                                           
                        $total_ob_dr_sum += $total_opening_bal_dr;
                        $total_ob_cr_sum += $total_opening_bal_cr;

                        $total_dr_sum += $total_dr;
                        $total_cr_sum += $total_cr;

                        $total_closing_dr_sum += $total_closing_bal_dr;
                        $total_closing_cr_sum += $total_closing_bal_cr;
                        
                        $total_ob_bal_sum += $total_ob_bal;
                        $total_tr_bal_sum += $total_tr_bal;
                        $total_cb_bal_sum += $total_cb_bal;
                    @endphp
                    @foreach(collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$root_exist) as $root)
                    @php
                        $total_closing_bal_sub_dr = (floatVal($root->opening_balance_dr) + floatVal($root->dr));           
                        $total_closing_bal_sub_cr = (floatVal($root->opening_balance_cr) + floatVal($root->cr));   
                        $last_opening_dr = floatVal($root->opening_balance_dr);
                        $last_opening_cr = floatVal($root->opening_balance_cr);
                        $last_closing_dr = floatVal($total_closing_bal_sub_dr);
                        $last_closing_cr = floatVal($total_closing_bal_sub_cr);

                    @endphp
                   
                    <tr>
                        <td style="padding-left: 30px; background-color: rgb(153, 204, 255);">{{ucwords(strtolower($root->account_code))}}</td>
                        <td style="padding-left: 30px; background-color: rgb(153, 204, 255);">{{ucwords(strtolower($root->tran_head))}}</td>                                           
                        <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_ob_bal = $last_opening_dr - $last_opening_cr; @endphp @if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                        <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_tran_bal_dr = floatVal($root->dr) @endphp {{number_format($root->dr,2)}}</td>
                        <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_tran_bal_cr = floatVal($root->cr) @endphp {{number_format(abs($root->cr),2)}}</td>
                        <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_cb_bal = $last_closing_dr - $last_closing_cr; @endphp @if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                    </tr>
                    @endforeach
                @endif

                @if(! in_array($root->root_head,$root_arr))
                    @php
                        array_push($root_arr, $root->root_head);
                        $new_root = $root->root_head;
                    @endphp
                    <tr>
                        <td style="padding-left: 20px; font-weight: 900;  text-align:center;">
                            {{-- {{$root->root_account_code}} --}}
                        </td>
                        <td style="font-weight: 900; padding-left:3px;color:#6B6F82">{{ucwords(strtolower($root->root_head))}}</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_ob_bal >= 0) {{number_format($total_ob_bal,2)}} @else {{"(".number_format(abs($total_ob_bal),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@php $total_tran_summery_bal_dr = $total_dr @endphp {{number_format($total_dr,2)}}</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@php $total_tran_summery_bal_cr = $total_cr @endphp {{number_format($total_cr,2)}}</td>
                        <td style="font-weight: bold; font-size: 14px; text-align:right;  font-style:italic; color: #6B6F82;">@if($total_cb_bal >= 0) {{number_format($total_cb_bal,2)}} @else {{"(".number_format(abs($total_cb_bal),2).")"}} @endif</td>
                    </tr>

                    @php                                               
                        //summation                                           
                        $total_ob_dr_sum += $total_opening_bal_dr;
                        $total_ob_cr_sum += $total_opening_bal_cr;

                        $total_dr_sum += $total_dr;
                        $total_cr_sum += $total_cr;

                        $total_closing_dr_sum += $total_closing_bal_dr;
                        $total_closing_cr_sum += $total_closing_bal_cr;
                        
                        $total_ob_bal_sum += $total_ob_bal;
                        $total_tr_bal_sum += $total_tr_bal;
                        $total_cb_bal_sum += $total_cb_bal;
                    @endphp

                    @foreach(collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1)->where('root_head',$new_root)->where('retained_earnings_ind','!=',1) as $root)
                        @php
                            $total_closing_bal_sub_dr = (floatVal($root->opening_balance_dr) + floatVal($root->dr));           
                            $total_closing_bal_sub_cr = (floatVal($root->opening_balance_cr) + floatVal($root->cr)); 
                            
                            $last_opening_dr = floatVal($root->opening_balance_dr);
                            $last_opening_cr = floatVal($root->opening_balance_cr);
                            $last_closing_dr = floatVal($total_closing_bal_sub_dr);
                            $last_closing_cr = floatVal($total_closing_bal_sub_cr);
                        @endphp
                        <tr>
                            <td style="padding-left: 30px; background-color: rgb(153, 204, 255);">{{ucwords(strtolower($root->account_code))}}</td>
                            <td style="padding-left: 30px; background-color: rgb(153, 204, 255); ">{{ucwords(strtolower($root->tran_head))}}</td>
                            <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_ob_bal = $last_opening_dr - $last_opening_cr; @endphp @if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                            <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_tran_bal_dr = floatVal($root->dr) @endphp {{number_format($root->dr,2)}}</td>
                            <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_tran_bal_cr = floatVal($root->cr) @endphp {{number_format(abs($root->cr),2)}}</td>
                            <td style="text-align:right;  #333;  font-style:italic; background-color: rgb(153, 204, 255);">@php $last_cb_bal = $last_closing_dr - $last_closing_cr; @endphp @if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                        </tr>
                    @endforeach

                @endif
            @empty
            <tr>
                <td colspan="6" style="text-align: center"> No Data Found</td>
            </tr>
            @endforelse

    {{-- Retained Earnings --}}
    @php

        // $retained_opening_bl_income_dr = collect($profit_loss->getData()->data)->whereIn('income_expense',['Revenue','Other Income'])->sum('opening_balance_dr');
        // $retained_opening_bl_expense_dr = collect($profit_loss->getData()->data)->whereNotIn('income_expense',['Revenue','Other Income'])->sum('opening_balance_dr');
        // $retained_opening_bl_dr = floatVal($retained_opening_bl_income_dr) - floatVal($retained_opening_bl_expense_dr);

       

    @endphp
    {{-- <tr>
        <td style="padding-left: 30px; "></td>
        <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;color:yellow">Retained Earnings</span></td>
        <td style="padding-left: 30px;  text-align:center;"><span style="font-weight: bold;">@if($retained_opening_bl_dr >= 0) {{number_format($retained_opening_bl_dr,2)}} @else {{'('.number_format(abs($retained_opening_bl_dr),2).')'}} @endif</span></td>   
        <td style="padding-left: 30px;  text-align:center;"><span style="font-weight: bold;">@if($total_ob_cr_sum >= 0) {{number_format($total_ob_cr_sum,2)}} @else {{'('.number_format(abs($total_ob_cr_sum),2).')'}} @endif</span></td>   
        <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_dr_sum,2)}}</span></td>
        <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_cr_sum,2)}}</span></td>
        <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold; font-style:italic;">@if($total_closing_dr_sum >= 0) {{number_format($total_closing_dr_sum,2)}} @else {{'('.number_format(abs($total_closing_dr_sum),2).')'}} @endif</span></td>
        <td style="padding-left: 30px;  text-align:center;"><span style="font-weight: bold;">@if($total_closing_cr_sum >= 0) {{number_format($total_closing_cr_sum,2)}} @else {{'('.number_format(abs($total_closing_cr_sum),2).')'}} @endif</span></td>
        <td style="padding-left: 30px;  text-align:center;">@if($total_ob_bal_sum >= 0) {{number_format($total_ob_bal_sum,2)}} @else {{'('.number_format(abs($total_ob_bal_sum),2).')'}} @endif</td>
        <td style="padding-left: 30px;  text-align:center;">@if($total_tr_bal_sum >= 0) {{number_format($total_tr_bal_sum,2)}} @else {{'('.number_format(abs($total_tr_bal_sum),2).')'}} @endif</td>
        <td style="padding-left: 30px;  text-align:center;">@if($total_cb_bal_sum >= 0) {{number_format($total_cb_bal_sum,2)}} @else {{'('.number_format(abs($total_cb_bal_sum),2).')'}} @endif</td>          
    </tr> --}}
    {{-- close Retained Earnings --}}

  
    @foreach(collect($root_info->getData()->data)->where('retained_earnings_ind',1)->take(1) as $root)
        @php
            $total_closing_bal_sub_dr = (floatVal($root->opening_balance_dr) + floatVal($root->dr));           
            $total_closing_bal_sub_cr = (floatVal($root->opening_balance_cr) + floatVal($root->cr));    
            
            $last_opening_dr = floatVal($root->opening_balance_dr);
            $last_opening_cr = floatVal($root->opening_balance_cr);
            $last_closing_dr = floatVal($total_closing_bal_sub_dr);
            $last_closing_cr = floatVal($total_closing_bal_sub_cr);
        @endphp
        <tr>
            <td style="padding-left: 30px; ">{{ucwords(strtolower($root->account_code))}}</td>
            <td style="padding-left: 30px; color: red; background-color: rgb(255, 255, 0);">{{ucwords(strtolower($root->tran_head))}}</td>
            <td style="text-align:right;  #333;  font-style:italic; color: red; background-color: rgb(255, 255, 0);">@php $last_ob_bal = $last_opening_dr - $last_opening_cr; @endphp @if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>                                    
            <td style="text-align:right;  #333;  font-style:italic; color: red; background-color: rgb(255, 255, 0);">@php $last_tran_bal_dr = floatVal($root->dr) @endphp {{number_format($root->dr,2)}}</td>
            <td style="text-align:right;  #333;  font-style:italic; color: red; background-color: rgb(255, 255, 0);">@php $last_tran_bal_cr = floatVal($root->cr) @endphp {{number_format(abs($root->cr),2)}}</td>
            <td style="text-align:right;  #333;  font-style:italic; color: red; background-color: rgb(255, 255, 0);">@php $last_cb_bal = $last_closing_dr - $last_closing_cr; @endphp @if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
        </tr>

        @php 
            $total_ob_dr_sum+=$last_opening_dr;
            $total_ob_cr_sum+=$last_opening_cr;
            $total_dr_sum+=$last_tran_bal_dr;
            $total_cr_sum+=$last_tran_bal_cr;
            $total_closing_dr_sum+=$last_closing_dr;
            $total_closing_cr_sum+=$last_closing_cr;
            $total_ob_bal_sum+=$last_ob_bal;
            $total_tr_bal_sum+=$last_tr_bal;
            $total_cb_bal_sum+=$last_cb_bal;
        @endphp

    @endforeach
        
    <tr>
        <td style="padding-left: 30px; "></td>
        <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>

        <td style="padding-left: 30px;  text-align:right;">@if($total_ob_bal_sum >= 0) {{number_format($total_ob_bal_sum,2)}} @else {{'('.number_format(abs($total_ob_bal_sum),2).')'}} @endif</td>
        <td style="padding-left: 30px;  text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_dr_sum,2)}}</span></td>
        <td style="padding-left: 30px;  text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_cr_sum,2)}}</span></td>
        <td style="padding-left: 30px;  text-align:right;">@if($total_cb_bal_sum >= 0) {{number_format($total_cb_bal_sum,2)}} @else {{'('.number_format(abs($total_cb_bal_sum),2).')'}} @endif</td>          
    </tr>
</table>
@endif



