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
                <th class="text-center">
                    <input type="checkbox" id="selectAll"> <!-- Select All Checkbox -->
                </th>
                <th class="text-center" scope="col" style="width:3%">SL</th>
                <th class="text-center" scope="col" style="width:6%">Item Code</th>
                <th class="text-center" scope="col" style="width:6%">Item No.</th>
                <th class="text-center" scope="col" style="width:9%">Major Group</th>
                <th class="text-center" scope="col" style="width:9%">Minor Group</th>
                <th class="text-center" scope="col" style="width:9%">Dosage type</th>
                <th class="text-center" scope="col" style="width:10%">Item Name</th>
                <th class="text-center" scope="col" style="width:9%">Generic Name</th>
                <th class="text-center" scope="col" style="width:5%">UoM</th>
                <th class="text-center" scope="col" style="width:9%">Current Stock</th>
                <th class="text-center" scope="col" style="width:9%">Purchase Price</th>
                <th class="text-center" scope="col" style="width:9%">Total Purchase Price</th>
                <th class="text-center" scope="col" style="width:7%">Sales Price</th>
                <th class="text-center" scope="col" style="width:4%">Status</th>
                <th class="text-center" scope="col" style="width:13%">Store Name</th>
                <th class="text-center" scope="col" style="width:6%">Details</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($stocks))
                @foreach ($stocks as $stock)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="stock-checkbox" data-stock-id="{{ $stock->item_no_fk }}"
                                data-store-id="{{ $store_id }}">
                        </td>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $stock->item_code }}</td>
                        <td class="text-left">{{ $stock->item_no_fk }}</td>
                        <td class="text-left">{{ $stock->par_item_type_name_major }}</td>
                        <td class="text-left">{{ $stock->item_type_name }}</td>
                        <td class="text-left">{{ $stock->pack_type }}</td>
                        <td class="text-left">{{ $stock->item_name }}</td>
                        <td class="text-left">{{ $stock->generic_name }}</td>
                        <td class="text-left">{{ $stock->uom_name }}</td>
                        <td class="text-center">{{ number_format($stock->current_stock, 2) }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price, 2) }}</td>
                        <td class="text-right">{{ number_format($stock->purchase_price * $stock->current_stock, 2) }}
                        </td>
                        <td class="text-right">{{ number_format($stock->sales_price, 2) }}</td>
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

    <!-- Print Button -->
    <button id="printSelected" data-store-id="{{$store_id }}" type="button"  class="btn btn-primary">Print Selected</button>

</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    // Initialize DataTable
    var table = $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": true,
        "iDisplayLength": 100,
        "bAutoWidth": false
    });

    $(document).ready(function() {
        var selectedStockIds = [];
        var storeList = [];

        function updateSelectedStocks() {
            selectedStockIds = [];
            storeList = [];
            $(".stock-checkbox:checked").each(function() {
                var stockId = $(this).data("stock-id");
                var storeId = $(this).data("store-id");

                selectedStockIds.push(stockId);
                if (!storeList.includes(storeId)) {
                    storeList.push(storeId);
                }
            });
        }

        // When checkbox is clicked, update selection
        $(document).on("change", ".stock-checkbox", function() {
            var stockId = $(this).data("stock-id");
            var storeId = $(this).data("store-id");
            if ($(this).is(":checked")) {
                if (!selectedStockIds.includes(stockId)) {
                    selectedStockIds.push(stockId);
                }
                if (!storeList.includes(storeId)) {
                    storeList.push(storeId);
                }
            } else {
                selectedStockIds = selectedStockIds.filter(id => id !== stockId);
                storeList = storeList.filter(id => id !== storeId);
            }
        });

        // Reapply selections when table is redrawn
        table.on('draw', function() {
            $(".stock-checkbox").each(function() {
                var stockId = $(this).data("stock-id");
                if (selectedStockIds.includes(stockId)) {
                    $(this).prop("checked", true);
                }
            });
        });

        // Handle Print Button Click
        $("#printSelected").click(function() {
            var genStore = $(this).data("store-id");
            if (selectedStockIds.length > 0) {
                var form = $("<form></form>").attr({
                    action: "{{ route('inventory.fetch-selected-stocks') }}",
                    method: "POST",
                    target: "_blank"
                });

                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}"/>');
                form.append('<input type="hidden" name="stock_ids" value="' + selectedStockIds.join(
                    ',') + '"/>');
                form.append('<input type="hidden" name="storeName" value="'+ genStore +'"/>');
                form.append('<input type="hidden" name="print_type" value="pdf_item_wise"/>');

                $("body").append(form);
                form.submit();
            } else {
                alert("No items selected for printing.");
            }
        });
    });
</script>
