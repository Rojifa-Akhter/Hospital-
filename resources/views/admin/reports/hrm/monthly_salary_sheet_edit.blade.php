@php
$salary_process = (isset($salary_process_data) && (!empty($salary_process_data))) ? $salary_process_data : [];
 // dd($salary_process);

$monthly_salary_no_pk = ($salary_process) ? $salary_process->monthly_salary_no_pk : '';
$month_attend_no_pk = ($salary_process) ? $salary_process->month_attend_no_pk : '';
$gross_salary = ($salary_process) ? $salary_process->gross_salary : '';
$attendance_bonus = ($salary_process) ? $salary_process->attendance_bonus : '';
$gross_salary = ($salary_process) ? $salary_process->gross_salary : '';
$basic_salary = ($salary_process) ? $salary_process->basic_salary : '';
$medical_allowance = ($salary_process) ? $salary_process->medical_allowance : '';
$house_rent = ($salary_process) ? $salary_process->house_rent : '';
$other_allowance = ($salary_process) ? $salary_process->other_allowance : '';
$att_deduct_amount = ($salary_process) ? $salary_process->att_deduct_amount : '';
$salary_advance_amount = ($salary_process) ? $salary_process->loan_deduct_amount : '';
$other_allowance = ($salary_process) ? $salary_process->other_allowance : '';
$attendance_days = ($salary_process) ? $salary_process->attendance_days : '';
$late_days = ($salary_process) ? $salary_process->late_days : '';
$absent_days = ($salary_process) ? $salary_process->absent_days : '';
$leave_days = ($salary_process) ? $salary_process->leave_days : '';
$leave_withoutpay_days = ($salary_process) ? $salary_process->leave_withoutpay_days : '';
$overtime_rate = ($salary_process) ? $salary_process->overtime_rate : '';
$overtime_amount = ($salary_process) ? $salary_process->overtime_amount : '';
$overtime_hours = ($salary_process) ? $salary_process->overtime_hours : '';
$salary_yyyymm = ($salary_process) ? $salary_process->salary_yyyymm : '';
$monthly_save_fund_no_pk = ($salary_process) ? $salary_process->monthly_save_fund_no_pk : '';
$personal_savings_amount = ($salary_process) ? $salary_process->personal_savings_amount : '';
$others_deduction = ($salary_process) ? $salary_process->other_deduct_amount : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{route('hrm.salary_sheet_update')}}" method="post" id="Monthly_attendance_store">
        @csrf
        <input type="hidden" value="{{$monthly_salary_no_pk}}" name="hdn_salary">
        <input type="hidden" value="{{$month_attend_no_pk}}" name="attend_hdn_month">
        <input type="hidden" value="{{$monthly_save_fund_no_pk}}" name="saving_hdn_month">
        <input type="hidden" value="{{$salary_yyyymm}}" name="yearmonth">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="late_day" class="">Late Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="late_day" name="late_day" value="{{$late_days}}" placeholder="Late Day " >
                </div>
            </div>
            <div class="col-md-4">
                <label for="leave_days" class="">Leave Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="leave_days" name="leave_days" value="{{$leave_days}}" placeholder="Attendance Bonus" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="leave_withoutpay_days" class="">Leave Wp Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="leave_withoutpay_days" name="leave_withoutpay_days" value="{{$leave_withoutpay_days}}" placeholder="Other Allowance" >
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="absent_days" class="">Absent Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="absent_days" name="absent_days" value="{{$absent_days}}" placeholder="Absent Days" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="present_day " class="">Present Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="present_day" name="present_day" value="{{$attendance_days}}" placeholder="Present Day" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="abs_ded_amount" class="">Absent Deduction Amount </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="abs_ded_amount" name="abs_ded_amount" value="{{$att_deduct_amount}}" placeholder="Absent Deduction Amount " >
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="attendance_bonus" class="">Attendance Bonus </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="attendance_bonus" name="attendance_bonus" value="{{$attendance_bonus}}" placeholder="Attendance Bonus" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="other_allowance" class="">Other Allowance </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="other_allowance" name="other_allowance" value="{{$other_allowance}}" placeholder="Other Allowance" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="other_allowance" class="">Advance </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="advance" name="advance" value="{{$salary_advance_amount}}" placeholder="Advance" >
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="overtime_hours" class="">Overtime Hours</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="overtime_hours" name="overtime_hours" value="{{$overtime_hours}}" placeholder="Overtime Hours" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="overtime_rate" class="">Overtime Rate</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="overtime_rate" name="overtime_rate" value="{{$overtime_rate}}" placeholder="Overtime Rate" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="overtime_amount" class="">Overtime Amount</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="overtime_amount" name="overtime_amount" value="{{$overtime_amount}}" placeholder="Overtime Amount" >
                </div>
            </div>
        </div>
         <div class="form-group row">
            <div class="col-md-4">
                <label for="saving_fund" class="">Savings Fund</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="saving_fund" name="saving_fund" value="{{$personal_savings_amount}}" placeholder="Savings Fund" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="others_deduction" class=""> Others Deduction</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="others_deduction" name="others_deduction" value="{{$others_deduction}}" placeholder="Others Deduction" >
                </div>
            </div>
        </div>





        <div class="modal-footer">
            @php
            $response_action = route('hrm.monthly_salary_sheet_jk');
            @endphp
            <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Update</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
