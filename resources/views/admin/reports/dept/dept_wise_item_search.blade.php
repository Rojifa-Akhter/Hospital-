@php
    $invoice_arr = 0;
    $invoice_su_arr[] = [];

@endphp

<div style="display: none">

    {{ $invoice_count = 0 }}
    {{ $sales_total_final_final = 0 }}
    {{ $sales_discount_final = 0 }}
    {{ $collection_final = 0 }}
    {{ $invoice_count_final = 0 }}
    {{ $net_sales_final = 0 }}
    {{ $due_final = 0 }}
    {{ $refund_final = 0 }}
    {{ $netcollection_final = 0 }}
</div>
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Date </th>
            <th class="text-center">Item Name</th>
            {{-- <th class="text-center">UoM</th> --}}

            <th class="text-right">Price</th>
            <th class="text-center">Sales Qty</th>
            <th class="text-center">Cancel Qty</th>
            <th class="text-center">Actual Qty</th>
    </thead>
    <tbody>


        @php
            $final_price =$final_sales_qty = $final_cancel_qty = $final_item_qty = 0;
        @endphp

        @if (!empty($dept))
            @foreach ($dept as $key => $dt)
                <tr>
                    <td colspan="7" class="text-left"><strong>{{ $key }}</strong></td>
                </tr>
                @php
                    $total_price =$total_sales_qty = $total_cancel_qty = $total_item_qty = 0;
                @endphp
                @foreach ($dt as $stock)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d/m/Y', strtotime($stock->invoice_date)) }}</td>
                        <td>{{ $stock->bill_item_name }}</td>
                        <td class="text-right">{{ number_format($stock->item_rate, '2', '.', '') }}
                        </td>
                        <td class="text-center">
                            {{ !empty($stock->item_qty) ? $stock->item_qty : 0 }}</td>
                        <td class="text-center">
                            {{ !empty($stock->cancel_qty) ? $stock->cancel_qty : 0 }}</td>
                        <td class="text-center">
                            {{ !empty($stock->sales_item_qty) ? $stock->sales_item_qty : 0 }}</td>
                    </tr>
                    <div style="display: none">{{ $total_sales_qty += $stock->sales_item_qty }}
                    </div>
                    <div style="display: none">{{ $total_cancel_qty += $stock->cancel_qty }}</div>
                    <div style="display: none">{{ $total_item_qty += $stock->item_qty }}</div>
                    <div style="display: none">{{ $total_price += $stock->item_rate }}</div>
                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="3">Sub Total =</th>
                    <th class="text-right bg-light-blue">{{ $total_price }}</th>
                    <th class="text-center bg-light-blue">{{ $total_item_qty }}</th>
                    <th class="text-center bg-light-blue">{{ $total_cancel_qty }}</th>
                    <th class="text-center bg-light-blue">{{ $total_sales_qty }}</th>
                </tr>


                <div style="display: none">{{ $final_sales_qty += $total_item_qty }}</div>
                <div style="display: none">{{ $final_cancel_qty += $total_cancel_qty }}</div>
                <div style="display: none">{{ $final_item_qty += $total_sales_qty }}</div>
                <div style="display: none">{{ $final_price += $total_price }}</div>
            @endforeach

        @endif

    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-right bg-light-blue">{{ $final_price }}</th>
            <th class="text-center bg-light-blue">{{ $final_sales_qty }}</th>
            <th class="text-center bg-light-blue">{{ $final_cancel_qty }}</th>
            <th class="text-center bg-light-blue">{{ $final_item_qty }}</th>
        </tr>
    </tfoot>

</table>
