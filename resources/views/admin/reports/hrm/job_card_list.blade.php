<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div class="card-header"> Job Card </div>
<div class="card-body">
    @if (!empty($details))
        <div class="form-row align-item-center">
            <div class=" col-md-8">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong> Name </strong></td>
                            @php
                                $photo = $details->photo_name ? $details->photo_name : '';
                            @endphp

                            <td> : {{ $details->salutation ? $details->salutation : '' }}
                                {{ $details->full_name ? $details->full_name : '' }}</td>

                            <td><strong> Designation </strong></td>
                            <td> : {{ $details->specialization_name ? $details->specialization_name : '' }}</td>
                        </tr>

                        <tr>
                            <td><strong> Card No </strong></td>
                            <td> : {{ $details->person_card_no ? $details->person_card_no : '' }}</td>

                            <td><strong> Department </strong></td>
                            <td> : {{ $details->department ? $details->department : '' }}</td>

                        </tr>
                        <tr>
                            <td><strong> Phone No </strong></td>
                            <td> : {{ $details->phone_mobile ? $details->phone_mobile : '' }}</td>


                            <td><strong> Joining Date </strong></td>
                            <td> : {{ $details->join_date ? date('d/m/Y', strtotime($details->join_date)) : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong> Grade <span class="dashicons dashicons-nametag"></span> </strong></td>
                            <td> : {{ $details->grade_name ? $details->grade_name : '' }}</td>


                            <td><strong> Roster Type </strong></td>
                            <td> : {{ $details->duty_roster_type ? $details->duty_roster_type : '' }}</td>
                        </tr>

                        <tr>
                            <td><strong> Month : </strong>
                                {{ date('F', strtotime($from_date)) }},
                            </td>
                            <td><strong> &nbsp; Year : </strong> {{ date('Y', strtotime($from_date)) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4 text-right">
                <img src="../../public/images/uploads/doctor_images/thumb/{{ $details->photo_name }}" width="80px"
                    alt="">
            </div>
        </div>
    @endif
    <div class="form-row ">
        <div class="col-md-12 table-responsive">
            <table class="table data-table table-bordered ">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <td class="text-center" scope="col">#SL</td>
                        <td class="text-left" scope="col">Card No.</td>
                        <td class="text-left" scope="col">Attendance Date</td>
                        <td class="text-left" scope="col"> Attandance Status </td>
                        <td class="text-left" scope="col">Shift</td>
                        <!-- <td class="text-left" scope="col"> Name</td>
         <td class="text-left" scope="col">Designation</td> -->
                        <td class="text-left" scope="col">In Time</td>
                        <td class="text-left" scope="col">Out Time</td>
                        <td class="text-left" scope="col"> <strong>Lunch In </strong></td>
                        <td class="text-left" scope="col"><strong>Lunch Out </strong></td>
                        <td class="text-left" scope="col">Late Time</td>
                        <td class="text-left" scope="col">OT </td>

                    </tr>
                </thead>
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

                @if (isset($value))
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
                        <tr>
                            <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                            <td class="text-left" scope="col">{{ $data->person_card_no }}</td>
                            <td class="text-left" scope="col">
                                {{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
                            <td class="text-left" scope="col"> {{ $data->attendance_status_text }}</td>
                            <td class="text-left" scope="col">
                                @if (isset($data->shift_code))
                                    {{ $data->shift_code }}
                                    ({{ isset($data->start_time) ? date('h:i a', strtotime($data->start_time)) : '' }}
                                    - {{ isset($data->end_time) ? date('h:i a', strtotime($data->end_time)) : '' }})
                                @endif
                            </td>

                            <td class="text-left" scope="col">
                                {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                            <td class="text-left" scope="col">
                                {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>
                            <td class="text-left" scope="col">
                                {{ isset($data->lunch_in_time) ? date('h:i a', strtotime($data->lunch_in_time)) : '' }}
                            </td>
                            <td class="text-left" scope="col">
                                {{ isset($data->lunch_out_time) ? date('h:i a', strtotime($data->lunch_out_time)) : '' }}
                            </td>
                            @php
                                $minutes = $data->late_time_min;
                                $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                            @endphp
                            <td class="table-td" style="text-align: center;" scope="col">
                                {{ $hours }} hour</td>
                            <td class="text-left" scope="col">{{ $data->over_time_min }}</td>

                        </tr>
                    @endforeach
                @endif

            </table>
            <div class="form-row mt-4 ">
                <div class="col-md-10">
                    <table border="1">

                        <tr>
                            <td class="p-2"> <strong>TOTAL NUMBER OF DAYS </strong></td>
                            <td class="p-2"> {{ count($value) }} </td>
                        </tr>
                        <tr>
                            <td class="p-2"> <strong>TOTAL NUMBER OF DAYS WORKED </strong></td>
                            <td class="p-2">

                                {{ $att }}

                            </td>
                        </tr>
                        <tr>
                            <td class="p-2"> <strong> TOTAL NUMBER OF HOLIDAY </strong></td>
                            <td class="p-2"> {{ $holyDay }}</td>
                        </tr>
                        <tr>
                            <td class="p-2"> <strong> TOTAL NUMBER OF ABSENT </strong></td>
                            <td class="p-2"> {{ $abs }}
                            </td>
                        </tr>


                        <tr>
                            <td class="p-2"> <strong> TOTAL NUMBER OF LEAVE</strong></td>
                            <td class="p-2"> {{ $leave }}</td>
                        </tr>
                        <tr>
                            <td class="p-2"> <strong>TOTAL NUMBER OF LWP</strong></td>
                            <td class="p-2">{{ $lwp }} </td>
                        </tr>
                        <tr>
                            <td class="p-2"> <strong> TOTAL NO OF DAY OFF </strong></td>
                            <td class="p-2"> {{ $OffDay }} </td>
                        </tr>
                        <tr>
                            @php
                                $total_minutes = $total_late_time;
                                $lMinutes = $total_minutes % 60;
                                $lHours = ($total_minutes - $lMinutes) / 60;

                            @endphp
                            <td class="p-2"> <strong> TOTAL LATE TIME </strong></td>
                            <td class="p-2"> {{ $lHours }} H {{ $lMinutes }} MIN
                            </td>
                        </tr>
                        <tr>
                            @php
                                $total_minutes = $total_oth;
                                $minutes = $total_minutes % 60;
                                $hours = ($total_minutes - $minutes) / 60;

                            @endphp
                            <td class="p-2"> <strong> TOTAL OT HOURS </strong></td>
                            <td class="p-2"> {{ $hours }} H {{ $minutes }} MIN</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2 ">
                    <table border="1">
                        <tr>
                            <td class="p-2"><strong> P </strong> </td>
                            <td class="p-2"> Present</td>
                        </tr>
                        <tr>
                            <td class="p-2"><strong> Abs </strong></td>
                            <td class="p-2"> Absent</td>
                        </tr>
                        <tr>
                            <td class="p-2"><strong> L </strong> </td>
                            <td class="p-2"> Leave</td>
                        </tr>
                        <tr>
                            <td class="p-2"><strong> LWP </strong></td>
                            <td class="p-2"> Leave Without Pay</td>
                        </tr>
                        <tr>
                            <td class="p-2"><strong> WHD </strong></td>
                            <td class="p-2"> Weekly Holiday</td>
                        </tr>
                        <tr>
                            <td class="p-2"><strong> NHD </strong></td>
                            <td class="p-2"> National Holiday</td>
                        </tr>
                    </table>
                </div>



            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    // $('.data-table').DataTable({
    // 	"lengthMenu": [
    // 		[50],
    // 		[50]
    // 	]
    // });
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        // "scrollY": "150px",
        "scrollCollapse": true,
        "paging": false,
        "searching": true,
        "ordering": false,
        "info": false
    });
</script>
