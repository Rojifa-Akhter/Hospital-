<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Company Name</th>
                <th class="text-center" scope="col">Item Name</th>
                <th class="text-center" scope="col">Generic Name</th>
                <th class="text-center" scope="col">Qty</th>
                <th class="text-center" scope="col">Sales Price</th>
                <th class="text-center" scope="col">Total Sales Price</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_qty = $total_sales_price = $final_sales_price = 0;
            @endphp
            @if (!empty($report_data))
                @foreach ($report_data as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ !empty($value->supplier_name) ? $value->supplier_name : '' }}</td>
                        <td class="text-left">{{ !empty($value->item_name) ? $value->item_name : '' }}</td>
                        <td class="text-left">{{ !empty($value->generic_name) ? $value->generic_name : '' }}</td>
                        <td class="text-center">{{ !empty($value->qty) ? $value->qty : '' }}</td>
                        <td class="text-right">
                            {{ !empty($value->sales_price) ? number_format($value->sales_price, 2) : '' }}</td>
                            <td class="text-right">
                            {{ !empty($value->qty) ? number_format($value->sales_price * $value->qty, 2) : '' }}</td>
                            <div style="display: none">{{$total_qty += $value->qty}}</div>
                            <div style="display: none">{{$total_sales_price += $value->sales_price}}</div>
                            <div style="display: none">{{$final_sales_price += $value->sales_price * $value->qty}}</div>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="4">Total =</th>
                <th class="text-center bg-light-blue">{{number_format($total_qty)}}</th>
                <th class="text-right bg-light-blue">{{number_format($total_sales_price,2)}}</th>
                <th class="text-right bg-light-blue">{{number_format($final_sales_price,2)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
