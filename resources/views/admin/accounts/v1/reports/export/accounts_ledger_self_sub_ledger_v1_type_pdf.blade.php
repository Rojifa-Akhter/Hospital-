

    <style>
        table{
            border-collapse: collapse;
        }
        table td {
            font-size: 13px;
            border: 1px solid #B4B5B6;
        }
        .table th {
            font-size: 13px !important;
            border: 1px solid #B4B5B6;
        }
        .top-table{
            width: 50%;
            margin-bottom: 20px;
        } 
        .top-table td{
            border:none !important;
            padding: 1px  2px !important;
            font-size: 13px !important ;
        } 
    </style>

    <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
    <h5 style="margin-top: 10px; text-align:center; margin-bottom:0px" >Sub Ledger Report</h5>            
    <div style="text-align:center;">
        <h6 style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
        <h6 style="text-transform: uppercase;margin-top: 8px; font-size:12px"><span style="font-style:italic;"><b></b>
            {!!@$title!!}
        </span></h6>
    </div>

    @php
        $opening_balance = collect($self_ledger->getData()->ledger_details)->sum('opening_bal');
        $dr = collect($self_ledger->getData()->ledger_details)->sum('dr');
        $cr = collect($self_ledger->getData()->ledger_details)->sum('cr');
        $closing_balance = (floatVal($opening_balance) + floatVal($dr)) - floatVal($cr);
    @endphp

    <table class="top-table">
        <tbody>
            <tr>
                <td><strong>Total Dr</strong></td>
                <td style="text-align:right">@if($dr > 0) {{number_format($dr,2)}} @else {{"(".number_format(abs($dr),2).")"}} @endif</td>                               
            </tr>
            <tr>
                <td><strong>Total Cr</strong></td>
                <td style="text-align:right">@if($cr > 0) {{number_format($cr,2)}} @else {{"(".number_format(abs($cr),2).")"}} @endif</td>                               
            </tr>
            <tr>
                <td><strong>Opening Balance</strong></td>
                <td style="text-align:right">@if($opening_balance > 0) {{number_format($opening_balance,2)}} @else {{"(".number_format(abs($opening_balance),2).")"}} @endif</td>                               
            </tr>
            <tr>
                <td><strong>Closing Balance</strong></td>
                <td style="text-align:right">@if($closing_balance > 0) {{number_format($closing_balance,2)}} @else {{"(".number_format(abs($closing_balance),2).")"}} @endif</td>                               
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="table">
        <thead>
            <tr style="background-color: #003B61; color:white">                                       
                <th style="text-align:left; padding:3px; font-weight:bold">Code</th>
                <th style="text-align:left; padding:3px; font-weight:bold">Subledger Name</th>
                <th style="text-align:left; padding:3px; font-weight:bold">Opening Balance</th>                                                                       
                <th style="text-align:left; padding:3px; font-weight:bold;">Debit</th>
                <th style="ext-align:left; padding:3px; font-weight:bold;">Credit</th>
                <th style="ext-align:left; padding:3px; font-weight:bold">Closing Balance</th>
            </tr>
        </thead>
    
        <tbody>
            @forelse($self_ledger->getData()->ledger_details as $root)
                    @php $closing_bal = (floatVal($root->opening_bal) + floatVal($root->dr)) - floatVal($root->cr); @endphp
                    <tr>                       
                        <td style="padding:2px;">{{$root->subledger_code}}</td>
                        <td style="padding:2px;"><a target="_blank" href="{{route('v1.accounts.subledger-report-by-id-date')}}?hid_acc_code={{@$leder_of_code}}&subledger_id={{@$root->acct_subledger_no_fk}}&from_date={{@$from_date}}&&to_date={{@$to_date}}">{{@$root->subledger_name}}</a></td>
                        <td style="text-align: right; padding:2px; font-style:italic;">@if($root->opening_bal > 0) {{number_format($root->opening_bal,2)}} @else {{"(".number_format(abs($root->opening_bal),2).")"}} @endif</td>
                        <td style="text-align: right; padding:2px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                        <td style="text-align: right; padding:2px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                        <td style="text-align: right; padding:2px; font-style:italic;">@if($closing_bal > 0) {{number_format($closing_bal,2)}} @else {{"(".number_format(abs($closing_bal),2).")"}} @endif</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr> 
            @endforelse                                                                                                                                                      
        </tbody>
    </table>
