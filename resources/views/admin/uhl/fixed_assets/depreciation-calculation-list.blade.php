@php
    $total_cost_balance_total = 0;
    $total_cost_addition_total = 0;
    $total_cost_disposal_adj_total = 0;
    $total_cost_cal_total = 0;
    $total_depr_rate = 0;
    $total_depr_balance_total = 0;
    $total_depr_Charged_during_total = 0;
    $total_depr_disposal_adj_total = 0;
    $total_depr_cal_total = 0;
    $total_written_down_value_wdv_total = 0;
    $total_depr_charged_during_total = 0;
    $total_depr_Charged_during_total = 0;
@endphp
@if (isset($depreciation_arr_group) && !empty($depreciation_arr_group))

    @foreach ($depreciation_arr_group as $yearMonth => $value)
        <tr>
            <td style="text-align: left!important;" colspan="15"> <strong> {{ $yearMonth }}</strong></td>
        </tr>
        @php
            $sum_cost_balance_total = 0;
            $sum_cost_addition_total = 0;
            $sum_cost_disposal_adj_total = 0;
            $sum_cost_cal_total = 0;
            $sum_depr_rate = 0;
            $sum_depr_balance_total = 0;
            $sum_depr_Charged_during_total = 0;
            $sum_depr_disposal_adj_total = 0;
            $sum_depr_cal_total = 0;
            $sum_written_down_value_wdv_total = 0;
            $sum_depr_charged_during_total = 0;
        @endphp
        @foreach ($value as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->processed_date != '' ? date('d/m/Y', strtotime($data->processed_date)) : '' }}</td>
                <td>{{ $data->processed_by_name }}</td>
                <td>{{ $data->major_group_name }}</td>
                {{-- <td>{{$data->minor_group_name}}</td> --}}
                <td class="text-right">{{ number_format($data->cost_balance, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->cost_addition_during_month, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->cost_disposal_adj, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->cost_closing_balance, 2, '.', '') }}</td>
                <td class="text-center">{{ number_format($data->dept_rate) }}%</td>
                <td class="text-right">{{ number_format($data->dept_balance, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->depr_charged, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->depr_disposal_adj, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->dept_closing_balance, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($data->wdv, 2, '.', '') }}</td>
                <td class="text-right">
                    <span class="btn btn-sm btn-success open-modal btnView"
                        data-action="{{ route('v1.depreciation-calculation-details', [$data->major_group_no_fk,$data->month_of_calc_yyyymm]) }}"
                        data-modal="common-modal-xl" data-title="Depreciation Details" title="View Depreciation Details"
                        data-id="{{ $data->major_group_no_fk }}"><i class="fa fa-eye"></i></span>
                </td>
            </tr>

            @php
                $sum_cost_balance_total += $data->cost_balance;
                $sum_cost_addition_total += $data->cost_addition_during_month;
                $sum_cost_disposal_adj_total += $data->cost_disposal_adj;
                $sum_cost_cal_total += $data->cost_closing_balance;
                $sum_depr_rate += 0;
                $sum_depr_balance_total += $data->dept_balance;
                $sum_depr_charged_during_total += $data->depr_charged;
                $sum_depr_disposal_adj_total += $data->depr_disposal_adj;
                $sum_depr_cal_total += $data->dept_closing_balance;
                $sum_written_down_value_wdv_total += $data->wdv;
            @endphp
        @endforeach

        {{-- <tr>
            <th colspan="4" class="text-right table_heading_bg">Total</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_cost_balance_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_cost_addition_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_cost_disposal_adj_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_cost_cal_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg"></th>
            <th class="text-right table_heading_bg">{{ number_format($sum_depr_balance_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_depr_Charged_during_total, 2, '.', '') }}
            </th>
            <th class="text-right table_heading_bg">{{ number_format($sum_depr_disposal_adj_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_depr_cal_total, 2, '.', '') }}</th>
            <th class="text-right table_heading_bg">{{ number_format($sum_written_down_value_wdv_total, 2, '.', '') }}
            </th>
            <th class="text-right table_heading_bg"></th>
        </tr> --}}

        @php
            $total_cost_balance_total += $sum_cost_balance_total;
            $total_cost_addition_total += $sum_cost_addition_total;
            $total_cost_disposal_adj_total += $sum_cost_disposal_adj_total;
            $total_cost_cal_total += $sum_cost_cal_total;
            $total_depr_rate += 0;
            $total_depr_balance_total += $sum_depr_balance_total;
            $total_depr_Charged_during_total += $sum_depr_charged_during_total;
            $total_depr_disposal_adj_total += $sum_depr_disposal_adj_total;
            $total_depr_cal_total += $sum_depr_cal_total;
            $total_written_down_value_wdv_total += $sum_written_down_value_wdv_total;
        @endphp
    @endforeach

    <tr>
        <th colspan="4" class="text-right table_heading_bg">Total</th>
        <th class="text-right table_heading_bg">{{ number_format($total_cost_balance_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_cost_addition_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_cost_disposal_adj_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_cost_cal_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg"></th>
        <th class="text-right table_heading_bg">{{ number_format($total_depr_balance_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_depr_Charged_during_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_depr_disposal_adj_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_depr_cal_total, 2, '.', '') }}</th>
        <th class="text-right table_heading_bg">{{ number_format($total_written_down_value_wdv_total, 2, '.', '') }}
        </th>
        <th class="text-right table_heading_bg"></th>
    </tr>

@endif
