<style>
    tr th,
    tr td{
        white-space: nowrap;
    }
</style>
@php
    use Carbon\Carbon;
@endphp
@include('admin.components.pdf_header_v1')
<div style="width: 100%;">
    <div style=" text-align:center; margin-top:-22px !important;">
        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;">Salary Sheet for the Month of
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
            - {{ $year }}</span>
    </div>
    {{-- <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">
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
    </div> --}}
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
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th colspan="24"></th>
                            <th colspan="3" class="text-center">Addition</th>
                            <th colspan="9" class="text-center">Deduction</th>
                            <th colspan="6"></th>
                        </tr>
                        <tr class="table-tr" style="background-color: #
                        E3E3E3;">
                            <th class="table-td"><strong>SL#</strong></th>
                            <th class="table-td"><strong>ID</strong></th>
                            <th class="" ><strong>Name</strong></th>
                            <th class="table-td" ><strong>Designation</strong></th>
                            <th class="table-td" ><strong>Department</strong></th>
                            <th class="table-td" ><strong>Unit</strong></th>
                            <th class="table-td" ><strong>Joining Date</strong></th>
                            <th class="table-td"><strong>No.<br>of Day</strong></th>
                            <th class="table-td"><strong>Work Day</strong></th>
                            <th class="table-td"><strong>Weekend</strong></th>
                            <th class="table-td"><strong>Holiday</strong></th>
                            <th class="text-center">Leave</th>
                            <th class="text-center">LWP</th>
                            <th class="text-center">Absent</th>
                            <th class="text-center">OTH</th>
                            <th class="table-td"><strong>Total<br>Pay day</strong></th>
                            {{-- <th class="table-td"><strong>OT(hr)</strong></th> --}}
                            <th class="table-td"><strong>Basic</strong></th>
                            <th class="table-td"><strong>HRA</strong></th>
                            <th class="table-td"><strong>MA</strong></th>
                            <th class="table-td"><strong>TA</strong></th>
                            <th class="table-td"><strong>CA</strong></th>
                            <th class="table-td"><strong>SA</strong></th>
                            <th class="table-td"><strong>IA</strong></th>
                            <th class="table-td"><strong>RA</strong></th>
                            <th class="table-td"><strong>Gross</strong></th>
                            {{-- <th class="table-td"><strong>Per Day</strong></th> --}}
                            <th class="table-td"><strong>Other</strong></th>
                            <th class="table-td"><strong>Arrear</strong></th>
                            <th class="table-td"><strong>OT</strong></th>
                            <th class="table-td"><strong>AIT</strong></th>
                            <th class="table-td"><strong>Food Bill</strong></th>
                            <th class="table-td"><strong>PF</strong></th>
                            <th class="table-td"><strong>ADV</strong></th>
                            <th class="table-td"><strong>Medical Bill</strong></th>
                            <th class="table-td"><strong>Salary</strong></th>
                            <th class="table-td"><strong>LWP<br>Absent</strong></th>
                            <th class="table-td"><strong>Extra<br>Mobile bill</strong></th>
                            <th class="table-td"><strong>Others</strong></th>
                            <th class="table-td"><strong>Total Addition</strong></th>
                            <th class="table-td"><strong>Total Deduction</strong></th>
                            <th class="table-td"><strong>Salary Payable</strong></th>
                            <th class="table-td"><strong>Remarks</strong></th>
                            <th class="table-td"><strong>A/C. No.</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_addition_amt = 0;
                        $total_deduction_amt = 0;
                        $total_salary_payable = 0;
                        ?>
                        @if (isset($monthlySalaryReportprint))
                            @foreach ($monthlySalaryReportprint as $data)
                                @php
                                    $desig = $data->designation_name;
                                    $totalDaysInMonth = isset($countTotalDaysInMonth) ? $countTotalDaysInMonth : 0;
                                    $totalWeekend = $countWeekend ? $countWeekend : 0;
                                    $weekendCount = isset($countWeekend) ? $countWeekend : 0;
                                    $holiday = isset($holidays) ? count($holidays) : 0;
                                    $workDays = $totalDaysInMonth - $totalWeekend - $holiday;
                                    $gross_salary = $data->gross_salary;
                                    $perDaySalary = isset($gross_salary) ? $gross_salary / $totalDaysInMonth : 0; //per day salary
                                    $joinDate = isset($data->join_date) ? Carbon::parse($data->join_date) : '';
                                    $resignDate = isset($data->resign_date) ? Carbon::parse($data->resign_date) : '';
                                    $targetMonth = $month;
                                    $targetYear = $year;
                                    $isJoinWithinMonthAndYear = isset($data->join_date) ? $joinDate > $startDate : false; // condition with joining after first date in specific  month
                                    $isResignWithinMonthAndYear = isset($data->resignDate) ? $joinDate < $endDate : false; // condition with resigning before last date in specific month
                                    // dd($isResignWithinMonthAndYear);
                                    if ($isJoinWithinMonthAndYear == true && $isResignWithinMonthAndYear == false) {
                                        $joinDateFormat = $joinDate->format('Y-m-d');
                                        $holiday = count(DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$joinDateFormat', 'YYYY-MM-DD') and TO_DATE('$endtDate', 'YYYY-MM-DD')"));
                                        $totalDaysInMonth = isset($joinDate) && isset($endtDate) ? countDays($joinDateFormat, $endtDate) + 1 : '';
                                        $weekendCount = isset($joinDate) && isset($endtDate) ? countFridays($joinDateFormat, $endtDate) : '';
                                        $workDays = $totalDaysInMonth - $weekendCount - $holiday;
                                    } elseif ($isJoinWithinMonthAndYear == false && $isResignWithinMonthAndYear == true) {
                                        $resignDateFormat = $resignDate->format('Y-m-d');
                                        $holiday = count(DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$startDate', 'YYYY-MM-DD') and TO_DATE('$resignDateFormat', 'YYYY-MM-DD')"));
                                        $totalDaysInMonth = isset($startDate) && isset($resignDateFormat) ? countDays($startDate, $resignDateFormat) + 1 : '';
                                        $weekendCount = isset($startDate) && isset($resignDateFormat) ? countFridays($startDate, $resignDateFormat) : '';
                                        $workDays = $totalDaysInMonth - $weekendCount - $holiday;
                                    } elseif ($isJoinWithinMonthAndYear == true && $isResignWithinMonthAndYear == true) {
                                        $joinDateFormat = $joinDate->format('Y-m-d');
                                        $resignDateFormat = $resignDate->format('Y-m-d');
                                        $holiday = count(DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$joinDateFormat', 'YYYY-MM-DD') and TO_DATE('$resignDateFormat', 'YYYY-MM-DD')"));
                                        $totalDaysInMonth = isset($joinDateFormat) && isset($resignDateFormat) ? countDays($joinDateFormat, $resignDateFormat) + 1 : '';
                                        $weekendCount = isset($startDate) && isset($resignDateFormat) ? countFridays($joinDateFormat, $resignDateFormat) : '';
                                        $workDays = $totalDaysInMonth - $weekendCount - $holiday;
                                    }
                                    $total_leave_day = $data->leave_days + $data->sick_leave + $data->casual_leave;
                                    $absent = $data->absent_days;
                                    // $absent = $totalDaysInMonth - ($data->attendance_days + $weekendCount + $holiday + $total_leave_day + $data->leave_withoutpay_days); // absent calculation
                                    $totalPayDays = $totalDaysInMonth - $absent - $data->leave_withoutpay_days;
                                    $calPaydays = $totalPayDays > 30 ? 30 : $totalPayDays;
                                    $lwp_amount = $perDaySalary * $data->leave_withoutpay_days;
                                    $absent_amount = $perDaySalary * $absent;
                                    if (isset($data->ot_time)){
                                        $hour = floor($data->ot_time / 60);
                                        $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                                        $strTime = $hour . '.' . $min;
                                        $floatTime = floatval($strTime);
                                        $basic = $data->basic_salary;
                                        if (Session::get('user.ses_hospital_code') == 'DMHL'){
                                            $gross_amt = $data->gross_salary;
                                            $percentage = 80;
                                            $calcuated_amt = ($gross_amt * $percentage) / 100;
                                            $per_hour_ot = floatval($calcuated_amt / 30 / 8);
                                        }else{
                                            $per_hour_ot = floatval(($basic * 2) / 208);
                                        }
                                        $overtimePayAmt = round($per_hour_ot * $floatTime);
                                    }else{
                                            $floatTime = 0;
                                            $overtimePayAmt = 0;
                                    }
                                    $abs_lwp = isset($data->ded_lwp) ? $data->ded_lwp : $absent_amount + $lwp_amount;
                                    $ot_amt = isset($data->add_ot) ? $data->add_ot : $overtimePayAmt;
                                    $total_addition = $data->add_revision + $data->add_arrear + $ot_amt;
                                    $total_deduction = $data->ded_ait + $data->ded_food_bill + $data->ded_pf + $data->ded_adv + $data->ded_med_bill + $data->ded_salary + $data->ded_emb + $abs_lwp + $data->ded_others;
                                    $calculated_total_deduction = $data->ded_ait + $data->ded_food_bill + $data->ded_pf + $data->ded_adv + $data->ded_med_bill + $data->ded_salary + $data->ded_emb + $data->ded_others;
                                    // $salary_payable = ($perDaySalary * $totalPayDays)+ $total_addition - $total_deduction; // salary payable claculation
                                    $abs_lwp = isset($data->ded_lwp) ? $data->ded_lwp : $absent_amount + $lwp_amount;
                                    $salary_payable = $gross_salary + $total_addition - $calculated_total_deduction - $abs_lwp; // salary payable claculation
                                @endphp
                                <tr>
                                    <td class="text-center table-td">{{ $loop->iteration }}</td>
                                    <td class="text-left table-td">{{ $data->card_no }}</td>
                                    <td class="text-left" style="text-align:left">{{ $data->full_name }}</td>
                                    <td class="text-left table-td" style="text-align:left">{{ $desig ? "$desig" : '' }}</td>
                                    <td class="text-left table-td" >
                                        {{ isset($data->servicedept_name) ? $data->servicedept_name : '' }}</td>
                                    <td class="text-left table-td" style="text-align:left">
                                        {{ isset($data->serviceunit_name) ? $data->serviceunit_name : '' }}</td>
                                    <td class="text-left table-td" >
                                        {{ isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:center">
                                        {{ isset($totalDaysInMonth) ? $totalDaysInMonth : 0 }}</td>
                                    <td class="text-right table-td" style="text-align:center">
                                        {{ isset($data->attendance_days) ? $data->attendance_days : 0 }}</td>
                                    <td class="text-right table-td" style="text-align:center">
                                        {{ isset($weekendCount) ? $weekendCount : 0 }}</td>
                                    <td class="text-right" style="text-align:center">{{ $holiday }}
                                    </td>
                                    <td class="text-right" style="text-align:center">
                                        {{ $total_leave_day ? $total_leave_day : 0 }}</td>
                                    <td class="text-right" style="text-align:center">
                                        {{ $data->leave_withoutpay_days ? $data->leave_withoutpay_days : 0 }}
                                    </td>
                                    <td class="text-right" style="text-align:center">
                                        {{$absent}}</td>
                                    <td class="text-center" style="text-align:center">
                                        @if (isset($data->ot_time))
                                        @php
                                        $hour = floor($data->ot_time / 60);
                                        $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                                        @endphp
                                        {{ $hour }} : {{ $min }}
                                        {{-- {{round($data->ot_time, 2)}} --}}
                                    @else
                                        0
                                    @endif
                                    </td>
                                    <td class="text-right" style="text-align:center">
                                        {{ $totalPayDays ? $totalPayDays : 0 }}</td>
                                 
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->basic_salary) ? number_format(round($data->basic_salary), 2) : 0 }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->house_rent) ? number_format(round($data->house_rent), 2) : 0 }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->medical_allowance) ? number_format(round($data->medical_allowance), 2) : 0 }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ta_da_allowance) ? number_format(round($data->ta_da_allowance), 2) : 0 }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ca_sal) ? number_format(round($data->ca_sal), 2) : 0 }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->sa_sal) ? number_format(round($data->sa_sal), 2) : 0 }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ica_sal) ? number_format(round($data->ica_sal), 2) : 0 }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ra_sal) ? number_format(round($data->ra_sal), 2) : 0 }}
                                    </td>
                                    <td class="text-right table-td gross_salary" style="text-align:right">
                                        {{ isset($gross_salary) ? number_format(round($gross_salary), 2) : 0 }}</td>
                                    {{-- <td class="text-right table-td" style="text-align:right">
                                        {{ isset($perDaySalary) ? number_format($perDaySalary, 2) : 0 }}</td> --}}
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->add_revision) ? $data->add_revision : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->add_arrear) ? $data->add_arrear : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->add_ot)? $data->add_ot : $overtimePayAmt }}
                                    </td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_ait) ? $data->ded_ait : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_food_bill) ? $data->ded_food_bill : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_pf) ? $data->ded_pf : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_adv) ? $data->ded_adv : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_med_bill) ? $data->ded_med_bill : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_salary) ? $data->ded_salary : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_lwp) ? round($data->ded_lwp) : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_emb) ? $data->ded_emb : '' }}</td>
                                    <td class="text-right table-td" style="text-align:right">
                                        {{ isset($data->ded_others) ? $data->ded_others : '' }}</td>
                                    <td class="text-right table-td total_addition" style="text-align:right">
                                        {{ isset($total_addition) ? number_format(round($total_addition), 2) : '' }}</td>
                                    <td class="text-right table-td total_deduction" style="text-align:right">
                                        {{ isset($total_deduction) ? number_format(round($total_deduction), 2) : '' }}</td>
                                    <td class="text-right table-td salary_payable_amt" style="text-align:right">
                                        {{ isset($salary_payable) ? number_format(round($salary_payable), 2) : '' }}</td>
                                    <td class="text-left table-td" style="text-align:left">
                                        {{ isset($data->remarks) ? $data->remarks : '' }}</td>
                                    <td class="text-right table-td">
                                            {{ isset($data->bank_acc_no) ? $data->bank_acc_no : '' }}</td>
                                </tr>
                                <?php
                                $total_addition_amt = $total_addition_amt + $total_addition;
                                $total_deduction_amt = $total_deduction_amt + $total_deduction;
                                $total_salary_payable = $total_salary_payable + $salary_payable;
                                $totalDaysInMonth = isset($countTotalDaysInMonth) ? $countTotalDaysInMonth : 0;
                                $weekendCount = isset($countWeekend) ? $countWeekend : 0;
                                $holiday = isset($holidays) ? count($holidays) : 0;
                                ?>
                            @endforeach
                            <tr>
                                <td class="text-right table-td" style="text-align: right;" colspan="37">
                                    <strong>Total=</strong>
                                </td>
                                <td class="text-right table-td" style="text-align: right;">
                                    <strong>{{ number_format($total_addition_amt, 2) }}</strong>
                                </td>
                                <td class="text-right table-td" style="text-align: right;">
                                    <strong>{{ number_format($total_deduction_amt, 2) }}</strong>
                                </td>
                                <td class="text-right table-td" style="text-align: right;">
                                    <strong>{{ number_format($total_salary_payable, 2) }}</strong>
                                </td>
                                <td class="text-right table-td"></td>
                                <td class="text-right table-td"></td>
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
