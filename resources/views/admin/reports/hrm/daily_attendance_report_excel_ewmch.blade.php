<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Attendance
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <span class="report-date"><strong> From Date: </strong> {{ $from_date }} </span>
            &nbsp;&nbsp;
            @if (!empty($card))
            <tr>

                <td><strong> Card No </strong></td>
                <td> : {{ $card }}</td>

            </tr>
        @endif
        @if (!empty($desig))
            <tr>
                <td><strong> Designation </strong></td>
                <td> : {{ $desig }}</td>
            </tr>
        @endif
        @if (!empty($dept))
            <tr>
                <td><strong> Department </strong></td>
                <td> : {{ $dept }}</td>
            </tr>
        @endif

        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>SL</strong>
                            </th>
                            <th class="text-left" style="text-align: center; width: 200px; " scope="col">
                                <strong>Employee </strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Department</strong>
                            </th>
                            <th class="text-left" style="text-align: center;  width: 120px;" scope="col">
                                <strong>Shift </strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>In Time </strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Out Time </strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Late Count</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Early Out</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Extra Duty Time</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Stay Hour</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Status</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Leave Status</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Remark</strong>
                            </th>
                        </tr>
                    </thead>

                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                        @if (isset($value))
                        @foreach ($value as $data)
                            <tr class="table-tr">
                                <td class="text-left" style="text-align: center;" scope="col">
                                    <strong>{{ $loop->iteration }}</strong>
                                </td>
                                <td class="text-left" scope="col" style="padding:5px; text-align:left">

                                    <div class="" style="padding-top: 5px">
                                        <div style="width: 99%;vertical-align:top ">

                                            @if ($data->photo_name != '')
                                                {{-- <img class="rounded"
                                                    src="{{ asset('images/uploads/doctor_images/thumb/') }}/{{ $data->photo_name }}"
                                                    width="50px" style="display: inline-block;"> --}}
                                                <div style="display: inline-block;">
                                                    {{ $data->full_name }}<br>
                                                    {{ $data->person_card_no }}<br>
                                                    {{ $data->designation_name }}
                                                </div>
                                            @else
                                                {{-- <img class="rounded" style="width: 50px;"
                                                    src="{{ asset('images/no-photo.png') }}"
                                                    style="display: inline-block;"> --}}

                                                <div style="display: inline-block;">
                                                    {{ $data->full_name }}<br>
                                                    {{ $data->person_card_no }}<br>
                                                    {{ $data->designation_name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->serviceunit_name != '' ? $data->serviceunit_name : '' }}</td>

                                <td class="text-left" scope="col">
                                    <div>
                                        {{ $data->shift_code }}<br>
                                        Duty In:
                                        {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}<br>

                                        Duty Out:
                                        {{ isset($data->duty_out_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}
                                    </div>

                                </td>

                                <td class="text-left" style="text-align: center; @if($data->entry_type == "2") color:red; @endif" scope="col">
                                    @if(!isset($data->in_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")
                                    -
                                    @else
                                        {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}
                                    @endif
                                </td>
                                <td class="text-left" style="text-align: center; @if($data->entry_type == "2") color:red; @endif" scope="col">
                                    @if(!isset($data->out_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")
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
                                <td class="text-left" style="text-align: center;" scope="col">
                                    @if($minutes % 60 == '0')
                                    @else
                                        {{ $hours }} hr
                                    @endif
                                </td>
                                <td class="text-left" style="text-align: center;" scope="col">
                                    @if($data->in_time == $data->out_time || !isset($data->out_time) || !isset($data->duty_out_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")

                                    @elseif (isset($data->out_time) && isset($data->duty_out_time))
                                        @php
                                            $to_time = strtotime($data->out_time);
                                            $from_time = strtotime($data->duty_out_time);
                                            $ot_min = ($to_time - $from_time) / 60;
                                            // $earlyMinutes = $data->early_time_min;
                                            $otHours = intdiv($ot_min, 60) . ':' . $ot_min % 60;
                                        @endphp
                                        @if($ot_min % 60 < 0 || intdiv($ot_min, 60) < 0)
                                        @php
                                            $ot_min = (abs($to_time - $from_time) / 60);
                                            $otHours = intdiv($ot_min, 60) . ':' . $ot_min % 60;
                                        @endphp
                                            {{ $otHours }} hr
                                        @else

                                        @endif
                                    @else

                                    @endif
                                </td>
                                <td class="text-left" style="text-align: center;" scope="col">
                                    @if($data->in_time == $data->out_time || !isset($data->out_time) || !isset($data->duty_out_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")

                                    @elseif (isset($data->out_time) && isset($data->duty_out_time))
                                        @php
                                            $to_time = strtotime($data->out_time);
                                            $from_time = strtotime($data->duty_out_time);
                                            $ot_min = ($to_time - $from_time) / 60;
                                            // $earlyMinutes = $data->early_time_min;
                                            $otHours = intdiv($ot_min, 60) . ':' . $ot_min % 60;
                                        @endphp
                                        @if($ot_min % 60 > 0 || intdiv($ot_min, 60) > 0)
                                            {{ $otHours }} hr
                                        @else

                                        @endif
                                    @else

                                    @endif
                                </td>
                                <td class="text-center" style="text-align: center;" scope="col">
                                    @if($data->in_time == $data->out_time || !isset($data->out_time) || !isset($data->in_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")

                                    @elseif (isset($data->out_time) && isset($data->in_time))
                                        @php
                                            $to_time = strtotime($data->out_time);
                                            $from_time = strtotime($data->in_time);
                                            $stay_min = round(abs($to_time - $from_time) / 60);
                                            // $earlyMinutes = $data->early_time_min;
                                            $stayHours = intdiv($stay_min, 60) . ':' . $stay_min % 60;
                                        @endphp
                                         @if($stay_min % 60 == '0')

                                         @else
                                             {{ $stayHours }} hr
                                         @endif
                                    @else

                                    @endif
                                </td>
                                <td class="text-center" style="text-align: center;" scope="col">
                                    @if($data->leave_entry_ind == 1)
                                    Leave
                                    @elseif($data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")
                                        Day Off
                                    @elseif(isset($data->in_time))
                                        Present
                                    @else
                                        Absent
                                    @endif
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    @if($data->leave_entry_ind == 1)
                                        {{$data->leave_reason ? $data->leave_reason : ""}}
                                    @else

                                    @endif
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col"></td>


                            </tr>
                        @endforeach
                    @endif
                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
    </div>
</main>

