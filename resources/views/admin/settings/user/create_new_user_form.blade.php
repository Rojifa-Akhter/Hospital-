<style>
    .fontpassword {
        position: relative;
    }

    .fontpassword i {
        position: absolute;
        left: 15px;
        top: 40px;
        color: gray;
    }

    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 40px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

</style>
@php

$user = isset($data) && !empty($data) ? $data : [];

$user_no_pk = $user ? $user->user_no_pk : '';
$person_no_fk = $user ? $user->person_no_fk : '';
$user_code = $user ? $user->user_code : '';
$user_full_name = $user ? $user->user_fullname : '';
$user_name = $user ? $user->user_name : '';
$user_email = $user ? $user->email : '';
$status = $user ? $user->status : '';

$user_expire_date = $user == null || date('d-m-Y', strtotime($user->user_expire_date)) == '01-01-1970' ? '' : date('d-m-Y', strtotime($user->user_expire_date));
$pass_expire_date = $user && $user->password_expiry_date ? date('d-m-Y', strtotime($user->password_expiry_date)) : '';
$lock_user = $user ? $user->user_lock_ind : '';
$expire_password = $user ? $user->pass_expiry_ind : '';
$expire_user = $user ? $user->user_expire_ind : '';
$financial_ind = $user ? $user->financial_ind : '';
$hospital_no_pk = $user && $user->hospital_no_pk ? $user->hospital_no_pk : '';

$person_name = isset($person_name_qurey) && !empty($person_name_qurey) ? $person_name_qurey->full_name : '';

