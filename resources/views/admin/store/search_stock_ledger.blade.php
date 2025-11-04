@php
$statuses = [
'Sufficient' => 'bg-success',
'Drug running low' => 'bg-warning',
'0 Stock' => 'bg-danger',
'N/A' => 'bg-info',
];
@endphp
<table class="table data-table table-bordered m-0">
    <thead class="bg-primary">
    <tr>
        <th>SL#</th>
  
        <th>Item Namess</th>
        <th>UOM</th>
        <th>Re-Order Level</th>
        <th>Current Stock</th>
        <th>Status</th>
        <th>Store Name</th>
        <th>Supplier Name</th>
        <th>Details</th>
    </tr>
    </thead>
    <tbody>

    @if(!empty($stocks))

        @foreach($stocks as $stock)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                
             
                <td class="text-left">{{ $stock->item_name }}</td>
                <td class="text-left">{{ $stock->uom_name }}</td>
                <td class="text-right">{{ $stock->re_order_level }}</td>
                <td class="text-right">{{ $stock->current_stock }}</td>
                <td class="text-center"><span class="badge {{ $statuses[$stock->stock_status_text] }}  @if($stock->stock_status_text != 'Drug running low')text-white @endif ">{{$stock->stock_status_text}}</span></td>
                <td class="text-left">{{ $stock->store_name }}</td>
                <td class="text-left">{{ $stock->supplier_name }}</td>
                <td><a class="stock_detail" data-current_stock="{{ $stock->current_stock }}" data-opening_qty = "{{ $stock->opening_qty }}" data-store_name = "{{ $stock->store_name }}" data-item_name = "{{ $stock->item_name }}" data-item_id = "{{ $stock->item_no_fk }}" data-store_id = "{{ $stock->stock_su_no_fk }}" href="javascript:void (0)"><i class="fa fa-eye"></i></a></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>