<div>
<!-- @if(isset($total_item))
<h3>Total Item Qty = {{array_sum($total_item)}} , Total Purchase Price = {{number_format(array_sum($total_amt),2)}} , Total Sales Price ={{number_format(array_sum($total_sales_amt),2)}} </h3>
@endif -->
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<table class="table data-table table-bordered m-0 data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center " scope="col">SL</th>
            <th class="text-center " scope="col">GRN No</th>
            <th class="text-left " scope="col">GRN Date</th>
            <th class="text-left " scope="col">Receive by</th>
            <th class="text-center " scope="col">Po No</th>
            <th class="text-left " scope="col">Po Date</th>
            <th class="text-left " scope="col">Item Name</th>
            <th class="text-center " scope="col">Uom </th>
            <th class="text-center " scope="col">Qty</th>
            <th class="text-right " scope="col">Rate</th>
            <th class="text-right " scope="col">Cost Price</th>
            <th class="text-right " scope="col">sales price</th>
            <th class="text-center " scope="col">Store Name</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($stocks))
            @foreach ($stocks as $stock)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $stock->itemreceive_no_pk }}</td>
                    <td class="text-left">{{ $stock->receive_date !="" ? date('d/m/Y',strtotime($stock->receive_date)) :'' }}</td>
                    <td class="text-left">{{ $stock->received_by }}</td>
                    <td class="text-center">{{ $stock->po_no }}</td>
                    <td class="text-left">{{ $stock->purchase_date !="" ? date('d/m/Y',strtotime($stock->purchase_date)) :''   }}</td>
                    <td class="text-left">{{ $stock->item_name }}</td>
                    <td class="text-center">{{ $stock->uom_code }}</td>
                    <td class="text-center">{{ $stock->delivered_qty }}</td>
                    <td class="text-right">{{ $stock->purchase_price }}</td>
                    <td class="text-right">{{ $stock->cost_price }}</td>
                    <td class="text-right">{{ $stock->sales_price }}</td>
                    <td class="text-center">{{ $stock->department }}</td>                   
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
