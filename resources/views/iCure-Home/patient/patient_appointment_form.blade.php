@extends('iCure-Home.patient.partials.patient_master')

@section('patient_content')

    @push('patient_customcss')
        <style>
            .twitter-typeahead {
                width: 100% !important;
            }

            .tt-menu {
                background: #fff;
                padding: 10px;
            }

        </style>

    @endpush

    <!-- Find doctor start -->
    <div class="find_doctors">
        <div class="container-fluid">
            <div class="form-row">
                <div class="col-md-12 mt-3">
                    <div class="text-center mb-3">
                        <h2 class="">Find the best doctor</h2>
                    </div>
                </div>
            </div>

            <form action="" method="post" id="SearcFormPatient">
                @csrf
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control shadow-sm " name="country">
                                <option value="">Select Country*</option>
                                @if (!empty($country_name))
                                    @foreach ($country_name as $pk => $country)
                                        <option value="{{ $pk }}">{{ $country }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control shadow-sm " name="specialization">
                                <option value="">Select Specialist*</option>
                                @if (!empty($docspl))
                                    @foreach ($docspl as $spe_name)
                                        <option value="{{ $spe_name->specialization_id }}">
                                            {{ $spe_name->specialization_name }}
                                            ({{ $spe_name->no_of_doctor }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {{-- <select class="form-control shadow-sm " name="doctor"> --}}
                            {{-- <option value="">Select Doctor</option> --}}
                            {{-- @if (!empty($doctors)) --}}
                            {{-- @foreach ($doctors as $doc_name) --}}
                            {{-- <option value="{{ $doc_name->person_no_pk }}"> --}}
                            {{-- {{ $doc_name->full_name }} --}}
                            {{-- </option> --}}
                            {{-- @endforeach --}}
                            {{-- @endif --}}
                            {{-- </select> --}}
                            <input type="text" id="primary_doctor" name="primary_doctor" class="form-control shadow-sm "
                                placeholder="Search By Doctor Name" />
                            <input type="hidden" id="doctor_id" name="doctor_id" class="hdn_doctor_id">

                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-theme2 btn-block btn-outline-success" type="button"
                            id="formSearchBtnPatient"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <div class="doctors">
                <div id="doctors_dataPatient">
                    @include('iCure-Home.patient.doctor_list_for_patient')

                </div>
            </div>
        </div>
    </div>
    <!-- Find doctor end -->

@endsection


@push('patient_customjs')
    <script>
        openDoctorAutocomplete('#primary_doctor', 'doctor_id');

        $(document).ready(function() {
            $(document).on("click", "#formSearchBtn", function(e) {
                var formID = $("#SearcForm").attr("id");
                var formMethod = $("#SearcForm").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: "{{ url('get-doctors-by-specialized') }}",
                    type: formMethod,
                    beforeSend: function() {
                        //blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $("#doctors_data").html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });
            });



            $('body').on('change', '.available_type', function() {
                let avv_data = $(this).val()
                if (avv_data === "others") {
                    $('.optional_data').removeClass('d-none');
                } else {
                    $('.optional_data').addClass('d-none');
                }
            })

            $(document).on("click", "#formSearchBtnPatient", function(e) {
                var formID = $("#SearcFormPatient").attr("id");
                var formMethod = $("#SearcFormPatient").attr("method");

                $.ajax({
                    data: $('#' + formID).serialize(),
                    url: "{{ url('get-doctors-by-specialized-patient') }}",
                    type: formMethod,
                    beforeSend: function() {
                        //blockUI();
                    },
                    success: function(data) {
                        console.log(data)
                        $("#doctors_dataPatient").html(data);
                    },
                    complete: function() {
                        // $.unblockUI();
                    }
                });
            });
        });


        $(document).on("change", '#doctor_speciality', function() {
            var specialization_id = $('#doctor_speciality').val();
            var apointment_type_id = $('#available_type').val();
            var available_status_id = $('#available_status').val();
            var appoint_dt = $('#apointment_date').val();
            var today = ($('#today').is(':checked') ? $('#today').val() : "");
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // xhr.setRequestHeader('X-CSRF-Token', getCSRFTokenValue());
            $.ajax({
                url: "{{ route('get-doctors-list-by-specialized') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    available_status_id: available_status_id,
                    apointment_type_id: apointment_type_id,
                    // CSRF: getCSRFTokenValue()
                },
                type: "post",
                beforeSend: function() {
                    $("#data-table").DataTable().destroy();
                    // blockUI();
                    $('#doctor_list').html('');
                },
                success: function(data) {
                    // $('#doctor_list').html(data);
                    Array.from(JSON.parse(data)).forEach(doctor => {
                        // console.log(doctor)
                        let schedule_dt_explode = doctor.schedule_dt;
                        let doctor_fee = 0;
                        let start_time = "N/A";
                        if (doctor.doctor_fee == null) {
                            doctor_fee = 0;
                        } else {
                            doctor_fee = doctor.doctor_fee
                        }
                        if (doctor.start_time == null) {
                            start_time = "N/A";
                        } else {
                            start_time = doctor.start_time
                        }
                        var myarr = schedule_dt_explode.split(",");
                        myarr.forEach(async function(a) {
                            $('.ava_id').html(
                                '<p><span class="ava_id" id="ava_id">Available Date: ' +
                                a + ',</span></p>');
                        })

                        $("#doctor_list").append(`
                                    <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                        <div class="doctor_img">
                                            <img src="{{ asset('coverpage/./img/doctor-1.jpg') }}" width="150px" />
                                        </div>

                                        <div class="info_select w-100 d-flex flex-row justify-content-between">
                                            <div class="doctor_info">
                                                <h4>` + doctor.full_name + `</h4>
                                                <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                               <p><span class="ava_id" id="ava_id">Available Date:</span></p>
                                               <p><span class="time">Available Time:</span>` + start_time + `</p>
                                               <p><span class="fee">Doctor Fee:</span>` + doctor_fee + `</p>
                                               <p><i class="fas fa-map-marker-alt medical"></i> Dhaka Medical</p>
                                            </div>

                                            <div class="doctor_select_btn">
                                                <button class="btn btn-success btn-sm">Select</button>
                                            </div>
                                        </div>
                                    </div>
                            `)
                    })
                },
                complete: function(data) {
                    // $.unblockUI();
                    $("#data-table").DataTable({
                        "ordering": false,
                        // "bPaginate": false
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                }

            });
        });

        // For Date Search

        {{-- $(document).on("change", '#apointment_date', function() { --}}
        {{-- var specialization_id = $('#doctor_speciality').val(); --}}
        {{-- var apointment_type_id = $('#available_type').val(); --}}
        {{-- var available_status_id = $('#available_status').val(); --}}
        {{-- var appoint_dt = $('#apointment_date').val(); --}}
        {{-- var today = ($('#today').is(':checked') ? $('#today').val() : ""); --}}
        {{-- var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : ""); --}}

        {{-- $.ajax({ --}}
        {{-- url: "{{ route('get-doctors-list-by-specialized') }}", --}}
        {{-- data: { --}}
        {{-- specialization_id: specialization_id, --}}
        {{-- appoint_dt: appoint_dt, --}}
        {{-- today: today, --}}
        {{-- tomorrow: tomorrow, --}}
        {{-- available_status_id: available_status_id, --}}
        {{-- apointment_type_id: apointment_type_id, --}}
        {{-- }, --}}
        {{-- type: "post", --}}
        {{-- beforeSend: function() { --}}
        {{-- $("#data-table").DataTable().destroy(); --}}
        {{-- // blockUI(); --}}
        {{-- $('#doctor_list').html(''); --}}
        {{-- }, --}}
        {{-- success: function(data) { --}}
        {{-- // $('#doctor_list').html(data); --}}
        {{-- Array.from(JSON.parse(data)).forEach(doctor=>{ --}}
        {{-- console.log(doctor) --}}
        {{-- $("#doctor_list").append(` --}}
        {{-- <div class="card shadow-sm mb-2 d-flex flex-row doctor_card"> --}}
        {{-- <div class="doctor_img"> --}}
        {{-- @if ($doctor_row->photo_name != '') --}}
        {{-- <img src="{{ asset('images/uploads/patient_images/thumb/' . $doctor_row->photo_name) }}" width="150px" /> --}}

        {{-- @else --}}
        {{-- <img src="{{asset('coverpage/./img/doctor-1.jpg')}}" width="150px" /> --}}
        {{-- @endif --}}
        {{-- </div> --}}

        {{-- <div class="info_select w-100 d-flex flex-row justify-content-between"> --}}
        {{-- <div class="doctor_info"> --}}
        {{-- <h4>${doctor.full_name}</h4> --}}
        {{-- <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6> --}}
        {{-- <p><span class="time">Available Time:</span> ${doctor.start_time}</p> --}}
        {{-- <p><span class="fee">Doctor Fee:</span> ${doctor.doctor_fee}</p> --}}
        {{-- <p><i class="fas fa-map-marker-alt medical"></i> Dhaka Medical</p> --}}
        {{-- </div> --}}

        {{-- <div class="doctor_select_btn"> --}}
        {{-- <button class="btn btn-success btn-sm">Select</button> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- `) --}}
        {{-- }) --}}
        {{-- }, --}}
        {{-- complete: function(data) { --}}
        {{-- $.unblockUI(); --}}
        {{-- $("#data-table").DataTable({ --}}
        {{-- "ordering": false, --}}
        {{-- // "bPaginate": false --}}
        {{-- "bLengthChange": false, --}}
        {{-- "bAutoWidth": false --}}
        {{-- }); --}}

        {{-- } --}}

        {{-- }); --}}
        {{-- }); --}}

        // Available Status

        $(document).on("change", '#available_status', function() {
            var specialization_id = $('#doctor_speciality').val();
            var available_status_id = $('#available_status').val();
            var apointment_type_id = $('#available_type').val();
            var appoint_dt = $('#apointment_date').val();
            var today = ($('#today').is(':checked') ? $('#today').val() : "");
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

            $.ajax({
                url: "{{ route('get-doctors-list-by-specialized') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    available_status_id: available_status_id,
                    apointment_type_id: apointment_type_id,
                },
                type: "post",
                beforeSend: function() {
                    $("#data-table").DataTable().destroy();
                    // blockUI();
                    $('#doctor_list').html('');
                },
                success: function(data) {
                    // $('#doctor_list').html(data);
                    Array.from(JSON.parse(data)).forEach(doctor => {
                        // console.log(doctor)
                        let schedule_dt_explode = doctor.schedule_dt;
                        let doctor_fee = 0;
                        let start_time = "N/A";
                        if (doctor.doctor_fee == null) {
                            doctor_fee = 0;
                        } else {
                            doctor_fee = doctor.doctor_fee
                        }
                        if (doctor.start_time == null) {
                            start_time = "N/A";
                        } else {
                            start_time = doctor.start_time
                        }
                        var myarr = schedule_dt_explode.split(",");
                        myarr.forEach(async function(a) {
                            $('.ava_id').html(
                                '<p><span class="ava_id" id="ava_id">Available Date: ' +
                                a + ',</span></p>');
                        })

                        $("#doctor_list").append(`
                                    <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                        <div class="doctor_img">
                                            <img src="{{ asset('coverpage/./img/doctor-1.jpg') }}" width="150px" />
                                        </div>

                                        <div class="info_select w-100 d-flex flex-row justify-content-between">
                                            <div class="doctor_info">
                                                <h4>` + doctor.full_name + `</h4>
                                                <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                               <p><span class="ava_id" id="ava_id">Available Date:</span></p>
                                               <p><span class="time">Available Time:</span>` + start_time + `</p>
                                               <p><span class="fee">Doctor Fee:</span>` + doctor_fee + `</p>
                                               <p><i class="fas fa-map-marker-alt medical"></i> Dhaka Medical</p>
                                            </div>

                                            <div class="doctor_select_btn">
                                                <button class="btn btn-success btn-sm">Select</button>
                                            </div>
                                        </div>
                                    </div>
                            `)
                    })
                },
                complete: function(data) {
                    $.unblockUI();
                    $("#data-table").DataTable({
                        "ordering": false,
                        // "bPaginate": false
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                }

            });
        });

        // Appointment Type

        // Available Status

        $(document).on("change", '#available_status', function() {
            var specialization_id = $('#doctor_speciality').val();
            var available_status_id = $('#available_status').val();
            var apointment_type_id = $('#available_type').val();
            var appoint_dt = $('#apointment_date').val();
            var today = ($('#today').is(':checked') ? $('#today').val() : "");
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");

            $.ajax({
                url: "{{ route('get-doctors-list-by-specialized') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    available_status_id: available_status_id,
                    apointment_type_id: apointment_type_id,
                },
                type: "post",
                beforeSend: function() {
                    $("#data-table").DataTable().destroy();
                    // blockUI();
                    $('#doctor_list').html('');
                },
                success: function(data) {
                    // $('#doctor_list').html(data);
                    Array.from(JSON.parse(data)).forEach(doctor => {
                        // console.log(doctor)
                        let schedule_dt_explode = doctor.schedule_dt;
                        let doctor_fee = 0;
                        let start_time = "N/A";
                        if (doctor.doctor_fee == null) {
                            doctor_fee = 0;
                        } else {
                            doctor_fee = doctor.doctor_fee
                        }
                        if (doctor.start_time == null) {
                            start_time = "N/A";
                        } else {
                            start_time = doctor.start_time
                        }
                        var myarr = schedule_dt_explode.split(",");
                        myarr.forEach(async function(a) {
                            $('.ava_id').html(
                                '<p><span class="ava_id" id="ava_id">Available Date: ' +
                                a + ',</span></p>');
                        })

                        $("#doctor_list").append(`
                                    <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                        <div class="doctor_img">
                                            <img src="{{ asset('coverpage/./img/doctor-1.jpg') }}" width="150px" />
                                        </div>

                                        <div class="info_select w-100 d-flex flex-row justify-content-between">
                                            <div class="doctor_info">
                                                <h4>` + doctor.full_name + `</h4>
                                                <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                               <p><span class="ava_id" id="ava_id">Available Date:</span></p>
                                               <p><span class="time">Available Time:</span>` + start_time + `</p>
                                               <p><span class="fee">Doctor Fee:</span>` + doctor_fee + `</p>
                                               <p><i class="fas fa-map-marker-alt medical"></i> Dhaka Medical</p>
                                            </div>

                                            <div class="doctor_select_btn">
                                                <button class="btn btn-success btn-sm">Select</button>
                                            </div>
                                        </div>
                                    </div>
                            `)
                    })
                },
                complete: function(data) {
                    $.unblockUI();
                    $("#data-table").DataTable({
                        "ordering": false,
                        // "bPaginate": false
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                }

            });


            document.getElementById('ava_id').onclick = changeColor;

            function changeColor() {
                document.body.style.color = "purple";
                return false;
            }
        });


        $(document).on("click", "#ava_id", function() {
            $date_data = $('#ava_id').val();
            $(".custom-card").removeClass("custom-card-active");
            $(this).parents('.custom-card').addClass("custom-card-active");
            var doctor_id = $(this).attr("data-doc-id");
            var appointment_dt = $(".dp-selected").attr("data-moment");
            doctor_schedule_info(doctor_id, appointment_dt);
        });


        $(document).on("click", ".doctor_select", function() {
            $(".custom-card").removeClass("custom-card-active");
            $(this).parents('.custom-card').addClass("custom-card-active");
            var doctor_id = $(this).attr("data-doc-id");
            var appointment_dt = $(".dp-selected").attr("data-moment");
            doctor_schedule_info(doctor_id, appointment_dt);
        });

        function doctor_schedule_info(doctor_id, appointment_dt, is_paginator = 0) {
            var action = '{{ route('get-doctor-appointment-info-online-form-cover') }}';
            $.ajax({
                url: action,
                data: {
                    doctor_id: doctor_id,
                    appointment_dt: appointment_dt
                },
                type: "post",
                beforeSend: function() {

                    if (is_paginator == 0) {
                        $("#hdn_hospital_id").val('');
                        $("#hdn_service_unit").val('');
                        $("#hdn_doctor_id").val('');
                    }
                    $("#hdn_appointment_date").val('');
                    $("#hdn_schedule_id").val('');

                    $("#avg_load").html('0');
                    $("#block_load").html('0');
                    $("#total_appointment").html('0');
                    $("#total_confirmed").html('0');
                    $("#total_billed").html('0');
                    $("#total_cancel").html('0');

                },
                success: function(data) {
                    console.log(data)
                    if (is_paginator == 0) {
                        $("#hdn_hospital_id").val(data.hospital_id);
                        $("#hdn_service_unit").val(data.service_unit_id);
                        $("#hdn_doctor_id").val(doctor_id);
                    }
                    $("#hdn_appointment_date").val(appointment_dt);
                    $("#hdn_schedule_id").val(data.schedule_id);

                    $("#avg_load").html(data.avg_load);
                    $("#block_load").html(data.block_load);

                    $("#total_appointment").html(data.total_appointment);
                    $("#total_confirmed").html(data.total_confirmed);
                    $("#total_billed").html(data.total_billed);
                    $("#total_cancel").html(data.total_cancel);
                    if (data != "" && data.schedule_id != "") {
                        $msg = "<div class='alert alert-success mb-2'>Schedule available</div>";
                    } else {
                        $msg = "<div class='alert alert-danger mb-2'>Schedule not available</div>";
                    }
                    $("#is_available").html($msg);
                },
                complete: function(data) {

                }

            });
        }


        // appointment

        var appFunc = {
            loadFunc: function(thisElement) {
                let name = $('#patient_name').val();
                let pat_appointment_for_app = $('.pat_appointmentfor').val();
                let pat_gender_app = $('.pat_gender').val();
                let pat_years_app = $('.pat_years_app').val();
                let pat_mobile_num = $('.pat_phone').val();
                let pat_email_app = $('.pat_email').val();
                let hdn_appointment_date = $('#hdn_appointment_date').val();

                let pat_relation = $('.pat_relation').val();
                let pat_dateofbirth = $('.pat_dateofbirth').val();
                let pat_details = $('.pat_details').val();

                // doctor
                let doctor_full_name = $('#doc_id').val();
                let doc_specialist = $('#doc_specialist').val();
                let doc_status = $('#doc_status').val();
                let doc_app_mode = $('#doc_app_mode').val();
                let doc_app_time = $('#doc_app_time').val();
                let doc_fee = $('#doc_fee').val();

                // Patient
                $('#pat_name_data').html(name)
                $('.pat_appointment_for_app').html(pat_appointment_for_app)
                $('.pat_gender_app').html(pat_gender_app)
                $('.pat_years_app').html(pat_years_app)
                $('.pat_mobile_num').html(pat_mobile_num)
                $('.pat_email_app').html(pat_email_app)
                $('#app_date').html(hdn_appointment_date)


                // doctor part /


                $('.doctor_time_app').html(doc_app_time)
                $('.doctor_email_app').html(name)
                $('.doctor_fee_app').html(doc_fee)
                $('.doctor_name_app').html(doctor_full_name)
                $('.specialist_data').html(doc_specialist)
            }
        }

        // Book Apointment

        function bookApointment(thisElement) {
            var pw1 = $('.password').val();
            var pw2 = $('.c_password').val();
            if (pw1 != pw2) {
                alert("Passwords did not match");
            }

            event.preventDefault();

            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created Successfully',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    })
                    $('.user_type').val("")
                    $('.full_name').val("")
                    $('.country').val("")
                    $('.license_no').val("")
                    $('.user_email').val("")
                    $('.password').val("")
                    $('.c_password').val("")
                    $.unblockUI();

                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong !',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    })
                    $.unblockUI();
                }
            });

            event.stopImmediatePropagation();
        }
    </script>
@endpush
