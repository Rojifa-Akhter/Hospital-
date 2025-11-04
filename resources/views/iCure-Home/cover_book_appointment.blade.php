@extends('iCure-Home.includes.cover_master')
@section('cover_content')


    <!-- preloader Start -->
    <div class="preloader-wrap">
        <div class="preloader">
            <img src="{{ asset('coverpage/img/loader.gif') }}" alt="">
            <!-- <span></span><span></span><span></span><span></span> -->
        </div>
    </div>
    <!-- preloader End -->


    <!--Doctor Appointment area start -->
    <div class="doctor_appointment_area" id="appointment">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <div class="section_title_area about_us_section">
                        <h3 class="section_title2">Make Your Appointment</h3>
                        <p class="sub_title">From emergency department care to remote patient monitoring for chronic
                            care management .and access to care from specialists</p>

                        <h4 class="instraction_for_appointment">Complete Three Steps for Your Appointment</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 card shadow-sm m-auto" style="background-color:transparent;">
                    {{-- <form id="msform" method="post" action="{{ route('cover.appointment-store') }}"> --}}

                    {{-- @csrf --}}
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active schedule" id="account"><strong></strong></li>
                        <li id="personal" class="patient"><strong> </strong></li>
                        <li id="payment" class="confirm"><strong> </strong></li>
                    </ul>

                    <?php $auth = !empty(Auth::user()->user_fullname) ? Auth::user()->user_fullname : ''; ?>
                    @if ($auth == '')
                        <fieldset>
                            <div class="form-card mt-5" style="min-height: 560px !important;">
                                <div class="row">
                                    <div class="col-md-5">
                                        @php
                                            $specl_route = route('get-doctors-list-by-specl-for-online');
                                        @endphp
                                        <div class="form-group">
                                            <label class="text-success form_label"> Select Specialization </label>
                                            <select class="form-control shadow-sm" id="doctor_speciality">
                                                <option value="">Select Specialization</option>
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

                                        <div class="form-group">
                                            <label class="text-success form_label">Select Country</label>
                                            <select class="form-control shadow-sm" id="country_name">
                                                <option value="">Select Country Name</option>
                                                @if (!empty($country_name))
                                                    @foreach ($country_name as $pk => $country)
                                                        <option value="{{ $pk }}">{{ $country }}</option>
                                                    @endforeach
                                                @endif
                                            </select>


                                        </div>

                                        {{-- <div class="form-group"> --}}
                                        {{-- <label class="text-success form_label">Available Date</label> --}}
                                        {{-- <input type="date" class="form-control shadow-sm" id="apointment_date" name="apointment_date" value="" placeholder="Enter Schedule Date" /> --}}
                                        {{-- </div> --}}

                                        {{-- <div class="form-group"> --}}
                                        {{-- <label class="text-success form_label">Available Time</label> --}}
                                        {{-- <input type="time" class="form-control shadow-sm" placeholder="--:--:--" /> --}}
                                        {{-- </div> --}}

                                        <div class="form-group">
                                            <label class="text-success form_label">Available Status</label>
                                            <select class="form-control shadow-sm" id="available_status"
                                                name="available_status">
                                                <option value=""> Select Appointment Status</option>
                                                <option value="1"> Available</option>
                                                <option value="2"> Unavailable</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-success form_label"> Appointment Mode </label>
                                            <select class="form-control shadow-sm " id="available_type"
                                                name="available_type">
                                                <option value=""> Select Appointment Type</option>
                                                <option value="1"> Online</option>
                                                <option value="2"> Offline</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-7" style="height:588px;overflow-x: hidden;overflow-y: scroll;">
                                        <span class="form_title text-success pb-3 doctor_list">List Of available doctors
                                            according to your department and required day</span>

                                        @if (!empty($doctor_list))
                                            @foreach ($doctor_list as $doctor_row)
                                                <div class="doctor_list custom-card" id="doctor_list">
                                                    <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                                        <div class="doctor_img">
                                                            @if ($doctor_row->photo_name != '')
                                                                <img src="{{ asset('images/uploads/patient_images/thumb/' . $doctor_row->photo_name) }}"
                                                                    width="150px" />

                                                            @else
                                                                <img src="{{ asset('coverpage/./img/doctor-1.jpg') }}"
                                                                    width="150px" />
                                                            @endif
                                                        </div>

                                                        <div
                                                            class="info_select w-100 d-flex flex-row justify-content-between">

                                                            <div class="doctor_info open-modal"
                                                                data-modal="common-modal-sm">
                                                                <h4><span
                                                                        id="doctor_full_name">{{ !empty($doctor_row->full_name) ? $doctor_row->full_name : '' }}</span>
                                                                </h4>
                                                                <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                                                <p><span class="ava_id" id="ava_id">Available Date:
                                                                        {{ !empty($doctor_row->schedule_dt) ? date('d/m/Y', strtotime($doctor_row->schedule_dt)) : 'N/A' }}</span>
                                                                </p>
                                                                <p><span class="time">Available Time:</span>
                                                                    {{ !empty($doctor_row->start_time) ? date('h:m:s', strtotime($doctor_row->start_time)) : 'N/A' }}
                                                                </p>
                                                                <p><span class="fee">Doctor Fee:</span>
                                                                    {{ !empty($doctor_row->doctor_fee) ? $doctor_row->doctor_fee : 0 }}
                                                                </p>
                                                                <p><i class="fas fa-map-marker-alt medical"></i>
                                                                    Dhaka Medical</p>
                                                            </div>

                                                            <div class="doctor_select_btn">
                                                                {{-- <span class="badge badge-sm badge-success cursor-pointer doctor_select p-1" data-doc-id="{{ $doctor_row->person_no_pk }}"><i class="fa fa-calendar"></i> Book Appointment</span> --}}

                                                                <button class="btn btn-success btn-sm doctor_select"
                                                                    id="doctor_select"
                                                                    data-doc-id="{{ $doctor_row->person_no_pk }}">
                                                                    Select
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                    </div>

                                </div>
                            </div>
                            {{-- <button class="btn btn-theme2 font-size-12" data-toggle="modal" data-target="#bookAppointment"  >Book Appointment</button> --}}
                            {{-- <button type="button" name="next" class="next action-button" data-toggle="modal" data-target="#bookAppointment">Next</button> --}}
                            <button type="button" name="next" class="next action-button">Next</button>
                            <input type="hidden" name="hdn_schedule_date" id="hdn_schedule_date" value="">
                        </fieldset>
                    @endif


                    <!-- fieldsets -->

                    @include('iCure-Home.cover_appointment_form')
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Meet With Our Expert  Doctor area end -->

    <!-- contact section area start -->
    <div class="contact_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-center">
                    <div class="contactimg_section">
                        <img src="{{ asset('coverpage/img/contact.png') }}" />
                        <div class="card shadow p-3 contact-box">
                            <h4 class="py-3">
                                We are here for you!
                            </h4>
                            <p class="">
                                <i class="fas fa-quote-left comment_icon"></i>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat rutrum turpis,
                                sit amet hendrerit metus vulputate id. <i class="fas fa-quote-right comment_icon"></i>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-5 text-center">
                    <div class="contact_section">
                        <h3 class="contact_title">Feel Free to Contact us</h3>
                    </div>
                    <form action="{{ route('cover.contact_us') }}" method="post" id="contact_form">

                        <div class="form">
                            @csrf
                            <div class=" form-group">
                                <input type="text" placeholder="Your Name*" id="c_name" class="form-control"
                                    name="user_name" />
                            </div>
                            <div class=" form-group">
                                <input type="email" placeholder="Your Email*" id="c_email" class="form-control"
                                    name="user_email" />
                            </div>
                            <div class=" form-group">

                                <textarea placeholder="Your Message*" class="form-control text_area" id="c_messag"
                                    name="user_text"></textarea>
                                {{-- <button class="btn btn-theme mt-3">Send</button> --}}
                                @php
                                    $appoint_id = '';
                                    $response_url = route('appointment-card-pat', $appoint_id);
                                    $redirect_url = route('appointments.create');
                                @endphp
                                <button type="submit" class="btn btn-theme mt-3"
                                    data-response_action="{{ $response_url }}"
                                    data-redirect-action="{{ $redirect_url }}"
                                    onclick="contactFunction(this)">Send</button>

                                {{-- <button type="submit"   class="btn btn-signin" >Send</button> --}}

                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!-- contact section area end -->

    <!-- footer area start -->
    <div class="footer_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="emergency_contact shadow">
                        <i class="fas fa-phone-alt"></i>
                        <i class="fas fa-envelope"></i>
                        <div class="form-row align-items-center">
                            <div class="col-md-5">
                                <h4>Emergency call</h4>
                                <p>(866) 710-9709</p>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="emergency_contact_or">or</span>
                            </div>
                            <div class="col-md-5">
                                <h4>24/7 Email Support</h4>
                                <p>mediplus@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="top_footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" />
                            <p class="pt-3 text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam
                                placerat rutrum turpis, sit amet hendrerit metus vulputate id.</p>
                        </div>

                        <div class="col-md-3 footer-links">
                            <h5 class="footer_title">Specialist</h5>
                            <ul>
                                <li><a href="#">Dental</a></li>
                                <li><a href="#">Pediatric</a></li>
                                <li><a href="#">Neurology Management</a></li>
                                <li><a href="#">Orthopaedics</a></li>
                                <li><a href="#">Cardiology</a></li>
                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Links</h5>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Department</a></li>
                                <li><a href="#">Doctors</a></li>

                            </ul>
                        </div>

                        <div class="col-md-3 footer-links ">
                            <h5 class="footer_title">Contact</h5>
                            <div class="py-2">
                                <span> <i class="fas fa-map-marker-alt pr-1 "> </i>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                            </div>
                            <div class="py-2">
                                <span> <i class="fas fa-phone-alt pr-1"></i>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            </div>
                            <div class="py-2">
                                <span> <i class="fas fa-envelope pr-1"></i>
                                    {{ isset($po_hospital_details->email) ? $po_hospital_details->email : '' }}</span>
                            </div>
                            <div class="footer_spcial py-2">
                                <a href=""> <i class="fab fa-facebook-f"></i></a>
                                <a href=""> <i class="fab fa-linkedin-in"></i></a>
                                <a href=""> <i class="fab fa-twitter"></i></a>
                                <a href=""> <i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <span>Copyright <i class="far fa-copyright"></i> 2021 by Mcare. All Rights Reserved </span>
            </div>
        </footer>
    </div>
    <!-- footer  area end -->



    <!-- Appointment Modal -->
    <div class="modal fade" id="bookAppointment" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                <div class="modal-body">

                    <!-- Sign-in start -->


                    @include('iCure-Home.sign_in_popup')
                    <!-- sign-in end -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-success">Sign In</button> -->
                </div>
            </div>
        </div>
    </div>

