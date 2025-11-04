<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
// ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
->first();
?>
@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daily Attendance Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong></span>
                                <br>
                                Address:
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                Phone No:
                                <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Daily Attendance Report</strong> </div>
                    <div style="text-align: center;">
                        <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Day</th>
                <th style="text-align: center">Shift</th>
                <th style="text-align: center">Start Time</th>
                <th style="text-align: center">End Time</th>
                <th style="text-align: center">In Time</th>
                <th style="text-align: center">Out Time</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Working Hours</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @if (!empty($value))
            @foreach ($value as $employeeData)
            @php
                $employeeInfo = reset($employeeData);
            @endphp
            <tr class="tr_border">
                <th style="border: none" colspan="3">Employee Card No: {{ $employeeInfo->person_card_no }}</th>
                <th style="border: none" colspan="2">Name: {{ $employeeInfo->full_name }}</th>
                <th style="border: none" colspan="">Department: {{ $employeeInfo->serviceunit_name }}</th>
                <th style="border: none" colspan="3">Designation: {{ $employeeInfo->designation_name }}</th>
            </tr>
            {{-- <tr class="tr_border">
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Day</th>
                <th style="text-align: center">Shift</th>
                <th style="text-align: center">Start Time</th>
                <th style="text-align: center">End Time</th>
                <th style="text-align: center">In Time</th>
                <th style="text-align: center">Out Time</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Working Hours</th>
            </tr> --}}
            @php
                $totalHours=0;
                $totalMinutes=0;
            @endphp
            @foreach ($employeeData as $data)
                <tr class="tr_border">
                    <td style="text-align: center">{{ date('d/m/Y', strtotime($data->attendance_date)) }}</td>
                    @php
                    $dateString = $data->attendance_date;
                    $timestamp = strtotime($dateString);
                    $dayName = date("l", $timestamp);
                    @endphp
                    <td style="text-align: center">{{ $dayName }}</td>
                    <td style="text-align: center">{{ $data->shift_code }}</td>
                    <td style="text-align: center">{{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}</td>
                    <td style="text-align: center">{{ isset($data->duty_out_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}</td>
                    <td class="text-left" style="text-align: center; @if($data->entry_type == "2") color:red; @endif" scope="col">
                        @if(!isset($data->in_time) || $data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")
                        -
                        @else
                            {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}
                        @endif
                    </td>
                    <td class="text-left" style="text-align: center; @if($data->entry_type == "2") color:red; @endif" scope="col">
                        @if (isset($data->in_time) && !isset($data->out_time))
                            No Out Time
                        @elseif (!isset($data->in_time) && !isset($data->out_time))
                            -
                        @elseif($data->leave_entry_ind == 1 || $data->shift_code == "OFFDAY" || $data->shift_code == "DAYOFF")
                            -
                        @elseif ($data->in_time == $data->out_time)
                            No Out Time
                        @else
                            {{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}
                        @endif
                    </td>
                    <td class="text-center tr_border" style="text-align: center;" scope="col">
                        @if($data->leave_entry_ind == 1)
                            Leave
                        @elseif($data->attendance_status == "7")
                            National Holiday
                        @elseif($data->attendance_status == "6")
                            Day Off
                        @elseif(isset($data->in_time) && isset($data->out_time))
                            Present
                        @elseif(isset($data->in_time) && !isset($data->out_time))
                            Out Less
                        @else
                            <b style="color: red">Absent</b>
                        @endif
                    </td>

                    @if (!empty($data->in_time) && !empty($data->out_time))
                        @php
                        $in_time = $data->in_time;
                        $out_time = $data->out_time;
                        $dateTime1 = Carbon::parse($in_time);
                        $dateTime2 = Carbon::parse($out_time);
                        $diff = $dateTime1->diff($dateTime2);
                        $hours = $diff->h; // Hours
                        $minutes = $diff->i; // Minutes
                        $total_time =$hours.':'.$minutes;


                        $totalHours += $hours;
                        $totalMinutes += $minutes;
                        // $totalHours += $total_hours;
                        // $totalMinutes += $total_minutes;
                        @endphp
                    @else
                        @php
                        $total_time = "0";
                        @endphp
                    @endif
                    <td style="text-align: center">{{ $total_time }}</td>

                </tr>
            @endforeach

            @php
              if ($totalMinutes >= 60) {
                $totalHours += floor($totalMinutes / 60);
                $totalMinutes = $totalMinutes % 60;

            }
            @endphp
            <tr class="tr_border">
                <td style="text-align: right;" colspan="8"><b>Total Hours</b></td>
                <td style="text-align: center;"><b>{{ $totalHours.':'.$totalMinutes }}</b></td>
            </tr>
        @endforeach
        @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