@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form method="post" id="frm-pat-registration" action="{{ route('user.store') }}" data-response-action="">
    @csrf
    <input type="hidden" name="id" value="{{ $user_no_pk }}">
    <div class="card-body">
        <div class="row pt-3 align-items-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm"
                        for="select_hospital">Hospital <span class="text-danger">*</span></label>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <select class="form-control form-control-sm" id="select_hospital" name="select_hospital"
                            required>
                            <option value="">Select Hospital</option>
                            @if (!empty($hospital))
                                @foreach ($hospital as $value)
                                    <option value="{{ $value->hospital_no_pk }}" @if ($hospital_no_pk = $value->hospital_no_pk) selected @endif>
                                        {{ $value->hospital_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="focus_input"></span>

                    </div>

                    <label for="emp_name"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Person Name  <span
                        class="text-danger">*</span>
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control " name="emp_name" id="emp_name"
                            placeholder="Card Number" value="{{ $person_name }}" />
                        <input type="hidden" name="emp_id" id="emp_id" value="{{ $person_no_fk }}" required>
                        <span class="focus_input"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="user_code"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">User Code <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required" id="user_code" name="user_code"
                            value="{{ $user_code }}" placeholder="User Code">
                        <span class="focus_input"></span>
                    </div>

                    <label for="user_full_name"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Full Name <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required text-capitalize required"
                            id="user_full_name" name="user_full_name" value="{{ $user_full_name }}"
                            placeholder="User Full Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                        <span class="focus_input"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_name"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">User Name <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm required" id="user_name" name="user_name"
                            value="{{ $user_name }}" placeholder="Enter User Name">
                        <span class="focus_input"></span>

                    </div>

                    <label for="user_email"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Email <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="email" class="form-control form-control-sm required email" id="user_email"
                            name="user_email" value="{{ $user_email }}" placeholder="Enter User Email">
                        <span class="focus_input"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_password"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Password <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 input-group">

                        <input type="password" class="form-control form-control-sm required" id="user_password"
                            name="user_password" value="" placeholder="Enter Password">
                        <div class="input-group-prepend mt-2">
                            <div class="input-group-text">
                                <input type="checkbox" id="show-password"
                                    aria-label="Checkbox for following text input">
                            </div>
                        </div>
                    </div>
                    {{-- <label for="user_password" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Password <span class="text-danger">*</span></label> --}}
                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 fontpassword"> --}}
                    {{-- <input type="password" class="form-control form-control-sm required" id="user_password" name="user_password" value="" placeholder="Enter Password" > --}}

                    {{-- <input type="checkbox" id="show-password"> --}}
                    {{-- <span class="focus_input"></span> --}}
                    {{-- </div> --}}


                    <label for="confirm_password"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Confirm <span
                            class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 input-group">

                        <input type="password" class="form-control form-control-sm required" id="confirm_password"
                            name="confirm_password" value="" placeholder="Confirm Password">
                        <div class="input-group-prepend mt-2">
                            <div class="input-group-text">
                                <input type="checkbox" id="show-password2"
                                    aria-label="Checkbox for following text input">
                            </div>
                        </div>
                    </div>



                    {{-- <label for="confirm_password" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Confirm <span class="text-danger">*</span></label> --}}
                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 fontpassword"> --}}
                    {{-- <input type="password" class="form-control form-control-sm required" id="confirm_password" name="confirm_password" value="" placeholder="Confirm Password"> --}}
                    {{-- <input type="checkbox" id="show-password2"> --}}
                    {{-- <span class="focus_input"></span> --}}
                    {{-- </div> --}}
                </div>

                <div class="form-group row">
                    <label for="user_expire_date"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm ">User Expire
                        date</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="text" class="form-control form-control-sm date_picker" id="user_expire_date"
                            name="user_expire_date" value="{{ $user_expire_date }}" placeholder="dd-mm-yyyy">
                        <span class="focus_input"></span>
                    </div>

                    <label for="pass_expire_date"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Password Expire
                        date</label>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <input type="text" class="form-control form-control-sm date_picker" id="pass_expire_date"
                            name="pass_expire_date" value="{{ $pass_expire_date }}" placeholder="dd-mm-yyyy">
                        <span class="focus_input"></span>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="status"
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label col-form-label-sm">Status</label>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <input type="checkbox" class="form-check-input" id="status" name="status"
                            @if ($status == 1) checked @endif>
                        <span class="focus_input"></span>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="col-sm-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="expire_user" name="expire_user"
                            @if ($expire_user == 1) checked @endif>
                        <label class="form-check-label-sm" for="expire_user">Expire User</label>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="expire_password" name="expire_password"
                            value="<?php echo date('d-m-Y'); ?>" @if ($expire_password == 1) checked @endif>
                        <label class="form-check-label-sm" for="expire_password">Expire Password</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="lock_user" name="lock_user"
                            value="<?php echo date('d-m-Y'); ?>" @if ($lock_user == 1) checked @endif>
                        <label class="form-check-label-sm" for="lock_user">Lock User</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dlt_usr_pass" name="dlt_usr_pass" value="">
                        <label class="form-check-label-sm" for="dlt_usr_pass">Default User Password</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="form-check-label-sm text-danger" for="dlt_usr_pass">(Default Password 123456)</label>

                </div>

                <div class="col-sm-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="financial_ind" name="financial_ind"
                            @if ($financial_ind == 1) checked @endif>
                        <label class="form-check-label-sm" for="financial_ind">Financial Report Access</label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @php
        $doctor_id = '';
        $response_url = route('user.index');
    @endphp
    <!-- <div class="card"> -->
    <div class="m-2">
        <button type="submit" class="btn btn-md btn-success"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save
            changes</button>
        <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>

    </div>
    <!-- </div> -->

</form>
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openDoctorAutocomplete('#emp_name', 'emp_id');
    $(function() {
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: true,
            autoclose: true,
            startDate: '+0d'
        });
    });
    $('input[id=dlt_usr_pass]').change(function() {
        $('#user_password').val("123456");
        $('#confirm_password').val("123456");
    });

    $(document).ready(function() {
        $("#show-password").change(function() {
            $(this).prop("checked") ? $("#user_password").prop("type", "text") : $("#user_password")
                .prop("type", "password");
        });
        $("#show-password2").change(function() {
            $(this).prop("checked") ? $("#confirm_password").prop("type", "text") : $(
                "#confirm_password").prop("type", "password");
        });
    });
</script>
