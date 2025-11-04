@php
    use Carbon\Carbon;
@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    tr th,
    tr td {
        white-space: nowrap;
    }
    .custom-button {
        position: fixed;
        left: 50%;
        margin-top: 22px !important;
        padding: 0px 45px !important
    }
    thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #fff0cb !important;
        color: #101010;
    }
    div[style*="max-height"] {
        border: 1px solid #dee2e6;
    }  
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .sticky-col-sl{
        left:0;
        z-index: 4;
    }
    .sticky-col-join,
    .sticky-col-id,
    .sticky-col-name {
        position: sticky;
        background-color: #f7f7f7;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        z-index: 4;
    }
    
</style>
<form action="{{ route('hrm.specific_salary_sheet_data_update') }}" method="POST" id="specific_salary_id" class="">
    @csrf
    <div style="overflow-y: auto; max-height: 540px;">
        <table class="table data-table table-bordered table-hover table-striped">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th colspan="26"></th>
                    <th colspan="3" class="text-center">Addition</th>
                    <th colspan="9" class="text-center">Deduction</th>
                    <th colspan="7"></th>
                </tr>
                <tr>
                    <th class="text-center sticky-col sticky-col-sl">SL#</th>
                    <th class="text-left sticky-col sticky-col-join">Joining Date</th>
                    <th class="text-center sticky-col sticky-col-id">ID</th>
                    <th class="text-left sticky-col sticky-col-name">Name</th>
                    <th class="text-left">Designation</th>
                    <th class="text-left" >Department</th>
                    <th class="text-left" >Unit</th>
                    <th class="text-center">No. of Day</th>
                    <th class="text-center">Work Day</th>
                    <th class="text-center">Weekend</th>
                    <th class="text-center">Holiday</th>
                    <th class="text-center">Leave</th>
                    <th class="text-center">LWP</th>
                    <th class="text-center">Absent</th>
                    <th class="text-center">OTH</th>
                    <th class="text-center">Total Pay day</th>
                    {{-- <th class="table-td">OT(hr)</th> --}}
                    <th class="text-center">Basic</th>
                    <th class="text-center">HRA</th>
                    <th class="text-center">MA</th>
                    <th class="text-center">TA</th>
                    <th class="text-center">CA</th>
                    <th class="text-center">SA</th>
                    <th class="text-center">IA</th>
                    <th class="text-center">RA</th>
                    <th class="text-center">Gross</th>
                    <th class="text-center">Calculated OT</th>
                    {{-- <th class="text-center">Per Day</th> --}}
                    <th class="text-center">Other</th>
                    <th class="text-center">Arrear</th>
                    <th class="text-center">OT</th>
                    <th class="text-center">AIT</th>
                    <th class="text-center">Food Bill</th>
                    <th class="text-center">PF</th>
                    <th class="text-center">ADV</th>
                    <th class="text-center">Medical Bill</th>
                    <th class="text-center">Salary</th>
                    <th class="text-center">LWP/Absent</th>
                    <th class="text-center">Extra Mobile bill</th>
                    <th class="text-center">Others</th>
                    <th class="text-center">Total Addition</th>
                    <th class="text-center">Total Deduction</th>
                    <th class="text-center">Salary Payable</th>
                    <th class="text-center">Remarks</th>
                    <th class="text-center">A/C. No.</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Withheld</th>
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
                        $totalDaysInMonth = isset($countTotalDaysInMonth) ? $countTotalDaysInMonth : 0;
                        $totalWeekend = $countWeekend ? $countWeekend : 0;
                        $weekendCount = isset($countWeekend) ? $countWeekend : 0;
                        $holiday = isset($holidays) ? count($holidays) : 0;
                        $workDays = $totalDaysInMonth - $totalWeekend - $holiday;
                        $gross_salary = $data->gross_salary;
                        // $gross_salary = $data->basic_salary + $data->house_rent + $data->medical_allowance + $data->ta_da_allowance + $data->ra_sal + $data->ica_sal + $data->sa_sal + $data->ca_sal;
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
                            //    $strTime = $hour . '.' . $min;
                            //     $floatTime = floatval($strTime);
                                // $basic = $data->basic_salary;
                                // $per_hour_ot = floatval(($basic * 2) / 208);
                                // $overtimePayAmt = round($per_hour_ot * round($data->ot_time, 2));
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
                        $salary_payable = $gross_salary + $total_addition - $calculated_total_deduction - $abs_lwp; // salary payable claculation
                    @endphp
                    <tr @if($data->withheld_ind == 1) style="background: #dc3545" @endif>
                        <td class="text-center sticky-col sticky-col-sl">{{ $loop->iteration }}</td>
                        <td class="text-left sticky-col sticky-col-join">
                            {{ isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}</td>
                        <td class="text-center sticky-col sticky-col-id">{{ $data->card_no }}</td>
                        <td class="text-left sticky-col sticky-col-name">{{ $data->full_name }}</td>
                        <td class="text-left">{{ $desig ? "$desig" : '' }}</td>
                        <td class="text-left">{{ isset($data->servicedept_name) ? $data->servicedept_name : '' }}</td>
                        <td class="text-left">{{ isset($data->serviceunit_name) ? $data->serviceunit_name : '' }}</td>
                    
                        <td class="text-center">{{ $totalDaysInMonth  }}</td>
                        <td class="text-center">{{ isset($data->attendance_days) ? $data->attendance_days : 0 }}</td>
                        <td class="text-center">{{ $weekendCount ? $weekendCount : '' }}</td>
                        <td class="text-center" style="text-align:right">{{ $holiday }}
                        </td>
                        <td class="text-center" style="text-align:right">
                            {{ $total_leave_day ? $total_leave_day : 0 }}</td>
                        <td class="text-center" style="text-align:right">
                            {{ $data->leave_withoutpay_days ? $data->leave_withoutpay_days : 0 }}
                        </td>
                        <td class="text-center" style="text-align:right">
                            {{ $absent }}</td>
                        <td class="text-center">
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
                        <td class="text-center">
                            {{ $totalPayDays ? $totalPayDays : 0 }}</td>
                        <td class="text-right">
                            {{ isset($data->basic_salary) ? number_format(round($data->basic_salary), 2) : 0 }}</td>
                        <td class="text-right">
                            {{ isset($data->house_rent) ? number_format(round($data->house_rent), 2) : 0 }}</td>
                        <td class="text-right">
                            {{ isset($data->medical_allowance) ? number_format(round($data->medical_allowance), 2) : 0 }}
                        </td>
                        <td class="text-right">{{ isset($data->ta_da_allowance) ? number_format(round($data->ta_da_allowance), 2) : 0 }}</td>
                        <td class="text-right">{{ isset($data->ca_sal) ? number_format(round($data->ca_sal), 2) : 0 }}</td>
                        <td class="text-right">{{ isset($data->sa_sal) ? number_format(round($data->sa_sal), 2) : 0 }}</td>
                        <td class="text-right">{{ isset($data->ica_sal) ? number_format(round($data->ica_sal), 2) : 0 }}</td>
                        <td class="text-right">{{ isset($data->ra_sal) ? number_format(round($data->ra_sal), 2) : 0 }}</td>
                        <td class="text-right gross_salary">
                            {{ isset($gross_salary) ? number_format(round($gross_salary), 2) : 0 }}</td>
                        <input type="hidden" class="hidden_gross_salary"
                            value="{{ isset($gross_salary) ? $gross_salary : 0 }}">
                        <td class="text-right">
                                {{ isset($overtimePayAmt) ? number_format(round($overtimePayAmt), 2) : 0 }}
                        </td>
                        {{-- <td class="text-right">
                            {{ isset($perDaySalary) ? number_format($perDaySalary, 2) : number_format(0, 2) }}</td> --}}
                        <td class="text-right"> <input type="text" class="form-control revision number_only"
                                name="revision[]" placeholder="Revision"
                                value="{{ isset($data->add_revision) ? $data->add_revision : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control arrear number_only"
                                name="arrear[]" placeholder="Arrear"
                                value="{{ isset($data->add_arrear) ? $data->add_arrear : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right">
                                <input type="text" class="form-control ot" name="ot[]" placeholder="OT"
                                    value="{{ isset($data->add_ot) ? $data->add_ot : $overtimePayAmt }}" style="width: 82px;"
                                    onkeyup="handleAddDed(this)" readonly/>
                        </td>
                        <td class="text-right"> <input type="text" class="form-control ait" name="ait[]"
                                placeholder="AIT" value="{{ isset($data->ded_ait) ? $data->ded_ait : '0' }}"
                                style="width: 82px;" onkeyup="handleAddDed(this)" autocomplete="off" readonly/></td>
                        <td class="text-right"> <input type="text" class="form-control food_bill number_only"
                                name="food_bill[]" placeholder="Food Bill"
                                value="{{ isset($data->ded_food_bill) ? $data->ded_food_bill : '0' }}"
                                style="width: 82px;" onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control pf_ded number_only"
                                name="pf_ded[]" placeholder="PF"
                                value="{{ isset($data->ded_pf) ? $data->ded_pf : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control adv number_only"
                                name="adv[]" placeholder="ADV"
                                value="{{ isset($data->ded_adv) ? $data->ded_adv : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control medical_bill number_only"
                                name="medical_bill[]" placeholder="Medical"
                                value="{{ isset($data->ded_med_bill) ? $data->ded_med_bill : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control salary_ded number_only"
                                name="salary_ded[]" placeholder="Salary"
                                value="{{ isset($data->ded_salary) ? $data->ded_salary : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control lwp number_only"
                                name="lwp[]" placeholder="LWP"
                                value="{{ isset($data->ded_lwp) ? round($data->ded_lwp) : round($lwp_amount + $absent_amount) }}"
                                style="width: 82px;" onkeyup="handleAddDed(this)" autocomplete="off" />
                        </td>
                        <td class="text-right"> <input type="text" class="form-control mobile_bill number_only"
                                name="mobile_bill[]" placeholder="Mobile"
                                value="{{ isset($data->ded_emb) ? $data->ded_emb : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right"> <input type="text" class="form-control others number_only"
                                name="others[]" placeholder="Others"
                                value="{{ isset($data->ded_others) ? $data->ded_others : '0' }}" style="width: 82px;"
                                onkeyup="handleAddDed(this)" autocomplete="off" /></td>
                        <td class="text-right total_addition">
                            {{ isset($total_addition) ? number_format(round($total_addition), 2) : '' }}</td>
                        <td class="text-right total_deduction">
                            {{ isset($total_deduction) ? number_format(round($total_deduction), 2) : '' }}</td>
                        <td class="text-right salary_payable_amt">
                            {{ isset($salary_payable) ? number_format(round($salary_payable), 2) : '' }}</td>
                        <td class="text-center">
                            <input type="text" class="form-control remarks" name="remarks[]"
                            placeholder="Remarks" style="width: 82px;" autocomplete="off" value="{{ isset($data->remarks) ? $data->remarks : '' }}"/>
                        </td>
                        <td class="text-center">{{ isset($data->bank_acc_no) ? $data->bank_acc_no : '' }}</td>
                        <td class="text-center">
                            <a Class="btn btn-sm btn-danger"
                                href="{{ url('hrm/monthly_salary_slip_v1', [$data->monthly_salary_no_pk, $salary_payable]) }}"
                                title="PDF Salary Slip"><i class="fas fa-file-pdf"></i></a>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="withheld[{{$data->monthly_salary_no_pk}}]" value="1" {{$data->withheld_ind == 1 ? 'checked': ''}}>
                        </td>
                        <input type="hidden" class="absent_amount"
                            value="{{ isset($absent_amount) ? $absent_amount : 0 }}">
                        <input type="hidden" name="person_no_pk[]" value="{{ $data->person_no_pk }}">
                        <input type="hidden" name="salary_yyyymm[]" value="{{ $data->salary_yyyymm }}">
                        <input type="hidden" name="ids[]" value="{{ $data->monthly_salary_no_pk }}" />
                        <input type="hidden" name="addndeduct_nos[]" value="{{ $data->addndeduct_no_pk }}" />
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
                    <td class="text-right table-td" style="text-align: center;" colspan="38"><strong>Total=</strong>
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
                    <td></td>
                    <td></td>
                </tr>
            @endif 
        </table>
    </div>
    @php
        $response_action = route('hrm.monthly_salary_sheet_jk');
    @endphp 
    <div class="text-right">
        <button type="button" class="btn btn-success btn-md mt-1" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
    </div>
</form>

<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>  
    $(document).ready(function() {
        const slWidth = $('.sticky-col-sl').outerWidth();
        $('.sticky-col-join').css(
            'left', slWidth + 'px'
        );
        const joinWidth = $('.sticky-col-join').outerWidth();
        $('.sticky-col-id').css('left', (slWidth + joinWidth) + 'px');
        const idWidth = $('.sticky-col-id').outerWidth();
        $('.sticky-col-name').css('left', (slWidth + joinWidth + idWidth) + 'px');
    });

    $(document).ready(function() {
        $("table tbody tr").click(function() {
            $("table tbody tr").css("background-color", "");
            $(this).css("background-color", "#fdf59a"); // Light yellow color
        });
    });
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
        let ot = Number($(element).parents('tr').find('.ot').val());
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
        let absent_amount = Number($(element).parents('tr').find('.absent_amount').val());
        let total_addition = Number(revision + arrear + ot);
        let total_deduction = Number(ait + food_bill + pf_ded + adv + medical_bill + salary_ded + lwp + mobile_bill +
            others);
        let salary_payable_amt = Number(hidden_gross_salary + total_addition - total_deduction);

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
