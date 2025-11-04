@extends('iCure-Home.patient.partials.patient_master')
@push('patient_customcss')
    <!-- Slick slider -->
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('coverpage/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@section('patient_content')

    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            {{-- <h4 class="page-title mb-0">E-Commerce Orders</h4> --}}
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">E-Commerce Orders</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
        </div>
    </div>
    <!--End Page header-->

    <div class="row">
        <div class="col-md-12">




            <form action="" method="post" id="orderFormPatient">
                @csrf

                <input type="hidden" value="{{ Auth::user()->user_no_pk }}" name="user_id" class="user_id">
                <div class="form-row  justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm " for="search_date_from">From Date</label>
                            <input type="text" class="form-control shadow-sm date_picker" id="search_date_from"
                                name="search_date_from" value="" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm " for="search_date_to">To Date</label>
                            <input type="text" class="form-control shadow-sm date_picker" id="search_date_to"
                                name="search_date_to" value="" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <label class="col-form-label col-form-label-sm" for="search_date_to"></label>
                        <button class="btn btn-theme2 btn-block btn-outline-success mt-2" type="button"
                            id="formSearchBtnPatientOrder"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">E-Commerce Orders </h3>
                </div>
                <div class="card-body" id="order_list">

                    @include('iCure-Home.patient.ecommerce_list_data')




                </div>

            </div>






            <!-- Appointment Modal -->
            <div class="modal fade" id="AppBook" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class=" modal-dialog-centered modal-dialog modal-lg">
                    <div class="modal-content">
                        {{-- <div class="modal-header"> --}}
                        {{-- <h5 class="modal-title">Book Appointment</h5> --}}
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                        {{-- <span aria-hidden="true">&times;</span> --}}
                        {{-- </button> --}}
                        {{-- </div> --}}


                        <div class="modal-header">
                            <h6 class="modal-title">Book Appointment</h6>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                    aria-hidden="true">×</span></button>
                        </div>


                        <div class="modal-body" id="appId">

                            <!-- Sign-in start -->
                            @php
                                $patient_id = !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '';
                                $pat_details = \Illuminate\Support\Facades\DB::table('patient_info_vw')
                                    ->where('patient_no_pk', $patient_id)
                                    ->first();
                                $full_name = isset($pat_details->patient_name) ? $pat_details->patient_name : 'N/A';
                                $dob = isset($pat_details->dob) ? date('d-m-Y', strtotime($pat_details->dob)) : 'N/A';
                                $gender_txt = isset($pat_details->gender_txt) ? $pat_details->gender_txt : 'N/A';
                                $gender_id = isset($pat_details->gender) ? $pat_details->gender : 'N/A';
                                $mobile1 = isset($pat_details->mobile1) ? $pat_details->mobile1 : 'n/a';
                                $email = isset($pat_details->email) ? $pat_details->email : 'n/a';

                            @endphp

                            <form id="msform" method="post" action="{{ route('cover.appointment-store') }}">

                                @csrf

                                <div class="row align-items-center">
                                    <div class="col-md-12 text-center">
                                        <div class="section_title_area about_us_section">
                                            <h3 class="section_title2">Make Your Appointment</h3>
                                        </div>
                                    </div>
                                </div>

                                <fieldset>
                                    <input type="hidden" class="keep_me" id="hdn_appointment_date"
                                        name="hdn_appointment_date"
                                        value="{{ !empty($doc_data[0]->schedule_dt) ? $doc_data[0]->schedule_dt : '' }}">
                                    <input type="hidden" class="keep_me" id="hdn_doctor_id" name="hdn_doctor_id"
                                        value="{{ !empty($doc_data[0]->person_no_pk) ? $doc_data[0]->person_no_pk : '' }}">
                                    <input type="hidden" class="keep_me" id="hdn_hospital_id" name="hdn_hospital_id"
                                        value="{{ !empty($doc_data[0]->au_entry_hospital_pk_no) ? $doc_data[0]->au_entry_hospital_pk_no : '' }}">
                                    <input type="hidden" class="keep_me" id="hdn_service_unit"
                                        name="hdn_service_unit"
                                        value="{{ !empty($doc_data[0]->serviceunit_no_fk) ? $doc_data[0]->serviceunit_no_fk : '' }}">
                                    <input type="hidden" class="keep_me" id="hdn_schedule_id" name="hdn_schedule_id"
                                        value="{{ !empty($doc_data[0]->schedule_no_pk) ? $doc_data[0]->schedule_no_pk : '' }}">
                                    <input type="hidden" class="keep_me" id="hdn_patient_id" name="hdn_patient_id"
                                        value="{{ !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '' }}">

                                    <input type="hidden"
                                        value="{{ !empty($doc_data[0]->full_name) ? $doc_data[0]->full_name : '' }}"
                                        id="doc_id">
                                    <input type="hidden"
                                        value="{{ !empty($doc_data[0]->specialization) ? $doc_data[0]->specialization : '' }}"
                                        id="doc_specialist">
                                    <input type="hidden"
                                        value="{{ !empty($doc_data[0]->status) ? 'available' : 'unavailable' }}"
                                        id="doc_status">
                                    <input type="hidden" value="" id="doc_app_mode">
                                    <input type="hidden" value="" id="doc_app_date">
                                    <input type="hidden"
                                        value="{{ !empty($doc_data[0]->schedule_dt) ? date('H:i', strtotime($doc_data[0]->schedule_dt)) : '' }}"
                                        id="doc_app_time">
                                    <input type="hidden"
                                        value="{{ !empty($doc_data[0]->doctor_fee) ? $doc_data[0]->doctor_fee : 0 }}"
                                        id="doc_fee">
                                    <div class="form-card mt-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Patient Name<strong
                                                            class="text-danger">*</strong> </label>
                                                    <input type="text" placeholder="Enter Your Name"
                                                        name="patient_first_name" id="patient_name"
                                                        class="form-control shadow-sm"
                                                        value="{{ !empty(Auth::user()->user_fullname) ? Auth::user()->user_fullname : '' }} " />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Select Gender<strong
                                                            class="text-danger">*</strong> </label>
                                                    <select class="form-control shadow-sm pat_gender"
                                                        name="patient_gender_id">
                                                        <option value="">Select Gender</option>
                                                        @if (!empty($gender))
                                                            @foreach ($gender as $pk => $gen)
                                                                <option value="{{ $pk }}"
                                                                    {{ $pk == $gender_id ? 'selected' : '' }}>
                                                                    {{ $gen }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Appointment For <strong
                                                            class="text-danger">*</strong> </label>
                                                    <select class="form-control shadow-sm available_type pat_appointmentfor"
                                                        name="appointment_person">
                                                        <option value="Self">Self</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Phone Number <strong
                                                            class="text-danger">*</strong> </label>
                                                    <input type="text" placeholder="Enter Your Phone Number"
                                                        class="form-control shadow-sm pat_phone"
                                                        value="{{ $mobile1 }}" name="phone" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 optional_data d-none">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Relation (Optional) </label>
                                                    <input type="text" placeholder="Enter Relationship"
                                                        class="form-control shadow-sm pat_relation" value=""
                                                        name="relationship" />

                                                    {{-- <select class="form-control shadow-sm"> --}}
                                                    {{-- <option>Select Appointment</option> --}}
                                                    {{-- <option>Father</option> --}}
                                                    {{-- <option>Mother</option> --}}
                                                    {{-- </select> --}}
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Email <strong
                                                            class="text-danger">*</strong> </label>
                                                    <input type="email" placeholder="Enter Your Email"
                                                        class="form-control shadow-sm pat_email" name="email"
                                                        value="{{ $email }}" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Date of Birth <strong
                                                            class="text-danger">*</strong> </label>
                                                    <input type="text" id="datepicker" value="{{ $dob }}"
                                                        placeholder="dd/mm/yyyy"
                                                        class="form-control shadow-sm pat_dateofbirth" name="dob" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-sucess form_label"> Disease Details </label>
                                                    <textarea class="form-control shadow-sm pat_details"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" name="next" class="next action-button" id="loadBtnData"
                                        onclick="appFunc.loadFunc(this)">Next
                                    </button>
                                    <button type="button" name="previous" class="previous action-button-previous">
                                        Previous
                                    </button>
                                </fieldset>


                                <fieldset>
                                    <div class="form-card">
                                        <div class="row p-3">


                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h2 class="card-title">Patient & Doctor
                                                            Details</h2>
                                                    </div>
                                                    <div class="card-body">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td><label class="text-sucess confirm_label">Department
                                                                    </label>
                                                                </td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span specialist_data"></span>
                                                                </td>

                                                                <td><label class="text-sucess confirm_label">Patient
                                                                        Name </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span pat_name"
                                                                        id="pat_name_data"></span></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label class="text-sucess confirm_label"> Doctor
                                                                        Name </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span doctor_name_app" id=""></span>
                                                                </td>

                                                                <td><label class="text-sucess confirm_label">
                                                                        Gender </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span pat_gender_app" id=""></span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td><label class="text-sucess confirm_label">
                                                                        Date </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span" id="app_date"> </span>
                                                                </td>

                                                                <td><label class="text-sucess confirm_label"> Mobile
                                                                        Number </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span pat_mobile_num" id="">
                                                                    </span></td>
                                                            </tr>

                                                            <tr>
                                                                <td><label class="text-sucess confirm_label">
                                                                        Time </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span " id="">
                                                                        {{ date('H:i') }} </span></td>

                                                                <td><label class="text-sucess confirm_label">
                                                                        Email </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span pat_email_app" id=""> </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="text-sucess confirm_label">
                                                                        Fee </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span doctor_fee_app" id="">
                                                                    </span></td>

                                                                <td><label class="text-sucess confirm_label"> Disease
                                                                        Details </label></td>
                                                                <td>:</td>
                                                                <td><span class="confirm_span disease_details" id="">
                                                                    </span></td>
                                                            </tr>


                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <button type="button" class="previous action-button reset">Reset</button>
                                    @php
                                        $appoint_id = '';
                                        $response_url = route('appointment-card-pat', $appoint_id);
                                        $redirect_url = route('cover.patient-admin-panel');
                                    @endphp
                                    <button type="button" class="action-button-previous pay"
                                        data-response_action="{{ $response_url }}"
                                        data-riderect_action="{{ $redirect_url }}"
                                        onclick="appointmentEngine.saveAppointmentForPatient(this)">Go for Pay
                                    </button>


                                    {{-- @php --}}
                                    {{-- $response_action = route('cover.doctor-admin-panel'); --}}
                                    {{-- @endphp --}}
                                    {{-- <button type="submit"   class="action-button-previous pay" onclick="payAppointment(this)">Go for Pay</button> --}}
                                    {{-- <button type="button" class="action-button-previous pay" >Go for Pay</button> --}}
                                </fieldset>
                            </form>


                            <!-- sign-in end -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-success">Sign In</button> -->
                        </div>
                    </div>
                </div>
            </div>





            <!-- Appointment Modal -->
            <div class="modal fade" id="ecommerce_status" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" id="ecom_data">

                        @include('iCure-Home.patient.status_details_modal')



                    </div>
                </div>
            </div>


        </div>
    </div>









@endsection

@push('patient_customjs')
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>`


    <script type="text/javascript">
        $(function() {
            $('.date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            $("body").addClass("sidenav-toggled");
        });

        $(document).on("click", "#formSearchBtnPatientOrder", function(e) {
            var formID = $("#orderFormPatient").attr("id");
            var formMethod = $("#orderFormPatient").attr("method");

            $user_id = $('.user_id').val();

            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ route('patient.e-commerce-orders-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#order_list").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


        function ecomStatusDetails(data_id) {
            $.ajax({
                data: {
                    data_id: data_id,
                },
                url: '{{ route('order.details') }}',
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data)


                    $('#ecom_data').html(data)

                    // all value
                    // $('#doctor_full_name').html(data[0].full_name)
                    // $('.doctor_full_name').html(data[0].full_name)
                    // $('#user_name').html(data[0].full_name)
                    // // $('#license').html(data.bmdc_number)
                    // $('#email').html(data[0].email_personal)
                    // $('#pat_email').html(data[0].email_personal)
                    // // $('#laguge').html(data.full_name)
                    // $('#phone').html(data[0].phone_mobile)
                    // $('#pat_mobile').html(data[0].phone_mobile)
                    // $('#pat_c_address').html(data[0].pe_addr1)
                    // $('#expertise').html(data[0].specialization)

                    // // schedule
                    // data[1].forEach(function(sched_date) {
                    //     // var toDate=new Date(sched_date.schedule_dt);
                    //     var start_d = new Date(sched_date.start_time);
                    //     var end_d = new Date(sched_date.end_time);
                    //     var sch_date = new Date(sched_date.schedule_dt);
                    //     var start_time = start_d.toLocaleTimeString().toLowerCase();
                    //     var end_time = end_d.toLocaleTimeString().toLowerCase();
                    //     var schedule_date = new Date(sch_date);
                    //     // var schedule_date = sch_date.toLocaleDateString('en-GB', {timeZone: 'UTC'});

                    //     var dayNames = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',
                    //         'Friday', 'Saturday');
                    //     var currentDate = Math.round(+new Date(sched_date.schedule_dt) / 1000);
                    //     var nData = new Date(sched_date.schedule_dt);
                    //     $('#date_time').append(
                    //         `<tr><th class="left">${schedule_date}</th><th class="bg-success text-white date_day text-left">${dayNames[nData.getDay()]}</th><th class="text-left">${start_time}</th><th class="text-left">${end_time}</th></tr>`
                    //     )
                    //     console.log(sched_date.schedule_dt);
                    // })
                    // $('.sat').html(data[1].schedule_dt)
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    </script>
@endpush
