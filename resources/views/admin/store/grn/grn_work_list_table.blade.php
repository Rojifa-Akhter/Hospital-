<table class="table data-table table-striped table-bordered table-hover" id="grn_table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center" width="10%">PO.No</th>
            <th class="text-center">PO Date</th>


            <th class="text-center">Supplier Name</th>
            <th class="text-center">No. of Item</th>
            <th class="text-center" width='20%'>Amount</th>
            <th class="text-center" width='20%'>Action</th>
        </tr>
    </thead>

    <tbody>


        @if (!empty($grn_worklists))
            @foreach ($grn_worklists as $rbc)
                @php
                    $total = 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $rbc->po_no ?: '' }}
                    </td>

                    <td class="text-center">
                        {{ !empty($rbc->au_entry_at) ? date('d/m/Y', strtotime($rbc->au_entry_at)) : '' }}
                    </td>

                    <td class="text-left">
                        {{ $rbc->supplier_name ?: '' }}
                    </td>
                    <td class="text-center">
                        {{ $rbc->item_q ?: '' }}
                    </td>
                    <td class="text-right">{{ $rbc->total_purchase_amount? number_format($rbc->total_purchase_amount, 2) : 0 }}</td>
                    <td class="text-center"><a href="{{ isset($rbc->itemreceive_no_pk) ? route('grn-report-print',$rbc->itemreceive_no_pk): "" }}" target="_blank" class="btn btn-warning btn-sm">Print</a></td>
                </tr>
            @endforeach
        @endif


    </tbody>
    <tfoot class="text-center">
        @php
            $response_url = route('inventory.item_po_worklist');
        @endphp
        <td colspan="6">
            <input type="hidden" id="issue_finalize_ind" name="issue_finalize_ind">

        </td>
        <td></td>
    </tfoot>
</table>
<script>
    $(document).ready( function () {
    $('#grn_table').DataTable({
        ordering:  false,
        "pageLength": 20,
        "aLengthMenu": [
                    [20, 25, 30, 50, -1],
                    [20, 25, 30, 50, "All"]
                ],

    });
} );
</script>
