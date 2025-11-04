<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left">SL#</th>
            <th class="text-left">Employee ID</th>
            <th class="text-left sticky-col sticky-col-name">Name</th>
            <th class="text-left">Department</th>
            <th class="text-left">Unit</th>
            <th class="text-left">Assign Date</th>
            <th class="text-left">Assign Type</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($assignDutydata))
            @foreach ($assignDutydata as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->person_code }}</td>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->serviceunit_no_fk_dept_name }}</td>
                    <td>{{ $data->su_name }}</td>
                    <td>{{ @$data->assign_date ? date('d-m-Y', strtotime($data->assign_date)) : '' }}</td>
                    <td>{{ $data->al_ind == 1 ? 'Alternative Leave' : 'Over Time' }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({});
</script>
