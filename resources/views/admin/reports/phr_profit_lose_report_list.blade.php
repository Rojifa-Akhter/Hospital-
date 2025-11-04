<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            {{-- <th class="text-right">Date</th> --}}
            <th class="text-left">Item Name</th>
            <th class="text-left">Supplier Name</th>
            <th class="text-right">Item Qty</th>
            <th class="text-right">Purchase Price</th>
            <th class="text-right">Sales Price</th>
            <th class="text-right"> Total Purchase Price</th>
            <th class="text-right">Total Sales Price</th>
            <th class="text-right">Discount</th>

            <th class="text-right">Profit / Loss</th>

            {{-- <th class="text-right">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        <div style="display: none">
            {{ $sales_total = 0 }}
            {{ $purchase_price = 0 }}
            {{ $total_item_qty = 0 }}
            {{ $total_sales_price = 0 }}
            {{ $total_cancel_price = 0 }}
            {{ $total_purchase_price = 0 }}
            {{ $total_discount = 0 }}
            {{ $total_profit = 0 }}

        </div>
        @if (!empty($item_data))
            @foreach ($item_data as $value)


                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ $value->supplier_name }}</td>
                        <td class="text-right">{{ $value->item_qty }} </td>
                        <td class="text-right">{{ number_format($value->purchase_price, 2) }}</td>
                        <td class="text-right">{{ number_format($value->sales_price, 2) }} </td>

                        <td class="text-right">{{ number_format($value->total_purchase_price, 2) }} </td>
                        <td class="text-right">{{ number_format($value->total_sales_price, 2) }} </td>
                        <td class="text-right">{{ number_format($value->discount, 2) }} </td>

                        <td class="text-right">{{ number_format($value->profit, 2) }} </td>

                        <div style="display: none">{{ $sales_total += $value->sales_price }}</div>
                        <div style="display: none">{{ $purchase_price += $value->purchase_price }}</div>
                        <div style="display: none">{{ $total_item_qty += $value->item_qty }}</div>
                        <div style="display: none">{{ $total_sales_price += $value->total_sales_price }}</div>
                        {{-- <div style="display: none">{{ $total_cancel_price += $value->total_cancel_price }}</div> --}}
                        <div style="display: none">{{ $total_purchase_price += $value->total_purchase_price }}</div>
                        <div style="display: none">{{ $total_discount += $value->discount }}</div>
                        <div style="display: none">{{ $total_profit += $value->profit }}</div>

                    </tr>



            @endforeach
            <tr>
                <th class="text-right" colspan="6"> Total =</th>

                <th class="text-right bg-light-blue" >{{number_format($total_purchase_price,2)}} </th>
                <th class="text-right bg-light-blue" >{{number_format($total_sales_price,2)}} </th>
                <th class="text-right bg-light-blue" >{{number_format($total_discount,2)}} </th>
                <th class="text-right bg-light-blue" >{{number_format($total_profit,2)}} </th>
            </tr>
            {{-- <tr>
                <th class="text-right" colspan="6"> Total Zakat =</th>

                <th class="text-right bg-light-blue" ></th>
                <th class="text-right bg-light-blue" ></th>
                <th class="text-right bg-light-blue" ></th>
                <th class="text-right bg-light-blue" >{{number_format($zakat_muslim+$zakat_nonmuslim,2)}} </th>
            </tr> --}}
        @endif
    </tbody>

</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
