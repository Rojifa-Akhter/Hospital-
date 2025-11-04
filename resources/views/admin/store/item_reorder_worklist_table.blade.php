<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table data-table table-striped table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Challan Date</th>
                        <th class="text-center">Challan No</th>
                        <th class="text-center">Item Name</th>
                        <th class="text-center">Item UoM</th>
                        <th class="text-center">Purchase Price</th>
                        <th class="text-center">Sell Price</th>
                        <th class="text-center">Re Order Level(Qty)</th>
                        <th class="text-center">Current Stock</th>
                        <th class="text-center">Store Name</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($item_reorder_level_arr))
                        @foreach ($item_reorder_level_arr as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    {{ !empty($item->challan_date) ? date('d/m/Y', strtotime($item->challan_date)) : 'N/A' }}
                                </td>
                                <td class="text-left">{{ $item->challan_no ?: 'N/A' }}
                                </td>

                                <td class="text-left">
                                    {{ $item->item_name ?: 'N/A' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->uom ?: 'N/A' }}
                                </td>
                                <td>
                                    {{ $item->purchase_price ?: 'N/A' }}
                                </td>
                                <td>
                                    {{ $item->sales_price ?: 'N/A' }}
                                </td>
                                <td>
                                    {{ $item->reorder_level ?: 'N/A' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->item_qty ?: 'N/A' }}</td>

                                <td>
                                    {{ $item->serviceunit_name ?: 'N/A' }}
                                </td>



                                {{-- <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-info" title="Details"><i
                                            class="fas fa-book-open"></i></a>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
