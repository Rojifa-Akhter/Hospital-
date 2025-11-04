<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL</th>
                <th class="text-left">Consumption By</th>
                <th class="text-left">Consumption Date</th>
                <th class="text-left">Department</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Consumption Uom</th>
                <th>Purchase Price</th>
                <th>Current Stock</th>
                <th class="text-left">Internal Batch</th>
                <th>Consumption Qty.</th>
                <th>Cost Price</th>
                <th>Value</th>
            </tr>

        </thead>
        <tbody>
            <?php $totalValue = 0; ?>
            @if (isset($requisition_list))
                @foreach ($requisition_list as $value)
                    <?php 
                        $valueTotal = $value->item_consumption_qty * $value->cost_price; 
                        $totalValue += $valueTotal; 
                    ?>
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->emp_name }}</td>
                        <td class="text-left">{{ $value->inv_consumption_date !="" ? date('d/m/Y',strtotime($value->inv_consumption_date)) :'' }}</td>
                        <td class="text-left">{{ $value->dept }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ $value->uom }}</td>
                        <td class="text-right">{{ $value->purchase_price }}</td>
                        <td class="text-center">{{ $value->curr_stock }}</td>
                        <td class="text-left">
                            {{ $value->internal_batch_no != '0' ? ucwords($value->internal_batch_no) : '' }}
                        </td>
                        <td class="text-right">{{ $value->item_consumption_qty }}</td>
                        <td class="text-right">{{ $value->cost_price }}</td>
                        <td class="text-right">{{ $valueTotal }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="11" class="text-right"><b>Total:</b></td>
                <td class="text-right"><b>{{ $totalValue }}</b></td>
            </tr>
           
        </tfoot>
    </table>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
  $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,
        "pageLength": 20

    });
</script>
