<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
<table class="table data-table table-bordered ">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Atten.Date</td>
            <td class="text-left" scope="col">Employee Card</td>
            <td class="text-left" scope="col">Employee Name</td>
            <!-- <td class="text-left" scope="col"> Name</td>			 -->

            <td class="text-left" scope="col">Dept.</td>
            <td style="width:17%" class="text-left" scope="col">Shift</td>
            <td style="width:8%" class="text-center" scope="col">In Time</td>
            <td style="width:8%" class="text-center" scope="col">Out Time</td>
            <td style="width:6%" class="text-center" scope="col">Late Count</td>
            <td style="width:6%" class="text-center" scope="col">Early Out</td>
            <td style="width:6%" class="text-center" scope="col">Extra Duty Time</td>
            <td style="width:6%" class="text-center" scope="col">Stay Hour</td>
            <td class="text-center" scope="col" style="width:8%">Status </td>
            <td class="text-center" scope="col" style="width:8%">Leave Status</td>
            <td class="text-center" scope="col">Remark</td>
            {{-- <td class="text-left" scope="col">Action</td> --}}
        </tr>
    </thead>

    @if (isset($dailAttendanceReportSearch))
        @foreach ($dailAttendanceReportSearch as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
                <td class="text-left" scope="col"> {{ $data->person_card_no }}</td>
                <td class="text-left" scope="col">{{ $data->full_name }}</td>
                <td class="text-left" scope="col">
                    {{ $data->serviceunit_name != '' ? $data->serviceunit_name : '' }}</td>
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
                <td class="text-center @if($data->entry_type == "2") text-danger @endif" scope="col" >
                    @if (
                        !isset($data->in_time) ||
                            $data->leave_entry_ind == 1 ||
                            $data->shift_code == 'OFFDAY' ||
                            $data->shift_code == 'DAYOFF')
                        -
                    @else
                        {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}
                    @endif
                </td>

                <td class="text-center @if($data->entry_type == "2") text-danger @endif" scope="col">

                    @if (isset($data->in_time) && !isset($data->out_time))
                        No Out Time
                    @elseif (!isset($data->in_time) && !isset($data->out_time))
                        -
                    @elseif($data->leave_entry_ind == 1 || $data->shift_code == 'OFFDAY' || $data->shift_code == 'DAYOFF')
                        -
                    @elseif ($data->in_time == $data->out_time)
                        No Out Time
                    @else
                        {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}
                    @endif
                </td>
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
                {{-- @php
                $earlyMinutes = $data->early_time_min;
                $earlyHours = intdiv($earlyMinutes, 60) . ':' . $earlyMinutes % 60;
                @endphp --}}

                <td class="text-center" scope="col">
                    @if (
                        $data->in_time == $data->out_time ||
                            !isset($data->out_time) ||
                            !isset($data->duty_out_time) ||
                            $data->leave_entry_ind == 1 ||
                            $data->shift_code == 'OFFDAY' ||
                            $data->shift_code == 'DAYOFF')
                    @elseif (isset($data->out_time) && isset($data->duty_out_time))
                        @php
                            $to_time = strtotime($data->out_time);
                            $from_time = strtotime($data->duty_out_time);
                            $ot_min = ($to_time - $from_time) / 60;
                            // $earlyMinutes = $data->early_time_min;
                            $otHours = intdiv($ot_min, 60) . ':' . $ot_min % 60;
                        @endphp
                        @if ($ot_min % 60 < 0 || intdiv($ot_min, 60) < 0)
                            @php
                                $ot_min = abs($to_time - $from_time) / 60;
                                $otHours = intdiv($ot_min, 60) . ':' . $ot_min % 60;
                            @endphp
                            {{ $otHours }} hr
                        @else
                        @endif
                    @else
                    @endif
                </td>

                {{-- @php
                $otMinutes = $data->over_time_min;
                $otyHours = intdiv($otMinutes, 60) . ':' . $otMinutes % 60;
                @endphp --}}

                <td class="text-center" scope="col">
                    @if (
                        $data->in_time == $data->out_time ||
                            !isset($data->out_time) ||
                            !isset($data->duty_out_time) ||
                            $data->leave_entry_ind == 1 ||
                            $data->shift_code == 'OFFDAY' ||
                            $data->shift_code == 'DAYOFF')
                    @elseif (isset($data->out_time) && isset($data->duty_out_time))
                       @php
                            $to_time   = strtotime($data->out_time);       
                            $from_time = strtotime($data->duty_out_time); 
                            $diffSeconds = $to_time - $from_time;

                            $daySeconds = 24 * 3600;
                            $diffSeconds = $diffSeconds % $daySeconds;
                            if ($diffSeconds < 0) {
                                $diffSeconds += $daySeconds;
                            }
                            $minutes = intdiv($diffSeconds, 60);
                            $hours   = intdiv($minutes, 60);
                            $mins    = $minutes % 60;
                            $otHours = sprintf('%d:%02d', $hours, $mins);
                        @endphp          
                       {{ $otHours }} hr
                    @else
                    @endif
                </td>

                <td class="text-center" scope="col">
                    @if (
                        $data->in_time == $data->out_time ||
                            !isset($data->out_time) ||
                            !isset($data->in_time) ||
                            $data->leave_entry_ind == 1 ||
                            $data->shift_code == 'OFFDAY' ||
                            $data->shift_code == 'DAYOFF')
                    @elseif (isset($data->out_time) && isset($data->in_time))
                        @php
                            $to_time = strtotime($data->out_time);
                            $from_time = strtotime($data->in_time);
                            $stay_min = round(abs($to_time - $from_time) / 60);
                            // $earlyMinutes = $data->early_time_min;
                            $stayHours = intdiv($stay_min, 60) . ':' . $stay_min % 60;
                        @endphp
                        @if ($stay_min % 60 == '0')
                        @else
                            {{ $stayHours }} hr
                        @endif
                    @else
                    @endif
                </td>

                <td class="text-center" scope="col">
                    @if ($data->leave_entry_ind == 1)
                        Leave
                    @elseif($data->attendance_status == '7')
                        National Holiday
                    @elseif($data->attendance_status == '6')
                        Day Off
                    @elseif(isset($data->in_time) && isset($data->out_time) && ($data->in_time != $data->out_time))
                        Present
                    @elseif(isset($data->in_time) && !isset($data->out_time))
                        Present
                    @elseif (isset($data->in_time) && isset($data->out_time) && $data->in_time == $data->out_time)
                        Present
                    @else
                        Absent
                    @endif
                </td>
                <td class="text-center" scope="col">
                    @if ($data->leave_entry_ind == 1)
                        {{ $data->leave_reason ? $data->leave_reason : '' }}
                    @else
                    @endif
                </td>
                <td class="text-left" scope="col"></td>

                {{-- <td class="text-left" scope="col">
                    <span class="btn btn-sm btn-success open-modal btnView"
                        data-action="{{ route('puch-time-details', [$data->person_card_no, date('Y-m-d', strtotime($data->attendance_date))]) }}"
                        data-modal="common-modal-xl" data-title="Details">
                        <i class="fa fa-eye"></i>
                    </span>

                </td> --}}
            </tr>
        @endforeach
    @endif
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
