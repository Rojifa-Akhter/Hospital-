<input type="hidden" value="{{ $patient_id }}" name="patient_id" id="hdn_patient_id">
<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active cursor-pointer" id="demographic-details-tab" data-toggle="tab" role="tab"
                aria-controls="demographic-details" onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="1"
                data-action="{{ route('emr.patient-current-emr-use') }}" aria-selected="false">Demographic Details</a>
        </li>

        <li class="nav-item " role="presentation">
            <a class="nav-link cursor-pointer" id="current-medical-usage-tab" data-toggle="tab" role="tab"
                aria-controls="current-medical-usage" onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="2"
                data-action="{{ route('emr.patient-current-emr-use') }}" aria-selected="false">Current Medical Usage</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" id="past-medical-records-tab" data-toggle="tab"
                aria-controls="past-medical-records" onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="3"
                data-action="{{ route('emr.patient-current-emr-use') }}" aria-selected="false">Past Medical Records</a>
        </li>

        <li class="nav-item" role="presentation">

            <a class="nav-link cursor-pointer" id="family-disease-tab" data-toggle="tab"
                aria-controls="family-disease-tab" onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="10"
                data-action="{{ route('emr.patient-current-emr-use') }}" aria-selected="false">Family Disease</a>
        </li>
        <li class="nav-item" role="presentation">

            <a class="nav-link cursor-pointer" id="family-disease-tab" data-toggle="tab"
                aria-controls="family-disease-tab" onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="13"
                data-action="{{ route('emr.patient-current-emr-use') }}" aria-selected="false">Medical Documents</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        {{-- demographic-details --}}
        <div class="tab-pane fade active show" id="demographic-details" role="tabpanel"
            aria-labelledby="demographic-details-tab">
            <div class="form-row">
                <div class="col-12">
                    <div class="detail-info-tab">
                        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="demographic-details-tab" data-toggle="tab"
                                    href="#demographic-details-child" tab role="tab"
                                    aria-controls="demographic-details" aria-selected="true">Demographic Details</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="nav-vitals-tab" data-toggle="pill" href="#nav-vitals"
                                    role="tab" aria-controls="nav-vitals" aria-selected="false">Vitals</a>
                            </li>
                        </ul>

                        <div class="tab-content p-0" id="nav-tabContent">
                            <div class="tab-pane fade show active pt-2" id="demographic-details-child" role="tabpanel"
                                aria-labelledby="demographic-details-tab">
                                @include('admin.EMR.tabs.demographic_details.demographic_details')
                            </div>

                            <div class="tab-pane fade pt-2" id="nav-vitals" role="tabpanel"
                                aria-labelledby="nav-vitals-tab">
                                @include('admin.EMR.tabs.demographic_details.vitals')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- current-medical-usage --}}
        <div class="tab-pane fade" id="current-medical-usage" role="tabpanel"
            aria-labelledby="current-medical-usage-tab">
            @include('admin.EMR.tabs.current_medical_usage.current_medical_usage')
        </div>

        {{-- past-medical-records --}}
        <div class="tab-pane fade" id="past-medical-records" role="tabpanel"
            aria-labelledby="past-medical-records-tab">
            @include('admin.EMR.tabs.past_medical_records.past_medical_records')
        </div>

        {{-- family-disease --}}
        <div class="tab-pane fade" id="family-disease" role="tabpanel" aria-labelledby="family-disease-tab">
            @include('admin.EMR.tabs.family_disease.family_disease')
        </div>
        {{-- Medical Documents --}}
        <div class="tab-pane fade" id="family-disease" role="tabpanel" aria-labelledby="family-disease-tab">
            @include('admin.EMR.tabs.medical_documents.medical_documents')
        </div>
    </div>
</div>



