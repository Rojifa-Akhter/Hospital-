<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<h3 class="text-center">{{ $result[0]->full_name }}</h3>

<table class="table table-bordered datatable" border="1">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-center" scope="col">Date</td>
            <td class="text-center" scope="col">In time</td>
            <td class="text-center" scope="col">Out time</td>
            <td class="text-center" scope="col">Working Hour</td>
        </tr>
    </thead>
    <tbody>
        @if(isset($result))
        @foreach ($result as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-center" scope="col">{{ date('M d, Y', strtotime($data->attendance_date)) }}</td>
                <td class="text-center" scope="col">{{ date('H:i:s', strtotime($data->in_time)) }}</td>
                <td class="text-center" scope="col">{{ !is_null($data->out_time) ? date('H:i:s', strtotime($data->out_time)) : 'N/A' }}</td>
                @php
                    $start  = new Carbon\Carbon($data->in_time);
                    $end    = new Carbon\Carbon($data->out_time);
                    if(!is_null($data->in_time) && !is_null($data->out_time)) {
                        $workingHour = $start->diff($end)->format('%H:%I:%S');
                    } else {
                        $workingHour = 'N/A';
                    }
                @endphp
                <td class="text-center" scope="col">{{ $workingHour }}</td>
            </tr>
        @endforeach
    @endif

    </tbody>
</table>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $(".datatableX").DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });
    });
</script>
