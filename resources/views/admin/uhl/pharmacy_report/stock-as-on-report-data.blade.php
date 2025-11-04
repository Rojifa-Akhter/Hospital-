@php
    $total_purchase_price = 0;
    $total_sales_price = 0;
    $total_op_qty = 0;
    $total_stock_in = 0;
    $total_stock_out = 0;
    $total_qty = 0;
    $total_clos_qty = 0;
    $purchase = 0;
    $salse = 0;
@endphp
@if (!empty($data))
    @foreach ($data as $value)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $value->department }}</td>
            <td class="text-left">{{ $value->item_category }}</td>
            <td class="text-left">{{ $value->item_sub_category }}</td>

            <td class="text-center">{{ $value->item_no_fk }}</td>
            <td class="text-left">{{ $value->item_name }}</td>
            <td class="text-left">{{ $value->generic_name }}</td>
            <td class="text-left">
                @if (!empty($value->batch_no))
                    {{ $value->batch_no }}
                @else
                    {{ $value->internal_batch_no_uq }}
                @endif
            </td>

            <td class="text-left">

                {{ empty($value->expiry_date) || $value->expiry_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->expiry_date)) }}
            </td>
            <td class="text-right">{{ $value->clos_qty }}</td>
            <td class="text-right">{{ number_format($value->purchase_price * $value->clos_qty, 2, '.', '') }}</td>
            <td class="text-center">
                @if (!empty($value->itemreceive_no_fk))
                <a href="{{ route('v2.grn-report-print', $value->itemreceive_no_fk) }}" target="_blank"
                    class="btn btn-warning btn-sm">{{ $value->itemreceive_no_fk }}</a>
                @else
                    N/A
                @endif

            </td>
            <td class="text-left">

                {{ empty($value->grn_date) || $value->grn_date == '1970-01-01' ? 'N/A' : date('d/m/Y', strtotime($value->grn_date)) }}

                {{-- {{ date('d/m/Y', strtotime($value->grn_date)) }} --}}
            </td>
            {{-- <td class="text-right">{{ number_format($value->purchase_price, 2, '.', '')}}</td> --}}
            {{-- <td class="text-right">{{ number_format($value->sales_price, 2, '.', '') }}</td> --}}
            {{-- <td class="text-right">{{ $value->op_qty }}</td> --}}
            {{-- <td class="text-right">{{ $value->stock_in }}</td> --}}
            {{-- <td class="text-right">{{ $value->stock_out }}</td> --}}
            {{-- <td class="text-right">{{ number_format($value->sales_price * $value->clos_qty, 2, '.', '') }}</td> --}}

        </tr>
        @php
            $total_purchase_price += $value->purchase_price;
            $total_sales_price += $value->sales_price;
            $total_op_qty += $value->op_qty;
            $total_stock_in += $value->stock_in;
            $total_stock_out += $value->stock_out;
            $total_clos_qty += $value->clos_qty;
            $purchase += $value->purchase_price * $value->clos_qty;
            $salse += $value->sales_price * $value->clos_qty;
        @endphp
    @endforeach

@endif

{{-- <tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: right;"><strong>Total</strong></td>
    <td style="text-align: right;"><strong></strong></td>
    <td style="text-align: right;"><strong></strong></td>
    <td style="text-align: right;"><strong>{{ $total_op_qty }}</strong></td>
    <td style="text-align: right;"><strong>{{ $total_stock_in }}</strong></td>
    <td style="text-align: right;"><strong>{{ $total_stock_out }}</strong></td>
    <td style="text-align: right;"><strong>{{ $total_clos_qty }}</strong></td>
    <td style="text-align: right;"><strong>{{ number_format($purchase, 2, '.', '') }}</strong></td>
    <td style="text-align: right;"><strong>{{ number_format($salse, 2, '.', '') }}</strong></td>


</tr> --}}
