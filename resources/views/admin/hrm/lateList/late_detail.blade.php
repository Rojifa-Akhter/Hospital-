<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div style="font-size: 14px">
                    <p class="mb-0">Employee Name: <strong>{{ $lateDetaildata[0]->full_name }}</strong></p>
                    <p class="mb-0">Card No.: <strong>{{ $lateDetaildata[0]->person_card_no }}</strong></p>
                    <p class="mb-0">Department: <strong>{{ $lateDetaildata[0]->department }}</strong></p>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="global-uhl-table-bg">
                        <td>#SL</td>
                        <td class="text-left">Date</td>
                        <td class="text-left">Shift</td>
                        <td class="text-left">In Time</td>
                        <td class="text-left">Out Time</td>
                        <td class="text-left">Early Out</td>
                        <td class="text-left">Late Hour</td>
                    </thead>
                    <tbody>
                        @foreach ($lateDetaildata as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-left">{{ date('d-m-Y', strtotime($data->attendance_date)) }}</td>
                                <td class="text-left">
                                    {{ $data->shift_code }}
                                </td>
                                <td class="text-left">
                                    {{ date('h:i A', strtotime($data->in_time)) }}
                                </td>
                                <td class="text-left">
                                    {{ date('h:i A', strtotime($data->out_time)) }}
                                </td>
                                <td class="text-left">
                                    @php
                                        $outTime = DateTime::createFromFormat(
                                            'h:i A',
                                            date('h:i A', strtotime($data->out_time)),
                                        );
                                        $dutyOutTime = DateTime::createFromFormat('h:i A', $data->duty_out_time);
                                        if ($outTime < $dutyOutTime) {
                                            $interval = $dutyOutTime->diff($outTime);
                                            $hours = $interval->h;
                                            $minutes = $interval->i;
                                        } else {
                                            $hours = 0;
                                            $minutes = 0;
                                        }
                                    @endphp

                                    {{ $hours }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }} hr

                                </td>
                                <td class="text-left">
                                    @php
                                        // Actual in time
                                        $inTime = DateTime::createFromFormat(
                                            'h:i A',
                                            date('h:i A', strtotime($data->in_time)),
                                        );

                                        // Scheduled duty in time + 15 minutes grace
                                        $dutyInTime = DateTime::createFromFormat('h:i A', $data->duty_in_time);
                                        $dutyInTime->modify('+15 minutes'); // Add grace period

                                        if ($inTime > $dutyInTime) {
                                            $interval = $inTime->diff($dutyInTime);
                                            $hours = $interval->h;
                                            $minutes = $interval->i;
                                        } else {
                                            $hours = 0;
                                            $minutes = 0;
                                        }
                                    @endphp

                                    {{ $hours }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }} hr

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    $(".timepicker").timepicker({
        defaultTime: new Date(),
        interval: false,
        // 'timeFormat': '24'
        // showInputs: false,
        showMeridian: false,
        minuteStep: 1,
        // setTime: null
    });
</script>
