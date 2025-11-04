@include('admin.components.pdf_header_jk')
<div style="width: 100%;">
    <div style="text-align:center;">
        <span class="report-name" style="width:70%; border:solid black 1px;"> Monthly Salary
            Report</span>
    </div>
    <div style=" text-align:center;  width:100%;" >
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
                <span style="padding:5px; border-top: black solid 1px;"> CMO
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> DGM
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
                    <td style="font-size: 9px;">Page | <span class="pagenum"></span></td>
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
                <table style="width:100%;border-collapse:collapse;border-right: 1px solid #333;" cellpadding="1"
                    cellspacing="0" border="1">
                    <thead style="">
                        <tr class="table-tr" style="background-color: #E3E3E3; ">
                            <th class=" table-td" rowspan="2"> <strong>SL# </strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Name, Designation & Joining Date </strong>
                            </th>
                            <!-- <th class=" table-td" rowspan="2"> <strong>Designation </strong></th> -->
                            <!-- <th class=" table-td" rowspan="2"> <strong>AD </strong></th>
                          <th class=" table-td" rowspan="2"> <strong>PD </strong></th> -->

                            <th class=" table-td" rowspan="2"> <strong>Gross Salary </strong></th>
                            <th class=" table-td" colspan="3"> <strong>Salary Stracture </strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Convance, D/A & Other Allowance </strong></th>

                            {{-- <th class=" table-td" rowspan="2"> <strong>Attend Bonus </strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Others </strong></th>
                            <th class=" table-td" colspan="3"> <strong>Over time </strong></th> --}}
                            <!-- <th class=" table-td" rowspan="2"> <strong>Payable Wages </strong></th> -->
                            <!-- <th class=" table-td" rowspan="2"> <strong>Late Count </strong></th>
                          <th class=" table-td" rowspan="2"> <strong>Deduct Hours </strong></th> -->
                            {{-- <th class=" table-td" colspan="10"> <strong>Deduction </strong></th> --}}
                            <th class=" table-td" rowspan="2"> <strong>Total Attn.</strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Payable Amount </strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Night Allowance </strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Absent</strong></th>
                            {{-- <th class=" table-td" rowspan="2"> <strong>LWP</strong></th> --}}
                            <th class=" table-td" rowspan="2"> <strong>Advance</strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Tax/RS</strong></th>
                            {{-- <th class=" table-td" rowspan="2"> <strong>R/S</strong></th> --}}
                            <th class=" table-td" rowspan="2"> <strong>Total Deduction</strong></th>
                            <th class=" table-td" rowspan="2"> <strong>Net<br>Payable</strong></th>
                            <th class=" table-td" rowspan="2" style="width:90px"> <strong>Recipient
                                    Signature</strong></th>
                        </tr>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class=" table-td"> <strong>Basic </strong></td>
                            <td class=" table-td"> <strong>House Rent </strong></td>
                            <td class=" table-td"> <strong>Medical </strong></td>

                            {{-- <td class=" table-td"> <strong>Min </strong></td>
                            <td class=" table-td"> <strong>Rate </strong></td>
                            <td class=" table-td"> <strong>Amount </strong></td>
                            <!-- <td class=" table-td"> <strong>Gross </strong></td> -->
                            <td class="text-center"><strong>Late Day</strong></td>
                            <td class="text-center"><strong>Leave Day</strong></td>
                            <td class="text-center"><strong>Leave WP day</strong></td>
                            <td class="text-center"><strong>Abs Day</strong></td>
                            <td class="text-center"><strong>Pre Day</strong></td>
                            <td class=" table-td"> <strong>Abs Deduct Amt </strong></td>
                            <td class=" table-td"> <strong>Residence fee </strong></td>
                            <td class=" table-td"> <strong>Loan </strong></td>
                            <td class=" table-td"> <strong>SF </strong></td>
                            <td class=" table-td"> <strong>Other Deduct </strong></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $listSl = 0;
                            $total_net_pay = 0;
                        @endphp
                        @if (!empty($emp_data))
                            @foreach ($emp_data as $dept => $dept_data)
                                @php
                                    $dep = 0;

                                @endphp
                                @foreach ($dept_data as $desig => $data)
                                    @php
                                        $des = 0;
                                        $listSl++;
                                        $dep++;
                                    @endphp
                                    @if ($dep == 1)
                                        <tr class="table-tr">
                                            <td class="border-0" colspan="16">
                                                <strong> Job Type = </strong>{{ $dept }}
                                                <strong> Total Employee = </strong>
                                                {{ isset($count_depart_emp[$dept]) ? $count_depart_emp[$dept] : '0' }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="table-tr">
                                        <td class="table-td" style="text-align: center;" style="text-align: center;"
                                            scope="col"><strong>{{ $listSl }}</strong></td>
                                        <td class="table-td" style="text-align: left; width:200px">
                                            {{ strlen($data->full_name) > 28 ? substr($data->full_name, 0, 28) . '..' : $data->full_name }}
                                            <br>{{ strlen($data->designation_name) > 28 ? substr($data->designation_name, 0, 28) . '..' : $data->designation_name }}
                                            <br>{{ isset($data->join_date) ? date('d/m/Y', strtotime($data->join_date)) : '' }}
                                        </td>

                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->gross_salary, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->basic_salary, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->house_rent, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->medical_allowance, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->conveyance_allowance, 2) }}<br>
                                            {{ number_format($data->ta_da_allowance, 2) }}<br>
                                            {{ number_format($data->other_allowance, 2) }}</td>

                                        <td class="table-td" style="text-align: right;">
                                            @php
                                                if ($data->attendance_days > 0) {
                                                    $attendance_days = $data->attendance_days - ($data->absent_days + $data->leave_withoutpay_days);
                                                    $holiday = $attendance_days - $data->working_days;
                                                    $one_day_pay_amount = intval($data->gross_salary) / intval($data->attendance_days);

                                                    $emp_attn_amount = $one_day_pay_amount * $attendance_days;
                                                    $emp_attn_ded_amount = $one_day_pay_amount * $holiday;
                                                    $abs_amount = $data->absent_days * $one_day_pay_amount;
                                                    $leave_wp_amount = $data->leave_withoutpay_days * $one_day_pay_amount;
                                                } else {
                                                    $attendance_days = $data->attendance_days - ($data->absent_days + $data->leave_withoutpay_days);
                                                    $holiday = $attendance_days - $data->working_days;
                                                    $one_day_pay_amount = intval($data->gross_salary);
                                                    // $one_day_pay_amount = intval($data->gross_salary)/intval($data->attendance_days);

                                                    $emp_attn_amount = $one_day_pay_amount;
                                                    // $emp_attn_amount = $one_day_pay_amount*$attendance_days;
                                                    $emp_attn_ded_amount = $one_day_pay_amount * $holiday;
                                                    $abs_amount = $data->absent_days * $one_day_pay_amount;
                                                    $leave_wp_amount = $data->leave_withoutpay_days * $one_day_pay_amount;
                                                }
                                                $pay_amount = $emp_attn_amount > 0 ? $emp_attn_amount : 0;
                                            @endphp
                                            {{-- @dd($data->leave_withoutpay_days) --}}
                                            {{ number_format($attendance_days) }}</td>
                                        <td class="table-td" style="text-align: right;">

                                            {{ number_format($pay_amount) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->night_allowance) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->absent_amount) }}</td>
                                        {{-- <td class="table-td" style="text-align: right;">
                                            {{ $data->leave_withoutpay_days }}</td> --}}
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->advance_amt) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->incometax_deduct_amount) }}<br>{{ number_format($data->revenue_stamp) }}
                                        </td>
                                        {{-- <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->revenue_stamp) }}</td> --}}
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format(abs($data->incometax_deduct_amount + $data->revenue_stamp + $data->advance_amt + $leave_wp_amount + $data->absent_amount)) }}
                                        </td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($pay_amount + $data->night_allowance - $data->incometax_deduct_amount - $data->revenue_stamp - $data->advance_amt - $data->absent_amount) }}
                                        </td>

                                        {{-- <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->attendance_bonus, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->other_allowance, 2) }}</td> --}}



                                        {{-- <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->overtime_hours) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->overtime_rate, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->overtime_amount, 2) }}</td> --}}

                                        {{-- <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->late_days) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->leave_days) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->leave_withoutpay_days) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->absent_days) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->attendance_days) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->att_deduct_amount, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->residence_fee, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->loan_deduct_amount, 2) }}</td>
                                        <!-- <td class="table-td" style="text-align: right;"></td> -->
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->personal_savings_amount, 2) }}</td>
                                        <td class="table-td" style="text-align: right;">
                                            {{ number_format($data->other_deduct_amount, 2) }}</td>
                                        <td class="table-td" style="text-align: right;"> <strong>
                                                {{ number_format($data->payable_amount, 2) }} </strong></td> --}}
                                        <td class="table-td" style="text-align: left;border-right: 1px solid #333;">
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-tr">
                                    <td class="border-0" colspan="14" style="text-align:right">
                                        <strong>Department Wise Total=</strong>
                                    </td>
                                    <td style="text-align:right">
                                        {{ isset($total_salary[$dept]) ? number_format($total_salary[$dept], 2) : '0' }}
                                    </td>
                                    <td></td>
                                </tr>
                                @php
                                    $total_net_pay = $total_net_pay + $total_salary[$dept];
                                @endphp
                            @endforeach
                            <tr class="table-tr">
                                <td class="border-0" colspan="14" style="text-align:right; font-size:12px">
                                    <strong>Grand Total=</strong>
                                </td>
                                <td style="text-align:right; font-size:13px">
                                    <strong>{{ number_format($total_net_pay, 2) }}</strong>
                                </td>
                                <td></td>
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
