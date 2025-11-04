<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">

    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" scope="col">#SL</th>
            <th class="text-left" scope="col">Card No</th>
            <th class="text-left" scope="col"> Name</th>
            <th class="text-left" scope="col">Designation</th>
            <th class="text-left" scope="col">In Time</th>
            <th class="text-left" scope="col">Late Time</th>
        </tr>
    </thead>

    @if (isset($value))
        @foreach ($value as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">{{ $data->person_card_no }}</td>
                <td class="text-left" scope="col"> {{ $data->full_name }}</td>
                <td class="text-left" scope="col">{{ $data->designation_name }}</td>
                <td class="text-center" scope="col">
                    {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                @php
                    $minutes = $data->late_time_min;

                    $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                @endphp
                <td class="text-center" scope="col">{{$hours}} hour</td>
            </tr>
        @endforeach
    @endif
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
