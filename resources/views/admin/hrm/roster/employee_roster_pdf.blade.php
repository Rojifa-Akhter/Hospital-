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
            <span class="report-name" style="width:70%; border:solid black 1px; font-size: 15px;">Employee Roster </span>
        </div>
        <div style=" text-align:center; margin-bottom:5px;" class="mb-2">
            <span class="report-date"><strong> From Date: </strong> {{ $from_date ? $from_date :""}} </span>
            <span class="report-date"><strong> To Date: </strong> {{ $to_date ? $to_date : "" }} </span>
        </div>
        @if (isset($emp_info->person_code))
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
            <table>
                @if (isset($emp_info))
                <tr>
                    <td colspan="2">
                        <span class="report-date"><strong> Name:
                            </strong>{{ $emp_info->full_name ? $emp_info->full_name : '' }}</span>
                        <span class="report-date"><strong> Card No.: </strong>
                            {{ $emp_info->person_code ? $emp_info->person_code : '' }}</span>
                        <span class="report-date"><strong> Department: </strong>
                            {{ $emp_info->su_name ? $emp_info->su_name : '' }}</span>
                    </td>
                </tr>
                @endif
            </table>


        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th class="text-left" style="text-align: center;" scope="col"><strong>Date</strong></th>
                            <th class="text-left" style="text-align: center;" scope="col"><strong>Duty Area</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col"><strong>Shift</strong></th>
                            <th class="text-left" style="text-align: center;" scope="col"><strong>Start Time</strong>
                            </th>
                            <th class="text-left" style="text-align: center;" scope="col"><strong>End Time</strong>
                            </th>
                        </tr>
                    </thead>

                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                    @if (isset($value))
                        @foreach ($value as $value)
                            <tr class="table-tr">
                                <td class="text-left" style="text-align: center;" scope="col">
                                    {{ date('d-m-Y', strtotime($value->roster_date)) }}<br>
                                    {{ date('D', strtotime($value->roster_date)) }} </strong></td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $value->lookupdata_name }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $value->shift_code }}
                                </td>
                                @if (isset($value->duty_area_su_no_fk) && !empty($value->duty_area_su_no_fk))
                                    <td class="text-left" style="text-align: center;" scope="col">
                                        {{ date('h:i a', strtotime($value->duty_start_time)) }}</td>
                                    <td class="text-left" style="text-align: center;" scope="col">
                                        {{ date('h:i a', strtotime($value->duty_end_time)) }}</td>
                                @else
                                    <td class="text-left" style="text-align: center;" scope="col"></td>
                                    <td class="text-left" style="text-align: center;" scope="col"></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    {{-- </tbody> --}}


                </table>
            </div>
        </section>
        @endif
    </div>
</main>
</body>

</html>
