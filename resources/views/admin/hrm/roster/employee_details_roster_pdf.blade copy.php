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
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px ; " class="">
            <span class="report-name" style="width:70%; border:solid black 1px; font-size: 15px;">Duty Roster
            </span>
        </div>
        <div style=" text-align:center; margin-bottom:5px;" class="mb-2">
            <span class="report-date"><strong> For the month of {{$monthYear}} </strong> </span><br>
            <span class="report-date"><strong> Department: </strong>
                {{ $emp_info->su_name ? $emp_info->su_name : '' }}</span>

            {{-- <span class="report-date"><strong> To Date: </strong> {{ $to_date ? $to_date : '' }} </span> --}}
        </div>
        @if (isset($emp_info->person_code))
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <table>
                    @if (isset($emp_info))
                        <tr>
                            <td colspan="2">


                            </td>
                        </tr>
                    @endif
                </table>


            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%; border-collapse:collapse;font-size:8px !important" cellpadding="1"
                        cellspacing="0" border="1" style="font-size: 9px!important;">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center" style="width: 5px!important">Sl</th>
                                <th class="text-center" style="width: 50px!important;word-wrap: break-word!important;">
                                    Emp.Name</th>
                                @php
                                    if (isset($from_date)) {
                                        $start_date = new DateTime($from_date);
                                        $end_date = new DateTime($to_date);

                                        for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                            echo " <th class='text-center'  style='width: 5px!important'> " . $start_date->format('d') . '</th>';
                                            // echo $from_date->format('d') . "\n" . $from_date->format('l') . '<br>';
                                        }
                                    }
                                @endphp
                            </tr>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center" style="width: 50px!important"></th>
                                @php
                                    if (isset($from_date)) {
                                        $start_date = new DateTime($from_date);
                                        $end_date = new DateTime($to_date);
                                        for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                                            echo " <th class='text-center' style='width: 5px!important' >" . $start_date->format('D') . ' </th>';
                                            // echo $from_date->format('d') . "\n" . $from_date->format('l') . '<br>';
                                        }
                                    }
                                @endphp
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x = 1;
                            @endphp
                            @foreach ($hod_emp as $key => $data)
                                @if (isset($emp_info_arr[$data->person_no_pk]))
                                    <tr>
                                        <td class="text-center" style='width: 5px!important'>{{ $x++ }}</td>
                                        <td style="width: 50px;word-wrap: break-word!important;" class="text-left">
                                            {{ $data->full_name }}({{ $data->person_code }})
                                            <input type="hidden" value="{{ $data->person_no_pk }}" name="user_arr[]">
                                        </td>

                                        @php
                                            if (isset($from_date)) {
                                                $start_date = new DateTime($from_date);
                                                $end_date = new DateTime($to_date);
                                            }
                                        @endphp
                                        @if (isset($from_date))
                                            @for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day'))
                                                <td class="text-center" style="width: 3px!important;text-align:center">
                                                    @if (isset($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']))
                                                        @if (strtoupper($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']) == 'OFFDAY')
                                                            {{ substr($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift'], 0, 2) }}

                                                            @elseif (strtoupper($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']) == 'EID HOLIDAY')
                                                            {{ 'EID' }}
                                                        @elseif (in_array(strtoupper($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']), [
                                                                'CASUAL LEAVE',
                                                                'MATERNITY LEAVE',
                                                                'SICK LEAVE',
                                                                'LEAVE WITHOUT PAY',
                                                                'EID HOLIDAY',
                                                                'EARN LEAVE',
                                                                'GOVT HOLIDAY',
                                                            ]))
                                                            @php
                                                                $words = explode(' ', $roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']);
                                                                $acronym = '';

                                                                foreach ($words as $w) {
                                                                    $acronym .= mb_substr($w, 0, 1);
                                                                }
                                                                echo $acronym;
                                                            @endphp
                                                        @else
                                                            {{ $roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['shift']." (".date('h:i a', strtotime($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['duty_start_time']))."-".date('h:i a', strtotime($roster_arr[$start_date->format('Y-m-d')][$data->person_no_pk]['duty_end_time'])).")"}}
                                                        @endif
                                                    @endif
                                                </td>
                                            @endfor
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    <table style="width: 20%; padding:3px; margin: 0">
                        @foreach ($shift_arr as $key => $shift)
                            @if ($key != null)
                                @if (strtoupper($shift) != 'OFFDAY')
                                    <tr>
                                        <td style="font-size: 9px; text-align:left;width:5px!important">


                                            {{ substr($shift, 0, 1) }}:


                                        </td>
                                        <td style="font-size: 9px; ">{{ $shift }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>

                </div>
            </section>
        @endif
    </div>
</main>
</body>

</html>
