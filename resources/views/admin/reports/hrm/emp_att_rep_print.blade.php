@include('admin.components.pdf_header')
<main>

    <div class="wrapper" style="margin-bottom: 2px;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:5px  ">
            <span class="report-name" style="width:70%; border:solid gary 1px;font-size:20px  ">
                <strong>Employee Attendance Report</strong></span>
            <br>
            @php
                $month = date('d/m/Y', strtotime($from_date));
            @endphp
            <strong> Date : </strong><span>{{ $from_date ? $from_date : '' }} to {{ $ta_date ? $ta_date : '' }}</span>

        </div>

        <div class="infos">
            @if (!empty($details))
                <table style="width:100%;border: 1px solid gray;margin-bottom: 20px;">
                    <tr>
                        <td><strong> Name </strong></td>
                        <!-- @php
                            $photo = $details->photo_name ? $details->photo_name : '';
                        @endphp -->

                        <td> : {{ $details->salutation ? $details->salutation : '' }}
                            {{ $details->full_name ? $details->full_name : '' }}</td>

                        <td><strong> Department </strong></td>
                        <td> : {{ $details->department ? $details->department : '' }}</td>
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
                    <td style="text-align: center; width:100px; " scope="col"><strong>Log Date</strong>
                    <td style="text-align: center; width:100px; " scope="col"><strong>Shift Time</strong>
                    <td style="text-align: center; width:100px; " scope="col"><strong>In Time</strong>
                    <td style="text-align: center; width:100px; " scope="col"><strong>Out Time</strong>
                    <td style="text-align: center; width:100px; " scope="col"><strong>Status</strong>
                    <td style="text-align: center; width:100px; " scope="col"><strong>Work Time</strong>
                    </td>

                </tr>

                @if (!empty($value))
                    @foreach ($value as $data)
                        <tr class="table-tr">
                            <td style="text-align: left;" scope="col"> {{ date('l jS  F Y ', strtotime($data->attendance_date)) }}</td>
                            <td style="text-align: center;" scope="col">
                                @if (isset($data->shift_code))
                                {{ $data->shift_code }}
                                ({{ isset($data->start_time) ? date('h:i a', strtotime($data->start_time)) : '' }}
                                -{{ isset($data->end_time) ? date('h:i a', strtotime($data->end_time)) : '' }})
                            @endif
                        </td>
                            <td style="text-align: center;" scope="col"> {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td></td>
                            <td style="text-align: center;" scope="col">{{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>
                            @php
                            $inTime = strtotime($data->in_time);
                            $outTime = strtotime($data->out_time);
                            $diff = $outTime - $inTime;

                            $hours = floor($diff / 3600);
                            $minutes = floor(($diff / 60) % 60);
                            $seconds = $diff % 60;

                        @endphp
                            <td style="text-align: center;" scope="col">{{ $diff>0 ? "Normal" : "Non Working"}}</td>
                            <td style="text-align: center;" scope="col">{{ $hours }}:{{ $minutes }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>

</main>



@include('admin.components.pdf_footer')
