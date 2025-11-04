<div class="table-responsiveX border-top border-right">
    @php
        $total_item_qty = $total_sales = $total_salesreturn = $total_discount = $total_payment = $total_refund = $total_net_collection = $total_net_sales = 0;
    @endphp
    <table class="table table-bordered table-hover mb-0 data-table">
        <thead class="bg-light-blue sticky">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Item Name</th>
                <th class="text-center" scope="col">Demand Qty</th>
                <th class="text-center" scope="col">Current Stock</th>
                <th class="text-center" scope="col">Last Purchase Qty</th>
                <th class="text-center" scope="col">Last Purchase Amount</th>
                <th class="text-center" scope="col">Last Purchase Date</th>
                <th class="text-center" scope="col">Last Month Expenditure Qty</th>
                <th class="text-center" scope="col">Approved Qty</th>
                <th class="text-center" scope="col">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($items))
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center ">{{ $loop->iteration }}</td>
                        <td class="text-left"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                        <td class="text-center"> </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" scope="col" colspan="10">No Data Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
