<div class="row">
    <div class="col-md-12">
        <table class="table data_table table-bordered m-0">
            <thead class="bg-primary">
                <tr>
                    <th>SL#</th>
                    <th>Reference No</th>
                    <th>Item Name</th>
                    <th>Batch No</th>
                    <th>Expiration date </th>
                    <th>Received Qty</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($receive_item_by_challan))

                    @foreach ($receive_item_by_challan as $items)
                        
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $items->itemreceive_no_fk }}</td>
                            <td class="text-left">{{ $items->item_name }}</td>
                            <td class="text-left">{{ $items->batch_no }}</td>
                            <td class="text-left">{{ isset($items->expiry_date)? date('d/m/Y',strtotime($items->expiry_date)): '' }}</td>
                            <td class="text-right">{{ $items->item_qty }}</td>
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
    </div>

</div>
