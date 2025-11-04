<div class="row bg-white border-bottom sticky-top shadow-sm">
    <div class="col-md-12 mb-1">
        <h5 class="mt-2 mb-0">Patient Registration</h5>
        <small>Patient / New Registration</small>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-9">
       @if(Session::get('user.ses_hospital_code') == 'IMPALA')
            @include("admin.patient.registration_form_v2_data_impala")
       @elseif(Session::get('user.ses_hospital_code') == 'AMCSH')
            @include("admin.patient.registration_form_v2_data_amcsh")
       @else
            @include("admin.patient.registration_form_v2_data")
       @endif
    </div>
</div>
