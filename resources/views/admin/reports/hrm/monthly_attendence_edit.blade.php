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
$sick_leave = ($salary_process) ? $salary_process->sick_leave : '';
$casual_leave = ($salary_process) ? $salary_process->casual_leave : '';
$general_festival_days = ($salary_process) ? $salary_process->general_festival_days : '';
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
                <label for="leave_days" class="">ML </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="sick_leave" name="sick_leave" value="{{$sick_leave}}" placeholder="Sick Leave" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="leave_days" class="">CL </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="casual_leave" name="casual_leave" value="{{$casual_leave}}" placeholder="Casual Leave" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="leave_withoutpay_days" class="">Leave Wp Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="leave_withoutpay_days" name="leave_withoutpay_days" value="{{$leave_withoutpay_days}}" placeholder="Other Allowance" >
                </div>
            </div>
            <div class="col-md-2">
                <label for="absent_days" class="">Absent Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="absent_days" name="absent_days" value="{{$absent_days}}" placeholder="Absent Days" >
                </div>
            </div>
            <div class="col-md-2">
                <label for="absent_days" class="">Gen.Fest. </label>    
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="general_festival_days" name="general_festival_days" value="{{$general_festival_days}}" placeholder="General festival" >
                </div>
            </div>
            <div class="col-md-4">
                <label for="present_day " class="">Present Day </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="present_day" name="present_day" value="{{$attendance_days}}" placeholder="Present Day" >
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            @php
            $response_action = '';//route('hrm.attendence-monthly-data');
            @endphp
            <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Update</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
