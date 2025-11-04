@php
    use Carbon\Carbon;
@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    tr th,
    tr td{
        white-space: nowrap;
    }
</style>
<form action="{{ route('hrm.specific_salary_sheet_data_update') }}" method="POST" id="specific_salary_id" class="">
    @csrf
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th colspan="21"></th>
                <th colspan="2" class="text-center">Addition</th>
                <th colspan="9" class="text-center">Deduction</th>
                <th colspan="5"></th>
            </tr>
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-center">ID</th>
                <th class="text-left">Name</th>
                <th class="text-left">Designation</th>
                <th class="text-left">Department</th>
                <th class="text-left">Unit</th>
                <th class="text-left">Joining Date</th>
                <th class="text-center">No. of Day</th>
                <th class="text-center">Work Day</th>
                <th class="text-center">Weekend</th>
                <th class="text-center">Holiday</th>
                <th class="text-center">Leave</th>
                <th class="text-center">LWP</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Total Pay day</th>
                {{-- <th class="table-td">OT(hr)</th> --}}
                <th class="text-center">Basic</th>
                <th class="text-center">HRA</th>
                <th class="text-center">MA</th>
                <th class="text-center">TA</th>
                <th class="text-center">Salary</th>
                <th class="text-center">Per Day</th>
                <th class="text-center">Revision</th>
                <th class="text-center">Arrear</th>
                {{-- <th class="text-center">OT</th> --}}
                <th class="text-center">AIT</th>
                <th class="text-center">Food Bill</th>
                <th class="text-center">PF</th>
                <th class="text-center">ADV</th>
                <th class="text-center">Medical Bill</th>
                <th class="text-center">Salary</th>
                <th class="text-center">LWP</th>
                <th class="text-center">Extra Mobile bill</th>
                <th class="text-center">Others</th>
                <th class="text-center">Total Addition</th>
                <th class="text-center">Total Deduction</th>
                <th class="text-center">Salary Payable</th>
                <th class="text-center">A/C. No.</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <?php
        $total_addition_amt = 0;
        $total_deduction_amt = 0;
        $total_salary_payable = 0;
        ?>
        @if (isset($value))
            @foreach ($value as $data)
                @php
                    $desig = $data->designation_name;
                    $totalDaysInMonth = $totalDaysInMonth ? $totalDaysInMonth : 0;
                    $totalWeekend = $weekendCount ? $weekendCount : 0;
                    $holiday = isset($holidays) ? count($holidays) : 0;
                    $workDays = $totalDaysInMonth - $totalWeekend - $holiday;
                    $gross_salary = $data->basic_salary + $data->house_rent + $data->medical_allowance + $data->medical_allowance;
                    $perDaySalary = isset($gross_salary) ? number_format($gross_salary / 30, 2) : number_format(0, 2);
                    $joinDate = isset($data->join_date) ? Carbon::parse($data->join_date) : '';
                    $resignDate = isset($data->resign_date) ? Carbon::parse($data->resign_date) : '';
                    $targetMonth = $month;
                    $targetYear = $year;
                    $isJoinWithinMonthAndYear = isset($data->join_date) ? $joinDate > $startDate : false; // condition with joining after first date in specific  month
                    $isResignWithinMonthAndYear = isset($data->resignDate) ?  $joinDate < $endDate: false; // condition with resigning before last date in specific month
                    // dd($isResignWithinMonthAndYear);
                    if ($isJoinWithinMonthAndYear == true && $isResignWithinMonthAndYear == false) {
                        $joinDateFormat = $joinDate->format('Y-m-d');
                        $totalDaysInMonth = isset($joinDate) && isset($endtDate) ? countDays($joinDateFormat, $endtDate) + 1 : "";
                        $weekendCount = isset($joinDate) && isset($endtDate) ? countFridays($joinDateFormat, $endtDate) : "";
                        $workDays = $totalDaysInMonth - $weekendCount - $holiday;
                    } elseif ($isJoinWithinMonthAndYear == true && $isResignWithinMonthAndYear == true) {
                        $resignDateFormat = $resignDate->format('Y-m-d');
                        $totalDaysInMonth = isset($startDate) && isset($resignDateFormat) ? countDays($startDate, $resignDateFormat) + 1 : "";
                        $weekendCount = isset($startDate) && isset($resignDateFormat) ? countFridays($startDate, $resignDateFormat) : "";
                        $workDays = $totalDaysInMonth - $weekendCount - $holiday;
                    }
                    $absent = $totalDaysInMonth - ($data->attendance_days + $weekendCount + $holiday);
                    $totalPayDays = $totalDaysInMonth - $absent;
                    $calPaydays = $totalPayDays > 30 ? 30 : $totalPayDays;
                    $gross_salary = round(($gross_salary / 30) * $calPaydays);
                    // $totalPayDays = $data->attendance_days + $holiday + $weekendCount + $data->leave_days;
                    $total_addition = $gross_salary + $data->add_revision + $data->add_arrear + $data->add_ot;
                    $total_deduction = $data->ded_ait + $data->ded_food_bill + $data->ded_pf + $data->ded_adv + $data->ded_med_bill + $data->ded_salary + $data->ded_lwp + $data->ded_emb + $data->ded_others;
                    $salary_payable = $total_addition - $total_deduction;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $data->card_no }}</td>
                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-left">{{ $desig ? "$desig" : '' }}</td>
                    <td class="text-left">{{ isset($data->servicedept_name) ? $data->servicedept_name : '' }}</td>
                    <td class="text-left">{{ isset($data->serviceunit_name) ? $data->serviceunit_name : '' }}</td>
                    <td class="text-left">
                        {{ isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}</td>
                    <td class="text-center">{{ $totalDaysInMonth ? $totalDaysInMonth : '' }}</td>
                    <td class="text-center">{{ isset($data->attendance_days) ? $data->attendance_days : 0 }}</td>
                    <td class="text-center">{{ $weekendCount ? $weekendCount : '' }}</td>
                    <td class="text-center" style="text-align:right">{{ $holiday }}
                    </td>
                    <td class="text-center" style="text-align:right">
                        {{ $data->leave_days ? $data->leave_days : 0 }}</td>
                    <td class="text-center" style="text-align:right">
                        {{ $data->leave_withoutpay_days ? $data->leave_withoutpay_days : 0 }}
                    </td>
                    <td class="text-center" style="text-align:right">
                        {{ $absent }}</td>
                    <td class="text-center">
                        {{ $totalPayDays ? $totalPayDays : 0 }}</td>
                    {{-- <td class="text-center">
                        @if (isset($data->ot_time))
                            @php
                            // $hour = floor($data->ot_time / 60);

                            // $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                            @endphp
                            {{ $hour }} : {{ $min }}
                        @else
                            0
                        @endif
                    </td> --}}
                    <td class="text-right">{{ isset($data->basic_salary) ? $data->basic_salary : 0 }}</td>
                    <td class="text-right">{{ isset($data->house_rent) ? $data->house_rent : 0 }}</td>
                    <td class="text-right">{{ isset($data->medical_allowance) ? $data->medical_allowance : 0 }}</td>
                    <td class="text-right">{{ isset($data->medical_allowance) ? $data->medical_allowance : 0 }}</td>
                    <td class="text-right gross_salary">  {{ isset($gross_salary) ? number_format(round($gross_salary), 2) : 0 }}</td>
                    <input type="hidden" class="hidden_gross_salary"
                        value="{{ isset($gross_salary) ? $gross_salary : 0 }}">
                    <td class="text-right">{{ isset($perDaySalary) ? $perDaySalary : 0 }}</td>
                    <td class="text-right"> <input type="text" class="form-control revision number_only" name="revision[]"
                            placeholder="Revision" value="{{ isset($data->add_revision) ? $data->add_revision : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control arrear number_only" name="arrear[]"
                            placeholder="Arrear" value="{{ isset($data->add_arrear) ? $data->add_arrear : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    {{-- <td class="text-right">
                            @if (isset($data->ot_time))
                                @php
                                    $strTime = $hour . '.' . $min;
                                    $floatTime = floatval($strTime);
                                    $basic = floatval($data->gross_salary * (60 / 100));
                                    $per_hour_ot = floatval(($basic * 2) / 208);
                                    $overtimePayAmt = round($per_hour_ot * $floatTime);
                                @endphp
                            @else
                                @php
                                    $floatTime = 0;
                                    $overtimePayAmt = 0;
                                @endphp
                            @endif
                                <input type="number" class="form-control ot" name="ot[]" placeholder="OT"
                                    value="{{ $data->add_ot === "0" || $data->add_ot > 0 ? $data->add_ot : $overtimePayAmt }}" style="width: 82px;"
                                    onkeyup="handleAddDed(this)" />
                    </td> --}}
                    <td class="text-right"> <input type="text" class="form-control ait number_only" name="ait[]"
                            placeholder="AIT" value="{{ isset($data->ded_ait) ? $data->ded_ait : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control food_bill number_only" name="food_bill[]"
                            placeholder="Food Bill"
                            value="{{ isset($data->ded_food_bill) ? $data->ded_food_bill : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control pf_ded number_only" name="pf_ded[]"
                            placeholder="PF" value="{{ isset($data->ded_pf) ? $data->ded_pf : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control adv number_only" name="adv[]"
                            placeholder="ADV" value="{{ isset($data->ded_adv) ? $data->ded_adv : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control medical_bill number_only"
                            name="medical_bill[]" placeholder="Medical"
                            value="{{ isset($data->ded_med_bill) ? $data->ded_med_bill : '' }}" style="width: 82px;"
                            onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control salary_ded number_only"
                            name="salary_ded[]" placeholder="Salary"
                            value="{{ isset($data->ded_salary) ? $data->ded_salary : '' }}" style="width: 82px;"
                            onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control lwp number_only" name="lwp[]"
                            placeholder="LWP" value="{{ isset($data->ded_lwp) ? $data->ded_lwp : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control mobile_bill number_only"
                            name="mobile_bill[]" placeholder="Mobile"
                            value="{{ isset($data->ded_emb) ? $data->ded_emb : '' }}" style="width: 82px;"
                            onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right"> <input type="text" class="form-control others number_only" name="others[]"
                            placeholder="Others" value="{{ isset($data->ded_others) ? $data->ded_others : '' }}"
                            style="width: 82px;" onkeyup="handleAddDed(this)" /></td>
                    <td class="text-right total_addition">
                        {{ isset($total_addition) ? number_format(round($total_addition), 2) : '' }}</td>
                    <td class="text-right total_deduction">
                        {{ isset($total_deduction) ? number_format(round($total_deduction), 2) : '' }}</td>
                    <td class="text-right salary_payable_amt">
                        {{ isset($salary_payable) ? number_format(round($salary_payable), 2) : '' }}</td>
                    <td class="text-center">{{ isset($data->bank_acc_no) ? $data->bank_acc_no : '' }}</td>
                    <td class="text-center">
                        <a Class="btn btn-sm btn-danger"
                            href="{{ url('hrm/monthly_salary_slip_v1', [$data->monthly_salary_no_pk, $salary_payable]) }}"
                            title="PDF Salary Slip"><i class="fas fa-file-pdf"></i></a>
                    </td>
                    <input type="hidden" name="person_no_pk[]" value="{{ $data->person_no_pk }}">
                    <input type="hidden" name="salary_yyyymm[]" value="{{ $data->salary_yyyymm }}">
                    <input type="hidden" name="ids[]" value="{{ $data->monthly_salary_no_pk }}" />
                    <input type="hidden" name="addndeduct_nos[]" value="{{ $data->addndeduct_no_pk }}" />
                </tr>
                <?php
                $total_addition_amt = $total_addition_amt + $total_addition;
                $total_deduction_amt = $total_deduction_amt + $total_deduction;
                $total_salary_payable = $total_salary_payable + $salary_payable;
                ?>
            @endforeach
            <tr>
                <td class="text-right table-td" style="text-align: center;" colspan="32"><strong>Total=</strong>
                </td>
                <td class="text-right table-td" style="text-align: right;">
                    <strong>{{ number_format(round($total_addition_amt), 2) }}</strong>
                </td>
                <td class="text-right table-td" style="text-align: right;"><strong>
                        {{ number_format(round($total_deduction_amt), 2) }}
                    </strong></td>
                <td class="text-right table-td" style="text-align: right;">
                    <strong>{{ number_format(round($total_salary_payable), 2) }}</strong>
                </td>
                <td></td>
                <td></td>
            </tr>
        @endif
    </table>
    <div style="text-align:right;" class="mb-2">
        @php
            $response_action = route('hrm.monthly_salary_sheet_jk');
        @endphp
        <button type="button" class="btn btn-success btn-md text-center mt-2"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
    </div>
