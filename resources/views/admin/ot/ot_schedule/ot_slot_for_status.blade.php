<table class="table data-table data_table_slot_details table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center" style="width:10%">SL#</th>
            <th class="text-left">Schedule Date</th>
            <th class="text-left">Start Time</th>
            <th class="text-left">End Time</th>
            <th class="text-left">Status</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($slot_details))
            @foreach ($slot_details as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ date("d-m-Y", strtotime($data->schedule_dt)) }}</td>
                    <td class="text-left">{{ date('h:i A', strtotime($data->start_time)) }}</td>
                    <td class="text-left">{{ date('h:i A', strtotime($data->end_time)) }}</td>
                    <td class="text-left">
                        @if ($data->available_ind == 1)
                            <span class="badge badge-success">Available</span>
                        @else
                            <span class="badge badge-danger">Booked</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
