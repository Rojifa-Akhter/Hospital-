<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Card No</td>
            <td class="text-left" scope="col"> Name</td>
            <td class="text-left" scope="col">Designation</td>
            <td class="text-left" scope="col">Total Absent</td>
            <td class="text-left" scope="col">Signature</td>
        </tr>
    </thead>
    @if (isset($value))
        @foreach ($value as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">{{ $data->person_card_no }}</td>
                <td class="text-left" scope="col"> {{ $data->full_name }}</td>
                <td class="text-left" scope="col">{{ $data->designation_name }}</td>
                <td class="text-center" scope="col">Total Absent</td>
                <td class="text-left" scope="col"> </td>
            </tr>
        @endforeach
    @endif
</table>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ]
    });
</script>
