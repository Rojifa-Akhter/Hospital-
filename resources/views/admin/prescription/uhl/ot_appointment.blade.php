<style>
    .container {
        border-radius: 3px;
        padding: 5px;
        width: 60%;
        margin: 0 auto;
    }

    h2 {
        font-weight: normal;
        font-size: 25px;
    }

    h2:hover {
        cursor: pointer;
    }

    /* Context menu */
    .context-menu {
        display: none;
        z-index: 1;
        position: absolute;
        width: 200px;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }



    .context-menu ul {
        list-style: none;
        padding: 10px 12px;
    }

    .context-menu ul li {
        list-style: none;
        width: 100%;
        cursor: pointer;
        align-items: center;
        border-radius: 5px;
        margin-bottom: 2px;
        padding: 0 5px 0 10px;

    }

    .context-menu ul li:hover {

        background: #ccc;


    }

    .context-menu ul li a {
        text-decoration: none;
        font-size: 14px;
        color: #151222;
        font-weight: 500;

    }

    .context-menu ul li span {
        font-size: 14px;
        color: #151222 !important;
        font-weight: 500;
    }

    .context-menu ul li a:hover {
        text-decoration: none;
    }

    /* Colors */
    .Gainsboro,
    .Orange,
    .Plum {
        width: 15px;
        height: 15px;
        border: 0px solid black;
        display: inline-block;
        margin-right: 5px;
    }

    .Gainsboro {
        background-color: Gainsboro;
    }

    .Orange {
        background-color: Orange;
    }

    .Plum {
        background-color: Plum;
    }

    .table-row {
        position: relative;
    }
