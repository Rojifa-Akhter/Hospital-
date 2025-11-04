<style type="text/css">
    body {
        font-family: font-family: 'Courier New' ;
        font-size: 16px !important;
    }

    table td {
        font-size: 16px;
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
        {{-- <h4 class="mb">{!!@$search_type!!}</h4> --}}
    </div>
 


@if(!empty($root_info))
<table style="width: 100%;" cellspacing="0" id="trialBalanceDatatable">
                <thead>
                    {{-- <tr>
                        <td colspan="7" class="text-right" style="border-top:0px;border-left:0px;border-right:0px"> <b>Amount (Tk.)</b></td>
                    </tr> --}}
                    <tr>
                        <td style="font-weight: 900; padding-left:3px;text-align: center;width: 8%" >Account</td>
                        <td style="font-weight: 900; padding-left:3px;text-align: center;width: 5%">Type</td>
                        <td style="font-weight: 900; padding-left:3px;width: 37%">Description</td>
                        <td style=" font-weight: 900; text-align: right; width: 15%">Opening</td>
                        <td style="font-weight: 900; text-align:right; width: 10%">DEBIT</td>
                        <td style="font-weight: 900; text-align:right;width: 10%">CREDIT</td>
                        <td style=" font-weight: 900; text-align: right; width: 15%">YTD</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total_ob_dr_sum = 0;
                    $total_ob_cr_sum = 0;
                    $total_dr_sum = 0;
                    $total_cr_sum = 0;
                    $total_closing_dr_sum = 0;
                    $total_closing_cr_sum = 0;
                    $total_ob_bal_sum = 0;
                    $total_tr_bal_sum = 0;
                    $total_cb_bal_sum = 0;
                @endphp

                {{-- Loop directly through all accounts, excluding the 'retained_earnings_ind' as before --}}
                @forelse(collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1) as $account)
                    @php
                        $last_opening_dr = floatVal($account->opening_balance_dr);
                        $last_opening_cr = floatVal($account->opening_balance_cr);
                        $last_tran_bal_dr = floatVal($account->dr);
                        $last_tran_bal_cr = floatVal($account->cr);
                        $last_closing_dr = (floatVal($account->opening_balance_dr) + floatVal($account->dr));
                        $last_closing_cr = (floatVal($account->opening_balance_cr) + floatVal($account->cr));

                        $last_ob_bal = $last_opening_dr - $last_opening_cr;
                        $last_tr_bal = $last_tran_bal_dr - $last_tran_bal_cr;
                        $last_cb_bal = $last_closing_dr - $last_closing_cr;

                        // Accumulate totals for the grand total row
                        $total_ob_dr_sum += $last_opening_dr;
                        $total_ob_cr_sum += $last_opening_cr;
                        $total_dr_sum += $last_tran_bal_dr;
                        $total_cr_sum += $last_tran_bal_cr;
                        $total_closing_dr_sum += $last_closing_dr;
                        $total_closing_cr_sum += $last_closing_cr;
                        $total_ob_bal_sum += $last_ob_bal;
                        $total_tr_bal_sum += $last_tr_bal;
                        $total_cb_bal_sum += $last_cb_bal;
                    @endphp
                    <tr>
                        <td style="text-align:center; #333;">{{ucwords(strtolower($account->account_code))}}</td>
                        <td style="text-align:center; #333; ">{{ucwords(strtolower($account->type_name))}}</td>
                        <td style="text-align:left; #333;">{{ucwords(strtolower($account->tran_head))}}</td>
                        <td style="text-align:right; #333;">@if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333;">{{number_format($account->dr,2)}}</td>
                        <td style="text-align:right; #333;">{{number_format(abs($account->cr),2)}}</td>
                        <td style="text-align:right; #333;">@if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center"> No Data Found</td>
                    </tr>
                @endforelse

                {{-- Retained Earnings row (if it exists) --}}
                @foreach(collect($root_info->getData()->data)->where('retained_earnings_ind',1)->take(1) as $root)
                    @php
                        $last_opening_dr = floatVal($root->opening_balance_dr);
                        $last_opening_cr = floatVal($root->opening_balance_cr);
                        $last_tran_bal_dr = floatVal($root->dr);
                        $last_tran_bal_cr = floatVal($root->cr);
                        $last_closing_dr = (floatVal($root->opening_balance_dr) + floatVal($root->dr));
                        $last_closing_cr = (floatVal($root->opening_balance_cr) + floatVal($root->cr));

                        $last_ob_bal = $last_opening_dr - $last_opening_cr;
                        $last_cb_bal = $last_closing_dr - $last_closing_cr;

                        // Add Retained Earnings to the grand total
                        $total_ob_dr_sum += $last_opening_dr;
                        $total_ob_cr_sum += $last_opening_cr;
                        $total_dr_sum += $last_tran_bal_dr;
                        $total_cr_sum += $last_tran_bal_cr;
                        $total_closing_dr_sum += $last_closing_dr;
                        $total_closing_cr_sum += $last_closing_cr;
                        $total_ob_bal_sum += $last_ob_bal;
                        $total_cb_bal_sum += $last_cb_bal;
                    @endphp
                    <tr>
                        <td style="padding-left: 30px; ">{{ucwords(strtolower($root->account_code))}}</td>
                        <td style="padding-left: 30px; color: red; background-color: rgb(255, 255, 0);">{{ucwords(strtolower($root->tran_head))}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">@if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">{{number_format($root->dr,2)}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">{{number_format(abs($root->cr),2)}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">@if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">0</td>
                    </tr>
                @endforeach

                <tr>
                    <td style="padding-left: 30px; "></td>
                    <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
                    <td style="padding-left: 30px; text-align:right;">@if($total_ob_bal_sum >= 0) {{number_format($total_ob_bal_sum,2)}} @else {{'('.number_format(abs($total_ob_bal_sum),2).')'}} @endif</td>
                    <td style="padding-left: 30px; text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_dr_sum,2)}}</span></td>
                    <td style="padding-left: 30px; text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_cr_sum,2)}}</span></td>
                    <td style="padding-left: 30px; text-align:right;">@if($total_cb_bal_sum >= 0) {{number_format($total_cb_bal_sum,2)}} @else {{'('.number_format(abs($total_cb_bal_sum),2).')'}} @endif</td>
                    <td style="padding-left: 30px; ">0</td>
                </tr>
                </tbody>
                
            </table>
@endif



