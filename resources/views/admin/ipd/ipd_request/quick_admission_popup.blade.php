@php
$ipd_admission = (isset($ipd) && (!empty($ipd))) ? $ipd : [];
$admission_no_pk = ($ipd_admission) ? $ipd_admission->admission_no_pk : '';
$admission_uid = ($ipd_admission) ? $ipd_admission->admission_uid : '';
$admission_date = ($ipd_admission) ? $ipd_admission->admission_date : '';
$primary_doctor_no_fk = ($ipd_admission) ? $ipd_admission->primary_doctor_no_fk : '';
$duty_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->duty_doc_person_no_fk : '';
$initial_bed_no_fk = ($ipd_admission) ? $ipd_admission->initial_bed_no_fk : '';
$curr_bed_no_fk = ($ipd_admission) ? $ipd_admission->curr_bed_no_fk : '';
$old_bed_no_fk = ($ipd_admission) ? $ipd_admission->old_bed_no_fk : '';
$curr_ward_no_fk = ($ipd_admission) ? $ipd_admission->curr_ward_no_fk : '';
$reg_type_no_fk = ($ipd_admission) ? $ipd_admission->reg_type_no_fk : '';
$su_no_fk = ($ipd_admission) ? $ipd_admission->su_no_fk : '';
$prescription_no_fk = ($ipd_admission) ? $ipd_admission->prescription_no_fk : '';
$prescription_uid = ($ipd_admission) ? $ipd_admission->prescription_uid : '';
$appointment_no_fk = ($ipd_admission) ? $ipd_admission->appointment_no_fk : '';
$opd_department_su_no_fk = ($ipd_admission) ? $ipd_admission->opd_department_su_no_fk : '';
$opd_department_name = ($ipd_admission) ? $ipd_admission->opd_department_name : '';
$status = ($ipd_admission) ? $ipd_admission->status : '';
$first_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->first_ref_doc_person_no_fk : '';
$second_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->second_ref_doc_person_no_fk : '';
$ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->ref_doc_person_no_fk : '';
$patient_no_fk = ($ipd_admission) ? $ipd_admission->patient_no_fk : '';
$doctor_name = isset($ipd_admission) && isset($ipd_admission->full_name)? $ipd_admission->full_name : '';


$IpdAdmissionDetails = (isset($IpdAdmissionDetails) && (!empty($IpdAdmissionDetails))) ? $IpdAdmissionDetails : [];
$admission_no_pk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->admission_no_pk : '';
$pat_condition = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_condition : '';
$arrival_mode = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->arrival_mode : '';
$accompanied_by = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->accompanied_by : '';
$cause_of_admission = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->cause_of_admission : '';
$contact_person = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person : '';
$contact_person_mobile = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person_mobile : '';
$contact_relaion = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_relaion : '';
$ward_no_fk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->ward_no_fk : '';
$remarks = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->remarks : '';
$pat_valuable_accessories = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_valuable_accessories : '';

