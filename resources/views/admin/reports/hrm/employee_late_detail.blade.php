<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <div class="form-group row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="global-uhl-table-bg">
                        <td>#SL</td>
                        <td class="text-left">Date</td>
                        <td class="text-left">Shift</td>
                        <td class="text-center">In time</td>
                        <td class="text-center">Out time</td>
                        <td class="text-center">Late Count</td>
                    </thead>
                    <tbody>
                        @foreach ($monthlyLateData as $key => $data)
                            <tr>
                                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                                <td class="text-left" scope="col">
                                    {{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
                                <td class="text-left" scope="col">
                                    <table>
                                        <tr>
                                            <td class="border-0 text-left" colspan="2"> {{ $data->shift_code }} </td>

                                        </tr>
                                        <tr>
                                            <td class="border-0 text-left"> <strong>Duty In </strong> </td>
                                            <td class="border-0 text-left"> :
                                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-0 text-left"> <strong>Duty Out </strong> </td>
                                            <td class="border-0 text-left"> :
                                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="text-center">
                                    {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                                <td class="text-center">
                                    {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>
                                @php
                                    $minutes = $data->late_time_min;
                                    $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                                @endphp
                                <td class="text-center" scope="col">
                                    @if ($minutes % 60 == '0')
                                    @else
                                        {{ $hours }} hr
                                    @endif
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
