<div>
    {{-- @if (Session::get('user.ses_hospital_code') != 'JKMH') --}}
        @if (isset($total_item))
            <h3>Total Item Qty = {{ array_sum($total_item) }} , Total Purchase Price =
                {{ number_format(array_sum($total_amt), 2) }} , Total Sales Price
                ={{ number_format(array_sum($total_sales_amt), 2) }} </h3>
        @endif
    {{-- @endif --}}
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                {{-- <th class="text-center " scope="col">Supplier Name</th> --}}
                <th class="text-center " scope="col">Item Code</th>
                <th class="text-center " scope="col">Pack Type</th>
                <th class="text-center " scope="col">Item Name</th>
                <th class="text-center " scope="col">Generic Name</th>
                <th class="text-center " scope="col">UoM</th>
                <th class="text-center " scope="col">ROL</th>

                <th class="text-center " scope="col">Current Stock</th>
                <th class="text-center " scope="col">Purchase Price</th>
                <th class="text-center " scope="col">Sales Price</th>
                <th class="text-center " scope="col">Status</th>
                <th class="text-center " scope="col">Store Name</th>
                <th class="text-center " scope="col">Details</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($stocks))
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        {{-- <td class="text-left">{{ $stock->supplier_name }}</td> --}}
                        <td class="text-left">{{ $stock->item_code }}</td>
                        <td class="text-left">{{ $stock->pack_type }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-left">{{ $stock->generic_name }}</td>
                        <td class="text-left">{{ $stock->uom_name }}</td>
                        <td class="text-center">{{ $stock->re_order_level }}</td>
                        <td class="text-center">{{ $stock->current_stock }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price,2) }}</td>
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
            @endif
        </tbody>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
      var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bAutoWidth": false
        });
       
</script>
