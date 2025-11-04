<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL</th>
                <th>Generic Name</th>
                <th class="text-left">Category</th>
                <th class="text-left">Sub. Category</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Last Purchase Price</th>
                <th class="text-left">Last Sale Price</th>
                <th class="text-left">Current Stock</th>
                <th class="text-left">Store Name</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($report_data))


                @foreach ($report_data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ !empty($item->generic_name) ? $item->generic_name : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->catagory) ? $item->catagory : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->sub_catagory) ? $item->sub_catagory : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->item_name) ? $item->item_name : 'N/A' }}</td>
                        <td class="text-right">
                            {{ !empty($item->purchase_price) ? number_format($item->purchase_price, 2) : 'N/A' }}</td>
                        <td class="text-right">
                            {{ !empty($item->sales_price) ? number_format($item->sales_price, 2) : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($item->curr_stk) ? $item->curr_stk : 'N/A' }}</td>
                        <td class="text-left">{{ !empty($item->store) ? $item->store : 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,

    });
</script>
