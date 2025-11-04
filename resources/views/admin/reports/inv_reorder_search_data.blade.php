<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Item Code </th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">Item Type</th>
            <th class="text-center">Purchase Price</th>
            <th class="text-center">Sales Price</th>
            <th class="text-center">Current Stock</th>
            <th class="text-center">Re Order Level</th>
    </thead>
    <tbody>

        @if (!empty($interdept_reports))
            @foreach ($interdept_reports as $data)
            <?php
            $class_name = '';
                if ($data->current_stock < 10) {
                   $class_name = 'table-danger';
                }
            ?>
                <tr class="{{$class_name}}">
                    @if ($data->current_stock >10)

                    @endif
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $data->item_code }}</td>
                    <td style="text-align: left">{{ $data->item_name }}</td>
                    <td  style="text-align: left">{{ $data->dpartment }}</td>
                    <td style="text-align: left">{{ $data->item_type }}</td>

                    <td style="text-align: right">{{ $data->purchase_price?number_format($data->purchase_price,2):'0.00' }}</td>
                    <td style="text-align: right">{{ $data->sales_price?number_format($data->sales_price,2):'0.00' }}</td>
                    <td style="text-align: center">{{ $data->current_stock?$data->current_stock:0 }}</td>
                    <td style="text-align: center">{{ $data->re_order_level?$data->re_order_level:0 }}</td>

                </tr>
            @endforeach
        @endif

    </tbody>

</table>
