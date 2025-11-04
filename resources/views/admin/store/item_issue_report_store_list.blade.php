<div>
<!-- @if(isset($total_item))
<h3>Total Item Qty = {{array_sum($total_item)}} , Total Purchase Price = {{number_format(array_sum($total_amt),2)}} , Total Sales Price ={{number_format(array_sum($total_sales_amt),2)}} </h3>
@endif -->
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<table class="table data-table table-bordered m-0 data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center " scope="col">Sl.</th>
            <th class="text-center " scope="col">Indent No</th>
            <th class="text-left " scope="col">Indent By</th>
            <th class="text-left " scope="col">Indent Date</th>
            <th class="text-left " scope="col">Issue Date</th>
            <th class="text-left " scope="col">Receive By</th>
            <th class="text-left " scope="col">Receive Date & Time</th>
            <th class="text-left " scope="col">Item Name</th>
            <th class="text-center " scope="col">Uom </th>
            <th class="text-center " scope="col">Issue Qty</th>
            <th class="text-right " scope="col">Rate</th>
            <th class="text-right " scope="col">Cost Price</th>
            <th class="text-right " scope="col">sales price</th>
            <th class="text-left " scope="col">Issued Store </th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($stocks))
            @foreach ($stocks as $stock)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $stock->inv_requisition_no_pk }}</td>
                    <td class="text-left">{{ $stock->req_by_name }}</td>
                    <td class="text-left">{{ $stock->req_at !="" ? date('d/m/Y h:i a',strtotime($stock->req_at)) :'' }}</td>
                    <td class="text-left">{{ $stock->issue_at !="" ? date('d/m/Y h:i a',strtotime($stock->issue_at)) :'' }}</td>
                    <td class="text-left">{{$stock->recv_by_name}}</td>
                    <td class="text-left">{{ $stock->recv_at !="" ? date('d/m/Y h:i a',strtotime($stock->recv_at)) :''   }}</td>
                    <td class="text-left">{{ $stock->item_name }}</td>
                    <td class="text-center">{{ $stock->req_uom_name }}</td>
                    <td class="text-center">{{ $stock->issue_quantity }}</td>
                    <td class="text-right">{{$stock->purchase_price}}</td>
                    <td class="text-right">{{$stock->purchase_price}}</td>
                    <td class="text-right">{{$stock->sales_price}}</td>
                    <td class="text-left">{{ $stock->from_store }}</td>                   
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
