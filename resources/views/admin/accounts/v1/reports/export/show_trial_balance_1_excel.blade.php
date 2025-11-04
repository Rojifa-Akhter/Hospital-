
<style>
.TrialBalanceReport table td {
    font-size: 12px !important;
    border: 1px solid black !important;
    white-space: nowrap;
    padding: 2px 4px !important;
}

.TrialBalanceReport table>thead>tr {
    background-color: #98a2b3 !important;
    color: white;
}

.TrialBalanceReport table>thead>tr>td {
    padding-right: 20px !important;
}

</style>


<h4 style="margin-top: 20px; text-align:center;">
    {{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>

<div class="voucher_title" style="margin-top: 20px; text-align:center;">
    <h5 style="margin-bottom: 10px; text-transform:uppercase;">
        Trial Balance
    </h5>
    <h6 class="mb" style="text-transform: uppercase">From Date:
        {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}
    </h6>
</div>

<table cellspacing="0" class="TrialBalanceReport" id="TrialBalanceReportDatatable">
    <thead>
        <tr>
            <td style="width:30%;border:1px solid black">GL (Code & Description)</td>
            <td style="width:10%;border:1px solid black;">Opening Balance <br> Debit</td>
            <td style="width:10%;border:1px solid black">Opening Balance <br> Credit</td>
            <td style="width:10%;border:1px solid black">Debit During The <br> Period</td>
            <td style="width:10%;border:1px solid black">Credit During The <br> Period</td>
            <td style="width:10%;border:1px solid black">Closing Balance <br> Debit</td>
            <td style="width:10%;border:1px solid black">Closing Balance <br> Credit</td>
            <td style="width:10%;border:1px solid black">Total Balance</td>               
        </tr>
    </thead>
    @php
        $sum_outflow = 0;
        $sum_inflow = 0;
        $total_sum_dr = 0;
        $total_sum_cr = 0;
        $op_total_cr = 0;
        $op_total_dr = 0;
        $dc_total_dr = 0;
        $cc_total_cr = 0;
        $total_op_sum_dr = 0;
        $total_op_sum_cr = 0;
        $total_total_balance = 0;

    @endphp
    @forelse(collect($root_info->getData()->data) as $root)
        @php           
        $total_closing_bal_sub_dr = ($root->opening_balance_dr +$root->dr);                         
        $total_closing_bal_sub_cr = ($root->opening_balance_cr+$root->cr);                         
        $total_balance = $total_closing_bal_sub_dr -  $total_closing_bal_sub_cr;
        @endphp
    <tr>
        <td style="text-align:left;white-space:nowrap">{{ucwords(strtolower($root->account_code))}} - {{ucwords(strtolower($root->tran_head))}}</td>
        <td style="text-align:right;">{{number_format($root->opening_balance_dr,2)}}</td>
        <td style="text-align:right;">{{number_format($root->opening_balance_cr,2)}}</td>
        <td style="text-align:right;">@php $last_tran_bal_dr = $root->dr @endphp {{number_format($root->dr,2)}}</td>
        <td style="text-align:right;">@php $last_tran_bal_cr = $root->cr @endphp {{number_format($root->cr,2)}}</td>
        <td style="text-align:right;">@if($total_closing_bal_sub_dr >= 0) {{number_format($total_closing_bal_sub_dr,2)}} @else {{'('.number_format(abs($total_closing_bal_sub_dr)).')'}} @endif</td>
        <td style="text-align:right;">@if($total_closing_bal_sub_cr >= 0) {{number_format($total_closing_bal_sub_cr,2)}} @else {{'('.number_format(abs($total_closing_bal_sub_cr)).')'}} @endif</td>
        <td style="text-align:right;">@if($total_balance >= 0) {{number_format($total_balance,2)}} @else {{"(".number_format(abs($total_balance),2).")"}} @endif</td>
    </tr>
        @php                                   
            $dc_total_dr += $total_closing_bal_sub_dr;
            $cc_total_cr += $total_closing_bal_sub_cr;

            $total_op_sum_dr += $root->opening_balance_dr;
            $total_op_sum_cr += $root->opening_balance_cr;

            $total_sum_dr += $root->dr;
            $total_sum_cr += $root->cr;
            $total_total_balance += $total_balance;
        @endphp
    @empty
    <tr>
        <td colspan="8" style="text-align: center"> No Data Found</td>
    </tr>
    @endforelse

    <tr>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important"><span style="font-weight: bold;">Grand Total</span></td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_op_sum_dr,2)}}</span></td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;"><span style="font-weight: bold;">@if($total_op_sum_cr >= 0) {{number_format($total_op_sum_cr,2)}} @else {{'('.number_format(abs($total_op_sum_cr),2).')'}} @endif</span></td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;"><span style="font-weight: bold;">@if($dc_total_dr >= 0) {{number_format($dc_total_dr,2)}} @else {{'('.number_format(abs($dc_total_dr),2).')'}} @endif</span></td>           
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($cc_total_cr,2)}}</span></td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_sum_dr >= 0) {{number_format($total_sum_dr,2)}} @else {{'('.number_format(abs($total_sum_dr),2).')'}} @endif</td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_sum_cr >= 0) {{number_format($total_sum_cr,2)}} @else {{'('.number_format(abs($total_sum_cr),2).')'}} @endif</td>
        <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_total_balance >= 0) {{number_format($total_total_balance,2)}} @else {{'('.number_format(abs($total_total_balance),2).')'}} @endif</td>        
    </tr>
</table>

