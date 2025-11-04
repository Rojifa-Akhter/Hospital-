<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }

    tr th,
    tr td {
        /* white-space: nowrap; */
    }
</style>
@if (Session::get('user.ses_hospital_code') == 'EWMCH')
    @include('admin.components.pdf_header_roaster_ewmch')
@else
    @include('admin.components.pdf_header_roaster')
@endif
<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Prepared By
                </span>
            </td>
            <td style="text-align:center; ">
                <span style="padding:5px; border-top: black solid 1px;"> Department Head</span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> HR Department</span>
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
    <div class="" style=" margin-top:15px;">
        <section id="lp-items">
            <div class="container">
                {{-- counting array  --}}
                @php
                    if (isset($from_date)) {
                        $start_date = new DateTime($from_date);
                        $end_date = new DateTime($to_date);
                        $datesArray = []; 
                        for (
                            $current_date = clone $start_date;
                            $current_date <= $end_date;
                            $current_date->modify('+1 day')
                        ) {
                            $datesArray[] = $current_date->format('Y-m-d'); 
                        }
                        $totalDates = count($datesArray);
                    }

                @endphp



                <table style="width: 100%;border-collapse:collapse;font-size:8px" cellpadding="1" cellspacing="0"
                    border="1" style="font-size: 9px;">
                    <thead>
                        <tr>
                            <td colspan="<?php echo ($totalDates + 8)  ?>">
                                <div style=" text-align:center;" class="">
                                    <span class="report-name" style="width:70%; font-size: 15px;">
                                        <strong>
                                            Duty Roster {{isset($serviceunit_no_fk_dept_name) ? 'of Department '. $serviceunit_no_fk_dept_name : ''}} for the
                                            Month {{ $monthYear }}
                                        </strong>

                                    </span>
                                </div>
                                <header>
                                    <table style="width: 100%;" class="signature">
                                        <tr>
                                            <td
                                                style="width:100%; font-weight:bold; border:1px solid; box-sizing: border-box; font-size:8px !important;">
                                                <table style="width:100%;">
                                                    @if ($shiftGroupedData)
                                                        @foreach ($shiftGroupedData as $key => $item)
                                                            <tr style="white-space: nowrap !important;">
                                                                @foreach ($item as $data)
                                                                    <td style=""
                                                                        style="white-space: nowrap !important;">
                                                                        {{ $data->shift_code }} =
                                                                        {{ $data->shift_desc }}</td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </header>
                            </td>
                        </tr>

                        <tr>
                            <th style="text-align:center" colspan="5"></th>
                            @php
                                if (isset($from_date)) {
                                    $start_date = new DateTime($from_date);
                                    $end_date = new DateTime($to_date);

                                    for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                        $start_date = \Carbon\Carbon::instance($start_date);
                                        $currentDate = $start_date->toDateString();
                                        $holidayData = collect($holidayData);
                                        $isHoliday = $holidayData->contains(function ($holiday) use ($currentDate) {
                                            return \Carbon\Carbon::parse($holiday->holiday_date)->toDateString() ===
                                                $currentDate;
                                        });
                                        echo "<th class='text-center' style='" .
                                            ($isHoliday ? 'color:red; font-weight: bold;' : '') .
                                            "'>" .
                                            $start_date->format('d') .
                                            '</th>';
                                    }
                                }
                            @endphp
                            <th style="width:4px; text-align:center" rowspan="2">Total <br>Duty</th>
                            <th style="width:4px; text-align:center" rowspan="2">Total <br>Hour</th>
                            <th style="width: 8px; text-align:center" rowspan="2">Total <br>DayOff</th>
                        </tr>
                        <tr>
                            <th style="width:2px; text-align:center">Sl</th>
                            <th style="width: 15px; text-align:center">EID</th>
                            <th style="width: 35px; text-align:left">Name</th>
                            <th style="width: 10px; text-align:left">Department <br>& Unit</th>
                            <th style="width: 10px; text-align:left;">Designation</th>
                            @php
                                if (isset($from_date)) {
                                    $start_date = new DateTime($from_date);
                                    $end_date = new DateTime($to_date);
                                    for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                        echo " <th style='width:2px; '>" . $start_date->format('D') . '</th>';
                                        // echo $from_date->format('d') . "\n" . $from_date->format('l') . '<br>';
                                    }
                                }
                            @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hod_emp as $key => $data)
                            @if (isset($emp_info_arr[$data->person_no_pk]))
                                @php
                                    $total_duty_hour = 0;
                                    $duty_count = 0;
                                    $day_off_count = 0;
                                @endphp
                                <tr>
                                    <td style="text-align:center">{{ $key + 1 }}</td>
                                    <td style="width: 10px; text-align:center">
                                        {{ $data->person_code }}</td>
                                    <td style="width: 10px ; text-align:left">
                                        {{ $data->full_name }}
                                        <input type="hidden" value="{{ $data->person_no_pk }}" name="user_arr[]">
                                    </td>
                                    <td style="width: 10px; text-align:left">
                                        {{ $data->serviceunit_no_fk_dept_name }}<br> & {{$data->su_name}}</td>
                                    <td style="width: 4px !important; text-align:left; ">
                                        {{ $data->designation }}</td>
                                    @php
                                        if (isset($from_date)) {
                                            $start_date = new DateTime($from_date);
                                            $end_date = new DateTime($to_date);
                                        }
                                    @endphp
                                    @if (isset($from_date))
                                        @for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day'))
                                            <td style="width: 2px; text-align:center; ">
                                                @foreach ($shift as $d)
                                                    @if (isset($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']))
                                                        @if ($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift'] == $d->shift_no_pk)
                                                            @php
                                                                $total_duty_hour =
                                                                    $total_duty_hour +
                                                                    $roster_arr[$start_date->format('Y-m-d')][
                                                                        $data->person_no_pk
                                                                    ]['shift_hour'];
                                                                if (
                                                                    $roster_arr[$start_date->format('Y-m-d')][
                                                                        $data->person_no_pk
                                                                    ]['shift_hour'] != '0'
                                                                ) {
                                                                    $duty_count = $duty_count + 1;
                                                                }
                                                                if (
                                                                    $roster_arr[$start_date->format('Y-m-d')][
                                                                        $data->person_no_pk
                                                                    ]['shift_hour'] == '0'
                                                                ) {
                                                                    $day_off_count = $day_off_count + 1;
                                                                }
                                                                $shift_code = $d->shift_code;
                                                                if (strpos($shift_code, '(') !== false) {
                                                                    $position = strpos($shift_code, '(');
                                                                    $short_name = substr($shift_code, 0, $position);
                                                                } else {
                                                                    $short_name = $d->shift_code;
                                                                }
                                                            @endphp
                                                            {{isset($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['leave_code']) ? $roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['leave_code'] : $short_name }}
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </td>
                                        @endfor
                                    @endif
                                    <td style="text-align:center">
                                        {{ $duty_count }}
                                    </td>
                                    <td style="text-align:center">
                                        {{ $total_duty_hour }}
                                    </td>
                                    <td style="text-align:center">
                                        {{ $day_off_count }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
</body>
</html>
