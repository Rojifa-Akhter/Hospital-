<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_ipd_admission">
    <div class="container-fluid">
        <form id="quick_admission_form" action="{{ route('ipd.store-quick-admission') }}" method="post">
            <input type="hidden" value="" name="admission_no_pk">
            <input type="hidden" value="" name="">
            <input type="hidden" id='bed_id' name="bed_id" value="{{ $bed_dt[0]->bed_no_pk }}">
            <input type="hidden" id='emer_text_ind' name="emer_text_ind" value="{{ $bed_dt[0]->emergency_daycare_ind_txt }}">


            <input type="hidden" id='ward_id' name="ward_id" value="{{ $bed_dt[0]->ward_no_fk }}">
            <input type="hidden" id='bed_id' name="bed_id" value="{{ $bed_dt[0]->bed_no_pk }}">
            <input type="hidden" id='su_id' name="su_id" value="{{ $bed_dt[0]->su_no_fk }}">
            <input type="hidden" id='{{ $bed_dt[0]->bed_no_pk }}' class="keep_me" name="initial_bed_no_fk"
                value="">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card ml-2">
                        <div class="card-header">
                            <h5>Register Form</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="form-group form-row border-bottom">
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input " onchange="bedViewer.patientType(this)"
                                            type="radio" name="patient_type" id="patient_type1" value="1"
                                            checked />
                                        <label class="form-check-label" for="patient_type1">Registered</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input " onchange="bedViewer.patientType(this)"
                                            type="radio" name="patient_type" id="patient_type2" value="2" />
                                        <label class="form-check-label" for="patient_type2">Non-Registered</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="registered_patient">
                                        <div class="form-group">
                                            <input type="hidden" class="" id="hdn_patient_id"
                                                name="hdn_patient_id" value="" />
                                            <input type="text" class="form-control form-control-sm m-0 mb-0 "
                                                id="service_number" name="service_number" value=""
                                                placeholder="Patient ID" required />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="registered_patient col-md-12">
                                    <div class="mt-2 pat_data patient_details d-none" id="patient_details">
                                        @include('admin.components.patient_info_min')
                                    </div>
                                </div>
                            </div>

                            {{-- ******************** Non Register ********************************************** --}}
                            <div class="non_registered_patient d-none mb-3 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fa fa-user"></i>&nbsp; Patient Quick Registration
                                        </h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        @include('admin.patient.patient_quick_registration_form')
                                    </div>
                                </div>
                            </div>
                            {{-- *********** non register form end ************** --}}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="primary_doctor">Primary
                                        Doctor / Admitted Under <span class="text-danger">*</span></label>
                                    <span class="badge badge-primary cursor-pointer open-modal"
                                        data-modal="common-modal-sm" data-id="1"
                                        data-action="{{ route('doctor.createquickregistration', 1) }}"
                                        data-title="Add new Doctor (Referral)">
                                        +</span>
                                    <input type="hidden" id="hdn_doctor_id" name="doctor_id" value="" />
                                    <input type="text" class="form-control form-control-sm m-0" id="doctor_code"
                                        name="primary_doctor" value="" placeholder="primay doctor" required />
                                </div>


                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="referral_doctor">Referral
                                        Doctor </label>
                                    <input type="hidden" id="ref_doc" name="ref_doc" value="" />
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="referral_doctor" name="referral_doctor" value=""
                                        placeholder="Enter Referral doctor" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="first_ref">First Referral
                                    </label>
                                    <input type="hidden" id="first_ref" name="first_ref" value="" />
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="first_referral" name="first_referral" value=""
                                        placeholder="Enter First Referral" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="second_ref">Second Referral
                                    </label>
                                    <input type="hidden" id="second_ref" name="second_ref" value="" />
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="second_referral" name="second_referral" value=""
                                        placeholder="Second Referral" />
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="patient_condition">Patient
                                        Condition</label>
                                    <select class="form-control form-control-sm select2" id="patient_condition"
                                        name="patient_condition">
                                        <option value="">select patient condition</option>
                                        @if (!empty($patientConditions))
                                            @foreach ($patientConditions as $pk => $patcon)
                                                <option value="{{ $pk }}">
                                                    {{ $patcon }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm"
                                        for="patient_valuable_accessories">Patient's
                                        Valuable accessories</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="patient_valuable_accessories" name="patient_valuable_accessories"
                                        value="" maxlength="50" placeholder="patient's valuable accessories" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="covid_vaccinated">Covid
                                        Vaccination</label>
                                    <select class="form-control form-control-sm select2" id="covid_vaccinated"
                                        name="covid_vaccinated">
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="arrival_mode">Arrival
                                        Mode</label>
                                    <select class="form-control form-control-sm select2" id="arrival_mode"
                                        name="arrival_mode">
                                        <option value="">select arrival mode</option>
                                        @if (!empty($arrivalModes))
                                            @foreach ($arrivalModes as $pk => $am)
                                                <option value="{{ $pk }}">{{ $am }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label class="col-form-label col-form-label-sm" for="cause_of_admission">Cause
                                        Of Admission</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="cause_of_admission" name="cause_of_admission" value=""
                                        placeholder="Cause of Admission" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label class="col-form-label col-form-label-sm"
                                        for="admission_remarks">Remarks</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="admission_remarks" name="admission_remarks" value=""
                                        placeholder="Remarks Here" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="external_hospital">External
                                        Hospital</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="external_hospital" name="external_hospital"
                                        placeholder="External hospital Name" value="" />
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm"
                                        for="accompanied_Guardian by">C/O</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="accompanied_Guardian" name="accompanied_by" placeholder="Ex: Billal Mia"
                                        value="" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="relation">Relation</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="relation"
                                        name="relation" placeholder="Father/Mother/Sister/Brother..."
                                        value="" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="phone_number by">Phone
                                        Number</label>
                                    <input type="text" class="form-control form-control-sm m-0 number_only"
                                        id="contact_number" name="contact_number" minlength="10" maxlength="15"
                                        placeholder="Ex:017********" value="" />
                                </div>
                            </div>
                            {{-- New Requirement From Marina APU(ED)  --}}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="father_name by">Father's
                                        Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="father_name"
                                        name="father_name" placeholder="Father's Name" value="" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm" for="mother_name by">Mother's
                                        Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="mother_name"
                                        name="mother_name" placeholder="Mother's Name" value="" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12">
                                    <label class="col-form-label col-form-label-sm" for="address by">Address</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="address"
                                        name="address" placeholder="Address Name" value="" />
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="pkg_patient_ind">Package
                                        Patient
                                        Ind</label>
                                    <input type="checkbox" class=" m-0 " name="pkg_patient_ind"
                                        id="pkg_patient_ind" value="1" />

                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="ref_from_emr_ind">Ref. from
                                        emr.
                                        Ind </label>
                                    <input type="checkbox" class=" m-0 " name="ref_from_emr_ind"
                                        id="ref_from_emr_ind" value="1" />

                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="ref_from_opd_dept">Ref. from
                                        opd
                                        dept. Ind </label>
                                    <input type="checkbox" class=" m-0 " name="ref_from_opd_dept"
                                        id="ref_from_opd_dept" value="1" />

                                </div>

                            </div>
                            <div class="col-md-12">
                                <label class="" for="ref_from_external">Ref. from external</label>
                                <input type="text" class=" m-0 " name="ref_from_external"
                                    id="ref_from_external" value="" />

                            </div>
                            <div class="col-md-12">
                                <label class="col-form-label col-form-label-sm" for="package_item_no">Package Item
                                    Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="package_item_no"
                                    name="package_item_no" maxlength="50" name="address" value=""
                                    placeholder="Package Item Name" />
                                <input type="hidden" name="package_item_id" id="package_item_id" value="0">
                            </div>

                        </div>
                        @php $response_action = route('ipd.bed-viewer-emergency'); @endphp

                        <div class="mt-2 modal-inline">

                            <button type="button" class="btn btn-md btn-success" onclick="saveIpd(this)">
                                Save
                            </button>
                            <button type="reset" class="btn btn-md btn-info">Reset</button>
                            <a href="{{ route('ipd.bed-viewer-emergency') }}" class="btn btn-danger btn-md" rel="tab"
                                title="Click here to go back to Dashboard">Exit</a>
                        </div>
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
    openItemAutocomplete($("#package_item_no"),
        'GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT', "#package_item_id");
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
        var url = '{{ route('ipd.bed-viewer-emergency') }}'
        btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, url);
    }

    $('.select2').select2();
    var bedViewer = {
        patientType: function(thisElement) {
            var checkValue = $('input[name=patient_type]:checked').val();
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
                    console.log(data);
                    $("#patient_name").html(data.patient_name);
                    $("#patient_age").html(data.age);
                    $("#patient_gender").html(data.gender);
                    $("#patient_bg").html(data.blood_group_txt);
                    $("#patient_ms").html(data.marital_status_txt);
                    $("#phone_number").html(data.contact);
                    $("#hdn_patient_id").val(data.patient_id);
                    $("#accompanied_Guardian").val(data.emergency_contact_name);
                    $("#relation").val(data.emergency_contact_relation);
                    $("#contact_number").val(data.emergency_contact_contact);
                    $("#father_name").val(data.father_name);
                    $("#mother_name").val(data.mother_name);
                    $("#address").val(data.permanent_addr);
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
            var ward_id = $(thisElement).attr("data-ward");
            var su_id = $(thisElement).attr("data-su");
            var bed_status = $(thisElement).attr('data-status');
            if (bed_status == 1) {
                $('#bedAndPatientData').removeClass('d-none');
            } else if (bed_status == 2) {
                alert('This Bed Is Unavailable');
                return;
                // $('#bedAndPatientData').removeClass('d-none');
            } else if (bed_status == 3) {
                alert('This Bed Is Not Ready');
                return;
                // $('#bedAndPatientData').removeClass('d-none');
            }

            $("#bed_id").val(bed_id);
            $("#ward_id").val(ward_id);
            $("#su_id").val(su_id);
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

                    // $('#request_department').val("");
                    $('#request_department').select2({
                        id: '',
                        a_key: 'select department'
                    });

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
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#referral_doctor', 'ref_doc');
    openDoctorAutocomplete('#first_referral', 'first_ref');
    openDoctorAutocomplete('#second_referral', 'second_ref');
    openPatientAreaInfoAutocomplete('#search_data');
</script>
