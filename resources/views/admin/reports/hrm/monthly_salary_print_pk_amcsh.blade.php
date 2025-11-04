@include('admin.components.pdf_header_jk')
<div style="width: 100%;">
    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Monthly Salary
            Report</span>
    </div>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


        <span class="report-date"><strong> Year: </strong> {{ $year }} </br> <strong> Month: </strong>
            @php
                if ($month == '01') {
                    echo 'January';
                } elseif ($month == '02') {
                    echo 'February';
                } elseif ($month == '03') {
                    echo 'March';
                } elseif ($month == '04') {
                    echo 'April';
                } elseif ($month == '05') {
                    echo 'May';
                } elseif ($month == '06') {
                    echo 'June';
                } elseif ($month == '07') {
                    echo 'July';
                } elseif ($month == '08') {
                    echo 'August';
                } elseif ($month == '09') {
                    echo 'September';
                } elseif ($month == '10') {
                    echo 'October';
                } elseif ($month == '11') {
                    echo 'November';
                } elseif ($month == '12') {
                    echo 'December';
                }
            @endphp

        </span>
    </div>
</div>
<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> PREPARED BY
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> MANAGER (A/C)
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> DGM
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> CMO
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> GM
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> DMD
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> CHAIRMAN </span>
            </td>
        </tr>
    </table>
</div>

<footer>
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

        <section id="lp-items">
            <div class="container">
                <table style="width:100%;border-collapse:collapse;border-right: 1px solid #333;" cellpadding="1" cellspacing="0" border="1">
                    <thead style="">
                        <tr class="table-tr" style="background-color: #E3E3E3; ">
                            <th class=" table-td"><strong>SL#</strong></th>
                            <th class=" table-td"><strong>Card No</strong></th>
                            <th class=" table-td"><strong>Name</strong></th>
                            <th class="table-td"><strong>Designation</strong></th>
                            <th class=" table-td"><strong>Joining Date</strong></th>
                            <th class=" table-td"><strong>Gross Salary</strong></th>
                            <th class=" table-td"><strong>Avg. Duty Hr</strong></th>
                            <th class=" table-td"><strong>Total Day of Month</strong></th>
                            <th class=" table-td"><strong>Weekends</strong></th>
                            <th class=" table-td"><strong>Present</strong></th>
                            <th class=" table-td"><strong>Absent</strong></th>
                            <th class=" table-td"><strong>Absent Cut.</strong></th>
                            <th class=" table-td"><strong>Payable Days</strong></th>
                            <th class=" table-td"><strong>Leave</strong></th>
                            <th class=" table-td"><strong>Salary Payable</strong></th>
                            <th class=" table-td"><strong>Overtime Hr</strong></th>
                            <th class=" table-td"><strong>Overtime Pay</strong></th>
                            <th class=" table-td"><strong>Total Payable Amt.</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_salary_pay = 0;
                        $total_overtime_hr = 0;
                        $total_overtime_pay = 0;
                        $total_payable = 0;
                        ?>
                        @if (isset($monthlySalaryReportprint))
                            @foreach ($monthlySalaryReportprint as $data)
                                @php
                                    $desig = $data->designation_name;
                                @endphp
                                <tr class="table-tr">
                                    <td class="text-center table-td" style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td class="text-left table-td" style="text-align: left;">{{ $data->card_no }}</td>
                                    <td class="text-left table-td" style="text-align: left;">{{ $data->full_name }}</td>
                                    <td class="text-left table-td" style="text-align: left;">{{ $desig ? "$desig" : '' }}</td>
                                    <td class="text-left table-td" style="text-align: left;">{{date('d-m-Y', strtotime($data->join_date))}}</td>
                                    {{-- <td class="text-left">{{$data->join_date ? date('d-m-Y', strtotime($data->join_date)) : ""}}</td> --}}
                                    <!-- <td class="text-center">00</td>
                                <td class="text-center">00</td> -->

                                    <td class="text-right table-td" style="text-align: right;">{{ number_format($data->gross_salary, 2) }}</td>
                                    <td class="text-right table-td" style="text-align: right;"></td>
                                    <td class="text-right table-td" style="text-align: right;">{{$totalDaysInMonth ? $totalDaysInMonth : ""}}</td>
                                    <td class="text-right table-td" style="text-align: right;">{{$weekendCount ? $weekendCount : ""}}</td>
                                    <td class="text-right table-td" style="text-align: right;">{{$totalDaysInMonth - $data->absent_days - $data->leave_days}}</td>
                                    <?php
                                        $presentdays = $totalDaysInMonth + $weekendCount - $data->absent_days - $data->leave_days;
                                    ?>
                                    <td class="text-right table-td" style="text-align: right;">{{ number_format($data->absent_days) }}</td>
                                    <td class="text-right table-td" style="text-align: right;">{{ number_format($data->incometax_deduct_amount) }} </td>
                                    <td class="text-right table-td" style="text-align: right;">{{$presentdays}}</td>
                                    <td class="text-right table-td" style="text-align: right;">{{ $data->leave_days}}</td>
                                    <td class="text-right table-td" style="text-align: right;">{{ number_format(abs(($data->gross_salary - $data->incometax_deduct_amount ))) }}</td>
                                    <td class="text-right table-td" style="text-align: right;">
                                        @if (isset($data->ot_time))
                                            <?php
                                            $hour = floor($data->ot_time / 60);
                                            $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                                            ?>
                                            {{ $hour }} : {{ $min }} hr
                                        @else
                                            0
                                        @endif
                                    </td>

                                    <td class="text-right" style="text-align: right;">
                                  
                                        @if (isset($data->ot_time) && $data->working_hour != 0)
                                            @php
                                                $strTime = $hour . '.' . $min;
                                                $floatTime = floatval($strTime);
                                                $working_hour = ($data->working_hour != 0) ? $data->working_hour : 1;
                                                $overtimePayAmt = round(($data->gross_salary / 30 / $working_hour) * $floatTime);
                                            @endphp
                                        @else
                                            @php
                                                $floatTime = 0;
                                                $overtimePayAmt = 0;
                                            @endphp
                                        @endif
                                        {{ number_format($overtimePayAmt) }}
                                        <input type="hidden"class="over_time_pay_amt" value="{{ intval($overtimePayAmt) }}" />

                                    </td>
                                    <td class="text-right table-td" style="text-align: right;">

                                        @php
                                            $total_payable_amount = ($data->gross_salary - $data->incometax_deduct_amount + $overtimePayAmt);
                                        @endphp
                                        {{ number_format($total_payable_amount) }}
                                    </td>
                                </tr>
                            <?php
                            $salary_pay = $data->gross_salary - $data->incometax_deduct_amount;
                            $total_salary_pay = $total_salary_pay + $salary_pay;
                            $total_overtime_hr = $total_overtime_hr + $floatTime;
                            $total_overtime_pay = $total_overtime_pay + $overtimePayAmt;
                            $total_payable = $total_payable + $total_payable_amount;
                            ?>
                            @endforeach
                            <tr>
                                <td class="text-right table-td" style="text-align: center;" colspan="14"><strong>Total</strong></td>
                                <td class="text-right table-td" style="text-align: right;"><strong>{{number_format($total_salary_pay, 2)}}</strong></td>
                                <td class="text-right table-td" style="text-align: right;"><strong>{{number_format($total_overtime_hr, 2)}}</strong></td>
                                <td class="text-right table-td" style="text-align: right;"><strong>{{number_format($total_overtime_pay, 2)}}</strong></td>
                                <td class="text-right table-td" style="text-align: right;"><strong>{{number_format($total_payable, 2)}}</strong></td>

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>



</body>

</html>