$admission_data = (isset($admission_data) && (!empty($admission_data))) ? $admission_data : [];
$primary_doctor_name = ($admission_data) ? $admission_data->primary_doctor_name : '';
$refrral_doctor_name = ($admission_data) ? $admission_data->refrral_doctor_name : '';
$first_ref_doctor_name = ($admission_data) ? $admission_data->first_ref_doctor_name : '';
$second_ref_doctor_name = ($admission_data) ? $admission_data->second_ref_doctor_name : '';
$patient_name = ($admission_data) ? $admission_data->patient_name : '';
$su_no_fk = ($admission_data) ? $admission_data->new_su_no_fk : '';
@endphp
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_ipd_admission">
    <div class="container-fluid">

        <!-- @if($admission_no_pk == '')
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-6">
                <h5 class="mt-2 mb-0">Ipd New Admission</h5>
                <small>Ipd / Ipd Quick Admission</small>
            </div>
            <div class="col-md-6 text-right">
                <div id="top-action" class="mt-2">
                    <a class="btn btn-outline-primary btn-md" rel="tab" href="{{ route('ipd.ipd-admission') }}"><i class="fa fa-hospital"></i> Admitted Patient List</a>
                </div>
            </div>
        </div>
        @endif -->

        <form id="quick_admission_form" action="{{ route('ipd.store-quick-admission') }}" method="post">
            <input type="hidden" value="{{$admission_no_pk}}" name="admission_no_pk">
            <input type="hidden" value="{{$curr_bed_no_fk}}" name="">
            <input type="hidden" id='bed_id' name="bed_id" value="{{$curr_bed_no_fk}}">
            <input type="hidden" id='' class="keep_me" name="initial_bed_no_fk" value="{{$old_bed_no_fk ? $old_bed_no_fk : $curr_bed_no_fk}}">
            <div class="form-row">
                <div class="col-md-7">
                    <div class="card ml-2">
                        <div class="card-header">
                            <h5>Admission Form</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="form-group form-row border-bottom">
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input " onchange="bedViewer.patientType(this)" type="radio" name="patienttype" id="patient_type1" value="1" checked />
                                        <label class="form-check-label" for="patient_type1">Registered</label>
                                    </div>
                                    <!-- <div class="form-check form-check-inline">
                                        <input class="form-check-input " onchange="bedViewer.patientType(this)" type="radio" name="patienttype" id="patient_type2" value="2" />
                                        <label class="form-check-label" for="patient_type2">Non-Registered</label>
                                    </div> -->
                                </div>
                                <div class="col-md-4">
                                    <div class="registered_patient">
                                        <div class="form-group">
                                            <input type="hidden" class="" id="hdn_patient_id" name="hdn_patient_id" value="{{$patient_info->patient_no_pk}}" />
                                            <!-- <input type="text" class="form-control form-control-sm m-0 mb-0 " id="service_number" name="service_number" value="{{$patient_name}}" placeholder="Patient ID" /> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="registered_patient col-md-12">
                                    <div class="mt-2 pat_data patient_details" id="patient_details">

                                        @include('admin.components.patient_info_min')
                                    </div>
                                </div>
                            </div>

                            {{-- ******************** Non Register ********************************************** --}}
                            <!-- <div class="non_registered_patient d-none mb-3 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fa fa-user"></i>&nbsp; Patient Quick Registration
                                        </h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        @include('admin.patient.patient_quick_registration_form')
                                    </div>
                                </div>
                            </div> -->
                            {{-- *********** non register form end ************** --}}

                            <div class="form-row mt-2">
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="request_department">Department
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm select2" onchange="bedViewer.getWard(this)" id="request_department" name="request_department" required>
                                        <option value="">select department</option>
                                        @if (!empty($requestDepts))
                                        @foreach ($requestDepts as $rd)
                                        <option value="{{ $rd->serviceunit_no_pk }}" {{$rd->serviceunit_no_pk == $su_no_fk ? 'selected' : ''}}>
                                            {{ $rd->serviceunit_name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4" id="ward_container">
                                    @include('admin.ipd.ipd_request.ipd_ward')
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="primary_doctor">Primary
                                        Doctor / Admitted Under <span class="text-danger">*</span></label>
                                    <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                    <input type="text" class="form-control form-control-sm m-0" id="primary_doctor" name="primary_doctor" value="" placeholder="primay doctor" required />
                                </div>


                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="referral_doctor">Referral
                                        Doctor </label>
                                    <input type="hidden" id="ref_doc" name="ref_doc" value="{{$ref_doc_person_no_fk}}" />
                                    <input type="text" class="form-control form-control-sm m-0" id="referral_doctor" name="referral_doctor" value="{{$refrral_doctor_name}}" placeholder="Enter Referral doctor" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="first_ref">First Referral
                                    </label>
                                    <input type="hidden" id="first_ref" name="first_ref" value="{{$first_ref_doc_person_no_fk}}" />
                                    <input type="text" class="form-control form-control-sm m-0" id="first_referral" name="first_referral" value="{{$first_ref_doctor_name}}" placeholder="Enter First Referral" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="second_ref">Second Referral
                                    </label>
                                    <input type="hidden" id="second_ref" name="second_ref" value="{{$second_ref_doc_person_no_fk}}" />
                                    <input type="text" class="form-control form-control-sm m-0" id="second_referral" name="second_referral" value="{{$second_ref_doctor_name}}" placeholder="Second Referral" />
                                </div>



                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="patient_condition">Patient
                                        Condition</label>
                                    <select class="form-control form-control-sm select2" id="patient_condition" name="patient_condition">
                                        <option value="">select patient condition</option>
                                        @if (!empty($patientConditions))
                                        @foreach ($patientConditions as $pk => $patcon)
                                        <option value="{{ $pk }}" {{$pk == $pat_condition ? 'selected' : ''}}>{{ $patcon }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label class="col-form-label col-form-label-sm" for="patient_valuable_accessories">Patient's
                                        Valuable accessories</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="patient_valuable_accessories" name="patient_valuable_accessories" value="{{$pat_valuable_accessories}}" maxlength="50" placeholder="patient's valuable accessories" />
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="arrival_mode">Arrival
                                        Mode</label>
                                    <select class="form-control form-control-sm select2" id="arrival_mode" name="arrival_mode">
                                        <option value="">select arrival mode</option>
                                        @if (!empty($arrivalModes))
                                        @foreach ($arrivalModes as $pk => $am)
                                        <option value="{{ $pk }}" {{$pk == $arrival_mode ? 'selected' : ''}}>{{ $am }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label class="col-form-label col-form-label-sm" for="cause_of_admission">Cause
                                        Of Admission</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="cause_of_admission" name="cause_of_admission" maxlength="50" value="{{$cause_of_admission}}" placeholder="Cause of Admission" />
                                </div>

                                <div class="col-md-8">
                                    <label class="col-form-label col-form-label-sm" for="admission_remarks">Remarks</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_remarks" name="admission_remarks" maxlength="50" value="{{$remarks}}" placeholder="Remarks Here" />
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="external_hospital">External
                                        Hospital</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="external_hospital" name="external_hospital" maxlength="50" value="" placeholder="External hospital Name" />
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="accompanied_Guardian by">Accompanied
                                        By/
                                        Guardian</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="accompanied_Guardian" maxlength="50" name="accompanied_by" value="{{$accompanied_by}}" placeholder="Ex: Billal Mia" />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="relation">Relation</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="relation" maxlength="50" name="relation" value="{{$contact_relaion}}" placeholder="Father/Mother/Sister/Brother..." />
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="phone_number by">Phone
                                        Number</label>
                                    <input type="text" class="form-control form-control-sm m-0 number_only" id="phone_number" name="phone_number" minlength="10" maxlength="15" value="{{$contact_person_mobile}}" placeholder="Ex:017********" />
                                </div>
                            </div>
                            @php $response_action = route('ipd.ipd-request-referred-patient'); @endphp

                            <div class="mt-2 modal-inline">

                                <button type="button" class="btn btn-md btn-success" data-dismiss="modal" onclick="saveIpd(this)">
                                    Save
                                </button>
                                {{-- <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">--}}
                                {{-- Clear--}}
                                {{-- </button>--}}
                                {{-- <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">--}}
                                {{-- Exit--}}
                                {{-- </button>--}}
                                <button type="button" class="btn btn-md btn-info" data-dismiss="modal">Close</button>
                                <a href="{{ route('ipd.ipd-admission') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="Bed_data">
                        <div class="card">
                            <div class="card-header">
                                <h5>Bed Viewer</h5>
                            </div>
                            <div class="card-body" id="Bed_data">
                                @include('admin.ipd.ipd_request.ipd_bed_viewer')
                            </div>
                        </div>
                        <div class="mt-2 bed_data d-none" id="bedAndPatientData">
                            @include('admin.ipd.ipd_request.bed_data_view')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    // $(document).on("change", ".patient_type	", function(e) {
    //     var value = $(this).val();
    //     if (value == 1) {

    //         $('.pat_info').val("");
    //         $("#pat_gender").val("");
    //         $("#pat_blood_group").val(0);
    //         $("#pat_marital_status").val(0);

    //     } else {
    //         $('#service_number').val("");
    //         $('#hdn_patient_id').val("");
    //     }
    // });

    function saveIpd(thisElement) {
        if ($('#bed_id').val() != "") {
            var url = '{{route("ipd.ipd-request-referred-patient")}}'
            btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, url);
        } else {

            alert("Please Select Bed");
            return;
        }
    }
    $('.select2').select2();
    var bedViewer = {
        patientType: function(thisElement) {
            var checkValue = $('input[name=patienttype]:checked').val();
            if (checkValue == "2") {
                $('.non_registered_patient').removeClass("d-none");
                $('.registered_patient').addClass("d-none");
                $("#patient_details").addClass('d-none');
                $('#service_number').val("");
                $('#hdn_patient_id').val("");
            } else {
                $('.registered_patient').removeClass("d-none");
                $('.non_registered_patient').addClass("d-none");
                $('.pat_info').val("");
                $("#pat_gender").val(0);
                $("#pat_blood_group").val(0);
                $("#pat_marital_status").val(0);
            }
        },
        selectPatient: function(item, obj) {
            $("#patient_details").removeClass('d-none');
            var patient_code = item.patient_code;
            $.ajax({
                url: "{{ route('patient-info-json') }}",
                type: 'post',
                data: {
                    patient_code: patient_code
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#patient_name").html(data.patient_name);
                    $("#patient_age").html(data.age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group_txt);
                    $("#patient_ms").html(data.marital_status_txt);
                    $("#phone_number").html(data.contact);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedByWard: function(thisElement) {
            var bed_value = $(thisElement).val();
            var bed_data = $(thisElement).val();


            $.ajax({
                url: "{{ route('ipd.get-bed-by-ward') }}",
                type: 'POST',
                data: {
                    bed_value: bed_value,
                    bed_data: bed_data
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#bed_container").html(data);

                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        filterBed: function(thisElement) {
            var bed_status = $(thisElement).attr("value");
            var ward_id = $("#destination_ward").val();

            //for bed data
            if (bed_status == 1) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 2) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 3) {
                $('#bedAndPatientData').addClass('d-none');
            }
            // alert(bed_value)
            $.ajax({
                url: "{{ route('get_bed_data') }}",
                type: 'GET',
                data: {
                    bed_status: bed_status,
                    ward_id: ward_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedDetails: function(thisElement) {
            var bed_id = $(thisElement).attr("id");
            var bed_status = $(thisElement).attr('data-status');
            if (bed_status == 1) {
                $('#bedAndPatientData').removeClass('d-none');
            } else if (bed_status == 2) {
                alert('This Bed Is Unavailable');
                // $('#bedAndPatientData').removeClass('d-none');
                return;
            } else if (bed_status == 3) {
                alert('This Bed Is Not Ready');
                // $('#bedAndPatientData').removeClass('d-none');
                return;
            }

            $("#bed_id").val(bed_id);
            $.ajax({
                url: "{{ route('ipd.get-patient-bed-info') }}",
                type: 'GET',
                data: {
                    bed_id: bed_id,
                    bed_status: bed_status
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    $("#bedAndPatientData").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getIdforStore: function(thisElement) {
            var bed_id = $('#bed_id').attr("id");
            $.ajax({
                url: "{{ route('ipd.store-quick-admission') }}",
                type: 'POST',
                data: {
                    bed_id: bed_id
                },
                beforeSend: function() {
                    blockUI();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getWard: function(thisElement) {
            var ward_data = $('#request_department').val();
            //alert(ward_data)
            $.ajax({
                url: "{{ route('ipd.get-ward') }}",
                type: 'POST',
                data: {
                    ward_data: ward_data
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ward_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
    };
    openPatientAutocomplete('#service_number', 'patient_name', bedViewer.selectPatient);
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    openDoctorAutocomplete('#referral_doctor', 'ref_doc');
    openDoctorAutocomplete('#first_referral', 'first_ref');
    openDoctorAutocomplete('#second_referral', 'second_ref');
</script>
