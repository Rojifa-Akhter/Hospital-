<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Code</th>
            <th class="text-center">Supplier Name</th>
            <th class="text-center">PO</th>
            <th class="text-center">PO Date</th>
            <th class="text-center">No Of Item</th>
            <th class="text-center">PO Amount</th>
            <th class="text-center">Status</th>
        </tr>

    </thead>
    <tbody>

        @if (isset($supplierwisePo))
            @foreach ($supplierwisePo as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $data->supplier_uid }}</td>
                    <td class="text-left">{{ $data->supplier_name }}</td>
                    <td class="text-center">{{ $data->purchase_uid }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($data->purchase_date)) }}</td>
                    <td class="text-center">{{ $data->no_of_item }}</td>
                    <td class="text-center">{{ $data->po_amount }}</td>
                    <td class="text-left">{{ $data->po_status }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