</form>

<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false,
        "searching": false
    });

    function handleAddDed(element) {
        let revision = Number($(element).parents('tr').find('.revision').val());
        let arrear = Number($(element).parents('tr').find('.arrear').val());
        // let ot = Number($(element).parents('tr').find('.ot').val());
        let ait = Number($(element).parents('tr').find('.ait').val());
        let food_bill = Number($(element).parents('tr').find('.food_bill').val());
        let pf_ded = Number($(element).parents('tr').find('.pf_ded').val());
        let adv = Number($(element).parents('tr').find('.adv').val());
        let medical_bill = Number($(element).parents('tr').find('.medical_bill').val());
        let salary_ded = Number($(element).parents('tr').find('.salary_ded').val());
        let lwp = Number($(element).parents('tr').find('.lwp').val());
        let mobile_bill = Number($(element).parents('tr').find('.mobile_bill').val());
        let others = Number($(element).parents('tr').find('.others').val());
        // console.log("valuee", revision, arrear, ot);
        let hidden_gross_salary = Number($(element).parents('tr').find('.hidden_gross_salary').val());
        let total_addition = Number(hidden_gross_salary + revision + arrear);
        let total_deduction = Number(ait + food_bill + pf_ded + adv + medical_bill + salary_ded + lwp + mobile_bill +
            others);
        let salary_payable_amt = Number(total_addition - total_deduction);

        $(element).parents('tr').find('.total_addition').text(total_addition.toFixed(0));
        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.salary_payable_amt').text(salary_payable_amt.toFixed(0));
    }

    function debounce(func, timeout = 200) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    }
</script>
