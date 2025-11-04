<div>
    <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table-bordered m-0 " width="100%">
        <thead class="global-uhl-table-bg">
            <tr>
                <th scope="col" >SL</th>
                <th scope="col">Item Name</th>
                <th scope="col">Store Name</th>
                <th scope="col">Stock Qty</th>
                <th scope="col">UoM</th>
                
            </tr>
        </thead>
        <tbody>
            @if (!empty($stocks))
                @php $sl = 1; @endphp
                @foreach ($stocks as $item_name => $stock)
                    @foreach($stock as $value)
                        <tr>
                            <td class="text-center">{{ $sl++ }}</td>
                            @if ($loop->first)
                                <td class="text-left" rowspan="{{ count($stock) }}">{{ $value->item_name }}</td>
                            @endif
                            <td class="text-left">{{ $value->store_name ?? '' }}</td>
                            <td class="text-center">{{ $value->current_stock ?? 0 }}</td>
                            <td class="text-left">{{ $value->uom_code ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach

            @endif
        </tbody>
    </table>

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
