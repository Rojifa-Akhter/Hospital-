<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

    table td {
        font-size: 11px;
        border: 1px solid #333;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div style="text-align: center;">
        <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
        <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
        <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>

        </div>
        <div class="voucher_title" style="margin-top: 30px; text-align:center;">
            <h3 style="margin-bottom: 10px; text-transform:uppercase;">
                Trail Balance
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>
    <div class="col-md-12">
        @php

    $sum_outflow = 0;
    $sum_inflow = 0;
    $total_sum_dr = 0;
    $total_sum_cr = 0;
    //dd(collect($root_info->getData()->data));
@endphp
@if(!empty($root_info))
<table style="width: 100%;" cellspacing="0">
    <thead>
    <tr>
        <td colspan="2"></td>
        <td colspan="2" style="text-align: center; background-color: yellow;">Opening Balance</td>
        <td colspan="2" style="text-align: center; background-color: yellow;">Transaction</td>
        <td colspan="2" style="text-align: center; background-color: yellow;">Closing Balance</td>
        <td style="text-align: center; background-color: yellow;">OB</td>
        <td style="text-align: center; background-color: yellow;">TR</td>
        <td style="text-align: center; background-color: yellow;">CB</td>
    </tr>
    <tr>
        <th style="font-weight: 900; padding-bottom: 10px; border-bottom:1px solid #333;">Code</th>
        <th style="font-weight: 900; padding-bottom: 10px; border-bottom:1px solid #333;">Name</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Dr.(tk)</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Cr.(tk)</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Dr.(tk)</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Cr.(tk)</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Dr.(tk)</th>
        <th style="font-weight: 900; padding-bottom: 10px; text-align:right; border-bottom:1px solid #333;">Cr.(tk)</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</thead>
    @php
        $root_exist = "";
        $t = 0;
        $c = 0;
        $total_opening_bal = 0;
        $total_closing_bal = 0;
        $total_closing_bal_sub = 0;
        $closing_bal_dr = 0;
        $closing_bal_cr = 0;
        $opening_bal_dr = 0;
        $opening_bal_cr = 0;
        $total_closing_bal = 0;
        $op_total_dr = 0;
        $op_total_cr = 0;

        $total_opening_summery_bal_dr = 0;
        $total_opening_summery_bal_cr = 0;

        $total_closing_summery_bal_dr = 0;
        $total_closing_summery_bal_cr = 0;

        $total_tran_summery_bal_dr = 0;
        $total_tran_summery_bal_cr = 0;

        $last_opening_bal_dr = 0;
        $last_opening_bal_cr = 0;

        $last_tran_bal_dr = 0;
        $last_tran_bal_cr = 0;

        $last_closing_bal_dr = 0;
        $last_closing_bal_cr = 0;



    @endphp
    @foreach(collect($root_info->getData()->data) as $root)


                @php
                    $inroot_sum = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("dr");
                    $total_dr = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("dr");
                    $total_cr = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("cr");
                    $total_opening_bal = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("opening_balance");

                    $total_closing_bal = (($total_opening_bal+$total_dr)-$total_cr);




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
                        <td style="padding-left: 20px; font-weight: 900; padding-bottom: 10px; text-align:center;">{{$root->root_account_code}}</td>
                        <td style="font-weight: 900; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head))}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal > 0) {{number_format(abs($total_opening_bal),2)}} @else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal < 0) {{"(".number_format(abs($total_opening_bal),2).")"}} @else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $total_tran_summery_bal_dr = $total_dr @endphp {{number_format($total_dr,2)}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $total_tran_summery_bal_cr = $total_cr @endphp {{"(".number_format($total_cr,2).")"}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal > 0) {{number_format(abs($total_closing_bal),2)}}@else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal < 0) {{"(".number_format(abs($total_closing_bal),2).")"}} @else  0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal > 0) {{number_format(abs($total_opening_bal),2)}} @elseif($total_opening_bal < 0) {{"(".number_format(abs($total_opening_bal),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $tran_summery_balance_dr_cr = ($total_tran_summery_bal_dr-$total_tran_summery_bal_cr) @endphp @if($tran_summery_balance_dr_cr > 0) {{number_format($tran_summery_balance_dr_cr,2)}} @else {{"(".number_format(abs($tran_summery_balance_dr_cr),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal > 0) {{number_format(abs($total_closing_bal),2)}} @elseif($total_closing_bal < 0) {{"(".number_format(abs($total_closing_bal),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                    </tr>
                    @php
                        $c = 1;
                        $sum_inflow += $inroot_sum;
                        array_push($root_arr,$root->root_head);

                    @endphp

                    @foreach(collect($root_info->getData()->data)->where('root_head',$root_exist) as $root)
                    @php


                        $total_closing_bal_sub = (($root->opening_balance+$root->dr)-$root->cr);

                    @endphp
                    <tr>
                        <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->account_code))}}</td>
                        <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($root->opening_balance > 0) {{number_format($root->opening_balance,2)}} @else  0.00 @endif</td>
                        <td style="text-align:right; #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($root->opening_balance < 0) {{"(".number_format($root->opening_balance,2).")"}} @else  0.00 @endif</td>
                        <td style="text-align: right; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@php $last_tran_bal_dr = $root->dr @endphp {{number_format($root->dr,2)}}</td>
                        <td style="text-align: right; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@php $last_tran_bal_cr = $root->cr @endphp {{"(".number_format($root->cr,2).")"}}</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($total_closing_bal_sub > 0) {{number_format(abs($total_closing_bal_sub),2)}} @else 0.00 @endif</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($total_closing_bal_sub < 0) {{"(".number_format(abs($total_closing_bal_sub),2).")"}} @else 0.00 @endif</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@if($root->opening_balance > 0) {{number_format($root->opening_balance,2)}} @elseif($root->opening_balance < 0) {{"(".number_format($root->opening_balance,2).")"}} @else {{"("."0.00".")"}} @endif</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@php $last_tran_bal_dr_cr = ($last_tran_bal_dr-$last_tran_bal_cr) @endphp @if($last_tran_bal_dr_cr > 0) {{number_format($last_tran_bal_dr_cr,2)}} @else {{"(".number_format(abs($last_tran_bal_dr_cr),2).")"}} @endif</td>
                        <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@if($total_closing_bal_sub > 0) {{number_format(abs($total_closing_bal_sub),2)}} @elseif($total_closing_bal_sub < 0) {{"(".number_format(abs($total_closing_bal_sub),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                    </tr>
                    @php
                        $total_sum_dr += $root->dr;
                        $total_sum_cr += $root->cr;

                        $op_total_cr += $total_closing_bal_sub;
                        $op_total_dr += $root->opening_balance;
                    @endphp
                    @endforeach
                @endif
                @if(! in_array($root->root_head,$root_arr))
                    @php
                        array_push($root_arr, $root->root_head);
                        $new_root = $root->root_head;
                    @endphp
                     <tr>
                        <td style="padding-left: 20px; font-weight: 900; padding-bottom: 10px; text-align:center;">{{$root->root_account_code}}</td>
                        <td style="font-weight: 900; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head))}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal > 0) {{number_format(abs($total_opening_bal),2)}} @else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal < 0) {{"(".number_format(abs($total_opening_bal),2).")"}} @else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $total_tran_summery_bal_dr = $total_dr @endphp {{number_format($total_dr,2)}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $total_tran_summery_bal_cr = $total_cr @endphp {{"(".number_format($total_cr,2).")"}}</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal > 0) {{number_format(abs($total_closing_bal),2)}}@else 0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal < 0) {{"(".number_format(abs($total_closing_bal),2).")"}} @else  0.00 @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_opening_bal > 0) {{number_format(abs($total_opening_bal),2)}} @elseif($total_opening_bal < 0) {{"(".number_format(abs($total_opening_bal),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@php $tran_summery_balance_dr_cr = ($total_tran_summery_bal_dr-$total_tran_summery_bal_cr) @endphp @if($tran_summery_balance_dr_cr > 0) {{number_format($tran_summery_balance_dr_cr,2)}} @else {{"(".number_format(abs($tran_summery_balance_dr_cr),2).")"}} @endif</td>
                        <td style="font-weight: bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic; background-color: purple; color: #fff;">@if($total_closing_bal > 0) {{number_format(abs($total_closing_bal),2)}} @elseif($total_closing_bal < 0) {{"(".number_format(abs($total_closing_bal),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                    </tr>

                    @foreach(collect($root_info->getData()->data)->where('root_head',$new_root) as $root)
                    @php


                        $total_closing_bal_sub = (($root->opening_balance+$root->dr)-$root->cr);


                    @endphp
                        <tr>
                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->account_code))}}</td>
                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($root->opening_balance > 0) {{number_format($root->opening_balance,2)}} @else  0.00 @endif</td>
                            <td style="text-align:right; #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($root->opening_balance < 0) {{"(".number_format($root->opening_balance,2).")"}} @else  0.00 @endif</td>
                            <td style="text-align: right; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@php $last_tran_bal_dr = $root->dr @endphp {{number_format($root->dr,2)}}</td>
                            <td style="text-align: right; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@php $last_tran_bal_cr = $root->cr @endphp {{"(".number_format($root->cr,2).")"}}</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($total_closing_bal_sub > 0) {{number_format(abs($total_closing_bal_sub),2)}} @else 0.00 @endif</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: rgb(141, 237, 141);">@if($total_closing_bal_sub < 0) {{"(".number_format(abs($total_closing_bal_sub),2).")"}} @else 0.00 @endif</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@if($root->opening_balance > 0) {{number_format($root->opening_balance,2)}} @elseif($root->opening_balance < 0) {{"(".number_format($root->opening_balance,2).")"}} @else {{"("."0.00".")"}} @endif</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@php $last_tran_bal_dr_cr = ($last_tran_bal_dr-$last_tran_bal_cr) @endphp @if($last_tran_bal_dr_cr > 0) {{number_format($last_tran_bal_dr_cr,2)}} @else {{"(".number_format(abs($last_tran_bal_dr_cr),2).")"}} @endif</td>
                            <td style="text-align:right;  #333; padding-bottom: 10px; font-style:italic; background-color: lightblue;">@if($total_closing_bal_sub > 0) {{number_format(abs($total_closing_bal_sub),2)}} @elseif($total_closing_bal_sub < 0) {{"(".number_format(abs($total_closing_bal_sub),2).")"}} @else {{"("."0.00".")"}} @endif</td>
                        </tr>
                        @php
                            $total_sum_dr += $root->dr;
                            $total_sum_cr += $root->cr;

                            $op_total_cr += $total_closing_bal_sub;
                            $op_total_dr += $root->opening_balance;
                        @endphp
                    @endforeach

                @endif
    @endforeach
    <tr>
        <td style="padding-left: 30px; padding-bottom: 10px;"></td>
        <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
        <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;" colspan="2"><span style="font-weight: bold;">@if($op_total_dr > 0) {{number_format($op_total_dr,2)}} Dr @else {{number_format($op_total_dr,2)}} @if($op_total_dr != 0)Cr @endif @endif</span></td>

        <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_sum_dr,2)}}</span></td>
        <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_sum_cr,2)}}</span></td>
        <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;" colspan="2"><span style="font-weight: bold;">@if($op_total_cr > 0) {{number_format($op_total_cr,2)}} Dr @else {{number_format($op_total_cr,2)}} @if($op_total_cr != 0)Cr @endif @endif</span></td>
        <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>
        <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>
        <td style="padding-left: 30px; padding-bottom: 10px; text-align:center;"></td>

    </tr>
</table>
@endif

</div>

</div>

