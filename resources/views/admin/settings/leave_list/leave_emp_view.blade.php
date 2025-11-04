@php

$data = isset($data) && !empty($data) ? $data : [];
$leave_sum = isset($leave_sum) && !empty($leave_sum) ? $leave_sum : [];

$all_leave = $leave_sum->all_leave ? $leave_sum->all_leave : '';
$approved_leave = $leave_sum->approved_leave ? $leave_sum->approved_leave : '';
$reject_leave = $leave_sum->reject_leave ? $leave_sum->reject_leave : '';
$ramaining_leave = $leave_sum->ramaining_leave ? $leave_sum->ramaining_leave : '';

$leave_no_pk = $data->leave_no_pk ? $data->leave_no_pk : '';
$au_entry_at = $data ? date('d/m/Y', strtotime($data->au_entry_at)) : '';
$full_name = $data ? $data->full_name : '';
$person_code = $data ? $data->person_code : '';
$su_name = $data ? $data->su_name : '';
$designation_name = $data ? $data->designation_name : '';
$from_date = $data->from_date ? date('d/m/Y', strtotime($data->from_date)) : '';
$to_dates = $data->to_dates ? date('d/m/Y', strtotime($data->to_dates)) : '';
$total_leave = $data->total_leave ? $data->total_leave : '';
$available_leave = $data->available_leave ? $data->available_leave : '';
$dep_approve_note = $data ? $data->dep_approve_note : '';
$dep_reject_note = $data ? $data->dep_reject_note : '';
$hr_approve_note = $data ? $data->hr_approve_note : '';
$hr_reject_note = $data ? $data->hr_reject_note : '';
$approved_dept_at = $data->approved_dept_at ? date('d/m/Y, h:i a', strtotime($data->approved_dept_at)) : '';
$approved_hr_at = $data->approved_hr_at != '' ? date('d/m/Y, h:i a', strtotime($data->approved_hr_at)) : '';
$dep_user_name = $data->dep_user_name ? $data->dep_user_name : '';
$hr_user_name = $data ? $data->hr_user_name : '';
$leave_reason = $data ? $data->leave_reason : '';

$person_no_fk = $data ? $data->person_no_fk : '';
// strtotime
$day_diff = (strtotime($data->to_dates) - strtotime($data->from_date)) / (3600 * 24) + 1;
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-2">
                <div class="form-group row">
                    <strong style="font-size: 16px" class="col-sm-12">Application Date : {{ $au_entry_at }}</strong>
                </div>
                <div class="form-group row d-flex px-2">
                    <span for="patient_gender" class="col-sm-4">Card No. :
                        <strong>{{ $person_code }}</strong></span>
                    <span for="patient_gender" class="col-sm-4">Employee Name :
                        <strong>{{ $full_name }}</strong></span>
                    <span for="patient_blood_group" class="col-sm-4">Employee Dep. :
                        <strong>{{ $su_name }}</strong></span>
                    <span for="patient_blood_group" class="col-sm-4">Employee Desig. :
                        <strong>{{ $designation_name }}</strong></span>
                </div>
                <div class="form-group row">
                    <strong style="font-size: 16px" class="col-sm-12 mt-4">Leave History</strong>

                </div>
                <div class="form-group row px-2">

                    <label for="patient_gender" class="col-sm-3 ">Leave Date From :
                        <strong>{{ $from_date }}</strong></label>
                    <label for="patient_blood_group" class="col-sm-3 ">Leave Date To :
                        <strong>{{ $to_dates }}</strong></label>
                    <label for="patient_blood_group" class="col-sm-3 ">Leave Request
                        :
                        <strong>{{ $day_diff }}</strong>
                        {{ $day_diff == 1 || $day_diff == 0 ? 'Day' : 'Days' }}</label>

                    <label for="patient_blood_group" class="col-sm-3 ">Total Leave Taken
                        :
                        <strong>{{ !empty($total_leave_count->total_leave) ? $total_leave_count->total_leave : 0 }}</strong>
                        {{ $total_leave_count->total_leave > 1 ? 'Days' : 'Day' }}</label>


                </div>
                <div class="form-group row px-2">
                    <label for="patient_gender" class="col-sm-3">Yearly Authorized
                        Leave : <strong>{{ $all_leave }}</strong>
                        {{ $all_leave == 1 || $all_leave == 0 ? 'Day' : 'Days' }}</label>

                    <label for="patient_blood_group" class="col-sm-3">Available Leave:
                        <strong>{{ $ramaining_leave }}</strong>
                        {{ $ramaining_leave == 1 || $ramaining_leave == 0 ? 'Day' : 'Days' }}</label>
                    <label for="patient_gender" class="col-sm-3">Leave Reason :
                        <strong>{{ $leave_reason }}</strong></label>
                </div>
                <div class="form-group row mt-4">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <strong style="font-size: 16px" class="col-sm-12">HR</strong>

                        </div>
                        <label for="patient_gender" class="col-sm-4 col-form-label col-form-label-sm">Approval
                            Notes</label>
                        <textarea readonly class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $hr_approve_note }}</textarea>
                        <label for="patient_gender" class="col-sm-4 col-form-label col-form-label-sm">Rejected
                            Notes</label>
                        <textarea readonly class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $hr_reject_note }}</textarea>
                        <p>By : <strong>{{ $hr_user_name }}</strong></p>
                        <p>Date Time : <strong>{{ $approved_hr_at }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <strong style="font-size: 16px" class="col-sm-12">Department</strong>
                        </div>
                        <label for="patient_gender" class="col-sm-4 col-form-label col-form-label-sm">Approval
                            Notes</label>
                        <textarea readonly class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $dep_approve_note }}</textarea>
                        <label for="patient_gender" class="col-sm-4 col-form-label col-form-label-sm">Rejected
                            Notes</label>
                        <textarea readonly class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $dep_reject_note }}</textarea>
                        <p>By : <strong>{{ $dep_user_name }}</strong></p>
                        <p>Date Time : <strong>{{ $approved_dept_at }}</strong></p>

                    </div>
                    <div class="col-md-12" style="text-align: right">
                        <form method="post" id="frm_print" action="{{ route('leave.view_print') }}" target="_blank">
                            @csrf
                            <input type="hidden" value="{{ $leave_no_pk  }}" name="leave_no_pk">
                            <button style="align-items:flex-end" type="submit" class="btn btn-warning">Print</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
