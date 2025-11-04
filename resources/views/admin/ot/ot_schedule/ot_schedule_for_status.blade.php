<table class="table table-bordered mt-2" id="doct_sch_table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th scope="col">SL</th>
            <th scope="col" class="text-left">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Duration (minutes)</th>
            <th scope="col">Slot</th>
            <th scope="col">Book Slot</th>
            <th scope="col">Available Slot</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>

        @if (isset($schedules) && count($schedules) > 0)
            @foreach ($schedules as $key => $val)
                @php
                    $remaining_slot = $val->total_slot - $val->schedule_count;
                @endphp
                <tr>
                    <td scope="row">{{ $key + 1 }}</td>
                    <td class="text-left">
                        {{ date('d-m-Y, D', strtotime($val->schedule_dt)) }}
                    </td>
                    <td class="text-center">{{ date('h:i A', strtotime($val->start_time)) }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($val->end_time)) }}</td>
                    <td class="text-center">{{ $val->avg_duration }}</td>
                    <td class="text-center">{{ $val->total_slot }}</td>
                    <td class="text-center">
                        @inject('countSchedule', 'App\Http\Controllers\OTController')
                        @php
                            $scheduleDt = date('d-m-Y', strtotime($val->schedule_dt));
                            $ScheduleCount = $countSchedule->getAvailableAndBookCount(
                                $scheduleDt,
                                $val->ot_schedule_no_pk,
                            );
                        @endphp
                        {{ $ScheduleCount['available'] ?? 0 }}
                    </td>
                    <td class="text-center">{{ $ScheduleCount['booked'] ?? 0 }}</td>
                    <td>
                        <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $val->ot_schedule_no_pk }}"
                            data-action="{{ route('get-ot-slot-for-status', $val->ot_schedule_no_pk) }}"data-modal="common-modal-sm"
                            data-title="Slot Details" title="view slot"><i class="fa fa-eye"></i></span>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9" class="text-center text-success"><span>No Data Found</span></td>
            </tr>
        @endif
    </tbody>
</table>
