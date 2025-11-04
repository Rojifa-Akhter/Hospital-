@php
    $total_amount = 0;
    $total_qty = 0;
@endphp

@if (!empty($data))
    @foreach ($data as $value)
        <tr>
            <td class="text-center" scope="col">{{ $loop->iteration }}</td>
            <td class="text-center" scope="col">{{ $value->indent_no }} </td>
            <td class="text-center" scope="col">
                @if (isset($value->indent_date))
                    {{ date('d-m-Y', strtotime($value->indent_date)) }}
                @endif
            </td>
            <td class="text-center" scope="col"> <a href="{{route('v1.issue-print-pdf',$value->issue_no)}}" target="_blank" title="click to show pdf report">{{ $value->issue_no }}</a>  </td>
            <td class="text-center"scope="col">
                @if (isset($value->issue_date))
                    {{ date('d-m-Y', strtotime($value->issue_date)) }}
                @endif
            </td>
            <td class="text-center" scope="col">{{ $value->from_store }}</td>
            <td class="text-center" scope="col">{{ $value->to_store }} </td>
            <td class="text-center" scope="col">{{ $value->item_no }}</td>
            <td class="text-left" scope="col">{{ $value->item_name }}</td>
            <td class="text-center" scope="col">{{ $value->uom }}</td>
            <td class="text-right" scope="col">{{ $value->qty }}</td>
            <td class="text-right" scope="col">{{ $value->rate }}</td>
            <td class="text-right" scope="col">{{ $value->total }}</td>
        </tr>

        @php
            $total_amount = $total_amount + $value->total;
            $total_qty = $total_qty + $value->qty;
        @endphp
    @endforeach
    <tr>
        <th colspan="10" class="text-right table_heading_bg">
            <h4>Total =</h4>
        </th>
        <th class="text-right table_heading_bg">
            <h4>{{ number_format($total_qty) }}</h4>
        </th>
        <th class="text-right table_heading_bg"></th>
        <th class="text-right table_heading_bg">
            <h4>{{ number_format($total_amount, 2, '.', '') }}</h4>
        </th>
    </tr>

@endif