@endsection


@push('custom_js')
    <script>
        $(document).ready(function() {
            $('body').on('change', '.available_type', function() {
                let avv_data = $(this).val()
                if (avv_data === "others") {
                    $('.optional_data').removeClass('d-none');
                } else {
                    $('.optional_data').addClass('d-none');
                }
            })
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
                    $('.doctor_list').html('');
                    $('.ava_id').html('');
                },
                success: function(data) {
                    // $('#doctor_list').html(data);
                    var sl_id = 0;
                    Array.from(JSON.parse(data)).forEach(doctor => {

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

                        $("#doctor_list").append(`
                                    <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                        <div class="doctor_img">
                                            <img src="{{ asset('coverpage/./img/doctor-1.jpg') }}" width="150px" />
                                        </div>

                                        <div class="info_select w-100 d-flex flex-row justify-content-between">
                                            <div class="doctor_info">
                                                <h4>` + doctor.full_name + `</h4>
                                                <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                               <p><span class="ava_id" id="ava_id_` + sl_id + `">Available Date:</span></p>
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

                        var myarr = schedule_dt_explode.split(",");

                        myarr.forEach(function(a) {


                            $('#ava_id_' + sl_id).append(
                                '<span class="sched_date" data-doctor_id="' + doctor
                                .person_no_pk + '">' + a + '</span> ,');



                        })
                        sl_id += 1;
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


        // $(document).on("click", "#ava_id", function () {
        //     $date_data = $('#ava_id').val();
        //     $(".custom-card").removeClass("custom-card-active");
        //     $(this).parents('.custom-card').addClass("custom-card-active");
        //     var doctor_id = $(this).attr("data-doc-id");
        //     var appointment_dt = $(".dp-selected").attr("data-moment");
        //     doctor_schedule_info(doctor_id, appointment_dt);
        // });
        $(document).on("click", ".sched_date", function() {
            var date_data = $(this).html();
            var doctor_id = $(this).attr("data-doctor_id");
            $('.sched_date').removeClass('bg-info');
            $(this).addClass('bg-info');
            $("#hdn_schedule_date").val(date_data);

            // $(".custom-card").removeClass("custom-card-active");
            // $(this).parents('.custom-card').addClass("custom-card-active");
            // var doctor_id = $(this).attr("data-doc-id");
            // var appointment_dt = $(".dp-selected").attr("data-moment");
            doctor_schedule_info(doctor_id, date_data);
        });


        $(document).on("click", ".doctor_select", function() {
            $(".custom-card").removeClass("custom-card-active");
            $(this).parents('.custom-card').addClass("custom-card-active");
            var doctor_id = $(this).attr("data-doc-id");
            var appointment_dt = $(".dp-selected").attr("data-moment");
            // doctor_schedule_info(doctor_id, appointment_dt);
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
                    window.location = '{{ url('cover/otp-verify') }}';

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
