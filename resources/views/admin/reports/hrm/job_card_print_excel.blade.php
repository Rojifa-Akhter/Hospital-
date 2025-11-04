<main>
    <div class="wrapper" style="margin-bottom: 2px;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:5px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:5px; font-size:20px  "><strong>Job Card Attendance Summary</strong></span>
            <br>
            @php
                $month = date('d/m/Y', strtotime($from_date));
            @endphp
            <strong> Date : </strong><span>{{ $from_date ? $from_date : '' }} to
                {{ $ta_date ? $ta_date : '' }}</span>

        </div>

        <div class="infos">
            @if (!empty($details))
                <table style="width:100%;">
                    <tr>
                        <td><strong> Name </strong></td>
                        <!-- @php
                            $photo = $details->photo_name ? $details->photo_name : '';
                        @endphp -->

                        <td> : {{ $details->salutation ? $details->salutation : '' }}
                            {{ $details->full_name ? $details->full_name : '' }}</td>

                        <td><strong> Department </strong></td>
                        <td> : {{ $details->department ? $details->department : '' }}</td>

                        <td style="text-align:right; width:50px;" rowspan="4">
                            @if ($details->photo_name != '')
                                <img src="{{ asset('images/uploads/doctor_images/thumb') }}/{{ $photo }}"
                                    alt="">
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <td><strong> Card No </strong></td>
                        <td> : {{ $details->person_card_no ? $details->person_card_no : '' }}</td>

                        <td><strong> Designation </strong></td>
                        <td> : {{ $details->specialization_name ? $details->specialization_name : '' }}</td>

                    </tr>

                    <tr>
                        <td><strong> Phone No </strong></td>
                        <td> : {{ $details->phone_mobile ? $details->phone_mobile : '' }}</td>


                        <td><strong> Joining Date </strong></td>
                        <td> : {{ $details->join_date ? date('d/m/Y', strtotime($details->join_date)) : '' }}</td>
                    </tr>

                    <tr>
                        <td><strong> Grade Name </strong></td>
                        <td> : {{ $details->grade_name ? $details->grade_name : '' }}</td>


                        <td><strong> Roster Type </strong></td>
                        <td> : {{ $details->duty_roster_type ? $details->duty_roster_type : '' }}</td>
                    </tr>
                </table>
            @endif
        </div>

        <div class="attendance_list" style="margin-top:5px;">
            <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                <tr class="table-tr" style="background-color: #E3E3E3;">
                    <td style="text-align: center;" scope="col">
                        <strong>SL</strong>
                    </td>
                    <td style="text-align: center; width:100px; " scope="col">
                        <strong>Attendance Date</strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>Attandance Status</strong>
                    </td>
                    <td style="text-align: center; width:170px" scope="col">
                        <strong>Shift</strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>In Time</strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>Out Time</strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>Lunch In </strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>Lunch Out </strong>
                    </td>

                    <td style="text-align: center;width:55px" scope="col">
                        <strong>Late Time</strong>
                    </td>
                    <td style="text-align: center;" scope="col">
                        <strong>OT</strong>
                    </td>

                </tr>
                @php

                    $total_oth = 0;
                    $total_late_time = 0;
                    $att = 0;
                    $abs = 0;

                    $leave = 0;
                    $lwp = 0;
                    $OffDay = 0;
                    $holyDay = 0;
                @endphp

                @if (!empty($value))
                    @foreach ($value as $data)
                        @php

                            $ot = $data->over_time_min;
                            $total_oth += $ot;
                            $late_time = $data->late_time_min;
                            $total_late_time += $late_time;

                            if ($data->attendance_status == 1 || $data->attendance_status == 2) {
                                $att++;
                            }
                            if ($data->attendance_status == 3) {
                                $leave++;
                            }
                            if ($data->attendance_status == 4) {
                                $lwp++;
                            }
                            if ($data->attendance_status == 5) {
                                $abs++;
                            }
                            if ($data->attendance_status == 6) {
                                $OffDay++;
                            }
                            if ($data->attendance_status == 7) {
                                $holyDay++;
                            }

                        @endphp
                        <tr class="table-tr">
                            <td style="text-align: center;" scope="col">
                                <strong>{{ $loop->iteration }}</strong>
                            </td>
                            <td style="text-align: left;" scope="col">
                                <strong>{{ date('d/m/Y', strtotime($data->attendance_date)) }}</strong>
                            </td>
                            <td style="text-align: left;" scope="col">
                                <strong>{{ $data->attendance_status_text }}</strong>
                            </td>
                            <td style="text-align: left;" scope="col">
                                @if (isset($data->shift_code))
                                    {{ $data->shift_code }} (
                                    {{ isset($data->start_time) ? date('h:i a', strtotime($data->start_time)) : '' }}
                                    -
                                    {{ isset($data->end_time) ? date('h:i a', strtotime($data->end_time)) : '' }})
                                @endif



                            </td>
                            <td style="text-align: center;" scope="col">
                                <strong>{{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</strong>
                            </td>
                            <td style="text-align: center;" scope="col">
                                <strong>{{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</strong>

                            </td>


                            <td style="text-align: center;" scope="col">
                                <strong>
                                    {{ isset($data->lunch_in_time) ? date('h:i a', strtotime($data->lunch_in_time)) : '' }}</strong>

                            </td>
                            <td style="text-align: center;" scope="col">
                                <strong>
                                    {{ isset($data->lunch_out_time) ? date('h:i a', strtotime($data->lunch_out_time)) : '' }}</strong>

                            </td>
                            @php
                                $minutes = $data->late_time_min;
                                $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                            @endphp
                            <td style="text-align: center;" scope="col">
                                <strong>{{ $hours }} hour</strong>
                            </td>
                            <td style="text-align: center;" scope="col">
                                <strong>{{ $data->over_time_min }}</strong>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </table>

<br>
            @php
                $total_minutes_late = $total_late_time;
                $lMinutes = $total_minutes_late % 60;
                $lHours = ($total_minutes_late - $lMinutes) / 60;

                $total_minutes = $total_oth;
                $minutes = $total_minutes % 60;
                $hours = ($total_minutes - $minutes) / 60;

            @endphp
            <table style="margin-top: 5px;" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="80%">
                        <table cellpadding="1" cellspacing="0" border="1">
                            <tr>
                                <td style="padding:3px; "> <strong> TOTAL DAYS </strong></td>
                                <td style="padding:3px; text-align:center">{{ count($value) }}</td>
                                <td style="padding:3px; "> <strong>ATTEND </strong></td>
                                <td style="padding:3px; text-align:center">{{ $att }}</td>
                            </tr>
                            <tr>
                                <td style="padding:3px; "><strong> HOLIDAY </strong></td>
                                <td style="padding:3px; text-align:center">{{ $holyDay }}</td>
                                <td style="padding:3px; "> <strong> ABSENT </strong></td>
                                <td style="padding:3px; text-align:center">{{ $abs }}</td>
                            </tr>
                            <tr>
                                <td style="padding:3px; "> <strong> LWP </strong></td>
                                <td style="padding:3px; text-align:center"> {{ $lwp }}</td>
                                <td style="padding:3px; "> <strong> LEAVE </strong></td>
                                <td style="padding:3px; text-align:center">{{ $leave }}</td>
                            </tr>
                            <tr>
                                <td style="padding:3px; "> <strong> OFF DAY </strong> <br></td>
                                <td style="padding:3px; text-align:center"> {{ $OffDay }}</td>
                                <td style="padding:3px; "> <strong> TOTAL LATE TIME </strong></td>
                                <td style="padding:3px; text-align:center">{{ $lHours }} H {{ $lMinutes }}
                                    MIN</td>
                            </tr>
                            <tr>
                                <td style="padding:3px; "> <strong> TOTAL OT HOURS </strong></td>
                                <td style="padding:3px; " colspan="3">{{ $hours }} H {{ $minutes }} MIN
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table border="1" cellpadding="1" cellspacing="0" width="100%">
                            <tr>
                                <td><strong> P </strong> </td>
                                <td> Present</td>
                            </tr>
                            <tr>
                                <td><strong> Abs </strong></td>
                                <td> Absent</td>
                            </tr>
                            <tr>
                                <td><strong> L </strong> </td>
                                <td> Leave</td>
                            </tr>
                            <tr>
                                <td><strong> LWP </strong></td>
                                <td> Leave Without Pay</td>
                            </tr>
                            <tr>
                                <td><strong> WHD </strong></td>
                                <td> Weekly Holiday</td>
                            </tr>
                            <tr>
                                <td><strong> NHD </strong></td>
                                <td> National Holiday</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </div>
    </div>

</main>
