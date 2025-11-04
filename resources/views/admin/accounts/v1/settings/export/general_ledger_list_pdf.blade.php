<style>
    table tr td{
        font-size: 10px !important;
        line-height: 9px;
 
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
    }
    thead>tr>th{
        font-size: 11px;
        padding: 3px 1px;
    }
    .striped-table tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>
<main id="page-content">
    <div>
        <div>
            <h3 style="text-align:center;margin-bottom:20px">General Ledger List </h3>
        </div>
        <table class="striped-table" style="border-collapse: collapse;width:100%">
            <thead>   
            <tr style="background-color: #626e84;color:white">                    
                <th style="text-align:left;width: 3%">SL</th>
                <th style="text-align:left;width: 3%">GL Code </th>
                <th style="text-align:left;width: 9%">GL Description </th>
                <th style="text-align:left;width: 5%">Status</th>
                <th style="text-align:left;width: 10%">Mapped Report</th>
                <th style="text-align:left;width: 14%">Report Header</th>
                <th style="text-align:left;width: 5%">Cost Center</th>
                <th style="text-align:left;width: 9%">Recurring Cost</th>
                <th style="text-align:left;width: 5%">Control Account</th>
                <th style="text-align:left;width: 5%">GL For</th>
                <th style="text-align:left;width: 8%">Cash Flow Report</th>
                <th style="text-align:left;width: 8%">Report Header</th>
                <th style="text-align:left;width: 3%">DR/CR</th>
                <th style="text-align:left;width: 8%">Depreciation</th>
            </tr> 
            </thead>

            <tbody>
                @forelse ($data as $key => $item)
                    <tr>
                        <td style="text-align: center">{{++$key}}</td>
                        <td style="text-align: center">{{$item->account_code}}</td>
                        <td>{{$item->account_name}}</td>
                        <td>{{$item->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>@if($item->mapped_report == 'INCOME') {{ 'Income Statement ' }} @elseif($item->mapped_report == 'BALANCE') {{ 'Balance Statement' }} @endif</td>
                        <td>
                            {{$item->report_header}}
                        </td>
                        <td>{{$item->cost_center_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td>{{$item->recurring_cost_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td>{{$item->control_acc_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td>
                            {{$item->bank_ind == 1 ? 'Bank' : ''}}
                            {{$item->bank_ind == 2 ? 'Cash' : ''}}
                            {{$item->bank_ind == 3 ? 'Others' : ''}}
                        </td>
                        <td>Cash Flow Report</td>
                        <td>
                            @if($item->cash_flow_ind == 1)
                                {{$item->cashflow_report_header}}
                            @endif
                        </td>   
                        <td>{{$item->default_dr_cr}}</td>                                         
                        <td>
                            @if($item->depreciation_ind == 1)
                                {{ 'Yes' }}
                            @else
                                {{ 'No' }}
                            @endif
                        </td>                                         
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="12"  style="padding:1px 3px;text-align:center">No Data Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



