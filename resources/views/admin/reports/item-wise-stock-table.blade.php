<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-left" style="width: 10%;">Department</th>
            <th class="text-left" style="width: 10%;">Item Code</th>
            <th class="text-left" style="width: 20%;">Item Name</th>
            <th class="text-left" style="width: 10%;">Generic Name</th>
            <th class="text-left" style="width: 20%;">Supplier Name</th>
            <th class="text-right" style="width: 10%;">Purchase Price</th>
            <th class="text-right" style="width: 10%;">Sales Price</th>
            <th class="text-center" style="width: 10%;">Stock Qty</th>
            {{-- <th class="text-center" style="width: 5%;">Action</th> --}}
        </tr>
    </thead>
    <tbody style="cursor: pointer;" id="tableBody">
        @if(!empty($items))
            @foreach($items as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td style="text-align:left">{{ $item->serviceunit_name }}</td>
                    <td style="text-align:left">{{ $item->item_code }}</td>
                    <td style="text-align:left">{{ $item->item_name }}</td>
                    <td style="text-align:left">{{ $item->generic_name }}</td>
                    <td style="text-align:left">{{ $item->supplier_name }}</td>
                    <td style="text-align:right">{{ $item->purchase_price }}</td>
                    <td style="text-align:right">{{ $item->sales_price }}</td>
                    <td style="text-align:center">{{ $item->stock_qty }}</td>
                    {{-- <td style="text-align:center">
                        <span class="btn btn-sm btn-primary open-modal" data-id="{{ $item->item_no_pk }}" data-action="{{ route('reports.itemWiseStockDetails', ['id' => $item->item_no_pk]) }}" data-modal="common-modal-md" data-title="Item Wise Stock Details" title="Item Wise Stock Details"><i class="fa fa-file"></i></span>
                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            "pageLength": 10
        });
        $('th').addClass('text-center');
    });
</script>
