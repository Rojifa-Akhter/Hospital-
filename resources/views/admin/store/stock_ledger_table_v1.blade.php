<div>
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col" style="width:5%">SL.</th>
                <th class="text-center" scope="col" style="width:30%">Item Name</th>
                <th class="text-center" scope="col" style="width:10%">Generic Name</th>
                <th class="text-center" scope="col" style="width:5%">Purchase UoM</th>
                <th class="text-center" scope="col" style="width:5%">Current Stock</th>
                <th class="text-center" scope="col" style="width:5%">Purchase Price</th>
                <th class="text-center" scope="col" style="width:10%">Total Purchase Price</th>
                <th class="text-center" scope="col" style="width:10%">Last Purchase Date</th>
                <th class="text-center" scope="col" style="width:5%">Last Purchase Price</th>
                <th class="text-center" scope="col" style="width:5%">Last Purchase Qty</th>
                <th class="text-center" scope="col" style="width:10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($stocks))
                @foreach ($stocks as $stock)
                    @php
                        $total_purch_price = ($stock->current_stock ?? 0) * ($stock->purchase_price ?? 0);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-left">{{ $stock->generic_name }}</td>
                        <td class="text-left">{{ $stock->uom_name }}</td>
                        <td class="text-center">{{ $stock->current_stock,2 }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price,2) }}</td>
                        <td class="text-right">{{ number_format($total_purch_price,2) }}</td>
                        <td class="text-center">{{ date('d/M/Y', strtotime($stock->last_purchase_date)) }}</td>
                        <td class="text-center">{{ $stock->last_purchase_prise }}</td>
                        <td class="text-center">{{ $stock->last_purchase_qty }}</td>
                        <td class="text-center">
                            @if ($stock->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif

            {{-- @if (!empty($stocks))
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $stock->item_code }}</td>
                        <td class="text-left">{{ $stock->par_item_type_name_major }}</td>
                        <td class="text-left">{{ $stock->item_type_name }}</td>
                        <td class="text-left">{{ $stock->pack_type }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-left">{{ $stock->generic_name }}</td>
                        <td class="text-left">{{ $stock->uom_name }}</td>
                        <td class="text-center">{{ $stock->re_order_level }}</td>
                        <td class="text-center">{{ number_format($stock->current_stock,2) }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price,2) }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price * $stock->current_stock,2) }}</td>
                        <td class="text-right">{{ number_format($stock->sales_price,2) }}</td>

                        <td class="text-center">
                            @if ($stock->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Inactive</span>
                            @endif
                        </td>
                        <td class="text-left">{{ $stock->store_name }}</td>
                        <td><a class="stock_detail" data-opening_qty="{{ $stock->opening_qty }}"
                                data-store_name="{{ $stock->store_name }}" data-item_name="{{ $stock->item_name }}"
                                data-item_id="{{ $stock->item_no_fk }}" data-store_id="{{ $stock->stock_su_no_fk }}"
                                href="javascript:void (0)"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif --}}
        </tbody>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    var table = $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": true,
        "iDisplayLength": 100,
        "bAutoWidth": false
    });
</script>
