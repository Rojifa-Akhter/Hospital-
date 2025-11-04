

<style>
    table{
        border-collapse: collapse;
    }
    table td {
        font-size: 11px;
        padding-right:3px;
        border:1px solid black;
        line-height: 8px;
    }
     .table th {
        font-size: 14px !important;
    }
    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .text-right{
        text-align: right;
    }
</style>

    <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>

    <div style="text-align:center;">
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><b>GL</b>: <span style="font-style:italic;">{{$leder_of_code}}-{{$leder_of}}</span></h6>
    </div>


    @if(!empty($self_ledger_summary))
    <table class="table" style="width: 100%;" cellspacing="0">
        <thead>
            <tr style="background-color: #003B61;color:white">                                       
                <th style="text-align:left; padding:3px; font-weight:bold;width:50%">Sub Ledger Name</th>
                <th style="text-align:left; padding:3px; font-weight:bold;width:15%" >Opening BL</th>
                <th style="text-align:left; padding:3px; font-weight:bold;width:10%" >Debit</th>
                <th style="text-align:left; padding:3px; font-weight:bold;width:10%" >Credit</th>                                       
                <th style="text-align:left; padding:3px; font-weight:bold;width:15%" >Closing BL</th>
            </tr>
        </thead>
    
        <tbody>

            @php
                $balance = 0;
                $total_dr = 0;
                $total_cr = 0;
                $final_opening_balance = 0;
                $final_closing_balance = 0;
            @endphp
  
            @forelse($self_ledger_summary->getData()->ledger_details as $root)
                @php
                    $balance += ($root->dr-$root->cr);
                    $total_dr += $root->dr;
                    $total_cr += $root->cr;
                    $local_closing = (($root->opening_bal + $root->dr) - $root->cr);
                    $final_opening_balance += $root->opening_bal;
                    $final_closing_balance += $local_closing;
                @endphp
                <tr>                                               
                    <td style="text-align: left;  padding-bottom: 3px;white-space:nowrap"><a target="new" href="{{route('v1.accounts.subledger-report-by-id-date')}}?subledger_id={{$root->acct_subledger_no_fk}}&from_date={{@$from_date}}&&to_date={{@$to_date}}">{{$root->subledger_name}}</a></td>
                    <td style="text-align: right; padding-bottom: 3px;">@if($root->opening_bal >= 0) {{number_format($root->opening_bal,2)}} @else {{'('.number_format(abs($root->opening_bal),2).')'}} @endif</td>
                    <td style="text-align: right; padding-left: 3px; padding-bottom: 3px;">@if($root->dr >= 0){{ number_format($root->dr,2) }} @else {{ '0.00'}} @endif</td>
                    <td style="text-align: right; padding-left: 3px; padding-bottom: 3px;">@if($root->cr >= 0){{ number_format($root->cr,2) }} @else {{ '0.00'}} @endif</td>  
                    <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($local_closing >= 0) {{number_format($local_closing,2)}} @else {{'('.number_format(abs($local_closing),2).')'}} @endif</td>                                               
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" >No Data Found</td>
                </tr> 
            @endforelse

            <tr>
                <td style="font-weight: bold; padding:3px;" >Total</td>
                <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($final_opening_balance >= 0) {{number_format($final_opening_balance,2)}} @else {{ '('.number_format(abs($final_opening_balance),2).')'}} @endif</span></td>
                <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
                <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
                <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($final_closing_balance >= 0) {{number_format($final_closing_balance,2)}} @else {{ '('.number_format(abs($final_closing_balance),2).')'}} @endif</span></td>                   
            </tr>                                                                                                                                                         
        </tbody>
    </table>
    @endif