</style>
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_calender.css') }}" />
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">



    <section class="appoinment-section">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-4 mb-1">
                            <h5 class="mt-2 mb-0">OT Booking</h5>
                            <small>OT / OT Booking</small>
                        </div>

                        <input type="hidden" value="{{ isset($req_id) ? $req_id : '' }}" id="req_id" name="req_id">
                        <div class="col-md-8 mb-1">
                            @php
                                $info = $patient_details_info;
                            @endphp

                            @if (isset($info) && is_object($info))
                                @php
                                    $badges = [
                                        'Name' => $info->patient_name,
                                        'Admitted' => optional(\Carbon\Carbon::parse($info->admission_date))->format(
                                            'd/m/Y H:i A',
                                        ),
                                        'Ward / Bed' => trim("{$info->ward_name} / {$info->bed_name}"),
                                        'Gender' => $info->gender_txt,
                                        'Department' => $info->admitted_department,
                                        'Diagnosis' => $info->diagnosis,
                                        'Purpose' => $info->purpose_off_reff,
                                        'Confirmed By' => $info->user_name,
                                        'Confirmed At' => optional(
                                            \Carbon\Carbon::parse($info->req_given_date),
                                        )->format('d/m/Y H:i A'),
                                        'Surgeon' => $info->surgen_name,
                                        'Requested At' => optional(\Carbon\Carbon::parse($info->reff_date))->format(
                                            'd/m/Y H:i A',
                                        ),
                                    ];
                                @endphp

                                @foreach ($badges as $label => $value)
                                    @isset($value)
                                        @if (trim((string) $value) !== '')
                                            <span class="badge rounded-pill bg-info text-dark me-1 mb-1">
                                                <strong>{{ $label }}:</strong> {{ $value }}
                                            </span>
                                        @endif
                                    @endisset
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <form action="#">

                <div class="form-row pt-3">
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="calender_body">
                                    <div id="example"></div>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="facility__" class="col-form-label">Facility</label>

                                    <select class="form-control form-control-sm">
                                        @if (!empty($hospital))
                                            @foreach ($hospital as $row)
                                                <option value="{{ $row->hospital_no_pk }}">
                                                    {{ $row->hospital_name }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="room_no" class="col-form-label col-form-label-sm">OT Room No. <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm font_size_12" id="room_no"
                                        name="room_no" onchange="getOTRequsition(1)" required>
                                        <option value="">Select Room</option>
                                        @foreach ($room_data as $data)
                                            <option value="{{ $data->room_no_pk }}">{{ $data->room_name }}
                                                ({{ $data->room_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="serach_clear_btn_box">
                                    <button id="search_btn" type="button"
                                        class="btn btn-info uhl_common_btn search__clear__btn "><i
                                            class="fas fa-search"></i>Search</button>
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="item_box legend_box">
                                    <ul>
                                        <li>
                                            Block
                                            <span class="box box-1"></span>
                                        </li>
                                        <li>
                                            Online Req.
                                            <span class="box box-2"></span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-10" id="page-data">
                        @include('admin.prescription.uhl.ot_slots_list')

                    </div>

                    <div class="col-lg-2">


                    </div>

                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-appointmentdesk" data-toggle="pill"
                                            href="#pills-appointmentdesk" role="tab"
                                            aria-controls="pills-appointment" aria-selected="false">OT Desk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="pills-appointment-tab" data-toggle="pill"
                                            href="#pills-appointment" role="tab" aria-controls="pills-appointment"
                                            onclick="loadContent('APPOINTMENT')" aria-selected="false">Booked</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-breakBlock-tab" data-toggle="pill"
                                            href="#pills-breakBlock" role="tab" aria-controls="pills-breakBlock"
                                            onclick="loadContent('BLOCK')" aria-selected="false">Break And
                                            Block</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-appointmentRequest-tab" data-toggle="pill"
                                            href="#pills-appointmentRequest" role="tab"
                                            onclick="loadContent('REQUISITION')"
                                            aria-controls="pills-appointmentRequest" aria-selected="false">Requisition
                                            Request</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-appointmentMove-tab" data-toggle="pill"
                                            href="#pills-appointmentMove" role="tab"
                                            onclick="loadContent('CANCEL')" aria-controls="pills-appointmentMove"
                                            aria-selected="false">Cancel/Move
                                            Appointment</a>
                                    </li>
                                </ul>

                                <div class="tab-content d-none" id="pills-tabContent">
                                    <div class="tab-pane fade" id="pills-appointment" role="tabpanel"
                                        aria-labelledby="pills-appointment-tab">
                                        2
                                    </div>
                                    <div class="tab-pane fade" id="pills-breakBlock" role="tabpanel"
                                        aria-labelledby="pills-breakBlock-tab">3</div>
                                    <div class="tab-pane fade" id="pills-appointmentRequest" role="tabpanel"
                                        aria-labelledby="pills-appointmentRequest-tab">4</div>
                                    <div class="tab-pane fade" id="pills-appointmentMove" role="tabpanel"
                                        aria-labelledby="pills-appointmentMove-tab">5</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <input type="hidden" id="calender_selected_date" value="{{ date('d m Y') }}">
        </form>

    </section>
    <script src="{{ asset('uhl_assets/js/uhl_calender.js') }}"></script>
    <script src="{{ asset('uhl_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('uhl_assets/js/uhl_style.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

    <script>
        $('.select2').select2();
        $(document).ready(function() {
            $('body').on('click', '.current td', function() {
                //console.log($('.header-label').text() + ' ' + $(this).text());
                $('#calender_selected_date').val($(this).text() + ' ' + $('.header-label').text());
                $('.current td').removeClass('today');
                var specialization_id = $('#doctor_speciality').val();
                // var doctor_list = $('#doctor_list').val();
                var appoint_dt = $('#apointment_date').val();
                var room_no = $('#room_no').val();
                var calender_selected_date = $('#calender_selected_date').val().split(' ');
                //  console.log(calender_selected_date);
                var date = '';
                if (calender_selected_date[0] < 10) {
                    date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                        calender_selected_date[0]);
                } else {
                    date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                        calender_selected_date[0]);
                }

                var today = date;
                var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
                // get_empty_time();
                //alert($('.header-label').text() + ', ' +$('.current  td').text())
                $("#appointment_slot_div").html('');

                var req_id = $('#req_id').val();
                console.log(specialization_id);
                if (specialization_id != 0) {
                    $.ajax({
                        url: "{{ route('ot.ot-appointment-details-info') }}",
                        data: {
                            specialization_id: specialization_id,
                            appoint_dt: appoint_dt,
                            today: today,
                            tomorrow: tomorrow,
                            req_id: req_id,
                            room_no: room_no,
                            type: 1,
                        },
                        type: "post",
                        beforeSend: function() {
                            // $("#data-table").DataTable().destroy();
                            blockUI();
                            $('#page-data').empty();
                        },
                        success: function(data) {
                            $('#page-data').html(data)
                        },
                        complete: function(data) {
                            $.unblockUI();

                            // $("#data-table").DataTable({
                            //     "ordering": false,
                            //     // "bPaginate": false
                            //     "bLengthChange": false,
                            //     "bAutoWidth": false
                            // });

                        }

                    });
                }
            });
        });
        // $(document).on("change", '#doctor_speciality', function() {
        //     var specialization_id = $('#doctor_speciality').val();
        //     var appoint_dt = $('#apointment_date').val();
        //     var calender_selected_date = $('#calender_selected_date').val().split(' ');

        //     var date = '';
        //     if (calender_selected_date[0] < 10) {
        //         date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
        //             calender_selected_date[0]);
        //     } else {
        //         date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
        //             calender_selected_date[0]);
        //     }

        //     var today = date;
        //     var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
        //     // get_empty_time();
        //     //alert($('.header-label').text() + ', ' +$('.current  td').text())
        //     $("#appointment_slot_div").html('');


        //     $.ajax({
        //         url: "{{ route('get-doctors-list-by-specl-date') }}",
        //         data: {
        //             specialization_id: specialization_id,
        //             appoint_dt: appoint_dt,
        //             today: today,
        //             tomorrow: tomorrow,
        //             type: 1,
        //         },
        //         type: "post",
        //         beforeSend: function() {
        //             // $("#data-table").DataTable().destroy();
        //             blockUI();
        //             $('#doctor_list').html('');
        //         },
        //         success: function(data) {
        //             $('#doctor_list').html(data);
        //         },
        //         complete: function(data) {
        //             $.unblockUI();
        //             // $("#data-table").DataTable({
        //             //     "ordering": false,
        //             //     // "bPaginate": false
        //             //     "bLengthChange": false,
        //             //     "bAutoWidth": false
        //             // });

        //         }

        //     });
        // });

        $(document).on("change", '#doctor_speciality', function() {
            var specialization_id = $('#doctor_speciality').val();
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var today = date;
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // get_empty_time();
            //alert($('.header-label').text() + ', ' +$('.current  td').text())
            $("#appointment_slot_div").html('');

            var room_no = $('#room_no').val();

            $.ajax({
                url: "{{ route('ot.ot-appointment-details-info') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    room_no: room_no,
                    tomorrow: tomorrow,
                    type: 1,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data);
                    $.ajax({
                        url: "{{ route('get-doctors-list-by-specl-date') }}",
                        data: {
                            specialization_id: specialization_id,
                            appoint_dt: appoint_dt,
                            today: today,
                            tomorrow: tomorrow,
                            type: 1,
                        },
                        type: "post",
                        beforeSend: function() {
                            $('#page-data').html('');
                        },
                        success: function(data) {
                            $('#page-data').html(data)
                        },
                        complete: function(data) {}

                    });
                },
                complete: function(data) {
                    $.unblockUI();

                    // $("#data-table").DataTable({
                    //     "ordering": false,
                    //     // "bPaginate": false
                    //     "bLengthChange": false,
                    //     "bAutoWidth": false
                    // });

                }

            });
        });
        loadDoctorData()

        function loadDoctorData() {
            var specialization_id = '';
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var req_id = $('#req_id').val();
            var room_no = $('#room_no').val();
            var today = date;
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // get_empty_time();
            //alert($('.header-label').text() + ', ' +$('.current  td').text())
            $("#appointment_slot_div").html('');
            $.ajax({
                url: "{{ route('ot.ot-appointment-details-info') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    req_id: req_id,
                    room_no: room_no,
                    type: 1,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                complete: function(data) {
                    $.unblockUI();

                }

            });

        }

        $(document).on("change", '#doctor_list', function() {
            var specialization_id = $('#doctor_speciality').val();
            var doctor_list = $('#doctor_list').val();
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var room_no = $('#room_no').val();
            var req_id = $('#req_id').val();
            var today = date;
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // get_empty_time();
            //alert($('.header-label').text() + ', ' +$('.current  td').text())
            $("#appointment_slot_div").html('');


            $.ajax({
                url: "{{ route('ot.ot-appointment-details-info') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    room_no: room_no,
                    req_id: req_id,
                    doctor_list: doctor_list,
                    type: 1,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                complete: function(data) {
                    $.unblockUI();

                    // $("#data-table").DataTable({
                    //     "ordering": false,
                    //     // "bPaginate": false
                    //     "bLengthChange": false,
                    //     "bAutoWidth": false
                    // });

                }

            });
        });


        $(document).on("click", '#pills-appointmentdesk', function() {
            var specialization_id = $('#doctor_speciality').val();
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var today = date;
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // get_empty_time();
            //alert($('.header-label').text() + ', ' +$('.current  td').text())
            $("#appointment_slot_div").html('');

            var room_no = $('#room_no').val();

            $.ajax({
                url: "{{ route('ot.ot-appointment-details-info') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    room_no: room_no,
                    tomorrow: tomorrow,
                    type: 1,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                complete: function(data) {
                    $.unblockUI();

                    // $("#data-table").DataTable({
                    //     "ordering": false,
                    //     // "bPaginate": false
                    //     "bLengthChange": false,
                    //     "bAutoWidth": false
                    // });

                }

            });
        });



        $(document).on("click", '#search_btn', function() {
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var room_no = $('#room_no').val();
            var today = date;
            var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            // get_empty_time();
            //alert($('.header-label').text() + ', ' +$('.current  td').text())
            $("#appointment_slot_div").html('');


            $.ajax({
                url: "{{ route('ot.ot-appointment-details-info') }}",
                data: {
                    appoint_dt: appoint_dt,
                    today: today,
                    tomorrow: tomorrow,
                    room_no: room_no,
                    type: 1,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                complete: function(data) {
                    $.unblockUI();

                    // $("#data-table").DataTable({
                    //     "ordering": false,
                    //     // "bPaginate": false
                    //     "bLengthChange": false,
                    //     "bAutoWidth": false
                    // });

                }

            });
        });

        function loadContent(appointment_type) {
            console.log(appointment_type);
            var specialization_id = $('#doctor_speciality').val();
            var appoint_dt = $('#apointment_date').val();
            var calender_selected_date = $('#calender_selected_date').val().split(' ');
            console.log(calender_selected_date);
            var date = '';
            if (calender_selected_date[0] < 10) {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-0' + parseInt(
                    calender_selected_date[0]);
            } else {
                date += calender_selected_date[2] + '-' + calender_selected_date[1] + '-' + parseInt(
                    calender_selected_date[0]);
            }

            var today = date;
            $("#page-data").html('');


            var room_no = $('#room_no').val();
            $.ajax({
                url: "{{ route('uhl.ot-appointment-list') }}",
                data: {
                    specialization_id: specialization_id,
                    appoint_dt: appoint_dt,
                    today: today,
                    room_no: room_no,
                    appointment_type: appointment_type,
                },
                type: "post",
                beforeSend: function() {
                    // $("#data-table").DataTable().destroy();
                    blockUI();
                    $('#page-data').empty();
                },
                success: function(data) {
                    $('#page-data').html(data)
                },
                complete: function(data) {
                    $.unblockUI();
                }

            });
        }
    </script>


</main>
