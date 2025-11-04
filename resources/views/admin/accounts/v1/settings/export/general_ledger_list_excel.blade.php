

<main id="page-content">
    <div >
        <table style="border-collapse: collapse">
            <thead>
                <tr>
                    <th colspan="13" style="text-align: center;border: 1px solid #222 ;padding:5px;">General Ledger List</th>
                </tr>
                <tr>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">SL</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;white-space:nowrap">GL Code </th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;white-space:nowrap">GL Description </th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Status</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Mapped Report</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Report Header</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Cost Center</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Recurring Cost</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Control Account</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">GL For</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Cash Flow Report</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Report Header</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">DR/CR</th>
                    <th style="border: 1px solid #222 ;padding:2px;text-align:left;">Depriciation</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $key => $item)

                    <tr>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{++$key}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->account_code}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->account_name}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">@if($item->mapped_report == 'INCOME') {{ 'Income Statement ' }} @elseif($item->mapped_report == 'BALANCE') {{ 'Balance Statement' }} @endif</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">
                            {{$item->report_header}}
                        </td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->cost_center_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->recurring_cost_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->control_acc_ind == 1 ? 'Yes' : 'No'}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">
                            {{$item->bank_ind == 1 ? 'Bank' : ''}}
                            {{$item->bank_ind == 2 ? 'Cash' : ''}}
                            {{$item->bank_ind == 3 ? 'Others' : ''}}
                        </td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">Cash Flow Report</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">
                            @if($item->cash_flow_ind == 1)
                                {{$item->cashflow_report_header}}
                            @endif
                        </td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">{{$item->default_dr_cr}}</td>
                        <td style="border: 1px solid #222 ;padding:2px;text-align:left">
                            @if($item->depreciation_ind == 1)
                                {{ 'Yes' }}
                            @else
                                {{ 'No' }}
                            @endif
                        </td>
                                             
                    </tr>
                @empty
                <tr>
                    <td colspan="14" style="border: 1px solid #222 ;padding:2px;text-align:center">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>