<script type="text/javascript">
    var EMRFunc = {

        getCurrentMedicalUsages: function(thisElement) {
            var patient_id = $("#hdn_patient_id").val();
            var action = $(thisElement).attr("data-action");
            var tab_type = $(thisElement).attr("data-tab-type");
            $.ajax({
                data: {
                    patient_id: patient_id,
                    tab_type: tab_type
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $(thisElement).parents("#myTab").siblings("#myTabContent").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },



        //immunization
        storeCurrentEquiment: function(thisElement) {
            event.preventDefault();
            var patient_id = $("#hdn_patient_id").val();
            if (patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient.");
            } else {
                var formID = $(thisElement).parents("form").attr("id");
                var formAction = $(thisElement).parents("form").attr("action");
                var formMethod = $(thisElement).parents("form").attr("method");

                var equipment_name = $("#equipment_name").val();
                var date_of_engage = $("#date_of_engage").val();
                var discharge_date = $("#date_of_discharge").val();
                var start_time_of_engage = $("#start_time_of_engage").val();
                var end_time_of_engage = $("#end_time_of_engage").val();
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
                            var sl = $("#current_table tr").length;
                            var action_btn = $("#current_equiment_container").append(
                                "<tr><td class='text-center'>" + sl +
                                "</td><td class='text-center'>" + equipment_name +
                                "</td><td class='text-center'>" + date_of_engage +
                                "</td><td class='text-center'>" + start_time_of_engage +
                                "</td><td class='text-center'>" + discharge_date +
                                "</td><td class='text-center'>" + end_time_of_engage +
                                "</td></tr>");

                            $("#" + formID).find("input, textarea").not('.keep_me').val("");

                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });


                }
            }
            event.stopImmediatePropagation();
        },


        //immunization
        storeImunization: function(thisElement) {
            event.preventDefault();
            var patient_id = $("#hdn_patient_id").val();
            if (patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient.");
            } else {

                var formID = $(thisElement).parents("form").attr("id");
                var formAction = $(thisElement).parents("form").attr("action");
                var formMethod = $(thisElement).parents("form").attr("method");

                var immunization_name = $("#immunization_name").val();
                var dose_numer = $("#dose_numer").val();
                var immunization_date = $("#immunization_date").val();
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
                            var sl = $("#immunization_table tr")
                            .length; //$("#immunization_container tr").length()*1+1;
                            var action_btn =
                                "<span onclick='EMRFunc.removeImunization(this)' class='btn btn-sm btn-danger' id='" +
                                data.last_id + "'><i class='fa fa-times'></i></span>";
                            $("#immunization_container").append("<tr><td class='text-center'>" +
                                sl + "</td><td class='text-center'>" + immunization_date +
                                "</td><td class='text-center'>" + immunization_name +
                                "</td><td class='text-center'>" + dose_numer +
                                "</td><td class='text-center'>" + action_btn + "</td></tr>");

                            $("#" + formID).find("input, textarea").not('.keep_me').val("");

                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });
                }

            }
            event.stopImmediatePropagation();
        },
        removeImunization: function(thisElement) {
            //remove immuzation
            var formAction = $(thisElement).attr("data-action");
            var data = $(thisElement).attr("id");

            if (confirm("Are you sure?")) {
                $.ajax({
                    async: true,
                    data: {
                        data: data
                    },
                    url: formAction,
                    type: "get",
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html("Success");
                        $('.common-modal-notify .modal-body').html(
                            "immuzation Data Deleted successfully");

                    },
                    complete: function() {
                        $(thisElement).parents("tr").remove();
                        $.unblockUI();
                    }
                });

            }

            event.stopImmediatePropagation();
            return;
        },
        storeFamilyDisease: function(thisElement) {
            event.preventDefault();
            var patient_id = $("#hdn_patient_id").val();
            if (patient_id == "") {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html("You did not select any Patient.");
            } else {

                var formID = $(thisElement).parents("form").attr("id");
                var formAction = $(thisElement).parents("form").attr("action");
                var formMethod = $(thisElement).parents("form").attr("method");


                var relative = $("#relative").val();
                var family_disease = $("#family_disease").val();
                var family_severity = $("#family_severity").val();
                var suffered_duration = $("#suffered_duration").val();
                var lp_report_from = $("#lp_report_from").val();
                var lp_report_to = $("#lp_report_to").val();
                // var death_yes 			= $("#death_yes").val();

                var checkBox = document.getElementById("death_yes");
                if (checkBox.checked == true) {
                    var death_yes = 1;
                    var death_btn = '<span class="badge badge-primary">Yes</span>';
                } else {
                    var death_yes = 0;
                    var death_btn = '<span class="badge badge-warning">No</span>';
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
                            // var sl = $("#family_table > tbody > tr").length;
                            var sl = $("#family_table tr").length;
                            var action_btn =
                                "<span onclick='EMRFunc.removeFamilyDisease(this)' class='btn btn-sm btn-danger' id='" +
                                data.last_id + "'><i class='fa fa-times'></i></span>";
                            $("#family_container").append("<tr><td class='text-center'>" + sl +
                                "</td><td class='text-center'>" + relative +
                                "</td><td class='text-center'>" + family_disease +
                                "</td><td class='text-center'>" + lp_report_from +
                                "</td><td class='text-center'>" + lp_report_to +
                                "</td><td class='text-center'>" + family_severity +
                                "</td><td class='text-center'>" + suffered_duration +
                                "</td><td class='text-center'>" + death_btn + "</td><td>" +
                                action_btn + "</td></tr>");

                            $("#" + formID).find("input, textarea").not('.keep_me').val("");

                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });
                }

            }
            event.stopImmediatePropagation();
        },
        removeFamilyDisease: function(thisElement) {
            //remove immuzation

            //var formID      = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).attr("data-action");
            var data = $(thisElement).attr("id");


            if (confirm("Are you sure?")) {
                $.ajax({
                    async: true,
                    data: {
                        data: data
                    },
                    url: formAction,
                    type: "get",
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html("Success");
                        $('.common-modal-notify .modal-body').html(
                            "Family Disease information removed successfully");

                    },
                    complete: function() {
                        $(thisElement).parents("tr").remove();
                        $.unblockUI();
                    }
                });

            }

            event.stopImmediatePropagation();
            return;
        },
        getPatientEMRData: function(patientData, patientObj) {
            var patient_id = patientData.patient_id;
            var emr_route = $("#patient_id").attr("data-emr-route");
            window.location = emr_route + "/" + patient_id;
        },

        getAdmittedPatientEMRData: function(patientData, patientObj) {
            console.log(patientData)
            var patient_id = patientData.patient_id;
            var emr_route = $("#patient_id").attr("data-emr-route");
            window.location = emr_route + "/" + patient_id;
        },

    };


    //searching Work


    $(document).on("click", "#btnSearchcurrentEquiment", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#search-current-equiment").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
