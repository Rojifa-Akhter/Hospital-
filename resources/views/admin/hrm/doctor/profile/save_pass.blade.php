<div class="card">
    <div class="card-header" style="color: #0b2e13;"><h5>Change Password</h5></div>
    <div class="card-body">
        <form method="post" id="doctor_save_pass" action="{{ route('profile-update') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $doctor_no_pk }}">
            <input type="hidden" name="tab_type" value="2">
            <div class="form-row align-items-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="save_user_name" class="col-form-label col-form-label-sm"> User Name</label>
                            <input type="text" class="form-control form-control-sm keep_me"
                                   id="save_user_name" name="user_name" value="{{ucwords($user_name)}}"
                                   placeholder="User Name">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="col-form-label col-form-label-sm number_only"> Current password</label>
                            <input type="password" class="form-control form-control-sm"
                                   id="password" name="password" value=""
                                   placeholder="Password" required>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="new_password" class="col-form-label col-form-label-sm">New Password </label>
                            <input type="password" class="form-control form-control-sm"
                                   id="new_password" name="new_password" value=""
                                   placeholder="New Password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="col-form-label col-form-label-sm">Confirm
                                Password </label>
                            <input type="password" class="form-control form-control-sm"
                                   id="confirm_password" name="confirm_password" value=""
                                    placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="form-row border-top">
                        @include('admin.hrm.doctor.profile.profile_footer')
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
