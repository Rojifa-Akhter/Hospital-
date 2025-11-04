{{-- <div>
    <div class="row">
        <div class="col-md-6"><p><strong>Start Time:</strong> 8:00</p></div>
        <div class="col-md-6"><p><strong>End Time:</strong> 2:30 PM</p></div>
        <div class="col-md-6"> <p><strong>Avg Time:</strong> 10 Minutes</p></div>
        <div class="col-md-6"> <p><strong>Number of Slots:</strong><span id="total_slot"></span></p></div>
    </div>
</div> --}}


@if (!empty($intervals))
    <tr class="bg-primary" style="position: sticky; top: 0; background: #f8f9fa; z-index: 1;">
        <td class="text-center"></td>
        <td class="text-center">
            <p><strong>Start Time: </strong> {{ !empty($startTime) ? date('H:i A', strtotime($startTime)) : '' }}</p>
        </td>
        <td class="text-center">
            <p><strong>End Time: </strong> {{ !empty($endTime) ? date('H:i A', strtotime($endTime)) : '' }}</p>
        </td>
        <td class="text-center">
            <div>
                <p><strong>Avg Time: </strong> {{ !empty($avg_interval) ? $avg_interval : '' }} Minutes</p>
            </div>
            <div>
                <p><strong>Number of Slots: </strong>{{ !empty($total_slots) ? $total_slots : '' }}</p>
            </div>
        </td>
    </tr>
    @foreach ($intervals as $index => $interval)
        @php
            $schedule = $selectedSchedules[$interval['start']] ?? null;
            $isSelected = $schedule && $schedule['radt_app_sl'] == $index + 1;
            $radinvoicedtl_no_fk = $schedule['radinvoicedtl_no_fk'] ?? null;
        @endphp

        <tr id="scheduleBook_{{ $interval['start'] }}" class="{{ $isSelected ? 'text-primary bg-green-100' : '' }}">
            <td class="myValueLoop_{{ $index + 1 }}">{{ $index + 1 }}</td>
            <td class="myValueStart_{{ $interval['start'] }}">{{ $interval['start'] }}</td>
            <td class="myValueEnd_{{ $interval['start'] }}">{{ $interval['end'] }}</td>
            <td class="text-center">
                @if ($isSelected)
                    {{-- <span class="btn btn-sm btn-primary" data-id="{{ $radinvoicedtl_no_fk }}" data-action="{{ route('radiology-appointment-card-print',$radinvoicedtl_no_fk) }}" data-title="Radiology Appointment card" title="Radiology Appointment card"><i class="fa fa-print"></i></span> --}}

                    <a href="{{ route('radiology-appointment-card-print', $radinvoicedtl_no_fk) }}"
                        class="btn btn-sm btn-success cursor-pointer" target="_blank"
                        data-id="{{ $radinvoicedtl_no_fk }}" id="Appointment Card Print"
                        title="Admission request form"><i class="fa fa-file-pdf"></i> Print</a>

                    <span class="btn btn-sm btn-danger" data-id="{{ $index + 1 }}" data-start="{{ $interval['start'] }}"
                        data-end="{{ $interval['end'] }}" data-radinvoicedtl="{{ $radinvoicedtl_no_fk }}"><i class="oi oi-circle-x" onclick="cancelSchedule(this)"></i>
                        Cancel
                    </span>
                @else
                    <span class="btn btn-sm btn-primary book-schedule" data-id="{{ $index + 1 }}"
                        data-start="{{ $interval['start'] }}" data-end="{{ $interval['end'] }}"
                        data-radinvoicedtl="{{ $radinvoicedtl_no_fk }}"><i class="oi oi-calendar"></i>
                        Book Schedule
                    </span>
                @endif
            </td>
        </tr>
    @endforeach




@endif

<script>
    $('.book-schedule').click(function() {
        if ($("#search_data").val() == null) {
            alert("Please Select Room !")
            return false;
        }
        var id = $(this).data('id');
        var start = $(this).data('start');
        var end = $(this).data('end');
        var date = $("#radio_appointment_date").val();
        var app_id = $("#app_id").val();
        var inv_voucher_no = $("#inv_voucher_no").val();

        $('#save_buttonRad').click();
        $.ajax({
            url: '{{ route('book.schedule-store-radt') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                start: start,
                end: end,
                date: date,
                app_id: app_id,
                inv_voucher_no: inv_voucher_no,
            },
            success: function(response) {
                $("#appointment_id").val('');
                $('#appointment_id').focus()
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    });

    function cancelSchedule(thisElement){
        console.log('ok')
    }
</script>
