<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Quick Registration</h5>
            <small>Patient / New Registration</small>
        </div>
    </div>
    <div class="card p-3">
        <form action="{{ route('registration.storequickregistration') }}" method="POST" id="patient_form"
            class="patient_form">
            @csrf
            @if(Session::get('user.ses_hospital_code') != 'IMPALA')
                @include('admin.patient.patient_quick_registration_form')
            @else
                @include('admin.patient.patient_quick_registration_form_impala')
            @endif
            <div class="mt-2">
                @php
                    $patient_id = '';
                    $response_url = route('patient-card', $patient_id);
                @endphp
                <input type="hidden" id="reg_billing" value="{{ $billing }}">
                <button type="submit" class="btn btn-md btn-success" onclick="patientQuickReg(this)">Save</button>

                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                    title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
            </div>
        </form>
    </div>
</div>

<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openPatientAreaInfoAutocomplete('#search_data');

    function patientQuickReg(thisElement) {
        event.preventDefault();
        // alert($('#pat_age_y').val() , $('#pat_age_m').val() , $('#pat_age_d').val());
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        if ($('#pat_age_y').val() == "" && $('#pat_age_m').val() == "" && $('#pat_age_d').val() == "") {
            alert('Please Enter Age');
            return;
        } else {
            if (formValidation(formID) == false) {
                return;
            }

            if (confirm("Are You Sure?")) {
                $.ajax({
                    async: true,
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        console.log(data);
                        $("#hdn_patient_id").val(data.insert_id);
                        $("#patient_id").val(data.patient_name);
                        $('#item_type_no_pk').val(data.item_level_disc_ind == 1 ? 0 : data.maximum_percent);
                        $('#discount_percent_hospital').val(data.item_level_disc_ind == 1 ? 0 : data
                            .maximum_percent);
                        $("#patient_itemType_dis_ind").val(data.item_level_disc_ind);
                        $("#" + formID + " input[name=hdn_patient_id]").val(data.insert_id);
                        var p_code = data.patient_code ? "<strong>Patient Code:  </strong>" + data
                            .patient_code + "," : "";
                        var p_name = data.patient_name ? "Name: " + data.patient_name + "(" + data
                            .patient_type_code + ")" + "," : "";
                        var p_gander = data.gender ? "<strong>Gender : </strong>" + data.gender + "," : "";
                        var p_age = (data.age != "") ? "<strong>Age : </strong>" + data.age + "," : "";
                        var p_phone = data.phone_mobile ? " <strong>Phone : </strong>" + data.phone_mobile :
                            "";

                        var corporate_name = data.ccm_client_name != null ?
                            ', <strong> Corporate : </strong>' + data.ccm_client_name : '';
                        var contact_person = data.contact_person != null ?
                            ', <strong> Contact Person : </strong>' + data.contact_person : '';
                        var contact_no = data.contact_no != null ? ', <strong> Contact No : </strong>' +
                            data.contact_no : '';

                        var patient_info = p_code + p_name + p_gander + p_age + p_phone + corporate_name +
                            contact_person + contact_no;
                        var billing = $('#reg_billing').val();

                        $("#patient_name").html(data.patient_name);
                        $("#patient_gender").html(data.gender);
                        $("#patient_age").html(data.age);
                        $("#patient_mobile").html(data.phone_mobile);
                        $("#patient_info").html(patient_info);


                        if (billing == "BILL") {
                            $("#" + formID).find("input, textarea").not('.keep_me').val("");
                            $("#" + formID).find("select").not('.keep_me').val("0");

                            var ccm_no = data.ccm_client_no_fk != "" ? data.ccm_client_no_fk : "''";
                            patientFunc(ccm_no, data.patient_type_code);
                        } else {
                            var url = '{{ route('patient-registration-print', ':id') }}';
                            url = url.replace(":id", data.insert_id);
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg +
                                `<br>  <a href='${url}'  class='btn btn-primary btn-md cursor-pointer text-center' target='_blank' data-id='${url}' id='patient_card' title='Print Patient Card'>Patient Card</a>`
                            );

                            $("#" + formID).find("input, textarea").not('.keep_me').val("");
                            $("#" + formID).find("select").not('.keep_me').val("0");
                        }
                        // patientFunc(data.ccm_client_no_fk);

                        var ccm_no = data.ccm_client_no_fk != "" ? data.ccm_client_no_fk : "''";
                        patientFunc(ccm_no, data.patient_type_code);

                    },
                    complete: function() {
                        if (isAModalOpen)
                            $('.modal').modal('hide');
                        $("#prescription_id").focus();

                        $.unblockUI();
                    },
                    error: function(data) {
                        var errors = jQuery.parseJSON(data.responseText).errors;
                        error_messages = "";
                        for (messages in errors) {
                            var field_name = $("#" + messages).siblings("label").html();
                            error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                                messages] + "</div>";
                        }

                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html("Validation Error");

                        $.unblockUI();
                    }
                });
            }
        }
        event.stopImmediatePropagation();
    }

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
