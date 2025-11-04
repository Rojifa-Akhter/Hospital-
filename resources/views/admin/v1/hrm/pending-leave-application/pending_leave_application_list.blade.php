<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr>
            <th>SL#</th>
            <th class="text-left">Employee Code</th>
            <th class="text-left">Employee Name</th>
            <th class="text-left">Department</th>
            <th class="text-left">Designation</th>
            <th class="text-left">Action</th>
        </tr>
    </thead>
    <tbody id="">
        @if (!empty($pendingLeavedata))
            @foreach ($pendingLeavedata as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $data->card_no }}</td>
                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-left">{{ $data->department }}</td>
                    <td class="text-left">{{ $data->designation_name }}</td>
                    <td class="text-left">
                        <a href="{{ route('hrm.leave-detail', $data->person_no_fk) }}" class="btn btn-outline-success btn-sm bg-none" target="_blank"  title="Detail">
                            Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if(isset($status))
    <script>
        $('.data-table').DataTable({
            "ordering": true,
            "searching": true,
            "lengthMenu": [15, 30, 50, 70, 100],
            "pageLength": 15,

        });
    </script>
@endif
