<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">Doctor Name</th>
            <th class="text-left">Department</th>
            <th class="text-center">No Of IPD Patient</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total_no_of_patient = 0;
    @endphp
        @if (!empty($doctorPerformanceSummary))

            @foreach ($doctorPerformanceSummary as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $data->primary_doctor_name }}</td>
                    <td class="text-left">{{ $data->dept }}</td>
                    <td class="text-center">{{ $data->no_of_patient }}</td>
                </tr>
                <div style="display: none">{{ $total_no_of_patient += $data->no_of_patient }}</div>
            @endforeach

        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-center bg-light-blue">{{ $total_no_of_patient }}</th>
        </tr>
    </tfoot>
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
