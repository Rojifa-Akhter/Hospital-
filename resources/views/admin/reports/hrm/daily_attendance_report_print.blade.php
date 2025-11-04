<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }

</style>
@include('admin.components.pdf_header')
<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td>
        </tr>
    </table>
</div>

<footer style="position: fixed;">
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y H:m:s');
                            @endphp
                            {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Attendance
                Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">




            <table>
                <tr>
                    <td colspan="2">
                        <span class="report-date"><strong> From Date: </strong> {{ $from_date }} </span>
                        <span class="report-date"><strong> To Date: </strong> {{ $to_date }} </span>
                    </td>
                </tr>
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
                @if (!empty($att_status_con))

                    <tr>
                        <td><strong> Attendance Status </strong></td>
                        @if ($att_status_con == 0)
                            <td> : Abnormal/Single </td>
                        @elseif($att_status_con == 1)
                            <td> : Attend </td>
                        @elseif($att_status_con == 2)
                            <td> : Late </td>
                        @elseif($att_status_con == 3)
                            <td> : Leave </td>
                        @elseif($att_status_con == 4)
                            <td> : Leave without pay </td>
                        @elseif($att_status_con == 5)
                            <td> : Absent </td>
                        @elseif($att_status_con == 6)
                            <td> : Weekly day off </td>
                        @elseif($att_status_con == 7)
                            <td> : Natinal Holiday </td>
                        @endif
                    </tr>
                @endif
            </table>


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
                                <strong>Date</strong>
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
                                <strong>OT</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Late</strong>
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
                                                <img class="rounded"
                                                    src="{{ asset('images/uploads/doctor_images/thumb/') }}/{{ $data->photo_name }}"
                                                    width="50px" style="display: inline-block;">
                                                <div style="display: inline-block;">
                                                    {{ $data->full_name }}<br>
                                                    {{ $data->person_card_no }}<br>
                                                    {{ $data->designation_name }}
                                                </div>
                                            @else
                                                <img class="rounded" style="width: 50px;"
                                                    src="{{ asset('images/no-photo.png') }}"
                                                    style="display: inline-block;">

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
                                    {{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
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
                                    {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                                <td class="text-left @if($data->entry_type == "2") text-danger @endif" style="text-align: center; @if($data->entry_type == "2") color:red; @endif" scope="col">
                                    {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>
                                <td class="text-left" style="text-align: center;" scope="col">
                                    {{ $data->over_time_min }}
                                </td>
                                @php
                                    $minutes = $data->late_time_min;
                                    $hours = intdiv($minutes, 60) . ':' . $minutes % 60;
                                @endphp
                                <td class="text-left" style="text-align: center;" scope="col">
                                    {{ $hours }} hour</td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->attendance_status_text }}</td>

                            </tr>
                        @endforeach
                    @endif
                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>
