<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Guest User Registration</h5>
            <small>Guest User / New Registration</small>
        </div>
    </div>

    <div class="card p-3">
        <form action="{{ route('registration.storeguestregistration') }}" method="POST" id="patient_form" class="patient_form">
            @csrf
            @include('admin.patient.guest_patient_registration_form')
            <div class="mt-2">

                @php
                    $response_action = route('registration.guestcreate');
                @endphp
                <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
            </div>
        </form>
    </div>
</div>




<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>


    // function get_dob_by_age()
    // {
    //     var pat_age_y = $('#pat_age_y').val();
    //     var pat_age_m = $('#pat_age_m').val();
    //     var pat_age_d = $('#pat_age_d').val();

    //     var cur_date = new Date();
    //     var cur_y = cur_date.getFullYear();

    //     var dob = pat_age_m + "/" + pat_age_d + "/" + (cur_y - pat_age_y);
    //     $("#pat_dob").val(dob);
    // }
    // $('.date_picker').datepicker({
    //     onSelect: function(){
    //         var yr = $("#patient_dob").val();
    //         $('#patient_age').val(yr);
    //     }
    // });
</script>
